<style>
  input {
    margin-top: 0px;
  }
  td{
    text-transform: uppercase;
  }
  
  .btn-xs {
    margin-top: -18px;
  }
  
  .def {
    font-weight: 100;
    display: inline-block;
  }
</style>
<div ng-controller="informesView" ng-init="idTransmision = <?php echo $id; ?>">
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
        <div ng-show="muestraDataPartidos" class="panel-body">
          <div class="row">
          <div class="col-sm-6">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">               
                    <th>Supervisor :</th>
                    <tr> 
                    <td>{{supervisor}}</td>                                   
                  </tr>                    
                </table>
              </div>
            </div>
             <div ng-show="informe.productor" class="col-sm-6">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">       
                
                <th>Productor :</th>
                      <tr>
                        <td>{{informe.productor}}</td>
                        </tr> 
                </table>
              </div>
            </div>
             <div ng-show="productorIngresado" class="col-sm-6">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">       
                <th>Productor :</th>
                      <tr ng-repeat="rows in productorIngresado">
                        <td>{{rows.nombre}}</td>
                        </tr> 
                 
                </table>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <tr>
                  <th>Campeonato:</th>
                    <td>{{informe.campeonato}}</td>
                    <th>Programa:</th>
                    <td>{{informe.equipos}}</td>
                    <th>Categoría:</th>
                    <td>{{informe.nombre_fecha_partido}}</td>              
                    <th>Lugar:</th>
                    <td>{{informe.estadio}}</td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <tr>
                   <th>Señales:</th>
                      <tr ng-repeat="rows in informe.senales">
                        <td>{{rows.Channel.nombre}}</td>
                        </tr>                         
                </table>
              </div>
            </div>
             <div class="col-sm-6">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                 <tr><th>Transmisión Partido:</th>
                    <td>{{produccionView}}</td></tr>
                <tr> 
                <tr> 
                    <th>Fecha :</th>
                    <td>{{informe.fecha_partido}}</td>
                    </tr>   
                  <tr>
                    <th>Hora Inicio:</th>
                    <td>{{informe.hora_transmision}}</td>
                    </tr>
                    <tr>
                    <th>Hora Termino:</th>
                    <td>{{informe.hora_termino_transmision}}</td>
                    </tr> 
                </table>
              </div>
            </div>
           
          </div>
        </div>
		  <div ng-show="muestraDataNoticias" class="panel-body">
          <div class="row">
          <div class="col-sm-6">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">          
                  <tr>               
                    <th>Supervisor :</th>
                    <td>{{supervisor}}</td>                                     
                  </tr>
                </table>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <tr> 
                    <th>Programa:</th>
                    <td>{{informe.evento.nombre}}</td>
                    <th>Lugar:</th>
                    <td>{{lugares}}</td>
                    </tr>
      
                </table>
              </div>
            </div>
             
             <div class="col-sm-6">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">              
                    <th>Señales :</th>
                     
                     <tr ng-repeat="rows in senalesArray">
                        <td>{{rows.nombre}}</td>
                        </tr>  
                </table>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                <tr> 
                    <th>Fecha :</th>
                    <td>{{informe.fecha_partido}}</td>
                    </tr>   
                  <tr>
                    <th>Hora Inicio:</th>
                    <td>{{informe.hora_ini_evento}}</td>
                    </tr>
                    <tr>
                    <th>Hora Termino:</th>
                    <td>{{informe.hora_out_evento}}</td>
                    </tr> 
                </table>
              </div>
            </div>
          </div>
        </div>
		<div  class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title text-default">Medio de Transmisiones</h2></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-6">
               
            <div class="form-group">
             <label ng-repeat="medio in posiciones" style="font-size: 15px;">
										<input ng-click="cambioPosiciones(medio.id)" ng-model="posicion" type="radio" name="medio" ng-value="medio.id" autocomplete="off" > {{medio.nombre}}
									</label>
                </div>
              </div>            
                </div>
          </div>
        </div>
        <div ng-show="informeSa[posicion]"class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title text-default">Satélite</h2></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tr>
                      <th>Satélite</th>
                      <td>{{informeSa[posicion].satelite}}</td>
                    </tr>
                   <tr>
                      <th>BSO :</th>
                      <td>{{informeSa[posicion].bso}}</td>
                    </tr>
                    <tr>
                      <th>Empresa :</th>
                      <td>{{informeSa[posicion].empresa}}</td>
                    </tr>
                     
                    <tr>
                      <th>Hora Inicio:</th>
                      <td>{{informeSa[posicion].hora_ini_satelite}}</td>
                    </tr>
                    <tr>
                      <th>Hora Termino:</th>
                      <td>{{informeSa[posicion].hora_out_satelite}}</td>
                    </tr>
                                                            
                  </table>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tr>
                      <th>Signal Level:</th>
                      <td>{{informeSa[posicion].signal_level}}</td>
                    </tr>
                    <tr>
                      <th>BER:</th>
                      <td>{{informeSa[posicion].ber}}</td>
                    </tr>
                    <tr>
                      <th>C/N :</th>
                      <td>{{informeSa[posicion].cn}}</td>
                    </tr>
                    <tr>
                      <th>C/N MARGIN:</th>
                      <td>{{informeSa[posicion].cn_margin}}</td>
                    </tr>
                    <tr>
                      <th>C/N MARGIN:</th>
                      <td>{{informeSa[posicion].cn_margin}}</td>
                    </tr>
                  </table>
                </div>
              </div>
               <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                       <th>Receptor:</th>
                        <tr ng-repeat="rows in informeSa[posicion].receptor_satelite">
                          <td>{{rows.nombre}}</td>
                        </tr>   
                  </table>
                </div>
              </div>
                <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                       <th>Prestador:</th>
                        <tr ng-repeat="rows in informeSa[posicion].prestador">
                          <td>{{rows.nombre}}</td>
                        </tr>
                  </table>
                </div>
              </div>
               <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <th>RX DE SEÑAL:</th>
                        <tr ng-repeat="rows in informeSa[posicion].rx_senal_satelite">
                          <td>{{rows.nombre}}</td>
                        </tr>
                  </table>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tr>
                     <th>Observación :</th>
                      <td>{{informeSa[posicion].observacion}}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div ng-show="informeFO[posicion]" class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title text-default">Fibra Óptica</h2></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tr>
                    </tr>
                    <tr>
                      <th>Receptor:</th>
                      <tr ng-repeat="rows in informeFO[posicion].receptor_fibra">
                        <td>{{rows.nombre}}</td>
                      </tr>
                  </table>
                </div>
              </div>
                <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                       <th>Prestador:</th>
                        <tr ng-repeat="rows in informeFO[posicion].prestador">
                          <td>{{rows.nombre}}</td>
                        </tr>
                  </table>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">    
                    <tr>
                      <th>Hora Inicio:</th>
                      <td>{{informeFO[posicion].hora_ini_fibra}}</td>
                      <th>Hora Termino:</th>
                      <td>{{informeFO[posicion].hora_out_fibra}}</td>
                  </table>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <th>RX DE SEÑAL:</th>
                        <tr ng-repeat="rows in informeFO[posicion].rx_senal_fibra">
                          <td>{{rows.nombre}}</td>
                        </tr>
                  </table>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tr>
                     <th>Observación :</th>
                      <td>{{informeFO[posicion].observacion}}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div ng-show="informeMO[posicion]" class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title text-default">Micro Ondas</h2></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tr>
                    </tr>
                    <tr>
                      <th>Receptor:</th>
                      <tr>
                        <tr ng-repeat="rows in informeMO[posicion].receptor_micro">
                          <td>{{rows.nombre}}</td>
                        </tr>
                  </table>
                </div>
              </div>
                <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                       <th>Prestador:</th>
                        <tr ng-repeat="rows in informeMO[posicion].prestador">
                          <td>{{rows.nombre}}</td>
                        </tr>           
                  </table>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tr>
                      <th>Hora Inicio:</th>
                      <td>{{informeMO[posicion].hora_ini_micro}}</td>
                    </tr>
                    <tr>
                      <th>Hora Termino:</th>
                      <td>{{informeMO[posicion].hora_out_micro}}</td>
                    </tr>
                    </tr>
                  </table>
                </div>
              </div>
               <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <th>RX DE SEÑAL:</th>
                        <tr ng-repeat="rows in informeMO[posicion].rx_senal_micro">
                          <td>{{rows.nombre}}</td>
                        </tr>
                  </table>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tr>
                     <th>Observación :</th>
                      <td>{{informeMO[posicion].observacion}}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div ng-show="informeOtros[posicion]"class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title text-default">Otros</h2></div>
          <div class="panel-body">
            <div class="row">
            <div class="form-group">
             <label ng-repeat="medio in posicionesMochila" style="font-size: 15px;">
										<input ng-click="cambioPosicionesMochila(medio.id)" ng-model="posicionMochi" type="radio" name="medioMochi" ng-value="medioMochi.id" autocomplete="off" > {{medio.nombre}}
									</label>
            
                </div>
              </div>
              <div ng-show="informeOtros[posicion][posicionMochi]">
              <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tr>                    
                    </tr>
                    <tr>
                      <th>Receptor:</th>
                      <tr>
                        <tr ng-repeat="rows in informeOtros[posicion][posicionMochi].receptor_micro">
                          <td>{{rows.nombre}}</td>
                        </tr>
                  </table>
                </div>
              </div>
               
              <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tr>
                      <th>Hora Inicio:</th>
                      <td>{{informeOtros[posicion][posicionMochi].hora_ini_micro}}</td>
                    </tr>
                    <tr>
                      <th>Hora Termino:</th>
                      <td>{{informeOtros[posicion][posicionMochi].hora_out_micro}}</td>
                    </tr>
                    </tr>
                  </table>
                </div>
              </div>
               <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <th>RX DE SEÑAL:</th>
                        <tr ng-repeat="rows in informeOtros[posicion][posicionMochi].rx_senal_micro">
                          <td>{{rows.nombre}}</td>
                        </tr>
                  </table>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <tr>
                     <th>Observación :</th>
                      <td>{{informeOtros[posicion][posicionMochi].observacion}}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="text-center">
          <a href="<?php echo $this->request->referer(); ?>" class="btn btn-lg btn-default btn-md center margin-t-10">
            <i class="fa fa-mail-reply-all"></i> Volver
          </a>
          <button class="btn btn-primary btn-lg imprimirPlantilla" ng-click="mensajeEmail()">
            <i class="fa fa-paper-plane"></i> Enviar Email
          </button>
        </div>
        <br>
      </div>
    </div>
  </div>
</div>

<?php
echo $this->Html->script(array(
'angularjs/controladores/app',
'angularjs/servicios/informes_transmisiones/informes_transmisiones',
'angularjs/controladores/informes_transmisiones/informes_transmisiones'
));
?>