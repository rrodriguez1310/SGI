<div class="panel panel-default hide">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>
	</div>
	<div class="panel-body" ng-init="isDisabled = true" >
		<ul class="list-inline menu_superior_angular" style="padding-bottom: 10px;">	
		<?php 
			$submenu = array();
			$submenu = $this->Session->Read("Acceso");
		 ?>
			<div ng-show="toolOperadores" class="list-inline menu_superior_angular" style="float:left;padding-right: 10px;padding-bottom: 10px;">		
				<?php if(in_array(array("controlador"=>"companies","accion"=>"detalleServiciosContratados"),$submenu)) { ?>
					<li>
						<a id="{{id}}" class="btn-sm btn btn-primary tool serviciosContratados" href="#" data-toggle="tooltip" data-placement="bottom" data-original-title="Detalle Servicio Contratado"><i class="fa fa-search-plus"></i></a>	
					</li>
				<?php } 
						if(in_array(array("controlador"=>"subscribers","accion"=>"index"),$submenu)) {  						
					?>
					<li>
						<a class="btn-sm btn btn-info tool" href="<?php echo $this->Html->url(array('controller'=>'subscribers', 'action'=>'index','')); ?>/{{id}}"  data-toggle="tooltip" data-placement="bottom" data-original-title="Abonados"><i class="fa fa-users"></i></a>
					</li>
				<?php } 
				 		if(in_array(array("controlador"=>"companiesAttributes","accion"=>"add"),$submenu)) {  ?>
					<li>
						<a class="btn-sm btn btn-warning tool camara" id="{{id}}" data-toggle="modal" data-target="#detalleServicio" href="#" data-toggle="tooltip" data-placement="bottom" data-original-title="Registrar Detalle Servicio"><i class="fa fa-video-camera"></i></a>
					</li>	
				<?php } ?>	
			</div>
			<li ng-show="toolContactos" style="float:left;padding-right: 10px;padding-left: 0px;padding-bottom: 10px;">
				<a class="listadoContactos btn-sm btn btn-default tool {{isDisabled}}" id="{{id}}" data-toggle="modal" data-target="#listaContactos" href="#" data-toggle="tooltip" data-placement="top" title="Ingresar contactos"><i class="fa fa-user"></i></a>
			</li>	
			<li ng-show="toolContactos" style="float:left;padding-right: 10px;padding-left: 0px;padding-bottom: 10px;">
				<a class="btn-sm btn btn-default tool" ng-click="listarComentarios(id)" id="{{id}}" data-toggle="modal" href="#" data-toggle="tooltip" data-placement="top" title="Bitácora"><i class="fa fa-comments"></i></a>
			</li>
			<div ng-show="toolOtros" class="list-inline menu_superior_angular" style="float:left;padding-bottom: 10px;">
				<?php 	if(in_array(array("controlador"=>"companies","accion"=>"edit"),$submenu)) {  ?>
					<li>
						<a href="<?php echo $this->Html->url(array("action"=>"edit"));?>/{{id}}" class="btn-sm btn btn-success tool {{isDisabled}}" data-placement="bottom" data-toggle="tooltip" data-original-title="Editar Corto"><i class="fa fa-pencil"></i></a>
					</li>
				<?php } 
						if(in_array(array("controlador"=>"companies","accion"=>"full_edit"),$submenu)) {  ?>
					<li>
						<a href="<?php echo $this->Html->url(array("action"=>"full_edit"));?>/{{id}}" class="btn-sm btn btn-success tool {{isDisabled}}" data-placement="bottom" data-toggle="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></a>
					</li>
				<?php } 
				 		if(in_array(array("controlador"=>"companies","accion"=>"view"),$submenu)) {  ?>
				 	<li>	
				 		<a class="btn btn-sm tool btn-primary" id="{{id}}" data-toggle="tooltip" href="<?php echo $this->Html->url(array('controller'=>'companies', 'action'=>'view', '')); ?>/{{id}}" data-toggle="tooltip" data-placement="top" title="Detalle Empresa"><i class="fa fa-eye" ></i></a>
				 	</li>	
				<?php } ?>
			</div>		
		</ul>
		<input type="text" class="form-control input-sm" ng-model="search" ng-change="refreshData(search)" placeholder="Buscar" />
	</div>
</div>