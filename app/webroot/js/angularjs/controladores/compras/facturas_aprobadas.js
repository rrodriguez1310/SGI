
app.controller('FacturasAprobadas', ['$scope', '$http','comprasServices', 'uiGridConstants', '$filter',  function ($scope, $http, comprasServices,  uiGridConstants, $filter) {
    $scope.loader = true
    $scope.cargador = loader;
    $scope.gridOptions = {
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        enableFiltering: false,
        showGridFooter: true,
        useExternalFiltering: true,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };
    $scope.gridOptions = {
        columnDefs : [
            { name:'idCompraFactura', displayName: 'Id', visible:false},
            { name:'fechaIngresoSap', displayName: 'Fecha'},
            { name:'nombreDocumento', displayName: 'Documento'},
            { name:'numeroFactura', displayName: 'Numero'},
            { name:'titulo', displayName: 'Titulo'},
            { name:'nombreEmpresa', displayName: 'Empresa'},
            { name:'neto', displayName: 'Neto', cellFilter:'number'},
            { name:'total', displayName: 'Total', cellFilter:'number'},
            { name:'productosAsociados', displayName: 'Codigos P.'},      
        ],
            enableGridMenu: true,
            enableSelectAll: true,
            exporterCsvFilename: 'Contratos.csv',
            exporterPdfDefaultStyle: {fontSize: 9},
            exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
            exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
            exporterPdfHeader: { text: "Encabezado", style: 'headerStyle' },
            exporterPdfFooter: function ( currentPage, pageCount ) {
              return { text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle' };
            },
            exporterPdfCustomFormatter: function ( docDefinition ) {
              docDefinition.styles.headerStyle = { fontSize: 22, bold: true };
              docDefinition.styles.footerStyle = { fontSize: 10, bold: true };
              return docDefinition;
            },
            exporterPdfOrientation: 'portrait',
            exporterPdfPageSize: 'LETTER',
            exporterPdfMaxGridWidth: 500,
            exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
    }
    
    comprasServices.listaFacturasAprobadas().success(function(data){
    	
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;

        $scope.refreshData = function (termObj){
            $scope.gridOptions.data = data;
            while (termObj){
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });
}]);