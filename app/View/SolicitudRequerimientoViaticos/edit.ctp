<div ng-controller="controllerSolicitudesViaticosEdit" ng-init="carga(<?=$id?>)">
<form class="form-horizontal" method="post" id="formularioSolicitud" role="form" ng-submit="guardaRendicionSubmit(<?=$id?>)" name="formularioSolicitud">
<input type="hidden" name="moneda_observada" id="moneda_observada" value="<?=$valorMoneda?>" >
	<div>
		<fieldset>
			<legend>Requerimiento de viáticoddddd</legend>
			<div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Fecha de Inicio </label>
				<div class="col-md-6">
					<?php 
						echo $this->Form->input('fecha_inicio', 
						array(	"class"=>"col-xs-4 form-control requerido", 
						        "ng-model"=>"guardarRendicion.fecha_inicio",  
								"label"=>false, 
								'placeholder'=>'Fecha Inicio'
							)
						);
					?>
					<label for="fecha_inicio"></label>
				</div>
			</div>

            <div class="form-group">

				<div class="control">
					<label class="col-md-4 control-label baja" for="appt-time">Hora de inicio </label>
					<div class="col-md-6">
					<div class="input">
						<input type="text" 
								class="form-control readonly-pointer-background clockpicker" 
								name="hora_inicio" 
								id="hora_inicio" 
								ng-model="guardarRendicion.hora_inicio" 
								
								placeholder="Seleccione hora inicio" />	
					</div>
					</div>	
						<?php 
						/*	echo $this->Form->input('fecha_inicio', 
								array(
									"type"=>"time",
									"class"=>"form-control requerido",
									"ng-model"=>"guardarRendicion.fecha_inicio", 
									//"label"=>false,
									"min"=>"9:00",
									"max"=>"18:00"
								)
							);*/
						?>
				</div>
			
				<!--label class="col-md-4 control-label baja" for="passwordinput">Hora de inicio </label>
				<div class="col-md-6">
					
				</div-->
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Fecha de Termino </label>
				<div class="col-md-6">
					<?php 
						echo $this->Form->input('fecha_termino', 
						array(	"class"=>"col-xs-4 form-control requerido", 
						        "ng-model"=>"guardarRendicion.fecha_termino",
								"label"=>false, 
								'placeholder'=>'Fecha Termino',
							)
						);
					?>
					<label for="fecha_termino"></label>
				</div>
			</div>

            <div class="form-group">
			<div class="control">
					<label class="col-md-4 control-label baja" for="appt-time">Hora de termino </label>
				<div class="col-md-6">
					<div class="input">
						<input type="text" 
							   class="form-control readonly-pointer-background clockpicker" 
							   name="hora_termino" 
							   id="hora_termino" 
							   ng-model="guardarRendicion.hora_termino"
							  
							   placeholder="Seleccione hora termino" />
					</div>
					</div>
					<?php 
					/*echo $this->Form->input('fecha_termino', 
						array(
							"class"=>"col-xs-4 form-control requerido",
							"ng-model"=>"guardarRendicion.fecha_termino", 
							"label"=>false, 
							'placeholder'=>'Fecha término'
						)
					);*/
					?>
				</div>	
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Responsable</label>
				<div class="col-md-6">
					<?php 
					echo $this->Form->input('responsable', 
						array(
							"class"=>"col-xs-4 form-control requerido",
							"ng-model"=>"guardarRendicion.responsable", 
							"label"=>false, 
							'placeholder'=>'Responsable'
						)
					);
					?>
					<label for="responsable"></label>
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
							"ng-model"=>"guardarRendicion.tipo_moneda_id", 
							"value"=>$idMoneda,
							"label"=>false
							
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
						"ng-model"=>"guardarRendicion.titulo", 
						"label"=>false, 
						'placeholder'=>'titulo'
						)
					);
					?>

					<label for="titulo"></label>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button type="button" class="btn-block btn btn-success btn-lg" data-toggle="modal" data-target="#ingresoProducto"><i class="fa fa-shopping-cart"></i> Ingresar viático</button>
				</div>
			</div>
		</fieldset>

		<legend>Detalle de viáticos ingresados</legend>
		<div><a href="#" ng-click="deleteRow()" class="btn btn-danger" ng-show="eliminarBtnGrilla"><i class="fa fa-trash"></i></a></div>
		<label for="gridOptions"></label>
			<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-edit ui-grid-cellnav class="grid"></div>
		<h4 class="text-right monedaOriginal esconde" >Total en moneda original: <span class="valorMonedaOriginal"></span></h4>

		<div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput">Descarga Archivo </label>
		<div class="col-md-6">
		<?php 
			$arrayDoc = explode(",", $datos); 
			for($i=0;$i<count($arrayDoc);$i++){
				$arhivo = basename($arrayDoc[$i]);
				if($arhivo!=''){

					echo "<div class='row'>";
						echo "<a href=".acortarurl($arrayDoc[$i])." target='_blank'>$arhivo</a>";
					echo "</div>";
				}
			}
		?>
		</div>
	</div>
		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput">Archivo adjunto : </label>
			<div class="col-md-6">
			<?php echo $this->Form->input('documento', array("type"=>"file", "file-model"=>"documetosRendicion",'multiple', "class"=>"requerido", "label"=>false, 'placeholder'=>'Adjuntar archivo'));?>
			<small class="label label-info">Utilice la tecla Ctrl para adjuntar mas de un archivo</small>
				<?php 
				/*echo $this->Form->input('adjunto.', 
					array(
						"type"=>"file", 
						'multiple', 
						"class"=>"requerido", 
						"label"=>false, 
						'placeholder'=>'Adjuntar archivo'
						)
					);*/
				?>
				
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" for="passwordinput">Observación : </label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->textArea('observacion', 
						array("class"=>"form-control", 
						"label"=>false, 
						'placeholder'=>'Observacion',
						"ng-model"=>"guardarRendicion.observacion"
						)
					);
				?>
			</div>
		</div>
		<?php echo $this->Form->hidden('total');?>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<div class="alert alert-info">
					<!--h4> Neto Afecto s/d: <span class="neto_sd"> </span></h4>
					<h4> Neto Exento s/d: </span> <span class="totalExento hidden"> </span></h4>
					<?php //echo $this->Form->hidden('neto_descuento');?>
					<h4> Descuentos: $ <span class="totalDescuentos"> </span></h4>
					<h4> Neto Total c/d: $ <span class="netoCd"> </span></h4>
					<h4> <span class="textoIva">Impuesto : </span><span class="iva"> </span></h4-->
					<h4> Total: $ {{totalGastos | number:0}}<!--span class="total"><div ng-bind="totalGastos"></div></span--></h4> 

				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button type="submit" class="btn-block btn btn-primary btn-lg generarOrden"><i class="fa fa-file-text-o"></i> Generar Requerimiento de viático</button>
			</div>
		</div>
	</div>
</form>
<div class="modal fade" id="ingresoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:800px;">

		<form class="form-horizontal" name="myFormulario" ng-submit="submit(<?=$id?>)" id="myFormulario" novalidate>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Ingresar detalle Viatico</h4>
				</div>


				<div class="modal-body" style="height:400px; overflow-y: scroll !important;">
				<div class="form-group">
					<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Descripción:</label>
							<div class="col-md-6">
							<?php 
									echo $this->Form->input('descripcion', 
										array("class"=>"form-control requerido", 
										"label"=>false, 
										'placeholder'=>'Descripcion',
										"ng-model"=>"rendicion.descripcion",
										"required"
										)
									);
								?>
									<label for="descripcion"></label>
							</div>
							
					</div>

					<div class="form-group">
					<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Colaborador:</label>
							<div class="col-md-6">
							<?php 
									echo $this->Form->input('colaborador', 
										array(
											"class"=>"form-control requerido", 
											"label"=>false, 
											'placeholder'=>'Colaborador',
											"ng-model"=>"rendicion.colaborador",
											"required"
										)
									);
									?>
									<label for="colaborador"></label>
							</div>
							
					</div>

					<div class="form-group">
					<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Monto:</label>
							<div class="col-md-6">
							<?php 
									echo $this->Form->input('monto', 
										array(
											"class"=>"form-control requerido", 
											"label"=>false, 
											'placeholder'=>'Monto',
											"ng-model"=>"rendicion.monto",
											"ng-keyup"=>"formatThusanNumber()",
											"ng-change"=>"formatThusanNumber()",
											"required"
										)
									);
									?>
									<label for="colaborador"></label>
							</div>
							
					</div>

					<div class="form-group">
					<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Gerencias:</label>
							<div class="col-md-6">
							<?php 
								echo $this->Form->input('dimUno', 
									array(
										"class"=>"form-control requerido", 
										"label"=>false, 
										'options'=>$dimensionUno, 
										'placeholder'=>'Selecione Gerencias',
										"ng-model"=>"rendicion.dimUno",
										"required"
									)
								);
								?>
									<label for="gerencia"></label>
							</div>
							
					</div>

					<div class="form-group">
					<label class="col-md-4 control-label baja">Estadios:</label>
							<div class="col-md-6">
							<?php 
								echo $this->Form->input('dimDos', 
									array(
										"class"=>"form-control", 
										'options'=>$dimensionDos, 
										"label"=>false, 
										'placeholder'=>'Seleccione Estadios',
										"ng-model"=>"rendicion.dimDos"
									)
								);
								?>
									
							</div>
							
					</div>

					<div class="form-group">
					<label class="col-md-4 control-label baja">Contenido:</label>
							<div class="col-md-6">
							<?php 
								echo $this->Form->input('dimTres', 
									array(
										"class"=>"form-control", 
										'options'=>$dimensionTres, 
										"label"=>false, 
										'placeholder'=>'seleccione Contenido',
										"ng-model"=>"rendicion.dimTres"
									)
								);
								?>

							</div>
							
					</div>

					<div class="form-group">
					<label class="col-md-4 control-label baja">Canal de distribución:</label>
							<div class="col-md-6">
							<?php 
									echo $this->Form->input('dimCuatro', 
										array(
											"class"=>"form-control", 
											'options'=>$dimensionCuatro, 
											"label"=>false, 
											'placeholder'=>'seleccione Canal de distribución',
											"ng-model"=>"rendicion.dimCuatro"
										)
									);
								?>

							</div>
							
					</div>

					<div class="form-group">
					<label class="col-md-4 control-label baja">Otros:</label>
							<div class="col-md-6">
							<?php 
									echo $this->Form->input('dimCinco', 
										array(
											"class"=>"form-control", 
											'options'=>$dimensionCinco, 
											"label"=>false, 
											'placeholder'=>'Seleccione Otros',
											"ng-model"=>"rendicion.dimCinco"
										)
									);
								?>
	
							</div>
							
					</div>
		
					<div class="form-group">
					<label class="col-md-4 control-label baja">Proyectos:</label>
							<div class="col-md-6">
							<?php 
									echo $this->Form->input('proyecto', 
										array(
											"class"=>"form-control", 
											'options'=>$proyectos, 
											"label"=>false, 
											'placeholder'=>'Seleccione Proyectos',
											"ng-model"=>"rendicion.proyecto"
										)
									);
								?>
	
							</div>
					</div>

					<div class="form-group">
					<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Códigos predupuestarios:</label>
							<div class="col-md-6">
							<?php 
								echo $this->Form->input('codigoPresupuestario', 
									array(
										"type"=>"select", 
										"options" =>array(""=>""), 
										"class"=>"form-control requerido requerido",
										"label"=>false, 
										'placeholder'=>'Seleccione Código Presupuestario',
										"ng-model"=>"rendicion.codigoPresupuestario",
										"required"
									)
								);
								?>
							<label for="codigoPresupuestario"></label>
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
</div>
<?php 
function acortarurl($url){
	$uris = explode("html", $url);
	return $uris[1];
}
       
echo $this->Html->css("bootstrap-clockpicker.min");
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/solicitudes_rendicion_viaticos/solicitudesRendicionViaticos',
		'angularjs/controladores/solicitudes_rendicion_viaticos/editSolicitudesRendiconViaticos',
		'angularjs/directivas/upload_file/upload_documento',
		'select2.min',
		'bootstrap-datepicker',
		"bootstrap-clockpicker.min"
		
	));
?>


<script>
$(".clockpicker").clockpicker({
        placement: 'bottom',
        align: 'top',
        autoclose: true
    });

$('#fecha_inicio').datepicker({
	format: "yyyy-mm-dd",
	//startView: 1,
	language: "es",
	multidate: false,
	// daysOfWeekDisabled: "0, 6",
	autoclose: true,
	viewMode: "week",
	Default: false
});

$('#fecha_termino').datepicker({
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
		    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"codigoPresupuestarioCompraTarjeta"))?>",
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
