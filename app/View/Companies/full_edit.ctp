<div class="col-sm-offset-3 col-sm-8">
	<h4><?php echo __('Editar Empresa'); ?></h4>
</div>
<br/>
<div class="col-md-12 col-md-offset-1">
	<?php echo $this->Form->create('Company', array('id'=>'CompanyFullEditForm', 'class'=>'form-horizontal')); ?>
	<?php echo $this->Form->input('id'); ?>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label"><span class="aterisco">*</span>País: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('paise_id', array("type"=>"select", "class"=>"form-control requerido", "label"=>false, 'readonly'));?>
			</div>
		</div>	

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label baja"><span class="aterisco">*</span>Rut empresa: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('rut', array("class"=>"form-control requerido", "placeholder"=>"Ingrese Rut", "label"=>false, 'maxlength'=>'12' , 'readonly'));?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label baja"><span class="aterisco">*</span>Razón social: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('razon_social', array("class"=>"form-control requerido", "placeholder"=>"Ingrese Razón social", "label"=>false , 'readonly')); ?>
			</div>
		</div>

		<div  class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label baja"><span class="aterisco">*</span>Nombre de fantasía: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('alias', array('type'=>'text', "class"=>"form-control requerido", "placeholder"=>"Ingrese Nombre de fantasía", "label"=>false)); ?>
				<?php echo $this->Form->hidden('nombre'); ?>
			</div>
		</div>		

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Dirección: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('direccion', array("class"=>"form-control", "placeholder"=>"Calle, numero", "label"=>false));?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Comuna: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('comuna', array("type"=>"select", "class"=>"form-control", "label"=>false));?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Teléfono / fax: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('telefono', array("class"=>"form-control", "label"=>false, 'placeholder'=>'Ingrese teléfono'));?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Email empresa: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('email', array("class"=>"form-control minuscula cambia-minuscula", 'maxlength'=>'100', 'type'=>'text', 'id'=>'email', "label"=>false, 'placeholder'=>'Ingrese email empresa'));?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Banco: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('banco', array("class"=>"form-control ", "label"=>false, 'placeholder'=>'Ingrese Banco'));?>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Cuenta corriente: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('cuenta_corriente', array("class"=>"form-control ", "label"=>false, 'placeholder'=>'Ingrese cuenta corriente'));?>
			</div>
		</div>
		
		<div  class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label"><span class="aterisco">*</span>Tipo empresa: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('company_type_id', array("class"=>"select2 requerido" , 'multiple' =>"multiple" , "placeholder"=>"Ingrese Tipo compañía", "label"=>false));?>
			</div>
		</div>	

		<div class="form-group activo hide" id="idAgrupado">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Agrupado: </label>
			<div class="col-sm-5 baja">
				<?php echo $this->Form->input('activo', array('id' => 'agrupado', 'type'=>'checkbox', "class"=>"agrupado baja", "placeholder"=>"Ingrese Razon Social", "label"=>false, 'div'=> false));?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Observación: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->textArea('observacion', array("class"=>"form-control ", "label"=>false, 'placeholder'=>'Observación'));?>
			</div>
		</div>
		
		<div class="col-sm-offset-3 col-sm-8">
			<button class="btn btn-primary btn-lg" type="submit" ><i class="fa fa-pencil-square-o"></i> Actualizar</button>

		<?php echo $this->Form->end(); ?>
		
		<a href="<?php echo $this->Html->url(array("controller"=>"companies", "action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
		</div>		
	<!--button class="btn btn-info btn-lg" data-toggle="modal" data-target="#vistaPrevia"><i class="fa fa-eye"></i> Vista Previa</button-->	
</div>

<br/><br/><br/>

<script>

	var reglas = {
		"data[Company][email]":{required: false, regex: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/}
	};

	var mensajes = {
		"data[Company][email]":{regex:"formato de email incorrecto"}
	};

	$.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
    });
   
    $('#CompanyFullEditForm').validate({
	    submitHandler: function (form) {
	    	return true;
	    },
	    rules:reglas,
		messages:mensajes
	 });

     $('.requerido').each(function() {
	    $(this).rules('add', {
	        required: true,
	        maxlength: 500,
	        messages: {
	            required: "campo requerido",
	        }
	    });
	});

	function cargarComunas(){
		$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"comunas"))?>",
		    async: true,
		    dataType: "json",
		    beforeSend: function(){	    	
		    	$("#CompanyComuna option").remove();
		    	$("#CompanyComuna").append("<option value=''> </option>");
		    },
		    success: function( data ) {
				if(data != "")
				{	
					$.each(data, function(i, item){
						$("#CompanyComuna").append("<option value='"+item.Id+"'>" +item.Nombre+ "</option>");
					});
				}
			},
			complete:  function() {	

				$("#CompanyComuna").select2({
					placeholder: "Seleccione una comuna",
					allowClear: true,
					width:'100%',
				});

				$("#CompanyComuna").select2("val",'<?php echo $this->Form->data["Company"]["comuna"]?>');
			}				
		});
	}	



    $(".error").css("color", "#AE0505");

    $("#CompanyAlias").change(function(){
		$("#CompanyNombre").val($(this).val());
	});
	
    js_arr = '<?php echo JSON_encode($this->Form->data["Company"]["company_type_id"]); ?>';
   
    if($.inArray("1",js_arr) >= 0) {
    	$("#idAgrupado").removeClass("hide").addClass("show");
    }

    $(".select2").select2({
		placeholder: "Seleccione tipo de Empresa",
		allowClear: true,
		width:'100%',
	});
			
	$(".select2").change(function () {
		if($(this).is("select")){
			var arr = $.trim($(this).val());
			if($.inArray("1",arr)>=0){					//Op. TV Paga
				if($("#idAgrupado").css("display")=='none'){
					$("#agrupado").prop('checked',true);
				}
				$("#idAgrupado").removeClass("hide").addClass("show");
			} else {
				$("#agrupado").prop('checked',false);
				$("#idAgrupado").removeClass("show").addClass("hide");
			}
		}
	});
	
	function cargarPaises(){
		$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"paises"))?>",
		    async: true,
		    dataType: "json",
		    beforeSend: function(){
		    	$("#CompanyPaiseId option").remove();
		    	$("#CompanyPaiseId").append("<option value=''> </option>");
		    },
		    success: function( data ) {	    		    	
				if(data != "")
				{	
					$.each(data, function(i, item){					
						$("#CompanyPaiseId").append("<option value='"+item.Id+"'>" +item.Nombre+ "</option>");
					});
				}		    	
		    },
			complete:  function() {
				
				$("#CompanyPaiseId").select2({
					placeholder: "Seleccione un país",
					allowClear: true,
					width:'100%',
				});
				
				$("#CompanyPaiseId").select2("val",'<?php echo $this->Form->data["Company"]["paise_id"]?>');

				$("#CompanyPaiseId").prop("disabled", true);
			}
		});
	}
	
	cargarComunas();
	cargarPaises();

</script>