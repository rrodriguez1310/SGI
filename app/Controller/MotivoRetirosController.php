<?php
App::uses('AppController', 'Controller');
/**
 * MotivoRetiros Controller
 *
 * @property MotivoRetiro $MotivoRetiro
 * @property PaginatorComponent $Paginator
 */
class MotivoRetirosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function motivo_retiros_list(){

		$this->autoRender = false;
		$motivoRetiros = $this->MotivoRetiro->find("all", array("conditions"=>array("MotivoRetiro.estado"=>1),"fields"=>array("MotivoRetiro.id", "MotivoRetiro.nombre"), "order"=>"MotivoRetiro.nombre"));
		if(!empty($motivoRetiros)){
			$respuestaArray = array();
			foreach ($motivoRetiros as $motivoRetiro) {
				array_push($respuestaArray, array(
					"id"=>$motivoRetiro["MotivoRetiro"]["id"],
					"nombre"=>$motivoRetiro["MotivoRetiro"]["nombre"],
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
