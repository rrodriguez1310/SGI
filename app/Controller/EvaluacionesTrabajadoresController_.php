<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('ServiciosController', 'Controller');
/**
 * EvaluacionesTrabajadores Controller
 *
 * @property EvaluacionesTrabajadore $EvaluacionesTrabajadore
 * @property PaginatorComponent $Paginator
 */
class EvaluacionesTrabajadoresController extends AppController {

	public function trabajadoresAEvaluar($anio=null){
		$this->loadModel("Trabajadore");
		if(!$anio) $anio = date('Y') . '-01-01';

		$this->Trabajadore->Behaviors->attach('Containable');
		$this->Trabajadore->contain ( array( "Documento" => array( 
				"fields" => array( "Documento.id", "Documento.fecha_final"), 
				"conditions" => array( "Documento.tipos_documento_id" => array(10),
					"Documento.fecha_final >" => $anio
					), 
				"order" => "Documento.fecha_final DESC"
				))
		);
		$listadoTrabajadores = $this->Trabajadore->find("all", array( 
			"conditions"=> array(
				"OR" => array(
					array( "Trabajadore.tipo_contrato_id"=>1), 	// 2015 tipo contrato solo indefinido. 
					array( "Trabajadore.tipo_contrato_id" => array(1,4), "( (EXTRACT(YEAR FROM DATE('$anio'))) - 1 ) > 2015")		// En adelante, indefinido y part-time
					),
				"Trabajadore.fecha_indefinido <" => $anio,
				array( 'NOT' => array("Trabajadore.rut" => array( "17.260.361-0" )) )
				),
			"recursive" => -1
		));
		$listadoAEvaluar = array();
		foreach ($listadoTrabajadores as $trabajador) {
			if(isset($trabajador["Documento"][0]["fecha_final"]) || $trabajador["Trabajadore"]["estado"] == "Activo"){
				if($trabajador["Trabajadore"]["estado"] == "Activo")
					$listadoAEvaluar[] = $trabajador["Trabajadore"]["id"];
				else if($trabajador["Documento"][0]["fecha_final"] > $anio && $trabajador["Trabajadore"]["estado"] == "Retirado")
						$listadoAEvaluar[] = $trabajador["Trabajadore"]["id"];
			}
		}
		return $listadoAEvaluar;
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$this->layout = "angular";
	
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Index Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));

		$accesos = $this->Session->Read("Acceso");
		foreach ($accesos as $acceso) {
			if($acceso["controlador"] == 'evaluaciones_trabajadores')
				$accesoPaginas[] = $acceso;
		}
		$this->set("accesoPaginas", $accesoPaginas);
	}

	public function evaluar() {
		$this->layout = "angular";

		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Listado Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */

	public function view($id = null) {
		$this->layout = "angular";

		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Ver Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->layout = "angular";

		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Add Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

	public function add_json($id) {
		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("NivelesLogro");
		$this->loadModel("TitulosCompetencia");
		$this->loadModel("CompetenciasGenerale");
		$this->loadModel("EvaluacionesTipo");
		$this->loadModel("Trabajadore");
		$this->loadModel("ObjetivosComentario");
		$this->loadModel("DialogosComentario");
		$this->loadModel("EvaluacionesAnio");
		$serv = new ServiciosController();

		$anio_evaluado = $this->EvaluacionesAnio->find("first", array ( "fields"=>array("id","anio_evaluado"), "conditions"=>array("estado"=>1) ) );
		$anioEvaluado  = $anio_evaluado["EvaluacionesAnio"]["anio_evaluado"];

		$trabajador = $this->Trabajadore->find("first", array(
			"fields"=>array( "EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.anio", "EvaluacionesTrabajadore.evaluaciones_estado_id", "EvaluacionesTrabajadore.puntaje_competencias", "EvaluacionesTrabajadore.puntaje_objetivos", "EvaluacionesTrabajadore.puntaje_ponderado", "EvaluacionesTrabajadore.niveles_logro_id", "EvaluacionesTrabajadore.fecha_inicio ",
				"Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.apellido_materno" , "Trabajadore.foto", "Cargo.id", "Cargo.nombre", "CargosFamilia.nombre", "CargosFamilia.id", "JefeTrabajadore.id", "JefeTrabajadore.nombre", "JefeTrabajadore.apellido_paterno", "Gerencia.id","Gerencia.nombre", "CalibradorJefe.id", "CalibradorJefe.nombre", "CalibradorJefe.apellido_paterno", "CalibradorJefe.email"),
			"joins"=> array( array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),
				array("table" => "trabajadores", "alias" => "JefeTrabajadore", "type" => "LEFT", "conditions" => array("Jefe.trabajadore_id = JefeTrabajadore.id")),
				array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
				array("table" => "jefes", "alias" => "Calibradore", "type" => "LEFT", "conditions" => array("JefeTrabajadore.jefe_id = Calibradore.id")),
				array("table" => "trabajadores", "alias" => "CalibradorJefe", "type" => "LEFT", "conditions" => array("Calibradore.trabajadore_id = CalibradorJefe.id")),
				array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.trabajadore_id = $id AND CAST(EvaluacionesTrabajadore.anio AS VARCHAR) = '$anioEvaluado'")),
				),	
			"conditions"=> array("Trabajadore.id"=>$id), 
			"recursive"=>0
			));
		
		//trabajador
		$datosTrabajador = array(
			"trabajadore_id"	=> $trabajador["Trabajadore"]["id"],
			"nombre"			=> $serv->capitalize(strtok($trabajador["Trabajadore"]["nombre"]," ").' '.$trabajador["Trabajadore"]["apellido_paterno"]),
			"nombre_completo"	=> $serv->capitalize($trabajador["Trabajadore"]["nombre"].' '.$trabajador["Trabajadore"]["apellido_paterno"]),
			"cargo" 			=> $serv->capitalize($trabajador["Cargo"]["nombre"]),
			"familia_cargo"		=> $serv->capitalize($trabajador["CargosFamilia"]["nombre"]),
			"gerencia"			=> $serv->capitalize($trabajador["Gerencia"]["nombre"]),
			"jefatura"			=> $serv->capitalize(strtok($trabajador["JefeTrabajadore"]["nombre"]," ").' '.$trabajador["JefeTrabajadore"]["apellido_paterno"]),
			"nombre_calibrador"	=> $serv->capitalize(strtok($trabajador["CalibradorJefe"]["nombre"]," ").' '.$trabajador["CalibradorJefe"]["apellido_paterno"]),
			"email_calibrador"	=> $trabajador["CalibradorJefe"]["email"],
			"cargos_familia_id" => $trabajador["CargosFamilia"]["id"],
			"foto" 				=> $this -> webroot . 'files' . DS . 'trabajadores' . DS . $trabajador["Trabajadore"]["foto"]
			);
		
		//evaluacion
		$nuevaEvaluacionTrabajador = array();
		if(isset($trabajador["EvaluacionesTrabajadore"]["id"])) 
			$nuevaEvaluacionTrabajador = array("id"=>$trabajador["EvaluacionesTrabajadore"]["id"]);
		
		$nuevaEvaluacionTrabajador = array_merge($nuevaEvaluacionTrabajador, array(
			"trabajadore_id"			=> $trabajador["Trabajadore"]["id"],
			"evaluador_trabajadore_id"	=> $trabajador["JefeTrabajadore"]["id"],
			"validador_trabajadore_id"	=> $trabajador["CalibradorJefe"]["id"],
			"evaluaciones_estado_id"	=> 1,
			"puntaje_competencias"		=> 0,
			"puntaje_objetivos"			=> 0,
			"puntaje_ponderado"			=> 0,
			"niveles_logro_id"			=> 0,
			"fecha_inicio"				=> date("Y-m-d"),
			"fecha_modificacion"		=> date("Y-m-d"),
			"anio"						=> $anio_evaluado["EvaluacionesAnio"]["anio_evaluado"],
			"evaluaciones_anio_id"		=> $anio_evaluado["EvaluacionesAnio"]["id"],
			"cargo_id"					=> $trabajador["Cargo"]["id"],
			"gerencia_id"				=> $trabajador["Gerencia"]["id"]
			));

		// tipos evaluaciones
		$this->EvaluacionesTipo->Behaviors->attach('Containable');
		$this->EvaluacionesTipo->contain( array(
			"NivelesLogro" => array("fields" => array("NivelesLogro.id", "NivelesLogro.secuencia", "NivelesLogro.rango_inicio", "NivelesLogro.rango_termino", "NivelesLogro.nombre", "NivelesLogro.definicion", "NivelesLogro.grafica"),
				"conditions" => array("NivelesLogro.estado" => 1),
				"order" => "NivelesLogro.secuencia ASC")
			));
		$tipoEvaluaciones = $this->EvaluacionesTipo->find("all", array("recursive"=>1));		
		
		foreach ($tipoEvaluaciones as $evaluaciones) {
			if($evaluaciones["EvaluacionesTipo"]["id"]==1){
				$criteriosEvaluacion["evaluacionCompetencias"]["nombre"] = $evaluaciones["EvaluacionesTipo"]["nombre"];
				$criteriosEvaluacion["evaluacionCompetencias"]["criterios"] = $evaluaciones["NivelesLogro"];
			}
			if($evaluaciones["EvaluacionesTipo"]["id"]==2){
				$criteriosEvaluacion["evaluacionObjetivos"]["nombre"] = $evaluaciones["EvaluacionesTipo"]["nombre"];
				$criteriosEvaluacion["evaluacionObjetivos"]["criterios"] = $evaluaciones["NivelesLogro"];
			}
			if($evaluaciones["EvaluacionesTipo"]["id"]==3){
				$criteriosEvaluacion["evaluacionPonderada"]["nombre"] = $evaluaciones["EvaluacionesTipo"]["nombre"];
				$criteriosEvaluacion["evaluacionPonderada"]["criterios"] = $evaluaciones["NivelesLogro"];
			}
		}
		
		//competencias
		$evaluacionesComEspecificas = $this->TitulosCompetencia->find("all", array(
			"fields"=>array("TitulosCompetencia.id", "TitulosCompetencia.nombre", "GruposCompetencia.id", "GruposCompetencia.nombre", "Competencia.id", "Competencia.nombre", "Competencia.secuencia"),
			"joins"=> array( array("table" => "grupos_competencias", "alias" => "GruposCompetencia", "type" => "LEFT", "conditions" => array("GruposCompetencia.titulos_competencia_id = TitulosCompetencia.id")),
					array("table" => "competencias", "alias" => "Competencia", "type" => "LEFT", "conditions" => array("Competencia.grupos_competencia_id = GruposCompetencia.id")) 
					),
			"conditions"=>array(
				array( "GruposCompetencia.cargos_familia_id" => $datosTrabajador["cargos_familia_id"], "TitulosCompetencia.estado" => 1 , 				
					"GruposCompetencia.estado" => 1, "Competencia.estado" => 1 ),
				),
			"recursive"=>0,
			"order" => array("TitulosCompetencia.secuencia ASC", "GruposCompetencia.secuencia ASC", "Competencia.secuencia ASC" ),
			));
		foreach ($evaluacionesComEspecificas as $competencia) {
			$competencias[] = array(
				"titulo"				=> $competencia["TitulosCompetencia"]["nombre"],				
				"grupos_competencia_id"	=> $competencia["GruposCompetencia"]["id"],
				"grupos_competencia"	=> ($competencia["Competencia"]["secuencia"]==1)? $competencia["GruposCompetencia"]["nombre"]: null,
				"id"					=> $competencia["Competencia"]["id"],
				"nombre" 				=> $competencia["Competencia"]["nombre"],	
				"secuencia"				=> $competencia["Competencia"]["secuencia"],			
				);
		}
		
		$evaluacionesComGenerales = $this->CompetenciasGenerale->find("all", array(
			"fields"=>array("TitulosCompetencia.nombre", "CompetenciasGenerale.nombre", "CompetenciasGenerale.id","CompetenciasGenerale.secuencia"),
			"conditions"=>array( array( "TitulosCompetencia.estado" => 1, "CompetenciasGenerale.estado" => 1),
				),
			"recursive"=>0,
			"order" => array("CompetenciasGenerale.secuencia ASC"),
			));

		foreach ($evaluacionesComGenerales as $comGeneral) {
			$comGenerales[] = array(
				"id"		=> $comGeneral["CompetenciasGenerale"]["id"],	
				"nombre"	=> $comGeneral["CompetenciasGenerale"]["nombre"],
				"titulo"	=> ($comGeneral["CompetenciasGenerale"]["secuencia"]==1)? $comGeneral["TitulosCompetencia"]["nombre"]:null
				);
		}
		//objetivos clave
		$objetivosClave = $this->ObjetivosComentario->find("all", array( "fields"=>array("id", "nombre"),
			"conditions"=>array( "ObjetivosComentario.estado" => 1 ),
			"recursive"=>0,
			"order" => array( "ObjetivosComentario.secuencia ASC" ),
		));
		foreach ($objetivosClave as $objetivo) {
			$objClave[] = $objetivo["ObjetivosComentario"];
		}
		//dialogo
		$dialogosDesempeno = $this->DialogosComentario->find("all", array( "fields"=>array("id", "nombre", "definicion", "requerido"),
			"conditions"=>array( "DialogosComentario.estado" => 1 ),	//evaluador
			"recursive"=>0,
			"order" => array( "DialogosComentario.secuencia ASC" ),
		));
		foreach ($dialogosDesempeno as $dialogo) {			
			$dialogos[] = $dialogo["DialogosComentario"];
		}

		$datosNuevaEvaluacion = array(
			"EvaluacionesTrabajadore" 	=>  $nuevaEvaluacionTrabajador,	
			"datosTrabajador" 			=>  $datosTrabajador,
			"criteriosEvaluacion"		=>	$criteriosEvaluacion,
			"competencias" 				=> 	$competencias,
			"competenciasGenerales" 	=> 	$comGenerales,
			"objetivosClave"			=>  $objClave,
			"dialogosDesempeno"			=> 	$dialogos
		);
		
		$this->set("datosNuevaEvaluacion", $datosNuevaEvaluacion);
	}

	public function add_evaluacion(){
		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("EvaluacionesEstado");
		$this->loadModel("Feriado");
		$this->loadModel("Trabajadore");
		$this->loadModel("EvaluacionesAnio");


		if( array_key_exists( "id", $this->request->data["EvaluacionesTrabajadore"] ) ){

			$this->EvaluacionesTrabajadore->id = $this->request->data["EvaluacionesTrabajadore"]["id"];

			if( $this->EvaluacionesTrabajadore->exists() ) {					//edit

				if($this->EvaluacionesTrabajadore->saveAssociated($this->request->data, array('deep' => true) )){
					CakeLog::write('actividad', 'actualizo - EvaluacionesTrabajadores - add_evaluacion - id '.$this->EvaluacionesTrabajadore->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));

					$data = $this->formulario($this->EvaluacionesTrabajadore->id);
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"Se actualizó correctamente",
						"id" => $this->EvaluacionesTrabajadore->id,
						"data" => $data
						);

				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"No se pudo ingresar, por favor intentelo de nuevo",
						"id"=>null
						);
				}

			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"La evaluación no existe",
					"id" => ($this->EvaluacionesTrabajadore->id)
					);
			}
		}else{
			
			if($this->EvaluacionesTrabajadore->saveAssociated($this->request->data, array('deep' => true))){
				CakeLog::write('actividad', 'agrego - EvaluacionesTrabajadores - add_evaluacion - id '.$this->EvaluacionesTrabajadore->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				
				$data = $this->formulario($this->EvaluacionesTrabajadore->id);
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Se actualizó correctamente",		//ingreso
					"id"=> $this->EvaluacionesTrabajadore->id,
					"data" => $data
					);

			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se pudo ingresar, por favor intentelo de nuevo",
					"id"=>null
					);
			}
		}
		
		if( isset($this->request->data["EnvioCorreo"]) ) {
			if($respuesta["estado"]==1){

				$file = null;
				$this->request->data["EnvioCorreo"]["copia"] = null;
				$correos = array();

				if($this->request->data["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]==4){  //enviado a calibracion 3 cambia a 4
					
					$estado = $this->EvaluacionesEstado->find("first", array("fields"=>"dias_plazo","conditions"=> array("id"=>$this->request->data["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]),"recursive"=>0));
					$this->request->data["EnvioCorreo"]["dias_plazo"] = $estado["EvaluacionesEstado"]["dias_plazo"];
					$this->request->data["EnvioCorreo"]["plantilla"] = 'evaluacion_correo_calibrador';
					
					$correos[] = $this->request->data["EnvioCorreo"];

				} else if( $this->request->data["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]==5 || $this->request->data["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]==7 ){  // calibrada
					
					if($this->request->data["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]==5)
						$this->request->data["EnvioCorreo"]["estado"] = 'con'; 	//observaciones
					else
						$this->request->data["EnvioCorreo"]["estado"] = 'sin';

					$this->request->data["EnvioCorreo"]["plantilla"] = 'evaluacion_correo_calibrada';

					$correos[] = $this->request->data["EnvioCorreo"];

				} else if($this->request->data["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]==8){  //cita reunion 7 cambia a 8
					//evaluacion adjunta 
					/*if(isset($this->request->data["EnvioCorreo"]["archivo_adjunto"])){
						$archivo = WWW_ROOT . "files" . DS . $this->request->data["EnvioCorreo"]["archivo_controlador"] . DS . $this->request->data["EnvioCorreo"]["archivo_carpeta"] . DS . $this->request->data["EnvioCorreo"]["archivo_adjunto"];						
						$this->request->data["EnvioCorreo"]["file"] = new File($archivo, false, 0777);
					}*/
					
					$this->request->data["EnvioCorreo"]["plantilla"] = 'evaluacion_correo_cita';
					$this->request->data["EnvioCorreo"]["copia"] = $this->request->data["EnvioCorreo"]["evaluador_email"];					

					$correos[] = $this->request->data["EnvioCorreo"];

				} else if($this->request->data["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]==9){  //envío validacion colaborador
					
					$estado = $this->EvaluacionesEstado->find("first", array("fields"=>"dias_plazo","conditions"=> array("id"=>$this->request->data["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]),"recursive"=>0));
					$anioEvaluado = $this->EvaluacionesAnio->find("first", array ( "fields"=>"anio_evaluado", "conditions"=>array("estado"=>1)));

					$this->request->data["EnvioCorreo"]["dias_plazo"] = $estado["EvaluacionesEstado"]["dias_plazo"];
					$this->request->data["EnvioCorreo"]["anio_evaluacion"] = $anioEvaluado["EvaluacionesAnio"]["anio_evaluado"];
					$this->request->data["EnvioCorreo"]["plantilla"] = 'evaluacion_correo_colaborador';

					// correo 1
					$correos[] = $this->request->data["EnvioCorreo"];

					if($this->request->data["EvaluacionesTrabajadore"]["modificada"] == 1){
						
						// correo 2
						$this->request->data["EnvioCorreo"]["plantilla"] = 'evaluacion_correo_modificacion';
						$this->request->data["EnvioCorreo"]["enviar_a_email"] = $this->request->data["EnvioCorreo"]["calibrador_email"];
						$this->request->data["EnvioCorreo"]["asunto"] = 'Modificación Evaluación de Desempeño '. $this->request->data["EnvioCorreo"]["trabajador_nombre"];

						if(array_key_exists("archivo_adjunto", $this->request->data["EnvioCorreo"])){
							$archivo = WWW_ROOT . "files" . DS . 'evaluaciones_trabajadores' . DS . 'tmp' . DS . 'preliminar'.$this->request->data["EvaluacionesTrabajadore"]["trabajadore_id"].'.pdf';
							$this->request->data["EnvioCorreo"]["file"] = new File($archivo, false, 0777);		
						}
						$correos[] = $this->request->data["EnvioCorreo"];
					}

				} else if($this->request->data["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]==10 || $this->request->data["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]==11){
					$anioEvaluado = $this->EvaluacionesAnio->find("first", array ( "fields"=>"anio_evaluado", "conditions"=>array("estado"=>1)));
					$this->request->data["EnvioCorreo"]["anio_evaluacion"] = $anioEvaluado["EvaluacionesAnio"]["anio_evaluado"];

					if($this->request->data["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]==10){						
						$this->request->data["EnvioCorreo"]["estado"] = 'con'; 	//observaciones
					}else{

						$this->request->data["EnvioCorreo"]["estado"] = 'sin';
						//gau
						/*$archivo = WWW_ROOT . "files" . DS . $this->request->data["EnvioCorreo"]["archivo_controlador"] . DS . $this->request->data["EnvioCorreo"]["archivo_carpeta"] . DS . $this->request->data["EnvioCorreo"]["archivo_adjunto"];
						$this->request->data["EnvioCorreo"]["file"] = new File($archivo, true, 0777);	
						*/
					}
					//gau
						$archivo = WWW_ROOT . "files" . DS . $this->request->data["EnvioCorreo"]["archivo_controlador"] . DS . $this->request->data["EnvioCorreo"]["archivo_carpeta"] . DS . $this->request->data["EnvioCorreo"]["archivo_adjunto"];
						$this->request->data["EnvioCorreo"]["file"] = new File($archivo, true, 0777);
					//
					$this->request->data["EnvioCorreo"]["plantilla"] = 'evaluacion_correo_validada';
					if(isset($this->request->data["EnvioCorreo"]["calibrador_comentarios"]))
						$this->request->data["EnvioCorreo"]["calibrador_comentarios"] = $this->request->data["EnvioCorreo"]["calibrador_comentarios"];

					$correos[] = $this->request->data["EnvioCorreo"];
				}

				foreach ($correos as $correo) {
								
					$datos["datos"] = $correo;
					$Email = new CakeEmail("gmail");
					$Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
					$Email->to($correo["enviar_a_email"]);//$correo["enviar_a_email"];
					if(isset($correo["copia"]))	$Email->cc($correo["copia"]);
					$Email->subject($correo["asunto"]); //$correo["asunto"]
					$Email->emailFormat('html');
					$Email->template($correo["plantilla"]);
					$Email->viewVars($datos);
					if(isset($correo["file"]))
					{
						if($correo["file"]->exists()){
							$Email->attachments(array($correo["file"]->pwd()));
						}
					}
					if($Email->send())
					{
						$respuesta = array_merge($respuesta, array("correo"=>1,
							"mensaje_correo"=>"La información se ha enviado correctamente.")
							);

						if(isset($correo["file"]))
						{
							if($correo["file"]->exists()){
								$correo["file"]->delete();
							}
						}
					}else{
						$respuesta = array_merge($respuesta, array("correo"=>-1));
					}
				}	
			}

		}else{

			$respuesta = array_merge($respuesta, array("correo"=>0));
		}
		
		$this->set("respuesta", $respuesta);
	}

	public function subir_evaluacion(){

		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Trabajadore");

		$this->request->data["EvaluacionesTrabajadore"] = $this->request->data;
		
		$respuesta = array();

		if($this->request->params["form"]["file"]['error'] == 0 && $this->request->params["form"]["file"]['size'] > 0.000000000000){
         	$destino = WWW_ROOT.'files'.DS.'evaluaciones_trabajadores'.DS.$this->request->data["EvaluacionesTrabajadore"]["anio"].DS.$this->request->data["EvaluacionesTrabajadore"]["trabajadore_id"].DS.date("d_ms");

         	if (!file_exists($destino)){
				mkdir($destino, 0777, true);
				chmod($destino, 0777);
			}

			if(is_uploaded_file($this->request->params["form"]["file"]['tmp_name'])){

				if($this->request->params["form"]["file"]['size'] <= 7000000){

					$subido = move_uploaded_file($this->request->params["form"]["file"]["tmp_name"], $destino . DS .$this->request->params["form"]["file"]['name']);
					$rutaArchivo = $this->request->data["EvaluacionesTrabajadore"]["anio"].DS.$this->request->data["EvaluacionesTrabajadore"]["trabajadore_id"].DS.date("d_ms").DS.$this->request->params["form"]["file"]['name'];

					if($subido&&$rutaArchivo!=''){

						$this->EvaluacionesTrabajadore->id = trim($this->request->data["EvaluacionesTrabajadore"]["id"]);
						$this->request->data["EvaluacionesTrabajadore"]["ruta_archivo"] = $rutaArchivo;
						
						if( $this->EvaluacionesTrabajadore->exists() ) {
							if($this->EvaluacionesTrabajadore->saveAssociated($this->request->data, array('deep' => true) )){
								CakeLog::write('actividad', 'subio archivo - EvaluacionesTrabajadores - subir_evaluacion - id '.$this->EvaluacionesTrabajadore->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));

								$data = $this->formulario($this->EvaluacionesTrabajadore->id);
								$respuesta = array(
									"estado_archivo"=>1,									
									"data" => $data,
									"ruta_archivo" => $rutaArchivo
									);
							}
						}

					}else 
						$respuesta = array("estado_archivo"=>-1,"mensaje"=>"Error: archivo no se pudo subir.");
				}
				else					
					$respuesta = array("estado_archivo"=>0,"mensaje"=>"Error: archivo demasiado grande");				
			}
			else					
				$respuesta = array("estado_archivo"=>-1,"mensaje"=>"Error: archivo no se pudo subir");				
		}else
			$respuesta = array("estado_archivo"=>-2,"mensaje"=>"Error: archivo no tiene un formato válido");				
		
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
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Ver Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

	public function calibrar_edit($id = null) {
		$this->layout = "angular";
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Calibrar Edit Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

	public function edit_json($id = null){
		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("NivelesLogro");
		$this->loadModel("Trabajadore");
		$this->loadModel("Competencia");
		$this->loadModel("CompetenciasGenerale");
		$this->loadModel("EvaluacionesTipo");
		$this->loadModel("ObjetivosComentario");
		$this->loadModel("DialogosComentario");
		$this->loadModel("EvaluacionesAnio");
		$this->loadModel("EvaluacionesCompetencia");
		$this->loadModel("GruposCompetencia");
		$this->loadModel("EvaluacionesObjetivo");
		$this->loadModel("EvaluacionesEstado");		
		$serv = new ServiciosController();

		//evaluacion
		$evaluacion = $this->formulario($id);

		// tipos evaluaciones
		$tipoEvaluaciones = $this->EvaluacionesTipo->find("all",array("recursive"=>0));
		foreach ($tipoEvaluaciones as $evaluaciones) {
			$tiposEvaluaciones[] = $evaluaciones["EvaluacionesTipo"];
		}
		//datos trabajador 
		$datosTrabajadorG = $this->Trabajadore->find("all", array(
			"fields"=>array("Trabajadore.id","Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.apellido_materno", "Trabajadore.email", "Trabajadore.foto", "Cargo.nombre", "CargosFamilia.nombre", "CargosFamilia.id", "JefeTrabajadore.id", "JefeTrabajadore.nombre", "JefeTrabajadore.apellido_paterno", "JefeTrabajadore.email", "Gerencia.nombre", "CalibradorJefe.id", "CalibradorJefe.nombre", "CalibradorJefe.apellido_paterno", "CalibradorJefe.email"),
			"joins"=> array( array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("Trabajadore.id = EvaluacionesTrabajadore.trabajadore_id")),
				array("table" => "cargos", "alias" => "Cargo", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.cargo_id = Cargo.id")),
				array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),
				array("table" => "trabajadores", "alias" => "JefeTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.evaluador_trabajadore_id = JefeTrabajadore.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.gerencia_id = Gerencia.id")),
				array("table" => "jefes", "alias" => "Calibradore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.validador_trabajadore_id = Calibradore.trabajadore_id")),
				array("table" => "trabajadores", "alias" => "CalibradorJefe", "type" => "LEFT", "conditions" => array("Calibradore.trabajadore_id = CalibradorJefe.id")),
					),	
			"conditions"=>array( "Trabajadore.id"=>$evaluacion["EvaluacionesTrabajadore"]["trabajadore_id"],
				"EvaluacionesTrabajadore.id" => $id),
			"recursive"=>-1
			));

		foreach ($datosTrabajadorG as $trabajador) {			
			$datosTrabajador = array(
				"trabajadore_id"	=> $trabajador["Trabajadore"]["id"],
				"nombre"			=> $serv->capitalize(strtok($trabajador["Trabajadore"]["nombre"]," ").' '.$trabajador["Trabajadore"]["apellido_paterno"]),
				"nombre_completo"	=> $serv->capitalize($trabajador["Trabajadore"]["nombre"].' '.$trabajador["Trabajadore"]["apellido_paterno"]),
				"cargo" 			=> $serv->capitalize($trabajador["Cargo"]["nombre"]),
				"familia_cargo"		=> $serv->capitalize($trabajador["CargosFamilia"]["nombre"]),
				"email"				=> $trabajador["Trabajadore"]["email"],
				"gerencia"			=> $serv->capitalize($trabajador["Gerencia"]["nombre"]),
				"jefatura"			=> $serv->capitalize(strtok($trabajador["JefeTrabajadore"]["nombre"]," ").' '.$trabajador["JefeTrabajadore"]["apellido_paterno"]),
				"email_jefatura"	=> $trabajador["JefeTrabajadore"]["email"],
				"nombre_calibrador"	=> $serv->capitalize(strtok($trabajador["CalibradorJefe"]["nombre"]," ").' '.$trabajador["CalibradorJefe"]["apellido_paterno"]),
				"email_calibrador"	=> $trabajador["CalibradorJefe"]["email"],
				"foto" 				=> $this -> webroot . 'files' . DS . 'trabajadores' . DS . $trabajador["Trabajadore"]["foto"] 
				);
		}		
		// tipos evaluaciones / criterios de evaluacion
		$this->EvaluacionesTipo->Behaviors->attach('Containable');
		$this->EvaluacionesTipo->contain( array(
			"NivelesLogro" => array("fields" => array("NivelesLogro.id", "NivelesLogro.secuencia", "NivelesLogro.rango_inicio", "NivelesLogro.rango_termino", "NivelesLogro.nombre", "NivelesLogro.definicion", "NivelesLogro.grafica"),
				"conditions" => array("NivelesLogro.estado" => 1),
				"order" => "NivelesLogro.secuencia ASC")
			));
		$tipoEvaluaciones = $this->EvaluacionesTipo->find("all",array("recursive"=>1));		
		foreach ($tipoEvaluaciones as $evaluaciones) {					
			if($evaluaciones["EvaluacionesTipo"]["id"]==1){
				$criteriosEvaluacion["evaluacionCompetencias"]["nombre"] = $evaluaciones["EvaluacionesTipo"]["nombre"];
				$criteriosEvaluacion["evaluacionCompetencias"]["criterios"] = $evaluaciones["NivelesLogro"];
			}
			if($evaluaciones["EvaluacionesTipo"]["id"]==2){
				$criteriosEvaluacion["evaluacionObjetivos"]["nombre"] = $evaluaciones["EvaluacionesTipo"]["nombre"];
				$criteriosEvaluacion["evaluacionObjetivos"]["criterios"] = $evaluaciones["NivelesLogro"];
			}
			if($evaluaciones["EvaluacionesTipo"]["id"]==3){
				$criteriosEvaluacion["evaluacionPonderada"]["nombre"] = $evaluaciones["EvaluacionesTipo"]["nombre"];
				$criteriosEvaluacion["evaluacionPonderada"]["criterios"] = $evaluaciones["NivelesLogro"];
			}
		}
		//competencias
		foreach ($evaluacion["EvaluacionesCompetencia"] as $key =>  $competencia) {
			$competenciasEvaluacionId[] = $competencia["competencia_id"];
		}
		$competenciasEspecificas = $this->Competencia->find("all", array(
			"fields" => array("Competencia.id","Competencia.nombre", "Competencia.secuencia", "GruposCompetencia.id","GruposCompetencia.nombre", "GruposCompetencia.secuencia", "TitulosCompetencia.nombre"),
			"joins" => array( array("table" => "titulos_competencias", "alias" => "TitulosCompetencia", "type" => "LEFT", "conditions" => array("GruposCompetencia.titulos_competencia_id = TitulosCompetencia.id"))),
			"conditions" => array("Competencia.id"=>$competenciasEvaluacionId),
			"recursive"=>0,
			"order" => array("TitulosCompetencia.secuencia ASC, GruposCompetencia.secuencia ASC, Competencia.secuencia ASC"),
			));
		foreach ($competenciasEspecificas as $competencia) {
			$dataCompetencias[] = array( "id" => $competencia["Competencia"]["id"],
				"nombre" => $competencia["Competencia"]["nombre"],
				"grupos_competencia" => ($competencia["Competencia"]["secuencia"] == 1)? $competencia["GruposCompetencia"]["nombre"]:null,
				"titulo" => ($competencia["Competencia"]["secuencia"] == 1 && $competencia["GruposCompetencia"]["secuencia"]==1 )? $competencia["TitulosCompetencia"]["nombre"]:null,
				);
		}
		//competencias generales
		foreach ($evaluacion["EvaluacionesCompetenciasGenerale"] as $competenciaGeneral) {
			$competenciasGeneralesEvaluacionId[] = $competenciaGeneral["competencias_generale_id"];
		}
		$competenciasGenerales = $this->CompetenciasGenerale->find("all", array(
			"conditions" => array("CompetenciasGenerale.id"=>$competenciasGeneralesEvaluacionId),
			"recursive"=>0,
			"order" => array("CompetenciasGenerale.secuencia ASC"),
			));
		foreach ($competenciasGenerales as $comGeneral) {
			$dataComGeneral[] = array( "id" => $comGeneral["CompetenciasGenerale"]["id"],
				"nombre" => $comGeneral["CompetenciasGenerale"]["nombre"],
				"titulo" => ($comGeneral["CompetenciasGenerale"]["secuencia"]==1)? $comGeneral["TitulosCompetencia"]["nombre"]: null
				);
		}

		//porcentaje grupo competencias 
		$ptjCompetencias = $this->EvaluacionesCompetencia->find("all", array(
			"fields" => array("EvaluacionesCompetencia.id", "EvaluacionesCompetencia.puntaje", "EvaluacionesCompetencia.competencia_id", "Competencia.id", "Competencia.grupos_competencia_id"),
			"conditions"=> array("EvaluacionesCompetencia.evaluaciones_trabajadore_id" => $id),
			"recursive"=> 0
		));
		$agrupaCompetencias;
		foreach ($ptjCompetencias as $competencia)
		{
			$agrupaCompetencias[$competencia["Competencia"]["grupos_competencia_id"]][] = $competencia["EvaluacionesCompetencia"]["puntaje"];
		}
		$max = $criteriosEvaluacion["evaluacionCompetencias"]["criterios"][count($criteriosEvaluacion["evaluacionCompetencias"]["criterios"])-1]["rango_inicio"];
		$puntajeMax = $max * (count($criteriosEvaluacion["evaluacionCompetencias"]["criterios"])-1);
		foreach ($agrupaCompetencias as $key => $value) {
			$porcentajes[$key] = array_sum($value)/$puntajeMax * 100;
			$totales[$key] = array_sum($value);
		}
		$gruposCompetenciaG = $this->GruposCompetencia->find("all", array(
			"fields" => array("GruposCompetencia.id","GruposCompetencia.nombre"),			
			"conditions" => array("GruposCompetencia.estado"=>1, "GruposCompetencia.cargos_familia_id" => $datosTrabajadorG[0]["CargosFamilia"]["id"]),
			"recursive" => 0
		));
		foreach ($gruposCompetenciaG as $value) {
			$gruposCompetencia[$value["GruposCompetencia"]["id"]] = $value["GruposCompetencia"];
		}

		foreach ($gruposCompetencia as $key => $value) {			
			$totalesGrupos[$key] = array("nombre" => $value["nombre"], "suma" => $totales[$key],"porcentaje"=>$porcentajes[$key], "maximo"=>$puntajeMax);
		}
		
		//objetivos clave
		$objetivosClave = $this->ObjetivosComentario->find("all", array( "fields"=>array("id", "nombre"),
			"conditions"=>array( "ObjetivosComentario.estado" => 1 ),
			"recursive"=>0,
			"order" => array( "ObjetivosComentario.secuencia ASC" ),
		));
		foreach ($objetivosClave as $objetivo) {
			$objClave[] = $objetivo["ObjetivosComentario"];
			$nombresClave[$objetivo["ObjetivosComentario"]["id"]] = $objetivo["ObjetivosComentario"]["nombre"];
		}

		// porcentaje objetivos
		$ptjObjetivos = $this->EvaluacionesObjetivo->find("all", array(
			"fields" => array("EvaluacionesObjetivo.id", "EvaluacionesObjetivo.puntaje", "EvaluacionesObjetivo.objetivos_comentario_id"),
			"conditions"=> array("EvaluacionesObjetivo.evaluaciones_trabajadore_id" => $id),
			"recursive"=> 0
		));
		$porcObjetivos;
		$maxObj = $criteriosEvaluacion["evaluacionObjetivos"]["criterios"][count($criteriosEvaluacion["evaluacionCompetencias"]["criterios"])-1]["rango_termino"];
		foreach ($ptjObjetivos as $objetivo)
		{
			$porcObjetivos[] = array( "id" => $objetivo["EvaluacionesObjetivo"]["objetivos_comentario_id"], 
				"nombre" => $nombresClave[$objetivo["EvaluacionesObjetivo"]["objetivos_comentario_id"]], 
				"puntaje" => $objetivo["EvaluacionesObjetivo"]["puntaje"],
				"porcentaje" => round(($objetivo["EvaluacionesObjetivo"]["puntaje"] / $maxObj) * 100 , 0 )
				);
		}
		
		//dialogo
		$dialogosDesempeno = $this->DialogosComentario->find("all", array( "fields"=>array("id", "nombre", "definicion", "requerido"),
			"conditions"=>array( "DialogosComentario.estado" => 1 ),	//evaluador
			"recursive"=>0,
			"order" => array( "DialogosComentario.secuencia ASC" ),
		));
		foreach ($dialogosDesempeno as $dialogo) {
			$dialogos[] = $dialogo["DialogosComentario"];
		}

		
		$anioEvaluado = $this->EvaluacionesAnio->find("first", array ( "fields"=>"anio_evaluado", "conditions"=>array("estado"=>1) ) );
		$diasPlazo = 0;
		$estado = $this->EvaluacionesEstado->find("first", array("fields"=>"dias_plazo","conditions"=> array("id"=>$evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]),"recursive"=>0));
		if(!empty($estado["EvaluacionesEstado"]["dias_plazo"]))
			$diasPlazo = $estado["EvaluacionesEstado"]["dias_plazo"];		
		
		$editEvaluacion = array_merge(
			$evaluacion, 
			array(				
				"tiposEvaluaciones" 		=>  $tiposEvaluaciones,					//data
				"datosTrabajador" 			=>  $datosTrabajador,
				"anio_evaluado"				=>  $anioEvaluado["EvaluacionesAnio"]["anio_evaluado"],
				"dias_plazo"				=>  $diasPlazo,
				"criteriosEvaluacion" 		=>  $criteriosEvaluacion,
				"competencias" 				=>  $dataCompetencias,
				"competenciasGenerales" 	=>  $dataComGeneral,
				"objetivosClave"			=>  $objClave,
				"dialogosDesempeno"			=>  $dialogos,
				"puntajesGrupoComp" 		=>  (!empty($totalesGrupos))? $totalesGrupos : 0 ,
				"puntajesObjetivos"			=>  (!empty($porcObjetivos))? $porcObjetivos : 0 )
		);

		$this->set("editEvaluacion", $editEvaluacion);
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */

	public function formulario($id){

		$this->layout = "ajax";
		$this->response->type('json');

		$this->EvaluacionesTrabajadore->Behaviors->attach('Containable');
		$this->EvaluacionesTrabajadore->contain("EvaluacionesCompetencia.id", 
			"EvaluacionesCompetencia.evaluaciones_trabajadore_id", 
			"EvaluacionesCompetencia.competencia_id", 
			"EvaluacionesCompetencia.niveles_logro_id",
			"EvaluacionesCompetencia.puntaje", 
			"EvaluacionesCompetencia.puntaje_calibrado", 
			"EvaluacionesCompetencia.puntaje_modificado", 
			"EvaluacionesCompetencia.modificado_evaluador", 
			"EvaluacionesCompetencia.observado_validador", 
			"EvaluacionesCompetencia.observacion", 
			"EvaluacionesCompetencia.validado", 
			"EvaluacionesCompetenciasGenerale.id", 
			"EvaluacionesCompetenciasGenerale.evaluaciones_trabajadore_id", 
			"EvaluacionesCompetenciasGenerale.competencias_generale_id", 
			"EvaluacionesCompetenciasGenerale.niveles_logro_id",
			"EvaluacionesCompetenciasGenerale.puntaje", 
			"EvaluacionesCompetenciasGenerale.puntaje_calibrado", 
			"EvaluacionesCompetenciasGenerale.puntaje_modificado", 
			"EvaluacionesCompetenciasGenerale.modificado_evaluador", 
			"EvaluacionesCompetenciasGenerale.observado_validador", 
			"EvaluacionesCompetenciasGenerale.observacion", 
			"EvaluacionesCompetenciasGenerale.validado", 
			"EvaluacionesObjetivo.id", 
			"EvaluacionesObjetivo.objetivos_comentario_id", 
			"EvaluacionesObjetivo.niveles_logro_id", 
			"EvaluacionesObjetivo.descripcion_objetivo", 
			"EvaluacionesObjetivo.observado_validador", 
			"EvaluacionesObjetivo.observacion", 
			"EvaluacionesObjetivo.validado", 
			"EvaluacionesObjetivo.puntaje",
			"EvaluacionesObjetivo.puntaje_calibrado", 
			"EvaluacionesObjetivo.puntaje_modificado", 
			"EvaluacionesObjetivo.modificado_evaluador", 
			"EvaluacionesObjetivo.porcentaje_ponderacion", 
			"EvaluacionesDialogo.id", 
			"EvaluacionesDialogo.dialogos_comentario_id", 
			"EvaluacionesDialogo.comentario");

		$evaluacion = $this->EvaluacionesTrabajadore->find("first", array(
			"fields" => array("EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.trabajadore_id", "EvaluacionesTrabajadore.evaluador_trabajadore_id", "EvaluacionesTrabajadore.anio", 
				"EvaluacionesTrabajadore.evaluaciones_estado_id","EvaluacionesTrabajadore.puntaje_competencias", "EvaluacionesTrabajadore.puntaje_objetivos", 
				"EvaluacionesTrabajadore.puntaje_ponderado", "EvaluacionesTrabajadore.niveles_logro_id", "EvaluacionesTrabajadore.fecha_modificacion", 
				"EvaluacionesTrabajadore.fecha_reunion", "EvaluacionesTrabajadore.hora_reunion", "EvaluacionesTrabajadore.lugar_reunion", "EvaluacionesTrabajadore.mensaje_reunion", 
				"EvaluacionesTrabajadore.acepta_trabajador", "EvaluacionesTrabajadore.comentario_trabajador", "EvaluacionesTrabajadore.ruta_archivo", 
				"EvaluacionesTrabajadore.evaluaciones_anio_id", "EvaluacionesTrabajadore.modificada", "EvaluacionesTrabajadore.cargo_id", "EvaluacionesTrabajadore.gerencia_id"),
			"conditions"=> array("EvaluacionesTrabajadore.id" => $id),
			"recursive"=> 1
		));

		$formulario = $evaluacion;
		$formulario["EvaluacionesTrabajadore"]["puntaje_objetivos"] = floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_objetivos"]);
		$formulario["EvaluacionesTrabajadore"]["puntaje_ponderado"] = floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_ponderado"]);		

		if($formulario["EvaluacionesTrabajadore"]["evaluador_trabajadore_id"] == 110 ||$formulario["EvaluacionesTrabajadore"]["evaluador_trabajadore_id"] == 111 ||$formulario["EvaluacionesTrabajadore"]["evaluador_trabajadore_id"] == 403)
			$formulario["EvaluacionesTrabajadore"]["nodo_inicial"] = 1;
		else
			$formulario["EvaluacionesTrabajadore"]["nodo_inicial"] = 0;

		// ASC
		usort($formulario["EvaluacionesCompetencia"], 			function($a, $b) {return $a['competencia_id'] - $b['competencia_id'];});
		usort($formulario["EvaluacionesCompetenciasGenerale"], 	function($a, $b) {return $a['competencias_generale_id'] - $b['competencias_generale_id'];});
		usort($formulario["EvaluacionesObjetivo"], 				function($a, $b) {return $a['objetivos_comentario_id'] - $b['objetivos_comentario_id'];});
		usort($formulario["EvaluacionesDialogo"], 				function($a, $b) {return $a['dialogos_comentario_id'] - $b['dialogos_comentario_id'];});

		$this->set("formulario", $formulario);
		return $formulario;
	}

	public function confirmar_json($id){
		$this->layout = "ajax";
		$this->response->type('json');
		$evaluacion = $this->formulario($id);
		$this->set("evaluacion", $evaluacion);
	}

	public function confirmar(){

		$this->layout = "angular";

		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Confirmar Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

	public function listado_evaluaciones(){

		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("Trabajadore");
		$this->loadModel("Jefe");
		$this->loadModel("EvaluacionesAnio");
		$this->loadModel("User");
		$serv = new ServiciosController();

		$anioEvaluado = $this->EvaluacionesAnio->find("first", array ( "fields"=>"anio_evaluado", "conditions"=>array("estado"=>1)));	
		$anioActual = $anioEvaluado["EvaluacionesAnio"]["anio_evaluado"];
		//Usuario-Trabajador
		$datosTrabajador = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
			"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
			));
		
		
		$evaluaciones = $this->EvaluacionesTrabajadore->find("first", array(
			"fields" => array("EvaluacionesTrabajadore.id"),
			"conditions"=>array("EvaluacionesTrabajadore.trabajadore_id"=> $datosTrabajador["User"]["trabajadore_id"],
				"EvaluacionesTrabajadore.evaluaciones_estado_id" => array(10, 11 ,12),									//finalizado
				"EvaluacionesAnio.estado"=>1),
			"recursive"=>0
		));
		//jefe
		$datosJefe = $this->Jefe->find("first", array(
			"fields"=>array("Jefe.id", "Trabajadore.id", "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.cargo_id", "Trabajadore.foto", "Cargo.nombre", 
				"TrabajadoresCalibradore.id", "TrabajadoresCalibradore.nombre", "TrabajadoresCalibradore.apellido_paterno", "TrabajadoresCalibradore.cargo_id", "TrabajadoresCalibradore.foto", "TrabajadoresCalibradore.jefe_id", "TrabajadoresCalibradore.email", "CargosCalibradore.nombre", "EvaluacionesTrabajadore.id"),
			"joins" => array( array( "table" => "cargos", "alias"=>"Cargo", "type" => "LEFT", "conditions" => array("Trabajadore.cargo_id = Cargo.id")),
				array( "table" =>"jefes", "alias"=>"Calibradore", "type" => "LEFT", "conditions" => array("Trabajadore.jefe_id = Calibradore.id")),
				array( "table" =>"trabajadores","alias"=>"TrabajadoresCalibradore", "type" => "LEFT", "conditions" => array("Calibradore.trabajadore_id = TrabajadoresCalibradore.id")),
				array( "table" =>"cargos", "alias" => "CargosCalibradore", "type" => "LEFT", "conditions" => array("TrabajadoresCalibradore.cargo_id = CargosCalibradore.id")),
				array( "table" =>"evaluaciones_trabajadores","alias" =>"EvaluacionesTrabajadore","type" => "LEFT","conditions" => array("EvaluacionesTrabajadore.trabajadore_id = Trabajadore.id")),
				),
			"conditions"=>array("Jefe.trabajadore_id" => $datosTrabajador["User"]["trabajadore_id"], 
				"Trabajadore.estado" => "Activo"),
			"recursive"=> 0
			));		
		$jefeEvaluador = array(
			"id" => $datosJefe["Trabajadore"]["id"],
			"nombre" => ucwords(mb_strtolower(strtok($datosJefe["Trabajadore"]["nombre"]," "), 'UTF-8')) ." ". ucwords(mb_strtolower($datosJefe["Trabajadore"]["apellido_paterno"], 'UTF-8')), 
			"cargo" => $serv->capitalize($datosJefe["Cargo"]["nombre"]),
			"evaluaciones_trabajadore_id" => (!empty($evaluaciones))? $datosJefe["EvaluacionesTrabajadore"]["id"]: null,		// usuario evaluado?
			"foto" => $this -> webroot . 'files' . DS . 'trabajadores' . DS . $datosJefe["Trabajadore"]["foto"] 
			);
		//calibrador
		$calibrador = array(
			"id" => $datosJefe["TrabajadoresCalibradore"]["id"],
			"nombre" => ucwords(mb_strtolower(strtok($datosJefe["TrabajadoresCalibradore"]["nombre"]," "), 'UTF-8')) ." ". ucwords(mb_strtolower($datosJefe["TrabajadoresCalibradore"]["apellido_paterno"], 'UTF-8')), 
			"cargo" => $serv->capitalize($datosJefe["CargosCalibradore"]["nombre"]),
			"foto" => $this -> webroot . 'files' . DS . 'trabajadores' . DS . $datosJefe["Trabajadore"]["foto"], 
			"email" => $datosJefe["TrabajadoresCalibradore"]["email"],
		);


		if(!empty($evaluaciones) || $datosJefe["Trabajadore"]["id"] == 110 || $datosJefe["Trabajadore"]["id"] == 111 || $datosJefe["Trabajadore"]["id"] == 403){	// usuario evaluado?
			// listado trabajadores
			$trabajadoresPorJefe = $this->Trabajadore->find("all", array(
				"fields"=>array( "Trabajadore.id", "EvaluacionesAnio.estado", "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.fecha_ingreso", "Trabajadore.estado", "Cargo.nombre", "CargosFamilia.nombre", "EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.fecha_inicio", "EvaluacionesTrabajadore.fecha_modificacion", "EvaluacionesTrabajadore.fecha_reunion", "EvaluacionesTrabajadore.lugar_reunion", "EvaluacionesTrabajadore.hora_reunion", "EvaluacionesTrabajadore.evaluaciones_estado_id", "EvaluacionesEstado.id", "EvaluacionesEstado.nombre"),
				"joins"=> array( array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),
					array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.trabajadore_id = Trabajadore.id AND CAST(EvaluacionesTrabajadore.anio AS VARCHAR) = '$anioActual'")),
					array("table" => "evaluaciones_estados", "alias" => "EvaluacionesEstado", "type" => "LEFT", "conditions" => array("EvaluacionesEstado.id = EvaluacionesTrabajadore.evaluaciones_estado_id")),
					array("table" => "evaluaciones_anios", "alias" => "EvaluacionesAnio", "type" => "LEFT", "conditions" => array("EvaluacionesAnio.id = EvaluacionesTrabajadore.evaluaciones_anio_id")),
					),
				"conditions"=>array(  
					"Trabajadore.id" => $this->trabajadoresAEvaluar(),
					"Trabajadore.jefe_id" => $datosJefe["Jefe"]["id"],
					"OR" => array(
						"AND" => array(
							array("EvaluacionesTrabajadore.evaluaciones_estado_id"=> array( 1 , 2 , 3 , 5 , 6 , 7 , 8 , 10 , 11 , 12 )),
							array("EvaluacionesAnio.estado"=> 1)				// actuales y por evaluar
							),
						array("EvaluacionesTrabajadore.evaluaciones_estado_id"=> null)
						)
					),
				"order"=>array("Trabajadore.fecha_ingreso ASC"),
				"recursive"=>0
				));
		}

		
		if(!empty($trabajadoresPorJefe)){
			foreach ($trabajadoresPorJefe as $trabajador) {
				$nombreCargo = '';
				$cargo = explode( " ", trim($trabajador["Cargo"]["nombre"]));
				foreach ($cargo as $value) 
					$nombreCargo.= (strlen($value)>2) ? ucwords( mb_strtolower($value, 'UTF-8') ).' ' : $value.' '; 

				$nombreFamiliaCargo = '';
				$familiaCargo = explode( " ", trim($trabajador["CargosFamilia"]["nombre"]));
				foreach ($familiaCargo as $value) 
					$nombreFamiliaCargo.= (strlen($value)>2) ? ucwords( mb_strtolower($value, 'UTF-8') ).' ' : $value.' ';

				$listaTrabajadores[] = array(
					"trabajador_id"			=> $trabajador["Trabajadore"]["id"],
					"nombre"				=> ucwords(mb_strtolower(strtok($trabajador["Trabajadore"]["nombre"]," "), 'UTF-8')) ." ". ucwords(mb_strtolower($trabajador["Trabajadore"]["apellido_paterno"], 'UTF-8')), 
					"cargo" 				=> $nombreCargo,
					"familia_cargo"			=> $nombreFamiliaCargo,
					"evaluacion_id"			=> $trabajador["EvaluacionesTrabajadore"]["id"],
					"estado_id"				=> $trabajador["EvaluacionesTrabajadore"]["evaluaciones_estado_id"],
					"estado"				=> (isset($trabajador["EvaluacionesEstado"]["nombre"]))? $trabajador["EvaluacionesEstado"]["nombre"]: 'No Iniciado',
					"fecha_inicio"			=> (isset($trabajador["EvaluacionesTrabajadore"]["fecha_inicio"]))? $trabajador["EvaluacionesTrabajadore"]["fecha_inicio"]: '-',
					"fecha_modificacion"	=> (isset($trabajador["EvaluacionesTrabajadore"]["fecha_modificacion"]))? $trabajador["EvaluacionesTrabajadore"]["fecha_modificacion"]:'-',
					"fecha_reunion"			=> (isset($trabajador["EvaluacionesTrabajadore"]["fecha_reunion"]))? $trabajador["EvaluacionesTrabajadore"]["fecha_reunion"]:'-',
					"hora_reunion"			=> (isset($trabajador["EvaluacionesTrabajadore"]["hora_reunion"]))? $trabajador["EvaluacionesTrabajadore"]["hora_reunion"]:'-',	
					);
			}

		}else{
			$listaTrabajadores = array();
		}
			
		$dataJefeEvaluador = array(
			"listaTrabajadores"	=> $listaTrabajadores, 
			"jefeEvaluador"		=> $jefeEvaluador, 
			"calibrador"		=> $calibrador, 
			"anio_evaluado"		=> $anioEvaluado["EvaluacionesAnio"]["anio_evaluado"],
			"usuario_evaluado" 	=> (!empty($evaluaciones))? 1: 0,
		);

		$this->set("evaluacionesPorJefe", $dataJefeEvaluador);
	}

	public function calibrar() {
		$this->layout = "angular";
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Calibrar Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

	public function listado_calibrador() {

		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("Trabajadore");
		$this->loadModel("Jefe");	
		$this->loadModel("EvaluacionesAnio");		
		$this->loadModel("User");
		$serv = new ServiciosController();

		$datosTrabajador = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
			"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
			));

		
		$evaluaciones = $this->EvaluacionesTrabajadore->find("first", array(
			"fields" => array("EvaluacionesTrabajadore.id"),
			"conditions"=>array("EvaluacionesTrabajadore.trabajadore_id"=> $datosTrabajador["User"]["trabajadore_id"],
				"EvaluacionesTrabajadore.evaluaciones_estado_id" => array(10, 11 ,12),									//finalizado?
				"EvaluacionesAnio.estado"=>1),
			"recursive"=>0
		));
		$datosJefe = $this->Jefe->find("first", array(
			"fields"=>array("Jefe.id", "Trabajadore.id", "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.cargo_id", "Trabajadore.foto", "Cargo.nombre", 
				"TrabajadoresCalibradore.id", "TrabajadoresCalibradore.nombre", "TrabajadoresCalibradore.apellido_paterno", "TrabajadoresCalibradore.cargo_id", "TrabajadoresCalibradore.foto", "TrabajadoresCalibradore.jefe_id", "TrabajadoresCalibradore.email", "CargosCalibradore.nombre", "EvaluacionesTrabajadore.id" ),
			"joins" => array( array( "table" => "cargos", "alias" => "Cargo", "type" => "LEFT", "conditions" => array("Trabajadore.cargo_id = Cargo.id")),
				array( "table" => "jefes", "alias" => "Calibradore", "type" => "LEFT", "conditions" => array("Trabajadore.jefe_id = Calibradore.id")),
				array( "table" => "trabajadores", "alias" => "TrabajadoresCalibradore", "type" => "LEFT", "conditions" => array("Calibradore.trabajadore_id = TrabajadoresCalibradore.id")),
				array( "table" => "cargos", "alias" => "CargosCalibradore", "type" => "LEFT", "conditions" => array("TrabajadoresCalibradore.cargo_id = CargosCalibradore.id")),
				array( "table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.trabajadore_id = Trabajadore.id")),
				array( "table" => "evaluaciones_anios", "alias" => "EvaluacionesAnio", "type" => "LEFT", "conditions" => array("EvaluacionesAnio.id = EvaluacionesTrabajadore.evaluaciones_anio_id")),
				),
			"conditions"=>array( array("Jefe.trabajadore_id" => $datosTrabajador["User"]["trabajadore_id"]),
				"OR" => array(
					array("Trabajadore.id"=>array(110,111)),
					array("EvaluacionesAnio.estado" => 1)
					),
				),
			"recursive"=> 0
			));
		//jefe
		if(!empty($datosJefe)){
			$calibrador = array(
				"id" => $datosJefe["Trabajadore"]["id"],
				"nombre" => $serv->capitalize(strtok($datosJefe["Trabajadore"]["nombre"]," ") ." ". $datosJefe["Trabajadore"]["apellido_paterno"]), 
				"cargo" => $serv->capitalize($datosJefe["Cargo"]["nombre"]),
				"evaluaciones_trabajadore_id" => (!empty($evaluaciones))?  $datosJefe["EvaluacionesTrabajadore"]["id"] : null,
				"foto" => $this -> webroot . 'files' . DS . 'trabajadores' . DS . $datosJefe["Trabajadore"]["foto"]
				);
		}else {
			$datosJefe = array();
			$calibrador = array();
		}			

		// listado trabajadores
		$TrabajadoresCalibradore = $this->Trabajadore->find("all", array(
			"fields"=>array( "Trabajadore.id", "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.fecha_ingreso",  "Cargo.nombre", "CargosFamilia.nombre", "EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.anio", 
				"EvaluacionesTrabajadore.fecha_inicio", "EvaluacionesTrabajadore.fecha_modificacion", "EvaluacionesEstado.nombre", "EvaluacionesTrabajadore.evaluaciones_estado_id",
				"EvaluadorTrabajadore.id", "EvaluadorTrabajadore.nombre", "EvaluadorTrabajadore.apellido_paterno"),
			"joins"=> array( array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.trabajadore_id = Trabajadore.id")),
				array("table" => "evaluaciones_estados", "alias" => "EvaluacionesEstado", "type" => "LEFT", "conditions" => array("EvaluacionesEstado.id = EvaluacionesTrabajadore.evaluaciones_estado_id")),
				array("table" => "cargos", "alias" => "Cargo", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.cargo_id = Cargo.id")),
				array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),
				array("table" => "trabajadores", "alias" => "EvaluadorTrabajadore", "type" => "LEFT", "conditions" => array("EvaluadorTrabajadore.id = EvaluacionesTrabajadore.evaluador_trabajadore_id")),
				),
			"conditions"=> array("EvaluacionesTrabajadore.validador_trabajadore_id" => $datosTrabajador["User"]["trabajadore_id"],	
				"EvaluacionesTrabajadore.evaluaciones_estado_id" => 4,
				"Trabajadore.id" => $this->trabajadoresAEvaluar()
				),
			"order"=> array("EvaluacionesTrabajadore.fecha_modificacion ASC"),
			"recursive"=>-1
			));
		
		if(!empty($TrabajadoresCalibradore)){
			foreach ($TrabajadoresCalibradore as $trabajador) {
				$listaTrabajadores[] = array(
					"trabajador_id"			=> $trabajador["Trabajadore"]["id"],
					"nombre"				=> ucwords(mb_strtolower(strtok($trabajador["Trabajadore"]["nombre"]," "), 'UTF-8')) ." ". ucwords(mb_strtolower($trabajador["Trabajadore"]["apellido_paterno"], 'UTF-8')), 
					"cargo" 				=> $serv->capitalize($trabajador["Cargo"]["nombre"]),
					"familia_cargo"			=> $serv->capitalize($trabajador["CargosFamilia"]["nombre"]),
					"evaluador"				=> $serv->capitalize(strtok($trabajador["EvaluadorTrabajadore"]["nombre"]," ") ." ". $trabajador["EvaluadorTrabajadore"]["apellido_paterno"]), 
					"evaluacion_id"			=> $trabajador["EvaluacionesTrabajadore"]["id"],
					"estado_id"				=> $trabajador["EvaluacionesTrabajadore"]["evaluaciones_estado_id"],
					"estado"				=> (isset($trabajador["EvaluacionesEstado"]["nombre"]))? $trabajador["EvaluacionesEstado"]["nombre"]: 'No Iniciado',
					"fecha_inicio"			=> (isset($trabajador["EvaluacionesTrabajadore"]["fecha_inicio"]))? $trabajador["EvaluacionesTrabajadore"]["fecha_inicio"]: '-',
					"fecha_modificacion"	=> (isset($trabajador["EvaluacionesTrabajadore"]["fecha_modificacion"]))? $trabajador["EvaluacionesTrabajadore"]["fecha_modificacion"]:'-',
					);
			}
		}else{
			$listaTrabajadores = array();
		}

		$anioEvaluado = $this->EvaluacionesAnio->find("first", array ( "fields"=>"anio_evaluado", "conditions"=>array("estado"=>1) ) );
		$listadoCalibrador = array(
			"listaTrabajadores"	=> $listaTrabajadores, 
			"calibrador"		=> $calibrador,  
			"anio_evaluado"		=> $anioEvaluado["EvaluacionesAnio"]["anio_evaluado"]
		);
		$this->set("listadoCalibrador", $listadoCalibrador);
	}

	public function desempeno(){
		$this->layout = "angular";

		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Listado Desempeño - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

	public function listado_desempeno(){
		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("Cargo");
		$this->loadModel("Trabajadore");
		$this->loadModel("EvaluacionesAnio");
		$this->loadModel("ObjetivosComentario");
		$this->loadModel("EvaluacionesObjetivo");
		$this->loadModel("EvaluacionesUnidadObjetivo");
		$this->loadModel("User");
		$serv = new ServiciosController();

		$anioEvaluado = $this->EvaluacionesAnio->find("first", array ( "fields"=>"anio_evaluado", "conditions"=>array("estado"=>1) ) );
		$anioAEvaluar = $this->EvaluacionesAnio->find("first", array ( "fields"=>"anio_evaluado", "conditions"=>array("evaluar"=>1) ) );

		$datosUser = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
			"conditions"=>array("User.id" =>  $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
		));

		$datosTrabajador = $this->Trabajadore->find("first", array( 
			"fields" => array( "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.apellido_materno" , "Trabajadore.foto", "Cargo.nombre"),
			"conditions"=> array("Trabajadore.id"=> $datosUser["User"]["trabajadore_id"]), //,				
			"recursive"=>0
		));
		$nombre_completo = strtok($datosTrabajador["Trabajadore"]["nombre"]," "). ' ' .$datosTrabajador["Trabajadore"]["apellido_paterno"];
		$trabajador = array_merge( $datosTrabajador["Trabajadore"],
			array( "nombre_completo" => $serv->capitalize($nombre_completo),
				"cargo" 	=> $serv->capitalize($datosTrabajador["Cargo"]["nombre"]),
				"foto"		=> $this -> webroot . 'files' . DS . 'trabajadores' . DS . $datosTrabajador["Trabajadore"]["foto"])
			);
		$evaluaciones = $this->EvaluacionesTrabajadore->find("all", array( 
			"fields" => array( "EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.anio", "EvaluacionesTrabajadore.evaluaciones_estado_id", 
				"EvaluacionesTrabajadore.puntaje_competencias", "EvaluacionesTrabajadore.puntaje_objetivos", "EvaluacionesTrabajadore.puntaje_ponderado", 
				"EvaluacionesTrabajadore.niveles_logro_id", "EvaluacionesTrabajadore.fecha_inicio ", "EvaluacionesAnio.anio_evaluado", "EvaluacionesAnio.estado",
				"JefeTrabajadore.nombre", "JefeTrabajadore.apellido_paterno", "NivelesLogro.nombre", "EvaluacionesEstado.nombre"
				),
			"joins"=> array( array("table" => "trabajadores", "alias" => "JefeTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.evaluador_trabajadore_id = JefeTrabajadore.id")) ),
			"conditions"=>array(
				array("Trabajadore.id"=> $datosUser["User"]["trabajadore_id"],
					"EvaluacionesTrabajadore.evaluaciones_estado_id" => array( 9 , 10, 11, 12 ) ) 		//** se incoporan estado 10 y 11 debido a la eliminacion de los pasos validada con observaciones y adjuntar documento
				),
			"order" => array("EvaluacionesTrabajadore.anio DESC"),
			"recursive"=>0
		));
		if(!empty($evaluaciones)){
			foreach ($evaluaciones as $evaluacion) {
				$listEvaluaciones[] = array_merge( $evaluacion["EvaluacionesTrabajadore"],
					array("nombre_jefatura" 	=> $serv->capitalize(strtok($evaluacion["JefeTrabajadore"]["nombre"], " "). " " .$evaluacion["JefeTrabajadore"]["apellido_paterno"]),
						"nivel_logro"			=> $evaluacion["NivelesLogro"]["nombre"],
						"estado_evaluacion"		=> $evaluacion["EvaluacionesEstado"]["nombre"],
						"anio_evaluado"			=> $evaluacion["EvaluacionesAnio"]["anio_evaluado"],
						"estado_actual"			=> ($evaluacion["EvaluacionesAnio"]["estado"]==1 && $evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]!=9 )? 1: 0,		//** 
						)
					);
			}
		}else{
			$listEvaluaciones = array();
		}
		
		//ocd
		$objetivos = $this->EvaluacionesTrabajadore->find("all", array(
			"fields" => array("EvaluacionesTrabajadore.id", "EvaluacionesObjetivo.id", "EvaluacionesObjetivo.descripcion_objetivo", "EvaluacionesObjetivo.porcentaje_ponderacion", "EvaluacionesObjetivo.indicador",
				"EvaluacionesObjetivo.evaluaciones_unidad_objetivo_id", "EvaluacionesObjetivo.fecha_limite_objetivo", "EvaluacionesObjetivo.fecha_limite_objetivo", "EvaluacionesObjetivo.objetivos_comentario_id",
				"EvaluacionesObjetivo.estado", "EvaluacionesObjetivo.evaluaciones_trabajadore_id", "EvaluacionesObjetivo.evaluaciones_objetivo_estado_id"),
			"joins"=> array( array("table" => "evaluaciones_objetivos", "alias" => "EvaluacionesObjetivo", "type" => "LEFT", "conditions" => array("EvaluacionesObjetivo.evaluaciones_trabajadore_id = EvaluacionesTrabajadore.id")) ),
			"conditions"=>array("EvaluacionesTrabajadore.anio"=>$anioAEvaluar["EvaluacionesAnio"]["anio_evaluado"],
				"EvaluacionesTrabajadore.trabajadore_id"=> $datosUser["User"]["trabajadore_id"],
				//"EvaluacionesObjetivo.estado" => 1,
				"EvaluacionesObjetivo.evaluaciones_objetivo_estado_id" => array(6,7)
				),
			"order" => "EvaluacionesObjetivo.id ASC",
			"recursive"=>-1,
			));
		$nombreOCD = $this->ObjetivosComentario->find("list", array("fields"=> array("ObjetivosComentario.id", "ObjetivosComentario.nombre")));
		$nombreUnidades = $this->EvaluacionesUnidadObjetivo->find("list", array("fields"=> array("EvaluacionesUnidadObjetivo.id", "EvaluacionesUnidadObjetivo.simbolo")));
		$listadoObjetivos = array();
		foreach ($objetivos as $ocd) {			
			$listadoObjetivos[] = array_merge( $ocd["EvaluacionesObjetivo"],
				array("nombre_objetivo" => $nombreOCD[$ocd["EvaluacionesObjetivo"]["objetivos_comentario_id"]],
				"simbolo_indicador" => $nombreUnidades[$ocd["EvaluacionesObjetivo"]["evaluaciones_unidad_objetivo_id"]])
				);
		}
	
		$listadoEvaluaciones = array("datosTrabajador"=>$trabajador,
			"listEvaluaciones"=>$listEvaluaciones,
			"anio_evaluado" => $anioEvaluado["EvaluacionesAnio"]["anio_evaluado"],
			"anio_evaluar" 	=> $anioAEvaluar["EvaluacionesAnio"]["anio_evaluado"],
			"listadoObjetivos" => $listadoObjetivos
			);
		
		$this->set("listadoDesempeno", $listadoEvaluaciones);
	}

	public function evaluaciones_actuales(){
		$this->layout = "angular";

		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Reviso Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

	/*public function evaluaciones_actuales_json(){

		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("EvaluacionesAnio");
		$this->loadModel("Trabajadore");
		$serv = new ServiciosController();
		$evaluacionesTrabajadores = $this->Trabajadore->find("all", array(
			"fields"=>array( "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.jefe_id", "Trabajadore.rut", "Cargo.nombre", "Gerencia.nombre",
				"EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.anio", "EvaluacionesTrabajadore.evaluaciones_estado_id", "Jefe.id", "Jefe.trabajadore_id", 
				"EvaluacionesTrabajadore.puntaje_competencias", "EvaluacionesTrabajadore.puntaje_objetivos", "EvaluacionesTrabajadore.puntaje_ponderado", 
				"EvaluacionesTrabajadore.niveles_logro_id", "EvaluacionesTrabajadore.fecha_inicio ", "EvaluacionesAnio.anio_evaluado", "EvaluacionesAnio.estado",
				"JefeTrabajadore.id","JefeTrabajadore.nombre", "JefeTrabajadore.apellido_paterno", "NivelesLogro.nombre", "EvaluacionesEstado.id", "EvaluacionesEstado.nombre"),
			"joins"=> array( array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),	
				array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
				array("table" => "trabajadores", "alias" => "JefeTrabajadore", "type" => "LEFT", "conditions" => array("Jefe.trabajadore_id = JefeTrabajadore.id")),
				array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.trabajadore_id = Trabajadore.id")),
				array("table" => "evaluaciones_estados", "alias" => "EvaluacionesEstado", "type" => "LEFT", "conditions" => array("EvaluacionesEstado.id = EvaluacionesTrabajadore.evaluaciones_estado_id")),
				array("table" => "evaluaciones_anios", "alias" => "EvaluacionesAnio", "type" => "LEFT", "conditions" => array("EvaluacionesAnio.id = EvaluacionesTrabajadore.evaluaciones_anio_id")),
				array("table" => "niveles_logros", "alias" => "NivelesLogro", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.niveles_logro_id = NivelesLogro.id")) ,
				),
			"conditions"=>array( array( 
				"Trabajadore.id" => $this->trabajadoresAEvaluar(),
				"OR" => array( array("EvaluacionesAnio.estado"=> 1),
					array("EvaluacionesTrabajadore.evaluaciones_estado_id"=> null)
					)
				)),
			"recursive"=>0
			));

		foreach ($evaluacionesTrabajadores as $evaluacion) {	
			$listadoActual[] = array(
				"id" => $evaluacion["EvaluacionesTrabajadore"]["id"],
				"nombre_trabajador" => $serv->capitalize(ucwords(strtok($evaluacion["Trabajadore"]["nombre"]," ") . ' ' .$evaluacion["Trabajadore"]["apellido_paterno"])),
				"cargo" => $serv->capitalize($evaluacion["Cargo"]["nombre"]),
				"rut" => $evaluacion["Trabajadore"]["rut"],
				"gerencia" => $serv->capitalize($evaluacion["Gerencia"]["nombre"]),
				"estado" => (isset($evaluacion["EvaluacionesEstado"]["nombre"])) ? $evaluacion["EvaluacionesEstado"]["nombre"]: 'No iniciado',
				"estado_id" => $evaluacion["EvaluacionesEstado"]["id"],
				"fecha_inicio" => (isset($evaluacion["EvaluacionesTrabajadore"]["fecha_inicio"]))? $evaluacion["EvaluacionesTrabajadore"]["fecha_inicio"] : '-',
				"nivel_logro" => (isset($evaluacion["NivelesLogro"]["nombre"])) ? $evaluacion["NivelesLogro"]["nombre"] : '-',
				"nombre_evaluador" => ucwords(strtok($evaluacion["JefeTrabajadore"]["nombre"]," ") . ' ' .$evaluacion["JefeTrabajadore"]["apellido_paterno"])
				);
		}

		if(!empty($listadoActual)) $listadoActual = $serv->sort_array_multidim($listadoActual,"gerencia DESC,nombre_evaluador ASC");	

		$anioEvaluado = $this->EvaluacionesAnio->find("first", array ( "fields"=>array("id","anio_evaluado"), "conditions"=>array("estado"=>1) ) );
		
		$datosListadoActual = array("anio_evaluado"=>$anioEvaluado["EvaluacionesAnio"]["anio_evaluado"],
			"listadoActual" => $listadoActual
			);

		$this->set("datosListadoActual", $datosListadoActual);
	}*/

	public function evaluaciones_alertas(){
		// todos los dias
		$this->layout = "ajax";
		$envioCorreo = '';

		$this->loadModel("EvaluacionesAnio");
		$this->loadModel("Trabajadore");
		$this->loadModel("Feriado");

		$evaluacionesTrabajadores = $this->Trabajadore->find("all", array(
			"fields"=>array( "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.jefe_id", "Trabajadore.email", "Cargo.nombre", "Gerencia.nombre",
				"EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.anio", "EvaluacionesTrabajadore.evaluaciones_estado_id", "Jefe.id", "Jefe.trabajadore_id", 
				"EvaluacionesTrabajadore.puntaje_competencias", "EvaluacionesTrabajadore.puntaje_objetivos", "EvaluacionesTrabajadore.puntaje_ponderado", 
				"EvaluacionesTrabajadore.niveles_logro_id", "EvaluacionesTrabajadore.fecha_inicio ", "EvaluacionesTrabajadore.fecha_modificacion", "EvaluacionesAnio.anio_evaluado", "EvaluacionesAnio.estado",
				"JefeTrabajadore.id","JefeTrabajadore.nombre", "JefeTrabajadore.apellido_paterno", "JefeTrabajadore.email", "NivelesLogro.nombre", "EvaluacionesEstado.id", "EvaluacionesEstado.nombre", "EvaluacionesEstado.dias_plazo",
				"CalibradorTrabajadore.nombre", "CalibradorTrabajadore.apellido_paterno", "CalibradorTrabajadore.email"),
			"joins"=> array( array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),				
				array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
				array("table" => "trabajadores", "alias" => "JefeTrabajadore", "type" => "LEFT", "conditions" => array("Jefe.trabajadore_id = JefeTrabajadore.id")),
				array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.trabajadore_id = Trabajadore.id")),
				array("table" => "evaluaciones_estados", "alias" => "EvaluacionesEstado", "type" => "LEFT", "conditions" => array("EvaluacionesEstado.id = EvaluacionesTrabajadore.evaluaciones_estado_id")),
				array("table" => "evaluaciones_anios", "alias" => "EvaluacionesAnio", "type" => "LEFT", "conditions" => array("EvaluacionesAnio.id = EvaluacionesTrabajadore.evaluaciones_anio_id")),
				array("table" => "niveles_logros", "alias" => "NivelesLogro", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.niveles_logro_id = NivelesLogro.id")) ,
				array("table" => "trabajadores", "alias" => "CalibradorTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.validador_trabajadore_id = CalibradorTrabajadore.id")),
				),
			"conditions"=> array( 
				"Trabajadore.id" => $this->trabajadoresAEvaluar(),
				"EvaluacionesAnio.estado" => 1,
				"EvaluacionesTrabajadore.evaluaciones_estado_id" => array( 4, 9 )
				),
			"order" => array("Gerencia.nombre DESC, JefeTrabajadore.nombre"),
			"recursive"=>0
			));
		
		if(!empty($evaluacionesTrabajadores))
		{
			foreach ($evaluacionesTrabajadores as $evaluacion) {
				
				$fechaModificacion = $evaluacion["EvaluacionesTrabajadore"]["fecha_modificacion"];
				$cantidadDias = $evaluacion["EvaluacionesEstado"]["dias_plazo"];
				if($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"] == 9) $cantidadDias = $cantidadDias + 1; // 1 dia posterior al plazo
				//feriados
				$diasFeriados = $this->Feriado->find("all", array("fields"=>"fecha","conditions"=> array("TO_CHAR(fecha,'YYYY')"=>date('Y')),"recursive"=>0));
				foreach ($diasFeriados as $fecha) {
					$feriados[] = $fecha["Feriado"]["fecha"];
				}
				$finDeSemana = array(6,0); 			// sabados, domingos
				$nuevaFecha = $fechaModificacion;	
				for ($i = 1; $i <= $cantidadDias;) {
					$nuevaFecha = date ( 'Y-m-d', strtotime ( '+1 day ' , strtotime ( $nuevaFecha ) ) );
					if( !in_array(date( 'w', strtotime($nuevaFecha) ) , $finDeSemana ) && !in_array($nuevaFecha, $feriados) ){ // si es fin de semana ni feriado salta el contador
						$i++;
					}
				}
				$fechaLimite = $nuevaFecha;
				//
				$envioCorreo = array();
				$nombreCargo = '';
				$cargo = explode( " ", trim($evaluacion["Cargo"]["nombre"]));
				foreach ($cargo as $value) {
					$nombreCargo.= (strlen($value)>2) ? ucwords( mb_strtolower($value, 'UTF-8') ).' ' : $value.' ';
				}
				//recordatorio calibracion
				if($fechaLimite == date('Y-m-d') && $evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"] == 4){
					$envioCorreo[] = array(	"email" 	=> $evaluacion["CalibradorTrabajadore"]["email"],
						"nombre" 		=> ucwords(strtok($evaluacion["CalibradorTrabajadore"]["nombre"], " ")),
						"apellido" 		=> ucwords(strtok($evaluacion["CalibradorTrabajadore"]["apellido_paterno"], " ")),
						"tipo" 			=> "alertas",
						"asunto" 		=> "Calibración de Desempeño " . ucwords(strtok($evaluacion["Trabajadore"]["nombre"], " ") ." ". $evaluacion["Trabajadore"]["apellido_paterno"]),
						"evaluacion" 	=> array_merge($evaluacion["Trabajadore"], 
							array("cargo"=> $nombreCargo,
								"jefatura"=> ucwords(strtok($evaluacion["JefeTrabajadore"]["nombre"], " ") ." ". $evaluacion["JefeTrabajadore"]["apellido_paterno"]), 
								)),	
						"fecha_limite" 	=> date("d-m-Y", strtotime($fechaLimite)),
					);
				}
				//validacion automatica
				if($fechaLimite == date('Y-m-d') && $evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"] == 9)
				{
					$evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"] = 12;
					$evaluacion["EvaluacionesTrabajadore"]["acepta_trabajador"] = 1;
					$evaluacion["EvaluacionesTrabajadore"]["comentario_trabajador"] = 'Validación automática generada por SGI.';
					$evaluacion["EvaluacionesTrabajadore"]["fecha_modificacion"] = date('Y-m-d');
					$this->request->data = $evaluacion;
					if($this->EvaluacionesTrabajadore->save($this->request->data)){
						CakeLog::write('actividad', 'Sistema validó evaluacion de desempeño. id '.$evaluacion["EvaluacionesTrabajadore"]["id"]);
						$envioCorreo[] = array(	"email"		=> $evaluacion["JefeTrabajadore"]["email"],
							"asunto" 					=> "Validación Evaluación de Desempeño " . ucwords(strtok($evaluacion["Trabajadore"]["nombre"], " ") ." ". $evaluacion["Trabajadore"]["apellido_paterno"]),
							"tipo" 						=> "validacion_automatica",
							"motivo"					=> "Validación automática generada por SGI.",
							"evaluador_nombre"			=> ucwords(strtok($evaluacion["JefeTrabajadore"]["nombre"], " ") ." ". $evaluacion["JefeTrabajadore"]["apellido_paterno"]), 
							"trabajador_nombre"			=> ucwords(strtok($evaluacion["Trabajadore"]["nombre"], " ") ." ". $evaluacion["Trabajadore"]["apellido_paterno"]),
							"trabajador_cargo"			=> $nombreCargo,
							"colaborador_comentarios"	=> $evaluacion["EvaluacionesTrabajadore"]["comentario_trabajador"],
							"estado"					=> 'sin',
							"anio_evaluacion"			=> $evaluacion["EvaluacionesAnio"]["anio_evaluado"]
						);
					}
				}

			}
			//envios
			if(!empty($envioCorreo)){
				foreach ($envioCorreo as $datosCorreo) {
					$Email = new CakeEmail("gmail");
					$Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
					$Email->to($datosCorreo["email"]); 
					$Email->subject($datosCorreo["asunto"]);
					$Email->emailFormat('html');
					if($datosCorreo["tipo"]=='alertas'){
						$Email->template('evaluacion_correo_alertas');
					}else if($datosCorreo["tipo"]=='validacion_automatica'){
						$Email->template('evaluacion_correo_validada');
					}
					$Email->viewVars(array(
						"datos"=>$datosCorreo,
					));
					$Email->send();
				}	
			}
		}
	}

/**
*	Los dias viernes se debe enviar notificacion a evaluadores 
*
*/
	public function evaluaciones_recordatorio(){
		// viernes 8:00am
		$this->layout = "ajax";
		$envioCorreo = '';
		$respuesta = '';

		$this->loadModel("EvaluacionesAnio");
		$this->loadModel("Trabajadore");
		$this->loadModel("Jefe");
		$this->loadModel("Feriado");

		$jefes = $this->Jefe->find("list", array(
			"fields" => array("Jefe.trabajadore_id"),
			"conditions" => array(
				"Jefe.estado" => 1,
				),
			));
		$evaluacionesJefes = $this->EvaluacionesTrabajadore->find("all", array(
			"fields" => array("EvaluacionesTrabajadore.id","EvaluacionesTrabajadore.fecha_modificacion", "Trabajadore.id", "Trabajadore.nombre","Trabajadore.email"),
			"conditions" => array("EvaluacionesTrabajadore.evaluaciones_estado_id >" => 9,
				"EvaluacionesAnio.estado" => 1,	
				"EvaluacionesTrabajadore.trabajadore_id" => $jefes
				),
			"recursive" => 0
			));
		
		$ggeneral = $this->Trabajadore->find("all", array(
			"fields"=>array("Trabajadore.id","Trabajadore.nombre","Trabajadore.email"),
			"conditions"=> array( 
				"Trabajadore.id" => $this->trabajadoresAEvaluar(),
				"Trabajadore.id" => array( 110,111 ),
				),
			"recursive" => 0
			));
		$jefesGG = array_merge($evaluacionesJefes, $ggeneral);
		
		//feriados
		$diasFeriados = $this->Feriado->find("all", array("fields"=>"fecha","conditions"=> array("TO_CHAR(fecha,'YYYY')"=>date('Y')),"recursive"=>0));
		foreach ($diasFeriados as $fecha) {
			$feriados[] = $fecha["Feriado"]["fecha"];
		}
		$viernes = array(5); 	// viernes
		$hoy = date("Y-m-d"); 	// hoy

		$trabajadoresSinEvaluar = array();
		if( in_array(date( 'w', strtotime($hoy) ) , $viernes ) && !in_array($hoy, $feriados) ){ // solo viernes	

			if(!empty($jefesGG)){
				foreach ($jefesGG as $jefe)
				{	
					if( $pos = array_search($jefe["Trabajadore"]["id"], $jefes) ){
						
						$jefesANotificar[$pos] = array("id" => $pos,
							"fecha_modificacion" => (isset($jefe["EvaluacionesTrabajadore"]["fecha_modificacion"]))? $jefe["EvaluacionesTrabajadore"]["fecha_modificacion"]:'',
							"nombre" => strtok($jefe["Trabajadore"]["nombre"], " "),
							"email" => $jefe["Trabajadore"]["email"],
							);
						$jefesANotificarId[] = $pos;
					}
				}
				
				$trabajadoresSinEvaluar = $this->Trabajadore->find("all", array(
					"fields" => array("Trabajadore.nombre", "Trabajadore.apellido_paterno",  "Trabajadore.jefe_id", "EvaluacionesTrabajadore.id"),
					"joins" => array( array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.trabajadore_id = Trabajadore.id"))
						),
					"conditions" => array( "Trabajadore.jefe_id" => $jefesANotificarId,
						"Trabajadore.id" => $this->trabajadoresAEvaluar(),
						"EvaluacionesTrabajadore.id" => null
						),
					"recursive"=> -1
					));
				$jefeNoficar = '';
				foreach($jefesANotificar as $key => $dataJefe) {
					$jefeNoficar[$key] = $dataJefe;
					foreach ($trabajadoresSinEvaluar as $trabajador) {
						if( $dataJefe["id"]==$trabajador["Trabajadore"]["jefe_id"] )
							$jefeNoficar[$key]["Trabajadore"][] = strtok($trabajador["Trabajadore"]["nombre"], " "). ' '. $trabajador["Trabajadore"]["apellido_paterno"];
					}
				}
				
				if(!empty($jefeNoficar)){
					foreach ($jefeNoficar as $datosCorreo) {	
						if(array_key_exists("Trabajadore",$datosCorreo)){
							$Email = new CakeEmail("gmail");
							$Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
							$Email->to($datosCorreo["email"]); 
							$Email->subject("Recordatorio Evaluación de Desempeño");  
							$Email->emailFormat('html');				
							$Email->template('evaluacion_correo_recordatorio');					
							$Email->viewVars(array(
								"datos"=>$datosCorreo,
							));
							$Email->send();
						}	
					}
				}
			}
		}
		$this->set("respuesta",$respuesta);
	}

	/*public function evaluaciones_final(){
		$this->layout = "angular";

		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Reviso Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}*/

	public function evaluaciones_final_json($anio=null){
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("EvaluacionesAnio");
		$this->loadModel("Trabajadore");
		$this->loadModel("NivelesLogro");

		$serv = new ServiciosController();
		$listadoAnios = array();
		$anioActual = date("Y");
		$nivelLogro = $this->NivelesLogro->find("all", array( "conditions"=>array("evaluaciones_tipo_id"=>4,"estado"=>1), "recursive" => -1 ) );
		foreach ($nivelLogro as $nivel) {
			$niveles[] = $nivel["NivelesLogro"];
		}
		$anioEvaluado = $this->EvaluacionesAnio->find("all", array( "conditions"=>array("evaluar"=>1) ));		
		foreach ($anioEvaluado as $anios){
			if($anios["EvaluacionesAnio"]["estado"]==1 && !$anio)
				$anio = $anios["EvaluacionesAnio"]["anio_evaluado"];
			if($anios["EvaluacionesAnio"]["anio_evaluado"]<$anioActual)
			$listadoAnios[] = $anios["EvaluacionesAnio"];
		}
		$evaluacionesTrabajadores = $this->Trabajadore->find("all", array( 
			"fields" => array("EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.puntaje_ponderado", "EvaluacionesTrabajadore.puntaje_objetivos", "EvaluacionesTrabajadore.puntaje_competencias", 
				"EvaluacionesTrabajadore.evaluaciones_estado_id", "EvaluacionesTrabajadore.trabajadore_id", "EvaluacionesTrabajadore.evaluador_trabajadore_id", 
				"EvaluacionesTrabajadore.cargo_id", "EvaluacionesTrabajadore.gerencia_id", "EvaluacionesTrabajadore.niveles_logro_id", "EvaluacionesTrabajadore.acepta_trabajador",
				"Trabajadore.*", "CargoEv.nombre", "GerenciaEv.nombre", "NivelResponsabilidadEv.nivel", "NivelesLogro.nombre", "EvaluacionesEstado.nombre", "EvaluacionesEstado.id",
				 "Evaluadore.apellido_paterno", "CargosFamiliaEv.nombre", //"Calibradore.nombre", "Calibradore.apellido_paterno",
				"Cargo.*","Jefatura.nombre","Jefatura.apellido_paterno", "Gerencia.nombre", "CargosFamilia.nombre", "NivelResponsabilidad.nivel"
				),
			"conditions" => array(
				"Trabajadore.id" => $this->trabajadoresAEvaluar(($anio+1).'-01-01'),			
				),
				"joins" => array( array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("Trabajadore.id = EvaluacionesTrabajadore.trabajadore_id AND EvaluacionesTrabajadore.anio = '$anio'")),	
					array("table" => "trabajadores", "alias" => "Evaluadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.evaluador_trabajadore_id = Evaluadore.id")),	
					array("table" => "trabajadores", "alias" => "Jefatura", "type" => "LEFT", "conditions" => array("Jefe.trabajadore_id = Jefatura.id")),	
					array("table" => "cargos", "alias" => "CargoEv", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.cargo_id = CargoEv.id")),	
					array("table" => "gerencias", "alias" => "GerenciaEv", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.gerencia_id = GerenciaEv.id")),	
					array("table" => "cargos_nivel_responsabilidades", "alias" => "NivelResponsabilidadEv", "type" => "LEFT", "conditions" => array("CargoEv.cargos_nivel_responsabilidade_id = NivelResponsabilidadEv.id")),	
					array("table" => "cargos_familias", "alias" => "CargosFamiliaEv", "type" => "LEFT", "conditions" => array("CargoEv.cargos_familia_id = CargosFamiliaEv.id")),	
					array("table" => "niveles_logros", "alias" => "NivelesLogro", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.niveles_logro_id = NivelesLogro.id")),	
					array("table" => "evaluaciones_estados", "alias" => "EvaluacionesEstado", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.evaluaciones_estado_id = EvaluacionesEstado.id")),	
					array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
					array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
					array("table" => "cargos_nivel_responsabilidades", "alias" => "NivelResponsabilidad", "type" => "LEFT", "conditions" => array("Cargo.cargos_nivel_responsabilidade_id = NivelResponsabilidad.id")),	
					array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),	
				),
			"recursive"=>0
			));
		
		$listadoFinal = array();
		$antiguedadHasta = new DateTime($anio."-12-31");
		foreach ($evaluacionesTrabajadores as $evaluacion) {			
			$ingreso = new DateTime($evaluacion["Trabajadore"]["fecha_indefinido"]);
			$diferencia = $antiguedadHasta->diff($ingreso);
			$antiguedad = round($diferencia->days/365,3);
			//ponderado 75 / 25
			$puntaje_75 = floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_objetivos"])*.75 + floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_competencias"])*.25;
			$puntaje_75 = round($puntaje_75,2);
			foreach($niveles as $nivel) 
				if(($puntaje_75 >= $nivel["rango_inicio"]) && ($puntaje_75 <= $nivel["rango_termino"]) )
					$porcBono = intval($nivel["nombre"]);

			$cargo 				= (isset($evaluacion["CargoEv"]["nombre"]))? $evaluacion["CargoEv"]["nombre"] : $evaluacion["Cargo"]["nombre"];
			$gerencia 			= (isset($evaluacion["GerenciaEv"]["nombre"]))? $evaluacion["GerenciaEv"]["nombre"] : $evaluacion["Gerencia"]["nombre"];
			$jefatura 			= (isset($evaluacion["Evaluadore"]["nombre"]))? strtok($evaluacion["Evaluadore"]["nombre"]," ") .' ' . $evaluacion["Evaluadore"]["apellido_paterno"] : strtok($evaluacion["Jefatura"]["nombre"]," ") .' ' . $evaluacion["Jefatura"]["apellido_paterno"];
			$familia 			= (isset($evaluacion["CargosFamiliaEv"]["nombre"]))? $evaluacion["CargosFamiliaEv"]["nombre"] : $evaluacion["CargosFamilia"]["nombre"];
			$estado 			= (isset($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]))? $evaluacion["EvaluacionesEstado"]["nombre"] : "No Iniciado";

			$listadoFinal[] = array( 
					"id" => $evaluacion["EvaluacionesTrabajadore"]["id"],
					"rut_trabajador" => $evaluacion["Trabajadore"]["rut"],
					"nombre_trabajador" => $serv->capitalize(strtok($evaluacion["Trabajadore"]["nombre"]," ") .' ' . $evaluacion["Trabajadore"]["apellido_paterno"]), 	
					"fecha_indefinido" => $evaluacion["Trabajadore"]["fecha_indefinido"],
					"antiguedad" => $antiguedad,
					"cargo" => $serv->capitalize($cargo), 				
					"gerencia" => $serv->capitalize($gerencia), 
					"jefatura" => $serv->capitalize($jefatura), 		
					"familia_cargo" => $serv->capitalize($familia),
					"nivel_responsabilidad" => floatval($evaluacion["NivelResponsabilidad"]["nivel"]),
					"puntaje_ocd" => floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_objetivos"]),
					"puntaje_competencias" => floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_competencias"]),
					"puntaje_ponderado_50" => floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_ponderado"]),
					"situacion_desempeno" => (isset($evaluacion["NivelesLogro"]["nombre"]))? $evaluacion["NivelesLogro"]["nombre"] : '-',
					"acepta_trabajador" => ($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]> 9)? (($evaluacion["EvaluacionesTrabajadore"]["acepta_trabajador"])? 'Si' : 'No') : '-',
					"estado" => $estado, 
					"estado_id" => $evaluacion["EvaluacionesEstado"]["id"], 
					"puntaje_ponderado_75" => floatval($puntaje_75),
					"porcentaje_bono" => $porcBono
				);
		}

		if(!empty($listadoFinal)) $listadoFinal = $serv->sort_array_multidim($listadoFinal,"gerencia DESC,jefatura ASC");		

		$datosFinal = array("anio_evaluado"=>$anio,
			"listadoFinal" => $listadoFinal,
			"listadoAnios" => $listadoAnios,
			"antiguedad_hasta" => $antiguedadHasta
			);

		$this->set("listadoFinal", $datosFinal);
	}
	
	public function evaluaciones_graficos(){
		$this->layout = "angular";
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Graficos EvaluacionesTrabajadores' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

	public function evaluaciones_graficos_json(){
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("EvaluacionesAnio");
		$this->loadModel("Trabajadore");
		$this->loadModel("NivelesLogro");
		$this->loadModel("Cargo");
		$this->loadModel("CargosFamilia");
		$this->loadModel("CargosNivelResponsabilidade");
		$anio = null;

		if(isset($this->request->data["anioEvaluacion"])){
			if($this->request->data["anioEvaluacion"]>0)
				$anio = $this->request->data["anioEvaluacion"];
		}else{
			$anio = null;
		}
		$serv = new ServiciosController();
		$listadoAnios = array();
		$anioActual = date("Y");
		$anioEvaluado = $this->EvaluacionesAnio->find("all", array( "conditions"=>array("evaluar"=>1) ));		
		foreach ($anioEvaluado as $anios){
			if($anios["EvaluacionesAnio"]["estado"]==1 && !$anio)
				$anio = $anios["EvaluacionesAnio"]["anio_evaluado"];
			if($anios["EvaluacionesAnio"]["anio_evaluado"]<$anioActual)
				$listadoAnios[] = $anios["EvaluacionesAnio"];
		}

		$evaluacionesTrabajadores = $this->Trabajadore->find("all", array( 
			"fields" => array("EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.puntaje_ponderado", "EvaluacionesTrabajadore.puntaje_objetivos", "EvaluacionesTrabajadore.puntaje_competencias", 
				"EvaluacionesTrabajadore.evaluaciones_estado_id", "EvaluacionesTrabajadore.trabajadore_id", "EvaluacionesTrabajadore.evaluador_trabajadore_id", 
				"EvaluacionesTrabajadore.cargo_id", "EvaluacionesTrabajadore.gerencia_id", "EvaluacionesTrabajadore.niveles_logro_id", "EvaluacionesTrabajadore.acepta_trabajador",
				"Trabajadore.*", "CargoEv.nombre", "GerenciaEv.nombre", "NivelResponsabilidadEv.nivel", "NivelesLogro.nombre", "NivelesLogro.secuencia", "EvaluacionesEstado.nombre", "EvaluacionesEstado.id",
				 "Evaluadore.apellido_paterno", "CargosFamiliaEv.id", "CargosFamiliaEv.nombre", //"Calibradore.nombre", "Calibradore.apellido_paterno",
				 "Cargo.*","Jefatura.nombre","Jefatura.apellido_paterno", "Gerencia.nombre", "CargosFamilia.nombre", "NivelResponsabilidad.nivel"
				 ),
			"conditions" => array(
				"Trabajadore.id" => $this->trabajadoresAEvaluar(($anio+1).'-01-01'),
				"Trabajadore.id not" => array(111,110)
				),
			"joins" => array( array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("Trabajadore.id = EvaluacionesTrabajadore.trabajadore_id AND EvaluacionesTrabajadore.anio = '$anio'")),	
				array("table" => "trabajadores", "alias" => "Evaluadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.evaluador_trabajadore_id = Evaluadore.id")),	
				array("table" => "trabajadores", "alias" => "Jefatura", "type" => "LEFT", "conditions" => array("Jefe.trabajadore_id = Jefatura.id")),	
				array("table" => "cargos", "alias" => "CargoEv", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.cargo_id = CargoEv.id")),	
				array("table" => "gerencias", "alias" => "GerenciaEv", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.gerencia_id = GerenciaEv.id")),	
				array("table" => "cargos_nivel_responsabilidades", "alias" => "NivelResponsabilidadEv", "type" => "LEFT", "conditions" => array("CargoEv.cargos_nivel_responsabilidade_id = NivelResponsabilidadEv.id")),	
				array("table" => "cargos_familias", "alias" => "CargosFamiliaEv", "type" => "LEFT", "conditions" => array("CargoEv.cargos_familia_id = CargosFamiliaEv.id")),	
				array("table" => "niveles_logros", "alias" => "NivelesLogro", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.niveles_logro_id = NivelesLogro.id")),	
				array("table" => "evaluaciones_estados", "alias" => "EvaluacionesEstado", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.evaluaciones_estado_id = EvaluacionesEstado.id")),	
				array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
				array("table" => "cargos_nivel_responsabilidades", "alias" => "NivelResponsabilidad", "type" => "LEFT", "conditions" => array("Cargo.cargos_nivel_responsabilidade_id = NivelResponsabilidad.id")),	
				array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),	
				),
			"recursive"=>0
			));
		$nivelLogro = $this->NivelesLogro->find("all", array(
			"fields" => array("NivelesLogro.id", "NivelesLogro.nombre", "NivelesLogro.rango_inicio", "NivelesLogro.rango_termino", "NivelesLogro.secuencia"),
			"conditions"=>array(
				"evaluaciones_tipo_id"=>3,
				"estado"=>1),
			"order" => "NivelesLogro.secuencia",
			"recursive" => -1) 
		);
		$this->CargosFamilia->Behaviors->attach('Containable');
		$this->CargosFamilia->contain( array( "CargosNivelResponsabilidade" => array( 
			"fields" => "CargosNivelResponsabilidade.nivel", 
			"order" => "CargosNivelResponsabilidade.nivel ASC"
			))
		);
		$cargosNR = $this->CargosFamilia->find("all", array(
			"fields" => array("CargosFamilia.id", "CargosFamilia.nombre"),
			"conditions"=> array("CargosFamilia.estado" => 1),
			"order" => array("CargosFamilia.id DESC"),
			"recursive" => 1) 
		);
		$responsabilidad = $this->CargosNivelResponsabilidade->find("list", array(
			"fields" => array("CargosNivelResponsabilidade.id", "CargosNivelResponsabilidade.nivel"),
			"order" => "CargosNivelResponsabilidade.nivel ASC",
			"conditions"=> array("CargosNivelResponsabilidade.nivel >" => 0),
			"recursive" => -1) 
		);
		
		$cumplimientoSeries = $this->grafico_cumplimiento($evaluacionesTrabajadores);
		$famCargoSeries = $this->grafico_familia_cargo($evaluacionesTrabajadores);
		$sitDesempenoSeries = $this->grafico_situacion_desempeno($evaluacionesTrabajadores, $nivelLogro);
		$sitCompetenciasSeries = $this->grafico_desempeno_competencias($evaluacionesTrabajadores, $nivelLogro);
		$barraComparativo = $this->grafico_comparacion_desempeno($evaluacionesTrabajadores, $nivelLogro);
		$barraComparativoGerencias = $this->grafico_comparacion_gerencias($evaluacionesTrabajadores);
		$distribucion = $this->grafico_nivel_responsabilidad($evaluacionesTrabajadores, $nivelLogro, $cargosNR, $responsabilidad);
		$distribucionCompetencias = $this->grafico_nivel_competencias($evaluacionesTrabajadores, $responsabilidad);
		$compXNivel = $this->grafico_comportamiento($evaluacionesTrabajadores, $cargosNR, $responsabilidad);

		$dataGraficos = array(
			"cumplimientoSeries" => $cumplimientoSeries,
			"famCargoSeries" => $famCargoSeries,
			"sitDesempenoSeries" => $sitDesempenoSeries,
			"sitCompetenciasSeries" => $sitCompetenciasSeries,
			"barraComparativo" => $barraComparativo,
			"barraComparativoGerencias" => $barraComparativoGerencias,
			"distribucion" => $distribucion,
			"distribucionCompetencias" => $distribucionCompetencias,
			"compXNivel" => $compXNivel,
			"listadoAnios" => $listadoAnios,
			"estado" => (!empty($evaluacionesTrabajadores))? 1: 0,
			"mensaje" => (!empty($evaluacionesTrabajadores))? "": "No existen evaluaciones, intentelo nuevamente."
			);

		$this->set("dataGraficos", $dataGraficos);
	}

	public function grafico_cumplimiento($evaluaciones){
		$totalEvaluaciones = count($evaluaciones);
		$totalEvFinalizadas = 0;
		foreach ($evaluaciones as $evaluacion){
			if(isset($evaluacion["EvaluacionesTrabajadore"]["id"])){
				if($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]>9){
					// torta 1
					$totalEvFinalizadas++;
					$puntajesGlobal[] = floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_ponderado"]);
					$puntajesCompet[] = $evaluacion["EvaluacionesTrabajadore"]["puntaje_competencias"];					
				}
			}
		}
		$promGlobal = round( array_sum($puntajesGlobal)/count($puntajesGlobal) , 2);
		$promCompet = round( array_sum($puntajesCompet)/count($puntajesCompet) , 2);
		$porcentajeEvaluados = round(($totalEvFinalizadas/$totalEvaluaciones) * 100 , 1);
		$porcentajeNoEvaluados = 100-$porcentajeEvaluados;
		$cumplimiento = array(
			array( "nombre"=>"Colaboradores Evaluados",
				"valor"=> $porcentajeEvaluados
				),
			array( "nombre"=>"Colaboradores No Evaluados",
				"valor"=> $porcentajeNoEvaluados
				)
			);
		$puntajeGlobal = array("desempeno"=>$promGlobal,
			"competencias"=>$promCompet);
		$cumplimientoSeries = array( "series"=> $cumplimiento,
			"puntajeGlobal"=>$puntajeGlobal			
			);
		return $cumplimientoSeries;
	}

	public function grafico_familia_cargo($evaluaciones){
		$totalEvFinalizadas = 0;
		foreach ($evaluaciones as $evaluacion){
			if(isset($evaluacion["EvaluacionesTrabajadore"]["id"])){
				if($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]>9){
					$totalEvFinalizadas++;				
					$famCargoEvaluados[] = $evaluacion["CargosFamiliaEv"]["nombre"];
				}
			}
		}
		$arrayFamiliaCargo = array_count_values($famCargoEvaluados);
		foreach ($arrayFamiliaCargo as $nombre => $famCargo){
			$porcFamCargo = floatval(round( ($famCargo/$totalEvFinalizadas)* 100 ,1));			
			$dataFamCargo[] = array($nombre,$porcFamCargo);
			$valoresFamCargo[] = array( 
				"nombre"=>$nombre,
				"valor" =>$famCargo
				);
		}
		$famCargoSeries = array(			
			"data" => $dataFamCargo,
			"valores"=>$valoresFamCargo
		);		
		return $famCargoSeries;
	}

	public function grafico_situacion_desempeno($evaluaciones, $nivelLogro){
		foreach ($nivelLogro as $nivel) {
			$nivelCategorias[$nivel["NivelesLogro"]["secuencia"]] = $nivel["NivelesLogro"]["nombre"];
		}
		$totalEvFinalizadas = 0;		
		foreach ($evaluaciones as $evaluacion){
			if(isset($evaluacion["EvaluacionesTrabajadore"]["id"])){
				if($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]>9){
					$totalEvFinalizadas++;
					$sitDesempenoEvaluados[] = $evaluacion["NivelesLogro"]["nombre"];
				}
			}
		}
		ksort($nivelCategorias);
		foreach ($nivelCategorias as $categoria) {
			$ordenNiveles[$categoria] = null;
		}
		$arraySitDesempeno = array_merge($ordenNiveles, array_count_values($sitDesempenoEvaluados));				
		foreach ($arraySitDesempeno as $nombre => $sitDesempeno) {
			$porcSitDesempeno = floatval(round( ($sitDesempeno/$totalEvFinalizadas)* 100 ,1));						
			$dataSitDesempeno[] = array($nombre,$porcSitDesempeno);
			$valoresSitDesempeno[] = array( 
				"nombre" => $nombre,
				"desempeno" =>$sitDesempeno
				);
		}

		return $sitDesempenoSeries = array(
			"data" => $dataSitDesempeno,
			"situacion_desempeno" => $valoresSitDesempeno
		);			
	}

	public function grafico_desempeno_competencias($evaluaciones, $nivelLogro){
		foreach ($nivelLogro as $nivel) {
			$niveles[] = $nivel["NivelesLogro"];
			$nivelCategorias[$nivel["NivelesLogro"]["secuencia"]] = $nivel["NivelesLogro"]["nombre"];
		}
		$totalEvFinalizadas = 0;
		foreach ($evaluaciones as $evaluacion){
			if(isset($evaluacion["EvaluacionesTrabajadore"]["id"])){
				if($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]>9){
					$totalEvFinalizadas++;	
					foreach ($niveles as $nivel){
						if($evaluacion["EvaluacionesTrabajadore"]["puntaje_competencias"]>=$nivel["rango_inicio"] && $evaluacion["EvaluacionesTrabajadore"]["puntaje_competencias"]<=$nivel["rango_termino"]){							
							$sitDesempenoCompentecias[] = $nivel["nombre"];
						}
					}
				}
			}
		}
		foreach ($nivelCategorias as $categoria) {
			$ordenNiveles[$categoria] = null;
		}
		$arraySitDesempenoCompentencias = array_merge($ordenNiveles, array_count_values($sitDesempenoCompentecias));	
		foreach ($arraySitDesempenoCompentencias as $nombre => $sitCompentencias) {
			$porcSitCompetencias = floatval(round( ($sitCompentencias/$totalEvFinalizadas)* 100 ,1));			
			$dataSitCompetencias[] = array($nombre, $porcSitCompetencias);
			$valoresSitCompetencias[] = array( 
				"nombre" => $nombre,
				"desem_compentencia" => $sitCompentencias
				);
		}
		return $sitCompetenciasSeries = array(			
			"data" => $dataSitCompetencias,
			"situacion_competencias" => $valoresSitCompetencias
		);
	}

	public function grafico_comparacion_desempeno($evaluaciones, $nivelLogro){
		foreach ($nivelLogro as $nivel) {
			$niveles[] = $nivel["NivelesLogro"];
			$nivelesSecuencia[$nivel["NivelesLogro"]["nombre"]] = $nivel["NivelesLogro"]["secuencia"];
			$nivelCategorias[$nivel["NivelesLogro"]["secuencia"]] = $nivel["NivelesLogro"]["nombre"];
		}
		$totalEvFinalizadas = 0;
		foreach ($evaluaciones as $evaluacion){
			if(isset($evaluacion["EvaluacionesTrabajadore"]["id"])){
				if($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]>9){
					$totalEvFinalizadas++;	
					$sitDesempenoEvaluados[] = $evaluacion["NivelesLogro"]["nombre"];
					foreach ($niveles as $nivel){
						if($evaluacion["EvaluacionesTrabajadore"]["puntaje_competencias"]>=$nivel["rango_inicio"] && $evaluacion["EvaluacionesTrabajadore"]["puntaje_competencias"]<=$nivel["rango_termino"]){							
							$sitDesempenoCompentecias[] = $nivel["nombre"];
						}
					}
				}
			}
		}
		foreach ($nivelCategorias as $categoria) {
			$ordenNiveles[$categoria] = null;
		}	
		$arraySitDesempeno = array_merge($ordenNiveles, array_count_values($sitDesempenoEvaluados));				
		foreach ($arraySitDesempeno as $nombre => $sitDesempeno) {
			$porcSitDesempeno = floatval(round( ($sitDesempeno/$totalEvFinalizadas)* 100 ,1));						
			$barraSitDesempeno[$nivelesSecuencia[$nombre]] = $porcSitDesempeno;
		}
		$arraySitDesempenoCompentencias = array_merge($ordenNiveles, array_count_values($sitDesempenoCompentecias));	
		foreach ($arraySitDesempenoCompentencias as $nombre => $sitCompentencias) {
			$porcSitCompetencias = floatval(round( ($sitCompentencias/$totalEvFinalizadas)* 100 ,1));			
			$barraSitCompetencias[$nivelesSecuencia[$nombre]] = $porcSitCompetencias;
		}
		ksort($nivelCategorias);		
		$categorias = explode(",",implode(",",$nivelCategorias));
		ksort($barraSitDesempeno);
		ksort($barraSitCompetencias);		
		$comparativoDesempenoSeries = array( 
			array( "name"=> "Desempeño CDF",
				"data"=> array_map('floatval',explode(",", implode(",",$barraSitDesempeno)))
				),
			array( "name"=> "Desempeño Competencias",
				"data"=> array_map('floatval',explode(",", implode(",",$barraSitCompetencias)))
				)
			);
		return $barraComparativo = array(
			"xAxis"=> $categorias,
			"series" => $comparativoDesempenoSeries
			);		
	}

	public function grafico_comparacion_gerencias($evaluaciones){
		$serv = new ServiciosController();	
		$tablaNivelLogro = $this->NivelesLogro->find("all", array(
			"fields" => array("NivelesLogro.id", "NivelesLogro.evaluaciones_tipo_id", "NivelesLogro.nombre", "NivelesLogro.rango_inicio", "NivelesLogro.rango_termino", "NivelesLogro.secuencia"),
			"conditions"=>array(
				"evaluaciones_tipo_id"=>array(3,4),
				"estado"=>1),
			"order" => "NivelesLogro.secuencia",
			"recursive" => -1) 
		);
		foreach ($tablaNivelLogro as $nivelesValores) {
			switch ($nivelesValores["NivelesLogro"]["evaluaciones_tipo_id"]) {
			    case 3:
			        $nombreNivel[$nivelesValores["NivelesLogro"]["evaluaciones_tipo_id"]] = "PuntajePonderado";
			        break;
			    case 4:
			    	$nombreNivel[$nivelesValores["NivelesLogro"]["evaluaciones_tipo_id"]] = "PorcentajeBono";
			        break;
			} 
			$tablaValores[$nombreNivel[$nivelesValores["NivelesLogro"]["evaluaciones_tipo_id"]]][] = $nivelesValores["NivelesLogro"];
		}
		foreach ($evaluaciones as $evaluacion){
			if(isset($evaluacion["EvaluacionesTrabajadore"]["id"])){
				if($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]>9){					
					$desempenoXGerencia[$evaluacion["GerenciaEv"]["nombre"]][] = array(
						"desempeno"=>floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_ponderado"]),
						"competencias"=>$evaluacion["EvaluacionesTrabajadore"]["puntaje_competencias"],
						);
					}
				}
			}
		ksort($desempenoXGerencia);
		foreach ($desempenoXGerencia as $key => $puntajes){
			$nombreTable[] = array(
				"name"=> (string)count($puntajes),
				"categories"=> array($serv->capitalize($key))
				);
			$situacionXGerencia[] = round( array_sum(array_map(function($item) { return $item['desempeno']; }, $puntajes)) /count($puntajes) ,2);
			$competenciaXGerencia[] = round( array_sum(array_map(function($item) { return $item['competencias']; }, $puntajes)) /count($puntajes) ,2);
		}
		$comparativoXGerenciaSeries = array(
			array( "name"=> "SITUACIÓN DESEMPEÑO",
				"data" => $situacionXGerencia
				),
			array( "name"=> "COMPETENCIAS",
				"data" => $competenciaXGerencia
				)
			);
		$minSituacion = min($situacionXGerencia);
		$minCompetencia = min($competenciaXGerencia);
		$minXGerencia = ($minSituacion<$minCompetencia)? $minSituacion : $minCompetencia;		

		return $barraComparativoGerencias = array(
			"xAxis"=>$nombreTable,
			"series" => $comparativoXGerenciaSeries,
			"tablaValores" => $tablaValores,
			"yMin"=> round($minXGerencia,-1)-5
			);
	}

	public function grafico_nivel_responsabilidad($evaluaciones, $nivelLogro, $familiasCargos, $responsabilidad){
		foreach ($evaluaciones as $evaluacion){
			if(isset($evaluacion["EvaluacionesTrabajadore"]["id"])){
				if($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]>9){					
					$dataDistribucion[] = array(
						$evaluacion["NivelResponsabilidad"]["nivel"],
						floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_ponderado"])
						);
					$puntajesPonderado[] = floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_ponderado"]);
				}
			}
		}
		foreach ($nivelLogro as $nivel) {
			$nivelSituacion[$nivel["NivelesLogro"]["rango_inicio"]] = $nivel["NivelesLogro"]["nombre"];
		}
		foreach ($familiasCargos as $cargoNR) {
			$cargosFamilia = array();
			foreach ($cargoNR["CargosNivelResponsabilidade"] as $nivelV){
				$cargosFamilia[] = $nivelV["nivel"];
			}
			$responsabilidadCargos[] = array(
				"name"=> $cargoNR["CargosFamilia"]["nombre"],
				"categories"=> $cargosFamilia
				);
		}
		sort($dataDistribucion);
		$dataDistribucion = array( "name" => 'PUNTAJE',
			"color" => 'rgba(119, 152, 191, .5)',
			"data"=> $dataDistribucion
			);
		return $distribucion = array(
			"xAxis"=>$responsabilidad,			
			"name"=>"Puntaje Ponderado",
			"series"=>array($dataDistribucion),
			"nivelSituacion"=>$nivelSituacion,
			"min"=>round(min($puntajesPonderado),-1)-4,
			"nivelFamilia" => $responsabilidadCargos
			);
	}

	public function grafico_nivel_competencias($evaluaciones, $responsabilidad){
		foreach ($evaluaciones as $evaluacion){
			if(isset($evaluacion["EvaluacionesTrabajadore"]["id"])){
				if($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]>9){					
					$dataDistribucionComp[] = array(
						$evaluacion["NivelResponsabilidad"]["nivel"],
						$evaluacion["EvaluacionesTrabajadore"]["puntaje_competencias"]
						);	
				}
			}
		}
		$dataDistribucionComp = array( "name" => 'PUNTAJE COMPETENCIAS',
			"color" => 'rgba(223, 83, 83, .5)',
			"data"=> $dataDistribucionComp
			);
		return $distribucionCompetencias = array(
			"xAxis"=>$responsabilidad,
			"name"=>"Puntaje Compentencias",
			"series"=>array($dataDistribucionComp)
			);
	}

	public function grafico_comportamiento($evaluaciones, $familiasCargos, $responsabilidad){
		foreach ($familiasCargos as $cargoNR) {
			$cargosFamilia = array();
			foreach ($cargoNR["CargosNivelResponsabilidade"] as $nivelV){
				$cargosFamilia[] = $nivelV["nivel"];
			}
			$responsabilidadCargos[] = array(
				"name"=> $cargoNR["CargosFamilia"]["nombre"],
				"categories"=> $cargosFamilia
				);
		}
		foreach ($responsabilidadCargos as $nombre => $nivelR) {			
			$nombreRCargos[$nombre] = array_map("unserialize", array_unique(array_map("serialize", $nivelR)));
		}	
		foreach ($evaluaciones as $evaluacion){
			if(isset($evaluacion["EvaluacionesTrabajadore"]["id"])){
				if($evaluacion["EvaluacionesTrabajadore"]["evaluaciones_estado_id"]>9){					
					$comporDesempeno[$evaluacion["NivelResponsabilidad"]["nivel"]][] = array(
						"desempeno"=>floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_ponderado"]),
						"competencias"=>$evaluacion["EvaluacionesTrabajadore"]["puntaje_competencias"]
						);
					$puntajesGlobal[] = floatval($evaluacion["EvaluacionesTrabajadore"]["puntaje_ponderado"]);
					$puntajesCompet[] = $evaluacion["EvaluacionesTrabajadore"]["puntaje_competencias"];					
				}
			}
		}		
		$promGlobal = round( array_sum($puntajesGlobal)/count($puntajesGlobal) , 2);
		$promCompet = round( array_sum($puntajesCompet)/count($puntajesCompet) , 2);
		$nivelResp = explode(",",implode(",",$responsabilidad));
		ksort($comporDesempeno);
		foreach ($nivelResp as $nivel){
			if(array_key_exists($nivel, $comporDesempeno)){
				$cantidadNivel[] = count($comporDesempeno[$nivel]);
				$situacionXNivel[$nivel] = round( array_sum(array_map(function($item) { return $item['desempeno']; }, $comporDesempeno[$nivel])) /count($comporDesempeno[$nivel]) ,2);
				$situacionXNivelComp[$nivel] = round( array_sum(array_map(function($item) { return $item['competencias']; }, $comporDesempeno[$nivel])) /count($comporDesempeno[$nivel]) ,2);	
			}
		}
		$situacionXNivel = array_map('floatval',explode(",",implode(",",$situacionXNivel)));
		$situacionXNivelComp = array_map('floatval',explode(",",implode(",",$situacionXNivelComp)));
		$compXNivelSeries = array(
			array( "name"=> "SITUACIÓN DESEMPEÑO",
				"data" => $situacionXNivel,
				"color" => 'rgb(23, 55, 139)' 
				),
			array( "name"=> "COMPETENCIAS",
				"data" => $situacionXNivelComp,
				"color" => 'rgb(192, 0, 0)'
				)
			);
		$plotLines = array( "desempeno"=> $promGlobal, 
			"competencias"=> $promCompet);

		return $compXNivel = array(
			"xAxis" => $nombreRCargos,
			"series" => $compXNivelSeries,
			"cantidades" => $cantidadNivel,
			"plotLines" => $plotLines
			);
	}

}