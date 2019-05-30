<?php
App::uses('AppController', 'Controller');
/**
 * TiposMonedas Controller
 *
 * @property TiposMoneda $TiposMoneda
 * @property PaginatorComponent $Paginator
 */
class TiposMonedasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function tipos_monedas_list(){

		$this->autoRender = false;
		$tiposMonedas = $this->TiposMoneda->find("all", array("fields"=>array("TiposMoneda.id", "TiposMoneda.nombre"), "order"=>"TiposMoneda.nombre"));
		if(!empty($tiposMonedas)){
			$respuestaArray = array();
			foreach ($tiposMonedas as $tiposMoneda) {
				array_push($respuestaArray, array(
					"id"=>$tiposMoneda["TiposMoneda"]["id"],
					"nombre"=>$tiposMoneda["TiposMoneda"]["nombre"],
					)
				);
			}
			$respuesta = array(
				"estado"=>1,
				"data"=>$respuestaArray
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"data"=>"Sin datos"
				);
		}
		return json_encode($respuesta);
	}
}
