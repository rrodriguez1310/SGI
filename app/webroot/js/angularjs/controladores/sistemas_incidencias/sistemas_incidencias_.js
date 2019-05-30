app.controller('sistemasIncidenciasAdd', function($scope, $window, $q, $filter, Flash, sistemasIncidenciaService, trabajadoresService, areasService, gerenciasService, listaUsers, usersFactory, sistemasResponsablesIncidenciasService, factoria) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.ShowContenido = false;
    $scope.formulario = {
        SistemasIncidencia: {}
    };
    $scope.tiempo = {
        dias: 0,
        horas: 0,
        minutos: 0
    };
    angular.element(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart: 1,
        //startDate: 'today'
    });

    fechaActual = new Date();
    $scope.fecha_inicio = ("0" + fechaActual.getDate()).slice(-2) + "/" + ("0" + (fechaActual.getMonth() + 1)).slice(-2) + "/" + fechaActual.getFullYear();
    $scope.termino_fecha = ("0" + fechaActual.getDate()).slice(-2) + "/" + ("0" + (fechaActual.getMonth() + 1)).slice(-2) + "/" + fechaActual.getFullYear();
    angular.element(".clockpicker").clockpicker({
        placement: 'bottom',
        align: 'top',
        autoclose: true
    });
    promesas = [];
    promesas.push(areasService.areasList());
    promesas.push(gerenciasService.gerenciasList());
    promesas.push(listaUsers.listaUsers());
    promesas.push(sistemasResponsablesIncidenciasService.sistemasResponsablesList());
    $scope.usuarioId = function(usuarioId) {
        $q.all(promesas).then(function(data) {
            $scope.ShowContenido = true;
            $scope.loader = false;
            $scope.areasList = data[0].data.data;
            $scope.gerenciasList = data[1].data.data;

            usuariosPorId = usersFactory.usersPorId(data[2].data);

            responsables = [];
            angular.forEach(data[3].data, function(responsable) {
                if (responsable.gerencia == 13) {
                    //console.log(responsable);
                    responsables.push({
                        id: responsable.id,
                        gerencia_id: responsable.gerencia,
                        nombre: $filter("capitalize")(usuariosPorId[responsable.user_id].UsuarioNombre)
                    });
                }
            });

            $scope.responsablesList = $filter("orderBy")(responsables, "nombre");
            responsablesPorUsuarioId = factoria.arregloPorPropiedad(data[3].data, "user_id");
            $scope.test = responsablesPorUsuarioId[usuarioId].user_id;

            if (responsablesPorUsuarioId[usuarioId].admin == 0) {
                $scope.responsableReadOnly = true;
                $scope.formulario.SistemasIncidencia.sistemas_responsables_incidencia_id = responsablesPorUsuarioId[usuarioId].id;
                angular.element('#responsableId').select2('data', { id: responsablesPorUsuarioId[usuarioId].id, text: $scope.usuariosPorId[responsablesPorUsuarioId[usuarioId].user_id].UsuarioNombre });
            }
        });
    }
    $scope.cambiaResponsable = function() {

        $scope.gerencia = [];
        for (var i in responsablesPorUsuarioId) {
            if ($scope.formulario.SistemasIncidencia.sistemas_responsables_incidencia_id == responsablesPorUsuarioId[i].id) {
                $scope.gerencia.push({
                    id: responsablesPorUsuarioId[i].gerencia,
                    nombre: responsablesPorUsuarioId[i].gerenciaNombre
                });
            }
        }
        $scope.formulario.SistemasIncidencia.gerencia = $scope.gerencia[0].nombre;
    }
    $scope.cambiaGerencia = function() {
        angular.element('#areas').select2('data', null);
        $scope.formulario.SistemasIncidencia.area_id = undefined;
        $scope.trabajadoresList = [];
        angular.element('#trabajador').select2('data', null);
        $scope.formulario.SistemasIncidencia.trabajadore_id = undefined;
    }

    $scope.registrarIncidencia = function() {
        $scope.registrando = true;
        fechaInicio = $scope.fecha_inicio.split("/");
        fechaInicioObj = new Date(fechaInicio[2], parseInt(fechaInicio[1]) - 1, parseInt(fechaInicio[0]));
        $scope.formulario.SistemasIncidencia.fecha_inicio = fechaInicio[2] + "-" + fechaInicio[1] + "-" + fechaInicio[0];
        $scope.formulario.SistemasIncidencia.estado = 1;
        sistemasIncidenciaService.registrarSistemasIncidencia($scope.formulario).success(function(data) {
            if (data.estado == 1) {
                $window.location = host + "sistemas_incidencias";
            } else {
                Flash.create('danger', data.mensaje, 'customAlert');
                $scope.registrando = false;
            }
        });
    }

    $scope.buscaTrabajadoresArea = function() {
        $scope.trabajadoresList = [];
        $scope.formulario.SistemasIncidencia.trabajadore_id = undefined;
        angular.element('#trabajador').select2('data', null);
        if (angular.isDefined($scope.formulario.SistemasIncidencia.area_id)) {
            trabajadoresService.trabajadoresPorArea($scope.formulario.SistemasIncidencia.area_id).success(function(trabajadores) {
                angular.forEach(trabajadores, function(trabajador, id) {
                    $scope.trabajadoresList.push({
                        id: id,
                        nombre: trabajador
                    });
                });
            });
        }
    }

    $scope.$watch("[fecha_inicio, hora_inicio, termino_fecha, termino_hora]", function(fechas, fechasAntiguas) {
        if (angular.isDefined(fechas[0]) && angular.isDefined(fechas[1]) && angular.isDefined(fechas[2]) && angular.isDefined(fechas[3])) {
            fechaInicio = $scope.fecha_inicio.split("/");
            horaInicio = $scope.hora_inicio.split(":");
            fechaInicioObj = new Date(fechaInicio[2], parseInt(fechaInicio[1]) - 1, parseInt(fechaInicio[0]), parseInt(horaInicio[0]), parseInt(horaInicio[1]));
            if (fechaInicioObj.getTime()) { //> fechaTerminoObj.getTime()
                Flash.create('danger', "La fecha y hora de termino debe ser mayor a la de inicio", 'customAlert');
                angular.forEach(fechasAntiguas, function(fecha, key) {
                    if (fecha != fechas[key]) {
                        console.log(key);
                        switch (key) {
                            case 0:
                                $scope.fecha_inicio = undefined;
                                break;
                            case 1:
                                $scope.hora_inicio = undefined;
                                break;
                                /* case 2:
                                     $scope.termino_fecha = undefined;
                                     break;
                                 case 3:
                                     $scope.termino_hora = undefined;
                                     break;*/
                        }
                    }
                });
                $scope.tiempo = {
                    dias: 0,
                    horas: 0,
                    minutos: 0
                };
            } else {
                $scope.tiempo = factoria.calculoDifMilisecADiasMinSec(fechaTerminoObj.getTime(), fechaInicioObj.getTime());
            }
        }
    });
});

app.controller('sistemasIncidenciasIndex', function($scope, $q, $filter, sistemasIncidenciaService, sistemasResponsablesIncidenciasService, listaUsers, areasService, factoria, trabajadoresService, uiGridConstants) {
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
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };
    $scope.gridOptions.columnDefs = [
        { name: 'titulo', displayName: 'Tarea / Problema', cellFilter: "uppercase", width: "20%" },
        {
            name: 'fecha_inicio',
            displayName: 'Fecha Inicio',
            field: 'fecha_inicio',
            sort: {
                direction: uiGridConstants.ASC,
                priority: 1
            }
        },
        { name: 'fecha_cierre', displayName: 'Fecha Cierre' },
        { name: 'area', displayName: 'Área' },
        { name: 'user', displayName: 'Creador' },
        { name: 'responsable', displayName: 'Responsable' },
        {
            name: 'estado',
            displayName: 'Estado',
            cellClass: function(row, rowRenderIndex, col, colRenderIndex) {
                switch (rowRenderIndex.entity.estado) {
                    case "Cerrado":
                        return "angular_aprobado_g";
                        break;
                    case "En Proceso":
                        return "angular_pendiente_g";
                        break;
                    case "Eliminado":
                        return "angular_rojo";
                        break;
                }
            },
            sort: {
                direction: uiGridConstants.ASC,
                priority: 0,
            },
            sortingAlgorithm: function(a, b) {
                var nulls = $scope.gridApi.core.sortHandleNulls(a, b);
                if (nulls !== null) {
                    return nulls;
                } else {
                    switch (a) {
                        case "Cerrado":
                            switch (b) {
                                case "Cerrado":
                                    return 0;
                                    break;
                                default:
                                    return 1;
                                    break;
                            }
                            break;
                        case "En Proceso":
                            switch (b) {
                                case "En Proceso":
                                    return 0;
                                    break;
                                default:
                                    return -1;
                                    break;

                            }
                            break;
                        case "Eliminado":
                            switch (b) {
                                case "Eliminado":
                                    return 0
                                    break;
                                default:
                                    return 1;
                                    break;
                            }
                            break;
                    }
                }
            }
        }
    ];


    $scope.estados = ["Eliminado", "En Proceso", "Cerrado"];
    $scope.usuarioId = function(usuarioId) {
        $scope.usuario = usuarioId;
        $scope.loader = true;
        $scope.ShowContenido = false;
        promesas = [];
        promesas.push(listaUsers.listaUsers());
        promesas.push(sistemasResponsablesIncidenciasService.sistemasResponsablesList());
        promesas.push(areasService.areasList());
        $q.all(promesas).then(function(data) {
            responsablesPorUsuarioId = factoria.arregloPorPropiedad(data[1].data, "user_id");
            responsablesPorId = factoria.arregloPorPropiedad(data[1].data, "id");
            usuariosPorId = factoria.arregloPorPropiedad(data[0].data, "UsuarioId");
            areasPorId = factoria.arregloPorPropiedad(data[2].data.data, "id")
            $scope.fecha_actual = "2017-05-16";
            trabajadoresService.trabajador(usuariosPorId[usuarioId].trabajadore_id).success(function(trabajador) {
                if (angular.isDefined(responsablesPorUsuarioId[usuarioId])) {
                    incidenciasPromesa = sistemasIncidenciaService.sistemasIncidencias();
                } else {
                    incidenciasPromesa = sistemasIncidenciaService.sistemasIncidenciasPorArea(trabajador.Cargo.Area.id);
                }
                incidenciasPromesa.success(function(incidencias) {
                    $scope.date = new Date();
                    $scope.ShowContenido = true;
                    $scope.loader = false;
                    $scope.incidencias = [];
                    $scope.incidencias3 = [];
                    if (data.length = !0) {
                        angular.forEach(incidencias, function(incidencia) {
                            if (incidencia.fecha_actual == incidencia.fecha_inicio) {
                                $scope.incidencias.push({
                                    id: incidencia.id,
                                    fecha_actual: incidencia.fecha_inicio,
                                    fecha_inicio: incidencia.fecha_inicio,
                                    hora_inicio: incidencia.hora_inicio,
                                    fecha_cierre: incidencia.fecha_cierre,
                                    user: angular.uppercase(usuariosPorId[incidencia.user_id].UsuarioNombre),
                                    user_id: incidencia.user_id,
                                    area: angular.uppercase(areasPorId[incidencia.area_id].nombre),
                                    responsable: angular.uppercase(usuariosPorId[responsablesPorId[incidencia.sistemas_responsables_incidencia_id].user_id].UsuarioNombre),
                                    responsableId: incidencia.sistemas_responsables_incidencia_id,
                                    estado: $scope.estados[incidencia.estado],
                                    estadoId: incidencia.estado,
                                    titulo: incidencia.titulo
                                });
                            }
                            if (incidencia.fecha_actual) {
                                $scope.incidencias3.push({
                                    id: incidencia.id,
                                    fecha_inicio: incidencia.fecha_inicio,
                                    hora_inicio: incidencia.hora_inicio,
                                    fecha_cierre: incidencia.fecha_cierre,
                                    user: angular.uppercase(usuariosPorId[incidencia.user_id].UsuarioNombre),
                                    user_id: incidencia.user_id,
                                    area: angular.uppercase(areasPorId[incidencia.area_id].nombre),
                                    responsable: angular.uppercase(usuariosPorId[responsablesPorId[incidencia.sistemas_responsables_incidencia_id].user_id].UsuarioNombre),
                                    responsableId: incidencia.sistemas_responsables_incidencia_id,
                                    estado: $scope.estados[incidencia.estado],
                                    estadoId: incidencia.estado,
                                    titulo: incidencia.titulo
                                });
                            }
                        });
                    }

                    $scope.gridOptions.data = $scope.incidencias;
                    $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
                        $scope.id = row.entity.id;
                        if (row.isSelected == true) {
                            $scope.btnsistemas_incidenciasedit = true;
                            $scope.btnsistemas_incidenciasdelete = true;
                            $scope.btnsistemas_incidenciascerrar_incidencia = true;
                            $scope.btnsistemas_incidenciasobservaciones_incidencia = true;
                            $scope.boton = true;
                            if (responsablesPorId[row.entity.responsableId].user_id == usuarioId && row.entity.estadoId == 1) {
                                $scope.btnsistemas_incidenciascerrar_incidencia = false;
                                $scope.btnsistemas_incidenciasobservaciones_incidencia = false;
                            }
                            if (row.entity.user_id == usuarioId && row.entity.estadoId == 1) {
                                $scope.btnsistemas_incidenciasedit = false;
                                $scope.btnsistemas_incidenciasdelete = false;
                            }
                            if (angular.isDefined(responsablesPorUsuarioId[usuarioId])) {
                                if (responsablesPorUsuarioId[usuarioId].admin == 1) {
                                    $scope.btnsistemas_incidenciascerrar_incidencia = false;
                                    $scope.btnsistemas_incidenciasobservaciones_incidencia = false;
                                    $scope.btnsistemas_incidenciasedit = false;
                                    $scope.btnsistemas_incidenciasdelete = false;
                                }
                            }
                        } else {
                            $scope.boton = false;
                            $scope.id = undefined;
                        }
                    });
                });
            })
        });
    };

    setInterval(function() { $scope.usuarioId($scope.usuario) }, 99999);
    $scope.confirmacion = function() {
        window.location.href = host + "sistemas_incidencias/delete/" + $scope.id
    };

    $scope.refreshData = function(termObj) {
        $scope.gridOptions.data = $scope.incidencias;
        while (termObj) {
            var oSearchArray = termObj.split(' ');
            $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
            oSearchArray.shift();
            termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
        }
    };
    $scope.filterGender = function() {

        $scope.gridApi.grid.columns[2].filter.term = $scope.term;
        $scope.incidencias2 = [];
        $scope.gridOptions.data = $scope.incidencias3;

        for (var i in $scope.gridOptions.data) {
            if ($scope.gridOptions.data[i].fecha_inicio == $scope.term) {
                $scope.incidencias2.push({
                    id: $scope.gridOptions.data[i].id,
                    titulo: $scope.gridOptions.data[i].titulo,
                    fecha_inicio: $scope.gridOptions.data[i].fecha_inicio,
                    fecha_cierre: $scope.gridOptions.data[i].fecha_cierre,
                    user: angular.uppercase(usuariosPorId[$scope.gridOptions.data[i].user_id].UsuarioNombre),
                    user_id: $scope.gridOptions.data[i].user_id,
                    area: $scope.gridOptions.data[i].area,
                    responsable: $scope.gridOptions.data[i].responsable,
                    responsableId: $scope.gridOptions.data[i].responsableId,
                    estado: $scope.gridOptions.data[i].estado
                });

            } else {}
        }
        $scope.gridOptions.data = $scope.incidencias2;
        //$scope.gridApi.grid.queueGridRefresh();
    };
});

app.controller('sistemasIncidenciaReportes', function($scope, $filter, $timeout, sistemasIncidenciaService, factoria) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.ShowContenido = false;
    $scope.tamanioModal = "modal-lg";
    $scope.modeloArea = {};

    var fecha = new Date();
    var anioActual = fecha.getFullYear();
    $scope.varAnios = anioActual - 2016;
    $scope.ingresosCierres = [];
    var count = 0;
    for (i = 0; i < $scope.varAnios; i++) {
        $scope.var = (i);
        $scope.ingresosCierres.push({ id: (2017 + $scope.var).toString(), nombre: (2017 + $scope.var).toString() });
    }

    $scope.anioBusqueda = $scope.ingresosCierres[0].id;
    $scope.anioInicial = function(anio) {
        $scope.anio = anio;
        sistemasIncidenciaService.dataReporte(anio).success(function(data) {
            $scope.tabla1 = data.reporte_ingresos_cierres.global;
            gfcCumplimiento = data.reporte_ingresos_cierres.series;
            series1 = [];
            angular.forEach(gfcCumplimiento, function(cumplimiento) {
                series1.push({
                    name: cumplimiento.nombre,
                    y: cumplimiento.valor
                });
            });
            $scope.chart1 = $scope.graficoTorta("ESTADO INCIDENCIAS", "Estado Incidencias", series1);
            $scope.cambioAnio = function(anioBusqueda) {
                var dataCount = data.reporte_ingresos_cierres.sistemasIncidencia;
                $scope.totalIssues = dataCount.length;
                $scope.incidencias = [];
                $scope.incidencias2 = [];
                solucionadas = [];
                revision = [];
                torakPorAño = [];
                var count = 0;
                var count2 = 0;
                for (var i in dataCount) {
                    if (dataCount[i].fecha_inicio == anioBusqueda.id) {
                        torakPorAño.push({ id: i });
                    }
                }
                for (var i in dataCount) {
                    if (dataCount[i].fecha_inicio === anioBusqueda.id && dataCount[i].estado === 2) {
                        solucionadas.push({ id: i });
                    }
                    if (dataCount[i].fecha_inicio === anioBusqueda.id && dataCount[i].estado === 1) {
                        revision.push({ id: i });
                    }
                }
                $scope.totalSolucionadas = (solucionadas.length / torakPorAño.length) * 100;
                $scope.totalRevision = (revision.length / torakPorAño.length) * 100;

                $scope.reportePorAños = [{
                    "nombre": "Incidencias Solucionadas",
                    "valor": $scope.totalSolucionadas
                }, {
                    "nombre": "Incidencias en Revisión",
                    "valor": $scope.totalRevision
                }];
                $scope.reporteGlobal = {
                    "resueltas": solucionadas.length,
                    "revision": revision.length,
                    "total": torakPorAño.length
                };
                $scope.tabla1 = $scope.reporteGlobal;
                series1 = [];
                angular.forEach($scope.reportePorAños, function(cumplimiento) {
                    series1.push({
                        name: cumplimiento.nombre,
                        y: cumplimiento.valor
                    });
                });
                $scope.chart1 = $scope.graficoTorta("ESTADO INCIDENCIAS " + anioBusqueda.id, "Estado Incidencias" + anioBusqueda, series1);
            };
        });
    };

    $scope.graficoTorta = function(titulo, subtitulo, data) {
        return objGrafTorta = {
            options: {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    reflow: true,
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
                                fontSize: "12px"
                            }
                        }
                    }
                },
            },
            series: [{
                name: subtitulo,
                type: 'pie',
                data: data
            }]
        };
    };

});
app.controller('sistemasIncidenciasObservacionesIncidencia', function($scope, $window, Flash, sistemasIncidenciaService) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.ShowContenido = false;
    $scope.incidenciaid = function(incidenciaId) {
        $scope.ShowContenido = true;
        $scope.loader = false;
        $scope.formulario = {
            SistemasIncidenciasOb: {
                sistemas_incidencia_id: incidenciaId,
                estado: 1,
                tipo: 1
            }
        };
    }
    $scope.registrarObservacion = function() {
        sistemasIncidenciaService.registroObservacionIncidencia($scope.formulario).success(function(data) {
            if (data.estado == 1) {
                $window.location = host + "sistemas_incidencias";
            } else {
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    }
});
app.controller('sistemasIncidenciasCerrarIncidencia', function($scope, $window, Flash, sistemasIncidenciaService) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.ShowContenido = false;
    angular.element(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart: 1,
        //startDate: 'today'
    });
    angular.element(".clockpicker").clockpicker({
        placement: 'bottom',
        align: 'top',
        autoclose: true
    });
    $scope.incidenciaid = function(incidenciaId) {
        sistemasIncidenciaService.sistemasIncidencia(incidenciaId).success(function(incidencia) {
            fechaActual = new Date();

            horaActual = fechaActual;
            datetext = fechaActual.toTimeString();
            datetext = datetext.split(' ')[0];

            $scope.hora_cierre = datetext;
            $scope.cierre_fecha = ("0" + fechaActual.getDate()).slice(-2) + "/" + ("0" + (fechaActual.getMonth() + 1)).slice(-2) + "/" + fechaActual.getFullYear();
            if (incidencia.SistemasIncidencia.fecha_cierre) {
                fechaCierreArray = (incidencia["SistemasIncidencia"]["fecha_cierre"].substring(0, 10)).split("-");
                $scope.cierre_fecha = fechaCierreArray[2] + "/" + fechaCierreArray[1] + "/" + fechaCierreArray[0];
                horaCierreArray = (incidencia["SistemasIncidencia"]["fecha_cierre"].substring(11)).split(":");
                $scope.hora_cierre = horaCierreArray[0] + ":" + horaCierreArray[1] + ":" + horaCierreArray[2];
            }

            $scope.ShowContenido = true;
            $scope.loader = false;
            $scope.formulario = {
                SistemasIncidencia: {
                    id: incidenciaId,
                    estado: 2
                }
            };
            $scope.formulario.SistemasIncidencia.observacion_termino = incidencia.SistemasIncidencia.observacion_termino;
        });
    }

    $scope.cerraIncidencia = function() {
        fechaCiere = $scope.cierre_fecha.split("/");

        $scope.formulario.SistemasIncidencia.fecha_cierre = fechaCiere[2] + "-" + fechaCiere[1] + "-" + fechaCiere[0] + " " + $scope.hora_cierre;
        //console.log('fechaCiere', fechaCiere);
        //fechaCiere = $scope.cierre_fecha.split("/");
        //$scope.formulario.SistemasBitacora.fecha_cierre = fechaCiere[2]+"-"+fechaCiere[1]+"-"+fechaCiere[0]+" "+$scope.cierre_hora+":00";
        sistemasIncidenciaService.registroCierreIncidencia($scope.formulario).success(function(data) {
            // return console.log($scope.formulario);
            if (data.estado == 1) {
                $window.location = host + "sistemas_incidencias";
            } else {
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    }
});

app.controller('sistemasIncidenciasEdit', function($scope, $window, $q, $filter, Flash, trabajadoresService, sistemasIncidenciaService, areasService, gerenciasService, listaUsers, usersFactory, sistemasResponsablesIncidenciasService, factoria) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.ShowContenido = false;
    $scope.formulario = {
        SistemasIncidencia: {}
    };
    $scope.tiempo = {
        dias: 0,
        horas: 0,
        minutos: 0
    };
    angular.element(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart: 1,
        startDate: 'today'
    });
    angular.element(".clockpicker").clockpicker({
        placement: 'bottom',
        align: 'top',
        autoclose: true
    });

    promesas = [];
    promesas.push(areasService.areasList());
    promesas.push(gerenciasService.gerenciasList());
    promesas.push(listaUsers.listaUsers());
    promesas.push(sistemasResponsablesIncidenciasService.sistemasResponsablesList());
    $scope.parametros = function(usuarioId, requerimientoId) {
        promesas.push(sistemasIncidenciaService.sistemasIncidencia(requerimientoId));
        $q.all(promesas).then(function(data) {
            $scope.ShowContenido = true;
            $scope.loader = false;
            $scope.areasList = data[0].data.data;
            $scope.gerenciasList = data[1].data.data;
            usuariosPorId = usersFactory.usersPorId(data[2].data);
            responsables = [];
            angular.forEach(data[3].data, function(responsable) {
                if (responsable.gerencia == 13) {
                    //console.log(responsable);
                    responsables.push({
                        id: responsable.id,
                        gerencia_id: responsable.gerencia,
                        nombre: $filter("capitalize")(usuariosPorId[responsable.user_id].UsuarioNombre)
                    });
                }
            });
            $scope.responsablesList = $filter("orderBy")(responsables, "nombre");
            responsablesPorUsuarioId = factoria.arregloPorPropiedad(data[3].data, "user_id");
            areasPorId = factoria.arregloPorPropiedad(data[0].data.data, "id");
            gerenciasPorId = factoria.arregloPorPropiedad(data[1].data.data, "id");
            dataLimpia = factoria.deleteCreatedModifiedDosNiveles(data[4].data);
            $scope.gerencia = [];
            for (var i in responsablesPorUsuarioId) {
                if (dataLimpia.SistemasIncidencia.sistemas_responsables_incidencia_id == responsablesPorUsuarioId[i].id) {
                    $scope.gerencia.push({
                        id: responsablesPorUsuarioId[i].gerencia,
                        nombre: responsablesPorUsuarioId[i].gerenciaNombre
                    });

                }
            }
            angular.element('#gerencia').select2('data', { id: $scope.gerencia[0].id, text: angular.uppercase(gerenciasPorId[$scope.gerencia[0].id].nombre) });
            angular.element('#areas').select2('data', { id: dataLimpia.SistemasIncidencia.area_id, text: angular.uppercase(areasPorId[dataLimpia.SistemasIncidencia.area_id].nombre) });
            angular.element('#responsableId').select2('data', { id: dataLimpia.SistemasIncidencia.sistemas_responsables_incidencia_id, text: $filter("capitalize")(usuariosPorId[dataLimpia.SistemasResponsablesIncidencia.user_id].UsuarioNombre) });
            $scope.fecha_inicio = dataLimpia.SistemasIncidencia.fecha_inicio;
            $scope.hora_inicio = dataLimpia.SistemasIncidencia.hora_inicio;
            if (responsablesPorUsuarioId[usuarioId].admin == 0) {
                $scope.responsableReadOnly = true;
            }
            nombre = undefined;
            if (angular.isString(dataLimpia.Trabajadore.nombre)) {
                nombre = angular.uppercase(dataLimpia.Trabajadore.nombre + " " + dataLimpia.Trabajadore.apellido_paterno);
            }
            delete data[4].data.Area;
            delete data[4].data.SistemasResponsablesIncidencia;
            delete data[4].data.User;
            delete data[4].data.Trabajadore;
            delete data[4].data.SistemasIncidenciasOb;
            $scope.formulario = dataLimpia;
            $scope.buscaTrabajadoresArea(false);
            if (angular.isDefined(nombre)) {
                angular.element('#trabajador').select2('data', { id: $scope.formulario.trabajadore_id, text: nombre });
            }

        });
    }
    $scope.cambiaGerencia = function() {
        angular.element('#areas').select2('data', null);
        $scope.formulario.SistemasIncidencia.area_id = undefined;
        $scope.trabajadoresList = [];
        angular.element('#trabajador').select2('data', null);
        $scope.formulario.SistemasIncidencia.trabajadore_id = undefined;
    }
    $scope.cambiaResponsable = function() {
        $scope.gerencia = [];
        for (var i in responsablesPorUsuarioId) {
            if (dataLimpia.SistemasIncidencia.sistemas_responsables_incidencia_id == responsablesPorUsuarioId[i].id) {
                $scope.gerencia.push({
                    id: responsablesPorUsuarioId[i].gerencia,
                    nombre: responsablesPorUsuarioId[i].gerenciaNombre
                });
            }
        }
        gerencia2 = $scope.gerencia[0].nombre;
        angular.element('#gerencia').select2('data', { id: $scope.gerencia[0].id, text: $scope.gerencia[0].nombre });
    }

    $scope.registrarIncidencia = function() {
        $scope.registrando = true;
        $scope.formulario.SistemasIncidencia.estado = 1;
        $scope.formulario.SistemasIncidencia.hora_inicio = $scope.hora_inicio;
        sistemasIncidenciaService.registrarSistemasIncidencia($scope.formulario).success(function(data) {
            if (data.estado == 1) {
                $window.location = host + "sistemas_incidencias";
            } else {
                Flash.create('danger', data.mensaje, 'customAlert');
                $scope.registrando = false;
            }
        });
    }
    $scope.buscaTrabajadoresArea = function(limpia) {
        $scope.trabajadoresList = [];
        if (limpia) {
            $scope.formulario.SistemasIncidencia.trabajadore_id = undefined;
        }
        angular.element('#trabajador').select2('data', null);
        if (angular.isDefined($scope.formulario.SistemasIncidencia.area_id)) {
            trabajadoresService.trabajadoresPorArea($scope.formulario.SistemasIncidencia.area_id).success(function(trabajadores) {
                angular.forEach(trabajadores, function(trabajador, id) {
                    $scope.trabajadoresList.push({
                        id: id,
                        nombre: trabajador
                    });
                });
            });
        }
    }
});