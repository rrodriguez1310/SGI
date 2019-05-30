<?php
App::uses('AppController', 'Controller');
/**
 * ComprasTarjetasEstados Controller
 *
 * @property ComprasTarjetasEstado $ComprasTarjetasEstado
 * @property PaginatorComponent $Paginator
 */
class ComprasTarjetasEstadosController extends AppController {

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
		$this->ComprasTarjetasEstado->recursive = 0;
		$this->set('comprasTarjetasEstados', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ComprasTarjetasEstado->exists($id)) {
			throw new NotFoundException(__('Invalid compras tarjetas estado'));
		}
		$options = array('conditions' => array('ComprasTarjetasEstado.' . $this->ComprasTarjetasEstado->primaryKey => $id));
		$this->set('comprasTarjetasEstado', $this->ComprasTarjetasEstado->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ComprasTarjetasEstado->create();
			if ($this->ComprasTarjetasEstado->save($this->request->data)) {
				$this->Session->setFlash(__('The compras tarjetas estado has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The compras tarjetas estado could not be saved. Please, try again.'));
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
		if (!$this->ComprasTarjetasEstado->exists($id)) {
			throw new NotFoundException(__('Invalid compras tarjetas estado'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ComprasTarjetasEstado->save($this->request->data)) {
				$this->Session->setFlash(__('The compras tarjetas estado has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The compras tarjetas estado could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ComprasTarjetasEstado.' . $this->ComprasTarjetasEstado->primaryKey => $id));
			$this->request->data = $this->ComprasTarjetasEstado->find('first', $options);
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
		$this->ComprasTarjetasEstado->id = $id;
		if (!$this->ComprasTarjetasEstado->exists()) {
			throw new NotFoundException(__('Invalid compras tarjetas estado'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ComprasTarjetasEstado->delete()) {
			$this->Session->setFlash(__('The compras tarjetas estado has been deleted.'));
		} else {
			$this->Session->setFlash(__('The compras tarjetas estado could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
