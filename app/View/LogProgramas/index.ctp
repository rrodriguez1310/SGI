<div>
    <form class="form-inline" id="form" name="form">
    
    
    
        <div class="press-title">
            <h4><a class="text" data-toggle="collapse" data-target="#collapseLog" href="">
                <span id="servicesButton" data-toggle="tooltip " data-original-title="Click Me!">
                <span class="servicedrop glyphicon glyphicon-chevron-down"></span> Regenerar Logs</span></a>
           </h4>
        </div>
        <div id="collapseLog" class="collapse">
            <br>
            <div class="block">
                <label class="col-md-2 control-label baja">Seleccione Carpeta</label>
                <select class="form-control" name="carpeta" id="carpeta">
                  <option value="01_basico"> Basico</option>
                  <option value="03_hd"> HD</option>
                  <option value="02_premium"> Premium</option>                
                </select>
            </div>
            <div>
                <label class="col-md-2 control-label baja">Seleccione Mes</label>
                <input class="form-control" id="date" name="date" placeholder="seleccione un mes"  type="text" required/>
            </div>
            <div>
                <br>
                <button type="submit" class="btn btn-primary btn-block btn-lg" name="btn" id="btnLog" value="regenerar"><i class="fa fa-spinner fa-spin fa-1x fa-fw esconde"></i> Regenerar Logs</button>
            </div>
    </form>
    <br>
    </div>
    <br>
    <hr>
    <br>
    <div ng-controller="ListaLog" ng-cloak>
        <form class="form-inline" ng-submit="listaLog.enviar()">
            <div class="form-group">
                <?php echo $this->Form->input('fecha_desde', array("class"=>"form-control fechaInicio", "label"=>false,'data-date-end-date'=>"-0d", 'placeholder'=>"Buscar por fecha", "ng-model"=>"fecha" ,"required"=>"required"));?>
            </div>
            <button type="submit" class="btn btn-default" ng-click="enviaFecha(fecha)"><i class="fa fa-search"></i> Buscar</button>
        </form>
        <br/>
        <div ng-hide="hideGrid " ng-show="tablaDetalle">
            <p ng-bind-html="cargador" ng-show="loader"></p>
            <div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
        </div>
    </div>
</div>

<?php
echo $this->Html->script(array(
'angularjs/controladores/app',
'angularjs/controladores/lista_log',
'bootstrap-datepicker'
));
?>
  <script>
    $('.fechaInicio').datepicker({
      format: "yyyy-mm-dd",
      viewMode: "months",
      minViewMode: "months",
      autoclose: true
    });

    $(document).ready(function() {
      var date_input = $('input[name="date"]');
      var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
      var options = {
        format: "mm",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true
      };
      date_input.datepicker(options);
    });

    $(document).ready(function() {
      $('#form').submit(function() {
        $('.fa-spinner').css('display', 'block');
        var data = $(this).serialize();
        $.ajax({
          type: "POST",
          url: host+"log_programas/procesa_log",
          data: data,
          success: function(data) {
            $('.fa-spinner').css('display', 'none')
          }
        });
        return false;
      });
    });

    $('#collapseLog').on('shown.bs.collapse', function() {
      $(".servicedrop").addClass('glyphicon-chevron-up').removeClass('glyphicon-chevron-down');
    });
    $('#collapseLog').on('hidden.bs.collapse', function() {
      $(".servicedrop").addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-up');
    });
  </script>