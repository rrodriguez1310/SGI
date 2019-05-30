<div compile="plantillaFinal" id="plantillaFinal">
	<label style="width:100%;text-align:center">
		<center><b>EVALUACIÓN DE DESEMPEÑO {{anioEvaluado}}</b></center>
	</label>	
	<div style="font-size:11px">
		<p><b>RESULTADOS EVALUACIÓN DE DESEMPEÑO</b></p>
		<table border="1" cellpadding="3" style="width:100%">
			<tr>
				<td width="30%" style="background-color:#CED8F6;color:#2E2E2E;"><b>Nombre Colaborador</b></td>
				<td width="70%"><b>{{trabajador.nombre}}</b></td>
			</tr>
			<tr>
				<td style="background-color:#CED8F6;color:#2E2E2E;"><b>Cargo</b></td>
				<td>{{trabajador.cargo}}</td>
			</tr>
			<tr>
				<td style="background-color:#CED8F6;color:#2E2E2E;"><b>Nombre Jefatura</b></td>
				<td>{{trabajador.jefatura}}</td>
			</tr>									
			<tr>
				<td style="background-color:#CED8F6;color:#2E2E2E;"><b>Puntaje Competencias</b></td>
				<td>{{formulario.EvaluacionesTrabajadore.puntaje_competencias | number:2}}</td>
			</tr>
			<tr>
				<td style="background-color:#CED8F6;color:#2E2E2E;"><b>Puntaje Objetivos</b></td>
				<td>{{formulario.EvaluacionesTrabajadore.puntaje_objetivos | number:2}}</td>
			</tr>
			<tr>
				<td style="background-color:#CED8F6;color:#2E2E2E;"><b>Puntaje Ponderado</b></td>
				<td>{{formulario.EvaluacionesTrabajadore.puntaje_ponderado | number:2}}</td>
			</tr>
			<tr>
				<td style="background-color:#CED8F6;color:#2E2E2E;"><b>Situación Desempeño</b></td>
				<td><b>{{situacionDesemepeno}}</b></td>
			</tr>
		</table>
		<label>&nbsp;</label>
		<!-- paso Competencias -->
		<!-- Competencias Generales -->								
		<!-- paso Objetivos -->
		<!-- paso Dialogo se imprime posterior al dialogo con colaborador -->
		<p>
			<b>Comentarios del Evaluador </b>
		</p>
		<table ng-repeat="dialogo in dialogos" cellpadding="3" border="1" style="width:100%;">
			<tr style="background-color:#CED8F6;color:#2E2E2E"> 
				<td>
					<b>{{dialogo.nombre}}</b>
				</td> 
			</tr>
			<tr>
				<td>
					{{formulario.EvaluacionesDialogo[$index].comentario}}
				</td>
			</tr>
		</table>
		<label>&nbsp;</label>
		<p>
			<b>Comentarios del Colaborador Evaluado </b>
		</p>
		<table border="1" cellpadding="3" style="width:100%">											
			<tr>
				<td>
					<p>{{formulario.EvaluacionesTrabajadore.comentario_trabajador}}</p>
				</td>
			</tr>
		</table>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		
		<table style="width:100%;" cellpadding="0" cellspacing="10">
			<tr>
				<td width="50%" align="center">						
					<div style="width:80%;border-top:1px solid black; margin: auto"><b>{{trabajador.nombre}}</b></div>
				</td>
				<td width="50%" align="center">
					<div style="width:80%;border-top:1px solid black; margin: auto"><b>{{trabajador.jefatura}}</b></div>
				</td>
			</tr>
		</table>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<?php 
			setlocale(LC_TIME, 'es_ES.UTF-8');
			echo ucfirst( mb_strtolower( strftime("%A, %d de %B de %Y") , 'UTF-8') ).'.';
		?>
	</div>	
</div>
