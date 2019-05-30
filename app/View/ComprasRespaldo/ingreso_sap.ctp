<h4>Lista de requerimiento de compras</h4>
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
<?php 
	$emailAprobadorSapRequerimientos = explode(".", strtolower($this->Session->read("Users.email")));
	if($emailAprobadorSapRequerimientos[0].'.cl' == "jmariangel@cdf.cl")
	{
		foreach($ordenCompra as $key=>$ordenCompras)
		{
			if($ordenCompras["ComprasProductosTotale"]["tipos_documento_id"] == "")
			{
?>	
				<tr>
					<td>
						<?php echo $ordenCompras["ComprasProductosTotale"]["id"]; ?>
					</td>
					<td><?php echo $ordenCompras["Company"]["razon_social"]; ?></td>
					<td><?php echo $ordenCompras["ComprasProductosTotale"]["titulo"]; ?></td>
					<td><?php echo date('d-m-Y', strtotime($ordenCompras["ComprasProductosTotale"]["created"]));?></td>
					<td><?php echo number_format($ordenCompras["ComprasProductosTotale"]["total"], 0, '', '.');?></td>
					<td>
						<span class="<?php echo $ordenCompras["ComprasEstado"]["clase"]?> tool" data-toggle="tooltip" data-placement="top" title="<?php echo $ordenCompras["ComprasEstado"]["estado"]?>"><?php echo $ordenCompras["ComprasEstado"]["estado"]?></span>
					</td>
					<td width="15%">
						<a class="btn-sm btn btn-primary tool" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"view", $ordenCompras["ComprasProductosTotale"]["id"])); ?>/ingreso_sap" data-original-title="Ver detalle"><i class="fa fa-eye"></i></a/>
					</td>
				</tr>

<?php

			}	
		}
	}
	else
	{
		
?>
		
	<?php 
		foreach($ordenCompra as $key=>$ordenCompras) : 
			if($ordenCompras["ComprasProductosTotale"]["tipos_documento_id"] != "") : 
				$class="";
				$tooltip = "";
				if(!empty($ordenCompras["TiposDocumento"]["nombre"]))
				{

					$class = "success";
					$tooltip =  'class="tool" data-toggle="tooltip" data-placement="top" title="tipo de documento : ' .$ordenCompras["TiposDocumento"]["nombre"]. '"';
				}
	?>
			<tr class="<?php echo $class ; ?>">
				<td>
					<?php if($class != "") : ?>

						<a href="#" <?php echo $tooltip?>> 

							<?php echo substr($ordenCompras["TiposDocumento"]["nombre"], 0,3); ?>-<?php if(isset($ordenCompras["ComprasFactura"][0]["numero_documento"])){echo $ordenCompras["ComprasFactura"][0]["numero_documento"];}?></a>
					<?php else : ?>
						<?php echo $ordenCompras["ComprasProductosTotale"]["id"]; ?>
					<?php endif; ?>
				</td>
				<td><?php echo $ordenCompras["Company"]["nombre"]; ?></td>
				<td><?php echo $ordenCompras["ComprasProductosTotale"]["titulo"]; ?></td>
				<td><?php echo date('d-m-Y', strtotime($ordenCompras["ComprasProductosTotale"]["created"]));?></td>
				<td><?php echo number_format($ordenCompras["ComprasProductosTotale"]["total"], 0, '', '.');?></td>
				<td>
					<span class="<?php echo $ordenCompras["ComprasEstado"]["clase"]?> tool" data-toggle="tooltip" data-placement="top" title="<?php echo $ordenCompras["ComprasEstado"]["estado"]?>"><?php echo $ordenCompras["ComprasEstado"]["estado"]?></span>
				</td>
				<td width="15%">
					<a class="btn-sm btn btn-primary tool" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"view", $ordenCompras["ComprasProductosTotale"]["id"])); ?>/ingreso_sap" data-original-title="Ver detalle"><i class="fa fa-eye"></i></a/>
				</td>

			</tr>
	<?php
			endif; 
		endforeach;
	?>

<?php	
	}
?>
	</tbody>
</table>

<script>
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
		}
    });
</script>