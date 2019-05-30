<?php
App::uses('AppController', 'Controller');
/**
 * SistemasResponsablesIncidencias Controller
 *
 * @property SistemasResponsablesIncidencia $SistemasResponsablesIncidencia
 * @property PaginatorComponent $Paginator
 */
class SistemasResponsablesIncidenciasController extends AppController {

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
		$this->SistemasResponsablesIncidencia->recursive = 0;
		$this->set('sistemasResponsablesIncidencias', $this->Paginator->paginate());
	}
	public function sistemas_responsables_list(){
		$this->autoRender = false;
		$this->response->type("json");
		$responsables = $this->SistemasResponsablesIncidencia->find("all", array(
			"conditions"=>array(
				"SistemasResponsablesIncidencia.estado"=>1
			),
			"recursive"=>1
		));
		
		
		if(!empty($responsables)){
			foreach ($responsables as $responsable) {
				$respuesta[] = array(
					"id"=>$responsable["SistemasResponsablesIncidencia"]["id"],
					"user_id"=>$responsable["SistemasResponsablesIncidencia"]["user_id"],
					"tipo"=>$responsable["SistemasResponsablesIncidencia"]["tipo"],
					"admin"=>$responsable["SistemasResponsablesIncidencia"]["admin"],
                    "gerencia"=>$responsable["Gerencia"]["id"],
					 "gerenciaNombre"=>$responsable["Gerencia"]["nombre"]

				);
			}
		}else{
			$respuesta = array();
		}
		//pr($responsables);exit;
		return json_encode($respuesta);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SistemasResponsablesIncidencia->exists($id)) {
			throw new NotFoundException(__('Invalid sistemas responsables incidencia'));
		}
		$options = array('conditions' => array('SistemasResponsablesIncidencia.' . $this->SistemasResponsablesIncidencia->primaryKey => $id));
		$this->set('sistemasResponsablesIncidencia', $this->SistemasResponsablesIncidencia->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SistemasResponsablesIncidencia->create();
			if ($this->SistemasResponsablesIncidencia->save($this->request->data)) {
				$this->Session->setFlash(__('The sistemas responsables incidencia has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sistemas responsables incidencia could not be saved. Please, try again.'));
			}
		}
		$users = $this->SistemasResponsablesIncidencia->User->find('list');
		$gerencias = $this->SistemasResponsablesIncidencia->Gerencium->find('list');
		$this->set(compact('users', 'gerencias'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SistemasResponsablesIncidencia->exists($id)) {
			throw new NotFoundException(__('Invalid sistemas responsables incidencia'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SistemasResponsablesIncidencia->save($this->request->data)) {
				$this->Session->setFlash(__('The sistemas responsables incidencia has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sistemas responsables incidencia could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SistemasResponsablesIncidencia.' . $this->SistemasResponsablesIncidencia->primaryKey => $id));
			$this->request->data = $this->SistemasResponsablesIncidencia->find('first', $options);
		}
		$users = $this->SistemasResponsablesIncidencia->User->find('list');
		$gerencias = $this->SistemasResponsablesIncidencia->Gerencium->find('list');
		$this->set(compact('users', 'gerencias'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SistemasResponsablesIncidencia->id = $id;
		if (!$this->SistemasResponsablesIncidencia->exists()) {
			throw new NotFoundException(__('Invalid sistemas responsables incidencia'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->SistemasResponsablesIncidencia->delete()) {
			$this->Session->setFlash(__('The sistemas responsables incidencia has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sistemas responsables incidencia could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
