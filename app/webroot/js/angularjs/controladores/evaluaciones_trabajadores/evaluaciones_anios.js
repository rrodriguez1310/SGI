app.controller('ListaEvaluacionesAnios', ['$scope', '$http', '$filter', 'evaluacionesAniosService', function($scope, $http, $filter, evaluacionesAniosService) {
    $scope.loader = true
    $scope.cargador = loader;
    $scope.gridOptions = {
        columnDefs: [{
            name: 'proceso_evaluacion',
            displayName: 'Evaluación Desempeño',
            width: 200
        }, {
            name: 'anio_evaluado',
            displayName: 'Año Evaluado'
        }, {
            name: 'inicio_ocd',
            displayName: 'Inicio OCD'
        }, {
            name: 'fin_ocd',
            displayName: 'Fin OCD'
        }, {
            name: 'inicio_evaluacion',
            displayName: 'Inicio Evaluación'
        }, {
            name: 'fin_evaluacion',
            displayName: 'Fin Evaluación'
        }, {
            name: 'estado',
            displayName: 'Estado',
            width: 180,
            cellTemplate: '<div class="ui-grid-cell-contents">{{(row.entity.estado==1) ? "Establecer OCD" :((row.entity.estado==2) ? "Evaluación Desempeño" :((row.entity.estado==3) ? "Finalizada" : "Eliminada") ) }}</div>',
            cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                return (grid.getCellValue(row, col) == 1) ? 'angular_aprobado_s' : ((grid.getCellValue(row, col) == 2) ? "angular_pendiente_g" : ((grid.getCellValue(row, col) == 3) ? "angular_aprobado_g" : ""))
            }
        }],
        enableGridMenu: true,
        enableSelectAll: false,
        exporterCsvFilename: 'myFile.csv',
        exporterMenuPdf: false,
        multiSelect: false,
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };
    evaluacionesAniosService.evaluacionesAnios().success(function(data) {
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        
        $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
            if (row.isSelected == true) {
                if (row.entity.id) {
                    $scope.id = row.entity.id;
                    $scope.boton = true;
                }
            } else {
                $scope.boton = false;
            }
        });
        $scope.confirmacion = function() {
            window.location.href = host + "evaluaciones_anios/delete_evaluacion_anios/" + $scope.id
        }
        $scope.refreshData = function(termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    })
}]);

app.controller('EvaluacionesAniosAdd', ['$scope', '$http', '$filter', 'evaluacionesAniosService', 'Flash', '$location', '$window', function($scope, $http, $filter, evaluacionesAniosService, Flash, $location, $window) {
    evaluacionesAniosService.dataEvaluacionesAnios().success(function(data) {        
        $scope.estadosList = data.estados;
        $scope.formulario = { EvaluacionesAnios : { "anio_evaluado": {} } };        
        $scope.formulario.EvaluacionesAnios = data.EvaluacionesAnios;
        angular.forEach(data.estados, function(estado){
            if(estado.id==1){
                $scope.formulario.EvaluacionesAnios.estado_nombre = estado.nombre;
                $scope.formulario.EvaluacionesAnios.estado = estado.id;
            }
        }); 
        angular.element("#Fecha_Inicio_OCD, #Fecha_Fin_OCD, #Fecha_Inicio_Evaluacion, #Fecha_Fin_Evaluacion").datepicker({
            format: "dd-mm-yyyy",                        
            language: "es",
            multidate: false,
            daysOfWeekDisabled: "6,0",
            weekStart:1,
            autoclose: true,
            required: true,            
            orientation: "bottom auto",
        });
        angular.element("#Fecha_Inicio_OCD").datepicker("setDate", $scope.formulario.EvaluacionesAnios.inicio_ocd);
        angular.element("#Fecha_Fin_OCD").datepicker("setDate", $scope.formulario.EvaluacionesAnios.termino_ocd);
        angular.element("#Fecha_Inicio_Evaluacion").datepicker("setDate", $scope.formulario.EvaluacionesAnios.fecha_inicio);
        angular.element("#Fecha_Fin_Evaluacion").datepicker("setDate", $scope.formulario.EvaluacionesAnios.fecha_termino);
    });   

    $scope.agregarAnioEvaluacion = function(){         
        evaluacionesAniosService.addEvaluacionAnio($scope.formulario).success(function(data){
            if(data.estado==1){           
                console.log(Flash);                
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host + 'evaluaciones_anios';

            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert'); 
            }
        });
    };
}]);
app.controller('EvaluacionesAniosEdit', ['$scope', '$http', '$filter', 'evaluacionesAniosService', 'Flash', '$location', '$window', function($scope, $http, $filter, evaluacionesAniosService, Flash, $location, $window) {

    $scope.datosEvaluacion = function(idAnio){
        evaluacionesAniosService.dataEvaluacionesAniosEdit(idAnio).success(function(data) {
            $scope.estadosList = data.estados;        
            $scope.formulario = { EvaluacionesAnios : { "anio_evaluado": {} } };
            $scope.formulario.EvaluacionesAnios = data.EvaluacionesAnios;

            angular.element("#Fecha_Inicio_OCD, #Fecha_Fin_OCD, #Fecha_Inicio_Evaluacion, #Fecha_Fin_Evaluacion").datepicker({
                format: "dd-mm-yyyy",                        
                language: "es",
                multidate: false,
                daysOfWeekDisabled: "6,0",
                weekStart:1,
                autoclose: true,
                required: true,
                orientation: "bottom auto",
            });
            angular.element("#Fecha_Inicio_OCD").datepicker("setDate", $scope.formulario.EvaluacionesAnios.inicio_ocd);
            angular.element("#Fecha_Fin_OCD").datepicker("setDate", $scope.formulario.EvaluacionesAnios.termino_ocd);
            angular.element("#Fecha_Inicio_Evaluacion").datepicker("setDate", $scope.formulario.EvaluacionesAnios.fecha_inicio);
            angular.element("#Fecha_Fin_Evaluacion").datepicker("setDate", $scope.formulario.EvaluacionesAnios.fecha_termino);
        });  
    }

    $scope.registrarAnioEvaluacion = function(){         
        evaluacionesAniosService.addEvaluacionAnio($scope.formulario).success(function(data){
            if(data.estado==1){ 
                console.log(Flash);                
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host + 'evaluaciones_anios';

            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert'); 
            }
        });
    };
}]);