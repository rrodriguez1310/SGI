app.controller("mainRatingMinutos", ["$scope", "$http", function ($scope, $http, $filter){

	
}]);

app.controller("semanal", ["$scope", "$filter", "ratingMinutosFactory", function ($scope, $filter, ratingMinutosFactory){
	$scope.$watch("fecha", function(nuevaFecha, antiguaFecha){
		if(angular.isDefined(nuevaFecha)){
			var fechaArray = nuevaFecha.split("/");
			ratingMinutosFactory.ratingMinutosSemanal(fechaArray[2]+"-"+fechaArray[1]+"-"+fechaArray[0]).
			then(function(data){
				console.log(data);
			});
		}
	});
}]);

app.controller('informe_minutos', ['$scope', '$filter', '$q','ratingMinutosService', "ratingMinutosFactory", "Flash", function ($scope, $filter, $q, ratingMinutosService, ratingMinutosFactory, Flash) {
	$scope.buscar_minutos = function(){
		if(angular.isDefined($scope.fecha) && angular.isDefined($scope.horaInicio)){
			$scope.loader = true;
			$scope.cargador = loader;
			$scope.detalleMinutos = false;
			$scope.alerta = false;
			var fecha = $scope.fecha.split("/");
			var hora = $scope.horaInicio.split(":");
			var final = new Date(fecha[2], fecha[1]-1,fecha[0], hora[0], hora[1]);
			var inicio = new Date(final);
			final.setHours((final.getHours()+4));
			var minutos = ratingMinutosService.minutos_rango_minutos(inicio.getFullYear()+"-"+(inicio.getMonth()+1)+"-"+inicio.getDate()+" "+inicio.getHours()+":"+inicio.getMinutes()+":00", final.getFullYear()+"-"+(final.getMonth()+1)+"-"+final.getDate()+" "+final.getHours()+":"+final.getMinutes()+":00");
			minutos.success(function (datos){

				if(datos!=0){
					
                    data = ratingMinutosFactory.minutos(datos);
                    
                    console.log("esta es la data --->" + data);
                    
					$scope.detalleMinutos = true;
					$scope.minutos = data;
					$scope.chartConfig.series = [];
					var inicioArray = new Array();
					var cdfbRating = new Array();
					var cdfpRating = new Array();
					var cdfhdRating = new Array();
					var espnRating = new Array();
					var espnmRating = new Array();
					var espn2Rating = new Array();
					var espn3Rating = new Array();
					var espnhdRating = new Array();
					var fsRating = new Array();
					var fspRating = new Array();
					var fs2Rating = new Array();
					var fs3Rating = new Array();
					
					angular.forEach(data, function(value, key){
						inicioArray.push(key);
                        console.log("hola");
                        console.log(value.cddatafb);
                        cdfbRating.push(parseFloat(typeof value.cddatafb !== 'undefined' ? value.cddatafb : 0));
						//cdfbRating.push(parseFloat(typeof value.cdfb !== 'undefined' ? value.cdfb : 0));
						cdfpRating.push(parseFloat(typeof value.cdfp !== 'undefined' ? value.cdfp : 0));
						cdfhdRating.push(parseFloat(typeof value.cdfhd !== 'undefined' ? value.cdfhd : 0));
						espnRating.push(parseFloat(typeof value.espn !== 'undefined' ? value.espn : 0));
						espnmRating.push(parseFloat(typeof value.espnm !== 'undefined' ? value.espnm : 0));
						espn2Rating.push(parseFloat(typeof value.espn2 !== 'undefined' ? value.espn2 : 0));
						espn3Rating.push(parseFloat(typeof value.espn3 !== 'undefined' ? value.espn3 : 0));
						espnhdRating.push(parseFloat(typeof value.espnhd !== 'undefined' ? value.espnhd : 0));
						fsRating.push(parseFloat(typeof value.fs !== 'undefined' ? value.fs : 0));
						fspRating.push(parseFloat(typeof value.fsp !== 'undefined' ? value.fsp : 0));
						fs2Rating.push(parseFloat(typeof value.fs2 !== 'undefined' ? value.fs2 : 0));
						fs3Rating.push(parseFloat(typeof value.fs3 !== 'undefined' ? value.fs3 : 0));
					});
                    
                    console.log(cdfbRating);
		
					var inicioFecha = inicioArray[0].substring(0,10);
					var inicioHoras = inicioArray[0].substring(11,19);
					var inicioFechaArray = inicioFecha.split("-");
					var inicioHorasArray = inicioHoras.split(":");
					var fechaObjFinal = new Date(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]);
					var fechaObjInicio = new Date(fechaObjFinal);
					fechaObjFinal.setHours((fechaObjInicio.getHours()+4));
					var fechaInicio = $filter('date')(fechaObjInicio, "dd/MM/yyyy HH:mm");
					var fechaFinal = $filter('date')(fechaObjFinal, "dd/MM/yyyy HH:mm");
					$scope.chartConfig.title.text  = "Rating entre "+fechaInicio+" y "+fechaFinal;
					
                    $scope.chartConfig.series.push({
						color: "#6D6E70",
						name: "CDFB",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: cdfbRating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});
                    
					$scope.chartConfig.series.push({
						color: '#B91E23',
						name: "CDFP",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: cdfpRating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});
					$scope.chartConfig.series.push({
						color: "#282828",
						name: "CDFHD",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: cdfhdRating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});
					$scope.chartConfig.series.push({
						name: "ESPN",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: espnRating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});
					$scope.chartConfig.series.push({
						name: "ESPN+",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: espnmRating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});
					
					$scope.chartConfig.series.push({
						name: "ESPN2",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: espn2Rating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});

					$scope.chartConfig.series.push({
						name: "ESPN3",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: espn3Rating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});
					$scope.chartConfig.series.push({
						name: "ESPNHD",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: espnhdRating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});
					$scope.chartConfig.series.push({
						name: "FS",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: fsRating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});
					$scope.chartConfig.series.push({
						name: "FSP",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: fspRating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});
					$scope.chartConfig.series.push({
						name: "FS2",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: fs2Rating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});
					$scope.chartConfig.series.push({
						name: "FS3",
						type: "line",
						pointStart: Date.UTC(inicioFechaArray[0],(inicioFechaArray[1]-1),inicioFechaArray[2], inicioHorasArray[0], inicioHorasArray[1]),
						data: fs3Rating,
						pointInterval: (24 * 3600 * 1000/24/60)
					});
					$scope.loader = false;					

				}else{
					$scope.loader = false;
					var message = 'No se encontro información para la busqueda';
					Flash.create('danger', message, 'customAlert');
					
				}
			});

		}else{
			alert("Debe especificar la fecha y hora a buscar");
		}
	};

	$scope.chartTypes = [
	{"id": "line", "title": "Line"},
	{"id": "spline", "title": "Smooth line"},
	{"id": "area", "title": "Area"},
	{"id": "areaspline", "title": "Smooth area"},
	{"id": "column", "title": "Column"},
	{"id": "bar", "title": "Bar"},
	{"id": "pie", "title": "Pie"},
	{"id": "scatter", "title": "Scatter"}
	];

	$scope.dashStyles = [
	{"id": "Solid", "title": "Solid"},
	{"id": "ShortDash", "title": "ShortDash"},
	{"id": "ShortDot", "title": "ShortDot"},
	{"id": "ShortDashDot", "title": "ShortDashDot"},
	{"id": "ShortDashDotDot", "title": "ShortDashDotDot"},
	{"id": "Dot", "title": "Dot"},
	{"id": "Dash", "title": "Dash"},
	{"id": "LongDash", "title": "LongDash"},
	{"id": "DashDot", "title": "DashDot"},
	{"id": "LongDashDot", "title": "LongDashDot"},
	{"id": "LongDashDotDot", "title": "LongDashDotDot"}
	];

	$scope.chartSeries = [];

	$scope.chartStack = [
	{"id": '', "title": "No"},
	{"id": "normal", "title": "Normal"},
	{"id": "percent", "title": "Percent"}
	];

	$scope.chartConfig = {
		options: {
			chart: {
				zoomType: 'x'
			},
			subtitle: {
				text: false,
				align: 'right',
				verticalAlign: 'bottom',
				y: 15
			},
			xAxis: {
				type: 'datetime',
				minRange: (12 * 24 * 3600 * 1000/24/60)
			},
			yAxis: {
				title: {
					text: 'Rating % Hogares con cable'
				}
			},
			plotOptions: {
				plotOptions: {
					area: {
						fillColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
							stops: [
							[0, Highcharts.getOptions().colors[0]],
							[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							]
						},
						marker: {
							radius: 2
						},
						lineWidth: 1,
						states: {
							hover: {
								lineWidth: 1
							}
						},
						threshold: null
					}
				},
			},
		},
		series: $scope.chartSeries,
		title: {
			text: ''
		},
		credits: {
			enabled: false
		},
		loading: false,
		size: {

		}
	}
}]);

app.controller("bandas", ["$scope", "$filter","$q", "ratingMinutosService", "ratingMinutosFactory", "servicios", "Flash", function ($scope, $filter, $q, ratingMinutosService, ratingMinutosFactory, servicios, Flash){
	
	$scope.buscar_bandas = function (){
		$scope.buscando = true;
		for (var i = 0; i < 6; i++) {
			$scope["navs"+i] = false;
		};

		$scope.canalesOrder = [1,2,3,10,12,16,13,11,6,7,8,9,15,14];
		if(angular.isDefined($scope.fecha)){
			$scope.sinData = false;
			$scope.tablas = false;
			$scope.loader = true;
			$scope.cargador = loader;
			var fechaArray = $scope.fecha.split("/");
			fecha = new Date(fechaArray[2],(parseInt(fechaArray[1])-1), parseInt(fechaArray[0]));
			e = new Date(fecha);
			e.setDate(e.getDate()+4-(e.getDay()||7));
			$scope.semanaCalendario0 = Math.ceil((((e-new Date(e.getFullYear(),0,1))/8.64e7)+1)/7);
			$scope.semanaCalendario2 = $scope.semanaCalendario0;
			$scope.fechaSemana0 = new Date(fecha);
			var dia = 6;
			if(fecha.getDay()!=0){
				dia = fecha.getDay()-1;
			}
			$scope.fechaSemana0.setDate((fecha.getDate()-dia));
			$scope.fechaSemana0.setHours(6);
			$scope.semanaFinal0 = new Date($scope.fechaSemana0.getTime() + (7 * 24 * 3600 * 1000));
			$scope.semanaFinal0.setHours(5);
			$scope.semanaFinal0.setMinutes(59);
			$scope.semanaFinal0.setSeconds(59);
			$scope.fechaSemana1 = new Date($scope.fechaSemana0.getTime() - (7 * 24 * 3600 * 1000));
			ee = new Date($scope.fechaSemana1);
			ee.setDate(ee.getDate()+4-(ee.getDay()||7));
			$scope.semanaCalendario1 = Math.ceil((((ee-new Date(ee.getFullYear(),0,1))/8.64e7)+1)/7);
			$scope.semanaFinal1 = new Date($scope.fechaSemana1.getTime() + (7 * 24 * 3600 * 1000));
			$scope.semanaFinal1.setHours(5);
			$scope.semanaFinal1.setMinutes(59);
			$scope.semanaFinal1.setSeconds(59);
			$scope.fechaSemana2 = new Date($scope.fechaSemana0);
			$scope.fechaSemana2.setFullYear($scope.fechaSemana0.getFullYear()-1);
			eee = new Date($scope.fechaSemana2);
			eee.setDate(eee.getDate()+4-(eee.getDay()||7));
			var semanaAnioAnterior = Math.ceil((((eee-new Date(eee.getFullYear(),0,1))/8.64e7)+1)/7);
			if($scope.semanaCalendario0 > semanaAnioAnterior || ($scope.semanaCalendario0==1 && semanaAnioAnterior==52)){
				$scope.fechaSemana2 = new Date($scope.fechaSemana2.getTime() + (7 * 24 * 3600 * 1000));
			}
			if($scope.semanaCalendario0 < semanaAnioAnterior && !($scope.semanaCalendario0==1 && semanaAnioAnterior==52)){
				$scope.fechaSemana2 = new Date($scope.fechaSemana2.getTime() - (7 * 24 * 3600 * 1000));
			}
			var diaAnoAnterior = 6;
			if($scope.fechaSemana2.getDay()!=0){
				diaAnoAnterior = $scope.fechaSemana2.getDay()-1;
			}
			$scope.fechaSemana2.setDate(($scope.fechaSemana2.getDate()-diaAnoAnterior));
			$scope.semanaFinal2 = new Date($scope.fechaSemana2.getTime() + (7 * 24 * 3600 * 1000));
			$scope.semanaFinal2.setHours(5);
			$scope.semanaFinal2.setMinutes(59);
			$scope.semanaFinal2.setSeconds(59);

			fechas = {
				"semanaInicio": {
					"inicio": $scope.fechaSemana0.getFullYear()+"-"+("0"+($scope.fechaSemana0.getMonth()+1)).slice(-2)+"-"+("0"+$scope.fechaSemana0.getDate()).slice(-2)+" "+("0"+$scope.fechaSemana0.getHours()).slice(-2)+":00:00",
					"final": $scope.semanaFinal0.getFullYear()+"-"+("0"+($scope.semanaFinal0.getMonth()+1)).slice(-2)+"-"+("0"+$scope.semanaFinal0.getDate()).slice(-2)+" "+("0"+$scope.semanaFinal0.getHours()).slice(-2)+":59:59",
					"identificador" : 0
				},
				"semanaAnterior": {
					"inicio": $scope.fechaSemana1.getFullYear()+"-"+("0"+($scope.fechaSemana1.getMonth()+1)).slice(-2)+"-"+("0"+$scope.fechaSemana1.getDate()).slice(-2)+" "+("0"+$scope.fechaSemana1.getHours()).slice(-2)+":00:00",
					"final": $scope.semanaFinal1.getFullYear()+"-"+("0"+($scope.semanaFinal1.getMonth()+1)).slice(-2)+"-"+("0"+$scope.semanaFinal1.getDate()).slice(-2)+" "+("0"+$scope.semanaFinal1.getHours()).slice(-2)+":59:59",
					"identificador" : 1
				},
				"anioAnterior":	{
					"inicio": $scope.fechaSemana2.getFullYear()+"-"+("0"+($scope.fechaSemana2.getMonth()+1)).slice(-2)+"-"+("0"+$scope.fechaSemana2.getDate()).slice(-2)+" "+("0"+$scope.fechaSemana2.getHours()).slice(-2)+":00:00",
					"final": $scope.semanaFinal2.getFullYear()+"-"+("0"+($scope.semanaFinal2.getMonth()+1)).slice(-2)+"-"+("0"+$scope.semanaFinal2.getDate()).slice(-2)+" "+("0"+$scope.semanaFinal2.getHours()).slice(-2)+":59:59",
					"identificador" : 2
				}
			};
			var promises = [];
			angular.forEach(fechas , function(fecha) {
				var promise = ratingMinutosFactory.semanasInformeBandas(fecha);
				promises.push(promise);
			});
			promises.push(ratingMinutosService.acumulados(fecha.getFullYear()+"-"+("0"+(fecha.getMonth()+1)).slice(-2)+"-"+("0"+fecha.getDate()).slice(-2)));
			promises.push(ratingMinutosService.acumulados((fecha.getFullYear()-1)+"-"+("0"+(fecha.getMonth()+1)).slice(-2)+"-"+("0"+fecha.getDate()).slice(-2)));
			promises.push(ratingMinutosService.graficosBandas(fecha.getFullYear()+"-"+("0"+(fecha.getMonth()+1)).slice(-2)+"-"+("0"+fecha.getDate()).slice(-2)));
			promises.push(ratingMinutosService.acumuladosSemanas(fecha.getFullYear()+"-"+("0"+(fecha.getMonth()+1)).slice(-2)+"-"+("0"+fecha.getDate()).slice(-2)));
			$scope.semanaFinal0.setDate($scope.semanaFinal0.getDate()-1);
			$scope.semanaFinal1.setDate($scope.semanaFinal1.getDate()-1);
			$scope.semanaFinal2.setDate($scope.semanaFinal2.getDate()-1);
			$q.all(promises).then(function (resultados){
				$scope.buscando = false;
				$scope.dataSemana = resultados;
				$scope.loader = false;
				$scope.diaSemana(0,0);
				$scope.navs0 = true;
				angular.element(".bandas").find("li").removeClass("active");
				angular.element("#acumuladoRating").addClass("active");
				$scope.nav(0);
				$scope.diaSemana(1,0);
				$scope.diaSemana(2,0);
				$scope.vsDia(1,3,0);
				$scope.vsDia(2,4,0);
				$scope.channels = $scope.dataSemana[3].data.canales;
				$scope.maxDiaData = $scope.dataSemana[3].data.fechaFinal;
				$scope.anioAcumulado =  ratingMinutosFactory.acumuladosAgrupados($scope.dataSemana[3].data.ytd, $scope.channels);
				$scope.anioAnteriorAcumulado = ratingMinutosFactory.acumuladosAgrupados($scope.dataSemana[4].data.ytd, $scope.channels);
				$scope.mesAcumulado =  ratingMinutosFactory.acumuladosAgrupados($scope.dataSemana[3].data.mtd, $scope.channels);
				$scope.mesAnteriorAcumulado = ratingMinutosFactory.acumuladosAgrupados($scope.dataSemana[4].data.mtd, $scope.channels);
				$scope.semanaAcumulada = ratingMinutosFactory.acumuladosAgrupadosSemana($scope.dataSemana[6].data[0], $scope.channels);
				$scope.semanaAnteriorAcumulada = ratingMinutosFactory.acumuladosAgrupadosSemana($scope.dataSemana[6].data[1], $scope.channels);
				graficos = ratingMinutosFactory.acumuladosGraficos($scope.dataSemana[5].data, $scope.channels);
				$scope.chartRatingSeries = [];
				$scope.chartRatingSeries2 = [];
				$scope.chartShareSeries = [];
				$scope.chartShareSeries2 = [];				


				// ****************** GRAFICOS RATING ********************
				$scope.chartRating = {
					options: {
						chart: {
							renderTo : "chart1",
							zoomType: 'x',
						},
						subtitle: {
							text: false,
							align: 'right',
							verticalAlign: 'bottom',
							y: 15
						},
						xAxis: {
							categories : graficos.categorias
						},
						yAxis: {
							title: {
								text: 'Rating % Hogares con cable'
							},
							min : 0
						},
						plotOptions: {
							column : {
								dataLabels: {
									enabled: false
								},
							},
							line : {
								dataLabels: {
									enabled: true
								},
							},
						},
						labels : {
							items : [{
								html : 'Click y desliza para zoom',
								style: {
									left: '10px',
									top: '10px'
								}
							}]
						}
					},
					series: $scope.chartRatingSeries,
					title: {
						text: 'Evolución Rating por cadena televisiva'
					},
					credits: {
						enabled : true,
						href : "http://sgi.cdf.cl",
						text: "CDF"
					},
					loading: false,
				}

				$scope.chartRating2 = {
					options: {
						chart: {
							renderTo : "chart1",
							zoomType: 'x'
						},
						subtitle: {
							text: false,
							align: 'right',
							verticalAlign: 'bottom',
							y: 15
						},
						xAxis: {
							categories : graficos.categorias
						},
						yAxis: {
							title: {
								text: 'Rating % Hogares con cable'
							},
							min : 0
						},
						plotOptions: {
							column : {
								dataLabels: {
									enabled: false
								},
							},
							line : {
								dataLabels: {
									enabled: true
								},
							},
						},
						labels : {
							items : [{
								html : 'Click y desliza para zoom',
								style: {
									left: '10px',
									top: '10px'
								}
							}]
						}
					},
					series: $scope.chartRatingSeries2,
					title: {
						text: 'Evolución Rating por señales deportivas'
					},
					credits: {
						enabled : true,
						href : "http://sgi.cdf.cl",
						text: "CDF"
					},
					loading: false,
				}

				// series rating agrupados 
				$scope.chartRating.series.push({
					color : "#000000",
					name: "CDF's",
					type: "line",
					data: graficos.agrupados[1].rating,
				});
				$scope.chartRating.series.push({
					color : "#0000FF",
					name: "Fox's",
					type: "line",
					data: graficos.agrupados[2].rating,
				});
				$scope.chartRating.series.push({
					color : " #FF0000",
					name: "ESPN's",
					type: "line",
					data: graficos.agrupados[3].rating,
				});
				$scope.chartRating.series.push({
					color : "#FFA500",
					name: "TVR DEP",
					type: "line",
					data: graficos.agrupados[1].tvr,
				});

				// series rating no agrupados
				$scope.chartRating2.series.push({
					color: "#808080",
					name: "CDF",
					type: "line",
					data: graficos.noagrupados[1].rating,
				});
				$scope.chartRating2.series.push({
					color: "#000000",
					name: "CDFP",
					type: "line",
					data: graficos.noagrupados[2].rating,
				});
				$scope.chartRating2.series.push({
					name: "CDFHD",
					type: "line",
					data: graficos.noagrupados[3].rating,
				});
				$scope.chartRating2.series.push({
					color: "#FF0000",
					name: "ESPN",
					type: "line",
					data: graficos.noagrupados[10].rating,
				});
				$scope.chartRating2.series.push({
					color: "#FFC0CB",
					name: "ESPN+",
					type: "line",
					data: graficos.noagrupados[12].rating,
				});

				if (typeof graficos.noagrupados[16] == 'undefined') {
					graficos.noagrupados[16] = {rating: "0.000", tvr: "0.000"};
				}
					
				$scope.chartRating2.series.push({
					color: "#2980B9",
					name: "ESPN2",
					type: "line",
					data: graficos.noagrupados[16].rating,
				});			
				
				$scope.chartRating2.series.push({
					name: "ESPN3",
					type: "line",
					data: graficos.noagrupados[13].rating,
				});

				$scope.chartRating2.series.push({
					name: "ESPNHD",
					type: "line",
					data: graficos.noagrupados[11].rating,
				});

				$scope.chartRating2.series.push({
					color : "#0000FF",
					name: "FS",
					type: "line",
					data: graficos.noagrupados[6].rating,
				});
				$scope.chartRating2.series.push({
					name: "FS2",
					type: "line",
					data: graficos.noagrupados[7].rating,
				});
		
				$scope.chartRating2.series.push({
					name: "FS3",
					type: "line",
					data: graficos.noagrupados[8].rating,
				});

				$scope.chartRating2.series.push({
					color: "#87CEEB",
					name: "FSP",
					type: "line",
					data: graficos.noagrupados[9].rating,
				});

				$scope.chartRating2.series.push({
					color : "#FFA500",
					name: "TVR",
					type: "line",
					data: graficos.noagrupados[1].tvr,
				});

				// ************************** GRAFICOS SHARE ***********************

				$scope.chartShare = {
					options: {
						chart: {
							renderTo : "chart1",
							zoomType: 'x',
						},
						subtitle: {
							text: false,
							align: 'right',
							verticalAlign: 'bottom',
							y: 15
						},
						xAxis: {
							categories : graficos.categorias
						},
						yAxis: {
							title: {
								text: 'Share % Hogares con cable'
							},
							min : 0
						},
						plotOptions: {
							column : {
								dataLabels: {
									enabled: false
								},
							},
							line : {
								dataLabels: {
									enabled: true,
									format: "{y} %"
								},
							},
						},
						labels : {
							items : [{
								html : 'Click y desliza para zoom',
								style: {
									left: '10px',
									top: '10px'
								}
							}]
						}
					},
					series: $scope.chartShareSeries,
					title: {
						text: 'Evolución Share por cadena televisiva'
					},
					credits: {
						enabled : true,
						href : "http://sgi.cdf.cl",
						text: "CDF"
					},
					loading: false,
				}

				$scope.chartShare2 = {
					options: {
						chart: {
							renderTo : "chart1",
							zoomType: 'x'
						},
						subtitle: {
							text: false,
							align: 'right',
							verticalAlign: 'bottom',
							y: 15
						},
						xAxis: {
							categories : graficos.categorias
						},
						yAxis: {
							title: {
								text: 'Share % Hogares con cable'
							},
							min : 0
						},
						plotOptions: {
							column : {
								dataLabels: {
									enabled: false
								},
							},
							line : {
								dataLabels: {
									enabled: true,
									format: "{y} %"
								},
							},
						},
						labels : {
							items : [{
								html : 'Click y desliza para zoom',
								style: {
									left: '10px',
									top: '10px'
								}
							}]
						}
					},
					series: $scope.chartShareSeries2,
					title: {
						text: 'Evolución Share por señales deportivas'
					},
					credits: {
						enabled : true,
						href : "http://sgi.cdf.cl",
						text: "CDF"
					},
					loading: false,
				}

				// series share agrupados 
				$scope.chartShare.series.push({
					color : "#000000",
					name: "CDF's",
					type: "line",
					data: graficos.agrupados[1].share,
				});
				$scope.chartShare.series.push({
					color : "#0000FF",
					name: "Fox's",
					type: "line",
					data: graficos.agrupados[2].share,
				});
				$scope.chartShare.series.push({
					color : " #FF0000",
					name: "ESPN's",
					type: "line",
					data: graficos.agrupados[3].share,
				});

				// series rating no agrupados
				$scope.chartShare2.series.push({
					color: "#808080",
					name: "CDF",
					type: "line",
					data: graficos.noagrupados[1].share,
				});
				$scope.chartShare2.series.push({
					color: "#000000",
					name: "CDFP",
					type: "line",
					data: graficos.noagrupados[2].share,
				});
				$scope.chartShare2.series.push({
					name: "CDFHD",
					type: "line",
					data: graficos.noagrupados[3].share,
				});
				$scope.chartShare2.series.push({
					color: "#FF0000",
					name: "ESPN",
					type: "line",
					data: graficos.noagrupados[10].share,
				});
				$scope.chartShare2.series.push({
					color: "#FFC0CB",
					name: "ESPN+",
					type: "line",
					data: graficos.noagrupados[12].share,
				});

				if (typeof graficos.noagrupados[16] == 'undefined'){
					graficos.noagrupados[16] = { share : "0.000" };
				}
				$scope.chartShare2.series.push({
					color: "#2980B9",
					name: "ESPN2",
					type: "line",
					data: graficos.noagrupados[16].share,
				});
						
		
				$scope.chartShare2.series.push({
					name: "ESPN3",
					type: "line",
					data: graficos.noagrupados[13].share,
				});

				$scope.chartShare2.series.push({
					name: "ESPNHD",
					type: "line",
					data: graficos.noagrupados[11].share,
				});

				$scope.chartShare2.series.push({
					color : "#0000FF",
					name: "FS",
					type: "line",
					data: graficos.noagrupados[6].share,
				});
				$scope.chartShare2.series.push({
					name: "FS2",
					type: "line",
					data: graficos.noagrupados[7].share,
				});
		
				$scope.chartShare2.series.push({
					name: "FS3",
					type: "line",
					data: graficos.noagrupados[8].share,
				});

				$scope.chartShare2.series.push({
					color: "#87CEEB",
					name: "FSP",
					type: "line",
					data: graficos.noagrupados[9].share,
				});

				if($scope.dataSemana[0] == 0 && $scope.dataSemana[1] == 0 && $scope.dataSemana[2] == 0){
					var message = 'No se encontro información para la busqueda';
					Flash.create('danger', message, 'customAlert');
					$scope.tablas = false;
				}else{
					$scope.tablas = true;
				}
			});
		}else{
			alert("Debe seleccionar una fecha");
		}
	};

	$scope.semana = function(solicitado){
		angular.element(".botonera"+solicitado).find(".btn").removeClass("active");
		angular.element(".botonera"+solicitado).find(".semana"+solicitado).addClass("active");
		$scope["semana1"+solicitado] = "";
		$scope["semana1"+solicitado] = {};
		if($scope.dataSemana[solicitado]!=0){
			resultado = ratingMinutosFactory.semana($scope.dataSemana[solicitado], solicitado);
			if(Object.keys($scope.dataSemana[solicitado]).length == 168){
				$scope["semana1"+solicitado] = resultado["semana1"+solicitado];
				$scope["semana2"+solicitado] = resultado["semana2"+solicitado];
				$scope["tabs"+solicitado] = true;
				$scope["tablaSemana"+solicitado] = true;
				$scope["errorTablaSemana"+solicitado] = false;
			}else{
				$scope["tabs"+solicitado] = true;
				$scope["tablaSemana"+solicitado] = false;
				$scope["errorTablaSemana"+solicitado] = true;
				$scope["error"+solicitado] = "No podemos procesar la semana, no se encuentra la información completa";
			}
			
		}else
		{	
			$scope["tabs"+solicitado] = false;
			$scope["tablaSemana"+solicitado] = false;
			$scope["errorTablaSemana"+solicitado] = true;
			$scope["error"+solicitado] = "No se encontro información en la busqueda, semana "+$scope["semanaCalendario"+solicitado]+" "+$scope["semanaFinal"+solicitado].getFullYear();
		}
		if (typeof $scope["semana1"+solicitado] !== 'undefined'){
			$scope["semana1"+solicitado]["informacion"] = {
				"semana": $scope["semanaCalendario"+solicitado],
				"fechaInicio" : ("0"+$scope["fechaSemana"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["fechaSemana"+solicitado].getMonth()+1)).slice(-2),
				"fechaFinal" : ("0"+$scope["semanaFinal"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["semanaFinal"+solicitado].getMonth()+1)).slice(-2),
				"anio" : $scope["semanaFinal"+solicitado].getFullYear(),
				"dividido": 420,
				"promedio": 7980
			};
		}
		
	};

	$scope.diaSemana = function(solicitado, dia){
		if($scope.dataSemana[solicitado]!=0){
			angular.element(".botonera"+solicitado).find(".btn").removeClass("active");
			angular.element(".botonera"+solicitado).find(".btn"+dia).addClass("active");
			fechaDia = new Date($scope["fechaSemana"+solicitado]);
			fechaDia.setDate(fechaDia.getDate()+dia);
			fechaPromedio1 = new Date(fechaDia);
			fechaPromedio1.setHours(7);
			fecha1 = fechaDia.getFullYear()+"-"+("0"+(fechaDia.getMonth()+1)).slice(-2)+"-"+("0"+fechaDia.getDate()).slice(-2);
			fechaDia.setDate(fechaDia.getDate()+1);
			fechaPromedio2 = fechaDia;
			fechaPromedio2.setHours(1);
			fecha2 = fechaDia.getFullYear()+"-"+("0"+(fechaDia.getMonth()+1)).slice(-2)+"-"+("0"+fechaDia.getDate()).slice(-2);
			resultados = ratingMinutosFactory.dia($scope.dataSemana[solicitado], fecha1, fecha2, fechaPromedio1, fechaPromedio2);
			if(!angular.isDefined(resultados["error"])){
				$scope["semana1"+solicitado] = resultados["semana1"];
				$scope["semana2"+solicitado] = resultados["semana2"];
				$scope["tabs"+solicitado] = true;
				$scope["tablaSemana"+solicitado] = true;
				$scope["errorTablaSemana"+solicitado] = false;
			}else{
				$scope["tabs"+solicitado] = true;
				$scope["tabs"+solicitado] = true;
				$scope["tablaSemana"+solicitado] = false;
				$scope["error"+solicitado] = "No se encontro información en la busqueda. Dia "+$filter('date')(fechaPromedio1, "dd'/'MM")+" de semana "+$scope["semanaCalendario"+solicitado]+" "+$scope["semanaFinal"+solicitado].getFullYear();
				$scope["errorTablaSemana"+solicitado] = true;
			}
			if (typeof $scope["semana1"+solicitado] !== 'undefined') {
				$scope["semana1"+solicitado]["informacion"] = {
					"semana": $scope["semanaCalendario"+solicitado],
					"fechaInicio" : ("0"+$scope["fechaSemana"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["fechaSemana"+solicitado].getMonth()+1)).slice(-2),
					"fechaFinal" : ("0"+$scope["semanaFinal"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["semanaFinal"+solicitado].getMonth()+1)).slice(-2),
					"anio" : $scope["semanaFinal"+solicitado].getFullYear(),
					"dividido": 60,
					"promedio": 1140
				}; 
			}
			
		}else
		{	
			$scope["tabs"+solicitado] = false;
			$scope["tablaSemana"+solicitado] = false;
			$scope["errorTablaSemana"+solicitado] = true;
			$scope["error"+solicitado] = "No se encontro información en la busqueda, semana "+$scope["semanaCalendario"+solicitado]+" "+$scope["semanaFinal"+solicitado].getFullYear();
		}
	};

	$scope.lav = function(solicitado){

		if($scope.dataSemana[solicitado]!=0){
			
			angular.element(".botonera"+solicitado).find(".btn").removeClass("active");
			angular.element(".botonera"+solicitado).find(".lav"+solicitado).addClass("active");
			if(Object.keys($scope.dataSemana[solicitado]).length >= 120){
				fechaLimite = new Date($scope["fechaSemana"+solicitado].getTime() + (5 * 24 * 3600 * 1000));
				fechaLimite.setHours(6);
				resultados = ratingMinutosFactory.lav($scope.dataSemana[solicitado], solicitado, fechaLimite);
				$scope["tablaSemana"+solicitado] = true;
				$scope["errorTablaSemana"+solicitado] = false;
				$scope["semana1"+solicitado] = resultados["semana1"];
				$scope["semana2"+solicitado] = resultados["semana2"];
			}else{
				$scope["tabs"+solicitado] = true;
				$scope["tablaSemana"+solicitado] = false;
				$scope["errorTablaSemana"+solicitado] = true;
				$scope["error"+solicitado] = "No podemos procesar lunes a viernes, no se encuentra la información completa";
			}
		}else
		{
			$scope["navs"+solicitado] = true;
			$scope["tabs"+solicitado] = false;
			$scope["tablaSemana"+solicitado] = false;
			$scope["errorTablaSemana"+solicitado] = true;
		}
		if (typeof $scope["semana1"+solicitado] !== 'undefined') {
			$scope["semana1"+solicitado]["informacion"]	= {
				"semana": $scope["semanaCalendario"+solicitado],
				"fechaInicio" : ("0"+$scope["fechaSemana"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["fechaSemana"+solicitado].getMonth()+1)).slice(-2),
				"fechaFinal" : ("0"+$scope["semanaFinal"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["semanaFinal"+solicitado].getMonth()+1)).slice(-2),
				"anio" : $scope["fechaSemana"+solicitado].getFullYear(),
				"dividido": 300,
				"promedio": 5700
			}
		}
		
	};

	$scope.sad = function(solicitado){

		angular.element(".botonera"+solicitado).find(".btn").removeClass("active");
		angular.element(".botonera"+solicitado).find(".sad"+solicitado).addClass("active");
		if($scope.dataSemana[solicitado]!=0){			
			semanaSolicitada = $scope.dataSemana[solicitado];
			
			if(Object.keys($scope.dataSemana[solicitado]).length == 168){
				fechaInicio = new Date($scope["fechaSemana"+solicitado].getTime() + (5 * 24 * 3600 * 1000));
				fechaInicio.setHours(6);
				fechaFinal = new Date($scope["semanaFinal"+solicitado].getTime() + (1 * 24 * 3600 * 1000));
				resultados = ratingMinutosFactory.sad($scope.dataSemana[solicitado], fechaInicio, fechaFinal);
				$scope["semana1"+solicitado] = resultados["semana1"];
				$scope["semana2"+solicitado] = resultados["semana2"];				
				$scope["tablaSemana"+solicitado] = true;
				$scope["errorTablaSemana"+solicitado] = false;
			}else{
				$scope["tabs"+solicitado] = true;
				$scope["tablaSemana"+solicitado] = false;
				$scope["errorTablaSemana"+solicitado] = true;
				$scope["error"+solicitado] = "No podemos procesar Sabado y Domingo, no se encuentra la información completa";
			}
		}else{
			$scope["semana"+solicitado] = "";
			$scope["tablaSemana"+solicitado] = false;
			$scope["errorTablaSemana"+solicitado] = true;
		}

		if (typeof $scope["semana1"+solicitado] !== 'undefined') {
			$scope["semana1"+solicitado]["informacion"] = {
				"semana": $scope["semanaCalendario"+solicitado],
				"fechaInicio" : ("0"+$scope["fechaSemana"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["fechaSemana"+solicitado].getMonth()+1)).slice(-2),
				"fechaFinal" : ("0"+$scope["semanaFinal"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["semanaFinal"+solicitado].getMonth()+1)).slice(-2),
				"anio" : $scope["fechaSemana"+solicitado].getFullYear(),
				"dividido": 120,
				"promedio": 2280
			};
		}
		
	};

	$scope.nav = function(nav){
		angular.element(".bandas").find("li").removeClass("active");
		angular.element(".bandas").find("#nav"+nav).addClass("active");
		for (var i = 0; i < 6; i++) {
			$scope["navs"+i] = false;
		};
		$scope["navs"+nav] = true;
	};

	$scope.vsSemana = function(semana, tabla){
		angular.element(".botonera"+tabla).find(".btn").removeClass("active");
		angular.element(".botonera"+tabla).find(".semana"+tabla).addClass("active");
		if($scope.dataSemana[0]==0 || $scope.dataSemana[semana]){
			if(Object.keys($scope.dataSemana[0]).length == 168 && Object.keys($scope.dataSemana[semana]).length == 168){
				semana1 = ratingMinutosFactory.semana($scope.dataSemana[0], 0);
				semana2 = ratingMinutosFactory.semana($scope.dataSemana[semana], semana);
				$scope["semana1"+tabla] = {};
				$scope["semana2"+tabla] = {};

				$scope["semana1"+tabla]["promedio"] = {
					"cdfb": ((semana1.semana10["promedio"]["cdfb"]-semana2["semana1"+semana]["promedio"]["cdfb"])/semana2["semana1"+semana]["promedio"]["cdfb"])*100,
					"cdfp": ((semana1.semana10["promedio"]["cdfp"]-semana2["semana1"+semana]["promedio"]["cdfp"])/semana2["semana1"+semana]["promedio"]["cdfp"])*100,
					"cdfhd": ((semana1.semana10["promedio"]["cdfhd"]-semana2["semana1"+semana]["promedio"]["cdfhd"])/semana2["semana1"+semana]["promedio"]["cdfhd"])*100,
					"espn": ((semana1.semana10["promedio"]["espn"]-semana2["semana1"+semana]["promedio"]["espn"])/semana2["semana1"+semana]["promedio"]["espn"])*100,
					"espnm": ((semana1.semana10["promedio"]["espnm"]-semana2["semana1"+semana]["promedio"]["espnm"])/semana2["semana1"+semana]["promedio"]["espnm"])*100,
					"espn2": ((semana1.semana10["promedio"]["espn2"]-semana2["semana1"+semana]["promedio"]["espn2"])/semana2["semana1"+semana]["promedio"]["espn2"])*100,
					"espn3": ((semana1.semana10["promedio"]["espn3"]-semana2["semana1"+semana]["promedio"]["espn3"])/semana2["semana1"+semana]["promedio"]["espn3"])*100,
					"espnhd": ((semana1.semana10["promedio"]["espnhd"]-semana2["semana1"+semana]["promedio"]["espnhd"])/semana2["semana1"+semana]["promedio"]["espnhd"])*100,
					"fs": ((semana1.semana10["promedio"]["fs"]-semana2["semana1"+semana]["promedio"]["fs"])/semana2["semana1"+semana]["promedio"]["fs"])*100,
					"fs2": ((semana1.semana10["promedio"]["fs2"]-semana2["semana1"+semana]["promedio"]["fs2"])/semana2["semana1"+semana]["promedio"]["fs2"])*100,
					"fs3": ((semana1.semana10["promedio"]["fs3"]-semana2["semana1"+semana]["promedio"]["fs3"])/semana2["semana1"+semana]["promedio"]["fs3"])*100,
					"fsp": ((semana1.semana10["promedio"]["fsp"]-semana2["semana1"+semana]["promedio"]["fsp"])/semana2["semana1"+semana]["promedio"]["fsp"])*100,
					"tvr": ((semana1.semana10["promedio"]["tvr"]-semana2["semana1"+semana]["promedio"]["tvr"])/semana2["semana1"+semana]["promedio"]["tvr"])*100,
				}
				angular.forEach(semana1.semana10, function(value, key){
					if(key.length==2){
						$scope["semana1"+tabla][key] = {
							"cdfb": ((semana1.semana10[key]["cdfb"]/420)-(semana2["semana1"+semana][key]["cdfb"]/420))/(semana2["semana1"+semana][key]["cdfb"]/420)*100,
							"cdfp": ((semana1.semana10[key]["cdfp"]/420)-(semana2["semana1"+semana][key]["cdfp"]/420))/(semana2["semana1"+semana][key]["cdfp"]/420)*100,
							"cdfhd": ((semana1.semana10[key]["cdfhd"]/420)-(semana2["semana1"+semana][key]["cdfhd"]/420))/(semana2["semana1"+semana][key]["cdfhd"]/420)*100,
							"espn": ((semana1.semana10[key]["espn"]/420)-(semana2["semana1"+semana][key]["espn"]/420))/(semana2["semana1"+semana][key]["espn"]/420)*100,
							"espnm": ((semana1.semana10[key]["espnm"]/420)-(semana2["semana1"+semana][key]["espnm"]/420))/(semana2["semana1"+semana][key]["espnm"]/420)*100,
							"espn2": ((semana1.semana10[key]["espn2"]/420)-(semana2["semana1"+semana][key]["espn2"]/420))/(semana2["semana1"+semana][key]["espn2"]/420)*100,
							"espn3": ((semana1.semana10[key]["espn3"]/420)-(semana2["semana1"+semana][key]["espn3"]/420))/(semana2["semana1"+semana][key]["espn3"]/420)*100,
							"espnhd": ((semana1.semana10[key]["espnhd"]/420)-(semana2["semana1"+semana][key]["espnhd"]/420))/(semana2["semana1"+semana][key]["espnhd"]/420)*100,
							"fs": ((semana1.semana10[key]["fs"]/420)-(semana2["semana1"+semana][key]["fs"]/420))/(semana2["semana1"+semana][key]["fs"]/420)*100,
							"fs2": ((semana1.semana10[key]["fs2"]/420)-(semana2["semana1"+semana][key]["fs2"]/420))/(semana2["semana1"+semana][key]["fs2"]/420)*100,
							"fs3": ((semana1.semana10[key]["fs3"]/420)-(semana2["semana1"+semana][key]["fs3"]/420))/(semana2["semana1"+semana][key]["fs3"]/420)*100,
							"fsp": ((semana1.semana10[key]["fsp"]/420)-(semana2["semana1"+semana][key]["fsp"]/420))/(semana2["semana1"+semana][key]["fsp"]/420)*100,
							"tvr": ((semana1.semana10[key]["tvr"]/420)-(semana2["semana1"+semana][key]["tvr"]/420))/(semana2["semana1"+semana][key]["tvr"]/420)*100,
						};
					}
				});
				angular.forEach(semana1.semana20, function(value, key){
					if(key.length==2){
						$scope["semana2"+tabla][key] = {
							"cdfb": ((semana1.semana20[key]["cdfb"]/420)-(semana2["semana2"+semana][key]["cdfb"]/420))/(semana2["semana2"+semana][key]["cdfb"]/420)*100,
							"cdfp": ((semana1.semana20[key]["cdfp"]/420)-(semana2["semana2"+semana][key]["cdfp"]/420))/(semana2["semana2"+semana][key]["cdfp"]/420)*100,
							"cdfhd": ((semana1.semana20[key]["cdfhd"]/420)-(semana2["semana2"+semana][key]["cdfhd"]/420))/(semana2["semana2"+semana][key]["cdfhd"]/420)*100,
							"espn": ((semana1.semana20[key]["espn"]/420)-(semana2["semana2"+semana][key]["espn"]/420))/(semana2["semana2"+semana][key]["espn"]/420)*100,
							"espnm": ((semana1.semana20[key]["espnm"]/420)-(semana2["semana2"+semana][key]["espnm"]/420))/(semana2["semana2"+semana][key]["espnm"]/420)*100,
							"espn2": ((semana1.semana20[key]["espn2"]/420)-(semana2["semana2"+semana][key]["espn2"]/420))/(semana2["semana2"+semana][key]["espn2"]/420)*100,
							"espn3": ((semana1.semana20[key]["espn3"]/420)-(semana2["semana2"+semana][key]["espn3"]/420))/(semana2["semana2"+semana][key]["espn3"]/420)*100,
							"espnhd": ((semana1.semana20[key]["espnhd"]/420)-(semana2["semana2"+semana][key]["espnhd"]/420))/(semana2["semana2"+semana][key]["espnhd"]/420)*100,
							"fs": ((semana1.semana20[key]["fs"]/420)-(semana2["semana2"+semana][key]["fs"]/420))/(semana2["semana2"+semana][key]["fs"]/420)*100,
							"fs2": ((semana1.semana20[key]["fs2"]/420)-(semana2["semana2"+semana][key]["fs2"]/420))/(semana2["semana2"+semana][key]["fs2"]/420)*100,
							"fs3": ((semana1.semana20[key]["fs3"]/420)-(semana2["semana2"+semana][key]["fs3"]/420))/(semana2["semana2"+semana][key]["fs3"]/420)*100,
							"fsp": ((semana1.semana20[key]["fsp"]/420)-(semana2["semana2"+semana][key]["fsp"]/420))/(semana2["semana2"+semana][key]["fsp"]/420)*100,
							"tvr": ((semana1.semana20[key]["tvr"]/420)-(semana2["semana2"+semana][key]["tvr"]/420))/(semana2["semana2"+semana][key]["tvr"]/420)*100,
						};
					}
				});
				$scope["tabs"+tabla] = true;
				$scope["tablaSemana"+tabla] = true;
				$scope["errorTablaSemana"+tabla] = false;
			}else{
				$scope["tabs"+tabla] = true;
				$scope["tablaSemana"+tabla] = false;
				$scope["errorTablaSemana"+tabla] = true;
				$scope["error"+tabla] = "No podemos procesar la información, faltan datos para la variacion de la semana "+$scope.semanaCalendario0+" "+$scope.semanaFinal0.getFullYear()+" vs "+$scope["semanaCalendario"+semana]+" "+$scope["semanaFinal"+semana].getFullYear();
			}
		}else{
			$scope["tabs"+tabla] = true;
			$scope["tablaSemana"+tabla] = false;
			$scope["errorTablaSemana"+tabla] = true;
			$scope["error"+tabla] = "No podemos procesar la información, faltan una de las semanas "+$scope.semanaCalendario0+" "+$scope.semanaFinal0.getFullYear()+" o "+$scope["semanaCalendario"+semana]+" "+$scope["semanaFinal"+semana].getFullYear();
		}
		
	}

	$scope.vsDia = function(solicitado, tabla, dia){
		angular.element(".botonera"+tabla).find(".btn").removeClass("active");
		angular.element(".botonera"+tabla).find(".btn"+dia).addClass("active");
		if($scope.dataSemana[0]!=0 && $scope.dataSemana[solicitado]!=0){
			fechaDia1 = new Date($scope["fechaSemana0"]);
			fechaDia1.setDate(fechaDia1.getDate()+dia);
			fechaPromedio1 = new Date(fechaDia1);
			fechaPromedio1.setHours(7);
			fecha1 = fechaDia1.getFullYear()+"-"+("0"+(fechaDia1.getMonth()+1)).slice(-2)+"-"+("0"+fechaDia1.getDate()).slice(-2);
			fechaDia1.setDate(fechaDia1.getDate()+1);
			fechaPromedio2 = fechaDia1;
			fechaPromedio2.setHours(1);
			fecha2 = fechaDia1.getFullYear()+"-"+("0"+(fechaDia1.getMonth()+1)).slice(-2)+"-"+("0"+fechaDia1.getDate()).slice(-2);
			resultado1 = ratingMinutosFactory.dia($scope.dataSemana[0], fecha1, fecha2, fechaPromedio1, fechaPromedio2);
			fechaDia2 = new Date($scope["fechaSemana"+solicitado]);
			fechaDia2.setDate(fechaDia2.getDate()+dia);
			fechaPromedio1 = new Date(fechaDia2);
			fechaPromedio1.setHours(10);
			fecha1 = fechaDia2.getFullYear()+"-"+("0"+(fechaDia2.getMonth()+1)).slice(-2)+"-"+("0"+fechaDia2.getDate()).slice(-2);
			fechaDia2.setDate(fechaDia2.getDate()+1);
			fechaPromedio2 = fechaDia2;
			fechaPromedio2.setHours(1);
			fecha2 = fechaDia2.getFullYear()+"-"+("0"+(fechaDia2.getMonth()+1)).slice(-2)+"-"+("0"+fechaDia2.getDate()).slice(-2);
			dividido = 60;
			resultado2 = ratingMinutosFactory.dia($scope.dataSemana[solicitado], fecha1, fecha2, fechaPromedio1, fechaPromedio2);
			if(!angular.isDefined(resultado1["error"]) && !angular.isDefined(resultado2["error"])){
				$scope["semana1"+tabla] = {};
				$scope["semana2"+tabla] = {};
				$scope["semana1"+tabla]["promedio"] = {
					"cdfb": ((resultado1.semana1["promedio"]["cdfb"]-resultado2.semana1["promedio"]["cdfb"])/resultado2.semana1["promedio"]["cdfb"])*100,
					"cdfp": ((resultado1.semana1["promedio"]["cdfp"]-resultado2.semana1["promedio"]["cdfp"])/resultado2.semana1["promedio"]["cdfp"])*100,
					"cdfhd": ((resultado1.semana1["promedio"]["cdfhd"]-resultado2.semana1["promedio"]["cdfhd"])/resultado2.semana1["promedio"]["cdfhd"])*100,
					"espn": ((resultado1.semana1["promedio"]["espn"]-resultado2.semana1["promedio"]["espn"])/resultado2.semana1["promedio"]["espn"])*100,
					"espnm": ((resultado1.semana1["promedio"]["espnm"]-resultado2.semana1["promedio"]["espnm"])/resultado2.semana1["promedio"]["espnm"])*100,
					"espn2": ((resultado1.semana1["promedio"]["espn2"]-resultado2.semana1["promedio"]["espn2"])/resultado2.semana1["promedio"]["espn2"])*100,
					"espn3": ((resultado1.semana1["promedio"]["espn3"]-resultado2.semana1["promedio"]["espn3"])/resultado2.semana1["promedio"]["espn3"])*100,
					"espnhd": ((resultado1.semana1["promedio"]["espnhd"]-resultado2.semana1["promedio"]["espnhd"])/resultado2.semana1["promedio"]["espnhd"])*100,
					"fs": ((resultado1.semana1["promedio"]["fs"]-resultado2.semana1["promedio"]["fs"])/resultado2.semana1["promedio"]["fs"])*100,
					"fs2": ((resultado1.semana1["promedio"]["fs2"]-resultado2.semana1["promedio"]["fs2"])/resultado2.semana1["promedio"]["fs2"])*100,
					"fs3": ((resultado1.semana1["promedio"]["fs3"]-resultado2.semana1["promedio"]["fs3"])/resultado2.semana1["promedio"]["fs3"])*100,
					"fsp": ((resultado1.semana1["promedio"]["fsp"]-resultado2.semana1["promedio"]["fsp"])/resultado2.semana1["promedio"]["fsp"])*100,
					"tvr": ((resultado1.semana1["promedio"]["tvr"]-resultado2.semana1["promedio"]["tvr"])/resultado2.semana1["promedio"]["tvr"])*100,
				}
				angular.forEach(resultado1.semana1, function(value, key){
					if(key.length==2){
						$scope["semana1"+tabla][key] = {
							"cdfb": ((resultado1.semana1[key]["cdfb"]/dividido)-(resultado2.semana1[key]["cdfb"]/dividido))/(resultado2.semana1[key]["cdfb"]/dividido)*100,
							"cdfp": ((resultado1.semana1[key]["cdfp"]/dividido)-(resultado2.semana1[key]["cdfp"]/dividido))/(resultado2.semana1[key]["cdfp"]/dividido)*100,
							"cdfhd": ((resultado1.semana1[key]["cdfhd"]/dividido)-(resultado2.semana1[key]["cdfhd"]/dividido))/(resultado2.semana1[key]["cdfhd"]/dividido)*100,
							"espn": ((resultado1.semana1[key]["espn"]/dividido)-(resultado2.semana1[key]["espn"]/dividido))/(resultado2.semana1[key]["espn"]/dividido)*100,
							"espnm": ((resultado1.semana1[key]["espnm"]/dividido)-(resultado2.semana1[key]["espnm"]/dividido))/(resultado2.semana1[key]["espnm"]/dividido)*100,
							"espn2": ((resultado1.semana1[key]["espn2"]/dividido)-(resultado2.semana1[key]["espn2"]/dividido))/(resultado2.semana1[key]["espn2"]/dividido)*100,
							"espn3": ((resultado1.semana1[key]["espn3"]/dividido)-(resultado2.semana1[key]["espn3"]/dividido))/(resultado2.semana1[key]["espn3"]/dividido)*100,
							"espnhd": ((resultado1.semana1[key]["espnhd"]/dividido)-(resultado2.semana1[key]["espnhd"]/dividido))/(resultado2.semana1[key]["espnhd"]/dividido)*100,
							"fs": ((resultado1.semana1[key]["fs"]/dividido)-(resultado2.semana1[key]["fs"]/dividido))/(resultado2.semana1[key]["fs"]/dividido)*100,
							"fs2": ((resultado1.semana1[key]["fs2"]/dividido)-(resultado2.semana1[key]["fs2"]/dividido))/(resultado2.semana1[key]["fs2"]/dividido)*100,
							"fs3": ((resultado1.semana1[key]["fs3"]/dividido)-(resultado2.semana1[key]["fs3"]/dividido))/(resultado2.semana1[key]["fs3"]/dividido)*100,
							"fsp": ((resultado1.semana1[key]["fsp"]/dividido)-(resultado2.semana1[key]["fsp"]/dividido))/(resultado2.semana1[key]["fsp"]/dividido)*100,
							"tvr": ((resultado1.semana1[key]["tvr"]/dividido)-(resultado2.semana1[key]["tvr"]/dividido))/(resultado2.semana1[key]["tvr"]/dividido)*100,
						};
					}
				});
				angular.forEach(resultado1.semana2, function(value, key){
					if(key.length==2){
						$scope["semana2"+tabla][key] = {
							"cdfb": ((resultado1.semana2[key]["cdfb"]/dividido)-(resultado2.semana2[key]["cdfb"]/dividido))/(resultado2.semana2[key]["cdfb"]/dividido)*100,
							"cdfp": ((resultado1.semana2[key]["cdfp"]/dividido)-(resultado2.semana2[key]["cdfp"]/dividido))/(resultado2.semana2[key]["cdfp"]/dividido)*100,
							"cdfhd": ((resultado1.semana2[key]["cdfhd"]/dividido)-(resultado2.semana2[key]["cdfhd"]/dividido))/(resultado2.semana2[key]["cdfhd"]/dividido)*100,
							"espn": ((resultado1.semana2[key]["espn"]/dividido)-(resultado2.semana2[key]["espn"]/dividido))/(resultado2.semana2[key]["espn"]/dividido)*100,
							"espnm": ((resultado1.semana2[key]["espnm"]/dividido)-(resultado2.semana2[key]["espnm"]/dividido))/(resultado2.semana2[key]["espnm"]/dividido)*100,
							"espn2": ((resultado1.semana2[key]["espn2"]/dividido)-(resultado2.semana2[key]["espn2"]/dividido))/(resultado2.semana2[key]["espn2"]/dividido)*100,
							"espn3": ((resultado1.semana2[key]["espn3"]/dividido)-(resultado2.semana2[key]["espn3"]/dividido))/(resultado2.semana2[key]["espn3"]/dividido)*100,
							"espnhd": ((resultado1.semana2[key]["espnhd"]/dividido)-(resultado2.semana2[key]["espnhd"]/dividido))/(resultado2.semana2[key]["espnhd"]/dividido)*100,
							"fs": ((resultado1.semana2[key]["fs"]/dividido)-(resultado2.semana2[key]["fs"]/dividido))/(resultado2.semana2[key]["fs"]/dividido)*100,
							"fs2": ((resultado1.semana2[key]["fs2"]/dividido)-(resultado2.semana2[key]["fs2"]/dividido))/(resultado2.semana2[key]["fs2"]/dividido)*100,
							"fs3": ((resultado1.semana2[key]["fs3"]/dividido)-(resultado2.semana2[key]["fs3"]/dividido))/(resultado2.semana2[key]["fs3"]/dividido)*100,
							"fsp": ((resultado1.semana2[key]["fsp"]/dividido)-(resultado2.semana2[key]["fsp"]/dividido))/(resultado2.semana2[key]["fsp"]/dividido)*100,
							"tvr": ((resultado1.semana2[key]["tvr"]/dividido)-(resultado2.semana2[key]["tvr"]/dividido))/(resultado2.semana2[key]["tvr"]/dividido)*100,
						};
					}
				});
				$scope["tabs"+tabla] = true;
				$scope["tablaSemana"+tabla] = true;
				$scope["errorTablaSemana"+tabla] = false;
			}else{
				$scope["tabs"+tabla] = true;
				$scope["tablaSemana"+tabla] = false;
				$scope["errorTablaSemana"+tabla] = true;
				$scope["error"+tabla] = "No podemos procesar la información, falta el dia "+$filter('date')(fechaDia1, "dd/MM/yyyy")+" o "+$filter('date')(fechaDia2, "dd/MM/yyyy");	
			}
	
		}else{
			$scope["tabs"+tabla] = true;
			$scope["tablaSemana"+tabla] = false;
			$scope["errorTablaSemana"+tabla] = true;
			$scope["error"+tabla] = "No podemos procesar la información, falta datos";
		}
		
	}

	$scope.vsLav = function(solicitado, tabla){

		angular.element(".botonera"+tabla).find(".btn").removeClass("active");
		angular.element(".botonera"+tabla).find(".lav"+tabla).addClass("active");
		if($scope.dataSemana[0]!=0 && $scope.dataSemana[solicitado]!=0){
			if(Object.keys($scope.dataSemana[0]).length >= 120 && Object.keys($scope.dataSemana[solicitado]).length >= 120){
				fechaLimite = new Date($scope.fechaSemana0.getTime() + (5 * 24 * 3600 * 1000));
				fechaLimite.setHours(6);
				resultado1 = ratingMinutosFactory.lav($scope.dataSemana[0], solicitado, fechaLimite);

				fechaLimite = new Date($scope["fechaSemana"+solicitado].getTime() + (5 * 24 * 3600 * 1000));
				fechaLimite.setHours(6);
				resultado2 = ratingMinutosFactory.lav($scope.dataSemana[solicitado], solicitado, fechaLimite);

				dividido = 300; 

				$scope["semana1"+tabla] = {};
				$scope["semana2"+tabla] = {};
				$scope["semana1"+tabla]["promedio"] = {
					"cdfb": ((resultado1.semana1["promedio"]["cdfb"]-resultado2.semana1["promedio"]["cdfb"])/resultado2.semana1["promedio"]["cdfb"])*100,
					"cdfp": ((resultado1.semana1["promedio"]["cdfp"]-resultado2.semana1["promedio"]["cdfp"])/resultado2.semana1["promedio"]["cdfp"])*100,
					"cdfhd": ((resultado1.semana1["promedio"]["cdfhd"]-resultado2.semana1["promedio"]["cdfhd"])/resultado2.semana1["promedio"]["cdfhd"])*100,
					"espn": ((resultado1.semana1["promedio"]["espn"]-resultado2.semana1["promedio"]["espn"])/resultado2.semana1["promedio"]["espn"])*100,
					"espnm": ((resultado1.semana1["promedio"]["espnm"]-resultado2.semana1["promedio"]["espnm"])/resultado2.semana1["promedio"]["espnm"])*100,
					"espn2": ((resultado1.semana1["promedio"]["espn2"]-resultado2.semana1["promedio"]["espn2"])/resultado2.semana1["promedio"]["espn2"])*100,
					"espn3": ((resultado1.semana1["promedio"]["espn3"]-resultado2.semana1["promedio"]["espn3"])/resultado2.semana1["promedio"]["espn3"])*100,
					"espnhd": ((resultado1.semana1["promedio"]["espnhd"]-resultado2.semana1["promedio"]["espnhd"])/resultado2.semana1["promedio"]["espnhd"])*100,
					"fs": ((resultado1.semana1["promedio"]["fs"]-resultado2.semana1["promedio"]["fs"])/resultado2.semana1["promedio"]["fs"])*100,
					"fs2": ((resultado1.semana1["promedio"]["fs2"]-resultado2.semana1["promedio"]["fs2"])/resultado2.semana1["promedio"]["fs2"])*100,
					"fs3": ((resultado1.semana1["promedio"]["fs3"]-resultado2.semana1["promedio"]["fs3"])/resultado2.semana1["promedio"]["fs3"])*100,
					"fsp": ((resultado1.semana1["promedio"]["fsp"]-resultado2.semana1["promedio"]["fsp"])/resultado2.semana1["promedio"]["fsp"])*100,
					"tvr": ((resultado1.semana1["promedio"]["tvr"]-resultado2.semana1["promedio"]["tvr"])/resultado2.semana1["promedio"]["tvr"])*100,
				}
				angular.forEach(resultado1.semana1, function(value, key){
					if(key.length==2){
						$scope["semana1"+tabla][key] = {
							"cdfb": ((resultado1.semana1[key]["cdfb"]/dividido)-(resultado2.semana1[key]["cdfb"]/dividido))/(resultado2.semana1[key]["cdfb"]/dividido)*100,
							"cdfp": ((resultado1.semana1[key]["cdfp"]/dividido)-(resultado2.semana1[key]["cdfp"]/dividido))/(resultado2.semana1[key]["cdfp"]/dividido)*100,
							"cdfhd": ((resultado1.semana1[key]["cdfhd"]/dividido)-(resultado2.semana1[key]["cdfhd"]/dividido))/(resultado2.semana1[key]["cdfhd"]/dividido)*100,
							"espn": ((resultado1.semana1[key]["espn"]/dividido)-(resultado2.semana1[key]["espn"]/dividido))/(resultado2.semana1[key]["espn"]/dividido)*100,
							"espnm": ((resultado1.semana1[key]["espnm"]/dividido)-(resultado2.semana1[key]["espnm"]/dividido))/(resultado2.semana1[key]["espnm"]/dividido)*100,
							"espn2": ((resultado1.semana1[key]["espn2"]/dividido)-(resultado2.semana1[key]["espn2"]/dividido))/(resultado2.semana1[key]["espn2"]/dividido)*100,
							"espn3": ((resultado1.semana1[key]["espn3"]/dividido)-(resultado2.semana1[key]["espn3"]/dividido))/(resultado2.semana1[key]["espn3"]/dividido)*100,
							"espnhd": ((resultado1.semana1[key]["espnhd"]/dividido)-(resultado2.semana1[key]["espnhd"]/dividido))/(resultado2.semana1[key]["espnhd"]/dividido)*100,
							"fs": ((resultado1.semana1[key]["fs"]/dividido)-(resultado2.semana1[key]["fs"]/dividido))/(resultado2.semana1[key]["fs"]/dividido)*100,
							"fs2": ((resultado1.semana1[key]["fs2"]/dividido)-(resultado2.semana1[key]["fs2"]/dividido))/(resultado2.semana1[key]["fs2"]/dividido)*100,
							"fs3": ((resultado1.semana1[key]["fs3"]/dividido)-(resultado2.semana1[key]["fs3"]/dividido))/(resultado2.semana1[key]["fs3"]/dividido)*100,
							"fsp": ((resultado1.semana1[key]["fsp"]/dividido)-(resultado2.semana1[key]["fsp"]/dividido))/(resultado2.semana1[key]["fsp"]/dividido)*100,
							"tvr": ((resultado1.semana1[key]["tvr"]/dividido)-(resultado2.semana1[key]["tvr"]/dividido))/(resultado2.semana1[key]["tvr"]/dividido)*100,
						};
					}
				})
				angular.forEach(resultado1.semana2, function(value, key){
					if(key.length==2){
						$scope["semana2"+tabla][key] = {
							"cdfb": ((resultado1.semana2[key]["cdfb"]/dividido)-(resultado2.semana2[key]["cdfb"]/dividido))/(resultado2.semana2[key]["cdfb"]/dividido)*100,
							"cdfp": ((resultado1.semana2[key]["cdfp"]/dividido)-(resultado2.semana2[key]["cdfp"]/dividido))/(resultado2.semana2[key]["cdfp"]/dividido)*100,
							"cdfhd": ((resultado1.semana2[key]["cdfhd"]/dividido)-(resultado2.semana2[key]["cdfhd"]/dividido))/(resultado2.semana2[key]["cdfhd"]/dividido)*100,
							"espn": ((resultado1.semana2[key]["espn"]/dividido)-(resultado2.semana2[key]["espn"]/dividido))/(resultado2.semana2[key]["espn"]/dividido)*100,
							"espnm": ((resultado1.semana2[key]["espnm"]/dividido)-(resultado2.semana2[key]["espnm"]/dividido))/(resultado2.semana2[key]["espnm"]/dividido)*100,
							"espn2": ((resultado1.semana2[key]["espn2"]/dividido)-(resultado2.semana2[key]["espn2"]/dividido))/(resultado2.semana2[key]["espn2"]/dividido)*100,
							"espn3": ((resultado1.semana2[key]["espn3"]/dividido)-(resultado2.semana2[key]["espn3"]/dividido))/(resultado2.semana2[key]["espn3"]/dividido)*100,
							"espnhd": ((resultado1.semana2[key]["espnhd"]/dividido)-(resultado2.semana2[key]["espnhd"]/dividido))/(resultado2.semana2[key]["espnhd"]/dividido)*100,
							"fs": ((resultado1.semana2[key]["fs"]/dividido)-(resultado2.semana2[key]["fs"]/dividido))/(resultado2.semana2[key]["fs"]/dividido)*100,
							"fs2": ((resultado1.semana2[key]["fs2"]/dividido)-(resultado2.semana2[key]["fs2"]/dividido))/(resultado2.semana2[key]["fs2"]/dividido)*100,
							"fs3": ((resultado1.semana2[key]["fs3"]/dividido)-(resultado2.semana2[key]["fs3"]/dividido))/(resultado2.semana2[key]["fs3"]/dividido)*100,
							"fsp": ((resultado1.semana2[key]["fsp"]/dividido)-(resultado2.semana2[key]["fsp"]/dividido))/(resultado2.semana2[key]["fsp"]/dividido)*100,
							"tvr": ((resultado1.semana2[key]["tvr"]/dividido)-(resultado2.semana2[key]["tvr"]/dividido))/(resultado2.semana2[key]["tvr"]/dividido)*100,
						};
					}
				});
				$scope["tabs"+tabla] = true;
				$scope["tablaSemana"+tabla] = true;
				$scope["errorTablaSemana"+tabla] = false;

			}else{
				$scope["tabs"+solicitado] = true;
				$scope["tablaSemana"+solicitado] = false;
				$scope["errorTablaSemana"+solicitado] = true;
				$scope["error"+solicitado] = "No podemos procesar lunes a viernes, no se encuentra la información completa";
			}	
		}else{
			$scope["tabs"+tabla] = true;
			$scope["tablaSemana"+tabla] = false;
			$scope["errorTablaSemana"+tabla] = true;
			$scope["error"+tabla] = "No podemos procesar la información, faltan datos";
		}
	}

	$scope.vsSad = function(solicitado, tabla){

		angular.element(".botonera"+tabla).find(".btn").removeClass("active");
		angular.element(".botonera"+tabla).find(".sad"+tabla).addClass("active");
		if($scope.dataSemana[0]!=0 && $scope.dataSemana[solicitado]!=0){
			if(Object.keys($scope.dataSemana[0]).length == 168 && Object.keys($scope.dataSemana[solicitado]).length == 168){
				fechaInicio = new Date($scope.fechaSemana0.getTime() + (5 * 24 * 3600 * 1000));
				fechaInicio.setHours(6);
				fechaFinal = new Date($scope.semanaFinal0.getTime() + (1 * 24 * 3600 * 1000));
				resultado1 = ratingMinutosFactory.sad($scope.dataSemana[0], fechaInicio, fechaFinal);
				fechaInicio = new Date($scope["fechaSemana"+solicitado].getTime() + (5 * 24 * 3600 * 1000));
				fechaInicio.setHours(6);
				fechaFinal = new Date($scope["semanaFinal"+solicitado].getTime() + (1 * 24 * 3600 * 1000));
				resultado2 = ratingMinutosFactory.sad($scope.dataSemana[solicitado], fechaInicio, fechaFinal);
				dividido = 120; 
				$scope["semana1"+tabla] = {};
				$scope["semana2"+tabla] = {};
				$scope["semana1"+tabla]["promedio"] = {
					"cdfb": ((resultado1.semana1["promedio"]["cdfb"]-resultado2.semana1["promedio"]["cdfb"])/resultado2.semana1["promedio"]["cdfb"])*100,
					"cdfp": ((resultado1.semana1["promedio"]["cdfp"]-resultado2.semana1["promedio"]["cdfp"])/resultado2.semana1["promedio"]["cdfp"])*100,
					"cdfhd": ((resultado1.semana1["promedio"]["cdfhd"]-resultado2.semana1["promedio"]["cdfhd"])/resultado2.semana1["promedio"]["cdfhd"])*100,
					"espn": ((resultado1.semana1["promedio"]["espn"]-resultado2.semana1["promedio"]["espn"])/resultado2.semana1["promedio"]["espn"])*100,
					"espnm": ((resultado1.semana1["promedio"]["espnm"]-resultado2.semana1["promedio"]["espnm"])/resultado2.semana1["promedio"]["espnm"])*100,
					"espn2": ((resultado1.semana1["promedio"]["espn2"]-resultado2.semana1["promedio"]["espn2"])/resultado2.semana1["promedio"]["espn2"])*100,
					"espn3": ((resultado1.semana1["promedio"]["espn3"]-resultado2.semana1["promedio"]["espn3"])/resultado2.semana1["promedio"]["espn3"])*100,
					"espnhd": ((resultado1.semana1["promedio"]["espnhd"]-resultado2.semana1["promedio"]["espnhd"])/resultado2.semana1["promedio"]["espnhd"])*100,
					"fs": ((resultado1.semana1["promedio"]["fs"]-resultado2.semana1["promedio"]["fs"])/resultado2.semana1["promedio"]["fs"])*100,
					"fs2": ((resultado1.semana1["promedio"]["fs2"]-resultado2.semana1["promedio"]["fs2"])/resultado2.semana1["promedio"]["fs2"])*100,
					"fs3": ((resultado1.semana1["promedio"]["fs3"]-resultado2.semana1["promedio"]["fs3"])/resultado2.semana1["promedio"]["fs3"])*100,
					"fsp": ((resultado1.semana1["promedio"]["fsp"]-resultado2.semana1["promedio"]["fsp"])/resultado2.semana1["promedio"]["fsp"])*100,
					"tvr": ((resultado1.semana1["promedio"]["tvr"]-resultado2.semana1["promedio"]["tvr"])/resultado2.semana1["promedio"]["tvr"])*100,
				}
				angular.forEach(resultado1.semana1, function(value, key){
					if(key.length==2){
						$scope["semana1"+tabla][key] = {
							"cdfb": ((resultado1.semana1[key]["cdfb"]/dividido)-(resultado2.semana1[key]["cdfb"]/dividido))/(resultado2.semana1[key]["cdfb"]/dividido)*100,
							"cdfp": ((resultado1.semana1[key]["cdfp"]/dividido)-(resultado2.semana1[key]["cdfp"]/dividido))/(resultado2.semana1[key]["cdfp"]/dividido)*100,
							"cdfhd": ((resultado1.semana1[key]["cdfhd"]/dividido)-(resultado2.semana1[key]["cdfhd"]/dividido))/(resultado2.semana1[key]["cdfhd"]/dividido)*100,
							"espn": ((resultado1.semana1[key]["espn"]/dividido)-(resultado2.semana1[key]["espn"]/dividido))/(resultado2.semana1[key]["espn"]/dividido)*100,
							"espnm": ((resultado1.semana1[key]["espnm"]/dividido)-(resultado2.semana1[key]["espnm"]/dividido))/(resultado2.semana1[key]["espnm"]/dividido)*100,
							"espn2": ((resultado1.semana1[key]["espn2"]/dividido)-(resultado2.semana1[key]["espn2"]/dividido))/(resultado2.semana1[key]["espn2"]/dividido)*100,
							"espn3": ((resultado1.semana1[key]["espn3"]/dividido)-(resultado2.semana1[key]["espn3"]/dividido))/(resultado2.semana1[key]["espn3"]/dividido)*100,
							"espnhd": ((resultado1.semana1[key]["espnhd"]/dividido)-(resultado2.semana1[key]["espnhd"]/dividido))/(resultado2.semana1[key]["espnhd"]/dividido)*100,
							"fs": ((resultado1.semana1[key]["fs"]/dividido)-(resultado2.semana1[key]["fs"]/dividido))/(resultado2.semana1[key]["fs"]/dividido)*100,
							"fs2": ((resultado1.semana1[key]["fs2"]/dividido)-(resultado2.semana1[key]["fs2"]/dividido))/(resultado2.semana1[key]["fs2"]/dividido)*100,
							"fs3": ((resultado1.semana1[key]["fs3"]/dividido)-(resultado2.semana1[key]["fs3"]/dividido))/(resultado2.semana1[key]["fs3"]/dividido)*100,
							"fsp": ((resultado1.semana1[key]["fsp"]/dividido)-(resultado2.semana1[key]["fsp"]/dividido))/(resultado2.semana1[key]["fsp"]/dividido)*100,
							"tvr": ((resultado1.semana1[key]["tvr"]/dividido)-(resultado2.semana1[key]["tvr"]/dividido))/(resultado2.semana1[key]["tvr"]/dividido)*100,
						};
					}
				})
				angular.forEach(resultado1.semana2, function(value, key){
					if(key.length==2){
						$scope["semana2"+tabla][key] = {
							"cdfb": ((resultado1.semana2[key]["cdfb"]/dividido)-(resultado2.semana2[key]["cdfb"]/dividido))/(resultado2.semana2[key]["cdfb"]/dividido)*100,
							"cdfp": ((resultado1.semana2[key]["cdfp"]/dividido)-(resultado2.semana2[key]["cdfp"]/dividido))/(resultado2.semana2[key]["cdfp"]/dividido)*100,
							"cdfhd": ((resultado1.semana2[key]["cdfhd"]/dividido)-(resultado2.semana2[key]["cdfhd"]/dividido))/(resultado2.semana2[key]["cdfhd"]/dividido)*100,
							"espn": ((resultado1.semana2[key]["espn"]/dividido)-(resultado2.semana2[key]["espn"]/dividido))/(resultado2.semana2[key]["espn"]/dividido)*100,
							"espnm": ((resultado1.semana2[key]["espnm"]/dividido)-(resultado2.semana2[key]["espnm"]/dividido))/(resultado2.semana2[key]["espnm"]/dividido)*100,
							"espn2": ((resultado1.semana2[key]["espn2"]/dividido)-(resultado2.semana2[key]["espn2"]/dividido))/(resultado2.semana2[key]["espn2"]/dividido)*100,
							"espn3": ((resultado1.semana2[key]["espn3"]/dividido)-(resultado2.semana2[key]["espn3"]/dividido))/(resultado2.semana2[key]["espn3"]/dividido)*100,
							"espnhd": ((resultado1.semana2[key]["espnhd"]/dividido)-(resultado2.semana2[key]["espnhd"]/dividido))/(resultado2.semana2[key]["espnhd"]/dividido)*100,
							"fs": ((resultado1.semana2[key]["fs"]/dividido)-(resultado2.semana2[key]["fs"]/dividido))/(resultado2.semana2[key]["fs"]/dividido)*100,
							"fs2": ((resultado1.semana2[key]["fs2"]/dividido)-(resultado2.semana2[key]["fs2"]/dividido))/(resultado2.semana2[key]["fs2"]/dividido)*100,
							"fs3": ((resultado1.semana2[key]["fs3"]/dividido)-(resultado2.semana2[key]["fs3"]/dividido))/(resultado2.semana2[key]["fs3"]/dividido)*100,
							"fsp": ((resultado1.semana2[key]["fsp"]/dividido)-(resultado2.semana2[key]["fsp"]/dividido))/(resultado2.semana2[key]["fsp"]/dividido)*100,
							"tvr": ((resultado1.semana2[key]["tvr"]/dividido)-(resultado2.semana2[key]["tvr"]/dividido))/(resultado2.semana2[key]["tvr"]/dividido)*100,
						};
					}
				});
				$scope["tabs"+tabla] = true;
				$scope["tablaSemana"+tabla] = true;
				$scope["errorTablaSemana"+tabla] = false;

			}else{
				$scope["tabs"+solicitado] = true;
				$scope["tablaSemana"+solicitado] = false;
				$scope["errorTablaSemana"+solicitado] = true;
				$scope["error"+solicitado] = "No podemos procesar sabado y domingo, no se encuentra la información completa";
			}	
		}else{
			$scope["tabs"+tabla] = true;
			$scope["tablaSemana"+tabla] = false;
			$scope["errorTablaSemana"+tabla] = true;
			$scope["error"+tabla] = "No podemos procesar la información, faltan datos";
		}
	}
	$scope.acumuladoRating = function(){
		angular.element(".acumulados").removeClass("active");
		angular.element("#acumuladoRating").addClass("active");
		$scope.acumuladoRatingShow = false;
		$scope.acumuladoShareShow = false;
	};

	$scope.acumuladoShare = function(){
		angular.element(".acumulados").removeClass("active");
		angular.element("#acumuladoShare").addClass("active");
		$scope.acumuladoRatingShow = true;
		$scope.acumuladoShareShow = true;
	};

	$scope.parseInt = function(numero){
		return (Math.ceil(numero).toString());
	};

	$scope.isFinite = function(numero){
		if(!isFinite(numero)){
			numero = 0;
		}
		return numero;
	};
}]);
