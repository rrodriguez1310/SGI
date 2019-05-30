"use strict";
appTextEditor.config(function($provide){
	$provide.decorator('taOptions', ['taRegisterTool', '$delegate', function(taRegisterTool, taOptions){
		taOptions.toolbar = [
			['h1', 'h2', 'h3', 'h4','p'],
			['bold', 'italics', 'underline', 'ul', 'ol']		
		];
		return taOptions;
	}]);
});

appTextEditor.controller( "ListaEventos" , ["$scope", "$http","$filter", "produccionPartidosEventos", "Flash", "$timeout", "$window", "$rootScope", function($scope, $http, $filter, produccionPartidosEventos,Flash, $timeout, $window, $rootScope) {

	$scope.loader = true;
	$scope.cargador = loader;
	$scope.gridOptions = {
		columnDefs: [
			{ name:'id', displayName: 'Id', width:90, visible:false},
			{ name:'torneo', displayName: 'Campeonato'},
			{ name:'categoria', displayName: 'Categoría', width:90},
			{ name:'subcategoria', displayName: 'Subcategoría', width:90},
			{ name:'fecha_partido', displayName: 'Día', type: 'date', cellFilter: 'date:"yyyy-MM-dd"', width:100},
			{ name:'estadio', displayName: 'Estadio'},
			{ name:'hora_partido', displayName: 'Hora', type: 'date', cellFilter: 'date:"hh:mm"', width:65},
			{ name:'equipo_local', displayName: 'Local'},
			{ name:'equipo_visita', displayName: 'Visita'},
			{ name:'tipo_transmision', displayName: 'Prod.', width:70},
			{ name:'estado_produccion', displayName: 'Estado', cellTemplate : '<div class="ui-grid-cell-contents">{{(row.entity.estado_produccion==1) ? "Planificando" :((row.entity.estado_produccion==2) ? "Completado" :((row.entity.estado_produccion==3) ? "Reagendado" : "Pendiente") ) }}</div>',
				cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
					return (grid.getCellValue(row,col)==1) ? 'angular_aprobado_s' : ((grid.getCellValue(row,col)==2) ? "angular_aprobado_g" : ((grid.getCellValue(row,col)==3) ? "angular_eliminado" : "angular_pendiente_g") )
				}
			},
		],
		enableGridMenu: true,
		enableSelectAll: false,
		exporterCsvFilename: 'myFile.csv',
		exporterMenuPdf: false,
		multiSelect: false,
		exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
		onRegisterApi: function(gridApi){
			$scope.gridApi = gridApi;
		}
	};

	$scope.gridOptions2 = {
		columnDefs: [
			{ name:'torneo', displayName: 'Campeonato'},
			{ name:'categoria', displayName: 'Categoría', width:90},
			{ name:'subcategoria', displayName: 'Subcategoría', width:90},
			{ name:'fecha_partido', displayName: 'Día', type: 'date', cellFilter: 'date:"yyyy-MM-dd"', width:100},
			{ name:'estadio', displayName: 'Estadio'},
			{ name:'hora_partido', displayName: 'Hora', type: 'date', cellFilter: 'date:"hh:mm"', width:65},
			{ name:'equipo_local', displayName: 'Local'},
			{ name:'equipo_visita', displayName: 'Visita'},
			{ name:'tipo_transmision', displayName: 'Prod.', width:70},
			{ name:'estado_produccion', displayName: 'Estado', cellTemplate : '<div class="ui-grid-cell-contents">{{(row.entity.estado_produccion==1) ? "Planificando" :((row.entity.estado_produccion==2) ? "Completado" :((row.entity.estado_produccion==3) ? "Reagendado" : "Pendiente") ) }}</div>',
			cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
				return (grid.getCellValue(row,col)==1) ? 'angular_aprobado_s' : ((grid.getCellValue(row,col)==2) ? "angular_aprobado_g" : ((grid.getCellValue(row,col)==3) ? "angular_eliminado" : "angular_pendiente_g") )
			}
		},
		],
		enableSelectAll: false,
		multiSelect: true,
		showGridFooter:true,
		exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
		onRegisterApi: function(gridApi2){
			$scope.gridApi2 = gridApi2;
		}
	};

	$scope.sinPartidosPendientes = function(producciones) {	
		var partidosEnviar = [];
		
		if(producciones!='undefined'){
			
			angular.forEach(producciones, function(valor, key){
				
				if(valor.estado_produccion == "2" || valor.estado_produccion == "1"){
					partidosEnviar.push(valor);
				}
			});
		}
		return partidosEnviar;
	};

	produccionPartidosEventos.listaEventos().success(function(data){

		$scope.loader = false;
		$scope.tablaDetalle = true;

		$scope.formFecha = {};
		$scope.categorias = [];
		$scope.subcategorias = [];

		$scope.campeonatos = data.campeonatos;
		$scope.relCampeonatos = data.relCampeonatos;
		$scope.relSubCategorias = data.relSubCategorias;
		$scope.destinatarios = data.destinatarios;		
		$scope.formatoCorreos = data.formatos;
		
	   var largo = window.location.pathname.split('/').length;
	   var pagina = window.location.pathname.split('/')[largo-1];

	   if(pagina == 'enviar_partidos')
	   {				
			
			$scope.partidosFecha = {};
			var ProduccionPartidosEventos = [];
			$scope.formFecha = {ProduccionPartidosEventos:null};

			$scope.$watch('formFecha.filtro', function(filter){

				$scope.gridOptions2.data = $scope.sinPartidosPendientes(data.partidos);
				$scope.formFecha.ProduccionPartidosEventos = [];
				$scope.gridApi2.selection.clearSelectedRows();

				var partidosVivo = [];				
				angular.forEach($scope.gridOptions2.data, function(data){

					if(filter == 0)
					{
						partidosVivo.push(data);
					}
					else if(filter == 1)
					{

						if(data.tipo_transmisione_id==1)
						{	
							partidosVivo.push(data);
						}
					}
					else if(filter == 2)
					{

						if(data.tipo_transmisione_id == 2)
						{	
							partidosVivo.push(data);
						}
					}						
					else
					{
						if(data.tipo_transmisione_id==1 || data.tipo_transmisione_id == 2)
						{	
							partidosVivo.push(data);
						}
					}

				});
				$scope.gridOptions2.data = partidosVivo;
				
				$scope.gridApi2.selection.on.rowSelectionChanged($scope,function(row){
					
					if(row.entity.id){

						if(row.isSelected){

							if( angular.element.inArray(row.entity.id,$scope.formFecha.ProduccionPartidosEventos)<0 )
								$scope.formFecha.ProduccionPartidosEventos.push(row.entity.id);
						}
						else{
							var pos = angular.element.inArray(row.entity.id, $scope.formFecha.ProduccionPartidosEventos);
							if(pos>-1) $scope.formFecha.ProduccionPartidosEventos.splice(pos,1);
						}

					}
				});

			});

		
			$scope.$watch('formFecha.Email.formato', function(format){
				
				if(format==2)
				{
					$scope.formFecha.filtro = undefined;
					$scope.fechaAdd.Filtro.$valid = false;
					$scope.listaTodos = false;
				}
				else 
				{
					$scope.formFecha.filtro = 0;
					$scope.listaTodos = true;					
				}
						
			});
			
			$scope.$watch('formFecha.ProduccionPartidosEvento.campeonato_id', function(idCamp){

				if(angular.isDefined($scope.formFecha.ProduccionPartidosEvento)){
					
					$scope.categorias = [];
					$scope.subcategorias = [];
					
					$scope.formFecha.ProduccionPartidosEvento.campeonatos_categoria_id = undefined;
					$scope.formFecha.ProduccionPartidosEvento.campeonatos_subcategoria_id = undefined;

					angular.forEach($scope.campeonatos, function(camp,key){

						if( idCamp == camp.id ){
							
							angular.forEach( $scope.relCampeonatos[camp.tipo_campeonato_id], function(cat) {
								
								$scope.categorias.push(cat);
							});
						}

					});
				}
			});
			
			$scope.$watch('formFecha.ProduccionPartidosEvento.campeonatos_categoria_id', function(sub){

				if(angular.isDefined($scope.formFecha.ProduccionPartidosEvento)){	

					$scope.subcategorias = [];
					$scope.formFecha.ProduccionPartidosEvento.campeonatos_subcategoria_id = undefined;

					angular.forEach($scope.relSubCategorias[sub], function(relS){						
						$scope.subcategorias.push(relS);
					});

				}
			});

			var asunto = ["formFecha.ProduccionPartidosEvento.campeonato_id","formFecha.ProduccionPartidosEvento.campeonatos_categoria_id","formFecha.ProduccionPartidosEvento.campeonatos_subcategoria_id", "formFecha.Email.formato"];
			$scope.$watchGroup(asunto, function(data){

				if($scope.fechaAdd.Campeonato.$valid && $scope.fechaAdd.Categoria.$valid && $scope.fechaAdd.Subcategoria.$valid && angular.isDefined($scope.formFecha.Email.formato)){ 

					var prefijo;

					if($scope.formFecha.Email.formato == 1) 
						prefijo = 'EQUIPOS ';
					else
						prefijo = 'PROGRAMACION ';

					if(angular.isDefined($scope.fechaAdd.Subcategoria.$viewValue)){
						$scope.formFecha.Email.asunto = prefijo + $scope.fechaAdd.Campeonato.$viewValue.nombre +' - '+ $scope.fechaAdd.Categoria.$viewValue.nombre +' - '+ $scope.fechaAdd.Subcategoria.$viewValue.nombre;
					}					
					else if(angular.isDefined($scope.fechaAdd.Categoria.$viewValue)){
						$scope.formFecha.Email.asunto = prefijo + $scope.fechaAdd.Campeonato.$viewValue.nombre +' - '+ $scope.fechaAdd.Categoria.$viewValue.nombre;
					}
					else{
						$scope.formFecha.Email.asunto = prefijo + $scope.fechaAdd.Campeonato.$viewValue.nombre;	
					}
				}
				else 
				{
					if(!angular.isDefined($scope.formFecha.Email)) 
					{
						$scope.formFecha.Email = { asunto : '' };
					}

					$scope.formFecha.Email.asunto = '';	
				}
			});

	   }
	   else
	   {
	   	$scope.gridOptions.data = data.partidos;   
			$scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){

				if(row.isSelected == true)
				{
					if(row.entity.id){
						$scope.id = row.entity.id;   
						if(row.entity.estado_produccion==3){   //reagendados

							$scope.btnproduccion_partidos_eventosadd = true;
							$scope.btnproduccion_partidos_eventosboton_produccion_chilefilms  = true;
							$scope.btnproduccion_partidos_eventosboton_editar_chilefilms  = true;

							$scope.btnproduccion_partidos_eventosboton_produccion_cdf  = true;
							$scope.btnproduccion_partidos_eventosboton_editar_cdf  = true;

							$scope.btnproduccion_partidos_eventosboton_produccion_transmision  = true;
							$scope.btnproduccion_partidos_eventosboton_editar_transmision  = true;

							$scope.btnproduccion_partidos_eventosview  = true;
							$scope.btnproduccion_partidos_eventosedit  = true;
							$scope.btnproduccion_partidos_eventosdelete_produccion_partidos  = false;
							$scope.btnproduccion_partidos_eventosreagendar_partido_add  = true;

							$scope.boton = true; 

						}else {                                 //planificando
							$scope.btnproduccion_partidos_eventosadd = true;
							$scope.btnproduccion_partidos_eventosboton_produccion_transmision = true;
							$scope.btnproduccion_partidos_eventosboton_editar_transmision  = true;

							if(angular.isNumber(row.entity.partidos_chilefilms_id)){
								$scope.btnproduccion_partidos_eventosboton_produccion_chilefilms  = true;
								$scope.btnproduccion_partidos_eventosboton_editar_chilefilms  = false;
							}else{
								$scope.btnproduccion_partidos_eventosboton_editar_chilefilms  = true;
								$scope.btnproduccion_partidos_eventosboton_produccion_chilefilms  = false;
							}

							if(angular.isNumber(row.entity.partidos_cdf_id)){
								$scope.btnproduccion_partidos_eventosboton_produccion_cdf  = true;
								$scope.btnproduccion_partidos_eventosboton_editar_cdf  = false;
							}else{
								$scope.btnproduccion_partidos_eventosboton_produccion_cdf  = false;
								$scope.btnproduccion_partidos_eventosboton_editar_cdf  = true;
							} 

							$scope.btnproduccion_partidos_eventosview  = false;
							$scope.btnproduccion_partidos_eventosedit  = false;
							$scope.btnproduccion_partidos_eventosdelete_produccion_partidos  = false;
							$scope.btnproduccion_partidos_eventosreagendar_partido_add  = false;
						}

						$scope.boton = true; 
					}else{

						$scope.id = row.entity.id_partido;
						$scope.btnproduccion_partidos_eventosadd = false;
						$scope.btnproduccion_partidos_eventosboton_produccion_chilefilms  = true;
						$scope.btnproduccion_partidos_eventosboton_editar_chilefilms  = true;

						$scope.btnproduccion_partidos_eventosboton_produccion_cdf  = true;
						$scope.btnproduccion_partidos_eventosboton_editar_cdf  = true;

						$scope.btnproduccion_partidos_eventosboton_produccion_transmision  = true;
						$scope.btnproduccion_partidos_eventosboton_editar_transmision  = true;

						$scope.btnproduccion_partidos_eventosview  = true;
						$scope.btnproduccion_partidos_eventosedit  = true;
						$scope.btnproduccion_partidos_eventosdelete_produccion_partidos  = true;
						$scope.btnproduccion_partidos_eventosreagendar_partido_add  = true;

						$scope.boton = true; 
					}
				}else{
					$scope.boton = false;
				}
			});
		}	

		$scope.confirmacion = function (id){
			window.location.href = host+"produccion_partidos_eventos/delete_produccion_partidos/"+id
		};

		$scope.enviarCorreos = function(){
			$scope.deshabilitaBtn = true;
			$scope.tablaDetalle = false;
			$scope.loader = true;

			if($scope.formFecha.Email.formato == 1){

				produccionPartidosEventos.dataCorreoInterno($scope.formFecha).success(function(data){

					if(data.estado==1){     		// 1. EQUIPOS DE TRANSMISION
						
						$scope.partidosFecha = [];
						var partido = [];
						
						$scope.tituloDocumento = data.titulo_documento;
						$scope.nombreDocumento = data.nombre_documento;

						angular.forEach(data.partidos_correo, function(valor,key){
							partido.push(valor);
							if(Number(key+1)%2==0){
								$scope.partidosFecha.push(partido);
								partido = [];
							}
						});
						if(partido.length>0){
							$scope.partidosFecha.push(partido);
						}

						var filterTextTimeout = $timeout(function() {
			         	$scope.crearDocumentoPartidos();
			        	}, 250);

					}
					else if(data.estado==0){
						Flash.create('danger', data.mensaje, 'customAlert');
					}
					$scope.deshabilitaBtn = false;
				});
			}
			else 											// 2. INFORMACION DE PARTIDOS
			{
				produccionPartidosEventos.enviarCorreoPartidos($scope.formFecha).success(function (data){
				
					if(data.estado==1){						
						Flash.create('success', data.mensaje, 'customAlert');
						$window.location.reload();

					}else if(data.estado==0){
						Flash.create('danger', data.mensaje, 'customAlert');
						$window.location.reload();
					}
				});
			}
		}

		$scope.crearDocumentoPartidos = function(){

			var nombrePDF   = $scope.nombreDocumento +'.pdf';   	
			var controlador = 'produccion_partidos';
			var carpeta     = 'tmp';

			var parametros = {
				"nombre": nombrePDF,
				"controlador" : controlador,
				"carpeta" : carpeta,
				"html"  : angular.element("#plantilla").html(),
				"orientacion" : 'P'
			}

			var imprimirHtml = $http({
				method: 'POST',
				url: host+'servicios/pdf_basico2',
				data: $.param(parametros)
			});

			imprimirHtml.then(function(dataFile){			
				$scope.formFecha.Email.adjunto = parametros.controlador +'/'+ parametros.carpeta +'/'+ parametros.nombre;
				produccionPartidosEventos.enviarCorreoPartidos($scope.formFecha).success(function (data){					
					if(data.estado==1){						
						Flash.create('success', data.mensaje, 'customAlert');
						$window.location.reload();

					}else if(data.estado==0){
						Flash.create('danger', data.mensaje, 'customAlert');						
						$window.location.reload();
					}
				});
			});   
		}

		$scope.cerrarModal = function (){
			$scope.showModal = false;
			$scope.loaderModal = false;
		};

		$scope.refreshData = function (termObj){
			$scope.gridOptions.data = data.partidos;
			while (termObj){
				var oSearchArray = termObj.split(' ');
				$scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
				oSearchArray.shift();
				termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
			}
		};
	});
}]);