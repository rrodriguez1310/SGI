app.controller('controllerSolicitudesViaticosEdit', ['$scope', '$http', '$filter', 'solicitudesRendicionviaticos', function($scope, $http, $filter, solicitudesRendicionviaticos) {
    $scope.tablaDetalle = false;
    $scope.loader = false;
    $scope.cargador = loader;
    var i=1;
    var listaRendicion = [];
    $scope.rendicion = {};
    $scope.rendicionList = [];
    $scope.guardarRendicion = {};
    //$scope.formularioSolicitud = [];
    $scope.total = [];
    $scope.totalx = 0;
    $scope.documetosRendicion = [];
    $scope.totalGastos=[];

    $scope.total=0;
    $scope.total1=0;


    var largo = 0;
    var id =0;
    var suma = [];
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
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                $scope.eliminarBtnGrilla = true;
                
            });
        }
    };  

    angular.element(".clockpicker").clockpicker({
        placement: 'bottom',
        align: 'top',
        autoclose: true
    });

    $scope.deleteRow = function(row) {
        var r = confirm("Desea eliminar el registro!");
        if(r){
                var selectedRowEntities = $scope.gridApi.selection.getSelectedRows();
                angular.forEach(selectedRowEntities, function(rowEntity, key) {
                var rowIndexToDelete = $scope.gridOptions.data.indexOf(rowEntity);

                $scope.gridOptions.data.splice(rowIndexToDelete, 1);
                $scope.totalGastos = $scope.totalGastos - rowEntity.sub;

                $scope.eliminarBtnGrilla = false;
               
                if(rowEntity.id!=0){
                    solicitudesRendicionviaticos.eliminaRegistro(rowEntity.id).success(function(data){
                        $scope.sumaResta();
                        return false; 
                    });
                }
            })
        }
    };

    $scope.gridOptions.columnDefs = [
       /// {name:'Eliminar',cellTemplate: '<a href="#" ng-click="grid.appScope.deleteRow(row.entity)" align="center"><span class="glyphicon glyphicon-trash"></span></a>'},
        {name:'descripcion', displayName: 'Descripcion'},
        {name:'colaborador', displayName: 'Colaborador'},
        {name:'monto', displayName: 'Monto'},
        {name:'gerencia', displayName: 'Gerencia'},
        {name:'estadio', displayName: 'Estadio'},
        {name:'contenido', displayName: 'Contenido'},
        {name:'canales_distribucion', displayName: 'Canales de distrubucion'},
        {name:'otros', displayName: 'Otros'},
        {name:'proyectos', displayName: 'Proyectos'},
        {name:'codigo_presupuestario', displayName: 'Codigo presupuesto'}
    ];



    $scope.carga=function(id){

    solicitudesRendicionviaticos.listaRendicioViatico(id).success(function(data){  
        //alert(data.descripcion)
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
        largo = $scope.gridOptions.data.length;
        id = id;
    })

    solicitudesRendicionviaticos.cargaDinamicaFondoViatico(id).success(function(data){
            $scope.guardarRendicion.fecha_inicio = data.SolicitudRequerimientoViatico.fecha_inicio;
            $scope.guardarRendicion.fecha_termino = data.SolicitudRequerimientoViatico.fecha_termino;
            $scope.guardarRendicion.hora_inicio = data.SolicitudRequerimientoViatico.hora_inicio;
            $scope.guardarRendicion.hora_termino = data.SolicitudRequerimientoViatico.hora_termino;
            $scope.guardarRendicion.responsable = data.SolicitudRequerimientoViatico.responsable;
            $scope.guardarRendicion.titulo = data.SolicitudRequerimientoViatico.titulo;
            $("#tipo_moneda_id").select2('destroy').val(data.SolicitudRequerimientoViatico.tipo_moneda).select2();
            $scope.guardarRendicion.observacion = data.SolicitudRequerimientoViatico.observacion;
            
        });
    };
    var sum = [];
    var sum2 = $scope.totalGastos;
    $scope.submit = function(id) {

       $scope.myFormulario.$setPristine();
       var i = 0;
      

        if(Object.keys($scope.rendicion).length ==0){

            alert('Todos los campos son obligatorios');
            $("[for=descripcion]").text('Campo obligatorio').css('color', 'red');
            $("[for=producto]").text('Campo obligatorio').css('color', 'red');
            $("[for=colaborador]").text('Campo obligatorio').css('color', 'red');
            $("[for=monto]").text('Campo obligatorio').css('color', 'red');
            $("[for=gerencia]").text('Campo obligatorio').css('color', 'red');
            $("[for=codigoPresupuestario]").text('Campo obligatorio').css('color', 'red');
            return false;
        }else{
            if( $scope.rendicion.descripcion != undefined ){
                $("[for=descripcion]").text('');
                i = i + 1;
            }else{
                $("[for=descripcion]").text('Campo obligatorio').css('color', 'red');
            }

            if($scope.rendicion.colaborador != undefined){
                $("[for=colaborador]").text('');
                i = i + 1;
               // sum.push($scope.rendicion.precio.replace(/\./g,''))
            }else{
                $("[for=colaborador]").text('Campo obligatorio').css('color', 'red');
            }

            if($scope.rendicion.monto != undefined){
                $("[for=monto]").text('');
                //sum.push($scope.rendicion.monto.replace(/\./g,''))
                i = i + 1;
            }else{
                $("[for=monto]").text('Campo obligatorio').css('color', 'red');
            }

            if($scope.rendicion.dimUno == '' || $scope.rendicion.dimUno == undefined){
                $("[for=gerencia]").text('Campo obligatorio').css('color', 'red');
                //return false;
                
            }else{
                $("[for=gerencia]").text('');
                //return;
                i = i + 1;
            }

            if($scope.rendicion.codigoPresupuestario != undefined){
                $("[for=codigoPresupuestario]").text('');
                i = i + 1;
                
            }else{
                $("[for=codigoPresupuestario]").text('Campo obligatorio').css('color', 'red');
               
            }
            if(i <5){
                return false;
            }
        }
        var  largo = $scope.gridOptions.data.length;
    
    solicitudesRendicionviaticos.formularioRendicionFondo($scope.rendicion, largo, id).success(function(data){
     
        for(var i =0; i<data.length;i++){
            listaRendicion.push(data[i]);
            sum.push(data[i].monto)
          }
      //  $scope.total = eval(suma.join("+"))

        $scope.gridOptions.data = listaRendicion;

        /*$("#dimUno").select2('destroy').val('').select2();
        $("#dimDos").select2('destroy').val('').select2();
        $("#dimTres").select2('destroy').val('').select2();
        $("#dimCuatro").select2('destroy').val('').select2();
        $("#dimCinco").select2('destroy').val('').select2();
        $("#proyecto").select2('destroy').val('').select2();
        $("#proveedor").select2('destroy').val('').select2();
        $("#empaque").select2('destroy').val('').select2();    */  
        
        $("#codigoPresupuestario").select2('destroy').val('').select2();
        $scope.rendicion = {};
        $scope.sumaResta();

    }); 

    $("#ingresoProducto").modal('hide');
    };



   /* $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){

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
        
    });*/

    $scope.guardaRendicionSubmit = function(id){


        if(Object.keys($scope.guardarRendicion).length ==0){
            alert('Todos los campos son obligatorios');
            $("[for=fecha_inicio]").text('Campo obligatorio').css('color', 'red');
            $("[for=fecha_termino]").text('Campo obligatorio').css('color', 'red');
            $("[for=responsable]").text('Campo obligatorio').css('color', 'red');
            $("[for=titulo]").text('Campo obligatorio').css('color', 'red');
            return false;
        }else{
            if($scope.guardarRendicion.fecha_inicio){
                $("[for=fecha_inicio]").text('');
                i = i + 1;
            }else{
                $("[for=fecha_inicio]").text('Campo obligatorio').css('color', 'red'); 
            }

            if($scope.guardarRendicion.fecha_termino){
                $("[for=fecha_termino]").text('');
                i = i + 1;
            }else{
                $("[for=fecha_termino]").text('Campo obligatorio').css('color', 'red');
            }
     
            if($scope.guardarRendicion.responsable){
                $("[for=responsable]").text('');
                i = i + 1;
              
            }else{
                $("[for=responsable]").text('Campo obligatorio').css('color', 'red');
            }

            if($scope.guardarRendicion.titulo){
                $("[for=titulo]").text('');
                i = i + 1;
               
            }else{
                $("[for=titulo]").text('Campo obligatorio').css('color', 'red');
            }
            /*if(Object.keys($scope.documetosRendicion).length==0){
                $("[for=doc]").text('Debe ingresar documentos').css('color', 'red');
                //return false;
            }else{
                $("[for=doc]").text('');
                i = i + 1;
            }*/

            if($scope.gridOptions.data.length==0){
                $("[for=gridOptions]").text('Debe ingresar detalle de gastos').css('color', 'red');
                //return false;
            }else{
                $("[for=gridOptions]").text('');
                i = i + 1;
            }

            if(i <6){
                return false;
            }

        }  

        solicitudesRendicionviaticos.actualizaRedicionFondos($scope.guardarRendicion, $scope.gridOptions.data, $scope.documetosRendicion, $scope.totalGastos, id).success(function(data){
            window.location.href = host+"solicitud_requerimiento_viaticos";
        });
    }

    $scope.shows=function(id){

        if( id==5 || id==7 ){
            $scope.eliminarBtn = true;
        }else{
            $scope.eliminarBtn = false;
        }
    }

    $scope.estado= function(id){
        if($scope.datos!=undefined){
            $("[for=compra]").text('');
        }else{
            $("[for=compra]").text('Campo obligatorio').css('color', 'red'); 
            return false;
        }

      
        if($scope.eliminarBtn){
            if($scope.datos.observacion!=undefined){
                $("[for=observacion]").text('');

            }else{
                $("[for=observacion]").text('Campo obligatorio').css('color', 'red'); 
                return false;
            }
        }
    
        solicitudesRendicionviaticos.actualizaEstado(id, $scope.datos.compra, $scope.datos.observacion ).success(function(data){

            if($scope.datos.compra==4 || $scope.datos.compra==7){
                //console.log(host+"solicitudes_requerimientos/view_finanzas");
                window.location.href = host+"solicitud_requerimiento_viaticos/lista_finanza";
            }

            if($scope.datos.compra==1 || $scope.datos.compra==5){
                window.location.href = host+"solicitud_requerimiento_viaticos/lista_area";
            }
       });
    }


    $scope.sumaResta = function() {
        var sum = []; 
        var selectedRowEntities = $scope.gridOptions.data;
        angular.forEach(selectedRowEntities, function(rowEntity, key) {
            sum.push(rowEntity.monto.replace(/\./g,''));
        });
        var moneda = $("#moneda_observada").val();
            if(moneda!=''){
                $scope.totalGastos = (eval(sum.join("+")) * moneda);
            }else{
                $scope.totalGastos = eval(sum.join("+"));
            }
    }


    $scope.formatThusanNumber = function(){
        var num = $scope.rendicion.monto.replace(/\./g,'');
        if(!isNaN(num)){
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            //input.value = num;
            $("#monto").val(num);
        }
        else
        { 
            alert('Solo se permiten numeros');
            $("#monto").val($scope.rendicion.precio.replace(/[^\d\.]*/g,''));
        }
    }
}]);