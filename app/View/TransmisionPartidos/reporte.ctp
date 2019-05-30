 <style>input {margin-top: 0px;}
	.ta-editor {
	   min-height: 170px !important;
	   height: 150px !important;	   
	   font-family:arial,sans-serif;
	}
	.ta-scroll-window > .ta-bind {min-height: 168px !important;}</style>
<div ng-controller="TransmisionControllerReporte" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="row" ng-show="!loader">
		<div class="col-sm-12 over">
			<h4>Transmisión de Partidos</h4>			
			<div class="row">
				<div class="col-md-12">
					<ul class="menu_secundario nav nav-pills">
						<li class="pull-right">&nbsp;</li>
						<li class="pull-right">
							<a href="" target="_blank" ng-show="!enviarDisabled" class="generarPdf btn btn-default btn-mx" ng-click="generarPdf(1)"><i class="fa fa-file-pdf-o fa-lg"></i> Exportar a PDF</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="cuerpoHtmlTabla">
				<style>
					.over{
						overflow-y: auto;
					}
					#cuerpoHtmlTabla{margin-top:5px;}
					table.partidos{
						width:100%;
						color:#292f33;
						font-size:9px;
						font-family:arial,sans-serif;
						text-align: left;
						margin-top:2px;
						border-collapse: collapse;
						border: 1px solid #ccc;
					 	table-layout: fixed !important;}
					table.partidos tr th{
						text-align:left;
						border-bottom: 1px solid #ccc;}
					table.partidos tr td, table.partidos tr th{
						padding-left: 3px;
				    	}
					table.partidos tr td{
						border-left:1px solid #ccc !important;
						border-right:1px solid #ccc !important;
			    	}
			    	table.partidos tr td.bordelados{
			    		border-left:1px solid #ccc;
						border-right:1px solid #ccc;
			    	}
				    table.partidos tr td.inicio, table.partidos tr th.inicio{
				    	width:20px;
				    }				    
			    	tr.borde td{
			    		border:1px solid #ccc;
			    	}
			    	table.partidos tr th.medio, table.partidos tr td.medio{
			    		width:80px;
			    	}
			    	table.partidos tr th.corto, table.partidos tr td.corto{
			    		text-align: center;
			    		width:65px;
			    	}
			    	table.partidos tr th.largo, table.partidos tr td.largo{
			    		width:120px;
			    	}
			    	table.partidos tr th.vs, table.partidos tr td.vs{
			    		width:35px;
			    		text-align: center;
			    	}
				</style>
				<div class="partidos_container" ng-repeat="transmision in transmisiones | orderBy: 'Campeonato.nombre'" nobr="true">
					<table class="partidos" ng-if="$first" nobr="true">
						<tr>
							<th class="inicio"></th>
							<th class="largo"></th>
							<th class="vs"></th>
							<th class="medio"></th>
							<th class="largo"></th>
							<th class="medio"></th>
							<th class="corto"></th>
							<th class="largo"></th>
							<th class="corto"></th>
							<th class="corto"></th>
							<th class="medio"></th>
							<th class="corto"></th>
							<th class="corto"></th>
						</tr>
						<tr class="no-border" >
							<th></th>
							<th colspan="6">{{(transmision.Categoria.nombre).replace(" ", " N° ")}} del Campeonato {{transmision.campeonatos}}</th>							
							<th></th>
							<th colspan="5">PROGRAMACIÓN DE TRANSMISIONES</th>
						</tr>
						<tr>
							<th class="inicio"></th>
							<th class="largo"></th>
							<th class="vs"></th>
							<th class="medio"></th>
							<th class="largo"></th>
							<th class="medio"></th>
							<th class="corto"></th>
							<th class="largo"></th>
							<th class="corto"></th>
							<th class="corto"></th>
							<th class="medio"></th>
							<th class="corto"></th>
							<th class="corto"></th>
						</tr>
					</table>
					<table class="partidos" ng-if="$first">
						<tr>
							<th class="inicio"></th>
							<th class="largo">LOCAL</th>
							<th class="vs"></th>
							<th class="medio">VISITA</th>
							<th class="largo">ESTADIO</th>
							<th class="medio">Campeonato</th>
							<th class="corto">SEÑAL</th>
							<th class="largo">Horario de puesta en marcha</th>
							<th class="corto">OPERACIÓN</th>
							<th class="corto">Medio de Tx</th>
							<th class="medio">Contacto Estadio</th>
							<th class="corto">Recepción de señal en CDF</th>
							<th class="corto">Teléfono</th>
						</tr>
					</table>
					<table class="partidos">
						<tr class="partido_desc no-border">
							<td class="inicio bordelados">{{transmision.ProduccionPartidosEvento.id}}</td>
							<td class="largo bordelados">{{transmision.Equipo.nombre}}</td>
							<td class="vs bordelados">v/s</td>
							<td class="medio bordelados">{{transmision.EquipoVisita.nombre}}</td>
							<td class="largo bordelados">{{transmision.estadio.nombre}}</td>
							<td class="medio bordelados">{{transmision.campeonato.nombre_prefijo}}</td>
							<td class="corto bordelados">Principal</td>
							<td class="largo bordelados">{{transmision.Transmision.principal_meta.puesta_marcha}}</td>
							<td class="corto bordelados">{{transmision.Transmision.senal_principal_nombre}}</td>
							<td class="corto bordelados">{{transmision.Transmision.medio_principal_nombre}}</td>
							<td class="medio bordelados">{{transmision.Transmision.principal_meta.contacto}}</td>
							<td class="corto bordelados">{{transmision.Transmision.principal_meta.recepcion}}</td>
							<td class="corto bordelados">{{transmision.Transmision.principal_meta.anexo}}</td>
						</tr>
						<tr class="partido_desc no-border">
							<td class="inicio bordelados"></td>
							<td class="largo bordelados">{{transmision.ProduccionPartidosEvento.fecha_string}}</td>
							<td class="vs bordelados bordelados"></td>
							<td class="medio bordelados"></td>
							<td class="largo bordelados"></td>
							<td class="medio bordelados"></td>
							<td class="corto bordelados">Respaldo</td>
							<td class="largo bordelados">{{transmision.Transmision.respaldo_meta.puesta_marcha}}</td>
							<td class="corto bordelados">{{transmision.Transmision.senal_respaldo_nombre}}</td>
							<td class="corto bordelados">{{transmision.Transmision.medio_respaldo_nombre}}</td>
							<td class="medio bordelados">{{transmision.Transmision.respaldo_meta.contacto}}</td>
							<td class="corto bordelados">{{transmision.Transmision.respaldo_meta.recepcion}}</td>
							<td class="corto bordelados">{{transmision.Transmision.respaldo_meta.anexo}}</td>
						</tr>
						<tr class="partido_desc no-border">
							<td class="inicio bordelados"></td>
							<td class="largo bordelados bordelados">Inicio Tx</td>
							<td class="vs bordelados">{{transmision.ProduccionPartidosTransmisione.hora_transmision | limitTo : 5 : 1}}</td>
							<td class="medio bordelados"></td>
							<td class="largo bordelados"></td>
							<td class="medio bordelados"></td>
							<td class="corto bordelados">Respaldo2</td>
							<td class="largo bordelados">{{transmision.Transmision.respaldo2_meta.puesta_marcha}}</td>
							<td class="corto bordelados">{{transmision.Transmision.senal_respaldo2_nombre}}</td>
							<td class="corto bordelados">{{transmision.Transmision.medio_respaldo2_nombre}}</td>
							<td class="medio bordelados">{{transmision.Transmision.respaldo2_meta.contacto}}</td>
							<td class="corto bordelados">{{transmision.Transmision.respaldo2_meta.recepcion}}</td>
							<td class="corto bordelados">{{transmision.Transmision.respaldo2_meta.anexo}}</td>
						</tr> 
						<tr class="partido_desc no-border">
							<td class="inicio bordelados"></td>
							<td class="largo bordelados"></td>
							<td class="vs bordelados bordelados"></td>
							<td class="medio bordelados"></td>
							<td class="largo bordelados"></td>
							<td class="medio bordelados"></td>
							<td class="corto bordelados">RADIO</td>
							<td class="largo bordelados">{{transmision.Transmision.radio_meta.puesta_marcha}}</td>
							<td class="corto bordelados">{{transmision.Transmision.senal_radio_nombre}}</td>
							<td class="corto bordelados">{{transmision.Transmision.medio_radio_nombre}}</td>
							<td class="medio bordelados">{{transmision.Transmision.radio.contacto}}</td>
							<td class="corto bordelados">{{transmision.Transmision.radio.recepcion}}</td>
							<td class="corto bordelados">{{transmision.Transmision.radio.anexo}}</td>
						</tr>						
					</table>
				</div>
			</div>
		</div>
	</div>
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
