<div class="dimensionesCodigosCortos index">
	<h3><?php echo __('Dimensiones Codigos Cortos'); ?></h3>
	<table id="datatable" class="table table-bordered">
	<thead>
	<tr>
			<th>Id</th>
			<th>Nombre Corto</th>
			<th>Nombre Completo</th>
			<th></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($dimensionesCodigosCortos as $dimensionesCodigosCorto): ?>
	<tr>
		<td><?php echo h($dimensionesCodigosCorto['DimensionesCodigosCorto']['id']); ?>&nbsp;</td>
		<td><?php echo h($dimensionesCodigosCorto['DimensionesCodigosCorto']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($dimensionesCodigosCorto['DimensionesCodigosCorto']['descripcion']); ?>&nbsp;</td>
		<td class="actions">
			<?php //echo $this->Html->link(__('View'), array('action' => 'view', $dimensionesCodigosCorto['DimensionesCodigosCorto']['id'])); ?>
			<?php echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), array('action' => 'edit', $dimensionesCodigosCorto['DimensionesCodigosCorto']['id']), array("class"=>"btn-sm btn btn-success tool", "escape"=>false)); ?>
			<?php echo $this->Form->postLink(__('<i class="fa fa-trash-o"></i>'), array('action' => 'delete', $dimensionesCodigosCorto['DimensionesCodigosCorto']['id']), array("class"=>"btn-sm btn btn-danger tool", "escape"=>false), __('Esta seguro que quiere eliminar # %s?', $dimensionesCodigosCorto['DimensionesCodigosCorto']['id'])); ?>
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
</script>
