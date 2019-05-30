<?php
App::uses('AppController', 'Controller');

class RolesController extends AppController {
	
	public $components = array('RequestHandler');
	
	public function lista_roles_nombres_json()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		
		if($this->Session->Read("Users.flag") != 0)
		{
			$idroles = explode(",", $this->params->query["idRoles"]);	
			$roles = $this->Role->find('all', array(
				"conditions"=>array("Role.id"=>$idroles),
				"recursive"=>0
			));
			
			$rolesJson = "";
			if(!empty($roles))
			{
				foreach($roles as $rol)
				{
					$rolesJson[] = array(
						"Id"=>$rol["Role"]["id"], 
						"Nombre"=>$rol["Role"]["nombre"]
					);
				}
				$this->set('rolesJson', $rolesJson);
			}
		}
	}
	
	public function lista_roles_json()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		
		if($this->Session->Read("Users.flag") != 0)
		{
		
			$roles = $this->Role->find('all', array(
				"conditions"=>array("Role.estado !="=>0),
				"recursive"=>-1
			));
			
			$rolesJson = "";
			if(!empty($roles))
			{
				foreach($roles as $rol)
				{
					$rolesJson[] = array(
						"Id"=>$rol["Role"]["id"], 
						"Nombre"=>$rol["Role"]["nombre"],
						"Estado"=>$rol["Role"]["estado"]
					);
				}
				$this->set('rolesJson', $rolesJson);
			}
		}
	}
	
	public function index() {
		$this->layout = "angular";
	
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
	}
	
	public function add() {
		//$this->layout = "ajax";
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
			if ($this->request->is(array('post', 'put'))) {

					$this->request->data["Role"]["estado"] = 1;
				if ($this->Role->save($this->request->data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this->Session->read("PerfilUsuario.idUsuario");
					$mensaje = 'Se crea rol "'.$this->request->data["Role"]["nombre"].'" con ID '.$this->Role->id;
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this->ActividadUsuario->save($log);
					$this->Session->setFlash('El rol fue ingresado correctamente', 'msg_exito');
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
			if (!$this->Role->exists($id)) {
				throw new NotFoundException(__('Usuario no existe'));
			}

			if ($this->request->is(array('post', 'put'))) {

				if ($this->Role->save($this->request->data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this->Session->read("PerfilUsuario.idUsuario");
					$mensaje = 'Se modifica rol "'.$this->request->data["Role"]["nombre"].'" con ID '.$this->request->data["Role"]["id"];
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this->ActividadUsuario->save($log);
					$this->Session->setFlash('El rol fue editado correctamente', 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('El rol no fue editado', 'msg_fallo');
				}
			} else {
				$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
				$this->request->data = $this->Role->find('first', $options);
			}

		} else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function delete() {

		$this->autoRender = false;
		$this->loadModel("User");
		$this->response->type('json');
		$this->request->allowMethod('post', 'delete');
		if ($this->Session->read('Users.flag') == 1) {
			if($this->Session->Read("Accesos.accesoPagina") == 1)
			{
				$this->Role->id = $this->request->data["id"];
				if ($this->Role->exists()) {
					$usuarios = $this->User->find("all", array("recursive"=>-1));
					$usuariosEncontrados = "";
					foreach ($usuarios as $usuario) {
						if(!empty($usuario["User"]["roles_id"])){
							$roles = explode(",", $usuario["User"]["roles_id"]);
							if(in_array($this->Role->id, $roles)){
								$usuariosEncontrados[] = $usuario["User"];
							} 
						}												
					}
					if(empty($usuariosEncontrados)){
						$rol["Role"] = array("id"=>$this->Role->id, "estado"=>0);
							if ($this->Role->save($rol)) {
								CakeLog::write('actividad', 'Elimino - Roles - delete - '.$this->Role->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
								$respuesta = array(
									"estado"=>1,
									"mensaje"=>"Se elimino correctamente el rol"
									);
							} else {
								$respuesta = array(
									"estado"=>0,
									"mensaje"=>"No se pudo eliminar el rol, por favor intentelo nuevamente"
									);
							}
					}else{
						$mensaje = "No se puede eliminar<br/>Usuarios asociados: <br/><lu>";
						foreach ($usuariosEncontrados as $usuario) {
							$mensaje .= "<li>".$usuario["nombre"]."</li>";
						}
						$mensaje .= "</lu>";
						$respuesta = array(
							"estado"=>0,
							"mensaje"=>$mensaje
							);
					}
				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"Rol no valido"
						);
				}
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No tiene acceso a la pagina, por favor contactarse con el administrador"
					);
			}
		} else {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdio la sessión, por favor vuelva a conectarse e intentelo nuevamente"
				);
		}
		return json_encode($respuesta);
	}

	public function consultaRoles($id = null)
	{
			
		$this->layout = "ajax";
		
		$idPaginas = $this->Role->Find("all", array(
			"conditions"=>array("Role.id"=>$this->params->query["idRol"])
		)); 
		$idPaginasArray = "";
		foreach($idPaginas[0]["PaginasRole"] as $valorIdPAginas)
		{
			$idPaginasArray[] = array("IdRol" => $valorIdPAginas["pagina_id"], "IdPagina"=>$valorIdPAginas["id"]); 
		}
		
		if(!empty($idPaginasArray))
		{
			echo json_encode($idPaginasArray);
		}
		exit;
	}
	
	public function usuariosPorRoles()
	{
		$this->autoRender = false;
		$this->response->type("json");
		
		if(!empty($this->params->query["getId"]))
		{
			$this->loadModel("User");
			$usuarios = $this->User->find("all",array(
				"conditions"=>array("User.estado"=>1),
				'fields'=>array("User.nombre", "User.roles_id"),
				"recursive"=>-1 
			));

			$usuariosExplodeRoles = "";
			foreach($usuarios as $usuario)
			{
				$usuariosExplodeRoles[] = array("nombre"=>$usuario["User"]["nombre"], "roles"=>explode(",", $usuario["User"]["roles_id"]));
			}

			$usuariosAsociados = "";

			foreach ($usuariosExplodeRoles as $usuariosRoles) {
				foreach($usuariosRoles["roles"] as $rol)
				{
					if($this->params->query["getId"] == $rol)
					{
						$usuariosAsociados[] = array("usuario"=>$usuariosRoles["nombre"]);
					}
				}
			}
		}
		return json_encode($usuariosAsociados);
		//$this->set('usuarios', $usuariosAsociados);
        //$this->set('_serialize', 'usuarios');
	}
	
}
