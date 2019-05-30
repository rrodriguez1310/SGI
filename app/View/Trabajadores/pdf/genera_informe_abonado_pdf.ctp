<style>
body
{
	font-family: Verdana;
	font-size: 12px;
}
table
{
	border-collapse: collapse;
}

</style>
<?php define("DOMPDF_ENABLE_REMOTE", true); ?>
<table border="0" cellspacing="0">
	<tr>
		<td>
			<img src="http://192.168.1.25/desarrolloV2/img/cdf_pdf.jpg" width="100">
		</td>
		<td><strong>INFORME ABONADOS </strong><br/>sgi.cdf.cl<br/><?php echo $mesLogo . ' - ' . $agnoLogo?></td>
	</tr>
</table>
<hr>


<h4 align="center" >RESUMEN ABONADOS TOTALES hola</h4>
<table style="width: 100%; border-collapse: collapse" border="1">
		<tbody>
			<tr>
				<td style="width:13%;   background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;">ABONADOS</td>
				<td style="width:43.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;" colspan="4" rowspan="1">Abonados Reales</td>
				<td style="width:43.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;" rowspan="1" colspan="4">Abonados Promedio <?php echo $mesesPromediosPrimium?></td>
			</tr>
			<tr>
				<td style="width:13%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;">
				<br>
				</td>
				<?php foreach($abonadosPremiumArray as $key => $abonadosPremium) :?>
					<td style="width:10.8%; background-color: #4F80BC; color:#FFF; font-weight: bold; border:1px solid #000;"><?php echo $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["Mes"] . ' - ' . $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["Agno"]; ?></td>
					<td style="width:10.8%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border:1px solid #000;"><?php echo $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["Mes"] . ' - ' . $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["Agno"]?></td>
	          <?php break; endForeach; ?>
				<!--td>mes 1</td>
				<td>mes 2</td-->
				<td style="width:21.75%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border:1px solid #000;" colspan="2" rowspan="1">Variación</td>
				<td style="width:10.8%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border:1px solid #000;">Presupuestado</td>
				<td style="width:10.8%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border:1px solid #000;">Real</td>
				<td style="width:21.75%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border:1px solid #000;" colspan="2" rowspan="1">Variación</td>
			</tr>
			<tr>
				<td style="text-align: center;">PREMIUM</td>
				
				<td style="padding-right:10px; width:10.8%; text-align: right;"><?php echo number_format( array_sum($abonadosTotalesPremiumArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.'); ?></td>
				<td style="padding-right:10px; width:10.8%; text-align: right;"><?php echo number_format( array_sum($abonadosTotalesPremiumArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
				<td style="padding-right:10px; width:10.8%; text-align: right;"><?php echo number_format( (array_sum($abonadosTotalesPremiumArray[end($agnosPedidos)][end($mesesPedidos)])) - (array_sum($abonadosTotalesPremiumArray[reset($agnosPedidos)][reset($mesesPedidos)])), 0, '', '.'); ?></td>
				<td style="padding-right:10px; width:10.8%; text-align: right;"><?php echo number_format( round((array_sum($abonadosTotalesPremiumArray[end($agnosPedidos)][end($mesesPedidos)]) - (array_sum($abonadosTotalesPremiumArray[reset($agnosPedidos)][reset($mesesPedidos)]))) / (array_sum($abonadosTotalesPremiumArray[end($agnosPedidos)][end($mesesPedidos)])) * 100), 0, '', '.'); ?> % </td>
				<td style="padding-right:10px; width:10.8%; text-align: right;"><?php echo number_format( $totalPromedioPpremium, 0, '', '.'); ?></td>
				<td style="padding-right:10px; width:10.8%; text-align: right;"><?php echo number_format( $totalRealPremium, 0, '', '.'); ?></td>
				<td style="padding-right:10px; width:10.8%; text-align: right;"><?php echo number_format( $totalPromedioPpremium - $totalRealPremium, 0, '', '.'); ?></td>
				<td style="padding-right:10px; width:10.8%; text-align: right;"><?php echo number_format( ($totalPromedioPpremium - $totalRealPremium) /  ($totalRealPremium) * 100   , 0, '', '.'); ?> % </td>
			</tr>
			
			<tr>
				<td style="text-align: center;">HD</td>
				<td style="padding-right:10px; text-align: right;">
					<?php if(isset($abonadosTotalesHdArray[reset($agnosPedidos)]))
						{
							echo number_format( array_sum($abonadosTotalesHdArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.');
						}
					?>
				</td>
				<td style="padding-right:10px; text-align: right;">
					<?php 
						if(isset($abonadosTotalesHdArray[end($agnosPedidos)][end($mesesPedidos)]))
						{
							echo number_format( array_sum($abonadosTotalesHdArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); 
						}
					?>
				</td>
				<td style="padding-right:10px; text-align: right;">
					<?php 
						if(isset($abonadosTotalesHdArray[reset($agnosPedidos)][reset($mesesPedidos)]))
						{
							echo number_format( array_sum($abonadosTotalesHdArray[reset($agnosPedidos)][reset($mesesPedidos)]) - array_sum($abonadosTotalesHdArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); 
						}
					?>
				</td>
				<td style="padding-right:10px; text-align: right;">
					<?php 
						if(isset($abonadosTotalesHdArray[reset($agnosPedidos)][reset($mesesPedidos)]))
						{
							echo number_format( round((array_sum($abonadosTotalesHdArray[reset($agnosPedidos)][reset($mesesPedidos)]) - array_sum($abonadosTotalesHdArray[end($agnosPedidos)][end($mesesPedidos)])) / (array_sum($abonadosTotalesHdArray[reset($agnosPedidos)][reset($mesesPedidos)])) * 100), 0, '', '.'); 
						}
					?>% 
				</td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( $totalPromedioHd, 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( $totalRealHd, 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( $totalPromedioHd - $totalRealHd, 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( ($totalPromedioHd - $totalRealHd) / ($totalRealHd) * 100, 0, '', '.'); ?> % </td>
			</tr>
			
			<tr>
				<td style="text-align: center;">BASICO</td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( array_sum($abonadosTotalesBasicoArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( array_sum($abonadosTotalesBasicoArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( array_sum($abonadosTotalesBasicoArray[reset($agnosPedidos)][reset($mesesPedidos)]) - array_sum($abonadosTotalesBasicoArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( round((array_sum($abonadosTotalesBasicoArray[reset($agnosPedidos)][reset($mesesPedidos)]) - array_sum($abonadosTotalesBasicoArray[end($agnosPedidos)][end($mesesPedidos)])) / (array_sum($abonadosTotalesBasicoArray[reset($agnosPedidos)][reset($mesesPedidos)])) * 100), 0, '', '.'); ?>% </td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( $totalPromedioBasico, 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( $totalRealBasico, 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( $totalPromedioBasico - $totalRealBasico, 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format( ($totalPromedioBasico - $totalRealBasico) / ($totalRealBasico) * 100, 0, '', '.'); ?> % </td>
			</tr>
			
			<tr>
				<td style="text-align: center;">PREMIUM + HD</td>
				<td style="padding-right:10px; text-align: right;"><?php echo $sumaPremiumHd = number_format( array_sum($abonadosTotalesPremiumArray[reset($agnosPedidos)][reset($mesesPedidos)]) + array_sum($abonadosTotalesHdArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo $sumaPremiumHdx = number_format( array_sum($abonadosTotalesPremiumArray[end($agnosPedidos)][end($mesesPedidos)]) + array_sum($abonadosTotalesHdArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo  $restaPremiumHd = number_format( ((array_sum( $abonadosTotalesPremiumArray[end($agnosPedidos)][end($mesesPedidos)]) + array_sum($abonadosTotalesHdArray[end($agnosPedidos)][end($mesesPedidos)])) - (array_sum($abonadosTotalesPremiumArray[reset($agnosPedidos)][reset($mesesPedidos)]) + array_sum($abonadosTotalesHdArray[reset($agnosPedidos)][reset($mesesPedidos)]))), 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo round(($restaPremiumHd / $sumaPremiumHd) * 100)?>%</td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format($totalPromedioPpremium + $totalPromedioHd, 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format($totalRealPremium + $totalRealHd, 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format(($totalPromedioPpremium + $totalPromedioHd) - ($totalRealPremium + $totalRealHd) , 0, '', '.'); ?></td>
				<td style="padding-right:10px; text-align: right;"><?php echo number_format((($totalPromedioPpremium + $totalPromedioHd) - ($totalRealPremium + $totalRealHd)) / ($totalRealPremium + $totalRealHd) * 100 , 0, '', '.'); ?> % </td>
			</tr>
		</tbody>
	</table>
	<br/><br/>
	
	<h4 align="left" >DETALLE ABONADOS OPERADORES SEÑAL PREMIUM</h4>
	
	<table style="width: 100%; border-collapse: collapse; ">
	      <tbody>
	        <tr>
	          <td style="width:13%;  background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-top:1px solid #000; border-left:1px solid #000;  border-right: 1px solid #000;">Abonados <br/> Premium</td>
	          <?php foreach($abonadosPremiumArray as $key => $abonadosPremium) :?>
	          	<td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;"><?php echo $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["Mes"] . ' - ' . $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["Agno"]; ?></td>
		      	<td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;"><?php echo $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["Mes"] . ' - ' . $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["Agno"]; ?></td>
	          <?php break; endForeach; ?>
	          <td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;">
	          	<?php echo $mesesPromediosPrimium?>
	          </td>
	        </tr>
	        <tr>
	          <td style="background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-left: 1px solid #000;"><br/></td>
	          <td style="width:14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width:14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	          <td style="width:14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width:14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	          <td style="width:14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width:14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	        </tr>
	        <?php foreach($abonadosPremiumArray as $key => $abonadosPremium) :?>
	        <tr>
	          <td style="border: 1px solid #000; text-align: center;"><?php echo $key; ?></td>
	          <!--td style="padding-right:10px; border: 1px solid #000; text-align: right;"-->
	          	<?php 
	          		//echo number_format( $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["CantidadAbonados"], 0, '', '.');
	          		
	          		if($abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["CantidadAbonados"] == 0 || $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["CantidadAbonados"] == "")
					{
						$mesAnterior = end($mesesPedidos) - 1;
						
						echo '<td style="background-color:#4F80BC; color:#FFF; padding-right:10px; border: 1px solid #000; text-align: right;">asdasd'.number_format( $abonadosPremium[reset($agnosPedidos)][$mesAnterior]["CantidadAbonados"], 0, '', '.').'</td>';
					}
					else
					{
						$colorFondo = "";
						echo '<td style="padding-right:10px; border: 1px solid #000; text-align: right;">'.number_format( $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["CantidadAbonados"], 0, '', '.') .'</td>';
					} 
	          	?>
	          <!--/td-->
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosPresupuestadosArray[$key][reset($agnosPedidos)][reset($mesesPedidos)], 0, '', '.'); ?></td>
	          <!--td style="padding-right:10px; border: 1px solid #000; text-align: right;"-->
	          <?php 
	          	//echo number_format( $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["CantidadAbonados"], 0, '', '.');
	          	if($abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["CantidadAbonados"] == 0 || $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["CantidadAbonados"] == "")
				{
					$mesAnterior = end($mesesPedidos) - 1;
					
					echo '<td style="background-color:#4F80BC; color:#FFF; padding-right:10px; border: 1px solid #000; text-align: right;" class="real2Premium">'.number_format( $abonadosPremium[end($agnosPedidos)][$mesAnterior]["CantidadAbonados"], 0, '', '.').'</td>';
				}
				else
				{
					echo '<td style="padding-right:10px; border: 1px solid #000; text-align: right;" class="real2Premium">'.number_format( $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["CantidadAbonados"], 0, '', '.') .'</td>';
				} 
	          ?><!--/td-->
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosPresupuestadosArray[$key][end($agnosPedidos)][end($mesesPedidos)], 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( round(array_sum($abonadosPromedioRealArray[$key])), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( round(array_sum($abonadosPromedioArray[$key]) / count($abonadosPromedioArray[$key])), 0, '', '.'); ?></td>
	        </tr>
	        <?php endForeach; ?>
	        <tr>
	          <td style=" border: 1px solid #000; text-align: center;">OTROS</td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(array_sum($abonadosOtrosPremiumArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( round(array_sum($abonadosPresupuestadosOtrosArray[reset($agnosPedidos)][reset($mesesPedidos)]) / count($abonadosPresupuestadosOtrosArray[reset($agnosPedidos)][reset($mesesPedidos)])) , 0, '', '.')?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(array_sum($abonadosOtrosPremiumArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPresupuestadosOtrosArray[end($agnosPedidos)][end($mesesPedidos)]) / count($abonadosPresupuestadosOtrosArray[end($agnosPedidos)][end($mesesPedidos)])), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPromedioRealOtrosArray)), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPromedioOtrosPremiumArray) / count($abonadosPromedioOtrosPremiumArray)), 0, '', '.'); ?></td>
	        </tr>
	        <tr>
	        	<td style=" text-align: center; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;">Totales</td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( array_sum($abonadosTotalesPremiumArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( $totalizadorMesUnoPresupuestado, 0, '', '.'); ?></td>
	        	<td class="totalPrimium"style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( array_sum($abonadosTotalesPremiumArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( $totalizadorMesDosPresupuestado, 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( $totalRealPremium, 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( $totalPromedioPpremium, 0, '', '.'); ?></td>
	        </tr>
	      </tbody>
	</table>
	
	<br/><br/>
	<h4 align="left" >DETALLE ABONADOS OPERADORES - SEÑAL HD</h4>
	
	
	<table style="width: 100%; border-collapse: collapse;">
	      <tbody>
	        <tr>
	          <td style="width:13%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-top:1px solid #000; border-left:1px solid #000;  border-right: 1px solid #000;">Abonados <br/> HD</td>
	          <?php foreach($abonadosPremiumArray as $key => $abonadosPremium) :?>
	          	<td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;"><?php echo $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["Mes"] . ' - ' . $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["Agno"]; ?></td>
		      	<td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;"><?php echo $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["Mes"] . ' - ' . $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["Agno"]; ?></td>
	          <?php break; endForeach; ?>
	          <td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;">
	          	<?php echo $mesesPromediosPrimium?>
	          </td>
	        </tr>
	        <tr>
	          <td style=" background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-left: 1px solid #000;"><br/></td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	        </tr>
	        <?php foreach($abonadosHdArray as $key => $abonadosHd) :?>
	        <tr>
	          <td style=" border: 1px solid #000; text-align: center;"><?php echo $key; ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosHd[reset($agnosPedidos)][reset($mesesPedidos)]["CantidadAbonados"], 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosHdPresupuestadosArray[$key][reset($agnosPedidos)][reset($mesesPedidos)], 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosHd[end($agnosPedidos)][end($mesesPedidos)]["CantidadAbonados"], 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosHdPresupuestadosArray[$key][end($agnosPedidos)][end($mesesPedidos)], 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( round(array_sum($abonadosPromedioRealHdArray[$key])), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( round(array_sum($abonadosPromedioHdArray[$key]) / count($abonadosPromedioHdArray[$key])), 0, '', '.'); ?></td>
	        </tr>
	        <?php endForeach; ?>
	        <tr>
	          <td style=" border: 1px solid #000; text-align: center;">OTROS </td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(array_sum($abonadosOtrosHdArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( round(array_sum($abonadosPresupuestadosOtrosHdArray[reset($agnosPedidos)][reset($mesesPedidos)]) / count($abonadosPresupuestadosOtrosHdArray[reset($agnosPedidos)][reset($mesesPedidos)])) , 0, '', '.')?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(array_sum($abonadosOtrosHdArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPresupuestadosOtrosHdArray[end($agnosPedidos)][end($mesesPedidos)]) / count($abonadosPresupuestadosOtrosHdArray[end($agnosPedidos)][end($mesesPedidos)])), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPromedioRealOtrosHdArray)), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPromedioOtrosHdArray) / count($abonadosPromedioOtrosHdArray)), 0, '', '.'); ?></td>
	        </tr>
	        <tr>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;">Totales</td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( array_sum($abonadosTotalesHdArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( $totalizadorMesUnoPresupuestadoHd, 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( array_sum($abonadosTotalesHdArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( $totalizadorMesDosPresupuestadoHd, 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( $totalRealHd, 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( $totalPromedioHd, 0, '', '.'); ?></td>
	        </tr>
	      </tbody>
	</table>
	
	
	<br/><br/>
	<h4 align="left" >DETALLE ABONADOS OPERADORES - SEÑAL BASICA</h4>
	
	<table style="width: 100%; border-collapse: collapse;">
	      <tbody>
	        <tr>
	          <td style="13%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-top:1px solid #000; border-left:1px solid #000;  border-right: 1px solid #000;">Abonados <br/> Basicos</td>
	          <?php foreach($abonadosPremiumArray as $key => $abonadosPremium) :?>
	          	<td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;"><?php echo $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["Mes"] . ' - ' . $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["Agno"]; ?></td>
		      	<td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;"><?php echo $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["Mes"] . ' - ' . $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["Agno"]; ?></td>
	          <?php break; endForeach; ?>
	          <td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;">
	          	<?php echo $mesesPromediosPrimium?>
	          </td>
	        </tr>
	        <tr>
	          <td style=" background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-left: 1px solid #000;"><br/></td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	        </tr>
	        <?php foreach($abonadosBasicoArray as $key => $abonadosBasico) :?>
	        <tr>
	          <td style=" border: 1px solid #000; text-align: center;"><?php echo $key; ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosBasico[reset($agnosPedidos)][reset($mesesPedidos)]["CantidadAbonados"], 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosBasicoPresupuestadosArray[$key][reset($agnosPedidos)][reset($mesesPedidos)], 0, '', '.'); ?></td>
	          <!--td  style="background-color:<?php echo $colorFondo; ?>; padding-right:10px; border: 1px solid #000; text-align: right;"-->
	          <?php
		          	if($abonadosBasico[end($agnosPedidos)][end($mesesPedidos)]["CantidadAbonados"] == 0 || $abonadosBasico[end($agnosPedidos)][end($mesesPedidos)]["CantidadAbonados"] == "")
					{
						$mesAnterior = end($mesesPedidos) - 1;
						
						echo '<td style="background-color:#4F80BC; color:#FFF; padding-right:10px; border: 1px solid #000; text-align: right;">'.number_format( $abonadosBasico[end($agnosPedidos)][$mesAnterior]["CantidadAbonados"], 0, '', '.').'</td>';
					}
					else
					{
						$colorFondo = "";
						echo '<td style="padding-right:10px; border: 1px solid #000; text-align: right;">'.number_format( $abonadosBasico[end($agnosPedidos)][end($mesesPedidos)]["CantidadAbonados"], 0, '', '.') .'</td>';
					}
	          	?>
	          	<!--/td-->
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosBasicoPresupuestadosArray[$key][end($agnosPedidos)][end($mesesPedidos)], 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( round(array_sum($abonadosPromedioRealBasicoArray[$key])), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( round(array_sum($abonadosPromedioBasicoArray[$key]) / count($abonadosPromedioBasicoArray[$key])), 0, '', '.'); ?></td>
	        </tr>
	        <?php endForeach; ?>
	        <tr>
	          <td style=" border: 1px solid #000; text-align: center;">OTROS.</td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(array_sum($abonadosOtrosBasicoArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPresupuestadosOtrosBasicoArray[reset($agnosPedidos)][reset($mesesPedidos)]) / count($abonadosPresupuestadosOtrosBasicoArray[reset($agnosPedidos)][reset($mesesPedidos)])) , 0, '', '.')?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(array_sum($abonadosOtrosBasicoArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPresupuestadosOtrosBasicoArray[end($agnosPedidos)][end($mesesPedidos)]) / count($abonadosPresupuestadosOtrosBasicoArray[end($agnosPedidos)][end($mesesPedidos)])), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPromedioRealOtrosBasicoArray)), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPromedioOtrosBasicoArray) / count($abonadosPromedioOtrosBasicoArray)), 0, '', '.'); ?></td>
	        </tr>
	        <tr>
	        	<td style=" text-align: center; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;">Totales</td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( array_sum($abonadosTotalesBasicoArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( $totalizadorMesUnoPresupuestadoBasico, 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( array_sum($abonadosTotalesBasicoArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format($totalizadorMesDosPresupuestadoBasico, 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( $totalRealBasico, 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( $totalPromedioBasico, 0, '', '.'); ?></td>
	        </tr>
	      </tbody>
	</table>
	
	<br/><br/>
	<h4 align="left" >DETALLE ABONADOS OPERADORES - PREMIUM + HD</h4>
	
	<table style="width: 100%; border-collapse: collapse;">
	      <tbody>
	        <tr>
	          <td style="13%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-top:1px solid #000; border-left:1px solid #000;  border-right: 1px solid #000;">Abonados <br/> Premium + HD</td>
	          <?php foreach($abonadosPremiumArray as $key => $abonadosPremium) :?>
	          	<td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;"><?php echo $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["Mes"] . ' - ' . $abonadosPremium[reset($agnosPedidos)][reset($mesesPedidos)]["Agno"]; ?></td>
		      	<td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;"><?php echo $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["Mes"] . ' - ' . $abonadosPremium[end($agnosPedidos)][end($mesesPedidos)]["Agno"]; ?></td>
	          <?php break; endForeach; ?>
	          <td colspan="2" rowspan="1" style="width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;">
	          	<?php echo $mesesPromediosPrimium?>
	          </td>
	        </tr>
	        <tr>
	          <td style="background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-left: 1px solid #000;"><br/></td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Real</td>
	          <td style="width: 14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;">Presupuestado</td>
	        </tr>
	        <?php foreach($abonadosBasicoArray as $key => $abonadosBasico) :?>
	        <tr>
	          <td style="border: 1px solid #000; text-align: center;"><?php echo $key; ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosPremiumArray[$key][reset($agnosPedidos)][reset($mesesPedidos)]["CantidadAbonados"] + $abonadosHdArray[$key][reset($agnosPedidos)][reset($mesesPedidos)]["CantidadAbonados"], 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosPresupuestadosArray[$key][reset($agnosPedidos)][reset($mesesPedidos)] + $abonadosHdPresupuestadosArray[$key][reset($agnosPedidos)][reset($mesesPedidos)], 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosPremiumArray[$key][end($agnosPedidos)][end($mesesPedidos)]["CantidadAbonados"] + $abonadosHdArray[$key][end($agnosPedidos)][end($mesesPedidos)]["CantidadAbonados"], 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( $abonadosPresupuestadosArray[$key][end($agnosPedidos)][end($mesesPedidos)]+$abonadosHdPresupuestadosArray[$key][end($agnosPedidos)][end($mesesPedidos)], 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( round(array_sum($abonadosPromedioRealArray[$key])) + round(array_sum($abonadosPromedioRealHdArray[$key])), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;""><?php echo number_format( round(array_sum($abonadosPromedioArray[$key]) / count($abonadosPromedioArray[$key])) + round(array_sum($abonadosPromedioHdArray[$key]) / count($abonadosPromedioHdArray[$key])), 0, '', '.'); ?></td>
	        </tr>
	        <?php endForeach; ?>
	        <tr>
	          <td style="border: 1px solid #000; text-align: center;">OTROS</td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(array_sum($abonadosOtrosPremiumArray[reset($agnosPedidos)][reset($mesesPedidos)]) + array_sum($abonadosOtrosHdArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format( round(array_sum($abonadosPresupuestadosOtrosArray[reset($agnosPedidos)][reset($mesesPedidos)]) / count($abonadosPresupuestadosOtrosArray[reset($agnosPedidos)][reset($mesesPedidos)])) +  round(array_sum($abonadosPresupuestadosOtrosHdArray[reset($agnosPedidos)][reset($mesesPedidos)]) / count($abonadosPresupuestadosOtrosHdArray[reset($agnosPedidos)][reset($mesesPedidos)])), 0, '', '.')?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(array_sum($abonadosOtrosPremiumArray[end($agnosPedidos)][end($mesesPedidos)]) + array_sum($abonadosOtrosHdArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPresupuestadosOtrosArray[end($agnosPedidos)][end($mesesPedidos)]) / count($abonadosPresupuestadosOtrosArray[end($agnosPedidos)][end($mesesPedidos)])) + round(array_sum($abonadosPresupuestadosOtrosHdArray[end($agnosPedidos)][end($mesesPedidos)]) / count($abonadosPresupuestadosOtrosHdArray[end($agnosPedidos)][end($mesesPedidos)])), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPromedioRealOtrosArray)) + round(array_sum($abonadosPromedioRealOtrosHdArray)), 0, '', '.'); ?></td>
	          <td style="padding-right:10px; border: 1px solid #000; text-align: right;"><?php echo number_format(round(array_sum($abonadosPromedioOtrosPremiumArray) / count($abonadosPromedioOtrosPremiumArray)) + round(array_sum($abonadosPromedioOtrosHdArray) / count($abonadosPromedioOtrosHdArray)), 0, '', '.'); ?></td>
	        </tr>
	        <tr>
	        	<td style="text-align: center; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;">Totales</td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format(array_sum($abonadosTotalesPremiumArray[reset($agnosPedidos)][reset($mesesPedidos)]) + array_sum($abonadosTotalesHdArray[reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format($totalizadorMesUnoPresupuestado + $totalizadorMesUnoPresupuestadoHd, 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format( array_sum($abonadosTotalesBasicoArray[end($agnosPedidos)][end($mesesPedidos)]) + array_sum($abonadosTotalesHdArray[end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format($totalizadorMesDosPresupuestado + $totalizadorMesDosPresupuestadoHd, 0, '', '.'); ?></td> 
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format($totalRealPremium + $totalRealHd, 0, '', '.'); ?></td>
	        	<td style="padding-right:10px; text-align: right; background-color: #088928; color:#FFF; font-weight: bold; border: 1px solid #000;"><?php echo number_format($totalPromedioPpremium + $totalPromedioHd, 0, '', '.'); ?></td>
	        </tr>
	      </tbody>
	</table>

	<script>
	function addCommas(nStr)
	{
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		return x1 + x2;
	}
	var suma = 0;
	$(".real2Premium").each(function () {
		var valor = $(this).html().replace('.', '')
		suma += parseInt( valor ); 
    });
    $('.totalPrimium').text(addCommas(suma));
</script>
