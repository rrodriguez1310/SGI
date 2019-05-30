<?php echo $this->Form->create('SolicitudesRequerimiento', array('type'=>'radio')); ?>

	<div>
    <fieldset>
			<legend><?php echo __('Tipo Documento'); ?></legend>
				<label class="radio-inline">
					<input type="radio" name="tipo_fondo" value="1"><strong>Fondo por rendir</strong>
				</label>
				<label class="radio-inline">
					<input type="radio" name="tipo_fondo" value="2"><strong>Fondo fijo</strong>
				</label>
	</fieldset>
		<fieldset>
			<legend>Rendición de fondo</legend>
			<div class="form-group">
				<label class="col-md-4 control-label baja" for="fecha_documento"><span class="aterisco">*</span>Fecha Documento</label>
				<div class="col-md-6">
                    <?php 
                    echo $this->Form->input('fecha_documento', 
                    array("class"=>"col-xs-4 form-control requerido", 
                    "type"=>"text",
                    "label"=>false, 
                    'placeholder'=>'Fecha Documento'));
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
                    'placeholder'=>'N° de solicitud de fondo'));
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
                    'requiered'=>true));
                    ?>
                    <div id="valorObserver" class="alert alert-success esconde" role="alert">...</div>
				</div>
			</div>

            	<div class="form-group">
				<label class="col-md-4 control-label baja" for="monto"><span class="aterisco">*</span>Monto Solicitado: </label>
				<div class="col-md-6">
                    <?php 
                    echo $this->Form->input('monto', 
                    array("class"=>"col-xs-4 form-control ", 
                    "label"=>false, 
                    'placeholder'=>'titulo' , 
                    "type"=>"text",
                    'placeholder'=>'Monto'));
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
                    'placeholder'=>'titulo'));
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
			<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisc$('#fecha_termino').datepicker({
    format: "yyyy-mm-dd",
    //startView: 1,
    language: "es",
    multidate: false,
   // daysOfWeekDisabled: "0, 6",
    autoclose: true,
   viewMode: "week",
   Default: false
});o">*</span>Tipo de impuesto : </label>
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
				<?php echo $this->Form->textArea('observacion', array("class"=>"form-control", "label"=>false, 'placeholder'=>'Observacion'));?>
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
					<h4> Total: $ <span class="total"> </span></h4> 
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button type="submit" class="btn-block btn disabled btn-primary btn-lg generarOrden"><i class="fa fa-file-text-o"></i> Generar rendición de fondos</button>
			</div>
		</div>
	</div>
    <?php echo $this->Form->end(); ?>
<div class="modal fade" id="ingresoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:800px;">

		<form id="formProducto" role="form"  method="Post" action="<?php echo $this->Html->url(array("controller" => "servicios","action" => "compraUnitario"))?>">
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
								<label class="col-md-4 control-label baja" for="passwordinput"><span class="aterisco">*</span>Descripción: </label>
								<div class="col-md-6">
                                        <?php echo $this->Form->input('descripcion', 
                                            array("class"=>"form-control requerido", 
                                                    "label"=>false, 
                                                    'placeholder'=>' Descripción'));
                                        ?>
                                </div>
                        </div>


                         <div class="form-group">
								<label class="col-md-4 control-label baja" for="monto"><span class="aterisco">*</span>Monto: </label>
								<div class="col-md-6">
                                    <?php 
                                        echo $this->Form->input('monto', 
                                        array("class"=>"form-control requerido", 
                                        "label"=>false, 
                                        'placeholder'=>'Monto'));
                                    ?>
                                </div>
                        </div>


                         <div class="form-group">
								<label class="col-md-4 control-label baja" for="proveedor"><span class="aterisco">*</span>Proveedor: </label>
								<div class="col-md-6">
                                    <?php 
                                        echo $this->Form->input('dimTres', 
                                        array("class"=>"proveedor", 
                                        'options'=>$dimensionTres, 
                                        "label"=>false, 
                                        'placeholder'=>'Contenido'));
                                    ?>
                                </div>
                        </div>


                         <div class="form-group">
								<label class="col-md-4 control-label baja" for="folio"><span class="aterisco">*</span>N° Folio: </label>
								<div class="col-md-6">
                                    <?php 
                                        echo $this->Form->input('folio', 
                                        array("class"=>"form-control", 
                                        "label"=>false, 
                                        'placeholder'=>'N° de Folio'));
                                    ?>
                                </div>
                        </div>


                         <div class="form-group">
								<label class="col-md-4 control-label baja" for="gerencia"><span class="aterisco">*</span>Gerencias: </label>
								<div class="col-md-6">
                                    <?php 
                                        echo $this->Form->input('dimUno', 
                                        array("class"=>"dimencionUno requerido", 
                                        "label"=>false, 'options'=>$dimensionUno, 
                                        'placeholder'=>'Gerencias'));
                                    ?>
                                </div>
                        </div>


                         <div class="form-group">
								<label class="col-md-4 control-label baja" for="estadios"><span class="aterisco">*</span>Estadios: </label>
								<div class="col-md-6">
                                    <?php 
                                        echo $this->Form->input('dimDos', 
                                        array("class"=>"dimencionDos", 
                                        'options'=>$dimensionDos, 
                                        "label"=>false, 
                                        'placeholder'=>'Estadios'));
                                    ?>
                                </div>
                        </div>


                         <div class="form-group">
								<label class="col-md-4 control-label baja" for="contenido"><span class="aterisco">*</span>Contenido: </label>
								<div class="col-md-6">
                                    <?php 
                                        echo $this->Form->input('dimTres', 
                                        array("class"=>"dimencionTres", 
                                        'options'=>$dimensionTres, 
                                        "label"=>false, 
                                        'placeholder'=>'Contenido'));
                                    ?>
                                </div>
                        </div>


                         <div class="form-group">
								<label class="col-md-4 control-label baja" for="distribucion"><span class="aterisco">*</span>Canal de distribución: </label>
								<div class="col-md-6">
                                    <?php 
                                        echo $this->Form->input('dimCuatro', 
                                        array("class"=>"dimencionCuatro", 
                                        'options'=>$dimensionCuatro, 
                                        "label"=>false, 
                                        'placeholder'=>'Canal de distribución'));
                                    ?>
                                </div>
                        </div>


                         <div class="form-group">
								<label class="col-md-4 control-label baja" for="otros"><span class="aterisco">*</span>Otros: </label>
								<div class="col-md-6">
                                    <?php 
                                        echo $this->Form->input('dimCinco', 
                                            array("class"=>"dimencionCinco", 
                                            'options'=>$dimensionCinco, 
                                            "label"=>false, 
                                            'placeholder'=>'Otros'));
                                    ?>
                                </div>
                        </div>

                             <div class="form-group">
								<label class="col-md-4 control-label baja" for="proyectos"><span class="aterisco">*</span>Proyectos: </label>
								<div class="col-md-6">
                                <?php 
                                    echo $this->Form->input('proyecto', 
                                    array("class"=>"proyectos", 
                                    'options'=>$proyectos, 
                                    "label"=>false, 
                                    'placeholder'=>'Proyectos'));
                                ?>
                                </div>
                        </div>


                         <div class="form-group">
								<label class="col-md-4 control-label baja" for="presupuestos"><span class="aterisco">*</span>Códigos presupuestarios: </label>
								<div class="col-md-6">
                                <?php  
                                    echo $this->Form->input('codigoPresupuestario', 
                                    array("type"=>"select", 
                                    "options" =>array(""=>""), 
                                    "class"=>"codigoPresupuestario requerido requerido", 
                                    "label"=>false, 
                                    'placeholder'=>'Codigo Presupuestario'));
                                ?>
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


<?php 
    echo $this->Html->script(array(
        'bootstrap-datepicker'
    ));
?>
<script>

    $('#SolicitudesRequerimientoFechaDocumento').datepicker({
        format: "yyyy-mm-dd",
        //startView: 1,
        language: "es",
        multidate: false,
        // daysOfWeekDisabled: "0, 6",
        autoclose: true,
        viewMode: "week",
        Default: false
    });

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



    $("#SolicitudesRequerimientoTipoMonedaId").on("change", function(){
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
		

</script>