<?php
App::uses('AppController', 'Controller');
App::uses('SoportesController', 'Controller');
App::uses('FormatosController', 'Controller');
App::uses('CopiasController', 'Controller');
App::uses('EquiposController', 'Controller');
App::uses('CampeonatosController', 'Controller');
App::uses('CatalogacionRTiposController', 'Controller');
App::uses('CatalogacionRTagsTiposController', 'Controller');
App::uses('IngestaServidoresController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * CatalogacionRequerimientos Controller
 *
 * @property CatalogacionRequerimiento $CatalogacionRequerimiento
 * @property PaginatorComponent $Paginator
 */
class CatalogacionRequerimientosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'RequestHandler');

	public function index(){
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
	}

	public function edit($id = null){
		$this->layout = "angular";
		$this->loadModel("CatalogacionRResponsable");
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
		$this->CatalogacionRequerimiento->id = $id;
		if($this->CatalogacionRequerimiento->exists()){
			$requerimiento = $this->CatalogacionRequerimiento->findById($this->CatalogacionRequerimiento->id);
			if($requerimiento["CatalogacionRequerimiento"]["estado"]==0 || $requerimiento["CatalogacionRequerimiento"]["estado"]==4){
				$this->Session->setFlash('No se puede editar el requerimiento', 'msg_fallo');
				return $this->redirect(array("controller"=>"catalogacion_requerimientos",'action' => 'index'));
			}

			$responsable = $this->CatalogacionRResponsable->findByUserId($this->Session->Read("PerfilUsuario.idUsuario"));
			if(!empty($responsable)){
				if($responsable["CatalogacionRResponsable"]["tipo"] == 1 || $requerimiento["CatalogacionRequerimiento"]["user_id"] == $this->Session->Read("PerfilUsuario.idUsuario")){
					
				}else{
					$this->Session->setFlash('No puedes editar este requerimiento', 'msg_fallo');
					return $this->redirect(array("controller"=>"catalogacion_requerimientos",'action' => 'index'));
				}
			}
		}
	}

	public function batch_requerimiento($id = null){
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

	public function view($id = null){
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

	public function registrar_catalogacion_requerimiento(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("User");
		$this->loadModel("Soporte");
		$this->loadModel("Formato");
		$this->loadModel("Copia");
		$this->loadModel("CatalogacionRTagsTipo");
		$this->loadModel("CatalogacionRTipo");
		$this->loadModel("IngestaServidore");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				if(isset($this->request->data["CatalogacionRequerimiento"]["id"])){
					$tipo = 2;
					$mensaje = array(
						"log"=>'Editar - CatalogacionRequerimientos - registrar_catalogacion_requerimiento - ',
						"mensaje"=>"Requerimiento actualizado correctamente"
					);
					$requerimiento = $this->CatalogacionRequerimiento->findById($this->request->data["CatalogacionRequerimiento"]["id"]);
					if(!empty($requerimiento)){
						if(isset($this->request->data["CatalogacionRDigitale"])){
							if(!empty($requerimiento["CatalogacionRFisico"]["id"])){
								$this->request->data["CatalogacionRFisico"]["id"] = $requerimiento["CatalogacionRFisico"]["id"];
								$this->request->data["CatalogacionRFisico"]["estado"] = 0;
							}
							if(!empty($requerimiento["CatalogacionRDigitale"]["id"])){
								$this->request->data["CatalogacionRDigitale"]["id"] = $requerimiento["CatalogacionRDigitale"]["id"];
								$this->request->data["CatalogacionRDigitale"]["estado"] = 1;
							}
						}else{
							if(!empty($requerimiento["CatalogacionRDigitale"]["id"])){
								$this->request->data["CatalogacionRDigitale"]["id"] = $requerimiento["CatalogacionRDigitale"]["id"];
								$this->request->data["CatalogacionRDigitale"]["estado"] = 0;
							}
							if(!empty($requerimiento["CatalogacionRFisico"]["id"])){
								$this->request->data["CatalogacionRFisico"]["id"] = $requerimiento["CatalogacionRFisico"]["id"];
								$this->request->data["CatalogacionRFisico"]["estado"] = 1;
							}
						}
					}
				}else{
					$tipo = 1;
					$this->request->data["CatalogacionRequerimiento"]["user_id"] = $this->Session->Read("PerfilUsuario.idUsuario");
					$mensaje = array(
						"log"=>'Ingresar - CatalogacionRequerimientos - registrar_catalogacion_requerimiento - ',
						"mensaje"=>"Requerimiento ingresado correctamente"
					);
				}
				if($this->CatalogacionRequerimiento->saveAll($this->request->data, array("deep"=>true))){
					CakeLog::write('actividad', $mensaje["log"].$this->CatalogacionRequerimiento->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash($mensaje["mensaje"], 'msg_exito');
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>$mensaje["mensaje"]
					);
					$usuario = $this->User->findById($this->Session->Read("PerfilUsuario.idUsuario"));
					$requerimiento = $this->CatalogacionRequerimiento->findById($this->CatalogacionRequerimiento->id);
					if($tipo == 1){
						$Email = new CakeEmail("gmail");
						$Email->from(array('no-reply@cdf.cl' => 'SGI'));
						$Email->to(array('bibliotecologos@cdf.cl', 'INGESTA@cdf.cl', 'ingestacf@cdf.cl'));
						empty($usuario["Trabajadore"]["email"]) ? "" : $Email->cc($usuario["Trabajadore"]["email"]);
						$Email->subject("Registro requerimiento imagenes");
						$Email->emailFormat('html');
						$Email->template('catalogacion_registrar_requerimiento');
						$Email->viewVars(array(
							"requerimiento"=>$requerimiento,
							"soportes"=>$this->Soporte->find("list", array("fields"=>array("Soporte.id", "Soporte.nombre"))),
							"formatos"=>$this->Formato->find("list", array("fields"=>array("Formato.id", "Formato.nombre"))),
							"copias"=>$this->Copia->find("list", array("fields"=>array("Copia.id", "Copia.copia"))),
							"tagstipos"=>$this->CatalogacionRTagsTipo->find("list", array("fields"=>array("CatalogacionRTagsTipo.id", "CatalogacionRTagsTipo.nombre"))),
							"tipos"=>$this->CatalogacionRTipo->find("list", array("fields"=>array("CatalogacionRTipo.id", "CatalogacionRTipo.nombre"))),
							"servidores"=>$this->IngestaServidore->find("list", array("fields"=>array("IngestaServidore.id", "IngestaServidore.nombre")))
						));
						$Email->send();
					}
					
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

	public function selects_para_requerimientos(){
		$this->autoRender = false;
		$this->response->type("json");
		$soportes = new SoportesController;
		$formatos = new FormatosController;
		$copias = new CopiasController;
		$equipos = new EquiposController;
		$campeonatos = new CampeonatosController;
		$requerimietos_tipos = new CatalogacionRTiposController;
		$tags_tipos = new CatalogacionRTagsTiposController;
		$ingesta_servidores = new IngestaServidoresController;
		$select["soportes"] = json_decode($soportes->soportes_list());
		$select["formatos"] = json_decode($formatos->formatos_list());
		$select["copias"] = json_decode($copias->copias_list());
		$select["equipos"] = json_decode($equipos->equipos_list());
		$select["campeonatos"] = json_decode($campeonatos->campeonatos_list());
		$select["requerimietos_tipos"] = json_decode($requerimietos_tipos->requerimientos_tipos_list());
		$select["tags_tipos"] = json_decode($tags_tipos->tags_tipos_list());
		$select["ingesta_servidores"] = json_decode($ingesta_servidores->ingesta_servidores_list());
		return json_encode($select);
	}

	public function catalogacion_requerimientos(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->CatalogacionRequerimiento->Behaviors->load('Containable');
		$this->CatalogacionRequerimiento->contain('CatalogacionRTag');
		$catalogacionRequerimientos = $this->CatalogacionRequerimiento->find("all", array("recursive"=>-1));
		if(!empty($catalogacionRequerimientos)){
			foreach ($catalogacionRequerimientos as $catalogacionRequerimiento) {
				$fechaEntrega = new DateTime($catalogacionRequerimiento["CatalogacionRequerimiento"]["fecha_entrega"]);
				$fechaCreate = new DateTime($catalogacionRequerimiento["CatalogacionRequerimiento"]["created"]);
				$catalogacionRequerimiento["CatalogacionRequerimiento"]["fecha_entrega"] = $fechaEntrega->format("c");
				$catalogacionRequerimiento["CatalogacionRequerimiento"]["created"] = $fechaCreate->format("c");
				$respuestaRequerimientos[] = $catalogacionRequerimiento;

			}
			$respuesta = array(
				"estado"=>1,
				"data"=>$respuestaRequerimientos
			);
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No existen requerimientos"
			);
		}
		return json_encode($respuesta);
	}

	public function catalogacion_requerimientos_usuario(){
		$this->autoRender = false;
		$this->CatalogacionRequerimiento->Behaviors->load('Containable');
		$this->CatalogacionRequerimiento->contain('CatalogacionRTag');
		$catalogacionRequerimientos = $this->CatalogacionRequerimiento->findAllByUserId($this->request->query["id"]);
		if(!empty($catalogacionRequerimientos)){
			foreach ($catalogacionRequerimientos as $catalogacionRequerimiento) {
				$fechaEntrega = new DateTime($catalogacionRequerimiento["CatalogacionRequerimiento"]["fecha_entrega"]);
				$fechaCreate = new DateTime($catalogacionRequerimiento["CatalogacionRequerimiento"]["created"]);
				$catalogacionRequerimiento["CatalogacionRequerimiento"]["fecha_entrega"] = $fechaEntrega->format("c");
				$catalogacionRequerimiento["CatalogacionRequerimiento"]["created"] = $fechaCreate->format("c");
				$respuestaRequerimientos[] = $catalogacionRequerimiento;

			}
			$respuesta = array(
				"estado"=>1,
				"data"=>$respuestaRequerimientos
			);
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No existen requerimientos"
			);
		}
		return json_encode($respuesta);
	}

	public function catalogacion_requerimiento(){
		$this->autoRender = false;
		if($this->request->query["id"]){
			$requerimiento = $this->CatalogacionRequerimiento->findById($this->request->query["id"]);
			if(!empty($requerimiento)){
				$fecha_entrega = new DateTime($requerimiento["CatalogacionRequerimiento"]["fecha_entrega"]);
				$creado = new DateTime($requerimiento["CatalogacionRequerimiento"]["created"]);
				$requerimiento["CatalogacionRequerimiento"]["fecha_entrega"] =  $fecha_entrega->format("c");
				$requerimiento["CatalogacionRequerimiento"]["created"] =  $creado->format("c");
				$respuesta = array(
					"estado"=>1,
					"data"=>$requerimiento
				);
			}
			
		}
		return json_encode($respuesta);
	}

	public function registrar_asignar_responsable(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("User");
		$this->loadModel("Soporte");
		$this->loadModel("Formato");
		$this->loadModel("Copia");
		$this->loadModel("CatalogacionRTagsTipo");
		$this->loadModel("CatalogacionRTipo");
		$this->loadModel("IngestaServidore");
		$this->loadModel("CatalogacionRResponsable");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				$requerimiento = $this->CatalogacionRequerimiento->findById($this->request->data["CatalogacionRequerimiento"]["id"]);
				if(!empty($requerimiento["CatalogacionRequerimiento"]["catalogacion_r_responsable_id"])){
					$mensaje = array(
						"log"=>'Editar - CatalogacionRequerimientos - registrar_asignar_responsable - ',
						"mensaje"=>"Requerimiento actualizado correctamente"
					);
					/// programar logica editar


					////
				}else{
					$mensaje = array(
						"log"=>'Ingresar - CatalogacionRequerimientos - registrar_asignar_responsable - ',
						"mensaje"=>"Se ingreso correctamente el responsable"
					);
				}
				if($this->CatalogacionRequerimiento->save($this->request->data)){
					CakeLog::write('actividad', $mensaje["log"].$this->CatalogacionRequerimiento->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>$mensaje["mensaje"]
					);
					$adminResponsables = $this->CatalogacionRResponsable->find("list", array("conditions"=>array("CatalogacionRResponsable.estado"=>1,"CatalogacionRResponsable.admin"=>1), "recursive"=>-1, "fields"=>array("CatalogacionRResponsable.user_id")));
					$adminUserId = array_values($adminResponsables);
					$usuariosParaCorreos = $this->User->find("all", array("conditions"=>array("User.id"=>$adminUserId), "fields"=>array("Trabajadore.email")));
					foreach ($usuariosParaCorreos as $usuariosParaCorreo) {
						$correosAdmin[] = $usuariosParaCorreo["Trabajadore"]["email"];
					}
					$requerimiento = $this->CatalogacionRequerimiento->findById($this->CatalogacionRequerimiento->id);
					$usuario = $this->User->findById($requerimiento["CatalogacionRResponsable"]["user_id"]);
					$Email = new CakeEmail("gmail");
					$Email->from(array('sgi@cdf.cl' => 'SGI'));
					$Email->to($correosAdmin);
					empty($usuario["Trabajadore"]["email"]) ? "" : $Email->cc($usuario["Trabajadore"]["email"]);
					$Email->subject("Asignación responsable requerimiento imagenes");
					$Email->emailFormat('html');
					$Email->template('catalogacion_responsable_requerimiento');
					$Email->viewVars(array(
						"requerimiento"=>$requerimiento,
						"soportes"=>$this->Soporte->find("list", array("fields"=>array("Soporte.id", "Soporte.nombre"))),
						"formatos"=>$this->Formato->find("list", array("fields"=>array("Formato.id", "Formato.nombre"))),
						"copias"=>$this->Copia->find("list", array("fields"=>array("Copia.id", "Copia.copia"))),
						"tagstipos"=>$this->CatalogacionRTagsTipo->find("list", array("fields"=>array("CatalogacionRTagsTipo.id", "CatalogacionRTagsTipo.nombre"))),
						"tipos"=>$this->CatalogacionRTipo->find("list", array("fields"=>array("CatalogacionRTipo.id", "CatalogacionRTipo.nombre"))),
						"usuarios"=>$this->User->find("list", array("fields"=>array("User.id", "User.nombre"))),
						"servidores"=>$this->IngestaServidore->find("list", array("fields"=>array("IngestaServidore.id", "IngestaServidore.nombre")))
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
				"mensaje"=>"Perdio la sesión, por favor intentelo nuevamente"
			);
		}
		return json_encode($respuesta);
	}

	public function requerimientos_usuario_o_responsable(){
		$this->autoRender = false;
		if($this->Session->Read("Users.flag") == 1){
			$this->CatalogacionRequerimiento->Behaviors->load('Containable');
			$this->CatalogacionRequerimiento->contain('CatalogacionRTag');
			$catalogacionRequerimientos = $this->CatalogacionRequerimiento->findAllByUserIdOrCatalogacionRResponsableId($this->request->query["usuarioId"],$this->request->query["responsableId"]);
			if(!empty($catalogacionRequerimientos)){
				foreach ($catalogacionRequerimientos as $catalogacionRequerimiento) {
					$fechaEntrega = new DateTime($catalogacionRequerimiento["CatalogacionRequerimiento"]["fecha_entrega"]);
					$catalogacionRequerimiento["CatalogacionRequerimiento"]["fecha_entrega"] = $fechaEntrega->format("c");
					$respuestaRequerimientos[] = $catalogacionRequerimiento;
				}
				$respuesta = array(
					"estado"=>1,
					"data"=>$respuestaRequerimientos
				);
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No existen requerimientos"
				);
			}
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdio la sesión, por favor intentelo nuevamente"
			);
		}
		return json_encode($respuesta);
	}

	public function batch_ingesta($id = null){

		$this->CatalogacionRequerimiento->id = $id;
		if($this->CatalogacionRequerimiento->exists()){
			$requerimiento = $this->CatalogacionRequerimiento->findById($this->CatalogacionRequerimiento->id);
		}
		$contenido = "name\tin\tout\treel\r\n";
		foreach ($requerimiento["CatalogacionRIngesta"] as $ingesta) {
			($ingesta["estado"] == 1 ) ? $contenido.=$ingesta["nombre"]."\t".$ingesta["entrada"]."\t".$ingesta["salida"]."\t".$ingesta["reel"]."\r\n" : "";
		}
		$archivo = fopen(WWW_ROOT."files/catalogacion_requerimientos/batch.txt", "w+");
		fwrite($archivo, $contenido);
		fclose($archivo);
		$this->response->file(WWW_ROOT."files/catalogacion_requerimientos/batch.txt", array('download' => true));
		return $this->response;
	}

	public function terminar_requerimiento(){
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

	public function registrar_termino_requerimiento(){
		$this->autoRender = false;
		$this->response->type("json");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				if($this->CatalogacionRequerimiento->save($this->request->data)){
					CakeLog::write('actividad', "Termino requerimiento - CatalogacionRequerimientos - registrar_termino_requerimiento - ".$this->CatalogacionRequerimiento->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash("Se cambio el requerimiento a terminado correctamente", 'msg_exito');
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"Se cambio el requerimiento a terminado correctamente"
					);
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
				"mensaje"=>"Perdio la sesión, por favor intentelo nuevamente"
			);
		}
		return json_encode($respuesta);
	}

	public function registrar_batch_requerimiento(){
		$this->autoRender = false;
		$this->response->type("json");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				if($this->CatalogacionRequerimiento->saveAll($this->request->data, array("deep"=>true))){
					CakeLog::write('actividad', "Registrar batch requerimiento - CatalogacionRequerimientos - registrar_batch_requerimiento - ".$this->CatalogacionRequerimiento->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash("Se adjunto batch correctamente al requerimiento", 'msg_exito');
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"Se adjunto batch correctamente al requerimiento"
					);
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
				"mensaje"=>"Perdio la sesión, por favor intentelo nuevamente"
			);
		}
		return json_encode($respuesta);
	}

	public function eliminar_requerimiento(){
		$this->autoRender = false;
		$this->response->type("json");
		if($this->Session->Read("Users.flag") == 1){
			if($this->request->isPost()){
				if($this->CatalogacionRequerimiento->save($this->request->data)){
					CakeLog::write('actividad', "Eliminar - CatalogacionRequerimientos - eliminar_requerimiento - ".$this->CatalogacionRequerimiento->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"Se elimino correctamente al requerimiento"
					);
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
				"mensaje"=>"Perdio la sesión, por favor intentelo nuevamente"
			);
		}
		return json_encode($respuesta);
	}
}
