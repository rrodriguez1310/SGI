<table style="width: 100%" border="1" class="table table-bordered">
	<tbody>
		<tr>
			<th>Tipo de Canal</th>
			<th>Tipo de Transmición</th>
			<th>Tipo de Señal</th>
			<th>Tipo de Pago</th>
		</tr>
		<?php foreach($atributosEmpresas as $key => $atributosEmpresa): ; ?>
		<?php foreach($atributosEmpresa as $atributosEmpresaValor) :?>
		
		<tr>
			<td colspan="1" rowspan="2"><?php echo $key; ?></td>
			
				<?php 
					if(isset($atributosEmpresaValor["Enlaces"][0]))
					{
						echo "<td>".$enlacesArray[$atributosEmpresaValor["Enlaces"][0]]."</td>";	
					}
				?>
			<td>
				<?php
					if(isset($atributosEmpresaValor["Segnal"][0]))
					{
						echo $signalArray[$atributosEmpresaValor["Segnal"][0]];	
					}
				?>
			</td>
			<td>
				<?php
					if(isset($atributosEmpresaValor["Pagos"][0]))
					{
						echo $pagosArray[$atributosEmpresaValor["Pagos"][0]];	
					}
					
				?>
				
			</td>
		</tr>
		<tr>
			<td>
				<?php 
					if(isset($atributosEmpresaValor["Enlaces"][1]))
					{
						echo $enlacesArray[$atributosEmpresaValor["Enlaces"][1]];	
					}
				?>
			</td>
			<td>
				<?php
	  						
					if(isset($atributosEmpresaValor["Segnal"][1]))
					{
						echo $signalArray[$atributosEmpresaValor["Segnal"][1]];	
					}
				?>
				
			</td>
			<td>
				<?php
					if(isset($atributosEmpresaValor["Pagos"][1]))
					{
						echo $pagosArray[$atributosEmpresaValor["Pagos"][1]];	
					}
				?>
			</td>
		</tr>
		<?php endForeach;  ?>
		<?php endForeach;  ?>
	</tbody>
</table>


<!--table style="width: 100%" class="table table-striped table-bordered dataTable">
	<thead>
		<tr>
			<th>Tipo de Canal</th>
			<th>Tipo de Transmisión</th>
			<th>Tipo de Señal</th>
			<th>Tipo de Pago</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($atributosEmpresas as $key => $atributosEmpresa): ?>
		<tr>
          <td><?php echo $key; ?></td>
          <td colspan="3" rowspan="1">
          	<table border="1">
          		<?php foreach($atributosEmpresa as $atributosEmpresaValor) :?>
          		<tr>
          			<td>
          				<table>
          					<?php
          							if(isset($atributosEmpresaValor["Enlaces"][0]))
									{
										echo '<tr><td>' .$enlacesArray[$atributosEmpresaValor["Enlaces"][0]] . '</td></tr>';	
									}
									
									if(isset($atributosEmpresaValor["Enlaces"][1]))
									{
										echo '<tr><td>' .$enlacesArray[$atributosEmpresaValor["Enlaces"][1]] . '</td></tr>';	
									}
          							 
          						?>
          				</table>
          				
          			</td>
          			<td>
          				<table>
	  						<?php
	  							if(isset($atributosEmpresaValor["Segnal"][0]))
								{
									echo '<tr><td>' .$signalArray[$atributosEmpresaValor["Segnal"][0]] . '</td></tr>';	
								}
								
								if(isset($atributosEmpresaValor["Segnal"][1]))
								{
									echo '<tr><td>' .$signalArray[$atributosEmpresaValor["Segnal"][1]] . '</td></tr>';	
								}
	  						?>
          				</table>
          			</td>
          			<td>
          				<table>
          					
          						<?php
          							if(isset($atributosEmpresaValor["Pagos"][0]))
									{
										echo '<tr><td>' .$pagosArray[$atributosEmpresaValor["Pagos"][0]] . '</td></tr>';	
									}
									
									if(isset($atributosEmpresaValor["Pagos"][1]))
									{
										echo '<tr><td>' .$pagosArray[$atributosEmpresaValor["Pagos"][1]] . '</td></tr>';	
									}
          						?>
          					
          				</table>
          			</td>
          		</tr>
          		<?php endForeach; ?>
          	</table>
          </td>
        </tr>
        <?php endForeach;  ?>
	</tbody>
</table>
<!--table class="table table-striped table-bordered dataTable">
	<thead>
		<tr>
			<th>Tipo de Canal</th>
			<th>Tipo de Transmisión</th>
			<th>Tipo de Señal</th>
			<th>Tipo de Pago</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($atributosEmpresas as $valor)
			{
				if(!empty($valor["Canales"]))
				{
					foreach($valor["Canales"] as $idValor)
					{
					echo "<tr>";
					echo '<td>'.$canalesArray[$idValor] .'</td>';
					
					if(!empty($valor["Enlaces"]))
					{
						echo '<td>';
						foreach($valor["Enlaces"] as $idValor)
						{
							echo $enlacesArray[$idValor] .', ';
						}
						echo '</td>';
					}
					else 
					{
						echo '<td>S/I</td>';
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
						echo '<td>S/I</td>'; 	
					}
					
					if(!empty($valor["Pagos"]))
					{
						echo '<td>';
						foreach($valor["Pagos"] as $idValor)
						{
							echo $pagosArray[$idValor] .', ';
						}
						echo '</td>';
					}
					else 
					{
						echo '<td>S/I</td>';
					}
					
					echo "</tr>";
					
					}
				}else{
					echo "<h3>SIN INFORMACIÓN</h3>";
				}	
				
			}
		?>

	</tbody>
</table-->