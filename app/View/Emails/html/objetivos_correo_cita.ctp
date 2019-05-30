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
	<p>Estimado(a) <?php echo strtok($datos["nombre_trabajador"]," "); ?>, tu jefatura ha agendado la reunión de Comunicación de OCD para el día <?php echo $datos["fecha_comunicacion"]; ?> a las <?php echo $datos["hora_comunicacion"]; ?> horas en <?php echo $datos["lugar_comunicacion"]; ?>.<br>	
	<br>Gracias.</p>
	<p>&nbsp;</p>
</body>
</html>