<div ng-controller="catalogacionRequerimientosView" ng-cloak ng-init="requerimientoId(<?php echo $this->request->pass[0]; ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 text-center">
				<h3>Detalle Requerimiento</h3>
			</div>
			<div class="col-md-2">
				<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"catalogacion_requerimientos", "action"=>"index"), array("class"=>"btn btn-default pull-right", "escape"=>false)); ?>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title" style="color:#FFFFFF">Requerimiento</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4 text-right">
								<strong>Estado :</strong>
							</div>
							<div class="col-md-8 text-left">
								<strong ng-class="{'label label-danger': requerimiento.CatalogacionRequerimiento.estado == 0, 'label label-warning' : requerimiento.CatalogacionRequerimiento.estado == 1, 'label label-primary' : requerimiento.CatalogacionRequerimiento.estado == 2, 'label label-info' : requerimiento.CatalogacionRequerimiento.estado == 3, 'label label-success' : requerimiento.CatalogacionRequerimiento.estado == 4}">{{estadosRequerimientos[requerimiento.CatalogacionRequerimiento.estado]}}</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 text-right">
								<strong>Creado por :</strong>
							</div>
							<div class="col-md-8 text-left">
								<strong>{{requerimiento.User.nombre | uppercase}}</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 text-right">
								<strong>Fecha creación :</strong>
							</div>
							<div class="col-md-8 text-left">
								<strong>{{requerimiento.CatalogacionRequerimiento.created | date : 'dd/MM/yyyy HH:mm'}}</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 text-right">
								<strong>Fecha entrega :</strong>
							</div>
							<div class="col-md-8 text-left">
								<strong>{{requerimiento.CatalogacionRequerimiento.fecha_entrega | date : 'dd/MM/yyyy HH:mm' : "UTC"}}</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 text-right">
								<strong>Tipo requerimiento :</strong>
							</div>
							<div class="col-md-8 text-left">
								<strong>{{requerimiento.CatalogacionRTipo.nombre | uppercase}}</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 text-right">
								<strong>Detalle :</strong>
							</div>
						</div>
						<br />
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>Tipo</th>
									<th>Contenido</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="tag in requerimiento.CatalogacionRTag" ng-if="tag.estado==1">
									<td>{{tagTipos[tag.catalogacion_r_tags_tipo_id].nombre | uppercase }}</td>
									<td>{{tag.valor | uppercase}}</td>
								</tr>
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-4 text-right">
								<strong>Observación :</strong>
							</div>
						</div>						
						<br />
						<div class="col-md-12">
							<pre>{{requerimiento.CatalogacionRequerimiento.observacion}}</pre>	
						</div>
					</div>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title" style="color:#FFFFFF">Entrega</h3>
					</div>
					<div class="panel-body">
						<div ng-if="requerimiento.CatalogacionRDigitale.estado==1">
							<div class="row">
								<div class="col-md-4 text-right">
									<strong>Tipo :</strong>
								</div>
								<div class="col-md-8 text-left">
									Digital
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 text-right">
									<strong>Servidor :</strong>
								</div>
								<div class="col-md-8 text-left">
									{{ ingestaServidores[requerimiento.CatalogacionRDigitale.ingesta_servidore_id].nombre | uppercase }}
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 text-right">
									<strong>Ruta :</strong>
								</div>
								<div class="col-md-8 text-left">
									{{ requerimiento.CatalogacionRDigitale.ruta }}
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 text-right">
									<strong>Observación :</strong>
								</div>
							</div>
							<br />
							<div class="col-md-12">
								<pre>{{requerimiento.CatalogacionRDigitale.observacion}}</pre>
							</div>
						</div>
						<div ng-if="requerimiento.CatalogacionRFisico.estado==1">
							<div class="row">
								<div class="col-md-4 text-right">
									<strong>Fisico :</strong>
								</div>
								<div class="col-md-8 text-left">
									Digital
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 text-right">
									<strong>Soporte :</strong>
								</div>
								<div class="col-md-8 text-left">
									{{ soportes[requerimiento.CatalogacionRFisico.soporte_id].nombre | uppercase }}
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 text-right">
									<strong>Formato :</strong>
								</div>
								<div class="col-md-8 text-left">
									{{ formatos[requerimiento.CatalogacionRFisico.formato_id].nombre | uppercase }}
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 text-right">
									<strong>Copia :</strong>
								</div>
								<div class="col-md-8 text-left">
									{{ copias[requerimiento.CatalogacionRFisico.copia_id].copia | uppercase }}
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 text-right">
									<strong>Logo :</strong>
								</div>
								<div class="col-md-8 text-left">
									{{ requerimiento.CatalogacionRFisico.logo | uppercase }}
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 text-right">
									<strong>Posición logo :</strong>
								</div>
								<div class="col-md-8 text-left">
									{{ requerimiento.CatalogacionRFisico.logo_posicion | uppercase }}
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 text-right">
									<strong>Observación :</strong>
								</div>
							</div>
							<br />
							<div class="col-md-12">
								<pre>{{requerimiento.CatalogacionRFisico.observacion}}</pre>
							</div>
						</div>
					</div>
				</div>
				<!--div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title" style="color:#FFFFFF">Detalle</h3>
					</div>
					<div class="panel-body">
						
					</div>
				</div-->
				<div ng-if="requerimiento.CatalogacionRIngesta.length!=0">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" style="color:#FFFFFF">Ingesta</h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover table-condensed">
								<thead>
									<tr>
									<th>Nombre</th>
									<th>Reel</th>
									<th>Entrada</th>
									<th>Salida</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="ingesta in requerimiento.CatalogacionRIngesta" ng-if="ingesta.estado==1">
										<td>{{ingesta.nombre | uppercase }}</td>
										<td>{{ingesta.reel | uppercase}}</td>
										<td>{{ingesta.entrada | uppercase}}</td>
										<td>{{ingesta.salida | uppercase}}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="panel-footer">
							<div class="row">
								<div class="col-md-12 text-center">
									<?php echo $this->Html->link('<i class="fa fa-download"></i> Batch</a>', array("controller"=>"catalogacion_requerimientos", "action"=>"batch_ingesta",  $this->request->pass[0]), array("class"=>"btn btn-primary", "escape"=>false, 'target'=>'_blank')); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div ng-if="requerimiento.CatalogacionRequerimiento.estado==4 || requerimiento.CatalogacionRequerimiento.estado==0" ng-switch on="requerimiento.CatalogacionRequerimiento.estado">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title" style="color:#FFFFFF">
								<p ng-switch-when="4">Terminado</p>
								<p ng-switch-when="0">Eliminado</p>
							</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-4 text-right">
									<strong ng-switch-when="4">Observación termino :</strong>
									<strong ng-switch-when="0">Observación elimado :</strong>
								</div>
							</div>
							<br />
							<div class="col-md-12">
								<pre>{{requerimiento.CatalogacionRequerimiento.observacion_termino}}</pre>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
 	echo $this->Html->script(array(
 		"angularjs/controladores/app",
 		"angularjs/servicios/catalogacion_requerimientos/catalogacion_requerimientos",
 		"angularjs/factorias/copias/copias",
 		"angularjs/factorias/formatos/formatos",
 		"angularjs/factorias/soportes/soportes",
 		"angularjs/factorias/catalogacion_r_tipos/catalogacion_r_tipos",
 		"angularjs/controladores/catalogacion_requerimientos/catalogacion_requerimientos",
 		//"angularjs/modulos/select2/angular-select2.min",
 	)); 
?>