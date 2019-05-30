app.controller('MisCompras', ['$scope', '$http','comprasServices', 'Flash', 'uiGridConstants', '$filter',  function ($scope, $http, comprasServices, Flash, uiGridConstants, $filter) {
    $scope.tipoForm = "Registrar";
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

    $scope.gridOptions.columnDefs = [
            { name:'id', displayName: 'Id', visible : false},
            { name:'codigo', displayName: 'Codigo'},
            { name:'empresa', displayName: 'Empresa'},
            { name:'titulo', displayName: 'Titulo'},
            { name:'total', displayName: 'Total'},
            { name:'titulo', displayName: 'Titulo'},
            { name:'fecha', displayName: 'Fecha'}, 
            { name:'estado', displayName: 'Estado',
            cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
               if (grid.getCellValue(row,col) == "Eliminado" || grid.getCellValue(row,col) == "Rechazado Gerencia" || grid.getCellValue(row,col) == "Rechazado Sap") {
                    return 'angular_eliminado';
                }

                if (grid.getCellValue(row,col) == "Aprobado Gerencia") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row,col) == "Aprobado Incompleto Gerencia") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row,col) == "Facturado") {
                    return 'angular_facturado';
                }

                if (grid.getCellValue(row,col) == "Aprobado Incompleto Sap") {
                    return 'angular_aprobado_s';
                }

                if (grid.getCellValue(row,col) == "Aprobado Sap") {
                    return 'angular_aprobado_s';
                }

                if (grid.getCellValue(row,col) == "Pendiente Gerencia") {
                    return 'angular_pendiente_g';
                }

                if (grid.getCellValue(row,col) == "N. Credito") {
                    return 'angular_nota_credito';
                }
            }},
            { name:'estadoId', displayName: 'Estado Id', visible:false},
    ];

    comprasServices.misCompras().success(function(data){
    	
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;

        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            
            var idRequerimientos = [];

            if(row.isSelected == true)
            {
                $scope.botonVer = true;
                $scope.id = row.entity.id;

                if(row.entity.estadoId == 1){
                    $scope.botonEditar = true;
                    $scope.botonEliminar = true;
                    
                     if(angular.isNumber(row.entity.codigo)){
                        $scope.botonPlantilla = true;
                        $scope.botonPlantillaFac = false;
                    }else{
                       $scope.botonPlantilla = false;
                        $scope.botonPlantillaFac = true;
                        $scope.botonEditarDocumento = true
                        $scope.botonEditar = false;
                    }
                   // $scope.botonPlantilla = true;

                    $scope.botonClonarDocumento = false;
                    $scope.botonAsociarDocumento = false;
                    $scope.botonPlantillaFac = false;
                }

                if(row.entity.estadoId == 4 || row.entity.estadoId == 6){
                    if(row.entity.estadoId == 4 && angular.isNumber(row.entity.codigo)){
                        console.log(row.entity.codigo);
                       
                        $scope.botonAsociarDocumento = true;
                        idRequerimientos.push(row.entity.codigo)
                        console.log(idRequerimientos);
                        $scope.idsRequerimientos = idRequerimientos;
                        
                    }
                    if(angular.isNumber(row.entity.codigo)){
                        $scope.botonPlantilla = true;
                        $scope.botonPlantillaFac = false;
                    }else{
                        $scope.botonPlantilla = false;
                        $scope.botonPlantillaFac = true;
                    }
                    //$scope.botonPlantilla = true;
                    $scope.botonNotasCredito = true;
                    $scope.botonEditar = false;
                    $scope.botonEliminar = false;
                }

                if(row.entity.estadoId == 3 || row.entity.estadoId == 5){
                   $scope.botonClonarDocumento = true;
                   $scope.botonPlantilla = false;
                    $scope.botonNotasCredito = false;
                    $scope.botonEditar = false;
                    $scope.botonEliminar = false;
                    $scope.botonAsociarDocumento = false;
                    $scope.botonPlantillaFac = false;
                    if(angular.isNumber(row.entity.codigo)){
                        $scope.botonPlantilla = true;
                        $scope.botonPlantillaFac = false;
                    }else{
                        $scope.botonPlantilla = false;
                        $scope.botonPlantillaFac = true;
                    }
                }

            }else{
              $scope.botonVer = false;
              $scope.botonEditar = false;
              $scope.botonPlantilla = false;
              $scope.botonClonarDocumento = false;
              $scope.botonNotasCredito = false;
              $scope.botonEliminar = false;
              $scope.botonPlantillaFac = false;
              //$scope.id.length = 0
              if(row.isSelected == false){
                    if(row.entity.estadoId == 4 && angular.isNumber(row.entity.codigo)){
                        var posicion = idRequerimientos.indexOf(row.entity.id);
                        $scope.idsRequerimientos = idRequerimientos.splice(posicion, row.entity.id);
                        console.log($scope.idRequerimientos);
                    }       
                }
            }
        });


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
