<?php
App::uses('AppController', 'Controller');
/**
 * CompaniesAttributes Controller
 *
 * @property CompaniesAttribute $CompaniesAttribute
 * @property PaginatorComponent $Paginator
 */
class CompaniesAttributesController extends AppController {

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
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		$this->CompaniesAttribute->recursive = 0;
		$this->set('companiesAttributes', $this->Paginator->paginate());
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
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if (!$this->CompaniesAttribute->exists($id)) {
			throw new NotFoundException(__('Invalid companies attribute'));
		}
		$options = array('conditions' => array('CompaniesAttribute.' . $this->CompaniesAttribute->primaryKey => $id));
		$this->set('companiesAttribute', $this->CompaniesAttribute->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		$this->layout = "ajax";
		
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->request->is('ajax')!=1)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		if ($this->request->is('post')) {

			$canales = serialize($this->request->data["CompaniesAttribute"]["channel_id"]);
			$enlaces = serialize($this->request->data["CompaniesAttribute"]["link_id"]);
			$segnal = serialize($this->request->data["CompaniesAttribute"]["signal_id"]);
			$pago = serialize($this->request->data["CompaniesAttribute"]["payment_id"]);
			
			$this->request->data["CompaniesAttributex"]["company_id"] = $this->request->data["CompaniesAttribute"]["company_id"];
			$this->request->data["CompaniesAttributex"]["channel_id"] = $canales;
			$this->request->data["CompaniesAttributex"]["link_id"] = $enlaces;
			$this->request->data["CompaniesAttributex"]["signal_id"] = $segnal;
			$this->request->data["CompaniesAttributex"]["payment_id"] = $pago;

			$estado = "";			
			$this->CompaniesAttribute->create();
			if ($this->CompaniesAttribute->save($this->request->data["CompaniesAttributex"])) {
				CakeLog::write('actividad', 'registro atributos - empresa id:' .$this->request->data["CompaniesAttributex"]["company_id"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$estado = 1;	
			} else {
				$estado = 0;	
			}

			echo $estado;
			exit;
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
		
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		if (!$this->CompaniesAttribute->exists($id)) {
			throw new NotFoundException(__('Invalid companies attribute'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CompaniesAttribute->save($this->request->data)) {
				$this->Session->setFlash(__('The companies attribute has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The companies attribute could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CompaniesAttribute.' . $this->CompaniesAttribute->primaryKey => $id));
			$this->request->data = $this->CompaniesAttribute->find('first', $options);
		}
		$companies = $this->CompaniesAttribute->Company->find('list');
		$channels = $this->CompaniesAttribute->Channel->find('list');
		$links = $this->CompaniesAttribute->Link->find('list');
		$signals = $this->CompaniesAttribute->Signal->find('list');
		$payments = $this->CompaniesAttribute->Payment->find('list');
		$this->set(compact('companies', 'channels', 'links', 'signals', 'payments'));
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
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		$this->CompaniesAttribute->id = $id;
		if (!$this->CompaniesAttribute->exists()) {
			throw new NotFoundException(__('Invalid companies attribute'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CompaniesAttribute->delete()) {
			$this->Session->setFlash(__('The companies attribute has been deleted.'));
		} else {
			$this->Session->setFlash(__('The companies attribute could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
