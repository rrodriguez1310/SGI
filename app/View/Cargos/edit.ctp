<div ng-controller="cargosEdit" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="cargosShow">
		<div class="row">
			<div class="col-md-12 text-center">
				<h4>Editar Cargo</h4>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form class="form-horizontal" name="cargosEdit" novalidate ng-init="idCargo=<?php echo $id; ?>">
					<input type="hidden" ng-model="formulario.Cargo.estado" ng-init="formulario.Cargo.estado = 1">
					<div class="form-group"  ng-class="{ 'has-error': !cargosEdit.cargosFamilias.$valid }">
						<label class="col-md-3 control-label" for="cargosFamilias">Familia</label>
						<div class="col-md-9">
							<ui-select ng-model="formulario.Cargo.cargos_familia_id" id="cargosFamilias" name="cargosFamilias" required>
								<ui-select-match placeholder="Seleccione una familia">
									{{$select.selected.nombre | uppercase }}
								</ui-select-match>
								<ui-select-choices repeat="cargosFamilia.id as cargosFamilia in cargosFamiliasList | filter: $select.search">
									<div ng-bind-html="(cargosFamilia.nombre | uppercase ) | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !cargosEdit.cargosNivelResponsabilidad.$valid }">
						<label class="col-md-3 control-label" for="cargosNivelResponsabilidad">Nivel Responsabilidad</label>
						<div class="col-md-9">
							<ui-select ng-model="formulario.Cargo.cargos_nivel_responsabilidade_id" id="cargosNivelResponsabilidad" name="cargosNivelResponsabilidad" required>
								<ui-select-match placeholder="Seleccione un nivel de responsabilidad">
									{{$select.selected.nivel}}
								</ui-select-match>
								<ui-select-choices repeat="cargosNivelResponsabilidad.id as cargosNivelResponsabilidad in cargosNivelResponsabilidadesList | filter: $select.search">
									<div ng-bind-html="cargosNivelResponsabilidad.nivel | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !cargosEdit.gerencia.$valid }">
						<label class="col-md-3 control-label" for="gerencia">Gerencia</label>
						<div class="col-md-9">
							<ui-select ng-model="formulario.Area.gerencia_id" id="gerencia" name="gerencia" on-select="cambioGerencia($item, true)" required>
								<ui-select-match placeholder="Seleccione una gerencia">
									{{$select.selected.nombre | uppercase }}
								</ui-select-match>
								<ui-select-choices repeat="gerencias.id as gerencias in gerenciasList | filter: $select.search">
									<div ng-bind-html="(gerencias.nombre | uppercase) | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !cargosEdit.area.$valid }">
						<label class="col-md-3 control-label" for="area">Área</label>
						<div class="col-md-9">
							<ui-select ng-model="formulario.Cargo.area_id" id="area" name="area" required>
								<ui-select-match placeholder="Seleccione un área">
									{{$select.selected.nombre | uppercase }}
								</ui-select-match>
								<ui-select-choices repeat="areas.id as areas in areasList | filter: $select.search">
									<div ng-bind-html="(areas.nombre | uppercase) | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !cargosEdit.cargo.$valid }">
						<label class="col-md-3 control-label baja" for="cargo">Cargo</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="cargo" id="cargo" ng-model="formulario.Cargo.nombre" ng-change="refreshData(formulario.Cargo.nombre)" required>	
						</div>
						
					</div>

					<div class="form-group">
							<label class="col-md-3 control-label">Adjuntar descripcón de cargo</label>
							<div class="col-md-8 baja" ng-show="!!formulario.Cargo.descripcion_cargo">
								<a download href="<?php echo $this->webroot.'files'.DS.'descripcion_cargo'.DS;?>{{formulario.Cargo.descripcion_cargo}}" target="_blank">
						    		{{formulario.Cargo.descripcion_cargo.split("/")[1]}}						    								    		
						    	</a>
						    	<button type="button" class="close sube" aria-label="Close" ng-confirm-click="¿Eliminar archivo?" confirmed-click="eliminarAdjunto()">
					    			<span aria-hidden="true">&times;</span>
					    		</button>								
							</div>
							<div class="col-md-8" ng-show="!formulario.Cargo.descripcion_cargo">								
								<input ngf-select ng-model="formulario.File.descripcion" name="file" type="file" accept=".docx,.doc">
							</div>
					</div>


					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-lg" ng-disabled="!cargosEdit.$valid" ng-click="registrarCargo()"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
							<a id="volver" class="volver btn btn-default btn-lg" ng-href="{{ host }}cargos"><i class="fa fa-mail-reply-all"></i> Volver</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div ng-show="resultadosShow">
				<div class="col-md-12 text-center">
					<h4>Listado de cargos encontrados</h4>
				</div>
				<div class="col-md-12">
					<div ui-grid="gridOptions" ui-grid-exporter ng-model="grid" class=""></div>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	echo $this->Html->script(array(
		"angularjs/controladores/app",
		"angularjs/servicios/cargos/cargos",
		"angularjs/servicios/areas/areas",
		"angularjs/servicios/gerencias/gerencias",
		"angularjs/servicios/cargos_familias/cargos_familias",
		"angularjs/servicios/cargos_nivel_responsabilidades/cargos_nivel_responsabilidades",
		"angularjs/factorias/areas/areas",
		"angularjs/controladores/cargos/cargos",
		'angularjs/directivas/confirmacion',
		)); 
?>

<!--
<div class="col-md-7 col-md-offset-2">
	<?php echo $this->Form->create('Cargo', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<h4 class="col-md-offset-6"><?php echo __('Edición de cargo'); ?></h4>
			<?php echo $this->Form->input('id');?>
			<div class="form-group">
				<label class="col-md-4 control-label">Familia</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('cargos_familia_id', array('empty' => '', "class"=>"select2 mayuscula", "placeholder"=>"Seleccione familia", "label"=>false, "required"=>"required", "options"=>$cargosFamilias));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Nivel Responsabilidad</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('cargos_nivel_responsabilidade_id', array('empty' => '', "class"=>"select2 mayuscula", "placeholder"=>"Seleccione el nivel de responsabilidad", "label"=>false, "required"=>"required", "options"=>$cargosNivelResponsabilidades));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Gerencia</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('gerencia_id', array("type"=>"select","options"=>$gerencias, "class"=>"select2 mayuscula", "placeholder"=>"Gerencias", "label"=>false, "required"=>"required"));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Área</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('area_id', array("class"=>"select22 mayuscula", "placeholder"=>"Areas", "label"=>false, "required"=>"required", "options"=>$areas));?>
				</div>
			</div>	
			<div class="form-group">
				<label class="col-md-4 control-label baja">Cargo</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('nombre', array("class"=>"form-control mayuscula", "placeholder"=>"Ingrese nombre cargo", "label"=>false, "required"=>"required"));?>
				</div>
			</div>
		</fieldset>
		<br/>
		<button class="btn btn-primary btn-lg col-md-offset-5"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
		<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
	<?php echo $this->Form->end(); ?>
</div>
-->
<script>
/*
	$(".select2").select2({
		placeholder: "Seleccione Gerencia",
		allowClear: true,
		width:'100%',
		minimumInputLength: -1,
	});
	
	$(".select22").select2({
		placeholder: "Seleccione Area",
		allowClear: true,
		width:'100%',
		minimumInputLength: -1,
		allowClear: true
	});

	$('#CargoGerenciaId').change(function(){
		var gerencia = $("#CargoGerenciaId").val();
		$.getJSON("<?php echo $this->Html->url(array('controller'=>'Servicios', 'action'=>'buscaAreas')); ?>",{'gerencia':gerencia},function(data,status){
			if(data == 1)
			{
				$('.select22').select2('data', null);
				$("#CargoAreaId option").empty();
			}else
			{
				$('.select22').select2('data', null);
				$("#CargoAreaId option").remove();
				$("#CargoAreaId").append('<option value=""></option>');
				$.each(data, function(i,item)
				{
					$("#CargoAreaId").append('<option value="'+item.Id+'">'+item.Nombre+'</option>');
				});
			}
  		});	
	});
*/
</script>
