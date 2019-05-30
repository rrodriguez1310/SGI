app.controller('Promociones', ['$scope', '$http', 'Flash', 'uiGridConstants', function($scope, $http, Flash, uiGridConstants,) {
    $scope.gridOptions = {
        showGridFooter: true,
        showColumnFooter: true,
        enableFiltering: true,
        enableGridMenu: true,
        enableSelectAll: false,
        enableRowSelection: true,
        exporterCsvFilename: 'raing_por_programas.csv',
        exporterPdfDefaultStyle: { fontSize: 9 },
        exporterPdfTableStyle: { margin: [30, 30, 30, 30] },
        exporterPdfTableHeaderStyle: { fontSize: 10, bold: true, italics: true, color: 'red' },
        exporterPdfHeader: { text: "Rating por programas", style: 'headerStyle' },
        exporterPdfFooter: function(currentPage, pageCount) {
            return { text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle' };
        },
        exporterPdfCustomFormatter: function(docDefinition) {
            docDefinition.styles.headerStyle = { fontSize: 22, bold: true };
            docDefinition.styles.footerStyle = { fontSize: 10, bold: true };
            return docDefinition;
        },
        exporterPdfOrientation: 'portrait',
        exporterPdfPageSize: 'LETTER',
        exporterPdfMaxGridWidth: 500,
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        { name: 'id', displayName: 'Id', visible: false },
        { name: 'fecha', displayName: 'Fecha' },
        { name: 'media', displayName: 'Media' },
        { name: 'signal', displayName: 'Señal' },
        { name: 'nombre', displayName: 'Nombre' },
        { name: 'cantidad', displayName: 'cantidad' }
    ];

    $scope.enviaFecha = function(form) {
        if (form.fechaInicio && form.fechaFin) {
            $scope.loader = true
            $scope.cargador = loader;
            $scope.detalle = false
            $http.get(host25 + 'log_programas/lista_promos_json/' + form.fechaInicio + '/' + form.fechaFin).success(function(data) {
                if (data.length > 0) {
                    $scope.gridOptions.data = data;
                    $scope.loader = false
                    $scope.detalle = true
                    
                    $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                        if(row.isSelected == true){
                            $scope.agrupado = row.entity.agrupado; 
                            $scope.showModal = true;
                            $scope.tamanioModal = '80';
                            $scope.titulo = 'Lista de codigos'
        
                        }else{
                            $scope.agrupado = '';
                             $scope.showModal = false;
                        }
                    });


                    $http.get(host25 + 'log_programas/promos_graficos_json/'+ form.fechaInicio + '/' + form.fechaFin).success(function (data) {
                        var nombre = [];
                        var basico = [];
                        var premium = [];
                        var hd = [];

                        console.warn(data);

                        angular.forEach(data, function (media, keyMedia) {
                            angular.forEach(media, function (signal, keySignal) {
                                nombre.push(signal.nombre)
                                if (keySignal == 'SD_CDF_BAS') {
                                    basico.push(signal.total)
                                }

                                if (keySignal == 'SD_CDF_PREM') {
                                    premium.push(signal.total)
                                }

                                if (keySignal == 'HD_CDF_HD') {
                                    hd.push(signal.total)
                                }


                            })
                        });

                        $scope.evolucionSubscribers = {
                            options: {
                                chart: {
                                    type: 'bar',
                                    zoomType: 'x'
                                },
                                tooltip: {
                                    style: {
                                        padding: 10,
                                        fontWeight: 'bold'
                                    },
                                    shared: true,
                                },
                                title: {
                                    text: "",
                                    useHTML: true
                                },
                                yAxis: {
                                    title: {
                                        text: 'Cantidad abonados'
                                    },
                                    min: 0
                                },
                                xAxis: {
                                    categories: nombre,
                                    title: {
                                        text: 'Nombres'
                                    },
                                },
                                lang: {
                                    noData: "Sin información",
                                    loading: "Cargando",
                                    printChart: "Imprimir grafico",
                                },
                                noData: {
                                    style: {
                                        fontWeight: 'bold',
                                        fontSize: '15px',
                                        color: '#303030'
                                    }
                                }
                            },
                            series: [{
                                name: 'Basicos',
                                data: basico
                            }, {
                                name: 'Premium',
                                data: premium
                            }, {
                                name: 'Hd',
                                data: hd
                            }]
                        };
                    })

                } else {
                    alert("No hay informacion de programacion para este dia");
                }
            
            });
        }  
    };
    $scope.cerrarModal = function (){
        $scope.showModal = false;
    };
}]);
/*
app.controller('PromocionesGraficos', function ($scope, $http, Flash) {
    $http.get(host25 + 'log_programas/promos_graficos_json2/' + form.fechaInicio + '/' + form.fechaFin).success(function (data) {
       console.log(data);
        alert(form.fechaInicio);
        alert(form.fechaFin);
        var nombre = [];
        var basico = [];
        var premium = [];
        var hd = [];

        console.warn(data);

        angular.forEach(data, function(media, keyMedia) {
            angular.forEach(media, function(signal, keySignal) {
                nombre.push(signal.nombre)
                if(keySignal == 'SD_CDF_BAS'){
                    basico.push(signal.total)
                }

                if(keySignal == 'SD_CDF_PREM'){
                    premium.push(signal.total)
                }

                if(keySignal == 'HD_CDF_HD'){
                    hd.push(signal.total)
                }


            })
        });

        $scope.evolucionSubscribers = {
            options: {
                chart: {
                    type: 'bar',
                    zoomType: 'x'
                },
                tooltip: {
                    style: {
                        padding: 10,
                        fontWeight: 'bold'
                    },
                    shared: true,
                },
                title: {
                    text: "Informe exhibición xx de xx al xx de xxx",
                    useHTML: true
                },
                yAxis: {
                    title: {
                        text: 'Cantidad abonados'
                    },
                    min: 0
                },
                xAxis: {
                    categories: nombre,
                    title: {
                        text: 'Nombres'
                    },
                },
                lang: {
                    noData: "Sin información",
                    loading: "Cargando",
                    printChart: "Imprimir grafico",
                },
                noData: {
                    style: {
                        fontWeight: 'bold',
                        fontSize: '15px',
                        color: '#303030'
                    }
                }
            },
            series: [{
                name: 'Basicos',
                data: basico
            }, {
                name: 'Premium',
                data: premium
            }, {
                name: 'Hd',
                data: hd
            }]
        };
    })
});
*/


