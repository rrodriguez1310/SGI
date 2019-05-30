/* listados */ 
app.controller('evaluacionesIndex', ['$scope', '$rootScope', '$http', '$filter', '$location', 'uiGridConstants', 'i18nService', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants, i18nService) {
    $scope.inicio = false;
    $scope.loader = true;
    $scope.tablaDetalle = false;
    $scope.cargador = loader;
    $scope.lang = 'es';
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
        {name:'nombre', displayName:'Nombre Colaborador', width:170},        
        {name:'cargo', displayName:'Cargo'},
        {name:'estado_id', displayName:'Id Estado', visible: false},
        {name:'estado', displayName:'Estado'},
        {name:'fecha_inicio', displayName: 'Fecha Inicio', cellFilter: $scope.getCellFilterDate('{{row.getProperty(col.field)}}'), width:112},
        {name:'fecha_reunion', displayName:'Diálogo', cellFilter: $scope.getCellFilterDate('{{row.getProperty(col.field)}}'), width:112},
    ];

    $http.get(host+'evaluaciones_trabajadores/listado_evaluaciones/').success(function(data) {      
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridOptions.data = data.listaTrabajadores;
        $scope.evaluador = data.jefeEvaluador;
        $scope.calibrador = data.calibrador;
        $scope.anioEvaluado = data.anio_evaluado;
       
        if(!$scope.inicio){

            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            
                if(angular.isNumber(row.entity.evaluacion_id))
                {
                    if(row.entity.estado_id == 5 || row.entity.estado_id == 6 || row.entity.estado_id == 7){
                        $scope.btnevaluaciones_trabajadoresadd = true;
                        $scope.btnevaluaciones_trabajadoresedit = true;
                        $scope.btnevaluaciones_trabajadoresview = true;
                        $scope.btnevaluaciones_trabajadorescalibrar_edit = false;                    

                    }else if(row.entity.estado_id == 10 || row.entity.estado_id == 11 || row.entity.estado_id == 12){
                        $scope.btnevaluaciones_trabajadorescalibrar_edit = true;
                        $scope.btnevaluaciones_trabajadoresadd = true;
                        $scope.btnevaluaciones_trabajadoresedit = true;                    
                        $scope.btnevaluaciones_trabajadoresview = false;                    

                    }else{
                        $scope.btnevaluaciones_trabajadorescalibrar_edit = true;
                        $scope.btnevaluaciones_trabajadoresadd = true;
                        $scope.btnevaluaciones_trabajadoresview = true;
                        $scope.btnevaluaciones_trabajadoresedit = false;  
                    }
                    $scope.id = row.entity.evaluacion_id;

                }else{
                    
                    $scope.btnevaluaciones_trabajadorescalibrar_edit = true;
                    $scope.btnevaluaciones_trabajadoresedit = true;
                    $scope.btnevaluaciones_trabajadoresview = true;
                    $scope.btnevaluaciones_trabajadoresadd = false; 
                    $scope.id = row.entity.trabajador_id;
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

app.controller('calibradorIndex', ['$scope', '$rootScope', '$http', '$filter', '$location', 'uiGridConstants', 'i18nService', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants, i18nService) {
    $scope.loader = true;
    $scope.tablaDetalle = false;
    $scope.cargador = loader;
    $scope.lang = 'es';
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

    $scope.getCellFilterDate = function(row){
        return 'date:\'dd MMM\'';
    };
    $scope.gridOptions.columnDefs = [
        {name:'evaluacion_id', displayName:'id', visible: false },
        {name:'trabajador_id', displayName:'Id trabajador', visible: false },
        {name:'nombre', displayName:'Nombre colaborador', width: 170},
        {name:'cargo', displayName:'Cargo '},
        {name:'evaluador', displayName:'Jefatura'},
        {name:'estado_id', displayName:'Id Estado', visible: false },
        {name:'estado', displayName:'Estado', width: 95, cellTemplate : '<div class="ui-grid-cell-contents">{{(row.entity.estado_id) == 4 ? "Pendiente" : "Calibrada"}}</div>'},
        {name:'fecha_inicio', displayName:'Fecha Inicio', cellFilter: $scope.getCellFilterDate('{{row.getProperty(col.field)}}'), visible: false},
        {name:'familia_cargo', displayName:'Familia Cargo', visible: false},
        {name:'fecha_modificacion', displayName:'Recepción', cellFilter: $scope.getCellFilterDate('{{row.getProperty(col.field)}}'), width: 115},        
    ];

    $http.get(host+'evaluaciones_trabajadores/listado_calibrador/').success(function(data) {
        
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridOptions.data = data.listaTrabajadores;
        $scope.calibrador = data.calibrador;
        $scope.anioEvaluado = data.anio_evaluado;
       
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            console.log(row.entity.evaluacion_id);
            if(angular.isNumber(row.entity.evaluacion_id))
            {
                $scope.btnevaluaciones_trabajadorescalibrar_edit = false;
                $scope.id = row.entity.evaluacion_id;
            }else{
                $scope.btnevaluaciones_trabajadorescalibrar_edit = true;
            }

            if(row.isSelected == true)           
                $scope.boton = true;            
            else            
                $scope.boton = false;    

        }); 

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

app.controller('miDesempenoIndex', ['$scope', '$rootScope', '$http', '$filter', '$location', 'uiGridConstants', 'i18nService', 'evaluacionesService', 'Flash', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants, i18nService, evaluacionesService, Flash ) {
    $scope.loader = true;
    $scope.tablaDetalle = false;
    $scope.cargador = loader;
    $scope.lang = 'es';
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

    $scope.gridOptions.columnDefs = [
        {name:'id', displayName:'id', visible:false},
        {name:'anio_evaluado', displayName:'Año', width:100},
        {name:'estado_evaluacion', displayName:'Estado' , width:140, cellTemplate : '<div class="ui-grid-cell-contents">{{(row.entity.evaluaciones_estado_id) == 9 ? "Pendiente" : "Finalizada"}}</div>'},
        {name:'nivel_logro', displayName:'Situacion Desempeño' , width:200},
        {name:'nombre_jefatura', displayName:'Jefatura '},
        {name:'evaluaciones_estado_id', displayName:'Id Estado', visible: false },
    ];

    $http.get(host+'evaluaciones_trabajadores/listado_desempeno/').success(function(data) {

        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridOptions.data = data.listEvaluaciones; 
        $scope.trabajador = data.datosTrabajador;
        $scope.anioEvaluado = data.anio_evaluado;
        $scope.anioAEvaluar = data.anio_evaluar;
        $scope.objetivos = data.listadoObjetivos;
        $scope.btnVerActual = false;
        $scope.ocdValidado = false;
        $scope.tieneObjetivos = false;       

        console.log($scope.objetivos);

        if($scope.objetivos.length>1){
            $scope.tieneObjetivos = true;
            if($scope.objetivos[0].evaluaciones_objetivo_estado_id == 7)
                $scope.ocdValidado = true;
        }
        angular.forEach(data.listEvaluaciones, function(valor, key){
            if(valor.estado_actual==1){
                $scope.btnVerActual = true;
                $scope.evaluacionActual = valor.id;
            }
        });          
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            console.log(row.entity.evaluacion_id);
            if(row.entity.evaluaciones_estado_id == 9 )
            {
                $scope.btnevaluaciones_trabajadoresconfirmar = false;
                $scope.btnevaluaciones_trabajadoresview = true;

            }else{
                $scope.btnevaluaciones_trabajadoresview = false;
                $scope.btnevaluaciones_trabajadoresconfirmar = true;
            }
            $scope.id = row.entity.id;

            if(row.isSelected == true)
                $scope.boton = true;
            else
                $scope.boton = false;
        });

        $scope.refreshData = function (termObj) {
            $scope.gridOptions.data = data.listEvaluaciones;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });

    $scope.validarObjetivos = function(){
        var actualiza = {};
        $scope.formulario = { EvaluacionesTrabajadore: {}, EvaluacionesObjetivo : {} };        
        $scope.formulario.EvaluacionesTrabajadore.id = $scope.objetivos[0].evaluaciones_trabajadore_id;
        $scope.formulario.EvaluacionesTrabajadore.pagina ='modified';
        $scope.formulario.EvaluacionesTrabajadore.etapa = 3;
        
        angular.forEach($scope.objetivos, function(valor,key){
            actualiza.id        = valor.id;
            actualiza.validado  = 1;
            actualiza.evaluaciones_objetivo_estado_id = 7;
            $scope.formulario.EvaluacionesObjetivo[key] = angular.copy(actualiza);
        });                
        
        evaluacionesService.updateObjetivos($scope.formulario).success(function (data){
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $scope.ocdValidado = true;
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            } 
        });
    };
}]);
//Consolidado
app.controller('evaluacionesConsolidadoIndex', ['$scope', '$rootScope', '$http', '$filter', '$location', 'uiGridConstants', 'i18nService', 'evaluacionesService', 'constantes', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants, i18nService, evaluacionesService, constantes) {
    $scope.loader = true;
    $scope.tablaDetalle = false;
    $scope.cargador = loader;
    $scope.lang = 'es';
    $scope.list = {anioEvaluacion : 0};
    
    var largo = window.location.pathname.split('/').length;
    var pagina = window.location.pathname.split('/')[largo-1];

    $scope.gridOptions = {
        enableGridMenu: true,
        exporterCsvFilename : 'consolidado_final.csv',
        exporterCsvColumnSeparator: ";",
        exporterOlderExcelCompatibility: true, 
        exporterMenuPdf: false,
        exporterMenuColumn: false,
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        enableSorting: true,
        exporterFieldCallback: function( grid, row, col, input ) {
            if( col.name == 'antiguedad' || col.name == 'puntaje_ponderado_50' || col.name == 'puntaje_ocd' || col.name == 'puntaje_ponderado_75') {
                return $filter('number')(input, 3);
            } else if(col.name == 'rut_trabajador'){
                return input.split(".").join("");
            } else
                return input;
        },
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        },
    };

    $scope.getCellFilterDate = function(){
        return 'date:\'dd MMM\'';
    };
    
    $scope.gridOptions.columnDefs = [
        {name:'rut_trabajador', displayName:'Rut', width:110, sortingAlgorithm  : constantes.ordenaRut }, 
        {name:'nombre_trabajador', displayName:'Nombre Colaborador', width:180},   
        {name:'fecha_indefinido', displayName:'Ingreso CDF',visible:false},                     
        {name:'antiguedad', displayName:'Antiguedad al 31/12',visible:false, cellTemplate: '<div style="text-align:right;" class="ui-grid-cell-contents">{{row.entity.antiguedad|number:3}}</div>', type: 'number'},        
        {name:'cargo', displayName:'Cargo'},           
        {name:'gerencia', displayName:'Gerencia',visible:false},
        {name:'jefatura', displayName:'Jefatura'},
        {name:'familia_cargo', displayName:'Familia Cargos',visible:false},
        {name:'nivel_responsabilidad', displayName:'NR',visible:false, cellTemplate: '<div style="text-align:right;" class="ui-grid-cell-contents">{{row.entity.nivel_responsabilidad}}</div>', type: 'number'},
        {name:'puntaje_ocd', displayName:'Puntaje OCD',visible:false , cellTemplate: '<div style="text-align:right;" class="ui-grid-cell-contents">{{row.entity.puntaje_ocd|number:2}}</div>', type: 'number'},
        {name:'puntaje_competencias', displayName:'Puntaje competencias',visible:false , cellTemplate: '<div style="text-align:right;"  class="ui-grid-cell-contents">{{row.entity.puntaje_competencias}}</div>', type: 'number'},
        {name:'puntaje_ponderado_50', displayName:'Puntaje Ponderado', cellTemplate: '<div style="text-align:right;" class="ui-grid-cell-contents">{{row.entity.puntaje_ponderado_50|number:2}}</div>', type: 'number'},            
        {name:'situacion_desempeno', displayName:'Situación Desempeño', width:175},
        {name:'acepta_trabajador', displayName:'Aceptada', width:90, visible:false},
        {name:'estado', displayName:'Estado'},
        {name:'puntaje_ponderado_75', displayName:'Puntaje Ponderado 75/25',visible:false, cellTemplate: '<div style="text-align:right;"  class="ui-grid-cell-contents">{{row.entity.puntaje_ponderado_75|number:2}}</div>', type: 'number'},
        {name:'porcentaje_bono', displayName:'% Bono',visible:false, cellTemplate: '<div style="text-align:right;" class="ui-grid-cell-contents">{{row.entity.porcentaje_bono}}</div>', type: 'number'},
    ];

    $scope.$watch('list.anioEvaluacion', function(data) {               
        evaluacionesService.getEvaluacionesFinal($scope.list.anioEvaluacion).success(function(datos) { 

            $scope.loader = false;
            $scope.tablaDetalle = true;
            $scope.gridOptions.data = datos.listadoFinal;
            $scope.evaluacionesAnios = datos.listadoAnios;
            $scope.anioEvaluado = datos.anio_evaluado;

            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                if(angular.isNumber(row.entity.id) && (row.entity.estado_id>=10) )
                    $scope.btnevaluaciones_trabajadoresview = false;                    
                else
                    $scope.btnevaluaciones_trabajadoresview = true;
                
                if(row.isSelected == true)
                    $scope.boton = true;
                else
                    $scope.boton = false;
                $scope.id = row.entity.id;     
            }); 
            $scope.refreshData = function (termObj) {
                $scope.gridOptions.data = datos.listadoFinal;
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

/* acciones */ 
app.controller('evaluacionesAdd', function ($scope, $http, evaluacionesService, Flash, $filter, $window, $location, $rootScope, $anchorScroll) {

    $scope.datosNuevaEvaluacion = function(idTrabajador){
        $scope.loader = true;
        $scope.cargador = loader;

        evaluacionesService.datosNuevaEvaluacion(idTrabajador).success(function (nuevaEvaluacion){
            if(angular.isDefined(nuevaEvaluacion.EvaluacionesTrabajadore.id)){
                $window.location = host+'evaluaciones_trabajadores/edit/'+nuevaEvaluacion.EvaluacionesTrabajadore.id;
            }else{

                $scope.loader = false;
                $scope.evaluacion = true;
                $scope.pasoCompetencias =  true;
                $scope.evFinalizada = false;              

                $scope.evaluacionCompetencias = nuevaEvaluacion.criteriosEvaluacion.evaluacionCompetencias.nombre;
                $scope.evaluacionObjetivos = nuevaEvaluacion.criteriosEvaluacion.evaluacionObjetivos.nombre;
                $scope.evaluacionDialogo = nuevaEvaluacion.criteriosEvaluacion.evaluacionPonderada.nombre;
                $scope.tituloCompetencia = nuevaEvaluacion.competencias[0].titulo;      
                $scope.tituloCompetenciaGenerales = nuevaEvaluacion.competenciasGenerales[0].titulo;            
                //llenado tablas
                $scope.trabajador       = nuevaEvaluacion.datosTrabajador;
                $scope.nivelesLogroPaso1    = nuevaEvaluacion.criteriosEvaluacion.evaluacionCompetencias.criterios;
                $scope.nivelesLogroPaso2    = nuevaEvaluacion.criteriosEvaluacion.evaluacionObjetivos.criterios;
                $scope.nivelesLogroPaso3    = nuevaEvaluacion.criteriosEvaluacion.evaluacionPonderada.criterios;
                $scope.competencias     = nuevaEvaluacion.competencias;
                $scope.competenciasGenerales = nuevaEvaluacion.competenciasGenerales;
                $scope.objetivos = nuevaEvaluacion.objetivosClave;
                $scope.tiposEvaluaciones = nuevaEvaluacion.tiposEvaluaciones;
                $scope.dialogos = nuevaEvaluacion.dialogosDesempeno;

                //formulario
                $scope.formulario = {};
                $scope.formulario.EvaluacionesTrabajadore = nuevaEvaluacion.EvaluacionesTrabajadore;
                $scope.formulario.EvaluacionesCompetencia;
                $scope.formulario.EvaluacionesCompetenciasGenerale;
                $scope.formulario.EvaluacionesTrabajadore.puntaje_competencias = nuevaEvaluacion.EvaluacionesTrabajadore.puntaje_competencias;

                //paso 1    
                // competencias especificas
                var nivelLogrosPuntaje = {}; 
                angular.forEach($scope.nivelesLogroPaso1, function(nivelLogro){
                    nivelLogrosPuntaje[nivelLogro.id] = nivelLogro.rango_inicio;
                }); 
                competenciasAObservar = [];
                angular.forEach($scope.competencias, function(valor, key){
                    competenciasAObservar.push("formulario.EvaluacionesCompetencia["+key+"].niveles_logro_id");
                });
                $scope.$watchGroup(competenciasAObservar, function(datos){
                    $scope.puntajeCompetencias = 0;
                    angular.forEach(datos, function(valor, key){
                        if(angular.isNumber(valor)){
                            $scope.puntajeCompetencias = Number($scope.puntajeCompetencias) + Number(nivelLogrosPuntaje[valor]);
                            $scope.formulario.EvaluacionesCompetencia[key].puntaje = nivelLogrosPuntaje[valor];
                        }
                    });
                    $scope.formulario.EvaluacionesTrabajadore.puntaje_competencias = Number($scope.puntajeCompetencias) + Number($scope.puntajeCompetenciasGenerales);
                });
                // competencias transversales   
                competenciasGeneralesAObservar = []; 
                angular.forEach($scope.competenciasGenerales, function(valor, key){
                    competenciasGeneralesAObservar.push("formulario.EvaluacionesCompetenciasGenerale["+key+"].niveles_logro_id");
                });
                $scope.$watchGroup(competenciasGeneralesAObservar, function(datos){
                    $scope.puntajeCompetenciasGenerales = 0;
                    angular.forEach(datos, function(valor, key){
                        if(angular.isNumber(valor)){
                            $scope.puntajeCompetenciasGenerales = Number($scope.puntajeCompetenciasGenerales) + Number(nivelLogrosPuntaje[valor]);
                            $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje = nivelLogrosPuntaje[valor];
                        }
                    });
                    
                    if(angular.isNumber($scope.puntajeCompetencias))
                        $scope.formulario.EvaluacionesTrabajadore.puntaje_competencias = Number($scope.puntajeCompetencias) + Number($scope.puntajeCompetenciasGenerales);
                });


                //paso 2                
                var nivelLogrosObjetivos = {}; 
                angular.forEach($scope.nivelesLogroPaso2, function(logroObjetivo){
                   nivelLogrosObjetivos[logroObjetivo.id] = { inicio:logroObjetivo.rango_inicio , termino:logroObjetivo.rango_termino} ;
                });

                puntajesAObservar = []; 
                ponderacionAObservar = [];
                angular.forEach($scope.objetivos, function(valor, pos){
                    puntajesAObservar.push("formulario.EvaluacionesObjetivo["+pos+"].puntaje");                            
                    ponderacionAObservar.push("formulario.EvaluacionesObjetivo["+pos+"].porcentaje_ponderacion");    
                });

                $scope.$watchGroup(puntajesAObservar, function(data){
                    $scope.puntajeObjetivos = 0.00;
                    $scope.ingresadoPonderado = 0.00;

                    angular.forEach(data, function(ingresado, key){

                        if(angular.isDefined(ingresado)){  
                            $scope.formulario.EvaluacionesObjetivo[key].puntaje = parseInt(ingresado);  

                            var ingresoValido = false;
                            angular.forEach(nivelLogrosObjetivos, function(value, id){

                                if(angular.isDefined(id)){
                                    if( (ingresado >= value.inicio ) && (ingresado <= value.termino) ) {

                                        $scope.formulario.EvaluacionesObjetivo[key].niveles_logro_id = id;
                                        if(angular.isDefined($scope.formulario.EvaluacionesObjetivo[key].porcentaje_ponderacion)){
                                            var ponderacion = $scope.formulario.EvaluacionesObjetivo[key].porcentaje_ponderacion;
                                            $scope.ingresadoPonderado = (ingresado * ponderacion / 100);
                                            $scope.puntajeObjetivos = $scope.puntajeObjetivos +$scope.ingresadoPonderado;
                                        }
                                        
                                        ingresoValido = true;
                                    }
                                }
                            });
                            if(!ingresoValido){
                                delete $scope.formulario.EvaluacionesObjetivo[key]['niveles_logro_id'];
                                delete $scope.formulario.EvaluacionesObjetivo[key]['puntaje'];
                            }
                        }
                    });
                    $scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos = (Math.round(100*$scope.puntajeObjetivos)/100).toFixed(2); //Number($scope.puntajeObjetivos.toFixed(2));

                });

                $scope.datosAux = [undefined,undefined,undefined];
                $scope.$watchGroup(ponderacionAObservar, function(datosNuevos, datosAntiguos, scope){   
                    $scope.puntajeObjetivos = 0.00;
                    $scope.ponderacionObjetivos = 0.00;
                    $scope.maxPonderacionTotal = 100;
                    maxPoderacion = 50;
                    minPoderacion = 0;
                    var distinto;
                    for( i = 0; i < datosNuevos.length ; i++ ){
                        if(datosNuevos[i] != $scope.datosAux[i]){
                            distinto = i;
                        }
                        $scope.datosAux[i] = datosNuevos[i];
                    }

                    angular.forEach(datosNuevos, function(ponderacion, obj){

                        if( angular.isDefined(ponderacion) && ponderacion >= minPoderacion && ponderacion <= maxPoderacion){
                            $scope.formulario.EvaluacionesObjetivo[obj]['porcentaje_ponderacion'] = parseInt(ponderacion);

                            $scope.ponderacionObjetivos = $scope.ponderacionObjetivos + ponderacion;
                            if($scope.formulario.EvaluacionesObjetivo[obj]['puntaje']){
                                puntajePonderado = ( $scope.formulario.EvaluacionesObjetivo[obj]['puntaje'] * ponderacion / 100);
                                $scope.puntajeObjetivos = $scope.puntajeObjetivos + puntajePonderado;
                            }

                            if($scope.ponderacionObjetivos > $scope.maxPonderacionTotal && angular.isDefined(distinto)){            
                                delete $scope.formulario.EvaluacionesObjetivo[distinto]['porcentaje_ponderacion'];
                            }

                        }else{
                            if(angular.isDefined(ponderacion)){
                                delete scope.formulario.EvaluacionesObjetivo[obj]['porcentaje_ponderacion'];
                            }                        
                        }
                    });
                    $scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos = (Math.round(100*$scope.puntajeObjetivos)/100).toFixed(2);//Number($scope.puntajeObjetivos.toFixed(2));

                });

                //totales
                var totalesAObservar = ["formulario.EvaluacionesTrabajadore.puntaje_objetivos",
                "formulario.EvaluacionesTrabajadore.puntaje_competencias",
                "formulario.EvaluacionesTrabajadore.puntaje_ponderado"];

                $scope.$watchGroup(totalesAObservar, function(data){      
                    $scope.suma = Number($scope.formulario.EvaluacionesTrabajadore.puntaje_competencias) + Number($scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos);
                    $scope.suma = (Math.round(100*$scope.suma)/100).toFixed(2);
                    $scope.poderado =  Number($scope.suma / 2);
                    $scope.redondeado = (Math.round(100*$scope.poderado)/100).toFixed(2);
                    $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado = $scope.redondeado;
                    var ptjPonderado = $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado;

                    angular.forEach($scope.nivelesLogroPaso3, function(nivel, num){
                        if( (ptjPonderado >= nivel.rango_inicio ) && (ptjPonderado <= nivel.rango_termino) ) {
                            $scope.formulario.EvaluacionesTrabajadore.niveles_logro_id = nivel.id;
                            $scope.situacionDesemepeno = nivel.nombre;
                        }
                    });
                });
            }
        });
    };

    $scope.agregarEvaluacion = function(evaluacion){
        if(angular.isDefined($scope.idEvaluacion)){
            $scope.formulario.EvaluacionesTrabajadore.id = $scope.idEvaluacion;
        }
        $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = evaluacion;
        if(evaluacion == 2 ){
            //$scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado = Number( (($scope.formulario.EvaluacionesTrabajadore.puntaje_competencias + $scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos) / 2).toFixed(2) );
            $scope.suma = Number($scope.formulario.EvaluacionesTrabajadore.puntaje_competencias) + Number($scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos);
            $scope.suma = (Math.round(100*$scope.suma)/100).toFixed(2);
            $scope.poderado =  Number($scope.suma / 2);
            $scope.redondeado = (Math.round(100*$scope.poderado)/100).toFixed(2);
            $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado = $scope.redondeado;
            var ptjPonderado = $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado;
            angular.forEach($scope.nivelesLogroPaso3, function(nivel, num){
                if( (ptjPonderado >= nivel.rango_inicio ) && (ptjPonderado <= nivel.rango_termino) ) {

                    $scope.formulario.EvaluacionesTrabajadore.niveles_logro_id = nivel.id;
                    $scope.situacionDesemepeno = nivel.nombre;
                }
            });
        }
        $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion = (new Date()).toISOString().substring(0, 10);
        evaluacionesService.addEvaluacion($scope.formulario).success(function (data){
            
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');

                if(angular.isDefined(data.data)){
                    $scope.formulario = data.data;
                }
                $scope.idEvaluacion = data.id;
                
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            } 
        });
    };

    $scope.siguienteEvaluacion = function(evaluacion){
        $scope.gotoId('miga');
        if(angular.isDefined($scope.idEvaluacion)){
            $scope.formulario.EvaluacionesTrabajadore.id = $scope.idEvaluacion;
        }
        if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==3 && $scope.formulario.EvaluacionesTrabajadore.nodo_inicial==1){
            $scope.evaluacion = false;
            $scope.pasoDialogo = false;
            $scope.loader = true;
            $scope.gotoId('miga');
            angular.forEach($scope.formulario.EvaluacionesCompetencia, function(data,key) {
                $scope.formulario.EvaluacionesCompetencia[key].puntaje_calibrado = data.puntaje;
                $scope.formulario.EvaluacionesCompetencia[key].puntaje_modificado = data.puntaje;
            });
            angular.forEach($scope.formulario.EvaluacionesCompetenciasGenerale, function(data,key) {
                $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_calibrado = data.puntaje;
                $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_modificado = data.puntaje;
            });
            angular.forEach($scope.formulario.EvaluacionesObjetivo, function(data,key) {
                $scope.formulario.EvaluacionesObjetivo[key].puntaje_calibrado = data.puntaje;
                $scope.formulario.EvaluacionesObjetivo[key].puntaje_modificado = data.puntaje;
            });
            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = 7;
        }else{
            
            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id + 1;
        }

        if(evaluacion == 2 ){
            //$scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado = Number( (($scope.formulario.EvaluacionesTrabajadore.puntaje_competencias + $scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos) / 2).toFixed(2) );
            $scope.suma = Number($scope.formulario.EvaluacionesTrabajadore.puntaje_competencias) + Number($scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos);
            $scope.suma = (Math.round(100*$scope.suma)/100).toFixed(2);
            $scope.poderado =  Number($scope.suma / 2);
            $scope.redondeado = (Math.round(100*$scope.poderado)/100).toFixed(2);
            $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado = $scope.redondeado;

            var ptjPonderado = $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado;

            angular.forEach($scope.nivelesLogroPaso3, function(nivel, num){
                if( (ptjPonderado >= nivel.rango_inicio ) && (ptjPonderado <= nivel.rango_termino) ) {

                    $scope.formulario.EvaluacionesTrabajadore.niveles_logro_id = nivel.id;
                    $scope.situacionDesemepeno = nivel.nombre;
                }
            });
        }

        $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion = (new Date()).toISOString().substring(0, 10);
        evaluacionesService.addEvaluacion($scope.formulario).success(function (data){
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert'); 
                if(angular.isDefined(data.data)){
                    $scope.formulario = data.data;
                }
                $scope.idEvaluacion = data.id;

                if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id == 2){
                    $scope.pasoCompetencias =  false;
                    $scope.pasoObjetivos =  true;
                    $scope.pasoDialogo =  false;     

                } else if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id == 3){
                    $scope.pasoCompetencias =  false;
                    $scope.pasoObjetivos =  false;
                    $scope.pasoDialogo =  true;

                }else if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id == 7){
                    if($scope.formulario.EvaluacionesTrabajadore.nodo_inicial==1){
                        $window.location = host+'evaluaciones_trabajadores/calibrar_edit/'+$scope.formulario.EvaluacionesTrabajadore.id;  
                    }
                    $scope.pasoCalibrar = false; 
                    $scope.pasoAgendarReunion = true;                       
                }

            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });

    };

    $scope.enviarEvaluacion = function(){
       
        $scope.evaluacion = false;
        $scope.pasoDialogo = false;
        $scope.loader = true;
        if(angular.isDefined($scope.idEvaluacion)){
            $scope.formulario.EvaluacionesTrabajadore.id = $scope.idEvaluacion;
        }
        $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion        = (new Date()).toISOString().substring(0, 10);
        $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id    = $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id + 1;  
        $scope.formulario.EnvioCorreo = {};
        $scope.formulario.EnvioCorreo.asunto            = "Calibración de Desempeño " + $scope.trabajador.nombre;
        $scope.formulario.EnvioCorreo.enviar_a_nombre   = $scope.trabajador.nombre_calibrador;
        $scope.formulario.EnvioCorreo.enviar_a_email    = $scope.trabajador.email_calibrador;

        $scope.formulario.EnvioCorreo.trabajador_nombre = $scope.trabajador.nombre;
        $scope.formulario.EnvioCorreo.trabajador_cargo  = $scope.trabajador.cargo;
        $scope.formulario.EnvioCorreo.trabajador_email  = $scope.trabajador.email;
        $scope.formulario.EnvioCorreo.evaluador_nombre  = $scope.trabajador.jefatura;
        $scope.formulario.EnvioCorreo.evaluador_email   = $scope.trabajador.email_jefatura;
        $scope.formulario.EnvioCorreo.calibrador_nombre = $scope.trabajador.nombre_calibrador;
        $scope.formulario.EnvioCorreo.calibrador_email  = $scope.trabajador.email_calibrador;

        angular.forEach( $scope.formulario.EvaluacionesCompetencia , function(value,key){
            $scope.formulario.EvaluacionesCompetencia[key].puntaje_calibrado = $scope.formulario.EvaluacionesCompetencia[key].puntaje;
        });
        angular.forEach( $scope.formulario.EvaluacionesCompetenciasGenerale , function(value,key){
            $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_calibrado = $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje;
        });
        angular.forEach( $scope.formulario.EvaluacionesObjetivo , function(value,key){
            $scope.formulario.EvaluacionesObjetivo[key].puntaje_calibrado = $scope.formulario.EvaluacionesObjetivo[key].puntaje;
        });
        evaluacionesService.addEvaluacion($scope.formulario).success(function (data){

            $scope.loader = false;
            $scope.evaluacion = true;
            $scope.gotoId('miga');
            
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $scope.evFinalizada = true;
                $scope.mensaje = true;
                $scope.msgExito = "Has enviado correctamente la evaluación de desempeño a  " + $scope.trabajador.nombre_calibrador + ".";
                $scope.msgExitoDetalle = "Recuerda que posterior a la Calibración deberás revisar si existen o no observaciones.";

            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });        
    };

    $scope.gotoId = function(id){
        $anchorScroll(id);
    }
});

app.controller('evaluacionesEdit', function ($scope, $http, evaluacionesService, Flash, $window, $location, $rootScope, $filter, $anchorScroll) {
    
    angular.element("#fechaReunion").datepicker({
        format: "dd-mm-yyyy",
        //startDate: "+0d",
        //endDate: "24-03-2016",
        language: "es",
        multidate: false,
        //daysOfWeekDisabled: "6,0",
        autoclose: true,
        required: true,
        weekStart:1,
        orientation: "bottom auto",
    });

    angular.element('#horaReunion').clockpicker({
        placement:'bottom',
        align: 'top',
        autoclose:true
    });

    $scope.datosEvaluacion = function(idEvaluacion){

        $scope.loader = true;
        $scope.cargador = loader;
        $scope.habilitarEditar = false;

        evaluacionesService.getEvaluacion(idEvaluacion).success(function (evaluacionData){
            $scope.loader = false;
            $scope.evaluacion = true;

            if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 1){
                $scope.pasoCompetencias =  true;
                $scope.pasoObjetivos =  false;
                $scope.pasoDialogo =  false;

            }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 2){
                $scope.pasoCompetencias =  false;
                $scope.pasoObjetivos =  true;
                $scope.pasoDialogo =  false;

            }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 3){
                $scope.pasoCompetencias =  false;
                $scope.pasoObjetivos =  false;
                $scope.pasoDialogo =  true;

            // calibracion / agendar reunion
            }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 4 ){

                $scope.pasoCalibrar =  true;
                $scope.pasoAgendarReunion = false;
                
            }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 5 || evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 6){
                $scope.pasoRectificarCalibracion =  true;
                $scope.pasoAgendarReunion = false;

            }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 7){    
                $scope.pasoCalibrar =  false; 
                $scope.pasoAgendarReunion = true;

                if(evaluacionData.EvaluacionesTrabajadore.fecha_reunion!==null)
                    if(angular.isDefined(evaluacionData.EvaluacionesTrabajadore.fecha_reunion))
                        evaluacionData.EvaluacionesTrabajadore.fecha_reunion = evaluacionData.EvaluacionesTrabajadore.fecha_reunion.split("-").reverse().join("-");        

                if(evaluacionData.EvaluacionesTrabajadore.hora_reunion!==null)
                    if(angular.isDefined(evaluacionData.EvaluacionesTrabajadore.hora_reunion))
                        evaluacionData.EvaluacionesTrabajadore.hora_reunion = evaluacionData.EvaluacionesTrabajadore.hora_reunion.substring(5, 0);

                // fin calibracion / agendar reunion

            }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 8){                              
                $scope.pasoCompetencias =  false;
                $scope.pasoObjetivos =  false;
                $scope.pasoDialogo =  true;
                $scope.imprimirEvaluacion = true;

                if(evaluacionData.EvaluacionesTrabajadore.modificada == 1)
                    $scope.habilitarEditar = true;

            }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 9){                              
                $scope.pasoCompetencias =  false;
                $scope.pasoObjetivos =  false;
                $scope.pasoDialogo =  true;
                $scope.imprimirEvaluacion = true;

            }else if( evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 10){                              
                $scope.pasoCompetencias =  false;
                $scope.pasoObjetivos =  false;
                $scope.pasoDialogo =  true;
                $scope.impEvaluacionFinal = true;
                $scope.subirEvaluacion = true;

            }else {  
               
                $window.location = host+'evaluaciones_trabajadores';
            }

            $scope.evFinalizada = false;  
            
            $scope.evaluacionCompetencias   = evaluacionData.criteriosEvaluacion.evaluacionCompetencias.nombre;
            $scope.evaluacionObjetivos      = evaluacionData.criteriosEvaluacion.evaluacionObjetivos.nombre;
            $scope.evaluacionDialogo        = evaluacionData.criteriosEvaluacion.evaluacionPonderada.nombre;

            $scope.trabajador               = evaluacionData.datosTrabajador;
            $scope.nivelesLogroPaso1        = evaluacionData.criteriosEvaluacion.evaluacionCompetencias.criterios;
            $scope.nivelesLogroPaso2        = evaluacionData.criteriosEvaluacion.evaluacionObjetivos.criterios;
            $scope.nivelesLogroPaso3        = evaluacionData.criteriosEvaluacion.evaluacionPonderada.criterios;

            $scope.tiposEvaluaciones        = evaluacionData.tiposEvaluaciones;

            $scope.competencias             = evaluacionData.competencias;
            $scope.competenciasGenerales    = evaluacionData.competenciasGenerales;
            $scope.objetivos                = evaluacionData.objetivosClave;
            $scope.dialogos                 = evaluacionData.dialogosDesempeno;
            $scope.porcGrupoComp            = evaluacionData.puntajesGrupoComp;
            $scope.porcObjetivos            = evaluacionData.puntajesObjetivos;      
            
            $scope.tituloCompetencia            = evaluacionData.competencias[0].titulo;
            $scope.tituloCompetenciaGenerales   = evaluacionData.competenciasGenerales[0].titulo;

            $scope.formulario   = {}; 
            $scope.formulario.EvaluacionesTrabajadore           = evaluacionData.EvaluacionesTrabajadore;
            $scope.formulario.EvaluacionesCompetencia           = evaluacionData.EvaluacionesCompetencia;
            $scope.formulario.EvaluacionesCompetenciasGenerale  = evaluacionData.EvaluacionesCompetenciasGenerale;
            $scope.formulario.EvaluacionesDialogo               = evaluacionData.EvaluacionesDialogo;
            $scope.formulario.EvaluacionesObjetivo              = evaluacionData.EvaluacionesObjetivo;

            $scope.anioEvaluado = evaluacionData.anio_evaluado;
            $scope.diasPlazo = evaluacionData.dias_plazo;

            $scope.formulario.EvaluacionesTrabajadore.puntaje_competencias = evaluacionData.EvaluacionesTrabajadore.puntaje_competencias;            

            //paso 1    
            // competencias especificas
            var nivelLogrosPuntaje = {}; 
            angular.forEach($scope.nivelesLogroPaso1, function(nivelLogro){
                nivelLogrosPuntaje[nivelLogro.id] = nivelLogro.rango_inicio;
            }); 
            competenciasAObservar = [];
            angular.forEach($scope.competencias, function(valor, key){
                competenciasAObservar.push("formulario.EvaluacionesCompetencia["+key+"].niveles_logro_id");
            });

            $scope.$watchGroup(competenciasAObservar, function(datos){
                $scope.puntajeCompetencias = 0;
                angular.forEach(datos, function(valor, key){
                    if(angular.isNumber(valor)){
                        $scope.puntajeCompetencias = Number($scope.puntajeCompetencias) + Number(nivelLogrosPuntaje[valor]);

                        if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id < 4)
                            $scope.formulario.EvaluacionesCompetencia[key].puntaje = nivelLogrosPuntaje[valor];
                        else 
                            if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id >= 4 && evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id < 8){
                                $scope.formulario.EvaluacionesCompetencia[key].puntaje_calibrado = nivelLogrosPuntaje[valor];
                                $scope.formulario.EvaluacionesCompetencia[key].puntaje_modificado = nivelLogrosPuntaje[valor];

                            }else if (evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id >= 8){
                                $scope.formulario.EvaluacionesCompetencia[key].puntaje_modificado = nivelLogrosPuntaje[valor];
                            }  

                        if($scope.formulario.EvaluacionesCompetencia[key].puntaje_calibrado!=$scope.formulario.EvaluacionesCompetencia[key].puntaje_modificado)                      
                            $scope.formulario.EvaluacionesCompetencia[key].modificado_evaluador = 1;
                        else
                            $scope.formulario.EvaluacionesCompetencia[key].modificado_evaluador = 0;

                        if($scope.formulario.EvaluacionesCompetencia[key].puntaje!=$scope.formulario.EvaluacionesCompetencia[key].puntaje_calibrado)                      
                            $scope.formulario.EvaluacionesCompetencia[key].observado_validador = 1;
                        else
                            $scope.formulario.EvaluacionesCompetencia[key].observado_validador = 0;
                    }
                }); 
                $scope.formulario.EvaluacionesTrabajadore.puntaje_competencias = Number($scope.puntajeCompetencias) + Number($scope.puntajeCompetenciasGenerales);

            });

            // competencias transversales   
            competenciasGeneralesAObservar = [];
            angular.forEach($scope.competenciasGenerales, function(valor, key){
                competenciasGeneralesAObservar.push("formulario.EvaluacionesCompetenciasGenerale["+key+"].niveles_logro_id");
                //$scope.formulario.EvaluacionesCompetenciasGenerale[key].niveles_anterior = $scope.formulario.EvaluacionesCompetenciasGenerale[key].niveles_logro_id;
            });
            $scope.$watchGroup(competenciasGeneralesAObservar, function(datos){
                $scope.puntajeCompetenciasGenerales = 0;
                angular.forEach(datos, function(valor, key){
                    if(angular.isNumber(valor)){
                        $scope.puntajeCompetenciasGenerales = Number($scope.puntajeCompetenciasGenerales) + Number(nivelLogrosPuntaje[valor]);

                        if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id < 4){
                            $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje = nivelLogrosPuntaje[valor];

                        }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id >= 4 && evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id < 8){
                                $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_calibrado = nivelLogrosPuntaje[valor];
                                $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_modificado = nivelLogrosPuntaje[valor];

                            }else if (evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id >= 8){
                                $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_modificado = nivelLogrosPuntaje[valor];
                            }

                        if($scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_calibrado!=$scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_modificado)                      
                            $scope.formulario.EvaluacionesCompetenciasGenerale[key].modificado_evaluador = 1;
                        else
                            $scope.formulario.EvaluacionesCompetenciasGenerale[key].modificado_evaluador = 0;

                        if($scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje!=$scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_calibrado)                      
                            $scope.formulario.EvaluacionesCompetenciasGenerale[key].observado_validador = 1;
                        else
                            $scope.formulario.EvaluacionesCompetenciasGenerale[key].observado_validador = 0;

                    }
                });

                if(angular.isNumber($scope.puntajeCompetencias))
                    $scope.formulario.EvaluacionesTrabajadore.puntaje_competencias = Number($scope.puntajeCompetencias) + Number($scope.puntajeCompetenciasGenerales);
            });

            //paso 2                
            var nivelLogrosObjetivos = {}; 
            angular.forEach($scope.nivelesLogroPaso2, function(logroObjetivo){
               nivelLogrosObjetivos[logroObjetivo.id] = { inicio:logroObjetivo.rango_inicio, termino:logroObjetivo.rango_termino };
            });
            puntajesAObservar = [];
            ponderacionAObservar = [];
            angular.forEach($scope.objetivos, function(valor, pos){

                if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id < 4)
                    puntajesAObservar.push("formulario.EvaluacionesObjetivo["+pos+"].puntaje"); 
                else
                    if (evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id >= 4 && evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id < 8)
                        puntajesAObservar.push("formulario.EvaluacionesObjetivo["+pos+"].puntaje_calibrado");
                else 
                    if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id >= 8)
                        puntajesAObservar.push("formulario.EvaluacionesObjetivo["+pos+"].puntaje_modificado");

                ponderacionAObservar.push("formulario.EvaluacionesObjetivo["+pos+"].porcentaje_ponderacion");
            });

            // watch puntaje objetivos
            $scope.$watchGroup(puntajesAObservar, function(data,pos){
                $scope.puntajeObjetivos = 0.00;
                $scope.ingresadoPonderado = 0.00;

                angular.forEach(data, function(ingresado, key){                    
                    if(angular.isDefined(ingresado)){

                        if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id < 4)
                            $scope.formulario.EvaluacionesObjetivo[key].puntaje = parseInt(ingresado);
                        else
                            if (evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id >= 4 && evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id < 8){
                                $scope.formulario.EvaluacionesObjetivo[key].puntaje_calibrado = parseInt(ingresado);
                                $scope.formulario.EvaluacionesObjetivo[key].puntaje_modificado = parseInt(ingresado);

                            }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id >= 8)
                                $scope.formulario.EvaluacionesObjetivo[key].puntaje_modificado = parseInt(ingresado);

                        var ingresoValido = false;
                        angular.forEach(nivelLogrosObjetivos, function(value, id){

                            if(angular.isDefined(id)){
                                if( (ingresado >= value.inicio ) && (ingresado <= value.termino) ) {
                                    $scope.formulario.EvaluacionesObjetivo[key].niveles_logro_id = id;

                                    if(angular.isDefined($scope.formulario.EvaluacionesObjetivo[key].porcentaje_ponderacion) && (angular.isDefined($scope.formulario.EvaluacionesObjetivo[key].puntaje) || angular.isDefined($scope.formulario.EvaluacionesObjetivo[key].puntaje_calibrado)) ){
                                        var ponderacion = $scope.formulario.EvaluacionesObjetivo[key].porcentaje_ponderacion;
                                        $scope.ingresadoPonderado = (ingresado * ponderacion / 100);
                                        $scope.puntajeObjetivos = $scope.puntajeObjetivos + $scope.ingresadoPonderado;
                                        console.log($scope.puntajeObjetivos);
                                    }
                                    ingresoValido = true;   
                                }
                            }
                        });

                        if($scope.formulario.EvaluacionesObjetivo[key].puntaje_calibrado!=$scope.formulario.EvaluacionesObjetivo[key].puntaje_modificado)                      
                            $scope.formulario.EvaluacionesObjetivo[key].modificado_evaluador = 1;
                        else
                            $scope.formulario.EvaluacionesObjetivo[key].modificado_evaluador = 0;

                        if($scope.formulario.EvaluacionesObjetivo[key].puntaje!=$scope.formulario.EvaluacionesObjetivo[key].puntaje_calibrado)                      
                            $scope.formulario.EvaluacionesObjetivo[key].observado_validador = 1;
                        else
                            $scope.formulario.EvaluacionesObjetivo[key].observado_validador = 0;


                        if(!ingresoValido){
                            if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id < 4){
                                delete $scope.formulario.EvaluacionesObjetivo[key]['puntaje'];

                            }else if (evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id >= 4 && evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id < 8){
                                delete $scope.formulario.EvaluacionesObjetivo[key]['puntaje_calibrado'];
                                delete $scope.formulario.EvaluacionesObjetivo[key]['puntaje_modificado'];

                            }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id >= 8)
                                delete $scope.formulario.EvaluacionesObjetivo[key]['puntaje_modificado'];

                            delete $scope.formulario.EvaluacionesObjetivo[key]['niveles_logro_id'];
                        }
                    }
                });                
                $scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos = (Math.round(100*$scope.puntajeObjetivos)/100).toFixed(2);//Number($scope.puntajeObjetivos.toFixed(2));
            });

            if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id < 4){
                // watch ponderado objetivos
                $scope.datosAux = [undefined,undefined,undefined];
                $scope.$watchGroup(ponderacionAObservar, function(datosNuevos, datosAntiguos, scope){   
                    $scope.puntajeObjetivos = 0.00;
                    $scope.ponderacionObjetivos = 0.00;
                    $scope.maxPonderacionTotal = 100;
                    maxPoderacion = 50;
                    minPoderacion = 0;
                    var distinto;
                    for( i = 0; i < datosNuevos.length ; i++ ){
                        if(datosNuevos[i] != $scope.datosAux[i]){
                            distinto = i;
                        }
                        $scope.datosAux[i] = datosNuevos[i];
                    }
                    angular.forEach(datosNuevos, function(ponderacion, obj){
                        if( angular.isDefined(ponderacion) && ponderacion >= minPoderacion && ponderacion <= maxPoderacion){
                            $scope.formulario.EvaluacionesObjetivo[obj]['porcentaje_ponderacion'] = parseInt(ponderacion);
                            
                            $scope.ponderacionObjetivos = $scope.ponderacionObjetivos + ponderacion;
                            if($scope.formulario.EvaluacionesObjetivo[obj]['puntaje']){
                                puntajePonderado = ($scope.formulario.EvaluacionesObjetivo[obj]['puntaje'] * ponderacion / 100);
                                $scope.puntajeObjetivos = $scope.puntajeObjetivos + puntajePonderado;
                            }
                            if($scope.ponderacionObjetivos > $scope.maxPonderacionTotal && angular.isDefined(distinto)){            
                                delete $scope.formulario.EvaluacionesObjetivo[distinto]['porcentaje_ponderacion'];
                            }
                        }else{
                            if(angular.isDefined(ponderacion)){
                                delete scope.formulario.EvaluacionesObjetivo[obj]['porcentaje_ponderacion'];
                            }                        
                        }
                    });                    
                    $scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos = (Math.round(100*$scope.puntajeObjetivos)/100).toFixed(2);
                }); 
            }
            // paso 3
            var ptjPonderado = $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado;
            angular.forEach($scope.nivelesLogroPaso3, function(nivel, num){
                if( (ptjPonderado >= nivel.rango_inicio ) && (ptjPonderado <= nivel.rango_termino) ) {
                    $scope.formulario.EvaluacionesTrabajadore.niveles_logro_id = nivel.id;
                    $scope.situacionDesemepeno = nivel.nombre;
                }
            });

            // paso 4 y 5
            if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id >= 4){                
                //puntajes anteriores competencias
                competenciasAObservar = [];
                angular.forEach($scope.competencias, function(valor, key){
                    competenciasAObservar.push("formulario.EvaluacionesCompetencia["+key+"].niveles_anterior");
                });
                $scope.$watchGroup(competenciasAObservar, function(datos){
                    $scope.puntajeCompetenciasAnterior = 0;
                    angular.forEach($scope.formulario.EvaluacionesCompetencia, function(valor, key){
                        angular.forEach($scope.nivelesLogroPaso1, function(value, id){
                            if(angular.isDefined(value.id)){
                                if( valor.puntaje >= value.rango_inicio && valor.puntaje <= value.rango_termino ) {
                                    $scope.formulario.EvaluacionesCompetencia[key].niveles_anterior = value.id;                                    
                                }
                            }
                        });      
                        $scope.puntajeCompetenciasAnterior = Number(valor.puntaje) + $scope.puntajeCompetenciasAnterior;              
                    });
                });

                competenciasGeneralesAObservar = [];
                angular.forEach($scope.competencias, function(valor, key){
                    competenciasGeneralesAObservar.push("formulario.EvaluacionesCompetenciasGenerale["+key+"].niveles_anterior");
                });
                $scope.$watchGroup(competenciasGeneralesAObservar, function(datos){
                    angular.forEach($scope.formulario.EvaluacionesCompetenciasGenerale, function(valor, key){
                        angular.forEach($scope.nivelesLogroPaso1, function(value, id){
                            if(angular.isDefined(value.id)){
                                if( valor.puntaje >= value.rango_inicio && valor.puntaje <= value.rango_termino ) 
                                    $scope.formulario.EvaluacionesCompetenciasGenerale[key].niveles_anterior = value.id;
                            }
                        });    
                        $scope.puntajeCompetenciasAnterior = Number(valor.puntaje) + $scope.puntajeCompetenciasAnterior;                
                    });
                });
                //

                //puntajes anteriores objetivos 
                $scope.puntajeObjetivosAnterior = 0.00;
                $scope.ingresadoPonderado = 0.00;
                angular.forEach($scope.formulario.EvaluacionesObjetivo, function(value, id){
                    if(angular.isDefined(id)){                        
                        if(angular.isDefined($scope.formulario.EvaluacionesObjetivo[id].puntaje) ){
                            var ponderacion = $scope.formulario.EvaluacionesObjetivo[id].porcentaje_ponderacion;
                            $scope.ingresadoPonderado = ($scope.formulario.EvaluacionesObjetivo[id].puntaje * ponderacion / 100);
                            $scope.puntajeObjetivosAnterior = $scope.puntajeObjetivosAnterior + $scope.ingresadoPonderado;                                    
                        }
                    }
                });
                $scope.puntajeObjetivosAnterior = (Math.round(100*$scope.puntajeObjetivosAnterior)/100).toFixed(2);//Number($scope.puntajeObjetivos.toFixed(2));
                //

                //modificaciones
/*$scope.cambioCompetencias = [];
                $scope.cambioCompetenciaGeneral = [];
                $scope.cambioObjetivo = [];

                modifCompetenciaAObservar = [];
                logroComInicial = [];
                observadoComInicial = [];

                angular.forEach($scope.competencias, function(valor, pos){
                    modifCompetenciaAObservar.push("formulario.EvaluacionesCompetencia["+pos+"].niveles_logro_id");
                    logroComInicial[pos] = evaluacionData.EvaluacionesCompetencia[pos].niveles_logro_id;                
                    observadoComInicial[pos] = evaluacionData.EvaluacionesCompetencia[pos].observado_validador;
                });
                $scope.$watchGroup(modifCompetenciaAObservar, function(data){
                    angular.forEach(data, function(texto, key){
                        
                        if( ( angular.isDefined(texto) && logroComInicial[key]!=$scope.formulario.EvaluacionesCompetencia[key].niveles_logro_id) || (observadoComInicial[key] == 1) ){
                            $scope.formulario.EvaluacionesCompetencia[key].observado_validador = 1;
                        }else{
                            $scope.formulario.EvaluacionesCompetencia[key].observado_validador = 0;
                        }
                    });
                });

                modifComGeneralAObservar = [];
                logroComGeneralInicial = [];
                observadoComGeneralInicial = [];

                angular.forEach($scope.competenciasGenerales, function(valor, pos){
                    modifComGeneralAObservar.push("formulario.EvaluacionesCompetenciasGenerale["+pos+"].niveles_logro_id");
                    logroComGeneralInicial[pos] = evaluacionData.EvaluacionesCompetenciasGenerale[pos].niveles_logro_id;       
                    observadoComGeneralInicial[pos] = evaluacionData.EvaluacionesCompetenciasGenerale[pos].observado_validador;
                });
                $scope.$watchGroup(modifComGeneralAObservar, function(data){
                    angular.forEach(data, function(texto, key){
                        
                        if( ( angular.isDefined(texto) && logroComGeneralInicial[key]!=$scope.formulario.EvaluacionesCompetenciasGenerale[key].niveles_logro_id) || (observadoComGeneralInicial[key] == 1) ){
                            $scope.formulario.EvaluacionesCompetenciasGenerale[key].observado_validador = 1;
                        }else{
                            $scope.formulario.EvaluacionesCompetenciasGenerale[key].observado_validador = 0;
                        }
                    });
                });

                modifObjAObservar = [];
                puntajeObjInicial = [];
                observadoObjInicial = [];
                angular.forEach($scope.objetivos, function(valor, pos){
                    modifObjAObservar.push("formulario.EvaluacionesObjetivo["+pos+"].puntaje_calibrado");
                    puntajeObjInicial[pos] = evaluacionData.EvaluacionesObjetivo[pos].puntaje_calibrado;
                    observadoObjInicial[pos] = evaluacionData.EvaluacionesObjetivo[pos].observado_validador;
                });

                $scope.$watchGroup(modifObjAObservar, function(data){
                    angular.forEach(data, function(inputValue, key){

                        if( (angular.isDefined(inputValue) && puntajeObjInicial[key]!=$scope.formulario.EvaluacionesObjetivo[key].puntaje_calibrado) || (observadoObjInicial[key] == 1) ){
                            $scope.formulario.EvaluacionesObjetivo[key].observado_validador = 1;
                        }else{
                            $scope.formulario.EvaluacionesObjetivo[key].observado_validador = 0;
                        }
                    });
                });*/
            }// fin paso 4 - calibrar

            //$scope.pasoAgendarReunion = true;
            var totalesAObservar = ["formulario.EvaluacionesTrabajadore.puntaje_objetivos",
            "formulario.EvaluacionesTrabajadore.puntaje_competencias",
            "formulario.EvaluacionesTrabajadore.puntaje_ponderado"];

            $scope.$watchGroup(totalesAObservar, function(data){                      
                $scope.suma = Number($scope.formulario.EvaluacionesTrabajadore.puntaje_competencias) + Number($scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos);
                $scope.suma = (Math.round(100*$scope.suma)/100).toFixed(2);
                $scope.poderado =  Number($scope.suma / 2);
                $scope.redondeado = (Math.round(100*$scope.poderado)/100).toFixed(2);
                $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado = $scope.redondeado;
                var ptjPonderado = $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado;

                angular.forEach($scope.nivelesLogroPaso3, function(nivel, num){
                    if( (ptjPonderado >= nivel.rango_inicio ) && (ptjPonderado <= nivel.rango_termino) ) {
                        $scope.formulario.EvaluacionesTrabajadore.niveles_logro_id = nivel.id;
                        $scope.situacionDesemepeno = nivel.nombre;
                    }
                });
            });    

            // paso final
            //if($scope.impEvaluacionFinal || $scope.imprimirEvaluacion || $scope.pasoAgendarReunion){

                var puntajesPaso1 = [];
                $scope.nivelLogros1Nombre = {}; 
                angular.forEach($scope.nivelesLogroPaso1, function(nivelLogro){
                    $scope.nivelLogros1Nombre[nivelLogro.id] = nivelLogro.nombre;
                    puntajesPaso1.push(nivelLogro.rango_termino);
                }); 
                totalCompetencias   = 0;
                angular.forEach($scope.formulario.EvaluacionesCompetencia, function(data){
                    totalCompetencias = totalCompetencias + data.puntaje;
                });            
                maximoCompetencias  = Math.max.apply(null, puntajesPaso1) * $scope.formulario.EvaluacionesCompetencia.length;   
                $scope.porcentajeLogradoCompetencias    = (100 * totalCompetencias) / maximoCompetencias;

                //competencias generales
                var puntajesPaso2 = [];            
                $scope.nivelLogros2Nombre = {};
                angular.forEach($scope.nivelesLogroPaso2, function(nivelLogro2){
                    $scope.nivelLogros2Nombre[nivelLogro2.id] = nivelLogro2.nombre;
                    puntajesPaso2.push(nivelLogro2.rango_termino);
                }); 
                totalCompetenciasGen = 0;
                angular.forEach($scope.formulario.EvaluacionesCompetenciasGenerale, function(data){
                    totalCompetenciasGen = totalCompetenciasGen + data.puntaje;
                });
                
                maximoCompetenciasGen = Math.max.apply(null, puntajesPaso1) * $scope.formulario.EvaluacionesCompetenciasGenerale.length;
                $scope.porcentajeLogradoCompetenciasGen = (100 * totalCompetenciasGen) / maximoCompetenciasGen;           

                //objetivos
                totalObjetivos = 0;
                angular.forEach($scope.formulario.EvaluacionesObjetivo, function(data){
                    totalObjetivos = totalObjetivos + data.puntaje;
                });    
                maximoObjetivos = Math.max.apply(null, puntajesPaso2) * $scope.formulario.EvaluacionesObjetivo.length;         
                $scope.porcentajeLogradoObjetivos  = (100 * totalObjetivos ) / maximoObjetivos;
                // fin confirmar
           // }

        });
    };

    $scope.habilitarEdicion = function(){
        var confirmaNotificacion;

        if($scope.formulario.EvaluacionesTrabajadore.nodo_inicial!=1)
            confirmaNotificacion = confirm("Podrás modificar la evaluación de desempeño. Se notificará a "+$scope.trabajador.nombre_calibrador+" de los cambios. ¿deseas continuar?");

        if(confirmaNotificacion || $scope.formulario.EvaluacionesTrabajadore.nodo_inicial==1){
            $scope.habilitarEditar = true;
            $scope.formulario.EvaluacionesTrabajadore.modificada = 1; 
        }       
    };

    $scope.editarEvaluacion = function(evaluacion){

        if(angular.isDefined($scope.idEvaluacion)){
            $scope.formulario.EvaluacionesTrabajadore.id = $scope.idEvaluacion;
        }

        if(evaluacion == 2 ){
            $scope.suma = Number($scope.formulario.EvaluacionesTrabajadore.puntaje_competencias) + Number($scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos);
            $scope.suma = (Math.round(100*$scope.suma)/100).toFixed(2);
            $scope.poderado =  Number($scope.suma / 2);
            $scope.redondeado = (Math.round(100*$scope.poderado)/100).toFixed(2);
            $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado = $scope.redondeado;
            //$scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado = Number( parseFloat(($scope.formulario.EvaluacionesTrabajadore.puntaje_competencias + $scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos ) / 2).toFixed(2) );
            var ptjPonderado = $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado;

            angular.forEach($scope.nivelesLogroPaso3, function(nivel, num){
                if( (ptjPonderado >= nivel.rango_inicio ) && (ptjPonderado <= nivel.rango_termino) ) {

                    $scope.formulario.EvaluacionesTrabajadore.niveles_logro_id = nivel.id;
                    $scope.situacionDesemepeno = nivel.nombre;
                }
            });
        }
        if( angular.isDefined($scope.formulario.EvaluacionesTrabajadore.archivo) ){

            var archivo = $scope.formulario.EvaluacionesTrabajadore.archivo;  
            delete $scope.formulario.EvaluacionesTrabajadore.archivo;
            $scope.archivoSeleccionado = true;
        }       


        evaluacionesService.addEvaluacion($scope.formulario).success(function (data){
                if(data.estado==1){

                    if(angular.isDefined(data.data)){
                        $scope.formulario = data.data;
                        console.log($scope.formulario);
                        if($scope.archivoSeleccionado)
                            $scope.formulario.EvaluacionesTrabajadore.archivo = archivo; 
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

    $scope.siguienteEvaluacion = function(evaluacion){

        $scope.gotoId('miga');
        console.log(evaluacion);
        if(evaluacion == 2 ){
            //$scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado = Number( parseFloat(($scope.formulario.EvaluacionesTrabajadore.puntaje_competencias + $scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos ) / 2).toFixed(2) );
            $scope.suma = Number($scope.formulario.EvaluacionesTrabajadore.puntaje_competencias) + Number($scope.formulario.EvaluacionesTrabajadore.puntaje_objetivos);
            $scope.suma = (Math.round(100*$scope.suma)/100).toFixed(2);
            $scope.poderado =  Number($scope.suma / 2);
            $scope.redondeado = (Math.round(100*$scope.poderado)/100).toFixed(2);
            $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado = $scope.redondeado;

            var ptjPonderado = $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado;
            angular.forEach($scope.nivelesLogroPaso3, function(nivel, num){
                if( (ptjPonderado >= nivel.rango_inicio ) && (ptjPonderado <= nivel.rango_termino) ) {

                    $scope.formulario.EvaluacionesTrabajadore.niveles_logro_id = nivel.id;
                    $scope.situacionDesemepeno = nivel.nombre;
                }
            });
        }

        $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion = (new Date()).toISOString().substring(0, 10);

        if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==3 && $scope.formulario.EvaluacionesTrabajadore.nodo_inicial==1){
            $scope.evaluacion = false;
            $scope.pasoDialogo = false;
            $scope.loader = true;
            $scope.gotoId('miga');

            angular.forEach($scope.formulario.EvaluacionesCompetencia, function(data,key) {
                $scope.formulario.EvaluacionesCompetencia[key].puntaje_calibrado = data.puntaje;
                $scope.formulario.EvaluacionesCompetencia[key].puntaje_modificado = data.puntaje;
            });
            angular.forEach($scope.formulario.EvaluacionesCompetenciasGenerale, function(data,key) {
                $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_calibrado = data.puntaje;
                $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_modificado = data.puntaje;
            });
            angular.forEach($scope.formulario.EvaluacionesObjetivo, function(data,key) {
                $scope.formulario.EvaluacionesObjetivo[key].puntaje_calibrado = data.puntaje;
                $scope.formulario.EvaluacionesObjetivo[key].puntaje_modificado = data.puntaje;
            });
            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = 7;

        }else if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==5){
            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id + 2;

        }else{
            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id + 1;
        }

        //validar estados y cambiar de pantalla    
        //console.log($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id);
        /*if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id == 7)
            var formulario = $scope.formulario.EvaluacionesTrabajadore;
        else
            var formulario = $scope.formulario;*/

        evaluacionesService.addEvaluacion($scope.formulario).success(function (data){
            if(data.estado==1){

                if(data.correo==1){
                    Flash.create('success', data.mensaje_correo, 'customAlert');
                }else{
                    Flash.create('success', data.mensaje, 'customAlert');
                }
                
                $scope.idEvaluacion = data.id;
                if(angular.isDefined(data.data))
                    $scope.formulario = data.data; // --queso

                if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id == 2){
                    $scope.pasoCompetencias =  false;
                    $scope.pasoObjetivos =  true;
                    $scope.pasoDialogo =  false;

                }else if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id == 3){
                    $scope.pasoCompetencias =  false;
                    $scope.pasoObjetivos =  false;
                    $scope.pasoDialogo =  true;

                }else if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id == 7){
                    if($scope.formulario.EvaluacionesTrabajadore.nodo_inicial==1){
                        $window.location = host+'evaluaciones_trabajadores/calibrar_edit/'+$scope.formulario.EvaluacionesTrabajadore.id;  
                    }
                    $scope.pasoCalibrar = false; 
                    $scope.pasoAgendarReunion = true;                       
                }

            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });      

    };

    $scope.enviarEvaluacion = function(){

        if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id == 8){
            confirmacionEnvio = confirm("Has completado la evaluación de desempeño. Recuerda al colaborador que debe validar el proceso desde su sesión. ¿Deseas continuar?");  /*Posteriormente debes adjuntar documento firmado por ambos.*/ 
        }else {
            confirmacionEnvio = confirm("La evaluación de desempeño se enviará a "+ $scope.trabajador.nombre_calibrador +" para su calibración. ¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.");
        }
        envioEvaluacion = function(){

            if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id <= 4){
                angular.forEach( $scope.formulario.EvaluacionesCompetencia , function(value,key){
                    $scope.formulario.EvaluacionesCompetencia[key].puntaje_calibrado = $scope.formulario.EvaluacionesCompetencia[key].puntaje;
                });
                angular.forEach( $scope.formulario.EvaluacionesCompetenciasGenerale , function(value,key){
                    $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje_calibrado = $scope.formulario.EvaluacionesCompetenciasGenerale[key].puntaje;
                });
                angular.forEach( $scope.formulario.EvaluacionesObjetivo , function(value,key){
                    $scope.formulario.EvaluacionesObjetivo[key].puntaje_calibrado = $scope.formulario.EvaluacionesObjetivo[key].puntaje;
                });
            }            
            evaluacionesService.addEvaluacion($scope.formulario).success(function (data){

                $scope.loader = false;
                $scope.evaluacion = true;                

                if(data.estado==1){
                    
                    $scope.evFinalizada = true;
                    $scope.mensaje = true;
                    if(!angular.isDefined($scope.formulario.EnvioCorreo.enviar_a_nombre))
                        $scope.formulario.EnvioCorreo.enviar_a_nombre = '';

                    $scope.msgExito = "Has enviado correctamente la evaluación de desempeño a " + $scope.formulario.EnvioCorreo.enviar_a_nombre + ".";

                    if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id != 9){      //validacion colaborador
                        $scope.msgExitoDetalle = "Recuerda que posterior a la Calibración deberás revisar si existen o no observaciones.";
                    }else{
                        $scope.msgExitoDetalle = "";
                    }


                    if(data.correo==1){
                        Flash.create('success', data.mensaje_correo, 'customAlert'); 

                    }else if(data.correo==0){
                        Flash.create('success', data.mensaje_correo, 'customAlert'); 

                    }else{
                        Flash.create('success', data.mensaje, 'customAlert'); 
                    }

                }else if(data.estado==0){
                    Flash.create('danger', data.mensaje, 'customAlert');
                }
            });
        };

        
        if(confirmacionEnvio){
            $scope.evaluacion = false;
            $scope.pasoDialogo = false;
            $scope.loader = true;
            $scope.gotoId('miga');

            $scope.formulario.EnvioCorreo = {};
            $scope.formulario.EnvioCorreo.trabajador_nombre = $scope.trabajador.nombre;
            $scope.formulario.EnvioCorreo.trabajador_cargo  = $scope.trabajador.cargo;
            $scope.formulario.EnvioCorreo.trabajador_email  = $scope.trabajador.email;
            $scope.formulario.EnvioCorreo.evaluador_nombre  = $scope.trabajador.jefatura;
            $scope.formulario.EnvioCorreo.evaluador_email   = $scope.trabajador.email_jefatura;
            $scope.formulario.EnvioCorreo.calibrador_nombre = $scope.trabajador.nombre_calibrador;
            $scope.formulario.EnvioCorreo.calibrador_email  = $scope.trabajador.email_calibrador;

            if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id == 8){ 

                $scope.formulario.EnvioCorreo.asunto            = "Validación Evaluación de Desempeño " + $scope.trabajador.nombre;
                $scope.formulario.EnvioCorreo.enviar_a_nombre   = $scope.trabajador.nombre;
                $scope.formulario.EnvioCorreo.enviar_a_email    = $scope.trabajador.email;
                $scope.formulario.EnvioCorreo.anio_evaluado     = $scope.formulario.EvaluacionesTrabajadore.anio;


                if($scope.formulario.EvaluacionesTrabajadore.modificada==1){

                    var nombrePDF   = 'preliminar'+ $scope.formulario.EvaluacionesTrabajadore.trabajadore_id+'.pdf';   
                    var controlador = 'evaluaciones_trabajadores';
                    var carpeta     = 'tmp';
                    parametros = {
                        "nombre": nombrePDF, 
                        "controlador" : controlador,
                        "carpeta" : carpeta,
                        "html"  : angular.element("#plantillaEvaluador").html()
                    }
                    var imprimirHtml = $http({
                        method: 'POST',
                        url: host+'servicios/pdf_basico2',
                        data: $.param(parametros)
                    });
                    imprimirHtml.then(function(data){

                        $scope.formulario.EnvioCorreo.archivo_adjunto = nombrePDF;
                        $scope.formulario.EnvioCorreo.archivo_controlador   = controlador;
                        $scope.formulario.EnvioCorreo.archivo_carpeta       = carpeta; 

                        $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion        = (new Date()).toISOString().substring(0, 10);
                        $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id    = $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id + 1; 
                        envioEvaluacion();

                    });                         
                   
                }else {
                    $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion        = (new Date()).toISOString().substring(0, 10);
                    $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id    = $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id + 1; 
                    envioEvaluacion();
                }             

            }else {

                $scope.formulario.EnvioCorreo.asunto            = "Calibración de Desempeño " + $scope.trabajador.nombre;
                $scope.formulario.EnvioCorreo.enviar_a_email    = $scope.trabajador.email_calibrador; 
                $scope.formulario.EnvioCorreo.enviar_a_nombre   = $scope.trabajador.nombre_calibrador; 

                $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion        = (new Date()).toISOString().substring(0, 10);
                $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id    = $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id + 1; 
                envioEvaluacion();
            }           
        }
    };

    $scope.enviarCalibracion = function(){
 
        $scope.evaluacion = false;
        $scope.pasoCalibracion = false;
        $scope.loader = true;
        tieneObservacion = 0;
        $scope.gotoId('miga');

        angular.forEach($scope.formulario.EvaluacionesCompetencia, function(valor, pos){
            if(valor.observado_validador == 1)                    
                tieneObservacion = 1;
        });
        if(tieneObservacion == 0) {
            angular.forEach($scope.formulario.EvaluacionesCompetenciasGenerale, function(valor, pos){
                if(valor.observado_validador == 1)                    
                    tieneObservacion = 1;
            });
        }
        if(tieneObservacion == 0){
            angular.forEach($scope.formulario.EvaluacionesObjetivo, function(valor, pos){
                if(valor.observado_validador == 1)
                    tieneObservacion = 1;
            });
        }
        /* Calibracion */
        if(tieneObservacion == 1){
            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id  =  5;  
        }else {
            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id  =  7;  
        }

        $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion = (new Date()).toISOString().substring(0, 10);
        
        $scope.formulario.EnvioCorreo = {};
        $scope.formulario.EnvioCorreo.trabajador_nombre = $scope.trabajador.nombre;
        $scope.formulario.EnvioCorreo.trabajador_cargo  = $scope.trabajador.cargo;
        $scope.formulario.EnvioCorreo.evaluador_nombre  = $scope.trabajador.jefatura;
        $scope.formulario.EnvioCorreo.evaluador_email   = $scope.trabajador.email_jefatura;
        $scope.formulario.EnvioCorreo.calibrador_nombre = $scope.trabajador.nombre_calibrador;
        $scope.formulario.EnvioCorreo.calibrador_email  = $scope.trabajador.email_calibrador;

        $scope.formulario.EnvioCorreo.asunto            = "Calibración de Desempeño " + $scope.trabajador.nombre;
        $scope.formulario.EnvioCorreo.enviar_a_nombre   = $scope.trabajador.jefatura;
        $scope.formulario.EnvioCorreo.enviar_a_email    = $scope.trabajador.email_jefatura;

        evaluacionesService.addEvaluacion($scope.formulario).success(function (data){


            $scope.loader = false;
            $scope.evaluacion = true;                

            if(data.estado==1){
                
                $scope.evFinalizada = true;
                $scope.mensaje = true;
                $scope.msgExito = "Has enviado correctamente la calibración de desempeño a " + $scope.trabajador.jefatura + ".";
                $scope.msgExitoDetalle = "";

                if(data.correo==1){
                    Flash.create('success', data.mensaje_correo, 'customAlert');
                }else{
                    Flash.create('success', data.mensaje, 'customAlert'); 
                }

            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };

    $scope.confirmarEvaluacion = function (idTrabajador){ // ver

        $scope.loader = true;
        $scope.cargador = loader;

        evaluacionesService.getEvaluacion(idEvaluacion).success( function(evaluacionData){

            $scope.loader = false;
            $scope.evaluacion = true;

            if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 1){
                $scope.pasoCompetencias =  true;
                $scope.pasoObjetivos =  false;
                $scope.pasoDialogo =  false;
            }
        });
    };

    $scope.imprimirPlantilla = function(idEvaluacion){

        var plantilla   = 'plantillaEvaluador';
        var nombrePDF   = 'preliminar'+ $scope.formulario.EvaluacionesTrabajadore.trabajadore_id+'.pdf';
        var carpeta     = 'tmp';

        if( angular.isDefined($scope.formulario.EvaluacionesTrabajadore.archivo) ){

            var archivo = $scope.formulario.EvaluacionesTrabajadore.archivo;  
            delete $scope.formulario.EvaluacionesTrabajadore.archivo;
            $scope.archivoSeleccionado = true;
        }

        if($scope.impEvaluacionFinal){
            evaluacionesService.addEvaluacion($scope.formulario).success(function (data){
                if(data.estado==1){
                    if($scope.archivoSeleccionado)
                            $scope.formulario.EvaluacionesTrabajadore.archivo = archivo; 

                }else if(data.estado==0){
                    Flash.create('danger', data.mensaje, 'customAlert');
                }
            });

            plantilla = 'plantillaFinal';
            nombrePDF   = 'evaluacion_'+ $scope.formulario.EvaluacionesTrabajadore.trabajadore_id+'_'+$scope.formulario.EvaluacionesTrabajadore.anio+'.pdf';   
            carpeta     = $scope.formulario.EvaluacionesTrabajadore.anio;
        }
     
        parametros = {
                "nombre": nombrePDF, 
                "controlador" : 'evaluaciones_trabajadores',
                "carpeta" : carpeta,
                "html"  : angular.element("#"+plantilla).html()
            }

        var imprimirHtml = $http({
                method: 'POST',
                url: host+'servicios/pdf_basico2',
                data: $.param(parametros)
            });

        imprimirHtml.success(function(data, status, headers, config){  
            $window.open(data);
        });
    };

    $scope.enviarCitaReunion = function(){

        $scope.evaluacion = false;
        $scope.pasoCalibracion = false;
        $scope.loader = true;
        $scope.gotoId('miga');
        
        $scope.formulario.EnvioCorreo = {};
        var nombrePDF   = 'preliminar'+ $scope.formulario.EvaluacionesTrabajadore.trabajadore_id+'.pdf';   
        var controlador = 'evaluaciones_trabajadores';
        var carpeta     = 'tmp';
        parametros = {
            "nombre": nombrePDF, 
            "controlador" : controlador,
            "carpeta" : carpeta,
            "html"  : angular.element("#plantillaEvaluador").html()
        }
        var imprimirHtml = $http({
            method: 'POST',
            url: host+'servicios/pdf_basico2',
            data: $.param(parametros)
        });
        imprimirHtml.then(function(data){

            console.log(data);

            $scope.formulario.EnvioCorreo.archivo_adjunto = nombrePDF;
            $scope.formulario.EnvioCorreo.archivo_controlador   = controlador;
            $scope.formulario.EnvioCorreo.archivo_carpeta       = carpeta;          

            $scope.formulario.EnvioCorreo.asunto            = "Diálogo de Desempeño " + $scope.trabajador.nombre;
            $scope.formulario.EnvioCorreo.enviar_a_nombre   = $scope.trabajador.nombre;
            $scope.formulario.EnvioCorreo.enviar_a_email    = $scope.trabajador.email;

            $scope.formulario.EnvioCorreo.fecha_reunion     = $scope.formulario.EvaluacionesTrabajadore.fecha_reunion;
            $scope.formulario.EnvioCorreo.hora_reunion      = $scope.formulario.EvaluacionesTrabajadore.hora_reunion;
            $scope.formulario.EnvioCorreo.lugar_reunion     = $scope.formulario.EvaluacionesTrabajadore.lugar_reunion;
            $scope.formulario.EnvioCorreo.mensaje_reunion   = $scope.formulario.EvaluacionesTrabajadore.mensaje_reunion;          
            $scope.formulario.EnvioCorreo.anio_evaluacion   = $scope.formulario.EvaluacionesTrabajadore.anio;          

            $scope.formulario.EnvioCorreo.trabajador_nombre = $scope.trabajador.nombre;
            $scope.formulario.EnvioCorreo.trabajador_cargo  = $scope.trabajador.cargo;
            $scope.formulario.EnvioCorreo.trabajador_email  = $scope.trabajador.email;
            $scope.formulario.EnvioCorreo.evaluador_nombre  = $scope.trabajador.jefatura;
            $scope.formulario.EnvioCorreo.evaluador_email   = $scope.trabajador.email_jefatura;
            $scope.formulario.EnvioCorreo.calibrador_nombre = $scope.trabajador.nombre_calibrador;
            $scope.formulario.EnvioCorreo.calibrador_email  = $scope.trabajador.email_calibrador;

            $scope.formulario.EvaluacionesTrabajadore.fecha_reunion = $scope.formulario.EvaluacionesTrabajadore.fecha_reunion.split("-").reverse().join("-");
            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id + 1;  
            $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion = (new Date()).toISOString().substring(0, 10);

            
            evaluacionesService.addEvaluacion($scope.formulario).success(function (data){

                $scope.loader = false;
                $scope.evaluacion = true;

                if(data.estado==1){
                    $scope.evFinalizada = true;
                    $scope.mensaje = true;
                    $scope.msgExito = "Has enviado correctamente la cita a " + $scope.trabajador.nombre + ".";
                    $scope.msgExitoDetalle = "";

                    if(data.correo==1){
                        Flash.create('success', data.mensaje_correo, 'customAlert');
                    }else{
                        Flash.create('success', data.mensaje, 'customAlert'); 
                    }

                }else if(data.estado==0){
                    if(data.correo==0){
                        Flash.create('success', data.mensaje_correo, 'customAlert');
                    }else{
                        Flash.create('success', data.mensaje, 'customAler'); 
                    } 
                } 
            });     

        });    
    };


    $scope.finalizarEvaluacion = function(){

        $scope.evaluacion = false;
        $scope.pasoDialogo = false;
        $scope.loader = true;
        var documentoPendiente;
        var rutaArchivo;

        guardar = function (form){
            evaluacionesService.addEvaluacion(form).success(function (data){
                $scope.loader = false;
                $scope.evaluacion = true;
                $scope.gotoId('miga');

                if(data.estado==1){                    
                    $scope.evFinalizada = true;
                    $scope.mensaje = true;
                    $scope.msgExito = "Has finalizado correctamente la evaluación de " + $scope.trabajador.nombre + ".";

                    if(documentoPendiente)
                        $scope.msgExitoDetalle = "Recuerda que debes adjuntar la evaluación firmada por ti y el colaborador evaluado.";    
                    else
                        $scope.msgExitoDetalle = "";
                    
                    Flash.create('success', data.mensaje, 'customAlert');    

                }else if(data.estado==0){
                    Flash.create('danger', data.mensaje, 'customAlert');
                }
            });    
        };

        if(angular.isDefined($scope.formulario.EvaluacionesTrabajadore.archivo)){

            var archivo = $scope.formulario.EvaluacionesTrabajadore.archivo[0];
            delete $scope.formulario.EvaluacionesTrabajadore.archivo;

            evaluacionesService.subirEvaluacion(archivo, $scope.formulario.EvaluacionesTrabajadore).success(function (data){
                if(data.estado_archivo==1){ 
                    rutaArchivo = data.data.EvaluacionesTrabajadore.ruta_archivo;
                    documentoPendiente = false;
                }else{
                    Flash.create('danger', data.mensaje, 'customAlert');
                    documentoPendiente = true;
                }
            });

            if(!documentoPendiente){
                $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id + 2;  // finalizar
                $scope.formulario.EvaluacionesTrabajadore.ruta_archivo = rutaArchivo;
                
            }else{

                $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id + 1;  // finalizar                
                $scope.formulario.EvaluacionesTrabajadore.ruta_archivo = null;                
            }
            
            $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion  = (new Date()).toISOString().substring(0, 10);
            guardar($scope.formulario);
            
        }else{

            $scope.formulario.EvaluacionesTrabajadore.ruta_archivo = null;
            documentoPendiente = true;
            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = 11;  // documento pendiente
            $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion  = (new Date()).toISOString().substring(0, 10);  
            guardar($scope.formulario);
        }       
    };



    $scope.gotoId = function(id){
        $anchorScroll(id);
    };
});

app.controller('confirmarEdit', function ($scope, $http, evaluacionesService, Flash, $window, $location, $rootScope, $filter, $anchorScroll) {

    $scope.datosEvaluacion = function(idEvaluacion){

        $scope.loader = true;
        $scope.cargador = loader;
        $scope.confirmar = true;
        angular.element('#confirmar').bootstrapSwitch({
            'state': true
        });

        evaluacionesService.getEvaluacion(idEvaluacion).success(function (evaluacionData){
            console.log(evaluacionData);

            $scope.loader = false;
            $scope.evaluacion = true;
            $scope.evFinalizada = false;  
             
            if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 9){ //confirma evaluacion
                $scope.pasoConfirmarEvaluacion = false;
            }
                        
            $scope.evaluacionCompetencias   = evaluacionData.criteriosEvaluacion.evaluacionCompetencias.nombre;
            $scope.evaluacionObjetivos      = evaluacionData.criteriosEvaluacion.evaluacionObjetivos.nombre;
            $scope.evaluacionDialogo        = evaluacionData.criteriosEvaluacion.evaluacionPonderada.nombre;
            //niveles
            $scope.trabajador               = evaluacionData.datosTrabajador;
            $scope.nivelesLogroPaso1        = evaluacionData.criteriosEvaluacion.evaluacionCompetencias.criterios;
            $scope.nivelesLogroPaso2        = evaluacionData.criteriosEvaluacion.evaluacionObjetivos.criterios;
            $scope.nivelesLogroPaso3        = evaluacionData.criteriosEvaluacion.evaluacionPonderada.criterios;

            $scope.tiposEvaluaciones        = evaluacionData.tiposEvaluaciones;
            //detalles (textos)
            $scope.competencias             = evaluacionData.competencias;
            $scope.competenciasGenerales    = evaluacionData.competenciasGenerales;
            $scope.objetivos                = evaluacionData.objetivosClave;
            $scope.dialogos                 = evaluacionData.dialogosDesempeno;
            $scope.porcGrupoComp            = evaluacionData.puntajesGrupoComp;
            $scope.porcObjetivos            = evaluacionData.puntajesObjetivos; 
            $scope.anioEvaluado             = evaluacionData.anio_evaluado;
            
            $scope.tituloCompetencia            = evaluacionData.competencias[0].titulo;
            $scope.tituloCompetenciaGenerales   = evaluacionData.competenciasGenerales[0].titulo;

            $scope.formulario = {}; 
            $scope.formulario.EvaluacionesTrabajadore           = evaluacionData.EvaluacionesTrabajadore;
            $scope.formulario.EvaluacionesCompetencia           = evaluacionData.EvaluacionesCompetencia;
            $scope.formulario.EvaluacionesCompetenciasGenerale  = evaluacionData.EvaluacionesCompetenciasGenerale;
            $scope.formulario.EvaluacionesDialogo               = evaluacionData.EvaluacionesDialogo;
            $scope.formulario.EvaluacionesObjetivo              = evaluacionData.EvaluacionesObjetivo;
            $scope.formulario.EvaluacionesTrabajadore.acepta_trabajador = 1;
            $scope.formulario.EvaluacionesTrabajadore.puntaje_competencias = evaluacionData.EvaluacionesTrabajadore.puntaje_competencias;       
            //situacion desempeño
            var ptjPonderado = $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado;
            angular.forEach($scope.nivelesLogroPaso3, function(nivel, num){
                if( (ptjPonderado >= nivel.rango_inicio ) && (ptjPonderado <= nivel.rango_termino) ) {

                    $scope.formulario.EvaluacionesTrabajadore.niveles_logro_id = nivel.id;
                    $scope.situacionDesemepeno = nivel.nombre;
                }
            });     
            //porcentajes
            //competencias
            var puntajesPaso1 = [];
            $scope.nivelLogros1Nombre = {}; 
            angular.forEach($scope.nivelesLogroPaso1, function(nivelLogro){
                $scope.nivelLogros1Nombre[nivelLogro.id] = nivelLogro.nombre;
                puntajesPaso1.push(nivelLogro.rango_termino);
            }); 
            totalCompetencias   = 0;
            angular.forEach($scope.formulario.EvaluacionesCompetencia, function(data){
                totalCompetencias = totalCompetencias + data.puntaje;
            });            
            maximoCompetencias  = Math.max.apply(null, puntajesPaso1) * $scope.formulario.EvaluacionesCompetencia.length;   
            $scope.porcentajeLogradoCompetencias    = (100 * totalCompetencias) / maximoCompetencias;

            //competencias generales
            var puntajesPaso2 = [];            
            $scope.nivelLogros2Nombre = {};
            angular.forEach($scope.nivelesLogroPaso2, function(nivelLogro2){
                $scope.nivelLogros2Nombre[nivelLogro2.id] = nivelLogro2.nombre;
                puntajesPaso2.push(nivelLogro2.rango_termino);
            }); 
            totalCompetenciasGen = 0;
            angular.forEach($scope.formulario.EvaluacionesCompetenciasGenerale, function(data){
                totalCompetenciasGen = totalCompetenciasGen + data.puntaje;
            });
            
            maximoCompetenciasGen = Math.max.apply(null, puntajesPaso1) * $scope.formulario.EvaluacionesCompetenciasGenerale.length;
            $scope.porcentajeLogradoCompetenciasGen = (100 * totalCompetenciasGen) / maximoCompetenciasGen;           

            //objetivos
            totalObjetivos = 0;
            angular.forEach($scope.formulario.EvaluacionesObjetivo, function(data){
                totalObjetivos = totalObjetivos + data.puntaje;
            });    
            maximoObjetivos = Math.max.apply(null, puntajesPaso2) * $scope.formulario.EvaluacionesObjetivo.length;         
            $scope.porcentajeLogradoObjetivos  = (100 * totalObjetivos ) / maximoObjetivos;
            // fin confirmar

            angular.element('#confirmar').on('switchChange.bootstrapSwitch', function (e, data) {
                if(data===true){
                    $scope.formulario.EvaluacionesTrabajadore.acepta_trabajador = 1;
                }else{
                    $scope.formulario.EvaluacionesTrabajadore.acepta_trabajador = 0;
                } 
                $scope.$apply();
            });
        });
    };
     
    $scope.confirmarEvaluacion = function(){
        $scope.evaluacion = false;
        $scope.pasoConfirmarEvaluacion = false;
        $scope.loader = true;
        $scope.gotoId('miga'); 
               
        $scope.formulario.EnvioCorreo = {};

        $scope.formulario.EnvioCorreo.trabajador_nombre = $scope.trabajador.nombre;
        $scope.formulario.EnvioCorreo.trabajador_cargo  = $scope.trabajador.cargo;
        $scope.formulario.EnvioCorreo.trabajador_email  = $scope.trabajador.email;
        $scope.formulario.EnvioCorreo.evaluador_nombre  = $scope.trabajador.jefatura;
        $scope.formulario.EnvioCorreo.evaluador_email   = $scope.trabajador.email_jefatura;
        $scope.formulario.EnvioCorreo.calibrador_nombre = $scope.trabajador.nombre_calibrador;
        $scope.formulario.EnvioCorreo.calibrador_email  = $scope.trabajador.email_calibrador;

        $scope.formulario.EnvioCorreo.asunto            = "Validación Evaluación de Desempeño " + $scope.trabajador.nombre;
        $scope.formulario.EnvioCorreo.enviar_a_nombre   = $scope.trabajador.jefatura;
        $scope.formulario.EnvioCorreo.enviar_a_email    = $scope.trabajador.email_jefatura;  
        $scope.formulario.EnvioCorreo.colaborador_comentarios = $scope.formulario.EvaluacionesTrabajadore.comentario_trabajador; 
     

        guardarConfirmar =  function(formulario){

            $scope.formulario.EvaluacionesTrabajadore.fecha_modificacion = (new Date()).toISOString().substring(0, 10);          
            evaluacionesService.addEvaluacion($scope.formulario).success(function (data){
                $scope.loader = false;
                $scope.evaluacion = true;
                $scope.evFinalizada = true;

                if(data.estado==1){

                    $scope.mensaje = true;
                    $scope.msgExito = "Has confirmado correctamente la evaluación de desempeño.";
                    //gau
                        /*if($scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id == 10 || $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id == 11)
                            $scope.msgExitoDetalle = "Recuerda que para finalizar el proceso debes firmar el documento con tu evaluador.";
                        else
                            $scope.msgExitoDetalle = "";*/

                    if(data.correo==1){
                        Flash.create('success', data.mensaje_correo, 'customAlert');
                    }else {
                        Flash.create('success', data.mensaje, 'customAlert'); 
                    }

                }else if(data.estado==0 || data.estado==0){

                    if(data.estado==0){
                        Flash.create('danger', data.mensaje, 'customAlert');
                    }else{
                        Flash.create('danger', data.mensaje_correo, 'customAlert');
                    }
                }               
            });      
        };
        
        if($scope.formulario.EvaluacionesTrabajadore.acepta_trabajador == 0){                
            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = 10;  // correo mensaje "con observaciones"
            //guardarConfirmar($scope.formulario);                              --gau

        }else{
            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = 11;  // correo "sin observaciones" => con pdf final 
            // gau
           /* var nombrePDF   = 'evaluacion_'+ $scope.formulario.EvaluacionesTrabajadore.trabajadore_id+'_'+$scope.formulario.EvaluacionesTrabajadore.anio+'.pdf';   
            var controlador = 'evaluaciones_trabajadores';
            var carpeta     = $scope.formulario.EvaluacionesTrabajadore.anio;
            parametros = {
                "nombre": nombrePDF, 
                "controlador" : controlador,
                "carpeta" : carpeta,
                "html"  : angular.element("#plantillaFinal").html()
            }
            var imprimirHtml = $http({
                method: 'POST',
                url: host+'servicios/pdf_basico2',
                data: $.param(parametros)
            });
            imprimirHtml.then(function(data){
                $scope.formulario.EnvioCorreo.archivo_adjunto = nombrePDF;
                $scope.formulario.EnvioCorreo.archivo_controlador = controlador;
                $scope.formulario.EnvioCorreo.archivo_carpeta  = carpeta;
                guardarConfirmar($scope.formulario);
            });*/
        }      
        //gau
            var nombrePDF   = 'evaluacion_'+ $scope.formulario.EvaluacionesTrabajadore.trabajadore_id+'_'+$scope.formulario.EvaluacionesTrabajadore.anio+'.pdf';   
            var controlador = 'evaluaciones_trabajadores';
            var carpeta     = $scope.formulario.EvaluacionesTrabajadore.anio;
            parametros = {
                "nombre": nombrePDF, 
                "controlador" : controlador,
                "carpeta" : carpeta,
                "html"  : angular.element("#plantillaFinal").html()
            }
            var imprimirHtml = $http({
                method: 'POST',
                url: host+'servicios/pdf_basico2',
                data: $.param(parametros)
            });
            imprimirHtml.then(function(data){
                $scope.formulario.EnvioCorreo.archivo_adjunto = nombrePDF;
                $scope.formulario.EnvioCorreo.archivo_controlador = controlador;
                $scope.formulario.EnvioCorreo.archivo_carpeta  = carpeta;
                guardarConfirmar($scope.formulario);
            });       
        //
    };

    $scope.gotoId = function(id){
        //$location.path(id);
        $anchorScroll(id);
    };
});

app.controller('evaluacionesView', function ($scope, $http, evaluacionesService, Flash, $window, $location, $rootScope, $filter, $anchorScroll) {

    $scope.datosEvaluacion = function(idEvaluacion){

        $scope.loader = true;
        $scope.cargador = loader;

        evaluacionesService.getEvaluacion(idEvaluacion).success(function (evaluacionData){
            $scope.loader = false;
            $scope.evaluacion = true;
            $scope.evFinalizada = false;

            console.log(evaluacionData);

            /*if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 7 || evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 8){ //confirma evaluacion
                $scope.imprimirPrevio = true;

            }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 11){ //confirma evaluacion
                $scope.pasoAdjuntarArchivo = true;

            }else if(evaluacionData.EvaluacionesTrabajadore.evaluaciones_estado_id == 12){ //confirma evaluacion
                $scope.pasoConfirmarEvaluacion = false;
            }*/
            $scope.pasoConfirmarEvaluacion = false;
                        
            $scope.evaluacionCompetencias   = evaluacionData.criteriosEvaluacion.evaluacionCompetencias.nombre;
            $scope.evaluacionObjetivos      = evaluacionData.criteriosEvaluacion.evaluacionObjetivos.nombre;
            $scope.evaluacionDialogo        = evaluacionData.criteriosEvaluacion.evaluacionPonderada.nombre;
            $scope.competenciasAgrupadas    = evaluacionData.competenciasAgrupadas;
            //niveles
            $scope.trabajador               = evaluacionData.datosTrabajador;
            $scope.anioEvaluado             = evaluacionData.anio_evaluado;
            $scope.nivelesLogroPaso1        = evaluacionData.criteriosEvaluacion.evaluacionCompetencias.criterios;
            $scope.nivelesLogroPaso2        = evaluacionData.criteriosEvaluacion.evaluacionObjetivos.criterios;
            $scope.nivelesLogroPaso3        = evaluacionData.criteriosEvaluacion.evaluacionPonderada.criterios;
            $scope.porcGrupoComp            = evaluacionData.puntajesGrupoComp;
            $scope.porcObjetivos            = evaluacionData.puntajesObjetivos; 

            $scope.tiposEvaluaciones        = evaluacionData.tiposEvaluaciones;
            //detalles (textos)
            $scope.competencias             = evaluacionData.competencias;
            $scope.competenciasGenerales    = evaluacionData.competenciasGenerales;
            $scope.objetivos                = evaluacionData.objetivosClave;
            $scope.dialogos                 = evaluacionData.dialogosDesempeno;
            
            $scope.tituloCompetencia            = evaluacionData.competencias[0].titulo;
            $scope.tituloCompetenciaGenerales   = evaluacionData.competenciasGenerales[0].titulo;

            $scope.formulario   = {}; 
            $scope.formulario.EvaluacionesTrabajadore           = evaluacionData.EvaluacionesTrabajadore;
            $scope.formulario.EvaluacionesCompetencia           = evaluacionData.EvaluacionesCompetencia;
            $scope.formulario.EvaluacionesCompetenciasGenerale  = evaluacionData.EvaluacionesCompetenciasGenerale;
            $scope.formulario.EvaluacionesDialogo               = evaluacionData.EvaluacionesDialogo;
            $scope.formulario.EvaluacionesObjetivo              = evaluacionData.EvaluacionesObjetivo;

            $scope.formulario.EvaluacionesTrabajadore.puntaje_competencias = evaluacionData.EvaluacionesTrabajadore.puntaje_competencias;       
            //situacion desempeño
            var ptjPonderado = $scope.formulario.EvaluacionesTrabajadore.puntaje_ponderado;
            angular.forEach($scope.nivelesLogroPaso3, function(nivel, num){
                if( (ptjPonderado >= nivel.rango_inicio ) && (ptjPonderado <= nivel.rango_termino) ) {

                    $scope.formulario.EvaluacionesTrabajadore.niveles_logro_id = nivel.id;
                    $scope.situacionDesemepeno = nivel.nombre;
                }
            });
            //porcentajes
            //competencias
            var puntajesPaso1 = [];
            $scope.nivelLogros1Nombre = {}; 
            angular.forEach($scope.nivelesLogroPaso1, function(nivelLogro){
                $scope.nivelLogros1Nombre[nivelLogro.id] = nivelLogro.nombre;
                puntajesPaso1.push(nivelLogro.rango_termino);
            }); 
            totalCompetencias   = 0;      
            angular.forEach($scope.formulario.EvaluacionesCompetencia, function(data){
                totalCompetencias = totalCompetencias + data.puntaje;
            });
            console.log(Math.max.apply(null, puntajesPaso1) + " * " + $scope.formulario.EvaluacionesCompetencia.length);
            maximoCompetencias  = Math.max.apply(null, puntajesPaso1) * $scope.formulario.EvaluacionesCompetencia.length;   
            $scope.porcentajeLogradoCompetencias = (100 * totalCompetencias) / maximoCompetencias;
            $scope.totalCompetencias = totalCompetencias;
            $scope.maximoCompetencias = maximoCompetencias;

            //competencias generales
            var puntajesPaso2 = [];
            $scope.nivelLogros2Nombre = {};
            angular.forEach($scope.nivelesLogroPaso2, function(nivelLogro2){
                $scope.nivelLogros2Nombre[nivelLogro2.id] = nivelLogro2.nombre;
                puntajesPaso2.push(nivelLogro2.rango_termino);
            }); 
            totalCompetenciasGen = 0;
            angular.forEach($scope.formulario.EvaluacionesCompetenciasGenerale, function(data){
                totalCompetenciasGen = totalCompetenciasGen + data.puntaje;
            });
            
            maximoCompetenciasGen = Math.max.apply(null, puntajesPaso1) * $scope.formulario.EvaluacionesCompetenciasGenerale.length;
            $scope.porcentajeLogradoCompetenciasGen = (100 * totalCompetenciasGen) / maximoCompetenciasGen;           

            //objetivos
            totalObjetivos = 0;
            angular.forEach($scope.formulario.EvaluacionesObjetivo, function(data){
                totalObjetivos = totalObjetivos + data.puntaje;
            });    
            maximoObjetivos = Math.max.apply(null, puntajesPaso2) * $scope.formulario.EvaluacionesObjetivo.length;         
            $scope.porcentajeLogradoObjetivos  = (100 * totalObjetivos ) / maximoObjetivos;
            // fin confirmar
        });
    };

    $scope.subirArchivo = function(){

        $scope.evaluacion = false;
        $scope.loader = true;
        $scope.cargador = loader;

        if( !!$scope.formulario.EvaluacionesTrabajadore.archivo ){
            if(angular.isDefined($scope.formulario.EvaluacionesTrabajadore.archivo)){

                var archivo = $scope.formulario.EvaluacionesTrabajadore.archivo[0];
                delete $scope.formulario.EvaluacionesTrabajadore.archivo;

                evaluacionesService.subirEvaluacion(archivo, $scope.formulario.EvaluacionesTrabajadore).success(function (data){

                        if(data.estado_archivo==1){
                            $scope.guardado = true;
                            $scope.formulario.EvaluacionesTrabajadore.ruta_archivo = data.ruta_archivo;
                            $scope.formulario.EvaluacionesTrabajadore.evaluaciones_estado_id = 12;      //finalizado                                

                            evaluacionesService.addEvaluacion($scope.formulario).success(function (data){                                                                  

                                if(data.estado==1){
                                    $window.location = host+'evaluaciones_trabajadores/evaluar';                                  
                                    Flash.create('success', data.mensaje, 'customAlert'); 

                                }else if(data.estado==0){                                        
                                    Flash.create('danger', data.mensaje_correo, 'customAlert'); 
                                }
                            });                                    

                        }else{
                            $scope.loader = false;
                            $scope.evaluacion = true;
                            Flash.create('danger', data.mensaje, 'customAlert'); 
                        }
                });
            }
        }
    };

    $scope.imprimirPlantilla = function(idEvaluacion){
        
        var plantilla   = 'plantillaFinal';
        var nombrePDF   = 'evaluacion_'+ $scope.formulario.EvaluacionesTrabajadore.trabajadore_id+'_'+$scope.formulario.EvaluacionesTrabajadore.anio+'.pdf';   
        var carpeta     = $scope.formulario.EvaluacionesTrabajadore.anio;
         
        parametros = {
                "nombre": nombrePDF, 
                "controlador" : 'evaluaciones_trabajadores',
                "carpeta" : carpeta,
                "html"  : angular.element("#"+plantilla).html()
            }

        var imprimirHtml = $http({
                method: 'POST',
                url: host+'servicios/pdf_basico2',
                data: $.param(parametros)
            });

        imprimirHtml.success(function(data, status, headers, config){  
            $window.open(data);
        });
    };
});

app.controller('evaluacionesGraficos', function ($scope, $q, $filter, Flash, evaluacionesService, uiGridConstants, servicios){

    $scope.mostrarSeccion = function(eleccion){
        angular.element("#secciones").find("li").removeClass("active");
        angular.element(".nav").find("#nav"+eleccion).addClass("active");
        $scope.seccionCumplimiento = false;
        $scope.seccionDistribucion = false;
        $scope.seccionDistribucionDesempeno = false;
        $scope.seccionDistribucionCompetencias = false;
        $scope.seccionComparativo = false;
        $scope.seccionComparativoGerencias = false;
        $scope.seccionDistribucionNivel = false;
        $scope.seccionDistNivelCompetencias = false;
        $scope.seccionDistNivelFamlia= false;

        switch(eleccion){
            case 1 : $scope.seccionCumplimiento = true;
            break;
            case 2 : $scope.seccionDistribucion = true;
            break;
            case 3 : $scope.seccionDistribucionDesempeno = true;
            break;
            case 4 : $scope.seccionDistribucionCompetencias = true;
            break;
            case 5 : $scope.seccionComparativo = true;
            break;
            case 6 : $scope.seccionComparativoGerencias = true;
            break;
            case 7 : $scope.seccionDistribucionNivel = true;
            break;
            case 8 : $scope.seccionDistNivelCompetencias = true;
            break;
            case 9 : $scope.seccionDistNivelFamlia = true;
            break;
        }        
    };

    $scope.buscarDatos = function (anio){
        $scope.list = {anioEvaluacion : 0};
        $scope.$watch('list.anioEvaluacion', function(data) { 
            $scope.search = undefined;
            $scope.ShowContenido = false;
            $scope.showFecha = false;
            $scope.loader = true;
            $scope.cargador = loader;   
            evaluacionesService.dataGraficoEvaluaciones($scope.list).success(function (data){  
                console.log(data);

                if(data.estado == 1){
                    gfcCumplimiento = data.cumplimientoSeries;
                    gfcDistribucion = data.famCargoSeries;
                    gfcDistribucionDesempeno = data.sitDesempenoSeries;
                    gfcDistribucionCompetencias = data.sitCompetenciasSeries;
                    gfcComparativo = data.barraComparativo;
                    gfcComparativoGerencias = data.barraComparativoGerencias;
                    gfcDistribucionNivel = data.distribucion;
                    gfcDistNivelCompetencias = data.distribucionCompetencias;
                    gfcDistNivelFamilia = data.compXNivel;

                    $scope.evaluacionesAnios = data.listadoAnios;
                    $scope.loader = false;
                    $scope.ShowContenido = true;
                    $scope.showFecha = true;
                    $scope.seccionCumplimiento = true;
                    $scope.mostrarSeccion(1);
                   
                    series1 = [];
                    angular.forEach(gfcCumplimiento.series, function(cumplimiento){
                        series1.push({
                            name: cumplimiento.nombre,
                            y: cumplimiento.valor
                        });
                    });
                    $scope.tabla1 = gfcCumplimiento.puntajeGlobal; 
                    $scope.chart1 = $scope.graficoTorta("CUMPLIMIENTO GLOBAL GESTIÓN DE DESEMPEÑO","Cumplimiento Global",series1);
                    $scope.chart2 = $scope.graficoTorta("DISTRIBUCIÓN SEGÚN FAMILIA DE CARGOS","Distribución Familia Cargos",gfcDistribucion.data);
                    
                    $scope.tabla3 = gfcDistribucionDesempeno.situacion_desempeno;
                    $scope.chart3 = $scope.graficoTorta("DISTRIBUCIÓN POR SITUACIÓN DE DESEMPEÑO","Distribución Desempeño",gfcDistribucionDesempeno.data);
                    
                    $scope.tabla4 = gfcDistribucionCompetencias.situacion_competencias;
                    $scope.chart4 = $scope.graficoTorta("DISTRIBUCIÓN CONSIDERANDO SÓLO VARIABLE COMPETENCIAS","Distribución Competencias",gfcDistribucionCompetencias.data);

                    $scope.chart5 = $scope.graficoBarra("DISTRIBUCIÓN POR SITUACIÓN DE DESEMPEÑO","COMPARATIVO DESEMPEÑO INTEGRAL CDF vs VARIABLE COMPETENCIAS", "SITUACIÓN DESEMPEÑO", "PORCENTAJE DOTACIÓN", gfcComparativo);

                    $scope.tablaBonos = gfcComparativoGerencias.tablaValores;
                    $scope.chart6 = $scope.graficoBarra("COMPORTAMIENTO DESEMPEÑO POR GERENCIAS","", "", "", gfcComparativoGerencias);

                    plotLines1 = [];
                    colores = ["white","red","yellow","green","blue","brown","lime"];
                    var i = 0;            
                    angular.forEach(gfcDistribucionNivel.nivelSituacion, function(valorNivel, key){    
                        plotLines1.push({
                            color: colores[i],
                            dashStyle: 'line',
                            width: 3,
                            value: (key==0)? gfcDistribucionNivel.min : key,
                            label: {
                                align: 'right',
                                x: -10,
                                text: angular.uppercase(valorNivel),
                                style: {
                                    color: 'rgb(119, 152, 191)'
                                }
                            },
                            zIndex: 2
                        });
                        i++;
                    });                
                    nombres = [];
                    grupos = [];
                    nivelesR = [];   
                    $scope.tablaDatos7 = {nivelesR,nombres,grupos};
                    angular.forEach(gfcDistribucionNivel.nivelFamilia, function (familia, key){                
                        angular.forEach(familia.categories, function (niv, key2){
                            $scope.tablaDatos7.nivelesR.push(niv);
                        });
                        nombres.push(familia.name);
                        grupos.push(familia.categories.length);
                    });           
                    gfcDistribucionNivel.plotLines = plotLines1;
                    $scope.chart7 = $scope.graficoDistribucion("DISTRIBUCIÓN DESEMPEÑO SEGÚN NR","","NIVEL RESPONSABILIDAD","PUNTAJE", gfcDistribucionNivel);

                    gfcDistNivelCompetencias.plotLines = plotLines1;
                    $scope.chart8 = $scope.graficoDistribucion("DISTRIBUCIÓN DESEMPEÑO SEGÚN NR","CONSIDERANDO SÓLO VARIABLE COMPETENCIAS","NIVEL RESPONSABILIDAD","PUNTAJE COMPETENCIAS", gfcDistNivelCompetencias);

                    plotLines2 = [];
                    colores = ["rgb(85, 142, 213)","rgb(192, 80, 77)","brown","lime"];
                    var i = 0;
                    angular.forEach(gfcDistNivelFamilia.plotLines, function(prom, key){                  
                        plotLines2.push({
                            color: colores[i],
                            dashStyle: 'line',
                            width: 3,
                            value: prom,
                            label: {
                                align: 'right',
                                x: -10,
                                text: prom,
                                style: {
                                    color: 'rgb(119, 152, 191)'
                                }
                            },
                            zIndex: 2
                        });
                        i++;
                    });
                    gfcDistNivelFamilia.plotLines = plotLines2;
                    $scope.tablaDatos9 = gfcDistNivelFamilia.series;
                    situacion = gfcDistNivelFamilia.series[0].data;
                    competencia = gfcDistNivelFamilia.series[1].data;
                    participantes = gfcDistNivelFamilia.cantidades;
                    $scope.tablaDatos9 = {situacion,competencia,participantes};
                    $scope.chart9 = $scope.graficoLinea("DISTRIBUCIÓN DESEMPEÑO SEGÚN NR","Situación de Desempeño alcanzada según NR/Familia de Cargos","NIVEL RESPONSABILIDAD","PUNTAJE PROMEDIO", gfcDistNivelFamilia);

                }else{
                    Flash.create('danger', data.mensaje, 'customAlert');
                    $scope.ShowContenido = false;                    
                }

            });
        });
    };

    $scope.graficoTorta = function(titulo, subtitulo, data){
        return objGrafTorta = {
            options : {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    reflow : true,
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: titulo
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.1f} %</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                                fontSize : "12px"
                            }
                        }
                    }
                },
            },
            series: [{   
                name : subtitulo,
                type :'pie',
                data : data
            }]
        };
    };

    $scope.graficoBarra = function(titulo, subtitulo, ejex, ejey, data){
        return objGrafTorta = {
            options : {
                chart: {
                    renderTo: 'container',
                    type: 'column',
                    options3d: {
                        enabled: true,
                        alpha: 15,
                        beta: 15,
                        depth: 50,
                        viewDistance: 25
                    }
                },
                title: {
                    text: titulo
                },
                subtitle: {
                    text: subtitulo
                },
                xAxis: {
                    categories: data.xAxis,
                    title: {
                        text: ejex
                    }
                },
                yAxis: {
                    min: data.yMin,
                    title: {
                        text: ejey
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.1f} %</b>'
                },
                plotOptions: {
                    column: {
                        depth: 10,
                        pointFormat: '{series.name}: <b>{point.y:.1f} %</b>',                       
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.y:.1f} %</b>'
                        }
                    }
                },
            },
            series: data.series
        };
    };

    $scope.graficoDistribucion = function(titulo, subtitulo, ejex, ejey, data){
        return objGrafTorta = {
            options : {
                chart: {
                    type: 'scatter'                    
                },
                title: {
                    text: titulo
                },
                subtitle: {
                    text: subtitulo
                },
                xAxis: {
                    title: {
                        enabled: true,
                        text: ejex
                    },
                    startOnTick: false,
                    endOnTick: false,
                    showLastLabel: true
                },
                yAxis: {
                    title: {
                        text: ejey
                    },
                    plotLines: data.plotLines
                },   
                legend: {
                    enabled:false
                },            
                plotOptions: {
                    scatter: {
                        marker: {
                            radius: 5,
                            states: {
                                hover: {
                                    enabled: true,
                                    lineColor: 'rgb(100,100,100)'
                                }
                            }
                        },
                        states: {
                            hover: {
                                marker: {
                                    enabled: false
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: '',
                            pointFormat: '<b>{series.name}:</b> {point.y}'
                        }
                    }
                }
            },
            series: data.series
        };
    }; 

    $scope.graficoLinea = function(titulo, subtitulo, ejex, ejey, data){
        return objGrafTorta = {
            options : {
                title: {
                    text: titulo,
                    x: -20 //center
                },
                subtitle: {
                    text: subtitulo,
                    x: -20
                },
                xAxis: {                    
                    categories: data.xAxis,
                    title: {
                        text: ejex
                    }
                },
                yAxis: {                    
                    title: {
                        text: ejey
                    },                
                    plotLines: data.plotLines
                },
                tooltip: {
                    headerFormat: '<b>NR:</b> {point.x}<br>',
                    pointFormat: '<b>'+ejey+':</b> {point.y}'
                },
                legend: {
                    enabled:false
                }
            },
            series: data.series
        }        
    };

});

