<div class="row">
	<div class="col-md-8 col-md-offset-2 text-center">
		<h3>Detalle Incidencia</h3>
	</div>
	<div class="col-md-2">
		<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"sistemas_incidencias", "action"=>"index"), array("class"=>"btn btn-default pull-right", "escape"=>false)); ?>
	</div>
</div>
<br />
<div class="col-md-8 col-md-offset-2">
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Creado por :</strong>
		</div>
		<div class="col-md-8">
			<?php echo mb_strtoupper($incidencia["User"]["nombre"]);?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Responsable :</strong>
		</div>
		<div class="col-md-8">
			<?php echo mb_strtoupper($incidencia["SistemasResponsablesIncidencia"]["User"]["nombre"]);?>
		</div>
	</div>
		<div class="row">
		<div class="col-md-4 text-right">
			<strong>Gerencia :</strong>
		</div>
		<div class="col-md-8">
			<?php echo mb_strtoupper($incidencia["Area"]["Gerencia"]);?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Estado :</strong>
		</div>
		<div class="col-md-8">
			<span class="label label-<?php echo ($incidencia["SistemasIncidencia"]["estado"]== 1) ? "warning" : "success";?>"><?php echo mb_strtoupper(($estados[$incidencia["SistemasIncidencia"]["estado"]]));?></span>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Área :</strong>
		</div>
		<div class="col-md-8">
			<?php echo mb_strtoupper($incidencia["Area"]["nombre"]);?>
		</div>
	</div>
	<!--<div class="row">
		<div class="col-md-4 text-right">
			<strong>Trabajador :</strong>
		</div>
		<div class="col-md-8">
			<?php echo mb_strtoupper(empty($incidencia["Trabajadore"]["nombre"]) ? "Sin trabajador asociado" : $incidencia["Trabajadore"]["nombre"]." ".$incidencia["Trabajadore"]["apellido_paterno"]." ".$incidencia["Trabajadore"]["apellido_materno"]);?>
		</div>
	</div>-->
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Fecha inicio :</strong>
		</div>
		<div class="col-md-8">
			<?php echo $incidencia["SistemasIncidencia"]["fecha_inicio"]?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Fecha cierre :</strong>
		</div>
		<div class="col-md-8">
			<?php echo $incidencia["SistemasIncidencia"]["fecha_cierre"]?>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-md-4 text-right">
			<strong>Titulo :</strong>
		</div>
		<div class="col-md-8">
			<?php echo $incidencia["SistemasIncidencia"]["titulo"];?>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-12 text-center">
			<strong>Dtalle Tarea / Problema :</strong>
		</div>		
	</div>
	<br />
	<div class="row">
		<div class="col-md-12 text-left">
			<pre><?php echo $incidencia["SistemasIncidencia"]["tarea"];?></pre>
		</div>
	</div>
	<br />
	<?php if(!empty($incidenciasobs["SistemasIncidenciasOb"])) :?>
	<div class="row">
		<div class="col-md-12 text-center">
			<strong>Observaciones :</strong>
		</div>
	</div>
	<br />
	
	
		<pre><?php echo $incidenciasobs["SistemasIncidenciasOb"]["observacion"];?></pre>
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
			<pre><?php echo empty($incidencia["SistemasIncidencia"]["observacion_termino"]) ? " " : $incidencia["SistemasIncidencia"]["observacion_termino"];?></pre>
		</div>
	</div>
</div>
