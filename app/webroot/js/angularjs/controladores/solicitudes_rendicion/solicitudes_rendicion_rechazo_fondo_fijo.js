app.controller('controllerSolicitudes', ['$scope', '$http', '$filter', 'solicitudesRendicion', function($scope, $http, $filter, solicitudesRendicion) {
    $scope.tablaDetalle = false;
    $scope.loader = true;
    $scope.cargador = loader;
    var i=1;
    var listaRendicion = [];
    $scope.rendicion = [];
    $scope.rendicionList = [];
    $scope.guardarRendicion = {};
    //$scope.formularioSolicitud = [];
    $scope.total = [];
    $scope.totalx = 0;
    $scope.documetosRendicion = [];

    $scope.totalGastos=0;
    $scope.gridOptions = {
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false, 
        enableSorting: true,
        enableColumnResizing: true,
        enableCellEdit: false,
        exporterMenuCsv: true,
        exporterMenuExcel: true,
        enableGridMenu: true, 
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };
    
    $scope.gridOptions.columnDefs = [
        {name:'id', displayName: 'Id'},
        {name:'cantidad', displayName: 'Can'},
        {name:'codigoPresupuestario', displayName: 'Cod. Presupuesto'},
        {name:'descuento_producto', displayName: 'Des $'},
        {name:'descuento_producto_peso', displayName: 'Des %'},
        {name:'dimCinco', displayName: 'Otros'},
        {name:'dimCuatro', displayName: 'C. Distribución'},
        {name:'dimDos', displayName: 'Estadios'},
        {name:'dimTres', displayName: 'Contenido'},
        {name:'dimUno', displayName: 'Gerencia'},
        {name:'empaque', displayName: 'Empaque'},
        {name:'precio', displayName: 'Precio.'},
        {name:'producto', displayName: 'Descripción.'},
        {name:'proyecto', displayName: 'Proyecto.'},
        {name:'tipo_impuesto', displayName: 'Impuesto'}

    ];
   
    $scope.submit = function() {

        if(Object.keys($scope.rendicion).length ==0){
            alert('Todos los campos son obligatorios');
            $("[for=cantidad]").text('Campo obligatorio').css('color', 'red');
            $("[for=producto]").text('Campo obligatorio').css('color', 'red');
            $("[for=precio]").text('Campo obligatorio').css('color', 'red');
            $("[for=gerencia]").text('Campo obligatorio').css('color', 'red');
            $("[for=presupuestos]").text('Campo obligatorio').css('color', 'red');
       
            return false;

           
        }else{
            if($scope.rendicion.cantidad){
                
                $("[for=cantidad]").text('');
            }else{
               
                $("[for=cantidad]").text('Campo obligatorio').css('color', 'red');
               
            }

            if($scope.rendicion.producto){
                $("[for=producto]").text('');
            }else{
                $("[for=producto]").text('Campo obligatorio').css('color', 'red');
                
            }

            if($scope.rendicion.precio){
                $("[for=precio]").text('');
                sum.push($scope.rendicion.precio.replace(/\./g,''))
            }else{
                $("[for=precio]").text('Campo obligatorio').css('color', 'red');
               
            }
          
            if($scope.rendicion.dimUno){
                $("[for=gerencia]").text('');
               
            }else{
                $("[for=gerencia]").text('Campo obligatorio').css('color', 'red');
               
            }

            if($scope.rendicion.codigoPresupuestario){
                $("[for=presupuestos]").text('');
                
            }else{
                $("[for=presupuestos]").text('Campo obligatorio').css('color', 'red');
               
            }
            if(Object.keys($scope.rendicion).length < 4){
                return false;
            }

        }

  


        solicitudesRendicion.formularioRendicionFondo($scope.rendicion).success(function(data){
         
            listaRendicion.push(data);
            $scope.gridOptions.data = listaRendicion;
            $scope.rendicion=undefined;
            $scope.myFormulario.$setPristine();
            $scope.rendicion = {}

            $("#dimUno").select2('destroy').val('').select2();
            $("#codigoPresupuestario").select2('destroy').val('').select2();
            /*$("#dimDos").select2('destroy').val('').select2();
            $("#dimTres").select2('destroy').val('').select2();
            $("#dimCuatro").select2('destroy').val('').select2();
            $("#dimCinco").select2('destroy').val('').select2();
            $("#proyecto").select2('destroy').val('').select2();
            $("#proveedor").select2('destroy').val('').select2();
            $("#empaque").select2('destroy').val('').select2();*/
           
            $scope.rendicion = {};
            $scope.sumaResta();

           
        });  
        $("#ingresoProducto").modal('hide');
    };

   /* $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
solicitudesRequerimiento
        if(row.isSelected == true){
            if(row.entity.id){descripcion
                $scope.id = row.entity.id;
                $scope.eliminarBtn = true;
                $scope.boton = true;
            }
        }else{
            $scope.boton = false;
            row.entity.id.length = 0;
            $scope.id = '';
            $scope.eliminarBtn = false;
        }
        
    });*/

    $scope.guardaRendicionSubmit = function(){

        var idFolio = $("#folio").val();
        if(Object.keys($scope.guardarRendicion).length ==0){
            alert('Todos los campos son obligatorios');
            $("[for=fecha_documento]").text('Campo obligatorio').css('color', 'red');
            $("[for=company_id]").text('Campo obligatorio').css('color', 'red');
            $("[for=plazos_pago_id]").text('Campo obligatorio').css('color', 'red');
            $("[for=titulo]").text('Campo obligatorio').css('color', 'red');
            $("[for=observacion]").text('Campo obligatorio').css('color', 'red');
        
            return false;

           
        }else{
            if($scope.guardarRendicion.fecha_documento){
                $("[for=fecha_documento]").text('');
            }else{
                $("[for=fecha_documento]").text('Campo obligatorio').css('color', 'red'); 
            }

            if($scope.guardarRendicion.company_id){
                $("[for=company_id]").text('');
            }else{
                $("[for=company_id]").text('Campo obligatorio').css('color', 'red');
                
            }
     
            if($scope.guardarRendicion.plazos_pago_id){
                $("[for=plazos_pago_id]").text('');
              
            }else{
                $("[for=plazos_pago_id]").text('Campo obligatorio').css('color', 'red');
               
            }

            if($scope.guardarRendicion.titulo){
                $("[for=titulo]").text('');
               
            }else{
                $("[for=titulo]").text('Campo obligatorio').css('color', 'red');
               
            }

            if($scope.guardarRendicion.observacion){
                $("[for=observacion]").text('');
               
            }else{
                $("[for=observacion]").text('Campo obligatorio').css('color', 'red');
              
            }
            //console.log(1,Object.keys(listaRendicion).length );
           // return false;
           if(Object.keys(listaRendicion).length==0){
                $("[for=gridOptions]").text('Debe ingresar detalle de gastos').css('color', 'red');
                return false;
            }else{
                $("[for=gridOptions]").text('');
            }

          /*  if($scope.gridOptions.data.length==0){
                $("[for=gridOptions]").text('Debe ingresar detalle de gastos').css('color', 'red');
               // return false;
            }else{
                $("[for=gridOptions]").text('');
            }*/

            console.log(Object.keys($scope.guardarRendicion).length);false
           // return false;
            if(Object.keys($scope.guardarRendicion).length < 5){

                return false;
            }  
        }
            solicitudesRendicion.guardaRedicionFondos($scope.guardarRendicion, listaRendicion, $scope.documetosRendicion, $scope.total, idFolio).success(function(data){
                window.location.href = host+"solicitud_rendicion_totales/view_solicitud";
            });
    }

    $scope.sumaResta = function() {
        var sum = []; 
        var selectedRowEntities = $scope.gridOptions.data;
            angular.forEach(selectedRowEntities, function(rowEntity, key) {
                sum.push(rowEntity.sub)
            })
            var moneda = $("#moneda_observada").val();
            if(moneda!=''){
                $scope.totalGastos = (eval(sum.join("+")) * moneda);
            }else{
                $scope.totalGastos = eval(sum.join("+"));
            }

        console.log($scope.totalGastos);
    }


}]);