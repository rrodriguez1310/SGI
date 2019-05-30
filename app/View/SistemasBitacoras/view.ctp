<div class="row">
	<div class="col-md-8 col-md-offset-2 text-center">
		<h3>Detalle Bitacora</h3>
	</div>
	<div class="col-md-2">
		<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"sistemas_bitacoras", "action"=>"index"), array("class"=>"btn btn-default pull-right", "escape"=>false)); ?>
	</div>
</div>
<br />
<div class="col-md-8 col-md-offset-2">
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Creado por :</strong>
		</div>
		<div class="col-md-8">
			<?php echo mb_strtoupper($bitacora["User"]["nombre"]);?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Responsable :</strong>
		</div>
		<div class="col-md-8">
			<?php echo mb_strtoupper($bitacora["SistemasResponsable"]["User"]["nombre"]);?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Estado :</strong>
		</div>
		<div class="col-md-8">
			<span class="label label-<?php echo ($bitacora["SistemasBitacora"]["estado"]== 1) ? "warning" : "success";?>"><?php echo mb_strtoupper(($estados[$bitacora["SistemasBitacora"]["estado"]]));?></span>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Gerencia :</strong>
		</div>
		<div class="col-md-8">
			<?php echo mb_strtoupper($bitacora["Area"]["Gerencia"]);?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Área :</strong>
		</div>
		<div class="col-md-8">
			<?php echo mb_strtoupper($bitacora["Area"]["nombre"]);?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Trabajador :</strong>
		</div>
		<div class="col-md-8">
			<?php echo mb_strtoupper(empty($bitacora["Trabajadore"]["nombre"]) ? "Sin trabajador asociado" : $bitacora["Trabajadore"]["nombre"]." ".$bitacora["Trabajadore"]["apellido_paterno"]." ".$bitacora["Trabajadore"]["apellido_materno"]);?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Fecha inicio :</strong>
		</div>
		<div class="col-md-8">
			<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["fecha_inicio"])->format('d/m/Y H:i');?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Fecha termino :</strong>
		</div>
		<div class="col-md-8">
			<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["fecha_termino"])->format('d/m/Y H:i');?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Fecha cierre :</strong>
		</div>
		<div class="col-md-8">
			<?php echo empty($bitacora["SistemasBitacora"]["fecha_cierre"]) ? "" : DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["fecha_cierre"])->format('d/m/Y H:i');?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Tiempo estimado :</strong>
		</div>
		<div class="col-md-8">
			El tiempo estimado eran <?php echo $bitacora["SistemasBitacora"]["tiempo_estimado"]["dias"]." ".ngettext("día", "días", (int)$bitacora["SistemasBitacora"]["tiempo_estimado"]["dias"])." ".$bitacora["SistemasBitacora"]["tiempo_estimado"]["horas"]." ".ngettext("hora", "horas", (int)$bitacora["SistemasBitacora"]["tiempo_estimado"]["horas"])." y ".$bitacora["SistemasBitacora"]["tiempo_estimado"]["minutos"]." ".ngettext("minuto", "minutos", (int)$bitacora["SistemasBitacora"]["tiempo_estimado"]["minutos"]);?>

		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Tiempo real :</strong>
		</div>
		<div class="col-md-8">
			<?php echo isset($bitacora["SistemasBitacora"]["tiempo_real"]) ? "El tiempo real fue ".$bitacora["SistemasBitacora"]["tiempo_real"]["dias"]." ".ngettext("día", "días", (int)$bitacora["SistemasBitacora"]["tiempo_real"]["dias"])." ".$bitacora["SistemasBitacora"]["tiempo_real"]["horas"]." ".ngettext("hora", "horas", (int)$bitacora["SistemasBitacora"]["tiempo_real"]["horas"])." y ".$bitacora["SistemasBitacora"]["tiempo_real"]["minutos"]." ".ngettext("minuto", "minutos", (int)$bitacora["SistemasBitacora"]["tiempo_real"]["minutos"]) : "";?>

		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Dif. entre estimado y real :</strong>
		</div>
		<div class="col-md-8">
			<?php if(isset($bitacora["SistemasBitacora"]["tiempo_diferencia"])) :?>
				<?php 
					echo $bitacora["SistemasBitacora"]["tiempo_diferencia"]["dias"]." ".ngettext("día", "días", (int)$bitacora["SistemasBitacora"]["tiempo_diferencia"]["dias"])." ".$bitacora["SistemasBitacora"]["tiempo_diferencia"]["horas"]." ".ngettext("hora", "horas", (int)$bitacora["SistemasBitacora"]["tiempo_diferencia"]["horas"])." y ".$bitacora["SistemasBitacora"]["tiempo_diferencia"]["minutos"]." ".ngettext("minuto", "minutos", (int)$bitacora["SistemasBitacora"]["tiempo_diferencia"]["minutos"]);
					echo ($bitacora["SistemasBitacora"]["fecha_termino"]<$bitacora["SistemasBitacora"]["fecha_cierre"]) ? " de más que el estimado" : (($bitacora["SistemasBitacora"]["fecha_termino"]==$bitacora["SistemasBitacora"]["fecha_cierre"]) ? " precision es tú nombre" : " menos que el estimado");
				;?>
				<span class="<?php echo ($bitacora["SistemasBitacora"]["fecha_termino"]>=$bitacora["SistemasBitacora"]["fecha_cierre"]) ? "text-success" : "text-danger";?>">
				<?php echo ($bitacora["SistemasBitacora"]["fecha_termino"]>=$bitacora["SistemasBitacora"]["fecha_cierre"]) ? '<i class="fa fa-thumbs-o-up fa-lg"></i>': '<i class="fa fa-thumbs-o-down fa-lg"></i>';?>
				</span>
			<?php endif;?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Titulo :</strong>
		</div>
		<div class="col-md-8">
			<?php echo $bitacora["SistemasBitacora"]["titulo"];?>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-12 text-center">
			<strong>Tarea :</strong>
		</div>		
	</div>
	<br />
	<div class="row">
		<div class="col-md-12 text-left">
			<pre><?php echo $bitacora["SistemasBitacora"]["observacion_ingreso"];?></pre>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-12 text-center">
			<strong>Observaciones :</strong>
		</div>
	</div>
	<br />
	<?php if(!empty($bitacora["SistemasBitacorasOb"])) :?>
		<?php foreach($bitacora["SistemasBitacorasOb"] as $i => $observacion) :?>
			<div class="row">
				<div class="col-md-12">
					<span class="label label-<?php echo $usuarios[$observacion["user_id"]]["color"]?>"><?php echo mb_strtoupper($usuarios[$observacion["user_id"]]["nombre"]);?></span> 
					<?php $observacion["created"] = new DateTime($observacion["created"]); $observacion["created"]->setTimeZone(new DateTimeZone("America/Santiago")); echo DateTime::createFromFormat('Y-m-d H:i:s', $observacion["created"]->format("Y-m-d H:i:s"))->format('d/m/Y H:i');?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<pre><?php echo $observacion["observacion"];?></pre>
				</div>
			</div>
		<?php endforeach;?>
	<?php endif; ?>
	<?php if(empty($bitacora["SistemasBitacorasOb"])) :?>
		<pre>Sin Observaciones</pre>
	<?php endif; ?>
	<br />
	<div class="row">
		<div class="col-md-12 text-center">
			<strong>Cierre :</strong>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-12">
			<pre><?php echo empty($bitacora["SistemasBitacora"]["observacion_termino"]) ? " " : $bitacora["SistemasBitacora"]["observacion_termino"];?></pre>
		</div>
	</div>
</div>
