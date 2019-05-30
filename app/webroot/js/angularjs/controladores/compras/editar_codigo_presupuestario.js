app.controller('ListaAprobadores', ['$scope', '$http', 'comprasServices', 'yearsService', 'codigosPresupuestosService', 'Flash', 'uiGridConstants', '$filter', function($scope, $http, comprasServices, yearsService, codigosPresupuestosService, Flash, uiGridConstants, $filter) {
    $scope.loader = true
    $scope.cargador = loader;
    $scope.form = {};

    $scope.gridOptions = {
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        enableFiltering: false,
        useExternalFiltering: true,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        { name: 'Id', displayName: 'Id', visible: true },
        { name: 'Descripcion', displayName: 'producto' },
        { name: 'DimUno', displayName: 'Dimención Uno' },
        { name: 'CodigoPresupuesto', displayName: 'Código Presupuestario' },
        { name: 'ValorProducto', displayName: 'Valor' },
    ];

    comprasServices.editCodigoPresupuestario().success(function(data) {

        $scope.gridOptions.data = data.Productos;
        $scope.loader = false;
        $scope.tablaDetalle = true;

        $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
            $scope.tipoDocumento = row.entity.TipoDocumento

            if (row.isSelected == true) {
                if (row.entity.Id != 0) {
                    //$scope.boton = true;
                    $scope.formulario = true;
                    $scope.tituloBoton = "Editar código presupuestario";
                    $scope.clase = "btn btn-primary";
                    $scope.form.id = row.entity.Id;
                    listaAgnos = [];
                    yearsService.yearsList().success(function(agnos) {
                        angular.forEach(agnos.data, function(item, key) {
                            if (item.nombre > 2014) {
                                listaAgnos.push({ id: item.id, nombre: item.nombre });
                            }

                        });
                    })

                    $scope.selectAgno = {
                        availableOptions: listaAgnos,
                        //selectedOption: {id: row.entity.Informe, nombre: row.entity.Informe}
                    };
                }
            } else {
                $scope.id = "";
                $scope.boton = false;
                $scope.formulario = false;
                $scope.form.id = "";
                $scope.form.tipo = "editar"
            }
        })

        $scope.agnoSeleccionado = function() {


            if ($scope.selectAgno.selectedOption.id != '') {

                codigosPresupeusto = [];
                codigosPresupuestosService.codigosPresupuestosAgnos($scope.selectAgno.selectedOption.id).success(function(dataCodigosPresupuesto) {
                    angular.forEach(dataCodigosPresupuesto, function(item, key) {
                        console.log(item.CodigosPresupuesto.id);
                        codigosPresupeusto.push({ id: item.CodigosPresupuesto.id, nombre: item.CodigosPresupuesto.codigo })
                    });

                    $scope.selectCodigoPresupuesto = {
                        availableOptions: codigosPresupeusto,
                        //selectedOption: {id: row.entity.Informe, nombre: row.entity.Informe}
                    };
                })
            }
        }


        $scope.submitForm = function() {

            if ($scope.form.id != "" && $scope.selectAgno.selectedOption.nombre != "" && $scope.selectCodigoPresupuesto.selectedOption.nombre != "") {

                comprasServices.editaCodigoProducto($scope.form.id, $scope.selectAgno.selectedOption.nombre, $scope.selectCodigoPresupuesto.selectedOption.nombre).success(function(mensaje) {
                    if (mensaje.Error == 1) {
                        comprasServices.editCodigoPresupuestario().success(function(data) {
                            $scope.gridOptions.data = data.Productos;
                        });

                        Flash.create('success', mensaje.Mensaje, 'customAlert');
                        $scope.form.id = "";
                        $scope.boton = false;
                        $scope.formulario = false;
                    } else {
                        Flash.create('danger', mensaje.Mensaje, 'customAlert');
                    }
                });
            }
        }
    });
}]);