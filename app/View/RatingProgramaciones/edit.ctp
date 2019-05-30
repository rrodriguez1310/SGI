<id class="mensaje"></id>
<?php if(empty($this->request->data)): ?>
	<div class="col-md-12 col-md-offset-1">
		<form class="form-horizontal" action="<?php echo $this->Html->url(array('controller'=>'rating_programaciones', 'action'=>'edit')); ?>" method="POST">
			<div class="row">
				<div class="form-group">
					<div class="col-md-1 col-md-offset-3">
						<label for="fecha" class="control-label baja">Fecha</label>
					</div>
					<div class="input">
						<div class="col-md-3">
							<input type="text" id="fecha" name="fecha" class="form-control readonly-pointer-background" readonly="readonly" placeholder="Seleccione fecha"/>
						</div>	
					</div>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-4 col-md-offset-3">
					<button type="submit" class="btn btn-primary btn-lg btn-block">Buscar</button>	
				</div>
			</div>
		</form>
	</div>
<?php endif; ?>
<br/>
	<?php if(!empty($programaciones)): ?> 
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<h4><?php echo $fecha; ?></h4>
				</div>
			</div>
			<?php foreach($programaciones as $señal => $programacionesArray): ?>
				<div class="row">
					<div class="col-md-12">
						<h4><?php echo $señal; ?></h4>
					</div>
				</div>
				<div class="row">
					<small>
						<small>
							<small>
								<div class="table-responsive text-center" style="overflow:auto">
									<table class="table table-condensed table-bordered table-striped">
										<thead>
											<tr>
												<th>Horario</th>
												<th>Programa</th>
												<th>Tema</th>
												<th>Grupo</th>
												<th>Genero</th>
												<th>Sub-genero</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($programacionesArray as $programacion): ?>
												<tr>
													<td>
														<?php echo date('H.i', strtotime($programacion["RatingProgramacione"]["inicio"])); ?>
														<br/>
														<?php echo date('H.i', strtotime($programacion["RatingProgramacione"]["final"]));  ?>
													</td>
													<td><?php echo $programacion["RatingProgramacione"]["programa"] ?></td>
													<td><?php echo $programacion["RatingProgramacione"]["tema"]?></td>
													<td><?php echo $programacion["RatingProgramacione"]["programa"] ?></td>
													<td><?php echo $programacion["RatingProgramacione"]["tema"]?></td>
													<td><?php echo $programacion["RatingProgramacione"]["subgenero"]?></td>
													<td><a class="btn-sm btn btn-success tool" href="<?php echo $this->Html->url(array('controller'=>'rating_programaciones', 'action'=>'edit', $programacion['RatingProgramacione']['id'])); ?>" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a></td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</small>
						</small>
					</small>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if(!empty($this->request->data) && !isset($this->request->data["fecha"])): ?>
		<div class="col-md-12 col-md-offset-1">
			<?php echo $this->Form->create('RatingProgramacione', array('class'=>'form-horizontal')); ?> 
			<?php echo $this->Form->input('id');?> 
			<div class="row">
				<div class="form-group">
					<label class="col-md-2 control-label baja">Programa</label>
					<div class="col-md-7">
						<?php echo $this->Form->input('programa', array("class"=>"form-control", "placeholder"=>"Ingrese programa", "label"=>false));?>
					</div>
				</div>					
			</div>
			<div class="row">
				<div class="form-group">
					<label class="col-md-2 control-label baja">Tema</label>
					<div class="col-md-7">
						<?php echo $this->Form->input('tema', array("class"=>"form-control", "placeholder"=>"Ingrese tema", "label"=>false));?>
					</div>
				</div>					
			</div>
			<div class="row">
				<div class="form-group">
					<label class="col-md-2 control-label baja">Grupo</label>
					<div class="col-md-7">
						<?php echo $this->Form->input('grupo', array("class"=>"form-control", "placeholder"=>"Ingrese grupo", "label"=>false));?>
					</div>
				</div>					
			</div>
			<div class="row">
				<div class="form-group">
					<label class="col-md-2 control-label baja">Género</label>
					<div class="col-md-7">
						<?php echo $this->Form->input('genero', array("class"=>"form-control", "placeholder"=>"Ingrese Género", "label"=>false));?>
					</div>
				</div>					
			</div>
			<div class="row">
				<div class="form-group">
					<label class="col-md-2 control-label baja">Sub-género</label>
					<div class="col-md-7">
						<?php echo $this->Form->input('subgenero', array("class"=>"form-control", "placeholder"=>"Ingrese Sub-género", "label"=>false));?>
					</div>
				</div>					
			</div>
			<br/>
			<div class="row">
				<div class="col-md-4 col-md-offset-3">
					<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fa fa-pencil"></i> Editar</button>	
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	<?php endif;?>
</div>
<?php echo $this->Html->script(array('bootstrap-datepicker'));?>
<?php echo $this->Html->script(array('bootstrap-datepicker.es'));?>

<script type="text/javascript">
	
	$(document).ready(function() {

		$("#fecha").datepicker({
			endDate: new Date(),
			format: "dd/mm/yyyy",
			clearBtn:true,
			language: 'es',
			autoclose:true
		});
	});	

	$(".form-horizontal").submit(function(){

		if($("#fecha").val() == "")
		{
			alert("Debe seleccionar una fecha");
			return false;
		}
	});
</script>
