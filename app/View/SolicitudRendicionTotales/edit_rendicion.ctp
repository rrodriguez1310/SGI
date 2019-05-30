<div ng-controller="controllerSolicitudesRechazo"  ng-init="carga(<?=$idsolicitud?>)" >
<?php //echo $this->Form->create('SolicitudRendicionTotale', array('type'=>'radio','type'=>'file', 'ng-submit'=>"guardaRendicionSubmit()")); ?>
<form class="form-horizontal"  ng-submit="guardaRendicionSubmit(<?=$idsolicitud?>)" method="post" name="formularioSolicitud" >
<div>
<fieldset>
		<legend><?php echo __('Tipo Documento'); ?></legend>
			<label class="radio-inline">
				<strong><?=$tipoFondo?></strong>
			</label>
</fieldset>
	<fieldset>
        
		<legend>Rendición de fondo</legend>
		<input type="hidden" name="moneda_observada" id="moneda_observada" value="<?=$valorMoneda?>" >
		<input type="hidden" name="folio" id="folio" value="<?=$ndocumento?>" >
		<div class="form-group">
			<label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Fecha Documento</label>
			<div class="col-md-6">
				<?php 
				echo $this->Form->input('fecha_documento', 	
						array("class"=>"col-xs-4 form-control requerido", 
						"type"=>"text",
						"label"=>false,
						"ng-model"=>"guardarRendicion.fecha_documento", 
						'placeholder'=>'Fecha Documento',
					)
				);
				?>
				<label for="fecha_documento"></label>
			</div>
		</div>


		<div class="form-group">
			<label class="col-md-4 control-label baja" >N° de solicitud de fondo</label>
			<div class="col-md-6">
				<?php 
				echo $this->Form->input('solicitud', 
						array("class"=>"col-xs-4 form-control requerido", 
						"label"=>false, 
						"type"=>"text",
						"ng-model"=>"guardarRendicion.solicitud",
						'placeholder'=>'N° de solicitud de fondo',
						'disabled'
					)
				);
				?>
				
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" >Seleccione moneda</label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input('tipo_moneda_id', 
							array("class"=>"tipoMoneda ajuste_select2 form-control", 
							"options"=>$tipoMonedas, 
							"label"=>false, 
							"ng-model"=>"guardarRendicion.tipo_moneda_id",
							"empty"=>"Seleccione moneda",
							"value"=>$idMoneda,
							'disabled'
						)
					);
				?>
				
				<div id="valorObserver" class="alert alert-success esconde" role="alert">...</div>
			</div>
		</div>

			<div class="form-group">
			<label class="col-md-4 control-label baja">Monto Solicitado: </label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input('montoSolis', 
							array("class"=>"col-xs-4 form-control ", 
							"label"=>false, 
							"type"=>"text",
							"ng-model"=>"guardarRendicion.montoSolis",
							'placeholder'=>'Monto',
							'disabled'
						)
					);
				?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Titulo </label>
			<div class="col-md-6">
				<?php 
				echo $this->Form->input('titulo', 
					array("class"=>"col-xs-4 form-control ", 
						"label"=>false, 
                        "type"=>"text",
						"ng-model"=>"guardarRendicion.titulo",
						'placeholder'=>'Titulo',
					)
				);
				?>
				<label for="titulo"></label>
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
	<label for="gridOptions"></label>
	<div><a href="#" ng-click="deleteRow()" class="btn btn-danger" ng-show="eliminarBtnGrilla"><i class="fa fa-trash"></i></a></div>
	<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-edit ui-grid-cellnav class="grid"></div>
	<div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput">Descarga Archivo </label>
		<div class="col-md-6">
		<?php 
			$arrayDoc = explode(",", $url); 
			for($i=0;$i<count($arrayDoc);$i++){
				$arhivo = basename($arrayDoc[$i]);
				echo "<div class='row'>";
					echo "<a href=".acortarurl($arrayDoc[$i])." target='_blank'>$arhivo</a>";
				echo "</div>";
			}
		?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label baja" for="passwordinput">Archivo adjunto : </label>
		<div class="col-md-6">
		<label for="doc"></label>
			<?php 
				echo $this->Form->input('documento', 
					array("type"=>"file", 
						"file-model"=>"documetosRendicion",
						'multiple', 
						"class"=>"requerido", 
						"label"=>false, 
						'placeholder'=>'Adjuntar archivo'
					)
				);
			?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label baja">Observación : </label>
		<div class="col-md-6">
			<?php echo $this->Form->textArea('observacion', 
					array("class"=>"form-control", 
					"label"=>false, 
                    'placeholder'=>'Observacion',
                    "ng-model"=>"guardarRendicion.observacion",
                    
					)
				);
			?>
			<label for="observacion"></label>
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
				<h4> Total: $ {{totalGastos | number:0}}<!--span class="total"><div ng-bind="totalGastos"></div></span--></h4> 

			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn-block btn btn-primary btn-lg generarOrden envio"><i class="fa fa-spinner fa-spin esconde" ></i>
			<i class="fa fa-file-text-o"></i> Generar Rendición de fondos</button>
		</div>
	</div>
</div>
<?php //echo $this->Form->end(); ?>
</form>



<div class="modal fade" id="ingresoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" style="width:800px;">
<form class="form-horizontal" name="myFormulario" ng-submit="submit(<?=$idsolicitud?>)" id="myFormulario">

<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Ingresar detalle fondo por rendir</h4>
	</div>

<div class="modal-body" style="height:400px; overflow-y: scroll !important;">

	<div class="form-group">
		<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Cantidad:</label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input('cantidad', 
					array(
						"class"=>"form-control requerido", 
						"label"=>false, 
						'placeholder'=>'Cantidad',
						"ng-model"=>"rendicion.cantidad",
						)
					);
				?>
			<label for="cantidad"></label>
		</div>
	</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja" >Seleccione proveedor : </label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input('company_id', 
						array(
							"type"=>"select",
							"class"=>"proveedor ajuste_select2 requerido", 
							"options"=>$proveedores,
                            "label"=>false,
							"ng-model"=>"rendicion.company_id",
							"placeholder"=>"Seleccione Proveedor",
                            
						)
					);
				?>
				<label for="company_id"></label>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label baja">N° Folio:</label>
			<div class="col-md-6">
				<?php 
				echo $this->Form->input('n_folio', 
					array(
					"class"=>"form-control requerido", 
					"label"=>false, 
					'placeholder'=>'N° Folio',
					"ng-model"=>"rendicion.n_folio"
					)
				);
				?>
				<label for="n_folio"></label>
			</div>
		</div>
	<div class="form-group">
		<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Producto:</label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input('producto', 
						array("class"=>"form-control requerido", 
						"label"=>false, 
						'placeholder'=>' Producto',
						"ng-model"=>"rendicion.producto",
						
						)
					);
				?>
			<label for="producto"></label>
		</div>
	</div>


	<div class="form-group">
		<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Precio unitario:</label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input('precio', 
						array(
						"class"=>"form-control requerido", 
						"label"=>false, 
						'placeholder'=>'Precio Unitario',
						"ng-model"=>"rendicion.precio",
						"ng-keyup"=>"formatThusanNumber()",
						"ng-change"=>"formatThusanNumber()"
						)
					);
				?>
			<label for="precio"></label>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label baja">Descuento %:</label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input('descuento_producto', 
						array("class"=>"form-control", 
						"label"=>false, 
						'placeholder'=>'Descuento al Producto',
						"ng-model"=>"rendicion.descuento_producto",
						)
					);
				?>
				<label for="descuento_producto"></label>
			</div>
	</div>


	<div class="form-group">
		<label class="col-md-4 control-label baja">Descuento $:</label>
			<div class="col-md-6">
			<?php 
				echo $this->Form->input('descuento_producto_peso', 
					array("class"=>"form-control", 
					"label"=>false, 
					'placeholder'=>'Descuento al Producto',
					"ng-model"=>"rendicion.descuento_producto_peso",
					)
				);
			?>
				<label for="descuento_producto_peso"></label>
			</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label baja">Empaque:</label>
			<div class="col-md-6">
				<?php 
					echo $this->Form->input('empaque', 
							array("class"=>"empaque", 
							"label"=>false, 
							'options'=>$empaques, 
							'placeholder'=>'Tipo de Empaque',
							"ng-model"=>"rendicion.empaque",
							"placeholder"=>"Seleccione Empaque"
						)
					);
				?>
				<label for="empaque"></label>
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
					
				)
			);
		?>
		<label for="gerencia"></label>
	</div>
</div>


<div class="form-group">
	<label class="col-md-4 control-label baja">Estadios: </label>
	<div class="col-md-6">
		<?php 
			echo $this->Form->input('dimDos', 
					array("class"=>"dimencionDos", 
					'options'=>$dimensionDos,
					"ng-model"=>"rendicion.dimDos", 
					"label"=>false, 
					'placeholder'=>'Estadios',
					
				)
			);
		?>
		<label for="estadios"></label>
	</div>
</div>


<div class="form-group">
	<label class="col-md-4 control-label baja" >Contenido: </label>
	<div class="col-md-6">
		<?php 
			echo $this->Form->input('dimTres', 
					array("class"=>"dimencionTres", 
					'options'=>$dimensionTres,
					"ng-model"=>"rendicion.dimTres", 
					"label"=>false, 
					'placeholder'=>'Contenido',
					
				)
			);
		?>
		<label for="contenido"></label>
	</div>
</div>


<div class="form-group">
	<label class="col-md-4 control-label baja" >Canal de distribución: </label>
	<div class="col-md-6">
		<?php 
			echo $this->Form->input('dimCuatro', 
					array("class"=>"dimencionCuatro", 
					'options'=>$dimensionCuatro, 
					"ng-model"=>"rendicion.dimCuatro",
					"label"=>false, 
					'placeholder'=>'Canal de distribución',
					
				)
			);
		?>
		<label for="distribucion"></label>
	</div>
</div>


<div class="form-group">
	<label class="col-md-4 control-label baja" >Otros: </label>
	<div class="col-md-6">
		<?php 
			echo $this->Form->input('dimCinco', 
					array("class"=>"dimencionCinco", 
					'options'=>$dimensionCinco,
					"ng-model"=>"rendicion.dimCinco", 
					"label"=>false, 
					'placeholder'=>'Otros',
					
				)
			);
		?>
		<label for="otros"></label>
	</div>
</div>

	<div class="form-group">
	<label class="col-md-4 control-label baja" >Proyectos: </label>
	<div class="col-md-6">
	<?php 
		echo $this->Form->input('proyecto', 
				array("class"=>"proyectos", 
				'options'=>$proyectos,
				"ng-model"=>"rendicion.proyecto",
				"label"=>false, 
				'placeholder'=>'Proyectos',
				
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
			<button type="submit" class="btn btn-primary agregarProducto" id="agrega">Agregar</button>
			</div>
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
	echo $this->Html->script(array(
		'bootstrap-datepicker',
		'angularjs/controladores/app',
		'angularjs/servicios/solicitudes_rendicion/solicitudesRendicion',
		'angularjs/controladores/solicitudes_rendicion/solicitudes_rendicion_edit_fondo',
		'angularjs/directivas/upload_file/upload_documento',
		'select2.min'
		
	));
?>

<script>
$('.esconde').hide();
$(".envio").on('click', function(event){
	$('.esconde').show();
	//$(".envio").text('Procesando Requerimiento')
})


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
					console.log("ENTRO?")
					$("#codigoPresupuestario").select2("data", null)
				}
			}
		});
})



	$("#dimUno").select2({
		//placeholder: "Seleccione Proveedor",
		allowClear: true,
	});

	$("#dimDos").select2({
		//placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#dimTres").select2({
		//placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#dimCuatro").select2({
		//placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#dimCinco").select2({
		//placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#proyecto").select2({
		//placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#proveedor").select2({
		//placeholder: "Seleccione Proveedor",
		allowClear: true,
	});
	$("#codigoPresupuestario").select2({
		//placeholder: "Seleccione Proveedor",
		allowClear: true,
	});

	$("#company_id").select2({
		//placeholder: "Seleccione Proveedor",
		allowClear: true,
	});

	$("#plazos_pago_id").select2({
		//placeholder: "Seleccione Proveedor",
		allowClear: true,
	});

	$("#empaque").select2({
		//placeholder: "Seleccione Proveedor",
		allowClear: true,
	});

	$("#dimUno").select2('destroy').val('').select2();
    /*$("#dimDos").select2('destroy').val('').select2();
    $("#dimTres").select2('destroy').val('').select2();
    $("#dimCuatro").select2('destroy').val('').select2();
    $("#dimCinco").select2('destroy').val('').select2();
    $("#proyecto").select2('destroy').val('').select2();
    $("#proveedor").select2('destroy').val('').select2();
    $("#empaque").select2('destroy').val('').select2();*/
    $("#codigoPresupuestario").select2('destroy').val('').select2();
	setTimeout(() => {
		$( "#afecto1" ).prop( "checked", true );
	}, 1000);
	 


</script>