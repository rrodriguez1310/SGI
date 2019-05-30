app.directive('ngBotonextra', function() {
  return {
    restrict: 'E',
    template: '<li ng-if="asignaPaginaRol"><a href="#" class="btn-sm btn btn-morado tool {{isDisabled}}"  ng-click="add()" data-placement="bottom" data-toggle="tooltip" data-original-title="Asociar Página arol seleccionado"><i class="fa fa-check-square-o"></i></a></li> <li ng-if="quitaPaginaRol"><a href="#" class="btn-sm btn btn-danger tool {{isDisabled}}"  ng-click="delete()" data-placement="bottom" data-toggle="tooltip" data-original-title="Eliminar asociación de página a rol seleccionado"><i class="fa fa-trash-o"></i></a></li>'
  }
});