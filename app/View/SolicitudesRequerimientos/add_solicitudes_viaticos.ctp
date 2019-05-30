<form class="form-horizontal" method="post" id="fileinfo" name="fileinfo" role="form">
	<div>
		<fieldset>
			<legend>Requerimiento de viático</legend>
			<div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Fecha de Inicio </label>
				<div class="col-md-6">
					<?php 
						echo $this->Form->input('fecha_documento', 
						array("class"=>"col-xs-4 form-control requerido", 
								"label"=>false, 'placeholder'=>'Fecha Documento')
						);
					?>
				</div>
			</div>

            <div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput">Hora de inicio </label>
				<div class="col-md-6">
					<?php 
					echo $this->Form->input('fecha_documento', 
					array("class"=>"col-xs-4 form-control requerido", 
						"label"=>false, 'placeholder'=>'Fecha Documento')
					);
					?>
				</div>
			</div>

            <div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Fecha de término </label>
				<div class="col-md-6">
					<?php 
					echo $this->Form->input('fecha_documento', 
						array(
							"class"=>"col-xs-4 form-control requerido", 
							"label"=>false, 
							'placeholder'=>'Fecha Documento'
						)
					);
					?>
				</div>
			</div>

            <div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput">Hora de término </label>
				<div class="col-md-6">
					<?php 
					echo $this->Form->input('fecha_documento', 
						array(
							"class"=>"col-xs-4 form-control requerido", 
							"label"=>false, 
							'placeholder'=>'Fecha Documento'
						)
					);
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Responsable</label>
				<div class="col-md-6">
					<?php 
					echo $this->Form->input('numero_documento', 
						array(
							"class"=>"col-xs-4 form-control requerido", 
							"label"=>false, 
							'placeholder'=>'N° Boleta'
						)
					);
					?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput">Seleccione moneda</label>
				<div class="col-md-6">
					<?php 
					echo $this->Form->input('tipo_moneda_id', 
						array(
							"class"=>"tipoMoneda ajuste_select2 form-control", 
							"options"=>$tipoMonedas, 
							"label"=>false, 
							'requiered'=>true
						)
					);
					?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Titulo </label>
				<div class="col-md-6">
					<?php 
					echo $this->Form->input('titulo', 
						array(
						"class"=>"col-xs-4 form-control ", 
						"label"=>false, 
						'placeholder'=>'titulo'
						)
					);
					?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button type="button" class="btn-block btn btn-success btn-lg" data-toggle="modal" data-target="#ingresoProducto"><i class="fa fa-shopping-cart"></i> Ingresar viático</button>
				</div>
			</div>
		</fieldset>

		<legend>Detalle de viáticos ingresados</legend>

		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Descripción</th>
					<th>Colaborador</th>
					<th>Monto</th>
					<th>Gerencia</th>
					<th>Estadio</th>
					<th>Contenido</th>
					<th>Canales distribución</th>
					<th>Otros</th>
					<th>Proyectos</th>
					<th>Cod. Presupuestario.</th>
				</tr>
			</thead>
			<tbody class="productos">

			</tbody>
		</table>
		<h4 class="text-right monedaOriginal esconde" >Total en moneda original: <span class="valorMonedaOriginal"></span></h4>

		<!--div class="form-group" style="visibility:hidden;">
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
				<?php 
				echo $this->Form->input('adjunto.', 
					array(
						"type"=>"file", 
						'multiple', 
						"class"=>"requerido", 
						"label"=>false, 
						'placeholder'=>'Adjuntar archivo'
						)
					);
				?>
				<small class="label label-info">Utilice la tecla Ctrl para adjuntar mas de un archivo</small>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput">Observación : </label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->textArea('observacion', 
						array("class"=>"form-control", 
						"label"=>false, 
						'placeholder'=>'Observacion'
						)
					);
				?>
			</div>
		</div>
		<?php echo $this->Form->hidden('total');?>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<div class="alert alert-info">
					<h4> Neto Afecto s/d: <span class="neto_sd"> </span></h4>
					<h4> Neto Exento s/d: </span> <span class="totalExento hidden"> </span></h4>
					<?php echo $this->Form->hidden('neto_descuento');?>
					<h4> Descuentos: $ <span class="totalDescuentos"> </span></h4>
					<h4> Neto Total c/d: $ <span class="netoCd"> </span></h4>
					<h4> <span class="textoIva">Impuesto : </span><span class="iva"> </span></h4>
					
					<h4> Total: $ <span class="total"> </span></h4> 
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button type="submit" class="btn-block btn disabled btn-primary btn-lg generarOrden"><i class="fa fa-file-text-o"></i> Generar Requerimiento de viático</button>
			</div>
		</div>
	</div>
</form>
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
					<table style="text-align: left; width: 700px; height: 172px;" border="0"cellpadding="2" cellspacing="2">
						<tbody>
							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong><span class="aterisco">*</span>Cantidad:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
								<?php 
									echo $this->Form->input('cantidad', 
										array("class"=>"form-control requerido", 
										"label"=>false, 'placeholder'=>'Cantidad'
										)
									);
								?>
								</td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong><span class="aterisco">*</span>Producto: </strong></td>
								<td style="vertical-align: bottom; width: 458px;">
									<?php 
										echo $this->Form->input('descripcion', 
											array(
											"class"=>"form-control requerido", 
											"label"=>false, 
											'placeholder'=>' Producto'
											)
										);
									?>
								</td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong><span class="aterisco">*</span>Precio unitario:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
									<?php 
									echo $this->Form->input('precio', 
										array(
											"class"=>"form-control requerido", 
											"label"=>false, 
											'placeholder'=>'Precio Unitario'
										)
									);
									?>
								</td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong>Descuento %:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
								<?php 
								echo $this->Form->input('descuento_producto', 
									array(
										"class"=>"form-control", 
										"label"=>false, 
										'placeholder'=>'Descuento al Producto'
									)
								);
								?>
								</td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong>Descuento $:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
								<?php 
								echo $this->Form->input('descuento_producto_peso', 
									array(
										"class"=>"form-control", 
										"label"=>false, 
										'placeholder'=>'Descuento al Producto'
									)
								);
								?></td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong>Empaque:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
								<?php 
								echo $this->Form->input('empaque', 
									array(
										"class"=>"empaque", 
										"label"=>false, 
										'options'=>$empaques, 
										'placeholder'=>'Tipo de Empaque'
									)
								);
								?>
								</td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong><span class="aterisco">*</span>Gerencias:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
								<?php 
								echo $this->Form->input('dimUno', 
									array(
										"class"=>"dimencionUno requerido", 
										"label"=>false, 
										'options'=>$dimensionUno, 
										'placeholder'=>'Gerencias'
									)
								);
								?>
								</td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong>Estadios:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
								<?php 
								echo $this->Form->input('dimDos', 
									array(
										"class"=>"dimencionDos", 
										'options'=>$dimensionDos, 
										"label"=>false, 
										'placeholder'=>'Estadios'
									)
								);
								?>
									</td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong>Contenido:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
								<?php 
								echo $this->Form->input('dimTres', 
									array(
										"class"=>"dimencionTres", 
										'options'=>$dimensionTres, 
										"label"=>false, 
										'placeholder'=>'Contenido'
									)
								);
								?></td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong>Canal de distribución:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
								<?php 
									echo $this->Form->input('dimCuatro', 
										array(
											"class"=>"dimencionCuatro", 
											'options'=>$dimensionCuatro, 
											"label"=>false, 
											'placeholder'=>'Canal de distribución'
										)
									);
								?>
								</td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong>Otros:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
								<?php 
									echo $this->Form->input('dimCinco', 
										array(
											"class"=>"dimencionCinco", 
											'options'=>$dimensionCinco, 
											"label"=>false, 
											'placeholder'=>'Otros'
										)
									);
								?>
								</td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong>Proyectos:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
								<?php 
									echo $this->Form->input('proyecto', 
										array(
											"class"=>"proyectos", 
											'options'=>$proyectos, 
											"label"=>false, 
											'placeholder'=>'Proyectos'
										)
									);
								?>
								</td>
							</tr>

							<tr>
								<td style="vertical-align: bottom; width: 222px;"><strong><span class="aterisco">*</span>Códigos predupuestarios:</strong></td>
								<td style="vertical-align: bottom; width: 458px;">
								<?php 
								echo $this->Form->input('codigoPresupuestario', 
									array(
										"type"=>"select", 
										"options" =>array(""=>""), 
										"class"=>"codigoPresupuestario requerido requerido", 
										"label"=>false, 
										'placeholder'=>'Codigo Presupuestario'
									)
								);
								?>
								</td>
							</tr>

						</tbody>
					</table>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary agregarProducto" >Agregar</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php 
echo $this->Html->script(array(
	'bootstrap-datepicker',
	'angularjs/controladores/app',
	'angularjs/servicios/solicitudes_rendicion/solicitudesRendicion',
	'angularjs/controladores/solicitudes_rendicion/solicitudes_rendicion',
	'angularjs/directivas/upload_file/upload_documento',
	'select2.min'
	
));
?>


<script>


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

$("#tipo_moneda_id").on("change", function(){
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
			$("#moneda_observada").val(data);
		}
	});

}else{
	$("#valorObserver").text('');
	$("#valorObserver").css('display', 'none')
}
})




$("#dimUno").on("change", function(){
	var valor = $(this).val()
		$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"codigoPresupuestario"))?>",
		    data: {"valor" : valor},
		    async: true,
		    dataType: "json",
			success: function( data ) {
				if(data != "")
				{	
					$("#codigoPresupuestario option").remove();
					$("#codigoPresupuestario").append("<option value=''> </option>");
					$.each(data, function(i, item){
						$("#codigoPresupuestario").append("<option value="+item.Id+">" +item.Nombre+ "</option>");
					});
				}
				else
				{
		
			<?php //echo $this->Form->input('company_id', array("class"=>"requerido proveedor ajuste_select2", "options"=>$proveedores,"label"=>false));?>
					console.log("ENTRO?")
					$("#codigoPresupuestario").select2("data", null)
				}
			}
		});
})


	});
	$("#dimCuatro").select2({
		placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#dimCinco").select2({
		placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#proyecto").select2({
		placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#proveedor").select2({
		placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#codigoPresupuestario").select2({
		placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	
	
	
</script>