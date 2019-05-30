app.controller('controllerRequerimientos', ['$scope', '$http', '$filter', 'solicitudesRequerimiento', function($scope, $http, $filter, solicitudesRequerimiento) {
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

    $scope.idRendicion=0;

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
        enableSorting: true,
        exporterMenuCsv: true,
        exporterMenuExcel: true,
        enableGridMenu: true, 
        onRegisterApi: function( gridApi ){
        $scope.gridApi = gridApi;
        }
    }

    $scope.gridOptions.columnDefs = [
        {name:'id', displayName: 'Id'},
        {name:'idSolicitud', displayName: 'Id Rendición'},
        {name:'titulo', displayName: 'Titulo'},
        {name:'dimensione_id', displayName: 'Gerencia'},
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

                if (grid.getCellValue(row,col) === "Por Aprobar") {
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
        /*{name:'codigos_presupuesto_id', displayName: 'Presupuesto'},
        {name:'estadios', displayName: 'Estadios'},
        {name:'proyectos', displayName: 'Proyectos'},
        {name:'canal_distribucion', displayName: 'Canal distribucion'},
        {name:'otros', displayName: 'Otros'},
        {name:'proyectos', displayName: 'Proyectos'},*/
        {name:'tipo_fondo', displayName: 'Tipo Fondo'},
        {name:'idEstadoCompraTarjeta', displayName: 'id Estado Compra Tarjeta', visible: false },
    ];

  

    solicitudesRequerimiento.listaRequerimientos().success(function(data){


        //$scope.loader = false
      //  if(data.length > 0){
            $scope.loader = false
            $scope.tablaDetalle = true;
            $scope.gridOptions.data = data
      //  }

       $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(row.isSelected == true){
                if(row.entity.id){

                    $scope.id = row.entity.id;
                    $scope.idSolicitud = row.entity.idSolicitud;
                    //$scope.eliminarBtn = true;
                    $scope.boton = true;
                }

                //$scope.btnsolicitudes_requerimientosdelete=false;
                //$scope.btnsolicitudes_requerimientosedit=false;

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
            }else{
                
                // $scope.btndelete='true';
                // $scope.btnedit='true';
                 //$scope.btndetalleRendicion = 'true';
                
                 row.entity.id.length = 0;
                $scope.id = '';
                $scope.eliminarBtn = false;
                $scope.boton = false;
                
            }
            
        });   
        
        
        $scope.confirmacion = function(){
            if(angular.isDefined($scope.id)){
                window.location.href = host+"solicitudes_requerimientos/delete/"+$scope.id
            }
        };



        $scope.detalleRendicion=function(){
            window.location.href = host+"solicitudes_requerimientos/view_detalleRendicion/"+$scope.idSolicitud
        }
    })


}]);


