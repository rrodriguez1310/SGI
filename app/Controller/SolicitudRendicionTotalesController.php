<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
/**
 * SolicitudRendicionTotales Controller
 *
 * @property SolicitudRendicionTotale $SolicitudRendicionTotale
 * @property PaginatorComponent $Paginator
 */
class SolicitudRendicionTotalesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
public function index() {

	$this->layout = 'angular';
	$this->SolicitudRendicionTotale->recursive = 0;
	//$this->set('solicitudRendicionTotales', $this->Paginator->paginate());
}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
public function view($id = null) {
	$this->layout = 'angular';
	$this->loadModel("SolicitudesRendicionFondo");
	$this->loadModel("User");
	$this->loadModel("ComprasTarjetasEstado");
	$this->loadModel("Company");
	$this->loadModel("SolicitudRendicionTotale");
	$this->loadModel("SolicitudesRequerimiento");
	$this->loadModel("MontosFondoFijo");
	$this->loadModel("TiposMoneda");
	
	if($this->Session->Read("Users.flag") != 0)
	{
		if($this->Session->Read("Accesos.accesoPagina") == 0)
		{
			$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
		}
	}
	else 
	{
		$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
		return $this->redirect(array("controller" => 'users', "action" => 'login'));
	}

	$listaRendicion = $this->SolicitudRendicionTotale->find('first',array(
		'conditions'=>array('SolicitudRendicionTotale.id' => $id, 'SolicitudRendicionTotale.tipo_fondo' =>2)
	));


	$nSolicitud = $this->SolicitudesRequerimiento->find('first', array(
		'conditions'=>array('SolicitudesRequerimiento.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'] )
	));

	$nombrelUser = $this->User->find('first', array(
		'conditions'=>array('User.id' => $listaRendicion['SolicitudRendicionTotale']['id_usuario'])
	));

	$estado = $this->ComprasTarjetasEstado->find('first', array(
		'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRendicion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])
	));

	$montoFijo = $this->MontosFondoFijo->find('first', array(
		'conditions'=>array('MontosFondoFijo.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'])
	));

	//if($nSolicitud['SolicitudesRequerimiento']['tipo_fondo']==2){
		$tipoFondo = "Fondo fijo";
		$moneda= "Peso Chileno";
		$monto = $montoFijo['MontosFondoFijo']['monto'];
		$observado = 'S/N';
	//}

	$this->set("id", $listaRendicion['SolicitudRendicionTotale']['id']);
	$this->set("fecha_documento", $listaRendicion['SolicitudRendicionTotale']['fecha_documento']);
	$this->set("n_solicitud_folio", $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio']);
	$this->set("monto", $montoFijo['MontosFondoFijo']['monto']);
	$this->set("titulo", $listaRendicion['SolicitudRendicionTotale']['titulo']);
	$this->set("url_documento", $listaRendicion['SolicitudRendicionTotale']['url_documento']);
	$this->set("observacion", $listaRendicion['SolicitudRendicionTotale']['observacion']);
	$this->set("total", $listaRendicion['SolicitudRendicionTotale']['total']);
	$this->set("nombreMoneda", $moneda);
	$this->set("tipo_fondo", $tipoFondo);
	$this->set("moneda_observada", $observado);
	$this->set("estado", $estado['ComprasTarjetasEstado']['descripcion']);
	$this->set("usuario", $nombrelUser['User']['nombre']);

	$listaRendicionFondo= $this->SolicitudesRendicionFondo->find('all', array(
		'conditions'=>array('SolicitudesRendicionFondo.id_solicitudes_rendicion_fondo'=> $listaRendicion['SolicitudRendicionTotale']['id'] )
	));

	if($estado['ComprasTarjetasEstado']['id']==1){
		$areas = array(4,7);
	}else{
		$areas =  array(1,5);
	}
	$this->set("tipo", $estado['ComprasTarjetasEstado']['id']);
	
	$this->set("listaRendicionFondo", $listaRendicionFondo);
	$listaEstado = $this->ComprasTarjetasEstado->find('list', array(
		'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
		'conditions'=>array('ComprasTarjetasEstado.id'=> $areas )
	));
	$this->set("listaEstado", $listaEstado);
	CakeLog::write('actividad', 'Visualiza solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	//exit;
}


public function view_edit_finanza($id = null) {
	$this->layout = 'angular';
	$this->loadModel("SolicitudesRendicionFondo");
	$this->loadModel("User");
	$this->loadModel("ComprasTarjetasEstado");
	$this->loadModel("Company");
	$this->loadModel("SolicitudRendicionTotale");
	$this->loadModel("SolicitudesRequerimiento");
	$this->loadModel("MontosFondoFijo");
	$this->loadModel("TiposMoneda");
	
	if($this->Session->Read("Users.flag") != 0)
	{
		if($this->Session->Read("Accesos.accesoPagina") == 0)
		{
			$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
		}
	}
	else 
	{
		$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
		return $this->redirect(array("controller" => 'users', "action" => 'login'));
	}

	$listaRendicion = $this->SolicitudRendicionTotale->find('first',array(
		'conditions'=>array('SolicitudRendicionTotale.id' => $id, 'SolicitudRendicionTotale.tipo_fondo' =>2)
	));


	$nSolicitud = $this->SolicitudesRequerimiento->find('first', array(
		'conditions'=>array('SolicitudesRequerimiento.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'] )
	));

	$nombrelUser = $this->User->find('first', array(
		'conditions'=>array('User.id' => $listaRendicion['SolicitudRendicionTotale']['id_usuario'])
	));

	$estado = $this->ComprasTarjetasEstado->find('first', array(
		'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRendicion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])
	));

	$montoFijo = $this->MontosFondoFijo->find('first', array(
		'conditions'=>array('MontosFondoFijo.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'])
	));

	//if($nSolicitud['SolicitudesRequerimiento']['tipo_fondo']==2){
		$tipoFondo = "Fondo fijo";
		$moneda= "Peso Chileno";
		$monto = $montoFijo['MontosFondoFijo']['monto'];
		$observado = 'S/N';
	//}

	$this->set("id", $listaRendicion['SolicitudRendicionTotale']['id']);
	$this->set("fecha_documento", $listaRendicion['SolicitudRendicionTotale']['fecha_documento']);
	$this->set("n_solicitud_folio", $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio']);
	$this->set("monto", $montoFijo['MontosFondoFijo']['monto']);
	$this->set("titulo", $listaRendicion['SolicitudRendicionTotale']['titulo']);
	$this->set("url_documento", $listaRendicion['SolicitudRendicionTotale']['url_documento']);
	$this->set("observacion", $listaRendicion['SolicitudRendicionTotale']['observacion']);
	$this->set("total", $listaRendicion['SolicitudRendicionTotale']['total']);
	$this->set("nombreMoneda", $moneda);
	$this->set("tipo_fondo", $tipoFondo);
	$this->set("moneda_observada", $observado);
	$this->set("estado", $estado['ComprasTarjetasEstado']['descripcion']);
	$this->set("usuario", $nombrelUser['User']['nombre']);

	$listaRendicionFondo= $this->SolicitudesRendicionFondo->find('all', array(
		'conditions'=>array('SolicitudesRendicionFondo.id_solicitudes_rendicion_fondo'=> $listaRendicion['SolicitudRendicionTotale']['id'] )
	));

	if($estado['ComprasTarjetasEstado']['id']==1){
		$areas = array(4,7);
	}else{
		$areas =  array(1,5);
	}
	$this->set("tipo", $estado['ComprasTarjetasEstado']['id']);
	
	$this->set("listaRendicionFondo", $listaRendicionFondo);
	$listaEstado = $this->ComprasTarjetasEstado->find('list', array(
		'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
		'conditions'=>array('ComprasTarjetasEstado.id'=> $areas )
	));
	$this->set("listaEstado", $listaEstado);
	CakeLog::write('actividad', 'Visualiza solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	//exit;
}


public function view_edit_area($id = null) {
	$this->layout = 'angular';
	$this->loadModel("SolicitudesRendicionFondo");
	$this->loadModel("User");
	$this->loadModel("ComprasTarjetasEstado");
	$this->loadModel("Company");
	$this->loadModel("SolicitudRendicionTotale");
	$this->loadModel("SolicitudesRequerimiento");
	$this->loadModel("MontosFondoFijo");
	$this->loadModel("TiposMoneda");
	
	if($this->Session->Read("Users.flag") != 0)
	{
		if($this->Session->Read("Accesos.accesoPagina") == 0)
		{
			$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
		}
	}
	else 
	{
		$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
		return $this->redirect(array("controller" => 'users', "action" => 'login'));
	}

	$listaRendicion = $this->SolicitudRendicionTotale->find('first',array(
		'conditions'=>array('SolicitudRendicionTotale.id' => $id, 'SolicitudRendicionTotale.tipo_fondo' =>2)
	));


	$nSolicitud = $this->SolicitudesRequerimiento->find('first', array(
		'conditions'=>array('SolicitudesRequerimiento.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'] )
	));

	$nombrelUser = $this->User->find('first', array(
		'conditions'=>array('User.id' => $listaRendicion['SolicitudRendicionTotale']['id_usuario'])
	));

	$estado = $this->ComprasTarjetasEstado->find('first', array(
		'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRendicion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])
	));

	$montoFijo = $this->MontosFondoFijo->find('first', array(
		'conditions'=>array('MontosFondoFijo.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'])
	));

	//if($nSolicitud['SolicitudesRequerimiento']['tipo_fondo']==2){
		$tipoFondo = "Fondo fijo";
		$moneda= "Peso Chileno";
		$monto = $montoFijo['MontosFondoFijo']['monto'];
		$observado = 'S/N';
	//}

	$this->set("id", $listaRendicion['SolicitudRendicionTotale']['id']);
	$this->set("fecha_documento", $listaRendicion['SolicitudRendicionTotale']['fecha_documento']);
	$this->set("n_solicitud_folio", $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio']);
	$this->set("monto", $montoFijo['MontosFondoFijo']['monto']);
	$this->set("titulo", $listaRendicion['SolicitudRendicionTotale']['titulo']);
	$this->set("url_documento", $listaRendicion['SolicitudRendicionTotale']['url_documento']);
	$this->set("observacion", $listaRendicion['SolicitudRendicionTotale']['observacion']);
	$this->set("total", $listaRendicion['SolicitudRendicionTotale']['total']);
	$this->set("nombreMoneda", $moneda);
	$this->set("tipo_fondo", $tipoFondo);
	$this->set("moneda_observada", $observado);
	$this->set("estado", $estado['ComprasTarjetasEstado']['descripcion']);
	$this->set("usuario", $nombrelUser['User']['nombre']);

	$listaRendicionFondo= $this->SolicitudesRendicionFondo->find('all', array(
		'conditions'=>array('SolicitudesRendicionFondo.id_solicitudes_rendicion_fondo'=> $listaRendicion['SolicitudRendicionTotale']['id'] )
	));

	if($estado['ComprasTarjetasEstado']['id']==1){
		$areas = array(4,7);
	}else{
		$areas =  array(1,5);
	}
	$this->set("tipo", $estado['ComprasTarjetasEstado']['id']);
	
	$this->set("listaRendicionFondo", $listaRendicionFondo);
	$listaEstado = $this->ComprasTarjetasEstado->find('list', array(
		'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
		'conditions'=>array('ComprasTarjetasEstado.id'=> $areas )
	));
	$this->set("listaEstado", $listaEstado);
	CakeLog::write('actividad', 'Visualiza solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	//exit;
}


/**
 * add method
 *
 * @return void
 */
	public function add($id) {

		$this->layout = 'angular';
		
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("MontosFondoFijo");
		/*if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}*/

		$vacio = array(""=>"");
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);


		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));

		if(!empty($empaques))
		{
			$empaques[0] = $vacio;
		    ksort($empaques);
			$this->set("empaques", $empaques);
		}

		$dimensionesProyectos = $this->DimensionesProyecto->find("all");

		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["id"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);

		$dimensiones = $this->Dimensione->find("all", array());

		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{

				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}
	
		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{

			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}

		$dimensionUno[0] = $vacio;
		ksort($dimensionUno);
		$this->set("dimensionUno", $dimensionUno);

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
		$dimensionDos[0] = $vacio;
		ksort($dimensionDos);
		$this->set("dimensionDos", $dimensionDos);

		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		$dimensionTres[0] = $vacio;
		ksort($dimensionTres);
		$this->set("dimensionTres", $dimensionTres);

		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		//array_unshift($dimensionCuatro, $vacio);
		$dimensionCuatro[0] = $vacio;
		ksort($dimensionCuatro);
		$this->set("dimensionCuatro", $dimensionCuatro);

		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		//array_unshift($dimensionCinco, $vacio);
		$dimensionCinco[0] = $vacio;
		ksort($dimensionCinco);
		$this->set("dimensionCinco", $dimensionCinco);

		$proveedores = $this->Company->find("list", array(
			"fields"=>array("Company.id", "Company.razon_social")
		));

		if(!empty($proveedores))
		{
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);   
		}
		$rutasDoc= array();
		if ($this->request->is('post')) {

			if(count($this->request['form']['file']['name'])>0){
				$destino = WWW_ROOT.'files'.DS.'solicitudFondos'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');		 
				if (!file_exists($destino))
				{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}

				for($i=0;$i<count($this->request['form']['file']['name']);$i++){
					$url = $destino . DS .$this->request['form']['file']['name'][$i];
					move_uploaded_file($this->request['form']['file']['tmp_name'][$i], $url);
					array_push($rutasDoc, $url);
				}
			}

			$datosFondosFolmulario = json_decode($this->request->data['rendicion']);
	
			$listaSolicituides = json_decode($this->request->data['lista']);

			$montoFijo = $this->SolicitudesRequerimiento->find('first', array(
				'conditions'=>array('SolicitudesRequerimiento.id'=> $id)
			));

			//$this->SolicitudesRequerimiento->create();
			//$this->request->data['SolicitudesRequerimiento']['id'] = $this->request->data['idFolio'];
			$this->request->data['SolicitudesRequerimiento']['estado_rendicion'] = 1;
			$this->request->data['SolicitudesRequerimiento']['estado_solicitud'] = 1;
			$this->request->data['SolicitudesRequerimiento']['user_id'] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data['SolicitudesRequerimiento']['tipos_moneda_id'] = isset($montoFijo['SolicitudesRequerimiento']['tipos_moneda_id'])?$montoFijo['SolicitudesRequerimiento']['tipos_moneda_id']:'';
			$this->request->data['SolicitudesRequerimiento']['tipo_fondo'] = 1;
			$this->request->data['SolicitudesRequerimiento']['fecha'] = date('Y-m-d');
			$this->request->data['SolicitudesRequerimiento']['id'] = $id;
			//$this->request->data['SolicitudesRequerimiento']['dimensione_id'] = $codigoDimensionId['Dimensione']['codigo'];
			$this->SolicitudesRequerimiento->save($this->request->data);

			$this->request->data['SolicitudRendicionTotale']['fecha_documento'] = $datosFondosFolmulario->fecha_documento;
			$this->request->data['SolicitudRendicionTotale']['titulo'] = $montoFijo['SolicitudesRequerimiento']['titulo'];
			//$this->request->data['SolicitudRendicionTotale']['plazos_pago_id'] = $datosFondosFolmulario->plazos_pago_id;
			$this->request->data['SolicitudRendicionTotale']['tipo_fondo'] = $montoFijo['SolicitudesRequerimiento']['tipo_fondo'];
			$this->request->data['SolicitudRendicionTotale']['url_documento'] = implode(",", $rutasDoc);
			$this->request->data['SolicitudRendicionTotale']['observacion'] = $datosFondosFolmulario->observacion;
			$this->request->data['SolicitudRendicionTotale']['total'] = $this->request->data['total'];
			$this->request->data['SolicitudRendicionTotale']['n_solicitud_folio'] = $id;
			$this->request->data['SolicitudRendicionTotale']['compras_tarjeta_estado_id']= 3;
			$this->request->data['SolicitudRendicionTotale']['id_usuario']=$this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data['SolicitudRendicionTotale']['estado_solicitud']=1; 

			if ($this->SolicitudRendicionTotale->save($this->request->data)) {

			} else {
				$this->Session->setFlash(__('The solicitud rendicion totale could not be saved. Please, try again.'));
			}

	
			for($i=0;$i<count($listaSolicituides);$i++){
				$this->SolicitudesRendicionFondo->create();

						$this->request->data['cantidad'] = $listaSolicituides[$i]->cantidad;
						$this->request->data['proveedor'] = $listaSolicituides[$i]->proveedor;
						$this->request->data['n_folio'] = $listaSolicituides[$i]->n_folio;
						$this->request->data['codigo_presupuesto'] = $listaSolicituides[$i]->codigoPresupuestario;
						$this->request->data['descuento_producto'] = $listaSolicituides[$i]->descuento_producto;
						$this->request->data['descuento_producto_peso'] = $listaSolicituides[$i]->descuento_producto_peso;
						$this->request->data['otros'] = $listaSolicituides[$i]->dimCinco;
						$this->request->data['canal_distribucion'] = $listaSolicituides[$i]->dimCuatro;
						$this->request->data['estadios'] = $listaSolicituides[$i]->dimDos;
						$this->request->data['contenido'] = $listaSolicituides[$i]->dimTres;
						$this->request->data['fecha_creacion'] = date('Y-m-d');
						$this->request->data['gerencia'] = $listaSolicituides[$i]->dimUno;
						$this->request->data['empaque'] = $listaSolicituides[$i]->empaque;
						$this->request->data['precio'] = str_replace (".","",$listaSolicituides[$i]->precio);
						$this->request->data['producto'] = $listaSolicituides[$i]->producto;
						$this->request->data['proyectos'] = $listaSolicituides[$i]->proyecto;
						$this->request->data['tipo_impuesto'] = $listaSolicituides[$i]->tipo_impuesto;
						$this->request->data['id_solicitudes_rendicion_fondo'] = $this->SolicitudRendicionTotale->getInsertID();
						$this->actualiza($id, 10);
				if ($this->SolicitudesRendicionFondo->save($this->request->data)) {
					CakeLog::write('actividad', 'Agrega solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				} else {
					$this->Session->setFlash(__('The solicitud rendicion totale could not be saved. Please, try again.'));
				}
			}
		}
		exit;
	}



	public function add_fondo_fijo() {

		$this->layout = 'angular';
		
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("MontosFondoFijo");
		
		$vacio = array(""=>"");
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);
		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));

		if(!empty($empaques))
		{
			$empaques[0] = $vacio;
			ksort($empaques);
			$this->set("empaques", $empaques);
		}
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		$proyectos = "";
		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["id"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);

		$dimensiones = $this->Dimensione->find("all", array());

		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{

				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}
	
		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{

			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}
		$dimensionUno[0] = $vacio;
		ksort($dimensionUno);
		$this->set("dimensionUno", $dimensionUno);

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
		$dimensionDos[0] = $vacio;
		ksort($dimensionDos);
		$this->set("dimensionDos", $dimensionDos);

		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		$dimensionTres[0] = $vacio;
		ksort($dimensionTres);
		$this->set("dimensionTres", $dimensionTres);

		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		$dimensionCuatro[0] = $vacio;
		ksort($dimensionCuatro);
		$this->set("dimensionCuatro", $dimensionCuatro);

		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		$dimensionCinco[0] = $vacio;
		ksort($dimensionCinco);
		$this->set("dimensionCinco", $dimensionCinco);

		$proveedores = $this->Company->find("list", array(
			"fields"=>array("Company.id", "Company.razon_social")
		));

		if(!empty($proveedores))
		{
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);   
		}
		$rutasDoc = array();
		if ($this->request->is('post')) {
			if(count($this->request['form']['file']['name'])>0){
				$destino = WWW_ROOT.'files'.DS.'solicitudFondos'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');		 
				if (!file_exists($destino))
				{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}

				for($i=0;$i<count($this->request['form']['file']['name']);$i++){
					$url = $destino . DS .$this->request['form']['file']['name'][$i];
					move_uploaded_file($this->request['form']['file']['tmp_name'][$i], $url);
					array_push($rutasDoc, $url);
				}
			}

			$datosFondosFolmulario = json_decode($this->request->data['rendicion']);
			$montoFijo = $this->MontosFondoFijo->find('first', array(
				'conditions'=>array('MontosFondoFijo.id'=> $this->request->data['idFolio'])
			));
	
			$codigoDimensionId = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo_corto'=> $montoFijo['MontosFondoFijo']['area'])
			));

			$this->request->data['SolicitudRendicionTotale']['fecha_documento'] = $datosFondosFolmulario->fecha_documento;
			$this->request->data['SolicitudRendicionTotale']['titulo'] = $datosFondosFolmulario->titulo;
			//$this->request->data['SolicitudRendicionTotale']['plazos_pago_id'] = $datosFondosFolmulario->plazos_pago_id;
			$this->request->data['SolicitudRendicionTotale']['total'] = str_replace (".","",$this->request->data['total']);
			$this->request->data['SolicitudRendicionTotale']['url_documento'] = implode(",", $rutasDoc);
			$this->request->data['SolicitudRendicionTotale']['observacion'] = isset($datosFondosFolmulario->observacion)?$datosFondosFolmulario->observacion:'S/N';
			$this->request->data['SolicitudRendicionTotale']['n_solicitud_folio'] = $this->request->data['idFolio'];
			$this->request->data['SolicitudRendicionTotale']['compras_tarjeta_estado_id']= 3;
			$this->request->data['SolicitudRendicionTotale']['tipo_fondo']= 2;
			$this->request->data['SolicitudRendicionTotale']['estado_solicitud']= 1;
			$this->request->data['SolicitudRendicionTotale']['id_usuario']=$this->Session->read('PerfilUsuario.idUsuario');
			if ($this->SolicitudRendicionTotale->save($this->request->data)) {

			} else {
				$this->Session->setFlash(__('The solicitud rendicion totale could not be saved. Please, try again.'));
			}

			$listaSolicituides = json_decode($this->request->data['lista']);

			for($i=0;$i<count($listaSolicituides);$i++){
				$this->SolicitudesRendicionFondo->create();

						$this->request->data['cantidad'] = $listaSolicituides[$i]->cantidad;
						$this->request->data['proveedor'] = $listaSolicituides[$i]->proveedor;
						$this->request->data['n_folio'] = $listaSolicituides[$i]->n_folio;
						$this->request->data['codigo_presupuesto'] = $listaSolicituides[$i]->codigoPresupuestario;
						$this->request->data['descuento_producto'] = $listaSolicituides[$i]->descuento_producto;
						$this->request->data['descuento_producto_peso'] = $listaSolicituides[$i]->descuento_producto_peso;
						$this->request->data['otros'] = $listaSolicituides[$i]->dimCinco;
						$this->request->data['canal_distribucion'] = $listaSolicituides[$i]->dimCuatro;
						$this->request->data['estadios'] = $listaSolicituides[$i]->dimDos;
						$this->request->data['contenido'] = $listaSolicituides[$i]->dimTres;
						$this->request->data['fecha_creacion'] = date('Y-m-d');
						$this->request->data['gerencia'] = $listaSolicituides[$i]->dimUno;
						$this->request->data['empaque'] = $listaSolicituides[$i]->empaque;
						$this->request->data['precio'] = str_replace (".","",$listaSolicituides[$i]->precio);
						$this->request->data['producto'] = $listaSolicituides[$i]->producto;
						$this->request->data['proyectos'] = $listaSolicituides[$i]->proyecto;
						$this->request->data['tipo_impuesto'] = $listaSolicituides[$i]->tipo_impuesto;
						$this->request->data['id_solicitudes_rendicion_fondo'] = $this->SolicitudRendicionTotale->getInsertID();
						//$this->actualiza($this->request->data['idFolio'], 1);
				if ($this->SolicitudesRendicionFondo->save($this->request->data)) {
					CakeLog::write('actividad', 'Agrega solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				} else {
					$this->Session->setFlash(__('The solicitud rendicion totale could not be saved. Please, try again.'));
				}
			}
		}
		exit;
	}


	public function edit_fondo_rendir() {

		Configure::write('debug', 0); 

		$this->layout = null;
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("DimensionesCodigosCorto");


		$vacio = array(""=>"");
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);


		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));

		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}

		$dimensionesProyectos = $this->DimensionesProyecto->find("all");

		$proyectos = "";
		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["id"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);
		$this->set("proyectos", $proyectos);
		$dimensiones = $this->Dimensione->find("all", array());
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}
	
		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}
		$this->set("dimensionUno", $dimensionUno);

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);

		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);

		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);

		$dimensionCinco = "";

		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{	
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);

		$proveedores = $this->Company->find("list", array(
			"fields"=>array("Company.id", "Company.razon_social")
		));

		if(!empty($proveedores))
		{
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);   
		}
		$rutasDoc = array();
		if ($this->request->is(array('post', 'put'))) {

			if ($this->request->is('post')) {
			$this->request->data['SolicitudRendicionTotale']['id'] = $this->request->data['id'];
			if(count($this->request['form']['file']['name'])>0){
				$destino = WWW_ROOT.'files'.DS.'solicitudFondos'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');		 
				if (!file_exists($destino))
				{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}

				for($i=0;$i<count($this->request['form']['file']['name']);$i++){
					$url = $destino . DS .$this->request['form']['file']['name'][$i];
					move_uploaded_file($this->request['form']['file']['tmp_name'][$i], $url);
					array_push($rutasDoc, $url);
				}
			}

		$datosFondosFolmulario = json_decode($this->request->data['rendicion']);
		$this->SolicitudRendicionTotale->data['fecha_documento'] = $datosFondosFolmulario->fecha_documento;
		$this->SolicitudRendicionTotale->data['titulo'] = $datosFondosFolmulario->titulo;
		//$this->SolicitudRendicionTotale->data['plazos_pago_id'] = $datosFondosFolmulario->plazos_pago_id;
		//$this->SolicitudRendicionTotale->data['company_id'] = $datosFondosFolmulario->company_id;
		$this->SolicitudRendicionTotale->data['observacion'] = $datosFondosFolmulario->observacion;
		$this->SolicitudRendicionTotale->data['total'] = $this->request->data['total'];
		$this->SolicitudRendicionTotale->data['n_solicitud_folio'] = $this->request->data['idFolio'];
		$this->SolicitudRendicionTotale->data['compras_tarjeta_estado_id']= 3;
		$this->SolicitudRendicionTotale->data['id_usuario']=$this->Session->read('PerfilUsuario.idUsuario');
		$this->SolicitudRendicionTotale->data['id']= $this->request->data['id'];
		if(count($rutasDoc)>0){
			$this->SolicitudRendicionTotale->data['url_documento'] = implode(",", $rutasDoc);
		}


		if ($this->SolicitudRendicionTotale->save($this->SolicitudRendicionTotale->data)) {
			$requerimiento = $this->SolicitudesRequerimiento->find('first', array(
				'conditions'=>array('SolicitudesRequerimiento.id'=> $this->request->data['idFolio'])
			));
			$codigoCorto = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $requerimiento['SolicitudesRequerimiento']['dimensione_id'])
			));

			if(empty($codigoCorto['Dimensione']['codigo_corto'])){
				//echo "entre 1 ".$codigoCorto['Dimensione']['nombre'];
				$idCodigoCorto = $this->DimensionesCodigosCorto->find('first', array(
					'conditions'=>array('DimensionesCodigosCorto.descripcion '=>$codigoCorto['Dimensione']['nombre'])
				));

				$codigoCorto = $idCodigoCorto['DimensionesCodigosCorto']['nombre'];
			}else{
				//echo "entre 2";
				$codigoCorto = $codigoCorto['Dimensione']['codigo_corto'];
			}
			$aprobador = $this->EmailsAprobador->find('all', array(
				'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$codigoCorto, 'EmailsAprobador.modulo' =>'fondos')
			));

			$envioEmail=[];
			foreach($aprobador as $k=>$j){
				array_push($envioEmail, $j['EmailsAprobador']['emails']);
			}

			$nombrelUser = $this->User->find('first', array(
				'conditions'=>array('User.id' => $this->Session->read('PerfilUsuario.idUsuario'))
			));
			$Email = new CakeEmail("gmail");
			$Email->from(array('sgi@cdf.cl' => 'SGI'));
			$Email->to($envioEmail);//($email[0]["Email"]["email"]);
			$Email->subject("Actualización rendicion de fondos");
			$Email->emailFormat('html');
			$Email->template('solicitud_rendicion_fondo_fijo');
			$Email->viewVars(array(
				"tipo_fondo"=>'Fondo fijo',
				"usuario"=>$nombrelUser['User']['nombre'],
				"titulo"=>$datosFondosFolmulario->titulo,
				"folio"=>$this->request->data['idFolio'],
				"fecha"=>$datosFondosFolmulario->fecha_documento,
				"destino"=>'solicitudes_requerimientos/',
			));
			$Email->send();
		
			$this->Session->setFlash(__('The solicitud rendicion totale has been saved.'));
			CakeLog::write('actividad', 'Edita solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		} else {
			$this->Session->setFlash(__('The solicitud rendicion totale could not be saved. Please, try again.'));
		}
	} 
	
	$this->SolicitudesRendicionFondo->deleteAll(array('SolicitudesRendicionFondo.id_solicitudes_rendicion_fondo' => $this->request->data['id']));
	$listaSolicituides = json_decode($this->request->data['lista']);

			for($i=0;$i<count($listaSolicituides);$i++){
				$this->SolicitudesRendicionFondo->create();
				$this->SolicitudesRendicionFondo->data['cantidad'] = $listaSolicituides[$i]->cantidad;
				$this->SolicitudesRendicionFondo->data['proveedor'] = $listaSolicituides[$i]->proveedor;
				$this->SolicitudesRendicionFondo->data['n_folio'] = $listaSolicituides[$i]->n_folio;
				$this->SolicitudesRendicionFondo->data['codigo_presupuesto'] = $listaSolicituides[$i]->codigoPresupuestario;
				$this->SolicitudesRendicionFondo->data['descuento_producto'] = $listaSolicituides[$i]->descuento_producto;
				$this->SolicitudesRendicionFondo->data['descuento_producto_peso'] = $listaSolicituides[$i]->descuento_producto_peso;
				$this->SolicitudesRendicionFondo->data['otros'] = $listaSolicituides[$i]->dimCinco;
				$this->SolicitudesRendicionFondo->data['canal_distribucion'] = $listaSolicituides[$i]->dimCuatro;
				$this->SolicitudesRendicionFondo->data['estadios'] = $listaSolicituides[$i]->dimDos;
				$this->SolicitudesRendicionFondo->data['contenido'] = $listaSolicituides[$i]->dimTres;
				$this->SolicitudesRendicionFondo->data['fecha_creacion'] = date('Y-m-d');
				$this->SolicitudesRendicionFondo->data['gerencia'] = $listaSolicituides[$i]->dimUno;
				$this->SolicitudesRendicionFondo->data['empaque'] = $listaSolicituides[$i]->empaque;
				$this->SolicitudesRendicionFondo->data['precio'] = str_replace (".","",$listaSolicituides[$i]->precio);
				$this->SolicitudesRendicionFondo->data['producto'] = $listaSolicituides[$i]->producto;
				$this->SolicitudesRendicionFondo->data['proyectos'] = $listaSolicituides[$i]->proyecto;
				$this->SolicitudesRendicionFondo->data['tipo_impuesto'] = $listaSolicituides[$i]->tipo_impuesto;
				$this->SolicitudesRendicionFondo->data['id_solicitudes_rendicion_fondo'] = $this->request->data['id'];
				$this->actualiza($this->request->data['idFolio'], 10);

				$this->SolicitudesRendicionFondo->save($this->SolicitudesRendicionFondo->data);

			}
		}

		exit;
	}

	public function edit() {

		/*$this->layout = 'angular';
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("DimensionesCodigosCorto");

		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}

		$vacio = array(""=>"");
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);


		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));

		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}

		$dimensionesProyectos = $this->DimensionesProyecto->find("all");

		$proyectos = "";
		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["id"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);
		$this->set("proyectos", $proyectos);
		$dimensiones = $this->Dimensione->find("all", array());
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}
	
		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}
		$this->set("dimensionUno", $dimensionUno);

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);

		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);

		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);

		$dimensionCinco = "";

		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{	
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);

		$proveedores = $this->Company->find("list", array(
			"fields"=>array("Company.id", "Company.razon_social")
		));

		if(!empty($proveedores))
		{
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);   
		}
		$rutasDoc = array();
		if ($this->request->is(array('post', 'put'))) {

			if ($this->request->is('post')) {
			$this->request->data['SolicitudRendicionTotale']['id'] = $this->request->data['id'];
			if(count($this->request['form']['file']['name'])>0){
				$destino = WWW_ROOT.'files'.DS.'solicitudFondos'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');		 
				if (!file_exists($destino))
				{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}

				for($i=0;$i<count($this->request['form']['file']['name']);$i++){
					$url = $destino . DS .$this->request['form']['file']['name'][$i];
					move_uploaded_file($this->request['form']['file']['tmp_name'][$i], $url);
					array_push($rutasDoc, $url);
				}
			}

		$datosFondosFolmulario = json_decode($this->request->data['rendicion']);
		$this->SolicitudRendicionTotale->data['fecha_documento'] = $datosFondosFolmulario->fecha_documento;
		$this->SolicitudRendicionTotale->data['titulo'] = $datosFondosFolmulario->titulo;
		//$this->SolicitudRendicionTotale->data['plazos_pago_id'] = $datosFondosFolmulario->plazos_pago_id;
		//$this->SolicitudRendicionTotale->data['company_id'] = $datosFondosFolmulario->company_id;
		$this->SolicitudRendicionTotale->data['observacion'] = $datosFondosFolmulario->observacion;
		$this->SolicitudRendicionTotale->data['total'] = $this->request->data['total'];
		$this->SolicitudRendicionTotale->data['n_solicitud_folio'] = $this->request->data['idFolio'];
		$this->SolicitudRendicionTotale->data['estado']= 3;
		$this->SolicitudRendicionTotale->data['id_usuario']=$this->Session->read('PerfilUsuario.idUsuario');
		$this->SolicitudRendicionTotale->data['id']= $this->request->data['id'];
		if(count($rutasDoc)>0){
			$this->SolicitudRendicionTotale->data['url_documento'] = implode(",", $rutasDoc);
		}


		if ($this->SolicitudRendicionTotale->save($this->SolicitudRendicionTotale->data)) {
			$requerimiento = $this->SolicitudesRequerimiento->find('first', array(
				'conditions'=>array('SolicitudesRequerimiento.id'=> $this->request->data['idFolio'])
			));
			$codigoCorto = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $requerimiento['SolicitudesRequerimiento']['dimensione_id'])
			));

			if(empty($codigoCorto['Dimensione']['codigo_corto'])){
				//echo "entre 1 ".$codigoCorto['Dimensione']['nombre'];
				$idCodigoCorto = $this->DimensionesCodigosCorto->find('first', array(
					'conditions'=>array('DimensionesCodigosCorto.descripcion '=>$codigoCorto['Dimensione']['nombre'])
				));

				$codigoCorto = $idCodigoCorto['DimensionesCodigosCorto']['nombre'];
			}else{
				//echo "entre 2";
				$codigoCorto = $codigoCorto['Dimensione']['codigo_corto'];
			}
			$aprobador = $this->EmailsAprobador->find('all', array(
				'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$codigoCorto, 'EmailsAprobador.modulo' =>'fondos')
			));

			$envioEmail=[];
			foreach($aprobador as $k=>$j){
				array_push($envioEmail, $j['EmailsAprobador']['emails']);
			}

			$nombrelUser = $this->User->find('first', array(
				'conditions'=>array('User.id' => $this->Session->read('PerfilUsuario.idUsuario'))
			));
			$Email = new CakeEmail("gmail");
			$Email->from(array('sgi@cdf.cl' => 'SGI'));
			$Email->to($envioEmail);//($email[0]["Email"]["email"]);
			$Email->subject("Actualización rendicion de fondos");
			$Email->emailFormat('html');
			$Email->template('solicitud_rendicion_fondo_fijo');
			$Email->viewVars(array(
				"tipo_fondo"=>'Fondo fijo',
				"usuario"=>$nombrelUser['User']['nombre'],
				"titulo"=>$datosFondosFolmulario->titulo,
				"folio"=>$this->request->data['idFolio'],
				"fecha"=>$datosFondosFolmulario->fecha_documento,
				"destino"=>'solicitudes_requerimientos/',
			));
			$Email->send();
		
			$this->Session->setFlash(__('The solicitud rendicion totale has been saved.'));
			CakeLog::write('actividad', 'Edita solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		} else {
			$this->Session->setFlash(__('The solicitud rendicion totale could not be saved. Please, try again.'));
		}
	} 
	
	$this->SolicitudesRendicionFondo->deleteAll(array('SolicitudesRendicionFondo.id_solicitudes_rendicion_fondo' => $this->request->data['id']));
	$listaSolicituides = json_decode($this->request->data['lista']);

			for($i=0;$i<count($listaSolicituides);$i++){
				$this->SolicitudesRendicionFondo->create();
				$this->SolicitudesRendicionFondo->data['cantidad'] = $listaSolicituides[$i]->cantidad;
				$this->SolicitudesRendicionFondo->data['proveedor'] = $listaSolicituides[$i]->proveedor;
				$this->SolicitudesRendicionFondo->data['n_folio'] = $listaSolicituides[$i]->n_folio;
				$this->SolicitudesRendicionFondo->data['codigo_presupuesto'] = $listaSolicituides[$i]->codigoPresupuestario;
				$this->SolicitudesRendicionFondo->data['descuento_producto'] = $listaSolicituides[$i]->descuento_producto;
				$this->SolicitudesRendicionFondo->data['descuento_producto_peso'] = $listaSolicituides[$i]->descuento_producto_peso;
				$this->SolicitudesRendicionFondo->data['otros'] = $listaSolicituides[$i]->dimCinco;
				$this->SolicitudesRendicionFondo->data['canal_distribucion'] = $listaSolicituides[$i]->dimCuatro;
				$this->SolicitudesRendicionFondo->data['estadios'] = $listaSolicituides[$i]->dimDos;
				$this->SolicitudesRendicionFondo->data['contenido'] = $listaSolicituides[$i]->dimTres;
				$this->SolicitudesRendicionFondo->data['fecha_creacion'] = date('Y-m-d');
				$this->SolicitudesRendicionFondo->data['gerencia'] = $listaSolicituides[$i]->dimUno;
				$this->SolicitudesRendicionFondo->data['empaque'] = $listaSolicituides[$i]->empaque;
				$this->SolicitudesRendicionFondo->data['precio'] = str_replace (".","",$listaSolicituides[$i]->precio);
				$this->SolicitudesRendicionFondo->data['producto'] = $listaSolicituides[$i]->producto;
				$this->SolicitudesRendicionFondo->data['proyectos'] = $listaSolicituides[$i]->proyecto;
				$this->SolicitudesRendicionFondo->data['tipo_impuesto'] = $listaSolicituides[$i]->tipo_impuesto;
				$this->SolicitudesRendicionFondo->data['id_solicitudes_rendicion_fondo'] = $this->request->data['id'];
				$this->actualiza($this->request->data['idFolio'], 10);

				$this->SolicitudesRendicionFondo->save($this->SolicitudesRendicionFondo->data);

			}
		}*/
	}


	public function actualiza($idFondo,$estado ){
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['SolicitudesRequerimiento']['id'] = $idFondo;
			$this->request->data['SolicitudesRequerimiento']['compras_tarjeta_estado_id'] = $estado;

			if ($this->SolicitudesRequerimiento->save($this->request->data)) {
				$this->Session->setFlash('Solicitudes requerimiento ingresado.', 'msg_exito');
				CakeLog::write('actividad', 'Actualiza solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			//	return $this->redirect(array('action' => 'view_solicitud'));
			} else {
				$this->Session->setFlash(__('The solicitudes requerimiento could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SolicitudesRequerimiento.' . $this->SolicitudesRequerimiento->primaryKey => $id));
			$this->request->data = $this->SolicitudesRequerimiento->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->loadModel("SolicitudesRequerimiento");

		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}

		//pr($id);
		//exit;
		if ($this->request->is(array('get', 'put'))) {
			$this->request->data['SolicitudRendicionTotale']['id']=$id;
			$this->request->data['SolicitudRendicionTotale']['estado_solicitud']=0;
			if ($this->SolicitudRendicionTotale->save($this->request->data)) {
				$this->Session->setFlash('Solicitud de requerimiento fondo fijo eliminada.', 'msg_exito');
				CakeLog::write('actividad', 'Elimina Solcitud Fondos fijos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				return $this->redirect(array('action' => 'view_lista_fijos'));
			}
		}	
	}

	public function add_rendicion_fondos(){
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("Company");

		$this->layout = null;

		/*if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}*/


		if(isset($this->request->data['datos']['proyecto'])){
			$proyectos = $this->DimensionesProyecto->find("first",array(
				'conditions'=>array('DimensionesProyecto.codigo' =>$this->request->data['datos']['proyecto'])
			));
		}
		
		if(isset($this->request->data['datos']['dimUno'])){
			$gerencia = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->data['datos']['dimUno'])
			));
		}	
		if(isset($this->request->data['datos']['dimDos'])){
			$estadios = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->data['datos']['dimDos'])
			));
		}
		if(isset($this->request->data['datos']['dimTres'])){
			$proveedor = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->data['datos']['dimTres'])
			));
		}
		if(isset($this->request->data['datos']['dimCuatro'])){
			$contenido = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->data['datos']['dimCuatro'])
			));
		}
		if(isset($this->request->data['datos']['dimCinco'])){
			$canal = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->data['datos']['dimCinco'])
			));
		}

		if(isset($this->request->data['datos']['codigoPresupuestario'])){
			$presupuesto = $this->CodigosPresupuesto->find("first",array(
				'conditions'=>array('CodigosPresupuesto.id' =>$this->request->data['datos']['codigoPresupuestario'])
			));
		}
		if(isset($this->request->data['datos']['company_id'])){
			$proveedores2 = $this->Company->find("first", array(
				"conditions"=>array("Company.id"=>$this->request->data['datos']['company_id'])
			));
		}
		if(count($this->request->data['datos'])>0){
			$salida = array(
				'cantidad'=>isset($this->request->data['datos']['cantidad'])?$this->request->data['datos']['cantidad']:'S/N',
				'n_folio'=>isset($this->request->data['datos']['n_folio'])?$this->request->data['datos']['n_folio']:'S/N',
				'proveedor'=>isset($proveedores2['Company']['nombre'])?$proveedores2['Company']['nombre']:'S/N',
				'codigoPresupuestario'=>isset($presupuesto['CodigosPresupuesto']['nombre'])?$presupuesto['CodigosPresupuesto']['nombre']:'S/N',
				'descuento_producto'=>isset($this->request->data['datos']['descuento_producto'])?$this->request->data['datos']['descuento_producto']:'S/N',
				'descuento_producto_peso'=>isset($this->request->data['datos']['descuento_producto_peso'])?$this->request->data['datos']['descuento_producto_peso']:'S/N',
				'dimCinco'=>isset($canal['Dimensione']['nombre'])?$canal['Dimensione']['nombre']:'S/N',
				'dimCuatro'=>isset($contenido['Dimensione']['nombre'])?$contenido['Dimensione']['nombre']:'S/N',
				'dimDos'=>isset($estadios['Dimensione']['nombre'])?$estadios['Dimensione']['nombre']:'S/N',
				'dimTres'=>isset($proveedor['Dimensione']['nombre'])?$proveedor['Dimensione']['nombre']:'S/N',
				'dimUno'=>$gerencia['Dimensione']['nombre'],
				'empaque'=>isset($this->request->data['datos']['empaque'])?$this->request->data['datos']['empaque']:'S/N',
				'precio'=>number_format(str_replace (".","",$this->request->data['datos']['precio']),0,",","."),
				'producto'=>$this->request->data['datos']['producto'],
				'sub'=>number_format((str_replace (".","",$this->request->data['datos']['precio']) * $this->request->data['datos']['cantidad']),0,",","."),
				'proyecto'=>isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
				'tipo_impuesto'=>'S/N'
			);
			CakeLog::write('actividad', 'Lista solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	        echo json_encode($salida);
		}
		exit;
	}



	public function edit_rendicion_fondos(){
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("Company");
		
		$this->layout = null;

		/*if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}*/

		if(isset($this->request->query['proyecto'])){
			$proyectos = $this->DimensionesProyecto->find("first",array(
				'conditions'=>array('DimensionesProyecto.codigo' =>$this->request->query['proyecto'])
			));
		}
		
		if(isset($this->request->query['dimUno'])){
			$gerencia = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimUno'])
			));
		}
		if(isset($this->request->query['dimDos'])){
			$estadios = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimDos'])
			));
		}
		if(isset($this->request->query['dimTres'])){
			$proveedor = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimTres'])
			));
		}
		if(isset($this->request->query['dimCuatro'])){
			$contenido = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimCuatro'])
			));
		}
		if(isset($this->request->query['dimCinco'])){
			$canal = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimCinco'])
			));
		}
		if(isset($this->request->query['codigoPresupuestario'])){
			$presupuesto = $this->CodigosPresupuesto->find("first",array(
				'conditions'=>array('CodigosPresupuesto.id' =>$this->request->query['codigoPresupuestario'])
			));
		}

		/**
		 * Obtiene lista de datos ingresados
		 * 
		*/


		$ProductosCompra = $this->SolicitudesRendicionFondo->find("all",array(
			'conditions'=>array('SolicitudesRendicionFondo.id_solicitudes_rendicion_fondo' =>$this->request->query['id'])
		));

	//$i=1;
		if(count($this->request->query)>0){
			//echo $i;
			if(count($ProductosCompra)>0){
				
				foreach($ProductosCompra as $h => $j){
			
					$salida1[] = array(
						'id'=>$j['SolicitudesRendicionFondo']['id'],
						'cantidad'=>$j['SolicitudesRendicionFondo']['cantidad'],
						'n_folio'=>$j['SolicitudesRendicionFondo']['n_folio'],
						'proveedor'=>$j['SolicitudesRendicionFondo']['proveedor'],
						'codigoPresupuestario'=>$j['SolicitudesRendicionFondo']['codigo_presupuesto'],
						'descuento_producto'=>$j['SolicitudesRendicionFondo']['descuento_producto'],
						'descuento_producto_peso'=>$j['SolicitudesRendicionFondo']['descuento_producto_peso'],
						'dimCinco'=>$j['SolicitudesRendicionFondo']['otros'],
						'dimCuatro'=>$j['SolicitudesRendicionFondo']['canal_distribucion'],
						'dimDos'=>$j['SolicitudesRendicionFondo']['estadios'],
						'dimTres'=>$j['SolicitudesRendicionFondo']['contenido'],
						'dimUno'=>$j['SolicitudesRendicionFondo']['gerencia'],
						'empaque'=>$j['SolicitudesRendicionFondo']['empaque'],
						'precio'=>number_format($j['SolicitudesRendicionFondo']['precio'],0,',','.'),
						'producto'=>$j['SolicitudesRendicionFondo']['producto'],
						'proyecto'=>isset($j['SolicitudesRendicionFondo']['proyectos'])?$j['SolicitudesRendicionFondo']['proyectos']:'S/N',
						'sub'=>number_format(($j['SolicitudesRendicionFondo']['cantidad'] * str_replace (".","",$j['SolicitudesRendicionFondo']['precio'])),0,',','.'),
						'tipo_impuesto'=>'S/N'
					);	
				}
			}
				if(isset($this->request->query['company_id'])){

					$proveedores = $this->Company->find("first", array(
						'conditions'=>array('Company.id' =>$this->request->query['company_id'])
					));
				}
				$salida2[] = array(
				'id'=>0,
				'cantidad'=>$this->request->query['cantidad'],
				'n_folio'=>isset($this->request->query['n_folio'])?$this->request->query['n_folio']:'S/N',
				'proveedor'=>isset($proveedores['Company']['nombre'])?$proveedores['Company']['nombre']:'S/N',
				'codigoPresupuestario'=>$presupuesto['CodigosPresupuesto']['nombre'],
				'descuento_producto'=>isset($this->request->query['descuento_producto'])?$this->request->query['descuento_producto']:'S/N',
				'descuento_producto_peso'=>isset($this->request->query['descuento_producto_peso'])?$this->request->query['descuento_producto_peso']:'S/N',
				'dimCinco'=>isset($canal['Dimensione']['nombre'])?$canal['Dimensione']['nombre']:'S/N',
				'dimCuatro'=>isset($contenido['Dimensione']['nombre'])?$contenido['Dimensione']['nombre']:'S/N',
				'dimDos'=>isset($estadios['Dimensione']['nombre'])?$estadios['Dimensione']['nombre']:'S/N',
				'dimTres'=>isset($proveedor['Dimensione']['nombre'])?$proveedor['Dimensione']['nombre']:'S/N',
				'dimUno'=>$gerencia['Dimensione']['nombre'],
				'empaque'=>isset($this->request->query['empaque'])?$this->request->query['empaque']:'S/N',
				'precio'=>isset($this->request->query['precio'])?number_format(str_replace (".","",$this->request->query['precio']),0,",","."):'S/N',
				'producto'=>isset($this->request->query['producto'])?$this->request->query['producto']:'S/N',
				'proyecto'=>isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
				'sub'=>number_format(($this->request->query['cantidad'] * str_replace (".","",$this->request->query['precio'])),0,',','.'),
				'tipo_impuesto'=>'S/N'
			);

			if($this->request->query['largo']==count($ProductosCompra) && count($ProductosCompra)>0){

				$resultado = array_merge($salida1, $salida2);
			}else{
				$resultado = $salida2;
			}
			CakeLog::write('actividad', 'Edita lista gastos rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	       echo json_encode($resultado);
		}
		exit;
	}



	public function lista_Rendicion_fondos_totales() {

		$this->layout=null;
		$this->response->type('json');
		$this->autoRender = false;
		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("ComprasTarjetasObservacion");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("MontosFondoFijo");
		$this->loadModel("SolicitudRendicionTotale");

		/*if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}*/
		$listaRendiciones = $this->SolicitudRendicionTotale->find("all",array(
			'conditions'=>array('SolicitudRendicionTotale.compras_tarjeta_estado_id'=> 3, 'SolicitudRendicionTotale.tipo_fondo'=>2, 'SolicitudRendicionTotale.estado_solicitud'=>1)
		));
			
		$salida = "";
		if(!empty($listaRendiciones)){
		
			foreach($listaRendiciones as $listaRendicion){	

			$nSolicitud = $this->SolicitudesRequerimiento->find('first', array(
				'conditions'=>array('SolicitudesRequerimiento.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'])
			));

			$estado = $this->ComprasTarjetasEstado->find('first', array(
				'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRendicion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'] )
			));
			$montoFijo = $this->MontosFondoFijo->find('first', array(
				'conditions'=>array('MontosFondoFijo.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'])
			));

				if($listaRendicion['SolicitudRendicionTotale']['tipo_fondo']==1){
					$tipoFondo = "Fondo por Rendir";
				}else{
					$tipoFondo = "Fondo fijo";
				}
						
						$moneda= "Peso Chileno";
						//$monto = $montoFijo['MontosFondoFijo']['monto'];
						$monto = 'S/N';
						$observado = isset($nSolicitud['SolicitudesRequerimiento']['moneda_observada'])?$nSolicitud['SolicitudesRequerimiento']['moneda_observada']:'S/N';


						$salida[] = array(
							'id'=> $listaRendicion['SolicitudRendicionTotale']['id'],
							'fecha_documento' => $listaRendicion['SolicitudRendicionTotale']['fecha_documento'],
							'n_solicitud_folio'=>$listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'],
							'monto'=> number_format($montoFijo['MontosFondoFijo']['monto'],0,',','.'),
							'titulo'=> $listaRendicion['SolicitudRendicionTotale']['titulo'],
							'url_documento'=> $listaRendicion['SolicitudRendicionTotale']['url_documento'],
							'observacion'=> $listaRendicion['SolicitudRendicionTotale']['observacion'],
							'total'=> number_format($listaRendicion['SolicitudRendicionTotale']['total'],0,',','.'),
							'tipos_moneda_id'=> $moneda,
							'tipo_fondo'=> $tipoFondo,
							'moneda_observada'=> $observado,
							'motivo'=> $listaRendicion['SolicitudRendicionTotale']['motivo'],
							'estado'=> $estado['ComprasTarjetasEstado']['descripcion']
						);
						CakeLog::write('actividad', 'Lista rendicion totales' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				}

				return  json_encode($salida);
				exit;
		}else{
			return json_encode(array());
		}
		exit;
	}




	public function add_estados(){
		$this->layout=null;

		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("Trabajadore");
		$this->loadModel("Jefe");
		$this->loadModel("SolicitudesRequerimiento");
		$vacio = array(""=>"");
		/*if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}*/

		$datosTotales = $this->SolicitudRendicionTotale->find("first", array(
			'conditions'=>array('SolicitudRendicionTotale.id'=>$this->request->query['id'])
		));
		$listaRequerimientos = $this->SolicitudesRequerimiento->find("first", array(
			'conditions'=>array('SolicitudesRequerimiento.id'=>$datosTotales['SolicitudRendicionTotale']['n_solicitud_folio'])
		));

		$nombrelUser = $listaRequerimientos['User']['nombre'];
		$nombreMoneda = $listaRequerimientos['TiposMoneda']['nombre'];
		if($listaRequerimientos['SolicitudesRequerimiento']['tipo_fondo']==1){
			$tipoFondo = "Fondo por rendir";
		}else{
			$tipoFondo = "Fondo fijo";
		}
		$salida = "";
			if ($this->request->is(array('post', 'put'))) {
				$this->request->data['SolicitudesRequerimiento']['id']=$datosTotales['SolicitudRendicionTotale']['n_solicitud_folio'];
				$this->request->data['SolicitudesRequerimiento']['compras_tarjeta_estado_id']=$this->request->query['estado'];
				$this->SolicitudesRequerimiento->save($this->request->data);

					$this->request->data['SolicitudRendicionTotale']['id']=$this->request->query['id'];
					$this->request->data['SolicitudRendicionTotale']['compras_tarjeta_estado_id']=$this->request->query['estado'];
					$this->request->data['SolicitudRendicionTotale']['n_documento']=isset($this->request->query['n_documento'])?$this->request->query['n_documento']:'';
					

					$this->request->data['SolicitudRendicionTotale']['tipo_fondo']= !empty($listaRequerimientos['SolicitudesRequerimiento']['tipo_fondo'])?1:2;
					$this->request->data['SolicitudRendicionTotale']['motivo']=isset($this->request->query['motivo'])?$this->request->query['motivo']:'';
			if ($this->SolicitudRendicionTotale->save($this->request->data)) {

				$idDimensione = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo' =>$listaRequerimientos['SolicitudesRequerimiento']['dimensione_id'])
				));

				$aprobador = $this->EmailsAprobador->find('all', array(
					'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$idDimensione['Dimensione']['codigo_corto'], 'EmailsAprobador.modulo' =>'fondos')
				));

				$envioEmail=[];
				foreach($aprobador as $k=>$j){
					array_push($envioEmail, $j['EmailsAprobador']['emails']);
				}

				if($this->request->query['compras_tarjeta_estado_id']==1 || $this->request->query['compras_tarjeta_estado_id']==4 ){				
					if(!empty($envioEmail)){
						$Email = new CakeEmail("gmail");
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to($envioEmail);//($email[0]["Email"]["email"]);
						$Email->subject("Aprobación Solicitud Requerimiento Compra");
						$Email->emailFormat('html');
						$Email->template('solicitud_requerimeinto_fondo_fijo');
						$Email->viewVars(array(
							"tipo_fondo"=>$tipoFondo,
							"usuario"=>$nombrelUser,
							"titulo"=>$datosTotales['SolicitudRendicionTotale']['titulo'],
							"folio"=>$datosTotales['SolicitudRendicionTotale']['n_solicitud_folio'],
							"fecha"=>$datosTotales['SolicitudRendicionTotale']['fecha_documento'],
							"moneda"=>$nombreMoneda,
							"monto"=>$listaRequerimientos['SolicitudesRequerimiento']['monto'],
							"proyecto"=>isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
							"tipo_fondo"=>$tipoFondo
							/*"titulo"=>$this->data["titulo"],
							"total"=>$this->data["total"],
							"empresa"=>$empresa["Company"]["nombre"]*/
						));
						$Email->send();
						CakeLog::write('actividad', 'Solictud Rendicon compra' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
						$this->Session->setFlash('Solicitud aprobada.', 'msg_exito');
					}

				}else if($this->request->query['compras_tarjeta_estado_id']==5 || $this->request->query['compras_tarjeta_estado_id']==7){

					if(!empty($envioEmail))
					{
						$Email = new CakeEmail("gmail");
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to($envioEmail);//($email[0]["Email"]["email"]);
						$Email->subject("Rechazo Solicitud Rendicion Fondo");
						$Email->emailFormat('html');
						$Email->template('rechaso_solicitud_requerimeinto_fondo_fijo');
						$Email->viewVars(array(
							"usuario"=>$nombrelUser,
							"titulo"=>$datosTotales['SolicitudRendicionTotale']['titulo'],
							"folio"=>$datosTotales['SolicitudRendicionTotale']['n_solicitud_folio'],
							"fecha"=>$datosTotales['SolicitudRendicionTotale']['fecha_documento'],
							"moneda"=>$nombreMoneda,
							"monto"=>$listaRequerimientos['SolicitudesRequerimiento']['monto'],
							"tipo_fondo"=>$tipoFondo,
							"motivo"=>$this->request->query['motivo'],
							"proyecto"=>isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
							/*"titulo"=>$this->data["titulo"],
							"total"=>$this->data["total"],
							"empresa"=>$empresa["Company"]["nombre"]*/
						));
						$Email->send();
						CakeLog::write('actividad', 'Rechazo Solcitud rendion fondo' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
						$this->Session->setFlash('Solicitud rechazada.', 'msg_fallo');

					}
				}
			} 
		} 
	}


public function	view_rendicion_finanzas(){

	$this->layout = 'angular';
	if($this->Session->Read("Users.flag") != 0)
	{
		if($this->Session->Read("Accesos.accesoPagina") == 0)
		{
			$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
		}
	}
	else 
	{
		$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
		return $this->redirect(array("controller" => 'users', "action" => 'login'));
	}
}

public function lista_Rendicion_fondos() {

	$this->layout=null;
	$this->response->type('json');
	$this->autoRender = false;
	$this->loadModel("TiposMoneda");
	$this->loadModel("Dimensione");
	$this->loadModel("User");
	$this->loadModel("EmailsAprobador");
	$this->loadModel("ComprasTarjetasEstado");
	$this->loadModel("ComprasTarjetasObservacion");
	$this->loadModel("SolicitudesRequerimiento");
	$this->loadModel("MontosFondoFijo");

		$listaRendiciones = $this->SolicitudRendicionTotale->find("all", array(
			'conditions'=>array('SolicitudRendicionTotale.compras_tarjeta_estado_id'=> 1 , 
			'SolicitudRendicionTotale.tipo_fondo'=> 2 )
		));
		if(!empty($listaRendiciones)){
			$salida = "";
			foreach($listaRendiciones as $listaRendicion){	
				$estado = $this->ComprasTarjetasEstado->find('first', array(
					'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRendicion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'] )
				));

				$nSolicitud = $this->SolicitudesRequerimiento->find('first', array(
					'conditions'=>array('SolicitudesRequerimiento.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'] )
				));

				$nombreMoneda = $this->TiposMoneda->find('first', array(
					'conditions'=>array('TiposMoneda.id'=> $nSolicitud['SolicitudesRequerimiento']['tipos_moneda_id'])
				));

				$montoFijo = $this->MontosFondoFijo->find('first', array(
					'conditions'=>array('MontosFondoFijo.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'])
				));
		
				if($nSolicitud['SolicitudesRequerimiento']['tipo_fondo']==1){
					$tipoFondo = "Fondo por rendir";
					$moneda = $nombreMoneda['TiposMoneda']['nombre'];
					$monto = $nSolicitud['SolicitudesRequerimiento']['monto'];
					$observado = isset($nSolicitud['SolicitudesRequerimiento']['moneda_observada'])?$nSolicitud['SolicitudesRequerimiento']['moneda_observada']:'S/N';
				}else{
					$tipoFondo = "Fondo fijo";
					$moneda= "Peso Chileno";
					$monto = $montoFijo['MontosFondoFijo']['monto'];
					$observado = isset($nSolicitud['SolicitudesRequerimiento']['moneda_observada'])?$nSolicitud['SolicitudesRequerimiento']['moneda_observada']:'S/N';
				}
			
				$salida[] = array(
					'id'=> $listaRendicion['SolicitudRendicionTotale']['id'],
					'fecha_documento' => $listaRendicion['SolicitudRendicionTotale']['fecha_documento'],
					'n_solicitud_folio'=>$listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'],
					'monto'=> number_format($monto,0,',','.'),
					'titulo'=> $listaRendicion['SolicitudRendicionTotale']['titulo'],
					'url_documento'=> $listaRendicion['SolicitudRendicionTotale']['url_documento'],
					'observacion'=> $listaRendicion['SolicitudRendicionTotale']['observacion'],
					'total'=> number_format($listaRendicion['SolicitudRendicionTotale']['total'],0,',','.'),
					'tipos_moneda_id'=> $moneda,
					'tipo_fondo'=> $tipoFondo,
					'moneda_observada'=> $observado,
					'motivo'=> $listaRendicion['SolicitudRendicionTotale']['motivo'],
					'estado'=> $estado['ComprasTarjetasEstado']['descripcion']
				);
			}
			CakeLog::write('actividad', 'Lista rendicon de fondos Totales' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			return json_encode($salida);
		}else{
			return json_encode(array());
		}
	exit;
}


public function view_lista_fijos() {
	$this->layout = 'angular';
}
public function lista_fijos() {

	$this->layout=null;
	$this->response->type('json');
	$this->autoRender = false;

	$this->loadModel("TiposMoneda");
	$this->loadModel("Dimensione");
	$this->loadModel("User");
	$this->loadModel("EmailsAprobador");
	$this->loadModel("ComprasTarjetasEstado");
	$this->loadModel("ComprasTarjetasObservacion");
	$this->loadModel("DimensionesProyecto");
	$this->loadModel("CodigosPresupuesto");
	$this->loadModel("SolicitudesRequerimiento");
	$this->loadModel("MontosFondoFijo");
	$this->loadModel("SolicitudRendicionTotale");

	$listaRequerimientos = $this->SolicitudRendicionTotale->find("all", array(
		'conditions'=>array('SolicitudRendicionTotale.id_usuario'=> $this->Session->Read("PerfilUsuario.idUsuario"),
			'SolicitudRendicionTotale.estado_solicitud'=>1,
			'SolicitudRendicionTotale.compras_tarjeta_estado_id !='=>7,
			'SolicitudRendicionTotale.tipo_fondo'=>2 
			)
		)
	);


	if(!empty($listaRequerimientos)){

		$salida = "";
		foreach($listaRequerimientos as $listaRequerimiento){	
		
			$nombrelUser = $this->User->find('first', array(
				'conditions'=>array('User.id' => $listaRequerimiento['SolicitudRendicionTotale']['id_usuario'])
			));

			$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
				'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRequerimiento['SolicitudRendicionTotale']['compras_tarjeta_estado_id'] )
			));

			$arear = $this->MontosFondoFijo->find('first', array(
				'conditions'=>array('MontosFondoFijo.id'=> $listaRequerimiento['SolicitudRendicionTotale']['n_solicitud_folio'] )
			));

			if(isset($arear['MontosFondoFijo']['area'])){
				$gerencia = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo_corto'=> $arear['MontosFondoFijo']['area'] )
				));
			}
				
		
			$salida[] = array(
				'id'=> $listaRequerimiento['SolicitudRendicionTotale']['id'],
				'user_id' => $nombrelUser['User']['nombre'],
				'fecha_documento'=>$listaRequerimiento['SolicitudRendicionTotale']['fecha_documento'],
				'n_solicitud_folio'=>$listaRequerimiento['SolicitudRendicionTotale']['n_solicitud_folio'],
				'total'=> number_format($listaRequerimiento['SolicitudRendicionTotale']['total'],0,',','.'),
				'dimensione_id'=> isset($gerencia['Dimensione']['nombre'])?$gerencia['Dimensione']['nombre']:'S/N',
				'codigos_presupuesto_id'=> isset($codigoPresupuesto['CodigosPresupuesto']['nombre'])?$codigoPresupuesto['CodigosPresupuesto']['nombre']:'S/N',
				'tipos_moneda_id'=> 'Peso Chileno',
				'moneda_observada'=> isset($listaRequerimiento['SolicitudRendicionTotale']['moneda_observada'])?$listaRequerimiento['SolicitudRendicionTotale']['moneda_observada']:'S/N',
				'estadios'=> isset($dimensionDos['Dimensione']['nombre'])?$dimensionDos['Dimensione']['nombre']:'S/N',
				'titulo'=> isset($arear['MontosFondoFijo']['titulo'])?$arear['MontosFondoFijo']['titulo']:'S/N',
				'contenido'=> isset($listaRequerimiento['SolicitudRendicionTotale']['contenido'])?$listaRequerimiento['SolicitudRendicionTotale']['contenido']:'S/N',
				'canal_distribucion'=> isset($dimensionTres['Dimensione']['nombre'])?$dimensionTres['Dimensione']['nombre']:'S/N',
				'otros'=> isset($dimensionCuatro['Dimensione']['nombre'])?$dimensionCuatro['Dimensione']['nombre']:'S/N',
				'monto'=> number_format($arear['MontosFondoFijo']['monto'],0,',','.'),
				'proyectos'=> isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
				'tipo_fondo'=> "Fondo fijo",
				'estado'=>$estadoSolicitud['ComprasTarjetasEstado']['descripcion']
			);
		}
	
		return json_encode($salida);
	}else{
		return json_encode(array());
	}
	CakeLog::write('actividad', 'Lista requerimientos fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	exit;
}


public function view_todo_fondo_fijo() {
	$this->layout = 'angular';
	if($this->Session->Read("Users.flag") != 0)
	{
		if($this->Session->Read("Accesos.accesoPagina") == 0)
		{
			$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
		}
	}
	else 
	{
		$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
		return $this->redirect(array("controller" => 'users', "action" => 'login'));
	}
}


public function lista_todos(){
	$this->layout=null;
	$this->response->type('json');
	$this->autoRender = false;

	$this->loadModel("TiposMoneda");
	$this->loadModel("Dimensione");
	$this->loadModel("User");
	$this->loadModel("EmailsAprobador");
	$this->loadModel("ComprasTarjetasEstado");
	$this->loadModel("ComprasTarjetasObservacion");
	$this->loadModel("DimensionesProyecto");
	$this->loadModel("CodigosPresupuesto");
	$this->loadModel("SolicitudesRequerimiento");
	$this->loadModel("MontosFondoFijo");
	$this->loadModel("SolicitudRendicionTotale");

	$listaRequerimientos = $this->SolicitudRendicionTotale->find("all", array(
		'conditions'=>array('SolicitudRendicionTotale.tipo_fondo' => 2, 'SolicitudRendicionTotale.estado_solicitud' => 1)
	));


	if(!empty($listaRequerimientos)){
		$salida = "";
		foreach($listaRequerimientos as $listaRequerimiento){	
		
			$nombrelUser = $this->User->find('first', array(
				'conditions'=>array('User.id' => $listaRequerimiento['SolicitudRendicionTotale']['id_usuario'])
			));

			$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
				'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRequerimiento['SolicitudRendicionTotale']['compras_tarjeta_estado_id'] )
			));

			$area = $this->MontosFondoFijo->find('first', array(
				'conditions'=>array('MontosFondoFijo.id'=> $listaRequerimiento['SolicitudRendicionTotale']['n_solicitud_folio'] )
			));

			if(isset($area['MontosFondoFijo']['area'])){
				$gerencia = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo_corto'=> $area['MontosFondoFijo']['area'])
				));
			}

			$salida[] = array(
				'id'=> $listaRequerimiento['SolicitudRendicionTotale']['id'],
				'user_id' => $nombrelUser['User']['nombre'],
				'fecha'=>$listaRequerimiento['SolicitudRendicionTotale']['fecha_documento'],
				'total'=> number_format($listaRequerimiento['SolicitudRendicionTotale']['total'],0,',','.'),
				'monto'=> number_format($area['MontosFondoFijo']['monto'],0,',','.'),
				'dimensione_id'=> isset($gerencia['Dimensione']['nombre'])?$gerencia['Dimensione']['nombre']:'S/N',
				'codigos_presupuesto_id'=> isset($codigoPresupuesto['CodigosPresupuesto']['nombre'])?$codigoPresupuesto['CodigosPresupuesto']['nombre']:'S/N',
				'tipos_moneda_id'=> 'Peso Chileno',
				'moneda_observada'=> isset($listaRequerimiento['SolicitudRendicionTotale']['moneda_observada'])?$listaRequerimiento['SolicitudRendicionTotale']['moneda_observada']:'S/N',
				'estadios'=> isset($dimensionDos['Dimensione']['nombre'])?$dimensionDos['Dimensione']['nombre']:'S/N',
				'titulo'=> isset($listaRequerimiento['SolicitudRendicionTotale']['titulo'])?$listaRequerimiento['SolicitudRendicionTotale']['titulo']:'S/N',
				'contenido'=> isset($listaRequerimiento['SolicitudRendicionTotale']['contenido'])?$listaRequerimiento['SolicitudRendicionTotale']['contenido']:'S/N',
				'canal_distribucion'=> isset($dimensionTres['Dimensione']['nombre'])?$dimensionTres['Dimensione']['nombre']:'S/N',
				'otros'=> isset($dimensionCuatro['Dimensione']['nombre'])?$dimensionCuatro['Dimensione']['nombre']:'S/N',
				'proyectos'=> isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
				'tipo_fondo'=> "Fondo fijo",
				'estado'=>$estadoSolicitud['ComprasTarjetasEstado']['descripcion']
			);
		}
	
		return json_encode($salida);
	}else{
		return json_encode(array());
	}
	CakeLog::write('actividad', 'Lista requerimientos fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	exit;

}




public function view_solicitud(){
	$this->layout='angular';
	if($this->Session->Read("Users.flag") != 0)
	{
		if($this->Session->Read("Accesos.accesoPagina") == 0)
		{
			$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
		}
	}
	else 
	{
		$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
		return $this->redirect(array("controller" => 'users', "action" => 'login'));
	}
}

public function lista_solicitudes($id = null) {

	$this->layout=null;
	$this->response->type('json');
	$this->autoRender = false;

	$this->loadModel("TiposMoneda");
	$this->loadModel("Dimensione");
	$this->loadModel("User");
	$this->loadModel("EmailsAprobador");
	$this->loadModel("ComprasTarjetasEstado");
	$this->loadModel("ComprasTarjetasObservacion");
	$this->loadModel("DimensionesProyecto");
	$this->loadModel("CodigosPresupuesto");
	$this->loadModel("SolicitudesRequerimiento");
	$emailUser = $this->User->find('first', array(
		'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
	));

	$aprobador = $this->EmailsAprobador->find('all', array(
		'conditions'=>array('EmailsAprobador.emails' =>$emailUser['Trabajadore']['email'], 'EmailsAprobador.modulo' =>'fondos')
	));
	$codigoPresupuesto = [];
	foreach($aprobador as $k=>$j){
		$codigoPresupuesto[$k] = $j['EmailsAprobador']['codigo_presupuesto'];
	}
	$index = [];	
	$codigoDimensionId = $this->Dimensione->find('all', array(
		'conditions'=>array('Dimensione.codigo_corto'=> $codigoPresupuesto)
	));

	foreach($codigoDimensionId as $k=>$j){
		$index[$k] = $j['Dimensione']['codigo'];
	}

	$listaRequerimientos = $this->SolicitudesRequerimiento->find("all", array(
		'conditions'=>array('SolicitudesRequerimiento.compras_tarjeta_estado_id' =>4, 
							'SolicitudesRequerimiento.estado_rendicion'=>0 ,
							 'SolicitudesRequerimiento.tipo_fondo'=>2,
							 'SolicitudesRequerimiento.user_id'=>$this->Session->Read("PerfilUsuario.idUsuario"))
	));
	if(!empty($listaRequerimientos)){
		$salida = "";
		foreach($listaRequerimientos as $listaRequerimiento){	
			$nombrelUser = $this->User->find('first', array(
				'conditions'=>array('User.id' => $listaRequerimiento['SolicitudesRequerimiento']['user_id'])
			));
			$codigoDimensionId = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['dimensione_id'] )
			));	
			if(!empty($listaRequerimiento['SolicitudesRequerimiento']['estadios'])){

				$dimensionDos = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['estadios'] )
				));
			}else{
				$dimensionDos['Dimensione']['nombre'] = 'S/N';
			}

			if(!empty($listaRequerimiento['SolicitudesRequerimiento']['canal_distribucion'])){
				$dimensionTres = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['canal_distribucion'] )
				));
			}else{
				$dimensionTres['Dimensione']['nombre'] = 'S/N';
			}
			if(!empty($listaRequerimiento['SolicitudesRequerimiento']['otros'])){
				$dimensionCuatro = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['otros'] )
				));
			}else{
				$dimensionCuatro['Dimensione']['nombre'] = 'S/N';
			}
			if(!empty($listaRequerimiento['SolicitudesRequerimiento']['otros'])){
				$proyectos = $this->DimensionesProyecto->find('first', array(
					'conditions'=>array('DimensionesProyecto.id'=> $listaRequerimiento['SolicitudesRequerimiento']['proyectos'] )
				));
			}else{
				$proyectos['DimensionesProyecto']['nombre']='S/N';
			}
			$nombreMoneda = $this->TiposMoneda->find('first', array(
				'conditions'=>array('TiposMoneda.id'=> $listaRequerimiento['SolicitudesRequerimiento']['tipos_moneda_id'] )
			));
			$codigoPresupuesto = $this->CodigosPresupuesto->find('first', array(
				'conditions'=>array('CodigosPresupuesto.id'=> $listaRequerimiento['SolicitudesRequerimiento']['codigos_presupuesto_id'] )
			));
			$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
				'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id'] )
			));
			if($listaRequerimiento['SolicitudesRequerimiento']['tipo_fondo']==1){
				$tipoFondo = "Fondo por rendir";
			}else{
				$tipoFondo = "Fondo fijo";
			}
			$salida[] = array(
				'id'=> $listaRequerimiento['SolicitudesRequerimiento']['id'],
				'user_id' => $nombrelUser['User']['nombre'],
				'fecha'=>$listaRequerimiento['SolicitudesRequerimiento']['fecha'],
				'monto'=> number_format($listaRequerimiento['SolicitudesRequerimiento']['monto'],0,',','.'),
				'dimensione_id'=> $codigoDimensionId['Dimensione']['nombre'],
				'codigos_presupuesto_id'=> $codigoPresupuesto['CodigosPresupuesto']['nombre'],
				'tipos_moneda_id'=> $nombreMoneda['TiposMoneda']['nombre'],
				'moneda_observada'=> $listaRequerimiento['SolicitudesRequerimiento']['moneda_observada'],
				'estadios'=> $dimensionDos['Dimensione']['nombre'],
				'titulo'=> $listaRequerimiento['SolicitudesRequerimiento']['titulo'],
				'contenido'=> $listaRequerimiento['SolicitudesRequerimiento']['contenido'],
				'canal_distribucion'=> $dimensionTres['Dimensione']['nombre'],
				'otros'=> $dimensionCuatro['Dimensione']['nombre'],
				'proyectos'=> $proyectos['DimensionesProyecto']['nombre'],
				'tipo_fondo'=> $tipoFondo,
				//'estado'=>$estadoSolicitud['ComprasTarjetasEstado']['descripcion']
				'estado'=>'Requerimiento Aprobado'
			);
		}
		CakeLog::write('actividad', 'Lista solicitud requerimiento' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		return json_encode($salida);
	}else{
		return json_encode(array());
	}
	exit;
}


public function view_solicitante($id = null) {

	$this->layout = 'angular';
	$this->loadModel("TiposMoneda");
	$this->loadModel("Dimensione");
	$this->loadModel("User");
	$this->loadModel("EmailsAprobador");
	$this->loadModel("ComprasTarjetasEstado");
	$this->loadModel("ComprasTarjetasObservacion");
	$this->loadModel("DimensionesProyecto");
	$this->loadModel("CodigosPresupuesto");
	$this->loadModel("SolicitudesRequerimiento");
	$this->loadModel("MontosFondoFijo");
	$this->loadModel("SolicitudRendicionTotale");
	$this->loadModel("SolicitudesRendicionFondo");
	

	if($this->Session->Read("Users.flag") != 0)
	{
		if($this->Session->Read("Accesos.accesoPagina") == 0)
		{
			$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
		}
	}
	else 
	{
		$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
		return $this->redirect(array("controller" => 'users', "action" => 'login'));
	}

	$listaRendicion = $this->SolicitudRendicionTotale->find('first',array(
		'conditions'=>array('SolicitudRendicionTotale.id' => $id, 'SolicitudRendicionTotale.tipo_fondo' =>2)
	));


	$nSolicitud = $this->SolicitudesRequerimiento->find('first', array(
		'conditions'=>array('SolicitudesRequerimiento.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'] )
	));

	$nombrelUser = $this->User->find('first', array(
		'conditions'=>array('User.id' => $listaRendicion['SolicitudRendicionTotale']['id_usuario'])
	));

	$estado = $this->ComprasTarjetasEstado->find('first', array(
		'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRendicion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])
	));

	$montoFijo = $this->MontosFondoFijo->find('first', array(
		'conditions'=>array('MontosFondoFijo.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'])
	));


	//if($nSolicitud['SolicitudesRequerimiento']['tipo_fondo']==2){
		$tipoFondo = "Fondo fijo";
		$moneda= "Peso Chileno";
		//$monto = $montoFijo['MontosFondoFijo']['monto'];
		$observado = 'S/N';
	//}

	$this->set("id", $listaRendicion['SolicitudRendicionTotale']['id']);
	$this->set("fecha_documento", $listaRendicion['SolicitudRendicionTotale']['fecha_documento']);
	$this->set("n_solicitud_folio", $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio']);
	$this->set("monto", number_format($montoFijo['MontosFondoFijo']['monto'],0,",","."));
	$this->set("titulo", $listaRendicion['SolicitudRendicionTotale']['titulo']);
	$this->set("url_documento", $listaRendicion['SolicitudRendicionTotale']['url_documento']);
	$this->set("observacion", $listaRendicion['SolicitudRendicionTotale']['observacion']);
	$this->set("total", $listaRendicion['SolicitudRendicionTotale']['total']);
	$this->set("nombreMoneda", $moneda);
	$this->set("tipo_fondo", $tipoFondo);
	$this->set("moneda_observada", $observado);
	$this->set("estado", $estado['ComprasTarjetasEstado']['descripcion']);
	$this->set("usuario", $nombrelUser['User']['nombre']);
	$this->set("n_documento", $listaRendicion['SolicitudRendicionTotale']['n_documento']);

	$listaRendicionFondo= $this->SolicitudesRendicionFondo->find('all', array(
		'conditions'=>array('SolicitudesRendicionFondo.id_solicitudes_rendicion_fondo'=> $listaRendicion['SolicitudRendicionTotale']['id'] )
	));

	if($estado['ComprasTarjetasEstado']['id']==1){
		$areas = array(4,7);
	}else{
		$areas =  array(1,5);
	}
	$this->set("tipo", $estado['ComprasTarjetasEstado']['id']);
	
	$this->set("listaRendicionFondo", $listaRendicionFondo);
	$listaEstado = $this->ComprasTarjetasEstado->find('list', array(
		'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
		'conditions'=>array('ComprasTarjetasEstado.id'=> $areas )
	));
	$this->set("listaEstado", $listaEstado);
	CakeLog::write('actividad', 'Visualiza solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	//exit;
}


public function add_rendicion($id){
	/*if($this->Session->Read("Users.flag") != 0)
	{
		if($this->Session->Read("Accesos.accesoPagina") == 0)
		{
			$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
		}
	}
	else 
	{
		$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
		return $this->redirect(array("controller" => 'users', "action" => 'login'));
	}*/
		$this->layout='angular';
		$this->loadModel("TiposDocumento");
		$this->loadModel("ComprasProductosTotale");
		//$this->layout ="angular";
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");

		$this->loadModel("SolicitudesRequerimiento");

		$datosSolicitudfondos= $this->SolicitudesRequerimiento->find("all", array(
			"conditions"=>array("SolicitudesRequerimiento.id"=>$id)
		));
		$this->set("ndocumento", $datosSolicitudfondos[0]['SolicitudesRequerimiento']['id']);
		$this->set("nmonto", $datosSolicitudfondos[0]['SolicitudesRequerimiento']['monto']);

		if($datosSolicitudfondos[0]['SolicitudesRequerimiento']['tipo_fondo']){
			$tipoFondo = "Fondo por rendir";
		}else{
			$tipoFondo = "Fondo fijo";
		}
		$this->set("tipoFondo", $tipoFondo);

		if (!$this->SolicitudesRequerimiento->exists($id)) {
			throw new NotFoundException(__('Invalid solicitudes requerimiento'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['SolicitudesRequerimiento']['estado_rendicion']=1;

			if ($this->SolicitudesRequerimiento->save($this->request->data)) {
				return $this->Session->setFlash(__('The solicitudes requerimiento has been saved---->1.'));
				//return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The solicitudes requerimiento could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SolicitudesRequerimiento.' . $this->SolicitudesRequerimiento->primaryKey => $id));
			$this->request->data = $this->SolicitudesRequerimiento->find('first', $options);
		}
		$tipoDocumentos = $this->TiposDocumento->find("list", array(
			"conditions"=>array("TiposDocumento.tipo"=>1, "TiposDocumento.id !="=>26),
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre")
		));

		$this->set("tipoDocumentos", $tipoDocumentos);
		if(!empty($id))
		{
			$comprasProductosTotale = $this->ComprasProductosTotale->find("first", array(
				'conditions'=>array("ComprasProductosTotale.id"=>$id)
			));

			$this->set("comprasProductosTotale", $comprasProductosTotale);
			$this->set("id", $id);
		}
		else
		{
			$this->Session->setFlash('No hay documentos tributarios cargados anteriormente', 'msg_fallo');
			return $this->redirect(array("action"=>'index'));
		}
		$vacio = array(""=>"");
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		$proyectos = "";
		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);
		$this->set("proyectos", $proyectos);
		$proveedores = $this->Company->find("list", array(
			"fields"=>array("Company.id", "Company.razon_social")
		));

		if(!empty($proveedores))
		{
			//array_unshift($proveedores, $vacio);
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);
		}
		if (!$this->SolicitudesRequerimiento->exists($id)) {
			throw new NotFoundException(__('Invalid solicitudes requerimiento'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SolicitudesRequerimiento->save($this->request->data)) {
				//return $this->Session->setFlash(__('The solicitudes requerimiento has been saved---->2.'));

			} else {
				$this->Session->setFlash(__('The solicitudes requerimiento could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SolicitudesRequerimiento.' . $this->SolicitudesRequerimiento->primaryKey => $id));
			$this->request->data = $this->SolicitudesRequerimiento->find('first', $options);
		}

		$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
		));

		if(!empty($tipoMonedas))
		{
			$tipoMonedas[] = $vacio;
			$this->set("tipoMonedas", $tipoMonedas);
		}

		$plazosPagos = $this->PlazosPago->find("list", array(
			"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));

		if(!empty($plazosPagos))
		{
			//array_unshift($plazosPagos, $vacio);
			$this->set("plazosPagos", $plazosPagos);
		}

		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));

		if(!empty($empaques))
		{
			//array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}

		$dimensiones = $this->Dimensione->find("all", array());

		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{

			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}
		//array_unshift($dimensionUno, $vacio);

		$this->set("dimensionUno", $dimensionUno);

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
		//array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);

		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		//array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);

		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		//array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);

		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		//array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);
		CakeLog::write('actividad', 'Agrega rendicion de fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		//return $this->Session->setFlash(__('The solicitudes requerimiento has been saved---->3.'));
		
	}


	public function view_solicitud_rechazadas(){
		$this->layout='angular';
		/*if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}*/

		
	}

	public function lista_solicitudes_rechazadas($id = null) {

		$this->layout=null;
		$this->response->type('json');
		$this->autoRender = false;
		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("ComprasTarjetasObservacion");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("SolicitudRendicionTotale");
		$this->loadModel("MontosFondoFijo");
		$this->loadModel("SolicitudesRequerimiento");

		$emailUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
		));

		$aprobador = $this->EmailsAprobador->find('all', array(
			'conditions'=>array('EmailsAprobador.emails' =>$emailUser['Trabajadore']['email'], 'EmailsAprobador.modulo' =>'fondos')
		));
		$codigoPresupuesto = [];
		foreach($aprobador as $k=>$j){
			$codigoPresupuesto[$k] = $j['EmailsAprobador']['codigo_presupuesto'];
		}
		$index = [];	
		$codigoDimensionId = $this->Dimensione->find('all', array(
			'conditions'=>array('Dimensione.codigo_corto'=> $codigoPresupuesto)
		));
			foreach($codigoDimensionId as $k=>$j){
				$index[$k] = $j['Dimensione']['codigo'];
			}
			$listaRequerimientos = $this->SolicitudRendicionTotale->find("all", array(
				'conditions'=>array('SolicitudRendicionTotale.compras_tarjeta_estado_id' =>array(5,7), 'SolicitudRendicionTotale.id_usuario' =>$this->Session->Read("PerfilUsuario.idUsuario") )
			));

		if(!empty($listaRequerimientos)){
			$salida = "";

			
			foreach($listaRequerimientos as $listaRequerimiento){	

				/*$idRendiciontotal  = $this->SolicitudRendicionTotale->find("first", array(
					'conditions'=>array('SolicitudRendicionTotale.n_solicitud_folio' =>$listaRequerimiento['SolicitudRendicionTotale']['id'])
				));
					
				if(!empty($listaRequerimiento['SolicitudesRequerimiento']['estadios'])){

					$dimensionDos = $this->Dimensione->find('first', array(
						'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['estadios'] )
					));
				}else{
					$dimensionDos['Dimensione']['nombre'] = 'S/N';
				}

				if(!empty($listaRequerimiento['SolicitudesRequerimiento']['canal_distribucion'])){
					$dimensionTres = $this->Dimensione->find('first', array(
						'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['canal_distribucion'] )
					));
				}else{
					$dimensionTres['Dimensione']['nombre'] = 'S/N';
				}
				if(!empty($listaRequerimiento['SolicitudesRequerimiento']['otros'])){
					$dimensionCuatro = $this->Dimensione->find('first', array(
						'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['otros'] )
					));
				}else{
					$dimensionCuatro['Dimensione']['nombre'] = 'S/N';
				}
				if(!empty($listaRequerimiento['SolicitudesRequerimiento']['otros'])){
					$proyectos = $this->DimensionesProyecto->find('first', array(
						'conditions'=>array('DimensionesProyecto.id'=> $listaRequerimiento['SolicitudesRequerimiento']['proyectos'] )
					));
				}else{
					$proyectos['DimensionesProyecto']['nombre']='S/N';
				}
				$nombreMoneda = $this->TiposMoneda->find('first', array(
					'conditions'=>array('TiposMoneda.id'=> $listaRequerimiento['SolicitudesRequerimiento']['tipos_moneda_id'] )
				));
			
				$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
					'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRequerimiento['SolicitudesRequerimiento']['estado'] )
				));

				if(isset($idRendiciontotal['SolicitudRendicionTotale']['n_solicitud_folio'])){
					$montoFijo = $this->MontosFondoFijo->find('first', array(
						'conditions'=>array('MontosFondoFijo.id'=> $idRendiciontotal['SolicitudRendicionTotale']['n_solicitud_folio'] )
					));
				}
				
				if(isset($idRendiciontotal['SolicitudRendicionTotale']['n_solicitud_folio'])){
					$nSolicitud = $this->SolicitudesRequerimiento->find('first', array(
						'conditions'=>array('SolicitudesRequerimiento.id'=> $idRendiciontotal['SolicitudRendicionTotale']['n_solicitud_folio'] )
					));
				}

				$nombrelUser = $this->User->find('first', array(
					'conditions'=>array('User.id' => $listaRequerimiento['SolicitudesRequerimiento']['user_id'])
				));*/

				$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
					'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRequerimiento['SolicitudRendicionTotale']['compras_tarjeta_estado_id'] )
				));

				$nombrelUser = $this->User->find('first', array(
					'conditions'=>array('User.id' => $listaRequerimiento['SolicitudRendicionTotale']['id_usuario'])
				));

		
				$arear = $this->MontosFondoFijo->find('first', array(
					'conditions'=>array('MontosFondoFijo.id'=> $listaRequerimiento['SolicitudRendicionTotale']['n_solicitud_folio'] )
				));
				if(isset($arear['MontosFondoFijo']['area'])){

					$gerencia = $this->Dimensione->find('first', array(
						'conditions'=>array('Dimensione.codigo_corto'=> $arear['MontosFondoFijo']['area'] )
					));
				}

					$tipoFondo = "Fondo fijo";
					$moneda= "Peso Chileno";

				
					//if(count($idRendiciontotal)>0){
						$salida[] = array(
							'id'=> $listaRequerimiento['SolicitudRendicionTotale']['id'],
							'user_id' => $nombrelUser['User']['nombre'],
							'fecha'=>$listaRequerimiento['SolicitudRendicionTotale']['fecha_documento'],
							'monto'=> number_format($listaRequerimiento['SolicitudRendicionTotale']['total'],0,',','.'),
							'dimensione_id'=> isset($gerencia['Dimensione']['nombre'])?$gerencia['Dimensione']['nombre']:'S/N',
							'codigos_presupuesto_id'=> 'S/N',
							'tipos_moneda_id'=> $moneda,
							'moneda_observada'=> 'S/N',
							'estadios'=> 'S/N',
							'titulo'=>  $listaRequerimiento['SolicitudRendicionTotale']['titulo'],
							'contenido'=> 'S/N',
							'canal_distribucion'=> 'S/N',
							'otros'=> 'S/N',
							'proyectos'=> 'S/N',
							'tipo_fondo'=> $tipoFondo,
							'estado'=>$estadoSolicitud['ComprasTarjetasEstado']['descripcion']
						);
					//}
				
			}
			CakeLog::write('actividad', 'Lista solicitud rechazada' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			return json_encode($salida);
		}else{
			return json_encode(array());
		}
		exit;
	
	}

	public function edit_rendicion($id=""){
		$this->layout='angular';
		$this->loadModel("TiposDocumento");
		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("SolicitudRendicionTotale");
		$this->loadModel("MontosFondoFijo");
		
	
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
	
			$datosRequerimientos = $this->SolicitudRendicionTotale->find("first", array(
			'conditions'=>array('SolicitudRendicionTotale.id'=>$id)
			));
		$this->set("fechasss", $datosRequerimientos['SolicitudRendicionTotale']['fecha_documento']);
		//$this->set("proveedor", $datosRequerimientos['SolicitudRendicionTotale']['company_id']);
		$this->set("titulo", $datosRequerimientos['SolicitudRendicionTotale']['titulo']);
		$this->set("observacion", $datosRequerimientos['SolicitudRendicionTotale']['observacion']);
		$this->set("idsolicitud", $datosRequerimientos['SolicitudRendicionTotale']['id']);
		$this->set("url", $datosRequerimientos['SolicitudRendicionTotale']['url_documento']);
	
		$this->set("ndocumento", $datosRequerimientos['SolicitudRendicionTotale']['n_solicitud_folio']);


		$datosMontosFijos = $this->MontosFondoFijo->find("first", array(
			"conditions"=>array("MontosFondoFijo.id"=>$datosRequerimientos['SolicitudRendicionTotale']['n_solicitud_folio']),
		));

		$valorMoneda = $this->TiposMoneda->find("first", array(
			"conditions"=>array("TiposMoneda.id"=>$datosMontosFijos['MontosFondoFijo']['id_moneda']),
		));
	
		$this->set("idMoneda", $valorMoneda['TiposMoneda']['id']);
		$this->set("valorMoneda", $valorMoneda['TiposMoneda']['valor']);
	
		
		$tipoFondo = "Fondo fijo";
	
		$this->set("tipoFondo", $tipoFondo);
	
		$tipoDocumentos = $this->TiposDocumento->find("list", array(
		"conditions"=>array("TiposDocumento.tipo"=>1, "TiposDocumento.id !="=>26),
		"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre")
		));
		$this->set("tipoDocumentos", $tipoDocumentos);
	
		if(!empty($id))
		{
			$comprasProductosTotale = $this->ComprasProductosTotale->find("first", array(
			'conditions'=>array("ComprasProductosTotale.id"=>$id)
			));
	
			$this->set("comprasProductosTotale", $comprasProductosTotale);
			$this->set("id", $id);
			//return $this->Session->setFlash('No hay documentos tributarios cargados anteriormente---->1', 'msg_fallo');
		}
		
			$vacio = array(""=>"");
			$dimensionesProyectos = $this->DimensionesProyecto->find("all");
			$proyectos = "";
		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
	
		$proyectos[0] = $vacio;
		ksort($proyectos);
		$this->set("proyectos", $proyectos);
		$proveedores = $this->Company->find("list", array(
		"fields"=>array("Company.id", "Company.razon_social")
		));
	
		if(!empty($proveedores))
		{
		//array_unshift($proveedores, $vacio);
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);
		}
	
			$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
			));
	
		if(!empty($tipoMonedas))
		{
			$tipoMonedas[] = $vacio;
			$this->set("tipoMonedas", $tipoMonedas);
		}
	
		$plazosPagos = $this->PlazosPago->find("list", array(
		"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));
	
		if(!empty($plazosPagos))
		{
		//array_unshift($plazosPagos, $vacio);
		$this->set("plazosPagos", $plazosPagos);
		}
	
		$empaques = $this->Empaque->find("list", array(
		"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));
	
		if(!empty($empaques))
		{
		//array_unshift($empaques, $vacio);
			$empaques[0] = $vacio;
			ksort($empaques);
			$this->set("empaques", $empaques);	
		}
	
		$dimensiones = $this->Dimensione->find("all", array());
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}
	
		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}
		//array_unshift($dimensionUno, $vacio);
		$dimensionUno[0] = $vacio;
		ksort($dimensionUno);
		$this->set("dimensionUno", $dimensionUno);
		$dimensionDos = "";
			foreach($tipoDimensiones[2] as $tipoDimensioneDos)
			{
				$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
			}
		//array_unshift($dimensionDos, $vacio);
		$dimensionDos[0] = $vacio;
		ksort($dimensionDos);
		$this->set("dimensionDos", $dimensionDos);
	
		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		//array_unshift($dimensionTres, $vacio);
		$dimensionTres[0] = $vacio;
		ksort($dimensionTres);
		$this->set("dimensionTres", $dimensionTres);
	
		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		//array_unshift($dimensionCuatro, $vacio);
		$dimensionCuatro[0] = $vacio;
		ksort($dimensionCuatro);
		$this->set("dimensionCuatro", $dimensionCuatro);
		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		$dimensionCinco[0] = $vacio;
		ksort($dimensionCinco);
		$this->set("dimensionCinco", $dimensionCinco);
		CakeLog::write('actividad', 'Edita rendición de fondos ' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	}




	public function datos_rendicion(){

		$this->layout = null;

		$this->loadModel("TiposDocumento");
		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("SolicitudRendicionTotale");
		$this->loadModel("MontosFondoFijo");

		/*if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}*/
		if(!empty($this->request->query)){
		
			$datosRequerimientos = $this->SolicitudRendicionTotale->find("first", array(
				'conditions'=>array('SolicitudRendicionTotale.id'=>$this->request->query['id'])
			));

			$montoFijo = $this->MontosFondoFijo->find('first', array(
				'conditions'=>array('MontosFondoFijo.id'=> $datosRequerimientos['SolicitudRendicionTotale']['n_solicitud_folio'])
			));

			$salida[] = array(
				'fecha'=>$datosRequerimientos['SolicitudRendicionTotale']['fecha_documento'],
				//'proveedor'=>$datosRequerimientos['SolicitudRendicionTotale']['company_id'],
				'titulo'=>$datosRequerimientos['SolicitudRendicionTotale']['titulo'],
				'observacion'=>$datosRequerimientos['SolicitudRendicionTotale']['observacion'],
				'idsolicitud'=>$datosRequerimientos['SolicitudRendicionTotale']['id'],
				'nmonto'=>number_format($montoFijo['MontosFondoFijo']['monto'],0,',','.'),
				'ndocumento'=>$datosRequerimientos['SolicitudRendicionTotale']['n_solicitud_folio'],
				'moneda'=>1,
				//'plazo'=>$datosRequerimientos['SolicitudRendicionTotale']['plazos_pago_id']
			);
			CakeLog::write('actividad', 'Lista rendicion de fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			echo json_encode($salida);
			exit;
		}

	}


	public function edit_fFijo() {

		$this->layout = null;
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("DimensionesCodigosCorto");
		$this->loadModel("MontosFondoFijo");

		/*if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}*/

		$vacio = array(""=>"");
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);


		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));

		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}

		$dimensionesProyectos = $this->DimensionesProyecto->find("all");

		$proyectos = "";
		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["id"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);
		$this->set("proyectos", $proyectos);
		$dimensiones = $this->Dimensione->find("all", array());
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}
	
		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}
		$this->set("dimensionUno", $dimensionUno);

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);

		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);

		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);

		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);

		$proveedores = $this->Company->find("list", array(
			"fields"=>array("Company.id", "Company.razon_social")
		));

		if(!empty($proveedores))
		{
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);   
		}
		$rutasDoc= array();
		if ($this->request->is(array('post', 'put'))) {
			if ($this->request->is('post')) {
			$this->request->data['SolicitudRendicionTotale']['id'] = $this->request->data['id'];

			if(count($this->request['form']['file']['name'])>0){
				$destino = WWW_ROOT.'files'.DS.'solicitudFondos'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');		 
				if (!file_exists($destino))
				{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}

				for($i=0;$i<count($this->request['form']['file']['name']);$i++){
					$url = $destino . DS .$this->request['form']['file']['name'][$i];
					move_uploaded_file($this->request['form']['file']['tmp_name'][$i], $url);
					array_push($rutasDoc, $url);
				}
			}

			$datosFondosFolmulario = json_decode($this->request->data['rendicion']);

			$this->SolicitudRendicionTotale->data['fecha_documento'] = $datosFondosFolmulario->fecha_documento;
			$this->SolicitudRendicionTotale->data['titulo'] = $datosFondosFolmulario->titulo;
			
			//$this->SolicitudRendicionTotale->data['company_id'] = $datosFondosFolmulario->company_id;
			$this->SolicitudRendicionTotale->data['observacion'] = $datosFondosFolmulario->observacion;

			if(count($rutasDoc)>0){
				$this->SolicitudRendicionTotale->data['url_documento'] = implode(",", $rutasDoc);
			}
			
			//$this->request->data['total'] = $this->request->data['total'];
			$this->SolicitudRendicionTotale->data['n_solicitud_folio'] = $this->request->data['idFolio'];
			$this->SolicitudRendicionTotale->data['compras_tarjeta_estado_id']= 3;
			$this->SolicitudRendicionTotale->data['id_usuario']=$this->Session->read('PerfilUsuario.idUsuario');
			$this->SolicitudRendicionTotale->data['id']= $this->request->data['id'];

			$this->SolicitudRendicionTotale->data['total'] = str_replace(".","",$this->request->data['total']);

			if ($this->SolicitudRendicionTotale->save($this->SolicitudRendicionTotale->data)) {

				$requerimiento = $this->MontosFondoFijo->find('first', array(
					'conditions'=>array('MontosFondoFijo.id'=> $this->request->data['idFolio'])
				));

				$aprobador = $this->EmailsAprobador->find('all', array(
					'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$requerimiento['MontosFondoFijo']['area'], 'EmailsAprobador.modulo' =>'fondos')
				));

				$envioEmail=[];
				foreach($aprobador as $k=>$j){
					array_push($envioEmail, $j['EmailsAprobador']['emails']);
				}

				$nombrelUser = $this->User->find('first', array(
					'conditions'=>array('User.id' => $this->Session->read('PerfilUsuario.idUsuario'))
				));
				$Email = new CakeEmail("gmail");
				$Email->from(array('sgi@cdf.cl' => 'SGI'));
				$Email->to($envioEmail);//($email[0]["Email"]["email"]);
				$Email->subject("Actualización rendicion de fondos");
				$Email->emailFormat('html');
				$Email->template('solicitud_rendicion_fondo_fijo');
				$Email->viewVars(array(
					"tipo_fondo"=>'Fondo fijo',
					"usuario"=>$nombrelUser['User']['nombre'],
					"titulo"=>$datosFondosFolmulario->titulo,
					"folio"=>$this->request->data['idFolio'],
					"fecha"=>$datosFondosFolmulario->fecha_documento,
					"destino"=>'solicitudes_requerimientos/',
				));
				$Email->send();
			
				$this->Session->setFlash('La solicitud a sido actualizada.', 'msg_exito');
				CakeLog::write('actividad', 'Edita solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				
			} else {
				$this->Session->setFlash(__('The solicitud rendicion totale could not be saved. Please, try again.'));
			}
		} 
			

			if ($this->SolicitudesRendicionFondo->deleteAll(array('SolicitudesRendicionFondo.id_solicitudes_rendicion_fondo' => $this->request->data['id']))) {
				//echo "--->elimino";
				//$this->Session->setFlash(__('The solicitud rendicion totale has been deleted.'));
			} else {
				//echo "--->No elimino";
				//$this->Session->setFlash(__('The solicitud rendicion totale could not be deleted. Please, try again.'));
			}
			$listaSolicituides = json_decode($this->request->data['lista']);
		
			for($i=0;$i<count($listaSolicituides);$i++){
				$this->SolicitudesRendicionFondo->create();
						$this->SolicitudesRendicionFondo->data['cantidad'] = $listaSolicituides[$i]->cantidad;
						$this->SolicitudesRendicionFondo->data['codigo_presupuesto'] = $listaSolicituides[$i]->codigoPresupuestario;
						$this->SolicitudesRendicionFondo->data['descuento_producto'] = $listaSolicituides[$i]->descuento_producto;
						$this->SolicitudesRendicionFondo->data['descuento_producto_peso'] = $listaSolicituides[$i]->descuento_producto_peso;
						$this->SolicitudesRendicionFondo->data['otros'] = $listaSolicituides[$i]->dimCinco;
						$this->SolicitudesRendicionFondo->data['canal_distribucion'] = $listaSolicituides[$i]->dimCuatro;
						$this->SolicitudesRendicionFondo->data['estadios'] = $listaSolicituides[$i]->dimDos;
						$this->SolicitudesRendicionFondo->data['contenido'] = $listaSolicituides[$i]->dimTres;
						$this->SolicitudesRendicionFondo->data['fecha_creacion'] = date('Y-m-d');
						$this->SolicitudesRendicionFondo->data['gerencia'] = $listaSolicituides[$i]->dimUno;
						$this->SolicitudesRendicionFondo->data['empaque'] = $listaSolicituides[$i]->empaque;
						$this->SolicitudesRendicionFondo->data['precio'] = str_replace(".","",$listaSolicituides[$i]->precio);
						$this->SolicitudesRendicionFondo->data['producto'] = $listaSolicituides[$i]->producto;
						$this->SolicitudesRendicionFondo->data['proyectos'] = $listaSolicituides[$i]->proyecto;
						$this->SolicitudesRendicionFondo->data['tipo_impuesto'] = $listaSolicituides[$i]->tipo_impuesto;
						$this->SolicitudesRendicionFondo->data['id_solicitudes_rendicion_fondo'] = $this->request->data['id'];
						$this->SolicitudesRendicionFondo->data['n_folio'] = $listaSolicituides[$i]->n_folio;
						$this->SolicitudesRendicionFondo->data['proveedor'] = $listaSolicituides[$i]->proveedor;
						//$this->actualiza($this->request->data['idFolio'], 3);

				if ($this->SolicitudesRendicionFondo->save($this->SolicitudesRendicionFondo->data)) {
					//return $this->Session->setFlash(__('The solicitud rendicion totale has been saved-------->>>.'));
					//return $this->redirect(array('action' => 'view_solicitud_rechazadas'));
					
				} else {
					//$this->Session->setFlash(__('The solicitud rendicion totale could not be saved. Please, try again.'));
				}

				//$this->Session->setFlash(__('The solicitud rendicion totale has been saved-------->>>.'));
				//return $this->redirect(array('action' => 'view_solicitud_rechazadas'));
			}

		}
	}


}
