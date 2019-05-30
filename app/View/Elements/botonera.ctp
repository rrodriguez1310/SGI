<!--div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>
	</div>
	<div class="panel-body" ng-init="isDisabled = true">
		<?php if(!empty($botones)) :  ?>		
			<ul class="list-inline">
				<?php if(isset($botones[$this->params->action])) : ?>
					<?php foreach($botones[$this->params->action] as $boton) :?>
						<?php if($boton['boton_metodo'] != "delete") : ?>
							<li ng-hide="btn<?php echo (isset($boton['boton_controller']) ? $boton['boton_controller'] : $this->params->controller).$boton['boton_metodo'];?>">
								<a id="{{id}}" ng-href="<?php echo (isset($boton["boton_ruta"]) ? $boton["boton_ruta"]."{{id}}" : ""); ?>" class="<?php echo $estilosBotones[$boton['boton_metodo']]["clase"]?> data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $boton['descripcion']?>" ng-show="boton" title="<?php echo $boton['descripcion'];?>"><?php echo $estilosBotones[$boton['boton_metodo']]["icono"]?></a>
							</li>
						<?php else : ?>
							<li ng-hide="btn<?php echo (isset($boton['boton_controller']) ? $boton['boton_controller'] : $this->params->controller).$boton['boton_metodo'];?>">
								<a ng-show="boton" class="<?php echo $estilosBotones[$boton['boton_metodo']]["clase"]?> data-placement="bottom" data-toggle="tooltip" data-original-title="Eliminar" confirmed-click="confirmacion()" ng-confirm-click="El registro sera eliminado" title="<?php echo $boton['descripcion'];?>"><?php echo $estilosBotones[$boton["boton_metodo"]]["icono"]?></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>	
				<ng-botonextra class='list-inline'></ng-botonextra>
			</ul>
		<?php endif; ?>
		<input type="text" class="form-control input-sm" ng-model="search" ng-change="refreshData(search)" placeholder="Buscar" />
	</div>
</div-->

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>
	</div>
	<div class="panel-body" ng-init="isDisabled = true">
		<?php if(!empty($botones)) :  ?>		
			<ul class="list-inline">
				<?php if(isset($botones[$this->params->action])) : ?>
					<?php foreach($botones[$this->params->action] as $boton) : ?>

						<?php if($boton['boton_metodo'] != "delete") : ?>
							
							<?php if(!empty($boton['boton_controller']) && !empty($boton['boton_metodo'])) : ?>
								<li ng-hide="btn<?php echo (isset($boton['boton_controller']) ? $boton['boton_controller'] : $this->params->controller).$boton['boton_metodo'];?>">
									<a id="{{id}}" ng-href="<?php echo $this->Html->url(array("controller"=>$boton['boton_controller'], "action"=>$boton['boton_metodo']));?>/{{id}}" class="<?php echo $estilosBotones[$boton['boton_metodo']]["clase"]?> data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $boton['descripcion']?>" ng-show="boton" title="<?php echo $boton['descripcion'];?>"><?php echo $estilosBotones[$boton['boton_metodo']]["icono"]?></a>
								</li>
							<?php else : ?>
								<li ng-hide="btn<?php echo (isset($boton['boton_controller']) ? $boton['boton_controller'] : $this->params->controller).$boton['boton_metodo'];?>">
									<a id="{{id}}" ng-href="<?php echo (isset($boton["boton_ruta"]) ? $boton["boton_ruta"]."{{id}}" : ""); ?>" class="<?php echo $estilosBotones[$boton['boton_metodo']]["clase"]?> data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $boton['descripcion']?>" ng-show="boton" title="<?php echo $boton['descripcion'];?>"><?php echo $estilosBotones[$boton['boton_metodo']]["icono"]?></a>
								</li>
							<?php endif; ?>
						<?php else : ?>
							<li ng-hide="btn<?php echo (isset($boton['boton_controller']) ? $boton['boton_controller'] : $this->params->controller).$boton['boton_metodo'];?>">
								<a ng-show="boton" class="<?php echo $estilosBotones[$boton['boton_metodo']]["clase"]?> data-placement="bottom" data-toggle="tooltip" data-original-title="Eliminar" confirmed-click="confirmacion()" ng-confirm-click="El registro sera eliminado" title="<?php echo $boton['descripcion'];?>"><?php echo $estilosBotones[$boton["boton_metodo"]]["icono"]?></a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>	
				<ng-botonextra class='list-inline'></ng-botonextra>
			</ul>
		<?php endif; ?>
		<input type="text" class="form-control input-sm" ng-model="search" ng-change="refreshData(search)" placeholder="Buscar" />
	</div>
</div>