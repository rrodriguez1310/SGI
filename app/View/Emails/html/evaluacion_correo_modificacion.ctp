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
	<p>Estimado(a) <?php echo strtok($datos["calibrador_nombre"], " "); ?>, la evaluación de desempeño de <?php echo $datos["trabajador_nombre"]; ?> ha sido modificada por <?php echo $datos["evaluador_nombre"]; ?> tras diálogo de desempeño. <br>
	Se adjunta documento final.
	</p>
	<p>&nbsp;</p>
	<h4><a href="http://sgi.cdf.local/">Acceder a SGI</a></h4>
</body>
</html>