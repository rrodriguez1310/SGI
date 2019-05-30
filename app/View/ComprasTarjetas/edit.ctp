<div class="comprasTarjetas form col-md-8 center col-md-offset-2">
	<?php echo $this->Form->create('ComprasTarjeta', array('type'=>'file')); ?>
		<fieldset>
			<legend><?php echo __('Edita compra con tarjeta'); ?></legend>
			<?php 
				echo $this->Form->input('moneda_observada', array(
					'label'=>false,
					'type' => 'hidden'
					));
				echo $this->Form->input('id', array(
					'label'=>false,
					'type' => 'hidden',
					'required'
				));
				echo $this->Form->input('id', array(
					'label'=>false,
					'type' => 'hidden',
					'required'
				));
				
				?>
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
					'type'=>'text',
					'class'=>'form-control', 
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
					'type'=>'number',
					'class'=>'form-control', 
					'label'=>false,
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
					
				));?>
			</div>

			<div class="form-group">
				<label for="dimensione_id">Gerencias</label>
				<?php echo $this->Form->input('dimensione_id',array(
					//'id'=>'ComprasTarjetaDimensionId',
					    'type'=>'select',
						"class"=>"selectDos form-control", 
						"options"=>$dimensione,
						"label"=>false, 
						"empty"=>"Seleccione Gerencia",
						'required',
						//'default' =>  '1000001 - Gerencia General'//$this->request->data['Dimensione']['codigo'] . ' - ' . $this->request->data['Dimensione']['nombre'] 
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
							"empty"=>"Seleccione Estadios",
					
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
							"empty"=>"Seleccione Contenido",
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
							"empty"=>"Seleccione Distribución"
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
							"empty"=>"Seleccione Otros"
						)
					);
				?>
			</div>

			<div class="form-group">
				<label for="proyectos">Proyecto</label>
				<?php 
				///echo $proyectos;

				echo $this->Form->input('proyectos',array(
					
					    'type'=>'select',
						"class"=>"selectDos form-control", 
						"options"=>$proyectos,
						"label"=>false, 
						"empty"=>"Seleccione Proyectos",
						"empty"=>"Seleccione Proyectos"
					));?>
			</div>

			<div class="form-group">
				<label for="codigo_presupuesto_id">Codigos Presupuestos</label>
				<?php echo $this->Form->input('codigo_presupuesto_id',array(
						'type'=>'select',
						"class"=>"selectDos form-control presupuestos", 
						"options"=>$codigoPresupuestoId,
						"label"=>false, 
						"empty"=>"Seleccione Código Presupuesto",
						'required'
					));?>
			</div>
			<div class="form-group">
				<label for="codigo_presupuesto_id">Archivo Subido</label>

				<!--a href="<?= acortarurl($urlDocumento); ?>" target="_blanck">Descargar Archivo</a-->

				<?php 
				$arrayDoc = explode(",", $urlDocumento); 
				for($i=0;$i<count($arrayDoc);$i++){
					$arhivo = basename($arrayDoc[$i]);
					echo "<div class='row'>";
						echo "<a href=".acortarurl($arrayDoc[$i])." target='_blank'>$arhivo</a>";
					echo "</div>";
				}
			?>
				
			</div>

			<div class="form-group">
				<label for="codigo_presupuesto_id">Adjuntar Archivo</label>
				<?php echo $this->Form->input('documento', array("type"=>"file", "file-model"=>"documetosRendicion", "class"=>"requerido", "label"=>false, 'placeholder'=>'Adjuntar archivo'));?>
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
		<button type="submit" class="btn btn-primary btn-lg envio"> <i class="fa fa-spinner fa-spin esconde" ></i> Actualizar</button>
	<?php echo $this->Form->end(); ?>
</div>

<?php
	function acortarurl($url){
		$uris = explode("html", $url);
		return $uris[1];
	}

?>

<script>
$(document).ready(function() {

	//$("#ComprasTarjetaDimensioneId").trigger( "change");
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
				$("#ComprasTarjetaMonedaObservada").val(data);				
			}
		});

	}else{
		$("#valorObserver").text('');
		$("#valorObserver").css('display', 'none')
	}
})
//$("#ComprasTarjetaDimensioneId").trigger( "change" );
$('#ComprasTarjetaDimensioneId option[value="<?php echo $this->request->data['Dimensione']['codigo'] . ' - ' . $this->request->data['Dimensione']['nombre']; ?>"]').attr("selected", true)
		setTimeout(() => {
			$("#ComprasTarjetaDimensioneId").trigger( "change" );
		}, 300);
$("#ComprasTarjetaDimensioneId").on("change", function(){
	var valor = $(this).val();
//	alert(valor)

		$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"codigoPresupuestarioCompraTarjeta"))?>",
		    data: {"valor" : valor},
		    async: true,
		    dataType: "json",
			success: function( data ) {
				if(data != "")
				{	
					$("#ComprasTarjetaCodigoPresupuestoId").select2("destroy");
					$("#ComprasTarjetaCodigoPresupuestoId option").remove();
					$("#ComprasTarjetaCodigoPresupuestoId").append("<option value=''> Codigo Presupuestos</option>");


	
					$.each(data, function(i, item){
						$("#ComprasTarjetaCodigoPresupuestoId").append("<option value="+item.Id+">" +item.Nombre+ "</option>");
					});
					
					
					var codigoPresupuestoId = "<?php echo $codigoPresupuestoIdOsirus; ?>"
                    $('#ComprasTarjetaCodigoPresupuestoId').val(codigoPresupuestoId);

				}
				else
				{
			<?php //echo $this->Form->input('company_id', array("class"=>"requerido proveedor ajuste_select2", "options"=>$proveedores,"label"=>false));?>
					console.log("ENTRO?")
					$("#ComprasTarjetaCodigoPresupuestoId").select2("data", null)
				}
			}
		})
})

	$("#ComprasTarjetaDimensionId").select2({
		placeholder: "Seleccione Gerencia",
		allowClear: true,
		width:'100%',
		//minimumInputLength: 2,
		//language: "es"
	});

	setTimeout(() => {

		//alert("<?php echo $this->request->data['ComprasTarjeta']['codigos_presupuesto_id'] ?>")

		//$('#ComprasTarjetaCodigoPresupuestoId option[value="<?php echo $this->request->data['ComprasTarjeta']['codigos_presupuesto_id'] ?>"]').attr("selected", true)
		/*$("#ComprasTarjetaCodigoPresupuestoId").select2({
				placeholder: "Codigo Presupuestos",
				allowClear: true,
				width:'100%'
			}).select2('val','<?php echo $this->request->data['ComprasTarjeta']['codigos_presupuesto_id'] ?>');*/
	}, 550);

});

</script>
