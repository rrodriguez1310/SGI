app.directive('ngBotonasignaroles', function() {
  return {
    restrict: 'A',
    template: '<a href="#" ng-show="asignaPaginaRol" class="btn-sm btn btn-morado tool {{isDisabled}}"  ng-click="add()" data-placement="bottom" data-toggle="tooltip" data-original-title="Asociar Página arol seleccionado"><i class="fa fa-check-square-o"></i></a>'
  }
});