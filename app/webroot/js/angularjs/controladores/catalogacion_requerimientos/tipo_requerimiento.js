"use strict";
app.controller('CatalogacionRTipo', ['$scope', '$http','$filter', 'tipoRequerimiento', 'Flash', '$timeout', '$window', '$rootScope', function($scope, $http, $filter, tipoRequerimiento,Flash, $timeout, $window, $rootScope) {
	$scope.loader = true;
	$scope.cargador = loader;
	$scope.gridOptions = {
		columnDefs: [
			{ name:'id', displayName: 'id', width:90},
			{ name:'nombre', displayName: 'Tipo Requerimiento'},
		],
		enableGridMenu: true,
		enableSelectAll: false,
		exporterCsvFilename: 'myFile.csv',
		exporterMenuPdf: false,
		multiSelect: false,
		exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
		onRegisterApi: function(gridApi){
			$scope.gridApi = gridApi;
		}
	};

	tipoRequerimiento.listaRequerimientos().success(function(data){
		$scope.loader = false;
		$scope.tablaDetalle = true;

   	$scope.gridOptions.data = data;
		$scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){			

			if(row.isSelected == true)
			{
				if(row.entity.id){
					$scope.id = row.entity.id;
					$scope.btncatalogacion_r_tiposdelete  = false;
					$scope.btncatalogacion_r_tiposedit  = false;
					$scope.boton = true; 
				}
			}else{
				$scope.boton = false;
			}
		});
		$scope.confirmacion = function(){
			if(angular.isDefined($scope.id)){
				window.location.href = host+"catalogacion_r_tipos/delete/"+$scope.id	
			}
		};
		
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