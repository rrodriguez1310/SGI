<style type="text/css">
	.cabecera{width:13%;  background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-top:1px solid #000; border-left:1px solid #000;  border-right: 1px solid #000;}
	.cabecera2{width:29%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;}
	.cabecera3{width:14.5%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border-top:1px solid #4F80BC; border-right: 1px solid #000;}
	.celdas{padding-right:10px; border: 1px solid #000; text-align: right;}
	.celda2{padding-left:5px; border:1px solid #000;}
	.total{background-color:#088928; padding-right:10px; border: 1px solid #000; text-align: right; color:#FFF;}
	.totalCabecera{background-color:#088928; padding-left:5px; border:1px solid #000; color:#FFF;}
	.rojo{background-color: #E34B39; color:#FFF; }
	.tabla{width: 100%; border-collapse: collapse;}
	
	.abonadosCabecera3{width:43.5%; background-color: #4F80BC; color:#FFF; font-weight: bold; border: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000; text-align: center; }
	.abonadosCabecera4{width:13%;background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border: 1px solid #000; border-bottom: 1px solid #000; border-top:1px solid #000;}
	.abonadoCabecera5{width:10.8%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border:1px solid #000;}
	.abonadoCabecera6{width:21.75%; background-color: #4F80BC; color:#FFF; text-align: center; font-weight: bold; border:1px solid #000;}
	.abondosCelda{padding-right:10px; width:10.8%; text-align: right; border:1px solid #000000}
	.abonadoCelda2{padding-left:5px; border:1px solid #000;}
</style>
<hr>
<ul class="menu_secundario nav nav-pills">
	<li class="pull-right">
		<a href="#" id="envia_informeAbonado" class"envia_informeAbonado" data-toggle="modal" data-target="#informeAbonadosPorEmail"><i class="fa fa-send"></i> Enviar informe de abonados</a>
	</li>
	<li class="pull-right">
		
		<a href="#" class="generarPdf"><i class="fa fa-file-pdf-o fa-lg "></i> Exportar a PDF</a>
	</li>
</ul>
<hr>



<div id="cuerpoHtmlTabla">

<?php if(!empty($operadoresNoAgrupados) && !empty($abonadosNoAgrupados)) :?>
<h2 align="center">Informe Abonados <?php echo $mesLogo . ' ' .$agnoLogo?> </h2>
	<br/>
	<h4 align="left" >RESUMEN ABONADOS TOTALES</h4>

<table class="tabla" style="width: 100%" border="1">
  <tbody>
    <tr>
      <td class="abonadosCabecera4" >Abonados</td>
      <td class="abonadosCabecera3" colspan="4" rowspan="1">Abonados Reales</td>
      <td class="abonadosCabecera3" colspan="4" rowspan="1">Abonados Promedio <?php echo $mesesArray[reset($mesePromedio)] . ' - ' .$mesesArray[end($mesePromedio)];?></td>
    </tr>
    <tr>
      <td class="abonadosCabecera4"><br>
      </td>
       <?php 
          foreach($mesesPedidos as $key => $mesesPedido) : 
            foreach($meses as $mes) :  
            if($mes["Month"]["id"] == $mesesPedido) : 
        ?>
        
      <td class="abonadoCabecera5 resumenMesUno">
      <?php echo $mes["Month"]["nombre"]; ?> - 
            <?php 
            	if(!empty($agnosPedidos))
				{
					if(isset($agnosPedidos[$key]))
					{
						echo $agnosArray[$agnosPedidos[$key]];
					}else{
						echo $agnosArray[reset($agnosPedidos)];
					}
				}
            ?>
      </td>
      <?php endif; ?>
      <?php endforeach; ?>
      <?php endforeach; ?>
      
      <td class="abonadoCabecera6" colspan="2" rowspan="1">Variación</td>
      <td class="abonadoCabecera5">Presupuestado</td>
      <td class="abonadoCabecera5">Real</td>
      <td class="abonadoCabecera6" colspan="2" rowspan="1">Variación</td>
    </tr>
    <?php foreach($operadoresNoAgrupados as $idChannel => $operadoresNoAgrupado) : ?>
    <tr>
      <td class="abonadoCelda2"><?php echo $channelArray[$idChannel]; ?></td>
      <td class="abondosCelda totalAbonadosMesUno-<?php echo $idChannel;?>"></td>
      <td class="abondosCelda totalAbonadosMesDos-<?php echo $idChannel;?>"></td>
      <td class="abondosCelda restaVariacion-<?php echo $idChannel;?>"></td>
      <td class="abondosCelda variacionPorcentaje-<?php echo $idChannel;?>"></td>
      <td class="abondosCelda variacionPresupuestado-<?php echo $idChannel;?>"></td>
      <td class="abondosCelda variacionReal-<?php echo $idChannel;?>">1</td>
      <td class="abondosCelda restaPromedio-<?php echo $idChannel;?>">2</td>
      <td class="abondosCelda VariacionPromedio-<?php echo $idChannel;?>">3</td>
    </tr>
    <?php endforeach; ?>
    <td class="abonadoCelda2">PRENETRACIÓN</td>
      <td class="abondosCelda penetracionMesUno"></td>
      <td class="abondosCelda penetracionMesDos"></td>
      <td class="abondosCelda variacion"></td>
      <td class="abondosCelda variacionPorcentaje"></td>
      <td class="abondosCelda presupuestado"></td>
      <td class="abondosCelda presupuestadoReal"></td>
      <td class="abondosCelda presupuestadoResta"></td>
      <td class="abondosCelda presupuestadoPromedio"></td>
    </tr>
  </tbody>
</table>
<br/><br/>
<?php foreach($operadoresNoAgrupados as $idChannel => $operadoresNoAgrupado) : ?>
<h4 align="left" >DETALLE ABONADOS OPERADORES SEÑAL <?php echo $channelArray[$idChannel]; ?></h4>
<table style="width: 100%; border-collapse: collapse; ">
      <tbody>
        <tr>
          <td colspan="1" rowspan="2" class="cabecera">Abonados</td>
         
            <?php 
              foreach($mesesPedidos as $key => $mesesPedido) : 
                foreach($meses as $mes) :  
                if($mes["Month"]["id"] == $mesesPedido) : 
            ?>
          <td colspan="2" rowspan="1" class="cabecera2">
            <?php echo $mes["Month"]["nombre"]; ?> - 
            <?php 
            	if(!empty($agnosPedidos))
				{
					if(isset($agnosPedidos[$key]))
					{
							
						echo $agnosArray[$agnosPedidos[$key]];
					}else{
						echo $agnosArray[reset($agnosPedidos)];
					}
				}
            ?>
          </td>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endforeach; ?>
          <td colspan="2" rowspan="1" class="cabecera2">promedio meses <?php echo $mesesArray[reset($mesePromedio)] . ' - ' .$mesesArray[end($mesePromedio)];?></td>
        </tr>
        <tr>
          <td class="cabecera3">real </td>
          <td class="cabecera3">presupuestado</td>
          <td class="cabecera3">real </td>
          <td class="cabecera3">presupuestado</td>
          <td class="cabecera3">real</td>
          <td class="cabecera3">presupuestado</td>
        </tr>
        <?php foreach(array_unique($operadoresNoAgrupado) as $key => $operador) :?>
        <tr>
          <td class="celda2"><?php echo $nombreOperadoresArray[$operador]; ?></td>
          <td class="celdas real-<?php echo $idChannel;?>">
            <?php
            	if(isset($abonadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)])){
            		if($idChannel == 2)
            		{
            			$valorUno[$nombreOperadoresArray[$operador]][]  = array_sum($abonadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)]);
            		}
					if($idChannel == 3)
					{
						$valorUno[$nombreOperadoresArray[$operador]][]  = array_sum($abonadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)]);
					}
            		 echo number_format( array_sum($abonadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.');
            	}
				else{
					echo 0;
				}
            ?>
          </td>
          <td class="celdas presupuestado-<?php echo $idChannel;?>">
          	<?php
				if(!empty($abonadosPresupuestadosNoAgrupados[$idChannel]))
				{
					if(isset($abonadosPresupuestadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)])){
						
						if($idChannel == 2)
            			{
            				$valorUnoPresupuestado[$nombreOperadoresArray[$operador]][] = $abonadosPresupuestadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)];
            			}
						
						if($idChannel == 3)
            			{
            				$valorUnoPresupuestado[$nombreOperadoresArray[$operador]][] = $abonadosPresupuestadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)];
            			}
						
						echo number_format($abonadosPresupuestadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)], 0, '', '.');
					}
					else 
					{
						echo 0;	
					}
				}else
				{
					echo 0;	
				}
          	?>
          </td>
          
            <?php

                if(isset($abonadosNoAgrupados[$idChannel]))
				{
					if(isset($abonadosNoAgrupados[$idChannel][$operador][end($agnosPedidos)][end($mesesPedidos)])){
						if($idChannel == 2)
            			{
            				$valorDos[$nombreOperadoresArray[$operador]][] =array_sum($abonadosNoAgrupados[$idChannel][$operador][end($agnosPedidos)][end($mesesPedidos)]);
            			}
						
						if($idChannel == 3)
            			{
            				$valorDos[$nombreOperadoresArray[$operador]][] =array_sum($abonadosNoAgrupados[$idChannel][$operador][end($agnosPedidos)][end($mesesPedidos)]);
            			}
						echo '<td class="celdas real2-'.$idChannel.'">';
						echo number_format(array_sum($abonadosNoAgrupados[$idChannel][$operador][end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.');
						echo '</td>';
					}else{
						if(isset($abonadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)]))
						{
							echo '<td class="rojo celdas real2-'.$idChannel.'">';
								echo number_format(array_sum($abonadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.');
								
								if($idChannel == 2)
		            			{
		            				$valorDos[$nombreOperadoresArray[$operador]][] = array_sum($abonadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)]);
		            			}
								
								if($idChannel == 3)
		            			{
		            				$valorDos[$nombreOperadoresArray[$operador]][] = array_sum($abonadosNoAgrupados[$idChannel][$operador][reset($agnosPedidos)][reset($mesesPedidos)]);
		            			}
							
							echo '</td>';
						}else{
							echo '<td class="celdas real2-'.$idChannel.'">';
							echo 0;
							echo "</td>";
						}
					}
				}else{
					echo '<td class="celdas real2-'.$idChannel.'">';
					echo 0;
					echo "</td>";
				}
            ?>
          
          <td class="celdas presupuestado2-<?php echo $idChannel;?>">
          	<?php
          		if(isset($abonadosPresupuestadosNoAgrupados) && !empty($abonadosPresupuestadosNoAgrupados))
				{
					
					if(isset($abonadosPresupuestadosNoAgrupados[$idChannel][$operador][end($agnosPedidos)][end($mesesPedidos)]))
					{
						if($idChannel == 2)
	            		{
	            			$valorDosPresupuestado[$nombreOperadoresArray[$operador]][] = $abonadosPresupuestadosNoAgrupados[$idChannel][$operador][end($agnosPedidos)][end($mesesPedidos)];
	            		}
						
						if($idChannel == 3)
	            		{
	            			$valorDosPresupuestado[$nombreOperadoresArray[$operador]][] = $abonadosPresupuestadosNoAgrupados[$idChannel][$operador][end($agnosPedidos)][end($mesesPedidos)];
	            		}
						
						echo number_format($abonadosPresupuestadosNoAgrupados[$idChannel][$operador][end($agnosPedidos)][end($mesesPedidos)], 0, '', '.');
					}
					else {
						echo 0;
					}
					
				}else
				{
					echo 0;
				}
          	
          	?>
          </td>
          	<?php
          		if(!empty($abonadosPromedioRealArray[$idChannel][$operador]))
				{
					$meseReales = "";
					foreach($mesePromedio as $key => $mesePromedios)
					{
						if(isset($abonadosPromedioRealArray[$idChannel][$operador][$mesePromedios]))
						{
							$meseReales[$mesePromedios] = array_sum($abonadosPromedioRealArray[$idChannel][$operador][$mesePromedios]);
						}
					}
					
					if(count($meseReales) == count($mesePromedio))
					{
						$vacios = "";
						foreach($meseReales as $key => $valor)
						{
							if(empty($valor))
							{
								$vacios[$key] = $key - 1;
							}
						}
						$creados = "";
						
						if(!empty($vacios))
						{
							foreach($vacios as $key => $valor)
							{
								$creados[$key] = $meseReales[$valor];
							}
							$meseFinal = array_replace($meseReales, $creados);
							$rojo = "rojo";
							echo '<td class="'.$rojo.' celdas promedioReal-'.$idChannel.'">';
							echo number_format(round(array_sum($meseFinal) / count($meseFinal)), 0, '', '.');
							if($idChannel == 2)
		            		{
								$promedioMesesUno[ $nombreOperadoresArray[$operador]][] = round(array_sum($meseReales) / count($meseReales));
							}
							
							if($idChannel == 3)
		            		{
								$promedioMesesUno[ $nombreOperadoresArray[$operador]][] = round(array_sum($meseReales) / count($meseReales));
							}
							echo '</td>';
						}else{
							echo '<td class="celdas promedioReal-'.$idChannel.'">';
							echo number_format(round(array_sum($meseReales) / count($meseReales)), 0, '', '.');
							if($idChannel == 2)
		            		{
								$promedioMesesUno[ $nombreOperadoresArray[$operador]][] = round(array_sum($meseReales) / count($meseReales));
							}
							
							if($idChannel == 3)
		            		{
								$promedioMesesUno[ $nombreOperadoresArray[$operador]][] = round(array_sum($meseReales) / count($meseReales));
							}
							echo '</td>';
						}
					}else{
						$mesFaltante = "";
						foreach($mesePromedio as $key => $valor)
						{
							if(!isset($meseReales[$valor]) && !empty($meseReales[$valor]))
							{
								
								$meseReales[$valor] = $meseReales[$valor - 1];
								pr($meseReales[$valor]);
							}
						}
						$rojo = "rojo";
						echo '<td class="'.$rojo.' celdas promedioReal-'.$idChannel.'">';
						echo number_format(round(array_sum($meseReales) / count($meseReales)), 0, '', '.');
						if($idChannel == 2)
	            		{
							$promedioMesesUno[ $nombreOperadoresArray[$operador]][] = round(array_sum($meseReales) / count($meseReales));
						}
						
						if($idChannel == 3)
	            		{
							$promedioMesesUno[ $nombreOperadoresArray[$operador]][] = round(array_sum($meseReales) / count($meseReales));
						}
						
						
						echo '</td>';
					}
				}else{
					echo '<td class="celdas promedioReal-'.$idChannel.'">';
					echo 0;
					echo '</td>';
				}
          	?>
          <td class="celdas promedioPresupuestado-<?php echo $idChannel;?>">
          	<?php
          		if(!empty($abonadosPresupuestadosNoAgrupadosTotal))
				{
					
					if(isset($abonadosPresupuestadosNoAgrupadosTotal[$idChannel][$operador]))
					{
						echo number_format(round((array_sum($abonadosPresupuestadosNoAgrupadosTotal[$idChannel][$operador]) / count($abonadosPresupuestadosNoAgrupadosTotal[$idChannel][$operador]))), 0, '', '.');
						if($idChannel == 2)
	            		{
	            			$presupuestadoMesesUno[$nombreOperadoresArray[$operador]][] = array_sum($abonadosPresupuestadosNoAgrupadosTotal[$idChannel][$operador]) / count($abonadosPresupuestadosNoAgrupadosTotal[$idChannel][$operador]);
					
						}
						
						if($idChannel == 3)
	            		{
	            			$presupuestadoMesesUno[$nombreOperadoresArray[$operador]][] = array_sum($abonadosPresupuestadosNoAgrupadosTotal[$idChannel][$operador]) / count($abonadosPresupuestadosNoAgrupadosTotal[$idChannel][$operador]);
					
						}
					}
				}else{
					echo "0";
				}
          	?>
          	
          </td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <td class="celda2" >Otros</td>
          <td class="celdas real-<?php echo $idChannel;?>">
           <?php
           		if(!empty($abonadosAgrupados[$idChannel]))
				{
					if(isset($abonadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]))
					{
						echo number_format(array_sum($abonadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.');
						
						if($idChannel == 2)
	            		{	
							$otrosRealUno[] = array_sum($abonadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]);
						}
						
						if($idChannel == 3)
	            		{	
							$otrosRealUno[] = array_sum($abonadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]);
						}
							
					}else{
						echo 0;
					}
				}
				else
				{
					echo 0;
				}
           ?>
          </td>
          	
          <td class="celdas presupuestado-<?php echo $idChannel;?>">
          	<?php
          		if(!empty($abonadosPresupuestadosAgrupados))
				{
					if(isset($abonadosPresupuestadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]))
					{
						echo number_format(array_sum($abonadosPresupuestadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.');
						
						if($idChannel == 2)
	            		{	
							$otrosPresupuestadoUno[] = array_sum($abonadosPresupuestadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]);
						}
						
						if($idChannel == 3)
	            		{	
							$otrosPresupuestadoUno[] = array_sum($abonadosPresupuestadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]);
						}
					}
				}
				else
				{
					echo 0;	
				}
          	?>
          </td>
          <td class="celdas real2-<?php echo $idChannel;?>">
              <?php
              	
           		if(!empty($abonadosAgrupados[$idChannel]))
				{
					if(isset($abonadosAgrupados[$idChannel][end($agnosPedidos)][end($mesesPedidos)]))
					{
						echo number_format(array_sum($abonadosAgrupados[$idChannel][end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.');
						if($idChannel == 2)
	            		{
							$otrosRealDos[] = array_sum($abonadosAgrupados[$idChannel][end($agnosPedidos)][end($mesesPedidos)]);
						}
						
						if($idChannel == 3)
	            		{	
							$otrosRealDos[] = array_sum($abonadosAgrupados[$idChannel][end($agnosPedidos)][end($mesesPedidos)]);
						}
					}else{
						if(isset($abonadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]))
						{
							echo number_format(array_sum($abonadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]), 0, '', '.');
							if($idChannel == 2)
		            		{	
								$otrosRealDos[] = array_sum($abonadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]);
							}
							
							if($idChannel == 3)
		            		{	
								$otrosRealDos[] = array_sum($abonadosAgrupados[$idChannel][reset($agnosPedidos)][reset($mesesPedidos)]);
							}	
						}else{
							echo 0;
						}
							
					}
				}else{
					echo 0;
				}
           ?>
          </td>
          <td class="celdas presupuestado-<?php echo $idChannel;?>">
          	<?php
          		if(!empty($abonadosPresupuestadosAgrupados))
				{
					if(isset($abonadosPresupuestadosAgrupados[$idChannel][end($agnosPedidos)][end($mesesPedidos)]))
					{
						echo number_format(array_sum($abonadosPresupuestadosAgrupados[$idChannel][end($agnosPedidos)][end($mesesPedidos)]), 0, '', '.');
						
						if($idChannel == 2)
	            		{	
							$otrosPresupuestadoDos[] = array_sum($abonadosPresupuestadosAgrupados[$idChannel][end($agnosPedidos)][end($mesesPedidos)]);
						}
						
						if($idChannel == 3)
	            		{	
							$otrosPresupuestadoDos[] = array_sum($abonadosPresupuestadosAgrupados[$idChannel][end($agnosPedidos)][end($mesesPedidos)]);
						}
					}
				}
				else
				{
					echo 0;	
				}
          	?>
          </td>
          <td class="celdas promedioReal-<?php echo $idChannel;?>">
          	<?php 
          		if(!empty($abonadosPromedioRealArrayOtros))
				{
					if(isset($abonadosPromedioRealArrayOtros[$idChannel]))
					{
						echo number_format(round(array_sum($abonadosPromedioRealArrayOtros[$idChannel]) / count($abonadosPromedioRealArrayOtros[$idChannel]) ), 0, '', '.');
						
						if($idChannel == 2)
	            		{	
							$otrosRealPromedio[] = array_sum($abonadosPromedioRealArrayOtros[$idChannel]) / count($abonadosPromedioRealArrayOtros[$idChannel]);
						}
						
						if($idChannel == 3)
	            		{	
							$otrosRealPromedio[] = array_sum($abonadosPromedioRealArrayOtros[$idChannel]) / count($abonadosPromedioRealArrayOtros[$idChannel]);
						}
					}
					else
					{
						echo 0;
					}
				}
				else
				{
					echo 0;
				}
          	
          	?>
          </td>
          <td class="celdas promedioPresupuestado-<?php echo $idChannel;?>">
          	<?php
          		if(!empty($abonadosPresupuestadosAgrupadosTotal))
				{
					if(isset($abonadosPresupuestadosAgrupadosTotal[$idChannel]))
					{
						echo number_format(round(array_sum($abonadosPresupuestadosAgrupadosTotal[$idChannel]) / count($abonadosPresupuestadosAgrupadosTotal[$idChannel]) ), 0, '', '.');
						if($idChannel == 2)
	            		{	
							$otrosPresupuestadoPromedio[] = array_sum($abonadosPresupuestadosAgrupadosTotal[$idChannel]) / count($abonadosPresupuestadosAgrupadosTotal[$idChannel]);
						}
						
						if($idChannel == 3)
	            		{	
							$otrosPresupuestadoPromedio[] = array_sum($abonadosPresupuestadosAgrupadosTotal[$idChannel]) / count($abonadosPresupuestadosAgrupadosTotal[$idChannel]);
						}
						
						
					}
					else
					{
						echo 0;
					}
				}
				else
				{
					echo 0;
				}
          	?>
          </td>
        </tr>
        <tr>
        	<td class="totalCabecera">Total</td>
        	<td class="total totalReal-<?php echo $idChannel; ?>"> </td>
        	<td class="total totalPresupuestado-<?php echo $idChannel; ?>"></td>
        	<td class="total totalReal2-<?php echo $idChannel; ?>"></td>
        	<td class="total totalPresupuestado2-<?php echo $idChannel; ?>"></td>
        	<td class="total totalPromedioReal-<?php echo $idChannel;?>"></td>
        	<td class="total totalPromedioPresupuestado-<?php echo $idChannel;?>">asda</td>
        </tr>
      </tbody>
    </table>
    <br/>
    </br/>
  <?php endforeach; ?>
  
  <h4 align="left" >DETALLE ABONADOS OPERADORES - PREMIUM + HD</h4>
  <?php foreach($operadoresNoAgrupados as $idChannel => $operadoresNoAgrupado) : ?>
 
  <table style="width: 100%" border="1">
      <tbody>
        <tr>
          <td class="cabecera">Abonados</td>
          
          <?php 
              foreach($mesesPedidos as $key => $mesesPedido) : 
                foreach($meses as $mes) :  
                if($mes["Month"]["id"] == $mesesPedido) : 
            ?>
          <td colspan="2" rowspan="1" class="cabecera2">
            <?php echo $mes["Month"]["nombre"]; ?> - 
            <?php 
            	if(!empty($agnosPedidos))
				{
					if(isset($agnosPedidos[$key]))
					{
						echo $agnosArray[$agnosPedidos[$key]];
					}else{
						echo $agnosArray[reset($agnosPedidos)];
					}
				}
            ?>
          </td>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endforeach; ?>
          
          <td class="cabecera2" colspan="2" rowspan="1">promedio meses <?php echo $mesesArray[reset($mesePromedio)] . ' - ' .$mesesArray[end($mesePromedio)];?></td>
        </tr>
        <tr>
          <td class="cabecera3"></td>
          <td class="cabecera3">real</td>
          <td class="cabecera3">presupuestado</td>
          <td class="cabecera3">real </td>
          <td class="cabecera3">presupuestado</td>
          <td class="cabecera3">real</td>
          <td class="cabecera3">presupuestado</td>
        </tr>
       	
       	<?php foreach(array_unique($operadoresNoAgrupado) as $key => $operador) :?>
        <tr>
          <td class="celda2"><?php echo $nombreOperadoresArray[$operador]; ?></td>
          <td class="celdas">
          	<?php 
	          	if(!empty($valorUno[$nombreOperadoresArray[$operador]]))
				{
					echo number_format(array_sum($valorUno[$nombreOperadoresArray[$operador]]), 0, '', '.');
				}else{
					echo 0;
				}
	          ?>
          </td>
          <td class="celdas">
          	<?php 
          		if(!empty($valorUnoPresupuestado[$nombreOperadoresArray[$operador]]))
				{
					echo number_format(array_sum($valorUnoPresupuestado[$nombreOperadoresArray[$operador]]), 0, '', '.');
				}else{
					echo 0;
				}
          	?>
          </td>
          <td class="celdas">
          	<?php 
          		if(!empty($valorDos[$nombreOperadoresArray[$operador]]))
				{
					echo number_format(array_sum($valorDos[$nombreOperadoresArray[$operador]]), 0, '', '.');
				}else{
					echo 0;
				}
          	?>
          	
          </td>
          <td class="celdas">
          	<?php 
          		if(!empty($valorDosPresupuestado[$nombreOperadoresArray[$operador]]))
				{
					echo number_format(round(array_sum($valorDosPresupuestado[$nombreOperadoresArray[$operador]])), 0, '', '.');
				}else{
					echo 0;
				}
          	?>
          </td>
          <td class="celdas">
          	<?php
          		if(!empty($promedioMesesUno[$nombreOperadoresArray[$operador]]))
				{
					echo number_format(round(array_sum($promedioMesesUno[$nombreOperadoresArray[$operador]])), 0, '', '.');
				}else{
					echo 0;
				}
          	?>
          </td>
          <td class="celdas">
          	<?php
          		if(!empty($presupuestadoMesesUno[$nombreOperadoresArray[$operador]]))
				{
					echo number_format(round(array_sum($presupuestadoMesesUno[$nombreOperadoresArray[$operador]])), 0, '', '.');
				}else{
					echo 0;
				}
          	?>
          </td>
        </tr>
       	<?php endForeach;  ?>
        
        <tr>
          <td class="celda2">otros</td>
          <td class="realUnoPremiumHd celdas">
          	<?php 
          		if(!empty($otrosRealUno))
				{
					echo number_format(array_sum($otrosRealUno), 0, '', '.');
				}
          	?>
          </td>
          <td class="celdas">
          	<?php 
          		if(!empty($otrosPresupuestadoUno))
				{
					echo number_format(array_sum($otrosPresupuestadoUno), 0, '', '.');
				}else{
					echo 0;
				}
          	?>
          </td>
          <td class="celdas">
          	<?php 
          		if(!empty($otrosRealDos))
				{
					echo number_format(array_sum($otrosRealDos), 0, '', '.');
				}else{
					echo 0;
				}
          	?>
          </td>
          <td class="celdas">
          	<?php
          		if(!empty($otrosPresupuestadoDos))
				{
					echo number_format(array_sum($otrosPresupuestadoDos), 0, '', '.');
				}else{
					echo 0;
				}
          	?>
          </td>
          <td class="celdas">
          	<?php 
          		if(!empty($otrosRealPromedio))
          		{
          			echo number_format(round(array_sum($otrosRealPromedio)), 0, '', '.');
          		}else{
          			echo 0;
          		}
          	?>
          </td>
          <td class="celdas">
          	<?php 
          		if(!empty($otrosPresupuestadoPromedio))
				{
					echo number_format(round(array_sum($otrosPresupuestadoPromedio)), 0, '', '.');
				}else
				{
					echo 0;	
				}
          	?>
          </td>
        </tr>
        <tr>
          <td class="totalCabecera">Totales</td>
          <td class="totalUno total"></td>
          <td class="totalDos total"></td>
          <td class="totalTres total"></td>
          <td class="totalCuatro total"></td>
          <td class="totalCinco total"></td>
          <td class="totalSeis total"></td>
        </tr>
        
      </tbody>
    </table>
<?php break; endforeach; ?>
  
  
  
	
 <?php endIf; ?>
 
</div>
<br/><br/><br/><br/><br/> 
 <script>
 	function addCommas(nStr)
	{
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) 
		{
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		return x1 + x2;
	}
 	
 	var sumaTotalReal1 = 0;
    $(".real-1").each(function () {
		var valorTotalReal1 = $(this).html().replace(/\./g , '');
		sumaTotalReal1 += parseInt(valorTotalReal1); 
    });
    $('.totalReal-1').text(addCommas(sumaTotalReal1));
    
    var sumaTotalPresupuestado = 0;
    $(".presupuestado-1").each(function () {
		var valorPresupuestado = $(this).html().replace(/\./g , '');
		sumaTotalPresupuestado += parseInt(valorPresupuestado); 
    });
    $('.totalPresupuestado-1').text(addCommas(sumaTotalPresupuestado));
    
    var sumaTotalReal2 = 0;
    $(".real2-1").each(function () {
		var valorTotalReal2 = $(this).html().replace(/\./g , '');
		sumaTotalReal2 += parseInt(valorTotalReal2); 
    });

    $('.totalReal2-1').text(addCommas(sumaTotalReal2));
    var abonadoMes2Basico = sumaTotalReal2; 
    
    console.log(sumaTotalReal2);
    
    var sumaTotalPresupuestado2 = 0;
    $(".presupuestado2-1").each(function () {
		var valorPresupuestado2 = $(this).html().replace(/\./g , '');
		sumaTotalPresupuestado2 += parseInt(valorPresupuestado2); 
    });
    
    console.log(sumaTotalPresupuestado2);
    
    
    $('.totalPresupuestado2-1').text(addCommas(sumaTotalPresupuestado2));
    
    var sumaTotalPromedioReal = 0;
    $(".promedioReal-1").each(function () {
		var valorPromedioReal = $(this).html().replace(/\./g , '');
		sumaTotalPromedioReal += parseInt(valorPromedioReal); 
    });
    $('.totalPromedioReal-1').text(addCommas(sumaTotalPromedioReal));
    
    var sumaTotalPromedioPresupuestado = 0;
    $(".promedioPresupuestado-1").each(function () {
		var valorPromedioPresupuestado = $(this).html().replace(/\./g , '');
		sumaTotalPromedioPresupuestado += parseInt(valorPromedioPresupuestado); 
    });
    $('.totalPromedioPresupuestado-1').text(addCommas(sumaTotalPromedioPresupuestado));
 	
 	/////2////////////////////////////////
 	
 	var sumaTotalReal2 = 0;
    $(".real-2").each(function () {
		var valorTotalReal2 = $(this).html().replace(/\./g , '');
		sumaTotalReal2 += parseInt(valorTotalReal2); 
    });
    $('.totalReal-2').text(addCommas(sumaTotalReal2));
    
    
    var sumaTotalPresupuestado2 = 0;
    $(".presupuestado-2").each(function () {
		var valorPresupuestado2 = $(this).html().replace(/\./g , '');
		sumaTotalPresupuestado2 += parseInt(valorPresupuestado2); 
    });
    $('.totalPresupuestado-2').text(addCommas(sumaTotalPresupuestado2));
    
    var sumaTotalReal22 = 0;
    $(".real2-2").each(function () {
		var valorTotalReal22 = $(this).html().replace(/\./g , '');
		sumaTotalReal22 += parseInt(valorTotalReal22); 
    });
    $('.totalReal2-2').text(addCommas(sumaTotalReal22));
    
    var sumaTotalPresupuestado22 = 0;
    $(".presupuestado2-2").each(function () {
		var valorPresupuestado22 = $(this).html().replace(/\./g , '');
		sumaTotalPresupuestado22 += parseInt(valorPresupuestado22); 
    });
    $('.totalPresupuestado2-2').text(addCommas(sumaTotalPresupuestado22));
    
    var sumaTotalPromedioReal2 = 0;
    $(".promedioReal-2").each(function () {
		var valorPromedioReal2 = $(this).html().replace(/\./g , '');
		sumaTotalPromedioReal2 += parseInt(valorPromedioReal2); 
    });
    $('.totalPromedioReal-2').text(addCommas(sumaTotalPromedioReal2));
    
    var sumaTotalPromedioPresupuestado2 = 0;
    $(".promedioPresupuestado-2").each(function () {
		var valorPromedioPresupuestado2 = $(this).html().replace(/\./g , '');
		sumaTotalPromedioPresupuestado2 += parseInt(valorPromedioPresupuestado2); 
    });
    $('.totalPromedioPresupuestado-2').text(addCommas(sumaTotalPromedioPresupuestado2));
    
    /////3////////////////////////////////
 	
 	var sumaTotalReal3 = 0;
    $(".real-3").each(function () {
		var valorTotalReal3 = $(this).html().replace(/\./g , '');
		sumaTotalReal3 += parseInt(valorTotalReal3); 
    });
    $('.totalReal-3').text(addCommas(sumaTotalReal3));
    
    
    var sumaTotalPresupuestado3 = 0;
    $(".presupuestado-3").each(function () {
		var valorPresupuestado3 = $(this).html().replace(/\./g , '');
		sumaTotalPresupuestado3 += parseInt(valorPresupuestado3); 
    });
    $('.totalPresupuestado-3').text(addCommas(sumaTotalPresupuestado3));
    
    var sumaTotalReal33 = 0;
    $(".real2-3").each(function () {
		var valorTotalReal33 = $(this).html().replace(/\./g , '');
		sumaTotalReal33 += parseInt(valorTotalReal33); 
    });
    $('.totalReal2-3').text(addCommas(sumaTotalReal33));
    
    var sumaTotalPresupuestado33 = 0;
    $(".presupuestado2-3").each(function () {
		var valorPresupuestado33 = $(this).html().replace(/\./g , '');
		sumaTotalPresupuestado33 += parseInt(valorPresupuestado33); 
    });
    $('.totalPresupuestado2-3').text(addCommas(sumaTotalPresupuestado33));
    
    var sumaTotalPromedioReal3 = 0;
    $(".promedioReal-3").each(function () {
		var valorPromedioReal3 = $(this).html().replace(/\./g , '');
		sumaTotalPromedioReal3 += parseInt(valorPromedioReal3); 
    });
    $('.totalPromedioReal-3').text(addCommas(sumaTotalPromedioReal3));
    
    var sumaTotalPromedioPresupuestado3 = 0;
    $(".promedioPresupuestado-3").each(function () {
		var valorPromedioPresupuestado3 = $(this).html().replace(/\./g , '');
		sumaTotalPromedioPresupuestado3 += parseInt(valorPromedioPresupuestado3); 
    });
    $('.totalPromedioPresupuestado-3').text(addCommas(sumaTotalPromedioPresupuestado3));
 	
 	//////////////////////////totales-Premium HD//////////////////////////
   var Uno = parseInt(sumaTotalReal2) + parseInt(sumaTotalReal3);
   var Dos = parseInt(sumaTotalPresupuestado2) + parseInt(sumaTotalPresupuestado3);
   var Tres = parseInt(sumaTotalReal22) + parseInt(sumaTotalReal33);
   var Cuatro = parseInt(sumaTotalPromedioReal2) + parseInt(sumaTotalPromedioReal3);
   var Cinco = parseInt(sumaTotalPromedioReal2) + parseInt(sumaTotalPromedioReal3);
    var Seis = parseInt(sumaTotalPromedioPresupuestado2) + parseInt(sumaTotalPromedioPresupuestado3);
   
   $(".totalUno").text(addCommas(Uno));
   $(".totalDos").text(addCommas(Dos));
   $(".totalTres").text(addCommas(Tres));
   $(".totalCuatro").text(addCommas(Cuatro));
   $(".totalCinco").text(addCommas(Cinco));
   $(".totalSeis").text(addCommas(Seis));
    /////////////////////////////////////////////////////////////////////////////////
    $('.totalAbonadosMesUno-1').text(addCommas(sumaTotalReal1));
    $('.totalAbonadosMesDos-1').text(addCommas(abonadoMes2Basico));
    var restaUno = parseInt(abonadoMes2Basico) - parseInt((sumaTotalReal1));
    $('.restaVariacion-1').text(addCommas(restaUno));
    var variacionPorcentaje = parseInt(restaUno) / parseInt(abonadoMes2Basico)  * 100;
    $('.variacionPorcentaje-1').text(variacionPorcentaje.toFixed(2)+' %');
    
    
    $('.totalAbonadosMesUno-2').text(addCommas(sumaTotalReal2));
    $('.totalAbonadosMesDos-2').text(addCommas(sumaTotalReal22));
    var restaDos = parseInt(sumaTotalReal22) - parseInt((sumaTotalReal2));
    $('.restaVariacion-2').text(addCommas(restaDos));
    var variacionPorcentajeDos = parseInt(restaDos) / parseInt(sumaTotalReal22)  * 100;
    $('.variacionPorcentaje-2').text(variacionPorcentajeDos.toFixed(2)+' %');
    
    
    $('.totalAbonadosMesUno-3').text(addCommas(sumaTotalReal3));
    $('.totalAbonadosMesDos-3').text(addCommas(sumaTotalReal33));
    var restaTres = parseInt(sumaTotalReal33) - parseInt((sumaTotalReal3));
    $('.restaVariacion-3').text(addCommas(restaTres));
    var variacionPorcentajeTres = parseInt(restaTres) / parseInt(sumaTotalReal33)  * 100;
    $('.variacionPorcentaje-3').text(variacionPorcentajeTres.toFixed(2) +' %');
    
    $('.variacionPresupuestado-1').text(addCommas(sumaTotalPromedioPresupuestado));
    $('.variacionReal-1').text(addCommas(sumaTotalPromedioReal));
    var restaPromedioUno = parseInt(sumaTotalPromedioReal) - parseInt(sumaTotalPromedioPresupuestado);
    $('.restaPromedio-1').text(addCommas(restaPromedioUno));
    var variacionPromedioUno = parseInt(restaPromedioUno) / parseInt(sumaTotalPromedioReal) * 100;
    $('.VariacionPromedio-1').text(variacionPromedioUno.toFixed(2) +' %');
    
    
    $('.variacionPresupuestado-2').text(addCommas(sumaTotalPromedioPresupuestado2));
    $('.variacionReal-2').text(addCommas(sumaTotalPromedioReal2));
    var restaPromedioDos = parseInt(sumaTotalPromedioReal2) - parseInt(sumaTotalPromedioPresupuestado2);
    $('.restaPromedio-2').text(addCommas(restaPromedioDos));
    var variacionPromedioDos = parseInt(restaPromedioDos) / parseInt(sumaTotalPromedioReal2) * 100;
    $('.VariacionPromedio-2').text(variacionPromedioDos.toFixed(2) +' %');
    
    
    $('.variacionPresupuestado-3').text(addCommas(sumaTotalPromedioPresupuestado3));
    $('.variacionReal-3').text(addCommas(sumaTotalPromedioReal3));
    var restaPromedioTres = parseInt(sumaTotalPromedioReal3) - parseInt(sumaTotalPromedioPresupuestado3);
    $('.restaPromedio-3').text(addCommas(restaPromedioTres));
    var variacionPromedioTres = restaPromedioTres / sumaTotalPromedioReal3 * 100;
    
    $('.VariacionPromedio-3').text(variacionPromedioTres.toFixed(2) +' %');
    
    
    ///////////////////////////////////Penetracion//////////////////////////////////////////////
    var penetracionMesUno = sumaTotalReal2 / sumaTotalReal1;
    $('.penetracionMesUno').text(penetracionMesUno.toFixed(2)  +' %');
    
    var penetracionMesDos = sumaTotalReal22 / abonadoMes2Basico;
    $('.penetracionMesDos').text(penetracionMesDos.toFixed(2)  +' %');
    
    var variacion = restaDos / restaUno;
    $('.variacion').text(variacion.toFixed(2)  +' %');
    
    var variacionPorcentaje = variacionPorcentajeDos / variacionPorcentaje;
    $('.variacionPorcentaje').text(variacionPorcentaje.toFixed(2)  +' %');
    
    var presupuestado = sumaTotalPromedioPresupuestado2 / sumaTotalPromedioPresupuestado;
    $('.presupuestado').text(presupuestado.toFixed(2)  +' %');
    
    var presupuestadoReal = sumaTotalPromedioReal2 / sumaTotalPromedioReal;
    $('.presupuestadoReal').text(presupuestadoReal.toFixed(2)  +' %');
    
    var presupuestadoResta = restaPromedioDos / restaPromedioUno;
    $('.presupuestadoResta').text(presupuestadoResta.toFixed(2)  +' %');
    
    console.log(variacionPromedioDos);
    console.log(variacionPromedioUno);
    var presupuestadoPromedio = variacionPromedioDos / variacionPromedioUno;
    $('.presupuestadoPromedio').text(presupuestadoPromedio.toFixed(2)  +' %');
    
 </script>
