<?php
App::uses('AppController', 'Controller');
/**
 * CargosNivelResponsabilidades Controller
 *
 * @property CargosNivelResponsabilidade $CargosNivelResponsabilidade
 * @property PaginatorComponent $Paginator
 */
class CargosNivelResponsabilidadesController extends AppController {

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
		$this->CargosNivelResponsabilidade->recursive = 0;
		$this->set('cargosNivelResponsabilidades', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CargosNivelResponsabilidade->exists($id)) {
			throw new NotFoundException(__('Invalid cargos nivel responsabilidade'));
		}
		$options = array('conditions' => array('CargosNivelResponsabilidade.' . $this->CargosNivelResponsabilidade->primaryKey => $id));
		$this->set('cargosNivelResponsabilidade', $this->CargosNivelResponsabilidade->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CargosNivelResponsabilidade->create();
			if ($this->CargosNivelResponsabilidade->save($this->request->data)) {
				$this->Session->setFlash(__('The cargos nivel responsabilidade has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cargos nivel responsabilidade could not be saved. Please, try again.'));
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
		if (!$this->CargosNivelResponsabilidade->exists($id)) {
			throw new NotFoundException(__('Invalid cargos nivel responsabilidade'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CargosNivelResponsabilidade->save($this->request->data)) {
				$this->Session->setFlash(__('The cargos nivel responsabilidade has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cargos nivel responsabilidade could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CargosNivelResponsabilidade.' . $this->CargosNivelResponsabilidade->primaryKey => $id));
			$this->request->data = $this->CargosNivelResponsabilidade->find('first', $options);
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
		$this->CargosNivelResponsabilidade->id = $id;
		if (!$this->CargosNivelResponsabilidade->exists()) {
			throw new NotFoundException(__('Invalid cargos nivel responsabilidade'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CargosNivelResponsabilidade->delete()) {
			$this->Session->setFlash(__('The cargos nivel responsabilidade has been deleted.'));
		} else {
			$this->Session->setFlash(__('The cargos nivel responsabilidade could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function cargos_nivel_responsabilidades_list(){

		$this->autoRender = false;
		$this->response->type("json");
		$cargosNivelResponsabilidades = $this->CargosNivelResponsabilidade->find("all", array("conditions"=>array("CargosNivelResponsabilidade.estado"=>1),"fields"=>array("CargosNivelResponsabilidade.id", "CargosNivelResponsabilidade.nivel"), "order"=>"CargosNivelResponsabilidade.nivel"));
		if(!empty($cargosNivelResponsabilidades)){
			$respuestaArray = array();
			foreach ($cargosNivelResponsabilidades as $cargosNivelResponsabilidade) {
				array_push($respuestaArray, array(
					"id"=>$cargosNivelResponsabilidade["CargosNivelResponsabilidade"]["id"],
					"nivel"=>$cargosNivelResponsabilidade["CargosNivelResponsabilidade"]["nivel"],
					)
				);
			}
			$respuesta = array(
				"estado"=>1,
				"data"=>$respuestaArray
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"data"=>"Sin datos"
				);
		}
		return json_encode($respuesta);
	}
}
