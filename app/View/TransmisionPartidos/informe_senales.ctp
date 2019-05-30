<style>
  input {
    margin-top: 4px;
  }
  
  .btn-xs {
    margin-top: -18px;
  }
  
  .col-md-2 {
    width: 16.66666667%;
    padding-top: 7px;
    margin-bottom: 0;
    text-align: right;
  }
</style>

<div ng-controller="TransmisionControllerAddInforme" ng-cloak>
  <p ng-bind-html="cargador" ng-show="loader"></p>
  <div class="row" ng-hide="loader">
    <div class="col-sm-12">
      <h3>Informe de transmisión de señales</h3>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Evento</h4>
        </div>
        <div class="panel-body">
          <div class='form-row'>
            <form class="form-horizontal" name="transporteEditForm" novalidate>
              <div class="col-xs-10 offset-2">
                <p>{{posicion}}</p>
                <div class="form-group">
                  <label class="col-md-2 control-label">Programa</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="programa" ng-model="formulario.programa" placeholder="Ingresa programa ">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Inicio</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="hora_ini_evento" ng-model="formulario.hora_ini_evento" placeholder="Ingresa Hora Inicio">
                  </div>
                  <label class="col-md-2 control-label">Hora Termino</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="hora_out_evento" ng-model="formulario.hora_out_evento" placeholder="Ingresa Hora Termino">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Lugar</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="lugar" ng-model="formulario.lugar" placeholder="Ingresa Lugar">
                  </div>
                </div>


              </div>
          </div>

        </div>
      </div>
      <div class="panel panel-default">

        <div class="panel-heading">
          <h4>Medio de Transmisiones</h4>
        </div>
        <div class="panel-body">
          <div class="form-group">
            <label>
              <input ng-click="cambioPosiciones(medio.id)" ng-model="formulario.principal" type="radio" name="medio" ng-value="principal" autocomplete="off"> Principal
            </label>
            <label>
              <input ng-click="cambioPosiciones(medio.id)" ng-model="formulario.respaldo" type="radio" name="medio" ng-value="respaldo" autocomplete="off"> Respaldo
            </label>
            <label>
              <input ng-click="cambioPosiciones(medio.id)" ng-model="formulario.radio" type="radio" name="medio" ng-value="radio" autocomplete="off"> Radio
            </label>
          </div>

        </div>
        <div class="panel-group" id="accordion">

          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
<a  id="btn_new" data-toggle="collapse" data-parent="#accordion" href="#collapse2">Satelite  <span class="fa fa-angle-right"></span></a>

</h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
              <div class="panel-body">
                <center>


                  <div class="form-group">
                    <label class="col-md-2 control-label">Receptor</label>
                    <div class="col-md-4">
                      <select multiple class="form-control" ng-model="formulario.selectedItemReceptorSatelite" ng-options="item as item.nombre for item in receptorDataSatelite"></select>
                    </div>

                  </div>

                  <div class="form-group">
                    <label class="col-md-2 control-label">Hora Inicio</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="hora_ini_satelite" ng-model="formulario.hora_ini_satelite" placeholder="Ingresa Hora Inicio">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Hora Termino</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="hora_out_satelite" ng-model="formulario.hora_out_satelite" placeholder="Ingresa Hora Termino">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Signal Level</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="signal_level" ng-model="formulario.signal_level" placeholder="Ingresa Satelite">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Ber</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="ber" ng-model="formulario.ber" placeholder="Ingresa BER">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-md-2 control-label">C/N</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="cn" ng-model="formulario.cn" placeholder="Ingresa C/N">
                    </div>
                  </div>

                  <div class="form-group">

                    <label class="col-md-2 control-label">C/N Margin </label>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="cn_margin" ng-model="formulario.cn_margin" placeholder="Ingresa C/N Margin">
                    </div>

                  </div>
                  <div class="form-group">
                  <label class="col-md-2 control-label" >RX de Señal</label>
                  <div class="col-md-4">
                    <select multiple   class="form-control" ng-model="formulario.rx_senal_satelite" ng-options="item as item.nombre for item in rx_senal">>
                      <select>
                  </div>
                </div>

                </center>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
<a id="btn_new2" data-toggle="collapse" data-parent="#accordion" href="#collapse1">Fibra Óptica   <span class="fa fa-angle-right"></span></a>
</h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
              <div class="panel-body">


                <div class="form-group">
                  <label class="col-md-2 control-label">Receptor</label>
                  <div class="col-md-4">
                    <select multiple class="form-control" ng-model="formulario.selectedItemReceptorFibra" ng-options="item as item.nombre for item in receptorDataFibra"></select>
                  </div>

                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Inicio</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="hora_ini_fibra" ng-model="formulario.hora_ini_fibra" placeholder="Ingresa Hora Inicio">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Termino</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="hora_out_fibra" ng-model="formulario.hora_out_fibra" placeholder="Ingresa Hora Termino">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label" >RX de Señal</label>
                  <div class="col-md-4">
                    <select multiple   class="form-control" ng-model="formulario.rx_senal_fibra" ng-options="item as item.nombre for item in rx_senal">>
                      <select>
                  </div>
                </div>



              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
<a id="btn_new3" data-toggle="collapse" data-parent="#accordion" href="#collapse3">Micro Ondas  <span class="fa fa-angle-right"></a>
</h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
              <div class="panel-body">
                <div class="form-group">
                  <label class="col-md-2 control-label">Receptor</label>
                  <div class="col-md-4">
                    <select multiple class="form-control" ng-model="formulario.selectedItemReceptorMicro" ng-options="item as item.nombre for item in receptorDataMicro"></select>
                  </div>

                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Inicio</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="hora_ini_micro" ng-model="formulario.hora_ini_micro" placeholder="Ingresa Hora Inicio">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Termino</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="hora_out_micro" ng-model="formulario.hora_out_micro" placeholder="Ingresa Hora Termino">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label" >RX de Señal</label>
                  <div class="col-md-4">
                    <select multiple   class="form-control" ng-model="formulario.rx_senal_micro" ng-options="item as item.nombre for item in rx_senal">>
                      <select>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
<a id="btn_new4" data-toggle="collapse" data-parent="#accordion" href="#collapse4">Otro <span class="fa fa-angle-right"></a>
</h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
              <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
            </div>
          </div>

          <div class="pull-right">

            <button type="button" ng-click="addInforme()" class="btn btn-lg btn-primary">Guardar <i class="fa fa-pencil"></i></button>
            <a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-lg center margin-t-10">
              <i class="fa fa-mail-reply-all"></i> Volver
            </a>
          </div>


        </div>
        </form>

      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<?php
echo $this->Html->script(array(
'angularjs/controladores/app',
'angularjs/servicios/transmisionPartidos/transmisionPartidos',
'angularjs/controladores/transmisionPartidos/transmisionPartidos'
));
?>
<script>
      /*var x = document.getElementsByClassName("fa coke fa-angle-down");
      console.log(x);
     if(x.length>=0){
        console.log('hola');
      x[0].className = "fa fa-angle-rigth";
      }*/
        
      var x = document.getElementsByClassName("fa fa-angle-down");
      //console.log(x);
     if(x.length>=1){
        console.log('hola');
      x[0].className = "fa fa-angle-right";
      }
$('#btn_new').click(function(){
   // var x = document.getElementsByClassName("fa fa-angle-right");
   // x[0].className = "fa fa-angle-down";
     $(this).find('span').toggleClass('fa-angle-right fa-angle-down');
      //console.log( document.getElementsByClassName("fa fa-angle-right"));
      
});
$('#btn_new2').click(function(){

      $(this).find('span').toggleClass('fa-angle-right fa-angle-down');
       
});
$('#btn_new3').click(function(){
      
      $(this).find('span').toggleClass('fa-angle-right fa-angle-down');
});
$('#btn_new4').click(function(){
     
      $(this).find('span').toggleClass('fa-angle-right fa-angle-down');
});
</script>