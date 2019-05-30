app.service('solicitudesRequerimiento', ["$http",'$location',  function($http, $location) {
	//parametros = location.search.substring(1); 
	//parametros = parametros.split("/");

	this.formularioRendicionFondo = function(dat){

		var data = $http({
			params: dat,
			method: 'POST',
			url: host25+'/SolicitudesRequerimiento/add_rendicion_fondos'
		});
		return data; 
	};


	this.listaRequerimientos = function(){ 
		
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'SolicitudesRequerimientos/list_requerimientos'
		});
		return data; 
	};

	this.listaRequerimientosArea = function(){ 
		
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'SolicitudesRequerimientos/lista_area'
		});
		return data; 
	};


	this.listaRequerimientosFinanza = function(){ 
		
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'SolicitudesRequerimientos/lista_finanza'
		});
		return data; 
	};

	this.actualizaEstado=function(id, estado, motivo, ndocumento){
		var data = $http({
			params: {id : id, estado: estado, motivo:motivo, n_documento: ndocumento},
			method: 'POST',
			url: host25+'SolicitudesRequerimientos/add_estados'
		});
		return data; 

	}

	this.listaSolicitudRendicon = function(){ 
		
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'SolicitudesRequerimientos/lista_solicitudes'
		});
		return data; 
	};

	this.listaSolicitudRendiconRechazo = function(){ 
		
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'SolicitudesRequerimientos/lista_solicitudes_rechazadas'
		});
		return data; 
	};

	this.listaTodos = function(){ 
		
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'SolicitudesRequerimientos/lista_todos'
		});
		return data; 
	};


	this.listaTodosFondoFijo = function(){ 
		
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'solicitud_rendicion_totales/lista_fijos'
		});
		return data; 
	};

	this.listaGeneralFondoFijo = function(){ 
		
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'solicitud_rendicion_totales/lista_todos'
		});
		return data; 
	};


	this.listaRendiconFondoFijo = function(){ 
		
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'solicitud_rendicion_totales/lista_solicitudes'
		});
		return data; 
	};


	this.listaSolicitudRendiconRechazoFijo = function(){ 
		
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'solicitud_rendicion_totales/lista_solicitudes_rechazadas'
		});
		return data; 
	};

	this.listaSolicitudRendiconFondoRendir = function(){ 
		
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'solicitudes_requerimientos/lista_solicitudes_rechazadas'
		});
		return data; 
	};


	


	
	/*this.guardaRedicionFondos = function(guardarRendicion, listaRendicion, documetosRendicion, total, valorMoneda){

	/*	var payload = new FormData();

		payload.append("valorMoneda", valorMoneda);
		payload.append("total", total);
		payload.append("rendicion", JSON.stringify(guardarRendicion));
		payload.append('lista', JSON.stringify(listaRendicion));
		payload.append('file', documetosRendicion);
	
		var data = $http({
			url: host25+'SolicitudRendicionTotales/add',
			method: 'POST',
			data: payload,
			//assign content-type as undefined, the browser
			//will assign the correct boundary for us
			headers: { 'Content-Type': undefined},
			//prevents serializing payload.  don't do it.
			transformRequest: angular.identity
		});




	/*	console.log('1', guardarRendicion)
		console.log('2', listaRendicion)
		console.log('3', documetosRendicion.File.lastModified);

		var fd = new FormData();
		
		fd.append('file', documetosRendicion);
		
		console.log('FD ---_>' , fd);

		//var fd = new FormData();
		//fd.append('file', documetosRendicion);


	/*	$http.post(uploadUrl, fd, {
			transformRequest: angular.identity,
			headers: { 'Content-Type': undefined }
		})*/

		/*
		var data = $http({
			transformRequest: angular.identity,
			headers: { 'Content-Type': undefined },
			params: {'datos' : guardarRendicion, 'grilla': listaRendicion, documento:fd},
			method: 'POST',
			url: host25+'SolicitudRendicionTotales/add'
		});
		*/
		//console.log(data);
		
	//	return data; 
	//};

	
}]);