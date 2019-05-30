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
	<p>Estimado(a) <?php echo strtok($datos["nombre_trabajador"], " "); ?>, tu jefatura ha solicitado que confirmes tus OCD <?php echo $datos["anio_ocd"]; ?>. Dispones de <?php echo $datos["dias_plazo"]; ?> día para realizar esta etapa.<br>
	<br><br>Gracias.</p>
	<p>&nbsp;</p>
	<h4><a href="http://sgi.cdf.local/">Acceder a SGI</a></h4>
</body>
</html>