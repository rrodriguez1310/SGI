<!DOCTYPE html>
<html lang="en" ng-app="<?php echo (isset($appAngular) ? $appAngular : "angularApp"); ?>">
<head>
  <meta charset="utf-8">
  <title>CDF SGI</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

    <!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
    <!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
    <!--script src="js/less-1.3.3.min.js"></script-->
    <!--append ‘#!watch’ to the browser URL, then refresh the page. -->
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">
    
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php //echo $cakeDescription; ?>
        <?php //echo $title_for_layout; ?>
    </title>
    <?php
        //echo $this->Html->meta('icon', $this->Html->url('favicon.png', array("type"=>"image/x-icon")));
        //echo $this->Html->meta('icon', $this->Html->url('/img/favicon.png'));
        echo $this->Html->meta('icon');

        echo $this->Html->css(array(
            'bootstrap.min',
            'bootstrap-multiselect.css',
            'font-awesome/css/font-awesome.min',
            'bootstrap-switch.min',
            'select2',
            'select2-bootstrap',
            'datatable',
            'bootstrap-editable',
            //'summernote-bs3',
            'PrintArea',
            'angular/ng-grid/ng-grid',
            'angular/ui-grid/ui-grid.min',
            'angular/angular-flash/angular-flash.min',
            'angular/select/select.min',
            //'angular/ng-table',
            //'angular/data-tables/jquery.dataTables.min',
            'style'
            
        ));
        
        echo $this->Html->script(array(
            'angularjs/jquery',
            'bootstrap.min',
            'angularjs/angular.min',
            'angularjs/modulos/ui-grid/ui-grid.min',
            'angularjs/modulos/ui-grid/angular-animate',
            'angularjs/modulos/ui-grid/csv',
            'angularjs/modulos/ui-grid/pdfmake',
            'angularjs/modulos/ui-grid/vfs_fonts',
            'angularjs/modulos/sanitize.min',
            'angularjs/angular-locale_es-cl',
            'highcharts.js',
            'modules/exporting',
            'highcharts-ng.min',
            'jquery.validate.min',
            'angularjs/modulos/angular-flash/angular-flash.min',
            'angularjs/modulos/ng-file-upload',
            'angularjs/modulos/select/select.min',
            'angularjs/modulos/enrutador/angular-route.min',
            'angularjs/modulos/angular-rut/angular-rut.min',
            "angularjs/modulos/select2/angular-select2.min",
            'moment'
        ));
            
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>  
</head>

<body>
<?php echo $this->element('cabecera'); ?>
<div class="<?php echo (isset($layoutContent) ? $layoutContent : "container"); ?> sombra">
    <?php echo $this->element('miga'); ?>
    <?php echo $this->Session->flash(); ?>
    <div flash-message="5000" ></div> 
    <?php echo $this->fetch('content'); ?>
</div>
<?php echo $this->element('pie'); ?>
<?php echo $this->element('sql_dump'); ?>

<div class="modal fade" id="informeAbonados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Generar Informe de Abonados</h4>
      </div>
      <div class="modal-body">
        <div class="informeAbonados"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="envioInformeAbonados" tabindex="-1" role="dialog" aria-labelledby="envioInformeAbonados" aria-hidden="true">
    <div class="modal-dialog" style="width: 20%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cancelar_envio_informe_abonados" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">cerrar</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Enviar informe de abonados</h4>
            </div>
            <div class="modal-body">
                <a href="#" class="btn btn-primary btn-block informeAbonados">Enviar informe abonados</a>
                <button type="button" class="cancelar_envio_informe_abonados btn btn-danger btn-block" data-dismiss="modal" onclick="cancelarEnviarInforme()">Cancelar</button>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>
    $(".filtroInformeAbonados").on("click", function(){
        $.ajax({ 
            type: 'GET', 
            url: '<?php echo $this->Html->url(array('controller'=>'subscribers', 'action'=>'informe_abonados'))?>', 
            dataType: "html",
            success: function (data) { 
                $('.informeAbonados').html(data);
            }
        });
    });

    filtroInformeAbonadosPromociones = document.getElementsByClassName("filtroInformeAbonadosPromociones")[0];
    if(typeof filtroInformeAbonadosPromociones != "undefined"){
        filtroInformeAbonadosPromociones.addEventListener('click', function() {
            $.ajax({ 
                type: 'GET', 
                url: '<?php echo $this->Html->url(array('controller'=>'subscribers', 'action'=>'informe_abonados', 1))?>', 
                dataType: "html",
                success: function (data) { 
                    $('.informeAbonados').html(data);
                }
            });
        });
    }
    $(".tool").tooltip();
    /*
    $(".cancelar_envio_informe_abonados").on("click", function(){
        window.onload = Exito();
        location.reload();
    })
    */
    uiGrid = $("[ui-grid=gridOptions]");
    if(uiGrid.length!=0){
        directivas = {};
        if(uiGrid.attr("ui-grid-auto-resize") === undefined){
            directivas["ui-grid-auto-resize"] = "";
        }
        if(uiGrid.attr("ui-grid-resize-columns") === undefined){
            directivas["ui-grid-resize-columns"] = "";       
        }
        if(Object.keys(directivas).length!=0){
            uiGrid.attr(directivas);
        }            
    } 
    
</script>
</body>
</html>


