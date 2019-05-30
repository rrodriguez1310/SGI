app.factory('ratingMinutosFactory', ["$http", "$q", "ratingMinutosService", "servicios", "$filter", function($http, $q, ratingMinutosService, servicios, $filter) {

	return {
		semanasInformeBandas : function(fechas) {
			
			return $q(function(resolve, reject) {
				var semanaSolicitadaArray = {};
				var i = 0;
				semanaSolicitada = ratingMinutosService.minutos_rango_bandas_horas(fechas.inicio, fechas.final);
				semanaSolicitada.success(function (data){
					if(data!=0){
						angular.forEach(data, function (valores, llave){
							semanaSolicitadaArray[llave] = {
								"cdfb": data[llave][1].rating,
								"cdfp": data[llave][2].rating,
								"cdfhd": data[llave][3].rating,
								"espn": data[llave][10].rating,
								"espnm": data[llave][12].rating,								
								"espn3": data[llave][13].rating,								
								"fs": data[llave][6].rating,
								"fsp": data[llave][9].rating,
								"fs2": data[llave][7].rating,
								"fs3": data[llave][8].rating,
								"tvr": data[llave][1].tvr	

							};
							if (typeof data[llave][11] !== 'undefined'){
								semanaSolicitadaArray[llave]['espnhd'] = data[llave][11].rating;
							}
							if (typeof data[llave][16] !== 'undefined'){
								semanaSolicitadaArray[llave]['espn2'] = data[llave][16].rating;
							}

						});
					}else{
						semanaSolicitadaArray = 0;	
					}
					resolve(semanaSolicitadaArray);
				});
  			});
		},
		semana : function(semanaSolicitada, solicitado){
			var semanaSolicitadaArray = {};
			var resultado = {};
			semanaSolicitadaArray["promedio"] = {
				"cdfb": 0,
				"cdfp": 0,
				"cdfhd": 0,
				"espn": 0,
				"espnm": 0,
				"espn2": 0,
				"espn3": 0,
				"espnhd": 0,
				"fs": 0,
				"fsp": 0,
				"fs2": 0,
				"fs3": 0,
				"tvr": 0	
			};
			angular.forEach(semanaSolicitada, function(valores,key){
				hora = key.slice(11,13);
				if(parseInt(hora)>6 && parseInt(hora)<24 ){
					semanaSolicitadaArray["promedio"] = {
						"cdfb": parseFloat(semanaSolicitadaArray["promedio"]["cdfb"])+parseFloat(valores.cdfb),
						"cdfp": parseFloat(semanaSolicitadaArray["promedio"]["cdfp"])+parseFloat(valores.cdfp),
						"cdfhd": parseFloat(semanaSolicitadaArray["promedio"]["cdfhd"])+parseFloat(valores.cdfhd),
						"espn": parseFloat(semanaSolicitadaArray["promedio"]["espn"])+parseFloat(valores.espn),
						"espnm": parseFloat(semanaSolicitadaArray["promedio"]["espnm"])+parseFloat(valores.espnm),
						"espn2": parseFloat(semanaSolicitadaArray["promedio"]["espn2"])+parseFloat(valores.espn2),
						"espn3": parseFloat(semanaSolicitadaArray["promedio"]["espn3"])+parseFloat(valores.espn3),
						"espnhd": parseFloat(semanaSolicitadaArray["promedio"]["espnhd"])+parseFloat(valores.espnhd),
						"fs": parseFloat(semanaSolicitadaArray["promedio"]["fs"])+parseFloat(valores.fs),
						"fsp": parseFloat(semanaSolicitadaArray["promedio"]["fsp"])+parseFloat(valores.fsp),
						"fs2": parseFloat(semanaSolicitadaArray["promedio"]["fs2"])+parseFloat(valores.fs2),
						"fs3": parseFloat(semanaSolicitadaArray["promedio"]["fs3"])+parseFloat(valores.fs3),
						"tvr": parseFloat(semanaSolicitadaArray["promedio"]["tvr"])+parseFloat(valores.tvr)
					};
				}
				if(parseInt(hora)>=0 && parseInt(hora)<2 ){
					semanaSolicitadaArray["promedio"] = {
						"cdfb": parseFloat(semanaSolicitadaArray["promedio"]["cdfb"])+parseFloat(valores.cdfb),
						"cdfp": parseFloat(semanaSolicitadaArray["promedio"]["cdfp"])+parseFloat(valores.cdfp),
						"cdfhd": parseFloat(semanaSolicitadaArray["promedio"]["cdfhd"])+parseFloat(valores.cdfhd),
						"espn": parseFloat(semanaSolicitadaArray["promedio"]["espn"])+parseFloat(valores.espn),
						"espnm": parseFloat(semanaSolicitadaArray["promedio"]["espnm"])+parseFloat(valores.espnm),
						"espn2": parseFloat(semanaSolicitadaArray["promedio"]["espn2"])+parseFloat(valores.espn2),
						"espn3": parseFloat(semanaSolicitadaArray["promedio"]["espn3"])+parseFloat(valores.espn3),
						"espnhd": parseFloat(semanaSolicitadaArray["promedio"]["espnhd"])+parseFloat(valores.espnhd),
						"fs": parseFloat(semanaSolicitadaArray["promedio"]["fs"])+parseFloat(valores.fs),
						"fsp": parseFloat(semanaSolicitadaArray["promedio"]["fsp"])+parseFloat(valores.fsp),
						"fs2": parseFloat(semanaSolicitadaArray["promedio"]["fs2"])+parseFloat(valores.fs2),
						"fs3": parseFloat(semanaSolicitadaArray["promedio"]["fs3"])+parseFloat(valores.fs3),
						"tvr": parseFloat(semanaSolicitadaArray["promedio"]["tvr"])+parseFloat(valores.tvr)
					};
				}
				if(angular.isDefined(semanaSolicitadaArray[hora])){
					semanaSolicitadaArray[hora] = {
						"cdfb": parseFloat(semanaSolicitadaArray[hora]["cdfb"])+parseFloat(valores.cdfb),
						"cdfp": parseFloat(semanaSolicitadaArray[hora]["cdfp"])+parseFloat(valores.cdfp),
						"cdfhd": parseFloat(semanaSolicitadaArray[hora]["cdfhd"])+parseFloat(valores.cdfhd),
						"espn": parseFloat(semanaSolicitadaArray[hora]["espn"])+parseFloat(valores.espn),
						"espnm": parseFloat(semanaSolicitadaArray[hora]["espnm"])+parseFloat(valores.espnm),
						"espn2": parseFloat(semanaSolicitadaArray[hora]["espn2"])+parseFloat(valores.espn2),
						"espn3": parseFloat(semanaSolicitadaArray[hora]["espn3"])+parseFloat(valores.espn3),
						"espnhd": parseFloat(semanaSolicitadaArray[hora]["espnhd"])+parseFloat(valores.espnhd),
						"fs": parseFloat(semanaSolicitadaArray[hora]["fs"])+parseFloat(valores.fs),
						"fsp": parseFloat(semanaSolicitadaArray[hora]["fsp"])+parseFloat(valores.fsp),
						"fs2": parseFloat(semanaSolicitadaArray[hora]["fs2"])+parseFloat(valores.fs2),
						"fs3": parseFloat(semanaSolicitadaArray[hora]["fs3"])+parseFloat(valores.fs3),
						"tvr": parseFloat(semanaSolicitadaArray[hora]["tvr"])+parseFloat(valores.tvr)
					};
				}else{
					semanaSolicitadaArray[hora] = {
						"cdfb": valores.cdfb,
						"cdfp": valores.cdfp,
						"cdfhd": valores.cdfhd,
						"espn": valores.espn,
						"espnm": valores.espnm,
						"espn2": valores.espn2,
						"espn3": valores.espn3,
						"espnhd": valores.espnhd,
						"fs": valores.fs,
						"fsp": valores.fsp,
						"fs2": valores.fs2,
						"fs3": valores.fs3,
						"tvr": valores.tvr	
					};
				}
			});
			resultado["semana1"+solicitado] = {
				"promedio": semanaSolicitadaArray["promedio"],
				"06" : semanaSolicitadaArray["06"],
				"07" : semanaSolicitadaArray["07"],
				"08" : semanaSolicitadaArray["08"],
				"09" : semanaSolicitadaArray["09"],
				"10" : semanaSolicitadaArray["10"],
				"11" : semanaSolicitadaArray["11"],
				"12" : semanaSolicitadaArray["12"],
				"13" : semanaSolicitadaArray["13"],
				"14" : semanaSolicitadaArray["14"],
				"15" : semanaSolicitadaArray["15"],
				"16" : semanaSolicitadaArray["16"],
				"17" : semanaSolicitadaArray["17"],
				"18" : semanaSolicitadaArray["18"],
				"19" : semanaSolicitadaArray["19"],
				"20" : semanaSolicitadaArray["20"],
				"21" : semanaSolicitadaArray["21"],
				"22" : semanaSolicitadaArray["22"],
				"23" : semanaSolicitadaArray["23"],
			};
			resultado["semana2"+solicitado] = {
				"00" : semanaSolicitadaArray["00"],
				"01" : semanaSolicitadaArray["01"],
				"02" : semanaSolicitadaArray["02"],
				"03" : semanaSolicitadaArray["03"],
				"04" : semanaSolicitadaArray["04"],
				"05" : semanaSolicitadaArray["05"],
			};
			return resultado;
		},
		dia : function(semanaSolicitada, fecha1, fecha2, fechaPromedio1, fechaPromedio2){
			semanaSolicitadaArray = {};
			resultado = {};
			semanaSolicitadaArray["promedio"] = {
				"cdfb": 0,
				"cdfp": 0,
				"cdfhd": 0,
				"espn": 0,
				"espnm": 0,
				"espn2": 0,
				"espn3": 0,
				"espnhd": 0,
				"fs": 0,
				"fsp": 0,
				"fs2": 0,
				"fs3": 0,
				"tvr": 0
			};
			angular.forEach(semanaSolicitada, function(valores,key){
				fechaKey = new Date(key.slice(0,4), parseInt(key.slice(5,7))-1, parseInt(key.slice(8,10)), parseInt(key.slice(11,13)));
				if(fechaKey>=fechaPromedio1 && fechaKey<=fechaPromedio2 ){
					semanaSolicitadaArray["promedio"] = {
						"cdfb": parseFloat(semanaSolicitadaArray["promedio"]["cdfb"])+parseFloat(valores.cdfb),
						"cdfp": parseFloat(semanaSolicitadaArray["promedio"]["cdfp"])+parseFloat(valores.cdfp),
						"cdfhd": parseFloat(semanaSolicitadaArray["promedio"]["cdfhd"])+parseFloat(valores.cdfhd),
						"espn": parseFloat(semanaSolicitadaArray["promedio"]["espn"])+parseFloat(valores.espn),
						"espnm": parseFloat(semanaSolicitadaArray["promedio"]["espnm"])+parseFloat(valores.espnm),
						"espn2": parseFloat(semanaSolicitadaArray["promedio"]["espn2"])+parseFloat(valores.espn2),
						"espn3": parseFloat(semanaSolicitadaArray["promedio"]["espn3"])+parseFloat(valores.espn3),
						"espnhd": parseFloat(semanaSolicitadaArray["promedio"]["espnhd"])+parseFloat(valores.espnhd),
						"fs": parseFloat(semanaSolicitadaArray["promedio"]["fs"])+parseFloat(valores.fs),
						"fsp": parseFloat(semanaSolicitadaArray["promedio"]["fsp"])+parseFloat(valores.fsp),
						"fs2": parseFloat(semanaSolicitadaArray["promedio"]["fs2"])+parseFloat(valores.fs2),
						"fs3": parseFloat(semanaSolicitadaArray["promedio"]["fs3"])+parseFloat(valores.fs3),
						"tvr": parseFloat(semanaSolicitadaArray["promedio"]["tvr"])+parseFloat(valores.tvr)
					};
				}
			});
			if(angular.isDefined(semanaSolicitada[fecha1+" 06"]) && angular.isDefined(semanaSolicitada[fecha2+" 05"])){
				resultado["semana1"] = {
					"promedio" : semanaSolicitadaArray["promedio"],
					"06" : semanaSolicitada[fecha1+" 06"],
					"07" : semanaSolicitada[fecha1+" 07"],
					"08" : semanaSolicitada[fecha1+" 08"],
					"09" : semanaSolicitada[fecha1+" 09"],
					"10" : semanaSolicitada[fecha1+" 10"],
					"11" : semanaSolicitada[fecha1+" 11"],
					"12" : semanaSolicitada[fecha1+" 12"],
					"13" : semanaSolicitada[fecha1+" 13"],
					"14" : semanaSolicitada[fecha1+" 14"],
					"15" : semanaSolicitada[fecha1+" 15"],
					"16" : semanaSolicitada[fecha1+" 16"],
					"17" : semanaSolicitada[fecha1+" 17"],
					"18" : semanaSolicitada[fecha1+" 18"],
					"19" : semanaSolicitada[fecha1+" 19"],
					"20" : semanaSolicitada[fecha1+" 20"],
					"21" : semanaSolicitada[fecha1+" 21"],
					"22" : semanaSolicitada[fecha1+" 22"],
					"23" : semanaSolicitada[fecha1+" 23"],
				};
				resultado["semana2"] = {
					"00" : semanaSolicitada[fecha2+" 00"],
					"01" : semanaSolicitada[fecha2+" 01"],
					"02" : semanaSolicitada[fecha2+" 02"],
					"03" : semanaSolicitada[fecha2+" 03"],
					"04" : semanaSolicitada[fecha2+" 04"],
					"05" : semanaSolicitada[fecha2+" 05"],
				};
			}else{

				resultado["error"] =  "No se encontro información en la busqueda";
			}
			return resultado;
		},
		lav : function(semanaSolicitada, solicitado){
			resultado = {};
			semanaSolicitadaArray = {};
			semanaSolicitadaArray["promedio"] = {
				"cdfb": 0,
				"cdfp": 0,
				"cdfhd": 0,
				"espn": 0,
				"espnm": 0,
				"espn2": 0,
				"espn3": 0,
				"espnhd": 0,
				"fs": 0,
				"fsp": 0,
				"fs2": 0,
				"fs3": 0,
				"tvr": 0	
			};
			angular.forEach(semanaSolicitada, function(valores,key){
				fecha = new Date(key.slice(0,4), parseInt(key.slice(5,7)-1), parseInt(key.slice(8,10)), parseInt(key.slice(11,13)));
				if(fecha<fechaLimite){					
					hora = key.slice(11,13);
					if(parseInt(hora)>6 && parseInt(hora)<24 ){
						semanaSolicitadaArray["promedio"] = {
							"cdfb": parseFloat(semanaSolicitadaArray["promedio"]["cdfb"])+parseFloat(valores.cdfb),
							"cdfp": parseFloat(semanaSolicitadaArray["promedio"]["cdfp"])+parseFloat(valores.cdfp),
							"cdfhd": parseFloat(semanaSolicitadaArray["promedio"]["cdfhd"])+parseFloat(valores.cdfhd),
							"espn": parseFloat(semanaSolicitadaArray["promedio"]["espn"])+parseFloat(valores.espn),
							"espnm": parseFloat(semanaSolicitadaArray["promedio"]["espnm"])+parseFloat(valores.espnm),
							"espn2": parseFloat(semanaSolicitadaArray["promedio"]["espn2"])+parseFloat(valores.espn2),
							"espn3": parseFloat(semanaSolicitadaArray["promedio"]["espn3"])+parseFloat(valores.espn3),
							"espnhd": parseFloat(semanaSolicitadaArray["promedio"]["espnhd"])+parseFloat(valores.espnhd),
							"fs": parseFloat(semanaSolicitadaArray["promedio"]["fs"])+parseFloat(valores.fs),
							"fsp": parseFloat(semanaSolicitadaArray["promedio"]["fsp"])+parseFloat(valores.fsp),
							"fs2": parseFloat(semanaSolicitadaArray["promedio"]["fs2"])+parseFloat(valores.fs2),
							"fs3": parseFloat(semanaSolicitadaArray["promedio"]["fs3"])+parseFloat(valores.fs3),
							"tvr": parseFloat(semanaSolicitadaArray["promedio"]["tvr"])+parseFloat(valores.tvr)
						};
					}

					if(parseInt(hora)>=0 && parseInt(hora)<2 ){
						semanaSolicitadaArray["promedio"] = {
							"cdfb": parseFloat(semanaSolicitadaArray["promedio"]["cdfb"])+parseFloat(valores.cdfb),
							"cdfp": parseFloat(semanaSolicitadaArray["promedio"]["cdfp"])+parseFloat(valores.cdfp),
							"cdfhd": parseFloat(semanaSolicitadaArray["promedio"]["cdfhd"])+parseFloat(valores.cdfhd),
							"espn": parseFloat(semanaSolicitadaArray["promedio"]["espn"])+parseFloat(valores.espn),
							"espnm": parseFloat(semanaSolicitadaArray["promedio"]["espnm"])+parseFloat(valores.espnm),
							"espn2": parseFloat(semanaSolicitadaArray["promedio"]["espn2"])+parseFloat(valores.espn2),
							"espn3": parseFloat(semanaSolicitadaArray["promedio"]["espn3"])+parseFloat(valores.espn3),
							"espnhd": parseFloat(semanaSolicitadaArray["promedio"]["espnhd"])+parseFloat(valores.espnhd),
							"fs": parseFloat(semanaSolicitadaArray["promedio"]["fs"])+parseFloat(valores.fs),
							"fsp": parseFloat(semanaSolicitadaArray["promedio"]["fsp"])+parseFloat(valores.fsp),
							"fs2": parseFloat(semanaSolicitadaArray["promedio"]["fs2"])+parseFloat(valores.fs2),
							"fs3": parseFloat(semanaSolicitadaArray["promedio"]["fs3"])+parseFloat(valores.fs3),
							"tvr": parseFloat(semanaSolicitadaArray["promedio"]["tvr"])+parseFloat(valores.tvr)
						};
					}
					
					if(angular.isDefined(semanaSolicitadaArray[hora])){
						semanaSolicitadaArray[hora] = {
							"cdfb": parseFloat(semanaSolicitadaArray[hora]["cdfb"])+parseFloat(valores.cdfb),
							"cdfp": parseFloat(semanaSolicitadaArray[hora]["cdfp"])+parseFloat(valores.cdfp),
							"cdfhd": parseFloat(semanaSolicitadaArray[hora]["cdfhd"])+parseFloat(valores.cdfhd),
							"espn": parseFloat(semanaSolicitadaArray[hora]["espn"])+parseFloat(valores.espn),
							"espnm": parseFloat(semanaSolicitadaArray[hora]["espnm"])+parseFloat(valores.espnm),
							"espn2": parseFloat(semanaSolicitadaArray[hora]["espn2"])+parseFloat(valores.espn2),
							"espn3": parseFloat(semanaSolicitadaArray[hora]["espn3"])+parseFloat(valores.espn3),
							"espnhd": parseFloat(semanaSolicitadaArray[hora]["espnhd"])+parseFloat(valores.espnhd),
							"fs": parseFloat(semanaSolicitadaArray[hora]["fs"])+parseFloat(valores.fs),
							"fsp": parseFloat(semanaSolicitadaArray[hora]["fsp"])+parseFloat(valores.fsp),
							"fs2": parseFloat(semanaSolicitadaArray[hora]["fs2"])+parseFloat(valores.fs2),
							"fs3": parseFloat(semanaSolicitadaArray[hora]["fs3"])+parseFloat(valores.fs3),
							"tvr": parseFloat(semanaSolicitadaArray[hora]["tvr"])+parseFloat(valores.tvr)
						};	
					}else{
						semanaSolicitadaArray[hora] = {
							"cdfb": valores.cdfb,
							"cdfp": valores.cdfp,
							"cdfhd": valores.cdfhd,
							"espn": valores.espn,
							"espnm": valores.espnm,
							"espn2": typeof valores.espn2 !== '' ? valores.espn2 : 0,
							"espn3": valores.espn3,
							"espnhd": valores.espnhd,
							"fs": valores.fs,
							"fsp": valores.fsp,
							"fs2": valores.fs2,
							"fs3": valores.fs3,
							"tvr": valores.tvr
						};
					}
				}						
			});

			resultado["semana1"] = {
				"promedio" : semanaSolicitadaArray["promedio"],
				"06" : semanaSolicitadaArray["06"],
				"07" : semanaSolicitadaArray["07"],
				"08" : semanaSolicitadaArray["08"],
				"09" : semanaSolicitadaArray["09"],
				"10" : semanaSolicitadaArray["10"],
				"11" : semanaSolicitadaArray["11"],
				"12" : semanaSolicitadaArray["12"],
				"13" : semanaSolicitadaArray["13"],
				"14" : semanaSolicitadaArray["14"],
				"15" : semanaSolicitadaArray["15"],
				"16" : semanaSolicitadaArray["16"],
				"17" : semanaSolicitadaArray["17"],
				"18" : semanaSolicitadaArray["18"],
				"19" : semanaSolicitadaArray["19"],
				"20" : semanaSolicitadaArray["20"],
				"21" : semanaSolicitadaArray["21"],
				"22" : semanaSolicitadaArray["22"],
				"23" : semanaSolicitadaArray["23"],
			};
			resultado["semana2"] = {
				"00" : semanaSolicitadaArray["00"],
				"01" : semanaSolicitadaArray["01"],
				"02" : semanaSolicitadaArray["02"],
				"03" : semanaSolicitadaArray["03"],
				"04" : semanaSolicitadaArray["04"],
				"05" : semanaSolicitadaArray["05"],
			};
			return resultado;
		},
		sad : function(semanaSolicitada, fechaInicio, fechaFinal){
			var semanaSolicitadaArray = {};
			resultado = {};
			semanaSolicitadaArray["promedio"] = {
				"cdfb": 0,
				"cdfp": 0,
				"cdfhd": 0,
				"espn": 0,
				"espnm": 0,
				"espn2": 0,
				"espn3": 0,
				"espnhd": 0,
				"fs": 0,
				"fsp": 0,
				"fs2": 0,
				"fs3": 0,
				"tvr": 0	
			};
			angular.forEach(semanaSolicitada, function(valores,key){
				fecha = new Date(key.slice(0,4), parseInt(key.slice(5,7)-1), parseInt(key.slice(8,10)), parseInt(key.slice(11,13)));
				if(fecha>=fechaInicio && fecha<=fechaFinal){
					hora = key.slice(11,13);
					if(parseInt(hora)>6 && parseInt(hora)<24 ){
						semanaSolicitadaArray["promedio"] = {
							"cdfb": parseFloat(semanaSolicitadaArray["promedio"]["cdfb"])+parseFloat(valores.cdfb),
							"cdfp": parseFloat(semanaSolicitadaArray["promedio"]["cdfp"])+parseFloat(valores.cdfp),
							"cdfhd": parseFloat(semanaSolicitadaArray["promedio"]["cdfhd"])+parseFloat(valores.cdfhd),
							"espn": parseFloat(semanaSolicitadaArray["promedio"]["espn"])+parseFloat(valores.espn),
							"espnm": parseFloat(semanaSolicitadaArray["promedio"]["espnm"])+parseFloat(valores.espnm),
							"espn2": parseFloat(semanaSolicitadaArray["promedio"]["espn2"])+parseFloat(valores.espn2),
							"espn3": parseFloat(semanaSolicitadaArray["promedio"]["espn3"])+parseFloat(valores.espn3),
							"espnhd": parseFloat(semanaSolicitadaArray["promedio"]["espnhd"])+parseFloat(valores.espnhd),
							"fs": parseFloat(semanaSolicitadaArray["promedio"]["fs"])+parseFloat(valores.fs),
							"fsp": parseFloat(semanaSolicitadaArray["promedio"]["fsp"])+parseFloat(valores.fsp),
							"fs2": parseFloat(semanaSolicitadaArray["promedio"]["fs2"])+parseFloat(valores.fs2),
							"fs3": parseFloat(semanaSolicitadaArray["promedio"]["fs3"])+parseFloat(valores.fs3),
							"tvr": parseFloat(semanaSolicitadaArray["promedio"]["tvr"])+parseFloat(valores.tvr)
						};
					}

					if(parseInt(hora)>=0 && parseInt(hora)<2 ){
						semanaSolicitadaArray["promedio"] = {
							"cdfb": parseFloat(semanaSolicitadaArray["promedio"]["cdfb"])+parseFloat(valores.cdfb),
							"cdfp": parseFloat(semanaSolicitadaArray["promedio"]["cdfp"])+parseFloat(valores.cdfp),
							"cdfhd": parseFloat(semanaSolicitadaArray["promedio"]["cdfhd"])+parseFloat(valores.cdfhd),
							"espn": parseFloat(semanaSolicitadaArray["promedio"]["espn"])+parseFloat(valores.espn),
							"espnm": parseFloat(semanaSolicitadaArray["promedio"]["espnm"])+parseFloat(valores.espnm),
							"espn2": parseFloat(semanaSolicitadaArray["promedio"]["espn2"])+parseFloat(valores.espn2),
							"espn3": parseFloat(semanaSolicitadaArray["promedio"]["espn3"])+parseFloat(valores.espn3),
							"espnhd": parseFloat(semanaSolicitadaArray["promedio"]["espnhd"])+parseFloat(valores.espnhd),
							"fs": parseFloat(semanaSolicitadaArray["promedio"]["fs"])+parseFloat(valores.fs),
							"fsp": parseFloat(semanaSolicitadaArray["promedio"]["fsp"])+parseFloat(valores.fsp),
							"fs2": parseFloat(semanaSolicitadaArray["promedio"]["fs2"])+parseFloat(valores.fs2),
							"fs3": parseFloat(semanaSolicitadaArray["promedio"]["fs3"])+parseFloat(valores.fs3),
							"tvr": parseFloat(semanaSolicitadaArray["promedio"]["tvr"])+parseFloat(valores.tvr)
						};
					}
					if(angular.isDefined(semanaSolicitadaArray[hora])){
						semanaSolicitadaArray[hora] = {
							"cdfb": parseFloat(semanaSolicitadaArray[hora]["cdfb"])+parseFloat(valores.cdfb),
							"cdfp": parseFloat(semanaSolicitadaArray[hora]["cdfp"])+parseFloat(valores.cdfp),
							"cdfhd": parseFloat(semanaSolicitadaArray[hora]["cdfhd"])+parseFloat(valores.cdfhd),
							"espn": parseFloat(semanaSolicitadaArray[hora]["espn"])+parseFloat(valores.espn),
							"espnm": parseFloat(semanaSolicitadaArray[hora]["espnm"])+parseFloat(valores.espnm),
							"espn2": parseFloat(semanaSolicitadaArray[hora]["espn2"])+parseFloat(valores.espn2),
							"espn3": parseFloat(semanaSolicitadaArray[hora]["espn3"])+parseFloat(valores.espn3),
							"espnhd": parseFloat(semanaSolicitadaArray[hora]["espnhd"])+parseFloat(valores.espnhd),
							"fs": parseFloat(semanaSolicitadaArray[hora]["fs"])+parseFloat(valores.fs),
							"fsp": parseFloat(semanaSolicitadaArray[hora]["fsp"])+parseFloat(valores.fsp),
							"fs2": parseFloat(semanaSolicitadaArray[hora]["fs2"])+parseFloat(valores.fs2),
							"fs3": parseFloat(semanaSolicitadaArray[hora]["fs3"])+parseFloat(valores.fs3),
							"tvr": parseFloat(semanaSolicitadaArray[hora]["tvr"])+parseFloat(valores.tvr),

						};	
					}else{
						semanaSolicitadaArray[hora] = {
							"cdfb": valores.cdfb,
							"cdfp": valores.cdfp,
							"cdfhd": valores.cdfhd,
							"espn": valores.espn,
							"espnm": valores.espnm,
							"espn2": typeof valores.espn2 !== 'undefined' ? valores.espn2 : 0,
							"espn3": valores.espn3,
							"espnhd": valores.espnhd,
							"fs": valores.fs,
							"fsp": valores.fsp,
							"fs2": valores.fs2,
							"fs3": valores.fs3,
							"tvr": valores.tvr
						};
					}

				}						
			});
			resultado["semana1"] = {
				"promedio": semanaSolicitadaArray["promedio"],
				"06" : semanaSolicitadaArray["06"],
				"07" : semanaSolicitadaArray["07"],
				"08" : semanaSolicitadaArray["08"],
				"09" : semanaSolicitadaArray["09"],
				"10" : semanaSolicitadaArray["10"],
				"11" : semanaSolicitadaArray["11"],
				"12" : semanaSolicitadaArray["12"],
				"13" : semanaSolicitadaArray["13"],
				"14" : semanaSolicitadaArray["14"],
				"15" : semanaSolicitadaArray["15"],
				"16" : semanaSolicitadaArray["16"],
				"17" : semanaSolicitadaArray["17"],
				"18" : semanaSolicitadaArray["18"],
				"19" : semanaSolicitadaArray["19"],
				"20" : semanaSolicitadaArray["20"],
				"21" : semanaSolicitadaArray["21"],
				"22" : semanaSolicitadaArray["22"],
				"23" : semanaSolicitadaArray["23"],
			};
			resultado["semana2"] = {
				"00" : semanaSolicitadaArray["00"],
				"01" : semanaSolicitadaArray["01"],
				"02" : semanaSolicitadaArray["02"],
				"03" : semanaSolicitadaArray["03"],
				"04" : semanaSolicitadaArray["04"],
				"05" : semanaSolicitadaArray["05"],
			};
			return resultado;
		},
		minutos : function(data){
			minutos = {};
			angular.forEach(data, function (valores, llave){
				minutos[llave] = {
					"cddatafb": data[llave][1].rating,
					"cdfp": data[llave][2].rating,
					"cdfhd": data[llave][3].rating,
					"espn": data[llave][10].rating,
					"espnm": data[llave][12].rating,					
					"espn3": data[llave][13].rating,
                    //"espnhd": data[llave][11].rating,
					"fs": data[llave][6].rating,
					"fsp": data[llave][9].rating,
					"fs2": data[llave][7].rating,
					"fs3": data[llave][8].rating,
					"tvr": data[llave][1].tvr	
				};

				if (typeof data[llave][16] !== 'undefined'){
					minutos[llave]['espn2'] = data[llave][16].rating;
				}
			});
			return minutos;
		},
		acumuladosAgrupados : function(acumulado, channels){
			acumuladoCanales = {};
			respuesta = {};
			angular.forEach(acumulado, function (canales, target){
				acumuladoCanales[target] = {};
				angular.forEach(canales, function (valores, canal){
					if(angular.isDefined(acumuladoCanales[target][channels[canal]["tipo"]])){
						acumuladoCanales[target][channels[canal]["tipo"]].push(valores);
					}else{
						acumuladoCanales[target][channels[canal]["tipo"]] = [];
						acumuladoCanales[target][channels[canal]["tipo"]].push(valores);						
					}
				});
			});
			angular.forEach(acumuladoCanales, function (tipos, target){
				respuesta[target] = {};
				angular.forEach(tipos, function (canales, tipo){
					respuesta[target][tipo] = {};
					//cantidadCanales = canales.length;
					angular.forEach(canales, function (valores){
						if(angular.isDefined(respuesta[target][tipo]["rating"])){
							respuesta[target][tipo]["rating"] = respuesta[target][tipo]["rating"]+valores["rating"];
							respuesta[target][tipo]["share"] = respuesta[target][tipo]["share"]+valores["share"];
							//respuesta[target][tipo]["tvr"] = respuesta[target][tipo]["tvr"]+valores["tvr"];
						}else{
							respuesta[target][tipo]["rating"] = valores["rating"];
							respuesta[target][tipo]["share"] = valores["share"];
							respuesta[target][tipo]["tvr"] = valores["tvr"];	
						}
					});
					//respuesta[target][tipo]["rating"] = respuesta[target][tipo]["rating"]/cantidadCanales;
					//respuesta[target][tipo]["share"] = respuesta[target][tipo]["share"]/cantidadCanales;
					//respuesta[target][tipo]["tvr"] = respuesta[target][tipo]["tvr"]/cantidadCanales;
				})
			});
			return respuesta;
		},
		acumuladosGraficos : function (acumulados, channels){
			acumuladoCanales = {};
			respuesta = { noagrupados : {} };
			acumuladosGrupos = {};
			respuesta["categorias"] = [];
			//respuesta["noagrupados"] = {};
			contador = 1;
			
			if(angular.isDefined(acumulados)){
				angular.forEach(acumulados, function (periodos, tipo){
					angular.forEach(periodos, function (targets, periodo){
						acumuladoCanales[periodo] = {};
						switch(tipo){
							case "meses" :
								mes = periodo.split("-");
								fecha = new Date(mes[1], mes[0]-1);
								respuesta["categorias"].push($filter("date")(fecha, 'MMM-yy'));
							break;
							case "semanas":
								semana = periodo.split("-");
								fecha = new Date(mes[1], mes[0]);
								respuesta["categorias"].push("s"+contador+"-"+$filter("date")(fecha, 'MMM-yy'));
								contador++;
							break; 
							
						}
						angular.forEach(targets, function (canales, target){
							acumuladoCanales[periodo][target] = {};
							angular.forEach(canales, function (valores, canal){
								if(angular.isDefined(acumuladoCanales[periodo][target][channels[canal]["tipo"]])){
									acumuladoCanales[periodo][target][channels[canal]["tipo"]].push(valores);
								}else{
									acumuladoCanales[periodo][target][channels[canal]["tipo"]] = [];
									acumuladoCanales[periodo][target][channels[canal]["tipo"]].push(valores);						
								}
								if(angular.isDefined(respuesta["noagrupados"][canal])){
									respuesta["noagrupados"][canal]["rating"].push(eval(valores.rating.toFixed(2)));
									respuesta["noagrupados"][canal]["share"].push(eval(((valores.rating/valores.tvr)*100).toFixed(2)));
									respuesta["noagrupados"][canal]["tvr"].push(eval(valores.tvr.toFixed(2)));
								}else{
									respuesta["noagrupados"][canal] = {};
									respuesta["noagrupados"][canal]["rating"] = [];
									respuesta["noagrupados"][canal]["share"] = [];
									respuesta["noagrupados"][canal]["tvr"] = [];
									respuesta["noagrupados"][canal]["rating"].push(eval(valores.rating.toFixed(2)));
									respuesta["noagrupados"][canal]["share"].push(eval(((valores.rating/valores.tvr)*100).toFixed(2)));
									respuesta["noagrupados"][canal]["tvr"].push(eval(valores.tvr.toFixed(2)));
								}
							});
						});
					});
				});
				angular.forEach(acumuladoCanales, function (targets, periodo){
					acumuladosGrupos[periodo] = {};
					angular.forEach(targets, function (tipos, target){
						acumuladosGrupos[periodo][target] = {};
						angular.forEach(tipos, function (canales, tipo){
							acumuladosGrupos[periodo][target][tipo] = {};
							cantidadCanales = canales.length;
							angular.forEach(canales, function (valores){
								if(angular.isDefined(acumuladosGrupos[periodo][target][tipo]["rating"])){
									acumuladosGrupos[periodo][target][tipo]["rating"] = acumuladosGrupos[periodo][target][tipo]["rating"]+valores["rating"];
									acumuladosGrupos[periodo][target][tipo]["share"] = acumuladosGrupos[periodo][target][tipo]["share"]+valores["share"];
								}else{
									acumuladosGrupos[periodo][target][tipo]["rating"] = valores["rating"];
									acumuladosGrupos[periodo][target][tipo]["share"] = valores["share"];
									acumuladosGrupos[periodo][target][tipo]["tvr"] = valores["tvr"];	
								}
							});
							acumuladosGrupos[periodo][target][tipo]["share"] = (acumuladosGrupos[periodo][target][tipo]["rating"]/acumuladosGrupos[periodo][target][tipo]["tvr"])*100;
						})
					});
				});
				respuesta["agrupados"] = {
					1 : {
						rating : [],
						share : [],
						tvr : []
					},
					2 : {
						rating : [],
						share : [],
						tvr : []
					},
					3 : {
						rating : [],
						share : [],
						tvr : []
					},
					4 : {
						rating : [],
						share : [],
						tvr : []
					},
					5 : {
						rating : [],
						share : [],
						tvr : []
					},
				}
				angular.forEach(acumuladosGrupos, function (targets, periodo){
					angular.forEach(targets, function (tipos, target){
						angular.forEach(tipos, function (valores, tipo){
							respuesta["agrupados"][tipo]["rating"].push(eval(valores["rating"].toFixed(2)));
							respuesta["agrupados"][tipo]["share"].push(eval(valores["share"].toFixed(2)));
							respuesta["agrupados"][tipo]["tvr"].push(eval(valores["tvr"].toFixed(2)));
						});
					});					
				});
			}
			return respuesta;
		},
		acumuladosAgrupadosSemana : function (acumulado, channels){
			acumuladoCanales = {};
			respuesta = {};
			angular.forEach(acumulado, function (targets, semana){
				acumuladoCanales[semana] = {};
				angular.forEach(targets, function (canales, target){
					acumuladoCanales[semana][target] = {};
					angular.forEach(canales, function (valores, canal){
						if(angular.isDefined(acumuladoCanales[semana][target][channels[canal]["tipo"]])){
							acumuladoCanales[semana][target][channels[canal]["tipo"]].push(valores);
						}else{
							acumuladoCanales[semana][target][channels[canal]["tipo"]] = [];
							acumuladoCanales[semana][target][channels[canal]["tipo"]].push(valores);						
						}
					});
				});	
			});
			angular.forEach(acumuladoCanales, function (targets, semana){
				respuesta[semana] = {};
				angular.forEach(targets, function (tipos, target){
					respuesta[semana][target] = {};
					angular.forEach(tipos, function (canales, tipo){
						respuesta[semana][target][tipo] = {};
						cantidadCanales = canales.length;
						angular.forEach(canales, function (valores){
							if(angular.isDefined(respuesta[semana][target][tipo]["rating"])){
								respuesta[semana][target][tipo]["rating"] = respuesta[semana][target][tipo]["rating"]+valores["rating"];
								respuesta[semana][target][tipo]["share"] = respuesta[semana][target][tipo]["share"]+valores["share"];
								//respuesta[semana][target][tipo]["tvr"] = respuesta[semana][target][tipo]["tvr"]+valores["tvr"];
							}else{
								respuesta[semana][target][tipo]["rating"] = valores["rating"];
								respuesta[semana][target][tipo]["share"] = valores["share"];
								respuesta[semana][target][tipo]["tvr"] = valores["tvr"];	
							}
							respuesta[semana][target][tipo]["fecha_inicio"] = valores.fecha_inicio;
							respuesta[semana][target][tipo]["fecha_final"] = valores.fecha_final;
							respuesta[semana][target][tipo]["estado"] = valores.estado;
						});
						//respuesta[semana][target][tipo]["rating"] = respuesta[semana][target][tipo]["rating"]/cantidadCanales;
						//respuesta[semana][target][tipo]["share"] = respuesta[semana][target][tipo]["share"]/cantidadCanales;
						//respuesta[semana][target][tipo]["tvr"] = respuesta[semana][target][tipo]["tvr"]/cantidadCanales;
					});
				});
			});
			return respuesta;
		}
	}
}]);
