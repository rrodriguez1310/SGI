<div ng-controller="TransmisionControllerAddInforme" ng-cloak>
  <p ng-bind-html="cargador" ng-show="loader"></p>
  <div class="row" ng-hide="loader">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Informe de recepción y transmisión de señales.</h4>
        </div>
        <div class="panel-body">
          <div class='form-row'>
            <form class="form-horizontal" name="transporteEditForm" novalidate>
              <div class="col-xs-10 offset-2">
                <p>{{posicion}}</p>
                <div class="form-group">
                  <label class="col-md-2 control-label">Programa </label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="programa" ng-model="formulario.programa" placeholder="Ingresa programa ">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Inicio </label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="hora_ini_evento" ng-model="formulario.hora_ini_evento" placeholder="Ingresa Hora Inicio">
                  </div>
                  <label class="col-md-2 control-label">Hora Termino </label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="hora_out_evento" ng-model="formulario.hora_out_evento" placeholder="Ingresa Hora Termino">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Lugar </label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="lugar" ng-model="formulario.lugar" placeholder="Ingresa Lugar">
                  </div>
                </div>
                <hr>
                <div class="panel-heading">
                  <h4>Medio de Transmisiones</h4>

                  <div class="panel-body">
                    <div class="form-group">
                      <label>
                        <input ng-click="cambioPosiciones(medio.id)" ng-model="posicion" type="radio" name="medio" ng-value="medio.id" autocomplete="off"> PRINCIPAL
                      </label>
                      <label>
                        <input ng-click="cambioPosiciones(medio.id)" ng-model="posicion" type="radio" name="medio" ng-value="medio.id" autocomplete="off"> RESPALDO
                      </label>
                      <label>
                        <input ng-click="cambioPosiciones(medio.id)" ng-model="posicion" type="radio" name="medio" ng-value="radio" autocomplete="off"> RADIO
                      </label>
                    </div>
                  </div>
                </div>
                
<div class="form-group">
<label class="col-md-2 control-label">Medio Transmisión</label>
<div class="col-md-5">
<select class="form-control" placeholder="Seleccione un Medio de Transmisión" ng-change="cambiaMedio(selectedItem.id, selectedItem)" ng-model="selectedItem" ng-options="item as item.nombre for item in posiciones"></select>
<!--<pre>{{selectedItem }}</pre>-->


</div>

</div>
<div class="form-group" ng-show="selectedItem.id=='otro'">
<label class="col-md-2 control-label">Seleccione Medio</label>
<div class="col-md-5">
<select class="form-control">
<option>Mochila</option>
<option>Foosc</option>

</select>
</div>
</div>
<div class="form-group">
<label class="col-md-2 control-label">Receptor </label>
<div class="col-md-5">
<select multiple class="form-control" ng-model="selectedItemReceptor" ng-options="item as item.nombre for item in receptorData"></select>
    </div>

</div>
<div class="form-group">
<label class="col-md-2 control-label">Hora Inicio </label>
<div class="col-md-3">
<input type="text" class="form-control" name="hora_ini" ng-model="formulario[posicion].hora_ini" placeholder="Ingresa Hora Inicio">
</div>
<label class="col-md-2 control-label">Hora Termino </label>
<div class="col-md-3">
<input type="text" class="form-control" name="hora_out" ng-model="formulario[posicion].hora_out" placeholder="Ingresa Hora Termino">
</div>
</div>
<div class="form-group" ng-show="selectedItem.id=='satelital'">
<label class="col-md-2 control-label">Signal Level </label>
<div class="col-md-3">
<input type="text" class="form-control" name="satelite" ng-model="formulario[posicion].satelite" placeholder="Ingresa Satelite">
</div>
<label class="col-md-2 control-label">Ber </label>
<div class="col-md-3">
<input type="text" class="form-control" name="ber" ng-model="formulario[posicion].ber" placeholder="Ingresa BER">
</div>
</div>


<div class="form-group" ng-show="selectedItem.id=='satelital'">
<label class="col-md-2 control-label">C/N </label>
<div class="col-md-3">
<input type="text" class="form-control" name="cn" ng-model="formulario[posicion].cn" placeholder="Ingresa C/N">
</div>

<label class="col-md-2 control-label">C/N Margin</label>
<div class="col-md-3">
<input type="text" class="form-control" name="cn_margin" ng-model="formulario[posicion].cn_margin" placeholder="Ingresa C/N Margin">
</div>

</div>

<div class="form-group">
<label class="col-md-2 control-label">RX de Señal </label>
<div class="col-md-5">
<select multiple class="form-control" id="sel2">
<option>Ok</option>
<option>Deficiente</option>
<option>Sin Observaciones</option>
<select>
</div>
</div>
<div class="col-md-12 text-center">
<div class="form-group">
<button type="button" ng-click="addInforme()" class="btn btn-lg btn-primary">Guardar <i class="fa fa-pencil"></i></button>
<a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-lg center margin-t-10">
<i class="fa fa-mail-reply-all"></i> Volver
</a>
</div>
</div>



</div>


              </div>

          </div>
        </div>
        <div class="panel-group" id="accordion">

          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Fibra Óptica</a>
</h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
              <div class="panel-body">

                <div class="form-group">
                  <label class="col-md-2 control-label">Receptor </label>
                  <div class="col-md-4">
                    <select multiple class="form-control" ng-model="selectedItemReceptorFibra" ng-options="item as item.nombre for item in receptorDataFibra"></select>
                  </div>

                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Inicio </label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="hora_iniFibra" ng-model="formulario.hora_iniFibra" placeholder="Ingresa Hora Inicio">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Termino </label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="hora_outFibra" ng-model="formulario.hora_outFibra" placeholder="Ingresa Hora Termino">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">RX de Señal </label>
                  <div class="col-md-4">
                    <select multiple class="form-control">
                      <option>Ok</option>
                      <option>Deficiente</option>
                      <option>Sin Observaciones</option>
                      <select>
                  </div>
                </div>


              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Satelite</a>
</h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
              <div class="panel-body">
                <div class="form-group">
                  <label class="col-md-2 control-label">Receptor </label>
                  <div class="col-md-5">
                    <select multiple class="form-control" ng-model="formulario.selectedItemReceptorSatelite" ng-options="item as item.nombre for item in receptorDataSatelite"></select>
                  </div>

                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Inicio </label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="hora_iniSatelite" ng-model="formulario.hora_iniSatelite" placeholder="Ingresa Hora Inicio">
                  </div>

                  <label class="col-md-2 control-label">Hora Termino </label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="hora_outSatelite" ng-model="formulario.hora_outSatelite" placeholder="Ingresa Hora Termino">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Signal Level </label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="signal_level" ng-model="formulario.signal_level" placeholder="Ingresa Satelite">
                  </div>
                  <label class="col-md-2 control-label">Ber </label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="ber" ng-model="formulario.ber" placeholder="Ingresa BER">
                  </div>
                </div>


                <div class="form-group">
                  <label class="col-md-2 control-label">C/N </label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="cn" ng-model="formulario.cn" placeholder="Ingresa C/N">
                  </div>

                  <label class="col-md-2 control-label">C/N Margin</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="cn_margin" ng-model="formulario.cn_margin" placeholder="Ingresa C/N Margin">
                  </div>

                </div>

                <div class="form-group">
                  <label class="col-md-2 control-label">RX de Señal </label>
                  <div class="col-md-5">
                    <select multiple class="form-control">
                      <option>Ok</option>
                      <option>Deficiente</option>
                      <option>Sin Observaciones</option>
                      <select>
                  </div>
                </div>


              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Micro Ondas</a>
</h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
              <div class="panel-body">
                <div class="form-group">
                  <label class="col-md-2 control-label">Receptor </label>
                  <div class="col-md-4">
                    <select multiple class="form-control" ng-model="selectedItemReceptorMicro" ng-options="item as item.nombre for item in receptorDataMicro"></select>
                  </div>

                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Inicio </label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="hora_ini_micro" ng-model="formulario.hora_ini_micro" placeholder="Ingresa Hora Inicio">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Termino </label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="hora_out_micro" ng-model="formulario.hora_out_micro" placeholder="Ingresa Hora Termino">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">RX de Señal </label>
                  <div class="col-md-4">
                    <select multiple class="form-control">
                      <option>Ok</option>
                      <option>Deficiente</option>
                      <option>Sin Observaciones</option>
                      <select>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Otro</a>
</h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
              <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
            </div>
          </div>
          <div class="col-md-12 text-center">
            <div class="form-group">
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