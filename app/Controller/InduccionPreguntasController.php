<?php
App::uses('AppController', 'Controller');
/**
 * InduccionPreguntas Controller
 *
 * @property InduccionPregunta $InduccionPregunta
 * @property PaginatorComponent $Paginator
 */
class InduccionPreguntasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function index_json() {
		$this->layout = null;
		$this->response->type('json');
		$salida = $this->InduccionPregunta->find('all',array('order' => 'InduccionPregunta.induccion_estado_id ASC'));
		$salidaJson ="";
		//pr($salida); exit;

		foreach($salida as $value){
			$salidaJson[] = array(
				'id'=>$value['InduccionPregunta']['id'],
				'leccion'=>ucwords($value['Etapa']['titulo']),
				'pregunta'=>ucwords($value['InduccionPregunta']['pregunta']),
				'valor'=>ucwords($value['InduccionPregunta']['valor']),
				'estado'=>$value['Estado']['nombre']
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
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'induccionPreguntas - index - miro el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));

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
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */
		if (!$this->InduccionPregunta->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido.','msg_fallo'));
		}
		CakeLog::write('actividad', 'induccionPreguntas - view - ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$options = array('conditions' => array('InduccionPregunta.' . $this->InduccionPregunta->primaryKey => $id));
		$this->set('induccionPregunta', $this->InduccionPregunta->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */
		if ($this->request->is('post')) {
			$this->InduccionPregunta->create();
			if ($this->InduccionPregunta->save($this->request->data)) {
				CakeLog::write('actividad', 'induccionPreguntas - index  ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash($this->Session->setFlash('Pregunta registrada correctamente.','msg_exito'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash($this->Session->setFlash('Ocurrio un error al registrar la pregunta.','msg_fallo'));
			}
		}
		$etapas = $this->InduccionPregunta->Etapa->find('list',array("conditions"=> array("Etapa.induccion_estado_id = 1" )));
		$estados = $this->InduccionPregunta->Estado->find('list');
		$this->set(compact('estados', 'etapas'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */
		if (!$this->InduccionPregunta->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido.','msg_fallo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->InduccionPregunta->save($this->request->data)) {
				CakeLog::write('actividad', 'induccionPreguntas - index  ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash($this->Session->setFlash('Pregunta actualizada correctamente.','msg_exito'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash($this->Session->setFlash('Ocurrio un error al actualizar la pregunta.','msg_fallo'));
			}
		} else {
			$options = array('conditions' => array('InduccionPregunta.' . $this->InduccionPregunta->primaryKey => $id));
			$this->request->data = $this->InduccionPregunta->find('first', $options);
		}
		$etapas = $this->InduccionPregunta->Etapa->find('list',array("conditions"=> array("Etapa.induccion_estado_id = 1" )));
		$estados = $this->InduccionPregunta->Estado->find('list');
		/*pr($etapas);
		exit;*/
		$this->set(compact('estados', 'etapas'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */
		
		$estado = $this->InduccionPregunta->find('all', array(
			'conditions'=>array('InduccionPregunta.id' => $id),
			'recursive'=>-1
		));

		$status = array(
			'id' => $estado[0]['InduccionPregunta']['id'],
			'induccion_estado_id'=>2
		);
		

		$this->InduccionPregunta->id = $id;
		if (!$this->InduccionPregunta->exists()) {

			throw new NotFoundException($this->Session->setFlash('Registro invalido', 'msg_fallo'));
		}

		if($estado[0]['InduccionPregunta']['induccion_estado_id'] == 1){

			if($this->InduccionPregunta->save($status)){
				CakeLog::write('actividad', 'induccionPregunta - delete ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Pregunta eliminada correctamente','msg_exito');
			}else{
				$this->Session->setFlash('Ocuerrio un error al eliminar la pregunta.','msg_fallo');
			}
		}else{

			$this->Session->setFlash('No puede realizar esta operación, la pregunta fue eliminada anteriormente.','msg_fallo');	
		}

		return $this->redirect(array('action' => 'index'));
	}
}
