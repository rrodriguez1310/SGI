<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
/**
 * ProduccionContactos Controller
 *
 * @property ProduccionContacto $ProduccionContacto
 * @property PaginatorComponent $Paginator
 */
class ProduccionContactosController extends AppController {

	private $tipoExternos = array(
		'asistente'=>"Asistente de Dirección",
		'director'=>"Director", 
		'productor'=>"Productor"
		);

	private $tipoCDF = array(
		'productor-cdf'=>"Productor",
		'asistente-cdf'=>"Asistente de Producción", 
		'coordinador-cdf'=>"Coordinador Periodístico",
		'relator-cdf'=>"Relator",
		'periodista-cdf'=>"Periodista",
		'comentarista-cdf'=>"Comentarista",
		'locutor-cdf'=>"Locutor",
		'operador-cdf'=>"Operador Track-vision",
		'musicalizador-cdf'=>"Musicalizador"
		);

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
		//$this->acceso();
	}

	public function lista_destinatarios_json(){
		$this->layout = "ajax";
		$this->response->type("json");
		$produccionContactos = $this->ProduccionContacto->find("all", array( 
			"conditions"=> array("estado"=>1, "tipo_contacto"=>'destinatarios'),
			"order"=>"id")
		);	
		foreach ($produccionContactos as $key => $contacto) {
			$listaContactos[] = $contacto["ProduccionContacto"];
		}
		$this->set('listado',$listaContactos); 
	}

	public function listar_externos() {
		$this->layout = "angular";
		//$this->acceso();
	}

	public function lista_externos_json(){
		$this->layout = "ajax";
		$this->response->type("json");
		$produccionExternos = $this->ProduccionContacto->find("all", array( 
			"conditions"=> array("estado"=>1, 
				"tipo_contacto"=> array_keys($this->tipoExternos)),
			"order"=>"id")
		);
		foreach ($produccionExternos as $key => $contacto) {
			$contacto["ProduccionContacto"]["tipo_contacto"] = $this->tipoExternos[$contacto["ProduccionContacto"]["tipo_contacto"]];
			$listaContactos[] = $contacto["ProduccionContacto"];
		}
		$this->set('listado',$listaContactos); 
	}

	public function listar_responsables() {
		$this->layout = "angular";
		//$this->acceso();
	}

	public function lista_responsables_json(){
		$this->layout = "ajax";
		$this->response->type("json");
	
		$produccionResponsables = $this->ProduccionContacto->find("all", array( 
			"conditions"=> array("estado"=>1, 
				"tipo_contacto"=> array_keys($this->tipoCDF)),
			"order"=>"tipo_contacto")
		);
		foreach ($produccionResponsables as $key => $contacto) {
			$contacto["ProduccionContacto"]["tipo_contacto"] = $this->tipoCDF[$contacto["ProduccionContacto"]["tipo_contacto"]];
			$listaResponsables[] = $contacto["ProduccionContacto"];
		}
		$this->set('listado',$listaResponsables); 
	}
/*
	public function listar_nombre_trabajadores () {

		$this->loadModel("ProduccionNombreRostro");
		$this->loadModel("Trabajadore");



		if ($this->request->is(array('post', 'put'))) {

			$this->request->data["ProduccionContacto"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');			

			pr($this->request->data);exit;

			if ($this->ProduccionContacto->save($this->request->data)) {
				$this->Session->setFlash('Se registro la información correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion.','msg_fallo');
			}

		} else {

			$trabajadores = $this->Trabajadore->find("all", array(
				"fields"=>array("Trabajadore.id","Trabajadore.nombre","Trabajadore.apellido_paterno"),
				"joins"=> array(array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id"))),
				"conditions"=>array("Trabajadore.estado"=>"Activo", 
					"Area.gerencia_id"=>23),
				"order"=>"Trabajadore.nombre ASC",
				"recursive" => 0
				));
			foreach ($trabajadores as $trabajador) {
				$trabajadoresProduccion[$trabajador["Trabajadore"]["id"]] = mb_strtoupper( strtok($trabajador["Trabajadore"]["nombre"], " ") . ' ' . $trabajador["Trabajadore"]["apellido_paterno"], 'UTF-8');
			}
			
			$this->set("trabajadores", $trabajadoresProduccion);



			$options = array('conditions' => array('ProduccionContacto.' . $this->ProduccionContacto->primaryKey => $id));
			$this->request->data = $this->ProduccionContacto->find('first', $options);
		}
	}*/

	public function nombres_trabajadores() {
		$this->layout = "angular";
		//$this->acceso();
	}

	public function lista_trabajadores_json(){
		$this->layout = "ajax";
		$this->response->type("json");
		$this->loadModel("Trabajadore");
		$this->loadModel("ProduccionNombreRostro");
		$serv = new ServiciosController();

		$trabajadores = $this->Trabajadore->find("all", array(
			"fields"=>array("Trabajadore.id","Trabajadore.rut","Trabajadore.nombre","Trabajadore.apellido_paterno", "Cargo.nombre"),
			"joins"=> array(array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id"))),
			"conditions"=>array( // "Trabajadore.estado"=>"Activo", 
				"Area.gerencia_id"=>23),
			"order"=>"Trabajadore.nombre ASC",
			"recursive" => 0
			));
		$nombreRostros = $this->ProduccionNombreRostro->find("list",array(
			"conditions"=>array("tipo_relacion"=>'T'),
			"fields"=>array("relacion_id","nombre")
		));

		foreach ($trabajadores as $trabajador) {

			$trabajador["Trabajadore"]["nombre_sistema"] = mb_strtoupper( strtok($trabajador["Trabajadore"]["nombre"], " ") . ' ' . $trabajador["Trabajadore"]["apellido_paterno"], 'UTF-8');
			$trabajador["Trabajadore"]["nombre_produccion"] = isset($nombreRostros[$trabajador["Trabajadore"]["id"]]) ? $nombreRostros[$trabajador["Trabajadore"]["id"]] : $trabajador["Trabajadore"]["nombre_sistema"];			
			$trabajador["Trabajadore"]["cargo"] = $serv->capitalize($trabajador["Cargo"]["nombre"]);
			
			$trabajadoresProduccion[] = $trabajador["Trabajadore"];
		}
			
		$this->set("listado", $trabajadoresProduccion);		
	}

/**
 *
 * @return void
 */
	public function add_destinatarios() {
		if ($this->request->is('post')) {
			$this->ProduccionContacto->create();
			$this->request->data["ProduccionContacto"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');

			if ($this->ProduccionContacto->save($this->request->data)) {
				$this->Session->setFlash('Se registro la información correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
			}
		}

	}

	public function add_externos() {
		$this->set( "tipoContactos", $this->tipoExternos);
		if ($this->request->is('post')) {
			$this->ProduccionContacto->create();
			$this->request->data["ProduccionContacto"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');			
			
			if ($this->ProduccionContacto->save($this->request->data)) {
				$this->Session->setFlash('Se registro la información correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'listar_externos'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
			}
		}
	}

	public function add_responsables_cdf() { //empresas

		$this->loadModel("Company");
		$this->loadModel("ProduccionNombreRostro");

		$companies = $this->Company->find("list", array(
			"fields"=>array("id","nombre"),
			"conditions"=>array("paise_id"=>46,
				"company_type_otros"=> serialize(array('4'))
				)
			)
		);

		$this->set("tipoContactos", $this->tipoCDF);
		$this->set("companies", $companies);

		if ($this->request->is('post')) {
			$this->ProduccionContacto->create();
			$this->request->data["ProduccionContacto"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');

			$nombres["tipo_relacion"] = 'E';
			$nombres["relacion_id"]  = $this->request->data["ProduccionContacto"]["company_id"];
			$nombres["nombre"]  = $this->request->data["ProduccionContacto"]["nombre"];

			
			if ( $this->ProduccionContacto->save($this->request->data)) {

				$contactoIds = $this->ProduccionContacto->find("list", array(
					"conditions"=>array("ProduccionContacto.company_id"=>$this->request->data["ProduccionContacto"]["company_id"])
					)
				);
				foreach ($contactoIds as $contact) {
					$updateContactos[] = array("id"=>$contact,"nombre"=>$this->request->data["ProduccionContacto"]["nombre"]);
				}
				$this->ProduccionContacto->saveAll($updateContactos);
			
				$conditions = array(
				    'ProduccionNombreRostro.tipo_relacion' => $nombres["tipo_relacion"],
				    'ProduccionNombreRostro.relacion_id' => $nombres["relacion_id"],
				    'ProduccionNombreRostro.user_id' => $this->Session->read('PerfilUsuario.idUsuario')
				);
				
				if($this->ProduccionNombreRostro->hasAny($conditions)){
					$nombresId = $this->ProduccionNombreRostro->find("list", array("conditions"=>$conditions));
					$nombres["id"] = array_values($nombresId)[0];
				}
				
				$this->ProduccionNombreRostro->save($nombres);

				$this->Session->setFlash('Se registro la información correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'listar_responsables'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
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
	public function edit_destinatarios($id = null) {

		if (!$this->ProduccionContacto->exists($id)) {
			throw new NotFoundException(__('Invalid produccion contacto'));
		}
		if ($this->request->is(array('post', 'put'))) {

			$this->request->data["ProduccionContacto"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');			

			if ($this->ProduccionContacto->save($this->request->data)) {
				$this->Session->setFlash('Se registro la información correctamente.','msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion.','msg_fallo');
			}

		} else {
			$options = array('conditions' => array('ProduccionContacto.' . $this->ProduccionContacto->primaryKey => $id));
			$this->request->data = $this->ProduccionContacto->find('first', $options);
		}
	}

	public function edit_externos($id = null) {

		if (!$this->ProduccionContacto->exists($id)) {
			throw new NotFoundException(__('Invalid produccion externo'));
		}

		if ($this->request->is(array('post', 'put'))) {

			$this->request->data["ProduccionContacto"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');

			if ($this->ProduccionContacto->save($this->request->data)) {
				$this->Session->setFlash('Se registro la información correctamente.','msg_exito');
				return $this->redirect(array('action' => 'listar_externos'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion.','msg_fallo');
			}

		} else {
			
			$tipoContactos = $this->tipoExternos;
			$this->set("tipoContactos",$tipoContactos);
			$options = array('conditions' => array('ProduccionContacto.' . $this->ProduccionContacto->primaryKey => $id));
			$this->request->data = $this->ProduccionContacto->find('first', $options);
			
		}
	}

	public function edit_responsables_cdf($id = null) {

		$this->loadModel("Company");
		$this->loadModel("ProduccionNombreRostro");

		if (!$this->ProduccionContacto->exists($id)) {
			throw new NotFoundException(__('Invalid produccion responsables'));
		}

		if ($this->request->is(array('post', 'put'))) {

			$this->request->data["ProduccionContacto"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data["ProduccionNombreRostro"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
		
			if ($this->ProduccionContacto->save($this->request->data)) {

				$nombres["tipo_relacion"] = 'E';
				$nombres["relacion_id"]  = $this->request->data["ProduccionContacto"]["company_id"];
				$nombres["nombre"]  = $this->request->data["ProduccionContacto"]["nombre"];

				$conditions = array(
				    'ProduccionNombreRostro.tipo_relacion' => $nombres["tipo_relacion"],
				    'ProduccionNombreRostro.relacion_id' => $nombres["relacion_id"]
				);
				
				if($this->ProduccionNombreRostro->hasAny($conditions)){
					$nombresId = $this->ProduccionNombreRostro->find("list", array("conditions"=>$conditions));
					$nombres["id"] = array_values($nombresId)[0];
				}
				
				$this->ProduccionNombreRostro->save($nombres);

				$this->Session->setFlash('Se registro la información correctamente.','msg_exito');
				return $this->redirect(array('action' => 'listar_responsables'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion.','msg_fallo');
			}

		} else {

			$companies = $this->Company->find("list", array(
				"fields"=>array("id","nombre")
			));

			$this->set("tipoContactos", $this->tipoCDF);
			$this->set("companies", $companies);
			
			$options = array('conditions' => array('ProduccionContacto.' . $this->ProduccionContacto->primaryKey => $id));
			$this->request->data = $this->ProduccionContacto->find('first', $options);
			
		}
	}


	public function edit_nombre_trabajador ($id = null) {

		$this->loadModel("ProduccionNombreRostro");
		$this->loadModel("Trabajadore");

		if (!$this->Trabajadore->exists($id)) {
			throw new NotFoundException(__('Invalid produccion contacto'));
		}
		if ($this->request->is(array('post', 'put'))) {

			$this->request->data["ProduccionNombreRostro"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');			
			$this->request->data["ProduccionNombreRostro"]["relacion_id"] = $this->request->data["ProduccionNombreRostro"]["id"];			
			$this->request->data["ProduccionNombreRostro"]["tipo_relacion"] = 'T';
			$this->request->data["ProduccionNombreRostro"]["nombre"] = $this->request->data["ProduccionNombreRostro"]["nombre_produccion"];

			unset($this->request->data["ProduccionNombreRostro"]["nombre_produccion"]);
			unset($this->request->data["ProduccionNombreRostro"]["nombre_sistema"]);

			$nombreId = $this->ProduccionNombreRostro->find("first", array( 
				"conditions" => array( "ProduccionNombreRostro.relacion_id" => $id,
					"ProduccionNombreRostro.tipo_relacion" => "T" )
				 ));

			if(!empty($nombreId)){
				$this->request->data["ProduccionNombreRostro"]["id"] = $nombreId["ProduccionNombreRostro"]["id"];
			}
			else
			{
				unset($this->request->data["ProduccionNombreRostro"]["id"]);
			}

			//pr($this->request->data);exit;

			if ($this->ProduccionNombreRostro->save($this->request->data)) {

				$this->Session->setFlash('Se registro la información correctamente.','msg_exito');
				return $this->redirect(array('action' => 'nombres_trabajadores'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion.','msg_fallo');
			}

		} else {

			$trabajador = $this->Trabajadore->find("first", array(
				"fields"=>array("Trabajadore.id","Trabajadore.nombre","Trabajadore.apellido_paterno"),	
				"conditions"=>array("Trabajadore.id"=>$id),
				"order"=>"Trabajadore.nombre ASC",
				"recursive" => -1
				)
			);

			$nombreProduccion = $this->ProduccionNombreRostro->find("first", array(
				"conditions" => array("tipo_relacion" => 'T',
					"relacion_id" => $id)
				));

			$trabajadorProduccion["ProduccionNombreRostro"]["nombre_sistema"] = mb_strtoupper(strtok($trabajador["Trabajadore"]["nombre"], " ") . ' ' . $trabajador["Trabajadore"]["apellido_paterno"]);
			$trabajadorProduccion["ProduccionNombreRostro"]["nombre_produccion"] = isset($nombreProduccion["ProduccionNombreRostro"]["nombre"]) ? $nombreProduccion["ProduccionNombreRostro"]["nombre"] : $trabajadorProduccion["ProduccionNombreRostro"]["nombre_sistema"];
			$trabajadorProduccion["ProduccionNombreRostro"]["id"] = $id;

			$this->request->data = $trabajadorProduccion;

			$this->set("produccionNombreRostro", $trabajadorProduccion);
			
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete_produccion_destinatarios($id = null) {
		$this->layout = "ajax";
		$this->ProduccionContacto->id = $id;
		if (!$this->ProduccionContacto->exists()) {
			throw new NotFoundException(__('Invalid produccion contacto'));
		}
		$this->request->data["id"] = $this->ProduccionContacto->id;
		$this->request->data["estado"] = 0;
		$this->request->data["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');	

		if ($this->ProduccionContacto->save($this->request->data)) {			
			$this->Session->setFlash('El contacto fue eliminado correctamente.', 'msg_exito');
		} else {
			$this->Session->setFlash('El contacto no pudo ser eliminado. Por favor, intente nuevamente.', 'msg_fallo');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function delete_produccion_externos($id = null) {
		$this->layout = "ajax";
		$this->ProduccionContacto->id = $id;
		if (!$this->ProduccionContacto->exists()) {
			throw new NotFoundException(__('Invalid produccion contacto'));
		}
		$this->request->data["id"] = $this->ProduccionContacto->id;
		$this->request->data["estado"] = 0;
		$this->request->data["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');	

		if ($this->ProduccionContacto->save($this->request->data)) {			
			$this->Session->setFlash('El registro fue eliminado correctamente.', 'msg_exito');
		} else {
			$this->Session->setFlash('El registro no pudo ser eliminado. Por favor, intente nuevamente.', 'msg_fallo');
		}
		return $this->redirect(array('action' => 'listar_externos'));
	}

	public function delete_produccion_responsables($id = null) {
		$this->layout = "ajax";
		$this->ProduccionContacto->id = $id;
		if (!$this->ProduccionContacto->exists()) {
			throw new NotFoundException(__('Invalid produccion responsable'));
		}
		$this->request->data["id"] = $this->ProduccionContacto->id;
		$this->request->data["estado"] = 0;
		$this->request->data["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');	

		if ($this->ProduccionContacto->save($this->request->data)) {			
			$this->Session->setFlash('El registro fue eliminado correctamente.', 'msg_exito');
		} else {
			$this->Session->setFlash('El registro no pudo ser eliminado. Por favor, intente nuevamente.', 'msg_fallo');
		}
		return $this->redirect(array('action' => 'listar_responsables'));
	}

}
