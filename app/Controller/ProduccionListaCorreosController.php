<?php
App::uses('AppController', 'Controller');
/**
 * ProduccionListaCorreos Controller
 *
 * @property ProduccionListaCorreo $ProduccionListaCorreo
 * @property PaginatorComponent $Paginator
 */
class ProduccionListaCorreosController extends AppController {

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
	}

	public function listado_lista_correos_json(){
		$this->layout = "ajax";
		$this->response->type("json");				
		$produccionListaCorreos = $this->ProduccionListaCorreo->find("all", array( 
			"conditions"=> array("estado"=>1),
			"order"=>"id")
		);

		if(!empty($produccionListaCorreos)){
			foreach ($produccionListaCorreos as $key => $lista) {
				
				if(!empty($lista["ProduccionListaCorreo"]["produccion_contactos_id"])){
					$contactos = $this->obtContactos(json_decode($lista["ProduccionListaCorreo"]["produccion_contactos_id"],true));
					$nombreContactos = implode(", ",array_values($contactos));
				}
				else
				{
					$nombreContactos = '';					
				}
				
				$lista["ProduccionListaCorreo"]["email"] = $nombreContactos;

				$listasCorreos[] = $lista["ProduccionListaCorreo"];
			}
		}
		else 
		{
			$listasCorreos = array();
		}

		$this->set('listado',$listasCorreos); 
	}

	public function obtContactos($ids){
		$this->loadModel("ProduccionContacto");		
		$listaContactos = $this->ProduccionContacto->find("list", array( 
			"fields"=>array("ProduccionContacto.id","ProduccionContacto.nombre"),
			"conditions"=> array("id"=>$ids),
			"order"=>"id")
		);			
		
		return $listaContactos;
	}

	public function contactos_lista_correos_json($idLista){
		$this->layout = "ajax";
		$this->response->type("json");
		$this->loadModel("ProduccionContacto");

		$produccionContactos = $this->ProduccionContacto->find("all", array( 
			"conditions"=> array("tipo_contacto"=>"destinatarios"),
			"order"=>"id")
		);
		
		$listaCorreosContactos = $this->ProduccionListaCorreo->find("first", array( 
			"conditions"=> array("estado"=>1, "id"=>$idLista),
			"order"=>"id")
		);

		$contactos = $listaCorreos = array();
		if($listaCorreosContactos["ProduccionListaCorreo"]["produccion_contactos_id"])
			$listaCorreos = json_decode($listaCorreosContactos["ProduccionListaCorreo"]["produccion_contactos_id"],true);

			foreach ($produccionContactos as $key => $contacto) {
				if(!empty($listaCorreos)){
					if(in_array($contacto["ProduccionContacto"]["id"], $listaCorreos)){
						$contacto["ProduccionContacto"]["lista"] = $idLista;
					}
				}
				
				$contactos[] = $contacto["ProduccionContacto"];
			}
		
		$this->set('listado',$contactos); 
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ProduccionListaCorreo->exists($id)) {
			throw new NotFoundException(__('Invalid produccion lista correo'));
		}
		$options = array('conditions' => array('ProduccionListaCorreo.' . $this->ProduccionListaCorreo->primaryKey => $id));
		$this->set('produccionListaCorreo', $this->ProduccionListaCorreo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ProduccionListaCorreo->create();



			if ($this->ProduccionListaCorreo->save($this->request->data)) {
				$this->Session->setFlash('Se registro la información correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
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
		if (!$this->ProduccionListaCorreo->exists($id)) {
			throw new NotFoundException(__('Lista correo inválida.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProduccionListaCorreo->save($this->request->data)) {
				$this->Session->setFlash('Se registro la información correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
			}
		} else {
			$options = array('conditions' => array('ProduccionListaCorreo.' . $this->ProduccionListaCorreo->primaryKey => $id));
			$this->request->data = $this->ProduccionListaCorreo->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete_produccion_lista_correos($id = null) {
		$this->layout = "ajax";
		$this->ProduccionListaCorreo->id = $id;
		if (!$this->ProduccionListaCorreo->exists()) {
			throw new NotFoundException(__('Invalid produccion lista correo'));
		}

		$this->request->data["id"] = $this->ProduccionListaCorreo->id;
		$this->request->data["estado"] = 0;

		if ($this->ProduccionListaCorreo->save($this->request->data)) {			
			$this->Session->setFlash('La información fue eliminada correctamente.', 'msg_exito');
		} else {
			$this->Session->setFlash('La información no pudo ser eliminada. Por favor, intente nuevamente.', 'msg_fallo');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function add_correos($idLista){
			
		$this->layout = "angular";
		if(empty($idLista))
		{
			$this->Session->setFlash('Seleccione una Lista', 'msg_fallo');
			return $this -> redirect(array("action" => 'index'));
		}

		$listaSeleccionada = $this->ProduccionListaCorreo->find("first", array(
			"conditions"=>array("ProduccionListaCorreo.id"=>$idLista), 
			"recursive"=>0
		));
	
		$this->set("listaSeleccionada", $listaSeleccionada["ProduccionListaCorreo"]["nombre"]);
	}


	public function add_contacto_lista($idLista, $idContacto){
			
		$this->layout = "ajax";
		if(empty($idLista))
		{
			$this->Session->setFlash('Seleccione una Lista', 'msg_fallo');
			return $this -> redirect(array("action" => 'index'));
		}

		$listaSeleccionada = $this->ProduccionListaCorreo->find("first", array(
			"conditions"=>array("ProduccionListaCorreo.id"=>$idLista), 
			"recursive"=>0
		));

		$contactos = json_decode($listaSeleccionada["ProduccionListaCorreo"]["produccion_contactos_id"],true);

		if(is_array($contactos)){
			if(!in_array($idContacto, $contactos)){
				array_push($contactos,$idContacto);
			}
		}
		else{
			$contactos = array();
			array_push($contactos,$idContacto);
		}
		

		$lista["id"] = $idLista;
		$lista["produccion_contactos_id"] = json_encode($contactos);

		if ($this->ProduccionListaCorreo->save($lista)) {

			$respuesta = array("estado"=>1,
				"mensaje"=> "El contacto se registro correctamente.");
		} else {
			$respuesta = array("estado"=>0,
				"mensaje"=> "No se pudo registrar la información. Intente más tarde.");
		}

	
		$this->set("respuesta", $respuesta);
	}

	public function delete_contacto_lista($idLista, $idContacto){
			
		$this->layout = "ajax";
		if(empty($idLista))
		{
			$this->Session->setFlash('Seleccione una Lista', 'msg_fallo');
			return $this -> redirect(array("action" => 'index'));
		}

		$listaSeleccionada = $this->ProduccionListaCorreo->find("first", array(
			"conditions"=>array("ProduccionListaCorreo.id"=>$idLista), 
			"recursive"=>0
		));

		$contactos = json_decode($listaSeleccionada["ProduccionListaCorreo"]["produccion_contactos_id"],true);

		$pos = (array_search($idContacto, $contactos));		
		if($pos>-1) unset($contactos[$pos]);

		$lista["id"] = $idLista;
		$lista["produccion_contactos_id"] = json_encode($contactos);

		if ($this->ProduccionListaCorreo->save($lista)) {

			$respuesta = array("estado"=>1,
				"mensaje"=> "Se elimino la relación correctamente.");
		} else {
			$respuesta = array("estado"=>0,
				"mensaje"=> "No se pudo registrar la información. Intente más tarde.");
		}

		$this->set("respuesta", $respuesta);
	}

}

