<?php
App::uses('AppController', 'Controller');
/**
 * CatalogacionRResponsables Controller
 *
 * @property CatalogacionResponsable $CatalogacionResponsable
 * @property PaginatorComponent $Paginator
 */
class CatalogacionRResponsablesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function responsable_usuario(){
		$this->autoRender = false;
		if($this->Session->Read("Users.flag") == 1){
			if(isset($this->request->query["id"])){
				$responsable = $this->CatalogacionRResponsable->findByUserId($this->request->query["id"]);
				if(!empty($responsable)){
					$respuesta = array(
						"estado"=>1,
						"data"=>$responsable
					);
				}else{
					$respuesta = array("estado"=>2);	
				}
			}else{
				$this->Session->setFlash('Falta id usuario', 'msg_fallo');
				return $this->redirect(array("controller"=>"dashboards",'action' => 'index'));
			}
		}

		return json_encode($respuesta);
	}

	public function catalogacion_r_responsables_list(){		
		$this->autoRender = false;
		$responsables = $this->CatalogacionRResponsable->find("all", array("conditions"=>array("CatalogacionRResponsable.estado"=>1), "recursive"=>-1));
		if(!empty($responsables)){
			foreach ($responsables as $responsable) {
				$respuesta[] = array(
					"id"=>$responsable["CatalogacionRResponsable"]["id"],
					"user_id"=>$responsable["CatalogacionRResponsable"]["user_id"],
					"tipo"=>$responsable["CatalogacionRResponsable"]["tipo"]
				);
			}
		}else{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}
}
