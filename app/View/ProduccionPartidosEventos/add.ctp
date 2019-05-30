<div class="col-xs-12 col-sm-12 col-md-12 hide" id="vista">
   <div class="panel panel-default">
     <div class="panel-heading">
      <h3 class="panel-title">Registrar Información Producción</h3>
      </div>
      <div class="panel-body">
         <?php echo $this->Form->create('ProduccionPartidosEvento', array('class' => 'form-horizontal')); ?>
         <div class="row">
           <div class="form-group">
            <label for="Torneo" class="col-sm-3 control-label">Campeonato: </label>
            <div class="col-sm-5">
             <?php echo $this->Form->input('campeonato_id', array("type"=>"select", "selected"=>$dataPartido["campeonato_id"], "class"=>"form-control requerido", "label"=>false, "id"=> "Torneo"));?>
          </div>
       </div>
       <div class="form-group">
         <label for="FaseTorneo" class="col-sm-3 control-label">Categoría: </label>
         <div class="col-sm-5">
          <?php echo $this->Form->input('campeonatos_categoria_id', array("type"=>"select", "selected"=>$dataPartido["campeonatos_categoria_id"], "class"=>"form-control", "empty"=>"", "label"=>false, "id"=> "FaseTorneo"));?>
       </div>
      </div>
      <div class="form-group">
         <label for="FechaTorneo" class="col-sm-3 control-label">Subcategoría: </label>
         <div class="col-sm-5">
          <?php echo $this->Form->input('campeonatos_subcategoria_id', array("type"=>"select", "selected"=>$dataPartido["campeonatos_subcategoria_id"], "class"=>"form-control", "empty"=>"", "label"=>false, "id"=> "FechaTorneo"));?>
       </div>
      </div>
      <div class="form-group">
         <label for="Local" class="col-sm-3 control-label">Equipo Local: </label>
         <div class="col-sm-5">
          <?php echo $this->Form->input('local_equipo_id', array( "class"=>"form-control requerido", "selected"=>$dataPartido["local_equipo_id"], "options"=> $equipos, "id"=> "Local", "label"=>false));?>
      </div>
      </div>
      <div class="form-group">
         <label for="Visita" class="col-sm-3 control-label">Equipo Visita: </label>
         <div class="col-sm-5">
          <?php echo $this->Form->input('visita_equipo_id', array("class"=>"form-control requerido", "selected"=>$dataPartido["visita_equipo_id"], "options"=> $equipos, "id"=> "Visita", "label"=>false));?>
       </div>
      </div>
      <div class="form-group">
         <label for="Fecha" class="col-sm-3 control-label">Fecha Partido: </label>
         <div class="col-sm-5">
          <?php echo $this->Form->input('fecha_partido', array( "type"=> 'text', "value"=>$dataPartido["fecha_partido"], "class"=>"form-control requerido readonly-pointer-background sube", "label"=>false, "id"=> "Fecha", "readonly"=>"readonly"));?>
       </div>
      </div>
      <div class="form-group">
         <label for="Hora" class="col-sm-3 control-label">Hora Inicio Partido: </label>
         <div class="col-sm-3">
            <?php echo $this->Form->input('hora_partido', array("type"=> 'text', "value"=>$dataPartido["hora_partido"] ,"class"=>"form-control requerido sube readonly-pointer-background", "label"=>false, "id"=> "hora_partido", "readonly"=>"readonly"));?>
         </div>
         <div class="col-sm-2">
            <p class="text-muted small" id="hora_partido_gmt_p" style="margin-top: 8px"><?php echo $dataPartido["hora_partido_gmt"]; ?> GMT</p>
            <?php echo $this->Form->hidden('hora_partido_gmt', array("type"=> 'text' ,"class"=>"form-control requerido", "value"=>$dataPartido["hora_partido_gmt"], "label"=>false, "id"=> "hora_partido_gmt"));?>  
         </div>
      </div>
      <div class="form-group">
        <label for="Estadio" class="col-sm-3 control-label">Estadio: </label>
        <div class="col-sm-5">
          <?php echo $this->Form->input('estadio_id', array("type"=>"select", "selected"=>$dataPartido["estadio_id"], "class"=>"form-control requerido", "label"=>false, "id"=> "Estadio"));?>
        </div>
      </div>

      <hr><br></hr>

      <div class="form-group">
         <label for="Partido" class="col-sm-3 control-label">Tipo Producción: </label>
         <div class="col-sm-5">
          <?php echo $this->Form->input('ProduccionPartidosTransmisione.tipo_transmisione_id', array("type"=>"select", "class"=>"form-control requerido", "empty"=>"",  "label"=>false, "id"=> "Partido", 'required'=> 'true'));?>
       </div>
      </div>
      <div class="form-group">
         <label for="hora_transmision" class="col-sm-3 control-label">Hora inicio transmisión: </label>
         <div class="col-sm-3">
          <?php echo $this->Form->input('ProduccionPartidosTransmisione.hora_transmision', array("type"=> 'text' ,"class"=>"form-control requerido sube", "label"=>false, "id"=> "hora_transmision", 'required'=> 'true'));?>
       </div>
       <div class="col-sm-2">
          <p class="text-muted small" id="hora_transmision_gmt_p" style="margin-top: 8px"></p>
          <?php echo $this->Form->hidden('ProduccionPartidosTransmisione.hora_transmision_gmt', array("type"=> 'text' ,"class"=>"form-control requerido", "label"=>false, "id"=> "hora_transmision_gmt"));?>  
       </div>
      </div>
      <div class="form-group">
         <label for="hora_termino_transmision" class="col-sm-3 control-label">Fin Aprox. de transmisión: </label>
         <div class="col-sm-3">
          <?php echo $this->Form->input('ProduccionPartidosTransmisione.hora_termino_transmision', array("type"=> 'text' ,"class"=>"form-control requerido sube", "label"=>false, "id"=> "hora_termino_transmision", 'required'=> 'true'));?>
       </div>
       <div class="col-sm-2">
          <p class="text-muted small" id="hora_termino_transmision_gmt_p" style="margin-top: 8px"></p>
          <?php echo $this->Form->hidden('ProduccionPartidosTransmisione.hora_termino_transmision_gmt', array("type"=> 'text' ,"class"=>"form-control requerido", "label"=>false, "id"=> "hora_termino_transmision_gmt"));?>
       </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label"> Señales:</label>
        <div class="col-sm-5">
          <?php echo $this->Form->input('ProduccionPartidosTransmisione.senales', array("label"=>false, "class"=>"form-control", "options"=>$senalesTransmision, 'required'=> 'true', "size"=>"3", 'multiple'=> 'true', "id"=>'senales')); ?>
        </div>
      </div>      
      <div class="form-group">
        <label class="col-sm-3 control-label"> Producción Técnica:</label>
        <div class="col-sm-5">
          <?php echo $this->Form->input('ProduccionPartidosTransmisione.proveedor_company_id', array("label"=>false, "class"=>"form-control", "empty"=>"", "id"=>'proveedor')); ?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label"> Móvil:</label>
        <div class="col-sm-5">
          <?php echo $this->Form->input('ProduccionPartidosTransmisione.transmisiones_movile_id', array("label"=>false, "class"=>"form-control", "empty"=>"", "id"=>'prod_tecnica')); ?>
        </div>
      </div>
      <div class="form-group">
        <label for="TipoPartido" class="col-sm-3 control-label"> Nro. Partido: </label>
        <div class="col-sm-5">
          <?php echo $this->Form->input('ProduccionPartidosTransmisione.numero_partido_id', array("type"=>"select", "class"=>"form-control", "empty"=>"",  "label"=>false, "id"=> "TipoPartido"));?>
        </div>
      </div>
      <div class="form-group">
        <label for="Camaras" class="col-sm-3 control-label">Nro. Cámaras: </label>
        <div class="col-sm-5">
          <?php echo $this->Form->input('ProduccionPartidosTransmisione.numero_camaras', array("type"=>"number", "class"=>"form-control sube", "label"=>false));?>
        </div>
      </div>
      <div class="text-center">
        <button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i>  Guardar</button> 
        <button type="submit" id="safe" class="hide">enviar</button>       
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
      $("#Torneo, #FaseTorneo, #FechaTorneo, #Estadio, #Local, #Visita, #Partido, #TipoPartido, #prod_tecnica, #proveedor").select2({         
         placeholder: '',
         width:'100%'
      });
      $(" #TipoPartido").select2({         
         allowClear:true,
         placeholder: '',
         width:'100%'
      });      
      $("#Torneo, #FaseTorneo, #FechaTorneo, #Local, #Visita").select2("readonly", true);

      $("#vista").removeClass("hide");

      $("#Fecha").datepicker({         
         format: "dd/mm/yyyy",
         language: "es",
         multidate: false,
         autoclose: true,
         required: true,
         weekStart:1,
         orientation: "top auto"
      });
      $('#hora_partido, #hora_transmision, #hora_termino_transmision').clockpicker({
         placement:'bottom',
         align: 'top',
         autoclose:true
      });      
      // horario gmt
      var difUtc = 0;      
      $("#Fecha").on("changeDate", function(){
         difUtc = obtieneUTC();
         if( $("#hora_partido").val()!='' ) cambiarHora($("#hora_partido"), difUtc);
         if( $("#hora_transmision").val()!='' ) cambiarHora($("#hora_transmision"), difUtc);
         if( $("#hora_termino_transmision").val()!='' ) cambiarHora($("#hora_termino_transmision"), difUtc);
      });
      $("#hora_partido, #hora_transmision, #hora_termino_transmision").on("change", function(){
         if(!difUtc) difUtc = obtieneUTC();
         cambiarHora($(this), difUtc);
      });
      obtieneUTC = function(){ 
         if($.trim($("#Fecha").val())!= ''){

            fecha = $("#Fecha").val();
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

      // señales
      $("#Fecha, #hora_partido, #Partido").on("change", function(){
         if($.trim($("#Fecha").val())!= '' &&  $.trim($("#hora_partido").val())!= ''){

            dia = $("#Fecha").val();
            hora = $("#hora_partido").val();

            if($.trim($("#Partido").val())== 3)
              hora = null;            

            fecha = { 
               "dia":dia, 
               "hora": hora
            };

            senalesLibres = $.getValues("<?php echo $this->Html->url(array('controller'=>'produccion_partidos_eventos', 'action'=>'senalesLibres'))?>", fecha);
            console.log(senalesLibres);
            $('#senales').empty();

            if(JSON.stringify(senalesLibres)!='[]'){
               $.each(senalesLibres, function(id,text){
                  $("#senales").append($('<option>', {value:id, text: text}));
               });
               $('#senales option').prop('disabled', false);  
            }else{
               alert("No existen Señales disponibles para el día y hora ingresados.");
            }
         }
      });

      $('#ProduccionPartidosEventoAddForm').submit(function () {
        if($(this).valid()){
          $("#submit").prop("disabled",true);
          $("#safe").click();
        }
      });

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