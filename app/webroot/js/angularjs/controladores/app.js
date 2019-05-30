var app = angular.module('angularApp', [
    //'ngAnimate', 
    'ui.grid',
    'ui.grid.selection',
    'ui.grid.resizeColumns',
    'ui.grid.moveColumns',
    'ui.grid.exporter',
    'ui.grid.selection',
    'ngSanitize',
    'highcharts-ng',
    'ui.grid.expandable',
    'ui.grid.pinning',
    'ngFileUpload',
    'flash',
    'ui.select',
    'ui.grid.edit',
    'ui.grid.cellNav',
    'platanus.rut',
    'rt.select2',
    'ui.grid.autoResize',
    'ui.grid.grouping'
]);

var appTextEditor = angular.module('angularAppText', ['ngSanitize', 'textAngular', 'angularApp']);

app.config(['$httpProvider', '$provide', function($httpProvider, $provide) {
    $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded';
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
    $httpProvider.defaults.headers.common['Cache-Control'] = 'no-cache, no-store, must-revalidate';
    $httpProvider.defaults.headers.common['Pragma'] = 'no-cache';
    $httpProvider.defaults.headers.common['Expires'] = '0';
    $provide.decorator('GridOptions', function($delegate, i18nService) {
        var gridOptions;
        gridOptions = angular.copy($delegate);
        gridOptions.initialize = function(options) {
            var initOptions;
            initOptions = $delegate.initialize(options);
            initOptions.exporterOlderExcelCompatibility = true,
                initOptions.exporterCsvColumnSeparator = ";";
            return initOptions;
        };
        i18nService.setCurrentLang('es');
        return gridOptions;
    });
}]);
//, 'highcharts-ng'	 
//var host = "http://192.168.1.35/sgi-v2/"; // DESARROLLO BRUNO
var host25 = "http://localhost/sgi-v3/"; // DESARROLLO CRISTIAN
var host = "http://localhost/sgi-v3/"; // DESARROLLO PRODUCCION

app.constant('constantes', {
    ordenaRut: function(a, b) {
        var aa = Number((a.substring(0, a.length - 2)).split(".").join(""));
        var bb = Number((b.substring(0, b.length - 2)).split(".").join(""));
        return aa - bb;
    }
});
var postHeader = { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' };
var loader = '<div align="center"><div class="second_circle"><div class="image_back"><div class="first_circle"></div></div></div></div>';