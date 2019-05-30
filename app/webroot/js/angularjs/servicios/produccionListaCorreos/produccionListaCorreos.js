app.service('produccionListaCorreos', function($http){
	this.listadoListaCorreos = function(){
		var data = $http({
			method: 'GET',
			url: host+'produccion_lista_correos/listado_lista_correos_json'
		});
		return data;
	};

	this.contactosListaCorreos = function(id){
		var data = $http({
			method: 'GET',
			url: host+'produccion_lista_correos/contactos_lista_correos_json/'+id
		});
		return data;
	};

	this.addContactoLista = function(idLista,idContacto){
		var data = $http({
			method: 'GET',
			url: host+'produccion_lista_correos/add_contacto_lista/'+idLista+'/'+idContacto
		});
		return data;
	};

	this.deleteContactoLista = function(idLista,idContacto){
		var data = $http({
			method: 'GET',
			url: host+'produccion_lista_correos/delete_contacto_lista/'+idLista+'/'+idContacto
		});
		return data;
	};

})