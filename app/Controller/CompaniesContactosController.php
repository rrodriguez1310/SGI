<?php
App::uses('AppController', 'Controller');
/**
 * CompaniesContactos Controller
 *
 * @property CompaniesContacto $CompaniesContacto
 * @property PaginatorComponent $Paginator
 */
class CompaniesContactosController extends AppController {

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
		$this->CompaniesContacto->recursive = 0;
		$this->set('companiesContactos', $this->Paginator->paginate());
	}

	public function lista_contactos($id = null, $estado = null)
	{
		
		$this->layout = "ajax";
		$this->loadModel("Companies");

		$consitions = "";

		if(!empty($id) && !empty($estado))
		{
			$idEmpresa = $id;
		}
		else
		{
			$idEmpresa = $this->params->query["id"];
		}

		$datosEmpresa = $this->Companies->find("first", array(
			"conditions"=>array("Companies.id"=>$idEmpresa),
			"fields"=>array("Companies.id", "Companies.nombre"),
			"recursive"=>0
		));
		$this->loadModel("CompaniesContacto");
		
		$listaContactos = $this->CompaniesContacto->find("all", array(
			"conditions"=>array("CompaniesContacto.company_id"=>$idEmpresa),
			"fields"=>array(
				"CompaniesContacto.id", 
				"CompaniesContacto.nombre",
				"CompaniesContacto.cargo",
				"CompaniesContacto.apellido_paterno", 
				"CompaniesContacto.email",
				"CompaniesContacto.telefono_fijo",
				"CompaniesContacto.telefono_celular"
			),
			"order" => array('CompaniesContacto.nombre ASC')
			));

	    $contactos = "";
	    
	    foreach($listaContactos as $listaContacto)
	    {
	     	
	     	$contactos[] = array(
	     		'id'=> $listaContacto["CompaniesContacto"]["id"],
	     		//'nombre_empresa'=> $listaContacto["Company"]["nombre"],
	     		'nombre'=> $listaContacto["CompaniesContacto"]["nombre"],
	     		'cargo'=> $listaContacto["CompaniesContacto"]["cargo"],
	     		'apellido_paterno'=> $listaContacto["CompaniesContacto"]["apellido_paterno"],
	     		//'apellido_materno'=> $listaContacto["CompaniesContacto"]["apellido_materno"],
	     		'email'=> $listaContacto["CompaniesContacto"]["email"],
	     		'celular'=> $listaContacto["CompaniesContacto"]["telefono_celular"],
	     		'telefono'=> $listaContacto["CompaniesContacto"]["telefono_fijo"],
	     		//'observacion'=> $listaContacto["CompaniesContacto"]["observacion"],
	     		//'estado'=> $listaContacto["CompaniesContacto"]["estado"],
	     		//'cargo'=> $listaContacto["CompaniesContacto"]["cargo"],
	     	);
	    }
	     $this->set("listaContactos", $contactos);
	     $this->set("datosEmpresa", $datosEmpresa['Companies']);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CompaniesContacto->exists($id)) {
			throw new NotFoundException(__('Invalid companies contacto'));
		}
		$options = array('conditions' => array('CompaniesContacto.' . $this->CompaniesContacto->primaryKey => $id));
		$this->set('companiesContacto', $this->CompaniesContacto->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {

		$this->layout = "ajax";	

		if ($this->request->data) {
			$this->CompaniesContacto->create();

			if ($this->CompaniesContacto->save($this->request->data)) {

				CakeLog::write('actividad', 'ingreso contacto - ' .$this->CompaniesContacto->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));

	            $this->Session->setFlash(__('El contacto se registró correctamente.'), 'msg_exito');
	            return $this->redirect(array('controller'=>'companies_contactos', 'action'=>'lista_contactos', $this->request->data["CompaniesContacto"]["company_id"], $this->request->data["CompaniesContacto"]["estado"]))	;

			} else {
				$this->Session->setFlash(__('El contacto no pudo ser registrado.'), 'msg_fallo');
			}
		}

		if(!empty($this->params->query["id"]) && !empty($this->params->query["estado"]))
		{
			$this->set("empresaId", $this->request->query["id"]);
			$this->set("estado", $this->params->query["estado"]);
		}

		$this->set(compact('companies'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */

	public function edit($id = null)
	{
		$this->layout = "ajax";	

		if(empty($id)){
			$id=$this->params->query["id"]; 
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->CompaniesContacto->save($this->request->data)) {

				CakeLog::write('actividad', 'edito contacto - ' .$this->CompaniesContacto->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash(__('El contacto se actualizó correctamente.'), 'msg_exito');
				return $this->redirect(array('controller'=>'companies_contactos', 'action'=>'lista_contactos', $this->request->data["CompaniesContacto"]["company_id"], $this->request->data["CompaniesContacto"]["estado"] )); 				

			} else {
					$this->Session->setFlash(__('El contacto no pudo ser actualizado.'), 'msg_fallo');
				}

		} else {
			$options = array('conditions' => array('CompaniesContacto.' . $this->CompaniesContacto->primaryKey => $id));
			$this->request->data = $this->CompaniesContacto->find('first', $options);
		}

		if(!empty($this->params->query["id"]) && !empty($this->params->query["estado"]))
		{	
			$this->set("empresaId", $this->request->query["id"]);
			$this->set("estado", $this->params->query["estado"]);
		}

		$this->set(compact('companies'));
	}

/**
 * comentar method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */

	public function comentar($id = null)
	{
		$this->layout = "ajax";	
		$id=$this->params->query["id"]; 
/*
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CompaniesContacto->save($this->request->data)) {

				$this->Session->setFlash(__('El contacto se actualizó correctamente.'), 'msg_exito');
				return $this->redirect(array('controller'=>'companies_contactos', 'action'=>'lista_contactos', $this->request->data["CompaniesContacto"]["company_id"], $this->request->data["CompaniesContacto"]["estado"] )); 				

			} else {
					$this->Session->setFlash(__('El contacto no pudo ser actualizado.'), 'msg_fallo');
				}

		} else {
			$options = array('conditions' => array('CompaniesContacto.' . $this->CompaniesContacto->primaryKey => $id));
			$this->request->data = $this->CompaniesContacto->find('first', $options);
		}

		if(!empty($this->params->query["id"]) && !empty($this->params->query["estado"]))
		{	
			$this->set("empresaId", $this->request->query["id"]);
			$this->set("estado", $this->params->query["estado"]);
		}
*/
		$this->set(compact('companies'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */

public function delete($id = null) {

		$this->layout = "ajax";	
		//pr($this->params);
		pr($this->data['id']);
		
		//$this->CompaniesContacto->id = $id;
		if(empty($id)){
			$id=$this->data['id']; 
		}

		if (!$this->CompaniesContacto->exists($id)) {
			throw new NotFoundException('No se encontró el contacto.' , 'msg_fallo');
		}

		$this->request->allowMethod('post', 'delete');
		
		if ($this->CompaniesContacto->delete($id)) {

			CakeLog::write('actividad', 'elimino contacto - ' .$id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			$this->Session->setFlash('El contacto se eliminó correctamente.', 'msg_exito');
			return $this->redirect(array('controller'=>'companies_contactos', 'action'=>'lista_contactos', $this->data['company_id'], 1));
		} else {
			
			$this->Session->setFlash('No se pudo eliminar el contacto. Por favor, intente nuevamente.', 'msg_error');
		}
		//return $this->redirect(array('controller'=>'companies', 'action' => 'index'));
	}
	
}
