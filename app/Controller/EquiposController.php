<?php
App::uses('AppController', 'Controller');
/**
 * Equipos Controller
 *
 * @property Equipo $Equipo
 * @property PaginatorComponent $Paginator
 */
class EquiposController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function equipos_list(){

		$this->autoRender = false;
		//$this->response->type("json");
		$equipos = $this->Equipo->find("all", array(
			"conditions"=>array(
				"Equipo.estado"=>1
				),
			"order"=>"Equipo.nombre ASC"
			)
		);
		if(!empty($equipos))
		{
 			foreach ($equipos as $equipo) 
 			{
 				$respuesta[] = array(
 					"id"=>$equipo["Equipo"]["id"],
 					"nombre"=>$equipo["Equipo"]["nombre"],
 					"codigo"=>$equipo["Equipo"]["codigo"]
 					);
 			}
		}else
		{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}
}
