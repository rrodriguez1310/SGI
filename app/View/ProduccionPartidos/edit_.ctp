<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Editar Responsables CDF</h3>
      </div>
      <div class="panel-body">

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
      <br>
        <?php echo $this->Form->create('ProduccionPartido'); ?>
        <?php echo $this->Form->hidden('id', array("type"=>"text"));?>
          <div class="row hide" id="body">

            <div class="col-xs-12 col-sm-6 col-md-6">
                     <label> Productor</label>
                     <div class="form-group">
                        <?php echo $this->Form->input('productor', array("label"=>false, "class"=>"form-control", "options"=>$productores, 'multiple'=> 'true', "id"=>"Productor", "selected"=>$productoresSeleccionado)); ?>
                     </div>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                     <label> Asistente de Producción</label>
                     <div class="form-group">
                        <?php echo $this->Form->input('asist_produccion', array("label"=>false, "class"=>"form-control", "options"=>$asistenteProduccion, "empty"=>"", 'multiple'=> 'true', "id"=>"Asistente", "selected"=>$asistenteProduccionSeleccionado)); ?>
                     </div>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <label> Coordinador Periodístico</label>
                    <div class="form-group">
                      <?php echo $this->Form->input('coordinador_periodistico', array("label"=>false, "class"=>"form-control", "options"=>$coordinadorPeriodistico, "empty"=>"", 'multiple'=> 'true', "id"=>"Coordinador", "selected"=>$coordinadorPeriodisticoSeleccionado)); ?>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                     <label> Relator</label>
                     <div class="form-group">
                        <?php echo $this->Form->input('relator', array("label"=>false, "class"=>"form-control", "options"=>$relator, "empty"=>"", 'multiple'=> 'true', "id"=>"Relator", "selected"=>$relatorSeleccionado)); ?>
                     </div>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                     <label> Periodista Equipo Local</label>
                     <div class="form-group">
                        <?php echo $this->Form->input('periodista', array("label"=>false, "class"=>"form-control", "options"=>$periodista, "empty"=>"", 'multiple'=> 'true', "id"=>"Periodista", "selected"=>$periodistaSeleccionado)); ?>
                     </div>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                     <label> Periodista Equipo Visita</label>
                     <div class="form-group">
                        <?php echo $this->Form->input('periodista_visita', array("label"=>false, "class"=>"form-control", "options"=>$periodistaVisita, "empty"=>"", 'multiple'=> 'true', "id"=>"PeriodistaVisita", "selected"=>$periodistaVisitaSeleccionado)); ?>
                     </div>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                     <label> Comentarista</label>
                     <div class="form-group">
                        <?php echo $this->Form->input('comentarista', array("label"=>false, "class"=>"form-control", "options"=>$comentarista, "empty"=>"", 'multiple'=> 'true', "id"=>"Comentarista", "selected"=>$comentaristaSeleccionado)); ?>
                     </div>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                     <label> Locutor</label>
                     <div class="form-group">
                        <?php echo $this->Form->input('locutor', array("label"=>false, "class"=>"form-control", "options"=>$locutor, "empty"=>"", 'multiple'=> 'true', "id"=>"Locutor", "selected"=>$locutorSeleccionado)); ?>
                     </div>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                     <label> Operador Track-vision</label>
                     <div class="form-group">
                        <?php echo $this->Form->input('operador_trackvision', array("label"=>false, "class"=>"form-control", "options"=>$operadorTrackVision, "empty"=>"", 'multiple'=> 'true', "id"=>"Trackvision", "selected"=>$operadorTrackvisionSeleccionado)); ?>
                     </div>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                     <label> Musicalizador</label>
                     <div class="form-group">
                        <?php echo $this->Form->input('musicalizador', array("label"=>false, "class"=>"form-control", "options"=>$musicalizador, "empty"=>"", 'multiple'=> 'true', "id"=>"Musicalizador", "selected"=>$musicalizadorSeleccionado)); ?>
                     </div>
                  </div>

                  <br>
                  <div class="col-xs-12 col-sm-12 col-md-12"></div>
                  <div class="form-horizontal">
                     <div class="form-group">
                        <label for="Terno" class="col-sm-3 control-label"> Terno </label>
                        <div class="col-sm-5">
                           <?php echo $this->Form->input('terno_vestuario_id', array("type"=>"select", "class"=>"form-control requerido sube", "label"=>false, "id"=> "Terno", 'required'=> 'false'));?>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="Camisa" class="col-sm-3 control-label"> Camisa</label>
                        <div class="col-sm-5">
                           <?php echo $this->Form->input('camisa_vestuario_id', array("type"=>"select", "class"=>"form-control requerido sube", "label"=>false, "id"=> "Camisa", 'required'=> 'false'));?>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="Corbata" class="col-sm-3 control-label"> Corbata </label>
                        <div class="col-sm-5">
                           <?php echo $this->Form->input('corbata_vestuario_id', array("type"=>"select", "class"=>"form-control requerido sube", "label"=>false, "id"=> "Corbata", 'required'=> 'false'));?>
                        </div>
                     </div>
                  </div>

          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-lg btn-primary "><i class="fa fa-plus"></i>  Guardar</button>
            <a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-lg center margin-t-10">
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
   $('#Musicalizador,#Productor,#Asistente,#Relator,#Comentarista,#Trackvision,#Locutor,#Periodista,#PeriodistaVisita,#Coordinador').multiSelect({cssClass:"m-select-w-450"});
   $("#Terno, #Camisa, #Corbata").select2();
   $("#body").removeClass("hide");  
</script>
