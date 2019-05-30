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
	<p>Estimado(a) <?php echo strtok($datos["evaluador_nombre"], " "); ?>, la evaluación de desempeño de <?php echo $datos["trabajador_nombre"]; ?> ha sido calibrada por <?php echo $datos["calibrador_nombre"] . ' ' .$datos["estado"]; ?> observaciones. <br>
	Recuerda que debes agendar reunión con el colaborador para realizar el Diálogo de Desempeño. 
	<br><br>Gracias.</p>
	<p>&nbsp;</p>
	<h4><a href="http://sgi.cdf.local/">Acceder a SGI</a></h4>
</body>
</html>