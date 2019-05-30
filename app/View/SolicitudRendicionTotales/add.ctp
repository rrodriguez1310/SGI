<div ng-controller="controllerSolicitudes" >


<?php //echo $this->Form->create('SolicitudRendicionTotale', array('type'=>'radio','type'=>'file', 'ng-submit'=>"guardaRendicionSubmit()")); ?>
<form class="form-horizontal"  ng-submit="guardaRendicionSubmit()" method="post" name="formularioSolicitud" >
<div>
<fieldset>
		<legend><?php echo __('Tipo Documento'); ?></legend>
			<label class="radio-inline">
				<input type="radio" name="tipo_fondo" value="1" ng-model="guardarRendicion.tipo_fondo1" required><strong>Fondo por rendir</strong>
			</label>
			<label class="radio-inline">
				<input type="radio" name="tipo_fondo" value="2" ng-model="guardarRendicion.tipo_fondo2" required><strong>Fondo fijo</strong>
			</label>
</fieldset>
	<fieldset>
		<legend>Rendición de fondo</legend>


		<input type="hidden" name="moneda_observada" id="moneda_observada"  >


		<div class="form-group">
			<label class="col-md-4 control-label baja" for="fecha_documento"><span class="aterisco">*</span>Fecha Documento</label>
			<div class="col-md-6">
				<?php 
				echo $this->Form->input('fecha_documento', 	
				array("class"=>"col-xs-4 form-control requerido", 
				"type"=>"text",
				"label"=>false,
				"ng-model"=>"guardarRendicion.fecha_documento", 
				'placeholder'=>'Fecha Documento',
				'required'=>true
					)
				);
				?>
			</div>
		</div>


		<div class="form-group">
			<label class="col-md-4 control-label baja" for="solicitud">N° de solicitud de fondo</label>
			<div class="col-md-6">
				<?php 
				echo $this->Form->input('solicitud', 
				array("class"=>"col-xs-4 form-control requerido", 
				"label"=>false, 
				"type"=>"text",
				"ng-model"=>"guardarRendicion.solicitud",
				'placeholder'=>'N° de solicitud de fondo',
				'required'=>true
					)
				);
				?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" for="tipo_moneda_id">Seleccione moneda</label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input('tipo_moneda_id', 
						array("class"=>"tipoMoneda ajuste_select2 form-control", 
						"options"=>$tipoMonedas, 
						"label"=>false, 
						"ng-model"=>"guardarRendicion.tipo_moneda_id",
						'requiered'=>true
				));
				?>
				<div id="valorObserver" class="alert alert-success esconde" role="alert">...</div>
			</div>
		</div>

			<div class="form-group">
			<label class="col-md-4 control-label baja" for="montoSolis"><span class="aterisco">*</span>Monto Solicitado: </label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input('montoSolis', 
						array("class"=>"col-xs-4 form-control ", 
						"label"=>false, 
						'placeholder'=>'titulo' , 
						"type"=>"text",
						"ng-model"=>"guardarRendicion.montoSolis",
						'placeholder'=>'Monto',
						'required'=>true
					)
				);
				?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" for="titulo"><span class="aterisco">*</span>Titulo </label>
			<div class="col-md-6">
				<?php 
				echo $this->Form->input('titulo', 
				array("class"=>"col-xs-4 form-control ", 
				"label"=>false, 
				"type"=>"text",
				"ng-model"=>"guardarRendicion.titulo",
				'placeholder'=>'Titulo',
				'required'=>true
			)
		);
				?>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button type="button" class="btn-block btn btn-success btn-lg" data-toggle="modal" data-target="#ingresoProducto">
				<i class="fa fa-shopping-cart"></i> Ingresar gastos</button>
			</div>
		</div>
	</fieldset>

	<legend>Detalle de gastos ingresados</legend>
	<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-edit ui-grid-cellnav class="grid"></div>
	<div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Archivo adjunto : </label>
		<div class="col-md-6">
		<input type="file" file-model="documetosRendicion" name:"documento"/>
			<?php /*echo $this->Form->input('adjunto', 
						array("type"=>"file", 
						'multiple', 
						"class"=>"requerido", 
						"label"=>false, 
						'placeholder'=>'Adjuntar archivo',
						"fileModel"=>"documentoAdjunto"
						)
					);*/
					?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput">Observación : </label>
		<div class="col-md-6">
			<?php echo $this->Form->textArea('observacion', 
					array("class"=>"form-control", 
					"label"=>false, 
					'placeholder'=>'Observacion',
					"ng-model"=>"guardarRendicion.observacion"
					)
				);
				?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<div class="alert alert-info">
				<!--h4> Neto Afecto s/d: <span class="neto_sd"> </span></h4>
				<h4> Neto Exento s/d: </span> <span class="totalExento hidden"> </span></h4>
				<?php //echo $this->Form->hidden('neto_descuento');?>
				<h4> Descuentos: $ <span class="totalDescuentos"> </span></h4>
				<h4> Neto Total c/d: $ <span class="netoCd"> </span></h4>
				<h4> <span class="textoIva">Impuesto : </span><span class="iva"> </span></h4-->
				<h4> Total: $ {{total | number:0}}<!--span class="total"><div ng-bind="totalGastos"></div></span--></h4> 

			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn-block btn btn-primary btn-lg generarOrden">
			<i class="fa fa-file-text-o"></i> Generar Requerimiento de viático</button>
		</div>
	</div>
</div>
<?php //echo $this->Form->end(); ?>
</form>




<div class="modal fade" id="ingresoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" style="width:800px;">
	<form class="form-horizontal" name="myFormulario" ng-submit="submit()" id="myFormulario">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Ingresar detalle fondo por rendir</h4>
			</div>

								


			<div class="modal-body" style="height:400px; overflow-y: scroll !important;">
					<!--div class="form-group">
						<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Tipo de impuesto : </label>
						<div class="col-md-6">
							<label class="radio-inline baja"><input type="radio" name="afecto" id="afecto1" value="1" checked class="requerido">Afecto (19%)</label>
							<label class="radio-inline baja"><input type="radio" name="afecto" id="afecto2" value="2" class="requerido">Exento (0%)</label>
						</div>
					</div-->

					<div class="form-group">
					<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Descripción:</label>
							<div class="col-md-6">
									<?php echo $this->Form->input('descripcion', 
										array("class"=>"form-control requerido", 
												"label"=>false, 
												"ng-model"=>"rendicion.descripcion",
												'placeholder'=>' Descripción',
												'required'=>true
											)
										);
									?>
									<label for="descripcion"></label>
							</div>
							
					</div>


					 <div class="form-group">
							<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Monto: </label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('monto', 
									array("class"=>"form-control requerido", 
									"label"=>false, 
									"ng-model"=>"rendicion.monto",
									'placeholder'=>'Monto',
									'ng-blur'=>'numeros(this)',
									'ng-change'=>'numeros(this)',
									'required'=>true
										)
									);
								?>
								<label for="montos"></label>
							</div>
							
					</div>


					 <div class="form-group">
							<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Proveedor: </label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('proveedor', 
									array("class"=>"proveedor", 
									'type'=>'select',
									'options'=>$proveedores, 
									"label"=>false, 
									"ng-model"=>"rendicion.proveedor",
									'placeholder'=>'Proveedor',
									'required'=>true
								)
							);
								?>
								<label for="proveedor"></label>
							</div>
							
					</div>


					 <div class="form-group">
							<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>N° Folio: </label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('folio', 
									array("class"=>"form-control", 
									"label"=>false, 
									"ng-model"=>"rendicion.folio",
									'placeholder'=>'N° de Folio',
									'required'=>true
								)
							);
								?>
								<label for="folio"></label>
							</div>
					</div>


					 <div class="form-group">
							<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Gerencias: </label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('dimUno', 
									array("class"=>"dimencionUno requerido", 
									"label"=>false, 
									'options'=>$dimensionUno, 
									"ng-model"=>"rendicion.dimUno",
									'placeholder'=>'Gerencias',
									'required'=>true
								)
							);
								?>
								<label for="gerencia"></label>
							</div>
					</div>


					 <div class="form-group">
							<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Estadios: </label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('dimDos', 
									array("class"=>"dimencionDos", 
									'options'=>$dimensionDos,
									"ng-model"=>"rendicion.dimDos", 
									"label"=>false, 
									'placeholder'=>'Estadios',
									'required'=>true
								)
							);
								?>
								<label for="estadios"></label>
							</div>
					</div>


					 <div class="form-group">
							<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Contenido: </label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('dimTres', 
									array("class"=>"dimencionTres", 
									'options'=>$dimensionTres,
									"ng-model"=>"rendicion.dimTres", 
									"label"=>false, 
									'placeholder'=>'Contenido',
									'required'=>true
								)
							);
								?>
								<label for="contenido"></label>
							</div>
					</div>


					 <div class="form-group">
							<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Canal de distribución: </label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('dimCuatro', 
									array("class"=>"dimencionCuatro", 
									'options'=>$dimensionCuatro, 
									"ng-model"=>"rendicion.dimCuatro",
									"label"=>false, 
									'placeholder'=>'Canal de distribución',
									'required'=>true
								)
							);
								?>
								<label for="distribucion"></label>
							</div>
					</div>


					 <div class="form-group">
							<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Otros: </label>
							<div class="col-md-6">
								<?php 
									echo $this->Form->input('dimCinco', 
										array("class"=>"dimencionCinco", 
										'options'=>$dimensionCinco,
										"ng-model"=>"rendicion.dimCinco", 
										"label"=>false, 
										'placeholder'=>'Otros',
										'required'=>true
									)
								);
								?>
								<label for="otros"></label>
							</div>
					</div>

						 <div class="form-group">
							<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Proyectos: </label>
							<div class="col-md-6">
							<?php 
								echo $this->Form->input('proyecto', 
								array("class"=>"proyectos", 
								'options'=>$proyectos,
								"ng-model"=>"rendicion.proyecto",
								"label"=>false, 
								'placeholder'=>'Proyectos',
								'required'=>true
							)
						);
							?>
							<label for="proyectos"></label>
							</div>
					</div>

					 <div class="form-group">
							<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Códigos presupuestarios: </label>
							<div class="col-md-6">
							<?php  
								echo $this->Form->input('codigoPresupuestario', 
								array("type"=>"select", 
								"options" =>array(""=>""), 
								"ng-model"=>"rendicion.codigoPresupuestario",
								"class"=>"codigoPresupuestario", 
								"label"=>false, 
								'placeholder'=>'Codigo Presupuestario',
								//'required'=>true
							)
						);
							?>
							<label for="presupuestos"></label>
							</div>
					</div>
	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary agregarProducto" >Agregar</button>
			</div>
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


	$("#dimUno").select2({
		placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#dimDos").select2({
		placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#dimTres").select2({
		placeholder: "Seleccione Proveedor",
		allowClear: true,
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

