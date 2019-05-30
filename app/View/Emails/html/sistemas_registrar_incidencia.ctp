<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email</title>
</head>
<body>
	<h1><?php echo $titulo; ?></h1>
	<hr>
	<div style="padding : 0% 10%;">
		<table style="width:100%">
			<tr>
				<td colspan="2" style="text-align:center"><h3>Incidencia</h3></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Estado :</b></td>
				<td style="text-align:left; width: 50%">En Proceso</td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Gerencia :</b></td>
				<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($incidencia["Gerencia"]);?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Área :</b></td>
				<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($incidencia["Area"]["nombre"]);?></td>
			</tr>
			
			<tr>
				<td style="text-align:right; width: 50%"><b>Creado por :</b></td>
				<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($incidencia["User"]["nombre"]);?></td>
			</tr>
			
			
			<tr>
				<td style="text-align:right; width: 50%"><b>Fecha inicio :</b></td>
				<td style="text-align:left; width: 50%"><?php $fechaEntrega = new DateTime($incidencia["SistemasIncidencia"]["fecha_inicio"]); echo $fechaEntrega->format("d/m/Y H:i") ?></td>
			</tr>
			
			
			<tr>
				<td style="text-align:right; width: 50%"><b>Titulo :</b></td>
				<td style="text-align:left; width: 50%"><?php echo $incidencia["SistemasIncidencia"]["titulo"];?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Tarea :</b></td>
				<td style="text-align:left; width: 50%"><?php echo nl2br($incidencia["SistemasIncidencia"]["tarea"]); ?></td>
			</tr>
		</table>
	</div>
</body>
</html>