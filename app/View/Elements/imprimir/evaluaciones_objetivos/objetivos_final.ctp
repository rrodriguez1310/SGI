<div compile="plantillaFinal" id="plantillaFinal">
	<label style="width:100%;text-align:center">
		<center><b>OBJETIVOS CLAVE DE DESEMPEÑO {{anioObjetivo}}</b></center>
	</label>
	<div style="font-size:11px">
		<p><b>DATOS COLABORADOR</b></p>
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
				<td style="background-color:#CED8F6;color:#2E2E2E;"><b>Familia de Cargos</b></td>
				<td>{{trabajador.familia_cargo}}</td>
			</tr>
			<tr>
				<td style="background-color:#CED8F6;color:#2E2E2E;"><b>Nombre Jefatura</b></td>
				<td>{{trabajador.jefatura}}</td>
			</tr>
		</table>
		<label>&nbsp;</label>
		<p>
			<b>OCD {{anioObjetivo}}</b>
		</p>
		<table cellpadding="3" border="1" style="width:100%;">
			<thead>
				<tr style="background-color:#CED8F6;color:#2E2E2E">
					<th width="15%"></th>
					<th align="center" width="35%">Descripción</th>
					<th align="center" width="20%">Indicador</th>
					<th align="center" width="15%">Fecha Límite</th>
					<th align="center" width="15%">Ponderación</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="objetivo in objetivos" ng-if="objetivo.estado==1">
					<td width="15%" align="center"><b>{{objetivo.nombre_objetivo}}</b></td>
					<td width="35%" align="left">{{objetivo.descripcion_objetivo}}</td>
					<td width="20%" align="right">
					{{(formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id==1)? simboloUnidad[$index] :''}} 
					{{formulario.EvaluacionesObjetivo[$index].indicador | number:1}} 
					{{(formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id>1)? simboloUnidad[$index] :''}}
					</td>
					<td width="15%" align="center">{{objetivo.fecha_limite_objetivo | date:'dd-MM-yyyy'}}</td>
					<td width="15%" align="center">{{objetivo.porcentaje_ponderacion}}%</td>
				</tr>
			</tbody>
		</table>
		<label>&nbsp;</label>
		<p>&nbsp;</p>
		<p>&nbsp;</p>		
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<?php 
			setlocale(LC_TIME, 'es_ES.UTF-8');
			echo ucfirst( mb_strtolower( strftime("%A, %d de %B de %Y") , 'UTF-8') ).'.';
		?>
	</div>	
</div>
