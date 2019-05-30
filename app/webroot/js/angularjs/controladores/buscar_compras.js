app.controller('BuscaCompras', ['$scope', '$http', '$filter', 'uiGridConstants', function($scope, $http, $filter, uiGridConstants) {
    $scope.tablaDetalle = false;
    $scope.loader = true
    $scope.cargador = loader;

    $scope.gridOptions = {
        enableGridMenu: true,
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        },
        enableGridMenu: true,
        enableSelectAll: true,
        exporterCsvFilename: 'myFile.csv',
        exporterPdfDefaultStyle: { fontSize: 9 },
        exporterPdfTableStyle: { margin: [30, 30, 30, 30] },
        exporterPdfTableHeaderStyle: { fontSize: 10, bold: true, italics: true, color: 'red' },
        exporterPdfHeader: { text: "My Header", style: 'headerStyle' },
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
        { name: 'Id', displayName: 'Id', visible: false },
        {
            name: 'Codigo',
            displayName: 'Cod.Req',
            cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                if (angular.isNumber(grid.getCellValue(row, col))) {
                    return 'negro';
                } else {
                    return 'negro';
                }
            }
        },

        { name: 'EmpresaRut', displayName: 'Rut' },
        { name: 'Empresa', displayName: 'Empresa' },
        { name: 'Titulo', displayName: 'Titulo' },
        { name: 'Fecha', displayName: 'Fecha' },
        { name: 'FechaDocumento', displayName: 'Fecha Documento', visible: false },
        { name: 'Total', displayName: 'Total', cellFilter: 'number' },
        {
            name: 'Estado',
            displayName: 'Estado',
            cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                if (grid.getCellValue(row, col) == "Eliminado" || grid.getCellValue(row, col) == "Rechazado Gerencia" || grid.getCellValue(row, col) == "Rechazado Sap") {
                    return 'angular_eliminado';
                }

                if (grid.getCellValue(row, col) == "Aprobado Gerencia") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row, col) == "Aprobado Incompleto Gerencia") {
                    return 'angular_aprobado_g';
                }

                if (grid.getCellValue(row, col) == "Facturado") {
                    return 'angular_facturado';
                }

                if (grid.getCellValue(row, col) == "Aprobado Incompleto Sap") {
                    return 'angular_aprobado_s';
                }

                if (grid.getCellValue(row, col) == "Aprobado Sap") {
                    return 'angular_aprobado_s';
                }

                if (grid.getCellValue(row, col) == "Pendiente Gerencia") {
                    return 'angular_pendiente_g';
                }

                if (grid.getCellValue(row, col) == "N. Credito") {
                    return 'angular_nota_credito';
                }


            }
        },
        { name: 'IdEstado', visible: false },
        { name: 'EmpresaId', visible: false },
        { name: 'EmpresaTipoSerializado', displayName: 'Tipo Empresa', visible: false },
    ];

    //$scope.cargador = true;

    $http.get(host25 + 'compras/buscar_compras/').success(function(data) {

        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;

        $scope.refreshData = function(termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };

        var urlPlantilla = "";
        var contadorSeleccionados = [];
        var empresasId = [];
        var codigosId = [];
        var idrequerimientos = [];
        $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
            switch (row.entity.IdEstado) {
                case 1:
                case 2:
                case 5:
                case 3:
                case 7:
                case 6:
                case 0:
                    if (row.isSelected == true) {
                        if (angular.isNumber(row.entity.Codigo)) {
                            urlPlantilla = "plantilla_boletas_facturas_add";
                            $scope.gridOptions.multiSelect = false;
                        } else {
                            urlPlantilla = "plantilla_boleta_facturas_add_documento";
                            $scope.gridOptions.multiSelect = false;
                        }

                        $scope.asociarFac = false;
                        idrequerimientos.length = 0;
                        $scope.plantilla = true;
                        $scope.ver = true;
                        $scope.plantilla = true;
                        $scope.id = row.entity.Id;
                        $scope.plantilla = urlPlantilla;
                        $scope.asociarNot = false;
                    } else {
                        $scope.plantilla = false;
                        $scope.ver = false;
                        $scope.plantilla = false;
                        $scope.id = "";
                        $scope.plantilla = "";
                        $scope.asociarFac = false;
                    }

                    break;

                case 4:
                case 8:
                    if (row.isSelected == true) {
                        if (!angular.isNumber(row.entity.Codigo)) {
                            if (row.entity.Codigo != "") {
                                codigoCorto = row.entity.Codigo.split("-")
                            }
                        }

                        if (angular.isNumber(row.entity.Codigo)) {
                            urlPlantilla = "plantilla_boletas_facturas_add";
                            $scope.gridOptions.multiSelect = true;
                            idrequerimientos.push(row.entity.Codigo);
                            empresasId.push(row.entity.EmpresaId)
                            if (idrequerimientos.length >= 1) {

                                function arrayMismaEmpresa(value, index, self) {
                                    return self.indexOf(value) === index;
                                }

                                if (empresasId.filter(arrayMismaEmpresa).length > 1) {
                                    alert("Para facturar seleccione requerimientos del mismo proveedor");
                                } else {
                                    $scope.asociarFac = true;
                                    $scope.plantilla = true;
                                    $scope.ver = true;
                                    $scope.id = row.entity.Id;
                                    $scope.plantilla = urlPlantilla;
                                    $scope.idEmpresas = idrequerimientos.join();
                                    $scope.asociarNot = false;
                                }
                            }
                        } else {
                            if (idrequerimientos.length >= 1) {
                                alert("No puede seleccionar requerimientos con facturas")
                                $scope.gridApi.selection.clearSelectedRows();
                                idrequerimientos.length = 0;
                                $scope.asociarFac = false;
                                $scope.ver = false;
                                $scope.plantilla = false;
                            }

                            urlPlantilla = "plantilla_boleta_facturas_add_documento";
                            if (codigoCorto[0] === "Fac") {
                                $scope.asociarNot = true;
                            } else {
                                $scope.asociarNot = false;
                            }

                            $scope.gridOptions.multiSelect = false;
                            $scope.asociarFac = false;
                            $scope.plantilla = true;
                            $scope.ver = true;
                            $scope.id = row.entity.Id;
                            $scope.plantilla = urlPlantilla;
                            $scope.idEmpresas = row.entity.Id;
                        }
                    } else {
                        var idRequerimiento = idrequerimientos.indexOf(row.entity.Id);
                        idRequerimiento > -1 && idrequerimientos.splice(idRequerimiento, 1);
                        $scope.idEmpresas = idrequerimientos.join();
                        console.log(idrequerimientos);
                        if (idrequerimientos.length < 1) {
                            $scope.asociarNot = false;
                            $scope.asociarFac = false;
                            $scope.plantilla = false;
                            $scope.ver = false;
                            $scope.id = "";
                            $scope.plantilla = "";
                            $scope.idEmpresas.length = 0;
                            $scope.idEmpresas.length = 0;
                        }
                    }
                    break;
            };
        });
    });
}]);
