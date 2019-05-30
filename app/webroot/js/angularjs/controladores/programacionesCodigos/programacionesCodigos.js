app.controller('ProgramacionesCodigos', ['$scope', '$http', '$filter', 'uiGridConstants', function($scope, $http, $filter, uiGridConstants) {
    $scope.tablaDetalle = false;
    $scope.loader = true
    $scope.cargador = loader;

    $scope.gridOptions = {
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        },
        
        enableGridMenu: true,
        enableSelectAll: true,
        exporterCsvFilename: 'myFile.csv',
        exporterPdfDefaultStyle: { fontSize: 9 },
        exporterPdfTableStyle: { margin: [30, 30, 30, 30] },
        exporterPdfTableHeaderStyle: { fontSize: 10, bold: true, italics: true, color: 'red' },
        exporterPdfHeader: { text: "My Header", style: 'headerStyle' },
        
        exporterPdfFooter: function(currentPage, pageCount) {
            return { text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle' };
        },

        exporterPdfCustomFormatter: function(docDefinition) {
            docDefinition.styles.headerStyle = { fontSize: 22, bold: true };
            docDefinition.styles.footerStyle = { fontSize: 10, bold: true };
            return docDefinition;
        },

        exporterPdfOrientation: 'portrait',
        exporterPdfPageSize: 'LETTER',
        exporterPdfMaxGridWidth: 500,
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        { name: 'id', displayName: 'Id', visible: false },
        { name: 'titulo', displayName: 'Titulo' },
        { name: 'descripcion', displayName: 'Descripcion' },
    ];
    //$scope.cargador = true;
    $http.get(host25 + 'programaciones_codigos/lista_codigos').success(function(data) {
        //alert(data);
        $scope.gridOptions.data = data;
        
        $scope.loader = false;
        $scope.tablaDetalle = true;

        $scope.refreshData = function(termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };

        $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) { 
            if(row.isSelected == true){
                $scope.botones = true
                $scope.id = row.entity.id;
            }else{
                $scope.botones = false
                $scope.id = '';
            }
        });
        
    });
}]);