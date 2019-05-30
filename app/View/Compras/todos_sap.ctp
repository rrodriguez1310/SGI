<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/buscar_compras',
		'bootstrap-datepicker'
	));
?>

<div ng-controller="BuscaCompras">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<?php //echo $this->element("loader"); ?>

	<div ng-show="tablaDetalle">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>
			</div>
			<div class="panel-body">
				<ul class="list-inline menu_superior_angular">
					<li ng-show="ver"><a href="<?php echo $this->Html->url(array("action"=>"view"));?>/{{id}}" class="btn-sm btn btn-primary tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Ver" target="_blank"><i class="fa fa-eye"></i></a></li>
					<li ng-show="ver"><a href="<?php echo $this->Html->url(array("action"=>"editar_codigo_presupuestario"));?>/{{id}}" class="btn-sm btn btn-danger tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Editar Codigo Presupuestario" target="_blank"><i class="fa fa-pencil"></i></a></li>
					<li ng-show="plantilla"><a href="{{plantilla}}/{{id}}" class="btn-sm btn btn-warning tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Plantilla"><i class="fa fa-recycle"></i></a></li>
					<li ng-show="asociarFac"><a href="<?php echo $this->Html->url(array("action"=>"asociar_facturas"));?>/{{idEmpresas}}" class="btn-sm btn btn-info tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Asociar Doc. Tributario"><i class="fa fa-file-text"></i></a></li>
					<li ng-show="asociarNot"><a href="<?php echo $this->Html->url(array("action"=>"notas_credito"));?>/{{id}}" class="btn-sm btn btn-naranjo tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Asociar Nota de Credito"><i class="fa fa-files-o"></i></a></li>

				</ul>
				<input type="text" class="form-control input-sm" ng-model="search" ng-change="refreshData(search)" placeholder="Buscar" />
			</div>
		</div>
		<div>
			
			<br>	
			<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
		</div>
	</div>
</div>
<script>
	$('.tool').tooltip();
</script>