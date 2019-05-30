<div class="form-horizontal">
	<div class="companiesContactos form">		
		<?php echo $this->Form->create(null); ?>	
			<fieldset>
				<div id="cuerpo" class="modal-scrolling col-sm-12">
					<div>
						<label for="ddi" class="col-sm-3 control-label baja"><span class="aterisco">*</span>Nombre: </label>
						<div class="col-xs-8">							
							<?php echo $this->Form->input('nombre', array("class"=>"form-control mayuscula cambia-mayuscula solo-letras","label"=>false, 'maxlength'=>'1000','id'=>'nombre', "required"));?>
						</div>
					</div>

					<div>
						<label for="ddi" class="col-sm-3 control-label baja"><span class="aterisco">*</span>Apellido Paterno: </label>
						<div class="col-xs-8">
							<?php echo $this->Form->input('apellido_paterno', array("class"=>"form-control mayuscula cambia-mayuscula solo-letras", "label"=>false, 'maxlength'=>'100','id'=>'apellidoPaterno', "required"));?>
						</div>
					</div>

					<div>
						<label  for="ddi" class="col-sm-3 control-label baja col-xs-8">Apellido Materno: </label>
						<div class="col-xs-8">
							<?php echo $this->Form->input('apellido_materno', array("class"=>"form-control mayuscula cambia-mayuscula solo-letras", "label"=>false, 'maxlength'=>'100','id'=>'apellidoMaterno'));?>
						</div>
					</div>

					<div>
						<label for="ddi" class="col-sm-3 control-label baja">Cargo: </label>
						<div class="col-xs-8">
							<?php echo $this->Form->input('cargo', array("class"=>"form-control mayuscula cambia-mayuscula", "label"=>false, 'maxlength'=>'50','id'=>'cargo', ));?>
						</div>
					</div>

					<div>
						<label for="ddi" class="col-sm-3 control-label baja">Email: </label>
						<div class="col-xs-8">
							<?php echo $this->Form->email('email', array("class"=>"form-control minuscula cambia-minuscula", "label"=>false, 'maxlength'=>'100','id'=>'email', 'type'=>'text',  'pattern' => "[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" , 'placeholder'=>"Ej. tu@email.com") );?>
						</div>
					</div>

					<div>
						<label for="ddi" class="col-sm-3 control-label baja">Telefono fijo: </label>
						<div class="col-xs-8">
							<?php echo $this->Form->input('telefono_fijo', array("class"=>"form-control", "placeholder"=>"Ej. 562-22222222", "label"=>false, 'maxlength'=>'15','id'=>'telefono' ));?>
						</div>
					</div>

					<div>
						<label for="ddi" class="col-sm-3 control-label baja">Celular: </label>
						<div class="col-xs-8">
							<?php echo $this->Form->input('telefono_celular', array("class"=>"form-control", "placeholder"=>"Ej. 0-87654321", "label"=>false, 'maxlength'=>'15','id'=>'celular'));?>
						</div>
					</div>
			
					<div>
						<label for="ddi" class="col-sm-3 control-label baja">Observaciones: </label>
						<div class="col-xs-8">
							<?php echo $this->Form->textarea('observacion', array("class"=>"form-control requerido", "label"=>false, 'maxlength'=>'300','id'=>'observacion'));?>
						</div>
					</div>
					<div>
						<?php echo $this->Form->hidden('company_id', array("type"=>"text", "default"=>$empresaId));?>	
						<?php echo $this->Form->hidden('estado', array("default"=>$estado));?>
					</div>		
				</div>			
			</fieldset>
			<div class="modal-footer">
				<div class="text-right">
					<input type="submit" class="btn btn-primary" value="Guardar" />
					<!--button type="submit" class="btn btn-primary guardar">Guardar</button-->
					<button id="<?php echo $empresaId;?>" type="button" class="volverListadoContactos btn btn-default">Cancelar</button>
				</div>	
			</div>
		<?php $this->form->end(); ?>
	</div>
</div>
<script>
	

    $(document).ready (function(){

    	var reglas = {
			"data[CompaniesContacto][nombre]": {required:true},
			"data[CompaniesContacto][apellido_paterno]": {required:true},
			"data[CompaniesContacto][email]":{required: false, regex: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/},
		};

		var mensajes = {
			"data[CompaniesContacto][nombre]": {required:"campo requerido"},
			"data[CompaniesContacto][apellido_paterno]":{required:"campo requerido"},
			"data[CompaniesContacto][email]":{regex:"formato de email incorrecto"},
		};
			
		$(".cambia-mayuscula").bind('keyup', function (e) {
		    $(this).val(($(this).val()).toUpperCase());
		});

		$(".cambia-minuscula").bind('keyup', function (e) {
		    $(this).val(($(this).val()).toLowerCase());
		});

		$.validator.addMethod(
	        "regex",
	        function(value, element, regexp) {
	            var re = new RegExp(regexp);
	            return this.optional(element) || re.test(value);
	    });

		$("#CompaniesContactoAddForm").validate ({
			rules:reglas,
			messages:mensajes
		}); 

		$(".solo-letras").keypress(function(event){
	        tecla = (document.all) ? event.keyCode : event.which; 
	   		if (tecla==8||tecla==32||tecla==39||tecla==127) return true; // backspace || espacio || comilla simple  || supr'
			if (event.ctrlKey && tecla==86) { return true;} //Ctrl v
			if (event.ctrlKey && tecla==67) { return true;} //Ctrl c
			if (event.ctrlKey && tecla==88) { return true;} //Ctrl x
			patron = /[a-zA-Z\sñÑáéíóúÁÉÍÓÚ]/; //patron	 
			te = String.fromCharCode(tecla); 
			return patron.test(te); // prueba de patron            
	        event.preventDefault();
    	});

    	$("#CompaniesContactoAddForm").submit( function(e)
		{
			var	erroresEnPantalla = $('#CompaniesContactoAddForm').find('.error').css("display");
			
			if(erroresEnPantalla != "block")
			{
				$.ajax({
				    type: "POST",
				    url: "<?php echo $this->Html->url(array('controller' => 'companies_contactos', 'action' => 'add')); ?>",
				    data: $("#CompaniesContactoAddForm").serialize(),
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
			}

			e.preventDefault();	
			//return false;
		});

		//peticion ajax para recuperar los datos del servicio contratado
	$(".volverListadoContactos").click(function(event){			
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


	});	
</script>