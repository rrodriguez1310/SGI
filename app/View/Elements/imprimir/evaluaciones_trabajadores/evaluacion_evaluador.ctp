<div compile="plantillaEvaluador" id="plantillaEvaluador"  ng-cloak>
	<label style="width:100%;text-align:center;font-size:14px">
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
		<!-- paso Competencias -->				
		<p><b>1.  {{evaluacionCompetencias}}</b></p>
		<table border="1" cellpadding="3" style="width:100%">		
			<tbody ng-repeat="competencia in competencias">
				<tr ng-if="!!competencia.grupos_competencia">
					<td width="75%" style="background-color:#CED8F6;color:#2E2E2E;" width="25%"><b>{{competencia.grupos_competencia}}</b></td>
					<td align="center" style="background-color:#CED8F6;color:#2E2E2E;" width="25%"> 
						<b>Nivel de Logro</b>
					</td>
				</tr>
				<tr>
					<td width="75%">{{competencia.nombre}}</td>
					<td width="25%" align="center">{{nivelLogros1Nombre[formulario.EvaluacionesCompetencia[$index].niveles_logro_id]}}</td>
				</tr>
			</tbody>
		</table>
		<!-- Competencias Generales -->						
		<table border="1" cellpadding="3" style="width:100%">
			<tr style="background-color:#CED8F6;color:#2E2E2E;">
				<td width="75%" style="text-transform:uppercase">
					<b>{{tituloCompetenciaGenerales}}</b>
				</td>
				<td align="center" width="25%">
					<b>Nivel de Logro</b>
				</td>												
			</tr>
			<tr ng-repeat="competenciaTransversal in competenciasGenerales">
				<td>{{competenciaTransversal.nombre}}</td>
				<td align="center">{{nivelLogros1Nombre[formulario.EvaluacionesCompetenciasGenerale[$index].niveles_logro_id]}}</td>
			</tr>
			<tfoot>
				<tr style="background-color:#CED8F6;color:#2E2E2E;">
					<td><b>PUNTAJE</b></td>
					<td align="center"><b>{{formulario.EvaluacionesTrabajadore.puntaje_competencias | number:2}}</b></td>
				</tr>
			</tfoot>
		</table>
		
		<!-- paso Objetivos -->
		<p><b> 2. {{evaluacionObjetivos}}</b></p>
		<!-- Objetivos-->

		<table border="1" cellpadding="3" style="width:100%">
			<tr style="background-color:#CED8F6;color:#2E2E2E;">
				<td width="70%" colspan="2"><b>Objetivos Clave de Desempeño (OCD)</b></td> 
				<td width="15%" style="text-align:center"><b>Puntaje</b></td> 
				<td width="15%" style="text-align:center"><b>Ponderación</b></td> 
			</tr>
			<tr ng-repeat="objetivo in porcObjetivos">
				<td width="15%" style="background-color:#D8D8D8;color:#2E2E2E;" align="center">
					<b>{{objetivo.nombre}}</b>
				</td>
				<td width="55%">
					{{formulario.EvaluacionesObjetivo[$index].descripcion_objetivo}}
				</td>
				<td style="text-align:center" width="15%">
					{{formulario.EvaluacionesObjetivo[$index].puntaje_modificado}}
					<!--{{nivelLogros2Nombre[formulario.EvaluacionesObjetivo[$index].niveles_logro_id]}}-->
				</td>
				<td style="text-align:center" width="15%">
					{{formulario.EvaluacionesObjetivo[$index].porcentaje_ponderacion}}%
					<!--{{nivelLogros2Nombre[formulario.EvaluacionesObjetivo[$index].niveles_logro_id]}}-->
				</td>
			</tr>
			<tr style="background-color:#CED8F6;color:#2E2E2E;">
				<td width="70%" colspan="2"><b>PUNTAJE</b></td> 
				<td style="text-align:center" width="15%">
					<b>{{formulario.EvaluacionesTrabajadore.puntaje_objetivos | number:2}}</b>
				</td>
				<td style="text-align:center" width="15%">
					<b>100%</b>
				</td>
			</tr>
		</table>	

		<!-- paso Retroalimentacion -->
		<p><b> 3. {{evaluacionDialogo}} </b></p>
		<!-- Objetivos-->
		<table border="1" cellpadding="3" style="width:100%" ng-repeat="dialogo in dialogos">
			<tr style="background-color:#CED8F6;color:#2E2E2E;"> 
				<td><b>{{dialogo.nombre}}</b></td> 
			</tr>
			<tr>
				<td>{{formulario.EvaluacionesDialogo[$index].comentario}}</td>
			</tr>
		</table>
	</div>	
</div>
