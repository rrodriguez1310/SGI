app.controller('controllerSolicitudes', ['$scope', '$http', '$filter', 'solicitudesRendicion', function($scope, $http, $filter, solicitudesRendicion) {
    $scope.tablaDetalle = false;
    $scope.loader = true;
    $scope.cargador = loader;
    var i=1;
    var listaRendicion = [];
    $scope.rendicion = {};
    $scope.rendicionList = [];
    $scope.guardarRendicion = {};
    //$scope.formularioSolicitud = [];
    $scope.total = [];
    
    $scope.documetosRendicion = {};

    $scope.totalGastos=0;
    $scope.gridOptions = {
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: false,
        enableRowHeaderSelection: true,
        multiSelect: false, 
        enableSorting: true,
        enableColumnResizing: true,
        enableCellEdit: false,
        exporterMenuCsv: true,
        exporterMenuExcel: true,
        enableGridMenu: false, 
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;

            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                $scope.eliminarBtnGrilla = true;
                
            }); 
        }
    };

    $scope.gridOptions.columnDefs = [
        //{name:'id', displayName: 'Id'},
        {name:'proveedor', displayName: 'Proveedor'},
        {name:'n_folio', displayName: 'N° Folio'},
        {name:'cantidad', displayName: 'Can'},
        {name:'producto', displayName: 'Descrp.'},
        {name:'dimUno', displayName: 'Gerencia'},
        {name:'dimDos', displayName: 'Estadios'},
        {name:'dimTres', displayName: 'Contenido'},
        {name:'dimCuatro', displayName: 'C. Distribución'},
        {name:'dimCinco', displayName: 'Otros'},
        {name:'proyecto', displayName: 'Proyecto.'},
        {name:'codigoPresupuestario', displayName: 'Cod. Presupuesto'},
        {name:'precio', displayName: 'Precio'},
        {name:'sub', displayName: 'Sub Total'},
        //{name:'descuento_producto', displayName: 'Des $'},
        //{name:'descuento_producto_peso', displayName: 'Des %'},
        //{name:'empaque', displayName: 'Empaque'},
        //{name:'tipo_impuesto', displayName: 'Impuesto'}

    ];
    //$scope.JSONPresupuesto     = [ ];
    $scope.cargaPresupuesto= function(){
        $("#codigoPresupuestario").select2('destroy').val('').select2();
        $scope.rendicion.codigoPresupuestario = '';
        solicitudesRendicion.listaDimenciones(this.rendicion.dimUno).success(function(data){
            $scope.JSONPresupuesto  = data;
        })
    }



    $scope.cargaDatos = function(id) {

       
        solicitudesRendicion.datosDimensionSolicitud(id).success(function(data){

            $("#dimUno").select2('destroy').val(data[0].dimensione_id).select2();
            $("#dimDos").select2('destroy').val(data[0].estadios).select2();
            $("#dimTres").select2('destroy').val(data[0].contenido).select2();
            $("#dimCuatro").select2('destroy').val(data[0].canal_distribucion).select2();
            $("#dimCinco").select2('destroy').val(data[0].otros).select2();
            $("#proyecto").select2('destroy').val(data[0].proyectos).select2();
            solicitudesRendicion.listaDimenciones(data[0].dimensione_id).success(function(data){
                $scope.JSONPresupuesto  = data;
            })
            setTimeout(() => {
                $("#codigoPresupuestario").select2('destroy').val(data[0].codigo_presupuesto).select2();
            }, 400);
            $scope.rendicion.dimUno = data[0].dimensione_id;
            $scope.rendicion.dimDos = data[0].estadios;
            $scope.rendicion.dimTres = data[0].contenido;
            $scope.rendicion.dimCuatro = data[0].canal_distribucion;
            $scope.rendicion.dimCinco = data[0].otros;
            $scope.rendicion.proyecto = data[0].proyectos;
            //$scope.item.id= data[0].codigo_presupuesto;
            $scope.rendicion.codigoPresupuestario = data[0].codigo_presupuesto;
              
        });
    }

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

    $scope.subiendo = function(form) {
        //event.preventDefault();
        var i =0;
        /*$("#myFormulario").find('select').each(function(v, e){
            if(e.value != ""){
                console.log($('#'+e.id+" option[value="+e.value+"]").attr("selected","selected"));
            }
        });*/

        if($scope.rendicion.cantidad == undefined || $scope.rendicion.cantidad == 0){
            $("[for=cantidad]").text('Debe ingresar cantidad').css('color', 'red');
        }else{
            $("[for=cantidad]").text('');
            i = i + 1;
        }

        if($scope.rendicion.producto == undefined || $scope.rendicion.producto == ''){
            $("[for=producto]").text('Campo obligatorio').css('color', 'red');
        }else{
            $("[for=producto]").text('');
            i = i + 1;
        }

        if($scope.rendicion.precio == undefined || $scope.rendicion.precio==0){
            $("[for=precio]").text('Debe ingresar precio').css('color', 'red');
        }else{
            $("[for=precio]").text('');
            i = i + 1;
        }

        if($scope.rendicion.dimUno == undefined || $scope.rendicion.dimUno == ''){
            $("[for=gerencia]").text('Campo obligatorio').css('color', 'red');
            
        }else{
            $("[for=gerencia]").text('');
            i = i + 1;
        }

        if($scope.rendicion.codigoPresupuestario == undefined || $scope.rendicion.codigoPresupuestario == ''){
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
        if(Object.keys($scope.guardarRendicion).length == 0){
            alert('Todos los campos son obligatorios');
            $("[for=fecha_documento]").text('Campo obligatorio').css('color', 'red');
            //$("[for=titulo]").text('Campo obligatorio').css('color', 'red');
           // $("[for=observacion]").text('Campo obligatorio').css('color', 'red');
            return false;
        }else{
            if($scope.guardarRendicion.fecha_documento){
                $("[for=fecha_documento]").text('');
                i = i + 1;
            }else{
                $("[for=fecha_documento]").text('Campo obligatorio').css('color', 'red'); 
            }

           /* if($scope.guardarRendicion.observacion){
                $("[for=observacion]").text('');
                i = i + 1;
               
            }else{
                $("[for=observacion]").text('Campo obligatorio').css('color', 'red');
              
            }*/

            if(Object.keys($scope.documetosRendicion).length==0){
                $("[for=doc]").text('Debe ingresar documentos').css('color', 'red');
                //return false;
            }else{
                $("[for=doc]").text('');
                i = i + 1;
            }

           if(Object.keys(listaRendicion).length==0){
                $("[for=gridOptions]").text('Debe ingresar detalle de gastos').css('color', 'red');
                //return false;
            }else{
                $("[for=gridOptions]").text('');
                i = i + 1;
            }

            if(i < 3){

                return false;
            }  
        }
        solicitudesRendicion.guardaRedicionFondos($scope.guardarRendicion, listaRendicion, $scope.documetosRendicion, $scope.totalGastos, idFolio).success(function(data){
            window.location.href = host+"solicitudes_requerimientos/view_solicitud";
        });
    }


    $scope.sumaResta = function(){
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


