<div ng-controller="catalogacionRequerimientosTerminarRequerimiento" ng-cloak ng-init="requerimientoId(<?php echo $this->request->pass[0]; ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Terminar Requerimiento</h3>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form name="catalogacionRequerimientoTerminarForm" novalidate class="form-horizontal">
					<div class="form-group">
						<label for="observacion">Observación termino</label>
						<textarea ng-model="formulario.CatalogacionRequerimiento.observacion_termino" rows="5" name="observacion" id="observacion" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-lg" ng-disabled="catalogacionRequerimientosTerminarRequerimiento.$invalid || registrando" ng-click="terminarRequerimiento()"><i class="fa fa-pencil-square-o"></i> Terminar</button>
							<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"catalogacion_requerimientos", "action"=>"index"), array("class"=>"btn btn-default btn-lg baja", "escape"=>false)); ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<?php
echo $this->Html->script(array(
	"angularjs/controladores/app",
	"angularjs/servicios/catalogacion_requerimientos/catalogacion_requerimientos",
	"angularjs/controladores/catalogacion_requerimientos/catalogacion_requerimientos"
)); 
?>