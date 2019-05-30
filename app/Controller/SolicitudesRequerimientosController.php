<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * SolicitudesRequerimientos Controller
 *
 * @property SolicitudesRequerimiento $SolicitudesRequerimiento
 * @property PaginatorComponent $Paginator
 */
class SolicitudesRequerimientosController extends AppController {

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
        Configure::write('debug', 2); 
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
		$this->SolicitudesRequerimiento->recursive = 0;
		$this->set('solicitudesRequerimientos', $this->Paginator->paginate());
		CakeLog::write('actividad', 'Lista Solicitudes requerimentos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	}

	public function view_area(){
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

	public function view_finanzas(){
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

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->layout = 'angular';
		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("ComprasTarjetasObservacion");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");

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

		$listaRequerimientos = $this->SolicitudesRequerimiento->find("all", array(
			'conditions'=>array('SolicitudesRequerimiento.id'=> $id, "SolicitudesRequerimiento.tipo_fondo"=>1)
		));
		$salida = "";
	foreach($listaRequerimientos as $listaRequerimiento){	

		$nombrelUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $listaRequerimiento['SolicitudesRequerimiento']['user_id'])
		));

		$codigoDimensionId = $this->Dimensione->find('first', array(
			'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['dimensione_id'] )
		));	
		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['dimensione_id'])){

			$dimensionUno = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['dimensione_id'])
			));
		}else{
			 $dimensionUno['Dimensione']['nombre']='S/N';
		}

		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['estadios'])){
			$dimensionDos = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['estadios'] )
			));
		}else{
			$dimensionDos['Dimensione']['nombre']='S/N';
		}

		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['contenido'])){
			$dimensionTres = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['contenido'] )
			));
		}else{
			$dimensionTres['Dimensione']['nombre']='S/N';
		}
		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['canal_distribucion'])){
			$dimensionCuatro = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['canal_distribucion'] )
			));
		}else{
			$dimensionCuatro['Dimensione']['nombre']='S/N';
		}

		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['canal_distribucion'])){
			$dimensionCinco  = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['otros'] )
			));
		}else{
			$dimensionCinco['Dimensione']['nombre']='S/N';
		}

		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['proyectos'])){
			$proyectos = $this->DimensionesProyecto->find('first', array(
				'conditions'=>array('DimensionesProyecto.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['proyectos'] )
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

			if($listaRequerimiento['SolicitudesRequerimiento']['tipo_fondo']==1){
				$tipoFondo = "Fondo por rendir";
			}
		$estadoSolicitud = $this->SolicitudesRequerimiento->find('first', array(
			'conditions'=>array('SolicitudesRequerimiento.compras_tarjeta_estado_id'=> $listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id'] )
		));

		if($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']==3){

			$estados = array(1,5);

			$ruta= "view_area";
		}else if($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']==1 || $listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']==4){
			$estados = array(4,7);
			$ruta= "view_finanzas";
		}

		$estado = $this->ComprasTarjetasEstado->find('list', array(
			'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
			'conditions'=>array('ComprasTarjetasEstado.id'=>  $estados)
		));


			$this->set("id", $listaRequerimiento['SolicitudesRequerimiento']['id']);
			$this->set("user_id", $nombrelUser['User']['nombre']);
			$this->set("fecha", $listaRequerimiento['SolicitudesRequerimiento']['fecha']);
			$this->set("monto", $listaRequerimiento['SolicitudesRequerimiento']['monto']);
			$this->set("dimensione_id", $dimensionUno['Dimensione']['nombre']);
			$this->set("codigos_presupuesto_id", $codigoPresupuesto['CodigosPresupuesto']['nombre']);
			$this->set("tipos_moneda_id", $nombreMoneda['TiposMoneda']['nombre']);
			$this->set("moneda_observada", $listaRequerimiento['TiposMoneda']['valor']);
			$this->set("estadios", $dimensionDos['Dimensione']['nombre']);
			$this->set("titulo", $listaRequerimiento['SolicitudesRequerimiento']['titulo']);
			$this->set("contenido", $dimensionTres['Dimensione']['nombre']);
			$this->set("canal_distribucion", $dimensionCuatro['Dimensione']['nombre']);
			$this->set("otros", $dimensionCinco['Dimensione']['nombre']);
			$this->set("proyectos", $proyectos['DimensionesProyecto']['nombre']);
			$this->set("tipo_fondo", $tipoFondo);
			$this->set("ruta", $ruta);
			$this->set("estado", $estado);
			$this->set("observacion", $listaRequerimiento['SolicitudesRequerimiento']['observacion']);
		}

		CakeLog::write('actividad', 'Visualiza informacion de solicitud' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("EmailsAprobador");
		
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

		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);
		$dimensiones = $this->Dimensione->find("all", array());

		$vacio = array(""=>"");
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);
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
		//$proyectos[0] = $vacio;
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
		//exit;

		if ($this->request->is('post')) {

			//pr(str_replace (".","",$this->data['SolicitudesRequerimiento']['monto']));
			//exit;
			$this->SolicitudesRequerimiento->create();
			$this->request->data['SolicitudesRequerimiento']['monto'] = str_replace (".","",$this->data['SolicitudesRequerimiento']['monto']);
			$this->request->data['SolicitudesRequerimiento']['tipo_fondo'] = $this->params['data']['tipo_fondo'];
			$this->request->data['SolicitudesRequerimiento']['user_id'] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data['SolicitudesRequerimiento']['moneda_observada'] = $this->params['data']['SolicitudesRequerimiento']['moneda_observada'];
			$this->request->data['SolicitudesRequerimiento']['estadios'] = $this->params['data']['SolicitudesRequerimiento']['estadio'];
			$this->request->data['SolicitudesRequerimiento']['compras_tarjeta_estado_id'] = 3;
			$this->request->data['SolicitudesRequerimiento']['estado_solicitud'] = 1;
			$this->request->data['SolicitudesRequerimiento']['estado_rendicion'] = 0;
		//	pr($this->request->data['SolicitudesRequerimiento']['proyectos']);
		//	exit;
			if ($this->SolicitudesRequerimiento->save($this->request->data)) {
				
				$nombreMoneda = $this->TiposMoneda->find('first', array(
					'conditions'=>array('TiposMoneda.id'=> $this->request->data['SolicitudesRequerimiento']['tipos_moneda_id'] )
				));

				if(!empty($this->request->data['SolicitudesRequerimiento']['proyectos'])){
					$nombreProyectos = $this->DimensionesProyecto->find('first', array(
						'conditions'=>array('DimensionesProyecto.id'=> $this->request->data['SolicitudesRequerimiento']['proyectos'] )
					));
				}else{
					$nombreProyectos['DimensionesProyecto']['nombre']="S/N";
				}
				$codigoCorto = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo'=> $this->request->data['SolicitudesRequerimiento']['dimensione_id'] )
				));
				$aprobador = $this->EmailsAprobador->find('all', array(
					'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$codigoCorto ['Dimensione']['codigo_corto'], 'EmailsAprobador.modulo' =>'fondos')
				));
					$envioEmail=[];
					foreach($aprobador as $k=>$j){
						array_push($envioEmail, $j['EmailsAprobador']['emails']);
					}


				if(!empty($envioEmail))
				{
					$Email = new CakeEmail("gmail");
					$Email->from(array('sgi@cdf.cl' => 'SGI'));
					$Email->to($envioEmail);//($email[0]["Email"]["email"]);
					$Email->subject("Solicitud Requerimiento Compra");
					$Email->emailFormat('html');
					$Email->template('solicitud_requerimeinto_compra');
					$Email->viewVars(array(
						"usuario"=>$this->Session->read("Users.nombre"),
						"titulo"=>$this->request->data['SolicitudesRequerimiento']['titulo'],
						"fecha"=>$this->request->data['SolicitudesRequerimiento']['fecha'],
						"moneda"=>$nombreMoneda['TiposMoneda']['nombre'],
						"monto"=>$this->request->data['SolicitudesRequerimiento']['monto'],
						"proyecto"=>isset($nombreProyectos['DimensionesProyecto']['nombre'])?$nombreProyectos['DimensionesProyecto']['nombre']:'S/N',
						"tipo_fondo"=>$this->request->data['SolicitudesRequerimiento']['tipo_fondo'],
						"destino"=>'solicitud_rendicion_totales/view_todo_fondo_fijo'
						/*"titulo"=>$this->data["titulo"],
						"total"=>$this->data["total"],
						"empresa"=>$empresa["Company"]["nombre"]*/
					));
					$Email->send();
				
					///$this->Flash->success('Email successfully send on receiveremail@ex.com');
				}
			
				CakeLog::write('actividad', 'Guarda solicitud de fondo' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Solicitud de requerimiento fondo ingresada.', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
				//return $this ->redirect(array("controller" => 'users', "action" => 'fallo'));
			} else {
				//$this->Session->setFlash(__('The solicitudes requerimiento could not be saved. Please, try again.'));
			}
		}
	}



	public function add_save_fondo() {


		
		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("EmailsAprobador");
		
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

		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);
		$dimensiones = $this->Dimensione->find("all", array());

		$vacio = array(""=>"");
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);
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
		//$proyectos[0] = $vacio;
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
		//exit;

		if ($this->request->is('post')) {

			//pr(str_replace (".","",$this->data['SolicitudesRequerimiento']['monto']));
			//exit;
			$this->SolicitudesRequerimiento->create();
			$this->request->data['SolicitudesRequerimiento']['monto'] = str_replace (".","",$this->data['SolicitudesRequerimiento']['monto']);
			$this->request->data['SolicitudesRequerimiento']['tipo_fondo'] = $this->params['data']['tipo_fondo'];
			$this->request->data['SolicitudesRequerimiento']['user_id'] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data['SolicitudesRequerimiento']['moneda_observada'] = $this->params['data']['SolicitudesRequerimiento']['moneda_observada'];
			$this->request->data['SolicitudesRequerimiento']['estadios'] = $this->params['data']['SolicitudesRequerimiento']['estadio'];
			$this->request->data['SolicitudesRequerimiento']['compras_tarjeta_estado_id'] = 3;
			$this->request->data['SolicitudesRequerimiento']['estado_solicitud'] = 1;
			$this->request->data['SolicitudesRequerimiento']['estado_rendicion'] = 0;
		//	pr($this->request->data['SolicitudesRequerimiento']['proyectos']);
		//	exit;
			if ($this->SolicitudesRequerimiento->save($this->request->data)) {
				
				$nombreMoneda = $this->TiposMoneda->find('first', array(
					'conditions'=>array('TiposMoneda.id'=> $this->request->data['SolicitudesRequerimiento']['tipos_moneda_id'] )
				));

				if(!empty($this->request->data['SolicitudesRequerimiento']['proyectos'])){
					$nombreProyectos = $this->DimensionesProyecto->find('first', array(
						'conditions'=>array('DimensionesProyecto.id'=> $this->request->data['SolicitudesRequerimiento']['proyectos'] )
					));
				}else{
					$nombreProyectos['DimensionesProyecto']['nombre']="S/N";
				}
				$codigoCorto = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo'=> $this->request->data['SolicitudesRequerimiento']['dimensione_id'] )
				));
				$aprobador = $this->EmailsAprobador->find('all', array(
					'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$codigoCorto ['Dimensione']['codigo_corto'], 'EmailsAprobador.modulo' =>'fondos')
				));
					$envioEmail=[];
					foreach($aprobador as $k=>$j){
						array_push($envioEmail, $j['EmailsAprobador']['emails']);
					}


				if(!empty($envioEmail))
				{
					$Email = new CakeEmail("gmail");
					$Email->from(array('sgi@cdf.cl' => 'SGI'));
					$Email->to($envioEmail);//($email[0]["Email"]["email"]);
					$Email->subject("Solicitud Requerimiento Compra");
					$Email->emailFormat('html');
					$Email->template('solicitud_requerimeinto_compra');
					$Email->viewVars(array(
						"usuario"=>$this->Session->read("Users.nombre"),
						"titulo"=>$this->request->data['SolicitudesRequerimiento']['titulo'],
						"fecha"=>$this->request->data['SolicitudesRequerimiento']['fecha'],
						"moneda"=>$nombreMoneda['TiposMoneda']['nombre'],
						"monto"=>$this->request->data['SolicitudesRequerimiento']['monto'],
						"proyecto"=>isset($nombreProyectos['DimensionesProyecto']['nombre'])?$nombreProyectos['DimensionesProyecto']['nombre']:'S/N',
						"tipo_fondo"=>$this->request->data['SolicitudesRequerimiento']['tipo_fondo'],
						"destino"=>'solicitud_rendicion_totales/view_todo_fondo_fijo'
						/*"titulo"=>$this->data["titulo"],
						"total"=>$this->data["total"],
						"empresa"=>$empresa["Company"]["nombre"]*/
					));
					$Email->send();
				
					///$this->Flash->success('Email successfully send on receiveremail@ex.com');
				}
			
				CakeLog::write('actividad', 'Guarda solicitud de fondo' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Solicitud de requerimiento fondo ingresada.', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
				//return $this ->redirect(array("controller" => 'users', "action" => 'fallo'));
			} else {
				//$this->Session->setFlash(__('The solicitudes requerimiento could not be saved. Please, try again.'));
			}
		}
	}


/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
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

		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
			$this->set('tipoMonedas', $tipoMonedas);
			$dimensiones = $this->Dimensione->find("all", array());

		$tipoDimensiones = "";
		if(!empty($dimensiones)){
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione){
			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}

		$this->set("dimensione", $dimensionUno);

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
			//$proyectos[0] = $vacio;
			//ksort($proyectos);
			$this->set("proyectos", $proyectos);

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			/////pr($tipoDimensioneDos);
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
		if (!$this->SolicitudesRequerimiento->exists($id)) {
			throw new NotFoundException(__('Invalid solicitudes requerimiento'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['SolicitudesRequerimiento']['monto'] = str_replace (".","", $this->request['data']['SolicitudesRequerimiento']['monto']);
			$this->request->data['SolicitudesRequerimiento']['tipo_fondo'] = $this->request['data']['tipo_fondo'];
			$this->request->data['SolicitudesRequerimiento']['estadios'] = $this->request['data']['SolicitudesRequerimiento']['estadios'];
			$this->request->data['SolicitudesRequerimiento']['codigos_presupuesto_id'] = $this->request['data']['codigos_presupuesto_id'];
			$this->request->data['SolicitudesRequerimiento']['compras_tarjeta_estado_id'] = 3;
			//pr($this->request->data);

		//	exit;
			if ($this->SolicitudesRequerimiento->save($this->request->data)) {
				// return $this->Session->setFlash(__('Solicitud de requerimiento fondo actualizada.'));
				//return $this->redirect(array('action' => 'view_solicitud_rechazadas'));
				$this->Session->setFlash('Solicitud de requerimiento fondo actualizada.', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The solicitudes requerimiento could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SolicitudesRequerimiento.' . $this->SolicitudesRequerimiento->primaryKey => $id));
			$this->request->data = $this->SolicitudesRequerimiento->find('first', $options);
		}
			$users = $this->SolicitudesRequerimiento->User->find('list');
			$dimensiones = $this->SolicitudesRequerimiento->Dimensione->find('list');
			$codigosPresupuestos = $this->SolicitudesRequerimiento->CodigosPresupuesto->find('list');
			$tiposMonedas = $this->SolicitudesRequerimiento->TiposMoneda->find('list');
			$this->set(compact('users', 'dimensiones', 'codigosPresupuestos', 'tiposMonedas'));
		CakeLog::write('actividad', 'Edita Solcitud Fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		//return $this->Session->setFlash(__('Solicitud de requerimiento fondo actualizada.'));
		
	}


/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
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
		if (!$this->SolicitudesRequerimiento->exists($id)) {		
			throw new NotFoundException(__('Invalid compras tarjeta'));
		}
		if ($this->request->is(array('get', 'put'))) {
			$this->request->data['SolicitudesRequerimiento']['id']=$id;
			$this->request->data['SolicitudesRequerimiento']['estado_solicitud']=5;//Numero que elimina
			if ($this->SolicitudesRequerimiento->save($this->request->data)) {
				$this->Session->setFlash('Solicitud de requerimiento fondo eliminada.', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			}
		}

		CakeLog::write('actividad', 'Elimina Solcitud Fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		
	}

	public function delete_gasto($id = null) {
		$this->layout=null;
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
		if (!$this->SolicitudesRendicionFondo->exists($this->request->query['id'])) {		
			throw new NotFoundException(__('Invalid compras tarjeta'));
		}
		if ($this->request->allowMethod('post', 'delete')) {
		
			if ($this->SolicitudesRendicionFondo->delete($this->request->data['SolicitudesRendicionFondo']['id']=$this->request->query['id'])) {
				$this->Session->setFlash('Solicitud de requerimiento fondo eliminada.', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The solicitud rendicion totale could not be deleted. Please, try again.'));
			}
		//return $this->redirect(array('action' => 'index'));
		CakeLog::write('actividad', 'Elimina datos de Gastos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		}
		
	}


	public function list_requerimientos() {

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

	$listaRequerimientos = $this->SolicitudesRequerimiento->find("all", array(
		'conditions'=>array('SolicitudesRequerimiento.user_id'=> $this->Session->Read("PerfilUsuario.idUsuario"), 
		'SolicitudesRequerimiento.estado_solicitud'=>1,
		'SolicitudesRequerimiento.tipo_fondo'=>1)
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
				$tipoFondo = "Fondo por rendir";

	$idRencion = $this->SolicitudRendicionTotale->find('first', array(
		'conditions'=>array('SolicitudRendicionTotale.n_solicitud_folio'=> $listaRequerimiento['SolicitudesRequerimiento']['id'] )
	));
	if($listaRequerimiento['SolicitudesRequerimiento']['estado_rendicion']==1 && ($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']==5 || $idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']==7)){
		$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
			'conditions'=>array('ComprasTarjetasEstado.id'=> $idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])
		));
		switch ($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']) {
			case 5:
			$valor=  "Area rechaza rendicion";
				break;
			case 7:
			$valor=  "Finanza rechaza rendicion";
			break;
		}
	}elseif($listaRequerimiento['SolicitudesRequerimiento']['estado_rendicion']==1 && ($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']==1 || $idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']==4)){
		$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
			'conditions'=>array('ComprasTarjetasEstado.id'=> $idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'] )
		));
		switch ($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']) {
			case 1:
			$valor=  "Area aprueba rendicion";
				break;
			case 4:
			$valor=  "Finanza aprueba rendicion";
			break;
		}
	}else{
		if(empty($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])){
			$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
				'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id'])
			));
			if($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']== 4){
				$valor='Por Rendir';
			}elseif($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']==10){
				$valor='Por Aprobar';
			}else{
				$valor=  $estadoSolicitud['ComprasTarjetasEstado']['descripcion'];
			}
		}else{
			$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
				'conditions'=>array('ComprasTarjetasEstado.id'=>  $idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])
			));

			if($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']== 4){
				$valor='Por Rendir';
			}elseif($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']==10){
				$valor='Por Aprobar';
			}else{
				$valor=  $estadoSolicitud['ComprasTarjetasEstado']['descripcion'];
			}
			

		}
		
	}

			$salida[] = array(
				'id'=>$listaRequerimiento['SolicitudesRequerimiento']['id'],
				'idSolicitud'=> isset($idRencion['SolicitudRendicionTotale']['id'])?$idRencion['SolicitudRendicionTotale']['id']:'',
				'user_id' => $nombrelUser['User']['nombre'],
				'fecha'=>$listaRequerimiento['SolicitudesRequerimiento']['fecha'],
				'monto'=> number_format($listaRequerimiento['SolicitudesRequerimiento']['monto'],0,",","."),
				'dimensione_id'=> isset($codigoDimensionId['Dimensione']['nombre'])?$codigoDimensionId['Dimensione']['nombre']:'S/N',
				'codigos_presupuesto_id'=> isset($codigoPresupuesto['CodigosPresupuesto']['nombre'])?$codigoPresupuesto['CodigosPresupuesto']['nombre']:'S/N',
				'tipos_moneda_id'=> isset($nombreMoneda['TiposMoneda']['nombre'])?$nombreMoneda['TiposMoneda']['nombre']:'',
				'moneda_observada'=> $listaRequerimiento['SolicitudesRequerimiento']['moneda_observada'],
				'estadios'=> $dimensionDos['Dimensione']['nombre'],
				'titulo'=> $listaRequerimiento['SolicitudesRequerimiento']['titulo'],
				'contenido'=> $listaRequerimiento['SolicitudesRequerimiento']['contenido'],
				'canal_distribucion'=> $dimensionTres['Dimensione']['nombre'],
				'otros'=> isset($dimensionCuatro['Dimensione']['nombre'])?$dimensionCuatro['Dimensione']['nombre']:'S/N',
				'proyectos'=> isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
				'tipo_fondo'=> $tipoFondo,
				'estadoNombre'=>$valor,
				'idEstadoCompraTarjeta'=> isset($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])?$idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']:$listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id'],
				'hhs'=>$listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id'],
				'T'=>isset($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])?$idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']:''
			);
			
			}
			return json_encode($salida);
		}else{
			return json_encode(array());
		}
		CakeLog::write('actividad', 'Lista requerimientos fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		exit;
	}


	public function add_estados(){
		$this->layout=null;



		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("ComprasTarjetasObservacion");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");

		$listaRequerimientos = $this->SolicitudesRequerimiento->find("all", array(
			'conditions'=>array('SolicitudesRequerimiento.id'=>$this->request->query['id'])
		));
	
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
	
			if($listaRequerimiento['SolicitudesRequerimiento']['tipo_fondo']==1){
				$tipoFondo = "Fondo por rendir";
			}else{
				$tipoFondo = "Fondo fijo";
			}
	
			$estado = $this->ComprasTarjetasEstado->find('list', array(
				'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
			));
	
				$this->set("id", $listaRequerimiento['SolicitudesRequerimiento']['id']);
				$this->set("user_id", $nombrelUser['User']['nombre']);
				$this->set("fecha", $listaRequerimiento['SolicitudesRequerimiento']['fecha']);
				$this->set("monto", $listaRequerimiento['SolicitudesRequerimiento']['monto']);
				$this->set("dimensione_id", $codigoDimensionId['Dimensione']['nombre']);
				$this->set("codigos_presupuesto_id", $codigoPresupuesto['CodigosPresupuesto']['nombre']);
				$this->set("tipos_moneda_id", $nombreMoneda['TiposMoneda']['nombre']);
				$this->set("moneda_observada", $listaRequerimiento['SolicitudesRequerimiento']['moneda_observada']);
				$this->set("estadios", $dimensionDos['Dimensione']['nombre']);
				$this->set("titulo", $listaRequerimiento['SolicitudesRequerimiento']['titulo']);
				$this->set("contenido", $listaRequerimiento['SolicitudesRequerimiento']['contenido']);
				$this->set("canal_distribucion", $dimensionTres['Dimensione']['nombre']);
				$this->set("otros", $dimensionCuatro['Dimensione']['nombre']);
				$this->set("proyectos", $proyectos['DimensionesProyecto']['nombre']);
				$this->set("tipo_fondo", $tipoFondo);
				$this->set("estado", $estado);
				
				
			}

		if ($this->request->is(array('post', 'put'))) {

			$this->request->data['SolicitudesRequerimiento']['id'] = $this->request->query['id'];
			$this->request->data['SolicitudesRequerimiento']['compras_tarjeta_estado_id'] = $this->request->query['estado'];
			$this->request->data['SolicitudesRequerimiento']['motivo'] = isset($this->request->query['motivo'])?$this->request->query['motivo']:'';
			$this->request->data['SolicitudesRequerimiento']['n_documento'] = isset($this->request->query['n_documento'])?$this->request->query['n_documento']:'';
		

			if($this->request->query['estado']==4){
				$this->request->data['SolicitudesRequerimiento']['estado_rendicion']=1;
			}
			if ($this->SolicitudesRequerimiento->save($this->request->data)) {

				$codPresupuesto = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['dimensione_id'] )
				));

				$aprobador = $this->EmailsAprobador->find('list', array(
					'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$codPresupuesto['Dimensione']['codigo_corto'], 'EmailsAprobador.modulo' =>'fondos')
				));

					$envioEmail= array_values($aprobador);

				if($this->request->query['compras_tarjeta_estado_id']==1 || $this->request->query['compras_tarjeta_estado_id']==4 ){
					if(!empty($envioEmail))
					{
						$Email = new CakeEmail("gmail");
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to($envioEmail);//($email[0]["Email"]["email"]);
						$Email->subject("Aprobación Solicitud Requerimiento Compra");
						$Email->emailFormat('html');
						$Email->template('solicitud_requerimeinto_compra');
						$Email->viewVars(array(
							"usuario"=>$nombrelUser['User']['nombre'],
							"titulo"=>$listaRequerimiento['SolicitudesRequerimiento']['titulo'],
							"folio"=>$listaRequerimiento['SolicitudesRequerimiento']['titulo'],
							"fecha"=>$listaRequerimiento['SolicitudesRequerimiento']['fecha'],
							"moneda"=>$nombreMoneda['TiposMoneda']['nombre'],
							"monto"=>$listaRequerimiento['SolicitudesRequerimiento']['monto'],
							"proyecto"=>$proyectos['DimensionesProyecto']['nombre'],
							"tipo_fondo"=>$tipoFondo,
							"destino"=>'solicitudes_requerimientos'
							/*"titulo"=>$this->data["titulo"],
							"total"=>$this->data["total"],
							"empresa"=>$empresa["Company"]["nombre"]*/
						));
						$Email->send();
						CakeLog::write('actividad', 'Envio Mail Aprueba solicitud requerimiento' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));					
						return $this->Session->setFlash('Solicitud aprobada.', 'msg_exito');
						
					}

				}else if($this->request->query['compras_tarjeta_estado_id']==5 || $this->request->query['compras_tarjeta_estado_id']==7){

					if(!empty($envioEmail))
					{
						$Email = new CakeEmail("gmail");
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to($envioEmail);//($email[0]["Email"]["email"]);
						$Email->subject("Rechazo Solicitud Requerimiento Compra");
						$Email->emailFormat('html');
						$Email->template('rechaso_solicitud_requerimeinto_compra');
						$Email->viewVars(array(
							"usuario"=>$nombrelUser['User']['nombre'],
							"titulo"=>$listaRequerimiento['SolicitudesRequerimiento']['titulo'],
							"folio"=>$listaRequerimiento['SolicitudesRequerimiento']['titulo'],
							"fecha"=>$listaRequerimiento['SolicitudesRequerimiento']['fecha'],
							"moneda"=>$nombreMoneda['TiposMoneda']['nombre'],
							"monto"=>$listaRequerimiento['SolicitudesRequerimiento']['monto'],
							"proyecto"=>$proyectos['DimensionesProyecto']['nombre'],
							"tipo_fondo"=>$tipoFondo,
							"motivo"=>$this->request->query['motivo'],
							"destino"=>'solicitudes_requerimientos'
							/*"titulo"=>$this->data["titulo"],
							"total"=>$this->data["total"],
							"empresa"=>$empresa["Company"]["nombre"]*/
						));
						$Email->send();
						CakeLog::write('actividad', 'Envio Mail Rechaza solicitud requerimiento' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
						return $this->Session->setFlash('Solicitud rechazada.', 'msg_fallo');
						
					}
				}
			} 
		} 
	}

	public function lista_area($id = null) {

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
		//pr($codigoPresupuesto);
		$codigoDimensionId = $this->Dimensione->find('all', array(
			'conditions'=>array('Dimensione.codigo_corto'=> $codigoPresupuesto)
		));

		foreach($codigoDimensionId as $k=>$j){
			$index[$k] = $j['Dimensione']['codigo'];
		}

		$listaRequerimientos = $this->SolicitudesRequerimiento->find("all", array(
			'conditions'=>array('SolicitudesRequerimiento.compras_tarjeta_estado_id' =>3, 'SolicitudesRequerimiento.estado_solicitud' =>1, 'SolicitudesRequerimiento.estado_rendicion' =>0)
			//'SolicitudesRequerimiento.dimensione_id' => $index , 
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
					'proyectos'=> isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
					'tipo_fondo'=> $tipoFondo,
					'estado'=>$estadoSolicitud['ComprasTarjetasEstado']['descripcion']
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

	$listaRequerimientos = $this->SolicitudesRequerimiento->find("all", array(
		'conditions'=>array('SolicitudesRequerimiento.id'=> $id ,'SolicitudesRequerimiento.estado_solicitud' =>1)
	));
	
	$salida = "";
	foreach($listaRequerimientos as $listaRequerimiento){	
		$this->set("contenido", $listaRequerimiento['SolicitudesRequerimiento']['contenido']);
		$this->set("titulo", $listaRequerimiento['SolicitudesRequerimiento']['titulo']);
		$this->set("fecha", $listaRequerimiento['SolicitudesRequerimiento']['fecha']);
		$this->set("monto", $listaRequerimiento['SolicitudesRequerimiento']['monto']);
		$this->set("moneda_observada", $listaRequerimiento['SolicitudesRequerimiento']['moneda_observada']);
		$nombrelUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $listaRequerimiento['SolicitudesRequerimiento']['user_id'])
		));
		$this->set("user_id", $nombrelUser['User']['nombre']);

		$codigoDimensionId = $this->Dimensione->find('first', array(
			'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['dimensione_id'] )
		));
		$this->set("dimensione_id", $codigoDimensionId['Dimensione']['nombre']);	


		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['estadios'])){
			$dimensionDos = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['estadios'] )
			));
		}else{
			$dimensionDos['Dimensione']['nombre']="S/N";
		}
		
		$this->set("estadios", $dimensionDos['Dimensione']['nombre']);


		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['contenido'])){
			$dimensionTres = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['contenido'] )
			));
		}else{
			$dimensionTres['Dimensione']['nombre']='S/N';
		}
		
		$this->set("contenido", $dimensionTres['Dimensione']['nombre']);


		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['canal_distribucion'])){
			$dimensionCuatro = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['canal_distribucion'] )
			));
		}else{
			$dimensionCuatro['Dimensione']['nombre']="S/N";
		}
		
		$this->set("canal_distribucion", $dimensionCuatro['Dimensione']['nombre']);


		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['otros'])){
			$dimensionCinco  = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['otros'] )
			));
		}else{
			$dimensionCinco['Dimensione']['nombre']='S/N';
		}

		$this->set("otros", $dimensionCinco['Dimensione']['nombre']);

		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['proyectos'])){

			$proyectos = $this->DimensionesProyecto->find('first', array(
				'conditions'=>array('DimensionesProyecto.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['proyectos'] )
			));
		}else{
			$proyectos['DimensionesProyecto']['nombre']="S/N";
		}

		$this->set("proyectos", $proyectos['DimensionesProyecto']['nombre']);
		
		$nombreMoneda = $this->TiposMoneda->find('first', array(
			'conditions'=>array('TiposMoneda.id'=> $listaRequerimiento['SolicitudesRequerimiento']['tipos_moneda_id'] )
		));
		$this->set("tipos_moneda_id", $nombreMoneda['TiposMoneda']['nombre']);

		$codigoPresupuesto = $this->CodigosPresupuesto->find('first', array(
			'conditions'=>array('CodigosPresupuesto.id'=> $listaRequerimiento['SolicitudesRequerimiento']['codigos_presupuesto_id'] )
		));
		$this->set("codigos_presupuesto_id", $codigoPresupuesto['CodigosPresupuesto']['nombre']);

		if($listaRequerimiento['SolicitudesRequerimiento']['tipo_fondo']==1){
			$tipoFondo = "Fondo por rendir";
		}else{
			$tipoFondo = "Fondo fijo";
		}
		$this->set("tipo_fondo", $tipoFondo);

		$estado = $this->ComprasTarjetasEstado->find('list', array(
			'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
			'conditions'=>array('ComprasTarjetasEstado.id'=> array(1,5) )
		));
		
		$this->set("estado", $estado);
		$this->set("observacion", $listaRequerimiento['SolicitudesRequerimiento']['observacion']);

		CakeLog::write('actividad', 'Lista solictudes solicitante' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));

		}
	}


	public function view_todos($id = null) {

		$this->layout = 'angular';
		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("ComprasTarjetasObservacion");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");

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

		$listaRequerimientos = $this->SolicitudesRequerimiento->find("all", array(
			'conditions'=>array('SolicitudesRequerimiento.id'=> $id ,'SolicitudesRequerimiento.estado_solicitud' =>1)
		));
	
	$salida = "";
	foreach($listaRequerimientos as $listaRequerimiento){	
		$this->set("contenido", $listaRequerimiento['SolicitudesRequerimiento']['contenido']);
		$this->set("titulo", $listaRequerimiento['SolicitudesRequerimiento']['titulo']);
		$this->set("fecha", $listaRequerimiento['SolicitudesRequerimiento']['fecha']);
		$this->set("monto", $listaRequerimiento['SolicitudesRequerimiento']['monto']);
		$this->set("moneda_observada", $listaRequerimiento['SolicitudesRequerimiento']['moneda_observada']);
		$this->set("observacion", $listaRequerimiento['SolicitudesRequerimiento']['observacion']);
		$nombrelUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $listaRequerimiento['SolicitudesRequerimiento']['user_id'])
		));
		$this->set("user_id", $nombrelUser['User']['nombre']);

		$codigoDimensionId = $this->Dimensione->find('first', array(
			'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['dimensione_id'] )
		));
		$this->set("dimensione_id", $codigoDimensionId['Dimensione']['nombre']);	


		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['estadios'])){
			$dimensionDos = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['estadios'] )
			));
		}else{
			$dimensionDos['Dimensione']['nombre']="S/N";
		}
		
		$this->set("estadios", $dimensionDos['Dimensione']['nombre']);


		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['contenido'])){
			$dimensionTres = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['contenido'] )
			));
		}else{
			$dimensionTres['Dimensione']['nombre']='S/N';
		}
		
		$this->set("contenido", $dimensionTres['Dimensione']['nombre']);


		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['canal_distribucion'])){
			$dimensionCuatro = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['canal_distribucion'] )
			));
		}else{
			$dimensionCuatro['Dimensione']['nombre']="S/N";
		}
		
		$this->set("canal_distribucion", $dimensionCuatro['Dimensione']['nombre']);


		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['otros'])){
			$dimensionCinco  = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['otros'] )
			));
		}else{
			$dimensionCinco['Dimensione']['nombre']='S/N';
		}

		$this->set("otros", $dimensionCinco['Dimensione']['nombre']);

		if(!empty($listaRequerimiento['SolicitudesRequerimiento']['proyectos'])){

			$proyectos = $this->DimensionesProyecto->find('first', array(
				'conditions'=>array('DimensionesProyecto.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['proyectos'] )
			));
		}else{
			$proyectos['DimensionesProyecto']['nombre']="S/N";
		}

		$this->set("proyectos", $proyectos['DimensionesProyecto']['nombre']);
		
		$nombreMoneda = $this->TiposMoneda->find('first', array(
			'conditions'=>array('TiposMoneda.id'=> $listaRequerimiento['SolicitudesRequerimiento']['tipos_moneda_id'] )
		));
		$this->set("tipos_moneda_id", $nombreMoneda['TiposMoneda']['nombre']);

		$codigoPresupuesto = $this->CodigosPresupuesto->find('first', array(
			'conditions'=>array('CodigosPresupuesto.id'=> $listaRequerimiento['SolicitudesRequerimiento']['codigos_presupuesto_id'] )
		));
		$this->set("codigos_presupuesto_id", $codigoPresupuesto['CodigosPresupuesto']['nombre']);

		if($listaRequerimiento['SolicitudesRequerimiento']['tipo_fondo']==1){
			$tipoFondo = "Fondo por rendir";
		}else{
			$tipoFondo = "Fondo fijo";
		}
		$this->set("tipo_fondo", $tipoFondo);

		$estado = $this->ComprasTarjetasEstado->find('list', array(
			'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
			'conditions'=>array('ComprasTarjetasEstado.id'=> array(1,5) )
		));
		
		$this->set("estado", $estado);

		CakeLog::write('actividad', 'Lista solictudes solicitante' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));

		}
	}


	public function lista_finanza($id = null) {

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
			'conditions'=>array('SolicitudesRequerimiento.compras_tarjeta_estado_id' =>1 , 'SolicitudesRequerimiento.estado_rendicion' =>0)
		));
		if(!empty($listaRequerimientos)){
			$salida = "";
			foreach($listaRequerimientos as $listaRequerimiento){	



				$idRendiciontotal  = $this->SolicitudRendicionTotale->find("first", array(
					'conditions'=>array('SolicitudRendicionTotale.n_solicitud_folio' =>$listaRequerimiento['SolicitudesRequerimiento']['id'])
				));

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

				/*if($listaRequerimiento['SolicitudesRequerimiento']['tipo_fondo']==1){
					$tipoFondo = "Fondo por rendir";
				}else{
					$tipoFondo = "Fondo fijo";
				}*/


				if($listaRequerimiento['SolicitudesRequerimiento']['tipo_fondo']==1){
					$tipoFondo = "Fondo por rendir";
					$moneda = $nombreMoneda['TiposMoneda']['nombre'];
					$monto = $listaRequerimiento['SolicitudesRequerimiento']['monto'];
					$observado = isset($listaRequerimiento['SolicitudesRequerimiento']['moneda_observada'])?$listaRequerimiento['SolicitudesRequerimiento']['moneda_observada']:'S/N';
					$codigoPresupuesto = $this->CodigosPresupuesto->find('first', array(
						'conditions'=>array('CodigosPresupuesto.id'=> $listaRequerimiento['SolicitudesRequerimiento']['codigos_presupuesto_id'] )
					));
					$presupuesto = $codigoPresupuesto['CodigosPresupuesto']['nombre'];

					$codigoDimensionId = $this->Dimensione->find('first', array(
						'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['dimensione_id'] )
					));
					$dimencion = $codigoDimensionId['Dimensione']['nombre'];

				
					$user = $nombrelUser['User']['nombre'];
					$fecha = $listaRequerimiento['SolicitudesRequerimiento']['fecha'];
					$titulo = $listaRequerimiento['SolicitudesRequerimiento']['titulo'];
				}else{

					$montoFijo = $this->MontosFondoFijo->find('first', array(
						'conditions'=>array('MontosFondoFijo.id'=> $idRendiciontotal['SolicitudRendicionTotale']['n_solicitud_folio'] )
					));

					$emailUser = $this->User->find('first', array(
						'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
					));

					$tipoFondo = "Fondo fijo";
					$moneda= "Peso Chileno";
					$monto = $montoFijo['MontosFondoFijo']['monto'];
					$observado = isset($listaRequerimiento['SolicitudesRequerimiento']['moneda_observada'])?$listaRequerimiento['SolicitudesRequerimiento']['moneda_observada']:'S/N';
					$presupuesto = 'S/N';
					$dimencion = 'S/N';
					$user = $emailUser['User']['nombre'];
					$fecha = 'S/N';
					$titulo = 'S/N';
				}

				$salida[] = array(
					'id'=> $listaRequerimiento['SolicitudesRequerimiento']['id'],
					'user_id' =>$user,
					'fecha'=>$fecha,
					'monto'=> number_format($monto,0,",","."),
					'dimensione_id'=> $dimencion,
					'codigos_presupuesto_id'=>$presupuesto,
					'tipos_moneda_id'=> $moneda,
					'moneda_observada'=> $listaRequerimiento['SolicitudesRequerimiento']['moneda_observada'],
					'estadios'=> $dimensionDos['Dimensione']['nombre'],
					'titulo'=> $titulo,
					'contenido'=> $listaRequerimiento['SolicitudesRequerimiento']['contenido'],
					'canal_distribucion'=> $dimensionTres['Dimensione']['nombre'],
					'otros'=> $dimensionCuatro['Dimensione']['nombre'],
					'proyectos'=> isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
					'tipo_fondo'=> $tipoFondo,
					'estado'=>$estadoSolicitud['ComprasTarjetasEstado']['descripcion']
				);
			}
			CakeLog::write('actividad', 'Lista solicitud requerimiento finanzas' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			return json_encode($salida);
		}else{
			return json_encode(array());
		}
		exit;
	
	}


	public function view_solicitud(){
		$this->layout='angular';
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
			'conditions'=>array(
								 'SolicitudesRequerimiento.compras_tarjeta_estado_id'=>array(4,10),
								 'SolicitudesRequerimiento.tipo_fondo'=>1,
								 'SolicitudesRequerimiento.estado_solicitud'=>array(1,0),
								 'SolicitudesRequerimiento.estado_rendicion'=>1
								 )
								 //'SolicitudesRequerimiento.user_id'=>$this->Session->Read("PerfilUsuario.idUsuario")
		));


		//pr($listaRequerimientos);

		//exit;
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

				if($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']== 4){
					$estado='Por Rendir';
				}elseif($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']==10){
					$estado='Por Aprobar';
				}
				$salida[] = array(
					'id'=> $listaRequerimiento['SolicitudesRequerimiento']['id'],
					'user_id' => $nombrelUser['User']['nombre'],
					'n_documento' =>$listaRequerimiento['SolicitudesRequerimiento']['n_documento'],
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
					'proyectos'=> isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
					'tipo_fondo'=> $tipoFondo,
					//'estado'=>$estadoSolicitud['ComprasTarjetasEstado']['descripcion']
					'estado'=>$estado
				);
			}
			CakeLog::write('actividad', 'Lista solicitud requerimiento' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			return json_encode($salida);
		}else{
			return json_encode(array());
		}
		exit;
	}

	public function view_solicitud_rechazadas(){
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
			'conditions'=>array('SolicitudesRequerimiento.compras_tarjeta_estado_id' =>array(5,7),'SolicitudesRequerimiento.user_id' =>$this->Session->Read("PerfilUsuario.idUsuario"))
		));

		if(!empty($listaRequerimientos)){
			$salida = "";
			
			foreach($listaRequerimientos as $listaRequerimiento){

				$idRendiciontotal  = $this->SolicitudRendicionTotale->find("first", array(
					'conditions'=>array('SolicitudRendicionTotale.n_solicitud_folio' =>$listaRequerimiento['SolicitudesRequerimiento']['id'])
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
					'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id'] )
				));

		

				if(isset($idRendiciontotal['SolicitudRendicionTotale']['n_solicitud_folio'])){
					$montoFijo = $this->MontosFondoFijo->find('first', array(
						'conditions'=>array('MontosFondoFijo.id'=> $idRendiciontotal['SolicitudRendicionTotale']['n_solicitud_folio'] )
					));
				}
				
				if(isset($listaRequerimiento['SolicitudesRequerimiento']['id'])){
					$nSolicitud = $this->SolicitudesRequerimiento->find('first', array(
						'conditions'=>array('SolicitudesRequerimiento.id'=> $listaRequerimiento['SolicitudesRequerimiento']['id'])
					));
				}


				$nombrelUser = $this->User->find('first', array(
					'conditions'=>array('User.id' => $listaRequerimiento['SolicitudesRequerimiento']['user_id'])
				));
		
				if($listaRequerimiento['SolicitudesRequerimiento']['tipo_fondo']==1){
					$tipoFondo = "Fondo por rendir";
					$moneda = $nombreMoneda['TiposMoneda']['nombre'];
					$monto = $nSolicitud['SolicitudesRequerimiento']['monto'];
					$observado = isset($listaRequerimiento['SolicitudesRequerimiento']['moneda_observada'])?$listaRequerimiento['SolicitudesRequerimiento']['moneda_observada']:'S/N';
					$codigoPresupuesto = $this->CodigosPresupuesto->find('first', array(
						'conditions'=>array('CodigosPresupuesto.id'=> $listaRequerimiento['SolicitudesRequerimiento']['codigos_presupuesto_id'] )
					));
					$presupuesto = $codigoPresupuesto['CodigosPresupuesto']['nombre'];

					$codigoDimensionId = $this->Dimensione->find('first', array(
						'conditions'=>array('Dimensione.codigo'=> $listaRequerimiento['SolicitudesRequerimiento']['dimensione_id'] )
					));
					$dimencion = $codigoDimensionId['Dimensione']['nombre'];

				
					$user = $nombrelUser['User']['nombre'];
					$fecha = $listaRequerimiento['SolicitudesRequerimiento']['fecha'];
					$titulo = $listaRequerimiento['SolicitudesRequerimiento']['titulo'];
				}else{

					$tipoFondo = "Fondo fijo";
					$moneda= "Peso Chileno";
					$monto = $montoFijo['MontosFondoFijo']['monto'];
					$observado = isset($listaRequerimiento['SolicitudesRequerimiento']['moneda_observada'])?$listaRequerimiento['SolicitudesRequerimiento']['moneda_observada']:'S/N';
					$presupuesto = 'S/N';
					$dimencion = 'S/N';
					$user = $emailUser['User']['nombre'];
					$fecha = 'S/N';
					$titulo = 'S/N';
				}

					if(count($idRendiciontotal)>0){

					
						$salida[] = array(
							'id'=> $idRendiciontotal['SolicitudRendicionTotale']['id'],
							'user_id' => $user,
							'fecha'=>$listaRequerimiento['SolicitudesRequerimiento']['fecha'],
							'monto'=> number_format($monto,0,',','.'),
							'dimensione_id'=> $dimencion,
							'codigos_presupuesto_id'=> $presupuesto,
							'tipos_moneda_id'=> $moneda,
							'moneda_observada'=> $listaRequerimiento['SolicitudesRequerimiento']['moneda_observada'],
							'estadios'=> $dimensionDos['Dimensione']['nombre'],
							'titulo'=> $titulo,
							'contenido'=> $listaRequerimiento['SolicitudesRequerimiento']['contenido'],
							'canal_distribucion'=> $dimensionTres['Dimensione']['nombre'],
							'otros'=> $dimensionCuatro['Dimensione']['nombre'],
							'proyectos'=> isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
							'tipo_fondo'=> $tipoFondo,
							'estado'=>$estadoSolicitud['ComprasTarjetasEstado']['descripcion']
						);
					}
					
			}
			CakeLog::write('actividad', 'Lista solicitud rechazada' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			return json_encode($salida);
		}else{
			return json_encode(array());
		}
		exit;
	
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
		$this->set("titulo", $datosSolicitudfondos[0]['SolicitudesRequerimiento']['titulo']);
		$this->set("idMoneda", $datosSolicitudfondos[0]['SolicitudesRequerimiento']['tipos_moneda_id']);
		$this->set("monedaValor", $datosSolicitudfondos[0]['SolicitudesRequerimiento']['moneda_observada']);

		//$this->data['Leaf']['tipo_moneda_id'] = $datosSolicitudfondos[0]['SolicitudesRequerimiento']['tipos_moneda_id'];

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
		//array_unshift($dimensionCinco, $vacio);
		$dimensionCinco[0] = $vacio;
		ksort($dimensionCinco);
		$this->set("dimensionCinco", $dimensionCinco);
		CakeLog::write('actividad', 'Agrega rendicion de fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		//return $this->Session->setFlash(__('The solicitudes requerimiento has been saved---->3.'));
		
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

	$datosRequerimientos = $this->SolicitudRendicionTotale->find("first", array(
	'conditions'=>array('SolicitudRendicionTotale.id'=>$id)
	));

	if(count($datosRequerimientos)>0){

		$datosRequerimientos = $this->SolicitudRendicionTotale->find("first", array(
			'conditions'=>array('SolicitudRendicionTotale.id'=>$id)
			));

			$datosSolicitudfondos= $this->SolicitudesRequerimiento->find("all", array(
				"conditions"=>array("SolicitudesRequerimiento.id"=>$datosRequerimientos['SolicitudRendicionTotale']['n_solicitud_folio'])
				));

	}else{
		$datosSolicitudfondos= $this->SolicitudesRequerimiento->find("all", array(
			"conditions"=>array("SolicitudesRequerimiento.id"=>$id)
			));
			$datosRequerimientos = $this->SolicitudRendicionTotale->find("first", array(
				'conditions'=>array('SolicitudRendicionTotale.n_solicitud_folio'=>$id)
				));
	}


	//	pr($datosRequerimientos);
	//	exit;
	$this->set("fechasss", $datosRequerimientos['SolicitudRendicionTotale']['fecha_documento']);
	//$this->set("proveedor", $datosRequerimientos['SolicitudRendicionTotale']['company_id']);
	$this->set("titulo", $datosRequerimientos['SolicitudRendicionTotale']['titulo']);
	$this->set("observacion", $datosRequerimientos['SolicitudRendicionTotale']['observacion']);
	$this->set("idsolicitud", $datosRequerimientos['SolicitudRendicionTotale']['id']);
	//$this->set("idMoneda", $datosSolicitudfondos[0]['SolicitudesRequerimiento']['tipos_moneda_id']);

	$this->set("url", $datosRequerimientos['SolicitudRendicionTotale']['url_documento']);

	$datosSolicitudfondos= $this->SolicitudesRequerimiento->find("all", array(
	"conditions"=>array("SolicitudesRequerimiento.id"=>$datosRequerimientos['SolicitudRendicionTotale']['n_solicitud_folio'])
	));
	$this->set("ndocumento", $datosSolicitudfondos[0]['SolicitudesRequerimiento']['id']);

	if($datosSolicitudfondos[0]['SolicitudesRequerimiento']['tipo_fondo']){
		$tipoFondo = "Fondo por rendir";
	}else{
		$tipoFondo = "Fondo fijo";
	}
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
	$plazosPagos[0] = $vacio;
	ksort($plazosPagos);
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

			$datosSolicitudfondos= $this->SolicitudesRequerimiento->find("all", array(
				"conditions"=>array("SolicitudesRequerimiento.id"=>$datosRequerimientos['SolicitudRendicionTotale']['n_solicitud_folio'])
			));

			$nSolicitud = $this->SolicitudesRequerimiento->find('first', array(
				'conditions'=>array('SolicitudesRequerimiento.id'=> $datosRequerimientos['SolicitudRendicionTotale']['n_solicitud_folio'] )
			));

			$montoFijo = $this->MontosFondoFijo->find('first', array(
				'conditions'=>array('MontosFondoFijo.id'=> $datosRequerimientos['SolicitudRendicionTotale']['n_solicitud_folio'])
			));

			$nombreMoneda = $this->TiposMoneda->find('first', array(
				'conditions'=>array('TiposMoneda.id'=> $nSolicitud['SolicitudesRequerimiento']['tipos_moneda_id'])
			));
	
			if($nSolicitud['SolicitudesRequerimiento']['tipo_fondo']==1){
				$tipoFondo = "Fondo por rendir";
				$moneda = $nSolicitud['SolicitudesRequerimiento']['tipos_moneda_id'];
				$monto = $nSolicitud['SolicitudesRequerimiento']['monto'];
				$observado = isset($nSolicitud['SolicitudesRequerimiento']['moneda_observada'])?$nSolicitud['SolicitudesRequerimiento']['moneda_observada']:'S/N';
			}else{
				$tipoFondo = "Fondo fijo";
				$moneda = 1;
				$monto = $montoFijo['MontosFondoFijo']['monto'];
				$observado = isset($nSolicitud['SolicitudesRequerimiento']['moneda_observada'])?$nSolicitud['SolicitudesRequerimiento']['moneda_observada']:'S/N';
			}

			$salida[] = array(
				'fecha'=>$datosRequerimientos['SolicitudRendicionTotale']['fecha_documento'],
				//'proveedor'=>$datosRequerimientos['SolicitudRendicionTotale']['company_id'],
				'titulo'=>$datosRequerimientos['SolicitudRendicionTotale']['titulo'],
				'observacion'=>$datosRequerimientos['SolicitudRendicionTotale']['observacion'],
				'idsolicitud'=>$datosRequerimientos['SolicitudRendicionTotale']['id'],
				'nmonto'=>$monto,
				'ndocumento'=>$datosSolicitudfondos[0]['SolicitudesRequerimiento']['id'],
				'moneda'=>$moneda,
				'valorMoneda'=>isset($nSolicitud['SolicitudesRequerimiento']['moneda_observada'])?$nSolicitud['SolicitudesRequerimiento']['moneda_observada']:1
			);
			CakeLog::write('actividad', 'Lista rendicion de fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			echo json_encode($salida);
			exit;
		}

	}



	public function datosDimenciones(){
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

			$datosSolicitudfondos= $this->SolicitudesRequerimiento->find("first", array(
				"conditions"=>array("SolicitudesRequerimiento.id"=>$this->request->query['id'])
			));
			$salida[] = array(
				'dimensione_id'=>$datosSolicitudfondos['SolicitudesRequerimiento']['dimensione_id'],
				'codigo_presupuesto'=>$datosSolicitudfondos['SolicitudesRequerimiento']['codigos_presupuesto_id'],
				'estadios'=>$datosSolicitudfondos['SolicitudesRequerimiento']['estadios'],
				'contenido'=>$datosSolicitudfondos['SolicitudesRequerimiento']['contenido'],
				'canal_distribucion'=>$datosSolicitudfondos['SolicitudesRequerimiento']['canal_distribucion'],
				'otros'=>$datosSolicitudfondos['SolicitudesRequerimiento']['otros'],
				'proyectos'=>$datosSolicitudfondos['SolicitudesRequerimiento']['proyectos'],
			);
			CakeLog::write('actividad', 'Lista rendicion de fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			echo json_encode($salida);
			exit;
		}
	}

	public function add_rendicion_fondos_rechazo(){
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("SolicitudesRequerimiento");
		$this->layout = null;
		
		if(!empty($this->request->query)){
			$salida = "";

			$ProductosCompra = $this->SolicitudesRendicionFondo->find("all",array(
				'conditions'=>array('SolicitudesRendicionFondo.id_solicitudes_rendicion_fondo' =>$this->request->query['id'])
			));

			if(count($ProductosCompra)>0){
				foreach($ProductosCompra as $h => $j){
					$salida[] = array(
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
						'proyecto'=>$j['SolicitudesRendicionFondo']['proyectos'],
						'sub'=>number_format(($j['SolicitudesRendicionFondo']['cantidad'] * str_replace(".","",$j['SolicitudesRendicionFondo']['precio'])),0,',','.'),
						'tipo_impuesto'=>$j['SolicitudesRendicionFondo']['tipo_impuesto']
					);
				}
				CakeLog::write('actividad', 'lista solicitud rendicion fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				echo json_encode($salida);

			}else{
				echo json_encode(array());
			}
		
		}
		exit;
	}



	public function view_lista(){
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
		$this->loadModel("SolicitudRendicionTotale");

	$listaRequerimientos = $this->SolicitudesRequerimiento->find("all", array(
		'conditions'=>array('SolicitudesRequerimiento.estado_solicitud'=>1, 'SolicitudesRequerimiento.tipo_fondo'=>1)
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

				$idRencion = $this->SolicitudRendicionTotale->find('first', array(
					'conditions'=>array('SolicitudRendicionTotale.n_solicitud_folio'=> $listaRequerimiento['SolicitudesRequerimiento']['id'] )
				));
				if($listaRequerimiento['SolicitudesRequerimiento']['estado_rendicion']==1 && ($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']==5 || $idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']==7)){
					$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
						'conditions'=>array('ComprasTarjetasEstado.id'=> $idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])
					));
					switch ($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']) {
						case 5:
						$valor=  "Area rechaza rendicion";
							break;
						case 7:
						$valor=  "Finanza rechaza rendicion";
						break;
					}
				}elseif($listaRequerimiento['SolicitudesRequerimiento']['estado_rendicion']==1 && ($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']==1 || $idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']==4)){
					$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
						'conditions'=>array('ComprasTarjetasEstado.id'=> $idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'] )
					));
					switch ($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id']) {
						case 1:
						$valor=  "Area aprueba rendicion";
							break;
						case 4:
						$valor=  "Finanza aprueba rendicion";
						break;
					}
				}else{
					if(empty($idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])){
						$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
							'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id'])
						));
						if($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']== 4){
							$valor='Por Rendir';
						}elseif($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']==10){
							$valor='Por Aprobar';
						}else{
							$valor=  $estadoSolicitud['ComprasTarjetasEstado']['descripcion'];
						}
					}else{
						$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
							'conditions'=>array('ComprasTarjetasEstado.id'=>  $idRencion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'])
						));
			
						if($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']== 4){
							$valor='Por Rendir';
						}elseif($listaRequerimiento['SolicitudesRequerimiento']['compras_tarjeta_estado_id']==10){
							$valor='Por Aprobar';
						}else{
							$valor=  $estadoSolicitud['ComprasTarjetasEstado']['descripcion'];
						}
						
			
					}
					
				}
			
			
		
				$salida[] = array(
                    'id'=>$listaRequerimiento['SolicitudesRequerimiento']['id'] ,
                    'idRendicion'=> isset($idRencion['SolicitudRendicionTotale']['id'])?$idRencion['SolicitudRendicionTotale']['id']:'',
                    'user_id' => $nombrelUser['User']['nombre'],
                    'fecha'=>$listaRequerimiento['SolicitudesRequerimiento']['fecha'],
                    'monto'=> number_format($listaRequerimiento['SolicitudesRequerimiento']['monto'],0,",","."),
                    'dimensione_id'=> isset($codigoDimensionId['Dimensione']['nombre'])?$codigoDimensionId['Dimensione']['nombre']:'S/N',
                    'codigos_presupuesto_id'=> isset($codigoPresupuesto['CodigosPresupuesto']['nombre'])?$codigoPresupuesto['CodigosPresupuesto']['nombre']:'S/N',
                    'tipos_moneda_id'=> $nombreMoneda['TiposMoneda']['nombre'],
                    'moneda_observada'=> $listaRequerimiento['SolicitudesRequerimiento']['moneda_observada'],
                    'estadios'=> $dimensionDos['Dimensione']['nombre'],
                    'titulo'=> $listaRequerimiento['SolicitudesRequerimiento']['titulo'],
                    'contenido'=> $listaRequerimiento['SolicitudesRequerimiento']['contenido'],
                    'canal_distribucion'=> $dimensionTres['Dimensione']['nombre'],
                    'otros'=> $dimensionCuatro['Dimensione']['nombre'],
                    'proyectos'=> isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
                    'tipo_fondo'=> $tipoFondo,
                    'estadoNombre'=>$valor,
                    'n_documento'=>$listaRequerimiento['SolicitudesRequerimiento']['n_documento']
				);
			}
			return json_encode($salida);
		}else{
			return json_encode(array());
		}
		CakeLog::write('actividad', 'Lista requerimientos fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		exit;

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


	public function	view_rendicion_area(){

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
		$this->loadModel("SolicitudRendicionTotale");
		
			$listaRendiciones = $this->SolicitudRendicionTotale->find("all", array(
				'conditions'=>array(
				'SolicitudRendicionTotale.compras_tarjeta_estado_id'=> 1,
				'SolicitudRendicionTotale.tipo_fondo'=> 1 )
			));

			if(!empty($listaRendiciones)){
				$salida = "";
				foreach($listaRendiciones as $listaRendicion){	

					
					$estado = $this->ComprasTarjetasEstado->find('first', array(
						'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRendicion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'] )
					));
	
					$nSolicitud = $this->SolicitudesRequerimiento->find('first', array(
						'conditions'=>array('SolicitudesRequerimiento.tipo_fondo'=>1 , 'SolicitudesRequerimiento.id'=>$listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'] )
					));
					
	
					if($nSolicitud['SolicitudesRequerimiento']['tipo_fondo']==1){
						$nombreMoneda = $this->TiposMoneda->find('first', array(
							'conditions'=>array('TiposMoneda.id'=> $nSolicitud['SolicitudesRequerimiento']['tipos_moneda_id'])
						));
		
						$montoFijo = $this->MontosFondoFijo->find('first', array(
							'conditions'=>array('MontosFondoFijo.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'])
						));
						$tipoFondo = "Fondo por rendir";
						$moneda = $nombreMoneda['TiposMoneda']['nombre'];
						$monto = $nSolicitud['SolicitudesRequerimiento']['monto'];
						$observado = isset($nSolicitud['SolicitudesRequerimiento']['moneda_observada'])?$nSolicitud['SolicitudesRequerimiento']['moneda_observada']:'S/N';


					$salida[] = array(
						'id'=> $listaRendicion['SolicitudRendicionTotale']['id'],
						'fecha_documento' => $listaRendicion['SolicitudRendicionTotale']['fecha_documento'],
						'n_solicitud_folio'=>$listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'],
						'monto'=> number_format($monto,0,",","."),
						'titulo'=> $listaRendicion['SolicitudRendicionTotale']['titulo'],
						'url_documento'=> $listaRendicion['SolicitudRendicionTotale']['url_documento'],
						'observacion'=> $listaRendicion['SolicitudRendicionTotale']['observacion'],
						'total'=> number_format($listaRendicion['SolicitudRendicionTotale']['total'],0,",","."),
						'tipos_moneda_id'=> $moneda,
						'tipo_fondo'=> $tipoFondo,
						'moneda_observada'=> $observado,
						'motivo'=> $listaRendicion['SolicitudRendicionTotale']['motivo'],
						'estado'=> $estado['ComprasTarjetasEstado']['descripcion']
					);

					
					}else{
						return json_encode(array());
					}
				}
				CakeLog::write('actividad', 'Lista rendicon de fondos Totales' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
						return json_encode($salida);
				
			}else{
				return json_encode(array());
			}
		exit;
	}



	public function view_detalle($id = null) {
		$this->layout = 'angular';
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("User");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("Company");
		$this->loadModel("SolicitudRendicionTotale");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("MontosFondoFijo");
		$this->loadModel("TiposMoneda");
		
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

		$listaRendicion = $this->SolicitudRendicionTotale->find('first',array(
			'conditions'=>array('SolicitudRendicionTotale.id' => $id)
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

		if(isset($nSolicitud['SolicitudesRequerimiento']['tipos_moneda_id'])){
			$nombreMoneda = $this->TiposMoneda->find('first', array(
				'conditions'=>array('TiposMoneda.id'=> $nSolicitud['SolicitudesRequerimiento']['tipos_moneda_id'])
			));
		}
		if(isset($nSolicitud['SolicitudesRequerimiento']['tipo_fondo'])){
			if($nSolicitud['SolicitudesRequerimiento']['tipo_fondo']==1){
				$tipoFondo = "Fondo por rendir";
				$moneda = isset($nombreMoneda['TiposMoneda']['nombre'])?$nombreMoneda['TiposMoneda']['nombre']:'';
				$monto = $nSolicitud['SolicitudesRequerimiento']['monto'];
				$observado = $nSolicitud['SolicitudesRequerimiento']['moneda_observada'];
			}
		}else{
			$tipoFondo = "Fondo fijo";
			$moneda= "Peso Chileno";
			$monto = $montoFijo['MontosFondoFijo']['monto'];
			$observado = 'S/N';
		}

		$this->set("id", $listaRendicion['SolicitudRendicionTotale']['id']);
		$this->set("fecha_documento", $listaRendicion['SolicitudRendicionTotale']['fecha_documento']);
		$this->set("n_solicitud_folio", $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio']);
		$this->set("monto", number_format($monto,0,',','.'));
		$this->set("titulo", $listaRendicion['SolicitudRendicionTotale']['titulo']);
		$this->set("url_documento", $listaRendicion['SolicitudRendicionTotale']['url_documento']);
		$this->set("observacion", $listaRendicion['SolicitudRendicionTotale']['observacion']);
		$this->set("total", number_format($monto,0,',','.'));
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
		
		$this->set("listaRendicionFondo", $listaRendicionFondo);
		$listaEstado = $this->ComprasTarjetasEstado->find('list', array(
			'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
			'conditions'=>array('ComprasTarjetasEstado.id'=> $areas )
		));
		$this->set("listaEstado", $listaEstado);
		//$this->set("tipo", $tipo);
		CakeLog::write('actividad', 'Visualiza solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		//exit;
	}


	public function view_detalleRendicion($id = null) {
		$this->layout = 'angular';
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("User");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("Company");
		$this->loadModel("SolicitudRendicionTotale");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("MontosFondoFijo");
		$this->loadModel("TiposMoneda");
		
	

		$listaRendicion = $this->SolicitudRendicionTotale->find('first',array(
			'conditions'=>array('SolicitudRendicionTotale.id' => $id)
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

		if(isset($nSolicitud['SolicitudesRequerimiento']['tipos_moneda_id'])){
			$nombreMoneda = $this->TiposMoneda->find('first', array(
				'conditions'=>array('TiposMoneda.id'=> $nSolicitud['SolicitudesRequerimiento']['tipos_moneda_id'])
			));
		}
		if(isset($nSolicitud['SolicitudesRequerimiento']['tipo_fondo'])){
			if($nSolicitud['SolicitudesRequerimiento']['tipo_fondo']==1){
				$tipoFondo = "Fondo por rendir";
				$moneda = isset($nombreMoneda['TiposMoneda']['nombre'])?$nombreMoneda['TiposMoneda']['nombre']:'';
				$monto = $nSolicitud['SolicitudesRequerimiento']['monto'];
				$observado = $nSolicitud['SolicitudesRequerimiento']['moneda_observada'];
			}
		}else{
			$tipoFondo = "Fondo fijo";
			$moneda= "Peso Chileno";
			$monto = $montoFijo['MontosFondoFijo']['monto'];
			$observado = 'S/N';
		}

		$this->set("id", $listaRendicion['SolicitudRendicionTotale']['id']);
		$this->set("fecha_documento", $listaRendicion['SolicitudRendicionTotale']['fecha_documento']);
		$this->set("n_solicitud_folio", $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio']);
		$this->set("monto", number_format($monto,0,',','.'));
		$this->set("titulo", $listaRendicion['SolicitudRendicionTotale']['titulo']);
		$this->set("url_documento", $listaRendicion['SolicitudRendicionTotale']['url_documento']);
		$this->set("observacion", $listaRendicion['SolicitudRendicionTotale']['observacion']);
		$this->set("total", number_format($monto,0,',','.'));
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
		
		$this->set("listaRendicionFondo", $listaRendicionFondo);
		$listaEstado = $this->ComprasTarjetasEstado->find('list', array(
			'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
			'conditions'=>array('ComprasTarjetasEstado.id'=> $areas )
		));
		$this->set("listaEstado", $listaEstado);
		//$this->set("tipo", $tipo);
		CakeLog::write('actividad', 'Visualiza solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		//exit;
	}


	public function view_detalleRendicionTodos($id = null) {
		$this->layout = 'angular';
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("User");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("Company");
		$this->loadModel("SolicitudRendicionTotale");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("MontosFondoFijo");
		$this->loadModel("TiposMoneda");
		

		$listaRendicion = $this->SolicitudRendicionTotale->find('first',array(
			'conditions'=>array('SolicitudRendicionTotale.id' => $id)
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

		if(isset($nSolicitud['SolicitudesRequerimiento']['tipos_moneda_id'])){
			$nombreMoneda = $this->TiposMoneda->find('first', array(
				'conditions'=>array('TiposMoneda.id'=> $nSolicitud['SolicitudesRequerimiento']['tipos_moneda_id'])
			));
		}
		if(isset($nSolicitud['SolicitudesRequerimiento']['tipo_fondo'])){
			if($nSolicitud['SolicitudesRequerimiento']['tipo_fondo']==1){
				$tipoFondo = "Fondo por rendir";
				$moneda = isset($nombreMoneda['TiposMoneda']['nombre'])?$nombreMoneda['TiposMoneda']['nombre']:'';
				$monto = $nSolicitud['SolicitudesRequerimiento']['monto'];
				$observado = $nSolicitud['SolicitudesRequerimiento']['moneda_observada'];
			}
		}else{
			$tipoFondo = "Fondo fijo";
			$moneda= "Peso Chileno";
			$monto = $montoFijo['MontosFondoFijo']['monto'];
			$observado = 'S/N';
		}

		$this->set("id", $listaRendicion['SolicitudRendicionTotale']['id']);
		$this->set("fecha_documento", $listaRendicion['SolicitudRendicionTotale']['fecha_documento']);
		$this->set("n_solicitud_folio", $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio']);
		$this->set("monto", number_format($monto,0,',','.'));
		$this->set("titulo", $listaRendicion['SolicitudRendicionTotale']['titulo']);
		$this->set("url_documento", $listaRendicion['SolicitudRendicionTotale']['url_documento']);
		$this->set("observacion", $listaRendicion['SolicitudRendicionTotale']['observacion']);
		$this->set("total", number_format($monto,0,',','.'));
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
		
		$this->set("listaRendicionFondo", $listaRendicionFondo);
		$listaEstado = $this->ComprasTarjetasEstado->find('list', array(
			'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
			'conditions'=>array('ComprasTarjetasEstado.id'=> $areas )
		));
		$this->set("listaEstado", $listaEstado);
		//$this->set("tipo", $tipo);
		CakeLog::write('actividad', 'Visualiza solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		//exit;
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
	
		$listaRendiciones = $this->SolicitudRendicionTotale->find("all",array(
			'conditions'=>array('SolicitudRendicionTotale.compras_tarjeta_estado_id'=> 3,'SolicitudRendicionTotale.tipo_fondo'=>1 )
		));

			if(!empty($listaRendiciones)){
				$salida = "";
				foreach($listaRendiciones as $listaRendicion){
					
					$estado = $this->ComprasTarjetasEstado->find('first', array(
						'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRendicion['SolicitudRendicionTotale']['compras_tarjeta_estado_id'] )
					));

					$nSolicitud = $this->SolicitudesRequerimiento->find('first', array(
						'conditions'=>array('SolicitudesRequerimiento.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'])
					));
					$montoFijo = $this->MontosFondoFijo->find('first', array(
						'conditions'=>array('MontosFondoFijo.id'=> $listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'])
					));

					if($nSolicitud['SolicitudesRequerimiento']['tipo_fondo']==1){
						$tipoFondo = "Fondo por rendir";

						$nombreMoneda = $this->TiposMoneda->find('first', array(
							'conditions'=>array('TiposMoneda.id'=> $nSolicitud['SolicitudesRequerimiento']['tipos_moneda_id'])
						));
						$moneda= $nombreMoneda['TiposMoneda']['nombre'];
					
						$monto = $nSolicitud['SolicitudesRequerimiento']['monto'];
						$observado = isset($nSolicitud['SolicitudesRequerimiento']['moneda_observada'])?$nSolicitud['SolicitudesRequerimiento']['moneda_observada']:'S/N';
						$salida[] = array(
							'id'=> $listaRendicion['SolicitudRendicionTotale']['id'],
							'fecha_documento' => $listaRendicion['SolicitudRendicionTotale']['fecha_documento'],
							'n_solicitud_folio'=>$listaRendicion['SolicitudRendicionTotale']['n_solicitud_folio'],
							'monto'=> number_format($nSolicitud['SolicitudesRequerimiento']['monto'],0,',','.'),
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
					}else{
						return json_encode(array());

					}
				}
				return json_encode($salida);
			}else{
				return json_encode(array());
			}
		exit;
	}

	public function detalleRendicion(){

	}
	

}
