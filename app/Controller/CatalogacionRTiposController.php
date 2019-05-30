<?php
App::uses('AppController', 'Controller');
/**
 * CatalogacionRTipos Controller
 *
 * @property CatalogacionRTipo $CatalogacionTipo
 * @property PaginatorComponent $Paginator
 */
class CatalogacionRTiposController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


	public function add() {

		$this->acceso();

		if ($this->request->is('post')) {
			$this->CatalogacionRTipo->create();

			$this->request->data["CatalogacionRTipo"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');			

			if ($this->CatalogacionRTipo->save($this->request->data)) 
			{
				$this->Session->setFlash('Se registro la información correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} 
			else
			{
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
			}
		}
	}

	public function edit($id = null) {

		$this->acceso();

		if (!$this->CatalogacionRTipo->exists($id)) {
			throw new NotFoundException(__('Invalid tipo requerimiento'));
		}
		if ($this->request->is(array('post', 'put'))) {

			$this->request->data["CatalogacionRTipo"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');			

			if ($this->CatalogacionRTipo->save($this->request->data)) {
				$this->Session->setFlash('Se registro la información correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion.','msg_fallo');
			}

		} else {
			$options = array('conditions' => array('CatalogacionRTipo.' . $this->CatalogacionRTipo->primaryKey => $id));
			$this->request->data = $this->CatalogacionRTipo->find('first', $options);
		}
	}


	public function index() {
		$this->layout = "angular";
		$this->acceso();
	}


	public function requerimientos_tipos_list(){

		$this->autoRender = false;
		//$this->response->type("json");
		$tipos = $this->CatalogacionRTipo->find("all", array(
			"conditions"=>array(
				"CatalogacionRTipo.estado"=>1
				),
			"order"=>"CatalogacionRTipo.nombre ASC",
			"recursive"=>-1
			)
		);
		if(!empty($tipos))
		{
 			foreach ($tipos as $tipo) 
 			{
 				$respuesta[] = array(
 					"id"=>$tipo["CatalogacionRTipo"]["id"],
 					"nombre"=>$tipo["CatalogacionRTipo"]["nombre"],
 					"tipo"=>$tipo["CatalogacionRTipo"]["tipo"]
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
		$this->CatalogacionRTipo->id = $id;
		if (!$this->CatalogacionRTipo->exists()) {
			throw new NotFoundException(__('Invalid produccion responsable'));
		}
		$this->request->data["id"] = $this->CatalogacionRTipo->id;
		$this->request->data["estado"] = 0;		
		$this->request->data["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');

		if ($this->CatalogacionRTipo->save($this->request->data)) {			
			$this->Session->setFlash('El registro fue eliminado correctamente.', 'msg_exito');
		} else {
			$this->Session->setFlash('El registro no pudo ser eliminado. Por favor, intente nuevamente.', 'msg_fallo');
		}
		return $this->redirect(array('action' => 'index'));
	}

}
