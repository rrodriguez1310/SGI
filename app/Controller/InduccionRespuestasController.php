<?php
App::uses('AppController', 'Controller');
/**
 * InduccionRespuestas Controller
 *
 * @property InduccionRespuesta $InduccionRespuesta
 * @property PaginatorComponent $Paginator
 */
class InduccionRespuestasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function index_json() {
		$this->layout = null;
		$this->response->type('json');
		$salida = $this->InduccionRespuesta->find('all',array(
			"fields"=>array("InduccionRespuesta.*", "Leccion.titulo", "Pregunta.*", "Estado.*"),
            "joins"=> array(
                array("table" => "induccion_etapas", "alias" => "Leccion", "type" => "INNER", "conditions" => array("Leccion.id = Pregunta.induccion_etapa_id "))
			),
			'order' => 'InduccionRespuesta.induccion_estado_id ASC'));
		$salidaJson ="";


		foreach($salida as $value){
			$salidaJson[] = array(
				'id'=>$value['InduccionRespuesta']['id'],
				'leccion'=>ucwords($value['Leccion']['titulo']),
				'pregunta'=>ucwords($value['Pregunta']['pregunta']),
				'respuesta'=>ucwords($value['InduccionRespuesta']['respuesta']),
				'correcta'=>ucwords($value['InduccionRespuesta']['verdad']),
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
		/* FinValida Usuario */
		CakeLog::write('actividad', 'induccionRespuestas - Index' .$this->Session->Read("PerfilUsuario.idUsuario"));
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

		if (!$this->InduccionRespuesta->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido.','msg_fallo'));
		}
		CakeLog::write('actividad', 'induccionRespuestas - view ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$options = array('conditions' => array('InduccionRespuesta.' . $this->InduccionRespuesta->primaryKey => $id));
		$this->set('induccionRespuesta', $this->InduccionRespuesta->find('first', $options));
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
			$this->InduccionRespuesta->create();
			if ($this->InduccionRespuesta->save($this->request->data)) {
				CakeLog::write('actividad', 'induccionRespuestas - add ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash($this->Session->setFlash('Respuesta registrada correctamente.','msg_exito'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash($this->Session->setFlash('Ocurrio un error al guardar la respuesta.','msg_fallo'));
			}
		}
		$preguntas = $this->InduccionRespuesta->Pregunta->find('list',array("conditions"=> array("Pregunta.induccion_estado_id = 1" )));
		$estados = $this->InduccionRespuesta->Estado->find('list');
		$this->set(compact('preguntas', 'estados'));
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

		if (!$this->InduccionRespuesta->exists($id)) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido.','msg_fallo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->InduccionRespuesta->save($this->request->data)) {
				CakeLog::write('actividad', 'induccionRespuestas - edit ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash($this->Session->setFlash('Respuesta actualizada correctamente.','msg_exito'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash($this->Session->setFlash('Ocurrio un error al actualizar la pregunta.','msg_fallo'));
			}
		} else {
			$options = array('conditions' => array('InduccionRespuesta.' . $this->InduccionRespuesta->primaryKey => $id));
			$this->request->data = $this->InduccionRespuesta->find('first', $options);
		}
		$preguntas = $this->InduccionRespuesta->Pregunta->find('list',array("conditions"=> array("Pregunta.induccion_estado_id = 1" )));
		$estados = $this->InduccionRespuesta->Estado->find('list');
		$this->set(compact('preguntas', 'estados'));
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

		$estado = $this->InduccionRespuesta->find('all', array(
			'conditions'=>array('InduccionRespuesta.id' => $id),
			'recursive'=>-1
		));

		$status = array(
			'id' => $estado[0]['InduccionRespuesta']['id'],
			'induccion_estado_id'=>2
		);
		
		$this->InduccionRespuesta->id = $id;
		if (!$this->InduccionRespuesta->exists()) {
			throw new NotFoundException($this->Session->setFlash('Registro invalido.','msg_fallo'));
		}

		if($estado[0]['InduccionRespuesta']['induccion_estado_id'] == 1){

			if($this->InduccionRespuesta->save($status)){
				CakeLog::write('actividad', 'induccionRespuesta - delete ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('Respuesta eliminada correctamente','msg_exito');
			}else{
				$this->Session->setFlash('Ocuerrio un error al eliminar la respuesta.','msg_fallo');
			}
		}else{

			$this->Session->setFlash('No puede realizar esta operación, la respuesta fue eliminada anteriormente.','msg_fallo');	
		}

		return $this->redirect(array('action' => 'index'));
	}
}
