<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
/**
 * FixturePartidos Controller
 *
 * @property FixturePartido $FixturePartido
 * @property PaginatorComponent $Paginator
 */
class FixturePartidosController extends AppController {

	public function index() {
		$this->acceso();
		$this->layout = "angular";
	}

	public function lista_fixtures_json(){

		$this->layout = "ajax";
		$this->response->type("json");
		$serv = new ServiciosController();
		$this->loadModel("FixturePartido");
		$this->loadModel("ProduccionPartidosEvento");
		$this->loadModel("Regione");

		//if($this->params->isAjax == 1)
		//{

			$regiones = $this->Regione->find("list", array("fields"=>array("id","region_ordinal")));

			$partidosEst = $this->ProduccionPartidosEvento->find("all", array( 
				"fields" => array("DISTINCT ProduccionPartidosEvento.fixture_partido_id", "ProduccionPartidosEvento.estado_produccion", "ProduccionPartidosEvento.fecha_partido", "ProduccionPartidosEvento.hora_partido_gmt"),
				"conditions" => array( "ProduccionPartidosEvento.estado_produccion"=>array(1,2) ), 					//planificando, completados
				"recursive" => -1,
				"order"=>array("ProduccionPartidosEvento.fixture_partido_id")
			));
			foreach ($partidosEst as $key => $partidoEst) {
				$estadoPartidos[$partidoEst["ProduccionPartidosEvento"]["fixture_partido_id"]]["estados_produccion"][] = $partidoEst["ProduccionPartidosEvento"]["estado_produccion"];
				unset($partidoEst["ProduccionPartidosEvento"]["estado_produccion"]);
				$estadoPartidos[$partidoEst["ProduccionPartidosEvento"]["fixture_partido_id"]] = array_merge($estadoPartidos[$partidoEst["ProduccionPartidosEvento"]["fixture_partido_id"]], $partidoEst["ProduccionPartidosEvento"]);
			}
			
			$partidos = $this->FixturePartido->find("all", array(
				"conditions"=>array("FixturePartido.estado" =>1)
			));
			$fixturesJson = array();
			foreach ($partidos as  $partido) {

				$estado = 0;
				$mensaje = '';
				if(isset($estadoPartidos[$partido["FixturePartido"]["id"]])){

					$estado = 1;
					$mensaje = 'El Partido que desea eliminar tiene Producciones asociadas. Deberá eliminarlas antes de continuar.';

					if(in_array(2, $estadoPartidos[$partido["FixturePartido"]["id"]]["estados_produccion"])){	//completado

						$fechaActual = date('Y-m-d H:i:s', time());
			 			$fechaActual = strtotime($fechaActual);
						$fechaPartido = $estadoPartidos[$partido["FixturePartido"]["id"]]["fecha_partido"].' '.$estadoPartidos[$partido["FixturePartido"]["id"]]["hora_partido_gmt"];
						$fechaPartido = strtotime($fechaPartido);

						if($fechaPartido < $fechaActual){ 			// jugado
							$mensaje = 'No puede eliminar partidos jugados. Comuníquese con el Administrador.';
						}
					}
				}

				$region = "";
				$region[] = $regiones[$partido["Estadio"]["regione_id"]];
				$region[] = ($partido["Estadio"]["regione_id"] != 7) ? ' Región.' : '.';

				$fixturesJson[] = array(
					"id"=>$partido["FixturePartido"]["id"],
					"nombre_torneo"=>$partido["Campeonato"]["nombre"].' '.$partido["Categoria"]["nombre"].' '.$partido["Subcategoria"]["nombre"],
					"torneo"=>$partido["Campeonato"]["nombre"],
					"categoria"=>$partido["Categoria"]["nombre"],
					"subcategoria"=>$partido["Subcategoria"]["nombre"],
					"estadio"=> $partido["Estadio"]["nombre"] == 'POR CONFIRMAR' ? $partido["Estadio"]["nombre"] : $partido["Estadio"]["nombre"] .', '.$partido["Estadio"]["ciudad"] .', '. mb_strtoupper(implode("", $region)),
					"equipo_local"=>$partido["Equipo"]["nombre_marcador"],
					"equipo_visita"=>$partido["EquipoVisita"]["nombre_marcador"],
					"fecha_partido"=>$partido["FixturePartido"]["fecha_partido"],
					"hora_partido"=>substr($partido["FixturePartido"]["hora_partido"],0,5),
					"transmite_cdf" =>($partido["FixturePartido"]["transmite_cdf"]) ? 'CDF': '-',
					"producciones_vigentes" => $estado,
					"mensaje_eliminar" => $mensaje
				);
			}
			
			if(!empty($fixturesJson))
				$fixturesJson = $serv->sort_array_multidim($fixturesJson, "fecha_partido ASC, hora_partido ASC");
		//}
		$this->set('listado',$fixturesJson);
	}

	public function listaCategorias(){
		$this->layout = "null";
		$this->response->type("json");
		$this->loadModel("CampeonatosRelacione");

		$campeonato = $this->FixturePartido->Campeonato->find('first', array("fields"=>array("id", "nombre", "tipo_campeonato_id"), "conditions"=>array("id" => $this->params->query['id'])));

		//categorias
		$campeonatosCat = $this->CampeonatosRelacione->find('all', array(
			"conditions"=>array("CampeonatosRelacione.estado" => 1,
				"CampeonatosRelacione.tipo_campeonato_id"=> $campeonato["Campeonato"]["tipo_campeonato_id"],
				"CampeonatosRelacione.dependencia"=> null)
			)
		);

		$categoriasList = array();
		foreach ($campeonatosCat as $key => $value) {
			$categorias = $this->obtCategorias(json_decode($value["CampeonatosRelacione"]["categoria_id"],true));
			foreach ($categorias as $key => $categoria) {
				$categoriasList[$key.'*'.$value["CampeonatosRelacione"]["id"]] = $categoria;
			}
		}
		
		$categoriasJson = array("categorias"=> $categoriasList);
		echo json_encode($categoriasJson); 
		exit;
	}

	public function listaSubCategorias(){
		$this->layout = "null";
		$this->response->type("json");
		$this->loadModel("CampeonatosRelacione");

		$campeonato = $this->FixturePartido->Campeonato->find('first', array("fields"=>array("id", "nombre", "tipo_campeonato_id"), "conditions"=>array("id" => $this->params->query['idCampeonato'])));
		$relacionCat = $this->CampeonatosRelacione->find('all', array(
			"conditions"=>array("CampeonatosRelacione.dependencia"=> $this->params->query['idDependencia'],
				"CampeonatosRelacione.tipo_campeonato_id"=> $campeonato["Campeonato"]["tipo_campeonato_id"]
				)
			)
		);
	
		if(!empty($relacionCat)){
			foreach ($relacionCat as $key => $value) {
				$subCategorias = $this->obtCategorias(json_decode($value["CampeonatosRelacione"]["categoria_id"],true));
				foreach ($subCategorias as $key => $sub) {
					$subCategoriasList[$key] = $sub;
				}				
			}
		}
		else{
			$subCategoriasList = array();
		}

		$subCategoriasJson = array("subCategorias"=> $subCategoriasList);
		echo json_encode($subCategoriasJson); 
		exit;
	}

	public function obtCategorias($ids){
		$this->loadModel("CampeonatosCategoria");
		$categorias = $this->CampeonatosCategoria->find('list', array(
			"fields"=>array("id", "nombre"),
			"conditions" => array("id"=>$ids)
			)
		);
		return $categorias;
	}

	public function add_fixtures() {
		$this->acceso();
		$this->loadModel("FixturePartido");
		$this->loadModel("Regione");

		$campeonatosList = $this->FixturePartido->Campeonato->find('all', array("fields"=>array("id", "nombre"), "conditions"=>array("estado" => 1)));
		$estadiosList = $this->FixturePartido->Estadio->find('all', array("fields"=>array("id", "nombre", "ciudad", "localia_equipo_id", "regione_id")));
		$equiposList = $this->FixturePartido->Equipo->find('all', array("fields"=>array("id", "nombre_marcador", "codigo_marcador"), "conditions"=> array("Equipo.nombre_marcador NOT" => null), "order"=>"nombre_marcador" ));	
		$regiones = $this->Regione->find('list', array("fields"=>array("id", "region_ordinal")));
	
		foreach ($campeonatosList as $campeonato) $campeonatos[$campeonato["Campeonato"]["id"]] = $campeonato["Campeonato"]["nombre"];

		foreach ($estadiosList as $estadio) {
			$region = "";
			$region[] = $regiones[$estadio["Estadio"]["regione_id"]];
			$region[] = ($estadio["Estadio"]["regione_id"] != 7) ? ' Región.' : '.';
			$estadios[$estadio["Estadio"]["id"]] =  $estadio["Estadio"]["regione_id"] == 0 ? "POR CONFIRMAR" : $estadio["Estadio"]["nombre"].', '.$estadio["Estadio"]["ciudad"]. ', '. mb_strtoupper(implode("",$region));
			$estadioRelacion[] = array("id"=>$estadio["Estadio"]["id"],"localia_equipo_id"=>$estadio["Estadio"]["localia_equipo_id"]);
		}
		
		foreach ($equiposList as $equipo) $equipos[$equipo["Equipo"]["id"]] = $equipo["Equipo"]["nombre_marcador"] .' - '. $equipo["Equipo"]["codigo_marcador"];

		$this->set(compact('campeonatos', 'estadios', 'equipos'));	
		
		$this->set("estadiosRelacion", json_encode($estadioRelacion));

		if ($this->request->is('post')) {			

			$partidos = array();
			$countRepetidos = 0;
			foreach ($this->request->data["FixturePartido"] as $partido) {
				
				if(isset($partido["campeonatos_categoria_id"])){
					$arrCat = explode("*",$partido["campeonatos_categoria_id"]);
					$partido["campeonatos_categoria_id"] = $arrCat[0];
				}
				if(isset($partido["campeonatos_subcategoria_id"])){
					$arrSubCat = explode("*",$partido["campeonatos_subcategoria_id"]);
					$partido["campeonatos_subcategoria_id"] = $arrSubCat[0];
				}				

				if(isset($partido["campeonato_id"]) && isset($partido["fecha_partido"]) && isset($partido["hora_partido"]) && isset($partido["estadio_id"]) && isset($partido["local_equipo_id"]) && isset($partido["visita_equipo_id"]) && isset($partido["transmite_cdf"]) ){

					$existePartidos = $this->FixturePartido->find("all", array(
						"conditions"=>array(
							"FixturePartido.estado" =>1,
							"FixturePartido.fecha_partido" => implode("-", array_reverse(explode("/",$partido["fecha_partido"]))),
							"FixturePartido.estadio_id" => $partido["estadio_id"],
							"FixturePartido.local_equipo_id" => $partido["local_equipo_id"],
							"FixturePartido.visita_equipo_id" => $partido["visita_equipo_id"]
						)
					));

					if (!empty($existePartidos)) {
						$countRepetidos++;

					} else {

						$partido["fecha_partido"] = implode("-", array_reverse( explode("/", $partido["fecha_partido"])));						
						$partido["estado"] = 1;
						$partido["user_id"] = $this->Session->Read("PerfilUsuario.idUsuario");
						$partidos[] = $partido;
					}					
				}

			}

			if(!empty($partidos)){

				$cantidadPartidos = count($partidos);
				$partidos = array_map("unserialize", array_unique(array_map("serialize", $partidos)));
				$cantidadPartidos2 = count($partidos);
				
				$countRepetidos = $cantidadPartidos - $cantidadPartidos2;

				$mensajeRepetidosEliminado = '';				
				
				if ($this->FixturePartido->saveAll($partidos)) {
					
					if ($countRepetidos > 0) {
						$mensajeRepetidosEliminado = 'Observación: '. $countRepetidos.' partido(s) no fue ingresado por estar repetido.';
					}

					CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' guardo - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario")); 

					$this->Session->setFlash('Se registro la información correctamente. '.$mensajeRepetidosEliminado, 'msg_exito');

					return $this->redirect(array('controller'=>'fixture_partidos','action' => 'index'));

				} else {
					$this->Session->setFlash('Ocurrio un error al tratar de registrar la informacion', 'msg_fallo');
				}

			} else {

				if ($countRepetidos>0) {
					
					$mensajeRepetidosEliminado = $countRepetidos.' partido(s) ya se encuentran ingresados.';
					
					$this->Session->setFlash($mensajeRepetidosEliminado, 'msg_fallo');

				}else {

					$this->Session->setFlash('Debe completar toda la información de partidos.', 'msg_fallo');
				}				
			}

		}
	}

	public function delete_partidos($id = null) {

		$this->layout = "ajax";

		$this->loadModel("ProduccionPartidosEvento");

		if (!$this->FixturePartido->exists($id)) {
			$this->Session->setFlash('Ocurrio un erro intentelo nuevamente', 'msg_fallo');
			return $this->redirect(array('controller'=>'fixture_partidos','action' => 'index'));
		}

		$partidos = $this->ProduccionPartidosEvento->find("all", array( 
			"conditions"=> array("ProduccionPartidosEvento.fixture_partido_id"=>$id,
				"ProduccionPartidosEvento.estado_produccion"=>array(1,2)  //planificando, completados				
				),
			"recursive"=>-1
			));

		if(empty($partidos)){

			$this->request->data["FixturePartido"]["id"] = $id;
			$this->request->data["FixturePartido"]["estado"] = 0;
			$this->request->data["FixturePartido"]["user_id"] = $this->Session->Read("PerfilUsuario.idUsuario");

			if ($this->FixturePartido->save($this->request->data)) {
				CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' elimino - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario")); 
				$this->Session->setFlash('El registro se elimino correctamente', 'msg_exito');
				return $this->redirect(array('controller'=>'fixture_partidos','action' => 'index'));

			} else {

				$this->Session->setFlash('Ocurrio un error al tratar de eliminar el registro', 'msg_fallo');
			}

		}else{

			foreach ($partidos as $partido) {

				if($partido["ProduccionPartidosEvento"]["estado_produccion"]==1){ 

					$estado = 0;										// planificando
				}
				elseif($partido["ProduccionPartidosEvento"]["estado_produccion"]==2){

		 			$fechaActual = date('Y-m-d H:i:s', time());
		 			$fechaActual = strtotime($fechaActual);
					$fechaPartido = $partido["ProduccionPartidosEvento"]["fecha_partido"].' '.$partido["ProduccionPartidosEvento"]["hora_partido_gmt"];
					$fechaPartido = strtotime($fechaPartido);

					if($fechaPartido < $fechaActual){ 			// jugado
						$estado = 1;
					}
					else{
						$estado = 0;									// por jugar
					}
				}
			}

			if($estado == 1){
				$mensaje = 'No puede eliminar Partidos Jugados. Comuníquese con el Administrador.';
			}
			else{
				$mensaje = 'El Partido que desea eliminar tiene Producciones asociadas. Deberá eliminarlas antes de continuar.';
			}

			$this->Session->setFlash($mensaje, 'msg_fallo');
			return $this->redirect(array('controller'=>'fixture_partidos','action' => 'index'));

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