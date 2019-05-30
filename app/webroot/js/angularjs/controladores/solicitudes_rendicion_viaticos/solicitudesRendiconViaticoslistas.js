app.controller('controllerSolicitudesViaticos', ['$scope', '$http', '$filter', 'solicitudesRendicionviaticos', function($scope, $http, $filter, solicitudesRendicionviaticos) {
    $scope.tablaDetalle = false;
    $scope.loader = false;
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
        {name:'id', displayName: 'id'},
        {name:'titulo', displayName: 'Titulo'},
        {name:'fecha_inicio', displayName: 'F. Inicio'},
        {name:'fecha_termino', displayName: 'F. Termino'},
       // {name:'hora_inicio', displayName: 'H. Inicio'},
        //{name:'hora_termino', displayName: 'H. Termino'},
        {name:'responsable', displayName: 'Responsable'},
        {name:'moneda', displayName: 'Moneda'},
        {name:'total', displayName: 'Total'},
        {name:'estado', displayName: 'Estado',
        enableCellEdit: false, 
        cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
     
                    if (grid.getCellValue(row,col) === "Aprobado Area") {
                        $scope.btnsolicitud_requerimiento_viaticosdelete=true;
                        //$scope.btnsolicitud_requerimiento_viaticosedit=true;
                    return 'angular_aprobado_g';
                    }
        
                    if (grid.getCellValue(row,col) === "Aprobado Finanza") {
                        $scope.btnsolicitud_requerimiento_viaticosdelete=true;
                        //$scope.btnsolicitud_requerimiento_viaticosedit=true;
                    return 'angular_aprobado_s';
                    }
        
                    if (grid.getCellValue(row,col) === "Rechazado Area") {
                        $scope.btnsolicitud_requerimiento_viaticosdelete=true;
                    // $scope.btnsolicitud_requerimiento_viaticosedit=true;
                    return 'angular_rojo';
                    }
        
                    if (grid.getCellValue(row,col) === "Rechazado Finanza") {
                        $scope.btnsolicitud_requerimiento_viaticosdelete=true;
                        //$scope.btnsolicitud_requerimiento_viaticosedit=false;
                    return 'angular_rojo';
                    }
        
                    if (grid.getCellValue(row,col) === "En Curso") {
                        $scope.btnsolicitud_requerimiento_viaticosdelete=true;
                        //$scope.btnsolicitud_requerimiento_viaticosedit=true;
                    return 'angular_pendiente_g';
                    }
            }   }
    ];

    $scope.carga = function(area){
        solicitudesRendicionviaticos.listaRendicionViaticos(area).success(function(data){
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

                if (row.entity.estado == "Rechazado Area" || row.entity.estado == "Rechazado Finanza") {
                    console.log("1")
                    //$scope.btnsolicitudes_requerimientosdelete=false;
                    //$scope.btnsolicitud_requerimiento_viaticosedit=false;
                } else if (row.entity.estado == "Aprobado Area" || row.entity.estado == "Aprobado Finanza" ){
                   // $scope.btnsolicitud_requerimiento_viaticosdelete=true;
                   // $scope.btnsolicitud_requerimiento_viaticosedit=true;
                    console.log("2")
                   angular.element('.btn-danger').css('display', 'none');
                   angular.element('.btn-success').css('display', 'none');
                   angular.element('.btn-primary').css('display', 'block');

                }else if ( row.entity.estado == "En Curso" ){
                   // $scope.btnsolicitudes_requerimientosdelete=true;
                    //$scope.btnsolicitud_requerimiento_viaticosdelete=false;
                    //$scope.btnsolicitud_requerimiento_viaticosedit=false;
                    console.log("3")

                    angular.element('.btn-danger').css('display', 'block');
                    angular.element('.btn-success').css('display', 'block');
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
                window.location.href = host+"solicitud_requerimiento_viaticos/delete/"+$scope.id
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
    }

    var sum = [];
    $scope.submit = function() {
        //console.log("rendicion ----> cant " , $scope.rendicion.monto)
        sum.push($scope.rendicion.precio.replace(/\./g,''))
        $scope.total = eval(sum.join("+"))
        solicitudesRendicion.formularioRendicionFondo($scope.rendicion).success(function(data){
         
            listaRendicion.push(data);
            $scope.gridOptions.data = listaRendicion;
            $scope.rendicion=undefined;
            $scope.myFormulario.$setPristine();

            $("#dimUno").select2('destroy').val('').select2();
           /* $("#dimDos").select2('destroy').val('').select2();
            $("#dimTres").select2('destroy').val('').select2();
            $("#dimCuatro").select2('destroy').val('').select2();
            $("#dimCinco").select2('destroy').val('').select2();
            $("#proyecto").select2('destroy').val('').select2();
            $("#proveedor").select2('destroy').val('').select2();
            $("#empaque").select2('destroy').val('').select2();*/
            $("#codigoPresupuestario").select2('destroy').val('').select2();

            $scope.rendicion = {};
            $scope.sumaResta();
        });  
    };


   /* $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
solicitudesRequerimiento
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
        
    });*/

    $scope.guardaRendicionSubmit = function(){
       solicitudesRendicion.guardaRedicionFondos($scope.guardarRendicion, listaRendicion, $scope.documetosRendicion, $scope.total).success(function(data){
               window.location.href = host+"solicitud_requerimiento_viaticos";
        });
    }

    $scope.sumaResta = function() {
        var sum = []; 
        var selectedRowEntities = $scope.gridOptions.data;
            angular.forEach(selectedRowEntities, function(rowEntity, key) {
                sum.push(rowEntity.sub)
            })
        $scope.totalGastos = eval(sum.join("+"));

        console.log($scope.totalGastos);
    }
}]);
