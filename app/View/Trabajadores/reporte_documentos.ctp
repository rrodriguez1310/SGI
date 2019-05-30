<div class="col-md-12">
	<div class="row">
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
			<thead>
				<tr>
					<th>Estado</th>
					<th>Nombre</th>
					<th>Observaciones</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($trabajadores as $trabajador) :  ?>
				<tr>
					<td rowspan="<?php echo $trabajador["filas"]; ?>"><?php echo $trabajador["Trabajadore"]["estado"] ?></td>
					<td rowspan="<?php echo $trabajador["filas"]; ?>"><a href="<?php echo $this->Html->url(array('controller'=>'trabajadores', 'action'=>'edit', $trabajador['Trabajadore']['id'])); ?>"><?php echo $trabajador["Trabajadore"]["nombre"]." ".$trabajador["Trabajadore"]["apellido_paterno"]." ".$trabajador["Trabajadore"]["apellido_materno"]?></a></td>
					<td>
						<ul>
						<?php foreach($trabajador["observaciones"] as $observacion):?>
							<li><?php echo $observacion?></li>
						<?php endforeach;?>
						</ul>
					</td>
				</tr>
			<?php  endforeach;?> 
			</tbody>			
		</table>			
	</div>
</div>
<script type="text/javascript">

	$(document).ready(function() {

		$('#datatable').dataTable( {
			'ordering': false,
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
	
	});
</script>