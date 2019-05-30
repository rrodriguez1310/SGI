app.controller('BuscaCompras', ['$scope', 'comprasServices', 'Flash', '$http', '$filter', 'uiGridConstants', function ($scope, comprasServices, Flash, $http, $filter, uiGridConstants) {
    $scope.tablaDetalle = false;
    $scope.loader = true;
    $scope.cargador = loader;

    $scope.gridOptions = {  
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };
 
    $scope.gridOptions.columnDefs = [
        {name:'Id', displayName:'Id', visible: false, enableCellEdit: false},
        {name:'Codigo', displayName:'Cod.Req', enableCellEdit: false, 
            cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                if (angular.isNumber(grid.getCellValue(row,col))) {
                    return 'negro';
                }else{
                     return 'negro'; 
                }
            }
        },
        {name:'EmpresaRut', displayName:'Rut Emp.', enableCellEdit: false},
        {name:'Empresa', displayName:'Empresa', enableCellEdit: false},
        {name:'Titulo', displayName:'Titulo', enableCellEdit: false},
        {name:'Fecha', displayName:'Fecha', type: 'date', cellFilter: 'date:"yyyy-MMM-dd"', enableCellEdit: false},
        {name:'Total', displayName:'Total', enableCellEdit: false},
        {name:'NumeroSap', displayName:'N° Sap', enableCellEdit: true},
        {name:'Estado', displayName:'Estado', enableCellEdit: false, cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
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


            }
        },
        {name:'IdEstado', visible:false},
        {name:'EmpresaId', visible:false},
    ];
    
	$scope.msg = {};
	
	$scope.gridOptions.onRegisterApi = function(gridApi){
		$scope.gridApi = gridApi;
		gridApi.edit.on.afterCellEdit($scope,function(rowEntity, colDef, newValue, oldValue){
			$scope.msg.lastCellEdited = rowEntity.Id + ', ' + newValue ;
			$scope.$apply();
		});
	};

    $http.get(host25+'compras/buscar_compras_ingresado_sap/').success(function(data) {
        
        $scope.gridOptions.data = data;
        
        $scope.loader = false;
        $scope.tablaDetalle = true;

        $scope.refreshData = function (termObj) {
            $scope.gridOptions.data = data;
            
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
			
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){    
           
        });
 
    });
    
	$scope.$watch("msg.lastCellEdited", function(valorAeditar){
		if(angular.isUndefined(valorAeditar) == false)
		{
			if((valorAeditar.split(",")).length == 2)
			{
				datosEditar = valorAeditar.split(",");
				comprasServices.editCodigoSap(datosEditar[0], datosEditar[1]).success(function(mensaje){
				if(mensaje.Error === 0)
	                {
	                    Flash.create('danger', mensaje.Mensaje, 'customAlert');
	                }
	                else
	                {
	                    Flash.create('success', mensaje.Mensaje, 'customAlert');
	                }
				})
			}
		}
	}); 
}]);