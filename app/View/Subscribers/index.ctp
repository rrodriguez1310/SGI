<div ng-controller="indexSubscribersCtrl" ng-init="agnoId=<?php echo $agno;?>; idEmpresa=<?php echo $idEmpresa;?>; linkInforme='<?php echo $this->Html->url(array('controller'=>'subscribers', 'action'=>'genera_informe_abonado_pdf'))?>'" ng-cloak>
	<div class="row">
		<div class="col-md-12">
			<div class="mensaje"></div>
			<h3><?php echo __("Lista de Abonados ".$nombreEmpresa ." año " . $nombreAgno)?></h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-pills">
				<li class="pull-right" style="margin-left: 10px;">
					<a href="<?php echo $this->Html->url(array("controller"=>"companies", "action"=>"index"))?>" class="btn btn-default btn-mx"><i class="fa fa-mail-reply-all"></i> Volver</a>
				</li>
				
				<li class="dropdown pull-right">
					<a href="#" class="dropdown-toggle btn btn-default" data-toggle="dropdown"><i class="fa fa-calendar fa-lg "></i> Ver otro año</span></a>
					<?php //echo $this->Html->link(__('PDF'), array('action' => 'view_pdf', 'ext' => 'pdf')); ?>
					
					<ul class="dropdown-menu">
						<?php foreach($agnos as $key => $valor) : ?>
							<li></li>
							<li>
								<a href="<?php echo $this->Html->url(array('controller'=>'subscribers', 'action'=>'index', $idEmpresa, $valor["Year"]["nombre"]))?>" id="<?php echo $valor["Year"]["id"]; ?>">  
									<?php echo $valor["Year"]["nombre"]; ?>
								</a>
							</li>

						<?php endForeach; ?>
					</ul>
				</li>
			</ul>		
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php foreach($atributosEmpresas as $key => $atributosEmpresa): ?>
			<h3>Abonados <?php echo $key; ?></h3>

				<table border="1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Tipo Transmisión</th>
							<th>Tipo Señal</th>
							<th>Tipo Pago</th>
							<?php 
								foreach($arrayMeses as $arrayMese)
								{
									echo "<th>" .$arrayMese["nombre"] . "</th>";
								}
							?>
						</tr>
					</thead>
					<?php foreach($atributosEmpresa as $atributosEmpresaValor) : ?>
					<tbody>
						<?php foreach($atributosEmpresaValor["Canales"] as $valorCanales):?>
						<?php foreach($atributosEmpresaValor["Enlaces"] as $valorEnlaces):?>
						<?php foreach($atributosEmpresaValor["Segnal"] as $valorSegnal):?>
						<?php foreach($atributosEmpresaValor["Pagos"] as $valorPagos):?>
						<tr>
							<?php 
								if(isset($enlacesArray[$valorEnlaces]))
								{
									echo '<td>' .$enlacesArray[$valorEnlaces] . '</td>';	
								}
								 
							?>
						</td>
							<td><?php echo $signalArray[$valorSegnal]; ?></td>
							<td><?php echo $pagosArray[$valorPagos]; ?></td>
							<?php foreach($arrayMeses as $arrayMese) : ?>
							<td>
								<a href="" ng-click="registrarAboandos('<?php  echo isset($valorAbonado[$arrayMese["id"]][$valorCanales][$valorEnlaces][$valorSegnal][$valorPagos]["Abonados"]) ? $valorAbonado[$arrayMese["id"]][$valorCanales][$valorEnlaces][$valorSegnal][$valorPagos]["Abonados"] : 0; ?>','<?php echo isset($valorAbonado[$arrayMese["id"]][$valorCanales][$valorEnlaces][$valorSegnal][$valorPagos]["Id"]) ? $valorAbonado[$arrayMese["id"]][$valorCanales][$valorEnlaces][$valorSegnal][$valorPagos]["Id"] : ''?>', '<?php echo $valorCanales; ?>', '<?php echo $arrayMese["id"];?>', '<?php echo $valorEnlaces; ?>', '<?php echo $valorSegnal; ?>', '<?php echo $valorPagos; ?>')"><?php  echo isset($valorAbonado[$arrayMese["id"]][$valorCanales][$valorEnlaces][$valorSegnal][$valorPagos]["Abonados"]) ? number_format($valorAbonado[$arrayMese["id"]][$valorCanales][$valorEnlaces][$valorSegnal][$valorPagos]["Abonados"], 0, '', '.') : '0'; ?></a>
								<!--a id ="<?php echo isset($valorAbonado[$arrayMese["id"]][$valorCanales][$valorEnlaces][$valorSegnal][$valorPagos]["Id"]) ? $valorAbonado[$arrayMese["id"]][$valorCanales][$valorEnlaces][$valorSegnal][$valorPagos]["Id"] : ''?>" data-pk="<?php echo $valorCanales; ?>" class='xeditable' data-mes="<?php echo $arrayMese["id"];?>" href="#" data-channel="<?php echo $valorCanales; ?>" data-link="<?php echo $valorEnlaces; ?>" data-segnales="<?php echo $valorSegnal; ?>" data-pagos="<?php echo $valorPagos; ?>">
									<?php  echo isset($valorAbonado[$arrayMese["id"]][$valorCanales][$valorEnlaces][$valorSegnal][$valorPagos]["Abonados"]) ? number_format($valorAbonado[$arrayMese["id"]][$valorCanales][$valorEnlaces][$valorSegnal][$valorPagos]["Abonados"], 0, '', '.') : '0'; ?>
								</a-->
								
							</td>
							<?php endForeach; ?>
						</tr>
						<?php endForeach; ?>
						<?php endForeach; ?>
						<?php endForeach; ?>
						<?php endForeach; ?>
						<?php endForeach; ?>
					</tbody>
			</table>
			<?php endForeach; ?>
		</div>
	</div>
	<modal visible="showModal">
		<form name="formularioCambioEstado" novalidate>
			<div class="row">
				<div class="col-md-12">
					<h5>Abonados</h5>
				</div>
			</div>
			<hr>
			<div class="form-group" ng-class="{'has-error' : formularioCambioEstado.Nueva_fecha_ingreso.$invalid}">
				<label class="control-label">N° abonados</label>
				<input type="number" name="Nueva_fecha_ingreso" class="form-control" placeholder="Ingrese numero de abonados" ng-model="abonados.cantidad" required min="0">
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<h5>Promociones</h5>
				</div>
			</div>
			<hr>
			<!--div class="form-group">
				<label for="promociones_id">Promoción</label>
				<select ng-model="agregar.promocion" class="form-control" name="promociones_id" id="promociones_id">
					<option value="">Seleccione una promoción</option>
					<option ng-repeat="(key, promocion) in promocionesList" ng-disabled="promocion.disabled" value="{{promocion}}">{{promocion.nombre}}</option>
				</select>
			</div>
			<div class="form-group text-center">
				<button class="btn btn-success" ng-click="agregarPromocion()" ng-disabled="!agregar.promocion"><i class="fa fa-plus"></i> Agregar promoción</button>
			</div-->
			<div class="row" ng-show="promociones.length != 0">
				<div class="col-md-12">
					<table class="table table-condensed table-bordered">
						<thead>
							<tr>
								<th>Promoción</th>
								<th>Abonados</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="(key, promocion) in promociones">
								<td style="vertical-align: middle">{{promocion.nombre}}</td>
								<td>
									<input style="margin-top:0px;" type="number" name="inputpromo{{key}}" ng-model="promociones[key].SubscribersPromocione.cantidad_abonados" class="form-control" required  min="0">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</form>		
		<div class="modal-footer">
	        <button type="button" class="btn btn-primary" ng-click="add()"><i class="fa fa-check"></i> Guardar</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
	    </div>
	</modal>
</div>

<?php 
	echo $this->Html->script(array(
		"angularjs/controladores/app",
		'angularjs/directivas/modal/modal',
		"angularjs/servicios/subscribers/subscribers",
		"angularjs/servicios/subscribers_promociones/subscribers_promociones",
		"angularjs/servicios/promociones/promociones",
		"angularjs/factorias/factoria",
		"angularjs/controladores/subscribers/subscribers",
	));
?>
<script>
	function Exito(){
		$(".mensaje").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Cantidad de abonados registrado correctamente</strong>.</div>');
	}
	document.addEventListener('DOMContentLoaded', function () {
		$('.tool').tooltip();
		cancelar = document.getElementsByClassName("cancelar_envio_informe_abonados");
		cancelarL = cancelar.length;
		for (var i = cancelarL - 1; i >= 0; i--) {
			cancelar[i].onclick = function() {
				window.onload = Exito();
			    location.reload();
			};
		}
	}, false );
</script>