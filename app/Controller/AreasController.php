<?php
App::uses('AppController', 'Controller');

class AreasController extends AppController {

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

		$menus = $this->Area->find('all', array('conditions'=>array('Area.estado'=>1), 'order'=>'Area.nombre ASC'));

		$this -> set('areas', $menus);
	}

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
		
		if ($this->Session->read('Users.flag') == 1) 
		{
			if ($this->request->is(array('post', 'put'))) 
			{
				$this->request->data["Area"]["nombre"] = mb_strtolower($this->data["Area"]["nombre"]);
				$nombre = $this->Area->find("first", array("conditions"=>array("Area.nombre"=>$this->data["Area"]["nombre"], "Area.estado"=>1)));
				if(empty($nombre))
				{	
					if ($this->Area->save($this->request->data)) {
						$this->loadModel("ActividadUsuario");
						$usuario = $this->Session->read("PerfilUsuario.idUsuario");
						$mensaje = 'Se crea área "'.$this->request->data["Area"]["nombre"].'" con ID '.$this->Area->id;
						$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
						$this->ActividadUsuario->save($log);
						$this->Session->setFlash('El area fue ingresada correctamente', 'msg_exito');
						return $this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash('La area no fue agregada', 'msg_fallo');
					}
				}else
				{
					$this->Session->setFlash('La área no fue agregada, el nombre ya existe', 'msg_fallo');
				}
			}
			$this->loadModel("Gerencia");
			$gerencias = $this -> Gerencia -> find('list', array('conditions'=>array('Gerencia.estado'=>1), 'fields' => array('Gerencia.id', 'Gerencia.nombre'), 'order'=>'Gerencia.nombre ASC'));
			$gerencias = array(""=>"")+$gerencias;
			$this -> set('gerencias', $gerencias);			 

		} else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

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
		
		if ($this -> Session -> read('Users.flag') == 1) {
			if (!$this -> Area -> exists($id)) {
				throw new NotFoundException(__('Area no existe'));
			}

			if ($this -> request -> is(array('post', 'put'))) {
				$this->request->data["Area"]["nombre"] = mb_strtolower($this->data["Area"]["nombre"]);
				$nombre = $this->Area->find("first", array("conditions"=>array("Area.nombre"=>$this->data["Area"]["nombre"], "Area.estado"=>1)));
				if(empty($nombre) || $nombre["Area"]["id"] == $id)
				{
					if ($this -> Area -> save($this -> request -> data)) {
						$this->loadModel("ActividadUsuario");
						$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
						$mensaje = 'Se modifica area "'.$this -> request -> data["Area"]["nombre"].'" con ID '.$this -> request -> data["Area"]["id"];
						$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
						$this -> ActividadUsuario -> save($log);
						$this -> Session -> setFlash('El area fue editado correctamente', 'msg_exito');
						return $this -> redirect(array('action' => 'index'));
					} else {
						$this -> Session -> setFlash('El area no fue editada', 'msg_fallo');
					}
				}else
				{
					$this->Session->setFlash('La gerencia no fue agregada, el nombre ya existe', 'msg_fallo');
				}	
			} else {
				$options = array('conditions' => array('Area.' . $this -> Area -> primaryKey => $id));
				$this -> request -> data = $this -> Area -> find('first', $options);

			}
			
			$this->loadModel("Gerencia");
			$gerencias = $this -> Gerencia -> find('list', array('conditions'=>array('Gerencia.estado'=>1),'fields' => array('Gerencia.id', 'Gerencia.nombre'), 'order'=>'Gerencia.nombre ASC'));
			$gerencias = array(""=>"")+$gerencias;
			$this -> set('gerencias', $gerencias);

		} else {
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function delete() {
		
		$this->layout = null;
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

		if ($this -> Session -> read('Users.flag') == 1) {
			$this -> Area -> id = $this->data["id"];
			if (!$this -> Area -> exists()) {
				throw new NotFoundException(__('Area Invalido'));
			}
			$this -> request -> allowMethod('post', 'delete');
			$data = array('id' => $this->data["id"], 'estado' => 0);
			if ($this -> Area -> save($data)) {
				$this->loadModel("ActividadUsuario");
				$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
				$mensaje = "Se elimino area ".$this->data["id"];
				$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
				$this -> ActividadUsuario -> save($log);	
				$this -> Session -> setFlash('La área ha sido eliminada.', 'msg_exito');
			} else {
				$this -> Session -> setFlash(__('La área no ha podido ser eliminada. Por favor, intente nuevamente', 'msg_fallo'));
			}
		} else {
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function areas_list(){

		$this->autoRender = false;
		$areas = $this->Area->find("all", array("conditions"=>array("Area.estado"=>1),"fields"=>array("Area.id", "Area.nombre", "Area.gerencia_id"), "order"=>"Area.nombre"));
		if(!empty($areas)){
			$respuestaArray = array();
			foreach ($areas as $area) {
				array_push($respuestaArray, array(
					"id"=>$area["Area"]["id"],
					"nombre"=>$area["Area"]["nombre"],
					"gerencia_id"=>$area["Area"]["gerencia_id"]
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
		//$this->set("respuesta", json_encode($respuesta));
	}
}
