<div ng-controller="EvaluacionesAniosAdd">
	<div class="col-xs-12 col-sm-12  col-md-10 col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Nueva Evaluación de Desempeño</h3>
			</div>
			<div class="panel-body">
				<div class="row">					
					<div class=" col-md-9 col-lg-9">
						<form class="form-horizontal" name="evaluacionesAdd" novalidate>
							<div class="form-group">
								<label class="col-md-4 control-label baja" for="AnioEvaluado">Año Evaluación</label>
								<div class="col-md-8">				           		
									<input type="text" name="AnioEvaluado" class="form-control" placeholder="Ingrese año" maxlength="12" ng-model="formulario.EvaluacionesAnios.anio_evaluado" readonly="readonly">
								</div>
							</div>   							
							<div class="form-group" ng-class="{ 'has-error': !evaluacionesAdd.Fecha_Inicio_OCD.$valid }">
								<label class="col-md-4 control-label baja">Fecha Inicio OCD</label>
								<div class="col-md-8">
									<div class="input">
										<input type="text" name="Fecha_Inicio_OCD" id="Fecha_Inicio_OCD" class="form-control datepicker readonly-pointer-background" readonly="readonly" placeholder="Fecha inicio OCD" ng-model="formulario.EvaluacionesAnios.inicio_ocd">
									</div>
								</div>
							</div>	
							<div class="form-group" ng-class="{ 'has-error': !evaluacionesAdd.Fecha_Fin_OCD.$valid }">
								<label class="col-md-4 control-label baja">Fecha Fin OCD</label>
								<div class="col-md-8">
									<div class="input">
										<input type="text" name="Fecha_Fin_OCD" id="Fecha_Fin_OCD" class="form-control datepicker readonly-pointer-background" readonly="readonly" placeholder="Fecha término OCD" ng-model="formulario.EvaluacionesAnios.termino_ocd">
									</div>
								</div>
							</div>
							<div class="form-group" ng-class="{ 'has-error': !evaluacionesAdd.Fecha_Inicio_Evaluacion.$valid }">
								<label class="col-md-4 control-label baja">Fecha Inicio Evaluación</label>
								<div class="col-md-8">
									<div class="input">
										<input type="text" name="Fecha_Inicio_Evaluacion" id="Fecha_Inicio_Evaluacion" class="form-control datepicker readonly-pointer-background" readonly="readonly" placeholder="Fecha inicio evaluación" ng-model="formulario.EvaluacionesAnios.fecha_inicio">
									</div>
								</div>
							</div>
							<div class="form-group" ng-class="{ 'has-error': !evaluacionesAdd.Fecha_Fin_Evaluacion.$valid }">
								<label class="col-md-4 control-label baja">Fecha Término Evaluación</label>
								<div class="col-md-8">
									<div class="input">
										<input type="text" name="Fecha_Fin_Evaluacion" id="Fecha_Fin_Evaluacion" class="form-control datepicker readonly-pointer-background" readonly="readonly" placeholder="Fecha inicio evaluación" ng-model="formulario.EvaluacionesAnios.fecha_termino">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label baja" for="Estado_Nombre">Estado Evaluación Desempeño</label>
								<div class="col-md-8">				           		
									<input type="text" name="Estado_Nombre" class="form-control" placeholder="Ingrese año" ng-model="formulario.EvaluacionesAnios.estado_nombre" readonly="readonly">
								</div>
							</div> 
						</form>					
						<br><br>
					</div>
				</div>
				<div class="panel-footer">
					<button class="btn btn-primary btn-lg" ng-disabled="!evaluacionesAdd.$valid" ng-click="agregarAnioEvaluacion()"><i class="fa fa-pencil"></i> Guardar</button>
					<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/evaluaciones_trabajadores/evaluaciones_anios',
		'angularjs/servicios/evaluaciones_trabajadores/evaluaciones_anios',
		'bootstrap-datepicker',
		'rut'
	));
?>