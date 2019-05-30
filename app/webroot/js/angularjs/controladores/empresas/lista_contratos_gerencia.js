app.controller('EmpresasCtrl', ['$scope', '$http', 'listaContratosEmpresas', 'uiGridConstants', '$filter',  function ($scope, $http, listaContratosEmpresas, uiGridConstants, $filter) {
    var idSeleccionado;
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
            { name:'Id', displayName: 'Id', visible:false},
            { name:'Gerencia', displayName: 'Gerencia', visible:false},
            { name:'EmpresaRut', displayName: 'Rut', width:"100"},
            { name:'EmpresaRazonSocial', displayName: 'Razon Social'},
            { name:'FechaDocumento', displayName: 'Fecha Doc.', width:"110"},
            { name:'FechaInicio', displayName: 'Fecha Ini.', width:"110"},
            { name:'FechaVencimiento', displayName:'Fecha Venc.', width:"110", sort: {direction: uiGridConstants.ASC, priority: 2}},
            { name:'Observacion', displayName:'Observacion.'},
            { name:'Renovacion', displayName:'Renovación'},
            { name:'nombreTipoContrato', displayName:'Tipo contrato'},
            { name:'NotificacionEmail', displayName:'Notificacion Email', visible : false}, 
    ];
    
    $scope.log = function () {
        listaContratosEmpresas.logContratos(idSeleccionado).then(function (res){
            
        }).catch(function (err){
    
        })
    }
    
    listaContratosEmpresas.listaTodosLosContratosGerencias().success(function(data){
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(row.isSelected == true)
            { 
                idSeleccionado = row.entity.Id;
                $scope.boton = true;
                $scope.pathAdjunto = host+'files/contrato_empresas/'+row.entity.adjunto;
            }else{
                idSeleccionado = undefined;
                $scope.boton = false;
                $scope.pathAdjunto = "";
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
