<?php
App::uses('AppController', 'Controller');

class GerenciasController extends AppController {

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

		$gerencias = $this -> Gerencia -> find('all', array('conditions'=>array('Gerencia.estado'=>1), 'order'=>'Gerencia.nombre ASC'));
		$this -> set('gerencias', $gerencias);
	}

	public function add() {
		
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
		
		if ($this->Session->read('Users.flag') == 1) 
		{
			if ($this->request->is(array('post', 'put'))) 
			{
				$this->request->data["Gerencia"]["nombre"] = mb_strtolower($this->data["Gerencia"]["nombre"]);
				$nombre = $this->Gerencia->find("first", array("conditions"=>array("Gerencia.nombre"=>$this->data["Gerencia"]["nombre"], "Gerencia.estado"=>1)));
				if(empty($nombre))
				{
					if ($this->Gerencia->save($this->request->data)) 
					{
						$this->loadModel("ActividadUsuario");
						$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
						$mensaje = 'Se crea gerencia "'.$this -> request -> data["Gerencia"]["nombre"].'" con ID '.$this -> Gerencia -> id;
						$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
						$this -> ActividadUsuario -> save($log);
						$this->Session->setFlash('La gerencia fue ingresada correctamente', 'msg_exito');
						return $this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash('La gerencia no fue agregado', 'msg_fallo');
					}	
				}else
				{
					$this->Session->setFlash('La gerencia no fue agregada, el nombre ya existe', 'msg_fallo');
				}
				
			} 
		}else {
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
			if (!$this -> Gerencia -> exists($id)) {
				throw new NotFoundException(__('Gerencia no existe'));
			}

			if ($this -> request -> is(array('post', 'put'))) {
				$this->request->data["Gerencia"]["nombre"] = mb_strtolower($this->data["Gerencia"]["nombre"]);
				$nombre = $this->Gerencia->find("first", array("conditions"=>array("Gerencia.nombre"=>$this->data["Gerencia"]["nombre"], "Gerencia.estado"=>1)));
				if(empty($nombre))
				{
					if ($this -> Gerencia -> save($this->request->data)) {
						$this->loadModel("ActividadUsuario");
						$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
						$mensaje = 'Se modifica gerencia "'.$this ->request->data["Gerencia"]["nombre"].'" con ID '.$this->request->data;
						$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
						$this -> ActividadUsuario -> save($log);
						$this -> Session -> setFlash('La gerencia fue editada correctamente', 'msg_exito');
						return $this -> redirect(array('action' => 'index'));
					} else {
						$this -> Session -> setFlash('La gerencia no fue editada', 'msg_fallo');
					}
				}else
				{
					$this->Session->setFlash('La gerencia no fue agregada, el nombre ya existe', 'msg_fallo');
				}
			} else {
				$options = array('conditions' => array('Gerencia.' . $this -> Gerencia -> primaryKey => $id));
				$this -> request -> data = $this -> Gerencia -> find('first', $options);

			}
			

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
			$this -> Gerencia -> id = $this->data["id"];
			if (!$this -> Gerencia -> exists()) {
				throw new NotFoundException(__('Gerencia Invalida'));
			}
			$this -> request -> allowMethod('post', 'delete');
			$data = array('id' => $this->data["id"], 'estado' => 0);
			if ($this -> Gerencia -> save($data)) {
				$this->loadModel("ActividadUsuario");
				$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
				$mensaje = "Se elimino gerencia ".$id;
				$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
				$this -> ActividadUsuario -> save($log);	
				$this -> Session -> setFlash('La gerencia ha sido eliminada.', 'msg_exito');
			} else {
				$this -> Session -> setFlash(__('La gerencia no ha podido ser eliminada. Por favor, intente nuevamente', 'msg_fallo'));
			}
		} else {
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function gerencias_list(){

		$this->autoRender = false;
		$gerencias = $this->Gerencia->find("all", array("conditions"=>array("Gerencia.estado"=>1),"fields"=>array("Gerencia.id", "Gerencia.nombre"), "order"=>"Gerencia.nombre"));
		if(!empty($gerencias)){
			$respuestaArray = array();
			foreach ($gerencias as $gerencia) {
				array_push($respuestaArray, array(
					"id"=>$gerencia["Gerencia"]["id"],
					"nombre"=>$gerencia["Gerencia"]["nombre"],
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
