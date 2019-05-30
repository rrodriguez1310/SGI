app.service('listaContratosEmpresas', ["$http",'$location',  function($http, $location) {
	
	var urlEmpresa = $location.absUrl().split('/');
		corte = urlEmpresa.length -1

	this.listaContratos = function(){
		var data = $http({
			params: {idEmpresa:urlEmpresa[corte]},
			method: 'GET',
			url: host25+'companies/lista_contratos_empresas'
		});
		return data;
	};

	this.Contrato = function(id){
		var data = $http({
			params: {idEmpresaContrato: id},
			method: 'GET',
			url: host25+'companies/lista_contratos_empresas_id'
		});
		return data;
	};
	
	this.listaTodosLosContratos = function(){
		var data = $http({
			method: 'GET',
			url: host25+'companies/lista_contratos'
		});
		return data;
	};

	this.listaTodosLosContratosGerencias = function(){
		var data = $http({
			method: 'GET',
			url: host25+'companies/lista_contratos_gerencia'
		});
		return data;
	};

	this.verificaFecha = function(fecha)
	{
		var data = $http({
			method: 'GET',
			params: {idEmpresa:urlEmpresa[corte], fecha:fecha},
			url: host25+'companies/verifica_fecha'
		});
		return data;
	}
	
	this.logContratos = function (idContrato){
		return $http({
			method: 'GET',
			url: host+'companies/log_contratos/'+idContrato
		});
	}

}]);
