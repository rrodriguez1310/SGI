<?php
App::uses('AppController', 'Controller');
/**
 * EstadosCiviles Controller
 *
 * @property EstadosCivile $EstadosCivile
 * @property PaginatorComponent $Paginator
 */
class EstadosCivilesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function estados_civiles_list(){
		$this->autoRender = false;
		$estadosCiviles = $this->EstadosCivile->find("list", array("fields"=>array("EstadosCivile.nombre"), "conditions"=>array("EstadosCivile.estado"=>1)));
		if(!empty($estadosCiviles)){
			foreach ($estadosCiviles as $id => $nombre) {
				$respuesta[] = array(
					"id"=>$id,
					"nombre"=>$nombre
				);
			}
		}
		return json_encode($respuesta);
	}
}
