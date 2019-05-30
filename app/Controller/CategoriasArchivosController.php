<?php
App::uses('AppController', 'Controller');
/**
 * CategoriasArchivos Controller
 *
 * @property CategoriasArchivo $CategoriasArchivo
 * @property PaginatorComponent $Paginator
 */
class CategoriasArchivosController extends AppController {

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
		$this->CategoriasArchivo->recursive = 0;
		$this->set('categoriasArchivos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CategoriasArchivo->exists($id)) {
			throw new NotFoundException(__('Invalid categorias archivo'));
		}
		$options = array('conditions' => array('CategoriasArchivo.' . $this->CategoriasArchivo->primaryKey => $id));
		$this->set('categoriasArchivo', $this->CategoriasArchivo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CategoriasArchivo->create();
			if ($this->CategoriasArchivo->save($this->request->data)) {
				$this->Session->setFlash(__('The categorias archivo has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The categorias archivo could not be saved. Please, try again.'));
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
		if (!$this->CategoriasArchivo->exists($id)) {
			throw new NotFoundException(__('Invalid categorias archivo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CategoriasArchivo->save($this->request->data)) {
				$this->Session->setFlash(__('The categorias archivo has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The categorias archivo could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CategoriasArchivo.' . $this->CategoriasArchivo->primaryKey => $id));
			$this->request->data = $this->CategoriasArchivo->find('first', $options);
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
		$this->CategoriasArchivo->id = $id;
		if (!$this->CategoriasArchivo->exists()) {
			throw new NotFoundException(__('Invalid categorias archivo'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CategoriasArchivo->delete()) {
			$this->Session->setFlash(__('The categorias archivo has been deleted.'));
		} else {
			$this->Session->setFlash(__('The categorias archivo could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
