<div class="col-xs-12 col-sm-12 col-md-12">
  <p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="row" ng-show="evaluacion">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">
					<div class="text-info">
						<i class="fa fa-cogs" aria-hidden="true"></i>
						Producción de partidos
					</div>
				</h3>
			</div>
			<div class="panel-body">
				<div class="">
					<h5 class="bold">Información del Partido</h5>
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<tr> 
								<th>Campeonato</th>
								<td><?php echo $data["Campeonato"]["nombre"]?></td>
								<th>Categoria</th>
								<td><?php echo isset($data["Categoria"]["nombre"])? $data["Categoria"]["nombre"]:'-'?></td>
								<th>Subcategoria</th>
								<td><?php echo isset($data["Subcategoria"]["nombre"])? $data["Subcategoria"]["nombre"]:'-'?></td>
							</tr>
							<tr>
								<th>Equipo Local</th>
								<td><?php echo $data["Equipo"]["nombre_marcador"]?></td>
								<th> Equipo Visita</th>
								<td><?php echo $data["EquipoVisita"]["nombre_marcador"]?></td>
								<th>Estadio</th>
								<td>
									<?php 
										if ($data["Estadio"]["nombre"] == 'POR CONFIRMAR') {
											echo $data["Estadio"]["nombre"];
										}
										else {
											echo $data["Estadio"]["nombre"] . ',<br>' . $data["Estadio"]["ciudad"] . ', ' . $data["Estadio"]["region_ordinal"];
										}
									?> 
								</td>
							</tr>
							<tr>
								<th>Fecha Partido</th>
								<td><?php echo $data["ProduccionPartidosEvento"]["fecha_partido"]?> </td>
								<th>Hora Partido</th>
								<td> <?php echo $data["ProduccionPartidosEvento"]["hora_partido"]?> Local - <?php echo substr($data["ProduccionPartidosEvento"]["hora_partido_gmt"],0,5);?> GMT</td>
							</tr>
						</table>
						<table class="table table-bordered table-hover">
							<tr>
								<th class="col-md-3">Transmisión Partido</th>
								<td class="col-md-3"><?php echo $data["ProduccionPartidosTransmisione"]["TipoTransmisione"]["nombre"]; ?></td>
								<th class="col-md-3">Señales</th>
								<td class="col-md-3"><?php echo $data["ProduccionPartidosTransmisione"]["senales"]; ?></td>
							</tr>
							<tr>
								<th>Inicio de Transmisión</th>
								<td><?php echo substr($data["ProduccionPartidosTransmisione"]["hora_transmision"], 0,5) ?> Local - <?php echo substr($data["ProduccionPartidosTransmisione"]["hora_transmision_gmt"], 0,5) ?> GMT</td>
								<th>Producción Técnica</th>
								<td><?php echo $data["ProduccionPartidosTransmisione"]["proveedor"] .' - '. $data["ProduccionPartidosTransmisione"]["TransmisionesMovile"]["nombre"]; ?></td>
							</tr>
							<tr>
								<th>Fin Aprox. Transmisión</th>
								<td><?php echo substr($data["ProduccionPartidosTransmisione"]["hora_termino_transmision"], 0,5) ?> Local - <?php echo substr($data["ProduccionPartidosTransmisione"]["hora_termino_transmision_gmt"], 0,5) ?> GMT</td>	
								<th>Nro. Cámaras</th>
								<td><?php echo isset($data["ProduccionPartidosTransmisione"]["numero_camaras"])? $data["ProduccionPartidosTransmisione"]["numero_camaras"] : '-'?></td>	
							</tr>
							<tr>
								<th>Nro. Partido</th>
								<td><?php echo isset($data["ProduccionPartidosTransmisione"]["NumeroPartido"]["nombre"])? $data["ProduccionPartidosTransmisione"]["NumeroPartido"]["nombre"]:'-'; ?></td>
								<th>Observación</th>
								<td><?php echo $data["ProduccionPartidosEvento"]["transmision"]; ?></td>
							</tr>
							<tr>
								<th>Estado Producción</th>
								<td>
									<button type="button" class="btn btn-xs sube <?php echo ($data["ProduccionPartidosEvento"]["estado_produccion"]==2)?'btn-success':'btn-warning'; ?>" 
									style="cursor:default"><?php echo ($data["ProduccionPartidosEvento"]["estado_produccion"]==2)? 'Completo': 'Planificando' ?></button>
								</td>
							</tr>
						</table>
					</div>
				</div>				
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title text-default">
							Responsables Externos
						</h4>
					</div>
					<div class="panel-body">
						<div class="row margin-b-10 col-md-12">						
							<div class="col-md-4">
								<div class="bold">Director</div>
								<div><?php echo $data["ProduccionPartidosChilefilm"]["director"]; ?></div>
							</div>
							<div class="col-md-4">
								<div class="bold">Asistente de Dirección</div>
								<div><?php echo $data["ProduccionPartidosChilefilm"]["asist_direccion"]; ?></div>
							</div>
							<div class="col-md-4">
								<div class="bold">Productor</div>
								<div><?php echo $data["ProduccionPartidosChilefilm"]["productor"]; ?></div>
							</div>							
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title text-default">
							Responsables CDF
						</h4>
					</div>
					<div class="panel-body">
						<div class="row margin-b-10 col-md-12">
							<div class="col-md-4">
								<div class="bold">Productor</div>
								<div><?php echo $data["ProduccionPartido"]["productor"]; ?></div>
							</div>
							<div class="col-md-4">
								<div class="bold">Asistente de Producción</div>
								<div><?php echo $data["ProduccionPartido"]["asist_produccion"]; ?></div>
							</div>
							<div class="col-md-4">
								<div class="bold">Coordinador Periodístico</div>
								<div><?php echo $data["ProduccionPartido"]["coordinador_periodistico"]; ?></div>
							</div>
							
						</div>
						
						<div class="row margin-b-10 col-md-12">
							<div class="col-md-4">
								<div class="bold">Relator</div>
								<div><?php echo $data["ProduccionPartido"]["relator"]; ?></div>
							</div>
							<div class="col-md-4">
								<div class="bold">Comentarista</div>
								<div><?php echo $data["ProduccionPartido"]["comentarista"]; ?></div>
							</div>
							<div class="col-md-4">
								<div class="bold">Periodista</div>
								<div><?php echo $data["ProduccionPartido"]["periodistas"]; ?></div>
							</div>
						</div>
						<div class="row margin-b-10 col-md-12">	
							<div class="col-md-4">
								<div class="bold">Locutor</div>
								<div><?php echo $data["ProduccionPartido"]["locutor"]; ?></div>
							</div>
							<div class="col-md-4">
								<div class="bold">Musicalizador</div>
								<div><?php echo $data["ProduccionPartido"]["musicalizador"]; ?></div>
							</div>
							<div class="col-md-4">
								<div class="bold">Operador Trackvision</div>
								<div><?php echo $data["ProduccionPartido"]["operador_trackvision"]; ?></div>
							</div>
						</div>		
						<div class="col-md-12">&nbsp;</div>
						<table class="table table-bordered table-hover">
							<tr> 
								<th>Terno</th>
								<td><?php echo $data["ProduccionPartido"]["ProduccionTerno"]["nombre"]?></td>
								<th>Camisa</th>
								<td><?php echo $data["ProduccionPartido"]["ProduccionCamisa"]["nombre"]?></td>
								<th>Corbata</th>
								<td><?php echo $data["ProduccionPartido"]["ProduccionCorbata"]["nombre"]?></td>
							</tr>
						</table>
					</div>

				</div>
				<div class="text-center">
					<a href="<?php echo $this->request->referer(); ?>" class="btn btn-lg btn-default btn-md center margin-t-10">
						<i class="fa fa-mail-reply-all"></i>  Volver
					</a>
					<button class="btn btn-success btn-lg imprimirPlantilla">
					 	<i class="fa fa-print"></i>
						Imprimir
					</button>
				</div>
			</div>
		</div>

		<div id="plantilla" class="hide">
			<label style="width:100%;text-align:center">
				<center><b>PRODUCCION DE PARTIDOS</b></center>
			</label>
			<div style="font-size:11px">
				<p><b><label style="border-bottom: 1px solid #000">DETALLE PARTIDO</label></b></p>

				<table border="1" cellpadding="3" style="width:100%">
					<tr>
						<th width="23%" style="background-color:#CED8F6;color:#2E2E2E;"><b>Campeonato</b></th>
						<td width="77%"><?php echo $data["Campeonato"]["nombre"] .' '. $data["Categoria"]["nombre"] .' '.$data["Subcategoria"]["nombre"]?></td>
					</tr>
					<tr>
						<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Local</b></th>
						<td><?php echo $data["Equipo"]["nombre_marcador"]?></td>
					</tr>
					<tr>
						<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Visita</b></th>
						<td><?php echo $data["EquipoVisita"]["nombre_marcador"]?></td>
					</tr>
					<tr>
						<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Estadio</b></th>
						<td><?php echo $data["Estadio"]["nombre"] . ', ' . $data["Estadio"]["ciudad"] . ', ' . $data["Estadio"]["region_ordinal"]?></td>
					</tr>

					<tr>
						<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Fecha Partido</b> </th>
						<td><?php echo $data["ProduccionPartidosEvento"]["fecha_partido"];?></td>
					</tr>
					<tr>
						<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Hora Partido</b> </th>
						<td><?php echo $data["ProduccionPartidosEvento"]["hora_partido"].' Local - '.substr($data["ProduccionPartidosEvento"]["hora_partido_gmt"],0,5) . ' GMT'; ?></td>
					</tr>
				</table>

				<table border="1" cellpadding="3" style="width:100%">
					<tr>
						<th width="23%" style="background-color:#CED8F6;color:#2E2E2E;"><b>Transmisión Partido</b></th>
						<td width="29%"><?php echo substr($data["ProduccionPartidosTransmisione"]["TipoTransmisione"]["nombre"], 0,5) ?></td>
						<th width="19%" style="background-color:#CED8F6;color:#2E2E2E;"><b>Señales</b></th>
						<td width="29%"><?php echo $data["ProduccionPartidosTransmisione"]["senales"]; ?></td>
					</tr>
					<tr>
						<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Inicio de Transmisión</b></th>
						<td><?php echo substr($data["ProduccionPartidosTransmisione"]["hora_transmision"], 0,5) .' Local - '. substr($data["ProduccionPartidosTransmisione"]["hora_transmision_gmt"], 0,5).' GMT'; ?></td>
						<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Producción Técnica</b></th>
						<td><?php echo $data["ProduccionPartidosTransmisione"]["proveedor"] .' - '. $data["ProduccionPartidosTransmisione"]["TransmisionesMovile"]["nombre"]; ?></td>
					</tr>
					<tr>
						<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Fin Aprox. Transmisión</b></th>
						<td><?php echo substr($data["ProduccionPartidosTransmisione"]["hora_termino_transmision"], 0,5).' Local - '.substr($data["ProduccionPartidosTransmisione"]["hora_termino_transmision_gmt"], 0,5). ' GMT' ?></td>
						<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Nro. Cámaras</b></th>
						<td colspan="5"><?php echo $data["ProduccionPartidosTransmisione"]["numero_camaras"] ?></td>
					</tr>
					<tr>
						<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Nro. Partido</b></th>
						<td><?php echo $data["ProduccionPartidosTransmisione"]["NumeroPartido"]["nombre"]; ?></td>
						<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Observación</b></th>
						<td colspan="5"><?php echo $data["ProduccionPartidosEvento"]["transmision"] ?></td>
					</tr>
				</table>
				<label>&nbsp;</label>

				<p><b><label style="border-bottom: 1px solid #000">RESPONSABLES EXTERNOS</label></b></p>
				
					<table cellpadding="3" style="width:100%">
						<tr>
							<td>
								<label><b>Productor</b></label>
								<div><?php echo $data["ProduccionPartidosChilefilm"]["productor"]; ?></div>
							</td>
							<td><label><b>Asistente de Dirección</b></label>
								<div><?php echo $data["ProduccionPartidosChilefilm"]["asist_direccion"]; ?></div>
							</td>
							<td>
								<label><b>Productor</b></label>
								<div><?php echo $data["ProduccionPartidosChilefilm"]["productor"]; ?></div>
							</td>
						</tr>
					</table>

					<label>&nbsp;</label>
					<p><b><label style="border-bottom: 1px solid #000">RESPONSABLES CDF</label></b></p>
					<table cellpadding="3" style="width:100%">
						<tr>
							<td>
								<label><b>Productor</b></label>
								<div><?php echo $data["ProduccionPartido"]["productor"]; ?></div>						
							</td>
							<td>
								<label><b>Asistente de Producción</b></label>
								<div><?php echo $data["ProduccionPartido"]["asist_produccion"]; ?></div>
							</td>
							<td>
								<label><b>Coordinador Periodístico</b></label>
								<div><?php echo $data["ProduccionPartido"]["coordinador_periodistico"]; ?></div>
							</td>
						</tr>
						<tr>
							<td>
								<label><b>Relator</b></label>
								<div><?php echo $data["ProduccionPartido"]["relator"]; ?></div>
							</td>
							<td>
								<label><b>Comentarista</b></label>
								<div><?php echo $data["ProduccionPartido"]["comentarista"]; ?></div>							
							</td>
							<td>
								<label><b>Periodista</b></label>
								<div><?php echo $data["ProduccionPartido"]["periodistas"]; ?></div>
							</td>
						</tr>
						<tr>
							<td>
								<label><b>Locutor</b></label>
								<div><?php echo $data["ProduccionPartido"]["locutor"]; ?></div>							
							</td>
							<td>
								<label><b>Musicalizador</b></label>
								<div><?php echo $data["ProduccionPartido"]["musicalizador"]; ?></div>
							</td>
							<td>
								<label><b>Operador Trackvision</b></label>
								<div><?php echo $data["ProduccionPartido"]["operador_trackvision"]; ?></div>
							</td>
						</tr>
					</table>
					<label>&nbsp;</label>
					<p><b><label style="border-bottom: 1px solid #000">VESTUARIO</label></b></p>
					<table border="1" cellpadding="3" style="width:100%">
						<tr>
							<th style="background-color:#CED8F6;color:#2E2E2E;" width="23%"><b>Terno</b></th>
							<td ><?php echo $data["ProduccionPartido"]["ProduccionTerno"]["nombre"]?></td>
						</tr>
						<tr>
							<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Camisa</b></th>
							<td><?php echo $data["ProduccionPartido"]["ProduccionCamisa"]["nombre"]?></td>
						</tr>
						<tr>
							<th style="background-color:#CED8F6;color:#2E2E2E;"><b>Corbata</b></th>
							<td><?php echo $data["ProduccionPartido"]["ProduccionCorbata"]["nombre"]?></td>
						</tr>
					</table>
				<label>&nbsp;</label>
			</div>
		</div>
	</div>
</div>
<script>
	$(".imprimirPlantilla").click(function(){       
        parametros = {
            "nombre": "produccion_partido.pdf", 
            "html"  : $("#plantilla").html(),
            "controlador": "produccion_partidos",
            "carpeta": "partidos"
        }
        $.ajax({ type: "POST",
		    url:"<?php echo $this->Html->url(array('controller'=>'servicios', 'action'=>'pdf_basico2'))?>",
		    data:parametros,
		    success: function(data){	
		    	window.open(data);
		    }		    
		});
    });
</script>
