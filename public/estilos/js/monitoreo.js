

  Vue.component('alert-card',{
  props : [ 'evento','vehiculo','hora', 'fecha', 'codigo'],
  template :  `
  <div v-if="codigo =='06'">
  <div class="barraLateral__alerta alerta_robo">
     <div >
        <span class="barraLateral__alertaCirculo" style="background-color: #f80603;"></span>
        <span class="barraLateral__alertaCodigo v.bind">{{vehiculo}}</span>
        <span class="barraLateral__alertaDescripcion">{{evento}}: {{hora}}</span>

     </div>
  </div>
  </div>

  <div v-else-if="codigo =='04'">
  <div class="barraLateral__alerta alerta_bloqueo">
     <div >
        <span class="barraLateral__alertaCirculo"></span>
        <span class="barraLateral__alertaCodigo v.bind">{{vehiculo}}</span>
        <span class="barraLateral__alertaDescripcion">{{evento}}: {{hora}}</span>

     </div>
  </div>
  </div>

  <div v-else-if="codigo =='05'">
  <div class="barraLateral__alerta alerta_exceso">
     <div >
        <span class="barraLateral__alertaCirculo"></span>
        <span class="barraLateral__alertaCodigo v.bind">{{vehiculo}}</span>
        <span class="barraLateral__alertaDescripcion">{{evento}}: {{hora}}</span>

     </div>
  </div>
  </div>

  <div v-else>
  <div class="barraLateral__alerta alerta_abandono">
     <div >
        <span class="barraLateral__alertaCirculo"style="background-color: #0ff901;"></span>
        <span class="barraLateral__alertaCodigo v.bind">{{vehiculo}}</span>
        <span class="barraLateral__alertaDescripcion">{{evento}}: {{hora}}</span>

     </div>
  </div>
  </div>
  `
  });
    var url= '/controlv2/alerts';
    let total = new Array();
    
    new Vue({
      el: '#main',
      created: function() {
        this.getAlerts();
        this.setAlert();
        this.timer = setInterval(this.resetAlerts, 2000)
        this.timer = setInterval(this.setAlert, this.tempo)
        
      },
      data: {
          alerts: [],
          counter: 0,
          timer: '',
          tempo: 5000,
          nombre: 'main Alertas'
      },
      methods: {
        getAlerts: function(){
          this.$http.get(url).then(function(response){
            var data = response.data;
            if(data.status == true){
              data = data.data;
              data.forEach(element => {
                     if(element.EVE_GPS_CODIGO == '06'){
                        var aux = { evento: 'Pánico', vehiculo: element.EQU_CODIGO, hora: element.HORA_GPS, fecha: element.FECHA_GPS, codigo: element.EVE_GPS_CODIGO  }
                     }else if(element.EVE_GPS_CODIGO == '04'){
                        var aux = {evento: 'Exceso de velocidad', vehiculo: element.EQU_CODIGO, hora: element.HORA_GPS, fecha: element.FECHA_GPS, codigo: element.EVE_GPS_CODIGO   }
                     }else if(element.EVE_GPS_CODIGO == '01'){
                        var aux = {evento: 'Encendido', vehiculo: element.EQU_CODIGO, hora: element.HORA_GPS, fecha: element.FECHA_GPS, codigo: element.EVE_GPS_CODIGO   }
                     }else{
                        var aux = {evento: 'Apagado', vehiculo: element.EQU_CODIGO, hora: element.HORA_GPS, fecha: element.FECHA_GPS, codigo: element.EVE_GPS_CODIGO   }
                     }
                     total.push(aux)                     
                }); 
            }
          });
          this.alerts = total;
          total = [];
        },
        resetAlerts:  function(){
          this.alerts = [];
          this.getAlerts();
        },
        setAlert: function(){

          var url = '/controlv2/alerts';
                    axios.get(url).then(response => {
                    data = response.data
                    var hoy = new Date();
                    hoy = (Date.parse(hoy)/1000);
                    if(data.status){
                    data.data.forEach(element => {
                      var aux = element.FECHA_GPS + ':' + element.HORA_GPS
                      var datum = Date.parse(aux)/1000;
                      if((hoy-datum) <= 50){
                        if(element.EVE_GPS_CODIGO == '06'){
                            toastr.error('Alerta de pánico ' + element.EQU_CODIGO + ': ' + element.HORA_GPS );
                          }else if(element.EVE_GPS_CODIGO == '04'){
                            toastr.morado('Alerta exceso de velocidad ' + element.EQU_CODIGO + ': ' + element.HORA_GPS );
                          }else if(element.EVE_GPS_CODIGO == '01'){
                            toastr.success('Encendido: ' + element.EQU_CODIGO + ': ' + element.HORA_GPS );
                          } else{
                            toastr.warning('Apagado : ' + element.EQU_CODIGO + ': ' + element.HORA_GPS );
                          }
                      }
                  });
                  }
                });   
        },
        deactivateAlert: function(){
          this.tempo = 1;

        }
      },
      template: 
      `
      <div class="barraLateral__acordeonContenido">
      <alert-card 
          v-for="(alert, index) in alerts"
            :key="index"
            :evento="alert.evento"              
            :vehiculo="alert.vehiculo"
            :codigo="alert.codigo"
            :hora="alert.hora"
            :fecha="alert.fecha">
        </alert-card>  
        </div>`
        
    });

 /// elementos para la carga de la lista de vehiculos
  Vue.component('select-card',{
  props : [ 'vehicle'],
  template :  `
     <option>{{vehicle}}</option>
  `
  });

    let aux = new Array();
    var vehicleComponent =   new Vue({
      el: '#vehiclesRoutes',
      created: function(){
        this.getVehicles();
        this.simular();
       // this.getId();
      },
      mounted(){
       // this.getVehicles();

        
      },
      data: { 
        vehicles: [],
        items:   [],
        showInMap: [],
        nombre : 'vehiclesRoutes'
      },
      methods: {
        getVehicles: function(){
          var url = '/controlv2/getvehicles';
          this.$http.get(url).then(function(response){
            var data = response.data;
            if(data.status == true){
              data.data.forEach(element => {
                aux.push(element.VEH_CODIGO);                   
                });
            }
          });
          this.vehicles = aux;
          setTimeout(function(){
            $('#select_id').trigger("chosen:updated");
            },1000)
        },
        getId: function(){
          var veh = document.getElementById("select_id").value;
          loadData({Display: veh},'/controlv2/inforutaveh','POST','json',this.cargar);

        },
        cargar: function(data){
            var cod = document.getElementById("select_id").value;
            var relDiv = cod.replace(/ /g, "");
            if(data['PROG'] == null){
              let r = Math.random().toString(36).substring(7);
              var veh = {equ_codigo: cod, ruta:'Sin programaciòn', horaInicio: '', HoraFin: '', tipo: 1, relDiv: r};
              this.items.push(veh);
              this.showInMap.push(cod)
            }else{
              var veh = {equ_codigo: cod, ruta: data.PROG.RUTA, horaInicio: data.PROG.HORA_INI, HoraFin: data.PROG.HORA_FIN, tipo: data.VEH[0].tipo_equipo, relDiv: relDiv};
              this.items.push(veh);
              this.showInMap.push(cod)

            }
            
            
          },
          simular: function(){
            this.showInMap.push(vehicle)
          }
      },
      template: 
      `
      <div class="monitoreo__filtroCampo">
      <select id="select_id" class="chosen">
      <select-card 
          v-for="(element, index) in vehicles"
            :key="index"
            :vehicle="element">
        </select-card> 
        </select>
        <div class="blFiltro barraLateral__filtroResultados">
           <button v-on:click="getId()" >Agregar</button>
        </div>
        </div>`
    });


  Vue.component('info-card',{
  props : [ 'vehicleItem'],
  template :  `
  <div v-if="vehicleItem.tipo =='1'">
  <div class="resultadoVehiculo vehiculo--encendido" v-bind:id="vehicleItem.relDiv">
    <div class="resultadoVehiculo__encabezado" >
       <h3 class="resultadoVehiculo__titulo"><img class="icono"
             src="/CONTROL/plantilla_nueva/img/busMapa-encendido.svg" alt="Vehículo apagado con señal"> {{vehicleItem.equ_codigo}}: ruta {{vehicleItem.ruta}}
              </h3>
              <h5><a> Inicio: {{vehicleItem.horaInicio}} </a> </h5>
              <h5><a> Fin: {{vehicleItem.HoraFin}} </a> </h5>
       <button onclick="resetVehiclesComponents()" class="resultado__eliminar" v-bind:rel="vehicleItem.relDiv" ><i class="ib-iconos ib-equis"
             alt="Quitar"></i></button>
    </div>
    
  </div>
  </div>
  <div v-else>
  <div class="resultadoVehiculo vehiculo--apagado" v-bind:id="vehicleItem.relDiv">
    <div class="resultadoVehiculo__encabezado" >
       <h3 class="resultadoVehiculo__titulo"><img class="icono"
             src="/CONTROL/plantilla_nueva/img/busMapa-apagado.svg" alt="Vehículo apagado con señal"> {{vehicleItem.equ_codigo}}: ruta {{vehicleItem.ruta}}
              </h3>
              <h5><a> Inicio: {{vehicleItem.horaInicio}} </a> </h5>
              <h5><a> Fin: {{vehicleItem.HoraFin}} </a> </h5>
              
       <button onclick="resetVehiclesComponents()" class="resultado__eliminar" v-bind:rel="vehicleItem.relDiv" ><i class="ib-iconos ib-equis"
             alt="Quitar"></i></button>
    </div>
    
  </div>
  </div>
  `
  });

  // funcion que elimina los items en vehiculos y rutas del multiselect
  $(document).on('click', '.resultado__eliminar', function (){
  var id = $(this).attr('rel');
  $('#' + id).remove();
  return id;
  
}); 

  var hola = new Vue({
      el: '#vehiclesDetalles',
      created: function(){  
        this.getVehicles();
      },
      data: { 
        vehicles: [],
        nombre : 'vehicleDetalles'
      },
      methods: {
        getVehicles: function(){
          this.vehicles = vehicleComponent.$data.items;
        }
      },
        template:
        `<div class="resultadosVehiculo">
          <info-card 
            v-for="(element, index) in vehicles"
              :key="index"
              :vehicleItem="element">
          </info-card>
          <div class="blFiltro barraLateral__filtroResultados">
         <!--  <button  type="hidden"  v-on:click="getVehicles()" >Agregar</button>-->
        </div>
        </div>
        `
    });   



 /// componente de rutas
  Vue.component('select-route-card',{
  props : [ 'route', 'id'],
  template :  `
     <option :value="id"  :data-rel="route" >{{route}}</option>
  `
  });

  let rutas = new Array();
  var rutasComponent =   new Vue({
      el: '#routes',
      created: function(){
        this.getRoutes();
      },
      mounted: function(){
        //this.getRoutes();
      },
      data: { 
        rutas: [],
        vehicles:   [],
        vehiclesShow: [],
        nombre : 'routes'
      },
      methods: {
        getRoutes: function(){
          var url = '/controlv2/getroutes';
          this.$http.get(url).then(function(response){
            var data = response.data;
            if(data){
              data.forEach(element => {
                item = {ruta: element.nombre, id: element.id}       
                rutas.push(item)          
                });
            }
          });
          this.rutas = rutas;
          setTimeout(function(){
            $('#select_id_route').trigger("chosen:updated");
            },1000)
          
        },
        getIdRoute: function(){
          setTimeout(function(){

          })
          $('#select_id_route').trigger("chosen:updated");
          var rutaId = document.getElementById("select_id_route").value;
          var rutaName = $('#select_id_route option:selected').text();
          var send = [rutaName,rutaId]
          console.log('Send dddd', send)
          loadData({RUTA: rutaId},'/controlv2/vehiculoinroute','POST','json',this.cargar,send);

        },
        cargar: function(data,send){
            //this.vehiclesShow = []
            console.log( 'this data to vehicles in route' ,data);
            var rutaName = send[0];
            var rutaId = send[1];
            relRuta = rutaName.replace(/ /g, "");
            if(data.length > 0){
              info = 1
            }else{
              info = 0
            }
            item = {ruta_id: rutaId,ruta: rutaName, relRuta: relRuta, info: info,  data: data}
            this.vehicles.push(item);
            let vehiculosEnRuta = new Array();
            data.forEach(element => {
              
              vehiculosEnRuta.push(element.vehiculo);
             // this.vehiclesShow.push(element.vehiculo)
            });
            aux = {ruta: rutaId, vehiculos: vehiculosEnRuta}
            this.vehiclesShow.push(aux)
           // var iterador = this.vehiclesShow.length-1;
            loadmap(rutaId,rutaId);
        }
      },
      template: 
      `
      <div class="monitoreo__filtroCampo">
      <select id="select_id_route" class="chosen" >
      <select-route-card 
          v-for="(element, index) in rutas"
            :key="index"
            :id="element.id"
            :route="element.ruta">
        </select-route-card> 
        </select>
        <div class="blFiltro barraLateral__filtroResultados">
           <button v-on:click="getIdRoute()" >Agregar</button>
        </div>
        </div>`

    });

  Vue.component('select-route-card',{
  props : [ 'route', 'id'],
  template :  `
     <option :value="id" >{{route}}</option>
  `
  });


  Vue.component('info-route-card',{
  props : [ 'ruta', 'data', 'relRuta', 'info','ruta_id'],
  template :  `
  <div class="resultadoRuta" :id="relRuta" >
  <div class="resultadoRuta__encabezado" >
     <h3 class="resultadoRuta__titulo">{{ruta}} </h3>
     <button onclick="deleteRel(id)" class="resultado__eliminar" v-bind:rel="relRuta" v-bind:id="ruta_id" ><i class="ib-iconos ib-equis"
           alt="Quitar"></i></button>
  </div>
    <div class="resultadoRuta__sentido">
    <div class="resultadoRuta__sentidoTitulo">
     </div> 

    <div class="resultadoRuta__tags rutaSeleccionada--01"  >
      <div v-if="info == 0 "  > 
          <a class="fila-flex resultadoRuta__tag vehiculo--encendido" >
             <img class="icono" src="/CONTROL/plantilla_nueva/img/bus-encendido.svg"
                alt="Vehículo encendido con señal">
             <span class="ruta">No hay vehiculos en la ruta</span>
          </a>
      </div>
      <div v-for='element in data' >
          <a class="fila-flex resultadoRuta__tag vehiculo--encendido" v-if="element.tipo ==1" >
             <img class="icono" src="/CONTROL/plantilla_nueva/img/bus-encendido.svg"
                alt="Vehículo encendido con señal">
             <span class="ruta">{{element.vehiculo}}</span>
          </a>

          <a class="fila-flex resultadoRuta__tag vehiculo--apagado" v-else >
             <img class="icono" src="/CONTROL/plantilla_nueva/img/bus-amarillo.svg"
                alt="Vehículo apagado con señal">
             <span class="ruta">{{element.vehiculo}}</span>
          </a>
       </div>
     </div>
  </div>


  </div>
  `
  });

  var VehRoutes1 = new Vue({
      el: '#vehRoutes',
      created: function(){
        this.getVehInRoute();
      },
      data: { 
        vehicles: [],
        nombre : 'vehRoutes'
      },
      methods: {
        getVehInRoute: function(){
          this.vehicles = rutasComponent.$data.vehicles;
        }
      },
        template:
        `<div class="resultadosRuta">
        <div class="blFiltro barraLateral__filtroResultados">
         <!--  <button  type="hidden"  v-on:click="getVehInRoute()" >Agregar</button> -->
        </div>
          <info-route-card 
            v-for="(element, index) in vehicles"
              :key="index"
              :ruta="element.ruta"
              :relRuta="element.relRuta"
              :info="element.info"
              :ruta_id="element.ruta_id"
              :data="element.data">
          </info-route-card>
        </div>
        `

    });   


function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}


  function loadmap(SelRuta, idRuta){ 
   var color = '';

   var colores = ["#e9870e", "#da231c", "#680eae", "#345d91", "#f943af", "#633200", "#e9e952"];
   //resetContadorAux(colorAux,colores.length);
   if(colorAux >= colores.length){
    colorAux = 0;
   }
   color = colores[colorAux];
   $.ajax({
      type: "POST",
      data: {idruta : SelRuta},
      dataType: "json",
      cache: false,
      async: false,
      url: "/control/gettrazoruta", 
          
      success: function(data) {
        try{
          if(data['None'] == 0)
          {
              //clearTraza();
              alert('La ruta no est&aacute; parametrizada');
          }
          else 
          {
            var StokeLine = $("#LineTick").val();

            var lineSymbol = null;
            var bounds = new google.maps.LatLngBounds();
            
            var routeName = '';
            var route = '';
            var routePIn = '';
            var routeDIn = '';

            routeName = $.trim(idRuta);
            route = $.trim(data[0]['geometria']);
            
            // Paint Route 
            route = route.substring(11, route.length - 1);
            route = route.split(",");
            var pts = [];
            for (var ri = 0; ri < route.length; ri++) {
              space_position = route[ri].indexOf(" ");
              pts[ri] = new google.maps.LatLng(
                parseFloat(route[ri]
                      .substring(space_position + 1)),
                  parseFloat(route[ri].substring(0,
                      space_position - 1)));
              bounds.extend(pts[ri]);
            }
            
             Ruta = new google.maps.Polyline({
              path : pts,
              icons : [ {
                icon : lineSymbol,
                offset : '50%',
              } ],
              strokeColor : color,
              strokeOpacity : 1,
              strokeWeight : StokeLine,
              clickable : false,
              rel : idRuta
            });

            bounds.getCenter();
            Controlmap.fitBounds(bounds);
            Rutas_Traza['a' + SelRuta] = Ruta;
            Ruta.setMap(Controlmap);
            colorAux++;
           }
        }catch(err){
        //  clearTraza();
          console.log("Error >> get trace route >> "+ err);
        }
      },
      beforeSend: function() { console.log('loading route..'); },
      complete: function() { console.log('..route completed'); },
     });  
   
  }


  function deleteRel(rel_id){
    Rutas_Traza['a'+rel_id].setMap(null);

    aux = rutasComponent.$data.vehiclesShow;
    var contador = 0;
    var borrar = 0;
    aux.forEach(element =>{
      if(element.ruta == rel_id){
         borrar = contador;
      }
      contador++;
    })
    aux = {ruta: 8999, vehiculos: []}
    rutasComponent.$data.vehiclesShow[borrar] = aux;

   // array = rutasComponent.$data.vehiclesShow.splice(borrar,1);

  }

  function resetRutasComponents() {
    rutasComponent.$data.vehiclesShow = [];
    clearTraza();
   }
  function resetVehiclesComponents() {
    vehicleComponent.$data.showInMap = [];
    clearTraza();
   }

   function resetHola() {
    hola.$data.vehicles = [];
    clearTraza();
   }

  function resetAll() {
    colorAux = 0;
    rutasComponent.$data.vehiclesShow = [];
    vehicleComponent.$data.showInMap = [];
    clearTraza();
    $('.resultadoRuta').remove();
    $('.resultadoVehiculo').remove();
    
   }

   function resetContadorAux(contador,iteradorActual){

    if (contador >iteradorActual) {
      contador = 0;
      return contador;
    }

   }

   //rutasComponent.$data.vehiclesShow.push(vehiculoNA);


