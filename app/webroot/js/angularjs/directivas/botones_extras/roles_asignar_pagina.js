app.directive('ngBotonextra', function() {
  return {
    restrict: 'E',
    template: '<li><a href="paginas/asigna_roles/{{id}}" ng-show="boton" class="btn-sm btn btn-morado tool {{isDisabled}}" data-placement="bottom" data-toggle="tooltip" title="Asignar paginas al rol seleccionado"><i class="fa fa-check-square-o"></i></a></li>'
  }
});