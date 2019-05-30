<div ng-controller="evaluacionesAdd">
	<div class="form-group col-md-12" ng-class="{'has-error' : !myValue }">
		<input type="text" number-format decimals="4" negative="true" ng-model="myValue" class="form-control sube" placeholder="Puntaje" ng-model="prueba.format" required>
		{{myValue}}<br>
		{{myValue|json}}
	</div>
</div>

<?php 
echo $this->Html->script(array(	
	'angularjs/controladores/app',
	'angularjs/servicios/evaluaciones_trabajadores/evaluaciones',
	'angularjs/controladores/evaluaciones_trabajadores/listar_evaluaciones',
	'angularjs/directivas/confirmacion',
	'angularjs/directivas/number_format',
	'bootstrap-datepicker',
	));
?>
