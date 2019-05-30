<id class="mensaje"></id>
<h3><?php echo __('Lista de Dimensiones Proyectos'); ?></h3>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
	<thead>
		<tr>
			<td>Codigo</td>
			<td>Nombre</td>
			<td>Descripción</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($dimensionesProyectos as $dimensionesProyecto): ?>
			<tr>
				<td><?php echo $dimensionesProyecto["DimensionesProyecto"]["codigo"]; ?></td>
				<td><?php echo $dimensionesProyecto["DimensionesProyecto"]["nombre"]; ?></td>
				<td><?php echo $dimensionesProyecto["DimensionesProyecto"]["descripcion"]; ?></td>
				<td style="width:8%">
					<div>
						<?php foreach($this->Session->Read("Controladores.controladores") as $submenu) : ?>					
							<?php if($submenu["Controllador"] == "dimensiones_proyectos" && $submenu["Accion"] == "edit"): ?>
								<a class="btn-sm btn btn-success tool" href="<?php echo $this->Html->url(array('controller'=>'dimensiones_proyectos', 'action'=>'edit', $dimensionesProyecto['DimensionesProyecto']['id'])); ?>" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
							<?php endif;	
								if($submenu["Controllador"] == "dimensiones_proyectos" && $submenu["Accion"] == "delete")
								{	
									echo $this->Form->postLink($this->Html->tag('i','',array('class'=>'fa fa-editz')),array('action' => 'delete', $dimensionesProyecto['DimensionesProyecto']['id']), array('class' => 'btn-sm btn btn-danger tool'), __('Estas seguro que deseas eliminar el codigo '.$dimensionesProyecto["DimensionesProyecto"]["codigo"], $dimensionesProyecto['DimensionesProyecto']['id']));	
								} 
							?>
						<?php endforeach; ?>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<script type="text/javascript">	

	$(document).ready(function(){   

        $('#datatable').dataTable({
            "sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
            "sPaginationType": "bootstrap",
            "iDisplayLength": 50,
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
    });
    $(".btn-danger").html('<i class="fa fa-trash-o"></i>');
</script>