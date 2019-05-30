<div class="col-md-10 col-md-offset-1">
	<?php echo $this->Form->create('ProduccionContacto', array('class' => 'form-horizontal')); ?>
			<h4><?php echo __('Editar responsables CDF producción'); ?></h4>
			<br/>
			<div>
				<?php echo $this->Form->input('id');?>
			</div>
			<div class="form-group">
		     <label for="TipoContacto" class="col-md-2 control-label"> <span class="aterisco">*</span> Responsable </label>
		     <div class="col-md-8">
		       <?php echo $this->Form->input('company_id', array("type"=>"select", "class"=>"form-control required", "empty"=>"", "placeholder"=>"Seleccione Responsable",  "label"=>false, "id"=> "Responsable", 'maxlength'=>'100'));?>
		     </div>
		   </div>

			<div class="form-group">
		     <label for="TipoContacto" class="col-md-2 control-label"> <span class="aterisco">*</span> Cargo </label>
		     <div class="col-md-8">
		       <?php echo $this->Form->input('tipo_contacto', array("type"=>"select", "class"=>"form-control required", "empty"=>"", "placeholder"=>"Seleccione Cargo",  "label"=>false, "id"=> "Cargo", 'maxlength'=>'100'));?>
		     </div>
		   </div>

			<div class="form-group">
				<label class="col-md-2 control-label baja"><span class="aterisco">*</span> Nombre</label>
				<div class="col-md-8"> 
					<?php echo $this->Form->input('nombre', array("class"=>"form-control required mayuscula", "placeholder"=>"Registre Nombre", "label"=>false, 'maxlength'=>'100', "id"=>"Nombre"));?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label baja">Email</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('email', array("class"=>"form-control minuscula", "placeholder"=>"Email", 'type'=>'text', 'maxlength'=>'100', "label"=>false));?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label baja">Teléfono</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('telefono', array("class"=>"form-control", "placeholder"=>"Teléfono", "label"=>false, 'maxlength'=>'100'));?>
				</div>
			</div>

		<br>

		<div class="col-md-offset-2">
			<button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i>  Guardar</button> 
        	<button type="submit" id="safe" class="hide">enviar</button>
        	<a href="<?php echo $this->Html->url(array("action"=>"listar_responsables"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>  
		</div>
	<?php echo $this->Form->end(); ?>
</div>

<script>
		
	var reglas = { "data[ProduccionContacto][email]":{required: false, regex: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/} };
	var mensajes = {"data[ProduccionContacto][email]":{regex:"formato de email incorrecto"}};

	$.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
    });

	$('#ProduccionContactoEditResponsablesCdfForm').validate({	 
	    submitHandler: function (form) {
	    	return true;
	    },
	    rules:reglas,
		 messages:mensajes
	 });

	$("#Cargo,#Responsable").select2({
         allowClear:false,
         placeholder: '',
         width:'100%'
      });

	$("#Cargo,#Responsable").select2("readonly", true);

	$(".minuscula").on("change", function(){ $(this).val( $(this).val().toLowerCase())});
	$(".mayuscula").on("change", function(){ $(this).val( $(this).val().toUpperCase())});
	$('#ProduccionContactoEditResponsablesCdfForm').submit(function () {
		if($(this).valid()){
			$("#submit").prop("disabled",true);
		}
	});

</script>