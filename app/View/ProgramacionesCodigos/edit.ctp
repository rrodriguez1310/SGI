<?php echo $this->Form->create('ProgramacionesCodigo'); ?>
	<?php echo $this->Form->input('id');?>
	<legend><?php echo __('Editar código'); ?></legend>
  <div class="form-group">
    <label for="exampleInputEmail1">titulo</label>
	<?php echo $this->Form->input('titulo', array('label'=>false, 'div'=>false, 'class'=>'form-control')) ;?>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">descripción</label>
    <?php echo $this->Form->input('descripcion', array('label'=>false, 'div'=>false, 'class'=>'form-control')) ;?>
  </div>
  <div class="form-group">
    <label for="exampleInputFile">Tiempo Aproximado</label>
   <?php echo $this->Form->input('tiempo_aproximado', array('label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
  </div>
   <div class="form-group">
    <label for="exampleInputFile">Tiempo</label>
   <?php echo $this->Form->input('tiempo', array('label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
  </div>

  <div class="form-group">
    <label for="exampleInputFile">Familia</label>
   <?php echo $this->Form->input('familia', array('label'=>false, 'div'=>false, 'class'=>'form-control')); ?>
  </div>
<?php echo $this->Form->end(__('Registrar')); ?>
