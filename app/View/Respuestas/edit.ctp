<div class="col-md-10 col-md-offset-1">
  <?php echo $this->Form->create('Respuesta', array('class' => 'form-horizontal')); ?>
    <h4><?php echo __('Editar Respuesta'); ?></h4>
    <br>
    <?php echo $this->Form->input('id');?>
      <div class="form-group">
        <label class="col-md-2 control-label baja">Letra</label>
        <div class="col-md-7">
          <?php echo $this->Form->input('Respuesta.opcion_letra', array("type"=>"text","class"=>"form-control", "placeholder"=>"Ingrese opcion_letra", "label"=>false, "required"=>"required", 'maxlength'=>'300', "id"=>"opcion_letra"));?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label baja">Respuesta</label>
        <div class="col-md-7">
          <?php echo $this->Form->input('Respuesta.opcion_text', array("type"=>"text","class"=>"form-control", "placeholder"=>"Ingrese opcion_text", "label"=>false, "required"=>"required", 'maxlength'=>'300', "id"=>"opcion_text"));?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label baja">Pregunta</label>
        <div class="col-md-7">
          <?php echo $this->Form->input('Respuesta.pregunta_id', array("class"=>"form-control baja", "placeholder"=>"Seleccione pregunta_id", "label"=>false, "required"=>"required", "id"=>"pregunta_id", "empty"=>""));?>
        </div>
      </div>
      <br>
      <div class="col-md-offset-2">
        <button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i> Guardar</button>
        <button type="submit" id="safe" class="hide">enviar</button>
        <a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>  
      </div>
      <?php echo $this->Form->end(); ?>
</div>
<script>
  $(".mayuscula").on("change", function() {
    $(this).val($(this).val().toUpperCase())
  });
</script>