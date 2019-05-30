<div class="col-xs-12 col-sm-12 col-md-12">
   <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Clonar Producción</h3>
      </div>
      <div class="panel-body">
         <?php echo $this->Form->create('ProduccionPartidosEvento', array('id'=>'ProduccionPartidosEventoEditForm', 'class' => 'form-horizontal')); ?>
         <?php echo $this->Form->hidden('fixture_partido_id'); ?>
         <?php echo $this->Form->hidden('estado_produccion'); ?>                    
         <div class="row"> 
            <div class="form-group">
               <label for="Torneo" class="col-sm-3 control-label">Campeonato: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('campeonato_id', array("type"=>"select",  "class"=>"form-control requerido", "label"=>false, "id"=> "Torneo"));?>
               </div>
            </div>
            <div class="form-group">
               <label for="FaseTorneo" class="col-sm-3 control-label">Categoria: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('campeonatos_categoria_id', array("type"=>"select", "class"=>"form-control", "empty"=>"", "label"=>false, "id"=> "FaseTorneo"));?>
               </div>
            </div>
            <div class="form-group">
               <label for="FechaTorneo" class="col-sm-3 control-label">Subcategoria: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('campeonatos_subcategoria_id', array("type"=>"select", "class"=>"form-control", "empty"=>"", "label"=>false, "id"=> "FechaTorneo"));?>
               </div>
            </div>
            <div class="form-group">
               <label for="Local" class="col-sm-3 control-label">Equipo Local: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('local_equipo_id', array( "class"=>"form-control requerido", "options"=> $equipos, "id"=> "Local", "label"=>false));?>
               </div>
            </div>
            <div class="form-group">
               <label for="Visita" class="col-sm-3 control-label">Equipo Visita: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('visita_equipo_id', array("class"=>"form-control requerido", "options"=> $equipos, "id"=> "Visita", "label"=>false));?>
               </div>
            </div>
            <div class="form-group">
               <label for="Fecha" class="col-sm-3 control-label">Fecha Partido: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('fecha_partido', array( "type"=> 'text', "class"=>"form-control requerido readonly-pointer-background sube", "label"=>false, "id"=> "Fecha"));?>
               </div>
            </div>
            <div class="form-group">
               <label for="Hora" class="col-sm-3 control-label">Hora Inicio Partido: </label>
               <div class="col-sm-3">
                 <?php echo $this->Form->input('hora_partido', array("type"=> 'text',"class"=>"form-control requerido readonly-pointer-background sube", "label"=>false, "id"=> "hora_partido", "readonly"=>"readonly"));?>
               </div>
               <div class="col-sm-2">
                  <p class="text-muted small" id="hora_partido_gmt_p" style="margin-top: 8px"><?php echo $data["ProduccionPartidosEvento"]["hora_partido_gmt"]; ?> GMT</p>
                  <?php echo $this->Form->hidden('hora_partido_gmt', array("type"=> 'text' ,"class"=>"form-control requerido", "value"=>$data["ProduccionPartidosEvento"]["hora_partido_gmt"], "label"=>false, "id"=> "hora_partido_gmt"));?>  
               </div>
            </div>
            <div class="form-group">
               <label for="Estadio" class="col-sm-3 control-label">Estadio: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('estadio_id', array("type"=>"select", "class"=>"form-control requerido", "label"=>false, "id"=> "Estadio"));?>
               </div>
            </div>

            <hr><br></hr>

            <?php echo $this->Form->hidden('ProduccionPartidosTransmisione.id', array("type"=>"select", "class"=>"form-control requerido sube",  "label"=>false, 'required'=> 'true'));?>               
            <?php echo $this->Form->hidden('ProduccionPartidosTransmisione.produccion_partidos_evento_id', array("default"=>"id"));?> 
            <?php echo $this->Form->hidden('ProduccionPartidosTransmisione.estado', array("default"=>1));?> 

            <div class="form-group">
               <label for="Partido" class="col-sm-3 control-label">Tipo Producción: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('ProduccionPartidosTransmisione.tipo_transmisione_id', array("type"=>"select", "class"=>"form-control requerido sube",  "label"=>false, "id"=> "Partido", 'required'=> 'true'));?>
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
               <label for="nroPartido" class="col-sm-3 control-label">Nro. Partido: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('ProduccionPartidosTransmisione.numero_partido_id', array("type"=>"select", "class"=>"form-control",  "label"=>false, "id"=> "nroPartido", "empty"=>""));?>
               </div>
            </div>

            <div class="form-group">
               <label for="Camaras" class="col-sm-3 control-label">Ingrese Nro. Cámaras: </label>
               <div class="col-sm-5">
                 <?php echo $this->Form->input('ProduccionPartidosTransmisione.numero_camaras', array("type"=>"number", "class"=>"form-control sube", "label"=>false));?>
               </div>
            </div>
            <div class="text-center">
               <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i>  Guardar</button>
                <!--La Producción clonada será reemplazada por la nueva. ¿Deseas continuar?
                Se creará una nueva Producción para el partido. ¿Deseas continuar?-->
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
   echo $this->Html->css('bootstrap-clockpicker.min'
    );
   echo $this->Html->script(array( 
      'bootstrap-datepicker',
      'bootstrap-clockpicker.min'
      ));
?>
<script>
   $(function() {
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
      $("#Torneo, #FaseTorneo, #FechaTorneo, #Estadio, #Local, #Visita, #Partido, #prod_tecnica, #proveedor").select2({
         allowClear: false,
         placeholder: '',
         width:'100%'
      }); 
      $("#nroPartido").select2({
         allowClear: true,
         placeholder: '',
         width:'100%'
      }); 
      $("#Torneo, #FaseTorneo, #FechaTorneo, #Local, #Visita").select2("readonly", true);

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
         if($.trim($("#Fecha").val())!= '' && $.trim($("#hora_partido").val())!= ''){
            dia = $("#Fecha").val();
            hora = $("#hora_partido").val();

            if($.trim($("#Partido").val())== 3){
              hora = null;
            }
            
            fecha = {
               "dia":dia,
               "hora": hora
            };

            senalesLibres = $.getValues("<?php echo $this->Html->url(array('controller'=>'produccion_partidos_eventos', 'action'=>'senalesLibres'))?>", fecha);            
            var senalesProd =  $.map(<?php echo json_encode($senalesPartido);?>, function(el) { return el });
            $('#senales').empty();
            
            if(JSON.stringify(senalesLibres)!='[]'){
               $.each(senalesLibres, function(id,text){
                  $("#senales").append($('<option>', {value:id, text: text}));
               });
               $("#senales").val(senalesProd);
               $('#senales option').prop('disabled', false); 
            }else{
               alert("No existen Señales disponibles para el día y hora ingresados.");
            }

         }
      });
      /*setSenalesLibres = function(url, fecha){
         $.ajax({ 
            type: 'get',
            url:url,
            data:fecha,
            success: function(data){
               $('#senales').empty();
               if(JSON.stringify(data)!='[]'){
                  $.each(data, function(id,text){
                     $("#senales").append($('<option>', {value:id, text: text}));
                  });
                  $('#senales option').prop('disabled', false);  
               }else{
                  alert("No existen Señales disponibles para el día y hora ingresados.");
               }
            }
         });
      };*/
      // clonar
      var tipoProduccionAnterior = '<?php echo $data["ProduccionPartidosTransmisione"]["tipo_transmisione_id"]; ?>';
      var produccionesPartido = '<?php echo $produccionesPartido; ?>';
      produccionesPartido = $.parseJSON(produccionesPartido);
      
      $('#ProduccionPartidosEventoEditForm').submit(function() {
         console.log("seleccionado:"+ $("#Partido").val());
         var c;
         var existe = false;
         $.each(produccionesPartido, function(key,valor){
            if(valor==$("#Partido").val() && tipoProduccionAnterior != $("#Partido").val()){
              alert("La Producción que desea crear ya existe.");
              existe = true;
            }
         });

         if(existe){
            c = false;
         }
         else
         {
            if(tipoProduccionAnterior == $("#Partido").val()){
               c = confirm("La Producción clonada será reemplazada por la nueva. ¿Deseas continuar?");   // clonar completa cabecera + colaboradores
            }
            else
            {
               c = confirm("Se creará una nueva Producción a partir del evento seleccionado. ¿Deseas continuar?"); // previa/radio solo cabecera
            }
         }

         return c;                                   //you can just return c because it will be true or false         
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