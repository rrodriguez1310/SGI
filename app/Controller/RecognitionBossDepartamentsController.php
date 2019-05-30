<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * RecognitionBossDepartaments Controller
 *
 * @property RecognitionBossDepartament $RecognitionBossDepartament
 * @property PaginatorComponent $Paginator
 */
class RecognitionBossDepartamentsController extends AppController {

	/* Load models */ 
	//public $uses = array('Area');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	
	public function bossDepartaments(){
		
		$this->loadModel("Trabajadore");
		$this->loadModel("Cargo");
		$this->loadModel("Jefe");
		$this->layout = null;
		$this->response->type('json');
        
        $this->Jefe->Behaviors->load('Containable');
		
		$jefes = $this->Jefe->find('list', array(
			'fields'=>'trabajadore_id',
			'conditions'=>array(
				'state_recognitions' => 1),
			'recursive'=>0
		));
		

		$cargos = $this->Cargo->find('list', array(
			'fields'=>'id',
			'conditions'=>array('Cargo.estado != ' => ''),
			'recursive'=>-1
		));

		$salida = $this->Trabajadore->find('all', array(
			'fields'=>array('Trabajadore.*', 'Cargo.nombre'),
			'conditions'=>array(
				'Trabajadore.id'=>$jefes,
                //'Trabajadore.jefe_id != ' => '',
				'Trabajadore.estado'=>'Activo',
				'Trabajadore.cargo_id'=>$cargos,
			),
			'recursive'=>0
		));
	
		$salidaJson ="";
		
		foreach($salida as $value){
			$salidaJson[] = array(
				//'area'=>ucwords($value['Area']['nombre']),
				'cargo'=>ucwords($value['Cargo']['nombre']),
				'nombre'=>ucwords($value['Trabajadore']['nombre']),
				'apellido'=>ucwords($value['Trabajadore']['apellido_paterno']),
				'trabajador_id'=>$value['Trabajadore']['id'],
				//'area_id'=>$value['Area']['id']
			);
		}
		
		echo json_encode($salidaJson);
		exit;
	
	}

	public function indexBossJson(){
		$this->loadModel("Trabajadore");
		$this->layout = null;
		$this->response->type('json');
		$salida = $this->RecognitionBossDepartament->find("all", array(
			"fields"=>array("RecognitionBossDepartament.*","Trabajadore.nombre", "Trabajadore.apellido_paterno", "Statu.*"),
				"joins"=> array(
					array("table" => "trabajadores", "alias" => "Trabajadore", "type" => "INNER", "conditions" => array("Trabajadore.id = RecognitionBossDepartament.employed_id and RecognitionBossDepartament.points_add > 0")),	
				),'order' => 'Statu.name ASC',
			"recursive"=>0
			));
		$salidaJson ="";
		
		foreach($salida as $value){
			$salidaJson[] = array(
				'fecha'=>$value['RecognitionBossDepartament']['created'],
				'points'=>$value['RecognitionBossDepartament']['points_add'],
				'name'=>ucwords($value['Trabajadore']['nombre']),
				'lastname'=>ucwords($value['Trabajadore']['apellido_paterno']),
				'points'=>$value['RecognitionBossDepartament']['points_add'],
				'status'=>ucwords($value['Statu']['name']),
				'employed_id'=>$value['RecognitionBossDepartament']['employed_id'],
				'id'=>$value['RecognitionBossDepartament']['id']
			);
		}
		echo json_encode($salidaJson);
		exit;
	}

	public function boss() {
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
		}/* FinValida Usuario */

		$this->layout = "angular";
	}


	public function collaborator_json(){
		$this->loadModel('RecognitionCollaborator');
		$this->loadModel("Trabajadore");
		$this->loadModel("User");
		$this->layout = null;
		$this->response->type('json');

		$datosUser = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
		"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
			));
		
		/*$salida = $this->RecognitionCollaborator->find("all", array(
			"fields"=>array("Boss.nombre","Employed.nombre","RecognitionCollaborator.created","Conducta.name","Subconducts.name","RecognitionCollaborator.points_add"),
				"joins"=> array(
					array("table" => "recognition_conducts", "alias" => "Conducta", "type" => "INNER", "conditions" => array("Conducta.id = Subconducts.conduct_id")),	
				),'conditions'=>array('RecognitionCollaborator.points_add > ' => 0)
				,"recursive"=>0
			));*/

		$salida = $this->RecognitionCollaborator->find("all",array(
			"fields"=>array("RecognitionCollaborator.id","RecognitionCollaborator.created","Employed.nombre","Employed.apellido_paterno","Conducta.name","Subconducts.name","RecognitionCollaborator.descrption","RecognitionCollaborator.points_add"),
				"joins"=> array(
					array("table" => "recognition_conducts", "alias" => "Conducta", "type" => "INNER", "conditions" => array("Conducta.id = Subconducts.conduct_id")),	
				),'conditions'=>array("RecognitionCollaborator.boss_id" => $datosUser["User"]["trabajadore_id"],
				"RecognitionCollaborator.points_add >" => 0),
			'order' => 'RecognitionCollaborator.id DESC',
			"recursive"=>0
		));
		$this->set(compact('salida',$salida));

		$salidaJson ="";
		foreach($salida as $value){
			$salidaJson[] = array(
				'id'=>$value['RecognitionCollaborator']['id'],
				'fecha'=>date('d/m/y h:i:s', strtotime($value['RecognitionCollaborator']['created'])),
				'colaborador'=>ucwords($value['Employed']['nombre']." ".$value['Employed']['apellido_paterno']),
				'conducta'=>ucwords($value['Conducta']['name']),
				'subconduta'=>ucwords($value['Subconducts']['name']),
				'descripcion'=>ucwords($value['RecognitionCollaborator']['descrption']),
				'ingresos'=>$value['RecognitionCollaborator']['points_add'],
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

		$this->loadModel("Trabajadore");
		$this->loadModel("User");

		$datosUser = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
		"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
			));

		$puntosJefe = $this->RecognitionBossDepartament->find("all", array(
			"fields"=>array("sum(RecognitionBossDepartament.points_add) - sum(RecognitionBossDepartament.points_delete) as disponible"),
			'conditions'=>array("RecognitionBossDepartament.statu_id" => 1 , "RecognitionBossDepartament.employed_id" => $datosUser["User"]["trabajadore_id"] )
			));

		$this->set(compact('puntosJefe',$puntosJefe));
		
		/*$salida = $this->RecognitionBossDepartament->find("all", array(
			"fields"=>array("RecognitionBossDepartament.*","Trabajadore.nombre", "Trabajadore.apellido_paterno", "Statu.*"),
				"joins"=> array(
					array("table" => "trabajadores", "alias" => "Trabajadore", "type" => "INNER", "conditions" => array("Trabajadore.id = RecognitionBossDepartament.employed_id")),	
				),'conditions'=>array("RecognitionBossDepartament.statu_id" => 1,
					 "RecognitionBossDepartament.employed_id" => 312 .$datosUser["User"]["trabajadore_id"] ),
				'order' => 'RecognitionBossDepartament.id ASC',
			"recursive"=>0
			));*/

			$salida = $this->Trabajadore->find('all',array(
			"fields"=>array("Trabajadore.nombre", "Trabajadore.apellido_paterno"),
		'conditions'=>array('Trabajadore.id' => $datosUser["User"]["trabajadore_id"] ),
		"recursive"=>0
		));

		$this->set(compact('salida',$salida));

		$this->layout = "angular";
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
		}/* FinValida Usuario */
		
		$this->layout = "angular";
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
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
		}/* FinValida Usuario */

		$this->loadModel("Trabajadore");
		$salida = $this->RecognitionBossDepartament->find("all", array(
			"fields"=>array("Trabajadore.nombre"),
			"joins"=> array(
				array("table" => "trabajadores", "alias" => "Trabajadore", "type" => "INNER", "conditions" => array("RecognitionBossDepartament.employed_id = Trabajadore.id")),	
			),'conditions'=>array(
				"RecognitionBossDepartament.id = ".$id ),
				"recursive"=>0
		));

		$this->set(compact('salida',$salida));

		if (!$this->RecognitionBossDepartament->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido','msg_fallo'));
		}
		$options = array('conditions' => array('RecognitionBossDepartament.' . $this->RecognitionBossDepartament->primaryKey => $id));
		CakeLog::write('actividad', 'RecognitionBossDepartament - view -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$this->set('recognitionBossDepartament', $this->RecognitionBossDepartament->find('first', $options));
	}

/**
 * add method
 *@author Mpalencia <email@email.com>
 * @return void
 */
	public function add($id = null) {
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		} 
		/*FinValida Usuario */

		$this->loadModel("Trabajadore");

		$salida = $this->Trabajadore->find('first', array("fields"=>array("Trabajadore.nombre", "Trabajadore.email"),
			'conditions'=>array(
			"Trabajadore.id = ".$id ),
			"recursive"=>0
		));

		$ultimoId = $this->RecognitionBossDepartament->find('all',array(
			"fields"=>array("max(RecognitionBossDepartament.id) as id"),
			"recursive"=>-1
		));
		$newId = $ultimoId[0][0]['id'] + 1;

		if ($this->request->is('post')) {
			/*pr($this->request);
			exit;*/
			$this->RecognitionBossDepartament->create();
			CakeLog::write('actividad', 'RecognitionBossDepartament - add -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			if ($this->RecognitionBossDepartament->save($this->request->data)) {
				$this->Session->setFlash('Puntuación asignada correctamente.','msg_exito');
				return $this->redirect(array('action' => 'boss'));
			} else {
				$this->Session->setFlash('Ocurrio un error al asignar la puntuación','msg_fallo');
			}
		}

		$status = $this->RecognitionBossDepartament->Statu->find('list');
		//$this->set(compact('status',$status));
		$this->set(compact('status', 'salida', 'newId'));
		return true;
	}


/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}/* FinValida Usuario */

		$this->loadModel("Trabajadore");

		$salida = $this->RecognitionBossDepartament->find("all", array(
			"fields"=>array("Trabajadore.nombre"),
			"joins"=> array(
				array("table" => "trabajadores", "alias" => "Trabajadore", "type" => "INNER", "conditions" => array("RecognitionBossDepartament.employed_id = Trabajadore.id")),	
			),'conditions'=>array(
					"RecognitionBossDepartament.id = ".$id ),
					"recursive"=>0
			));

		$this->set(compact('salida',$salida));

		if (!$this->RecognitionBossDepartament->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido','msg_fallo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RecognitionBossDepartament->save($this->request->data)) {
				CakeLog::write('actividad', 'RecognitionBossDepartament - add -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Registro actualizado correctamente.','msg_exito');
				return $this->redirect(array('action' => 'boss'));
			} else {
				$this->Session->setFlash(__('The recognition boss departament could not be saved. Please, try again.'));
				$this->Session->setFlash('Ocurrio un error al actualizar el registro.','msg_fallo');
			}
		} else {
			$options = array('conditions' => array('RecognitionBossDepartament.' . $this->RecognitionBossDepartament->primaryKey => $id));
			$this->request->data = $this->RecognitionBossDepartament->find('first', $options);
		}
		$status = $this->RecognitionBossDepartament->Statu->find('list');
		$this->set(compact( 'status'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}/* FinValida Usuario */

		$this->RecognitionBossDepartament->id = $id;
		if (!$this->RecognitionBossDepartament->exists()) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido.','msg_fallo'));
		}

		CakeLog::write('actividad', 'RecognitionBossDepartament - delete -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$result = $this->RecognitionBossDepartament->statu($id);
		if(count($result)>0){ 
			if($this->RecognitionBossDepartament->deletes($id)){
				$this->Session->setFlash('Ocuerrio un error al eliminar la puntuacíon.','msg_fallo');
			}else{
				$this->Session->setFlash('Puntos eliminados correctamente','msg_exito');
			}
		}else{
			$this->Session->setFlash('No puede realizar esta operación, los puntos fueron eliminados anteriormente.','msg_fallo');	
		}
		//$this->Session->setFlash('El registro no puede ser eliminado del historico.','msg_fallo');
		return $this->redirect(array('action' => 'boss'));
	}
}
