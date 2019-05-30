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

app.controller('informe_minutos', ['$scope', '$http', '$filter', '$q','ratingMinutosService', function ($scope, $http, $filter, $q, ratingMinutosService) {
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
			var minutos = ratingMinutosService.minutos_rango(inicio.getFullYear()+"-"+(inicio.getMonth()+1)+"-"+inicio.getDate()+" "+inicio.getHours()+":"+inicio.getMinutes()+":00", final.getFullYear()+"-"+(final.getMonth()+1)+"-"+final.getDate()+" "+final.getHours()+":"+final.getMinutes()+":00");
			minutos.then(function (data){
				if(data.data!=0){
					$scope.detalleMinutos = true;
					$scope.minutos = data.data;
					$scope.chartConfig.series = [];
					var inicioArray = new Array();
					var cdfbRating = new Array();
					var cdfpRating = new Array();
					var cdfhdRating = new Array();
					var espnRating = new Array();
					var espnmRating = new Array();
					var espn3Rating = new Array();
					var espnhdRating = new Array();
					var fsRating = new Array();
					var fspRating = new Array();
					var fs2Rating = new Array();
					var fs3Rating = new Array();
					angular.forEach(data.data, function(value, key){
						inicioArray.push(key);
						cdfbRating.push(parseFloat(value.cdfb[0]));
						cdfpRating.push(parseFloat(value.cdfp[0]));
						cdfhdRating.push(parseFloat(value.cdfhd[0]));
						espnRating.push(parseFloat(value.espn[0]));
						espnmRating.push(parseFloat(value.espnm[0]));
						espn3Rating.push(parseFloat(value.espn3[0]));
						espnhdRating.push(parseFloat(value.espnhd[0]));
						fsRating.push(parseFloat(value.fs[0]));
						fspRating.push(parseFloat(value.fsp[0]));
						fs2Rating.push(parseFloat(value.fs2[0]));
						fs3Rating.push(parseFloat(value.fs3[0]));
					});
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
					$scope.alerta = true;
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

app.controller("bandas", ["$scope", "$http", "$filter","$q", "ratingMinutosService", "ratingMinutosFactory", "servicios", function ($scope, $http, $filter, $q, ratingMinutosService, ratingMinutosFactory, servicios){
	
	$scope.buscar_bandas = function (){
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
			ee = new Date($scope.fechaSemana2);
			ee.setDate(ee.getDate()+4-(ee.getDay()||7));
			var semanaAnioAnterior = Math.ceil((((ee-new Date(ee.getFullYear(),0,1))/8.64e7)+1)/7);
			if($scope.semanaCalendario0 > semanaAnioAnterior ){
				$scope.fechaSemana2 = new Date($scope.fechaSemana2.getTime() + (7 * 24 * 3600 * 1000));
			}
			if($scope.semanaCalendario0 < semanaAnioAnterior){
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
			var deferred = $q.defer();
			var promises = [];
			angular.forEach(fechas , function(fecha) {
				var promise = ratingMinutosFactory.semanasInformeBandas(fecha);
				promises.push(promise);
			});
			$scope.semanaFinal0.setDate($scope.semanaFinal0.getDate()-1);
			$scope.semanaFinal1.setDate($scope.semanaFinal1.getDate()-1);
			$scope.semanaFinal2.setDate($scope.semanaFinal2.getDate()-1);
			$q.all(promises).then(function (resultados){
				$scope.dataSemana = resultados;
				$scope.loader = false;
				$scope.semana(0);
				$scope.semana(1);
				$scope.semana(2);
				if($scope.dataSemana[0] == 0 && $scope.dataSemana[1] == 0 && $scope.dataSemana[2] == 0){
					$scope.sinData = true;
					$scope.tablas = false;
				}else{
					$scope.tablas = true;
					$scope.sinData = false;
				}
			});
		}else{
			alert("Debe seleccionar una fecha");
		}
	};

	$scope.semana = function(solicitado){

		if($scope.dataSemana[solicitado]!=0){
			var semanaSolicitadaArray = {};
			angular.element(".botonera"+solicitado).find(".btn").removeClass("active");
			angular.element(".botonera"+solicitado).find(".semana"+solicitado).addClass("active");
			semanaSolicitada = $scope.dataSemana[solicitado];
			angular.forEach(semanaSolicitada, function(valores,key){
				hora = key.slice(11,13);
				if(angular.isDefined(semanaSolicitadaArray[hora])){
					semanaSolicitadaArray[hora] = {
						"cdfb": parseFloat(semanaSolicitadaArray[hora]["cdfb"])+parseFloat(valores.cdfb),
						"cdfp": parseFloat(semanaSolicitadaArray[hora]["cdfp"])+parseFloat(valores.cdfp),
						"cdfhd": parseFloat(semanaSolicitadaArray[hora]["cdfhd"])+parseFloat(valores.cdfhd),
						"espn": parseFloat(semanaSolicitadaArray[hora]["espn"])+parseFloat(valores.espn),
						"espnm": parseFloat(semanaSolicitadaArray[hora]["espnm"])+parseFloat(valores.espnm),
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

			$scope["semana1"+solicitado] = {
				"informacion" :	{
					"semana": $scope["semanaCalendario"+solicitado],
					"fechaInicio" : ("0"+$scope["fechaSemana"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["fechaSemana"+solicitado].getMonth()+1)).slice(-2),
					"fechaFinal" : ("0"+$scope["semanaFinal"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["semanaFinal"+solicitado].getMonth()+1)).slice(-2),
					"anio" : $scope["fechaSemana"+solicitado].getFullYear(),
					"dividido": 420
				},
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
			$scope["semana2"+solicitado] = {
				"00" : semanaSolicitadaArray["00"],
				"01" : semanaSolicitadaArray["01"],
				"02" : semanaSolicitadaArray["02"],
				"03" : semanaSolicitadaArray["03"],
				"04" : semanaSolicitadaArray["04"],
				"05" : semanaSolicitadaArray["05"],
			};
			$scope["tablaSemana"+solicitado] = true;
			$scope["errorTablaSemanaActual"+solicitado] = false;
		}else
		{
			$scope["semana1"+solicitado] = {
				"informacion" :	{
					"semana": $scope["semanaCalendario"+solicitado],
					"fechaInicio" : ("0"+$scope.semanaInicio.getDate()).slice(-2)+"/"+("0"+($scope.semanaInicio.getMonth()+1)).slice(-2),
					"fechaFinal" : ("0"+semanaFinal.getDate()).slice(-2)+"/"+("0"+(semanaFinal.getMonth()+1)).slice(-2),
					"anio" : $scope.semanaInicio.getFullYear(),
					"dividido": 420
				}
			};
			$scope["semana"+solicitado] = "";
			$scope["tablaSemana"+solicitado] = false;
			$scope["errorTablaSemana"+solicitado] = true;
		}
	};

	$scope.diaSemana = function(solicitado, dia){
		if($scope.dataSemana[solicitado]!=0){
			angular.element(".botonera"+solicitado).find(".btn").removeClass("active");
			angular.element(".botonera"+solicitado).find(".btn"+dia).addClass("active");
			fechaDia = new Date($scope["fechaSemana"+solicitado]);
			fechaDia.setDate(fechaDia.getDate()+dia);
			fecha1 = fechaDia.getFullYear()+"-"+("0"+(fechaDia.getMonth()+1)).slice(-2)+"-"+("0"+fechaDia.getDate()).slice(-2);
			fechaDia.setDate(fechaDia.getDate()+1);
			fecha2 = fechaDia.getFullYear()+"-"+("0"+(fechaDia.getMonth()+1)).slice(-2)+"-"+("0"+fechaDia.getDate()).slice(-2);
			$scope["semana1"+solicitado] = {
				"informacion" :	{
					"semana": $scope["semanaCalendario"+solicitado],
					"fechaInicio" : ("0"+$scope["fechaSemana"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["fechaSemana"+solicitado].getMonth()+1)).slice(-2),
					"fechaFinal" : ("0"+$scope["semanaFinal"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["semanaFinal"+solicitado].getMonth()+1)).slice(-2),
					"anio" : $scope["semanaFinal"+solicitado].getFullYear(),
					"dividido": 60
				},
				"06" : $scope.dataSemana[solicitado][fecha1+" 06"],
				"07" : $scope.dataSemana[solicitado][fecha1+" 07"],
				"08" : $scope.dataSemana[solicitado][fecha1+" 08"],
				"09" : $scope.dataSemana[solicitado][fecha1+" 09"],
				"10" : $scope.dataSemana[solicitado][fecha1+" 10"],
				"11" : $scope.dataSemana[solicitado][fecha1+" 11"],
				"12" : $scope.dataSemana[solicitado][fecha1+" 12"],
				"13" : $scope.dataSemana[solicitado][fecha1+" 13"],
				"14" : $scope.dataSemana[solicitado][fecha1+" 14"],
				"15" : $scope.dataSemana[solicitado][fecha1+" 15"],
				"16" : $scope.dataSemana[solicitado][fecha1+" 16"],
				"17" : $scope.dataSemana[solicitado][fecha1+" 17"],
				"18" : $scope.dataSemana[solicitado][fecha1+" 18"],
				"19" : $scope.dataSemana[solicitado][fecha1+" 19"],
				"20" : $scope.dataSemana[solicitado][fecha1+" 20"],
				"21" : $scope.dataSemana[solicitado][fecha1+" 21"],
				"22" : $scope.dataSemana[solicitado][fecha1+" 22"],
				"23" : $scope.dataSemana[solicitado][fecha1+" 23"],
			};
			$scope["semana2"+solicitado] = {
				"00" : $scope.dataSemana[solicitado][fecha2+" 00"],
				"01" : $scope.dataSemana[solicitado][fecha2+" 01"],
				"02" : $scope.dataSemana[solicitado][fecha2+" 02"],
				"03" : $scope.dataSemana[solicitado][fecha2+" 03"],
				"04" : $scope.dataSemana[solicitado][fecha2+" 04"],
				"05" : $scope.dataSemana[solicitado][fecha2+" 05"],
			};
			$scope["tablaSemana"+solicitado] = true;
			$scope["errorTablaSemana"+solicitado] = false;
		}
	};

	$scope.lav = function(solicitado){

		if($scope.dataSemana[solicitado]!=0){
			var semanaSolicitadaArray = {};
			angular.element(".botonera"+solicitado).find(".btn").removeClass("active");
			angular.element(".botonera"+solicitado).find(".lav"+solicitado).addClass("active");
			semanaSolicitada = $scope.dataSemana[solicitado];
			fechaLimite = new Date($scope.fechaSemana0.getTime() + (5 * 24 * 3600 * 1000));
			fechaLimite.setHours(6);
			angular.forEach(semanaSolicitada, function(valores,key){
				fecha = new Date(key.slice(0,4), parseInt(key.slice(5,7)-1), parseInt(key.slice(8,10)), parseInt(key.slice(11,13)));
				if(fecha<fechaLimite){
					hora = key.slice(11,13);


					if(angular.isDefined(semanaSolicitadaArray[hora])){
						semanaSolicitadaArray[hora] = {
							"cdfb": parseFloat(semanaSolicitadaArray[hora]["cdfb"])+parseFloat(valores.cdfb),
							"cdfp": parseFloat(semanaSolicitadaArray[hora]["cdfp"])+parseFloat(valores.cdfp),
							"cdfhd": parseFloat(semanaSolicitadaArray[hora]["cdfhd"])+parseFloat(valores.cdfhd),
							"espn": parseFloat(semanaSolicitadaArray[hora]["espn"])+parseFloat(valores.espn),
							"espnm": parseFloat(semanaSolicitadaArray[hora]["espnm"])+parseFloat(valores.espnm),
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

			$scope["semana1"+solicitado] = {
				"informacion" :	{
					"semana": $scope["semanaCalendario"+solicitado],
					"fechaInicio" : ("0"+$scope["fechaSemana"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["fechaSemana"+solicitado].getMonth()+1)).slice(-2),
					"fechaFinal" : ("0"+$scope["semanaFinal"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["semanaFinal"+solicitado].getMonth()+1)).slice(-2),
					"anio" : $scope["fechaSemana"+solicitado].getFullYear(),
					"dividido": 300
				},
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
			$scope["semana2"+solicitado] = {
				"00" : semanaSolicitadaArray["00"],
				"01" : semanaSolicitadaArray["01"],
				"02" : semanaSolicitadaArray["02"],
				"03" : semanaSolicitadaArray["03"],
				"04" : semanaSolicitadaArray["04"],
				"05" : semanaSolicitadaArray["05"],
			};
			$scope["tablaSemana"+solicitado] = true;
			$scope["errorTablaSemanaActual"+solicitado] = false;
		}else
		{
			$scope["semana1"+solicitado] = {
				"informacion" :	{
					"semana": $scope["semanaCalendario"+solicitado],
					"fechaInicio" : ("0"+$scope.semanaInicio.getDate()).slice(-2)+"/"+("0"+($scope.semanaInicio.getMonth()+1)).slice(-2),
					"fechaFinal" : ("0"+semanaFinal.getDate()).slice(-2)+"/"+("0"+(semanaFinal.getMonth()+1)).slice(-2),
					"anio" : $scope.semanaInicio.getFullYear(),
					"dividido": 300
				}
			};
			$scope["semana"+solicitado] = "";
			$scope["tablaSemana"+solicitado] = false;
			$scope["errorTablaSemana"+solicitado] = true;
		}
	};

	$scope.sad = function(solicitado){

		if($scope.dataSemana[solicitado]!=0){
			var semanaSolicitadaArray = {};
			angular.element(".botonera"+solicitado).find(".btn").removeClass("active");
			angular.element(".botonera"+solicitado).find(".sad"+solicitado).addClass("active");
			semanaSolicitada = $scope.dataSemana[solicitado];
			fechaInicio = new Date($scope.fechaSemana0.getTime() + (5 * 24 * 3600 * 1000));
			fechaInicio.setHours(6);
			angular.forEach(semanaSolicitada, function(valores,key){
				fecha = new Date(key.slice(0,4), parseInt(key.slice(5,7)-1), parseInt(key.slice(8,10)), parseInt(key.slice(11,13)));
				if(fecha>=fechaInicio && fecha<=$scope["semanaFinal"+solicitado]){
					hora = key.slice(11,13);
					if(angular.isDefined(semanaSolicitadaArray[hora])){
						semanaSolicitadaArray[hora] = {
							"cdfb": parseFloat(semanaSolicitadaArray[hora]["cdfb"])+parseFloat(valores.cdfb),
							"cdfp": parseFloat(semanaSolicitadaArray[hora]["cdfp"])+parseFloat(valores.cdfp),
							"cdfhd": parseFloat(semanaSolicitadaArray[hora]["cdfhd"])+parseFloat(valores.cdfhd),
							"espn": parseFloat(semanaSolicitadaArray[hora]["espn"])+parseFloat(valores.espn),
							"espnm": parseFloat(semanaSolicitadaArray[hora]["espnm"])+parseFloat(valores.espnm),
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

			$scope["semana1"+solicitado] = {
				"informacion" :	{
					"semana": $scope["semanaCalendario"+solicitado],
					"fechaInicio" : ("0"+$scope["fechaSemana"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["fechaSemana"+solicitado].getMonth()+1)).slice(-2),
					"fechaFinal" : ("0"+$scope["semanaFinal"+solicitado].getDate()).slice(-2)+"/"+("0"+($scope["semanaFinal"+solicitado].getMonth()+1)).slice(-2),
					"anio" : $scope["fechaSemana"+solicitado].getFullYear(),
					"dividido": 60
				},
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
			$scope["semana2"+solicitado] = {
				"00" : semanaSolicitadaArray["00"],
				"01" : semanaSolicitadaArray["01"],
				"02" : semanaSolicitadaArray["02"],
				"03" : semanaSolicitadaArray["03"],
				"04" : semanaSolicitadaArray["04"],
				"05" : semanaSolicitadaArray["05"],
			};
			$scope["tablaSemana"+solicitado] = true;
			$scope["errorTablaSemanaActual"+solicitado] = false;
		}else
		{
			$scope["semana1"+solicitado] = {
				"informacion" :	{
					"semana": $scope["semanaCalendario"+solicitado],
					"fechaInicio" : ("0"+$scope.semanaInicio.getDate()).slice(-2)+"/"+("0"+($scope.semanaInicio.getMonth()+1)).slice(-2),
					"fechaFinal" : ("0"+semanaFinal.getDate()).slice(-2)+"/"+("0"+(semanaFinal.getMonth()+1)).slice(-2),
					"anio" : $scope.semanaInicio.getFullYear(),
					"dividido": 60
				}
			};
			$scope["semana"+solicitado] = "";
			$scope["tablaSemana"+solicitado] = false;
			$scope["errorTablaSemana"+solicitado] = true;
		}
	};

}]);
