app.controller('AppCtrlListaEventos', ['$scope', '$http','$filter', 'ProduccionPartidos',  function ($scope, $http, $filter, ProduccionPartidos) {
  $scope.loader = true
  $scope.cargador = loader;
  $scope.gridOptions = {
    columnDefs: [
      { name:'id', displayName: 'Id', visible:false},
      { name:'created', displayName: 'Fecha Creación'},
      { name:'productor', displayName: 'Productor'},
      { name:'asistenteProduccion', displayName: 'Asit. Producción'},
      { name:'relator', displayName: 'Relator'},
      { name:'comentarista', displayName: 'Comentarista'},
      { name:'periodistaCancha', displayName: 'Periodista Cancha'},
      { name:'operadorTrackvision', displayName: 'Operador Trackvision'},
      { name:'estadoPartido', displayName: 'Estado partido'},
      //{ name:'estado', displayName: 'Estado'},
    ],
    enableGridMenu: true,
    enableSelectAll: true,
    exporterCsvFilename: 'myFile.csv',
    exporterPdfDefaultStyle: {fontSize: 9},
    exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
    exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
    exporterPdfHeader: { text: "My Header", style: 'headerStyle' },
    exporterPdfFooter: function ( currentPage, pageCount ) {
      return { text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle' };
    },
    exporterPdfCustomFormatter: function ( docDefinition ) {
      docDefinition.styles.headerStyle = { fontSize: 22, bold: true };
      docDefinition.styles.footerStyle = { fontSize: 10, bold: true };
      return docDefinition;
    },
    exporterPdfOrientation: 'portrait',
    exporterPdfPageSize: 'LETTER',
    exporterPdfMaxGridWidth: 500,
    exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
    onRegisterApi: function(gridApi){
      $scope.gridApi = gridApi;
    }
  };

  ProduccionPartidos.listaEventos().success(function(data){
    $scope.gridOptions.data = data;
    $scope.loader = false;
      $scope.tablaDetalle = true;
      $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
        if(row.isSelected == true)
        {
          if(row.entity.id){
            $scope.id = row.entity.id;
              $scope.boton = true; 
          } 
        }else{
          $scope.boton = false; 
        }
    });

    $scope.confirmacion = function (){           
      window.location.href = host+"produccion_partidos/delete_produccion_partidos/"+$scope.id
    }


    $scope.refreshData = function (termObj){
        $scope.gridOptions.data = data;
        while (termObj){
            var oSearchArray = termObj.split(' ');
            $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
            oSearchArray.shift();
            termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
        }
    };
  })
}]);