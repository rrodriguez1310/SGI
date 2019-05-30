<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
//Configure::write('debug', 2);

/**
* Companies Controller
 *
 * @property Company $Company
 * @property PaginatorComponent $Paginator
 */
class CompaniesController extends AppController {
	
	
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
	
	public function lista_empresas_json()
		{
		$this->layout = "ajax";
		
		$listaEmpresas = $this->Company->find("all", array(
					"fields"=>array("Company.id", "Company.rut", "Company.alias", "Company.razon_social", "Company.company_type_id", "Company.company_type_otros", "Company.observacion"),
					"recursive"=>0
				));
		
		$datosEmpresas = "";
		$arrayTypeOtros = array();
		$companyTypes = $this->Company->CompanyType->find('all', array("CompanyType.id", "CompanyType.nombre_corto","recursive"=>0));
		
		$companyType = array();
		foreach ($companyTypes as $value) {
			$companyType[]=$value["CompanyType"];
		}
		
		foreach($listaEmpresas as $key => $listaEmpresa)
				{
			$arrayTypeOtros = array();
			if(!empty($listaEmpresa["Company"]["company_type_otros"])){
				$arrayTypeOtros = unserialize($listaEmpresa["Company"]["company_type_otros"]);
				if(!empty($listaEmpresa["Company"]["company_type_id"]))
									$arrayTypeOtros[] = $listaEmpresa["Company"]["company_type_id"];
			}
			else {
				$arrayTypeOtros[] = $listaEmpresa["Company"]["company_type_id"];
			}
			
			$tEmpresa=array();
			foreach ($arrayTypeOtros as $key => $arrayTypeOtro) {
				foreach ($companyType as $key => $value) {
					if($arrayTypeOtro==$value["id"]) 
											$tEmpresa[] = $value["nombre_corto"];
				}
			}
			
			$txtTipoCompania = implode(", ",array_unique($tEmpresa));
			
			$datosEmpresas[] = array(
							"Id"=>$listaEmpresa["Company"]["id"],
							"Rut"=>$listaEmpresa["Company"]["rut"],
							"Nombre"=>$listaEmpresa["Company"]["alias"],
							"RazonSocial"=>$listaEmpresa["Company"]["razon_social"],
							"TipoCompania"=>$txtTipoCompania,
							"IdTipoCompania"=>$listaEmpresa["Company"]["company_type_id"],
							"IdTipoCompaniaOtros"=>$listaEmpresa["Company"]["company_type_otros"],
							"Observacion"=>$listaEmpresa["Company"]["observacion"],
						);
		}
		
		$this->response->type('json');
		$this->set("listaEmpresas", $datosEmpresas);
		
	}
	
	public function empresas()
		{
		$this->layout = "angular";
	}
	
	public function index(){
		
		$this->layout = "angular";
		
		if($this->Session->Read("Users.flag") != 0)
				{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
						{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller"=>'users', "action"=>'fallo'));
			}
		}
		else 
				{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller"=>'users', "action"=>'login'));
		}
		
		$this->loadModel("Channel");
		$this->loadModel("Link");
		$this->loadModel("Signal");
		$this->loadModel("Payment");
		$this->loadModel("CompaniesAttribute");
		
		$companies = $this->CompaniesAttribute->Company->find('list', array('fields'=>array('Company.id', 'Company.nombre')));
		$channels = $this->Channel->find('list', array('fields'=>array('Channel.id', 'Channel.nombre')));
		$links = $this->Link->find('list', array('fields'=>array('Link.id', 'Link.nombre')));
		$signals = $this->Signal->find('list', array('fields'=>array('Signal.id', 'Signal.nombre')));
		$payments = $this->Payment->find('list', array('fields'=>array('Payment.id', 'Payment.nombre')));
		
		$operadorTv = $this->Company->find('all', array(
					'conditions'=>array("Company.company_type_id"=>1),
					'recursive'=>0
				));
		
		$idEmpresasArray = array();
		foreach($operadorTv as  $key=>$valor)
				{
			$idEmpresasArray[] = $valor["Company"]["id"];
		}
		
		$idEmpresasAtributos = $this->CompaniesAttribute->find("all", array(
							'conditions'=>array('CompaniesAttribute.company_id'=>$idEmpresasArray),
							'fields'=>array("CompaniesAttribute.company_id"),
							'recursive'=>0	));
		
		$idAtributos = array();
		foreach($idEmpresasAtributos as $idEmpresasAtributo)
				{
			$idAtributos[$idEmpresasAtributo["CompaniesAttribute"]["company_id"]] = $idEmpresasAtributo["CompaniesAttribute"]["company_id"];
		}
		
		$this->set(compact('channels', 'links', 'signals', 'payments'));
		$this->set("idAtributos", $idAtributos);
		
	}
	
	
	
	/**
	* view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
		public function view($id = null) {
		
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
			$this->Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		if($this->Session->read('Users.flag') == 1)
				{
			CakeLog::write('actividad', 'miró empresa id ' .$id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			
			if (!$this->Company->exists($id)) {
				throw new NotFoundException(__('Ingrese una compañía válida'));
			}
			
			$options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
			$this->request->data = $this->Company->find('first', $options);
			
			//t			ipo empresa	
						if(!empty($this->request->data["Company"]["company_type_id"])&&!empty($this->request->data["Company"]["company_type_otros"])){
				$arrayTypeOtros = unserialize($this->request->data["Company"]["company_type_otros"]);
				array_push($arrayTypeOtros, $this->request->data["Company"]["company_type_id"]);
				$this->request->data["Company"]["company_type_id"] = $arrayTypeOtros;
			}
			else if(!empty($this->request->data["Company"]["company_type_otros"])){
				$this->request->data["Company"]["company_type_id"] = unserialize($this->request->data["Company"]["company_type_otros"]);
			}
			
			$companyTypes = $this->Company->CompanyType->find('list', array(
							'conditions'=>array("CompanyType.id"=>$this->request->data["Company"]["company_type_id"]),
							"fields"=>array("CompanyType.id", "CompanyType.nombre")));
			
			$tipoCompania = implode(", ",$companyTypes);
			//f			in tipo empresa	
			
			$this->loadModel("Comuna");
			$comuna = $this->Comuna->find('first', array(
							'conditions'=>array("Comuna.id"=>$this->request->data['Company']["comuna"]),
							'fields'=>array("Comuna.comuna_nombre")
						));
			$this->loadModel("Paise");
			$pais = $this->Paise->find('first', array(
							'conditions'=>array("Paise.id"=>$this->request->data['Company']["paise_id"]),
							'fields'=>array("Paise.nombre")
						));
			
			$this->set('tipoCompania', $tipoCompania);
			$this->set('comuna', $comuna);
			$this->set('pais', $pais);
			$this->set('company', $this->request->data);
			
		}
		else
				{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller"=>'users', "action"=>'login'));
		}
	}
	
	
	/**
	* add method
	 *
	 * @return void
	 */
		public function add($estado = null) {
		
		if(!empty($estado))
				{
			$this->set("escondeEstado", $estado);
		}
		else
				{
			$this->set("escondeEstado", 0);
		}
		
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
		
		if($this->Session->read('Users.flag') == 1)
				{
			if ($this->request->is('post')) {
				if($this->request->data["Company"]["paise_id"] == 46)
								{
					$existe = $this->Company->find("first", array(
											"conditions"=>array("Company.rut"=>$this->request->data["Company"]["rut"])
										));
					
					if(!empty($existe))
										{
						$this->Session->setFlash('El rut ingresado ya existe. Por favor, intente con otro.', 'msg_fallo');
						$this->redirect(array("action"=>'add'));
					}
				}
				//-				-
								if(!empty($this->request->data["Company"]["company_type_id"])){
					
					if(in_array("1", $this->request->data["Company"]["company_type_id"])){
						// 						Operador de tv paga
						
						if(count($this->request->data["Company"]["company_type_id"])>1){
							
							$posicionOperador =  array_search("1", $this->request->data["Company"]["company_type_id"]);
							unset($this->request->data["Company"]["company_type_id"][$posicionOperador]);
							$this->request->data["Company"]["company_type_otros"] = serialize($this->request->data["Company"]["company_type_id"]);
						}
						else{
							
							$this->request->data["Company"]["company_type_otros"] = '';
						}
						
						$this->request->data["Company"]["company_type_id"] = "1";
						
					}
					else{
						$this->request->data["Company"]["company_type_otros"] = serialize($this->request->data["Company"]["company_type_id"]);
						$this->request->data["Company"]["company_type_id"] = "";
					}
					
				}
				else{
					$this->request->data["Company"]["company_type_otros"] = '';
				}
				
				$nombresarchivo = '';

				if($this->request->data['Company']['archivo']['error'] == 0 && $this->request->data['Company']['archivo']['size'] > 0){

		        	$destino = WWW_ROOT.'files'.DS.'empresas'.DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
		             	
		             	if (!file_exists($destino)){
							mkdir($destino, 0777, true);
							chmod($destino, 0777);
						}
						
						if(is_uploaded_file($this->request->data['Company']['archivo']['tmp_name'])){
							if($this->request->data['Company']['archivo']['size'] <= 7000000){
								
								move_uploaded_file($this->request->data['Company']['archivo']['tmp_name'], $destino . DS .$this->request->data['Company']['archivo']['name']);
								$nombresarchivo = $this->Session->read('PerfilUsuario.idUsuario').DS.$this->request->data['Company']['archivo']['name'];
							}
							else{
								pr("no guardo");
								$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
								//return $this->redirect(array("controller" => 'compras', "action" => 'index'));
								//$estado = 2;
								exit;
							}
						}
						else{
                            pr("no guardo");
                            $this->Session->setFlash('NO GUARDO!! Ocurrio un problema', 'msg_fallo');
                            //return $this->redirect(array("controller" => 'compras', "action" => 'index'));
                            //$estado = 2;
                            exit;	
                        }
					}

					
					if(!empty($nombresarchivo))
					{
						$this->request->data["Company"]["documento"] = $nombresarchivo;
					}
				
				$this->Company->create();
				
				if ($this->Company->save($this->request->data)) {
					
					$this->loadModel("ActividadUsuario");
					$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
					$mensaje = 'Se crea compañia para "'.$this->request->data["Company"]["razon_social"].'" con ID '.$this ->Company ->id;
					
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					
					$this->ActividadUsuario-> save($log);
					
					CakeLog::write('actividad', 'agregó empresa id ' .$this->ActividadUsuario->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					
					
					$this->Session->setFlash('La empresa se registro correctamente', 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				}
				else {
					$this->Session->setFlash('No se pudo registrar la empresa correctamente', 'msg_fallo');
				}
			}
			
			$companyTypes = $this->Company->CompanyType->find('list', array("fields"=>array("CompanyType.id", "CompanyType.nombre")));
			$this->set(compact('companyTypes'));
			
		}
		else
				{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller"=>'users', "action"=>'login'));
		}
	}
	
	
	/**
	* edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
		public function edit($id = null) {
		
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
		//p		r($this->Company);
		if($this->Session->read('Users.flag') == 1)
				{
			if (!$this->Company->exists($id)) {
				throw new NotFoundException(__('Compañia no existe'));
			}
			if ($this->request->is(array('post', 'put'))) {
				
				//-				-
								if(!empty($this->request->data["Company"]["company_type_id"])){
					
					if(in_array("1", $this->request->data["Company"]["company_type_id"])){
						// 						Operador de tv paga
						
						if(count($this->request->data["Company"]["company_type_id"])>1){
							
							$posicionOperador =  array_search("1", $this->request->data["Company"]["company_type_id"]);
							unset($this->request->data["Company"]["company_type_id"][$posicionOperador]);
							$this->request->data["Company"]["company_type_otros"] = serialize($this->request->data["Company"]["company_type_id"]);
						}
						else{
							
							$this->request->data["Company"]["company_type_otros"] = '';
						}
						
						$this->request->data["Company"]["company_type_id"] = "1";
						
					}
					else{
						$this->request->data["Company"]["company_type_otros"] = serialize($this->request->data["Company"]["company_type_id"]);
						$this->request->data["Company"]["company_type_id"] = "";
					}
					
				}
				else{
					$this->request->data["Company"]["company_type_otros"] = '';
				}
				
				if($this->request->data['Company']['archivo']['error'] == 0 && $this->request->data['Company']['archivo']['size'] > 0){

					pr("paso");
					
		        	$destino = WWW_ROOT.'files'.DS.'empresas'.DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
		             	
		             	if (!file_exists($destino)){
							mkdir($destino, 0777, true);
							chmod($destino, 0777);
						}
						
						if(is_uploaded_file($this->request->data['Company']['archivo']['tmp_name'])){
							if($this->request->data['Company']['archivo']['size'] <= 7000000){
								
								move_uploaded_file($this->request->data['Company']['archivo']['tmp_name'], $destino . DS .$this->request->data['Company']['archivo']['name']);
								$nombresarchivo = $this->Session->read('PerfilUsuario.idUsuario').DS.$this->request->data['Company']['archivo']['name'];
							}else{
								pr("no guardo");
								$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
								//return $this->redirect(array("controller" => 'compras', "action" => 'index'));
								//$estado = 2;
								exit;
							}
						}else{
							pr("no guardo");
							$this->Session->setFlash('NO GUARDO!! Ocurrio un problema', 'msg_fallo');
							//return $this->redirect(array("controller" => 'compras', "action" => 'index'));
							//$estado = 2;
							exit;	
						}
						
					}

					
					if(!empty($nombresarchivo))
					{
						$this->request->data["Company"]["documento"] = $nombresarchivo;  //date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->data['adjunto']['name'];
					}
				
				if ($this->Company->save($this->request->data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
					$mensaje = 'Se modifica compañia "'.$this -> request -> data["Company"]["razon_social"].'" con ID '.$this -> request -> data["Company"]["id"];
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this -> ActividadUsuario -> save($log);
					
					CakeLog::write('actividad', 'editó empresa ID - ' . $this -> request -> data["Company"]["id"] . ' usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash('La empresa fue editada correctamente', 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				}
				else {
					$this->Session->setFlash('La empresa no fue editada', 'msg_fallo');
				}
			}
			else {
				
				$options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
				$this->request->data = $this->Company->find('first', $options);
				
								if(!empty($this->request->data["Company"]["company_type_id"])&&!empty($this->request->data["Company"]["company_type_otros"])){
					
					$arrayTypeOtros = unserialize($this->request->data["Company"]["company_type_otros"]);
					array_push($arrayTypeOtros, $this->request->data["Company"]["company_type_id"]);
					$this->request->data["Company"]["company_type_id"] = $arrayTypeOtros;
					
				}
				else if(!empty($this->request->data["Company"]["company_type_otros"])){
					$this->request->data["Company"]["company_type_id"] = unserialize($this->request->data["Company"]["company_type_otros"]);
				}
				
			}
			
			$companyTypes = $this->Company->CompanyType->find('list', array("fields"=>array("CompanyType.id", "CompanyType.nombre")));
			$this->set(compact('companyTypes'));
			
			$paise = $this->Company->Paise->find('list', array("fields"=>array("Paise.id", "Paise.nombre")));
			$this->set(compact('paises'));
		}
		else
				{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller"=>'users', "action"=>'login'));
		}
		
	}
	
	
	/**
	* edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
		public function full_edit($id = null) {
		
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
		if($this->Session->read('Users.flag') == 1)
				{
			if (!$this->Company->exists($id)) {
				throw new NotFoundException(__('Compañia no existe'));
			}
			if ($this->request->is(array('post', 'put'))) {
				
				if(!empty($this->request->data["Company"]["company_type_id"])){
					
					if(in_array("1", $this->request->data["Company"]["company_type_id"])){
						// 						Operador de tv paga
						
						if(count($this->request->data["Company"]["company_type_id"])>1){
							
							$posicionOperador =  array_search("1", $this->request->data["Company"]["company_type_id"]);
							unset($this->request->data["Company"]["company_type_id"][$posicionOperador]);
							$this->request->data["Company"]["company_type_otros"] = serialize($this->request->data["Company"]["company_type_id"]);
						}
						else{
							
							$this->request->data["Company"]["company_type_otros"] = '';
						}
						
						$this->request->data["Company"]["company_type_id"] = "1";
						
					}
					else{
						$this->request->data["Company"]["company_type_otros"] = serialize($this->request->data["Company"]["company_type_id"]);
						$this->request->data["Company"]["company_type_id"] = "";
					}
					
				}
				else{
					$this->request->data["Company"]["company_type_otros"] = '';
				}
				
				if ($this->Company->save($this->request->data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this -> Session -> read("PerfilUsuario.idUsuario");
					$mensaje = 'Se modifica compañia "'.$this -> request -> data["Company"]["razon_social"].'" con ID '.$this -> request -> data["Company"]["id"];
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
					$this -> ActividadUsuario -> save($log);
					CakeLog::write('actividad', 'editó completa empresa ID - ' . $this -> request -> data["Company"]["id"] . ' usuario '. $this->Session->Read("PerfilUsuario.idUsuario"));
					
					$this->Session->setFlash('La empresa fue editada correctamente', 'msg_exito');
					return $this->redirect(array('action' => 'index'));
				}
				else {
					$this->Session->setFlash('La empresa no fue editada', 'msg_fallo');
				}
			}
			else {
				
				$options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
				$this->request->data = $this->Company->find('first', $options);
				//-				-
								if(!empty($this->request->data["Company"]["company_type_id"])&&!empty($this->request->data["Company"]["company_type_otros"])){
					
					$arrayTypeOtros = unserialize($this->request->data["Company"]["company_type_otros"]);
					array_push($arrayTypeOtros, $this->request->data["Company"]["company_type_id"]);
					$this->request->data["Company"]["company_type_id"] = $arrayTypeOtros;
					
				}
				else if(!empty($this->request->data["Company"]["company_type_otros"])){
					$this->request->data["Company"]["company_type_id"] = unserialize($this->request->data["Company"]["company_type_otros"]);
				}
				//-				-
			}
			
			$companyTypes = $this->Company->CompanyType->find('list', array("fields"=>array("CompanyType.id", "CompanyType.nombre")));
			$this->set(compact('companyTypes'));
		}
		else
				{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller"=>'users', "action"=>'login'));
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
		
		if($this->Session->read('Users.flag') == 1)
				{
			$this->Company->id = $id;
			if (!$this->Company->exists()) {
				throw new NotFoundException(__('Invalid company'));
			}
			$this->request->allowMethod('post', 'delete');
			if ($this->Company->delete()) {
				
				CakeLog::write('actividad', 'elimino empresa ID ' . $id . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				
				$this->Session->setFlash(__('The company has been deleted.'));
			}
			else {
				$this->Session->setFlash(__('The company could not be deleted. Please, try again.'));
			}
			return $this->redirect(array('action' => 'index'));
		}
		else
				{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller"=>'users', "action"=>'login'));
		}
	}
	
	public function detalleServiciosContratados()
		{
		
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
		
		$this->layout = "ajax";
		
		$this->loadModel("CompaniesAttribute");
		$serviciosContratados = $this->CompaniesAttribute->find("all", array(
					'conditions'=>array('CompaniesAttribute.company_id'=>$this->params->query["id"]),
				));
		
		$itemsData = array();
		if(!empty($serviciosContratados))
				{
			//$			canales = array();
			
			foreach($serviciosContratados as  $serviciosContratado)
						{
				$canales[] =  unserialize($serviciosContratado["CompaniesAttribute"]["channel_id"]);
				$enlaces[] =  unserialize($serviciosContratado["CompaniesAttribute"]["link_id"]);
				$segnal[] =  unserialize($serviciosContratado["CompaniesAttribute"]["signal_id"]);
				$pagos[] = unserialize($serviciosContratado["CompaniesAttribute"]["payment_id"]);
			}
			
			$datosFinales = array($canales);
			
			$this->loadModel("Channel");
			$this->loadModel("Link");
			$this->loadModel("Signal");
			$this->loadModel("Payment");
			
			$muestraCanales = $this->Channel->find("all");
			$muestraEnlaces = $this->Link->find("all");
			$muestraSignal = $this->Signal->find("all");
			$muestraPagos = $this->Payment->find("all");
			
			$canalesArray = array();
			$enlacesArray = array();
			$signalArray = array();
			$pagosArray = array();
			
			$atributosEmpresas = array();
			//i			nicio
						foreach($muestraCanales as $muestraCanale)
						{
				$canalesArray[$muestraCanale["Channel"]["id"]] = $muestraCanale["Channel"]["nombre"];
			}
			
			$this->set('canalesArray', $canalesArray);
			
			foreach($muestraEnlaces as $muestraEnlace)
						{
				$enlacesArray[$muestraEnlace["Link"]["id"]] = $muestraEnlace["Link"]["nombre"];
			}
			
			$this->set("enlacesArray", $enlacesArray);
			
			foreach($muestraSignal as $muestraSigna)
						{
				$signalArray[$muestraSigna["Signal"]["id"]] = $muestraSigna["Signal"]["nombre"];
			}
			$this->set("signalArray", $signalArray);
			
			foreach($muestraPagos as $muestraPago)
						{
				$pagosArray[$muestraPago["Payment"]["id"]] = $muestraPago["Payment"]["nombre"];
			}
			
			$this->set("pagosArray", $pagosArray);
			
			foreach($canales as $key => $valor)
						{
				foreach($valor as $valo)
								{
					$atributosEmpresas[$canalesArray[$valo]][] = array("Canales"=>$valor, "Enlaces"=>$enlaces[$key], "Segnal"=>$segnal[$key], "Pagos"=>$pagos[$key]);
				}
			}
			
			$this->set("atributosEmpresas", $atributosEmpresas);
		}
	}
	
	public function contratos_add($id = null)
	{
		Configure::write('debug', 1); 
		
		$this->layout = "angular";
		$this->Company->id = $id;
		//pr($id);
		if (!$this->Company->exists()) {
			$this->Session->setFlash('La empresa seleccionada no existe', 'msg_fallo');
			return $this->redirect(array("action" => 'index'));
		}
		if(!empty($id))
		{
			$this->loadModel("CompaniesAvisoTermino");
			$this->loadModel("Gerencia");
			$this->loadModel("Trabajadore");
			$this->loadModel("CompanyType");
			$this->set("tipoContratos", $this->CompanyType->find("list", array("fields"=>array("CompanyType.id", "CompanyType.nombre_corto"), "recursive"=>-1)));
			$this->set("nombre", $this->Company->find("first", array("conditions"=>array("Company.id"=>$id), "fields"=>"Company.nombre", "recursive"=>-1)));
			$this->set("avisoTermino",  $this->CompaniesAvisoTermino->find("list", array("fields"=>array("CompaniesAvisoTermino.id", "CompaniesAvisoTermino.nombre"))));
			$this->set("gerencia",  $this->Gerencia->find("list", array("conditions"=>array("Gerencia.estado"=>1), "fields"=>array("Gerencia.id", "Gerencia.nombre"))));
			$this->set("emailTrabajador",  $this->Trabajadore->find("list", array("fields"=>array("Trabajadore.email", "Trabajadore.email"), "recursive"=>-1)));
			$this->set("id", $id);
		}
		
		if ($this->request->data)
				{
			$this->loadModel("CompaniesContrato");
			//p			r($this->data);
			//exit;
			if($this->request->data["CompaniesContrato"]["adjunto"]['error'] == 0 && $this->request->data["CompaniesContrato"]["adjunto"]['size'] > 0)
						{
				$destino = WWW_ROOT.'files'.DS.'contrato_empresas'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');
				
				if (!file_exists($destino))
								{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}
				
				if(is_uploaded_file($this->request->data["CompaniesContrato"]["adjunto"]['tmp_name']))
								{
					if($this->request->data["CompaniesContrato"]["adjunto"]['size'] <= 7000000)
										{
						move_uploaded_file($this->data["CompaniesContrato"]["adjunto"]["tmp_name"], $destino . DS .$this->request->data["CompaniesContrato"]["adjunto"]['name']);
						$this->request->data["CompaniesContrato"]["adjunto"] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->request->data["CompaniesContrato"]["adjunto"]['name'];
						$this->request->data["CompaniesContrato"]["notificacion_email"] = $this->request->data["CompaniesContrato"]["notificacion_email"];
						
						if(empty($this->request->data["CompaniesContrato"]["estado"]))
												{
							$this->request->data["CompaniesContrato"]["estado"] = 1;
						}
						
						if($this->CompaniesContrato->save($this->request->data))
												{
							$gerenciaNombre = $this->Gerencia->find("first", array(
															"conditions"=>array("Gerencia.id"=>$this->request->data["CompaniesContrato"]["gerencia_id"], "Gerencia.estado"=>1), 
															"fields"=>array("Gerencia.nombre"),
															"recursive"=>0
														));
							
							$empresaNombre = $this->Company->find("first", array(
															"conditions"=>array("Company.id"=>$id), 
															"fields"=>array("Company.nombre"),
															"recursive"=>0
														));
							
							$Email = new CakeEmail("gmail");
							$Email->from(array('sgi@cdf.cl' => 'SGI'));
							$Email->to('garistegui@cdf.cl');
							$Email->subject("Se registro un nuevo contrato empresa");
							$Email->emailFormat('html');
							$Email->template('aviso_upload_contrato');
							$Email->viewVars(array(
															"fechaInicio"=>$this->request->data["CompaniesContrato"]["fecha_inicio"],
															"fechaTermino"=>$this->request->data["CompaniesContrato"]["fecha_termino"],
															"fechaVencimiento"=>$this->request->data["CompaniesContrato"]["fecha_vencimiento"],
															"gerencia"=>$gerenciaNombre["Gerencia"]["nombre"],
															"observacion"=>$this->request->data["CompaniesContrato"]["observacion"],
															"empresa"=>$empresaNombre["Company"]["nombre"],
														));
							$Email->send();
							
							CakeLog::write('actividad', 'Ingreso el contrato a la empresa' .$this->request->data["CompaniesContrato"]["company_id"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") . ' - id de contrato -' .$this->CompaniesContrato->id);
							$this->Session->setFlash('Registrado correctamente', 'msg_exito');
							return $this->redirect(array("action" => 'contratos_add', $id));
						}
						
					}
					else
										{
						$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
						return $this->redirect(array("action" => 'index'));
						$estado = 2;
						exit;
					}
				}
				else
								{
					$this->Session->setFlash('NO GUARDO!! Ocurrio un problema', 'msg_fallo');
					return $this->redirect(array("action" => 'index'));
					$estado = 2;
					exit;
				}
			}
			else
						{
				if(empty($this->request->data["CompaniesContrato"]["estado"]))
								{
					$this->request->data["CompaniesContrato"]["estado"] = 1;
				}
				
				unset($this->request->data["CompaniesContrato"]["adjunto"]);
				if($this->CompaniesContrato->save($this->request->data))
								{
					CakeLog::write('actividad', 'Ingreso el contrato a la empresa' .$this->request->data["CompaniesContrato"]["company_id"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash('Registrado correctamente', 'msg_exito');
				}
			}
		}
	}
	
	public function contratos_custom_add($id = null)
	{
		//Configure::write('debug', 1); 
		
		$this->layout = "angular";
		$this->Company->id = $id;
		//pr($id);
		if (!$this->Company->exists()) {
			$this->Session->setFlash('La empresa seleccionada no existe', 'msg_fallo');
			return $this->redirect(array("action" => 'index'));
		}
		if(!empty($id))
		{
			$this->loadModel("CompaniesAvisoTermino");
			$this->loadModel("Gerencia");
			$this->loadModel("Trabajadore");
			$this->loadModel("CompanyType");
			$this->set("tipoContratos", $this->CompanyType->find("list", array("fields"=>array("CompanyType.id", "CompanyType.nombre_corto"), "recursive"=>-1)));
			$this->set("nombre", $this->Company->find("first", array("conditions"=>array("Company.id"=>$id), "fields"=>"Company.nombre", "recursive"=>-1)));
			$this->set("avisoTermino",  $this->CompaniesAvisoTermino->find("list", array("fields"=>array("CompaniesAvisoTermino.id", "CompaniesAvisoTermino.nombre"))));
			$this->set("gerencia",  $this->Gerencia->find("list", array("conditions"=>array("Gerencia.estado"=>1), "fields"=>array("Gerencia.id", "Gerencia.nombre"))));
			$this->set("emailTrabajador",  $this->Trabajadore->find("list", array("fields"=>array("Trabajadore.email", "Trabajadore.email"), "recursive"=>-1)));
			$this->set("id", $id);
		}
		
		if ($this->request->data)
				{
			$this->loadModel("CompaniesContrato");
			//p			r($this->data);
			//exit;
			if($this->request->data["CompaniesContrato"]["adjunto"]['error'] == 0 && $this->request->data["CompaniesContrato"]["adjunto"]['size'] > 0)
						{
				$destino = WWW_ROOT.'files'.DS.'contrato_empresas'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');
				
				if (!file_exists($destino))
								{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}
				
				if(is_uploaded_file($this->request->data["CompaniesContrato"]["adjunto"]['tmp_name']))
								{
					if($this->request->data["CompaniesContrato"]["adjunto"]['size'] <= 7000000)
										{
						move_uploaded_file($this->data["CompaniesContrato"]["adjunto"]["tmp_name"], $destino . DS .$this->request->data["CompaniesContrato"]["adjunto"]['name']);
						$this->request->data["CompaniesContrato"]["adjunto"] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->request->data["CompaniesContrato"]["adjunto"]['name'];
						$this->request->data["CompaniesContrato"]["notificacion_email"] = $this->request->data["CompaniesContrato"]["notificacion_email"];
						
						if(empty($this->request->data["CompaniesContrato"]["estado"]))
												{
							$this->request->data["CompaniesContrato"]["estado"] = 1;
						}
						
						if($this->CompaniesContrato->save($this->request->data))
												{
							$gerenciaNombre = $this->Gerencia->find("first", array(
															"conditions"=>array("Gerencia.id"=>$this->request->data["CompaniesContrato"]["gerencia_id"], "Gerencia.estado"=>1), 
															"fields"=>array("Gerencia.nombre"),
															"recursive"=>0
														));
							
							$empresaNombre = $this->Company->find("first", array(
															"conditions"=>array("Company.id"=>$id), 
															"fields"=>array("Company.nombre"),
															"recursive"=>0
														));
							
							$Email = new CakeEmail("gmail");
							$Email->from(array('sgi@cdf.cl' => 'SGI'));
							$Email->to('garistegui@cdf.cl');
							$Email->subject("Se registro un nuevo contrato empresa");
							$Email->emailFormat('html');
							$Email->template('aviso_upload_contrato');
							$Email->viewVars(array(
								"fechaInicio"=>$this->request->data["CompaniesContrato"]["fecha_inicio"],
								"fechaTermino"=>$this->request->data["CompaniesContrato"]["fecha_termino"],
								"fechaVencimiento"=>$this->request->data["CompaniesContrato"]["fecha_vencimiento"],
								"gerencia"=>$gerenciaNombre["Gerencia"]["nombre"],
								"observacion"=>$this->request->data["CompaniesContrato"]["observacion"],
								"empresa"=>$empresaNombre["Company"]["nombre"],
							));
							$Email->send();
							
							CakeLog::write('actividad', 'Ingreso el contrato a la empresa' .$this->request->data["CompaniesContrato"]["company_id"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") . ' - id de contrato -' .$this->CompaniesContrato->id);
							$this->Session->setFlash('Registrado correctamente', 'msg_exito');
							return $this->redirect(array("action" => 'contratos_add', $id));
						}
						
					}
					else
										{
						$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
						return $this->redirect(array("action" => 'index'));
						$estado = 2;
						exit;
					}
				}
				else
								{
					$this->Session->setFlash('NO GUARDO!! Ocurrio un problema', 'msg_fallo');
					return $this->redirect(array("action" => 'index'));
					$estado = 2;
					exit;
				}
			}
			else
						{
				if(empty($this->request->data["CompaniesContrato"]["estado"]))
								{
					$this->request->data["CompaniesContrato"]["estado"] = 1;
				}
				
				unset($this->request->data["CompaniesContrato"]["adjunto"]);
				if($this->CompaniesContrato->save($this->request->data))
								{
					CakeLog::write('actividad', 'Ingreso el contrato a la empresa' .$this->request->data["CompaniesContrato"]["company_id"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash('Registrado correctamente', 'msg_exito');
				}
			}
		}
		}
	
	
	public function lista_contratos_empresas()
		{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("CompaniesContrato");
		
		$listaContratos = $this->CompaniesContrato->find("all", array(
					"conditions"=>array("CompaniesContrato.company_id"=>$this->params->query["idEmpresa"], "CompaniesContrato.estado"=>1)
				));
		
		
		$listaContratosJson = "";
		
		foreach($listaContratos as $listaContrato)
				{
			$adjunto = explode("/", $listaContrato["CompaniesContrato"]["adjunto"]);
			//e			cho "<pre>";
			//p			rint_r($listaContrato["CompaniesRenovacionAutomatica"]["id"]);
			$listaContratosJson[] =  array(
							"Id"=>$listaContrato["CompaniesContrato"]["id"],
							"IdTipoContrato"=>$listaContrato["CompaniesContrato"]["company_type_id"],
							"nombreTipoContrato"=>$listaContrato["CompanyType"]["nombre_corto"],
							"FechaInicio"=>$listaContrato["CompaniesContrato"]["fecha_inicio"],
							"FechaTermino"=>$listaContrato["CompaniesContrato"]["fecha_termino"],
							"FechaVencimiento"=>$listaContrato["CompaniesContrato"]["fecha_vencimiento"],
							"Gerencia"=>$listaContrato["Gerencia"]["nombre"],
							"GerenciaId"=>$listaContrato["Gerencia"]["id"],
							"Adjunto"=>$listaContrato["CompaniesContrato"]["adjunto"],
							"Observacion"=>$listaContrato["CompaniesContrato"]["observacion"],
							"Renovacion"=>$listaContrato["CompaniesRenovacionAutomatica"]["nombre"],
							"NotificacionEmail"=>$listaContrato["CompaniesContrato"]["notificacion_email"],
							"CompaniesAvisoTermino"=>$listaContrato["CompaniesAvisoTermino"]["nombre"],
							"CompaniesAvisoTerminoId"=>$listaContrato["CompaniesAvisoTermino"]["id"],
							"Empresa"=>$listaContrato["Company"]["nombre"],
							"EmpresaId"=>$listaContrato["Company"]["id"],
							//"			Estado"=>$listaContrato["CompaniesContrato"]["estado"],
				"Estado"=>$listaContrato["CompaniesContrato"]["terminado"],
				"FechaDocumento"=>$listaContrato["CompaniesContrato"]["fecha_documento"],
				"RenovacionId"=>$listaContrato["CompaniesRenovacionAutomatica"]["id"],
				"Adjunto"=>(isset($adjunto[2]) ? $adjunto[2] : ""),
			);
		}
		//pr($listaContratosJson);exit;
		$this->set("listaContratosJson", $listaContratosJson);
	}
	public function lista_contratos_empresas_id()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("CompaniesContrato");
		$listaContratos = $this->CompaniesContrato->find("all", array(
			"conditions"=>array("CompaniesContrato.id"=>$this->params->query["idEmpresaContrato"], "CompaniesContrato.estado"=>1)
		));
		$listaContratosJson = "";
		foreach($listaContratos as $listaContrato)
		{
			$listaContratosJson[] =  array(
				"Id"=>$listaContrato["CompaniesContrato"]["id"],
				"IdTipoContrato"=>$listaContrato["CompaniesContrato"]["company_type_id"],
				"nombreTipoContrato"=>$listaContrato["CompanyType"]["nombre_corto"],
				"FechaInicio"=>$listaContrato["CompaniesContrato"]["fecha_inicio"],
				"FechaTermino"=>$listaContrato["CompaniesContrato"]["fecha_termino"],
				"FechaVencimiento"=>$listaContrato["CompaniesContrato"]["fecha_vencimiento"],
				"Gerencia"=>$listaContrato["Gerencia"]["nombre"],
				"GerenciaId"=>$listaContrato["Gerencia"]["id"],
				"Adjunto"=>$listaContrato["CompaniesContrato"]["adjunto"],
				"Observacion"=>$listaContrato["CompaniesContrato"]["observacion"],
				"Renovacion"=>$listaContrato["CompaniesRenovacionAutomatica"]["nombre"],
				"RenovacionId"=>$listaContrato["CompaniesRenovacionAutomatica"]["id"],
				"NotificacionEmail"=>$listaContrato["CompaniesContrato"]["notificacion_email"],
				"CompaniesAvisoTermino"=>$listaContrato["CompaniesAvisoTermino"]["nombre"],
				"CompaniesAvisoTerminoId"=>$listaContrato["CompaniesAvisoTermino"]["id"],
				"Empresa"=>$listaContrato["Company"]["nombre"],
				"EmpresaId"=>$listaContrato["Company"]["id"],
				//"Estado"=>$listaContrato["CompaniesContrato"]["estado"],
				"Estado"=>$listaContrato["CompaniesContrato"]["terminado"],
				"FechaDocumento"=>$listaContrato["CompaniesContrato"]["fecha_documento"],
			);
		}
		$this->set("listaContratosJson", $listaContratosJson);
	}
	public function delete_contratos($id, $idEmpresa) 
	{
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
		if($this->Session->read('Users.flag') == 1)
		{	$this->loadModel("CompaniesContrato");
			$this->CompaniesContrato->id = $id;
			if (!$this->CompaniesContrato->exists()) {
				$this->Session->setFlash(__('El registro seleccionado no existe.'), 'msg_exito');
				return $this->redirect(array("action"=>'contratos_add'));
			}
			$this->request->allowMethod('get');
			$this->request->data["CompaniesContrato"]["id"] = $id;
			$this->request->data["CompaniesContrato"]["estado"] = 0;
			if($this->CompaniesContrato->save($this->request->data))
			{
				CakeLog::write('actividad', 'elimino contrato ID ' . $id . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario")); 
				$this->Session->setFlash('Se elimino correctamente', 'msg_exito');
				return $this->redirect(array("action"=>'contratos_add', $idEmpresa));
			}
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller"=>'users', "action"=>'login'));
		}
	}
	public function renovacion_contrato_automatica()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("CompaniesContrato");
		$this->loadModel("Trabajadore");
		$this->loadModel("Cargo");
		$renovaciones = $this->CompaniesContrato->find("all", array(
			"conditions"=>array(
				"CompaniesContrato.estado"=>1,
				"CompaniesContrato.terminado"=>1
			)
		));
		$cargos = $this->Cargo->find("all", array(
			"conditions"=>array("Cargo.nombre LIKE"=>'%gerente%'),
			"fields"=>array("Cargo.id", "Area.gerencia_id"),
			"recursive"=>1
		));
		$cargosId = "";
		$gerenciaCargo = "";
		foreach($cargos as $cargo)
		{
			$cargosId[] = $cargo["Cargo"]["id"];
			$gerenciaCargo[$cargo["Cargo"]["id"]] = $cargo["Area"]["gerencia_id"];
		}
		$gerenteEmail = $this->Trabajadore->find("all", array(
			"conditions"=>array(
				"Trabajadore.estado"=>"Activo", 
				"Trabajadore.email !="=>"",
				"Trabajadore.cargo_id"=>$cargosId
			),
			"fields"=>array("Trabajadore.id", "Trabajadore.email", "Trabajadore.cargo_id"),
			"recursive"=>-1
		));
		$emailGerente = "";
		foreach($gerenteEmail as $gerenteEmail)
		{
			$emailGerente[$gerenciaCargo[$gerenteEmail["Trabajadore"]["cargo_id"]]] = $gerenteEmail["Trabajadore"]["email"];
		}
		/*
		$emailGerente = $this->Trabajadore->find("list", array(
			"conditions"=>array("Trabajadore.estado"=>"Activo", "Trabajadore.email !="=>""),
			"fields"=>array("Trabajadore.email"),
			"recursive"=>-1
		));
		*/
		//pr($emailGerente);exit;
		$sinRenovacion = "";
		$renovacionPorAgno = "";
		$renovacionPorPeriodosIguales = "";
		foreach($renovaciones as $renovacion)
		{
			if($renovacion["CompaniesContrato"]["companies_renovacion_automatica_id"] == 1)
			{
				$sinRenovacion[] = array(
					"Id"=>$renovacion["CompaniesContrato"]["id"],
					"FechaInicio"=>$renovacion["CompaniesContrato"]["fecha_inicio"],
					"FechaTermino"=>$renovacion["CompaniesContrato"]["fecha_termino"],
					"FechaVencimiento"=>$renovacion["CompaniesContrato"]["fecha_vencimiento"],
					"Gerencia"=>$renovacion["Gerencia"]["nombre"],
					"GerenciaId"=>$renovacion["Gerencia"]["id"],
					"Observacion"=>$renovacion["CompaniesContrato"]["observacion"],
					"NotificacionEmail"=>array((isset($emailGerente[$renovacion["Gerencia"]["id"]]) ? $emailGerente[$renovacion["Gerencia"]["id"]] :""), $renovacion["CompaniesContrato"]["notificacion_email"]),
					"Avisotermino"=>$renovacion["CompaniesAvisoTermino"]["nombre"],
					"Empresa"=>$renovacion["Company"]["nombre"],
					"EmailGerente"=>(isset($emailGerente[$renovacion["Gerencia"]["id"]]) ? $emailGerente[$renovacion["Gerencia"]["id"]] : ""),
					"diasTermino"=>$renovacion["CompaniesAvisoTermino"]["nombre"]
				);
			}
			if($renovacion["CompaniesContrato"]["companies_renovacion_automatica_id"] == 2)
			{
				$renovacionPorAgno[] = array(
					"Id"=>$renovacion["CompaniesContrato"]["id"],
					"FechaInicio"=>$renovacion["CompaniesContrato"]["fecha_inicio"],
					"FechaTermino"=>$renovacion["CompaniesContrato"]["fecha_termino"],
					"FechaVencimiento"=>$renovacion["CompaniesContrato"]["fecha_vencimiento"],
					"Gerencia"=>$renovacion["Gerencia"]["nombre"],
					"GerenciaId"=>$renovacion["Gerencia"]["id"],
					"Observacion"=>$renovacion["CompaniesContrato"]["observacion"],
					"NotificacionEmail"=>array((isset($emailGerente[$renovacion["Gerencia"]["id"]]) ? $emailGerente[$renovacion["Gerencia"]["id"]] : ""), $renovacion["CompaniesContrato"]["notificacion_email"]),
					"Avisotermino"=>$renovacion["CompaniesAvisoTermino"]["nombre"],
					"Empresa"=>$renovacion["Company"]["nombre"],
					"EmailGerente"=>(isset($emailGerente[$renovacion["Gerencia"]["id"]]) ? $emailGerente[$renovacion["Gerencia"]["id"]] : ""),
					"diasTermino"=>$renovacion["CompaniesAvisoTermino"]["nombre"]
				);
			}
			if($renovacion["CompaniesContrato"]["companies_renovacion_automatica_id"] == 3)
			{
				$renovacionPorPeriodosIguales[] = array(
					"Id"=>$renovacion["CompaniesContrato"]["id"],
					"FechaInicio"=>$renovacion["CompaniesContrato"]["fecha_inicio"],
					"FechaTermino"=>$renovacion["CompaniesContrato"]["fecha_termino"],
					"FechaVencimiento"=>$renovacion["CompaniesContrato"]["fecha_vencimiento"],
					"Gerencia"=>$renovacion["Gerencia"]["nombre"],
					"GerenciaId"=>$renovacion["Gerencia"]["id"],
					"Observacion"=>$renovacion["CompaniesContrato"]["observacion"],
					"NotificacionEmail"=>array((isset($emailGerente[$renovacion["Gerencia"]["id"]]) ? $emailGerente[$renovacion["Gerencia"]["id"]] : ""), $renovacion["CompaniesContrato"]["notificacion_email"]),
					"Avisotermino"=>$renovacion["CompaniesAvisoTermino"]["nombre"],
					"Empresa"=>$renovacion["Company"]["nombre"],
					"EmailGerente"=>(isset($emailGerente[$renovacion["Gerencia"]["id"]]) ? $emailGerente[$renovacion["Gerencia"]["id"]] : ""),
					"diasTermino"=>$renovacion["CompaniesAvisoTermino"]["nombre"]
				);
			}
		}
		//pr($sinRenovacion);
		//exit;
		if(!empty($sinRenovacion))
		{
			foreach($sinRenovacion as $sinRenovacion)
			{
				$fechaAviso = date("Y-m-d", strtotime($sinRenovacion["FechaVencimiento"] .'-' .$sinRenovacion["diasTermino"]." day"));
				$fechaActual = date("Y-m-d");
				$fehaNoventaDiasAntes =  date("Y-m-d", strtotime($sinRenovacion["FechaVencimiento"] .'-' ."90 day"));
				if($fechaAviso == $fechaActual || $fechaActual == $fehaNoventaDiasAntes )
				{
					if(!empty($sinRenovacion["NotificacionEmail"]))
					{
						$Email = new CakeEmail("gmail");
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to(array_filter($sinRenovacion["NotificacionEmail"]));
						$Email->subject("Recordatorio Contrato con empresa " .$sinRenovacion["Empresa"]);
						$Email->emailFormat('html');
						$Email->template('recordatorio_contratos_empresas');
						$Email->viewVars(array(
							"fechaInicio"=>$sinRenovacion["FechaInicio"],
							"fechaTermino"=>$sinRenovacion["FechaTermino"],
							"fechaVencimiento"=>$sinRenovacion["FechaVencimiento"],
							"gerencia"=>$sinRenovacion["Gerencia"],
							"observacion"=>$sinRenovacion["Observacion"],
							"empresa"=>$sinRenovacion["Empresa"],
						));
						$Email->send();
					}
				}
				if($fechaActual == $sinRenovacion["FechaVencimiento"] || $fechaActual >= $sinRenovacion["FechaVencimiento"])
				{
					$this->request->data["sinRenovacion"]["id"] = $sinRenovacion["Id"];
					$this->request->data["sinRenovacion"]["terminado"] = 0;
					//$this->request->data["sinRenovacion"]["estado"] = 0;
					if($this->CompaniesContrato->save($this->request->data["sinRenovacion"]))
					{
						CakeLog::write('actividad', 'se cambio de estado el contrato empresa ' . $sinRenovacion["Id"] . " cambio automatico");
					}
				}	
			}
		}
		if(!empty($renovacionPorAgno))
		{
			foreach($renovacionPorAgno as $renovacionPorAgno)
			{
				$fechaAviso = date("Y-m-d", strtotime($renovacionPorAgno["FechaVencimiento"] .'-' .$renovacionPorAgno["diasTermino"] . " day"));
				$fechaActual = date("Y-m-d");
				$fehaNoventaDiasAntes =  date("Y-m-d", strtotime($renovacionPorAgno["FechaVencimiento"] .'-' ."90 day"));
				if($fechaAviso == $fechaActual || $fechaActual == $fehaNoventaDiasAntes)
				{
					if(!empty($renovacionPorAgno["NotificacionEmail"]))
					{
						$Email = new CakeEmail("gmail");
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to(array_filter($renovacionPorAgno["NotificacionEmail"]));
						$Email->subject("Recordatorio Contrato con empresa " .$renovacionPorAgno["Empresa"]);
						$Email->emailFormat('html');
						$Email->template('recordatorio_contratos_empresas');
						$Email->viewVars(array(
							"fechaInicio"=>$renovacionPorAgno["FechaInicio"],
							"fechaTermino"=>$renovacionPorAgno["FechaTermino"],
							"fechaVencimiento"=>$renovacionPorAgno["FechaVencimiento"],
							"gerencia"=>$renovacionPorAgno["Gerencia"],
							"observacion"=>$renovacionPorAgno["Observacion"],
							"empresa"=>$renovacionPorAgno["Empresa"],
						));
						$Email->send();
					}
				}
				if($fechaActual == $renovacionPorAgno["FechaVencimiento"] || $fechaActual >= $renovacionPorAgno["FechaVencimiento"])
				{
					echo 1;
					$this->request->data["renovacionPorAgno"]["id"] = $renovacionPorAgno["Id"];
					$this->request->data["renovacionPorAgno"]["fecha_vencimiento"] = date("Y-m-d", strtotime($renovacionPorAgno["FechaVencimiento"] . '+1 year'));
					if($this->CompaniesContrato->save($this->request->data["renovacionPorAgno"]))
					{
						CakeLog::write('actividad', 'se cambio de estado el contrato empresa ' . $renovacionPorAgno["Id"] . " cambio automatico");
					}
				}	
			}
		}
		if(!empty($renovacionPorPeriodosIguales))
		{
			foreach($renovacionPorPeriodosIguales as $renovacionPorPeriodosIguales)
			{
				$fechaInicial = new DateTime($renovacionPorPeriodosIguales["FechaInicio"]);
				$fechaFinal = new DateTime($renovacionPorPeriodosIguales["FechaTermino"]);
				$intervalorEntreFecha = $fechaInicial->diff($fechaFinal);
				$fechaAviso = date("Y-m-d", strtotime($renovacionPorPeriodosIguales["FechaVencimiento"] .'-' .$renovacionPorPeriodosIguales["diasTermino"] . " day"));
				$fechaActual = date("Y-m-d");
				$fehaNoventaDiasAntes =  date("Y-m-d", strtotime($sinRenovacion["FechaVencimiento"] .'-' ."90 day"));
				if($fechaAviso == $fechaActual || $fechaActual == $fehaNoventaDiasAntes)
				{
					if(!empty($renovacionPorPeriodosIguales["NotificacionEmail"]))
					{
						$Email = new CakeEmail("gmail");
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to(array_filter($sinRenovacion["NotificacionEmail"]));
						$Email->subject("Recordatorio Contrato con empresa " .$renovacionPorPeriodosIguales["Empresa"]);
						$Email->emailFormat('html');
						$Email->template('recordatorio_contratos_empresas');
						$Email->viewVars(array(
							"fechaInicio"=>$renovacionPorPeriodosIguales["FechaInicio"],
							"fechaTermino"=>$renovacionPorPeriodosIguales["FechaTermino"],
							"fechaVencimiento"=>$renovacionPorPeriodosIguales["FechaVencimiento"],
							"gerencia"=>$renovacionPorPeriodosIguales["Gerencia"],
							"observacion"=>$renovacionPorPeriodosIguales["Observacion"],
							"empresa"=>$renovacionPorPeriodosIguales["Empresa"],
						));
						$Email->send();
					}
				}
				if($fechaActual == $renovacionPorPeriodosIguales["FechaVencimiento"] || $fechaActual >= $renovacionPorPeriodosIguales["FechaVencimiento"])
				{	
					echo 2;
					$this->request->data["renovacionPorPeriodosIguales"]["id"] = $renovacionPorPeriodosIguales["Id"];
					$this->request->data["renovacionPorPeriodosIguales"]["fecha_vencimiento"] = date("Y-m-d", strtotime($renovacionPorPeriodosIguales["FechaVencimiento"] .'+' . $intervalorEntreFecha->format('%a') . " day"));
					if($this->CompaniesContrato->save($this->request->data["renovacionPorPeriodosIguales"]))
					{
						CakeLog::write('actividad', 'se cambio de estado el contrato empresa ' . $renovacionPorPeriodosIguales["Id"] ." cambio automatico" );
					}
				}	
			}	
		}
	}
	public function contratos_view()
	{
	}
	public function listar_contratos_empresas()
	{
		$this->layout = "angular";
	}
	public function lista_contratos()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("CompaniesContrato");
		$listaContratos = $this->CompaniesContrato->find("all", array(
			"conditions"=>array("CompaniesContrato.estado"=>1)
		));
		$listaContratosJson = "";
		foreach($listaContratos as $listaContrato)
		{
			$listaContratosJson[] =  array(
				"Id"=>$listaContrato["CompaniesContrato"]["id"],
				"IdTipoContrato"=>$listaContrato["CompaniesContrato"]["company_type_id"],
				"nombreTipoContrato"=>$listaContrato["CompanyType"]["nombre_corto"],
				"FechaDocumento"=>$listaContrato["CompaniesContrato"]["fecha_documento"],
				"FechaInicio"=>$listaContrato["CompaniesContrato"]["fecha_inicio"],
				"FechaVencimiento"=>$listaContrato["CompaniesContrato"]["fecha_vencimiento"],
				"Gerencia"=>$listaContrato["Gerencia"]["nombre"],
				"Observacion"=>$listaContrato["CompaniesContrato"]["observacion"],
				"EmpresaRazonSocial"=>$listaContrato["Company"]["razon_social"],
				"EmpresaRut"=>$listaContrato["Company"]["rut"],
				"EmpresaNombre"=>$listaContrato["Company"]["nombre"],
				"Estado"=>$listaContrato["CompaniesContrato"]["terminado"],
				"Renovacion"=>$listaContrato["CompaniesRenovacionAutomatica"]["nombre"],
				"NotificacionEmail"=>$listaContrato["CompaniesContrato"]["notificacion_email"],
				"Adjunto" => empty($listaContrato["CompaniesContrato"]['adjunto']) ? 'Falta contrato adjunto' : '',
				"adjunto_ruta" => empty($listaContrato["CompaniesContrato"]['adjunto']) ? '' : $listaContrato["CompaniesContrato"]['adjunto']
			);
		}
		$this->set("listaContratosJson", $listaContratosJson);
	}
	public function baja_contrato_manual($id)
	{
		$this->layout = "ajax";
		$this->loadModel("CompaniesContrato");
		$this->CompaniesContrato->id = $id;
		if (!$this->CompaniesContrato->exists()) {
			$this->Session->setFlash('El contrato seleccionado no existe', 'msg_fallo');
			return $this->redirect(array("action" => 'index'));
		}
		if(!empty($id))
		{
			$idEmpresa = $this->CompaniesContrato->find("first", array(
				"conditions"=>array("CompaniesContrato.id"=>$id),
				"fields"=>"company_id",
				"recursive"=> -1
			));
			if(!empty($idEmpresa))
			{
				$this->request->data["CompaniesContrato"]["id"] = $id;
				$this->request->data["CompaniesContrato"]["terminado"] = 0;
				if($this->CompaniesContrato->save($this->request->data["CompaniesContrato"]))
				{
					CakeLog::write('actividad', 'se cambio de estado el contrato id ' . $id . ' usurio id' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash('El contrato cambio de estado a terminado', 'msg_exito');
					return $this->redirect(array("action" => 'contratos_add', $idEmpresa["CompaniesContrato"]["company_id"]));
				}
			}
		}
		else
		{
			$this->Session->setFlash('Seleccione un contrato', 'msg_fallo');
			return $this->redirect(array("action" => 'index'));
		}
	}
	public function verifica_fecha()
	{	
		$this->layout = "ajax";
		$this->response->type('json');
		$estado = "";
		if(!empty($this->params->query["fecha"]) && !empty($this->params->query["idEmpresa"]))
		{
			$this->loadModel("CompaniesContrato");
			$fechaExiste = $this->CompaniesContrato->find("first", array(
				"conditions"=>array("CompaniesContrato.company_id"=>$this->params->query["idEmpresa"], "CompaniesContrato.fecha_documento"=>$this->params->query["fecha"]),
				"fields"=>"id",
				"recursive"=>-1
			));
			if(!empty($fechaExiste))
			{
				$estado = array("Error"=>0, "Mensaje"=>"La fecha seleccionada ya tiene un contrato asociado");
			}
		}
		$this->set('estado', $estado);
	}
	public function listar_contratos_empresas_gerencias()
	{
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
		CakeLog::write('actividad', 'el usuario miro los contratos empresas por gerencias usuario' . $this->Session->Read('Users.trabajadore_id') );
		$this->layout = "angular";
	}
	public function lista_contratos_gerencia()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("CompaniesContrato");
		$this->loadModel("Trabajadore");
		$this->loadModel("Cargo");
		$this->loadModel("Area");
		$this->loadModel("Gerencia");
		$trabajador = $this->Trabajadore->find('first', array(
			'conditions'=>array('Trabajadore.id'=>$this->Session->Read('Users.trabajadore_id')),
			'fields'=> "Trabajadore.cargo_id",
			'recursive' => -1
		));
		$cargo = $this->Cargo->find("first", array(
			'conditions'=>array('Cargo.id'=>$trabajador["Trabajadore"]['cargo_id']),
			'fields'=> "Cargo.area_id",
			'recursive' => -1
		));
		$area = $this->Area->find("first", array(
			'conditions'=>array('Area.id'=>$cargo["Cargo"]['area_id']),
			'fields'=> "Area.gerencia_id",
			'recursive' => -1
		));
		$gerencia = $this->Gerencia->find("first", array(
			'conditions'=>array('Gerencia.id'=>$area["Area"]['gerencia_id']),
			'fields'=> array("Gerencia.id", "Gerencia.nombre"),
			'recursive' => -1
		));
		$listaContratos = $this->CompaniesContrato->find("all", array(
			"conditions"=>array(
				"CompaniesContrato.gerencia_id"=>$gerencia["Gerencia"]["id"],
				"CompaniesContrato.estado"=>1
			)
		));
		$listaContratosJson = "";
		foreach($listaContratos as $listaContrato)
		{
			$listaContratosJson[] =  array(
				"Id"=>$listaContrato["CompaniesContrato"]["id"],
				"IdTipoContrato"=>$listaContrato["CompaniesContrato"]["company_type_id"],
				"nombreTipoContrato"=>$listaContrato["CompanyType"]["nombre_corto"],
				"FechaDocumento"=>$listaContrato["CompaniesContrato"]["fecha_documento"],
				"FechaInicio"=>$listaContrato["CompaniesContrato"]["fecha_inicio"],
				"FechaVencimiento"=>$listaContrato["CompaniesContrato"]["fecha_vencimiento"],
				"Gerencia"=>$listaContrato["Gerencia"]["nombre"],
				"Observacion"=>$listaContrato["CompaniesContrato"]["observacion"],
				"EmpresaRazonSocial"=>$listaContrato["Company"]["razon_social"],
				"EmpresaRut"=>$listaContrato["Company"]["rut"],
				"EmpresaNombre"=>$listaContrato["Company"]["nombre"],
				"Estado"=>$listaContrato["CompaniesContrato"]["terminado"],
				"Renovacion"=>$listaContrato["CompaniesRenovacionAutomatica"]["nombre"],
				"NotificacionEmail"=>$listaContrato["CompaniesContrato"]["notificacion_email"],
				"adjunto"=>$listaContrato["CompaniesContrato"]["adjunto"]
			);
		}
		$this->set("listaContratosJson", $listaContratosJson);
	}
	public function log_contratos($id) {
		$this->autoRender = false;
		$this->response->type('json');
		CakeLog::write('actividad', 'miró contrato de empresa id ' .$id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
		return json_encode(array("status"=>"OK"));
	}
public function registrar_servicios()
{
}
}
