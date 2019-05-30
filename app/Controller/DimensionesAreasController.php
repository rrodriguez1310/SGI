<?php
App::uses('AppController', 'Controller');
/**
 * DimensionesAreas Controller
 *
 * @property DimensionesArea $DimensionesArea
 * @property PaginatorComponent $Paginator
 */
class DimensionesAreasController extends AppController {

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
			$this->DimensionesArea->recursive = 0;
			$this->set('dimensionesAreas', $this->DimensionesArea->find("all"));
			CakeLog::write('actividad', 'miro la pagina dimensiones-areas usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
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
			if (!$this->DimensionesArea->exists($id)) {
				throw new NotFoundException(__('Dimensión no existe'), 'msg_fallo');
				return $this->redirect(array('action' => 'index'));
			}
			CakeLog::write('actividad', 'miro  dimensiones areas view' . ' usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
			$options = array('conditions' => array('DimensionesArea.' . $this->DimensionesArea->primaryKey => $id));
			$this->set('dimensionesArea', $this->DimensionesArea->find('first', $options));
		}
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
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
		{
			if ($this->request->is('post')) {
				
				$existe = $this->DimensionesArea->findByNombre($this->request->data["DimensionesArea"]["nombre"]);

				if(!empty($existe))
				{
					$this->Session->setFlash(__('El nombre que esta intentando ingresar ya existe'), 'msg_exito');
					return $this->redirect(array('action'=>'index'));	
				}

				$this->DimensionesArea->create();
				if ($this->DimensionesArea->save($this->request->data)) {
					CakeLog::write('actividad', 'inserto un registro en dimensiones-areas - id ' . $this->DimensionesArea->id . ' usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash(__('Se registro correctamente'), 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('No se registro'), 'msg_fallo');
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
			if (!$this->DimensionesArea->exists($id)) {
				throw new NotFoundException(__('Dimensión no existe'), 'msg_fallo');
				return $this->redirect(array('action' => 'index'));
			}
			if ($this->request->is(array('post', 'put'))) {
				if ($this->DimensionesArea->save($this->request->data)) {
					CakeLog::write('actividad', 'edito un registro en dimensiones-areas - id ' . $this->DimensionesArea->id . ' usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash(__('Se registro correctamente'), 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('No se registro'), 'msg_fallo');
				}
			} else {
				$options = array('conditions' => array('DimensionesArea.' . $this->DimensionesArea->primaryKey => $id));
				$this->request->data = $this->DimensionesArea->find('first', $options);
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
			$this->DimensionesArea->id = $id;
			if (!$this->DimensionesArea->exists()) {
				throw new NotFoundException(__('Dimensión no existe'), 'msg_fallo');
				return $this->redirect(array('action' => 'index'));
			}
			$this->request->allowMethod('post', 'delete');
			if ($this->DimensionesArea->delete()) {
				CakeLog::write('actividad', 'elimino un registro en dimensiones-areas - id ' . $id . ' usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash(__('Se elimino correctamente'), 'msg_exito');
			} else {
				$this->Session->setFlash(__('No se pudo eliminar'), 'msg_fallo');
			}
			return $this->redirect(array('action' => 'index'));
		}
	}
}
