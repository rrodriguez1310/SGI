app.controller('ListaPartidos', ['$scope', '$http','$filter', 'FixturePartidos',  function ($scope, $http, $filter, FixturePartidos) {
  $scope.loader = true
  $scope.cargador = loader;
  $scope.gridOptions = {
    columnDefs: [
      { name:'id', displayName: 'Id', visible:false},
      { name:'torneo', displayName: 'Campeonato'},
      { name:'categoria', displayName: 'Categoria', width:93},
      { name:'subcategoria', displayName: 'Subcategoria', width:117},
      { name:'fecha_partido', displayName: 'Día', type: 'date', cellFilter: 'date:"yyyy-MM-dd"', width:100},
      { name:'estadio', displayName: 'Estadio'},
      { name:'hora_partido', displayName: 'Hora', type: 'date', cellFilter: 'date:"hh:mm"', width:65},
      { name:'equipo_local', displayName: 'Local'},
      { name:'equipo_visita', displayName: 'Visita'},
      { name:'transmite_cdf', displayName: 'TV', width:75}
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
  FixturePartidos.listaPartidos().success(function(data){

    $scope.gridOptions.data = data;
    $scope.loader = false;
      $scope.tablaDetalle = true;
      $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
        
        if(row.isSelected == true)
        {
          if(row.entity.id){
            $scope.id = row.entity.id;
            $scope.btnfixture_partidosboton_delete_partidos = false;
            $scope.boton = true; 
            console.log("pase");
          }else{
            $scope.boton = false; 
          }            
        }else{
          $scope.boton = false; 
        }
      
    });

    $scope.confirmacion = function (id){
      var estado = 0;
      var mensaje = '';
      var confirma = false;

      angular.forEach($scope.gridOptions.data, function(valor,key) {
        if(valor.id == id){
          estado = valor.producciones_vigentes;
          mensaje = valor.mensaje_eliminar;
        }
      });
      
      if(estado == 1){
        alert(mensaje);
      }
      else
      {
        confirma = confirm("¿Deseas eliminar el partido?"); 
        if(confirma){
          window.location.href = host+"FixturePartidos/delete_partidos/"+id
        }
      }
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
  });
}]);