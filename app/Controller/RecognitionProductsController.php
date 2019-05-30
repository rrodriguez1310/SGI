<?php
App::uses('AppController', 'Controller');
/**
 * RecognitionProducts Controller
 *
 * @property RecognitionProduct $RecognitionProduct
 * @property PaginatorComponent $Paginator
 */
class RecognitionProductsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * Components
 *
 * @var array
 * @author Mpalencia 
 */
	public function index_json() {
		$this->layout = null;
		$this->response->type('json');
		$salida = $this->RecognitionProduct->find('all');
		
		$salidaJson ="";


		foreach($salida as $value){
			$salidaJson[] = array(
				'id'=>$value['RecognitionProduct']['id'],
				'name'=>ucwords($value['RecognitionProduct']['name']),
				'image'=>$value['RecognitionProduct']['image'],
				'imagedir'=>$value['RecognitionProduct']['imagedir'],
				'points'=>$value['RecognitionProduct']['points'],
				'quantity'=>$value['RecognitionProduct']['quantity'],
				'category'=>ucwords($value['Category']['name']),
				'status'=>ucwords($value['Statu']['name']),
				'descrption'=>ucwords($value['RecognitionProduct']['descrption']),
				'created'=>$value['RecognitionProduct']['created'],
				'modified'=>$value['RecognitionProduct']['modified']	
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
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}/* FinValida Usuario */

		if (!$this->RecognitionProduct->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Producto invalido', 'msg_fallo'));
		}
		$options = array('conditions' => array('RecognitionProduct.' . $this->RecognitionProduct->primaryKey => $id));
		$this->set('recognitionProduct', $this->RecognitionProduct->find('first', $options));
	}

	public function detalle($id = null){
		if (!$this->RecognitionProduct->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Producto invalido', 'msg_fallo'));
		}
		$options = array('conditions' => array('RecognitionProduct.' . $this->RecognitionProduct->primaryKey => $id));
		$this->set('recognitionProduct', $this->RecognitionProduct->find('first', $options));
	}

	public function canje($id = null){
		if (!$this->RecognitionProduct->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Producto invalido', 'msg_fallo'));
		}
		$options = array('conditions' => array('RecognitionProduct.' . $this->RecognitionProduct->primaryKey => $id));
		$this->set('recognitionProduct', $this->RecognitionProduct->find('first', $options));
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
			$this->RecognitionProduct->create();
			
			if ($this->RecognitionProduct->save($this->request->data)) {
				CakeLog::write('actividad', 'recognitionProducts - add -  '.$this->RecognitionProduct->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Producto registrado correctamente','msg_exito');
				
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al guardar el producto','msg_fallo');
			}
		}
		$categories = $this->RecognitionProduct->Category->find('list',array("conditions"=> array("Category.statu_id = 1"  )));
		$status = $this->RecognitionProduct->Statu->find('list');
		$this->set(compact('categories', 'status'));
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

		if (!$this->RecognitionProduct->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Producto invalido', 'msg_fallo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			CakeLog::write('actividad', 'recognitionProducts - edit -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			if ($this->RecognitionProduct->save($this->request->data)) {
				$this->Session->setFlash('Producto actualizado correctamente','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al editar el producto','msg_fallo');
			}
		} else {
			$options = array('conditions' => array('RecognitionProduct.' . $this->RecognitionProduct->primaryKey => $id));
			$this->request->data = $this->RecognitionProduct->find('first', $options);
		}
		$categories = $this->RecognitionProduct->Category->find('list',array("conditions"=> array("Category.statu_id = 1"  )));
		$status = $this->RecognitionProduct->Statu->find('list');
		$this->set(compact('categories', 'status'));
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

		$this->RecognitionProduct->id = $id;
		if (!$this->RecognitionProduct->exists()) {
			throw new NotFoundException($this->Session->setFlash('Producto invalido', 'msg_fallo'));
		}
		/*$this->request->allowMethod('post', 'delete');
		if ($this->RecognitionProduct->delete()) {
			$this->Session->setFlash(__('The recognition product has been deleted.'));
		} else {
			$this->Session->setFlash(__('The recognition product could not be deleted. Please, try again.'));
		}*/

		CakeLog::write('actividad', 'recognitionProducts - delete -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$result = $this->RecognitionProduct->statu($id);
		if(count($result)>0){
			if($this->RecognitionProduct->deletes($id)){
				$this->Session->setFlash('Ocurrio un error al eliminar el producto.','msg_fallo');
			}else{
				$this->Session->setFlash('Producto eliminado correctamente','msg_exito');
			}
		}else{
			$this->Session->setFlash('No puede realizar esta operación, el producto fue eliminado anteriormente.','msg_fallo');	
		}

		return $this->redirect(array('action' => 'index'));
	}
}
