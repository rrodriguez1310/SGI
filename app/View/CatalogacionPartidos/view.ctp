<div ng-controller="catalogacionPartidosView" ng-cloak ng-init="catalogacionPartidoId(<?php echo $this->request->pass[0]; ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-md-6 center-block">
				<h4>Detalle codigo evento {{ catalogacionPartido.codigo }}</h4>
			</div>
			<div class="col-md-6">
				<ul class="list-inline  pull-right">
			  		<li><?php echo $this->Html->link('<i class="fa fa-video-camera"></i> Ingresar Media</a>', array('controller'=>'catalogacion_partidos_medios', 'action'=>'add', $this->request->pass[0]), array("class"=>"btn btn-primary", "escape"=>false)); ?></li>
			  		<!--<li><?php echo $this->Html->link('<i class="fa fa-comment-o"></i> Ingresar Estadistica</a>', array('controller'=>'catalogacion_partidos_medios', 'action'=>'add', $this->request->pass[0]), array("class"=>"btn btn-success", "escape"=>false)); ?></li>-->
				</ul>
			</div>
		</div>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Codigo</th>
					<th>Equipo Local</th>
					<th>Equipo Visita</th>
					<th>Fecha Partido</th>
					<th>Campeonato</th>
					<th>Fecha Torneo</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ catalogacionPartido.CatalogacionPartido.codigo }}</td>
					<td>{{ (equipos[catalogacionPartido.CatalogacionPartido.equipo_local].codigo+" - "+equipos[catalogacionPartido.CatalogacionPartido.equipo_local].nombre) | uppercase }}</td>
					<td>{{ (equipos[catalogacionPartido.CatalogacionPartido.equipo_visita].codigo+" - "+equipos[catalogacionPartido.CatalogacionPartido.equipo_visita].nombre) | uppercase }}</td>
					<td>{{ catalogacionPartido.CatalogacionPartido.fecha_partido | date : 'dd/MM/yyyy' }}</td>
					<td>{{ catalogacionPartido.Campeonato.nombre | uppercase }}</td>
					<td>{{ catalogacionPartido.CatalogacionPartido.fecha_torneo }}</td>
				</tr>
			</tbody>
		</table>
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->element('botonera'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid" ui-grid-resize-columns></div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-12 text-center">
				<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"catalogacion_partidos", "action"=>"index"), array("class"=>"btn btn-default btn-lg", "escape"=>false)); ?>
			</div>
		</div>
	</div>
</div>

<?php 
	echo $this->Html->script(array(
		"angularjs/controladores/app",
		"angularjs/servicios/catalogacion_partidos/catalogacion_partidos",
		"angularjs/servicios/equipos/equipos",
		"angularjs/factorias/equipos/equipos",
		'angularjs/controladores/catalogacion_partidos/catalogacion_partidos',
	));
?>