<?php
App::uses('AppController', 'Controller');
/**
 * CodigosPresupuestos Controller
 *
 * @property CodigosPresupuesto $CodigosPresupuesto
 * @property PaginatorComponent $Paginator
 */
class CodigosPresupuestosController extends AppController {

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
		$this->layout = "angular";
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CodigosPresupuesto->exists($id)) {
			throw new NotFoundException(__('Invalid codigos presupuesto'));
		}
		$options = array('conditions' => array('CodigosPresupuesto.' . $this->CodigosPresupuesto->primaryKey => $id));
		$this->set('codigosPresupuesto', $this->CodigosPresupuesto->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->layout = "angular";
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

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->autoRender = false;
		$this->response->type("json");
		if($this->request->is("POST")){
			if($this->Session->Read("Users.flag") == 1){
				if($this->CodigosPresupuesto->save($this->request->data)){
					CakeLog::write('actividad', 'Elimino - CodigosPresupuestario - delete - '.$this->CodigosPresupuesto->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"Se elimino correctamente el codigo presupuestario"
						);	
				}
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Perdio la sesión, por favor intentelo nuevamente"
					);	
			}
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Metodo no permitido"
				);
		}
		$this->response->body(json_encode($respuesta));
	}

	public function codigos_presupuestos(){
		//Configure::write('debug', 2);
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel('Year');
		$codigosPresupuestarios = $this->CodigosPresupuesto->find("all", array("conditions"=>array("CodigosPresupuesto.estado"=>1), 'recursive' => -1));
		//pr($codigosPresupuestarios);exit;
		if(!empty($codigosPresupuestarios)){
			$respuesta = array(
				"estado"=>1,
			);
			$yearsQuery = $this->Year->find("all", array('recursive' => -1));
			foreach ($yearsQuery as $year) {
				$years[$year['Year']['id']] = $year['Year']['nombre'];
			}
			foreach ($codigosPresupuestarios as $codigoPresupestario) {
				$codigoPresupestario['CodigosPresupuesto']['anio'] = $years[$codigoPresupestario['CodigosPresupuesto']['year_id']];
				$respuesta['data'][] = $codigoPresupestario['CodigosPresupuesto'];
			}
		}else{
			$respuesta = array(
				"estado"=>0,
				"data"=>"No se encontro información"
				);
		}
		return json_encode($respuesta);
	}


public function codigos_presupuestos_agno(){
		$this->autoRender = false;
		$this->response->type("json");

		if(!empty($this->params->query["idAgno"]))
		{
			$codigosAgnos = $this->CodigosPresupuesto->find("all", array(
				"conditions"=>array("CodigosPresupuesto.year_id"=>$this->params->query["idAgno"]),
				"fields"=>array("CodigosPresupuesto.id", "CodigosPresupuesto.codigo")
			));
		}

		return json_encode($codigosAgnos);

	}




	public function codigos_presupuesto(){

		$this->autoRender = false;
		$this->response->type("json");
		$codigosPresupuestario = $this->CodigosPresupuesto->findById($this->request->query["id"]);
		if(!empty($codigosPresupuestario)){
			$respuesta = array(
				"estado"=>1,
				"data"=>$codigosPresupuestario
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"data"=>"No se encontro información"
				);
		}
		return json_encode($respuesta);
	}

	public function codigos_presupuesto_registrar(){
		$this->autoRender = false;
		$this->response->type("json");
		if($this->request->is("POST")){
			if($this->CodigosPresupuesto->save($this->request->data)){
				if(isset($this->request->data["CodigosPresupuesto"]["id"])){
					$this->Session->setFlash("Se edito correctamente el codigo prosupuesto","msg_exito");
					CakeLog::write('actividad', 'Edito - CodigosPresupuestario - codigos_presupuesto_registrar - '.$this->CodigosPresupuesto->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				}else{
					$this->Session->setFlash("Se ingreso correctamente el codigo prosupuesto","msg_exito");
					CakeLog::write('actividad', 'Ingreso - CodigosPresupuestario - codigos_presupuesto_registrar - '.$this->CodigosPresupuesto->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				}
				$respuesta = array(
					"estado"=>1
					);
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se pudo guardar en la base de datos, por favor intentelo nuevamente"
					);
			}
		}else{
			$this->Session->setFlash("Metodo no permitido","msg_fallo");
			return $this -> redirect(array("controller" => 'codigos_presupuestos', "action" => 'index'));
		}
		return json_encode($respuesta);
	}

	public function carga_masiva(){
		$this->layout = "angular";
	}

	public function carga_masiva_data(){
		$this->autoRender = false;
		$this->response->type("json");
		if(($file = fopen($this->params->form['file']['tmp_name'], "r")) !== FALSE)
		{
			while(!feof($file))
			{
				$data[] = fgetcsv($file,0, ";"); 
			}
			unset($data[0]);
			$erroresArchivo = array();
			if(!empty($data))
			{
				foreach ($data as $puntero => $codigosPresupuestario) 
				{
					if(!empty($codigosPresupuestario))
					{
						if(!empty($codigosPresupuestario[1]))
						{
							$codigo = trim($codigosPresupuestario[1]);
							$codigosPresupuestarios["conCodigo"][$codigo][$puntero+1] = $codigosPresupuestario;
						}else{
							$codigosPresupuestarios["sinCodigo"][$puntero+1] = $codigosPresupuestario;
						}
					}
					
				}
				$comprabacioCodigosQuery = $this->CodigosPresupuesto->find("all", array(
					"conditions"=>array(
						"CodigosPresupuesto.year_id"=>$this->request->data["year_id"],
						"CodigosPresupuesto.codigo"=>array_unique(array_keys($codigosPresupuestarios["conCodigo"]))
						)
					)
				);
				if(!empty($comprabacioCodigosQuery)){
					foreach ($comprabacioCodigosQuery as $codigosPresu) 
					{
						$comprabacionCodigos[$codigosPresu["CodigosPresupuesto"]["codigo"]] = $codigosPresu["CodigosPresupuesto"];
					}
				}
				foreach ($codigosPresupuestarios["conCodigo"] as $codigo => $lineas)
				{
					foreach ($lineas as $linea => $codigosPresupuestario) {
						$errores = array();
						empty($codigosPresupuestario[0]) ? array_push($errores, "Falta nombre") : "";
						empty($codigosPresupuestario[2]) ? array_push($errores, "Falta total") : "";
						(count($lineas)>1) ? array_push($errores, "Codigo repetido ".count($lineas)." veces, lineas ".implode(",", array_keys($lineas))) : "";
						isset($comprabacionCodigos[$codigo]) ? array_push($errores, "Codigo existente en la base de datos ") : "";
						if(count($errores) != 0)
						{
							$erroresArchivo[$linea] = array(
								"fila"=>$linea,
								"errores"=>$errores
								);
						}	
					}
				}
				if(!empty($codigosPresupuestarios["sinCodigo"]))
				{
					foreach ($codigosPresupuestarios["sinCodigo"] as $linea => $codigosPresupuestario) 
					{
						$errores = array();
						array_push($errores, "Sin Codigo");
						empty($codigosPresupuestario[0]) ? array_push($errores, "Falta nombre") : "";
						empty($codigosPresupuestario[2]) ? array_push($errores, "Falta total") : "";
						if(count($errores) != 0)
						{
							if(isset($erroresArchivo[$linea])){
								array_push($erroresArchivo[$linea]["errores"], $errores);
							}else{
								$erroresArchivo[$linea] = array(
									"fila"=>$linea,
									"errores"=>$errores
									);
							}
							
						}
					}
				}
				if(empty($erroresArchivo))
				{
					foreach ($data as $valores) 
					{
						if(!empty($valores)){
							$codigosInsert[] = array(
								"CodigosPresupuesto"=>array(
									"nombre"=>utf8_encode($valores[0]),
									"codigo"=>$valores[1],
									"presupuesto_total"=>$valores[2],
									"presupuesto_enero"=>$valores[3],
									"presupuesto_febrero"=>$valores[4],
									"presupuesto_marzo"=>$valores[5],
									"presupuesto_abril"=>$valores[6],
									"presupuesto_mayo"=>$valores[7],
									"presupuesto_junio"=>$valores[8],
									"presupuesto_julio"=>$valores[9],
									"presupuesto_agosto"=>$valores[10],
									"presupuesto_septiembre"=>$valores[11],
									"presupuesto_octubre"=>$valores[12],
									"presupuesto_noviembre"=>$valores[13],
									"presupuesto_diciembre"=>$valores[14],
									"year_id"=>$this->request->data["year_id"],
									'estado' => 1
									)
								);
						}
					}
					if(!empty($codigosInsert)){
						if($this->CodigosPresupuesto->saveAll($codigosInsert))
						{
							$respuesta = array("estado"=>1);
							$this->Session->setFlash("Se ingreso correctamente la carga masiva de codigos","msg_exito");
							CakeLog::write('actividad', 'Ingreso masivo - CodigosPresupuestario - carga_masiva_data - '.$this->CodigosPresupuesto->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						}else{
							$respuesta = array(
								"estado"=>0,
								"mensaje"=>"No se pudo guardar en la base de datos, por favor intentelo nuevamente"
								);
						}
					}
				}else
				{
					asort($erroresArchivo);
					$erroresArchivo = array_values($erroresArchivo);
					$respuesta = array(
						"estado"=>2,
						"errores"=>$erroresArchivo
						);
				}	
			}else
			{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Archivo vacio"
					);
			}
		}else
		{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No se pudo subir el archivo, por favor intentalo nuevamente"
				);
		}
		$this->response->body(json_encode($respuesta));
		
	}

}
