app.controller('sistemasBitacorasAdd', function ($scope, $window, $q, $filter, Flash, sistemasBitacorasService, trabajadoresService, areasService, gerenciasService, listaUsers, usersFactory, sistemasResponsablesService, factoria){
	$scope.loader = true;
    $scope.cargador = loader;
	$scope.ShowContenido = false;
	$scope.formulario = {
		SistemasBitacora : {}
	};
	$scope.tiempo = {
		dias : 0,
		horas : 0,
		minutos : 0
	};
	angular.element(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart:1,
        //startDate: 'today'
    });

    fechaActual = new Date();
    $scope.inicio_fecha = ("0"+fechaActual.getDate()).slice(-2)+"/"+("0"+(fechaActual.getMonth()+1)).slice(-2)+"/"+fechaActual.getFullYear();
    $scope.termino_fecha = ("0"+fechaActual.getDate()).slice(-2)+"/"+("0"+(fechaActual.getMonth()+1)).slice(-2)+"/"+fechaActual.getFullYear();
    angular.element(".clockpicker").clockpicker({
		placement:'bottom',
		align: 'top',
		autoclose:true
	});
	promesas = [];
	promesas.push(areasService.areasList());
	promesas.push(gerenciasService.gerenciasList());
	promesas.push(listaUsers.listaUsers());
	promesas.push(sistemasResponsablesService.sistemasResponsablesList());
	$scope.usuarioId = function(usuarioId){
		$q.all(promesas).then(function (data){
			$scope.ShowContenido = true;
			$scope.loader = false;
			$scope.areasList = data[0].data.data;
			$scope.gerenciasList = data[1].data.data;
			usuariosPorId = usersFactory.usersPorId(data[2].data);
			responsables = [];
			angular.forEach(data[3].data, function (responsable){
				responsables.push({
					id : responsable.id,
					nombre : $filter("capitalize")(usuariosPorId[responsable.user_id].UsuarioNombre)
				});
			});
			$scope.responsablesList = $filter("orderBy")(responsables,"nombre");
			responsablesPorUsuarioId = factoria.arregloPorPropiedad(data[3].data, "user_id");
			if(responsablesPorUsuarioId[usuarioId].admin == 0){
				$scope.responsableReadOnly = true;
				$scope.formulario.SistemasBitacora.sistemas_responsable_id = responsablesPorUsuarioId[usuarioId].id;
				angular.element('#responsableId').select2('data', {id:responsablesPorUsuarioId[usuarioId].id, text : $scope.usuariosPorId[responsablesPorUsuarioId[usuarioId].user_id].UsuarioNombre});
			}
		});
	}
	$scope.cambiaGerencia = function(){  
		angular.element('#areas').select2('data', null);
		$scope.formulario.SistemasBitacora.area_id = undefined;
		$scope.trabajadoresList = [];
		angular.element('#trabajador').select2('data', null);
		$scope.formulario.SistemasBitacora.trabajadore_id = undefined;
	}

	$scope.registrarBitacora = function(){
		$scope.registrando = true;
		fechaInicio = $scope.inicio_fecha.split("/");
		fechaTermino = $scope.termino_fecha.split("/");
		horaInicio = $scope.inicio_hora.split(":");
		horaTermino = $scope.termino_hora.split(":");
		fechaInicioObj = new Date(fechaInicio[2], parseInt(fechaInicio[1])-1, parseInt(fechaInicio[0]),parseInt(horaInicio[0]),parseInt(horaInicio[1]));
		fechaTerminoObj = new Date(fechaTermino[2], parseInt(fechaTermino[1])-1, parseInt(fechaTermino[0]),parseInt(horaTermino[0]),parseInt(horaTermino[1]));
		if(fechaInicioObj.getTime() > fechaTerminoObj.getTime()){
			Flash.create('danger', "La fecha y hora de termino debe ser mayor a la de inicio", 'customAlert');
			$scope.registrando = false;
			return false;
		}
		$scope.formulario.SistemasBitacora.fecha_inicio = fechaInicio[2]+"-"+fechaInicio[1]+"-"+fechaInicio[0]+" "+$scope.inicio_hora+":00";
		$scope.formulario.SistemasBitacora.fecha_termino = fechaTermino[2]+"-"+fechaTermino[1]+"-"+fechaTermino[0]+" "+$scope.termino_hora+":00";
		$scope.formulario.SistemasBitacora.estado = 1;
		sistemasBitacorasService.registrarSistemasBitacora($scope.formulario).success(function (data){
			if(data.estado == 1){
				$window.location = host+"sistemas_bitacoras";
			}else{
				Flash.create('danger', data.mensaje, 'customAlert');
				$scope.registrando = false;
			}
		});
	}

	$scope.buscaTrabajadoresArea = function(){
		$scope.trabajadoresList = [];
		$scope.formulario.SistemasBitacora.trabajadore_id = undefined;
		angular.element('#trabajador').select2('data', null);
		if(angular.isDefined($scope.formulario.SistemasBitacora.area_id)){
			trabajadoresService.trabajadoresPorArea($scope.formulario.SistemasBitacora.area_id).success(function (trabajadores){
				angular.forEach(trabajadores, function(trabajador, id){
					$scope.trabajadoresList.push({
						id : id,
						nombre : trabajador
					});
				});
			});
		}
	}

	$scope.$watch("[inicio_fecha, inicio_hora, termino_fecha, termino_hora]", function(fechas, fechasAntiguas){
		if(angular.isDefined(fechas[0]) && angular.isDefined(fechas[1]) && angular.isDefined(fechas[2]) && angular.isDefined(fechas[3])){
			fechaInicio = $scope.inicio_fecha.split("/");
			fechaTermino = $scope.termino_fecha.split("/");
			horaInicio = $scope.inicio_hora.split(":");
			horaTermino = $scope.termino_hora.split(":");
			fechaInicioObj = new Date(fechaInicio[2], parseInt(fechaInicio[1])-1, parseInt(fechaInicio[0]),parseInt(horaInicio[0]),parseInt(horaInicio[1]));
			fechaTerminoObj = new Date(fechaTermino[2], parseInt(fechaTermino[1])-1, parseInt(fechaTermino[0]),parseInt(horaTermino[0]),parseInt(horaTermino[1]));
			if(fechaInicioObj.getTime() > fechaTerminoObj.getTime()){
				Flash.create('danger', "La fecha y hora de termino debe ser mayor a la de inicio", 'customAlert');
				angular.forEach(fechasAntiguas, function (fecha, key){
					if(fecha != fechas[key]){
						console.log(key);
						switch(key){
							case 0 :
								$scope.inicio_fecha = undefined;
							break;
							case 1 :
								$scope.inicio_hora = undefined;
							break;
							case 2 :
								$scope.termino_fecha = undefined;
							break;
							case 3 :
								$scope.termino_hora = undefined;
							break;
						}
					}
				});
				$scope.tiempo = {
					dias : 0,
					horas : 0,
					minutos : 0
				};
			}else{
				$scope.tiempo = factoria.calculoDifMilisecADiasMinSec(fechaTerminoObj.getTime(), fechaInicioObj.getTime());
			}
		}
	});
});

app.controller('sistemasBitacorasIndex', function ($scope, $q, $filter, sistemasBitacorasService, sistemasResponsablesService, listaUsers, areasService, factoria, trabajadoresService, uiGridConstants){
	$scope.cargador = loader;
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
    	{name:'titulo', displayName: 'Titulo', cellFilter : "uppercase", width : "20%"},
    	{name:'fecha_inicio', displayName: 'Fecha Inicio', sort: {
        	direction: uiGridConstants.ASC,
        	priority: 1
        }},
        {name:'fecha_termino', displayName: 'Fecha Termino'},
        {name:'fecha_cierre', displayName: 'Fecha Cierre'},
        {name:'tiempo_estimado', displayName: 'T. Estimado', cellTemplate : "<div class='ui-grid-cell-contents'>Dias:{{row.entity.tiempo_estimado.dias}} Horas:{{row.entity.tiempo_estimado.horas}} Minutos:{{row.entity.tiempo_estimado.minutos}}</div>"},
        //{name:'tiempo_final', displayName: 'T. Real', cellTemplate : "<div class='ui-grid-cell-contents' ng-if='row.entity.tiempo_final'>Dias:{{row.entity.tiempo_final.dias}} Horas:{{row.entity.tiempo_final.horas}} Minutos:{{row.entity.tiempo_final.minutos}}</div>"},
        {name:'area', displayName: 'Área'},
        {name:'user', displayName: 'Creador'},
        {name:'responsable', displayName: 'Responsable'},
        {name:'estado', displayName: 'Estado', cellClass: function(row,rowRenderIndex, col, colRenderIndex) {
        	switch(rowRenderIndex.entity.estado){
        		case "Cerrado" :
        			return "angular_aprobado_g";
        		break;
        		case "En Proceso" :
        			return "angular_pendiente_g";
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
        			case "Cerrado" :
        				switch(b){
        					case "Cerrado" :
        						return 0;
        					break;
        					default :
        						return 1;
        					break;
        				} 
        			break;
        			case "En Proceso":
        				switch(b){
        					case "En Proceso" :
        						return 0;
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
   	$scope.estados = ["Eliminado","En Proceso", "Cerrado"];
	$scope.usuarioId = function (usuarioId){
		$scope.usuario = usuarioId;
		$scope.loader = true;
		$scope.ShowContenido = false;
		promesas = [];
		promesas.push(listaUsers.listaUsers());
		promesas.push(sistemasResponsablesService.sistemasResponsablesList());
		promesas.push(areasService.areasList());
	 	$q.all(promesas).then(function (data){
		 	responsablesPorUsuarioId = factoria.arregloPorPropiedad(data[1].data, "user_id");
		 	responsablesPorId = factoria.arregloPorPropiedad(data[1].data, "id");
		 	usuariosPorId = factoria.arregloPorPropiedad(data[0].data, "UsuarioId");
		 	areasPorId = factoria.arregloPorPropiedad(data[2].data.data, "id")
		 	trabajadoresService.trabajador(usuariosPorId[usuarioId].trabajadore_id).success(function (trabajador){
		 		if(angular.isDefined(responsablesPorUsuarioId[usuarioId])){
			 		bitacorasPromesa = sistemasBitacorasService.sistemasBitacoras();
			 	}else{
			 		bitacorasPromesa = sistemasBitacorasService.sistemasBitacorasPorArea(trabajador.Cargo.Area.id);
			 	}
		 		bitacorasPromesa.success(function (bitacoras){
			 		$scope.ShowContenido = true;
			 		$scope.loader = false;
			 		$scope.bitacoras = [];
			 		if(data.length =! 0){
			 			angular.forEach(bitacoras, function (bitacora){
			 				fecha_inicialArray = $filter("date")(bitacora.fecha_inicio, "yyyy,M,d,H,m", "UTC").split(",");
			 				fecha_inicio = new Date(fecha_inicialArray[0],fecha_inicialArray[1]-1,fecha_inicialArray[2],fecha_inicialArray[3],fecha_inicialArray[4]);
			 				fecha_terminoArray = $filter("date")(bitacora.fecha_termino, "yyyy,M,d,H,m", "UTC").split(",");
			 				fecha_termino = new Date(fecha_terminoArray[0],fecha_terminoArray[1]-1,fecha_terminoArray[2],fecha_terminoArray[3],fecha_terminoArray[4]);
			 				if(bitacora.fecha_cierre){
			 					fecha_cierreArray = $filter("date")(bitacora.fecha_cierre, "yyyy,M,d,H,m", "UTC").split(",");
			 					fecha_cierre = new Date(fecha_cierreArray[0],fecha_cierreArray[1]-1,fecha_cierreArray[2],fecha_cierreArray[3],fecha_cierreArray[4]);
			 				}else{
			 					fecha_cierre = null;
			 				}
			 				$scope.bitacoras.push({
			 					id : bitacora.id,
			 					fecha_inicio : $filter("date")(bitacora.fecha_inicio, "yyyy-MM-dd HH:mm", "UTC"),
			 					fecha_termino : $filter("date")(bitacora.fecha_termino, "yyyy-MM-dd HH:mm", "UTC"),
			 					fecha_cierre : (bitacora.fecha_cierre) ? $filter("date")(bitacora.fecha_cierre, "yyyy-MM-dd HH:mm", "UTC") : null,
			 					tiempo_estimado : factoria.calculoDifMilisecADiasMinSec(fecha_termino.getTime(), fecha_inicio.getTime()),
			 					tiempo_final : (fecha_cierre) ? factoria.calculoDifMilisecADiasMinSec(fecha_cierre.getTime(), fecha_inicio.getTime()) : null,
			 					user : angular.uppercase(usuariosPorId[bitacora.user_id].UsuarioNombre),
			 					user_id : bitacora.user_id,
			 					area : angular.uppercase(areasPorId[bitacora.area_id].nombre),
			 					responsable : angular.uppercase(usuariosPorId[responsablesPorId[bitacora.sistemas_responsable_id].user_id].UsuarioNombre),
			 					responsableId : bitacora.sistemas_responsable_id,
			 					estado : $scope.estados[bitacora.estado],
			 					estadoId : bitacora.estado,
			 					titulo : bitacora.titulo
			 				});
			 			});
			 		}			 		
			 		$scope.gridOptions.data = $scope.bitacoras;
			 		$scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
				        if(angular.isNumber(row.entity.id))
				        {
				            $scope.id = row.entity.id;
				        }
				        if(row.isSelected == true)
				        {
				        	$scope.btnsistemas_bitacorasedit = true;
				        	$scope.btnsistemas_bitacorascerrar_bitacora = true;
				        	$scope.btnsistemas_bitacorasobservaciones_bitacora = true;
				            $scope.boton = true;
				            if(responsablesPorId[row.entity.responsableId].user_id == usuarioId && row.entity.estadoId == 1){
				            	$scope.btnsistemas_bitacorascerrar_bitacora = false;
				            	$scope.btnsistemas_bitacorasobservaciones_bitacora = false;
				            }
				            if(row.entity.user_id == usuarioId && row.entity.estadoId == 1){
			            		$scope.btnsistemas_bitacorasedit = false;
				            }
				            if(angular.isDefined(responsablesPorUsuarioId[usuarioId])){
				            	if(responsablesPorUsuarioId[usuarioId].admin == 1){
					            	$scope.btnsistemas_bitacorascerrar_bitacora = false;
					            	$scope.btnsistemas_bitacorasobservaciones_bitacora = false;	
					            	$scope.btnsistemas_bitacorasedit = false;
					            }
				            }
				        }
				        else
				        {
				            $scope.boton = false;
				            $scope.id = undefined;
				        }
				    });
			 	});
		 	})
		});
	};
	setInterval(function(){$scope.usuarioId($scope.usuario)}, 300000);
	
	$scope.refreshData = function (termObj) {
        $scope.gridOptions.data = $scope.bitacoras;
        while (termObj) {
            var oSearchArray = termObj.split(' ');
            $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
            oSearchArray.shift();
            termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
        }
    };
});

app.controller('sistemasBitacorasEdit', function ($scope, $window, $q, $filter, Flash, trabajadoresService, sistemasBitacorasService, areasService, gerenciasService, listaUsers, usersFactory, sistemasResponsablesService, factoria){
	$scope.loader = true;
    $scope.cargador = loader;
	$scope.ShowContenido = false;
	$scope.formulario = {
		SistemasBitacora : {}
	};
	$scope.tiempo = {
		dias : 0,
		horas : 0,
		minutos : 0
	};
	angular.element(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart:1,
        //startDate: 'today'
    });
    angular.element(".clockpicker").clockpicker({
		placement:'bottom',
		align: 'top',
		autoclose:true
	});
	promesas = [];
	promesas.push(areasService.areasList());
	promesas.push(gerenciasService.gerenciasList());
	promesas.push(listaUsers.listaUsers());
	promesas.push(sistemasResponsablesService.sistemasResponsablesList());
	$scope.parametros = function(usuarioId, requerimientoId){
		promesas.push(sistemasBitacorasService.sistemasBitacora(requerimientoId));
		$q.all(promesas).then(function (data){
			$scope.ShowContenido = true;
			$scope.loader = false;
			$scope.areasList = data[0].data.data;
			$scope.gerenciasList = data[1].data.data;
			usuariosPorId = usersFactory.usersPorId(data[2].data);
			responsables = [];
			angular.forEach(data[3].data, function (responsable){
				responsables.push({
					id : responsable.id,
					nombre : $filter("capitalize")(usuariosPorId[responsable.user_id].UsuarioNombre)
				});
			});
			$scope.responsablesList = $filter("orderBy")(responsables,"nombre");
			responsablesPorUsuarioId = factoria.arregloPorPropiedad(data[3].data, "user_id");
			areasPorId = factoria.arregloPorPropiedad(data[0].data.data, "id");
			gerenciasPorId = factoria.arregloPorPropiedad(data[1].data.data, "id");
			dataLimpia = factoria.deleteCreatedModifiedDosNiveles(data[4].data);
			$scope.gerencia = areasPorId[dataLimpia.SistemasBitacora.area_id].gerencia_id;
			angular.element('#gerencia').select2('data', {id:$scope.gerencia, text : angular.uppercase(gerenciasPorId[$scope.gerencia].nombre)});
			angular.element('#areas').select2('data', {id:dataLimpia.SistemasBitacora.area_id, text : angular.uppercase(areasPorId[dataLimpia.SistemasBitacora.area_id].nombre)});
			angular.element('#responsableId').select2('data', {id: dataLimpia.SistemasBitacora.sistemas_responsable_id, text : $filter("capitalize")(usuariosPorId[dataLimpia.SistemasResponsable.user_id].UsuarioNombre)});
			fechaInicioArray = (dataLimpia["SistemasBitacora"]["fecha_inicio"].substring(0, 10)).split("-");
			horaInicioArray = (dataLimpia["SistemasBitacora"]["fecha_inicio"].substring(11)).split(":");
			fechaTerminoArray = (dataLimpia["SistemasBitacora"]["fecha_termino"].substring(0, 10)).split("-");
			horaTerminoArray = (dataLimpia["SistemasBitacora"]["fecha_termino"].substring(11)).split(":");
			$scope.inicio_fecha = fechaInicioArray[2]+"/"+fechaInicioArray[1]+"/"+fechaInicioArray[0];
			$scope.termino_fecha = fechaTerminoArray[2]+"/"+fechaTerminoArray[1]+"/"+fechaTerminoArray[0];
			$scope.inicio_hora = horaInicioArray[0]+":"+horaInicioArray[1];
			$scope.termino_hora = horaTerminoArray[0]+":"+horaTerminoArray[1];
			if(responsablesPorUsuarioId[usuarioId].admin == 0){
				$scope.responsableReadOnly = true;
			}
			nombre = undefined;
			if(angular.isString(dataLimpia.Trabajadore.nombre)){
				nombre = angular.uppercase(dataLimpia.Trabajadore.nombre+" "+dataLimpia.Trabajadore.apellido_paterno);	
			}
			delete data[4].data.Area;
			delete data[4].data.SistemasResponsable;
			delete data[4].data.User;
			delete data[4].data.Trabajadore;
			delete data[4].data.SistemasBitacorasOb;
			$scope.formulario = dataLimpia;
			$scope.buscaTrabajadoresArea(false);
			if(angular.isDefined(nombre)){
				angular.element('#trabajador').select2('data', {id: $scope.formulario.trabajadore_id, text : nombre});	
			}
			
		});
	}
	$scope.cambiaGerencia = function(){  
		angular.element('#areas').select2('data', null);
		$scope.formulario.SistemasBitacora.area_id = undefined;
		$scope.trabajadoresList = [];
		angular.element('#trabajador').select2('data', null);
		$scope.formulario.SistemasBitacora.trabajadore_id = undefined;
	}

	$scope.registrarBitacora = function(){
		$scope.registrando = true;
		fechaInicio = $scope.inicio_fecha.split("/");
		fechaTermino = $scope.termino_fecha.split("/");
		horaInicio = $scope.inicio_hora.split(":");
		horaTermino = $scope.termino_hora.split(":");
		fechaInicioObj = new Date(fechaInicio[2], parseInt(fechaInicio[1])-1, parseInt(fechaInicio[0]),parseInt(horaInicio[0]),parseInt(horaInicio[1]));
		fechaTerminoObj = new Date(fechaTermino[2], parseInt(fechaTermino[1])-1, parseInt(fechaTermino[0]),parseInt(horaTermino[0]),parseInt(horaTermino[1]));
		if(fechaInicioObj.getTime() > fechaTerminoObj.getTime()){
			Flash.create('danger', "La fecha y hora de termino debe ser mayor a la de inicio", 'customAlert');
			$scope.registrando = false;
			return false;
		}
		$scope.formulario.SistemasBitacora.fecha_inicio = fechaInicio[2]+"-"+fechaInicio[1]+"-"+fechaInicio[0]+" "+$scope.inicio_hora+":00";
		$scope.formulario.SistemasBitacora.fecha_termino = fechaTermino[2]+"-"+fechaTermino[1]+"-"+fechaTermino[0]+" "+$scope.termino_hora+":00";
		$scope.formulario.SistemasBitacora.estado = 1;
		sistemasBitacorasService.registrarSistemasBitacora($scope.formulario).success(function (data){
			if(data.estado == 1){
				$window.location = host+"sistemas_bitacoras";
			}else{
				Flash.create('danger', data.mensaje, 'customAlert');
				$scope.registrando = false;
			}
		});
	}

	$scope.$watch("[inicio_fecha, inicio_hora, termino_fecha, termino_hora]", function(fechas, fechasAntiguas){
		if(angular.isDefined(fechas[0]) && angular.isDefined(fechas[1]) && angular.isDefined(fechas[2]) && angular.isDefined(fechas[3])){
			fechaInicio = $scope.inicio_fecha.split("/");
			fechaTermino = $scope.termino_fecha.split("/");
			horaInicio = $scope.inicio_hora.split(":");
			horaTermino = $scope.termino_hora.split(":");
			fechaInicioObj = new Date(fechaInicio[2], parseInt(fechaInicio[1])-1, parseInt(fechaInicio[0]),parseInt(horaInicio[0]),parseInt(horaInicio[1]));
			fechaTerminoObj = new Date(fechaTermino[2], parseInt(fechaTermino[1])-1, parseInt(fechaTermino[0]),parseInt(horaTermino[0]),parseInt(horaTermino[1]));
			if(fechaInicioObj.getTime() > fechaTerminoObj.getTime()){
				Flash.create('danger', "La fecha y hora de termino debe ser mayor a la de inicio", 'customAlert');
				angular.forEach(fechasAntiguas, function (fecha, key){
					if(fecha != fechas[key]){
						switch(key){
							case 0 :
								$scope.inicio_fecha = undefined;
							break;
							case 1 :
								$scope.inicio_hora = undefined;
							break;
							case 2 :
								$scope.termino_fecha = undefined;
							break;
							case 3 :
								$scope.termino_hora = undefined;
							break;
						}
					}
				});
				$scope.tiempo = {
					dias : 0,
					horas : 0,
					minutos : 0
				};
			}else{
				$scope.tiempo = factoria.calculoDifMilisecADiasMinSec(fechaTerminoObj.getTime(), fechaInicioObj.getTime());
			}
		}
	});
	$scope.buscaTrabajadoresArea = function(limpia){
		$scope.trabajadoresList = [];
		if(limpia){
			$scope.formulario.SistemasBitacora.trabajadore_id = undefined;
		}
		angular.element('#trabajador').select2('data', null);
		if(angular.isDefined($scope.formulario.SistemasBitacora.area_id)){
			trabajadoresService.trabajadoresPorArea($scope.formulario.SistemasBitacora.area_id).success(function (trabajadores){
				angular.forEach(trabajadores, function(trabajador, id){
					$scope.trabajadoresList.push({
						id : id,
						nombre : trabajador
					});
				});
			});
		}
	}
});

app.controller('sistemasBitacorasCerrarBitacora', function ($scope, $window, Flash, sistemasBitacorasService){
	$scope.loader = true;
    $scope.cargador = loader;
	$scope.ShowContenido = false;
	angular.element(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart:1,
        //startDate: 'today'
    });
    angular.element(".clockpicker").clockpicker({
		placement:'bottom',
		align: 'top',
		autoclose:true
	});
	$scope.bitacoraid = function(bitacoraId){
		sistemasBitacorasService.sistemasBitacora(bitacoraId).success(function (bitacora){
			if(bitacora.SistemasBitacora.fecha_cierre){
				fechaCierreArray = (bitacora["SistemasBitacora"]["fecha_cierre"].substring(0, 10)).split("-");
				horaCierreArray = (bitacora["SistemasBitacora"]["fecha_cierre"].substring(11)).split(":");
				$scope.cierre_fecha = fechaCierreArray[2]+"/"+fechaCierreArray[1]+"/"+fechaCierreArray[0];
				$scope.cierre_hora = horaCierreArray[0]+":"+horaCierreArray[1];
			}
			$scope.ShowContenido = true;
			$scope.loader = false;
			$scope.formulario = {
				SistemasBitacora : {
					id : bitacoraId,
					estado : 2
				}
			};
			$scope.formulario.SistemasBitacora.observacion_termino = bitacora.SistemasBitacora.observacion_termino;
		});
	}

	$scope.cerraBitacora = function(){
		fechaCiere = $scope.cierre_fecha.split("/");
		$scope.formulario.SistemasBitacora.fecha_cierre = fechaCiere[2]+"-"+fechaCiere[1]+"-"+fechaCiere[0]+" "+$scope.cierre_hora+":00";
		sistemasBitacorasService.registroCierreBitacora($scope.formulario).success(function (data){
			if(data.estado == 1){
				$window.location = host+"sistemas_bitacoras";
			}else{
				Flash.create('danger', data.mensaje, 'customAlert');
			}
		});
	}
});

app.controller('sistemasBitacorasObservacionesBitacora', function ($scope, $window, Flash, sistemasBitacorasService){
	$scope.loader = true;
    $scope.cargador = loader;
	$scope.ShowContenido = false;
	$scope.bitacoraid = function(bitacoraId){
		$scope.ShowContenido = true;
		$scope.loader = false;
		$scope.formulario = {
			SistemasBitacorasOb : {
				sistemas_bitacora_id : bitacoraId,
				estado : 1,
				tipo : 1
			}
		};
	}
	$scope.registrarObservacion = function(){
		sistemasBitacorasService.registroObservacionBitacora($scope.formulario).success(function (data){
			if(data.estado == 1){
				$window.location = host+"sistemas_bitacoras";
			}else{
				Flash.create('danger', data.mensaje, 'customAlert');
			}
		});
	}
});

app.controller('sistemasBitacorasReportes', function ($scope, $filter, $timeout, sistemasBitacorasService, factoria){
	$scope.loader = true;
    $scope.cargador = loader;
	$scope.ShowContenido = false;
	$scope.tamanioModal = "modal-lg";
	$scope.modeloArea = {};
	$scope.anioInicial = function(anio){
		sistemasBitacorasService.dataReporte().success(function (data){			
			$scope.loader = false;
			$scope.showFecha = true;
			
			meses = [];
			$scope.ingresosCierres = data.reporte_ingresos_cierres;
			$scope.meses = $scope.ingresosCierres.meses;
			$scope.mesesPorNumero = factoria.arregloPorPropiedad($scope.meses, "mes");
			$scope.anioBusqueda = parseInt(anio);
			$scope.numResponsables = Object.keys($scope.ingresosCierres.responsables).length;
			angular.forEach($scope.meses, function (mes){
				meses.push(angular.uppercase(mes.nombre));
			});
			$scope.cambioAnio = function(anio){
				// armado data para grafico 1
				//console.log(anio);
				sistemasBitacorasService.areasBitacorasPorAnio(anio).success(function (areas){
					$scope.areas = [];
					angular.forEach(areas, function (nombre, id){
						$scope.areas.push({
							id : id,
							nombre : angular.uppercase(nombre)
						});
					});
					$scope.areaPorId = factoria.arregloPorPropiedad($scope.areas, "id");
					$scope.areas = $filter("orderBy")($scope.areas, "nombre");
					$scope.dataArea = [];
					$scope.chart3.series = [];
					$scope.modeloArea.areaBusqueda = undefined;
					angular.element('#area').select2('data', null);
					series = [];
					angular.forEach($scope.ingresosCierres.responsables, function(responsable, idResponsable){
						dataResponsable = {
							name : $filter("capitalize")(responsable.nombre),
							data : []
						}
						angular.forEach($scope.meses, function(mes){
							if(angular.isDefined($scope.ingresosCierres.inicio.valores[$scope.anioBusqueda])){
								if(angular.isDefined($scope.ingresosCierres.inicio.valores[$scope.anioBusqueda][idResponsable])){
									dataResponsable.data.push((angular.isDefined($scope.ingresosCierres.inicio.valores[$scope.anioBusqueda][idResponsable][mes.mes])) ? $scope.ingresosCierres.inicio.valores[$scope.anioBusqueda][idResponsable][mes.mes] : 0);
								}else{
									dataResponsable.data.push(0);
								}
							}else{
								dataResponsable.data.push(0);
							}
						});
						series.push(dataResponsable);
					});			
					$scope.chart.options.title.text = 'Tareas asignadas por ingreso '+anio;
					$scope.chart.series = series;

		            // armado data para grafico 2
					series2 = [];
					angular.forEach($scope.ingresosCierres.responsables, function(responsable, idResponsable){
						dataResponsable = {
							name : $filter("capitalize")(responsable.nombre),
							data : []
						}
						angular.forEach($scope.meses, function(mes){
							if(angular.isDefined($scope.ingresosCierres.cierre.valores[$scope.anioBusqueda])){
								if(angular.isDefined($scope.ingresosCierres.cierre.valores[$scope.anioBusqueda][idResponsable])){
									dataResponsable.data.push((angular.isDefined($scope.ingresosCierres.cierre.valores[$scope.anioBusqueda][idResponsable][mes.mes])) ? $scope.ingresosCierres.cierre.valores[$scope.anioBusqueda][idResponsable][mes.mes] : 0);
								}else{
									dataResponsable.data.push(0);
								}	
							}else{
								dataResponsable.data.push(0);
							}
							
						});
						series2.push(dataResponsable);
					});
					$scope.chart2.options.title.text = 'Tareas asignadas por cierre '+anio;
					$scope.chart2.series = series2;
					$scope.chart3.options.title.text = '';
					});		
		       }
		      
	        $scope.chart = {
                options :{
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: 'Cantidad de tareas asignadas a los responsables ingreso'
                    },
                    xAxis: {
                        title: {
                            text: 'meses'
                        },
                        categories: meses
                    },
                    yAxis: {
                        title: {
                            text: 'N° tareas'
                        },
                        min : 0
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
                        valueSuffix: ' Tareas'
                    },
                },
                series:  []/*,
                func: function(chart) {
	                $timeout(function() {
	                    chart.reflow();
	                }, 0);
	            }*/
            }

            $scope.chart2 = {
                options :{
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Tareas cerradas '+anio
                    },
                    subtitle: {
                        text: 'Cantidad de tareas asignadas a los responsables por cierre'
                    },
                    xAxis: {
                        title: {
                            text: 'meses'
                        },
                        categories: meses
                    },
                    yAxis: {
                        title: {
                            text: 'N° tareas'
                        },
                        min : 0
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
                        valueSuffix: ' Tareas'
                    },
                },
                series: ""
            }

            // graficos areas

            $scope.chart3 = {
                options :{
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: 'Cantidad de tareas asignadas a los responsables'
                    },
                    xAxis: {
                        title: {
                            text: 'meses'
                        },
                        categories: meses
                    },
                    yAxis: {
                        title: {
                            text: 'N° tareas'
                        },
                        min : 0
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
                        valueSuffix: ' Tareas'
                    },
                },
                series: [],
                func: function(chart) {
	                $timeout(function() {
	                    chart.reflow();
	                }, 0);
	            }
            }
		    $scope.cambioAnio(anio);
		    $scope.ShowContenido = true;
		    $scope.ingresoTareas = true;
		    //$scope.bitacorasAreas = true;
		});
		
		//console.log($scope.$$phase);
		$scope.mostrarSeccion = function(eleccion){
	        angular.element("#secciones").find("li").removeClass("active");
	        angular.element(".nav").find("#nav"+eleccion).addClass("active");
	        $scope.ingresoTareas = false;
	        $scope.cierresTareas = false;
	        $scope.bitacorasAreas = false;
	        switch(eleccion){
	            case 1 : $scope.ingresoTareas = true;
	            break;
	            case 2 : $scope.cierresTareas = true;
	            break;
	            case 3 : $scope.bitacorasAreas = true;
	            break;
	        }
	    }
		
	}

	$scope.cambioArea = function(area){
		if(angular.isDefined(area)){
			sistemasBitacorasService.reporteArePorAnioJson($scope.anioBusqueda, area).success(function (data){
				if(data.length!=0){
					$scope.dataArea = data;
					$scope.chart3.series = [];
					serie = [];
					angular.forEach($scope.meses, function(mes){
						serie.push(
							(angular.isDefined($scope.dataArea.data.meses[mes.mes])) ? $scope.dataArea.data.meses[mes.mes].total : 0 
						);
					});
					$scope.chart3.series.push({
						name : "Totales año " +$scope.anioBusqueda,
						data : serie
					});
					$scope.chart3.options.title.text = 'Totales '+$scope.areaPorId[area].nombre+' '+$scope.anioBusqueda;
				}else{
					$scope.dataArea = [];
					$scope.chart3.series = [];
					$scope.chart3.options.title.text = '';
				}
			});
		}
	}
	
    $scope.detalleArea = function(mes){
    	$scope.mesDetalle = mes;
    	$scope.detalleAreaData = [];
    	angular.forEach($scope.dataArea.data.meses[mes].trabajadores, function (cantidad, idTrabajador){
    		if(idTrabajador!=0){
    			$scope.detalleAreaData.push({
    				name : ($filter("capitalize")($scope.dataArea.trabajadores[idTrabajador])),
    				y : cantidad
    			});
    		}
    	});
    	if($scope.detalleAreaData.length!=0){
    		$scope.detalleAreaData = $filter("orderBy")($scope.detalleAreaData);
    	}
    	if(angular.isDefined($scope.dataArea.data.meses[mes].trabajadores[0])){
    		$scope.detalleAreaData.push({
    			name : "No definido",
    			y : $scope.dataArea.data.meses[mes].trabajadores[0]
    		});
    	}
    	$scope.showModal = true;
    	$scope.chart4 = {
            options :{
                chart: {
		            plotBackgroundColor: null,
		            plotBorderWidth: null,
		            plotShadow: false,
		            type: 'pie',
		            width: 850
		        },
		        title: {
		            text: 'Detalle '+$scope.areaPorId[$scope.modeloArea.areaBusqueda].nombre+' mes '+$scope.mesesPorNumero[mes].nombre+" "+$scope.anioBusqueda
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
		                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
		                    }
		                }
		            }
		        },
            },
            series: [{
            	name : "Trabajador",
            	data : $scope.detalleAreaData
            }],
            func: function(chart) {
                $timeout(function() {
                    chart.reflow();
                }, 0);
            }
        }
    }
});