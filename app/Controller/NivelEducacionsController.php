<?php
App::uses('AppController', 'Controller');
/**
 * NivelEducacions Controller
 *
 * @property NivelEducacion $NivelEducacion
 * @property PaginatorComponent $Paginator
 */
class NivelEducacionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function nivel_educacions_list(){

		$this->autoRender = false;
		$nivelEducacions = $this->NivelEducacion->find("all", array("fields"=>array("NivelEducacion.id", "NivelEducacion.nombre"), "order"=>"NivelEducacion.nombre"));
		if(!empty($nivelEducacions)){
			$respuestaArray = array();
			foreach ($nivelEducacions as $nivelEducacion) {
				array_push($respuestaArray, array(
					"id"=>$nivelEducacion["NivelEducacion"]["id"],
					"nombre"=>$nivelEducacion["NivelEducacion"]["nombre"]
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
