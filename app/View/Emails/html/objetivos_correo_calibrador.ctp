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
	<p>Estimado(a) <?php echo strtok($datos["nombre_email"], " "); ?>, solicitamos calibrar los OCD de <?php echo $datos["nombre_trabajador"]; ?>. Recuerda que tienes un plazo de <?php echo $datos["dias_plazo"]; ?> días hábiles para completar esta etapa. 
	<br><br>Gracias.</p>
	<br>
	<h4><a href="http://sgi.cdf.local/">Acceder a SGI</a></h4>
</body>
</html>