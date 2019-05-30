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
<div ng-controller="TransmisionControllerEditForm"  ng-init="idTransmision = <?php echo $id; ?>">
  <p ng-bind-html="cargador" ng-show="loader"></p>
  <div class="row" ng-hide="loader">
    <div class="col-sm-12">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">
            <div class="text-info">
            <i class="fa fa-cogs" aria-hidden="true"></i> Informe de recepción y transmisión de señales.
            </div>
        </h3>
        </div>
        <div class="panel-body">
          <div class='form-row'>
            <form class="form-horizontal" name="transporteEditForm" novalidate>
              <div ng-show="muestraDataPartidos" class="col-xs-10 offset-2">
                  <div class="form-group">
                  <label class="col-md-2 control-label">Campeonato :</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control mayuscula" name="lugar" ng-model="formulario.campeonato" placeholder="Ingresa campenoato">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Programa :</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control mayuscula" name="programa" ng-model="formulario.programa" placeholder="Ingresa programa ">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Tipo de Producción :</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control mayuscula" name="programa" ng-model="formulario.tipo_produccion" placeholder="Ingresa tipo de produccion ">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Inicio :</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control mayuscula" name="hora_ini_evento" ng-model="formulario.hora_ini_evento" id="hora_ini_evento" placeholder="Ingresa Hora Inicio">
                    </span>
                  </div>
                  <label class="col-md-2 control-label">Hora Termino :</label>
                  <div class="col-md-3">
                    <input type="text" id="hora_out_evento" class="form-control mayuscula" name="hora_out_evento" ng-model="formulario.hora_out_evento" placeholder="Ingresa Hora Termino">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Fecha :</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control mayuscula" name="fecha" ng-model="formulario.fecha_partido" placeholder="Ingresa fecha">
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-md-2 control-label">Lugar :</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control mayuscula" name="lugar" ng-model="formulario.lugar" placeholder="Ingresa Lugar">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-md-2 control-label">Fecha Campeonato :</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control mayuscula" name="lugar" ng-model="formulario.fecha" placeholder="Ingresa fecha">
                  </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Señales :</label>
                    <div class="col-md-4">
                      <select multiple class="form-control mayuscula" ng-model="formulario.senales" ng-options="item as item.Channel.nombre for item in senales track by item.Channel.id"></select>
                    </div>
                  </div>
                   <div  ng-show="showProductores==''" class="form-group">
                    <label class="col-md-2 control-label">Productor :</label>
                    <div class="col-md-4">
                      <select multiple class="form-control mayuscula" ng-model="formulario.programas.informes.productoresArray" ng-options="item as item.nombre for item in dataProductores track by item.id"></select>
                    </div>
                   
                  </div>
              </div>
		   <div ng-show="muestraDataNoticias" class="col-xs-10 offset-2">
          <div class="form-group">
                  <label class="col-md-2 control-label">Programa :</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control mayuscula" name="lugar" ng-model="formulario.programas.informes.programa" placeholder="Ingresa Lugar">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Hora Inicio :</label>
                  <div class="col-md-3">
                    <input type="text" id="hora_ini_evento" class="form-control mayuscula" name="hora_ini_evento" ng-model="formulario.programas.informes.hora_ini_evento"  placeholder="Ingresa Hora Inicio">
                  </div>
                  <label class="col-md-2 control-label">Hora Termino :</label>
                  <div class="col-md-3">
                    <input type="text" id="hora_out_evento" class="form-control mayuscula" name="hora_out_evento" ng-model="formulario.programas.informes.hora_out_evento" placeholder="Ingresa Hora Termino">
                  </div>
                </div>
                 <div  class="form-group">
                  <label class="col-md-2 control-label">Fecha :</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control mayuscula" name="date" ng-model="formulario.programas.informes.fecha_partido" placeholder="Ingresa fecha">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Lugar :</label>
                  <div class="col-md-8">
                    <select  type="text" class="form-control mayuscula" name="lugar" ng-model="formulario.programas.informes.lugar" ng-options="item.nombre as item.nombre for item in lugares" >
                       <option value=''>- SELECCIONE UN LUGAR -</option>
                      </select> 
                  </div>
                </div> 
                 <div  class="form-group">
                    <label class="col-md-2 control-label">Señales :</label>
                    <div class="col-md-4">
                      <select multiple class="form-control mayuscula" ng-model="formulario.programas.informes.senalesPrograma" ng-options="item as item.nombre for item in senalesArray track by item.id"></select>
                      
                    </div>
                  </div>       
       </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title text-default">Medio de Transmisiones</h4>
          </div>
          <div class="panel-body">
            <div class="form-group">
             <div class="form-group">
									<label ng-repeat="medio in posiciones" style="font-size: 15px;">
										<input ng-click="cambioPosiciones(medio.id)" ng-model="posicion" type="radio" name="medio" ng-value="medio.id" autocomplete="off" > {{medio.nombre}}
									</label>
								</div>
            </div>
          </div>
          <div class="panel-group" id="accordion">
            <div  class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                 <a  id="btn_new" data-toggle="collapse" data-parent="#accordion" href="#collapse2">Satélite  <span class="fa fa-angle-right"></span></a>
                </h4>
              </div>
              <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                  <label class="col-md-2 control-label">Satélite :</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control mayuscula" name="satelite" ng-model="formulario.satelite2[posicion].satelite" placeholder="Ingresa Satelite">
                  </div>
                   <label class="col-md-2 control-label">Prestador Servicio :</label>
                  <div class="col-md-4">
                     <select multiple class="form-control mayuscula" name="satelite"  ng-model="formulario.satelite2[posicion].prestador" ng-options="item as item.nombre for item in prestadoresArray | filter:{medio:'3'} "></select>
                  </div>
                  <div class="form-group">
                  <label class="col-md-2 control-label">BSO :</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control mayuscula" name="satelite" ng-model="formulario.satelite2[posicion].bso" placeholder="Ingresa BSO">
                  </div>
                   </div>
                   <div class="form-group">
                  <label class="col-md-2 control-label">Empresa :</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control mayuscula" name="satelite" ng-model="formulario.satelite2[posicion].empresa" placeholder="Ingresa empresa">
                  </div>
                   </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Receptor :</label>
                    <div class="col-md-4">
                      <select multiple class="form-control mayuscula" ng-model="formulario.satelite2[posicion].receptor_satelite" ng-options="item as item.nombre for item in receptoresArray track by item.id"></select>                   
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Hora Inicio :</label>
                    <div class="col-md-4">
                      <input type="text" id="hora_out_satelite" class="form-control mayuscula" name="hora_ini_satelite" ng-model="formulario.satelite2[posicion].hora_ini_satelite" placeholder="Ingresa Hora Inicio">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Hora Termino :</label>
                    <div class="col-md-4">
                      <input type="text" id="hora_out_satelite" class="form-control mayuscula" name="hora_out_satelite" ng-model="formulario.satelite2[posicion].hora_out_satelite" placeholder="Ingresa Hora Termino">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Signal Level :</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control mayuscula" name="signal_level" ng-model="formulario.satelite2[posicion].signal_level" placeholder="Ingresa Satelite">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Ber :</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control mayuscula" name="ber" ng-model="formulario.satelite2[posicion].ber" placeholder="Ingresa BER">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">C/N :</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control mayuscula" name="cn" ng-model="formulario.satelite2[posicion].cn" placeholder="Ingresa C/N">
                    </div>
                  </div>
                  <div class="form-group">

                    <label class="col-md-2 control-label">C/N Margin :</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control mayuscula" name="cn_margin" ng-model="formulario.satelite2[posicion].cn_margin" placeholder="Ingresa C/N Margin">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">RX de Señal :</label>
                    <div class="col-md-4">
                      <select multiple class="form-control mayuscula" ng-model="formulario.satelite2[posicion].rx_senal_satelite" ng-options="item as item.nombre for item in rx_senal track by item.id">>
                        <select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Observación:</label>
                    <div class="col-md-4">
                      <textarea   class="form-control mayuscula" name="observacion" rows="4" ng-model="formulario.satelite2[posicion].observacion" placeholder="Ingresa observacion"></textarea >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div  class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                 <a id="btn_new2" data-toggle="collapse" data-parent="#accordion" href="#collapse1">Fibra Óptica  <span class="fa fa-angle-right"></span></a>
                </h4>
              </div>
              <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                  <div class="form-group">
                    <label class="col-md-2 control-label">Receptor :</label>
                    <div class="col-md-4">
                      <select multiple class="form-control mayuscula" ng-model="formulario.fibra_optica[posicion].receptor_fibra" ng-options="item as item.nombre for item in receptoresArray track by item.id"></select>
                      
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Hora Inicio :</label>
                    <div class="col-md-3">
                      <input type="text" id="hora_out_fibra" class="form-control mayuscula" name="hora_ini_fibra" ng-model="formulario.fibra_optica[posicion].hora_ini_fibra" placeholder="Ingresa Hora Inicio">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Hora Termino :</label>
                    <div class="col-md-3">
                      <input type="text" id="hora_out_fibra" class="form-control mayuscula" name="hora_out_fibra" ng-model="formulario.fibra_optica[posicion].hora_out_fibra" placeholder="Ingresa Hora Termino">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">RX de Señal :</label>
                    <div class="col-md-4">
                      <select multiple class="form-control mayuscula" ng-model="formulario.fibra_optica[posicion].rx_senal_fibra" ng-options="item as item.nombre for item in rx_senal track by item.id">>
                        <select>
                    </div>
                  </div>
                   <label class="col-md-2 control-label">Prestador Servicio :</label>
                  <div class="col-md-4">
                     <select multiple class="form-control mayuscula" name="prestafibra"  ng-model="formulario.fibra_optica[posicion].prestador" ng-options="item as item.nombre for item in prestadoresArray | filter:{medio:'1'} "></select>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Observación:</label>
                    <div class="col-md-4">
                      <textarea   class="form-control mayuscula" name="observacion" rows="4" ng-model="formulario.fibra_optica[posicion].observacion" placeholder="Ingresa observacion"></textarea >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div   class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                 <a id="btn_new3" data-toggle="collapse" data-parent="#accordion" href="#collapse3">Micro Ondas  <span class="fa fa-angle-right"></a>
                </h4>
              </div>
              <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                  <div class="form-group">
                    <label class="col-md-2 control-label">Receptor :</label>
                    <div class="col-md-4">
                      <select multiple class="form-control mayuscula" ng-model="formulario.micro_ondas[posicion].receptor_micro" ng-options="item as item.nombre for item in receptoresArray track by item.id"></select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Hora Inicio :</label>
                    <div class="col-md-3">
                      <input type="text" id="hora_out_micro" class="form-control mayuscula" name="hora_ini_micro" ng-model="formulario.micro_ondas[posicion].hora_ini_micro" placeholder="Ingresa Hora Inicio">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Hora Termino :</label>
                    <div class="col-md-3">
                      <input type="text" id="hora_out_micro" class="form-control mayuscula" name="hora_out_micro" ng-model="formulario.micro_ondas[posicion].hora_out_micro" placeholder="Ingresa Hora Termino">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">RX de Señall :</label>
                    <div class="col-md-4">
                      <select multiple class="form-control mayuscula" ng-model="formulario.micro_ondas[posicion].rx_senal_micro" ng-options="item as item.nombre for item in rx_senal track by item.id">>
                        <select>
                    </div>
                  </div>
                  <label class="col-md-2 control-label">Prestador Servicio :</label>
                  <div class="col-md-4">
                     <select multiple class="form-control mayuscula" name="prestamicro"  ng-model="formulario.micro_ondas[posicion].prestador" ng-options="item as item.nombre for item in prestadoresArray | filter:{medio:'2'}"></select>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Observación:</label>
                    <div class="col-md-4">
                      <textarea   class="form-control mayuscula" name="observacion" rows="4" ng-model="formulario.micro_ondas[posicion].observacion" placeholder="Ingresa observacion"></textarea >
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
             
                <div class="panel-body">
                 <div class="panel-body">
            <div class="form-group">
             <label ng-repeat="medios in posicionesMochila" style="font-size: 15px;">
										<input ng-click="cambioPosicionesMochila(medios.id)" ng-model="posicionMochi" type="radio" name="medios" ng-value="medios.id" autocomplete="off" > {{medios.nombre}}
									</label>
            </div>
          </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Receptor :</label>
                    <div class="col-md-4">
                      <select multiple class="form-control mayuscula" ng-model="formulario.otros[posicion][posicionMochi].receptor_micro" ng-options="item as item.nombre for item in receptoresArray track by item.id"></select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Hora Inicio :</label>
                    <div class="col-md-3">
                      <input type="text" id="hora_ini_micro" class="form-control mayuscula" name="hora_ini_micro" ng-model="formulario.otros[posicion][posicionMochi].hora_ini_micro" placeholder="Ingresa Hora Inicio">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Hora Termino :</label>
                    <div class="col-md-3">
                      <input type="text" id="hora_ini_micro" class="form-control mayuscula" name="hora_out_micro" ng-model="formulario.otros[posicion][posicionMochi].hora_out_micro" placeholder="Ingresa Hora Termino">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">RX de Señal :</label>
                    <div class="col-md-4">
                      <select multiple class="form-control mayuscula" ng-model="formulario.otros[posicion][posicionMochi].rx_senal_micro" ng-options="item as item.nombre for item in rx_senal track by item.id">>
                        <select>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-md-2 control-label">Observación:</label>
                    <div class="col-md-4">
                      <textarea   class="form-control mayuscula" name="observacion" rows="4" ng-model="formulario.otros[posicion][posicionMochi].observacion" placeholder="Ingresa observacion"></textarea >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center">
              <button type="button" ng-click="editarTransmision()" class="btn btn-lg btn-primary">Guardar <i class="fa fa-pencil"></i></button>
              <a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-lg center margin-t-10">
                <i class="fa fa-mail-reply-all"></i> Volver
              </a>
            </div>
          </div>
        </div>
        </form>
        <br>
      </div>
    </div>
  </div>
</div>
<?php
echo $this->Html->script(array(
'angularjs/controladores/app',
'angularjs/servicios/informes_transmisiones/informes_transmisiones',
'angularjs/controladores/informes_transmisiones/informes_transmisiones',
'angularjs/servicios/programas/programas',
'angularjs/servicios/receptores/receptores',

));
echo $this->Html->css('bootstrap-clockpicker.min');
echo $this->Html->script(array(
'bootstrap-datepicker',
'bootstrap-clockpicker.min'
));
?>
  <script>
    $(function() {
      $('#hora_ini_evento, #hora_out_evento,#hora_ini_satelite, #hora_out_satelite,#hora_ini_fibra, #hora_out_fibra,#hora_ini_micro, #hora_out_micro').clockpicker({
        placement: 'bottom',
        align: 'top',
        autoclose: true
      });
    });
    var x = document.getElementsByClassName("fa fa-angle-down");
    if (x.length >= 1) {
      x[0].className = "fa fa-angle-right";
    }
    $('#btn_new').click(function() {
   
      $(this).find('span').toggleClass('fa-angle-right fa-angle-down');
    });
    $('#btn_new2').click(function() {
      $(this).find('span').toggleClass('fa-angle-right fa-angle-down');
    });
    $('#btn_new3').click(function() {
      $(this).find('span').toggleClass('fa-angle-right fa-angle-down');
    });
    $('#btn_new4').click(function() {

      $(this).find('span').toggleClass('fa-angle-right fa-angle-down');
    });
     $(document).ready(function() {
      var date_input = $('input[name="date"]');
      var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
      var options = {
        
        autoclose: true
      };
      date_input.datepicker(options);
    });

  </script>