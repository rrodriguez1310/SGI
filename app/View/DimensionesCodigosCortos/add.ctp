<!--div class="dimensionesCodigosCortos form">
<?php echo $this->Form->create('DimensionesCodigosCorto'); ?>
	<fieldset>
		<legend><?php echo __('Add Dimensiones Codigos Corto'); ?></legend>
	<?php
		echo $this->Form->input('nombre');
		echo $this->Form->input('descripcion');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Dimensiones Codigos Cortos'), array('action' => 'index')); ?></li>
	</ul>
</div-->

<div class="container">
  <div class='row'>
    <div class='col-md-4'></div>
    <div class='col-md-4'>
      <div class='col-md-12 form-group'>
        <h4><?php echo __('Registrar'); ?></h4>
         <hr class="featurette-divider"></hr>
         <br/>
         <?php echo $this->Form->create('DimensionesCodigosCorto'); ?>
        <div class='form-row'>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>Nombre corto:</label>
            <?php  echo $this->Form->input('nombre', array("class"=>"form-control", "label"=>false)); ?>
          </div>

          <div class='col-xs-12 form-group required'>
            <label class='control-label'>Nombre completo:</label>
            <?php  echo $this->Form->input('descripcion', array("class"=>"form-control", "label"=>false)); ?>
          </div>
        </div>
        <?php echo $this->Form->button('<i class="fa fa-floppy-o"></i> Guardar', array('class' => 'btn btn-primary btn-block')); ?>
      </div>
    </div>
  </div>
</div>

