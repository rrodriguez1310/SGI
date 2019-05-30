<div ng-controller="miDesempenoIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="margin-t-10">Evaluación de Desempeño CDF </h3>
			</div>
		</div>
		<div class="row margin-t-10">
			<div class="col-md-3">
				<div><h4><i class="fa fa-line-chart fa-lg margin-r-10"></i>Colaborador</h4></div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title" style="color: #fff !important"> <i class="fa fa-file-text-o margin-r-10"></i>Mi desempeño</h3>
					</div>
					<div class="panel panel-body" style="padding-bottom:0px !important">
						<div class="col-md-12 col-xs-12">
							<div class="img-circle img-fondo-100 center-block" ng-if="trabajador.foto" style="background-image:url({{trabajador.foto}})" width="100" height="100"></div>
						</div>
						<div class="col-md-12 col-xs-12 text-center">
							<div class="text-success"><h4>{{trabajador.nombre_completo}}</h4></div>
							<div>{{trabajador.cargo}}</div>
						</div>
						<div class="col-md-12 col-xs-12 text-center margin-t-10" ng-show="btnVerActual">
							<a class="btn btn-primary btn-md baja" href="<?php echo Router::url(array('controller' => 'evaluaciones_trabajadores', 'action' => 'view'));?>/{{evaluacionActual}}">Evaluación</a>	
						</div>
					</div>
				</div>
			</div>
			<div ng-show="tieneObjetivos" class="col-md-9">
				<div ng-show="ocdValidado"><h4>&nbsp;</h4></div>
				<div class="panel panel-default">					
					<div class="panel-heading" role="tab">
						<h4 class="panel-title">
							<i class="fa fa-file-text-o"></i>
							Objetivos Clave de Desempeño {{anioAEvaluar}}
						</h4>
					</div>					
					<div class="panel-body panel-collapse collapse in" id="collapseOne">
						<div ng-hide="ocdValidado">
							<h4>Instrucciones</h4>	
							<p>
								Estimado/a<br>
								Debes confirmar tus Objetivos Clave de Desempeño (OCD) {{anioAEvaluar}}.<br>
								Mucho éxito!
							</p>
						</div>
						<table class="table table-responsive table-hover table-responsive">
							<thead>
								<tr class="bg-success">
									<th class="col-md-1"></th>
									<th class="col-md-5 bold">Descripción</th>
									<th class="col-md-2 bold text-center">Indicador</th>
									<th class="col-md-2 bold text-center">Fecha Límite</th>
									<th class="col-md-2 bold text-center">Ponderación</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="objetivo in objetivos" ng-show="objetivo.estado==1">
									<td class="bold text-center">{{objetivo.nombre_objetivo}}</td>
									<td>{{objetivo.descripcion_objetivo}}</td>
									<td class="text-right">{{(objetivo.evaluaciones_unidad_objetivo_id==1)?objetivo.simbolo_indicador:''}} {{objetivo.indicador | number:1}} {{(objetivo.evaluaciones_unidad_objetivo_id>1)?objetivo.simbolo_indicador:''}}</td>
									<td class="text-center">{{objetivo.fecha_limite_objetivo | date:'dd-MM-yyyy'}}</td>
									<td class="text-center">{{objetivo.porcentaje_ponderacion}}%</td>
								</tr>
							</tbody>
						</table>
						<div class="text-center">
							<button ng-hide="ocdValidado" class="btn btn-success" confirmed-click="validarObjetivos()" ng-confirm-click="¿Deseas continuar?">
								<i class="fa fa-check"></i>
								Confirmar
							</button>
							<p ng-show="ocdValidado">&nbsp;</p>
						</div>
					</div>																			
				</div>
			</div>
			<div ng-class="">
				<div ng-class="(tieneObjetivos)? 'col-md-12': 'col-md-9'">
					<h4 class="margin-t-10">{{(tieneObjetivos)? 'Evaluaciones de Desempeño':''}}&nbsp;</h4>
				</div>
				<div ng-class="(tieneObjetivos)? 'col-md-12': 'col-md-9'">
					<div>
						<?php echo $this->element("botonera"); ?>					
						<div ui-i18n="{{lang}}">
							<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid" style="height:400px;"></div>
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
		'angularjs/controladores/evaluaciones_trabajadores/listar_evaluaciones',
		'angularjs/directivas/confirmacion',
		'angularjs/servicios/evaluaciones_objetivos/evaluaciones_objetivos',
		'angularjs/servicios/evaluaciones_trabajadores/evaluaciones'
	));
?> 