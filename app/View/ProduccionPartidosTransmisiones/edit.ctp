<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Editar Información de Transmisión</h3>
      </div>
      <div class="panel-body">
      	<h5 class="bold">Detalle Partido</h5>
      	<table class="table">
		<tr>
			<th>Equipo Local</th>
			<th>Equipo Visita</th>
			<th>Estadio</th>
			<th>Inicio Partido</th>                        
			<th>Campeonato</th>
		</tr>
		<tr>
			<td><?php echo $data["Equipo"]["alias_nombre"]?></td>
			<td><?php echo $data["EquipoVisita"]["alias_nombre"]?></td>
			<td><?php echo $data["Estadio"]["nombre"]?></td>
			<td><?php echo $data["ProduccionPartidosEvento"]["fecha_partido"].' '.$data["ProduccionPartidosEvento"]["hora_inicio_partido"]?></td>
			<td><?php echo $data["Campeonato"]["nombre"]?></td>
		</tr>
      	</table>
      	<br>
        <?php echo $this->Form->create('ProduccionPartidosTransmisione'); ?>
        <?php echo $this->Form->hidden('id', array("type"=>"text", "default"=>$idTransmision));?>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
				<label>Ingrese Operador MCR</label>
				<div class="form-group">
					<?php echo $this->Form->input('operador_mcr', array("label"=>false, "class"=>"form-control ", "options"=>$operadoresMcr, "empty"=>"", 'multiple'=> 'true', 'required'=> 'true', "id"=> "operador_mcr")); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6">
				<label>Ingrese Director Continuidad</label>
				<div class="form-group">
					<?php echo $this->Form->input('operador_continuidad', array("label"=>false, "class"=>"form-control ", "options"=>$operadoresContinuidad, "empty"=>"", 'multiple'=> 'true', 'required'=> 'true',  "id"=> "operador_continuidad")); ?>
				</div>
			</div>
        </div>
        <div class="form-horizontal">
          	<div class="form-group">
          		<label for="Fecha" class="col-sm-3 control-label baja">Fecha transmisión </label>
          		<div class="col-sm-5">
                	<?php echo $this->Form->input('fecha_transmision', array( "type"=> 'text' ,"class"=>"form-control requerido readonly-pointer-background", "label"=>false, "id"=> "Fecha"));?>
				</div>
        	</div>

        	<div class="form-group">
				<label for="hora_transmision" class="col-sm-3 control-label baja">Hora inicio transmisión </label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('hora_transmision', array("type"=> 'text' ,"class"=>"form-control requerido", "label"=>false, "id"=> "hora_transmision"));?>
				</div>
	            <div class="col-sm-2">
					<!--p class="text-muted small" id="hora_transmision_gmt_p" style="margin-top: 18px"></p-->
					<?php echo $this->Form->hidden('hora_transmision_gmt', array("type"=> 'text' ,"class"=>"form-control requerido", "label"=>false, "id"=> "hora_transmision_gmt"));?>  
	            </div>
            </div>

            <div class="form-group">
	            <label for="hora_termino_transmision" class="col-sm-3 control-label baja">Fin aproximada de transmisión </label>
	            <div class="col-sm-5">
					<?php echo $this->Form->input('hora_termino_transmision', array("type"=> 'text' ,"class"=>"form-control requerido", "label"=>false, "id"=> "hora_termino_transmision"));?>
	            </div>
	            <div class="col-sm-2">
					<!--p class="text-muted small" id="hora_termino_transmision_gmt_p" style="margin-top: 18px"></p-->
					<?php echo $this->Form->hidden('hora_termino_transmision_gmt', array("type"=> 'text' ,"class"=>"form-control requerido", "label"=>false, "id"=> "hora_termino_transmision_gmt"));?>
	            </div>
          	</div>

            <div class="form-group">
				<label for="Comentarios" class="col-sm-3 control-label">Comentarios </label>
				<div class="col-sm-5">
					<?php echo $this->Form->textArea('comentarios', array("class"=>"form-control ", "id"=>"Comentarios", "label"=>false, 'placeholder'=>'Comentarios sobre la transmisión'));?>
				</div>
			</div>
        </div>      	
      	<div class="text-center">
            <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i>  Guardar</button>        
            <a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-lg center margin-t-10">
              <i class="fa fa-mail-reply-all"></i>  Volver  
            </a>
      	</div>
    	<?php echo $this->Form->end(); ?>
      	<br><br>
  </div>
</div>
</div>
<?php 
	echo $this->Html->css('bootstrap-clockpicker.min');
	echo $this->Html->script(array(
	  'bootstrap-datepicker',
	  'bootstrap-clockpicker.min'
	  ));
?>
<script>
	$(function(){
		$("#Fecha").datepicker({
		    format: "dd/mm/yyyy",
		    language: "es",
		    multidate: false,
		    autoclose: true,
		    required: true,
		    weekStart:1,
		    orientation: "top auto"
	    });
		$('#hora_transmision, #hora_termino_transmision').clockpicker({
		    placement:'bottom',
		    align: 'top',
		    autoclose:true
	    });
	   $('#hora_transmision, #hora_termino_transmision').on("change", function(data){
			hora = {"time":$(this).val()};
			campo = $(this).attr('id');
			$.ajax({ type: "POST",
				url:"<?php echo $this->Html->url(array('controller'=>'servicios', 'action'=>'converTimeToGMT'))?>",
				data:hora,
				success: function(data){
				  $('#'+campo+'_gmt').val($.trim(data));
				  $('#'+campo+'_gmt_p').text(data + ' GMT');
				}
			});
		});
		var operador_mcr = '<?php echo implode(",",unserialize($seleccionados["operador_mcr"])); ?>';	
		$.each(operador_mcr.split(","), function(i,e){		
		    $("#operador_mcr option[value='" + e + "']").prop("selected", true);
		});
		var operador_continuidad = '<?php echo implode(",",unserialize($seleccionados["operador_continuidad"])); ?>';	
		$.each(operador_continuidad.split(","), function(i,e){		
		    $("#operador_continuidad option[value='" + e + "']").prop("selected", true);
		});
		$('#hora_transmision_gmt_p').text('<?php echo $seleccionados["hora_transmision_gmt"] ?>'+' GMT');
    	$('#hora_termino_transmision_gmt_p').text('<?php echo  $seleccionados["hora_termino_transmision_gmt"] ?>'+' GMT');
	});
</script>


