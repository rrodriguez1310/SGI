<h4>Lista de requerimiento de compras</h4>
<?php if(!empty($comprasTotales)) : ?>
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

	<?php foreach($comprasTotales as $key=>$comprasTotale) : ?>
		<?php if($comprasTotale["Estado"] == 1) : ?>
		<?php
			$class="";
			$tooltip = "";
			if(!empty($comprasTotale["docTributario"]))
			{

				$class = "success";
				$tooltip =  'class="tool" data-toggle="tooltip" data-placement="top" title="tipo de documento : ' .$comprasTotale["docTributario"]. '"';
			}
		?>
			<tr class="<?php echo $class; ?>">
				<td>
					<?php if(!empty($tooltip)) :?>
						<a href="#" <?php echo $tooltip?>> <?php echo substr($comprasTotale["docTributario"], 0,3)?> - <?php echo $comprasTotale["numeroFactura"]?></a>
					<?php else : ?>
						<?php echo $comprasTotale["IdRequerimiento"]; ?>
					<?php endif; ?>
				</td>
				<td><?php echo $comprasTotale["Empresa"]?></td>
				<td><?php echo $comprasTotale["Titulo"]?></td>
				<td><?php echo date('d-m-Y', strtotime($comprasTotale["Fecha"]));?></td>
				<td><?php echo number_format($comprasTotale["Total"], 0, '', '.');?></td>
				<td>
					<?php
						if($comprasTotale["Estado"] == 1)
						{
							echo '<span class="label label-danger tool" data-toggle="tooltip" data-placement="top" title="Pendiente por aprobar en gerencia"> Pendiente</span>';
						}
						
						else if($comprasTotale["Estado"] == 2)
						{
							echo '<span class="label label-warning tool" data-toggle="tooltip" data-placement="top" title="Aprobado por Gerencia"> Aprobado</span>';	
						}

						else if($comprasTotale["Estado"] == 4)
						{
							echo '<span class="label label-morado tool" data-toggle="tooltip" data-placement="top" title="Ingresado en SAP">Ing. Sap</span>';	
						}

						else if($comprasTotale["Estado"] == 0)
						{
							echo '<span class="label label-warning tool" data-toggle="tooltip" data-placement="top" title="Pendiente"> Eliminado</span>';	
						}


						else if($comprasTotale["Estado"] == 3)
						{

							echo '<span class="label label-default tool" data-toggle="tooltip" data-placement="top" title="'.$comprasTotale["Rechazo"][0]["motivo"]. '"> Rechazado G</span>';
						}

						else if($comprasTotale["Estado"]== 5)
						{

							echo '<span class="label label-default tool" data-toggle="tooltip" data-placement="top" title="'.$comprasTotale["Rechazo"][0]["motivo"]. '"> Rechazado S</span>';
						}

						else
						{
							echo '<span class="label label-success tool" data-toggle="tooltip" data-placement="top" title="Terminado"> Terminado</span>';
						}
					?>
				</td>
				<td>
					<a class="btn-sm btn btn-primary tool" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"view", $comprasTotale["IdRequerimiento"])); ?>/aprobadores" data-original-title="Ver detalle"><i class="fa fa-eye"></i></a/>
					<!--a class="btn-sm btn btn-success tool" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"edit", $comprasTotale["IdRequerimiento"])); ?>" data-original-title="Editar"><i class="fa fa-pencil"></i></a/-->

					<?php //echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash-o tool', 'title'=>"Eliminar")). "", array('action' => 'delete', $comprasTotale["IdRequerimiento"]), array('escape'=>false), __('El requerimiento de compra sera eliminado # %s?', $comprasTotale["IdRequerimiento"]));?>


				</td>
			</tr>
		<?php endif; ?>
	<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>

<div class="alert alert-danger" role="alert">
	<strong>Información!</strong> No hay requerimientos de compras por aprobar.
</div>

<?php endif; ?>

<!--script type="text/javascript">
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
</script-->

<script type="text/javascript">
    $(document).ready(function() {
    	
    	$(".btn-danger").click(function(){
    		var id = $(this).attr("id");
    		$(".id_rechazo").val(id);
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