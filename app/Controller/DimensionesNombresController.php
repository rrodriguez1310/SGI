<?php
App::uses('AppController', 'Controller');
/**
 * DimensionesNombres Controller
 *
 * @property DimensionesNombre $DimensionesNombre
 * @property PaginatorComponent $Paginator
 */
class DimensionesNombresController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 * @return void
 */
	public function index() {
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
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
		{
			$this->DimensionesNombre->recursive = 0;
			$this->set('dimensionesNombres', $this->DimensionesNombre->find("all"));
			CakeLog::write('actividad', 'miro la pagina dimensiones-nombres/index - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
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
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
		{
			if (!$this->DimensionesNombre->exists($id)) {
				throw new NotFoundException(__('Codigo invalido'), 'msg_fallo');
				return $this->redirect(array('action' => 'index'));
			}
			CakeLog::write('actividad', 'miro la pagina dimensiones-nombres/view - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
			$options = array('conditions' => array('DimensionesNombre.' . $this->DimensionesNombre->primaryKey => $id));
			$this->set('dimensionesNombre', $this->DimensionesNombre->find('first', $options));
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add(){
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
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
		{
			if ($this->request->is('post')) {

				$existe = $this->DimensionesNombre->findByNombre($this->request->data["DimensionesNombre"]["nombre"]);

				if(!empty($existe))
				{
					$this->Session->setFlash(__('El nombre que esta intentando ingresar ya existe'), 'msg_exito');
					return $this->redirect(array('action'=>'index'));	
				}

				$this->DimensionesNombre->create();
				if ($this->DimensionesNombre->save($this->request->data)) {
					CakeLog::write('actividad', 'ingreso un registro en dimensiones-nombres - id ' . $id . ' usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash(__('Se registro correctamente'), 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('No se registro correctamente'), 'msg_fallo');
				}
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
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
		{
			if (!$this->DimensionesNombre->exists($id)) {
				throw new NotFoundException(__('Codigo invalido'), 'msg_fallo');
				return $this->redirect(array('action' => 'index'));
			}
			if ($this->request->is(array('post', 'put'))) {
				if ($this->DimensionesNombre->save($this->request->data)) {
					CakeLog::write('actividad', 'edito un registro en dimensiones-nombres - id ' . $this->DimensionesNombre->id . ' usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash(__('Se registro correctamente'), 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('No se registro correctamente'), 'msg_fallo');
				}
			} else {
				$options = array('conditions' => array('DimensionesNombre.' . $this->DimensionesNombre->primaryKey => $id));
				$this->request->data = $this->DimensionesNombre->find('first', $options);
			}
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
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
		{
			$this->DimensionesNombre->id = $id;
			if (!$this->DimensionesNombre->exists()) {
				throw new NotFoundException(__('Codigo invalido'), 'msg_fallo');
				return $this->redirect(array('action' => 'index'));
			}
			$this->request->allowMethod('post', 'delete');
			if ($this->DimensionesNombre->delete()) {
				CakeLog::write('actividad', 'elimino un registro en dimensiones-nombres - id ' . $this->DimensionesNombre->id . ' usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash(__('Se elimino correctamente'), 'msg_exito');
			} else {
				$this->Session->setFlash(__('No se elimino'), 'msg_fallo');
			}
			return $this->redirect(array('action' => 'index'));
		}
	}
}
