<?php
App::uses('AppController', 'Controller');
/**
 * DimensionesProyectos Controller
 *
 * @property DimensionesProyecto $DimensionesProyecto
 * @property PaginatorComponent $Paginator
 */
class DimensionesProyectosController extends AppController {

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
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this-> redirect(array("controller" => 'users', "action" => 'login'));
		}
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		$this->set('dimensionesProyectos', $dimensionesProyectos);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DimensionesProyecto->exists($id)) {
			throw new NotFoundException(__('Invalid dimensiones proyecto'));
		}
		$options = array('conditions' => array('DimensionesProyecto.' . $this->DimensionesProyecto->primaryKey => $id));
		$this->set('dimensionesProyecto', $this->DimensionesProyecto->find('first', $options));
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
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if ($this->Session->read('Users.flag') == 1) 
		{
			if ($this->request->is('post')) {
				$codigo = $this->DimensionesProyecto->find("first", array("conditions"=>array("DimensionesProyecto.codigo"=>$this->request->data["DimensionesProyecto"]["codigo"])));
				if(!empty($codigo)){
					$this->Session->setFlash('El codigo ingresado ya existe', 'msg_fallo');
					return $this->redirect(array("controller" => 'dimensiones_proyectos', "action" => 'add'));
				}
				$this->request->data["DimensionesProyecto"]["descripcion"] = "Proyectos";
				$this->DimensionesProyecto->create();
				//pr($this->request->data);exit;
				if ($this->DimensionesProyecto->save($this->request->data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this->Session->read("PerfilUsuario.idUsuario");
					$mensaje = 'Se crea dimension proyecto codigo"'.$this->request->data["DimensionesProyecto"]["codigo"].'" con ID '.$this->DimensionesProyecto->id;
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this->ActividadUsuario->save($log);
					$this->Session->setFlash('El cargo fue ingresado correctamente', 'msg_exito');
					return $this->redirect(array('action' => 'index'));
					$this->Session->setFlash(__('The dimensiones proyecto has been saved.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('La dimension proyectos no fue ingresada, por favor consulta con el administrador', 'msg_fallo');
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
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		if ($this->Session->read('Users.flag') == 1) {
			if (!$this->DimensionesProyecto->exists($id)) {
				$this->Session->setFlash('No existe el registro para editar', 'msg_fallo');
				return $this -> redirect(array('action' => 'index'));
			}
			if ($this->request->is(array('post', 'put'))) {
				$codigo = $this->DimensionesProyecto->find("first", array("conditions"=>array("DimensionesProyecto.codigo"=>$this->request->data["DimensionesProyecto"]["codigo"])));
				if(!empty($codigo)){
					if($codigo["DimensionesProyecto"]["id"] != $this->request->data["DimensionesProyecto"]["id"]){
						$this->Session->setFlash('El codigo ingresado ya existe', 'msg_fallo');
						return $this->redirect(array("controller" => 'dimensiones_proyectos', "action" => 'edit', $id));
					}
				}
				if ($this->DimensionesProyecto->save($this->request->data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this->Session->read("PerfilUsuario.idUsuario");
					$mensaje = 'Se modifica codigo "'.$this->request->data["DimensionesProyecto"]["codigo"].'" con ID '.$this->request->data["DimensionesProyecto"]["codigo"];
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this->ActividadUsuario->save($log);
					$this->Session->setFlash('La dimension proyecto fue editada correctamente', 'msg_exito');
					return $this -> redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('La dimension proyectos no fue editada, por favor consulta con el administrador', 'msg_fallo');
				}
			} else {
				$options = array('conditions' => array('DimensionesProyecto.' . $this->DimensionesProyecto->primaryKey => $id));
				$this->request->data = $this->DimensionesProyecto->find('first', $options);
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
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		if ($this->Session->read('Users.flag') == 1) {
			$this->DimensionesProyecto->id = $id;
			if (!$this->DimensionesProyecto->exists()) {
				$this->Session->setFlash('No existe el registro para editar', 'msg_fallo');
				return $this -> redirect(array('action' => 'index'));
			}
			$this->request->allowMethod('post', 'delete');
			if ($this->DimensionesProyecto->delete()) {
				$this->loadModel("ActividadUsuario");
				$usuario = $this->Session->read("PerfilUsuario.idUsuario");
				$mensaje = "Se elimino dimension proyectos ".$id;
				$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
				$this->ActividadUsuario->save($log);	
				$this->Session->setFlash('La dimension proyectos fue eliminada', 'msg_exito');
			} else {
				$this->Session->setFlash('La dimension proyectos no fue eliminada, por favor consulta con el administrador', 'msg_fallo');
			}
			return $this->redirect(array('action' => 'index'));
		}
	}
}
