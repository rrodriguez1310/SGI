<style>
.container{ width: 1350px; }
input {margin-top: 0px;}
</style>


<?php

	$sumaDecimales = 0;
	$contadorAprobados = "";
	$totalProductos =  count($ordenCompra["ComprasProducto"]);
	$desabilitaBotonAprobar = "";
	foreach($ordenCompra["ComprasProducto"] as $aprobados)
	{
		if($aprobados["estado"] == 2)
		{
			$contadorAprobados[] = $aprobados["estado"]; 
		}
	}

	if(!empty($contadorAprobados) && count($contadorAprobados) == $totalProductos)
	{
		$desabilitaBotonAprobar = "disabled";
	}

	$disableDos = "";
	$disableTres = "";
	if( $ordenCompra["ComprasProductosTotale"]["compras_estado_id"] == 2)
	{
		$disableDos = "disabled";
	}

	if( $ordenCompra["ComprasProductosTotale"]["compras_estado_id"] == 3 || $ordenCompra["ComprasProductosTotale"]["compras_estado_id"] == 5)
	{
		$disableTres = "disabled";
	}
?>
<?php if(!empty($perfilUsuario) && $perfilUsuario == "aprobadores"): ?>
	<div class="btn-group pull-right" role="group" aria-label="">
		<?php if($ordenCompra["ComprasProductosTotale"]["compras_estado_id"] != 4) :?>
		<a href="javascript:void(0)"  class="<?php echo $desabilitaBotonAprobar; ?> aprobar btn btn-success btn-mx <?php echo $disableDos; ?>"><i class="fa fa-thumbs-o-up"></i> Aprobar</a>
		<!--a href="<?php echo $this->Html->url(array("action"=>$aprobarCompra, $ordenCompra["ComprasProductosTotale"]["id"])); ?>"  class="btn btn-success btn-mx <?php echo $disableDos; ?>"><i class="fa fa-thumbs-o-up"></i> Aprobar</a-->
		<a href=""  data-toggle="modal" data-target="<?php echo $rechazarCompra; ?>" class="btn btn-danger btn-mx <?php echo $disableTres; ?>"><i class="fa fa-thumbs-o-down"></i> Rechazar</a>
		<?php endif; ?>
		<!--a href=""  class="btn btn-warning printer"><i class="fa fa-print"></i> Imprimir</a-->
	  	<a href="<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"aprobadores"))?>"  class="btn btn-info btn-mx"><i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
	</div>
<?php endif; ?>

<?php if(empty($perfilUsuario)): ?>
	<div class="btn-group pull-right" role="group" aria-label="">
		<!--a href=""  class="btn btn-warning printer"><i class="fa fa-print"></i> Imprimir</a-->
		<a href="<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"index"))?>"  class="btn btn-info btn-mx backLink"><i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
	</div>
<?php endif; ?>	

<form id="aprueba" name="form" method="Post" role="form" action="<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"aprobar_compra"))?>">	

	<?php if(!empty($perfilUsuario) && $perfilUsuario == "ingreso_sap"): ?>
		<div class="btn-group pull-right" role="group" aria-label="">

			<a id="enviar_compra_sap" href="#" class="btn btn-primary enviar_compra_sap" style="height:33px"> <i class="fa fa-share"></i> Enviar a sap
				<input type="submit" style="opacity:0; margin-top:-10px;margin-left:-100px;width:105px" class="sube">
			</a>

			<a id="ingresoSap" href="#"  class="btn btn-success btn-mx ingresoSap"> <i class="fa fa-thumbs-o-up"></i> Ingresar a sap</a>

			<!--a href=""  data-toggle="modal" data-target="#compras_rechazar_sap" class="btn btn-danger btn-mx"><i class="fa fa-thumbs-o-down"></i> Rechazar</a-->
			<a href=""  data-toggle="modal" data-target="<?php echo $rechazarCompra; ?>" class="rechazo_sap btn btn-danger btn-mx <?php echo $disableTres; ?>"><i class="fa fa-thumbs-o-down"></i>Rechazar</a>
			<!--a href=""  class="btn btn-warning printer"><i class="fa fa-print"></i> Imprimir</a-->
		  	<a href="<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"ingreso_sap"))?>"  class="btn btn-info btn-mx"><i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
		</div>
	<?php endif; ?>

	<br/>

	<div class="print">

		<h4>
			<?php 
				if(!empty($ordenCompra["TiposDocumento"]["nombre"]))
				{
					echo $ordenCompra["TiposDocumento"]["nombre"]; 
				}
				else
				{
					echo "Requerimiento de compra";
				}
			?>
		</h4>
		
		<p class="mayuscula">Titulo : <?php echo $ordenCompra["ComprasProductosTotale"]["titulo"]; ?></p>

		<p>
			<?php
				if(isset($ordenCompra["ComprasFactura"][0]["numero_documento"]))
				{
					echo '<strong>N° Documento: </strong>' .$ordenCompra["ComprasFactura"][0]["numero_documento"];
				}
			?>
		</p>

			<div class="col-md-12">
				<div class="row clearfix">
					<div class="col-md-4 column">
						<div class="panel panel-default">
		  				<!-- Default panel contents -->
		  					<div class="panel-heading"><Strong>Creador</Strong></div>
							<!-- List group -->
							<ul class="list-group">
		  						<li class="list-group-item " title="Creador">Creador: <span class="mayuscula"><?php echo $ordenCompra["User"]["nombre"]; ?></span></li>
		  						<li class="list-group-item list-group-item-success" title="Fecha creación">Fecha creación: <?php echo $ordenCompra["ComprasProductosTotale"]["created"]; ?></li>
		  						<li class="list-group-item" title="Estado">Estado:

										<span class="<?php echo $ordenCompra["ComprasEstado"]["clase"]?> tool" data-toggle="tooltip" data-placement="top" title="<?php echo $ordenCompra["ComprasEstado"]["estado"]?>"><?php echo$ordenCompra["ComprasEstado"]["estado"]?></span>
		  						</li>
		  						<li class="list-group-item ">
		  							Historial de cambio:
		  							</strong>
		  							<a class="cursor_pointer"  data-toggle="popover" data-content="
									<?php
											echo "<h5>Creador</h5>";
											echo '<p> Nombre: '.$ordenCompra["User"]["nombre"].'</p>';
											echo '<p>Fecha: '.$ordenCompra["ComprasProductosTotale"]["created"].'</p>';

											if(isset($ordenCompra["ComprasProductosTotale"]["aprobacion_rechazo"]))
											{	echo "<h5>Gerencia Aprobador</h5>";
												foreach(unserialize($ordenCompra["ComprasProductosTotale"]["aprobacion_rechazo"]) as $datos)
												{
													echo '<p> Nombre: '.$datos["UsuarioAprobador"].'</p>';
													echo '<p>Fecha: '.$datos["FechaAprobacion"].'</p>';
												}
											}
											
											if(isset($ordenCompra["ComprasProductosTotale"]["aprobacion_rechazo_sap"]))
											{	echo "<h5>Ingreso a SAP</h5>";
												foreach(unserialize($ordenCompra["ComprasProductosTotale"]["aprobacion_rechazo_sap"]) as $datos)
												{
													if(isset($datos["UsuarioAprobarSap"]))
													{
														echo '<p>Nombre: ' .$datos["UsuarioAprobarSap"] . '</p>';
														echo '<p>Fecha: ' .$datos["FechaAprobacion"] . '</p>';
													}

													if(isset($datos["UsuarioAprobador"]))
													{
														echo '<p>Nombre: ' .$datos["UsuarioAprobador"] . '</p>';
														echo '<p>Fecha: ' .$datos["FechaAprobacion"] . '</p>';
													}
												}
											}
											
											if(!empty($motivoRechazos))
											{
												echo "<p><strong>Detalle Rechazos</strong></p>";
												foreach($motivoRechazos as $motivoRechazo)
												{
													echo "<p>Fecha : " .date("d-m-Y", strtotime($motivoRechazo["Fecha"])) . "</p>";
													echo "<p>Nombre : " .$motivoRechazo["Usuario"] . "</p>";
													echo "<p>Motivo : " .$motivoRechazo["Motivo"] . "</p>";
													echo "<p>Producto : " .$motivoRechazo["Producto"] . "</p>";
												}
											}	
									?>
									" title="Código <?php echo $ordenCompra["ComprasProductosTotale"]["id"]; ?>" data-placement="bottom"><i class="fa fa-info-circle"></i></a>
									<!--
									<?php if(!empty($motivoRechazos)) : ?>
										<a class="cursor_pointer" data-toggle="popover" data-content="
											<p><strong>Detalle Rechazos</strong></p>
											<?php 
												foreach($motivoRechazos as $motivoRechazo)
												{
													echo "<p>Nombre : " .$motivoRechazo["Usuario"] . "</p>";
													echo "<p>Motivo : " .$motivoRechazo["Motivo"] . "</p>";
													echo "<p>Producto : " .$motivoRechazo["Producto"] . "</p>";
												}
											?>
										" title="Código <?php echo $ordenCompra["ComprasProductosTotale"]["id"]; ?>" data-placement="bottom"><i class="fa fa-times text-danger"></i></a>
		  							<?php endif; ?>
		  						-->
		  						</li>
							</ul>
						</div>
					</div>

					<div class="col-md-4 column">
						<div class="panel panel-default">
							<!-- Default panel contents -->
							<div class="panel-heading"><Strong>Información Impuesto</Strong></div>
							<!-- List group -->
							<ul class="list-group">
								<li class="list-group-item">
									<?php
										//pr($ordenCompra["ComprasProductosTotale"]["tipos_documento_id"]);
										if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 1 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 17 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 22)
										{
											echo "AFECTO";
										} 
										else if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 19 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 2 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 19 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 20 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 21)
										{
											echo "EXENTO";
										}
										elseif($ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 26)
										{
											echo "NOTA DE CREDITO";
										}
										else
										{
											echo "HONORARIOS";
										}

									?>
								</li>
								<li class="list-group-item">Tipo de cambio: <?php echo strtoupper($ordenCompra['ComprasProductosTotale']['tipo_cambio']); ?></li>
								<li class="list-group-item">Moneda: <?php echo strtoupper($ordenCompra["TiposMoneda"]["nombre"]); ?></li>
								<li class="list-group-item">Archivo:
									
									<?php 
										$archivos = array();
										$rutaFotosSerialize = @unserialize($ordenCompra["ComprasProductosTotale"]["adjunto"]);
										if($rutaFotosSerialize !== false)
										{
											foreach(unserialize($ordenCompra["ComprasProductosTotale"]["adjunto"]) as $rutaFotos)
											{	
												$archivos[] = $rutaFotos;
									?>	
												<a href="<?php echo $this->Html->url('/', true).'files'.DS.'orden_compra'.DS.$rutaFotos;?>" target="_blank">ver</a> - 
									<?php		
											}
										}
										else 
										{
											$archivos[] = $ordenCompra["ComprasProductosTotale"]["adjunto"];
									?>
											<a href="<?php echo $this->Html->url('/', true).'files'.DS.'orden_compra'.DS.$ordenCompra["ComprasProductosTotale"]["adjunto"];?>" target="_blank">ver</a>
									
									<?php 
										}
									?>
									<!--Archivo: <a href="<?php echo $this->Html->url('/', true).'files'.DS.'orden_compra'.DS.$ordenCompra["ComprasProductosTotale"]["adjunto"];?>" target="_blank">ver</a-->
								</li>
								<!--li class="list-group-item">
									<div>
										<label for="inputPassword3" class="control-label">Indicador SAP</label>
										<?php //echo $this->Form->input('Sap.IndicatorCode', array("id"=>"indicadores", "type"=>"select", "class"=>"form-control", "label"=>false));?>
									</div>
								</li-->
							</ul>
						</div>
					</div>

					<div class="col-md-4 column">
						
						<?php 
							//pr($ordenCompra);
							// CABECERA PRELIMINAR SAP
							// tipo documento
							if(isset($ordenCompra["ComprasProductosTotale"]["tipos_documento_id"]) && $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] != 1 && $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] != 26) {
								// factura proveedor (otros doc sgi)
								echo $this->Form->hidden('Sap.DocObjectCode', array("id"=>"DocObjectCode", "value"=> "18"));	

							} else if($ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 26) {
								// abono proveedor (sgi.nota de credito)
								echo $this->Form->hidden('Sap.DocObjectCode', array("id"=>"DocObjectCode", "value"=> "19"));

							} else { 
								// pedidods (sgi.orden compra)
								echo $this->Form->hidden('Sap.DocObjectCode', array("id"=>"DocObjectCode", "value"=> "22"));
							}

							echo $this->Form->hidden('Sap.Comments', array("id"=>"Comments", "value"=>$ordenCompra["ComprasProductosTotale"]["titulo"]));
							echo $this->Form->hidden('Sap.DocDate', array("id"=>"DocDate", "value"=> isset($ordenCompra["ComprasFactura"][0]["fecha_documento"]) ? $ordenCompra["ComprasFactura"][0]["fecha_documento"] : substr($ordenCompra["ComprasProductosTotale"]["created"],0,10)));
							echo $this->Form->hidden('Sap.TaxDate', array("id"=>"TaxDate", "value"=> isset($ordenCompra["ComprasFactura"][0]["fecha_documento"]) ? $ordenCompra["ComprasFactura"][0]["fecha_documento"] : substr($ordenCompra["ComprasProductosTotale"]["created"],0,10)));

							//prefijo documento
								switch ($ordenCompra["ComprasProductosTotale"]["tipos_documento_id"]) {
									case 17:
										$prefijoSap = 'FC';	
										break;
									case 19:
										$prefijoSap = 'FC';	
										break;
									case 18:
										$prefijoSap = 'BH';	
										break;
									case 20:
										$prefijoSap = 'BH';	
										break;
									case 26:
										$prefijoSap = 'CN';	
										break;
									case 27:
										$prefijoSap = 'DI';	
										break;
									default:
										$prefijoSap = '';
										break;
								}					
							echo $this->Form->hidden('Sap.FolioPrefixString', array("id"=>"FolioPrefixString", "value"=> $prefijoSap));

								switch ($ordenCompra["TiposMoneda"]["id"]) {
									case 1:
										$monedaSap = 'CLP';	
										break;
									case 2:
										$monedaSap = 'USD';	
										break;
									case 3:
										$monedaSap = 'EUR';	
										break;
									case 4:
										$monedaSap = 'GBP';	
										break;
									case 6:
										$monedaSap = 'UF';	
										break;
									default:
										$monedaSap = '';
										break;
								}

							echo $this->Form->hidden('Sap.DocCurrency', array("id"=>"DocCurrency", "value"=> $monedaSap));

							if(isset($ordenCompra["ComprasFactura"][0]["numero_documento"]))
								echo $this->Form->hidden('Sap.FolioNumber', array("id"=>"FolioNumber", "value"=> isset($ordenCompra["ComprasFactura"][0]["numero_documento"]) ? substr($ordenCompra["ComprasFactura"][0]["numero_documento"], -9) : ""));					

							echo $this->Form->hidden('Sap.DiscountPercent', array("id"=>"DiscountPercent", "value"=> number_format( ($ordenCompra["ComprasProductosTotale"]["descuento_total"]/$ordenCompra["ComprasProductosTotale"]["total"])*100 , 8, '.', '') ));

							if (!isset($ordenCompra["ComprasProductosTotale"]["tipos_documento_id"]) || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 1) {
								// dias plazo
								$groupNumber = null;
								switch ($ordenCompra["PlazosPago"]["id"]) {
									case 1: $groupNumber = '1';
											break;
									case 2: $groupNumber = '13';
											break;
									case 3: $groupNumber = '9';
											break;
									case 4: $groupNumber = '14';
											break;
									case 5: $groupNumber = '15';
											break;
									case 6: $groupNumber = '6';
											break;
								}
								echo $this->Form->hidden('Sap.PaymentGroupCode', array("id"=>"PaymentGroupCode", "value"=> $groupNumber));
							}
						?>

						

						<input type="hidden" id="idRequerimiento" value="<?php echo $id; ?>" name="idRequerimiento">
						<div class="panel panel-default">
							<!-- Default panel contents -->
							<div class="panel-heading"><Strong>Información Proveedor</Strong></div>
							<!-- List group -->					
							<ul class="list-group">
								<li class="list-group-item">Nombre Proveedor: <?php echo strtoupper($ordenCompra["Company"]["razon_social"]); ?></li>
								<li class="list-group-item">Rut proveedor: <?php echo $ordenCompra["Company"]["rut"]; ?></li>
								<li class="list-group-item">Plazo pago: <?php echo strtoupper($ordenCompra["PlazosPago"]["nombre"]); ?></li>	
								<!--li class="list-group-item">
									<div>
										<label for="inputPassword3" class="control-label">Cliente/Proveedor SAP</label>
										<?php echo $this->Form->input('Sap.CardCode', array("id"=>"sociosDeNegocio", "type"=>"select", "class"=>"form-control", "label"=>false));?>
									</div>
								</li-->
							</ul>
						</div>
					</div>				
				</div>
				
				<div class="row clearfix">
					<div class="col-md-4 column">
					</div>
					<?php if(!empty($perfilUsuario) && $perfilUsuario != "aprobadores"){ ?>
					<div class="col-md-4 column">
						<?php if(isset($ordenCompra["ComprasProductosTotale"]["tipos_documento_id"]) && $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] != 1) { ?>
						<ul class="list-group">
							<li class="list-group-item">
								<div>
									<label for="inputPassword3" class="control-label">Indicador</label>
									<?php echo $this->Form->input('Sap.Indicator', array("id"=>"indicadores", "type"=>"select", "class"=>"form-control", "label"=>false, "default"=> 35));?>
								</div>
							</li>
						</ul>
						<?php } ?>
					</div>
					
					
					
					<div class="col-md-4 column">
						<ul class="list-group">
							<li class="list-group-item">
								<div>
									<label for="inputPassword3" class="control-label">Cliente/Proveedor</label>
									<?php echo $this->Form->input('Sap.CardCode', array("id"=>"sociosDeNegocio", "type"=>"select", "class"=>"form-control", "label"=>false));?>
								</div>
							</li>
						</ul>
					</div>
					<?php } ?>
				</div>
				
				<div class="row">
					<strong><span>Observación:</span></strong> <?php echo strtoupper($ordenCompra["ComprasProductosTotale"]["observacion"]); ?>						
					<br/>
					<br/>
				</div>				
			</div>

			<?php 

				if(!empty($perfilUsuario) && $perfilUsuario != "aprobadores"){

					if(isset($ordenCompra["ComprasProductosTotale"]["tipos_documento_id"]) && $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] != 1 ) {

						$claseServicio = true;
				?>

				<legend for="DocType">Clase de Artículo/Servicio</legend>
				<label for="dDocument_Service">Servicios</label>
				<input type="radio" id="dDocument_Service" name="data[Sap][DocType]" value="dDocument_Service">
				<label for="dDocument_Items">Artículos</label>
				<input type="radio" id="dDocument_Items" name="data[Sap][DocType]" value="dDocument_Items">

				<?php 

					} else {

					$claseServicio = false;
				?>
				<input type="hidden" id="dDocument_Items" name="data[Sap][DocType]" value="dDocument_Items" selected>
				<br/>
				<h4>Productos:</h4>	

				<?php 
				
					} 

				}
			?>

			<div style="width:100%; overflow:auto;">
				<span id="codigo_sap"></span>
				<input type="hidden" id="idRequerimiento" value="<?php echo $id; ?>" name="idRequerimiento">
				<table class="table table-striped table-bordered ">
					<thead>
						<tr>
							<th width="2%"><a href="javascript:void(0)" class="checkTodos">Apro.</a></th>
							
							<?php if(!empty($perfilUsuario) && $perfilUsuario != "aprobadores"){ ?>
								<th>Cód. SAP </th>
							<?php } ?>
							
							<th>Can.</th>
							<th>Impuesto</th>
							<th>Desc.</th>
							<th>Valor</th>
							<th>Descuento</th>
							<th>Empaque</th>
							<th>Gere.</th>
							<th>Esta.</th>
							<th>Cont.</th>
							<th>C.Dist.</th>
							<th>Otros</th>
							<th>Proy.</th>
							<th>Cód.Pres.</th>				
							<th>Sub Total</th>
						</tr>
						<?php ?>
					</thead>
					<tbody>
						<?php 

							foreach($ordenCompra["ComprasProducto"] as $key => $productos) :

							//if ($claseServicio) {
								// SERVICIOS
								//echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.ProductId', array("id"=>"ProductId", "value"=> $productos["id"] ));						
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.LineNumber', array("id"=>"LineaNumber", "value"=> $key ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.ItemDescription', array("id"=>"Descripcion", "value"=> mb_strtoupper($productos["descripcion"])));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.DiscountPercent', array("id"=>"DiscountPercent", "value"=> number_format( str_replace(".","", $productos["descuento_producto"]) / str_replace(".","", $productos["precio_unitario"]) * 100, 8) ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.LineTotal', array("id"=>"TotalLM", "value"=> str_replace(",",".", str_replace(".","", $productos["subtotal"])) ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.CostingCode', array("id"=>"CentroCosto", "value"=> explode(" - ",$productos["dim_uno"])[0] ));									
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.CostingCode2', array("id"=>"Estadio", "value"=> explode(" - ",$productos["dim_dos"])[0] ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.CostingCode3', array("id"=>"Contenido", "value"=> explode(" - ",$productos["dim_tres"])[0] ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.CostingCode4', array("id"=>"CanalesDist", "value"=> explode(" - ",$productos["dim_cuatro"])[0] ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.CostingCode5', array("id"=>"Varios", "value"=> explode(" - ",$productos["dim_cinco"])[0] ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.ProjectCode', array("id"=>"ProjectCode", "value"=> $productos["proyecto_codigo"] ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.U_codppto', array("id"=>"cor_prespuesto", "value"=> str_replace("-","",$productos["codigos_presupuestarios"]) ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.TaxCode', array("id"=>"TaxCode", "value"=> ($productos["afecto"] == 1 && $prefijoSap!= 'BH') ? "IVA" : "IVA_EXE" ));					
							
							//} else {
								// ARTICULOS
								if($key == 0) {
									//titulo
									echo $this->Form->hidden('Sap.DocumentSpecialLines.Text1.LineType', array("id"=>"LineType", "value"=> 'dslt_Text' ));
									echo $this->Form->hidden('Sap.DocumentSpecialLines.Text1.LineText', array("id"=>"LineText", "value"=> mb_strtoupper($ordenCompra["ComprasProductosTotale"]["titulo"]) ));
									echo $this->Form->hidden('Sap.DocumentSpecialLines.Text1.AfterLineNumber', array("id"=>"LineNumber", "value"=> -1 ));
									echo $this->Form->hidden('Sap.DocumentSpecialLines.Text1.OrderNumber', array("id"=>"OrderNumber", "value"=> 1 ));
									//salto
									echo $this->Form->hidden('Sap.DocumentSpecialLines.Text2.LineType', array("id"=>"LineType", "value"=> 'dslt_Text' ));
									echo $this->Form->hidden('Sap.DocumentSpecialLines.Text2.LineText', array("id"=>"LineText", "value"=> " ") );	
									echo $this->Form->hidden('Sap.DocumentSpecialLines.Text2.AfterLineNumber', array("id"=>"LineNumber", "value"=> -1 ));	
									echo $this->Form->hidden('Sap.DocumentSpecialLines.Text2.OrderNumber', array("id"=>"OrderNumber", "value"=> 2 ));							
								}
								//detalle
								//artículo							
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.LineType', array("id"=>"LineType", "value"=> 'dlt_Regular' ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.LineNumber', array("id"=>"LineNumber", "value"=> $key ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.Quantity', array("id"=>"Quantity", "value"=> number_format($productos["cantidad"], 0, '', '.') ));						
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.DiscountPercent', array("id"=>"DiscountPercent", "value"=> number_format( str_replace(".","", $productos["descuento_producto"]) / str_replace(".","", $productos["precio_unitario"]) * 100, 8) ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.LineTotal', array("id"=>"LineTotal", "value"=> str_replace(",",".", str_replace(".","", $productos["subtotal"])) ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.CostingCode', array("id"=>"CentroCosto", "value"=> explode(" - ",$productos["dim_uno"])[0] ));									
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.CostingCode2', array("id"=>"Estadio", "value"=> explode(" - ",$productos["dim_dos"])[0] ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.CostingCode3', array("id"=>"Contenido", "value"=> explode(" - ",$productos["dim_tres"])[0] ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.CostingCode4', array("id"=>"CanalesDist", "value"=> explode(" - ",$productos["dim_cuatro"])[0] ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.CostingCode5', array("id"=>"Varios", "value"=> explode(" - ",$productos["dim_cinco"])[0] ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.ProjectCode', array("id"=>"ProjectCode", "value"=> $productos["proyecto_codigo"] ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.U_codppto', array("id"=>"cor_prespuesto", "value"=> str_replace("-","",$productos["codigos_presupuestarios"]) ));
								echo $this->Form->hidden('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.TaxCode', array("id"=>"TaxCode", "value"=> ($productos["afecto"] == 1 && $prefijoSap!= 'BH') ? "IVA" : "IVA_EXE" ));	
								//descripcion
								echo $this->Form->hidden('Sap.DocumentSpecialLines.'.$productos["id"].'.LineType', array("id"=>"LineType", "value"=> 'dslt_Text' ));
								echo $this->Form->hidden('Sap.DocumentSpecialLines.'.$productos["id"].'.LineText', array("id"=>"LineText", "value"=> strtoupper($productos["descripcion"])));	
								echo $this->Form->hidden('Sap.DocumentSpecialLines.'.$productos["id"].'.AfterLineNumber', array("id"=>"LineNumber", "value"=> $key ));
								//echo $this->Form->hidden('Sap.DocumentSpecialLines.'.$productos["id"].'.OrderNumber', array("id"=>"OrderNumber", "value"=> 1 ));

								//salto
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text3.LineType', array("id"=>"LineType", "value"=> 'dslt_Text' ));
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text3.LineText', array("id"=>"LineText", "value"=> ' '));	
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text3.AfterLineNumber', array("id"=>"LineNumber", "value"=> $key ));
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text3.OrderNumber', array("id"=>"OrderNumber", "value"=> 1 ));
								//pie contenido
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text4.LineType', array("id"=>"LineType", "value"=> 'dslt_Text' ));
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text4.LineText', array("id"=>"LineText", "value"=> 'SOLICITADO POR '.mb_strtoupper($ordenCompra["User"]["nombre"])));	
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text4.AfterLineNumber', array("id"=>"LineNumber", "value"=> $key ));
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text4.OrderNumber', array("id"=>"OrderNumber", "value"=> 2 ));
								
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text5.LineType', array("id"=>"LineType", "value"=> 'dslt_Text' ));
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text5.LineText', array("id"=>"LineText", "value"=> 'CÓDIGO PPTO: '));	
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text5.AfterLineNumber', array("id"=>"LineNumber", "value"=> $key ));	
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text5.OrderNumber', array("id"=>"OrderNumber", "value"=> 3 ));
								
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text6.LineType', array("id"=>"LineType", "value"=> 'dslt_Text' ));
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text6.LineText', array("id"=>"LineText", "value"=> 'Observación: '. $ordenCompra["ComprasProductosTotale"]["observacion"] ));	
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text6.AfterLineNumber', array("id"=>"LineNumber", "value"=> $key ));
								echo $this->Form->hidden('Sap.DocumentSpecialLines.Text6.OrderNumber', array("id"=>"OrderNumber", "value"=> 4 ));

								// adjuntos
								//$ordenCompra["ComprasProductosTotale"]["adjunto"]
								//pr(WWW_ROOT.'files'.DS.'orden_compra'.DS.explode(".",$archivos[0])[0].'_2.pdf');
								//$this->Form->file('Sap.SourcePath2', array("id"=>"SourcePath2", "value"=> WWW_ROOT.'files'.DS.'orden_compra'.DS.explode(".",$archivos[0])[0].'_2.pdf'));
								
								foreach ($archivos as $key => $archivo) {
									$nombreArr = explode(".",basename($archivo));
									$pos = count($nombreArr)-1;
									$ext = $nombreArr[$pos];
									$nombre = basename($archivo, ".".$ext);

									echo $this->Form->hidden('Sap.Attachments2_Lines.'.$key.'.SourcePath', array("id"=>"SourcePath", "value"=> WWW_ROOT.'files'.DS.'orden_compra'.DS.$archivo) );
									echo $this->Form->hidden('Sap.Attachments2_Lines.'.$key.'.FileName', array("id"=>"FileName", "value"=> $nombre ));
									echo $this->Form->hidden('Sap.Attachments2_Lines.'.$key.'.FileExtension', array("id"=>"FileExtension", "value"=> $ext ));
								}
								
						?>
							<?php if($productos["estado"] != 0) : ?>
							<?php 

								$codigoPresupuestario = explode("-", $productos["codigos_presupuestarios"]);
								if($productos["estado"] != 0 ) :
									if(!empty($productos["subtotal"]))
									{
										$subTotal[] = $productos["subtotal"];
									}
									if($productos["estado"] == 3 || $productos["estado"] == 5)
									{
										$classRechazado = "rechazado";
									}
									else
									{
										$classRechazado = "";
									}
							?>
								<tr class="tool" data-toggle="tooltip" data-placement="top" tile="hola a todos">
									<td>
										<?php if(!empty($perfilUsuario) && $perfilUsuario == "ingreso_sap" && $productos["estado"] == 2): ?>
											<input class="check" type="checkbox" name="productos[]" value="<?php echo $productos["id"];?>">

										<?php elseif($productos["estado"] == 1) :?>
											<?php if(isset($codigosCortos)) :?>
												<?php if (in_array($codigoPresupuestario[0], $codigosCortos)) : ?>
													<input class="check" type="checkbox" name="productos[]" value="<?php echo $productos["id"];?>">
												<?php endif; ?>
											<?php endif; ?>
										<?php elseif($productos["estado"] == 3 || $productos["estado"] == 5) : ?>
											<i class="fa fa-times icono_grilla tool" data-toggle="tooltip" data-placement="top" ></i>
										<?php else : ?>
											<i class="fa fa-check-square fa-check-square-view icono_grilla"></i>
									<?php endif?>
									</td>

									<?php if(!empty($perfilUsuario) && $perfilUsuario != "aprobadores"){ ?>
									<td class="<?php echo $classRechazado; ?>" width="160">
										<div id='articulos-"<php? $productos["id"] ?>"'>
											<?php //pr($ordenCompra["ComprasProducto"]);
												echo $this->Form->input('Sap.DocumentLines.dDocument_Items.'.$productos["id"].'.ItemCode', array("id"=>"articulos-".$productos["id"], "type"=>"select", "class"=>"form-control", "label"=>false, "width" => "148px"));
											?>
										</div>
										<div style="display:none" id='cuentas-"<php? $productos["id"] ?>"'>
											<?php 
												echo $this->Form->input('Sap.DocumentLines.dDocument_Service.'.$productos["id"].'.AccountCode', array("id"=>"cuentas-".$productos["id"], "type"=>"select", "class"=>"form-control", "label"=>false, "width" => "148px"));
											?>
										</div>										
									</td>
									<?php } ?>

									
									<td class="<?php echo $classRechazado; ?>">
										<p><?php echo number_format($productos["cantidad"], 0, '', '.');?></p>
									</td>
									<td><?php echo ($productos["afecto"] == 1) ? "Afecto" : "Exento"; ?></td>
									<td class="<?php echo $classRechazado; ?>"><a style="cursor:pointer;" data-toggle="popover" title="Descripción" data-content="<?php echo strtoupper($productos["descripcion"]); ?>"><p><?php echo strtoupper( substr($productos["descripcion"], 0, 15)   ); ?></p></a></td>
									
									<td class="<?php echo $classRechazado; ?>"><p><?php echo $productos["precio_unitario"];?></p></td>
									<td class="<?php echo $classRechazado; ?>">
										<p>
										<?php
											if(isset($productos["descuento_producto"]) && !empty( $productos["descuento_producto"]) && !empty($ordenCompra["TiposMoneda"]["id"]) != 1)
											{

												$enteroDecimal = explode(',', $productos["descuento_producto"]);


												echo number_format($enteroDecimal[0], 0, '', '.') . ','.$enteroDecimal[1];
											}
											elseif(empty($productos["descuento_producto"]))
											{
												echo 0;
											}
											else
											{
												echo $productos["descuento_producto"]; 
											}
										?>
										</p>
									</td>
									<td class="<?php echo $classRechazado; ?>"><p><?php echo strtoupper($productos["empaque"]);?></p></td>
			 						<td class="<?php echo $classRechazado; ?>"><p><?php echo strtoupper($productos["dim_uno"]);?></p></td>
									<td class="<?php echo $classRechazado; ?>"><p><?php echo strtoupper($productos["dim_dos"]);?></p></td>
									<td class="<?php echo $classRechazado; ?>"><p><?php echo strtoupper($productos["dim_tres"]);?></p></td>
									<td class="<?php echo $classRechazado; ?>"><p><?php echo strtoupper($productos["dim_cuatro"]);?></p></td>
									<td class="<?php echo $classRechazado; ?>"><p><?php echo strtoupper($productos["dim_cinco"]);?></p></td>
									<td class="<?php echo $classRechazado; ?>"><p><?php echo strtoupper($productos["proyecto"]);?></p></td>
									<td class="<?php echo $classRechazado; ?>">
                                        <a href="#" class="codigoPresupuestario"> 
                                            <?php echo strtoupper($productos["codigos_presupuestarios"]);?> <span id="nombreCodigo[]"></span>
                                        </a>
                                    </td>						
									<td class="<?php echo $classRechazado; ?>">
										<p>
										<?php
											if($ordenCompra["TiposMoneda"]["id"] != 1)
											{	$suma[] =  str_replace(',', '.', $productos["subtotal"]);
													
												//pr($productos["subtotal"]);
												
												$enteroDecimal = explode(',', $productos["subtotal"]);
												if(count($enteroDecimal) > 1)
												{
													echo number_format($enteroDecimal[0], 0, '', '.') . ','.$enteroDecimal[1];	
												}
												else
												{
													echo number_format($enteroDecimal[0], 0, '', '.');	
												}	
											}
											else
											{
												echo number_format($productos["subtotal"], 0, '', '.');
											}

										?>
										</p>
									</td>
								</tr>
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php if($ordenCompra["ComprasProductosTotale"]["tipos_moneda_id"] != 1) : ?>
				<p class="text-right"><strong>Total en moneda original : <?php echo number_format(floatval(array_sum($suma)), 2, ',', '.'); ?></strong></p>
				<?php endif; ?>
				
			</div>


		<?php if(empty($ordenCompra["ComprasProductosTotale"]["declaracion_ingreso"])) : ?>
			<table class="table table-striped">
				<tbody>
					<tr>
						<td><h3 class="text-right"> Totales ($)</h3>	</td>
						<td></td>
					</tr>
					<tr>
						<td width="90%" class="text-right"><strong>Neto Afecto s/d: </strong></td>
						<td class="text-right">
							<?php
								$sumaProductosAfectos = array();
								$sumaProductosNoAfectos = array();
								foreach($ordenCompra["ComprasProducto"] as $productos)
								{
									if($productos["estado"] != 0)
									{
										if($productos["estado"] != 3 && $productos["afecto"] == 1)
										{
											$sumaProductosAfectos[] = $productos["subtotal"];
										}
										
										if($productos["estado"] != 3 && $productos["afecto"] == 2)
										{
											$sumaProductosNoAfectos[] = $productos["subtotal"];
										}
									}
								}

								if(empty($ordenCompra['ComprasProductosTotale']['tipo_cambio']))
								{
									$totalNetoSinDescuentos =  (!empty($sumaProductosAfectos) ? array_sum($sumaProductosAfectos) : 0);
									$netoAfecto = number_format($totalNetoSinDescuentos, 0, '', '.');
								}
								else
								{
									$totalNetoSinDescuentos = 0;
									foreach($sumaProductosAfectos as $sumaProductosAfecto)
									{
										$totalNetoSinDescuentos += str_replace(",",".",$sumaProductosAfecto);
									}
									$netoAfecto = number_format($totalNetoSinDescuentos * $ordenCompra['ComprasProductosTotale']['tipo_cambio'] , 0, '', '.');
								}
								echo $netoAfecto;
							?>
						</td>
					</tr>
				
					<tr>
						<td width="85%" class="text-right"><strong>Neto Exento s/d:</strong></td>
						<td class="text-right">
							<?php 
								if(empty($ordenCompra['ComprasProductosTotale']['tipo_cambio']))
								{
									$netoExento = (!empty($sumaProductosNoAfectos) ? number_format(array_sum($sumaProductosNoAfectos), 0, '', '.') : 0);
								}
								else
								{
                                    //print_r($sumaProductosNoAfectos) .'<br/>';
                                    //echo array_sum($sumaProductosNoAfectos) .'<br/>';
									$netoExento = (!empty($sumaProductosNoAfectos) ? number_format(array_sum($sumaProductosNoAfectos) * $ordenCompra['ComprasProductosTotale']['tipo_cambio'], 0, '', '.') : 0);
								}
								echo $netoExento;
							?>
						</td>
					</tr>

					<tr>
						<td width="85%" class="text-right"><strong>Descuento : </strong></td>
						<td class="text-right"><?php  echo number_format($ordenCompra["ComprasProductosTotale"]["descuento_total"], 0, '', '.');?></td>			
					</tr>

					

					<tr>
						<td width="85%" class="text-right"><strong>Neto Total c/d: </strong></td>
						<td class="text-right">
							<?php echo number_format($ordenCompra["ComprasProductosTotale"]["neto_descuento"], 0, '', '.');?>
						</td>
					</tr>

					<tr>
						<td width="85%" class="text-right"><strong>
						<?php  if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 1 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 2 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 17 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 21 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 19 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 20 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 22 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 26): ?>
							Impuesto:
						<?php else :  ?>
						 Retencíon
						 <?php endif; ?> 
						</strong></td>
						<td class="text-right">
							<?php
								if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 1 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 17 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 20 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 22 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 26)
								{
									if(empty($ordenCompra['ComprasProductosTotale']['tipo_cambio']))
									{
										echo number_format($totalNetoSinDescuentos * 0.19, 0, '', '.');
									}
									else
									{
										echo number_format(($totalNetoSinDescuentos * $ordenCompra['ComprasProductosTotale']['tipo_cambio']) * 0.19, 0, '', '.');
									}
									//echo number_format(array_sum($sumaProductosAfectos) * 0.19, 0, '', '.');
								}
								else if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 2 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 19 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 21 )
								{
									echo "0";
								}
								else
								{
									if(empty($ordenCompra['ComprasProductosTotale']['tipo_cambio']))
									{
										echo number_format($totalNetoSinDescuentos / 10, 0, '', '.');
									}
									else
									{
										echo number_format(($totalNetoSinDescuentos * $ordenCompra['ComprasProductosTotale']['tipo_cambio']) / 10, 0, '', '.');
									}
									//echo number_format(round($ordenCompra["ComprasProductosTotale"]["neto_descuento"] / 10), 0, '', '.');
								}
							?>
						</td>
					</tr>
					
					<tr>
						<td width="85%" class="text-right"><strong>Total: </strong></td>
						<td class="text-right">
							<?php
								echo number_format($ordenCompra["ComprasProductosTotale"]["total"], 0, '', '.');
							?>
						</td>
					</tr>
				</tbody>
			</table>
		<?php endif; ?>

		<?php if(!empty($ordenCompra["ComprasProductosTotale"]["declaracion_ingreso"])) : ?>
		<?php $declaracionIngreasos = unserialize($ordenCompra["ComprasProductosTotale"]["declaracion_ingreso"]);?>
			<table class="table table-striped">
				<tbody>
					<tr>
						<td><h3 class="text-right"> Totales ($)</h3></td>
						<td></td>
					</tr>
					<tr>
						<td width="90%" class="text-right"><strong>Total Neto S/D: </strong></td>
						<td class="text-right"><?php echo number_format($declaracionIngreasos["neto_sin_descueto"], 0, '', '.'); ?></td>
					</tr>
					<tr>
						<td width="85%" class="text-right"><strong>Descuentos : </strong></td>
						<td class="text-right"><?php echo number_format($declaracionIngreasos["descuentos"], 0, '', '.') ?></td>
					</tr>

					<tr>
						<td width="85%" class="text-right"><strong>Total Neto C/D: </strong></td>
						<td class="text-right"><?php echo number_format($declaracionIngreasos["neto_descuento"], 0, '', '.'); ?></td>
					</tr>

					<tr>
						<td width="85%" class="text-right"><strong>Impuesto:</strong></td>
						<td class="text-right"><?php echo number_format($declaracionIngreasos["impuesto"], 0, '', '.'); ?></td>
					</tr>
					<tr>
						<td width="85%" class="text-right"><strong>Exento:</strong></td>
						<td class="text-right"><?php echo number_format($declaracionIngreasos["exento"], 0, '', '.'); ?></td>
					</tr>
					<tr>
						<td width="85%" class="text-right"><strong>Total: </strong></td>
						<td class="text-right"><?php echo number_format($declaracionIngreasos["total"], 0, '', '.'); ?></td>
					</tr>
				</tbody>
			</table>
		<?php endif; ?>

	</div>


	<?php if(!empty($perfilUsuario) && $perfilUsuario == "aprobadores"): ?>
		
		<div class="btn-group pull-right" role="group" aria-label="">
			
			<?php if($ordenCompra["ComprasProductosTotale"]["compras_estado_id"] != 4) :?>
			<a href="javascript:void(0)"  class="<?php echo $desabilitaBotonAprobar; ?> aprobar btn btn-success btn-mx <?php echo $disableDos; ?>"><i class="fa fa-thumbs-o-up"></i> Aprobar</a>
			<!--a href="<?php echo $this->Html->url(array("action"=>$aprobarCompra, $ordenCompra["ComprasProductosTotale"]["id"])); ?>"  class="btn btn-success btn-mx <?php echo $disableDos; ?>"><i class="fa fa-thumbs-o-up"></i> Aprobar</a-->
			
			<a href=""  data-toggle="modal" data-target="<?php echo $rechazarCompra; ?>" class="btn btn-danger btn-mx <?php echo $disableTres; ?>"><i class="fa fa-thumbs-o-down"></i> Rechazar</a>
			<?php endif; ?>
			<!--a href=""  class="btn btn-warning printer"><i class="fa fa-print"></i> Imprimir</a-->
		  	<a href="<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"aprobadores"))?>"  class="btn btn-info btn-mx"><i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
		  	
		</div>
	<?php endif; ?>

	<?php if(!empty($perfilUsuario) && $perfilUsuario == "ingreso_sap"): ?>
		
		<div class="btn-group pull-right" >
			
			<a id="enviar_compra_sap" href="#" class="btn btn-primary enviar_compra_sap" style="height:33px"> <i class="fa fa-share"></i> Enviar a sap
				<input type="submit" style="opacity:0; margin-top:-10px;margin-left:-100px;width:105px" class="sube">
			</a>
			
			<a id="ingresoSap" href="#" class="btn btn-success btn-mx ingresoSap"> <i class="fa fa-thumbs-o-up"></i> Ingresar a sap</a>

			<!--a href=""  data-toggle="modal" data-target="#compras_rechazar_sap" class="btn btn-danger btn-mx"><i class="fa fa-thumbs-o-down"></i> Rechazar</a-->
			<a href=""  data-toggle="modal" data-target="<?php echo $rechazarCompra; ?>" class="rechazo_sap btn btn-danger btn-mx <?php echo $disableTres; ?>"><i class="fa fa-thumbs-o-down"></i>Rechazar</a>
			
			<!--a href=""  class="btn btn-warning printer"><i class="fa fa-print"></i> Imprimir</a-->
		  	
		  	<a href="<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"ingreso_sap"))?>"  class="btn btn-info btn-mx"><i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
		  	
		</div>
	<?php endif; ?>

	<?php if(empty($perfilUsuario)): ?>
		<div class="btn-group pull-right" role="group" aria-label="">
			<!--a href=""  class="btn btn-warning printer"><i class="fa fa-print"></i> Imprimir</a-->
			<a href="<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"index"))?>"  class="btn btn-info btn-mx backLink"><i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
		</div>
	<?php endif; ?>	

</form>

<div class="modal fade" id="rechazo_requerimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <div class="modal-content">
    	<?php echo $this->Form->create('Compras', array('action' => 'compras_rechazar')); ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Motivo del rechazo</h4>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="productosRechazados" value="" name="productosRechazados">
        <input type="hidden" name="id_rechazo" class="id_rechazo" value="<?php echo $id; ?>">
      
        <?php echo $this->Form->textArea('motivoRechazo', array('label'=>false,  'class'=>'form-control', 'placeholder'=>'Motivo del rechazo', 'required')); ?>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Rechazar</button>
      </div>
      <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="compras_rechazar_sap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  
    <div class="modal-content">
    	<?php echo $this->Form->create('Compras', array('action' => 'compras_rechazar_sap')); ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Motivo del rechazo</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id_rechazo" class="id_rechazo" value="<?php echo $id; ?>">
      
        <?php echo $this->Form->textArea('motivoRechazo', array('label'=>false,  'class'=>'form-control', 'placeholder'=>'Motivo del rechazo', 'required')); ?>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Rechazar</button>
      </div>
      <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="NumeroSap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 300px;">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Código Sap</h4>
			</div>
			<div class="modal-body">
				<input type="text" name="codigo_sap" class="codigo_sap form-control" value=""> 
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary aprobarCodigosap">Aprobar</button>
			</div>
		</div>
	</div>
</div>

<script>
	
	$(function () {
  		
  		$('[data-toggle="popover"]').popover({
  			//'placement': 'bottom',
  			'title' : 'Detalle',
  			'html' : true,
  			'trigger' : 'click',
  		});
	})


	$("select[id^='articulos']").append("<option value=''> </option>"); 
	var Articulos = '<?php echo json_encode($sap["articulos"], JSON_HEX_APOS|JSON_HEX_QUOT ); ?>';
	var articulos = JSON.parse(Articulos.replace(/[\u0000-\u0019]+/g,""));	

	$.each(articulos, function(i, item){
		$("select[id^='articulos']").append("<option value='"+item.id+"'>" +item.name+ "</option>");
	});
	$("select[id^='articulos']").select2({
		placeholder: "Seleccione",
		allowClear: true,
		dropdownAutoWidth : true,
		width: '148px'
	});	

	$("select[id^='cuentas']").append("<option value=''> </option>"); 
	var Cuentas = '<?php echo json_encode($sap["cuentas"], JSON_HEX_APOS|JSON_HEX_QUOT ); ?>';
	var cuentas = JSON.parse(Cuentas.replace(/[\u0000-\u0019]+/g,""));	

	$.each(cuentas, function(i, item){
		$("select[id^='cuentas']").append("<option value='"+item.id+"'>" +item.name+ "</option>");
	});
	$("select[id^='cuentas']").select2({
		placeholder: "Seleccione",
		allowClear: true,
		dropdownAutoWidth : true,
		width: '148px'
	});	

	var productos = '<?php echo json_encode($ordenCompra["ComprasProducto"], JSON_HEX_APOS|JSON_HEX_QUOT ); ?>';
	productos = JSON.parse(productos.replace(/[\u0000-\u0019]+/g,""));	
	$.each(productos, function(i, item){				
		$("#articulos-"+item.id).val(item.sap_item_code_id).select2({
			placeholder: "Seleccione",
			allowClear: true,
			dropdownAutoWidth : true,
			width: '148px'
		}).attr("disabled", (item.sap_item_code_id !== null? true : false));
	});

	$("#indicadores").append("<option value=''> </option>"); 
	var Indicadores = '<?php echo json_encode($sap["indicadores"], JSON_HEX_APOS|JSON_HEX_QUOT ); ?>';	
	var indicadores = JSON.parse(Indicadores.replace(/[\u0000-\u0019]+/g,""));	

	$.each(indicadores, function(i, item){
		$("#indicadores").append("<option value='"+item.id+"'>" +item.name+ "</option>");
	});	

	var indicador = '<?php echo $ordenCompra["ComprasProductosTotale"]["sap_indicator_id"]?>';
	$("#indicadores").val(indicador).select2({
		placeholder: "Seleccione indicador SAP",
		allowClear: true			
	}).attr("disabled", (indicador != ''? true : false));


	$("#sociosDeNegocio").append("<option value=''> </option>"); 
	var SociosDeNegocio = '<?php echo json_encode($sap["SociosDeNegocio"], JSON_HEX_APOS|JSON_HEX_QUOT ); ?>';
	var socios = JSON.parse(SociosDeNegocio.replace(/[\u0000-\u0019]+/g,""));

	$.each(socios, function(i, item){		
		$("#sociosDeNegocio").append("<option value='"+i+"'>" +item+ "</option>");
	});

	var socioNegocio = '<?php echo $ordenCompra["ComprasProductosTotale"]["sap_card_code_id"]?>';	
	$("#sociosDeNegocio").val(socioNegocio).select2({
		placeholder: "Seleccione Cliente/Proveedor SAP",
		allowClear: true
	}).attr("disabled", (socioNegocio != ''? true : false));

	var docType = '<?php echo $ordenCompra["ComprasProductosTotale"]["sap_doc_type_id"]?>';
	var envioSapAnterior = '<?php echo isset($sap["sap_doc_entry_id"])? $sap["sap_doc_entry_id"] : "" ?>';
	console.log(envioSapAnterior);
	$("#dDocument_Items").prop("checked", docType == 'dDocument_Items' ? true : false);
	$("input[name='data[Sap][DocType]']").prop("disabled", docType != '' ? true : false);
	$("select[id^='articulos']").prop("disabled", docType != '' ? true : false);

	// alerta al momento de registrar si no hay envios sgi a sap.
	
	if ($("input[name='data[Sap][DocType]']").val() != 'dDocument_Items'){ //documento
		$("select[id^='articulos']").attr("disabled", true);
	}
	$("input[name='data[Sap][DocType]']").click(function() {
		$("select[id^='articulos']").attr("disabled", false);
		if ($("input[name='data[Sap][DocType]']:checked").val() == 'dDocument_Items') {
			$("div[id^='articulos-']").show();
			$("div[id^='cuentas-']").hide();
		} else {			
			$("div[id^='articulos-']").hide();
			$("div[id^='cuentas-']").show();			
		}
	});

    $(document).ready(function() {
        
        $('.codigoPresupuestario').click(function(){
    		if($(this).text()){
    			$.ajax({
				    type: "GET",
				    url:"<?php echo $this->Html->url(array("controller"=>"servicios", "action"=>"codigo_nombre"))?>",
				    data: {"codigo" : $(this).text()},
				    async: true,
				    dataType: "json",
				    success: function(data) {
				    	alert(data);
				    }
				 })
    		}
    	})
        
        
    	$('.tool').tooltip();

		$(".printer").click(function(){
			$(".print").printArea();
		});

		$(".backLink").click(function() {
			 var referrer =  document.referrer;
			 $(this).attr("href", referrer)
		});
		
	    $(document).ready(function() 
	    {
	    	var tipoDocumento = "<?php echo $ordenCompra['ComprasProductosTotale']['tipos_documento_id']; ?>"

	    	$(".ingresoSap").click(function(){	    		
	    		var confirmacion = true;
	    		if (envioSapAnterior == '') {
	    			confirmacion = confirm("La información no ha sido enviada a SAP \n ¿Desea continuar? ");
	    		}
	    		
	    		if (confirmacion) {

	    			if(tipoDocumento == "" || tipoDocumento == 1)
			    	{
		    			$("#aprueba").attr("action", '<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"aprobar_compra_sap"))?>')
		    			$("#aprueba").submit();		
			    	}
			    	else
			    	{
			    		$('#NumeroSap').modal('show');
			    	}
	    		}		    		

	    	});

	    	$(".enviar_compra_sap").click(function(){    			    		
	    		$('#aprueba').submit(function (e) {
	    			e.preventDefault();

		    		if($("#sociosDeNegocio").val() != '' ) {
		    			console.log($("input[name='data[Sap][DocType]']:checked").val());
		    			//return false;
			    		if(tipoDocumento == "" || tipoDocumento == 1)
				    	{		
				    		$(".btn-group").children().attr("disabled", "disabled");
				    		$("#enviar_compra_sap").children().removeClass("fa-share");
				    		$("#enviar_compra_sap").children().addClass("fa-spinner fa-pulse");	

				    		$("input[name^='data[Sap][DocumentLines][dDocument_Service]']").val('');
	    			    	
							var values = $("#aprueba :input[value!='']").serialize();	//sin blancos	

							$.post('<?php echo Router::fullbaseUrl().$this->webroot;?>'+"compras/enviar_compra_sap", values )							
							.done(function(data){
								$(".btn-group").children().removeAttr("disabled");
					    		$("#enviar_compra_sap").children().removeClass("fa-spinner fa-pulse");
					    		$("#enviar_compra_sap").children().addClass("fa-share");

								var respuesta = JSON.parse(data);
								envioSapAnterior = respuesta["sap_doc_entry_id"];
								alert(respuesta["mensaje"]);								
							});								

				    	}
				    	else
				    	{
				    		if(typeof $("input[name='data[Sap][DocType]']:checked").val() !== 'undefined')
				    		{		

			    				if($("#indicadores").val() != ''){
				    				$(".btn-group").children().attr("disabled", "disabled");
					    			$("#enviar_compra_sap").children().removeClass("fa-share");
			    					$("#enviar_compra_sap").children().addClass("fa-spinner fa-pulse");		
			    					
					    			if($("input[name='data[Sap][DocType]']:checked").val()=='dDocument_Service'){
					    				$("input[name^='data[Sap][DocumentLines][dDocument_Items]']").val('');
					    			}else{
					    				$("input[name^='data[Sap][DocumentLines][dDocument_Service]']").val('');
					    			}
					    			var values = $("#aprueba :input[value!='']").serialize();	//sin blancos

									$.post('<?php echo Router::fullbaseUrl().$this->webroot;?>'+"compras/enviar_compra_sap", values )
									.done(function(data){
										$(".btn-group").children().removeAttr("disabled");
							    		$("#enviar_compra_sap").children().removeClass("fa-spinner fa-pulse");
							    		$("#enviar_compra_sap").children().addClass("fa-share");

										var respuesta = JSON.parse(data);
										envioSapAnterior = respuesta["sap_doc_entry_id"];
										alert(respuesta["mensaje"]);										
									});										

		    					}else {
		    						alert("Seleccione Indicador");			
		    					}
				    			
				    		}
				    		else {
				    			alert("Seleccione Clase de Artículo/Servicio");		
				    		}    		
				    	}
		    		} else {
		    			alert("Seleccione Cliente/Proveedor SAP");

		    		}
		    		$(this).unbind(e);
		    	});
			})

	    	$('#NumeroSap').on('show.bs.modal', function(e) {
	    		$(".aprobarCodigosap").click(function(){
	    			codigo = $(".codigo_sap").val();	    			
	    			$("#codigo_sap").html('<input type="text" id="codigo" value="'+codigo+'" name="codigo">');

	    			$('<input>').attr({
					    type: 'hidden',
					    id: 'codigo',
					    name: 'codigo',
					    value: codigo
					}).appendTo('#aprueba');
	    			
	    			$(".close").trigger('click');
	    			$("#aprueba").attr("action", '<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"aprobar_compra_sap"))?>');

		    		$("#aprueba").submit();
	    		});
	    	});
	    });
		
		$(".checkTodos").click(function () {
			$('.check').each(function(){
				var checkbox = $(this);
				if(checkbox.is(':checked') == true)
				{
					$(this).prop('checked',false);
				}	
				else
				{
					$(this).prop('checked',true);
				}

			});
    	});

		$(".aprobar").click(function(){			
			$("#aprueba").submit();
		})


		$(".rechazo_sap").click(function(){

			$("#ComprasComprasRechazarForm").attr("action", "<?php echo $this->Html->url(array('controller'=>'compras', 'action'=>'compras_rechazar_sap'));?>")
		})


		$('#rechazo_requerimiento').on('show.bs.modal', function(e) {
			//var idProductos = [];
			var idProductos = new Array();

			$('.check').each(function(){
				var checkbox = $(this);
				if(checkbox.is(':checked') == true)
				{
					idProductos.push($(this).val());
				}
			});
			if(idProductos != "")
			{
				$("#productosRechazados").val(idProductos);
			}
			else
			{
				$("#productosRechazados").val("");
			}
		});

	});
</script>
