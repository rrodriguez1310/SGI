app.controller('EmpresasCtrl', ['$scope', '$location' , '$http','listaContratosEmpresas', 'Flash', 'uiGridConstants', '$filter',  function ($scope, $location, $http, listaContratosEmpresas, Flash, uiGridConstants, $filter) {
    var absUrl = $location.absUrl();
    var trozo = absUrl.split("/");
    
    console.log(trozo);
    $scope.tipoForm = "Registrar";
    $scope.loader = true
    $scope.cargador = loader;
    $scope.gridOptions = {
        enableRowSelection: trozo[4] == 'contratos_add' ? true : false, // true,
        enableRowHeaderSelection: trozo[4] == 'contratos_add' ? true : false, // true,
        multiSelect: false,
        enableFiltering: false,
        useExternalFiltering: true,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
            { name:'Id', displayName: 'Id', visible:false},
            { name:'IdTipoContrato', displayName: 'Id tipo contrato', visible:false},
            { name:'FechaDocumento', displayName: 'Fecha Doc.', width:"110"},
            { name:'FechaInicio', displayName: 'Fecha Ini.', width:"110"},
            { name:'FechaVencimiento', displayName:'Fecha Venc.', width:"110", sort: {direction: uiGridConstants.ASC, priority: 2}},
            { name:'Observacion', displayName:'Observacion.'},
            { name:'Renovacion', displayName:'Renovación'},
            { name:'nombreTipoContrato', displayName: 'Tipo de Relación', width:"110"},
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
            { name:'Adjunto', displayName:'Adjunto', visible:false}, 
    ];

    listaContratosEmpresas.listaContratos().success(function(data){
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(row.isSelected == true)
            { 
                console.log(row.entity.Id); 
                       
                $scope.tipoForm = "Editar";
                if(row.entity.Estado != 0)
                {
                    $scope.noEdita = true
                    $scope.id = row.entity.Id;

                    
                               



                    if(row.entity.IdTipoContrato != null)
                    {
                        $scope.contratoTipo = {selected: row.entity.IdTipoContrato};
                    }
                    else
                    {
                        $scope.contratoTipo = "";   
                    }

                    $scope.fechaDocumento = row.entity.FechaDocumento;
                    $scope.fechaInicio = row.entity.FechaInicio;
                    $scope.fechaTermino = row.entity.FechaTermino;
                    $scope.fechaVencimiento = row.entity.FechaVencimiento;
                    $scope.gerencia = {selected: row.entity.GerenciaId};
                    $scope.avisoTerminoId = {selected: row.entity.CompaniesAvisoTerminoId};
                    if(row.entity.CompaniesAvisoTerminoId != null)
                    {
                        $scope.avisoTerminoId = {selected: row.entity.CompaniesAvisoTerminoId};
                    }
                    else
                    {
                        $scope.avisoTerminoId = "";   
                    }
                    $scope.notificacionEmail = row.entity.NotificacionEmail;
                    $scope.observacion = row.entity.Observacion;
                    $scope.estado = row.entity.Estado;
                    $scope.tipoContrato = row.entity.RenovacionId;
                    $scope.empresaId = row.entity.EmpresaId;
                    $scope.tipoContrato = row.entity.RenovacionId;
                    $scope.nombreAdjunto = true;
                    $scope.archivoAdjunto = row.entity.Adjunto;
                }
                else
                {
                    $scope.id = row.entity.Id;
                    $scope.noEdita = false 
                }
                $scope.empresaId = row.entity.EmpresaId;
                
                $scope.boton = true;
            }
            else
            {
                $scope.id = "";
                //$scope.empresaId = "";
                $scope.boton = false;
                $scope.noEdita = false
                $scope.tipoForm = "Registrar";
                $scope.fechaInicio = "";
                $scope.fechaTermino = "";
                $scope.fechaVencimiento = "";
                $scope.gerencia = "";
                $scope.avisoTermino = "";
                $scope.avisoTerminoId = "";
                $scope.notificacionEmail = "";
                $scope.observacion = "";
                $scope.renovacion = "";
                $scope.empresaId = "";
                $scope.gerencia = "";
                $scope.tipoContrato = "";
                $scope.fechaDocumento = "";
                $scope.estado = "";
                $scope.nombreAdjunto = false
                $scope.archivoAdjunto = "";
                $scope.contratoTipo = "";

            }

            $scope.editarContratoEmpresa = function(id)
            {
                $scope.tipoForm = "Editar";
                id = row.entity.Id
                listaContratosEmpresas.Contrato(id).success(function(dataContratos){
                    angular.forEach(dataContratos, function(item, key) {
                        $scope.id
                        $scope.fechaInicio = item.FechaInicio;
                        $scope.fechaTermino = item.FechaTermino;
                        $scope.fechaVencimiento = item.FechaVencimiento;
                        $scope.gerencia = item.Gerencia;
                        $scope.avisoTermino = item.CompaniesAvisoTermino;
                        $scope.avisoTerminoId = {selected: item.CompaniesAvisoTerminoId};
                        $scope.notificacionEmail = item.NotificacionEmail;
                        $scope.observacion = item.Observacion;
                        $scope.renovacion = item.Renovacion;
                        $scope.empresaId = item.EmpresaId;
                        $scope.gerencia = {selected: item.GerenciaId};
                        $scope.tipoContrato = item.RenovacionId;
                        $scope.fechaDocumento = item.FechaDocumento;
                        $scope.estado = item.Estado;
                        $scope.nombreAdjunto = true;
                        $scope.archivoAdjunto =item.Adjunto;
                        $scope.contratoTipo = {selected: item.IdTipoContrato};
                    });
                    
                })
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

        $scope.confirmacion = function (){
            window.location.href = host+"companies/delete_contratos/"+$scope.id+'/'+$scope.empresaId
        }


        $scope.modalView = function (id){
            $scope.showModal = true;
            id = $scope.id
            listaContratosEmpresas.Contrato(id).success(function(dataContratos){
                angular.forEach(dataContratos, function(item, key) {
                    $scope.titulo = "Detalle del Contrato";
                    $scope.fechaInicioModal = item.FechaInicio;
                    $scope.fechaTerminoModal = item.FechaTermino;
                    $scope.fechaVencimientoModal = item.FechaVencimiento;
                    $scope.gerenciaModal = item.Gerencia;
                    $scope.avisoTerminoModal = item.CompaniesAvisoTermino;
                    $scope.notificacionEmailModal = item.NotificacionEmail;
                    $scope.observacionModal = item.Observacion;
                    $scope.renovacionModal = item.Renovacion;
                    $scope.empresaModal = item.Empresa;
                    $scope.adjuntoModal = item.Adjunto;
                    $scope.fechaDocumentoModal = item.FechaDocumento;
                });
                
            })
        };

        $scope.cerrarModal = function (){
            $scope.showModal = false;
        };
    });

    $scope.limpiarForm = function (){
        $scope.tipoForm = "Registrar";
        $scope.id = "";
        $scope.fechaInicio = "";
        $scope.fechaTermino = "";
        $scope.fechaVencimiento = "";
        $scope.gerencia = "";
        $scope.avisoTermino = "";
        $scope.avisoTerminoId = "";
        $scope.notificacionEmail = "";
        $scope.observacion = "";
        $scope.renovacion = "";
        $scope.empresaId = "";
        $scope.gerencia = "";
        $scope.tipoContrato = "";
        $scope.fechaDocumento = "";
        $scope.estado = "";
        $scope.contratoTipo = "";
      
    }

    $scope.verificaFecha = function() {
        if($scope.fechaDocumento !== "")
        {
            fecha = $scope.fechaDocumento;
            listaContratosEmpresas.verificaFecha($scope.fechaDocumento).success(function(mensaje){
                if(mensaje.Error === 0)
                {
                    Flash.create('danger', mensaje.Mensaje, 'customAlert');
                }
            });
        }
    };

    $scope.bajaContrato = function (){
           window.location.href = host+"companies/baja_contrato_manual/"+$scope.id
    }
}]);
