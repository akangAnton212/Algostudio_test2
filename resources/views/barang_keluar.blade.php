<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
           
        </style>
    </head>
    <body>
        <div id="app" class="col-lg-12 mt-2 ml-2 mr-5 mb-2">
            <h3>Welcome, {{ Auth::user()->name }} | Halaman Pengeluaran Barang</h3>
            <div class="col-lg-12 mt-2 ml-2 mr-5 mb-2">
                <div class="row">
                    <div class="col-lg-6">
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Nomor Pengeluaran</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" v-model="nomor_pengeluaran">
                            </div>

                            <button
                                type="button"
                                class="btn btn-success"
                                :disabled="items.length > 0 ? false : true"
                                @click="prosesPengeluaran">Submit</button>
                            <button type="button" class="btn btn-danger" @click="batal">Batal</button>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <h5>Detail Pengeluaran Barang</h5>
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Barang</label>
                                <select
                                    @change="selectedItems"
                                    id="exampleFormControlSelect1"
                                    class="form-control"
                                    v-model="itemSelected">
                                    <option value="">Pilih Barang</option>
                                    <option
                                        v-for="(data, index) in itemsList"
                                        :key="index"
                                        :value="data.uid+'|'+data.item_name">
                                        @{{ data.item_name }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Qty</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" v-model="qty">
                            </div>                        
                            <button
                                type="button"
                                class="btn btn-success mb-3"
                                :disabled="itemSelected != '' && qty != '' ? false : true"
                                @click="tambahBarang">Tambahkan Barang</button>
                        </form>
                        
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(data, index) in items"
                                    :key="index">
                                    <td>@{{ index+=1 }}</td>
                                    <td>@{{ data.item_name }}</td>
                                    <td>@{{ data.qty }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" @click="deleteSelectedItem(data.uid)">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </body>
</html>

<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                items:[],
                itemsList:[],
                nomor_pengeluaran:'',
                itemSelected:'',
                qty:0,
            }
        },

        async mounted() {
            await this.getAllItem()
        },

        watch: {

        },

        async created() {

        },

        methods: {

            async prosesPengeluaran(){
                try{
                    let itemUsage = await axios.post('/order/itemUsage', {
                        usage_num: this.nomor_pengeluaran,
                        items: JSON.stringify(this.items)
                    });

                    let response = JSON.parse(JSON.stringify(itemUsage.data))

                    if(response.status === true){
                        this.usage_num = ""
                        this.items = []
                        this.nomor_pengeluaran = ""
                        alert("Input Pengeluaran Barang Success")
                        await this.getAllItem()
                    }else{
                        console.log(response.message)
                    }
                }catch(error){
                   console.log("(prosesPengeluaran) Error => "+ error)
                }
            },

            batal (){
                this.usage_num = ""
                this.items = []
                this.nomor_pengeluaran = ""
                await this.getAllItem()
            },

            selectedItems(){
                
            },

            async tambahBarang(){
                var item = this.itemSelected.split('|');
                let checkItem = this.items.some(el => el.uid === item[0]);
                if(!checkItem){
                    let checkStockItem = await this.checkLastStockItem(item[0]);
                    
                    if(this.qty > checkStockItem){
                        alert(`Stock Terakhir Barang ${item[1]} Adalah ${checkStockItem}..`);
                        this.itemSelected = ""
                        this.qty = 0
                    }else{
                        this.items.push({
                            uid:item[0],
                            item_name: item[1],
                            qty: this.qty
                        });
                        this.itemSelected = ""
                        this.qty = 0
                    }
                }else{
                    alert(`Barang ${item[1]} Sudah Ada...`);
                }
            },

            deleteSelectedItem(uid_item){
                let pos = this.items.findIndex(el => el.uid === uid_item);
                if (pos >= 0){
                    this.items.splice(pos, 1);
                }
            },

            async getAllItem(){
                try{
                    let dataItems = await axios.get('/order/allItems');

                    let response = JSON.parse(JSON.stringify(dataItems.data))

                    if(response.status === true){
                        let data = response.data
                        this.itemsList = data
                    }else{
                        console.log(response.message)
                    }
                }catch(error){
                   console.log("(getAllItem) Error => "+ error)
                }
            },

            async checkLastStockItem(uid_item){
                try{
                    let dataItems = await axios.get('/order/checkLastStock', {
                        params:{
                            uid_item: uid_item
                        }
                    });

                    let response = JSON.parse(JSON.stringify(dataItems.data))

                    return response.data
                }catch(error){
                   console.log("(checkLastStockItem) Error => "+ error)
                }
            },
        }
    })
</script>
