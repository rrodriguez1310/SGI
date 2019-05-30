<?php
App::uses('AppController', 'Controller');
/**
 * SistemaPrevisiones Controller
 *
 * @property SistemaPrevisione $SistemaPrevisione
 * @property PaginatorComponent $Paginator
 */
class SistemaPrevisionesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function sistema_previsiones_list(){

		$this->autoRender = false;
		$sistemaPrevisiones = $this->SistemaPrevisione->find("all", array("fields"=>array("SistemaPrevisione.id", "SistemaPrevisione.nombre"), "order"=>"SistemaPrevisione.nombre"));
		if(!empty($sistemaPrevisiones)){
			$respuestaArray = array();
			foreach ($sistemaPrevisiones as $sistemaPrevision) {
				array_push($respuestaArray, array(
					"id"=>$sistemaPrevision["SistemaPrevisione"]["id"],
					"nombre"=>$sistemaPrevision["SistemaPrevisione"]["nombre"]
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
