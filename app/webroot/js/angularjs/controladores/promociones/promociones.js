app.controller('indexPromocionesCtrl', function($scope, factoria, promocionesService, uiGridConstants, Flash){
	$scope.cargador = loader;
	$scope.loader = true;
	promocionesData = [];
	cargarPromociones();
	$scope.gridOptions = {
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false, 
        enableSorting: true,
        enableColumnResizing: true,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
		        if(angular.isNumber(row.entity.id))
		        {
		            $scope.id = row.entity.id;
		        }
		        if(row.isSelected == true)
		        {
		        	$scope.boton = true;
		        }
		        else
		        {
		            $scope.boton = false;
		            $scope.id = undefined;
		        }
		    });
        }
    };
	$scope.gridOptions.columnDefs = [
    	{name:'nombre', displayName: 'Nombre', cellFilter : "uppercase"},
    	{name:'descripcion', displayName: 'Descripción', cellFilter : "uppercase"},
    	{name:'company_nombre', displayName: 'Compañia', cellFilter : "uppercase"},
    	{name:'channel_nombre', displayName: 'Canal', cellFilter : "uppercase"},
    	{name:'estado', displayName: 'Estado', cellFilter : "uppercase"},
    ];
   	function cargarPromociones (){
   		promocionesService.promociones().success(function (promociones){
			promocionesData = promociones;
			$scope.gridOptions.data = promocionesData;
			$scope.loader = false;
			$scope.contenido = true;
		});	
   	}	
	$scope.refreshData = function (termObj){
		$scope.gridOptions.data = factoria.buscadorUiGrid(termObj, promocionesData);
	}

	$scope.confirmacion = function (){
		promocionesService.delete($scope.id).success(function (respuesta){
			if(respuesta.status == "OK"){
				Flash.create("success", respuesta.message, "customAlert")
				cargarPromociones();
			}else{
				Flash.create("danger", respuesta.message, "customAlert")
			}
		}).error(function (err){
			Flash.create("danger", "Ocurrio un error, por favor comunicarlo al administrador", "customAlert");
		});
	}

});