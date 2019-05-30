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
	<p>Estimado(a) <?php echo strtok($datos["nombre_email"], " "); ?>, los OCD de <?php echo $datos["nombre_trabajador"]; ?> han sido calibrados por <?php echo $datos["nombre_calibrador"]?>. <br>
	Recuerda que debes agendar reunión con el colaborador para realizar la comunicación de sus OCD. 
	<br><br>Gracias.</p>
	<p>&nbsp;</p>
	<h4><a href="http://sgi.cdf.local/">Acceder a SGI</a></h4>
</body>
</html>