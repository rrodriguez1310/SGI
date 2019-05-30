<div class="col-md-10 col-md-offset-">
	<?php echo $this->Form->create('ProduccionNombreRostro', array('class' => 'form-horizontal')); ?>
			<h4><?php echo __('Editar nombre trabajador módulo producción'); ?></h4>
			<br/>
			<?php echo $this->Form->hidden('ProduccionNombreRostro.id');?>

			<div class="form-group">
		     <label for="TipoContacto" class="col-md-3 control-label baja"> <span class="aterisco">*</span> Nombre Sistema </label>
		     <div class="col-md-8">
		       <?php echo $this->Form->input('ProduccionNombreRostro.nombre_sistema', array("class"=>"form-control mayuscula", "placeholder"=>"Nombre Sistema", "label"=>false, 'maxlength'=>'100', "id"=>"NombreSistema", "readonly"=>"readonly"));?>
		     </div>
		   </div>

			<div class="form-group">
				<label class="col-md-3 control-label baja"><span class="aterisco">*</span> Nombre Corregido </label>
				<div class="col-md-8"> 
					<?php echo $this->Form->input('ProduccionNombreRostro.nombre_produccion', array("class"=>"form-control required mayuscula", "placeholder"=>"Nombre Corregido", "label"=>false, 'maxlength'=>'100', "id"=>"NombreCorregido"));?>
				</div>
			</div>			
		<br>

		<div class="col-md-offset-2">
			<button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i>  Guardar </button> 
        	<button type="submit" id="safe" class="hide">enviar</button>
        	<a href="<?php echo $this->Html->url(array("action"=>"nombres_trabajadores"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver </a>  
		</div>

	<?php echo $this->Form->end(); ?>
</div>
<script>
	$(".mayuscula").on("change", function(){ $(this).val( $(this).val().toUpperCase())});
	$('#ProduccionNombreRostroEditExternosForm').submit(function () {
		if($(this).valid()){
			$("#submit").prop("disabled",true);
		}
	});
</script>