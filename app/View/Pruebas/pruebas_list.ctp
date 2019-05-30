<style>
  input {
    margin-top: 0px;
  }
</style>
<div ng-controller="Pruebas" ng-cloak>
  <p ng-bind-html="cargador" ng-show="loader"></p>
  <p>{{hola}}</p>
  <div ng-show="tablaDetalle">
    <div class="row">
      <div class="col-sm-12">
        <h4>Pruebas</h4>
      </div>
    </div>
    <?php echo $this->element('botonera'); ?>
      <div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
  </div>
</div>
<?php
echo $this->Html->script(array(
'angularjs/controladores/app',
'angularjs/controladores/pruebas/pruebas',
'angularjs/servicios/pruebas/pruebas',
'angularjs/directivas/confirmacion'
));
?>
  <script>
    $('.tool').tooltip();
  </script>