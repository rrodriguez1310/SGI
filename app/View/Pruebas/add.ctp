<div class="col-md-10 col-md-offset-1">
  <?php echo $this->Form->create('Prueba', array('class' => 'form-horizontal')); ?>
    <h4><?php echo __('Registrar Prueba'); ?></h4>
    <br>
    <div class="form-group">
      <label class="col-md-2 control-label baja">Título</label>
      <div class="col-md-7">
        <?php echo $this->Form->input('Prueba.titulo', array("type"=>"text","class"=>"form-control", "placeholder"=>"Ingrese título", "label"=>false, "required"=>"required", 'maxlength'=>'300', "id"=>"Titulo"));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label baja">Descripción</label>
      <div class="col-md-7">
        <?php echo $this->Form->input('Prueba.descripcion', array("type"=>"text","class"=>"form-control baja", "placeholder"=>"Ingrese descripción", "label"=>false, "required"=>"required", "id"=>"Descripcion"));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label baja">N° Preguntas</label>
      <div class="col-md-7">
        <?php echo $this->Form->input('Prueba.numero_preguntas', array("type"=>"number","class"=>"form-control mayuscula", "placeholder"=>"Ingrese n° preguntas", "label"=>false, "required"=>"required", 'maxlength'=>'100', "id"=>"numero_preguntas"));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label baja">Puntaje Max</label>
      <div class="col-md-7">
        <?php echo $this->Form->input('Prueba.punt_max', array("type"=>"number","class"=>"form-control mayuscula", "placeholder"=>"Ingrese el puntaje max", "label"=>false, "required"=>"required", 'maxlength'=>'100', "id"=>"punt_max"));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label baja">Puntaje Min</label>
      <div class="col-md-7">
        <?php echo $this->Form->input('Prueba.punt_min', array("type"=>"number","class"=>"form-control mayuscula", "placeholder"=>"Ingrese el  puntaje min", "label"=>false, "required"=>"required", 'maxlength'=>'100', "id"=>"punt_min"));?>
      </div>

    </div>
    <br>
    <div class="col-md-offset-2">
      <button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i> Guardar</button>
      <button type="submit" id="safe" class="hide">enviar</button>
      <!--a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a-->
    </div>
    <?php echo $this->Form->end(); ?>
</div>