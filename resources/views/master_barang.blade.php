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
            <h3>Welcome, {{ Auth::user()->name }} | Master Barang</h3>
            <div class="row">
                <div class="col-lg-5">
                    <form>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Nama Barang</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" v-model="itemName">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Group</label>
                            <select
                                id="exampleFormControlSelect1"
                                class="form-control"
                                v-model="selectedItemGroup">
                                <option value="">Pilih Item Group</option>
                                <option
                                    v-for="(data, index) in listItemGroup"
                                    :key="index"
                                    :value="data.uid">
                                    @{{ data.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Type</label>
                            <select
                                id="exampleFormControlSelect1"
                                class="form-control"
                                v-model="selectedItemType">
                                <option value="">Pilih Item Type</option>
                                <option
                                    v-for="(data, index) in listItemType"
                                    :key="index"
                                    :value="data.uid">
                                    @{{ data.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Stock</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" v-model="itemStock">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Deskripsi</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="description"></textarea>
                        </div>
                        
                        <button
                            type="button"
                            class="btn btn-success"
                            @click="simpan">Simpan</button>
                        <button type="button" class="btn btn-danger" @click="batalSimpan">Batal</button>
                    </form>
                </div>
                <div class="col-lg-7">
                    <table class="table table-sm mr-3 ml-3">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Group</th>
                                <th scope="col">Type</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">
                                    aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(data, index) in itemsList"
                                :key="index">
                                <td>@{{ index+=1 }}</td>
                                <td>@{{ data.item_name }}</td>
                                <td>@{{ data.group_name }}</td>
                                <td>@{{ data.type_name }}</td>
                                <td>@{{ data.stock }}</td>
                                <td>@{{ data.item_description }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" @click=editItem(data)>Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" @click="deleteItem(data.uid)">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
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
                itemName:'',
                itemStock:0,
                description:'',
                listItemGroup:[],
                selectedItemGroup:'',
                listItemType:[],
                selectedItemType:'',
                itemsList:[],
                uidItem:'',
                enabled: true
            }
        },

        async mounted() {
            await this.getAllComboBox()
            await this.getAllItems()
        },

        watch: {

        },

        async created() {

        },

        methods: {
            NewPage(page){
                window.location.href = page;
            },
            async simpan(){
                try{
                    let saveItem = await axios.post('/item/saveItem', {
                        itemName: this.itemName,
                        itemStock: this.itemStock,
                        description: this.description,
                        itemGroup: this.selectedItemGroup,
                        itemType:this.selectedItemType,
                        uidItem:this.uidItem
                    });

                    let response = JSON.parse(JSON.stringify(saveItem.data))

                    if(response.status === true){
                        this.itemName = ""
                        this.itemStock = ""
                        this.description= ""
                        this.selectedItemGroup = ""
                        this.selectedItemType = ""
                        this.uidItem = ""
                        await this.getAllComboBox()
                        await this.getAllItems()
                        alert("Simpan Data Barang Success")
                    }else{
                        console.log(response.message)
                    }
                }catch(error){
                   console.log("(simpan) Error => "+ error)
                }
            },
            batalSimpan(){

            },

            async deleteItem(uidItem){
                try{
                    let saveItem = await axios.post('/item/deleteItem', {
                        enabled:false,
                        uidItem:uidItem
                    });

                    let response = JSON.parse(JSON.stringify(saveItem.data))

                    if(response.status === true){
                        this.itemName = ""
                        this.itemStock = ""
                        this.description= ""
                        this.selectedItemGroup = ""
                        this.selectedItemType = ""
                        this.uidItem = ""
                        await this.getAllComboBox()
                        await this.getAllItems()
                        alert("Hapus Data Barang Success")
                    }else{
                        console.log(response.message)
                    }
                }catch(error){
                   console.log("(deleteItem) Error => "+ error)
                }
            },

            editItem(item){
                this.itemName = item.item_name
                this.itemStock = item.stock
                this.description= item.item_description
                this.selectedItemGroup = item.uid_item_group
                this.selectedItemType = item.uid_item_type
                this.uidItem = item.uid
            },

            async getAllComboBox(){
                try{
                    let dataComboBox = await axios.get('/item/getAllComboboxItemMaster');

                    let response = JSON.parse(JSON.stringify(dataComboBox.data))

                    if(response.status === true){
                        let data = response.data
                        this.listItemGroup = data.dataGroup
                        this.listItemType = data.dataType
                    }else{
                        console.log(response.message)
                    }
                }catch(error){
                   console.log("(getAllComboBox) Error => "+ error)
                }
            },

            async getAllItems(){
                try{
                    let dataItems = await axios.get('/item/allItems');

                    let response = JSON.parse(JSON.stringify(dataItems.data))

                    if(response.status === true){
                        let data = response.data
                        this.itemsList = data
                    }else{
                        console.log(response.message)
                    }
                }catch(error){
                   console.log("(getAllItems) Error => "+ error)
                }
            }
        }
    })
</script>
