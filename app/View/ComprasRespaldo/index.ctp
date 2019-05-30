<!--h4>Mis Ingresos</h4-->
<div class="text-right" >
	<div class="btn-group" role="group" aria-label="...">
		<button type="button" class="btn btn-info tool asociar_documentos_tributarios" data-toggle="tooltip" data-placement="top" title="Asociar Documento Tributario"><i class="fa fa-file-text"></i></button>
	</div>
</div> 
<table id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th></th>
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
	<?php foreach($ordenCompra as $key=>$ordenCompras) : ?>
		<?php //if($ordenCompras["ComprasProductosTotale"]["estado"] != 0) : ?>
		<?php
			$class = "";
			if(!empty($ordenCompras["TiposDocumento"]["id"]))
			{
				$plantilla = "plantilla_boleta_facturas_add_documento";
				$class="success";
				$tooltip =  'class="tool" data-toggle="tooltip" data-placement="top" title="tipo de documento : ' .$ordenCompras["TiposDocumento"]["nombre"]. '"';
			}
			else
			{
				$plantilla = "plantilla_boletas_facturas_add";
			}
		?>	
			<tr class="<?php echo $class;?>">
				<td>
					<?php if($ordenCompras["ComprasProductosTotale"]["tipos_documento_id"] == "") :?>
						<?php if($ordenCompras["ComprasProductosTotale"]["compras_estado_id"] == 4  || $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] == 8 ):?>
							<input class="check" type="checkbox" name="idOrdenCompra[]" value="<?php echo $ordenCompras["ComprasProductosTotale"]["id"];?>">
						<?php endif; ?>
					<?php endif; ?>
				</td>
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
				<td style="vertical-align: top; text-align: right;"><?php echo number_format($ordenCompras["ComprasProductosTotale"]["total"], 0, '', '.');?></td>
				<td>
					<span class="<?php echo $ordenCompras["ComprasEstado"]["clase"]?> tool" data-toggle="tooltip" data-placement="top" title="<?php echo $ordenCompras["ComprasEstado"]["estado"]?>"><?php echo $ordenCompras["ComprasEstado"]["estado"]?></span>
				</td>
				<td width="15%">
					
					<a class="btn-sm btn btn-primary tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"view", $ordenCompras["ComprasProductosTotale"]["id"])); ?>" data-original-title="Ver detalle"><i class="fa fa-eye"></i></a/>
					<?php if($ordenCompras["ComprasProductosTotale"]["tipos_documento_id"] != 26) : ?>
					<?php if($ordenCompras["ComprasProductosTotale"]["compras_estado_id"] == 6 || $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] == 4) : ?>
						<a class="btn-sm btn btn-warning tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>$plantilla, $ordenCompras["ComprasProductosTotale"]["id"])); ?>" data-original-title="Usar plantilla"><i class="fa fa-recycle"></i></a/>	
					<?php endif; ?>
					
					<?php if($ordenCompras["ComprasProductosTotale"]["tipos_documento_id"] == 17 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] == 4)  :?>
						<a class="btn-sm btn btn-naranjo tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"notas_credito", $ordenCompras["ComprasProductosTotale"]["id"])); ?>" data-original-title="Notas de credito"><i class="fa fa-files-o"></i></a/>
					<?php endif; ?>
					<?php if($ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 3  && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 5 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 4 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 6): ?>
					
						<?php
							$accion = ""; 
							if(!empty($ordenCompras["TiposDocumento"]["nombre"]))
							{ 
									$accion = "clonar_documento_tributario_edit";
							}
							else
							{
								$accion = "edit";
							}
						?>
					<?php if($ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 2 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 8 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 9) :?>

					<a class="btn-sm btn btn-success tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>$accion, $ordenCompras["ComprasProductosTotale"]["id"])); ?>" data-original-title="Editar"><i class="fa fa-pencil"></i></a/>
							
					<?php endif; ?>

					<a class="btn-sm btn btn-warning tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>$plantilla, $ordenCompras["ComprasProductosTotale"]["id"])); ?>" data-original-title="Usar plantilla"><i class="fa fa-recycle"></i></a/>
						


					<?php endif; ?>
					


					<?php if($ordenCompras["ComprasProductosTotale"]["compras_estado_id"] == 3 || $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] == 5 ) : ?>
								
						<?php
							$accion = ""; 
							if(!empty($ordenCompras["TiposDocumento"]["nombre"]))
							{
									$accion = "clonar_documento_tributario";
							}
							else
							{
								$accion = "clonar";
							}
						?>
						<a class="btn-sm btn btn-info tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>$accion, $ordenCompras["ComprasProductosTotale"]["id"])); ?>" data-original-title="Clonar orden de compra"><i class="fa fa-refresh"></i></a/>
					<?php endif; ?>

					<?php 
						//pr($ordenCompras["ComprasProductosTotale"])
					?>



					<?php if($ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 9 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 7 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 8 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 2 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 3 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 5 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 4 && $ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 6) : ?>
					<?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash-o tool', 'title'=>"Eliminar")). "", array('action' => 'delete', $ordenCompras["ComprasProductosTotale"]["id"]), array('escape'=>false), __('La orden de compra sera eliminado # %s?', $ordenCompras["ComprasProductosTotale"]["id"]));?>
					<?php endif; ?>

				<?php endif; ?>
				</td>
				<!--td></td>
				<td></td>
				<td></td-->
			</tr>
		<?php// endif; ?>
	<?php endforeach; ?>
	</tbody>
</table>

<?php echo $this->Form->create('Compras', array('action' => 'asociar_facturas'));?>
	<input type="hidden" id="productosAsociados" name="idRequerimiento">
<?php echo $this->Form->end(); ?>


<script type="text/javascript">
    $(document).ready(function() {
    	
    	$('.tool').tooltip();
    	
    	var buscaPor = "<?php echo $empresaSeleccionada; ?>"
    	
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
			"oSearch": {"sSearch": buscaPor}

        } );
        $('#datatable label input[type=text]').val('Default Product');
 		
 		
 		
 		$('.check').click(function(){
 			$(this).each(function(){
 				var checkbox = $(this);
			   	if(checkbox.is(':checked') == true)
			   	{
			   		
			   		//$(".asociar_documentos_tributarios").removeClass("esconde");
			   		//$(".asociar_documentos_tributarios").removeClass("disabled");
			   	}
			   	else
			   	{
			   		//$(".asociar_documentos_tributarios").addClass("esconde");
			   		//$(".asociar_documentos_tributarios").addClass("disabled");
			   	}
			});
 		});

       $(".asociar_documentos_tributarios").click(function(){
       		
       		 var idProductos = new Array();

       		$("#productosAsociados").val("");

	       	$('.check').each(function(){
	       		var checkbox = $(this);
	       		if(checkbox.is(':checked') == true)
	       		{
	       			idProductos.push($(this).val());
	       		}
	       	});

	       	if(idProductos != "")
	       	{
	       		$("#productosAsociados").val(idProductos);
	       	}
	       	else
	       	{
	       		$("#productosAsociados").val("");
	       	}
	       	if(idProductos != "")
	       	{
				$("#ComprasAsociarFacturasForm").submit();
			}
			else
			{
				alert("Seleccione un requerimiento");
				return false;
			}
       })
    });
    
    $(".btn-danger").html('<i class="fa fa-trash-o "></i>');
    $(".fa-trash-o").closest("a").addClass("btn-xs btn btn-danger tool");
</script>