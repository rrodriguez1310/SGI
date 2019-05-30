<style>
.container{ width: 1350px; }
input {margin-top: 0px;}
</style>
	<div class="print" ng-controller="controllerSolicitudesViaticos" >
	
		<p class="mayuscula">Titulo : <?=$data['datosViatico']['titulo'] ?></p>
			<div class="col-md-12">
				<div class="row clearfix">
					<div class="col-md-4 column">
						<div class="panel panel-default">
		  				<!-- Default panel contents -->
		  					<div class="panel-heading"><Strong>Creador</Strong></div>
							<!-- List group -->
							<ul class="list-group">
		  						<li class="list-group-item " title="Creador">Creador: <span class="mayuscula"><?=$data['datosViatico']['usuario']?></span></li>
		  						<li class="list-group-item list-group-item-success" title="Fecha inicio">Fecha inicio: <?=$data['datosViatico']['fecha_inicio']?></li>
								<li class="list-group-item list-group-item-success" title="Fecha termino">Fecha termino: <?=$data['datosViatico']['fecha_termino']?></li>
		  						<li class="list-group-item" title="Estado">Estado:

										<span  data-toggle="tooltip" data-placement="top" title=""><?=$data['datosViatico']['estado']?></span>
		  						</li>
		  						<li class="list-group-item list-group-item-success" title="Fecha creación">N° Documento: <?=$data['datosViatico']['n_documento']?></li>
							</ul>
						</div>
					</div>

					<div class="col-md-4 column">
					
					
					
					
						<div class="panel panel-default">
							<!-- Default panel contents -->
							<div class="panel-heading"><Strong>Información Rendición Viáticos</Strong></div>
							<!-- List group -->
								<li class="list-group-item">Tipo de cambio: <?=$data['datosViatico']['estado'] ?></li>
								<li class="list-group-item">Moneda: <?=$data['datosViatico']['moneda']?></li>
								<li class="list-group-item">Total: <?php
								
								$Total = 0;
								foreach($data['listaDetalle'] as $k => $j){
								
									$Total  = $Total  +	$j['SolicitudDetalleViatico']['monto'];
									
	
								}	
								echo number_format($Total,0,",",".");
								
								?></li>
								<li class="list-group-item">Archivo:
									<?php 
									 $arrayDoc = explode(",", $data['datosViatico']['url_documento']); 
									 for($i=0;$i<count($arrayDoc);$i++){
										 $arhivo = basename($arrayDoc[$i]);
										 if($arhivo!=''){

											echo "<div class='row'>";
												echo "<a href=".acortarurl($arrayDoc[$i])." target='_blank'>$arhivo</a>";
											echo "</div>";
										}
									 }
									
									?>
								</li>
							</ul>
						</div>
					</div>
					
                    <?php if($data['datosViatico']['programacion_partido'] != '-') : ?>
                        <div class="col-md-4 column">
                            <div class="panel panel-default">
                                <div class="panel-heading"><Strong>Produccion Partido</Strong></div>
                                <ul class="list-group">
                                    <li class="list-group-item" title="Creador">Nombre: <span class="mayuscula"><?= $data['datosViatico']['programacion_partido']['nombre_torneo']; ?></span></li>
                                    <li class="list-group-item" title="Creador">fecha: <span class="mayuscula"><?= $data['datosViatico']['programacion_partido']['fecha_partido']; ?></span></li>
                                    <li class="list-group-item" title="Fecha inicio">Equipo local: <?= $data['datosViatico']['programacion_partido']['equipo_local']; ?></li>
                                    <li class="list-group-item" title="Fecha termino">Equipo visita: <?= $data['datosViatico']['programacion_partido']['equipo_visita']; ?></li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                 
					
					<div class="col-md-12 column">
						<div class="panel panel-default">
		  					<div class="panel-heading"><Strong>Observación</Strong></div>
							<ul class="list-group">
		  						<li class="list-group-item" title="Creador"><?=$data['datosViatico']['observacion']?></li>
							</ul>
						</div>
					</div>
					
				</div>
								
			</div>
				<br/>
			<div style="width:100%; overflow:auto;">
				<span id="codigo_sap"></span>
				<!--input type="hidden" id="idRequerimiento" value="<?php //echo $id; ?>" name="idRequerimiento"-->
				<table class="table table-striped table-bordered ">
					<thead>

						<tr>
							<th>Descripcion</th>
							<th>Colaborador</th>
							<th>Monto</th>
							<th>Gerencia</th>
							<th>Estadio</th>
							<th>Contenido</th>
							<th>Canales de distribución</th>
							<th>Otros</th>
							<th>Proyectos</th>
							<th>Codigo presupuestario</th>					
						</tr>
						
					</thead>
					<tbody>
					
						<?php

						//pr($listaRendicionFondo);
							foreach($data['listaDetalle'] as $k => $j){
								echo "<tr>";
								echo "<td>".$j['SolicitudDetalleViatico']['descripcion']."</td>";
								echo "<td>".$j['SolicitudDetalleViatico']['colaborador']."</td>";
								echo "<td>".number_format($j['SolicitudDetalleViatico']['monto'],0,',','.')."</td>";
								echo "<td>".$j['SolicitudDetalleViatico']['gerencia']."</td>";
								echo "<td>".$j['SolicitudDetalleViatico']['estadio']."</td>";
								echo "<td>".$j['SolicitudDetalleViatico']['contenido']."</td>";
								echo "<td>".$j['SolicitudDetalleViatico']['canales_distribucion']."</td>";
								echo "<td>".$j['SolicitudDetalleViatico']['otros']."</td>";
								echo "<td>".$j['SolicitudDetalleViatico']['proyectos']."</td>";
								echo "<td>".$j['SolicitudDetalleViatico']['codigo_presupuestario']."</td>";
								echo "<tr>";

							}	
						?>
					
					</tbody>
				</table>	
			</div>


	<div style="margin-left:15px">
		<div class="row">
			<a href="<?php echo $this->Html->url(array("action"=>"index"));?>"  class="btn btn-info btn-mx">
				<i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
			</div>
		</div>
	</div>
</div>


	

<?php
	function acortarurl($url){
		$uris = explode("html", $url);
		return $uris[1];
	}
       
		echo $this->Html->script(array(
			'angularjs/controladores/app',
			'angularjs/servicios/solicitudes_rendicion_viaticos/solicitudesRendicionViaticos',
			'angularjs/controladores/solicitudes_rendicion_viaticos/solicitudesRendiconViaticos'
		));
	?>

