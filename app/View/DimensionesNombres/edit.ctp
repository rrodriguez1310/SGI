<div class="container">
  <div class='row'>
    <div class='col-md-4'></div>
    <div class='col-md-4'>
      <div class='col-md-12 form-group'>
        <h4><?php echo __('Editar Dimensión Nombre'); ?></h4>
         <hr class="featurette-divider"></hr>
         <br/>
         <?php echo $this->Form->create('DimensionesNombre'); ?>
         <?php  echo $this->Form->input('id'); ?>
        <div class='form-row'>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>Nombre</label>
            <?php  echo $this->Form->input('nombre', array("class"=>"form-control", "label"=>false)); ?>
          </div>
        </div>
        <?php echo $this->Form->button('<i class="fa fa-floppy-o"></i> Guardar', array('class' => 'btn btn-primary btn-block')); ?>
      </div>
    </div>
  </div>
</div>
