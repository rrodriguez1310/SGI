<?php
App::uses('AppController', 'Controller');
/**
 * ClasificacionComentarios Controller
 *
 * @property ClasificacionComentario $ClasificacionComentario
 * @property PaginatorComponent $Paginator
 */
class ClasificacionComentariosController extends AppController {

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
		$this->ClasificacionComentario->recursive = 0;
		$this->set('clasificacionComentarios', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ClasificacionComentario->exists($id)) {
			throw new NotFoundException(__('Invalid clasificacion comentario'));
		}
		$options = array('conditions' => array('ClasificacionComentario.' . $this->ClasificacionComentario->primaryKey => $id));
		$this->set('clasificacionComentario', $this->ClasificacionComentario->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ClasificacionComentario->create();
			if ($this->ClasificacionComentario->save($this->request->data)) {
				$this->Session->setFlash(__('The clasificacion comentario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The clasificacion comentario could not be saved. Please, try again.'));
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
		if (!$this->ClasificacionComentario->exists($id)) {
			throw new NotFoundException(__('Invalid clasificacion comentario'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ClasificacionComentario->save($this->request->data)) {
				$this->Session->setFlash(__('The clasificacion comentario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The clasificacion comentario could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ClasificacionComentario.' . $this->ClasificacionComentario->primaryKey => $id));
			$this->request->data = $this->ClasificacionComentario->find('first', $options);
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
		$this->ClasificacionComentario->id = $id;
		if (!$this->ClasificacionComentario->exists()) {
			throw new NotFoundException(__('Invalid clasificacion comentario'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ClasificacionComentario->delete()) {
			$this->Session->setFlash(__('The clasificacion comentario has been deleted.'));
		} else {
			$this->Session->setFlash(__('The clasificacion comentario could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
