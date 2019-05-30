"use strict";
app.controller('ProduccionListaCorreos', ['$scope', '$http','$filter', 'produccionListaCorreos', 'Flash', '$timeout', '$window', '$rootScope', function($scope, $http, $filter, produccionListaCorreos,Flash, $timeout, $window, $rootScope) {
	$scope.loader = true;
	$scope.cargador = loader;
	$scope.gridOptions = {
		columnDefs: [
			{ name:'id', displayName: 'id', width:90, visible:false},
			{ name:'nombre', displayName: 'Lista Correos', width:240},
			{ name:'email', displayName: 'Contactos'}
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

	produccionListaCorreos.listadoListaCorreos().success(function(data){

		$scope.loader = false;
		$scope.tablaDetalle = true;

   	$scope.gridOptions.data = data;
		$scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){			

			if(row.isSelected == true)
			{
				if(row.entity.id){
					$scope.id = row.entity.id;
					$scope.btnproduccion_lista_correosdelete  = false;
					$scope.btnproduccion_lista_correosedit  = false;
					$scope.boton = true; 
				}
			}
			else
			{
				$scope.boton = false;
			}
		});
		
		$scope.confirmacion = function(){
			if(angular.isDefined($scope.id)){
				window.location.href = host+"produccion_lista_correos/delete_produccion_lista_correos/"+$scope.id	
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


app.controller('ListaAddCorreo', ['$scope', '$q', '$http', '$filter', '$location', 'uiGridConstants','Flash', 'produccionListaCorreos', function ($scope, $q,$http, $filter, $location, uiGridConstants, Flash, produccionListaCorreos) {
    
    $scope.tablaDetalle = false;
    $scope.loader = true
    $scope.cargador = loader;
    angular.element(".tool").tooltip();

    $scope.idLista = $location.absUrl().split("/")
    $scope.idLista = $scope.idLista[$scope.idLista.length - 1];

    $scope.gridOptions = { 
        enableColumnResizing : true,
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
        }
    };
    
    $scope.gridOptions.columnDefs = [
        {name:'id', displayName:'Id', visible : false},
        {name:'nombre', displayName:'Nombre'},
        {name:'email', displayName:'Email'},
        {field:'contiene', displayName:'Ok',  width: '5%', cellTemplate:"<div class='ui-grid-cell-contents text-center' ng-if="+'"'+"row['entity']['lista']=="+$scope.idLista+'"'+"><i class='fa fa-check'></i></div>"},
    ];

    var addContactos = function (){
        var promesas = [];
        promesas.push(produccionListaCorreos.contactosListaCorreos($scope.idLista));  

        $q.all(promesas).then(function (data){
            
            $scope.gridOptions.data = data[0].data;
            $scope.loader = false;
            $scope.tablaDetalle = true;

            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){                
				if(row.isSelected == true)
				{
					$scope.id = row.entity.id;
					console.log($scope.id);

					if(angular.isUndefined(row["entity"]["lista"])){
					   $scope.hideAddContactoLista = true;
					   $scope.delContactoLista = false;
					}else{
					   $scope.hideAddContactoLista = false;
					   $scope.delContactoLista = true;
					}
				}
				else
				{
				  $scope.id = "";
				  $scope.boton = false;
				  $scope.asignaPaginaRol = false;
				  $scope.nombreRoles = "";
				}
            });
             
            $scope.refreshData = function (termObj){
                $scope.gridOptions.data = data[0].data;
                while (termObj){
                    var oSearchArray = termObj.split(' ');
                    $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                    oSearchArray.shift();
                    termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                }
            };
        });
    };
    addContactos();
	
	$scope.addContactoLista = function(){		
		if($scope.idLista != "" && $scope.id != "" && angular.isNumber($scope.id)) 
		{	
			produccionListaCorreos.addContactoLista($scope.idLista, $scope.id).success(function(data){
				
				if(data.estado === 0)
				{
					Flash.create('danger', data.mensaje, 'customAlert');
				}
				else
				{
					addContactos();
					$scope.gridApi.selection.clearSelectedRows();
					$scope.search = undefined;
					$scope.hideAddContactoLista = false;
					Flash.create('success', data.mensaje, 'customAlert');
				}
			});

      }
    };

    $scope.deleteContactoLista = function(){
        if($scope.idLista != "" && $scope.id != "" && angular.isNumber($scope.id)) 
        {
            produccionListaCorreos.deleteContactoLista($scope.idLista, $scope.id).success(function (data){                
                if(data.estado == 1)
                {
                    addContactos();
                    $scope.gridApi.selection.clearSelectedRows();
                    $scope.search = undefined;
                    $scope.delContactoLista = false;
                    Flash.create('success', data.mensaje, 'customAlert');
                }
                else
                {
                    Flash.create('danger', data.mensaje, 'customAlert');
                }
            })
        }
    };
}]);