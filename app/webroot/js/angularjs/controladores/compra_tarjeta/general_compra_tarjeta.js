app.controller('controllerGeneralCompras', ['$scope', '$http', '$filter', 'generalCompraTarjeta', function($scope , $http, $filter,generalCompraTarjeta) {
    $scope.tablaDetalle = false;
    $scope.loader = false;
    $scope.cargador = loader;
    $scope.eliminarBtn = false;
   // $scope.menuVista=false;
    //$scope.form = [];

    //$scope.btncompras_tarjetasedit=true;
    //$scope.btncompras_tarjetasdelete=true;

  

    $scope.gridOptions = {
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false, 
        enableSorting: true,
        enableCellEdit: false,
        enableColumnResizing: true,
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
         
                if (grid.getCellValue(row,col) == "Aprobado Area") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row,col) == "Aprobado Finanza") {
                    return 'angular_aprobado_g';
                }
                if (grid.getCellValue(row,col) == "Comprado") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row,col) == "Aprobado Gerencia") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row,col) == "Rechazado Area") {
                    return 'angular_rojo';
                }

                if (grid.getCellValue(row,col) == "Rechazado Finanza") {
                    return 'angular_rojo';
                }

                if (grid.getCellValue(row,col) == "Rechazado Gerencia") {
                    return 'angular_rojo';
                }
            }
        },
        
        {name:'user_id', displayName: 'Usuario'},
        {name:'recurrencia', displayName: 'Recurrencia'},
        {name:'observacion', displayName: 'Observacion'}
    ];$scope.menuVista= true;

    generalCompraTarjeta.viewGeneralJson().success(function(data){
        
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
                        $scope.boton = true;
                        if (row.entity.compras_tarjetas_estado_id == "Aprobado Area" || 
                            row.entity.compras_tarjetas_estado_id == "Rechazado Area" ||
                            row.entity.compras_tarjetas_estado_id == "Aprobado Finanza" ||
                            row.entity.compras_tarjetas_estado_id == "Rechazado Finanza" ||
                            row.entity.compras_tarjetas_estado_id == "Aprobado Gerencia" ||
                            row.entity.compras_tarjetas_estado_id == "Rechazado Gerencia" || 
                            row.entity.compras_tarjetas_estado_id == "Comprado"||
                            row.entity.compras_tarjetas_estado_id == "En Curso"
                        ) {
                              $scope.btncompras_tarjetasdelete=true;
                            }else{
                                $scope.btncompras_tarjetasdelete=false;
                        }

                      //  btncompras_tarjetasdelete
                    }

                    if(row.entity.recurrencia=='SI' ){
                        $scope.btncompras_tarjetasrecurrencia=false;
                    }else{
                        $scope.btncompras_tarjetasrecurrencia=true;
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
				window.location.href = host+"compras_tarjetas/delete/"+$scope.id
			}
		};

         $scope.guardaRecurrencia = function(recurrencia){
            if(recurrencia.folio!=undefined && recurrencia.monto!=undefined){
                generalCompraTarjeta.insertRecurrencia(recurrencia.folio, recurrencia.monto, $scope.id).success(function(data){
                    $scope.showModalRecurrencia = false;
                    $("[for=folio]").text('');
                    $("[for=monto]").text('');

                    recurrencia.folio ='';
                    recurrencia.monto='';

                   // Flash.create("success", "Datos Ingresados", 'customAlert');
                    /* compraTarjeta.viewsolicitantejson().success(function(data){
                         $scope.gridOptions.data = data
                         $scope.showModal = false;
                     })*/
                 }); 
            }else{

                if(recurrencia.folio == undefined ){
                    $("[for=folio]").css('color', 'red');

                    $scope.error="Campo obligatorio";
           
                }else{
                    $("[for=folio]").text('');
                   
                }
                if(recurrencia.monto == undefined ){
                    
                    $("[for=monto]").css('color', 'red');
                    $scope.error="Campo obligatorio";
                   
                }else{
                   
                    $("[for=monto]").text('');
                }
            }  
        }

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

      
        $scope.showModal = function(ev){
            $scope.showModalRecurrencia = true;
         }
        $scope.closeModal = function(){   
            $scope.showModalRecurrencia  = false;
        }
    })   
}]);

