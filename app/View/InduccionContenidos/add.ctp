<?php 
	echo $this->Html->css("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css");
	echo $this->Html->css("froala_editor.css");
	echo $this->Html->css ("froala_style.min.css");
	echo $this->Html->css("froala/fullscreen.css");
	echo $this->Html->css("froala/table.css");
	echo $this->Html->css("froala/colors.css");
	echo $this->Html->css("https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css");
	echo $this->Html->css("https://fonts.googleapis.com/css?family=Source+Sans+Pro");
	echo $this->Html->css("https://fonts.googleapis.com/css?family=Muli|Source+Sans+Pro");

	echo $this->Html->script ("froala_editor.min.js");
	echo $this->Html->script ("plugins/fullscreen.min.js");
	echo $this->Html->script ("plugins/table.min.js");
	echo $this->Html->script ("plugins/align.min.js");
	echo $this->Html->script ("plugins/colors.min.js");
	echo $this->Html->script ("plugins/font_size.min.js");
	echo $this->Html->script ("plugins/font_family.min.js");
	echo $this->Html->script ("plugins/draggable.min.js");
	echo $this->Html->script ("plugins/lists.min.js");
	echo $this->Html->script ("plugins/paragraph_format.min.js");
	echo $this->Html->script ("plugins/paragraph_style.min.js");
	echo $this->Html->script ("plugins/emoticons.min.js");
	echo $this->Html->script ("plugins/code_beautifier.min.js");
	echo $this->Html->script ("plugins/code_view.min.js");
	echo $this->Html->script ("plugins/image.min.js");
	echo $this->Html->script ("plugins/image_manager.min.js");
	echo $this->Html->script ("plugins/save.min.js");

?>
<div class="col-sm-offset-3 col-sm-8">
	<h2><?php echo __('Registrar Contenido'); ?></h2>
</div>
<div class="col-md-12 col-md-offset-1">
	<br/>
	<div class="induccionContenidos form">
	<?php echo $this->Form->create('InduccionContenido',array('type' => 'file', 'class' => 'form-horizontal')); ?>
		<fieldset>
			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Título: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('titulo', array("type"=>"text", "class"=>"form-control", "label"=>false));?>
				</div>
			</div>
			
			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Orden: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('peso', array("type"=>"number", "min"=>"1", "class"=>"form-control", "label"=>false));?>
				</div>
			</div>

			<!--div class="form-group">
				<label for="" class="col-sm-3 control-label">Quiz: </label>
				<div class="col-sm-5">
					<?php echo $this->Form->checkbox('quiz', array( 'value' => '1','default' => '0',));?>
				</div>
			</div-->
			<?php echo $this->Form->input('quiz', array('type' => 'hidden', 'value'=>0));?>


			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Imagen: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('image', array('type' => 'file', "class"=>"form-control", "accept"=>".jpg, .jpeg, .png", "label"=>false ,'id' => 'foto',));?>
				</div>
			</div>
			
			<?php echo $this->Form->input('imagedir', array('type' => 'hidden'));?>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Lección: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('induccion_etapa_id', array(
							"type"=>"select", 
							"class"=>"form-control", 
							"label"=>false, 
							'empty' => 'Seleccione...',
							'options'=>$etapas
						));
					?>
				</div>
			</div>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Estado: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('induccion_estado_id', array(
							"type"=>"select", 
							"class"=>"form-control", 
							"label"=>false, 
							'empty' => 'Seleccione...',
							'options'=>$estados
						));
					?>
				</div>
			</div>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Descripción: </label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('descripcion', array("type"=>"textArea", "class"=>"form-control", "label"=>false,"id"=>"froala-editor", "name"=>"descripcion"));?>
				</div>
			</div>

			<div> 
				<div class="col-sm-offset-1 col-sm-8 box-footer">
					<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default pull-left"><i class="fa fa-mail-reply-all"></i> Volver</a>
					<button class="mostrar btn btn-primary pull-right" type="submit"><i class="fa fa-pencil"></i> Registrar</button>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</fieldset>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#foto').css({'color':'transparent'});

		$('.file').click(function() {
			$('#foto').css({'color':'black'});
		});

		$(function() {
			$('textarea#froala-editor').froalaEditor({
				fontFamily: {
					"Source Sans Pro, sans-serif": 'Trebuchet MS',
					"Muli', sans-serif": "Muli"
				},
				fontFamilySelection: true,
				imageManagerPreloader: "http://localhost/sgi-v3/app/webroot/img/loading.gif",
				imageManagerLoadURL:"http://localhost/sgi-v3/induccionContenidos/image_json",
				imageManagerLoadMethod: "GET"
			})
		});
	});
</script>

<style>
	a[href="https://froala.com/wysiwyg-editor"], a[href="https://www.froala.com/wysiwyg-editor?k=u"] {
	  display: none !important;
	  position: absolute;
	  top: -99999999px;
	}
</style>

