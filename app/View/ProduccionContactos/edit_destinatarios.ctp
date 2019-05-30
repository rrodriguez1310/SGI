<div class="col-md-10 col-md-offset-1">
	<?php echo $this->Form->create('ProduccionContacto', array('class' => 'form-horizontal')); ?>
		<h4><?php echo __('Editar Contacto Producción'); ?></h4>
		<br/>
		<div>
			<?php echo $this->Form->input('id');?>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label baja">Nombre Contacto</label>
			<div class="col-md-8">
				<?php echo $this->Form->input('nombre', array("class"=>"form-control", "placeholder"=>"Ingrese Nombre", "label"=>false, "required"=>"required", 'maxlength'=>'100'));?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label baja">Email</label>
			<div class="col-md-8">
				<?php echo $this->Form->input('email', array("class"=>"form-control minuscula cambia-minuscula", "placeholder"=>"Ingrese Email", 'type'=>'text', 'id'=>'email', 'maxlength'=>'100', "label"=>false, "required"=>"required"));?>
			</div>
		</div>
		<br/>
		<div class="col-md-offset-2">
			<button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-pencil"></i>  Guardar</button> 
        	<button type="submit" id="safe" class="hide">enviar</button>
        	<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>  
		</div>
	<?php echo $this->Form->end(); ?>
</div>

<script>
$(document).ready (function(){
	var reglas = {"data[ProduccionContacto][email]":{required: false, regex: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/}};
	var mensajes = {"data[ProduccionContacto][email]":{regex:"formato de email incorrecto"}};
	$.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
    });
	$('#ProduccionContactoEditDestinatariosForm').validate({
	    submitHandler: function (form) {
	    	return true;
	    },
	    rules:reglas,
		 messages:mensajes
	 });
	$('#ProduccionContactoEditDestinatariosForm').submit(function () {
		if($(this).valid()){
			$("#submit").prop("disabled",true);
			$("#safe").click();
		}
	});
});
</script>