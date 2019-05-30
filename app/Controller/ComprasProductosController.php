<?php
App::uses('AppController', 'Controller');
/**
 * ComprasProductos Controller
 *
 * @property ComprasProducto $ComprasProducto
 * @property PaginatorComponent $Paginator
 */
class ComprasProductosController extends AppController {

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
		$this->ComprasProducto->recursive = 0;
		$this->set('comprasProductos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ComprasProducto->exists($id)) {
			throw new NotFoundException(__('Invalid compras producto'));
		}
		$options = array('conditions' => array('ComprasProducto.' . $this->ComprasProducto->primaryKey => $id));
		$this->set('comprasProducto', $this->ComprasProducto->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ComprasProducto->create();
			if ($this->ComprasProducto->save($this->request->data)) {
				$this->Session->setFlash(__('The compras producto has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The compras producto could not be saved. Please, try again.'));
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
		if (!$this->ComprasProducto->exists($id)) {
			throw new NotFoundException(__('Invalid compras producto'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ComprasProducto->save($this->request->data)) {
				$this->Session->setFlash(__('The compras producto has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The compras producto could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ComprasProducto.' . $this->ComprasProducto->primaryKey => $id));
			$this->request->data = $this->ComprasProducto->find('first', $options);
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
		$this->ComprasProducto->id = $id;
		if (!$this->ComprasProducto->exists()) {
			throw new NotFoundException(__('Invalid compras producto'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ComprasProducto->delete()) {
			$this->Session->setFlash(__('The compras producto has been deleted.'));
		} else {
			$this->Session->setFlash(__('The compras producto could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
