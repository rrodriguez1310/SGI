<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email</title>
</head>
<body>
	<h2>GESTIÓN DE DESEMPEÑO CDF</h2>
	<hr>
	<p>Estimado(a) <?php echo $datos["nombre"]; ?>, recordamos que debes calibrar la evaluación de desempeño de <?php echo strtok($datos["evaluacion"]["nombre"]," ")  ." ". $datos["evaluacion"]["apellido_paterno"]; ?>. Hoy culmina el plazo para completar esta etapa.
	<br><br>Gracias.</p>
	<br>
	<!--p><u><b>Detalle evaluación:</b></u></p>
	<table>
		<tr>
			<td><b>Colaborador evaluado</b></td>	
			<td>&emsp;<?php echo $datos["evaluacion"]["nombre"] ." ". $datos["evaluacion"]["apellido_paterno"]; ?></td>
		</tr>
		<tr>
			<td><b>Cargo</b></td>
			<td>&emsp;<?php echo $datos["evaluacion"]["cargo"]; ?></td>
		</tr>
		<tr>
			<td><b>Evaluador / Jefatura</b></td> 				
			<td>&emsp;<?php echo $datos["evaluacion"]["jefatura"]; ?></td>
		</tr>
		<tr>
			<td><b>Fecha límite</b></td> 			
			<td>&emsp;<?php echo $datos["fecha_limite"]; ?></td>
		</tr>
	</table-->
	<h4><a href="http://sgi.cdf.local/">Acceder a SGI</a></h4>
</body>
</html>