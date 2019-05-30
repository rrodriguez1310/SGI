<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
App::uses('EvaluacionesTrabajadoresController', 'Controller');
/**
 * EvaluacionesObjetivos Controller
 *
 * @property EvaluacionesObjetivo $EvaluacionesObjetivo
 * @property PaginatorComponent $Paginator
 */
class EvaluacionesObjetivosController extends AppController {
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

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
        $this->layout = "angular";
	}

	public function listado_objetivos() {
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("EvaluacionesAnio");
        $this->loadModel("EvaluacionesTrabajadore");
		$this->loadModel("Trabajadore");
		$this->loadModel("User");
		$this->loadModel("Jefe");
		$this->loadModel("Cargo");
        $serv = new ServiciosController();
        $nodoInicial = false;
        $ocdDefinido = false;

		$anioActual = $this->EvaluacionesAnio->find("first", array ( "fields"=>"anio_evaluado", "conditions"=>array("evaluar"=>1), "order"=>"anio_evaluado DESC" ));
		$anioAEvaluar = $anioActual["EvaluacionesAnio"]["anio_evaluado"];
		//Usuario-Evaluador
		$datosUser 		= $this->User->find("first", array(
			"fields" =>array("User.trabajadore_id"),
			"conditions" =>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"	=>0 ));     

        $evaluaciones = $this->EvaluacionesTrabajadore->find("first", array(
            "fields" => array("EvaluacionesTrabajadore.id"),
            "conditions"=>array("EvaluacionesTrabajadore.trabajadore_id"=> $datosUser["User"]["trabajadore_id"],
                "EvaluacionesTrabajadore.anio" => $anioAEvaluar),
            "recursive"=>1 ));
        if(!empty($evaluaciones["EvaluacionesObjetivo"])){
            if($evaluaciones["EvaluacionesObjetivo"][0]["evaluaciones_objetivo_estado_id"]>=6)      //finalizado
                $ocdDefinido = true; 
        }

        if($datosUser["User"]["trabajadore_id"] == 110 || $datosUser["User"]["trabajadore_id"] == 111)
            $nodoInicial = true;

		$datosJefe 		= $this->Jefe->find("first", array("conditions"=> array("Jefe.trabajadore_id"=>$datosUser["User"]["trabajadore_id"])));	
		$datosEvaluador = $this->Trabajadore->find("first", array(
			"fields" 		=> array("Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.foto", "Cargo.nombre" ),
			"conditions" 	=> array("Trabajadore.id" => $datosJefe["Jefe"]["trabajadore_id"]), 
			"recursive" => 0)
		);
		$dataEvaluador = array( 
			"nombre" 	=> $serv->capitalize(strtok($datosEvaluador["Trabajadore"]["nombre"]," ") .' '. $datosEvaluador["Trabajadore"]["apellido_paterno"]), 
			"cargo" 	=> $serv->capitalize($datosEvaluador["Cargo"]["nombre"]),
			"foto" 		=> $this->webroot.'files'.DS.'trabajadores'.DS.$datosEvaluador["Trabajadore"]["foto"],
            "nodo_inicial" => ($nodoInicial)? 1:0);
        // cascada, listado colaboradores
        $ocdDefinido = true;
        if($ocdDefinido || $nodoInicial){
    		$anioActual = date("Y")-1;    // spolicitó Mario *************** 04-01-2017
    		$trabajadoresPorJefe = $this->Trabajadore->find("all", array(
    			"fields"=>array( "Trabajadore.id", "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.fecha_indefinido", "Cargo.nombre",//"CargosFamilia.nombre", // se guarda? o se evalua con el actual
    				"EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.trabajadore_id", "EvaluacionesObjetivo.evaluaciones_objetivo_estado_id", "EvaluacionesObjetivo.evaluaciones_etapa_id", "EvaluacionesObjetivo.created", "EvaluacionesObjetivoEstado.nombre", /*"EvaluacionesObjetivo.id", "EvaluacionesObjetivo.evaluaciones_objetivo_estado_id", "EvaluacionesObjetivoEstado.nombre"*/
                    "EvaluacionesTrabajadore.anio"
    				),
    			"joins" => array( array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.trabajadore_id = Trabajadore.id AND EvaluacionesTrabajadore.anio = $anioActual")),
    				array("table" => "evaluaciones_objetivos", "alias" => "EvaluacionesObjetivo", "type" => "LEFT", "conditions" => array("EvaluacionesObjetivo.evaluaciones_trabajadore_id = EvaluacionesTrabajadore.id AND EvaluacionesObjetivo.estado=1 AND EvaluacionesObjetivo.objetivos_comentario_id=1")),				
                    array("table" => "evaluaciones_objetivo_estados", "alias" => "EvaluacionesObjetivoEstado", "type" => "LEFT", "conditions" => array("EvaluacionesObjetivoEstado.id = EvaluacionesObjetivo.evaluaciones_objetivo_estado_id")),
    				),
    			"conditions"=>array(
    				"Trabajadore.jefe_id" => $datosJefe["Jefe"]["id"],
    				"Trabajadore.estado" => "Activo",
    				"Trabajadore.tipo_contrato_id" => array(1,4),
    				//"Trabajadore.fecha_indefinido <=" => $anioActual.date("-m-d"), // indefinido, part-time al 31-03-año anterior    				
                    "OR" => array(
                        array("EvaluacionesObjetivo.evaluaciones_objetivo_estado_id" => array(1,3,4,5,7)),      // Definicion, Calibrado
                        array("EvaluacionesObjetivo.evaluaciones_objetivo_estado_id" => null)             // No iniciado,
                        ),
    				),
    			"order"=>array("Trabajadore.id ASC"),
    			"recursive"=>0
    			));
        } 

		$listadoTrabajadores = array();
        if(!empty($trabajadoresPorJefe)){
    		foreach ($trabajadoresPorJefe as $trabajador) {
                $trabajador["Trabajadore"]["nombre_trabajador"] = $serv->capitalize(strtok($trabajador["Trabajadore"]["nombre"], " ").' '. $trabajador["Trabajadore"]["apellido_paterno"]);
    			$listadoTrabajadores[] = array_merge( $trabajador["Trabajadore"], 
    				array( "evaluacion_id" => $trabajador["EvaluacionesTrabajadore"]["id"],
                        "cargo" => $serv->capitalize($trabajador["Cargo"]["nombre"]),
    					"fecha_inicio" => (isset($trabajador["EvaluacionesObjetivo"]["created"]))? substr($trabajador["EvaluacionesObjetivo"]["created"],0,10): '-',
                        "estado" => (isset($trabajador["EvaluacionesObjetivoEstado"]["nombre"]))? $trabajador["EvaluacionesObjetivoEstado"]["nombre"] : 'No Inicado' ,
                        "etapa_objetivo" => $trabajador["EvaluacionesObjetivo"]["evaluaciones_etapa_id"],
                        "objetivo_estado_id" => $trabajador["EvaluacionesObjetivo"]["evaluaciones_objetivo_estado_id"]
                        )
    			);
    		}
        }
		$datos = array("anioAEvaluar" => $anioAEvaluar,
			"listadoTrabajadores" => $listadoTrabajadores,
			"datosEvaluador" => $dataEvaluador
		);
		$this->set("datos", $datos);
	}

    public function calibrar() {        
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
        $this->layout = "angular";
    }

    public function listado_calibrador() {
        $this->layout = "ajax";
        $this->response->type('json');
        $this->loadModel("EvaluacionesAnio");
        $this->loadModel("EvaluacionesObjetivoEstado");
        $this->loadModel("Trabajadore");
        $this->loadModel("User");
        $this->loadModel("Jefe");
        $this->loadModel("Cargo");
        $serv = new ServiciosController();

        $anioActual = $this->EvaluacionesAnio->find("first", array ( "fields"=>"anio_evaluado", "conditions"=>array("estado"=>1)));        
        $anioAEvaluar = $anioActual["EvaluacionesAnio"]["anio_evaluado"];
        //Usuario-Evaluador
        $datosUser      = $this->User->find("first", array(
            "fields" =>array("User.trabajadore_id"),
            "conditions" =>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
            "recursive" =>0 ));      
            
        if($datosUser["User"]["trabajadore_id"] == 403)
           $datosUser["User"]["trabajadore_id"] = 136;

        $datosJefe      = $this->Jefe->find("first", array("conditions"=> array("Jefe.trabajadore_id"=>$datosUser["User"]["trabajadore_id"]))); 
        $datosCalibrador = $this->Trabajadore->find("first", array(
            "fields"        => array("Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.foto", "Cargo.nombre" ),
            "conditions"    => array("Trabajadore.id"=>$datosJefe["Jefe"]["trabajadore_id"]), 
            "recursive" => 0)
        );
        $dataCalibrador = array( 
            "nombre"    => strtok($datosCalibrador["Trabajadore"]["nombre"]," ") .' '. $datosCalibrador["Trabajadore"]["apellido_paterno"], 
            "cargo"     => $serv->capitalize($datosCalibrador["Cargo"]["nombre"]),
            "foto"      => $this -> webroot . 'files' . DS . 'trabajadores' . DS . $datosCalibrador["Trabajadore"]["foto"]
            );        
        $anioActual = date("Y");  
        $objetivosID = $this->EvaluacionesObjetivo->find("all", array(
            "fields"=> array("EvaluacionesObjetivo.evaluaciones_trabajadore_id", "EvaluacionesObjetivo.modified"),
            "conditions"=> array( "EvaluacionesObjetivo.evaluaciones_etapa_id"=>2,
                "EvaluacionesObjetivo.estado"=>1
            ),
        ));
        $evaluados = array();
        foreach ($objetivosID as $value) {
            $modifObjetivos[$value["EvaluacionesObjetivo"]["evaluaciones_trabajadore_id"]] = $value["EvaluacionesObjetivo"]["modified"];
            $evaluados[] = $value["EvaluacionesObjetivo"]["evaluaciones_trabajadore_id"];
        }
        $TrabajadoresCalibradore = $this->Trabajadore->find("all", array(
            "fields"=>array( "Trabajadore.id", "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.fecha_ingreso",  "Cargo.nombre", 
                "CargosFamilia.nombre", "EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.anio", "EvaluacionesTrabajadore.fecha_inicio", 
                "EvaluadorTrabajadore.id", "EvaluadorTrabajadore.nombre", "EvaluadorTrabajadore.apellido_paterno"/*, "EvaluacionesObjetivo.id"*/),
            "joins"=> array( array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.trabajadore_id = Trabajadore.id")),                
                array("table" => "cargos", "alias" => "Cargo", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.cargo_id = Cargo.id")),
                array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),
                array("table" => "trabajadores", "alias" => "EvaluadorTrabajadore", "type" => "LEFT", "conditions" => array("EvaluadorTrabajadore.id = EvaluacionesTrabajadore.evaluador_trabajadore_id")),                
                ),
            "conditions"=> array("EvaluacionesTrabajadore.validador_trabajadore_id" => $datosCalibrador['Trabajadore']['id'],
                "Trabajadore.estado" => "Activo", 
                "Trabajadore.tipo_contrato_id" => array(1,4), 
                //"Trabajadore.fecha_indefinido <=" => $anioActual.'-03-31',
                "EvaluacionesTrabajadore.id" => $evaluados
                ),
            "order"=> array("EvaluacionesTrabajadore.fecha_modificacion ASC"),
            "recursive"=>-1
            ));
        if(!empty($TrabajadoresCalibradore)){
            foreach ($TrabajadoresCalibradore as $trabajador) {
                $listaTrabajadores[] = array(
                    "trabajador_id"         => $trabajador["Trabajadore"]["id"],
                    "nombre"                => $serv->capitalize(strtok($trabajador["Trabajadore"]["nombre"]," ") ." ". $trabajador["Trabajadore"]["apellido_paterno"]), 
                    "cargo"                 => $serv->capitalize($trabajador["Cargo"]["nombre"]),
                    "familia_cargo"         => $serv->capitalize($trabajador["CargosFamilia"]["nombre"]),
                    "jefatura"              => $serv->capitalize(strtok($trabajador["EvaluadorTrabajadore"]["nombre"]," ") ." ". $trabajador["EvaluadorTrabajadore"]["apellido_paterno"]), 
                    "evaluacion_id"         => $trabajador["EvaluacionesTrabajadore"]["id"],
                    "estado"                => 'Pendiente',
                    "fecha_inicio"          => (isset($trabajador["EvaluacionesTrabajadore"]["fecha_inicio"]))? $trabajador["EvaluacionesTrabajadore"]["fecha_inicio"]: '-',
                    "fecha_modificacion"    => (isset($modifObjetivos[$trabajador["EvaluacionesTrabajadore"]["id"]]))? substr($modifObjetivos[$trabajador["EvaluacionesTrabajadore"]["id"]],0,10): '-',
                    );
            }
        }else{
            $listaTrabajadores = array();
        }        
        $datos = array("anioAEvaluar" => $anioActual,
            "listadoTrabajadores" => $listaTrabajadores,
            "datosCalibrador" => $dataCalibrador
            );
        $this->set("datos", $datos);
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
		$this->layout = "angular";
	}


	public function add_json($id=null) {
		$this->layout = "ajax";
		$this->response->type('json');	
		$this->loadModel("EvaluacionesAnio");
		$this->loadModel("EvaluacionesEtapa");
		$this->loadModel("Trabajadore");
		$this->loadModel("ObjetivosComentario");
		$this->loadModel("EvaluacionesUnidadObjetivo");
		$serv = new ServiciosController();
        $nodoInicial = false;
		$anio_evaluado 	= $this->EvaluacionesAnio->find("first", array ( "fields"=>array("id","anio_evaluado"), "conditions"=>array("evaluar"=>1), "order"=>"anio_evaluado DESC" ));
		$anioEvaluado  	= $anio_evaluado["EvaluacionesAnio"]["anio_evaluado"];
		//trabajador
		$trabajador = $this->Trabajadore->find("first", array(
			"fields" 	=> array("EvaluacionesTrabajadore.id", "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.apellido_materno" , "Trabajadore.foto", "Trabajadore.email",
				"Cargo.id", "Cargo.nombre", "JefeTrabajadore.id", "JefeTrabajadore.nombre", "JefeTrabajadore.email", "Jefe.id", "Jefe.trabajadore_id",
				"JefeTrabajadore.apellido_paterno", "Gerencia.id","Gerencia.nombre", "CargosFamilia.nombre", "CalibradorJefe.id", "CalibradorJefe.nombre", 
				"CalibradorJefe.apellido_paterno", "CalibradorJefe.email"),
			"joins"  	=> array( array("table" => "trabajadores", "alias" => "JefeTrabajadore", "type" => "LEFT", "conditions" => array("Jefe.trabajadore_id = JefeTrabajadore.id")),
				array("table" => "jefes", "alias" => "Calibradore", "type" => "LEFT", "conditions" => array("JefeTrabajadore.jefe_id = Calibradore.id")),
				array("table" => "trabajadores", "alias" => "CalibradorJefe", "type" => "LEFT", "conditions" => array("Calibradore.trabajadore_id = CalibradorJefe.id")),				
				array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
				array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),
				array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.trabajadore_id = $id AND CAST(EvaluacionesTrabajadore.anio AS VARCHAR) = '$anioEvaluado'")),
				),	
			"conditions" => array("Trabajadore.id"=>$id), 
			"recursive"	 => 0
			));
        if($trabajador["JefeTrabajadore"]["id"] == 110 || $trabajador["JefeTrabajadore"]["id"] == 111)
            $nodoInicial = true;        
		$datosTrabajador = array(
			"trabajadore_id"	=> $trabajador["Trabajadore"]["id"],
			"nombre"			=> $serv->capitalize(strtok($trabajador["Trabajadore"]["nombre"]," ").' '.$trabajador["Trabajadore"]["apellido_paterno"]),
			"nombre_completo"	=> $serv->capitalize($trabajador["Trabajadore"]["nombre"].' '.$trabajador["Trabajadore"]["apellido_paterno"]),
			"cargo" 			=> $serv->capitalize($trabajador["Cargo"]["nombre"]),
            "email"             => $trabajador["Trabajadore"]["email"],
			"cargo_id" 			=> $trabajador["Cargo"]["id"],
			"gerencia"			=> $serv->capitalize($trabajador["Gerencia"]["nombre"]),
			"gerencia_id"		=> $trabajador["Gerencia"]["id"],
			"familia_cargo"		=> $serv->capitalize($trabajador["CargosFamilia"]["nombre"]),
			"jefatura"			=> $serv->capitalize(strtok($trabajador["JefeTrabajadore"]["nombre"]," ").' '.$trabajador["JefeTrabajadore"]["apellido_paterno"]),
            "email_jefatura"    => (isset($trabajador["JefeTrabajadore"]["email"]))?$trabajador["JefeTrabajadore"]["email"]:'',
			"nombre_calibrador"	=> $serv->capitalize(strtok($trabajador["CalibradorJefe"]["nombre"]," ").' '.$trabajador["CalibradorJefe"]["apellido_paterno"]),
            "email_calibrador"  => (isset($trabajador["CalibradorJefe"]["email"]))?$trabajador["CalibradorJefe"]["email"]:'',
			"foto" 				=> $this->webroot . 'files' . DS . 'trabajadores' . DS . $trabajador["Trabajadore"]["foto"]            
			);
		//ocd
		$dataObjetivo = $this->ObjetivosComentario->find("all", array( 
			"fields"		=> array("ObjetivosComentario.id", "ObjetivosComentario.nombre"),
			"conditions"	=> array("estado"=>1),
			"order" 		=> "ObjetivosComentario.secuencia",
			"recursive" 	=> -1 
			));
		foreach ($dataObjetivo as $ocd) $datosObjetivo[] = array_merge($ocd["ObjetivosComentario"],
            array("evaluaciones_objetivo_estado_id"=>1,
                "estado" => 1));
		//etapas
		$etapasOCD 	= $this->EvaluacionesEtapa->find("all", array ("fields"=>array("id","nombre"), "conditions"=>array("estado"=>1), "order"=>"id"));
		foreach ($etapasOCD as $etapa) $dataEtapasOCD[] = $etapa["EvaluacionesEtapa"];	
		//uniMedida
		$dataUnidadMedida = $this->EvaluacionesUnidadObjetivo->find("all", array( 			
			"fields"		=> array("EvaluacionesUnidadObjetivo.id", "EvaluacionesUnidadObjetivo.simbolo", "EvaluacionesUnidadObjetivo.nombre"),
			"conditions"	=> array("estado"=>1),
            "order"         => array("EvaluacionesUnidadObjetivo.id ASC")
			));
		foreach ($dataUnidadMedida as $um) $datosUnidadMedida[] = $um["EvaluacionesUnidadObjetivo"];		
		//evaPreliminar		
		$id = array();
		if($trabajador["EvaluacionesTrabajadore"]["id"]>0)
			$id = array("id"=>$trabajador["EvaluacionesTrabajadore"]["id"]);
		$nuevaEvaluacionTrabajador = array_merge(
			$id,
			array("trabajadore_id"		=> $trabajador["Trabajadore"]["id"],
			"evaluador_trabajadore_id"	=> $trabajador["JefeTrabajadore"]["id"],
			"validador_trabajadore_id"	=> $trabajador["CalibradorJefe"]["id"],
			"evaluaciones_estado_id"	=> 0,
			"puntaje_competencias"		=> 0,
			"puntaje_objetivos"			=> 0,
			"puntaje_ponderado"			=> 0,
			"niveles_logro_id"			=> 0,
			"anio"						=> date("Y"),
			"cargo_id"					=> $trabajador["Cargo"]["id"],
			"gerencia_id"				=> $trabajador["Gerencia"]["id"],
            "nodo_inicial"              => ($nodoInicial)? 1:0)
			);
		$datosObjetivos = array( "evaluacionNueva" => $nuevaEvaluacionTrabajador,
			"datosTrabajador" 	=> $datosTrabajador,
			"datosObjetivo" 	=> $datosObjetivo,
			"datosUnidadMedida" => $datosUnidadMedida,
			"datosEtapasOCD"	=> $dataEtapasOCD
			);

		$this->set("datosObjetivos", $datosObjetivos);
	}

	public function add_objetivos(){
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("EvaluacionesEstado");
		$this->loadModel("Feriado");
		$this->loadModel("Trabajadore");
		$this->loadModel("EvaluacionesAnio");
		$this->loadModel("EvaluacionesTrabajadore");
        $this->loadModel("EvaluacionesObjetivoEstado");
		$this->loadModel("EvaluacionesEtapa");
		$eval = new EvaluacionesTrabajadoresController();
		$serv = new ServiciosController();

		if(array_key_exists("id", $this->request->data["EvaluacionesTrabajadore"])){
			$this->EvaluacionesTrabajadore->id = $this->request->data["EvaluacionesTrabajadore"]["id"];
			if( $this->EvaluacionesTrabajadore->exists() ){	//edit
                if( $this->request->data["EvaluacionesTrabajadore"]["etapa"] == 2 && $this->request->data["EvaluacionesTrabajadore"]["pagina"] == 'edit'){
                    $objetivosCalibrar = array(); 
                    foreach ($this->request->data["EvaluacionesObjetivo"] as $ocd2)
                        if($ocd2["evaluaciones_etapa_id"] == $this->request->data["EvaluacionesTrabajadore"]["etapa"]) $objetivosCalibrar[] = $ocd2;
                    if(!empty($objetivosCalibrar))  $this->request->data["EvaluacionesObjetivo"] = $objetivosCalibrar;
                }
                $objetivosSave = array();
                if(array_key_exists("fecha_comunicacion", $this->request->data["EvaluacionesTrabajadore"]) || $this->request->data["EvaluacionesTrabajadore"]["pagina"] == 'modified') {
                    foreach ($this->request->data["EvaluacionesObjetivo"] as $ocd) {
                        if(isset($ocd["fecha_limite_objetivo"])) $ocd["fecha_limite_objetivo"] = implode("-",array_reverse(explode("-",$ocd["fecha_limite_objetivo"])));
                        $objetivosSave[] = $ocd;
                    }
                }
                else
                {    
                    $etapaAnterior = $this->request->data["EvaluacionesTrabajadore"]["etapa"]-1;
                    foreach ($this->request->data["EvaluacionesObjetivo"] as $ocd) {
                        $objetivosID = $this->EvaluacionesObjetivo->find("all", array(
                            "fields" => array("EvaluacionesObjetivo.id", "EvaluacionesObjetivo.evaluaciones_etapa_id"),
                            "conditions"=>array(
                                "objetivos_comentario_id" => $ocd["objetivos_comentario_id"],
                                "evaluaciones_trabajadore_id" => $this->EvaluacionesTrabajadore->id,
                                "evaluaciones_etapa_id >=" => $ocd["evaluaciones_etapa_id"]
                            ),
                        "recursive"=>-1));
                        foreach ($objetivosID as $obj) {
                            $antEtapa = $esEtapa = false;
                            $observado = array();
                            if($obj["EvaluacionesObjetivo"]["evaluaciones_etapa_id"] == $this->request->data["EvaluacionesTrabajadore"]["etapa"]) $esEtapa = true;
                            if($this->request->data["EvaluacionesTrabajadore"]["paso"]=='sig') {
                                if($obj["EvaluacionesObjetivo"]["evaluaciones_etapa_id"] == $etapaAnterior){
                                    $observado = array(
                                        "observado_validador" => (isset($ocd["observado_validador"]))? $ocd["observado_validador"]:0,
                                        "observacion"         => (isset($ocd["observacion"]))? $ocd["observacion"]:''
                                    );    
                                }                                
                            }else
                            if($esEtapa){
                                $observado = array(
                                    "observado_validador" => (isset($ocd["observado_validador"]))? $ocd["observado_validador"]:0,
                                    "observacion"         => (isset($ocd["observacion"]))? $ocd["observacion"]:''
                                );
                            }
                            $objetivosSave[] = array_merge( $obj["EvaluacionesObjetivo"],
                                array("descripcion_objetivo"    => $ocd["descripcion_objetivo"],                       // set
                                    "indicador"                 => $ocd["indicador"],
                                    "evaluaciones_unidad_objetivo_id"   => $ocd["evaluaciones_unidad_objetivo_id"],                   
                                    "porcentaje_ponderacion"            => $ocd["porcentaje_ponderacion"],
                                    "evaluaciones_objetivo_estado_id"   => $ocd["evaluaciones_objetivo_estado_id"],
                                    "fecha_limite_objetivo"     => implode("-",array_reverse(explode("-",$ocd["fecha_limite_objetivo"]))),
                                    "user_id"                   => $this->Session->Read("PerfilUsuario.idUsuario"),
                                    "estado"                    => ($esEtapa)? 1 : 0 ),
                                    $observado                                    
                                );
                        }
                    }
                }                
                if(!empty($objetivosSave)){                    
                    if(array_key_exists("fecha_comunicacion", $this->request->data["EvaluacionesTrabajadore"])){
                        $this->request->data["EvaluacionesTrabajadore"]["fecha_comunicacion"] = implode("-",array_reverse(explode("-",$this->request->data["EvaluacionesTrabajadore"]["fecha_comunicacion"])));
                        $this->EvaluacionesTrabajadore->save($this->request->data["EvaluacionesTrabajadore"]);
                    }      
                    if($this->EvaluacionesObjetivo->saveAll($objetivosSave)){
                        $data = $this->formulario($this->EvaluacionesTrabajadore->id, $this->request->data["EvaluacionesTrabajadore"]["etapa"]);    				
                        CakeLog::write('actividad', 'actualizo - ObjetivosTrabajadores - add_objetivos - id '.$this->EvaluacionesTrabajadore->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));                   
                        $respuesta = array(
                            "estado"=>1,
                            "mensaje"=>"Se actualizó correctamente",
                            "id" => $this->EvaluacionesTrabajadore->id,
                            "data" => $data
                            );
                    }                    
                    if(array_key_exists("Email", $this->request->data)){  
                        foreach ($this->request->data["Email"] as $correo) {                           
                            $estado = $this->EvaluacionesObjetivoEstado->find("first", array("fields"=>"dias_plazo","conditions"=> array("id"=>$this->request->data["EvaluacionesObjetivo"][0]["evaluaciones_objetivo_estado_id"]),"recursive"=>0));
                            $correo["dias_plazo"] = $estado["EvaluacionesObjetivoEstado"]["dias_plazo"];
                            $correo["anio_ocd"] = date("Y");                            
                            $datos = array("datos"=>$correo);
                            $Email = new CakeEmail("gmail");
                            $Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
                            $Email->to(array($correo["email"] => $correo["nombre_email"] ));//$correo["email"];
                            if(isset($correo["copia"])) $Email->cc($correo["copia"]);
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
                    $respuesta = array(
                        "estado"=>0,
                        "mensaje"=>"Ocurrió un problema al guardar la información. Intente mas tarde.",
                        "id" => ($this->EvaluacionesTrabajadore->id),
                        "data" => $this->request->data["EvaluacionesObjetivo"]
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
			if($eval->EvaluacionesTrabajadore->save($this->request->data["EvaluacionesTrabajadore"])){
				$etapasOCD = $this->EvaluacionesEtapa->find("all", array ("fields"=>array("id","nombre"), "conditions"=>array("estado"=>1), "recursive"=>0, "order"=>"id"));
				foreach ($this->request->data["EvaluacionesObjetivo"] as $objetivo) {
                    if(isset($objetivo["fecha_limite_objetivo"])) $objetivo["fecha_limite_objetivo"] = implode("-", array_reverse(explode("-",$objetivo["fecha_limite_objetivo"])));
					$objetivo["evaluaciones_trabajadore_id"] = $eval->EvaluacionesTrabajadore->id;
					foreach ($etapasOCD as $key => $etapa) {
                        $objetivo["evaluaciones_objetivo_estado_id"] = (isset($objetivo["evaluaciones_objetivo_estado_id"]))? $objetivo["evaluaciones_objetivo_estado_id"] : 1; 
						$objetivo["estado"] = ( $this->request->data["EvaluacionesTrabajadore"]["etapa"] == $etapa["EvaluacionesEtapa"]["id"])? 1:0;
						$objetivo["evaluaciones_etapa_id"] = $etapa["EvaluacionesEtapa"]["id"];						
						$objetivo["user_id"] = $this->Session->Read("PerfilUsuario.idUsuario");
						$objetivos[] = 	$objetivo;
					}
				}
				$this->EvaluacionesObjetivo->saveAll($serv->sort_array_multidim($objetivos,"objetivos_comentario_id ASC, evaluaciones_etapa_id ASC"));
				CakeLog::write('actividad', 'ingreso - EvaluacionesObjetivos - EvaluaciónID '.$eval->EvaluacionesTrabajadore->id.' usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$data = $this->formulario($eval->EvaluacionesTrabajadore->id);				
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Se actualizó correctamente",		//ingreso
					"id"=> $eval->EvaluacionesTrabajadore->id,
					"data" => $data
					);

                if(array_key_exists("Email", $this->request->data)){                       
                    $correo = array();
                    foreach ($this->request->data["Email"] as $correo) {                           
                        $estado = $this->EvaluacionesObjetivoEstado->find("first", array("fields"=>"dias_plazo","conditions"=> array("id"=>$this->request->data["EvaluacionesObjetivo"][0]["evaluaciones_objetivo_estado_id"]),"recursive"=>0));
                        $correo["dias_plazo"] = $estado["EvaluacionesObjetivoEstado"]["dias_plazo"];
                        $correo["anio_ocd"] = date("Y");                            
                        $datos = array("datos"=>$correo);
                        $Email = new CakeEmail("gmail");
                        $Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
                        $Email->to(array($correo["email"] => $correo["nombre_email"] ));//$correo["enviar_a_email"];
                        if(isset($correo["copia"])) $Email->cc($correo["copia"]);
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
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se pudo ingresar, por favor intentelo de nuevo",
					"id"=>null
					);
			}
		}
		$this->set("respuesta", $respuesta);
	}

	public function formulario($id = null,$etapa=1){
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("EvaluacionesTrabajadore");
		$serv = new ServiciosController();

		$this->EvaluacionesTrabajadore->Behaviors->attach('Containable');
		$this->EvaluacionesTrabajadore->contain(
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
			"EvaluacionesObjetivo.evaluaciones_objetivo_estado_id", 
			"EvaluacionesObjetivo.fecha_limite_objetivo", 
			"EvaluacionesObjetivo.evaluaciones_unidad_objetivo_id", 
            "EvaluacionesObjetivo.evaluaciones_etapa_id",
			"EvaluacionesObjetivo.evaluaciones_etapa_id<=".$etapa,
			"EvaluacionesObjetivo.indicador", 
			"EvaluacionesObjetivo.estado");
		$evaluacion = $this->EvaluacionesTrabajadore->find("first", array(
			"fields" => array( "EvaluacionesTrabajadore.id", "EvaluacionesTrabajadore.trabajadore_id"),
			"conditions"=> array("EvaluacionesTrabajadore.id" => $id),
			"recursive"=> 1
		));
		$formulario = $evaluacion;		
		foreach ($formulario["EvaluacionesObjetivo"] as $key => $ocd) {
			$formulario["EvaluacionesObjetivo"][$key]["indicador"] = floatval($ocd["indicador"]);
			$formulario["EvaluacionesObjetivo"][$key]["fecha_limite_objetivo"] = implode("-",array_reverse(explode("-",$ocd["fecha_limite_objetivo"])));
		}
		// ASC		
        $formulario["EvaluacionesObjetivo"] = $serv->sort_array_multidim($formulario["EvaluacionesObjetivo"],"id ASC");		
		$this->set("formulario", $formulario);
		return $formulario;
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

	public function edit_json($id = null, $etapa = 1) {
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Trabajadore");
		$this->loadModel("ObjetivosComentario");
		$this->loadModel("EvaluacionesUnidadObjetivo");
        $this->loadModel("EvaluacionesAnio");
		$serv = new ServiciosController();
        $nodoInicial = false;

		$evaluacion = $this->formulario($id);
        $anio_evaluado  = $this->EvaluacionesAnio->find("first", array ( "fields"=>array("id","anio_evaluado"), "conditions"=>array("evaluar"=>1) , "order"=>"anio_evaluado DESC" ));
        $anioEvaluado   = $anio_evaluado["EvaluacionesAnio"]["anio_evaluado"];

		$datosTrabajadorG = $this->Trabajadore->find("all", array(
			"fields"=>array("Trabajadore.id","Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.apellido_materno", "Trabajadore.email", "Trabajadore.foto", "Cargo.nombre", "CargosFamilia.nombre", "CargosFamilia.id", "JefeTrabajadore.id", "JefeTrabajadore.nombre", "JefeTrabajadore.apellido_paterno", "JefeTrabajadore.email", /*"Gerencia.nombre",*/ "CalibradorJefe.id", "CalibradorJefe.nombre", "CalibradorJefe.apellido_paterno", "CalibradorJefe.email"),
			"joins"=> array( array("table" => "evaluaciones_trabajadores", "alias" => "EvaluacionesTrabajadore", "type" => "LEFT", "conditions" => array("Trabajadore.id = EvaluacionesTrabajadore.trabajadore_id")),
				array("table" => "cargos", "alias" => "Cargo", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.cargo_id = Cargo.id")),
				array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),
				array("table" => "trabajadores", "alias" => "JefeTrabajadore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.evaluador_trabajadore_id = JefeTrabajadore.id")),				
				array("table" => "jefes", "alias" => "Calibradore", "type" => "LEFT", "conditions" => array("EvaluacionesTrabajadore.validador_trabajadore_id = Calibradore.trabajadore_id")),
				array("table" => "trabajadores", "alias" => "CalibradorJefe", "type" => "LEFT", "conditions" => array("Calibradore.trabajadore_id = CalibradorJefe.id")),
				),	
			"conditions"=>array( "Trabajadore.id"=>$evaluacion["EvaluacionesTrabajadore"]["trabajadore_id"],
				"EvaluacionesTrabajadore.id" => $id),
			"recursive"=>-1
			));       

        if($datosTrabajadorG[0]["JefeTrabajadore"]["id"] == 110 || $datosTrabajadorG[0]["JefeTrabajadore"]["id"] == 111)
            $nodoInicial = true;
        
		foreach ($datosTrabajadorG as $trabajador) {			
			$datosTrabajador = array(
				"trabajadore_id"	=> $trabajador["Trabajadore"]["id"],
				"nombre"			=> $serv->capitalize(strtok($trabajador["Trabajadore"]["nombre"]," ").' '.$trabajador["Trabajadore"]["apellido_paterno"]),				
				"cargo" 			=> $serv->capitalize($trabajador["Cargo"]["nombre"]),
				"familia_cargo"		=> $serv->capitalize($trabajador["CargosFamilia"]["nombre"]),
				"email"				=> $trabajador["Trabajadore"]["email"],				
				"jefatura"	        => $serv->capitalize(strtok($trabajador["JefeTrabajadore"]["nombre"]," ").' '.$trabajador["JefeTrabajadore"]["apellido_paterno"]),
				"email_jefatura"	=> $trabajador["JefeTrabajadore"]["email"],
				"nombre_calibrador"	=> $serv->capitalize(strtok($trabajador["CalibradorJefe"]["nombre"]," ").' '.$trabajador["CalibradorJefe"]["apellido_paterno"]),
				"email_calibrador"	=> $trabajador["CalibradorJefe"]["email"],
				"foto" 				=> $this -> webroot . 'files' . DS . 'trabajadores' . DS . $trabajador["Trabajadore"]["foto"],
                "anio"              => $anioEvaluado
				);
		}
		//ocd
		$objetivos = $this->EvaluacionesObjetivo->find("all",array(
			"fields" => array("EvaluacionesObjetivo.id", "EvaluacionesObjetivo.descripcion_objetivo", "EvaluacionesObjetivo.indicador", "EvaluacionesObjetivo.evaluaciones_unidad_objetivo_id",
                "EvaluacionesObjetivo.fecha_limite_objetivo", "EvaluacionesObjetivo.porcentaje_ponderacion", "EvaluacionesObjetivo.evaluaciones_trabajadore_id",
                "EvaluacionesObjetivo.objetivos_comentario_id", "EvaluacionesObjetivo.evaluaciones_objetivo_estado_id", "EvaluacionesObjetivo.evaluaciones_etapa_id",
                "EvaluacionesObjetivo.observado_validador", "EvaluacionesObjetivo.observacion",
                "EvaluacionesObjetivo.estado", "ObjetivosComentario.id", "ObjetivosComentario.nombre"),
			"conditions"=>array("EvaluacionesObjetivo.evaluaciones_trabajadore_id"=>$id,
            "EvaluacionesObjetivo.evaluaciones_etapa_id <="=> $etapa), //estado = 1
			"recursive"=>0)
		);
        $unidadMedida = $this->EvaluacionesUnidadObjetivo->find("list", array( "fields" => array("EvaluacionesUnidadObjetivo.id", "EvaluacionesUnidadObjetivo.simbolo") ));
        $ocdEvaluar = array();
		foreach ($objetivos as $ocd) {               
			$ocd["EvaluacionesObjetivo"]["fecha_limite_objetivo"] = implode("-", array_reverse( explode("-",$ocd["EvaluacionesObjetivo"]["fecha_limite_objetivo"])));
			$ocdEvaluar[] = array_merge($ocd["EvaluacionesObjetivo"], 
                array("nombre_objetivo" => (($ocd["EvaluacionesObjetivo"]["evaluaciones_etapa_id"]==2)? 'Calibración ' : '' ).$ocd["ObjetivosComentario"]["nombre"],
                    "simbolo_indicador" => (isset($ocd["EvaluacionesObjetivo"]["evaluaciones_unidad_objetivo_id"]))? $unidadMedida[$ocd["EvaluacionesObjetivo"]["evaluaciones_unidad_objetivo_id"]] : ''
                ));
		}
		//uniMedida
		$dataUnidadMedida = $this->EvaluacionesUnidadObjetivo->find("all", array( 			
			"fields"		=> array("EvaluacionesUnidadObjetivo.id", "EvaluacionesUnidadObjetivo.simbolo", "EvaluacionesUnidadObjetivo.nombre"),
			"conditions"	=> array("estado"=>1),
			"order"         => array("EvaluacionesUnidadObjetivo.id ASC")
			));
		foreach ($dataUnidadMedida as $um) $datosUnidadMedida[] = $um["EvaluacionesUnidadObjetivo"];		

		$editObjetivos = array( "datosTrabajador"=>$datosTrabajador,
			"dataObjetivos" => (!empty($ocdEvaluar))? $serv->sort_array_multidim($ocdEvaluar, "id ASC"): '[]',
			"datosUnidadMedida" => $datosUnidadMedida,
            "listUnidadMedida" => $unidadMedida,
            "nodo_inicial" => ($nodoInicial)? 1:0
			);
		$this->set("editObjetivos", $editObjetivos);
	}

    public function objetivos_consolidado() {
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
        CakeLog::write('actividad', 'Visito - Ver Consolidado Objetivos - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));    
        $this->layout = "angular";
    }

    public function objetivos_consolidado_json($anio=null){
        $this->layout = "ajax";
        $this->response->type('json');
        $this->loadModel("EvaluacionesAnio");
        $this->loadModel("Trabajadore");
        $this->loadModel("NivelesLogro");
        $this->loadModel("EvaluacionesTrabajadore");
        $this->loadModel("EvaluacionesUnidadObjetivo");
        $this->loadModel("EvaluacionesObjetivoEstado");
        $this->loadModel("ObjetivosComentario");
        $serv = new ServiciosController();    
        $anio = 2016;
        if(!$anio)
            $anio = date("Y");

        $this->EvaluacionesTrabajadore->Behaviors->attach('Containable');
        $this->EvaluacionesTrabajadore->contain(
            array( "EvaluacionesObjetivo" => array(
                    "fields" => array("EvaluacionesObjetivo.objetivos_comentario_id","EvaluacionesObjetivo.descripcion_objetivo", "EvaluacionesObjetivo.indicador", "EvaluacionesObjetivo.evaluaciones_unidad_objetivo_id", "EvaluacionesObjetivo.fecha_limite_objetivo",
                        "EvaluacionesObjetivo.porcentaje_ponderacion", "EvaluacionesObjetivo.evaluaciones_objetivo_estado_id"),
                    "conditions" => array( "EvaluacionesObjetivo.estado" =>1 ))
            ));
        $trabajadores = $this->EvaluacionesTrabajadore->find("all", array(
            "fields" => array( "EvaluacionesTrabajadore.*","Trabajadore.*", "Cargo.nombre", "CargosFamilia.nombre", "Gerencia.nombre", "TrabajadoreJefe.nombre", "TrabajadoreJefe.apellido_paterno",
               "CargoNivelResponsabilidad.nivel" ),
            "joins" => array( array("table" => "trabajadores", "alias" => "Trabajadore", "type" => "RIGHT", "conditions" => array("EvaluacionesTrabajadore.trabajadore_id = Trabajadore.id AND EvaluacionesTrabajadore.anio=$anio")),                
                array("table" => "cargos", "alias" => "Cargo", "type" => "LEFT", "conditions" => array("Trabajadore.cargo_id = Cargo.id")),
                array("table" => "cargos_nivel_responsabilidades", "alias" => "CargoNivelResponsabilidad", "type" => "LEFT", "conditions" => array("Cargo.cargos_nivel_responsabilidade_id = CargoNivelResponsabilidad.id")),
                array("table" => "cargos_familias", "alias" => "CargosFamilia", "type" => "LEFT", "conditions" => array("Cargo.cargos_familia_id = CargosFamilia.id")),
                array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
                array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
                array("table" => "jefes", "alias" => "Jefe", "type" => "LEFT", "conditions" => array("Trabajadore.jefe_id = Jefe.id")), // ... seguir consolidado OCD
                array("table" => "trabajadores", "alias" => "TrabajadoreJefe", "type" => "LEFT", "conditions" => array("Jefe.trabajadore_id = TrabajadoreJefe.id")),
             ),
            "conditions" => array(
                "Trabajadore.estado" => "Activo",
                "Trabajadore.tipo_contrato_id" => array(1,4),
                //"Trabajadore.fecha_indefinido <=" => $anio.date("-m-d"), // indefinido, part-time al 31-03-año anterior
                ),
            "recursive"=>1
            ));
        
        $nombreObjetivos = $this->ObjetivosComentario->find("list", array("fields"=> array("id", "nombre"), "order" => "secuencia ASC"));
        $unidadesMedidas = $this->EvaluacionesUnidadObjetivo->find("list", array("fields"=> array("id", "simbolo"), "order" => "id ASC"));        
        $estadoObjetivos = $this->EvaluacionesObjetivoEstado->find("list", array("fields"=> array("id", "nombre"), "order" => "id ASC"));
        $cantidadObjetivos = 0;
        foreach ($trabajadores as $trab) {
            if(!empty($trab["EvaluacionesObjetivo"])){
                $cantidadObjetivos = count($trab["EvaluacionesObjetivo"]);
                $trabOCD = array();
                foreach ($trab["EvaluacionesObjetivo"] as $key => $ocd) {                    
                    $objetivo = array(
                        "nombre".$key        => $nombreObjetivos[$ocd["objetivos_comentario_id"]],
                        "descripcion".$key   => $ocd["descripcion_objetivo"],
                        "indicador".$key     => (isset($ocd["evaluaciones_unidad_objetivo_id"]))? (($ocd["evaluaciones_unidad_objetivo_id"] == 1)? $unidadesMedidas[$ocd["evaluaciones_unidad_objetivo_id"]]." ".number_format($ocd["indicador"], 0, '', '.'): number_format($ocd["indicador"], 0, '', '.').' '.$unidadesMedidas[$ocd["evaluaciones_unidad_objetivo_id"]]):0,                        
                        "fecha_limite".$key  => $ocd["fecha_limite_objetivo"],
                        "porcentaje".$key    => $ocd["porcentaje_ponderacion"],
                        "estado".$key        => $estadoObjetivos[$ocd["evaluaciones_objetivo_estado_id"]],
                        "objetivo_estado_id".$key => $ocd["evaluaciones_objetivo_estado_id"]
                    );
                    $trabOCD = array_merge($trabOCD, $objetivo);
                }
                $listadoObjetivos[] = array_merge( array(
                        "evaluacion_id" => $trab["EvaluacionesTrabajadore"]["id"],
                        "rut"           => $trab["Trabajadore"]["rut"],
                        "gerencia"      => $serv->capitalize($trab["Gerencia"]["nombre"]),                
                        "jefatura"      => $serv->capitalize(strtok($trab["TrabajadoreJefe"]["nombre"], " "). ' ' .$trab["TrabajadoreJefe"]["apellido_paterno"]),                
                        "nombre_trabajador" => $serv->capitalize(strtok($trab["Trabajadore"]["nombre"], " "). ' ' .$trab["Trabajadore"]["apellido_paterno"]),
                        "cargo"         => $serv->capitalize($trab["Cargo"]["nombre"]),
                        "familia_cargo" => $serv->capitalize($trab["CargosFamilia"]["nombre"]),
                        "nr"            => $trab["CargoNivelResponsabilidad"]["nivel"],                                        
                        "fecha_comunicacion" => (isset($trab["EvaluacionesTrabajadore"]["fecha_comunicacion"]))? $trab["EvaluacionesTrabajadore"]["fecha_comunicacion"] : '-',
                        "estadoObjetivos" => (!empty($trabOCD))? $trabOCD["estado0"] : 'No Inicado'),
                        $trabOCD
                        );
            }else{
                $listadoObjetivos[] = array(
                    "evaluacion_id" => $trab["EvaluacionesTrabajadore"]["id"],
                    "rut"           => $trab["Trabajadore"]["rut"],
                    "gerencia"      => $serv->capitalize($trab["Gerencia"]["nombre"]),                
                    "jefatura"      => $serv->capitalize(strtok($trab["TrabajadoreJefe"]["nombre"], " "). ' ' .$trab["TrabajadoreJefe"]["apellido_paterno"]),                
                    "nombre_trabajador" => $serv->capitalize(strtok($trab["Trabajadore"]["nombre"], " "). ' ' .$trab["Trabajadore"]["apellido_paterno"]),
                    "cargo"         => $serv->capitalize($trab["Cargo"]["nombre"]),
                    "familia_cargo" => $serv->capitalize($trab["CargosFamilia"]["nombre"]),
                    "nr"            => $trab["CargoNivelResponsabilidad"]["nivel"],                
                    "fecha_comunicacion" => (isset($trab["EvaluacionesTrabajadore"]["fecha_comunicacion"]))? $trab["EvaluacionesTrabajadore"]["fecha_comunicacion"] : '-',
                    "estadoObjetivos" => 'No Inicado',
                    "nombre"        => "-",
                    "objetivo_estado_id"=> null
                );
            }
        }        
        $consObjetivos = array("anioActual"=>$anio,
            "cantidadObjetivos" => $cantidadObjetivos,
            "listadoObjetivos" => $listadoObjetivos,
            );
        $this->set("consObjetivos", $consObjetivos);
    }
}
