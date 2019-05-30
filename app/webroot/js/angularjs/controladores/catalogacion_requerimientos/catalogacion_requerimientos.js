app.controller('catalogacionRequerimientosAdd', function ($scope, $q, $filter, $window, Flash, catalogacionRequerimientosService, soportesFactory, formatosFactory, copiasFactory){
	$scope.loader = true;
    $scope.cargador = loader;
	angular.element(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart:1,
        startDate: 'today',
        daysOfWeekDisabled : [0,6]
    });

    angular.element(".clockpicker").clockpicker({
		placement:'bottom',
		align: 'top',
		autoclose:true
	});
	$scope.tiposPorId = {};
	angular.forEach($scope.tiposList, function(tipo){
		$scope.tiposPorId[tipo.id] = tipo;
	});
	/*$scope.tipoEntregas = [
		{id: 0, nombre: "Digital"}, 
		{id: 1, nombre: "Fisica"}
	];*/
    $scope.tipoEntregas = $filter("orderBy")(catalogacionRequerimientosService.tipoEntregas(), "nombre");
    $scope.publicoList = $filter("orderBy")(catalogacionRequerimientosService.publicoList(), "nombre");
    $scope.produccionCDFList = $filter("orderBy")(catalogacionRequerimientosService.produccionCDFList(), "nombre");
    $scope.tipoImagenList = $filter("orderBy")(catalogacionRequerimientosService.tipoImagenList(), "nombre");
    $scope.tiposPlanoList = $filter("orderBy")(catalogacionRequerimientosService.tiposPlanoList(), "nombre");
    $scope.logoPosicionList = $filter("orderBy")(catalogacionRequerimientosService.logoPosicionList(), "nombre");
	/*$scope.logoPosicionList = $filter("orderBy")([
		{id: 0, nombre: "Izquierda"},
		{id: 1, nombre: "Derecha"},
		{id: 2, nombre: "Centro"}
	], "nombre");*/

	$scope.formulario = {};
	$scope.formulario.CatalogacionRequerimiento = {};
	$scope.formulario.CatalogacionRTag = [];
	$scope.detalle = {};
	promesas = [];
	promesas.push(catalogacionRequerimientosService.selectsRequerimientos());
	$q.all(promesas).then(function (data){
		$scope.ShowContenido = true;
		$scope.loader = false;
		$scope.soportesList =$filter("orderBy")(soportesFactory.soportesPorTipo(data[0].data.soportes, 1), "nombre");
		$scope.formatosList = $filter("orderBy")(formatosFactory.formatoPorTipo(data[0].data.formatos, 1), "nombre");
		$scope.copiasList = $filter("orderBy")(copiasFactory.copiasPorTipo(data[0].data.copias, 1), "copia");
		$scope.equiposList = $filter("orderBy")(data[0].data.equipos, "nombre");
		$scope.campeonatosList = $filter("orderBy")(data[0].data.campeonatos, "nombre");
		$scope.tipoRequerimientosList = $filter("orderBy")(data[0].data.requerimietos_tipos, "nombre");
		$scope.tiposList = $filter("orderBy")(data[0].data.tags_tipos, "nombre");
        $scope.servidoresList = $filter("orderBy")(data[0].data.ingesta_servidores, "nombre");
		angular.forEach($scope.tiposList, function(tipo){
			$scope.tiposPorId[tipo.id] = tipo;
		});
	});
	
	
	$scope.agregarDetalle = function (){
		$scope.formulario.CatalogacionRTag.push({ catalogacion_r_tags_tipo_id: $scope.detalle.tipo, valor: $scope.detalle.valor});
		$scope.detalle.tipo = undefined;
		$scope.detalle.valor = undefined;
	};

	$scope.eliminarDetalle = function(posicion){
		$scope.formulario.CatalogacionRTag.splice(posicion,1);
	};

	$scope.registrarRequerimiento = function(){
		$scope.registrando = true;
		fechaEntrega = $scope.entrega_fecha.split("/");
		$scope.formulario.CatalogacionRequerimiento.fecha_entrega = fechaEntrega[2]+"-"+fechaEntrega[1]+"-"+fechaEntrega[0]+" "+$scope.entrega_hora+":00";
		formulario = angular.copy($scope.formulario);
		catalogacionRequerimientosService.registrarCatalogacionRequerimiento(formulario).success(function (data){
			if(data.estado==1){
				$window.location = host+"catalogacion_requerimientos"
			}else{
				$scope.registrando = false;
				Flash.create('danger', data.mensaje, 'customAlert');
			}
		})
	};

	$scope.cambioTipoEntrega = function (id){
		switch(id){
			case 0:
				delete $scope.formulario.CatalogacionRFisico
			break;
			case 1:
				delete $scope.formulario.CatalogacionRDigitale;
			break; 
		}
	};
	var primera = true;
	$scope.cambioTipoDetalle = function(){
		if(!primera){
			$scope.detalle.valor = undefined;
			primera = true;
		}else{
			primera = false;
		}		
	};
});

app.controller('catalogacionRequerimientosIndex', function ($scope, $window, $q, $filter, Flash, uiGridConstants, catalogacionRResponsablesFactory, usersFactory, catalogacionRequerimientosService, catalogacionRResponsablesService, listaUsers, catalogacionRTiposFactory){
    $scope.tiposResponsables = ["","Administrador", "Archivo", "Ingesta"];
    $scope.formulario = {
    	CatalogacionRequerimiento : {}
    }
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
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };
    $scope.gridOptions.columnDefs = [
    	{name:'fecha_creacion', displayName: 'Fecha Creación'},
        {name:'fecha_entrega', displayName: 'Fecha Entrega', sort: {
        	direction: uiGridConstants.ASC,
        	priority: 1
        },cellTemplate : "<div class='ui-grid-cell-contents'>{{row.entity.fecha_entrega}} <span ng-if='grid.appScope.advertenciaFecha(row.entity.fecha_entrega_UTC, row.entity.estado)' class='text-danger tool' title='Fecha actual superior a fecha de entrega'><i class='fa fa-exclamation-triangle'></i></div></span>"},
        {name:'tipo_requerimiento', displayName: 'Tipo requerimiento'},
        {name:'detalles', displayName: 'Detalle', cellTemplate: "<div class='ui-grid-cell-contents tool' title='{{row.entity.detalles}}'>{{row.entity.detalles}}</div>"},
        {name:'user', displayName: 'Creador'},
        {name:'responsable', displayName: 'Responsable'},
        {name:'estado', displayName: 'Estado', cellClass: function(row,rowRenderIndex, col, colRenderIndex) {
        	switch(rowRenderIndex.entity.estado){
        		case "Terminado" :
        			return "angular_aprobado_g";
        		break;
        		case "En Archivo":
        			return "angular_primary";
        		break;
        		case "Pendiente" :
        			return "angular_pendiente_g";
        		break;
        		case "En Ingesta" :
        			return "angular_info";
        		break;
        		case "Eliminado" :
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
        	if( nulls !== null ) {
            	return nulls;
        	} else {
        		switch(a){
        			case "Terminado" :
        				switch(b){
        					case "Terminado" :
        						return 0;
        					break;
        					case "Eliminado" :
        						return -1;
        					break;
        					default :
        						return 1;
        					break;
        				} 
        			break;
        			case "Pendiente":
        				switch(b){
        					case "Pendiente" :
        						return 0;
        					break;
        					default :
        						return -1;
        					break;

        				}
        			break;
        			case "En Archivo":
        				switch(b){
        					case "Pendiente":
        						return 1
        					break;
        					case "En Archivo":
        						return 0
        					break;
        					default :
        						return -1;
        					break;
        				}
        			break;
        			case "En Ingesta" :
        				switch(b){
        					case "Pendiente":
        						return 1
        					break;
        					case "En Archivo":
        						return 1
        					break;
        					case "En Ingesta":
        						return 0
        					break;
        					default :
        						return -1;
        					break;
        				}
        			break;
        			case "Eliminado" :
        				switch(b){
        					case "Eliminado":
        						return 0
        					break;
        					default :
        						return 1;
        					break;
        				}
        			break;
        		}
            }
   		}}
    ];

    var estadosRequerimientos = catalogacionRequerimientosService.estadosRequerimientos();
    $scope.usuarioId = function (usuarioId){
    	$scope.ShowContenido = false;
    	$scope.loader = true;
    	$scope.cargador = loader;
    	var usuarioId = usuarioId;
    	catalogacionRResponsablesService.catalogacionRResponsableXUsuario(usuarioId).success(function (responsable){
    		switch(responsable.estado){
    			case 1:
    				if(responsable.data.CatalogacionRResponsable.admin==1){
    					$scope.responsableTipo = 1;
    					listado = catalogacionRequerimientosService.catalogacionRequerimientos();
    				}else{
    					$scope.responsableTipo = 0;
	    				listado = catalogacionRequerimientosService.catalogacionRequerimientosUsuarioOrResponsable(usuarioId, responsable.data.CatalogacionRResponsable.id);
    				}    				
    			break;    			
    			case 2:
    				listado = catalogacionRequerimientosService.catalogacionRequerimientosUsuario(usuarioId);
    			break;
    			default :
    				$window.location = host+"catalogacion_requerimientos/add";
    			break;
    		}
    		listado.success(function (catalogacionRequerimientos){
				if(catalogacionRequerimientos.estado == 1){
    				promesas = [];
    				promesas.push(catalogacionRequerimientosService.selectsRequerimientos());
    				promesas.push(listaUsers.listaUsers());
    				promesas.push(catalogacionRResponsablesService.catalogacionRResponsablesList());
    				$q.all(promesas).then(function (data){
    					$scope.loader = false;
						$scope.ShowContenido = true;
						$scope.catalogacionRResponsablesList = data[2].data;
						$scope.responsablesPorId = catalogacionRResponsablesFactory.responsablesPorId(data[2].data);
						$scope.responsablesPorUsuario = catalogacionRResponsablesFactory.responsablesPorUsuario(data[2].data);
						$scope.usuariosPorId = usersFactory.usersPorId(data[1].data);
						$scope.responsable = $scope.responsablesPorUsuario[usuarioId];
    					catalogacionTipos = catalogacionRTiposFactory.catalogacionRTiposPorId(data[0].data.requerimietos_tipos);
    					$scope.requerimientos = [];
    					angular.forEach(catalogacionRequerimientos.data, function (requerimiento){
    						tagsValores = "";
    						if(requerimiento.CatalogacionRTag.length!=0){
    							tagArray = [];
    							angular.forEach(requerimiento.CatalogacionRTag, function(tag){
    								tagArray.push('"'+tag.valor+'"');
    							});
    							tagsValores = tagArray.join(",");
    						}
    						$scope.requerimientos.push({
    							id: requerimiento.CatalogacionRequerimiento.id,
    							fecha_creacion: $filter("date")(requerimiento.CatalogacionRequerimiento.created, "yyyy-MM-dd HH:mm"),
    							fecha_entrega: $filter("date")(requerimiento.CatalogacionRequerimiento.fecha_entrega, "yyyy-MM-dd HH:mm", "UTC"),
    							fecha_entrega_UTC : requerimiento.CatalogacionRequerimiento.fecha_entrega,
    							tipo_requerimiento: angular.uppercase(catalogacionTipos[requerimiento.CatalogacionRequerimiento.catalogacion_r_tipo_id].nombre),
    							detalles: tagsValores,
    							user: $scope.usuariosPorId[requerimiento.CatalogacionRequerimiento.user_id].UsuarioNombre,
    							user_id: requerimiento.CatalogacionRequerimiento.user_id,
    							responsable : (angular.isNumber(requerimiento.CatalogacionRequerimiento.catalogacion_r_responsable_id)) ? $scope.usuariosPorId[$scope.responsablesPorId[requerimiento.CatalogacionRequerimiento.catalogacion_r_responsable_id].user_id].UsuarioNombre : "",
    							estado: estadosRequerimientos[requerimiento.CatalogacionRequerimiento.estado]
    						});
    					});
				    	$scope.gridOptions.data = $scope.requerimientos;
				    	$scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
					        if(angular.isNumber(row.entity.id))
					        {
					            $scope.id = row.entity.id;
					        }
					        if(row.isSelected == true)
					        {
					            $scope.boton = true;
					            $scope.btncatalogacion_requerimientosasignar_responsable = true;
					            $scope.btncatalogacion_requerimientosedit = true;
					            $scope.btncatalogacion_requerimientosterminar_requerimiento = true;
					            $scope.btncatalogacion_requerimientosbatch_requerimiento = true;
					            $scope.btncatalogacion_requerimientosdelete = true;
					            if(angular.isDefined($scope.responsableTipo)){
					            	switch($scope.responsableTipo){
					            		case 1 :
					            			$scope.btncatalogacion_requerimientosasignar_responsable = false;
					            			$scope.btncatalogacion_requerimientosedit = false;
					            			$scope.btncatalogacion_requerimientosterminar_requerimiento = false;
					            			$scope.btncatalogacion_requerimientosbatch_requerimiento = false;
					            			$scope.btncatalogacion_requerimientosdelete = false;
					            			/*switch(row.entity.estado){
							            		case "Pendiente" : $scope.btncatalogacion_requerimientosedit = false;
							            		break;
							            	}*/
							            break;
							            default :
							            	$scope.btncatalogacion_requerimientosasignar_responsable = true;
							            	$scope.btncatalogacion_requerimientosedit = true;
							            	$scope.btncatalogacion_requerimientosbatch_requerimiento = false;
							            	$scope.btncatalogacion_requerimientosterminar_requerimiento = false;
							            	if(row.entity.user_id==usuarioId && row.entity.estado == "Pendiente"){
							            		$scope.btncatalogacion_requerimientosedit = false;
							            		$scope.btncatalogacion_requerimientosdelete = false;
							            	}
							            break;
					            	}
					            		
					            }else{
					            	if(row.entity.estado=="Pendiente"){
					            		$scope.btncatalogacion_requerimientosedit = false;
					            		$scope.btncatalogacion_requerimientosdelete = false;
					            	}
					            }
					            if(row.entity.estado=="Terminado" || row.entity.estado=="Eliminado"){
					            	$scope.btncatalogacion_requerimientosbatch_requerimiento = true;
					            	$scope.btncatalogacion_requerimientosterminar_requerimiento = true;
					            	$scope.btncatalogacion_requerimientosedit = true;
					            	$scope.btncatalogacion_requerimientosasignar_responsable = true;
					            	$scope.btncatalogacion_requerimientosdelete = true;
					            }
					            
					        }
					        else
					        {
					            $scope.boton = false;
					            $scope.id = "";
					        }
					    });
    				})
    			}else{    				
    				c = confirm("No tiene requerimientos\n¿Desea crear uno?");
    				if(c){
    					$window.location = host+"catalogacion_requerimientos/add"
    				}else{
    					$scope.loader = false;
    					Flash.create('danger', catalogacionRequerimientos.mensaje, 'customAlert');
    				}
    			}
    		});
    	})
		$scope.catalogacionResponsable = function(){
			$scope.formulario.CatalogacionRequerimiento.id = $scope.id;
			($scope.responsablesPorId[$scope.formulario.CatalogacionRequerimiento.catalogacion_r_responsable_id].tipo == 3) ? $scope.formulario.CatalogacionRequerimiento.estado = 3 : $scope.formulario.CatalogacionRequerimiento.estado = 2;
			catalogacionRequerimientosService.registrarAsignarResponsable($scope.formulario).success(function (data){
				if(data.estado==1){
					Flash.create('success', data.mensaje, 'customAlert');
					$scope.cerrarModal();
					$scope.usuarioId(usuarioId);
					$scope.id = undefined;
					$scope.gridApi.selection.clearSelectedRows();
					$scope.boton = false;
				}else{
					$scope.registrando = false;
					Flash.create('danger', data.mensaje, 'customAlert');
				}
			});
		}
		$scope.confirmacion = function(){
			eliminacion = {
				CatalogacionRequerimiento : {
					id : $scope.id,
					estado : 0
				}
			}
			catalogacionRequerimientosService.eliminarRequerimiento(eliminacion).success(function (data){
				if(data.estado==1){
					Flash.create('success', data.mensaje, 'customAlert');
					$scope.usuarioId(usuarioId);
					$scope.id = undefined;
					$scope.gridApi.selection.clearSelectedRows();
					$scope.boton = false;
				}else{
					Flash.create('danger', data.mensaje, 'customAlert');
				}
			});
		}
    }
    $scope.refreshData = function (termObj) {
        $scope.gridOptions.data = $scope.requerimientos;
        while (termObj) {
            var oSearchArray = termObj.split(' ');
            $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
            oSearchArray.shift();
            termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
        }
    };

    $scope.advertenciaFecha = function(fechaEntrega, estado){
    	fechaEntrega = $filter("date")(fechaEntrega, "yyyy,MM,dd,HH,mm,00", "UTC");
    	fechaEntregaArray = fechaEntrega.split(",");
    	fecha_entrega = new Date(fechaEntregaArray[0], parseInt(fechaEntregaArray[1])-1, parseInt(fechaEntregaArray[2]), fechaEntregaArray[3], fechaEntregaArray[4], fechaEntregaArray[5]);
    	fecha_actual = new Date();
    	respuesta = false;
    	if(fecha_entrega.getTime() < fecha_actual.getTime() && (estado == "Pendiente" || estado == "En Ingesta" || estado == "En Archivo")){
    		respuesta = true;
    	}
    	return respuesta;
    };

    $scope.asignarResponsableModal = function(){
    	$scope.showModal = true;
    };

 
	$scope.cerrarModal = function (){
        $scope.showModal = false;
        $scope.formulario = undefined;
		$scope.formulario = {
			CatalogacionRequerimiento : {}
		}
    }
});

app.controller('catalogacionRequerimientosEdit', function ($scope, $q, $filter, $window, Flash, catalogacionRequerimientosService, soportesFactory, formatosFactory, copiasFactory){
	$scope.loader = true;
    $scope.cargador = loader;
	angular.element(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart:1,
        startDate: 'today',
    });

    angular.element(".clockpicker").clockpicker({
		placement:'bottom',
		align: 'top',
		autoclose:true
	});

	$scope.requerimientoId = function (requerimientoId)
	{
		$scope.tiposPorId = {};
		angular.forEach($scope.tiposList, function(tipo){
			$scope.tiposPorId[tipo.id] = tipo;
		});
		$scope.tipoEntregas = [
			{id: 0, nombre: "Digital"}, 
			{id: 1, nombre: "Fisica"}
		];
		$scope.logoPosicionList = $filter("orderBy")([
			{id: 0, nombre: "Izquierda"},
			{id: 1, nombre: "Derecha"},
			{id: 2, nombre: "Centro"}
		], "nombre");

		$scope.formulario = {};
		$scope.formulario.CatalogacionRequerimiento = {};
		$scope.formulario.CatalogacionRTag = [];
		$scope.detalle = {};
		promesas = [];
		promesas.push(catalogacionRequerimientosService.selectsRequerimientos());
		promesas.push(catalogacionRequerimientosService.catalogacionRequerimiento(requerimientoId));
		$q.all(promesas).then(function (data){
			$scope.soportesList =$filter("orderBy")(soportesFactory.soportesPorTipo(data[0].data.soportes, 1), "nombre");
			$scope.formatosList = $filter("orderBy")(formatosFactory.formatoPorTipo(data[0].data.formatos, 1), "nombre");
			$scope.copiasList = $filter("orderBy")(copiasFactory.copiasPorTipo(data[0].data.copias, 1), "copia");
			$scope.equiposList = $filter("orderBy")(data[0].data.equipos, "nombre");
			$scope.campeonatosList = $filter("orderBy")(data[0].data.campeonatos, "nombre");
			$scope.tipoRequerimientosList = $filter("orderBy")(data[0].data.requerimietos_tipos, "nombre");
			$scope.tiposList = $filter("orderBy")(data[0].data.tags_tipos, "nombre");
            $scope.servidoresList = $filter("orderBy")(data[0].data.ingesta_servidores, "nombre");
			angular.forEach($scope.tiposList, function(tipo){
				$scope.tiposPorId[tipo.id] = tipo;
			});
            fechaArray = (data[1].data.data.CatalogacionRequerimiento.fecha_entrega.substring(0, 10)).split("-");
            horaArray = (data[1].data.data.CatalogacionRequerimiento.fecha_entrega.substring(11)).split(":");
            $scope.entrega_fecha = fechaArray[2]+"/"+fechaArray[1]+"/"+fechaArray[0];
            $scope.entrega_hora = horaArray[0]+":"+horaArray[1];
			if(angular.isDefined(data[1].data.data.CatalogacionRFisico)){
				if(data[1].data.data.CatalogacionRFisico.estado  == 1){
					delete data[1].data.data.CatalogacionRDigitale;
					$scope.tipoEntrega = 1;
				}
			}
			if(angular.isDefined(data[1].data.data.CatalogacionRDigitale)){
				if(data[1].data.data.CatalogacionRDigitale.estado  == 1){
					delete data[1].data.data.CatalogacionRFisico;
					$scope.tipoEntrega = 0;
				}
			}
			delete data[1].data.data.CatalogacionRResponsable;
			delete data[1].data.data.CatalogacionRTipo;
			delete data[1].data.data.User;
			angular.forEach(data[1].data.data, function (datos, modelo){
				delete data[1].data.data[modelo].created;
				delete data[1].data.data[modelo].modified;
				if(angular.isArray(data[1].data.data[modelo])){
					angular.forEach(data[1].data.data[modelo], function (valores, key){
						delete data[1].data.data[modelo][key].created;
						delete data[1].data.data[modelo][key].modified;
					});
				}
			});
			$scope.formulario = data[1].data.data;
			$scope.ShowContenido = true;
			$scope.loader = false;
		});	
		
		$scope.agregarDetalle = function (){
			$scope.formulario.CatalogacionRTag.push({ catalogacion_r_tags_tipo_id: $scope.detalle.tipo, valor: $scope.detalle.valor, estado: 1});
			$scope.detalle.tipo = undefined;
			$scope.detalle.valor = undefined;
		};

		$scope.eliminarDetalle = function(posicion){
			if(angular.isDefined($scope.formulario.CatalogacionRTag[posicion].id)){
				$scope.formulario.CatalogacionRTag[posicion].estado = 0;
			}else{
				$scope.formulario.CatalogacionRTag.splice(posicion,1);	
			}
		}

		$scope.registrarRequerimiento = function(){
			$scope.registrando = true;
			fechaEntrega = $scope.entrega_fecha.split("/");
			$scope.formulario.CatalogacionRequerimiento.fecha_entrega = fechaEntrega[2]+"-"+fechaEntrega[1]+"-"+fechaEntrega[0]+" "+$scope.entrega_hora+":00";
			formulario = angular.copy($scope.formulario);
			catalogacionRequerimientosService.registrarCatalogacionRequerimiento(formulario).success(function (data){
				if(data.estado==1){
					$window.location = host+"catalogacion_requerimientos"
				}else{
					$scope.registrando = false;
					Flash.create('danger', data.mensaje, 'customAlert');
				}
			})
		};

		$scope.cambioTipoEntrega = function (id){
			switch(id){
				case 0:
					delete $scope.formulario.CatalogacionRFisico
				break;
				case 1:
					delete $scope.formulario.CatalogacionRDigitale;
				break; 
			}
		};
	}
});

app.controller('catalogacionRequerimientosBatchRequerimiento', function ($scope, $q, $window, Flash, catalogacionRResponsablesService, catalogacionRResponsablesFactory, listaUsers, usersFactory, catalogacionRequerimientosService, catalogacionRequerimientosFactory){
	$scope.loader = true;
    $scope.cargador = loader;
    $scope.disabledForm = true;
    $scope.entradaClass = true;
    $scope.salidaClass = true;
    $scope.tiposResponsables = ["","Administrador", "Archivo", "Ingesta"];
    $scope.minutos = catalogacionRequerimientosFactory.arregloMinutos();
    $scope.horas = catalogacionRequerimientosFactory.arregloHoras();
    $scope.cuadros = catalogacionRequerimientosFactory.arregloCuadros();
    $scope.formulario = {
        CatalogacionRequerimiento : {},
        CatalogacionRIngesta : []
    };
    $scope.batch = {};
	$scope.requerimientoId = function (requerimientoId, usuarioId){
		promesas = [];
		promesas.push(catalogacionRResponsablesService.catalogacionRResponsablesList());
		promesas.push(listaUsers.listaUsers());
		promesas.push(catalogacionRequerimientosService.catalogacionRequerimiento(requerimientoId));
		$q.all(promesas).then(function (data){
			if(data[2].data.data.CatalogacionRIngesta.length != 0){
				$scope.editando = true;
				delete data[2].data.data.CatalogacionRDigitale;
				delete data[2].data.data.CatalogacionRFisico;
				delete data[2].data.data.CatalogacionRResponsable;
				delete data[2].data.data.CatalogacionRTag;
				delete data[2].data.data.CatalogacionRTipo;
				delete data[2].data.data.User;
				angular.forEach(data[2].data.data, function (datos, modelo){
					delete data[2].data.data[modelo].created;
					delete data[2].data.data[modelo].modified;
					if(angular.isArray(data[2].data.data[modelo])){
						angular.forEach(data[2].data.data[modelo], function (valores, key){
							delete data[2].data.data[modelo][key].created;
							delete data[2].data.data[modelo][key].modified;
						});
					}
				});
				$scope.formulario = data[2].data.data;
			}
			$scope.loader = false;
			$scope.ShowContenido = true;
			$scope.catalogacionRResponsablesList = data[0].data;
			$scope.responsablesPorId = catalogacionRResponsablesFactory.responsablesPorId(data[0].data);
			$scope.responsablesPorUsuario = catalogacionRResponsablesFactory.responsablesPorUsuario(data[0].data);
			$scope.usuariosPorId = usersFactory.usersPorId(data[1].data);
			$scope.tipoResponsable = $scope.responsablesPorUsuario[usuarioId].tipo;
			//console.log($scope.responsablesPorUsuario);
		});
		$scope.registrarBatchRequerimiento  = function(){
			$scope.formulario.CatalogacionRequerimiento.id = requerimientoId;
			formulario = angular.copy($scope.formulario);
			catalogacionRequerimientosService.registrarBatchRequerimiento(formulario).success(function (data){
				if(data.estado==1){
					$window.location = host+"catalogacion_requerimientos"
				}else{
					$scope.registrando = false;
					Flash.create('danger', data.mensaje, 'customAlert');
				}
			});
		}
	}

	$scope.$watch("batch", function (valores){
		if(angular.isDefined(valores)){
			if($scope.formulario.CatalogacionRIngesta.length == 0){
				if(angular.isDefined(valores.horasIn) && angular.isDefined(valores.minutosIn) && angular.isDefined(valores.segundosIn) && angular.isDefined(valores.bloquesIn)){
					$scope.entradaClass = false;
				}
				if(angular.isDefined(valores.horasOut) && angular.isDefined(valores.minutosOut) && angular.isDefined(valores.segundosOut) && angular.isDefined(valores.bloquesOut)){
					$scope.salidaClass = false;
				}	
			}
			
			if(Object.keys(valores).length==10){
				$scope.batchDisabled = false;
				angular.forEach(valores, function(valor){
					(angular.isUndefined(valor)) ? $scope.batchDisabled = true : "";
				});
			}else{
				$scope.batchDisabled = true;
			}
		}
	}, true);

	$scope.agregarDetalle = function(){
		correcto = false;
		entrada = new Date(2000, 0,1,parseInt($scope.batch.horasIn), parseInt($scope.batch.minutosIn),parseInt($scope.batch.segundosIn));
		salida = new Date(2000, 0,1,parseInt($scope.batch.horasOut), parseInt($scope.batch.minutosOut),parseInt($scope.batch.segundosOut));
		if(entrada.getTime()<=salida.getTime()){
			if(entrada.getTime()==salida.getTime()){
				if(parseInt($scope.batch.bloquesIn)<=parseInt($scope.batch.bloquesOut)){
					correcto = true;
				}else{
					Flash.create('danger', "El cuandro de entrada no puede ser menor que el de salida", 'customAlert');
				}
			}else{
				correcto = true;
			}
			if(correcto){				
				$scope.formulario.CatalogacionRIngesta.push({
					nombre: $scope.batch.nombre,
					reel: $scope.batch.reel,
					entrada: $scope.batch.horasIn+":"+$scope.batch.minutosIn+":"+$scope.batch.segundosIn+":"+$scope.batch.bloquesIn,
					salida: $scope.batch.horasOut+":"+$scope.batch.minutosOut+":"+$scope.batch.segundosOut+":"+$scope.batch.bloquesOut,
					estado : 1
				});
				$scope.batchDisabled = true;
				$scope.batch.horasIn = undefined;
				$scope.batch.minutosIn = undefined;
				$scope.batch.segundosIn = undefined;
				$scope.batch.bloquesIn = undefined;
				$scope.batch.horasOut = undefined;
				$scope.batch.minutosOut = undefined;
				$scope.batch.segundosOut = undefined;
				$scope.batch.bloquesOut = undefined;
			}
		}else{
			Flash.create('danger', "La entrada no puede ser menor que la salida", 'customAlert');
		}
	};

	$scope.eliminarDetalle = function(posicion){
		if(angular.isDefined($scope.formulario.CatalogacionRIngesta[posicion].id)){
			$scope.formulario.CatalogacionRIngesta[posicion].estado = 0;
		}else{
			$scope.formulario.CatalogacionRIngesta.splice(posicion,1);	
		}
	};
});

app.controller('catalogacionRequerimientosView', function ($scope, $q, Flash,catalogacionRequerimientosService, soportesFactory, formatosFactory, copiasFactory, catalogacionRTiposFactory){
	$scope.ShowContenido = false;
	$scope.loader = true;
    $scope.cargador = loader;
    $scope.estadosRequerimientos = catalogacionRequerimientosService.estadosRequerimientos();
	$scope.requerimientoId = function (requerimientoId){
		promesas = [];
    	promesas.push(catalogacionRequerimientosService.selectsRequerimientos());
    	promesas.push(catalogacionRequerimientosService.catalogacionRequerimiento(requerimientoId));
    	$q.all(promesas).then(function (data){
    		$scope.soportes = soportesFactory.soportesPorId(data[0].data.soportes);
    		$scope.formatos = formatosFactory.formatosPorId(data[0].data.formatos);
    		$scope.copias = copiasFactory.copiasPorId(data[0].data.copias);
    		$scope.tagTipos = copiasFactory.copiasPorId(data[0].data.tags_tipos);
            $scope.ingestaServidores = copiasFactory.copiasPorId(data[0].data.ingesta_servidores);
    		$scope.ShowContenido = true;
			$scope.loader = false;
    		if(data[1].data.estado==1){
				$scope.requerimiento = data[1].data.data;
			}else{
				Flash.create('danger', data[1].data.mensaje, 'customAlert');
			}
    	})
	}
})

app.controller('catalogacionRequerimientosTerminarRequerimiento', function ($scope, $window, catalogacionRequerimientosService){
    $scope.cargador = loader;
    $scope.formulario = {
    	CatalogacionRequerimiento : {}
    };
	$scope.requerimientoId = function(requerimientoId){
		$scope.ShowContenido = true;
		$scope.formulario.CatalogacionRequerimiento.id = requerimientoId;
		$scope.formulario.CatalogacionRequerimiento.estado = 4;
		$scope.terminarRequerimiento = function(){
			catalogacionRequerimientosService.terminarRequerimiento($scope.formulario).success(function (data){
				if(data.estado==1){
					$window.location = host+"catalogacion_requerimientos"
				}else{
					$scope.registrando = false;
					Flash.create('danger', data.mensaje, 'customAlert');
				}
			});
		};
	}
});