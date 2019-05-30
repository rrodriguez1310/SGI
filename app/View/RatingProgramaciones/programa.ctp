<div class="col-md-12 col-md-offset-1">
	<form class="form" action="<?php echo $this->Html->url(array('controller'=>'rating_programaciones', 'action'=>'programa')); ?>" method="POST">
		<div class="row">
			<div class="col-md-10 text-center">
				<h4>Rating y Share programas CDF y sus competidores ESPN - Fox Sport</h4>			
			</div>
		</div>
		<br/>
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
					<input type="text" id="fechaInicio" name="fechaInicio" value="<?php $f = new DateTime(); echo date_format($f->modify('-8 day'), 'd/m/Y') ?>" class="form-control readonly-pointer-background" placeholder="Seleccione fecha inicial" />
				</div>	
			</div>
			<div class="input">
				<div class="col-md-2">
					<input type="text" id="fechaFinal" name="fechaFinal" value="<?php echo date('d/m/Y') ?>" class="form-control readonly-pointer-background" placeholder="Seleccione fecha final"/>
				</div>	
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-md-12">
				<label class="checkbox-inline">
					<input type="checkbox" id="inlineCheckbox1" name="señal[]" value="CDFB" checked> <strong>CDFB</strong>
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" id="inlineCheckbox2" name="señal[]" value="CDFP" checked> <strong>CDFP</strong>
				</label>
				<label class="checkbox-inline">
					<input type="checkbox" id="inlineCheckbox3" name="señal[]" value="CDFHD" checked> <strong>CDFHD</strong>
				</label>
			</div>
		</div>
		<div class="row">
			<i><small>* El periodo maximo a mostrar es de 6 meses</small></i>
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
					<small>
						<small>
						<div class="table-responsive text-center" style="overflow:auto">
							<table class="table table-condensed table-bordered table-striped">
								<thead>
									<tr>
										<th rowspan="2" >Señal</th>
										<th rowspan="2">Periodo</th>
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
											<td><?php echo $programacion["RatingProgramacione"]["canal_base"] ?></td>
											<td><?php echo date('d/m/Y', strtotime($programacion["RatingProgramacione"]["inicio"])); ?></td>
											<td>
												<?php echo date('H.i', strtotime($programacion["RatingProgramacione"]["inicio"])); ?> <br/>
												<?php echo date('H.i', strtotime($programacion["RatingProgramacione"]["final"]));  ?>
											</td>
											<td class="<?php echo $color; ?>"><b><?php echo $genero; ?></b></td>
											<td>
												<a href="<?php echo $this->Html->url(array('controller'=>'rating_programaciones', 'action'=>'programa_minutos', 'programa',$programacion["RatingProgramacione"]["id"])); ?>">
												<?php echo $programacion["RatingProgramacione"]["programa"]." </a> - ".$programacion["RatingProgramacione"]["tema"] ?>
											</td>
											<!--<td><?php echo $programacion["RatingProgramacione"]["programa"]." - ".$programacion["RatingProgramacione"]["tema"] ?></td>-->
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
											<td class="<?php if($programacion["RatingProgramacionesDetalle"][9]["canal"] == $programacion["RatingProgramacione"]["canal_base"]) echo 'warning' ?>" style="border-right: 2px solid;"><?php if($programacion["RatingProgramacionesDetalle"][9]["rating"]!=0) echo $programacion["RatingProgramacionesDetalle"][9]["rating"] ?></td>
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
					</small>
				</small>
			</div>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-md-12">
			<i><small>Fuente: Time Ibope, a través del software TvData</small></i>			
		</div>
	</div>
</div>

<?php echo $this->Html->script(array('bootstrap-datepicker'));?>

<script type="text/javascript">
	
	$(document).ready(function() {

		$(".select2").select2({
			 allowClear: true
		});
		$("#fechaInicio, #fechaFinal").datepicker({
			endDate: new Date(),
			startDate: new Date(2013,0,1),
			format: "dd/mm/yyyy",
			clearBtn:true,
			language: 'es',
			autoclose:true
		});
	});

	$(".form").submit(function(){
		if($("#programa").val() == "")
		{
			alert("Debe seleccionar un programa");
			return false;
		}
		if($("#fechaInicio").val() != "" && $("#fechaFinal").val() != "")
		{	
			var fechaInicioArray = $("#fechaInicio").val().split('/');
			var fechaInicio = new Date(fechaInicioArray[1]+"/"+fechaInicioArray[0]+"/"+fechaInicioArray[2]);
			var fechaFinalArray = $("#fechaFinal").val().split('/');
			var fechaFinal = new Date(fechaFinalArray[1]+"/"+fechaFinalArray[0]+"/"+fechaFinalArray[2]);
			var diferencia = fechaFinal.getTime()-fechaInicio.getTime();
			var seisMeses=(1000*60*60*24)*183;
			if(diferencia>seisMeses)
			{
				alert("Debe seleccionar un rango de fecha menor a 6 meses");
				return false;
			}
		}
		if($("#fechaInicio").val() == "" && $("#fechaFinal").val() != "")
		{
			var fechaArray = $("#fechaFinal").val().split('/');
			var fecha = new Date(fechaArray[1]+"/"+fechaArray[0]+"/"+fechaArray[2]);
			fecha.setMonth(fecha.getMonth()-6);
			$("#fechaInicio").val(fecha.getDate()+"/"+fecha.getMonth()+"/"+fecha.getFullYear());
		}
		if($("#fechaInicio").val() != "" && $("#fechaFinal").val() == "")
		{
			var fechaArray = $("#fechaInicio").val().split('/');
			var fecha = new Date(fechaArray[1]+"/"+fechaArray[0]+"/"+fechaArray[2]);
			fecha.setMonth(fecha.getMonth()+6);
			$("#fechaFinal").val(fecha.getDate()+"/"+fecha.getMonth()+"/"+fecha.getFullYear());
		}
		if($("#fechaInicio").val() == "" && $("#fechaFinal").val() == "")
		{
			var fecha = new Date();
			fecha.setMonth(fecha.getMonth()-6);
			$("#fechaInicio").val(fecha.getDate()+"/"+fecha.getMonth()+"/"+fecha.getFullYear());
		}

		
	});

</script>
