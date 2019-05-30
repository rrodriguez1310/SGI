<div ng-controller="sistemasIncidenciasIndex" class="col-md-12" ng-cloak ng-init="usuarioId(<?php echo $this->Session->Read("PerfilUsuario.idUsuario"); ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Listado Incidencias</h3>
			</div>
		</div>
		<br />              
	  <br>
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->element('botonera'); ?>
			</div>
		</div>
		<div class="col-md-3">
                   <input class="form-control" id="date" name="date"ng-model="term" ng-change="filterGender()" placeholder="Seleccione fecha"  type="text" required/>
				  
        </div>
		<div class="row">	<button class="btn btn-primary btn-lg" ng-click="refreshData()"><i class="fa fa-eraser"></i> Limpiar</button></div>
		<br>
		<br>
		<br>
		<div class="row">
		
			<div class="col-md-12">
				<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid" ui-grid-resize-columns ui-grid-auto-resize></div>
			</div>
		</div>
	</div>
</div>
<?php
echo $this->Html->script(array(
	"angularjs/controladores/app",
	"angularjs/servicios/sistemas_incidencias/sistemas_incidencias",
	"angularjs/servicios/areas/areas",
	//"angularjs/servicios/gerencias/gerencias",
	"angularjs/servicios/users/lista_users_service",
	"angularjs/servicios/sistemas_responsables_incidencias/sistemas_responsables_incidencias",
	"angularjs/servicios/trabajadores",
 	"angularjs/factorias/users/users",
 	"angularjs/factorias/factoria",
	"angularjs/controladores/sistemas_incidencias/sistemas_incidencias",
	'angularjs/directivas/confirmacion',
	
));
echo $this->Html->css('bootstrap-clockpicker.min');
echo $this->Html->script(array(
'bootstrap-datepicker',
'bootstrap-clockpicker.min'
));
?>
<script>
	$(document).ready(function() {
      var date_input = $('input[name="date"]');
      var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
      var options = {
        format: "yyyy-mm-dd",
        
        autoclose: true
      };
      date_input.datepicker(options);
    });
</script>