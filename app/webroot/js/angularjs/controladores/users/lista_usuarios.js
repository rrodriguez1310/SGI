app.controller('ListaUsers', ['$scope', 'listaUsers', 'listaRolesNombres', 'listaRoles', 'paginasRoles', 'Flash', '$http', '$filter', '$location', 'uiGridConstants', function ($scope, listaUsers, listaRolesNombres, listaRoles, paginasRoles, Flash, $http, $filter, $location, uiGridConstants) {
    $scope.showModal = false;
    $scope.tablaDetalle = false;
    $scope.loader = true
    $scope.cargador = loader;
    
    $scope.idRol = "";
    
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
        {name:'UsuarioId', displayName:'Id', visible: true, sort : {direction: uiGridConstants.ASC,priority: 1}, width: '15%'},
        {name: 'UsuarioNombre', displayName: 'Nombre Usuario', width: '85%'},
        {name: 'RoleNombre', visible : false},
        {name: 'RoleId', visible : false},
    ];
    listaUsuarios = function(){
        listaUsers.listaUsers().success(function(data){
            $scope.gridOptions.data = data;
            $scope.loader = false;
            $scope.tablaDetalle = true;
           
            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                
                if(row.isSelected == true)
                {   
                	$scope.idUsuario = row.entity.UsuarioId;
                    
                    
                    $scope.id = row.entity.UsuarioId;
                    $scope.boton = true;

                    listaUsers.rolesUsuario(row.entity.UsuarioId).success(function(idRoles){
                        $scope.cuentaSeleccionados = (idRoles.split(",")).length;
                        ////lista al buelo los nombres de los roles.
                        /*listaRolesNombres.listaRolesNombres(idRoles).success(function(dataNombresRoles){
                            $scope.cantRoles = dataNombresRoles.length;
                            $scope.nombreRoles = dataNombresRoles;
                            console.log($scope.nombreRoles);
                            $scope.idRol = row.entity.RoleId;
                        });*/

                        listaRoles.listaRoles().success(function(roles){
                            $scope.roles = roles;
                            $scope.cantRolesCreados = roles.length;

                            $scope.seleccionaRoles = JSON.parse("[" + idRoles.trim() + "]");//row.entity.UsuarioRolesId.split(",");
                            $scope.rolesSeleccionados = function rolesSeleccionados(idRolesSeleccionados) {
                            	
                                var seleccionado = $scope.seleccionaRoles.indexOf(idRolesSeleccionados);
                                if (seleccionado > -1)
                                {
                                    $scope.seleccionaRoles.splice(seleccionado, 1);
                                }
                                else
                                {
                                    $scope.seleccionaRoles.push(idRolesSeleccionados);
                                }
                                $scope.cuentaSeleccionados = $scope.seleccionaRoles.length;
                            };

                            
                        });
                    });
                }
                 else
                 {
                    $scope.cuentaSeleccionados = undefined;
                    $scope.cantRolesCreados = undefined;
                    $scope.UsuarioId = "";
                    $scope.boton = false;
                    $scope.nombreRoles = "";
                    $scope.nombrePaginas = "";
                    $scope.cantRoles = "";
                    $scope.cantPaginas = "";
                    $scope.seleccionaRoles = [];
                    $scope.roles = "";
                 }
            });
            var idRolSeleccionado = "";
            var idPaginaSeleccionado = "";
            $scope.paginasAsociadas = function(idRol)
            {
                if(idRol != "")
                {
                    $scope.idRolSeleccionado = idRol;
                    paginasRoles.paginasAsociadasRoles(idRol).success(function(dataNombreRoles){
                        $scope.nombrePaginas = dataNombreRoles;
                        $scope.cantPaginas = dataNombreRoles.length;
                    })
                }
            };
            
            $scope.guardarAsociacion = function(rolesAsociados)
            {
                listaUsers.addUserRol($scope.idUsuario, rolesAsociados.join()).success(function(mensaje){
                    
                    if(mensaje.Error === 0)
                    {
                        Flash.create('danger', mensaje.Mensaje, 'customAlert');
                    }
                    else
                    {
                        Flash.create('success', mensaje.Mensaje, 'customAlert');
                    }
                    
                });
            }

            $scope.refreshData = function (termObj){
                $scope.gridOptions.data = data;
                while (termObj){
                    var oSearchArray = termObj.split(' ');
                    $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                    oSearchArray.shift();
                    termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                }
            };

            $scope.toggleModal = function(idPagina){

                $scope.paginaId = idPagina;
                if(idPagina != null)
                {
                    $scope.showModal = !$scope.showModal;
                    if($scope.showModal == true)
                    {
                        $scope.titulo = "Selección de botones para mostrar en la pagina";

                        listaUsers.botonesPorPagina(idPagina).success(function(dataBotones){
                            if(dataBotones != "")
                            {
                                $scope.botones = dataBotones;

                                 listaUsers.botonesRol(idPagina, $scope.idRolSeleccionado).success(function(botonesSeleccionadosData){
                                   $scope.seleccionaBotones = botonesSeleccionadosData;
                                 })

                                $scope.botonesSeleccionados = function rolesSeleccionados(idBotonesSeleccionados) {
                                    var seleccionado = $scope.seleccionaBotones.indexOf(idBotonesSeleccionados);
                                    if (seleccionado > -1)
                                    {
                                        $scope.seleccionaBotones.splice(seleccionado, 1);
                                    }
                                    else
                                    {
                                        $scope.seleccionaBotones.push(idBotonesSeleccionados);
                                    }
                                };
                            }
                        });

                        $scope.guardarPaginasBotones = function(seleccionaBotones, idPagina)
                        {

                            idPagina = $scope.paginaId
                            if(seleccionaBotones.length == 0)
                            {
                               Flash.create('danger', "Seleccione almenos un boton", 'customAlert'); 
                               return false;
                            }
                            else
                            {
                                listaUsers.addBotonesPaginas(seleccionaBotones.join(), idPagina, $scope.idRolSeleccionado).success(function(mensaje){
                                    $scope.hiddenModal = !$scope.hiddenModal;
                                    if(mensaje.Error === 0)
                                    {
                                        angular.element('.cerrar').trigger('click');
                                        Flash.create('danger', mensaje.Mensaje, 'customAlert');
                                    }
                                    else
                                    {
                                        angular.element('.cerrar').trigger('click');
                                        Flash.create('success', mensaje.Mensaje, 'customAlert');
                                    }
                                });
                            }
                        }

                        $scope.eliminaPaginasBotones = function(seleccionaBotones, idPagina)
                        {
                            idPagina = $scope.paginaId
                            if(seleccionaBotones.length == 0)
                            {
                               Flash.create('danger', "Seleccione almenos un boton", 'customAlert'); 
                               return false;
                            }
                            else
                            {
                                listaUsers.deleteBotonesPaginas(seleccionaBotones.join(), idPagina, $scope.idRolSeleccionado).success(function(mensaje){
                                    $scope.hiddenModal = !$scope.hiddenModal;
                                    if(mensaje.Error === 0)
                                    {
                                        Flash.create('danger', mensaje.Mensaje, 'customAlert');
                                    }
                                    else
                                    {
                                        Flash.create('success', mensaje.Mensaje, 'customAlert');
                                    }
                                });
                            }
                        }
                    }
                }
                else
                {
                    Flash.create('danger', "Ocurrio un error al seleccionar la pagina", 'customAlert');
                }
            };

            $scope.confirmacion = function(){
                listaUsers.delete($scope.id).success(function (data){
                    if(data.estado == 1){
                        listaUsuarios();
                        Flash.create('success', data.mensaje, 'customAlert');
                        $scope.cuentaSeleccionados = undefined;
                        $scope.cantRolesCreados = undefined;
                        $scope.UsuarioId = "";
                        $scope.boton = false;
                        $scope.nombreRoles = "";
                        $scope.nombrePaginas = "";
                        $scope.cantRoles = "";
                        $scope.cantPaginas = "";
                        $scope.seleccionaRoles = [];
                        $scope.roles = "";
                        $scope.gridApi.selection.clearSelectedRows();
                    }else{
                        Flash.create('danger', data.mensaje, 'customAlert');
                    }
                });
            };
        });
    };
    listaUsuarios();
}]);