<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ComprasController extends AppController 
{
	public $components = array('RequestHandler');
	/**
	*
	* @author Cristian Quijada
	* muestra todos los requerimientos que ha creado el usuario
	* 
	*/
	public function index($empresaSeleccionada = null) 
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
		CakeLog::write('actividad', 'miro la pagina compras/index - ' . $this->Session->Read("PerfilUsuario.idUsuario"));


		if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
		{

			

			$this->loadModel("ComprasProductosTotale");

			if(!empty($empresaSeleccionada))
			{
				$ordenCompra = $this->ComprasProductosTotale->find("all", array(
					'conditions'=>array(
						"ComprasProductosTotale.id"=>explode('-', $empresaSeleccionada),
						"ComprasProductosTotale.user_id"=>$this->Session->Read("PerfilUsuario.idUsuario"),
						"ComprasProductosTotale.estado != "=> 0,
						//"ComprasProductosTotale.estado !="=>6,
						//"ComprasProductosTotale.tipos_documento_id !="=>""
						//'OR'=>array("ComprasProductosTotale.estado !="=>6, "ComprasProductosTotale.tipos_documento_id !="=>"",)
						
					),
					'order'=>'ComprasProductosTotale.id DESC',
					//'order' => "FIELD(Login.profile_type, 'Basic', 'Premium') DESC"
				));
			}
			else
			{
				$ordenCompra = $this->ComprasProductosTotale->find("all", array(
					'conditions'=>array(
						"ComprasProductosTotale.user_id"=>$this->Session->Read("PerfilUsuario.idUsuario"),
						"ComprasProductosTotale.estado != "=> 0,
						//"ComprasProductosTotale.estado !="=>6,
						//"ComprasProductosTotale.tipos_documento_id !="=>""
						//'OR'=>array("ComprasProductosTotale.estado !="=>6, "ComprasProductosTotale.tipos_documento_id !="=>"",)
						
					),
					'order'=>'ComprasProductosTotale.id DESC',
					//'order' => "FIELD(Login.profile_type, 'Basic', 'Premium') DESC"
				));
			}
			

			$rechazadosId = "";

			foreach($ordenCompra as $ordenCompraProductos)
			{
				foreach($ordenCompraProductos["ComprasProducto"] as $productos)

				if($productos["estado"] == 5 || $productos["estado"] == 3)
				{
					$rechazadoId[] = $productos["id"];
				}
			}

			if(!emptY($rechazadoId))
			{
				$this->loadModel("ComprasProductosRechazo");

				$rechazados = $this->ComprasProductosRechazo->find("all", array(
					'conditions'=>array("ComprasProductosRechazo.compras_producto_id"=>$rechazadoId)
				));
			
				$mensajeRechazados = "";
				foreach($rechazados as $rechazado)
				{
					$mensajeRechazados[$rechazado["ComprasProductosRechazo"]["compras_producto_id"]] = $rechazado["ComprasProductosRechazo"]["motivo"];
				}
			}
			//$this->set("mensajeRechazados", $mensajeRechazados);

			$this->set("empresaSeleccionada", "");
			/*

			if(!empty($empresaSeleccionada))
			{
				$this->set("empresaSeleccionada", $empresaSeleccionada);
			}
			else
			{
				$this->set("empresaSeleccionada", "");
			}
			*/
			$this->set("ordenCompra", $ordenCompra);
			CakeLog::write('actividad', 'miro la pagina compras/index - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
		}
		
	}
	
	/**
	*
	* @author Cristian Quijada
	* este es un metodo para el ingreso de nuevos requerimientos de compra
	*/
	public function add()
	{
		//$this->layout ="angular";
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		
		$vacio = array(""=>"");
		
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		
		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);
		
		$proveedores = $this->Company->find("list", array(
			//"conditions"=>array("Company.company_type_id"=>2),
			"fields"=>array("Company.id", "Company.alias")
		));
		
		if(!empty($proveedores))
		{
			//array_unshift($proveedores, $vacio);
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);
		}
		
		$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
		));
		
		if(!empty($tipoMonedas))
		{
			//array_unshift($tipoMonedas, $vacio);
			$this->set("tipoMonedas", $tipoMonedas);
		}
		
		$plazosPagos = $this->PlazosPago->find("list", array(
			"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));
		
		if(!empty($plazosPagos))
		{
			array_unshift($plazosPagos, $vacio);
			$this->set("plazosPagos", $plazosPagos);
		}
		
		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));
		
		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}
		
		$dimensiones = $this->Dimensione->find("all", array());
		
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				//pr($dimensione);
				
				//pr($dimensione["TiposDimensione"]["id"]);

				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["id"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			
			$dimensionUno[$tipoDimensione["Nombre"]] = $tipoDimensione["Nombre"];
		}
		array_unshift($dimensionUno, $vacio);
		
		$this->set("dimensionUno", $dimensionUno);
		
		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Nombre"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);
		
		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Nombre"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);
		
		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Nombre"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);
		
		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Nombre"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);
	}


	/**
	*
	* @author Cristian Quijada
	* Metodo para ver el detalle de una orden de compra la cual se filtra por el id que pasa por get
	* @return Metodo para ver el detalle de una orden de compra la cual se filtra por el id que pasa por get
	* @param  string $id, parametro de entrada,  id valido para mostrar su detalle de orden de compra
	*/
	public function view($id, $perfilUsuario = null) 
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
		
		if($this->Session->read('Users.flag') == 1)
		{
			CakeLog::write('actividad', 'miro la pagina compras/view - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
			$this->loadModel("ComprasProductosTotale");
			if (!$this->ComprasProductosTotale->exists($id)) {
				$this->Session->setFlash('El requerimiento de compras no existe', 'msg_fallo');
				return $this->redirect(array("action"=>'index'));
			}

			$options = array('conditions' => array('ComprasProductosTotale.' . $this->ComprasProductosTotale->primaryKey => $id));
			$ordenCompras = $this->ComprasProductosTotale->find('first', $options);
			$this->set('ordenCompra', $ordenCompras);
			if(!empty($perfilUsuario))
			{
				$this->set("perfilUsuario", $perfilUsuario);
				$this->set("aprobarCompra", "aprobar_compra");
				$this->set("rechazarCompra", "#rechazo_requerimiento");
				$this->set("id", $id);
			}
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("action"=>'index'));
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id) 
	{

		
		if($this->Session->read('Users.flag') == 1)
		{
			$this->loadModel("ComprasProductosTotale");
			$this->ComprasProductosTotale->id = $id;
			if (!$this->ComprasProductosTotale->exists()) 
			{
				$this->Session->setFlash('El requerimiento compra no existe', 'msg_fallo');
				return $this->redirect(array("action"=>'index'));
			}
			
			$this->request->allowMethod('post', 'delete');

			$this->request->data["ComprasProductosTotale"]["id"] = $id;
			$this->request->data["ComprasProductosTotale"]["estado"] = 0;
 
			if ($this->ComprasProductosTotale->save($this->request->data))
			{
				CakeLog::write('actividad', 'Se eliemino el requerimiento de compra ID - ' . $id . '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
				$this->Session->setFlash('El requerimiento compra fue eliminado', 'msg_exito');
			} 
			else 
			{
				$this->Session->setFlash('El requerimiento compra fue eliminado', 'msg_fallo');
			}
			return $this->redirect(array('action' => 'index'));
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("action"=>'index'));
		}
	}


	/**
 * edit method
 * @author  Cristian Quijada
 * @throws NotFoundException
 * @param string $id
 * @return void
 * Se le pasa el id para poder editar el registro de un requeriminto de compra
 */
	public function edit($id) {
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
		
	 	$this->loadModel("ComprasProductosTotale");


		CakeLog::write('actividad', 'miro la pagina compras/edit - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

		//$this->layout ="angular";
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		
		if(!empty($id))
		{
			$comprasProductosTotale = $this->ComprasProductosTotale->find("first", array(
				'conditions'=>array("ComprasProductosTotale.id"=>$id)
			));
			
			$this->set("comprasProductosTotale", $comprasProductosTotale);
			$this->set("id", $id);
		}

		
		
		$vacio = array(""=>"");
		
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		
		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);
		
		$proveedores = $this->Company->find("list", array(
			"conditions"=>array("Company.company_type_id"=>2),
			"fields"=>array("Company.id", "Company.nombre")
		));
		
		if(!empty($proveedores))
		{
			//array_unshift($proveedores, $vacio);
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);
		}
		
		$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
		));
		
		if(!empty($tipoMonedas))
		{
			$tipoMonedas[0] = $vacio;
			ksort($tipoMonedas);
			$this->set("tipoMonedas", $tipoMonedas);
		}
		
		$plazosPagos = $this->PlazosPago->find("list", array(
			"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));
		
		if(!empty($plazosPagos))
		{
			$plazosPagos[0] = $vacio;
			ksort($plazosPagos);
			$this->set("plazosPagos", $plazosPagos);
		}
		
		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));
		
		if(!empty($empaques))
		{
			$empaques[0] = $vacio;
			ksort($empaques);
			$this->set("empaques", $empaques);
		}
		
		$dimensiones = $this->Dimensione->find("all", array());
		
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["id"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			
			$dimensionUno[$tipoDimensione["Nombre"]] = $tipoDimensione["Nombre"];
		}
		array_unshift($dimensionUno, $vacio);
		
		$this->set("dimensionUno", $dimensionUno);
		
		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Nombre"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);
		
		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Nombre"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);
		
		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Nombre"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);
		
		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Nombre"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);
	}


/**
 * aprobadores method
 * @author  Cristian Quijada
 * @throws NotFoundException
 * @param string 
 * @return void
 * Retorna un listado con requerimientos de compra para su aprobacion 
 * Se le pasa el id para poder editar el registro de un requeriminto de compra
 */
	public function aprobadores()
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
		
	 	$this->loadModel("ComprasProductosTotale");


		CakeLog::write('actividad', 'entro a  la pagina compras/aprobadores - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
		//echo "<br/><br/><br/><br/><br/>";
		//print_r($this->Session->read());
		if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
		{	
			$emailCorto = explode(".", $this->Session->Read("Users.email"));
			$emailAprobador = $emailCorto[0] .".cl";

			if(!empty($emailAprobador))
			{
				$this->loadModel("Email");

				$requerimientos = $this->Email->find('all', array(
					'conditions'=>array('Email.email'=>strtolower($emailAprobador)),
					'fields'=>'Email.informe'
				));

				if(!empty($requerimientos))
				{
					foreach($requerimientos as $requerimiento)
					{
						$codigosCortos[] = explode('-',$requerimiento["Email"]["informe"]);
					}
				}
				$codigos = "";
				foreach($codigosCortos as $codigosCorto)
				{
					if($codigosCorto[0] == "Aprobador")
					{
						$codigos[] = $codigosCorto[1];
					}
				}

				$conditions = "";
				if(!empty($codigos))
				{
					foreach ($codigos as $codigo) {
    					$conditions['OR'][] = array('ComprasProducto.codigos_presupuestarios LIKE' => "%".$codigo."%");
					}	
				}

				if(!empty($conditions))
				{
					$this->loadModel("ComprasProducto");

					$ordenCompra = $this->ComprasProducto->find("all", array(
						'conditions'=>$conditions,
						'order'=>array('ComprasProducto.id ASC'),
						'recursive'=>2
					));

					$this->set("ordenCompra", $ordenCompra);
				}
				/*$requerimientos = $this->Email->find('first', array(
					'conditions'=>array('Email.email'=>strtolower($emailAprobador),
					"Email.informe LIKE"=>"%Aprobador%"
					),
					'fields'=>'Email.informe'
				));

				if(!empty($requerimientos))
				{
					$codigoCorto = explode('-', $requerimientos["Email"]["informe"]);
				}
				
				if(!empty($codigoCorto[1]))
				{
					$this->loadModel("ComprasProducto");

					$ordenCompra = $this->ComprasProducto->find("all", array(
						'conditions'=>array(
							"ComprasProducto.codigos_presupuestarios LIKE"=> '%'.$codigoCorto[1].'%',
						),
						'order'=>array('ComprasProducto.id ASC'),
						'recursive'=>2
					));

					$this->set("ordenCompra", $ordenCompra);	
				}*/

				$comprasTotales = "";
				if(!empty($ordenCompra))
				{

					foreach($ordenCompra as $ordenCompras)
					{
						$numeroFactura = "";
						$nombreDocumentos = "";
						//pr($ordenCompras["ComprasProductosTotale"]["ComprasFactura"][0]["numero_documento"]);
						if($ordenCompras["ComprasProductosTotale"]["estado"] != 0)
						{
							if(isset($ordenCompras["ComprasProductosTotale"]["ComprasFactura"][0]["numero_documento"]))
							{
								$numeroFactura = $ordenCompras["ComprasProductosTotale"]["ComprasFactura"][0]["numero_documento"];
							}
							if(isset($ordenCompras["ComprasProductosTotale"]["TiposDocumento"]["nombre"]))
							{
								$nombreDocumentos = $ordenCompras["ComprasProductosTotale"]["TiposDocumento"]["nombre"];
							}
							$comprasTotales[$ordenCompras["ComprasProductosTotale"]["id"]] = array(
								"IdRequerimiento" => $ordenCompras["ComprasProductosTotale"]["id"],
								"Empresa"=> $ordenCompras["ComprasProductosTotale"]["Company"]["nombre"],
								"Titulo"=> $ordenCompras["ComprasProductosTotale"]["titulo"],
								"Fecha"=> $ordenCompras["ComprasProductosTotale"]["created"],
								"Total"=> $ordenCompras["ComprasProductosTotale"]["total"],
								"Estado"=> $ordenCompras["ComprasProductosTotale"]["estado"],
								"Rechazo"=>$ordenCompras["ComprasProductosTotale"]["ComprasProductosRechazo"],
								"docTributario"=>$nombreDocumentos,
								"numeroFactura"=> $numeroFactura,
	 						);

						}
					}
				}
				

				$this->set("comprasTotales", $comprasTotales);
			}
		}
		//echo "<br/><br/><br/><br/><br/>";
		//pr($ordenCompras[]["ComprasFactura"]["numero_documento"]);
	}


	public function aprobar_compra($id)
	{

		//pr($this->Session->read());
		$this->layout = null;
		$this->loadModel("ComprasProducto");
		$this->loadModel("ComprasProductosTotale");

		if (!$this->ComprasProductosTotale->exists($id)) 
		{
			$this->Session->setFlash('El Producto no existe', 'msg_fallo');
			return $this->redirect(array('action' => 'index'));
		}


		if (!empty($id)) 
		{
			$aprobacionRechazo[] = array(
				"Id"=>$id,
				"UsuarioAprobador"=>$this->Session->Read("Users.nombre"),
				"FechaAprobacion"=>date("m-d-Y H:i")
			);
			
			$this->request->data["ComprasProductosTotale"]["id"] = $id;
			$this->request->data["ComprasProductosTotale"]["estado"] = 2;
			$this->request->data["ComprasProductosTotale"]["aprobacion_rechazo"] = serialize($aprobacionRechazo);
			
			if ($this->ComprasProductosTotale->save($this->request->data)) 
			{
				CakeLog::write('actividad', 'Se aprobo el requerimiento de compra ID - ' . $id . '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
				
				$this->loadModel("Email");

				$idUsuarioRequerimientoCompra = $this->ComprasProductosTotale->find("first", array(
					'conditions'=>array('ComprasProductosTotale.id'=>$id),

				));

				/*
				$tipoRequerimiento = $this->ComprasProductosTotale->find("first", array(
					"conditions"=>array("ComprasProductosTotale.id"=>$id)
				));

				*/

				//pr($idUsuarioRequerimientoCompra)

				
				if($idUsuarioRequerimientoCompra["TiposDocumento"]["id"] == 1 || $idUsuarioRequerimientoCompra["TiposDocumento"]["id"] == 2 || $idUsuarioRequerimientoCompra["TiposDocumento"]["id"] == 3)
				{
					$plantilla = "orden_compra_aprobada";
				}
				else
				{
					$plantilla = "documento_aprobado_gerencia";
				}


				$emailSap = $this->Email->find("first", array(
					'conditions'=>array('Email.informe'=>"Ingreso-Sap"),
					'fields'=>"Email.email"
				));

				$emailCorto = explode(".", $idUsuarioRequerimientoCompra["User"]["email"]);
				$email[] = strtolower($emailCorto[0].'.cl');
				$email[] = strtolower($emailSap["Email"]["email"]);



				
				if(!empty($idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"]))
				{
					$numeroRequerimiento = $idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"] . ' - ' .$idUsuarioRequerimientoCompra["ComprasFactura"][0]["numero_documento"];
					$plantilla = "orden_compra_aprobada";
					$nombreEmail = "SE APROBO UN DOCUMENTO TRIBUTARIO";
				}
				else
				{
					$numeroRequerimiento = $idUsuarioRequerimientoCompra["ComprasProductosTotale"]["id"];
					$plantilla = "orden_compra_aprobada";
					$nombreEmail = "SE APROBO UN NUEVO REQUERIMIENTO DE COMPRA";
				}



				$this->loadModel("Email");
				$Email = new CakeEmail("gmail");
				$Email->from(array('sgi@cfd.cl' => 'SGI'));
				$Email->to($email);
				$Email->subject($nombreEmail);
				$Email->emailFormat('html');
				$Email->template($plantilla);

				$Email->viewVars(array(
					"nombreEmail"=>$nombreEmail,
					"numeroRequerimiento"=>$numeroRequerimiento,
					"usuario"=>$this->Session->read("Users.nombre"),
					"creador"=>$idUsuarioRequerimientoCompra["User"]["nombre"],
					"fechaCreacion"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["created"],//date("d/m/Y H:i"),
					"titulo"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["titulo"],
					"total"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["total"],
					"empresa"=>$idUsuarioRequerimientoCompra["Company"]["nombre"]
				));

				$Email->send();
				$this->Session->setFlash('Producto aprobado', 'msg_exito');
				return $this -> redirect(array("action" => 'aprobadores'));
			}
			else
			{
				$this->Session->setFlash('Ocurrio un problema no se puede aprobar el producto', 'msg_fallo');
				return $this -> redirect(array("action" => 'aprobadores'));
			}
		}
	}

	public function compras_rechazar()
	{
		$this->layout = null;
		

		$this->loadModel("ComprasProductosTotale");

		if(!empty($this->data))
		{
			$aprobacionRechazo[] = array(
				"Id"=>$this->data["id_rechazo"],
				"UsuarioAprobador"=>$this->Session->Read("Users.nombre"),
				"FechaAprobacion"=>date("m-d-Y H:i")
			);

			if (!$this->ComprasProductosTotale->exists($this->data["id_rechazo"])) 
			{
				$this->Session->setFlash('El Producto no existe', 'msg_fallo');
				return $this->redirect(array('action' => 'aprobadores'));
			}

			if($this->data["id_rechazo"]) 
			{
				$this->request->data["ComprasProductosTotale"]["id"] = $this->data["id_rechazo"];
				$this->request->data["ComprasProductosTotale"]["estado"] = 3;
				$this->request->data["ComprasProductosTotale"]["aprobacion_rechazo"] = serialize($aprobacionRechazo);
				
				if ($this->ComprasProductosTotale->save($this->request->data)) 
				{
					CakeLog::write('actividad', 'Se rechazo el requerimiento de compra ID - ' . $this->data["id_rechazo"] . '(' .$this->Session->read('Users.nombre') .')');

					$this->loadModel("ComprasProductosRechazo");

					$this->request->data["ComprasProductosRechazo"]["compras_productos_totale_id"] = $this->data["id_rechazo"];
					$this->request->data["ComprasProductosRechazo"]["motivo"] =  $this->request->data["Compras"]["motivoRechazo"];
					$this->request->data["ComprasProductosRechazo"]["user_id"] = $this->Session->read("PerfilUsuario.idUsuario");

					$this->ComprasProductosRechazo->save($this->request->data["ComprasProductosRechazo"]);


					$this->loadModel("Email");

					$idUsuarioRequerimientoCompra = $this->ComprasProductosTotale->find("first", array(
						'conditions'=>array('ComprasProductosTotale.id'=>$this->data["id_rechazo"]),
						//'recursive'=>3
					));
					



					if(!empty($idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"]))
					{
						$numeroRequerimiento = $idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"] . ' - ' .$idUsuarioRequerimientoCompra["ComprasFactura"][0]["numero_documento"];
						$plantilla = "orden_compra_rechazada";
						$nombreEmail = "SE RECHAZO UN DOCUMENTO TRIBUTARIO"; 
					}
					else
					{
						$numeroRequerimiento = $idUsuarioRequerimientoCompra["ComprasProductosTotale"]["id"];
						$plantilla = "orden_compra_rechazada";
						$nombreEmail = "SE RECHAZO UN REQUERIMIENTO DE COMPRA";
					}

					
					$emailSap = $this->Email->find("first", array(
						'conditions'=>array('Email.informe'=>"Ingreso-Sap"),
						'fields'=>"Email.email"
					));

					$emailSapLimpio = explode(".", $idUsuarioRequerimientoCompra["User"]["email"]);	
					$email[] = $emailSapLimpio[0].".cl";	
					$email[] = $emailSap["Email"]["email"];


					$Email = new CakeEmail("gmail");
					$Email->from(array('sgi@cfd.cl' => 'SGI'));
					$Email->to($email);
					$Email->subject($nombreEmail);
					$Email->emailFormat('html');
					$Email->template($plantilla);

					$Email->viewVars(array(
						"nombreEmail"=>$nombreEmail,
					"numeroRequerimiento"=>$numeroRequerimiento,
					"usuario"=>$this->Session->read("Users.nombre"),
					"creador"=>$idUsuarioRequerimientoCompra["User"]["nombre"],
					"fechaCreacion"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["created"],//date("d/m/Y H:i"),
					"titulo"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["titulo"],
					"total"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["total"],
					"empresa"=>$idUsuarioRequerimientoCompra["Company"]["nombre"]
					));
					$Email->send();

					$this->Session->setFlash('Requerimiento de compra no aprobado', 'msg_exito');
					return $this->redirect(array("action" => 'aprobadores'));
				}
				else
				{
					$this->Session->setFlash('Ocurrio un problema no se puede aprobar el producto', 'msg_fallo');
					return $this -> redirect(array("action" => 'aprobadores'));
				}
			}

		}
			
	}

	public function ingreso_sap()
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

		CakeLog::write('actividad', 'entro a  la pagina compras/ingreso_sap - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

		if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
		{
			$this->loadModel("ComprasProductosTotale");
			$ordenCompra = $this->ComprasProductosTotale->find("all", array(
				'conditions'=>array(
					"ComprasProductosTotale.estado"=>2,
					"ComprasProductosTotale.estado != "=> 0
				),
				'order'=>array('ComprasProductosTotale.id DESC'),
			));
			
			$rechazadosId = "";

			foreach($ordenCompra as $ordenCompraProductos)
			{
				foreach($ordenCompraProductos["ComprasProducto"] as $productos)

				if($productos["estado"] == 5 || $productos["estado"] == 3)
				{
					$rechazadoId[] = $productos["id"];
				}
			}

			if(!emptY($rechazadoId))
			{
				$this->loadModel("ComprasProductosRechazo");

				$rechazados = $this->ComprasProductosRechazo->find("all", array(
					'conditions'=>array("ComprasProductosRechazo.compras_producto_id"=>$rechazadoId)
				));
			
				$mensajeRechazados = "";
				foreach($rechazados as $rechazado)
				{
					
					$mensajeRechazados[$rechazado["ComprasProductosRechazo"]["compras_producto_id"]] = $rechazado["ComprasProductosRechazo"]["motivo"];
				}
			}
			$this->set("ordenCompra", $ordenCompra);
		}
	}




	public function aprobar_compra_sap()
	{
		$this->layout = "ajax";

		$estado = "";
		$id = $this->params["data"]["pk"];
		$codigoSap = $this->params["data"]["value"];


		$this->loadModel("ComprasProducto");
		$this->loadModel("ComprasProductosTotale");

		if (!$this->ComprasProductosTotale->exists($id)) 
		{
			$this->Session->setFlash('El Producto no existe', 'msg_fallo');
			return $this->redirect(array('action' => 'index'));
		}


		if (!empty($id)) 
		{
			$aprobacionRechazo[] = array(
				"Id"=>$id,
				"UsuarioAprobarSap"=>$this->Session->Read("Users.nombre"),
				"FechaAprobacion"=>date("m-d-Y H:i")
			);

			$this->request->data["ComprasProductosTotale"]["id"] = $id;
			$this->request->data["ComprasProductosTotale"]["estado"] = 4;
			$this->request->data["ComprasProductosTotale"]["aprobacion_rechazo_sap"] = serialize($aprobacionRechazo);
			$this->request->data["ComprasProductosTotale"]["numero_sap"] = $codigoSap;

			if ($this->ComprasProductosTotale->save($this->request->data)) 
			{
				CakeLog::write('actividad', 'Se aprobo el requerimiento de compra en SAP ID - ' . $id . '(' .$this->Session->read('Users.nombre') .')');
				$this->loadModel("Email");

				$idUsuarioRequerimientoCompra = $this->ComprasProductosTotale->find("first", array(
					'conditions'=>array('ComprasProductosTotale.id'=>$id),

				));

				$emailSap = $this->Email->find("first", array(
					'conditions'=>array('Email.informe'=>"Ingreso-Sap"),
					'fields'=>"Email.email"
				));


				if(!empty($idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"]))
				{
					$numeroRequerimiento = $idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"] . ' - ' .$idUsuarioRequerimientoCompra["ComprasFactura"][0]["numero_documento"];
					$plantilla = "orden_compra_aprobada";
					$nombreEmail = "SE APROBO UN DOCUMENTO TRIBUTARIO, INGRESO SAP";
				}
				else
				{
					$numeroRequerimiento = $idUsuarioRequerimientoCompra["ComprasProductosTotale"]["id"];
					$plantilla = "orden_compra_aprobada";
					$nombreEmail = "SE APROBO UN NUEVO REQUERIMIENTO DE COMPRA , INGRESO SAP";
				}




				//$emailCorto = explode(".", $idUsuarioRequerimientoCompra["User"]["email"]);
				$envioEmail = "";

				foreach ($email as $sendEmail) {
					$envioEmail[] = $sendEmail["Email"]["email"];
				}


				//$email[] = $emailCorto[0].'.cl';

				$envioEmail[] = $emailSap["Email"]["email"];

				$this->loadModel("Email");
				$Email = new CakeEmail("gmail");
				$Email->from(array('sgi@cfd.cl' => 'SGI'));
				$Email->to($envioEmail);
				$Email->subject("Requerimiento de Compra aprobado");
				$Email->emailFormat('html');
				$Email->template('orden_compra_aprobada_sap');

				$Email->viewVars(array(
					"nombreEmail"=>$nombreEmail,
					"numeroRequerimiento"=>$numeroRequerimiento,
					"usuario"=>$this->Session->read("Users.nombre"),
					"creador"=>$idUsuarioRequerimientoCompra["User"]["nombre"],
					"fechaCreacion"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["created"],//date("d/m/Y H:i"),
					"titulo"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["titulo"],
					"total"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["total"],
					"empresa"=>$idUsuarioRequerimientoCompra["Company"]["nombre"]
				));

				
				$Email->send();
				$this->Session->setFlash('El requerimiento de compra aprobada', 'msg_exito');
				$estado = 1;
				//return $this -> redirect(array("action" => 'ingreso_sap'));
			}
			else
			{
				$this->Session->setFlash('Ocurrio un problema no se puede aprobar el requerimiento de compra', 'msg_fallo');
				//return $this -> redirect(array("action" => 'ingreso_sap'));
				$estado = 2;
			}
		}
		$this->set("estado", $estado);
	}




	public function compras_rechazar_sap()
	{

		$this->layout = null;

		$this->loadModel("ComprasProductosTotale");

		if(!empty($this->data))
		{
			if (!$this->ComprasProductosTotale->exists($this->data["id_rechazo"])) 
			{
				$this->Session->setFlash('El Producto no existe', 'msg_fallo');
				return $this->redirect(array('action' => 'aprobadores'));
			}

			if($this->data["id_rechazo"]) 
			{
				$aprobacionRechazo[] = array(
					"Id"=>$this->data["id_rechazo"],
					"UsuarioAprobarSap"=>$this->Session->Read("Users.nombre"),
					"FechaAprobacion"=>date("m-d-Y H:i")
				);
				$this->request->data["ComprasProductosTotale"]["id"] = $this->data["id_rechazo"];
				$this->request->data["ComprasProductosTotale"]["estado"] = 5;
				$this->request->data["ComprasProductosTotale"]["aprobacion_rechazo_sap"] = serialize($aprobacionRechazo);
				if ($this->ComprasProductosTotale->save($this->request->data)) 
				{

					CakeLog::write('actividad', 'Se rechazo el requerimiento de compra ID - ' . $this->data["id_rechazo"] . '(' .$this->Session->read('Users.nombre') .')');

					$this->loadModel("ComprasProductosRechazo");

					$this->request->data["ComprasProductosRechazo"]["compras_productos_totale_id"] = $this->data["id_rechazo"];
					$this->request->data["ComprasProductosRechazo"]["motivo"] =  $this->request->data["Compras"]["motivoRechazo"];
					$this->request->data["ComprasProductosRechazo"]["user_id"] = $this->Session->read("PerfilUsuario.idUsuario");

					$this->ComprasProductosRechazo->save($this->request->data["ComprasProductosRechazo"]);


					$this->loadModel("Email");

					$idUsuarioRequerimientoCompra = $this->ComprasProductosTotale->find("first", array(
						'conditions'=>array('ComprasProductosTotale.id'=>$this->data["id_rechazo"]),
						//'recursive'=>3
					));
				
					
					$emailSap = $this->Email->find("first", array(
						'conditions'=>array('Email.informe'=>"Ingreso-Sap"),
						'fields'=>"Email.email"
					));

					$emailSapLimpio = explode(".", $idUsuarioRequerimientoCompra["User"]["email"]);	
	
					$email[] = $emailSapLimpio[0].".cl";
					$email[] = $emailSap["Email"]["email"];


					if(!empty($idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"]))
					{
						$numeroRequerimiento = $idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"] . ' - ' .$idUsuarioRequerimientoCompra["ComprasFactura"][0]["numero_documento"];
						$plantilla = "orden_compra_aprobada";
						$nombreEmail = "SE RECHAZO UN DOCUMENTO TRIBUTARIO, INGRESO SAP";
					}
					else
					{
						$numeroRequerimiento = $idUsuarioRequerimientoCompra["ComprasProductosTotale"]["id"];
						$plantilla = "orden_compra_aprobada";
						$nombreEmail = "SE RECHAZO UN NUEVO REQUERIMIENTO DE COMPRA , INGRESO SAP";
					}

					//$emailCorto = explode(".", $idUsuarioRequerimientoCompra["User"]["email"]);

					$Email = new CakeEmail("gmail");
					$Email->from(array('sgi@cfd.cl' => 'SGI'));
					$Email->to($email);
					$Email->subject("Requerimiento de Compra de compra rechazada");
					$Email->emailFormat('html');
					$Email->template('rechazo_sap');

					$Email->viewVars(array(
						"nombreEmail"=>$nombreEmail,
						"numeroRequerimiento"=>$numeroRequerimiento,
						"usuario"=>$this->Session->read("Users.nombre"),
						"creador"=>$idUsuarioRequerimientoCompra["User"]["nombre"],
						"fechaCreacion"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["created"],//date("d/m/Y H:i"),
						"titulo"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["titulo"],
						"total"=>$idUsuarioRequerimientoCompra["ComprasProductosTotale"]["total"],
						"empresa"=>$idUsuarioRequerimientoCompra["Company"]["nombre"]
					));

					$Email->send();
					$this->Session->setFlash('Producto no aprobado ', 'msg_exito');
					return $this->redirect(array("action" => 'ingreso_sap'));
				}
				else
				{
					$this->Session->setFlash('Ocurrio un problema no se puede aprobar el producto', 'msg_fallo');
					return $this -> redirect(array("action" => 'ingreso_sap'));
				}
			}

		}
			
	}

	public function todos_sap()
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

		CakeLog::write('actividad', 'entro a  la pagina compras/todos_sap - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

		if ($this->request->is(array('post', 'put'))) 
		{

			$this->LoadModel("ComprasProductosTotale");

			if($this->request->data["TodosSap"]["fecha_desde"] && $this->request->data["TodosSap"]["fecha_hasta"])
			{
				$conditions = array('ComprasProductosTotale.created BETWEEN ? and ?'=> array($this->request->data["TodosSap"]["fecha_desde"], date('Y/m/d', strtotime('+1 day', strtotime ($this->request->data["TodosSap"]["fecha_hasta"])))));
			}
			else
			{
				$conditions =  array("OR"=>array(
					"ComprasProducto.descripcion LIKE"=>'%'. $this->request->data["TodosSap"]["palabraClave"] .'%',
					"ComprasProducto.dim_uno LIKE"=>'%'. $this->request->data["TodosSap"]["palabraClave"] .'%',
					"ComprasProducto.dim_dos LIKE"=>'%'. $this->request->data["TodosSap"]["palabraClave"] .'%',
					"ComprasProducto.dim_tres LIKE"=>'%'. $this->request->data["TodosSap"]["palabraClave"] .'%',
					"ComprasProducto.dim_cuatro LIKE"=>'%'. $this->request->data["TodosSap"]["palabraClave"] .'%',
					"ComprasProducto.dim_cinco LIKE"=>'%'. $this->request->data["TodosSap"]["palabraClave"] .'%',
					"ComprasProducto.proyecto LIKE"=>'%'. $this->request->data["TodosSap"]["palabraClave"] .'%',
					"ComprasProducto.codigos_presupuestarios LIKE"=>'%'. $this->request->data["TodosSap"]["palabraClave"] .'%', 
					"ComprasProductosTotale.titulo LIKE"=>'%'. $this->request->data["TodosSap"]["palabraClave"] .'%',
					"ComprasProductosTotale.observacion LIKE"=>'%'. $this->request->data["TodosSap"]["palabraClave"] .'%',
					//"ComprasProductosTotale.id" =>$this->request->data["TodosSap"]["palabraClave"],
					)
				);
			}


			$ordenCompra = $this->ComprasProductosTotale->ComprasProducto->find("all", array(
				'conditions'=>array($conditions),
				'recursive'=>2
			));
			//pr($ordenCompra);
			$this->loadModel("Company");
			$empresas = $this->Company->find("all", array("fields"=>"Company.alias, Company.id"));
			$nombreEmpresas = "";

			foreach($empresas as $empresa)
			{
				$nombreEmpresas[$empresa["Company"]["id"]] = $empresa["Company"]["alias"];
			}

			$filtroOrdenesDeCompra = "";

			foreach($ordenCompra as $key => $ordenCompras)
			{
				$filtroOrdenesDeCompra[$ordenCompras["ComprasProductosTotale"]["id"]] = array(
					"idOrdenCompra"=>$ordenCompras["ComprasProductosTotale"]["id"],
					"nombreEmpresa"=>$ordenCompras["ComprasProductosTotale"]["Company"]["nombre"],
					"titulo"=>$ordenCompras["ComprasProductosTotale"]["titulo"],
					"fecha"=>$ordenCompras["ComprasProductosTotale"]["created"],
					"titulo"=>$ordenCompras["ComprasProductosTotale"]["titulo"],
					"estado"=>$ordenCompras["ComprasProductosTotale"]["estado"],
					"total"=>$ordenCompras["ComprasProductosTotale"]["total"],
					"nombreDocumento"=>$ordenCompras["ComprasProductosTotale"]["TiposDocumento"],
					"numeroFactura"=>$ordenCompras["ComprasProductosTotale"]["ComprasFactura"]
				);
			}
			//pr($filtroOrdenesDeCompra);


			//$this->set("nombreEmpresas", $nombreEmpresas);
			//$this->set("ordenCompra", $ordenCompra);
			$this->set("filtroOrdenesDeCompra", $filtroOrdenesDeCompra);
		}
	}

	public function clonar($id)
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

		CakeLog::write('actividad', 'entro a  la pagina compras/clonar - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

		$this->loadModel("ComprasProductosTotale");

		if (!$this->ComprasProductosTotale->exists($id)) 
		{
			throw new NotFoundException(__('Invalid compras productos totale'));
		}
		//$this->layout ="angular";
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		
		if(!empty($id))
		{
			$comprasProductosTotale = $this->ComprasProductosTotale->find("first", array(
				'conditions'=>array("ComprasProductosTotale.id"=>$id)
			));

			$this->set("comprasProductosTotale", $comprasProductosTotale);
			$this->set("id", $id);
		}

		$vacio = array(""=>"");
		
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		
		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);
		
		$proveedores = $this->Company->find("list", array(
			"conditions"=>array("Company.company_type_id"=>2),
			"fields"=>array("Company.id", "Company.nombre")
		));
		
		if(!empty($proveedores))
		{
			//array_unshift($proveedores, $vacio);
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);
		}
		
		$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
		));
		
		if(!empty($tipoMonedas))
		{
			$tipoMonedas[0] = $vacio;
			$this->set("tipoMonedas", $tipoMonedas);
		}
		
		$plazosPagos = $this->PlazosPago->find("list", array(
			"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));
		
		if(!empty($plazosPagos))
		{
			$plazosPagos[0] = $vacio;
			$this->set("plazosPagos", $plazosPagos);
		}
		
		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));
		
		if(!empty($empaques))
		{
			$empaques[0] = $vacio;
			$this->set("empaques", $empaques);
		}
		
		$dimensiones = $this->Dimensione->find("all", array());
		
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["id"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			
			$dimensionUno[$tipoDimensione["Nombre"]] = $tipoDimensione["Nombre"];
		}
		array_unshift($dimensionUno, $vacio);
		
		$this->set("dimensionUno", $dimensionUno);
		
		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Nombre"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);
		
		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Nombre"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);
		
		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Nombre"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);
		
		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Nombre"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);
	}

	public function boletas_facturas_add()
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

		CakeLog::write('actividad', 'entro a  la pagina compras/boletas_facturas_add - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

		//$this->layout ="angular";
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("TiposDocumento");

		
		$vacio = array(""=>"");


		$tipoDocumentos = $this->TiposDocumento->find("list", array(
			"conditions"=>array("TiposDocumento.tipo"=>1),
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre"),
			'order'=>array("TiposDocumento.id ASC")
		));

		$this->set("tipoDocumentos", $tipoDocumentos);


		
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		
		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);
		
		$proveedores = $this->Company->find("list", array(
			//"conditions"=>array("Company.company_type_id"=>2),
			"fields"=>array("Company.id", "Company.nombre")
		));
		
		if(!empty($proveedores))
		{
			//array_unshift($proveedores, $vacio);
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);
		}
		
		$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
		));
		
		if(!empty($tipoMonedas))
		{
			//array_unshift($tipoMonedas, $vacio);
			$this->set("tipoMonedas", $tipoMonedas);
		}
		
		$plazosPagos = $this->PlazosPago->find("list", array(
			"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));
		
		if(!empty($plazosPagos))
		{
			array_unshift($plazosPagos, $vacio);
			$this->set("plazosPagos", $plazosPagos);
		}
		
		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));
		
		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}
		
		$dimensiones = $this->Dimensione->find("all", array());
		
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["id"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			
			$dimensionUno[$tipoDimensione["Nombre"]] = $tipoDimensione["Nombre"];
		}
		array_unshift($dimensionUno, $vacio);
		
		$this->set("dimensionUno", $dimensionUno);
		
		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Nombre"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);
		
		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Nombre"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);
		
		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Nombre"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);
		
		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Nombre"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);

	}


	public function plantilla_boletas_facturas_add($id)
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

		CakeLog::write('actividad', 'entro a  la pagina compras/plantilla_boletas_facturas_add - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

		$this->loadModel("TiposDocumento");
		$this->loadModel("ComprasProductosTotale");
		//$this->layout ="angular";
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		
		$tipoDocumentos = $this->TiposDocumento->find("list", array(
			"conditions"=>array("TiposDocumento.tipo"=>1),
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre")
		));

		$this->set("tipoDocumentos", $tipoDocumentos);
		if(!empty($id))
		{
			$comprasProductosTotale = $this->ComprasProductosTotale->find("first", array(
				'conditions'=>array("ComprasProductosTotale.id"=>$id)
			));

			$this->set("comprasProductosTotale", $comprasProductosTotale);
			$this->set("id", $id);
		}
		else
		{
			$this->Session->setFlash('No hay documentos tributarios cargados anteriormente', 'msg_fallo');
			return $this->redirect(array("action"=>'index'));
		}

		
		
		$vacio = array(""=>"");
		
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		
		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);
		
		$proveedores = $this->Company->find("list", array(
			"conditions"=>array("Company.company_type_id"=>2),
			"fields"=>array("Company.id", "Company.nombre")
		));
		
		if(!empty($proveedores))
		{
			//array_unshift($proveedores, $vacio);
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);
		}
		
		$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
		));
		
		if(!empty($tipoMonedas))
		{
			$tipoMonedas[] = $vacio;
			$this->set("tipoMonedas", $tipoMonedas);
		}
		
		$plazosPagos = $this->PlazosPago->find("list", array(
			"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));
		
		if(!empty($plazosPagos))
		{
			array_unshift($plazosPagos, $vacio);
			$this->set("plazosPagos", $plazosPagos);
		}
		
		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));
		
		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}
		
		$dimensiones = $this->Dimensione->find("all", array());
		
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["id"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			
			$dimensionUno[$tipoDimensione["Nombre"]] = $tipoDimensione["Nombre"];
		}
		array_unshift($dimensionUno, $vacio);
		
		$this->set("dimensionUno", $dimensionUno);
		
		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Nombre"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);
		
		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Nombre"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);
		
		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Nombre"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);
		
		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Nombre"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);
	}

	public function plantilla_boleta_facturas_add_documento($id)
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

		CakeLog::write('actividad', 'entro a  la pagina compras/plantilla_boletas_facturas_add - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

		$this->loadModel("TiposDocumento");
		$this->loadModel("ComprasProductosTotale");
		//$this->layout ="angular";
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		
		$tipoDocumentos = $this->TiposDocumento->find("list", array(
			"conditions"=>array("TiposDocumento.tipo"=>1),
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre")
		));

		$this->set("tipoDocumentos", $tipoDocumentos);
		if(!empty($id))
		{
			$comprasProductosTotale = $this->ComprasProductosTotale->find("first", array(
				'conditions'=>array("ComprasProductosTotale.id"=>$id)
			));

			$this->set("comprasProductosTotale", $comprasProductosTotale);
			$this->set("id", $id);
		}
		else
		{
			$this->Session->setFlash('No hay documentos tributarios cargados anteriormente', 'msg_fallo');
			return $this->redirect(array("action"=>'index'));
		}

		
		
		$vacio = array(""=>"");
		
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		
		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);
		
		$proveedores = $this->Company->find("list", array(
			//"conditions"=>array("Company.company_type_id"=>2),
			"fields"=>array("Company.id", "Company.nombre")
		));
		
		if(!empty($proveedores))
		{
			//array_unshift($proveedores, $vacio);
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);
		}
		
		$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
		));
		
		if(!empty($tipoMonedas))
		{
			$tipoMonedas[] = $vacio;
			$this->set("tipoMonedas", $tipoMonedas);
		}
		
		$plazosPagos = $this->PlazosPago->find("list", array(
			"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));
		
		if(!empty($plazosPagos))
		{
			array_unshift($plazosPagos, $vacio);
			$this->set("plazosPagos", $plazosPagos);
		}
		
		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));
		
		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}
		
		$dimensiones = $this->Dimensione->find("all", array());
		
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["id"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			
			$dimensionUno[$tipoDimensione["Nombre"]] = $tipoDimensione["Nombre"];
		}
		array_unshift($dimensionUno, $vacio);
		
		$this->set("dimensionUno", $dimensionUno);
		
		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Nombre"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);
		
		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Nombre"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);
		
		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Nombre"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);
		
		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Nombre"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);
	}


	public function asociar_facturas($id)
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

		CakeLog::write('actividad', 'entro a  la pagina compras/asociar facturas - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

		$this->loadModel("TiposDocumento");
		$this->loadModel("ComprasProductosTotale");
		//$this->layout ="angular";
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		
		$tipoDocumentos = $this->TiposDocumento->find("list", array(
			"conditions"=>array("TiposDocumento.tipo"=>1),
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre"),
			'order'=>"TiposDocumento.id ASC"
		));

		$this->set("tipoDocumentos", $tipoDocumentos);
		if(!empty($id))
		{
			$comprasProductosTotale = $this->ComprasProductosTotale->find("first", array(
				'conditions'=>array("ComprasProductosTotale.id"=>$id)
			));

			$this->set("comprasProductosTotale", $comprasProductosTotale);
			$this->set("id", $id);
		}
		else
		{
			$this->Session->setFlash('No hay documentos tributarios cargados anteriormente', 'msg_fallo');
			return $this->redirect(array("action"=>'index'));
		}

		
		
		$vacio = array(""=>"");
		
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		
		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);
		
		$proveedores = $this->Company->find("list", array(
			"conditions"=>array("Company.company_type_id"=>2),
			"fields"=>array("Company.id", "Company.nombre")
		));
		
		if(!empty($proveedores))
		{
			//array_unshift($proveedores, $vacio);
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);
		}
		
		$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
		));
		
		if(!empty($tipoMonedas))
		{
			$tipoMonedas[0] = $vacio;
			$this->set("tipoMonedas", $tipoMonedas);
		}
		
		$plazosPagos = $this->PlazosPago->find("list", array(
			"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));
		
		if(!empty($plazosPagos))
		{
			array_unshift($plazosPagos, $vacio);
			$this->set("plazosPagos", $plazosPagos);
		}
		
		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));
		
		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}
		
		$dimensiones = $this->Dimensione->find("all", array());
		
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["id"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			
			$dimensionUno[$tipoDimensione["Nombre"]] = $tipoDimensione["Nombre"];
		}
		array_unshift($dimensionUno, $vacio);
		
		$this->set("dimensionUno", $dimensionUno);
		
		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Nombre"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);
		
		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Nombre"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);
		
		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Nombre"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);
		
		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Nombre"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);
	}


	public function clonar_documento_tributario($id)
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

		CakeLog::write('actividad', 'entro a  la pagina compras/clonar_documento_tributario - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

		$this->loadModel("ComprasProductosTotale");

		if (!$this->ComprasProductosTotale->exists($id)) 
		{
			throw new NotFoundException(__('Invalid compras productos totale'));
		}
		$this->loadModel("TiposDocumento");
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");

		$tipoDocumentos = $this->TiposDocumento->find("list", array(
			"conditions"=>array("TiposDocumento.tipo"=>1),
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre")
		));

		$this->set("tipoDocumentos", $tipoDocumentos);

		if(!empty($id))
		{
			$comprasProductosTotale = $this->ComprasProductosTotale->find("first", array(
				'conditions'=>array("ComprasProductosTotale.id"=>$id)
			));

			$this->set("comprasProductosTotale", $comprasProductosTotale);
			$this->set("id", $id);
		}

		
		
		$vacio = array(""=>"");
		
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		
		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);
		
		$proveedores = $this->Company->find("list", array(
			//"conditions"=>array("Company.company_type_id"=>2),
			"fields"=>array("Company.id", "Company.nombre")
		));
		
		if(!empty($proveedores))
		{
			//array_unshift($proveedores, $vacio);
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);
		}
		
		$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
		));
		
		if(!empty($tipoMonedas))
		{
			$tipoMonedas[0] = $vacio;
			ksort($tipoMonedas);
			$this->set("tipoMonedas", $tipoMonedas);
		}
		
		$plazosPagos = $this->PlazosPago->find("list", array(
			"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));
		
		if(!empty($plazosPagos))
		{
			array_unshift($plazosPagos, $vacio);
			$this->set("plazosPagos", $plazosPagos);
		}
		
		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));
		
		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}
		
		$dimensiones = $this->Dimensione->find("all", array());
		
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["id"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			
			$dimensionUno[$tipoDimensione["Nombre"]] = $tipoDimensione["Nombre"];
		}
		array_unshift($dimensionUno, $vacio);
		
		$this->set("dimensionUno", $dimensionUno);
		
		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Nombre"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);
		
		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Nombre"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);
		
		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Nombre"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);
		
		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Nombre"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);
	}

	public function clonar_documento_tributario_edit($id) {

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

		CakeLog::write('actividad', 'entro a  la pagina compras/clonar_documento_tributario_edit - ' . $this->Session->Read("PerfilUsuario.idUsuario"));


		$this->loadModel("TiposDocumento");	
		
		$tipoDocumentos = $this->TiposDocumento->find("list", array(
			"conditions"=>array("TiposDocumento.tipo"=>1),
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre")
		));

		$this->set("tipoDocumentos", $tipoDocumentos);

	 	$this->loadModel("ComprasProductosTotale");

		if (!$this->ComprasProductosTotale->exists($id)) {
			throw new NotFoundException(__('Invalid compras productos totale'));
		}
		
		//$this->layout ="angular";

		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		
		if(!empty($id))
		{
			$comprasProductosTotale = $this->ComprasProductosTotale->find("first", array(
				'conditions'=>array("ComprasProductosTotale.id"=>$id)
			));
			
			$this->set("comprasProductosTotale", $comprasProductosTotale);
			$this->set("id", $id);
		}

		
		
		$vacio = array(""=>"");
		
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		
		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);
		
		$proveedores = $this->Company->find("list", array(
			"conditions"=>array("Company.company_type_id"=>2),
			"fields"=>array("Company.id", "Company.nombre")
		));
		
		if(!empty($proveedores))
		{
			//array_unshift($proveedores, $vacio);
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);
		}
		
		$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
		));
		
		if(!empty($tipoMonedas))
		{
			$tipoMonedas[0] = $vacio;
			ksort($tipoMonedas);
			$this->set("tipoMonedas", $tipoMonedas);
		}
		
		$plazosPagos = $this->PlazosPago->find("list", array(
			"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));
		
		if(!empty($plazosPagos))
		{
			array_unshift($plazosPagos, $vacio);
			$this->set("plazosPagos", $plazosPagos);
		}
		
		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));
		
		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}
		
		$dimensiones = $this->Dimensione->find("all", array());
		
		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["id"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{
			
			$dimensionUno[$tipoDimensione["Nombre"]] = $tipoDimensione["Nombre"];
		}
		array_unshift($dimensionUno, $vacio);
		
		$this->set("dimensionUno", $dimensionUno);
		
		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Nombre"]] = $tipoDimensioneDos["Nombre"];
		}
		array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);
		
		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Nombre"]] = $tipoDimensioneTres["Nombre"];
		}
		array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);
		
		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Nombre"]] = $tipoDimensioneCuatro["Nombre"];
		}
		array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);
		
		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Nombre"]] = $tipoDimensioneCinco["Nombre"];
		}
		array_unshift($dimensionCinco, $vacio);
		$this->set("dimensionCinco", $dimensionCinco);
	}
}
