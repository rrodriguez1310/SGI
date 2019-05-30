"use strict";
app.controller('ProduccionContatos', ['$scope', '$http','$filter', 'produccionContactos', 'Flash', '$timeout', '$window', '$rootScope', function($scope, $http, $filter, produccionContactos,Flash, $timeout, $window, $rootScope) {
	$scope.loader = true;
	$scope.cargador = loader;
	$scope.gridOptions = {
		columnDefs: [
			{ name:'id', displayName: 'id', width:90, visible:false},
			{ name:'nombre', displayName: 'Nombre'},
			{ name:'email', displayName: 'Email'}			
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

	produccionContactos.listaContactos().success(function(contactos){
		$scope.loader = false;
		$scope.tablaDetalle = true;

   	$scope.gridOptions.data = contactos;
		$scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){			

			if(row.isSelected == true)
			{
				if(row.entity.id){
					$scope.id = row.entity.id;
					$scope.btnproduccion_contactosdelete  = false;
					$scope.btnproduccion_contactosedit  = false;
					$scope.boton = true; 
				}
			}else{
				$scope.boton = false;
			}
		});		
		$scope.confirmacion = function(){
			if(angular.isDefined($scope.id)){
				window.location.href = host+"produccion_contactos/delete_produccion_destinatarios/"+$scope.id	
			}
		};
		$scope.refreshData = function (termObj){
	       $scope.gridOptions.data = contactos;
	       while (termObj){
	           var oSearchArray = termObj.split(' ');
	           $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
	           oSearchArray.shift();
	           termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
	       }
	   };		
	});
}]);
app.controller('ProduccionExternos', ['$scope', '$http','$filter', 'produccionContactos', 'Flash', '$timeout', '$window', '$rootScope', function($scope, $http, $filter, produccionContactos,Flash, $timeout, $window, $rootScope) {
	$scope.loader = true;
	$scope.cargador = loader;
	$scope.gridOptions = {
		columnDefs: [
			{ name:'id', displayName: 'id', width:90, visible:false},
			{ name:'nombre', displayName: 'Nombre'},
			{ name:'tipo_contacto', displayName: 'Cargo'},
			{ name:'email', displayName: 'Email'},
			{ name:'telefono', displayName: 'Teléfono'}
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

	produccionContactos.listaExternos().success(function(externos){
		$scope.loader = false;
		$scope.tablaDetalle = true;

   	$scope.gridOptions.data = externos;
		$scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){			

			if(row.isSelected == true)
			{
				if(row.entity.id){
					$scope.id = row.entity.id;
					$scope.btnproduccion_contactosdelete  = false;
					$scope.btnproduccion_contactosedit  = false;
					$scope.boton = true; 
				}
			}else{
				$scope.boton = false;
			}
		});		
		$scope.confirmacion = function(){
			if(angular.isDefined($scope.id)){
				window.location.href = host+"produccion_contactos/delete_produccion_externos/"+$scope.id	
			}
		};
		
		$scope.refreshData = function (termObj){
	       $scope.gridOptions.data = externos;
	       while (termObj){
	           var oSearchArray = termObj.split(' ');
	           $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
	           oSearchArray.shift();
	           termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
	       }
	   };		
	});
}]);
app.controller('ProduccionResponsables', ['$scope', '$http','$filter', 'produccionContactos', 'Flash', '$timeout', '$window', '$rootScope', function($scope, $http, $filter, produccionContactos,Flash, $timeout, $window, $rootScope) {
	$scope.loader = true;
	$scope.cargador = loader;
	$scope.gridOptions = {
		columnDefs: [
			{ name:'id', displayName: 'id', width:90, visible:false},
			{ name:'nombre', displayName: 'Nombre'},
			{ name:'tipo_contacto', displayName: 'Cargo'},
			{ name:'email', displayName: 'Email'},
			{ name:'telefono', displayName: 'Teléfono'}
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

	produccionContactos.listaResponsables().success(function(responsables){
		$scope.loader = false;
		$scope.tablaDetalle = true;

   	$scope.gridOptions.data = responsables;
		$scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){

			if(row.isSelected == true)
			{
				if(row.entity.id){
					$scope.id = row.entity.id;
					$scope.btnproduccion_contactosdelete  = false;
					$scope.btnproduccion_contactosedit  = false;
					$scope.boton = true; 
				}
			}else{
				$scope.boton = false;
			}
		});
		$scope.confirmacion = function(){
			if(angular.isDefined($scope.id)){
				window.location.href = host+"produccion_contactos/delete_produccion_responsables/"+$scope.id	
			}
		};
		
		$scope.refreshData = function (termObj){
	       $scope.gridOptions.data = responsables;
	       while (termObj){
	           var oSearchArray = termObj.split(' ');
	           $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
	           oSearchArray.shift();
	           termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
	       }
	   };
	});
}]);

app.controller('ProduccionNombres', ['$scope', '$http','$filter', 'produccionContactos', 'Flash', '$timeout', '$window', '$rootScope', function($scope, $http, $filter, produccionContactos,Flash, $timeout, $window, $rootScope) {
	$scope.loader = true;
	$scope.cargador = loader;
	$scope.gridOptions = {
		columnDefs: [
			{ name:'id', displayName: 'id', width:90, visible:false},
			{ name:'rut', displayName: 'Rut', visible:false},
			{ name:'nombre_sistema', displayName: 'Nombre Sistema'},			
			{ name:'nombre_produccion', displayName: 'Nombre Corregido'},
			{ name:'cargo', displayName: 'Cargo'}
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

	produccionContactos.listaTrabajadores().success(function(trabajadores){
		$scope.loader = false;
		$scope.tablaDetalle = true;

   	$scope.gridOptions.data = trabajadores;
		$scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){

			if(row.isSelected == true)
			{
				if(row.entity.id){
					$scope.id = row.entity.id;
					$scope.btnproduccion_contactosdelete  = false;
					$scope.btnproduccion_contactosedit  = false;
					$scope.boton = true; 
				}
			}else{
				$scope.boton = false;
			}
		});
		$scope.confirmacion = function(){
			if(angular.isDefined($scope.id)){
				window.location.href = host+"produccion_contactos/delete_produccion_responsables/"+$scope.id	
			}
		};
		
		$scope.refreshData = function (termObj){
	       $scope.gridOptions.data = trabajadores;
	       while (termObj){
	           var oSearchArray = termObj.split(' ');
	           $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
	           oSearchArray.shift();
	           termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
	       }
	   };
	});
}]);