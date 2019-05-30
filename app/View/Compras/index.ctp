<div ng-controller="MisCompras">
	<div class="col-md-12">
		<legend>Lista mis documentos</legend>
		<p ng-bind-html="cargador" ng-show="loader"></p>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>
            </div>
            <div class="panel-body" ng-init="isDisabled = true">
                <ul class="list-inline">
                    <li ng-show="botonVer">
                        <a class="btn-sm btn btn-primary tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"view"));?>/{{id}}" data-original-title="Ver detalle" target="_blank"><i class="fa fa-eye"></i></a/>
                    </li>
                    
                    <li ng-show="botonEditar">
                        <a class="btn-sm btn btn-success tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"edit"));?>/{{id}}" data-original-title="Editar"><i class="fa fa-pencil"></i></a>
                    </li>

                    <li ng-show="botonPlantilla">
                        <a class="btn-sm btn btn-warning tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"plantilla_boletas_facturas_add")); ?>/{{id}}" data-original-title="Usar plantilla"><i class="fa fa-recycle"></i></a/>
                    </li>
                    <li ng-show="botonPlantillaFac">
                        <a class="btn-sm btn btn-warning tool btn-xs" title="" data-placement="top" data-toggle="tooltip" href="<?php echo $this->Html->url(array("action"=>"plantilla_boleta_facturas_add_documento")); ?>/{{id}}" data-original-title="Usar plantilla"><i class="fa fa-recycle"></i></a/>
                    </li>

                    <li ng-show="botonClonarDocumento">
                        <a class="btn-sm btn btn-info tool btn-xs" data-original-title="Clonar orden de compra" href="<?php echo $this->Html->url(array("action"=>"clonar_documento_tributario")); ?>/{{id}}" data-toggle="tooltip" data-placement="top" title="">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>

                    <li ng-show="botonEditarDocumento">
                        <a class="btn-sm btn btn-success tool btn-xs" data-original-title="Editar Documento" href="<?php echo $this->Html->url(array("action"=>"clonar_documento_tributario_edit")); ?>/{{id}}" data-toggle="tooltip" data-placement="top" title="">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </li>

                    <li ng-show="botonNotasCredito">
                        <a class="btn-sm btn btn-naranjo tool btn-xs" data-original-title="Notas de credito" href="<?php echo $this->Html->url(array("action"=>"notas_credito")); ?>/{{id}}" data-toggle="tooltip" data-placement="top" title="">
                            <i class="fa fa-files-o"></i>
                        </a>
                    </li>

                    <li ng-show="botonEliminar">
                        <a class="btn-sm btn btn-danger tool btn-xs eliminar" id="{{id}}" data-original-title="Eliminar" href="#" data-toggle="tooltip" data-placement="top" title="">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </li>

                    <li ng-show="botonAsociarDocumento">
                        <a class="btn btn-info tool asociar_documentos_tributarios btn-xs"  data-original-title="Asociar Documento Tributario" href="#" data-toggle="tooltip" data-placement="top" title="">
                            <i class="fa fa-file-text"></i>
                        </a>
                        <!--button type="button" class="btn btn-info tool asociar_documentos_tributarios btn-xs" data-toggle="tooltip" data-placement="top" title="Asociar Documento Tributario"><i class="fa fa-file-text"></i></button-->
                    </li>
                </ul>
                <input class="form-control input-sm ng-pristine ng-untouched ng-valid" type="text" placeholder="Buscar" ng-change="refreshData(search)" ng-model="search">
            </div>
        </div>

		<div ng-show="tablaDetalle">
		    <div id="ListaCompras" ui-grid="gridOptions" ui-grid-selection ui-grid-exporter  class="grid"></div>
        </div>
		
	</div>
    <?php echo $this->Form->create('Compras', array('action' => 'asociar_facturas'));?>
        <input type="hidden" id="productosAsociados" name="idRequerimiento" ng-model="idsRequerimientos" value="{{idsRequerimientos}}">
    <?php echo $this->Form->end(); ?>
</div>
<?php
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/compras/compras',
		'angularjs/controladores/compras/mis_compras',
	));
?>

<script>
   // alert(window.location.href = "compras/delete/")
    $(".eliminar").click(function(){
        var id = $(this).attr("id");
        if (confirm("el registro sera eliminado!") == true) {
           window.location.href = "compras/delete/"+id;
        }
    })

    $(".asociar_documentos_tributarios").on('click', function(){
        //alert($("#productosAsociados").val());
        if($("#productosAsociados").val() != "")
        {
            $("#ComprasAsociarFacturasForm").submit();
        }
        else
        {
            alert("Seleccione un requerimiento");
            return false;
        }
    })
</script>