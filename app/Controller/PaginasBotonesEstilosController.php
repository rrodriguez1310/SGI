<?php
App::uses('AppController', 'Controller');
/**
 * PaginasBotonesEstilos Controller
 *
 * @property PaginasBotonesEstilo $PaginasBotonesEstilo
 * @property PaginatorComponent $Paginator
 */
class PaginasBotonesEstilosController extends AppController {

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
		$this->PaginasBotonesEstilo->recursive = 0;
		$this->set('paginasBotonesEstilos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PaginasBotonesEstilo->exists($id)) {
			throw new NotFoundException(__('Invalid paginas botones estilo'));
		}
		$options = array('conditions' => array('PaginasBotonesEstilo.' . $this->PaginasBotonesEstilo->primaryKey => $id));
		$this->set('paginasBotonesEstilo', $this->PaginasBotonesEstilo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PaginasBotonesEstilo->create();
			if ($this->PaginasBotonesEstilo->save($this->request->data)) {
				$this->Session->setFlash(__('The paginas botones estilo has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The paginas botones estilo could not be saved. Please, try again.'));
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
		if (!$this->PaginasBotonesEstilo->exists($id)) {
			throw new NotFoundException(__('Invalid paginas botones estilo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PaginasBotonesEstilo->save($this->request->data)) {
				$this->Session->setFlash(__('The paginas botones estilo has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The paginas botones estilo could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PaginasBotonesEstilo.' . $this->PaginasBotonesEstilo->primaryKey => $id));
			$this->request->data = $this->PaginasBotonesEstilo->find('first', $options);
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
		$this->PaginasBotonesEstilo->id = $id;
		if (!$this->PaginasBotonesEstilo->exists()) {
			throw new NotFoundException(__('Invalid paginas botones estilo'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->PaginasBotonesEstilo->delete()) {
			$this->Session->setFlash(__('The paginas botones estilo has been deleted.'));
		} else {
			$this->Session->setFlash(__('The paginas botones estilo could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
