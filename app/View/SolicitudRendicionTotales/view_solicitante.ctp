
<style>
.container{ width: 1350px; }
input {margin-top: 0px;}
</style>
	<div class="print" ng-controller="controllerEstadosRendicion" >
		<p class="mayuscula">Titulo : <?=$titulo ?></p>
			<div class="col-md-12">
				<div class="row clearfix">
					<div class="col-md-4 column">
						<div class="panel panel-default">
		  				<!-- Default panel contents -->
		  					<div class="panel-heading"><Strong>Creador</Strong></div>
							<!-- List group -->
							<ul class="list-group">
		  						<li class="list-group-item " title="Creador">Creador: <span class="mayuscula"><?=$usuario?></span></li>
		  						<li class="list-group-item list-group-item-success" title="Fecha creación">Fecha creación: <?=$fecha_documento?></li>
		  						<li class="list-group-item" title="Estado">Estado:

										<span  data-toggle="tooltip" data-placement="top" title=""><?=$estado?></span>
		  						</li>
								  <li class="list-group-item list-group-item-success" title="Fecha creación">N° Documento: <?=isset($n_documento)?$n_documento:'S/N'?></li>
		  					
							</ul>
						</div>
					</div>

					<div class="col-md-4 column">
						<div class="panel panel-default">
							<!-- Default panel contents -->
							<div class="panel-heading"><Strong>Información Fondo Rendir</Strong></div>
							<!-- List group -->
								<li class="list-group-item">Tipo de cambio: <?=$moneda_observada ?></li>
								<li class="list-group-item">Moneda: <?=$nombreMoneda?></li>
								<li class="list-group-item">Total: <?php
								$Totales = 0;
								foreach($listaRendicionFondo as $k => $j){
								
									$Totales = $Totales +	($j['SolicitudesRendicionFondo']['cantidad'] * $j['SolicitudesRendicionFondo']['precio']);
									
	
								}	
							echo number_format($Totales,0,',','.');
								
								
								?></li>
								<li class="list-group-item">Archivo:
									<?php 
										$arrayDoc = explode(",", $url_documento); 
										for($i=0;$i<count($arrayDoc);$i++){
											$arhivo = basename($arrayDoc[$i]);
											echo "<div class='row'>";
												echo "<a href=".acortarurl($arrayDoc[$i])." target='_blank'>$arhivo</a>";
											echo "</div>";
										}
									?> 
								</li>

								
							</ul>
						</div>
					</div>

					
					<div class="row">
					<strong><span>Observación:</span></strong> <?=$observacion?>						
					<br/>
					<br/>
				</div>
				</div>
								
			</div>
				<br/>
			<div style="width:100%; overflow:auto;">
				<span id="codigo_sap"></span>
				<input type="hidden" id="idRequerimiento" value="<?php echo $id; ?>" name="idRequerimiento">
				<table class="table table-striped table-bordered ">
					<thead>

					<tr>
				<th>Proveedor</th>
				<th>N° Folio</th>
				<th>Cantidad</th>
				<th>Descripción</th>	
				<th>Gerencia</th>
				<th>Estadios</th>
				<th>Contenido</th>
				<th>C. Distribución</th>
				<th>Otros</th>
				<th>Proyecto</th>
				<th>Cod. ptto.</th>
				<th>Precio.</th>
				<th>Sub Total.</th>				
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($listaRendicionFondo as $k => $j){
					echo "<tr>";
					echo "<td>".$j['SolicitudesRendicionFondo']['proveedor']."</td>";
					echo "<td>".$j['SolicitudesRendicionFondo']['n_folio']."</td>";
					echo "<td>".$j['SolicitudesRendicionFondo']['cantidad']."</td>";
					echo "<td>".$j['SolicitudesRendicionFondo']['producto']."</td>";
					echo "<td>".$j['SolicitudesRendicionFondo']['gerencia']."</td>";
					echo "<td>".$j['SolicitudesRendicionFondo']['estadios']."</td>";
					echo "<td>".$j['SolicitudesRendicionFondo']['contenido']."</td>";
					echo "<td>".$j['SolicitudesRendicionFondo']['canal_distribucion']."</td>";
					echo "<td>".$j['SolicitudesRendicionFondo']['otros']."</td>";
					echo "<td>".$j['SolicitudesRendicionFondo']['proyectos']."</td>";
					echo "<td>".$j['SolicitudesRendicionFondo']['codigo_presupuesto']."</td>";
					echo "<td>".number_format($j['SolicitudesRendicionFondo']['precio'],0,',','.')."</td>";
					echo "<td>".number_format(($j['SolicitudesRendicionFondo']['cantidad'] * $j['SolicitudesRendicionFondo']['precio']),0,',','.')."</td>";
					echo "<tr>";
				}	
			?>
					
					</tbody>
				</table>	
			</div>


		<div style="margin-left:15px">
			<div class="row">
						<a href="<?php echo $this->Html->url(array("action"=>"view_lista_fijos"));?>"  class="btn btn-info btn-mx"><i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
					</div>
			
		</div>
</div>


	

<?php
	function acortarurl($url){
		$uris = explode("html", $url);
		return $uris[1];
	}
       
		echo $this->Html->script(array(
			'bootstrap-datepicker',
			'angularjs/controladores/app',
			'angularjs/servicios/solicitudes_rendicion/solicitudesRendicion',
			'angularjs/controladores/solicitudes_rendicion/estadosRendicionFondoFijo',
			'angularjs/directivas/confirmacion'
        ));
        
       /* echo $this->Html->script(array(
            'bootstrap-datepicker',
            'angularjs/controladores/app',
            'angularjs/servicios/solicitudes_requerimiento_servicio/solicitudesRequerimiento',
            'angularjs/controladores/solicitudes_requerimientos_fondos/estado'
        ));*/
	?>

<!--div class="center col-md-8 col-md-offset-2" >
<div class="panel panel-info">
<div class="panel-heading"><h3>Información Solicitud Requerimientos de fondos</h3></div>
<div class="panel-body">

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Titulo:</div>
    <div class="col-sm-4"><? //$titulo ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Fecha:</div>
    <div class="col-sm-4"><? ///$fecha ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Usuario:</div>
    <div class="col-sm-4"><? //$user_id ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Monto:</div>
    <div class="col-sm-4"><? //$monto ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Tipo Moneda:</div>
    <div class="col-sm-4"><? //$tipos_moneda_id ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Tipo Fondo: </div>
    <div class="col-sm-4"><? //$tipo_fondo  ?> </div>
    </div>

     
</div>
</div>
</div>
<div class="center col-md-8 col-md-offset-2">
            <div class="row">
            <div class="col-sm-4">	
            <a href="" class="btn btn-info btn-mx"><i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
            </div>
            </div>
        </div>


<?php         
	/*echo $this->Html->script(array(
		'bootstrap-datepicker',
		'angularjs/controladores/app',
		'angularjs/servicios/solicitudes_requerimiento_servicio/solicitudesRequerimiento',
		'angularjs/controladores/solicitudes_requerimientos_fondos/estado'
	));*/
?>