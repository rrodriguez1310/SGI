<?php
App::uses('AppController', 'Controller');
/**
 * CatalogacionPartidosMedios Controller
 *
 * @property CatalogacionPartidosMedio $CatalogacionPartidosMedio
 * @property PaginatorComponent $Paginator
 */
class CatalogacionPartidosMediosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function add ($idCatalogacionPartido){
		$this->layout = "angular";
		$this->loadModel("CatalogacionPartido");
		$this->CatalogacionPartido->id = $idCatalogacionPartido;
		if(!$this->CatalogacionPartido->exists()){
			$this->Session->setFlash('El evento no existe, por favor vuelva a intentarlo', 'msg_fallo');
			return $this -> redirect(array("controller" => 'catalogacion_partidos', "action" => 'index'));
		} 
	}

	public function registrar_medios(){
		$this->autoRender = false;
		$this->response->type("json");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				if(!isset($this->request->data["CatalogacionPartidosMedio"]["id"])){
					$this->request->data["CatalogacionPartidosMedio"]["user_id"] = $this->Session->Read("PerfilUsuario.idUsuario");
					$mensajeLog = 'Registro - CatalogacionPartidosMedios - registrar_medios id';
					$mensajeFlash = 'Se registro correctamente';
				}else{
					$mensajeLog = 'Edito - CatalogacionPartidosMedios - registrar_medios id';
					$mensajeFlash = 'Se edito correctamente';
				}
				if($this->CatalogacionPartidosMedio->save($this->request->data)){
					CakeLog::write('actividad', $mensajeLog.' - '.$this->CatalogacionPartidosMedio->id.' - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash(__($mensajeFlash), "msg_exito");
					$respuesta = array(
						"estado"=>1,
						"id"=>$this->request->data["CatalogacionPartidosMedio"]["catalogacion_partido_id"]
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

	public function edit($id = null){
		$this->layout = "angular";
		$this->CatalogacionPartidosMedio->id = $id;
		if($this->CatalogacionPartidosMedio->exists()){
			$catalogacionPartidosMedio = $this->CatalogacionPartidosMedio->findById($this->CatalogacionPartidosMedio->id);
			$this->set("catalogacionPartidoId", $catalogacionPartidosMedio["CatalogacionPartido"]["id"]);
		}else{
			$this->Session->setFlash('El medio no existe, por favor vuelva a intentarlo', 'msg_fallo');
			return $this -> redirect(array("controller" => 'catalogacion_partidos', "action" => 'index'));
		}
	}

	public function catalogacion_partidos_medio(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->CatalogacionPartidosMedio->id = $this->request->query["id"];
		$catalogacionPartidosMedio = $this->CatalogacionPartidosMedio->findById($this->CatalogacionPartidosMedio->id);
		if(!empty($catalogacionPartidosMedio)){
			$respuesta = array(
				"estado"=>1,
				"data"=>$catalogacionPartidosMedio
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No se encontro el medio solicitado"
				);		
		}
		return json_encode($respuesta);
	}

}
