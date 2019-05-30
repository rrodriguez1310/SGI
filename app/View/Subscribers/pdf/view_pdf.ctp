<style>
	table
	{
		border:1px solid #CCCCCC;
		font-size: 10px;
	}
	td 
	{
		border:1px solid #CCCCCC;
	}
	th
	{
		background-color: #CCCCCC;	
		padding: 3px;
	}
</style>
<?php define("DOMPDF_ENABLE_REMOTE", true); ?>
<table border="0" cellspacing="0">
	<tr>
		<td>
			<img src="http://192.168.1.25/desarrolloV2/img/cdf_pdf.jpg" width="100">
		</td>
		<td><strong>INFORME ABONADOS </strong><br/>sgi.cdf.cl<br/><?php echo $nombreEmpresa?> año   <?php echo $nombreAgno?></td>
	</tr>
</table>
<hr>

<h3><?php echo __("Lista de Abonados ".$nombreEmpresa ." año " . $nombreAgno)?></h3>

<div class="scroll">
	<table class="table" cellspacing="0">
		<thead>
			<tr>
				<th>Tipo de Canal</th>
				<th>Tipo de Transmisión</th>
				<th>Tipo de Señal</th>
				<th>Tipo de Pago</th>
				<?php 
					foreach($arrayMeses as $arrayMese)
					{
						echo "<th>" .$arrayMese["nombre"] . "</th>";
					} 
				?>
			</tr>
		</thead>
		<tbody>
			<?php
				if(!empty($atributosEmpresas))
				{
					foreach($atributosEmpresas as $valor)
					{
						if(!empty($valor["Canales"]))
						{
							foreach($valor["Canales"] as $idValorCanal)
							{
								
							echo "<tr>";
							echo '<td>'.$canalesArray[$idValorCanal] .'</td>';
							
							if(!empty($valor["Enlaces"]))
							{
								echo '<td class="canal" id ="">';
								foreach($valor["Enlaces"] as $idValor)
								{
									echo $enlacesArray[$idValor] .', ';
								}
								echo '</td>';
							}
							else 
							{
								echo '<td class="canal" id ="'.$idValor.'"> S/I</td>';
							}
							
							if(!empty($valor["Segnal"]))
							{
								echo '<td>';
								foreach($valor["Segnal"] as $idValor)
								{
									echo $signalArray[$idValor] .', ';
								} 
								echo '</td>';
							}
							else 
							{
								echo '<td> S/I </td>';
							}
							
							
							if(!empty($valor["Pagos"]))
							{
								echo '<td>';
								foreach($valor["Pagos"] as $idValor)
								{
									echo $pagosArray[$idValor] . ', ';
								}
								echo '</td>';
							}
							else 
							{
								echo '<td> S/I </td>';
							}
							
							foreach($arrayMeses as $arrayMese)
							{
								
								if(isset($valorAbonado[$arrayMese["id"]][$idValorCanal]))
								{
									echo "<td><a href='#' abonado='".$valorAbonado[$arrayMese["id"]][$idValorCanal]["Id"]."' data-pk='".$idValorCanal."' id='".$arrayMese["id"]."' class='xeditable' > <span class='badge badge-success'>".$valorAbonado[$arrayMese["id"]][$idValorCanal]["Abonados"]."</span></a></td>";
								}else{
									echo "<td><a href='#' abonado='' data-pk='".$idValorCanal."' id='".$arrayMese["id"]."' class='xeditable'>x</a></td>";
								}
							} 
								echo "</tr>";
							
							}
						}
						else
						{
							echo "<h3>SIN INFORMACIÓN</h3>";
						}
						
					}
				}
				else
				{
					echo "<h3>SIN INFORMACIÓN</h3>";
				}
				
			?>
	
		</tbody>
	</table>
</div>
