<id class="mensaje"></id>
<h3><?php echo __('Lista tipos de correo'); ?></h3>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Descripción</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaCorreosTipos as $listaCorreosTipo): ?>
		<tr>
			<td class="mayuscula"><?php echo $listaCorreosTipo['ListaCorreosTipo']['nombre'];?></td>
			<td class="mayuscula"><?php echo $listaCorreosTipo['ListaCorreosTipo']['descripcion'];?></td>
			<td style="width: 8%">
				<div>
					<a class="btn-sm btn btn-success tool" href="<?php echo $this->Html->url(array('controller'=>'lista_correos_tipos', 'action'=>'edit', $listaCorreosTipo['ListaCorreosTipo']['id'])); ?>" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
					<?php echo $this->Form->postLink($this->Html->tag('i','',array('class'=>'fa fa-editz')),array('action' => 'delete', $listaCorreosTipo['ListaCorreosTipo']['id']),array('class' => 'btn-sm btn btn-danger tool'), __('Estas seguro que quieres eliminar '.$listaCorreosTipo["ListaCorreosTipo"]["nombre"].'?', $listaCorreosTipo['ListaCorreosTipo']['id'])); ?>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<script type="text/javascript">
	$('.tool').tooltip();
	$(".btn-danger").html('<i class="fa fa-trash-o"></i>');
</script>