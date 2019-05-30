<!--hr>
	<ul class="nav nav-pills">
		<li class="pull-right">
			<a href="<?php echo $this->Html->url(array("controller"=>"users", "action"=>"add"))?>"><i class="fa fa-plus"></i> Agregar Usuario</a>
		</li>
	</ul>
<hr-->
<id class="mensaje"></id>
<h3><?php echo __('Usuarios'); ?></h3>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Nombre de Usuario</th>
			<th>Rol</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($usuarios as $usuario): ?>
		<tr>
			<td class="mayuscula"><?php echo $usuario['User']['nombre'];?></td>
			<td class="mayuscula"><?php echo $usuario['User']['usuario'];?></td>
			<td class="mayuscula"><?php echo $usuario['Role']['nombre'];?></td>
			<td style="width: 8%">
				<div>
					<a class="btn-sm btn btn-success tool" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'edit', $usuario['User']['id'])); ?>" data-toggle="tooltip" data-placement="top" title="Editar usuario"><i class="fa fa-edit"></i></a>
					<?php echo $this->Form->postLink($this->Html->tag('i','',array('class'=>'fa fa-editz')),array('action' => 'delete', $usuario['User']['id']),array('class' => 'btn-sm btn btn-danger tool'), array(), __('Are you sure you want to delete # %s?', $usuario['User']['id'])); ?>
					<!--<a class="btn-sm btn btn-danger tool" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'delete', $usuario['User']['id']))?>" data-toggle="tooltip" data-placement="top" title="Eliminar usuario"><i class="fa fa-trash-o"></i></a>-->		
				</div>
			</td>
		</tr>
		<?php endForeach; ?>
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
			}

        } );
    } );
    
    $(".btn-danger").html('<i class="fa fa-trash-o"></i>');
</script>