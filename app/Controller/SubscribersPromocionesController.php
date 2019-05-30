<?php
App::uses('AppController', 'Controller');
/**
 * SubscribersPromociones Controller
 *
 * @property SubscribersPromocione $SubscribersPromocione
 * @property PaginatorComponent $Paginator
 */
class SubscribersPromocionesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('RequestHandler');

	public function add(){
		$this->autoRender = false;
		$this->response->type("json");
		if($this->Session->Read("Users.flag") != 0){
			if($this->params->isPost != 1){
				if($this->SubscribersPromocione->saveAll($this->request->input('json_decode', true))){
					CakeLog::write('actividad', 'GuardoEdito - SubscribersPromocione - add - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$respuesta = array(
						"status" => "OK",
						"message" => "Promocion ingresada correctamente",
					);
				}else{
					$respuesta = array(
						"status" => "ERROR",
						"message" => "No se pudo guardar en la base de datos",
					);
				}
			}else{
				$respuesta = array(
					"status" => "ERROR",
					"message" => "Metodo no permitido",
				);
			}
		}else{
			$respuesta = array(
				"status" => "ERROR",
				"message" => "Sin sessión activa",
			);
		}
		return json_encode($respuesta);
	}

	public function subs_promo($companyId, $yearId, $monthId, $channelId, $signalId){
		$this->autoRender = false;
		$this->response->type("json");
		$promociones = $this->SubscribersPromocione->find("all", array(
			"conditions" => array(
				"SubscribersPromocione.company_id" => $companyId,
				"SubscribersPromocione.year_id" => $yearId,
				"SubscribersPromocione.month_id" => $monthId,
				"SubscribersPromocione.channel_id" => $channelId,
				"SubscribersPromocione.signal_id" => $signalId
			),
			"recursive" => -1
		));
		$respuesta = array(
			"status" => "OK",
			"data" => $promociones
		);
		return json_encode($respuesta);
		
	}

}
