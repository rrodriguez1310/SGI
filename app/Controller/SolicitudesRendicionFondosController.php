<?php
App::uses('AppController', 'Controller');
/**
 * SolicitudesRendicionFondos Controller
 *
 * @property SolicitudesRendicionFondo $SolicitudesRendicionFondo
 * @property PaginatorComponent $Paginator
 */
class SolicitudesRendicionFondosController extends AppController {

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
		$this->SolicitudesRendicionFondo->recursive = 0;
		$this->set('solicitudesRendicionFondos', $this->Paginator->paginate());
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
		if (!$this->SolicitudesRendicionFondo->exists($id)) {
			throw new NotFoundException(__('Invalid solicitudes rendicion fondo'));
		}
		$options = array('conditions' => array('SolicitudesRendicionFondo.' . $this->SolicitudesRendicionFondo->primaryKey => $id));
		$this->set('solicitudesRendicionFondo', $this->SolicitudesRendicionFondo->find('first', $options));
		CakeLog::write('actividad', 'Visualiza solicitud rendicion fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
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
		if ($this->request->is('post')) {
			$this->SolicitudesRendicionFondo->create();

		if ($this->SolicitudesRendicionFondo->save($this->request->data)) {
				$this->Session->setFlash(__('The solicitudes rendicion fondo has been saved.'));
				CakeLog::write('actividad', 'Agrega solicitud rendicion de fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The solicitudes rendicion fondo could not be saved. Please, try again.'));
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
		if (!$this->SolicitudesRendicionFondo->exists($id)) {
			throw new NotFoundException(__('Invalid solicitudes rendicion fondo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SolicitudesRendicionFondo->save($this->request->data)) {
				CakeLog::write('actividad', 'Edita solicitud rendicion de fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash(__('The solicitudes rendicion fondo has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The solicitudes rendicion fondo could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SolicitudesRendicionFondo.' . $this->SolicitudesRendicionFondo->primaryKey => $id));
			$this->request->data = $this->SolicitudesRendicionFondo->find('first', $options);
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
		$this->SolicitudesRendicionFondo->id = $id;
		if (!$this->SolicitudesRendicionFondo->exists()) {
			throw new NotFoundException(__('Invalid solicitudes rendicion fondo'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->SolicitudesRendicionFondo->delete()) {
			CakeLog::write('actividad', 'Elimina solicitud rendicion de fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			$this->Session->setFlash(__('The solicitudes rendicion fondo has been deleted.'));
		} else {
			$this->Session->setFlash(__('The solicitudes rendicion fondo could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
