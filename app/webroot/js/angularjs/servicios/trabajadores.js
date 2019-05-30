app.service('trabajadoresService', ["$http", "Upload", function($http, Upload) {

	this.trabajadoresListado = function(){
		var data = $http({
			method: 'GET',
			url: host+'trabajadores/trabajadores_listado',
		});		
		return data;
	};

	this.trabajadoresListadoCorto = function(){
		var data = $http({
			method: 'GET',
			url: host+'trabajadores/sistema_lista_trabajadores_json',
		});		
		return data;
	};

	this.editaTrabajadorSistema = function(datosEditar){
		var data = $http({
			method: 'POST',
			data: $.param(datosEditar),
			url: host+'trabajadores/editar_trabajador_sistema',
		});		
		return data;
	};

	this.trabajador = function(id){
		var data = $http({
			method: 'GET',
			url: host+'trabajadores/trabajador/'+id,
		});		
		return data;
	};

	this.estadosTrabajador = function(){
		estadosArray = ["Activo", "Prospecto","Retirado"];
		estados = [];
		angular.forEach(estadosArray, function (estadosValor){
			estados.push({
				id: estadosValor,
				nombre: estadosValor
			});
		});
		return estados;
	};

	this.editarTrabajador = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'trabajadores/editar_trabajador',
			data: $.param(formulario)
		});		
		return data;
	};

	this.cambiarContrato = function(formulario){
		return $http({
			method: 'POST',
			url: host+'trabajadores/cambiarContrato',
			data: $.param(formulario)
		});	
	};

	this.retiroTrabajador = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'trabajadores/retiro_trabajador',
			data: $.param(formulario)
		});		
		return data;
	};

	this.comprobarDocTrabajadorUpload = function(idTrabajador, idDocumento, fecha_inicial){
		var data = $http({
			method: 'GET',
			url: host+'documentos/comprobar_doc_trabajador_upload',
			params: { id : idTrabajador, tipos_documento_id : idDocumento, fecha_inicial : fecha_inicial}
		});
		return data;
	};

	this.activarTrabajador = function(datos){
		var data = $http({
			method: 'POST',
			url: host+'trabajadores/activar_trabajador',
			data: $.param(datos)
		});		
		return data;
	};

	this.uploadFotoTrabajador = function(idTrabajadore, archivo){
		var data = Upload.upload({
            url: host+'trabajadores/upload_foto_trabajador',
            fields: { id : idTrabajadore },
            file: archivo
        });
        return data;
	};
    
    this.uploadDescripcionCargo = function(idTrabajadore, archivo){
		var data = Upload.upload({
            url: host+'trabajadores/upload_descripcion_cargo',
            fields: { id : idTrabajadore },
            file: archivo
        });
        return data;
	};

	this.validaRut = function(rut){
		var data = $http({
			method: 'GET',
			url: host+'trabajadores/valida_rut',
			params : { rutTrabajador : rut }
		});
		return data;
	};

	this.validaRutCompras = function(rut){
		var data = $http({
			method: 'GET',
			url: host+'trabajadores/valida_rut_compras',
			params : { rutTrabajador : rut }
		});		
		return data;
	};

	this.addTrabajador = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'trabajadores/add_trabajador',
			data: $.param(formulario)
		});		
		return data;
	};

	this.cuentaBancaria = function(idTrabajador){
		var data = $http({
			method: 'GET',
			url: host+'trabajadores/cuenta_bancaria_trabajador',
			params : { idTrabajador : idTrabajador }
		});		
		return data;
	};

	this.guardarCuentaBancaria = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'trabajadores/guardar_cuenta_bancaria',
			data: $.param(formulario)
		});		
		return data;
	};

	this.trabajadores = function(){
		var data = $http({
			method: 'GET',
			url: host+'trabajadores/trabajadores',
		});		
		return data;
	};

	this.selectTrabajadores = function(){
		var data = $http({
			method: 'GET',
			url: host+'trabajadores/select_trabajador',
		});		
		return data;
	};

	this.enviaCorreoRetiro = function(idTrabajado){
		return $http({
			method : "GET",
			url : host+"trabajadores/envio_correo_retiro",
			params : { id : idTrabajado }
		});
	}

	this.dataDotacionTrabajadores = function(fecha){
		return $http({
			method : "GET",
			url : host+"trabajadores/data_dotacion_trabajadores",
			params : (angular.isDefined(fecha)) ? {fecha : fecha}: ""
		});
	}

	this.trabajadoresPorArea = function(areaId){
		return $http({
			method : "GET",
			url : host+"trabajadores/trabajadores_por_area",
			params : {idArea : areaId }
		});	
	}
	
}]);
