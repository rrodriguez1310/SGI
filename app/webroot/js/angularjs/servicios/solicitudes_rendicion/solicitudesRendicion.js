app.service('solicitudesRendicion', ["$http",'$location',  function($http, $location) {
	//parametros = location.search.substring(1); 
	//parametros = parametros.split("/");

	this.formularioRendicionFondo = function(datos){

		//var data = $http.post(host25+'SolicitudRendicionTotales/add_rendicion_fondos', $.param({datos}));
		var data = $http({
			method: 'POST',
			url: host25+'SolicitudRendicionTotales/add_rendicion_fondos',
			data : $.param({datos})
		});

		return data; 
	};



	this.formularioRendicionFondoEdit= function(dat, largo, id){
		dat['largo']=largo;
		dat['id']=id;
		var data = $http({
			params: dat,
			method: 'POST',
			url: host25+'SolicitudRendicionTotales/edit_rendicion_fondos'
		});
		return data; 
	};



	this.listaRequerimientosRechazo = function(id){ 
		var data = $http({
			params: {id : id},
			method: 'POST',
			url: host25+'SolicitudesRequerimientos/add_rendicion_fondos_rechazo'
		});
		return data; 
	};

	this.listaRendicionFondo = function(){ 
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'SolicitudRendicionTotales/lista_Rendicion_fondos'
		});
		return data; 
	};
	
	this.listaRendicionFondoTotales = function(){ 
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'SolicitudRendicionTotales/lista_Rendicion_fondos_totales'
		});
		return data; 
	};

	this.listaRendicionFondoTotalesRendir = function(){ 
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'SolicitudesRequerimientos/lista_Rendicion_fondos_totales'
		});
		return data; 
	};


	this.listaRendicionFondoFinanzasFondoFijo = function(){ 
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'SolicitudRendicionTotales/lista_Rendicion_fondos'
		});
		return data; 
	};

	this.listaRendicionFondoFinanzas = function(){ 
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'SolicitudesRequerimientos/lista_Rendicion_fondos'
		});
		return data; 
	};


	this.actualizaEstado=function(id, estado, motivo, n_documento){

	//	console.log("----->",id, estado, motivo)
		var data = $http({
			params: {id : id, estado: estado, motivo:motivo, n_documento: n_documento},
			method: 'POST',
			url: host25+'SolicitudRendicionTotales/add_estados'
		});
		return data; 

	}

	this.eliminaRegistro = function(id){
		var data = $http({
			params: {id:id},
			method: 'POST',
			url: host25+'SolicitudesRequerimientos/delete_gasto'
		});
		return data; 
	}

	this.cargaDinamica=function(id){

		var data = $http({
			params: {id:id},
			method: 'POST',
			url: host25+'SolicitudesRequerimientos/datos_rendicion'
		});
		return data; 
	}


	this.datosDimensionSolicitud=function(id){

		var data = $http({
			params: {id:id},
			method: 'POST',
			url: host25+'SolicitudesRequerimientos/datosDimenciones'
		});
		return data; 
	}

	this.cargaDinamicaFondoFijo=function(id){

		var data = $http({
			params: {id:id},
			method: 'POST',
			url: host25+'SolicitudRendicionTotales/datos_rendicion'
		});
		return data; 
	}

	this.listaDimenciones=function(id){

		var data = $http({
			params: {"valor" : id},
			method: 'GET',
			url: host25+'servicios/codigoPresupuestarioCompraTarjeta'
		});
		return data; 
	}

	var payload = new FormData();
	this.guardaRedicionFondos = function(guardarRendicion, listaRendicion, documetosRendicion, total, idFolio){

		console.log(total);

		payload.append("total", total);
		payload.append("rendicion", JSON.stringify(guardarRendicion));
		payload.append('lista', JSON.stringify(listaRendicion));
		//payload.append('file', documetosRendicion);

		angular.forEach(documetosRendicion,function(file){
			payload.append('file[]',file);
		});
	
		var data = $http({
			url: host25+'SolicitudRendicionTotales/add/'+idFolio,
			method: 'POST',
			data: payload,
			//assign content-type as undefined, the browser
			//will assign the correct boundary for usguardaRedicionFondosFijos
			//headers: { 'Content-Type': undefined},
			headers: {'Content-Type': undefined},
			//prevents serializing payload.  don't do it.
			transformRequest: angular.identity
		});
		
		return data; 
	};


	this.guardaRedicionFondosFijos = function(guardarRendicion, listaRendicion, documetosRendicion, totalGastos, idFolio){

		payload.append("idFolio", idFolio);
		payload.append("total", totalGastos);
		payload.append("rendicion", JSON.stringify(guardarRendicion));
		payload.append('lista', JSON.stringify(listaRendicion));
		//payload.append('file', documetosRendicion);

		angular.forEach(documetosRendicion,function(file){
			payload.append('file[]',file);
		});

		var data = $http({
			url: host25+'SolicitudRendicionTotales/add_fondo_fijo',
			method: 'POST',
			data: payload,
			//assign content-type as undefined, the browser
			//will assign the correct boundary for us
			headers: {'Content-Type': undefined},
			//prevents serializing payload.  don't do it.
			transformRequest: angular.identity
		});
		
		return data; 
	};

	this.actualizaRedicionFondos = function(guardarRendicion, listaRendicion, documetosRendicion, totalGastos, idFolio, id){
	


		payload.append("idFolio",idFolio);
		payload.append("total", totalGastos);
		payload.append("rendicion", JSON.stringify(guardarRendicion));
		payload.append('lista', JSON.stringify(listaRendicion));
		payload.append('id', id);

			angular.forEach(documetosRendicion,function(file){
				payload.append('file[]',file);
			});

		var data = $http({
			url: host25+'SolicitudRendicionTotales/edit_fondo_rendir',
			method: 'POST',
			data: payload,
			//assign content-type as undefined, the browser
			//will assign the correct boundary for us
			headers: {'Content-Type': undefined},
			//prevents serializing payload.  don't do it.
			transformRequest: angular.identity
		});

		return data; 
};

this.actualizaRedicionFondosFijo = function(guardarRendicion, listaRendicion, documetosRendicion, total, idFolio, id){



	payload.append("idFolio",idFolio);
	payload.append("total", total);
	payload.append("rendicion", JSON.stringify(guardarRendicion));
	payload.append('lista', JSON.stringify(listaRendicion));
	//payload.append('file', documetosRendicion);
	payload.append('id', id);

	angular.forEach(documetosRendicion,function(file){
		payload.append('file[]',file);
	});


	var data = $http({
		url: host25+'SolicitudRendicionTotales/edit_fFijo',
		method: 'POST',
		data: payload,
		//assign content-type as undefined, the browser
		//will assign the correct boundary for us
		headers: {'Content-Type': undefined},
		//prevents serializing payload.  don't do it.
		transformRequest: angular.identity
	});

	return data; 
};

	
}]);
