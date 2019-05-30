<?php
App::uses('AppController', 'Controller');

class PaginasController extends AppController {
	

	public function lista_botones_json()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$botonera = "";

		if(!empty($this->params->query["paginaId"]))
		{
			$paginasBotones = $this->Pagina->find("first", array(
				'conditions'=>array("Pagina.id"=>$this->params->query["paginaId"]),
				'fields'=>array("Pagina.controlador", "Pagina.accion"),
				'recursive'=>-1
			));
 		}

 		$botonera = "";
 		if(!empty($paginasBotones["Pagina"]["controlador"]))
 		{
 			if($this->Session->read("BotonesSecundarios") != Null)
			{
				foreach($this->Session->read("BotonesSecundarios") as $key => $dataBotones)
				{
					foreach($dataBotones as $dataBotone)
					{
						foreach($dataBotone as $botones)
						{
							if($paginasBotones["Pagina"]["controlador"] == $botones["controlador"])
							{
								$botonera[] = array(
									"PaginaId"=>$botones["idPagina"],
									"Controlador"=>$botones["controlador"],
									"Accion"=>$botones["accion"],
									"AccionFantasia"=>$botones["accionFantasia"]
								);
							}
						}	
					}
				}
			}	
 		}

 		$this->set("botonera", $botonera);
	}

	public function lista_paginas_json()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$paginas = $this->Pagina->find('all', array("recursive"=>0));
		
		//pr($paginas);
		//exit;


		$this->loadModel("Role");
		
		if(!empty($paginas))
		{
			$paginasJson = "";
			
			foreach($paginas as $pagina)
			{
				$paginasJson[] = array(
					"Id"=>$pagina["Pagina"]["id"],
					"ControladorFantasia"=>$pagina["Pagina"]["controlador_fantasia"],
					"AccionFantasia"=>$pagina["Pagina"]["accion_fantasia"],
					"Alias"=>$pagina["Pagina"]["alias"],
					"MenuId"=>$pagina["Menu"]["id"],
					"MenuNombre"=>$pagina["Menu"]["nombre"],
					"FechaCreacion"=>$pagina["Pagina"]["created"]
				);
			}
		}
	
		$this->set('paginas', $paginasJson);
	}

	public function asigna_roles($idRol){
			
		$this->layout = "angular";
		if(empty($idRol))
		{
			$this->Session->setFlash('Seleccione un Rol', 'msg_fallo');
			return $this -> redirect(array("controller" => 'roles', "action" => 'index'));
		}
		
		$this->loadModel("Role");
		$rolSeleccionado = $this->Role->find("first", array(
			"conditions"=>array("Role.id"=>$idRol), 
			"recursive"=>0
		));
	
		$this->set("rolSeleccionado", $rolSeleccionado["Role"]["nombre"]);
	}
	
	public function index(){
		
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

		$this->layout = "angular";
	}

	public function add() {
	Configure::write('debug', 1); 
		
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
				if ($this->Pagina->save($this->request->data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
					$mensaje = 'Se crea pagina "'.$this -> request -> data["Pagina"]["alias"].'" con ID '.$this -> Pagina -> id;
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this -> ActividadUsuario -> save($log);
					$this->Session->setFlash('La pagina fue ingresada correctamente', 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('El rol no fue agregado', 'msg_fallo');
				}
			}
			$this->loadModel("Menu");
			$menus = $this -> Menu -> find('list', array('fields' => array('Menu.id', 'Menu.nombre'), 'order'=>'Menu.nombre ASC'));
			$menus = array(""=>"")+$menus;
			$this -> set('menus', $menus); 

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
			if (!$this -> Pagina -> exists($id)) {
				throw new NotFoundException(__('Pagina no existe'));
			}

			if ($this -> request -> is(array('post', 'put'))) {

				if ($this -> Pagina -> save($this -> request -> data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
					$mensaje = 'Se modifica pagina "'.$this -> request -> data["Pagina"]["alias"].'" con ID '.$this -> request -> data["Pagina"]["id"];
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this -> ActividadUsuario -> save($log);
					$this -> Session -> setFlash('La pagina fue editado correctamente', 'msg_exito');
					return $this -> redirect(array('action' => 'index'));
				} else {
					$this -> Session -> setFlash('La pagina no fue editada', 'msg_fallo');
				}
			} else {
				$options = array('conditions' => array('Pagina.' . $this -> Pagina -> primaryKey => $id));
				$this -> request -> data = $this -> Pagina -> find('first', $options);

			}
			$this->loadModel("Menu");
			$menus = $this -> Menu -> find('list', array('fields' => array('Menu.id', 'Menu.nombre'), 'order'=>'Menu.nombre ASC'));
			$menus = array(""=>"")+$menus;
			$this -> set('menus', $menus); 

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
			$this -> Pagina -> id = $id;
			if (!$this -> Pagina -> exists()) {
				throw new NotFoundException(__('Usuario Invalido'));
			}
			$this -> request -> allowMethod('post', 'delete');
			if ($this -> Pagina -> delete()) {
				$this->loadModel("ActividadUsuario");
				$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
				$mensaje = "Se elimina pagina ".$id;
				$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
				$this -> ActividadUsuario -> save($log);
				$this -> Session -> setFlash('La pagina ha sido borrado.', 'msg_exito');
			} else {
				$this -> Session -> setFlash(__('La pagina no ha podido ser borrado. Por favor, intente nuevamente', 'msg_fallo'));
			}
			return $this -> redirect(array('action' => 'index'));
		} else {
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
	}
}
