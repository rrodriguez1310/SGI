app.service('catalogacionRequerimientosService', function ($http){
	this.registrarCatalogacionRequerimiento = function(formulario){
		return $http({
			method: "POST",
			url: host+"catalogacion_requerimientos/registrar_catalogacion_requerimiento",
			data: $.param(formulario)
		});
	}

	this.selectsRequerimientos = function(){
		return $http({
			method: "GET",
			url: host+"catalogacion_requerimientos/selects_para_requerimientos"
		});
	}

	this.catalogacionRequerimientos = function(){
		return $http({
			method: "GET",
			url: host+"catalogacion_requerimientos/catalogacion_requerimientos"
		});
	}

	this.catalogacionRequerimientosUsuario = function(idUsuario){
		return $http({
			method: "GET",
			url: host+"catalogacion_requerimientos/catalogacion_requerimientos_usuario",
			params: {id:idUsuario}
		});
	}

	this.estadosRequerimientos = function(){
		return ["Eliminado", "Pendiente", "En Archivo", "En Ingesta", "Terminado"];
	}

	this.catalogacionRequerimiento = function (idRequerimiento){
		return $http({
			method: "GET",
			url: host+"catalogacion_requerimientos/catalogacion_requerimiento",
			params: {id:idRequerimiento}
		});
	}

	this.registrarAsignarResponsable = function (formulario){
		return $http({
			method: "POST",
			url: host+"catalogacion_requerimientos/registrar_asignar_responsable",
			data: $.param(formulario)
		});
	}

	this.catalogacionRequerimientosUsuarioOrResponsable = function(usuarioId, responsableId){
		console.log(responsableId);
		return $http({
			method: "GET",
			url: host+"catalogacion_requerimientos/requerimientos_usuario_o_responsable",
			params: {usuarioId:usuarioId, responsableId:responsableId}
		});
	}

	this.terminarRequerimiento = function (formulario){
		return $http({
			method: "POST",
			url: host+"catalogacion_requerimientos/registrar_termino_requerimiento",
			data: $.param(formulario)
		});
	}

	this.registrarBatchRequerimiento = function (formulario){
		return $http({
			method: "POST",
			url: host+"catalogacion_requerimientos/registrar_batch_requerimiento",
			data: $.param(formulario)
		});
	}

	this.eliminarRequerimiento = function (eliminacion){
		return $http({
			method: "POST",
			url: host+"catalogacion_requerimientos/eliminar_requerimiento",
			data: $.param(eliminacion)
		});	
	}

	this.publicoList = function(){
		return [
			"Hombre",
			"Niño",
			"Bebe",
			"Anciano",
			"Hincha",
			"Vendedor"
		];
	}
	this.produccionCDFList = function(){
		return [
			"Relator",
			"Comentarista",
			"Periodista",
			"Camarógrafo"
		];
	}
	this.tipoImagenList = function(){
		return [
			"Gol",
			"Expulsión",
			"Amonestación",
			"Falta",
			"Jugada deslumbrante",
			"Lesión",
			"Polémica",
			"Jugada",
			"Entrevista",
			"Otro"
		];
	}
	this.tiposPlanoList = function(){
		return [
			"Primer plano",
			"Plano medio",
			"Plano general",
			"Camarógrafo"
		];
	}
	this.tipoEntregas = function(){
		return [
			{id : 0, nombre : "Digital"},
			{id : 1, nombre : "Fisica"}
		];
	}
	this.logoPosicionList = function(){
		return [
			"Izquierda",
			"Derecha",
			"Centro"
		];
	}
});