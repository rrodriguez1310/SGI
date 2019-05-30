<?php
App::uses('AppController', 'Controller');
/**
 * TransmisionCanales Controller
 *
 * @property TransmisionCanale  
 * @property PaginatorComponent $Paginator
 */
class TransmisionCanalesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


	public function add() {

		$this->acceso();

		if ($this->request->is('post')) {
			$this->TransmisionCanale->create();

			$this->request->data["TransmisionCanale"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
			if ($this->TransmisionCanale->save($this->request->data)){
				$this->Session->setFlash('Se registro la información correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			}else{
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
			}
		}
	}

	public function edit($id = null) {

		$this->acceso();

		if (!$this->TransmisionCanale->exists($id)) {
			throw new NotFoundException(__('Invalid transmision señal'));
		}
		
		if ($this->request->is(array('post', 'put'))) {

			$this->request->data["TransmisionCanale"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');

			if ($this->TransmisionCanale->save($this->request->data)) {
				$this->Session->setFlash('Se registro la información correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion.','msg_fallo');
			}

		} else {
			$options = array('conditions' => array('TransmisionCanale.' . $this->TransmisionCanale->primaryKey => $id));
			$this->request->data = $this->TransmisionCanale->find('first', $options);
		}
	}


	public function index() {
		$this->layout = "angular";
		$this->acceso();
	} 


	public function canales_list(){

		$this->autoRender = false;
		//$this->response->type("json");
		$canales = $this->TransmisionCanale->find("all", array(
			"conditions"=>array(
				"TransmisionCanale.estado"=>1
				),
			"fields"=>array(
				"TransmisionCanale.id",
				"TransmisionCanale.nombre"),
			"order"=>"TransmisionCanale.id ASC",
			"recursive"=>0
			)
		);
		
		if(!empty($canales))
		{
 			foreach ($canales as $canal)
 			{
 				$respuesta[] = array(
 					"id"=>$canal["TransmisionCanale"]["id"],
 					"nombre"=>$canal["TransmisionCanale"]["nombre"]
 					);
 			}
		}else
		{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}

	public function delete($id = null) {
		$this->layout = "ajax";
		$this->TransmisionCanale->id = $id;
		if (!$this->TransmisionCanale->exists()) {
			throw new NotFoundException(__('Invalid descripción'));
		}
		$this->request->data["id"] = $this->TransmisionCanale->id;
		$this->request->data["estado"] = 0;		
		$this->request->data["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');

		if ($this->TransmisionCanale->save($this->request->data)) {			
			$this->Session->setFlash('El registro fue eliminado correctamente.', 'msg_exito');
		} else {
			$this->Session->setFlash('El registro no pudo ser eliminado. Por favor, intente nuevamente.', 'msg_fallo');
		}
		return $this->redirect(array('action' => 'index'));
	}

}