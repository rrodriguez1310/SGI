<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>
	</div>
	<div class="panel-body">
		<ul class="list-inline menu_superior_angular">
			<li>
				<a href="<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"view"));?>/{{id}}" ng-show="boton" class="btn-sm btn btn-primary tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Ver"><i class="fa fa-eye"></i></a>
			</li>
		</ul>
		<input type="text" class="form-control input-sm" ng-model="search" ng-change="refreshData(search)" placeholder="Buscar" />
	</div>
</div>