<div class="dimensionesAreas index">
	<h2><?php echo __('Dimensiones Areas'); ?></h2>
	<table id="datatable" class="table table-bordered">
	<thead>
	<tr>
		<th>Id</th>
		<th>Nombre</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($dimensionesAreas as $dimensionesArea): ?>
	<tr>
		<td><?php echo h($dimensionesArea['DimensionesArea']['id']); ?>&nbsp;</td>
		<td><?php echo h($dimensionesArea['DimensionesArea']['nombre']); ?>&nbsp;</td>
		<td width="80">
			<?php //echo $this->Html->link(__('<i class="fa fa-eye"></i>'), array('action'=>'view', $dimensionesArea['DimensionesArea']['id']), array("class"=>"btn-sm btn btn-primary tool", "escape"=>false)); ?>
			<?php echo $this->Html->link(__('<i class="fa fa-pencil"></i>'), array('action' => 'edit', $dimensionesArea['DimensionesArea']['id']), array("class"=>"btn-sm btn btn-success tool", "escape"=>false)); ?>
			<?php echo $this->Form->postLink(__('<i class="fa fa-trash-o"></i>'), array('action' => 'delete', $dimensionesArea['DimensionesArea']['id']), array("class"=>"btn-sm btn btn-danger tool", "escape"=>false), __('Esta seguro que quiere eliminar # %s?', $dimensionesArea['DimensionesArea']['id'])); ?>
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
