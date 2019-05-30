<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Se registro un nuevo contrato</title>
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
		<h1>Se registro un nuevo contrato Empresa</h1>
		<hr>
		<p>Fecha inicio:  <?php echo $fechaInicio; ?></p>
		<p>Fecha vencimiento: <?php echo $fechaVencimiento; ?></p>
		<p>Gerencia: <?php echo $gerencia; ?> </p>
		<p>Empresa : <?php echo $empresa; ?></p>
		<p>descripción: <?php echo $observacion; ?></p>
		<hr>
		<h3><a href="http://intranet.cdf.local/">ir a intranet</a></h3>
		<p><strong>Nota: No responda este emails, el cual ha sido generado en forma automática por el Sistema de Gestión de Informacion (SGI)</strong><p>
	</body>
</html>