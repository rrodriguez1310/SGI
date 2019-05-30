<?php
App::uses('AppController', 'Controller');
/**
 * Nacionalidades Controller
 *
 * @property Nacionalidade $Nacionalidade
 * @property PaginatorComponent $Paginator
 */
class NacionalidadesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function nacionalidades_list(){

		$this->autoRender = false;
		$nacionalidades = $this->Nacionalidade->find("all", array("fields"=>array("Nacionalidade.id", "Nacionalidade.nombre"), "order"=>"Nacionalidade.nombre"));
		if(!empty($nacionalidades)){
			$respuestaArray = array();
			foreach ($nacionalidades as $nacionalidad) {
				array_push($respuestaArray, array(
					"id"=>$nacionalidad["Nacionalidade"]["id"],
					"nombre"=>$nacionalidad["Nacionalidade"]["nombre"]
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
