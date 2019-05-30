<div class="comprasTarjetas form col-md-8 center col-md-offset-2">
	<?php echo $this->Form->create('SolicitudesRequerimiento'); ?>

	<fieldset>
			
			<div class="alert alert-success" role="alert">
					Fondo por rendir: Es entregado solo una vez, una vez se utiliza el dinero debes entregar la rendición.
			</div>
				<label class="radio-inline">
					<input type="hidden" name="tipo_fondo" value="1" >
				</label>
	</fieldset>
	<div class="row">&nbsp;</div>
		<fieldset>
			<legend><?php echo __('Requerimiento Fondos'); ?></legend>

			<?php echo $this->Form->input('moneda_observada', array(
					'label'=>false,
					'type' => 'hidden'
				));?>
	

			<div class="form-group">
				<label><span class="aterisco">*</span>Fecha entrega fondo</label>
				<?php echo $this->Form->input('fecha', array(
					"type"=>'text',
					"class"=>"col-xs-4 form-control",
					'label'=>false,
					'required'=>false,
					'title'=>'Debe seleccionar una fecha'
				));?>

				<label for="fecha"></label>
			</div>
			<div class="form-group">
				<label><span class="aterisco">*</span>Titulo</label>
				<?php echo $this->Form->input('titulo', array(
					'type'=>'text',
					'class'=>'form-control', 
					'required'=>false,
					'label'=>false
				));?>
				<label for="titulo"></label>
			</div>

			<div class="form-group">
				<label><span class="aterisco">*</span>Monedas</label>
				<?php 	echo $this->Form->input('tipos_moneda_id',array(
						'type'=>'select',
						"class"=>"selectDos form-control", 
						"options"=>$tipoMonedas,
						"label"=>false, 
						'required'=>false,
						"empty"=>"Seleccione Moneda"
					));?>
					
					 <div id="valorObserver" class="alert alert-success esconde" role="alert">...</div>
					 <label for="tipos_moneda_id"></label>
			</div>

			<div class="form-group">
				<label><span class="aterisco">*</span>Monto Solicitado</label>
				<?php echo $this->Form->input('monto', array(
					'type'=>'text',
					'class'=>'form-control', 
					'label'=>false,
					'value'=>0,
					'required'=>false,
					'onkeyup'=>"formatThusanNumber(this)"
				));?>
				<label for="monto"></label>
			</div>

			<div class="form-group">
				<label><span class="aterisco">*</span>Gerencia</label>
				<?php echo $this->Form->input('dimensione_id',array(
					'id'=>'ComprasTarjetaDimensionId',
					    'type'=>'select',
						"class"=>"selectDos form-control", 
						"options"=>$dimensionUno,
						"label"=>false, 
						'required'=>false,
						"empty"=>"Seleccione Gerencia"
					));?>
					<label for="dimensione_id"></label>
			</div>


			<div class="form-group">
				<label for="estadio">Estadios</label>
				<?php echo $this->Form->input('estadio', array(
					  'type'=>'select',
					  "class"=>"selectDos form-control", 
					  "options"=>$dimensionDos,
					  "label"=>false, 
					  "empty"=>"Seleccione Estadio"
				));?>
			</div>

			<div class="form-group">
				<label for="contenido">Contenido</label>
				<?php echo $this->Form->input('contenido', array(
					  'type'=>'select',
					  "class"=>"selectDos form-control", 
					  "options"=>$dimensionTres,
					  "label"=>false, 
					  "empty"=>"Seleccione Contenido"
				));?>
			</div>

			<div class="form-group">
				<label for="canal_distribucion">Canal de distribucion</label>
				<?php echo $this->Form->input('canal_distribucion', array(
					  'type'=>'select',
					  "class"=>"selectDos form-control", 
					  "options"=>$dimensionCuatro,
					  "label"=>false, 
					  "empty"=>"Seleccione Canal"
				));?>
			</div>

			<div class="form-group">
				<label for="otros">Otros</label>
				<?php echo $this->Form->input('otros',array(
						  'type'=>'select',
						  "class"=>"selectDos form-control", 
						  "options"=>$dimensionCinco,
						  "label"=>false, 
						  "empty"=>"Seleccione Canal"
					));?>
			</div>

			<div class="form-group">
				<label for="proyectos">Proyectos</label>
				<?php echo $this->Form->input('proyectos',array(
						'type'=>'select',
						"class"=>"selectDos form-control", 
						"options"=>$proyectos,
						"label"=>false, 
						"empty"=>"Seleccione Proyectos"
					));?>
			</div>
			<div class="form-group">
				<label ><span class="aterisco">*</span>Código presupuestario</label>
				<?php echo $this->Form->input('codigos_presupuesto_id',array(
						'type'=>'select',
						"class"=>"selectDos form-control", 
						"label"=>false, 
						'required'=>false,
						"empty"=>"Seleccione codigo presupuesto"
					));?>
					<label for="codigos_presupuesto_id"></label>
			</div>

			<div class="form-group">
				<label><span class="aterisco">*</span>Observación</label>
				<?php echo $this->Form->input('observacion', array(
					'type'=>'textarea',
					'cols'=>10,
					'rows'=>5,
					'class'=>'form-control', 
					'required'=>false,
					'label'=>false
				));?>
				<label for="observacion"></label>
			</div>

		</fieldset>
		<button type="submit" class="btn btn-primary btn-lg envio" > <i class="fa fa-spinner fa-spin esconde" ></i> Generar Requerimiento</button>
	<?php echo $this->Form->end(); ?>

</div>




<?php 

	echo $this->Html->script(array(
		'bootstrap-datepicker'
	));
?>
<script>

$('.esconde').hide();
$(".envio").on('click', function(event){
	$('.esconde').show();
	//$(".envio").text('Procesando Requerimiento')
})

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
				$("#SolicitudesRequerimientoCodigosPresupuestoId option").remove();
				$("#SolicitudesRequerimientoCodigosPresupuestoId").append("<option value=''>Seleccione codigo presupuesto </option>");
				$.each(data, function(i, item){
					$("#SolicitudesRequerimientoCodigosPresupuestoId").append("<option value="+item.Id+">" +item.Nombre+ "</option>");
				});
			}
			else
			{
				$("#SolicitudesRequerimientoCodigosPresupuestoId").select2("data", null)
			}
		}
	});
})


$("#SolicitudesRequerimientoTiposMonedaId").on("change", function(){
var valor = $(this).val()

if(valor != 1){
	$.ajax({
		type: "GET",
		url:"<?php echo $this->Html->url(array("controller"=>"Servicios", "action"=>"carga_tipo_cambios"))?>",
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

$("#SolicitudesRequerimientoCodigosPresupuestoId").select2({
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