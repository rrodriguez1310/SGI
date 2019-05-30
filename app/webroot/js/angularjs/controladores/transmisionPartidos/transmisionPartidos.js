"use strict";
appTextEditor.config(function($provide) {
    $provide.decorator('taOptions', ['taRegisterTool', '$delegate', function(taRegisterTool, taOptions) {
        taOptions.toolbar = [
            ['h1', 'h2', 'h3', 'h4', 'p'],
            ['bold', 'italics', 'underline', 'ul', 'ol']
        ];
        return taOptions;
    }]);
});

app.controller('TransmisionController', ['$scope', '$http', '$filter', 'TransmisionService', 'Flash', function($scope, $http, $filter, TransmisionService, Flash) {
    //var rowtpl='<div ng-class="{\'red\':row.entity.estado==\'Ingresado\' }"><div ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ng-class="{ \'ui-grid-row-header-cell\': col.isRowHeader }" ui-grid-cell></div></div>';
    $scope.isReadonly = true;
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.gridOptions = {
        columnDefs: [
            { name: 'id', displayName: 'Id', width: 90, visible: false },
            { name: 'transmisionPartido', displayName: 'Id Transmision', width: 90, visible: false },
            { name: 'campeonato', displayName: 'Campeonato' },
            { name: 'categoria', displayName: 'Categoría' },
            { name: 'subcategoria', displayName: 'Subcategoría' },
            { name: 'dia', displayName: 'Día' },
            { name: 'estadio', displayName: 'Estadio' },
            { name: 'estadio_region', displayName: 'Estadio Region', visible: false },
            { name: 'hora', displayName: 'Hora' },
            { name: 'local', displayName: 'Local' },
            { name: 'visita', displayName: 'Visita' },
            {
                name: 'estado',
                displayName: 'Estado',
                width: 90,
                cellTemplate: '<div class="ui-grid-cell-contents">{{(row.entity.estado==1) ? "Ingresado" : ((row.entity.estado==2) ? "Eliminado" : "Pendiente") }}</div>',
                cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                    return ((grid.getCellValue(row, col) == 1) ? 'angular_aprobado_g' : (grid.getCellValue(row, col) == 2) ? "angular_eliminado" : "angular_pendiente_g");
                }
            },
        ],
        enableGridMenu: true,
        gridMenuShowHideColumns: true,
        enableSelectAll: false,
        enableColumnMenus: true,
        //rowTemplate:rowtpl,
        exporterCsvFilename: 'myFile.csv',
        exporterMenuPdf: false,
        multiSelect: false,
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    TransmisionService.transmisionListaJson().then(function(data) {
        if (data.data.length > 0) {
            $scope.gridOptions.data = data.data;
            $scope.loader = false;
            $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
                $scope.id = row.entity.id;
                $scope.idTransmision = row.entity.transmisionPartido;

                if (row.isSelected == true) {
                    if (row.entity.estado == 0) {
                        $scope.btnedit = true;
                        $scope.btnadd = false;
                        $scope.btndelete = true;
                        $scope.btnview = true;
                        /*$scope.btntransmision_partidosedit = true;
                        $scope.btntransmision_partidosadd = false;
                        $scope.btntransmision_partidosview = true;
                        $scope.btntransmision_partidosdelete = true;*/
                    } else if (row.entity.estado == 2) {
                        $scope.btnedit = true;
                        $scope.btnadd = true;
                        $scope.btndelete = true;
                        $scope.btnview = false;
                        /*
                                                $scope.btntransmision_partidosedit = true;
                                                $scope.btntransmision_partidosadd = true;
                                                $scope.btntransmision_partidosview = false;
                                                $scope.btntransmision_partidosdelete = true;*/
                    } else if (row.entity.estado == 1) {
                        $scope.btnedit = false;
                        $scope.btnadd = true;
                        $scope.btndelete = false;
                        $scope.btnview = false;
                        /*
                        $scope.btntransmision_partidosedit = false;
                        $scope.btntransmision_partidosadd = true;
                        $scope.btntransmision_partidosview = false;
                        $scope.btntransmision_partidosdelete = false;
                        */
                    }
                    $scope.boton = true;
                } else {
                    $scope.boton = false;
                }
            });
        } else {
            $scope.loader = false;
            Flash.create('danger', 'No se encontraron Registros de Transmisión', 'customAlert');
        }

        $scope.confirmacion = function() {
            window.location.href = host + "transmision_partidos/delete_transmision/" + $scope.idTransmision
        }

        $scope.generaExcel = function() {
            console.log('gfgfgf');
            TransmisionService.transmisionGeneraExcel().then(function(data) {
                console.log(host + data);
                window.location.assign(host + data.data.url);
            });
        };

        $scope.generaReporte = function() {
            window.location.assign(host + "transmision_partidos/reporte");
        };

        $scope.refreshData = function(termObj) {
            $scope.gridOptions.data = data.data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });
}]);

appTextEditor.controller("TransmisionControllerEnviar", ["$scope", "$http", "$window", "TransmisionService", "Flash", function($scope, $http, $window, TransmisionService, Flash) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.enviarDisabled = false;
    $scope.showModal = false;
    $scope.transmisiones = [];
    $scope.transmisionForm = {};
    $scope.transmisionForm.email = "mcr@cdf.cl";
    TransmisionService.transmisionListaEnvioJson().then(function(data) {
        if (data.data['estado'] == 0) {
            $scope.enviarDisabled = true;
            Flash.create('danger', data.data['mensaje'], 'customAlert');
            /*
            setTimeout(function() {
                $window.location =host+"transmision_partidos";
            }, 2500);
            */
        } else {
            $scope.transmisiones = $.map(data.data, function(value, index) {
                return [value];
            });
        }
        $scope.loader = false;
    });

    $scope.generarPdf = function(archivo) {
        $scope.enviarDisabled = true;
        $scope.loader = true;
        var parametros = {
            "nombre": "transmision_pdf.pdf",
            "controlador": 'transmisionPartido',
            "carpeta": 'tmp',
            "html": angular.element("#cuerpoHtmlTabla").html(),
            "orientacion": 'P'
        }
        var pdf_url = host + 'transmision_partidos/transmision_pdf/enviar';

        var imprimirHtml = $http({
            method: 'POST',
            url: pdf_url,
            data: $.param(parametros)
        });

        imprimirHtml.then(function(dataFile) {
            $scope.transmisionForm.adjunto = host + dataFile.data;
            // archivo: 1->genera archivo y lo abre en otra pestaña. 2->genera archivo y devuelve url.            
            if (archivo == 1) {
                window.open(host + dataFile.data);
                $scope.enviarDisabled = false;
                $scope.loader = false;
            } else if (archivo == 2) {
                TransmisionService.enviarCorreoTransmisiones($scope.transmisionForm).success(function(data) {
                    if (data.estado == 1) {
                        Flash.create('success', data.mensaje, 'customAlert');
                        $window.location.reload();
                        $scope.loader = false;
                    } else if (data.estado == 0) {
                        Flash.create('danger', data.mensaje, 'customAlert');
                        $window.location.reload();
                        $scope.loader = false;
                    }
                });
            }
        });
    };

    $scope.mostrarEnviarCorreo = function() {
        $scope.showModal = true;
    };

    $scope.cerrarModal = function() {
        $scope.showModal = false;
    };

}]);

app.controller('TransmisionControllerForm', function($scope, $filter, TransmisionService, $q, $window, Flash, $rootScope) {
    $scope.formulario = {};
    $scope.cambia = function(pos) {
        if (pos == "principal_meta" || pos == "respaldo_meta") {
            if ($scope.transmisionPosiciones["principal_meta"].senal === $scope.transmisionPosiciones["respaldo_meta"].senal) {
                alert("¿Estás seguro de usar el mismo metodo de Transmisión para Principal y Respaldo?");
            }
        }
    };

    $scope.$watch("idTransmision", function() {
        var promesas = [];
        $scope.loader = true;
        $scope.cargador = loader;

        if (angular.isDefined($scope.idTransmision)) {
            promesas.push(TransmisionService.editTransmision($scope.idTransmision));
            $q.all(promesas).then(function(data) {
                $scope.posicion = "principal_meta";
                $scope.posicionActual = "principal_meta";
                data = data[0].data;



                $scope.produccion = data.produccion;
                $scope.senales = data.senales;
                $scope.canales = data.canales;
                $scope.formulario = {};
                $scope.transmisionPosiciones = [];
                $scope.transmisionSenales = [];
                $scope.guardar = false;
                $scope.deshabilitado = true;

                $scope.posiciones = [{ "id": "principal_meta", "nombre": "Principal" },
                    { "id": "respaldo_meta", "nombre": "Respaldo" },
                    { "id": "radio_meta", "nombre": "Radio" },
                    { "id": "respaldo_otro_meta", "nombre": "Otro" }
                ];

                $scope.transmisionPosiciones["principal_meta"] = { "medio": "", "senal": "" };
                $scope.transmisionPosiciones["respaldo_meta"] = { "medio": "", "senal": "" };
                $scope.transmisionPosiciones["radio_meta"] = { "medio": "", "senal": "" };
                $scope.transmisionPosiciones["respaldo_otro_meta"] = { "medio": "", "senal": "", "canal": "" };

                $scope.posicionesActuales = ["principal_meta", "respaldo_meta", "radio_meta", "respaldo_otro_meta"];

                $scope.formulario["principal_meta"] = JSON.parse(data.transmision.TransmisionPartido.principal_meta);
                $scope.formulario["respaldo_meta"] = JSON.parse(data.transmision.TransmisionPartido.respaldo_meta);
                $scope.formulario["radio_meta"] = JSON.parse(data.transmision.TransmisionPartido.radio_meta);
                if ($scope.formulario["respaldo_otro_meta"]) {
                    $scope.formulario["respaldo_otro_meta"] = JSON.parse(data.transmision.TransmisionPartido.respaldo_otro_meta);
                }

                $scope.loader = false;
                $scope.medios = data.medios;
                $scope.tipoevento = data.tipoevento;
                $scope.transmision = data.transmision.TransmisionPartido;

                $scope.formulario.produccion_partidos_evento_id = data.produccion.id;
                $scope.formulario.id = data.transmision.TransmisionPartido.id;

                $scope.transmisionPosiciones["principal_meta"].senal = data.transmision.TransmisionPartido.transmision_senales_principal_senale_id;
                $scope.transmisionPosiciones["respaldo_meta"].senal = data.transmision.TransmisionPartido.transmision_senales_respaldo_senale_id;
                $scope.transmisionPosiciones["radio_meta"].senal = data.transmision.TransmisionPartido.radio;
                $scope.transmisionPosiciones["respaldo_otro_meta"].senal = data.transmision.TransmisionPartido.transmision_senales_respaldo_otro_senale_id;

                if (data.transmision.TransmisionPartido.transmision_senales_principal_senale_id) {
                    var medio_id_principal = $filter('filter')(data.senales, { id: data.transmision.TransmisionPartido.transmision_senales_principal_senale_id });
                    $scope.transmisionPosiciones["principal_meta"].medio = medio_id_principal[0].medio_id;
                }

                if (data.transmision.TransmisionPartido.transmision_senales_respaldo_senale_id) {
                    var medio_id_respaldo = $filter('filter')(data.senales, { id: data.transmision.TransmisionPartido.transmision_senales_respaldo_senale_id });
                    $scope.transmisionPosiciones["respaldo_meta"].medio = medio_id_respaldo[0].medio_id;
                }

                if (data.transmision.TransmisionPartido.radio) {
                    var medio_id_radio = $filter('filter')(data.senales, { id: data.transmision.TransmisionPartido.radio });
                    $scope.transmisionPosiciones["radio_meta"].medio = medio_id_radio[0].medio_id;
                } else {
                    $scope.transmisionPosiciones["radio_meta"].medio = undefined;
                }

                if (data.transmision.TransmisionPartido.transmision_senales_respaldo_otro_senale_id) {
                    var medio_id_respaldo2 = $filter('filter')(data.senales, { id: data.transmision.TransmisionPartido.transmision_senales_respaldo_otro_senale_id });
                    $scope.transmisionPosiciones["respaldo_otro_meta"].medio = medio_id_respaldo2[0].medio_id;
                } else {
                    $scope.transmisionPosiciones["respaldo_otro_meta"].medio = undefined;
                }

                $scope.transmisionSenales["principal_meta"] = $filter('filter')(data.senales, { medio_id: $scope.transmisionPosiciones["principal_meta"].medio });
                $scope.transmisionSenales["respaldo_meta"] = $filter('filter')(data.senales, { medio_id: $scope.transmisionPosiciones["respaldo_meta"].medio });
                $scope.transmisionSenales["radio_meta"] = $filter('filter')(data.senales, { medio_id: $scope.transmisionPosiciones["radio_meta"].medio });

                //if(data.transmision.TransmisionPartido.transmision_senales_respaldo_otro_senale_id){
                $scope.transmisionSenales["respaldo_otro_meta"] = $filter('filter')(data.senales, { medio_id: $scope.transmisionPosiciones["respaldo_otro_meta"].medio });
                //}

                $scope.cambioPosiciones = function(pos) {
                    if (angular.isUndefined(pos)) {
                        $scope.posicion = "principal_meta";
                    } else {
                        $scope.posicion = pos;
                    }
                };

                $scope.$watchGroup([
                    'transmisionPosiciones["principal_meta"].medio',
                    'transmisionPosiciones["respaldo_meta"].medio',
                    'transmisionPosiciones["principal_meta"].senal',
                    'transmisionPosiciones["respaldo_meta"].senal'
                ], function() {
                    if ($scope.transmisionPosiciones["principal_meta"].senal !== null && $scope.transmisionPosiciones["principal_meta"].senal !== "") {
                        if ($scope.transmisionPosiciones["respaldo_meta"].senal !== null && $scope.transmisionPosiciones["respaldo_meta"].senal !== "") {
                            $scope.deshabilitado = true;
                        } else {
                            $scope.deshabilitado = false;
                        }
                    } else {
                        $scope.deshabilitado = false;
                    }
                });

                $scope.cambiaMedio = function(newVal, pos) {
                    $scope.transmisionSenales[pos] = $scope.senales;
                    $scope.transmisionPosiciones[pos].senal = "";
                    $scope.transmisionSenales[pos] = $filter('filter')($scope.transmisionSenales[pos], { medio_id: newVal });
                };

            });
        }
    });

    $scope.editarTransmision = function() {
        $scope.loader = true;
        $scope.cargador = loader;
        $scope.formulario.principal_meta = JSON.stringify($scope.formulario.principal_meta);
        $scope.formulario.respaldo_meta = JSON.stringify($scope.formulario.respaldo_meta);
        $scope.formulario.radio_meta = JSON.stringify($scope.formulario.radio_meta);
        $scope.formulario.respaldo_otro_meta = JSON.stringify($scope.formulario.respaldo_otro_meta);
        $scope.formulario.transmision_senales_principal_senale_id = $scope.transmisionPosiciones["principal_meta"].senal;
        $scope.formulario.transmision_senales_respaldo_senale_id = $scope.transmisionPosiciones["respaldo_meta"].senal;
        $scope.formulario.radio = $scope.transmisionPosiciones["radio_meta"].senal;
        $scope.formulario.transmision_senales_respaldo_otro_senale_id = $scope.transmisionPosiciones["respaldo_otro_meta"].senal;

        TransmisionService.editarTransmisionGuardar($scope.formulario).success(function(data) {
            switch (data.estado) {
                case 1:
                    Flash.create('success', data.mensaje, 'customAlert');
                    $window.location = host + "transmision_partidos";
                    break;
                case 0:
                    Flash.create('danger', data.mensaje, 'customAlert');
                    $scope.loader = false;
                    break;
            }
        });

    };
});

app.controller('TransmisionControllerView', function($scope, $filter, TransmisionService, $q, $window, Flash) {
    $scope.formulario = {};

    $scope.$watch("idTransmision", function() {
        var promesas = [];
        $scope.loader = true;
        $scope.cargador = loader;
        $scope.posicion = "principal_meta";
        if (angular.isDefined($scope.idTransmision)) {
            promesas.push(TransmisionService.editTransmision($scope.idTransmision));
            $q.all(promesas).then(function(data) {
                data = data[0].data;
                $scope.produccion = data.produccion;
                $scope.senales = data.senales;
                $scope.canales = data.canales;
                $scope.medios = data.medios;
                $scope.tipoevento = data.tipoevento;
                $scope.transmision = data.transmision.TransmisionPartido;
                $scope.loader = false;

                $scope.transmisionPosiciones = [];
                $scope.posiciones = [{ "id": "principal_meta", "nombre": "Principal" },
                    { "id": "respaldo_meta", "nombre": "Respaldo" },
                    { "id": "radio_meta", "nombre": "Radio" },
                    { "id": "respaldo_otro_meta", "nombre": "Otro" }
                ];

                $scope.transmisionPosiciones["principal_meta"] = { "medio": "", "senal": "" };
                $scope.transmisionPosiciones["respaldo_meta"] = { "medio": "", "senal": "" };
                $scope.transmisionPosiciones["radio_meta"] = { "medio": "", "senal": "" };
                $scope.transmisionPosiciones["respaldo_otro_meta"] = { "medio": "", "senal": "" };

                $scope.posicionesActuales = ["principal_meta", "respaldo_meta", "radio_meta", "respaldo_otro_meta"];

                $scope.formulario["principal_meta"] = JSON.parse(data.transmision.TransmisionPartido.principal_meta);
                $scope.formulario["respaldo_meta"] = JSON.parse(data.transmision.TransmisionPartido.respaldo_meta);
                $scope.formulario["radio_meta"] = JSON.parse(data.transmision.TransmisionPartido.radio_meta);
                $scope.formulario["respaldo_otro_meta"] = JSON.parse(data.transmision.TransmisionPartido.respaldo_otro_meta);

                if (data.transmision.TransmisionPartido.transmision_senales_principal_senale_id) {
                    var medio_id_principal = $filter('filter')(data.senales, { id: data.transmision.TransmisionPartido.transmision_senales_principal_senale_id });
                    $scope.transmisionPosiciones["principal_meta"].medio = medio_id_principal[0].medio_tx;
                    $scope.transmisionPosiciones["principal_meta"].senal = medio_id_principal[0].nombre;
                }

                if (data.transmision.TransmisionPartido.transmision_senales_respaldo_senale_id) {
                    var medio_id_respaldo = $filter('filter')(data.senales, { id: data.transmision.TransmisionPartido.transmision_senales_respaldo_senale_id });
                    $scope.transmisionPosiciones["respaldo_meta"].medio = medio_id_respaldo[0].medio_tx;
                    $scope.transmisionPosiciones["respaldo_meta"].senal = medio_id_respaldo[0].nombre;
                }

                if (data.transmision.TransmisionPartido.radio) {
                    var medio_id_radio = $filter('filter')(data.senales, { id: data.transmision.TransmisionPartido.radio });
                    $scope.transmisionPosiciones["radio_meta"].medio = medio_id_radio[0].medio_tx;
                    $scope.transmisionPosiciones["radio_meta"].senal = medio_id_radio[0].nombre;
                } else {
                    $scope.transmisionPosiciones["radio_meta"].medio = undefined;
                }

                if (data.transmision.TransmisionPartido.transmision_senales_respaldo_otro_senale_id) {
                    var medio_id_respaldo2 = $filter('filter')(data.senales, { id: data.transmision.TransmisionPartido.transmision_senales_respaldo_otro_senale_id });
                    $scope.transmisionPosiciones["respaldo_otro_meta"].medio = medio_id_respaldo2[0].medio_tx;
                    $scope.transmisionPosiciones["respaldo_otro_meta"].senal = medio_id_respaldo2[0].nombre;
                    var canal = $filter('filter')(data.canales, { id: $scope.formulario["respaldo_otro_meta"].canal });
                    $scope.canalNombre = canal[0].nombre;
                } else {
                    $scope.transmisionPosiciones["respaldo_otro_meta"].medio = undefined;
                }

                $scope.cambioPosiciones = function(pos) {
                    if (angular.isUndefined(pos)) {
                        $scope.posicion = "principal_meta";
                    } else {
                        $scope.posicion = pos;
                    }
                };
            });
        }
    });

});

app.controller('TransmisionControllerAddForm', function($scope, $filter, TransmisionService, $q, $window, Flash) {
    $scope.formulario = {};

    $scope.cambia = function(pos) {
        if (pos == "principal_meta" || pos == "respaldo_meta") {
            if ($scope.transmisionPosiciones["principal_meta"].senal === $scope.transmisionPosiciones["respaldo_meta"].senal) {
                alert("¿Estás seguro de usar el mismo metodo de Transmisión para Principal y Respaldo?");
            }
        }
    };

    $scope.$watch("idTransmision", function() {
        var promesas = [];
        $scope.loader = true;
        $scope.cargador = loader;
        $scope.deshabilitado = true;
        $scope.posicion = "principal_meta";
        $scope.posicionActual = "principal_meta";

        if (angular.isDefined($scope.idTransmision)) {
            promesas.push(TransmisionService.addTransmision($scope.idTransmision));
            $q.all(promesas).then(function(data) {
                data = data[0].data;
                $scope.transmisionPosiciones = [];
                $scope.transmisionSenales = [];
                $scope.produccion = data.produccion;
                $scope.senales = data.senales;
                $scope.canales = data.canales;
                $scope.senales_principal = data.senales;
                $scope.senales_respaldo = data.senales;
                $scope.senales_radio = data.senales;
                $scope.senales_respaldo2 = data.senales;
                $scope.medios = data.medios;
                $scope.tipoevento = data.tipoevento;
                $scope.loader = false;
                $scope.formulario.produccion_partidos_evento_id = data.produccion.id;

                $scope.posiciones = [{ "id": "principal_meta", "nombre": "Principal" },
                    { "id": "respaldo_meta", "nombre": "Respaldo" },
                    { "id": "radio_meta", "nombre": "Radio" },
                    { "id": "respaldo_otro_meta", "nombre": "Otro" }
                ];

                $scope.transmisionSenales["principal_meta"] = data.senales;
                $scope.transmisionSenales["respaldo_meta"] = data.senales;
                $scope.transmisionSenales["radio_meta"] = data.senales;
                $scope.transmisionSenales["respaldo_otro_meta"] = data.senales;

                $scope.transmisionPosiciones["principal_meta"] = { "medio": "", "senal": "" };
                $scope.transmisionPosiciones["respaldo_meta"] = { "medio": "", "senal": "" };
                $scope.transmisionPosiciones["radio_meta"] = { "medio": "", "senal": "" };
                $scope.transmisionPosiciones["respaldo_otro_meta"] = { "medio": "", "senal": "", "canal": "" };

                $scope.posicionesActuales = ["principal_meta", "respaldo_meta", "radio_meta", "respaldo_otro_meta"];

                $scope.cambioPosiciones = function(pos) {
                    if (angular.isUndefined(pos)) {
                        $scope.posicion = "principal_meta";
                    } else {
                        $scope.posicion = pos;
                    }
                };

                $scope.$watchGroup([
                    'transmisionPosiciones["principal_meta"].medio',
                    'transmisionPosiciones["respaldo_meta"].medio',
                    'transmisionPosiciones["principal_meta"].senal',
                    'transmisionPosiciones["respaldo_meta"].senal'
                ], function() {
                    if ($scope.transmisionPosiciones["principal_meta"].senal !== "" && $scope.transmisionPosiciones["principal_meta"].senal !== undefined) {
                        if ($scope.transmisionPosiciones["respaldo_meta"].senal !== "" && $scope.transmisionPosiciones["respaldo_meta"].senal !== undefined) {
                            $scope.deshabilitado = true;
                        }
                    } else {
                        $scope.deshabilitado = false;
                    }
                });

                $scope.cambiaMedio = function(newVal, pos) {
                    $scope.transmisionSenales[pos] = $scope.senales;
                    $scope.transmisionPosiciones[pos].senal = "";
                    $scope.transmisionSenales[pos] = $filter('filter')($scope.transmisionSenales[pos], { medio_id: newVal });
                };

            });
        }
    });

    $scope.addTransmision = function() {
        $scope.loader = true;
        $scope.cargador = loader;
        $scope.formulario.transmision_senales_principal_senale_id = $scope.transmisionPosiciones["principal_meta"].senal;
        $scope.formulario.transmision_senales_respaldo_senale_id = $scope.transmisionPosiciones["respaldo_meta"].senal;
        $scope.formulario.radio = $scope.transmisionPosiciones["radio_meta"].senal;
        $scope.formulario.transmision_senales_respaldo_otro_senale_id = $scope.transmisionPosiciones["respaldo_otro_meta"].senal;
        $scope.formulario.respaldo_otro_meta = JSON.stringify($scope.formulario.respaldo_otro_meta);
        var formulario = $scope.formulario;
        console.log($scope.formulario);

        TransmisionService.addTransmisionGuardar(formulario).success(function(data) {
            switch (data.estado) {
                case 1:
                    Flash.create('success', data.mensaje, 'customAlert');
                    $window.location = host + "transmision_partidos";
                    break;
                case 0:
                    $scope.loader = false;
                    Flash.create('danger', data.mensaje, 'customAlert');
                    break;
            }
        });

    };
});

app.controller('TransmisionControllerCarga', ['$scope', '$http', '$filter', '$window', 'TransmisionService', 'Upload', 'Flash', function($scope, $http, $filter, $window, TransmisionService, Upload, Flash) {
    //var rowtpl='<div ng-class="{\'red\':row.entity.estado==\'Pendiente\' }"><div ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ng-class="{ \'ui-grid-row-header-cell\': col.isRowHeader }" ui-grid-cell></div></div>';
    $scope.isReadonly = true;
    $scope.loader = false;
    $scope.cargador = loader;
    $scope.datosCargados = false;
    $scope.deshabilitado = true;

    angular.element(document).ready(function() {
        $scope.showModal = true;
    });

    var parametros = {};
    $scope.gridOptions = {
        columnDefs: [
            { name: 'id', enableCellEdit: false, displayName: 'Id', width: 50, visible: true },
            { name: 'local', enableCellEdit: false, displayName: 'Local', width: 110 },
            { name: 'visita', enableCellEdit: false, displayName: 'Visita', width: 110 },
            { name: 'tipo_senal', enableCellEdit: false, displayName: 'Tipo Señal', width: 80 },
            { name: 'senal', enableCellEdit: true, displayName: 'Medio Tx', width: 120 },
            { name: 'puesta_marcha', enableCellEdit: true, displayName: 'Puesta en Marcha', width: 230 },
            { name: 'contacto_estadio', enableCellEdit: true, displayName: 'Contacto Estadio', width: 200 },
            { name: 'recepcion_senal', enableCellEdit: true, displayName: 'Recepción Señal CDF', width: 90 },
            { name: 'anexo', enableCellEdit: true, displayName: 'Anexo', width: 90 },
            /*{ name:'estado', displayName: 'Estado', width:90, cellTemplate : '<div class="ui-grid-cell-contents">{{(row.entity.estado==\'Ingresado\') ? "Ingresado" : "Pendiente" }}</div>',
                cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                    return ((grid.getCellValue(row,col)=='Ingresado') ? 'angular_aprobado_g' : "angular_pendiente_g");
                }
            },*/
        ],
        enableGridMenu: true,
        gridMenuShowHideColumns: true,
        enableSelectAll: true,
        enableColumnMenus: true,
        //rowTemplate:rowtpl,
        exporterCsvFilename: 'myFile.csv',
        exporterMenuPdf: false,
        multiSelect: true,
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    $scope.cargaExcel = function(files) {
        $scope.subirDisabled = true;
        parametros = {
            "user_id": $scope.usuarioId
        }

        if (files && files.length) {
            var file = files[0];
        }

        Upload.upload({
                url: host + 'transmision_partidos/subir_csv',
                fields: parametros,
                data: '',
                file: file
            })
            .success(function(data, status, headers, config) {
                $scope.agregar = false;
                if (data.estado == 1) {
                    $scope.cargarGrillaCsv(data.data);
                    $scope.subirDisabled = false;
                } else if (data.estado == 0) {
                    $scope.msjError = 'No se ha podido leer el archivo de origen.';
                    $scope.subirDisabled = false;
                } else if (data.estado == 3) {
                    $scope.msjError = 'Archivo supera el límite permitido';
                    $scope.subirDisabled = false;
                } else if (data.estado == 2) {
                    $scope.msjError = 'Error: el formato de archivo no permitido';
                    $scope.subirDisabled = false;
                } else {
                    $scope.msjError = 'Seleccione otro archivo';
                    $scope.subirDisabled = false;
                }
            });
        $scope.eliminarArchivo(files);
    };

    $scope.settingFile = function(files) {
        if (files && files.length) {
            $scope.setFile = true;

            if (files[0].name.length > 18) {
                $scope.nombreArchivo = files[0].name.slice(0, 18) + '...';
            } else {
                $scope.nombreArchivo = files[0].name;
            }

            var tamaño = (files[0].size / 1000000).toFixed(2);
            $scope.sizeArchivo = '(' + tamaño + 'MB)';

            if (tamaño > 2) {
                $scope.msjError = 'Archivo supera el límite permitido';
                $scope.alerta = true;
                $scope.eliminarArchivo(files);
                Flash.create('danger', 'Archivo supera el límite permitido', 'customAlert');
            } else {
                $scope.msjError = '';
                $scope.alerta = false;
                $scope.loader = true;
                $scope.cargaExcel(files);
            }
        }
    };

    $scope.eliminarArchivo = function(files) {
        if (files && files.length) {
            files = undefined;
            $scope.nombreArchivo = undefined;
            $scope.sizeArchivo = undefined;
            $scope.setFile = false;

            if ($scope.alerta) {
                $scope.msjError = '';
                $scope.alerta = false;
            }
        }
    };

    $scope.cargarGrillaCsv = function(archivo) {
        $scope.loader = true;
        TransmisionService.transmisionLeerCsvJson(archivo).then(function(data) {
            if (data.data.length !== 0) {
                $scope.showModal = false;
                $scope.gridOptions.data = data.data;
                $scope.loader = false;
                $scope.datosCargados = true;
                $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
                    $scope.id = row.entity.id;
                });
                Flash.create('success', 'El Archivo se ha cargado correctamente', 'customAlert');
            } else {
                $scope.loader = false;
                Flash.create('danger', 'No se pudo cuadrar ningún partido activo, o bien la información requerida viene en blanco, Intente nuevamente.', 'customAlert');
            }
        });
    };

    $scope.consolidarInfo = function() {
        $scope.loader = true;
        $scope.deshabilitado = false;
        TransmisionService.consolidaCsv($scope.gridOptions.data).then(function(datos) {
            console.log(datos);

            if (datos.data.estado == 1) {
                Flash.create('success', datos.data.mensaje, 'customAlert');
            } else if (datos.data.estado == 2) {
                Flash.create('danger', datos.data.mensaje, 'customAlert');
            }
            $scope.loader = false;

            setTimeout(function() {
                $window.location = host + "transmision_partidos";
            }, 2500);

        });
    };

    $scope.refreshData = function(termObj) {
        $scope.gridOptions.data = data.data;
        while (termObj) {
            var oSearchArray = termObj.split(' ');
            $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
            oSearchArray.shift();
            termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
        }
    };

}]);

appTextEditor.controller("TransmisionControllerReporte", ["$scope", "$http", "$window", "TransmisionService", "Flash", function($scope, $http, $window, TransmisionService, Flash) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.enviarDisabled = false;
    $scope.showModal = false;
    $scope.transmisiones = [];
    $scope.transmisionForm = {};
    $scope.transmisionForm.email = "mcr@cdf.cl";
    TransmisionService.transmisionReporteListaJson().then(function(data) {
        if (data.data['estado'] == 0) {
            $scope.enviarDisabled = true;
            Flash.create('danger', data.data['mensaje'], 'customAlert');
        } else {
            $scope.transmisiones = $.map(data.data, function(value, index) {
                return [value];
            });
        }
        $scope.loader = false;
    });

    $scope.generarPdf = function(archivo) {
        $scope.enviarDisabled = true;
        $scope.loader = true;
        var parametros = {
            "nombre": "transmision_pdf.pdf",
            "controlador": 'transmisionPartido',
            "carpeta": 'tmp',
            "html": angular.element("#cuerpoHtmlTabla").html(),
            "orientacion": 'P'
        }
        var pdf_url = host + 'transmision_partidos/transmision_pdf/reporte';

        var imprimirHtml = $http({
            method: 'POST',
            url: pdf_url,
            data: $.param(parametros)
        });

        imprimirHtml.then(function(dataFile) {
            $scope.transmisionForm.adjunto = host + dataFile.data;
            // archivo: 1->genera archivo y lo abre en otra pestaña. 2->genera archivo y devuelve url.            
            if (archivo == 1) {
                window.open(host + dataFile.data);
                $scope.enviarDisabled = false;
                $scope.loader = false;
            } else if (archivo == 2) {
                TransmisionService.enviarCorreoTransmisiones($scope.transmisionForm).success(function(data) {
                    if (data.estado == 1) {
                        Flash.create('success', data.mensaje, 'customAlert');
                        $window.location.reload();
                        $scope.loader = false;
                    } else if (data.estado == 0) {
                        Flash.create('danger', data.mensaje, 'customAlert');
                        $window.location.reload();
                        $scope.loader = false;
                    }
                });
            }
        });
    };

    $scope.mostrarEnviarCorreo = function() {
        $scope.showModal = true;
    };

    $scope.cerrarModal = function() {
        $scope.showModal = false;
    };

}]);

app.controller('TransmisionControllerAddInforme', function($scope, $filter, TransmisionService, $q, $window, Flash) {

    $scope.formulario = {
        hora_ini_evento: '',
        hora_out_evento: '',
        lugar: '',
        selectedItemReceptorSatelite: '',
        hora_ini_fibra: '',
        hora_out_fibra: '',
        hora_ini_satelite: '',
        hora_out_satelite: '',
        hora_ini_micro: '',
        hora_out_micro: '',
        programa: '',
        ber: '',
        signal_level: '',
        cn: '',
        cn_margin: '',
        selectedItemReceptorFibra: '',
        selectedItemReceptorMicro: '',
        rx_senal_satelite: '',
        rx_senal_fibra: '',
        rx_senal_micro: ''
    };
    $scope.hola = 'Hola';
    $scope.rx_senal = [{ "id": "ok", "nombre": "Ok" },
        { "id": "deficiente", "nombre": "Deficiente" }, { "id": "sin_observaciones", "nombre": "Sin Observaciones" }
    ]
    $scope.posiciones = [{ "id": "fibraoptica", "nombre": "Fibra Optica" },
        { "id": "satelital", "nombre": "Satelital" },
        { "id": "microondas", "nombre": "Micro Ondas" },
        { "id": "otro", "nombre": "Otro" },
    ];
    $scope.selectedItem = $scope.posiciones[0];
    $scope.receptorDataSatelite = [{ "id": "1", "nombre": "SATHD" }];
    $scope.receptorDataFibra = [{ "id": "1", "nombre": "RXHD 1 CLARO" },
        { "id": "2", "nombre": "RXHD 2 CLARO" },
        { "id": "3", "nombre": "RXC13 HD1" },
        { "id": "4", "nombre": "RXC13 HD2" },
        { "id": "5", "nombre": "RX CTC 1" },
        { "id": "6", "nombre": "RX1" },
        { "id": "7", "nombre": "RX2" },
        { "id": "8", "nombre": "RX3" },
        { "id": "9", "nombre": "RX4" },
        { "id": "10", "nombre": "RXCHF HD" },
        { "id": "11", "nombre": "IN CHF SDI" },
        { "id": "12", "nombre": "CHILEF VC" }
    ];
    $scope.receptorDataMicro = [{ "id": "1", "nombre": "RX CDF1" },
        { "id": "2", "nombre": "RX CDF1" }
    ];


    $scope.cambiaMedio = function(newVal, pos) {
        console.log(newVal, pos);
        if (newVal == 'satelital') {
            $scope.receptorData = [{ "id": "1", "nombre": "SATHD" }];

        }
        if (newVal == 'fibraoptica') {
            $scope.receptorData = [
                { "id": "1", "nombre": "RXHD 1 CLARO" },
                { "id": "2", "nombre": "RXHD 2 CLARO" },
                { "id": "3", "nombre": "RXC13 HD1" },
                { "id": "4", "nombre": "RXC13 HD2" },
                { "id": "5", "nombre": "RX CTC 1" },
                { "id": "6", "nombre": "RX1" },
                { "id": "7", "nombre": "RX2" },
                { "id": "8", "nombre": "RX3" },
                { "id": "9", "nombre": "RX4" },
                { "id": "10", "nombre": "RXCHF HD" },
                { "id": "11", "nombre": "IN CHF SDI" },
                { "id": "12", "nombre": "CHILEF VC" }
            ];
        }
        if (newVal == 'microondas') {
            $scope.receptorData = [{ "id": "1", "nombre": "RX CDF1" },
                { "id": "2", "nombre": "RX CDF1" }
            ];
        }
        if (newVal == 'otro') {
            $scope.receptorData = [{ "id": "1", "nombre": "SATHD" }];
        }
    };
    console.log('fibraoptica', $scope.posiciones);

    $scope.addInforme = function() {
        console.log('poraqui');
        /* $scope.loader = true;
         $scope.cargador = loader;
         $scope.formulario.transmision_senales_principal_senale_id = $scope.transmisionPosiciones["principal_meta"].senal;
         $scope.formulario.transmision_senales_respaldo_senale_id = $scope.transmisionPosiciones["respaldo_meta"].senal;
         $scope.formulario.radio = $scope.transmisionPosiciones["radio_meta"].senal;
         $scope.formulario.transmision_senales_respaldo_otro_senale_id = $scope.transmisionPosiciones["respaldo_otro_meta"].senal;
         $scope.formulario.respaldo_otro_meta = JSON.stringify($scope.formulario.respaldo_otro_meta);
         var formulario = $scope.formulario;*/
        console.log($scope.formulario);


        TransmisionService.listaPruebas($scope.formulario).success(function(data) {
            console.log('data', data);
            if (data.estado == 1) {
                Flash.create('success', data.mensaje, 'customAlert');
            } else {
                // $window.location = host + "videos/video";
            }
        });



    };

});