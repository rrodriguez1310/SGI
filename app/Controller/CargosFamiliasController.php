<?php
App::uses('AppController', 'Controller');
/**
 * CargosFamilias Controller
 *
 * @property CargosFamilia $CargosFamilia
 * @property PaginatorComponent $Paginator
 */
class CargosFamiliasController extends AppController {

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
	    
	    
		/*if($this->Session->Read("Users.flag") != 0)
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
		}*/

		$cargosFamilias = $this->CargosFamilia->find("all", array('conditions'=>array('CargosFamilia.estado'=>1),'order'=>'CargosFamilia.nombre'));
		$this->set('cargosFamilias', $cargosFamilias);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CargosFamilia->exists($id)) {
			throw new NotFoundException(__('Invalid cargos familia'));
		}
		$options = array('conditions' => array('CargosFamilia.' . $this->CargosFamilia->primaryKey => $id));
		$this->set('cargosFamilia', $this->CargosFamilia->find('first', $options));
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
				$this->request->data["CargosFamilia"]["estado"] = 1;
				$this->CargosFamilia->create();
				if ($this->CargosFamilia->save($this->request->data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this->Session->read("PerfilUsuario.idUsuario");
					$mensaje = 'Se crea la familia de cargo "'.$this->request->data["CargosFamilia"]["nombre"].'" con ID '.$this->CargosFamilia->id;
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this->ActividadUsuario->save($log);
					$this->Session->setFlash('La familia fue ingresada correctamente', 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('La familia no fue agregada', 'msg_fallo');
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
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if ($this->Session->read('Users.flag') == 1) 
		{
			if (!$this->CargosFamilia->exists($id)) {
				throw new NotFoundException(__('Familia invalida'));
			}
			if ($this->request->is(array('post', 'put'))) {
				if ($this->CargosFamilia->save($this->request->data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this->Session->read("PerfilUsuario.idUsuario");
					$mensaje = 'Se edito la familia de cargo "'.$this->request->data["CargosFamilia"]["nombre"].'" con ID '.$this->CargosFamilia->$id;
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this->ActividadUsuario->save($log);
					$this->Session->setFlash('La familia fue editada correctamente', 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('La familia no fue editada', 'msg_fallo');
				}
			} else {
				$options = array('conditions' => array('CargosFamilia.' . $this->CargosFamilia->primaryKey => $id));
				$this->request->data = $this->CargosFamilia->find('first', $options);
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
			$this->CargosFamilia->id = $id;
			if (!$this->CargosFamilia->exists()) {
				throw new NotFoundException(__('Familia no valida'));
			}
			$this->request->allowMethod('post', 'delete');
			$this->request->data["CargosFamilia"]["id"] = $id;
			$this->request->data["CargosFamilia"]["estado"] = 0;
			if ($this->CargosFamilia->save($this->request->data)) {
				$this->loadModel("ActividadUsuario");
				$usuario = $this->Session->read("PerfilUsuario.idUsuario");
				$mensaje = 'Se elimino la familia de cargo con ID '.$id;
				$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
				$this->ActividadUsuario->save($log);
				$this->Session->setFlash('La familia fue eliminada correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('La familia no fue eliminada', 'msg_fallo');
			}
			return $this->redirect(array('action' => 'index'));
		}
	}

	public function cargos_familias_list(){

		$this->autoRender = false;
		$this->response->type("json");
		$cargosFamilias = $this->CargosFamilia->find("all", array("conditions"=>array("CargosFamilia.estado"=>1),"fields"=>array("CargosFamilia.id", "CargosFamilia.nombre"), "order"=>"CargosFamilia.nombre"));
		if(!empty($cargosFamilias)){
			$respuestaArray = array();
			foreach ($cargosFamilias as $cargosFamilia) {
				array_push($respuestaArray, array(
					"id"=>$cargosFamilia["CargosFamilia"]["id"],
					"nombre"=>$cargosFamilia["CargosFamilia"]["nombre"],
					)
				);
			}
			$respuesta = array(
				"estado"=>1,
				"data"=>$respuestaArray
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"data"=>"Sin datos"
				);
		}
		return json_encode($respuesta);
	}
}
