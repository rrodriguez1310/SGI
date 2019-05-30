<div class="dimensionesNombres index">
	<h3><?php echo __('Dimensiones Nombres'); ?></h3>
	<table id="datatable" class="table table-bordered">
	<thead>
	<tr>
			<th><?php echo __('Id'); ?></th>
			<th><?php echo __('Nombre'); ?></th>
			<th class="actions"> </th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($dimensionesNombres as $dimensionesNombre): ?>
	<tr>
		<td><?php echo h($dimensionesNombre['DimensionesNombre']['id']); ?>&nbsp;</td>
		<td><?php echo h($dimensionesNombre['DimensionesNombre']['nombre']); ?>&nbsp;</td>
		<td width="70">
			<?php //echo $this->Html->link(__('View'), array('action' => 'view', $dimensionesNombre['DimensionesNombre']['id'])); ?>
			<?php echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), array('action' => 'edit', $dimensionesNombre['DimensionesNombre']['id']), array("class"=>"btn-sm btn btn-success tool", "escape"=>false)); ?>
			<?php echo $this->Form->postLink(__('<i class="fa fa-trash-o"></i>'), array('action' => 'delete', $dimensionesNombre['DimensionesNombre']['id']), array("class"=>"btn-sm btn btn-danger tool", "escape"=>false), __('Esta seguro que quiere eliminar # %s?', $dimensionesNombre['DimensionesNombre']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
</div>

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