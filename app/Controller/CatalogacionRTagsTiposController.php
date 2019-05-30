<?php
App::uses('AppController', 'Controller');
/**
 * CatalogacionRTagsTiposController Controller
 *
 * @property CatalogacionRTagsTiposController $CatalogacionRTagsTiposController
 * @property PaginatorComponent $Paginator
 */
class CatalogacionRTagsTiposController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function tags_tipos_list(){

		$this->autoRender = false;
		//$this->response->type("json");
		$tipos = $this->CatalogacionRTagsTipo->find("all", array(
			"conditions"=>array(
				"CatalogacionRTagsTipo.estado"=>1
				),
			"order"=>"CatalogacionRTagsTipo.nombre ASC",
			"recursive"=>-1
			)
		);
		if(!empty($tipos))
		{
 			foreach ($tipos as $tipo) 
 			{
 				$respuesta[] = array(
 					"id"=>$tipo["CatalogacionRTagsTipo"]["id"],
 					"nombre"=>$tipo["CatalogacionRTagsTipo"]["nombre"],
 					"tipo"=>$tipo["CatalogacionRTagsTipo"]["tipo"]
 					);
 			}
		}else
		{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}
}
