app.factory('catalogacionRequerimientosFactory', function(){
	return {
		arregloMinutos : function(){
			minutos = [];
			for (var i = 0; i < 60; i++) {
				minutos.push(("0"+i).slice(-2));
			};
			return minutos;
		},
		arregloHoras : function(){
			horas = [];
			for (var i = 0; i < 24; i++) {
				horas.push(("0"+i).slice(-2));
			};
			return horas;
		},
		arregloCuadros : function(){
			cuadros = [];
			for (var i = 0; i < 30; i++) {
				cuadros.push(("0"+i).slice(-2));
			};
			return cuadros;
		}
	};
})