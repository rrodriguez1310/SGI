<?php
App::uses('AppController', 'Controller');
/**
 * InduccionContenidos Controller
 *
 * @property InduccionContenido $InduccionContenido
 * @property PaginatorComponent $Paginator
 */
class InduccionContenidosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	//public $helpers = array('Wysiwyg.Wysiwyg' => array('editor' => 'Ck'));

	public function etapas(){
		$this->autoRender = false;
		$this->loadModel("InduccionEtapa");

		$etapas = $this->InduccionEtapa->find('all',array("conditions"=> array("InduccionEtapa.induccion_estado_id = 1" )));
		pr($etapas);
		exit;
	}


/**
 * 	servicio imagen
 *	@author Mpalencia <email@email.com>
 * 	@return void
 */
	public function image_json() {


		$this->autoRender=false;
		$this->loadModel('InduccionDetalle');
		$this->response->type('json');
		$salida = $this->InduccionDetalle->find('all',array('conditions' => array('InduccionDetalle.estado_id' => 1)
		));
		$salidaJson ="";


		foreach($salida as $value){
			$salidaJson[] = array(
				'id'=> $value['InduccionDetalle']['id'],
				'name'=> $value['InduccionDetalle']['image'],
				'tag'=> 'CDF',
				'thumb'=>'http://localhost/sgi-v3/app/webroot/files/induccion_detalle/image/'.$value['InduccionDetalle']['imagedir'].'/vga_'.$value['InduccionDetalle']['image'],
				'type'=> 'image',
				'url'=> 'http://localhost/sgi-v3/app/webroot/files/induccion_detalle/image/'.$value['InduccionDetalle']['imagedir'].'/'.$value['InduccionDetalle']['image']	
			);
		}
		
		echo json_encode($salidaJson);
		exit;
	}


/**
 * servicio index
 *@author Mpalencia <email@email.com>
 * @return void
 */
	public function index_json() {
		$this->layout = null;
		$this->response->type('json');
		$salida = $this->InduccionContenido->find('all',array('order' => 'InduccionContenido.peso ASC'));
		$salidaJson ="";

		foreach($salida as $value){
			$salidaJson[] = array(
				'id'=>$value['InduccionContenido']['id'],
				'titulo'=>ucwords($value['InduccionContenido']['titulo']),
				'leccion'=>$value['InduccionEtapa']['titulo'],
				'peso'=>$value['InduccionContenido']['peso'],
				'image'=>$value['InduccionContenido']['image'],
				'imagedir'=>$value['InduccionContenido']['imagedir'],
				'estado'=>$value['InduccionEstado']['nombre']
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
		/*CakeLog::write('actividad', 'induccionContenido - index ' .$this->Session->Read("PerfilUsuario.idUsuario"));*/
		$this->layout = "angular";
		$this->acceso();
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
		if (!$this->InduccionContenido->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido', 'msg_fallo'));
		}
		CakeLog::write('actividad', 'induccionContenido - view ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$options = array('conditions' => array('InduccionContenido.' . $this->InduccionContenido->primaryKey => $id));
		$this->set('induccionContenido', $this->InduccionContenido->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		$this->acceso();
		if ($this->request->is('post')) {

			$this->request->data['InduccionContenido']['descripcion'] = serialize($this->request->data['descripcion']);
			$this->InduccionContenido->create();
			if ($this->InduccionContenido->save($this->request->data)) {
				CakeLog::write('actividad', 'induccionContenido - add ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Contenido registrado correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al registrar el contenido', 'msg_fallo'); 
			}
		}
		$etapas = $this->InduccionContenido->InduccionEtapa->find('list',array("conditions"=> array("InduccionEtapa.induccion_estado_id = 1" )));
		$estados = $this->InduccionContenido->InduccionEstado->find('list');
		$this->set(compact('etapas', 'estados'));
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

		$content = $this->InduccionContenido->findById($id);
		
		$contenido = $this->InduccionContenido->find('all',array(
			'fields'=>array('InduccionContenido.descripcion'),
			'conditions'=> array('InduccionContenido.id' => $id)
		));
		
		$contenido = unserialize($contenido[0]['InduccionContenido']['descripcion']);
		$this->set(compact('contenido', $contenido));
		

		if (!$this->InduccionContenido->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('registro invalido', 'msg_fallo'));
		}

		if ($this->request->is(array('post', 'put'))) {

			$this->request->data['InduccionContenido']['descripcion'] = serialize($this->request->data['descripcion']);
			
			if ($this->InduccionContenido->save($this->request->data)) {
				CakeLog::write('actividad', 'induccionContenido - edit ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Contenido actualizado correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al actualizar el contenido', 'msg_exito');
			}
		} else {
			$options = array('conditions' => array('InduccionContenido.' . $this->InduccionContenido->primaryKey => $id));
			$this->request->data = $this->InduccionContenido->find('first', $options);

		}
		$etapas = $this->InduccionContenido->InduccionEtapa->find('list',array("conditions"=> array("InduccionEtapa.induccion_estado_id = 1" )));
		$estados = $this->InduccionContenido->InduccionEstado->find('list');
		$this->set(compact('etapas', 'estados'));
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
		$estado = $this->InduccionContenido->find('all', array(
			'conditions'=>array('InduccionContenido.id' => $id),
			'recursive'=>-1
		));

		$status = array(
			'id' => $estado[0]['InduccionContenido']['id'],
			'induccion_estado_id'=>2
		);
		
		$this->InduccionContenido->id = $id;
		if (!$this->InduccionContenido->exists()) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido.','msg_fallo'));
		}

		if($estado[0]['InduccionContenido']['induccion_estado_id'] == 1){

			if($this->InduccionContenido->save($status)){
				CakeLog::write('actividad', 'InduccionContenido - delete ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Contenido eliminado correctamente','msg_exito');
			}else{
				$this->Session->setFlash('Ocuerrio un error al eliminar el contenido.','msg_fallo');
			}
		}else{

			$this->Session->setFlash('No puede realizar esta operación, el contenido fue eliminada anteriormente.','msg_fallo');	
		}

		return $this->redirect(array('action' => 'index'));
	}
}
