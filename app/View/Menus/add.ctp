<!--hr>
	<ul class="nav nav-pills">
		<li class="pull-right">
			<a href="<?php echo $this->Html->url(array("controller"=>"menus", "action"=>"index"))?>"><i class="fa fa-mail-reply-all"></i> Volver</a>
		</li>
	</ul>
<hr-->

<br/>
<div class="col-md-6 col-md-offset-3">
	<?php echo $this->Form->create('Menu'); ?>
		<fieldset>
			<h4><?php echo __('Registrar Menú'); ?></h4>
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('nombre', array("class"=>"form-control mayuscula", "placeholder"=>"Ingrese Nombre", "label"=>false, "required"=>"required"));?>
			</div>			
		</fieldset>
		<br/><br/><br/>
		<button class="btn btn-primary btn-lg"><i class="fa fa-pencil"></i> Registrar</button>
		<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
	<?php echo $this->Form->end(); ?>
</div>