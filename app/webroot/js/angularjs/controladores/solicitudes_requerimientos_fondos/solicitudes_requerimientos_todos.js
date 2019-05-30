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
        {name:'idRendicion', displayName: 'Id Rendicion'},
        {name:'titulo', displayName: 'Titulo'},
        {name:'dimensione_id', displayName: 'Gerencia'},
        {name:'n_documento', displayName: 'N° Cheque'},
        {name:'fecha', displayName: 'Fecha'},
        {name:'tipos_moneda_id', displayName: 'Moneda'},
        {name:'monto', displayName: 'Monto'},
        {name:'user_id', displayName: 'Usuario'},
        {name:'estadoNombre', displayName: 'Estado',
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
                    return 'angular_pendiente_g';
                }

                if (grid.getCellValue(row,col) === "Finanza aprueba rendicion") {
                    return 'angular_aprobado_s';
                }

                if (grid.getCellValue(row,col) === "Por Aprobar") {
                    return 'angular_aprobado_g';
                }
            }
        },
        {name:'tipo_fondo', displayName: 'Tipo Fondo'},
        {name:'idEstadoCompraTarjeta', displayName: 'Tipo Fondo',  visible:false},
    ];

    solicitudesRequerimiento.listaTodos().success(function(data){
        
   
            $scope.loader = false
            $scope.tablaDetalle = true;
            $scope.gridOptions.data = data
      

       $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(row.isSelected == true){
                if(row.entity.id){

                    $scope.id = row.entity.id;
                    $scope.idRendicion = row.entity.idRendicion;
                    $scope.eliminarBtn = true;
                    $scope.boton = true;
                }



                switch(row.entity.estadoNombre) {
                    case "Rechazado Area":
                    case "Rechazado Finanza":
                        angular.element('.btn-naranjo').css('display', 'none');
                        angular.element('.btn-primary').css('display', 'block');
                        angular.element('.btn-danger').css('display', 'block');
                        angular.element('.btn-success').css('display', 'block');
                        
                        //$scope.btndelete='false';
                        //$scope.btnedit='true';
                        //$scope.btndetalleRendicion = 'false';
                        console.log(1)
                        break;
                        
                    case "Aprobado Area":
                    case "Aprobado Finanza":
                        angular.element('.btn-naranjo').css('display', 'none');
                        angular.element('.btn-primary').css('display', 'block');
                        angular.element('.btn-danger').css('display', 'none');
                        angular.element('.btn-success').css('display', 'none');
                        //$scope.btndelete='false';
                        //$scope.btnedit='false';
                        /*
                        if(row.entity.id_rendicion!=''){
                        $scope.btndetalleRendicion = 'true';
                        }else{
                        $scope.btndetalleRendicion = 'false';
                        }*/
                        
                        console.log(2)
                        break;

                    case "Por Rendir":
                        angular.element('.btn-naranjo').css('display', 'none');
                        angular.element('.btn-primary').css('display', 'block');
                        angular.element('.btn-danger').css('display', 'none');
                        angular.element('.btn-success').css('display', 'none');
                        //$scope.btndelete='false';
                        //$scope.btnedit='false';
                        //$scope.btndetalleRendicion = 'false';
                        console.log(3)
                        break;
                        
                    case "Area rechaza rendicion":
                    case "Area aprueba rendicion":
                    case "Por Aprobar":
                        angular.element('.btn-naranjo').css('display', 'block');
                        angular.element('.btn-primary').css('display', 'block');
                        angular.element('.btn-danger').css('display', 'none');
                        angular.element('.btn-success').css('display', 'none');
                        //$scope.btndelete='false';
                        //$scope.btnedit='false';
                        //$scope.btndetalleRendicion = 'true';
                        console.log(4)
                        break; 
                        
                    case "Finanza aprueba rendicion":
                    case "Finanza rechaza rendicion":
                        angular.element('.btn-naranjo').css('display', 'block');
                        angular.element('.btn-primary').css('display', 'block');
                        angular.element('.btn-danger').css('display', 'none');
                        angular.element('.btn-success').css('display', 'none');
                        
                        //$scope.btndetalleRendicion = true;
                        //$scope.btndelete='false';
                        //$scope.btnedit='false';
                        console.log(5)
                        break; 
                        
                    case "En Curso":
                        angular.element('.btn-naranjo').css('display', 'none');
                        angular.element('.btn-primary').css('display', 'block');
                        angular.element('.btn-danger').css('display', 'block');
                        angular.element('.btn-success').css('display', 'block');
                        $scope.boton = true;
                        //$scope.btndetalleRendicion = false;
                        //$scope.btndelete=true;
                        //$scope.btnedit=true;
                        break;
                        
                }


                /*switch(row.entity.idEstadoCompraTarjeta) {
                    case 5://"Rechazado Area"
                    case 7://"Rechazado Finanza"
                
                        $scope.btnsolicitudes_requerimientosdelete=true;
                        $scope.btnsolicitudes_requerimientosedit=false;
                        $scope.btnsolicitudes_requerimientosdetalleRendicion = true;
                    break;
                    case 1://"Aprobado Area"
                    case 4://"Aprobado Finanza"
                   
                        $scope.btnsolicitudes_requerimientosdelete=true;
                        $scope.btnsolicitudes_requerimientosedit=true;

                        if(row.entity.id_rendicion!=''){
                            $scope.btnsolicitudes_requerimientosdetalleRendicion = false;
                        }else{
                            $scope.btnsolicitudes_requerimientosdetalleRendicion = true;
                        }
                        
                        break;

                    case 4://"Por Rendir"
                        $scope.btnsolicitudes_requerimientosdelete=true;
                        $scope.btnsolicitudes_requerimientosedit=true;
                        $scope.btnsolicitudes_requerimientosdetalleRendicion = true;
                    break;
                    case 5://"Area rechaza rendicion"
                    case 7://"Area aprueba rendicion"
                    case 10://"Por Aprobar"
                        $scope.btnsolicitudes_requerimientosdelete=true;
                        $scope.btnsolicitudes_requerimientosedit=true;
                        $scope.btnsolicitudes_requerimientosdetalleRendicion = false;
                    break; 
                    case 1://"Finanza aprueba rendicion"
                    case 4://"Finanza rechaza rendicion"
                        $scope.btnsolicitudes_requerimientosdelete=true;
                        $scope.btnsolicitudes_requerimientosedit=true;
                        $scope.btnsolicitudes_requerimientosdetalleRendicion = false;
                    break; 
                    case 3://"En Curso"
                        $scope.btnsolicitudes_requerimientosdetalleRendicion = true;

                    break; 
                }*/
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

        $scope.detalleRendicion=function(){
            window.location.href = host+"solicitudes_requerimientos/view_detalleRendicionTodos/"+$scope.idRendicion
        }
    })


}]);


