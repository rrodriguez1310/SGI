app.controller('ListaAprobadores', ['$scope', '$http','comprasServices', 'Flash', 'uiGridConstants', '$filter',  function ($scope, $http, comprasServices, Flash, uiGridConstants, $filter) {
    $scope.boton = true;
    $scope.botonDos = false
    $scope.loader = true
    $scope.cargador = loader;
    $scope.form = {};

    $scope.gridOptions = {
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        enableFiltering: false,
        useExternalFiltering: true,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };
    $scope.gridOptions.columnDefs = [
            { name:'Id', displayName: 'Id', visible:false},
            { name:'Email', displayName: 'Email'},
            { name:'Informe', displayName: 'Informe'},
    ];

    comprasServices.listaAprobadores().success(function(data){
        $scope.gridOptions.data = data;
        aprobadoresGerencias = []; 
        if(data !== null)
            comprasServices.listaCodigosCortos().success(function(dataCodigosCortos){
                angular.forEach(dataCodigosCortos, function(item, key){
                  aprobadoresGerencias.push({id : 'Aprobador-'+item, nombre:'Aprobador-'+item})
                });
            });

            $scope.selectAprobadores = {
                availableOptions: aprobadoresGerencias,
                //selectedOption: {id: row.entity.Informe, nombre: row.entity.Informe}
            };

        $scope.loader = false;
        $scope.tablaDetalle = true;
        
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(row.isSelected == true)
            {
                $scope.botonDos = true;
                if(row.entity.Id != 0)
                    $scope.id = row.entity.Id;
                    $scope.form.id = row.entity.Id;
                    $scope.form.email = row.entity.Email;

                    $scope.selectAprobadores = {
                        availableOptions: aprobadoresGerencias,
                        selectedOption: {id: row.entity.Informe, nombre: row.entity.Informe}
                    };  
            }
            else
            {
                $scope.id = "";
                $scope.botonDos = false;
                $scope.formulario = false;
                $scope.form.id = "";
                $scope.form.tipo = "editar"
            }
        })

        $scope.editarAprobador = function(id)
        {
            $scope.formulario = true;
            $scope.tituloBoton = "Editar Aprobador"
            $scope.clase = "btn btn-primary";
            $scope.form.tipo = "editar"

        }

        $scope.addAprobador = function(id)
        {
            $scope.formulario = true;
            $scope.tituloBoton = "registrar Aprobador"
            $scope.clase = "btn btn-primary";
            $scope.form.tipo = "add"
            $scope.form.id = "";
            $scope.form.email = "";
            $scope.selectAprobadores = {
                availableOptions: aprobadoresGerencias,
               // selectedOption: {id: row.entity.Informe, nombre: row.entity.Informe}
            };


        }

        $scope.submitForm = function() {

            if($scope.form.tipo === "editar")
            {
                comprasServices.editarAprobador($scope.form.id, $scope.form.email, $scope.form.tipo, $scope.selectAprobadores.selectedOption.nombre).success(function(mensaje){
                    if(mensaje.Error == 1)
                    {
                        comprasServices.listaAprobadores().success(function(data){
                            $scope.gridOptions.data = data;
                        });

                        Flash.create('success', mensaje.Mensaje, 'customAlert');
                        $scope.form.id = "";
                        $scope.form.email = "";
                        $scope.boton = false;
                        $scope.formulario = false;
                    }
                    else
                    {
                        Flash.create('danger', mensaje.Mensaje, 'customAlert');
                    }
                })
            }

            if($scope.form.tipo === "add")
            {

                comprasServices.aprobadorAdd($scope.form.id, $scope.form.email, $scope.form.tipo, $scope.selectAprobadores.selectedOption.nombre).success(function(mensaje){
                    if(mensaje.Error == 1)
                    {
                        comprasServices.listaAprobadores().success(function(data){
                            $scope.gridOptions.data = data;
                        });
                        Flash.create('success', mensaje.Mensaje, 'customAlert');
                        $scope.form.id = "";
                        $scope.form.email = "";
                        $scope.boton = false;
                        $scope.formulario = false;
                    }
                    else
                    {
                        Flash.create('danger', mensaje.Mensaje, 'customAlert');
                    }
                })
            }
        };

        $scope.confirmacion = function(id){
            comprasServices.aprobadorDelete(id).success(function(mensaje){
                if(mensaje.Error == 1)
                {
                    comprasServices.listaAprobadores().success(function(data){
                        $scope.gridOptions.data = data;
                    });
                    Flash.create('success', mensaje.Mensaje, 'customAlert');
                    $scope.form.id = "";
                    $scope.form.email = "";
                    $scope.boton = false;
                    $scope.formulario = false;
                }
                else
                {
                    Flash.create('danger', mensaje.Mensaje, 'customAlert');
                }
            })
        }

        $scope.refreshData = function (termObj) {
            $scope.gridOptions.data = data;
            
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });
}]);