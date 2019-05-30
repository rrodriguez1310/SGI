 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Document</title>
</head>
<body>
<?php foreach($salida as $key => $salida ){?>
<?php echo "<h1>Antiguedad " . $key . " Años"."</h1>";?>
<?php foreach($salida as $datos ){ ?>
<table border="1" style="color:#000;" cellpadding='10' cellspacing='0'>
<tr>
<td align="left" width="160"><b>Nombre:</b></td>
<td align="left" width="160"><b><?php echo $datos['nombre']; ?></b></td>
</tr>
<tr>
<td align="left"><b>Fecha Ingreso:</b></td>
<td align="left"><b><?php echo $datos['fechaIngreso']; ?></b></td>
</tr>
<tr>
<td align="left"><b>Fecha Aniversario:</b></td>
<td align="left"><b><?php echo $datos['cumple']; ?></b></td>
</tr>
</table>
<br/>
<?php }
}?> 
</html>
