app.service('servicios', ["$http", function($http) {

	this.arraySum = function(array){
		suma = 0;
		angular.forEach(array, function(value, key){
			suma = suma+parseFloat(value);
		});
		return suma;
	};

	this.estadoCivil = function(){
		estadoCivilArray = ["Soltero(a)", "Casado(a)", "Divorciado(a)", "Viudo(a)"];
		estadoCivil = [];
		angular.forEach(estadoCivilArray, function (estadoCivilValor){
			estadoCivil.push({
				id: estadoCivilValor,
				nombre: estadoCivilValor
			});
		});
		return estadoCivil;
	};
	this.sexo = function(){
		sexoArray = ["Masculino", "Femenino"];
		sexos = [];
		angular.forEach(sexoArray, function (sexosValor, id){
			sexos.push({
				id: id,
				nombre: sexosValor
			});
		});
		return sexos;
	};
	this.tiposMonedasList = function(){
		var data = $http({
			method: 'GET',
			url: host+'tipos_monedas/tipos_monedas_list'
		});		
		return data;
	};
	this.bancosList = function(){
		var data = $http({
			method: 'GET',
			url: host+'bancos/bancos_list'
		});		
		return data;
	};
	this.tiposCuentaBancosList = function(){
		var data = $http({
			method: 'GET',
			url: host+'tipos_cuenta_bancos/tipos_cuenta_bancos_list'
		});		
		return data;
	};
	this.pdfBasico = function(parametros){
		var data = $http({
			method: 'POST',
			data : $.param(parametros),
			url: host+'servicios/pdf_basico'
		});		
		return data;	
	};
	this.representantesLegales = function(){
		return [{
			rut : "8.675.623-4",
			nombre : "Gonzalo Au Alvarado"
		}/*,
		{
			rut : "10.046.036-K",
			nombre : "Martin Awad Cherit"
		}*/]
	};
}]);