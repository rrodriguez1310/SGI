<?php
App::uses('AppController', 'Controller');
/**
 * TiposDocumentos Controller
 *
 * @property TiposDocumento $TiposDocumento
 * @property PaginatorComponent $Paginator
 */
class TiposDocumentosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function tipos_documentos_list(){

		$this->autoRender = false;
		$tipoDocumentos = $this->TiposDocumento->find("all", array("fields"=>array("TiposDocumento.id", "TiposDocumento.nombre", "TiposDocumento.tipo"), "order"=>"TiposDocumento.nombre"));
		if(!empty($tipoDocumentos)){
			$respuestaArray = array();
			foreach ($tipoDocumentos as $tipoDocumento) {
				array_push($respuestaArray, array(
					"id"=>$tipoDocumento["TiposDocumento"]["id"],
					"nombre"=>$tipoDocumento["TiposDocumento"]["nombre"],
					"tipo"=>$tipoDocumento["TiposDocumento"]["tipo"]
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
