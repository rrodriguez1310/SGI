<form class="form-inline">
    <div class="form-group">
        <label class="sr-only" for="exampleInputEmail3">Fecha Inicio</label>
       <?php 
            echo $this->Form->input('fecha_inicio', array(
                "class"=>"form-control fechaInicio", 
                "label"=>false, 
                'placeholder'=>"Seleccione un fecha", 
                //"ng-model"=>"form.fecha"
            ));
        ?>
    </div>
    <div class="form-group">
        <label class="sr-only" for="exampleInputPassword3">Fecha fin</label>
        <?php 
            echo $this->Form->input('fecha_fin', array(
                "class"=>"form-control fechaFin", 
                "label"=>false, 
                'placeholder'=>"Seleccione un fecha", 
                //"ng-model"=>"form.fecha"
            ));
        ?>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fa fa-search" ></i></button>
</form>

<div id="grid1" ui-grid="gridOptions" ui-grid-cellnav ui-grid-resize-columns ui-grid-exporter class="grid"></div>



<script>
	$('.fechaInicio, .fechaFin').datepicker({
	    format: "yyyy-mm-dd",
	    language: "es",
	    multidate: false,
	    autoclose: true,
	    required: true,
    });
</script>