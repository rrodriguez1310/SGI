<?php
	if(empty($salida[0]['Trabajadore']['nombre'])) $salida[0]['Trabajadore']['nombre'] = "";
	if(empty($salida[0]['Trabajadore']['apellido_paterno']))$salida[0]['Trabajadore']['apellido_paterno'] = "";
	if(empty($puntosJefe[0][0]['disponible'])) $puntosJefe[0][0]['disponible'] = 0;
?>
	<form class="form-horizontal">
		<div class="container">
			<div class="col-md-12 " >
				<div class="panel panel-primary" style="margin-left: -27px !important">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<h3 class="panel-title"><?php echo __('Acciones de reconocimiento'); ?></h3>
							</div>
						</div>
					</div>
					<div class="panel-body">	
						<div class="col-md-12">
							<div class="panel-body">

								<div  class="col-md-4">
									<label for="" class="col-md-3 control-label">Jefe:</label>
									<div class="col-md-9 baja mayuscula" style"margin-top: 6px;!important;"><?php echo $salida[0]['Trabajadore']['nombre']." ".$salida[0]['Trabajadore']['apellido_paterno']?></div>
								</div>

								<div  class="col-md-6">
									<label for="" class="col-md-3 control-label">Disponible:</label>
									<div class="col-md-6 baja mayuscula" style"margin-top: 6px; !important;"><?php echo $puntosJefe[0][0]['disponible']?> <span>&nbsp;Puntos</span></div>
								</div>

								<div class="col-md-2" id="link">
									<div class="col-md- baja mayuscula ">
										<div><a href="<?php echo $this->Html->url(array("controller" => "recognitionCollaborators", "action"=>"index"))?>" class="volver btn btn-primary pull-right"><i class="fa fa-check-square-o"></i> Realizar Reconocimiento</a></div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
<div ng-controller="collaborator" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>

	
	<?php //echo $this->element('botonera'); ?>

	<div>
		<br>
		<div ng-show="tablaDetalle">
			<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
		</div>
	</div>

</div>
	
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/recognition/collaborator',
		'angularjs/controladores/recognition/recognitioncollaborator',
		'angularjs/directivas/confirmacion'
	));
?>
<script>
$(document).ready(function() {

	var disponible  = '<?php echo $puntosJefe[0][0]['disponible'];?>';

	if(disponible > 0){
		$('#link').show();
	}else{
		$('#link').hide();
	}		
});
</script>