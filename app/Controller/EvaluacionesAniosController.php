<?php
App::uses('AppController', 'Controller');
/**
 * EvaluacionesAnios Controller
 *
 * @property EvaluacionesAnio $EvaluacionesAnio
 * @property PaginatorComponent $Paginator
 */
class EvaluacionesAniosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	private $estados = array( 
				//array("id"=>0, "nombre"=>"Eliminada"),
				array("id"=>1, "nombre"=>"Establecimiento OCD"),
				array("id"=>2, "nombre"=>"Evaluación Desempeño"),
				array("id"=>3, "nombre"=>"Finalizada")
			);

/**
 * index method
 *
 * @return void
 */
 
	public function index() {		
        $this->layout = "angular";
		//$this->acceso();
	}

	public function listar_anios_json(){
		$this->layout = "ajax";
		$this->response->type('json');

		$aniosEvaluaciones = $this->EvaluacionesAnio->find("all", array("conditions"=>array("estado >" => 0), "order" => "anio_evaluado DESC"));
		foreach($aniosEvaluaciones as $evaluacion){
			$anios[] = array(
				"id"=>$evaluacion["EvaluacionesAnio"]["id"],
				"anio_evaluado" => $evaluacion["EvaluacionesAnio"]["anio_evaluado"],
				"proceso_evaluacion" => $evaluacion["EvaluacionesAnio"]["anio_evaluado"] . ' - ' . ($evaluacion["EvaluacionesAnio"]["anio_evaluado"]+1),
				"inicio_ocd" => $evaluacion["EvaluacionesAnio"]["inicio_ocd"],
				"fin_ocd"=>$evaluacion["EvaluacionesAnio"]["termino_ocd"],
				"inicio_evaluacion"=>$evaluacion["EvaluacionesAnio"]["fecha_inicio"],
				"fin_evaluacion"=>$evaluacion["EvaluacionesAnio"]["fecha_termino"],
				"estado"=>$evaluacion["EvaluacionesAnio"]["estado"]
			);
		}
		$this->set("datos", $anios);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->EvaluacionesAnio->exists($id)) {
			throw new NotFoundException(__('Invalid evaluaciones anio'));
		}
		$options = array('conditions' => array('EvaluacionesAnio.' . $this->EvaluacionesAnio->primaryKey => $id));
		$this->set('evaluacionesAnio', $this->EvaluacionesAnio->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->layout = "angular";
	}

	public function data_add_anios_json() {
		$this->layout = "ajax";		
		$this->response->type('json');	

		$aniosEvaluaciones = $this->EvaluacionesAnio->find("first", array(
			"fields" => "anio_evaluado",
			"conditions"=>array("estado >" => 0),
			"order" => "anio_evaluado DESC",
			"limit"=>1)
		);			
		$anioEvaluar = ($aniosEvaluaciones["EvaluacionesAnio"]["anio_evaluado"] + 1);		
		$diaTerminoEv = date("Y-m-t", strtotime($anioEvaluar.'-02-01'));
		$diaTerminoEv = implode("-", array_reverse(explode("-", $diaTerminoEv)));		
		$diaInicioOCD = '01-03-'.$anioEvaluar;
		$diaTerminoOCD = '31-12-'.$anioEvaluar;
		$diaInicioEv = '01-01-'.$anioEvaluar;

		$data = array(
			"EvaluacionesAnios"=> array(
				"anio_evaluado" => $anioEvaluar,
				"inicio_ocd"=> $diaInicioOCD,
				"termino_ocd"=> $diaTerminoOCD,
				"fecha_inicio"=> $diaInicioEv,
				"fecha_termino"=> $diaTerminoEv,
				"estado"=> 1
				),
			"estados" => $this->estados
		);
		$this->set("datos", $data);
	}

	public function add_json() {
		$this->layout = "ajax";
		$this->response->type('json');	

		$this->request->data["EvaluacionesAnios"]["inicio_ocd"] = implode("-", array_reverse(explode("-", $this->request->data["EvaluacionesAnios"]["inicio_ocd"])));
		$this->request->data["EvaluacionesAnios"]["termino_ocd"] = implode("-", array_reverse(explode("-", $this->request->data["EvaluacionesAnios"]["termino_ocd"])));
		$this->request->data["EvaluacionesAnios"]["fecha_inicio"] = implode("-", array_reverse(explode("-", $this->request->data["EvaluacionesAnios"]["fecha_inicio"])));
		$this->request->data["EvaluacionesAnios"]["fecha_termino"] = implode("-", array_reverse(explode("-", $this->request->data["EvaluacionesAnios"]["fecha_termino"])));		

		if($this->EvaluacionesAnio->save($this->request->data["EvaluacionesAnios"])){
			CakeLog::write('actividad', 'agrego - EvaluacionesAnio - add_evaluacion - id '.$this->EvaluacionesAnio->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));						
			$respuesta = array(
				"estado"=>1,
				"mensaje"=>"La información se guardó correctamente"				
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"El registro no pudo ser creado, por favor intente más tarde."
				);
		}
		$this->set("respuesta", $respuesta);
	}




/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {		
		$this->layout = "angular";
	}

	public function edit_data_json($id) {
		$this->layout = "ajax";		
		$this->response->type('json');

		$aniosEvaluaciones = $this->EvaluacionesAnio->find("first", array(			
			"conditions" => array("id"=>$id)
			)
		);		
		
		$aniosEvaluaciones["EvaluacionesAnio"]["inicio_ocd"] = implode("-", array_reverse(explode("-", $aniosEvaluaciones["EvaluacionesAnio"]["inicio_ocd"])));
		$aniosEvaluaciones["EvaluacionesAnio"]["termino_ocd"] = implode("-", array_reverse(explode("-", $aniosEvaluaciones["EvaluacionesAnio"]["termino_ocd"])));
		$aniosEvaluaciones["EvaluacionesAnio"]["fecha_inicio"] = implode("-", array_reverse(explode("-", $aniosEvaluaciones["EvaluacionesAnio"]["fecha_inicio"])));
		$aniosEvaluaciones["EvaluacionesAnio"]["fecha_termino"] = implode("-", array_reverse(explode("-", $aniosEvaluaciones["EvaluacionesAnio"]["fecha_termino"])));		
				
		$data = array(
			"EvaluacionesAnios"=> $aniosEvaluaciones["EvaluacionesAnio"],
			"estados" => $this->estados
		);
		$this->set("datos", $data);
	}


/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete_evaluacion_anios($id = null) {
		$this->layout = "ajax";
		
		if (!$this->EvaluacionesAnio->exists($id)) {
			$this->Session->setFlash('Ocurrio un erro intentelo nuevamente', 'msg_fallo');
			return $this->redirect(array('action' => 'index'));
		}

		$this->request->data["EvaluacionesAnio"]["id"] = $id;
		$this->request->data["EvaluacionesAnio"]["estado"] = 0;

		if ($this->EvaluacionesAnio->save($this->request->data)) {
			CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->EvaluacionesAnio->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") ); 			

			$this->Session->setFlash('El registro se elimino correctamente', 'msg_exito');
			return $this->redirect(array('action' => 'index'));

		} else {
			$this->Session->setFlash('Ocurrio un error al tratar de eliminar el registro', 'msg_fallo');
		}
	}
}
