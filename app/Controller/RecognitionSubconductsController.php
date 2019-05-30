<?php
App::uses('AppController', 'Controller');
/**
 * RecognitionSubconducts Controller
 *
 * @property RecognitionSubconduct $RecognitionSubconduct
 * @property PaginatorComponent $Paginator
 */
class RecognitionSubconductsController extends AppController {

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
 * @var array
 * @author Mpalencia 
 */
public function index_json() {
	$this->layout = null;
	$this->response->type('json');
	$salida = $this->RecognitionSubconduct->find('all');
	$salidaJson ="";

	foreach($salida as $value){
		$salidaJson[] = array(
			'id'=>$value['RecognitionSubconduct']['id'],
			'name'=>ucwords($value['RecognitionSubconduct']['name']),
			'conducts'=>ucwords($value['Conduct']['name']),
			'points'=>$value['RecognitionSubconduct']['points'],
			'image'=>$value['RecognitionSubconduct']['image'],
			'imagedir'=>$value['RecognitionSubconduct']['imagedir'],
			'status'=>ucwords($value['Statu']['name']),
			'descrption'=>ucwords($value['RecognitionSubconduct']['descrption']),
			'created'=>$value['RecognitionSubconduct']['created'],
			'modified'=>$value['RecognitionSubconduct']['modified']	
		);
	}
	
	echo json_encode($salidaJson);
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

		if (!$this->RecognitionSubconduct->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Sub-Coducta invalida', 'msg_fallo'));
		}
		$options = array('conditions' => array('RecognitionSubconduct.' . $this->RecognitionSubconduct->primaryKey => $id));
		$this->set('recognitionSubconduct', $this->RecognitionSubconduct->find('first', $options));
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
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}/* FinValida Usuario */

		if ($this->request->is('post')) {
			$this->RecognitionSubconduct->create();
			CakeLog::write('actividad', 'recognitionSubconducts - add -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			if ($this->RecognitionSubconduct->save($this->request->data)) {
				$this->Session->setFlash('Comportamiento registrado correctamente','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al guardar el comportamiento','msg_fallo');
			}
		}
		$conducts = $this->RecognitionSubconduct->Conduct->find('list',array("conditions"=> array("Conduct.statu_id = 1"  )));
		$status = $this->RecognitionSubconduct->Statu->find('list');
		$this->set(compact('conducts', 'status'));
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
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}/* FinValida Usuario */

		if (!$this->RecognitionSubconduct->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Sub-Coducta invalida', 'msg_fallo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			CakeLog::write('actividad', 'recognitionSubonducts - edit -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			if ($this->RecognitionSubconduct->save($this->request->data)) {
				$this->Session->setFlash('Comportamiento actualizado correctamente','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al actualizar el comportamiento','msg_fallo');
			}
		} else {
			$options = array('conditions' => array('RecognitionSubconduct.' . $this->RecognitionSubconduct->primaryKey => $id));
			$this->request->data = $this->RecognitionSubconduct->find('first', $options);
		}
		$conducts = $this->RecognitionSubconduct->Conduct->find('list',array("conditions"=> array("Conduct.statu_id = 1"  )));
		$status = $this->RecognitionSubconduct->Statu->find('list');
		$this->set(compact('conducts', 'status'));
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
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}/* FinValida Usuario */

		$this->RecognitionSubconduct->id = $id;
		if (!$this->RecognitionSubconduct->exists()) {
			throw new NotFoundException($this->Session->setFlash('Comportamiento invalida.','msg_fallo'));
		}
		/*
		$this->request->allowMethod('post', 'delete');
		if ($this->RecognitionSubconduct->delete()) {
			$this->Session->setFlash(__('The recognition subconduct has been deleted.'));
		} else {
			$this->Session->setFlash(__('The recognition subconduct could not be deleted. Please, try again.'));
		}*/

		CakeLog::write('actividad', 'RecognitionSubconduct - delete -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$result = $this->RecognitionSubconduct->statu($id);
		if(count($result)>0){
			if($this->RecognitionSubconduct->deletes($id)){
			$this->Session->setFlash('Ocurrio un error al eliminar el comportamiento.','msg_fallo');
			}else{
				$this->Session->setFlash('Comportamiento eliminado correctamente.','msg_exito');
			}
		}else{
			$this->Session->setFlash('No puede realizar esta operación, el comportamiento fue eliminado anteriormente.','msg_fallo');	
		}
		return $this->redirect(array('action' => 'index'));
	}
}
