<?php
App::uses('AppController', 'Controller');
App::uses('ProduccionPartidosEventosController', 'Controller');
App::uses('ServiciosController', 'Controller');


/**
 * ProduccionPartidosOptas Controller
 *
 * @property ProduccionPartidosOpta $ProduccionPartidosOpta
 * @property PaginatorComponent $Paginator
 */
class ProduccionPartidosOptasController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index(){		
		$this->layout = "angular";
		//$this->acceso();
	}

	public function lista_opta_json(){
		$this->layout = "ajax";
		$this->response->type("json");
		$produccion = new ProduccionPartidosEventosController;
		$anioActual = date("Y").'-01-01';
		$partidosProd = $produccion->lista_eventos_json($anioActual);
		$senalesList = $produccion->obtSenales();	

		$partidosIds = array();		
		$previaHora = array();
		$senalesPartido = array();

		foreach($partidosProd["partidos"] as $partido){			

			if (!isset($senalesPartido[$partido["id_partido"]]))
				$senalesPartido[$partido["id_partido"]] = array();

			switch ($partido["tipo_transmisione_id"]) {
				case 1: $partidosIds[] = $partido["id"];						
						$senalesPartido[$partido["id_partido"]] = array_merge($partido["senales_id"], $senalesPartido[$partido["id_partido"]]);
						break;
				case 2: $senalesPartido[$partido["id_partido"]] = array_merge($partido["senales_id"], $senalesPartido[$partido["id_partido"]]);
						break;				
			}
		}		
	
		$partidosOptasArr = $this->ProduccionPartidosOpta->find(
			"all",
			array(
				"conditions" => array("ProduccionPartidosOpta.produccion_partidos_evento_id" => $partidosIds) 
			)
		);
		$partidosOptas = array();
		foreach($partidosOptasArr as $partidoOpta){
			$partidosOptas[$partidoOpta["ProduccionPartidosOpta"]["produccion_partidos_evento_id"]] = $partidoOpta["ProduccionPartidosOpta"];
		}

		foreach($partidosProd["partidos"] as $partido){

			if ($partido["tipo_transmisione_id"] == 1) { //vivos

				if ( array_key_exists($partido["id"],$partidosOptas) ){
					$partido["opta_game_id"] = $partidosOptas[$partido["id"]]["opta_game_id"];
					$partido["produccion_partidos_opta_id"] = $partidosOptas[$partido["id"]]["id"];									
				}
				$partido["senales_id"] = $senalesPartido[$partido["id_partido"]];

				foreach($partido["senales_id"] as $senal){
					$partido["senales"][] = $senalesList[$senal];
				}
				$partido["senales"] = implode(", ", $partido["senales"]);

				$partidosProdOpta[] = $partido;
			}
		}		

		$this->set('listado',$partidosProdOpta); 
	}

	public function archivo_opta_xml($idSeason, $idCompetition){
		$this->layout = "ajax";		
		$this->autoRender = false;
		$servicio = new ServiciosController;
		$partidos = array();

		$content = $servicio->kapi_getxml('http://omo.akamai.opta.net/competition.php?competition='.$idCompetition.'&season_id='.$idSeason.'&json&feed_type=f1&user=geca_cdf&psw=0pt4@!D');		
		$parseData = json_decode($content, true);

		if (isset($parseData["response"]) && !isset($parseData["SoccerFeed"]["SoccerDocument"]) ) {

			$respuesta = array(
				"data" => $partidos,
				"mensaje" => $parseData["response"],
				"estado" => 0
			);

		} else {

			$dataOpta = $parseData["SoccerFeed"]["SoccerDocument"];
			$equiposOpta = $dataOpta["Team"];
			foreach($equiposOpta as $equipo){
				$equipos[$equipo["@attributes"]["uID"]] = mb_strtoupper($equipo["Name"]);
			}

			if (isset($dataOpta["MatchData"][0])){			//identifica campeonatos de un solo partido.
				$partidosOpta = $dataOpta["MatchData"];	
			} else {				
				$partidosOpta[] = $dataOpta["MatchData"];
			}
			
			foreach($partidosOpta as $match){

				if (gettype($match["MatchInfo"]["Date"]) == 'array'){
					$fcOpta = $match["MatchInfo"]["Date"]["@value"];
				} else {
					$fcOpta = $match["MatchInfo"]["Date"];
				}
				$date = new DateTime((string)$fcOpta, new DateTimeZone('Europe/London'));
				$partido["fecha_opta"] = date('Y-m-d H:i:s',$date->format('U'));
				$partido["tz_opta"] = $match["MatchInfo"]["TZ"];
				date_default_timezone_set('America/Santiago');
				$partido["dia_opta"] = date('Y-m-d',$date->format('U'));
				$partido["hora_opta"] = date('H:i',$date->format('U'));

				//if ($partido["dia_opta"] >= date('Y-m-d')){

					$partido["partidoId"] = substr($match["@attributes"]["uID"],1);

					if ( array_key_exists("Stat", $match) ) {
						if ( array_key_exists(0, $match["Stat"])) {
							if ( array_key_exists("@value", $match["Stat"][0]) ) {
								$partido["estadio"] = mb_strtoupper($match["Stat"][0]["@value"]);
							}
						} else { 
							if (array_key_exists("@value",$match["Stat"]) ){
								$partido["estadio"] = mb_strtoupper($match["Stat"]["@value"]);
							}					
						}
					}

					foreach($match["TeamData"] as $equipo){				
						if ( mb_strtoupper($equipo["@attributes"]["Side"]) == 'HOME' ){
							$partido["localNombre"] = $equipos[$equipo["@attributes"]["TeamRef"]];
							$partido["localId"] = substr($equipo["@attributes"]["TeamRef"],1);
						} else {
							$partido["visitalNombre"] = $equipos[$equipo["@attributes"]["TeamRef"]];
							$partido["visitaId"] = substr($equipo["@attributes"]["TeamRef"],1);
						}
					}

					$partido["campeonato"] = $dataOpta["@attributes"]["competition_name"];
					$partido["campeonatoId"] = $dataOpta["@attributes"]["competition_id"];
					$partido["temporada"] = $dataOpta["@attributes"]["season_id"];

					$partidos[] = $partido;			
				//}			
			}

			$respuesta = array(
				"data" => $partidos,
				"mensaje" => "Ok",
				"estado" => 1
			);
		}

		return json_encode($respuesta);

	}

	public function guardar_data_opta(){

		$this->layout = "ajax";
		$this->response->type("json");	
		$servicio = new ServiciosController;
		$protocol = 'http://';
		$protocolS  = 'https://';
		$urlDev = '200.91.40.246/app_campeonatos/cpan/campeonatos/set_programacion/';
		$urlProd = 'www.cdf.cl/app_campeonatos/cpan/campeonatos/set_programacion/';
		$pass = urldecode('fdt%$bhr4f');

		$cdf = false;
	
		if (isset($this->request->data["cdf"])){
			$cdf = $this->ProduccionPartidosOpta->saveAll($this->request->data["cdf"]);
		}

		if($cdf){
			
			$partidos = array();
			$dataAltavoz = $this->request->data["altavoz"];

			//$response = $servicio->kapi_post($protocol.'cdf:'.$pass.'@'.$urlDev, $dataAltavoz);			
			$response = $servicio->kapi_post($protocolS.$urlProd, $dataAltavoz);	 						

			$parseData = json_decode($response, true);			
			
			if ($parseData["exito"]){

				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Información actualizada en Altavoz.",
					"respuesta"=>$parseData
				);

			} else {
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se pudo actualizar Altavoz ",
					"respuesta"=>$parseData
				);
			}
			
		} else {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No se pudo actualizar el sistema"				
				);
		}

		$this->set("respuesta", $respuesta);
	}


}