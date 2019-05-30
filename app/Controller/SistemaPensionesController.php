<?php
App::uses('AppController', 'Controller');
/**
 * SistemaPensiones Controller
 *
 * @property SistemaPensione $SistemaPensione
 * @property PaginatorComponent $Paginator
 */
class SistemaPensionesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function sistema_pensiones_list(){

		$this->autoRender = false;
		$sistemaPensiones = $this->SistemaPensione->find("all", array("fields"=>array("SistemaPensione.id", "SistemaPensione.nombre"), "order"=>"SistemaPensione.nombre"));
		if(!empty($sistemaPensiones)){
			$respuestaArray = array();
			foreach ($sistemaPensiones as $sistemaPension) {
				array_push($respuestaArray, array(
					"id"=>$sistemaPension["SistemaPensione"]["id"],
					"nombre"=>$sistemaPension["SistemaPensione"]["nombre"]
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
