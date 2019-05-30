<form class="form-horizontal" method="post" id="fileinfo" name="fileinfo" role="form">
	<input type="hidden" id="impuesto" name="impuesto" value="<?php echo $comprasProductosTotale["ComprasProductosTotale"]["impuesto"]?>">
	<input type="hidden" id="tipo_documento" name="tipo_documento" value="<?php echo $comprasProductosTotale["ComprasProductosTotale"]["tipos_documento_id"]?>">
	<?php
	$options = $tipoDocumentos;
	$attributes = array('div' => 'input', 'type' => 'radio', 'options' => $options, 'class'=>'radio_botom', 'required'=>true);
	echo $this->Form->input('tipo_documento',$attributes);
	?>
	
	<fieldset>
		<legend>Requerimiento de compra</legend>
		
		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Fecha Documento </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('fecha_documento', array("class"=>"col-xs-4 form-control requerido", "label"=>false, 'placeholder'=>'Fecha Documento', 'default'=>$comprasProductosTotale["ComprasFactura"][0]["fecha_documento"]));?>
			</div>
		</div>


		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>N° Documento </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('numero_documento', array("class"=>"col-xs-4 form-control requerido", "label"=>false, 'placeholder'=>'N° Documento', 'default'=>""));?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Titulo </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('titulo', array("class"=>"col-xs-4 form-control", "label"=>false, 'placeholder'=>'titulo', 'default'=>"Nota de credito", "readonly"=>true));?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Seleccione proveedor : </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('company_id', array("class"=>"proveedor ajuste_select2 requerido", "options"=>$proveedores,"label"=>false, 'readonly'=>true));?>
			</div>
			<div class="col-md-2">
				<!--a href="<?php echo $this->Html->url(array("controller"=>"companies", "action"=>"add", 1)); ?>" class="btn btn-primary btn-xs tool registraempresa" data-toggle="tooltip" data-placement="top" title="Ingresar empresa" target="_blank"><i class="fa fa-plus"></i></a-->
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput">Seleccione moneda : </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('tipo_moneda_id', array("class"=>"tipoMoneda ajuste_select2", "options"=>$tipoMonedas, "label"=>false, 'requiered'=>true));?>
			</div>
		</div>

		<div class="form-group tipo_cambio" style="display:none">
			<label class="col-md-4 control-label baja" for="passwordinput">Tipo de cambio : </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('tipo_cambio', array("class"=>"form-control", "label"=>false, 'default'=>$comprasProductosTotale['ComprasProductosTotale']['tipo_cambio'], 'readonly'=>true));?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput">Seleccione pago : </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('plazos_pago_id', array("class"=>"plazoPago ajuste_select2 requerido", "label"=>false, "options"=>$plazosPagos));?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button type="button" class="btn-block btn btn-success btn-lg" data-toggle="modal" data-target="#ingresoProducto"><i class="fa fa-shopping-cart"></i> Ingresar Producto</button>
			</div>
		</div>
	</fieldset>

	<fieldset><legend>Detalle de productos ingresados</legend>

	<table class="table table-striped table-bordered">
	    <thead>
	        <tr>
				<th>Can.</th>
				<th>Impuesto</th>
				<th>Des.</th>
				<th>P. Uni.</th>
				<th>Desc $</th>
				<th>Emp.</th>
				<th>Gere.</th>
				<th>Esta.</th>
				<th>Cont.</th>
				<th>C. Distr.</th>
				<th>Otros</th>
				<th>Proy.</th>
				<th>Cod. Pres.</th>
				<th>SubT.</th>
				<th class="ocultar">Total</th>
				<th></th>
			</tr>
	    </thead>
	    <tbody class="productos">
	    	<?php 
	    		foreach($comprasProductosTotale["ComprasProducto"] as $productos) : 
	    		if($productos["estado"] != 0)
	    		{
	    		$netoSinDescuento[] = $productos["cantidad"] * str_replace(".","",$productos["precio_unitario"]);
	    		$descuentosProductos[] = str_replace(".","",$productos["descuento_producto"]);

	    	?>
				<tr class="dato">
			    	<td class="eliminar"> <input type="hidden" name="cantidad[]" value="<?php echo $productos["cantidad"];?>"><?php echo $productos["cantidad"];?></td>
					<td> <input type="hidden" name="afecto[]" value="<?php echo $productos["afecto"];?>"><?php echo ($productos["afecto"] == 1) ? "Afecto" : "Exento" ;?></td>
					<td> <input type="hidden" name="descripcion[]" value="<?php echo $productos["descripcion"];?>"><?php echo $productos["descripcion"];?></td>
					<td class="precio_unitario"> <input type="hidden" name="precio[]" value="<?php echo $productos["precio_unitario"];?>"><?php echo $productos["precio_unitario"];?></td>
					<td class="descuento_tabla"> <input type="hidden" name="descuento_unitario[]" value="<?php echo $productos["descuento_producto"];?>"><?php echo $productos["descuento_producto"];?></td>
					<td> <input type="hidden" name="empaque[]" value="<?php echo $productos["empaque"];?>" ><?php echo $productos["empaque"];?></td>
					<td title="<?php echo $productos["dim_uno"];?>" id="codigoUno-<?php echo $productos["dim_uno"];?>"><input type="hidden" name="dimCodigoUno[]" value="<?php echo $productos["dim_uno"];?>"><?php echo $productos["dim_uno"];?></td>
					<td title="<?php echo $productos["dim_dos"];?>" id="codigoDos-<?php echo $productos["dim_dos"];?>" > <input type="hidden" name="dimCodigoDos[]" value="<?php echo $productos["dim_dos"];?>"><?php echo $productos["dim_dos"];?></td>
					<td title="<?php echo $productos["dim_tres"];?>" id="codigoTres-"<?php echo $productos["dim_tres"];?> ><input type="hidden" name="dimCodigoTres[]" value="<?php echo $productos["dim_tres"];?>"><?php echo $productos["dim_tres"];?></td>
					<td title="<?php echo $productos["dim_cuatro"];?>" id="codigoCuatro-<?php echo $productos["dim_cuatro"];?>"> <input type="hidden" name="dimCodigoCuatro[]" value="<?php echo $productos["dim_cuatro"];?>"><?php echo $productos["dim_cuatro"];?></td>
					<td title="<?php echo $productos["dim_cinco"];?>" id="codigoCinco-<?php echo $productos["dim_cinco"];?>" > <input type='hidden' name='dimCodigoCinco[]' value="<?php echo $productos["dim_cinco"];?>"><?php echo $productos["dim_cinco"];?></td>
					<td title="<?php echo $productos["proyecto"];?>" id="proyecto-<?php echo $productos["proyecto"];?>"> <input type="hidden" name="proyecto[]" value="<?php echo $productos["proyecto"];?>"><?php echo $productos["proyecto"];?></td>
					<td> <input type="hidden" name="codigoPresupuestario[]" value="<?php echo $productos["codigos_presupuestarios"];?>"><a style="cursor:pointer" class="codigo_presupuestario <?php echo $productos["codigos_presupuestarios"];?>" data-toggle="modal" data-target="#detalleSaldoCodigo"><?php echo $productos["codigos_presupuestarios"];?></a></td>
					<td class="<?php echo ($productos["afecto"] == 1) ? "sub_total_formato" : "exento" ;?>">
						<input type="hidden" name="subToal[]" value="<?php echo str_replace(".","",$productos["subtotal"]) ; ?>">

						<?php 
							//echo number_format($productos["subtotal"], 0, '', '.');

							if(isset( $productos["subtotal"]) && !empty( $productos["subtotal"]))
							{


								$enteroDecimal = explode(',', $productos["subtotal"]);

								if(count($enteroDecimal) > 1)
								{
									echo number_format($enteroDecimal[0], 0, '', '.') . ','.$enteroDecimal[1];
								}
								else
								{
									echo number_format($enteroDecimal[0], 0, '', '.');
								}
								
							}
						?>
					</td>

					<td class="total_producto ocultar"><input type="hidden" name="total_producto[]" value="<?php echo $productos["cantidad"] * str_replace(".","", $productos["precio_unitario"]) - str_replace(".","",$productos["descuento_producto"]); ?>"><?php echo $productos["cantidad"] * str_replace(".","", $productos["precio_unitario"]) - str_replace(".","",$productos["descuento_producto"]); ?></td>
					<td>
						<button id="<?php echo $productos["id"];?>" type="button" class="btn btn-success btn-xs editar" data-toggle="modal" data-target="#ingresoProducto"><i class="fa fa-pencil"></i></button>
						<button id="<?php echo $productos["id"];?>" type="button" class="btn btn-danger btn-xs clsEliminarFila"><i class="fa fa-trash-o"></i></button>
					</td>
				<tr>
			<?php } endforeach; ?>


	    
	    </tbody>
	</table>

	<fieldset><legend>Totales y descuentos</legend>
	<div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput">Descuento % : </label>
		<div class="col-md-6">
			<?php echo $this->Form->input('descuento', array("class"=>"col-xs-4 form-control", "label"=>false, 'placeholder'=>'descuento %', 'readonly'=>true));?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput">Descuento $ : </label>
		<div class="col-md-6">
			<?php echo $this->Form->input('monto', array("class"=>"col-xs-4 form-control", "label"=>false, 'placeholder'=>'descuento %', 'default'=>number_format($comprasProductosTotale['ComprasProductosTotale']['descuento_total'], 0, '', '.'), 'readonly'=>true));?>
		</div>
	</div>

	<!--div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Tipo de impuesto : </label>
		<div class="col-md-6">
			<label class="radio-inline baja"><input type="radio" name="tipoImpuesto" id="tipoImpuesto1" value="1">Afecto </label>
			<label class="radio-inline baja"><input type="radio" name="tipoImpuesto" id="tipoImpuesto2" value="2">Exento  </label>
			<label class="radio-inline baja"><input type="radio" name="tipoImpuesto" id="tipoImpuesto3" value="3">Honorarios  </label>
		</div>
	</div-->


	<div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Archivo adjunto : </label>
		<div class="col-md-6">
			<?php echo $this->Form->input('adjunto.', array("type"=>"file", 'multiple', "class"=>"requerido", "label"=>false, 'placeholder'=>'Adjuntar archivo'));?>
			<small class="label label-info">Utilice la tecla Ctrl para adjuntar mas de un archivo</small>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput">Observación : </label>
		<div class="col-md-6">
			<?php echo $this->Form->textArea('observacion', array("class"=>"form-control", "label"=>false, 'placeholder'=>'Observacion', 'default'=>$comprasProductosTotale['ComprasProductosTotale']['observacion']));?>
		</div>
	</div>
	
	<?php echo $this->Form->hidden('total', array('default'=>$comprasProductosTotale['ComprasProductosTotale']['total']));?>
	<?php echo $this->Form->hidden('id_clonado', array('default'=>$id));?>
	<?php echo $this->Form->hidden('clonar', array('default'=>1));?>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<div class="alert alert-info">
				<h4> Neto Afecto s/d: $ <span class="neto_sd"> <?php echo number_format(array_sum($netoSinDescuento) - array_sum($descuentosProductos), 0, '', '.'); ?></span></h4>

				<?php echo $this->Form->hidden('neto_descuento', array('default'=>str_replace(".","",$comprasProductosTotale['ComprasProductosTotale']['neto_descuento'])));?>
				<h4> Neto Exento s/d: $ </span> <span class="totalExento hidden"> </span></h4>
				<h4> Descuentos: $ <span class="totalDescuentos"> <?php echo number_format($comprasProductosTotale['ComprasProductosTotale']['descuento_total'], 0, '', '.')?></span></h4>
				<h4> Neto Total c/d: $ <span class="netoCd"><?php echo number_format($comprasProductosTotale["ComprasProductosTotale"]["neto_descuento"], 0, '', '.'); ?> </span></h4>
				<h4> <span class="textoIva">Impuesto : $</span> <span class="iva"><?php echo number_format($comprasProductosTotale["ComprasProductosTotale"]["total"] - $comprasProductosTotale["ComprasProductosTotale"]["neto_descuento"], 0, '', '.'); ?> </span></h4>
				
				<h4> Total: $ <span class="total"> <?php echo number_format($comprasProductosTotale['ComprasProductosTotale']['total'], 0, '', '.'); ?> </span></h4>
				<!--h4> Neto s/d : $ <span class="neto_sd"><?php echo array_sum($netoSinDescuento); ?></span></h4>
				<?php echo $this->Form->hidden('neto_descuento', array('default'=>str_replace(".","",$comprasProductosTotale['ComprasProductosTotale']['neto_descuento'])));?>
				<h4> Descuentos : $ <span class="totalDescuentos"> </span></h4>
				<h4> Neto c/d : $ <span class="netoCd"><?php echo $comprasProductosTotale["ComprasProductosTotale"]["neto_descuento"]; ?> </span></h4>
				<h4> Impuesto : $ <span class="iva"> <?php echo number_format($comprasProductosTotale['ComprasProductosTotale']['total'] - str_replace(".","",$comprasProductosTotale["ComprasProductosTotale"]["neto_descuento"]), 0, '', '.'); ?></span></h4>
				<h4> Total : $ <span class="total"> <?php echo number_format($comprasProductosTotale['ComprasProductosTotale']['total'], 0, '', '.'); ?> </span></h4-->
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn-block btn btn-primary btn-lg generarOrden"><i class="fa fa-file-text-o"></i> Registrar nota de credito</button>
		</div>
	</div>
</form>
<!-- Modal -->
<div class="modal fade" id="ingresoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
  	<form id="formProducto" role="form"  method="Post" action="<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"compraUnitario")); ?>">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Ingresar detalle del Producto</h4>
	      </div>


			<div class="modal-body" style="height:400px; overflow-y: scroll !important;">
				
				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Tipo de impuesto : </label>
					<div class="col-md-6">
						<label class="radio-inline baja"><input type="radio" name="afecto" id="afecto1" value="1" checked class="requerido">Afecto (19%)</label>
						<label class="radio-inline baja"><input type="radio" name="afecto" id="afecto2" value="2" class="requerido">Exento (0%)</label>
					</div>
				</div>


				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Cantidad: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('cantidad', array("class"=>"form-control requerido", "label"=>false, 'placeholder'=>'Cantidad'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Producto: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('descripcion', array("class"=>"form-control requerido", "label"=>false, 'placeholder'=>' Producto'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Precio unitario: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('precio', array("class"=>"form-control requerido", "label"=>false, 'placeholder'=>'Precio Unitario'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput">Descuento %: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('descuento_producto', array("class"=>"form-control", "label"=>false, 'placeholder'=>'Descuento al Producto'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput">Descuento $: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('descuento_producto_peso', array("class"=>"form-control", "label"=>false, 'placeholder'=>'Descuento al Producto'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput">Empaque: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('empaque', array("class"=>"empaque", "label"=>false, 'options'=>$empaques, 'placeholder'=>'Tipo de Empaque'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Gerencias: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('dimUno', array("class"=>"dimencionUno requerido", "label"=>false, 'options'=>$dimensionUno, 'placeholder'=>'Gerencias'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput">Estadios: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('dimDos', array("class"=>"dimencionDos", 'options'=>$dimensionDos, "label"=>false, 'placeholder'=>'Estadios'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput">Contenido: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('dimTres', array("class"=>"dimencionTres", 'options'=>$dimensionTres, "label"=>false, 'placeholder'=>'Contenido'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput">Canal de distribución: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('dimCuatro', array("class"=>"dimencionCuatro", 'options'=>$dimensionCuatro, "label"=>false, 'placeholder'=>'Canal de distribución'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput">otros: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('dimCinco', array("class"=>"dimencionCinco", 'options'=>$dimensionCinco, "label"=>false, 'placeholder'=>'otros'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput">Proyectos: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('proyecto', array("class"=>"proyectos", 'options'=>$proyectos, "label"=>false, 'placeholder'=>'Proyectos'));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Códigos predupuestarios: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('codigoPresupuestario', array("type"=>"select", "options" =>array(""=>""), "class"=>"codigoPresupuestario requerido requerido", "label"=>false, 'placeholder'=>'Codigo Presupuestario'));?>
					</div>
				</div>
			</div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        <button type="submit" class="btn btn-primary agregarProducto" >Agregar</button>
		      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="detalleSaldoCodigo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 450px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle Codigo Presupuestario</h4>
      </div>
      <div class="modal-body detalleCodigo"></div>
    </div>
  </div>
</div>

<?php

	echo $this->Html->script(array(
		'bootstrap-datepicker'
	));
?>

<script>
	var existNotasCredito = "<?php echo $exisNotaCredito; ?>"
	$('#fecha_documento').datepicker({
	    format: "yyyy-mm-dd",
	    //startView: 1,
	    language: "es",
	    multidate: false,
	   // daysOfWeekDisabled: "0, 6",
	    autoclose: true,
	   viewMode: "week",
	   Default: false
	});

	if(existNotasCredito != "")
	{
		alert("!!Ya existen notas de credito asociadas a la factura seleccionada. \n\n N° DE DOCUMENTO: \n " + existNotasCredito);
	}
	
	var tipoImpuestoVal = $("#impuesto").val();
	var tipoDocumentoVal = $("#tipo_documento").val();
	var editar = "";
	var posicion = 0;
	var idElimina  = "";

	$(document).ready(function() {
		//$("#tipo_documento26").prop("checked", true);
	    $('#username').editable();

	    $(".ingresar_producto").click(function(){
	    	
			idElimina = undefined;
			editar = undefined;
			
			$("#cantidad").val("");
			$("#descripcion").val("");
			$("#precio").val("");
			$("#descuento_producto").val("");
			$("#descuento_producto_peso").val("");
			$('html, #cantidad').animate({scrollTop : 0},800);
		});
	});
	
	var validaFormulario = 0; 
	$('#fileinfo').validate({
	    submitHandler: function(form){
	    	validaFormulario = 1;
	    	return false;
	    }
	 });
	
	
	$('.ocultar').hide();
	
	$('#formProducto').validate({
	    submitHandler: function (form) {
	    	return false;
	    }
	 });


	$('.requerido').each(function() {
	    $(this).rules('add', {
	        required: true,
	        maxlength: 500,
	        messages: {
	            required: "campo requerido",
	        }
	    });
	});


	var datosPopover = "";
	$("#fileinfo").submit(function(e){

		if(validaFormulario == 0)
		{
			return false;
		}

		$(".fa-file-text-o").addClass("fa-spinner fa-spin").removeClass("fa-file-text-o");
		//$(".generarOrden").text("Generando Orden de Compra, Espere un momento");
		var fd = new FormData(document.getElementById("fileinfo"));
		$.ajax({
			url: "<?php echo $this->Html->url(array('controller'=>'Servicios', 'action'=>'notas_credito')); ?>",
			type: "POST",
			data: fd,
			enctype: 'multipart/form-data',
			processData: false,
			contentType: false
		}).done(function( data ){
			if(data != "")
			{
				setTimeout("window.location.href='<?php echo $this->Html->url(array('controller'=>'compras', 'action'=>'index'));?>';",1000);
				//$("#tipo_documento").trigger('click');
			}
			else
			{
				setTimeout("window.location.href='<?php echo $this->Html->url(array('controller'=>'compras', 'action'=>'index'));?>';",1000);
				//$("#tipo_documento").trigger('click');
			}
		});
		e.preventDefault();
	});

	$(document).ready(function(){
		$("#company_id option[value='<?php echo $comprasProductosTotale['ComprasProductosTotale']['company_id']; ?>']").attr("selected","selected");
		$("#company_id").prop("readonly", true);
		$("#tipo_moneda_id").prop("readonly", true);
		$("#plazos_pago_id").prop("readonly", true);

		$("#tipo_moneda_id option[value='<?php echo $comprasProductosTotale['ComprasProductosTotale']['tipos_moneda_id']; ?>']").attr("selected","selected");
		$("#plazos_pago_id option[value='<?php echo $comprasProductosTotale['ComprasProductosTotale']['plazos_pago_id']; ?>']").attr("selected","selected");
		$("input[name=tipoImpuesto][value=<?php echo $comprasProductosTotale['ComprasProductosTotale']['impuesto']; ?>]").attr('checked', true);


	    $(document).on('click','caption',function(){
            if(objTabla.find('tbody').is(':visible')){
                $(this).removeClass('clsContraer');
                $(this).addClass('clsExpandir');
            }else{
                $(this).removeClass('clsExpandir');
                $(this).addClass('clsContraer');
            }
	            objTabla.find('tbody').toggle();
	    });

    	$(document).on('click','.clsEliminarFila',function(event){
    		idElimina = undefined;
			editar = undefined;

    		var idProducto = $(this).attr("id");     //$(this).find('td').eq(0).text();
    		var idProducto = $(this).attr("id");     //$(this).find('td').eq(0).text();

    		/*
    		if(idProducto != "")
    		{

    			$.ajax({
			    type: "GET",
			    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"eliminar_producto"))?>",
			    data: {"idProducto" : idProducto},
			    async: true,
			    dataType: "json",
				    success: function( data ) {

				    }
				});
    		}
    		*/
            if($(objCuerpo).find('tr').length == 0)
			{
				//$(".generarOrden").addClass("disabled");
            	$(".total").html("0");
            	$(".netoCd").html("0");
            	$("#neto_descuento").val();
            	$("#total").val();
            	$(".totalDescuentos").html("0");
            	$(".neto_sd").html("0");
            	$(".iva").html("0");
			}

        	var objCuerpo = $(this).parents().get(2);
            if($(objCuerpo).find('tr').length == 1)
            {
            	//$(".generarOrden").addClass("disabled");
            	$(".total").html("0");
            	$(".netoCd").html("0");
            	$("#neto_descuento").val();
            	$("#total").val();
            	$(".totalDescuentos").html("0");
            	$(".neto_sd").html("0");
            	$(".iva").html("0");
            }


        	var objFila = $(this).parents().get(1);

            $(objFila).remove();

            var sumaSubTotal = 0;
		    $('.dato').each(function(){
		     	sumaSubTotal += parseInt( $(this).find('td').eq(12).text().replace(/\./g,'') || 0,10 )
		    })

			if(sumaSubTotal != "")
			{
				var tipoCambio = $("#tipo_cambio").val();
				if(tipoCambio != "")
				{
					
					//xxx

					var sumaSubTotalPeso = eval(tipoCambio) * eval(sumaSubTotal);
					$(".neto_sd").text(accounting.formatMoney(sumaSubTotalPeso, "", 0, ".", ".")  );
					$(".netoCd").text(accounting.formatMoney(sumaSubTotalPeso, "", 0, ".", ".")  );
					$("#neto_descuento").val(sumaSubTotalPeso);
					var iva = eval(sumaSubTotalPeso) * 0.19;
					$(".iva").text(accounting.formatMoney(iva, "", 0, ".", "."));
					$(".total").text(accounting.formatMoney(eval(iva) + eval(sumaSubTotalPeso), "", 0, ".", "."))
					$("#total").val(Math.round(eval(iva) + eval(sumaSubTotalPeso)));


				}
				else
				{
					var sumaSubTotalFormateado = accounting.formatMoney(sumaSubTotal, "", 0, ".", ".");
					$(".neto_sd").text(sumaSubTotalPeso)
					$(".netoCd").text(sumaSubTotalFormateado);
					$("#neto_descuento").val(sumaSubTotalFormateado.replace(/\./g,''));

					var iva = eval(sumaSubTotal) * 0.19;
					$(".iva").text(accounting.formatMoney(iva, "", 0, ".", "."));
					$(".total").text(accounting.formatMoney(eval(iva) + eval(sumaSubTotal), "", 0, ".", "."))

					$("#total").val(Math.round(eval(sumaSubTotal) + eval(iva)));
				}
			}

 			var sumaTotalProducto = 0;
		    $('.dato').each(function(){
		     	sumaTotalProducto += parseInt( $(this).find('td').eq(13).text().replace(/\./g,'') || 0,10 )
		    })

		  	if(sumaTotalProducto != "" && tipoCambio == "")
			{
				$(".neto_sd").text(accounting.formatMoney(sumaTotalProducto, "", 0, ".", "."));
			}
			else
			{
				$(".neto_sd").text(accounting.formatMoney(sumaSubTotalPeso, "", 0, ".", "."));
			}
			
			$("#tipo_documento").trigger('click');

 		})


    	$(document).on('click','.codigo_presupuestario',function(){

			var codigoPresupuestario = $(this).text();

	    	$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"saldo_codigo_presupuestario"))?>",
		    data: {"codigoPresupuestario" : codigoPresupuestario},
		    async: true,
		    dataType: "json",
			    success: function( data ) {
			    	$(".nombreCodigoPresupuestario").text(codigoPresupuestario);
					detalleHtml = '<ul class="list-group">'; 
			    	detalleHtml += "<li class='list-group-item'>Presupuesto: $ " + accounting.formatMoney(data.sumaPresupuestoArea, "", 0, ".", ".") + "</li>";
			    	detalleHtml += "<li class='list-group-item'>Gastos Aprobados: $ " + accounting.formatMoney(data.gastosArea, "", 0, ".", ".") + "</li>";
			    	detalleHtml += "<li class='list-group-item'>Saldo: $ " + accounting.formatMoney(data.saldoGastos, "", 0, ".", ".") + "</li>";
			    	detalleHtml += "</ul>";
			    	$(".detalleCodigo").html(detalleHtml);
			    	//$('.'+codigoPresupuestario).attr("data-content",'Pres cod.:'+ data.presupuestoItem+' / Pres. área:<br/>'+data.sumaPresupuestoArea);
			    	
			    }
			});
		});



		$("#formProducto").submit(function (e) {
			e.preventDefault();

			if( $("#cantidad").val() != "" && $("#descripcion").val() != "" && $("#codigoPresupuestario").val() != "" && $("#precio").val() != "" && $("#dimUno").val() != "" )
			{
				var destino = $(this).prop("action");
				var datos = $(this).serialize();
				
				$.post(destino, datos, function (data) {
					var obj = jQuery.parseJSON( data );
					if(obj.cantidad != "")
					{
						var dimUnoCodigo = "";
						var dimDosCodigo = "";
						var dimCuatroCodigo = "";
						var dimCincoCodigo = "";
						var dimProyecto
						
						var tdHtml = "";
						var afecto = "";
						var sub_total_formato = "";
						if(obj.afecto == 1)
						{
							sub_total_formato = "sub_total_formato"
							afecto = "Afecto"
							
						}
						else
						{
							sub_total_formato = "exento"
							afecto = "Exento"	
						}
						tdHtml = "<td class='eliminar'> <input type='hidden' name='cantidad[]' value='"+obj.cantidad.replace(/\./g,'')+"'>"+obj.cantidad+"</td>";
						tdHtml += "<td> <input type='hidden' name='afecto[]' value='"+obj.afecto+"'>"+afecto+"</td>";
						tdHtml += "<td> <input type='hidden' name='descripcion[]' value='"+obj.descripcion+"'>"+obj.descripcion+"</td>";
						tdHtml += "<td class='precio_unitario'> <input type='hidden' name='precio[]' value='"+obj.precio+"'>"+obj.precio+"</td>";
						tdHtml += "<td class='descuento_tabla'> <input type='hidden' name='descuento_unitario[]' value='"+obj.descuento_producto_peso+"'>"+obj.descuento_producto_peso+"</td>";
						tdHtml += "<td> <input type='hidden' name='empaque[]' value='"+obj.empaque+"'>"+   obj.empaque+"</td>";
						
						if(obj.dimUno != "")
						{
							dimUnoCodigo = obj.dimUno.split(" - "); 
							tdHtml += "<td title='"+dimUnoCodigo[0]+"' id='codigoUno-"+dimUnoCodigo[0]+"' ><input type='hidden' name='dimCodigoUno[]' value='"+obj.dimUno+"'> "+dimUnoCodigo[1]+"</td>";
							
						}
						else
						{
							tdHtml += "<td><input type='hidden' name='dimCodigoUno[]' value=''></td>";
						}
						
						if(obj.dimDos != "")
						{
							dimDosCodigo = obj.dimDos.split(" - ");
							tdHtml += "<td title='"+dimDosCodigo[0]+"' id='codigoDos-"+dimDosCodigo[0]+"' > <input type='hidden' name='dimCodigoDos[]' value='"+obj.dimDos+"'>"+dimDosCodigo[1]+"</td>";
						}
						else
						{
							tdHtml += "<td><input type='hidden' name='dimCodigoDos[]' value=''></td>";
						}
						
						if(obj.dimTres != "")
						{
							var dimTresCodigo = obj.dimTres.split(" - "); 
							tdHtml += "<td title='"+dimTresCodigo[0]+"' id='codigoTres-"+dimTresCodigo[0]+"' ><input type='hidden' name='dimCodigoTres[]' value='"+obj.dimTres+"'>"+dimTresCodigo[1]+"</td>";
						}
						else
						{
							tdHtml += "<td><input type='hidden' name='dimCodigoTres[]' value=''></td>";
						}
						
						if(obj.dimCuatro != "")
						{
							var dimCuatroCodigo = obj.dimCuatro.split(" - ");
							tdHtml += "<td title='"+dimCuatroCodigo[0]+"' id='codigoCuatro-"+dimCuatroCodigo[0]+"' > <input type='hidden' name='dimCodigoCuatro[]' value='"+obj.dimCuatro+"'>"+dimCuatroCodigo[1]+"</td>";
						}
						else
						{
							tdHtml += "<td><input type='hidden' name='dimCodigoCuatro[]' value=''></td>";
						}
						
						if(obj.dimCinco != "")
						{
							var dimCincoCodigo = obj.dimCinco.split(" - ");
							tdHtml += "<td title='"+dimCincoCodigo[0]+"' id='codigoCinco-"+dimCincoCodigo[0]+"' > <input type='hidden' name='dimCodigoCinco[]' value='"+obj.dimCinco+"'>"+dimCincoCodigo[1]+"</td>";
						}
						else
						{
							tdHtml += "<td><input type='hidden' name='dimCodigoCinco[]' value=''></td>";
						}

						if(obj.proyecto != "")
						{
							var dimProyecto = obj.proyecto.split(" - ");
							tdHtml += "<td title='"+dimProyecto[0]+"' id='proyecto-"+dimProyecto[0]+"' > <input type='hidden' name='proyecto[]' value='"+dimProyecto[1]+"'>"+dimProyecto[1]+"</td>";
						}
						else
						{
							tdHtml += "<td><input type='hidden' name='proyecto[]' value=''></td>";
						}
					   

						//tdHtml += "<td> <input type='hidden' name='proyecto[]' value='"+obj.proyecto+"'>"+obj.proyecto+"</td>";
						tdHtml += "<td> <input type='hidden' name='codigoPresupuestario[]' value='"+obj.codigoPresupuestario+"'><a style='cursor:pointer' class='codigo_presupuestario "+obj.codigoPresupuestario+"' data-toggle='modal' data-target='#detalleSaldoCodigo'>"+obj.codigoPresupuestario+"</a></td>";

						var subTotal = 0;
						var subTotalFormato	 = "";
						if(obj.cantidad != "" && obj.precio != "")
						{
							if(tipoCambio != 1)
							{
								subTotal = parseFloat(obj.cantidad.replace(/\./g,'').replace(/\,/g,'.')) * parseFloat(obj.precio.replace(/\./g,'').replace(/\,/g,'.'));
							}
							else
							{
								subTotal = obj.cantidad.replace(/\./g,'') * obj.precio.replace(/\./g,'');
							}

							//subTotal = obj.cantidad * obj.precio.replace(/\./g,'');

							var neto_sd = "";

							if(subTotal != "")
							{
								var netoSd = $(".neto_sd").text().replace(/\./g,'').replace(/\$/g,'').trim();

								if(netoSd == "")
								{

									var tipoCambio = $("#tipo_cambio").val();

									if(tipoCambio == "" || tipoCambio == 1)
									{
										$(".neto_sd").text(' $ '+ accounting.formatMoney(subTotal, "", 0, ".", "."));
										//$(".neto_sd").text(' $ '+ accounting.formatMoney(eval(subTotal) * eval(tipoCambio), "", 0, ".", "."));
										console.log(1);

									}
									else
									{
										$(".neto_sd").text(' $ '+ accounting.formatMoney(eval(subTotal) * eval(tipoCambio), "", 0, ".", "."));
									}
								}
								else
								{
									var tipoCambio = $("#tipo_cambio").val();
									var netoSdPeso = eval(subTotal) * eval(tipoCambio);

									if(tipoCambio != "" || tipoCambio != 1)
									{

										$(".neto_sd").text(accounting.formatMoney(eval(netoSd) + eval(netoSdPeso), "", 0, ".", "."));
									}
									else
									{
										$(".neto_sd").text(accounting.formatMoney(eval(subTotal) + eval(netoSd), "", 0, ".", "."));
									}
								}
							}
							var descuentoEnPesos = $("#descuento_producto_peso").val().replace(/\./g,'').replace(/\,/g,'.');
							
							if(obj.descuento_producto != "" && subTotal != "")
							{
								if($("#descuento_producto_peso").val())
								{
									descuentoEnPesos = descuentoEnPesos;
								}
							}

							if(descuentoEnPesos != "")
							{

								if(tipoCambio == "" || tipoCambio == 1)
								{
									subTotalFormato = accounting.formatMoney(subTotal - descuentoEnPesos, "", 0, ".", ".");
								}
								else
								{

									subTotalFormato = accounting.formatMoney(parseFloat(subTotal) - parseFloat(descuentoEnPesos), "",2, ".", ",");
								}
							}
							else
							{

								if(tipoCambio == "" || tipoCambio == 1)
								{
									subTotalFormato = accounting.formatMoney(subTotal, "", 0, ".", ".");
								}
								else
								{
									subTotalFormato = accounting.formatMoney(subTotal, "", 2, ".", ",");
								}

								
							}
						}

						tdHtml += "<td class='"+sub_total_formato+"'><input type='hidden' name='subToal[]' value='"+ subTotalFormato.replace(/\./g,'')+"'>"+subTotalFormato+"</td>";



						tdHtml += "<td class='total_producto ocultar'><input type='hidden' name='total_producto[]' value='"+ subTotalFormato+"'>"+subTotalFormato+"</td>";

						tdHtml += '<td><button type="button" class="btn btn-danger btn-xs clsEliminarFila"><i class="fa fa-trash-o"></i></button></td>';
						$(".productos").append('<tr class="dato">'+tdHtml+'</tr>');

						
							$('#ingresoProducto').modal('hide');
							$(".generarOrden").removeClass("disabled");
							//alert("ingrese todos los campos Obligatorios")
						//}
						$('.ocultar').hide();

						var sumaSubTotal = 0;


						if(tipoCambio == "" || tipoCambio == 1)
						{
							$('.sub_total_formato').each(function(i, valor) {
					     		sumaSubTotal += parseInt( $(this).text().replace(/\./g,''))
					    	})
						}
						else
						{
							$('.sub_total_formato').each(function(i, valor) {
		     					sumaSubTotal += parseFloat( $(this).text().replace(/\./g,'').replace(/\,/g,'.'))
		    				})
						}

					    	

						if(sumaSubTotal != "")
						{
							var tipoCambio = $("#tipo_cambio").val();
							if(tipoCambio == "" || tipoCambio == 1)
							{

								var sumaSubTotalFormateado = accounting.formatMoney(sumaSubTotal, "", 0, ".", ".");
								$(".netoCd").text(sumaSubTotalFormateado);
								$(".neto_sd").text(sumaSubTotalFormateado);
								$("#neto_descuento").val(Math.round(sumaSubTotal));
								
								var iva = eval(sumaSubTotal) * 0.19;

								$(".iva").text(accounting.formatMoney(iva, "", 0, ".", "."));

								$(".total").text(accounting.formatMoney(eval(iva) + eval(sumaSubTotal), "", 0, ".", "."))
								$("#total").val(Math.round(eval(iva) + eval(sumaSubTotal)));

								$(".totalDescuentos").text("0");
							}
							else
							{

								var sumaSubTotalPeso = parseFloat(tipoCambio) * parseFloat(sumaSubTotal);

								$(".netoCd").text(accounting.formatMoney(Math.round(sumaSubTotalPeso), "", 0, ".", "."));
								$("#neto_descuento").val(Math.round(sumaSubTotalPeso));
								$(".neto_sd").text(accounting.formatMoney(Math.round(sumaSubTotalPeso), "", 0, ".", "."));
								$(".totalDescuentos").text("0");



								var iva = eval(Math.round(sumaSubTotalPeso)) * 0.19;
								$(".iva").text(accounting.formatMoney(iva, "", 0, ".", "."));
								$(".total").text(accounting.formatMoney(eval(iva) + eval(Math.round(sumaSubTotalPeso)), "", 0, ".", "."))
								$("#total").val(Math.round(eval(iva) + Math.round(sumaSubTotalPeso)));
								
							}
						}

					$("#cantidad").val("");
					$("#descripcion").val("");
					$("#precio").val("");
					$("#descuento_producto").val("");
					$("#descuento_producto_peso").val("");
					}

					var tipoImpuesto = $("input[name='data[tipo_documento]']:checked").attr("id")
					$("#"+tipoImpuesto).trigger('click');
					
				});

			}
			else
			{

				alert("Ingrese todos los campos obligatorios");
				return false;
			}
			tipoImpuesto = $("input[type='radio']:checked").val();
			if(tipoImpuesto != 1 && tipoImpuesto != 2)
			{
				nonbretipoImpuesto = "#tipo_documento"+tipoImpuesto;
				$(nonbretipoImpuesto).prop("checked", true).trigger("click");
			}
		});

		var montoPeso = "";
		var montoPorcentaje = "";

		$("#descuento").on("change", function(){

			if($(this).val() > 100)
			{
				$(this).val("");
				alert("El descuento ingresado no puede superar el 100 %");

				return false;
			}

			var sumaSubTotal = 0;

			tipoMoneda = $("#tipo_moneda_id").val();

			if(tipoMoneda == 1 || tipoMoneda == "" )
			{
		    	$('.sub_total_formato').each(function(i, valor) {
		     		sumaSubTotal += parseInt( $(this).text().replace(/\./g,''))
		    	})
	    	}
	    	else
	    	{
	    		$('.sub_total_formato').each(function(i, valor) {
		     		sumaSubTotal += parseFloat( $(this).text().replace(/\./g,'').replace(/\,/g,'.'))
		    	})
	    	}

			if(sumaSubTotal != "")
			{
				var sumaSubTotalFormateado = accounting.formatMoney(sumaSubTotal, "", 0, ".", ".");
				$(".total").text(sumaSubTotalFormateado);
			}

			var descuentoPocentaje = $("#descuento").val();
			var descuentoMonto = $("#monto").val();
			
			var total = $("#total").val(); 

			if(descuentoPocentaje != "" && total != "")
			{

				var valorPorcentaje = parseFloat(descuentoPocentaje) * parseFloat(sumaSubTotal); //parseInt($(".netoCd").text().replace(/\./g,'').replace(/\$/g,'').trim());

				var tipoCambio = $("#tipo_cambio").val();

				if(tipoCambio != "")
				{
					montoPeso = parseInt(valorPorcentaje) / 100  * eval(tipoCambio);
				}
				else
				{
					montoPeso = parseInt(valorPorcentaje) / 100 ;
				}

				if(montoPeso != "")
				{

					var valorFormateado = accounting.formatMoney(montoPeso, "", 0, ".", ".");
					$("#monto").val(valorFormateado).css("color", "red");

					var netoCd = $(".netoCd").text().replace(/\./g,'').replace(/\$/g,'').trim();


					$(".netoCd").text(accounting.formatMoney(eval(netoCd) - eval(montoPeso), "", 0, ".", "."));
					var netoSinDescuento = $(".neto_sd").text().replace(/\./g,'').replace(/\$/g,'').trim();

					netoCd = eval(netoSinDescuento) - eval(montoPeso);

					var iva = "";
					if(netoCd != "")
					{
						iva = eval(netoCd) * 0.19;
						$(".iva").text(accounting.formatMoney(Math.round(iva), "", 0, ".", "."));
						$(".total").text(accounting.formatMoney(eval(netoCd) + eval(iva), "", 0, ".", "."));
						$("#total").val(Math.round(eval(netoCd) + eval(iva))); 
						$("#neto_descuento").val(Math.round(netoCd));
						$(".totalDescuentos").text(accounting.formatMoney(montoPeso, "", 0, ".", "."));
						$(".netoCd").text(accounting.formatMoney(Math.round(netoCd) , "", 0, ".", "."));

					}
				}

				if(montoPeso == "" || montoPeso == 0)
				{
					var netoCd = 0;
					
					$('.sub_total_formato').each(function(i, valor) {
			     		netoCd += parseInt( $(this).text().replace(/\./g,''))
			    	})

			    	if(netoCd != "")
			    	{
			    		if(tipoCambio != "")
			    		{

			    			$(".neto_sd").text(accounting.formatMoney (Math.round(eval(netoCd) * eval(tipoCambio)), "", 0, ".", "."));
			    			$("#neto_descuento").val(Math.round(eval(netoCd) * eval(tipoCambio)));
			    			$("#monto").val("");
			    			$(".totalDescuentos").text("0")
			    			$(".netoCd").text(accounting.formatMoney (Math.round(eval(netoCd) * eval(tipoCambio)), "", 0, ".", "."));
			    			var iva = eval(netoCd * tipoCambio) * 0.19
							$(".iva").text(accounting.formatMoney(Math.round(iva), "", 0, ".", "."));
							$(".total").text(accounting.formatMoney (Math.round(eval(netoCd) * eval(tipoCambio) + eval(iva)), "", 0, ".", "."));

							$("#total").val(Math.round(eval(netoCd) * eval(tipoCambio) + eval(iva)));
			    		}
			    		else
			    		{
			    			$(".neto_sd").text(accounting.formatMoney (Math.round(eval(netoCd)), "", 0, ".", "."));
			    			$("#neto_descuento").val(Math.round(eval(netoCd)));
			    			$("#monto").val("");
			    			$(".totalDescuentos").text("0")
			    			$(".netoCd").text(accounting.formatMoney (Math.round(eval(netoCd)), "", 0, ".", "."));
			    			var iva = eval(netoCd) * 0.19
							$(".iva").text(accounting.formatMoney(Math.round(iva), "", 0, ".", "."));
							$(".total").text(accounting.formatMoney (Math.round(eval(netoCd) + eval(iva)), "", 0, ".", "."));

							$("#total").val(Math.round(eval(netoCd) + eval(iva)));
			    			
			    		}
			    		valorDescuentoPeso = $("#monto").val();
						if(valorDescuentoPeso != "")
						{
							$("#monto").trigger('change');
						}
						
			    	}
					return false;
				}
			};
			tipoImpuesto = $("input[type='radio']:checked").val();

			if(tipoImpuesto != 1 && tipoImpuesto != 2)
			{
				nonbretipoImpuesto = "#tipo_documento"+tipoImpuesto;
				$(nonbretipoImpuesto).prop("checked", true).trigger("click");
			}		
		});




		var valorDescuento = $("#descuento").val();

		$("#monto").change(function(){

			var descuentoPeso = $(this).val().replace(/\./g,'');

			var tipoCambio = $("#tipo_cambio").val();
 			var sumaSubTotal = 0;
	    	$('.dato').each(function(){
	     		sumaSubTotal += parseInt( $(this).find('td').eq(12).text().replace(/\./g,'') || 0,10 )
	    	})

			if(sumaSubTotal != "")
			{
				var sumaSubTotalFormateado = accounting.formatMoney(sumaSubTotal, "", 0, ".", ".");
				$(".total").text(sumaSubTotalFormateado);
				$("#total").val(Math.round(sumaSubTotal));
			}

			var descuentoPocentaje = "";

			if(sumaSubTotal != "" && descuentoPeso != "")
			{

				descuentoPocentaje = parseFloat(descuentoPeso) * 100 / parseFloat(sumaSubTotal);

				if(tipoCambio != "")
				{
					var pesosATipoCambios = $(this).val().replace(/\./g,'') / tipoCambio
					descuentoPocentaje = parseFloat(pesosATipoCambios) * 100 / parseFloat(sumaSubTotal);
				}

				if(descuentoPocentaje > 100)
				{
					$("#descuento").val("");
					$("#monto").val();
					alert("El descuento ingresado no puede superar el 100 %");
					return false;
				}

			}

			var total = $("#total").val();


			if(descuentoPocentaje != "")
			{

				montoPeso = descuentoPeso;
				if(montoPeso != "")
				{
					$("#descuento").val(descuentoPocentaje.toFixed(2)).css("color", "red");
					$(".totalDescuentos").text(montoPeso);
					if(netoCd != "")
					{

						if(tipoCambio != "")
						{
							var subTotalTipoCambio = eval(sumaSubTotal) * eval(tipoCambio);

							$(".neto_sd").text(accounting.formatMoney (Math.round(eval(subTotalTipoCambio)), "", 0, ".", "."));
							$(".totalDescuentos").text(accounting.formatMoney($(this).val().replace(/\./g,''), "", 0, ".", ".") );
							$(".netoCd").text(accounting.formatMoney(Math.round(eval(subTotalTipoCambio) - eval($(this).val().replace(/\./g,''))), "", 0, ".", ".") );
							resta = eval(subTotalTipoCambio) - eval( $(this).val().replace(/\./g,''));
							var iva = eval(resta) * 0.19
							$(".iva").text(accounting.formatMoney(Math.round(eval(iva)), "", 0, ".", ".") );
							$(".total").text(accounting.formatMoney(Math.round(eval(resta) + eval(iva)), "", 0, ".", ".") );

							$("#total").val(Math.round(eval(resta) + eval(iva) ));
							$("#neto_descuento").val(Math.round(resta));
						}
						else
						{

							//alert(sumaSubTotal);

							var subTotalTipoCambio = eval(sumaSubTotal);

							$(".neto_sd").text(accounting.formatMoney (Math.round(eval(subTotalTipoCambio)), "", 0, ".", "."));
							$(".totalDescuentos").text(accounting.formatMoney($(this).val().replace(/\./g,''), "", 0, ".", ".") );
							$(".netoCd").text(accounting.formatMoney(Math.round(eval(subTotalTipoCambio) - eval($(this).val().replace(/\./g,''))), "", 0, ".", ".") );
							resta = eval(subTotalTipoCambio) - eval( $(this).val().replace(/\./g,''));
							var iva = eval(resta) * 0.19
							$(".iva").text(accounting.formatMoney(Math.round(eval(iva)), "", 0, ".", ".") );
							$(".total").text(accounting.formatMoney(Math.round(eval(resta) + eval(iva)), "", 0, ".", ".") );

							$("#total").val(Math.round(eval(resta) + eval(iva) ));
							$("#neto_descuento").val(Math.round(resta));
						}
					}
				}
			}
			else
			{
				var netoCd = 0;
				$('.dato').each(function(){
		     		netoCd += parseInt( $(this).find('td').eq(12).text().replace(/\./g,'') || 0,10 )
		    	});

		    	if(netoCd != "")
		    	{
		    		if(tipoCambio != "")
		    		{
		    			var netoCdPeso = eval(netoCd) * eval(tipoCambio);
		    			$(".totalDescuentos").text("0");
						$(".netoCd").text(accounting.formatMoney(eval(netoCdPeso), "", 0, ".", "."));

						var iva = eval(netoCdPeso)* 0.19

						$(".iva").text(accounting.formatMoney(Math.round(iva), "", 0, ".", "."));
						$(".total").text(accounting.formatMoney(eval(netoCdPeso) + eval(iva), "", 0, ".", "."));
						$("#descuento").val("");
						$("#total").val(Math.round(eval(netoCdPeso) + eval(iva)));
						$("#neto_descuento").val(Math.round(netoCdPeso));

		    		}
		    		else
		    		{
		    			$(".totalDescuentos").text("0");
						$(".netoCd").text(accounting.formatMoney(eval(netoCd), "", 0, ".", "."));

						var iva = eval(netoCd)* 0.19

						$(".iva").text(accounting.formatMoney(Math.round(iva), "", 0, ".", "."));
						$(".total").text(accounting.formatMoney(eval(netoCd) + eval(iva), "", 0, ".", "."));
						$("#descuento").val("");
						$("#total").val(Math.round(eval(netoCd) + eval(iva)));
						$("#neto_descuento").val(Math.round(netoCd));

		    		}
		    	}
			}
			return false;

		});

		var descuentoEnPesos = $("#monto").val();
		if(descuentoEnPesos != "" && descuentoEnPesos != 0)
		{
			$("#monto").trigger('change');
		}

		var tipoMoneda = "";
		$("#tipo_moneda_id").on("change", function(){
			tipoMoneda = $("#tipo_moneda_id").val();
			$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"carga_tipo_cambios"))?>",
		    data: {"valor" : tipoMoneda},
		    async: true,
		    dataType: "json",
			    success: function( data ) {
			    	if(data != "")
			    	{
			    		$(".tipo_cambio").css("display", "block");
			    		$("#tipo_cambio").val(data).css("color", "#B40404");
			    	}
			    	else
			    	{
			    		$(".tipo_cambio").css("display", "none");
			    		$("#tipo_cambio").val(data);
			    	}
			    }
			});
		})


		$(document).on('click','.editar',function(){
			posicion = $(this).closest("tr").index();

			editar = $(this).parents().get(1);

			var idProductoEdita = $(this).attr("id");
			if(idProductoEdita != "")
			{
				var idProductoEditaCorto = idProductoEdita.split("-")
				if(idProductoEditaCorto[1] != "undefined")
				{
					idElimina = idProductoEditaCorto[1];
				}
			}
			
			

			var celdas = $(this).parent().parent();
			
			var cantidad = celdas.children("td:nth-child(1)").text().trim();
			var afecto = celdas.children("td:nth-child(2)").text().trim();
			var descripcion = celdas.children("td:nth-child(3)").text().trim();
			var precioUnitario = celdas.children("td:nth-child(4)").text().trim();
			var descuento = celdas.children("td:nth-child(5)").text().trim();
			var empaque = celdas.children("td:nth-child(6)").text().trim();
			var dimUno = celdas.children("td:nth-child(7)").text().trim();
			var dimDos = celdas.children("td:nth-child(8)").text().trim();
			var dimTres = celdas.children("td:nth-child(9)").text().trim();
			var dimCuatro = celdas.children("td:nth-child(10)").text().trim();
			var dimCinco = celdas.children("td:nth-child(11)").text().trim();
			var proyecto = celdas.children("td:nth-child(12)").text().trim();
			var codigoPresupuestario = celdas.children("td:nth-child(13)").text().trim();
			var subTotal = celdas.children("td:nth-child(14)").text().trim();

			$("#cantidad").val(cantidad);
			$("#descripcion").val(descripcion);
			$("#precio").val(precioUnitario);
			$("#empaque").select2({
				allowClear: true,
				width:'100%'}).select2('val',empaque);
			$("#dimUno").select2({
				allowClear: true,
				width:'100%'}).select2('val',dimUno);

			$("#descuento_producto_peso").val(descuento);
			
			if(afecto == "Exento")
			{
				$("#afecto2").prop('checked', true);
			}
			
			if(descuento != ""){
				$("#descuento_producto_peso").trigger('change');
			}

			if(dimUno != "")
			{
				$.ajax({
			    type: "GET",
			    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"codigoPresupuestario"))?>",
			    data: {"valor" : dimUno},
			    async: true,
			    dataType: "json",
				    success: function( data ) {
				    	$("#codigoPresupuestario option").remove();
				    	$("#codigoPresupuestario").append("<option value=''> </option>");
						if(data != "")
						{	
							$.each(data, function(i, item){
								$("#codigoPresupuestario").append("<option value="+item.Id+">" +item.Nombre+ "</option>");
								if(dimUno != "" && codigoPresupuestario != "")
								{
									if(codigoPresupuestario == item.Id)
									{
										$("#codigoPresupuestario").select2().select2('val',codigoPresupuestario);
									}
								}
							});

							$(".agregarProducto").removeClass('disabled');
						}
						else
						{
							$("#codigoPresupuestario").select2("data", null)
							//$(".agregarProducto").addClass('disabled')
						}		    	
				    }
				});
			}



			$("#dimDos").select2({
				allowClear: true,
				width:'100%'}).select2('val',dimDos);
			$("#dimTres").select2({
				allowClear: true,
				width:'100%'}).select2('val',dimTres);
			$("#dimCuatro").select2({
				allowClear: true,
				width:'100%'}).select2('val',dimCuatro);
			$("#dimCinco").select2({
				allowClear: true,
				width:'100%'}).select2('val',dimCinco);
			$("#proyecto").select2({
				allowClear: true,
				width:'100%'}).select2('val',proyecto);

			//$("#descuento_producto_peso").trigger('change');

			//celdas.children("td:nth-child(15) , .clsEliminarFila").trigger('click');
		});

		$('#ingresoProducto').on('show.bs.modal', function (event) {
			$("#descuento_producto_peso").trigger('change');
		})



		$('#total').on('change', function(){
		     var valorInicial = $(this).val();
		     var valorFormateado = accounting.formatMoney(valorInicial, "", 0, ".", ".");
		     $('#total').val(valorFormateado);
		});


		$('.editable').editable();

		$(".proveedor").select2({
			placeholder: "Seleccione Proveedor",
			allowClear: true,
			width:'100%',
		});

		$("#codigoPresupuestario").select2({
			placeholder: "Seleccione Código Presupuestario",
			allowClear: true,
			width:'100%',
		});

		$(".empaque").select2({
			placeholder: "Seleccione Empaque",
			//allowClear: true,
			width:'100%',
		});

		$(".tipoMoneda").select2({
			placeholder: "Seleccione tipo de moneda",
			allowClear: true,
			width:'100%',
		});

		$(".plazoPago").select2({
			placeholder: "Seleccione Plazo del Pago",
			allowClear: true,
			width:'100%',
		});

		$(".dimencionUno").select2({
			placeholder: "Dimension Uno",
			allowClear: true,
			width:'100%',
		});

		$(".dimencionDos").select2({
			placeholder: "Dimension Dos",
			allowClear: true,
			width:'100%',
		});

		$(".dimencionTres").select2({
			placeholder: "Dimension Tres",
			allowClear: true,
			width:'100%',
		});

		$(".dimencionCuatro").select2({
			placeholder: "Dimension Cuatro",
			allowClear: true,
			width:'100%',
		});

		$(".dimencionCinco").select2({
			placeholder: "Dimension Cinco",
			allowClear: true,
			width:'100%',
		});

		$(".proyectos").select2({
			placeholder: "Proyectos",
			allowClear: true,
			width:'100%',
		});

		 $('#fecha_entrega').datepicker({


		    format: "dd-mm-yyyy",
		    daysOfWeekDisabled: "0, 6",
		    //startView: 1,
		    language: "es",
		    multidate: false,
		    autoclose: true,
		    required: true
	    });


	    $(".dimencionUno").click(function(){
	    	var valorSeleccioando = $(this).val();
	    	//console.log(valorSeleccioando);
	    	//return false;
	    	$.ajax({
			    type: "GET",
			    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"codigoPresupuestario"))?>",
			    data: {"valor" : valorSeleccioando},
			    async: true,
			    dataType: "json",
				    success: function( data ) {
				    	$("#codigoPresupuestario option").remove();
				    	$("#codigoPresupuestario").append("<option value=''> </option>");
						if(data != "")
						{
							$.each(data, function(i, item){
								$("#codigoPresupuestario").append("<option value="+item.Id+">" +item.Nombre+ "</option>");
							});

							$(".agregarProducto").removeClass('disabled');
						}
						else
						{
							$("#codigoPresupuestario").select2("data", null)
							$(".agregarProducto").addClass('disabled')
						}
				    }
				});
	    });
	});




	$("#cantidad").change(function(){
		var valorFormateado = accounting.formatMoney($(this).val(), "", 0, ".", ".");
		$(this).val(valorFormateado);
		tieneDescuentoPorcentaje = $("#descuento_producto").val();
		if(tieneDescuentoPorcentaje != "")
		{
			$("#descuento_producto").trigger('change');
		}
	})

	$("#precio").change(function(){
		tipoMoneda = $("#tipo_moneda_id").val();

		if(tipoMoneda == 1 || tipoMoneda == "" )
		{
			var valorFormateado = accounting.formatMoney($(this).val(), "", 0, ".", ".");
		}
		else
		{
			var valorFormateado = accounting.formatMoney($(this).val(), "", 2, ".", ",");
		}


		$(this).val(valorFormateado);
	})

	$("#descuento").change(function(){
		var valorFormateado = accounting.formatMoney($(this).val(), "", 2, ".", ".");
		$(this).val(valorFormateado);
	})
	$('.tool').tooltip();


	$("#descuento_producto").change(function(){

		var cantidad = $("#cantidad").val();
		var precioUnitario = $("#precio").val().replace(/\./g,'') * eval(cantidad);

		var porcentajeDescuento = $(this).val();
		if(precioUnitario != "" && porcentajeDescuento != "")
		{
			$("#descuento_producto_peso").val(Math.round(porcentajeDescuento * precioUnitario / 100));

			if(porcentajeDescuento > 100)
			{
				alert("El descuento ingresado no puede superar el 100 %")
				$(this).val("");
				return false;
			}
		}
		if(porcentajeDescuento == "")
		{
			$("#descuento_producto_peso").val("");
		}
	})

	$("#descuento_producto_peso").change(function(){
		var cantidad = $("#cantidad").val();

		tipoMoneda = $("#tipo_moneda_id").val();

		if(tipoMoneda == 1 || tipoMoneda == "" )
		{
			var precioUnitario = $("#precio").val().replace(/\./g,'') * cantidad;
		}
		else
		{
			precioCondecimales = $("#precio").val().replace(/\./g,'').replace(/\,/g,'.');
			var precioUnitario = parseFloat(precioCondecimales) * cantidad;
		}

		var montopesos = $(this).val();
		var valorFormateado = $(this).val();


		if($("#tipo_moneda_id").val() == 1 || $("#tipo_moneda_id").val() == "")
		{
			$(this).val(accounting.formatMoney(valorFormateado, "", 0, ".", "."));
		}
		else
		{
			$(this).val(accounting.formatMoney(valorFormateado, "", 2, ".", ","));
		}


		if(precioUnitario != "" && montopesos != "")
		{
			porcentajeDescuento = eval(montopesos) * 100 / eval(precioUnitario)

			if(porcentajeDescuento > 100)
			{
				alert("El descuento ingresado no puede superar el 100 % , (valor % "+porcentajeDescuento.toFixed(0)+")");
				$(this).val("");
				return false;
			}

			$("#descuento_producto").val(porcentajeDescuento.toFixed(2));
		}
		else
		{
			$("#descuento_producto").val("");
		}
	})
	
	$("#tipo_documento17, #tipo_documento18, #tipo_documento19, #tipo_documento20 , #tipo_documento21, #tipo_documento22, #tipo_documento26").click(function(){
		valorEnPesos = 0;
		valorEnPesosConDescuento = 0;
		expresion = "";
		tipoCambio = $("#tipo_cambio").val();
		monto = $("#monto").val().replace(/\./g,'');
		valorExento = 0;
		
		if(tipoCambio == "" || tipoCambio == 1)
		{
			$('.sub_total_formato').each(function(i, valor) {
				valorEnPesos += parseInt( $(this).text().replace(/\./g,''))
			});
			
			$('.exento').each(function(i, valor) {
				valorExento += parseInt( $(this).text().replace(/\./g,''))
			});
		}
		else
		{
			$('.sub_total_formato').each(function(i, valor) {
				valorEnPesos += parseFloat($(this).text().replace(/\./g,'').replace(/\,/g,'.'))
			});
			
			$(".esconde").css("display", "block"); 

			$('.exento').each(function(i, valor) {
				valorExento += parseInt( $(this).text().replace(/\./g,''))
			});

			$(".valorMonedaOriginal").text(accounting.formatMoney(eval(valorEnPesos) + eval(valorExento), "", 2, ".", ","));
			
			
			valorExento = Math.round(valorExento * tipoCambio);
			
			valorEnPesos = Math.round(valorEnPesos * tipoCambio);
		}
		
		if(monto != "")
		{
			valorEnPesosConDescuento = parseInt(valorEnPesos) - parseInt(monto); 
		}
		
		if($(this).val() == 17 || $(this).val() == 22 || $(this).val() == 26)
		{ 
			var iva = 0
			$(".neto_sd").text(accounting.formatMoney(eval(valorEnPesos), "", 0, ".", "."));
			if(valorEnPesosConDescuento != 0)
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesosConDescuento)+eval(valorExento), "", 0, ".", "."));
				if($(".totalExento").text() != '' )
				{
					iva = eval(valorEnPesos) * 0.19;
				}
				else
				{
					iva = eval(eval(valorEnPesosConDescuento)+eval(valorExento)) * 0.19;
				}
				//iva = eval(eval(valorEnPesosConDescuento)+eval(valorExento)) * 0.19; //eval(valorEnPesosConDescuento) * 0.19
				$(".totalExento").text(accounting.formatMoney(eval(valorExento), "", 0, ".", "."));
				$(".total").text(accounting.formatMoney(eval(valorEnPesosConDescuento) + eval(iva) + eval(valorExento), "", 0, ".", "."));
				$("#total").val(Math.round(eval(valorEnPesosConDescuento) + eval(iva) + eval(valorExento)));
				$("#neto_descuento").val(Math.round(eval(valorEnPesosConDescuento)+eval(valorExento)));
			}
			else
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesos)+eval(valorExento), "", 0, ".", "."));
				iva = eval(valorEnPesos) * 0.19
				$(".totalExento").text(accounting.formatMoney(eval(valorExento), "", 0, ".", "."));
				$(".total").text(accounting.formatMoney(eval(valorEnPesos) + eval(iva) + eval(valorExento), "", 0, ".", "."));
				$("#total").val(Math.round(eval(valorEnPesos) + eval(iva) + eval(valorExento)));
				$("#neto_descuento").val(Math.round(eval(valorEnPesos)));
			}
			
			$(".textoIva").text("Impuesto: $ ");
			$(".iva").text(accounting.formatMoney(Math.round(iva), "", 0, ".", "."));
 		}

		if($(this).val() == 19 || $(this).val() == 20 || $(this).val() == 21)
		{
			//var iva = 0
			$(".neto_sd").text(accounting.formatMoney(eval(valorEnPesos), "", 0, ".", "."));
			if(valorEnPesosConDescuento != 0)
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesosConDescuento)+eval(valorExento), "", 0, ".", "."));
				$(".totalExento").text(accounting.formatMoney(eval(valorExento), "", 0, ".", "."));
				$(".total").text(accounting.formatMoney(eval(valorEnPesosConDescuento) + eval(valorExento), "", 0, ".", "."));
				$("#total").val(Math.round(eval(valorEnPesosConDescuento) + eval(valorExento)));
				$("#neto_descuento").val(Math.round(valorEnPesosConDescuento));
			}
			else
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesos)+eval(valorExento), "", 0, ".", "."));
				$(".totalExento").text(accounting.formatMoney(eval(valorExento), "", 0, ".", "."));
				$(".total").text(accounting.formatMoney(eval(valorEnPesos) + eval(valorExento), "", 0, ".", "."));
				$("#total").val(Math.round(eval(valorEnPesos)) + eval(valorExento));
				$("#neto_descuento").val(Math.round(eval(valorEnPesos)));
			}
			
			$(".textoIva").text("Impuesto: $ ");
			$(".iva").text(accounting.formatMoney(Math.round(0), "", 0, ".", "."));
 		}

 		if($(this).val() == 18)
		{
			var iva = 0
			$(".neto_sd").text(accounting.formatMoney(eval(valorEnPesos), "", 0, ".", "."));
			if(valorEnPesosConDescuento != 0)
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesosConDescuento)+eval(valorExento), "", 0, ".", "."));
				iva = eval(valorEnPesosConDescuento) / 10
				$(".totalExento").text(accounting.formatMoney(eval(valorExento), "", 0, ".", "."));
				$(".total").text(accounting.formatMoney(eval(valorEnPesosConDescuento) - eval(iva) + eval(valorExento), "", 0, ".", "."));
				$("#total").val(Math.round(eval(valorEnPesosConDescuento) - eval(iva) + eval(valorExento)));
				$("#neto_descuento").val(Math.round(valorEnPesosConDescuento));
			}
			else
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesos)+eval(valorExento), "", 0, ".", "."));
				iva = eval(valorEnPesos) / 10
				$(".totalExento").text(accounting.formatMoney(eval(valorExento), "", 0, ".", "."));
				$(".total").text(accounting.formatMoney(eval(valorEnPesos) - eval(iva) + eval(valorExento), "", 0, ".", "."));
				$("#total").val(Math.round(eval(valorEnPesos) - eval(iva) + eval(valorExento)));
				$("#neto_descuento").val(Math.round(eval(valorEnPesos)));
			}
			
			$(".textoIva").text("Retención: $ ");
			$(".iva").text(accounting.formatMoney(Math.round(iva), "", 0, ".", "."));
 		}
 		$(".neto_sd").removeClass('hidden');
 		$(".totalDescuentos").removeClass('hidden');
 		$(".netoCd").removeClass('hidden');
 		$(".iva").removeClass('hidden');
 		$(".total").removeClass('hidden');
 		$(".totalExento").removeClass('hidden');
	});

	var activaTipoCambio = "<?php echo $comprasProductosTotale['ComprasProductosTotale']['tipo_cambio']; ?>"

	if(activaTipoCambio != "")
	{
		$(".tipo_cambio").css("display", "block");
		var netoSindescuentoPeso = eval("<?php echo array_sum($netoSinDescuento);?>") * eval(activaTipoCambio);
		$(".neto_sd").text(accounting.formatMoney(netoSindescuentoPeso, "", 0, ".", "."));
	}
	
	$(document).ready(function(){
		$("#tipo_documento").trigger('click');
	})
	
	$("#numero_documento").change(function(){
		idEmpresa = $("#company_id").val();
		numeroFactura = $(this).val();
		tipoDocumento = $("input[name='data[tipo_documento]']:checked").val();
		$.ajax({
    		type: "GET",
			url:'<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"asociar_facturas"))?>',
			data: {
		    	"numeroFactura" : numeroFactura,
		    	"tipoDocumento" : tipoDocumento,
		    	"idEmpresa" : idEmpresa
		   },
	    async: true,
	    dataType: "json",
		    success: function( data ) {
		    	if(data == 1)
		    	{
		    		$("#numero_documento").val("");
		    		alert("El numero de documento ya esta registrado");
		    		retorno = false;
		    	}
		    }
		});
	})

</script>
