<?php
App::uses('AppController', 'Controller');
/**
 * InduccionDetalles Controller
 *
 * @property InduccionDetalle $InduccionDetalle
 * @property PaginatorComponent $Paginator
 */
class InduccionDetallesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	/**
 * servicio index
 *@author Mpalencia <email@email.com>
 * @return void
 */
public function index_json() {
	$this->layout = null;
	$this->response->type('json');
	$salida = $this->InduccionDetalle->find('all',array('order' => 'InduccionDetalle.estado_id ASC'));
	$salidaJson ="";


	foreach($salida as $value){
		$salidaJson[] = array(
			'id'=>$value['InduccionDetalle']['id'],
			'detalle'=>ucwords($value['InduccionDetalle']['texto']),
			'estado'=>ucwords($value['Estado']['nombre']),
			'image'=>$value['InduccionDetalle']['image'],
			'imagedir'=>$value['InduccionDetalle']['imagedir']
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
		/*valida usuario*/
		/*if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}*/
		$this->acceso();
		/* Fin Valida Usuario */
		CakeLog::write('actividad', 'induccionDetalles - index ' .$this->Session->Read("PerfilUsuario.idUsuario"));
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
		/*valida usuario*/
		/*if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}*/
		$this->acceso();
		/* Fin Valida Usuario */

		if (!$this->InduccionDetalle->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido.','msg_fallo'));
		}
		CakeLog::write('actividad', 'induccionDetalles - view ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$options = array('conditions' => array('InduccionDetalle.' . $this->InduccionDetalle->primaryKey => $id));
		$this->set('induccionDetalle', $this->InduccionDetalle->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		/*valida usuario*/
		/*if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}*/
		$this->acceso();
		/* Fin Valida Usuario */

		if ($this->request->is('post')) {
			$this->InduccionDetalle->create();
			if ($this->InduccionDetalle->save($this->request->data)) {
				CakeLog::write('actividad', 'induccionDetalles - add ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Detalle registrado correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al registrar el detalle.','msg_fallo');
			}
		}
		$estados = $this->InduccionDetalle->Estado->find('list');
		$this->set(compact( 'estados'));
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

		if (!$this->InduccionDetalle->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido.','msg_fallo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->InduccionDetalle->save($this->request->data)) {
				CakeLog::write('actividad', 'induccionDetalles - edit ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Detalle actualizado correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al actualizar el detalle.','msg_fallo');
			}
		} else {
			$options = array('conditions' => array('InduccionDetalle.' . $this->InduccionDetalle->primaryKey => $id));
			$this->request->data = $this->InduccionDetalle->find('first', $options);
		}
		$estados = $this->InduccionDetalle->Estado->find('list');
		$this->set(compact( 'estados'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
public function delete($id = null) {

	$estado = $this->InduccionDetalle->find('all', array(
		'conditions'=>array('InduccionDetalle.id' => $id),
		'recursive'=>-1
	));

	$status = array(
		'id' => $estado[0]['InduccionDetalle']['id'],
		'estado_id'=>2
	);
	
	$this->InduccionDetalle->id = $id;
	if (!$this->InduccionDetalle->exists()) {
		throw new NotFoundException($this->Session->setFlash('Registro invalido.','msg_fallo'));
	}

	if($estado[0]['InduccionDetalle']['estado_id'] == 1){

		if($this->InduccionDetalle->save($status)){
			CakeLog::write('actividad', 'InduccionDetalle - delete ' .$this->Session->Read("PerfilUsuario.idUsuario"));
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
