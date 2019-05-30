<?php
App::uses('AppController', 'Controller');
/**
 * Horarios Controller
 *
 * @property Horario $Horario
 * @property PaginatorComponent $Paginator
 */
class HorariosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function horarios_list(){

		$this->autoRender = false;
		$horarios = $this->Horario->find("all", array("conditions"=>array("Horario.estado"=>1),"fields"=>array("Horario.id", "Horario.nombre"), "order"=>"Horario.nombre"));
		if(!empty($horarios)){
			$respuestaArray = array();
			foreach ($horarios as $horario) {
				array_push($respuestaArray, array(
					"id"=>$horario["Horario"]["id"],
					"nombre"=>$horario["Horario"]["nombre"],
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
