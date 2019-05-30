app.controller('cargosIndex', function ($scope, $q, $filter, cargosService, Flash){
	$scope.host = host;
	angular.element(".tool").tooltip();
    $scope.loader = true
    $scope.cargador = loader;
    $scope.gridOptions = {
    	enableGridMenu: true,
        exporterCsvFilename : 'cargos.csv',
        exporterPdfFilename : 'cargos.pdf',
        gridMenuShowHideColumns : false,
    	enableColumnResizing : true,
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        {name:'id', displayName:'id', visible: false,  },
        {name:'cargo', displayName:'Cargo', },
        {name:'area', displayName:'Área', },
        {name:'gerencia', displayName:'Gerencia', },
        {name:'estado', displayName:'Estado', },
        {name:'cantidadTrabajadoresActivos', displayName:'Trabajadores Activos', },
        {name:'cantidadTrabajadores', displayName:'Trabajadores Total', }
    ];
    cargosService.cargos().success(function (data){
    	$scope.dataCargos = data.data;
    	$scope.gridOptions.data = $scope.dataCargos;
	    $scope.loader = false;
	    $scope.tablaDetalle = true;
	    $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
	    	if(angular.isNumber(row.entity.id))
	    	{
	    		$scope.id = row.entity.id;
	    	}
	    	if(row.isSelected == true)
	    	{
	    		$scope.boton = true;
	    		if(row.entity.cantidadTrabajadoresActivos!=0){
	    			$scope.cargo = row.entity.cargo;
	    			$scope.btncargosdelete = true;
	    			$scope.btncargoscargos_activar = true;
	    		}else{
	    			if(row.entity.estado == "Activo"){
	    				$scope.btncargosdelete = false;
	    				$scope.btncargoscargos_activar = true;
	    			}else{
	    				$scope.btncargosdelete = true;
	    				$scope.btncargoscargos_activar = false;
	    			}
	    		}
	    		if(row.entity.cantidadTrabajadores==0){
	    			$scope.btncargoscargos_trabajadores = true;
	    		}else{
	    			$scope.btncargoscargos_trabajadores = false;
	    		}
	    	}
	    	else
	    	{
	    		$scope.btncargoscargos_activar = true;
	    		$scope.btncargosdelete = true;
	    		$scope.btncargoscargos_trabajadores = true;
	    		$scope.boton = false;
	    		$scope.id = "";
	    	}
	    });

	    $scope.refreshData = function (termObj) {
	    	$scope.gridOptions.data = $scope.dataCargos;
	    	while (termObj) {
	    		var oSearchArray = termObj.split(' ');
	    		$scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
	    		oSearchArray.shift();
	    		termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
	    	}
	    };

	    $scope.trabajadoresCargo = function (cargoId){
	    	cargosService.cargoTrabajadores(cargoId).success(function (data){
	    		$scope.titulo = 'Trabajadores cargo "'+angular.uppercase($scope.cargo)+'"';
            	$scope.showModal = true;
            	$scope.cargoTrabajadoresList = data.data;
	    	});
	    };

	    $scope.activarCargo = function (idCargo){	    	
	    	cargo = {
	    		Cargo : {
	    			id : idCargo,
	    			estado : 1	
	    		}
	    	}
	    	cargosService.cambiarEstadoCargo(cargo).success(function (datos){
	    		if(datos.estado==1){
	 				Flash.create('success', datos.mensaje, 'customAlert');
	    			cargosService.cargos().success(function (data){
	    				$scope.dataCargos = data.data;
	    				$scope.gridOptions.data = $scope.dataCargos;
	    				$scope.gridApi.selection.clearSelectedRows();
	    				$scope.boton = false;
	    				$scope.refreshData($scope.search);
	    			});
	    		}else{
	    			Flash.create('danger', datos.mensaje, 'customAlert');	
	    		}
	    	});
	    };

	    $scope.confirmacion = function (){
	    	cargo = {
	    		Cargo : {
	    			id : $scope.id,
	    			estado : 0	
	    		}
	    	}

	    	cargosService.cambiarEstadoCargo(cargo).success(function (datos){
	    		if(datos.estado==1){
	 				Flash.create('success', datos.mensaje, 'customAlert');
	    			cargosService.cargos().success(function (data){
	    				$scope.boton = false;
	    				$scope.gridApi.selection.clearSelectedRows();
	    				$scope.dataCargos = data.data;
	    				$scope.gridOptions.data = $scope.dataCargos;
	    				$scope.refreshData($scope.search) 
	    			});
	    		}else{
	    			Flash.create('danger', datos.mensaje, 'customAlert');	
	    		}
	    	});	
	    };

	    $scope.cerrarModal = function (){
            $scope.showModal = false;
        };
    });
      
});

app.controller('cargosAdd', function ($scope, $q, $filter, cargosService, areasService, gerenciasService, cargosNivelResponsabilidadesService, cargosFamiliasService, areasFactory, $window, Flash){
	$scope.host = host;
	$scope.loader = true
    $scope.cargador = loader;
    $scope.formulario = {};
    $scope.gridOptions = {
    	enableColumnResizing : true,
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false
    };

    $scope.gridOptions.columnDefs = [
        {name:'cargo', displayName:'Cargo', },
        {name:'area', displayName:'Área', },
        {name:'gerencia', displayName:'Gerencia', },
        {name:'estado', displayName:'Estado', },
        {name:'cantidadTrabajadoresActivos', displayName:'Trab.Activos', },
        {name:'cantidadTrabajadores', displayName:'Trab. Total', }
    ];
    promesas = [];
    promesas.push(cargosNivelResponsabilidadesService.cargosNivelResponsabilidadesList());
    promesas.push(cargosFamiliasService.cargosFamiliasList());
    promesas.push(areasService.areasList());
    promesas.push(gerenciasService.gerenciasList());
    promesas.push(cargosService.cargos());
    $q.all(promesas).then(function (datos){
    	$scope.loader = false;
    	$scope.cargosShow = true;
    	$scope.cargosNivelResponsabilidadesList = datos[0].data.data;
    	$scope.cargosFamiliasList = datos[1].data.data;
    	$scope.gerenciasList = datos[3].data.data;
    	$scope.gridOptions.data = datos[4].data.data;

    	$scope.refreshData = function (termObj) {
    		if(angular.isDefined(termObj)){
    			$scope.resultadosShow = true;
    			$scope.gridOptions.data = datos[4].data.data;
		    	while (termObj) {
		    		var oSearchArray = termObj.split(' ');
		    		$scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
		    		oSearchArray.shift();
		    		termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
		    		if($scope.gridOptions.data.length==0){
		    			$scope.resultadosShow = false;
		    		}
		    	}
    		}else{
				$scope.resultadosShow = false;
    		}
	    };
    	$scope.cambioGerencia = function (gerencia){
            $scope.areasList = areasFactory.areasGerencia(datos[2].data.data, gerencia.id);
            $scope.formulario.Cargo.area_id = undefined;
        };
        $scope.registrarCargo = function(){
        	cargosService.registrarCargo({ Cargo : $scope.formulario.Cargo }).success(function (data){
        		if(data.estado == 1){
        			$window.location = host+"cargos";
        		}else{
        			Flash.create('danger', data.mensaje, 'customAlert');
        		}
        	});
        };
    });
});

app.controller('cargosEdit', function ($scope, $q, $filter, cargosService, areasService, gerenciasService, cargosNivelResponsabilidadesService, cargosFamiliasService, areasFactory, $window, Flash){
	$scope.host = host;
	$scope.loader = true
    $scope.cargador = loader;
    $scope.formulario = {};
    $scope.gridOptions = {
    	enableColumnResizing : true,
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false
    };

    $scope.gridOptions.columnDefs = [
        {name:'cargo', displayName:'Cargo', },
        {name:'area', displayName:'Área', },
        {name:'gerencia', displayName:'Gerencia', },
        {name:'estado', displayName:'Estado', },
        {name:'cantidadTrabajadoresActivos', displayName:'Trab.Activos', },
        {name:'cantidadTrabajadores', displayName:'Trab. Total', }
    ];
    promesas = [];
    promesas.push(cargosNivelResponsabilidadesService.cargosNivelResponsabilidadesList());
    promesas.push(cargosFamiliasService.cargosFamiliasList());
    promesas.push(areasService.areasList());
    promesas.push(gerenciasService.gerenciasList());
    promesas.push(cargosService.cargos());
    $scope.$watch("idCargo", function (idCargo){
    	promesas.push(cargosService.cargo(idCargo));
	    $q.all(promesas).then(function (datos){
	    	$scope.formulario = datos[5].data.data;
	    	$scope.loader = false;
	    	$scope.cargosShow = true;
	    	$scope.cargosNivelResponsabilidadesList = datos[0].data.data;
	    	$scope.cargosFamiliasList = datos[1].data.data;
	    	$scope.gerenciasList = datos[3].data.data;
	    	$scope.gridOptions.data = datos[4].data.data;

	    	$scope.refreshData = function (termObj) {
	    		if(angular.isDefined(termObj)){
	    			$scope.resultadosShow = true;
	    			$scope.gridOptions.data = datos[4].data.data;
			    	while (termObj) {
			    		var oSearchArray = termObj.split(' ');
			    		$scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
			    		oSearchArray.shift();
			    		termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
			    		if($scope.gridOptions.data.length==0){
			    			$scope.resultadosShow = false;
			    		}
			    	}
	    		}else{
					$scope.resultadosShow = false;
	    		}
		    };
	    	$scope.cambioGerencia = function (gerencia, limpia){
	            $scope.areasList = areasFactory.areasGerencia(datos[2].data.data, gerencia.id);
	            if(limpia){
                    $scope.formulario.Cargo.area_id = undefined;
                }
	        };
	        $scope.cambioGerencia({ id : datos[5].data.data.Area.gerencia_id }, false);
	        $scope.registrarCargo = function(){
	        	cargoEdit = {
	        		Cargo : {
	        			id : $scope.formulario.Cargo.id,
	        			nombre : $scope.formulario.Cargo.nombre,
	        			area_id : $scope.formulario.Cargo.area_id,
	   					cargos_familia_id : $scope.formulario.Cargo.cargos_familia_id,
	   					cargos_nivel_responsabilidade_id : $scope.formulario.Cargo.cargos_nivel_responsabilidade_id
	        		}
	        	};
	        	cargosService.registrarCargo(cargoEdit).success(function (data){
	        		if(data.estado == 1){
	        			$window.location = host+"cargos";
	        		}else{
	        			Flash.create('danger', data.mensaje, 'customAlert');
	        		}
	        	});
	        };
	    });
    });
});