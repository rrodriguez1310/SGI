app.config(function(uiSelectConfig) {
    uiSelectConfig.appendToBody = true;
});
app.controller('mainTrabajadore', ['$scope', '$http', function($scope, $http) {
    $scope.trabajador = function(id, recursivo) {
        if (angular.isNumber(id)) {
            $http.get(host + 'trabajadores/trabajador/' + id + '/' + recursivo).
            success(function(data, status, headers, config) {
                $scope.$broadcast('trabajador', data);
            }).
            error(function(data, status, headers, config) {

            });
        }
    };
}]);

app.controller("imprimirContrato", function($scope, $http, $filter, $window, $q, localizacionesService, localizacionesFactory, documentosFactory, documentosService, servicios, trabajadoresService, tipoContratosPlantillasService, tipoContratosPlantillasFactory) {

    $scope.loader = true
    $scope.cargador = loader;
    $scope.idTrabajador = function(idTrabajdor) {
        trabajadoresService.trabajador(idTrabajdor).success(function(trabajadorData) {
            $scope.dataTrabajador = trabajadorData;
            promesas = [];
            promesas.push(tipoContratosPlantillasService.tipoContratosPlantillas());
            promesas.push(documentosService.documentosTrabajador(trabajadorData.Trabajadore.id));
            promesas.push(localizacionesService.localizacionesList());
            $q.all(promesas).then(function(data) {

                $scope.representantesLegales = servicios.representantesLegales();
                $scope.tipoContratos = tipoContratosPlantillasFactory.plantillasPorContrato(data[0].data.data, trabajadorData.Trabajadore.tipo_contrato_id);
                $scope.documentos = documentosFactory.documentosContratos(data[1].data);
                $scope.direcciones = localizacionesFactory.direcciones(data[2].data);
                $scope.loader = false;
                $scope.detalle = true;
            });
        });
    };

    var fecha = new Date();
    $scope.changeSelect = function() {
        $scope.inputSueldo = false;
        $scope.sueldo = undefined;
        $scope.inputFecha1Show = false;
        $scope.inputFechaVigencia = undefined;
        $scope.inputContratoOrigen = false;
        $scope.contratoOrigen = undefined;
        $scope.inputCargo = false;
        $scope.cargo = undefined;
        $scope.inputUbicacion = false;
        $scope.ubicacion_empresa = undefined;
        $scope.sueldoPalabras = undefined;
        $scope.representanteLegal = undefined;
        $scope.inputRepresentanteLegal = false;
        angular.element("#representanteLegal").select2('data', null);
        angular.element("#contratoOrigen").select2('data', null);
        angular.element("#ubicacion").select2('data', null);
        if (angular.isDefined($scope.form.tipos_documento_id)) {
            $scope.plantilla = tipoContratosPlantillasFactory.plantilla($scope.tipoContratos, $scope.form.tipos_documento_id);
            $scope.nombre = $scope.dataTrabajador.Trabajadore.nombre + " " + $scope.dataTrabajador.Trabajadore.apellido_paterno + " " + $scope.dataTrabajador.Trabajadore.apellido_materno;
            $scope.rut = $scope.dataTrabajador.Trabajadore.rut;
            $scope.fecha = $filter('date')(fecha.getFullYear() + "-" + ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" + ("0" + fecha.getDate()).slice(-2), "dd 'de' MMMM 'de' yyyy");
            $scope.inputRepresentanteLegal = true;
            if (angular.isString($scope.dataTrabajador.Nacionalidade.nombre)) {
                $scope.nacionalidad = $scope.dataTrabajador.Nacionalidade.nombre;
            } else {
                $scope.nacionalidad = "Sin Nacionalidad";
            }
            if (angular.isString($scope.dataTrabajador.EstadosCivile.nombre)) {
                $scope.estado_civil = $scope.dataTrabajador.EstadosCivile.nombre;
            } else {
                $scope.estado_civil = "Sin Estado Civil";
            }
            if (angular.isString($scope.dataTrabajador.Trabajadore.direccion)) {
                $scope.domicilio = $scope.dataTrabajador.Trabajadore.direccion;
            } else {
                $scope.domicilio = "Sin Domicilio";
            }
            if (angular.isString($scope.dataTrabajador.Comuna.comuna_nombre)) {
                $scope.comuna = $scope.dataTrabajador.Comuna.comuna_nombre;
            } else {
                $scope.comuna = "Sin Comuna";
            }
            if (angular.isString($scope.dataTrabajador.Trabajadore.fecha_nacimiento)) {
                $scope.fecha_nacimiento = $filter('date')($scope.dataTrabajador.Trabajadore.fecha_nacimiento, "dd 'de' MMMM 'de' yyyy");
            } else {
                $scope.fecha_nacimiento = "Sin Fecha Nacimiento";
            }
            if (angular.isString($scope.dataTrabajador.Trabajadore.fecha_ingreso)) {
                $scope.fecha_ingreso = $filter('date')($scope.dataTrabajador.Trabajadore.fecha_ingreso, "dd 'de' MMMM 'de' yyyy");
            } else {
                $scope.fecha_ingreso = "Sin Fecha de Ingreso";
            }
            if (angular.isString($scope.dataTrabajador.Cargo.nombre)) {
                $scope.cargo = $scope.dataTrabajador.Cargo.nombre
            } else {
                $scope.cargo = "Sin Cargo";
            }
            switch ($scope.form.tipos_documento_id) {
                case 1:
                case 23:
                    $scope.inputSueldo = true;
                    $scope.inputUbicacion = true;
                    break;
                case 24:
                case 25:

                    $scope.inputSueldo = true;
                    $scope.inputUbicacion = true;
                    $scope.inputMes = true;
                    break;

                case 8:
                case 6:
                    $scope.inputSueldo = true;
                    $scope.inputFecha1Show = true;
                    $scope.inputContratoOrigen = true;
                    break;
                case 5:
                    $scope.inputFecha1Show = true;
                    $scope.inputContratoOrigen = true;
                    $scope.inputCargo = true;
                    break;
            }
        }
    }

    $scope.$watch("inputFechaVigencia", function(nuevoValor, antiguoValor) {
        if (angular.isDefined(nuevoValor) && nuevoValor != "") {
            fecha1 = nuevoValor.split("/");
            $scope.fechaVigencia = fecha1[2] + "-" + fecha1[1] + "-" + fecha1[0];
        }
    });

    $scope.sumaMes = function(mes) {
        var mesFin = parseInt(fecha.getMonth()) + parseInt(mes) - parseInt(1);
        $scope.fechaFin = $filter('date')(fecha.getFullYear() + "-" + ("0" + (fecha.getMonth() + mesFin)).slice(-2) + "-" + ("0" + fecha.getDate()).slice(-2), "dd 'de' MMMM 'de' yyyy");
    }

    $scope.imprimirPlantilla = function() {

        parametros = {
            "nombre": "contrato_trabajador.pdf",
            "html": angular.element("#plantilla").html()
        }
        var imprimirHtml = $http({
            method: 'POST',
            url: host + 'servicios/pdf_basico',
            data: $.param(parametros)
        });

        imprimirHtml.success(function(data, status, headers, config) {
            $window.open(data);
        });
    }

    $scope.numeroPalabras = function() {

        var numeroPalabras = $http({
            method: 'GET',
            url: host + 'servicios/numeros_a_palabras',
            params: { numero: $scope.sueldo }
        });

        numeroPalabras.success(function(data, status, headers, config) {
            $scope.sueldoPalabras = data;
        });
    }
});

app.controller("view", ["$scope", "$http", "$sce", "$filter", "$window", function($scope, $http, $sce, $filter, $window) {

    $scope.imprimirFicha = function() {
        parametros = {
            "nombre": "ficha_trabajador.pdf",
            "html": angular.element("#ficha").html()
        }
        var imprimirHtml = $http({
            method: 'POST',
            url: host + 'servicios/pdf_basico',
            data: $.param(parametros)
        });

        imprimirHtml.success(function(data, status, headers, config) {
            $window.open(data);
        });
    }

}]);

app.controller('trabajadoresIndex', function($scope, $filter, uiGridConstants, trabajadoresService, servicios, trabajadoresFactory, $window, tipoContratosService, factoria) {

    $scope.host = host;
    $scope.templateFicha = host + "trabajadores/ficha_trabajador";
    $scope.loader = true
    $scope.cargador = loader;
    $scope.gridOptions = {
        enableGridMenu: true,
        exporterCsvFilename: 'trabajadores.csv',
        exporterPdfFilename: 'trabajadores.pdf',
        gridMenuShowHideColumns: false,
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        enableSelectAll: true,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        { name: 'id', displayName: 'id', width: 50 },
        { name: 'rut', displayName: 'rut' },
        { name: 'email', displayName: 'email' },
        { name: 'nombre', displayName: 'Nombre', sort: { direction: uiGridConstants.ASC, ignoreSort: true } },
        { name: 'apellido_paterno', displayName: 'Apellido Paterno', },
        { name: 'nombreCargo', displayName: 'Cargo', },
        { name: 'nombreArea', displayName: 'Aréa', },
        { name: 'nombreGerencia', displayName: 'Gerencia', },
        { name: 'tipoContrato', displayName: 'Tipo Contrato', cellFilter: "uppercase" },
        { name: 'telefono_emergencia', displayName: 'Telefono Emergencia', visible: true},
        { name: 'horario', displayName: 'Horario'},
        { name: 'estado', displayName: 'Estado' },
        {
            name: 'fecha_ingreso',
            displayName: 'Antiguedad Laboral'
        }
        
        
        
    ];
    tipoContratosService.tipoContratosList().success(function(tipoContratos) {
        $scope.tipoContratosList = factoria.arregloPorPropiedad(tipoContratos.data, "id");
        trabajadoresService.trabajadoresListado().success(function(data) {
            if (data.estado == 1) {
                listaTrabajadores = [];
                
                
                 
                
                
                angular.forEach(data.data, function(datos, llave) {
                    var dateOld = moment(datos.fecha_ingreso);
                    var dateToday = moment();
                    var years = dateToday.diff(dateOld, 'year');
                    dateOld.add(years, 'years');
                    var months = dateToday.diff(dateOld, 'months');
                    dateOld.add(months, 'months');
                    var days = dateToday.diff(dateOld, 'days');
                    dateOld.add(months, 'days');
                    listaTrabajadores.push({
                        id: datos.id,
                        rut: datos.rut,
                        email: datos.email,
                        nombre: datos.nombre,
                        apellido_paterno: datos.apellido_paterno,
                        nombreCargo: datos.nombreCargo,
                        nombreArea: datos.nombreArea,
                        nombreGerencia: datos.nombreGerencia,
                        tipoContrato: (angular.isDefined($scope.tipoContratosList[datos.tipo_contrato_id])) ? $scope.tipoContratosList[datos.tipo_contrato_id].nombre : "",
                        estado: datos.estado,
                        telefono_emergencia: datos.telefono_emergencia,
                        horario: datos.horario,
                        fecha_ingreso: datos.estado == "Activo" ? years + " años, " + months + " meses y " + days + " días" : "No aplica"
                    });
                });                
                $scope.gridOptions.data = listaTrabajadores;
                $scope.loader = false;
                $scope.tablaDetalle = true;
                $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
                    if (angular.isNumber(row.entity.id)) {
                        $scope.id = row.entity.id;
                    }
                    if (row.isSelected == true) {
                        $scope.boton = true;
                        trabajadoresService.trabajador($scope.id).success(function(data) {
                            $scope.trabajador = data;
                        });
                    } else {
                        $scope.boton = false;
                        $scope.id = "";
                    }
                });
                $scope.refreshData = function(termObj) {
                    $scope.gridOptions.data = listaTrabajadores;
                    while (termObj) {
                        var oSearchArray = termObj.split(' ');
                        $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                        oSearchArray.shift();
                        termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                    }
                };
            }
        });
    });

    $scope.imprimirFicha = function() {
        parametros = {
            "nombre": "ficha_trabajador.pdf",
            "html": angular.element("#ficha").html(),
            "margenLi": 0
        }
        servicios.pdfBasico(parametros).success(function(datos) {
            $window.open(datos);
        })
    };


});

app.controller('trabajadoresEdit', function($scope, $q, $filter, $timeout, $window, servicios, uiGridConstants, Flash, documentosService, trabajadoresService, areasFactory, cargosFactory, trabajadoresFactory, RutHelper) {
    $scope.validacionRut = true;
    watchEstado = false;
    angular.element(".tel_fijo").mask("(99) 9999-9999");
    angular.element(".tel_movil").mask("9999-9999");
    angular.element(".tool").tooltip();
    angular.element("#collapse1, #collapse2, #collapse3, #collapse4").collapse({ toggle: false });
    $scope.collapsePrimera = true;
    $scope.gridOptions = {
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        { name: 'fecha_inicial', displayName: 'Fecha doc.', sort: { direction: uiGridConstants.DESC }, width: "20%" },
        { name: 'nombre', displayName: 'Tipo documento', },
        { name: 'descripcion', displayName: 'Descripción', },
        { name: 'archivo', displayName: '', cellTemplate: "<div ng-if='row.entity.ruta!=null' class='text-center'><i class='fa fa-file-archive-o fa-lg'></i></div>", width: "10%" },
    ];

    angular.element("#trabajadoreFechaNacimiento").datepicker({
        format: "dd/mm/yyyy",
        startView: 1,
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        weekStart: 1
    });
    $scope.fechaTerminoLabel = 'Fecha termino';
    $scope.fechaFinalPlaceHolder = 'Seleccione fecha final';
    $scope.documentos = {};
    $scope.nuevaFechaIngreso = {};
    dataDocumentos = function(documentos) {
        $scope.gridOptions.data = [];
        angular.forEach(documentos, function(documento) {
            $scope.gridOptions.data.push({
                id: documento.Documento.id,
                fecha_inicial: documento.Documento.fecha_inicial,
                nombre: documento.TiposDocumento.nombre,
                descripcion: documento.Documento.descripcion,
                ruta: documento.Documento.ruta,
            });
        });
        documentosOriginal = $scope.gridOptions.data;
    }
    $scope.$watch("idTrabajador", function(nuevoValor, antiguoValor) {
        $scope.editshow = false;
        $scope.loader = true
        $scope.cargador = loader;
        if (angular.isDefined(nuevoValor)) {
            promesas = [];
            promesas.push(trabajadoresService.trabajador(nuevoValor));
            promesas.push(trabajadoresService.selectTrabajadores());
            promesas.push(documentosService.documentosTrabajador(nuevoValor));
            $q.all(promesas).then(function(data) {
                angular.element('.datepicker').datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    multidate: false,
                    autoclose: true,
                    required: true,
                    weekStart: 1
                });
                $scope.loader = false;
                $scope.editshow = true;
                dataDocumentos(data[2].data);
                data[0].data.Trabajadore.fecha_nacimiento = $filter('date')(data[0].data.Trabajadore.fecha_nacimiento, "dd/MM/yyyy");
                data[0].data.Trabajadore.fecha_ingreso = $filter('date')(data[0].data.Trabajadore.fecha_ingreso, "dd/MM/yyyy");
                data[0].data.Trabajadore.fecha_indefinido = $filter('date')(data[0].data.Trabajadore.fecha_indefinido, "dd/MM/yyyy");
                $scope.nacionalidadesList = data[1].data.Nacionalidades.data;
                $scope.comunasList = data[1].data.Comunas.data;
                $scope.sistemaPensionesList = data[1].data.SistemaPensiones.data;
                $scope.sistemaPrevisionesList = data[1].data.SistemaPrevisiones.data;
                $scope.nivelEducacionsList = data[1].data.NivelEducacional.data;
                $scope.gerenciasList = data[1].data.Gerencias.data;
                $scope.jefesList = trabajadoresFactory.trabajadoresList(data[1].data.TrabajadoresListado.data);
                $scope.localizacionesList = data[1].data.Localizaciones.data;
                $scope.horariosList = data[1].data.Horarios.data;
                $scope.tipoContratosList = data[1].data.TipoContratos.data;
                $scope.tiposDocumentosList = trabajadoresFactory.trabajadoresTiposDocumentosList(data[1].data.TiposDocumentos.data);
                $scope.motivoRetirosList = data[1].data.MotivoRetiros.data;
                $scope.tiposMonedasList = trabajadoresFactory.tipoMonedasSalud(data[1].data.TiposModenas.data);
                $scope.dimensionesList = trabajadoresFactory.dimensionesTrabajador(data[1].data.Dimensiones);
                $scope.bancosList = data[1].data.Bancos.data;
                $scope.tiposCuentaBancosList = data[1].data.TiposCuentasBancos.data;
                $scope.estadoCivilList = data[1].data.EstadosCiviles;
                $scope.sexosList = servicios.sexo();
                $scope.estadosList = trabajadoresService.estadosTrabajador();
                angular.element("#collapseOne, #collapseTwo, #collapseThree").addClass('collapse');
                $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
                    if (angular.isNumber(row.entity.id)) {
                        $scope.idDocumento = row.entity.id;
                        $scope.subirArchivoGrid = row.entity.id;
                    }
                    if (row.isSelected == true) {
                        $scope.boton = true;
                        if (row.entity.ruta != null) {
                            $scope.btnDownload = true;
                            $scope.btnSubirArchivo = false;
                            $scope.rutaArchivo = row.entity.ruta;
                        } else {
                            $scope.btnDownload = false;
                            $scope.btnSubirArchivo = true;
                        }
                    } else {
                        $scope.btnSubirArchivo = false;
                        $scope.btnDownload = false;
                        $scope.boton = false;
                        $scope.idDocumento = undefined;
                    }
                });
                $scope.refreshData = function(termObj) {
                    $scope.gridOptions.data = documentosOriginal;
                    while (termObj) {
                        var oSearchArray = termObj.split(' ');
                        $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                        oSearchArray.shift();
                        termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                    }
                };
                $scope.cambioGerencia = function(gerencia, limpia) {
                    $scope.areasList = areasFactory.areasGerencia(data[1].data.Areas.data, gerencia.id);
                    if (limpia) {
                        $scope.formulario.Cargo.area_id = undefined;
                        $scope.formulario.Trabajadore.cargo_id = undefined;
                    }

                };
                $scope.cambioArea = function(area, limpia) {
                    $scope.cargosList = cargosFactory.cargosArea(data[1].data.Cargos.data, area.id);
                    if (limpia) {
                        $scope.formulario.Trabajadore.cargo_id = undefined;
                    }
                };
                $scope.cambioJefe = function(trabajador) {
                    $scope.formulario.Trabajadore.jefe_id = trabajador.id;
                };
                if (angular.isNumber(data[0].data.Trabajadore.cargo_id)) {
                    $scope.cambioGerencia({ id: data[0].data.Cargo.Area.gerencia_id }, false);
                    $scope.cambioArea({ id: data[0].data.Cargo.area_id }, false);
                }
                $scope.formulario = data[0].data;
                $timeout(function() {
                    // Esto es así porque si no javascript lo hace el cambio antes que se ejecute el watch de la directiva, asi previee formatear el valor original a un rut
                    $scope.validacionRut = false;
                }, 1000);
                var rutOriginal = data[0].data.Trabajadore.rut;
                $scope.tipoContrato = data[0].data.Trabajadore.tipo_contrato_id;
                $scope.nombre = data[0].data.Trabajadore.nombre + " " + data[0].data.Trabajadore.apellido_paterno;
                $scope.formulario.Trabajadore.jefe_id = data[0].data.Jefe.trabajadore_id;
                $scope.mensajeError = function() {
                    if (!$scope.trabajadoresEdit.$valid) {
                        var message = 'Requeridos: <ul>';
                        angular.forEach($scope.trabajadoresEdit.$error.required, function(requeridos) {
                            message += "<li>" + requeridos.$name.replace("_", " ") + "</li>";
                        });
                        message += "</ul>";
                        Flash.create('danger', message, 'customAlert');
                    }
                };

                $scope.editarTrabajador = function() {
                    if ($scope.validacionRut === false) {
                        $scope.formulario.Trabajadore.rut = RutHelper.format($scope.formulario.Trabajadore.rut);
                    }
                    formulario = {
                        Trabajadore: $scope.formulario.Trabajadore,
                        CuentasCorriente: $scope.formulario.CuentasCorriente
                    }
                    if (formulario.Trabajadore.fecha_indefinido != null) {
                        fechaIndefino = formulario.Trabajadore.fecha_indefinido.split("/");
                        formulario.Trabajadore.fecha_indefinido = [fechaIndefino[2], fechaIndefino[1], fechaIndefino[0]].join("-");
                    }
                    trabajadoresService.editarTrabajador(formulario).success(function(data) {
                        switch (data.estado) {
                            case 1:
                                $window.location = host + "trabajadores";
                                break;
                            case 0:
                                Flash.create('danger', data.mensaje, 'customAlert');
                                break;
                        }
                    });
                };

                $scope.cambioTiposDocumentoId = function(tipoDocumento) {
                    $scope.indefinido = 0;
                    angular.element("[name='file']").val("");
                    $scope.documentos.Documento.fecha_inicial = undefined;
                    $scope.documentos.Documento.fecha_final = undefined;
                    $scope.documentos.Documento.descripcion = undefined;
                    $scope.documentos.Documento.archivo = undefined;
                    (angular.isDefined($scope.documentos.Retiro)) ? $scope.documentos.Retiro = undefined: "";
                    $scope.showIndefinido = false;
                    $scope.fechaTermino = false;
                    $scope.motivoRetiro = false;
                    $scope.showIndefinido = false;
                    $scope.fechaTermino = false;
                    $scope.motivoRetiro = false;
                    $scope.descripcionLabel = "Descripción";
                    $scope.fechaTerminoLabel = "Fecha termino";
                    $scope.fechaFinalPlaceHolder = "Seleccione fecha final";
                    if (angular.isDefined(tipoDocumento)) {
                        switch (tipoDocumento.id) {
                            case 10:
                                $scope.descripcionLabel = "Descripción de retiro";
                                $scope.fechaTerminoLabel = "Fecha Retiro";
                                $scope.fechaFinalPlaceHolder = "Seleccione fecha de retiro";
                                $scope.fechaTermino = true;
                                $scope.motivoRetiro = true;
                                break;
                            case 2:
                            case 3:
                            case 24:
                            case 25:
                                $scope.fechaTermino = true;
                                break;
                            case 1:
                            case 23:
                            case 28:
                            case 4:
                            case 29:
                                $scope.fechaTermino = true;
                                $scope.fechaTerminoLabel = "Inicio plazo indefinido";
                                $scope.fechaFinalPlaceHolder = "Seleccione un inicio indefinido";
                                break;
                            default:
                                $scope.showIndefinido = false;
                                $scope.fechaTermino = false;
                                $scope.motivoRetiro = false;
                                $scope.descripcionLabel = "Descripción";
                                $scope.fechaTerminoLabel = "Fecha termino";
                                $scope.fechaFinalPlaceHolder = "Seleccione fecha final";
                        }
                    }
                };

                $scope.subirArchivo = function() {

                    documentoVerificacion = true;
                    trabajadoresService.comprobarDocTrabajadorUpload($scope.formulario.Trabajadore.id, $scope.documentos.Documento.tipos_documento_id, $scope.documentos.Documento.fecha_inicial).success(function(data) {
                        if (data.estado == 1) {
                            var c = confirm("Se encontro un documento ingresado del mismo tipo y fecha\n¿Desea que sea ingresado de todas formas?");
                            if (!c) {
                                documentoVerificacion = false;
                            }
                        }
                        if (documentoVerificacion) {
                            formulario = {
                                Trabajadore: {
                                    id: $scope.formulario.Trabajadore.id,
                                }
                            };
                            if (angular.isDefined($scope.documentos.Documento.fecha_final)) {
                                fechaIndefino = $scope.documentos.Documento.fecha_final.split("/");
                                formulario.Trabajadore.fecha_indefinido = [fechaIndefino[2], fechaIndefino[1], fechaIndefino[0]].join("-");
                            }
                            switch ($scope.documentos.Documento.tipos_documento_id) {
                                case 4:
                                    $scope.formulario.Trabajadore.fecha_indefinido = $scope.documentos.Documento.fecha_final;
                                    delete $scope.documentos.Documento.fecha_final;
                                    if ($scope.tipoContrato != 4) {
                                        var r = confirm("El actual contrato de " + $scope.nombre + ", no es part-time.\n Se cambiara el tipo de contrato a part-time");
                                        if (r == true) {
                                            formulario.Trabajadore.tipo_contrato_id = 4;
                                            trabajadoresService.cambiarContrato(formulario).success(function(data) {
                                                if (data.mensaje == 1) {
                                                    $scope.formulario.Trabajadore.tipo_contrato_id = 4;
                                                    message = "Se ha cambiado el tipo de contrato a " + $scope.nombre;
                                                    Flash.create('success', message, 'customAlert');
                                                } else {
                                                    message = "No se ha podido cambiar el tipo de contrato a " + $scope.nombre;
                                                    Flash.create('danger', message, 'customAlert');
                                                }
                                            });
                                        }
                                    }
                                    break;
                                case 24:
                                case 25:
                                    if ($scope.tipoContrato != 2) {
                                        var r = confirm("El actual contrato de " + $scope.nombre + ", no es de plazo fijo.\n Se cambiara el tipo de contrato a plaza fijo");
                                        if (r == true) {
                                            formulario.Trabajadore.tipo_contrato_id = 2;
                                            trabajadoresService.cambiarContrato(formulario).success(function(data) {
                                                if (data.mensaje == 1) {
                                                    $scope.formulario.Trabajadore.tipo_contrato_id = 2;
                                                    message = "Se ha cambiado el tipo de contrato a " + $scope.nombre;
                                                    Flash.create('success', message, 'customAlert');
                                                } else {
                                                    message = "No se ha podido cambiar el tipo de contrato a " + $scope.nombre;
                                                    Flash.create('danger', message, 'customAlert');
                                                }
                                            });
                                        }
                                    }
                                    break;
                                case 1:
                                case 23:
                                case 28:
                                    $scope.formulario.Trabajadore.fecha_indefinido = $scope.documentos.Documento.fecha_final;
                                    delete $scope.documentos.Documento.fecha_final;
                                    if ($scope.tipoContrato != 1) {
                                        var r = confirm("El actual contrato de " + $scope.nombre + ", no es indefinido.\n Se cambiara el tipo de contrato a indefinido");
                                        if (r == true) {
                                            formulario.Trabajadore.tipo_contrato_id = 1;
                                            trabajadoresService.cambiarContrato(formulario).success(function(data) {
                                                if (data.mensaje == 1) {
                                                    $scope.formulario.Trabajadore.tipo_contrato_id = 1;
                                                    message = "Se ha cambiado el tipo de contrato a " + $scope.nombre;
                                                    Flash.create('success', message, 'customAlert');
                                                } else {
                                                    message = "No se ha podido cambiar el tipo de contrato a " + $scope.nombre;
                                                    Flash.create('danger', message, 'customAlert');
                                                }
                                            });
                                        }
                                    }
                                    break;
                            }
                            documento = {
                                "Documento": {
                                    "trabajadore_id": $scope.formulario.Trabajadore.id,
                                    "tipos_documento_id": $scope.documentos.Documento.tipos_documento_id,
                                    "fecha_inicial": $scope.documentos.Documento.fecha_inicial
                                },
                                "archivo": $scope.documentos.Documento.archivo
                            }
                            if (angular.isDefined($scope.documentos.Documento.fecha_final)) {
                                documento.Documento["fecha_final"] = $scope.documentos.Documento.fecha_final;
                            }
                            if (angular.isDefined($scope.documentos.Documento.descripcion)) {
                                documento.Documento["descripcion"] = $scope.documentos.Documento.descripcion;
                            }
                            documentosService.uploadDocumentoTrabajador(documento).success(function(data) {
                                if (data.estado == 1) {
                                    message = "Se subio el documento correctamente";
                                    tipoMensaje = "success";
                                    if ($scope.documentos.Documento.tipos_documento_id == 10) {
                                        retiro = {
                                            "Retiro": {
                                                "trabajadore_id": $scope.formulario.Trabajadore.id,
                                                "fecha_retiro": $scope.documentos.Documento.fecha_inicial,
                                                "motivo_retiro_id": $scope.documentos.Retiro.motivo_retiro,
                                                'documento_id': data.mensaje
                                            }
                                        };
                                        if (angular.isDefined($scope.documentos.Documento.descripcion)) {
                                            retiro.Retiro["descripcion"] = $scope.documentos.Documento.descripcion;
                                        }
                                        trabajadoresService.retiroTrabajador(retiro).success(function(data) {
                                            if (data.estado == 1) {
                                                message += "<br/>Se cambio a " + $scope.nombre + " a estado Retirado";
                                                $scope.formulario.Trabajadore.estado = "Retirado";
                                            } else {
                                                tipoMensaje = "warning";
                                                message += "<br/>No se pudo cambiar a " + $scope.nombre + " a estado Retirado";
                                            }
                                            documentosService.documentosTrabajador(nuevoValor).success(function(datos) {
                                                dataDocumentos(datos);
                                                //$scope.gridOptions.data = datos;
                                                $scope.gridApi.selection.clearSelectedRows();
                                                $scope.btnSubirArchivo = false;
                                                $scope.btnDownload = false;
                                                $scope.boton = false;
                                                Flash.create(tipoMensaje, message, 'customAlert');
                                            });
                                        });
                                    } else {
                                        documentosService.documentosTrabajador(nuevoValor).success(function(data) {
                                            dataDocumentos(data);
                                            //$scope.gridOptions.data = data;
                                            $scope.gridApi.selection.clearSelectedRows();
                                            Flash.create(tipoMensaje, message, 'customAlert');
                                        });
                                    }
                                    $scope.fechaTermino = false;
                                    $scope.motivoRetiro = false;
                                    $scope.documentos.Documento.tipos_documento_id = undefined;
                                    $scope.cambioTiposDocumentoId(undefined);
                                    angular.element("[name='file']").val("");
                                    documentosService.documentosTrabajador(nuevoValor).success(function(data) {
                                        dataDocumentos(data);
                                        //$scope.gridOptions.data = data;
                                        $scope.gridApi.selection.clearSelectedRows();
                                    });
                                } else {
                                    Flash.create('danger', data.mensaje, 'customAlert');
                                }
                            });
                        }
                    });
                };

                $scope.uploadFoto = function() {
                    if ($scope.foto.archivo.length != 0) {
                        trabajadoresService.uploadFotoTrabajador($scope.formulario.Trabajadore.id, $scope.foto.archivo).success(function(data) {
                            if (data.estado == 1) {
                                $scope.foto.archivo = undefined;
                                $scope.foto.archivo = [];
                                $scope.formulario.Trabajadore.foto = data.data + "?" + (new Date().getTime());
                                Flash.create("success", data.mensaje, 'customAlert');
                            } else {
                                $scope.foto.archivo = undefined;
                                $scope.foto.archivo = [];
                                Flash.create("danger", data.mensaje, 'customAlert');
                            }
                        });
                    }
                };
                
                $scope.uploadDescripcion = function() {
                    if ($scope.documentos.descripcion.length != 0) {
                        trabajadoresService.uploadDescripcionCargo($scope.formulario.Trabajadore.id, $scope.documentos.descripcion).success(function(data) {
                            console.log(data);
                            
                            
                            if (data.estado == 1) {
                                Flash.create("success", 'registrado con exito', 'customAlert');
                            } else {
                                Flash.create("danger", 'no se pudo registrar', 'customAlert');
                            }
                            

                        });
                    }
                };

                $scope.collapsePersona = function() {
                    if (angular.element("#collapseOne").hasClass("in")) {
                        angular.element("#collapseOne").collapse("hide");
                    } else {
                        angular.element("#collapseOne").collapse("show");
                        if (angular.element("#collapseTwo").hasClass("in")) {
                            angular.element("#collapseTwo").collapse("hide");
                        }
                        if (angular.element("#collapseThree").hasClass("in")) {
                            angular.element("#collapseThree").collapse("hide");
                        }
                    }
                };

                $scope.collapseEmpresa = function() {
                    if (angular.element("#collapseTwo").hasClass("in")) {
                        angular.element("#collapseTwo").collapse("hide");
                    } else {
                        angular.element("#collapseTwo").collapse("show");
                        if (angular.element("#collapseOne").hasClass("in")) {
                            angular.element("#collapseOne").collapse("hide");
                        }
                        if (angular.element("#collapseThree").hasClass("in")) {
                            angular.element("#collapseThree").collapse("hide");
                        }
                    }
                };

                $scope.collapseDocumento = function() {
                    if (angular.element("#collapseThree").hasClass("in")) {
                        angular.element("#collapseThree").collapse("hide");
                    } else {
                        angular.element("#collapseThree").collapse("show");
                        if (angular.element("#collapseTwo").hasClass("in")) {
                            angular.element("#collapseTwo").collapse("hide");
                        }
                        if (angular.element("#collapseOne").hasClass("in")) {
                            angular.element("#collapseOne").collapse("hide");
                        }
                    }
                };
                
                $scope.collapseDescripcion = function() {
                    if (angular.element("#collapseCuatro").hasClass("in")) {
                        angular.element("#collapseCuatro").collapse("hide");
                    } else {
                        angular.element("#collapseCuatro").collapse("show");
                        
                        if (angular.element("#collapseThree").hasClass("in")) {
                            angular.element("#collapseThree").collapse("hide");
                        }

                        if (angular.element("#collapseTwo").hasClass("in")) {
                            angular.element("#collapseTwo").collapse("hide");
                        }
                        
                        if (angular.element("#collapseOne").hasClass("in")) {
                            angular.element("#collapseOne").collapse("hide");
                        }
                    }
                };

                $scope.subirDocumentoGrid = function(idDocumento) {
                    if (angular.isDefined($scope.documentoGrid[0])) {
                        archivo = {
                            id: $scope.subirArchivoGrid,
                            file: $scope.documentoGrid
                        };
                        documentosService.uploadArchivoTrabajador(archivo).success(function(data) {
                            if (data.estado == 1) {
                                documentosService.documentosTrabajador(nuevoValor).success(function(datos) {
                                    dataDocumentos(datos);
                                    //$scope.gridOptions.data = datos;
                                    $scope.gridApi.selection.clearSelectedRows();
                                    $scope.btnSubirArchivo = false;
                                    $scope.btnDownload = false;
                                    $scope.boton = false;
                                    Flash.create("success", data.mensaje, 'customAlert');
                                });
                            } else {
                                Flash.create('danger', data.mensaje, 'customAlert');
                            }
                        });
                    }
                }
                $scope.validaRut = function() {
                    if (angular.isDefined($scope.formulario.Trabajadore.rut)) {
                        if ($scope.validacionRut === false) {
                            $scope.formulario.Trabajadore.rut = RutHelper.format($scope.formulario.Trabajadore.rut);
                        }
                        if ($scope.formulario.Trabajadore.rut != rutOriginal) {
                            trabajadoresService.validaRut($scope.formulario.Trabajadore.rut).success(function(data) {
                                if (data.estado == 1) {
                                    angular.element("#TrabajadoreRut").focus();
                                    $scope.formulario.Trabajadore.rut = undefined;
                                    Flash.create('danger', data.mensaje, 'customAlert');
                                }
                            });
                        }
                    }
                };
                $scope.documentoDelete = function(idDocumento) {
                    c = confirm("¿Seguro quieres eliminar el documento?");
                    if (c) {
                        documentosService.documentoDelete(idDocumento).success(function(data) {
                            if (data.estado == 1) {
                                documentosService.documentosTrabajador(nuevoValor).success(function(datos) {
                                    dataDocumentos(datos);
                                    //$scope.gridOptions.data = datos;
                                    $scope.gridApi.selection.clearSelectedRows();
                                    $scope.btnSubirArchivo = false;
                                    $scope.btnDownload = false;
                                    $scope.boton = false;
                                    Flash.create('success', data.mensaje, 'customAlert');
                                });
                            } else {
                                Flash.create('danger', data.mensaje, 'customAlert');
                            }
                        });
                    }
                };

                $scope.$watch("formulario.Trabajadore.estado", function(nuevoValor, antiguoValor) {
                    if (watchEstado) {
                        if ($scope.formulario.Trabajadore.estado == 'Activo') {
                            $scope.titulo = "Cambiar estado";
                            $scope.showModal = true;
                            $scope.guardarCambioEstado = function() {
                                formulario = {
                                    id: $scope.formulario.Trabajadore.id,
                                    estado: "Activo",
                                    fecha_ingreso: $scope.nuevaFechaIngreso.fecha_ingreso,
                                }
                                trabajadoresService.activarTrabajador(formulario).success(function(data) {
                                    if (data.estado == 1) {
                                        $scope.formulario.Trabajadore.fecha_ingreso = $scope.nuevaFechaIngreso.fecha_ingreso;
                                        $scope.formulario.Trabajadore.estado = nuevoValor;
                                        $scope.showModal = false;
                                        $scope.nuevaFechaIngreso.fecha_ingreso = undefined;
                                        Flash.create('success', "Se cambio el estado correctamente", 'customAlert');
                                    } else {
                                        $scope.formulario.Trabajadore.estado = antiguoValor;
                                        Flash.create('danger', "No se pudo cambiar el estado, por favor intentelo nuevamente", 'customAlert');
                                    }
                                });
                            };
                        }
                        $scope.cerrarModal = function() {
                            $scope.showModal = false;
                            $scope.nuevaFechaIngreso.fecha_ingreso = undefined;
                            $scope.formulario.Trabajadore.estado = antiguoValor;
                        }
                    } else {
                        watchEstado = true;
                    }
                });
            });

        }
    });
    $scope.quitarValidarut = function() {
        if ($scope.validacionRut == true) {
            confirmacion = confirm("¿Seguro deseas quitar la validación del rut?");
            if (!confirmacion) {
                $scope.validacionRut = false;
            }
        }
    }

    $scope.cambioFechaInicial = function() {
        if (typeof $scope.documentos.Documento.tipos_documento_id !== 'undefined') {
            switch ($scope.documentos.Documento.tipos_documento_id) {
                case 1:
                case 23:
                case 28:
                    if (typeof $scope.documentos.Documento.fecha_final === 'undefined') {
                        $scope.documentos.Documento.fecha_final = $scope.documentos.Documento.fecha_inicial;
                    }
                    break;
            }
        }
    }
});

app.controller('trabajadoresPerfil', function($scope, $q, $filter, $window, servicios, Flash, documentosService, tipoContratosService, horariosService, localizacionesService, trabajadoresService, nacionalidadesService, comunasService, sistemaPensionesService, sistemaPrevisionesService, nivelEducacionsService, cargosService, areasService, gerenciasService, areasFactory, cargosFactory, trabajadoresFactory, RutHelper) {

    watchEstado = false;
    angular.element(".tool").tooltip();
    angular.element("#collapse1, #collapse2, #collapse3").collapse({ toggle: false });
    $scope.collapsePrimera = true;

    angular.element("#trabajadoreFechaNacimiento").datepicker({
        format: "dd/mm/yyyy",
        startView: 1,
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        weekStart: 1
    });

    $scope.$watch("idTrabajador", function(nuevoValor, antiguoValor) {
        $scope.editshow = false;
        $scope.loader = true
        $scope.cargador = loader;
        if (angular.isDefined(nuevoValor)) {
            promesas = [];
            promesas.push(trabajadoresService.trabajador(nuevoValor));
            promesas.push(trabajadoresService.selectTrabajadores());
            promesas.push(documentosService.documentosTrabajador(nuevoValor));
            $q.all(promesas).then(function(data) {
                angular.element('.datepicker').datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    multidate: false,
                    autoclose: true,
                    required: true,
                    weekStart: 1
                });
                $scope.loader = false;
                $scope.editshow = true;
                data[0].data.Trabajadore.fecha_nacimiento = $filter('date')(data[0].data.Trabajadore.fecha_nacimiento, "dd/MM/yyyy");
                data[0].data.Trabajadore.fecha_ingreso = $filter('date')(data[0].data.Trabajadore.fecha_ingreso, "dd/MM/yyyy");
                data[0].data.Trabajadore.fecha_indefinido = $filter('date')(data[0].data.Trabajadore.fecha_indefinido, "dd/MM/yyyy");
                $scope.nacionalidadesList = data[1].data.Nacionalidades.data;
                $scope.comunasList = data[1].data.Comunas.data;
                $scope.sistemaPensionesList = data[1].data.SistemaPensiones.data;
                $scope.sistemaPrevisionesList = data[1].data.SistemaPrevisiones.data;
                $scope.nivelEducacionsList = data[1].data.NivelEducacional.data;
                $scope.gerenciasList = data[1].data.Gerencias.data;
                $scope.jefesList = trabajadoresFactory.trabajadoresList(data[1].data.TrabajadoresListado.data);
                $scope.localizacionesList = data[1].data.Localizaciones.data;
                $scope.horariosList = data[1].data.Horarios.data;
                $scope.tipoContratosList = data[1].data.TipoContratos.data;
                $scope.tiposDocumentosList = trabajadoresFactory.trabajadoresTiposDocumentosList(data[1].data.TiposDocumentos.data);
                $scope.motivoRetirosList = data[1].data.MotivoRetiros.data;
                $scope.documentosList = data[2].data;
                $scope.tiposMonedasList = trabajadoresFactory.tipoMonedasSalud(data[1].data.TiposModenas.data);
                $scope.dimensionesList = trabajadoresFactory.dimensionesTrabajador(data[1].data.Dimensiones);
                $scope.bancosList = data[1].data.Bancos.data;
                $scope.tiposCuentaBancosList = data[1].data.TiposCuentasBancos.data;
                $scope.estadoCivilList = data[1].data.EstadosCiviles;
                $scope.sexosList = servicios.sexo();
                $scope.estadosList = trabajadoresService.estadosTrabajador();
                $scope.cambioGerencia = function(gerencia, limpia) {
                    $scope.areasList = areasFactory.areasGerencia(data[1].data.Areas.data, gerencia.id);
                    if (limpia) {
                        $scope.formulario.Cargo.area_id = undefined;
                        $scope.formulario.Trabajadore.cargo_id = undefined;
                    }

                };
                $scope.cambioArea = function(area, limpia) {
                    $scope.cargosList = cargosFactory.cargosArea(data[1].data.Cargos.data, area.id);
                    if (limpia) {
                        $scope.formulario.Trabajadore.cargo_id = undefined;
                    }
                };
                if (angular.isNumber(data[0].data.Trabajadore.cargo_id)) {
                    $scope.cambioGerencia({ id: data[0].data.Cargo.Area.gerencia_id }, false);
                    $scope.cambioArea({ id: data[0].data.Cargo.area_id }, false);
                }
                $scope.formulario = data[0].data;
                $scope.tipoContrato = data[0].data.Trabajadore.tipo_contrato_id;
                $scope.nombre = data[0].data.Trabajadore.nombre + " " + data[0].data.Trabajadore.apellido_paterno;
                $scope.formulario.Trabajadore.jefe_id = data[0].data.Jefe.trabajadore_id;

                $scope.formulario.Cargo.descripcion_cargo;
                var carpetaArr = $scope.formulario.Cargo.descripcion_cargo.split(".");
                var largoCarpetaArr = carpetaArr.length;
                carpetaArr[largoCarpetaArr-1] = 'pdf';
                $scope.nombrePdf = carpetaArr.join(".");      

                angular.element("#collapseOne, #collapseTwo, #collapseThree").addClass('collapse');
                $scope.mensajeError = function() {
                    if (!$scope.trabajadoresEdit.$valid) {
                        var message = 'Requeridos: <ul>';
                        angular.forEach($scope.trabajadoresEdit.$error.required, function(requeridos) {
                            message += "<li>" + requeridos.$name.replace("_", " ") + "</li>";
                        });
                        message += "</ul>";
                        Flash.create('danger', message, 'customAlert');
                    }
                };

                $scope.editarTrabajador = function() {
                    $scope.formulario.Trabajadore.rut = RutHelper.format($scope.formulario.Trabajadore.rut);
                    // $scope.formulario.Trabajadore.rut = $scope.formulario.Trabajadore.rut;
                    trabajadoresService.editarTrabajador($scope.formulario).success(function(data) {
                        switch (data.estado) {
                            case 1:
                                $window.location = host + "dashboards";
                                break;
                            case 0:
                                Flash.create('danger', data.mensaje, 'customAlert');
                                break;
                        }
                    });
                };

                $scope.uploadFoto = function() {
                    if ($scope.foto.archivo.length != 0) {
                        trabajadoresService.uploadFotoTrabajador($scope.formulario.Trabajadore.id, $scope.foto.archivo).success(function(data) {
                            if (data.estado == 1) {
                                $scope.foto.archivo = undefined;
                                $scope.foto.archivo = [];
                                $scope.formulario.Trabajadore.foto = data.data + "?" + (new Date().getTime());
                                Flash.create("success", data.mensaje, 'customAlert');
                            } else {
                                $scope.foto.archivo = undefined;
                                $scope.foto.archivo = [];
                                Flash.create("danger", data.mensaje, 'customAlert');
                            }
                        });
                    }
                };

                $scope.collapsePersona = function() {
                    if (angular.element("#collapseOne").hasClass("in")) {
                        angular.element("#collapseOne").collapse("hide");
                    } else {
                        angular.element("#collapseOne").collapse("show");
                        if (angular.element("#collapseTwo").hasClass("in")) {
                            angular.element("#collapseTwo").collapse("hide");
                        }
                        if (angular.element("#collapseThree").hasClass("in")) {
                            angular.element("#collapseThree").collapse("hide");
                        }
                    }
                };

                $scope.collapseEmpresa = function() {
                    if (angular.element("#collapseTwo").hasClass("in")) {
                        angular.element("#collapseTwo").collapse("hide");
                    } else {
                        angular.element("#collapseTwo").collapse("show");
                        if (angular.element("#collapseOne").hasClass("in")) {
                            angular.element("#collapseOne").collapse("hide");
                        }
                        if (angular.element("#collapseThree").hasClass("in")) {
                            angular.element("#collapseThree").collapse("hide");
                        }
                    }
                };

                $scope.collapseDocumento = function() {
                    if (angular.element("#collapseThree").hasClass("in")) {
                        angular.element("#collapseThree").collapse("hide");
                    } else {
                        angular.element("#collapseThree").collapse("show");
                        if (angular.element("#collapseTwo").hasClass("in")) {
                            angular.element("#collapseTwo").collapse("hide");
                        }
                        if (angular.element("#collapseOne").hasClass("in")) {
                            angular.element("#collapseOne").collapse("hide");
                        }
                    }
                };
            });

        }
    });
});

app.controller('trabajadoresAdd', function($scope, $q, $window, Flash, trabajadoresService, cargosService, areasService, gerenciasService, areasFactory, cargosFactory, trabajadoresFactory, RutHelper) {

    $scope.formulario = {};
    $scope.formulario.Trabajadore = {};
    $scope.formulario.Cargo = {};
    $scope.formulario.Trabajadore.cargo_id = {};
    $scope.formulario.Cargo.area_id = {};
    $scope.formulario.Cargo.area_id = undefined;
    $scope.formulario.Trabajadore.cargo_id = undefined;
    angular.element(".tool").tooltip();
    angular.element("#trabajadoreFechaNacimiento").datepicker({
        format: "dd/mm/yyyy",
        startView: 1,
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        weekStart: 1
    });
    angular.element('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        weekStart: 1
    });

    $scope.editshow = false;
    $scope.loader = true
    $scope.cargador = loader;
    promesas = [];
    promesas.push(cargosService.cargosList());
    promesas.push(areasService.areasList());
    promesas.push(gerenciasService.gerenciasList());
    $q.all(promesas).then(function(data) {
        $scope.loader = false;
        $scope.editshow = true;
        $scope.gerenciasList = data[2].data.data;
        $scope.estadosList = trabajadoresService.estadosTrabajador();
        $scope.cambioGerencia = function(gerencia, limpia) {
            if (angular.isDefined(gerencia)) {
                $scope.areasList = areasFactory.areasGerencia(data[1].data.data, gerencia.id);
                $scope.formulario.Cargo.area_id = undefined;
                $scope.formulario.Trabajadore.cargo_id = undefined;
            } else {
                $scope.formulario.Cargo.area_id = undefined;
                $scope.formulario.Trabajadore.cargo_id = undefined;
                $scope.areasList = undefined;
                $scope.cargosList = undefined;
            }
        };
        $scope.cambioArea = function(area, limpia) {
            if (angular.isDefined(area)) {
                $scope.cargosList = cargosFactory.cargosArea(data[0].data.data, area.id);
                $scope.formulario.Trabajadore.cargo_id = undefined;
            } else {
                $scope.formulario.Trabajadore.cargo_id = undefined;
                $scope.cargosList = undefined;
                $scope.formulario.Trabajadore.cargo_id = undefined;
            }
        };
        $scope.mensajeError = function() {
            if (!$scope.trabajadoresEdit.$valid) {
                var message = 'Requeridos: <ul>';
                angular.forEach($scope.trabajadoresEdit.$error.required, function(requeridos) {
                    message += "<li>" + requeridos.$name.replace("_", " ") + "</li>";
                });
                message += "</ul>";
                Flash.create('danger', message, 'customAlert');
            }
        };
    });

    $scope.validaRut = function() {
        if (angular.isDefined($scope.formulario.Trabajadore.rut)) {
            $scope.formulario.Trabajadore.rut = RutHelper.format($scope.formulario.Trabajadore.rut);
            trabajadoresService.validaRut($scope.formulario.Trabajadore.rut).success(function(data) {
                if (data.estado == 1) {
                    angular.element("#TrabajadoreRut").focus();
                    $scope.formulario.Trabajadore.rut = undefined;
                    Flash.create('danger', data.mensaje, 'customAlert');
                }
            });
        }
    };

    $scope.validaRutCompras = function() {
        if (angular.isDefined($scope.formulario.Trabajadore.rut)) {
            $scope.formulario.Trabajadore.rut = RutHelper.format($scope.formulario.Trabajadore.rut);
            trabajadoresService.validaRutCompras($scope.formulario.Trabajadore.rut).success(function(data) {                
                if (data.estado == 1) {

                    angular.element("#TrabajadoreRut").focus();
                    $scope.formulario.Trabajadore.rut = undefined;
                    Flash.create('danger', data.mensaje, 'customAlert');

                } else if (data.estado == 2) {
                    Flash.create('warning', data.mensaje, 'customAlert');
                }
            });
        }
    };

    $scope.agregarTrabajador = function() {
        delete $scope.formulario.Cargo;
        trabajadoresService.addTrabajador($scope.formulario).success(function(data) {
            switch (data.estado) {
                case 1:
                    $window.location = host + "trabajadores";
                    break;
                case 0:
                    Flash.create('danger', data.mensaje, 'customAlert');
                    break;
            }
        });
    };
});

app.controller('trabajadoresCuentaBancaria', function($scope, $q, $window, trabajadoresService, servicios) {
    $scope.formulario = {};
    $scope.formulario.CuentasCorriente = {};
    $scope.formulario.Trabajadore = {};
    $scope.cuentaBancariaShow = false;
    $scope.loader = true
    $scope.cargador = loader;
    $scope.$watch("trabajadoreId", function(nuevoValor, antiguoValor) {
        if (angular.isDefined(nuevoValor)) {
            promesas = [];
            promesas.push(trabajadoresService.trabajador($scope.trabajadoreId));
            promesas.push(trabajadoresService.cuentaBancaria($scope.trabajadoreId));
            promesas.push(servicios.bancosList());
            promesas.push(servicios.tiposCuentaBancosList());
            $q.all(promesas).then(function(data) {
                $scope.loader = false;
                $scope.cuentaBancariaShow = true;
                $scope.nombre = data[0].data.Trabajadore.nombre + " " + data[0].data.Trabajadore.apellido_paterno + " " + data[0].data.Trabajadore.apellido_materno;
                $scope.bancosList = data[2].data.data;
                $scope.tiposCuentaBancosList = data[3].data.data;
                if (data[1].data.estado == 1) {
                    $scope.formulario = data[1].data.data;
                }
                $scope.guardarCuenta = function() {
                    $scope.formulario.CuentasCorriente.tipo = 1;
                    $scope.formulario.CuentasCorriente.estado = 1;
                    $scope.formulario.Trabajadore.id = $scope.trabajadoreId;
                    if (data[1].data.estado == 1) {
                        $scope.formulario = {
                            CuentasCorriente: {
                                id: $scope.formulario.CuentasCorriente.id,
                                cuenta: $scope.formulario.CuentasCorriente.cuenta,
                                tipo: $scope.formulario.CuentasCorriente.tipo,
                                banco_id: $scope.formulario.CuentasCorriente.banco_id,
                                tipos_cuenta_banco_id: $scope.formulario.CuentasCorriente.tipos_cuenta_banco_id,
                            }
                        }
                    }
                    trabajadoresService.guardarCuentaBancaria($scope.formulario).success(function(data) {
                        if (data.estado == 1) {
                            //$window.location = host+"trabajadores";
                        } else {
                            Flash.create('danger', data.mensaje, 'customAlert');
                        }
                    })
                };
                $scope.volver = function() {
                    $window.location = host + "trabajadores";
                };
            });
        }
    });

});

app.controller('trabajadoresReportePendientes', function($scope, $q, $filter, uiGridConstants, trabajadoresService, trabajadoresFactory, tiposDocumentosService) {
    $scope.host = host;
    $scope.reporteShow = false;
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
        enableGridMenu: true,
        exporterCsvFilename: 'pendientes.csv',
        exporterPdfFilename: 'pendientes.pdf',
        gridMenuShowHideColumns: false,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        { name: 'id', displayName: 'id', visible: false, },
        { name: 'nombre', displayName: 'Nombre', sort: { direction: uiGridConstants.ASC, ignoreSort: true } },
        { name: 'apellido_paterno', displayName: 'Apellido Paterno', },
        { name: 'apellido_materno', displayName: 'Apellido Materno', },
        { name: 'tipo_contrato', displayName: 'Tipo Contrato', },
        { name: 'estado', displayName: 'Estado', },
        { name: 'pendiente', displayName: 'Pendiente', },
    ];

    promesas = [];
    promesas.push(trabajadoresService.trabajadores());
    promesas.push(tiposDocumentosService.tiposDocumentosList());
    $q.all(promesas).then(function(data) {
        if (data[0]["data"]["estado"] == 1) {
            reporteData = trabajadoresFactory.reportePendientes(data);
            $scope.reporteShow = true;
            $scope.loader = false;
            $scope.gridOptions.data = reporteData;
            $scope.loader = false;
            $scope.tablaDetalle = true;
            $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
                if (angular.isNumber(row.entity.id)) {
                    $scope.id = row.entity.id;
                }
                if (row.isSelected == true) {
                    $scope.boton = true;
                } else {
                    $scope.boton = false;
                    $scope.id = "";
                }
            });
            $scope.refreshData = function(termObj) {
                $scope.gridOptions.data = reporteData;
                while (termObj) {
                    var oSearchArray = termObj.split(' ');
                    $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                    oSearchArray.shift();
                    termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                }
            };
        }
    });
});

app.controller('trabajadoresListaContratos', function($scope, $filter, documentosService, uiGridConstants) {
    $scope.ShowContenido = false;
    $scope.loader = true
    $scope.cargador = loader;
    $scope.gridOptions = {
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: false,
        multiSelect: false,
        enableGridMenu: true,
        exporterCsvFilename: 'contratos_trabajadores.csv',
        exporterPdfFilename: 'contratos_trabajadores.pdf',
        gridMenuShowHideColumns: false,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        { name: 'id', displayName: 'id', visible: false, },
        { name: 'nombre', displayName: 'Nombre', sort: { direction: uiGridConstants.ASC, priority: 2 } },
        { name: 'apellido_paterno', displayName: 'Apellido Paterno' },
        { name: 'tipo_documento', displayName: 'Tipo Documento', cellFilter: "uppercase" },
        { name: 'fecha_inicial', displayName: 'Fecha Inicio', cellFilter: "date:'yyyy-MM-dd'" },
        { name: 'fecha_final', displayName: 'Fecha Termino', cellFilter: "date:'yyyy-MM-dd'", sort: { direction: uiGridConstants.ASC, priority: 1 } },
        { name: 'estado_trabajador', displayName: 'Estado Trabajador', cellFilter: "uppercase" },
        {
            name: 'estado_contrato',
            displayName: 'Estado Contrato',
            cellClass: function(row, rowRenderIndex, col, colRenderIndex) {
                switch (rowRenderIndex.entity.estado_contrato) {
                    case "Vigente":
                        return "angular_aprobado_g";
                        break;
                    case "Por vencer":
                        return "angular_pendiente_g";
                        break;
                    case "Vencido":
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
                        case "Vigente":
                            switch (b) {
                                case "Vigente":
                                    return 0;
                                    break;
                                case "Vencido":
                                    return -1;
                                    break;
                                default:
                                    return 1;
                                    break;
                            }
                            break;
                        case "Por vencer":
                            switch (b) {
                                case "Por vencer":
                                    return 0;
                                    break;
                                default:
                                    return -1;
                                    break;

                            }
                            break;
                        case "Vencido":
                            switch (b) {
                                case "Vencido":
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

    documentosService.contratosTrabajadores().success(function(contratos) {
        $scope.ShowContenido = true;
        $scope.loader = false;
        $scope.contratos = contratos;
        $scope.gridOptions.data = $scope.contratos;
    });
    $scope.refreshData = function(termObj) {
        $scope.gridOptions.data = $scope.contratos;
        while (termObj) {
            var oSearchArray = termObj.split(' ');
            $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
            oSearchArray.shift();
            termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
        }
    };
});

app.controller('trabajadoresDotacionTrabajadores', function($scope, $q, $filter, Flash, trabajadoresService, uiGridConstants, servicios) {

    $scope.tamanioModal = "modal-lg";
    var sexos = servicios.sexo();
    $scope.gridOptions = {
        enableGridMenu: true,
        exporterCsvFilename: 'trabajadores.csv',
        exporterPdfFilename: 'trabajadores.pdf',
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: false,
        enableRowHeaderSelection: true,
        multiSelect: false,
        gridMenuShowHideColumns: false,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };
    $scope.gridOptions.columnDefs = [
        { name: "rut", displayName: "Rut" },
        { name: 'nombre', displayName: 'Nombre', sort: { direction: uiGridConstants.ASC, priority: 0 }, cellTemplate: "<div class='ui-grid-cell-contents'><a ng-href='" + host + "trabajadores/view/{{row.entity.id}}'> {{row.entity.nombre+' '+row.entity.apellido_paterno+' '+row.entity.apellido_materno}}</a></div>" },
        { name: 'apellido_paterno', displayName: 'Apellido Paterno', visible: false, },
        { name: 'apellido_materno', displayName: 'Apellido Materno', visible: false, },
        { name: 'tipo_contrato', displayName: 'Tipo Contrato', cellFilter: "uppercase" },
        { name: 'sexo', displayName: 'Sexo', cellFilter: "uppercase" },
        { name: 'fecha_nacimiento', displayName: 'Fecha Nacimiento' },
        { name: 'fecha_ingreso', displayName: 'Fecha Ingreso' },
        { name: 'fecha_salida', displayName: 'Fecha Salida' },
    ];
    angular.element(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        startView: 1,
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        weekStart: 1,
        endDate: Date(),
        startDate: "02/05/2003"
    });

    angular.element('#myTabs a').click(function(e) {
        e.preventDefault()
        $(this).tab('show')
    });

    $scope.fecha = function(fecha) {
        $scope.fechaBusqueda = fecha;
        $scope.buscarDatos($scope.fechaBusqueda);
        angular.element(".datepicker").datepicker('setDate', $scope.fechaBusqueda);
    }

    $scope.mostrarSeccion = function(eleccion) {
        angular.element("#secciones").find("li").removeClass("active");
        angular.element(".nav").find("#nav" + eleccion).addClass("active");
        $scope.seccionDotacion = false;
        $scope.seccionAntiguedad = false;
        $scope.seccionGerencias = false;
        $scope.seccionEdades = false;
        $scope.seccionEstadosCiviles = false;
        $scope.seccionDesvinculaciones = false;
        switch (eleccion) {
            case 1:
                $scope.seccionDotacion = true;
                break;
            case 2:
                $scope.seccionAntiguedad = true;
                break;
            case 3:
                $scope.seccionGerencias = true;
                break;
            case 4:
                $scope.seccionEdades = true;
                break;
            case 5:
                $scope.seccionEstadosCiviles = true;
                break;
            case 6:
                $scope.seccionDesvinculaciones = true;
                break;
        }
    }
    $scope.buscarDatos = function(fecha) {
        $scope.search = undefined;
        $scope.ShowContenido = false;
        $scope.showFecha = false;
        $scope.loader = true;
        $scope.cargador = loader;
        if (angular.isDefined(fecha)) {
            fechaArray = fecha.split("/");
            fecha = fechaArray[2] + "-" + fechaArray[1] + "-" + fechaArray[0];
        }

        trabajadoresService.dataDotacionTrabajadores(fecha).success(function(data) {
            $scope.toggleAnio = true;
            $scope.desAnuales = true;
            dotacion = data.dotacion_sexo_tipo_contrato;
            $scope.antiguedades = data.trabajadores_agrupados_antiguedad;
            $scope.dotacionPorGerencias = data.dotacion_por_gerencias;
            $scope.rangoEdades = data.trabajadores_rango_edades;
            $scope.estadosCiviles = data.trabajadores_estado_civil;
            $scope.desvinculaciones = data.trabajadores_desvinculaciones;
            $scope.showFecha = true
            $scope.ShowContenido = true;
            $scope.loader = false;
            $scope.seccionDotacion = true;
            $scope.mostrarSeccion(1);
            if (dotacion.estado == 1) {
                //console.log(dotacion);
                $scope.dotaciones = dotacion.data.datos;
                $scope.fecha = dotacion.data.fecha;
                $scope.anioDesvinculacion = parseInt($filter("date")($scope.fecha, "yyyy"));
                $scope.tipoContratos = dotacion.data.tipo_contratos;
                series = [];
                series2 = [];
                serie7 = [];
                $scope.serie8 = [];
                angular.forEach($scope.dotaciones, function(dotacion, tipoContrato) {
                    if (tipoContrato != "total_general") {
                        series.push({
                            name: angular.uppercase($scope.tipoContratos[tipoContrato]),
                            y: dotacion.total_tipo_contrato
                        });
                    }
                });
                $scope.chart = {
                    options: {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie',
                            reflow: true
                        },
                        title: {
                            text: 'Dotación por tipo de contrato'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                                        fontSize: "15px"
                                    }
                                }
                            }
                        },
                    },
                    series: [{
                        name: "Tipo contratos",
                        colorByPoint: true,
                        data: series
                    }]
                };
                angular.forEach($scope.antiguedades.anios, function(valores, anio) {
                    series2.push({
                        name: anio,
                        y: valores.total
                    });
                });
                $scope.chart2 = {
                    options: {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie',
                            reflow: true
                        },
                        title: {
                            text: 'Antigüedad dotación'
                        },
                        tooltip: {
                            pointFormat: ' {point.name} : <b>{point.percentage:.1f}%</b>',
                            headerFormat: 'Año'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name} años</b> : {point.percentage:.1f} %',
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                                        fontSize: "15px"
                                    }
                                }
                            }
                        },
                    },
                    series: [{
                        colorByPoint: true,
                        data: series2
                    }]
                }
                series3 = [];
                angular.forEach($scope.dotacionPorGerencias.gerencias, function(areas, gerencia) {
                    dataSerie = [];
                    angular.forEach($scope.dotacionPorGerencias.anios, function(anio) {
                        dataSerie.push((angular.isDefined($scope.dotacionPorGerencias.totales[gerencia][anio])) ? $scope.dotacionPorGerencias.totales[gerencia][anio] : 0);
                    });
                    series3.push({
                        name: angular.uppercase(gerencia),
                        data: dataSerie
                    });
                });
                $scope.chart3 = {
                    options: {
                        chart: {
                            type: 'line'
                        },
                        title: {
                            text: 'Trabajadores por gerencias'
                        },
                        subtitle: {
                            text: 'Cantidad de personas por año en cada gerencia'
                        },
                        xAxis: {
                            title: {
                                text: 'años'
                            },
                            categories: $scope.dotacionPorGerencias.anios
                        },
                        yAxis: {
                            title: {
                                text: 'N° personas'
                            },
                            min: 0
                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: true
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle',
                            borderWidth: 0
                        },
                        tooltip: {
                            valueSuffix: ' Personas'
                        },
                    },
                    series: series3
                }
                $scope.chart4 = {
                    options: {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie',
                            reflow: true
                        },
                        title: {
                            text: 'Dotación por rango edades'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                                        fontSize: "15px"
                                    }
                                }
                            }
                        },
                    },
                    series: [{
                        name: "Rango edad",
                        colorByPoint: true,
                        data: [
                            { name: "menos de 25 años", y: $filter("undefinedPorValor")($scope.rangoEdades[0], 0) },
                            { name: "entre 25 y 35 años", y: $filter("undefinedPorValor")($scope.rangoEdades[25], 0) },
                            { name: "entre 35 y 45 años", y: $filter("undefinedPorValor")($scope.rangoEdades[35], 0) },
                            { name: "más de 45 años < ", y: $filter("undefinedPorValor")($scope.rangoEdades[45], 0) },
                        ]
                    }]
                };
                serie5 = [];
                angular.forEach($scope.estadosCiviles.estadosCiviles, function(estadoCivil) {
                    serie5.push({
                        name: estadoCivil.nombre,
                        y: $filter("undefinedPorValor")($scope.estadosCiviles.data[estadoCivil.id], 0)
                    });
                });
                if (angular.isDefined($scope.estadosCiviles.noDefinidos)) {
                    serie5.push({
                        name: "NO DEFINIDOS",
                        y: $scope.estadosCiviles.noDefinidos
                    });
                }
                $scope.chart5 = {
                    options: {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie',
                            reflow: true
                        },
                        title: {
                            text: 'Dotación por estado civil'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                                        fontSize: "15px"
                                    }
                                }
                            }
                        },
                    },
                    series: [{
                        name: "Estado civil",
                        colorByPoint: true,
                        data: serie5
                    }]
                };
                serie6 = [];
                angular.forEach($scope.desvinculaciones.data.total.anios, function(data) {
                    serie6.push(data);
                });
                $scope.chart6 = {
                    options: {
                        chart: {
                            type: 'area'
                        },
                        title: {
                            text: 'Desvinculaciones por año'
                        },
                        subtitle: {
                            text: 'Cantidad de desvinculaciones hasta ' + $filter("date")($scope.fecha, "dd/MM/yyyy", "UTC")
                        },
                        xAxis: {
                            title: {
                                text: 'años'
                            },
                            categories: $scope.desvinculaciones.anios
                        },
                        yAxis: {
                            title: {
                                text: 'N° personas'
                            },
                            min: 0
                        },
                        plotOptions: {
                            area: {
                                fillColor: {
                                    linearGradient: {
                                        x1: 0,
                                        y1: 0,
                                        x2: 0,
                                        y2: 1
                                    },
                                    stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                    ]
                                },
                                marker: {
                                    radius: 2
                                },
                                lineWidth: 1,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                threshold: null,
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: true
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            valueSuffix: ' Personas'
                        },
                    },
                    series: [{
                        name: "Desvinculaciones",
                        data: serie6
                    }]
                }
                meses = [];
                angular.forEach($scope.desvinculaciones.meses, function(mes) {
                    meses.push(mes.nombre);
                });
                $scope.chart7 = {
                    options: {
                        chart: {
                            type: 'area'
                        },
                        title: {
                            text: ''
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            title: {
                                text: 'años'
                            },
                            categories: meses
                        },
                        yAxis: {
                            title: {
                                text: 'N° personas'
                            },
                            min: 0
                        },
                        plotOptions: {
                            area: {
                                fillColor: {
                                    linearGradient: {
                                        x1: 0,
                                        y1: 0,
                                        x2: 0,
                                        y2: 1
                                    },
                                    stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                    ]
                                },
                                marker: {
                                    radius: 2
                                },
                                lineWidth: 1,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                threshold: null,
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: true
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            valueSuffix: ' Personas'
                        },
                    },
                    series: [{
                        name: "Desvinculaciones",
                        data: serie7
                    }]
                }

                $scope.chart8 = {
                    options: {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie',
                            reflow: true
                        },
                        title: {
                            text: ''
                        },
                        subtitle: {
                            text: ''
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                                        fontSize: "15px"
                                    }
                                },
                                startAngle: 45
                            }
                        },
                    },
                    series: [{
                        name: "Motivo retiro",
                        colorByPoint: true,
                        data: $scope.serie8
                    }]
                };

                $scope.cambioAnio = function(anio) {
                    serie7 = [];
                    $scope.serie8 = [];
                    angular.forEach($scope.desvinculaciones.meses, function(data) {
                        if (angular.isDefined($scope.desvinculaciones.data.meses[anio][data.mes])) {
                            serie7.push($scope.desvinculaciones.data.meses[anio][data.mes]);
                        } else {
                            serie7.push(0);
                        }
                    });
                    $scope.totalDesvinculaciones = 0;
                    angular.forEach($scope.desvinculaciones.motivosList, function(nombre, id) {
                        if (angular.isDefined($scope.desvinculaciones.motivos[anio][id])) {
                            $scope.serie8.push({
                                name: nombre,
                                y: $scope.desvinculaciones.motivos[anio][id]
                            });
                            $scope.totalDesvinculaciones += $scope.desvinculaciones.motivos[anio][id];
                        } else {
                            $scope.serie8.push({
                                name: nombre,
                                y: 0
                            });
                        }
                    });
                    $scope.chart7.series[0].data = serie7;
                    $scope.chart8.series[0].data = $scope.serie8;
                    if (anio == ($filter("date")($scope.fecha, "yyyy", "UTC"))) {
                        $scope.tituloDesvinculacion = $scope.fecha;
                    } else {
                        $scope.tituloDesvinculacion = anio + "12-31";
                    }
                    $scope.chart7.options.title.text = 'Desvinculaciones ' + $filter("date")($scope.tituloDesvinculacion, "yyyy", "UTC");
                    $scope.chart7.options.subtitle.text = 'Hasta ' + $filter("date")($scope.tituloDesvinculacion, "dd/MM/yyyy", "UTC");
                    $scope.chart8.options.title.text = 'Motivo de Desvinculaciones ' + $filter("date")($scope.tituloDesvinculacion, "yyyy", "UTC");
                    $scope.chart8.options.subtitle.text = 'Hasta ' + $filter("date")($scope.tituloDesvinculacion, "dd/MM/yyyy", "UTC");
                };

                $scope.desvinculacionTipo = function(tipo) {
                    if (tipo == 1) {
                        $scope.toggleAnio = true;
                        $scope.toggleMeses = false;
                        $scope.desAnuales = true;
                        $scope.desMeses = false;
                    } else {
                        $scope.toggleAnio = false;
                        $scope.toggleMeses = true;
                        $scope.desAnuales = false;
                        $scope.desMeses = true;
                        $scope.cambioAnio($scope.anioDesvinculacion);
                    }
                }
                $scope.verPersonasDotacion = function() {
                    $scope.titulo = "Trabajadores";
                    $scope.search = undefined;
                    $scope.gridOptions.data = undefined;
                    $scope.showModal = true;
                    $scope.trabajadores = [];
                    angular.forEach(dotacion.data.detallePersonas, function(trabajador) {
                        $scope.trabajadores.push({
                            id: trabajador.id,
                            rut: trabajador.rut,
                            nombre: trabajador.nombre,
                            apellido_paterno: trabajador.apellido_paterno,
                            apellido_materno: trabajador.apellido_materno,
                            tipo_contrato: $scope.tipoContratos[trabajador.tipo_contrato_id],
                            sexo: (angular.isDefined(sexos[trabajador.sexo])) ? sexos[trabajador.sexo].nombre : "",
                            fecha_nacimiento: trabajador.fecha_nacimiento,
                            fecha_ingreso: trabajador.fecha_ingreso,
                            fecha_salida: trabajador.fecha_retiro
                        });
                    })
                    $scope.gridOptions.data = $scope.trabajadores;
                };
                $scope.verPersonasAntiguedad = function() {
                    $scope.search = undefined;
                    $scope.titulo = "Trabajadores";
                    $scope.gridOptions.data = undefined;
                    $scope.trabajadores = [];
                    angular.forEach($scope.antiguedades.detallePersonas, function(trabajador) {
                        $scope.trabajadores.push({
                            id: trabajador.id,
                            rut: trabajador.rut,
                            nombre: trabajador.nombre,
                            apellido_paterno: trabajador.apellido_paterno,
                            apellido_materno: trabajador.apellido_materno,
                            tipo_contrato: $scope.tipoContratos[trabajador.tipo_contrato_id],
                            sexo: (angular.isDefined(sexos[trabajador.sexo])) ? sexos[trabajador.sexo].nombre : "",
                            fecha_nacimiento: trabajador.fecha_nacimiento,
                            fecha_ingreso: trabajador.fecha_ingreso,
                            fecha_salida: trabajador.fecha_retiro
                        });
                    })
                    $scope.gridOptions.data = $scope.trabajadores;
                }
            } else {
                Flash.create('danger', dotacion.mensaje, 'customAlert');
                $scope.ShowContenido = false;
            }

        });
    };
    $scope.refreshData = function(termObj) {
        $scope.gridOptions.data = $scope.trabajadores;
        while (termObj) {
            var oSearchArray = termObj.split(' ');
            $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
            oSearchArray.shift();
            termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
        }
    };
});
