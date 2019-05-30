app.controller('InformeTransmisionesList', ['$scope', '$http', '$filter', 'informeTransmisiones', function($scope, $http, $filter, informeTransmisiones) {
    $scope.loader = true
    $scope.cargador = loader;
    $scope.gridOptions = {
        columnDefs: [
            { name: 'id', displayName: 'Id', visible: false },
            { name: 'programas.informes.programa', displayName: 'Programa', width: 280 },
            { name: 'programas.informes.hora_ini_evento', displayName: 'Hora Inicio', width: 110 },
            { name: 'programas.informes.hora_out_evento', displayName: 'Hora Termino', width: 110 },
            { name: 'programas.informes.lugar', displayName: 'Lugar', width: 200 },
            {
                name: 'programas.informes.evento.tipo_transmisione_id',
                displayName: 'Estado',
                width: 150,
                cellTemplate: '<div class="ui-grid-cell-contents">{{(row.entity.programas.informes.evento.tipo_transmisione_id=="1") ? "VIVO" :((row.entity.programas.informes.evento.tipo_transmisione_id=="2") ? "RADIO" :((row.entity.programas.informes.evento.tipo_transmisione_id=="3") ? "VIVO" : "VIVO") ) }}</div>',
                cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                    return (grid.getCellValue(row, col) == 'VIVO') ? 'angular_aprobado_s' : ((grid.getCellValue(row, col) == 'RADIO') ? "angular_pendiente_g" : ((grid.getCellValue(row, col) == 'VIVO') ? "angular_aprobado_g" : ""))
                }
            },
            { name: 'programas.informes.evento.tipo_transmisione_id', displayName: 'Producción', width: 120 },
            { name: 'user', displayName: 'Supervisor', width: 145 },
            { name: 'programas.informes.fecha_partido', displayName: 'Fecha Evento', width: 120, type: 'date', cellFilter: 'date:\'yyyy-MM-dd\'' },
            { name: 'satelite', displayName: 'Satelite', width: 200 },
        ],
        enableGridMenu: true,
        enableSelectAll: false,
        exporterCsvFilename: 'myFile.csv',
        exporterMenuPdf: false,
        multiSelect: false,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };
    informeTransmisiones.listaInformes().success(function(data) {
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
            if (row.isSelected == true) {
                if (row.entity.id) {
                    $scope.id = row.entity.id;
                    $scope.btnPruebasDelete = false;
                    $scope.btnPruebasEdit = false;
                    $scope.boton = true;
                }
            } else {
                $scope.boton = false;
            }
        });
        $scope.confirmacion = function() {
            window.location.href = host + "produccion_mcr_informes/delete/" + $scope.id
        };
        $scope.refreshData = function(termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    })
}]);

app.controller('TransmisionControllerAddInforme', function($scope, $filter, informeTransmisiones, $q, $window, Flash) {

    informeTransmisiones.addInformeTransmision().success(function(data) {
        $scope.dataEvento = data.mensajeArray;
        $scope.transmisionSenalesArray = data.trasmisionSenalesArray;
        $scope.receptoresArray = data.receptoresArray;
        $scope.dataProgra = data.programaArray;
        $scope.dataProductores = data.productores;
        $scope.dataSenales = data.senalesArray;
    });

    $scope.formulario = {
        evento: '',
        otros: '',
        fibra_optica: '',
        satelite2: '',
        micro_ondas: '',
        tipo: '',
        programas: ''

    };
    $scope.tipoEvento = [{ "id": "cdf_noticias", "nombre": "PROGRAMA CDF" },
        { "id": "partido", "nombre": "PARTIDO" },
        { "id": "ceremonia", "nombre": "CEREMONIA" }
    ];
    $scope.posicion2 = 'informes';
    $scope.rx_senal = [{ "id": "ok", "nombre": "Ok" },
        { "id": "deficiente", "nombre": "Deficiente" }, { "id": "sin_observaciones", "nombre": "Sin Observaciones" }
    ]
    $scope.posiciones = [{ "id": "principal_meta", "nombre": "Principal" },
        { "id": "respaldo_meta", "nombre": "Respaldo" },
        { "id": "respaldo_otro_meta", "nombre": "Otro" }
    ];
    $scope.posicion = "principal_meta";
    $scope.posicionesMochila = [{ "id": "mochila1", "nombre": "Mochila N° 1" },
        
        { "id": "mochila2", "nombre": "Mochila N° 2" },
        { "id": "mochila3", "nombre": "Mochila N° 3" },
        { "id": "mochila4", "nombre": "Mochila N° 4" },
        { "id": "movil", "nombre": "Movil" }
    ];
    $scope.lugares = [{ "id": "roger", "nombre": "Roger de Flor" },
        { "id": "chilefilms", "nombre": "Chile Films" }
    ];
    $scope.posicionMochi = "mochila1";
    $scope.selectedItem = $scope.posiciones[0];

    $scope.cambioPosicionesMochila = function(pos) {
        if (angular.isUndefined(pos)) {
            $scope.posicionMochi = "mochila1";
        } else {
            $scope.posicionMochi = pos;
        }
    };
    $scope.cambiaMedio = function() {
        if ($scope.formulario.tipo) {
            $scope.verData = $scope.formulario.tipo.id;
            if ($scope.verData == 'cdf_noticias') {
                $scope.muestraDataNoticias = true;
            } else {
                $scope.muestraDataNoticias = false;
            }
            if ($scope.verData == 'partido' || $scope.verData == 'ceremonia') {
                $scope.muestraDataPartidos = true;
            } else {
                $scope.muestraDataPartidos = false;
            }
            if ($scope.verData == null) {

            }
        } else {
            $scope.muestraDataNoticias = false;
            $scope.muestraDataPartidos = false;
        }
        if ($scope.formulario.programas) {

            if ($scope.formulario.programas[$scope.posicion2].evento == null) {
                $scope.formulario.programas[$scope.posicion2].programa = null;
                $scope.formulario.programas[$scope.posicion2].hora_ini_evento = null;
                $scope.formulario.programas[$scope.posicion2].hora_out_evento = null;
                $scope.formulario.programas[$scope.posicion2].lugar = null;
                $scope.formulario.programas[$scope.posicion2].campeonato = null;
                $scope.formulario.programas[$scope.posicion2].fecha = null;
                $scope.senales = null;
                $scope.formulario.programas[$scope.posicion2].fecha_partido = null;
            } else {

                $scope.posicionesTipoProduccion = [{ "id": "1", "nombre": "VIVO" },
                    { "id": "2", "nombre": "RADIO" },
                    { "id": "3", "nombre": "PREVIA" }
                ];
                if ($scope.verData == 'cdf_noticias') {
                    $scope.formulario.programas[$scope.posicion2].programa = $scope.formulario.programas[$scope.posicion2].evento.nombre;
                }
                if ($scope.verData == 'partido') {
                    $scope.formulario.programas[$scope.posicion2].programa = $scope.formulario.programas[$scope.posicion2].evento.equipos;
                }
                $scope.formulario.programas[$scope.posicion2].hora_ini_evento = $scope.formulario.programas[$scope.posicion2].evento.hora_transmision;
                $scope.formulario.programas[$scope.posicion2].hora_out_evento = $scope.formulario.programas[$scope.posicion2].evento.hora_termino_transmision;
                $scope.formulario.programas[$scope.posicion2].lugar = $scope.formulario.programas[$scope.posicion2].evento.estadio;
                $scope.formulario.programas[$scope.posicion2].campeonato = $scope.formulario.programas[$scope.posicion2].evento.campeonato;
                $scope.formulario.programas[$scope.posicion2].fecha_partido = $scope.formulario.programas[$scope.posicion2].evento.fecha_partido;
                $scope.formulario.programas[$scope.posicion2].fecha = $scope.formulario.programas[$scope.posicion2].evento.nombre_fecha_partido;
                $scope.formulario.programas[$scope.posicion2].tipo_produccion = $scope.formulario.programas[$scope.posicion2].evento.tipo_transmisione_id;
                $scope.formulario.programas[$scope.posicion2].id = $scope.formulario.programas[$scope.posicion2].evento.id;

                $scope.formulario.programas[$scope.posicion2].productores = $scope.formulario.programas[$scope.posicion2].evento.productor;
                $scope.showProductores = $scope.formulario.programas[$scope.posicion2].productores;
                if ($scope.formulario.programas[$scope.posicion2].tipo_produccion == 1) {
                    $scope.formulario.programas[$scope.posicion2].tipo_produccion = $scope.posicionesTipoProduccion[0].nombre;
                }
                if ($scope.formulario.programas[$scope.posicion2].tipo_produccion == 2) {
                    $scope.formulario.programas[$scope.posicion2].tipo_produccion = $scope.posicionesTipoProduccion[1].nombre;
                }
                $scope.senales = $scope.formulario.programas[$scope.posicion2].evento.senales;
                $scope.productores = $scope.formulario.programas[$scope.posicion2].evento.productores;
            }
        }
    };
    $scope.cambioPosiciones = function(pos) {
        if (angular.isUndefined(pos)) {
            $scope.posicion = "principal_meta";
        } else {
            $scope.posicion = pos;
        }
    };

    $scope.addInforme = function() {
        informeTransmisiones.addInformes($scope.formulario).success(function(data) {
            switch (data.estado) {
                case 1:
                    Flash.create('success', data.mensaje, 'customAlert');
                    $window.location = host + "produccion_mcr_informes";
                    break;
                case 0:
                    Flash.create('danger', data.mensaje, 'customAlert');
                    $scope.loader = false;
                    break;
            }
        });
    };
});

app.controller('informesView', function($scope, $filter, informeTransmisiones, $q, $window, Flash) {

    $scope.formulario = {};
    $scope.posiciones = [{ "id": "principal_meta", "nombre": "Principal" },
        { "id": "respaldo_meta", "nombre": "Respaldo" },
        { "id": "respaldo_otro_meta", "nombre": "Otro" }
    ];
    $scope.posicionesMochila = [{ "id": "mochila1", "nombre": "Mochila N° 1" },
        { "id": "mochila2", "nombre": "Mochila N° 2" },
        { "id": "mochila3", "nombre": "Mochila N° 3" },
        { "id": "mochila4", "nombre": "Mochila N° 4" },
        { "id": "movil", "nombre": "Movil" }
    ];

    $scope.$watch("idTransmision", function() {
        $scope.posicion = "principal_meta";
        if (angular.isDefined($scope.idTransmision)) {
            informeTransmisiones.viewInformes($scope.idTransmision).success(function(data) {
                $scope.tipo = data.ProduccionMcrInforme.tipo.id;
                $scope.produccion = data.ProduccionMcrInforme.programas.informes.evento.tipo_transmisione_id;
                $scope.productor = data.ProduccionMcrInforme.programas.informes.productores;
                $scope.supervisor = data.User.nombre;
                $scope.lugares = data.ProduccionMcrInforme.programas.informes.lugar;
                $scope.productorIngresado = data.ProduccionMcrInforme.programas.informes.productoresArray;
                $scope.senalesArray = data.ProduccionMcrInforme.programas.informes.senalesPrograma;
                $scope.showProductores = data.ProduccionMcrInforme.programas.informes.productores;

                if ($scope.produccion == 1) {
                    $scope.produccionView = 'VIVO'
                }
                if ($scope.produccion == 2) {
                    $scope.produccionView = 'RADIO'
                }
                if ($scope.tipo == 'cdf_noticias') {
                    $scope.muestraDataNoticias = true;
                    $scope.informe = data.ProduccionMcrInforme.programas.informes;
                } else {
                    $scope.muestraDataNoticias = false;
                }
                if ($scope.tipo == 'partido' || $scope.tipo == 'ceremonia') {
                    $scope.muestraDataPartidos = true;
                    if (data.informeArray = null) {
                        $scope.informe = data.informeArray;
                    } else {
                        $scope.informe = data.ProduccionMcrInforme.programas.informes.evento;
                    }
                } else {
                    $scope.muestraDataPartidos = false;
                }

                $scope.informeSa = data.ProduccionMcrInforme.satelite2;
                $scope.informeFO = data.ProduccionMcrInforme.fibra_optica;
                $scope.informeMO = data.ProduccionMcrInforme.micro_ondas;
                $scope.informeOtros = data.ProduccionMcrInforme.otros;

                $scope.cambioPosicionesMochila = function(pos) {
                    if (angular.isUndefined(pos)) {
                        $scope.posicionMochi = "mochila1";
                    } else {
                        $scope.posicionMochi = pos;
                    }
                };

                $scope.cambioPosiciones = function(pos) {
                    if (angular.isUndefined(pos)) {
                        $scope.posicion = "principal_meta";
                    } else {
                        $scope.posicion = pos;
                    }
                };
            })
            $scope.mensajeEmail = function() {
                alert('Email Enviado');
            }
        }
    });

});

app.controller('TransmisionControllerEditForm', function($scope, $filter, $q, $window, Flash, $rootScope, informeTransmisiones, ProgramasService, ReceptoresService) {

    $scope.formulario = {
        evento: '',
        otros: '',
        fibra_optica: '',
        satelite2: '',
        micro_ondas: '',
        programas: ''
    };
    var dataRe3ceptores = [];
    promesas = [];
    promesas.push(ProgramasService.listaProgramas());
    promesas.push(ReceptoresService.listaReceptores());

    $scope.test = function() {
        $q.all(promesas).then(function(data) {
            $scope.listaReceptore = data[1].data;
        });
    }
    $scope.test();
    $scope.rx_senal = [{ "id": "ok", "nombre": "Ok" },
        { "id": "deficiente", "nombre": "Deficiente" }, { "id": "sin_observaciones", "nombre": "Sin Observaciones" }
    ];

    $scope.posiciones = [{ "id": "principal_meta", "nombre": "Principal" },
        { "id": "respaldo_meta", "nombre": "Respaldo" },
        { "id": "respaldo_otro_meta", "nombre": "Otro" }
    ];
    $scope.posicion = "principal_meta";
    $scope.posicionesMochila = [{ "id": "mochila1", "nombre": "Mochila N° 1" },
        { "id": "mochila2", "nombre": "Mochila N° 2" },
        { "id": "mochila3", "nombre": "Mochila N° 3" },
        { "id": "mochila4", "nombre": "Mochila N° 4" },
        { "id": "movil", "nombre": "Movil" }
    ];
    $scope.lugares = [{ "id": "roger", "nombre": "Roger de Flor" },
        { "id": "chilefilms", "nombre": "Chile Films" }
    ];

    $scope.posicionMochi = "mochila1";
    $scope.selectedItem = $scope.posiciones[0];

    $scope.$watch("idTransmision", function() {
        var promesas = [];
        if (angular.isDefined($scope.idTransmision)) {
            console.log('vcvccv');
            informeTransmisiones.viewInformes($scope.idTransmision).success(function(data) {
                $scope.formulario = data.ProduccionMcrInforme;
                $scope.receptoresArray = data.receptoresArray;
                $scope.senalesArray = data.senalesArray;
                $scope.prestadoresArray = data.trasmisionSenalesArray;
                $scope.selected = $scope.receptoresArray[0];
                $scope.dataProgra = data.programaArray;
                $scope.informeSA = data.ProduccionMcrInforme.satelite2;
                $scope.informeFO = data.ProduccionMcrInforme.fibra_optica;
                $scope.informeMO = data.ProduccionMcrInforme.micro_ondas;
                $scope.showProductores = $scope.formulario.programas.informes.productores;
                $scope.dataundefined = undefined;
                $scope.dataProductores = data.productores;
                $scope.selected2 = $scope.formulario.programas.informes.senalesPrograma;

                if ($scope.informeSA) {
                    $scope.receptoresSatelite = $scope.receptoresArray;
                    $scope.prestadoresSatelite = $scope.prestadoresArray;

                } else {
                    $scope.receptoresSatelite = $scope.receptoresArray;
                    $scope.prestadoresSatelite = $scope.prestadoresArray;
                }
                if ($scope.informeFO) {
                    $scope.receptoresFibra = $scope.receptoresArray;
                    $scope.prestadoresFibra = $scope.prestadoresArray;

                } else {
                    $scope.receptoresFibra = $scope.receptoresArray;
                    $scope.prestadoresFibra = $scope.prestadoresArray;
                }
                if ($scope.informeMO) {
                    $scope.receptoresMicro = $scope.receptoresArray;
                    $scope.prestadoresMicro = $scope.prestadoresArray;

                } else {
                    $scope.receptoresMicro = $scope.receptoresArray;
                    $scope.prestadoresMicro = $scope.prestadoresArray;
                }
                $scope.tipo = data.ProduccionMcrInforme.tipo.id;

                if ($scope.tipo == 'cdf_noticias') {
                    $scope.muestraDataNoticias = true;
                } else {
                    $scope.muestraDataNoticias = false;
                }
                if ($scope.tipo == 'partido' || $scope.tipo == 'ceremonia') {
                    $scope.muestraDataPartidos = true;
                } else {
                    $scope.muestraDataPartidos = false;
                }
                if ($scope.formulario.programas) {
                    $scope.formulario.programa = $scope.formulario.programas.informes.evento.equipos;
                    $scope.formulario.hora_ini_evento = $scope.formulario.programas.informes.evento.hora_transmision;
                    $scope.formulario.hora_out_evento = $scope.formulario.programas.informes.evento.hora_termino_transmision;
                    $scope.formulario.lugar = $scope.formulario.programas.informes.evento.estadio;
                    $scope.formulario.campeonato = $scope.formulario.programas.informes.evento.campeonato;
                    $scope.formulario.fecha = $scope.formulario.programas.informes.evento.nombre_fecha_partido;
                    $scope.formulario.fecha_partido = $scope.formulario.programas.informes.evento.fecha_partido;
                    $scope.formulario.tipo_produccion = $scope.formulario.programas.informes.evento.tipo_transmisione_id;
                    $scope.senales = $scope.formulario.programas.informes.evento.senales;
                    $scope.productores = $scope.formulario.programas.informes.productores;
                    $scope.lugarFormu = $scope.formulario.programas.informes.lugar;
                    $scope.formulario.senalesPrograma = $scope.formulario.programas.informes.senalesPrograma;
                    $scope.formulario.programas.informes.productoresArray = $scope.formulario.programas.informes.productoresArray;

                }
                $scope.cambioPosicionesMochila = function(pos) {
                    if (angular.isUndefined(pos)) {
                        $scope.posicionMochi = "mochila1";
                    } else {
                        $scope.posicionMochi = pos;
                    }
                };
                $scope.cambioPosiciones = function(pos) {
                    if (angular.isUndefined(pos)) {
                        $scope.posicion = "principal_meta";
                    } else {
                        $scope.posicion = pos;
                    }
                    if ($scope.informeSA) {
                        $scope.receptoresSatelite = $scope.receptoresArray;
                        $scope.prestadoresSatelite = $scope.prestadoresArray;
                    } else {
                        $scope.receptoresSatelite = data.receptoresArray;
                        $scope.prestadoresSatelite = $scope.prestadoresArray;
                    }
                    if ($scope.informeFO) {
                        $scope.receptoresFibra = $scope.receptoresArray;
                        $scope.prestadoresFibra = $scope.prestadoresArray;
                    } else {
                        $scope.receptoresFibra = $scope.receptoresArray;
                        $scope.prestadoresFibra = $scope.prestadoresArray;
                    }
                    if ($scope.informeMO) {
                        $scope.receptoresMicro = $scope.receptoresArray;
                        $scope.prestadoresMicro = $scope.prestadoresArray;
                    } else {
                        $scope.receptoresMicro = $scope.receptoresArray;
                        $scope.prestadoresMicro = $scope.prestadoresArray;
                    }
                };
            });
        }
    });

    $scope.editarTransmision = function() {
        informeTransmisiones.editarTransmisionGuardar($scope.formulario).success(function(data) {
            switch (data.estado) {
                case 1:
                    Flash.create('success', data.mensaje, 'customAlert');
                    $window.location = host + "produccion_mcr_informes";
                    break;
                case 0:
                    Flash.create('danger', data.mensaje, 'customAlert');
                    $scope.loader = false;
                    break;
            }
        });
    };
})
