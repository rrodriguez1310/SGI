<div class="alert alert-danger">
  <strong>El campo descripción es obligatorio.</strong> 
</div>
<div style="text-align:center;">
		<h2>Argumente brevemente las razones del reconocimiento.</h2>
</div>

<div class="col-md-12 col-md-offset-1">
	<br/>
	<div class="recognitionCollaborators form">
	
	<?php echo $this->Form->create('RecognitionCollaborator', array('class' => 'form-horizontal')); ?>

        <div class="form-group">
            <label for="" class="col-sm-3 control-label">Colaborador: <span class="aterisco">*</span></label>
            <div class="col-sm-5">
                <?php echo $this->Form->input('', array("value" => $colaborador['Trabajadore']["nombre"], "disabled","type"=>"text", "class"=>"form-control", "label"=>false));?>
            </div>
        </div>

		<fieldset>
			<?php echo $this->Form->input('id', array("value" => $idCollaborator,'type' => 'hidden'));?>

			<?php echo $this->Form->input('subconducts_id', array("value" => $subconduct_id,'type' => 'hidden'));?>

            <?php echo $this->Form->input('employed_id', array("value" => $colaborador['Trabajadore']["id"],'type' => 'hidden'));?>

			<?php echo $this->Form->input('boss_id', array("value" => $jefe['Trabajadore']["id"],'type' => 'hidden'));?>

			<?php echo $this->Form->input( 'points_add', array("value" => $points_subconduct, "type"=>"hidden"));?>

            <?php echo $this->Form->input('points_delete', array('value' => '0', 'type' => 'hidden'));?>

			<?php echo $this->Form->input('product_id', array('value' => '0', 'type' => 'hidden'));?>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Descripción: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('descrption', array("id" => "descrption","required","type"=>"textArea", "class"=>"form-control", "label"=>false));?>
				</div>
			</div>

			<div> 
				<div id="here" class="col-sm-offset-1 col-sm-8 box-footer">
					<a id="volver" href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default pull-left"><i class="fa fa-mail-reply-all"></i> Volver</a>
					<button id="confir" class="btn btn-primary pull-right" type="button" onclick="alerta()"><i class="fa fa-pencil"></i> Reconocer</button> 
					<?php //echo $this->Form->end(); ?>
				</div>
			</div>
		</fieldset>
	</div>
</div>

<script>
$(document).ready(function() {
	$('.alert').hide();
});

function alerta(){
	var html ="";
	var opcion = confirm("¿Desea continuar?");
	var inputs = $("#descrption").val();
	if (opcion == true) {
		if(inputs ==""){
			$('#descrption').css("border", "solid 2px #FA5858");
			$('.alert').show();
			return ;
		}
		html += '<button id="registrar" type="submit"></button>';
		html += '<?php echo $this->Form->end(); ?>';
	
		$('#here').append(html); 
		$('#registrar').click();
		$('#registrar').hide();
		$('#confir').attr("disabled", true);
		$('#volver').attr("disabled", true);
		//$("#registrar").trigger("click");
	}  
}
</script>


