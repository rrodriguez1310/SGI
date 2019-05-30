app.controller('abonadosCtrl', function ($scope, abonados) {

	var categorias = [];
	var segnalSeleccion = "";
	var operadores = "";
	var abonadosDirecTV = [];
	var abonadosMovistar = [];
	var abonadosClaro = [];
	var abonadosVtr = [];
	var abonadosEntel = [];
	var abonadosGtd = [];
	var abonadosTelSur = [];
	var abonadosOtros = [];

	var fechasTotal = [];
	
	var normalizacionDirecTv = [];
	var normalizacionClaro = [];
	var normalizacionMovistar = [];
	var normalizacionGtd = [];
	var normalizacionVtr = [];
	var normalizacionEntel = [];
	var normalizacionTelSur = [];
	var normalizacionOtros = [];

	var tipoGrafico = "";


	var fechaSeleccionada = '';


	var abonadosDirecTvNormalizado = [];
	var abonadosClaroNormalizado = [];
	var abonadosMovistarNormalizado = [];
	var abonadosVtrNormalizado = [];
	var abonadosEntelNormalizado = [];
	var abonadosGtdNormalizado = [];
	var abonadosTelSurNormalizado = [];
	var abonadosOtrosNormalizado = [];


	var contadorDirecTv = "";
	var contadorClaro = "";
	var contadorMovistar = "";
	var contadorVtr = "";
	var contadorEntel = "";
	var contadorGtd = "";
	var contadorTelSur = "";
	var contadorOtros = "";
	
	$scope.seleccionaFecha = function () {
        fechaSeleccionada = $scope.fecha

		if(fechaSeleccionada == '')
		{
			alert("Selecione un fecha antes de seleccionar un tipo de señal");
			return false;
		}
		
		
			tipoGrafico = 'CDF Basico';
		

			$scope.showTitulo = true;

			$scope.tituloGraficos = tipoGrafico;


			categorias.length = 0;
			operadores = "";
			abonadosDirecTV.length = 0;
			abonadosMovistar.length = 0;
			abonadosClaro.length = 0;
			abonadosVtr.length = 0;
			abonadosEntel.length = 0;
			abonadosGtd.length = 0;
			abonadosTelSur.length = 0;
			abonadosOtros.length = 0;

			fechasTotal.length = 0;
			
			normalizacionDirecTv.length = 0;
			normalizacionClaro.length = 0;
			normalizacionMovistar.length = 0;
			normalizacionGtd.length = 0;
			normalizacionVtr.length = 0;
			normalizacionEntel.length = 0;
			normalizacionTelSur.length = 0;
			normalizacionOtros.length = 0;

			abonadosDirecTvNormalizado.length = 0;
			abonadosClaroNormalizado.length = 0;
			abonadosMovistarNormalizado.length = 0;
			abonadosVtrNormalizado.length = 0;
			abonadosEntelNormalizado.length = 0;
			abonadosGtdNormalizado.length = 0;
			abonadosTelSurNormalizado.length = 0;
			abonadosOtrosNormalizado.length = 0;


			contadorDirecTv = '';
			contadorClaro = '';
			contadorMovistar = '';
			contadorVtr = '';
			contadorEntel = '';
			contadorGtd = '';
			contadorTelSur = '';
			contadorOtros = '';

			abonados.listaAbonados(fechaSeleccionada).success(function(data){
				angular.forEach(data, function(valueAgno, agno){
					angular.forEach(valueAgno, function(valueMes, mes){

						fechasTotal.push({'agno': agno, 'mes': mes})

						if(mes == 1)
			                mes = "Ene.";
			            if(mes == 2)
			                mes = "Feb.";
			            if(mes == 3)
			                mes = "Mar.";
			            if(mes == 4)
			                mes = "Abr.";
			            if(mes == 5)
			                mes = "may.";
			            if(mes == 6)
			                mes = "Jun.";
			            if(mes == 7)
			                mes = "Jul.";
			            if(mes == 8)
			                mes = "Ago.";
			            if(mes == 9)
			                mes = "Sep.";
			            if(mes == 10)
			                mes = "Oct.";
			            if(mes == 11)
			                mes = "Nov.";
			            if(mes == 12)
			                mes = "Dic.";
						categorias.push(mes + '' +agno)

						angular.forEach(valueMes, function(valueOperador, operador){
							angular.forEach(valueOperador, function(valueAbonados, keyAbonados){
								
								if(operador === "DirecTV")
									//console.log(keyAbonados);
									if(keyAbonados == tipoGrafico)

										//abonadosDirecTV.push(Number(valueAbonados[0].abonados));
									normalizacionDirecTv.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

								if(operador === "Movistar")
									if(keyAbonados == tipoGrafico)
										normalizacionMovistar.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})
										//abonadosMovistar.push(Number(valueAbonados[0].abonados));

								if(operador === "Claro Comunicaciones")
									if(keyAbonados == tipoGrafico)
										normalizacionClaro.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

								if(operador === "VTR")
									if(keyAbonados == tipoGrafico)
										normalizacionVtr.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

								if(operador === "Entel")
									if(keyAbonados == tipoGrafico)
										normalizacionEntel.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

								if(operador === "GTD")
									if(keyAbonados == tipoGrafico)
										normalizacionGtd.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

								if(operador === "Telsur")
									if(keyAbonados == tipoGrafico)
										normalizacionTelSur.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

								if(operador === "otros")
									if(keyAbonados == tipoGrafico)
										normalizacionOtros.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})
							});
						});
					});
				});

				 

				angular.forEach(fechasTotal, function(valueFecha, key){
					if(!angular.isUndefined(normalizacionClaro[key]))
					{
						contadorClaro = normalizacionClaro.length;	
						if(valueFecha.agno == normalizacionClaro[key]['agno'])
						{
							abonadosClaroNormalizado.push(normalizacionClaro[key]['valor'])
						}else{
							abonadosClaroNormalizado.push(normalizacionClaro[key]['valor'])
						}
					}
					else
					{
						abonadosClaroNormalizado.push(0)
					}

					if(!angular.isUndefined(normalizacionDirecTv[key]))
					{
						contadorDirecTv = normalizacionDirecTv.length;	
						if(valueFecha.agno == normalizacionDirecTv[key]['agno'])
						{
							abonadosDirecTvNormalizado.push(normalizacionDirecTv[key]['valor'])
						}else{
							abonadosDirecTvNormalizado.push(normalizacionDirecTv[key]['valor'])
						}
					}
					else
					{
						abonadosDirecTvNormalizado.push(0)
					}

					if(!angular.isUndefined(normalizacionMovistar[key]))
					{
						contadorMovistar = normalizacionMovistar.length;	
						if(valueFecha.agno == normalizacionMovistar[key]['agno'])
						{
							abonadosMovistarNormalizado.push(normalizacionMovistar[key]['valor'])
						}else{
							abonadosMovistarNormalizado.push(normalizacionMovistar[key]['valor'])
						}
					}
					else
					{
						abonadosMovistarNormalizado.push(0)
					}

					if(!angular.isUndefined(normalizacionVtr[key]))
					{
						contadorVtr = normalizacionVtr.length;	
						if(valueFecha.agno == normalizacionVtr[key]['agno'])
						{
							abonadosVtrNormalizado.push(normalizacionVtr[key]['valor'])
						}else{
							abonadosVtrNormalizado.push(normalizacionVtr[key]['valor'])
						}
					}
					else
					{
						abonadosVtrNormalizado.push(0)
					}


					if(!angular.isUndefined(normalizacionEntel[key]))
					{
						contadorEntel = normalizacionEntel.length;	
						if(valueFecha.agno == normalizacionEntel[key]['agno'])
						{
							abonadosEntelNormalizado.push(normalizacionEntel[key]['valor'])
						}else{
							abonadosEntelNormalizado.push(normalizacionEntel[key]['valor'])
						}
					}
					else
					{
						abonadosEntelNormalizado.push(0)
					}

					if(!angular.isUndefined(normalizacionGtd[key]))
					{
						contadorGtd = normalizacionGtd.length;	
						if(valueFecha.agno == normalizacionGtd[key]['agno'])
						{
							abonadosGtdNormalizado.push(normalizacionGtd[key]['valor'])
						}else{
							abonadosGtdNormalizado.push(normalizacionGtd[key]['valor'])
						}
					}
					else
					{
						abonadosGtdNormalizado.push(0)
					}

					if(!angular.isUndefined(normalizacionTelSur[key]))
					{
						contadorTelSur = normalizacionTelSur.length;	
						if(valueFecha.agno == normalizacionTelSur[key]['agno'])
						{
							abonadosTelSurNormalizado.push(normalizacionTelSur[key]['valor'])
						}else{
							abonadosTelSurNormalizado.push(normalizacionTelSur[key]['valor'])
						}
					}
					else
					{
						abonadosTelSurNormalizado.push(0)
					}

					if(!angular.isUndefined(normalizacionOtros[key]))
					{
						contadorOtros = normalizacionOtros.length;	
						if(valueFecha.agno == normalizacionOtros[key]['agno'])
						{
							abonadosOtrosNormalizado.push(normalizacionOtros[key]['valor'])
						}else{
							abonadosOtrosNormalizado.push(normalizacionOtros[key]['valor'])
						}
					}
					else
					{
						abonadosOtrosNormalizado.push(0)
					}
				});

				if(contadorClaro <= 14)
				{
					var ar = abonadosClaroNormalizado;
					var p1 = ar.slice(0,contadorClaro);
					var p2 = ar.slice(contadorClaro);
					abonadosClaro = p2.concat(p1);
					//console.log(abonadosClaro);
					$scope.abonadosClaro = abonadosClaro;
				}


				if(contadorDirecTv <= 14)
				{
					var ar = abonadosDirecTvNormalizado;
					var p1 = ar.slice(0,contadorDirecTv);
					var p2 = ar.slice(contadorDirecTv);
					abonadosDirecTv = p2.concat(p1);
					$scope.abonadosDirecTv = abonadosDirecTv;
				}

				if(contadorMovistar <= 14)
				{
					var ar = abonadosMovistarNormalizado;
					var p1 = ar.slice(0,contadorMovistar);
					var p2 = ar.slice(contadorMovistar);
					abonadosMovistar = p2.concat(p1);
					$scope.abonadosMovistar = abonadosMovistar;	
					console.log(abonadosMovistar);	
				}

				if(contadorVtr <= 14)
				{
					var ar = abonadosVtrNormalizado;
					var p1 = ar.slice(0,contadorVtr);
					var p2 = ar.slice(contadorVtr);
					abonadosVtr = p2.concat(p1);
					$scope.abonadosVtr = abonadosVtr;
				}

				if(contadorEntel <= 14)
				{
					var ar = abonadosEntelNormalizado;
					var p1 = ar.slice(0,contadorEntel);
					var p2 = ar.slice(contadorEntel);
					abonadosEntel = p2.concat(p1);
					$scope.abonadosEntel = abonadosEntel;
				}

				if(contadorGtd <= 14)
				{
					var ar = abonadosGtdNormalizado;
					var p1 = ar.slice(0,contadorGtd);
					var p2 = ar.slice(contadorGtd);
					abonadosGtd = p2.concat(p1);
					$scope.abonadosGtd = abonadosGtd;
				}

				if(contadorTelSur <= 14)
				{
					var ar = abonadosTelSurNormalizado;
					var p1 = ar.slice(0,contadorTelSur);
					var p2 = ar.slice(contadorTelSur);
					abonadosTelSur = p2.concat(p1);
					$scope.abonadosTelSur = abonadosTelSur;
				}

				if(contadorOtros <= 14)
				{
					var ar = abonadosOtrosNormalizado;
					var p1 = ar.slice(0,contadorOtros);
					var p2 = ar.slice(contadorOtros);
					abonadosOtros = p2.concat(p1);
					$scope.abonadosOtros = abonadosOtros;
				}

				if(categorias.length != 0)
				{
					$scope.cabecera = categorias;	
					$scope.decimales = 0;
					$scope.tablaDetalle = true;
				}

				$scope.highchartsNG = {
			        options: {
			            chart: {
			                type: 'line',
			                zoomType: 'x'
			            }
			        },
			        yAxis: {
			            title: {
			                text: 'Valores'
			            }
			        },
			        xAxis: {
			            categories: categorias
			        },
			        series: [{
			                name : 'DirecTv',
			                data: abonadosDirecTv
			            },
			            {
			            	name : 'Movistar',
			            	data : abonadosMovistar
			            },
			            {
			            	name : 'Claro',
			            	data : abonadosClaro
			            },
			            {
			            	name : 'Vtr',
			            	data : abonadosVtr
			            },
			            {
			            	name : 'Entel',
			            	data : abonadosEntel
			            },
			            {
			            	name : 'Gtd',
			            	data : abonadosGtd
			            },
			            {
			            	name : 'telSur',
			            	data : abonadosTelSur
			            },
			            {
			            	name : 'Otros',
			            	data : abonadosOtros
			            }
			        ],
			        title: {
			            text: ''
			        },
			        loading: false
			    }
			});
	};



	$scope.segnal = function(segnal){

		if(fechaSeleccionada == '')
		{
			alert("Selecione un fecha antes de seleccionar un tipo de señal");
			return false;
		}

		if(segnal == 1)
			tipoGrafico = 'CDF Basico';
			

		if(segnal == 2)
			tipoGrafico = 'CDF Premium';

		if(segnal == 3)
			tipoGrafico = 'CDF HD';

		if(segnal == 4)
			tipoGrafico = 'penetracion';
			//console.log(tipoGrafico);


		if(segnal == '')
		{
			tipoGrafico = 'CDF Basico';
		}

		console.log(tipoGrafico);

			$scope.showTitulo = true;

			$scope.tituloGraficos = tipoGrafico;


			categorias.length = 0;
			operadores = "";
			abonadosDirecTV.length = 0;
			abonadosMovistar.length = 0;
			abonadosClaro.length = 0;
			abonadosVtr.length = 0;
			abonadosEntel.length = 0;
			abonadosGtd.length = 0;
			abonadosTelSur.length = 0;
			abonadosOtros.length = 0;

			fechasTotal.length = 0;
			
			normalizacionDirecTv.length = 0;
			normalizacionClaro.length = 0;
			normalizacionMovistar.length = 0;
			normalizacionGtd.length = 0;
			normalizacionVtr.length = 0;
			normalizacionEntel.length = 0;
			normalizacionTelSur.length = 0;
			normalizacionOtros.length = 0;

			abonadosDirecTvNormalizado.length = 0;
			abonadosClaroNormalizado.length = 0;
			abonadosMovistarNormalizado.length = 0;
			abonadosVtrNormalizado.length = 0;
			abonadosEntelNormalizado.length = 0;
			abonadosGtdNormalizado.length = 0;
			abonadosTelSurNormalizado.length = 0;
			abonadosOtrosNormalizado.length = 0;

			contadorDirecTv = '';
			contadorClaro = '';
			contadorMovistar = '';
			contadorVtr = '';
			contadorEntel = '';
			contadorGtd = '';
			contadorTelSur = '';
			contadorOtros = '';

			abonados.listaAbonados(fechaSeleccionada).success(function(data){
				//abonadosDirecTvNormalizado.length = 0;
				angular.forEach(data, function(valueAgno, agno){
					angular.forEach(valueAgno, function(valueMes, mes){

						fechasTotal.push({'agno': agno, 'mes': mes})

						if(mes == 1)
			                mes = "Ene.";
			            if(mes == 2)
			                mes = "Feb.";
			            if(mes == 3)
			                mes = "Mar.";
			            if(mes == 4)
			                mes = "Abr.";
			            if(mes == 5)
			                mes = "may.";
			            if(mes == 6)
			                mes = "Jun.";
			            if(mes == 7)
			                mes = "Jul.";
			            if(mes == 8)
			                mes = "Ago.";
			            if(mes == 9)
			                mes = "Sep.";
			            if(mes == 10)
			                mes = "Oct.";
			            if(mes == 11)
			                mes = "Nov.";
			            if(mes == 12)
			                mes = "Dic.";
						categorias.push(mes + '' +agno)

						angular.forEach(valueMes, function(valueOperador, operador){
							angular.forEach(valueOperador, function(valueAbonados, keyAbonados){
								if(segnal == 1 || segnal == 2 || segnal == 3)
								{
									if(operador === "DirecTV")
									//console.log(keyAbonados);
									if(keyAbonados == tipoGrafico)
										normalizacionDirecTv.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

									if(operador === "Movistar")
										if(keyAbonados == tipoGrafico)
											normalizacionMovistar.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})
											//console.log(valueAbonados.abonados);
											//abonadosMovistar.push(Number(valueAbonados[0].abonados));

									if(operador === "Claro Comunicaciones")
										if(keyAbonados == tipoGrafico)
											normalizacionClaro.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

									if(operador === "VTR")
										if(keyAbonados == tipoGrafico)
											normalizacionVtr.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

									if(operador === "Entel")
										if(keyAbonados == tipoGrafico)
											normalizacionEntel.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

									if(operador === "GTD")
										if(keyAbonados == tipoGrafico)
											normalizacionGtd.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

									if(operador === "Telsur")
										if(keyAbonados == tipoGrafico)
											normalizacionTelSur.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})

									if(operador === "otros")
										if(keyAbonados == tipoGrafico)
											normalizacionOtros.push({'agno': agno, 'mes' : mes, 'valor' : valueAbonados[0].abonados})
								}	
								
							});
							
							if(segnal == 4)
							{
								
								if(operador === "penetracion" || operador === "otrosPenetracion" && tipoGrafico == 'penetracion' )
									if(valueOperador['DirecTV'])
										normalizacionDirecTv.push({'agno': agno, 'mes' : mes, 'valor' : valueOperador['DirecTV']['abonados']})

									if(valueOperador['Movistar'])
										normalizacionMovistar.push({'agno': agno, 'mes' : mes, 'valor' : valueOperador['Movistar']['abonados']})

									if(valueOperador['Claro Comunicaciones'])
										normalizacionClaro.push({'agno': agno, 'mes' : mes, 'valor' : valueOperador['Claro Comunicaciones']['abonados']})
									
									if(valueOperador['VTR'])
										normalizacionVtr.push({'agno': agno, 'mes' : mes, 'valor' : valueOperador['VTR']['abonados']})

									if(valueOperador['Entel'])
										normalizacionEntel.push({'agno': agno, 'mes' : mes, 'valor' : valueOperador['Entel']['abonados']})

									if(valueOperador['GTD'])
										normalizacionGtd.push({'agno': agno, 'mes' : mes, 'valor' : valueOperador['GTD']['abonados']})

									if(valueOperador['Telsur'])
										normalizacionTelSur.push({'agno': agno, 'mes' : mes, 'valor' : valueOperador['Telsur']['abonados']})

									if(valueOperador['otrosPenetracion'])
										normalizacionOtros.push({'agno': agno, 'mes' : mes, 'valor' : valueOperador['otrosPenetracion']['abonados']})
							}
							
							
						});
					});
				});

				 
				angular.forEach(fechasTotal, function(valueFecha, key){
					if(!angular.isUndefined(normalizacionClaro[key]))
					{
						contadorClaro = normalizacionClaro.length;	
						if(valueFecha.agno == normalizacionClaro[key]['agno'])
						{
							abonadosClaroNormalizado.push(Number(normalizacionClaro[key]['valor']))
						}else{
							abonadosClaroNormalizado.push(Number(normalizacionClaro[key]['valor']))
						}
					}
					else
					{
						abonadosClaroNormalizado.push(0)
					}

					if(!angular.isUndefined(normalizacionDirecTv[key]))
					{
						contadorDirecTv = normalizacionDirecTv.length;	
						if(valueFecha.agno == normalizacionDirecTv[key]['agno'])
						{
							abonadosDirecTvNormalizado.push(Number(normalizacionDirecTv[key]['valor']))
						}else{
							abonadosDirecTvNormalizado.push(Number(normalizacionDirecTv[key]['valor']))
						}
					}
					else
					{
						abonadosDirecTvNormalizado.push(0)
					}


					

					if(!angular.isUndefined(normalizacionMovistar[key]))
					{
						contadorMovistar = normalizacionMovistar.length;	
						if(valueFecha.agno == normalizacionMovistar[key]['agno'])
						{
							abonadosMovistarNormalizado.push(Number(normalizacionMovistar[key]['valor']))
						}else{
							abonadosMovistarNormalizado.push(Number(normalizacionMovistar[key]['valor']))
						}
					}
					else
					{
						abonadosMovistarNormalizado.push(0)
					}

					//console.log(abonadosMovistarNormalizado);

					if(!angular.isUndefined(normalizacionVtr[key]))
					{
						contadorVtr = normalizacionVtr.length;	
						if(valueFecha.agno == normalizacionVtr[key]['agno'])
						{
							abonadosVtrNormalizado.push(Number(normalizacionVtr[key]['valor']))
						}else{
							abonadosVtrNormalizado.push(Number(normalizacionVtr[key]['valor']))
						}
					}
					else
					{
						abonadosVtrNormalizado.push(0)
					}


					if(!angular.isUndefined(normalizacionEntel[key]))
					{
						contadorEntel = normalizacionEntel.length;	
						if(valueFecha.agno == normalizacionEntel[key]['agno'])
						{
							abonadosEntelNormalizado.push(Number(normalizacionEntel[key]['valor']))
						}else{
							abonadosEntelNormalizado.push(Number(normalizacionEntel[key]['valor']))
						}
					}
					else
					{
						abonadosEntelNormalizado.push(0)
					}

					if(!angular.isUndefined(normalizacionGtd[key]))
					{
						contadorGtd = normalizacionGtd.length;	
						if(valueFecha.agno == normalizacionGtd[key]['agno'])
						{
							abonadosGtdNormalizado.push(Number(normalizacionGtd[key]['valor']))
						}else{
							abonadosGtdNormalizado.push(Number(normalizacionGtd[key]['valor']))
						}
					}
					else
					{
						abonadosGtdNormalizado.push(0)
					}

					if(!angular.isUndefined(normalizacionTelSur[key]))
					{
						contadorTelSur = normalizacionTelSur.length;	
						if(valueFecha.agno == normalizacionTelSur[key]['agno'])
						{
							abonadosTelSurNormalizado.push(Number(normalizacionTelSur[key]['valor']))
						}else{
							abonadosTelSurNormalizado.push(Number(normalizacionTelSur[key]['valor']))
						}
					}
					else
					{
						abonadosTelSurNormalizado.push(0)
					}

					if(!angular.isUndefined(normalizacionOtros[key]))
					{
						contadorOtros = normalizacionOtros.length;	
						if(valueFecha.agno == normalizacionOtros[key]['agno'])
						{
							abonadosOtrosNormalizado.push(Number(normalizacionOtros[key]['valor']))
						}else{
							abonadosOtrosNormalizado.push(Number(normalizacionOtros[key]['valor']))
						}
					}
					else
					{
						abonadosOtrosNormalizado.push(0)
					}
				});


				if(contadorClaro <= 14)
				{
					var ar = abonadosClaroNormalizado;
					var p1 = ar.slice(0,contadorClaro);
					var p2 = ar.slice(contadorClaro);
					abonadosClaro = p2.concat(p1);
					$scope.abonadosClaro = abonadosClaro;
				}


				if(contadorDirecTv <= 14)
				{

					var ar = abonadosDirecTvNormalizado;
					var p1 = ar.slice(0,contadorDirecTv);
					var p2 = ar.slice(contadorDirecTv);
					abonadosDirecTv = p2.concat(p1);
					$scope.abonadosDirecTv = abonadosDirecTv;
					
				}

				if(contadorMovistar <= 14)
				{
					console.log(abonadosMovistarNormalizado);

					var ar = abonadosMovistarNormalizado;
					var p1 = ar.slice(0,contadorMovistar);
					var p2 = ar.slice(contadorMovistar);
					abonadosMovistar = p2.concat(p1);
					$scope.abonadosMovistar = abonadosMovistar;	
				}

				if(contadorVtr <= 14)
				{
					var ar = abonadosVtrNormalizado;
					var p1 = ar.slice(0,contadorVtr);
					var p2 = ar.slice(contadorVtr);
					abonadosVtr = p2.concat(p1);
					$scope.abonadosVtr = abonadosVtr;	
				}

				if(contadorEntel <= 14)
				{
					var ar = abonadosEntelNormalizado;
					var p1 = ar.slice(0,contadorEntel);
					var p2 = ar.slice(contadorEntel);
					abonadosEntel = p2.concat(p1);
					$scope.abonadosEntel = abonadosEntel;	
				}

				if(contadorGtd <= 14)
				{
					var ar = abonadosGtdNormalizado;
					var p1 = ar.slice(0,contadorGtd);
					var p2 = ar.slice(contadorGtd);
					abonadosGtd = p2.concat(p1);
					$scope.abonadosGtd = abonadosGtd;	
				}

				if(contadorTelSur <= 14)
				{
					var ar = abonadosTelSurNormalizado;
					var p1 = ar.slice(0,contadorTelSur);
					var p2 = ar.slice(contadorTelSur);
					abonadosTelSur = p2.concat(p1);
					$scope.abonadosTelSur = abonadosTelSur;	
				}

				if(contadorOtros <= 14)
				{
					var ar = abonadosOtrosNormalizado;
					var p1 = ar.slice(0,contadorOtros);
					var p2 = ar.slice(contadorOtros);
					abonadosOtros = p2.concat(p1);
					$scope.abonadosOtros = abonadosOtros;	
				}

				if(categorias.length != 0)
				{
					$scope.cabecera = categorias;
					if(tipoGrafico === 1)
						$scope.decimales = 0;
					else
						$scope.decimales = 2;
					$scope.tablaDetalle = true;
				}

				$scope.highchartsNG = {
			        options: {
			            chart: {
			                type: 'line',
			                zoomType: 'x'
			            }
			        },
			        yAxis: {
			            title: {
			                text: 'Valores'
			            }
			        },
			        xAxis: {
			            categories: categorias
			        },
			        series: [{
			                name : 'DirecTv',
			                data: abonadosDirecTv
			            },
			            {
			            	name : 'Movistar',
			            	data : abonadosMovistar
			            },
			            {
			            	name : 'Claro',
			            	data : abonadosClaro
			            },
			            {
			            	name : 'Vtr',
			            	data : abonadosVtr
			            },
			            {
			            	name : 'Entel',
			            	data : abonadosEntel
			            },
			            {
			            	name : 'Gtd',
			            	data : abonadosGtd
			            },
			            {
			            	name : 'telSur',
			            	data : abonadosTelSur
			            },
			            {
			            	name : 'Otros',
			            	data : abonadosOtros
			            }
			        ],
			        title: {
			            text: ''
			        },
			        loading: false
			    }
			});

	}

});