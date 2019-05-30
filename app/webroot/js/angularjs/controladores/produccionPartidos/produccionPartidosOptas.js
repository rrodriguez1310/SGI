"use strict";
app.controller( "conciliacionOptaProd" , ["$scope", "$http","$filter", "produccionPartidosOptas", "Flash", "$timeout", "$window", "$rootScope", function($scope, $http, $filter, produccionPartidosOptas, Flash, $timeout, $window, $rootScope) {

    $scope.loader = true;
	$scope.cargador = loader;

    $scope.tablaDetalle = false;
    $scope.btnLoader = false;
    $scope.btnCampeonato = false;
    $scope.btnSync = false;

	$scope.gridOptions = {
		columnDefs: [
            { name:'id', displayName: 'Id', width:60, enableCellEdit: false, type: 'number'},
            { name:'opta_game_id', displayName: 'Id Opta', width:85, enableCellEdit: true, type: 'number'},
            { name:'senales', displayName: 'Señales',  enableCellEdit: false},	
			{ name:'nombre_torneo', displayName: 'Torneo',  enableCellEdit: false},	
            { name:'fecha_partido', displayName: 'Día', type: 'date', cellFilter: 'date:"yyyy-MM-dd"', width:85, enableCellEdit: false, sort: { direction: 'desc' }},
            { name:'hora_transmision', displayName: 'Tx', type: 'date', cellFilter: 'date:"hh:mm"', width:70, enableCellEdit: false},
            { name:'hora_partido', displayName: 'KickOff', type: 'date', cellFilter: 'date:"hh:mm"', width:70, enableCellEdit: false},            
            { name:'hora_termino_transmision', displayName: 'Fin Tx', type: 'date', cellFilter: 'date:"hh:mm"', width:70, enableCellEdit: false},
			{ name:'estadio', displayName: 'Estadio', enableCellEdit: false},
			{ name:'equipo_local', displayName: 'Local', enableCellEdit: false},
            { name:'equipo_visita', displayName: 'Visita', enableCellEdit: false},
            { name:'produccion_partidos_opta_id', displayName: 'Ok', cellTemplate:"<div class='ui-grid-cell-contents text-center' ng-if="+'"'+"row['entity']['produccion_partidos_opta_id']!==undefined"+'"'+"><i class='fa fa-check'></i></div>", enableCellEdit: false, width:45}
        ],
        enableFiltering: true,
		enableSelectAll: false,
		multiSelect: false,
		onRegisterApi: function(gridApi){
			$scope.gridApi = gridApi;
		}
    };

    $scope.gridOptionsOpta = {
        columnDefs: [
            { name:'partidoId', displayName: 'Id Partido', width:100},
            { name:'campeonato', displayName: 'Torneo'},	
            { name:'dia_opta', displayName: 'Día', type: 'date', cellFilter: 'date:"yyyy-MM-dd"', width:85 },
            { name:'hora_opta', displayName: 'KickOff', type: 'date', cellFilter: 'date:"hh:mm"', width:70},                
            { name:'estadio', displayName: 'Estadio'},
            { name:'localNombre', displayName: 'Local'},
            { name:'visitalNombre', displayName: 'Visita'},		
        ],
        enableFiltering: true,
        enableSelectAll: false,
        multiSelect: false,            
        onRegisterApi: function(gridApi2){
            $scope.gridApi2 = gridApi2;            
        }
    };

    /*$scope.obtInfoPartidos = function(partidos){
        partidos.forEach(function(item,index){
            if ($scope.campeonatosList.filter(e => e.id == item["torneo_id"]).length == 0){
                $scope.campeonatosList.push({
                    "id": item["torneo_id"],
                    "nombre": item["torneo"]
                });
            }
        });
    }; */

    produccionPartidosOptas.dataPartidos().success(function(data){        
        var partidos = data;
        $scope.campeonatosList = [];
        $scope.selectCampeonato = {};
        //$scope.obtInfoPartidos(partidos);
        $scope.gridOptionsOpta.data = [];
        $scope.gridOptions.data = partidos;               

        /*$scope.$watch('selectCampeonato.id', function(format){
            var partidoSelect = [];

            if (typeof $scope.selectCampeonato.id !== 'undefined'){
                $scope.btnCampeonato = true;

                partidos.forEach(function(item,index){                    
                    if (item["torneo_id"] == $scope.selectCampeonato.id) {
                        partidoSelect.push(item);
                    }
                });
            }
            $scope.gridOptions.data = partidoSelect;
        });*/

    });

    $scope.loader = false;
    $scope.tablaDetalle = true;
    
    //$scope.loader = false;
    //$scope.tablaDetalle = true;
   
    

    $scope.obtDatosOpta = function(){
        $scope.btnLoader = true;
        if (typeof $scope.idCompetition !== 'undefined' && $scope.idSeason !== 'undefined'){
            produccionPartidosOptas.fixtureOpta($scope.idSeason, $scope.idCompetition).success(function(opta){
                $scope.btnLoader = false;
                if (opta.estado == 1) {
                    $scope.gridOptionsOpta.data = opta.data;
                } else {
                    Flash.create('danger', opta.mensaje, 'customAlert');
                }
            }).error(function(data, status){
                console.log(data);
            });
        }
    };

    $scope.gridOptions.onRegisterApi = function(gridApi) {
        $scope.gridApi = gridApi;
        gridApi.edit.on.afterCellEdit($scope, function(rowEntity, colDef, newValue, oldValue) {

            if (typeof newValue == 'number') {

                if (rowEntity.id != "") {

                    var partidosOpta = [{
                        "id": typeof rowEntity.produccion_partidos_opta_id !== 'undefined' ? rowEntity.produccion_partidos_opta_id : undefined,                            
                        "opta_game_id": Number(newValue),
                        "produccion_partidos_evento_id": rowEntity.id                            
                    }];

                    var partidoAltavoz = [{                            
                        "idPartido": Number(newValue),
                        "inicio_transmision": rowEntity.fecha_partido + ' ' + rowEntity.hora_transmision,
                        "termino_transmision": rowEntity["fecha_partido"] +' '+ rowEntity["hora_termino_transmision"],
                        "senales": rowEntity.senales_id,
                    }];

                    partidosOpta = JSON.parse(JSON.stringify(partidosOpta)); // limpiar

                    var dataPush = {
                        "cdf" : partidosOpta,
                        "altavoz" : partidoAltavoz
                    };
                    console.log(dataPush);
                    
                    produccionPartidosOptas.guardarDataPartidos(dataPush).success(function(data){
                        console.log(data);
                        if (data.estado == 1){
                            produccionPartidosOptas.dataPartidos().success(function(datos){
                                $scope.gridOptions.data = datos;
                                //$scope.obtInfoPartidos(datos);
                                Flash.create('success', data.mensaje, 'customAlert');    
                            });                                
                        } else {                                
                            Flash.create('danger', data.mensaje, 'customAlert');                                
                           // window.location.href = host+"produccion_partidos_optas";
                        }
                    });

                } else {
                    alert("No se puede registrar falta información");
                }

            } else {
                alert("El ID partido debe ser numérico");
            }                
                       
        });
    };

    $scope.setDatosOptaAll = function() {
        $scope.btnSync = true;
        var datosAltavoz = [];
        if ($scope.gridOptions.data.length>0){

            $scope.gridOptions.data.forEach(function(item, key){              
                console.log(item["opta_game_id"]);
                if (typeof item["opta_game_id"] !== 'undefined' && item["opta_game_id"] != '') {
                    datosAltavoz.push({
                        "idPartido": item["opta_game_id"],
                        "inicio_transmision": item["fecha_partido"] +' '+ item["hora_transmision"],
                        "termino_transmision": item["fecha_partido"] +' '+ item["hora_termino_transmision"],
                        "senales": item["senales_id"]
                    });
                }
            });
            if (datosAltavoz.length>0){
                var dataPush = { 
                    "altavoz" : datosAltavoz
                };
                console.log(dataPush);
                produccionPartidosOptas.guardarDataPartidos(dataPush).success(function(data){
                    console.log(data);
                    if (data.estado == 1){
                        produccionPartidosOptas.dataPartidos().success(function(datos){
                            //$scope.obtInfoPartidos(datos);
                            $scope.gridOptions.data = datos;
                            Flash.create('success', data.mensaje, 'customAlert');
                            $scope.btnSync = false;
                        });
                    } else {                                
                        $scope.btnSync = false;
                        Flash.create('danger', data.mensaje, 'customAlert');                
                    }
                });
            } else {
                $scope.btnSync = false;
            }        
        }
    };

}]);