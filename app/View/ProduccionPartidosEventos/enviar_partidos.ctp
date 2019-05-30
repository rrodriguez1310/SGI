<style>
	input {margin-top: 0px;}
	.ta-editor {
	   min-height: 170px !important;
	   height: 170px !important;	   
	   font-family:arial,sans-serif;
	   color:#0070c0;
	}
	.ta-scroll-window > .ta-bind {min-height: 168px !important;}
</style>
<div ng-controller="ListaEventos" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		
		<form class="form-horizontal" name="fechaAdd" novalidate>
			
			<div class="col-sm-12"><h4>Datos de Fecha</h4></div>

			<div class="form-group" ng-class="{ 'has-error': !fechaAdd.Campeonato.$valid }" >
				<label class="col-md-2 control-label"> Campeonato</label>
				<div class="col-md-8 sube">
					<ui-select ng-model="formFecha.ProduccionPartidosEvento.campeonato_id" name="Campeonato" theme="select2" required> 
						<ui-select-match placeholder="">
							{{$select.selected.nombre}}
						</ui-select-match>
						<ui-select-choices repeat="campeonato.id as campeonato in campeonatos | filter: $select.search">
							<div ng-bind-html="campeonato.nombre | highlight: $select.search"></div>
						</ui-select-choices>
					</ui-select>
				</div>
			</div>
			<div class="form-group" ng-class="{ 'has-error': !fechaAdd.Categoria.$valid }">
				<label class="col-md-2 control-label"> Categoria</label>
				<div class="col-md-8 sube">
					<ui-select ng-model="formFecha.ProduccionPartidosEvento.campeonatos_categoria_id" id="categoria" name="Categoria" theme="select2" ng-required="(categorias.length>0)">
						<ui-select-match placeholder="">
							{{$select.selected.nombre}}
						</ui-select-match>
						<ui-select-choices repeat="categoria.id as categoria in categorias | filter: $select.search">
							<div ng-bind-html="categoria.nombre | highlight: $select.search"></div>
						</ui-select-choices>
					</ui-select>
				</div>
			</div>
			<div class="form-group" ng-class="{ 'has-error': !fechaAdd.Subcategoria.$valid }">
				<label class="col-md-2 control-label"> Subcategoria</label>
				<div class="col-md-8 sube">
					<ui-select ng-model="formFecha.ProduccionPartidosEvento.campeonatos_subcategoria_id" id="subcategoria" name="Subcategoria" theme="select2" ng-required="(subcategorias.length>0)"> 
						<ui-select-match placeholder="">
							{{$select.selected.nombre}}
						</ui-select-match>
						<ui-select-choices repeat="subcategoria.id as subcategoria in subcategorias | filter: $select.search">
							<div ng-bind-html="subcategoria.nombre | highlight: $select.search"></div>
						</ui-select-choices>
					</ui-select>
				</div>
			</div>
			<hr>

			<div class="col-sm-12"><h4>Datos de Correo</h4></div>
			<div class="form-group" ng-class="{ 'has-error': !fechaAdd.Formato.$valid }">
				<label class="col-md-2 control-label"> Formato Correo</label>
				<div class="col-md-8 sube">
					<ui-select ng-model="formFecha.Email.formato" name="Formato" theme="select2" required>
						<ui-select-match placeholder="">
							{{$select.selected.nombre}}
						</ui-select-match>
						<ui-select-choices repeat="formato.id as formato in formatoCorreos | filter: $select.search">
							<div ng-bind-html="formato.nombre | highlight: $select.search"></div>
						</ui-select-choices>
					</ui-select>
				</div>
			</div>

			<div class="form-group" ng-class="{ 'has-error': !fechaAdd.Destinatarios.$valid }">
				<label class="col-md-2 control-label"> Lista Destinatarios</label>
				<div class="col-md-8 sube">
					<ui-select ng-model="formFecha.Email.lista" name="Destinatarios" theme="select2" required>
						<ui-select-match placeholder="">
							{{$select.selected.nombre}}
						</ui-select-match>
						<ui-select-choices repeat="destino.id as destino in destinatarios | filter: $select.search">
							<div ng-bind-html="destino.nombre | highlight: $select.search"></div>
						</ui-select-choices>
					</ui-select>
				</div>
			</div>

			<div class="form-group sube" ng-class="{ 'has-error': !fechaAdd.Asunto.$valid }">
				<label class="col-md-2 control-label" for="Asunto">Asunto</label>
				<div class="col-md-8">
					<input class="form-control sube" name="Asunto" ng-model="formFecha.Email.asunto" maxlength="140" required />
				</div>
				<p>&nbsp;</p>
			</div>
	
			<div class="form-group sube" ng-class="{ 'has-error': !fechaAdd.Comentarios.$valid }">
				<label class="col-md-2 control-label" for="Comentarios"> Mensaje</label>
				<div class="col-md-8">
					<div name="Comentarios" text-angular ng-model="formFecha.comentarios" required></div>	
				</div>
				<p>&nbsp;</p>
			</div>

			<div class="form-group"  ng-class="{ 'has-error': !fechaAdd.Filtro.$valid }">
				<label class="col-md-2 control-label" for="filtroPartidos" style="margin-top:5px"> Filtro </label>
				<div class="col-md-8 baja">				
					<label ng-show="listaTodos">
						<input type="radio"  name="Filtro" value="0" ng-model="formFecha.filtro" required> Todos
					</label>
					<label ng-class="{ 'has-error': !fechaAdd.Filtro.$valid }">
						<input type="radio" name="Filtro"  value="1" ng-model="formFecha.filtro" required> Vivo
					</label>
					<label ng-class="{ 'has-error': !fechaAdd.Filtro.$valid }">
						<input type="radio"  name="Filtro" value="2" ng-model="formFecha.filtro" required> Radio
					</label>
				</div>
			</div>

			<div ui-grid="gridOptions2" ui-grid-selection class="grid" style="height:280px" ui-grid-auto-resize ui-grid-resize-columns></div>

		</form>

		<div class="modal-footer">
        <button type="button" class="btn btn-primary btn-lg" ng-disabled="!fechaAdd.$valid||formFecha.ProduccionPartidosEventos.length==0||deshabilitaBtn" ng-click="enviarCorreos()"><i class="fa fa-paper-plane"></i> Enviar</button>
    	</div>
		
		<div id="plantilla" class="hide">
			<div style="width:100%;font-size:75%">
				<div><label style="font-size:15px"><b>{{tituloDocumento | uppercase}}</b></label></div>
				<div nobr="true">
					<table width="100%" style="border-spacing: 0px 7px;border-collapse: separate;">
						<tr ng-repeat="partidos in partidosFecha" nobr="true">
							<td width="50%" cellspacing="7" style="margin: 1em;vertical-align: top;" ng-style="{'padding': ($index%2==0) ? '7px 7px 7px 0px' : '7px 0px 7px 7px'}" ng-repeat="partido in partidos" nobr="true">
								<div nobr="true">
									<table width="100%">
										<tr><td align="left" style="font-size:9px;"><b><i>{{partido.titulo_partido | uppercase}}</i></b></td></tr>
										<tr><td align="left" style="font-size:9px;"><b><i>{{partido.subtitulo_partido}}</i></b></td></tr>
										<tr><td align="left" style="font-size:9px"><i>{{partido.equipos | uppercase}}</i></td></tr>
										<tr><td align="left" style="font-size:3px"></td></tr>
									</table>
									<table border="1">
									<tr><td>
										<table width="100%" style="font-size:8px;padding:0px 3px">
											<tr>
												<td width="33%" align="right" ><b>INICIO TX</b></td>
												<td width="67%" align="left">
												<b>{{partido.hora_transmision}} HRS.</b>
												</td>
											</tr>
											<tr>
												<td width="33%" align="right" ><b>INICIO PARTIDO</b></td>
												<td align="left">
													<b>{{ (partido.hora_partido) ? partido.hora_partido + ' HRS.' : '' }}</b>
												</td>
											</tr>
											<tr>
												<td width="33%" align="right" ><b>FIN APROX. TX</b></td>
												<td align="left">
													<b>{{partido.hora_termino_transmision}} HRS.</b>
												</td>
											</tr>

											<tr>
												<td width="33%" align="right" ><b>ESTADIO</b></td>
												<td align="left">
													{{partido.estadio | uppercase}}
												</td>
											</tr>
											<!--tr>
												<td width="33%" align="right" ><b>LUGAR</b></td>
												<td align="left">
													{{partido.ciudad | uppercase}}
												</td> 
											</tr-->
											<tr >
												<td width="33%" align="right" ><b>MÓVIL TX</b></td>
												<td align="left">
													{{partido.movil_transmision | uppercase}} 
												</td>
											</tr>

											<tr>
												<td width="33%" align="right" ><b>COMENTARIOS</b></td>
												<td align="left">
													{{partido.comentarios | uppercase}}
												</td>
											</tr>
											<tr>
												<td width="33%" align="right" ><b>CONDUCCIÓN - RELATO</b></td>
												<td align="left">
													{{partido.conduccion_relato | uppercase}}
												</td>
											</tr>
											<tr>
												<td width="33%" align="right" ><b>REPORTERO</b></td>
												<td align="left">
													{{partido.reportero | uppercase}}
												</td>
											</tr>

											<tr>
												<td width="33%" align="right" ><b>DIRECCIÓN</b></td>
												<td align="left">
													{{partido.direccion | uppercase}}
												</td>
											</tr>
											<tr>
												<td width="33%" align="right" ><b>PRODUCCIÓN</b></td>
												<td align="left">
													{{partido.produccion | uppercase}}
												</td>
											</tr>
											<tr>
												<td width="33%" align="right" ><b>ASIST. DIRECCIÓN</b></td>
												<td align="left">
													{{partido.asist_direccion | uppercase}}
												</td>
											</tr>
											<tr >
												<td width="33%" align="right" ><b>TRACK VISION CDF</b></td>
												<td align="left">
													{{partido.operador_trackvision | uppercase}}
												</td>
											</tr>
											<tr >
												<td width="33%" align="right" ><b>COORD. PERIODÍSTICO</b></td>
												<td align="left">
													{{partido.coordinador_periodistico | uppercase}}
												</td>
											</tr>
											<tr>
												<td width="33%" align="right" ><b>PRODUCCIÓN CDF</b></td>
												<td align="left">
													{{(partido.asist_productor_cdf!='-' && partido.produccion_cdf!='-')? partido.produccion_cdf + ' - ' + partido.asist_productor_cdf : ( partido.asist_productor_cdf=='-' )? partido.produccion_cdf : ((partido.produccion_cdf=='-')? partido.asist_productor_cdf : '-') | uppercase}}
												</td>
											</tr>
										</table>	
									</td></tr>
									</table>
									<table width="100%" style="font-size:8px;" nobr="true">
											<tr><td align="left" style="font-size:3px"></td></tr>
											<tr>
												<td width="33%" align="right"><b>TERNO</b></td>
												<td align="left">
													<b>{{partido.terno | uppercase}}</b>
												</td>
											</tr>
											<tr>
												<td width="33%" align="right"><b>CAMISA</b></td>
												<td align="left">
													<b>{{partido.camisa | uppercase}}</b>
												</td>
											</tr>
											<tr>
												<td width="33%" align="right"><b>CORBATA</b></td>
												<td align="left">
													<b>{{partido.corbata | uppercase}}</b>
												</td>
											</tr>
									</table>
								</div>
							</td>
						</tr>
					</table>
				</div>				
			</div>	<!-- outer -->
		</div>
	</div>
</div>

<?php

	echo $this->Html->css("angular/text-angular/textAngular");

	echo $this->Html->script(array(
		'angularjs/controladores/app',			
		'angularjs/servicios/produccionPartidos/produccionPartidosEventos',		
		'angularjs/modulos/text-angular/textAngular.min',
		'angularjs/modulos/text-angular/textAngular-rangy.min',
		'angularjs/modulos/text-angular/textAngular-sanitize.min',		
		'angularjs/controladores/produccionPartidos/produccionPartidosEventos'
	));
?>