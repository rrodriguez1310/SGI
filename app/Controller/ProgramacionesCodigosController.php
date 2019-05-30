 
<?php
App::uses('AppController', 'Controller');
/**
 * ProgramacionesCodigos Controller
 *
 * @property ProgramacionesCodigo $ProgramacionesCodigo
 * @property PaginatorComponent $Paginator
 */
class ProgramacionesCodigosController extends AppController {

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
		$this->layout = "angular";
		//$this->ProgramacionesCodigo->recursive = 0;
		//$this->set('programacionesCodigos', $this->Paginator->paginate());
	}

	public function lista_codigos() {

		$this->autoRender = false;
		$this->response->type("json");

		$codigos = $this->ProgramacionesCodigo->find('all', array(
			'fields'=>array(
				'ProgramacionesCodigo.id',
				'ProgramacionesCodigo.titulo',
				'ProgramacionesCodigo.descripcion'
			),
			'recursive'=> -1,
		));

		$codigosJson = "";
		if(!empty($codigos)){
			foreach($codigos as $codigo){
				$codigosJson[] = array(
					'id'=> $codigo['ProgramacionesCodigo']['id'],
					'titulo'=> $codigo['ProgramacionesCodigo']['titulo'],
					'descripcion'=> $codigo['ProgramacionesCodigo']['descripcion']
				);
			}
		}
		return json_encode($codigosJson);
		exit;
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		/*
		if($this->Session->Read("Users.flag") != 0)
		{

			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		*/

		if (!$this->ProgramacionesCodigo->exists($id)) {
			throw new NotFoundException(__('Invalid programaciones codigo'));
		}
		$options = array('conditions' => array('ProgramacionesCodigo.' . $this->ProgramacionesCodigo->primaryKey => $id));
		$this->set('programacionesCodigo', $this->ProgramacionesCodigo->find('first', $options));
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
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		if ($this->request->is('post')) {
			$this->ProgramacionesCodigo->create();
			if ($this->ProgramacionesCodigo->save($this->request->data)) {
				CakeLog::write('actividad', 'codigo programacion - save - id registrado ' .$this->ProgramacionesCodigo->id. ' id de usuario '. $this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('el codigo se registro correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('El codigo no se registro intenetelo nuevamente', 'msg_fallo');
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
		
		if($this->Session->Read("Users.flag") != 0)
		{

			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		if (!$this->ProgramacionesCodigo->exists($id)) {
			throw new NotFoundException(__('Invalid programaciones codigo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProgramacionesCodigo->save($this->request->data)) {
				CakeLog::write('actividad', 'codigo programacion - save - id editado ' .$this->ProgramacionesCodigo->id. ' id de usuario '. $this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash('el codigo se edito correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('El codigo no se edito intenetelo nuevamente', 'msg_fallo');
			}
		} else {
			$options = array('conditions' => array('ProgramacionesCodigo.' . $this->ProgramacionesCodigo->primaryKey => $id));
			$this->request->data = $this->ProgramacionesCodigo->find('first', $options);
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
		
		if($this->Session->Read("Users.flag") != 0)
		{

			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		$this->ProgramacionesCodigo->id = $id;
		if (!$this->ProgramacionesCodigo->exists()) {
			throw new NotFoundException(__('Invalid programaciones codigo'));
		}
		$this->request->allowMethod('get', 'delete');
		if ($this->ProgramacionesCodigo->delete()) {
			CakeLog::write('actividad', 'codigo programacion - eliminar - id eliminar ' .$this->ProgramacionesCodigo->id. ' id de usuario '. $this->Session->Read("PerfilUsuario.idUsuario"));
			$this->Session->setFlash('el codigo se elimino correctamente', 'msg_exito');
		} else {
			CakeLog::write('actividad', 'codigo programacion - no se pudo - id eliminar ' .$this->ProgramacionesCodigo->id. ' id de usuario '. $this->Session->Read("PerfilUsuario.idUsuario"));
			$this->Session->setFlash('el codigo no se pudo eliminar', 'msg_fallo');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
