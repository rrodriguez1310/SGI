<?php
App::uses('AppController', 'Controller');
/**
 * Promociones Controller
 *
 * @property Promocione $Promocione
 * @property PaginatorComponent $Paginator
 */
class PromocionesController extends AppController {

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
		$this->layout = "angular";
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
		CakeLog::write('actividad', 'Visito - Promociones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->loadModel("Channel");
		$this->loadModel("Company");
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
		CakeLog::write('actividad', 'Visito - Promociones - view - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		if (!$this->Promocione->exists($id)) {
			throw new NotFoundException(__('Promoción invalida'));
		}
		$options = array('conditions' => array('Promocione.' . $this->Promocione->primaryKey => $id));
		$promocion =  $this->Promocione->find('first', $options);
		$promocion["Promocione"]["channel_nombre"] = $this->Channel->findById($promocion["Promocione"]["channel_id"], array("fields" => "nombre"))["Channel"]["nombre"];
		$promocion["Promocione"]["company_nombre"] = $this->Company->findById($promocion["Promocione"]["company_id"], array("fields" => "nombre"))["Company"]["nombre"];
		$promocion["Promocione"]["estado"] =  $promocion["Promocione"]["estado"] == 0 ? "eliminado" : "activo";
		$this->set('promocione', $promocion);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->layout = "angular";
		$this->loadModel("Channel");
		$this->loadModel("Company");
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
		if ($this->request->is('post')) {
			$this->Promocione->create();
			if ($this->Promocione->save($this->request->data)) {
				CakeLog::write('actividad', 'Guardo - Promociones - add - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('La promocion fue ingresada correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La promoción no se pudo guardar, por favor vuelve a intentar.'), "msg_fallo");
			}
		}
		CakeLog::write('actividad', 'Visito - Promociones - add - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$this->set("channels", $this->Channel->find("list", ["fields" => ["Channel.id","Channel.nombre"], "conditions" => ["Channel.estado" => 1, "Channel.tipo" => 1], "order" => ["Channel.nombre" => "asc"]]));
		$this->set("companies", $this->Company->find("list", ["fields" => ["Company.id","Company.nombre"], "conditions" => ["Company.company_type_id" => 1], "order" => ["Company.nombre" => "asc"]]));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->layout = "angular";
		$this->loadModel("Channel");
		$this->loadModel("Company");
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
		if (!$this->Promocione->exists($id)) {
			throw new NotFoundException(__('Promoción invalida'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Promocione->save($this->request->data)) {
				CakeLog::write('actividad', 'Edito - Promociones - edit - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash(__('La promoción ha sido editado correctamente.'), 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La promoción no se pudo editar, por favor vuelve a intentar.'), 'msg_fallo');
			}
		} else {
			$options = array('conditions' => array('Promocione.' . $this->Promocione->primaryKey => $id));
			$this->request->data = $this->Promocione->find('first', $options);
		}
		CakeLog::write('actividad', 'Visito - Promociones - edit - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$this->set("channels", $this->Channel->find("list", ["fields" => ["Channel.id","Channel.nombre"], "conditions" => ["Channel.estado" => 1, "Channel.tipo" => 1], "order" => ["Channel.nombre" => "asc"]]));
		$this->set("companies", $this->Company->find("list", ["fields" => ["Company.id","Company.nombre"], "conditions" => ["Company.company_type_id" => 1], "order" => ["Company.nombre" => "asc"]]));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->autoRender = false;
		$this->response->type("json");
		$this->Promocione->id = $id;
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") != 0)
			{				
				if (!$this->Promocione->exists()) {
					$respuesta = [
						"status" => "ERROR",
						"message" => "Promocion no existe"
					];
				}
				$this->request->allowMethod('post', 'delete');
				if($this->request->is("post")){
					if ($this->Promocione->save(["Promocione" => ["id" => $id, "estado" => 0]])) {
						CakeLog::write('actividad', 'Elimino - Promociones - delete - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						$respuesta = [
							"status" => "OK",
							"message" => "Promoción eliminada correctamente"
						];
					} else {
						$respuesta = [
							"status" => "ERROR",
							"message" => "Problemas al eliminar la promoción"
						];
					}
				}else{
					$respuesta = [
						"status" => "ERROR",
						"message" => "Metodo no permitido"
					];
				}
			}else{
				$respuesta = [
					"status" => "ERROR",
					"message" => "No tiene permisos para esta acción"
				];
			}
		}else{
			$respuesta = [
				"status" => "ERROR",
				"message" => "Debe hacer login para intentar esta accion"
			];
		}
		return json_encode($respuesta);
		
	}

	public function promo_list_compa_channel($companyId, $channelId){
		$this->autoRender = false;
		$this->response->type("json");
		return json_encode(
			$this->Promocione->find("list",array(
				"fields"=>array(
					"Promocione.id", "Promocione.nombre"
				), 
				"conditions" => array(
					"Promocione.estado" => 1, "Promocione.company_id" => $companyId, "Promocione.channel_id" => $channelId
				)
			))
		);
	}

	public function promociones (){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("Company");
		$this->loadModel("Channel");
		$promocionesQuery = $this->Promocione->find("all", array("recursive" => -1));
		if(!empty($promocionesQuery)){
			foreach ($promocionesQuery as $promocion) {
				$ids["Channel"][] = $promocion["Promocione"]["channel_id"];
				$ids["Company"][] = $promocion["Promocione"]["company_id"]; 
			}
			foreach ($ids as $modelo => $id) {
				$asociados[$modelo] = $this->$modelo->find("list", array("fields" => array($modelo.".id", $modelo.".nombre"), "recursive" => -1));
			}
			foreach ($promocionesQuery as $promocion) {
				$promocion["Promocione"]["channel_nombre"] = $asociados["Channel"][$promocion["Promocione"]["channel_id"]];
				$promocion["Promocione"]["company_nombre"] = $asociados["Company"][$promocion["Promocione"]["company_id"]]; 
				$promocion["Promocione"]["estado"] = $promocion["Promocione"]["estado"] == 0 ? "eliminado" : "activo"; 
				$respuesta[] = $promocion["Promocione"];
			}
		}else{
			$respuesta = array();
		}
		return json_encode($respuesta);	
	}
}
