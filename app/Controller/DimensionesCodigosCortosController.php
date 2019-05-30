<?php
App::uses('AppController', 'Controller');
/**
 * DimensionesCodigosCortos Controller
 *
 * @property DimensionesCodigosCorto $DimensionesCodigosCorto
 * @property PaginatorComponent $Paginator
 */
class DimensionesCodigosCortosController extends AppController {

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
			$this->DimensionesCodigosCorto->recursive = 0;
			$this->set('dimensionesCodigosCortos', $this->DimensionesCodigosCorto->find("all"));
			CakeLog::write('actividad', 'miro la pagina dimensiones codigos cortos' . ' usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
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
			if (!$this->DimensionesCodigosCorto->exists($id)) {
				throw new NotFoundException(__('Codigo invalido'), 'msg_falo');
				return $this->redirect(array('action' => 'index'));
			}
			$options = array('conditions' => array('DimensionesCodigosCorto.' . $this->DimensionesCodigosCorto->primaryKey => $id));
			$this->set('dimensionesCodigosCorto', $this->DimensionesCodigosCorto->find('first', $options));
			CakeLog::write('actividad', ' miro la pagina dimensiones codigos cortos view usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
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

				$existe = $this->DimensionesCodigosCorto->findByNombre($this->request->data["DimensionesCodigosCorto"]["nombre"]);

				if(!empty($existe))
				{
					$this->Session->setFlash(__('El codigo corto que esta intentando ingresar ya existe'), 'msg_exito');
					return $this->redirect(array('action'=>'index'));	
				}
				
				$this->DimensionesCodigosCorto->create();
				if ($this->DimensionesCodigosCorto->save($this->request->data)) {
					CakeLog::write('actividad', 'inserto un registro en dimensiones-codigos-cortos - id ' . $this->DimensionesCodigosCorto->id . ' usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash(__('Se registrocorrectamente'), 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('No se registrocorrectamente'), 'msg_fallo');
					return $this->redirect(array('action' => 'index'));
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
			if (!$this->DimensionesCodigosCorto->exists($id)) {
				throw new NotFoundException(__('codigo invalido', 'msg_fallo'));
				return $this->redirect(array('action' => 'index'));
			}
			if ($this->request->is(array('post', 'put'))) {
				if ($this->DimensionesCodigosCorto->save($this->request->data)) {
					CakeLog::write('actividad', 'edito un registro en dimensiones-codigos-cortos - id ' . $this->DimensionesCodigosCorto->id . ' usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash(__('Se registrocorrectamente'), 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('No se registrocorrectamente'), 'msg_fallo');
					return $this->redirect(array('action' => 'index'));
				}
			} else {
				$options = array('conditions' => array('DimensionesCodigosCorto.' . $this->DimensionesCodigosCorto->primaryKey => $id));
				$this->request->data = $this->DimensionesCodigosCorto->find('first', $options);
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
			$this->DimensionesCodigosCorto->id = $id;
			if (!$this->DimensionesCodigosCorto->exists()) {
				throw new NotFoundException(__('Codigo invalido'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->request->allowMethod('post', 'delete');
			if ($this->DimensionesCodigosCorto->delete()) {
				CakeLog::write('elimino', 'inserto un registro en dimensiones-codigos-cortos - id ' . $id . ' usuario ' . $this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash(__('Se elimino el registro'), 'msg_exito');
			} else {
				$this->Session->setFlash(__('No se pudo eliminar'), 'msg_fallo');
			}
			return $this->redirect(array('action' => 'index'));
		}
	}
}
