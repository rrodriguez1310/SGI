<?php
App::uses('AppController', 'Controller');
/**
 * Months Controller
 *
 * @property Month $Month
 * @property PaginatorComponent $Paginator
 */
class MonthsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function months_list(){
		$this->autoRender = false;
		$this->response->type("json");
		$months = $this->Month->find("all", array("fields"=>array("Month.id", "Month.nombre"), "order"=>"Month.nombre DESC", "recursive" => -1));

		if(!empty($months)){
			foreach ($months as $month) {
				$respuesta[] =  array(
					"id"=>$month["Month"]["id"],
					"nombre"=>$month["Month"]["nombre"],
				);
			}
		}else{
			$respuesta = [];
		}
		return json_encode($respuesta);
	}
}
