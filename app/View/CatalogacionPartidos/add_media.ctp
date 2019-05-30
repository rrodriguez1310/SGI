<div class="col-sm-offset-3 col-sm-8">
	<h4><?php echo __('Ingresar Media'); ?></h4>
</div>
<br/><br/>
<div class="col-md-12 col-md-offset-1">
	<?php echo $this->Form->create('Ingesta', array('class' => 'form-horizontal')); ?>

		<div class="form-group">
			<label for="numero" class="col-sm-3 control-label baja"><span class="aterisco">*</span>Número: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('numero', array("class"=>"form-control", "label"=>false, "placeholder"=>"Número"));?>
			</div>
		</div>	

		<div class="form-group">
			<label for="fecha_partido" class="col-sm-3 control-label baja"><span class="aterisco">*</span>Fecha partido: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('fecha_partido', array("class"=>"form-control fecha", "label"=>false, "placeholder"=>"Fecha partido"));?>
			</div>
		</div>

		<div class="form-group">
			<label for="fecha_torneo" class="col-sm-3 control-label baja"><span class="aterisco" id="spanRut">*</span>Fecha torneo: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('fecha_torneo', array("class"=>"form-control fecha", "label"=>false, "placeholder"=>"Fecha torneo"));?>
			</div>
		</div>

		<div class="form-group">
			<label for="equipo_local" class="col-sm-3 control-label"><span class="aterisco">*</span>Ingrese equipo local: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('equipo_local', array("class"=>"form-control local", "label"=>false, "placeholder"=>"Equipo local", "options"=>$equipos, 'empty'=>array(0 => 'Ingrese equipo local')));?>
			</div>
		</div>

		<div class="form-group">
			<label for="equipo_visita" class="col-sm-3 control-label"><span class="aterisco">*</span>Ingrese equipo visita: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('equipo_visita', array("class"=>"form-control visita", "label"=>false, "placeholder"=>"Equipo visita", "options"=>$equipos, 'empty'=>array(0 => 'Ingrese equipo visita')));?>
				<?php echo $this->Form->hidden('nombre'); ?>
			</div>
		</div>

		<div class="form-group">
			<label for="copia_id" class="col-sm-3 control-label">Tipo de copia: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('copia_id', array("class"=>"form-control copia", "label"=>false, "placeholder"=>"Copia", 'empty'=>array(0 => 'Seleccione tipo de copia')));?>
			</div>
		</div>

		<div class="form-group">
			<label for="campeonato_id" class="col-sm-3 control-label">Campeonato: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('campeonato_id', array("class"=>"form-control campeonato", "label"=>false, "placeholder"=>"Campeonato", 'empty' => array(0 => 'Seleccione campeonato')));?>
			</div>
		</div>

		<div class="form-group">
			<label for="almacenamiento_id" class="col-sm-3 control-label">Almacenamiento: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('almacenamiento_id', array("class"=>"form-control almacenamiento", "label"=>false, "placeholder"=>"Almacenamiento", 'empty' => array(0 => 'Seleccione almacenamiento')));?>
			</div>
		</div>

		<div class="form-group">
			<label for="soporte_id" class="col-sm-3 control-label">Soporte: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('soporte_id', array("class"=>"form-control soporte", "label"=>false, "placeholder"=>"Soporte", 'empty' => array(0 => 'Seleccione soporte')));?>
			</div>
		</div>

		<div class="form-group">
			<label for="tiempo_id" class="col-sm-3 control-label">Tiempo: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('tiempo_id', array("class"=>"form-control tiempo", "label"=>false, "placeholder"=>"Tiempo", 'empty' => array(0 => 'Seleccione tiempo')));?>
			</div>
		</div>

		<div class="form-group">
			<label for="observacion" class="col-sm-3 control-label">Observación: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->textArea('observacion', array("class"=>"form-control observacion", "label"=>false, "placeholder"=>"Observación"));?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-5">
				<?php echo $this->Form->hidden('user_id', array("type"=>"hidden", "class"=>"form-control", "label"=>false, "placeholder"=>"Usuario", "default"=>$this->Session->read("Users.trabajadore_id")));?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-8">
				<button type="submit" class="btn btn-primary">Registrar <i class="fa fa-plus"></i></button>
				<button href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="btn btn-default"><i class="fa fa-mail-reply-all"></i> Volver</button> 
			</div>
		</div>	
	
	<?php echo $this->Form->end(); ?>

</div>

<!--div class="col-md-6 col-md-offset-3">
	<?php echo $this->Form->create('Ingesta'); ?>
		<div class="form-group">
			<?php echo $this->Form->input('numero', array("class"=>"form-control", "label"=>false, "placeholder"=>"Numero"));?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->input('fecha_partido', array("class"=>"form-control fecha", "label"=>false, "placeholder"=>"Fecha partido"));?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->input('fecha_torneo', array("class"=>"form-control fecha", "label"=>false, "placeholder"=>"Fecha torneo"));?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->input('equipo_local', array("class"=>"form-control local", "label"=>false, "placeholder"=>"Equipo local", "options"=>$equipos, 'empty'=>array(0 => 'Ingrese equipo local')));?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->input('equipo_visita', array("class"=>"form-control visita", "label"=>false, "placeholder"=>"Equipo visita", "options"=>$equipos, 'empty'=>array(0 => 'Ingrese equipo visita')));?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->input('copia_id', array("class"=>"form-control copia", "label"=>false, "placeholder"=>"Copia", 'empty'=>array(0 => 'Seleccione tipo de copia')));?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->input('campeonato_id', array("class"=>"form-control campeonato", "label"=>false, "placeholder"=>"Campeonato", 'empty' => array(0 => 'Seleccione campeonato')));?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->input('almacenamiento_id', array("class"=>"form-control almacenamiento", "label"=>false, "placeholder"=>"Almacenamiento", 'empty' => array(0 => 'Seleccione almacenamiento')));?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->input('soporte_id', array("class"=>"form-control soporte", "label"=>false, "placeholder"=>"Soporte", 'empty' => array(0 => 'Seleccione soporte')));?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->input('tiempo_id', array("class"=>"form-control tiempo", "label"=>false, "placeholder"=>"Tiempo", 'empty' => array(0 => 'Seleccione tiempo')));?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->textArea('observacion', array("class"=>"form-control observacion", "label"=>false, "placeholder"=>"Observación"));?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->hidden('user_id', array("type"=>"text", "class"=>"form-control", "label"=>false, "placeholder"=>"Usuario", "default"=>$this->Session->read("Users.trabajadore_id")));?>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary btn">Registrar <i class="fa fa-plus"></i></button>
		</div>

	<?php echo $this->Form->end(); ?>
</div-->
<?php echo $this->Html->script(array('bootstrap-datepicker'));?>
<script>
	$("#IngestaEquipoLocal").select2({
		placeholder: "Seleccione equipo local",
		allowClear: true,
		width:'100%',
		minimumInputLength: 2,
		language: "es"
	});

	$("#IngestaEquipoVisita").select2({
		placeholder: "Seleccione equipo visita",
		allowClear: true,
		width:'100%',
		minimumInputLength: 2,
		language: "es"
	});

	$("#IngestaCopiaId").select2({
		placeholder: "Seleccione tipo de copia",
		allowClear: true,
		width:'100%',
		minimumInputLength: 2,
		language: "es"
	});

	$("#IngestaCampeonatoId").select2({
		placeholder: "Seleccione tipo de campeonato",
		allowClear: true,
		width:'100%',
		minimumInputLength: 2,
		language: "es"
	});

	$("#IngestaAlmacenamientoId").select2({
		placeholder: "Seleccione almacenamiento",
		allowClear: true,
		width:'100%',
		minimumInputLength: 2,
		language: "es"
	});

	$("#IngestaSoporteId").select2({
		placeholder: "Seleccione soporte",
		allowClear: true,
		width:'100%',
		minimumInputLength: 2,
		language: "es"
	});

	$("#IngestaTiempoId").select2({
		placeholder: "Seleccione soporte",
		allowClear: true,
		width:'100%',
		minimumInputLength: 2,
		language: "es"
	});

	$('.fecha').datepicker({
	    format: "yyyy-mm-dd",
	    language: "es",
	    multidate: false,
	    autoclose: true,
	    required: true,
    });
</script>