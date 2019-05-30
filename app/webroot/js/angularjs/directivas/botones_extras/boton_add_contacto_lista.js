app.directive('ngBotonextra', function() {
  return {
    restrict: 'E',
    template: '<li ng-if="hideAddContactoLista"><a href="#" class="btn-sm btn btn-morado tool {{isDisabled}}"  ng-click="addContactoLista()" data-placement="bottom" data-toggle="tooltip" data-original-title="Asociar Contacto Seleccionado"><i class="fa fa-check-square-o"></i></a></li> <li ng-if="delContactoLista"><a href="#" class="btn-sm btn btn-danger tool {{isDisabled}}"  ng-click="deleteContactoLista()" data-placement="bottom" data-toggle="tooltip" data-original-title="Eliminar asociación de página a rol seleccionado"><i class="fa fa-trash-o"></i></a></li>'
  }
});