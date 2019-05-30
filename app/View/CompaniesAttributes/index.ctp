<id class="mensaje"></id>
<h3><?php echo __('Lista de Empresas'); ?></h3>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
	<thead>
		<tr>
			<th>Rut</th>
			<th>Nombre de fantasía</th>
			<th>Razón social</th>
			<th>Tipo Compañia</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($empresas as $empresa): ?>
		<tr>
			<td class="mayuscula"><?php echo $empresa['Company']['rut'];?></td>
			<td class="mayuscula"><?php echo $empresa['Company']['alias'];?></td>
			<td class="mayuscula"><?php echo $empresa['Company']['razon_social'];?></td>
			<td><?php echo $empresa['CompanyType']['nombre'];?></td>
			<!--td>
				<?php 
					echo ($empresa['Company']['activo'] == 1) ? "Agrupado":"No Agrupado";
				?>
			</td-->
			<td style="width: 14%">
				<div>	
						<?php 
						if($empresa['Company']['company_type_id'] == 1)
						{
							foreach($this->Session->Read("Controladores.controladores") as $submenu) : 
						?>
						<?php 
						if($submenu["Controllador"] == "companies" && $submenu["Accion"] == "detalleServiciosContratados")
						{ ?>
						<a id="<?php if(isset($idAtributos[$empresa['Company']['id']])) {echo $idAtributos[$empresa['Company']['id']];
						}
						else
						{
							echo "";} ?>" class="btn-sm btn btn-primary  tool serviciosContratados btn-xs" href="#" data-toggle="tooltip" data-placement="top" title="Detalle Servicio Contratado"><i class="fa fa-eye"></i></a>
						<?php 
						}	
						if($submenu["Controllador"] == "companies" && $submenu["Accion"] == "edit")
						{ ?>
						<a class="btn-sm btn btn-success tool btn-xs" href="<?php echo $this->Html->url(array('controller'=>'companies', 'action'=>'edit', $empresa['Company']['id'])); ?>" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<?php 
						}						
						if($submenu["Controllador"] == "subscribers" && $submenu["Accion"] == "index")
						{ ?>
						<a class="btn-sm btn btn-info tool btn-xs" href="<?php echo $this->Html->url(array('controller'=>'subscribers', 'action'=>'index', $empresa['Company']['id']))?>" data-toggle="tooltip" data-placement="top" title="Abonados"><i class="fa fa-users"></i></a>
						<?php
						}
						if($submenu["Controllador"] == "companiesAtributes" && $submenu["Accion"] == "add")
						{ ?>
						<a class="btn-sm btn btn-warning tool camara btn-xs" id="<?php echo $empresa['Company']['id']?>" data-toggle="modal" data-target="#detalleServicio" href="#" data-toggle="tooltip" data-placement="top" title="Registrar Detalle Servicio"><i class="fa fa-video-camera"></i></a>
						<?php
						} 
						?>

					<?php endforeach; } ?>

					<!-- <a class="contacto btn-sm btn btn-default btn-xs tool" id="<?php //echo $empresa['Company']['id']?>" data-toggle="modal" data-target="#contactos" href="#" data-toggle="tooltip" data-placement="top" title="Ingresar contacto"><i class="fa fa-user"></i></a>  -->
					<a class="listadoContactos btn-sm btn btn-default btn-xs tool" id="<?php echo $empresa['Company']['id']?>" data-toggle="modal" data-target="#listaContactos" href="#" data-toggle="tooltip" data-placement="top" title="Ingresar contactos"><i class="fa fa-user"></i></a>
					
				</div>


				
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="detalleServicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <?php echo $this->Form->create('CompaniesAttribute', array('url' =>array('controller'=>'companies_attributes', 'action'=>'add')), array('class'=>'form-inline')); ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Registrar Servicio 123</h4>
      </div>
      <div class="modal-body">
      	<div class="col-md-6">
			<div class="form-group">
				<?php echo $this->Form->hidden('company_id', array('type'=>'text', 'label'=>false));?>
	  		</div>
	  		
	  		<div class="form-group">
				<label class="sr-only" for="exampleInputEmail2">Email address</label>
				<?php echo $this->Form->input('channel_id', array('label'=>false, 'class'=>'multiselect channel', "multiple"=>"multiple")); ?>
	  		</div>
	  		
	  		<div class="form-group">
				<label class="sr-only" for="exampleInputEmail2">Email address</label>
				<?php echo $this->Form->input('link_id', array('label'=>false, 'class'=>'multiselect link', "multiple"=>"multiple")); ?>
	  		</div>
	  		
	  		<div class="form-group">
				<label class="sr-only" for="exampleInputEmail2">Email address</label>
				<?php echo $this->Form->input('signal_id', array('label'=>false, 'class'=>'multiselect signal', "multiple"=>"multiple")); ?>
	  		</div>
	  		
	  		<div class="form-group">
				<label class="sr-only" for="exampleInputEmail2">Email address</label>
				<?php echo $this->Form->input('payment_id', array('label'=>false, 'class'=>'multiselect payment', "multiple"=>"multiple")); ?>
	  		</div>

		</div>
		<div class="modal-footer">
        <button type="submit" class="btn btn-primary registraAtributos">Registrar 333</button>
      </div>
		<?php echo $this->Form->end(); ?>
      </div>
      
    </div>
  </div>
</div>
<div class="modal fade" id="detalleServicioContratado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle de Servicios Contratados</h4>
      </div>
      <div class="modal-body detalle">
		</div>
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </div>      
    </div>
  </div>

<div class="modal fade " id="listaContactos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="tituloModal">Lista de Contactos</h4>
      </div>
      <div class="modal-body listado "></div>
  	</div>      
  </div>
</div>


<div class="modal fade" id="contactos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Contactos</h4>
			</div>
			<div class="modal-body detalleContacto">
				
				<?php echo $this->Form->create('CompaniesContacto', array('action' => 'add')); ?>
					<?php echo $this->Form->hidden('company_id'); ?>
					<?php echo $this->Form->hidden('estado', array('default'=>1)); ?>
					<div class="form-group">
						<?php echo $this->Form->input('nombre', array("label"=>false, "class"=>"form-control", "placeholder"=>"Nombre")); ?>
					</div>

					<div class="form-group">
						<?php echo $this->Form->input('apellido_paterno', array("label"=>false, "class"=>"form-control", "placeholder"=>"Apellido Paterno")); ?>
					</div>

					<div class="form-group">
						<?php echo $this->Form->input('apellido_materno', array("label"=>false, "class"=>"form-control", "placeholder"=>"Apellido Materno")); ?>
					</div>

					<div class="form-group">
						<?php echo $this->Form->input('cargo', array("label"=>false, "class"=>"form-control", "placeholder"=>"Cargo")); ?>
					</div>

					<div class="form-group">
						<?php echo $this->Form->input('telefono_fijo', array("label"=>false, "class"=>"form-control", "placeholder"=>"Telefono Fijo")); ?>
					</div>

					<div class="form-group">
						<?php echo $this->Form->input('telefono_celular', array("label"=>false, "class"=>"form-control", "placeholder"=>"Telefono Celular")); ?>
					</div>

					<div class="form-group">
						<?php echo $this->Form->email('email', array("label"=>false, "class"=>"form-control", "placeholder"=>"Email")); ?>
					</div>

					<div class="form-group">
						<?php echo $this->Form->textArea('observacion', array("label"=>false, "class"=>"form-control", "placeholder"=>"Observación")); ?>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-default"><i class="fa fa-floppy-o"></i> Registrar</button>
					</div>
				<?php echo $this->Form->end(); ?>
				
			</div>
			
		</div>
	</div>
</div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
    
    	var id = ""
    	$(".camara").click(function(){
    		id = $(this).attr('id');
    		$("#CompaniesAttributeCompanyId").val(id);
    	})
 
    	$('.channel').multiselect({
    		nonSelectedText: 'Seleccione Canal',
    		buttonWidth: '520',
    		numberDisplayed : '6',
    		//checkboxName : 'canal[]'
    	});
    	
    	$('.link').multiselect({
    		nonSelectedText: 'Seleccione enlace',
    		buttonWidth: '520',
    		numberDisplayed : '6',
    		//checkboxName : 'enlace[]'
    	});
    	
    	$('.signal').multiselect({
    		nonSelectedText: 'Seleccione Señal',
    		buttonWidth: '520',
    		numberDisplayed : '6',
    		//checkboxName : 'señal[]'
    	});
    	
    	$('.payment').multiselect({
    		nonSelectedText: 'Seleccione pago',
    		buttonWidth: '520',
    		numberDisplayed : '6',
    		//checkboxName : 'pago[]'
    	});
    	
    	$("#CompaniesAttributeIndexForm").submit(function(e)
		{
			var postData = $(this).serializeArray();
			var formURL = $(this).attr("action");
			$.ajax(
			{
				url : formURL,
				type: "POST",
				data : postData,
				success:function(data, textStatus, jqXHR) 
				{
					if(data == 1)
					{
						$( ".close" ).trigger( "click" );
						$(".mensaje").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Detalle del servicio registrado correctamente</strong>.</div>');
					}
					
					if(data == 0 || data == "")
					{
						$( ".close" ).trigger( "click" );
						$(".mensaje").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Ocurrio un problema al querer registrar la información</strong>.</div>');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) 
				{
					if(data == 0 || data == "")
					{
						$( ".close" ).trigger( "click" );
						$(".mensaje").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Ocurrio un problema al querer registrar la información</strong>.</div>');
					}
				}
			});
		    e.preventDefault();	//STOP default action
		});
		
		//peticion ajax para recuperar los datos del servicio contratado
		 $(".serviciosContratados").click(function(event){
		 	var id = $(this).attr('id');
		 
		 if(id != "")
		 {
		 	$('#detalleServicioContratado').modal('show');
		 	
			$(".canales li").remove();
			
			$.ajax({ 
				type: 'GET', 
				url: '<?php echo $this->Html->url(array('controller'=>'companies', 'action'=>'detalleServiciosContratados'))?>', 
				data: { "id": id },
				dataType: "html",
				success: function (data) { 
					$('.detalle').html(data);
		        }
		    });
		 }
		 else
		 {
		 	$(".mensaje").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>No existe información para el detalle del Servicio</strong>.</div>');
		 }
		 
      });
    	
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
        });

        $(".contacto").click(function(){
        	id = $(this).attr('id');
        	$("#CompaniesContactoCompanyId").val(id);
        }) 
    });

	//peticion ajax para recuperar los datos del servicio contratado
	$(".listadoContactos").click(function(event){			
		 var id = $(this).attr('id');
		 if(id != "")
		 {		 				
			$.ajax({ 
				type: 'GET', 
				url: '<?php echo $this->Html->url(array('controller'=>'companies_contactos', 'action'=>'lista_contactos'))?>', 
				data: { "id": id },
				dataType: "html",
				success: function (data) {
					$('.listado').empty();				
					if($.trim(data)!==''){
						$('.listado').html(data);
					}
		        },
		        complete: function (){
		        	$('#listaContactos').modal('show');	
		        	$('.tool').tooltip();	 
		        	$('.btn-danger').html('<i class="fa fa-trash-o"></i>');	
		        	$("#tituloModal").text('Lista de Contactos');
		        }
		    });
		 }		 		 
      });
</script>