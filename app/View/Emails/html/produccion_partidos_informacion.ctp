<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email</title>
</head>
<body>
	<div style="font-family:arial,sans-serif;color:#0070c0;"><?php echo (isset($comentarios))? $comentarios : '' ; ?></div>
	<br /><br />
	<?php	
		foreach($partidos as $partido)
		{
			$separadorTransmision = (!isset($partido["ProduccionPartidosTransmisione"]["NumeroPartido"]["nombre"]) || !isset($partido["ProduccionPartidosTransmisione"]["transmision"] ))? '' : ' / ';
		?>
			<table style="font-family:arial,sans-serif;color:#0070c0;margin-bottom:-3px">
				<tr>
					<td colspan="4" style="font-family:arial,sans-serif;color:#0070c0"><?php setlocale(LC_TIME, 'es_ES.UTF-8'); echo ucfirst( mb_strtolower( strftime("%A %d de %B de %Y", strtotime($partido["ProduccionPartidosEvento"]["fecha_partido"])) , 'UTF-8') ); ?></td>
				</tr>
				<tr>
					<td colspan="4" style="font-family:arial,sans-serif;color:#0070c0;font-size: 13.0pt;font-weight: bold;">
						<?php echo mb_strtoupper($partido["Equipo"]["nombre"]) . ' vs. '. mb_strtoupper($partido["EquipoVisita"]["nombre"]); ?> 
						<?php if(isset($partido["ProduccionPartidosTransmisione"]["NumeroPartido"]["nombre"]) || isset($partido["ProduccionPartidosTransmisione"]["transmision"] )): 
							 	echo isset($partido["ProduccionPartidosTransmisione"]["NumeroPartido"]["nombre"])? ' ('. $partido["ProduccionPartidosTransmisione"]["NumeroPartido"]["nombre"].$separadorTransmision: '('.$separadorTransmision; 
								echo isset($partido["ProduccionPartidosTransmisione"]["transmision"])? $partido["ProduccionPartidosTransmisione"]["transmision"]. ')' : ')'; 
							 endif; ?>
					</td>
				</tr>
				<?php if(isset($partido["ProduccionPartidosTransmisione"]["nombre_senales"])): ?>
				<tr>
					<td colspan="4"  style="font-family:arial,sans-serif;color:red;font-size: 13.0pt;font-weight: bold;"">
						<?php echo $partido["ProduccionPartidosTransmisione"]["nombre_senales"]; ?> 
					</td>
				</tr>
				<?php endif; ?>
			</table>
			<table style="font-family:arial,sans-serif;color:#0070c0;margin-top:0px;">
				<tr>
					<td colspan="2">
						<?php 
							if ($partido["Estadio"]["nombre"] == 'POR CONFIRMAR') {
								echo 'ESTADIO '.mb_strtoupper($partido["Estadio"]["nombre"]);
							} else {
								echo 'ESTADIO '.mb_strtoupper($partido["Estadio"]["nombre"]). ', ' . mb_strtoupper($partido["Estadio"]["ciudad"]). ', '.$partido["Estadio"]["region_ordinal"]; 
							}							
						?>						
					</td>
				</tr>
				<tr>
					<td width="220">INICIO DE TRANSMISION</td>
					<td><?php   echo 	( isset($partido["ProduccionPartidosEvento"]["hora_transmision_previa"]) ? substr($partido["ProduccionPartidosEvento"]["hora_transmision_previa"],0,5) : substr($partido["ProduccionPartidosTransmisione"]["hora_transmision"],0,5) ) . ' Hora Local - ' 
										. 	( isset($partido["ProduccionPartidosEvento"]["hora_transmision_previa_gmt"]) ? substr($partido["ProduccionPartidosEvento"]["hora_transmision_previa_gmt"],0,5) :substr($partido["ProduccionPartidosTransmisione"]["hora_transmision_gmt"],0,5) ) . ' Hora GMT'; ?></td>
				</tr>
				<tr>
					<td>INICIO PARTIDO</td>
					<td><?php echo substr($partido["ProduccionPartidosEvento"]["hora_partido"],0,5) . ' Hora Local - '. substr($partido["ProduccionPartidosEvento"]["hora_partido_gmt"],0,5).' Hora GMT' ; ?></td>
				</tr>
				<tr>
					<td>FIN APROX. TRANSMISION</td>
					<td><?php echo substr($partido["ProduccionPartidosTransmisione"]["hora_termino_transmision"],0,5) . ' Hora Local - '.substr($partido["ProduccionPartidosTransmisione"]["hora_termino_transmision_gmt"],0,5).' Hora GMT'; ?></td>
				</tr>
				<tr>
					<td>PRODUCCION TECNICA</td>
					<td><?php echo $partido["ProduccionPartidosTransmisione"]["nombre_proveedor"].' '.$partido["ProduccionPartidosTransmisione"]["TransmisionesMovile"]["nombre"]; ?></td>
				</tr>
			</table>
			<br/>
			<br/>
	<?php
		}
	?>
	<p style="font-family:arial,sans-serif;color:#0070c0">
		Saludos
	</p>
	<p class="MsoNormal">
		<b><i><span lang="ES-CO" style='font-family:"Arial",sans-serif;color:#0b5394;background:white'></span></i></b>
		<b><i><span lang="ES-CO" style='font-size:11.0pt;font-family:"Arial",sans-serif;color:#9e0201;background:white'>SEBASTIÁN CABALLERO</span></i></b>
		<b><i><span lang="ES-CO" style='font-family:"Arial",sans-serif;color:#9e0201;background:white'><br></span></i></b>
		<b><i><span lang="ES-CO" style='font-size:9.0pt;font-family:"Arial",sans-serif;color:#666666;background:white'>PRODUCCION PARTIDOS VIVO<br></span></i></b>
		<span style='font-family:"Arial",sans-serif;color:blue;background:white'><img src="cid:my-unique-id"></span>
	</p>	
	<p class="MsoNormal">
		<span style='font-family:"Arial",sans-serif;color:#0b5394;background:white'></span><b><i><span lang="ES-CO" style='font-size:10.0pt;font-family:"Arial",sans-serif;color:#666666;background:white'><a href="http://www.cdf.cl/" title="http://www.cdf.cl/" target="_blank"><span style="color:blue">www.cdf.cl</span></a></span></i></b><b><i><span lang="ES-CO" style='font-family:"Arial",sans-serif;color:#666666;background:white'><u></u><u></u></span></i></b>
	</p>
	<p class="MsoNormal"><b><i><span lang="ES-CO" style="font-size:10.0pt;font-family:"Arial",sans-serif;color:#666666;background:white">
		<br>F:&nbsp;(562) 24909355&nbsp;&nbsp;M: <a href="tel:+56998847792" value="+56998847792" target="_blank">+56 9 98847792</a>
		<br>Martin Alonso Pinzon 5935 (Chilefilms), Las Condes - Santiago - CHILE</span></i>
		</b><span style="font-family:"Verdana",sans-serif;color:#0b5394;background:white"><u></u><u></u></span>
	</p>
</body>
</html>

