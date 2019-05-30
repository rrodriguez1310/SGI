<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * SistemasIncidencias Controller
 *
 * @property SistemasIncidencia $SistemasIncidencia
 * @property PaginatorComponent $Paginator
 */
class SistemasIncidenciasController extends AppController {

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
		$this->set("layoutContent","container-fluid");
		$this->layout = "angular";
	}

	public function sistemas_incidencias(){
		
		$this->autoRender = false;
		$this->response->type("json");
		$respuesta = array();
		if($this->Session->Read("Users.flag") == 1){
			$incidencias = $this->SistemasIncidencia->find("all", array(
				 "order"=>"SistemasIncidencia.created DESC",
				"recursive"=>-1
			));
			if(!empty($incidencias)){
				foreach ($incidencias as $incidencia) {
					$respuesta[] = array(
						"id"=>$incidencia["SistemasIncidencia"]["id"],
						"fecha_inicio"=> $incidencia["SistemasIncidencia"]["fecha_inicio"],
						"fecha_cierre"=> $incidencia["SistemasIncidencia"]["fecha_cierre"],
						"titulo"=>$incidencia["SistemasIncidencia"]["titulo"],
						"tarea"=>$incidencia["SistemasIncidencia"]["tarea"],
						"estado"=>$incidencia["SistemasIncidencia"]["estado"],
						"user_id"=>$incidencia["SistemasIncidencia"]["user_id"],
						"area_id"=>$incidencia["SistemasIncidencia"]["area_id"],
						"sistemas_responsables_incidencia_id"=>$incidencia["SistemasIncidencia"]["sistemas_responsables_incidencia_id"],
						"fecha_actual"=>date("Y-m-d")
					);

				}
			}
		}
		
		return json_encode($respuesta);
	}

	public function sistemas_incidencias_por_area(){
		$this->autoRender = false;
		$this->response->type("json");
		$respuesta = array();
		if($this->Session->Read("Users.flag") == 1){
			$incidencias = $this->SistemasIncidencia->find("all", array(
				"conditions"=>array(
					"SistemasIncidencia.estado"=>1,
					"SistemasIncidencia.area_id"=>$this->request->query["areaId"]
				),
				"recursive"=>-1
			));
			
			if(!empty($incidencias)){
				foreach ($incidencias as $incidencia) {
					$respuesta[] = array(
						"id"=>$incidencia["SistemasIncidencia"]["id"],
						"fecha_inicio"=> $incidencia["SistemasIncidencia"]["fecha_inicio"],
						"titulo"=>$incidencia["SistemasIncidencia"]["titulo"],
						"tarea"=>$incidencia["SistemasIncidencia"]["tarea"],
						"estado"=>$incidencia["SistemasIncidencia"]["estado"],
						"user_id"=>$incidencia["SistemasIncidencia"]["user_id"],
						"area_id"=>$incidencia["SistemasIncidencia"]["area_id"],
						"sistemas_responsables_incidencia_id"=>$incidencia["SistemasIncidencia"]["sistemas_responsables_incidencia_id"],
					);
				}
			}
		}
		return json_encode($respuesta);
	}

	public function view($id = null){
		
		$this->loadModel("User");
		$this->loadModel("Gerencia");
		$this->loadModel("SistemasIncidenciasOb");
		 
		$this->SistemasIncidencia->id = $id;
		if(!$this->SistemasIncidencia->exists()){
			$this->Session->setFlash("La Incidencia solicitada no existe", 'msg_fallo');
			return $this->redirect(array("controller"=>"sistemas_incidencias",'action' => 'index'));
		}

		$incidenciasobs = $this->SistemasIncidenciasOb->find("first", array(
            "order"=>"SistemasIncidenciasOb.id ASC",
			'conditions' => array('SistemasIncidenciasOb.sistemas_incidencia_id' => $this->SistemasIncidencia->id),
            "recursive"=>-1
        ));
			
		
		$incidencia = $this->SistemasIncidencia->findById($this->SistemasIncidencia->id);
		$usuarioResponsable = $this->User->find("first", array("conditions"=>array("User.id"=>$incidencia["SistemasResponsablesIncidencia"]["user_id"]),"recursive"=>-1));
		$incidencia["SistemasResponsablesIncidencia"]["User"] = $usuarioResponsable["User"];
		$fecha_inicial = new DateTime($incidencia["SistemasIncidencia"]["fecha_inicio"]);
		$fecha_cierre = empty($incidencia["SistemasIncidencia"]["fecha_cierre"]) ? null : new DateTime($incidencia["SistemasIncidencia"]["fecha_cierre"]);

		if(!empty($incidenciasobs["SistemasIncidenciasOb"])){
			$idUsuarios[] = $incidenciasobs["SistemasIncidenciasOb"]["user_id"];
			
			$usuarios = $this->User->find("list", array("fields"=>array("User.nombre"), "conditions"=>array("User.id"=>$idUsuarios)));
			$cuenta = 1;
			foreach ($usuarios as $key => $usuario) {
				switch ($cuenta) {
					case '1':
						$color  = "success";
						break;
					case '2':
						$color  = "primary";
						break;
					case '3':
						$color  = "info";
						break;
					case '4':
						$color  = "warning";
						break;
					default:
						$color = "default";
						break;
				}
				$usuarios[$key] = array(
					"nombre"=>$usuario,
					"color"=>$color
				);
				$cuenta++;
			}
		}
		
		$gerencia = $this->Gerencia->find("first", array("conditions"=>array("Gerencia.id"=>$incidencia["SistemasResponsablesIncidencia"]["gerencia_id"]), "recursive"=>-1, "fields"=>"Gerencia.nombre"));
		$incidencia["Area"]["Gerencia"] = $gerencia["Gerencia"]["nombre"];
		$this->set("incidencia", $incidencia);
		$this->set("incidenciasobs", $incidenciasobs);
		if(isset($usuarios)){
			$this->set("usuarios", $usuarios);
		}
		$this->set("estados", array("Eliminado","En Proceso", "Cerrado"));
	}

	public function add(){
		
		$this->layout = "angular";
		$this->loadModel("SistemasResponsablesIncidencia");
		
		$responsable ='250';
		if(empty($responsable)){
			$this->Session->setFlash('No puedes ingresar una incidencia', 'msg_fallo');
			return $this->redirect(array("controller"=>"dashboards",'action' => 'index'));
		}
	}
	public function registrar_sistemas_incidencias(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("User");
		$this->loadModel("SistemasResponsablesIncidencia");
		$this->loadModel("Gerencia");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				if(isset($this->request->data["SistemasIncidencia"]["id"])){
					$tipo = 2;
					$this->SistemasIncidencia->id = $this->request->data["SistemasIncidencia"]["id"];
					if($this->SistemasIncidencia->exists()){
						$mensaje = array(
							"log"=>"Editar",
							"mensaje"=>"Se edito correctamente la incidencia"
						);
						$titulo = "Se realizo un cambio en la incidencia";
					}else{
						return $respuesta = array(
							"estado"=>0,
							"mensaje"=>"La incidencia no existe"
						);
					}					
				}else{
					$tipo = 1;
					$this->request->data["SistemasIncidencia"]["user_id"] = $this->Session->Read("PerfilUsuario.idUsuario");
					$mensaje = array(
						"log"=>"Ingreso",
						"mensaje"=>"Se ingreso correctamente la incidencia"
					);
					$titulo = "Se registro una nueva incidencia";
				}
				if($this->SistemasIncidencia->save($this->request->data)){
					CakeLog::write('actividad', $mensaje["log"].$this->SistemasIncidencia->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash($mensaje["mensaje"], 'msg_exito');
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>$mensaje["mensaje"]
					);
					$this->SistemasResponsablesIncidencia->id = $this->request->data["SistemasIncidencia"]["sistemas_responsables_incidencia_id"];
					$usuario = $this->User->findById($this->SistemasResponsablesIncidencia->field("user_id"));
					$incidencia = $this->SistemasIncidencia->findById($this->SistemasIncidencia->id);
					$usuarioResponsable = $this->User->find("first", array("conditions"=>array("User.id"=>$incidencia["SistemasResponsablesIncidencia"]["user_id"]),"recursive"=>-1));
					$incidencia["SistemasResponsablesIncidencia"]["User"] = $usuarioResponsable["User"];
					$fecha_inicial = new DateTime($incidencia["SistemasIncidencia"]["fecha_inicio"]);
				    $fecha_cierre = empty($incidencia["SistemasIncidencia"]["fecha_cierre"]) ? null : new DateTime($incidencia["SistemasIncidencia"]["fecha_cierre"]);
					$this->Gerencia->id = $incidencia["Area"]["gerencia_id"];
					$incidencia["Gerencia"] = $this->Gerencia->field("nombre");
					$Email = new CakeEmail("gmail");
					$Email->from(array('sgi@cdf.cl' => 'SGI'));
					$Email->to(array('soporte@cdf.cl'));
					empty($usuario["Trabajadore"]["email"]) ? "" : $Email->cc($usuario["Trabajadore"]["email"]);
					$Email->subject(($tipo==1) ? "Registro de incidencia ".$incidencia["SistemasIncidencia"]["titulo"] : "Edición de incidencia ".$incidencia["SistemasIncidencia"]["titulo"]);
					$Email->emailFormat('html');
					$Email->template('sistemas_registrar_incidencia');
					$Email->viewVars(array(
						"titulo"=>($tipo==1) ? "SE HA GENERADO UN REGISTRO DE INCIDENCIA" : "SE HA EDITO LA SIGUENTE INCIDENCIA",
						"incidencia"=>$incidencia,
					));
					$Email->send();
				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"Problemas al guardar en base de datos, por favor intentelo nuevamente"
					);
				}
			}else{
				$this->Session->setFlash('Metodo no permitido', 'msg_fallo');
				return $this->redirect(array("controller"=>"dashboards",'action' => 'index'));
			}
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Sesion perdida, por favor vuelva a ingresar al sistema e intentelo nuevamente"
		    	);
		  }
		return json_encode($respuesta);
	  }
	
		public function sistemas_incidencia(){
			$this->autoRender = false;
			$this->response->type("json");
			$respuesta = array();
			$incidencias = $this->SistemasIncidencia->findById($this->request->query["id"]);
			
			if(!empty($incidencias)){
				$respuesta = $incidencias;
			}
			return json_encode($respuesta);
	    }

	/**
	* edit method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function edit($id = null){
		$this->layout = "angular";
		$this->loadModel("SistemasResponsablesIncidencia");
		
		$this->SistemasIncidencia->id = $id;
		if($this->SistemasIncidencia->exists()){
			$responsableUsuario = $this->SistemasResponsablesIncidencia->findByUserId($this->Session->Read("PerfilUsuario.idUsuario"));
			if(!empty($responsableUsuario)){
				if($responsableUsuario["SistemasResponsablesIncidencia"]["admin"]!=1){
					if(!($this->SistemasIncidencia->field("sistemas_responsables_incidencia_id") == $responsableUsuario["SistemasResponsablesIncidencia"]["id"] && $this->SistemasIncidencia->field("estado") == 1)){
						$this->Session->setFlash("No puedes editar esta incidencia", 'msg_fallo');
						return $this->redirect(array("controller"=>"sistemas_incidencias",'action' => 'index'));		
					}
				}
			}else{
				$this->Session->setFlash("No puedes editar una incidencia", 'msg_fallo');
				return $this->redirect(array("controller"=>"sistemas_incidencias",'action' => 'index'));
			}
		}else{
			$this->Session->setFlash("La incidencia solicitada no existe", 'msg_fallo');
			return $this->redirect(array("controller"=>"sistemas_incidencias",'action' => 'index'));	
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
		$this->SistemasIncidencia->id = $id;
		if (!$this->SistemasIncidencia->exists()) {
			throw new NotFoundException(__('Invalid sistemas incidencia'));
		}
		if ($this->SistemasIncidencia->delete()) {
			
			$this->Session->setFlash("La incidencia ha sido eliminada", 'msg_exito');
		} else {
			
			$this->Session->setFlash("La incidencia no pudo ser eliminada", 'msg_fallo');
		}
		return $this->redirect(array('action' => 'index'));
	}
	public function observaciones_incidencia($id = null){
		$this->layout = "angular";
		$this->loadModel("SistemasResponsablesIncidencia");
		$this->SistemasIncidencia->id = $id;
		if($this->SistemasIncidencia->exists()){
			$responsableUsuario = $this->SistemasResponsablesIncidencia->findByUserId($this->Session->Read("PerfilUsuario.idUsuario"));
			if(!empty($responsableUsuario)){
				if(!$responsableUsuario["SistemasResponsablesIncidencia"]["admin"]==1 ){
					if(!($this->SistemasIncidencia->field("sistemas_responsables_incidencia_id") == $responsableUsuario["SistemasResponsablesIncidencia"]["id"] && $this->SistemasIncidencia->field("estado") == 1)){
						$this->Session->setFlash("No puedes ingresar el cierre de esta Incidencia", 'msg_fallo');
						return $this->redirect(array("controller"=>"sistemas_incidencias",'action' => 'index'));		
					}
				}
			}else{
				$this->Session->setFlash("No puedes ingresar el cierre de esta Incidencia", 'msg_fallo');
				return $this->redirect(array("controller"=>"sistemas_incidencias",'action' => 'index'));
			}
		}else{
			$this->Session->setFlash("La Incidencia solicitada no existe", 'msg_fallo');
			return $this->redirect(array("controller"=>"sistemas_incidencias",'action' => 'index'));	
		}
	}
	public function cerrar_incidencia($id = null){
		$this->layout = "angular";
		$this->loadModel("SistemasResponsablesIncidencia");
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
		$this->SistemasIncidencia->id = $id;
		if($this->SistemasIncidencia->exists()){
			$responsableUsuario = $this->SistemasResponsablesIncidencia->findByUserId($this->Session->Read("PerfilUsuario.idUsuario"));
			if(!empty($responsableUsuario)){
				if(!$responsableUsuario["SistemasResponsablesIncidencia"]["admin"]==1 ){
					if(!($this->SistemasIncidencia->field("sistemas_responsables_incidencia_id") == $responsableUsuario["SistemasResponsablesIncidencia"]["id"] && $this->SistemasIncidencia->field("estado") == 1)){
						$this->Session->setFlash("No puedes ingresar el cierre de esta incidencia", 'msg_fallo');
						return $this->redirect(array("controller"=>"sistemas_incidencias",'action' => 'index'));		
					}
				}
			}else{
				$this->Session->setFlash("No puedes ingresar el cierre de esta incidencia", 'msg_fallo');
				return $this->redirect(array("controller"=>"sistemas_incidencias",'action' => 'index'));
			}
		}else{
			$this->Session->setFlash("La incidencia solicitada no existe", 'msg_fallo');
			return $this->redirect(array("controller"=>"sistemas_incidencias",'action' => 'index'));	
		}
	 }
	public function registro_cierre_incidencia(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("User");
		$this->loadModel("SistemasResponsablesIncidencia");
		$this->loadModel("Gerencia");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				$this->SistemasIncidencia->id = $this->request->data["SistemasIncidencia"]["id"];
				$incidencia = $this->SistemasIncidencia->findById($this->SistemasIncidencia->id);
				if(empty($incidencia["SistemasIncidencia"]["fecha_cierre"])){
					$tipo = 1;
					$mensaje = array(
						"log"=>"Ingreso",
						"mensaje"=>"Se ingreso correctamente el cierre de la incidencia"
					);
				}else{
					$tipo = 2;
					$mensaje = array(
						"log"=>"Editar",
						"mensaje"=>"Se edito correctamente el cierre de la incidencia"
					);
				}
				if($this->SistemasIncidencia->exists()){
					if($this->SistemasIncidencia->save($this->request->data)){
						CakeLog::write('actividad',$mensaje["log"]." - registro_cierre_incidencia".$this->SistemasIncidencia->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						$this->Session->setFlash($mensaje["mensaje"], 'msg_exito');
						$respuesta = array(
							"estado"=>1,
							"mensaje"=>$mensaje["mensaje"]
						);
						$incidencia = $this->SistemasIncidencia->findById($this->SistemasIncidencia->id);
						$this->SistemasResponsablesIncidencia->id = $incidencia["SistemasIncidencia"]["sistemas_responsables_incidencia_id"];
						$usuario = $this->User->findById($this->SistemasResponsablesIncidencia->field("user_id"));
						$usuarioResponsable = $this->User->find("first", array("conditions"=>array("User.id"=>$incidencia["SistemasResponsablesIncidencia"]["user_id"]),"recursive"=>-1));
						$incidencia["SistemasResponsablesIncidencia"]["User"] = $usuarioResponsable["User"];
						$fecha_inicial = new DateTime($incidencia["SistemasIncidencia"]["fecha_inicio"]);
						$fecha_cierre = empty($incidencia["SistemasIncidencia"]["fecha_cierre"]) ? null : new DateTime($incidencia["SistemasIncidencia"]["fecha_cierre"]);
						$this->Gerencia->id = $incidencia["Area"]["gerencia_id"];
						$incidencia["Gerencia"] = $this->Gerencia->field("nombre");
						$Email = new CakeEmail("gmail");
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to(array('soporte@cdf.cl'));
						empty($usuario["Trabajadore"]["email"]) ? "" : $Email->cc($usuario["Trabajadore"]["email"]);
						$Email->subject(($tipo == 1) ? "Ingreso cierre incidencia ".$incidencia["SistemasIncidencia"]["titulo"] : "Edición cierre incidencia ".$incidencia["SistemasIncidencia"]["titulo"]);
						$Email->emailFormat('html');
						$Email->template('sistemas_registrar_cierre_inicidencia');
						$Email->viewVars(array(
							"incidencia"=>$incidencia,
							"titulo"=>($tipo==1) ? "SE INGRESO CIERRE DE incidencia" : "SE EDITO CIERRE DE incidencia" 
						));
						$Email->send();
					}
				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"El registro no existe"
					);
				}
			}
		}
		return json_encode($respuesta);
	}
	public function reportes(){
		$this->layout = "angular";
		
	}

	public function data_reporte(){
		$this->autoRender = false;
		$this->response->type("json");
		$respuesta["reporte_ingresos_cierres"] = $this->reporte_ingresos_cierres();
		return json_encode($respuesta);
	}

	public function registro_observacion_incidencia(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("SistemasIncidenciasOb");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				$this->SistemasIncidencia->id = $this->request->data["SistemasIncidenciasOb"]["sistemas_incidencia_id"];
				if($this->SistemasIncidencia->exists()){
					$this->request->data["SistemasIncidenciasOb"]["user_id"] = $this->Session->Read("PerfilUsuario.idUsuario");
					if($this->SistemasIncidenciasOb->save($this->request->data)){
						CakeLog::write('actividad',"Ingreso - registro_observacion_incidencia".$this->SistemasIncidenciasOb->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						$this->Session->setFlash("Se ingreso correctamente la observación", 'msg_exito');
						$respuesta = array(
							"estado"=>1,
							"mensaje"=>"Se ingreso correctamente la observación"
						);
					}
				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"El registro no existe"
					);
				}
			}
		}
		return json_encode($respuesta);
	}

	 public function reporte_ingresos_cierres(){
			$this->autoRender = false;

			$sistemasIncis = $this->SistemasIncidencia->find('all',array(
				'order'=>array("SistemasIncidencia.id ASC"),
				"fields" => array("SistemasIncidencia.estado", "SistemasIncidencia.user_id","SistemasIncidencia.fecha_inicio"),    
				'recursive'=> 1
			));
			foreach($sistemasIncis as $sistemasInci){
			$sistemasIncidencia[] = array(
				"estado"=>$sistemasInci["SistemasIncidencia"]["estado"],
				"user_id"=>$sistemasInci["SistemasIncidencia"]["user_id"],
				"fecha_inicio"=>date("Y", strtotime($sistemasInci["SistemasIncidencia"]["fecha_inicio"]	))	
			);
			}
			$totalIncidencia = count($sistemasIncidencia);
			if($sistemasIncidencia){
			foreach($sistemasIncidencia as $sistemasInci2){

			if($sistemasInci2["estado"]==2){
			    $totalEstado2[] = array("estado"=>$sistemasInci2["estado"]);
			}
			if($sistemasInci2["estado"]==1){
				$totalEstado1[] = array(
				"estado"=>$sistemasInci2["estado"]
				);
				}
			if($sistemasInci2["estado"]==0){
				$totalEstado0[] = array(
				"estado"=>$sistemasInci2["estado"]
				);
			    }
			  }	
			}
			$totalEstadodos=count($totalEstado2);
			$totalEstadouno=count($totalEstado1);
			$porcentajeToatl1 = ($totalEstadodos/$totalIncidencia)*100;
			$porcentajeToatl2 = ($totalEstadouno/$totalIncidencia)*100;

			$promGlobal = round( ($totalEstadodos)/count($totalEstadodos) , 2);
			$promCompet = round( ($totalEstadouno)/count($totalEstadouno) , 2);

			$cumplimiento = array(array( "nombre"=>"Incidencias Solucionadas","valor"=> $porcentajeToatl1),
			array( "nombre"=>"Incidencias En Revisión","valor"=> $porcentajeToatl2));
			$global = array("resueltas"=>$totalEstadodos,
				"total"=>$totalIncidencia,
				"revision"=>$totalEstadouno
			);
			$cumplimientoSeries = array( "series"=> $cumplimiento,
				"global"=>$global,
				"sistemasIncidencia"=>$sistemasIncidencia			
			);
			return $cumplimientoSeries;
		
     	}
		public function areas_incidencias_anio($anio){
			$this->autoRender = false;
			$this->loadModel("Area");
			$areasList = array();
			$areasQuery = $this->SistemasIncidencia->find("all", array(
				"fields"=>"DISTINCT SistemasIncidencia.area_id", 
				"recursive"=>-1,
				"conditions"=>array(
					"TO_CHAR(SistemasIncidencia.fecha_inicio,'YYYY')"=>$anio
				)
			));
			if(!empty($areasQuery)){
				foreach ($areasQuery as $areaId) {
					$areasId[] = $areaId["SistemasIncidencia"]["area_id"];
				}
				$areasList = $this->Area->find("list", array("fields"=>"Area.nombre", "conditions"=>array("Area.id"=>$areasId)));
			}
			return $areasList;
		}

	
	
}
