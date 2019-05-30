<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * RecognitionCollaborators Controller
 *
 * @property RecognitionCollaborator $RecognitionCollaborator
 * @property PaginatorComponent $Paginator
 */
class RecognitionCollaboratorsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	/**
 * Servicio de productos
 *@author Mapalencia <email@email.com>
 * @var array
 */
	public function products_json() {
		$this->layout = null;
		$this->loadModel("RecognitionProduct");
		$this->response->type('json');
		$salida = $this->RecognitionProduct->find('all',array(
			"conditions"=>array("RecognitionProduct.statu_id" => 1,
				"RecognitionProduct.quantity >" => 0),
			"recursive"=>-1
		));

		$salidaJson ="";

		foreach($salida as $value){
			$salidaJson[] = array(
				'id'=>$value['RecognitionProduct']['id'],
				'name'=>ucwords($value['RecognitionProduct']['name']),
				'image'=>$value['RecognitionProduct']['image'],
				'imagedir'=>$value['RecognitionProduct']['imagedir'],
				'points'=>$value['RecognitionProduct']['points'],
				'quantity'=>$value['RecognitionProduct']['quantity'],
				'descrption'=>ucwords($value['RecognitionProduct']['descrption']),
				'created'=>$value['RecognitionProduct']['created'],
				'modified'=>$value['RecognitionProduct']['modified']	
			);
		}
		
		echo json_encode($salidaJson);
		exit;
	}

/**
* Vista con productos
*@author Mapalencia <email@email.com>
* @var array
*/
	public function products(){
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */
		$this->layout = "angular";
	}

/**
 * Servicio Estado de cuenta colaborador
 *
 * @var array
 */

	public function collaborator_json(){
		$this->loadModel("User");
		$this->layout = null;
		$this->response->type('json');

		$datosUser = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
		"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
			));
			
			$salida = $this->RecognitionCollaborator->find("all", array(
				'conditions'=>array("Employed.estado" => "Activo",
			"RecognitionCollaborator.employed_id" => $datosUser["User"]["trabajadore_id"]),
					'order' => 'RecognitionCollaborator.id DESC',
				"recursive"=>0
			));
			
		$this->set(compact('salida',$salida));

		$salidaJson ="";
		foreach($salida as $value){
			$salidaJson[] = array(
				'id'=>$value['RecognitionCollaborator']['id'],
				'fecha'=>date('d/m/y h:i:s', strtotime($value['RecognitionCollaborator']['created'])),
				'producto'=>ucwords($value['Product']['name']),
				'descripcion'=>ucwords($value['Product']['descrption']),
				'detalle'=>ucwords($value['RecognitionCollaborator']['descrption']),
				'ingresos'=>$value['RecognitionCollaborator']['points_add'],
				'egresos'=>$value['RecognitionCollaborator']['points_delete'],
				'product_id'=>$value['Product']['id'],
				'image'=>$value['Product']['image'],
				'imagedir'=>$value['Product']['imagedir'],
				'cambio'=>$value['RecognitionCollaborator']['change'],
				'subconduta'=>ucwords($value['Subconducts']['name']),

			);
		}
		echo json_encode($salidaJson);
		exit;
	}

	public function collaborator() {
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */
		$this->loadModel("User");
		$this->loadModel("Trabajadore");

		$datosUser = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
		"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
			));
		
		/*$salida = $this->RecognitionCollaborator->find("all",array(
			"fields"=>array("Employed.nombre", "Employed.apellido_paterno"),
			'conditions'=>array("RecognitionCollaborator.employed_id" => 509 $datosUser["User"]["trabajadore_id"])	
		));*/

		$salida = $this->Trabajadore->find('all',array(
			"fields"=>array("Trabajadore.nombre", "Trabajadore.apellido_paterno"),
		'conditions'=>array('Trabajadore.id' => $datosUser["User"]["trabajadore_id"] ),
		"recursive"=>0
		));

		$puntosColaborador = $this->RecognitionCollaborator->find("all", array(
			"fields"=>array("sum(RecognitionCollaborator.points_add) - sum(RecognitionCollaborator.points_delete) as disponible"),
			'conditions'=>array("RecognitionCollaborator.employed_id" => $datosUser["User"]["trabajadore_id"])
		));

		$this->set(compact('salida','puntosColaborador'));

		$this->layout = "angular";
	}

/**
 * Servicio Grupo de trabajadores por jefe 
 *
 * @var array
 */
	public function index_Json(){
		$this->layout = null;
		$this->loadModel("Trabajadore");
		$this->loadModel("Cargo");
		$this->loadModel("Jefe");
		$this->response->type('json');

		$datosUser = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
		"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
		));

		$this->Jefe->Behaviors->load('Containable');
		
		$jefes = $this->Jefe->find('list', array(
			'fields'=>'id',
		'conditions'=>array('Jefe.trabajadore_id ' => $datosUser["User"]["trabajadore_id"]),
			'recursive'=>-1
		));

		$cargos = $this->Cargo->find('list', array(
			'fields'=>'id',
			'conditions'=>array('Cargo.estado != ' => ''),
			'recursive'=>-1
		));

		$salida = $this->Trabajadore->find('all', array(
			'fields'=>array('Trabajadore.*', 'Cargo.nombre'),
			'conditions'=>array(
				'Trabajadore.jefe_id'=>$jefes,
				'Trabajadore.estado'=>'Activo',
				'Trabajadore.cargo_id'=>$cargos,
			),
			'recursive'=>0
		));

		$salidaJson ="";
		
		foreach($salida as $value){
			$salidaJson[] = array(
				'id'=>$value['Trabajadore']['id'],
				'nombre'=>ucwords($value['Trabajadore']['nombre']),
				'apellido'=>ucwords($value['Trabajadore']['apellido_paterno']),
				'cargo'=>ucwords($value['Cargo']['nombre'])	
			);
		}
		echo json_encode($salidaJson);
		exit;
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */
		$this->layout = "angular";
	}

	/**
 * Canje de puntos por productos
 *@author Mpalencia <email@email.com>
 * @return void
 */
	public function canje($product_id = null) {
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */

		$this->loadModel("User");
		$this->loadModel("RecognitionProduct");
		$this ->loadModel("Trabajadore");

		$product = $this->RecognitionProduct->find("all", array(
			"conditions"=>array("RecognitionProduct.id" => $product_id),
			"recursive"=>-1
		));
		
		$point_delete = $product[0]['RecognitionProduct']['points'];
		$quantity = $product[0]['RecognitionProduct']['quantity'];

		$user = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
			"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
		));
		$trabajadore_id = $user['User']['trabajadore_id'];
		//$trabajadore_id = 509; //usuario de prueba

		$colaborador = $this->Trabajadore->find('first', array("fields"=>array("Trabajadore.id", "Trabajadore.nombre","Trabajadore.apellido_paterno","Trabajadore.apellido_materno", "Trabajadore.email"),
			'conditions'=>array(
			"Trabajadore.id = ".$trabajadore_id ),
			"recursive"=>0
		));

		$ultimoId = $this->RecognitionCollaborator->find('all',array(
			"fields"=>array("max(RecognitionCollaborator.id) as id"),
			"recursive"=>-1
		));
		$newId = $ultimoId[0][0]['id'] + 1;

		$puntosColaborador = $this->RecognitionCollaborator->find("all", array(
			"fields"=>array("sum(RecognitionCollaborator.points_add) - sum(RecognitionCollaborator.points_delete) as disponible"),
			'conditions'=>array("RecognitionCollaborator.employed_id" => $trabajadore_id)
		));
		$disponible = $puntosColaborador[0][0]['disponible'];

		$parametros = array($newId, $product_id, $trabajadore_id, $point_delete);
		$param = array($product_id, $quantity);
		$fechaActual = date('d-m-Y');

		if($disponible >= $point_delete){
			if(!empty($parametros)){
				$this->RecognitionCollaborator->egreso($parametros);
				$this->RecognitionProduct->stock($param);
				
				$Email = new CakeEmail("gmail");
				$Email->to('rrhh@cdf.cl');
				$Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
				$Email->cc($colaborador['Trabajadore']["email"]);
				$Email->subject("Canje de reconocimiento");
				$Email->emailFormat('html');
				$Email->template('puntos_canjeados');
				$Email->viewVars(array(
						"nombre"=>$colaborador['Trabajadore']['nombre']." ".$colaborador['Trabajadore']['apellido_paterno']." ".$colaborador['Trabajadore']['apellido_materno'], 
						"producto"=>$product['0']['RecognitionProduct']['name'],
						"fechaActual"=>$fechaActual
					));
				$Email->send();
				
				$this->Session->setFlash('Reconocimiento canjeado correctamente. RRHH te contactará para la entrega del producto.','msg_exito');
				return $this->redirect(array('action' => 'collaborator'));
			}else{
				$this->Session->setFlash('Ocurrio un error canjeando sus puntos.','msg_fallo');
				return $this->redirect(array('action' => 'collaborator'));
			}
		}else{
			$this->Session->setFlash('Saldo insuficiente, Verifique sus puntos disponibles.','msg_fallo');
			return $this->redirect(array('action' => 'collaborator'));
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
		return $this->redirect(array("controller" => 'recognitionBossDepartaments','action' => 'collaborator'));
		/*
		if (!$this->RecognitionCollaborator->exists($id)) {
			throw new NotFoundException(__('Invalid recognition collaborator'));
		}
		$options = array('conditions' => array('RecognitionCollaborator.' . $this->RecognitionCollaborator->primaryKey => $id));
		$this->set('recognitionCollaborator', $this->RecognitionCollaborator->find('first', $options));
		*/
	}


/**
 * Vista con las sub-conductas a evaluar
 *@author Mpalencia <email@email.com>
 * @return void
 */
	public function getSubConducts($id = null) {
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */
		$this->loadModel('RecognitionSubconduct');
		
		$subConducts = $this->RecognitionSubconduct->find('all',array(
			'conditions'=>array(
				'RecognitionSubconduct.statu_id'=>1
			),'order' => 'RecognitionSubconduct.conduct_id ASC',
			'recursive'=>0
		));
		$this->set(compact('subConducts','id'));
	}

	//ultimo dia del mes actual
	function lastMonthDay() { 
		$this->layout = null;
		$month = date('m');
		$year = date('Y');
		$day = date("d", mktime(0,0,0, $month+1, 0, $year));
		return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
	}
	
	/** primer dia del mes actual**/
	function firstMonthDay() {
		$this->layout = null;
		$month = date('m');
		$year = date('Y');
		return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
	}

/**
 * valida que no se reconosca a un colaborador mas de 1 vez por quincena
 *@author Mpalencia <email@email.com>
 * @return void
 */
	public function validar($id,$comportamiento,$valorComportamiento) {
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */
		
		$this->autoRender= false;
		return $this->redirect(array("controller" => "recognitionCollaborators", "action" => "add",$id,$comportamiento,$valorComportamiento));
		/* comentado por solicitud de Mario Arriola, no se valida la cantidad de reconocimientos
		$param = explode("-", $id);
		$trabajador_id = $param[0];
		$primerDia = $this->firstMonthDay();
		$ultimoDia = $this->lastMonthDay();
		$fechaActual = date('d-m-Y');
		$quincena = strtotime ( '+15 day' , strtotime ( $primerDia ) ) ;
		$quincena = date ( 'Y-m-j' , $quincena );
		
		$primeraQuincena = $this->RecognitionCollaborator->find('all',array(
			'conditions'=>array("RecognitionCollaborator.employed_id = ".$trabajador_id 
				,'RecognitionCollaborator.created BETWEEN ? AND ?' => array($primerDia, $quincena),
			),"recursive"=>-1
		));

		$segundaQuincena = $this->RecognitionCollaborator->find('all',array(
			'conditions'=>array("RecognitionCollaborator.employed_id = ".$trabajador_id 
				,'RecognitionCollaborator.created BETWEEN ? AND ?' => array($quincena, $ultimoDia),
			),"recursive"=>-1
		));

		if($fechaActual >= $primerDia && $fechaActual <= $primeraQuincena){
			if(count($primeraQuincena) > 0){
				$this->Session->setFlash('El colaborador ya fue reconocido durante la primera quincena de este mes.','msg_fallo');
				return $this->redirect(array("controller" => 'recognitionBossDepartaments','action' => 'collaborator'));
			}else{
				return $this->redirect(array("controller" => "recognitionCollaborators", "action" => "add",$id));
			}
		}else{

			if(count($segundaQuincena) > 0){
				$this->Session->setFlash('El colaborador ya fue reconocido durante la segunda quincena de este mes.','msg_fallo');
				return $this->redirect(array("controller" => 'recognitionBossDepartaments','action' => 'collaborator'));
			}else{
				return $this->redirect(array("controller" => "recognitionCollaborators", "action" => "add",$id));
			}
		}
		*/
	}

/**
 * add method
 *
 * @return void
 */
	public function add($id,$comportamiento,$valorComportamiento) {
		
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */

		/*$param = explode("-", $id);
		$trabajador_id = $param[0];
		$subconduct_id = $param[1];
		$points_subconduct = $param[2];*/
		$trabajador_id = $id;
		$subconduct_id = $comportamiento;
		$points_subconduct = $valorComportamiento;

		$this->loadModel('RecognitionBossDepartament');
		$this->loadModel('RecognitionSubconduct');
		$this->loadModel('Trabajadore');
		$this->loadModel('User');

		$colaborador = $this->Trabajadore->find('first', array("fields"=>array("Trabajadore.id", "Trabajadore.nombre","Trabajadore.apellido_paterno","Trabajadore.apellido_materno", "Trabajadore.email"),
			'conditions'=>array("Trabajadore.id = ".$trabajador_id ),
			"recursive"=>0
		));

		$user = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
			"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
			));
			
		$jefe = $this->Trabajadore->find('first', array("fields"=>array("Trabajadore.id", "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.apellido_materno", "Trabajadore.email"),
			'conditions'=>array(
			"Trabajadore.id" => $user['User']['trabajadore_id'] ),
			"recursive"=>0
		));

		$puntosJefe = $this->RecognitionBossDepartament->find("all", array(
			"fields"=>array("sum(RecognitionBossDepartament.points_add) - sum(RecognitionBossDepartament.points_delete) as disponible"),
			'conditions'=>array("RecognitionBossDepartament.statu_id" => 1 , "RecognitionBossDepartament.employed_id" => $user['User']['trabajadore_id'] )
			));

		$puntosJefe = $puntosJefe[0][0]['disponible'];

		$ultimoId = $this->RecognitionBossDepartament->find('all',array(
			"fields"=>array("max(RecognitionBossDepartament.id) as id"),
			"recursive"=>-1
		));
		$newId = $ultimoId[0][0]['id'] + 1;

		$ultimoIdCollaborator = $this->RecognitionCollaborator->find('all',array(
			"fields"=>array("max(RecognitionCollaborator.id) as id"),
			"recursive"=>-1
		));
		$idCollaborator = $ultimoIdCollaborator[0][0]['id'] + 1;
		$fechaActual = date('d-m-Y');
		if ($this->request->is('post')) {
			if($puntosJefe >= $this->request->data['RecognitionCollaborator']['points_add']){
				$parametros = array($newId, $this->request->data['RecognitionCollaborator']['points_add'], $this->request->data['RecognitionCollaborator']['boss_id']);
				$this->RecognitionCollaborator->create();
				if ($this->RecognitionCollaborator->save($this->request->data)) {
					$this->RecognitionBossDepartament->egreso($parametros);
					$this->RecognitionBossDepartament->secuencia($newId);

					$subconducta = $this->RecognitionSubconduct->find('all', array(
						'conditions'=>array("RecognitionSubconduct.id = ".$this->request->data['RecognitionCollaborator']['subconducts_id'] ),
						"recursive"=>0
					));
					//Envio de correo a RRHH
					$Email = new CakeEmail("gmail");
					$Email->to('rrhh@cdf.cl'); 
					$Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
					$Email->cc('marriola@cdf.cl'); 
					$Email->subject("Nuevo Reconocimiento");
					$Email->emailFormat('html');
					$Email->template('puntos_asignados');
					$Email->viewVars(array("jefe"=>$jefe['Trabajadore']['nombre']." ".$jefe['Trabajadore']['apellido_paterno']." ".$jefe['Trabajadore']['apellido_materno'],
											"nombre"=>$colaborador['Trabajadore']['nombre']." ".$colaborador['Trabajadore']['apellido_paterno']." ".$colaborador['Trabajadore']['apellido_materno'],
											"valor"=>$subconducta[0]['Conduct']['name'],
											"comportamiento"=>$subconducta[0]['RecognitionSubconduct']['name'],
											"puntos"=>$this->request->data['RecognitionCollaborator']['points_add'],
											"fechaActual"=>$fechaActual
										));
					$Email->send();
					
					//Envio de correo al colaborador
					$Email = new CakeEmail("gmail");
					$Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
					$Email->to($colaborador['Trabajadore']["email"]); 
					$Email->cc('marriola@cdf.cl');
					$Email->subject("Programa de Reconocimiento CDF");
					$Email->emailFormat('html');
					$Email->template('puntos_asignados_colaborador');
					$Email->viewVars(array( "valor"=>$subconducta[0]['Conduct']['name'],
											"comportamiento"=>$subconducta[0]['RecognitionSubconduct']['name'],
											"descripcion"=>$this->request->data['RecognitionCollaborator']['descrption'],
											"puntos"=>$this->request->data['RecognitionCollaborator']['points_add'],
											"fechaActual"=>$fechaActual
										));
					$Email->send();
					
					$this->Session->setFlash('Reconocimiento realizado correctamente, se ha enviado correo a colaborador.','msg_exito');
					return $this->redirect(array("controller" => 'recognitionBossDepartaments','action' => 'collaborator'));
				} else {
					$this->Session->setFlash('Ocurrio un error al asignar la puntuación.','msg_fallo');
					return $this->redirect(array("controller" => 'recognitionBossDepartaments','action' => 'collaborator'));
				}
			}else{
				$this->Session->setFlash('Saldo insuficiente, Verifique sus puntos disponibles.','msg_fallo');
				return $this->redirect(array("controller" => 'recognitionBossDepartaments','action' => 'collaborator'));
			}
		}
		
		$bosses = $this->RecognitionCollaborator->Boss->find('list');
		$employeds = $this->RecognitionCollaborator->Employed->find('list');
		$products = $this->RecognitionCollaborator->Product->find('list');
		$this->set(compact('bosses','employeds','products','subconduct_id','colaborador','jefe', 'points_subconduct','idCollaborator'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		return $this->redirect(array("controller" => 'recognitionBossDepartaments','action' => 'collaborator'));
		
		/*if (!$this->RecognitionCollaborator->exists($id)) {
			throw new NotFoundException(__('Invalid recognition collaborator'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RecognitionCollaborator->save($this->request->data)) {
				$this->Session->setFlash(__('The recognition collaborator has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The recognition collaborator could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RecognitionCollaborator.' . $this->RecognitionCollaborator->primaryKey => $id));
			$this->request->data = $this->RecognitionCollaborator->find('first', $options);
		}
		//$subconducts = $this->RecognitionCollaborator->Subconduct->find('list');
		$bosses = $this->RecognitionCollaborator->Boss->find('list');
		$employeds = $this->RecognitionCollaborator->Employed->find('list');
		$products = $this->RecognitionCollaborator->Product->find('list');
		$this->set(compact('subconducts', 'bosses', 'employeds', 'products'));*/
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		return $this->redirect(array("controller" => 'recognitionBossDepartaments','action' => 'collaborator'));
		/*
		$this->RecognitionCollaborator->id = $id;
		if (!$this->RecognitionCollaborator->exists()) {
			throw new NotFoundException(__('Invalid recognition collaborator'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->RecognitionCollaborator->delete()) {
			$this->Session->setFlash(__('The recognition collaborator has been deleted.'));
		} else {
			$this->Session->setFlash(__('The recognition collaborator could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
		*/
	}

	//boton de canje personalizado
	public function ejemplo_boton(){}
}
