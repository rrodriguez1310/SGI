<div class="comprasTarjetas form col-md-8 center col-md-offset-2">
	<?php 
		echo $this->Form->create('SolicitudesRequerimiento', array('type'=>'radio')); 
		echo $this->Form->input('id',array("type"=>'hidden'));
		echo $this->Form->input('user_id',array("type"=>'hidden'));
		echo $this->Form->input('estado',array("type"=>'hidden'));
	?>

	<fieldset>

			<?php echo $this->Form->input('tipo_fondo', array(
					"type"=>'hidden',
					"class"=>"col-xs-4 form-control requerido",
					'label'=>false,
					'required'
				));?>

				<div class="alert alert-success" role="alert">
					Fondo por rendir: Es entregado solo una vez, una vez se utiliza el dinero debes entregar la rendición.
				</div>
				<label class="radio-inline">
					<input type="radio" name="tipo_fondo" value="1" id="radio_1" required><strong>Fondo por rendir</strong>
				</label>
	</fieldset>
	<div class="row">&nbsp;</div>
		<fieldset>
			<legend><?php echo __('Requerimiento Fondos'); ?></legend>

			<?php echo $this->Form->input('moneda_observada', array(
					'label'=>false,
					'type' => 'hidden'
				));
				?>
	

			<div class="form-group">
				<label for="fecha"><span class="aterisco">*</span>Fecha entrega fondo</label>
				<?php echo $this->Form->input('fecha', array(
					"type"=>'text',
					"class"=>"col-xs-4 form-control requerido",
					'label'=>false,
					'required'=>false
				));
				?>
			</div>
			<div class="form-group">
				<label for="titulo"><span class="aterisco">*</span>Titulo</label>
				<?php echo $this->Form->input('titulo', array(
					'type'=>'text',
					'class'=>'form-control', 
					'label'=>false,
					'required'=>false
				));
				?>
			</div>

			<div class="form-group">
				<label for="tipos_moneda_id"><span class="aterisco">*</span>Monedas</label>
				<?php 	echo $this->Form->input('tipos_moneda_id',array(
						'type'=>'select',
						"class"=>"selectDos form-control", 
						"options"=>$tipoMonedas,
						"label"=>false, 
						"empty"=>"Seleccione Moneda",
						'required'=>false
					));?> <div id="valorObserver" class="alert alert-success esconde" role="alert">...</div>
			</div>

			<div class="form-group">
				<label for="monto"><span class="aterisco">*</span>Monto Solicitado</label>
				<?php echo $this->Form->input('monto', array(
					'type'=>'text',
					'class'=>'form-control', 
					'label'=>false,
					"onkeyup"=>"formatThusanNumber(this)",
					'required'=>false
				));
				?>
			</div>

			<div class="form-group">
				<label for="dimensione_id"><span class="aterisco">*</span>Gerencia</label>
				<?php echo $this->Form->input('dimensione_id',array(
					'id'=>'ComprasTarjetaDimensionId',
					    'type'=>'select',
						"class"=>"selectDos form-control", 
						"options"=>$dimensione,
						"label"=>false, 
						"empty"=>"Seleccione Gerencia",
						'required'=>false
					));
					?>
			</div>


			<div class="form-group">
				<label for="estadios">Estadios</label>
				<?php echo $this->Form->input('estadios', array(
					  'type'=>'select',
					  "class"=>"selectDos form-control", 
					  "options"=>$dimensionDos,
					  "label"=>false, 
					  "empty"=>"Seleccione Estadio"
				));
				?>
			</div>

			<div class="form-group">
				<label for="contenido">Contenido</label>
				<?php echo $this->Form->input('contenido', array(
					  'type'=>'select',
					  "class"=>"selectDos form-control", 
					  "options"=>$dimensionTres,
					  "label"=>false, 
					  "empty"=>"Seleccione Contenido"
				));
				?>
			</div>

			<div class="form-group">
				<label for="canal_distribucion">Canal de distribucion</label>
				<?php echo $this->Form->input('canal_distribucion', array(
					  'type'=>'select',
					  "class"=>"selectDos form-control", 
					  "options"=>$dimensionCuatro,
					  "label"=>false, 
					  "empty"=>"Seleccione Canal"
				));
				?>
			</div>

			<div class="form-group">
				<label for="otros">Otros</label>
				<?php echo $this->Form->input('otros',array(
						  'type'=>'select',
						  "class"=>"selectDos form-control", 
						  "options"=>$dimensionCinco,
						  "label"=>false, 
						  "empty"=>"Seleccione Canal"
					));
					?>
			</div>

			<div class="form-group">
				<label for="proyectos">Proyectos</label>
				<?php echo $this->Form->input('proyectos',array(
						'type'=>'select',
						"class"=>"selectDos form-control", 
						"options"=>$proyectos,
						"label"=>false, 
						"empty"=>"Seleccione Proyectos"
					));
					?>
			</div>
			<div class="form-group">
				<label for="codigos_presupuesto_id"><span class="aterisco">*</span>Código presupuestario</label>

					<select name="codigos_presupuesto_id" id="codigos_presupuesto_id" required>
					</select>
			</div>

			<div class="form-group">
				<label for="monto"><span class="aterisco">*</span>Observación</label>
				<?php echo $this->Form->input('observacion', array(
					'type'=>'textarea',
					'class'=>'form-control', 
					'cols'=>10,
					'rows'=>5,
					'label'=>false,
					'required'=>false
				));
				?>
			</div>
		</fieldset>
		<button type="submit" class="btn btn-primary btn-lg" >Actualizar Requerimiento</button>
	<?php echo $this->Form->end(); ?>
</div>
<?php 

	echo $this->Html->script(array(
		'bootstrap-datepicker'
	));
?>
<script>

var tipo = $("#SolicitudesRequerimientoTipoFondo").val();
if(tipo==1){
	$("#radio_1").prop("checked", true);
}else{
	$("#radio_2").prop("checked", true);
}

$('#SolicitudesRequerimientoFecha').datepicker({
	format: "yyyy-mm-dd",
	//startView: 1,
	language: "es",
	multidate: false,
	// daysOfWeekDisabled: "0, 6",
	autoclose: true,
	viewMode: "week",
	Default: false
});

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
					$("#codigos_presupuesto_id option").remove();
					$("#codigos_presupuesto_id").append("<option value=''>Seleccione codigo presupuesto </option>");
					$.each(data, function(i, item){
						$("#codigos_presupuesto_id").append("<option value="+item.Id+">" +item.Nombre+ "</option>");
					});
				}
				else
				{
					console.log("ENTRO?")
					$("#codigos_presupuesto_id").select2("data", null)
				}
			}
		});
})


$("#ComprasTarjetaDimensionId").trigger( "change" );
	
	setTimeout(() => {
	
		$("#codigos_presupuesto_id").select2({
					placeholder: "Codigo Presupuestos",
					allowClear: true,
					width:'100%'
				}).select2('val','<?php echo $this->request->data['SolicitudesRequerimiento']['codigos_presupuesto_id'] ?>');
	}, 300);


$("#SolicitudesRequerimientoTiposMonedaId").on("change", function(){
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
				$("#SolicitudesRequerimientoMonedaObservada").val(data)
			}
		});

	}else{
		$("#valorObserver").text('');
		$("#valorObserver").css('display', 'none')
	}
})

$("#ComprasTarjetaDimensionId").select2({
	placeholder: "Seleccione Dimencion",
	allowClear: true,
	width:'100%',
});

$("#SolicitudesRequerimientoEstadio").select2({
	placeholder: "Seleccione Dimencion",
	allowClear: true,
	width:'100%',
});

$("#SolicitudesRequerimientoContenido").select2({
	placeholder: "Seleccione Dimencion",
	allowClear: true,
	width:'100%',
});

$("#SolicitudesRequerimientoCanalDistribucion").select2({
	placeholder: "Seleccione Dimencion",
	allowClear: true,
	width:'100%',
});

$("#SolicitudesRequerimientoOtros").select2({
	placeholder: "Seleccione Dimencion",
	allowClear: true,
	width:'100%',
});

$("#SolicitudesRequerimientoProyectos").select2({
	placeholder: "Seleccione Dimencion",
	allowClear: true,
	width:'100%',
});

$("#codigos_presupuesto_id").select2({
	placeholder: "Seleccione Dimencion",
	allowClear: true,
	width:'100%',
});

function formatThusanNumber(input){
        var num = input.value .replace(/\./g,'');
        if(!isNaN(num)){
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
           // $("#monto").val(num);
        }
        else
        { 
            alert('Solo se permiten numeros');
            input.value = input.value.replace(/[^\d\.]*/g,'');
        }
    }
</script>
