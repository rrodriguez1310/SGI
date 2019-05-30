<div ng-controller="EmpresasCtrl">
	<h4>Ingreso de Contratos:: <?php echo __($nombre["Company"]["nombre"])?></h4>

	<div class="col-md-12 bs-callout well well-sm">
		<?php echo $this->Form->create('CompaniesContrato', array('type' => 'file', "class"=>"form-horizontal", "name"=>"CompaniesContratoContratosAddForm")); ?>

		<legend>Detalle de  documento</legend>
		<?php echo $this->Form->hidden('id', array("type"=>"text", "ng-model"=>"id", "value"=>"{{id}}") ); ?>
		<?php echo $this->Form->hidden('company_id', array("type"=>"text", "default"=>$id) ); ?>
		<?php echo $this->Form->hidden('estado', array("ng-model"=>"estado", "default"=>"{{estado}}")); ?> 
		<?php echo $this->Form->hidden('terminado', array("default"=>"1")); ?>
		

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label baja">Tipo de Relación</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('company_type_id', array('label'=>false, 'class'=>'form-control', "options"=>$tipoContratos, "ng-model"=>"contratoTipo.selected")); ?>
			</div>
		</div>


		<div class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label baja">Fecha documento:</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('fecha_documento', array('label'=>false, 'class'=>'form-control', 'required'=>true, "ng-change"=>"verificaFecha({{id}})", "ng-model"=>"fechaDocumento", "default"=>"{{fechaDocumento}}")); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label baja">Fecha inicio:</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('fecha_inicio', array('label'=>false, 'class'=>'form-control', 'required'=>true, "ng-model"=>"fechaInicio")); ?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Fecha Término</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('fecha_termino', array('label'=>false, 'class'=>'form-control', 'required'=>true, "ng-model"=>"fechaTermino")); ?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Vencimiento</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('fecha_vencimiento', array('label'=>false, 'class'=>'form-control', 'required'=>true, "ng-model"=>"fechaVencimiento")); ?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">gerencias</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('gerencia_id', array('label'=>false, 'class'=>'form-control', "options"=>$gerencia, "ng-model"=>"gerencia.selected")); ?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Aviso termino</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('companies_aviso_termino_id', array('label'=>false, 'class'=>'form-control', "options"=>$avisoTermino, "ng-model"=>"avisoTerminoId.selected")); ?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Adjunto</label>
			<div class="col-sm-9">
				<?php echo $this->Form->file('adjunto', array('label'=>false)); ?><span class="label label-success" ng-show="nombreAdjunto">El archivo adjunto es : {{archivoAdjunto}}</span>
			</div>
		</div>

		<!--div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Email Dest.</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('notificacion_email', array('label'=>false, 'class'=>'form-control', 'required'=>true, "options"=>$emailTrabajador, "multiple"=>"multiple" , "ng-model"=>"notificacionEmail")); ?>
			</div>
		</div-->
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Email Dest.</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('notificacion_email', array("type"=>"email", 'label'=>false, 'class'=>'form-control', "pattern"=>"[a-z0-9._%+-]+@cdf.cl$", 'required'=>true, "ng-model"=>"notificacionEmail")); ?>
				<span class="label label-success">El dominio del email debe ser <b>@cdf.cl</b></span>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Descripción</label>
			<div class="col-sm-9">
				<?php echo $this->Form->input('observacion', array('label'=>false, 'class'=>'form-control', 'required'=>true, "ng-model"=>"observacion")); ?>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="form-group">
				<legend>Renovación automatica de contratos</legend>
				
				<div class="radio">
					<label>
						<input type="radio" name="CompaniesContrato[companies_renovacion_automatica_id]" ng-model="tipoContrato" ng-checked="status" value="1" required>
						Sin renovación automática
					</label>
				</div>

				<div class="radio">
					<label>
						<input type="radio" name="CompaniesContrato[companies_renovacion_automatica_id]" ng-model="tipoContrato" value="2" required>
						Renovación por un año sucesivo
					</label>
				</div>

				<div class="radio">
					<label>
						<input type="radio" name="CompaniesContrato[companies_renovacion_automatica_id]" ng-model="tipoContrato" value="3" required>
						Por iguales períodos sucesivos
					</label>
				</div>
			</div>
		</div>
			<button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> {{tipoForm}}</button>
			<button type="button" class="btn btn-danger btn-lg" ng-click="limpiarForm()"><i class="fa fa-refresh"></i> Limpiar Formulario</button>
		<!--button class="button" ng-click="reset()">Reset</button-->
		<?php $this->form->end()?>
	</div>
	<div class="col-md-12">
		<legend>Lista de documentos</legend>
		<p ng-bind-html="cargador" ng-show="loader"></p>
		<?php echo $this->element('botonera'); ?>
		<div ng-show="tablaDetalle">
			<div ui-grid="gridOptions" class="grid" ui-grid-selection></div>
		</div>
		
	</div>
	<modal visible="showModal">
		<table class="table table-striped">
			<tbody>
				<tr>
					<td><strong>Nombre Emprea:</strong></td>
					<td><strong>{{empresaModal}}</strong></td>
				</tr>
				<tr>
					<td><strong>Fecha inicio contrato:</strong></td>
					<td><strong>{{fechaInicioModal}}</strong></td>
				</tr>
				<tr>
					<td><strong>Fecha termino contrato:</strong></td>
					<td><strong>{{fechaTerminoModal}}</strong></td>
				</tr>

				<tr>
					<td><strong>Fecha vencimiento contrato:</strong></td>
					<td><strong>{{fechaVencimientoModal}}</strong></td>
				</tr>

				<tr>
					<td><strong>Gerencia:</strong></td>
					<td><strong>{{gerenciaModal}}</strong></td>
				</tr>

				<tr>
					<td><strong>Aviso termino:</strong></td>
					<td><strong>{{avisoTerminoModal}} días</strong></td>
				</tr>

				<tr>
					<td><strong>Notificación email:</strong></td>
					<td><strong>{{notificacionEmailModal}}</strong></td>
				</tr>

				<tr>
					<td><strong>Tipo renovación:</strong></td>
					<td><strong>{{renovacionModal}}</strong></td>
				</tr>
				<tr>
					<td><strong>Observación:</strong></td>
					<td><strong>{{observacionModal}}</strong></td>
				</tr>
				<tr>
					<td><strong>Ver contrato:</strong></td>
					<td><a href="<?php echo $this->webroot ?>files/contrato_empresas/{{adjuntoModal}} " target="_blank"><i class="fa fa-external-link"></i></a></td>
				</tr>
			</tbody>
		</table>
		<div class="modal-footer">
	        <button type="button" class="btn btn-default" ng-click="cerrarModal()" data-dismiss="modal">Cerrar</button>
	    </div>
	</modal>
</div>
<?php
	echo $this->Html->script(array(
		'select2.min',
		'bootstrap-datepicker',
		'angularjs/controladores/app',
		'angularjs/servicios/empresas/empresas',
		'angularjs/controladores/empresas/empresas',
		'angularjs/directivas/confirmacion',
		'angularjs/directivas/modal/modal',
	));
?>
<script>
	$('#CompaniesContratoFechaInicio, #CompaniesContratoFechaTermino, #CompaniesContratoFechaVencimiento, #CompaniesContratoFechaDocumento').datepicker({
		    format: "yyyy-mm-dd",
		    //startView: 1,
		    language: "es",
		    multidate: false,
		   // daysOfWeekDisabled: "0, 6",
		    autoclose: true,
		   viewMode: "week",
		   Default: false
	});
	
	$("#CompaniesContratoFechaTermino").change(function(){
		$("#CompaniesContratoFechaVencimiento").val($(this).val());
	});
</script>