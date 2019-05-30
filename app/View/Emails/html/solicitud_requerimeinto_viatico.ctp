<table >
	<tr>
		<td colspan="2" style="background:#cccccc;padding:5px"><h3><?=$cabecera?></h3></td>
	</tr>

    <tr>
		<td width="100" style="padding:5px"><strong>Titulo:</strong></td>
		<td style="padding:5px"><?=$titulo?></td>
	</tr>
	<tr>
		<td width="100" style="padding:5px"><strong>Usuario:</strong></td>
		<td style="padding:5px"><?=$usuario?></td>
	</tr>
	<tr>
		<td width="100" style="padding:5px"><strong>Moneda:</strong></td>
		<td style="padding:5px"><?=$moneda?></td>
	</tr>
	<tr>
		<td width="100" style="padding:5px"><strong>Monto:</strong></td>
		<td style="padding:5px"><?=$monto?></td>
	</tr>

    <tr>
		<td width="100" style="padding:5px"><strong>Motivo:</strong></td>
		<td style="padding:5px"><?=isset($motivo)?$motivo:'S/N';?></td>
	</tr>

	<tr>
		<td width="100" style="padding:5px">&nbsp;</td>
	</tr>
	<tr>
		<td width="100" style="padding:5px">&nbsp;</td>
	</tr>
	<tr>
		<td width="100" style="padding:5px"><a href="http://192.168.1.25/qa/<?=$link?>" target="_blank">Ir a sgi-v3</a></td>
	</tr>
</table>