<div class="col-md-12 col-md-offset-1">
	<form class="form" action="<?php echo $this->Html->url(array('controller'=>'RatingProgramaciones', 'action'=>'programa')); ?>" method="POST">
		<div class="row">
			<div class="col-md-6">
				<label for="programa" class="control-label">Programas</label>
			</div>
			<div class="col-md-2" class="control-label">
				<label for="fechaInicio" class="control-label cursor_pointer btn-block">Fecha Inicial</label>
			</div>
			<div class="col-md-2">
				<label for="fechaFinal" class="control-labe cursor_pointer btn-block">Fecha Final</label>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<select class="select2 btn-block baja_sin_form" id="programa" name="programa" placeholder="Seleccione un programa">
					<?php foreach($programas as $programa) : ?>
						<option value="<?php echo $programa ?>"><?php echo $programa ?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="input">
				<div class="col-md-2">
					<input type="text" id="fechaInicio" name="fechaInicio" class="form-control readonly-pointer-background" placeholder="Seleccione fecha inicial" />
				</div>	
			</div>
			<div class="input">
				<div class="col-md-2">
					<input type="text" id="fechaFinal" name="fechaFinal" class="form-control readonly-pointer-background" placeholder="Seleccione fecha final"/>
				</div>	
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-md-12">
				<label class="checkbox-inline">
					<input type="checkbox" id="inlineCheckbox1" name="señal[]" value="CDFB"> <strong>CDFB</strong>
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" id="inlineCheckbox2" name="señal[]" value="CDFP"> <strong>CDFP</strong>
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" id="inlineCheckbox3" name="señal[]" value="CDFHD"> <strong>CDFHD</strong>
				</label>
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
<br/>
	<?php if(!empty($mostrarPrograma) && !empty($programaciones)): ?> 
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<h4><?php echo $mostrarPrograma; if(!empty($inicio)) { echo " desde ".$inicio ; } if(!empty($final)) { echo " hasta ".$final; } ?> </h4>
				</div>
			</div>
			<div class="row">
				<small>
						<div class="table-responsive text-center" style="overflow:auto">
							<table class="table table-condensed table-bordered table-striped" style="vertical-align: middle;">
								<thead>
									<tr>
										<th rowspan="2">Señal</th>
										<th rowspan="2">Periodo</th>
										<th rowspan="2">Horario</th>
										<th rowspan="2">Emisión</th>
										<th rowspan="2">Contenido</th>
									</tr>
									<tr>
										<th>TIPO</th>
										<th>CDFB</th>
										<th>CDFP</th>
										<th>CDFHD</th>
										<th>ESPN</th>
										<th>ESPN+</th>
										<th>ESPN3</th>
										<th>ESPNHD</th>
										<th>FS</th>
										<th>FSP</th>
										<th>FS2</th>
										<th>FS3</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($programaciones as $programacion): ?>
										<?php
											$generoArray = explode(" ", $programacion["RatingProgramacione"]["genero"]);
											switch($generoArray[1]) 
											{
											 	case 'ESTRENO':
											 		$color="success";
													$genero="E";
											 		break;
											 	case 'VIVO':
											 		$color="info";
													$genero="V";
											 		break;
											 	default:
											 		$color="danger";
													$genero="R";
											 		break;
											 } 
										?>
										<tr>
											<td rowspan="2"><?php echo $programacion["RatingProgramacione"]["canal_base"] ?></td>
											<td rowspan="2"><?php echo date('d/m/Y', strtotime($programacion["RatingProgramacione"]["fecha"])); ?></td>
											<td><?php echo date('H.i', strtotime($programacion["RatingProgramacione"]["inicio"])); ?></td>
											<td rowspan="2" class="<?php echo $color; ?>"><b><?php echo $genero; ?></b></td>
											<td rowspan="2"><?php echo $programacion["RatingProgramacione"]["programa"]." - ".$programacion["RatingProgramacione"]["tema"] ?></td>
											<td><p>RATING% HCC</p></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][0]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][0]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][0]["rating"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][2]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][2]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][2]["rating"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][1]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][1]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][1]["rating"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][3]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][3]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][3]["rating"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][6]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][6]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][6]["rating"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][4]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][4]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][4]["rating"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][5]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][5]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][5]["rating"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][7]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][7]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][7]["rating"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][10]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][10]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][10]["rating"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][8]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][8]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][8]["rating"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][9]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][9]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][9]["rating"] ?></td>
										</tr>
										<tr>
											<td><?php echo date('H.i', strtotime($programacion["RatingProgramacione"]["final"]));  ?></td>
											<td><p>SHARE% HCC</p></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][0]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][0]["share"]!=0) echo $programacion["RatingProgramacionesDetalle"][0]["share"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][2]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][2]["share"]!=0) echo $programacion["RatingProgramacionesDetalle"][2]["share"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][1]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][1]["share"]!=0) echo $programacion["RatingProgramacionesDetalle"][1]["share"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][3]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][3]["share"]!=0) echo $programacion["RatingProgramacionesDetalle"][3]["share"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][6]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][6]["share"]!=0) echo $programacion["RatingProgramacionesDetalle"][6]["share"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][4]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][4]["share"]!=0) echo $programacion["RatingProgramacionesDetalle"][4]["share"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][5]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][5]["share"]!=0) echo $programacion["RatingProgramacionesDetalle"][5]["share"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][7]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][7]["share"]!=0) echo $programacion["RatingProgramacionesDetalle"][7]["share"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][10]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][10]["share"]!=0) echo $programacion["RatingProgramacionesDetalle"][10]["share"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][8]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][8]["share"]!=0) echo $programacion["RatingProgramacionesDetalle"][8]["share"] ?></td>
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][9]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][9]["share"]!=0) echo $programacion["RatingProgramacionesDetalle"][9]["share"] ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
				</small>
			</div>
		</div>
	<?php endif; ?>
</div>

<script type="text/javascript">
	
	$(document).ready(function() {

		$(".select2").select2({
			 allowClear: true
		});

		$("#fechaInicio, #fechaFinal").datepicker({
			endDate: new Date(),
			format: "dd/mm/yyyy",
			clearBtn:true,
			language: 'es',
			autoclose:true
		});
	});

	$("#pantallaCompleta").click(function() {

		var i = document.getElementById("rating");
 
		if (i.requestFullscreen) {
		    i.requestFullscreen();
		} else if (i.webkitRequestFullscreen) {
		    i.webkitRequestFullscreen();
		} else if (i.mozRequestFullScreen) {
		    i.mozRequestFullScreen();
		} else if (i.msRequestFullscreen) {
		    i.msRequestFullscreen();
		}

	});	

</script>
