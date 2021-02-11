<head>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="/estilos/css/toastr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
</head>



<br>

<body>
    <div class="col-md-12">
        @if(session('success'))
        <div class="col-lg-6 col-6">
            <div class="alert alert-success text-success" align="center" role="alert">
                <h3 align="center">
                    {{session('success')}}
                </h3><a href="#" class="alert-link"> </a>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="box box-secundary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detalle cliente</h3>
                    </div>
                    <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i> Nombre</strong>
                        <p class="text-muted">
                            {{$cliente->nombre}}
                        </p>
                        <hr>
                        <strong><i class="fa fa-pencil margin-r-5"></i> Convocatoria</strong>
                        <p>
                            <span class="label ">{{$cliente->nombre}}</span>
                        </p>
                        <hr>
                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Fecha de Creación</strong>
                        <p>{{$cliente->created_at}}</p>
                        <form action="{{ route('cliente.destroy', $cliente->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn-danger btn-lg" onclick="return confirm('Esta seguro de eliminar el cliente')"><span class="fa fa-trash"> Eliminar</span></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title text-black">Editar cliente {{$cliente->nombre}}</h3>

                    </div>
                    <div class="box-body col-md-12">
                        <form method="POST" action="{{ route('cliente.update' , $cliente)}}">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="col-md-12">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre',$cliente->nombre) }}">
                            </div>
                            <div class="col-md-12">
                                <label for="cedula">Cedula</label>
                                <input type="text" class="form-control" name="cedula" id="cedula" value="{{ old('cedula',$cliente->cedula) }}">
                            </div>
                            <br>
                            <div class="col-md-12">
                                <button type="submit" class="btn bg-orange">Guardar</button>
                            </div>
                        </form>
                        <div class="card-footer bg-transparent border-secundary">Editar cliente</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <a href="{{ route('cliente') }}" class="btn btn-success text-white">Regresar al listado de clientes</a>
            </div>

        </div>
    </div>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>