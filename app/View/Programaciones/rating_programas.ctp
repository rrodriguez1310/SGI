<style>
.container{
    width:100%;
}
</style>

<div ng-controller="RatingProgramas" ng-init>
    <p ng-bind-html="cargador" ng-show="loader"></p>
    <div class="col-md-12" style="margin-bottom:20px;">
        <form class="form-inline" ng-submit="listaLog.enviar()">
            <div class="form-group">
                <?php echo $this->Form->input('fecha_desde', array("class"=>"form-control fechaInicio", "label"=>false, 'placeholder'=>"Seleccione un fecha", "ng-model"=>"form.fecha"));?>
            </div>
                <div class="form-group" style="margin-top:10px;">
                <?php echo $this->Form->input('signal', array(
                    "class"=>"form-control", 
                    "label"=>false, 
                    'placeholder'=>"Seleccione señal", 
                    'options'=>array('CDF Básico'=>'Basico', 'CDF Premium'=>'Premium', 'CDF HD'=>'Hd'), 
                    'type'=>'select', 
                    "ng-model"=>"form.signal",
                    'empty' => 'Seleccione una señal'
                ));?>
            </div>
            <button type="submit" class="btn btn-default" ng-click="enviaFecha(form)"><i class="fa fa-search"></i> Buscar</button>
        </form>
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Programación</h4></div>
            <div id="grid1" ui-grid="gridOptions" ui-grid-cellnav ui-grid-resize-columns ui-grid-exporter class="grid"></div>
        </div>
    </div>
</div>

<?php 
    echo $this->Html->script(array(
        'angularjs/controladores/app',
        'angularjs/controladores/programaciones/ratingProgramas.js',
        'bootstrap-datepicker'
    ));
?>

<script>
	$('.fechaInicio').datepicker({
	    format: "yyyy-mm-dd",
	    language: "es",
	    multidate: false,
	    autoclose: true,
	    required: true,
    });
</script>