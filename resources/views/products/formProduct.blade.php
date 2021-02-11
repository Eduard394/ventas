

<div class="content-wrapper">
<head>
    <!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" href="/estilos/css/toastr.css">
</head>
    <br>
    <body>
        <div id="products">
            <div class="row">
        <div class="col-sm-6" id="form">
        <div class="row">
        <div class="col-sm-12">
              <div class="alert alert-primary">
                <h4 align="center">Nuevo producto</h4>
                 <h5></h5>
              </div> 
         </div>       
          @if ($errors->any())
          <div class="col-sm-12">
            <div class="alert alert-primary">
                <h5>Por favor corrige los siguientes errores </h5> Errores :
                <ul class="btn-success" >
                    @foreach($errors->all() as $error)
                        <li><h6>{{ $error }}</h6></li>
                    @endforeach
                </ul>
            </div>       
          </div>
            @endif
            <div class="card-body">
                <div class="col-sm-12">
                <div class="row">
                <div class="col">
                            <label for="name">Nombre:</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Manzana">
                </div>
                <div class="col">
                            <label for="descripcion">Descripción:</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Manzana fruver">
                </div>
                </div>
                </div>
                <div class="col-sm-6">
                            <label for="precio">Precio:</label>
                            <input type="precio" class="form-control" name="precio" id="precio" placeholder="1250">
                </div>
                <br>  
                <div class="col"> 
                <button v-on:click="guardar" class="btn btn-success">Crear producto</button>
                <a href="" class="btn btn-info">Regresar al listado de productos</a>
                </div>
            <br>
            <div class="card-footer bg-transparent border-success"></div>
        </div>    
        </div>
        </div>


        <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-12" >
          <div class="card bg-light" >
          <div class="card-header d-flex p-2">
            <h3 class="card-title p-2 text-morado-white">
              <i class="fa fa-desktop text-info"></i> <h4 align="center" class="text-morado-white">Lista de Productos</h4>
            </h3>              
          </div>
            <br>
                <div  class="col-sm-12">
                  <div class="row">
                  <div class="col-sm-12">
                  <input class="form-control" type="text" id="myInput" onkeyup="search()" placeholder="Buscar">
                  </div>

                  <br>
                    <div class="col-sm-12">
                      <template>
                          <b-table id="table" :fields="fields" :items="datos" >
                            <template slot="name" slot-scope="data">
                              @{{data.item.name}}
                            </template>                      
                          </b-table>
                      </template>
                    </div> 
                  </div>
                  </div>
              </div>
            </div>
        </div>
     </div>
 </div>
</div>

    </body>
</div>

<style type="text/css">  
  h4 { color: #A569BD; }
</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"> </script>
<script src="/estilos/js/bootstrap-vue.js"></script>
<script src="/estilos/js/axios.js"></script>
<script src="/estilos/js/toastr.js"></script>
<script>

new Vue({
      el: '#products',
      mounted: function(){
            this.getData();
        },
      data: {
        fields: [
                        { key: 'name', label: 'Nombre' },
                        { key: 'precio', label: 'Precio' },
                        { key: 'descripcion', label: 'Descripción' },
                        
                      ],
          datos: [],

      },
      methods: {
        guardar : function(){
            name = $('#name').val();
            descripcion = $('#descripcion').val();
            precio = $('#precio').val();
            var url = '/product/save';
                axios.post(url, {
                    name: name,
                    descripcion: descripcion,
                    precio: precio,
                }).then(response => {
                    toastr.success('Nuevo producto registrado');
                    this.getData();
                }).catch(error => {
                    toastr.error('Errores al guardar!!!');
                });      
        },
        getData: function(){            
            url = '/product/list';
             axios.get(url).then(response => {
                    var data = response.data.data
                    let aux2 = [];
                    data.forEach( element => {
                    var aux = { name:element.name, descripcion: element.descripcion, precio: element.precio}
                    aux2.push(aux);
                    });                    
                    this.datos = aux2
                    toastr.success('Productos cargados exitosamente!!');
                }).catch(error => {
                    toastr.error('Errores Cargar!!!');
                });               
           }
      }
        
    });

function search() {
  const filter = document.querySelector('#myInput').value.toUpperCase();
  const trs = document.querySelectorAll('#table tr:not(.header)');
  trs.forEach(tr => tr.style.display = [...tr.children].find(td => td.innerHTML.toUpperCase().includes(filter)) ? '' : 'none');
}

</script>



