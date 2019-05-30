<div class="center col-md-8 col-md-offset-2" ng-controller="controllerEstado" ng-init="respuesta(<?php echo $comprasTarjeta['ComprasTarjeta']['id']?>)">
	<div class="panel panel-info">
		<div class="panel-heading"><h3>Información Solicitud Compra Tarjeta</h3></div>
	<div class="panel-body">

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Número Solicitud:</div>
		<div class="col-sm-4"><?= h($comprasTarjeta['ComprasTarjeta']['id']); ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Fecha Requerimiento:</div>
		<div class="col-sm-4"><?= h($comprasTarjeta['ComprasTarjeta']['created']); ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Fecha Compra:</div>
		<div class="col-sm-4"><?= h($comprasTarjeta['ComprasTarjeta']['modified']); ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Producto:</div>
		<div class="col-sm-4">
            <?php 
           
                if(!empty($comprasTarjeta['ComprasTarjeta']['url'])){
            ?>
                <a href="<?= h($comprasTarjeta['ComprasTarjeta']['url']); ?>" target="_blank">
                    <?= h($comprasTarjeta['ComprasTarjeta']['url_producto']); ?>
                </a>
            <?php 
                }else{
                    echo $comprasTarjeta['ComprasTarjeta']['url_producto'];
                }
            ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Monto:</div>
		<div class="col-sm-4"><?= h($comprasTarjeta['ComprasTarjeta']['monto']); ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Cuotas:</div>
		<div class="col-sm-4"><?= h($comprasTarjeta['ComprasTarjeta']['cuota']); ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Tipos Monedas:</div>
		<div class="col-sm-4"><?= h($comprasTarjeta['TiposMoneda']['nombre']); ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Presupuestos:</div>
		<div class="col-sm-4"><?= h($comprasTarjeta['CodigosPresupuesto']['nombre']); ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Gerencia</div>
		<div class="col-sm-4"><?= h($dimensione['Dimensione']['descripcion']); ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Descarga Documento</div>
		<div class="col-sm-4"><a href="<?= acortarurl($comprasTarjeta['ComprasTarjeta']['url_documentos']); ?>" target="_blank">Descargar</a></div>
	</div>

	<?php if( $comprasTarjeta['ComprasTarjeta']['compras_tarjetas_estado_id']==1 || 
			  $comprasTarjeta['ComprasTarjeta']['compras_tarjetas_estado_id']==2 ||
			  $comprasTarjeta['ComprasTarjeta']['compras_tarjetas_estado_id']==3 ||
			  $comprasTarjeta['ComprasTarjeta']['compras_tarjetas_estado_id']==9){ ?>
<div >
		<div class="row" >
			<div class="col-sm-4 col-md-offset-2">Estado</div>
				<div class="col-sm-4">	
						<?php echo $this->Form->input('tarjeta_estado_id',array(
						"class"=>"selectDos form-control", 
						"options"=>$estado,
						"label"=>false, 
						"empty"=>"Estados Solicitud",
						"ng-model"=>"tarjeta_estado_id",
						"ng-change"=>"muestraCampo(tarjeta_estado_id)",
						"selected"=>
						'required'
						));
						?>
				</div>

					
					<div class="row" >
					<div ng-show="compraBtn">
						<div class="col-sm-4 col-md-offset-2">Compra</div>
						<div class="col-sm-4">
							
								<?php echo $this->Form->input('compra', array(
									'type'=>'select',
									'class'=>'selectDos form-control', 
									"ng-model"=>"compra",
									"empty"=>"Estados Compra",
									"options"=>$estadoCompra,
									'label'=>false,
									'required'
								));?>
								<label for="compra"></label>
							
						</div>
					</div>
				<div class="row" ng-show="eliminarBtn">
					<div class="col-sm-4 col-md-offset-2">Observación</div>
						<div class="col-sm-4">	
								<?php echo $this->Form->input('observacion',array(
								"class"=>"selectDos form-control", 	
								"type"=>"textarea",
								"rows"=>"4",
								"cols"=>"50",
								"label"=>false, 
								"empty"=>"",
								'ng-model'=>'observacion'
								));
								?>
						<label for="observacion"></label>
						</div>
						</div>
				</div>
			<div class="col-sm-4 col-md-offset-2"></div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-info" ng-click="estado(<?php echo $comprasTarjeta['ComprasTarjeta']['id']?>)">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php } ?>
<div class="center col-md-8 col-md-offset-2">
	<div class="row">
		<?php if( $comprasTarjeta['ComprasTarjeta']['compras_tarjetas_estado_id']==3){?>
			<div class="col-sm-4">	
				<a href="<?= $this->Html->url(array("controller"=>"compras_tarjetas/view_area", "action"=>"index"))?>" class="btn btn-primary btn-lg" id="area"><span>Volver</span></a>
			</div>
		<?php }else if( $comprasTarjeta['ComprasTarjeta']['compras_tarjetas_estado_id']==2 || $comprasTarjeta['ComprasTarjeta']['compras_tarjetas_estado_id']==9){ ?>
			<div class="col-sm-4">
				<a href="<?= $this->Html->url(array("controller"=>"compras_tarjetas", "action"=>"index"))?>" class="btn btn-primary btn-lg" id="finanzas"><span>Volver</span></a>
			</div>
		<?php }else if($comprasTarjeta['ComprasTarjeta']['compras_tarjetas_estado_id']==1){ ?>
			<div class="col-sm-4">
				<a href="<?= $this->Html->url(array("controller"=>"compras_tarjetas/view_gerente", "action"=>"index"))?>" class="btn btn-primary btn-lg" id="gerente"><span>Volver</span></a>
			</div>
		<?php }else{?>
			<div class="col-sm-4">
				<a href="<?= $this->Html->url(array("controller"=>"compras_tarjetas/view_general", "action"=>"index"))?>" class="btn btn-primary btn-lg" >Volver</a>
			</div>

		<?php } ?>
	</div>
</div>
</div>
</div>
</div>
<?php
	function acortarurl($url){
		$uris = explode("html", $url);
		return $uris[1];
	}
?>
	
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/compra_tarjeta/compraTarjeta',
		'angularjs/directivas/modal/modal',
		'angularjs/controladores/compra_tarjeta/estado',
	));
?>

<script>
$('#compra').on('change', function(){
	var valor = $(this).val();
	if(valor!=''){
		$("[for=compra]").text('');
	}
})
</script>
