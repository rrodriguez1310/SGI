<style>
  input {
    margin-top: 0px;
  }
</style>
<div ng-controller="Calificaciones" ng-cloak>
  <p ng-bind-html="cargador" ng-show="loader"></p>
  <div ng-show="tablaDetalle">
    <div class="row">
      <div class="col-sm-12">
        <h4>Calificaciones</h4>
      </div>
    </div>
    <?php echo $this->element('botonera'); ?>
      <div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid">
      </div>
  </div>
  <?php
echo $this->Html->script(array(
'angularjs/controladores/app',
'angularjs/controladores/calificaciones/calificaciones',
'angularjs/servicios/calificaciones/calificaciones',
//'angularjs/directivas/confirmacion'
));
?>
    