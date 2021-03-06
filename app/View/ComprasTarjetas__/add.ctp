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
				<label for="url_producto">Producto</label>
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
				<label for="tipos_moneda_id">Monedas</label>
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
				<label for="monto">Monto</label>
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
				<label for="dimensione_id">Gerencias</label>
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
				<label for="codigo_presupuesto_id">Codigos Presupuestos</label>
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
			<label for="codigo_presupuesto_id">Adjuntar Archivo</label>
			<?php echo $this->Form->input('file',array('type' => 'file',"label"=>false)); ?>
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
		<button type="submit" class="btn btn-primary btn-lg" >Registrar</button>
	<?php echo $this->Form->end(); ?>
</div>

<script>
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
	placeholder: "Seleccione DIMENCIOSSSSSS",
	allowClear: true,
	width:'100%',
	//minimumInputLength: 2,
	//language: "es"
});

$("#ComprasTarjetaCodigoPresupuestoId").select2({
	placeholder: "SDFSDF Código SDSDFSDFSDFSDF",
	allowClear: true,
	width:'100%',
});

/** 

$.ajax({
			url: "<?php echo $this->Html->url(array('controller'=>'Servicios', 'action'=>'addOrdenCompra')); ?>",
			type: "POST",
			data: fd,
			enctype: 'multipart/form-data',
			processData: false,
			contentType: false
		}).done(function(data) {

*/




</script>