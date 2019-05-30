app.controller('controllerMontosFijos', ['Flash', '$scope', '$http', '$filter', 'servicioMontosFijos', function(Flash, $scope, $http, $filter, servicioMontosFijos) {
    $scope.tablaDetalle = false;
    $scope.loader = true;
    $scope.cargador = loader;

    $scope.btnmontos_fondo_fijosdelete=true;
    $scope.btnmontos_fondo_fijosedit=true;

    $scope.montofijo=[];

    $scope.eliminarBtn=true;
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
        enableCellEdit: false,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        {name:'id', displayName: 'ID'},
        {name:'titulo', displayName: 'Titulo'},
        {name:'area', displayName: 'Area'},
        {name:'moneda', displayName: 'Moneda'},
        {name:'monto', displayName: 'Monto'},
        {name:'estado', displayName: 'Estado'},
        {name:'encargado', displayName: 'Encargado'}
    ];

    servicioMontosFijos.listaMontosFondoFijos().success(function(data){
    
            if(data.length > 0){
                $scope.loader = false
                $scope.tablaDetalle = true;
                $scope.gridOptions.data = data
            }

            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
              

                if(row.isSelected == true){
                    if(row.entity.id){
                        $scope.id = row.entity.id;
                        $scope.eliminarBtn = true;
                        $scope.boton = true;

                        
                    }
                }else{
                    $scope.boton = false;
                    row.entity.id.length = 0;
                    $scope.id = '';
                    $scope.eliminarBtn = false;
                }
                
            });    
            $scope.confirmacion = function(){
                if(angular.isDefined($scope.id)){
                    window.location.href = host+"montos_fondo_fijos/delete/"+$scope.id
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
        })


        
}]);
