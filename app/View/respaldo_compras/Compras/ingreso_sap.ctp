<h4>Lista de requerimiento de compras</h4>
<table id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Cod.Req</th>
			<!--th>Cod.Prod</th-->
			<th>Empresa</th>
			<th>Titulo.</th>
			<th>Fecha</th>
			<th>Total</th>
			<th>Estado</th>
			<th width="110"></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($ordenCompra as $key=>$ordenCompras) : ?>
		<?php
			$class="";
			$tooltip = "";
			if(!empty($ordenCompras["TiposDocumento"]["nombre"]))
			{

				$class = "success";
				$tooltip =  'class="tool" data-toggle="tooltip" data-placement="top" title="tipo de documento : ' .$ordenCompras["TiposDocumento"]["nombre"]. '"';
			}
		?>
		<?php //if($ordenCompras["ComprasProductosTotale"]["estado"] != 0) : ?>
			<tr class="<?php echo $class ; ?>">
				<td>
					<?php if($class != "") : ?>

						<a href="#" <?php echo $tooltip?>> 

							<?php echo substr($ordenCompras["TiposDocumento"]["nombre"], 0,3); ?>-<?php if(isset($ordenCompras["ComprasFactura"][0]["numero_documento"])){echo $ordenCompras["ComprasFactura"][0]["numero_documento"];}?></a>
					<?php else : ?>
						<?php echo $ordenCompras["ComprasProductosTotale"]["id"]; ?>
					<?php endif; ?>
				</td>
				<!--td></td-->
				<td><?php echo $ordenCompras["Company"]["nombre"]?></td>
				<td><?php echo $ordenCompras["ComprasProductosTotale"]["titulo"]; ?></td>
				<td><?php echo date('d-m-Y', strtotime($ordenCompras["ComprasProductosTotale"]["created"]));?></td>
				<td><?php echo number_format($ordenCompras["ComprasProductosTotale"]["total"], 0, '', '.');?></td>
				<td>
					<?php
						if($ordenCompras["ComprasProductosTotale"]["estado"] == 1)
						{
							echo '<span class="label label-danger tool" data-toggle="tooltip" data-placement="top" title="Pendiente por aprobar en gerencia"> Pendiente</span>';
						}
						
						else if($ordenCompras["ComprasProductosTotale"]["estado"] == 2)
						{
							echo '<span class="label label-warning tool" data-toggle="tooltip" data-placement="top" title="Aprobado por Gerencia"> Aprobado</span>';	
						}

						else if($ordenCompras["ComprasProductosTotale"]["estado"] == 4)
						{
							echo '<span class="label label-morado tool" data-toggle="tooltip" data-placement="top" title="Ingresado en SAP">Ing. Sap</span>';	
						}

						else if($ordenCompras["ComprasProductosTotale"]["estado"] == 0)
						{
							echo '<span class="label label-warning tool" data-toggle="tooltip" data-placement="top" title="Pendiente"> Eliminado</span>';	
						}


						else if($ordenCompras["ComprasProductosTotale"]["estado"] == 3)
						{
							echo '<span class="label label-default tool" data-toggle="tooltip" data-placement="top" title="'.$ordenCompras["ComprasProductosRechazo"][0]["motivo"]. '"> Rechazado G</span>';
						}

						else if($ordenCompras["ComprasProductosTotale"]["estado"] == 5)
						{

							echo '<span class="label label-default tool" data-toggle="tooltip" data-placement="top" title="'.$ordenCompras["ComprasProductosRechazo"][0]["motivo"]. '"> Rechazado S</span>';
						}

						else
						{
							echo '<span class="label label-success tool" data-toggle="tooltip" data-placement="top" title="Terminado"> Terminado</span>';
						}
					?>
				</td>
				<td width="15%">
					<a class="btn-sm btn btn-primary tool" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"view", $ordenCompras["ComprasProductosTotale"]["id"])); ?>/ingreso_sap" data-original-title="Ver detalle"><i class="fa fa-eye"></i></a/>
				</td>
				<!--td></td>
				<td></td>
				<td></td-->
			</tr>
		<?php// endif; ?>
	<?php endforeach; ?>
	</tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
    	
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
    
    $(".btn-danger").html('<i class="fa fa-trash-o"></i>');
    $(".fa-trash-o").closest("a").addClass("btn-sm btn btn-danger tool");
</script>