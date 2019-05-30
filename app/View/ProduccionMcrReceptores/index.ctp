<style>
  input {
    margin-top: 0px;
  }
</style>
<div ng-controller="Receptores" ng-cloak>
  <p ng-bind-html="cargador" ng-show="loader"></p>

  <div ng-show="tablaDetalle">
    <div class="row">
      <div class="col-sm-12">
        <h4>Receptores</h4>
      </div>
    </div>
    <?php echo $this->element('botonera'); ?>
      <div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
  </div>
</div>
<?php
echo $this->Html->script(array(
'angularjs/controladores/app',
'angularjs/controladores/receptores/receptores',
'angularjs/servicios/receptores/receptores',
'angularjs/directivas/confirmacion'
));
?>
  <script>
    $('.tool').tooltip();
  </script>