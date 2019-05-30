<?php
App::uses('AppController', 'Controller');
/**
 * RecognitionCategories Controller
 *
 * @property RecognitionCategory $RecognitionCategory
 * @property PaginatorComponent $Paginator
 */
class RecognitionCategoriesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','RequestHandler', 'Session');
	
/**
 * index_json method
 *
 * @return void
 * @author Mpalencia <email@email.com>
 */
	public function index_json() {
		/*Valida Usuario */
	/*	if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}*//* FinValida Usuario */

		$this->layout = null;
		$this->response->type('json');
		$salida = $this->RecognitionCategory->find('all');
		$salidaJson ="";


		foreach($salida as $value){
			$salidaJson[] = array(
				'id'=>$value['RecognitionCategory']['id'],
				'name'=>ucwords($value['RecognitionCategory']['name']),
				'descrption'=>ucwords($value['RecognitionCategory']['descrption']),
				'created'=>$value['RecognitionCategory']['created'],
				'modified'=>$value['RecognitionCategory']['modified'],
				'status'=>$value['Statu']['name']
			);
		}
		
		echo json_encode($salidaJson);
		exit;
	}

	/**
	 * index method
	 *
	 * @return void
	 * @author Mpalencia <email@email.com>
 	*/
		public function index(){
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
 * @author Mpalecia <email@email.com>
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
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}/* FinValida Usuario */


		if (!$this->RecognitionCategory->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Categoría invalida', 'msg_fallo'));
		}
		$options = array('conditions' => array('RecognitionCategory.' . $this->RecognitionCategory->primaryKey => $id));
		CakeLog::write('actividad', 'recognitionCategories - add -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$this->set('recognitionCategory', $this->RecognitionCategory->find('first', $options));
		$status = $this->RecognitionCategory->Statu->find('list');
		$this->set(compact('status'));

	}

/**
 * add method
 *
 * @return void
 * @author MPalencia 
 */
	public function add() {

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

		if ($this->request->is('post')) {
			$this->RecognitionCategory->create();
			CakeLog::write('actividad', 'recognitionCategories - add -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				if ($this->RecognitionCategory->save($this->request->data)) {
					$this->Session->setFlash('Categoría registrada correctamente.', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al guardar la categoría.', 'msg_fallo');
			}
		}
		$status = $this->RecognitionCategory->Statu->find('list');
		$this->set(compact('status'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 * @author MPalencia 
 */
	public function edit($id = null) {

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

		

		if(!$this->RecognitionCategory->exists($id)){
			throw new NotFoundException($this->Session->setFlash('Categoría invalida', 'msg_fallo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RecognitionCategory->save($this->request->data)) {
				CakeLog::write('actividad', 'recognitionCategories - edit -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Categoría actualizada.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al guardar la categoría.','msg_fallo');
			}
		} else {
			$options = array('conditions' => array('RecognitionCategory.' . $this->RecognitionCategory->primaryKey => $id));
			$this->request->data = $this->RecognitionCategory->find('first', $options);
		}
		$status = $this->RecognitionCategory->Statu->find('list');
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
		
		$this->RecognitionCategory->id = $id;
		if (!$this->RecognitionCategory->exists()) {
			throw new NotFoundException($this->Session->setFlash('Categoria invalida', 'msg_fallo'));
		}

		CakeLog::write('actividad', 'recognitionCategories - delete -  '.$id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$result = $this->RecognitionCategory->statu($id);
		if(count($result)>0){ 
			if($this->RecognitionCategory->deletes($id)){
				$this->Session->setFlash('Ocurrio un error al eliminar la categoría.','msg_fallo');
			}else{
				$this->Session->setFlash('Categoría eliminada correctamente','msg_exito');
			}
		}else{
			$this->Session->setFlash('No puede realizar esta operación, la categoría fue eliminada anteriormente.','msg_fallo');	
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
