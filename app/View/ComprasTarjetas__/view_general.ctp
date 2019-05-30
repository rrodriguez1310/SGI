
<div ng-controller="controllerGeneralCompras">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<?php echo $this->element('botonera'); ?>
	<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-edit ui-grid-cellnav class="grid"></div>
	<modal visible="showModalRecurrencia">
		<div class="row"> 
			<div class="col-md-12">
			<h4>Datos recurrencia</h4>
			</div>
		</div>
		<form name="recurrencia" novalidate>
			<?php echo $this->Form->input('id', array(
				'type'=>'hidden',
				'class'=>'form-control', 
				'label'=>false,
				'value'=>'{{id}}',
				'ng-model'=>'recurrencia.id'
			));?>
	
		<div class="row"> 
			<div class="col-md-4">
			<label>Folio</label>
					<?php echo $this->Form->input('folio', array(
						'type'=>'text',
						'class'=>'form-control', 
						'label'=>false,
						'value'=>'{{valor}}',
						'ng-model'=>'recurrencia.folio'
					));?>
					<label for="folio">{{error}}</label>
			</div>

			<div class="col-md-4">
			<label >Monto</label>
					<?php echo $this->Form->input('monto', array(
						'type'=>'text',
						'class'=>'form-control', 
						'label'=>false,
						'value'=>'{{valor}}',
						'ng-model'=>'recurrencia.monto'
					));?>
					<label for="monto">{{error}}</label>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-offset-8 col-md-12">
				<button type="button" class="btn btn-primary"  ng-click="guardaRecurrencia(recurrencia)" >Guardar</button>
				<button type="button" class="btn btn-warning" ng-click="closeModal()" data-dismiss="modal" >Cerrar</button>
			</div>
		</div>
		</form>
	</modal>
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/compra_tarjeta/generalCompraTarjeta',
		'angularjs/directivas/modal/modal',
		'angularjs/controladores/compra_tarjeta/general_compra_tarjeta',
		'angularjs/directivas/confirmacion'
		
	));
?>