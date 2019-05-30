<?php
App::uses('AppController', 'Controller');
/**
 * ProduccionPartidosTransmisiones Controller
 *
 * @property ProduccionPartidosTransmisione $ProduccionPartidosTransmisione
 * @property PaginatorComponent $Paginator
 */
class ProduccionPartidosTransmisionesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ProduccionPartidosTransmisione->recursive = 0;
		$this->set('produccionPartidosTransmisiones', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ProduccionPartidosTransmisione->exists($id)) {
			throw new NotFoundException(__('Invalid produccion partidos transmisione'));
		}
		$options = array('conditions' => array('ProduccionPartidosTransmisione.' . $this->ProduccionPartidosTransmisione->primaryKey => $id));
		$this->set('produccionPartidosTransmisione', $this->ProduccionPartidosTransmisione->find('first', $options));
	}

	public function trabajadoresCargos($idCargos)
	{
		$this->loadModel("Trabajadore");
		$cargosTrabajadores  = $this->Trabajadore->find("all", array(
			"conditions"=>array("Trabajadore.cargo_id"=>$idCargos, "Trabajadore.estado"=>"Activo"),
			"fields"=>array(
				"Trabajadore.id",
				"Trabajadore.nombre",
				"Trabajadore.apellido_paterno",
				"Trabajadore.apellido_materno",
				"Trabajadore.cargo_id"
			),
			"recursive"=>-1
		));

		$cargosTrabajadoresArray = "";

		foreach($cargosTrabajadores as $cargosTrabajadore)
		{
			$cargosTrabajadoresArray[$cargosTrabajadore["Trabajadore"]["id"]] = mb_strtoupper(strtok($cargosTrabajadore["Trabajadore"]["nombre"], " ") . ' ' . $cargosTrabajadore["Trabajadore"]["apellido_paterno"]);
		}
		return $cargosTrabajadoresArray;
	}

	public function obtEstadoEvento($id){
		$this->loadModel("ProduccionPartidosEvento");
		$evento = $this->ProduccionPartidosEvento->find("first", array("conditions"=>array("ProduccionPartidosEvento.id"=>$id, "ProduccionPartidosEvento.estado"=>1)));
		$estado = 0;
		if($evento["ProduccionPartido"]["estado"]==1 && $evento["ProduccionPartidosChilefilm"]["estado"]==1){
			$estado = 1;
		}
		return $estado;
	}

	public function obtSenales(){
		$this->loadModel("Channel");
		return $senalesTransmision = $this->Channel->find("list", array(
			"fields"=>array( "Channel.id", "Channel.nombre"), 
			"conditions"=> array( "Channel.tipo"=>1, "Channel.estado" => 1, "Channel.id in" => array(1, 2, 3, 5)),
			"order" => "Channel.id" )
		);
	}

/**
 * add method
 *
 * @return void
 */
	public function add($idProduccionPartidos = null) {
	
		$this->loadModel("ProduccionPartidosEvento");
		if (!$this->ProduccionPartidosEvento->exists($idProduccionPartidos)) {

			$this->Session->setFlash('Ocurrio un problema intentelo nuevamente', 'msg_fallo');
			return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
		}

		if(empty($idProduccionPartidos))
		{
			$this->Session->setFlash('Ocurrio un problema intentelo nuevamente', 'msg_fallo');
			return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
		}

		$dataPartido = $this->ProduccionPartidosEvento->find("first", array("conditions"=> array("ProduccionPartidosEvento.id"=>$idProduccionPartidos)));
		/*$senalesTransmision = $this->obtSenales();
		$this->set("senalesTransmision", $senalesTransmision);*/
		$dataPartido["ProduccionPartidosEvento"]["fecha_partido"] = implode("/",array_reverse(explode("-",$dataPartido["ProduccionPartidosEvento"]["fecha_partido"])));
		$dataPartido["ProduccionPartidosEvento"]["hora_inicio_partido"] = substr($dataPartido["ProduccionPartidosEvento"]["hora_inicio_partido"],0,5);

		$senalesTransmision = $this->obtSenales();

		$this->set("senalesTransmision", $senalesTransmision);
		$this->set("data", $dataPartido);
		$this->set("idProduccionPartido", $idProduccionPartidos);
		$this->set("operadoresMcr", $this->trabajadoresCargos(array(88)));
		$this->set("operadoresContinuidad", $this->trabajadoresCargos(array(36,37)));
		//$this->set("senalesTransmision", $senalesTransmision);

		if ($this->request->is('post')) {
			$this->ProduccionPartidosTransmisione->create();

			$this->request->data["ProduccionPartidosTransmisione"]["operador_mcr"] = serialize($this->request->data["ProduccionPartidosTransmisione"]["operador_mcr"]);
			$this->request->data["ProduccionPartidosTransmisione"]["operador_continuidad"] = serialize($this->request->data["ProduccionPartidosTransmisione"]["operador_continuidad"]);
			//$this->request->data["ProduccionPartidosTransmisione"]["senales"] = serialize($this->request->data["ProduccionPartidosTransmisione"]["senales"]);
			$this->request->data["ProduccionPartidosTransmisione"]["fecha_transmision"] = implode("-", array_reverse(explode("/",$this->request->data["ProduccionPartidosTransmisione"]["fecha_transmision"])));
			$this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"],0,5);
			$this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"],0,5);
			$this->request->data["ProduccionPartidosTransmisione"]["estado"] = 1;

			$this->request->data["ProduccionPartidosEvento"]["id"] = $this->request->data["ProduccionPartidosTransmisione"]["produccion_partidos_evento_id"];
			$this->request->data["ProduccionPartidosEvento"]["estado_produccion"] = $this->obtEstadoEvento($this->request->data["ProduccionPartidosTransmisione"]["produccion_partidos_evento_id"]);

			if ($this->ProduccionPartidosEvento->saveAssociated($this->request->data, array('deep' => true))) {
				$this->Session->setFlash('Registrado correctamente', 'msg_exito');
				return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error no se a podido registrar la información', 'msg_fallo');
				return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
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

		$this->loadModel("ProduccionPartidosEvento");

		$idTransmision = $this->ProduccionPartidosTransmisione->find("list",array("fields"=>"ProduccionPartidosTransmisione.id","conditions"=> array("ProduccionPartidosTransmisione.produccion_partidos_evento_id"=> $id)));			
		$dataPartido = $this->ProduccionPartidosEvento->find("first", array("conditions"=> array("ProduccionPartidosEvento.id"=>$id)));

		if (!$this->ProduccionPartidosTransmisione->exists($idTransmision)) {
			$this->Session->setFlash('Ocurrio un problema intentelo nuevamente', 'msg_fallo');
			return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
		}

		if ($this->request->is(array('post', 'put'))) {
			
			$this->request->data["ProduccionPartidosTransmisione"]["operador_mcr"] = serialize($this->request->data["ProduccionPartidosTransmisione"]["operador_mcr"]);
			$this->request->data["ProduccionPartidosTransmisione"]["operador_continuidad"] = serialize($this->request->data["ProduccionPartidosTransmisione"]["operador_continuidad"]);
			//$this->request->data["ProduccionPartidosTransmisione"]["senales"] = serialize($this->request->data["ProduccionPartidosTransmisione"]["senales"]);
			$this->request->data["ProduccionPartidosTransmisione"]["fecha_transmision"] = implode("-", array_reverse(explode("/",$this->request->data["ProduccionPartidosTransmisione"]["fecha_transmision"])));
			$this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"],0,5);
			$this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"],0,5);
			
			if ($this->ProduccionPartidosTransmisione->save($this->request->data)) {				
				$this->Session->setFlash('Registrado correctamente', 'msg_exito');
				return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));

			} else {
				$this->Session->setFlash('Ocurrio un error no se a podido registrar la información', 'msg_fallo');
				return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('ProduccionPartidosTransmisione.' . $this->ProduccionPartidosTransmisione->primaryKey => $idTransmision),"recursive"=>2);
			$this->request->data = $this->ProduccionPartidosTransmisione->find('first', $options);
		}

		$dataPartido["ProduccionPartidosEvento"]["fecha_partido"] = implode("/",array_reverse(explode("-",$this->request->data["ProduccionPartidosEvento"]["fecha_partido"])));
		$dataPartido["ProduccionPartidosEvento"]["hora_inicio_partido"] = substr($this->request->data["ProduccionPartidosEvento"]["hora_inicio_partido"],0,5);
		
		$this->request->data["ProduccionPartidosTransmisione"]["fecha_transmision"] = implode("/", array_reverse(explode("-",$this->request->data["ProduccionPartidosTransmisione"]["fecha_transmision"])));
		$this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"],0,5);
		$this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"],0,5);
		$this->request->data["ProduccionPartidosTransmisione"]["hora_transmision_gmt"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_transmision_gmt"],0,5);
		$this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision_gmt"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision_gmt"],0,5);
		
		$this->set("operadoresMcr", $this->trabajadoresCargos(array(88)));
		$this->set("operadoresContinuidad", $this->trabajadoresCargos(array(36,37)));
//		$this->set("senalesTransmision", $this->obtSenales());

		$this->set("idTransmision", $idTransmision);
		$this->set("data", $dataPartido);
		$this->set("seleccionados", $this->request->data["ProduccionPartidosTransmisione"]);

		$produccionPartidosEventos = $this->ProduccionPartidosTransmisione->ProduccionPartidosEvento->find('list');
		$this->set(compact('produccionPartidosEventos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ProduccionPartidosTransmisione->id = $id;
		if (!$this->ProduccionPartidosTransmisione->exists()) {
			throw new NotFoundException(__('Invalid produccion partidos transmisione'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ProduccionPartidosTransmisione->delete()) {
			$this->Session->setFlash(__('The produccion partidos transmisione has been deleted.'));
		} else {
			$this->Session->setFlash(__('The produccion partidos transmisione could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
