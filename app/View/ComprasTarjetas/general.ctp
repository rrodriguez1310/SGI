
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

	<!--div class="row">
		<div class="col-sm-4 col-md-offset-2">Fecha Compra:</div>
		<div class="col-sm-4"><?= h($comprasTarjeta['ComprasTarjeta']['modified']); ?></div>
	</div-->

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Producto:</div>
		<div class="col-sm-4"><a href="<?= h($comprasTarjeta['ComprasTarjeta']['url']); ?>" target="_blank">
		<?= h($comprasTarjeta['ComprasTarjeta']['url_producto']); ?></a></div>
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
		<div class="col-sm-4 col-md-offset-2">Estadio</div>
		<div class="col-sm-4"><?= isset($estadios['Dimensione']['descripcion'])?$estadios['Dimensione']['descripcion']:'S/N'; ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Contenido</div>
		<div class="col-sm-4"><?= h(isset($contenido['Dimensione']['descripcion'])?$contenido['Dimensione']['descripcion']:'S/N'); ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Canal</div>
		<div class="col-sm-4"><?= h(isset($canal['Dimensione']['descripcion'])?$canal['Dimensione']['descripcion']:'S/N'); ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Otros</div>
		<div class="col-sm-4"><?= h(isset($otros['Dimensione']['descripcion'])?$otros['Dimensione']['descripcion']:'S/N'); ?></div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Proyectos</div>
		<div class="col-sm-4"><?= h($proyectos); ?></div>
	</div>
    <div class="row">
		<div class="col-sm-4 col-md-offset-2">Codigo Presupuestario</div>
		<div class="col-sm-4"><?= h($codigoPresupuestoId); ?></div>
	</div>


	<div class="row">
		<div class="col-sm-4 col-md-offset-2">Descarga Documento</div>
		<div class="col-sm-4">
		<!--a href="<?= acortarurl($comprasTarjeta['ComprasTarjeta']['url_documentos']); ?>" target="_blank">Descargar</a-->
		<?php 
				$arrayDoc = explode(",", $comprasTarjeta['ComprasTarjeta']['url_documentos']); 
				for($i=0;$i<count($arrayDoc);$i++){
					$arhivo = basename($arrayDoc[$i]);
					echo "<div class='row'>";
						echo "<a href=".acortarurl($arrayDoc[$i])." target='_blank'>$arhivo</a>";
					echo "</div>";
				}
			?>
		</div>
	</div>
<div class="center col-md-8 col-md-offset-2">
	<div class="row">
			<div class="col-sm-4">
				<a href="<?= $this->Html->url(array("controller"=>"compras_tarjetas/view_general", "action"=>"index"))?>" class="btn btn-primary btn-lg" >Volver</a>
			</div>
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
