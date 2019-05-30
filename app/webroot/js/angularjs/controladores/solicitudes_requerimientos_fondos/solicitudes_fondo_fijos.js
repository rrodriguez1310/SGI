app.controller('controllerRequerimientosTodos', ['$scope', '$http', '$filter', 'solicitudesRequerimiento', function($scope, $http, $filter, solicitudesRequerimiento) {
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
    $scope.showModal=false;


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
        {name:'titulo', displayName: 'Titulo'},
        {name:'dimensione_id', displayName: 'Gerencia'},
        {name:'fecha', displayName: 'Fecha'},
        {name:'tipos_moneda_id', displayName: 'Moneda'},
        {name:'monto', displayName: 'Monto Solicitado'},
        {name:'total', displayName: 'Total Rendido'},
        {name:'user_id', displayName: 'Usuario'},
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
            }
        },
       /* {name:'codigos_presupuesto_id', displayName: 'Cod. Presupuesto'},
        {name:'estadios', displayName: 'Estadios'},
        {name:'proyectos', displayName: 'Proyectos'},
        {name:'canal_distribucion', displayName: 'Canal distribucion'},
        {name:'otros', displayName: 'Otros'},*/
        {name:'tipo_fondo', displayName: 'Tipo Fondo'},
    ];

  

    solicitudesRequerimiento.listaGeneralFondoFijo().success(function(data){
        
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

                    if (row.entity.estado == "Rechazado Area" || 
                        row.entity.estado == "Rechazado Finanza"  
                        ) {
                        //$scope.btnsolicitudes_requerimientosdelete=true;
                       // $scope.btnsolicitudes_requerimientosedit=false;
                       angular.element('.btn-danger').css('display', 'none');
                       angular.element('.btn-success').css('display', 'none');
                       angular.element('.btn-primary').css('display', 'block');
                    } else if( row.entity.estado == "Aprobado Area" || row.entity.estado == "Aprobado Finanza"){
                       // $scope.btnsolicitudes_requerimientosdelete=true;
                        //$scope.btnsolicitudes_requerimientosedit=true;
                        angular.element('.btn-danger').css('display', 'none');
                        angular.element('.btn-success').css('display', 'none');
                        angular.element('.btn-primary').css('display', 'block');
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


