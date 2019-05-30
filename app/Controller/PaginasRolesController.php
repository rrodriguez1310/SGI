<?php
App::uses('AppController', 'Controller');

class PaginasRolesController extends AppController {

	public function paginas_roles_json()
	{	
		$this->layout = "ajax";
		$this->response->type('json');
		$paginasRoles = $this->PaginasRole->find("all", array(
			"conditions"=>array("PaginasRole.pagina_id"=>$this->params->query["id"]),
			"fields"=>array("Role.id", "Role.nombre")
		));
		$rolesAsociados = "";
		if(!empty($paginasRoles))
		{
			
			foreach($paginasRoles as $roles)
			{
				$rolesAsociados[] = array("Id"=>$roles["Role"]["id"], "Nombre"=>$roles["Role"]["nombre"]);
			}
		}
		
		$this->set("rolesAsociados", $rolesAsociados);
	}
	
	
	public function paginas_asociadas_roles()
	{
		$this->layout = "ajax";
		$this->response->type('json');
	
		
		
		$paginasRoles = $this->PaginasRole->find("all", array(
			"conditions"=>array("PaginasRole.role_id"=>$this->params->query["idRol"]),
			"fields"=>array("Pagina.id", "Pagina.controlador", "Pagina.accion", "Pagina.controlador_fantasia", "Pagina.accion_fantasia")
		));
		
		$nombreRolesJson = "";
		
		if(!empty($paginasRoles))
		{
			foreach($paginasRoles as $nombre)
			{
				$nombreRolesJson[] = array(
					"IdPagina"=>$nombre["Pagina"]["id"],
					"ControladorFantasia"=>$nombre["Pagina"]["controlador_fantasia"],
					"AccionFantasia"=>$nombre["Pagina"]["accion_fantasia"]
				);
			}
		}
		
		$this->set("nombreRolesJson", $nombreRolesJson);
	}
	
	
	public function index() {
		
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

	public function view($id = null) {
		
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
	
	public function add() {
		
		$this->layout = "ajax";
		$this->response->type('json');
		$estado = "";
		
		if(!empty($this->params->query["idPagina"]) && !empty($this->params->query["idRol"]))
		{
			if ($this->request->is('get'))
			{
				$existePaginaRol = $this->PaginasRole->find("first", array(
					"conditions"=>array("PaginasRole.pagina_id"=>$this->params->query["idPagina"], "PaginasRole.role_id"=>$this->params->query["idRol"]),
					"fields"=>array("PaginasRole.id"),
					"recursive"=>0
				));
				
				if(!empty($existePaginaRol["PaginasRole"]["id"]))
				{
					$estado = array("Error"=>0, "Mensaje"=>"LA ASOCIACIÓN YA EXISTE");  
				}
				else
				{					
					$this->request->data["PaginasRole"]["pagina_id"] = $this->params->query["idPagina"];
					$this->request->data["PaginasRole"]["role_id"] = $this->params->query["idRol"];

					if($this->PaginasRole->save($this->request->data))
					{
						$estado = array("Error"=>1, "Mensaje"=>"LA ASOCIACIÓN FUE REGISTRADA");  
					}
				}
			}
		}
		else
		{
			$estado = array("Error"=>0, "Mensaje"=>"NO SE PUEDE REGISTRAR. SELECCIONE AL MENOS UNA PAGINA Y UN ROL");  
		}
		
		$this->set("estado", $estado);
		
		/*
		if ($this->request->is('post')) {	
			$paginas = $this->request->data["PaginasRole"]["pagina_id"];
			$role_id = $this->request->data["PaginasRole"]["role_id"];
			$paginasRolesArray = "";
			foreach($paginas as $pagina)
			{
					$paginasRolesArray[] = array("role_id"=>$role_id, "pagina_id"=>$pagina);
			}			
			//pr($paginasRolesArray);exit;

			$estado = "";
			
			$this-> PaginasRole ->create();
			if ($this->PaginasRole->saveAll($paginasRolesArray)) {
				$estado = 1;	
				
				//$this->Session->setFlash(__('The companies attribute has been saved.'));
				//return $this->redirect(array('action' => 'index'));
			} else {
				$estado = 0;	
				//$this->Session->setFlash(__('The companies attribute could not be saved. Please, try again.'));
			}
			
			$this->set('estado', $estado);
		}
		//$companies = $this->CompaniesAttribute->Company->find('list');
		//$channels = $this->CompaniesAttribute->Channel->find('list');
		//$links = $this->CompaniesAttribute->Link->find('list');
		//$signals = $this->CompaniesAttribute->Signal->find('list');
		//$payments = $this->CompaniesAttribute->Payment->find('list');
		//$this->set(compact('companies', 'channels', 'links', 'signals', 'payments'));
		 * 
		 */
	}
	
	public function delete(){
		
		$this->layout = "ajax";
		$this->response->type('json');
		if(!empty($this->request->data)){
			$paginasRole = $this->PaginasRole->find("first", array("conditions"=>array("PaginasRole.pagina_id"=>$this->request->data["idPagina"], "PaginasRole.role_id"=>$this->request->data["idRol"])));
			if(!empty($paginasRole)){
				if($this->PaginasRole->delete($paginasRole["PaginasRole"]["id"])){
					CakeLog::write('actividad', 'Elimino - PaginasRoles - delete - ID '.$paginasRole["PaginasRole"]["id"].' id de pagina '.$this->request->data["idPagina"].' id de rol '.$this->request->data["idRol"].' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"SE ELIMINO LA ASOCIACIÓN"
						);	
				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"No se pudo eliminar, por favor intentelo de nuevo"
						);	
				}
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se encontro la asociacion, por favor intentelo de nuevo"
					);
			}
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No se enviaron los datos correctamente, por favor intente de nuevo"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
		/*
		if ($this->request->is('post')) {
			$paginas = $this->request->data["PaginasRole"]["id"];
			foreach($paginas as $pagina)
			{
				$paginasArray["PaginasRole.id"][] = $pagina;
			}
			
			$estado = "";
			
			//pr($paginasArray);exit;
			//$this-> PaginasRole ->create();
			if ($this->PaginasRole->deleteAll($paginasArray)) {
				$estado = 1;	
				
				//$this->Session->setFlash(__('The companies attribute has been saved.'));
				//return $this->redirect(array('action' => 'index'));
			} else {
				$estado = 0;	
				//$this->Session->setFlash(__('The companies attribute could not be saved. Please, try again.'));
			}
			
			$this->set('estado', $estado);
		}*/
	}
	
	public function actualizarPaginaRoles() {
		
		$this->layout = "ajax";
		$idPaginas = $this->Role->Find("all", array(
			"conditions"=>array("Role.id"=>$this->params->query["id"])
		)); 
		$checked = explode(",", $_GET["checked"]);
		$id = $_GET["id"];
		$idPaginasArray ="";
		foreach($idPaginas[0]["PaginasRole"] as  $valorIdPAginas)
		{
			$idPaginasArray[$valorIdPAginas["id"]] = $valorIdPAginas["pagina_id"]; 
			
		}
		if($idPaginasArray=="")
		{		
			foreach($insertar as $insert)
			{
				$parametro[] = array("role_id"=>$id, "pagina_id"=>$insert);
			}
			pr($parametro);exit;
		}else
			{
				$borrar = array_diff($idPaginasArray, $checked);
				$insertar = array_diff($checked, $idPaginasArray);
				if(!empty($insertar))
				{
					pr("insert");
					pr($insertar);
					//pr($idPaginasArray);
					//pr(explode(",", $_GET["insertar"]));exit;
				}
				if(!empty($borrar))
				{
					pr("borrar");
					pr($borrar);
					//pr($idPaginasArray);
					//pr(explode(",", $_GET["insertar"]));exit;
				}
				exit;
				
			}
		//pr($resultado);exit;
		if(!empty($idPaginasArray))
		{
			echo json_encode($idPaginasArray);
		}
		exit;
		
		
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
			//$canales = array();
			
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
			//inicio
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

	public function paginas_roles_list()
	{	
		$this->layout = "ajax";
		
		$this->response->type('json');
		$paginasRoles = $this->PaginasRole->find("all", array(
			//'conditions'=>array('pagina_id' => 264),
		));

		$rolesAsociados = "";
		if(!empty($paginasRoles))
		{
			$respuesta = array(
				"estado"=>1,
				"data"=>$paginasRoles
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"No se encontraron paginas asociadas al roles"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
	}
}
