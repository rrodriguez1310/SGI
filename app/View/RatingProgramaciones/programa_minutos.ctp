<div class="col-md-12">
	<?php if(!empty($programacion)): ?> 
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-10">
					<h4><?php echo $programacion["RatingProgramacione"]["canal_base"]." ".date('d/m/Y', strtotime($programacion["RatingProgramacione"]["inicio"])); ?></h4>
				</div>
				<div class="col-md-2" >
					<a class="volver btn btn-default pull-right" href="javascript:window.history.back()"><i class="fa fa-mail-reply-all"></i> Volver</a>
				</div>
			</div>
			<br/>
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
												<strong><?php echo $programacion["RatingProgramacione"]["programa"] ?></strong> - 
												<?php echo $programacion["RatingProgramacione"]["tema"] ?>
											</td>
											<td class="<?php if($programacion["RatingProgramacione"]["canal_base"]=='CDFB') echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][0]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][0]["rating"],3,",",".") ?></td>
											<td class="<?php if($programacion["RatingProgramacione"]["canal_base"]=='CDFP') echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][2]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][2]["rating"],3,",",".") ?></td>
											<td class="<?php if($programacion["RatingProgramacione"]["canal_base"]=='CDFHD') echo 'warning' ?>"><?php if($programacion["RatingProgramacionesDetalle"][1]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][1]["rating"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][3]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][3]["rating"],3,",",".") ?></td>
											<td><?php if($programacion["RatingProgramacionesDetalle"][6]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][6]["rating"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][4]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][4]["rating"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][5]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][5]["rating"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][7]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][7]["rating"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][10]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][10]["rating"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][8]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][8]["rating"],3,",",".") ?></td>
											<td style="border-right: 2px solid;"><?php if($programacion["RatingProgramacionesDetalle"][9]["rating"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][9]["rating"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][0]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][0]["share"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][2]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][2]["share"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][1]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][1]["share"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][3]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][3]["share"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][6]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][6]["share"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][4]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][4]["share"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][5]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][5]["share"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][7]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][7]["share"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][10]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][10]["share"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][8]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][8]["share"],3,",",".") ?></td>
											<td ><?php if($programacion["RatingProgramacionesDetalle"][9]["share"]!=0) echo number_format($programacion["RatingProgramacionesDetalle"][9]["share"],3,",",".") ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</small>
					</small>
				</small>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div id="grafico">
					
					</div>					
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="table-responsive text-center" style="overflow:auto">
					<table class="table table-condensed table-bordered table-striped">
						<thead>
							<tr>
								<th rowspan="2" class="text-center">Minuto</th>
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
							<?php foreach($minutos as $key => $minuto) :?>
								<tr>
									<td><?php echo date('H:i', strtotime($key));?></td>
									<td class="<?php if($programacion["RatingProgramacione"]["canal_base"]=='CDFB') echo 'warning' ?>"><?php if($minuto["cdfb"][0]!=0) echo number_format($minuto["cdfb"][0],3,",",".") ?></td>
									<td class="<?php if($programacion["RatingProgramacione"]["canal_base"]=='CDFP') echo 'warning' ?>"><?php if($minuto["cdfp"][0]!=0) echo number_format($minuto["cdfp"][0],3,",",".") ?></td>
									<td class="<?php if($programacion["RatingProgramacione"]["canal_base"]=='CDFHD') echo 'warning' ?>"><?php if($minuto["cdfhd"][0]!=0) echo number_format($minuto["cdfhd"][0],3,",",".") ?></td>
									<td ><?php if($minuto["espn"][0]!=0) echo number_format($minuto["espn"][0],3,",",".") ?></td>
									<td ><?php if($minuto["espnm"][0]!=0) echo number_format($minuto["espnm"][0],3,",",".") ?></td>
									<td ><?php if($minuto["espn2"][0]!=0) echo number_format($minuto["espn2"][0],3,",",".") ?></td>
									<td ><?php if($minuto["espn3"][0]!=0) echo number_format($minuto["espn3"][0],3,",",".") ?></td>
									<td ><?php if($minuto["espnhd"][0]!=0) echo number_format($minuto["espnhd"][0],3,",",".") ?></td>
									<td ><?php if($minuto["fs"][0]!=0) echo number_format($minuto["fs"][0],3,",",".") ?></td>
									<td ><?php if($minuto["fsp"][0]!=0) echo number_format($minuto["fsp"][0],3,",",".") ?></td>
									<td ><?php if($minuto["fs2"][0]!=0) echo number_format($minuto["fs2"][0],3,",",".") ?></td>
									<td style="border-right: 2px solid;"><?php if($minuto["fs3"][0]!=0) echo number_format($minuto["fs3"][0],3,",",".") ?></td>
									<td class="<?php if($programacion["RatingProgramacione"]["canal_base"]=='CDFB') echo 'warning' ?>"><?php if($minuto["cdfb"][1]!=0) echo number_format($minuto["cdfb"][1],3,",",".") ?></td>
									<td class="<?php if($programacion["RatingProgramacione"]["canal_base"]=='CDFP') echo 'warning' ?>"><?php if($minuto["cdfp"][1]!=0) echo number_format($minuto["cdfp"][1],3,",",".") ?></td>
									<td class="<?php if($programacion["RatingProgramacione"]["canal_base"]=='CDFHD') echo 'warning' ?>"><?php if($minuto["cdfhd"][1]!=0) echo number_format($minuto["cdfhd"][0],3,",",".") ?></td>
									<td ><?php if($minuto["espn"][1]!=0) echo number_format($minuto["espn"][1],3,",",".") ?></td>
									<td ><?php if($minuto["espnm"][1]!=0) echo number_format($minuto["espnm"][1],3,",",".") ?></td>
									<td ><?php if($minuto["espn2"][1]!=0) echo number_format($minuto["espn2"][1],3,",",".") ?></td>
									<td ><?php if($minuto["espn3"][1]!=0) echo number_format($minuto["espn3"][1],3,",",".") ?></td>
									<td ><?php if($minuto["espnhd"][1]!=0) echo number_format($minuto["espnhd"][1],3,",",".") ?></td>
									<td ><?php if($minuto["fs"][1]!=0) echo number_format($minuto["fs"][1],3,",",".") ?></td>
									<td ><?php if($minuto["fsp"][1]!=0) echo number_format($minuto["fsp"][1],3,",",".") ?></td>
									<td ><?php if($minuto["fs2"][1]!=0) echo number_format($minuto["fs2"][1],3,",",".") ?></td>
									<td ><?php if($minuto["fs3"][1]!=0) echo number_format($minuto["fs3"][1],3,",",".") ?></td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-md-12">
			<i><small>Fuente: Time Ibope, a través del software TvData</small></i>			
		</div>
	</div>
</div>
<script type="text/javascript">
$(function () {
    $('#grafico').highcharts({
        chart: {
             zoomType: 'x'
        },
        title: {
            text: '<?php echo $programacion["RatingProgramacione"]["canal_base"]." ".date('d/m/Y (H:i', strtotime($programacion["RatingProgramacione"]["inicio"]))." - ".date('H:i)', strtotime($programacion["RatingProgramacione"]["final"]))." ".$programacion["RatingProgramacione"]["programa"]; ?>'
        },
        subtitle: {
            text: false,
           // floating: true,
            align: 'right',
            verticalAlign: 'bottom',
            y: 15
        },
        xAxis: {
            type: 'datetime',
            minRange: 12 * 24 * 3600 * 1000/24/60 // fourteen days
        },
        yAxis: {
            title: {
                text: 'Rating % Hogares con cable'
            }
        },
        tooltip: {
        	/*
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    this.x + ': ' + this.y;
            }*/
        },
        plotOptions: {
           plotOptions: {
            area: {
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }
        },
        },
        credits: {
            enabled: false
        },
        series: [{
        	type: 'line',
            name: "CDFB",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["cdfb"][0].',';	
					}
				?>
            ],
        }, {
            type: 'line',
            name: "CDFP",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["cdfp"][0].',';	
					}
				?>
            ],
        }, {
            type: 'line',
            name: "CDFHD",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["cdfhd"][0].',';	
					}
				?>
            ],
        }, {
            type: 'line',
            name: "ESPN",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["espn"][0].',';	
					}
				?>
            ],
        }, {
            type: 'line',
            name: "ESPN+",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["espnm"][0].',';	
					}
				?>
            ],
         }, {
            type: 'line',
            name: "ESPN2",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["espn2"][0].',';	
					}
				?>
            ],
         }, {
            type: 'line',
            name: "ESPN3",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["espn3"][0].',';	
					}
				?>
            ],
         }, {
            type: 'line',
            name: "ESPNHD",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["espnhd"][0].',';	
					}
				?>
            ],
        }, {
            type: 'line',
            name: "FS",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["fs"][0].',';	
					}
				?>
            ],
        }, {
            type: 'line',
            name: "FSP",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["fsp"][0].',';	
					}
				?>
            ],
        }, {
            type: 'line',
            name: "FS2",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["fs2"][0].',';	
					}
				?>
            ],
        }, {
            type: 'line',
            name: "FS3",
            color: "#065800",
            pointInterval: 24 * 3600 * 1000/24/60,
            pointStart: Date.UTC(<?php echo date('Y, m, d, H, i', strtotime($programacion["RatingProgramacione"]["inicio"])) ?>),
            data: [
            	<?php
					foreach($minutos as $minuto)
					{
						echo $minuto["fs3"][0].',';	
					}
				?>
            ],
        }]
    });
});

</script>