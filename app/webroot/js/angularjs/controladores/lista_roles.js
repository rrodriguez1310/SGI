app.controller('ComprasReportes', ['$scope', 'listaRoles', '$http', '$filter', '$location', 'uiGridConstants', 'Flash', 'rolesFactory', function ($scope, listaRoles, $http, $filter, $location, uiGridConstants, Flash, rolesFactory) {
    $scope.loader = true
    $scope.cargador = loader;
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
        {name:'Id', displayName:'Id', visible: true, sort : {direction: uiGridConstants.ASC,priority: 1}},
        {name:'Nombre', displayName:'Nombre', width: '70%'},
        {name: 'Usuarios Asoc.',
             cellTemplate:'<div class="text-center"><a href="" ng-click="grid.appScope.listaUsuarios(row.entity.Id)" ><i class="fa fa-user"> </i></a></div>' 
        }
    ];
    listaRoles.listaRoles().success(function(data){
        $scope.gridOptions.data = rolesFactory.rolesActivos(data);
        $scope.loader = false;
        $scope.tablaDetalle = true;
         $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(row.isSelected == true)
            {
                $scope.id = row.entity.Id;
                $scope.boton = true;
            }
            else
            {
                $scope.id = "";
                $scope.boton = false;
            }
         });

        $scope.listaUsuarios = function(id){
             listaRoles.usuarioRoles(id).success(function(dataUsuarios){
                

                if(dataUsuarios.length > 0)
                {

                    $scope.showModal = true;
                    $scope.titulo = "Usuario asociados" ;
                    $scope.rolAsociado = 
                    $scope.usuarios = dataUsuarios    
                }else {
                    Flash.create('danger', 'Sin usuarios asociados', 'customAlert');
                }

                console.log(dataUsuarios);
                
            })
        };

        $scope.cerrarModal = function (){
            $scope.showModal = false;
        };

        $scope.refreshData = function (termObj){
            $scope.gridOptions.data = rolesFactory.rolesActivos(data);
            while (termObj){
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });

    $scope.confirmacion = function(){
        listaRoles.delete($scope.id).success(function (data){
            if(data.estado == 1 ){
                 Flash.create('success', data.mensaje, 'customAlert');
                 listaRoles.listaRoles().success(function(data){
                    $scope.gridOptions.data = rolesFactory.rolesActivos(data);
                    $scope.gridApi.selection.clearSelectedRows();
                 });
            }else{
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
}]);