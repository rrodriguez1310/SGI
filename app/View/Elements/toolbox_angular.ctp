<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>
	</div>
	<div class="panel-body" ng-init="isDisabled = true">
		<ul class="list-inline menu_superior_angular">
			<li class="addbtn">
				<a href="<?php echo $this->Html->url(array("action"=>"add"));?>"  class="btn-sm btn btn-primary tool {{isDisabled}}" data-placement="bottom" data-toggle="tooltip" data-original-title="Insertar"><i class="fa fa-floppy-o"></i></a>
			</li>
			<li>
				<a href="<?php echo $this->Html->url(array("action"=>"edit"));?>/{{id}}" ng-show="boton" class="btn-sm btn btn-success tool {{isDisabled}}" data-placement="bottom" data-toggle="tooltip" data-original-title="Editar"><i class="fa fa-pencil"></i></a>
			</li>
			<li>
				<a  ng-show="boton" class="btn-sm btn btn-danger tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Eliminar" confirmed-click="confirmacion()" ng-confirm-click="El registro sera eliminado"><i class="fa fa-trash-o"></i></a>
			</li>
			<li ng-asignaroles></li>
			<li ng-botonasignaroles></li>
		</ul>
		<input type="text" class="form-control input-sm" ng-model="search" ng-change="refreshData(search)" placeholder="Buscar" />
	</div>
</div>