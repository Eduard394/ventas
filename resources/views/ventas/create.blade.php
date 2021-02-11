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
                <div class="col-sm-4" id="form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-primary">
                                <h4 align="center">Nuevo venta</h4>
                                <h5></h5>
                            </div>
                        </div>
                        <div class="box-body col-md-12">
                            <form v-on:submit.prevent="addProducto">
                                {{ csrf_field() }}
                                <!--  -->
                                <div class="col-md-12">
                                    <label for="cliente_id">Clientes:</label>
                                    <select name="cliente_id" id="cliente_id" class="col chosen-select">
                                        <option value="{{ old('cliente_id') }}"> Seleccione cliente</option>
                                        @foreach($clientes as $cliente)
                                        <option name="cliente_id" value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="producto_id">Producto:</label>
                                    <select name="producto_id" id="producto_id" class="col chosen-select">
                                        <option value="{{ old('producto_id') }}"> Seleccione producto</option>
                                        @foreach($productos as $producto)
                                        <option name="producto_id" id="{{ $producto->id }}" rel="{{ $producto->precio }}" value="{{ $producto->id }}">{{ $producto->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <button type="submit" class="btn bg-warning">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-8">
                    <div class="col-12">
                        <div class="alert alert-primary">
                            <h4 align="center">Nuevo cliente</h4>
                            <h5></h5>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">producto</th>
                                    <th scope="col">precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in ventas">
                                    <td>@{{item.nombre}}</td>
                                    <td>@{{item.precio}}</td>
                                    <td><button v-on:click="redirect(item)" class="btn btn-info" type="submit"> Detalles</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-12 box-tools pull-right">
                            <p>Precio total : @{{valorTotal}} </p>
                        </div>

                    </div>
                </div>

            </div>
            <br>

            <div class="col-12 ">
                <button class=" btn btn-success" :disabled="boton" type="submit" v-on:click="guardarVentas">Guardar</button>
            </div>
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
        mounted: function() {},
        data: {
            ventas: [],
            nombre: null,
            cedula: null,
            cliente: null,
            producto: null,
            valorTotal: 0,
            boton: true,


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
                }).catch(error => {
                    toastr.error('Errores al guardar!!!');
                });
            },
            redirect: function(id) {
                window.location.href = '/cliente/' + id;
            },
            addProducto: function() {
                this.cliente = $('#cliente_id').val();
                let producto = $('#producto_id').val();
                let cosa = '#' + producto
                let nombre_producto = $(cosa).text();
                let precio = $(cosa).attr("rel")
                console.log(precio)
                let item = {
                    precio: precio,
                    nombre: nombre_producto,
                    id: producto
                }
                cosa = ''
                this.calcularValor(precio)
                this.ventas.push(item)

            },
            guardarVentas: function() {
                console.log(this.ventas)
                let data = {
                    cliente: this.cliente,
                    total: this.valorTotal,
                    ventas: this.ventas
                }

                var url = '/venta/store';
                axios.post(url, {
                    data: data,
                }).then(response => {
                    toastr.success('venta # ' + response.data + ' resgistrada exitosamente');
                    window.location.href = '/venta/lista';
                }).catch(error => {
                    toastr.error('Errores al guardar!!!');
                });
            },
            calcularValor: function(value) {
                valor = Number(value)
                this.valorTotal = this.valorTotal + valor
                this.boton = false
            }
        },

    });

    function search() {
        const filter = document.querySelector('#myInput').value.toUpperCase();
        const trs = document.querySelectorAll('#table tr:not(.header)');
        trs.forEach(tr => tr.style.display = [...tr.children].find(td => td.innerHTML.toUpperCase().includes(filter)) ? '' : 'none');
    }
</script>