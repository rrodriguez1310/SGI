app.service('cargosService', ['$http', 'Upload', function ($http, Upload){
	
	this.cargosList = function(){
		var data = $http({
			method: 'GET',
			url: host+'cargos/cargos_list',
		});		
		return data;
	};

	this.cargos = function(){
		var data = $http({
			method: 'GET',
			url: host+'cargos/cargos',
		});		
		return data;
	};

	this.cargoTrabajadores = function(cargoId){
		var data = $http({
			method: 'GET',
			url: host+'cargos/cargo_trabajadores',
			params : { id : cargoId }
		});		
		return data;
	};

	this.cambiarEstadoCargo = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'cargos/cambiar_estado_cargo',
			data : $.param(formulario)
		});		
		return data;
	};

	this.cargosConsultaNombre = function (nombreCargo){
		var data = $http({
			method: 'GET',
			url: host+'cargos/cargos_consulta_nombre',
			params : { nombre : nombreCargo }
		});		
		return data;
	};

	this.cargo = function (idCargo){
		return $http({
			method: 'GET',
			params : { id : idCargo },
			url: host+'cargos/cargo'
		});		
	};

	this.registrarCargoAdd = function(formulario){
		if(formulario.Archivo.descripcion === false){
			return $http({
				method: "POST",
				url: host+"cargos/registrar_cargo_add",
				data: $.param(formulario)
			});
			
		}else{	
			var Cargo = formulario.Cargo
			var data = Upload.upload({
	            url: host+"cargos/registrar_cargo_add",
	            fields: { Cargo },
            	file: formulario.Archivo.descripcion
        	});

        	return data;
		}
	}

	this.registrarCargoEdit = function(formulario){
		if(formulario.Archivo.descripcion === false){
			return $http({
				method: "POST",
				url: host+"cargos/registrar_cargo_edit",
				data: $.param(formulario)
			});
			
		}else{	
			var Cargo = formulario.Cargo
			var data = Upload.upload({
	            url: host+"cargos/registrar_cargo_edit",
	            fields: { Cargo },
            	file: formulario.Archivo.descripcion
        	});

        	return data;
		}
	}

	this.registrarCargo = function(formulario){

		if(formulario.Archivo.descripcion === false){
			return $http({
				method: "POST",
				url: host+"cargos/registrar_cargo",
				data: $.param(formulario)
			});
			
		}else{	
			var Cargo = formulario.Cargo
			var data = Upload.upload({
	            url: host+"cargos/registrar_cargo",
	            fields: { Cargo },
            	file: formulario.Archivo.descripcion
        	});

        	return data;
		}
	};




}]);