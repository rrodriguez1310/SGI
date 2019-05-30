<!--hr>
	<ul class="nav nav-pills">
		<li class="pull-right">
			<a href="<?php echo $this->Html->url(array("controller"=>"menus", "action"=>"add"))?>"><i class="fa fa-plus"></i> Agregar Menú</a>
		</li>
	</ul>
<hr-->
<id class="mensaje"></id>
<h3><?php echo __('Lista de Menús'); ?></h3>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
	<thead>
		<tr>
			<th>Nombre</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($menus as $menu): ?>
		<tr>
			<td class="mayuscula"><?php echo $menu['Menu']['nombre'];?></td>
			<td style="width: 8%">
				<div>
					<a class="btn-sm btn btn-success tool" href="<?php echo $this->Html->url(array('controller'=>'menus', 'action'=>'edit', $menu['Menu']['id'])); ?>" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
					<?php echo $this->Form->postLink($this->Html->tag('i','',array('class'=>'fa fa-editz')),array('action' => 'delete', $menu['Menu']['id']),array('class' => 'btn-sm btn btn-danger tool'), array(), __('Are you sure you want to delete # %s?', $menu['Menu']['id'])); ?>	
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