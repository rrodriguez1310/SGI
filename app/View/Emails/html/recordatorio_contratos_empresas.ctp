<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Aviso de vencimiento de contrato</title>
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
		<h1>Aviso de vencimiento de contrato</h1>
		<hr>
		<h4>Le informamos que el próximo <?php echo $fechaVencimiento; ?> vence el contrato vigente con la empresa <strong><?php echo $empresa?></strong></h4>
		<p>Fecha inicio:  <?php echo $fechaInicio; ?></p>
		<p>Fecha termino:  <?php echo $fechaTermino; ?></p>
		<p>Fecha vencimineto: <?php echo $fechaVencimiento; ?></p>
		<p>Gerencia: <?php echo $gerencia; ?> </p>
		<p>Observación: <?php echo $observacion; ?></p>
		<hr>
		<h3><a href="http://intranet.cdf.local/">ir a intranet</a></h3>
		<p><strong>Nota: No responda este emails, el cual ha sido generado en forma automática por el Sistema de Gestión de Informacion (SGI)</strong><p>
	</body>
</html>