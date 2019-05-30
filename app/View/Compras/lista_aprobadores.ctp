<div ng-controller="ListaAprobadores">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle" class="col-md-7">
		<?php echo $this->element('botonera'); ?>
		<div>
			<div>{{msg.lastCellEdited}}</div>
			<br>	
			<div ui-grid="gridOptions" ui-grid-selection class="grid"></div>
		</div>
	</div>
	<div class="col-md-5" ng-show="formulario">
		<h3>{{tituloBoton}}</h3>
		<form name="userForm" ng-submit="submitForm()" method="post">
			<div class="form-group">
				<input type="hidden" class="form-control" id="exampleInputEmail1" ng-model="form.tipo" required>
				<input type="hidden" class="form-control" id="exampleInputEmail1" ng-model="form.id" required>
				<label for="exampleInputEmail1">Email</label>
				<input type="email" class="form-control" id="exampleInputEmail1" ng-model="form.email" required="required">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Gerencia</label>

				<select class="form-control" name="mySelect" id="mySelect" ng-options="option.nombre for option in selectAprobadores.availableOptions track by option.id " ng-model="selectAprobadores.selectedOption" required> </select>
			</div>
			<button type="submit" class="{{clase}}">{{tituloBoton}}</button>
		</form>
	</div>
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/compras/compras',
		'angularjs/controladores/compras/aprobadores_compras',
		'angularjs/directivas/confirmacion',
	));
?>