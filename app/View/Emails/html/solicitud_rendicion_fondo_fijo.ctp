<table >
	<tr>
		<td colspan="2" style="background:#cccccc;padding:5px"><h3>Acepta Solicitud Requerimiento Compra</h3></td>
	</tr>

     <tr>
		<td width="100" style="padding:5px"><strong>Tipo fondo:</strong></td>
        <td style="padding:5px"><?php
            if($tipo_fondo==1){
                echo "Fondo por rendir  ";
            }else{
                echo "Fondo fijo";
            }
        ?>
        </td>
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
		<td width="100" style="padding:5px"><strong>Fecha:</strong></td>
		<td style="padding:5px"><?=$fecha?></td>
	</tr>

	<tr>
		<td width="100" style="padding:5px">&nbsp;</td>
	</tr>
	<tr>
		<td width="100" style="padding:5px">&nbsp;</td>
	</tr>
	<tr>
		<td width="100" style="padding:5px"><a href="http://192.168.1.25/qa/solicitudes_requerimientos" target="_blank">Ir a sgi-v3</a></td>
	</tr>
</table>