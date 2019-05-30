<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
/**
 * ProduccionPartidos Controller
 *
 * @property ProduccionPartido $ProduccionPartido
 * @property PaginatorComponent $Paginator
 */
class ProduccionPartidosController extends AppController {

	public $components = array('Paginator');

	public function index() {
		$this->layout = "angular";
	}

	public function iteracion($trabajadorSerializado)
	{
		$this->loadModel("Trabajadore");
		$nombreTrabajadores = $this->Trabajadore->find("all", array(
			"conditions"=>array("Trabajadore.estado"=>"Activo"),
			"fields"=>array("Trabajadore.id","Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.apellido_materno"),
			"recursive"=>-1
		));
			
		$trabajadores = "";
		if(!empty($nombreTrabajadores))
		{
			foreach ($nombreTrabajadores as $nombreTrabajadores)
			{
				$trabajadores[$nombreTrabajadores["Trabajadore"]["id"]] = $nombreTrabajadores["Trabajadore"]["nombre"] . ' ' . $nombreTrabajadores["Trabajadore"]["apellido_paterno"] . ' ' . $nombreTrabajadores["Trabajadore"]["apellido_materno"];
			}
		}

		$trabajadorDeserealizado = unserialize($trabajadorSerializado);

		for ($i = 0; $i <= count($trabajadorDeserealizado) - 1; $i++) {
			$produccionPartidosCdfJson[] = $trabajadores[$trabajadorDeserealizado[$i]];
		}
		return $produccionPartidosCdfJson;
	}

	public function listaPartidos()
	{
		$this->autoRender = false;
		$this->response->type("json");

		//if($this->params->isAjax == 1)
		//{
			$produccionPartidosCdf = $this->ProduccionPartido->find("all", array(
				"conditions"=>array("ProduccionPartido.estado" =>1)
			));

			$produccionPartidosCdfJson = "";
			foreach ($produccionPartidosCdf as  $produccionPartidos) {

				$produccionPartidosCdfJson[] = array(
					"id"=>$produccionPartidos["ProduccionPartido"]["id"],
					"productor"=>implode(", ", $this->iteracion($produccionPartidos["ProduccionPartido"]["productor"])),
					"asistenteProduccion"=>implode(", ", $this->iteracion($produccionPartidos["ProduccionPartido"]["asist_produccion"])),
					"relator"=>implode(", ", $this->iteracion($produccionPartidos["ProduccionPartido"]["relator"])),
					"comentarista"=>implode(", ", $this->iteracion($produccionPartidos["ProduccionPartido"]["comentarista"])),
					"periodistaCancha"=>implode(", ", $this->iteracion($produccionPartidos["ProduccionPartido"]["periodista_cancha"])),
					"operadorTrackvision"=>implode(", ", $this->iteracion($produccionPartidos["ProduccionPartido"]["operador_trackvision"])),
					"estadoPartido"=>$produccionPartidos["ProduccionPartido"]["estado_partido"],
					"estado"=>  $produccionPartidos["ProduccionPartido"]["estado"],
					"created" => $produccionPartidos["ProduccionPartido"]["created"],
				);
			}
		//}
		return json_encode($produccionPartidosCdfJson);
	}

	public function view($id = null) {
		if (!$this->ProduccionPartido->exists($id)) {
			throw new NotFoundException(__('Invalid produccion partido'));
		}
		$options = array('conditions' => array('ProduccionPartido.' . $this->ProduccionPartido->primaryKey => $id));		
		$this->set('produccionPartido', $this->ProduccionPartido->find('first', $options));
	}

	public function trabajadoresCargos($idCargos)
	{
		$this->loadModel("Trabajadore");
		$this->loadModel("ProduccionNombreRostro");	

		$cargosTrabajadores  = $this->Trabajadore->find("all", array(
			"conditions"=>array("Trabajadore.cargo_id"=>$idCargos, 
				"Trabajadore.estado"=>"Activo",
				"Trabajadore.id !=" => array()),
			"fields"=>array(
				"Trabajadore.id",
				"Trabajadore.nombre",
				"Trabajadore.apellido_paterno",
				"Trabajadore.apellido_materno",
				"Trabajadore.cargo_id"
			),
			"recursive"=>-1
		));
		$nombreRostros = $this->ProduccionNombreRostro->find("list",array( 
			"conditions"=>array("tipo_relacion"=>'T'), 
			"fields"=>array("relacion_id","nombre")
		));
		
		$cargosTrabajadoresArray = "";

		foreach($cargosTrabajadores as $cargosTrabajadore)
		{
			$nombre = (isset($nombreRostros[$cargosTrabajadore["Trabajadore"]["id"]]))? $nombreRostros[$cargosTrabajadore["Trabajadore"]["id"]]: strtok($cargosTrabajadore["Trabajadore"]["nombre"]," ").' '.$cargosTrabajadore["Trabajadore"]["apellido_paterno"];
			$cargosTrabajadoresArray[$cargosTrabajadore["Trabajadore"]["id"]] = mb_strtoupper($nombre); 

		}
		
		return $cargosTrabajadoresArray;
	}

	public function trabajadoresEmpresaID($ids){
		//$serv = new ServiciosController();
		$this->loadModel("Company");
		$this->loadModel("ProduccionNombreRostro");

		$nombreCompany = $this->Company->find("all", array(
			"conditions"=>array( 
				"Company.id"=> $ids),
			"fields"=>array("Company.id","Company.nombre"),
			"recursive"=>-1
		));
		$nombreRostros = $this->ProduccionNombreRostro->find("list",array( 
			"conditions"=>array("tipo_relacion"=>'E'), 
			"fields"=>array("relacion_id","nombre")
		));

		if(!empty($nombreCompany)){
			foreach ($nombreCompany as $company) {
				
				$nombre = (isset($nombreRostros[$company["Company"]["id"]]))? $nombreRostros[$company["Company"]["id"]] : $company["Company"]["nombre"];
				$honorarios[$company["Company"]["id"]] = $nombre; //$serv->capitalize($nombre);
			}
		}else{
			$honorarios = array();
		}
		return $honorarios;
	}

	public function trabajadoresEmpresaTipo($tipoContacto){
		
		$this->loadModel("Company");
		$this->loadModel("ProduccionContacto");
		$this->loadModel("ProduccionNombreRostro");

		$nombresEmpresas = $this->ProduccionContacto->find("all", array(
			"conditions"=> array("ProduccionContacto.estado"=>1,
				"ProduccionContacto.tipo_contacto"=> $tipoContacto
				)
			));
		
		$nombreRostros = $this->ProduccionNombreRostro->find("list",array( 
			"conditions"=>array("tipo_relacion"=>'E'), 
			"fields"=>array("relacion_id","nombre")
		));

		if(!empty($nombresEmpresas)){
			foreach ($nombresEmpresas as $company) {
				
				$nombre = (isset($nombreRostros[$company["ProduccionContacto"]["id"]]))? $nombreRostros[$company["ProduccionContacto"]["id"]] : $company["ProduccionContacto"]["nombre"];
				$honorarios[$company["ProduccionContacto"]["id"]] = $nombre;
			}
		}else{
			$honorarios = array();
		}
		
		return $honorarios;
	}

	public function obtEstadoEvento($id){
		$this->loadModel("ProduccionPartidosEvento");
		$evento = $this->ProduccionPartidosEvento->find("first", array("conditions"=>array("ProduccionPartidosEvento.id"=>$id)));
		$estado = 1;
		if(!empty($evento)){
			if($evento["ProduccionPartidosTransmisione"]["estado"]==1 && $evento["ProduccionPartidosChilefilm"]["estado"]==1){
				$estado = 2;
			}
		}else{
			$estado = 0;	
		}
		return $estado;
	}

	public function obtVestuario($tipoVestuario){
		$this->loadModel("ProduccionPartidosVestuario");
		$vestuariosList = array();
		$vestuarios = $this->ProduccionPartidosVestuario->find("list",array(
			"fields"=>array("ProduccionPartidosVestuario.id", "ProduccionPartidosVestuario.nombre"),
			"conditions"=>array("ProduccionPartidosVestuario.estado"=>1,
				"ProduccionPartidosVestuario.tipo_vestuario"=>$tipoVestuario),
			));
		
		if(!empty($vestuarios))
			$vestuariosList = $vestuarios;
		
		return $vestuariosList;
	}

	public function add($idProduccionPartidos = null) {

		$this->acceso();

		$this->loadModel("ProduccionPartidosEvento");
		$this->loadModel("ProduccionPartidosVestuario");
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
		$this->set("idProduccionPartido", $idProduccionPartidos);

		// trabajadores x cargo
		$productoresTrab = $this->trabajadoresCargos(array(102,143,139));
		foreach ($productoresTrab as $key => $productorT) { $productores["T:".$key] = $productorT; }
		$asistentesTrab = $this->trabajadoresCargos(array(136,145,147,150));
		foreach ($asistentesTrab as $key => $asistenteT) { $asistentes["T:".$key] = $asistenteT; }
		$coordinadoresTrab = $this->trabajadoresCargos(array(33,63));
		foreach ($coordinadoresTrab as $key => $coordinadorT) { $coordinadores["T:".$key] = $coordinadorT; }						
		$relatoresTrab = $this->trabajadoresCargos(array(104));
		foreach ($relatoresTrab as $key => $relatorT) { $relatores["T:".$key] = $relatorT; }
		$comentaristaTrab = $this->trabajadoresCargos(array(28,  89,90,91,92,93,123,140,146,151,168));
		foreach ($comentaristaTrab as $key => $comentaristaT) { $comentarista["T:".$key] = $comentaristaT; }
		$periodistaTrab = $this->trabajadoresCargos(array(89,90,91,92,93,123,140,146,151,168));
		foreach ($periodistaTrab as $key => $periodistaT) { $periodista["T:".$key] = $periodistaT; }
		$periodistaVisitaTrab = $this->trabajadoresCargos(array(89,90,91,92,93,123,140,146,151,168));
		foreach ($periodistaVisitaTrab as $key => $periodistaVisitaT) { $periodistaVisita["T:".$key] = $periodistaVisitaT; }

		//empresas

		$coordinadoresEmp = $this->trabajadoresEmpresaTipo('coordinador-cdf');
		//$coordinadoresEmp = $this->trabajadoresEmpresaID(array(364)); 
		foreach ($coordinadoresEmp as $key => $coordinadorE) { $coordinadores["E:".$key] = $coordinadorE; }

		$relatoresEmp = $this->trabajadoresEmpresaTipo('relator-cdf');
		//$relatoresEmp = $this->trabajadoresEmpresaID(array(1637,429,642,913,912,302));		// ELIMINADO 1654 HC
		foreach ($relatoresEmp as $key => $relatorE) { $relatores["E:".$key] = $relatorE; }

		$comentaristaEmp = $this->trabajadoresEmpresaTipo('comentarista-cdf');
		//$comentaristaEmp = $this->trabajadoresEmpresaID(array(255,295,267,1172,698,112));
		foreach ($comentaristaEmp as $key => $comentaristaE) { $comentarista["E:".$key] = $comentaristaE; }	

		$periodistaEmp = $this->trabajadoresEmpresaTipo('periodista-cdf');
		//$periodistaEmp = $this->trabajadoresEmpresaID(array(1835,434,368,1937));
		foreach ($periodistaEmp as $key => $periodistaE) { $periodista["E:".$key] = $periodistaE; }

		$periodistaVisitaEmp = $this->trabajadoresEmpresaTipo('periodista-cdf');
		//$periodistaVisitaEmp = $this->trabajadoresEmpresaID(array(1835,434,368,1937));
		foreach ($periodistaVisitaEmp as $key => $periodistaVisitaE) { $periodistaVisita["E:".$key] = $periodistaVisitaE; }

		$operadorTrackVisionEmp = $this->trabajadoresEmpresaTipo('operador-cdf');
		foreach ($operadorTrackVisionEmp as $key => $peradorTrackVisionE) { $peradorTrackVision["E:".$key] = $peradorTrackVisionE; }

		$locutorEmp = $this->trabajadoresEmpresaTipo('locutor-cdf');
		foreach ($locutorEmp as $key => $locutorE) { $locutor["E:".$key] = $locutorE; }

		$musicalizadorEmp = $this->trabajadoresEmpresaTipo('musicalizador-cdf');
		foreach ($musicalizadorEmp as $key => $musicalizadorE) { $musicalizador["E:".$key] = $musicalizadorE; }

		//solo empresas
		$this->set("operadorTrackVision", $peradorTrackVision);
		$this->set("locutor", $locutor);
		$this->set("musicalizador", $musicalizador);

		$this->set("relator", $relatores);
		$this->set("comentarista", $comentarista);
		$this->set("periodista",  $periodista);
		$this->set("periodistaVisita",  $periodistaVisita);

		$this->set("productores", $productores);
		$this->set("asistenteProduccion", $asistentes);
		$this->set("coordinadorPeriodistico", $coordinadores);

		$ternoVestuarios = $this->ProduccionPartidosVestuario->find("list", array("fields"=>array("id","nombre"),"conditions"=>array("tipo_vestuario"=>"terno")));
		$camisaVestuarios = $this->ProduccionPartidosVestuario->find("list", array("fields"=>array("id","nombre"),"conditions"=>array("tipo_vestuario"=>"camisa")));
		$corbataVestuarios = $this->ProduccionPartidosVestuario->find("list", array("fields"=>array("id","nombre"),"conditions"=>array("tipo_vestuario"=>"corbata")));	
		//vestuario
		$this->set(compact("ternoVestuarios","camisaVestuarios","corbataVestuarios"));

		if ($this->request->is('post')) {

			$this->ProduccionPartido->create();
			$this->request->data["ProduccionPartido"]["productor"] = serialize($this->request->data["ProduccionPartido"]["productor"]);
			$this->request->data["ProduccionPartido"]["asist_produccion"] = serialize($this->request->data["ProduccionPartido"]["asist_produccion"]);
			$this->request->data["ProduccionPartido"]["relator"] = serialize($this->request->data["ProduccionPartido"]["relator"]);
			$this->request->data["ProduccionPartido"]["comentarista"] = serialize($this->request->data["ProduccionPartido"]["comentarista"]);
			$this->request->data["ProduccionPartido"]["periodista"] = serialize($this->request->data["ProduccionPartido"]["periodista"]);
			$this->request->data["ProduccionPartido"]["periodista_visita"] = serialize($this->request->data["ProduccionPartido"]["periodista_visita"]);
			$this->request->data["ProduccionPartido"]["coordinador_periodistico"] = serialize($this->request->data["ProduccionPartido"]["coordinador_periodistico"]);
			$this->request->data["ProduccionPartido"]["operador_trackvision"] = serialize($this->request->data["ProduccionPartido"]["operador_trackvision"]);			
			$this->request->data["ProduccionPartido"]["locutor"] = serialize($this->request->data["ProduccionPartido"]["locutor"]);
			$this->request->data["ProduccionPartido"]["musicalizador"] = serialize($this->request->data["ProduccionPartido"]["musicalizador"]);
			$this->request->data["ProduccionPartido"]["estado"] = 1;
			
			$this->request->data["ProduccionPartidosEvento"]["id"] = $idProduccionPartidos;
			$this->request->data["ProduccionPartidosEvento"]["estado_produccion"] = $this->obtEstadoEvento($idProduccionPartidos);
			//pr($this->request->data);exit;
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

	public function edit($id = null) {

		$this->acceso();

		$this->loadModel("ProduccionPartidosEvento");
		$this->loadModel("ProduccionPartidosVestuario");
		$this->loadModel("Regione");
		
		$dataPartido = $this->ProduccionPartidosEvento->find("first", array("conditions"=> array("ProduccionPartidosEvento.id"=>$id), "recursive"=>0));
		$dataPartido["ProduccionPartidosEvento"]["fecha_partido"] = implode("/",array_reverse(explode("-",$dataPartido["ProduccionPartidosEvento"]["fecha_partido"])));
		$dataPartido["ProduccionPartidosEvento"]["hora_partido"] = substr($dataPartido["ProduccionPartidosEvento"]["hora_partido"],0,5);

		$regiones = $this->Regione->find('list', array("fields"=> array("id", "region_ordinal")));
		$region = "";
		$region[] = $regiones[$dataPartido["Estadio"]["regione_id"]];
		$region[] = ($dataPartido["Estadio"]["regione_id"] != 7) ? ' Región.' : '.';
		$dataPartido["Estadio"]["region_nombre"] = mb_strtoupper(implode("",$region));
		
		$this->set("data", $dataPartido);

		$idResponsablesCDF = $this->ProduccionPartido->find("list",array("conditions"=> array("ProduccionPartido.produccion_partidos_evento_id"=> $id)));
		
		if (!$this->ProduccionPartido->exists($idResponsablesCDF)) {
			$this->Session->setFlash('Ocurrio un erro intentelo nuevamente', 'msg_fallo');
			return $this->redirect(array('action' => 'index'));
		}
		
		// trabajadores x cargo
		$productoresTrab = $this->trabajadoresCargos(array(102,143,139));
		foreach ($productoresTrab as $key => $productorT) { $productores["T:".$key] = $productorT; }
		$asistentesTrab = $this->trabajadoresCargos(array(136,145,147,150));
		foreach ($asistentesTrab as $key => $asistenteT) { $asistentes["T:".$key] = $asistenteT; }
		$coordinadoresTrab = $this->trabajadoresCargos(array(33,63));
		foreach ($coordinadoresTrab as $key => $coordinadorT) { $coordinadores["T:".$key] = $coordinadorT; }						
		$relatoresTrab = $this->trabajadoresCargos(array(104));
		foreach ($relatoresTrab as $key => $relatorT) { $relatores["T:".$key] = $relatorT; }
		$comentaristaTrab = $this->trabajadoresCargos(array(28,  89,90,91,92,93,123,140,146,151,168));
		foreach ($comentaristaTrab as $key => $comentaristaT) { $comentarista["T:".$key] = $comentaristaT; }
		$periodistaTrab = $this->trabajadoresCargos(array(89,90,91,92,93,123,140,146,151,168));
		foreach ($periodistaTrab as $key => $periodistaT) { $periodista["T:".$key] = $periodistaT; }
		$periodistaVisitaTrab = $this->trabajadoresCargos(array(89,90,91,92,93,123,140,146,151,168));
		foreach ($periodistaVisitaTrab as $key => $periodistaVisitaT) { $periodistaVisita["T:".$key] = $periodistaVisitaT; }

		//empresas
		$coordinadoresEmp = $this->trabajadoresEmpresaTipo('coordinador-cdf');
		//$coordinadoresEmp = $this->trabajadoresEmpresaID(array(364)); 
		foreach ($coordinadoresEmp as $key => $coordinadorE) { $coordinadores["E:".$key] = $coordinadorE; }

		$relatoresEmp = $this->trabajadoresEmpresaTipo('relator-cdf');
		//$relatoresEmp = $this->trabajadoresEmpresaID(array(1637,429,642,913,912,302));		// ELIMINADO 1654 HC
		foreach ($relatoresEmp as $key => $relatorE) { $relatores["E:".$key] = $relatorE; }

		$comentaristaEmp = $this->trabajadoresEmpresaTipo('comentarista-cdf');
		//$comentaristaEmp = $this->trabajadoresEmpresaID(array(255,295,267,1172,698,112));
		foreach ($comentaristaEmp as $key => $comentaristaE) { $comentarista["E:".$key] = $comentaristaE; }	

		$periodistaEmp = $this->trabajadoresEmpresaTipo('periodista-cdf');
		//$periodistaEmp = $this->trabajadoresEmpresaID(array(1835,434,368,1937));
		foreach ($periodistaEmp as $key => $periodistaE) { $periodista["E:".$key] = $periodistaE; }

		$periodistaVisitaEmp = $this->trabajadoresEmpresaTipo('periodista-cdf');
		//$periodistaVisitaEmp = $this->trabajadoresEmpresaID(array(1835,434,368,1937));
		foreach ($periodistaVisitaEmp as $key => $periodistaVisitaE) { $periodistaVisita["E:".$key] = $periodistaVisitaE; }

		$operadorTrackVisionEmp = $this->trabajadoresEmpresaTipo('operador-cdf');
		foreach ($operadorTrackVisionEmp as $key => $peradorTrackVisionE) { $peradorTrackVision["E:".$key] = $peradorTrackVisionE; }

		$locutorEmp = $this->trabajadoresEmpresaTipo('locutor-cdf');
		foreach ($locutorEmp as $key => $locutorE) { $locutor["E:".$key] = $locutorE; }

		$musicalizadorEmp = $this->trabajadoresEmpresaTipo('musicalizador-cdf');
		foreach ($musicalizadorEmp as $key => $musicalizadorE) { $musicalizador["E:".$key] = $musicalizadorE; }

		//solo empresas
		$this->set("operadorTrackVision", $peradorTrackVision);
		$this->set("locutor", $locutor);
		$this->set("musicalizador", $musicalizador);

		$this->set("relator", $relatores);
		$this->set("comentarista", $comentarista);
		$this->set("periodista",  $periodista);
		$this->set("periodistaVisita",  $periodistaVisita);

		$this->set("productores", $productores);
		$this->set("asistenteProduccion", $asistentes);
		$this->set("coordinadorPeriodistico", $coordinadores);

		//vestuario	
		$ternoVestuarios = $this->ProduccionPartidosVestuario->find("list", array("fields"=>array("id","nombre"),"conditions"=>array("tipo_vestuario"=>"terno")));
		$camisaVestuarios = $this->ProduccionPartidosVestuario->find("list", array("fields"=>array("id","nombre"),"conditions"=>array("tipo_vestuario"=>"camisa")));
		$corbataVestuarios = $this->ProduccionPartidosVestuario->find("list", array("fields"=>array("id","nombre"),"conditions"=>array("tipo_vestuario"=>"corbata")));			
		$this->set(compact("ternoVestuarios","camisaVestuarios","corbataVestuarios"));

		$options = array('conditions' => array('ProduccionPartido.' . $this->ProduccionPartido->primaryKey => $idResponsablesCDF), "recursive"=>-1);
		$editables = $this->ProduccionPartido->find('first', $options);
		//pr($editables);
		$this->set("id", $editables["ProduccionPartido"]["id"]);

		//solo empresas
		$this->set("operadorTrackvisionSeleccionado", (!empty($editables["ProduccionPartido"]["operador_trackvision"]))?unserialize($editables["ProduccionPartido"]["operador_trackvision"]):array());
		$this->set("locutorSeleccionado", (!empty($editables["ProduccionPartido"]["locutor"]))? unserialize($editables["ProduccionPartido"]["locutor"]) : array());
		$this->set("musicalizadorSeleccionado", (!empty($editables["ProduccionPartido"]["musicalizador"]))? unserialize($editables["ProduccionPartido"]["musicalizador"]) : array());
		
		// trabajadores y empresas		
		$this->set("relatorSeleccionado", (!empty($editables["ProduccionPartido"]["relator"]))? unserialize($editables["ProduccionPartido"]["relator"]):array());
		$this->set("comentaristaSeleccionado", (!empty($editables["ProduccionPartido"]["comentarista"]))?unserialize($editables["ProduccionPartido"]["comentarista"]):array());
		$this->set("periodistaSeleccionado", (!empty($editables["ProduccionPartido"]["periodista"]))?unserialize($editables["ProduccionPartido"]["periodista"]):array());	
		$this->set("periodistaVisitaSeleccionado", (!empty($editables["ProduccionPartido"]["periodista_visita"]))?unserialize($editables["ProduccionPartido"]["periodista_visita"]):array());	
		$this->set("productoresSeleccionado", (!empty($editables["ProduccionPartido"]["productor"]))? unserialize($editables["ProduccionPartido"]["productor"]) : array());
		$this->set("asistenteProduccionSeleccionado", (!empty($editables["ProduccionPartido"]["asist_produccion"]))? unserialize($editables["ProduccionPartido"]["asist_produccion"]):array());
		$this->set("coordinadorPeriodisticoSeleccionado", (!empty($editables["ProduccionPartido"]["coordinador_periodistico"]))? unserialize($editables["ProduccionPartido"]["coordinador_periodistico"]):array());
		
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data["ProduccionPartido"]["productor"] = serialize($this->request->data["ProduccionPartido"]["productor"]);
			$this->request->data["ProduccionPartido"]["asist_produccion"] = serialize($this->request->data["ProduccionPartido"]["asist_produccion"]);
			$this->request->data["ProduccionPartido"]["relator"] = serialize($this->request->data["ProduccionPartido"]["relator"]);
			$this->request->data["ProduccionPartido"]["comentarista"] = serialize($this->request->data["ProduccionPartido"]["comentarista"]);
			$this->request->data["ProduccionPartido"]["periodista"] = serialize($this->request->data["ProduccionPartido"]["periodista"]);
			$this->request->data["ProduccionPartido"]["periodista_visita"] = serialize($this->request->data["ProduccionPartido"]["periodista_visita"]);
			$this->request->data["ProduccionPartido"]["operador_trackvision"] = serialize($this->request->data["ProduccionPartido"]["operador_trackvision"]);
			$this->request->data["ProduccionPartido"]["musicalizador"] = serialize($this->request->data["ProduccionPartido"]["musicalizador"]);
			$this->request->data["ProduccionPartido"]["locutor"] = serialize($this->request->data["ProduccionPartido"]["locutor"]);
			$this->request->data["ProduccionPartido"]["coordinador_periodistico"] = serialize($this->request->data["ProduccionPartido"]["coordinador_periodistico"]);
			
			if ($this->ProduccionPartido->save($this->request->data)) {

				CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->ProduccionPartido->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") ); 

				$this->Session->setFlash('Registrado correctamente', 'msg_exito');
				return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error no se a podido registrar la información', 'msg_fallo');
				return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('ProduccionPartido.' . $this->ProduccionPartido->primaryKey => $idResponsablesCDF),"recursive"=> 2);
			$this->request->data = $this->ProduccionPartido->find('first', $options);
		}
		
		/*$this->request->data["ProduccionPartidosEvento"]["fecha_partido"] = implode("/",array_reverse(explode("-",$this->request->data["ProduccionPartidosEvento"]["fecha_partido"])));
		$this->request->data["ProduccionPartidosEvento"]["hora_partido"] = substr($this->request->data["ProduccionPartidosEvento"]["hora_partido"],0,5);
		$this->set("data", $this->request->data);*/
	}

	public function delete_produccion_partidos($id = null) {
		$this->layout = "ajax";

		if (!$this->ProduccionPartido->exists($id)) {
			$this->Session->setFlash('Ocurrio un erro intentelo nuevamente', 'msg_fallo');
			return $this->redirect(array('action' => 'index'));
		}
			$this->request->data["ProduccionPartido"]["id"] = $id;
			$this->request->data["ProduccionPartido"]["estado"] = 0;

			if ($this->ProduccionPartido->save($this->request->data)) {

				CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->ProduccionPartido->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") ); 
				
				$this->Session->setFlash('El registro se elimino correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de eliminar el registro', 'msg_fallo');
			}
	}

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
