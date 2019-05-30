<?php
App::uses('AppController', 'Controller');
/**
 * ComprasProductosTotales Controller
 *
 * @property ComprasProductosTotale $ComprasProductosTotale
 * @property PaginatorComponent $Paginator
 */
class ComprasProductosTotalesController extends AppController {

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
		$this->ComprasProductosTotale->recursive = 0;
		$this->set('comprasProductosTotales', $this->Paginator->paginate());	
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ComprasProductosTotale->exists($id)) {
			throw new NotFoundException(__('Invalid compras productos totale'));
		}
		$options = array('conditions' => array('ComprasProductosTotale.' . $this->ComprasProductosTotale->primaryKey => $id));
		$this->set('comprasProductosTotale', $this->ComprasProductosTotale->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ComprasProductosTotale->create();
			if ($this->ComprasProductosTotale->save($this->request->data)) {
				$this->Session->setFlash(__('The compras productos totale has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The compras productos totale could not be saved. Please, try again.'));
			}
		}
		$companies = $this->ComprasProductosTotale->Company->find('list');
		$tiposMonedas = $this->ComprasProductosTotale->TiposMoneda->find('list');
		$users = $this->ComprasProductosTotale->User->find('list');
		$plazosPagos = $this->ComprasProductosTotale->PlazosPago->find('list');
		$this->set(compact('companies', 'tiposMonedas', 'users', 'plazosPagos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ComprasProductosTotale->exists($id)) {
			throw new NotFoundException(__('Invalid compras productos totale'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ComprasProductosTotale->save($this->request->data)) {
				$this->Session->setFlash(__('The compras productos totale has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The compras productos totale could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ComprasProductosTotale.' . $this->ComprasProductosTotale->primaryKey => $id));
			$this->request->data = $this->ComprasProductosTotale->find('first', $options);
		}
		$companies = $this->ComprasProductosTotale->Company->find('list');
		$tiposMonedas = $this->ComprasProductosTotale->TiposMoneda->find('list');
		$users = $this->ComprasProductosTotale->User->find('list');
		$plazosPagos = $this->ComprasProductosTotale->PlazosPago->find('list');
		$this->set(compact('companies', 'tiposMonedas', 'users', 'plazosPagos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ComprasProductosTotale->id = $id;
		if (!$this->ComprasProductosTotale->exists()) {
			throw new NotFoundException(__('Invalid compras productos totale'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ComprasProductosTotale->delete()) {
			$this->Session->setFlash(__('The compras productos totale has been deleted.'));
		} else {
			$this->Session->setFlash(__('The compras productos totale could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
