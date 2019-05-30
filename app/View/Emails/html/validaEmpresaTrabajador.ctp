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
	<h1>Se Creo un documento asociado a un trabajador activo</h1>
	<hr>
	<p>Fecha creación:  <?php echo $fechaCreacion; ?></p>
	<p>Documento: <?php echo $numeroDocumento; ?></p>
	<p>Usuario creador:  <?php echo $usuarioCreador; ?></p>
	<p>Empresa seleccionada: <?php echo $empresa; ?></p>
	<hr>
	<h3><a href="http://intranet.cdf.local/">ir a intranet</a></h3>
</body>
</html>