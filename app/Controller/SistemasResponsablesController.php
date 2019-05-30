<?php
App::uses('AppController', 'Controller');
/**
 * SistemasResponsables Controller
 *
 * @property SistemasResponsable $SistemasResponsable
 * @property PaginatorComponent $Paginator
 */
class SistemasResponsablesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function sistemas_responsables_list(){
		$this->autoRender = false;
		$this->response->type("json");
		$responsables = $this->SistemasResponsable->find("all", array(
			"conditions"=>array(
				"SistemasResponsable.estado"=>1
			),
			"recursive"=>-1
		));
		if(!empty($responsables)){
			foreach ($responsables as $responsable) {
				$respuesta[] = array(
					"id"=>$responsable["SistemasResponsable"]["id"],
					"user_id"=>$responsable["SistemasResponsable"]["user_id"],
					"tipo"=>$responsable["SistemasResponsable"]["tipo"],
					"admin"=>$responsable["SistemasResponsable"]["admin"],
				);
			}
		}else{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}

}
