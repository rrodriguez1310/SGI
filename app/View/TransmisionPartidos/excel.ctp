 <style>input {margin-top: 0px;}</style>
<div ng-controller="TransmisionControllerExcel" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="row" ng-show="!loader">
		<div class="col-sm-12">
			<h4>Transmisión de Partidos</h4>
			<style>
					#cuerpoHtmlTabla{margin-top:25px;}
					input {margin-top: 0px;}
					table.partidos{
						width:100%;
						color:#292f33;
						font-size:10px;
						font-family:arial,sans-serif;
						text-align:left;
					 	/*table-layout: fixed !important;*/}
					 	.center{text-align: center !important;}
				</style>
			<div id="cuerpoHtmlTabla">
				<?php
				//pr($partidos);exit;
				$count = 0;
				foreach($partidos as $id => $partido){
				?>
				<table class="partidos" nobr="true" border="1">
					<?php if($count == 0){ ?>
					<tr class="campeonato">
						<td></td>
						<td colspan="5" class="center">
							<strong>CAMPEONATO <?php echo $campeonatos;?></strong>
						</td>						
						<td></td>
						<td colspan="3" class="center"><strong>PROGRAMACIÓN DE TRANSMISIONES CLARO</strong></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<th></th>
						<th class="equipo">Local</th>
						<th class=""></th>
						<th class="equipo">Visita</th>
						<th>Estadio</th>
						<th>Campeonato</th>
						<th>Señal</th>
						<th>Horario de puesta en marcha</th>
						<th>OPERACIÓN</th>
						<th>Medio de Tx</th>
						<th>Contacto Estadio</th>
						<th>Recepcion de señal en CDF</th>
						<th>Anexo</th>
					</tr>
					<?php } ?>
					<tr>
						<td class="inicio"><?php echo $partido['ProduccionPartidosEvento']['id'];?></td>
						<td><?php echo $partido['Equipo']['nombre'];?></td>
						<td class="center">v/s</td>
						<td><?php echo $partido['EquipoVisita']['nombre'];?></td>
						<td><?php echo $partido['estadio']['nombre'];?></td>
						<td><?php echo $partido['campeonato']['nombre_prefijo'];?></td>
						<td>Principal</td>
						<td></td>
						<td></td>
						<td><?php echo $partido['Transmision']['senal_principal_nombre'];?></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><?php echo $partido['ProduccionPartidosEvento']['fecha_string'];?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>Respaldo</td>
						<td></td>
						<td></td>
						<td><?php echo $partido['Transmision']['senal_respaldo_nombre'];?></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td>Inicio Tx</td>
						<td class="center"><?php echo substr($partido['ProduccionPartidosTransmisione']['hora_transmision'],0,5);?></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $partido['Transmision']['senal_radio_nombre'] !== "" ? "RADIO" : "";?></td>
						<td></td>
						<td></td>
						<td><?php echo $partido['Transmision']['senal_radio_nombre'] !== "" ? $partido['Transmision']['senal_radio_nombre'] : "";?></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="13"></td>
					</tr>
				</table>
				<?php 
				$count++;
				} //endforeach ?>
				<br />
			</div>
		</div>
	</div>	
</div>

