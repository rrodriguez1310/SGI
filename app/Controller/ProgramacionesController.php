<?php
App::uses('AppController', 'Controller');
/**
 * Programaciones Controller
 *
 * @property Programacione $Programacione
 * @property PaginatorComponent $Paginator
 */
class ProgramacionesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Programacione->recursive = 0;
		$this->set('programaciones', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Programacione->exists($id)) {
			throw new NotFoundException(__('Invalid programacione'));
		}
		$options = array('conditions' => array('Programacione.' . $this->Programacione->primaryKey => $id));
		$this->set('programacione', $this->Programacione->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Programacione->create();
			if ($this->Programacione->save($this->request->data)) {
				$this->Session->setFlash(__('The programacione has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The programacione could not be saved. Please, try again.'));
			}
		}
		$logProgramas = $this->Programacione->LogPrograma->find('list');
		$channels = $this->Programacione->Channel->find('list');
		$this->set(compact('logProgramas', 'channels'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id, $idLog) {

		$this->autoRender = false;
		$this->response->type("json");

		if (!$this->Programacione->exists($id)) {
			throw new NotFoundException(__('El Id es invalido no se puede editar la información'));
		}
		
		if ($this->request->is(array('get'))) {
			$this->request->data["Programacione"]["id"] = $this->params->pass[0];
			$this->request->data["Programacione"]['log_programa_id'] = $this->params->pass[1];

			if ($this->Programacione->save($this->request->data)) {
				
				$this->loadModel("LogPrograma");
				$this->request->data["LogPrograma"]['id'] = $this->params->pass[1];
				$this->request->data["LogPrograma"]["programacione_id"] = $this->params->pass[0];
				$this->LogPrograma->save($this->request->data['LogPrograma']);

				return json_encode(array("Error"=>1, "Mensaje"=>"El registro se edito correctamente"));
			} else {
				return json_encode(array("Error"=>0, "Mensaje"=>"El registro no se edito correctamente"));
			}
		} 
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Programacione->id = $id;
		if (!$this->Programacione->exists()) {
			throw new NotFoundException(__('Invalid programacione'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Programacione->delete()) {
			$this->Session->setFlash(__('The programacione has been deleted.'));
		} else {
			$this->Session->setFlash(__('The programacione could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function programacionJson($tipoSignal){
		$this->autoRender = false;
		$this->response->type("json");
		
		$contenidoJson = file_get_contents('http://www.cdf.cl/api/movil_programacion.php?format=json&senal='.$tipoSignal.'&fecha='.date('Ymd'));
		$programacion = json_decode($contenidoJson, true);

		$programacionArray = "";

		foreach ($programacion['data'] as $key => $value) {
			$programacionArray[] = array(
				'imagen' => trim($value['imagethumb'], ' '),
				'hora' =>trim($value['time'], ' '),
				'fecha' =>trim($value['date'], ' '),
				'nombre'=>trim($value['title'], ' '),
				'fecha_full'=>trim($value['datem'], ' '),
				'descripcion'=>trim($value['description'], ' '),
				'signal'=>$programacion['meta']['channel']
			);
		}
		
		if($this->Programacione->saveAll($programacionArray)){
			echo json_encode("se registro");
			CakeLog::write('actividad', 'Se guardo la programacion -' . date('Y-m-d'));
		}else{ 
			echo json_encode("no se registro");
			CakeLog::write('actividad', 'No se guardo la programacion -' . date('Y-m-d'));
		}
		 	
	}


	public function listaProgramacion($fecha = null, $signal = null){
		$this->autoRender = false;
		$this->response->type("json");

		if(!empty($this->params->pass[0]) && !empty($this->params->pass[1])){
			$fecha = $this->params->pass[0];
			$signal = $this->params->pass[1];
		}

		$listaProgramacion = $this->Programacione->find('all', array(
			'conditions'=>array(
				'fecha_full'=>$fecha,//$this->params->pass[0],
				'signal'=>$signal//$this->params->pass[1],
				),
			'recursive'=>-1
		));

		$programacionList = "";
		if(!empty($listaProgramacion)){
			foreach ($listaProgramacion as $key => $value) {
				$segnal = "";
				$programacionList[] = array(
					'id' => $value['Programacione']['id'],
					'log_programa_id' => $value['Programacione']['log_programa_id'],
					'fecha_full' => $value['Programacione']['fecha_full'],
					'descripcion' => $value['Programacione']['descripcion'],
					'fecha' => $value['Programacione']['fecha'],
					'hora' => $value['Programacione']['hora'],
					'nombre' => $value['Programacione']['nombre'],
					'signal' => substr($value['Programacione']['signal'], 3)
				);
			}
		}
		return  json_encode($programacionList);
	}

	public function listaLog($fecha = null, $canal = null){

		$this->autoRender = false;
		$this->response->type("json");

		$this->loadModel('LogPrograma');
		$recursivo = -1;
		//$canal = "";
		if(!empty($this->params->pass[0]) && !empty($this->params->pass[1]) && $this->params->pass[1] === 'CDF Básico'){
			$canal = 'SD_CDF_BAS';
			$fecha = $this->params->pass[0];
			$recursivo = 1;
		}else if( !empty($this->params->pass[0]) && !empty($this->params->pass[1]) && $this->params->pass[1] === 'CDF HD'){
			$canal = 'HD_CDF_HD';
			$fecha = $this->params->pass[0];
			$recursivo = 1;
		}else if(!empty($this->params->pass[0]) && !empty($this->params->pass[1]) && $this->params->pass[1] === 'SD_CDF_PREM'){
			$canal = 'SD_CDF_PREM';
			$fecha = $this->params->pass[0];
			$recursivo = 1;
		}

		$listaLog = $this->LogPrograma->find("all", array(
			'conditions'=>array(
				'dia_tv'=>date("d-m-Y", strtotime($fecha)), //$this->params->pass[0],
				'nombre_canal'=>$canal,
			),
			'recursive'=>1,
			//'order'=>'LogPrograma.hora_inicio DESC'
		));


		$logList = "";
		
		if(!empty($listaLog)){
			foreach ($listaLog as $key => $value) {

				$programa = explode('/', $value['LogPrograma']['clip']);
				$key = array_keys($programa);
				$ultimoKey = end($key);

				$logList[] = array(
					'id' => $value['LogPrograma']['id'],
					'fecha' => $value['LogPrograma']['fecha'],
					'numero_evento' => $value['LogPrograma']['numero_evento'],
					'inicio_presupuestado' => $value['LogPrograma']['inicio_presupuestado'],
					'hora_inicio' => $value['LogPrograma']['hora_inicio'],
					'duracion' => $value['LogPrograma']['duracion'],
					'nombre' => $programa[$ultimoKey],
					'dia_tv' => $value['LogPrograma']['dia_tv'],
					'estado' => $value['LogPrograma']['estado'],
					'nombre_canal' => $value['LogPrograma']['nombre_canal'],
					'programacionId' => (isset($value['Programacione']['id']) ? $value['Programacione']['id'] : '') ,
					'programacionDescripcion' => (isset($value['Programacione']['descripcion']) ? $value['Programacione']['descripcion'] : '') ,
					'programacionHora' => (isset($value['Programacione']['hora']) ? $value['Programacione']['hora'] : '') ,
					'programacionNombre' => (isset($value['Programacione']['nombre']) ? $value['Programacione']['nombre'] : '')
				);
			}
		}
		return  json_encode($logList);
	}

	public function conciliacion_programacion(){
		$this->layout = "angular";
	}

	public function programacionLogRating($fecha = null, $canal = null){
		//ini_set('memory_limit', '1024M');
		$this->autoRender = false;
		$this->response->type("json");

		$listaProgramacionLogRaiting = '';

		if(!empty($this->params->pass[0]) && !empty($this->params->pass[1])){

			$this->loadModel('ProgramacionesCodigo');

			$signal = 1;

			if($this->params->pass[1] === 'CDF Básico'){
				$fecha = $this->params->pass[0];
			}else if( $this->params->pass[1] === 'CDF HD'){
				$canal = 'HD_CDF_HD';
			}else if($this->params->pass[1] === 'SD_CDF_PREM'){
				$canal = 'SD_CDF_PREM';
			}

			$programacion = $this->listaProgramacion($this->params->pass[0], $this->params->pass[1]);
			$log = $this->listaLog($this->params->pass[0], $canal);
			
			$codigos = '';
			$logAcumulado = '';

			if(!empty($log) && json_decode($log, true)){
				foreach ( json_decode($log, true) as $key => $value) {
					$logAcumulado[$value['nombre']][substr($value['hora_inicio'], 0, 2)][] = array(
						"id" => $value['id'],
						"fecha" => $value['fecha'],
						"numero_evento" => $value['numero_evento'],
						"inicio_presupuestado" => $value['inicio_presupuestado'],
						"hora_inicio" => $value['hora_inicio'],
						"duracion" => $value['duracion'],
						"nombre" => $value['nombre'],
						"dia_tv" => $value['dia_tv'],
						"estado" => $value['estado'],
						"nombre_canal" => $value['nombre_canal'],
						"programacionId" => $value['programacionId'],
						"programacionDescripcion" => $value['programacionDescripcion'],
						"programacionHora" => $value['programacionHora'],
						"programacionNombre" => $value['programacionNombre']
					);
					//codigos cortos para los codigos
					if(!empty($value['programacionId'])){
						$nombrePrograma = explode('.', $value['nombre']);
						$codigosDos[] = substr($nombrePrograma[0], 0, -1);
						$codigosDosHora[] = array(
							'nombre'=>substr($nombrePrograma[0], 0, -1), 
							'hora'=>substr($value['hora_inicio'], 0, 2)
						);
					}
				}


				$gruposCodigo = "";

				foreach($codigosDos as $codigoCorto){
					$codigosAsociados = $this->ProgramacionesCodigo->find('all', array(
						'conditions'=>array(
							'ProgramacionesCodigo.titulo LIKE' => "%".$codigoCorto."%"
						),
						'fields'=>array(
							'ProgramacionesCodigo.titulo', 
						)
					));

					$gruposCodigo[$codigoCorto] = $codigosAsociados;
				}

				$codigosInicioFin = "";

				foreach($gruposCodigo as $key => $valor){
					$codigosInicioFin[reset($valor)['ProgramacionesCodigo']['titulo']] = array(
						'inicio' =>reset($valor)['ProgramacionesCodigo']['titulo'],//reset($valor), 
						'fin'=>end($valor)['ProgramacionesCodigo']['titulo'],//end($valor)
					);
				}

				$inicioFinRating = '';

				foreach($codigosInicioFin as $key => $value){
					foreach($logAcumulado[$value['inicio'].'.mov'] as $keyDos => $valueDos){
						if(isset($logAcumulado[$value['fin'].'.mov' ][$keyDos])){

							$horaInicioLimpia = explode(';', $logAcumulado[$value['inicio'].'.mov'][$keyDos][0]['hora_inicio']);
							$horaFinLimpia = explode(';', $logAcumulado[$value['fin'].'.mov' ][$keyDos][0]['hora_inicio']);
							$duracionBloque = explode(';', $logAcumulado[$value['fin'].'.mov' ][$keyDos][0]['duracion']);

							$minutos = date("i", strtotime($duracionBloque[0]));
							$segundos = date("s", strtotime($duracionBloque[0]));
							$horas = date("H", strtotime($duracionBloque[0]));

							$transforma = strtotime("+$minutos minutes", strtotime($horaFinLimpia[0]));
							$transforma = strtotime("+$segundos seconds", $transforma);
							$transforma = strtotime("+$horas hours", $transforma);
							$nuevoTiempo = date('H:i:s', $transforma);
							
							$inicioFinRating[$value['inicio'].'.mov'] = array(
								'inicio'=>$logAcumulado[$value['inicio'].'.mov'][$keyDos][0]['hora_inicio'],
								'finReal'=>$nuevoTiempo,
							);
						}
					}
				}

				$agrupadoRatingMinutosProgramas = '';

				if(!empty($inicioFinRating)) {
					
					
					foreach($inicioFinRating as $key => $value){
						$inicio = explode(';', $value['inicio']);

						$this->loadModel('RatingMinuto');
					
						$fechaInicial = new DateTime('2017-06-05 '.$inicio[0]);
						$fechaFinal = new DateTime('2017-06-05 ' .$value['finReal']);

						$ratingMinutos = $this->RatingMinuto->find('all', array(
							'conditions'=>array(
								"RatingMinuto.fecha BETWEEN ? and ?"=>array(
									$fechaInicial->format("Y-m-d H:i:s"),
									$fechaFinal->format("Y-m-d H:i:s")
								),
								'RatingMinuto.channels_id'=>$signal,
								'RatingMinuto.estado'=>1,
								'RatingMinuto.target_id'=>1
							),
							'fields'=>array(
								'RatingMinuto.id',
								'RatingMinuto.fecha',
								'RatingMinuto.rating',
								'RatingMinuto.share',
								'RatingMinuto.tvr',
							)
						));

						$agrupadoRatingMinutosProgramas[$key] = $ratingMinutos;
					}
				}

				$ratingNormalizado = '';

				if(!empty($agrupadoRatingMinutosProgramas)){
					foreach($agrupadoRatingMinutosProgramas as $key => $value){
					
						foreach($value as $keyDos => $valueDos){ 
							$hora = explode(' ', $valueDos['RatingMinuto']['fecha']);
							$ratingNormalizado[$key][substr($hora[1], 0, 2)]['rating'][] = $valueDos['RatingMinuto']['rating'];//$sumaRaiting;
							$ratingNormalizado[$key][substr($hora[1], 0, 2)]['share'][] = $valueDos['RatingMinuto']['share'];
							$ratingNormalizado[$key][substr($hora[1], 0, 2)]['tvr'][] = $valueDos['RatingMinuto']['tvr'];
						}
					}
				}
				
				foreach($logAcumulado as $keyPrograma => $valor){
					foreach($valor as $keyHora => $valorDos){
						foreach($valorDos as $keyHoraDos => $valorDosTres){
							if(!empty($valorDos[0]['programacionId'])){
								if(isset($ratingNormalizado[$valorDos[0]['nombre']])){
									$listaProgramacionLogRaiting[] = array(	
										'id'=>$valorDos[0]['id'],
										'fecha' =>$valorDos[0]['fecha'],
										'numero_evento'=>$valorDos[0]['numero_evento'],
										'inicio_presupuestado'=>$valorDos[0]['inicio_presupuestado'],
										'hora_inicio'=> substr($valorDos[0]['hora_inicio'], 0, 8),
										'duracion'=>substr($valorDos[0]['hora_inicio'], 0, 8),
										'nombre'=>$valorDos[0]['nombre'],
										'dia_tv'=>$valorDos[0]['dia_tv'],
										'estado'=>$valorDos[0]['estado'],
										'nombre_canal'=>$valorDos[0]['nombre_canal'],
										'programacionId'=>(isset($valorDos[0]['programacionId']) ? $valorDos[0]['programacionId'] : ''),
										'programacionDescripcion'=>(isset($valorDos[0]['programacionDescripcion']) ? $valorDos[0]['programacionDescripcion'] : ''),
										'programacionHora'=>(isset($valorDos[0]['programacionHora']) ? $valorDos[0]['programacionHora'] : ''),
										'programacionNombre'=>(isset($valorDos[0]['programacionNombre']) ? $valorDos[0]['programacionNombre'] : ''),
										'inicioReal'=>$inicioFinRating[$valorDos[0]['nombre']]['inicio'],
										'finReal'=>$inicioFinRating[$valorDos[0]['nombre']]['finReal'],
										'raiting'=>(isset($ratingNormalizado[$valorDos[0]['nombre']]) ? array_sum((isset($ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['rating']) ? $ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['rating'] : array(0))      )    / count(  (isset($ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['rating']) ? $ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['rating'] : '')) : ''),
										'share'=>(isset($ratingNormalizado[$valorDos[0]['nombre']]) ? array_sum((isset($ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['share']) ? $ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['share'] : array(0))) / count((isset($ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['share']) ? $ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['share'] : '')) : ''),
										'tvr'=>(isset($ratingNormalizado[$valorDos[0]['nombre']]) ? array_sum((isset($ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['tvr']) ? $ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['tvr'] : array(0))) / count((isset($ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['tvr']) ? $ratingNormalizado[$valorDos[0]['nombre']][substr($valorDos[0]['hora_inicio'], 0, 2)]['tvr'] : '')) : '') 
									);
								}
							}
						}
					}
				}
			}
		}

		return json_encode($listaProgramacionLogRaiting);
	}

	public function rating_Programas(){
		$this->layout = "angular";
	}
}

