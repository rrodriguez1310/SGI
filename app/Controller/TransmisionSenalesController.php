<?php
App::uses('AppController', 'Controller');
/**
 * TransmisionSenales Controller
 *
 * @property TransmisionSenale  
 * @property PaginatorComponent $Paginator
 */
class TransmisionSenalesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


	public function add() {

		$this->acceso();

		if ($this->request->is('post')) {
			$this->TransmisionSenale->create();

			$this->request->data["TransmisionSenale"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data["TransmisionSenale"]["transmision_medio_transmisione_id"] = $this->request->data["transmision_medio_transmisione_id"];
			/** Array
(
    [transmision_medio_transmisione_id] => 1
    [TransmisionSenale] => Array
        (
            [nombre] => Telefonica
            [tipo] => 1
            [user_id] => 263
            [transmision_medio_transmisione_id] => 1
        )

)**/
		
			if ($this->TransmisionSenale->save($this->request->data)) 
			{
				$this->Session->setFlash('Se registro la información correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} 
			else
			{
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
			}
		}else{
			$medios = $this->medios_transmision_list();
			$this->set('medios',$medios);
		}
		
	}

	public function edit($id = null) {

		$this->acceso();
		$medios = $this->medios_transmision_list();
		$this->set('medios',$medios);

		if (!$this->TransmisionSenale->exists($id)) {
			throw new NotFoundException(__('Invalid transmision señal'));
		}
		
		if ($this->request->is(array('post', 'put'))) {

			$this->request->data["TransmisionSenale"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data["TransmisionSenale"]["transmision_medio_transmisione_id"] = $this->request->data["transmision_medio_transmisione_id"];
			if ($this->TransmisionSenale->save($this->request->data)) {
				$this->Session->setFlash('Se registro la información correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion.','msg_fallo');
			}

		} else {
			$options = array('conditions' => array('TransmisionSenale.' . $this->TransmisionSenale->primaryKey => $id));
			$medios = $this->medios_transmision_list();			
			$this->request->data = $this->TransmisionSenale->find('first', $options);
			$this->request->data["medios"] = $medios;
		}
	}


	public function index() {
		$this->layout = "angular";
		$this->acceso();
	} 


	public function senales_list(){

		$this->autoRender = false;
		//$this->response->type("json");
		$senales = $this->TransmisionSenale->find("all", array(
			"conditions"=>array(
				"TransmisionSenale.estado"=>1,
				"TransmisionMedioTransmisione.estado"=>1,
				),
			"fields"=>array(
				"TransmisionSenale.id",
				"TransmisionSenale.nombre",
				"TransmisionSenale.transmision_medio_transmisione_id",
				"TransmisionMedioTransmisione.id",
				"TransmisionMedioTransmisione.nombre"),
			"order"=>"TransmisionSenale.id ASC",
			"recursive"=>0
			)
		);
		
		if(!empty($senales))
		{
 			foreach ($senales as $senal)
 			{
 				$respuesta[] = array(
 					"id"=>$senal["TransmisionSenale"]["id"],
 					"nombre"=>$senal["TransmisionSenale"]["nombre"],
 					"medio_tx"=>$senal["TransmisionMedioTransmisione"]["nombre"],
 					"medio_id"=>$senal["TransmisionMedioTransmisione"]["id"]
 					);
 			}
		}else
		{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}

	public function medios_transmision_list(){
		$this->loadModel("TransmisionMedioTransmisione");

		$medios = $this->TransmisionMedioTransmisione->find('all', array(
			'fields'=>array(
				'TransmisionMedioTransmisione.id',
				'TransmisionMedioTransmisione.nombre')
			));		
		if(!empty($medios))
		{
 			foreach ($medios as $medio)
 			{
 				$respuesta[] = array(
 					"id"=>$medio["TransmisionMedioTransmisione"]["id"],
 					"nombre"=>$medio["TransmisionMedioTransmisione"]["nombre"]
 					);
 			}
		}else
		{
			$respuesta = array();
		}
		return ($respuesta);
	}	

	public function delete($id = null) {
		$this->layout = "ajax";
		$this->TransmisionSenale->id = $id;
		if (!$this->TransmisionSenale->exists()) {
			throw new NotFoundException(__('Invalid descripción'));
		}
		$this->request->data["id"] = $this->TransmisionSenale->id;
		$this->request->data["estado"] = 0;		
		$this->request->data["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');

		if ($this->TransmisionSenale->save($this->request->data)) {			
			$this->Session->setFlash('El registro fue eliminado correctamente.', 'msg_exito');
		} else {
			$this->Session->setFlash('El registro no pudo ser eliminado. Por favor, intente nuevamente.', 'msg_fallo');
		}
		return $this->redirect(array('action' => 'index'));
	}

}