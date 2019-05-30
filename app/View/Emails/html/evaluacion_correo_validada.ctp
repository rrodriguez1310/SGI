<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email</title>
</head>								
<body>
	<h2>GESTIÓN DE DESEMPEÑO CDF</h2>
	<hr>
	<p>Estimado(a) <?php echo strtok($datos["evaluador_nombre"], " "); ?>, 
	<?php if(isset($datos["motivo"])) :?> 
		la evaluación de <?php echo $datos["trabajador_nombre"]; ?> ha sido validada de manera automática por el sistema.  <br>
	<?php else: ?>
		la evaluación de <?php echo $datos["trabajador_nombre"]; ?> ha sido validada exitosamente. <br>
	<?php endif; ?>

	Con esto la Evaluación de Desempeño <?php echo $datos["anio_evaluacion"]; ?> del colaborador ha finalizado.
	<?php 	//if($datos["estado"]=='sin') :	?> 
		<!--Recuerda que debes imprimirla y subirla al sistema firmada por ambos.
	<?php 	//else :	?> 
		Recuerda que debes imprimir el documento y adjuntarlo al sistema firmado por ambos.-->
	<?php 	//endif;	?> 
	</p>
	<?php 	if($datos["estado"]=='con') : ?> 
	<p><b>Comentarios</b>
	<br>
	<?php echo $datos["colaborador_comentarios"]; ?>
	</p>
	<?php 	endif; 	?> 
	Gracias.
</body>
</html>