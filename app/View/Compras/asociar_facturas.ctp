<form class="form-horizontal" method="post" id="fileinfo" name="fileinfo" role="form">
	<?php 
		$options = $tipoDocumentos;
		$attributes = array('div' => 'input', 'type' => 'radio', 'options' => $options, 'class'=>'requerido radio_botom', "default"=>$comprasProductosTotale['TiposDocumento']['id']);
		echo $this->Form->input('tipo_documento',$attributes);
	?>
	<fieldset>
		<legend>Requerimiento de compra</legend>
		<?php
			$numeroDocumento = "";
			if(isset($comprasProductosTotale["ComprasFactura"][0]["numero_documento"]))
			{
				$numeroDocumento = $comprasProductosTotale["ComprasFactura"][0]["numero_documento"];
			}
		?>
			<div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Fecha Documento </label>
				<div class="col-md-6">
					<?php echo $this->Form->input('fecha_documento', array("class"=>"col-xs-4 form-control requerido", "label"=>false, 'placeholder'=>'Fecha Documento', 'default'=>$comprasProductosTotale["ComprasFactura"][0]["fecha_documento"]));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>N° Documento </label>
				<div class="col-md-6">
					<?php echo $this->Form->input('numero_documento', array("class"=>"requerido col-xs-4 form-control", "label"=>false, 'placeholder'=>'N° Documento', 'default'=>$numeroDocumento));?>
				</div>
			</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Seleccione proveedor : </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('company_id', array("class"=>"proveedor ajuste_select2", "options"=>$proveedores,"label"=>false));?>
			</div>
			<div class="col-md-2">
				<a href="<?php echo $this->Html->url(array("controller"=>"companies", "action"=>"add", 1)); ?>" class="btn btn-primary btn-xs tool registraempresa" data-toggle="tooltip" data-placement="top" title="Ingresar empresa" target="_blank"><i class="fa fa-plus"></i></a>
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
				<?php echo $this->Form->input('tipo_cambio', array("class"=>"form-control", "label"=>false, 'default'=>$comprasProductosTotale['ComprasProductosTotale']['tipo_cambio']));?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput">Seleccione pago : </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('plazos_pago_id', array("class"=>"plazoPago ajuste_select2", "label"=>false, "options"=>$plazosPagos));?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Titulo </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('titulo', array("class"=>"requerido col-xs-4 form-control", "label"=>false, 'placeholder'=>'titulo', 'default'=>$comprasProductosTotale["ComprasProductosTotale"]["titulo"]));?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button type="button" class="btn-block btn btn-success btn-lg ingresar_producto" data-toggle="modal" data-target="#ingresoProducto"><i class="fa fa-shopping-cart"></i> Ingresar Producto</button>
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
	    		foreach($comprasMultiplesProductos as $productos) : 
	    		if($productos["estado"] != 0 && $productos["estado"] != 3 && $productos["estado"] != 6)
	    		{
	    			$netoSinDescuento[] = $productos["cantidad"] * str_replace(".","",$productos["precio_unitario"]);
	    			$descuentosProductos[] = str_replace(".","",$productos["descuento_producto"]);
	    	?>
				<tr class="dato">
			    	<td class="eliminar"><input type="hidden" name="id[]" value="<?php echo $productos["id"];?>"> <input type="hidden" name="cantidad[]" value="<?php echo $productos["cantidad"];?>"><?php echo $productos["cantidad"];?></td>
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
							else
							{
								echo number_format($productos["subtotal"], 0, '', '.');
							}

						?>
					</td>

					<td class="total_producto ocultar"><input type="hidden" name="total_producto[]" value="<?php echo $productos["cantidad"] * str_replace(".","", $productos["precio_unitario"]) - str_replace(".","",$productos["descuento_producto"]); ?>">
					<?php echo $productos["cantidad"] * str_replace(".","", $productos["precio_unitario"]) - str_replace(".","",$productos["descuento_producto"]); ?>
					</td>

					<td>
						<button id="edita-<?php echo $productos["id"];?>" type="button" class="btn btn-success btn-xs editar" data-toggle="modal" data-target="#ingresoProducto"><i class="fa fa-pencil"></i></button>
						<button id="<?php echo $productos["id"];?>" type="button" class="btn btn-danger btn-xs clsEliminarFila eliminar-<?php echo $productos["id"]?>"><i class="fa fa-trash-o"></i></button>
					</td>
				<tr>
			<?php } endforeach; ?>


	    
	    </tbody>
	</table>
	<h4 class="text-right monedaOriginal esconde" >Total en moneda original: <span class="valorMonedaOriginal"></span></h4>

	<fieldset><legend>Totales y descuentos</legend>

	<div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput">Descuento % : </label>
		<div class="col-md-6">
			<?php echo $this->Form->input('descuento', array("class"=>"col-xs-4 form-control", "label"=>false, 'placeholder'=>'descuento %'));?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput">Descuento $ : </label>
		<div class="col-md-6">
			<?php echo $this->Form->input('monto', array("class"=>"col-xs-4 form-control", "label"=>false, 'placeholder'=>'descuento $', 'default'=>$comprasProductosTotale['ComprasProductosTotale']['descuento_total']));?>
		</div>
	</div>

	<!--div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Tipo de impuesto : </label>
		<div class="col-md-6">
			<label class="radio-inline baja"><input type="radio" name="tipoImpuesto" id="tipoImpuesto1" value="1" required>Afecto </label>
			<label class="radio-inline baja"><input type="radio" name="tipoImpuesto" id="tipoImpuesto2" value="2" required>Exento  </label>
			<label class="radio-inline baja"><input type="radio" name="tipoImpuesto" id="tipoImpuesto3" value="3" required>Honorarios  </label>
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
	<?php echo $this->Form->hidden('total', array('default'=>(array_sum($netoSinDescuento) - array_sum($descuentosProductos) ) * 0.19 + (array_sum($netoSinDescuento) - array_sum($descuentosProductos))));?>
	<?php echo $this->Form->hidden('id_clonado', array('default'=>implode(",", $idRequerimientos)));?>
	<?php echo $this->Form->hidden('clonar', array('default'=>6));?>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<div class="alert alert-info">
				<h4> Neto s/d : $ <span class="neto_sd"><?php echo number_format(array_sum($netoSinDescuento), 0, '', '.'); ?></span></h4>
				<?php echo $this->Form->hidden('neto_descuento', array('default'=>str_replace(".","",array_sum($netoSinDescuento) - array_sum($descuentosProductos))));?>
				<h4> Descuentos : $ <span class="totalDescuentos"> <?php echo number_format($comprasProductosTotale['ComprasProductosTotale']['descuento_total'], 0, '', '.')?></span></h4>
				<h4> Neto c/d : $ <span class="netoCd"> <?php echo number_format(array_sum($netoSinDescuento) - array_sum($descuentosProductos), 0, '', '.'); ?> </span></h4>
				<h4> <span class="textoIva">Impuesto : $ </span><span class="iva"> <?php echo number_format( (array_sum($netoSinDescuento) - array_sum($descuentosProductos)) * 0.19, 0, '', '.'); ?> </span></h4>
				<h4> Exento: $ </span> <span class="totalExento hidden"> </span></h4>
				<h4> Total : $ <span class="total"> <?php echo number_format((array_sum($netoSinDescuento) - array_sum($descuentosProductos) ) * 0.19 + (array_sum($netoSinDescuento) - array_sum($descuentosProductos)), 0, '', '.'); ?> </span></h4>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn-block btn btn-primary btn-lg generarOrden"><i class="fa fa-file-text-o"></i> Registrar documento tributario</button>
		</div>
	</div>
</form>
<!-- Modal -->
<div class="modal fade" id="ingresoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
  	<form id="formProducto" role="form"  method="Post" action="<?php echo $this->Html->url(array("controller" => "servicios","action" => "compraUnitario"))?>">
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
					<label class="col-md-4 control-label baja" for="passwordinput">Otros: </label>
					<div class="col-md-6">
						<?php echo $this->Form->input('dimCinco', array("class"=>"dimencionCinco", 'options'=>$dimensionCinco, "label"=>false, 'placeholder'=>'Otros'));?>
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
						<?php echo $this->Form->input('codigoPresupuestario', array("type"=>"select", "options" =>array(""=>""), "class"=>"codigoPresupuestario requerido", "label"=>false, 'placeholder'=>'Codigo Presupuestario'));?>
					</div>
				</div>
			</div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        <button type="submit" class="btn btn-primary agregarProducto" >Agregar</button>
		      </div>
     
    </div>
     </form>
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

	var editar = "";
	var posicion = 0;
	var idElimina  = "";



	$(document).ready(function() {
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
	
	$('.ocultar').hide();
	
	
	var validaFormulario = 0; 
	
	$('#fileinfo').validate({
	    submitHandler: function(form){
	    	validaFormulario = 1;
	    	return false;
	    }
	 });
	 
	 
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
			var fd = new FormData(document.getElementById("fileinfo"));
			$.ajax({
				url: "<?php echo $this->Html->url(array('controller'=>'Servicios', 'action'=>'facturados')); ?>",
				type: "POST",
				data: fd,
				enctype: 'multipart/form-data',
				processData: false,
				contentType: false
			}).done(function( data ) {
				if(data == 1)
				{
					setTimeout("window.location.href='<?php echo $this->Html->url(array('controller'=>'compras', 'action'=>'index'));?>';",1000);
				}
				else
				{
					setTimeout("window.location.href='<?php echo $this->Html->url(array('controller'=>'compras', 'action'=>'index'));?>';",1000);	
				}
			});
			e.preventDefault();
		});
	//}

	$(document).ready(function(){
		$("#company_id option[value='<?php echo $comprasProductosTotale['ComprasProductosTotale']['company_id']; ?>']").attr("selected","selected");
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
		    $('.sub_total_formato').each(function(i, valor) {
	     		sumaSubTotal += parseInt( $(this).text().replace(/\./g,''));
	    	})

			if(sumaSubTotal != "")
			{	
				var tipoCambio = $("#tipo_cambio").val();
				if(tipoCambio != "")
				{
					
					var sumaSubTotalPeso = eval(tipoCambio) * eval(sumaSubTotal);
					$(".neto_sd").text(accounting.formatMoney(sumaSubTotalPeso, "", 0, ".", ".")  );
					$(".netoCd").text(accounting.formatMoney(sumaSubTotalPeso, "", 0, ".", ".")  );
					$("#neto_descuento").val(Math.round(sumaSubTotalPeso));
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
					$("#neto_descuento").val(Math.round(sumaSubTotalFormateado));
					//$("#total").val(Math.round(sumaSubTotal));

					var iva = eval(sumaSubTotal) * 0.19;
					$(".iva").text(accounting.formatMoney(iva, "", 0, ".", "."));
					$(".total").text(accounting.formatMoney(eval(iva) + eval(sumaSubTotal), "", 0, ".", "."));
					$("#total").val(Math.round(eval(sumaSubTotal) + eval(iva)));
				}
			}

 			var sumaTotalProducto = 0;
 			var sumaSubTotalProducto = 0;
		    $('.sub_total_formato').each(function(i, valor) {
	     		sumaSubTotalProducto += parseInt( $(this).text().replace(/\./g,''))
	    	})
		   
		   if(sumaTotalProducto != "" && tipoCambio == "")
		   {
				$(".neto_sd").text(accounting.formatMoney(sumaTotalProducto, "", 0, ".", "."));
		   }
		   else
		   {
		   	$(".neto_sd").text(accounting.formatMoney(sumaSubTotalPeso, "", 0, ".", "."));
		   }

    	});


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
			    	detalleHtml += "<li class='list-group-item'>Gastos aprobados: $ " + accounting.formatMoney(data.gastosArea, "", 0, ".", ".") + "</li>";
			    	detalleHtml += "<li class='list-group-item'>Saldo: $ " + accounting.formatMoney(data.saldoGastos, "", 0, ".", ".") + "</li>";
			    	detalleHtml += "</ul>";
			    	$(".detalleCodigo").html(detalleHtml);
			    }
			});
		});


	
		$("#formProducto").submit(function (e) {
			e.preventDefault();

			if($("#cantidad").val() != "" && $("#descripcion").val() != "" && $("#codigoPresupuestario").val() != "" && $("#precio").val() != "" && $("#dimUno").val() != "")
			{
				if(editar)
				{

					if(idElimina != "")
					{
						$(".eliminar-"+idElimina).trigger('click');
					}
					if(editar != undefined)
					{
						editar.remove();
					}
					
				}


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
							tdHtml += "<td title='"+dimUnoCodigo[0]+"' id='codigoUno-"+dimUnoCodigo[0]+"' ><input type='hidden' name='dimCodigoUno[]' value='"+obj.dimUno+"'> "+obj.dimUno+"</td>";
							
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

						if(typeof obj.proyecto != 'undefined' && obj.proyecto)
						{
							alert(obj.proyecto);
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
										$(".neto_sd").text(accounting.formatMoney(subTotal, "", 0, ".", "."));
										//$(".neto_sd").text(' $ '+ accounting.formatMoney(eval(subTotal) * eval(tipoCambio), "", 0, ".", "."));
										console.log(1);

									}
									else
									{
										$(".neto_sd").text(accounting.formatMoney(eval(subTotal) * eval(tipoCambio), "", 0, ".", "."));
										console.log(2)
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

								
								//subTotalFormato = accounting.formatMoney(subTotal, "", 0, ".", ".");
							}
						}

						tdHtml += "<td class='"+sub_total_formato+"'><input type='hidden' name='subToal[]' value='"+ subTotalFormato.replace(/\./g,'')+"'>"+subTotalFormato+"</td>";

						tdHtml += "<td class='total_producto ocultar'><input type='hidden' name='total_producto[]' value='"+ subTotal+"'>"+subTotal+"</td>";

						tdHtml += '<td><button id="" type="button" class="btn btn-success btn-xs editar" data-toggle="modal" data-target="#ingresoProducto"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-danger btn-xs clsEliminarFila"><i class="fa fa-trash-o"></i></button></td>';
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

							if(tipoCambio != "")
							{

								var sumaSubTotalPeso = eval(tipoCambio) * eval(sumaSubTotal);
								$(".neto_sd").text(accounting.formatMoney(sumaSubTotalPeso, "", 0, ".", ".")  );
								$(".netoCd").text(accounting.formatMoney(sumaSubTotalPeso, "", 0, ".", ".")  );
								$("#neto_descuento").val(sumaSubTotalPeso);
								var iva = eval(sumaSubTotalPeso) * 0.19;
								$(".iva").text(accounting.formatMoney(iva, "", 0, ".", "."));
								$(".total").text(accounting.formatMoney(eval(iva) + eval(sumaSubTotalPeso), "", 0, ".", "."))
								$("#total").val(Math.round(eval(iva) + eval(sumaSubTotalPeso)));
								$(".totalDescuentos").text("0");
				
							}
							else
							{

								var sumaSubTotalFormateado = accounting.formatMoney(sumaSubTotal, "", 0, ".", ".");
								$(".neto_sd").text(sumaSubTotalFormateado);
								$(".netoCd").text(sumaSubTotalFormateado);
								$("#neto_descuento").val(sumaSubTotal);
								
								var iva = eval(sumaSubTotal) * 0.19;
								$(".iva").text(accounting.formatMoney(iva, "", 0, ".", "."));

								$(".total").text(accounting.formatMoney(eval(iva) + eval(sumaSubTotal), "", 0, ".", "."))
								$("#total").val(Math.round(eval(iva) + eval(sumaSubTotal)));
								$(".totalDescuentos").text("0");
							}
							valorDescuentoPeso = $("#monto").val();
							if(valorDescuentoPeso)
							{

								$("#monto").trigger('change');
							}
						}
						$("#cantidad").val("");
						$("#descripcion").val("");
						$("#precio").val("");
						$("#descuento_producto").val("");
						$("#descuento_producto_peso").val("");
					}
				});
			}
			else
			{
				alert("Ingrese todos los campos obligatorios")
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
		     		sumaSubTotal += parseInt($(this).text().replace(/\./g,''). replace(/\,/g,'.'))
		    	    //sumaSubTotal += parseInt($(this).text().replace(/\./g,''));
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

				var valorPorcentaje = parseInt(descuentoPocentaje) * sumaSubTotal; //parseInt($(".netoCd").text().replace(/\./g,'').replace(/\$/g,'').trim());

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
			var descuentoPeso = $(this).val()
			var tipoCambio = $("#tipo_cambio").val();	
 			var sumaSubTotal = 0;

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
				var sumaSubTotalFormateado = accounting.formatMoney(Math.round(sumaSubTotal), "", 0, ".", ".");


				$(".total").text(sumaSubTotalFormateado);
				$("#total").val(Math.round(sumaSubTotal));
			}

			var descuentoPocentaje = "";

			if(sumaSubTotal != "" && descuentoPeso != "")
			{
				
				descuentoPocentaje = parseFloat(descuentoPeso) * 100 / parseFloat(sumaSubTotal);

				if(tipoCambio != "")
				{
					var pesosATipoCambios = $(this).val() / tipoCambio
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
							$(".totalDescuentos").text(accounting.formatMoney($(this).val(), "", 0, ".", ".") );
							$(".netoCd").text(accounting.formatMoney(Math.round(eval(subTotalTipoCambio) - eval($(this).val())), "", 0, ".", ".") );
							resta = eval(subTotalTipoCambio) - eval( $(this).val());
							var iva = eval(resta) * 0.19
							$(".iva").text(accounting.formatMoney(Math.round(eval(iva)), "", 0, ".", ".") );
							$(".total").text(accounting.formatMoney(Math.round(eval(resta) + eval(iva)), "", 0, ".", ".") );

							$("#total").val(Math.round(eval(resta) + eval(iva) ));
							$("#neto_descuento").val(Math.round(resta));
						}
						else
						{
							var subTotalTipoCambio = eval(sumaSubTotal);
							
							$(".neto_sd").text(accounting.formatMoney (Math.round(eval(subTotalTipoCambio)), "", 0, ".", "."));
							$(".totalDescuentos").text(accounting.formatMoney($(this).val(), "", 0, ".", ".") );
							$(".netoCd").text(accounting.formatMoney(Math.round(eval(subTotalTipoCambio) - eval($(this).val())), "", 0, ".", ".") );
							resta = eval(subTotalTipoCambio) - eval( $(this).val());
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
				$('.sub_total_formato').each(function(i, valor) {
		     		netoCd += parseInt( $(this).text().replace(/\./g,''))
		    	})

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
			$(this).val(accounting.formatMoney(Math.round(descuentoPeso), "", 0, ".", "."))  
			tipoImpuesto = $("input[type='radio']:checked").val();
			if(tipoImpuesto != 1 && tipoImpuesto != 2)
			{
				nonbretipoImpuesto = "#tipo_documento"+tipoImpuesto;
				$(nonbretipoImpuesto).prop("checked", true).trigger("click");
			}
			return false;
		});

		var descuentoEnPesos = $("#monto").val();
		if(descuentoEnPesos != "")
		{
			$("#monto").trigger('change');
		}
	
		var tipoMoneda = "";
		$("#tipo_moneda_id").on("change", function(){
			tipoMoneda = $("#tipo_moneda_id").val();
			var tipoImpuesto = $('input:radio[name="data[tipo_documento]"]:checked').val();
			
			if(tipoImpuesto == undefined)
			{
				alert("Seleccion un tipo de documento antes de continuar");
				return false;
			}

			var tipoCambio = "";
			$.ajax({
			    type: "GET",
			    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"carga_tipo_cambios"))?>",
			    data: {"valor" : tipoMoneda},
			    async: true,
			    dataType: "json",
			    success: function(data) {
			    	if(data != "")
			    	{
			    		
			    		$(".tipo_cambio").css("display", "block");
			    		$("#tipo_cambio").val(data).css("color", "#B40404");

			    		tipoCambio = $("#tipo_cambio").val();
			    		total = $("#total").val();
						if(tipoMoneda != "" && total != "")
						{

							monto = $("#monto").val()

							var descuentoPeso = $("#monto").val(); //$(this).val()
				
				 			var sumaSubTotal = 0;

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
								var sumaSubTotalFormateado = accounting.formatMoney(Math.round(sumaSubTotal), "", 0, ".", ".");


								$(".total").text(sumaSubTotalFormateado);
								$("#total").val(Math.round(sumaSubTotal));
							}

							var descuentoPocentaje = "";

							if(sumaSubTotal != "" && descuentoPeso != "")
							{
								
								descuentoPocentaje = parseFloat(descuentoPeso) * 100 / parseFloat(sumaSubTotal);

								if(tipoCambio != "")
								{
									var pesosATipoCambios = descuentoPeso / tipoCambio
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


										if(tipoCambio != 1)
										{

											var subTotalTipoCambio = eval(sumaSubTotal) * eval(tipoCambio);

											

											$(".neto_sd").text(accounting.formatMoney (Math.round(eval(subTotalTipoCambio)), "", 0, ".", "."));
											$(".totalDescuentos").text(accounting.formatMoney(descuentoPeso, "", 0, ".", ".") );
											$(".netoCd").text(accounting.formatMoney(Math.round(eval(subTotalTipoCambio) - eval(descuentoPeso)), "", 0, ".", ".") );


											resta = eval(subTotalTipoCambio) - eval( descuentoPeso);
											if(tipoImpuesto == 17 || tipoImpuesto == 22)
									    	{
									    		var iva = eval(resta) * 0.19;
									    		$(".textoIva").text("Iva");
									    	}

									    	if(tipoImpuesto == 19 || tipoImpuesto == 20 || tipoImpuesto == 21)
									    	{
									    		iva = eval(0);
									    		$(".textoIva").text("Iva");
									    	}

									    	if(tipoImpuesto == 18)
									    	{
									    		iva = eval(resta) / 10;
									    		$(".textoIva").text("Retención");

									    	}
											


											$(".iva").text(accounting.formatMoney(Math.round(eval(iva)), "", 0, ".", ".") );
											$(".total").text(accounting.formatMoney(Math.round(eval(resta) + eval(iva)), "", 0, ".", ".") );

											$("#total").val(Math.round(eval(resta) + eval(iva) ));
											$("#neto_descuento").val(Math.round(resta));
										}
										else
										{


											var subTotalTipoCambio = eval(sumaSubTotal);
											
											$(".neto_sd").text(accounting.formatMoney (Math.round(eval(subTotalTipoCambio)), "", 0, ".", "."));
											$(".totalDescuentos").text(accounting.formatMoney(descuentoPeso, "", 0, ".", ".") );
											$(".netoCd").text(accounting.formatMoney(Math.round(eval(subTotalTipoCambio) - eval(descuentoPeso)), "", 0, ".", ".") );
											resta = eval(subTotalTipoCambio) - eval( descuentoPeso);
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
								$('.sub_total_formato').each(function(i, valor) {
						     		netoCd += parseInt( $(this).text().replace(/\./g,''))
						    	})

						    	if(netoCd != "")
						    	{
						    		

						    		if(tipoCambio != 1)
						    		{

						    			var netoCdPeso = eval(netoCd) * eval(tipoCambio);
						    			$(".neto_sd").text(accounting.formatMoney (Math.round(eval(netoCdPeso)), "", 0, ".", "."));
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
						}
			    	}
			    	else
			    	{
			    		$(".tipo_cambio").css("display", "none");
			    		$("#tipo_cambio").val(data);
			    		if(tipoMoneda == 1 && total != "")
			    		{
			    			var netoCd = 0;

							$('.sub_total_formato').each(function(i, valor) {
					     		netoCd += parseInt( $(this).text().replace(/\./g,''))
					    	})

					    	descuentos = $("#monto").val();
					    	


					    	if(descuentos > netoCd)
							{
								alert("El descuento es mayor al total");
								//$(".generarOrden").addClass("disabled");
								return false;
								
							}

					    	if(descuentos != "")
					    	{
					    		$(".totalDescuentos").text(accounting.formatMoney(Math.round(descuentos), "", 0, ".", "."));

					    		$(".netoCd").text(accounting.formatMoney(Math.round(netoCd - descuentos), "", 0, ".", "."));
					    	}
					    	else
					    	{
					    		$(".totalDescuentos").text('0');
					    	}

					    	tipoImpuesto = $('input:radio[name=tipoImpuesto]:checked').val()

					    	if(tipoImpuesto == 1)
					    	{
					    		var total = 0;

					    		if(descuentos != "")
					    		{
					    			total = eval(netoCd) - eval(descuentos);
					    		}
					    		else
					    		{
					    			total = netoCd;
					    		}

					    		var iva = eval(total) * 0.19
					    		$(".iva").text(accounting.formatMoney(Math.round(iva), "", 0, ".", "."));
					    		$(".total").text(accounting.formatMoney(eval(total) + eval(iva), "", 0, ".", "."));
					    	}

					    	if(tipoImpuesto == 2)
					    	{

					    		var total = 0;

					    		if(descuentos != "")
					    		{
					    			total = eval(netoCd) - eval(descuentos);
					    		}
					    		else
					    		{
					    			total = netoCd;
					    		}

					    		$(".textoIva").text("Iva")
								$(".iva").text("0");
								$(".total").text(accounting.formatMoney(total, "", 0, ".", "."));
								$("#total").val(Math.round(total));
					    	}

					    	if(tipoImpuesto == 3)
					    	{	

					    		var total = 0;

					    		if(descuentos != "")
					    		{
					    			total = eval(netoCd) - eval(descuentos);
					    		}
					    		else
					    		{
					    			total = netoCd;
					    		}

					    		var iva = eval(total) / 10
								$(".iva").text("  -" + accounting.formatMoney(Math.round(iva), "", 0, ".", "."));
								$(".textoIva").text("Retención");
								var totalRetencion = eval(total) - eval(iva);

								$(".total").text(accounting.formatMoney(totalRetencion, "", 0, ".", "."));
								$("#total").val(Math.round(totalRetencion));
					    	}

					    	$(".neto_sd").text(accounting.formatMoney(Math.round(netoCd), "", 0, ".", "."));

			    		}		    	
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
			var afecto = celdas.children("td:nth-child(2)").text().trim();
			var cantidad = celdas.children("td:nth-child(1)").text().trim();
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
			$("#empaque").select2().select2('val',empaque);
			$("#dimUno").select2().select2('val',dimUno);
			
			if(afecto == "Exento")
			{
				$("#afecto2").prop('checked', true);
			}
			
			$("#descuento_producto_peso").val(descuento);

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



			$("#dimDos").select2().select2('val',dimDos);
			$("#dimTres").select2().select2('val',dimTres);
			$("#dimCuatro").select2().select2('val',dimCuatro);
			$("#dimCinco").select2().select2('val',dimCinco);
			$("#proyecto").select2().select2('val',proyecto);

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
		var valorFormateado = accounting.formatMoney($(this).val(), "", 0, ".", ".");
		$(this).val(valorFormateado);
	})
	$('.tool').tooltip();


	$("#descuento_producto").change(function(){
		var cantidad = $("#cantidad").val();
		
		if(tipoMoneda == 1 || tipoMoneda == "" )
		{
			var precioUnitario = $("#precio").val().replace(/\./g,'') * cantidad;
		}
		else
		{
			precioCondecimales = $("#precio").val().replace(/\./g,'').replace(/\,/g,'.');
			var precioUnitario = parseFloat(precioCondecimales) * cantidad;
		}
		
		
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

	$("#tipo_documento17, #tipo_documento18, #tipo_documento19, #tipo_documento20 , #tipo_documento21, #tipo_documento22").click(function(){

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
			$(".valorMonedaOriginal").text(accounting.formatMoney(valorEnPesos, "", 2, ".", ","));
			
			$('.exento').each(function(i, valor) {
				valorExento += parseInt( $(this).text().replace(/\./g,''))
			});
			
			valorExento = Math.round(valorExento * tipoCambio);
			
			valorEnPesos = Math.round(valorEnPesos * tipoCambio);
		}
		
		if(monto != "")
		{
			valorEnPesosConDescuento = parseInt(valorEnPesos) - parseInt(monto); 
		}
		
		if($(this).val() == 17 || $(this).val() == 22)
		{ 
			var iva = 0
			$(".neto_sd").text(accounting.formatMoney(eval(valorEnPesos), "", 0, ".", "."));
			if(valorEnPesosConDescuento != 0)
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesosConDescuento), "", 0, ".", "."));
				iva = eval(valorEnPesosConDescuento) * 0.19
				$(".totalExento").text(accounting.formatMoney(eval(valorExento), "", 0, ".", "."));
				$(".total").text(accounting.formatMoney(eval(valorEnPesosConDescuento) + eval(iva) + eval(valorExento), "", 0, ".", "."));
				$("#total").val(Math.round(eval(valorEnPesosConDescuento) + eval(iva) + eval(valorExento)));
				$("#neto_descuento").val(Math.round(valorEnPesosConDescuento));
			}
			else
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesos), "", 0, ".", "."));
				iva = eval(valorEnPesos) * 0.19
				$(".totalExento").text(accounting.formatMoney(eval(valorExento), "", 0, ".", "."));
				$(".total").text(accounting.formatMoney(eval(valorEnPesos) + eval(iva) + eval(valorExento), "", 0, ".", "."));
				$("#total").val(Math.round(eval(valorEnPesos) + eval(iva) + eval(valorExento)));
				$("#neto_descuento").val(Math.round(eval(valorEnPesos)));
			}
			
			$(".textoIva").text("Impuesto: $ ");
			$(".iva").text(accounting.formatMoney(Math.round(iva), "", 0, ".", "."));
 		}

		if($(this).val() == 19 ||  $(this).val() == 21 || $(this).val() == 20 )
		{
			//var iva = 0
			$(".neto_sd").text(accounting.formatMoney(eval(valorEnPesos), "", 0, ".", "."));
			if(valorEnPesosConDescuento != 0)
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesosConDescuento), "", 0, ".", "."));
				$(".totalExento").text(accounting.formatMoney(eval(valorExento), "", 0, ".", "."));
				$(".total").text(accounting.formatMoney(eval(valorEnPesosConDescuento) + eval(valorExento), "", 0, ".", "."));
				$("#total").val(Math.round(eval(valorEnPesosConDescuento) + eval(valorExento)));
				$("#neto_descuento").val(Math.round(valorEnPesosConDescuento));
			}
			else
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesos), "", 0, ".", "."));
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
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesosConDescuento), "", 0, ".", "."));
				iva = eval(valorEnPesosConDescuento) / 10
				$(".totalExento").text(accounting.formatMoney(eval(valorExento), "", 0, ".", "."));
				$(".total").text(accounting.formatMoney(eval(valorEnPesosConDescuento) - eval(iva) + eval(valorExento), "", 0, ".", "."));
				$("#total").val(Math.round(eval(valorEnPesosConDescuento) - eval(iva) + eval(valorExento)));
				$("#neto_descuento").val(Math.round(valorEnPesosConDescuento));
			}
			else
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesos), "", 0, ".", "."));
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
		$(".neto_sd").text(' $ '+accounting.formatMoney(netoSindescuentoPeso, "", 0, ".", "."));
	}

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
