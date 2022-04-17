<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Halaman Penerimaan barang</title>
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
            <h3>Welcome, {{ Auth::user()->name }} | Halaman Penerimaan Barang</h3>
            <div class="col-lg-12 mt-2 ml-2 mr-5 mb-2">
                <div class="row">
                    <div class="col-lg-6">
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Nomor Order</label>
                                <select
                                    @change="detailOrder"
                                    id="exampleFormControlSelect1"
                                    class="form-control"
                                    v-model="orderSelected">
                                    <option value="">Pilih Nomor Order</option>
                                    <option
                                        v-for="(data, index) in listNomorOrder"
                                        :key="index"
                                        :value="data.order_number">
                                        @{{ data.order_number }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Nomor Invoice</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" v-model="invoice_number">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Diorder Oleh</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" v-model="orderBy" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Status</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" v-model="statusOrder" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Catatan Pengiriman</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="delivery_note"></textarea>
                            </div>
                            
                            <button
                                type="button"
                                class="btn btn-success"
                                :disabled="orderSelected != '' ? false : true"
                                @click="terimaBarang">Terima Barang</button>
                            <button type="button" class="btn btn-danger" @click="batalTerima">Batal</button>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <h5>Detail Order</h5>
                        <table class="table table-sm">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(data, index) in detailOrders"
                                        :key="index">
                                        <td>@{{ index+=1 }}</td>
                                        <td>@{{ data.item_name }}</td>
                                        <td>@{{ data.qty }}</td>
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
                listNomorOrder:[],
                orderSelected:'',
                orderBy:'',
                detailOrders:[],
                statusOrder:'',
                uid_order:'',
                invoice_number:'',
                delivery_note:'',
            }
        },

        async mounted() {
            await this.getListNomorOrder()
        },

        watch: {

        },

        async created() {
            
        },

        methods: {
            test(){
                console.log("HAY")
            },
            async getListNomorOrder(){
                try{
                    let dataOrderNumber = await axios.get('/order/allOrderNumber');

                    let response = JSON.parse(JSON.stringify(dataOrderNumber.data))

                    if(response.status === true){
                        let data = response.data
                        this.listNomorOrder = data
                    }else{
                        console.log(response.message)
                    }
                }catch(error){
                   console.log("(getListNomorOrder) Error => "+ error)
                }
            },
            async detailOrder(){
                
                try{
                    let detail = await axios.get('/order/detailOrderByOrderNumber', {
                        params:{
                            orderNumber: this.orderSelected
                        }
                    });

                    let response = JSON.parse(JSON.stringify(detail.data))

                    if(response.status === true){
                        let data = response.data
                        this.orderBy = data.user_order.name
                        this.statusOrder = data.is_received == 0 ? 'Belum Diterima' : 'Sudah Diterima'
                        this.detailOrders = []
                        this.uid_order = data.uid
                        data.order_detail.forEach((value) => {
                            this.detailOrders.push({
                                id:value.id,
                                uid:value.uid,
                                uid_item:value.uid_item,
                                item_name:value.item.item_name,
                                qty:value.qty
                            })
                        });
                    }else{
                        console.log(response.message)
                    }
                }catch(error){
                   console.log("(getListNomorOrder) Error => "+ error)
                }
            },

            async terimaBarang(){
                try{
                    let receiveOrder = await axios.post('/order/receiveOrder', {
                        uid_order: this.uid_order,
                        order_detail: JSON.stringify(this.detailOrders),
                        invoice_number: this.invoice_number,
                        delivery_note: this.delivery_note,
                        order_number:this.orderSelected
                    });

                    let response = JSON.parse(JSON.stringify(receiveOrder.data))

                    if(response.status === true){
                        this.orderBy = ""
                        this.statusOrder = ""
                        this.detailOrders = []
                        this.uid_order = ""
                        this.invoice_number = ""
                        this.delivery_note = ""
                        this.orderSelected = ""
                        await this.getListNomorOrder()
                        alert("Penerimaan Barang Success")
                    }else{
                        console.log(response.message)
                    }
                }catch(error){
                   console.log("(terimaBarang) Error => "+ error)
                }
            },
            async batalTerima(){
                this.orderBy = ""
                this.statusOrder = ""
                this.detailOrders = []
                this.uid_order = ""
                this.invoice_number = ""
                this.delivery_note = ""
                this.orderSelected = ""
                await this.getListNomorOrder()
            }
        }
    })
</script>
