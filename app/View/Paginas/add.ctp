<!--hr>
	<ul class="nav nav-pills">
		<li class="pull-right">
			<a href="<?php echo $this->Html->url(array("controller"=>"paginas", "action"=>"index"))?>"><i class="fa fa-mail-reply-all"></i> Volver</a>
		</li>
	</ul>
<hr-->

<br/>
<div class="col-md-6 col-md-offset-3">
	<?php echo $this->Form->create('Pagina'); ?>
		<fieldset>
			<h4><?php echo __('Registrar Pagina'); ?></h4>
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('controlador', array("class"=>"form-control", "placeholder"=>"Ingrese Controlador", "label"=>false, "required"=>"required"));?>
			</div>
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('controlador_fantasia', array("class"=>"form-control", "placeholder"=>"Ingrese Controlador Fantasia", "label"=>false, "required"=>"required"));?>
			</div>
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('accion', array("class"=>"form-control", "placeholder"=>"Ingrese Acción", "label"=>false, "required"=>"required"));?>
			</div>
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('accion_fantasia', array("class"=>"form-control", "placeholder"=>"Ingrese Accion Fantasia", "label"=>false, "required"=>"required"));?>
			</div>
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('nombre_link', array("class"=>"form-control", "placeholder"=>"Ingrese Link", "label"=>false, "required"=>"required"));?>
			</div>				
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('alias', array("class"=>"form-control", "placeholder"=>"Ingrese Alias", "label"=>false, "required"=>"required"));?>
			</div>
			<br/>
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('menu_id', array("type"=>"select","class"=>"form-control", "placeholder"=>"", "label"=>"Menú", 'options' => $menus));?>
			</div>			
		</fieldset>
		<br/><br/><br/>
		<button class="btn btn-primary btn-lg"><i class="fa fa-pencil"></i> Registrar</button>
		<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>  
	<?php echo $this->Form->end(); ?>
</div>

<script>
	$("#PaginaMenuId").select2({
		placeholder: "Seleccione Proveedor",
		allowClear: true,
		width:'100%',
		//minimumInputLength: 2,
		language: "es"
	});
</script>