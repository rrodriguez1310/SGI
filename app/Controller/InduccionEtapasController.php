<?php
App::uses('AppController', 'Controller');
/**
 * InduccionEtapas Controller
 *
 * @property InduccionEtapa $InduccionEtapa
 * @property PaginatorComponent $Paginator
 */
class InduccionEtapasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function index_json() {
		$this->layout = null;
		$this->response->type('json');
		$salida = $this->InduccionEtapa->find('all',array('order' => 'InduccionEtapa.peso ASC'));
		$salidaJson ="";

	
		foreach($salida as $value){
			$salidaJson[] = array(
				'id'=>$value['InduccionEtapa']['id'],
				'titulo'=>ucwords($value['InduccionEtapa']['titulo']),
				'porcentMin'=>$value['InduccionEtapa']['porcentaje_minimo'],
				'image'=>$value['InduccionEtapa']['image'],
				'imagedir'=>$value['InduccionEtapa']['imagedir'],
				'estado'=>$value['Estado']['nombre'],
				'peso'=>$value['InduccionEtapa']['peso']
			);
		}
		
		echo json_encode($salidaJson);
		exit;
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->acceso();
		CakeLog::write('actividad', 'induccionEtapa - index ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$this->layout = "angular";
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->acceso();

		if (!$this->InduccionEtapa->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido', 'msg_fallo'));
		}
		CakeLog::write('actividad', 'induccionEtapa - view ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$options = array('conditions' => array('InduccionEtapa.' . $this->InduccionEtapa->primaryKey => $id));
		$this->set('induccionEtapa', $this->InduccionEtapa->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->acceso();

		if ($this->request->is('post')) {
			$this->InduccionEtapa->create();
			if ($this->InduccionEtapa->save($this->request->data)) {
				CakeLog::write('actividad', 'induccionEtapa - add ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Lección registrada correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al registrar la lección', 'msg_fallo');
			}
		}
		$estados = $this->InduccionEtapa->Estado->find('list');
		$this->set(compact('estados'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {

		$this->acceso();

		if (!$this->InduccionEtapa->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido', 'msg_fallo'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->InduccionEtapa->save($this->request->data)) {
				CakeLog::write('actividad', 'induccionEtapa - index ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Lección actualizada correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al actualizar la lección', 'msg_fallo');
			}
		} else {
			$options = array('conditions' => array('InduccionEtapa.' . $this->InduccionEtapa->primaryKey => $id));
			$this->request->data = $this->InduccionEtapa->find('first', $options);
		}
		$estados = $this->InduccionEtapa->Estado->find('list');
		$this->set(compact('estados'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {

		$this->acceso();
		
		$estado = $this->InduccionEtapa->find('all', array(
			'conditions'=>array('InduccionEtapa.id' => $id),
			'recursive'=>-1
		));

		$status = array(
			'id' => $estado[0]['InduccionEtapa']['id'],
			'induccion_estado_id'=>2
		);
		

		$this->InduccionEtapa->id = $id;
		if (!$this->InduccionEtapa->exists()) {

			throw new NotFoundException($this->Session->setFlash('Registro invalido', 'msg_fallo'));
		}

		if($estado[0]['InduccionEtapa']['induccion_estado_id'] == 1){

			if($this->InduccionEtapa->save($status)){
				CakeLog::write('actividad', 'induccionEtapa - delete ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Lección eliminada correctamente','msg_exito');
			}else{
				$this->Session->setFlash('Ocuerrio un error al eliminar la lección.','msg_fallo');
			}
		}else{
			$this->Session->setFlash('No puede realizar esta operación, la lección fue eliminada anteriormente.','msg_fallo');	
		}

		return $this->redirect(array('action' => 'index'));
	}
	
}
