<div class="col-sm-offset-3 col-sm-8">
	<h4><?php echo __('Editar Empresa'); ?></h4>
</div>
<br/>
<div class="col-md-12 col-md-offset-1">
	<?php echo $this->Form->create('Company', array('type'=>'file', 'id'=>'CompanyEditForm','class'=>'form-horizontal')); ?>
	<?php echo $this->Form->input('id'); ?>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label"><span class="aterisco">*</span>País: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('paise_id', array("type"=>"select", "class"=>"form-control requerido valida_pais", "label"=>false));?>
			</div>
		</div>	
	
		<div  class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label baja"><span class="aterisco" id="spanRut">*</span>Rut empresa: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('rut', array("class"=>"form-control requerido", "placeholder"=>"Rut", "label"=>false, 'maxlength'=>'12'));?>
			</div>
		</div>

		<div  class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label baja"><span class="aterisco">*</span>Razón social: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('razon_social', array("class"=>"form-control requerido", "placeholder"=>"Razon social", "label"=>false)); ?>
			</div>
		</div>

		<div  class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label baja"><span class="aterisco">*</span>Nombre de fantasía: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('alias', array('type'=>'text',  "class"=>"form-control requerido", "placeholder"=>"Nombre de fantasía", "label"=>false)); ?>
				<?php echo $this->Form->hidden('nombre'); ?>
			</div>
		</div>					
		
		<div  class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label"><span class="aterisco">*</span>Tipo empresa: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('company_type_id', array("class"=>"select2 requerido" , 'multiple' =>"multiple" , "placeholder"=>"Tipo compañía", "label"=>false));?>
			</div>
		</div>	
		
		<div class="form-group uploadFile" >
			<label for="inputPassword3" class="col-sm-3 control-label baja">Seleccione archivo: </label>
			
			<div class="col-sm-5">
				<?php echo $this->Form->input('archivo', array('type'=>'file', "class"=>" ", "label"=>false, 'placeholder'=>'Seleccione archivo'));?>
			</div>
		</div>

		<div class="col-sm-offset-3 col-sm-8">
			<button class="btn btn-primary btn-lg" type="submit"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
			<a href="<?php echo $this->Html->url(array("controller"=>"companies", "action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
			<?php echo $this->Form->end(); ?>
		</div>
	<!--button class="btn btn-info btn-lg" data-toggle="modal" data-target="#vistaPrevia"><i class="fa fa-eye"></i> Vista Previa</button-->	
</div>

<br/><br/><br/>

<script>

	$('#CompanyEditForm').validate({
	    submitHandler: function (form) {
	    	return true;
	    }
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

	$(".error").css("color", "#AE0505");

	$(".select2").select2({
		placeholder: "Seleccione tipo de Empresa",
		allowClear: true,
		width:'100%',
	});
		
	/* $('#CompanyRut').Rut({
		on_error: function () {
			$("#CompanyRut").val("").focus();
			alert('Rut incorrecto');
		},
		format_on: 'keyup'
	});*/

	$("#CompanyAlias").change(function(){
		$("#CompanyNombre").val($(this).val());
	});

	if($("#CompanyPaiseId").val()=='46'){
		var rut = $(this).val();			
		rut = rut.split('.').join('');	
		rut = rut.split('-').join('');
		$("#CompanyRut").val($.Rut.formatear(rut,rut.substring(rut.length-1, rut.length)).toUpperCase());
	}	

	function cargarPaises(){
		$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array('controller'=>'servicios', 'action'=>'paises'))?>",
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

				$(".valida_pais").change();
			}
		});
	}

	$("#CompanyRut").keyup(function (){
		if($("#CompanyPaiseId").val()=='46'){
			var rut = $(this).val();			
			rut = rut.split('.').join('');	
			rut = rut.split('-').join('');	
			$("#CompanyRut").val($.Rut.formatear(rut,rut.substring(rut.length-1, rut.length)).toUpperCase());
		}		
	});

	$("#CompanyRut").blur(function (){
		if($("#CompanyPaiseId").val()=='46' && $.trim($(this).val())!==''){
			var rut = $(this).val();			
			rut = rut.split('.').join('');	
			rut = rut.split('-').join('');	
			$("#CompanyRut").val($.Rut.formatear(rut,rut.substring(rut.length-1, rut.length)).toUpperCase());

			if(!$.Rut.validar($("#CompanyRut").val())){
	    		$("#CompanyRut").val("").focus();
	    		alert('Rut incorrecto');
	    	}
		}
	});

	$(".valida_pais").change(function(){

		var pais = $('#CompanyPaiseId').val();

		if(pais!==''){
			if(pais==='46'){ // Chile
				$('#CompanyRut').addClass("requerido");				
				$("#CompanyRut").rules('add', {
			        required: true,
			        maxlength: 500,
			        messages: {required: "campo requerido"}
			    });
			    $('#spanRut').removeClass("hide");
			    $('#CompanyRut').attr("required");
			    $("#CompanyRut").blur();

			}else{

				$('#CompanyRut').removeClass("requerido");
				$('#CompanyRut').removeAttr("required");
				$("#CompanyRut").rules("remove");
				$('#spanRut').addClass("hide");
				$('#CompanyRut-error').addClass("hide");
			}

			$('#CompanyPaiseId-error').addClass("hide");
		}else{
			$('#CompanyPaiseId-error').removeClass("hide");
		}



	});

	cargarPaises();	
	
</script>
