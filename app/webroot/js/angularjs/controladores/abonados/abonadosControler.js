app.controller('abonadosCtrl', function ($scope, abonados) {
    var nombreSegnal = "";
    var fecha = "";
    $scope.onEditChange = function () {
        fecha = $scope.fecha
    };
    var tipoSegnal = "";
    var penetracionDirectv = [];
    var penetracionMovistar = [];
    var penetracionClaro = [];
    var penetracionVtr = [];
    var penetracionEntel = [];
    var penetracionGtd = [];
    var penetracionTelsur = [];

    var categoriasArray = [];
    var abonadosDirecTv = [];
    var abonadosDirecTvPresup = [];
    var abonadosMovistar = [];
    var abonadosMovistarPresup = [];
    var abonadosClaro = [];
    var abonadosClaroPresup = [];
    var abonadosVTR = [];
    var abonadosVTRPresup = [];
    var abonadosOtros = [];
    var abonadosOtrosPresup = [];
    var abonadosEntel = [];
    var abonadosEntelPresup = [];
    var abonadosGtd = [];
    var abonadosGtdPresup = [];
    var abonadosTelsur = [];
    var abonadosTelsurPresup = [];
    var penetracionOtros = [];
    var abonadosTotales = [];
    var abonadosTotalesPenetracion = [];


    var nombreDirecTv = "";
    var nombreMovistar = "";

    $scope.segnal = function(segnal){
        //$scope.loader = true
        //$scope.cargador = loader;

        if(segnal == 1)
        {
            $scope.activoBasico = "active";
            $scope.activoPremium = "";
            $scope.activoHd = "";
            $scope.titulo = "CDF Básico" ; 
            nombreSegnal = "CDF Basico";
            $scope.activoPenetracion = "";
        }

        if(segnal == 2)
        {
            $scope.activoPremium = "active";
            $scope.activoBasico = "";
            $scope.activoHd = "";
            $scope.titulo = "CDF Premium";
            nombreSegnal = "CDF Premium";
            $scope.activoPenetracion = "";   
        }

        if(segnal == 3)
        {
            $scope.activoHd = "active";
            $scope.activoPremium = "";
            $scope.activoBasico = "";
            $scope.titulo = "CDF HD";
            nombreSegnal = "CDF HD";
            $scope.activoPenetracion = "";
        }

        if(segnal == 4)
        {
            $scope.activoPenetracion = "active";
            $scope.activoPremium = "";
            $scope.activoBasico = "";
            $scope.activoHd = "";
            $scope.titulo = "Penetración";
            nombreSegnal = "penetracion";
        }

        tipoSegnal = nombreSegnal;
        abonados.listaAbonados(fecha).success(function(abonados){
            
            categoriasArray.length = 0;
            abonadosDirecTv.length = 0;
            abonadosDirecTvPresup.length = 0;
            abonadosMovistar.length = 0;
            abonadosMovistarPresup.length = 0;
            abonadosClaro.length = 0;
            abonadosClaroPresup.length = 0;
            abonadosVTR.length = 0;
            abonadosVTRPresup.length = 0;
            abonadosOtros.length = 0;
            abonadosOtrosPresup.length = 0;
            abonadosEntel.length = 0;
            abonadosEntelPresup.length = 0;
            abonadosGtd.length = 0;
            abonadosGtdPresup.length = 0;
            abonadosTelsur.length = 0;
            abonadosTelsurPresup.length = 0;
            

            penetracionDirectv.length = 0;
            penetracionMovistar.length = 0;
            penetracionClaro.length = 0;
            penetracionVtr.length = 0;
            penetracionEntel.length = 0;
            penetracionGtd.length = 0;
            penetracionTelsur.length = 0;
            penetracionOtros.length = 0;

            abonadosTotales.length = 0;
            abonadosTotalesPenetracion.length = 0;

            angular.forEach(abonados, function(item, keyAgno){
                angular.forEach(item, function(itemMes, keyMes){
                    
                    categoriasArray.push(keyMes + ' ' +keyAgno)
                    
                    angular.forEach(itemMes, function(itemOperador, keyOperador){
                        angular.forEach(itemOperador, function(itemIdAbonados, keyIdAbonados){

                            if(keyMes == "Enero")
                                keyMes = "Ene.";

                            if(keyMes == "Febrero")
                                keyMes = "Feb.";   

                            if(keyMes == "Marzo")
                                keyMes = "Mar.";   

                            if(keyMes == "Abril")
                                keyMes = "Abr.";   

                            if(keyMes == "Mayo")
                                keyMes = "May.";   

                            if(keyMes == "Junio")
                                keyMes = "Jun.";   

                            if(keyMes == "Julio")
                                keyMes = "Jul.";   

                            if(keyMes == "Agosto")
                                keyMes = "Ago.";   

                            if(keyMes == "Septiembre")
                                keyMes = "Sep.";   

                            if(keyMes == "Octubre")
                                keyMes = "Oct.";   

                            if(keyMes == "Noviembre")
                                keyMes = "Nov.";   

                            if(keyMes == "Diciembre")
                                keyMes = "Dic.";

                            
                            if(tipoSegnal != "penetracion")
                            {
                                if(keyIdAbonados === tipoSegnal && keyOperador === "DirecTV")
                                { 
                                    abonadosDirecTv.push(itemIdAbonados[0]['totalAbonado'])

                                    if(!angular.isUndefined(itemIdAbonados.presupuestados))
                                    {
                                        abonadosDirecTvPresup.push(Number(itemIdAbonados.presupuestados.totalAbonadoPresupuestados))
                                        return nombreDirecTv = "P.DirecTv"
                                    }
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "Telefónica Empresas Chile S.A.")
                                {
                                    abonadosMovistar.push(itemIdAbonados[0]['totalAbonado'])
                                    if(!angular.isUndefined(itemIdAbonados.presupuestados))
                                    {
                                        abonadosMovistarPresup.push(itemIdAbonados.presupuestados.totalAbonadoPresupuestados)
                                    }
                                    
                                    return nombreMovistar = "P.Movistar"
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "Claro Comunicaciones")
                                {
                                    abonadosClaro.push(itemIdAbonados[0]['totalAbonado'])
                                    if(!angular.isUndefined(itemIdAbonados.presupuestados))
                                    {
                                        abonadosClaroPresup.push(Number(itemIdAbonados.presupuestados.totalAbonadoPresupuestados))
                                         return nombreMovistar = "P.Claro"
                                    }
                                    
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "VTR")
                                {
                                    abonadosVTR.push(itemIdAbonados[0]['totalAbonado'])
                                    if(!angular.isUndefined(itemIdAbonados.presupuestados))
                                    {
                                        abonadosVTRPresup.push(Number(itemIdAbonados.presupuestados.totalAbonadoPresupuestados))
                                         return nombreMovistar = "P.Vtr"
                                    }
                                    
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "Entel")
                                {
                                    abonadosEntel.push(itemIdAbonados[0]['totalAbonado'])
                                    if(!angular.isUndefined(itemIdAbonados.presupuestados))
                                    {
                                       abonadosEntelPresup.push(Number(itemIdAbonados.presupuestados.totalAbonadoPresupuestados))
                                        return nombreMovistar = "P.Entel"
                                    }
                                    
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "GTD")
                                {
                                    abonadosGtd.push(itemIdAbonados[0]['totalAbonado'])

                                    if(!angular.isUndefined(itemIdAbonados.presupuestados))
                                    {
                                       abonadosGtdPresup.push(Number(itemIdAbonados.presupuestados.totalAbonadoPresupuestados))
                                        return nombreMovistar = "P.Gtd"
                                    }
                                    
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "Telsur")
                                {
                                    abonadosTelsur.push(itemIdAbonados[0]['totalAbonado'])
                                    if(!angular.isUndefined(itemIdAbonados.presupuestados))
                                    {
                                       abonadosTelsurPresup.push(Number(itemIdAbonados.presupuestados.totalAbonadoPresupuestados))
                                        return nombreMovistar = "P.Telsur"
                                    }
                                    
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "otros")
                                {
                                    abonadosOtros.push(Number(itemIdAbonados[0]['totalAbonado']))
                                    //xx.push(Number(itemIdAbonados[0]['totalAbonado']))
                                    //console.log(itemIdAbonados[0]['totalAbonado']);

                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "otrosPresupuestados")
                                {
                                    abonadosOtrosPresup.push(Number(itemIdAbonados[0]['totalAbonado']))
                                } 
                            }
                            
                            if(tipoSegnal === "penetracion")
                            { 
                                if(keyIdAbonados === tipoSegnal && keyOperador === "DirecTV")
                                {
                                    //categoriasArray.push(keyMes + ' ' +keyAgno)
                                    penetracionDirectv.push(Number(itemIdAbonados[0]['penetracion']))
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "Telefónica Empresas Chile S.A.")
                                {
                                    penetracionMovistar.push(Number(itemIdAbonados[0]['penetracion']))
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "Claro Comunicaciones")
                                {
                                    penetracionClaro.push(Number(itemIdAbonados[0]['penetracion']))
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "VTR")
                                {
                                    penetracionVtr.push(Number(itemIdAbonados[0]['penetracion']))
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "Entel")
                                {
                                    penetracionEntel.push(Number(itemIdAbonados[0]['penetracion']))
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "GTD")
                                {
                                    penetracionGtd.push(Number(itemIdAbonados[0]['penetracion']))
                                }

                                if(keyIdAbonados === tipoSegnal && keyOperador === "Telsur")
                                {
                                    penetracionTelsur.push(Number(itemIdAbonados[0]['penetracion']))
                                }
                                
                                if(keyIdAbonados === tipoSegnal && keyOperador === "Otrospenetracion")
                                {
                                    penetracionOtros.push(Number(itemIdAbonados))
                                }
                                
                            }
                        });
                    });
                });


        
            });
           $scope.otros = abonadosOtros;

            angular.forEach(abonadosDirecTv, function(value, key){
                abonadosTotales.push(Number(value) + Number(abonadosMovistar[key]) + Number(abonadosClaro[key]) + Number(abonadosVTR[key]) + Number(abonadosEntel[key]) + Number(abonadosGtd[key]) + Number(abonadosTelsur[key]) + Number(abonadosOtros[key]));
            });
            $scope.totalAbonados = abonadosTotales;

            angular.forEach(penetracionDirectv, function(value, key){
                abonadosTotalesPenetracion.push( Number(value) + Number(penetracionMovistar[key]) + Number(penetracionClaro[key]) + Number(penetracionVtr[key]) + Number(penetracionEntel[key]) + Number(penetracionGtd[key]) + Number(penetracionTelsur[key]) + Number(penetracionOtros[key]) )
            });

            $scope.totalesPenetracion = abonadosTotalesPenetracion;


            if(tipoSegnal != "penetracion")
            {

                $scope.showTitulo = true;   
                $scope.tablaAbonados = true;
                $scope.tablaPenetracion = false;
                $scope.cabecera = categoriasArray;
                $scope.direcTv = abonadosDirecTv;
                $scope.movistar = abonadosMovistar;
                $scope.claro = abonadosClaro;
                $scope.vtr = abonadosVTR;
                $scope.entel = abonadosEntel;
                $scope.gtd = abonadosGtd;
                $scope.telsur = abonadosTelsur;

                $scope.contenedorGraficos = true;
                
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
                        categories: categoriasArray
                    },
                    series: [{
                            name : 'DirecTv',
                            data: abonadosDirecTv
                        },
                        {
                            name: 'Movistar',
                            data: abonadosMovistar
                        },
                        {
                            name: 'Claro',
                            data: abonadosClaro   
                        },

                        {
                            name : 'Vtr',
                            data : abonadosVTR
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

                            name : 'Telsur',
                            data : abonadosTelsur
                        },
                        {
                            name : 'Otros',
                            data : abonadosOtros
                        },

                        {
                            name : nombreDirecTv,
                            data : abonadosDirecTvPresup
                        },
                        {
                            name : 'P.Movistar',
                            data : abonadosMovistarPresup
                        },
                        {
                            name: 'P.Claro',
                            data: abonadosClaroPresup   
                        },
                        {
                            name : 'P.Vtr',
                            data : abonadosVTRPresup
                        },
                        {
                            name : 'P.Entel',
                            data : abonadosEntelPresup
                        },
                        {
                            name : 'P.Gtd',
                            data : abonadosGtdPresup
                        },
                        {
                            name : 'P.Telsur',
                            data : abonadosTelsurPresup
                        },
                        {
                            name : "P.Otros",
                            data : abonadosOtrosPresup
                        }
                    ],
                    title: {
                        text: ''
                    },
                    loading: false
                } 
            }


            if(tipoSegnal === "penetracion")
            {
                $scope.tablaAbonados = false;
                $scope.tablaPenetracion = true;

                $scope.cabecera = categoriasArray;
                $scope.penetracionDirectv = penetracionDirectv;
                $scope.penetracionMovistar = penetracionMovistar;
                $scope.penetracionClaro = penetracionClaro;
                $scope.penetracionVtr = penetracionVtr;
                $scope.penetracionEntel = penetracionEntel;
                $scope.penetracionGtd = penetracionGtd;
                $scope.penetracionTelsur = penetracionTelsur;
                $scope.penetracionOtros = penetracionOtros;
                $scope.contenedorGraficos = true;

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
                        categories: categoriasArray
                    },
                    series: [{
                            name : 'DirecTv',
                            data: penetracionDirectv
                        },
                        {
                            name : 'Movistar',
                            data : penetracionMovistar 
                        },
                        {
                            name : 'Claro',
                            data : penetracionClaro
                        },
                        {
                            name : 'Vtr',
                            data : penetracionVtr
                        },
                        {
                            name : 'Entel',
                            data : penetracionEntel
                        },
                        {
                            name : 'Gtd',
                            data : penetracionGtd
                        },
                        {
                            name : 'Telsur',
                            data : penetracionTelsur
                        },
                        {
                            name : 'Otros',
                            data : penetracionOtros
                        }
                    ],
                    title: {
                        text: ''
                    },
                    loading: false
                } 
            }


        });
    }

    $scope.highchartsNG = {
        title: {
            text: ''
        },
    }
});