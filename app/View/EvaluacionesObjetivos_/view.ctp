<style>
.table>tbody+tbody {border-top: 0px solid #ddd}
input {margin-top: 0px;}
</style>
<div ng-controller="objetivosEdit" ng-init="datosObjetivos(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?><?php if(isset($this->request->pass[1])){ echo ','.$this->request->pass[1]; }?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="objetivos"> 
		<div class="row">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title" ng-hide="pasoCalibrar||pasoAgendar||pasoDialogo||pasoAgendarCita">
						<div style="display:inline">
							<div class="text-primary bold">
								<i class="fa fa-futbol-o fa-lg margin-r-10"></i>
								Detalle Objetivos Clave de Desempe&ntilde;o (OCD) {{anioObjetivo}}
							</div>
						</div>
					</h3>
				</div>
				<div class="panel-body">			
					<div class="panel panel-primary">
						<div class="panel-heading" role="tab">
							<h4 class="panel-title">
								<i class="fa fa-user fa-lg margin-r-10"></i>									
								Datos Colaborador									
							</h4>
						</div>
						<div class="panel-body" id="collapseOne">
							<div class="table-responsive col-md-10">									
								<table class="table table-condensed animate-if" style="margin-bottom: 0 !important">
									<thead>
										<tr>
											<td class="col-md-3 text-right text-primary"> <b>Nombre Colaborador</b> </td>
											<td class="col-md-7"><b>{{trabajador.nombre}}</b></td>
										</tr>
									</thead>
									<tr>
										<th class="col-md-3 text-right  text-primary">Cargo</th>
										<td class="col-md-7">{{trabajador.cargo}}</td>
									</tr>
									<tr>
										<th class="col-md-3 text-right  text-primary">
											<div class="has-warning">Familia Cargos</div>
										</th>
										<td class="col-md-7">{{trabajador.familia_cargo}}</td>
									</tr>
									<tr>
										<th class="col-md-3 text-right  text-primary">Jefatura</th>
										<td class="col-md-7">{{trabajador.jefatura}}</td>
									</tr>
								</table>									
							</div>
						</div>
					</div>
					<!-- objetivos -->
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title"> <i class="fa fa-file-text-o fa-lg margin-r-10"></i> Objetivos Clave de Desempe&ntilde;o (OCD) </h4>
						</div>
						<div class="panel-body">								
							<form class="form-horizontal" name="objetivosEdit" novalidate>
								<div class="col-md-12 bg-success table-responsive" style="padding-top:8px;padding-bottom:8px;border-bottom:1px solid #ddd">
									<div class="col-md-1"></div>
									<div class="bold col-md-5">Descripci&oacute;n</div>
									<div class="col-md-2 bold">Indicador</div>
									<div class="col-md-2 bold">Fecha L&iacute;mite</div>
									<div class="bold col-md-2">Ponderaci&oacute;n</div>
								</div>									
								<div>
									<div ng-repeat="objetivo in objetivos" class="col-md-12 container-fluid" style="padding-top: 8px;padding-bottom: 16px;border-bottom: 1px solid #ddd"
										ng-show="formulario.EvaluacionesObjetivo[$index].estado==1">
										<div>
											<div class="col-md-1"><b>{{objetivo.nombre_objetivo}}</b></div>
											<div class="col-md-5">{{formulario.EvaluacionesObjetivo[$index].descripcion_objetivo}}</div>
											<div class="col-md-2 text-right">
												{{(formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id==1)? simboloUnidad[$index] :''}} 
												{{formulario.EvaluacionesObjetivo[$index].indicador | number:1}} 
												{{(formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id>1)? simboloUnidad[$index] :''}}
											</div>
											<div class="col-md-2">
												<div class="text-left">{{formulario.EvaluacionesObjetivo[$index].fecha_limite_objetivo}}</div>
											</div>
											<div class="col-md-2 text-left">
												{{formulario.EvaluacionesObjetivo[$index].porcentaje_ponderacion}}%
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 bg-success table-responsive" style="padding-top: 8px">
									<div class="col-md-10 col-xs-10 bold">Total</div>
									<div class="col-md-2 col-xs-2 text-left bold">
										<p ng-class="{'error' : (totalPonderado!=limitPonderado)}">
											{{totalPonderado}}% 
										</p>
									</div>
								</div>
								<p>&nbsp;</p>
								<div class="hide" name="plantillaFinal">
									<?php echo $this->element('imprimir/evaluaciones_objetivos/objetivos_final'); ?>
								</div>
							</form>
						</div><!-- panel-body -->
					</div>	<!-- panel-default -->
					<!-- EJECUTIVO BCI aldo barbera -->
					<div>
						<a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-md center">
							<i class="fa fa-mail-reply-all"></i> Volver
						</a>
					</div>
				</div>									
			</div>		

		</div>	
	</div>
</div>
<?php 

echo $this->Html->script(array(	
	'angularjs/controladores/app',
	'angularjs/servicios/evaluaciones_objetivos/evaluaciones_objetivos',
	'angularjs/controladores/evaluaciones_objetivos/evaluaciones_objetivos',
	'angularjs/directivas/number_format',
	'angularjs/directivas/confirmacion',
	'bootstrap-datepicker',	
	'bootstrap-clockpicker.min'
	));
?>
