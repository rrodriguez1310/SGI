<?php
App::uses('AppController', 'Controller');
/**
 * RecognitionStatuses Controller
 *
 * @property RecognitionStatus $RecognitionStatus
 * @property PaginatorComponent $Paginator
 */
class RecognitionStatusesController extends AppController {

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
		$this->RecognitionStatus->recursive = 0;
		$this->set('recognitionStatuses', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->RecognitionStatus->exists($id)) {
			throw new NotFoundException(__('Invalid recognition status'));
		}
		$options = array('conditions' => array('RecognitionStatus.' . $this->RecognitionStatus->primaryKey => $id));
		$this->set('recognitionStatus', $this->RecognitionStatus->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->RecognitionStatus->create();
			if ($this->RecognitionStatus->save($this->request->data)) {
				$this->Session->setFlash(__('The recognition status has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The recognition status could not be saved. Please, try again.'));
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
		if (!$this->RecognitionStatus->exists($id)) {
			throw new NotFoundException(__('Invalid recognition status'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RecognitionStatus->save($this->request->data)) {
				$this->Session->setFlash(__('The recognition status has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The recognition status could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RecognitionStatus.' . $this->RecognitionStatus->primaryKey => $id));
			$this->request->data = $this->RecognitionStatus->find('first', $options);
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
		$this->RecognitionStatus->id = $id;
		if (!$this->RecognitionStatus->exists()) {
			throw new NotFoundException(__('Invalid recognition status'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->RecognitionStatus->delete()) {
			$this->Session->setFlash(__('The recognition status has been deleted.'));
		} else {
			$this->Session->setFlash(__('The recognition status could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
