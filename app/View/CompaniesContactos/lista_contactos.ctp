<?php echo $this->Session->flash(); ?>
<h5 style="font-weight: bold;"><?php echo $datosEmpresa['nombre']?></h5>
<div class="modal-scrolling" style="max-height:365px">
	<table class="table table-striped table-bordered">
		<tr class="text-center">
			<th class="text-center">Nombre</th>
			<th class="text-center">Cargo</th>
			<th class="text-center" style="min-width: 120px">Teléfono</th>
			<th class="text-center" style="min-width: 120px">Celular</th>
			<th class="text-center">Correo</th>		
			<th class="text-center" style="min-width: 80px">Acción</th>
		</tr>
		<?php if(!empty($listaContactos)): ?>
			<?php foreach ($listaContactos as $contacto): ?>
				<tr>
					<td><?php echo mb_strtoupper($contacto['nombre'], 'UTF-8') .' '.mb_strtoupper($contacto['apellido_paterno'], 'UTF-8'); ?></td>
					<td><?php echo (trim($contacto['cargo'])!='')? mb_strtoupper($contacto['cargo'], 'UTF-8') : '-';  ?></td>
					<td><?php echo (trim($contacto['telefono'])!='')? $contacto['telefono'] : '-'; ?></td>
					<td><?php echo (trim($contacto['celular'])!='')? $contacto['celular'] : '-'; ?></td>
					<td><?php echo (trim($contacto['email'])!='')? $contacto['email'] : '-'; ?></td>
					<td class="text-center">	
						<!--a class="comentarios btn-sm btn btn-default btn-xs tool" id="<?php echo $contacto['id']?>" data-toggle="modal" data-target="#listaContactos" href="#" data-toggle="tooltip" data-placement="top" title="Comentarios">
							<i class="fa fa-comment"></i>
						</a-->
						<a class="edit-contacto btn btn-success tool btn-xs" id="<?php echo $contacto['id']?>" data-target="#listaContactos" href="#" data-toggle="tooltip" data-placement="top" title="Editar">
							<i class="fa fa-pencil"></i>
						</a>													
						<a class="eliminar btn btn-danger tool btn-xs" id="<?php echo $contacto['id']?>" name="<?php echo $contacto['nombre'].' '.$contacto['apellido_paterno']?>" data-target="#listaContactos" href="#" data-toggle="tooltip" data-placement="top" title="Eliminar">
							<i class="fa fa-trash-o"></i>
						</a>
					</td>					
				</tr>
			<?php endforeach; ?>
		<?php else : ?>
			<tr><td colspan="6">No se encontraron registros</td></tr>
		<?php endif; ?>
	</table>
</div>
<div class="modal-footer">
	<div class="text-right">
		<button type="button" class="add-contacto btn btn-primary">
			<i class="fa fa-plus-square-o"></i> Ingresar
		</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	</div>	
</div>
<script>
	$(".add-contacto").click(function(event){	
		 var id = "<?php echo $datosEmpresa['id'];?>";
		 var estado = '1';		 
		 
		if(id!=="")
		{		 				
			$.ajax({ 
				type: 'GET', 
				async: true,
				url: '<?php echo $this->Html->url(array('controller'=>'companies_contactos', 'action'=>'add'))?>', 
				data: { "id": id, "estado": estado},
				dataType: "html",
				success: function (data) {							
					$('.listado').empty();	
					if($.trim(data)!==''){
						$('.listado').html(data);						
					}
		        },
		        complete: function (){
		        	$('.tool').tooltip();	
		        	$("#tituloModal").text('Ingresar Contacto');
		        }
		    });
		}		 		 
      });

	$(".edit-contacto").click(function(event){	
		var id = $(this).attr('id');
		var estado = '1';

		if(id!=="")
		{
			$.ajax({ 
				type: 'GET', 
				async: true,
				url: '<?php echo $this->Html->url(array('controller'=>'companies_contactos', 'action'=>'edit'))?>', 
				data: { "id": id, "estado": estado},
				dataType: "html",
				success: function (data) {	
					$('.listado').empty();	
					if($.trim(data)!==''){
						$('.listado').html(data);						
					}
		        },
		        complete: function (){
		        	$('.tool').tooltip();	
		        	$("#tituloModal").text('Editar Contacto');
		        }
		    });
		}		 		 
      });

	$(".eliminar").on("click", function()
	{	
		var id = $(this).attr('id');
		var company_id = "<?php echo $datosEmpresa['id'];?>";
		var nombre = $(this).attr('name');
		var r = confirm("Esta seguro que desea eliminar el contacto "+ nombre);

		if(r){
			$.ajax({
			    type: "POST",
			    url: "<?php echo $this->Html->url(array('controller' => 'companies_contactos', 'action' => 'delete')); ?>",
			    data: { "id": id, "company_id" : company_id},
			    success: function(data) {			    
		    		$('.listado').empty();
					if($.trim(data)!==''){
						$('.listado').html(data);
					}			    	
			    },
			    complete: function(){
			    	$('.btn-danger').html('<i class="fa fa-trash-o"></i>');	
			    	$(".alert-success").delay(3000).slideUp(600, function() {
					    $(this).alert('close');
					});
			    }
			  });
			return false;
		}
	});

	$(".comentarios").click(function(event){	
		var id = $(this).attr('id');
		 
		if(id!=="")
		{		 				
			$.ajax({ 
				type: 'GET', 
				async: true,
				url: '<?php echo $this->Html->url(array('controller'=>'companies_contactos', 'action'=>'comentar'))?>', 
				data: { "id": id},
				dataType: "html",
				success: function (data) {							
					$('.listado').empty();	
					if($.trim(data)!==''){
						$('.listado').html(data);						
					}
		        },
		        complete: function (){
		        	$('.tool').tooltip();	
		        	$("#tituloModal").text('Comentarios');
		        }
		    });
		}		 		 
      });

</script>

