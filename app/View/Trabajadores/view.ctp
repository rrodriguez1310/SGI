<div ng-controller="mainTrabajadore">
	<div ng-controller="view">	
		<div class="container">
			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1 toppad" >    
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-4">
								<h3 class="panel-title"><?php echo $trabajador["Trabajadore"]["nombre"]." ".$trabajador["Trabajadore"]["apellido_paterno"]." ".$trabajador["Trabajadore"]["apellido_materno"] ?></h3>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<br/>				 
							<div class="col-md-3 col-lg-3 " align="center">
								<div class="thumbnail">
									<img id="fotoUsuario" class="img-circle" alt="Usuario" src="<?php echo $this -> webroot . 'files' . DS . 'trabajadores' . DS . $trabajador["Trabajadore"]["foto"]; ?>">
								</div>
							</div>
							<div class=" col-md-9 col-lg-9 ">
								<div class="panel-group" id="accordion">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
													Datos Personales
												</a>
											</h4>
										</div>
										<div id="collapseOne" class="panel-collapse collapse">
											<div class="panel-body">				 
												<div class="row">
													<p class="col-md-4 text-right"><b>Rut</b></p>
													<p class="col-md-8">
														<?php echo h($trabajador["Trabajadore"]["rut"]); ?>
													</p>			         	
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Nombres</b></p>
													<p class="col-md-8">
														<?php echo h($trabajador["Trabajadore"]["nombre"]); ?>	
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Apellido Paterno</b></p>
													<p class="col-md-8">
														<?php echo h($trabajador["Trabajadore"]["apellido_paterno"]); ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Apellido Materno</b></p>
													<p class="col-md-8">
														<?php echo h($trabajador["Trabajadore"]["apellido_materno"]); ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Fecha Nacimiento</b></p>
													<p class="col-md-8">
														<?php echo h($trabajador["Trabajadore"]["fecha_nacimiento"]); ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Nacionalidad</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Nacionalidade"]["nombre"]; ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Sexo</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Trabajadore"]["sexo"]; ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Estado Civil</b></p>
													<p class="col-md-8">
														<?php echo empty($trabajador["EstadosCivile"]["nombre"]) ? "" : ucfirst($trabajador["EstadosCivile"]["nombre"]); ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Dirección</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Trabajadore"]["direccion"] ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Comuna</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Comuna"]["comuna_nombre"] ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Telefono Fijo</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Trabajadore"]["telefono_particular"] ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Telefono Movil</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Trabajadore"]["telefono_movil"] ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Telefono Emergencia</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Trabajadore"]["telefono_emergencia"] ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Sistema Pensión</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["SistemaPensione"]["nombre"] ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Sistema Salud</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["SistemaPrevisione"]["nombre"] ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Tipo moneda plan de salud</b></p>
													<p class="col-md-8">
														<?php echo (isset($trabajador["Trabajadore"]["sistema_salud_moneda"]) ? $tipoMonedas[$trabajador["Trabajadore"]["sistema_salud_moneda"]] : "" )?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Valor plan de salud</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Trabajadore"]["sistema_salud_valor"] ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Nivel de educación</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["NivelEducacion"]["nombre"] ?>
													</p>
												</div> 
												<div class="row">
													<p class="col-md-4 text-right"><b>Casa de estudios</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Trabajadore"]["estudios_institucion"] ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Titulo</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Trabajadore"]["estudios_titulo"] ?>
													</p>
												</div>           
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
													Empresa
												</a>
											</h4>
										</div>
										<div id="collapseTwo" class="panel-collapse collapse">
											<div class="panel-body"> 
												<div class="row">
													<p class="col-md-4 text-right"><b>Fecha Ingreso</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Trabajadore"]["fecha_ingreso"] ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Fecha Indefinido</b></p>
													<p class="col-md-8">
														<?php echo empty($trabajador["Trabajadore"]["fecha_indefinido"]) ? '' : date('d/m/Y', strtotime($trabajador["Trabajadore"]["fecha_indefinido"])) ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Gerencia</b></p>
													<p class="col-md-8">
														<?php echo ucfirst($trabajador["Gerencia"]["nombre"]); ?>
													</p>
												</div>  
												<div class="row">
													<p class="col-md-4 text-right"><b>Área</b></p>
													<p class="col-md-8">
														<?php echo ucfirst($trabajador["Area"]["nombre"]); ?>
													</p>
												</div> 
												<div class="row">
													<p class="col-md-4 text-right"><b>Cargo</b></p>
													<p class="col-md-8">
														<?php echo ucfirst($trabajador["Cargo"]["nombre"]); ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Jefe</b></p>
													<p class="col-md-8">
														<?php echo isset($trabajador["Jefe"]["Trabajadore"]["nombre"]) ? ucfirst($trabajador["Jefe"]["Trabajadore"]["nombre"]." ".$trabajador["Jefe"]["Trabajadore"]["apellido_paterno"]." ".$trabajador["Jefe"]["Trabajadore"]["apellido_materno"]) : ""; ?>
													</p>
												</div> 
												<div class="row">
													<p class="col-md-4 text-right"><b>Lugar Trabajo</b></p>
													<p class="col-md-8">
														<?php echo ucfirst($trabajador["Localizacione"]["nombre"]); ?>
													</p>
												</div>		      
												<div class="row">
													<p class="col-md-4 text-right"><b>Correo Electronico</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Trabajadore"]["email"]; ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Anexo</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Trabajadore"]["anexo"]; ?>
													</p>
												</div>	
												<div class="row">
													<p class="col-md-4 text-right"><b>Horario</b></p>
													<p class="col-md-8">
														<?php echo $trabajador["Horario"]["nombre"]; ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Tipo Contrato</b></p>
													<p class="col-md-8">
														<?php echo mb_strtoupper($trabajador["TipoContrato"]["nombre"]); ?>
													</p>
												</div>
												<div class="row">
													<p class="col-md-4 text-right"><b>Dimensión</b></p>
													<p class="col-md-8">
														<td><?php echo (isset($trabajador["Dimensione"]["codigo"]) ? mb_strtoupper($trabajador["Dimensione"]["codigo"]." - ".$trabajador["Dimensione"]["nombre"]) : "" ); ?></td>
													</p>
												</div>	
												<div class="row">
													<p class="col-md-4 text-right"><b>Estado</b></p>
													<p class="col-md-8">
														<?php echo mb_strtoupper($trabajador["Trabajadore"]["estado"]); ?>
													</p>
												</div>		
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Documentos</a>
											</h4>
										</div>
										<div id="collapseThree" class="panel-collapse collapse">
											<table class="table table-striped">
												<thead>
													<tr>
														<th class="col-md-2">Fecha doc.</th>
														<th class="col-md-2">Termino doc.</th>
														<th class="col-md-3">Tipo Documento</th>
														<th class="col-md-5">Descripcion</th>
														<th style="width: 7%"></th>										
													</tr>	
												</thead>
												<tbody id="adjuntos">
													<?php if(!empty($documentos)): ?>
														<?php foreach($documentos as $documento ):?>	
															<tr class="<?php echo $documento["Documento"]["id"]; ?>">
																<td><?php echo date('d/m/Y', strtotime($documento["Documento"]["fecha_inicial"])); ?></td>
																<td><?php echo empty($documento["Documento"]["fecha_final"]) ? "" : date('d/m/Y', strtotime($documento["Documento"]["fecha_final"])); ?></td>
																<td><?php echo $documento["TiposDocumento"]["nombre"]?></td>
																<td><?php echo $documento["Documento"]["descripcion"]?></td>
																<td>
																	<?php if(!empty($documento["Documento"]["ruta"])): ?>
																		<a download class="btn-sm btn btn-primary tool" href="<?php echo $this->webroot.'files'. DS .'trabajadores'. DS .$documento["Documento"]["ruta"]?>" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fa fa-download"></i></a>
																	<?php endif; ?>
																</td>
															</tr>
														<?php endforeach; ?>
													<?php else: ?>
														<tr class="danger" id="sinAdjuntos">
															<td colspan="4" class="text-center"><h5>No contiene archivos adjuntos!</h5></td>
														</tr>
													<?php endif; ?>	
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<a href="javascript:window.history.back()" class="btn btn-default btn-lg volver"><i class="fa fa-mail-reply-all"></i> Volver</a>
						<?php echo $this->Form->end(); ?>
					</div> 
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script(array(
	'angularjs/controladores/app', 
	'angularjs/controladores/trabajadores',
	'angularjs/directivas/html-bind-compile',
	'angularjs/angular-locale_es-cl',
	'select2.min',
	'bootstrap-datepicker'
));
?>