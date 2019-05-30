<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
App::uses('LocalizacionesController', 'Controller');
App::uses('ComunasController', 'Controller');
App::uses('NacionalidadesController', 'Controller');
App::uses('SistemaPensionesController', 'Controller');
App::uses('SistemaPrevisionesController', 'Controller');
App::uses('TiposMonedasController', 'Controller');
App::uses('NivelEducacionsController', 'Controller');
App::uses('BancosController', 'Controller');
App::uses('TiposCuentaBancosController', 'Controller');
App::uses('GerenciasController', 'Controller');
App::uses('AreasController', 'Controller');
App::uses('CargosController', 'Controller');
App::uses('HorariosController', 'Controller');
App::uses('TipoContratosController', 'Controller');
App::uses('DimensionesController', 'Controller');
App::uses('TiposDocumentosController', 'Controller');
App::uses('MotivoRetirosController', 'Controller');
App::uses('EstadosCivilesController', 'Controller');
App::uses('CakeEmail', 'Network/Email');


class TrabajadoresController extends AppController {
	public $components = array('RequestHandler');
	
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
		CakeLog::write('actividad', 'Visito - Trabajadores - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

	public function add() {
		
		$this->layout = "angular";
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if ($this->Session->read('Users.flag') == 1) {
			/*
			if ($this->request->is(array('post', 'put'))) {
				if($this->request->data["Trabajadore"]["fecha_nacimiento"]!="")
				{
					$this->request->data["Trabajadore"]["fecha_nacimiento"] = DateTime::createFromFormat('d/m/Y', $this->request->data["Trabajadore"]["fecha_nacimiento"])->format('Y-m-d');
				}
				if($this->request->data["Trabajadore"]["fecha_ingreso"] != "")
				{
					$this->request->data["Trabajadore"]["fecha_ingreso"] = DateTime::createFromFormat('d/m/Y', $this->request->data["Trabajadore"]["fecha_ingreso"])->format('Y-m-d');
				}
				if ($this->Trabajadore->save($this->request->data)) {
				$this->loadModel("ActividadUsuario");
				$usuario = $this->Session->read("PerfilUsuario.idUsuario");
				$mensaje = 'Se crea trabajador "'.$this->request->data["Trabajadore"]["rut"].'" con ID '.$this->Trabajadore->id;
				$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
				$this->ActividadUsuario->save($log);
				$this->Session->setFlash('El trabajador fue ingresada correctamente', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('El trabajador no fue agregado', 'msg_fallo');
				}
			}
			$this->loadModel("Gerencia");
			$gerencias = $this->Gerencia->find('list', array('fields' => array('Gerencia.id', 'Gerencia.nombre'), 'order'=>'Gerencia.nombre ASC', "conditions"=>array("Gerencia.estado"=>1)));
			
			$gerencias = array(''=>'')+$gerencias;

			$this -> set('gerencias', $gerencias);

			$this->loadModel("Area");
			
			$areas = $this->Area->find('list', array('fields' => array('Area.id', 'Area.nombre'), 'order'=>'Area.nombre ASC', "conditions"=>array("Area.estado"=>1)));
			
			$areas = array(''=>'')+$areas;

			$this -> set('areas', $areas); 
			$this->loadModel("Cargo");
			$cargos = $this->Cargo->find('list', array('fields' => array('Cargo.id', 'Cargo.nombre'), 'order'=>'Cargo.nombre ASC', "conditions"=>array("Cargo.estado"=>1)));
			
			$cargos = array(''=>'')+$cargos;

			$this -> set('cargos', $cargos);
			
			$this->set('estados', array('Activo'=>"Activo",'Prospecto'=>"Prospecto"));*/
		} else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

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
		CakeLog::write('actividad', 'Visito - Trabajadores - edit - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		$this->set("id", $id);
	}

	public function editar_trabajador(){
		$this->layout = "ajax";
		$this->loadModel("Jefe");
		$this->loadModel("CuentasCorriente");
		$this->Trabajadore->id = $this->request->data["Trabajadore"]["id"];
		if($this->Trabajadore->exists()){
			unset($this->request->data["Trabajadore"]["created"]);
			unset($this->request->data["Trabajadore"]["modified"]);
			empty($this->request->data["Trabajadore"]["fecha_nacimiento"]) ? '' : $this->request->data["Trabajadore"]["fecha_nacimiento"] = DateTime::createFromFormat('d/m/Y', $this->request->data["Trabajadore"]["fecha_nacimiento"])->format('Y-m-d');
			empty($this->request->data["Trabajadore"]["fecha_ingreso"]) ? '' : $this->request->data["Trabajadore"]["fecha_ingreso"] = DateTime::createFromFormat('d/m/Y', $this->request->data["Trabajadore"]["fecha_ingreso"])->format('Y-m-d');
			if(!empty($this->request->data["Trabajadore"]["jefe_id"])){
				$jefe = $this->Jefe->find("first", array("conditions"=>array("Jefe.trabajadore_id"=>$this->request->data["Trabajadore"]["jefe_id"])));
				if(!empty($jefe)){
				$this->request->data["Trabajadore"]["jefe_id"] = $jefe["Jefe"]["id"];
				}else{
					$trabajadorEdit["Jefe"] = array(
						"trabajadore_id"=>$this->request->data["Trabajadore"]["jefe_id"],
						"estado"=>1
						);
					unset($this->request->data["Trabajadore"]["jefe_id"]);
				}
			}
			$trabajadorEdit["Trabajadore"] = $this->request->data["Trabajadore"];
			//pr($trabajadorEdit);exit;
			if($this->Trabajadore->saveAssociated($trabajadorEdit)){
				
				$Email = new CakeEmail("gmail");
				$Email->from(array('sgi@cdf.cl' => 'SGI'));
				$Email->to(array('rrhh@cdf.cl'));
				$Email->subject('Actualización información personal trabajador');
				$Email->emailFormat('html');
				$Email->template('edita_trabajador');
				$Email->viewVars(array(
					"usuario"=>$this->Session->read("Users.nombre"),
					"fechaActualizacion"=>date("d/m/Y H:i"),
				));
				$Email->send();

				      if(!empty($this->request->data["CuentasCorriente"])){
					if(isset($this->request->data["CuentasCorriente"][0]["id"])){
						unset($this->request->data["CuentasCorriente"][0]["modified"]);
						unset($this->request->data["CuentasCorriente"][0]["created"]);
						unset($this->request->data["CuentasCorriente"][0]["TrabajadoresCuentasCorriente"]);
						unset($this->request->data["CuentasCorriente"][0]["Banco"]);
						unset($this->request->data["CuentasCorriente"][0]["TiposCuentaBanco"]);
						$this->request->data["CuentasCorriente"][0]["estado"] = 1;
						$this->request->data["CuentasCorriente"][0]["tipo"] = 1;
					}	
					$cuentaCorriente["CuentasCorriente"] = $this->request->data["CuentasCorriente"][0];
					$cuentaCorriente["Trabajadore"]["id"] = $this->Trabajadore->id;
					if(!$this->CuentasCorriente->saveAssociated($cuentaCorriente, array('deep' => true))){
						$mensaje = "Se edito correctamente el trabajador, pero no se pudo actualizar la cuenta corriente";		
					}
				}
				CakeLog::write('actividad', 'edito - Trabajadores - editar_trabajadores - '.$this->Trabajadore->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->Session->setFlash($mensaje, 'msg_exito');	
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Se edito correctamente"
					);
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se pudo editar, por favor intentelo de nuevo"
					);
			}
			
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"El trabajador no existe"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function view($id = null){
		
		$this->layout = "angular";
		$this->loadModel("Jefe");
		$this->loadModel("Cargo");
		$this->loadModel("tiposMoneda");
		$this->loadModel("Documento");
		if($this->Session->Read("Users.flag") != 0){			
			if($this->Session->Read("Accesos.accesoPagina") == 0){
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		if($this->Session->read('Users.flag') == 1){
			if (!$this->Trabajadore->exists($id)){
				$this->Session-> setFlash('El trabajador no existe', 'msg_fallo');
				return $this -> redirect(array("controller" => 'trabajadores', "action" => 'index'));
			}else{
				$tipoMonedas = $this->tiposMoneda->find("list", array("fields"=>array("tiposMoneda.id","tiposMoneda.nombre")));
				$options = array(
					'conditions' => array(
						'Trabajadore.' . $this->Trabajadore->primaryKey=>$id
						),
					'recursive'=>2
					);
				$trabajador = $this->Trabajadore->find('first', $options);
				$trabajador["Area"]["nombre"] = "";
				$trabajador["Gerencia"]["nombre"] = "";
				$cargoAreaGerencia = $this->Cargo->find("first", array("conditions"=>array("Cargo.id"=>$trabajador["Trabajadore"]["cargo_id"]), "recursive"=>2));
				if(!empty($trabajador["Trabajadore"]["cargo_id"])){
					$cargoAreaGerencia = $this->Cargo->find("first", array("conditions"=>array("Cargo.id"=>$trabajador["Trabajadore"]["cargo_id"]), "recursive"=>2));					
					$trabajador["Area"]["nombre"] = $cargoAreaGerencia["Area"]["nombre"];	
					$trabajador["Gerencia"]["nombre"] = $cargoAreaGerencia["Area"]["Gerencia"]["nombre"];	
				}
				if(empty($trabajador["Trabajadore"]["jefe_id"])){
					$trabajador["Jefe"]["Trabajadore"]["nombre"] = "";
					$trabajador["Jefe"]["Trabajadore"]["apellido_paterno"] = "";
					$trabajador["Jefe"]["Trabajadore"]["apellido_materno"] = "";
				}
				isset($trabajador["Trabajadore"]["fecha_nacimiento"]) ? $trabajador["Trabajadore"]["fecha_nacimiento"] = date('d/m/Y', strtotime($trabajador["Trabajadore"]["fecha_nacimiento"])) : '';
				isset($trabajador["Trabajadore"]["fecha_ingreso"] ) ? $trabajador["Trabajadore"]["fecha_ingreso"] = date('d/m/Y', strtotime($trabajador["Trabajadore"]["fecha_ingreso"])) : '';
				if(!is_null($trabajador["Trabajadore"]["sexo"])){
					switch ($trabajador["Trabajadore"]["sexo"]) {
						case 0:
							$trabajador["Trabajadore"]["sexo"] = "Masculino";
							break;
						case 1: 
							$trabajador["Trabajadore"]["sexo"] = "Femenino";
					}
				}
				$documentos = $this->Documento->find('all', array("order"=>"Documento.fecha_inicial DESC", 'conditions'=>array('Documento.trabajadore_id'=>$id)));
				$this->set('documentos', $documentos);
				$this->set('trabajador', $trabajador);
				$this->set("tipoMonedas", $tipoMonedas);
			}
		}
	}

	public function delete($id = null) {
		
		
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		if ($this -> Session -> read('Users.flag') == 1) {
			$this -> Trabajadore -> id = $id;
			if (!$this -> Trabajadore -> exists()) {
				$this -> Session -> setFlash('Este perfil no existe', 'msg_fallo');
						return $this -> redirect(array("controller"=>"trabajadores",'action' => 'index'));
			}
			$this -> request -> allowMethod('post', 'delete');
			if ($this -> Trabajadore -> delete()) {
				$this->loadModel("ActividadUsuario");
				$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
				$mensaje = "Se elimina trabajador ".$id;
				$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
				$this -> ActividadUsuario -> save($log);
				$this -> Session -> setFlash('El trabajador ha sido borrado.', 'msg_exito');
			} else {
				$this -> Session -> setFlash(__('El trabajador no ha podido ser borrado. Por favor, intente nuevamente', 'msg_fallo'));
			}
			return $this -> redirect(array('action' => 'index'));
		} else {
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function perfil($id = null) {
 
 		$this->layout = "angular";
		$usuario = $this->Session->Read("PerfilUsuario");
 		if($this->Session->Read("Users.flag") == 0){			
 			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
 			return $this->redirect(array("controller" => 'users', "action" => 'login'));
 		}
 		if ($this->Session->read('Users.flag') == 1) {			
			if($usuario["trabajadoreId"] == $id){
 				if(!$this->Trabajadore->exists($id)) {
 					$this->Session->setFlash('Este perfil no existe', 'msg_fallo');
 					return $this->redirect(array("controller"=>"dashboards",'action' => 'index'));
 				}else{
 					/*$descripcionCargo = $this->Trabajadore->find('all', array(
						'conditions'=>array('Trabajadore.id'=>$id),
						'fields'=>array('Trabajadore.descripcion_cargo'),
						'recursive'=>-1
					));

 					$this->set('descripcionCargo', $descripcionCargo[0]['Trabajadore']['descripcion_cargo']);*/
 					$this->set("id", $id);	
 				}
 			}else{
 				$this->Session->setFlash('Solo puedes ingresar a tu perfil', 'msg_fallo');
 				return $this->redirect(array("controller"=>"dashboards",'action' => 'index'));
 			}
 		}
 	}

	public function valida_rut()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$estadoTrabajador = $this->Trabajadore->find('all', array(
			'conditions'=>array('Trabajadore.rut'=>$this->params->query["rutTrabajador"]),
			'fields'=>array("Trabajadore.rut")
		));
		if(!empty($estadoTrabajador)){
			$respuesta = array(
				"estado"=>1,
				"mensaje"=>"El rut ya se encuetra ingresado"
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Rut no ingresado"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function valida_rut_compras()
	{
		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("Company");

		$respuesta = array();
		$empresa = $this->Company->find('first', array( 'conditions'=>array('Company.rut'=>$this->params->query["rutTrabajador"]), 'fields'=>array("Company.id") ));

		if (!empty($empresa)) {
			$compra = $this->ComprasProductosTotale->find('first', array(
					'conditions'=>array( 
						'ComprasProductosTotale.company_id'=>$empresa["Company"]["id"]						
					), 
					'fields'=>array("ComprasProductosTotale.id")
				)
			);
			foreach ($compra["ComprasFactura"] as $key => $boleta) {				
				if($boleta["tipos_documento_id"] == 18) {
					$respuesta = array(
						"estado"=>2,
						"mensaje"=>"El trabajador que esta ingresando posee boleta(s) de honorarios"
					);
				}
			}
		} 
		
		$estadoTrabajador = $this->Trabajadore->find('first', array(
			'conditions'=>array('Trabajadore.rut'=>$this->params->query["rutTrabajador"]),
			'fields'=>array("Trabajadore.rut")
		));
		if(!empty($estadoTrabajador)){
			$respuesta = array(
				"estado"=>1,
				"mensaje"=>"El rut ya se encuetra ingresado"
				);
		}
		if(empty($respuesta)) {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Rut no ingresado"
				);
		}
		
		$this->set("respuesta", json_encode($respuesta));
	}
	
	public function buscaAreas(){
		$this->layout = null;
		$this->loadModel("Area");
		
		$buscaAreas = $this->Area->find('all', array(
			'conditions'=>array('gerencia_id'=>$this->params->query["gerencia"]),
			'fields'=>array("Area.id", "Area.nombre")
		));
		
		$areas = "";
		foreach($buscaAreas as $buscaArea)
		{
			$areas[] = array("Id"=>$buscaArea["Area"]["id"], "Nombre"=>$buscaArea["Area"]["nombre"]); 
		}

		if(!empty($areas))
		{
			echo json_encode($areas);
		}
		else
		{
			echo "1";
		}		
		exit;
	}
	
	public function retiro_trabajador() {

		$this->layout = "ajax";
		$this->loadModel("Retiro");
		$this->loadModel("Jefe");
		if ($this->Session->read('Users.flag') == 1) {
			$trabajador = $this->Trabajadore-> find('first', array('conditions'=> array('Trabajadore.id'=>$this->request->data["Retiro"]["trabajadore_id"])));
			$this->request->data["Retiro"]["fecha_ingreso"] = $trabajador["Trabajadore"]["fecha_ingreso"];
			$this->request->data["Retiro"]["fecha_retiro"] = DateTime::createFromFormat('d/m/Y', $this->request->data["Retiro"]["fecha_retiro"])->format('Y-m-d');
			if ($this->Retiro->save($this->request->data)) {
				$trabajadore["Trabajadore"] = array("id"=>$this->request->data["Retiro"]["trabajadore_id"], "estado"=>"Retirado");
				$this->Trabajadore->save($trabajadore);
				CakeLog::write('actividad', 'Retiro - Trabajadores - retiro_trabajador - '.$this->Retiro->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$jefe = $this->Jefe->find("first", array("conditions"=>array("Jefe.trabajadore_id"=>$this->request->data["Retiro"]["trabajadore_id"])));
				if(!empty($jefe)){
					$jefeCambioEstado = array(
						"Jefe"=>array(
							"id"=>$jefe["Jefe"]["id"],
							"estado"=>0
							)
						);
					if($this->Jefe->save($jefeCambioEstado)){
						CakeLog::write('actividad', 'Cambio estado jefe - Trabajadores - retiro_trabajador - '.$this->Jefe->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					}
				}
				$respuesta = array("estado"=>1);
			} else {
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se puedo registrar el retiro"
					);
			}
		} else {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdio la sesión por favor vuelva a conectarse"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function activar_trabajador() {

		$this->layout = "ajax";
		if($this->Session->read('Users.flag') == 1){
			$this->Trabajadore->id = $this->request->data["id"];
			if ($this->Trabajadore->exists()){
				$this->request->data["fecha_ingreso"] = DateTime::createFromFormat('d/m/Y', $this->request->data["fecha_ingreso"])->format('Y-m-d');
				$trabajador["Trabajadore"] = $this->request->data;
				if ($this->Trabajadore->save($trabajador)){					
					CakeLog::write('actividad', 'CambioEstado - Trabajadores - activar_trabajador - '.$this->Trabajadore->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"Se cambio correctamente el estado"
						); 
				}
				else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"No se puedo registrar el estado"
						);
				}
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"El trabajador no existe"
					);
			}
		}
		else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdio la sesión por favor vuelva a conectarse"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function dotacionPorGerencia() {
		
		/*if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->request->is('post') != 1)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}*/
		$this->loadModel("Gerencia");
		$this->loadModel("Retiro");
		$gerencias = $this->Gerencia->find("all", array('fields'=>array('Gerencia.nombre'), 'order'=>'Gerencia.nombre ASC', 'conditions'=>array('Gerencia.estado'=>1)));
		$this->set('gerencias',$gerencias);
		$ingresosQuery = $this->Trabajadore->find("all", array('fields'=>array('Trabajadore.id', 'Trabajadore.fecha_ingreso','Gerencia.nombre'),'order'=>'Trabajadore.fecha_ingreso ASC'));
		$retirosQuery = $this->Retiro->find("all", array('fields'=>array('Trabajadore.id','Retiro.fecha_retiro'), 'order'=>'Retiro.fecha_retiro ASC'));
		$ingresoSuma= 0;
		$retiroSuma = 0;
		foreach ($ingresosQuery as $ingresosArray) 
		{
			$ingresosArrayArray[$ingresosArray["Gerencia"]["nombre"]][] = date("Y", strtotime($ingresosArray["Trabajadore"]["fecha_ingreso"]));
			foreach ($retirosQuery as $retirosArray) 
			{
				if($ingresosArray["Trabajadore"]["id"]==$retirosArray["Trabajadore"]["id"])
				{
					$retirosArrayArray[$ingresosArray["Gerencia"]["nombre"]][] = date("Y", strtotime($retirosArray["Retiro"]["fecha_retiro"]));
				}

			}
		}
		foreach($ingresosArrayArray as $key => $ingresoArrayArrayArray)
		{
			$ingresoArrayArrayArrayArray[$key] = array_count_values($ingresoArrayArrayArray);
		}
		foreach ($ingresoArrayArrayArrayArray as $gerencia => $ingresoArrayArrayArrayArrayArray) 
		{
			//pr($ingresoArrayArrayArrayArrayArray);
			foreach ($ingresoArrayArrayArrayArrayArray as $key => $ingreso) 
			{
				$ingresos[$gerencia][] = array($key=>$ingresoSuma+$ingreso);
				$ingresoSuma = 	$ingresoSuma+$ingreso;
			}
			$ingresoSuma=0;
		}
		foreach($retirosArrayArray as $key => $retiroArrayArrayArray)
		{
			$retirosArrayArrayArrayArray[$key] = array_count_values($retiroArrayArrayArray);
		}
		foreach ($retirosArrayArrayArrayArray as $gerencia => $retirosArrayArrayArrayArrayArray) 
		{
			foreach ($retirosArrayArrayArrayArrayArray as $key => $retiro) 
			{
				$retiros[$gerencia][] = array($key=>$retiro);	
			}

		}

		foreach ($ingresos as $key => $value) 
		{
			
		}
		pr($retiros);
		//pr($retiros);
		exit;
	}

	public function cambiarContrato(){
		
		$this->layout = "ajax";
		if ($this->Session->read('Users.flag') == 1) {
			//$trabajadore["Trabajadore"] = array("id"=>$this->request->data["id"], "tipo_contrato_id"=>$this->request->data["tipo"]);
			if ($this->Trabajadore->save($this->request->data)) {
				$this->loadModel("ActividadUsuario");
				$usuario = $this->Session->read("PerfilUsuario.idUsuario");
				$mensaje = 'Se cambia tipo contrato para trabajador con id "'.$this->request->data["Trabajadore"]["id"];
				$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
				$this->ActividadUsuario->save($log);
				$mensaje = json_encode(array("mensaje"=>1));
				$this->set("mensaje", $mensaje);
			} else {
				$mensaje = json_encode(array("mensaje"=>0));
				$this->set("mensaje", $mensaje);
			}			

		} else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function comprobar_documento()
	{
		$this->layout = "ajax";
		$respuesta = "";
		$this->loadModel("Documento");
		//pr($this->request->query);exit;
		if ($this->request-> is(array('get'))) 
		{
			if(!empty($this->request->query))
			{
				$fecha = DateTime::createFromFormat('d/m/Y', $this->request->query["fecha_inicial"])->format('Y-m-d');
				$documento = $this->Documento->find("first", array('conditions'=>array('Documento.trabajadore_id'=>$this->request->query["id"], "Documento.tipos_documento_id"=>$this->request->query["tipos_documento_id"], "Documento.fecha_inicial"=>$fecha )));
				$respuesta = json_encode($documento);
				$this->set('respuesta', $respuesta);
			}
			else
			{	
				$respuesta = json_encode($documento);
				$this->set('respuesta', $respuesta);
			}
		}

	}

	public function reporte_pendientes()
	{
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

	public function trabajador($id){

		$this->autoRender = false;
		//$this->response->type("json");
		$this->loadModel("Gerencia");
		$trabajador = $this->Trabajadore->find("first", array(
			"conditions"=>array("Trabajadore.id"=>$id), 
			"recursive"=>2,
			)
		);
		if(isset($trabajador["Cargo"]["Area"]["gerencia_id"])){
			$gerencia = $this->Gerencia->find("first", array("conditions"=>array("Gerencia.id"=>$trabajador["Cargo"]["Area"]["gerencia_id"])));
			$trabajador["Cargo"]["Area"]["Gerencia"] = $gerencia["Gerencia"];
		}
		return json_encode($trabajador);
	}

	public function imprimir_contrato($id){

		$this->layout = "angular";
		$this->loadModel("TipoContratosPlantilla");
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/*if($this->Session->read('Users.flag')==1) {
			if (!$this->Trabajadore->exists($id)) {
				$this->Session->setFlash('Este perfil no existe', 'msg_fallo');
				return $this->redirect(array("controller"=>"dashboards",'action' => 'index'));
			}
			$tipoContrato = $this->Trabajadore->find("first", array(
				'conditions'=>array(
					'Trabajadore.id'=>$id
					),
				'fields'=>'Trabajadore.tipo_contrato_id'
				)
			);	
			if($this->request->is('post')){

			}
			$tipoDocumentos = "";
			$tipoDocumentosQuery = $this->TipoContratosPlantilla->find("all", array(
				"conditions"=>array(
					"TipoContratosPlantilla.tipo_contrato_id"=>$tipoContrato["Trabajadore"]["tipo_contrato_id"]
					)
				)
			);
			if(!empty($tipoDocumentosQuery)){
				foreach($tipoDocumentosQuery as $k => $tipoDocumento){
					$tipoDocumentos[$tipoDocumento["TipoDocumento"]["id"]] = $tipoDocumento["TipoDocumento"]["nombre"];
				}
			}
			$this->set("tipoDocumentos", $tipoDocumentos);
		}*/

	}

	public function trabajadores_listado(){
		
		$this->autoRender = false;
		$this->loadModel("Cargo");
		$this->loadModel("Horario");
		$cargos = $this->Cargo->find("all", array("recursive"=>2));
		foreach ($cargos as $cargo) {
			$listaCargo[$cargo["Cargo"]["id"]] = array(
				"nombreCargo"=>$cargo["Cargo"]["nombre"],
				"nombreArea"=>$cargo["Area"]["nombre"],
				"nombreGerencia"=>$cargo["Area"]["Gerencia"]["nombre"]
				);
		}
		$horarios = $this->Horario->find("list", array("fields"=>array("Horario.id","Horario.nombre")));		
		$trabajadores = $this->Trabajadore->find("all", array(
			"order"=>"Trabajadore.nombre ASC",
			"recursive"=>-1
			)
		);
		foreach ($trabajadores as $trabajador) {	
			if (isset($horarios[$trabajador["Trabajadore"]["horario_id"]])) {
				$trabajador["Trabajadore"]["horario"] = trim($horarios[$trabajador["Trabajadore"]["horario_id"]]);
			}
			$trabajadoresListado[$trabajador["Trabajadore"]["id"]] = $trabajador["Trabajadore"];
			if(!empty($trabajador["Trabajadore"]["cargo_id"])){
				if(isset($listaCargo[$trabajador["Trabajadore"]["cargo_id"]])) {
					$trabajadoresListado[$trabajador["Trabajadore"]["id"]] = $trabajadoresListado[$trabajador["Trabajadore"]["id"]]+$listaCargo[$trabajador["Trabajadore"]["cargo_id"]];	
				} else {
					$trabajadoresListado[$trabajador["Trabajadore"]["id"]] = $trabajadoresListado[$trabajador["Trabajadore"]["id"]];
				}				
			}
		}		
		if(!empty($trabajadoresListado)){
			$respuesta = array(
				"estado"=>1,
				"data" => $trabajadoresListado
			);
		}else
		{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Sin datos"
			);
		}

		return json_encode($respuesta);
	}

	public function add_trabajador(){
		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("Company");
		$this->loadModel("Email");

		$tieneCompras = false;
		$empresa = $this->Company->find('first', array( 'conditions'=>array('Company.rut'=>$this->request->data["Trabajadore"]["rut"]), 'fields'=>array("Company.id") ));
		if (!empty($empresa)) {
			$compra = $this->ComprasProductosTotale->find('first', array(
					'conditions'=>array( 
						'ComprasProductosTotale.company_id'=>$empresa["Company"]["id"]						
					), 
					'fields'=>array("ComprasProductosTotale.id")
				)
			);
			foreach ($compra["ComprasFactura"] as $key => $boleta) {				
				if($boleta["tipos_documento_id"] == 18) {
					$tieneCompras  = true;
				}
			}
		} 

		isset($this->request->data["Trabajadore"]["fecha_nacimiento"]) ? $this->request->data["Trabajadore"]["fecha_nacimiento"] = DateTime::createFromFormat('d/m/Y', $this->request->data["Trabajadore"]["fecha_nacimiento"])->format('Y-m-d') : '';
		isset($this->request->data["Trabajadore"]["fecha_ingreso"]) ? $this->request->data["Trabajadore"]["fecha_ingreso"] = DateTime::createFromFormat('d/m/Y', $this->request->data["Trabajadore"]["fecha_ingreso"])->format('Y-m-d') : '' ;

		if($this->Trabajadore->saveAssociated($this->request->data)){
			CakeLog::write('actividad', 'agrego - Trabajadores - add_trabajadores - '.$this->Trabajadore->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			$this->Session->setFlash('Se ingreso correctamente', 'msg_exito');	
			$respuesta = array(
				"estado"=>1,
				"mensaje"=>"Se ingreso correctamente"
				);

			if($tieneCompras){
				$emails = array();
				$emailArr = $this->Email->find('all', array( 'conditions'=>array('Email.informe'=>'trabajador-boleta'), 'fields'=>array("Email.email")));
				foreach ($emailArr as $key => $value) {
					$emails[] = $value["Email"]["email"];
				}

				$Email = new CakeEmail("gmail");
				$Email->from(array('sgi@cdf.cl' => 'SGI'));
				$Email->to($emails);
				$Email->subject("Ingreso de trabajador");
				$Email->emailFormat('html');
				$Email->template('envio_correo_trabajador_boleta');
				$Email->viewVars(array(
					"mensaje"=>'Se ha ingresado un nuevo trabajador que posee Boleta(s) de Honorarios',
					"nombre"=>$this->request->data["Trabajadore"]["nombre"],
					"apellido"=>$this->request->data["Trabajadore"]["apellido_paterno"],
					"rut"=>$this->request->data["Trabajadore"]["rut"],
				));
				$Email->send();
			}

		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No se pudo ingresar, por favor intentelo de nuevo"
				);
		}
		
		$this->set("respuesta", json_encode($respuesta));
	}

	public function cuenta_bancaria($id){
		$this->layout = "angular";
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		$this->set("id", $id);
	}

	public function cuenta_bancaria_trabajador(){
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("TrabajadoresCuentasCorriente");
		if($this->Session->read('Users.flag') == 1){
			$cuentaCorriente = $this->TrabajadoresCuentasCorriente->find("first", array("conditions"=>array("TrabajadoresCuentasCorriente.trabajadore_id"=>$this->request->query["idTrabajador"])));
			if(!empty($cuentaCorriente)){
				$respuesta = array(
					"estado"=>1,
					"data"=>$cuentaCorriente
					);
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Sin información"
					);
			}
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdiste la sesión por favor vuelve a logear"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function guardar_cuenta_bancaria(){
		pr($this->request->data);exit;
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("CuentasCorriente");
		if($this->Session->read('Users.flag') == 1){
			if($this->CuentasCorriente->saveAssociated($this->request->data, array('deep' => true))){
				if(isset($this->request->data["CuentasCorriente"]["id"])){
					CakeLog::write('actividad', 'edito - Trabajadores - guardar_cuenta_bancaria - '.$this->CuentasCorriente->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash('Se edito correctamente', 'msg_exito');
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"Se edito correctamente"
						);
				}else{
					CakeLog::write('actividad', 'agrego - Trabajadores - guardar_cuenta_bancaria - '.$this->CuentasCorriente->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash('Se ingreso correctamente', 'msg_exito');
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"Se ingreso correctamente"
						);
				}
					
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se pudo guardar en la base de datos, por favor intentelo de nuevo"
					);
			}
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdiste la sesión por favor vuelve a logear"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function upload_foto_trabajador(){
		$this->layout = "ajax";
		//$this->response->type('json');
		$Servicios = new ServiciosController;
		ini_set('gd.jpeg_ignore_warning', true);
		if(isset($this->params->form)){
			if($this->params->form["file"]['error'] == 0 && $this->params->form["file"]['size'] > 0){
				$destino = WWW_ROOT.'files'. DS .'trabajadores'. DS .$this->request->data["id"];					
				if (!file_exists($destino)){
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}
				if(is_uploaded_file($this->params->form["file"]['tmp_name'])){
					if($this->params->form["file"]['size'] <= 2000000000){
						$rutaImagenOriginal = $this->params->form['file']['tmp_name'];
						switch ($this->params->form["file"]["type"]){
							case "image/jpg":
							case "image/jpeg":
								$img_original = imagecreatefromjpeg($rutaImagenOriginal);
								break;
							case "image/png":
								$img_original = imagecreatefrompng($rutaImagenOriginal);
								break;
							case "image/gif":
								$img_original = imagecreatefromgif($rutaImagenOriginal);
								break;
						}
						//pr($this->request->data["foto"]["type"]);exit;															
						$max_ancho = 800;
						$max_alto = 600;
						
						list($ancho,$alto)=getimagesize($rutaImagenOriginal);
						
						//Se calcula ancho y alto de la imagen final
						//pr("Ancho ".$ancho." Alto ".$alto." Tipo ".$tipo); exit;
						$x_ratio = $max_ancho / $ancho;
						$y_ratio = $max_alto / $alto;
													
						//Si el ancho y el alto de la imagen no superan los maximos, 
						//ancho final y alto final son los que tiene actualmente
						if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){//Si ancho 
							$ancho_final = $ancho;
							$alto_final = $alto;
						}
						/*
						 * si proporcion horizontal*alto mayor que el alto maximo,
						 * alto final es alto por la proporcion horizontal
						 * es decir, le quitamos al alto, la misma proporcion que 
						 * le quitamos al alto
						 * 
						*/
						elseif (($x_ratio * $alto) < $max_alto){
							$alto_final = ceil($x_ratio * $alto);
							$ancho_final = $max_ancho;
						}
						/*
						 * Igual que antes pero a la inversa
						*/
						else{
							$ancho_final = ceil($y_ratio * $ancho);
							$alto_final = $max_alto;
						}
						
						//Creamos una imagen en blanco de tamaño $ancho_final  por $alto_final .
						$tmp=imagecreatetruecolor($ancho_final,$alto_final);	
						
						//Copiamos $img_original sobre la imagen que acabamos de crear en blanco ($tmp)
						imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
						
						//Se destruye variable $img_original para liberar memoria
						imagedestroy($img_original);
						
						//Definimos la calidad de la imagen final
						$calidad=72;
						
						//Se crea la imagen final en el directorio indicado
						$trabajador = $this -> Trabajadore -> find('first', array('conditions'=>array('Trabajadore.id'=>$this->data["id"])));
						if($trabajador["Trabajadore"]["foto"]!="photo.png"){
							unlink(WWW_ROOT.'files'. DS .'trabajadores'. DS .$trabajador["Trabajadore"]["foto"]);
						}
						$nombreTrabajador = str_replace(' ', '', $trabajador["Trabajadore"]["nombre"].$trabajador["Trabajadore"]["apellido_paterno"].$trabajador["Trabajadore"]["apellido_materno"]);
						$nombreTrabajador = $Servicios->sanearString($nombreTrabajador);
						$extension = substr(strrchr($this->params->form["file"]["name"], "."), 1);
						$nombreImagen = $nombreTrabajador.".".$extension;
						imagejpeg($tmp,$destino . DS .$nombreImagen,$calidad);
						chmod($destino . DS .$nombreImagen, 0777);							
						$this->request->data["Trabajadore"]["id"] = $this->request->data["id"]; 
						$this->request->data["Trabajadore"]["foto"] = $this->request->data["id"] .DS.$nombreImagen;
						if($this->Trabajadore->save($this->request->data)){
							CakeLog::write('actividad', 'subio - Documentos - upload_foto_trabajador - '.$this->Trabajadore->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
							$respuesta = array(
								"estado"=>1,
								"mensaje"=>"La foto se subio correctamente",
								"data"=> $this->request->data["id"] .DS.$nombreImagen
								);
						}
					}else{
						$respuesta = array(
							"estado"=>0,
							"mensaje"=>"No se pudo subir la foto, peso del archivo excedido"
							);	
					}
				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"No se pudo subir la foto, problemas con el archivo guardado en el servidor temporalmente"
						);	
				}
				
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se pudo subir la foto, la subida contiene errores o el peso es 0"
					);
			}		 
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No se pudo subir la foto, error en el envio del archivo"
				);
		}
		$this->set('respuesta', json_encode($respuesta));
	}

	public function upload_descripcion_cargo(){
		$this->autoRender = false;
		$this->response->type("json");

		if($this->params->form["file"]['error'] == 0 && $this->params->form["file"]['size'] > 0)
		{
		 	$destino = WWW_ROOT.'files'.DS.'descripcion_cargo'.DS.date("Y_m_d_H_i").DS.$this->request->data['id']; 
		 	
		 	if (!file_exists($destino))
			{
				mkdir($destino, 0777, true);
				chmod($destino, 0777);
			}
			
			if($this->params->form["file"]['tmp_name'])
			{
				if($this->params->form["file"]['size'] <= 7000000)
				{
					move_uploaded_file($this->params->form["file"]['tmp_name'], $destino . DS .$this->params->form["file"]['name']);
					$nombreArchivo = date("Y_m_d_H_i").DS.$this->request->data['id'].DS.$this->params->form["file"]['name'];

					$this->request->data['Trabajadore']['id'] = $this->request->data['id'];
					$this->request->data['Trabajadore']['descripcion_cargo'] = $nombreArchivo;

					if( $this->Trabajadore->save($this->request->data)){
						return json_encode(array('estado'=>1));
					}
				}
				else
				{
					return json_encode(array('estado'=>2));
					exit;
				}
			}
			else
			{
				return json_encode(array('estado'=>2));
				exit;	
			}
		}
	}
	
	public function trabajadores(){
		$this->layout = "ajax";
		$this->response->type('json');
		$trabajadoresQuery = $this->Trabajadore->find("all");
		if(!empty($trabajadoresQuery)){
			foreach ($trabajadoresQuery as $trabajador) {
				$trabajadoresId[$trabajador["Trabajadore"]["id"]] = $trabajador;
			}
			$usuariosTrabajadores = $this->User->find("all", array(
				"conditions" => array(
					"User.trabajadore_id" => array_keys($trabajadoresId)
				),
				"fields" => array(
					"User.id",
					"User.trabajadore_id",
					"User.estado"
				),
				"recursive" => -1
			));
			if(!empty($usuariosTrabajadores)){
				foreach ($usuariosTrabajadores as $usuario) {
					$usuarios[$usuario["User"]["trabajadore_id"]] = $usuario;
				}
			}
			foreach ($trabajadoresId as $idTrabajador => $trabajador) {
				if(!empty($trabajador["Jefe"]["trabajadore_id"])){
					$trabajador["Jefe"]["Trabajadore"] = $trabajadoresId[$trabajador["Jefe"]["trabajadore_id"]]["Trabajadore"];
				}
				(isset($usuarios[$idTrabajador])) ? $trabajador["User"] = $usuarios[$idTrabajador]["User"] : $trabajador["User"] = array();
				$trabajadores[] = $trabajador;
			}

			$respuesta = array(
				"estado"=>1,
				"data"=>$trabajadores
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No se encontro información"
				);	
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function select_trabajador (){

		$this->autoRender = false;
		$this->response->type('json');
		$nacionalidades = new NacionalidadesController;
		$localizaciones = new LocalizacionesController;
		$comunas = new ComunasController;
		$sistemaPensiones = new SistemaPensionesController;
		$sistemaPrevisiones = new SistemaPrevisionesController;
		$tiposMonedas = new TiposMonedasController;
		$nivelEducacional = new NivelEducacionsController;
		$tiposCuentaBancos = new TiposCuentaBancosController;
		$bancos = new BancosController;
		$gerencias = new GerenciasController;
		$areas = new AreasController;
		$cargos = new CargosController;
		$horarios = new HorariosController;
		$tipoContratos = new TipoContratosController;
		$dimensiones = new DimensionesController;
		$tiposDocumentos = new TiposDocumentosController;
		$motivoRetiros = new MotivoRetirosController;
		$estadosCiviles = new EstadosCivilesController;
		$select["Nacionalidades"] = json_decode($nacionalidades->nacionalidades_list());
		$select["Localizaciones"] = json_decode($localizaciones->localizaciones_list());
		$select["Comunas"] = json_decode($comunas->comunas_list());
		$select["SistemaPensiones"] = json_decode($sistemaPensiones->sistema_pensiones_list());
		$select["SistemaPrevisiones"] = json_decode($sistemaPrevisiones->sistema_previsiones_list());
		$select["TiposModenas"] = json_decode($tiposMonedas->tipos_monedas_list());
		$select["NivelEducacional"] = json_decode($nivelEducacional->nivel_educacions_list());
		$select["Bancos"] = json_decode($bancos->bancos_list());
		$select["TiposCuentasBancos"] = json_decode($tiposCuentaBancos->tipos_cuenta_bancos_list());
		$select["Gerencias"] = json_decode($gerencias->gerencias_list());
		$select["Areas"] = json_decode($areas->areas_list());
		$select["Cargos"] = json_decode($cargos->cargos_list());
		$select["TrabajadoresListado"] = json_decode($this->trabajadores_listado());
		$select["Horarios"] = json_decode($horarios->horarios_list());
		$select["TipoContratos"] = json_decode($tipoContratos->tipo_contratos_list());
		$select["Dimensiones"] = json_decode($dimensiones->json_listar_dimensiones());
		$select["TiposDocumentos"] = json_decode($tiposDocumentos->tipos_documentos_list());
		$select["MotivoRetiros"] = json_decode($motivoRetiros->motivo_retiros_list());
		$select["EstadosCiviles"] = json_decode($estadosCiviles->estados_civiles_list());
		return json_encode($select);
	}

	public function directorio(){
		header("Access-Control-Allow-Origin: *");
		$serv = new ServiciosController();
		$this->autoRender = false;
		$trabajadores = $this->Trabajadore->find("all", array(
			"fields"=>array("Trabajadore.rut","Trabajadore.nombre","Trabajadore.apellido_paterno","Trabajadore.email","Trabajadore.foto","Trabajadore.anexo", "Trabajadore.telefono_particular", "Trabajadore.movil_corporativo", "Cargo.nombre","Gerencia.nombre"),
			"joins"=> array(array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id"))),
			"conditions"=>array("Trabajadore.estado"=>"Activo", "Trabajadore.tipo_contrato_id"=>array(1,4)),  // indefinido
			"order"=>"Trabajadore.nombre ASC",
			"recursive" => 0
			));
		foreach ($trabajadores as $trabajador) {
			$listaTrabajadores[] = array(
				"id" 					=> $trabajador["Trabajadore"]["id"],
				"rut" 					=> $trabajador["Trabajadore"]["rut"],
				"nombre"				=> $serv->capitalize($serv->eliminarAcentos($trabajador["Trabajadore"]["nombre"].' '.$trabajador["Trabajadore"]["apellido_paterno"])),
				"foto" 					=> $trabajador["Trabajadore"]["foto"],
				"anexo" 				=> $trabajador["Trabajadore"]["anexo"],
				"email" 				=> $trabajador["Trabajadore"]["email"],
				"telefono_particular" 	=> $trabajador["Trabajadore"]["telefono_particular"],
				"movil_corporativo" 	=> $trabajador["Trabajadore"]["movil_corporativo"],
				"cargo" 				=> $serv->capitalize($trabajador["Cargo"]["nombre"]),
				"gerencia" 				=> $serv->capitalize($trabajador["Gerencia"]["nombre"])									
				);
		}
		$this->set("directorio", $listaTrabajadores);
		$this->set("_serialize","directorio");
		return json_encode($listaTrabajadores);
	}

	public function gerentes_listado(){
		header("Access-Control-Allow-Origin: *");
		$this->autoRender = false;
		$this->loadModel("Jefe");
		$serv = new ServiciosController();

		$gerentes_listado = $this->Trabajadore->find("all", array(
			"fields"=>array( "Trabajadore.jefe_id", "Jefe.trabajadore_id", "Trabajadore.id", "Trabajadore.nombre", "Trabajadore.apellido_paterno",  "Trabajadore.estado" , "Trabajadore.foto", "Gerencia.id", "Cargo.nombre", "Tipo_contrato.nombre", "Jefe_trabajador.id","Jefe_trabajador.trabajadore_id"),
			"joins"=> array( array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
				array("table" => "tipo_contratos", "alias" => "Tipo_contrato", "type" => "LEFT", "conditions" => array("Trabajadore.tipo_contrato_id = Tipo_contrato.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
				array("table" => "jefes", "alias" => "Jefe_trabajador", "type" => "LEFT", "conditions" => array("Jefe_trabajador.trabajadore_id = Trabajadore.id")),
				),
			"conditions"=>array(
				array("Trabajadore.tipo_contrato_id !=" => 3),		
				"OR" => array(
					array("Trabajadore.estado"=>"Activo"),
					array("Jefe_trabajador.trabajadore_id not"=>null)
					),
				"OR" => array(
					array("Jefe.trabajadore_id IN" => array(110 , 501)), 
					array("Trabajadore.id IN"=>array(110 , 501))
					), 
				),	
			"recursive"=>0
			));

		$trabajadores = $this->Trabajadore->find("all", array(
			"fields"=>array("Trabajadore.jefe_id", "Jefe.trabajadore_id", "Trabajadore.id", "Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.foto", "Cargo.nombre"),
			"joins"=> array( array("table" => "jefes", "alias" => "Jefe_trabajador", "type" => "LEFT", "conditions" => array("Jefe_trabajador.trabajadore_id = Trabajadore.id")),
				),
			"conditions"=>array(
				array("Trabajadore.tipo_contrato_id !=" => 3),
				"OR" => array(
					array("Trabajadore.estado"=>"Activo"),
					array("Jefe_trabajador.trabajadore_id not"=>null)
					),	
				),	
			"recursive"=>0
			));			

		foreach ($trabajadores as $trabajador) {
			$trabajadoresArray[$trabajador["Trabajadore"]["jefe_id"]]["Trabajadores"][] = $trabajador["Trabajadore"];
		}

		$jefes = $this->Jefe->find("all", array(
			"conditions" => array("Trabajadore.tipo_contrato_id !=" => 3, "Trabajadore.cargo_id not"=> null),
			"recursive"=>0));

		foreach ($jefes as $jefe) {
			if(isset($trabajadoresArray[$jefe["Jefe"]["id"]])){
				$idJefes[] = $jefe["Jefe"]["trabajadore_id"];
			}
		}

		foreach ($gerentes_listado as $trabajador) {			// Arma arreglo para Arbol

			$masTrabajadores = '';
			$nrTrabajadores = 0;
			$nombreCargo = '';
			// nr trabajadores
			if(in_array($trabajador["Trabajadore"]["id"], $idJefes) && $trabajador["Trabajadore"]["id"] != 110 && $trabajador["Trabajadore"]["id"] != 501 ){
				$nrTrabajadores  = TrabajadoresController::contar_trabajadores($trabajador["Jefe_trabajador"]["id"] , $trabajador["Gerencia"]["id"]);
				$masTrabajadores = 'mas-trabajadores';		

			} else if($trabajador["Trabajadore"]["id"] == 110 /*|| $trabajador["Trabajadore"]["id"] == 111*/){
				$nrTrabajadores  = 1;
			}
			// nombre
			if($trabajador["Trabajadore"]["estado"]!='Activo')
			{
				$nombreCompleto = "";
				$apellidoPaterno = "";
				$foto = FULL_BASE_URL. DS.'files'. DS .'trabajadores'. DS . 'photo.png';
				
			}else{

				$nombres = explode(" ", $trabajador["Trabajadore"]["nombre"]);
				$nombreCompleto = ucwords(mb_strtolower($nombres[0], 'UTF-8')).' '.ucwords(mb_strtolower($trabajador["Trabajadore"]["apellido_paterno"], 'UTF-8'));
				$apellidoPaterno = $trabajador["Trabajadore"]["apellido_paterno"];
				$foto = FULL_BASE_URL. DS .'files'. DS .'trabajadores'. DS . $trabajador["Trabajadore"]["foto"];

			}
			//cargo
			$cargo = explode(" ", trim($trabajador["Cargo"]["nombre"]));
			foreach ($cargo as $palabra) {
				$nombreCargo.= (strlen($palabra)>2) ? ucwords(mb_strtolower($palabra, 'UTF-8')).' ' : $palabra.' '; 
			}

			if( $trabajador["Trabajadore"]["estado"]=='Activo' || $nrTrabajadores>0 ){

				$data[] = array(
					"id" 				=> $trabajador["Trabajadore"]["id"],
					"title"				=> $nombreCompleto, 
					"apellido" 			=> $apellidoPaterno,
					"foto" 				=> $foto,
					"clase" 			=> $masTrabajadores,
					"nr_trabajadores" 	=> $nrTrabajadores,
					"es_jefe" 			=> (in_array($trabajador["Trabajadore"]["id"], $idJefes))? 1:0,
					"subtitle" 			=> $nombreCargo,
					"jefe_id" 			=> $trabajador["Trabajadore"]["jefe_id"],
					"estado" 			=> $trabajador["Trabajadore"]["estado"],
					"parent_id" 		=> ($trabajador["Jefe"]["trabajadore_id"])? $trabajador["Jefe"]["trabajadore_id"]: 999999,
					"gerencia_id" 		=> $trabajador["Gerencia"]["id"],
					"jefe_id_propio" 	=> $trabajador["Jefe_trabajador"]["id"],
					"tipo_contrato" 	=> $trabajador["Tipo_contrato"]["nombre"],
					"subtype" 			=> ($trabajador["Tipo_contrato"]["nombre"]=='plazo fijo')? "dashed": "",
					);
			}
		}

		$orderby = "es_jefe DESC,subtitle ASC,apellido ASC"; //Jefes,cargo,apellido
		$data = $serv->sort_array_multidim($data,$orderby);	

		//crea nodo especial para estructura CDF, con dos nodos Root. Este nodo (id=999999) no dibuja lineas a sus hijos, y su altura es definida en oc_options_1; box_root_node_height: 1 pixel 
		$nodoInicialCDF = array("nivel_jefe"=>14,"parent_id"=>null,"es_jefe"=>1,"id"=>999999,"title"=>"","apellido"=>'a',"foto"=>"","subtitle"=>"", "nivel_jefe"=>14, "tipo_contrato"=>'',"visible"=>"false");
		array_unshift($data, $nodoInicialCDF);	

		$itemsByReference = array();
		// Build array of item references:
		foreach($data as $key => &$item) {
			$itemsByReference[$item['id']] = &$item;
		}
		// Set items as children of the relevant parent item.
		foreach($data as $key => &$item){
			if($item['parent_id'] && isset($itemsByReference[$item['parent_id']])){
				$itemsByReference [$item['parent_id']]['children'][] = &$item;	   		
			}
		}
		// Remove items that were added to parents elsewhere:
		foreach($data as $key => &$item) {
			if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
				unset($data[$key]);
		}

		$listado = array("id"=>1,"title"=>"Organigrama CDF","root"=>$data[0]);		
		$this->set("gerentes_listado", $listado);
		$this->set("_serialize","gerentes_listado");
		return json_encode($listado);
	} 

	public function trabajadores_por_jefe($jefeId, $gerenciaId){
		header("Access-Control-Allow-Origin: *");
		$this->autoRender = false;
		$this->loadModel("Jefe");
		$serv = new ServiciosController();

		$trabajadoresPorJefe = $this->Trabajadore->find("all", array(
			"fields"=>array( "Jefe.id", "Jefe.trabajadore_id",  "Trabajadore.id", "Trabajadore.nombre", "Trabajadore.estado", "Trabajadore.foto", "Trabajadore.apellido_paterno", "Cargo.nombre","Tipo_contrato.nombre", "Jefe_trabajador.id", "Jefe_trabajador.estado", "Gerencia.id" ),
			"joins"=> array( array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
				array("table" => "tipo_contratos", "alias" => "Tipo_contrato", "type" => "LEFT", "conditions" => array("Trabajadore.tipo_contrato_id = Tipo_contrato.id")),				
				array("table" => "jefes", "alias" => "Jefe_trabajador", "type" => "LEFT", "conditions" => array("Jefe_trabajador.trabajadore_id = Trabajadore.id")),
				),
			"conditions"=>array(
				array("Trabajadore.tipo_contrato_id !=" => 3, "Tipo_contrato.nombre not" => null, "Trabajadore.jefe_id" => $jefeId),
				"OR" => array(
					array("Trabajadore.estado"=>"Activo"),
					array("Jefe_trabajador.trabajadore_id not"=>null)
					)
				),
			"recursive"=>0
			));

		$trabajadoresGerencia = $this->Trabajadore->find("all", array(
			"fields"=>array( "Jefe.id", "Jefe.trabajadore_id", "Trabajadore.id", "Trabajadore.nombre", "Trabajadore.estado", "Trabajadore.foto", "Trabajadore.apellido_paterno", "Cargo.nombre", "Tipo_contrato.nombre","Jefe_trabajador.id", "Gerencia.id"),
			"joins"=> array( array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
				array("table" => "jefes", "alias" => "Jefe_trabajador", "type" => "LEFT", "conditions" => array("Jefe_trabajador.trabajadore_id = Trabajadore.id")),
				array("table" => "tipo_contratos", "alias" => "Tipo_contrato", "type" => "LEFT", "conditions" => array("Trabajadore.tipo_contrato_id = Tipo_contrato.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
				),
			"conditions"=>array(
				array("Trabajadore.tipo_contrato_id !=" => 3, "Tipo_contrato.nombre not" => null, "Trabajadore.jefe_id not" => null,"Gerencia.id"=>$gerenciaId),
				"OR" => array(
					array("Trabajadore.estado"=>"Activo"),
					array("Jefe_trabajador.trabajadore_id not"=>null)
					)
				),	
			"recursive"=>0
			));

		$jefesGerencia = $this->Jefe->find("all", array(
			"fields" => array("Jefe.id","Jefe.trabajadore_id","Trabajadore.estado"),
			"conditions" => array("Trabajadore.tipo_contrato_id !=" => 3, "Trabajadore.cargo_id not"=> null ),
			"recursive" => 0));	

		foreach ($trabajadoresGerencia as $trabajador){
			$trabajadoresArray[$trabajador["Jefe"]["id"]]["Trabajadores"][$trabajador["Trabajadore"]["id"]] = array(
				"Trabajadore"=>$trabajador["Trabajadore"],
				"Jefe"=>$trabajador["Jefe"],
				"Cargo"=>$trabajador["Cargo"],
				"Gerencia"=>$trabajador["Gerencia"],
				"Tipo_contrato"=>$trabajador["Tipo_contrato"],
				"Jefe_trabajador"=>array("id" =>$trabajador["Jefe_trabajador"]["id"])
				 );
			if($trabajador["Jefe_trabajador"]["id"]==$jefeId)
				$jefeTrabajador = array_merge($trabajador, array("es_jefe"=>1,"root"=>'root',"minimizado"=>1));
		}

		foreach ($jefesGerencia as $jefe) {
			if(isset($trabajadoresArray[$jefe["Jefe"]["id"]])){
				$jefesArray[$jefe["Jefe"]["id"]] = array_merge($jefe, $trabajadoresArray[$jefe["Jefe"]["id"]]);
			}
		}

		foreach ($jefesArray as $jefe) {

			$nuevoArray[$jefe["Jefe"]["trabajadore_id"]] =  array(
			"trabajadore_id" => $jefe["Jefe"]["trabajadore_id"],
			"trabajadore_estado" => $jefe["Trabajadore"]["estado"],
			"minimizado" => (( count($jefe["Trabajadores"])>5)? 1: 0 ),
			"nr_trabajadores" => (count($jefe["Trabajadores"])>0)? count($jefe["Trabajadores"]): false,
			"Gerencia"=>array("id"=>$gerenciaId),
			"Trabajadore"	=> $jefe["Trabajadores"]
			);
		}

		/* oculta trabajadores > 5 */
		$finalizado = false;
		$revisandos = array();
		while(!$finalizado){
			$tra = "";
			$validador = false;	
			foreach ($trabajadoresPorJefe as $trabajador) {
				if($trabajador["Trabajadore"]["estado"]=="Activo" || isset($nuevoArray[$trabajador["Trabajadore"]["id"]]["nr_trabajadores"])){

					if(!isset($trabajador["revisado"])){		

						if(isset($nuevoArray[$trabajador["Trabajadore"]["id"]])){	
							$tra[] = array_merge($trabajador, array("revisado"=>1,"es_jefe"=>1, "minimizado"=> $nuevoArray[$trabajador["Trabajadore"]["id"]]["minimizado"]));
							if(!$nuevoArray[$trabajador["Trabajadore"]["id"]]["minimizado"]){
								foreach ($nuevoArray[$trabajador["Trabajadore"]["id"]]["Trabajadore"] as $trabaja) {
									$tra[] = array_merge($trabaja, array("es_jefe"=>0));
								}
							}
						}else{
							$tra[] = array_merge($trabajador, array("revisado"=>1,"es_jefe"=>0));
						}
					$validador = true;

					}else{
						$tra[] = $trabajador;
					}
					$trabajadoresPorJefe = $tra;
					if(!$validador){
						$finalizado = true;
					}
				}
			}
		}
		// nodo inicial, jefe solicitado	
		$trabajadoresPorJefe[] = $jefeTrabajador;
		
		foreach ($trabajadoresPorJefe as $trabajador) {			// Arma arreglo para Arbol
			$nombreCargo = '';
			$cargo = explode(" ", trim($trabajador["Cargo"]["nombre"]));
			foreach ($cargo as $palabra) {
				$nombreCargo.= (strlen($palabra)>2) ? ucwords(mb_strtolower($palabra, 'UTF-8')).' ' : $palabra.' '; 
			}

			if($trabajador["Trabajadore"]["estado"]=='Retirado')
			{
				$nombreCompleto = "";
				$apellidoPaterno = "";
				$foto = FULL_BASE_URL. DS .'files'. DS .'trabajadores'. DS . 'photo.png';
				
			}else{

				$nombres = explode(" ", $trabajador["Trabajadore"]["nombre"]);
				$nombreCompleto = ucwords(mb_strtolower($nombres[0], 'UTF-8')).' '.ucwords(mb_strtolower($trabajador["Trabajadore"]["apellido_paterno"], 'UTF-8'));
				$apellidoPaterno = $trabajador["Trabajadore"]["apellido_paterno"];
				$foto = FULL_BASE_URL. DS .'files'. DS .'trabajadores'. DS . $trabajador["Trabajadore"]["foto"];
			}

			$data[] = array(
				"id" 				=> $trabajador["Trabajadore"]["id"],
	/* nombre*/	"title"				=> $nombreCompleto,
				"apellido" 			=> $apellidoPaterno,
				"foto" 				=> $foto,
				"clase" 			=> (isset($trabajador["minimizado"]) && !isset($trabajador["root"]) )? ( ($trabajador["minimizado"]) ? 'mas-trabajadores' :'' ) :'',
				"nr_trabajadores" 	=> (isset($trabajador["minimizado"]))? ( ($trabajador["minimizado"])? (TrabajadoresController::contar_trabajadores($trabajador["Jefe_trabajador"]["id"],$gerenciaId)) : 0 ) : 0,					//
				"es_jefe" 			=> $trabajador["es_jefe"],
	/*cargo*/	"subtitle" 			=> $nombreCargo,
				"jefe_id" 			=> $trabajador["Jefe"]["id"],
	/*id jefe*/ "parent_id" 		=> $trabajador["Jefe"]["trabajadore_id"],
				"gerencia_id" 		=> $trabajador["Gerencia"]["id"],	
				"jefe_id_propio" 	=> $trabajador["Jefe_trabajador"]["id"],		
				"tipo_contrato" 	=> (isset($trabajador["Tipo_contrato"]["nombre"]))? $trabajador["Tipo_contrato"]["nombre"] : '',
				"subtype" 			=> (isset($trabajador["Tipo_contrato"]["nombre"]))? ($trabajador["Tipo_contrato"]["nombre"]=='plazo fijo')? "dashed": "" : "",			
				"root"				=> (isset($trabajador["root"]))? $trabajador["root"] : ''
				);
		}

		$orderby = "root DESC, es_jefe DESC,subtitle ASC,apellido ASC"; //Jefes,cargo,apellido
		$trabajadoresPorJefe = $serv->sort_array_multidim($data,$orderby);

		$itemsByReference = array();
		// Build array of item references:
		foreach($trabajadoresPorJefe as $key => &$item) {
			$itemsByReference[$item['id']] = &$item;
		}
		// Set items as children of the relevant parent item.
		foreach($trabajadoresPorJefe as $key => &$item){
			if($item['parent_id'] && isset($itemsByReference[$item['parent_id']])){
				$itemsByReference [$item['parent_id']]['children'][] = &$item;	   		
			}
		}
		foreach($trabajadoresPorJefe as $key => &$item) {		// Remove items that were added to parents elsewhere:
			if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
				unset($trabajadoresPorJefe[$key]);
		}
		
		$trabajadores = array("id"=>2,"title"=>"Organigrama CDF","root"=>$trabajadoresPorJefe[0]);		
		$this->set("trabajadoresPorJefe", $trabajadores); 	
		$this->set("_serialize","trabajadoresPorJefe");
		return json_encode($trabajadores);
	}


	/**
	* cuenta trabajadores en profundidad
	*
	*/
	public function contar_trabajadores($jefeId,$gerenciaId){
		
		$this->loadModel("Jefe");
		$trabajadoresPorJefe = $this->Trabajadore->find("all", array(
			"fields"=>array( "Jefe.id", "Jefe.trabajadore_id",  "Trabajadore.id", "Trabajadore.estado", "Jefe_trabajador.id"),
			"joins"=> array( array("table" => "jefes", "alias" => "Jefe_trabajador", "type" => "LEFT", "conditions" => array("Jefe_trabajador.trabajadore_id = Trabajadore.id")),
				),
			"conditions"=>array( array("Trabajadore.tipo_contrato_id !=" => 3, "Trabajadore.jefe_id" => $jefeId),		
				"OR" => array(
					array("Trabajadore.estado"=>"Activo"),
					array("Jefe_trabajador.trabajadore_id not"=>null)
					)
				),
			"recursive"=>0
			));
		$trabajadoresGerencia = $this->Trabajadore->find("all", array(
			"fields"=>array("Jefe.id", "Jefe.trabajadore_id", "Trabajadore.id","Trabajadore.estado", "Jefe_trabajador.id"),
			"joins"=> array( array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
				array("table" => "jefes", "alias" => "Jefe_trabajador", "type" => "LEFT", "conditions" => array("Jefe_trabajador.trabajadore_id = Trabajadore.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
				),
			"conditions"=>array( array("Trabajadore.tipo_contrato_id !=" => 3, "Trabajadore.jefe_id not" => null,"Gerencia.id"=>$gerenciaId),		
				"OR" => array(
					array("Trabajadore.estado"=>"Activo"),
					array("Jefe_trabajador.trabajadore_id not"=>null)
					)
				),	
			"recursive"=>0
			));

		$jefesGerencia = $this->Jefe->find("all", array(
			"fields" => array("Jefe.id","Jefe.trabajadore_id"),
			"conditions" => array("Trabajadore.tipo_contrato_id !=" => 3,"Trabajadore.cargo_id not"=> null),
			"recursive" => 0));	

		foreach ($trabajadoresGerencia as $trabajador) {
			$trabajadoresArray[$trabajador["Jefe"]["id"]]["Trabajadores"][$trabajador["Trabajadore"]["id"]] = array("Trabajadore"=>$trabajador["Trabajadore"],
				"Jefe_trabajador"=>$trabajador["Jefe_trabajador"]["id"]);
		}

		foreach ($jefesGerencia as $jefe) {
			if(isset($trabajadoresArray[$jefe["Jefe"]["id"]])){
				$jefesArray[$jefe["Jefe"]["id"]] = array_merge($jefe, $trabajadoresArray[$jefe["Jefe"]["id"]]);
			}
		}
		foreach ($jefesArray as $jefe) {
			$nuevoArray[$jefe["Jefe"]["trabajadore_id"]] =  array(
				"trabajadore_id" => $jefe["Jefe"]["trabajadore_id"],
				"Trabajadore"	=> $jefe["Trabajadores"],
				"nr_trabajadores" => (count($jefe["Trabajadores"])>0)? count($jefe["Trabajadores"]): false,
				);
		}		
		/* total de trabajadores */
		$finalizado = false;
		$revisandos = array();
		while(!$finalizado){
			$tra = "";
			$validador = false;				
			foreach ($trabajadoresPorJefe as $trabajador) {
				if($trabajador["Trabajadore"]["estado"]!="Retirado" || isset($nuevoArray[$trabajador["Trabajadore"]["id"]]["nr_trabajadores"])){
					if(!isset($trabajador["revisado"])){		
						if(isset($nuevoArray[$trabajador["Trabajadore"]["id"]])){
							$tra[] = array_merge($trabajador, array("revisado"=>1,"es_jefe"=>1));
							foreach ($nuevoArray[$trabajador["Trabajadore"]["id"]]["Trabajadore"] as $trabaja) {
								$tra[] = array_merge($trabaja,array("es_jefe"=>0));
							}
						}else{	
							$tra[] = array_merge($trabajador, array("revisado"=>1,"es_jefe"=>0));
						}
						$validador = true;
					}else{
						$tra[] = $trabajador;
					}
					$trabajadoresPorJefe = $tra;
					if(!$validador){
						$finalizado = true;
					}
				} else {
					$finalizado = true;
				}						
			}
		}
		$trabajadoresActivos = array();
		foreach ($trabajadoresPorJefe as $trabajador) if($trabajador["Trabajadore"]["estado"]=='Activo') $trabajadoresActivos[] = $trabajador["Trabajadore"]["estado"];
		return count($trabajadoresActivos);
	}

	public function cumpleanos_trabajadores(){
		header("Access-Control-Allow-Origin: *");
		$this->autoRender = false;
		$serv = new ServiciosController();
		$trabajadores = $this->Trabajadore->find("all", array(
			"fields"=>array( "Trabajadore.id", "Trabajadore.nombre" , "Trabajadore.apellido_paterno", "Trabajadore.rut", "Trabajadore.fecha_nacimiento", "Trabajadore.foto", "Trabajadore.email", "Gerencia.nombre" ),
			"joins"=> array(array("table" => "cargos", "alias" => "Cargo", "type" => "LEFT", "conditions" => array("Trabajadore.cargo_id = Cargo.id")),
				array("table" => "areas", "alias" => "Area", "type" => "LEFT", "conditions" => array("Cargo.area_id = Area.id")),
				array("table" => "gerencias", "alias" => "Gerencia", "type" => "LEFT", "conditions" => array("Area.gerencia_id = Gerencia.id")),
				),
			"conditions"=> array("Trabajadore.estado"=>"Activo", "Trabajadore.tipo_contrato_id !=" => 3, '(EXTRACT(MONTH FROM (Trabajadore.fecha_nacimiento))) = (EXTRACT(MONTH FROM now()))'),						
			"recursive"=> -1
			));		
		foreach ($trabajadores as $trabajador) {
			$fechaNacimiento = new DateTime($trabajador["Trabajadore"]["fecha_nacimiento"]);
			$listaTrabajadores[] = array(
				"id" 					=> $trabajador["Trabajadore"]["id"],
				"rut" 					=> $trabajador["Trabajadore"]["rut"],
				"nombre"				=> $serv->capitalize($trabajador["Trabajadore"]["nombre"].' '.$trabajador["Trabajadore"]["apellido_paterno"]), 
				"fecha_nacimiento"		=> $fechaNacimiento->format('d-m'),
				"dia_nacimiento"		=> $fechaNacimiento->format('d'),
				"mes_nacimiento"		=> $fechaNacimiento->format('m'),
				"foto" 					=> $trabajador["Trabajadore"]["foto"],
				"email" 				=> $trabajador["Trabajadore"]["email"],
				"gerencia" 				=> $serv->capitalize($trabajador["Gerencia"]["nombre"])								
				);
		}		
		if(!empty($listaTrabajadores)){
			usort($listaTrabajadores, function($a, $b) {				
			    return $a['dia_nacimiento'] - $b['dia_nacimiento'];	// ASC
			});
		}else{
			$listaTrabajadores = array();
		}	
		$fechaActual = new DateTime;
		setlocale(LC_TIME, "es_CL");
		$mesActual = strftime("%B",$fechaActual->getTimestamp());
		$cumpleanosTrabajadores = array("trabajadores" => $listaTrabajadores,
			"fecha_actual" => $fechaActual->format('d-m'),
			"mes_actual" => $serv->capitalize($mesActual),
			"ano_actual" => $fechaActual->format('Y'),
			);

		$this->set("cumpleanosTrabajadores", $cumpleanosTrabajadores);
		$this->set("_serialize","cumpleanosTrabajadores");
		return json_encode($cumpleanosTrabajadores);
	}

	public function sistema_lista_trabajadores()
	{
		$this->layout = "angular";
	}

	public function sistema_lista_trabajadores_json()
	{
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("Cargo");
		$this->loadModel("Gerencia");

		$trabajadores = $this->Trabajadore->find("all",array(
			"conditions"=>array(
				"Trabajadore.estado"=>"Activo",
				"Trabajadore.tipo_contrato_id !="=>3
			),
			"fields"=>array(
				"Trabajadore.id", 
				"Trabajadore.nombre", 
				"Trabajadore.apellido_paterno", 
				"Trabajadore.apellido_materno", 
				"Trabajadore.foto", 
				"Trabajadore.estado", 
				"Trabajadore.email", 
				"Trabajadore.anexo", 
				"Trabajadore.movil_corporativo",
				"Trabajadore.cargo_id"
			),
			"recursive"=>-0
		));

		if(!empty($trabajadores))
		{
			$cargos = $this->Cargo->find("all", array(
				"fields"=>array("Cargo.id", "Area.gerencia_id")
			));

			$gerenciasId = "";
			foreach($cargos as $cargo)
			{
				$gerenciasId[$cargo["Cargo"]["id"]][] = $cargo["Area"]["gerencia_id"]; 
			}

			$gerencias = $this->Gerencia->find("all", array(
				"fields"=>array("Gerencia.id", "Gerencia.nombre"),
				"recursive"=>-1
			));


			$nombreGerencias = "";
			foreach($gerencias as $gerencia)
			{
				$nombreGerencias[$gerencia["Gerencia"]["id"]] = $gerencia["Gerencia"]["nombre"];
			}
		}

		$dataTrabajadores = "";

		foreach($trabajadores as $trabajador)
		{
			$dataTrabajadores[] = array(
				"Id"=>$trabajador["Trabajadore"]["id"],
				"Nombre"=>$trabajador["Trabajadore"]["nombre"],
				"ApellidoPaterno"=>$trabajador["Trabajadore"]["apellido_paterno"],
				"ApellidoMaterno"=>$trabajador["Trabajadore"]["apellido_materno"],
				"Foto"=>$trabajador["Trabajadore"]["foto"],
				"Estado"=>$trabajador["Trabajadore"]["estado"],
				"Email"=>$trabajador["Trabajadore"]["email"],
				"Anexo"=>$trabajador["Trabajadore"]["anexo"],
				"MovilCorporativo"=>$trabajador["Trabajadore"]["movil_corporativo"],
				"Gerencia"=>(isset($gerenciasId[$trabajador["Trabajadore"]["cargo_id"]]) ? $nombreGerencias[$gerenciasId[$trabajador["Trabajadore"]["cargo_id"]][0]] : "")
			);
		}

		echo json_encode($dataTrabajadores);
		exit;
	}

	public function editar_trabajador_sistema()
	{	
		$this->autoRender = false;
		$this->response->type("json");

		$estado = "";
		$campo = "";
		if(!empty($this->data["columna"]))
		{
			switch ($this->data["columna"]) {
			    case "MovilCorporativo":
			       $campo = "movil_corporativo";
			        break;
			    case "Anexo":
			        $campo = "anexo";
			        break;
			    case "Email":
			        $campo = "email";
			        break;
			}

			$this->request->data["Trabajadore"]["id"] = $this->request->data["id"];
			$this->request->data["Trabajadore"][$campo] = $this->request->data["valor"];
			
			if($this->Trabajadore->save($this->request->data))
			{

				$Email = new CakeEmail("gmail");
				$Email->from(array('sgi@cdf.cl' => 'SGI'));
				$Email->to(array('rrhh@cdf.cl'));
				$Email->subject('Actualización información personal trabajador');
				$Email->emailFormat('html');
				$Email->template('edita_trabajador');
				$Email->viewVars(array(
						//"usuario"=>$this->Session->read("Users.nombre"),
						"usuario" => $this->request->data["Trabajadore"]["nombre"] . ' ' . $this->request->data["Trabajadore"]["apellido_paterno"],
						"fechaActualizacion"=>date("d/m/Y H:i"),
				));
				$Email->send();
				
				$estado = array("estado"=>1, "mensaje"=>"Registro Actualizado");
			}
			else
			{
				$estado = array("estado"=>0, "mensaje"=>"Nose puedo actualizar");
			}
		}
		else
		{
			$estado = array("estado"=>0, "mensaje"=>"Nose puedo actualizar");
		}

		echo json_encode($estado);
		exit;
	}

	public function lista_contratos(){
		$this->layout = "angular";
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function dotacion_por_gerencias($trabajadores, $fechaBusqueda){

		$this->autoRender = false;
		$this->loadModel("TipoContrato");
		$this->loadModel("Cargo");
		$this->loadModel("Area");
		$this->loadModel("Gerencia");
		$this->Trabajadore->Behaviors->load('Containable');
		$cargosLista = $this->Cargo->find("list", array("fields"=>array("Cargo.id", "Cargo.area_id")));
		$areasLista = $this->Area->find("list", array("fields"=>array("Area.id", "Area.gerencia_id")));
		$areasNombre = $this->Area->find("list", array("fields"=>array("Area.id", "Area.nombre")));
		$gerenciasLista = $this->Gerencia->find("list", array("fields"=>array("Gerencia.id", "Gerencia.nombre")));
		if($trabajadores){
			foreach ($trabajadores as $trabajador) {
				if(!empty($trabajador["Trabajadore"]["cargo_id"])){
					$cargos[] = $trabajador["Trabajadore"]["cargo_id"];
					if(empty($trabajador["Retiro"])){
						$anios[] = substr($trabajador["Trabajadore"]["fecha_ingreso"], 0,4);
					}else{
						if(count($trabajador["Retiro"]) == 1){
							$anios[] = substr($trabajador["Trabajadore"]["fecha_ingreso"], 0,4);
						}else{
							foreach ($trabajador["Retiro"] as $retiro) {
								$anios[] = substr($trabajador["Trabajadore"]["fecha_ingreso"], 0,4);
							}
						}
					}
					$trabajadoresPorArea[$areasNombre[$cargosLista[$trabajador["Trabajadore"]["cargo_id"]]]][$trabajador["Trabajadore"]["cargo_id"]][] = array(
						"Trabajadore"=>array(
							"fecha_ingreso"=>$trabajador["Trabajadore"]["fecha_ingreso"],
							"nombre"=>$trabajador["Trabajadore"]["nombre"],
							"apellido_paterno"=>$trabajador["Trabajadore"]["apellido_paterno"]
						),
						"Retiro"=>$trabajador["Retiro"]
					);
				}
			}
			$cargos = array_unique($cargos);
			foreach ($cargos as $cargo) {
				if(!isset($gerencias[$gerenciasLista[$areasLista[$cargosLista[$cargo]]]])){
					$gerencias[$gerenciasLista[$areasLista[$cargosLista[$cargo]]]][] = $areasNombre[$cargosLista[$cargo]];
				}else{
					if(!in_array($areasNombre[$cargosLista[$cargo]], $gerencias[$gerenciasLista[$areasLista[$cargosLista[$cargo]]]])){
						$gerencias[$gerenciasLista[$areasLista[$cargosLista[$cargo]]]][] = $areasNombre[$cargosLista[$cargo]];
					}
				}
			}
			$anioBusqueda = substr($fechaBusqueda, 0,4);
			$anioMinimo  = min($anios);
			for ($i=$anioMinimo; $i <= $anioBusqueda; $i++) { 
				$años[] = $i;
			}
			foreach ($gerencias as $gerencia => $areas) {
				foreach ($areas as $area) {
					foreach ($años as $anio) {
						foreach ($trabajadoresPorArea[$area] as $cargo => $trabajadoresArray) {
							foreach ($trabajadoresArray as $trabajador) {
								if(empty($trabajador["Retiro"])){
									if($trabajador["Trabajadore"]["fecha_ingreso"]<$fechaBusqueda){
										if(substr($trabajador["Trabajadore"]["fecha_ingreso"], 0, 4)<=$anio){
											$acumulados[$gerencia][$area][$anio][] = $trabajador["Trabajadore"];
										}
									}
								}else{
									if(count($trabajador["Retiro"])==1){
										if($trabajador["Retiro"][0]["fecha_ingreso"]<$fechaBusqueda){
											if(substr($trabajador["Retiro"][0]["fecha_ingreso"], 0, 4)<=$anio && substr($trabajador["Retiro"][0]["fecha_retiro"], 0, 4)>$anio){
												$acumulados[$gerencia][$area][$anio][] = $trabajador["Trabajadore"];	
											}elseif(substr($trabajador["Retiro"][0]["fecha_ingreso"], 0, 4)<=$anio && substr($trabajador["Retiro"][0]["fecha_retiro"], 0, 4)==$anio){
												if($anio == substr($fechaBusqueda, 0,4)){
													if($trabajador["Retiro"][0]["fecha_retiro"]>$fechaBusqueda){
														$acumulados[$gerencia][$area][$anio][] = $trabajador["Trabajadore"];
													}
												}
											}
										}
									}else{
										foreach ($trabajador["Retiro"] as $retiro) {
											if($retiro["fecha_ingreso"]<$fechaBusqueda){
												if(substr($retiro["fecha_ingreso"], 0, 4)<=$anio && substr($retiro["fecha_retiro"], 0, 4)>$anio){
													$acumulados[$gerencia][$area][$anio][] = $trabajador["Trabajadore"];	
												}elseif(substr($retiro["fecha_ingreso"], 0, 4)<=$anio && substr($retiro["fecha_retiro"], 0, 4)==$anio){
													if($anio == substr($fechaBusqueda, 0,4)){
														if($retiro["fecha_retiro"]>$fechaBusqueda){
															$acumulados[$gerencia][$area][$anio][] = $trabajador["Trabajadore"];
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			foreach ($acumulados as $gerencia => $areas) {
				foreach ($areas as $area => $anios) {
					foreach ($anios as $anio => $valores) {
						isset($respuesta["totales"][$gerencia][$anio]) ? "" : $respuesta["totales"][$gerencia][$anio] = 0;
						isset($respuesta["total_general"][$anio]) ? "" : $respuesta["total_general"][$anio] = 0;
						$respuesta["data"][$gerencia][$area][$anio] = count($valores);
						$respuesta["total_general"][$anio] += $respuesta["data"][$gerencia][$area][$anio];
						$respuesta["totales"][$gerencia][$anio] += $respuesta["data"][$gerencia][$area][$anio];
					}
				}
			}
			$respuesta["anios"] = $años;
			$respuesta["gerencias"] = $gerencias;
		}else{
			$respuesta = array();
		}
		
		return $respuesta;
	}

	public function dotacion_trabajadores(){
		$this->layout = "angular";
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}	
	}

	public function dotacion_sexo_tipo_contrato($trabajadores, $fechaBusqueda){
		$this->autoRender = false;
		//$this->response->type("json");
		$this->loadModel("TipoContrato");
		$this->Trabajadore->Behaviors->load('Containable');
		//pr($trabajadores);exit;
		if(!empty($trabajadores)){
			foreach ($trabajadores as $trabajadore) {
				if(!empty($trabajadore["Trabajadore"]["tipo_contrato_id"])){
					if(is_numeric($trabajadore["Trabajadore"]["sexo"])){
						if(empty($trabajadore["Retiro"])){
							$agrupados[$trabajadore["Trabajadore"]["tipo_contrato_id"]][$trabajadore["Trabajadore"]["sexo"]][] = $trabajadore["Trabajadore"]["id"];
							$detallePersonas[] = array(
								"id"=>$trabajadore["Trabajadore"]["id"],
								"nombre"=>$trabajadore["Trabajadore"]["nombre"],
								"rut"=>$trabajadore["Trabajadore"]["rut"],
								"apellido_paterno"=>$trabajadore["Trabajadore"]["apellido_paterno"],
								"apellido_materno"=>$trabajadore["Trabajadore"]["apellido_materno"],
								"sexo"=>$trabajadore["Trabajadore"]["sexo"],
								"tipo_contrato_id"=>$trabajadore["Trabajadore"]["tipo_contrato_id"],
								"fecha_nacimiento"=>$trabajadore["Trabajadore"]["fecha_nacimiento"],
								"fecha_ingreso"=>$trabajadore["Trabajadore"]["fecha_ingreso"],
								"fecha_retiro"=>null
							);
						}else{
							if(count($trabajadore["Retiro"])==1){
								($trabajadore["Retiro"][0]["fecha_retiro"]>$fechaBusqueda) ? $agrupados[$trabajadore["Trabajadore"]["tipo_contrato_id"]][$trabajadore["Trabajadore"]["sexo"]][] = $trabajadore["Trabajadore"]["id"] : "";
								($trabajadore["Retiro"][0]["fecha_retiro"]>$fechaBusqueda) ? $detallePersonas[] = array(
									"id"=>$trabajadore["Trabajadore"]["id"],
									"nombre"=>$trabajadore["Trabajadore"]["nombre"],
									"rut"=>$trabajadore["Trabajadore"]["rut"],
									"apellido_paterno"=>$trabajadore["Trabajadore"]["apellido_paterno"],
									"apellido_materno"=>$trabajadore["Trabajadore"]["apellido_materno"],
									"sexo"=>$trabajadore["Trabajadore"]["sexo"],
									"tipo_contrato_id"=>$trabajadore["Trabajadore"]["tipo_contrato_id"],
									"fecha_nacimiento"=>$trabajadore["Trabajadore"]["fecha_nacimiento"],
									"fecha_ingreso"=>$trabajadore["Retiro"][0]["fecha_ingreso"],
									"fecha_retiro"=>$trabajadore["Retiro"][0]["fecha_retiro"],
								) : "";
							}else{
								$fechasRetiros = array_map(function($retiro){ return $retiro["fecha_retiro"]; }, $trabajadore["Retiro"]);
								foreach ($trabajadore["Retiro"] as $retiro) {
									$fechasRetiros[$retiro["fecha_retiro"]] = $retiro;
								}
								if(max(array_keys($fechasRetiros))>$fechaBusqueda){
									$agrupados[$trabajadore["Trabajadore"]["tipo_contrato_id"]][$trabajadore["Trabajadore"]["sexo"]][] = $trabajadore["Trabajadore"]["id"];
									$detallePersonas[] = array(
										"id"=>$trabajadore["Trabajadore"]["id"],
										"nombre"=>$trabajadore["Trabajadore"]["nombre"],
										"rut"=>$trabajadore["Trabajadore"]["rut"],
										"apellido_paterno"=>$trabajadore["Trabajadore"]["apellido_paterno"],
										"apellido_materno"=>$trabajadore["Trabajadore"]["apellido_materno"],
										"sexo"=>$trabajadore["Trabajadore"]["sexo"],
										"tipo_contrato_id"=>$trabajadore["Trabajadore"]["tipo_contrato_id"],
										"fecha_nacimiento"=>$trabajadore["Trabajadore"]["fecha_nacimiento"],
										"fecha_ingreso"=>$fechasRetiros[max(array_keys($fechasRetiros))]["fecha_ingreso"],
										"fecha_retiro"=>$fechasRetiros[max(array_keys($fechasRetiros))]["fecha_retiro"]
									);
								}
								/*$activo = "";
								foreach($trabajadore["Retiro"] as $retiro) {
									$fechasRetiros[] = array(
										"fecha_retiro"=>$retiro["fecha_retiro"],
										"fecha_ingreso"=>$retiro["fecha_ingreso"]
									);
								}
								sort($fechasRetiros);
								foreach($fechasRetiros as $fechas){
									if($fechas["fecha_retiro"]>$fechaBusqueda){
										$activo = true;
										$fecha_retiro = $fechas["fecha_retiro"];
										$fecha_ingreso = $fechas["fecha_ingreso"];
									}else{
										$activo = false;
									} 
								}
								if($activo){
									$agrupados[$trabajadore["Trabajadore"]["tipo_contrato_id"]][$trabajadore["Trabajadore"]["sexo"]][] = $trabajadore["Trabajadore"]["id"];
									$detallePersonas[] = array(
										"id"=>$trabajadore["Trabajadore"]["id"],
										"nombre"=>$trabajadore["Trabajadore"]["nombre"],
										"rut"=>$trabajadore["Trabajadore"]["rut"],
										"apellido_paterno"=>$trabajadore["Trabajadore"]["apellido_paterno"],
										"apellido_materno"=>$trabajadore["Trabajadore"]["apellido_materno"],
										"sexo"=>$trabajadore["Trabajadore"]["sexo"],
										"tipo_contrato_id"=>$trabajadore["Trabajadore"]["tipo_contrato_id"],
										"fecha_nacimiento"=>$trabajadore["Trabajadore"]["fecha_nacimiento"],
										"fecha_ingreso"=>$fecha_ingreso,
										"fecha_retiro"=>$fecha_retiro
									);
								}*/
							}
						}
					}
				};
			}
			if(!empty($agrupados)){
				foreach ($agrupados as $tipoContrato => $sexos) {
					foreach ($sexos as $sexo => $trabajadores) {
						$data[$tipoContrato][$sexo]["total_sexo"] = count($trabajadores);
						isset($data[$tipoContrato]["total_tipo_contrato"]) ? $data[$tipoContrato]["total_tipo_contrato"] += $data[$tipoContrato][$sexo]["total_sexo"]: $data[$tipoContrato]["total_tipo_contrato"] = $data[$tipoContrato][$sexo]["total_sexo"];
					}
					foreach ($sexos as $sexo => $trabajadores) {
						if(isset($data[$tipoContrato]["total_tipo_contrato"])){
							if($data[$tipoContrato][$sexo]["total_sexo"]){
								$data[$tipoContrato][$sexo]["porcentaje_sexo"] = round(($data[$tipoContrato][$sexo]["total_sexo"]*100)/$data[$tipoContrato]["total_tipo_contrato"], 2);
							}
							isset($data["total_general"][$sexo]) ? $data["total_general"][$sexo] += $data[$tipoContrato][$sexo]["total_sexo"] : $data["total_general"][$sexo] = $data[$tipoContrato][$sexo]["total_sexo"];							
						}	
					}
				}				
				if(!empty($data["total_general"])){
					foreach ($data["total_general"] as $sexo => $total) {
						$data["total_general"]["porcentaje"][$sexo] = round(($data["total_general"][$sexo]*100)/array_sum($data["total_general"]),2);
					}
					$data["total_general"]["total"] = array_sum($data["total_general"]);
					$respuesta = array(
						"estado"=>1,
						"data"=>array(
							"datos"=>$data,
							"tipo_contratos"=>$this->TipoContrato->find("list", array("fields"=>"TipoContrato.nombre")),
							"fecha"=>$fechaBusqueda,
							"detallePersonas"=>$detallePersonas
						)
					);
				}
			}
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No se encontraron trabajadores"
			);
		}		
		return $respuesta;
	}

	public function trabajadores_agrupados_antiguedad($trabajadores, $fechaBusqueda){		
		$this->autoRender = false;
		$this->Trabajadore->Behaviors->load('Containable');
		$fechaBusquedaObj = new DateTime($fechaBusqueda);
		if(!empty($trabajadores)){
			foreach ($trabajadores as $trabajador) {
				//pr($trabajador);
				$fechaIngresoObj = new DateTime($trabajador["Trabajadore"]["fecha_ingreso"]);
				if(is_numeric($trabajador["Trabajadore"]["sexo"])){
					if(empty($trabajador["Retiro"])){
						$diferenciaFechas = $fechaIngresoObj->diff($fechaBusquedaObj);
					//($diferenciaFechas->y >= 7) ? $traPorAnio[7][$trabajador["Trabajadore"]["sexo"]][] = $trabajador["Trabajadore"]["id"] : $traPorAnio[$diferenciaFechas->y][$trabajador["Trabajadore"]["sexo"]][] = $trabajador["Trabajadore"]["id"]; 
						$traPorAnio[$diferenciaFechas->y][$trabajador["Trabajadore"]["sexo"]][] = array(
							"id"=>$trabajador["Trabajadore"]["id"],
							"nombre"=>$trabajador["Trabajadore"]["nombre"],
							"rut"=>$trabajador["Trabajadore"]["rut"],
							"apellido_paterno"=>$trabajador["Trabajadore"]["apellido_paterno"],
							"apellido_materno"=>$trabajador["Trabajadore"]["apellido_materno"],
							"sexo"=>$trabajador["Trabajadore"]["sexo"],
							"tipo_contrato_id"=>$trabajador["Trabajadore"]["tipo_contrato_id"],
							"fecha_nacimiento"=>$trabajador["Trabajadore"]["fecha_nacimiento"],
							"fecha_ingreso"=>$trabajador["Trabajadore"]["fecha_ingreso"],
							"fecha_retiro"=>null
						);
						//$agrupados[$trabajadore["Trabajadore"]["tipo_contrato_id"]][$trabajadore["Trabajadore"]["sexo"]][] = $trabajadore["Trabajadore"]["id"]
						
					}else{
						if(count($trabajador["Retiro"])==1){
							if($trabajador["Retiro"][0]["fecha_retiro"]>$fechaBusqueda){
								$fechaIngresoRetiroObj = new DateTime($trabajador["Retiro"][0]["fecha_ingreso"]);
								$fechaRetiroObj = new DateTime($trabajador["Retiro"][0]["fecha_retiro"]);
								$diferenciaFechas = $fechaIngresoRetiroObj->diff($fechaBusquedaObj);
								//($diferenciaFechas->y >= 7) ? $traPorAnio[7][$trabajador["Trabajadore"]["sexo"]][] = $trabajador["Trabajadore"]["id"] : $traPorAnio[$diferenciaFechas->y][$trabajador["Trabajadore"]["sexo"]][] = $trabajador["Trabajadore"]["id"]; 
								$traPorAnio[$diferenciaFechas->y][$trabajador["Trabajadore"]["sexo"]][] = array(
									"id"=>$trabajador["Trabajadore"]["id"],
									"nombre"=>$trabajador["Trabajadore"]["nombre"],
									"rut"=>$trabajador["Trabajadore"]["rut"],
									"apellido_paterno"=>$trabajador["Trabajadore"]["apellido_paterno"],
									"apellido_materno"=>$trabajador["Trabajadore"]["apellido_materno"],
									"sexo"=>$trabajador["Trabajadore"]["sexo"],
									"tipo_contrato_id"=>$trabajador["Trabajadore"]["tipo_contrato_id"],
									"fecha_nacimiento"=>$trabajador["Trabajadore"]["fecha_nacimiento"],
									"fecha_ingreso"=>$trabajador["Retiro"][0]["fecha_ingreso"],
									"fecha_retiro"=>$trabajador["Retiro"][0]["fecha_retiro"],
								);
							}
						}else{
							$fechasRetiros = array_map(function($retiro){ return $retiro["fecha_retiro"]; }, $trabajador["Retiro"]);
							foreach ($trabajador["Retiro"] as $retiro) {
								$fechasRetiros[$retiro["fecha_retiro"]] = $retiro;
							}
							if(max(array_keys($fechasRetiros))>$fechaBusqueda){
								$fechaInicialDiferencia = new DateTime($fechasRetiros[max(array_keys($fechasRetiros))]["fecha_ingreso"]);
								$diferenciaFechas = $fechaInicialDiferencia->diff($fechaBusquedaObj);
								//($diferenciaFechas->y >= 7) ? $traPorAnio[7][$trabajador["Trabajadore"]["sexo"]][] = $trabajador["Trabajadore"]["id"] : $traPorAnio[$diferenciaFechas->y][$trabajador["Trabajadore"]["sexo"]][] = $trabajador["Trabajadore"]["id"]; 
								$traPorAnio[$diferenciaFechas->y][$trabajador["Trabajadore"]["sexo"]][] = array(
									"id"=>$trabajador["Trabajadore"]["id"],
									"nombre"=>$trabajador["Trabajadore"]["nombre"],
									"rut"=>$trabajador["Trabajadore"]["rut"],
									"apellido_paterno"=>$trabajador["Trabajadore"]["apellido_paterno"],
									"apellido_materno"=>$trabajador["Trabajadore"]["apellido_materno"],
									"sexo"=>$trabajador["Trabajadore"]["sexo"],
									"tipo_contrato_id"=>$trabajador["Trabajadore"]["tipo_contrato_id"],
									"fecha_nacimiento"=>$trabajador["Trabajadore"]["fecha_nacimiento"],
									"fecha_ingreso"=>$fechasRetiros[max(array_keys($fechasRetiros))]["fecha_ingreso"],
									"fecha_retiro"=>$fechasRetiros[max(array_keys($fechasRetiros))]["fecha_retiro"]
								);
							}
							/*$activo = "";
							foreach($trabajador["Retiro"] as $retiro) {
								$fechasRetiros[] = array(
									"fecha_retiro"=>$retiro["fecha_retiro"],
									"fecha_ingreso"=>$retiro["fecha_ingreso"]
								);
							}
							sort($fechasRetiros);
							foreach($fechasRetiros as $fechas){
								if($fechas["fecha_retiro"]>$fechaBusqueda){
									$activo = true;
									$fecha_retiro = $fechas["fecha_retiro"];
									$fecha_ingreso = $fechas["fecha_ingreso"];
								}else{
									$activo = false;
								} 
							}
							if($activo){
								$fechaInicialDiferencia = new DateTime($fecha_ingreso);
								$diferenciaFechas = $fechaInicialDiferencia->diff($fechaBusquedaObj);
								//($diferenciaFechas->y >= 7) ? $traPorAnio[7][$trabajador["Trabajadore"]["sexo"]][] = $trabajador["Trabajadore"]["id"] : $traPorAnio[$diferenciaFechas->y][$trabajador["Trabajadore"]["sexo"]][] = $trabajador["Trabajadore"]["id"]; 
								$traPorAnio[$diferenciaFechas->y][$trabajador["Trabajadore"]["sexo"]][] = array(
									"id"=>$trabajador["Trabajadore"]["id"],
									"nombre"=>$trabajador["Trabajadore"]["nombre"],
									"rut"=>$trabajador["Trabajadore"]["rut"],
									"apellido_paterno"=>$trabajador["Trabajadore"]["apellido_paterno"],
									"apellido_materno"=>$trabajador["Trabajadore"]["apellido_materno"],
									"sexo"=>$trabajador["Trabajadore"]["sexo"],
									"tipo_contrato_id"=>$trabajador["Trabajadore"]["tipo_contrato_id"],
									"fecha_nacimiento"=>$trabajador["Trabajadore"]["fecha_nacimiento"],
									"fecha_ingreso"=>$trabajador["Retiro"][0]["fecha_ingreso"],
									"fecha_retiro"=>$trabajador["Retiro"][0]["fecha_retiro"],
								);
							}*/
						}
					}
				}
			}
			if(!empty($traPorAnio)){
				foreach ($traPorAnio as $anio => $sexos) {
					foreach ($sexos as $sexo => $valores) {
						$gruposContados["anios"][$anio][$sexo] = count($valores);
						isset($gruposContados["anios"][$anio]["total"]) ? $gruposContados["anios"][$anio]["total"] += $gruposContados["anios"][$anio][$sexo]: $gruposContados["anios"][$anio]["total"] = $gruposContados["anios"][$anio][$sexo];
						foreach ($valores as  $valor) {
							$valor["anios"] = $anio;
							$detallePersonas[] = $valor;
						}
					}
					
				}
				$gruposContados["detallePersonas"] = $detallePersonas;
				if(!empty($gruposContados)){
					foreach ($gruposContados["anios"] as $anio => $sexos) {
						foreach ($sexos as $sexo => $conteo) {
							if(is_numeric($sexo)){
								isset($gruposContados["totales"][$sexo]) ? $gruposContados["totales"][$sexo] += $conteo : $gruposContados["totales"][$sexo] = $conteo;
							}
						}
					}
					$gruposContados["totales"]["total"] = array_sum($gruposContados["totales"]);
					foreach ($gruposContados["anios"] as $anio => $sexos) {
						$gruposContados["anios"][$anio]["porcentaje"] = round(($gruposContados["anios"][$anio]["total"]*100)/$gruposContados["totales"]["total"],2);  
						foreach ($sexos as $sexo => $conteo) {
							isset($gruposContados["antiguedadPro"][$sexo]) ? $gruposContados["antiguedadPro"][$sexo] += $conteo*$anio : $gruposContados["antiguedadPro"][$sexo] = $conteo*$anio;
						}
					}
					if(!empty($gruposContados["antiguedadPro"])){
						foreach ($gruposContados["antiguedadPro"] as $key => $sumatoria) {
							$gruposContados["antiguedadPro"][$key] = round($sumatoria/$gruposContados["totales"][$key],2);
						}
					}
					$limpiar = true;
					foreach ($gruposContados["anios"] as $anio => $sexos) {
						foreach ($sexos as $sexo => $conteo) {
							if($anio>=7){
								$masDeSieteAnios[$sexo][] = $conteo;
							}
						}
						if($anio>7){
							unset($gruposContados["anios"][$anio]);
						}
					}
					unset($gruposContados["anios"][7]);
					if(isset($masDeSieteAnios)){
						foreach ($masDeSieteAnios as $key => $masDeSieteAnio) {
							$gruposContados["anios"][7][$key] = array_sum($masDeSieteAnio);
						}	
					}
					foreach ($gruposContados["anios"] as $anio => $value) {
						$gruposContados["anios"][$anio]["anio"] = $anio;
					};
				}
			}
		}else{
			$gruposContados = array();	
		}
		return $gruposContados;
	}

	public function trabajadores_por_area(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->Trabajadore->Behaviors->load('Containable');
		$this->Trabajadore->virtualFields['nombre_completo'] = "(Trabajadore.nombre || ' ' || Trabajadore.apellido_paterno)";
		$trabajadores = $this->Trabajadore->find("list", array(
			"fields"=>array(
				"Trabajadore.nombre_completo",
			),
			"contain"=>array(
				"Cargo"
			),
			"conditions"=>array(
				"Cargo.area_id"=>$this->request->query["idArea"],
				"Trabajadore.estado"=>"Activo"
			)
		));
		return json_encode($trabajadores);
	}

	public function data_dotacion_trabajadores(){
		$this->autoRender = false;
		$this->response->type("json");
		$fechaBusqueda = isset($this->request->query["fecha"]) ? $this->request->query["fecha"] : date("Y-m-d");
		$trabajadores = $this->Trabajadore->find("all", array(
			"fields"=>array(
				"Trabajadore.tipo_contrato_id",
				"Trabajadore.sexo",
				"Trabajadore.id",
				"Trabajadore.nombre",
				"Trabajadore.apellido_paterno",
				"Trabajadore.apellido_materno",
				"Trabajadore.fecha_ingreso",
				"Trabajadore.fecha_nacimiento",
				"Trabajadore.rut",
				"Trabajadore.cargo_id",
				"Trabajadore.estados_civile_id",
				"Trabajadore.estado",
			),
			"contain"=>array(
				"Retiro"=>array(
					"fields"=>array(
						"Retiro.id",
						"Retiro.fecha_retiro",
						"Retiro.fecha_ingreso",
						"Retiro.motivo_retiro_id"
					),
					"order"=>"Retiro.fecha_retiro ASC"
				)
			),
			"conditions"=>array(
				"Trabajadore.tipo_contrato_id <>"=>3,
				"Trabajadore.fecha_ingreso <="=>$fechaBusqueda,
				"Trabajadore.estado <>"=>"Prospecto"
			)
		));

		$respuesta["dotacion_sexo_tipo_contrato"] = $this->dotacion_sexo_tipo_contrato($trabajadores, $fechaBusqueda);
		$respuesta["trabajadores_agrupados_antiguedad"] = $this->trabajadores_agrupados_antiguedad($trabajadores, $fechaBusqueda);
		$respuesta["dotacion_por_gerencias"] = $this->dotacion_por_gerencias($trabajadores, $fechaBusqueda);
		$respuesta["trabajadores_rango_edades"] = $this->trabajadores_rango_edades($trabajadores, $fechaBusqueda);
		$respuesta["trabajadores_estado_civil"] = $this->trabajadores_estado_civil($trabajadores, $fechaBusqueda);
		$respuesta["trabajadores_desvinculaciones"] = $this->trabajadores_desvinculaciones($trabajadores, $fechaBusqueda);
		return json_encode($respuesta);
	}

	public function trabajadores_rango_edades($trabajadores, $fechaBusqueda){
		$this->autoRender = false;
		if(!empty($trabajadores)){
			foreach ($trabajadores as $trabajador) {
				//if($trabajador["Trabajadore"]["estado"] != "Retirado")
				//{
					if(!empty($trabajador["Trabajadore"]["fecha_nacimiento"])){
						$fechaNacimiento = new DateTime($trabajador["Trabajadore"]["fecha_nacimiento"]);
						$fechaBusquedaObj = new DateTime($fechaBusqueda);
						if(empty($trabajador["Retiro"])){
							if($fechaBusquedaObj>=$fechaNacimiento){
								$diferenciaFechas = date_diff($fechaNacimiento,$fechaBusquedaObj);
								if($diferenciaFechas->y<25){
									$agrupados[0][]  = $trabajador["Trabajadore"];
								}
								if($diferenciaFechas->y>=25 && $diferenciaFechas->y<35){
									$agrupados[25][]  = $trabajador["Trabajadore"];
								}
								if($diferenciaFechas->y>=35 && $diferenciaFechas->y<45){
									$agrupados[35][]  = $trabajador["Trabajadore"];
								}
								if($diferenciaFechas->y>=45){
									$agrupados[45][]  = $trabajador["Trabajadore"];
								}
							}else{
								//pr("entra");
							}
						}else{
							if(count($trabajador["Retiro"])==1){
								if($trabajador["Retiro"][0]["fecha_retiro"]>$fechaBusqueda){
									if($fechaBusquedaObj>=$fechaNacimiento){
										$diferenciaFechas = date_diff($fechaNacimiento,$fechaBusquedaObj);
										if($diferenciaFechas->y<25){
											$agrupados[0][]  = $trabajador["Trabajadore"];
										}
										if($diferenciaFechas->y>=25 && $diferenciaFechas->y<35){
											$agrupados[25][]  = $trabajador["Trabajadore"];
										}
										if($diferenciaFechas->y>=35 && $diferenciaFechas->y<45){
											$agrupados[35][]  = $trabajador["Trabajadore"];
										}
										if($diferenciaFechas->y>=45){
											$agrupados[45][]  = $trabajador["Trabajadore"];
										}
									}else{
										//pr("entra");
									}
								}
							}else{
								$fechasRetiros = array_map(function($retiro){ return $retiro["fecha_retiro"]; }, $trabajador["Retiro"]);
								if(max($fechasRetiros)>$fechaBusqueda){
									if($fechaBusquedaObj>=$fechaNacimiento){
										$diferenciaFechas = date_diff($fechaNacimiento,$fechaBusquedaObj);
										if($diferenciaFechas->y<25){
											$agrupados[0][]  = $trabajador["Trabajadore"];
										}
										if($diferenciaFechas->y>=25 && $diferenciaFechas->y<35){
											$agrupados[25][]  = $trabajador["Trabajadore"];
										}
										if($diferenciaFechas->y>=35 && $diferenciaFechas->y<45){
											$agrupados[35][]  = $trabajador["Trabajadore"];
										}
										if($diferenciaFechas->y>=45){
											$agrupados[45][]  = $trabajador["Trabajadore"];
										}
									}else{
										
									}
								}
							}
						}
					}
				//}	
			}
			if(!empty($agrupados)){
				$respuesta["total"] = 0;
				foreach ($agrupados as $rango => $trabajadores) {
					$respuesta[$rango] = count($trabajadores);
					$respuesta["total"]+=count($trabajadores); 
				}
			}else{
				$respuesta = array();
			}
		}else{
			$respuesta = array();
		}
		return $respuesta;
	}

	public function trabajadores_estado_civil($trabajadores, $fechaBusqueda){
		$this->autoRender = false;
		$estadosCiviles = new EstadosCivilesController;
		$respuesta["estadosCiviles"] = json_decode($estadosCiviles->estados_civiles_list());
		if(!empty($trabajadores)){
			foreach ($trabajadores as $trabajador) {
				//if($trabajador["Trabajadore"]["estado"] != "Retirado")
				//{
					if(!empty($trabajador["Trabajadore"]["estados_civile_id"])){
						$fechaBusquedaObj = new DateTime($fechaBusqueda);
						if(empty($trabajador["Retiro"])){
							$agrupados[$trabajador["Trabajadore"]["estados_civile_id"]][] = $trabajador["Trabajadore"];	
						}else{
							if(count($trabajador["Retiro"])==1){
								if($trabajador["Retiro"][0]["fecha_retiro"]>$fechaBusqueda){
									$agrupados[$trabajador["Trabajadore"]["estados_civile_id"]][] = $trabajador["Trabajadore"];
								}
							}else{
								$fechasRetiros = array_map(function($retiro){ return $retiro["fecha_retiro"]; }, $trabajador["Retiro"]);
								if(max($fechasRetiros)>$fechaBusqueda){
									$agrupados[$trabajador["Trabajadore"]["estados_civile_id"]][] = $trabajador["Trabajadore"];
								}
							}
						}
					}else{
						if(empty($trabajador["Retiro"])){
							$noDefinidos[] = $trabajador["Trabajadore"];
						}else{
							if(count($trabajador["Retiro"])==1){
								if($trabajador["Retiro"][0]["fecha_retiro"]>$fechaBusqueda){
									$noDefinidos[] = $trabajador["Trabajadore"];
								}
							}else{
								$fechasRetiros = array_map(function($retiro){ return $retiro["fecha_retiro"]; }, $trabajador["Retiro"]);
								if(max($fechasRetiros)>$fechaBusqueda){
									$noDefinidos[] = $trabajador["Trabajadore"];
								}
							}
						}
					}
				//}
			}
			if(isset($noDefinidos)){
				$respuesta["noDefinidos"] = count($noDefinidos);
			}
			if(!empty($agrupados)){
				$respuesta["data"]["total"] = 0;
				foreach ($agrupados as $estadoCivil => $trabajadores) {
					$respuesta["data"][$estadoCivil] = count($trabajadores);
					$respuesta["data"]["total"]+=count($trabajadores); 
				}
				if(isset($respuesta["noDefinidos"])){
					$respuesta["data"]["total"]+=$respuesta["noDefinidos"];
				}
			}else{
				$respuesta = array();
			}
		}else{
			$respuesta = array();
		}
		return $respuesta;
	}

	public function trabajadores_desvinculaciones($trabajadores, $fechaBusqueda){
		$this->autoRender = false;
		$this->loadModel("MotivoRetiro");
		$respuesta["motivosList"] = $this->MotivoRetiro->find("list", array("fields"=>array("MotivoRetiro.nombre")));
		setlocale(LC_ALL,"es_ES");
		if(!empty($trabajadores)){
			foreach ($trabajadores as $trabajador) {
				$fechaBusquedaObj = new DateTime($fechaBusqueda);
				if(!empty($trabajador["Retiro"])){
					if(count($trabajador["Retiro"])==1){
						if($trabajador["Retiro"][0]["fecha_retiro"]<$fechaBusqueda){
							$fechaRetiro = new DateTime($trabajador["Retiro"][0]["fecha_retiro"]);
							$agrupados["data"][$fechaRetiro->format("Y")][$fechaRetiro->format("n")][] = $trabajador["Trabajadore"];
							$anios[] = $fechaRetiro->format("Y");
							$agrupados["motivos"][$fechaRetiro->format("Y")][$trabajador["Retiro"][0]["motivo_retiro_id"]][] = $trabajador["Trabajadore"];	
						}
					}else{
						foreach ($trabajador["Retiro"] as $retiro) {
							if($retiro["fecha_retiro"]<$fechaBusqueda){
								$fechaRetiro = new DateTime($retiro["fecha_retiro"]);
								$agrupados["data"][$fechaRetiro->format("Y")][$fechaRetiro->format("n")][] = $trabajador["Trabajadore"];
								$anios[] = $fechaRetiro->format("Y");
								$agrupados["motivos"][$fechaRetiro->format("Y")][$trabajador["Retiro"][0]["motivo_retiro_id"]][] = $trabajador["Trabajadore"];	
							}
						}
					}
				}
			}
			$anioBusqueda = substr($fechaBusqueda, 0,4);
			$anioMinimo  = (int)min($anios);
			for ($i=$anioMinimo; $i <= $anioBusqueda; $i++) { 
				$respuesta["anios"][] = $i;
			}
			for ($i=1; $i <= 12 ; $i++) {
				$respuesta["meses"][] = array(
					"mes"=>$i,
					"nombre"=>strftime("%B",mktime(0,0,0,$i,1,2000))
				);
			}
			if(!empty($agrupados)){
				foreach ($agrupados["data"] as $anio => $meses) {
					$respuesta["data"]["total"]["anios"][$anio] = 0;
					foreach ($meses as $mes => $trabajadores) {
						$respuesta["data"]["meses"][$anio][$mes] = count($trabajadores);
						$respuesta["data"]["total"]["anios"][$anio]+=count($trabajadores);
					}
					isset($respuesta["data"]["meses"][$anio]) ? $respuesta["data"]["meses"][$anio]["total"] = array_sum($respuesta["data"]["meses"][$anio]) : "";
				}
				$respuesta["data"]["total"]["general"] = array_sum($respuesta["data"]["total"]["anios"]);

				foreach ($agrupados["motivos"] as $anio => $motivos) {
					//$respuesta["data"]["total"]["anios"][$anio] = 0;
					foreach ($motivos as $motivo => $trabajadores) {
						$respuesta["motivos"][$anio][$motivo] = count($trabajadores);
					}
					//isset($respuesta["data"]["meses"][$anio]) ? $respuesta["data"]["meses"][$anio]["total"] = array_sum($respuesta["data"]["meses"][$anio]) : "";
				}
				//$respuesta["data"]["total"]["general"] = array_sum($respuesta["data"]["total"]["anios"]);
			}else{
				$respuesta = array();
			}
		}else{
			$respuesta = array();
		}
		return $respuesta;
	}
	public function enviarCorreoAntiguedad(){
		
		$this->layout = null;
		if(date('d') == '20'){
			$trabajadores = $this->Trabajadore->find('all', array(
				'conditions'=>array(
					'Trabajadore.estado'=>'Activo'
				),
				'fields'=>array(
					"Trabajadore.id",
					"Trabajadore.nombre",
					"Trabajadore.apellido_paterno",
					"Trabajadore.apellido_materno",
					"Trabajadore.fecha_ingreso"									
				),
				'recursive'=>-1			
			));
			
			$salidaAntiguedad = '';
		
	
			$diasMes = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
			$inicioMes = strtotime(date("Y").'-'.date("m").'-01');
			$finMes = strtotime(date("Y").'-'.date("m").'-'.$diasMes);
	
			$fechaActual = new Datetime(); 
	
			foreach($trabajadores as $trabajador){
				$fechaIngreso = $trabajador['Trabajadore']['fecha_ingreso'];
				$nuevafecha = strtotime ( '+5 year' , strtotime ( $fechaIngreso ) ) ;
				$nuevafecha = date ('Y-m-j' , $nuevafecha);
				$cumple = strtotime($nuevafecha);
	
				if($cumple >= $inicioMes && $cumple <= $finMes)
				{
					 $salidaAntiguedad[5][] = array(
						"nombre"=>$trabajador['Trabajadore']['nombre']. ' ' .$trabajador['Trabajadore']['apellido_paterno'],
						"fechaIngreso"=>$trabajador['Trabajadore']['fecha_ingreso'],
						"cumple"=>$nuevafecha
					);
				}
				
				$nuevafecha = strtotime ( '+10 year' , strtotime ( $fechaIngreso ) ) ;
				$nuevafecha = date ('Y-m-j' , $nuevafecha);
				$cumple = strtotime($nuevafecha);
	
				if($cumple >= $inicioMes && $cumple <= $finMes)
				{
					 $salidaAntiguedad[10][] = array(
						"nombre"=>$trabajador['Trabajadore']['nombre']. ' ' .$trabajador['Trabajadore']['apellido_paterno'],
						"fechaIngreso"=>$trabajador['Trabajadore']['fecha_ingreso'],
						"cumple"=>$nuevafecha				
					);
				}
	
				
				$nuevafecha = strtotime ( '+15 year' , strtotime ( $fechaIngreso ) ) ;
				$nuevafecha = date ('Y-m-j' , $nuevafecha);
				$cumple = strtotime($nuevafecha);
				
				if($cumple >= $inicioMes && $cumple <= $finMes)
				{
					 $salidaAntiguedad[15][] = array(
						"nombre"=>$trabajador['Trabajadore']['nombre']. ' ' .$trabajador['Trabajadore']['apellido_paterno'],
						"fechaIngreso"=>$trabajador['Trabajadore']['fecha_ingreso'],
						"cumple"=>$nuevafecha
					);
				}
	
				$nuevafecha = strtotime ( '+20 year' , strtotime ( $fechaIngreso ) ) ;
				$nuevafecha = date ('Y-m-j' , $nuevafecha);
				$cumple = strtotime($nuevafecha);
				
				if($cumple >= $inicioMes && $cumple <= $finMes)
				{
					 $salidaAntiguedad[20][] = array(
						"nombre"=>$trabajador['Trabajadore']['nombre']. ' ' .$trabajador['Trabajadore']['apellido_paterno'],
						"fechaIngreso"=>$trabajador['Trabajadore']['fecha_ingreso'],
						"cumple"=>$nuevafecha
					);
				}
	
				
				$nuevafecha = strtotime ( '+25 year' , strtotime ( $fechaIngreso ) ) ;
				$nuevafecha = date ('Y-m-j' , $nuevafecha);
				$cumple = strtotime($nuevafecha);
	
				if($cumple >= $inicioMes && $cumple <= $finMes)
				{
					 $salidaAntiguedad[25][] = array(
						"nombre"=>$trabajador['Trabajadore']['nombre']. ' ' .$trabajador['Trabajadore']['apellido_paterno'],
						"fechaIngreso"=>$trabajador['Trabajadore']['fecha_ingreso'],
						"cumple"=>$nuevafecha
					);
				}
	
				$nuevafecha = strtotime ( '+30 year' , strtotime ( $fechaIngreso ) ) ;
				$nuevafecha = date ('Y-m-j' , $nuevafecha);
				$cumple = strtotime($nuevafecha);
				
				if($cumple >= $inicioMes && $cumple <= $finMes)
				{
					 $salidaAntiguedad[30][] = array(
						"nombre"=>$trabajador['Trabajadore']['nombre']. ' ' .$trabajador['Trabajadore']['apellido_paterno'],
						"fechaIngreso"=>$trabajador['Trabajadore']['fecha_ingreso'],
						"cumple"=>$nuevafecha
					);
				}
			}		 
				
			$Email = new CakeEmail("gmail");
			$Email->from(array('sgi@cdf.cl' => 'SGI'));
			$Email->to('rrhh@cdf.cl');
			$Email->subject('Recordatorio Antiguedad Trabajadores');
			$Email->emailFormat('html');
			$Email->template('envio_correo_antiguedad');
	
			$Email->viewVars(array(
				"salida"  =>$salidaAntiguedad,	
			));
	
			$Email->send();
		}else{
			echo "nada que hacer";
		}
		exit;
	}
}
