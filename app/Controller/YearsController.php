<?php
App::uses('AppController', 'Controller');
/**
 * Years Controller
 *
 * @property Year $Year
 * @property PaginatorComponent $Paginator
 */
class YearsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function years_list(){

		$this->autoRender = false;
		$years = $this->Year->find("all", array("fields"=>array("Year.id", "Year.nombre"), "order"=>"Year.nombre DESC"));
		if(!empty($years)){
			$respuestaArray = array();
			foreach ($years as $year) {
				array_push($respuestaArray, array(
					"id"=>$year["Year"]["id"],
					"nombre"=>$year["Year"]["nombre"],
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
