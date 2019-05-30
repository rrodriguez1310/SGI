app.controller('ListaEmpresas',  ['$scope', '$rootScope','$http', '$filter', '$location', 'uiGridConstants', 'listaEmpresasService', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants, listaEmpresasService) {
    $scope.loader = true
    $scope.cargador = loader;

    $scope.gridOptions = {  
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        enableSorting: true,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        {name:'Id', displayName:'Id', visible: false },
        {name:'Rut', displayName:'Rut'},
        {name:'Nombre', displayName:'Nombre de fantasía', },
        {name:'RazonSocial', displayName:'Razón social', },
        {name:'TipoCompania', displayName:'Tipo Compañía'},
        {name:'IdTipoCompania', displayName:'Id Tipo Compañía', visible: false},
        {name:'IdTipoCompaniaOtros', displayName:'Tipo Compañía otros', visible: false},
        {name:'Observacion', displayName:'Observacion'},
    ];

    $http.get(host25+'companies/lista_empresas_json').success(function(data) {
        $scope.loader = false;
        $scope.gridOptions.data = data;                 
        $scope.tablaDetalle = true;
       
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){

            if(angular.isNumber(row.entity.Id))
            {
                $scope.boton = true;
                $scope.id = row.entity.Id;
                angular.element("#CompaniesAttributeCompanyId").val(row.entity.Id);

            }            
            if(row.isSelected == true)
            {
                if(row.entity.IdTipoCompania==1)
                {
                    $scope.operadores = true;
                    $scope.toolContactos = true;  
                    $scope.toolOtros = true;                   
                }
                else
                {
                    $scope.operadores = false;
                    $scope.toolOtros = true;
                    $scope.toolContactos = true;
                }
            }
            else
            {
                $scope.toolOtros = false;
                $scope.id = "";
                $scope.toolOperadores = false;
                $scope.toolContactos = false;
                $scope.boton = false;
                $scope.operadores = false;
            }
        }); 

        $scope.refreshData = function (termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });

    $scope.listarComentarios = function (idEmpresa){       
        $rootScope.data = listaEmpresasService.listaComentarios($scope.id);
        angular.element("#tituloModalComment").text('Bitácora');   
        angular.element("#listaComentarios").modal("show");
    };
}]);


app.controller('ListaMensajes', ['$scope', '$http', '$log','$filter', '$rootScope', 'uiGridConstants','Upload', 'listaEmpresasService',  
    function ($scope, $http, $log, $filter, $rootScope, uiGridConstants, Upload, listaEmpresasService) {
    
    $scope.loaderComentarios = true;
    $scope.cargador = loader;
    $scope.listado = true;
    $scope.detalle = undefined;
    $scope.searchMensajes = '';  

    $scope.gridOptions = { 
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: false,
        rowSelection: false,
        multiSelect: false,
        enableSorting: true,
        expandableRowTemplate: '<div ui-grid="row.entity.subGridOptions" style="height:270px"></div>',
        expandableRowHeight: 270,
        gridExpandableExpandedAll :false,
        onRegisterApi : function(gridApi){
            $scope.gridApi = gridApi;
            $scope.gridApi.expandable.on.rowExpandedStateChanged($scope, function (row) {
                if (row.isExpanded) {
                    row.entity.subGridOptions = {
                    columnDefs: [
                        { field:'Comentario', displayName:'Detalle de información', cellTemplate: '<p style="width:780px;max-height:270px;margin:0px;position:absolute">{{grid.getCellValue(row,col)}}</p>'}
                    ]};
                    row.entity.subGridOptions.data = angular.fromJson([{"Comentario":row.entity.Comentario}]);
                }
            });
        }
    };
    
    $scope.gridOptions.columnDefs = [
        {name:'IdCompania', displayName:'IdCompania', visible: false, enablePinning:false },
        {name:"Fecha", displayName:'Fecha', sort: { direction: uiGridConstants.DESC}, width: 110, enablePinning:false},
        {name:'NombreUsuario', displayName:'Creador', width: 160 , enablePinning:false},
        {name:'Clasificacion', displayName:'Clasificación', width: 120, enablePinning:false},
        {name:"NombreContacto", displayName:'Contacto' , cellTemplate: '<div class="ui-grid-cell-contents">{{(grid.getCellValue(row,col)=="")? "-": grid.getCellValue(row,col)}}</div>', width: 150, enablePinning:false},
        {name: 'Comentario' , displayName:'Información' , width: 150, enablePinning:false},
        {name:'Adjunto', displayName:'Adjunto', cellTemplate: '<a href="{{grid.getCellValue(row,col)}}" target="_blank" ng-show="grid.getCellValue(row,col)" style="margin-top:3px"><div class="ui-grid-cell-contents">descargar</div></a>',width: 105, enablePinning:false},
    ];

    $rootScope.$watch("data", function(nuevoValor, viejoValor){
        if(angular.isDefined(nuevoValor)){
  
            $scope.listadoMensajes = false;
            $scope.loaderComentarios = true;    

            nuevoValor.success(function(data){
                $scope.id = data.IdEmpresa;
                $scope.loaderComentarios = false;
                $scope.listadoMensajes = true;
                $scope.gridOptions.data = data.ListaComentarios;  

                $scope.refreshData = function (termObj) {
                    $scope.gridOptions.data = data.ListaComentarios;
                    while (termObj) {
                        var oSearchArray = termObj.split(' ');
                        $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                        oSearchArray.shift();
                        termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                    }
                };
            });        
        }        
    });

    $scope.volverComentarios = function(idEmpresa){    
        $rootScope.data = listaEmpresasService.listaComentarios(idEmpresa);
        angular.element("#tituloModalComment").text('Bitácora'); 
        $scope.listado = true;
        $scope.agregar = false;
    };    

    $scope.agregarComentario = function(idEmpresa){        
        $scope.listado = false;
        $scope.alerta = false;
        $scope.mensaje = "";
        $scope.clasificacion = ""; 
        $scope.nombreArchivo = '';
        $scope.sizeArchivo = '';
        angular.element("#tituloModalComment").text('Ingresar Información');

        $http.get(host25+'companies_comentarios/add_json/'+idEmpresa).
            success(function(data, status, headers, config){
                
                $scope.nombreCompania = data.Empresa.razon_social;
                $scope.nombreClasificacion = data.ListaClasificacion;
                $scope.listaContacto = data.ListaContacto;
                $scope.idEmpresa = idEmpresa;       
                $scope.agregar = true;
        });
    };

    $scope.upload = function(idEmpresa,files){
        var idContato;
        if(angular.isDefined($scope.contacto)){
            idContato = $scope.contacto.idContacto;
        }

        parametros = {            
            "company_id":   idEmpresa,
            "user_id":      angular.element("#user_id").val(), 
            "comentario"  : $scope.mensaje,
            "clasificacion_comentario_id" : $scope.clasificacion.idClasificacion, 
            "estado" : 1, 
            "companies_contacto_id" : idContato, 
        } 

        if( files && files.length) {
            var file = files[0];
        }

        Upload.upload({
                url: host+'companies_comentarios/add',
                fields:  parametros,
                file: file
            })
            .success(function(data, status, headers, config){

                $scope.agregar = false; 

                if(data==1){
                      $scope.volverComentarios(idEmpresa);

                  }else if(data==0){

                        $scope.agregar = true;
                        $scope.msjError = 'Ocurrio un problema al querer registrar la información';
                        $scope.alerta = true;     

                }else if (data==3) {

                    $scope.agregar = true;
                    $scope.msjError = 'Archivo supera el límite permitido';
                    $scope.alerta = true;   

                }else if (data==2) {

                    $scope.agregar = true;
                    $scope.msjError = 'Error: el formato de archivo no permitido';
                    $scope.alerta = true;   

                }else{

                    $scope.agregar = true;
                    $scope.msjError = 'Seleccione otro archivo';
                    $scope.alerta = true;
               }
            });
    };

    $scope.settingFile = function(files){        
        if( files && files.length) {

            $scope.setFile = true; 

            if(files[0].name.length>18){
                $scope.nombreArchivo = files[0].name.slice(0,18) + '...';

            }else{                
                $scope.nombreArchivo = files[0].name;
            }
            
            var tamaño = (files[0].size/1000000).toFixed(2);
            $scope.sizeArchivo = '(' + tamaño + 'MB)';

            if(tamaño>2){
                $scope.msjError = 'Archivo supera el límite permitido';
                $scope.alerta = true; 
                $scope.addComentarioForm['archivo'].$setValidity("required", false); 
            }else{
                $scope.msjError = '';
                $scope.alerta = false; 
                $scope.addComentarioForm['archivo'].$setValidity("required", true);
            }

        }
    };

    $scope.eliminarArchivo = function(files){        
        if( files && files.length) {

            files = undefined;
            $scope.nombreArchivo = undefined;
            $scope.sizeArchivo = undefined;
            $scope.setFile = false;

            $scope.addComentarioForm['archivo'].$setValidity("required", true);  
            if($scope.alerta){
                 $scope.msjError = '';
                 $scope.alerta = false;

            }
        }
    };
 
}]);