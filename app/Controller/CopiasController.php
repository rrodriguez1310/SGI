<?php
App::uses('AppController', 'Controller');
/**
 * Copias Controller
 *
 * @property Copia $Copia
 * @property PaginatorComponent $Paginator
 */
class CopiasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function copias_list(){
		$this->autoRender = false;
		//$this->response->type("json");
		$copiasQuery = $this->Copia->find("all", array("conditions"=>array("Copia.estado"=>1), "recursive"=>-1));
		if(!empty($copiasQuery)){
			foreach ($copiasQuery as $copia) {
				$respuesta[] = array(
					"id"=>$copia["Copia"]["id"],
					"copia"=>$copia["Copia"]["copia"],
					"tipo"=>$copia["Copia"]["tipo"]
					);
			}
		}else{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}
}
