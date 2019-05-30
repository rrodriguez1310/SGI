app.controller('controllerSolicitudesFondoFijo', ['$scope', '$http', '$filter', 'solicitudesRendicion', function($scope, $http, $filter, solicitudesRendicion) {
    $scope.tablaDetalle = false;
    $scope.loader = true;
    $scope.cargador = loader;
    var i=1;
    var listaRendicion = [];
    $scope.rendicion = {};
    $scope.rendicionList = {};
    $scope.guardarRendicion = {};
    //$scope.formularioSolicitud = [];
    $scope.total = [];
    $scope.totalx = 0;
    $scope.documetosRendicion = {};

    $scope.totalGastos=[];

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
            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                $scope.eliminarBtnGrilla = true;
                
            }); 
        }
    };

    $scope.deleteRow = function() {
        var r = confirm("Desea eliminar el registro!");
        if(r){
            var selectedRowEntities = $scope.gridApi.selection.getSelectedRows();
            angular.forEach(selectedRowEntities, function(rowEntity, key) {
                var rowIndexToDelete = $scope.gridOptions.data.indexOf(rowEntity);
                $scope.totalGastos = $scope.totalGastos - rowEntity.sub;
                $scope.gridOptions.data.splice(rowIndexToDelete, 1);
                $scope.sumaResta();
                $scope.eliminarBtnGrilla = false;
            })
        }
    };

    $scope.gridOptions.columnDefs = [
     
        //{name:'eliminar', displayName: '',cellTemplate: '<a href="#" ng-click="grid.appScope.deleteRow(row.entity)" ><span class="glyphicon glyphicon-trash"></span></a>'},
        //{name:'id', displayName: 'Id'},
        {name:'cantidad', displayName: 'Can'},
        {name:'producto', displayName: 'Descrp.'},
        {name:'proveedor', displayName: 'Proveedor'},
        {name:'n_folio', displayName: 'N° Folio'},
        {name:'codigoPresupuestario', displayName: 'Cod. Presupuesto'},
       // {name:'descuento_producto', displayName: 'Des $'},
        //{name:'descuento_producto_peso', displayName: 'Des %'},
        {name:'dimCinco', displayName: 'Otros'},
        {name:'dimCuatro', displayName: 'C. Distribución'},
        {name:'dimDos', displayName: 'Estadios'},
        {name:'dimTres', displayName: 'Contenido'},
        {name:'dimUno', displayName: 'Gerencia'},
       // {name:'empaque', displayName: 'Empaque'},
        {name:'precio', displayName: 'Precio'},
        {name:'sub', displayName: 'Sub Total'},
        //{name:'proyecto', displayName: 'Proyecto.'},
        //{name:'tipo_impuesto', displayName: 'Impuesto'}

    ];

  
    $scope.submit = function() {
        //$scope.myFormulario.$setPristine();

        //var i = 0;

       /* if(Object.keys($scope.rendicion).length ==0){
            alert('Todos los campos son obligatorios');
            $("[for=cantidad]").text('Campo obligatorio').css('color', 'red');
            $("[for=producto]").text('Campo obligatorio').css('color', 'red');
            $("[for=precio]").text('Campo obligatorio').css('color', 'red');
            $("[for=gerencia]").text('Campo obligatorio').css('color', 'red');
            $("[for=presupuestos]").text('Campo obligatorio').css('color', 'red');
            return false;

           
        }else{
            if($scope.rendicion.cantidad){
               // console.log('entre arriba')
               if($scope.rendicion.cantidad == 0){
                    $("[for=cantidad]").text('Debe ingresar cantidad').css('color', 'red');
                    i = i - 1;
                }else{
                    $("[for=cantidad]").text('');
                    i = i + 1;
                }
            }else{
                //console.log('entre abajo')
                $("[for=cantidad]").text('Campo obligatorio').css('color', 'red');
               
            }

            if($scope.rendicion.producto){
                $("[for=producto]").text('');
                i = i + 1;
            }else{
                $("[for=producto]").text('Campo obligatorio').css('color', 'red');
                
            }

            if($scope.rendicion.precio){
                if($scope.rendicion.precio == 0){
                    $("[for=precio]").text('Debe ingresar precio').css('color', 'red');
                    i = i - 1;
                }else{
                    $("[for=precio]").text('');
                    i = i + 1;
                }
               
            }else{
                $("[for=precio]").text('Campo obligatorio').css('color', 'red');
               
            }
          
            if($scope.rendicion.dimUno){
                $("[for=gerencia]").text('');
                i = i + 1;
               
            }else{
                $("[for=gerencia]").text('Campo obligatorio').css('color', 'red');
               
            }

            if($scope.rendicion.codigoPresupuestario){
                $("[for=presupuestos]").text('');
                i = i + 1;
                
            }else{
                $("[for=presupuestos]").text('Campo obligatorio').css('color', 'red');
               
            }

            if(i  < 5){
                return false;
            }

        }*/

        var i =0;
        $("#myFormulario").find('select').each(function(v, e){
            if(e.value != ""){
                console.log($('#'+e.id+" option[value="+e.value+"]").attr("selected","selected"));
            }
        });


        if($("#cantidad").val() == "" || $("#cantidad").val() == 0){
            $("[for=cantidad]").text('Debe ingresar cantidad').css('color', 'red');
        }else{
            $("[for=cantidad]").text('');
            i = i + 1;
        }


        if($("#producto").val() == ""){
            $("[for=producto]").text('Campo obligatorio').css('color', 'red');
        }else{
            $("[for=producto]").text('');
            i = i + 1;
        }

        if($("#precio").val() == "" || $("#precio").val()==0){
            $("[for=precio]").text('Debe ingresar precio').css('color', 'red');
        }else{
            $("[for=precio]").text('');
            i = i + 1;
        }

        if($("#dimUno").val() == ''){
            $("[for=gerencia]").text('Campo obligatorio').css('color', 'red');
            
        }else{
            $("[for=gerencia]").text('');
            i = i + 1;
        }

        if($("#codigoPresupuestario").val() == ""){
            $("[for=presupuestos]").text('Campo obligatorio').css('color', 'red');
        }else{
            $("[for=presupuestos]").text('');
            i = i + 1;
        
        }

        if(i < 5){
            return false;
        }

        solicitudesRendicion.formularioRendicionFondo($scope.rendicion).success(function(data){

            
         
            listaRendicion.push(data);
            $scope.gridOptions.data = listaRendicion;
            //$scope.rendicion=undefined;
            //$scope.myFormulario.$setPristine();

           // $("#dimUno").select2('destroy').val('').select2();
            /*$("#dimDos").select2('destroy').val('').select2();
            $("#dimTres").select2('destroy').val('').select2();
            $("#dimCuatro").select2('destroy').val('').select2();
            $("#dimCinco").select2('destroy').val('').select2();
            $("#proyecto").select2('destroy').val('').select2();
            $("#proveedor").select2('destroy').val('').select2();
            $("#empaque").select2('destroy').val('').select2();**/
           // $("#codigoPresupuestario").select2('destroy').val('').select2();
            //$scope.rendicion = {}
            //$scope.sumaResta();

           /* $('#cantidad').val('')
            $('#n_folio').val('')
            $('#producto').val('')
            $('#precio').val('')
            $('#descuento_producto').val('')
            $('#descuento_producto_peso').val('')*/
            $scope.rendicion.cantidad='';
            $scope.rendicion.n_folio='';
            $scope.rendicion.producto='';
            $scope.rendicion.precio='';
            $scope.rendicion.descuento_producto='';
            $scope.rendicion.descuento_producto_peso='';
 
            $scope.sumaResta();
        });  
        $("#ingresoProducto").modal('hide');
    };

    $scope.guardaRendicionSubmit = function(){
        var i = 0;
        var idFolio = $("#folio").val();
        if(Object.keys($scope.guardarRendicion).length ==0){
            alert('Todos los campos son obligatorios');
            $("[for=fecha_documento]").text('Campo obligatorio').css('color', 'red');
           // $("[for=company_id]").text('Campo obligatorio').css('color', 'red');
            //$("[for=plazos_pago_id]").text('Campo obligatorio').css('color', 'red');
            $("[for=titulo]").text('Campo obligatorio').css('color', 'red');
            //$("[for=observacion]").text('Campo obligatorio').css('color', 'red');
            $("[for=doc]").text('Debe ingresar documentos').css('color', 'red');
            return false;
        }else{
            if($scope.guardarRendicion.fecha_documento){
                $("[for=fecha_documento]").text('');
                i = i + 1;
            }else{
                $("[for=fecha_documento]").text('Campo obligatorio').css('color', 'red'); 
            }

            if($scope.guardarRendicion.titulo){
                $("[for=titulo]").text('');
                i = i + 1;
            }else{
                $("[for=titulo]").text('Campo obligatorio').css('color', 'red');
            }

           /* if($scope.guardarRendicion.observacion){
                $("[for=observacion]").text('');
                i = i + 1;
               
            }else{
                $("[for=observacion]").text('Campo obligatorio').css('color', 'red');
            }*/

            if(Object.keys($scope.documetosRendicion).length==0){
                $("[for=doc]").text('Debe ingresar documentos').css('color', 'red');
            }else{
                $("[for=doc]").text('');
                i = i + 1;
            }

            if($scope.gridOptions.data.length==0){
                $("[for=gridOptions]").text('Debe ingresar detalle de gastos').css('color', 'red');
            }else{
                $("[for=gridOptions]").text('');
                i = i + 1;
            }

            //console.log(Object.keys($scope.guardarRendicion).length);
            if(i < 4){
                return false;
            }  

       
    }

    solicitudesRendicion.guardaRedicionFondosFijos($scope.guardarRendicion, listaRendicion, $scope.documetosRendicion, $scope.totalGastos, idFolio).success(function(data){
       window.location.href = host+"solicitud_rendicion_totales/view_lista_fijos";

    });
    }


    $scope.sumaResta = function() {
        var sum = []; 
        var selectedRowEntities = $scope.gridOptions.data;
            angular.forEach(selectedRowEntities, function(rowEntity, key) {
                sum.push(rowEntity.sub.replace(/\./g,''))
            })
            var moneda = $("#moneda_observada").val();
            if(moneda!=''){
                $scope.totalGastos = (eval(sum.join("+")) * moneda);
            }else{
                $scope.totalGastos = eval(sum.join("+"));
            }

        console.log($scope.totalGastos);
    }


    $scope.formatThusanNumber = function(){
        var num = $scope.rendicion.precio.replace(/\./g,'');
        if(!isNaN(num)){
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            //input.value = num;
            $("#precio").val(num);
        }
        else
        { 
            alert('Solo se permiten numeros');
            $("#precio").val($scope.rendicion.precio.replace(/[^\d\.]*/g,''));
        }
    }

}]);


