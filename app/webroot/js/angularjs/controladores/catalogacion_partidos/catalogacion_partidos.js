app.controller('catalogacionPartidosIndex', function ($scope, catalogacionPartidosService, $filter, uiGridConstants) {
    $scope.tablaDetalle = false;
    $scope.loader = true
    $scope.cargador = loader;

    $scope.gridOptions = {
        enableFiltering: true,
        useExternalFiltering: false,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false, 
        enableSorting: true,
        enableColumnResizing: true,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        //{name:'id', displayName: 'id', width: '5%'},
        {name:'codigo', displayName: 'Codigo', width: '20%', filter: {condition: uiGridConstants.filter.CONTAINS}},
        {name:'fecha_partido', displayName: 'Fecha Partido', cellFilter: 'date:"yyyy-MM-dd":"UTC"', filter: {condition: uiGridConstants.filter.CONTAINS}},
        {name:'equipo_local', displayName: 'E. local'},
        {name:'equipo_visita', displayName: 'E. Visita'},
        {name:'campeonato', displayName: 'Campeonato'},
        {name:'fecha_torneo', displayName: 'Fecha torneo'},
        {name:'user', displayName: 'Id usuario'},
        {name:'observacion', displayName: 'Observacion'},
    ];

    catalogacionPartidosService.catalogacionPartidos().success(function (data){
        $scope.gridOptions.data = $filter("orderBy")(data, "fecha_partido", true);
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(angular.isNumber(row.entity.id))
            {
                $scope.id = row.entity.id;
            }
            if(row.isSelected == true)
            {   
                $scope.boton = true;
                //$scope.btncatalogacion_partidosview = false;
                
            }
            else
            {
                $scope.boton = false;
                $scope.id = undefined;
                //$scope.btncatalogacion_partidosview = true;
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

    })
});

app.controller('catalogacionPartidosAdd', function ($scope, $q, $filter, $window, equiposService, campeonatosService,catalogacionPartidosService, Flash){

    $scope.loader = true;
    $scope.cargador = loader;
    angular.element("#fecha_partido").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart:1,
    });
    angular.element(".select2").select2();
    $scope.formulario = {};
    $scope.formulario.CatalogacionPartido = {};
    promesas = [];
    promesas.push(equiposService.equiposList());
    promesas.push(campeonatosService.campeonatosList());
    $q.all(promesas).then(function (data){
        $scope.loader = false;
        $scope.detalle = true;
        $scope.equiposList = data[0].data;
        $scope.campeonatosList = data[1].data;
        equipos = {};
        campeonatos = {};
        angular.forEach(data[0].data, function(equipo){
            equipos[equipo.id] = equipo;
        });
        angular.forEach(data[1].data, function(campeonato){
            campeonatos[campeonato.id] = campeonato;
        });
        $scope.$watchGroup(["formulario.CatalogacionPartido.equipo_local", "formulario.CatalogacionPartido.equipo_visita", "formulario.CatalogacionPartido.campeonato_id", "formulario.CatalogacionPartido.fecha_torneo", "fecha_partido"], function(valores){
            if(angular.isDefined(valores[0]) && angular.isDefined(valores[1]) && angular.isDefined(valores[2]) && angular.isDefined(valores[3]) && angular.isDefined(valores[4]))
            {
                fechaPartidoArray =  valores[4].split("/");
                fechaPartido = String(fechaPartidoArray[2])+String(fechaPartidoArray[1])+String(fechaPartidoArray[0]);
                $scope.formulario.CatalogacionPartido.codigo = equipos[valores[0]].codigo+equipos[valores[1]].codigo+fechaPartido+campeonatos[valores[2]].codigo+valores[3];
            }else{
                $scope.formulario.CatalogacionPartido.codigo = undefined;
            }
            
        });
    });
    
    $scope.registrarCatalogacionPartido = function (){
        $scope.registrando = true;
        fecha_partido = $scope.fecha_partido.split("/");
        $scope.formulario.CatalogacionPartido.fecha_partido = fecha_partido[2]+"-"+fecha_partido[1]+"-"+fecha_partido[0];
        catalogacionPartidosService.registrarCatalogacionPartido($scope.formulario).success(function (data){
            if(data.estado == 1)
            {
                $window.location = host+"catalogacion_partidos/view/"+data.id;
            }else
            {
                $scope.registrando = true;
                Flash.create('danger', data.mensaje, 'customAlert');
            }         
        });
    };
});

app.controller('catalogacionPartidosView', function ($scope, $q, catalogacionPartidosService, $filter, uiGridConstants, Flash, equiposService, equiposFactory){

    $scope.catalogacionPartidoId = function(catalogacionPartidoId){
        $scope.tablaDetalle = false;
        $scope.loader = true
        $scope.cargador = loader;

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
            onRegisterApi: function(gridApi){
                $scope.gridApi = gridApi;
            }
        };

        $scope.gridOptions.columnDefs = [
            //{name:'id', displayName: 'id', width: '5%'},
            {name:'codigo', displayName: 'Codigo', width: '20%'},
            {name:'numero', displayName: 'N°', width: '5%'},
            {name:'formato_id', displayName: 'Formato'},
            {name:'soporte_id', displayName: 'Soporte'},
            {name:'almacenamiento_id', displayName: 'Almacenamiento'},
            {name:'copia_id', displayName: 'Copia'},
            {name:'bloque_id', displayName: 'Bloque'},
            {name:'user', displayName: 'Usuario'},
            {name:'observacion', displayName: 'Observacion'},
        ];

        promesas = [];
        promesas.push(catalogacionPartidosService.catalogacionPartido(catalogacionPartidoId));
        promesas.push(equiposService.equiposList());
        $q.all(promesas).then(function (data){
            $scope.equipos = equiposFactory.equiposPorId(data[1].data);
            $scope.catalogacionPartido = data[0].data;
            $scope.gridOptions.data = data[0].data.CatalogacionPartidosMedio;
            $scope.loader = false;
            $scope.tablaDetalle = true;
            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                if(angular.isNumber(row.entity.id))
                {
                    $scope.id = row.entity.id;
                }
                if(row.isSelected == true)
                {   
                    $scope.boton = true;
                    //$scope.btncatalogacion_partidosview = false;
                    
                }
                else
                {
                    $scope.boton = false;
                    $scope.id = undefined;
                    //$scope.btncatalogacion_partidosview = true;
                }
            });

            $scope.refreshData = function (termObj){
                $scope.gridOptions.data = data[0].data.CatalogacionPartidosMedio;
                while (termObj){
                    var oSearchArray = termObj.split(' ');
                    $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                    oSearchArray.shift();
                    termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                }
            };
        })
    };
});

app.controller('catalogacionPartidosEdit', function ($scope, $q, $filter, $window, equiposService, campeonatosService,catalogacionPartidosService, Flash){

    $scope.loader = true;
    $scope.cargador = loader;
    angular.element("#fecha_partido").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart:1,
    });
    angular.element(".select2").select2();
    $scope.idCatalogacionPartido = function(idCatalogacionPartido){
        $scope.formulario = {};
        $scope.formulario.CatalogacionPartido = {};
        promesas = [];
        promesas.push(equiposService.equiposList());
        promesas.push(campeonatosService.campeonatosList());
        promesas.push(catalogacionPartidosService.catalogacionPartido(idCatalogacionPartido));
        $q.all(promesas).then(function (data){
            $scope.formulario = {};
            $scope.formulario.CatalogacionPartido = {};
            $scope.formulario.CatalogacionPartido = data[2].data.CatalogacionPartido;
            fechaPartido = $scope.formulario.CatalogacionPartido.fecha_partido.split("-");
            $scope.fecha_partido = fechaPartido[2]+"/"+fechaPartido[1]+"/"+fechaPartido[0];
            $scope.loader = false;
            $scope.detalle = true;
            $scope.equiposList = data[0].data;
            $scope.campeonatosList = data[1].data;
            equipos = {};
            campeonatos = {};
            angular.forEach(data[0].data, function(equipo){
                equipos[equipo.id] = equipo;
            });
            angular.forEach(data[1].data, function(campeonato){
                campeonatos[campeonato.id] = campeonato;
            });
            $scope.$watchGroup(["formulario.CatalogacionPartido.equipo_local", "formulario.CatalogacionPartido.equipo_visita", "formulario.CatalogacionPartido.campeonato_id", "formulario.CatalogacionPartido.fecha_torneo", "fecha_partido"], function(valores){
                if(angular.isDefined(valores[0]) && angular.isDefined(valores[1]) && angular.isDefined(valores[2]) && angular.isDefined(valores[3]) && angular.isDefined(valores[4]))
                {
                    fechaPartidoArray =  valores[4].split("/");
                    fechaPartido = String(fechaPartidoArray[2])+String(fechaPartidoArray[1])+String(fechaPartidoArray[0]);
                    $scope.formulario.CatalogacionPartido.codigo = equipos[valores[0]].codigo+equipos[valores[1]].codigo+fechaPartido+campeonatos[valores[2]].codigo+valores[3];
                }else{
                    $scope.formulario.CatalogacionPartido.codigo = undefined;
                }
                
            });
        });    
    }
    
    
    $scope.editarCatalogacionPartido = function (){
        $scope.editando = true;
        fecha_partido = $scope.fecha_partido.split("/");
        $scope.formulario.CatalogacionPartido.fecha_partido = fecha_partido[2]+"-"+fecha_partido[1]+"-"+fecha_partido[0];
        catalogacionPartidosService.registrarCatalogacionPartido($scope.formulario).success(function (data){
            if(data.estado == 1)
            {
                $window.location = host+"catalogacion_partidos/view/"+data.id;
            }else
            {
                $scope.editando = true;
                Flash.create('danger', data.mensaje, 'customAlert');
            }         
        });
    };
});