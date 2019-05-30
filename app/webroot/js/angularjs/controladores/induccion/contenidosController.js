app.controller('contenidosController', ['$scope', '$http', '$filter', 'contenidosService', '$interval', 'uiGridGroupingConstants',  function($scope, $http, $filter, contenidosService,  $interval, uiGridGroupingConstants) {
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
            { name: 'peso', displayName: 'Orden' },
            { name: 'titulo', displayName: 'Contenido' },
            //{ name: 'leccion', displayName: 'Lección' },
            { name: 'leccion', grouping: { groupPriority: 0 }, sort: { priority: 0, direction: 'desc' }, width: '35%', cellTemplate: '<div><div ng-if="!col.grouping || col.grouping.groupPriority === undefined || col.grouping.groupPriority === null || ( row.groupHeader && col.grouping.groupPriority === row.treeLevel )" class="ui-grid-cell-contents" title="TOOLTIP">{{COL_FIELD CUSTOM_FILTERS}}</div></div>' },
            /*{ name: 'imagen', displayName: 'Imagen',
                cellTemplate: '<div class="text-center"> <a target="_blank" href="'+host+'app/webroot/files/induccion_contenido/image/{{row.entity.imagedir}}/vga_{{row.entity.image}}"><img style="padding:2px; lefth:10px;" ng-src="'+host+'app/webroot/files/induccion_contenido/image/{{row.entity.imagedir}}/thumb_{{row.entity.image}}"/></a></div>'},*/
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

    contenidosService.induccionList().success(function(response){
        $scope.gridOptions.data = response;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){ 
            $scope.imagedir = row.entity.imagedir;
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
        window.location.href = host + "induccionContenidos/delete/" + $scope.id
    };
}]);
