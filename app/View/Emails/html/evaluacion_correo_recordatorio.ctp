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
	<p>Estimado(a) <?php echo $datos["nombre"]; ?>, recordamos que debes realizar la evaluación de desempeño de la(s) siguiente(s) persona(s):
	<br></p>
		<?php 
			foreach ($datos["Trabajadore"] as $key => $value) :
				echo ($key+1).'. '.$value.'<br>';
			endforeach;
		?>
	<p>Es importante que completes esta etapa lo antes posible, dado que es requisito para culminar el proceso con éxito.</p>
	Gracias.
	<br><br>
	<h4><a href="http://sgi.cdf.local/">Acceder a SGI</a></h4>
</body>
</html>