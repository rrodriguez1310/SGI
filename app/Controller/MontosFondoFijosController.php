<?php
App::uses('AppController', 'Controller');
/**
 * MontosFondoFijos Controller
 *
 * @property MontosFondoFijo $MontosFondoFijo
 * @property PaginatorComponent $Paginator
 */
class MontosFondoFijosController extends AppController {

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
		//$this->MontosFondoFijo->recursive = 0;
		//$this->set('montosFondoFijos', $this->Paginator->paginate());
	}


	public function list_montos_fijos(){
		$this->layout = 'ajax';
		$this->loadModel("Dimensione");
		$this->loadModel("TiposMoneda");
		$email = $this->User->find('first', array(
			'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
		));
		$listaMontosFijos = $this->MontosFondoFijo->find("all", array(
			//'conditions'=>array('MontosFondoFijo.encargado'=>$email['Trabajadore']['email'])
		));
		if(!empty($listaMontosFijos)){
			foreach($listaMontosFijos as $listaMontosFijo){	
				/*$codigoDimensionId = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo'=> $listaMontosFijo['SolicitudesRequerimiento']['dimensione_id'] )
				));*/

				if($listaMontosFijo['MontosFondoFijo']['estado']==1){
					$estado = "Activo";
				}else{
					$estado = "No activo";
				}

				$tipoMonedas = $this->TiposMoneda->find('first', array(
					'conditions'=>array('TiposMoneda.id'=>$listaMontosFijo['MontosFondoFijo']['id_moneda'])
				));
		
				$salida[] = array(
					'id'=> $listaMontosFijo['MontosFondoFijo']['id'],
					'titulo' => $listaMontosFijo['MontosFondoFijo']['titulo'],
					'area'=> $listaMontosFijo['MontosFondoFijo']['area'],
					'moneda'=> $tipoMonedas['TiposMoneda']['nombre'],
					'monto'=> number_format($listaMontosFijo['MontosFondoFijo']['monto'],0,',','.'),
					'estado'=> $estado,
					'encargado'=> $listaMontosFijo['MontosFondoFijo']['encargado']
				);
			}
				echo json_encode($salida);
		}else{
			echo json_encode(array());
		}

		exit;
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
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
		if (!$this->MontosFondoFijo->exists($id)) {
			throw new NotFoundException(__('Invalid montos fondo fijo'));
		}
		$options = array('conditions' => array('MontosFondoFijo.' . $this->MontosFondoFijo->primaryKey => $id));
		$this->set('montosFondoFijo', $this->MontosFondoFijo->find('first', $options));
	}




	public function add_montos(){
	
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("Trabajadore");
		$this->loadModel("TiposMoneda");

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


		$usuario = $this->User->find("list", array(
			'conditions'=>array('User.estado'=> 1),
			'fields'=>array('User.trabajadore_id', 'User.nombre'),
		));

		$this->set("usuario", $usuario);

		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);

		if ($this->request->is('post')) {

                $dimensiones = $this->Dimensione->find("first", array(
                    'conditions'=>array('Dimensione.codigo'=> $this->request['data']['MontosFondoFijos']['area'])
				));

				$usuarioMail = $this->Trabajadore->find("first", array(
					'conditions'=>array('Trabajadore.id'=> $this->request['data']['MontosFondoFijos']['encargado']),
					"recursive" => -1
				));

				$this->request->data['MontosFondoFijos']['area']= $dimensiones['Dimensione']['codigo_corto'];
				$this->request->data['MontosFondoFijos']['encargado']= $usuarioMail['Trabajadore']['email'];
				$this->request->data['MontosFondoFijos']['id_moneda'] = $this->request['data']['MontosFondoFijos']['moneda'];
				$this->request->data['MontosFondoFijos']['monto'] = str_replace (".","",$this->request['data']['MontosFondoFijos']['monto']);
				
            if ($this->MontosFondoFijo->save($this->request->data['MontosFondoFijos'])) {
               	$this->Session->setFlash('Fondo fijo ingresado', 'msg_exito');
                //verificar el listado donde va a llegar
                return $this->redirect(array("action" => 'index'));
        
            } 
        }

	}

/**
 * add method
 *
 * @return void
 */
	public function add($id="") {

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

	//$this->loadModel("SolicitudesRequerimiento");

	
	$datosMontosFijos= $this->MontosFondoFijo->find("first", array(
		"conditions"=>array("MontosFondoFijo.id"=>$id)
	));


	$this->set("ndocumento", $datosMontosFijos['MontosFondoFijo']['id']);
	$this->set("nmonto", number_format($datosMontosFijos['MontosFondoFijo']['monto']));

	$this->set("tipoFondo", "Fondo fijo");

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
		//$this->Session->setFlash('No hay documentos tributarios cargados anteriormente', 'msg_fallo');
		//return $this->redirect(array("action"=>'index'));
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


	$valorMoneda = $this->TiposMoneda->find("first", array(
		"conditions"=>array("TiposMoneda.id"=>$datosMontosFijos['MontosFondoFijo']['id_moneda']),
	));

	$this->set("idMoneda", $valorMoneda['TiposMoneda']['id']);
	$this->set("valorMoneda", $valorMoneda['TiposMoneda']['valor']);
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
	CakeLog::write('actividad', 'Agrega fondo fijo' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	
	//return $this->flash(__('Agrega fondo fijo'));
	/*if ($this->request->is('post')) {
			$this->MontosFondoFijo->create();
			if ($this->MontosFondoFijo->save($this->request->data)) {
				return $this->flash(__('The montos fondo fijo has been saved.'), array('action' => 'index'));
			}
		}*/
	}







/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("Trabajadore");
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

		$estado = $this->MontosFondoFijo->find("first", array(
			'conditions'=>array("MontosFondoFijo.id"=>$id)
		));
		$this->set("estado", $estado['MontosFondoFijo']['estado']);

		$usuario = $this->User->find("list", array(
			'conditions'=>array('User.estado'=> 1),
			'fields'=>array('User.trabajadore_id', 'User.nombre'),
		));

		$this->set("usuario", $usuario);

		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);

		$encargado = $this->MontosFondoFijo->find("first", array(
			'conditions'=>array("MontosFondoFijo.id"=>$id)
		));


		$userEncargado = $this->Trabajadore->find("first", array(
			'conditions'=>array("Trabajadore.email"=>$encargado['MontosFondoFijo']['encargado'])
		));

		$this->set("encargado", $userEncargado['Trabajadore']['id']);

		if (!$this->MontosFondoFijo->exists($id)) {
			throw new NotFoundException(__('Invalid montos fondo fijo'));
		}

		if ($this->request->is(array('post', 'put'))) {
			$dimensiones = $this->Dimensione->find("first", array(
				'conditions'=>array('Dimensione.codigo'=> $this->request->data['MontosFondoFijo']['area'] )
			));
			$this->request->data['MontosFondoFijo']['id'] = $id;
			$this->request->data['MontosFondoFijo']['estado']= $this->request->data['estado'];
			$this->request->data['MontosFondoFijo']['area']= $dimensiones['Dimensione']['codigo_corto'];
			if ($this->MontosFondoFijo->save($this->request->data)) {
				CakeLog::write('actividad', 'Edita fondo fijo' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				//return $this->flash(__('Fondo fijo actualizado.'), $this->redirect(array("action"=>'index')));
				 //;
			}
		} else {
			$options = array('conditions' => array('MontosFondoFijo.' . $this->MontosFondoFijo->primaryKey => $id));
			$this->request->data = $this->MontosFondoFijo->find('first', $options);
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
		$this->MontosFondoFijo->id = (int)$id;
		if (!$this->MontosFondoFijo->exists()) {
			throw new NotFoundException(__('Invalid montos fondo fijo'));
		}
		$this->request->allowMethod('get', 'delete');
		if ($this->MontosFondoFijo->delete()) {
			//return $this->flash(__('The montos fondo fijo has been deleted.'), array('action' => 'index'));
			CakeLog::write('actividad', 'Elimina fondo fijo' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			$this->flash(__('Fondo fijo eliminado.'));
			//return $this->redirect(array('action' => 'index'));
		} else {
			return $this->flash(__('The montos fondo fijo could not be deleted. Please, try again.'), array('action' => 'index'));
		}
	}

	public function view_lista_montos(){
		$this->layout = 'angular';
	}


	public function lista_montos(){

		$this->layout = 'ajax';
		$this->loadModel("Dimensione");
		$this->loadModel("TiposMoneda");

		$listaMontosFijos = $this->MontosFondoFijo->find("all", array(
			//'conditions'=>array('MontosFondoFijo.encargado'=>$email['Trabajadore']['email'])
		));
		if(!empty($listaMontosFijos)){
			foreach($listaMontosFijos as $listaMontosFijo){	
				/*$codigoDimensionId = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo'=> $listaMontosFijo['SolicitudesRequerimiento']['dimensione_id'] )
				));*/

				if($listaMontosFijo['MontosFondoFijo']['estado']==1){
					$estado = "Activo";
				}else{
					$estado = "No activo";
				}

				$tipoMonedas = $this->TiposMoneda->find('first', array(
					'conditions'=>array('TiposMoneda.id'=>$listaMontosFijo['MontosFondoFijo']['id_moneda'])
				));
		
				$salida[] = array(
					'id'=> $listaMontosFijo['MontosFondoFijo']['id'],
					'titulo' => $listaMontosFijo['MontosFondoFijo']['titulo'],
					'area'=> $listaMontosFijo['MontosFondoFijo']['area'],
					'moneda'=> $tipoMonedas['TiposMoneda']['nombre'],
					'monto'=> $listaMontosFijo['MontosFondoFijo']['monto'],
					'estado'=> $estado,
					'encargado'=> $listaMontosFijo['MontosFondoFijo']['encargado']
				);
			}
				echo json_encode($salida);
		}else{
			echo json_encode(array());
		}

		exit;

	}
}
