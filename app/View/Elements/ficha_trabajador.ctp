<div id="ficha" hidden>
	<table>
		<tr>
			<td style="vertical-align: middle">
				<img ng-src="{{ host }}img/cdf_pdf.jpg" width="100">		
			</td>
			<td>
				<p>
				</p>
				<p align="center"><u><b>FICHA DE TRABAJADOR</b></u></p>			
			</td>
			<td align="right">
				<img ng-src="{{ host }}files/trabajadores/{{ trabajador.Trabajadore.foto }}" width="80" height="100"></span>
			</td>
		</tr>
	</table>
	<ol>
		<li><u><b>Antecedentes Personales</b></u></li>
	</ol>
	<table style="width: 100%;" border="solid">
		<tr>
			<td width="28%">Rut</td>
			<td width="2%">:</td>
			<td width="70%">{{ trabajador.Trabajadore.rut}}</td>						
		</tr>
		<tr>
			<td>Nombres</td>
			<td>:</td>
			<td>{{ trabajador.Trabajadore.nombre | uppercase }}</td>						
		</tr>
		<tr>
			<td>Apellidos</td>
			<td>:</td>
			<td>{{ (trabajador.Trabajadore.apellido_paterno+" "+trabajador.Trabajadore.apellido_materno) | uppercase }}</td>						
		</tr>
		<tr>
			<td>Fecha de Nacimiento</td>
			<td>:</td>
			<td>{{ trabajador.Trabajadore.fecha_nacimiento | date: "dd/MM/yyyy" }}</td>						
		</tr>
		<tr>
			<td>Domicilio - Comuna</td>
			<td>:</td>
			<td>{{ trabajador.Trabajadore.direccion | uppercase  }} {{ trabajador.Comuna.comuna_nombre | uppercase }} </td>
		</tr>
		<tr>
			<td>Estado civil</td>
			<td>:</td>
			<td>{{ trabajador.EstadosCivile.nombre | uppercase }}</td>						
		</tr>
		<tr>
			<td>Nacionalidad</td>
			<td>:</td>
			<td>{{ trabajador.Nacionalidade.nombre | uppercase }}</td>						
		</tr>
		<tr>
			<td>Estudios</td>
			<td>:</td>
			<td>{{ trabajador.NivelEducacion.nombre | uppercase }}</td>						
		</tr>
		<tr>
			<td>Titulo</td>
			<td>:</td>
			<td>{{ trabajador.Trabajadore.estudios_titulo | uppercase }}</td>						
		</tr>
		<tr>
			<td>Telefonos</td>
			<td>:</td>
			<td>
				<ul style="list-style-type: none; margin: 0; padding: 0;">
					<li ng-if="trabajador.Trabajadore.telefono_movil">Movil : {{ trabajador.Trabajadore.telefono_movil }}</li>
					<li ng-if="trabajador.Trabajadore.telefono_particular">Particular : {{ trabajador.Trabajadore.telefono_particular }}</li>
					<li ng-if="trabajador.Trabajadore.telefono_emergencia">Emergencia : {{ trabajador.Trabajadore.telefono_emergencia }}</li>
				</ul>
			</td>						
		</tr>
		<tr>
			<td>Nombre del Banco</td>
			<td>:</td>
			<td>{{ trabajador["CuentasCorriente"][0]["Banco"]["nombre"] | uppercase }}</td>						
		</tr>
		<tr>
			<td>Tipo de cuenta</td>
			<td>:</td>
			<td>{{ trabajador["CuentasCorriente"][0]["TiposCuentaBanco"]["nombre"] | uppercase }}</td>
		</tr>
		<tr>
			<td>Nro. Cuenta Bancaria</td>
			<td>:</td>
			<td>{{ trabajador["CuentasCorriente"][0]["cuenta"] }}</td>
		</tr>
	</table>
	<ol>
		<li value="2"><u><b>Antecedentes Previsionales</b></u></li>
	</ol>
	<table style="width: 100%;" border="solid">
		<tr>
			<td width="28%">A.F.P</td>
			<td width="2%">:</td>
			<td width="70%">{{ trabajador.SistemaPensione.nombre | uppercase }}</td>						
		</tr>
		<tr>
			<td>Previsión</td>
			<td>:</td>
			<td>{{ trabajador.SistemaPrevisione.nombre | uppercase }}</td>						
		</tr>
		<tr>
			<td>Moneda Plan</td>
			<td>:</td>
			<td>{{ monedas[trabajador.Trabajadore.sistema_salud_moneda] | uppercase }}</td>					
		</tr>
		<tr>
			<td>Valor del Plan</td>
			<td>:</td>
			<td>{{ trabajador.Trabajadore.sistema_salud_valor }}</td>						
		</tr>
	</table>
	<ol>
		<li value="3"><u><b>Información Laboral</b></u></li>
	</ol>
	<table style="width: 100%;" border="solid">
		<tr>
			<td width="28%">Fecha Ingreso</td>
			<td width="2%">:</td>
			<td width="70%">{{ trabajador.Trabajadore.fecha_ingreso | date : "dd/MM/yyyy" }}</td>						
		</tr>
		<tr>
			<td>Tipo Contrato</td>
			<td align="center">:</td>
			<td>{{ trabajador.TipoContrato.nombre | uppercase }}</td>						
		</tr>
		<tr>
			<td>Sueldo Base</td>
			<td align="center">:</td>
			<td></td>						
		</tr>
		<tr>
			<td>Gerencia</td>
			<td align="center">:</td>
			<td>{{ trabajador.Cargo.Area.Gerencia.nombre | uppercase }}</td>						
		</tr>
		<tr>
			<td>Area</td>
			<td align="center">:</td>
			<td>{{ trabajador.Cargo.Area.nombre | uppercase }}</td>						
		</tr>
		<tr>
			<td>Cargo</td>
			<td align="center">:</td>
			<td>{{ trabajador.Cargo.nombre | uppercase }}</td>						
		</tr>
		<tr>
			<td>Dimensión</td>
			<td align="center">:</td>
			<td>{{ trabajador.Dimensione.codigo }} {{ trabajador.Dimensione.nombre | uppercase }}</td>
		</tr>
		<tr>
			<td>Jefe</td>
			<td align="center">:</td>
			<td>{{ trabajador.Jefe.Trabajadore.nombre+" "+trabajador.Jefe.Trabajadore.apellido_paterno+" "+trabajador.Jefe.Trabajadore.apellido_materno | uppercase}}</td>						
		</tr>
		<tr>
			<td>Autoriza</td>
			<td align="center">:</td>
			<td></td>						
		</tr>
		<tr>
			<td>Oficina</td>
			<td align="center">:</td>
			<td>{{ trabajador.Localizacione.nombre | uppercase }}</td>						
		</tr>
		<tr>
			<td>Correo Electronico</td>
			<td align="center">:</td>
			<td>{{ trabajador.Trabajadore.email | uppercase }}</td>						
		</tr>
		<tr>
			<td>Tipo de Jornada</td>
			<td align="center">:</td>
			<td>{{ trabajador.Horario.nombre | uppercase }}</td>						
		</tr>
	</table>
</div>