<form class="form-horizontal" method="post" id="fileinfo" name="fileinfo" role="form">
	<fieldset>
		<legend>Requerimiento de compra</legend>
		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Seleccione proveedor : </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('company_id', array("class"=>"requerido proveedor ajuste_select2", "options"=>$proveedores,"label"=>false));?>
			</div>
			<div class="col-md-2">
				<a href="<?php echo $this->Html->url(array("controller"=>"companies", "action"=>"add", 1)); ?>" target="_blank" class="btn btn-primary btn-xs tool registraempresa" data-toggle="tooltip" data-placement="top" title="Ingresar empresa"><i class="fa fa-plus"></i></a>
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
				<?php echo $this->Form->input('tipo_cambio', array("class"=>"form-control", "label"=>false));?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput">Seleccione pago : </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('plazos_pago_id', array("class"=>"requerido plazoPago ajuste_select2", "label"=>false, "options"=>$plazosPagos));?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Titulo </label>
			<div class="col-md-6">
				<?php echo $this->Form->input('titulo', array("class"=>"requerido col-xs-4 form-control", "label"=>false, 'placeholder'=>'titulo'));?>
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
					<?php echo $this->Form->input('monto', array("class"=>"col-xs-4 form-control", "label"=>false, 'placeholder'=>'descuento $'));?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Tipo de impuesto : </label>
				<div class="col-md-6">
					<label class="radio-inline baja"><input type="radio" name="tipoImpuesto" id="tipoImpuesto1" value="1" class="requerido">Afecto (19%)</label>
					<label class="radio-inline baja"><input type="radio" name="tipoImpuesto" id="tipoImpuesto2" value="2" class="requerido">Exento (0%)</label>
					<label class="radio-inline baja"><input type="radio" name="tipoImpuesto" id="tipoImpuesto3" value="3" class="requerido">Retención (10%)</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Archivo adjunto : </label>
				<div class="col-md-6">
					<?php echo $this->Form->input('adjunto.', array("type"=>"file", 'multiple', "class"=>"requerido", "label"=>false, "div"=>false,'placeholder'=>'Adjuntar archivo'));?><small class="label label-info">Utilice la tecla Ctrl para adjuntar mas de un archivo</small>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput">Observación : </label>
				<div class="col-md-6">
					<?php echo $this->Form->textArea('observacion', array("class"=>"form-control", "label"=>false, 'placeholder'=>'Observacion'));?>
				</div>
			</div>
			<?php echo $this->Form->hidden('total');?>

			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<div class="alert alert-info">
						<h4> Neto Afecto s/d: $ <span class="neto_sd hidden"> </span></h4>
						<?php echo $this->Form->hidden('neto_descuento');?>
						<h4> Neto Exento s/d: $ </span> <span class="totalExento hidden"> </span></h4>
						<h4> Descuentos: $ <span class="totalDescuentos hidden"> </span></h4>
						<h4> Neto Total c/d: $ <span class="netoCd hidden"> </span></h4>
						<h4> <span class="textoIva">Impuesto: $ </span> <span class="iva hidden"> </span></h4>
						<h4> Total: $ <span class="total hidden"> </span></h4> 
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button type="submit" class="btn-block btn disabled btn-primary btn-lg generarOrden"><i class="fa fa-file-text-o"></i> Generar Requerimiento</button>
				</div>
			</div>
		</form>


		<!-- Modal -->
		<div class="modal fade" id="ingresoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" style="width:800px;">
				<a name="miancla"></a>
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
					</form>
				</div>
			</div>

		</div>

		<div class="modal fade" id="detalleSaldoCodigo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" style="width: 450px;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">Código Presupuestario: <span class="nombreCodigoPresupuestario"> </span></h4>
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
		$(".generarOrden").addClass("disabled");
		
		var fd = new FormData(document.getElementById("fileinfo"));
		$.ajax({
			url: "<?php echo $this->Html->url(array('controller'=>'Servicios', 'action'=>'addOrdenCompra')); ?>",
			type: "POST",
			data: fd,
			enctype: 'multipart/form-data',
			processData: false,
			contentType: false
		}).done(function(data) {
			if(data != "")
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

	
	//js para la generacion de tablas
	$(document).ready(function(){
		$("#tipo_moneda_id option[value='1']").attr("selected","selected");
		$("#plazos_pago_id option[value='2']").attr("selected","selected");
		$("#empaque option[value='Unidad']").attr("selected","selected");

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

        	var objCuerpo = $(this).parents().get(2);
            if($(objCuerpo).find('tr').length == 1)
            {
            	$(".generarOrden").addClass("disabled");
            	$(".total").html("0");
            	$(".netoCd").html("0");
            	$("#neto_descuento").val("");
            	$("#total").val("");
            	$(".totalDescuentos").html("0");
            	$(".neto_sd").html("0");
            	$(".iva").html("0");
            }

         

        	var objFila = $(this).parents().get(1);

            $(objFila).remove();

            var sumaSubTotal = 0;
            $('.sub_total_formato').each(function(i, valor) {
	     		sumaSubTotal += parseInt( $(this).text().replace(/\./g,'').replace(/\,/g,'.'))
	    	})
	    	/*
		    $('.dato').each(function(){
		     	sumaSubTotal += parseInt( $(this).find('td').eq(13).text().replace(/\./g,'') || 0,10 )
		    })
			*/
			if(sumaSubTotal != "")
			{
				var tipoCambio = $("#tipo_cambio").val();
				if(tipoCambio != "")
				{
					var sumaSubTotalPeso = eval(tipoCambio) * eval(sumaSubTotal);
					$(".netoCd").text( accounting.formatMoney(sumaSubTotalPeso, "", 0, ".", ".")  );
					$("#neto_descuento").val(Math.round(sumaSubTotalPeso));
					var iva = eval(sumaSubTotalPeso) * 0.19;
					$(".iva").text(accounting.formatMoney(iva, "", 0, ".", "."));
					$(".total").text(accounting.formatMoney(eval(iva) + eval(sumaSubTotalPeso), "", 0, ".", "."))
					$("#total").val(Math.round(eval(iva) + eval(sumaSubTotalPeso)));
				}
				else
				{
					var sumaSubTotalFormateado = accounting.formatMoney(sumaSubTotal, "", 0, ".", ".");
					$(".netoCd").text("$ " +sumaSubTotalFormateado);
					$("#neto_descuento").val(Math.round(sumaSubTotalFormateado));
					//$("#total").val(Math.round(sumaSubTotal));

					var iva = eval(sumaSubTotal) * 0.19;
					$(".iva").text(accounting.formatMoney(iva, "", 0, ".", "."));
					$(".total").text(accounting.formatMoney(eval(iva) + eval(sumaSubTotal), "", 0, ".", "."));
					$("#total").val(Math.round(eval(sumaSubTotal) + eval(iva)));
				}
			}

 			var sumaTotalProducto = 0;
 			
 			$('.sub_total_formato').each(function(i, valor) {
	     		sumaTotalProducto += parseInt( $(this).text().replace(/\./g,'').replace(/\,/g,'.'))
	    	})
	    	/*
		    $('.dato').each(function(){
		     	sumaTotalProducto += parseInt( $(this).find('td').eq(13).text().replace(/\./g,'') || 0,10 )
		    })
		    */
		   
		   if(sumaTotalProducto != "" && tipoCambio == "")
		   {
				$(".neto_sd").text( accounting.formatMoney(sumaTotalProducto, "", 0, ".", "."));
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
						
						var tdHtml = ""
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

										$(".neto_sd").text(' $ '+ accounting.formatMoney(eval(netoSd) + eval(netoSdPeso), "", 0, ".", "."));
									}
									else
									{
										$(".neto_sd").text(' $ '+ accounting.formatMoney(eval(subTotal) + eval(netoSd), "", 0, ".", "."));
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
					     		sumaSubTotal += parseInt( $(this).text().replace(/\./g,'').replace(/\,/g,'.'))
					    	})
					    	/*
							$('.dato').each(function(){
					     		sumaSubTotal += parseInt( $(this).find('td').eq(13).text().replace(/\./g,'') || 0,10 )
					    	})
					    	*/
						}
						else
						{
							$('.sub_total_formato').each(function(i, valor) {
					     		sumaSubTotal += parseFloat( $(this).text().replace(/\./g,'').replace(/\,/g,'.'))
					    	})
					    	
					    	/*
							$('.dato').each(function(){
					     		sumaSubTotal += parseFloat( $(this).find('td').eq(13).text().replace(/\./g,'').replace(/\,/g,'.') || 0,10 )
					    	})
					    	*/
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

								$(".total").text( accounting.formatMoney(eval(iva) + eval(sumaSubTotal), "", 0, ".", "."))
								$("#total").val(Math.round(eval(iva) + eval(sumaSubTotal)));

								$(".totalDescuentos").text("0");
							}
							else
							{

								var sumaSubTotalPeso = parseFloat(tipoCambio) * parseFloat(sumaSubTotal);

								$(".netoCd").text(accounting.formatMoney(Math.round(sumaSubTotalPeso), "", 0, ".", "."));
								$("#neto_descuento").val(Math.round(sumaSubTotalPeso));
								$(".neto_sd").text(accounting.formatMoney(Math.round(sumaSubTotalPeso), "", 0, ".", "."));
								$(".totalDescuentos").text(" 0");



								var iva = eval(Math.round(sumaSubTotalPeso)) * 0.19;
								$(".iva").text(accounting.formatMoney(iva, "", 0, ".", "."));
								$(".total").text( accounting.formatMoney(eval(iva) + eval(Math.round(sumaSubTotalPeso)), "", 0, ".", "."))
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
		}); 
		
		$(".ingresar_producto").click(function(){
			$("#cantidad").val("");
			$("#descripcion").val("");
			$("#precio").val("");
			$("#descuento_producto").val("");
			$("#descuento_producto_peso").val("");
			$("#modal-body").animate({ scrollTop: 0 }, 600);
    		
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
	    	$('.sub_total_formato').each(function(i, valor) {
	     		sumaSubTotal += parseInt( $(this).text().replace(/\./g,''))
	    	})

			if(sumaSubTotal != "")
			{
				var sumaSubTotalFormateado = accounting.formatMoney(sumaSubTotal, "", 0, ".", ".");
				$(".total").text("$ " +sumaSubTotalFormateado);
			}

			var descuentoPocentaje = $("#descuento").val();
			var descuentoMonto = $("#monto").val();


			
			var total = $("#total").val(); 
			
			
			
			if(descuentoPocentaje != "" && total != "")
			{

				var valorPorcentaje = parseFloat(descuentoPocentaje) * parseFloat(sumaSubTotal); 
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
			    			$(".neto_sd").text('$ ' +accounting.formatMoney (Math.round(eval(netoCd) * eval(tipoCambio)), "", 0, ".", "."));
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
						
			    	}
					return false;
				}
			};
			
			tipoImpuesto = $("input[type='radio']:checked").val();
			if(tipoImpuesto != "")
			{
				nonbretipoImpuesto = "#tipoImpuesto"+tipoImpuesto;
				$(nonbretipoImpuesto).prop("checked", true).trigger("click");
			}
			return false;		
		});

	
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
		    	/*
		    	$('.dato').each(function(){
		     		sumaSubTotal += parseFloat( $(this).find('td').eq(13).text().replace(/\./g,'').replace(/\,/g,'.') || 0,10 )
		    	})
		    	*/
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
			tipoImpuesto = $("input[type='radio']:checked").val();
			if(tipoImpuesto != "")
			{
				nonbretipoImpuesto = "#tipoImpuesto"+tipoImpuesto;
				$(nonbretipoImpuesto).prop("checked", true).trigger("click");
			}
			return false;
		})

		var tipoMoneda = "";
		$("#tipo_moneda_id").on("change", function(){
			tipoMoneda = $("#tipo_moneda_id").val();
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
						    	
						    	/*
						    	$('.dato').each(function(){
						     		sumaSubTotal += parseInt( $(this).find('td').eq(13).text().replace(/\./g,'') || 0,10 )
						    	})
						    	*/
						    }
						    else
						    {
						    	$('.sub_total_formato').each(function(i, valor) {
						     		sumaSubTotal += parseFloat( $(this).text().replace(/\./g,'').replace(/\,/g,'.'))
						    	})
						    	/*
						    	$('.dato').each(function(){
						     		sumaSubTotal += parseFloat( $(this).find('td').eq(13).text().replace(/\./g,'').replace(/\,/g,'.') || 0,10 )
						    	})*/
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

											var tipoImpuesto = $('input:radio[name=tipoImpuesto]:checked').val()

											$(".neto_sd").text(accounting.formatMoney (Math.round(eval(subTotalTipoCambio)), "", 0, ".", "."));
											$(".totalDescuentos").text(accounting.formatMoney(descuentoPeso, "", 0, ".", ".") );
											$(".netoCd").text(accounting.formatMoney(Math.round(eval(subTotalTipoCambio) - eval(descuentoPeso)), "", 0, ".", ".") );
											resta = eval(subTotalTipoCambio) - eval( descuentoPeso);
											if(tipoImpuesto == 1)
									    	{
									    		var iva = eval(resta) * 0.19;
									    		$(".textoIva").text("Iva");
									    	}

									    	if(tipoImpuesto == 2)
									    	{
									    		iva = eval(0);
									    		$(".textoIva").text("Iva");
									    	}

									    	if(tipoImpuesto == 3)
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
						     		netoCd += parseInt( $(this).text().replace(/\./g,'').replace(/\,/g,'.'))
						    	})
						    	
						    	/*
								$('.dato').each(function(){
						     		netoCd += parseInt( $(this).find('td').eq(13).text().replace(/\./g,'') || 0,10 )
						    	});
						    	*/

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
							
							/*
							$('.dato').each(function(){
					     		netoCd += parseInt( $(this).find('td').eq(13).text().replace(/\./g,'') || 0,10 )
					    	});
					    	*/
					    	$('.sub_total_formato').each(function(i, valor) {
					     		netoCd += parseInt( $(this).text().replace(/\./g,'').replace(/\,/g,'.'))
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
			tipoImpuesto = $("input[name='tipoImpuesto']:checked").val();
			
			if(tipoImpuesto == 1)
			{
				$("#tipoImpuesto1").prop("checked", true).trigger("click");
			}
			
			if(tipoImpuesto == 2)
			{
				$("#tipoImpuesto2").prop("checked", true).trigger("click");
			} 
			
			if(tipoImpuesto == 3)
			{
				$("#tipoImpuesto3").prop("checked", true).trigger("click");
			} 
		})
		
		
		$('#total').on('change', function(){
		     var valorInicial = $(this).val();
		     var valorFormateado = accounting.formatMoney(valorInicial, "", 0, ".", ".");
		     $('#total').val(Math.round(valorFormateado));
		});
		
		
		$('.editable').editable();
		//$("proveedor option").empty();
		$(".proveedor").select2({
			placeholder: "Seleccione Proveedor",
			allowClear: true,
			width:'100%',
			minimumInputLength: 2,
			language: "es"
		});
		

		$("#codigoPresupuestario").select2({
			placeholder: "Seleccione Código Presupuestario",
			allowClear: true,
			width:'100%',
		});

		$(".empaque").select2({
			placeholder: "Seleccione Empaque",
			allowClear: true,
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
	    
	    $(".select2-no-results").text("ingrese al menos 2 caracteres")
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

		if(porcentajeDescuento > 100)
		{
			alert("El descuento ingresado no puede superar el 100 %")
			$(this).val("");
			return false;
		}


		if(precioUnitario != "" && porcentajeDescuento != "")
		{
			 $("#descuento_producto_peso").val(accounting.formatMoney( Math.round(porcentajeDescuento * precioUnitario / 100), "", 0, ".", "."));
		}else{
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

	$("#tipoImpuesto1, #tipoImpuesto2, #tipoImpuesto3").click(function(){
		
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
		
		if($(this).val() == 1)
		{
			var iva = 0
			$(".neto_sd").text(accounting.formatMoney(eval(valorEnPesos), "", 0, ".", "."));
			if(valorEnPesosConDescuento != 0)
			{
				$(".netoCd").text(accounting.formatMoney(eval(valorEnPesosConDescuento)+eval(valorExento), "", 0, ".", "."));
				
				if($(".totalExento").text() != '' )
				{
					iva = eval(valorEnPesosConDescuento) * 0.19;
				}
				else
				{
					iva = eval(eval(valorEnPesosConDescuento)+eval(valorExento)) * 0.19;
				}

				//iva = eval(eval(valorEnPesosConDescuento)+eval(valorExento)) * 0.19;//iva = eval(valorEnPesos) * 0.19; //eval(valorEnPesosConDescuento) * 0.19
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
	   
	   	if($(this).val() == 2)
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
 		
		if($(this).val() == 3)
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
</script>