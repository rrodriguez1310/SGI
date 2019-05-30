<?php
App::uses('AppController', 'Controller');
/**
 * Localizaciones Controller
 *
 * @property Localizacione $Localizacione
 * @property PaginatorComponent $Paginator
 */
class LocalizacionesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function localizaciones_list(){

		$this->autoRender = false;
		$localizaciones = $this->Localizacione->find("all", array("conditions"=>array("Localizacione.estado"=>1),"fields"=>array("Localizacione.id", "Localizacione.nombre", "Localizacione.direccion"), "order"=>"Localizacione.nombre"));
		if(!empty($localizaciones)){
			$respuestaArray = array();
			foreach ($localizaciones as $localizacion) {
				array_push($respuestaArray, array(
					"id"=>$localizacion["Localizacione"]["id"],
					"nombre"=>$localizacion["Localizacione"]["nombre"],
					"direccion"=>$localizacion["Localizacione"]["direccion"]
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
