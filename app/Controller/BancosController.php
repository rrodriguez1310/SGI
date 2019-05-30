<?php
App::uses('AppController', 'Controller');
/**
 * Bancos Controller
 *
 * @property Banco $Banco
 * @property PaginatorComponent $Paginator
 */
class BancosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function bancos_list(){

		$this->autoRender = false;
		$bancos = $this->Banco->find("all", array("conditions"=>array("Banco.estado"=>1), "fields"=>array("Banco.id", "Banco.nombre"), "order"=>"Banco.nombre"));
		if(!empty($bancos)){
			$respuestaArray = array();
			foreach ($bancos as $banco) {
				array_push($respuestaArray, array(
					"id"=>$banco["Banco"]["id"],
					"nombre"=>$banco["Banco"]["nombre"],
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
