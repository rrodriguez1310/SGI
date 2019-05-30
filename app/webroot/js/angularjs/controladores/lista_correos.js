appTextEditor.config(function($provide){
	$provide.decorator('taOptions', ['taRegisterTool', '$delegate', function(taRegisterTool, taOptions){
		taOptions.toolbar = [
		['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'pre', 'quote'],
		['bold', 'italics', 'underline', 'strikeThrough', 'ul', 'ol', 'redo', 'undo', 'clear'],
		['justifyLeft', 'justifyCenter', 'justifyRight'],
		['html']
		];
		return taOptions;
	}]);
});

appTextEditor.controller("listaCorreosAdd", ["$scope", "$location", "listaCorreosService","listaCorreosTiposFactory", "$window", function ($scope, $location, listaCorreosService, listaCorreosTiposFactory, $window){

	$scope.locationListaCorreos = host+"lista_correos";
	tipos = listaCorreosTiposFactory.listaCorreosTipos();
	tipos.then(function(data){
		$scope.tipos = data;
	});


	$scope.registrarListaCorreos = function(){
		registro = listaCorreosService.registrarListaCorreos($scope.formulario);
		registro.success(function(datos, status, headers, config){
			switch(datos.estado){
				case 1:	$window.location = host+"lista_correos";
				break;
				case 0: $window.location = host+"lista_correos/add";
				break;  
			}
			
		});
	};
	
}]);

appTextEditor.controller("listaCorreosEdit", ["$scope", "listaCorreosFactory", 'listaCorreosService', "listaCorreosTiposFactory", "$window", function ($scope,listaCorreosFactory, listaCorreosService, listaCorreosTiposFactory, $window){
	
	$scope.locationListaCorreos = host+"lista_correos";
	tipos = listaCorreosTiposFactory.listaCorreosTipos();
	tipos.then(function(data){
		$scope.tipos = data;
	});

	$scope.$watch("tipos", function(nuevoValor, viejoValor){
		if(angular.isDefined(nuevoValor)){
			promesa = listaCorreosFactory.listaCorreo($scope.id);
			promesa.then(function(data){
				$scope.formulario = data;
			});	
		}
	});
	
	$scope.editarListaCorreos = function(){
		editar = listaCorreosService.editarListaCorreos($scope.formulario);
		editar.success(function(datos, status, headers, config){
			switch(datos.estado){
				case 1:	$window.location = host+"lista_correos";
				break;
				case 0: $window.location = host+"lista_correos/edit/"+$scope.id;
				break;  
			}
			
		});
	};
	
}]);

app.controller("listaCorreosIndex", ["$scope", "$filter", "$location", "$window", "$compile", "uiGridConstants", "listaCorreosFactory", "listaCorreosService", function ($scope, $filter, $location, $window, $compile, uiGridConstants, listaCorreosFactory, listaCorreosService){

	$scope.loader = true
    $scope.cargador = loader;

	$scope.gridOptions = {  
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
        {name:'Id', displayName:'Id', visible: false },
        {name:'nombre', displayName:'Nombre', },
        {name:'descripcion', displayName:'Descripción', },
        {name:'tipo_nombre', displayName:'Gatillador', },
    ];

    listaCorreos = listaCorreosFactory.listaCorreos();
    listaCorreos.then(function(data){
    	html = '\
			<li>\
				<a ng-show="boton" href="'+$location.absUrl()+'/trabajadores/{{ id }}" class="btn-sm btn btn-default tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Eliminar"><i class="fa fa-user"></i></a>\
			</li>\
			';
    	angular.element(".addbtn").after($compile(html)($scope));	
    	$scope.gridOptions.data = data;
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
	        }
	        else
	        {
	            $scope.boton = false;
	            $scope.id = "";
	        }
	    });
	    $scope.refreshData = function (termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };

	    $scope.confirmacion = function(text) {
	        $scope.locationAbsUrl = $location.absUrl();
	        parametros = {
	        	"ListaCorreo": {
	        		"id": $scope.id,
	        		"estado": 0
	        	}
	        }
	        eliminar = listaCorreosService.eliminar(parametros);
	        eliminar.success(function(data, status, headers, config) {
	        	$window.location = $scope.locationAbsUrl;
	        });
	    };
    });

}]);

app.controller("listaCorreosTrabajadores", ["$scope", "$filter", "$location", "$window", "$q", "uiGridConstants", "listaCorreosFactory", "listaCorreosService", "trabajadoresFactory", "Flash", function ($scope, $filter, $location, $window, $q, uiGridConstants, listaCorreosFactory, listaCorreosService, trabajadoresFactory, Flash){

	$scope.locationListaCorreos = host+"lista_correos";
	$scope.gridOptions = {  
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
        {name:'Id', displayName:'Id', visible: false },
        {name:'nombre', displayName:'Nombre', },
        {name:'email', displayName:'Email', },
        {name:'cargo', displayName:'Cargo', },
    ];

    $scope.$watch("idlistaCorreo", function(nuevoValor, viejoValor){
		if(angular.isDefined(nuevoValor)){
			$scope.listaTrabajadores();
		}
	});

	$scope.listaTrabajadores = function(){
		$scope.search = undefined;
		$scope.tablaDetalle = false;
		$scope.seleccionadosTabla = false;
		$scope.boton = false;
		$scope.loader = true
   		$scope.cargador = loader;
		$scope.gridApi.selection.clearSelectedRows();
		trabajadores = trabajadoresFactory.trabajadoresEmail();
	    listaCorreosTrabajadores = listaCorreosFactory.listaCorreosTrabajadores($scope.idlistaCorreo);
		promesas = [trabajadores, listaCorreosTrabajadores];
		$q.all(promesas).then(function (data){
			$scope.seleccionados = 	data[1].Trabajadore;
			$scope.nombreListaCorreo = data[1].ListaCorreo.nombre;
			if(data[1].Trabajadore.length !=0){
				$scope.seleccionadosTabla = true;
			}
			listaCorreos = listaCorreosFactory.limpiaListaCorreosTrabajadores(data[0], data[1].Trabajadore);
			$scope.gridOptions.data = listaCorreos;
	    	$scope.loader = false;
	        $scope.tablaDetalle = true;
	        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
		        if(angular.isNumber(row.entity.id))
		        {	
		            $scope.id = row.entity.id;
		            $scope.nombreSeleccionada = row.entity.nombre;
		        }
		        if(row.isSelected == true)
		        {
		            $scope.boton = true;
		        }
		        else
		        {
		            $scope.boton = false;
		            $scope.id = "";
		        }
		    });
		    $scope.refreshData = function (termObj) {
	            $scope.gridOptions.data = listaCorreos;
	            while (termObj) {
	                var oSearchArray = termObj.split(' ');
	                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
	                oSearchArray.shift();
	                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
	            }
	        };	
		});
	}

	$scope.agregarCorreo = function(id) {
        parametros = {
        	"TrabajadoresListaCorreo": {
        		"trabajadore_id": $scope.id,
        		"lista_correo_id": $scope.idlistaCorreo
        	}
        }
        registrar = listaCorreosService.registrarTrabajadoresListaCorreos(parametros);
        registrar.success(function(data, status, headers, config) {
        	var message = 'Se agrego a <strong>'+$scope.nombreSeleccionada+'</strong>';
			Flash.create('success', message, 'customAlert');
			$scope.listaTrabajadores();
        });
    };

    $scope.eliminarCorreoAsociado = function(id, nombre){
    	confirmar = confirm("¿Desea eliminar a "+nombre+" de la lista de correos?");
    	if(confirmar){
    		eliminar = listaCorreosService.eliminarCorreoAsociado(id,$scope.idlistaCorreo);
    		eliminar.success(function(data, status, headers, config) {
    			if(data.estado==1){
    				var message = 'Elimino correctamente <strong>'+nombre+'</strong>';
					Flash.create('danger', message, 'customAlert');
					$scope.listaTrabajadores();		
    			}else{
					Flash.create('danger', data.mensaje, 'customAlert');
    			}
       	    });
    	}else{
    		var message = 'Cancelada la eliminación de '+nombre;
			Flash.create('warning', message, 'customAlert');
    	}
    }
}]);