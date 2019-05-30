app.controller('catalogacionPartidosMediosAdd', function ($scope, $q, $filter, $window, Flash, catalogacionPartidosMediosService, formatosService, formatosFactory, bloquesService, bloquesFactory, soportesService, soportesFactory, almacenamientosService, almacenamientosFactory, copiasService, copiasFactory, catalogacionPartidosService){
	
	$scope.loader = true;
    $scope.cargador = loader;
	angular.element("#fechaIngreso").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart:1,
    });

	$scope.idCatalogacionPartidos = function(idCatalogacionPartido){
		$scope.formulario = {};
		$scope.formulario.CatalogacionPartidosMedio = {};
		$scope.formulario.CatalogacionPartidosMedio.catalogacion_partido_id = idCatalogacionPartido;
		promesas = [];
	    promesas.push(formatosService.formatosList());
	    promesas.push(bloquesService.bloquesList());
	    promesas.push(soportesService.soportesList());
	    promesas.push(almacenamientosService.almacenamientosList());
	    promesas.push(copiasService.copiasList());
	    promesas.push(catalogacionPartidosService.catalogacionPartido(idCatalogacionPartido));
	    $q.all(promesas).then(function (data){
	    	$scope.cargado = true;
	    	$scope.loader = false;
	    	$scope.formatosList = $filter("orderBy")(formatosFactory.formatoPorTipo(data[0].data, 1), "nombre");
	    	$scope.bloquesList = $filter("orderBy")(bloquesFactory.bloquesPorTipo(data[1].data, 1), "codigo");
	    	$scope.soportesList =$filter("orderBy")(soportesFactory.soportesPorTipo(data[2].data, 1), "nombre");
	    	$scope.almacenamientosList = $filter("orderBy")(almacenamientosFactory.almacenamientosPorTipo(data[3].data, 1), "lugar");
	    	$scope.copiasList = $filter("orderBy")(copiasFactory.copiasPorTipo(data[4].data, 1), "copia");
	    	$scope.$watchGroup(["fecha_ingreso", "formulario.CatalogacionPartidosMedio.formato_id", "formulario.CatalogacionPartidosMedio.bloque_id", "formulario.CatalogacionPartidosMedio.soporte_id", "formulario.CatalogacionPartidosMedio.almacenamiento_id", "formulario.CatalogacionPartidosMedio.copia_id"], function(valores){
	            if(angular.isDefined(valores[0]) && angular.isDefined(valores[1]) && angular.isDefined(valores[2]) && angular.isDefined(valores[3]) && angular.isDefined(valores[4]) && angular.isDefined(valores[5]))
	            {
	            	formato = formatosFactory.formatoPorId($scope.formatosList, $scope.formulario.CatalogacionPartidosMedio.formato_id);
	            	bloque = bloquesFactory.bloquePorId($scope.bloquesList, $scope.formulario.CatalogacionPartidosMedio.bloque_id);
	            	if($scope.formulario.CatalogacionPartidosMedio.formato_id == 1){
	            		$scope.formulario.CatalogacionPartidosMedio.codigo = angular.uppercase(formato.nombre)+angular.uppercase(data[5].data.CatalogacionPartido.codigo)+"_"+angular.uppercase(bloque.codigo);	
	            	}else{
	            		$scope.formulario.CatalogacionPartidosMedio.codigo = angular.uppercase(data[5].data.CatalogacionPartido.codigo)+"_"+angular.uppercase(bloque.codigo);	
	            	}
	                
	            }else{
	                $scope.formulario.CatalogacionPartidosMedio.codigo = undefined;
	            }
	            
	        });
	    });
		
		$scope.registrarCatalogacionPartidosMedios = function(){
			$scope.registrando = true;
			fechaIngreso = $scope.fecha_ingreso.split("/");
			$scope.formulario.CatalogacionPartidosMedio.fecha_ingreso = fechaIngreso[2]+"-"+fechaIngreso[1]+"-"+fechaIngreso[0];
			catalogacionPartidosMediosService.registrarCatalogacionPartidosMedios($scope.formulario).success(function (data){
				if(data.estado == 1){
					$window.location = host+"catalogacion_partidos/view/"+data.id;
				}else{
					$scope.registrando = true;
                	Flash.create('danger', data.mensaje, 'customAlert');
				}
			});
		}
	}
});

app.controller('catalogacionPartidosMediosEdit', function ($scope, $q, $filter, $window, Flash, catalogacionPartidosMediosService, formatosService, formatosFactory, bloquesService, bloquesFactory, soportesService, soportesFactory, almacenamientosService, almacenamientosFactory, copiasService, copiasFactory, catalogacionPartidosService){
	
	$scope.loader = true;
    $scope.cargador = loader;
	angular.element("#fechaIngreso").datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        multidate: false,
        autoclose: true,
        required: true,
        calendarWeeks: true,
        weekStart:1,
    });

	$scope.idCatalogacionPartidosMedio = function(idCatalogacionPartidosMedio){
		$scope.formulario = {};
		$scope.formulario.CatalogacionPartidosMedio = {};
		//$scope.formulario.CatalogacionPartidosMedio.catalogacion_partido_id = idCatalogacionPartido;
		promesas = [];
	    promesas.push(formatosService.formatosList());
	    promesas.push(bloquesService.bloquesList());
	    promesas.push(soportesService.soportesList());
	    promesas.push(almacenamientosService.almacenamientosList());
	    promesas.push(copiasService.copiasList());
	    promesas.push(catalogacionPartidosMediosService.catalogacionPartidosMedio(idCatalogacionPartidosMedio));
	    $q.all(promesas).then(function (data){
	    	$scope.cargado = true;
	    	$scope.loader = false;
	    	$scope.formatosList = $filter("orderBy")(formatosFactory.formatoPorTipo(data[0].data, 1), "nombre");
	    	$scope.bloquesList = $filter("orderBy")(bloquesFactory.bloquesPorTipo(data[1].data, 1), "codigo");
	    	$scope.soportesList =$filter("orderBy")(soportesFactory.soportesPorTipo(data[2].data, 1), "nombre");
	    	$scope.almacenamientosList = $filter("orderBy")(almacenamientosFactory.almacenamientosPorTipo(data[3].data, 1), "lugar");
	    	$scope.copiasList = $filter("orderBy")(copiasFactory.copiasPorTipo(data[4].data, 1), "copia");
	    	$scope.formulario.CatalogacionPartidosMedio = data[5].data.data.CatalogacionPartidosMedio;
	    	fecha_ingreso = ($scope.formulario.CatalogacionPartidosMedio.fecha_ingreso.substr(0,10)).split("-");
	    	$scope.fecha_ingreso = fecha_ingreso[2]+"/"+fecha_ingreso[1]+"/"+fecha_ingreso[0];
	    	$scope.$watchGroup(["fecha_ingreso", "formulario.CatalogacionPartidosMedio.formato_id", "formulario.CatalogacionPartidosMedio.bloque_id", "formulario.CatalogacionPartidosMedio.soporte_id", "formulario.CatalogacionPartidosMedio.almacenamiento_id", "formulario.CatalogacionPartidosMedio.copia_id"], function(valores){
	            if(angular.isDefined(valores[0]) && angular.isDefined(valores[1]) && angular.isDefined(valores[2]) && angular.isDefined(valores[3]) && angular.isDefined(valores[4]) && angular.isDefined(valores[5]))
	            {
	            	formato = formatosFactory.formatoPorId($scope.formatosList, $scope.formulario.CatalogacionPartidosMedio.formato_id);
	            	bloque = bloquesFactory.bloquePorId($scope.bloquesList, $scope.formulario.CatalogacionPartidosMedio.bloque_id);
	            	if($scope.formulario.CatalogacionPartidosMedio.formato_id == 1){
	            		$scope.formulario.CatalogacionPartidosMedio.codigo = angular.uppercase(formato.nombre)+angular.uppercase(data[5].data.data.CatalogacionPartido.codigo)+"_"+angular.uppercase(bloque.codigo);	
	            	}else{
	            		$scope.formulario.CatalogacionPartidosMedio.codigo = angular.uppercase(data[5].data.data.CatalogacionPartido.codigo)+"_"+angular.uppercase(bloque.codigo);	
	            	}
	                
	            }else{
	                $scope.formulario.CatalogacionPartidosMedio.codigo = undefined;
	            }
	            
	        });
	    });
		
		$scope.editarCatalogacionPartidosMedios = function(){
			$scope.editando = true;
			fechaIngreso = $scope.fecha_ingreso.split("/");
			$scope.formulario.CatalogacionPartidosMedio.fecha_ingreso = fechaIngreso[2]+"-"+fechaIngreso[1]+"-"+fechaIngreso[0];
			delete $scope.formulario.CatalogacionPartidosMedio.created;
			delete $scope.formulario.CatalogacionPartidosMedio.modified;
			catalogacionPartidosMediosService.registrarCatalogacionPartidosMedios($scope.formulario).success(function (data){
				if(data.estado == 1){
					$window.location = host+"catalogacion_partidos/view/"+data.id;
				}else{
					$scope.registrando = true;
                	Flash.create('danger', data.mensaje, 'customAlert');
				}
			});
		}
	}
});