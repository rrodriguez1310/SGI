<div class="container">
  <div class='row'>
    <div class='col-md-4'></div>
    <div class='col-md-4'>
      <div class='col-md-12 form-group'>
        <h4><?php echo __('Agregar Dimensión'); ?></h4>
         <hr class="featurette-divider"></hr>
         <br/>
         <?php echo $this->Form->create('Dimensione'); ?>
        <div class='form-row'>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>Tipo dimensión:</label>
            <?php  echo $this->Form->input('tipos_dimensione_id', array("class"=>"selectDos form-control", "label"=>false, "options"=>$tiposDimensioneId, "empty"=>"")); ?>
          </div>
        </div>
        
        <div class='form-row'>
        	<?php //pr($area); ?>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>Área dimensión:</label>
            <?php  echo $this->Form->input('descripcion', array("class"=>"selectDos form-control", "label"=>false, 'options'=>$area, "empty"=>"")); ?>
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
            <label class='control-label'>Código dimensión:</label>
            <?php  echo $this->Form->input('codigo', array("class"=>"form-control", "label"=>false, 'type'=>'text')); ?>
          </div>
        </div>
        <div class='form-row'>
          <div class='col-xs-12 form-group required'>
            <label class='control-label'>Codigo corto dimensión:</label>
             <?php  //echo $this->Form->input('codigo_corto', array("class"=>"form-control", "label"=>false)); ?>
            <?php  echo $this->Form->input('codigo_corto', array("class"=>"form-control", "label"=>false, "options"=>$codigoCorto, "empty"=>"")); ?>
          </div>
        </div>

        <?php echo $this->Form->button('<i class="fa fa-floppy-o"></i> Guardar', array('class' => 'btn btn-primary btn-block')); ?>
      </div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		
		var tipoDimension = "";

		$("#DimensioneTiposDimensioneId").change(function(){
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
							$("#DimensioneCodigoCorto option[value="+data+"]").attr("selected","selected");
							
							//($("#DimensioneCodigoCorto").val(data);
							//$("#DimensioneCodigoCorto option:selected").val(data);
							//$('#DimensioneCodigoCorto option[value='+data+']').attr('selected','selected');
							//alert(data);
							//	alert(item.Codigo);
						}
					}
				);
			}
		});
		$(".selectDos").select2({
			placeholder: "Seleccione un valor",
			allowClear: true,
			width:'100%',
			language: "es",
		});
	});
</script>
