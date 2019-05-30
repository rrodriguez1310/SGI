<h1>Abonados Reales.</h1>
<?php foreach($totalAbonadosPorMes as $keyAgno => $totalAbonadosPorAgno) : ?>
	<table>
		<?php foreach($totalAbonadosPorAgno as $keyEmpresa => $totalAbonadosPorEmpresa) : ?>
			<td>
				<table style="text-align: left; width: 500px; height: 88px; border:1px solid #1C4D6B;" cellpadding="2" cellspacing="2">
					<tbody>
						<tr>
							<td style=" background-color:#1C4D6B; border:1px solid #1C4D6B; color: #FFF; text-align: center; width: 125px;" colspan="1" rowspan="1"><strong>Año / <?php echo $keyAgno; ?></strong></td>
							<td style="background-color:#1C4D6B; border:1px solid #1C4D6B; color: #FFF; text-align: center; vertical-align: middle; width: 125px;" colspan="3" rowspan="1"><strong>Proveedor / <?php echo $keyEmpresa; ?></strong></td>
						</tr>
						<tr>
							<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><strong>Mes</strong></td>
							<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><strong>Basico</strong></td>
							<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><strong>Premium</strong></td>
							<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><strong>Hd</strong></td>
						</tr>
						<?php foreach($totalAbonadosPorEmpresa as $keyMes => $totalAbonadosPorMes) : ?>
							<tr>
								<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><?php echo $keyMes; ?></td>
								<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><?php echo (isset($totalAbonadosPorMes["CDF Basico"]) ? number_format(array_sum($totalAbonadosPorMes["CDF Basico"]), 0, '', '.') : ""); ?></td>
								<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><?php echo (isset($totalAbonadosPorMes["CDF Premium"]) ? number_format(array_sum($totalAbonadosPorMes["CDF Premium"]), 0, '', '.') : ""); ?></td>
								<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><?php echo (isset($totalAbonadosPorMes["CDF HD"]) ? number_format(array_sum($totalAbonadosPorMes["CDF HD"]), 0, '', '.') : ""); ?></td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</td>
		<?php endforeach; ?>
	</table>
	777777
<?php endforeach; ?>

<h1>Abonados Presupuestado</h1>
<?php foreach($salidaAbonadosPresupuestado as $keyAgno => $salidaAbonadosPresupuestadoAgno) : ?>
	<table>
		<?php foreach($salidaAbonadosPresupuestadoAgno as $keyEmpresa => $salidaAbonadosPresupuestadoEmpresa) : ?>
			<td>
				<table style="text-align: left; width: 500px; height: 88px; border:1px solid #1C4D6B;" cellpadding="2" cellspacing="2">
					<tbody>
						<tr>
							<td style=" background-color:#1C4D6B; border:1px solid #1C4D6B; color: #FFF; text-align: center; width: 125px;" colspan="1" rowspan="1"><strong>Año / <?php echo $keyAgno; ?></strong></td>
							<td style="background-color:#1C4D6B; border:1px solid #1C4D6B; color: #FFF; text-align: center; vertical-align: middle; width: 125px;" colspan="3" rowspan="1"><strong>Proveedor / <?php echo $keyEmpresa; ?></strong></td>
						</tr>
						<tr>
							<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><strong>Mes</strong></td>
							<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><strong>Basico</strong></td>
							<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><strong>Premium</strong></td>
							<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><strong>Hd</strong></td>
						</tr>
						<?php foreach($salidaAbonadosPresupuestadoEmpresa as $keyMes => $salidaAbonadosPresupuestadoMes) : ?>
							<tr>
								<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><?php echo $keyMes; ?></td>
								<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><?php echo $salidaAbonadosPresupuestadoMes["CDF Basico"] ? number_format(array_sum($salidaAbonadosPresupuestadoMes["CDF Basico"]), 0, '', '.') : ""; ?></td>
								<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><?php echo $salidaAbonadosPresupuestadoMes["CDF Premium"] ? number_format(array_sum($salidaAbonadosPresupuestadoMes["CDF Premium"]), 0, '', '.') : ""; ?></td>
								<td style="text-align: center; width: 125px; border:1px solid #1C4D6B;"><?php echo $salidaAbonadosPresupuestadoMes["CDF HD"] ? number_format(array_sum($salidaAbonadosPresupuestadoMes["CDF HD"]), 0, '', '.') : ""; ?></td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</td>
		<?php endforeach; ?>
	</table>
<?php endforeach; ?>