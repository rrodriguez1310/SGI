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
	<p>Estimado(a) <?php echo strtok($datos["trabajador_nombre"]," "); ?>, tu jefatura ha agendado la reunión de Diálogo de Desempeño para el día <?php echo $datos["fecha_reunion"]; ?> a las <?php echo $datos["hora_reunion"]; ?> horas en <?php echo $datos["lugar_reunion"]; ?>.<br>
	<!--Adjunto encontrarás un resumen de tu Evaluación de Desempeño <?php // echo $datos["anio_evaluacion"]; ?>. <br>-->
	<br>Gracias.</p>
	<p>&nbsp;</p>
</body>
</html>