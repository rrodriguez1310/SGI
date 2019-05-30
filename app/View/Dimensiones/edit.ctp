<div class="container">
  <div class='row'>
    <div class='col-md-4'></div>
    <div class='col-md-4'>
      <div class='col-md-12 form-group'>
        <h4><?php echo __('Editar Dimensión'); ?></h4>
         <hr class="featurette-divider"></hr>
         <br/>
         <?php echo $this->Form->create('Dimensione'); ?>
         <?php  echo $this->Form->input('id'); ?>
         <!--form accept-charset="UTF-8" action="/" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="pk_bQQaTxnaZlzv4FnnuZ28LFHccVSaj" id="payment-form" method="post"-->
        <div class='form-row'>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>Tipo dimension:</label>
            <?php  echo $this->Form->input('tipos_dimensione_id', array("class"=>"form-control selectDos", "label"=>false, "options"=>$tiposDimensioneId)); ?>
          </div>
        </div>
        
        <div class='form-row'>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>Área dimensión:</label>
            <?php  echo $this->Form->input('descripcion', array("class"=>"selectDos form-control", "label"=>false, 'options'=>$area, 'default'=>$descripcion)); ?>
          </div>
        </div>
		
		<div class='form-row'>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>Nombre dimensión:</label>
            <?php  echo $this->Form->input('nombre', array("class"=>"form-control", "label"=>false)); ?>
          </div>
        </div>
		
        <div class='form-row'>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>Codigo dimensión:</label>
            <?php  echo $this->Form->input('codigo', array("type"=>"text", "class"=>"form-control", "label"=>false)); ?>
          </div>
        </div>
       
        <div class='form-row'>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>Codigo corto dimensión:</label>
 
            <?php  echo $this->Form->input('codigo_corto', array("class"=>"selectDos form-control", "label"=>false, "options"=>$codigoCorto, 'default'=>$codigo)); ?>
          </div>
        </div>

        <?php echo $this->Form->button('<i class="fa fa-floppy-o"></i> Guardar', array('class' => 'btn btn-primary btn-block')); ?>
      </div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$(".selectDos").select2({
			allowClear: true,
			width:'100%',
			language: "es",
		});
	
		var tipoDimension = "";
		
		$("#DimensioneDescripcion").change(function(){
			if($("#DimensioneTiposDimensioneId").val() == 1)
			{
				tipoDimension = $("#DimensioneTiposDimensioneId").val();
			}
			
			//$("#DimensioneDescripcion option").remove();
			$.get("<?php echo $this->Html->url(array("action"=>"lista_tipo_dimension"))?>",{descripcion: $("#DimensioneTiposDimensioneId").val()}).done(
				function(data){
					if(data != "")
					{
						$.each(data, function(key, item) 
						{
							if(key === 0)
							{
								$("#DimensioneCodigo").val(item.Codigo);
							}
							//$("#DimensioneDescripcion").append("<option value='"+item.Nombre+"'>"+item.Nombre+"</option>");
						});
					}
				}
			);
		});
	
		$("#DimensioneDescripcion").change(function(){
			if(tipoDimension == 1)
			{
				$.get("<?php echo $this->Html->url(array("action"=>"codigo_corto_json"))?>",{descripcion: $("#DimensioneDescripcion").val()}).done(
					function(data){
						if(data != "")
						{
							$("#DimensioneCodigoCorto").val(data);
						}
					}
				);
			}
		});
	});
</script>
