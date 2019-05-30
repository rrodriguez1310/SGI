<style>
  input {
    margin-top: 0px;
  }
</style>
<div ng-controller="Archivos" ng-cloak>
  <p ng-bind-html="cargador" ng-show="loader"></p>

  <div ng-show="tablaDetalle">
    <div class="row">
      <div class="col-sm-12">
        <h4>Archivos</h4>
      </div>
    </div>
    <?php echo $this->element('botonera'); ?>
      <div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
  </div>
</div>
<?php
echo $this->Html->script(array(
'angularjs/controladores/app',
'angularjs/controladores/archivos/archivos',
'angularjs/servicios/archivos/archivos',
'angularjs/directivas/confirmacion'
));
?>
  <script>
    $('.tool').tooltip();
  </script>