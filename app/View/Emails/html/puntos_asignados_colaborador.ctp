<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email</title>
</head>
<body>
	<h2>Programa de Reconocimiento CDF.</h2>
	<hr>
	<p>Has recibido un reconocimiento por parte de tu jefatura.</p>
	<p>Los destalles son:<br></p>				
	<ul>
		<li>Valor: <?php echo $valor; ?></li>
		<li>Comportamiento: <?php echo $comportamiento; ?></li>
		<li>Descripcion: <?php echo $descripcion; ?></li>
		<li>Puntaje obtenido: <?php echo $puntos; ?></li>
		<li>Fecha: <?php echo $fechaActual; ?></li>
	</ul>
	<p>&nbsp;</p>
	¡Felicitaciones!

</body>
</html> 