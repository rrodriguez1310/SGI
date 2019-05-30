<?php
App::uses('AppController', 'Controller');
/**
 * Comunas Controller
 *
 * @property Comuna $Comuna
 * @property PaginatorComponent $Paginator
 */
class ComunasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function comunas_list(){
		$this->autoRender = false;
		$comunas = $this->Comuna->find("all", array("fields"=>array("Comuna.id", "Comuna.comuna_nombre")));
		if(!empty($comunas)){
			$respuestaArray = array();
			foreach ($comunas as $comuna) {
				array_push($respuestaArray, array(
					"id"=>$comuna["Comuna"]["id"],
					"nombre"=>$comuna["Comuna"]["comuna_nombre"]
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
				"data"=>"sin datos"
				);
		}
		return json_encode($respuesta);
	}
}
