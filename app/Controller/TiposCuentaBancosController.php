<?php
App::uses('AppController', 'Controller');
/**
 * TiposCuentaBancos Controller
 *
 * @property TiposCuentaBanco $TiposCuentaBanco
 * @property PaginatorComponent $Paginator
 */
class TiposCuentaBancosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function tipos_cuenta_bancos_list(){

		$this->autoRender = False;
		$tiposCuentaBancos = $this->TiposCuentaBanco->find("all", array("conditions"=>array("TiposCuentaBanco.estado"=>1), "fields"=>array("TiposCuentaBanco.id", "TiposCuentaBanco.nombre"), "order"=>"TiposCuentaBanco.nombre"));
		if(!empty($tiposCuentaBancos)){
			$respuestaArray = array();
			foreach ($tiposCuentaBancos as $tiposCuentaBanco) {
				array_push($respuestaArray, array(
					"id"=>$tiposCuentaBanco["TiposCuentaBanco"]["id"],
					"nombre"=>$tiposCuentaBanco["TiposCuentaBanco"]["nombre"],
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
		//$this->set("respuesta", json_encode($respuesta));
	}
}
