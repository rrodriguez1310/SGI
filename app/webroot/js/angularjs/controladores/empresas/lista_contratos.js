app.controller('EmpresasCtrl', ['$scope', '$http','listaContratosEmpresas', 'uiGridConstants', '$filter',  function ($scope, $http, listaContratosEmpresas,  uiGridConstants, $filter) {
    var idSeleccionado;
    $scope.loader = true
    $scope.cargador = loader;
    $scope.gridOptions = {
        columnDefs : [
            { name:'Id', displayName: 'Id', visible:false},
            { name:'Gerencia', displayName: 'Gerencia', visible:false},
            { name:'EmpresaRut', displayName: 'Rut', width:"100"},
            { name:'EmpresaRazonSocial', displayName: 'Razón Social'},
            { name:'FechaDocumento', displayName: 'Fecha Doc.', width:"110"},
            { name:'FechaInicio', displayName: 'Fecha Ini.', width:"110"},
            { name:'FechaVencimiento', displayName:'Fecha Venc.', width:"110", sort: {direction: uiGridConstants.ASC, priority: 2}},
            { name:'Observacion', displayName:'Observación.'},
            { name:'Renovacion', displayName:'Renovación'},
            { name:'nombreTipoContrato', displayName:'Tipo de Relación'},
            { name:'NotificacionEmail', displayName:'Notificacion Email', visible : false},
            { name:'Adjunto', displayName:'Adjunto', visible : false},
            { name:'Estado', displayName: 'Estado', width:"120", sort: {direction: uiGridConstants.DESC, priority: 1}, cellClass:'text-center', cellTemplate : '<span>{{(row.entity.Estado) == 1 ? "Activo" : "Terminado"}}</span>',  
                cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                    if (grid.getCellValue(row,col) != 1)
                    {
                        return 'angular_rojo';
                    }
                    else
                    {
                         return 'angular_aprobado_g';
                    }
                }},        
        ],
            enableGridMenu: true,
            enableSelectAll: true,
            exporterCsvFilename: 'Contratos.csv',
            exporterPdfDefaultStyle: {fontSize: 9},
            exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
            exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
            exporterPdfHeader: { text: "Encabezado", style: 'headerStyle' },
            exporterPdfFooter: function ( currentPage, pageCount ) {
              return { text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle' };
            },
            exporterPdfCustomFormatter: function ( docDefinition ) {
              docDefinition.styles.headerStyle = { fontSize: 22, bold: true };
              docDefinition.styles.footerStyle = { fontSize: 10, bold: true };
              return docDefinition;
            },
            exporterPdfOrientation: 'portrait',
            exporterPdfPageSize: 'LETTER',
            exporterPdfMaxGridWidth: 500,
            exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
            enableRowSelection: true,
            enableRowHeaderSelection: true,
            multiSelect: false,
            enableFiltering: false,
            showGridFooter: true,
            useExternalFiltering: true,
            onRegisterApi: function(gridApi){
                $scope.gridApi = gridApi;
            }
    }
    
    $scope.log = function () {
        listaContratosEmpresas.logContratos(idSeleccionado).then(function (res){
            
        }).catch(function (err){
    
        })
    }

    listaContratosEmpresas.listaTodosLosContratos().success(function(data){
        
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(row.isSelected == true)
            {   
                $scope.boton = true;
                if(row.entity.adjunto_ruta != '') {
                    idSeleccionado = row.entity.Id; 
                    $scope.btncompaniesboton_muestra_contrato = false;
                    $scope.pathAdjunto = host+'files/contrato_empresas/'+row.entity.adjunto_ruta;
                }else {
                    idSeleccionado = undefined; 
                    $scope.btncompaniesboton_muestra_contrato = true;
                }
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
