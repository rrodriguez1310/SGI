<div class="col-md-10 col-md-offset-1">
  <?php echo $this->Form->create('ProduccionMcrReceptore', array('class' => 'form-horizontal')); ?>
    <h3><?php echo __('Registrar Receptor'); ?></h3>
      <div class="form-group">
        <label class="col-md-2 control-label baja">Nombre</label>
        <div class="col-md-7">
          <?php echo $this->Form->input('ProduccionMcrReceptore.nombre', array("type"=>"text","class"=>"form-control", "placeholder"=>"Ingrese nombre", "label"=>false, "required"=>"required", 'maxlength'=>'300', "id"=>"nombre"));?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label baja">Medio</label>
        <div class="col-md-7">
          <?php echo $this->Form->input('ProduccionMcrReceptore.transmision_medio_transmisione_id', array("class"=>"form-control mayuscula", "placeholder"=>"Ingrese medio", "label"=>false, "required"=>"required", 'maxlength'=>'300', "id"=>"transmision_medio_transmisione_id"));?>
        </div>
      </div>
     

      <br>
      <div class="col-md-offset-2">
        <button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i> Guardar</button>
        <button type="submit" id="safe" class="hide">enviar</button>
        <!--a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a-->
      </div>
</div>

<script>
  $(" #transmision_medio_transmisione_id").select2();
  $(" #transmision_medio_transmisione_id").select2('data', null);
  $(".mayuscula").on("change", function() {
    $(this).val($(this).val().toUpperCase())
  });
</script>