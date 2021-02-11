<div class="content-wrapper">

    <head>
        <!-- CSS only -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="/estilos/css/toastr.css">
    </head>
    <br>

    <body>
        @if(session('success'))
        <div class="col-lg-6 col-6">
            <div class="alert alert-success text-success" align="center" role="alert">
                <h4 align="center">
                    {{session('success')}}
            </div>
        </div>
        @endif
        @if(session('errors'))
        <div class="col-lg-6 col-6">
            <div class="alert alert-danger text-success" align="center" role="alert">
                <h4 align="center">
                    {{session('errors')}}
            </div>
        </div>
        @endif
        <div id="clientes">
            <div class="row">
                <div class="col-8">
                    <div class="col-12">
                        <div class="alert alert-primary">
                            <h4 align="center">Lista de ventas</h4>
                            <h5></h5>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in datos" :key="item.id">
                                    <td>@{{item.cliente}}</td>
                                    <td>@{{item.valor}}</td>
                                    <td>@{{item.fecha}}</td>
                                    <td><button v-on:click="redirect(item.id)" class="btn btn-info" type="submit"> Detalles</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>

        </div>



    </body>
</div>

<style type="text/css">
    h4 {
        color: #A569BD;
    }
</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"> </script>
<script src="/estilos/js/bootstrap-vue.js"></script>
<script src="/estilos/js/axios.js"></script>
<script src="/estilos/js/toastr.js"></script>
<script>
    new Vue({
        el: '#clientes',
        mounted: function() {
            this.getData();
        },
        data: {
            fields: [{
                    key: 'cliente',
                    label: 'Cliente'
                },
                {
                    key: 'valor',
                    label: 'Valor'
                },


            ],
            datos: [],
            nombre: null,
            cedula: null,

        },
        methods: {
            guardar: function() {
                var url = '/cliente/store';
                axios.post(url, {
                    nombre: this.nombre,
                    cedula: this.cedula,
                }).then(response => {
                    toastr.success('Cliente ' + response.data + ' resgistrado exitosamente');
                    this.nombre = '';
                    this.cedula = '';
                    this.getData();
                }).catch(error => {
                    toastr.error('Errores al guardar!!!');
                });
            },
            getData: function() {
                url = '/venta';
                axios.get(url).then(response => {
                    console.log(response.data)
                    var data = response.data
                    let aux2 = [];
                    data.forEach(element => {
                        var aux = {
                            id: element.id,
                            cliente: element.cliente,
                            valor: element.valor,
                            fecha: element.fecha
                        }
                        aux2.push(aux);
                    });
                    this.datos = aux2
                    toastr.success('Ventas cargados exitosamente!!');
                }).catch(error => {
                    toastr.error('Errores Cargar!!!');
                });
            },
            redirect: function(id) {
                window.location.href = '/cliente/' + id;
            }
        }

    });

    function search() {
        const filter = document.querySelector('#myInput').value.toUpperCase();
        const trs = document.querySelectorAll('#table tr:not(.header)');
        trs.forEach(tr => tr.style.display = [...tr.children].find(td => td.innerHTML.toUpperCase().includes(filter)) ? '' : 'none');
    }
</script>