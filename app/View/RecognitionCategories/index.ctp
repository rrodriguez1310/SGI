<div ng-controller="recognitionCategories" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<?php echo $this->element('botonera'); ?>

	<div class="modal fade" id="modal-default">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" style="color: black !important;">Categoría</h4>
				</div>
				<div class="modal-body">
					<p>Desea eliminar esta categoría?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary confirmar" id="{{id}}" data-original-title="Eliminar" href="#"  data-placement="top" data-toggle="tooltip" title="">Aceptar</button>
				</div>
			</div>
		</div>
	</div>

	<div>
		<br>
		<div ng-show="tablaDetalle">
			<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
		</div>
	</div>


</div>
	
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/recognition/recognition',
		'angularjs/controladores/recognition/recognition',
		'angularjs/directivas/confirmacion'

	));
?>

<script>
	var id="";
    $(".eliminar").click(function(){
		id = $(this).attr("id");
        /*if (confirm("el registro sera eliminado!") == true) {
           window.location.href = "recognitionCategories/delete/"+eliminado;
		}*/
	})

	$(".confirmar").click(function(){
		 window.location.href = "recognitionCategories/delete/"+id;
    })
</script>

