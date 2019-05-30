<?php
App::uses('AppController', 'Controller');
/**
 * ListaCorreosTipos Controller
 *
 * @property ListaCorreosTipo $ListaCorreosTipo
 * @property PaginatorComponent $Paginator
 */
class ListaCorreosTiposController extends AppController {

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
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}

		$listaCorreosTipos = $this->ListaCorreosTipo->find('all', array(
			'order'=>'ListaCorreosTipo.nombre ASC',
			'fields'=>array(
				'ListaCorreosTipo.id',
				'ListaCorreosTipo.nombre',
				'ListaCorreosTipo.descripcion',
				),
			'conditions'=>array("ListaCorreosTipo.estado"=>1)
			)
		);
		$this->set('listaCorreosTipos', $listaCorreosTipos);
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
				$this->request->data["ListaCorreosTipo"]["nombre"] = mb_strtolower($this->data["ListaCorreosTipo"]["nombre"]);
				$nombre = $this->ListaCorreosTipo->find("first", array("conditions"=>array("ListaCorreosTipo.nombre"=>$this->data["ListaCorreosTipo"]["nombre"], "ListaCorreosTipo.estado"=>1)));
				if(empty($nombre))
				{
					$this->request->data["ListaCorreosTipo"]["estado"] = 1;
					if ($this->ListaCorreosTipo->save($this->request->data)) 
					{
						CakeLog::write('actividad', 'agrego - ListaCorreosTipos - add - '.$this->ListaCorreosTipo->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						$this->Session->setFlash('El tipo fue ingresado correctamente', 'msg_exito');
						return $this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash('El tipo no fue agregado', 'msg_fallo');
					}	
				}else
				{
					$this->Session->setFlash('El tipo no fue agregado, el nombre ya existe', 'msg_fallo');
				}
				
			} 
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
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
			if(!$this->ListaCorreosTipo->exists($id)) {
				throw new NotFoundException(__('Tipo lista de correo no existe'));
			}

			if($this->request->is(array('post', 'put'))) {
				$this->request->data["ListaCorreosTipo"]["nombre"] = mb_strtolower($this->data["ListaCorreosTipo"]["nombre"]);
				$nombre = $this->ListaCorreosTipo->find("first", array("conditions"=>array("ListaCorreosTipo.nombre"=>$this->data["ListaCorreosTipo"]["nombre"], "ListaCorreosTipo.estado"=>1)));
				if(empty($nombre) || $this->request->data["ListaCorreosTipo"]["nombre"] == $nombre["ListaCorreosTipo"]["nombre"])
				{
					$this->request->data["ListaCorreosTipo"]["estado"] = 1;
					if($this->ListaCorreosTipo->save($this->request->data)) {
						CakeLog::write('actividad', 'edito - ListaCorreosTipos - edit - '.$this->request->data["ListaCorreosTipo"]["id"].' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						$this->Session->setFlash('El tipo de lista correo fue editado correctamente', 'msg_exito');
						return $this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash('El tipo de lista correo no fue editado', 'msg_fallo');
					}
				}else
				{
					$this->Session->setFlash('El tipo de lista correo no fue agregado, el nombre ya existe', 'msg_fallo');
				}
			} else {
				$options = array('conditions' => array('ListaCorreosTipo.' . $this->ListaCorreosTipo->primaryKey=>$id));
				$this->request->data = $this->ListaCorreosTipo->find('first', $options);

			}
		} else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
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
			$this->ListaCorreosTipo->id = $id;
			if (!$this->ListaCorreosTipo->exists()) {
				$this->Session->setFlash('El tipo a eliminar no existe', 'msg_fallo');
				return $this->redirect(array("action" => 'index'));
			}
			$this->request->allowMethod('post', 'delete');
			$this->request->data["ListaCorreosTipo"]["id"] = $id;
			$this->request->data["ListaCorreosTipo"]["estado"] = 0;
			if ($this->ListaCorreosTipo->save($this->request->data)) {
				CakeLog::write('actividad', 'elimino - ListaCorreosTipos - delete - '.$this->request->data["ListaCorreosTipo"]["id"].' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('El tipo de lista correo ha sido eliminado.', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El tipo de lista correo no ha podido ser eliminado. Por favor, intente nuevamente', 'msg_fallo'));
			}
			return $this -> redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function lista_correos_tipos(){

		$this->layout = "ajax";

		$listaCorreosTipos = $this->ListaCorreosTipo->find("all", array("conditions"=>array("ListaCorreosTipo.estado"=>1), "order"=>"ListaCorreosTipo.nombre ASC"));
		if(!empty($listaCorreosTipos)){
			$respuesta = array(
				"estado"=>1,
				"data" => $listaCorreosTipos
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
