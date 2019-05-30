<?php
App::uses('AppController', 'Controller');
/**
 * ListaCorreos Controller
 *
 * @property ListaCorreo $ListaCorreo
 * @property PaginatorComponent $Paginator
 */
class ListaCorreosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function index(){

		$this->layout="angular";

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

	public function add(){

		$this->set("appAngular", "angularAppText");
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

	public function edit(){

		$this->set("appAngular", "angularAppText");
		$this->layout="angular";

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

	public function lista_correos(){

		$this->layout = "ajax";

		$listaCorreos = $this->ListaCorreo->find("all", array("conditions"=>array("ListaCorreo.estado"=>1), "order"=>"ListaCorreo.nombre ASC"));
		if(!empty($listaCorreos)){
			$respuesta = array(
				"estado"=>1,
				"data" => $listaCorreos
			);
		}else
		{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Sin datos"
			);
		}
			
		$this->set("resultado", json_encode($respuesta));

	}

	public function registrar_lista_correos(){

		$this->layout = "ajax";

		if ($this->request->is(array('post', 'put'))) 
		{
			$this->request->data["ListaCorreo"]["nombre"] = mb_strtolower($this->data["ListaCorreo"]["nombre"]);
			$nombre = $this->ListaCorreo->find("first", array("conditions"=>array("ListaCorreo.nombre"=>$this->data["ListaCorreo"]["nombre"], "ListaCorreo.estado"=>1)));
			if(empty($nombre)){
				if($this->ListaCorreo->save($this->request->data)){
					CakeLog::write('actividad', 'agrego - ListaCorreo - registrar_lista_correos - '.$this->ListaCorreo->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>'La lista fue ingresado correctamente'
						);
					$this->Session->setFlash('La lista fue ingresado correctamente', 'msg_exito');
				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>'La lista no pudo ser agregado, por favor intente de nuevo o avise al administrador'
						);
					$this->Session->setFlash('La lista no pudo ser agregado, por favor intente de nuevo o avise al administrador', 'msg_fallo');
				}	
			}else
			{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"La lista no fue agregado, el nombre ya existe"
					);
				$this->Session->setFlash('La lista no fue agregado, el nombre ya existe', 'msg_fallo');
			}
			
		}
		$this->set("respuesta", json_encode($respuesta));
		
	}

	public function lista_correo(){

		$this->layout = "ajax";
		$listaCorreo= $this->ListaCorreo->find("first", array("conditions"=>array("ListaCorreo.id"=>$this->request->query["id"],"ListaCorreo.estado"=>1)));
		if(!empty($listaCorreo)){
			$respuesta = array(
				"estado"=>1,
				"data" => $listaCorreo
			);
		}else
		{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Sin datos"
			);
		}
			
		$this->set("resultado", json_encode($respuesta));
		
	}

	public function editar_lista_correos(){

		$this->layout = "ajax";

		if ($this->request->is(array('post', 'put'))){
			$this->request->data["ListaCorreo"]["nombre"] = mb_strtolower($this->data["ListaCorreo"]["nombre"]);
			$nombre = $this->ListaCorreo->find("first", array("conditions"=>array("ListaCorreo.nombre"=>$this->data["ListaCorreo"]["nombre"], "ListaCorreo.estado"=>1)));
			if(empty($nombre) || $nombre["ListaCorreo"]["id"] == $this->request->data["ListaCorreo"]["id"]){
				if($this->ListaCorreo->save($this->request->data)){
					CakeLog::write('actividad', 'edito - ListaCorreos - id - '.$this->ListaCorreo->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>'La lista fue editado correctamente'
						);
					$this->Session->setFlash('La lista fue editado correctamente', 'msg_exito');
				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>'La lista no pudo ser editado, por favor intente de nuevo o avise al administrador'
						);
					$this->Session->setFlash('La lista no pudo ser editado, por favor intente de nuevo o avise al administrador', 'msg_fallo');
				}	
			}else
			{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"La lista no fue editado, el nombre ya existe"
					);
				$this->Session->setFlash('La lista no fue editado, el nombre ya existe', 'msg_fallo');
			}
			
		}
		$this->set("resultado", json_encode($respuesta));
		
	}

	public function delete() {
		$this->layout = "ajax";
		$this->ListaCorreo->id = $this->request->data["ListaCorreo"]["id"];
		if($this->ListaCorreo->exists()){
			if($this->request->is(array('post', 'put'))){
				$listaCorreos = $this->ListaCorreo->find("first", array(
					"conditions"=>array(
						"ListaCorreo.id"=>$this->ListaCorreo->id
						)
					)
				);
				if(empty($listaCorreos["Trabajadore"])){
					if ($this->ListaCorreo->save($this->request->data)) {
						CakeLog::write('actividad', 'elimino - ListaCorreo - delete - '.$this->ListaCorreo->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						$this->Session->setFlash('La lista de correo fue eliminado correctamente', 'msg_exito');
						$respuesta = array("estado",1);
					} else {
						$this->Session->setFlash('No se pudo eliminar la lista', 'msg_fallo');
						$respuesta = array("estado",0);
					}	
				}else{
					$this->Session->setFlash('No se puede eliminar, tiene '.count($listaCorreos["Trabajadore"]).' trabajadores asociados', 'msg_fallo');
					$respuesta = array("estado",0);
				}
			}else{
				$this->Session->setFlash('No se puede eliminar', 'msg_fallo');
				$respuesta = array("estado",0);
			}	
		}else{
			$this->Session->setFlash('El mensaje no existe', 'msg_fallo');
			$respuesta = array("estado",0);
		}
		$this->set("resultado", json_encode($respuesta));
		
		
	}

	public function trabajadores(){
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

	public function lista_correos_trabajadores(){

		$this->layout = "ajax";
		$listaCorreosTrabajadores = $this->ListaCorreo->find("first", array(
			"conditions"=>array(
				"ListaCorreo.id"=>$this->request->query["id"],
				"ListaCorreo.estado"=>1
				),
			"recursive"=>2
			)
		);
		if(!empty($listaCorreosTrabajadores)){
			$respuesta = array(
				"estado"=>1,
				"data" => $listaCorreosTrabajadores
			);
		}else
		{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Sin datos"
			);
		}
			
		$this->set("resultado", json_encode($respuesta));
	}

}
