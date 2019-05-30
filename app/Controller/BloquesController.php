<?php
App::uses('AppController', 'Controller');
/**
 * Bloques Controller
 *
 * @property Bloque $Bloque
 * @property PaginatorComponent $Paginator
 */
class BloquesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function bloques_list(){
		$this->autoRender = false;
		$this->response->type("json");
		$bloquesQuery = $this->Bloque->find("all", array("conditions"=>array("Bloque.estado"=>1), "recursive"=>-1));
		if(!empty($bloquesQuery)){
			foreach ($bloquesQuery as $bloque) {
				$respuesta[] = array(
					"id"=>$bloque["Bloque"]["id"],
					"nombre"=>$bloque["Bloque"]["nombre"],
					"codigo"=>$bloque["Bloque"]["codigo"],
					"tipo"=>$bloque["Bloque"]["tipo"]
					);
			}
		}else{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}
}
