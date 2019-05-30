<div ng-controller="ListaEmpresas" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<?php echo $this->element('botonera'); ?>

		<div>
			<br>	
			<div id="ListaEmpresas" ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
		</div>
	</div>

	<div class="modal fade" id="detalleServicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		    <div class="modal-content">	   	   
		    	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        <h4 class="modal-title" id="myModalLabel">Registrar Servicio</h4>
			  	</div>		
				   	<div class="modal-body">	
				   	<div class="mensaje"></div>
				   	<?php echo $this->Form->create('CompaniesAttribute',array('url' =>array('controller'=>'companiesAttributes', 'action'=>'add')), array('class'=>'form-inline'));?>      		
				      	<div class="col-md-12">
								<div class="form-group">
									<?php echo $this->Form->hidden('company_id', array('label'=>false)); ?>
						  		</div>			  		
						  		<div class="form-group">
									<label class="sr-only" for="channel_id">Email address </label>
									<?php echo $this->Form->input('channel_id', array('label'=>false, 'class'=>'multiselect channel', "multiple"=>"multiple")); ?>
						  		</div>			  		
						  		<div class="form-group">
									<label class="sr-only" for="link_id">Email address</label>
									<?php echo $this->Form->input('link_id', array('label'=>false, 'class'=>'multiselect link', "multiple"=>"multiple")); ?>
						  		</div>
						  		
						  		<div class="form-group">
									<label class="sr-only" for="signal_id">Email address</label>
									<?php echo $this->Form->input('signal_id', array('label'=>false, 'class'=>'multiselect signal', "multiple"=>"multiple")); ?>
						  		</div>			  		
						  		<div class="form-group">
									<label class="sr-only" for="payment_id">Email address</label>
									<?php echo $this->Form->input('payment_id', array('label'=>false, 'class'=>'multiselect payment', "multiple"=>"multiple")); ?>
						  		</div>
				      	</div>
					</div>						
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary registraAtributos"> Registrar</button>
	  			</div>
	      		<?php echo $this->Form->end(); ?>	
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
				<div class="modal-body detalle"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
		  	</div>      
		</div>
	</div> 

	<div class="modal fade" id="listaContactos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	  <div class="modal-dialog modal-grande">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title" id="tituloModal">Lista de Contactos</h4>
	      </div>
	      <div class="modal-body listado"></div>
	  	</div> 
	  </div>
	</div>
</div>

<div ng-controller="ListaMensajes" >
	<div class="modal fade" id="listaComentarios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-grande">
			<div class="modal-content" data-keyboard="false" data-backdrop="static">
				<div class="modal-header">					
					<h4 class="modal-title" id="tituloModalComment">Bitácora </h4>
				</div>
				<div id="bodyComentarios" class="modal-body" style="padding: 10px !important">					
					<div ng-show="listado">				
						<?php echo $this->element("buscador_grid"); ?>	
						<p ng-bind-html="cargador" ng-show="loaderComentarios"></p>	
						<div ng-if="listadoMensajes">							
							<div id="gridMensajes" ui-grid="gridOptions" ui-grid-selection ui-grid-pinning ui-grid-expandable class="grid2"></div>
						</div>				
						<div class="modal-footer"> 
							<div class="text-right"> 	
								<button type="button" class="btn btn-primary" ng-click="agregarComentario(id)" id="{{id}}" >
									<i class="fa fa-plus-square-o"></i> Ingresar 
								</button>							
								<button type="button" class="btn btn-default" data-dismiss="modal" ng-click="searchMensajes=''">Cancelar</button>
							</div>
						</div>
					</div>
					<div ng-show="agregar" class="form-horizontal" style="min-height:455px !important">
						<form name="addComentarioForm">		
							<input type="hidden" value="<?php echo $this->Session->Read('PerfilUsuario.idUsuario')?>" id="user_id" ng-model="user_id" />

							<div class="form-group">
								<label for="nombre" class="col-xs-3 control-label baja">Empresa: </label>
								<div class="col-xs-8">
									<input type="text" value="{{nombreCompania}}" class="form-control" readonly />
								</div>				
							</div>

							<div class="form-group">
								<label for="contacto" class="col-xs-3 control-label">Contacto: </label>
								<div class="col-xs-8">
									<select id="contacto" class="form-control" name="contacto" ng-model="contacto" ng-options="contacto.nombre_completo for contacto in listaContacto">
										<option value="">-- seleccione --</option>
									</select>
								</div>								
							</div>						

							<div class="form-group">
								<label for="clasificacion" class="col-xs-3 control-label"><span class="aterisco">*</span>Clasificación: </label>
								<div class="col-xs-8">
									<select id="clasificacion" class="form-control" name="clasificacion" ng-model="clasificacion" ng-options="clasificacion.clasificacion for clasificacion in nombreClasificacion" required>
										<option value="">-- seleccione --</option>
									</select>
								</div>	
							</div>

							<div class="form-group">
								<label for="mensaje" class="col-xs-3 control-label baja"><span class="aterisco">*</span>Información: </label>
								<div class="col-xs-8">
									<textarea id="mensaje" type="text" class="form-control" name="mensaje" ng-model="mensaje"  maxlength="1000" required></textarea> (quedan {{1000 - addComentarioForm.mensaje.$viewValue.length}} caracteres)
								</div>								
							</div>
							
							<div class="form-group">
								<label for="archivo" class="col-xs-3 control-label baja">Adjuntar archivo: <br/> (Max. 2MB)</label> 
								<div class="col-xs-9" style="display:inline">
								    <button class="btn btn-success" style="width:110px" ngf-select ngf-multiple="multiple" name="archivo" ngf-change="settingFile(archivo)" id="archivo" ng-model="archivo">Examinar...</button>&nbsp;
								    <label class="control-label baja" ng-if="setFile" style="font-weight: normal !important;">
								    	{{nombreArchivo}} {{sizeArchivo}}&nbsp;&nbsp;
								    	<a hre="#" class="btn btn-xs" ng-click="eliminarArchivo(archivo)">
								    		<i class="fa fa-times"></i>
								    	</a>
								    </label>
								</div>
							</div>

							<label class="col-sm-offset-3 error" ng-if="alerta">{{msjError}}</label>

							<div class="modal-footer"> 
								<div class="text-right"> 	
									<button type="button" class="btn btn-primary" ng-click="upload(id, archivo)" ng-disabled="addComentarioForm.$invalid">
										<i class="fa fa-plus-square-o"></i> Guardar
									</button>
									<button type="button" class="btn btn-default" ng-click="volverComentarios(id)">Cancelar</button>
									<!--button type="button" class="btn btn-default" data-dismiss="modal" ng-click="searchMensajes='';listado=true;agregar=false">Cerrar</button-->
								</div>
							</div>

						</form>		

					</div>														
				</div>   

			</div>
		</div>
	</div>
</div>	

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/lista_empresas',
		'angularjs/servicios/lista_empresas',
		'bootstrap-multiselect',
	));	
?>
<script type="text/javascript">

$(document).ready(function() {

	var id = "";
	$(".camara").click(function(){
		id = $(this).attr('id');
		$("#CompaniesAttributeCompanyId").val(id);
	});

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
			async: true,
			data : postData,
			success:function(data) 
			{	
				if(data == 1)
				{			
					$(".mensaje").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Detalle del servicio registrado correctamente</strong>.</div>');

					$(".alert-success").delay(3000).slideUp(600, function() {
					   		$(this).alert('close');
						});
				}else if(data == 0 || data == "")
					{
						$(".mensaje").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Ocurrio un problema al querer registrar la información</strong>.</div>');

						$(".alert-danger").delay(3000).slideUp(600, function() {
					   		$(this).alert('close');
						});
					}else{
						$(".modal-content").html(data);
					}
			},
		});
	    e.preventDefault();	//STOP default action
	});
	
	//peticion ajax para recuperar los datos del servicio contratado
	 $(".serviciosContratados").click(function(event)
	 {
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
	
    $(".contacto").click(function(){
    	id = $(this).attr('id');
    	$("#CompaniesContactoCompanyId").val(id);
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

	$(".panel-default").removeClass("hide");

});	

$('.serviciosContratados').attr("href", "#");
$('.camara').attr("href", "#");
$('.camara').attr("data-target", "#detalleServicio");
$('.camara').attr("data-toggle", "modal");
var idabonados = $('.ver_abonados').attr("id");
	
</script>