app.controller('respuestasController', ['$scope', '$http', '$filter', 'respuestasService', 'uiGridGroupingConstants',  function($scope, $http, $filter, respuestasService, uiGridGroupingConstants) {
    $scope.id = 0;
    $scope.loader = true
    $scope.cargador = loader;

    $scope.gridOptions = {
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        enableFiltering: false,
        useExternalFiltering: true,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions = {
        //enableFiltering: true,
        treeRowHeaderAlwaysVisible: false,
        columnDefs: [
            { name: 'id', displayName: 'Id', visible: false },
            //{ name: 'pregunta', displayName: 'preguntas' },
            { name: 'leccion', displayName: 'Lección', grouping: { groupPriority: 0 }, sort: { priority: 0, direction: 'desc' }, width: '25%', cellTemplate: '<div><div ng-if="!col.grouping || col.grouping.groupPriority === undefined || col.grouping.groupPriority === null || ( row.groupHeader && col.grouping.groupPriority === row.treeLevel )" class="ui-grid-cell-contents" title="TOOLTIP">{{COL_FIELD CUSTOM_FILTERS}}</div></div>' },
            { name: 'pregunta', displayName: 'Preguntas', grouping: { groupPriority: 0 }, sort: { priority: 0, direction: 'desc' }, width: '25%', cellTemplate: '<div><div ng-if="!col.grouping || col.grouping.groupPriority === undefined || col.grouping.groupPriority === null || ( row.groupHeader && col.grouping.groupPriority === row.treeLevel )" class="ui-grid-cell-contents" title="TOOLTIP">{{COL_FIELD CUSTOM_FILTERS}}</div></div>' },
            { name: 'respuesta', displayName: 'Respuestas' },
            { name: 'correcta', displayName: 'Resp. Correcta',
                cellTemplate: '<div ng-if="row.entity.correcta > 0" >Correcta</div>  <div ng-if="row.entity.correcta < 1 "> Incorrecta </div>',
                cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                    if (grid.getCellValue(row,col) == "0" ) {
                            return 'incorrecta';
                    };
    
                    if (grid.getCellValue(row,col) == "1") {
                        return 'correcta';
                    }
                    
                }},
            { name: 'estado', displayName: 'Estados',
                cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                if (grid.getCellValue(row,col) == "Eliminado" ) {
                        return 'recognition_eliminado';
                };

                if (grid.getCellValue(row,col) == "Activo") {
                    return 'recognition_aprobado';
                }
                
            }}
        ],
        enableGridMenu: true,
        enableSelectAll: false,
        exporterCsvFilename: 'myFile.csv',
        exporterMenuPdf: false,
        multiSelect: false,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    respuestasService.induccionList().success(function(response){
        $scope.gridOptions.data = response;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){ 

            if(row.isSelected == true){
                $scope.id = row.entity.id;
                $scope.boton = true;
            }else{
                $scope.boton = false;
                $scope.id = 0;
            }
            
        });

        $scope.refreshData = function (termObj){
            $scope.gridOptions.data = response;
            while (termObj){
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    
    });

    $scope.confirmacion = function() {
        window.location.href = host + "induccionRespuestas/delete/" + $scope.id
    };

}]);
