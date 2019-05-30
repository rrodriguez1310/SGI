var app = angular.module("app", ["xeditable", 'ngAnimate', 'ui.grid', 'ui.grid.selection', 'ui.grid.exporter', 'ui.grid.selection', 'ngSanitize']);


var host25 = "http://192.168.1.37/"; // DESARROLLO CRISTIAN
var postHeader = {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'};
var loader = '<div align="center"><div class="second_circle"><div class="image_back"><div class="first_circle"></div></div></div></div>';

app.run(function(editableOptions) {
  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
});

app.controller('Ctrl', function($scope) {
  $scope.user = {
    name: 'awesome user'
  };  
});