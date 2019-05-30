 <style>input {margin-top: 0px;}
	.ta-editor {
	   min-height: 170px !important;
	   height: 150px !important;	   
	   font-family:arial,sans-serif;
	}
	.ta-scroll-window > .ta-bind {min-height: 168px !important;}</style>
<div ng-controller="TransmisionControllerEnviar" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="row" ng-show="!loader">
		<div class="col-sm-12">
			<h4>Enviar información de transmisiones</h4>
			<div class="row">
				<div class="col-md-12">
					<ul class="menu_secundario nav nav-pills">
						<li class="pull-right">&nbsp;</li>
						<li class="pull-right">
							<a href="" id="envia_informeTransmision" ng-show="!enviarDisabled" class="envia_informeTransmision btn btn-default btn-mx" ng-click="mostrarEnviarCorreo()"><i class="fa fa-send"></i> Enviar informe de Transmisiones</a> 
						</li>
						<li class="pull-right">&nbsp;</li>
						<li class="pull-right">
							<a href="" target="_blank" ng-show="!enviarDisabled" class="generarPdf btn btn-default btn-mx" ng-click="generarPdf(1)"><i class="fa fa-file-pdf-o fa-lg" download></i> Exportar a PDF</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="cuerpoHtmlTabla">
				<style>
					#cuerpoHtmlTabla{margin-top:25px;}
					input {margin-top: 0px;}
					table.partidos{
						width:100%;
						color:#292f33;
						font-size:11px;
						font-family:arial,sans-serif;
						text-align:left;
						border: 1px solid #ccc;
					 	table-layout: fixed !important;}
					table.partidos tr th{				
						text-align:left;
						border-bottom: 1px solid #ccc;}
					table.partidos tr.campeonato1 td{
						border-top: 1px solid #ccc;
						line-height:22px;						
						padding-bottom:2px;
						padding-top:2px;
						padding-left:7px;
					}
					table.partidos tr td.campeonato_inicio{
						border:none !important;
					}
				    table.partidos tr td.campeonato_indentado{
				    	text-indent: -20px !important;				    	
				    }

					table.partidos tr td, table.partidos tr th{
						padding-left:4px;
						text-indent: 3px;						
				    	}
				    table.partidos tr.no-border td, table.partidos tr.no-border th{
				    	border:none;
				    }
				    table.partidos tr td.bordelados, table.partidos tr th.bordelados{
				    	border-top:none;
				    	border-bottom:none;
			    		border-left: 1px solid #ccc;
				    	border-right: 1px solid #ccc;
				    }
				    table.partidos tr td.borde{
				    	border: 1px solid #ccc;
				    }
				    table.partidos tr td.sinborde{
				    	border: none;
				    }
				    table.partidos tr td.vacio{height: 2px;width:100%;}
				    table.partidos tr td.centro, table.partidos tr th.centro{text-align:center;}
				    tr.partido_desc{font-size:12px !important;}
				    table.partidos tr td.inicio, table.partidos tr th.inicio{
				    	width:20px;
				    }
				    table.partidos tr td.bordeupdown{
				    	border-left:none;
				    	border-right:none;
			    		border-top: 1px solid #ccc;
				    	border-bottom: 1px solid #ccc;}
			    	tr.borde td{
			    		border:1px solid #ccc;
			    	}
				</style>
				<table class="partidos" ng-repeat="transmision in transmisiones | orderBy: 'Campeonato.nombre'" nobr="true">
					<tr class="no-border" ng-if="$first">
						<th class="inicio"></th>
						<th colspan="7">Partido </th>
						<th class="centro" colspan="2">Principal</th>
						<th class="centro" colspan="2">Respaldo</th>
						<th class="centro" colspan="1">Radio</th>
					</tr>
					<tr class="campeonato" ng-if="transmision.Campeonato !== undefined">
						<td class="inicio bordeupdown"></td>
						<td colspan="12" class="campeonato_indentado bordeupdown"><strong>CAMPEONATO:</strong>{{transmision.Campeonato.nombre}} </td>
					</tr>
					<tr class="no-border">
						<td class="bordelados inicio"></td>
						<td colspan="7">{{transmision.ProduccionPartidosEvento.fecha_string}}</td>
						<td class="bordelados" colspan="2"></td>
						<td class="bordelados" colspan="2"></td>
						<td></td>
					</tr>
					<tr class="partido_desc no-border">
						<td class="bordelados inicio"></td>
						<td colspan="7"><strong>{{transmision.Equipo.nombre}} vs. {{transmision.EquipoVisita.nombre}} ( {{transmision.ProduccionPartidosTransmisione.nombre_partido}} / 

						Transmisión {{transmision.TransmisionMovile.senal}} )</strong></td>
						<td class="bordelados" colspan="2"></td>
						<td class="bordelados" colspan="2"></td>
						<td></td>
					</tr>	
					<tr class="no-border">
						<td class="bordelados inicio"></td>
						<td colspan="7">ESTADIO {{transmision.Estadio.nombre}}, {{transmision.Estadio.ciudad}}, {{transmision.Estadio.region_ordinal}} {{transmision.Estadio.region_ordinal==="RM" ? "" : " REGIÓN"}}</td>
						<td class="bordelados" colspan="2"></td>
						<td class="bordelados" colspan="2"></td>
						<td></td>
					</tr>
					<tr class="no-border">
						<td class="bordelados inicio"></td>
						<td colspan="3">INICIO DE TRANSMISIÓN</td>
						<td colspan="4">{{transmision.ProduccionPartidosTransmisione.hora_transmision}} Hora Local - {{transmision.ProduccionPartidosTransmisione.hora_transmision_gmt}} Hora GMT</td>
						<td class="bordelados" colspan="2"></td>
						<td class="bordelados" colspan="2"></td>
						<td></td>
					</tr>
					<tr class="no-border">
						<td class="bordelados inicio"></td>
						<td colspan="3">INICIO PARTIDO</td>
						<td colspan="4">{{transmision.ProduccionPartidosEvento.hora_partido}} Hora Local - {{transmision.ProduccionPartidosEvento.hora_partido_gmt}} Hora GMT</td>
						<td class="bordelados centro" colspan="2">{{transmision.Transmision.senal_principal_nombre}}</td>
						<td class="bordelados centro" colspan="2">{{transmision.Transmision.senal_respaldo_nombre}}</td>
						<td class="centro">{{transmision.Transmision.senal_radio_nombre}}</td>						
					</tr>
					<tr class="no-border">
						<td class="bordelados inicio"></td>
						<td colspan="3">FIN APROX. TRANSMISIÓN</td>
						<td colspan="4">{{transmision.ProduccionPartidosTransmisione.hora_termino_transmision}} Hora Local - {{transmision.ProduccionPartidosTransmisione.hora_termino_transmision_gmt}} Hora GMT</td>
						<td class="bordelados" colspan="2"></td>
						<td class="bordelados" colspan="2"></td>
						<td></td>
					</tr>
					<tr class="no-border">
						<td class="bordelados inicio"></td>
						<td colspan="3">PRODUCCIÓN TÉCNICA</td>
						<td colspan="4">{{transmision.NombreProveedor}} 
						{{transmision.TransmisionMovile.nombre}}</td>
						<td class="bordelados" colspan="2"></td>
						<td class="bordelados" colspan="2"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="13" class="borde"></td>
					</tr>
				</table>
				<br />
			</div>
		</div>
	</div>
	<modal visible="showModal">
		<form name="envioCorreoTransmisionesForm" novalidate>
			<div class="form-group">
				<label for="email">Email :</label>
				<input type="email" class="form-control" id="email" name="email" ng-model="transmisionForm.email" required>
			</div>
			<div class="form-group">
				<label for="asunto">Asunto :</label>
				<input type="text" class="form-control" id="asunto" name="asunto" ng-model="transmisionForm.asunto" required>
			</div>		  
			<div class="form-group" >
				<label for="mensaje">Mensaje :</label>				
				<div name="mensaje" id="mensaje" text-angular ng-model="transmisionForm.mensaje" required></div>		
				<p>&nbsp;</p>
			</div>
			<div class="form-group" >
				<label for="adjunto">Adjunto : <i class="fa fa-paperclip fa-lg" aria-hidden="true">Transmision_pdf_<?php echo date("Y-m-d");?>.pdf</i></label>
			</div>
			<div class="form-group text-center">
				<button type="button" ng-disabled="envioCorreoTransmisionesForm.$invalid || enviarDisabled" ng-click="generarPdf(2)" class="btn btn-lg btn-primary">Enviar</button>
			</div>
		</form>
		<div class="modal-footer">
	        <button type="button" class="btn btn-default" ng-click="cerrarModal()" data-dismiss="modal">Cerrar ventana</button>
	    </div>
	</modal>
</div>

<?php
	echo $this->Html->css("angular/text-angular/textAngular"); 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/transmisionPartidos/transmisionPartidos',
		'angularjs/modulos/text-angular/textAngular.min',
		'angularjs/modulos/text-angular/textAngular-rangy.min',
		'angularjs/modulos/text-angular/textAngular-sanitize.min',		
		'angularjs/controladores/transmisionPartidos/transmisionPartidos',
		'angularjs/directivas/modal/modal',
	));
?>
