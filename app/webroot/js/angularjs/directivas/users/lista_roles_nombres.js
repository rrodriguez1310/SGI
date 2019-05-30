/*app.directive('ngNombreroles', function() {
	var getHtml = "";

		getHtml += '<div class="panel panel-default">';
		getHtml += '<div class="panel-heading"><i class="fa fa-thumb-tack"></i> Roles asociados / Cant roles : {{cantRoles}}</div>';
		getHtml += '<table class="table table-bordered">';
		getHtml += '<thead>';
		getHtml += '<tr>';
		getHtml += '<th>Id</th>';
		getHtml += '<th>Nombre</th>';
		getHtml += '</tr>';
		getHtml += '</thead>';
		getHtml += '<tbody>';
		getHtml += '<tr ng-repeat="roles in nombreRoles" ng-click="paginasAsociadas(roles.Id)">';
		getHtml += '<td>{{roles.Id}}</td>';
		getHtml += '<td><a href="#">{{roles.Nombre}}</a></td>';
		getHtml += '</tr>';
		getHtml += '</tbody>';
		getHtml += '</table>';
		getHtml += '</div>';
	
  return {
    restrict: 'A',
    template: getHtml
  }
});

app.directive('ngNombrepaginas', function(){
	var getHtml = "";
		getHtml += '<div class="panel panel-default">';
		getHtml += '<div class="panel-heading"><i class="fa fa-thumb-tack"></i> Páginas asociados / Cant paginas : {{cantPaginas}}</div>';
		getHtml += '<table class="table table-bordered">';
		getHtml += '<thead>';
		getHtml += '<tr>';
		getHtml += '<th>Id</th>';
		getHtml += '<th>Nombre / Acción</th>';
		getHtml += '</tr>';
		getHtml += '</thead>';
		getHtml += '<tbody>';
		getHtml += '<tr ng-repeat="paginas in nombrePaginas | orderBy:\'ControladorFantasia\'" ng-click="toggleModal(paginas.IdPagina)">';
		getHtml += '<td>{{paginas.IdPagina}}</td>';
		getHtml += '<td><a href="#">{{paginas.ControladorFantasia}} / {{paginas.AccionFantasia}}</a></td>';
		getHtml += '</tr>';
		getHtml += '</tbody>';
		getHtml += '</table>';
		getHtml += '</div>';

  return {
    restrict: 'A',
    template: getHtml
  }
});
*/
app.directive('ngRolesactivos', function() {
	var getHtml = "";
		//getHtml += '<p>{{seleccionaRoles}}</p>';
		getHtml += '<div class="panel panel-success">';
		getHtml += '<div class="panel-heading">';
		getHtml += '<i class="fa fa-thumb-tack"></i> Roles Seleccionados {{ cuentaSeleccionados }} <span ng-if="cantRolesCreados"> de </span> {{cantRolesCreados}}</a>';
		getHtml += '</div>';
		getHtml += '<div class="col-xs-12"><button type="button" class="btn btn-warning btn-block btn-sm" ng-click="guardarAsociacion(seleccionaRoles)"><i class="fa fa-users"></i> Asociar Rol</button></div><br/>';
		getHtml += '<table class="table table-bordered">';
		getHtml += '<tr>';
		getHtml += '<th width="10%"><!--input type="checkbox" ng-model="master"--></th>';
		getHtml += '<th widht="10%" class="text-center">ID</th>';
		getHtml += '<th widht="80%">Nombre Rol</th>';
		getHtml += '</tr>';
		getHtml += '<tr ng-repeat="nombreRol in roles | orderBy:\'Nombre\'">';
		//getHtml += '<td style="padding: 3px;"><input type="checkbox" id="{{nombreRol.Id}}"  name="check-{{nombreRol.Id}}" ng-checked="master"></td>';
		getHtml += '<td style="padding: 3px;"><input type="checkbox" name="selectedRoles[]" value="{{nombreRol.Id}}" ng-checked="seleccionaRoles.indexOf(nombreRol.Id) > -1" ng-click="rolesSeleccionados(nombreRol.Id)"></td>';
		getHtml += '<td style="padding: 3px;" class="text-center">{{nombreRol.Id}}</td>';
		getHtml += '<td style="padding: 3px;">{{nombreRol.Nombre}}</td>';
		getHtml += '</tr>';
		getHtml += '</table>';
		getHtml += '</div>';
		
  return {
    restrict: 'A',
    template: getHtml
  }
});