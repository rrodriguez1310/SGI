/* listados */ 
app.controller('objetivosIndex', ['$scope', '$rootScope', '$http', '$filter', '$location', 'uiGridConstants', 'objetivosService', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants, objetivosService) {
    $scope.inicio = false;
    $scope.loader = true;
    $scope.tablaDetalle = false;
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
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };
    $scope.getCellFilterDate = function(){
        return 'date:\'dd MMM\'';
    };
    $scope.gridOptions.columnDefs = [
        {name:'nombre_trabajador', displayName:'Nombre Colaborador'},      
        {name:'cargo', displayName:'Cargo'},
        {name:'estado', displayName:'Estado OCD'},
        {name:'fecha_inicio', displayName: 'Fecha Inicio', cellFilter: $scope.getCellFilterDate('{{row.getProperty(col.field)}}')}        
    ];
    objetivosService.listadoObjetivos().success(function(data) {
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridOptions.data = data.listadoTrabajadores;
        $scope.evaluador = data.datosEvaluador;
        $scope.anioAEvaluar = data.anioAEvaluar;         
        if(!$scope.inicio){
            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                if(angular.isNumber(row.entity.evaluacion_id))
                {                                        
                    if(row.entity.objetivo_estado_id==7){
                        $scope.btnevaluaciones_objetivosadd = true;                    
                        $scope.btnevaluaciones_objetivosview = false;
                        $scope.btnevaluaciones_objetivosedit = true;
                    }else{
                        $scope.btnevaluaciones_objetivosadd = true;                    
                        $scope.btnevaluaciones_objetivosview = true;
                        $scope.btnevaluaciones_objetivosedit = false;
                    }                               
                    $scope.id = row.entity.evaluacion_id+'/'+row.entity.etapa_objetivo;
                }else{
                    
                    $scope.btnevaluaciones_objetivosadd = false; 
                    $scope.btnevaluaciones_objetivosedit = true;
                    $scope.btnevaluaciones_objetivosview = true;
                    $scope.id = row.entity.id; // trabajadore_id
                }
                if(row.isSelected == true)           
                    $scope.boton = true;            
                else            
                    $scope.boton = false;     
            }); 
        }        
        $scope.refreshData = function (termObj) {
            $scope.gridOptions.data = data.listaTrabajadores;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });
}]);

app.controller('calibrarIndex', ['$scope', '$rootScope', '$http', '$filter', '$location', 'uiGridConstants', 'objetivosService', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants, objetivosService) {
    $scope.inicio = false;
    $scope.loader = true;
    $scope.tablaDetalle = false;
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
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };
    $scope.getCellFilterDate = function(){
        return 'date:\'dd MMM\'';
    };
    $scope.gridOptions.columnDefs = [
        {name:'nombre', displayName:'Nombre Colaborador'},
        {name:'cargo', displayName:'Cargo'},
        {name:'jefatura', displayName:'Jefatura'},
        {name:'estado', displayName:'Estado'},
        {name:'fecha_modificacion', displayName: 'Recepción', cellFilter: $scope.getCellFilterDate('{{row.getProperty(col.field)}}')}        
    ];
    objetivosService.listadoCalibrar().success(function(data) {
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridOptions.data = data.listadoTrabajadores;
        $scope.calibrador = data.datosCalibrador;
        $scope.anioAEvaluar = data.anioAEvaluar;       
        $scope.etapa = 2;
        if(!$scope.inicio){
            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                if(angular.isNumber(row.entity.evaluacion_id))
                {                                        
                    $scope.btnevaluaciones_objetivosedit = false;                   
                }else{
                    $scope.btnevaluaciones_objetivosedit = true;
                }
                $scope.id = row.entity.evaluacion_id+'/'+$scope.etapa;
                if(row.isSelected == true)           
                    $scope.boton = true;            
                else            
                    $scope.boton = false;     
            }); 
        }        
        $scope.refreshData = function (termObj) {
            $scope.gridOptions.data = data.listaTrabajadores;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });
}]);

app.controller('objetivosConsolidadoIndex', ['$scope', '$rootScope', '$http', '$filter', '$location', 'uiGridConstants', 'objetivosService', 'constantes', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants, objetivosService, constantes) {
    $scope.inicio = false;
    $scope.loader = true;
    $scope.tablaDetalle = false;
    $scope.cargador = loader;
    $scope.list = {anioEvaluacion : 0};

    $scope.gridOptions = {
        enableGridMenu: true,
        exporterCsvFilename : 'consolidado_ocd.csv',
        exporterCsvColumnSeparator: ";",
        exporterOlderExcelCompatibility: true, 
        exporterMenuPdf: false,
        exporterMenuColumn: false,
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: false,
        enableRowHeaderSelection: true,
        multiSelect: false,
        enableSorting: true,
        exporterFieldCallback: function( grid, row, col, input ) {
            if(col.name == 'rut'){
                return input.split(".").join("");
            } else
                return input;
        },
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };
    $scope.getCellFilterDate = function(){
        return 'date:\'dd MMM\'';
    };
    $scope.$watch('list.anioEvaluacion', function(data) {
        objetivosService.objetivosConsolidado($scope.list.anioEvaluacion).success(function(data) {
            $scope.gridOptions.columnDefs = [
                {name:'rut', displayName:'Rut', visible:false, sortingAlgorithm  : constantes.ordenaRut},
                {name:'gerencia', displayName:'Gerencia'},
                {name:'jefatura', displayName:'Jefatura'},
                {name:'nombre_trabajador', displayName:'Colaborador'},
                {name:'cargo', displayName:'Cargo'},
                {name:'familia_cargo', displayName:'Familia de Cargos'},
                {name:'nr', displayName:'NR', width:75},        
                {name:'fecha_comunicacion', displayName: 'Fecha Comunicación OCD', cellFilter: $scope.getCellFilterDate('{{row.getProperty(col.field)}}'), visible:false},
                {name:'estadoObjetivos', displayName:'Estado', width:155},
            ];
            if(angular.isDefined(data.cantidadObjetivos)){
                var grupo;
                var id;
                for (key = 0; key < data.cantidadObjetivos; key++) {
                    id = Number(key)+1;
                    grupo = [//{name:'nombre'+key, displayName:'Nombre OCD '+id, width:85}, 
                    {name:'descripcion'+key, displayName:'Descripción OCD '+id, visible:false}, 
                    {name:'indicador'+key, displayName:'Indicador OCD '+id, width:110, visible:false, cellTemplate: '<div style="text-align:right;"  class="ui-grid-cell-contents">{{row.entity.indicador}}</div>'}, 
                    {name:'fecha_limite'+key, displayName:'Fecha Límite OCD '+id, width:120, visible:false, cellFilter: $scope.getCellFilterDate('{{row.getProperty(col.field)}}')}, 
                    {name:'porcentaje'+key, displayName:'Ponderación OCD '+id, width:130, visible:false}];        
                    $scope.gridOptions.columnDefs = $scope.gridOptions.columnDefs.concat(grupo);
                }   
            }
            $scope.loader = false;
            $scope.tablaDetalle = true;
            $scope.gridOptions.data = data.listadoObjetivos;
            $scope.evaluacionesAnios = data.listadoAnios;
            $scope.calibrador = data.datosCalibrador;
            $scope.anioActual = data.anioActual;
            $scope.etapa = 3;        
            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                if(row.entity.objetivo_estado_id0==7){                    
                    $scope.btnevaluaciones_objetivosview = false;
                }else{                    
                    $scope.btnevaluaciones_objetivosview = true;
                }
                $scope.id = row.entity.evaluacion_id+'/'+$scope.etapa;            
                if(row.isSelected == true)           
                    $scope.boton = true;
                else            
                    $scope.boton = false;     
            });        
            $scope.refreshData = function (termObj) {
                $scope.gridOptions.data = data.listadoObjetivos;
                while (termObj) {
                    var oSearchArray = termObj.split(' ');
                    $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                    oSearchArray.shift();
                    termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                }
            };
        });
    });

}]);

app.controller('objetivosAdd', function ($scope, $http, objetivosService, Flash, $window, $location, $rootScope, $filter, $anchorScroll, $timeout) {

    console.log("entra");

    $scope.datosObjetivos = function(idTrabajador){
        $scope.loader = true;
        $scope.cargador = loader;
        $scope.objetivos = false;
        $scope.etapa = 1;
        var Evaluacion;
        $scope.formulario = {
            EvaluacionesTrabajadore : {}
        };
        $scope.objetivosIn = [];
        objetivosService.getObjetivos(idTrabajador).success(function (objetivosData){
            if(angular.isDefined(objetivosData.evaluacionNueva.id)){
                $window.location = host+'evaluaciones_objetivos/edit/'+objetivosData.evaluacionNueva.id+'/'+$scope.etapa;
            }
            else
            {   
                $scope.loader = false;
                $scope.objetivos = true;
                $scope.trabajador  = objetivosData.datosTrabajador;
                
                $scope.objetivos   = objetivosData.datosObjetivo;
                $scope.unidades    = objetivosData.datosUnidadMedida;
                $scope.etapasOCD   = objetivosData.datosEtapasOCD;
                $scope.formulario.EvaluacionesTrabajadore  = objetivosData.evaluacionNueva;            
                $scope.anioObjetivo = objetivosData.evaluacionNueva.anio;
                $scope.anioHasta    = Number($scope.anioObjetivo) + 1;
                if($scope.formulario.EvaluacionesTrabajadore.nodo_inicial==1){
                    $scope.nodoInicial  = true;
                }
                console.log($scope.formulario.EvaluacionesTrabajadore);
                var ponderados = [];
                angular.forEach($scope.objetivos, function(valor, key){
                    ponderados.push("formulario.EvaluacionesObjetivo["+key+"].porcentaje_ponderacion");
                });                
                $scope.limitPonderado = 100;
                var limitPonderacion = 80;
                $scope.$watchGroup(ponderados, function(data){
                    $scope.ponderadoValido = false;
                    $scope.totalPonderado = 0;                
                    angular.forEach(data, function(valor, key){
                        if(angular.isDefined(valor)){
                            if(valor <= limitPonderacion){
                                $scope.totalPonderado = Number($scope.totalPonderado) + Number(valor);    
                                if($scope.totalPonderado > $scope.limitPonderado){
                                    $scope.formulario.EvaluacionesObjetivo[key].porcentaje_ponderacion = 0;
                                }
                            }else{
                                $scope.formulario.EvaluacionesObjetivo[key].porcentaje_ponderacion = 0;                            
                            }              
                            if($scope.totalPonderado==$scope.limitPonderado){
                                $scope.ponderadoValido = true;
                            }
                        }
                    });
                });
                $timeout($scope.initFechas);                
            }
        });
    };
    $scope.initFechas = function(){
        var anioActual = new Date().getFullYear();
        angular.element("#fechaObjetivo-0, #fechaObjetivo-1, #fechaObjetivo-2").datepicker({
            format: "dd-mm-yyyy",
            startDate: "now",
            //endDate: "31-12-"+anioActual,
            language: "es",
            multidate: false,
            //daysOfWeekDisabled: "6,0",
            autoclose: true,
            required: true,
            weekStart:1,
            orientation: "top auto"
        });
    };
    $scope.registrarObjetivos = function(){
        $scope.deshabilita = true;
        $scope.formulario.EvaluacionesTrabajadore.etapa = $scope.etapa;
        $scope.formulario.EvaluacionesTrabajadore.pagina = 'add';
        $scope.formulario.EvaluacionesTrabajadore.paso = 'act';
        objetivosService.addObjetivos($scope.formulario).success(function (data){
            $scope.deshabilita = false;
            if(data.estado==1){
                var objetivosActivos= [];
                $scope.objetivosIn = [];
                if(angular.isDefined(data.data)){
                    angular.forEach(data.data.EvaluacionesObjetivo,function(valor,key){
                        if(valor.estado == 1) objetivosActivos.push(valor);
                        $scope.objetivosIn.push(valor);
                    });
                    $scope.formulario.EvaluacionesTrabajadore = data.data.EvaluacionesTrabajadore;
                    objetivosActivos.sort(function(a, b){return a.objetivos_comentario_id - b.objetivos_comentario_id;});
                    $scope.formulario.EvaluacionesObjetivo = objetivosActivos;
                }
                if(data.correo==1){
                    Flash.create('success', data.mensaje_correo, 'customAlert');
                }else{
                    Flash.create('success', data.mensaje, 'customAlert'); //$window.location = host+'evaluaciones_trabajadores';
                }
                $scope.idEvaluacion = data.id;
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
    $scope.enviarObjetivos = function(){
        var anioActual = new Date().getFullYear();
        $scope.objetivos    = false;
        $scope.loader       = true;
        var email           = false;
        $scope.formulario.EvaluacionesTrabajadore.etapa = $scope.etapa + 1;
        $scope.formulario.EvaluacionesTrabajadore.pagina = 'add';
        $scope.formulario.EvaluacionesTrabajadore.paso = 'sig';                
        angular.forEach( $scope.formulario.EvaluacionesObjetivo, function (valor, key){            
            $scope.formulario.EvaluacionesObjetivo[key].evaluaciones_objetivo_estado_id = Number(valor.evaluaciones_objetivo_estado_id) + 1;
            if($scope.formulario.EvaluacionesObjetivo[key].evaluaciones_objetivo_estado_id == 2) email = true;
        });
        if(email){
            $scope.Email = { 0:{} };
            $scope.Email[0].nombre_email        = $scope.trabajador.nombre_calibrador;
            $scope.Email[0].email               = $scope.trabajador.email_calibrador;
            $scope.Email[0].asunto              = "Calibración OCD "+ anioActual + " " + $scope.trabajador.nombre;
            $scope.Email[0].nombre_trabajador   = $scope.trabajador.nombre;
            $scope.Email[0].plantilla           = "objetivos_correo_calibrador";
            $scope.formulario.Email = $scope.Email;
        }        
        objetivosService.addObjetivos($scope.formulario).success(function (data){
            $scope.loader = false;
            if(data.estado==1){
                var objetivosActivos= [];
                $scope.objetivosIn = [];
                if(angular.isDefined(data.data)){
                    angular.forEach(data.data.EvaluacionesObjetivo,function(valor,key){
                        if(valor.estado == 1) objetivosActivos.push(valor);
                        $scope.objetivosIn.push(valor);
                    });
                    $scope.formulario.EvaluacionesTrabajadore = data.data.EvaluacionesTrabajadore;
                    objetivosActivos.sort(function(a, b){return a.objetivos_comentario_id - b.objetivos_comentario_id;});
                    $scope.formulario.EvaluacionesObjetivo = objetivosActivos;
                }
                $scope.msgExito         = "Has enviado correctamente los OCD a " + $scope.trabajador.nombre_calibrador + ".";            
                $scope.msgExitoDetalle  = "Recuerda que posterior a la Calibración deberás revisar si existen o no observaciones.";
                $scope.ocdFinalizado    = true;
                $scope.objetivos        = true;
                $scope.mensaje          = true;
                if(data.correo==1){
                    Flash.create('success', data.mensaje, 'customAlert');
                }else{
                    Flash.create('success', data.mensaje, 'customAlert'); //$window.location = host+'evaluaciones_trabajadores';
                }
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
    $scope.agendarReunion = function(){
        $anchorScroll('miga');
        $scope.objetivos = false;
        $scope.loader = true;        
        $scope.pasoAgendarCita = true;
        $scope.formulario.EvaluacionesTrabajadore.pagina = 'add';
        $scope.formulario.EvaluacionesTrabajadore.paso = 'sig';
        angular.forEach( $scope.formulario.EvaluacionesObjetivo, function (valor, key){                        
            $scope.formulario.EvaluacionesTrabajadore.etapa = 3;
            $scope.formulario.EvaluacionesObjetivo[key].evaluaciones_objetivo_estado_id = 4;        
        });
        objetivosService.addObjetivos($scope.formulario).success(function (data){
            if(data.estado==1){                
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host+'evaluaciones_objetivos/edit/'+data.id+'/'+$scope.formulario.EvaluacionesTrabajadore.etapa;                
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
});

app.controller('objetivosEdit', function ($scope, $http, objetivosService, Flash, $window, $location, $rootScope, $filter, $anchorScroll, $timeout, $anchorScroll) {

    $scope.datosObjetivos = function(idEvaluacion, etapa){
        $scope.objetivos    = false;
        $scope.loader       = true;
        $scope.cargador     = loader;
        $scope.objetivosIn  = [];
        $scope.etapa        = etapa;     
        objetivosService.getEvaluacion(idEvaluacion,etapa).success(function (objetivosData){
            
            $scope.loader       = false;            
            $scope.objetivos    = true;            
            $scope.trabajador   = objetivosData.datosTrabajador;
            $scope.anioObjetivo = objetivosData.datosTrabajador.anio;
            $scope.anioHasta    = Number($scope.anioObjetivo) + 1;
            $scope.objetivos    = objetivosData.dataObjetivos;
            $scope.unidades     = objetivosData.datosUnidadMedida;
            
            $scope.unidadesList = objetivosData.listUnidadMedida;
            $scope.simboloUnidad= [];
            $scope.formulario   = { EvaluacionesTrabajadore:{}, EvaluacionesObjetivo:{} };
            $scope.formulario.EvaluacionesTrabajadore.id = idEvaluacion;
            $scope.formulario.EvaluacionesTrabajadore.nodo_inicial = objetivosData.nodo_inicial;

            if($scope.formulario.EvaluacionesTrabajadore.nodo_inicial==1){
                $scope.nodoInicial  = true;
            }

            $scope.formulario.EvaluacionesObjetivo = objetivosData.dataObjetivos;            
            $scope.etapasOCD    = objetivosData.datosEtapasOCD;
            if($scope.formulario.EvaluacionesObjetivo[0].evaluaciones_objetivo_estado_id==1) {
                $scope.pasoCalibrar = false;                
                $scope.pasoDefinir = true;                
            }else
            if($scope.formulario.EvaluacionesObjetivo[0].evaluaciones_objetivo_estado_id==2) {
                $scope.pasoCalibrar = true;
                $scope.pasoDefinir = false;
            }else
            if($scope.formulario.EvaluacionesObjetivo[0].evaluaciones_objetivo_estado_id==3) {
                $scope.pasoAgendar = true;
                $scope.pasoDefinir = false;
                $scope.pasoCalibrar = false;                
            }else
            if($scope.formulario.EvaluacionesObjetivo[0].evaluaciones_objetivo_estado_id==4){
                $scope.pasoAgendar = false;
                $scope.pasoDefinir = false;
                $scope.pasoCalibrar = false;
                $scope.pasoAgendarCita = true;
                $scope.ocdFinalizado = true;                
            }else
            if($scope.formulario.EvaluacionesObjetivo[0].evaluaciones_objetivo_estado_id==5){
                $scope.pasoAgendar = false;
                $scope.pasoDefinir = false;
                $scope.pasoCalibrar = false;
                $scope.pasoAgendarCita = false;
                $scope.pasoDialogo = true;
                $scope.habilitarEditar = false;                
            }
            if($scope.formulario.EvaluacionesObjetivo[0].evaluaciones_objetivo_estado_id==7){
                $scope.pasoVer = true;                
            }
            var ponderados = [];
            angular.forEach($scope.objetivos, function(valor, key){
                if(valor.evaluaciones_etapa_id==etapa)
                    ponderados.push("formulario.EvaluacionesObjetivo["+key+"].porcentaje_ponderacion");
            });            
            $scope.limitPonderado = 100;
            var limitPonderacion = 80;
            $scope.$watchGroup(ponderados, function(data){
                $scope.ponderadoValido = false;
                $scope.totalPonderado = 0;
                angular.forEach(data, function(valor, key){
                    if(angular.isDefined(valor)){
                        if(valor <= limitPonderacion){
                            $scope.totalPonderado = Number($scope.totalPonderado) + Number(valor);    
                            if($scope.totalPonderado > $scope.limitPonderado){
                                $scope.formulario.EvaluacionesObjetivo[key].porcentaje_ponderacion = 0;
                            }
                        }else{
                            $scope.formulario.EvaluacionesObjetivo[key].porcentaje_ponderacion = 0;
                        }
                        if($scope.totalPonderado==$scope.limitPonderado){
                            $scope.ponderadoValido = true;
                        }
                    }
                });
            });
            var unidadAObservar = [];
            if( $scope.pasoCalibrar==true || ($scope.pasoDialogo&&!$scope.habilitarEditar) || $scope.pasoVer==true){
                var valoresAObservar = [];
                var valoresOriginales = [];                
                angular.forEach($scope.formulario.EvaluacionesObjetivo, function(valor,key){           
                    if(valor.evaluaciones_etapa_id==2){
                        valoresAObservar[key] = ['formulario.EvaluacionesObjetivo['+key+'].descripcion_objetivo','formulario.EvaluacionesObjetivo['+key+'].indicador','formulario.EvaluacionesObjetivo['+key+'].evaluaciones_unidad_objetivo_id',
                                            'formulario.EvaluacionesObjetivo['+key+'].fecha_limite_objetivo', 'formulario.EvaluacionesObjetivo['+key+'].porcentaje_ponderacion'];
                        valoresOriginales[key] = [$scope.formulario.EvaluacionesObjetivo[key].descripcion_objetivo,$scope.formulario.EvaluacionesObjetivo[key].indicador,
                                            $scope.formulario.EvaluacionesObjetivo[key].evaluaciones_unidad_objetivo_id, $scope.formulario.EvaluacionesObjetivo[key].fecha_limite_objetivo,
                                            $scope.formulario.EvaluacionesObjetivo[key].porcentaje_ponderacion];
                    }
                    unidadAObservar[key] = 'formulario.EvaluacionesObjetivo['+key+'].evaluaciones_unidad_objetivo_id';
                    $scope.simboloUnidad[key] = $scope.unidadesList[$scope.formulario.EvaluacionesObjetivo[key].evaluaciones_unidad_objetivo_id];
                });
            }            
            if($scope.pasoDialogo==true){
                var valoresAObservar = [];
                var valoresOriginales = [];
                angular.forEach($scope.formulario.EvaluacionesObjetivo, function(valor,key){           
                    if(valor.evaluaciones_etapa_id==3){
                        valoresAObservar[key] = ['formulario.EvaluacionesObjetivo['+key+'].descripcion_objetivo','formulario.EvaluacionesObjetivo['+key+'].indicador','formulario.EvaluacionesObjetivo['+key+'].evaluaciones_unidad_objetivo_id',
                                            'formulario.EvaluacionesObjetivo['+key+'].fecha_limite_objetivo', 'formulario.EvaluacionesObjetivo['+key+'].porcentaje_ponderacion'];
                        valoresOriginales[key] = [$scope.formulario.EvaluacionesObjetivo[key].descripcion_objetivo,$scope.formulario.EvaluacionesObjetivo[key].indicador,
                                            $scope.formulario.EvaluacionesObjetivo[key].evaluaciones_unidad_objetivo_id, $scope.formulario.EvaluacionesObjetivo[key].fecha_limite_objetivo,
                                            $scope.formulario.EvaluacionesObjetivo[key].porcentaje_ponderacion];
                    }
                });
            }
            angular.forEach(valoresAObservar, function(data, key){
                $scope.$watchGroup(data, function (nuevo){
                    if(nuevo.toString()===valoresOriginales[key].toString())
                        $scope.formulario.EvaluacionesObjetivo[key].observado_validador = 0;
                    else
                        $scope.formulario.EvaluacionesObjetivo[key].observado_validador = 1;
                });
            });
            $scope.$watchGroup(unidadAObservar, function (nuevo, antiguo){                    
                angular.forEach(nuevo , function(valor, key){
                    if(nuevo[key]!=antiguo[key]){
                        $scope.simboloUnidad[key] = $scope.unidadesList[valor];            
                    }
                });
            });                        
            $timeout($scope.initFechas);
        });
    };
    $scope.initFechas = function(){
        var anioActual = new Date().getFullYear();
        angular.element("#fechaObjetivo-0, #fechaObjetivo-1, #fechaObjetivo-2, #fechaObjetivo-3, #fechaObjetivo-4, #fechaObjetivo-5, #fechaObjetivo-6, #fechaObjetivo-7, #fechaObjetivo-8").datepicker({
            format: "dd-mm-yyyy",            
            //startDate: "+0d",
            //endDate: "31-12-"+anioActual,
            language: "es",
            multidate: false,
            //daysOfWeekDisabled: "6,0",
            autoclose: true,
            required: true,
            weekStart:1,
            orientation: "top auto"
        });
        angular.forEach($scope.formulario.EvaluacionesObjetivo, function(valor,key){                            
            angular.element("#fechaObjetivo-"+key).datepicker("setDate", valor.fecha_limite_objetivo);
        });        
        angular.element("#fechaComunicacion").datepicker({
            format: "dd-mm-yyyy",            
            startDate: "now",
            //endDate: "31-12-"+anioActual,
            language: "es",
            multidate: false,
            daysOfWeekDisabled: "6,0",
            autoclose: true,
            required: true,
            weekStart:1,
            orientation: "top auto"
        });
        angular.element('#horaComunicacion').clockpicker({
            placement:'bottom',
            align: 'top',
            autoclose:true
        });
    };
    $scope.registrarObjetivos = function(){
        $scope.formulario.EvaluacionesTrabajadore.etapa = $scope.etapa;
        $scope.formulario.EvaluacionesTrabajadore.pagina = 'edit';
        $scope.formulario.EvaluacionesTrabajadore.paso = 'act';
        console.log($scope.formulario);
        objetivosService.addObjetivos($scope.formulario).success(function (data){
            if(data.estado==1){
                var objetivosActivos= [];
                $scope.objetivosIn = [];
                if(angular.isDefined(data.data)){
                    if($scope.etapa == 1){
                        angular.forEach(data.data.EvaluacionesObjetivo,function(valor,key){
                            if(valor.estado == 1) objetivosActivos.push(valor);
                            $scope.objetivosIn.push(valor);
                        });
                        $scope.formulario.EvaluacionesTrabajadore = data.data.EvaluacionesTrabajadore;
                        objetivosActivos.sort(function(a, b){return a.objetivos_comentario_id - b.objetivos_comentario_id;});
                        $scope.formulario.EvaluacionesObjetivo = objetivosActivos;
                    }
                    else{
                        $scope.formulario.EvaluacionesObjetivo = data.data.EvaluacionesObjetivo;
                    }
                }
                if(data.correo==1){
                    Flash.create('success', data.mensaje_correo, 'customAlert');
                }else{
                    Flash.create('success', data.mensaje, 'customAlert'); //$window.location = host+'evaluaciones_trabajadores';
                }
                $scope.idEvaluacion = data.id;            
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
    $scope.enviarObjetivos = function(){
        var anioActual = new Date().getFullYear();
        $scope.objetivos    = false;
        $scope.loader       = true;
        var email           = false;
        $scope.formulario.EvaluacionesTrabajadore.etapa = $scope.etapa + 1;
        $scope.formulario.EvaluacionesTrabajadore.pagina = 'edit';
        $scope.formulario.EvaluacionesTrabajadore.paso = 'sig';
        angular.forEach( $scope.formulario.EvaluacionesObjetivo, function (valor, key){            
            $scope.formulario.EvaluacionesObjetivo[key].evaluaciones_objetivo_estado_id = Number(valor.evaluaciones_objetivo_estado_id) + 1;
            if($scope.formulario.EvaluacionesObjetivo[key].evaluaciones_objetivo_estado_id == 2) 
            {
                email = 'calibrador';
                $scope.msgExito         = "Has enviado correctamente los OCD a " + $scope.trabajador.nombre_calibrador + ".";            
                $scope.msgExitoDetalle  = "Recuerda que posterior a la Calibración deberás revisar si existen o no observaciones.";
            }
            if($scope.formulario.EvaluacionesObjetivo[key].evaluaciones_objetivo_estado_id == 3){
                email = 'jefatura';    
                $scope.msgExito         = "Has enviado correctamente tu calibración a " + $scope.trabajador.jefatura + ".";
                $scope.msgExitoDetalle  = "";
            }
        });
        if(email=='calibrador'){
            $scope.Email = { 0 : {} };    
            $scope.Email[0].nombre_email        = $scope.trabajador.nombre_calibrador;
            $scope.Email[0].email               = $scope.trabajador.email_calibrador;
            $scope.Email[0].asunto              = "Calibración OCD "+ anioActual + " " +$scope.trabajador.nombre;
            $scope.Email[0].nombre_trabajador   = $scope.trabajador.nombre;
            $scope.Email[0].plantilla           = "objetivos_correo_calibrador";
            $scope.formulario.Email             = $scope.Email;
        }else
            if(email=='jefatura'){
            $scope.Email = { 0 : {} };  
            $scope.Email[0].nombre_email        = $scope.trabajador.jefatura;
            $scope.Email[0].email               = $scope.trabajador.email_jefatura;
            $scope.Email[0].asunto              = "Calibración OCD "+ anioActual + " " +$scope.trabajador.nombre;
            $scope.Email[0].nombre_trabajador   = $scope.trabajador.nombre;
            $scope.Email[0].plantilla           = "objetivos_correo_jefatura";
            $scope.Email[0].nombre_calibrador   = $scope.trabajador.nombre_calibrador;
            $scope.formulario.Email             = $scope.Email;
        }        
        objetivosService.addObjetivos($scope.formulario).success(function (data){
            $scope.loader = false;            
            if(data.estado==1){
                if(data.correo==1){
                    Flash.create('success', data.mensaje, 'customAlert');
                    $scope.ocdFinalizado    = true;
                    $scope.objetivos        = true;
                    $scope.mensaje          = true;
                }else{
                    Flash.create('success', data.mensaje, 'customAlert'); //$window.location = host+'evaluaciones_trabajadores';
                }
                $scope.idEvaluacion = data.id;            
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
    $scope.agendarReunion = function(){
        $anchorScroll('miga');
        $scope.ocdFinalizado = true;
        $scope.pasoAgendarCita = true;
        $scope.formulario.EvaluacionesTrabajadore.pagina = 'edit';
        $scope.formulario.EvaluacionesTrabajadore.paso = 'act';
        $scope.formulario.EvaluacionesTrabajadore.etapa = $scope.etapa;
        angular.forEach( $scope.formulario.EvaluacionesObjetivo, function (valor, key){      
            $scope.formulario.EvaluacionesTrabajadore.etapa = 3;                  
            $scope.formulario.EvaluacionesObjetivo[key].evaluaciones_objetivo_estado_id = 4;            
        });
        objetivosService.addObjetivos($scope.formulario).success(function (data){
            $scope.loader = false;
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $scope.idEvaluacion = data.id;
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
    $scope.enviarCitaReunion = function(){
        var anioActual = new Date().getFullYear();
        $scope.objetivos = false;
        $scope.loader = true;
        $scope.email = false;
        $scope.formulario.EvaluacionesTrabajadore.etapa = $scope.etapa;
        angular.forEach( $scope.formulario.EvaluacionesObjetivo, function (valor, key){            
            $scope.formulario.EvaluacionesObjetivo[key].evaluaciones_objetivo_estado_id = 5;
            $scope.email = true;
        });
        if($scope.email){
            $scope.Email = { 0 : {} };  
            $scope.Email[0].nombre_email        = $scope.trabajador.nombre;
            $scope.Email[0].email               = $scope.trabajador.email;
            $scope.Email[0].asunto              = "Comunicación de OCD " + anioActual + " " + $scope.trabajador.nombre;
            $scope.Email[0].nombre_trabajador   = $scope.trabajador.nombre;
            $scope.Email[0].plantilla           = "objetivos_correo_cita";
            $scope.Email[0].fecha_comunicacion  = $scope.formulario.EvaluacionesTrabajadore.fecha_comunicacion;
            $scope.Email[0].hora_comunicacion   = $scope.formulario.EvaluacionesTrabajadore.hora_comunicacion;
            $scope.Email[0].lugar_comunicacion  = $scope.formulario.EvaluacionesTrabajadore.lugar_comunicacion;

            $scope.formulario.Email             = $scope.Email;            
        }
        objetivosService.addObjetivos($scope.formulario).success(function (data){
            $scope.loader = false;            
            if(data.estado==1){
                if(data.correo==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $scope.msgExito         = "Has enviado correctamente la cita a " + $scope.trabajador.nombre + ".";            
                $scope.msgExitoDetalle  = "";                
                $scope.ocdFinalizado    = true;
                $scope.objetivos        = true;
                $scope.mensaje          = true;
                }else{
                  Flash.create('success', data.mensaje, 'customAlert'); //$window.location = host+'evaluaciones_trabajadores';
                }
                $scope.idEvaluacion = data.id;
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
    $scope.imprimirPlantilla = function(idEvaluacion){
        var anioActual = new Date();
        var plantilla   = 'plantillaFinal';
        var nombrePDF   = 'objetivos_'+ $scope.formulario.EvaluacionesTrabajadore.id+'_'+anioActual.getFullYear()+anioActual.getMonth()+anioActual.getDate()+'.pdf';   
        var carpeta     = anioActual.getFullYear();         
        parametros = {
                "nombre": nombrePDF, 
                "controlador" : 'evaluaciones_objetivos',
                "carpeta" : carpeta,
                "html"  : angular.element("#"+plantilla).html()
            }
        var imprimirHtml = $http({
                method: 'POST',
                url: host+'servicios/pdf_basico2',
                data: $.param(parametros)
            });
        imprimirHtml.success(function(data, status, headers, config){  
            var link = $("<a>", { //$window.open(data);
                href: data,
                download: '',
                target: "_blank"
            }).appendTo("body");
            link[0].click();                        
        });
    };
    $scope.downloadURL = function(url) {
        var $idown; 
        if ($idown) {
            $idown.attr('src',url);
        } else {
            $idown = $('<iframe>', { id:'idown', src:url }).hide().appendTo('body');
        }
    };
    $scope.habilitarEdicion = function(){
        var confirmaNotificacion;
        if($scope.formulario.EvaluacionesTrabajadore.nodo_inicial!=1)
            confirmaNotificacion = confirm("Podrás modificar los OCD. Se notificará a "+$scope.trabajador.nombre_calibrador+" de los cambios. ¿deseas continuar?");

        if(confirmaNotificacion || $scope.formulario.EvaluacionesTrabajadore.nodo_inicial==1){
            $scope.habilitarEditar = true;
        }
    };
    $scope.enviarAColaborador = function(){
        var anioActual = new Date().getFullYear();
        $scope.objetivos = false;
        $scope.loader = true;
        $scope.email = false;
        $scope.Email = { 0:{}, 1:{} };
        $scope.formulario.EvaluacionesTrabajadore.etapa = $scope.etapa;
        $scope.formulario.EvaluacionesTrabajadore.pagina = 'modified';
        angular.forEach( $scope.formulario.EvaluacionesObjetivo, function (valor, key){            
            $scope.formulario.EvaluacionesObjetivo[key].evaluaciones_objetivo_estado_id = 6;
            $scope.email = true;
        });
        if($scope.email){            
            $scope.Email[0].nombre_email        = $scope.trabajador.nombre;
            $scope.Email[0].email               = $scope.trabajador.email;
            $scope.Email[0].asunto              = "Confirmación de OCD "+ anioActual + " " +$scope.trabajador.nombre;
            $scope.Email[0].nombre_trabajador   = $scope.trabajador.nombre;
            $scope.Email[0].plantilla           = "objetivos_correo_colaborador";
        }
        if($scope.habilitarEditar){
            $scope.Email[1].nombre_email        = $scope.trabajador.nombre_calibrador;
            $scope.Email[1].email               = $scope.trabajador.email_calibrador;
            $scope.Email[1].asunto              = "Modificación de OCD "+ anioActual + " " + $scope.trabajador.nombre;
            $scope.Email[1].nombre_trabajador   = $scope.trabajador.nombre;
            $scope.Email[1].nombre_jefatura     = $scope.trabajador.jefatura;
            $scope.Email[1].plantilla           = "objetivos_correo_modificacion";
        }else{
            delete $scope.Email[1];
        }
        $scope.formulario.Email = $scope.Email;
        objetivosService.addObjetivos($scope.formulario).success(function (data){
            $scope.loader = false;            
            if(data.estado==1){
                if(data.correo==1){
                    Flash.create('success', data.mensaje, 'customAlert');
                    $scope.msgExito         = "Has enviado correctamente los OCD a " + $scope.trabajador.nombre + ".";            
                    $scope.msgExitoDetalle  = "";
                    $scope.ocdFinalizado    = true;
                    $scope.objetivos        = true;
                    $scope.mensaje          = true;
                }else{
                    Flash.create('success', data.mensaje, 'customAlert'); //$window.location = host+'evaluaciones_trabajadores';
                }
                $scope.idEvaluacion = data.id;
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
});