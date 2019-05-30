app.controller('indexSubscribersCtrl', function($scope, $q, subscribersService, promocionesService, subscribersPromocionesService, factoria){
	$scope.tamanioModal = "modal-lg";
	$scope.agregar = {};
	$scope.registrarAboandos = function (abonadosCantidad, id, canalId, mesId, enlaceId, segnalId, pagosId){
		promesas = [];
		promesas.push(promocionesService.promoListCompChannel($scope.idEmpresa, canalId));
		promesas.push(subscribersPromocionesService.subsPromo($scope.idEmpresa, $scope.agnoId, mesId, canalId, segnalId));
		$q.all(promesas).then(function (datos){
			$scope.promociones = [];
			$scope.promocionesList = [];
			keysPromocionesList = Object.keys(datos[0].data);
			keysPromocionesListL = keysPromocionesList.length;
			subscribersPromocionesL = datos[1].data.data.length;
			if(keysPromocionesListL){
				for (var iPromoList = keysPromocionesList.length - 1; iPromoList >= 0; iPromoList--) {
					objPromo = {};
					if(subscribersPromocionesL != 0){
						for (var iSubPromo = subscribersPromocionesL - 1; iSubPromo >= 0; iSubPromo--) {
							if(datos[1].data.data[iSubPromo].SubscribersPromocione.promocione_id == keysPromocionesList[iPromoList]){
								delete datos[1].data.data[iSubPromo].SubscribersPromocione.created;
								delete datos[1].data.data[iSubPromo].SubscribersPromocione.modifed;
								objPromo = datos[1].data.data[iSubPromo];
							}
						}
					}
					if(typeof objPromo.SubscribersPromocione === "undefined"){
						objPromo.SubscribersPromocione = {
							promocione_id : keysPromocionesList[iPromoList]
						};
					}
					objPromo.nombre = datos[0].data[keysPromocionesList[iPromoList]];
					$scope.promociones.push(objPromo);
				}	
			}
			$scope.showModal = true;
			$scope.abonados = {
				cantidad : parseInt(abonadosCantidad)
			};
			abonados = {
				id : id,
				agnoId : $scope.agnoId,
				mesId : mesId,
				enlaceId : enlaceId,
				segnalId : segnalId,
				pagosId : pagosId,
				idEmpresa : $scope.idEmpresa,
				pk : canalId
			};
		});
	}

	$scope.add = function (){
		errores = [];
		abonados.value = $scope.abonados.cantidad;
		promesas = [];
		promesas.push(subscribersService.add(abonados));
		promocionesL = $scope.promociones.length;
		if(promocionesL != 0){
			for (var i = promocionesL - 1; i >= 0; i--) {
				propiedadesPromo = Object.keys($scope.promociones[i].SubscribersPromocione);
				propiedadesPromoL = propiedadesPromo.length;
				if((propiedadesPromoL == 1 || propiedadesPromoL == 2) && $scope.promociones[i].SubscribersPromocione.cantidad_abonados === undefined){
					$scope.promociones.splice(i,1);
				}else if(typeof $scope.promociones[i].SubscribersPromocione.id === "undefined"){
					$scope.promociones[i].SubscribersPromocione.company_id = abonados.idEmpresa;
					$scope.promociones[i].SubscribersPromocione.year_id = abonados.agnoId;
					$scope.promociones[i].SubscribersPromocione.month_id = abonados.mesId;
					$scope.promociones[i].SubscribersPromocione.channel_id = abonados.pk;
					$scope.promociones[i].SubscribersPromocione.link_id = abonados.enlaceId;
					$scope.promociones[i].SubscribersPromocione.signal_id = abonados.segnalId;
					$scope.promociones[i].SubscribersPromocione.payment_id = abonados.pagosId;
					if($scope.promociones[i].SubscribersPromocione.cantidad_abonados === undefined){
						$scope.promociones[i].SubscribersPromocione.cantidad_abonados = 0;
					}
				}else{
					if($scope.promociones[i].SubscribersPromocione.cantidad_abonados === undefined){
						$scope.promociones[i].SubscribersPromocione.cantidad_abonados = 0;
					}
				}
			}
			promesas.push(subscribersPromocionesService.add(angular.copy($scope.promociones)));
		}
		$q.all(promesas).then(function (respuestas){
			data = respuestas[0].data;
			$scope.showModal = false;
			if(data == 1 && ((typeof respuestas[1] === "undefined") ? true : ((respuestas[1].data.status == "OK") ? true : false)))
	    	{
	    		window.onload = Exito();
	    		location.reload();
	    		//$('#envioInformeAbonados').modal('show');
	    		//$(".informeAbonados").attr("href","<?php echo $this->Html->url(array('controller'=>'subscribers', 'action'=>'genera_informe_abonado_pdf'))?>/"+mesId+'/'+agnoId+'/'+idEmpresa);
	    	}
	    	if(data == 2 && ((typeof respuestas[1] === "undefined") ? true : ((respuestas[1].data.status == "OK") ? true : false)))
	    	{
	    		$('#envioInformeAbonados').modal('show');
	    		$(".informeAbonados").attr("href",$scope.linkInforme+"/"+parseInt(abonados.mesId)+'/'+parseInt(abonados.agnoId)+'/'+parseInt(abonados.idEmpresa));
	    	}
	    	
	    	if(data == 0 || data == "")
	    	{	
	    		errores.push("Ocurrio un problema al querer registrar los abonados");
	    	}
	    	if(!((typeof respuestas[1] === "undefined") ? true : ((respuestas[1].data.status == "OK") ? true : false))){
	    		errores.push(respuestas[1].data.message);
	    	}
		    if(errores.length!=0){
	    		$(".mensaje").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>'+errores.join("<br/>")+'</strong>.</div>');
	    	}
		});
		
	}

	$scope.agregarPromocion = function (){
		$scope.promociones.push({
			SubscribersPromocione : {
				company_id : abonados.idEmpresa,
				year_id : abonados.agnoId,
				month_id : abonados.mesId,
				channel_id : abonados.pk,
				link_id : abonados.enlaceId,
				signal_id : abonados.segnalId,
				payment_id : abonados.pagosId,
				promocione_id : JSON.parse($scope.agregar.promocion).id,
				promocion_nombre : JSON.parse($scope.agregar.promocion).nombre.toUpperCase()	
			}
		});
		$scope.agregar = {};
		//disabledPromociones();
	};

	function Exito()
	{
		$(".mensaje").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Cantidad de abonados registrado correctamente</strong>.</div>');
	}

	/*disabledPromociones = function (){
		if($scope.promociones.length!=0){
			idPromocionExiste = {};
			for (var i = $scope.promociones.length - 1; i >= 0; i--) {
				idPromocionExiste[$scope.promociones[i].SubscribersPromocione.promocione_id] = true;;
			}
			for (var i = $scope.promocionesList.length - 1; i >= 0; i--) {
				if(typeof idPromocionExiste[$scope.promocionesList[i].id] !== "undefined"){
					$scope.promocionesList[i].disabled = true;	
				}else{
					if(typeof $scope.promocionesList[i].disabled !== "undefined"){
						delete $scope.promocionesList[i].disabled;
					}
				}
			}
		}		
	}*/
});

app.controller('generaInformeAbonadoPdfSubscribersCtrl', ['$scope', function ($scope) {
	$scope.parametros = function (correos, anio, mes){
		$('#subscribersEmail').select2({ tags: correos });
		document.getElementById("subscribersCodigoHtmlPdf").value = '<table border="0" cellspacing="0"><tr><td width="100"><img src="http://192.168.1.22/img/cdf_pdf.jpg" width="100"/></td><td><strong>INFORME ABONADOS </strong><br/>sgi.cdf.cl<br/>'+mes+' - '+anio+'</td></tr></table><br/>'+document.getElementById("cuerpoHtmlTabla").innerHTML;
		document.getElementById("subscribersCodigoHtml").value = '<table border="0" cellspacing="0"><tr><td width="100"><img src="http://192.168.1.22/img/cdf_pdf.jpg" width="100"/></td><td><strong>INFORME ABONADOS </strong><br/>sgi.cdf.cl<br/>'+mes+' - '+anio+'</td></tr></table><br/>'+document.getElementById("cuerpoHtmlTabla").innerHTML;
	};
	$scope.generarPdf = function (evento){
		document.getElementById("subscribersInformeAbonadoPdfForm").submit();
	};
}]);

app.controller('graficosSubscribersCtrl', ['$scope', "$q", "$timeout", 'subscribersService', "yearsService", "monthsService",'Flash', function ($scope, $q, $timeout, subscribersService, yearsService, monthsService, Flash) {
	$scope.activo = undefined;
	var years = {};
	var months = {};
	var companiesSubscribers = [];
	var headers = {};
	var idCanal = undefined;
	$scope.evolucionSubscribers = {	
		options: {
			chart: {
				type: 'line',
				zoomType: 'xy'
			},
			tooltip: {
				style: {
					padding: 10,
					fontWeight: 'bold'
				},
				shared: true,
			},
			title : {
				text : "Evolución de abonados",
				useHTML : true
			},
			yAxis: {
				title: {
					text: 'Cantidad abonados'
				},
				min : 0
			},
			xAxis: {
				title: {
					text: 'Meses'
				},
			},
			lang: {
	            noData: "Sin información",
	            loading : "Cargando",
	            printChart : "Imprimir grafico",
	        },
	        noData: {
	            style: {
	                fontWeight: 'bold',
	                fontSize: '15px',
	                color: '#303030'
	            }
	        }
		},
		series : []
	};
	$q.all([yearsService.yearsList(), monthsService.monthsList(), subscribersService.companiesSubscribers()]).then(function (data){
		function listPorId(lista){
			respuesta = {};
			listaL = lista.length;
			for (var i = listaL - 1; i >= 0; i--) {
				respuesta[lista[i]["id"]] = lista[i]["nombre"];
			}
			return respuesta;
		}
		yearsList = (data[0].data.data.length != 0) ? listPorId(data[0].data.data) : [];
		monthsList = (data[1].data.length != 0) ? listPorId(data[1].data) : [];
		companiesSubscribers = data[2].data;
		tablaColores = {
			13 : {color : "#000000", simbolo : "triangle"},
			14 : {color : "#ff0000", simbolo : "circle"},
			15 : {color : "#7AB800", simbolo : "diamond"},
			31 : {color : "#166AB6", simbolo : "square"},
			32 : {color : "#FF6700", simbolo : "triangle-down"},
			33 : {color : "#B00000", simbolo : "triangle"},
			46 : {color : "#64B705", simbolo : "circle"},
		};
	});
	$scope.buscarDatos = function (){
		$scope.evolucionSubscribers.loading = true;
		subscribersService.subscribersTreceMeses($scope.yearId, $scope.monthId).success(function (datos){
			$scope.contendio = false;
			if(datos.status == "OK"){
				$scope.evolucionSubscribers.options.xAxis.categories = [];
				data = datos.data.rows;
				headers = datos.data.headers;
				years = Object.keys(datos.data.headers);
				yearsL = years.length;
				for (var iYears = 0; iYears < yearsL; iYears++) {
					months = headers[years[iYears]];
					monthsL = months.length;
					for (var iMonths = 0; iMonths < monthsL; iMonths++) {
						$scope.evolucionSubscribers.options.xAxis.categories.push(monthsList[months[iMonths]]+" "+yearsList[years[iYears]]);
					}
				}
			}else if(datos.status == "ERROR"){
				Flash.create();
			}else{

			}
			($scope.activo == undefined) ? $scope.canal(1) : (($scope.activo == 0) ? $scope.penetracion() : $scope.canal($scope.activo)) ;
			$scope.contenido = false;
			$scope.loader = false;
			$scope.evolucionSubscribers.loading = false;
		});
	}

	$scope.canal = function (idCanal){
		$scope.activo = idCanal;
		tipos = Object.keys(data);
		tiposL = tipos.length;
		$scope.evolucionSubscribers.options.tooltip.pointFormat = "{series.name}: <b>{point.y}</b><br/>";
		$scope.evolucionSubscribers.options.title.text = "Evolución de abonados ";
		$scope.evolucionSubscribers.series = [];
		for (var iTipos = 0; iTipos < tiposL; iTipos++) {
			switch(tipos[iTipos]){
				case "noagrupados" :
					if(typeof data["noagrupados"][idCanal] !== "undefined"){
						companies = Object.keys(data["noagrupados"][idCanal]);
						companiesL = companies.length;
						for (var iCompanies = 0; iCompanies < companiesL; iCompanies++) {
							if(typeof data["noagrupados"][idCanal][companies[iCompanies]] !== "undefined"){						
								objSerie = {
									name : companiesSubscribers[companies[iCompanies]].toUpperCase(),
									data : [],
								};
								if(typeof tablaColores[companies[iCompanies]] !== "undefined"){
									objSerie.color = tablaColores[companies[iCompanies]].color;
									objSerie.marker = {
										symbol: tablaColores[companies[iCompanies]].simbolo
									};
								}
								for (var iYears = 0; iYears < yearsL; iYears++) {
									monthsL = headers[years[iYears]].length;
									for (var iMonths = 0; iMonths < monthsL; iMonths++) {
										if(typeof data["noagrupados"][idCanal][companies[iCompanies]][years[iYears]] !== "undefined"){
											if(typeof data["noagrupados"][idCanal][companies[iCompanies]][years[iYears]][headers[years[iYears]][iMonths]]!== "undefined"){
												objSerie.data.push(parseInt(data["noagrupados"][idCanal][companies[iCompanies]][years[iYears]][headers[years[iYears]][iMonths]]));
											}else{
												objSerie.data.push(0);
											}
										}else{
											objSerie.data.push(0);
										}
									}
								}
								$scope.evolucionSubscribers.series.push(objSerie);
							}
						}	
					}
				break;
				default :
					if(typeof data[tipos[iTipos]][idCanal] !== "undefined"){
						objSerie = {
							name : (tipos[iTipos] == "agrupados") ? "OTROS" : "TOTALES",
							marker : {
								symbol : (tipos[iTipos] == "agrupados") ? "diamond" : "square",
							},
							color : (tipos[iTipos] == "agrupados") ? "#0000ff" : "#009933",
							data : []
						};
						for (var iYears = 0; iYears < yearsL; iYears++) {
							monthsL = headers[years[iYears]].length;
							for (var iMonths = 0; iMonths < monthsL; iMonths++) {
								if(typeof data[tipos[iTipos]][idCanal][years[iYears]] !== "undefined"){
									if(typeof data[tipos[iTipos]][idCanal][years[iYears]][headers[years[iYears]][iMonths]] !== "undefined"){
										objSerie.data.push(parseInt(data[tipos[iTipos]][idCanal][years[iYears]][headers[years[iYears]][iMonths]]));
									}else{
										objSerie.data.push(0);
									}
								}else{
									objSerie.data.push(0);
								}
							}
						}
						$scope.evolucionSubscribers.series.push(objSerie);
					}
				break;
			}
		}
	};

	$scope.penetracion = function (){
		$scope.activo = 0;
		$scope.evolucionSubscribers.series = [];
		$scope.evolucionSubscribers.options.tooltip.pointFormat = "{series.name}: <b>{point.y:,.2f} %</b><br/>";
		if(typeof data["noagrupados"] !== "undefined"){
			if(typeof data["noagrupados"][1] !== "undefined" && (typeof data["noagrupados"][2] !== "undefined" || typeof data["noagrupados"][3] !== "undefined")){
				companies = Object.keys(data["noagrupados"][1]);
				companiesL = companies.length;
				for (var iCompanies = 0; iCompanies < companiesL; iCompanies++) {
					if(typeof data["noagrupados"][1][companies[iCompanies]] !== "undefined"){
						objSerie = {
							name : companiesSubscribers[companies[iCompanies]].toUpperCase(),
							data : [],
						};
						if(typeof tablaColores[companies[iCompanies]] !== "undefined"){
							objSerie.color = tablaColores[companies[iCompanies]].color;
							objSerie.marker = {
								symbol: tablaColores[companies[iCompanies]].simbolo
							};
						}
						for (var iYears = 0; iYears < yearsL; iYears++) {
							monthsL = headers[years[iYears]].length;
							for (var iMonths = 0; iMonths < monthsL; iMonths++) {
								cdfP = 0;
								cdfHd = 0;
								if(typeof data["noagrupados"][1][companies[iCompanies]][years[iYears]] !== "undefined"){
									if(typeof data["noagrupados"][1][companies[iCompanies]][years[iYears]][headers[years[iYears]][iMonths]]!== "undefined"){
										if(typeof data["noagrupados"][2] !== "undefined"){
											if(typeof data["noagrupados"][2][companies[iCompanies]] !== "undefined"){
												if(typeof data["noagrupados"][2][companies[iCompanies]][years[iYears]] !== "undefined"){
													if(typeof data["noagrupados"][2][companies[iCompanies]][years[iYears]][headers[years[iYears]][iMonths]]!== "undefined"){
														cdfP = parseInt(data["noagrupados"][2][companies[iCompanies]][years[iYears]][headers[years[iYears]][iMonths]]);
													}
												}
											}
										}
										if(typeof data["noagrupados"][3] !== "undefined"){
											if(typeof data["noagrupados"][3][companies[iCompanies]] !== "undefined"){
												if(typeof data["noagrupados"][3][companies[iCompanies]][years[iYears]] !== "undefined"){
													if(typeof data["noagrupados"][3][companies[iCompanies]][years[iYears]][headers[years[iYears]][iMonths]]!== "undefined"){
														cdfHd = parseInt(data["noagrupados"][3][companies[iCompanies]][years[iYears]][headers[years[iYears]][iMonths]]);
													}
												}
											}
										}
										objSerie.data.push(parseFloat((((cdfP+cdfHd)/parseInt(data["noagrupados"][1][companies[iCompanies]][years[iYears]][headers[years[iYears]][iMonths]]))*100).toFixed(2)));
									}else{
										objSerie.data.push(0);
									}
								}else{
									objSerie.data.push(0);
								}
							}
						}
						$scope.evolucionSubscribers.series.push(objSerie);
					}
				}	
			}
		}
		if(typeof data["agrupados"] !== "undefined"){
			if(typeof data["agrupados"][1] !== "undefined" && (typeof data["agrupados"][2] !== "undefined" || typeof data["agrupados"][3] !== "undefined")){
				objSerie = {
					name : "OTROS",
					data : [],
				};
				for (var iYears = 0; iYears < yearsL; iYears++) {
					monthsL = headers[years[iYears]].length;
					for (var iMonths = 0; iMonths < monthsL; iMonths++) {
						cdfP = 0;
						cdfHd = 0;
						if(typeof data["agrupados"][1][years[iYears]] !== "undefined"){
							if(typeof data["agrupados"][1][years[iYears]][headers[years[iYears]][iMonths]]!== "undefined"){
								if(typeof data["agrupados"][2] !== "undefined"){
									if(typeof data["agrupados"][2] !== "undefined"){
										if(typeof data["agrupados"][2][years[iYears]] !== "undefined"){
											if(typeof data["agrupados"][2][years[iYears]][headers[years[iYears]][iMonths]]!== "undefined"){
												cdfP = parseInt(data["agrupados"][2][years[iYears]][headers[years[iYears]][iMonths]]);
											}
										}
									}
								}
								if(typeof data["agrupados"][3] !== "undefined"){
									if(typeof data["agrupados"][3] !== "undefined"){
										if(typeof data["agrupados"][3][years[iYears]] !== "undefined"){
											if(typeof data["agrupados"][3][years[iYears]][headers[years[iYears]][iMonths]]!== "undefined"){
												cdfHd = parseInt(data["agrupados"][3][years[iYears]][headers[years[iYears]][iMonths]]);
											}
										}
									}
								}
								objSerie.data.push(parseFloat((((cdfP+cdfHd)/parseInt(data["agrupados"][1][years[iYears]][headers[years[iYears]][iMonths]]))*100).toFixed(2)));
							}else{
								objSerie.data.push(0);
							}
						}else{
							objSerie.data.push(0);
						}
					}
				}
				$scope.evolucionSubscribers.series.push(objSerie);
			}
		}
	}
}])