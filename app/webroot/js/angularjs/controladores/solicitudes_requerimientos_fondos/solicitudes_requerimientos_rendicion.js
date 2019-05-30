app.controller('controllerRequerimientosRendicion', ['$scope', '$http', '$filter', 'solicitudesRequerimiento', function($scope, $http, $filter, solicitudesRequerimiento) {
    $scope.tablaDetalle = false;
    $scope.loader = true;
    $scope.cargador = loader;
    var i=1;
    var listaRendicion = [];
    $scope.rendicion = [];
    $scope.rendicionList = [];
   // $scope.guardarRendicion = [];
    //$scope.formularioSolicitud = [];
    $scope.total = [];
    $scope.totalx = 0;
    $scope.documetosRendicion = [];

    $scope.showModal=false;

    $scope.totalGastos=0;
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
        exporterMenuCsv: true,
        exporterMenuExcel: true,
        enableGridMenu: true, 
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [

        {name:'id', displayName: 'Id'},
        {name:'n_documento', displayName: 'Folio'},
        {name:'titulo', displayName: 'Titulo'},
        {name:'user_id', displayName: 'Usuario'},
        {name:'fecha', displayName: 'Fecha'},
        {name:'dimensione_id', displayName: 'Gerencia'},
        {name:'estadios', displayName: 'Estadios'},
        {name:'estado', displayName: 'Estado',
        enableCellEdit: false, 

    cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
        
                    if (grid.getCellValue(row,col) === "Aprobado Area") {
                        return 'angular_aprobado_g';
                    }
        
                    if (grid.getCellValue(row,col) === "Aprobado Finanza") {
                        return 'angular_aprobado_s';
                    }
        
                    if (grid.getCellValue(row,col) === "Rechazado Area") {
                        return 'angular_rojo';
                    }
        
                    if (grid.getCellValue(row,col) === "Rechazado Finanza") {
                        return 'angular_rojo';
                    }
        
                    if (grid.getCellValue(row,col) === "En Curso") {
                        return 'angular_pendiente_g';
                    }

                    if (grid.getCellValue(row,col) === "Por Rendir") {
                        return 'angular_aprobado_s';
                    }

                    if (grid.getCellValue(row,col) === "Por Aprobar") {
                        return 'angular_aprobado_g';
                    }
            }
        },
        /*{name:'canal_distribucion', displayName: 'Canal distribucion'},
        {name:'otros', displayName: 'Otros'},
        {name:'proyectos', displayName: 'Proyectos'},*/ 
        {name:'tipo_fondo', displayName: 'Tipo Fondo'},
        //{name:'codigos_presupuesto_id', displayName: 'Presupuesto'},
        {name:'tipos_moneda_id', displayName: 'Moneda'},
        {name:'monto', displayName: 'Monto'},
    ];

    


    solicitudesRequerimiento.listaSolicitudRendicon().success(function(data){
        
        //if(data.length > 0){
            $scope.loader = false
            $scope.tablaDetalle = true;
            $scope.gridOptions.data = data
        //}

       $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(row.isSelected == true){
                if(row.entity.id){

                    $scope.id = row.entity.id;
                    $scope.eliminarBtn = true;
                    $scope.boton = true;
                }

                    if (row.entity.estado == "Por Rendir") {
                        $scope.btnsolicitudes_requerimientosedit=true;
                        $scope.btnsolicitudes_requerimientosdelete=true;
                        $scope.btnsolicitudes_requerimientosadd=false;
                    } else if(row.entity.estado == "Por Aprobar"){
                        $scope.btnsolicitudes_requerimientosedit=false;
                        $scope.btnsolicitudes_requerimientosadd=true;
                        $scope.btnsolicitudes_requerimientosdelete=false;
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
                window.location.href = host+"solicitudes_requerimientos/delete/"+$scope.id
            }
        };

       /* $scope.refreshData = function (termObj){
            $scope.gridOptions.data = data;
            while (termObj){
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };*/
    })


}]);


