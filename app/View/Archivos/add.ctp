<div class="col-md-10 col-md-offset-1">
  <?php echo $this->Form->create('Archivo', array('class' => 'form-horizontal','type' => 'file')); ?>
    <h2><?php echo __('Upload Video'); ?></h2>
    <div class="form-group">
      <label class="col-md-2 control-label baja">Categoria</label>
      <div class="col-md-7">
        <?php echo $this->Form->input('Archivo.categorias_archivo_id', array("class"=>"form-control mayuscula autocompletar", "placeholder"=>"Seleccione una categoria", "label"=>false, "required"=>"required", 'maxlength'=>'100', "id"=>"categorias_archivo_id", "empty"=>""));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label baja">Nombre</label>
      <div class="col-md-7">
        <?php echo $this->Form->input('Archivo.nombre', array("type"=>"text","class"=>"form-control  ",  "label"=>false, "required"=>"required", 'maxlength'=>'300', "readonly"=>"readonly", "id"=>"nombre"));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label baja"></label>
      <div class="col-md-7">
        <?php echo $this->Form->input('file', ['type' => 'file', 'class' => 'form-control']); ?>
      </div>
    </div>
    <button type="submit" id="submit" class="btn btn-md btn-primary"><i class="fa fa-plus"></i> Upload File</button>

    <?php echo $this->Form->end(); ?>
</div>

<script>
  $("#categorias_archivo_id").select2();

  $(".mayuscula").on("change", function() {
    $(this).val($(this).val().toUpperCase())
  });

  $(".autocompletar").bind("keyup change", function() {
    if ($.trim($("#categorias_archivo_id").val()) == 1) {
      $("#nombre").val($.trim('bienvenida.mp4'));
    } else if ($.trim($("#categorias_archivo_id").val()) == 2) {
      $("#nombre").val($.trim("historia.mp4"));
    } else if ($.trim($("#categorias_archivo_id").val()) == 3) {
      $("#nombre").val($.trim("negocio_cliente.mp4"));
    } else if ($.trim($("#categorias_archivo_id").val()) == 4) {
      $("#nombre").val($.trim("realizacion_servicio.mp4"));
    } else if ($.trim($("#categorias_archivo_id").val()) == 5) {
      $("#nombre").val($.trim("mapa_estrategico.mp4"));
    } else if ($.trim($("#categorias_archivo_id").val()) == 6) {
      $("#nombre").val($.trim("gestion_personas.mp4"));
    } else {
      $("#nombre").val($.trim("relaciones_laborales.mp4"));
    }
  });
</script>