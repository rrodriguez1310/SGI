app.controller('controllerGerenciaCompras', ['$scope', '$http', '$filter', 'gerenciaCompraTarjeta', function($scope, $http, $filter, gerenciaCompraTarjeta) {
    $scope.tablaDetalle = false;
    $scope.loader = false;
    $scope.cargador = loader;
    $scope.eliminarBtn = false;




   // $scope.btncompras_tarjetasedit=true;
   // $scope.btncompras_tarjetasdelete=true;

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
        {name:'fechaRequerimiento', displayName: 'Fecha Requerimiento'},
        {name:'fecha_compra', displayName: 'Fecha Compra'},
        {name:'url_producto', displayName: 'Producto'},
        {name:'monto', displayName: 'Monto'},
        {name:'cuota', displayName: 'Cuota'},
        {name:'motivo_rechazo', displayName: 'Motivo Rechazo'},
        {name:'moneda', displayName: 'Moneda'},
        {name:'codigos_presupuesto_id', displayName: 'Estado Presupuesto'},
        {name:'dimencione_id', displayName: 'Gerencia'},

        {name:'compras_tarjetas_estado_id', displayName:'Estado Compra', enableCellEdit: false, cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
         
               /*
                if (grid.getCellValue(row,col) == "Aprobado Area") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row,col) == "AprobadgerenciaCompraTarjetao Finanza") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row,col) == "Aprobado Gerencia") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row,col) == "Rechazado Area") {
                    return 'angular_eliminado';
                }

                if (grid.getCellValue(row,col) == "Rechazado Finanza") {
                    return 'angular_eliminado';
                }

                if (grid.getCellValue(row,col) == "Rechazado Gerencia") {
                    return 'angular_eliminado';
                }
                */
                if (grid.getCellValue(row,col) == "Aprobado Area") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row,col) == "Aprobado Finanza") {
                    return 'angular_aprobado_s';
                }

                if (grid.getCellValue(row,col) == "Comprado") {
                    return 'angular_aprobado_s';
                }

                if (grid.getCellValue(row,col) == "Aprobado Gerencia") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row,col) == "Rechazado Area") {
                    return 'angular_eliminado';
                }

                if (grid.getCellValue(row,col) == "Rechazado Finanza") {
                    return 'angular_eliminado';
                }

                if (grid.getCellValue(row,col) == "Rechazado Gerencia") {
                    return 'angular_eliminado';
                }
                if (grid.getCellValue(row,col) == "En Curso") {
                    return 'angular_nota_credito';
                }
            }
        },
        
        {name:'user_id', displayName: 'Usuario'}
    ];


    $scope.codigoEstado=function(id){
        gerenciaCompraTarjeta.viewGerenciajson(id).success(function(data){
//console.log(123,id);
        
        if(data.length > 0){
            $scope.loader = false
            $scope.tablaDetalle = true;
            $scope.gridOptions.data = data
        }

       $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
          // console.log(row.entity.compras_tarjetas_estado_id)
            if(row.isSelected == true){
                    if(row.entity.id){
                        $scope.id = row.entity.id;
                        
                        $scope.eliminarBtn = true;

                        if (row.entity.compras_tarjetas_estado_id == "Aprobado Gerencia") {

                                $scope.boton = false; 

                            } else{

                                $scope.boton = true;
                            }   
                             
                        if (row.entity.compras_tarjetas_estado_id == "Rechazado Gerencia") {

                                $scope.btncompras_tarjetasdelete=true;

                            } else{
                                
                                $scope.btncompras_tarjetasdelete=false;
                        }

                    }
            }else{
                $scope.boton = false;
                row.entity.id.length = 0;
                $scope.id = '';
                $scope.eliminarBtn = false;
            } 
        })

        $scope.confirmacion = function(){
			if(angular.isDefined($scope.id)){
				window.location.href = host+"compras_tarjetas/delete/"+$scope.id+"/3"
			}
		};

       /* $scope.delete = function(id){
            // console.log(id);
             compraTarjeta.deleteCompratarjeta(id).success(function(data){
                 compraTarjeta.viewsolicitantejson(1).success(function(data){
                     $scope.gridOptions.data = data
                     $scope.showModal = false;
                 })
             });     
        }*/

        $scope.uploadDocumentos = function () {
            if ($scope.foto.archivo.length != 0) {
                trabajadoresService.uploadDocumentosCompras($scope.formulario.Trabajadore.id, $scope.foto.archivo).success(function (data) {
                    if (data.estado == 1) {
                        $scope.foto.archivo = undefined;
                        $scope.foto.archivo = [];
                        $scope.formulario.Trabajadore.foto = data.data + "?" + (new Date().getTime());
                        Flash.create("success", data.mensaje, 'customAlert');
                    } else {
                        $scope.foto.archivo = undefined;
                        $scope.foto.archivo = [];
                        Flash.create("danger", data.mensaje, 'customAlert');
                    }
                });
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
    }
    $scope.openModal = function(){
        $scope.showModal = true;
    }

    $scope.closeModal = function(){
        $scope.showModal = false;
    }



    
}]);
