<?php
App::uses('AppController', 'Controller');
/**
 * Soportes Controller
 *
 * @property Soporte $Soporte
 * @property PaginatorComponent $Paginator
 */
class SoportesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function soportes_list(){
		$this->autoRender = false;
		//$this->response->type("json");
		$soportes = $this->Soporte->find("all", array("conditions"=>array("Soporte.estado"=>1), "recursive"=>-1));
		if(!empty($soportes)){
			foreach ($soportes as $soporte) {
				$respuesta[] = array(
					"id"=>$soporte["Soporte"]["id"],
					"nombre"=>$soporte["Soporte"]["nombre"],
					"tipo"=>$soporte["Soporte"]["tipo"]
					);
			}
		}else{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}
}
