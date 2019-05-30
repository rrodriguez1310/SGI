<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email</title>
</head>
<body>
	<h1>ASIGNACIÓN REQUERIMIENTO IMAGENES</h1>
	<hr>
	<div style="padding : 0% 10%;">
		<table style="width:100%">
			<tr>
				<td colspan="2" style="text-align:center"><h3>REQUERIMIENTO</h3></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Tipo :</b></td>
				<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($requerimiento["CatalogacionRTipo"]["nombre"]);?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Creado por :</b></td>
				<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($requerimiento["User"]["nombre"]);?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Responsable :</b></td>
				<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($usuarios[$requerimiento["CatalogacionRResponsable"]["user_id"]]);?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Fecha creacion :</b></td>
				<td style="text-align:left; width: 50%"><?php $fechaCreacion = new DateTime($requerimiento["CatalogacionRequerimiento"]["created"]); $fechaCreacion->modify("-3 hour"); echo $fechaCreacion->format("d/m/Y H:i") ?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Fecha entrega :</b></td>
				<td style="text-align:left; width: 50%"><?php $fechaEntrega = new DateTime($requerimiento["CatalogacionRequerimiento"]["fecha_entrega"]); echo $fechaEntrega->format("d/m/Y H:i") ?></td>
			</tr>
			<tr>
				<td style="text-align:right; width: 50%"><b>Observacion :</b></td>
				<td style="text-align:left; width: 50%"><?php echo nl2br($requerimiento["CatalogacionRequerimiento"]["observacion"]); ?></td>
			</tr>
		</table>
		<br />
		<?php if(!empty($requerimiento["CatalogacionRDigitale"]["estado"])) : ?>
			<?php if($requerimiento["CatalogacionRDigitale"]["estado"] == 1) :?>
				<table style="width:100%">
					<tr>
						<td colspan="2" style="text-align:center"><h3>ENTREGA</h3></td>
					</tr>
					<tr>
						<td style="text-align:right; width: 50%"><b>Tipo :</b></td>
						<td style="text-align:left; width: 50%">DIGITAL</td>
					</tr>
					<tr>
						<td style="text-align:right; width: 50%"><b>Medio de entrega :</b></td>
						<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($servidores[$requerimiento["CatalogacionRDigitale"]["ingesta_servidore_id"]]); ?></td>
					</tr>
					<tr>
						<td style="text-align:right; width: 50%"><b>Ruta o carpeta :</b></td>
						<td style="text-align:left; width: 50%"><?php echo $requerimiento["CatalogacionRDigitale"]["ruta"]; ?></td>
					</tr>
					<tr>
						<td style="text-align:right; width: 50%"><b>Observacion entrega :</b></td>
						<td style="text-align:left; width: 50%"><?php echo nl2br($requerimiento["CatalogacionRDigitale"]["observacion"]); ?></td>
					</tr>
				</table>
			<?php endif; ?>
		<?php endif;?>
		<?php if(!empty($requerimiento["CatalogacionRFisico"]["estado"])) : ?>
			<?php if($requerimiento["CatalogacionRFisico"]["estado"] == 1) :?>
				<table style="width:100%">
					<tr>
						<td colspan="2" style="text-align:center"><h3>ENTREGA</h3></td>
					</tr>
					<tr>
						<td style="text-align:right; width: 50%"><b>Tipo :</b></td>
						<td style="text-align:left; width: 50%">FISICA</td>
					</tr>
					<tr>
						<td style="text-align:right; width: 50%"><b>Soporte :</b></td>
						<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($soportes[$requerimiento["CatalogacionRFisico"]["soporte_id"]]);?></td>
					</tr>
					<tr>
						<td style="text-align:right; width: 50%"><b>Copia :</b></td>
						<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($copias[$requerimiento["CatalogacionRFisico"]["copia_id"]]);?></td>
					</tr>
					<tr>
						<td style="text-align:right; width: 50%"><b>Logo :</b></td>
						<td style="text-align:left; width: 50%"><?php echo $requerimiento["CatalogacionRFisico"]["logo"] ;?></td>
					</tr>
					<?php if($requerimiento["CatalogacionRFisico"]["logo"] == "SI"):?>
						<tr>
							<td style="text-align:right; width: 50%"><b>Posición logo :</b></td>
							<td style="text-align:left; width: 50%"><?php echo mb_strtoupper($requerimiento["CatalogacionRFisico"]["logo_posicion"]) ;?></td>
						</tr>
					<?php endif;?>
					<tr>
						<td style="text-align:right; width: 50%"><b>Observacion entrega :</b></td>
						<td style="text-align:left; width: 50%"><?php echo nl2br($requerimiento["CatalogacionRFisico"]["observacion"]); ?></td>
					</tr>
				</table>
			<?php endif; ?>
		<?php endif;?>
		<br /> 
		<table style="width:100%; border-collapse: collapse">
			<tr>
				<td colspan="2" style="text-align:center"><h3>DESCRIPCIÓN</h3></td>
			</tr>
			<tr>
				<td style="text-align:center; width: 50%; border: 1px solid black; border-collapse: collapse"><b>Tipo</b></td>
				<td style="text-align:center; width: 50%; border: 1px solid black; border-collapse: collapse"><b>Valor</b></td>
			</tr>
			<?php foreach($requerimiento["CatalogacionRTag"] as $tag):?>
				<?php if($tag["estado"] == 1) :?>
				<tr>
					<td style="text-align:center; width: 50%; border: 1px solid black; border-collapse: collapse"><?php echo mb_strtoupper($tagstipos[$tag["catalogacion_r_tags_tipo_id"]]); ?></td>
					<td style="text-align:center; width: 50%; border: 1px solid black; border-collapse: collapse"><?php echo mb_strtoupper($tag["valor"]); ?></td>
				</tr>
				<?php endif;?>
			<?php endforeach; ?>
		</table>
	</div>
</body>
</html>