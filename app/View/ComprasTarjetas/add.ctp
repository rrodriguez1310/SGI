<div class="comprasTarjetas form col-md-8 center col-md-offset-2">
	<?php echo $this->Form->create('ComprasTarjeta', array('type'=>'file')); ?>
		<fieldset>
			<legend><?php echo __('Solicitar compra con tarjeta'); ?></legend>

			<?php echo $this->Form->input('moneda_observada', array(
					'label'=>false,
					'type' => 'hidden'
				));?>
	
			<!--div class="form-group">
				<label for="fecha_requerimiento">Fecha Requerimiento</label>
				<?php echo $this->Form->input('fecha_requerimiento', array(
					'id' => 'fecha_requerimiento',
					'class'=>'form-control datepicker readonly-pointer-background', 
					'label'=>false,
					'type' => 'text',
					'required'
				));?>
			</div-->
			<!--div class="form-group">
				<label for="fecha_compra">Fecha Compra</label>
				<?php echo $this->Form->input('fecha_compra', array(
					'id' => 'fecha_compra',
					'class'=>'form-control datepicker readonly-pointer-background', 
					'label'=>false,
					'type' => 'text',
					'required'
				));?>
			</div-->
			<div class="form-group">
				<label for="url_producto"><span class="aterisco">*</span>Producto</label>
				<?php echo $this->Form->input('url_producto', array(
					'class'=>'form-control', 
					'label'=>false,
					'required'
				));?>
			</div>

			<div class="form-group">
				<label for="url">Url</label>
				<?php echo $this->Form->input('url', array(
					'class'=>'form-control', 
					'type'=>'text',
					'label'=>false
				));?>
			</div>

			<div class="form-group">
				<label for="tipos_moneda_id"><span class="aterisco">*</span>Monedas</label>
				<?php 	echo $this->Form->input('tipos_moneda_id',array(
						'type'=>'select',
						"class"=>"selectDos form-control", 
						"options"=>$tipoMonedas,
						"label"=>false, 
						"empty"=>"Seleccione Moneda",
						'required'
					));?> <div id="valorObserver" class="alert alert-success esconde" role="alert">...</div>
			</div>

			<div class="form-group">
				<label for="monto"><span class="aterisco">*</span>Monto</label>
				<?php echo $this->Form->input('monto', array(
					'type'=>'text',
					'class'=>'form-control', 
					'label'=>false,
					'value'=>0,
					'required'
				));?>
			</div>


			 <div class="checkbox"> 
				<label>
					<?php echo $this->Form->input('recurrencia', array(
						'type'=>'checkbox',
						//'class'=>'form-control', 
						'label'=>false,
						'value'=>1
					));?><b>Recurrencia Mensual</b>
				</label> 
			</div>

			<div class="form-group">
				<label for="cuota">Cuotas</label>
				<?php echo $this->Form->input('cuota', array(
					'class'=>'form-control', 
					'label'=>false,
					'value'=>0
				));?>
			</div>

			<div class="form-group">
				<label for="dimensione_id"><span class="aterisco">*</span>Gerencias</label>
				<?php echo $this->Form->input('dimensione_id',array(
					'id'=>'ComprasTarjetaDimensionId',
					    'type'=>'select',
						"class"=>"selectDos form-control", 
						"options"=>$dimensione,
						"label"=>false, 
						"empty"=>"Seleccione Gerencia",
						'required'
					));?>
			</div>

			<div class="form-group">
				<label for="dimensione_id">Estadios</label>
				<?php echo $this->Form->input('dimDos', 
						array(
							"class"=>"form-control", 
							'options'=>$dimensionDos, 
							"label"=>false, 
							'placeholder'=>'Estadios',
							"empty"=>"Estadios"
					
						)
					);
				?>
			</div>

			<div class="form-group">
				<label for="dimensione_id">Contenido</label>
				<?php echo $this->Form->input('dimTres', 
						array(
							"class"=>"form-control", 
							'options'=>$dimensionTres, 
							"label"=>false, 
							'placeholder'=>'Contenido',
							"empty"=>"Contenido"
						)
					);
				?>
			</div>

			<div class="form-group">
				<label for="dimensione_id">Canal distribución</label>
				<?php echo $this->Form->input('dimCuatro', 
						array(
							"class"=>"form-control", 
							'options'=>$dimensionCuatro, 
							"label"=>false, 
							'placeholder'=>'Canal de distribución',
							"empty"=>"Canal de distribución"
						)
					);
				?>
			</div>

			<div class="form-group">
				<label for="dimensione_id">Otros</label>
				<?php 
					echo $this->Form->input('dimCinco', 
						array(
							"class"=>"form-control", 
							'options'=>$dimensionCinco, 
							"label"=>false, 
							'placeholder'=>'Otros',
							"empty"=>"Otros"
						)
					);
				?>
			</div>

			<div class="form-group">
				<label for="proyectos">Proyecto</label>
				<?php echo $this->Form->input('proyectos',array(
					
					    'type'=>'select',
						"class"=>"selectDos form-control", 
						"options"=>$proyectos,
						"label"=>false, 
						"empty"=>"Seleccione Gerencia"
					));?>
			</div>

			<div class="form-group">
				<label for="codigo_presupuesto_id"><span class="aterisco">*</span>Codigos Presupuestos</label>
				<?php echo $this->Form->input('codigo_presupuesto_id',array(
						'type'=>'select',
						"class"=>"selectDos form-control presupuestos", 
						//"options"=>$presupuesto,
						"label"=>false, 
						"empty"=>"Seleccione Código Presupuesto",
						'required'
					));?>
			</div>

		<div class="form-group">
			<label for="codigo_presupuesto_id"><span class="aterisco">*</span>Adjuntar Archivo</label>
			<?php //echo $this->Form->input('file',array('type' => 'file',"label"=>false)); ?>
			<?php echo $this->Form->input('documento', 
			array("type"=>"file", 
					"file-model"=>"documetosRendicion",
					"class"=>"requerido", 
					"label"=>false, 
					'placeholder'=>'Adjuntar archivo',
					));?>
		</div>
			<?php //echo $this->Form->input('company_id', array("class"=>"requerido proveedor ajuste_select2", "options"=>$proveedores,"label"=>false));?>
			<!--div class="form-group">
				<label for="tarjetas_estados_id">Estados</label>
				<?php echo $this->Form->input('tarjeta_estado_id',array(
						"class"=>"selectDos form-control", 
						"options"=>$estado,
						"label"=>false, 
						"empty"=>"",
						'required'
					));?>
			</div-->
		</fieldset>
		<button type="submit" class="btn btn-primary btn-lg envio"> <i class="fa fa-spinner fa-spin esconde" ></i> Registrar</button>
	<?php echo $this->Form->end(); ?>
</div>

<script>
$('.esconde').hide();
$(".envio").on('click', function(event){
	$('.esconde').show();
	//$(".envio").text('Procesando Requerimiento')
})
$("#ComprasTarjetaTiposMonedaId").on("change", function(){
	var valor = $(this).val()
	if(valor != 1){
		$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"carga_tipo_cambios"))?>",
		    data: {"valor" : valor},
		    async: true,
		    dataType: "json",
			success: function( data ) {
				$("#valorObserver").css('display', 'block')
				$("#valorObserver").text('valor observado ' + data);	
				//alert(data)
				$("#ComprasTarjetaMonedaObservada").val(data)
			}
		});

	}else{
		$("#valorObserver").text('');
		$("#valorObserver").css('display', 'none')
	}
})

$("#ComprasTarjetaDimensionId").on("change", function(){
	var valor = $(this).val()
		$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"codigoPresupuestarioCompraTarjeta"))?>",
		    data: {"valor" : valor},
		    async: true,
		    dataType: "json",
			success: function( data ) {
				if(data != "")
				{	
					$("#ComprasTarjetaCodigoPresupuestoId option").remove();
					$("#ComprasTarjetaCodigoPresupuestoId").append("<option value=''> </option>");
					$.each(data, function(i, item){
						$("#ComprasTarjetaCodigoPresupuestoId").append("<option value="+item.Id+">" +item.Nombre+ "</option>");
					});
				}
				else
				{
		
			<?php //echo $this->Form->input('company_id', array("class"=>"requerido proveedor ajuste_select2", "options"=>$proveedores,"label"=>false));?>
					console.log("ENTRO?")
					$("#ComprasTarjetaCodigoPresupuestoId").select2("data", null)
				}
			}
		});
})


$("#ComprasTarjetaDimensionId").select2({
	placeholder: "",
	allowClear: true,
	width:'100%',
	//minimumInputLength: 2,
	//language: "es"
});

$("#ComprasTarjetaCodigoPresupuestoId").select2({
	placeholder: "",
	allowClear: true,
	width:'100%',
});
$("#ComprasTarjetaDimDos").select2({
	placeholder: "",
	allowClear: true,
	width:'100%',
});
$("#ComprasTarjetaDimTres").select2({
	placeholder: "",
	allowClear: true,
	width:'100%',
});
$("#ComprasTarjetaDimCuatro").select2({
	placeholder: "",
	allowClear: true,
	width:'100%',
});
$("#ComprasTarjetaDimCinco").select2({
	placeholder: "",
	allowClear: true,
	width:'100%',
});

$("#proyectos").select2({
	placeholder: "",
	allowClear: true,
	width:'100%',
});
</script>