app.controller('RatingProgramas', ['$scope', '$http', 'Flash', function($scope, $http, Flash) {

    $scope.gridOptions = {
        enableFiltering: true,
        enableGridMenu: true,
        enableSelectAll: true,
        exporterCsvFilename: 'raing_por_programas.csv',
        exporterPdfDefaultStyle: { fontSize: 9 },
        exporterPdfTableStyle: { margin: [30, 30, 30, 30] },
        exporterPdfTableHeaderStyle: { fontSize: 10, bold: true, italics: true, color: 'red' },
        exporterPdfHeader: { text: "Rating por programas", style: 'headerStyle' },
        exporterPdfFooter: function(currentPage, pageCount) {
            return { text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle' };
        },
        exporterPdfCustomFormatter: function(docDefinition) {
            docDefinition.styles.headerStyle = { fontSize: 22, bold: true };
            docDefinition.styles.footerStyle = { fontSize: 10, bold: true };
            return docDefinition;
        },
        exporterPdfOrientation: 'portrait',
        exporterPdfPageSize: 'LETTER',
        exporterPdfMaxGridWidth: 500,
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }

    };

    $scope.gridOptions.columnDefs = [
        { name: 'id', displayName: 'Id', visible: false },
        //{ name: 'fecha', displayName: 'Fecha' },
        { name: 'dia_tv', displayName: 'Fecha' },
        { name: 'inicio_presupuestado', displayName: 'I.Presusp.' },
        { name: 'hora_inicio', displayName: 'I.Real' },
        { name: 'duracion', displayName: 'Duración' },
        { name: 'nombre', displayName: 'Nombre' },
        { name: 'programacionNombre', displayName: 'Programa' },
        { name: 'programacionDescripcion', displayName: 'Desc.' },
        { name: 'nombre_canal', displayName: 'Señal' },
        { name: 'programacionHora', displayName: 'Programado' },
        { name: 'inicioReal', displayName: 'I.Real' },
        { name: 'finReal', displayName: 'F.Real' },
        { name: 'raiting', displayName: 'Raiting' },
        { name: 'share', displayName: 'Share' },
        { name: 'tvr', displayName: 'Tvr' },
        { name: 'estado', displayName: 'Estado' },
    ];

    $scope.enviaFecha = function(form) {
        if (form.fecha && form.signal) {
            $http.get(host25 + 'programaciones/programacionLogRating/' + form.fecha + '/' + form.signal).success(function(data) {
                if (data.length > 0) {
                    $scope.gridOptions.data = data;
                } else {
                    alert("No hay informacion de programacion para este dia");
                }
            });
        }
    };
}]);