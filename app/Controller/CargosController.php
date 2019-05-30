<?php
App::uses('AppController', 'Controller');

class CargosController extends AppController {

	public function index() {

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
		CakeLog::write('actividad', 'visito - Cargo - index - '.$this->Cargo->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
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
	}

	public function edit($id = null) {

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
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		$this->set("id", $id);
		/*if ($this->Session->read('Users.flag') == 1) {
			if (!$this->Cargo-> exists($id)) {
				throw new NotFoundException(__('Cargo no existe'));
			}

			if ($this->request->is(array('post', 'put'))) {
				$this->request->data["Cargo"]["nombre"] = mb_strtolower($this->data["Cargo"]["nombre"]);
				$nombre = $this->Cargo->find("first", array("conditions"=>array("Cargo.nombre"=>$this->data["Cargo"]["nombre"])));	
				if(empty($nombre) || $nombre["Cargo"]["id"] == $id)
				{
					if ($this->Cargo->save($this->request->data)) {
						$this->loadModel("ActividadUsuario");
						$usuario = $this->Session->read("PerfilUsuario.idUsuario");
						$mensaje = 'Se modifica cargo "'.$this->request->data["Cargo"]["nombre"].'" con ID '.$this->request->data["Cargo"]["id"];
						$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
						$this->ActividadUsuario->save($log);
						$this->Session->setFlash('El cargo fue editado correctamente', 'msg_exito');
						return $this -> redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash('El cargo no fue editada', 'msg_fallo');
					}
				}else
				{
					$this->Session->setFlash('El cargo no fue agregada, el nombre ya existe', 'msg_fallo');
				}
			} 
			$options = array('conditions' => array('Cargo.' . $this->Cargo->primaryKey=>$id), 'recursive'=>2);
			$this->request->data = $this->Cargo->find('first', $options);
			$this->request->data["Cargo"]["gerencia_id"] = $this->request->data["Area"]["Gerencia"]["id"];
			$this->loadModel("Gerencia");
			$this->loadModel("CargosFamilia");
			$this->loadModel("CargosNivelResponsabilidade");
			$gerencias = $this->Gerencia->find('list', array('conditions'=>array('Gerencia.estado'=>1),'fields' => array('Gerencia.id', 'Gerencia.nombre'), 'order'=>'Gerencia.nombre ASC'));
			$gerencias = array(''=>'')+$gerencias;
			$this -> set('gerencias', $gerencias);
			$this->loadModel("Area");
			$areas = $this ->Area->find('list', array('conditions'=>array('Area.estado'=>1),'fields' => array('Area.id', 'Area.nombre'), 'conditions'=>array('Area.gerencia_id'=>$this->request->data["Cargo"]["gerencia_id"]),'order'=>'Area.nombre ASC'));
			$areas = array(''=>'')+$areas;
			$this -> set('areas', $areas);
			$cargosFamilias = $this->CargosFamilia->find('list', array('conditions'=>array('CargosFamilia.estado'=>1), 'fields'=>array('CargosFamilia.id', 'CargosFamilia.nombre'), 'order'=>'CargosFamilia.nombre'));
			$cargosNivelResponsabilidades = $this->CargosNivelResponsabilidade->find('list', array('conditions'=>array('CargosNivelResponsabilidade.estado'=>1), 'fields'=>array('CargosNivelResponsabilidade.id', 'CargosNivelResponsabilidade.nivel'), 'order'=>'CargosNivelResponsabilidade.nivel'));
			$this->set('cargosFamilias',$cargosFamilias);
			$this->set('cargosNivelResponsabilidades',$cargosNivelResponsabilidades);
		} else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}*/
	}

	public function delete() {
		$this->layout = null;
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

		if ($this->Session->read('Users.flag') == 1) {
			$this->Cargo->id = $this->data["id"];
			if (!$this->Cargo->exists()) {
				throw new NotFoundException(__('Cargo Invalido'));
			}
			$this->request->allowMethod('post', 'delete');
			$data = array('id' => $this->data["id"], 'estado' => 0);
			if ($this->Cargo->save($data)) {
				$this->loadModel("ActividadUsuario");
				$usuario = $this->Session->read("PerfilUsuario.idUsuario");
				$mensaje = "Se elimino cargo ".$this->data["id"];
				$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
				$this->ActividadUsuario->save($log);	
				$this->Session->setFlash('El cargo ha sido eliminado.', 'msg_exito');
			} else {
				$this->Session->setFlash(__('El cargo no ha podido ser eliminado. Por favor, intente nuevamente', 'msg_fallo'));
			}
		} else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function cargos_list(){

		$this->autoRender = false;
		$cargos = $this->Cargo->find("all", array("conditions"=>array("Cargo.estado"=>1),"fields"=>array("Cargo.id", "Cargo.nombre", "Cargo.area_id"), "order"=>"Cargo.nombre"));
		if(!empty($cargos)){
			$respuestaArray = array();
			foreach ($cargos as $cargo) {
				array_push($respuestaArray, array(
					"id"=>$cargo["Cargo"]["id"],
					"nombre"=>$cargo["Cargo"]["nombre"],
					"area_id"=>$cargo["Cargo"]["area_id"]
					)
				);
			}
			$respuesta = array(
				"estado"=>1,
				"data"=>$respuestaArray
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"data"=>"Sin datos"
				);
		}
		return json_encode($respuesta);
	}

	public function cargos(){

		$this->layout = "ajax";
		$this->loadModel("Trabajadore");
		if ($this->Session->read('Users.flag') == 1) {
			$cargos = $this->Cargo->find("all", array(
				"recursive"=>2,
				'order'=>'Cargo.nombre ASC',)
			);
			$trabajadores = $this->Trabajadore->find("all", array(
				"fields"=>array("Trabajadore.id", "Trabajadore.estado","Trabajadore.cargo_id"), 
				"recursive"=>-1
				)
			);
			foreach ($trabajadores as $trabajador) {
				$trabajadorArray[$trabajador["Trabajadore"]["cargo_id"]][] = $trabajador["Trabajadore"]["estado"];
			}
			//pr($trabajadorArray);exit;
			foreach ($trabajadorArray as $cargo_id => $trabajador) {
				$trabajadorCantidad[$cargo_id]["Estado"] = array_count_values($trabajador);
				$trabajadorCantidad[$cargo_id]["Total"] = count($trabajador);

			}
			$cargosArray = array();
			$estados = array("INACTIVO", "ACTIVO");
			foreach ($cargos as $cargo) {
				array_push($cargosArray, array(
					"id"=>$cargo["Cargo"]["id"],
					"cargo"=>$cargo["Cargo"]["nombre"],
					"area"=>$cargo["Area"]["nombre"],
					"gerencia"=>isset($cargo["Area"]["Gerencia"]["nombre"]) ? $cargo["Area"]["Gerencia"]["nombre"] : '',
					"estado"=>($estados[ $cargo["Cargo"]["estado"] ] == 'INACTIVO' ) ? 'Eliminado' : 'Activo',//$estados[$cargo["Cargo"]["estado"]],
					"cantidadTrabajadoresActivos"=>(isset($trabajadorCantidad[$cargo["Cargo"]["id"]]["Estado"]["Activo"]) ? $trabajadorCantidad[$cargo["Cargo"]["id"]]["Estado"]["Activo"] : 0),
					"cantidadTrabajadores"=>(isset($trabajadorCantidad[$cargo["Cargo"]["id"]]["Total"]) ? $trabajadorCantidad[$cargo["Cargo"]["id"]]["Total"] : 0),
					"descripcionCargo"=>$cargo["Cargo"]["descripcion_cargo"]


					));
			}
			$respuesta = array(
				"estado"=>1,
				"data"=>$cargosArray
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdio la sessión, por favor vuelve a ingresar al sistema"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function cargo_trabajadores(){

		$this->layout = "ajax";
		$this->loadModel("Trabajadore");
		if ($this->Session->read('Users.flag') == 1) {
			$trabajadores = $this->Trabajadore->find("all", array(
				"recursive"=>-1,
				'conditions'=>array(
					"Trabajadore.cargo_id"=>$this->request->query["id"],
					),
				"fields"=>array(
					"Trabajadore.id",
					"Trabajadore.nombre",
					"Trabajadore.apellido_paterno",
					"Trabajadore.apellido_materno",
					"Trabajadore.estado"
					)
				)
			);
			$trabajadoresArray = array();
			foreach ($trabajadores as $trabajador) {
				array_push($trabajadoresArray, array(
					"id"=>$trabajador["Trabajadore"]["id"],
					"nombre"=>mb_strtolower($trabajador["Trabajadore"]["nombre"]." ".$trabajador["Trabajadore"]["apellido_paterno"]." ".$trabajador["Trabajadore"]["apellido_materno"]),
					"estado"=>$trabajador["Trabajadore"]["estado"]
					)
				);
			}
			$respuesta = array(
				"estado"=>1,
				"data"=>$trabajadoresArray
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdio la sessión, por favor vuelve a ingresar al sistema"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function cambiar_estado_cargo(){

		$this->layout = "ajax";
		if ($this->Session->read('Users.flag') == 1) {
			if($this->Cargo->save($this->request->data)){
				if($this->request->data["Cargo"]["estado"]==1){
					CakeLog::write('actividad', 'activo - Cargo - cambiar_estado_cargo - '.$this->Cargo->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				}else{
					CakeLog::write('actividad', 'elimino - Cargo - cambiar_estado_cargo - '.$this->Cargo->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				}
				
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Se cambio el estado correctamente"
					);
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se pudo guardar en la base de datos, por favor intentelo nuevamente"
					);
			}
			
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdio la sessión, por favor vuelve a ingresar al sistema"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function cargo(){
		$this->autoRender = false;
		$this->response->type("json");
		$cargo = $this->Cargo->find("first", array(
			"conditions"=>array(
				"Cargo.id"=>$this->request->query["id"]
				),
			"recursive"=>2
			)
		);
		$respuesta = array(
			"estado"=>1,
			"data"=>$cargo
			);
		return json_encode($respuesta);
	}

	public function registrar_cargo_add(){
		
		$this->autoRender = false;
		$this->response->type("json");
		$this->request->allowMethod("post");
		
		App::import("Vendor", "lector", array("file" => "lector-docx" . DS . "index.php"));
		$estado = array("INACTIVO", "ACTIVO");
		$obs = '';

		if ($this->Session->read('Users.flag') == 1) {

			if (gettype($this->request->data['Cargo']) == 'string'){
				$this->request->data['Cargo'] = json_decode($this->request->data['Cargo'], true);
			}				

			$this->request->data["Cargo"]["nombre"] = mb_strtolower($this->request->data["Cargo"]["nombre"]);
						
			$cargo = $this->Cargo->find("first", array(
				"conditions"=>array("Cargo.area_id"=>$this->request->data["Cargo"]["area_id"], 
					"Cargo.nombre"=>$this->request->data["Cargo"]["nombre"])
			));

			if(empty($cargo)){				

				if($this->request->params['form']['file']['error'] == 0 && $this->request->params['form']['file']['size'] > 0){
					$destino = WWW_ROOT.'files'.DS.'descripcion_cargo'.DS.date("Y_m_d_H_i"); 					
					
				 	if (!file_exists($destino))
					{
						mkdir($destino, 0777, true);
						chmod($destino, 0777);
					}
				
					if($this->request->params['form']["file"]['tmp_name'])
					{
						if($this->request->params['form']["file"]['size'] <= 7000000)
						{
							$nombreArchivo = $this->request->params['form']["file"]['name'];
							move_uploaded_file($this->request->params['form']["file"]['tmp_name'], $destino. DS . $nombreArchivo);
							
								//pr($destino.DS.$nombreArchivo);

								if(file_exists($destino . DS .$nombreArchivo)){
									//echo("ENTRO!");
									exec('/usr/bin/unoconv --listener &');									
									exec('/usr/bin/unoconv -f pdf '. $destino . DS . str_replace(' ','\ ',$nombreArchivo));	
								
									$nombre = explode(".",$nombreArchivo);
								}
								
								if (!file_exists($destino . DS . $nombre[0].'.pdf')){
									$obs = "No se pudo guardar archivo pdf";
								}						
							
							$this->request->data['Cargo']['descripcion_cargo'] = date("Y_m_d_H_i").DS.$nombreArchivo;								 					
						}
					}
				}					

				if($this->Cargo->save($this->request->data)){

					$respuesta = array(
						"estado"=>1,
						"respuesta"=>"Se ingreso el cargo correctamente. "
						);
					$this->Session->setFlash('Se ingreso correctamente', 'msg_exito');
					CakeLog::write('actividad', 'ingreso - Cargo - registrar_cargo - '.$this->Cargo->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					
				}else
				{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"No se pudo guardar en la base de datos, por favor intentelo nuevamente"
					);
				}
			}else
			{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Ya existe el cargo en la gerencia y área solicitada con estado ".$estado[$cargo["Cargo"]["estado"]]
				);
			}
				
		}else
		{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdio la sesión, por favor vuelva a ingresar al sistema y luego intente nuevamente"
				);
		}
		
		return json_encode($respuesta);
	}


	public function registrar_cargo_edit(){
		
		$this->autoRender = false;
		$this->response->type("json");
		$this->request->allowMethod("post");
		
			$estado = array("INACTIVO", "ACTIVO");
			$obs = "";
		
				if ($this->Session->read('Users.flag') == 1) {
					
					if (gettype($this->request->data['Cargo']) == 'string')
						$this->request->data['Cargo'] = json_decode($this->request->data['Cargo'], true);
		
					$this->request->data["Cargo"]["nombre"] = mb_strtolower($this->request->data["Cargo"]["nombre"]);

					$cargoEditar = $this->Cargo->find("first", array(
					"conditions"=>array("Cargo.id"=>$this->request->data["Cargo"]["id"],
					"Cargo.nombre"=>$this->request->data['Cargo']['nombre'])
					));				
					
		
					if(!empty($cargoEditar)){
		
						unset($cargoEditar["Area"]);
						unset($this->request->data["Archivo"]);
		
						if (isset($this->request->params['form'])){
							if($this->request->params['form']['file']['error'] == 0 && $this->request->params['form']['file']['size'] > 0){
								$carpetaDate = date("Y_m_d_H_i");
								$destino = WWW_ROOT.'files'.DS.'descripcion_cargo'.DS.$carpetaDate; 
		
							 	if (!file_exists($destino))
								{
									mkdir($destino, 0777, true);
									chmod($destino, 0777);
								}
								
								if($this->request->params['form']["file"]['tmp_name'])
								{
									if($this->request->params['form']["file"]['size'] <= 7000000)
									{
									
										$nombreArchivo = $this->request->params['form']['file']['name'];
										move_uploaded_file($this->request->params['form']['file']['tmp_name'], $destino .DS . $nombreArchivo);
											
										$this->request->data['Cargo']['descripcion_cargo'] = $carpetaDate.DS.$nombreArchivo;
										
										if(file_exists($destino . DS . $nombreArchivo)){
											
											exec('/usr/bin/unoconv --listener &');
											exec('/usr/bin/unoconv -f pdf '. $destino . DS . str_replace(' ','\ ',$nombreArchivo));
											
											$nombre = explode(".",$nombreArchivo);									
										}
									}
									
									if(!file_exists($destino. DS . $nombre[0].'.pdf')){
										$obs = "no se pudo guardar el archivo";
									}
								}
							}
						} else {
							$this->request->data['Cargo']['descripcion_cargo'] = null;
						}				
						
						$cargoEditar = array_replace($cargoEditar, $this->request->data);				
		
						if($this->Cargo->save($cargoEditar)){				
							$respuesta = array(
								"estado"=>1,
								"respuesta"=>"Se actualizó el cargo correctamente"
								);
							$this->Session->setFlash('Se actualizó correctamente', 'msg_exito');
							CakeLog::write('actividad', 'actualizó - Cargo - registrar_cargo_edit - '.$this->Cargo->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						}else{

							$respuesta = array(
								"estado"=>0,
								"mensaje"=>"No se pudo guardar en la base de datos, por favor intentelo nuevamente"
							);
						}
					}else{
						$respuesta = array(
							"estado"=>0,
							"mensaje"=>"Ya existe el cargo en la gerencia y área solicitada con estado ".$estado[$cargo["Cargo"]["estado"]]
						);
					}
						
				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"Perdio la sesión, por favor vuelva a ingresar al sistema y luego intente nuevamente"
						);
				}
				
				return json_encode($respuesta);
			}

}


