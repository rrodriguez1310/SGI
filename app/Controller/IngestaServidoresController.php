<?php
App::uses('AppController', 'Controller');
/**
 * IngestaServidores Controller
 *
 * @property IngestaServidore $IngestaServidore
 * @property PaginatorComponent $Paginator
 */
class IngestaServidoresController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function ingesta_servidores_list(){
		$this->autoRender = false;
		$servidores = $this->IngestaServidore->find("all", array(
			"conditions"=>array(
				"IngestaServidore.tipo"=>1,
				"IngestaServidore.estado"=>1
			),
			"recursive"=>-1
		));
		if(!empty($servidores)){
			foreach ($servidores as $servidor) {
				$respuesta[] = array(
					"id"=>$servidor["IngestaServidore"]["id"],
					"nombre"=>$servidor["IngestaServidore"]["nombre"],
					"tipo"=>$servidor["IngestaServidore"]["tipo"]
				);
			}
		}else{
			$respuesta = array();
		}
		return json_encode($respuesta);
	}
}
