<?php
App::uses('AppController', 'Controller');
/**
 * Formatos Controller
 *
 * @property Formato $Formato
 * @property PaginatorComponent $Paginator
 */
class FormatosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function formatos_list(){

		$this->autoRender = false;
		//$this->response->type("json");
		$formatosQuery = $this->Formato->find("all", array("conditions"=>array("Formato.estado"=>1), "recursive"=>-1));
		if(!empty($formatosQuery)){
			foreach ($formatosQuery as $formato) {
				$formatos[] = array(
					"id"=>$formato["Formato"]["id"],
					"nombre"=>$formato["Formato"]["nombre"],
					"tipo"=>$formato["Formato"]["tipo"]
				);
			}			
			$respuesta = $formatos;
		}else{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}
}
