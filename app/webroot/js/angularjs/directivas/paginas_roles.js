app.directive('ngPaginasroles', function() {
	var getHtml = "";
		getHtml += '<div class="list-group">';
		getHtml += '<a href="#" class="list-group-item active"><i class="fa fa-thumb-tack"></i> Roles por páginas</a>';
		getHtml += '<a href="#" class="list-group-item" ng-repeat="roles in nombreRoles"><i class="fa fa-check-square-o"></i> {{roles.Nombre}}</a>';
		getHtml += '</div>';
	
  return {
    restrict: 'A',
    template: getHtml
  }
});