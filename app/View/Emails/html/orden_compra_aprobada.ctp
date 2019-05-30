<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email</title>
	<style type="text/css">
 		table,th,td
		{
			border:1px solid black;
			border-collapse:collapse;
			padding:5px;
			text-align: center;
		}
  </style>
</head>
<body>
	<h1><?php echo $nombreEmail; ?></h1>
	<hr>
	<p>Fecha creación:  <?php echo $fechaCreacion; ?></p>
	<p>Usuario aprobador:  <?php echo $usuario; ?></p>
	<p>Titulo requerimiento: <?php echo $titulo; ?></p>
	<p>ID requerimiento: <?php echo $numeroRequerimiento; ?> </p>
	<p>Nombre empresa: <?php echo $empresa; ?></p>
	<p>Total: $<?php echo number_format($total, 0, '', '.'); ?></p>
	<hr>
	<h3><a href="http://intranet.cdf.local/">ir a intranet</a></h3>
</body>
</html>