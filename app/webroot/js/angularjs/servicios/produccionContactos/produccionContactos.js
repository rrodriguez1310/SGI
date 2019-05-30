app.service('produccionContactos', function($http){
	this.listaContactos = function(){
		var data = $http({
			method: 'GET',
			url: host+'produccion_contactos/lista_destinatarios_json'
		});
		return data; 
	};
	this.listaExternos = function(){
		var data = $http({
			method: 'GET',
			url: host+'produccion_contactos/lista_externos_json'
		});
		return data; 
	};
	this.listaResponsables = function(){
		var data = $http({
			method: 'GET',
			url: host+'produccion_contactos/lista_responsables_json'
		});
		return data; 
	};
	this.listaTrabajadores = function(){
		var data = $http({
			method: 'GET',
			url: host+'produccion_contactos/lista_trabajadores_json'
		});
		return data; 
	};
})