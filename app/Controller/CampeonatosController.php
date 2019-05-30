<?php
App::uses('AppController', 'Controller');
/**
 * Campeonatos Controller
 *
 * @property Campeonato $Campeonato
 * @property PaginatorComponent $Paginator
 */
class CampeonatosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function campeonatos_list(){

		$this->autoRender = false;
		//$this->response->type("json");
		$campeonatos = $this->Campeonato->find("all", array(
			"conditions"=>array(
				"Campeonato.estado"=>1
				),
			"order"=>"Campeonato.nombre ASC",
			"recursive"=>-1
			)
		);
		if(!empty($campeonatos))
		{
 			foreach ($campeonatos as $campeonato) 
 			{
 				$respuesta[] = array(
 					"id"=>$campeonato["Campeonato"]["id"],
 					"nombre"=>$campeonato["Campeonato"]["nombre"],
 					"codigo"=>$campeonato["Campeonato"]["codigo"]
 					);
 			}
		}else
		{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}
}
