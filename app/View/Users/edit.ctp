<!--hr>
	<ul class="nav nav-pills">
		<li class="pull-right">
			<a href="<?php echo $this->Html->url(array("controller"=>"users", "action"=>"index"))?>"><i class="fa fa-mail-reply-all"></i> Volver</a>
		</li>
	</ul>
<hr-->
<div class="col-md-6 col-md-offset-3">
	<?php echo $this->Form->create('User'); ?>
		<fieldset>
			<h4><?php echo __('Editar Usuario'); ?></h4>
			
			<?php echo $this->Form->input('id');?>
			
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('User.trabajadore_id', array("class"=>"select2", "label"=>false, "required"=>"required", "options"=>$trabajadores));?>
			</div>
			<br/>
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('User.nombre', array("class"=>"select21", "label"=>false, "required"=>"required", "options"=>$usuarios));?>
			</div>
			<br/>
		</fieldset>
		<br/><br/><br/>
		<button class="btn btn-primary btn-lg"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
		<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
	<?php echo $this->Form->end(); ?>
</div>

<script>

	$(".select2").select2({
		placeholder: "Busque trabajador",
		allowClear: true,
		width:'100%',
		minimumInputLength: -1
	});
	$(".select21").select2({
		placeholder: "Seleccione usuario correspondiente",
		allowClear: true,
		width:'100%',
		minimumInputLength: 3,
	});
	$(".select22").select2({
		placeholder: "Seleccione Rol",
		allowClear: true,
		width:'100%',
		minimumInputLength: -1,
	});
</script>