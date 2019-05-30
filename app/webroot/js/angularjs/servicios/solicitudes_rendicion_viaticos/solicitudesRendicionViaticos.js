app.service('solicitudesRendicionviaticos', ["$http",'$location',  function($http, $location) {
	

	this.listaRendicionViaticos = function(area){ 
		var data = $http({
			params: {modulo : area},
			method: 'POST',
			url: host25+'SolicitudRequerimientoViaticos/lista_viaticos'
		});
		return data; 
	};

	this.formularioRendicionFondoAdd= function(dat){
		var data = $http({
			params: dat,
			method: 'POST',
			url: host25+'SolicitudRequerimientoViaticos/add_rendicion_viaticos'
		});
		return data; 
	};

	this.formularioRendicionFondo = function(dat,largo, id){
		//console.log(largo);
		dat['largo']=largo;
		dat['id']=id;
		var data = $http({
			params: dat,
			method: 'POST',
			url: host25+'SolicitudRequerimientoViaticos/edit_rendicion_fondos'
		});
		return data; 
	};


	this.actualizaEstado=function(id, estado, motivo, ndocuemnto){
		var data = $http({
			params: {id : id, estado: estado, motivo:motivo, n_documento:ndocuemnto},
			method: 'POST',
			url: host25+'SolicitudRequerimientoViaticos/add_estados'
		});
		return data; 
	};

	this.eliminaRegistro = function(id){
		var data = $http({
			//params: {id:id},
			method: 'POST',
			url: host25+'SolicitudRequerimientoViaticos/delete/'+id
		});
		return data; 
	};


	this.listaRendicioViatico = function(id){ 

		///alert(id)
		var data = $http({
			//params: {id : id},
			method: 'POST',
			url: host25+'SolicitudRequerimientoViaticos/add_rendicion_fondos_rechazo/'+id
		});
		return data; 
	};


	this.cargaDinamicaFondoViatico=function(id){

		var data = $http({
			//params: {id:id},
			method: 'POST',
			url: host25+'SolicitudRequerimientoViaticos/datos_rendicion/'+id
		});
		return data; 
	}

	this.eliminaRegistro = function(id){
		var data = $http({
			params: {id:id},
			method: 'POST',
			url: host25+'SolicitudRequerimientoViaticos/delete_gasto'
		});
		return data; 
	}


	
	this.guardaRedicionFondos = function(guardarRendicion, listaRendicion, documetosRendicion, total){
        
        
        console.log('1 -> ', guardarRendicion)
        console.log('2 -> ', listaRendicion)
        console.log('3 -> ', documetosRendicion)
        console.log('4 -> ', total)
  

			console.log("1",guardarRendicion);
			console.log("2",listaRendicion);
			console.log("3",documetosRendicion);
			console.log("4",total);
		//	console.log("4",idFolio);

		var payload = new FormData();


		payload.append("total", total);
		payload.append("rendicion", JSON.stringify(guardarRendicion));
		payload.append('lista', JSON.stringify(listaRendicion));
        
        console.log('payload --> ', payload);
        //return false;
        
        
        
        
        
        


		angular.forEach(documetosRendicion,function(file){
			payload.append('file[]',file);
		});
        
	
		var data = $http({
			url: host25+'SolicitudRequerimientoViaticos/add_viaticos',
			method: 'POST',
			data: payload,
			//assign content-type as undefined, the browser
			//will assign the correct boundary for us
			headers: { 'Content-Type': undefined},
			//prevents serializing payload.  don't do it.
			transformRequest: angular.identity
		});
		
		return data; 
	};
//, listaRendicion, documetosRendicion, total, idFolio, id
	this.actualizaRedicionFondos = function(guardarRendicion, listaRendicion, documetosRendicion,total, id){

	var payload = new FormData();

	//payload.append("idFolio",idFolio);
	payload.append("total", total);
	payload.append("rendicion", JSON.stringify(guardarRendicion));
	payload.append('lista', JSON.stringify(listaRendicion));
	//payload.append('file', documetosRendicion);
	payload.append('id', id);


	angular.forEach(documetosRendicion,function(file){
		payload.append('file[]',file);
	});

	var data = $http({
		url: host25+'SolicitudRequerimientoViaticos/edit_viatico',
		method: 'POST',
		data: payload,
		//assign content-type as undefined, the browser
		//will assign the correct boundary for us
		headers: { 'Content-Type': undefined},
		//prevents serializing payload.  don't do it.
		transformRequest: angular.identity
	});
	
	return data; 
};

	
}]);
