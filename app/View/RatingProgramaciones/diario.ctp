<div class="col-md-12 col-md-offset-1">
	<form class="form-horizontal" action="<?php echo $this->Html->url(array('controller'=>'rating_programaciones', 'action'=>'diario')); ?>" method="POST">
		<div class="row">
			<div class="col-md-10 text-center">
				<h4>Rating y Share programas CDF y sus competidores ESPN - Fox Sport</h4>				
			</div>
		</div>
		<br/>
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
												<th rowspan="2">Horario</th>
												<th rowspan="2">Emisión</th>
												<th rowspan="2">Contenido</th>
												<th colspan="11" class="text-center" style="border-right: 2px solid;">RATING% HCC</th>
												<th colspan="11" class="text-center">SHARE% HCC</th>
											</tr>
											<tr>
												<th>CDFB</th>
												<th>CDFP</th>
												<th>CDFHD</th>
												<th>ESPN</th>
												<th>ESPN+</th>
												<th>ESPN2</th>
												<th>ESPN3</th>
												<th>ESPNHD</th>
												<th>FS</th>
												<th>FSP</th>
												<th>FS2</th>
												<th style="border-right: 2px solid;">FS3</th>
												<th>CDFB</th>
												<th>CDFP</th>
												<th>CDFHD</th>
												<th>ESPN</th>
												<th>ESPN+</th>
												<th>ESPN2</th>
												<th>ESPN3</th>
												<th>ESPNHD</th>
												<th>FS</th>
												<th>FSP</th>
												<th>FS2</th>
												<th>FS3</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($programacionesArray as $programacion): ?>
												<?php //pr($programacion); exit; ?>
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
													<td>
														<?php echo date('H.i', strtotime($programacion["RatingProgramacione"]["inicio"])); ?>
														<br/>
														<?php echo date('H.i', strtotime($programacion["RatingProgramacione"]["final"]));  ?>
													</td>
													<td class="<?php echo $color; ?>"><b><?php echo $genero; ?></b></td>
													<td>
														<a href="<?php echo $this->Html->url(array('controller'=>'rating_programaciones', 'action'=>'programa_minutos', 'diario',$programacion["RatingProgramacione"]["id"])); ?>">
														<?php echo $programacion["RatingProgramacione"]["programa"]." </a> - ".$programacion["RatingProgramacione"]["tema"] ?>
													</td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][0]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][0]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][0]["rating"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][2]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][2]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][2]["rating"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][1]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][1]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][1]["rating"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][3]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][3]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][3]["rating"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][6]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][6]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][6]["rating"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][4]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][4]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][4]["rating"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][5]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][5]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][5]["rating"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][7]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][7]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][7]["rating"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][10]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][10]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][10]["rating"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][8]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][8]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][8]["rating"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][9]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>" style="border-right: 2px solid;"><?php if($programacion["RatingProgramacionesDetalle"][9]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][9]["rating"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][0]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>" ><?php if($programacion["RatingProgramacionesDetalle"][0]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][0]["share"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][2]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][2]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][2]["share"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][1]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][1]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][1]["share"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][3]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][3]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][3]["share"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][6]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][6]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][6]["share"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][4]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][4]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][4]["share"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][5]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][5]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][5]["share"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][7]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][7]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][7]["share"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][10]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][10]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][10]["share"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][8]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][8]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][8]["share"],3,",",".") ?></td>
													<td class="<?php if($programacion["RatingProgramacionesDetalle"][9]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][9]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][9]["share"],3,",",".") ?></td>
												</tr>
											<?php endforeach; ?>
											<tr>
												<td></td>
												<td></td>
												<td><b>Totales entre las 10:00 AM y 2:00 AM</b></td>
												<td><b><?php echo $totales["cdfb"]["rating"]?></b></td>
												<td><b><?php echo $totales["cdfp"]["rating"]?></b></td>
												<td><b><?php echo $totales["cdfhd"]["rating"]?></b></td>
												<td><b><?php echo $totales["espn"]["rating"]?></b></td>
												<td><b><?php echo $totales["espnm"]["rating"]?></b></td>
												<td><b><?php echo $totales["espn2"]["rating"]?></b></td>
												<td><b><?php echo $totales["espn3"]["rating"]?></b></td>
												<td><b><?php echo $totales["espnhd"]["rating"]?></b></td>
												<td><b><?php echo $totales["fs"]["rating"]?></b></td>
												<td><b><?php echo $totales["fsp"]["rating"]?></b></td>
												<td><b><?php echo $totales["fs2"]["rating"]?></b></td>
												<td style="border-right: 2px solid;"><b><?php echo $totales["fs3"]["rating"]?></b></td>
												<td><b><?php echo $totales["cdfb"]["share"]?></b></td>
												<td><b><?php echo $totales["cdfp"]["share"]?></b></td>
												<td><b><?php echo $totales["cdfhd"]["share"]?></b></td>
												<td><b><?php echo $totales["espn"]["share"]?></b></td>
												<td><b><?php echo $totales["espnm"]["share"]?></b></td>
												<td><b><?php echo $totales["espn2"]["share"]?></b></td>
												<td><b><?php echo $totales["espn3"]["share"]?></b></td>
												<td><b><?php echo $totales["espnhd"]["share"]?></b></td>
												<td><b><?php echo $totales["fs"]["share"]?></b></td>
												<td><b><?php echo $totales["fsp"]["share"]?></b></td>
												<td><b><?php echo $totales["fs2"]["share"]?></b></td>
												<td><b><?php echo $totales["fs3"]["share"]?></b></td>
											</tr>
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
	<div class="row">
		<div class="col-md-12">
			<i><small>Fuente: Time Ibope, a través del software TvData</small></i>			
		</div>
	</div>
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
