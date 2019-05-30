<id class="mensaje"></id>
<h3><?php echo __('Lista de Gerencias'); ?></h3>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
	<thead>
		<tr>
			<th>Nombre</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($gerencias as $gerencia): ?>
		<tr>
			<td class="mayuscula"><?php echo $gerencia['Gerencia']['nombre'];?></td>
			<td style="width: 8%">
				<div>
					<a class="btn-sm btn btn-success tool" href="<?php echo $this->Html->url(array('controller'=>'gerencias', 'action'=>'edit', $gerencia['Gerencia']['id'])); ?>" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
					<a href="javascript:void(0)" name="<?php echo $gerencia["Gerencia"]["nombre"]?>" class="btn-sm btn btn-danger tool" id="<?php echo $gerencia['Gerencia']['id']?>"><i class="fa fa-trash-o"></i></a>	
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<div class="modal fade" id="modalAsociados">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        <h4 class="modal-title">Asociados a <strong id="tituloModal"></strong></h4>
      </div>
      <div class="modal-body modal-scrolling">
      	<h5><strong>No se puede eliminar la gerencia porque tiene asociado</strong></h5>
      	<ul id="listaModal">
      		
      	</ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">

	$(".btn-danger").click(function(){

		var id = $(this).attr('id');
		var nombre = $(this).attr('name');
		var eliminar = confirm("Desea eliminar "+nombre+"?");
		if(eliminar == true)
		{
			$.getJSON("<?php echo $this->Html->url(array('controller'=>'Servicios', 'action'=>'asocGerencia')); ?>",{'id':id},function(data,status)
			{
				$("#tituloModal").empty();
				$("#listaModal").empty();
				if(data != 0)
				{
					$("#tituloModal").text(nombre.toUpperCase());
					if(data.areas!="")
					{
						$("#listaModal").append('<br/><strong>Áreas</strong><br/>');
						$.each(data.areas, function(i,item)
						{	
							$("#listaModal").append('<li>'+item+'</li>');
						});
					}
					if(data.cargos!="")
					{	
						$("#listaModal").append('<br/><strong>Cargos</strong><br/>');
						$.each(data.cargos, function(i,item)
						{
							$("#listaModal").append('<li>'+item+'</li>');
						});
					}		
					if(data.trabajadores!="")
					{	
						$("#listaModal").append('<br/><strong>Trabajadores</strong><br/>');
						$.each(data.trabajadores, function(i,item)
						{
							$("#listaModal").append('<li>'+item+'</li>');
						});
					}			
					$('#modalAsociados').modal();
				}else
				{
					$.post("<?php echo $this->Html->url(array('controller'=>'gerencias', 'action'=>'delete')); ?>",{'id':id}, function(){
						window.location = "<?php echo $this->Html->url(array('controller'=>'gerencias', 'action'=>'index')); ?>";
					});
				}	
  			});
		}
	});

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