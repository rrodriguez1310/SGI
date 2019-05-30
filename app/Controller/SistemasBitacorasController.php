<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * SistemasBitacoras Controller
 *
 * @property SistemasBitacora $SistemasBitacora
 * @property PaginatorComponent $Paginator
 */
class SistemasBitacorasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function add(){
		
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
		$responsable = $this->SistemasBitacora->SistemasResponsable->findByUserId($this->Session->Read("PerfilUsuario.idUsuario"));
		if(empty($responsable)){
			$this->Session->setFlash('No puedes ingresar una bitacora', 'msg_fallo');
			return $this->redirect(array("controller"=>"dashboards",'action' => 'index'));
		}
	}

	public function index(){
		$this->set("layoutContent","container-fluid");
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
	}

	public function edit($id = null){
		$this->layout = "angular";
		$this->loadModel("SistemasResponsable");
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
		$this->SistemasBitacora->id = $id;
		if($this->SistemasBitacora->exists()){
			$responsableUsuario = $this->SistemasResponsable->findByUserId($this->Session->Read("PerfilUsuario.idUsuario"));
			if(!empty($responsableUsuario)){
				if($responsableUsuario["SistemasResponsable"]["admin"]!=1){
					if(!($this->SistemasBitacora->field("sistemas_responsable_id") == $responsableUsuario["SistemasResponsable"]["id"] && $this->SistemasBitacora->field("estado") == 1)){
						$this->Session->setFlash("No puedes editar esta bitacora", 'msg_fallo');
						return $this->redirect(array("controller"=>"sistemas_bitacoras",'action' => 'index'));		
					}
				}
			}else{
				$this->Session->setFlash("No puedes editar una bitacora", 'msg_fallo');
				return $this->redirect(array("controller"=>"sistemas_bitacoras",'action' => 'index'));
			}
		}else{
			$this->Session->setFlash("La bitacora solicitada no existe", 'msg_fallo');
			return $this->redirect(array("controller"=>"sistemas_bitacoras",'action' => 'index'));	
		}
	}

	public function view($id = null){
		
		$this->loadModel("User");
		$this->loadModel("Gerencia");
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
		$this->SistemasBitacora->id = $id;
		if(!$this->SistemasBitacora->exists()){
			$this->Session->setFlash("La bitacora solicitada no existe", 'msg_fallo');
			return $this->redirect(array("controller"=>"sistemas_bitacoras",'action' => 'index'));
		}
		$bitacora = $this->SistemasBitacora->findById($this->SistemasBitacora->id);
		$usuarioResponsable = $this->User->find("first", array("conditions"=>array("User.id"=>$bitacora["SistemasResponsable"]["user_id"]),"recursive"=>-1));
		$bitacora["SistemasResponsable"]["User"] = $usuarioResponsable["User"];
		$fecha_inicial = new DateTime($bitacora["SistemasBitacora"]["fecha_inicio"]);
		$fecha_termino = new DateTime($bitacora["SistemasBitacora"]["fecha_termino"]);
		$fecha_cierre = empty($bitacora["SistemasBitacora"]["fecha_cierre"]) ? null : new DateTime($bitacora["SistemasBitacora"]["fecha_cierre"]);
		$tiempo_estimado = $fecha_inicial->diff($fecha_termino);
		$bitacora["SistemasBitacora"]["tiempo_estimado"] = array(
			"dias"=>$tiempo_estimado->format("%d"),
			"horas"=>$tiempo_estimado->format("%h"),
			"minutos"=>$tiempo_estimado->format("%i"),
		);
		if(!empty($fecha_cierre)){
			$tiempo_real = $fecha_inicial->diff($fecha_cierre);
			$bitacora["SistemasBitacora"]["tiempo_real"] = array(
				"dias"=>$tiempo_real->format("%d"),
				"horas"=>$tiempo_real->format("%h"),
				"minutos"=>$tiempo_real->format("%i"),
			);
			$tiempo_diferencia = $fecha_termino->diff($fecha_cierre);
			$bitacora["SistemasBitacora"]["tiempo_diferencia"] = array(
				"dias"=>$tiempo_diferencia->format("%d"),
				"horas"=>$tiempo_diferencia->format("%h"),
				"minutos"=>$tiempo_diferencia->format("%i"),
			);
		}
		if(!empty($bitacora["SistemasBitacorasOb"])){
			foreach ($bitacora["SistemasBitacorasOb"] as $observacion) {
				$idUsuarios[] = $observacion["user_id"];
			}
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
		$gerencia = $this->Gerencia->find("first", array("conditions"=>array("Gerencia.id"=>$bitacora["Area"]["gerencia_id"]), "recursive"=>-1, "fields"=>"Gerencia.nombre"));
		$bitacora["Area"]["Gerencia"] = $gerencia["Gerencia"]["nombre"];
		$this->set("bitacora", $bitacora);
		if(isset($usuarios)){
			$this->set("usuarios", $usuarios);
		}
		$this->set("estados", array("Eliminado","En Proceso", "Cerrado"));
	}

	public function registrar_sistemas_bitacora(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("User");
		$this->loadModel("SistemasResponsable");
		$this->loadModel("Gerencia");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				if(isset($this->request->data["SistemasBitacora"]["id"])){
					$tipo = 2;
					$this->SistemasBitacora->id = $this->request->data["SistemasBitacora"]["id"];
					if($this->SistemasBitacora->exists()){
						$mensaje = array(
							"log"=>"Editar",
							"mensaje"=>"Se edito correctamente la bitacora"
						);
						$titulo = "Se realizo un cambio en la bitacora";
					}else{
						return $respuesta = array(
							"estado"=>0,
							"mensaje"=>"La bitacora no existe"
						);
					}					
				}else{
					$tipo = 1;
					$this->request->data["SistemasBitacora"]["user_id"] = $this->Session->Read("PerfilUsuario.idUsuario");
					$mensaje = array(
						"log"=>"Ingreso",
						"mensaje"=>"Se ingreso correctamente la bitacora"
					);
					$titulo = "Se registro una nueva bitacora";
				}
				if($this->SistemasBitacora->save($this->request->data)){
					CakeLog::write('actividad', $mensaje["log"].$this->SistemasBitacora->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash($mensaje["mensaje"], 'msg_exito');
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>$mensaje["mensaje"]
					);
					$this->SistemasResponsable->id = $this->request->data["SistemasBitacora"]["sistemas_responsable_id"];
					$usuario = $this->User->findById($this->SistemasResponsable->field("user_id"));
					$bitacora = $this->SistemasBitacora->findById($this->SistemasBitacora->id);
					$usuarioResponsable = $this->User->find("first", array("conditions"=>array("User.id"=>$bitacora["SistemasResponsable"]["user_id"]),"recursive"=>-1));
					$bitacora["SistemasResponsable"]["User"] = $usuarioResponsable["User"];
					$fecha_inicial = new DateTime($bitacora["SistemasBitacora"]["fecha_inicio"]);
					$fecha_termino = new DateTime($bitacora["SistemasBitacora"]["fecha_termino"]);
					$fecha_cierre = empty($bitacora["SistemasBitacora"]["fecha_cierre"]) ? null : new DateTime($bitacora["SistemasBitacora"]["fecha_cierre"]);
					$tiempo_estimado = $fecha_inicial->diff($fecha_termino);
					$bitacora["SistemasBitacora"]["tiempo_estimado"] = array(
						"dias"=>$tiempo_estimado->format("%d"),
						"horas"=>$tiempo_estimado->format("%h"),
						"minutos"=>$tiempo_estimado->format("%i"),
					);
					$this->Gerencia->id = $bitacora["Area"]["gerencia_id"];
					$bitacora["Gerencia"] = $this->Gerencia->field("nombre");
					$Email = new CakeEmail("gmail");
					$Email->from(array('sgi@cdf.cl' => 'SGI'));
					$Email->to(array('soporte@cdf.cl'));
					empty($usuario["Trabajadore"]["email"]) ? "" : $Email->cc($usuario["Trabajadore"]["email"]);
					$Email->subject(($tipo==1) ? "Registro de bitacora ".$bitacora["SistemasBitacora"]["titulo"] : "Edición de bitacora ".$bitacora["SistemasBitacora"]["titulo"]);
					$Email->emailFormat('html');
					$Email->template('sistemas_registrar_bitacora');
					$Email->viewVars(array(
						"titulo"=>($tipo==1) ? "SE HA GENERADO UNA REGISTRO DE BITACORA" : "SE EDITO LA SIGUENTE BITACORA",
						"bitacora"=>$bitacora,
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

	public function sistemas_bitacoras(){
		$this->autoRender = false;
		$this->response->type("json");
		$respuesta = array();
		if($this->Session->Read("Users.flag") == 1){
			$bitacoras = $this->SistemasBitacora->find("all", array(
				"recursive"=>-1
			));
			if(!empty($bitacoras)){
				foreach ($bitacoras as $bitacora) {
					$respuesta[] = array(
						"id"=>$bitacora["SistemasBitacora"]["id"],
						"fecha_inicio"=> DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["fecha_inicio"])->format('c'),
						"fecha_termino"=> DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["fecha_termino"])->format('c'),
						"fecha_cierre"=> empty($bitacora["SistemasBitacora"]["fecha_cierre"]) ? null : DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["fecha_cierre"])->format('c'),
						"titulo"=>$bitacora["SistemasBitacora"]["titulo"],
						"observacion_ingreso"=>$bitacora["SistemasBitacora"]["observacion_ingreso"],
						"observacion_termino"=>$bitacora["SistemasBitacora"]["observacion_termino"],
						"estado"=>$bitacora["SistemasBitacora"]["estado"],
						"user_id"=>$bitacora["SistemasBitacora"]["user_id"],
						"area_id"=>$bitacora["SistemasBitacora"]["area_id"],
						"sistemas_responsable_id"=>$bitacora["SistemasBitacora"]["sistemas_responsable_id"],
						"created"=> DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["created"])->format('c'),
						"modified"=> DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["modified"])->format('c'),
					);

				}
			}
		}
		return json_encode($respuesta);
	}

	public function sistemas_bitacoras_por_area(){
		$this->autoRender = false;
		$this->response->type("json");
		$respuesta = array();
		if($this->Session->Read("Users.flag") == 1){
			$bitacoras = $this->SistemasBitacora->find("all", array(
				"conditions"=>array(
					"SistemasBitacora.estado"=>1,
					"SistemasBitacora.area_id"=>$this->request->query["areaId"]
				),
				"recursive"=>-1
			));
			if(!empty($bitacoras)){
				foreach ($bitacoras as $bitacora) {
					$respuesta[] = array(
						"id"=>$bitacora["SistemasBitacora"]["id"],
						"fecha_inicio"=> DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["fecha_inicio"])->format('c'),
						"fecha_termino"=> DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["fecha_termino"])->format('c'),
						"fecha_cierre"=> empty($bitacora["SistemasBitacora"]["fecha_cierre"]) ? null : DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["fecha_cierre"])->format('c'),
						"titulo"=>$bitacora["SistemasBitacora"]["titulo"],
						"observacion_ingreso"=>$bitacora["SistemasBitacora"]["observacion_ingreso"],
						"observacion_termino"=>$bitacora["SistemasBitacora"]["observacion_termino"],
						"estado"=>$bitacora["SistemasBitacora"]["estado"],
						"user_id"=>$bitacora["SistemasBitacora"]["user_id"],
						"area_id"=>$bitacora["SistemasBitacora"]["area_id"],
						"sistemas_responsable_id"=>$bitacora["SistemasBitacora"]["sistemas_responsable_id"],
						"created"=> DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["created"])->format('c'),
						"modified"=> DateTime::createFromFormat('Y-m-d H:i:s', $bitacora["SistemasBitacora"]["modified"])->format('c'),
					);

				}
			}
		}
		return json_encode($respuesta);
	}

	public function sistemas_bitacora (){
		$this->autoRender = false;
		$this->response->type("json");
		$respuesta = array();
		$bitacoras = $this->SistemasBitacora->findById($this->request->query["id"]);
		if(!empty($bitacoras)){
			$respuesta = $bitacoras;
		}
		return json_encode($respuesta);
	}

	public function cerrar_bitacora($id = null){
		$this->layout = "angular";
		$this->loadModel("SistemasResponsable");
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
		$this->SistemasBitacora->id = $id;
		if($this->SistemasBitacora->exists()){
			$responsableUsuario = $this->SistemasResponsable->findByUserId($this->Session->Read("PerfilUsuario.idUsuario"));
			if(!empty($responsableUsuario)){
				if(!$responsableUsuario["SistemasResponsable"]["admin"]==1 ){
					if(!($this->SistemasBitacora->field("sistemas_responsable_id") == $responsableUsuario["SistemasResponsable"]["id"] && $this->SistemasBitacora->field("estado") == 1)){
						$this->Session->setFlash("No puedes ingresar el cierre de esta bitacora", 'msg_fallo');
						return $this->redirect(array("controller"=>"sistemas_bitacoras",'action' => 'index'));		
					}
				}
			}else{
				$this->Session->setFlash("No puedes ingresar el cierre de esta bitacora", 'msg_fallo');
				return $this->redirect(array("controller"=>"sistemas_bitacoras",'action' => 'index'));
			}
		}else{
			$this->Session->setFlash("La bitacora solicitada no existe", 'msg_fallo');
			return $this->redirect(array("controller"=>"sistemas_bitacoras",'action' => 'index'));	
		}
	}

	public function registro_cierre_bitacora(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("User");
		$this->loadModel("SistemasResponsable");
		$this->loadModel("Gerencia");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				$this->SistemasBitacora->id = $this->request->data["SistemasBitacora"]["id"];
				$bitacora = $this->SistemasBitacora->findById($this->SistemasBitacora->id);
				if(empty($bitacora["SistemasBitacora"]["fecha_cierre"])){
					$tipo = 1;
					$mensaje = array(
						"log"=>"Ingreso",
						"mensaje"=>"Se ingreso correctamente el cierre de la bitacora"
					);
				}else{
					$tipo = 2;
					$mensaje = array(
						"log"=>"Editar",
						"mensaje"=>"Se edito correctamente el cierre de la bitacora"
					);
				}
				if($this->SistemasBitacora->exists()){
					/*if(empty($this->request->data["SistemasBitacora"]["fecha_cierre"])){
						$fecha = new DateTime();
						$fecha->setTimezone(new DateTimeZone('America/Santiago'));
						$this->request->data["SistemasBitacora"]["fecha_cierre"] = $fecha->format("Y-m-d H:i:00");	
					}*/
					if($this->SistemasBitacora->save($this->request->data)){
						CakeLog::write('actividad',$mensaje["log"]." - registro_cierre_bitacora".$this->SistemasBitacora->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						$this->Session->setFlash($mensaje["mensaje"], 'msg_exito');
						$respuesta = array(
							"estado"=>1,
							"mensaje"=>$mensaje["mensaje"]
						);
						$bitacora = $this->SistemasBitacora->findById($this->SistemasBitacora->id);
						$this->SistemasResponsable->id = $bitacora["SistemasBitacora"]["sistemas_responsable_id"];
						$usuario = $this->User->findById($this->SistemasResponsable->field("user_id"));
						$usuarioResponsable = $this->User->find("first", array("conditions"=>array("User.id"=>$bitacora["SistemasResponsable"]["user_id"]),"recursive"=>-1));
						$bitacora["SistemasResponsable"]["User"] = $usuarioResponsable["User"];
						$fecha_inicial = new DateTime($bitacora["SistemasBitacora"]["fecha_inicio"]);
						$fecha_termino = new DateTime($bitacora["SistemasBitacora"]["fecha_termino"]);
						$fecha_cierre = empty($bitacora["SistemasBitacora"]["fecha_cierre"]) ? null : new DateTime($bitacora["SistemasBitacora"]["fecha_cierre"]);
						$tiempo_estimado = $fecha_inicial->diff($fecha_termino);
						$bitacora["SistemasBitacora"]["tiempo_estimado"] = array(
							"dias"=>$tiempo_estimado->format("%d"),
							"horas"=>$tiempo_estimado->format("%h"),
							"minutos"=>$tiempo_estimado->format("%i"),
						);
						if(!empty($fecha_cierre)){
							$tiempo_real = $fecha_inicial->diff($fecha_cierre);
							$bitacora["SistemasBitacora"]["tiempo_real"] = array(
								"dias"=>$tiempo_real->format("%d"),
								"horas"=>$tiempo_real->format("%h"),
								"minutos"=>$tiempo_real->format("%i"),
							);
							$tiempo_diferencia = $fecha_termino->diff($fecha_cierre);
							$bitacora["SistemasBitacora"]["tiempo_diferencia"] = array(
								"dias"=>$tiempo_diferencia->format("%d"),
								"horas"=>$tiempo_diferencia->format("%h"),
								"minutos"=>$tiempo_diferencia->format("%i"),
							);
						}
						$this->Gerencia->id = $bitacora["Area"]["gerencia_id"];
						$bitacora["Gerencia"] = $this->Gerencia->field("nombre");
						$Email = new CakeEmail("gmail");
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to(array('soporte@cdf.cl'));
						empty($usuario["Trabajadore"]["email"]) ? "" : $Email->cc($usuario["Trabajadore"]["email"]);
						$Email->subject(($tipo == 1) ? "Ingreso cierre bitacora ".$bitacora["SistemasBitacora"]["titulo"] : "Edición cierre bitacora ".$bitacora["SistemasBitacora"]["titulo"]);
						$Email->emailFormat('html');
						$Email->template('sistemas_registrar_cierre');
						$Email->viewVars(array(
							"bitacora"=>$bitacora,
							"titulo"=>($tipo==1) ? "SE INGRESO CIERRE DE BITACORA" : "SE EDITO CIERRE DE BITACORA" 
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

	public function observaciones_bitacora($id = null){
		$this->layout = "angular";
		$this->loadModel("SistemasResponsable");
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
		$this->SistemasBitacora->id = $id;
		if($this->SistemasBitacora->exists()){
			$responsableUsuario = $this->SistemasResponsable->findByUserId($this->Session->Read("PerfilUsuario.idUsuario"));
			if(!empty($responsableUsuario)){
				if(!$responsableUsuario["SistemasResponsable"]["admin"]==1 ){
					if(!($this->SistemasBitacora->field("sistemas_responsable_id") == $responsableUsuario["SistemasResponsable"]["id"] && $this->SistemasBitacora->field("estado") == 1)){
						$this->Session->setFlash("No puedes ingresar el cierre de esta bitacora", 'msg_fallo');
						return $this->redirect(array("controller"=>"sistemas_bitacoras",'action' => 'index'));		
					}
				}
			}else{
				$this->Session->setFlash("No puedes ingresar el cierre de esta bitacora", 'msg_fallo');
				return $this->redirect(array("controller"=>"sistemas_bitacoras",'action' => 'index'));
			}
		}else{
			$this->Session->setFlash("La bitacora solicitada no existe", 'msg_fallo');
			return $this->redirect(array("controller"=>"sistemas_bitacoras",'action' => 'index'));	
		}
	}

	public function registro_observacion_bitacora(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("SistemasBitacorasOb");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				$this->SistemasBitacora->id = $this->request->data["SistemasBitacorasOb"]["sistemas_bitacora_id"];
				if($this->SistemasBitacora->exists()){
					$this->request->data["SistemasBitacorasOb"]["user_id"] = $this->Session->Read("PerfilUsuario.idUsuario");
					if($this->SistemasBitacorasOb->save($this->request->data)){
						CakeLog::write('actividad',"Ingreso - registro_observacion_bitacora".$this->SistemasBitacorasOb->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
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

	public function reportes(){
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
	}

	public function data_reporte(){
		$this->autoRender = false;
		$this->response->type("json");
		$respuesta["reporte_ingresos_cierres"] = $this->reporte_ingresos_cierres();
		return json_encode($respuesta);
	}

	public function reporte_ingresos_cierres(){

		setlocale(LC_ALL,"es_ES");
		$this->loadModel("SistemasResponsable");
		$this->SistemasResponsable->Behaviors->load('Containable');
		$sistemasResponsables = $this->SistemasResponsable->find("all", array(
			"contain"=>"User", 
			"conditions"=>array(
				"SistemasResponsable.estado"=>1
			),
			"fields"=>array(
				"SistemasResponsable.id",
				"SistemasResponsable.admin",
				"User.nombre"
			)
		));
		for ($i=1; $i <= 12 ; $i++) {
			$respuesta["meses"][] = array(
				"mes"=>$i,
				"nombre"=>strftime("%B",mktime(0,0,0,$i,1,2000))
			);
		}
		if(!empty($sistemasResponsables)){
			foreach ($sistemasResponsables as $sistemasResponsable) {
				$respuesta["responsables"][$sistemasResponsable["SistemasResponsable"]["id"]] = array(
					"nombre"=>$sistemasResponsable["User"]["nombre"],
					"admin"=>$sistemasResponsable["SistemasResponsable"]["admin"]
				);
				$resonsablesId[] = $sistemasResponsable["SistemasResponsable"]["id"];
			}
		}
		$bitacoras = $this->SistemasBitacora->find("all", array(
			"conditions"=>array(
				"SistemasBitacora.sistemas_responsable_id"=>$resonsablesId
			),
			"fields"=>array(
				"SistemasBitacora.fecha_inicio",
				"SistemasBitacora.fecha_cierre",
				"SistemasBitacora.sistemas_responsable_id"
			),
			"recursive"=>-1
		));
		if(!empty($bitacoras)){
			foreach ($bitacoras as $bitacora) {
				$fechaInicio = new DateTime($bitacora["SistemasBitacora"]["fecha_inicio"]);
				$fechaCierre = new DateTime($bitacora["SistemasBitacora"]["fecha_cierre"]);
				$bitacorasAgrupResponIni[$fechaInicio->format("Y")][$bitacora["SistemasBitacora"]["sistemas_responsable_id"]][$fechaInicio->format("n")][] = $bitacora["SistemasBitacora"]["sistemas_responsable_id"];
				$bitacorasAgrupResponCierre[$fechaCierre->format("Y")][$bitacora["SistemasBitacora"]["sistemas_responsable_id"]][$fechaCierre->format("n")][] = $bitacora["SistemasBitacora"]["sistemas_responsable_id"];
				$anios[] = $fechaInicio->format("Y");
				$anios[] = $fechaCierre->format("Y");
			}
			if(!empty($anios)){
				$anioMinimo  = (int)min($anios);
				$anioMaximo  = (int)max($anios);
				if($anioMinimo == $anioMaximo){
					$respuesta["anios"][] = $anioMinimo;
				}else{
					for ($i=$anioMinimo; $i <= $anioMaximo; $i++) { 
						$respuesta["anios"][] = $i;
					}	
				}
			}
			if(!empty($bitacorasAgrupResponIni)){
				foreach ($bitacorasAgrupResponIni as $anio => $responsablesArray) {
					foreach ($responsablesArray as $idResponsable => $meses) {
						$respuesta["inicio"]["total"][$anio][$idResponsable] = 0;
						foreach ($meses as $mes => $data) {
							$respuesta["inicio"]["valores"][$anio][$idResponsable][$mes] = count($data);
							if(isset($respuesta["inicio"]["total"][$anio][$idResponsable])){
								$respuesta["inicio"]["total"][$anio][$idResponsable] += $respuesta["inicio"]["valores"][$anio][$idResponsable][$mes];
							}
						}
					}
				}
			}
			if(!empty($bitacorasAgrupResponCierre)){
				foreach ($bitacorasAgrupResponCierre as $anio => $responsablesArray) {
					foreach ($responsablesArray as $idResponsable => $meses) {
						$respuesta["cierre"]["total"][$anio][$idResponsable] = 0;
						foreach ($meses as $mes => $data) {
							$respuesta["cierre"]["valores"][$anio][$idResponsable][$mes] = count($data);
							if(isset($respuesta["cierre"]["total"][$anio][$idResponsable])){
								$respuesta["cierre"]["total"][$anio][$idResponsable] += $respuesta["inicio"]["valores"][$anio][$idResponsable][$mes];
							}
						}
					}
				}
			}
		}
		return $respuesta;
	}

	public function reporte_area_por_anio_json(){
		$this->autoRender = false;
		$this->response->type("json");
		return json_encode($this->reporte_area_por_anio($this->request->query["anio"], $this->request->query["area"]));
	}

	/*public function areas_bitacoras(){
		$this->autoRender = false;
		$this->loadModel("Area");
		$areasBitacoras = $this->SistemasBitacora->find("list", array("fields"=>"SistemasBitacora.area_id"));
		$areas = $this->Area->find("list", array(
			"fields"=>"Area.nombre",
			"conditions"=>array(
				"Area.id"=>array_unique($areasBitacoras)
			),
			"order"=>"Area.nombre"
		));
		return $areas;
	}*/

	public function reporte_area_por_anio($anio, $area){
		$this->autoRender = false;
		$this->loadModel("Trabajadore");
		$this->Trabajadore->virtualFields['nombre_completo'] = "(Trabajadore.nombre || ' ' || Trabajadore.apellido_paterno)";
		$bitacorasQuery = $this->SistemasBitacora->find("all",array(
			"conditions"=>array(
				"SistemasBitacora.area_id"=>$area,
				"TO_CHAR(SistemasBitacora.fecha_inicio,'YYYY')"=>$anio
			),
			"fields"=>array(
				"SistemasBitacora.trabajadore_id",
				"SistemasBitacora.fecha_inicio"
			),
			"recursive"=>-1
		));
		if(!empty($bitacorasQuery)){
			foreach ($bitacorasQuery as $bitacora) {
				$fecha_inicio = new DateTime($bitacora["SistemasBitacora"]["fecha_inicio"]);
				$trabajadores[] = $bitacora["SistemasBitacora"]["trabajadore_id"];
				$agrupadosPorMes[$fecha_inicio->format("n")][$bitacora["SistemasBitacora"]["trabajadore_id"]][] = $bitacora["SistemasBitacora"]["trabajadore_id"];
				$total[] = $bitacora;
			}
			$trabajadores = array_unique($trabajadores);
			$respuesta["trabajadores"] = $this->Trabajadore->find("list", array(
				"conditions"=>array(
					"Trabajadore.id"=>$trabajadores
				),
				"fields"=>"Trabajadore.nombre_completo",
				"order"=>"Trabajadore.nombre_completo"
			));
			if(!empty($agrupadosPorMes)){
				$respuesta["data"]["total"] = count($total);
				foreach ($agrupadosPorMes as $mes => $trabajadores) {
					foreach ($trabajadores as $idTrabajador => $trabajador) {
						isset($respuesta["data"]["meses"][$mes]["total"]) ? $respuesta["data"]["meses"][$mes]["total"]+=count($trabajador) : $respuesta["data"]["meses"][$mes]["total"] = count($trabajador);
						empty($idTrabajador) ? $respuesta["data"]["meses"][$mes]["trabajadores"][0] = count($trabajador) : $respuesta["data"]["meses"][$mes]["trabajadores"][$idTrabajador] = count($trabajador);
					}
				}
			}
		}else{
			$respuesta = array();	
		}
		return $respuesta;
	}
	public function areas_bitacoras_anio_json(){
		$this->autoRender = false;
		$this->response->type("json");
		return json_encode(isset($this->request->query["anio"]) ? $this->areas_bitacoras_anio($this->request->query["anio"]) : array());
	}

	public function areas_bitacoras_anio($anio){
		$this->autoRender = false;
		$this->loadModel("Area");
		$areasList = array();
		$areasQuery = $this->SistemasBitacora->find("all", array(
			"fields"=>"DISTINCT SistemasBitacora.area_id", 
			"recursive"=>-1,
			"conditions"=>array(
				"TO_CHAR(SistemasBitacora.fecha_inicio,'YYYY')"=>$anio
			)
		));
		if(!empty($areasQuery)){
			foreach ($areasQuery as $areaId) {
				$areasId[] = $areaId["SistemasBitacora"]["area_id"];
			}
			$areasList = $this->Area->find("list", array("fields"=>"Area.nombre", "conditions"=>array("Area.id"=>$areasId)));
		}
		return $areasList;
	}
}
