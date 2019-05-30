app.controller('controllerSolicitudesRechazo', ['$scope', '$http', '$filter', 'solicitudesRendicion', function($scope, $http, $filter, solicitudesRendicion) {
    $scope.tablaDetalle = false;
    $scope.loader = true;
    $scope.cargador = loader;

    var i=1;
    var listaRendicion = [];
    $scope.rendicion = {};
    $scope.rendicionList = {};
   // $scope.guardarRendicion = [];
    //$scope.formularioSolicitud = [];
    $scope.total = [];
    $scope.totalx = 0;
    $scope.documetosRendicion = {};
    $scope.guardarRendicion = {};
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
       // enableGridMenu: true, 
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

                $scope.gridOptions.data.splice(rowIndexToDelete, 1);

                $scope.sumaResta();
                $scope.eliminarBtnGrilla = false;
                if(rowEntity.id!=0){
                    solicitudesRendicion.eliminaRegistro(rowEntity.id).success(function(data){
                        return false; 
                    });

                    
                }
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

$scope.carga=function(id){
    solicitudesRendicion.listaRequerimientosRechazo(id).success(function(data){  
       
        if(data.length > 0){
            $scope.loader = false
            $scope.tablaDetalle = true;
            $scope.gridOptions.data = data
            $scope.sumaResta();

            
        }

        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(row.isSelected == true){
                if(row.entity.id){
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
        });      
    })

   
    solicitudesRendicion.cargaDinamicaFondoFijo(id).success(function(data){

        $scope.guardarRendicion.fecha_documento = data[0].fecha;
        $scope.guardarRendicion.solicitud = data[0].ndocumento;
        $scope.guardarRendicion.montoSolis = data[0].nmonto;
        $scope.guardarRendicion.titulo = data[0].titulo;
        $scope.guardarRendicion.company_id = data[0].proveedor;

        //$("#company_id").select2('destroy').val(data[0].proveedor).select2();
        $("#plazos_pago_id").select2('destroy').val(data[0].plazo).select2();
        $("#tipo_moneda_id").select2('destroy').val(data[0].moneda).select2();
        $scope.guardarRendicion.tipo_moneda_id=data[0].moneda; 
        $scope.guardarRendicion.observacion = data[0].observacion;
        $scope.guardarRendicion.plazos_pago_id = data[0].plazo;
        
    });

    $scope.guardaRendicionSubmit = function(id){
        var idFolio = $("#folio").val();

        if(Object.keys($scope.guardarRendicion).length ==0){
            alert('Todos los campos son obligatorios');
                $("[for=fecha_documento]").text('Campo obligatorio').css('color', 'red');
                //$("[for=company_id]").text('Campo obligatorio').css('color', 'red');
                //$("[for=plazos_pago_id]").text('Campo obligatorio').css('color', 'red');
                $("[for=titulo]").text('Campo obligatorio').css('color', 'red');
               // $("[for=observacion]").text('Campo obligatorio').css('color', 'red');
            return false;
        }else{
            if($scope.guardarRendicion.fecha_documento!=''){
                $("[for=fecha_documento]").text('');
            }else{
                $("[for=fecha_documento]").text('Campo obligatorio').css('color', 'red'); 
                return false;
            }

            if($scope.guardarRendicion.company_id!=''){
                $("[for=company_id]").text('');
            }else{
                $("[for=company_id]").text('Campo obligatorio').css('color', 'red');
                return false;
            }
     
            if($scope.guardarRendicion.plazos_pago_id!=''){
                $("[for=plazos_pago_id]").text('');
              
            }else{
                $("[for=plazos_pago_id]").text('Campo obligatorio').css('color', 'red');
                return false;
            }

            if($scope.guardarRendicion.titulo!=''){
                $("[for=titulo]").text('');
               
            }else{
                $("[for=titulo]").text('Campo obligatorio').css('color', 'red');
                return false;
            }

           /* if($scope.guardarRendicion.observacion!=''){
                $("[for=observacion]").text('');
               
            }else{
                $("[for=observacion]").text('Campo obligatorio').css('color', 'red');
                return false;
            }*/
            
           /* if(Object.keys($scope.documetosRendicion).length==0){
                $("[for=doc]").text('Debe ingresar documentos').css('color', 'red');
                return false;
            }else{
                $("[for=doc]").text('');
            }*/
           if($scope.gridOptions.data.length==0){
                $("[for=gridOptions]").text('Debe ingresar detalle de gastos').css('color', 'red');
                return false;
            }else{
                $("[for=gridOptions]").text('');
            }
          
        }
        solicitudesRendicion.actualizaRedicionFondosFijo($scope.guardarRendicion, $scope.gridOptions.data, $scope.documetosRendicion, $scope.totalGastos, idFolio, id).success(function(data){
             window.location.href = host+"solicitud_rendicion_totales/view_lista_fijos";
        });
    }

}

  
    $scope.submit = function(id) {
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
        var  largo = $scope.gridOptions.data.length;

        //$scope.total = eval(sum.join("+"))
        solicitudesRendicion.formularioRendicionFondoEdit($scope.rendicion, largo, id).success(function(data){

          for(var i =0; i<data.length;i++){
            listaRendicion.push(data[i]);
          }
           // return
            $scope.gridOptions.data = listaRendicion;
            /*$('#cantidad').val('')
            $('#n_folio').val('')
            $('#producto').val('')
            $('#precio').val('')
            $('#descuento_producto').val('')
            $('#descuento_producto_peso').val('')*/

            $scope.rendicion.company_id=0;
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


