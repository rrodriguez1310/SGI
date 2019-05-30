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
				<td colspan="2" style="text-align:center"><h3>Bitacora</h3></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Estado :</b></td>
				<td style="text-align:left; width: 50%">En Proceso</td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Gerencia :</b></td>
				<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($bitacora["Gerencia"]);?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Área :</b></td>
				<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($bitacora["Area"]["nombre"]);?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Trabajador :</b></td>
				<td style="text-align:left; width: 50%"><?php echo mb_strtoupper(empty($bitacora["Trabajadore"]["nombre"]) ? "Sin trabajador asociado" : $bitacora["Trabajadore"]["nombre"]." ".$bitacora["Trabajadore"]["apellido_paterno"]." ".$bitacora["Trabajadore"]["apellido_materno"]);?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Creado por :</b></td>
				<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($bitacora["User"]["nombre"]);?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Asignado a :</b></td>
				<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($bitacora["SistemasResponsable"]["User"]["nombre"]);?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Fecha creacion :</b></td>
				<td style="text-align:left; width: 50%"><?php $fechaCreacion = new DateTime($bitacora["SistemasBitacora"]["created"]); $fechaCreacion->modify("-3 hour"); echo $fechaCreacion->format("d/m/Y H:i") ?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Fecha inicio :</b></td>
				<td style="text-align:left; width: 50%"><?php $fechaEntrega = new DateTime($bitacora["SistemasBitacora"]["fecha_inicio"]); echo $fechaEntrega->format("d/m/Y H:i") ?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Fecha termino :</b></td>
				<td style="text-align:left; width: 50%"><?php $fechaTermino = new DateTime($bitacora["SistemasBitacora"]["fecha_termino"]); echo $fechaTermino->format("d/m/Y H:i") ?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Tiempo estimado :</b></td>
				<td style="text-align:left; width: 50%"><?php echo $bitacora["SistemasBitacora"]["tiempo_estimado"]["dias"]." ".ngettext("día", "días", (int)$bitacora["SistemasBitacora"]["tiempo_estimado"]["dias"])." ".$bitacora["SistemasBitacora"]["tiempo_estimado"]["horas"]." ".ngettext("hora", "horas", (int)$bitacora["SistemasBitacora"]["tiempo_estimado"]["horas"])." y ".$bitacora["SistemasBitacora"]["tiempo_estimado"]["minutos"]." ".ngettext("minuto", "minutos", (int)$bitacora["SistemasBitacora"]["tiempo_estimado"]["minutos"]);?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Titulo :</b></td>
				<td style="text-align:left; width: 50%"><?php echo $bitacora["SistemasBitacora"]["titulo"];?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Tarea :</b></td>
				<td style="text-align:left; width: 50%"><?php echo nl2br($bitacora["SistemasBitacora"]["observacion_ingreso"]); ?></td>
			</tr>
		</table>
	</div>
</body>
</html>