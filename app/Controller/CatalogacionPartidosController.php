<?php
App::uses('AppController', 'Controller');
/**
 * CatalogacionIngestas Controller
 *
 * @property CatalogacionIngestas $CatalogacionIngestas
 * @property PaginatorComponent $Paginator
 */
class CatalogacionPartidosController extends AppController {

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
		//$this->Ingesta->recursive = 0;
		//$this->set('ingestas', $this->Paginator->paginate());
	}

	public function lista_media_json()
	{
		$this->layout = "ajax";
		$this->response->type('json');

		$listaMedias = $this->Ingesta->find('all', array(
			"recursive"=>-1
		));

		$this->loadModel("Equipo");
		$this->loadModel("Campeonato");
		$this->loadModel("Copia");
		$this->loadModel("Almacenamiento");
		$this->loadModel("Soporte");
		$this->loadModel("Tiempo");

		$equipos = $this->Equipo->find("list", array("fields"=>array("Equipo.id", "Equipo.nombre")));
		$campeonato = $this->Campeonato->find("list", array("fields"=>array("Campeonato.id", "Campeonato.nombre")));
		$copia = $this->Copia->find("list", array("fields"=>array("Copia.id", "Copia.copia")));
		$almacenamiento = $this->Almacenamiento->find("list", array("fields"=>array("Almacenamiento.id", "Almacenamiento.lugar")));
		$soporte = $this->Soporte->find("list", array("fields"=>array("Soporte.id", "Soporte.nombre")));
		$tiempo = $this->Tiempo->find("list", array("fields"=>array("Tiempo.id", "Tiempo.nombre")));
		
		$listaMediaJson = "";

		foreach($listaMedias as $listaMedia)
		{
			$listaMediaJson[] = array(
				"Id"=>$listaMedia["Ingesta"]["id"],
				"Numero"=>$listaMedia["Ingesta"]["numero"],
				"EquipoLocal"=>$equipos[$listaMedia["Ingesta"]["equipo_local"]],
				"EquipoVisita"=>$equipos[$listaMedia["Ingesta"]["equipo_visita"]],
				"Campeonato"=>$campeonato[$listaMedia["Ingesta"]["campeonato_id"]],
				"Copia"=>$copia[$listaMedia["Ingesta"]["copia_id"]],
				"Almacenamiento"=>$almacenamiento[$listaMedia["Ingesta"]["almacenamiento_id"]],
				"Soporte"=>$soporte[$listaMedia["Ingesta"]["soporte_id"]],
				"Tiempo"=>$tiempo[$listaMedia["Ingesta"]["tiempo_id"]],
				"Observacion"=>$listaMedia["Ingesta"]["observacion"],
				"FechaPartido"=>$listaMedia["Ingesta"]["fecha_partido"],
				"FechaTorneo"=>$listaMedia["Ingesta"]["fecha_torneo"],
				"User"=>$listaMedia["Ingesta"]["user_id"],
				"FechaCreacion"=>$listaMedia["Ingesta"]["created"]
			);
		}		
		//pr($listaMediaJson);exit;
		$this->set('listaMediaJson', $listaMediaJson);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {

		$this->layout = "angular";
		//pr($this->Session->Read());
		//exit;

	}

/**
 * add method
 *
 * @return void
 */
	public function add_media() {
		if ($this->request->is('post')) {
			$this->Ingesta->create();
			if ($this->Ingesta->save($this->request->data)) {
				$this->Session->setFlash(__('Se registro correctamente'), "msg_exito");
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo registrar'), "msg_fallo");
			}
		}
		
		$this->loadModel("Equipo");
		$equipos = $this->Equipo->find('list', array("fields"=>array("Equipo.id", "Equipo.nombre")));
		$campeonatos = $this->Ingesta->Campeonato->find('list', array("fields"=>array("Campeonato.id", "Campeonato.nombre")));
		$copias = $this->Ingesta->Copia->find('list', array("fields"=>array("Copia.id", "Copia.copia")));
		$almacenamientos = $this->Ingesta->Almacenamiento->find('list', array("fields"=>array("Almacenamiento.id", "Almacenamiento.lugar")));
		$soportes = $this->Ingesta->Soporte->find('list', array("fields"=>array("Soporte.id", "Soporte.nombre")));
		$tiempos = $this->Ingesta->Tiempo->find('list', array("fields"=>array("Tiempo.id", "Tiempo.nombre")));
		$this->set("equipos", $equipos);
		$this->set(compact('campeonatos', 'copias', 'almacenamientos', 'soportes', 'tiempos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->layout = "angular";
		$this->CatalogacionPartido->id = $id;
		if(!$this->CatalogacionPartido->exists()){
			$this->Session->setFlash('El medio no existe, por favor vuelva a intentarlo', 'msg_fallo');
			return $this -> redirect(array("controller" => 'catalogacion_partidos', "action" => 'index'));
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
		$this->Ingesta->id = $id;
		if (!$this->Ingesta->exists()) {
			throw new NotFoundException(__('Invalid ingesta'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Ingesta->delete()) {
			$this->Session->setFlash(__('The ingesta has been deleted.'));
		} else {
			$this->Session->setFlash(__('The ingesta could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function add() {

		$this->layout = "angular";
		
	}

	public function procesar_maestro(){

		set_time_limit("100000");
		//$catalogacion = $this->CatalogacionPartido->find("all");
		//pr($catalogacion);exit;
		$this->autoRender = false;
		$this->loadModel("Equipo");
		$this->loadModel("Campeonato");
		$this->loadModel("Bloque");
		$this->loadModel("Soporte");
		$this->loadModel("Copia");
		$this->loadModel("Almacenamiento");
		$this->loadModel("Formato");
		$file = fopen(WWW_ROOT."files/ARCHIVO MAESTRO.csv","r");
		while(! feof($file))
		{
			$fila = fgetcsv($file,0, ";");
			empty($fila) ? "" : $archivo[] = $fila;
		}
		unset($archivo[0]);
		fclose($file);
		$file = fopen(WWW_ROOT."files/archivo programas.csv","r");
		while(! feof($file))
		{
			$fila = fgetcsv($file,0, ";");
			empty($fila) ? "" : $programas[] = $fila;
		}
		unset($programas[0]);
		$agrupaciones = array();
		$equipos = $this->Equipo->find("list", array("fields"=>array("Equipo.codigo", "Equipo.id")));
		$campeonatos = $this->Campeonato->find("list", array("fields"=>array("Campeonato.codigo","Campeonato.id")));
		$bloques = $this->Bloque->find("list", array("fields"=>array("Bloque.codigo", "Bloque.id")));
		$soportes = $this->Soporte->find("list", array("fields"=>array("Soporte.nombre", "Soporte.id")));
		$copiasQuery = $this->Copia->find("all", array("recursive"=>-1));
		foreach ($copiasQuery as $copia) {
			$copias[mb_strtoupper($copia["Copia"]["copia"])] = $copia["Copia"]["id"];
		}
		$almacenamientos = $this->Almacenamiento->find("list", array("fields"=>array("Almacenamiento.lugar","Almacenamiento.id")));

		// PROCESANDO PARTIDOS
		foreach ($archivo as $fila) {
			if(!empty($fila[1]) && !empty($fila[2]) && !empty($fila[4]) && !empty($fila[6]) && !empty($fila[7]) && !empty($fila[8]) && !empty($fila[5])){
				switch ($fila[10]) {
					case 'PEERDIDO':
					case 'PERDIDA' :
						$fila[10] = "PERDIDO";
						break;
				}
				($fila[12]=="XDCAM") ? $formato = 1 : $formato = 2;
				$codigo = "PF".mb_strtoupper($fila[1]).mb_strtoupper($fila[2]).$fila[8].((strlen($fila[7])==1) ? "0".$fila[7] : $fila[7]).((strlen($fila[6])==1) ? "0".$fila[6] : $fila[6]).mb_strtoupper($fila[4]).mb_strtoupper($fila[5])."_".mb_strtoupper($fila[13]);
				if(isset($agrupaciones[$fila[1]."-".$fila[2]."-".$fila[4]."-".$fila[6]."-".$fila[7]."-".$fila[8]."-".$fila[5]]))
				{					
					$agrupaciones[$fila[1]."-".$fila[2]."-".$fila[4]."-".$fila[6]."-".$fila[7]."-".$fila[8]."-".$fila[5]][] = array(
						"codigo"=>$codigo,
						"numero"=>$fila[0],
						"observacion"=>utf8_encode($fila[14]),
						"bloque_id"=>$bloques[$fila[13]],
						"soporte_id"=>$soportes[$fila[12]],
						"copia_id"=>$copias[$fila[9]],
						"almacenamiento_id"=>$almacenamientos[$fila[10]],
						"formato_id"=>$formato
					);

				}else
				{
					$agrupaciones[$fila[1]."-".$fila[2]."-".$fila[4]."-".$fila[6]."-".$fila[7]."-".$fila[8]."-".$fila[5]][] = array(
						"codigo"=>$codigo,
						"numero"=>$fila[0],
						"observacion"=>utf8_encode($fila[14]),
						"bloque_id"=>$bloques[$fila[13]],
						"soporte_id"=>$soportes[$fila[12]],
						"copia_id"=>$copias[$fila[9]],
						"almacenamiento_id"=>$almacenamientos[$fila[10]],
						"formato_id"=>$formato
					);
				}	
			}else{
				$incompletas[] = $fila;
			}
			
		}
		foreach ($agrupaciones as $ingesta => $ingestaMedia) {
			$ingestaArray = split("-", $ingesta);
			$codigo = "PF".mb_strtoupper($ingestaArray[0]).mb_strtoupper($ingestaArray[1]).$ingestaArray[5].((strlen($ingestaArray[4])==1) ? "0".$ingestaArray[4] : $ingestaArray[4]).((strlen($ingestaArray[3])==1) ? "0".$ingestaArray[3] : $ingestaArray[3]).mb_strtoupper($ingestaArray[2]).mb_strtoupper($ingestaArray[6]);
			$procesado[] = array(
				"CatalogacionPartido"=>array(
					"codigo"=>$codigo,
					"equipo_local"=>$equipos[$ingestaArray[0]],
					"equipo_visita"=>$equipos[$ingestaArray[1]],
					"fecha_partido"=>$ingestaArray[5]."-".((strlen($ingestaArray[4])==1) ? "0".$ingestaArray[4] : $ingestaArray[4])."-".((strlen($ingestaArray[3])==1) ? "0".$ingestaArray[3] : $ingestaArray[3]),
					"campeonato_id"=>$campeonatos[$ingestaArray[2]],
					"fecha_torneo"=>$ingestaArray[6]
				),
				"CatalogacionPartidosMedio"=>$ingestaMedia				
			);
		}
		($this->CatalogacionPartido->saveAll($procesado, array("deep"=>true))) ? pr("graba") : pr("no graba");
		//pr($camponatosMalos);
		exit;
		// PARTIDO PROCESADO

		// PROCESANDO PROGRAMAS

		foreach ($programas as $programa) {
			pr($programa);
		}
		//pr(count($procesado));
		//pr($procesado);
		exit;
	}

	public function catalogacion_partidos(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("Equipo");
		$this->loadModel("Campeonato");
		$this->loadModel("Bloque");
		$this->loadModel("Soporte");
		$this->loadModel("Copia");
		$this->loadModel("Almacenamiento");
		$this->loadModel("User");
		$equipos = $this->Equipo->find("list", array("fields"=>array("Equipo.id","Equipo.codigo")));
		$campeonatos = $this->Campeonato->find("list", array("fields"=>array("Campeonato.id","Campeonato.codigo")));
		$bloques = $this->Bloque->find("list", array("fields"=>array("Bloque.id","Bloque.codigo")));
		$soportes = $this->Soporte->find("list", array("fields"=>array("Soporte.id","Soporte.nombre")));
		$copiasQuery = $this->Copia->find("all", array("recursive"=>-1));
		foreach ($copiasQuery as $copia) {
			$copias[mb_strtoupper($copia["Copia"]["id"])] = $copia["Copia"]["copia"];
		}
		$almacenamientos = $this->Almacenamiento->find("list", array("fields"=>array("Almacenamiento.id","Almacenamiento.lugar")));
		$users = $this->User->find("list", array("fields"=>array("User.id", "User.nombre")));

		$catalogacionPartidos = array();
		$catalogacionPartidosQuery = $this->CatalogacionPartido->find("all", array(
			"recursive"=>-1
			)
		);
		if(!empty($catalogacionPartidosQuery)){
			foreach ($catalogacionPartidosQuery as $catalogacionPartido) {
				$fecha = new DateTime($catalogacionPartido["CatalogacionPartido"]["fecha_partido"]);
				$fechaCreacion = new DateTime($catalogacionPartido["CatalogacionPartido"]["created"]);
				$catalogacionPartidos[] = array(
					"id"=>$catalogacionPartido["CatalogacionPartido"]["id"],
					"codigo"=>$catalogacionPartido["CatalogacionPartido"]["codigo"],
					"equipo_local"=>mb_strtoupper($equipos[$catalogacionPartido["CatalogacionPartido"]["equipo_local"]]),
					"equipo_visita"=>mb_strtoupper($equipos[$catalogacionPartido["CatalogacionPartido"]["equipo_visita"]]),
					"fecha_partido"=>$fecha->format("c"),
					"campeonato"=>mb_strtoupper($campeonatos[$catalogacionPartido["CatalogacionPartido"]["campeonato_id"]]),
					"fecha_torneo"=>mb_strtoupper($catalogacionPartido["CatalogacionPartido"]["fecha_torneo"]),
					"observacion"=>mb_strtoupper($catalogacionPartido["CatalogacionPartido"]["observacion"]),
					"user"=>(isset($users[$catalogacionPartido["CatalogacionPartido"]["user_id"]]) ? mb_strtoupper($users[$catalogacionPartido["CatalogacionPartido"]["user_id"]]) : '')
				);
			}
		}
		return json_encode($catalogacionPartidos);
	}

	public function catalogacion_partido(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("Equipo");
		$this->loadModel("Campeonato");
		$this->loadModel("Bloque");
		$this->loadModel("Soporte");
		$this->loadModel("Copia");
		$this->loadModel("Almacenamiento");
		$this->loadModel("Formato");
		$this->loadModel("User");
		$this->CatalogacionPartido->id = $this->request->query["id"];
		if($this->CatalogacionPartido->exists()){
			$equipos = $this->Equipo->find("list", array("fields"=>array("Equipo.id","Equipo.codigo")));
			$campeonatos = $this->Campeonato->find("list", array("fields"=>array("Campeonato.id","Campeonato.codigo")));
			$bloques = $this->Bloque->find("list", array("fields"=>array("Bloque.id","Bloque.codigo")));
			$soportes = $this->Soporte->find("list", array("fields"=>array("Soporte.id","Soporte.nombre")));
			$formatos = $this->Formato->find("list", array("fields"=>array("Formato.id","Formato.nombre")));
			$copiasQuery = $this->Copia->find("all", array("recursive"=>-1));
			foreach ($copiasQuery as $copia) {
				$copias[$copia["Copia"]["id"]] = mb_strtoupper($copia["Copia"]["copia"]);
			}
			$almacenamientos = $this->Almacenamiento->find("list", array("fields"=>array("Almacenamiento.id","Almacenamiento.lugar")));
			$users = $this->User->find("list", array("fields"=>array("User.id", "User.nombre")));
			$catalogacionPartido = $this->CatalogacionPartido->find("first", array(
				"conditions"=>array(
					"CatalogacionPartido.id"=>$this->CatalogacionPartido->id
					)
				)
			);
			$fechaPartido = new DateTime($catalogacionPartido["CatalogacionPartido"]["fecha_partido"]);
			$catalogacionPartido["CatalogacionPartido"]["fecha_partido"] = $fechaPartido->format("Y-m-d");
			//$catalogacionPartido["CatalogacionPartido"]["equipo_local"] = mb_strtoupper($equipos[$catalogacionPartido["CatalogacionPartido"]["equipo_local"]]);
			//$catalogacionPartido["CatalogacionPartido"]["equipo_visita"] = mb_strtoupper($equipos[$catalogacionPartido["CatalogacionPartido"]["equipo_visita"]]);
			//$catalogacionPartido["CatalogacionPartido"]["campeonato_id"] = mb_strtoupper($campeonatos[$catalogacionPartido["CatalogacionPartido"]["campeonato_id"]]);
			foreach ($catalogacionPartido["CatalogacionPartidosMedio"] as $key => $medios) {
				$catalogacionPartido["CatalogacionPartidosMedio"][$key]["bloque_id"] = mb_strtoupper($bloques[$medios["bloque_id"]]);
				$catalogacionPartido["CatalogacionPartidosMedio"][$key]["soporte_id"] = mb_strtoupper($soportes[$medios["soporte_id"]]);
				$catalogacionPartido["CatalogacionPartidosMedio"][$key]["almacenamiento_id"] = mb_strtoupper($almacenamientos[$medios["almacenamiento_id"]]);
				$catalogacionPartido["CatalogacionPartidosMedio"][$key]["copia_id"] = mb_strtoupper($copias[$medios["copia_id"]]);
				$catalogacionPartido["CatalogacionPartidosMedio"][$key]["formato_id"] = mb_strtoupper($formatos[$medios["formato_id"]]);
				empty($medios["user_id"]) ? "" : $catalogacionPartido["CatalogacionPartidosMedio"][$key]["user"] = mb_strtoupper($users[$medios["user_id"]]);
			}
			//unset($catalogacionPartido["Campeonato"],$catalogacionPartido["CatalogacionPartidosMedio"]["created"],$catalogacionPartido["CatalogacionPartidosMedio"]["modified"]);*/
			$respuesta = $catalogacionPartido;
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"El evento no fue encontrado, por favor intentelo nuevamente"
			);
		}
		return json_encode($respuesta);
	}

	public function registrar_catalogacion_partidos(){
		$this->autoRender = false;
		$this->response->type("json");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				if(!isset($this->request->data["CatalogacionPartido"]["id"])){
					$this->request->data["CatalogacionPartido"]["user_id"] = $this->Session->Read("PerfilUsuario.idUsuario");
					$mensajeLog = 'Registro - CatalogacionPartidos - registrar_catalogacion_partidos id';
					$mensajeFlash = 'Se registro correctamente';
				}else{
					$mensajeLog = 'Edito - CatalogacionPartidos - registrar_catalogacion_partidos id';
					$mensajeFlash = 'Se edito correctamente';
				}
				
				if($this->CatalogacionPartido->save($this->request->data)){
					CakeLog::write('actividad', $mensajeLog.' - '.$this->CatalogacionPartido->id.' - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash(__($mensajeFlash), "msg_exito");
					$respuesta = array(
						"estado"=>1,
						"id"=>$this->CatalogacionPartido->id
						);
				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"No se pudo guardar en la base de datos, por favor intentalo nuevamente"
					);	
				}
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Metodo no permitido"
				);
			}
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdio la sessión por favor intentelo nuevamente"
			);
		}
		return json_encode($respuesta);

	}
}
