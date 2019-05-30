<?php
App::uses('AppController', 'Controller');
/**
 * TipoContratos Controller
 *
 * @property TipoContrato $TipoContrato
 * @property PaginatorComponent $Paginator
 */
class TipoContratosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function tipo_contratos_list(){

		$this->autoRender = false;
		$tipoContratos = $this->TipoContrato->find("all", array("conditions"=>array("TipoContrato.estado"=>1),"fields"=>array("TipoContrato.id", "TipoContrato.nombre"), "order"=>"TipoContrato.nombre"));
		if(!empty($tipoContratos)){
			$respuestaArray = array();
			foreach ($tipoContratos as $tipoContrato) {
				array_push($respuestaArray, array(
					"id"=>$tipoContrato["TipoContrato"]["id"],
					"nombre"=>$tipoContrato["TipoContrato"]["nombre"],
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
