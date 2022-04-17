<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Halaman Utama</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            .square-box{
                position: relative;
                width: 100%;
                overflow: hidden;
                background: #4679BD;
            }
            .square-box:before{
                content: "";
                display: block;
                padding-top: 100%;
            }
            .square-content{
                position:  absolute;
                margin-top:70px;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                color: white;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div id="app" class="col-lg-12 mt-2 ml-2 mr-5 mb-2">
            <h5>Welcome, {{ Auth::user()->name }} | Halaman Utama</h5>
            <div class="col-lg-12 mt-2 ml-2 mr-5 mb-2">
                <div class="row">
                    <div
                        v-for="(data, index) in listMenu"
                        :key="index"
                        class="col-lg-2">
                        <div
                            class='square-box'
                            @click="NewPage(data.link)">
                            <div class='square-content'>
                                <span>@{{ data.menu }}</span>
                            </div>
                        </div>
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
                listMenu:[
                    {
                        'menu':'Barang Masuk',
                        'link':'barang_masuk'
                    },
                    {
                        'menu':'Barang Keluar',
                        'link':'/barang_keluar'
                    },
                    {
                        'menu':'Kartu Stock',
                        'link':'/kartu_stock'
                    },
                    {
                        'menu':'Master Barang',
                        'link':'/master_barang'
                    },
                ],
                userLogin:'',
            }
        },

        async mounted() {
        },

        watch: {

        },

        async created() {

        },

        methods: {
            NewPage(page){
                window.location.href = page;
            }
        }
    })
</script>
