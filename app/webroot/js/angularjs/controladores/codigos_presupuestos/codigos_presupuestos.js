app.controller('codigosPresupuestosIndex', function ($scope, $filter, uiGridConstants, codigosPresupuestosService, Flash){
    $scope.cargador = loader;
    $scope.gridOptions = {
        enableGridMenu: true,
        exporterMenuPdf: false,
        gridMenuShowHideColumns:false,
        exporterCsvFilename: 'codigos_presupuestarios.csv',
        enableColumnResizing : true,
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        {name:'id', displayName:'id', visible: false, exporterSuppressExport:true },
        {name:'anio', displayName:'Año', width: '5%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.anio }}'>{{ row.entity.anio }}</div>"},
        {name:'nombre', width: '20%', displayName:'Nombre', sort: { direction: uiGridConstants.ASC, ignoreSort: true }, cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.nombre }}'>{{ row.entity.nombre }}</div>"},
        {name:'codigo', width: '20%', displayName:'Codigo', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.codigo }}'>{{ row.entity.codigo }}</div>"},
        {name:'presupuesto_total', displayName:'Total', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_total | number }}'>{{ row.entity.presupuesto_total | number }}</div>"},
        {name:'presupuesto_enero', displayName:'Enero', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_enero | number }}'>{{ row.entity.presupuesto_enero | number }}</div>"},
        {name:'presupuesto_febrero', displayName:'Febrero', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_febrero | number }}'>{{ row.entity.presupuesto_febrero | number }}</div>"},
        {name:'presupuesto_marzo', displayName:'Marzo', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_marzo | number }}'>{{ row.entity.presupuesto_marzo | number }}</div>"},
        {name:'presupuesto_abril', displayName:'Abril', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_abril | number }}'>{{ row.entity.presupuesto_abril | number }}</div>"},
        {name:'presupuesto_mayo', displayName:'Mayo', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_mayo | number }}'>{{ row.entity.presupuesto_mayo | number }}</div>"},
        {name:'presupuesto_junio', displayName:'Junio', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_junio | number }}'>{{ row.entity.presupuesto_junio | number }}</div>"},
        {name:'presupuesto_julio', displayName:'Julio', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_julio | number }}'>{{ row.entity.presupuesto_julio | number }}</div>"},
        {name:'presupuesto_agosto', displayName:'Agosto', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_agosto | number }}'>{{ row.entity.presupuesto_agosto | number }}</div>"},
        {name:'presupuesto_septiembre', displayName:'Septiempre', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_septiembre }}'>{{ row.entity.presupuesto_septiembre | number }}</div>"},
        {name:'presupuesto_octubre', displayName:'Octubre', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_octubre | number }}'>{{ row.entity.presupuesto_octubre | number }}</div>"},
        {name:'presupuesto_noviembre', displayName:'Noviembre', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_noviembre | number }}'>{{ row.entity.presupuesto_noviembre | number }}</div>"},
        {name:'presupuesto_diciembre', displayName:'Diciembre', width: '10%', cellTemplate: "<div class='ui-grid-cell-contents' data-toggle='tooltip' title='{{ row.entity.presupuesto_diciembre | number }}'>{{ row.entity.presupuesto_diciembre | number }}</div>"},

    ];
    cargaIndex = function (){
        $scope.loader = true
        $scope.tablaDetalle = false;
        codigosPresupuestosService.codigosPresupuestos().success(function (codigosPresupuestarios){
            $scope.loader = false;
            if(codigosPresupuestarios.estado == 1){
                $scope.tablaDetalle = true;
                $scope.gridOptions.data = codigosPresupuestarios.data;
                $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                    if(angular.isNumber(row.entity.id))
                    {
                        $scope.id = row.entity.id;
                    }
                    if(row.isSelected == true)
                    {
                        $scope.boton = true;
                    }
                    else
                    {
                        $scope.boton = false;
                        $scope.id = "";
                    }
                });

                $scope.refreshData = function (termObj) {
                $scope.gridOptions.data = codigosPresupuestarios.data;
                while (termObj) {
                    var oSearchArray = termObj.split(' ');
                    $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                    oSearchArray.shift();
                    termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                }
            };
            }else{
                Flash.create('danger', "Por alguna razón no se puedo obtener la información, por favor intentalo nuevamente", 'customAlert');
            }
        });    
    };
    cargaIndex();

    $scope.confirmacion = function(){
        codigoPresupuestos = {
            CodigosPresupuesto : {
                id : $scope.id,
                estado : 0
            }
        }
        codigosPresupuestosService.delete(codigoPresupuestos).success(function (data){
            if(data.estado == 1){
                console.log($scope.gridApi);
                $scope.gridApi.selection.clearSelectedRows();
                $scope.id = undefined;
                $scope.boton = false;
                Flash.create('success', data.mensaje, 'customAlert');
                cargaIndex();
            }else{
                Flash.create('danger', data.mensaje, 'customAlert');
            }
            
        });
    };
});

app.controller('codigosPresupuestosEdit', function ($scope, $q, $window, codigosPresupuestosService, yearsService, Flash){
    $scope.loader = true
    $scope.cargador = loader;
    $scope.idCodigoPresupuesto = function(idCodigoPresupuesto){
        promesas = [];
        promesas.push(codigosPresupuestosService.codigosPresupuesto(idCodigoPresupuesto));
        promesas.push(yearsService.yearsList());
        $q.all(promesas).then(function (data){
            if(data[0].data.estado == 1){
                $scope.formulario = data[0].data.data;
                $scope.yearsList = data[1].data.data
                $scope.loader = false;
                $scope.detalle = true;
            }else{
                Flash.create('danger', "Por alguna razón no se puedo obtener la información del codigo, por favor intentalo nuevamente", 'customAlert');
            }
        })
        
    };

    $scope.actualizarCodigoPresupuesto = function(){
        delete $scope.formulario.created;
        delete $scope.formulario.modified;
        delete $scope.formulario.Year;
        codigosPresupuestosService.codigosPresupuestoRegistrar($scope.formulario).success(function (data){
            if(data.estado == 1){
                $window.location = host+"codigos_presupuestos";
            }else{
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
});

app.controller('codigosPresupuestosAdd', function ($scope, $q, $window, codigosPresupuestosService, yearsService, Flash){
    $scope.formulario = {};
    $scope.loader = true
    $scope.cargador = loader;
    yearsService.yearsList().success(function (data){
        $scope.yearsList = data.data;
        $scope.loader = false;
        $scope.detalle = true;
    }); 

    $scope.ingresarCodigoPresupuesto = function(){
        codigosPresupuestosService.codigosPresupuestoRegistrar($scope.formulario).success(function (data){
            if(data.estado == 1){
                $window.location = host+"codigos_presupuestos";
            }else{
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
});

app.controller('codigosPresupuestosCargaMasiva', function ($scope, $window, codigosPresupuestosService, yearsService, Flash){
    $scope.formulario = {};
    $scope.loader = true
    $scope.cargador = loader;
    yearsService.yearsList().success(function (data){
        $scope.yearsList = data.data;
        $scope.loader = false;
        $scope.detalle = true;
    });
    $scope.subirArchivo = function(){
        $scope.procesando = true;
        $scope.detalleErrores = false;
        codigosPresupuestosService.cargaMasivaData($scope.formulario).success(function (data){
        $scope.procesando = false;
        switch(data.estado)
        {
            case 1 : 
                $window.location = host+"codigos_presupuestos";
            break;
            case 0 :
                Flash.create('danger', data.mensaje, 'customAlert');
            break;
            case 2 :
                $scope.formulario.CodigosPresupuesto.archivo = undefined;
                angular.element("[name='file']").val("");
                $scope.detalleErrores = true;
                $scope.errores = data.errores;
            break;
        }
       });
    }
});