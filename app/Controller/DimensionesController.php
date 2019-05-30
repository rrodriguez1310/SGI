<?php
	App::uses('AppController', 'Controller');

	class DimensionesController extends AppController {

		public function json_listar_dimensiones()
		{
			$this->autoRender = false;
			//$this->response->type('json');

			$dimensiones = $this->Dimensione->find("all", array(
				'order' => array('Dimensione.id ASC'),
			));

			$dimensionesJson = "";

			foreach($dimensiones as $dimensione)
			{
				$dimensionesJson[] = array(
					"Id"=>$dimensione["Dimensione"]["id"],
					"TiposDimensioneId"=>$dimensione["TiposDimensione"]["id"],
					"NombreTipoDimension"=>$dimensione["TiposDimensione"]["nombre"],
					"descripcionTipoDimension"=>$dimensione["TiposDimensione"]["descripcion"],
					"Codigo"=>$dimensione["Dimensione"]["codigo"],
					"Nombre"=>$dimensione["Dimensione"]["nombre"],
					"Descripcion"=>$dimensione["Dimensione"]["descripcion"],
					"CodigoCorto"=>$dimensione["Dimensione"]["codigo_corto"],
				); 	
			}
			return json_encode($dimensionesJson);
		}

		public function index()
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
				return $this -> redirect(array("controller" => 'users', "action" => 'login'));
			}

			if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
			{
				$this->layout = "angular";
				CakeLog::write('actividad', 'miro la pagina dimensiones/index - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
			}
		}

		public function add() 
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
				return $this -> redirect(array("controller" => 'users', "action" => 'login'));
			}

			if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
			{
				if ($this->request->is('post')) 
				{
					$this->Dimensione->create();
					if ($this->Dimensione->save($this->request->data)) {
						CakeLog::write('actividad', 'agrego dimensiones/add - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
						$this->Session->setFlash(__('Insertado con exito'), "msg_exito");
						return $this->redirect(array('action' => 'index'));

					} else {
						$this->Session->setFlash(__('No se pudo insertar el registro'), "msg_fallo");
						return $this->redirect(array('action' => 'index'));
					}
				}

				$tiposDimensionesId = $this->Dimensione->TiposDimensione->find('list', array(
					"fields"=>array("TiposDimensione.id", "TiposDimensione.descripcion")
				));

				$tiposDimensionesId = $this->Dimensione->TiposDimensione->find('list', array(
					"fields"=>array("TiposDimensione.id", "TiposDimensione.descripcion")
				));

				$this->loadModel("DimensionesNombre");
				$nombres = $this->DimensionesNombre->find('list', array(
					"fields"=>array("DimensionesNombre.nombre", "DimensionesNombre.nombre")
				));

				$this->loadModel("DimensionesArea");
				$area = $this->DimensionesArea->find('list', array(
					"fields"=>array("DimensionesArea.nombre", "DimensionesArea.nombre")
				));

				$this->loadModel("DimensionesCodigosCorto");
				$codigoCorto = $this->DimensionesCodigosCorto->find('list', array(
					"fields"=>array("DimensionesCodigosCorto.nombre", "DimensionesCodigosCorto.nombre")
				));

				$codigospresupuestarios = $this->DimensionesCodigosCorto->find('list', array(
					"fields"=>array("DimensionesCodigosCorto.nombre", "DimensionesCodigosCorto.nombre")
				));

				$this->set('tiposDimensioneId', $tiposDimensionesId);
				$this->set('nombre', array_unique($nombres));
				$this->set('area', array_unique($area));
				$this->set('codigoCorto', array_unique($codigoCorto));
			}
		}

		public function edit($id = null) 
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
				return $this -> redirect(array("controller" => 'users', "action" => 'login'));
			}

			if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
			{
				if (!$this->Dimensione->exists($id)) {
					throw new NotFoundException(__('Selección invalida'));
					return $this->redirect(array('action' => 'index'));
				}
				
				if ($this->request->is(array('post', 'put'))) {
					if ($this->Dimensione->save($this->request->data)) {
						CakeLog::write('actividad', 'edito dimensiones/edit - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
						$this->Session->setFlash(__('Editado con exito'), "msg_exito");
						return $this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash(__('No se puedo editar'), "msg_fallo");
					}
				}
				else
				{
					$options = array('conditions' => array('Dimensione.' . $this->Dimensione->primaryKey => $id));
					$this->request->data = $this->Dimensione->find('first', $options);
					$this->set("nombre", $this->request->data["Dimensione"]["nombre"]);
					$this->set("descripcion", $this->request->data["Dimensione"]["descripcion"]);
					
				}
				
				$tiposDimensionesId = $this->Dimensione->TiposDimensione->find('list', array(
					"fields"=>array("TiposDimensione.id", "TiposDimensione.descripcion")
				));
				
				$this->loadModel("DimensionesNombre");
				$nombres = $this->DimensionesNombre->find('list', array(
					"fields"=>array("DimensionesNombre.nombre", "DimensionesNombre.nombre")
				));
				
				$this->loadModel("DimensionesArea");
				$area = $this->DimensionesArea->find('list', array(
					"fields"=>array("DimensionesArea.nombre", "DimensionesArea.nombre")
				));
				
				$this->loadModel("DimensionesCodigosCorto");
				$codigoCorto = $this->DimensionesCodigosCorto->find('list', array(
					"fields"=>array("DimensionesCodigosCorto.nombre", "DimensionesCodigosCorto.nombre")
				));

				$codigospresupuestarios = $this->DimensionesCodigosCorto->find('list', array(
					"fields"=>array("DimensionesCodigosCorto.nombre", "DimensionesCodigosCorto.nombre")
				));

				$this->set('tiposDimensioneId', $tiposDimensionesId);
				$this->set('nombre', array_unique($nombres));
				$this->set('area', array_unique($area));
				$this->set('codigoCorto', array_unique($codigoCorto));
			}
		}

		public function delete($id = null)
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
				return $this -> redirect(array("controller" => 'users', "action" => 'login'));
			}

			if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
			{
				$this->Dimensione->id = $id;

				if (!$this->Dimensione->exists()) {
					throw new NotFoundException(__('Producto Invalido'));
					return $this->redirect(array('action' => 'index'));
				}
				$this->request->allowMethod('get', 'delete');
				if ($this->Dimensione->delete()) {
					CakeLog::write('actividad', 'elimino dimensiones/delete - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
					$this->Session->setFlash(__('Se eliminado correctamente'), 'msg_exito');
				} else {
					$this->Session->setFlash(__('No se pudo elimnar'), 'msg_fallo');
				}
				return $this->redirect(array('action' => 'index'));
			}
		}

		public function lista_tipo_dimension()
		{
			$this->layout = "";
			$this->response->type('json');
						
			$tipDimensiones = $this->Dimensione->find("all", array(
				"conditions"=>array("Dimensione.tipos_dimensione_id"=> trim($this->params->query["descripcion"])),//$this->params->query["descripcion"])
				"fields"=>array("Dimensione.id", "Dimensione.nombre", "Dimensione.codigo")
			));
			
			if(!empty($tipDimensiones))
			{
				$dimencionesAreas = "";
				foreach($tipDimensiones as $tipDimensione)
				{
					$dimencionesAreas[] = array("Nombre"=>$tipDimensione["Dimensione"]["nombre"], "Codigo"=>$tipDimensione["Dimensione"]["codigo"]);
				}
			}
			
			$this->set("dimencionesAreas", $dimencionesAreas);
		}
		
		public function codigo_corto_json()
		{
			$this->layout = "";
			$this->response->type('json');
						
			$codigoCorto = $this->Dimensione->find("first", array(
				"conditions"=>array("Dimensione.nombre"=> trim($this->params->query["descripcion"])),//$this->params->query["descripcion"])
				"fields"=>array("Dimensione.codigo_corto")
			));
			
			$this->set("codigoCoroto", $codigoCorto["Dimensione"]["codigo_corto"]);
		}
	}
