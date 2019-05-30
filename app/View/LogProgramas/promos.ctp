<div ng-controller="Promociones">
    <form class="form-inline" ng-submit="listaLog.enviar()">
        <div class="form-group">
            <label class="sr-only" for="exampleInputEmail3">Fecha Inicio</label>
        <?php 
                echo $this->Form->input('fecha_inicio', array(
                    "class"=>"form-control fechaInicio", 
                    "label"=>false, 
                    'placeholder'=>"Fecha Inicio dd-mm-yyyy", 
                    "ng-model"=>"form.fechaInicio"
                ));
            ?>
        </div>
        <div class="form-group">
            <label class="sr-only" for="exampleInputPassword3">Fecha fin</label>
            <?php 
                echo $this->Form->input('fecha_fin', array(
                    "class"=>"form-control fechaFin", 
                    "label"=>false,  
                    'placeholder'=>"Fecha Fin dd-mm-yyyy", 
                    "ng-model"=>"form.fechaFin"
                ));
            ?>
        </div>
        <button type="submit" class="btn btn-default" ng-click="enviaFecha(form)"><i class="fa fa-search" ></i></button>
    </form>
    <p ng-bind-html="cargador" ng-show="loader"></p>
    <br/>
    <div ng-show="detalle">
        <div id="grid1" ui-grid="gridOptions" ui-grid-resize-columns ui-grid-exporter ui-grid-selection class="grid"></div>


        <h4>Informe exhibición desde el {{form.fechaInicio}} hasta el {{form.fechaFin}}</h4>
        <highchart id="evolucionSubscribers" config="evolucionSubscribers"></highchart>

    </div>

    <modal visible="showModal">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<td class="text-center">Id</td>
						<td class="text-center">Fecha</td>
                        <td class="text-center">Nombre</td>
						<td class="text-center">Codigo</td>
                        <td class="text-center">Señal</td>
                        <td class="text-center">Inicio</td>
                        <td class="text-center">Duracion</td>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="agrupadoList in agrupado">
						<td class="text-center">{{agrupadoList.id}}</td>
						<td class="text-center"> {{agrupadoList.fecha}}</td>
                        <td class="text-center"> {{agrupadoList.nombre}}</td>
						<td class="text-center">{{agrupadoList.media}}</td>	
                        <td class="text-center">{{agrupadoList.signal}}</td>
						<td class="text-center"> {{agrupadoList.horaInicio}}</td>
						<td class="text-center">{{agrupadoList.duracion}}</td>	
					</tr>
				</tbody>
			</table>
		<div class="modal-footer">
	        <button type="button" class="btn btn-default" ng-click="cerrarModal()" data-dismiss="modal">Cerrar</button>
	    </div>
	</modal>
    

</div>

<?php 
    echo $this->Html->script(array(
        'highcharts-no-data-to-display',
        'angularjs/controladores/app',
        'angularjs/controladores/logProgramas/logProgramas.js',
        'bootstrap-datepicker',
        'angularjs/directivas/modal/modal',
    ));
?>

<script>
	$('.fechaInicio, .fechaFin').datepicker({
	    format: "dd-mm-yyyy",
	    language: "es",
	    multidate: false,
	    autoclose: true,
	    required: true,
    });
</script>