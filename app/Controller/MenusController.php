<?php
App::uses('AppController', 'Controller');

class MenusController extends AppController {

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

		$menus = $this -> Menu -> find('all');

		$this -> set('menus', $menus);
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
		
		if ($this->Session->read('Users.flag') == 1) {
			if ($this->request->is(array('post', 'put'))) {
				//pr($this->request->data);exit;
				if ($this->Menu->save($this->request->data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
					$mensaje = 'Se crea menu "'.$this -> request -> data["Menu"]["nombre"].'" con ID '.$this -> Menu -> id;
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this -> ActividadUsuario -> save($log);
					$this->Session->setFlash('El menu fue ingresada correctamente', 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('El rol no fue agregado', 'msg_fallo');
				}
			} 

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
			if (!$this -> Menu -> exists($id)) {
				throw new NotFoundException(__('Menu no existe'));
			}

			if ($this -> request -> is(array('post', 'put'))) {

				if ($this -> Menu -> save($this -> request -> data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
					$mensaje = 'Se modifica menu "'.$this -> request -> data["Menu"]["nombre"].'" con ID '.$this -> request -> data["Menu"]["id"];
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this -> ActividadUsuario -> save($log);
					$this -> Session -> setFlash('El menu fue editado correctamente', 'msg_exito');
					return $this -> redirect(array('action' => 'index'));
				} else {
					$this -> Session -> setFlash('El menu no fue editada', 'msg_fallo');
				}
			} else {
				$options = array('conditions' => array('Menu.' . $this -> Menu -> primaryKey => $id));
				$this -> request -> data = $this -> Menu -> find('first', $options);

			}
			

		} else {
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

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

		if ($this -> Session -> read('Users.flag') == 1) {
			$this -> Menu -> id = $id;
			if (!$this -> Menu -> exists()) {
				throw new NotFoundException(__('Menu Invalido'));
			}
			$this -> request -> allowMethod('post', 'delete');
			if ($this -> Menu -> delete()) {
				$this->loadModel("ActividadUsuario");
				$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
				$mensaje = "Se elimino menu ".$id;
				$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
				$this -> ActividadUsuario -> save($log);	
				$this -> Session -> setFlash('El menu ha sido borrado.', 'msg_exito');
			} else {
				$this -> Session -> setFlash(__('El menu no ha podido ser borrado. Por favor, intente nuevamente', 'msg_fallo'));
			}
			return $this -> redirect(array('action' => 'index'));
		} else {
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
	}
}
