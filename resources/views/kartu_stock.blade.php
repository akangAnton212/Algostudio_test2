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
            <h3>Welcome, {{ Auth::user()->name }} | Halaman Kartu Stock</h3>
            <div class="col-lg-12 mb-3 mt-3">
                <div class="row">
                <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Tanggal Awal</label>
                                <input type="date" class="form-control" id="exampleFormControlInput1x" v-model=tglAwal>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="exampleFormControlInput1xy" v-model=tglAkhir>
                            </div>
                        </div>
                        <div class="col-lg-3">
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
                                        :value="data.uid">
                                        @{{ data.item_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-primary mt-4" @click="cariStock">Cari..</button>
                            <button type="button" class="btn btn-danger mt-4" @click="batalSearch">Batal..</button>
                        </div>
                    
                </div>
            </div>
            <div class="row">
                <table class="table table-sm mr-3 ml-3">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Type Transaksi</th>
                        <th scope="col">Tanggal Transaksi</th>
                        <th scope="col">Stock Awal</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Stock Akhir</th>
                        <th scope="col">Nomor Referensi</th>
                        <th scope="col">Informasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(data, index) in stockCardList"
                            :key="index">
                            <td>@{{ index+=1 }}</td>
                            <td>@{{ data.item_name }}</td>
                            <td>@{{ data.trans_type }}</td>
                            <td>@{{ data.trans_date }}</td>
                            <td>@{{ data.initial_balance }}</td>
                            <td>@{{ data.qty }}</td>
                            <td>@{{ data.final_balance }}</td>
                            <td>@{{ data.ref_number }}</td>
                            <td>@{{ data.information }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                stockCardList:[],
                itemSelected:'',
                itemsList:[],
                tglAwal:'',
                tglAkhir:'',
            }
        },

        async mounted() {
            await this.getAllItem()
            await this.getStockCard()
        },

        watch: {

        },

        async created() {

        },

        methods: {
            selectedItems(){

            },

            async batalSearch(){
                this.tglAwal = ""
                this.tglAkhir = ""
                this.itemSelected = ""
                await this.getStockCard()
            },

            async cariStock(){
                await this.getStockCard()
            },

            async getStockCard(){
                try{
                    let stockCard = await axios.get('/stockCard', {
                        params:{
                            tglAwal: this.tglAwal,
                            tglAkhir: this.tglAkhir,
                            itemSelected: this.itemSelected
                        }
                    })

                    let response = JSON.parse(JSON.stringify(stockCard.data))

                    if(response.status === true){
                        let data = response.data
                        this.stockCardList = []
                        this.stockCardList = data
                    }else{
                        console.log(response.message)
                    }
                }catch(error){
                   console.log("(getAllItem) Error => "+ error)
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
        }
    })
</script>
