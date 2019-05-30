<?php
App::uses('AppController', 'Controller');

define("ID_EMPRESA", 1842);
/**
 * ProduccionPartidosChilefilms Controller
 *
 * @property ProduccionPartidosChilefilm $ProduccionPartidosChilefilm
 * @property PaginatorComponent $Paginator
 */
class ProduccionPartidosChilefilmsController extends AppController {

	private $tipoExternos = array('asistente'=>"Asistente de Dirección",'director'=>"Director", 'productor'=>"Productor");

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
	}

	public function iteracion($chilefilmsSerializado)
	{
		$this->loadModel("CompaniesContacto");

		$nombreTrabajadoresChilefilms = $this->CompaniesContacto->find("all", array(
			"conditions"=>array("CompaniesContacto.estado"=>2, "CompaniesContacto.company_id"=>ID_EMPRESA),
			"fields"=>array("CompaniesContacto.id","CompaniesContacto.nombre", "CompaniesContacto.apellido_paterno", "CompaniesContacto.apellido_materno"),
			"recursive"=>-1
		));
			
		$trabajadores = "";
		if(!empty($nombreTrabajadoresChilefilms))
		{
			foreach ($nombreTrabajadoresChilefilms as $nombreTrabajadoresChilefilms)
			{
				$trabajadores[$nombreTrabajadoresChilefilms["CompaniesContacto"]["id"]] = $nombreTrabajadoresChilefilms["CompaniesContacto"]["nombre"] . ' ' . $nombreTrabajadoresChilefilms["CompaniesContacto"]["apellido_paterno"] . ' ' . $nombreTrabajadoresChilefilms["CompaniesContacto"]["apellido_materno"];
			}
		}

		$trabajadorChilefilmsDeserealizado = unserialize($chilefilmsSerializado);

		
		for ($i = 0; $i <= count($trabajadorChilefilmsDeserealizado) - 1; $i++) {
			$produccionPartidosChileFilmsJson[] = $trabajadores[$trabajadorChilefilmsDeserealizado[$i]];
		}

		return $produccionPartidosChileFilmsJson;
	}

	public function listaChileFilms()
	{
		$this->autoRender = false;
		$this->response->type("json");

		$produccionPartidosChileFilms = $this->ProduccionPartidosChilefilm->find("all", array(
			"conditions"=>array("ProduccionPartidosChilefilm.estado" =>1),
			"recursive"=> -1
		));

		$produccionPartidosChileFilmsJson = "";
		foreach ($produccionPartidosChileFilms as  $produccionPartidos) {

			$produccionPartidosChileFilmsJson[] = array(
				"id"=>$produccionPartidos["ProduccionPartidosChilefilm"]["id"],
				"produccionPartidoId"=>$produccionPartidos["ProduccionPartidosChilefilm"]["produccion_partido_id"],
				"director"=>implode(", ", $this->iteracion($produccionPartidos["ProduccionPartidosChilefilm"]["director"])),
				"asistenteProduccion"=>implode(", ", $this->iteracion($produccionPartidos["ProduccionPartidosChilefilm"]["asist_direccion"])),
				"operadorGc"=>implode(", ", $this->iteracion($produccionPartidos["ProduccionPartidosChilefilm"]["operador_gc"])),
				"sonidista"=>implode(", ", $this->iteracion($produccionPartidos["ProduccionPartidosChilefilm"]["sonidista"])),
				"chofer"=>implode(", ", $this->iteracion($produccionPartidos["ProduccionPartidosChilefilm"]["chofer"])),
				"estado"=>$produccionPartidos["ProduccionPartidosChilefilm"]["estado"],
				"created" => $produccionPartidos["ProduccionPartidosChilefilm"]["created"],
			);
		}
		
		return json_encode($produccionPartidosChileFilmsJson);
	}

	public function view($id = null) {
		if (!$this->ProduccionPartidosChilefilm->exists($id)) {
			throw new NotFoundException(__('Invalid produccion partidos chilefilm'));
		}
		$options = array('conditions' => array('ProduccionPartidosChilefilm.' . $this->ProduccionPartidosChilefilm->primaryKey => $id));
		$this->set('produccionPartidosChilefilm', $this->ProduccionPartidosChilefilm->find('first', $options));
	}

	public function obtEstadoEvento($id){
		$this->loadModel("ProduccionPartidosEvento");
		$evento = $this->ProduccionPartidosEvento->find("first", array("conditions"=>array("ProduccionPartidosEvento.id"=>$id)));
		$estado = 1;
		if(!empty($evento)){
			if($evento["ProduccionPartido"]["estado"]==1 && $evento["ProduccionPartidosTransmisione"]["estado"]==1 ){
				$estado = 2;
			}
		}else{
			$estado = 0;
		}
		return $estado;
	}

	public function equipoChilefilms(){
		$this->loadModel("ProduccionContacto");
		$trabajadoresExternos = $this->ProduccionContacto->find("all", array(
			"conditions"=>array(	"estado"=>1,
				"tipo_contacto"=>  array_keys($this->tipoExternos) ),
			"fields"=>array(
				"id", 
				"nombre"
			)
		));

		$chilefilmsList = "";
		foreach ($trabajadoresExternos as $key => $trabajadoresChileFilm){
			$chilefilmsList[$trabajadoresChileFilm["ProduccionContacto"]["id"]] = $trabajadoresChileFilm["ProduccionContacto"]["nombre"];  
		}
		return $chilefilmsList;
	}

	public function add($idProduccionPartidos = null){

		$this->acceso();

		$this->loadModel("ProduccionPartidosEvento");
		$this->loadModel("FixturePartido");
		$this->loadModel("Regione");

		if (!$this->ProduccionPartidosEvento->exists($idProduccionPartidos)) {

			$this->Session->setFlash('Ocurrio un problema intentelo nuevamente', 'msg_fallo');
			return $this->redirect(array('controller'=>'produccion_partidos', 'action' => 'index'));
		}
		if(empty($idProduccionPartidos))
		{
			$this->Session->setFlash('Ocurrio un problema intentelo nuevamente', 'msg_fallo');
			return $this->redirect(array('controller'=>'produccion_partidos', 'action' => 'index'));
		}
		$dataPartido = $this->ProduccionPartidosEvento->find("first", array("conditions"=> array("ProduccionPartidosEvento.id"=>$idProduccionPartidos), "recursive"=>0));
		$dataPartido["ProduccionPartidosEvento"]["fecha_partido"] = implode("/",array_reverse(explode("-",$dataPartido["ProduccionPartidosEvento"]["fecha_partido"])));
		$dataPartido["ProduccionPartidosEvento"]["hora_partido"] = substr($dataPartido["ProduccionPartidosEvento"]["hora_partido"],0,5);

		$regiones = $this->Regione->find('list', array("fields"=> array("id", "region_ordinal")));
		$region = "";
		$region[] = $regiones[$dataPartido["Estadio"]["regione_id"]];
		$region[] = ($dataPartido["Estadio"]["regione_id"] != 7) ? ' Región.' : '.';
		$dataPartido["Estadio"]["region_nombre"] = mb_strtoupper(implode("",$region));
		
		$this->set("data", $dataPartido);
		$this->set("externoList", $this->equipoChilefilms());
		$this->set("idProduccionPartido", $idProduccionPartidos);

		if ($this->request->is('post')) {

			$this->ProduccionPartidosChilefilm->create();
			$this->request->data["ProduccionPartidosChilefilm"]["director"] = serialize($this->request->data["ProduccionPartidosChilefilm"]["director"]);
			$this->request->data["ProduccionPartidosChilefilm"]["asist_direccion"] = serialize($this->request->data["ProduccionPartidosChilefilm"]["asist_direccion"]);
			$this->request->data["ProduccionPartidosChilefilm"]["productor"] = serialize($this->request->data["ProduccionPartidosChilefilm"]["productor"]);
			$this->request->data["ProduccionPartidosChilefilm"]["estado"] = 1;

			$this->request->data["ProduccionPartidosEvento"]["id"] = $idProduccionPartidos;
			$this->request->data["ProduccionPartidosEvento"]["estado_produccion"] = $this->obtEstadoEvento($idProduccionPartidos);
			

			if ($this->ProduccionPartidosEvento->saveAssociated($this->request->data, array('deep' => true))) {

				CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->ProduccionPartidosEvento->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") ); 

				$this->Session->setFlash('Registrado correctamente', 'msg_exito');
				return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error no se a podido registrar la información', 'msg_fallo');
				return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
			}
		}
	}

	public function edit($idProduccionPartidos = null) {
		
		$this->acceso();
		
		$this->loadModel("ProduccionPartidosEvento");
		$this->loadModel("Regione");
		
		$dataPartido = $this->ProduccionPartidosEvento->find("first", array("conditions"=> array("ProduccionPartidosEvento.id"=>$idProduccionPartidos), "recursive"=>0));
		$dataPartido["ProduccionPartidosEvento"]["fecha_partido"] = implode("/",array_reverse(explode("-",$dataPartido["ProduccionPartidosEvento"]["fecha_partido"])));
		$dataPartido["ProduccionPartidosEvento"]["hora_partido"] = substr($dataPartido["ProduccionPartidosEvento"]["hora_partido"],0,5);		
		
		$regiones = $this->Regione->find('list', array("fields"=> array("id", "region_ordinal")));
		$region = "";
		$region[] = $regiones[$dataPartido["Estadio"]["regione_id"]];
		$region[] = ($dataPartido["Estadio"]["regione_id"] != 7) ? ' Región.' : '.';
		$dataPartido["Estadio"]["region_nombre"] = mb_strtoupper(implode("",$region));
		
		$this->set("data", $dataPartido);
		
		$idChilefilms = $this->ProduccionPartidosChilefilm->find("list",array("conditions"=> array("ProduccionPartidosChilefilm.produccion_partidos_evento_id"=> $idProduccionPartidos)));		
		if (!$this->ProduccionPartidosChilefilm->exists($idChilefilms)) {
			$this->Session->setFlash('Ocurrio un error no se a podido registrar la información', 'msg_fallo');
		}	
		
		$options = array('conditions' => array('ProduccionPartidosChilefilm.' . $this->ProduccionPartidosChilefilm->primaryKey => $idChilefilms),"recursive"=>-1);
		$editables = $this->ProduccionPartidosChilefilm->find('first', $options);
		
		$this->set("externoList", $this->equipoChilefilms());
		$this->set("idChilefilms", $idChilefilms);
		$this->set("regiones",$regiones);
		
		$this->set("productorSeleccionado", (!empty($editables["ProduccionPartidosChilefilm"]["productor"]))? unserialize($editables["ProduccionPartidosChilefilm"]["productor"]) : array());
		$this->set("asistSeleccionado", (!empty($editables["ProduccionPartidosChilefilm"]["asist_direccion"]))? unserialize($editables["ProduccionPartidosChilefilm"]["asist_direccion"]) : array());
		$this->set("directorSeleccionado", (!empty($editables["ProduccionPartidosChilefilm"]["director"]))? unserialize($editables["ProduccionPartidosChilefilm"]["director"]) : array());
		
		if ($this->request->is(array('post', 'put'))) {			
			$this->request->data["ProduccionPartidosChilefilm"]["director"] = serialize($this->request->data["ProduccionPartidosChilefilm"]["director"]);
			$this->request->data["ProduccionPartidosChilefilm"]["asist_direccion"] = serialize($this->request->data["ProduccionPartidosChilefilm"]["asist_direccion"]);
			$this->request->data["ProduccionPartidosChilefilm"]["productor"] = serialize($this->request->data["ProduccionPartidosChilefilm"]["productor"]);			

			if ($this->ProduccionPartidosChilefilm->save($this->request->data["ProduccionPartidosChilefilm"])) {

				CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->ProduccionPartidosChilefilm->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") ); 

				$this->Session->setFlash('Registrado correctamente', 'msg_exito');
				return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
				
			} else {
				$this->Session->setFlash('Ocurrio un error no se a podido registrar la información', 'msg_fallo');
				return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('ProduccionPartidosChilefilm.' . $this->ProduccionPartidosChilefilm->primaryKey => $idChilefilms),"recursive"=>2);
			$this->request->data = $this->ProduccionPartidosChilefilm->find('first', $options);
		}
	}

	public function delete($id = null) {
		$this->ProduccionPartidosChilefilm->id = $id;
		if (!$this->ProduccionPartidosChilefilm->exists()) {
			throw new NotFoundException(__('Invalid produccion partidos chilefilm'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ProduccionPartidosChilefilm->delete()) {
			$this->Session->setFlash(__('The produccion partidos chilefilm has been deleted.'));
		} else {
			$this->Session->setFlash(__('The produccion partidos chilefilm could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function boton_produccion_chilefilms(){}

	public function acceso(){
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
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario")); 
	}
}
