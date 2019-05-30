<div class="col-xs-12 col-sm-12 col-md-12">
   <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Editar Información de Partido</h3>
      </div>
      <div class="panel-body">
         <?php echo $this->Form->create('ProduccionPartidosEvento', array('id'=>'ProduccionPartidosEventoEditForm', 'class' => 'form-horizontal')); ?>
         <?php echo $this->Form->input('id'); ?>
         
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
         <div class="row">
            <hr><br></hr>

            <?php echo $this->Form->hidden('ProduccionPartidosTransmisione.id', array("type"=>"select", "class"=>"form-control requerido sube",  "label"=>false, 'required'=> 'true'));?>               
            <?php echo $this->Form->hidden('ProduccionPartidosTransmisione.produccion_partidos_evento_id', array("default"=>"id"));?> 

            <div class="form-group">
               <label for="Partido" class="col-sm-3 control-label">Tipo Producción: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('ProduccionPartidosTransmisione.tipo_transmisione_id', array("type"=>"select", "class"=>"form-control requerido sube",  "label"=>false, "id"=> "Partido", 'required'=> 'true'));?>
               </div>
            </div>

            <div class="form-group">
               <label for="Partido" class="col-sm-3 control-label">Estadio: </label>
               <div class="col-sm-5">
               <?php echo $this->Form->input('estadio_id', array("type"=>"select", "class"=>"form-control requerido estadiosRelacion", "label"=>false, "id"=> "Estadio", 'style'=>'width:220px'));?>
               <?php echo $this->Form->input('fixture_partido_id', array("type"=>"hidden",  "label"=>false));?>
               </div>
            </div>

            <!--div class="form-group">
               <label for="Partido" class="col-sm-3 control-label">Hora Partido: </label>
               <div class="col-sm-3">
               <?php echo $this->Form->input('hora_partido',  array("type"=> 'text' , "class"=>"form-control requerido sube", "label"=>false, "id"=> "Hora"));?>
               </div>
               <div class="col-sm-5">
                <p class="text-muted small" id="hora_partido_gmt_p" style="margin-top: 8px"><?php echo $hora_partido_gmt; ?> GMT</p>
                <?php //echo $this->Form->hidden('ProduccionPartidosTransmisione.hora_transmision_gmt', array("type"=> 'text' ,"class"=>"form-control requerido", "label"=>false, "id"=> "hora_transmision_gmt"));?>  
             </div>
            </div-->


            <div class="form-group">
             <label for="hora_partido" class="col-sm-3 control-label">Hora Partido: </label>
               <div class="col-sm-3">
                <?php echo $this->Form->input('hora_partido', array("type"=> 'text' ,"class"=>"form-control requerido sube", "label"=>false, "id"=> "hora_partido", 'required'=> 'true'));?>
             </div>
             <div class="col-sm-2">
                <p class="text-muted small" id="hora_partido_gmt_p" style="margin-top: 8px"><?php echo substr($data["ProduccionPartidosEvento"]["hora_partido_gmt"],0,5); ?> GMT</p>
                <?php echo $this->Form->hidden('hora_partido_gmt', array("type"=> 'text' ,"class"=>"form-control requerido", "label"=>false, "id"=> "hora_partido_gmt"));?>  
             </div>
            </div>



            <div class="form-group">
             <label for="hora_transmision" class="col-sm-3 control-label">Hora inicio transmisión: </label>
               <div class="col-sm-3">
                <?php echo $this->Form->input('ProduccionPartidosTransmisione.hora_transmision', array("type"=> 'text' ,"class"=>"form-control requerido sube", "label"=>false, "id"=> "hora_transmision", 'required'=> 'true'));?>
             </div>
             <div class="col-sm-2">
                <p class="text-muted small" id="hora_transmision_gmt_p" style="margin-top: 8px"><?php echo $data["ProduccionPartidosTransmisione"]["hora_transmision_gmt"]; ?> GMT</p>
                <?php echo $this->Form->hidden('ProduccionPartidosTransmisione.hora_transmision_gmt', array("type"=> 'text' ,"class"=>"form-control requerido", "label"=>false, "id"=> "hora_transmision_gmt"));?>  
             </div>
            </div>
            <div class="form-group">
               <label for="hora_termino_transmision" class="col-sm-3 control-label">Fin Aprox. de transmisión: </label>
               <div class="col-sm-3">
                <?php echo $this->Form->input('ProduccionPartidosTransmisione.hora_termino_transmision', array("type"=> 'text' ,"class"=>"form-control requerido sube", "label"=>false, "id"=> "hora_termino_transmision", 'required'=> 'true'));?>
             </div>
             <div class="col-sm-2">
                <p class="text-muted small" id="hora_termino_transmision_gmt_p" style="margin-top: 8px"><?php echo $data["ProduccionPartidosTransmisione"]["hora_termino_transmision_gmt"]; ?> GMT</p>
                <?php echo $this->Form->hidden('ProduccionPartidosTransmisione.hora_termino_transmision_gmt', array("type"=> 'text' ,"class"=>"form-control requerido", "label"=>false, "id"=> "hora_termino_transmision_gmt"));?>
             </div>
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">Señales:</label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('ProduccionPartidosTransmisione.senales', array("label"=>false, "class"=>"form-control", "placeholder"=>"Productor", "options"=>$senalesTransmision, 'required'=> 'true', "size"=>"3", 'multiple'=> 'true', "id"=>'senales', "selected"=>$senalesPartido)); ?>
               </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"> Producción Técnica:</label>
              <div class="col-sm-5">
                <?php echo $this->Form->input('ProduccionPartidosTransmisione.proveedor_company_id', array("label"=>false, "class"=>"form-control", "empty"=>"", "id"=>'proveedor', "required"=>"true")); ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"> Móvil:</label>
              <div class="col-sm-5">
                <?php echo $this->Form->input('ProduccionPartidosTransmisione.transmisiones_movile_id', array("label"=>false, "class"=>"form-control", "empty"=>"", "id"=>'prod_tecnica', "required"=>"true")); ?>
              </div>
            </div>
            <div class="form-group">
               <label for="TipoPartido" class="col-sm-3 control-label">Nro. Partido: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('ProduccionPartidosTransmisione.numero_partido_id', array("type"=>"select", "class"=>"form-control", "label"=>false, "id"=> "TipoPartido", "empty"=>""));?>
               </div>
            </div>
            <div class="form-group">
               <label for="Camaras" class="col-sm-3 control-label">Nro. Cámaras: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('ProduccionPartidosTransmisione.numero_camaras', array("type"=>"number", "class"=>"form-control sube", "label"=>false));?>
               </div>
            </div>
            <div class="text-center">
               <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i>  Guardar</button>
               <a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-lg center margin-t-10">
                 <i class="fa fa-mail-reply-all"></i>  Volver
               </a>
            </div>
         </div>
         <?php echo $this->Form->end(); ?>
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
   $(function() {     
    $('#Hora').clockpicker({
        placement:'bottom',
        align: 'top',
        autoclose:true
    }); 
    


      $('#hora_partido, #hora_transmision, #hora_termino_transmision').clockpicker({
         placement:'bottom',
         align: 'top',
         autoclose:true
      });
      $("#Partido, #proveedor, #prod_tecnica, #Estadio").select2({
         allowClear: false,
         placeholder: '',
         width:'100%'
      });
      $("#TipoPartido").select2({
         allowClear: true,
         placeholder: '',
         width:'100%'
      });

      // horario gmt      
      var difUtc = 0;
      $("#hora_partido, #hora_transmision, #hora_termino_transmision").on("change", function(){
         if(!difUtc) difUtc = obtieneUTC();
         cambiarHora($(this), difUtc);
      });
      obtieneUTC = function(){
         fecha = '<?php echo $data["ProduccionPartidosEvento"]["fecha_partido"];?>';
         if(fecha!= ''){
            fecha = fecha.split("/").reverse().join("-");
            dia = {dia:fecha};

            difUtc = $.getValues("<?php echo $this->Html->url(array('controller'=>'servicios', 'action'=>'utc'))?>", dia);
         }
         return difUtc;
      };
      cambiarHora = function(campo, diferencia){         
         nuevaHora = new Date('1970-01-01 '+campo.val());
         nuevaHora.addHours(Math.abs(diferencia));
         nuevahora = nuevaHora.toTimeString().split(" ")[0];

         $("#"+campo.attr("id")+'_gmt').val(nuevahora.substr(0,5));
         $("#"+campo.attr("id")+'_gmt_p').text(nuevahora.substr(0,5)+' GMT');
      };
   });

   jQuery.extend({
      getValues: function(url, vars) {
         var result = null;
         $.ajax({
            data: vars,
            url: url,
            type: 'get',
            async: false,
            success: function(data) {
               result = data;
            }
         });
         return result;
       }
   });
   Date.prototype.addHours= function(h){
      this.setHours(this.getHours()+h);       
      return this;
   }
</script>