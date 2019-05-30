<div class="col-xs-12 col-sm-12 col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
    		<h3 class="panel-title">Editar Responsable Externo</h3>
 		</div>
		<div class="panel-body"> 		
			<h5 class="bold">Detalle Partido</h5>
 			<table class="table">
                <tr>
                    <th>Campeonato</th>
                    <th>Equipo Local</th>
                    <th>Equipo Visita</th>
                    <th>Estadio</th>
                    <th>Inicio Partido</th>
                </tr>
                <tr>
                    <td><?php echo $data["Campeonato"]["nombre"]?></td>
                    <td><?php echo $data["Equipo"]["nombre_marcador"]?></td>
                    <td><?php echo $data["EquipoVisita"]["nombre_marcador"]?></td>
                    <td><?php echo $data["Estadio"]["nombre"]?></td>
                    <td><?php echo $data["ProduccionPartidosEvento"]["fecha_partido"].' ' . $data["ProduccionPartidosEvento"]["hora_partido"]?></td>                    
                </tr>
            </table>
    		<?php echo $this->Form->create('ProduccionPartidosChilefilm'); ?>
    		<?php echo $this->Form->hidden('id', array("type"=>"text", "default"=>$idChilefilms));?>    			
    			<div class="row">
    				<div class="col-xs-12 col-md-6">
    					<label> Director</label>
    					<div class="form-group">
    						<?php echo $this->Form->input('director', array("label"=>false, "class"=>"form-control requerido", "options"=>$externoList, 'multiple'=> 'true', "id"=>"director", "selected"=>$directorSeleccionado)); ?>
    					</div>
    				</div>
                    <div class="col-xs-12 col-md-6">
                        <label> Productor</label>
                        <div class="form-group">
                            <?php echo $this->Form->input('productor', array("label"=>false, "class"=>"form-control requerido", "options"=>$externoList, 'multiple'=> 'true', "id"=>"productor", "selected"=>$productorSeleccionado)); ?>
                        </div>
                    </div>                     
    				<div class="col-xs-12 col-md-6">
    					<label> Asistente de Dirección</label>
    					<div class="form-group">
    						<?php echo $this->Form->input('asist_direccion', array("label"=>false, "class"=>"form-control requerido", "options"=>$externoList, 'multiple'=> 'true', "id"=>'asist_direccion', "selected"=>$asistSeleccionado)); ?>
    					</div>
    				</div>                        
    			</div>    
                <br><br>
                <div class="text-center">
        			<button type="submit" class="btn btn-lg btn-primary "><i class="fa fa-plus"></i>  Guardar</button>
                    <a href="<?php echo $this->request->referer(); ?>" class="btn btn-default  btn-lg center margin-t-10">
                      <i class="fa fa-mail-reply-all"></i>  Volver  
                    </a>
                </div>    			
    		<?php echo $this->Form->end(); ?>
    	</div>
	</div>
</div>
<?php 
echo $this->Html->css('multi-select');
echo $this->Html->script('jquery.multi-select');
?>
<script>
    $("#prod_tecnica").select2(); 
    $('#director, #asist_direccion, #productor').multiSelect({
        cssClass:"m-select-w-450"
    });
</script>
