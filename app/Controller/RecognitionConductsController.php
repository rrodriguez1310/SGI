<?php
App::uses('AppController', 'Controller');
/**
 * RecognitionConducts Controller
 *
 * @property RecognitionConduct $RecognitionConduct
 * @property PaginatorComponent $Paginator
 */
class RecognitionConductsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * @var array
 * @author Mpalencia 
 */
public function index_json() {
	$this->layout = null;
	$this->response->type('json');
	//$salida = $this->RecognitionConduct->find('all');
	$salida = $this->RecognitionConduct->find('all',array(
		'order' => 'RecognitionConduct.statu_id ASC',
	));
	
	$salidaJson ="";

	foreach($salida as $value){
		$salidaJson[] = array(
			'id'=>$value['RecognitionConduct']['id'],
			'name'=>ucwords($value['RecognitionConduct']['name']),
			'status'=>ucwords($value['Statu']['name']),
			'image'=>$value['RecognitionConduct']['image'],
			'imagedir'=>$value['RecognitionConduct']['imagedir'],
			'descrption'=>ucwords($value['RecognitionConduct']['descrption']),
			'created'=>$value['RecognitionConduct']['created'],
			'modified'=>$value['RecognitionConduct']['modified']	
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
				$this->Session->setFlash('No tiene acceso a la pagina solicitada.', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión.', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}/* FinValida Usuario */

		if (!$this->RecognitionConduct->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Valor invalido.', 'msg_fallo'));
		}
		$options = array('conditions' => array('RecognitionConduct.' . $this->RecognitionConduct->primaryKey => $id));
		$this->set('recognitionConduct', $this->RecognitionConduct->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada.', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión.', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}/* FinValida Usuario */

		if ($this->request->is('post')) {
			$this->RecognitionConduct->create();
			CakeLog::write('actividad', 'recognitionConducts - add -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			if ($this->RecognitionConduct->save($this->request->data)) {
				$this->Session->setFlash('Valor registrado correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al guardar el valor.','msg_fallo');
			}
		}
		$status = $this->RecognitionConduct->Statu->find('list');
		$this->set(compact('status'));
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
				$this->Session->setFlash('No tiene acceso a la pagina solicitada.', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión.', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}/* FinValida Usuario */

		if (!$this->RecognitionConduct->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Valor invalido.', 'msg_fallo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			CakeLog::write('actividad', 'recognitionConducts - edit -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			if ($this->RecognitionConduct->save($this->request->data)) {
				$this->Session->setFlash('Valor actualizado correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al actualizar el valor.','msg_fallo');
			}
		} else {
			$options = array('conditions' => array('RecognitionConduct.' . $this->RecognitionConduct->primaryKey => $id));
			$this->request->data = $this->RecognitionConduct->find('first', $options);
		}
		$status = $this->RecognitionConduct->Statu->find('list');
		$this->set(compact('status'));
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
				$this->Session->setFlash('No tiene acceso a la pagina solicitada.', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión.', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}/* FinValida Usuario */

		$this->RecognitionConduct->id = $id;
		if (!$this->RecognitionConduct->exists()) {
			throw new NotFoundException($this->Session->setFlash('Coducta invalida.', 'msg_fallo'));
		}
		/*
		$this->request->allowMethod('post', 'delete');
		if ($this->RecognitionConduct->delete()) {
			$this->Session->setFlash(__('The recognition conduct has been deleted.'));
		} else {
			$this->Session->setFlash(__('The recognition conduct could not be deleted. Please, try again.'));
		}*/
		CakeLog::write('actividad', 'recognitionConducts - delete -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$result = $this->RecognitionConduct->statu($id);
		if(count($result)>0){
			if($this->RecognitionConduct->deletes($id)){
				$this->Session->setFlash('Ocurrio un error al eliminar el valor.','msg_fallo');
			}else{
				$this->Session->setFlash('Valor eliminado correctamente','msg_exito');
			}
		}else{
			$this->Session->setFlash('No puede realizar esta operación, el valor fue eliminada anteriormente.','msg_fallo');	
		}
		return $this->redirect(array('action' => 'index'));
	}
}
