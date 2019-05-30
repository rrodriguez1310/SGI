<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('TransmisionPartidosController', 'Controller');
/**
 * ProduccionPartidosEventos Controller
 *
 * @property ProduccionPartidosEvento $ProduccionPartidosEvento
 * @property PaginatorComponent $Paginator
 */
class ProduccionPartidosEventosController extends AppController {

	private $proveedorCompanies = array(1226 => "Chilefilms", 1842=>"Señal Cero", 551 => "Feres");

	public function index(){
		$this->set("appAngular", "angularAppText");
		$this->layout = "angular";
		$this->acceso();
	}
	
	public function enviar_partidos(){
		$this->set("appAngular", "angularAppText");
		$this->layout = "angular";
		$this->acceso();
	}

	public function lista_eventos_json($fecha = null){
		$this->layout = "ajax";
		//$this->response->type("json");
		$serv = new ServiciosController();
		$this->loadModel("FixturePartido");
		$this->loadModel("CampeonatosRelacione");
		$this->loadModel("ProduccionListaCorreo");
		$this->loadModel("ProduccionContacto");
		$this->loadModel("Regione");

		if(!$fecha) {
			$fecha = date('Y-m-d');
		}
		
		$produccionPartidos = $this->ProduccionPartidosEvento->find("all", array(
			"fields"=>array("ProduccionPartidosEvento.*","TipoTransmisione.nombre","TipoTransmisione.id", "Campeonato.id","Campeonato.nombre", "Categoria.nombre", "Subcategoria.nombre", "Estadio.nombre", "Estadio.ciudad", "Estadio.regione_id", /*"Regione.id", "Regione.region_ordinal",*/
				"Equipo.nombre_marcador", "EquipoVisita.nombre_marcador", "ProduccionPartido.id", "ProduccionPartidosChilefilm.id", "ProduccionPartidosTransmisione.*" ),
			"conditions"=> array("ProduccionPartidosEvento.estado_produccion !="=> 0,
			"ProduccionPartidosEvento.fecha_partido >=" => $fecha),
			"joins"=> array( 
				array("table" => "tipo_transmisiones", 
					"alias" => "TipoTransmisione", 
					"type" => "LEFT", 
					"conditions" => array("ProduccionPartidosTransmisione.tipo_transmisione_id = TipoTransmisione.id")
					)
				)
			));

		$listRegion = $this->Regione->find("all", array("fields"=>array("id","region_nombre", "region_prep")));
		$regiones = array();
		foreach ($listRegion as $region) {
			$regiones[$region["Regione"]["id"]] = $region["Regione"];
		}
		
		$produccionJson = array();
		$partidosEnProduccion = array();
		foreach ($produccionPartidos as $produccionPartido) {
			
			$produccionPartido["Campeonato"]["nombre"] = str_replace("CAMPEONATO ","",$produccionPartido["Campeonato"]["nombre"]);

			if ($produccionPartido["Estadio"]["regione_id"] == 0 || $produccionPartido["Estadio"]["nombre"] == 'POR CONFIRMAR') {				
				$region = "";				
				$produccionPartido["Estadio"]["ciudad"] = "";
				$produccionPartido["Estadio"]["localia"] = "";
				$produccionPartido["Estadio"]["region_ordinal"] = '';

			} else {

			$region = "";
			$region[] = 'Región ';
			$region[] = $regiones[$produccionPartido["Estadio"]["regione_id"]]["region_prep"];
			$region[] = ' ';
			$region[] = ($produccionPartido["Estadio"]["regione_id"] != 7) ? $regiones[$produccionPartido["Estadio"]["regione_id"]]["region_nombre"] : 'Metropolitana';
			$region[] = '.';
			}

			$produccionJson[] = array(
				"id" => $produccionPartido["ProduccionPartidosEvento"]["id"],
				"id_partido"=>$produccionPartido["ProduccionPartidosEvento"]["fixture_partido_id"],
				"nombre_torneo"=>$produccionPartido["Campeonato"]["nombre"].' '.$produccionPartido["Categoria"]["nombre"].' '.$produccionPartido["Subcategoria"]["nombre"],		
				"torneo"=>$produccionPartido["Campeonato"]["nombre"],
				"torneo_id"=>$produccionPartido["Campeonato"]["id"],
				"categoria"=>$produccionPartido["Categoria"]["nombre"],
				"subcategoria"=>$produccionPartido["Subcategoria"]["nombre"],
				"estadio"=> ($produccionPartido["Estadio"]["nombre"] == 'POR CONFIRMAR')? $produccionPartido["Estadio"]["nombre"] : $produccionPartido["Estadio"]["nombre"] .', '.$produccionPartido["Estadio"]["ciudad"] .', '. mb_strtoupper(implode("", $region)),
				"equipo_local"=>$produccionPartido["Equipo"]["nombre_marcador"],
				"equipo_visita"=>$produccionPartido["EquipoVisita"]["nombre_marcador"],
				"fecha_partido"=>$produccionPartido["ProduccionPartidosEvento"]["fecha_partido"],
				"hora_partido"=>substr($produccionPartido["ProduccionPartidosEvento"]["hora_partido"],0,5),
				"hora_transmision"=>substr($produccionPartido["ProduccionPartidosTransmisione"]["hora_transmision"],0,5),
				"hora_transmision_gmt"=>substr($produccionPartido["ProduccionPartidosTransmisione"]["hora_transmision_gmt"],0,5),
				"hora_termino_transmision"=>substr($produccionPartido["ProduccionPartidosTransmisione"]["hora_termino_transmision"],0,5),
				"senales_id"=> isset($produccionPartido["ProduccionPartidosTransmisione"]["senales"]) ? unserialize($produccionPartido["ProduccionPartidosTransmisione"]["senales"]) : array(),
				"estado_produccion" => $produccionPartido["ProduccionPartidosEvento"]["estado_produccion"],
				"tipo_transmision"=> $produccionPartido["TipoTransmisione"]["nombre"],
				"tipo_transmisione_id"=> $produccionPartido["TipoTransmisione"]["id"],
				"partidos_cdf_id" => isset($produccionPartido["ProduccionPartido"]["id"]) ? $produccionPartido["ProduccionPartido"]["id"] : null,
				"partidos_chilefilms_id" => isset($produccionPartido["ProduccionPartidosChilefilm"]["id"]) ? $produccionPartido["ProduccionPartidosChilefilm"]["id"] : null,
				"partidos_transmisione_id" => isset($produccionPartido["ProduccionPartidosTransmisione"]["id"]) ? $produccionPartido["ProduccionPartidosTransmisione"]["id"] : null,
			);
			$partidosEnProduccion[] = $produccionPartido["ProduccionPartidosEvento"]["fixture_partido_id"];

		}
		
		if(count($partidosEnProduccion)==1)
			$conditions = array("FixturePartido.id !=" => $partidosEnProduccion);
		else
			$conditions = array("FixturePartido.id not" => $partidosEnProduccion);

		$partidos = $this->FixturePartido->find("all", array(			
			"conditions" => array("FixturePartido.estado" => 1,
				"FixturePartido.transmite_cdf" => 1,
				"FixturePartido.fecha_partido >=" => date("Y-m-d"),
				$conditions					
				)
			));

		$fixturesJson = array();
		if(!empty($partidos)){
			foreach ($partidos as  $partido) {
				
				$partido["Campeonato"]["nombre"] = str_replace("CAMPEONATO ","",$partido["Campeonato"]["nombre"]);
				/*$region = "";
				$region[] = $regiones[$partido["Estadio"]["regione_id"]];
				$region[] = ($partido["Estadio"]["regione_id"] != 7) ? ' Región.' : '.';*/


				if ($partido["Estadio"]["regione_id"] == 0 || $partido["Estadio"]["nombre"] == 'POR CONFIRMAR') {				
					$region = "";				
					$partido["Estadio"]["ciudad"] = "";
					$partido["Estadio"]["localia"] = "";
					$partido["Estadio"]["region_ordinal"] = '';

				} else {

				$region = "";
				$region[] = 'Región ';
					$region[] = $regiones[$partido["Estadio"]["regione_id"]]["region_prep"];
				$region[] = ' ';
					$region[] = ($partido["Estadio"]["regione_id"] != 7) ? $regiones[$partido["Estadio"]["regione_id"]]["region_nombre"] : 'Metropolitana';
				$region[] = '.';
				}

					
				$fixturesJson[] = array(
					"id" => null,
					"id_partido"=>$partido["FixturePartido"]["id"],
					"nombre_torneo"=>$partido["Campeonato"]["nombre"].' '.$partido["Categoria"]["nombre"].' '.$partido["Subcategoria"]["nombre"],		
					"torneo"=>$partido["Campeonato"]["nombre"],
					"categoria"=>$partido["Categoria"]["nombre"],
					"subcategoria"=>$partido["Subcategoria"]["nombre"],
					"estadio"=> ($partido["Estadio"]["nombre"] == 'POR CONFIRMAR')? $partido["Estadio"]["nombre"] : $partido["Estadio"]["nombre"] .', '.$partido["Estadio"]["ciudad"] .', '. mb_strtoupper(implode("", $region)),
					"equipo_local"=>$partido["Equipo"]["nombre_marcador"],
					"equipo_visita"=>$partido["EquipoVisita"]["nombre_marcador"],
					"fecha_partido"=>$partido["FixturePartido"]["fecha_partido"],
					"hora_partido"=>substr($partido["FixturePartido"]["hora_partido"],0,5),
					"hora_transmision"=>null,
					"hora_transmision_gmt"=>null,
					"estado_produccion"	=> null,
					"tipo_transmision"=> '-',
					"partidos_cdf_id" => null,
					"partidos_chilefilms_id" => null,
					"partidos_transmisione_id" => null
				);
			}
		}

		$listadoProduccion = array();
		$listadoReagendados = array();
		
		foreach ($produccionJson as $partidoProd) {

			if($partidoProd["estado_produccion"]==3)
			{
				$listadoReagendados[] = $partidoProd;
			}
			else
			{
				$listadoProduccion[] = $partidoProd;
			}
		}

		$listadoProduccionJson = array_merge($listadoProduccion, $fixturesJson);


		foreach ($listadoProduccionJson as $key1 => $partido) {
			
			foreach ($listadoProduccionJson as $key2 => $previa) {

				if($partido["id_partido"] == $previa["id_partido"]){

					$partido["hora_tramision_previa"] = $previa["hora_transmision"];
					$partido["hora_tramision_previa_gmt"] = $previa["hora_transmision_gmt"];
				}
			}

			$listadoProduccionRelJson[] = $partido;

		}
		
		if(!empty($listadoProduccionJson))
			$listadoProduccionJson = $serv->sort_array_multidim($listadoProduccionJson, "fecha_partido ASC, hora_partido ASC");

		if(!empty($listadoReagendados)){
			$listadoReagendados = $serv->sort_array_multidim($listadoReagendados, "fecha_partido ASC, hora_partido ASC");	

			foreach ($listadoReagendados as $value) {
				array_push($listadoProduccionJson, $value);
			}
		}

		$campeonatosList = $this->ProduccionPartidosEvento->Campeonato->find('all', array("fields"=>array("id", "nombre", "tipo_campeonato_id"), "conditions"=>array("estado" => 1)));			
		$categoriasList = $this->ProduccionPartidosEvento->Categoria->find('all', array("fields"=>array("id", "nombre"),"recursive"=>-1));

		$campeonatos = array();
		foreach ($campeonatosList as $campeonato) {
			$campeonatos[] = $campeonato["Campeonato"];
			$tipoCampeonatosIds[] = $campeonato["Campeonato"]["tipo_campeonato_id"];
		}

		foreach ($categoriasList as $key => $cat) {
			$categoriasList[$cat["Categoria"]["id"]] = $cat["Categoria"]["nombre"];
			$categoriasArr[$cat["Categoria"]["id"]] = $cat;
		}

		//relaciones
		$relacionCampeonatos = $this->CampeonatosRelacione->find('all', array(
			"conditions"=>array("estado" => 1,
				"tipo_campeonato_id" => $tipoCampeonatosIds
				)
			)
		);
		foreach ($relacionCampeonatos as $key => $relCampeonatos) {
			$relacionCampeonatosArr[$relCampeonatos["CampeonatosRelacione"]["id"]] = $relCampeonatos["CampeonatosRelacione"];
		}

		foreach ($relacionCampeonatosArr as $key => $value) {
				
			if($value["dependencia"] && $value["dependencia"]!=''){
				
				$subcategorias = json_decode($value["categoria_id"],true);
				foreach ($subcategorias as $keySub => $idSub) {	

					$posPadre = json_decode($relacionCampeonatosArr[$value["dependencia"]]["categoria_id"])[0];

					$relCategoriasSub[$posPadre][] = array_merge($categoriasArr[$idSub]["Categoria"],array("dependencia"=>$value["dependencia"]));
				}
			}

			if(!$value["dependencia"] || $value["dependencia"]==''){
				
				$categorias = json_decode($value["categoria_id"],true);
				foreach ($categorias as $key2 => $id) {

					$relCampCategorias[$value["tipo_campeonato_id"]][$id] = $categoriasArr[$id]["Categoria"];

				}
			}
		}

		$listadosFormatos = array( 
			array( "id"=>"1", 
				"nombre"=>"1. Equipos de Transmisión (contiene adjuntos)"
				), 
			array( "id"=>"2",
				"nombre"=>"2. Información de Partidos"
				)
		);
		
		$listaDestinatariosn = $this->ProduccionListaCorreo->find('all', array("fields"=>array("id", "nombre", "produccion_contactos_id"), "conditions"=>array("estado" => 1)));		
		$contactosVigentes = $this->ProduccionContacto->find("list", array( "conditions" => array("estado"=>1) ));
	
		foreach ($listaDestinatariosn as $key => $nombre) {
			$contactos = json_decode($nombre["ProduccionListaCorreo"]["produccion_contactos_id"], true);
			
			if(array_intersect((array)$contactos, (array)$contactosVigentes))
				$listaDestinatarios[] = $nombre["ProduccionListaCorreo"];
		}
		
		$data = array( "partidos"=> $listadoProduccionJson, 
			"campeonatos"=>$campeonatos,
			"relCampeonatos"=>$relCampCategorias,
			"relSubCategorias"=>$relCategoriasSub,
			"destinatarios" => $listaDestinatarios,
			"formatos" => $listadosFormatos
		);
		
		$this->set('listado',$data); 

		return $data;
	}

	public function enviar_correo_partidos(){

		$this->layout = "ajax";
		$this->response->type("json");
		$this->loadModel("Campeonato");
		$this->loadModel("ProduccionContacto");
		$this->loadModel("ProduccionListaCorreo");		
		$this->loadModel("Regione");

		$serv = new ServiciosController();

		$destinatariosJsonIds = $this->ProduccionListaCorreo->find("first", array(
			"fields"=>array("produccion_contactos_id"),
			"conditions" => array(
				"ProduccionListaCorreo.id" => $this->request->data["Email"]["lista"]
				)
			));

		$destinatariosIds = json_decode($destinatariosJsonIds["ProduccionListaCorreo"]["produccion_contactos_id"],true);

		$destinatarios = $this->ProduccionContacto->find("all", array(
			"conditions" => array("ProduccionContacto.id"=> $destinatariosIds)
			));
		foreach ($destinatarios as $key => $correo) {
			$listaDestinatarios[] = $correo["ProduccionContacto"];
		}
		//$regiones = $this->Regione->find("list", array("fields"=>array("Regione.id","Regione.region_ordinal")));
		$listRegion = $this->Regione->find("all", array("fields"=>array("id","region_nombre", "region_prep")));
		$regiones = array();
		foreach ($listRegion as $region) {
			$regiones[$region["Regione"]["id"]] = $region["Regione"];
		}

		$campeonato = $this->Campeonato->find("first", array("conditions"=>array("id"=>$this->request->data["ProduccionPartidosEvento"]["campeonato_id"])));
		$asunto = isset($this->request->data["Email"]["asunto"])? $this->request->data["Email"]["asunto"]: '';
		$partidos["partidos"] = $this->listadoPartidos($this->request->data["ProduccionPartidosEventos"]);

		foreach ($partidos["partidos"] as $partido) {
			//$region = '';
			$senalesT = array();
			//$region[] = $regiones[$partido["Estadio"]["regione_id"]];
			//$region[] = ($partido["Estadio"]["regione_id"]!=7) ? ' REGIÓN.': '.';
			if ($partido["Estadio"]["regione_id"] == 0 || $partido["Estadio"]["nombre"] == 'POR CONFIRMAR') {				
				$region = "";				
				$partido["Estadio"]["ciudad"] = "";
				$partido["Estadio"]["localia"] = "";
				$partido["Estadio"]["region_ordinal"] = '';
			}
			else {
			$region = "";
			$region[] = 'Región ';
			$region[] = $regiones[$partido["Estadio"]["regione_id"]]["region_prep"];
			$region[] = ' ';
			$region[] = ($partido["Estadio"]["regione_id"] != 7) ? $regiones[$partido["Estadio"]["regione_id"]]["region_nombre"] : 'Metropolitana';
			$region[] = '.';
			$partido["Estadio"]["region_ordinal"] = mb_strtoupper(implode("",$region));
			}
			
			
			$partidosxId[$partido["ProduccionPartidosEvento"]["fixture_partido_id"]] = $partido;
			$idFixturePrevia[] = $partido["ProduccionPartidosEvento"]["fixture_partido_id"];
		}

		$partidos["comentarios"] = $this->request->data["comentarios"];
		$emailsParticipantes = array();

		//enviar correo con excel de transmisiones Claro
		if($this->request->data["Email"]["formato"] == 2){

			$plantilla = 'produccion_partidos_informacion';
			$partidosPrevia = $this->ProduccionPartidosEvento->find("all", array(
				"conditions"=>array( "ProduccionPartidosEvento.fixture_partido_id" => $idFixturePrevia,
					"ProduccionPartidosEvento.estado_produccion" => array(1,2),
					"ProduccionPartidosTransmisione.tipo_transmisione_id" => 3,
					"ProduccionPartidosTransmisione.estado" => 1
					),
				"recursive" =>2
				)
			);

			foreach ($partidosPrevia as $partidoPrevia) {

				$partidosPreviaId[$partidoPrevia["ProduccionPartidosEvento"]["fixture_partido_id"]]["hora_transmision"] = $partidoPrevia["ProduccionPartidosTransmisione"]["hora_transmision"];
				$partidosPreviaId[$partidoPrevia["ProduccionPartidosEvento"]["fixture_partido_id"]]["hora_transmision_gmt"] = $partidoPrevia["ProduccionPartidosTransmisione"]["hora_transmision_gmt"];
			}
			// corrige hora vivo con previa
			foreach ($partidosxId as $key => $partidoI) {
				$senalesTitulo = array();			
				if($partidoI["ProduccionPartidosTransmisione"]["tipo_transmisione_id"] == 1){	//vivo

					if(isset($partidosPreviaId[$key])){

						$partidoI["ProduccionPartidosEvento"]["hora_transmision_previa"] = $partidosPreviaId[$key]["hora_transmision"];
						$partidoI["ProduccionPartidosEvento"]["hora_transmision_previa_gmt"] = $partidosPreviaId[$key]["hora_transmision_gmt"];
					}
					/*$senalesId = unserialize($partidoI["ProduccionPartidosTransmisione"]["senales"]);
					if( in_array( 3, $senalesId) ){ // HD

						$partidoI["ProduccionPartidosTransmisione"]["transmision"] = 'Transmisión HD';
					}*/
				}

				$partidosOrden[] = array(
					"id"=> $key,
					"fecha"=>$partidoI["ProduccionPartidosEvento"]["fecha_partido"],
					"hora"=>(isset($partidoI["ProduccionPartidosEvento"]["hora_transmision_previa"])? $partidoI["ProduccionPartidosEvento"]["hora_transmision_previa"] : $partidoI["ProduccionPartidosTransmisione"]["hora_transmision"])
					);

				if( isset($partidoI["ProduccionPartidosTransmisione"]["proveedor_company_id"]) ){
					$partidoI["ProduccionPartidosTransmisione"]["nombre_proveedor"] = $this->proveedorCompanies[$partidoI["ProduccionPartidosTransmisione"]["proveedor_company_id"]];
				}

				$senalesArray = $this->listadoSenales(unserialize($partidoI["ProduccionPartidosTransmisione"]["senales"]));								
				if(array_key_exists(5, $senalesArray)) $senalesArray[5] = "Estadio CDF";
				$senalesTitulo[] = isset($senalesArray)? implode(", ",$senalesArray): '';
				$senalesTitulo[] = ($partido["ProduccionPartidosTransmisione"]["tipo_transmisione_id"]==2)? 'CDF Radio' : '';
				$partidoI["ProduccionPartidosTransmisione"]["senales"] = implode(" - ",array_filter($senalesTitulo));	
				
				$partidosInicioPrevia[$key] = $partidoI;
			}
			//reordena hora previa.
			$partidosOrden = $serv->sort_array_multidim($partidosOrden, "fecha ASC, hora ASC");
			foreach ($partidosOrden as $value) { $ordenArr[$value["id"]] = $value; }
			$partidos["partidos"] = array_replace($ordenArr, $partidosInicioPrevia); 			
		
		}else{

			$files[] = WWW_ROOT . "files" . DS . $this->request->data["Email"]["adjunto"];
			$files[] = WWW_ROOT . "files" . DS . 'produccion_partidos' . DS . 'partidos' . DS . 'COMBINACIONES_TX_PARTIDOS_CDF.pdf';

			$plantilla = 'produccion_partidos_tx';
		}
				
		// correos lista
		$correos = array();
		foreach ($listaDestinatarios as $correo) {
			$correos[$correo["email"]] = $correo["nombre"];
		}
		//$correos = array_values(array_unique(array_merge($emailsParticipantes, $correos)));	

		if(!empty($correos)){

			$Email = new CakeEmail("gmail");
			$Email->from(array('scaballero@cdf.cl' => 'Sebastian Caballero'));
			$Email->to($correos); //$correos
			//$Email->cc("scaballero@cdf.cl");	// scaballero@cdf.cl
			$Email->bcc("ddiaz@cdf.cl");

			$Email->subject($asunto); //$correo["asunto"]
			$Email->emailFormat('html');
			$Email->template($plantilla);
			$Email->viewVars($partidos);

			$archivos = array('cdf_firma.jpg' => array(
					'file' =>  WWW_ROOT.'img'.DS.'cdf_firma.jpg',
					'mimetype' => 'image/jpg',
					'contentId' => 'my-unique-id'
					)
			);

			if(!empty($files)){
				foreach ($files as $file) {
					$nom = explode(DS,$file);
					$archivos[$nom[count($nom)-1]] = $file;	
				}
			}
						
			$Email->attachments($archivos);
			
			if($Email->send()){
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"La información se ha enviado correctamente."
					);
			}
			else
			{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se pudo enviar la información. Intente nuevamente mas tarde."
					);
			}
		}
		else
		{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No se pudo enviar la información. Intente nuevamente mas tarde."
				);
		}

		$this->set('respuesta',$respuesta); 
	}

	public function data_info_correo_json(){

		$this->layout = "ajax";
		$this->response->type("json");

		$this->loadModel("Campeonato");
		$this->loadModel("ProduccionPartidosEvento");
		$this->loadModel("CampeonatosFecha");
		$this->loadModel("Regione");

		$serv = new ServiciosController();
		//$regiones = $this->Regione->find("list", array("fields"=>array("id","region_ordinal")));
		$listRegion = $this->Regione->find("all", array("fields"=>array("id","region_nombre", "region_prep")));
		$regiones = array();
		foreach ($listRegion as $region) {
			$regiones[$region["Regione"]["id"]] = $region["Regione"];
		}

		$estado = 1;
		$categoria = $this->ProduccionPartidosEvento->Categoria->find("first", array("conditions"=>array("id"=>$this->request->data["ProduccionPartidosEvento"]["campeonatos_categoria_id"]), "recursive"=>-1) );
		$subcategoria = $this->ProduccionPartidosEvento->Categoria->find("first", array("conditions"=>array("id"=>$this->request->data["ProduccionPartidosEvento"]["campeonatos_subcategoria_id"]), "recursive"=>-1) );
		$campeonato = $this->Campeonato->find("first", array("conditions"=>array("id"=>$this->request->data["ProduccionPartidosEvento"]["campeonato_id"])) );
		
		$campeonatoNom = isset($campeonato["Campeonato"]["nombre"])? $campeonato["Campeonato"]["nombre"]: '';
		$categoriaNom = isset($categoria["Categoria"]["nombre"])? $categoria["Categoria"]["nombre"]: '';
		$subcategoriaNom = isset($subcategoria["Categoria"]["nombre"])? $subcategoria["Categoria"]["nombre"]: '';

		$tituloDocumento = array($campeonatoNom,$categoriaNom,$subcategoriaNom);
		$tituloDocumento = mb_strtoupper(implode(" - ",array_filter($tituloDocumento)));

		$partidos = $this->listadoPartidos($this->request->data["ProduccionPartidosEventos"]);

		//archivo pdf
		$nombreDocumento[0] = 'EQUIPOS '.$tituloDocumento;
		
		if(!empty($partidos)){

			foreach ($partidos as $partido) {
				$senalesArray = $this->listadoSenales(unserialize($partido["ProduccionPartidosTransmisione"]["senales"]));
				$patron = '/CDF ESTADIO/';				
				$tituloPartido = array();
				$tituloPartido[] = isset($partido["ProduccionPartidosTransmisione"]["numero_camaras"])? $partido["ProduccionPartidosTransmisione"]["numero_camaras"] . ' Cámaras' : '';
				$senalesText = isset($senalesArray)? mb_strtoupper(implode(", ",$senalesArray)): '';				
				$tituloPartido[] = preg_replace($patron, 'ESTADIO CDF', $senalesText);									
				$tituloPartido[] = ($partido["ProduccionPartidosTransmisione"]["tipo_transmisione_id"]==2)? 'CDF RADIO' : '';				

				if($partido["Campeonato"]["id"] != $this->request->data["ProduccionPartidosEvento"]["campeonato_id"]){
					$torneoDif = $partido["Campeonato"]["nombre"].' '.$partido["Categoria"]["nombre"].' '.$partido["Subcategoria"]["nombre"];
					$nombreDocumento[1] = $partido["Campeonato"]["nombre"].' '.$partido["Categoria"]["nombre"];
				}

				$torneoDif = ($partido["Campeonato"]["id"] != $this->request->data["ProduccionPartidosEvento"]["campeonato_id"])? $partido["Campeonato"]["nombre"].' '.$partido["Categoria"]["nombre"].' '.$partido["Subcategoria"]["nombre"] : '';

				if(trim($torneoDif) != ''){
					$tituloPartido[] = $torneoDif;
				}
				else
					$tituloPartido[] = ($partido["Subcategoria"]["id"] != $this->request->data["ProduccionPartidosEvento"]["campeonatos_subcategoria_id"])? $partido["Subcategoria"]["nombre"] : '';
				
				$tituloPartido = mb_strtoupper(implode(" - ",array_filter($tituloPartido)));

				setlocale(LC_TIME, 'es_ES.UTF-8'); 
				$fechaPartido = ucfirst(mb_strtolower( strftime("%A %d, %B, %Y", strtotime($partido["ProduccionPartidosEvento"]["fecha_partido"])) , 'UTF-8'));

				$previa = ($partido["ProduccionPartidosTransmisione"]["tipo_transmisione_id"]==3) ? 'PREVIA ' : '';
				$equipos = $previa.mb_strtoupper($partido["Equipo"]["nombre_marcador"]) . ' vs. ' . mb_strtoupper($partido["EquipoVisita"]["nombre_marcador"]);	

				$partido["ProduccionPartido"]["periodista"] = unserialize($partido["ProduccionPartido"]["periodista"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($partido["ProduccionPartido"]["periodista"]))) : '';
				$partido["ProduccionPartido"]["periodistas"][] = $partido["ProduccionPartido"]["periodista"];				
				$partido["ProduccionPartido"]["periodista_visita"] = unserialize($partido["ProduccionPartido"]["periodista_visita"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($partido["ProduccionPartido"]["periodista_visita"]))) : '';	
				$partido["ProduccionPartido"]["periodistas"][] = $partido["ProduccionPartido"]["periodista_visita"];

				if($partido["ProduccionPartido"]["periodista_visita"]!='' && $partido["ProduccionPartido"]["periodista"]!=''){
					unset($partido["ProduccionPartido"]["periodistas"]);
					$partido["ProduccionPartido"]["periodistas"][] = $partido["ProduccionPartido"]["periodista"] . ' (' . $partido["Equipo"]["codigo_marcador"]. ')';	
					$partido["ProduccionPartido"]["periodistas"][] = $partido["ProduccionPartido"]["periodista_visita"] . ' (' . $partido["EquipoVisita"]["codigo_marcador"]. ')';	
				}
				$periodistas = implode(" - ",array_filter($partido["ProduccionPartido"]["periodistas"]));
				
				//$senal = array_key_exists(3, $partido["ProduccionPartidosTransmisione"]["senales"]) ? ' HD': '';
				$partido["ProduccionPartidosTransmisione"]["nombre_proveedor"] = $this->proveedorCompanies[$partido["ProduccionPartidosTransmisione"]["proveedor_company_id"]] . ' - ' . $partido["ProduccionPartidosTransmisione"]["TransmisionesMovile"]["nombre"];	

				//$region = "";
				//$region[] = $regiones[$partido["Estadio"]["regione_id"]];
				//$region[] = ($partido["Estadio"]["regione_id"] != 7) ? ' Región.' : '.';
				if ($partido["Estadio"]["regione_id"] == 0 ) {
					$region[] = 'Por Confirmar';
				}
				else {
				$region = "";
				$region[] = 'Región ';
				$region[] = $regiones[$partido["Estadio"]["regione_id"]]["region_prep"];
				$region[] = ' ';
				$region[] = ($partido["Estadio"]["regione_id"] != 7) ? $regiones[$partido["Estadio"]["regione_id"]]["region_nombre"] : 'Metropolitana';
				$region[] = '.';
				}	

				$listadoPartidosJson[] = array(
					"titulo_partido"=> $tituloPartido,
					"subtitulo_partido"=> $fechaPartido,
					"equipos"=> $equipos,
					"fecha_partido"=> $partido["ProduccionPartidosEvento"]["fecha_partido"],
					"hora_partido"=> ($partido["ProduccionPartidosTransmisione"]["tipo_transmisione_id"]==3) ? '' : substr($partido["ProduccionPartidosEvento"]["hora_partido"],0,5),
					"hora_transmision"=> substr($partido["ProduccionPartidosTransmisione"]["hora_transmision"],0,5),
					"hora_termino_transmision"=> substr($partido["ProduccionPartidosTransmisione"]["hora_termino_transmision"],0,5),
					"estadio"=> ($partido["Estadio"]["nombre"] == 'POR CONFIRMAR') ? $partido["Estadio"]["nombre"] : $partido["Estadio"]["nombre"] .', '.$partido["Estadio"]["ciudad"] .', '. mb_strtoupper(implode("", $region)),					
					"ciudad"=> $partido["Estadio"]["ciudad"],
					"movil_transmision" => trim($partido["ProduccionPartidosTransmisione"]["nombre_proveedor"]),
					
					"comentarios"=> unserialize($partido["ProduccionPartido"]["comentarista"])? implode("-", $this->obtTrabajadoresEmpresas(unserialize($partido["ProduccionPartido"]["comentarista"]))) : '-',
					"conduccion_relato"=> unserialize($partido["ProduccionPartido"]["relator"])? implode("-", $this->obtTrabajadoresEmpresas(unserialize($partido["ProduccionPartido"]["relator"]))) : '-',
					"reportero"=> $periodistas,
					"direccion"=> unserialize($partido["ProduccionPartidosChilefilm"]["director"])? implode("-", $this->obtPersonalExterno(unserialize($partido["ProduccionPartidosChilefilm"]["director"]))) : '-',
					"asist_direccion"=> unserialize($partido["ProduccionPartidosChilefilm"]["asist_direccion"])? implode("-", $this->obtPersonalExterno(unserialize($partido["ProduccionPartidosChilefilm"]["asist_direccion"]))) : '-',
					"produccion"=> unserialize($partido["ProduccionPartidosChilefilm"]["productor"])? implode("-", $this->obtPersonalExterno(unserialize($partido["ProduccionPartidosChilefilm"]["productor"]))) : '-',

					"operador_trackvision"=> unserialize($partido["ProduccionPartido"]["operador_trackvision"])? implode("-", $this->obtTrabajadoresEmpresas(unserialize($partido["ProduccionPartido"]["operador_trackvision"]))) : '-',

					"produccion_cdf"=> unserialize($partido["ProduccionPartido"]["productor"])? implode("-", $this->obtTrabajadoresEmpresas(unserialize($partido["ProduccionPartido"]["productor"]))) : '-',
					"asist_productor_cdf"=> unserialize($partido["ProduccionPartido"]["asist_produccion"])? implode("-", $this->obtTrabajadoresEmpresas(unserialize($partido["ProduccionPartido"]["asist_produccion"]))) : '-',
					"coordinador_periodistico"=> unserialize($partido["ProduccionPartido"]["coordinador_periodistico"])? implode("-", $this->obtTrabajadoresEmpresas(unserialize($partido["ProduccionPartido"]["coordinador_periodistico"]))) : '-',

					"terno"=> isset($partido["ProduccionPartido"]["ProduccionTerno"]["nombre"])? trim($partido["ProduccionPartido"]["ProduccionTerno"]["nombre"]):'-',
					//"camisa"=> isset($partido["ProduccionPartido"]["ProduccionCamisa"]["nombre"])? trim($partido["ProduccionPartido"]["ProduccionCamisa"]["nombre"]): '-',
					"corbata"=> isset($partido["ProduccionPartido"]["ProduccionCorbata"]["nombre"])? trim($partido["ProduccionPartido"]["ProduccionCorbata"]["nombre"]): '-',
					"panuelo"=> isset($partido["ProduccionPartido"]["ProduccionPanuelo"]["nombre"])? trim($partido["ProduccionPartido"]["ProduccionPanuelo"]["nombre"]): '-'
					);
			}
		}
		else
		{
			$listadoPartidosJson = array();
			$estado = 0;
		}

		$nombreDocumento = mb_strtoupper(implode(" + ",array_filter($nombreDocumento)));
		
		$listadoPartidosJson = $serv->sort_array_multidim($listadoPartidosJson, "fecha_partido asc, hora_transmision asc, hora_partido asc");

		$dataListado = array(
			"estado"=>$estado,
			"nombre_documento"=>$nombreDocumento,
			"titulo_documento"=>$tituloDocumento,
			"partidos_correo"=>$listadoPartidosJson
			);

		$this->set('listado',$dataListado); 
	}

	public function obtEmailParticipantes($ids, $tipo){

		if($tipo=='externos'){

			$this->loadModel("CompaniesContacto");
			$emails = $this->CompaniesContacto->find("list", array(
				"conditions"=>array( "CompaniesContacto.id"=>$ids),
				"fields"=>array( "CompaniesContacto.email")
			));			
		}

		if($tipo=='cdf'){	// trabajadores

			$this->loadModel("Trabajadore");			
			$emails  = $this->Trabajadore->find("list", array(
				"conditions"=>array("Trabajadore.id"=>$ids),
				"fields"=>array("Trabajadore.email")				
			));
		}

		if($tipo=='empresas'){
			
			$this->loadModel("Company");			
			$emails = $this->Company->find("list", array(
				"conditions"=>array("Company.id"=> $ids),
				"fields"=>array("Company.email")				
			));
		}

		if($tipo=='trab_empresas'){
			$trabajadores = array();
			$empresas = array();
			foreach ($ids as $id) {
				$formato = explode(":",$id);
				($formato[0]=='T') ? $trabajadores[] = $formato[1] : $empresas[] = $formato[1];
			}

			$emails = array_merge($this->obtEmailParticipantes($trabajadores, "cdf"), $this->obtEmailParticipantes($empresas, "empresas"));
		}

		return array_filter($emails);
	}

	public function listadoPartidos($ids){
		$partidos = $this->ProduccionPartidosEvento->find("all", array(
			"conditions" => array( "ProduccionPartidosEvento.id"=> $ids),
			"recursive"=>2,
			"order" => "ProduccionPartidosEvento.fecha_partido ASC, ProduccionPartidosTransmisione.hora_transmision ASC, ProduccionPartidosEvento.hora_partido ASC"
			));
		return $partidos;
	}

	public function view($id = null) {

		$this->acceso();

		$this->loadModel("Regione");

		if (!$this->ProduccionPartidosEvento->exists($id)) {
			$this->Session->setFlash('Ocurrio un error intentelo nuevamente', 'msg_fallo');
			return $this->redirect(array('controller'=>'produccion_partidos_eventos', 'action' => 'index'));
		}
		$options = array('conditions' => array('ProduccionPartidosEvento.' . $this->ProduccionPartidosEvento->primaryKey => $id), "recursive"=>2);
		$data = $this->ProduccionPartidosEvento->find('first', $options);

		$regiones = $this->Regione->find("list", array(
			"fields"=> array("id","region_ordinal")
			));

		if ($data["Estadio"]["regione_id"] == 0) {
			$data["Estadio"]["ciudad"] = '';
			$data["Estadio"]["localia"] = '';
			$data["Estadio"]["region_ordinal"] = '';
		} else {
		$ordinal = ($data["Estadio"]["regione_id"] != 7) ? ' REGIÓN.': '.';
		$data["Estadio"]["region_ordinal"] = $regiones[$data["Estadio"]["regione_id"]] . $ordinal;
		}

		$data["ProduccionPartidosTransmisione"]["senales"] = implode(", ",$this->listadoSenales(unserialize($data["ProduccionPartidosTransmisione"]["senales"]))); 

		$data["ProduccionPartidosEvento"]["transmision"] = $this->obtTipoPartido($data["ProduccionPartidosEvento"]["fecha_partido"], $data["ProduccionPartidosEvento"]["hora_partido"]);
		$data["ProduccionPartidosEvento"]["fecha_partido"] = implode("/",array_reverse(explode("-",$data["ProduccionPartidosEvento"]["fecha_partido"])));
		$data["ProduccionPartidosEvento"]["hora_partido"] = substr($data["ProduccionPartidosEvento"]["hora_partido"],0,5);

		// externos		
		$data["ProduccionPartidosChilefilm"]["director"] = unserialize($data["ProduccionPartidosChilefilm"]["director"])? implode("<br>", $this->obtPersonalExterno(unserialize($data["ProduccionPartidosChilefilm"]["director"]))) : '';		
		$data["ProduccionPartidosChilefilm"]["productor"] = unserialize($data["ProduccionPartidosChilefilm"]["productor"])? implode("<br>", $this->obtPersonalExterno(unserialize($data["ProduccionPartidosChilefilm"]["productor"]))) : '';			
		$data["ProduccionPartidosChilefilm"]["asist_direccion"] = unserialize($data["ProduccionPartidosChilefilm"]["asist_direccion"])? implode("<br>", $this->obtPersonalExterno(unserialize($data["ProduccionPartidosChilefilm"]["asist_direccion"]))) : '';		

		// trabajadores y empresas

		$data["ProduccionPartido"]["productor"] = unserialize($data["ProduccionPartido"]["productor"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($data["ProduccionPartido"]["productor"]))) : '';
		$data["ProduccionPartido"]["asist_produccion"] = unserialize($data["ProduccionPartido"]["asist_produccion"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($data["ProduccionPartido"]["asist_produccion"]))) : '';		
		$data["ProduccionPartido"]["coordinador_periodistico"] = unserialize($data["ProduccionPartido"]["coordinador_periodistico"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($data["ProduccionPartido"]["coordinador_periodistico"]))) : '';		

		$data["ProduccionPartido"]["relator"] 	= unserialize($data["ProduccionPartido"]["relator"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($data["ProduccionPartido"]["relator"]))) : '';
		$data["ProduccionPartido"]["comentarista"] = unserialize($data["ProduccionPartido"]["comentarista"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($data["ProduccionPartido"]["comentarista"]))) : '';

		$data["ProduccionPartido"]["periodista"] = unserialize($data["ProduccionPartido"]["periodista"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($data["ProduccionPartido"]["periodista"]))) : '';
		$data["ProduccionPartido"]["periodistas"][] = $data["ProduccionPartido"]["periodista"];
		
		$data["ProduccionPartido"]["periodista_visita"] = unserialize($data["ProduccionPartido"]["periodista_visita"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($data["ProduccionPartido"]["periodista_visita"]))) : '';	
		$data["ProduccionPartido"]["periodistas"][] = $data["ProduccionPartido"]["periodista_visita"];

		if($data["ProduccionPartido"]["periodista_visita"]!='' && $data["ProduccionPartido"]["periodista"]!=''){
			unset($data["ProduccionPartido"]["periodistas"]);

			$data["ProduccionPartido"]["periodistas"][] = $data["ProduccionPartido"]["periodista"] . ' (' . $data["Equipo"]["codigo_marcador"]. ')';	
			$data["ProduccionPartido"]["periodistas"][] = $data["ProduccionPartido"]["periodista_visita"] . ' (' . $data["EquipoVisita"]["codigo_marcador"]. ')';	
		}

		$data["ProduccionPartido"]["periodistas"] = implode("<br>",$data["ProduccionPartido"]["periodistas"]);

		//empresas
		$data["ProduccionPartido"]["operador_trackvision"] = unserialize($data["ProduccionPartido"]["operador_trackvision"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($data["ProduccionPartido"]["operador_trackvision"]))) : '';
		$data["ProduccionPartido"]["locutor"] = unserialize($data["ProduccionPartido"]["locutor"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($data["ProduccionPartido"]["locutor"]))) : '';
		$data["ProduccionPartido"]["musicalizador"] = unserialize($data["ProduccionPartido"]["musicalizador"])? implode("<br>", $this->obtTrabajadoresEmpresas(unserialize($data["ProduccionPartido"]["musicalizador"]))) : '';

		$data["ProduccionPartido"]["ProduccionTerno"]["nombre"] = isset($data["ProduccionPartido"]["ProduccionTerno"]["nombre"])? $data["ProduccionPartido"]["ProduccionTerno"]["nombre"] : '-';
		//$data["ProduccionPartido"]["ProduccionCamisa"]["nombre"] = isset($data["ProduccionPartido"]["ProduccionCamisa"]["nombre"])? $data["ProduccionPartido"]["ProduccionCamisa"]["nombre"] : '-';
		$data["ProduccionPartido"]["ProduccionCorbata"]["nombre"] = isset($data["ProduccionPartido"]["ProduccionCorbata"]["nombre"])? $data["ProduccionPartido"]["ProduccionCorbata"]["nombre"] : '-';
		$data["ProduccionPartido"]["ProduccionPanuelo"]["nombre"] = isset($data["ProduccionPartido"]["ProduccionPanuelo"]["nombre"])? $data["ProduccionPartido"]["ProduccionPanuelo"]["nombre"] : '-';

		$data["ProduccionPartidosTransmisione"]["NumeroPartido"]["nombre"] = isset($data["ProduccionPartidosTransmisione"]["NumeroPartido"]["nombre"])? $data["ProduccionPartidosTransmisione"]["NumeroPartido"]["nombre"] : '-';
		$data["ProduccionPartidosTransmisione"]["TransmisionesMovile"]["nombre"] = isset($data["ProduccionPartidosTransmisione"]["TransmisionesMovile"]["nombre"])? $data["ProduccionPartidosTransmisione"]["TransmisionesMovile"]["nombre"] : '';
		$data["ProduccionPartidosTransmisione"]["proveedor"] = isset($data["ProduccionPartidosTransmisione"]["proveedor_company_id"])? $this->proveedorCompanies[$data["ProduccionPartidosTransmisione"]["proveedor_company_id"]] : '';
		//pr($data);

		
		$this->set('data', $data);
	}

	public function obtPersonalExterno($idExternos){		
		$this->loadModel("ProduccionContacto");
		$trabajadoresExternos = $this->ProduccionContacto->find("all", array(
			"conditions"=>array(	"estado"=>1,
				"id"=> $idExternos),
			"fields"=>array(
				"id", 
				"nombre"
			)
		));		
		$chilefilmsList = "";
		foreach ($trabajadoresExternos as $key => $trabajadoresChileFilm){
			$chilefilmsList[$trabajadoresChileFilm["ProduccionContacto"]["id"]] = mb_strtoupper($trabajadoresChileFilm["ProduccionContacto"]["nombre"]);  
		}

		return $chilefilmsList;
	}
	public function obtTrabajadoresEmpresas($idCombinados){

		$trabajadores = array();
		$empresas = array();
		$nombres = array();
		//pr($idCombinados);

		if(!empty($idCombinados)){

			foreach ($idCombinados as $id) {
				$formato = explode(":",$id);
				($formato[0]=='T') ? $trabajadores[] = $formato[1] : $empresas[] = $formato[1];
			}

			$empresas = !empty($empresas) ? $this->trabajadoresEmpresaID($empresas) : $empresas;	
			$trabajadores = !empty($trabajadores) ? $this->obtTrabajadores($trabajadores) : $trabajadores;
			
			$nombres = array_merge($trabajadores, $empresas);	
		}
		
		return $nombres;
	}

	public function obtTrabajadores($idTrabajadores){
		$this->loadModel("Trabajadore");
		$this->loadModel("ProduccionNombreRostro");
				
		$cargosTrabajadores  = $this->Trabajadore->find("all", array(
			"conditions"=>array("Trabajadore.id"=>$idTrabajadores),
			"fields"=>array(
				"Trabajadore.id",
				"Trabajadore.nombre",
				"Trabajadore.apellido_paterno",
				//"Trabajadore.apellido_materno",				
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
			$nombre = (isset($nombreRostros[$cargosTrabajadore["Trabajadore"]["id"]]))? $nombreRostros[$cargosTrabajadore["Trabajadore"]["id"]]: strtok($cargosTrabajadore["Trabajadore"]["nombre"], " ").' '.$cargosTrabajadore["Trabajadore"]["apellido_paterno"];
			$cargosTrabajadoresArray[$cargosTrabajadore["Trabajadore"]["id"]] = mb_strtoupper($nombre); 
		}
		
		return $cargosTrabajadoresArray;
	}

	public function trabajadoresEmpresaID($ids=null){

		$this->loadModel("Company");
		$this->loadModel("ProduccionNombreRostro");
		$this->loadModel("ProduccionContacto");

		$nombreCompany = array();
		
		if($ids){

			$contactos = $this->ProduccionContacto->find("all", array(
				"conditions"=>array( 
					"ProduccionContacto.id"=> $ids),
				"fields"=>array("ProduccionContacto.id","ProduccionContacto.nombre", "ProduccionContacto.company_id" ),
				"recursive"=>-1
			));
			foreach ($contactos as $key => $value) {
				$empresasId[] = $value["ProduccionContacto"]["company_id"];
			}

			$nombreCompany = $this->Company->find("all", array(
				"conditions"=>array( 
					"Company.id"=> $empresasId),
				"fields"=>array("Company.id","Company.nombre"),
				"recursive"=>-1
			));
			$nombreRostros = $this->ProduccionNombreRostro->find("list",array( 
				"conditions"=>array("tipo_relacion"=>'E'), 
				"fields"=>array("relacion_id","nombre")
			));	
		}
		
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

	public function add($idPartido=null){
		Configure::write('debug', 1);
		//$this->acceso();

		
		//echo "hola <br><br><br><br><br><br><br><br><br>";
		//echo "hola <br><br><br><br><br><br><br><br><br>";
		//Configure::write('debug', 1); 
		//pr("Hola");
		$this->loadModel("FixturePartido");
		$this->loadModel("ProduccionPartidosTransmisione");
		$this->loadModel("TransmisionesMovile");
		$this->loadModel("TipoTransmisione");
		$this->loadModel("NumeroPartido");
		$this->loadModel("Regione");
		$serv = new ServiciosController();

		$dataPartido = $this->FixturePartido->find("first",array("conditions"=>array("FixturePartido.id"=>$idPartido)));
		$senalesLibres = $this->obtSenalesLibres( $dataPartido["FixturePartido"]["fecha_partido"], $dataPartido["FixturePartido"]["hora_partido"] );
		$this->set("senalesTransmision", $senalesLibres);
		
		$husoHorario = $serv->getUTC($dataPartido["FixturePartido"]["fecha_partido"]);
		$hora = $dataPartido["FixturePartido"]["hora_partido"];
		$dataPartido["FixturePartido"]["hora_partido_gmt"] = date('H:i', strtotime($hora . ' + '.abs($husoHorario).' hours'));
		$dataPartido["FixturePartido"]["hora_partido_gmt_p"] = $dataPartido["FixturePartido"]["hora_partido_gmt"];

		$dataPartido["FixturePartido"]["fecha_partido"] = implode("/",array_reverse(explode("-",$dataPartido["FixturePartido"]["fecha_partido"])));
		$dataPartido["FixturePartido"]["hora_partido"] = substr($dataPartido["FixturePartido"]["hora_partido"],0,5);
		
		$campeonatosList = $this->ProduccionPartidosEvento->Campeonato->find('all', array("fields"=>array("id", "nombre", "codigo"), "conditions"=>array("estado" => 1)));
		$categoriaList = $this->ProduccionPartidosEvento->Categoria->find('all', array("fields"=>array("id", "nombre")));		
		$estadiosList = $this->ProduccionPartidosEvento->Estadio->find('all', array("fields"=>array("id", "nombre", "ciudad", "regione_id")));
		$equiposList = $this->ProduccionPartidosEvento->Equipo->find('all', array("fields"=>array("id", "codigo_marcador", "nombre_marcador")));
		$regiones = $this->Regione->find('list', array("fields"=>array("id", "region_ordinal")));

		foreach ($campeonatosList as $campeonato) $campeonatos[$campeonato["Campeonato"]["id"]] = $campeonato["Campeonato"]["nombre"];
		foreach ($categoriaList as $categoria) $categorias[$categoria["Categoria"]["id"]] = $categoria["Categoria"]["nombre"];		
		foreach ($estadiosList as $estadio) {
			$region = "";
			$region[] = $regiones[$estadio["Estadio"]["regione_id"]];
			$region[] = ($estadio["Estadio"]["regione_id"] != 7) ? ' Región.' : '.';
			$estadios[$estadio["Estadio"]["id"]] = $estadio["Estadio"]["regione_id"] == 0 ? "POR CONFIRMAR" : $estadio["Estadio"]["nombre"].', '.$estadio["Estadio"]["ciudad"]. ', '. mb_strtoupper(implode("",$region));
		}
		foreach ($equiposList as $equipo) $equipos[$equipo["Equipo"]["id"]] = $equipo["Equipo"]["nombre_marcador"].' - '.$equipo["Equipo"]["codigo_marcador"];
		
		$transmisionesMoviles = $this->TransmisionesMovile->find('list', array("fields"=>array("id", "nombre"), "conditions"=>array("estado"=>1), "order" =>"id"));	
		$tipoTransmisiones = $this->TipoTransmisione->find('list', array("fields"=>array("id", "nombre")));
		$numeroPartidos = $this->NumeroPartido->find('list', array("fields"=>array("id", "nombre"), "order" =>"id"));

		$campeonatosSubcategorias = $campeonatosCategorias = $categorias;
		$proveedorCompanies = $this->proveedorCompanies;

		$this->set(compact('campeonatos', 'campeonatosSubcategorias', 'campeonatosCategorias', 'estadios', 'equipos', 'tipoTransmisiones', 'transmisionesMoviles', 'numeroPartidos', 'proveedorCompanies'));
		
		$this->set("dataPartido",$dataPartido["FixturePartido"]);

		if($this->request->is('post')){
						
			$this->request->data["ProduccionPartidosTransmisione"]["senales"] = serialize($this->request->data["ProduccionPartidosTransmisione"]["senales"]);
			$this->request->data["ProduccionPartidosTransmisione"]["estado"] = 1;

			$this->request->data["ProduccionPartidosEvento"]["fecha_partido"] 	= implode("-", array_reverse( explode("/", $this->request->data["ProduccionPartidosEvento"]["fecha_partido"])));
			$this->request->data["ProduccionPartidosEvento"]["fixture_partido_id"] = $idPartido;
			$this->request->data["ProduccionPartidosEvento"]["estado_produccion"] = 1;

			$historial = $this->request->data["ProduccionPartidosEvento"];
			unset($historial["estado_produccion"]);
			unset($historial["fixture_partido_id"]);
			ksort($historial);
			
			$this->request->data["ProduccionPartidosEvento"]["HistorialFixturePartido"][] = array(
				"fixture_partido_id"=>$this->request->data["ProduccionPartidosEvento"]["fixture_partido_id"],
				"historial_cambios"=>json_encode($historial), 
				"user_id"=>$this->Session->read('PerfilUsuario.idUsuario')
			);
			//pr($this->request->data);
			
			if ($this->ProduccionPartidosEvento->saveAssociated($this->request->data, array("deep"=>true))){

				CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->ProduccionPartidosEvento->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") ); 

				$this->Session->setFlash('Se registro la información correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));

			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
			}
		}
	}

	public function edit($id = null){

		$this->acceso();
		
		$this->loadModel("TipoTransmisione");
		$this->loadModel("TransmisionesMovile");
		$this->loadModel("NumeroPartido");
		$this->loadModel("ProduccionPartidosTransmisione");
		$this->loadModel("HistorialFixturePartido");
		$this->loadModel("FixturePartido");
		$this->loadModel("Regione");
		$serv = new ServiciosController();

		if (!$this->ProduccionPartidosEvento->exists($id)) {
			throw new NotFoundException(__('Invalid produccion partido evento'));
		}

		if ($this->request->is(array('post', 'put'))) {


			$this->request->data["ProduccionPartidosTransmisione"]["senales"] = serialize($this->request->data["ProduccionPartidosTransmisione"]["senales"]);
			//$this->request->data["ProduccionPartidosEvento"]["fecha_partido"] =  implode("-", array_reverse( explode("/", $this->request->data['ProduccionPartidosEvento']['fecha_partido'])));

			if ($this->ProduccionPartidosEvento->saveAssociated($this->request->data, array('deep' => true))) {

				CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->ProduccionPartidosEvento->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") ); 

				$this->Session->setFlash('Se registro la información correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			}

		} else {

			

			$options = array('conditions' => array('ProduccionPartidosEvento.' . $this->ProduccionPartidosEvento->primaryKey => $id));
			$this->request->data = $this->ProduccionPartidosEvento->find('first', $options);
			
			$estadiFechaHoraFixture = $this->FixturePartido->find("first", array( 
				"conditions"=> array("FixturePartido.id"=>$this->request->data['ProduccionPartidosEvento']['fixture_partido_id']) 
				));

				$husoHorario = $serv->getUTC($estadiFechaHoraFixture['FixturePartido']['fecha_partido']);
			/*	$hora = $dataPartido["FixturePartido"]["hora_partido"];
				$dataPartido["FixturePartido"]["hora_partido_gmt"] = date('H:i', strtotime($hora . ' + '.abs($husoHorario).' hours'));*/

			$this->set("estadio_id", $estadiFechaHoraFixture['FixturePartido']['estadio_id']);
			$this->set("hora_partido", $estadiFechaHoraFixture['FixturePartido']['hora_partido']);
			$this->set("hora_partido_gmt", date('H:i', strtotime($estadiFechaHoraFixture['FixturePartido']['hora_partido']. ' + '.abs($husoHorario).' hours')));
			$this->set("fixture_partido_id", $this->request->data['ProduccionPartidosEvento']['fixture_partido_id']);

			$this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"], 0,5);
			$this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"], 0,5);
			$this->request->data["ProduccionPartidosTransmisione"]["hora_transmision_gmt"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_transmision_gmt"], 0,5);
			$this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision_gmt"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision_gmt"], 0,5);			

			$senalesLibres = $this->obtSenalesLibres( $this->request->data["ProduccionPartidosEvento"]["fecha_partido"], $this->request->data["ProduccionPartidosEvento"]["hora_partido"] );
			$senalesPartido = $this->listadoSenales(unserialize($this->request->data["ProduccionPartidosTransmisione"]["senales"]));
			$senalesEditables = array_replace($senalesLibres, $senalesPartido);
			ksort($senalesEditables);

			$this->request->data["ProduccionPartidosEvento"]["fecha_partido"] = implode("/", array_reverse( explode("-", $this->request->data["ProduccionPartidosEvento"]["fecha_partido"])));
			$this->request->data["ProduccionPartidosEvento"]["hora_partido"] = substr($this->request->data["ProduccionPartidosEvento"]["hora_partido"], 0, 5);

			$this->set("data", $this->request->data);
			$this->set("senalesTransmision", $senalesEditables);
			$this->set("senalesPartido", unserialize($this->request->data["ProduccionPartidosTransmisione"]["senales"]));

		
		}

		$campeonatosList = $this->ProduccionPartidosEvento->Campeonato->find('all', array("fields"=>array("id", "codigo", "nombre"), "conditions"=>array("estado >" => 1)));
		$categoriaList = $this->ProduccionPartidosEvento->Categoria->find('all', array("fields"=>array("id", "nombre")));		
		$estadiosList = $this->ProduccionPartidosEvento->Estadio->find('all', array("fields"=>array("id", "ciudad", "nombre", "regione_id")));		
		$equiposList = $this->ProduccionPartidosEvento->Equipo->find('all', array("fields"=>array("id", "nombre_marcador", "codigo_marcador")));
		$regiones = $this->Regione->find('list', array("fields"=>array("id", "region_ordinal")));

		foreach ($campeonatosList as $campeonato) $campeonatos[$campeonato["Campeonato"]["id"]] = $campeonato["Campeonato"]["codigo"].' - '.$campeonato["Campeonato"]["nombre"];
		foreach ($categoriaList as $categoria) $categorias[$categoria["Categoria"]["id"]] = $categoria["Categoria"]["nombre"];				
		foreach ($estadiosList as $estadio) {
			$region = "";
			$region[] = $regiones[$estadio["Estadio"]["regione_id"]];
			$region[] = ($estadio["Estadio"]["regione_id"] != 7) ? ' Región.' : '.';
			$estadios[$estadio["Estadio"]["id"]] = $estadio["Estadio"]["regione_id"] == 0 ? "POR CONFIRMAR" : $estadio["Estadio"]["nombre"].', '.$estadio["Estadio"]["ciudad"]. ', '. mb_strtoupper(implode("",$region));
		}
		foreach ($equiposList as $equipo) $equipos[$equipo["Equipo"]["id"]] = $equipo["Equipo"]["codigo_marcador"].' - '.$equipo["Equipo"]["nombre_marcador"];

		$transmisionesMoviles = $this->TransmisionesMovile->find('list', array("fields"=>array("id", "nombre"), "conditions"=>array("estado"=>1), "order" =>"id"));	
		$tipoTransmisiones = $this->TipoTransmisione->find('list', array("fields"=>array("id", "nombre")));
		$numeroPartidos = $this->NumeroPartido->find('list', array("fields"=>array("id", "nombre"), "order" =>"id"));

		$campeonatosSubcategorias = $campeonatosCategorias = $categorias;
		$proveedorCompanies = $this->proveedorCompanies;

		$this->set(compact('campeonatos', 'campeonatosCategorias', 'campeonatosSubcategorias', 'estadios', 'equipos', 'tipoTransmisiones', 'transmisionesMoviles','numeroPartidos', 'proveedorCompanies'));

		$dataTransmision = $this->ProduccionPartidosTransmisione->find("first", array( 
			"conditions"=> array("ProduccionPartidosTransmisione.produccion_partidos_evento_id"=>$id) 
			));		
		$this->set("dataTransmision", $dataTransmision["ProduccionPartidosTransmisione"]);
	}	

	public function reagendar_partido_add($id = null){

		$this->acceso();

		$this->loadModel("TipoTransmisione");
		$this->loadModel("TransmisionesMovile");
		$this->loadModel("NumeroPartido");		
		$this->loadModel("ProduccionPartidosTransmisione");
		$this->loadModel("HistorialFixturePartido");
		$this->loadModel("ProduccionPartidosChilefilm");
		$this->loadModel("ProduccionPartido");
		$this->loadModel("Regione");

		if (!$this->ProduccionPartidosEvento->exists($id)) {
			throw new NotFoundException(__('Invalid produccion partido evento'));
		}

		if ($this->request->is(array('post', 'put'))) {

			$transmisionAnterior = $this->ProduccionPartidosTransmisione->find("first", array( 
				"fields"=> array("ProduccionPartidosTransmisione.*"),
				"conditions" => array("ProduccionPartidosTransmisione.produccion_partidos_evento_id" => $id,
					"ProduccionPartidosTransmisione.estado"=>1),
				));

			$this->request->data["ProduccionPartidosTransmisione"]["senales"] = serialize($this->request->data["ProduccionPartidosTransmisione"]["senales"]);
			$this->request->data["ProduccionPartidosEvento"]["fecha_partido"] = implode("-", array_reverse( explode("/", $this->request->data["ProduccionPartidosEvento"]["fecha_partido"])));

			$historiaCambios = $this->HistorialFixturePartido->find("first", array(
				"conditions"=> array("HistorialFixturePartido.produccion_partidos_evento_id"=>$id), 
				"fields"=>array("HistorialFixturePartido.id","HistorialFixturePartido.historial_cambios"),
				"order" => "HistorialFixturePartido.created DESC",
				"limit" => 1));

			$historia = array();
			if(!empty($historiaCambios)){

				$historia = json_decode($historiaCambios["HistorialFixturePartido"]["historial_cambios"], true);
				unset($historia["estado_produccion"]);
				ksort($historia);
			}

			$partidoNuevo = $this->request->data["ProduccionPartidosEvento"];
			unset($partidoNuevo["id"]);
			unset($partidoNuevo["estado_produccion"]);
			unset($partidoNuevo["fixture_partido_id"]);
			ksort($partidoNuevo);
			
			if($partidoNuevo != $historia){
				$this->request->data["ProduccionPartidosEvento"]["HistorialFixturePartido"][] = array(
					"fixture_partido_id"=>$this->request->data["ProduccionPartidosEvento"]["fixture_partido_id"],
					"historial_cambios"=>json_encode($partidoNuevo), 
					"user_id"=>$this->Session->read('PerfilUsuario.idUsuario')
				);
			}

			unset($this->request->data["ProduccionPartidosTransmisione"]["id"]);
			unset($this->request->data["ProduccionPartidosTransmisione"]["produccion_partidos_evento_id"]);

			$original = $this->ProduccionPartidosEvento->find("first", array( 
				"fields"=> array( "ProduccionPartidosChilefilm.*", "ProduccionPartido.*" ),
				"conditions"=> array( "ProduccionPartidosEvento.id" => $id )
				) 
			);			
						
			if(isset($original["ProduccionPartidosChilefilm"]["id"]))
			{
				unset($original["ProduccionPartidosChilefilm"]["id"], $original["ProduccionPartidosChilefilm"]["produccion_partidos_evento_id"], $original["ProduccionPartidosChilefilm"]["created"], $original["ProduccionPartidosChilefilm"]["modified"]);				
				$this->request->data["ProduccionPartidosChilefilm"] = $original["ProduccionPartidosChilefilm"];
			}
			else
			{
				unset($original["ProduccionPartidosChilefilm"]);
			}

			if(isset($original["ProduccionPartido"]["id"]))
			{
				unset($original["ProduccionPartido"]["id"], $original["ProduccionPartido"]["produccion_partidos_evento_id"], $original["ProduccionPartido"]["created"], $original["ProduccionPartido"]["modified"]);
				$this->request->data["ProduccionPartido"] = $original["ProduccionPartido"];
			}
			else
			{
				unset($original["ProduccionPartido"]);
			}

			// previa/radio
			if( $transmisionAnterior["ProduccionPartidosTransmisione"]["tipo_transmisione_id"] == $this->request->data["ProduccionPartidosTransmisione"]["tipo_transmisione_id"] ) {

				$originalEvento["ProduccionPartidosEvento"] = array("id"=>$id, "estado_produccion"=> 3);	// reagendar: copia produccion completa, da de baja original, guarda log cambios
			}
			else
			{
				$originalEvento["ProduccionPartidosEvento"] = array("id"=>$id);									// clon previa/radio: copia cabecera, deja intacto original, estado 1
				unset($this->request->data["ProduccionPartidosChilefilm"], $this->request->data["ProduccionPartido"], $this->request->data["ProduccionPartidosEvento"]["HistorialFixturePartido"]);
				$this->request->data["ProduccionPartidosEvento"]["estado_produccion"] = 1;
			}

			// nuevo
			if($this->ProduccionPartidosEvento->saveAssociated($this->request->data, array('deep' => true))){

				CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->ProduccionPartidosEvento->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") ); 
				//update
				if ($this->ProduccionPartidosEvento->save($originalEvento)) {

					$this->Session->setFlash('Se registro la información correctamente', 'msg_exito');
					return $this->redirect(array('action' => 'index'));

				}else{
					$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
				}
			}else{
				$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
			}

		} else {

			$options = array('conditions' => array('ProduccionPartidosEvento.' . $this->ProduccionPartidosEvento->primaryKey => $id));
			$this->request->data = $this->ProduccionPartidosEvento->find('first', $options);

			$this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"], 0,5);
			$this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"], 0,5);

			$producciones = $this->ProduccionPartidosEvento->find('all', array(
				"fields"=>array("ProduccionPartidosTransmisione.tipo_transmisione_id"),
				"conditions"=>array("ProduccionPartidosEvento.fixture_partido_id"=>$this->request->data["ProduccionPartidosEvento"]["fixture_partido_id"],
					"ProduccionPartidosEvento.estado_produccion"=>array(1,2)
					),
				"recursive"=>0
				));
			foreach ($producciones as $transmision) {
				$produccionesPartido[] = $transmision["ProduccionPartidosTransmisione"]["tipo_transmisione_id"];
			}
			$produccionesPartido = array_values(array_unique($produccionesPartido));
			$this->set("produccionesPartido", json_encode($produccionesPartido));

			if($this->request->data["ProduccionPartidosTransmisione"]["tipo_transmisione_id"]==3){
				$senalesLibres = $this->obtSenales();
			}
			else{
				$senalesLibres = $this->obtSenalesLibres( $this->request->data["ProduccionPartidosEvento"]["fecha_partido"], $this->request->data["ProduccionPartidosEvento"]["hora_partido"] );
			}

			$senalesPartido = $this->listadoSenales(unserialize($this->request->data["ProduccionPartidosTransmisione"]["senales"]));
			$senalesEditables = array_replace($senalesLibres, $senalesPartido);
			ksort($senalesEditables);

			$this->request->data["ProduccionPartidosEvento"]["fecha_partido"] = implode("/", array_reverse( explode("-", $this->request->data["ProduccionPartidosEvento"]["fecha_partido"])));
			$this->request->data["ProduccionPartidosEvento"]["hora_partido"] = substr($this->request->data["ProduccionPartidosEvento"]["hora_partido"], 0, 5);
			$this->request->data["ProduccionPartidosEvento"]["hora_partido_gmt"] = substr($this->request->data["ProduccionPartidosEvento"]["hora_partido_gmt"], 0, 5);

			$this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_transmision"], 0, 5);
			$this->request->data["ProduccionPartidosTransmisione"]["hora_transmision_gmt"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_transmision_gmt"], 0, 5);
			$this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision"], 0, 5);
			$this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision_gmt"] = substr($this->request->data["ProduccionPartidosTransmisione"]["hora_termino_transmision_gmt"], 0, 5);

			$this->set("data", $this->request->data);
			
			$this->set("senalesTransmision", $senalesEditables);
			$this->set("senalesPartido", unserialize($this->request->data["ProduccionPartidosTransmisione"]["senales"]));
			
		}
		
		$campeonatosList = $this->ProduccionPartidosEvento->Campeonato->find('all', array("fields"=>array("id", "codigo", "nombre"), "conditions"=>array("estado" => 1)));
		$categoriaList = $this->ProduccionPartidosEvento->Categoria->find('all', array("fields"=>array("id", "nombre")));		
		$estadiosList = $this->ProduccionPartidosEvento->Estadio->find('all', array("fields"=>array("id", "ciudad", "nombre", "regione_id")));
		$equiposList = $this->ProduccionPartidosEvento->Equipo->find('all', array("fields"=>array("id", "nombre_marcador", "codigo_marcador")));
		$regiones = $this->Regione->find('list', array("fields"=>array("id", "region_ordinal")));
		
		foreach ($campeonatosList as $campeonato) $campeonatos[$campeonato["Campeonato"]["id"]] = $campeonato["Campeonato"]["nombre"];
		foreach ($categoriaList as $categoria) $categorias[$categoria["Categoria"]["id"]] = $categoria["Categoria"]["nombre"];				
		foreach ($estadiosList as $estadio) {
			$region = "";
			$region[] = $regiones[$estadio["Estadio"]["regione_id"]];
			$region[] = ($estadio["Estadio"]["regione_id"] != 7) ? ' Región.' : '.';
			$estadios[$estadio["Estadio"]["id"]] = $estadio["Estadio"]["regione_id"] == 0 ? "POR CONFIRMAR" : $estadio["Estadio"]["nombre"].', '.$estadio["Estadio"]["ciudad"]. ', '. mb_strtoupper(implode("",$region));
		}
		foreach ($equiposList as $equipo) $equipos[$equipo["Equipo"]["id"]] = $equipo["Equipo"]["nombre_marcador"].' - '.$equipo["Equipo"]["codigo_marcador"];

		$transmisionesMoviles = $this->TransmisionesMovile->find('list', array("fields"=>array("id", "nombre"), "conditions"=>array("estado"=>1), "order" =>"id"));	
		$tipoTransmisiones = $this->TipoTransmisione->find('list', array("fields"=>array("id", "nombre")));
		$numeroPartidos = $this->NumeroPartido->find('list', array("fields"=>array("id", "nombre"), "order" =>"id"));	

		$campeonatosSubcategorias = $campeonatosCategorias = $categorias;
		$proveedorCompanies = $this->proveedorCompanies;

		$this->set(compact('campeonatos', 'campeonatosCategorias', 'campeonatosSubcategorias', 'estadios', 'equipos', 'tipoTransmisiones', 'transmisionesMoviles','numeroPartidos', 'proveedorCompanies'));
	}

	public function delete_produccion_partidos($id = null) {
		$this->layout = "ajax";

		if (!$this->ProduccionPartidosEvento->exists($id)) {
			$this->Session->setFlash('Ocurrio un erro intentelo nuevamente', 'msg_fallo');
			return $this->redirect(array('action' => 'index'));
		}

			$this->request->data["ProduccionPartidosEvento"]["id"] = $id;
			$this->request->data["ProduccionPartidosEvento"]["estado_produccion"] = 0;

			if ($this->ProduccionPartidosEvento->save($this->request->data)) {

				CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->ProduccionPartidosEvento->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") ); 

				$this->Session->setFlash('El registro se elimino correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error al tratar de eliminar el registro', 'msg_fallo');
			}
	}

	public function obtTipoPartido($fecha=null, $hora=null){
		$cantidadPartidos = 0;
		if($fecha && $hora){
			$cantidadPartidos = $this->ProduccionPartidosEvento->find('all', array(
	        	'conditions' => array('ProduccionPartidosEvento.fecha_partido' => $fecha,
	        		"ProduccionPartidosEvento.hora_partido" => $hora,
	        		"ProduccionPartidosEvento.estado_produccion in"=>array(1,2),
	        		"ProduccionPartidosTransmisione.estado" => 1,
	        		"ProduccionPartidosTransmisione.tipo_transmisione_id"  => 1
	        		)
	    	));
		}

		switch ($cantidadPartidos) {
		    case 2:
		        $transmision = "DUPLEX";
		        break;
		    case 3:
		        $transmision = "TRIPLEX";
		        break;
		    case 4:
		        $transmision = "CUADRUPLEX";
		        break;
		    default:
       			$transmision = "-";
		}
		return $transmision;
	}

	public function listadoTrabajadores($idTrabajadores){
		$this->loadModel("Trabajadore");	
		if(!empty($idTrabajadores)){
			$trabajadores = $this->Trabajadore->find("all", array( 
				"conditions"=> array("Trabajadore.id" => $idTrabajadores), 
				"fields"=> array("Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.apellido_materno"),
				"recursive" => -1
				));
		}
		if(!empty($trabajadores))
		{
			foreach ($trabajadores as $trabajador) {
				$listadoTrabajadores[] = mb_strtoupper( strtok($trabajador["Trabajadore"]["nombre"], " ") .' '.$trabajador["Trabajadore"]["apellido_paterno"] );
			}
		}else{
			$listadoTrabajadores = array('');	
		}
		return $listadoTrabajadores;
	}

	public function listadoSenales($idSenal=null){
		$this->loadModel("Channel");
		$senalesNombres = $senalesTransmision = array();
		if($idSenal){
			$senalesTransmision = $this->Channel->find("list", array(
				"fields"=>array( "Channel.id", "Channel.nombre"), 
				"conditions"=> array( "Channel.id" => $idSenal ),
				"order" => "Channel.id" )
			);
			foreach ($senalesTransmision as $key => $value){
				$senalesNombres[$key] = $key == 5 ? "Estadio CDF" : $value;			
			}		
		}		
		
		return $senalesNombres;
	}

	public function obtSenales(){
		$this->loadModel("Channel");
		$senalesTransmision = $this->Channel->find("list", array(
			"fields"=>array( "Channel.id", "Channel.nombre"), 
			"conditions"=> array("Channel.tipo"=>1, "Channel.estado" => 1, "Channel.id" => array(1, 2, 3, 5, 17, 18)),
			"order" => "Channel.id" )
		);
		foreach ($senalesTransmision as $key => $value){
			$senalesNombres[$key] = $key == 5 ? "Estadio CDF" : $value;			
		}
		return $senalesNombres;
	}

	public function senalesLibres(){
		$this->autoRender = false;
		$formato = 'json';
		$this->response->type("json");

		$senalesLibres = array();

		if(isset($this->request->query["dia"]) && isset($this->request->query["hora"])){

			$fecha = implode("-",array_reverse(explode("/",$this->request->query["dia"])));			

			if( isset($this->request->query["id"]) ){
				$senalesLibres = $this->obtSenalesLibres($fecha, $this->request->query["hora"], $this->request->query["id"]);
			}else{
				$senalesLibres = $this->obtSenalesLibres($fecha, $this->request->query["hora"]);	
			}
			
		}
		return json_encode($senalesLibres);		
	}

	public function obtSenalesLibres($fecha=null, $hora=null, $idProduccion = null){	
		$this->loadModel("Channel");
		$this->loadModel("FixturePartido");

		$formato = '';
		$senalesNombres = $senalesOcupadas = array();

		$cantidadPartidos = $this->ProduccionPartidosEvento->find('all', array(
			"fields"=>array("ProduccionPartidosTransmisione.senales"),
        	'conditions' => array(
        		"ProduccionPartidosEvento.id !=" => $idProduccion,
        		'ProduccionPartidosEvento.fecha_partido' => $fecha,
        		"ProduccionPartidosEvento.hora_partido" => $hora,
        		"ProduccionPartidosEvento.estado_produccion not"=> array(3,0),   	// reagendado, eliminado
        		//"ProduccionPartidosTransmisione.tipo_transmisione_id" => 1
        		)
    	));
		foreach ($cantidadPartidos as $partido) $senalesOcupadas = array_merge($senalesOcupadas, unserialize($partido["ProduccionPartidosTransmisione"]["senales"]));				
		
		if(in_array(5, $senalesOcupadas)) {
			$senalesOcupadas = array_diff($senalesOcupadas, [5]);
			//unset($senalesOcupadas[array_search(5, $senalesOcupadas)]); 
		}	

		$senalesLibres = $this->Channel->find("list", array(
			"fields"=>array( "Channel.id", "Channel.nombre"), 
			"conditions"=> array( "Channel.tipo"=>1, 
				"Channel.estado" => 1, 
				"Channel.id in" => array(1, 2, 3, 5, 17, 18),
				//"Channel.codigo not" => null, 
				"Channel.id !=" => $senalesOcupadas
				),
			"order" => "Channel.id"
			));
		
		foreach ($senalesLibres as $key => $value){
			$senalesNombres[$key] = $key == 5 ? "Estadio CDF" : $value;			
	}

		return $senalesNombres;
	}

}