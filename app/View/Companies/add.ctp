<div class="col-sm-offset-3 col-sm-8">
	<h4><?php echo __('Registrar Empresa'); ?></h4>
</div>
<br/>
<div class="col-md-12 col-md-offset-1">
		<?php echo $this->Form->create('Company', array('type'=>'file', 'class' => 'form-horizontal')); ?>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label"><span class="aterisco">*</span>País: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('paise_id', array("type"=>"select", "class"=>"form-control requerido valida_pais", "label"=>false));?>
			</div>
		</div>	

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label baja"><span class="aterisco" id="spanRut">*</span>Rut: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('rut', array("class"=>"form-control requerido", "placeholder"=>"Rut", "label"=>false, 'maxlength'=>'12'));?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja"><span class="aterisco">*</span>Razón social: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('razon_social', array("class"=>"form-control requerido", "placeholder"=>"Razón Social", "label"=>false)); ?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja"><span class="aterisco">*</span>Nombre de fantasia: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('alias', array('type'=>'text',  "class"=>"form-control requerido", "placeholder"=>"Nombre de Fantasia", "label"=>false)); ?>
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
				<?php echo $this->Form->input('telefono', array("class"=>"form-control", "label"=>false, 'placeholder'=>'Teléfono'));?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Email empresa: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('email', array("class"=>"form-control minuscula cambia-minuscula", 'maxlength'=>'100', 'type'=>'text', 'id'=>'email', "label"=>false, 'placeholder'=>'Email empresa'));?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Banco: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('banco', array("class"=>"form-control ", "label"=>false, 'placeholder'=>'Banco'));?>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Cuenta corriente: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('cuenta_corriente', array("class"=>"form-control ", "label"=>false, 'placeholder'=>'Cuenta corriente'));?>
			</div>
		</div>

		<!-- cambios -->
		<div class="form-group company_id">
			<label for="inputPassword3" class="col-sm-3 control-label"><span class="aterisco">*</span>Tipo(s) de empresa: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('company_type_id', array("class"=>"select2 requerido", 'multiple' =>"multiple", "placeholder"=>"Tipo(s) de empresa", "label"=>false));?>
			</div>
		</div>
		
		<div class="form-group uploadFile esconde" >
			<label for="inputPassword3" class="col-sm-3 control-label baja">Seleccione archivo: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('archivo', array('type'=>'file', "class"=>" ", "label"=>false, 'placeholder'=>'Seleccione archivo'));?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Observación: </label>
			<div class="col-sm-5">
				<?php echo $this->Form->input('observacion', array("type"=>"textarea", "class"=>"form-control ", "label"=>false, 'placeholder'=>'Observación'));?>
			</div>
		</div>

		<!-- fin cambios -->

		<div class="form-group activo hide" id="idAgrupado">
			<label for="inputPassword3" class="col-sm-3 control-label baja">Agrupado: </label>
			<div class="col-sm-5 baja">
				<?php echo $this->Form->input('activo', array('id' => 'agrupado', 'type'=>'checkbox', "class"=>"agrupado baja", "placeholder"=>"Razon Social", "label"=>false, 'div'=> false));?>
			</div>
		</div>
		
		

		<div>
			<div class="col-sm-offset-3 col-sm-8">
				<button class="btn btn-primary btn-lg" type="submit"><i class="fa fa-pencil"></i> Registrar</button>
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
</div>
<br/><br/><br/>
<script>

	var reglas = {
		"data[Company][email]":{required: false, regex: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/},
	};

	var mensajes = {
		"data[Company][email]":{regex:"formato de email incorrecto"},
	};

	$.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
    });
	//$("#CompanyTelefono").mask("(99) 9999-9999");
	function cargarComunas(){
		$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array('controller'=>'servicios', 'action'=>'comunas'))?>",
		    async: true,
		    dataType: "json",
		    success: function( data ) {		

		    	$("#CompanyComuna option").remove();
		    	$("#CompanyComuna").append("<option value=''> </option>");  

				if(data != "")
				{	
					$.each(data, function(i, item){
						$("#CompanyComuna").append("<option value='"+item.Id+"'>" +item.Nombre+ "</option>");
					});
				}
		    },
		    complete: function(){
		    	$("#CompanyComuna").select2({
					placeholder: "Seleccione una comuna",
					allowClear: true,
					width:'100%',
				});
		    }
		});
	}

	$(".error").css("color", "#AE0505");

	$('#CompanyRut').focusout(function(){
		var rutEmpresa = $.trim($('#CompanyRut').val());
		if(rutEmpresa!=='' && $("#CompanyPaiseId").val()=='46'){
			var rut = $(this).val();
			rut = rut.split('.').join('');
			rut = rut.split('-').join('');
			$("#CompanyRut").val($.Rut.formatear(rut,rut.substring(rut.length-1, rut.length)).toUpperCase() );
			rutEmpresa = $('#CompanyRut').val();
			$.get("<?php echo $this->Html->url(array('controller'=>'servicios', 'action'=>'valida_rut')); ?>",{'rutEmpresa':rutEmpresa},function(data,status){
				if(data == 1)
				{
					alert("El rut ya esta registrado!!!"); ///aqui
					$('#CompanyRut').val("").focus();
				}
  			});	
		}
	});

	$('#CompanyAddForm').validate({
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
/*
	$('.noRequerido').each(function() {
	    $(this).rules('add', {
	        required: true,
	        maxlength: 500,
	        messages: {
	        required: "campo requerido",
	        }
	    });
	});
*/
	var estado = <?php echo $escondeEstado; ?>;

	if(estado == 1)									// vista solo Proveedor
	{	
		$("#CompanyCompanyTypeId").val(2);			// Proveedor
		$("#CompanyCompanyTypeId").prop("readonly","readonly");
		$("#agrupado").prop('checked',false);
	}

	function cargarPaises(){
		$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array('controller'=>'servicios', 'action'=>'paises'))?>",
		    async: true,
		    dataType: "json",
		    success: function(data){	
		    	$("#CompanyPaiseId option").remove();
		    	$("#CompanyPaiseId").append("<option value=''></option>");	    	
				if(data != "")
				{	
					$.each(data, function(i, item){					
						$('#CompanyPaiseId').append("<option value='"+item.Id+"'>" +item.Nombre+ "</option>");
					});
				}
		    },
		    complete: function(){

		    	$("#CompanyPaiseId").select2({
					placeholder: "Seleccione un país",
					allowClear: true,
					width:'100%',
				});

				$("#CompanyPaiseId").select2("val",'46');		//Chile
		    }
		});
	}

	$("#CompanyRazonSocial").change(function(){
		$("#CompanyAlias").val($(this).val());
		$("#CompanyNombre").val($(this).val());
	});

	$("#CompanyAlias").change(function(){
		$("#CompanyNombre").val($(this).val());
	});

	$(".select2").select2({
		placeholder: "Seleccione tipo de Empresa",
		allowClear: true,
		width:'100%',
	});
			
	$(".select2").change(function () {
		if($(this).is("select")){
			var arr = $.trim($(this).val());
			if( $(this).val() == 1 || $(this).val() == 2){
				
				$('.uploadFile').css('display', 'block')
			}else{
				$('.uploadFile').css('display', 'none')
			}
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

	$('#CompanyActivo').attr('checked',true);

	$("#CompanyRut").keyup(function (){
		if($("#CompanyPaiseId").val()=='46'){
			var rut = $(this).val();			
			rut = rut.split('.').join('');	
			rut = rut.split('-').join('');	
			$("#CompanyRut").val($.Rut.formatear(rut,rut.substring(rut.length-1, rut.length)).toUpperCase() ); 
		}		
	});

	$("#CompanyRut").blur(function (){
		if($("#CompanyPaiseId").val()=='46' && $.trim($(this).val())!==''){
			var rut = $(this).val();			
			rut = rut.split('.').join('');	
			rut = rut.split('-').join('');	
			$("#CompanyRut").val($.Rut.formatear(rut,rut.substring(rut.length-1, rut.length)).toUpperCase() );

			if(!$.Rut.validar($("#CompanyRut").val())){
	    		$("#CompanyRut").val("").focus();
	    		alert('Rut incorrecto');
	    	}
		}
	});

	$(".valida_pais").change(function(){
		if($('#CompanyPaiseId').val()!==''){
			var pais = $(this).val();
			if(pais=='46'){				// Chile
				$('#CompanyRut').addClass("requerido");		
				$("#CompanyRut").rules('add', {
			        required: true,
			        maxlength: 500,
			        messages: {required: "campo requerido"}
			    });
			    $('#spanRut').removeClass("hide");
			    $('#CompanyRut').attr("required");
			    $("#CompanyRut").blur();
			    $("#CompanyComuna").prop("disabled", false);
			    $("#CompanyComuna").select2({
			    	placeholder: "Seleccione una comuna",
			    	allowClear: true,
					width:'100%'
				});
			}else{

				$('#CompanyRut').removeClass("requerido");
				$('#CompanyRut').removeAttr("required");
				$("#CompanyRut").rules("remove");
				$('#spanRut').addClass("hide");
				$('#CompanyRut-error').addClass("hide");
				$("#CompanyComuna").prop("disabled", true);
				$("#CompanyComuna").select2({placeholder: ""});
			}	

			$('#CompanyPaiseId-error').addClass("hide");

		}else{
			$('#CompanyPaiseId-error').removeClass("hide");
		}
	});

	cargarPaises();

	cargarComunas();

</script>
