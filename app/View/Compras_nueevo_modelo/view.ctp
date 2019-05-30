<?php 
	//pr($ordenCompra);
	//exit;
	$disableDos = "";
	$disableTres = "";
	if( $ordenCompra["ComprasProductosTotale"]["estado"] == 2)
	{
		$disableDos = "disabled";
	}

	if( $ordenCompra["ComprasProductosTotale"]["estado"] == 3)
	{
		$disableTres = "disabled";
	}
?>
<?php if(!empty($perfilUsuario) && $perfilUsuario == "aprobadores"): ?>
	<div class="btn-group pull-right" role="group" aria-label="">
		
		<?php if($ordenCompra["ComprasProductosTotale"]["estado"] != 4) :?>
		

		<a href="<?php echo $this->Html->url(array("action"=>$aprobarCompra, $ordenCompra["ComprasProductosTotale"]["id"])); ?>"  class="btn btn-success btn-mx <?php echo $disableDos; ?>"><i class="fa fa-thumbs-o-up"></i> Aprobar</a>
		
		<a href=""  data-toggle="modal" data-target="<?php echo $rechazarCompra; ?>" class="btn btn-danger btn-mx <?php echo $disableTres; ?>"><i class="fa fa-thumbs-o-down"></i> Rechazar</a>
		<?php endif; ?>
		<!--a href=""  class="btn btn-warning printer"><i class="fa fa-print"></i> Imprimir</a-->
	  	<a href="<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"aprobadores"))?>"  class="btn btn-info btn-mx"><i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
	  	
	</div>
<?php endif; ?>

<?php if(!empty($perfilUsuario) && $perfilUsuario == "ingreso_sap"): ?>
	<div class="btn-group pull-right" role="group" aria-label="">
		

		<!--a href="#" class="" id="codigoSap" data-type="text" data-pk="<?php echo $ordenCompra["ComprasProductosTotale"]["id"]?>" data-url="/post" data-title=""><i class="fa fa-thumbs-o-up"></i> Ingresar a sap</a-->
		<a data-type="text" data-pk="<?php echo $ordenCompra["ComprasProductosTotale"]["id"]?>" id="codigoSap" href="#"  class="btn btn-success btn-mx codigoSap" data-url="<?php echo $this->Html->url(array("action"=>"aprobar_compra_sap")); ?>" data-title="Codigo SAP" style="border-bottom: 1px dashed #0088cc; text-decoration: none;"> <i class="fa fa-thumbs-o-up"></i> Ingresar a sap</a>


		<a href=""  data-toggle="modal" data-target="#compras_rechazar_sap" class="btn btn-danger btn-mx"><i class="fa fa-thumbs-o-down"></i> Rechazar</a>
		
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
	
	<p>Titulo : <?php echo $ordenCompra["ComprasProductosTotale"]["titulo"]; ?></p>

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
  						<li class="list-group-item " title="Creador">Creador: <?php echo $ordenCompra["User"]["nombre"]; ?></li>
  						<li class="list-group-item list-group-item-success" title="Fecha creación">Fecha creación: <?php echo $ordenCompra["ComprasProductosTotale"]["created"]; ?></li>
  						<li class="list-group-item" title="Estado">Estado:  
							<?php if($ordenCompra["ComprasProductosTotale"]["estado"] == 1)
								{
								echo '<span class="text-danger tool cursor_pointer" data-toggle="tooltip" data-placement="top" title="Pendiente por aprobar en gerencia">  Pendiente</span>';
								}

								else if($ordenCompra["ComprasProductosTotale"]["estado"] == 2)
								{
								echo '<span class="text-warning tool cursor_pointer" data-toggle="tooltip" data-placement="top" title="Aprobado por Gerencia"> Aprobado</span>';
								}

								else if($ordenCompra["ComprasProductosTotale"]["estado"] == 4)
								{
								echo '<span class="text-morado tool cursor_pointer" data-toggle="tooltip" data-placement="top" title="Ingresado en SAP"> Ing. Sap</span>';
								}

								else if($ordenCompra["ComprasProductosTotale"]["estado"] == 0)
								{
								echo '<span class="text-warning tool cursor_pointer" data-toggle="tooltip" data-placement="top" title="Pendiente">  Eliminado</span>';
								}

		 
								else if($ordenCompra["ComprasProductosTotale"]["estado"] == 3)
								{
								echo '<span class="text-default tool cursor_pointer" data-toggle="tooltip" data-placement="top" title="'.$ordenCompra["ComprasProductosRechazo"][0]["motivo"]. '"> Rechazado Gerencia</span>';
								}

								else if($ordenCompra["ComprasProductosTotale"]["estado"] == 5)
								{

								echo '<span class="text-default tool cursor_pointer" data-toggle="tooltip" data-placement="top" title="'.$ordenCompra["ComprasProductosRechazo"][0]["motivo"]. '"> Rechazado S</span>';
								}

								else if($ordenCompra["ComprasProductosTotale"]["estado"] == 6)
								{

								echo '<span class="text-success tool cursor_pointer" data-toggle="tooltip" data-placement="top" title="Facturado">Facturado</span>';
								}
								else
								{
								echo '<span class="text-success tool" data-toggle="tooltip" data-placement="top" title="Terminado">Terminado</span>';
								}
							?>
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
									{	echo "<h5>Gerencia</h5>";
										foreach(unserialize($ordenCompra["ComprasProductosTotale"]["aprobacion_rechazo"]) as $datos)
										{
											echo '<p> Nombre: '.$datos["UsuarioAprobador"].'</p>';
											echo '<p>Fecha: '.$datos["FechaAprobacion"].'</p>';
										}
									}

									if(isset($ordenCompra["ComprasProductosTotale"]["aprobacion_rechazo_sap"]))
									{	echo "<h5>SAP</h5>";
										foreach(unserialize($ordenCompra["ComprasProductosTotale"]["aprobacion_rechazo_sap"]) as $datos)
										{
											echo '<p>Nombre: '.$datos["UsuarioAprobarSap"].'</p>';
											echo '<p>Fecha: '.$datos["FechaAprobacion"].'</p>';
										}
									}	
							?>
		" title="Código <?php echo $ordenCompra["ComprasProductosTotale"]["id"]; ?>" data-placement="bottom"><i class="fa fa-info-circle"></i></a>
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
								else if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 2 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 19 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 20 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 21)
								{
								echo "EXENTO";
								}
								else
								{
								echo "HONORARIOS";
								}

							?>
						</li>
						<li class="list-group-item">Tipo de cambio: <?php echo strtoupper($ordenCompra['ComprasProductosTotale']['tipo_cambio']); ?></li>
						<li class="list-group-item">Moneda: <?php echo strtoupper($ordenCompra["TiposMoneda"]["nombre"]); ?></li>
						<li class="list-group-item">Archivo: <a href="<?php echo $this->Html->url('/', true).'files'.DS.'orden_compra'.DS.$ordenCompra["ComprasProductosTotale"]["adjunto"];?>" target="_blank">ver</a></li>
					</ul>
				</div>

			</div>

			<div class="col-md-4 column">
				<div class="panel panel-default">
					<!-- Default panel contents -->
					<div class="panel-heading"><Strong>Información Proveedor</Strong></div>
					<!-- List group -->
					<ul class="list-group">
						<li class="list-group-item">Nombre Proveedor: <?php echo strtoupper($ordenCompra["Company"]["alias"]); ?></li>
						<li class="list-group-item">Rut proveedor: <?php echo $ordenCompra["Company"]["rut"]; ?></li>
						<li class="list-group-item">Plazo pago: <?php echo strtoupper($ordenCompra["PlazosPago"]["nombre"]); ?></li>
						<li class="list-group-item">Observación: <?php echo strtoupper($ordenCompra["ComprasProductosTotale"]["observacion"]); ?></li>
					</ul>
				</div>

			</div>
		</div>
	</div>

<hr>
<h4>Productos:</h4>	
<div style="width:100%; overflow:auto;">	
	<table class="table table-striped table-bordered ">
		<thead>
			<tr>
				<!--th width="10%">Cód</th-->
				<th>Can.</th>
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
				<th>Cod.Pres.</th>
				<th>Sub Total</th>

			</tr>
			<?php ?>
		</thead>
		<tbody>
			<?php foreach($ordenCompra["ComprasProducto"] as $productos) :?>
				<?php 
					if($productos["estado"] != 0 ) :
						if(!empty($productos["subtotal"]))
						{
							$subTotal[] = $productos["subtotal"];
						}
				?>
					<tr>
						<!--td><?php echo $productos["id"];?></td-->
						<td><?php echo number_format($productos["cantidad"], 0, '', '.');?></td>
						<td><a style="cursor:pointer;" data-toggle="popover" title="Descripción" data-content="<?php echo strtoupper($productos["descripcion"]); ?>"><?php echo strtoupper( substr($productos["descripcion"], 0, 15)   ); ?></a></td>
						
						<td><?php echo $productos["precio_unitario"];?></td>
						<td>
							<?php
								//pr($productos["descuento_producto"]);
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
						</td>
						<td><?php echo strtoupper($productos["empaque"]);?></td>
 						<td><?php echo strtoupper($productos["dim_uno"]);?></td>
						<td><?php echo strtoupper($productos["dim_dos"]);?></td>
						<td><?php echo strtoupper($productos["dim_tres"]);?></td>
						<td><?php echo strtoupper($productos["dim_cuatro"]);?></td>
						<td><?php echo strtoupper($productos["dim_cinco"]);?></td>
						<td><?php echo strtoupper($productos["proyecto"]);?></td>
						<td><?php echo strtoupper($productos["codigos_presupuestarios"]);?></td>
						<td>
							<?php
								if($ordenCompra["TiposMoneda"]["id"] != 1)
								{
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
									//echo $ordenCompra["TiposMoneda"]["id"] ."<br/>";
									//pr("2");
									echo number_format($productos["subtotal"], 0, '', '.');
								}

							?>
						</td>
					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<table class="table table-striped">
	<tbody>
		<tr>
			<td><h3 class="text-right"> Totales ($)</h3>	</td>
			<td></td>
		</tr>
		<tr>
			<td width="90%" class="text-right"><strong>Total Neto S/D: </strong></td>
			<td class="text-right">
				<?php
					if(!empty($ordenCompra['ComprasProductosTotale']['tipo_cambio']))
					{
						$cambiaPuntos = str_replace(",",".",$subTotal);

						echo number_format(array_sum($cambiaPuntos) * $ordenCompra['ComprasProductosTotale']['tipo_cambio'], 0, '', '.');
					}
					else
					{
						echo number_format(array_sum($subTotal), 0, '', '.');
					}
					
				?>
			</td>
		</tr>
		<tr>
			<td width="85%" class="text-right"><strong>Descuentos : </strong></td>
			<td class="text-right"><?php  echo number_format($ordenCompra["ComprasProductosTotale"]["descuento_total"], 0, '', '.');?></td>
		</tr>

		<tr>
			<td width="85%" class="text-right"><strong>Total Neto C/D: </strong></td>
			<td class="text-right">
				<?php echo number_format($ordenCompra["ComprasProductosTotale"]["neto_descuento"], 0, '', '.');?>
			</td>
		</tr>

		<tr>
			<td width="85%" class="text-right"><strong>
			<?php if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 1 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 2 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 17 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 21 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 19 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 20 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 22 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == ""): ?>
				Iva:
			<?php else :  ?>
			 Retencíon
			 <?php endif; ?> 
			</strong></td>
			<td class="text-right">
				<?php
					if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 1 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 17 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 20 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 22)
					{
						echo number_format($ordenCompra["ComprasProductosTotale"]["total"] - $ordenCompra["ComprasProductosTotale"]["neto_descuento"], 0, '', '.'); 
					}
					else if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 2 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 19 || $ordenCompra["ComprasProductosTotale"]["tipos_documento_id"] == 21 )
					{
						echo "0";//echo $ordenCompra["ComprasProductosTotale"]["neto_descuento"];
					}
					else
					{
						echo number_format(round($ordenCompra["ComprasProductosTotale"]["neto_descuento"] / 10), 0, '', '.');
					}
					
				?>
			</td>
		</tr>

		<tr>
			<td width="85%" class="text-right"><strong>Total: </strong></td>
			<td class="text-right">
				<?php
					echo number_format($ordenCompra["ComprasProductosTotale"]["total"], 0, '', '.');
				/*
					if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 1 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 17)
					{
						echo number_format($ordenCompra["ComprasProductosTotale"]["total"], 0, '', '.');
					}
					else if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 2 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 19)
					{
						echo number_format($ordenCompra["ComprasProductosTotale"]["neto_descuento"], 0, '', '.');
					}
					else if($ordenCompra["ComprasProductosTotale"]["impuesto"] == 3 || $ordenCompra["ComprasProductosTotale"]["impuesto"] == 18)
					{
						$retencion = $ordenCompra["ComprasProductosTotale"]["neto_descuento"] / 10;
						echo number_format($ordenCompra["ComprasProductosTotale"]["neto_descuento"] - $retencion, 0, '', '.');
					}
					*/
				?>
			</td>
		</tr>
	</tbody>
</table>
</div>
<?php if(!empty($perfilUsuario) && $perfilUsuario == "aprobadores"): ?>
	<div class="btn-group pull-right" role="group" aria-label="">
		<?php if($ordenCompra["ComprasProductosTotale"]["estado"] != 4) :?>

		<a href="<?php echo $this->Html->url(array("action"=>$aprobarCompra, $ordenCompra["ComprasProductosTotale"]["id"])); ?>"  class="btn btn-success btn-mx <?php echo $disableDos; ?>"><i class="fa fa-thumbs-o-up"></i> Aprobar</a>
		
		<a href=""  data-toggle="modal" data-target="<?php echo $rechazarCompra; ?>" class="btn btn-danger btn-mx <?php echo $disableTres; ?>"><i class="fa fa-thumbs-o-down"></i> Rechazar</a>
		<?php endif; ?>
		<!--a href=""  class="btn btn-warning printer"><i class="fa fa-print"></i> Imprimir</a-->
	  	<a href="<?php echo $this->Html->url(array("controller"=>"compras", "action"=>"aprobadores"))?>"  class="btn btn-info btn-mx"><i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
	  	
	</div>
<?php endif; ?>

<?php if(!empty($perfilUsuario) && $perfilUsuario == "ingreso_sap"): ?>
	<div class="btn-group pull-right" role="group" aria-label="">
		
		<a data-type="text" data-pk="<?php echo $ordenCompra["ComprasProductosTotale"]["id"]?>" id="codigoSap" href="#"  class="btn btn-success btn-mx codigoSap" data-url="<?php echo $this->Html->url(array("action"=>"aprobar_compra_sap")); ?>" data-title="Codigo SAP" style="border-bottom: 1px dashed #0088cc; text-decoration: none;"> <i class="fa fa-thumbs-o-up"></i> Ingresar a sap</a>


		<a href=""  data-toggle="modal" data-target="#compras_rechazar_sap" class="btn btn-danger btn-mx"><i class="fa fa-thumbs-o-down"></i> Rechazar</a>
		
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

<div class="modal fade" id="rechazo_requerimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  
    <div class="modal-content">
    	<?php echo $this->Form->create('Compras', array('action' => 'compras_rechazar')); ?>
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

<!--button type="button" class="btn btn-lg btn-danger" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">Click to toggle--> 
<script>
	$(function () {
  		$('[data-toggle="popover"]').popover({
  			//'placement': 'bottom',
  			'title' : 'Detalle',
  			'html' : true,
  			'trigger' : 'click',
  		});

  		$('[data-toggle="popoverDos"]').popover({
  			//'placement': 'bottom',
  			'title' : 'Detalle',
  			'html' : true,
  			'trigger' : 'click',
  		})


	})
    $(document).ready(function() {
    	
    	$('.tool').tooltip();

		$(".printer").click(function(){
			$(".print").printArea();
		});

		$(".backLink").click(function() {
			 var referrer =  document.referrer;
			 $(this).attr("href", referrer)
		});
		
	    $(document).ready(function() {
	    	$('.codigoSap').editable({
	    		placement : 'bottom',
	    		ajaxOptions: {
        			type: 'put'
    			},

    			success: function(response, newValue) {
    				if(!response.success)
    				{
    					window.location.href='<?php echo $this->Html->url(array('controller'=>'compras', 'action'=>'ingreso_sap'));?>'	
    				}
    			}
	    	});

	    	$('.codigoSap').on('click', function(){
	    		$('.editable-input input').val("");
	    	})
	    });
		
	});

	
</script>