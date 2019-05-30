app.controller('ComprasReportes', ['$scope', '$http', '$filter', '$location', 'uiGridConstants', function ($scope, $http, $filter, $location, uiGridConstants) {
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
        enableSorting: true,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        },

        enableGridMenu: true,
        enableSelectAll: true,
        exporterCsvFilename: 'myFile.csv',
        exporterPdfDefaultStyle: {fontSize: 9},
        exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
        exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
        exporterPdfHeader: { text: "My Header", style: 'headerStyle' },
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
        onRegisterApi: function(gridApi){ 
          $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        {name:'Id', displayName:'Id', visible: false, sort : {
                direction: uiGridConstants.ASC,
                priority: 1
            }
        },
        {name:'Fecha', displayName:'Fecha'},
        {name:'TipoDocumento', displayName:'Documento'},
        {name:'DescripcionGasto', displayName:'Titulo'},
        {name:'Proveedor', displayName:'Proveedor'},
        {name:'Neto', displayName:'Neto', cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
            return 'text-right';
            }
        },
        {name:'Total', displayName:'Total', cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
            return 'text-right';
            }
        },
        //{name:'CodigoPresupuestario', displayName:'Código pres.'},
        //{name:'Area', displayName:'Área'},
    ];

    $http.get(host25+'compras_reportes/lista_compras').success(function(data) {
        $scope.gridOptions.data = data; 
        $scope.loader = false;
        $scope.tablaDetalle = true;
       

        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(angular.isNumber(row.entity.Id))
            {
                $scope.id = row.entity.Id;
            }

            if(row.isSelected == true)
            {
                $scope.boton = true;
            }
            else
            {
                $scope.boton = false;
                $scope.id = "";
            }
        });
        
        $scope.refreshData = function (termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });
}]);
