<div style="text-align:center;">
	<h2>Seleccione comportamiento a reconocer.</h2>
</div>
<form class="form-horizontal">
	<div class="container">
		<div class="col-md-10 col-md-offset-1 toppad" >
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h3 class="panel-title"><?php echo __('Comportamientos'); ?></h3>
						</div>
					</div>
				</div>
				<div class="panel-body">	
					<div class="col-md-12">
						<div class="panel-body">
							<?php foreach ($subConducts as $subconduct): ?>
								<?php
								$comportamiento =$subconduct['RecognitionSubconduct']['id']; 
								$valorComportamiento = $subconduct['RecognitionSubconduct']['points'];
									$array = array($id, $subconduct['RecognitionSubconduct']['id'],$subconduct['RecognitionSubconduct']['points']); 
									$param = implode("-", $array);
								?>
                                <div  class="col-md-12">
					<div class="col-md-2 "><?php echo $this->Html->image('../files/recognition_conduct/image/'.$subconduct['Conduct']['imagedir'].'/vga_'.$subconduct['Conduct']['image'],array('fullBase' => true, "style"=>"width:50%; height:50%;")); ?></div>
					<div class="col-md-10 ">
			   			<a id="<?php echo $subconduct['RecognitionSubconduct']['id']; ?>" href="<?php echo $this->Html->url(array('action'=>'validar', $id,$comportamiento,$valorComportamiento))?>" class=" btnSubConducts btn btn-default btn-block" style="     text-align: left !important; color:black !important; border-color:<?php echo $subconduct['Conduct']['color'];?> !important; border-color:#635454; color:#fff; font-size: 16px;"><i class=""></i><?php echo ucwords($subconduct['RecognitionSubconduct']['name']); ?></a>
					</div>
				</div>
                            <?php endforeach; ?> 
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default"><i class="fa fa-mail-reply-all"></i> Volver</a>
				</div> 
			</div>
		</div>
	</div>
</form>

<script>
	/*var txt;
	$('.subConduct').click(function() {
		var r = confirm("Press a button!");
		if (r == true) {
			txt = "Esta seguro de evaluar esta sub-conducta";
		} else {
			txt = "You pressed Cancel!";
		}
		});*/
</script>

