<div class="center col-md-8 col-md-offset-2" >
<div class="panel panel-info">
<div class="panel-heading"><h3>Información Solicitud Requerimientos de fondos</h3></div>
<div class="panel-body">

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Titulo:</div>
    <div class="col-sm-4"><?= $titulo ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Fecha entrega fondo:</div>
    <div class="col-sm-4"><?= $fecha ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Usuario:</div>
    <div class="col-sm-4"><?= $user_id ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Monto:</div>
    <div class="col-sm-4"><?= number_format($monto,0,",",".") ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Tipo Moneda:</div>
    <div class="col-sm-4"><?= $tipos_moneda_id ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Moneda Observada:</div>
    <div class="col-sm-4"><?= $moneda_observada ?></div>
    </div>

    <!--div class="row">
    <div class="col-sm-4 col-md-offset-2">Presupuesto:</div>
    <div class="col-sm-4"><?//$codigos_presupuesto_id ?></div>
    </div-->

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Gerencia:</div>
    <div class="col-sm-4"><?= $dimensione_id ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Estadio:</div>
    <div class="col-sm-4"><?= $estadios ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Contenido:</div>
    <div class="col-sm-4"><?= $contenido?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Canal Distribución:</div>
    <div class="col-sm-4"><?= $canal_distribucion ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Otros:</div>
    <div class="col-sm-4"><?= $otros ?></div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Proyectos:</div>
    <div class="col-sm-4"><?= $proyectos ?></div>
    </div>

     <div class="row">
    <div class="col-sm-4 col-md-offset-2">Codigo Presupuestario: </div>
    <div class="col-sm-4"><?= $codigos_presupuesto_id  ?> </div>
    </div>

    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Tipo Fondo: </div>
    <div class="col-sm-4"><?= $tipo_fondo  ?> </div>
    </div>
    <div class="row">
    <div class="col-sm-4 col-md-offset-2">Observacion: </div>
    <div class="col-sm-4"><?= $observacion  ?> </div>
    </div>
</div>
</div>
</div>

        <div class="center col-md-8 col-md-offset-2">
            <div class="row">
            <div class="col-sm-4">	
            <a href="<?= $this->Html->url(array("controller"=>"solicitudes_requerimientos", "action"=>"view_lista"))?>" class="btn btn-info btn-mx" id="area"><i class="fa fa-mail-reply-all fa-mx "></i> Volver</a>
            </div>
            </div>
        </div>


<?php         
	echo $this->Html->script(array(
		'bootstrap-datepicker',
		'angularjs/controladores/app',
		'angularjs/servicios/solicitudes_requerimiento_servicio/solicitudesRequerimiento',
		'angularjs/controladores/solicitudes_requerimientos_fondos/estado'
	));
?>