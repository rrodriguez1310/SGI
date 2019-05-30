app.controller('controllerSolicitudesTotales', ['$scope', '$http', '$filter', 'solicitudesRendicion', function($scope, $http, $filter, solicitudesRendicion) {
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

    $scope.totalGastos=0;

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
        enableColumnResizing: true,gridMenuCustomItems: [
            {
              title: 'Rotate Grid',
              action: function ($event) {
                this.grid.element.toggleClass('rotated');
              },
              order: 210
            }
          ],
          onRegisterApi: function( gridApi ){
            vm.gridApi = gridApi;
       
            // interval of zero just to allow the directive to have initialized
            $interval( function() {
              gridApi.core.addToGridMenu( gridApi.grid, [{ title: 'Dynamic item', order: 100}]);
            }, 0, 1);
       
            gridApi.core.on.columnVisibilityChanged( $scope, function( changedColumn ){
              vm.columnChanged = { name: changedColumn.colDef.name, visible: changedColumn.colDef.visible };
            });
          },
        enableCellEdit: false,
        exporterMenuCsv: true,
        exporterMenuExcel: true,
        enableGridMenu: true, 
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        {name:'id', displayName: 'Id Rendicin'},
        {name:'fecha_documento', displayName: 'Fecha'},
        {name:'n_solicitud_folio', displayName: 'Id Solicitud'},
        {name:'monto', displayName: 'Monto Solicitado'},
        {name:'total', displayName: 'Total Rendido'},
        {name:'titulo', displayName: 'Titulo'},
        {name:'observacion', displayName: 'Observacion'},
        {name:'tipos_moneda_id', displayName: 'Moneda'},
        {name:'tipo_fondo', displayName: 'Fondos'},
        {name:'moneda_observada', displayName: 'Valor Moneda'},
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
        {name:'motivo', displayName: 'Motivo'}
        
        
    ];
    $scope.init = function(value) {
      
   
        solicitudesRendicion.listaRendicionFondoTotalesRendir().success(function(data){
            
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

 


}]);


