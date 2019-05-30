<h3 class="text-center"><?php echo __('Buscar'); ?></h3>
<div class="row">
	<?php echo $this->Form->create('TodosSap'); ?>
		<div class="col-md-6 col-md-offset-3">
			
			<div class="required-field-block">
				<?php echo $this->Form->input('fecha_desde', array("class"=>"form-control fechaInicio", "label"=>false, 'placeholder'=>"Fecha desde"));?>
			</div>

			<div class="required-field-block">
				<?php echo $this->Form->input('fecha_hasta', array("class"=>"form-control fechaFin", "label"=>false, 'placeholder'=>"Fecha hasta"));?>
			</div>

			<div class="required-field-block">
				<?php echo $this->Form->input('palabraClave', array("class"=>"form-control", "label"=>false, 'placeholder'=>"Palabra clave"));?>
			</div>
			<button type="submit" class="btn btn-primary btn-block">Buscar</button>

		</div>
	<?php echo $this->Form->end(); ?>
</div>

<br/>
<br/>

<?php if(isset($filtroOrdenesDeCompra)) : ?>

<h4>Detalle de productos encontrados</h4>
	<table id="datatable" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Cod.Req</th>
				<th>Empresa</th>
				<th>Titulo.</th>
				<th>Fecha</th>
				<th>Total</th>
				<th>Estado</th>
				<th width="110"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($filtroOrdenesDeCompra as $filtroOrdenesDeCompras) : ?>
				<?php
					$class = "";
					if(!empty($filtroOrdenesDeCompras["nombreDocumento"]["id"]))
					{
						$class="success";
						$tooltip =  'class="tool" data-toggle="tooltip" data-placement="top" title="tipo de documento : ' .$filtroOrdenesDeCompras["nombreDocumento"]["nombre"]. '"';
					}
				?>	
				<tr class="<?php echo $class;?>">
				<td>
					<?php
						if(!empty($filtroOrdenesDeCompras["nombreDocumento"]["id"]))
						{
							echo substr($filtroOrdenesDeCompras["nombreDocumento"]["nombre"], 0,3) . '-' .$filtroOrdenesDeCompras["numeroFactura"][0]["numero_documento"] ;	
						}
						else
						{
							echo $filtroOrdenesDeCompras["idOrdenCompra"];
						}
					?>

				</td>
				<td><?php echo $filtroOrdenesDeCompras["nombreEmpresa"]?></td>
				<td><?php echo $filtroOrdenesDeCompras["titulo"]?></td>
				<td><?php echo $filtroOrdenesDeCompras["fecha"]?></td>
				<td><?php echo number_format($filtroOrdenesDeCompras["total"], 0, '', '.')?></td>
				<td>
					<?php
							if($filtroOrdenesDeCompras["estado"] == 1)
							{
								echo '<span class="label label-warning tool" data-toggle="tooltip" data-placement="top" title="Pendiente por aprobar en gerencia"> Pendiente</span>';
							}

							else if($filtroOrdenesDeCompras["estado"] == 2)
							{
								echo '<span class="label label-success tool" data-toggle="tooltip" data-placement="top" title="Aprobado por Gerencia"> Aprobado</span>';	
							}

							else if($filtroOrdenesDeCompras["estado"] == 4)
							{
								echo '<span class="label label-morado tool" data-toggle="tooltip" data-placement="top" title="Ingresado en SAP">Ing. Sap</span>';	
							}

							else if($filtroOrdenesDeCompras["estado"] == 0)
							{
								echo '<span class="label label-default tool" data-toggle="tooltip" data-placement="top" title="Eliminado"> Eliminado</span>';	
							}


							else if($filtroOrdenesDeCompras["estado"] == 3)
							{
								echo '<span class="label label-warning tool" data-toggle="tooltip" data-placement="top" title="'.$ordenCompras["ComprasProductosTotale"]["ComprasProductosRechazo"][0]["motivo"]. '"> Rechazado G</span>';
							}

							else if($filtroOrdenesDeCompras["estado"] == 5)
							{

								echo '<span class="label label-default tool" data-toggle="tooltip" data-placement="top" title="'.$ordenCompras["ComprasProductosRechazo"][0]["motivo"]. '"> Rechazado S</span>';
							}

							else if($filtroOrdenesDeCompras["estado"] == 6)
							{
								echo '<span class="label label-success tool" data-toggle="tooltip" data-placement="top" title="Facturado"> Facturado</span>';
							}
							
							else
							{
								echo '<span class="label label-success tool" data-toggle="tooltip" data-placement="top" title="Terminado"> Terminado</span>';
							}
						?>
				</td>
				<td>
					<a class="btn-sm btn btn-primary tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"view", $filtroOrdenesDeCompras["idOrdenCompra"])); ?>" data-original-title="Ver detalle"><i class="fa fa-eye"></i></a/>

					<?php //if($filtroOrdenesDeCompras["estado"] == 1 || $filtroOrdenesDeCompras["estado"] == 2 || $filtroOrdenesDeCompras["estado"] == 4) :?>
						<a class="btn-sm btn btn-warning tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"plantilla_boletas_facturas_add", $filtroOrdenesDeCompras["idOrdenCompra"])); ?>" data-original-title="Usar plantilla"><i class="fa fa-recycle"></i></a/>
					<?php //endif; ?>

					<?php if($filtroOrdenesDeCompras["estado"] == 4 && $filtroOrdenesDeCompras["numeroFactura"][0]["numero_documento"] == "") : ?>
						<a class="btn-sm btn btn-info tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"asociar_facturas", $filtroOrdenesDeCompras["idOrdenCompra"])); ?>" data-original-title="Ingresar documento"><i class="fa fa-file-text"></i></a/>
					<?php endif; ?>


				</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
</table>
<?php endif; ?>
<?php echo $this->Html->script(array('bootstrap-datepicker'));?>

<script type="text/javascript">
    $(document).ready(function() {
    	
    	var fechaInicio = "";
        var fechaFin = "";

        $("#TodosSapFechaDesde").change(function(){
	  		fechaInicioSplit = $(this).val().split("/");
	  		fechaInicio = fechaInicioSplit[2]+'/'+fechaInicioSplit[1]+'/'+fechaInicioSplit[0];


	  		
	  		if(fechaInicio != "" && fechaFin != "")
	  		{

	  			if(Date.parse(fechaInicio) > Date.parse(fechaFin))
	  			{
	  				alert("La fecha desde es mayor que la fecha hasta");
	  				$(this).val("");
	  				return false;
	  			}
	  		}
        })

        $("#TodosSapFechaHasta").change(function(){
        	fechaFinSplit = $(this).val().split("/");
	  		fechaFin = fechaFinSplit[2]+'/'+fechaFinSplit[1]+'/'+fechaFinSplit[0];

	  		if(fechaInicio != "" && fechaFin != "")
	  		{
	  			if(Date.parse(fechaInicio) > Date.parse(fechaFin))
	  			{
	  				alert("La fecha desde es mayor que la fecha hasta");
	  				$(this).val("");
	  				return false;
	  			}
	  		}
        })

       


    	$('.fechaInicio').datepicker({

		    format: "yyyy/mm/dd",
		    daysOfWeekDisabled: "0, 6",
		    startView: 1,
		    language: "es",
		    multidate: false,
		    autoclose: true,
		    required: true,
	    });

	    $('#TodosSapFechaHasta').datepicker({
		    format: "yyyy/mm/dd",
		    //startDate: fechaInicio[2]+ '-'+fechaInicio[1]+'-'+fechaInicio[0],
		    //daysOfWeekDisabled: "0, 6",
		    //startView: 1,
		    //language: "es",
		    //multidate: false,
		    //autoclose: true,
		    //required: true,
	    });
    	$('.tool').tooltip();
    	
        $('#datatable').dataTable( {
            "sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
				"sLengthMenu": "Display _MENU_ records per page",
				"sZeroRecords": "Nothing found - sorry",
				"sInfo": "",
				"sInfoEmpty": "Showing 0 to 0 of 0 records",
				"sInfoFiltered": "(encontrados _MAX_ registros)",
				"sSearch": "Buscar:",
				"oPaginate": {
					"sFirst":    "Primero",
					"sPrevious": "« ",
					"sNext":     " »",
					"sLast":     "Último"
				}
			},
			"iDisplayLength": 25,

        } );


    } );
</script>