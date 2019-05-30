<div class="montosFondoFijos form">
<?php echo $this->Form->create('MontosFondoFijo'); ?>
	<fieldset>
		<legend><?php echo __('Edit Montos Fondo Fijo'); ?></legend>
		<input type="hidden" name="moneda_observada" id="moneda_observada" value="<?=$valorMoneda?>" >
		<div class="form-group">
		<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Titulo</label>
		<div class="col-md-6">
			<?php 
			echo $this->Form->input('titulo', 	
			array("class"=>"col-xs-4 form-control requerido", 
			"type"=>"text",
			"label"=>false,
			'placeholder'=>'Titulo',
			//"ng-model"=>"montofijo.titulo",
			'required'=>true
				)
			);
			?>
			<label for="titulo"></label>
		</div>
		
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Area</label>
		<div class="col-md-6">
			<?php 
			echo $this->Form->input('area', 
			array("class"=>"col-xs-4 form-control requerido", 
			"label"=>false, 
			'type'=>'select',
			"options"=>$dimensionUno,
			'empty'=>'Area',
			//"ng-model"=>"montofijo.area",
			'required'=>true
				)
			);
			?>
			<label for="area"></label>
		</div>
		
	</div>

	 <div class="form-group">
                <label class="col-md-4 control-label baja"><span class="aterisco">*</span>Moneda: </label>
                <div class="col-md-6">
                    <?php 
                        echo $this->Form->input('moneda', 
                            array("class"=>"col-xs-4 form-control requerido", 
                                "label"=>false, 
                                'type'=>'select',
                                'empty'=>'Moneda',
                                "options"=>$tipoMonedas,
								"ng-model"=>"montofijo.moneda",
								"value"=>$idMoneda,
                                'required'=>true
                            )
                        );
                    ?>
                    <label for="moneda"></label>
                </div>
            </div>

		<div class="form-group">
		<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Monto: </label>
		<div class="col-md-6">
			<?php 
				echo $this->Form->input('monto', 
					array("class"=>"col-xs-4 form-control ", 
					"label"=>false,  
					"type"=>"text",
					//"ng-model"=>"montofijo.monto",
					'placeholder'=>'Monto',
					'required'=>true
				)
			);
			?>
			<label for="monto"></label>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Estado </label>
		<div class="col-md-6">
				<select name="estado" id="estado" class="col-xs-4 form-control" required>
					<option value="">Seleccione estado</option>
					<option value="1">Activo</option>
					<option value="2">No activo</option>
				</select>
			<label for="estado"></label>
		</div>
		
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Encargado</label>
		<div class="col-md-6">
			<?php 
			echo $this->Form->input('encargado', 
			array("class"=>"col-xs-4 form-control requerido", 
			"label"=>false, 
			'type'=>'select',
			'empty'=>'Encargado',
			"options"=>$usuario,
			"ng-model"=>"montofijo.encargado",
			'required'=>true
				)
			);
			?>

		</div>
		
	</div>
	</fieldset>
<div class="form-group">
	<div class="col-md-6 col-md-offset-4">
		<button type="submit" class="btn-block btn btn-primary btn-lg generarOrden">
		<i class="fa fa-file-text-o"></i> Actualizar Fondo fijo</button>
	</div>
</div>
</div>

<?php 
	echo $this->Html->script(array(
		'bootstrap-datepicker',
        'select2.min'
	));
?>
<script>

	$("#estado").val('<?= $estado?>');
	$("#encargado").val('<?= $encargado?>');
    $("#MontosFondoFijoArea").select2({
        placeholder: "Seleccione Area",
        allowClear: true,
        width:'100%',
	});
	$("#flashMessage").addClass( "alert alert-success" );

	 $("#MontosFondoFijoEncargado").select2({
        placeholder: "Seleccione Area",
        allowClear: true,
        width:'100%',
    });
</script>
