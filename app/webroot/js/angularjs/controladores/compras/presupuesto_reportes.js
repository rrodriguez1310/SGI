app.controller('PresupuestoReportes', ['$scope', '$http', 'comprasServices', 'uiGridConstants', '$filter', '$q', function($scope, $http, comprasServices, uiGridConstants, $filter, $q) {
    $scope.gridOptions = {
        enableGridMenu: true,
        exporterCsvFilename: 'consolidado_final.csv',
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
        enableSorting: false,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };
    $scope.gridOptions.columnDefs = [
        { name: 'factura_id', displayName: 'ID Factura', visible: false, width: 95, pinnedLeft: true },
        { name: 'fecha_documento', displayName: 'Fecha', width: 95, pinnedLeft: true },
        { name: 'empresa', displayName: 'Empresa', width: 95, pinnedLeft: true },
        { name: 'tipo_documento', displayName: 'Documento', width: 110, pinnedLeft: true },
        { name: 'nro_documento', displayName: 'N° Doc.', width: 95, pinnedLeft: true },
        { name: 'familia_nombre', displayName: 'Desc. Familia', width: 135, enablePinning: false },
        { name: 'nombre_producto', displayName: 'Titulo', width: 145, enablePinning: false },
        { name: 'cantidad_producto', displayName: 'Cantidad', visible: false },
        { name: 'familia_codigo', displayName: 'Familia', width: 85 },
        { name: 'codigo_presupuesto', displayName: 'Código', width: 100 },
        { name: 'subtotal', displayName: 'Neto $', cellTemplate: '<div style="text-align:right;" class="ui-grid-cell-contents">{{row.entity.subtotal|number}}</div>', type: 'number', width: 100 },
        {
            name: 'presupuesto',
            displayName: 'Presup. Mes $',
            cellTemplate: '<div style="text-align:right;" class="ui-grid-cell-contents">{{row.entity.presupuesto|number}}</div>',
            type: 'number',
            width: 130,
            cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                return (Number(row.entity.presupuesto) < 0) ? 'text-danger' : '';
            }
        },
        {
            name: 'saldo',
            displayName: 'Saldo Mes $',
            cellTemplate: '<div style="text-align:right" class="ui-grid-cell-contents">{{row.entity.saldo|number}}</div>',
            type: 'number',
            width: 120,
            cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                return (Number(row.entity.saldo) < 0) ? 'text-danger' : '';
            }
        },
        {
            name: 'presupuesto_anual',
            displayName: 'Presup. Año $',
            cellTemplate: '<div style="text-align:right;" class="ui-grid-cell-contents">{{row.entity.presupuesto_anual|number}}</div>',
            type: 'number',
            width: 130,
            cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                return (Number(row.entity.presupuesto_anual) < 0) ? 'text-danger' : '';
            }
        },
        {
            name: 'saldo_anual',
            displayName: 'Saldo Año $',
            cellTemplate: '<div style="text-align:right;" class="ui-grid-cell-contents">{{row.entity.saldo_anual|number}}</div>',
            type: 'number',
            width: 140,
            cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                return (Number(row.entity.saldo_anual) < 0) ? 'text-danger' : '';
            }
        }
    ];

    var general = 0;
    var largo = window.location.pathname.split('/').length;
    var pagina = window.location.pathname.split('/')[largo - 1];
    if (pagina == 'presupuesto_general') {
        general = 1;
    }

    $scope.mostrarSeccion = function(eleccion) {
        angular.element("#secciones").find("li").removeClass("active");
        angular.element(".nav").find("#nav" + eleccion).addClass("active");
        $scope.seccionDetalle = false;
        $scope.seccionMensual = false;
        switch (eleccion) {
            case 1:
                $scope.seccionDetalle = true;
                break;
            case 2:
                $scope.seccionMensual = true;
                break;
        }
    };

    $scope.seccionDetalle = false;
    $scope.showFecha = false;
    $scope.showCodigoGrafico = false;
    $scope.graficos = false;
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.lang = 'es';
    $scope.list = { anioPresupuesto: new Date().getFullYear(), famPresupuesto: 0, codPresupuesto: 0, general: general };
    $scope.presupuestoCodigos = [];
    $scope.counter = 0;

    $scope.$watch('list.anioPresupuesto', function(anio, anioAnt) {

        $scope.list.famPresupuesto = 0;
        $scope.list.codPresupuesto = 0;
        $scope.loader = true;
        $scope.showFecha = false;
        $scope.showFechaGrafico = false;
        $scope.tablaDetalle = false;
        $scope.showCodigoGrafico = false;
        $scope.graficos = false;
        $scope.gridOptions.data = [];

        comprasServices.listaDetallePresupuesto($scope.list.anioPresupuesto, general).success(function(data) {

            $scope.gridOptions.data = data.productosFinal;
            $scope.presupuestoAnios = data.anioPresupuestoList;
            $scope.presupuestoFamilias = data.familiaList;
            $scope.codigoFamilia = data.codigoList;
            $scope.nombreGerencia = data.gerenciaNombre;
            $scope.nombreCodigo = data.nombreCodigo;

            $scope.loader = false;
            $scope.tablaDetalle = true;
            $scope.showFecha = true;
            $scope.showCodigoGrafico = true;
            $scope.actualizaGraficos();
            $scope.mostrarSeccion(1);

            $scope.refreshData = function(termObj) {
                $scope.gridOptions.data = data.productosFinal;
                while (termObj) {
                    var oSearchArray = termObj.split(' ');
                    $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                    oSearchArray.shift();
                    termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                }
            };
        });
        $scope.$watch('list.famPresupuesto', function(nuevo, anterior) {
            if (nuevo != anterior)
                $scope.list.codPresupuesto = 0;
        });
    });

    $scope.actualizaGraficos = function() {
        $scope.graficos = false;
        promesas = [];
        promesas.push(comprasServices.listaPresupuestoGrafico($scope.list));
        var subtitulo = '';
        $q.all(promesas).then(function(datos) {
            $scope.graficos = true;
            if (angular.isDefined($scope.codigoFamilia)) {
                $scope.presupuestoCodigos = [];
                angular.forEach($scope.codigoFamilia[$scope.list.famPresupuesto], function(codigo) {
                    angular.forEach($scope.presupuestoFamilias, function(nombreFam) {
                        if (nombreFam.codigo == $scope.list.famPresupuesto) {
                            subtitulo = nombreFam.nombre;
                        }
                    });
                    $scope.presupuestoCodigos.push({
                        codigo: codigo,
                        nombre: codigo + ' - ' + $scope.nombreCodigo[codigo][0]
                    });
                });
            }
            if ($scope.list.codPresupuesto != 0) {
                subtitulo = $scope.list.codPresupuesto + ' - ' + $scope.nombreCodigo[$scope.list.codPresupuesto][0];
            }
            if (general == 1) {
                $scope.titulo = 'General';
            } else {
                $scope.titulo = datos[0].data.gerencia;
            }
            $scope.chart1 = $scope.graficoBarra("Gráfico Comparativo Presupuesto vs Gasto Mensual " + $scope.list.anioPresupuesto, subtitulo, "", "Pesos", datos[0].data);
        });
    };

    $scope.graficoBarra = function(titulo, subtitulo, ejex, ejey, data) {
        return objGrafTorta = {
            lang: {
                decimalPoint: ',',
                thousandsSep: '.'
            },
            options: {
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
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>${point.y:,.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
            },
            series: data.series
        };
    };
}]);