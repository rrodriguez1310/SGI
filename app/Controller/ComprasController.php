<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('ServiciosController', 'Controller');

define("SAP", "http://192.168.1.24:50001/b1s/v1/");
define("SAP_ATTACH_DIR", "\\\\CDF-SQL01\\carpetas compartidas\\attachments");
define("SGI_ATTACH_DIR", "/mnt/attachments_sap");
define("USAP", "manager");
define("PSAP", "manager");
define("DBSAP", "SBO_CDF");

class ComprasController extends AppController
{
	public $components = array('RequestHandler');
	/**
	*
	* @author Cristian Quijada
	* muestra todos los requerimientos que ha creado el usuario
	*
	*/
	public function mis_compras_json()
	{
        Configure::write('debug', 0); 
		ini_set('max_execution_time', 300);
		$this->autoRender = false;
		$this->response->type("json");

		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("Company");
		$this->loadModel("ComprasEstado");
		$this->loadModel("TiposDocumento");
		$this->loadModel("ComprasFactura");


		$comprasTotal = $this->ComprasProductosTotale->find('all', array(
			'conditions'=>array( 'ComprasProductosTotale.user_id'=>$this->Session->read('PerfilUsuario.idUsuario'), 'ComprasProductosTotale.compras_estado_id !='=>0),
			'fields'=>array(
				'ComprasProductosTotale.id', 
				'ComprasProductosTotale.titulo',
				'ComprasProductosTotale.created',
				'ComprasProductosTotale.total',
				'ComprasProductosTotale.compras_estado_id',
				'ComprasProductosTotale.company_id',
				'ComprasProductosTotale.tipos_documento_id'
			),
			'recursive'=>-1
		));

		$idEmpresas = "";
		$idCompras = "";

		foreach($comprasTotal as $empresa){
			$idEmpresas[] = $empresa['ComprasProductosTotale']['company_id'];
			$idCompras[] = $empresa['ComprasProductosTotale']['id'];
		}

		$facturas = $this->ComprasFactura->find('all', array(
			'conditions'=>array('ComprasFactura.compras_productos_totale_id'=>$idCompras),
			'fields'=>array('ComprasFactura.numero_documento', 'ComprasFactura.compras_productos_totale_id'),
			'recrsive'=>-1

		));

		$numeroFacturas = "";

		foreach($facturas as $factura){
			$numeroFacturas[$factura['ComprasFactura']['compras_productos_totale_id']] = $factura['ComprasFactura']['numero_documento'];
		}

		$empresas = $this->Company->find('all', array(
			'conditions'=>array('Company.id'=>array_unique($idEmpresas)),
			'fields'=>array('Company.id', 'razon_social'),
			'recursive'=>-1
		));

		$nombreEmpresas = "";

		foreach($empresas as $empresa)
		{
			$nombreEmpresas[$empresa['Company']['id']] = $empresa['Company']['razon_social']; 
		}


		$estados = $this->ComprasEstado->find('all', array('recursive'=>-1));

		$estadoCompra = "";
		$estadoClase = "";
		foreach($estados as $estado){
			$estadoCompra[$estado['ComprasEstado']["id"]] = $estado['ComprasEstado']["estado"];
		}


		$nombreDocumento = $this->TiposDocumento->find('list', array(
			'fields'=>array('TiposDocumento.id', 'TiposDocumento.nombre')
		));

		$misCompras = "";

		foreach($comprasTotal as $compras){
			
			$documentoNombre = "";
			if(!empty($compras['ComprasProductosTotale']['tipos_documento_id']) || $compras['ComprasProductosTotale']['tipos_documento_id'] == 17 || $compras['ComprasProductosTotale']['tipos_documento_id'] == 18 || $compras['ComprasProductosTotale']['tipos_documento_id'] == 19 || $compras['ComprasProductosTotale']['tipos_documento_id'] == 20 || $compras['ComprasProductosTotale']['tipos_documento_id'] == 21 || $compras['ComprasProductosTotale']['tipos_documento_id'] == 22 || $compras['ComprasProductosTotale']['tipos_documento_id'] == 26 || $compras['ComprasProductosTotale']['tipos_documento_id'] == 27 ){
				$documentoNombre = $nombreDocumento[ $compras['ComprasProductosTotale']['tipos_documento_id'] ];
			}

			$misCompras[] = array(
				'codigo'=>(!empty($documentoNombre) ? $documentoNombre .' - '. $numeroFacturas[$compras['ComprasProductosTotale']['id']] : $compras['ComprasProductosTotale']['id'] ) ,
				'empresa'=>$nombreEmpresas[$compras['ComprasProductosTotale']['company_id']],
				'titulo'=>$compras['ComprasProductosTotale']['titulo'],
				'total'=>number_format($compras['ComprasProductosTotale']['total'], 0, '', '.'),
				'estado'=>$estadoCompra[$compras['ComprasProductosTotale']['compras_estado_id']],
				'estadoId'=>$compras['ComprasProductosTotale']['compras_estado_id'],
				'fecha'=> date('Y-m-d', strtotime($compras['ComprasProductosTotale']['created'])),
				'id' => $compras['ComprasProductosTotale']['id']
				
			);
		}

		return  json_encode($misCompras);
	}

	public function multi_impuesto()
	{
		ini_set('max_execution_time', 300);
		$this->layout = "angular";
	}


	public function index(){
		//Configure::write('debug', 1); 
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
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'miro la pagina compras/index - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
	}
	/*
	public function index($empresaSeleccionada = null)
	{
		//Configure::write('debug', 1);
		//ini_set("max_execution_time", "0")
		ini_set('memory_limit', '512M');
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

		//echo "<br/><br/><br/><br/><br/>";
		//pr($this->Session->Read("PerfilUsuario.idUsuario"));

		if($this->Session->Read("PerfilUsuario.idUsuario") != null) //  && $this->Session->Read("PerfilUsuario.roleId") != 2
		{
			$this->loadModel("ComprasProductosTotale");

			if(!empty($empresaSeleccionada))
			{
				$ordenCompra = $this->ComprasProductosTotale->find("all", array(
					'conditions'=>array(
						"ComprasProductosTotale.id"=>explode('-', $empresaSeleccionada),
						"ComprasProductosTotale.user_id"=>$this->Session->Read("PerfilUsuario.idUsuario"),
						"ComprasProductosTotale.compras_estado_id != "=> 0,
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
						"ComprasProductosTotale.compras_estado_id != "=> 0,
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


			$this->set("empresaSeleccionada", "");

			$this->set("ordenCompra", $ordenCompra);
			CakeLog::write('actividad', 'miro la pagina compras/index - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
		}

	}
	*/

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
			"fields"=>array("Company.id", "Company.razon_social")
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
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("ComprasSapEnvio");
		
		$dimensionesProyectos = $this->DimensionesProyecto->find("list", array("fields"=>array("nombre", "codigo")));		

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
		{
			CakeLog::write('actividad', 'miro la pagina compras/view - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

			$this->loadModel("ComprasProductosTotale");

			if (!$this->ComprasProductosTotale->exists($id)) {
				$this->Session->setFlash('El requerimiento de compras no existe', 'msg_fallo');
				return $this->redirect(array("action"=>'index'));
			}


			$options = array('conditions' => array(
				'ComprasProductosTotale.' . $this->ComprasProductosTotale->primaryKey => $id)
			);

			$ordenCompras = $this->ComprasProductosTotale->find('first', $options);
			////// prueba //////
			if($perfilUsuario == "aprobadores")
			{
				$emailCorto = explode(".", $this->Session->Read("Users.email"));
				$emailAprobador = $emailCorto[0] .".cl";

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

				foreach($codigosCortos as $codigosCorto)
				{
					if($codigosCorto[0] == "Aprobador")
					{
						$codigos[$codigosCorto[1]] = $codigosCorto[1];
					}
				}

				$this->set("codigosCortos", $codigos);
			}

			/////////  Fin Pruebas //////////

			$idOrdencompra = "";			
			foreach($ordenCompras["ComprasProducto"] as $key => $ordenCompra)
			{	
				if($ordenCompra["estado"] == 3 || $ordenCompra["estado"] == 5)
				{
					$idOrdencompra[] = $ordenCompra["id"];
				}
				$ordenCompras["ComprasProducto"][$key]["proyecto_codigo"] = isset($dimensionesProyectos[$ordenCompras["ComprasProducto"][$key]["proyecto"]]) ? $dimensionesProyectos[$ordenCompras["ComprasProducto"][$key]["proyecto"]] : "";
			}

			if($idOrdencompra != "")
			{
				$this->loadModel("ComprasProductosRechazo");
				$rechazos = $this->ComprasProductosRechazo->find("all", array(
					"conditions"=>array("ComprasProductosRechazo.compras_producto_id"=>$idOrdencompra),
					"recursive"=>1
				));
			}

			$motivoRechazos = "";
			if(isset($rechazos))
			{
				foreach($rechazos as $rechazo)
				{
					$motivoRechazos[$rechazo["User"]["id"]] = array(
						"Usuario" => $rechazo["User"]["nombre"],
						"Motivo"=>$rechazo["ComprasProductosRechazo"]["motivo"],
						"Producto"=>$rechazo["ComprasProducto"]["descripcion"],
						"Fecha"=>$rechazo["ComprasProducto"]["created"]
					);
				}
			}
			
			// SAP 			
			$envioSap = $this->ComprasSapEnvio->find("first", array(
					'conditions' => array(
						"ComprasSapEnvio.compras_productos_totale_id" => $ordenCompras["ComprasProductosTotale"]["id"],
						"ComprasSapEnvio.sap_doc_entry_id !=" => null,
					),
					'fields'=>array("ComprasSapEnvio.compras_productos_totale_id", "ComprasSapEnvio.sap_doc_entry_id")
				));			
			
			$rutLimpio = str_replace("-","", str_replace(".", "", $ordenCompras["Company"]["rut"]));
			$socios = $this->obtSocioDeNegocio($rutLimpio);				
			$empresas = array();
			foreach ($socios as $socio) {				
				$empresas[$socio["CardCode"]] = $socio["CardCode"] .  ' - ' . $socio["CardName"];
			}

			$indicadores = $this->obtFinanzasIndicadores();			
			$indicadoresArr = array();
			foreach ($indicadores as $indicador) {				
				$indicadoresArr[] = array( "id" => $indicador["IndicatorCode"], 
					"name" => $indicador["IndicatorName"]);
			}

			$articulos = $this->obtArticulos();
			$articulosArr = array();
			foreach ($articulos as $articulo) {
				$articulosArr[] = array( "id" => $articulo["ItemCode"],
					"name"=> $articulo["ItemCode"] .  ' - ' . $articulo["ItemName"]);
			}

			$cuentas = $this->obtCuentasContables();
			$cuentasArr = array();
			foreach ($cuentas as $cuenta) {
				$cuentasArr[] = array( "id" => $cuenta["Code"],
					"name"=> $cuenta["Code"] .  ' - ' . $cuenta["Name"]);
			}			

			$sap = array(
				"SociosDeNegocio" => $empresas,
				"articulos" => $articulosArr,
				"cuentas" => $cuentasArr,
				"indicadores" => $indicadoresArr,
				"sap_doc_entry_id" => isset($envioSap["ComprasSapEnvio"]["sap_doc_entry_id"]) ? $envioSap["ComprasSapEnvio"]["sap_doc_entry_id"] : null
			);			

			$this->set('motivoRechazos', $motivoRechazos);
			$this->set('ordenCompra', $ordenCompras);

			$this->set('sap', $sap);

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

		$this->set("id", $id);
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

			//$this->request->allowMethod('post', 'delete');

			$this->request->data["ComprasProductosTotale"]["id"] = $id;
			$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 0;

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

		exit;
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
			"fields"=>array("Company.id", "Company.razon_social")
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

/*
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

				$this->loadModel("ComprasProducto");

				if(!empty($codigos))
				{
					foreach ($codigos as $codigo) {
    					$conditions['OR'][] = array(
    						'ComprasProducto.codigos_presupuestarios LIKE' => $codigo."%",
    					);
					}


					$productos = $this->ComprasProducto->find("all", array(
						"conditions"=>array(
							$conditions,
							'ComprasProducto.estado'=>1,
						)
					));

					$this->set("ordenCompra", $ordenCompra);
				}

				$comprasTotales = "";
				if(!empty($ordenCompra))
				{
					foreach($ordenCompra as $ordenCompras)
					{

						//pr($ordenCompras);

						$numeroFactura = "";
						$nombreDocumentos = "";
						//pr($ordenCompras["ComprasProductosTotale"]["ComprasFactura"][0]["numero_documento"]);
						if($ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 0)
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
								"Estado"=> $ordenCompras["ComprasProductosTotale"]["compras_estado_id"],
								"Rechazo"=>$ordenCompras["ComprasProductosTotale"]["ComprasEstado"]["estado"],
								"Clase"=>$ordenCompras["ComprasProductosTotale"]["ComprasEstado"]["clase"],
								"docTributario"=>$nombreDocumentos,
								"numeroFactura"=> $numeroFactura,
	 						);

						}
					}
				}

				$this->set("comprasTotales", $comprasTotales);

			}
		}
	}
*/
	/*
	public function aprobadores()
	{
		Configure::write('debug', 1);
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
    					$conditions['OR'][] = array(
    						'ComprasProducto.codigos_presupuestarios LIKE' => $codigo."%", 
    					);
					}	
				}

				if(!empty($conditions))
				{
					$this->loadModel("ComprasProducto");

					$ordenCompra = $this->ComprasProducto->find("all", array(
						"conditions"=>array(
							$conditions, 
							'ComprasProducto.estado'=>1,
						),
						'order'=>array('ComprasProducto.id ASC'),
						'recursive'=>1
					));

					$this->set("ordenCompra", $ordenCompra);
				}

				$comprasTotales = "";

				//pr($ordenCompra);

				if(!empty($ordenCompra))
				{

					$this->loadModel("Company");

					$this->loadModel("ComprasEstado");


					$empresasId = "";
					$comprasId = "";
					foreach($ordenCompra as $idEmpresas)
					{
						$empresasId[] = $idEmpresas["ComprasProductosTotale"]["company_id"];
						$comprasId[] = $idEmpresas["ComprasProductosTotale"]["id"]; 
					}

					$this->loadModel("ComprasFactura");

					$facturas = $this->ComprasFactura->find('all', array(
						'conditions'=>array('ComprasFactura.compras_productos_totale_id'=>$comprasId),
						'fields'=>array(
							'ComprasFactura.id',
							'ComprasFactura.compras_productos_totale_id',
							'ComprasFactura.numero_documento'
						),
						'recursive'=>-1
					))

					$idFacturaCompra = "";
					foreach($facturas as $factura){
						$idFacturaCompra[$factura['ComprasFactura']['compras_productos_totale_id']] = $factura['ComprasFactura']['numero_documento'];	
					}

					$comprasEstadoId = "";
					foreach($ordenCompra as $idComprasEstado)
					{
						$comprasEstadoId[] = $idEmpresas["ComprasProducto"]["estado"];
					}

					//pr($comprasEstadoId);

					$empresas = $this->Company->find("all", array(
						'conditions'=>array("Company.id"=>$empresasId),
						'fields'=>array("Company.nombre", "Company.id")
					));

					$estados = $this->ComprasEstado->find("all", array(
						'conditions'=>array("ComprasEstado.id"=>$comprasEstadoId),
						'fields'=>array("ComprasEstado.estado", "ComprasEstado.id", "ComprasEstado.clase")
					));


					$nombreEstados = "";
					$nombreClase = "";

					foreach($estados as $nombre)
					{
						$nombreEstados[$nombre["ComprasEstado"]["id"]] = $nombre["ComprasEstado"]["estado"];
						$nombreClase[$nombre["ComprasEstado"]["id"]] = $nombre["ComprasEstado"]["clase"];
					}

					$nombreEmpresas = "";

					foreach($empresas as $nombre)
					{
						$nombreEmpresas[$nombre["Company"]["id"]] = $nombre["Company"]["nombre"];
					}

					foreach($ordenCompra as $ordenCompras)
					{

						$numeroFactura = "";
						$nombreDocumentos = "";

						if($ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 0)
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
								"Empresa"=> $nombreEmpresas[$ordenCompras["ComprasProductosTotale"]["company_id"]],
								"Titulo"=> $ordenCompras["ComprasProductosTotale"]["titulo"],
								"Fecha"=> $ordenCompras["ComprasProductosTotale"]["created"],
								"Total"=> $ordenCompras["ComprasProductosTotale"]["total"],
								"Estado"=> $ordenCompras["ComprasProductosTotale"]["compras_estado_id"],
								"Rechazo"=>$nombreEstados[$ordenCompras["ComprasProducto"]["estado"]],
								"Clase"=>$nombreClase[$ordenCompras["ComprasProducto"]["estado"]],
								"docTributario"=>$nombreDocumentos,
								"numeroFactura"=> $numeroFactura,
								"claseFac" =>(isset($idFacturaCompra[$ordenCompras["ComprasProductosTotale"]["id"]]) ? 'warning' :  ""),
								"numFac"=>(isset($idFacturaCompra[$ordenCompras["ComprasProductosTotale"]["id"]]) ? 'Doc. '.$idFacturaCompra[$ordenCompras["ComprasProductosTotale"]["id"]] :  "")
	 						);

						}
					}
				}


				$this->set("comprasTotales", $comprasTotales);
			}
		}
	}
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
    					$conditions['OR'][] = array(
    						'ComprasProducto.codigos_presupuestarios LIKE' => $codigo."%",
    					);
					}
				}

				if(!empty($conditions))
				{

					$this->loadModel("ComprasProducto");

					$ordenCompra = $this->ComprasProducto->find("all", array(
						"conditions"=>array(
							$conditions,
							'ComprasProducto.estado'=>1
						),
						'order'=>array('ComprasProducto.id ASC'),
						'recursive'=>1
					));

					$this->set("ordenCompra", $ordenCompra);
				}

				$comprasTotales = "";

				//pr($ordenCompra);

				if(!empty($ordenCompra))
				{
					
					$this->loadModel("Company");

					$this->loadModel("ComprasEstado");


					$empresasId = "";
					$comprasId = "";
					foreach($ordenCompra as $idEmpresas)
					{
						$empresasId[] = $idEmpresas["ComprasProductosTotale"]["company_id"];
						$comprasId[] = $idEmpresas["ComprasProductosTotale"]["id"]; 
					}

					$this->loadModel("ComprasFactura");

					$facturas = $this->ComprasFactura->find('all', array(
						'conditions'=>array('ComprasFactura.compras_productos_totale_id'=>$comprasId),
						'fields'=>array(
							'ComprasFactura.id',
							'ComprasFactura.compras_productos_totale_id',
							'ComprasFactura.numero_documento'
						),
						'recursive'=>-1
					));


					$idFacturaCompra = "";
					foreach($facturas as $factura){
						$idFacturaCompra[$factura['ComprasFactura']['compras_productos_totale_id']] = $factura['ComprasFactura']['numero_documento'];	
					}


					$comprasEstadoId = "";
					foreach($ordenCompra as $idComprasEstado)
					{
						$comprasEstadoId[] = $idEmpresas["ComprasProducto"]["estado"];
					}

					//pr($comprasEstadoId);

					$empresas = $this->Company->find("all", array(
						'conditions'=>array("Company.id"=>$empresasId),
						'fields'=>array("Company.nombre", "Company.id")
					));

					$estados = $this->ComprasEstado->find("all", array(
						'conditions'=>array("ComprasEstado.id"=>$comprasEstadoId),
						'fields'=>array("ComprasEstado.estado", "ComprasEstado.id", "ComprasEstado.clase")
					));


					$nombreEstados = "";
					$nombreClase = "";

					foreach($estados as $nombre)
					{
						$nombreEstados[$nombre["ComprasEstado"]["id"]] = $nombre["ComprasEstado"]["estado"];
						$nombreClase[$nombre["ComprasEstado"]["id"]] = $nombre["ComprasEstado"]["clase"];
					}

					$nombreEmpresas = "";

					foreach($empresas as $nombre)
					{
						$nombreEmpresas[$nombre["Company"]["id"]] = $nombre["Company"]["nombre"];
					}

					foreach($ordenCompra as $ordenCompras)
					{

						$numeroFactura = "";
						$nombreDocumentos = "";

						if($ordenCompras["ComprasProductosTotale"]["compras_estado_id"] != 0)
						{
							$comprasTotales[$ordenCompras["ComprasProductosTotale"]["id"]] = array(
								"IdRequerimiento" =>$ordenCompras["ComprasProductosTotale"]["id"],
								"Empresa"=> $nombreEmpresas[$ordenCompras["ComprasProductosTotale"]["company_id"]],
								"Titulo"=> $ordenCompras["ComprasProductosTotale"]["titulo"],
								"Fecha"=> $ordenCompras["ComprasProductosTotale"]["created"],
								"Total"=> $ordenCompras["ComprasProductosTotale"]["total"],
								"Estado"=> $ordenCompras["ComprasProductosTotale"]["compras_estado_id"],
								"Rechazo"=>$nombreEstados[$ordenCompras["ComprasProducto"]["estado"]],
								"Clase"=>$nombreClase[$ordenCompras["ComprasProducto"]["estado"]],
								"claseFac" =>(isset($idFacturaCompra[$ordenCompras["ComprasProductosTotale"]["id"]]) ? 'success' :  ""),
								"numFac"=>(isset($idFacturaCompra[$ordenCompras["ComprasProductosTotale"]["id"]]) ? 'Doc. '.$idFacturaCompra[$ordenCompras["ComprasProductosTotale"]["id"]] :  "")
	 						);

							// pr($comprasTotales);

						}
					}
				}


				$this->set("comprasTotales", $comprasTotales);
			}
		}
	}

	public function aprobar_compra()
	{

		$this->layout = null;

		$this->loadModel("ComprasProducto");
		$this->loadModel("ComprasProductosTotale");

		$id = $this->request->data["idRequerimiento"];



		if (!$this->ComprasProductosTotale->exists($id))
		{
			$this->Session->setFlash('El Producto no existe', 'msg_fallo');
			return $this->redirect(array('action' => 'aprobadores'));
		}


		if (!empty($id))
		{
			$estadoCompleto = "";

			if(isset($this->request->data["productos"]))
			{

				$idProductos = $this->ComprasProducto->find("all", array(
					'conditions'=>array("ComprasProducto.compras_productos_totale_id"=>$id),
					'fields'=>array("ComprasProducto.id", "ComprasProducto.estado")
				));


				//pr($idProductos);


				$productosId = "";
				foreach($this->request->data["productos"] as $idProducto)
				{
					$productosId[] = array(
							"id"=>$idProducto,
							"estado"=>2
					);
				}
				//pr($idProductos);exit;

				if(!empty($productosId) && !empty($this->request->data["productos"]))
				{
					if(count($idProductos) == count($this->request->data["productos"]))
					{
						$estadoCompleto = 2;
					}
					else
					{
						$estadoCompleto = 1;
					}
				}
				else
				{
					$this->Session->setFlash('Seleccione almenos un producto para aprobar', 'msg_fallo');
					return $this->redirect(array('action' => 'aprobadores'));
				}

			}
			else
			{
				$this->Session->setFlash('Seleccione almenos un producto para aprobar', 'msg_fallo');
				return $this->redirect(array('action' => 'aprobadores'));
			}


			$aprobacionRechazo[] = array(
				"Id"=>$id,
				"UsuarioAprobador"=>$this->Session->Read("Users.nombre"),
				"FechaAprobacion"=>date("m-d-Y H:i")
			);

			$this->request->data["ComprasProductosTotale"]["id"] = $id;
			$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = $estadoCompleto;
			$this->request->data["ComprasProductosTotale"]["aprobacion_rechazo"] = serialize($aprobacionRechazo);


			//pr($estadoCompleto);exit;


			$estadoProductos = "";

			if ($this->ComprasProductosTotale->save($this->request->data))
			{
				if($this->ComprasProducto->saveAll($productosId))
				{
					$estadosProductos = $this->ComprasProducto->find("all", array(
						'conditions'=>array(
							"ComprasProducto.compras_productos_totale_id"=>$id,
							"ComprasProducto.estado"=>2,
						),
						'fields'=>array("ComprasProducto.estado")
					));

					if(count($estadosProductos) == count($idProductos))
					{
						$this->request->data["ComprasProductosTotale"]["id"] = $id;
						$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 2;
						$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);
					}
					else
					{
						$estadosProductosCompletos = $this->ComprasProducto->find("all", array(
							'conditions'=>array(
								"ComprasProducto.compras_productos_totale_id"=>$id,
							),
							'fields'=>array("ComprasProducto.estado")
						));
					}

					if(isset($estadosProductosCompletos))
					{
						$estado = "";
						foreach($estadosProductosCompletos as $estadoProductos)
						{
							$estado[] = $estadoProductos["ComprasProducto"]["estado"];
						}


						if(in_array(1, $estado))
						{
						    $estadoRechazado = 1;
						}
						else if(in_array(2, $estado))
						{
							$estadoRechazado = 7;
						}
						else
						{
							$estadoRechazado = 3;
						}

						$this->request->data["ComprasProductosTotale"]["id"] = $this->ComprasProductosTotale->id;
						$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = $estadoRechazado;
						$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);

					}
				}

				CakeLog::write('actividad', 'Se aprobo el requerimiento de compra ID - ' . $id . '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');

				$this->loadModel("Email");

				$idUsuarioRequerimientoCompra = $this->ComprasProductosTotale->find("first", array(
					'conditions'=>array('ComprasProductosTotale.id'=>$id),

				));

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
				$Email->from(array('sgi@cdf.cl' => 'SGI'));
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

		$this->layout = null;

		$estadoRechazado = "";

		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("ComprasProducto");

		if(!empty($this->data))
		{
			if (!$this->ComprasProductosTotale->exists($this->data["id_rechazo"]))
			{
				$this->Session->setFlash('El Producto no existe', 'msg_fallo');
				return $this->redirect(array('action' => 'aprobadores'));
			}

			if($this->data["id_rechazo"])
			{
				$idproductosRerchazados = explode(",", $this->request->data["productosRechazados"]);

				$idProductos = $this->ComprasProducto->find("all", array(
					'conditions'=>array("ComprasProducto.compras_productos_totale_id"=>$this->request->data["id_rechazo"]),
					'fields'=>array("ComprasProducto.id", "ComprasProducto.estado")
				));

					$productosIdRechazados = "";

					foreach($idproductosRerchazados as $idProducto)
					{
						$productosIdRechazados[] = array(
								"id"=>$idProducto,
								"estado"=>3,
						);
					}

				if($this->ComprasProducto->saveAll($productosIdRechazados))
				{
					$idProductos = $this->ComprasProducto->find("all", array(
						'conditions'=>array("ComprasProducto.compras_productos_totale_id"=>$this->request->data["id_rechazo"]),
						'fields'=>array("ComprasProducto.id", "ComprasProducto.estado", "ComprasProducto.subtotal")
					));

					$estadoTotalRechazo = "";

					if(!empty($productosIdRechazados) && !empty($idproductosRerchazados))
					{
						$productos = "";
						$productosRechazados = "";
						$otrosProductos = "";


						//pr($idProductos);exit;
						foreach($idProductos as $estadoPrtoductos)
						{
							$productos[] = $estadoPrtoductos["ComprasProducto"]["estado"];
							if($estadoPrtoductos["ComprasProducto"]["estado"] == 3)
							{
								$productosRechazados[] = $estadoPrtoductos["ComprasProducto"]["subtotal"];
							}
							else
							{
								$otrosProductos[] = $estadoPrtoductos["ComprasProducto"]["subtotal"];
							}
						}
					}
					else
					{
						$this->Session->setFlash('Seleccione almenos un producto para aprobar', 'msg_fallo');
						return $this->redirect(array('action' => 'aprobadores'));
					}

					if(in_array(1, $productos))
					{
					    $estadoRechazado = 1;
					}

					else if(in_array(2, $productos))
					{
						$estadoRechazado = 7;
					}
					else
					{
						$estadoRechazado = 3;
					}

					$aprobacionRechazo[] = array(
						"Id"=>$this->data["id_rechazo"],
						"UsuarioAprobador"=>$this->Session->Read("Users.nombre"),
						"FechaAprobacion"=>date("m-d-Y H:i")
					);

					if(!empty($productosRechazados))
					{
						$totalCompra = $this->ComprasProductosTotale->find("first", array(
							"conditions"=>array("ComprasProductosTotale.id"=>$this->data["id_rechazo"]),
							"fields"=>array("neto_descuento", "total", "descuento_total"),
							"recursive"=>0
						));
					}

					if(count($idProductos) == count($idproductosRerchazados))
					{
						$estadoTotalRechazo = 3;
						$this->request->data["ComprasProductosTotale"]["descuento_total"] = 0;
						$this->request->data["ComprasProductosTotale"]["total"] = 0;
						$this->request->data["ComprasProductosTotale"]["neto_descuento"] = 0;
					}
					else
					{

						if(!empty($totalCompra["ComprasProductosTotale"]["neto_descuento"]) && !empty($productosRechazados))
						{
							$this->request->data["ComprasProductosTotale"]["sub_total"] = array_sum($otrosProductos); //$totalCompra["ComprasProductosTotale"]["neto_descuento"] - array_sum($productosRechazados);
							$iva = $this->request->data["ComprasProductosTotale"]["sub_total"] * 0.19;
							$this->request->data["ComprasProductosTotale"]["total"] =  $this->request->data["ComprasProductosTotale"]["sub_total"] + $iva;
	 						$this->request->data["ComprasProductosTotale"]["neto_descuento"] = $this->request->data["ComprasProductosTotale"]["sub_total"];

	 						if(!empty($totalCompra["ComprasProductosTotale"]["descuento_total"]))
	 						{
	 							$descuentoPocentaje = $totalCompra["ComprasProductosTotale"]["descuento_total"] * 100 / $this->request->data["ComprasProductosTotale"]["sub_total"];
	 							$descuentoPeso = $descuentoPocentaje * $this->request->data["ComprasProductosTotale"]["sub_total"] / 100;

	 							if($descuentoPeso)
	 							{
	 								$this->request->data["ComprasProductosTotale"]["neto_descuento"] = array_sum($otrosProductos) - $descuentoPeso;
	 								$iva = $this->request->data["ComprasProductosTotale"]["neto_descuento"] * 0.19;
	 								$this->request->data["ComprasProductosTotale"]["total"] =  $this->request->data["ComprasProductosTotale"]["neto_descuento"] + $iva;
	 							}
	 						}
	 					}
					}


					//pr($estadoRechazado);exit;


					$this->request->data["ComprasProductosTotale"]["id"] = $this->data["id_rechazo"];
					$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = $estadoRechazado;
					$this->request->data["ComprasProductosTotale"]["aprobacion_rechazo"] = serialize($aprobacionRechazo);

					if ($this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]))
					{
						CakeLog::write('actividad', 'Se rechazo el requerimiento de compra ID - ' . $this->data["id_rechazo"] . '(' .$this->Session->read('Users.nombre') .')');

						$this->loadModel("ComprasProductosRechazo");

						//$this->request->data["ComprasProductosRechazo"]["compras_productos_totale_id"] = $this->data["id_rechazo"];
						//$this->request->data["ComprasProductosRechazo"]["motivo"] =  $this->request->data["Compras"]["motivoRechazo"];
						//$this->request->data["ComprasProductosRechazo"]["user_id"] = $this->Session->read("PerfilUsuario.idUsuario");
						$rechasos = "";
						foreach($productosIdRechazados as $idProductos)
						{
							$rechasos[] = array(
								"compras_producto_id"=>$idProductos["id"],
								"motivo"=>$this->request->data["Compras"]["motivoRechazo"],
								"user_id"=>$this->Session->read("PerfilUsuario.idUsuario")
							);
						}

						if(!empty($rechasos))
						{
							$this->ComprasProductosRechazo->saveAll($rechasos);
						}

						//$this->ComprasProductosRechazo->save($this->request->data["ComprasProductosRechazo"]);


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
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to(array_filter($email));
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
						"empresa"=>$idUsuarioRequerimientoCompra["Company"]["nombre"],
						"motivoRechazo"=>$this->request->data["Compras"]["motivoRechazo"]
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
					"ComprasProductosTotale.compras_estado_id"=>array(2,7),
					"ComprasProductosTotale.compras_estado_id != "=> 0
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

			/*
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
			*/
			$this->set("ordenCompra", $ordenCompra);
		}
	}

	public function aprobar_compra_sap()
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

		$this->layout = null;

		$this->loadModel("ComprasProducto");
		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("ComprasSapEnvio");
					

		$id = $this->request->data["idRequerimiento"];

		if (!$this->ComprasProductosTotale->exists($id))
		{
			$this->Session->setFlash('El Producto no existe', 'msg_fallo');
			return $this->redirect(array('action' => 'ingreso_sap'));
		}

		if (!empty($id))
		{
			$estadoCompleto = "";

			if(isset($this->request->data["productos"]))
			{

				$idProductos = $this->ComprasProducto->find("all", array(
					'conditions'=>array("ComprasProducto.compras_productos_totale_id"=>$id),
					'fields'=>array("ComprasProducto.id", "ComprasProducto.estado")
				));

				$productosId = "";
				foreach($this->request->data["productos"] as $idProducto)
				{
					$productosId[] = array(
							"id"=>$idProducto,
							"estado"=>4,
							"sap_item_code_id" => isset($this->request->data["Sap"]["DocumentLines"]["dDocument_Items"][$idProducto]["ItemCode"])? $this->request->data["Sap"]["DocumentLines"]["dDocument_Items"][$idProducto]["ItemCode"]: null
					);
				}
				

				if(!empty($productosId) && !empty($this->request->data["productos"]))
				{
					if(count($idProductos) == count($this->request->data["productos"]))
					{
						$estadoCompleto = 4;
					}
					else
					{
						$estadoCompleto = 2;
					}
				}
				else
				{
					$this->Session->setFlash('Seleccione almenos un producto para aprobar', 'msg_fallo');
					return $this->redirect(array('action' => 'ingreso_sap'));
				}

			}
			else
			{
				$this->Session->setFlash('Seleccione almenos un producto para aprobar', 'msg_fallo');
				return $this->redirect(array('action' => 'ingreso_sap'));
			}


			$aprobacionRechazo[] = array(
				"Id"=>$id,
				"UsuarioAprobador"=>$this->Session->Read("Users.nombre"),
				"FechaAprobacion"=>date("m-d-Y H:i")
			);

			$this->request->data["ComprasProductosTotale"]["id"] = $id;
			$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = $estadoCompleto;
			$this->request->data["ComprasProductosTotale"]["aprobacion_rechazo_sap"] = serialize($aprobacionRechazo);
			$this->request->data["ComprasProductosTotale"]["numero_sap"] = isset($this->request->data["codigo"]) ? $this->request->data["codigo"] : "";

			$this->request->data["ComprasProductosTotale"]["sap_doc_type_id"] = isset($this->request->data["Sap"]["DocType"])?	$this->request->data["Sap"]["DocType"]:null;
			$this->request->data["ComprasProductosTotale"]["sap_indicator_id"]= isset($this->request->data["Sap"]["Indicator"])?$this->request->data["Sap"]["Indicator"]:null;
			$this->request->data["ComprasProductosTotale"]["sap_card_code_id"]= isset($this->request->data["Sap"]["CardCode"])?	$this->request->data["Sap"]["CardCode"]:null;

			$estadoProductos = "";			

			if ($this->ComprasProductosTotale->save($this->request->data))
			{			
				unset($this->request->data["Sap"]);

				if(isset($respuestaSap["error"])) {
					CakeLog::write('actividad', 'Registró un error el ingreso en SAP compra ID - ' . $id . '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
				}

				if($this->ComprasProducto->saveAll($productosId))
				{
					$estadosProductos = $this->ComprasProducto->find("all", array(
						'conditions'=>array(
							"ComprasProducto.compras_productos_totale_id"=>$id,
							"ComprasProducto.estado"=>4,
						),
						'fields'=>array("ComprasProducto.estado")
					));					

					if(count($estadosProductos) == count($idProductos))
					{
						$this->request->data["ComprasProductosTotale"]["id"] = $id;
						$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 4;
						$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);
						$this->request->data["ComprasProductosTotale"]["numero_sap"] = isset($this->request->data["codigo"]) ? $this->request->data["codigo"] : "";
						//$this->request->data["ComprasProductosTotale"]["numero_sap"] = isset($respuestaSap["DocNum"]) ? $respuestaSap["DocNum"] : "";
					}
					else
					{
						$estadosProductosCompletos = $this->ComprasProducto->find("all", array(
							'conditions'=>array(
								"ComprasProducto.compras_productos_totale_id"=>$id,
							),
							'fields'=>array("ComprasProducto.estado")
						));
					}

					if(isset($estadosProductosCompletos))
					{
						$estado = "";
						foreach($estadosProductosCompletos as $estadoProductos)
						{
							$estado[] = $estadoProductos["ComprasProducto"]["estado"];
						}


						if(in_array(2, $estado))
						{
						    $estadoRechazado = 2;
						}
						else if(in_array(4, $estado))
						{
							$estadoRechazado = 8;
						}
						else
						{
							$estadoRechazado = 5;
						}

						$this->request->data["ComprasProductosTotale"]["compras_estado_id"];
						$this->request->data["ComprasProductosTotale"]["id"] = $this->ComprasProductosTotale->id;
						$this->request->data["ComprasProductosTotale"]["numero_sap"] = $this->request->data["codigo"];
						$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);

					}
				}			

				CakeLog::write('actividad', 'Se aprobo el requerimiento de compra ID - ' . $id . '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');

				$this->loadModel("Email");

				$idUsuarioRequerimientoCompra = $this->ComprasProductosTotale->find("first", array(
					'conditions'=>array('ComprasProductosTotale.id'=>$id),

				));

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

				if (isset($emailSap["Email"]["email"]))
					$email[] = strtolower($emailSap["Email"]["email"]);




				if(!empty($idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"]))
				{
					$numeroRequerimiento = $idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"] . ' - ' .$idUsuarioRequerimientoCompra["ComprasFactura"][0]["numero_documento"];
					$plantilla = "orden_compra_aprobada";
					$nombreEmail = "SE APROBO UN DOCUMENTO TRIBUTARIO EN SAP";
				}
				else
				{
					$numeroRequerimiento = $idUsuarioRequerimientoCompra["ComprasProductosTotale"]["id"];
					$plantilla = "orden_compra_aprobada";
					$nombreEmail = "SE APROBO UN NUEVO REQUERIMIENTO DE COMPRA EN SAP";
				}



				$this->loadModel("Email");
				$Email = new CakeEmail("gmail");
				$Email->from(array('sgi@cdf.cl' => 'SGI'));
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
				return $this -> redirect(array("action" => 'ingreso_sap'));
			}
			else
			{
				$this->Session->setFlash('Ocurrio un problema no se puede aprobar el producto', 'msg_fallo');
				return $this -> redirect(array("action" => 'ingreso_sap'));
			}
		}
	}


	/*
	public function aprobar_compra_sap()
	{
		$this->layout = null;
		$this->loadModel("ComprasProducto");
		$this->loadModel("ComprasProductosTotale"
		$id = $this->request->data["idRequerimiento"];

		if (!$this->ComprasProductosTotale->exists($id))
		{
			$this->Session->setFlash('El Producto no existe', 'msg_fallo');
			return $this->redirect(array('action' => 'ingreso_sap'));
		}

		if (!empty($id))
		{
			$estadoCompleto = "";

			if(isset($this->request->data["productos"]))
			{

				$idProductos = $this->ComprasProducto->find("all", array(
					'conditions'=>array("ComprasProducto.compras_productos_totale_id"=>$id),
					'fields'=>array("ComprasProducto.id", "ComprasProducto.estado")
				));

				$productosId = "";
				foreach($this->request->data["productos"] as $idProducto)
				{
					$productosId[] = array(
							"id"=>$idProducto,
							"estado"=>4
					);
				}

				if(!empty($productosId) && !empty($this->request->data["productos"]))
				{
					if(count($idProductos) == count($this->request->data["productos"]))
					{

						$estadoCompleto = 4;

					}
					else
					{
						$estadoCompleto = 2;
					}
				}
				else
				{
					$this->Session->setFlash('Seleccione almenos un producto para aprobar', 'msg_fallo');
					return $this->redirect(array('action' => 'ingreso_sap'));
				}

			}
			else
			{
				$this->Session->setFlash('Seleccione almenos un producto para aprobar', 'msg_fallo');
				return $this->redirect(array('action' => 'ingreso_sap'));
			}

			$aprobacionRechazo[] = array(
				"Id"=>$id,
				"UsuarioAprobador"=>$this->Session->Read("Users.nombre"),
				"FechaAprobacion"=>date("m-d-Y H:i")
			);

			$this->request->data["ComprasProductosTotale"]["id"] = $id;
			$this->request->data["ComprasProductosTotale"]["estado"] = $estadoCompleto;
			$this->request->data["ComprasProductosTotale"]["aprobacion_rechazo"] = serialize($aprobacionRechazo);

			if(!empty($this->request->data["codigo"]))
			{
				$this->request->data["ComprasProductosTotale"]["numero_sap"] = $this->request->data["codigo"];
			}

			if ($this->ComprasProductosTotale->save($this->request->data))
			{
				if($this->ComprasProducto->saveAll($productosId))
				{
					$estadosProductos = $this->ComprasProducto->find("all", array(
						'conditions'=>array(
							"ComprasProducto.compras_productos_totale_id"=>$id,
							"ComprasProducto.estado"=>4,
						),
						'fields'=>array("ComprasProducto.estado")
					));

					if(count($estadosProductos) == count($idProductos))
					{
						$this->request->data["ComprasProductosTotale"]["id"] = $id;
						$this->request->data["ComprasProductosTotale"]["estado"] = 4;
						$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);
					}
					else
					{
						$estadosProductosCompletos = $this->ComprasProducto->find("all", array(
							'conditions'=>array(
								"ComprasProducto.compras_productos_totale_id"=>$id,
							),
							'fields'=>array("ComprasProducto.estado")
						));
					}

					//pr($estadosProductosCompletos);exit;

					if(isset($estadosProductosCompletos))
					{
						$estado = "";
						foreach($estadosProductosCompletos as $estadoProductos)
						{
							$estado[] = $estadoProductos["ComprasProducto"]["estado"];
						}


						if(in_array(1, $estado))
						{
						    $estadoRechazado = 1;
						}
						else if(in_array(2, $estado))
						{
							$estadoRechazado = 7;
						}
						else
						{
							$estadoRechazado = 3;
						}

						//exit;

						$this->request->data["ComprasProductosTotale"]["id"] = $this->ComprasProductosTotale->id;
						$this->request->data["ComprasProductosTotale"]["estado"] = $estadoRechazado;
						$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);

					}
				}



				CakeLog::write('actividad', 'Se aprobo el requerimiento de compra ID - ' . $id . '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');

				$this->loadModel("Email");

				$idUsuarioRequerimientoCompra = $this->ComprasProductosTotale->find("first", array(
					'conditions'=>array('ComprasProductosTotale.id'=>$id),

				));

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
				//$email[] = strtolower($emailSap["Email"]["email"]);

				if(!empty($idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"]))
				{
					$numeroRequerimiento = $idUsuarioRequerimientoCompra["TiposDocumento"]["nombre"] . ' - ' .$idUsuarioRequerimientoCompra["ComprasFactura"][0]["numero_documento"];
					$plantilla = "orden_compra_aprobada";
					$nombreEmail = "SE APROBO UN DOCUMENTO TRIBUTARIO EN SAP";
				}
				else
				{
					$numeroRequerimiento = $idUsuarioRequerimientoCompra["ComprasProductosTotale"]["id"];
					$plantilla = "orden_compra_aprobada";
					$nombreEmail = "SE APROBO UN NUEVO REQUERIMIENTO DE COMPRA EN SAP";
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
				return $this -> redirect(array("action" => 'ingreso_sap'));
			}
			else
			{
				$this->Session->setFlash('Ocurrio un problema no se puede aprobar el producto', 'msg_fallo');
				return $this -> redirect(array("action" => 'ingreso_sap'));
			}
		}
	}
	*/
	public function compras_rechazar_sap()
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

		$this->layout = null;
		$estadoRechazado = "";

		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("ComprasProducto");

		if(!empty($this->data))
		{



			if (!$this->ComprasProductosTotale->exists($this->data["id_rechazo"]))
			{
				$this->Session->setFlash('El Producto no existe', 'msg_fallo');
				return $this->redirect(array('action' => 'ingreso_sap'));
			}

			if($this->data["id_rechazo"])
			{
				$idproductosRerchazados = explode(",", $this->request->data["productosRechazados"]);

				$idProductos = $this->ComprasProducto->find("all", array(
					'conditions'=>array("ComprasProducto.compras_productos_totale_id"=>$this->request->data["id_rechazo"]),
					'fields'=>array("ComprasProducto.id", "ComprasProducto.estado")
				));

					$productosIdRechazados = "";

					foreach($idproductosRerchazados as $idProducto)
					{
						$productosIdRechazados[] = array(
								"id"=>$idProducto,
								"estado"=>5,
						);
					}

				if($this->ComprasProducto->saveAll($productosIdRechazados))
				{
					$idProductos = $this->ComprasProducto->find("all", array(
						'conditions'=>array("ComprasProducto.compras_productos_totale_id"=>$this->request->data["id_rechazo"]),
						'fields'=>array("ComprasProducto.id", "ComprasProducto.estado", "ComprasProducto.subtotal")
					));

					$estadoTotalRechazo = "";

					if(!empty($productosIdRechazados) && !empty($idproductosRerchazados))
					{
						$productos = "";
						$productosRechazados = "";
						$otrosProductos = "";

						foreach($idProductos as $estadoPrtoductos)
						{
							$productos[] = $estadoPrtoductos["ComprasProducto"]["estado"];
							if($estadoPrtoductos["ComprasProducto"]["estado"] == 5)
							{
								$productosRechazados[] = $estadoPrtoductos["ComprasProducto"]["subtotal"];
							}
							else
							{
								$otrosProductos[] = $estadoPrtoductos["ComprasProducto"]["subtotal"];
							}
						}
					}
					else
					{
						$this->Session->setFlash('Seleccione almenos un producto para aprobar', 'msg_fallo');
						return $this->redirect(array('action' => 'ingreso_sap'));
					}

					if(in_array(2, $productos))
					{
					    $estadoRechazado = 2;
					}

					else if(in_array(4, $productos))
					{
						$estadoRechazado = 8;
					}
					else
					{
						$estadoRechazado = 5;
					}

					$aprobacionRechazo[] = array(
						"Id"=>$this->data["id_rechazo"],
						"UsuarioAprobador"=>$this->Session->Read("Users.nombre"),
						"FechaAprobacion"=>date("m-d-Y H:i")
					);

					if(!empty($productosRechazados))
					{
						$totalCompra = $this->ComprasProductosTotale->find("first", array(
							"conditions"=>array("ComprasProductosTotale.id"=>$this->data["id_rechazo"]),
							"fields"=>array("neto_descuento", "total", "descuento_total"),
							"recursive"=>0
						));
					}

					if(count($idProductos) == count($idproductosRerchazados))
					{
						$estadoTotalRechazo = 5;
						$this->request->data["ComprasProductosTotale"]["descuento_total"] = 0;
						$this->request->data["ComprasProductosTotale"]["total"] = 0;
						$this->request->data["ComprasProductosTotale"]["neto_descuento"] = 0;
					}
					else
					{

						if(!empty($totalCompra["ComprasProductosTotale"]["neto_descuento"]) && !empty($productosRechazados))
						{
							$this->request->data["ComprasProductosTotale"]["sub_total"] = array_sum($otrosProductos); //$totalCompra["ComprasProductosTotale"]["neto_descuento"] - array_sum($productosRechazados);
							$iva = $this->request->data["ComprasProductosTotale"]["sub_total"] * 0.19;
							$this->request->data["ComprasProductosTotale"]["total"] =  $this->request->data["ComprasProductosTotale"]["sub_total"] + $iva;
	 						$this->request->data["ComprasProductosTotale"]["neto_descuento"] = $this->request->data["ComprasProductosTotale"]["sub_total"];

	 						if(!empty($totalCompra["ComprasProductosTotale"]["descuento_total"]))
	 						{
	 							$descuentoPocentaje = $totalCompra["ComprasProductosTotale"]["descuento_total"] * 100 / $this->request->data["ComprasProductosTotale"]["sub_total"];
	 							$descuentoPeso = $descuentoPocentaje * $this->request->data["ComprasProductosTotale"]["sub_total"] / 100;

	 							if($descuentoPeso)
	 							{
	 								$this->request->data["ComprasProductosTotale"]["neto_descuento"] = array_sum($otrosProductos) - $descuentoPeso;
	 								$iva = $this->request->data["ComprasProductosTotale"]["neto_descuento"] * 0.19;
	 								$this->request->data["ComprasProductosTotale"]["total"] =  $this->request->data["ComprasProductosTotale"]["neto_descuento"] + $iva;
	 							}
	 						}
	 					}
					}


					$this->request->data["ComprasProductosTotale"]["id"] = $this->data["id_rechazo"];
					$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = $estadoRechazado;
					$this->request->data["ComprasProductosTotale"]["aprobacion_rechazo_sap"] = serialize($aprobacionRechazo);

					if ($this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]))
					{
						CakeLog::write('actividad', 'Se rechazo el requerimiento de compra ID - ' . $this->data["id_rechazo"] . '(' .$this->Session->read('Users.nombre') .')');

						$this->loadModel("ComprasProductosRechazo");

						//$this->request->data["ComprasProductosRechazo"]["compras_productos_totale_id"] = $this->data["id_rechazo"];
						//$this->request->data["ComprasProductosRechazo"]["motivo"] =  $this->request->data["Compras"]["motivoRechazo"];
						//$this->request->data["ComprasProductosRechazo"]["user_id"] = $this->Session->read("PerfilUsuario.idUsuario");
						$rechasos = "";
						foreach($productosIdRechazados as $idProductos)
						{
							$rechasos[] = array(
								"compras_producto_id"=>$idProductos["id"],
								"motivo"=>$this->request->data["Compras"]["motivoRechazo"],
								"user_id"=>$this->Session->read("PerfilUsuario.idUsuario")
							);
						}

						if(!empty($rechasos))
						{
							$this->ComprasProductosRechazo->saveAll($rechasos);
						}


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
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to(array_filter($email));
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
							"empresa"=>$idUsuarioRequerimientoCompra["Company"]["nombre"],
							"motivoRechazo"=>$this->request->data["Compras"]["motivoRechazo"]
						));
						$Email->send();

						$this->Session->setFlash('Requerimiento de compra no aprobado', 'msg_exito');
						return $this->redirect(array("action" => 'ingreso_sap'));
					}
					else
					{
						$this->Session->setFlash('Ocurrio un problema no se puede aprobar el producto', 'msg_fallo');
						return $this->redirect(array("action" => 'ingreso_sap'));
					}
				}
			}
		}
	}
    
    /*
	public function buscar_compras()
	{
        ini_set('memory_limit', '-1');
		$this->layout = "ajax";
		
		//$fecha = date('Y/m/d');
		//$nuevafecha = strtotime ('+1 day', strtotime ($fecha)) ;
		//$nuevafecha = date ('Y/m/d', $nuevafecha );
		//$menosDosMeses = strtotime ('-60 day', strtotime ($fecha));


		//$nuevafechaMenosDosMeses = date ('Y/m/d', $menosDosMeses );
		//pr($nuevafechaMenosDosMeses);
		//exit;
    	$this->response->type('json');

    	$compras = json_encode(array('mensaje'=>'No tiene permiso para ver el Json'));


    	$this->loadModel("ComprasProductosTotale");
		$this->loadModel("ComprasFactura");
		$this->loadModel("ComprasEstado");
		$this->loadModel("Company");
		$this->loadModel("TiposDocumento");
        $this->loadModel("CompanyType");

		$compras = $this->ComprasProductosTotale->find('all', array(
			"fields"=>array(
				"ComprasProductosTotale.id",
				"ComprasProductosTotale.company_id",
				"ComprasProductosTotale.titulo",
				"ComprasProductosTotale.created",
				"ComprasProductosTotale.total",
				"ComprasProductosTotale.compras_estado_id",
				"ComprasProductosTotale.numero_sap",

			),
			//'conditions'=>array('ComprasProductosTotale.created BETWEEN ? AND ?' => array('2015/01/01', $nuevafecha)),
			//'conditions'=>array('ComprasProductosTotale.created >' => '2017-01-01'),
			'recursive'=>-1
		));

		$empresas = $this->Company->find("all", array(
			"fields"=>array("Company.id", "Company.razon_social", "Company.rut", "Company.company_type_id", "Company.company_type_otros"),
			"recursive"=>-1
		));
		
		$companyTypes = $this->CompanyType->find("list", array(
			"fields"=>array("CompanyType.id", "CompanyType.nombre")
		));

		$estadoCompras = $this->ComprasEstado->find("all", array(
			"recursive"=>-1
		));

		$tiposDocumentos = $this->TiposDocumento->find("all", array(
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre")
		));

		$facturas = $this->ComprasFactura->find("all", array(
			"fields"=>array(
				"ComprasFactura.id",
				"ComprasFactura.numero_documento",
				"ComprasFactura.tipos_documento_id",
				"ComprasFactura.compras_productos_totale_id",
				"ComprasFactura.fecha_documento",
				"ComprasFactura.created"
			),
			"recursive" => -1
		));

		$tiposDocumentosNombres = "";

		foreach($tiposDocumentos as $tiposDocumento)
		{
			$tiposDocumentosNombres[$tiposDocumento["TiposDocumento"]["id"]] = substr($tiposDocumento["TiposDocumento"]["nombre"], 0,3);
		}

		$facturaNumeroDocumento = "";
		$facturaFechaDocumento = "";
		foreach($facturas as $factura)
		{
			$facturaNumeroDocumento[$factura["ComprasFactura"]["compras_productos_totale_id"]] = isset($tiposDocumentosNombres[$factura["ComprasFactura"]["tipos_documento_id"]]) ? $tiposDocumentosNombres[$factura["ComprasFactura"]["tipos_documento_id"]] . '-'.$factura["ComprasFactura"]["numero_documento"] : "";
			$facturaFechaDocumento[$factura["ComprasFactura"]["compras_productos_totale_id"]] = isset($factura["ComprasFactura"]["fecha_documento"]) ? $factura["ComprasFactura"]["fecha_documento"] : substr($factura["ComprasFactura"]["created"], 0, 10);
		}		
		
		$estadoId = "";
		$estadoNombre = "";
		$estadoClase = "";

		foreach($estadoCompras as $estadoCompra)
		{
			$estadoId[$estadoCompra["ComprasEstado"]["id"]] = $estadoCompra["ComprasEstado"]["id"];
			$estadoNombre[$estadoCompra["ComprasEstado"]["id"]] = $estadoCompra["ComprasEstado"]["estado"];
			$estadoClase[$estadoCompra["ComprasEstado"]["id"]] = $estadoCompra["ComprasEstado"]["clase"];
		}

		$nombreEmpresas = "";
		$rutEmpresas = "";
		$idEmpresa = "";
		$tipoEmpresa = "";
		

		foreach($empresas as $empresa)
		{
			$nombreEmpresas[$empresa["Company"]["id"]] = $empresa["Company"]["razon_social"];
			$rutEmpresas[$empresa["Company"]["id"]] = $empresa["Company"]["rut"];
			$idEmpresa[$empresa["Company"]["id"]] = $empresa["Company"]["id"];
			$tipoEmpresa[$empresa["Company"]["id"]] = ( isset($empresa["Company"]["company_type_otros"]) && !empty($empresa["Company"]["company_type_otros"]) ? unserialize($empresa["Company"]["company_type_otros"]) : $companyTypes[$empresa["Company"]["company_type_id"]]);
			
			
		}

		$buscaCompras = "";
		foreach($compras as $compra)
		{
			$buscaCompras[] = array(
				"Id"=>isset($compra["ComprasProductosTotale"]["id"]) ? $compra["ComprasProductosTotale"]["id"] : "",
				"Codigo"=>isset($facturaNumeroDocumento[$compra["ComprasProductosTotale"]["id"]]) ? $facturaNumeroDocumento[$compra["ComprasProductosTotale"]["id"]] : $compra["ComprasProductosTotale"]["id"],
				"Empresa"=>isset($nombreEmpresas[$compra["ComprasProductosTotale"]["company_id"]]) ? $nombreEmpresas[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"EmpresaRut"=>isset($rutEmpresas[$compra["ComprasProductosTotale"]["company_id"]]) ? $rutEmpresas[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"EmpresaId"=>isset($idEmpresa[$compra["ComprasProductosTotale"]["company_id"]]) ? $idEmpresa[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"EmpresaTipoSerializado"=>(isset($nombreTiposCompany[$compra["ComprasProductosTotale"]["company_id"]]) ? implode(' y ', $nombreTiposCompany[$compra["ComprasProductosTotale"]["company_id"]]) : ''),
				"Titulo"=>$compra["ComprasProductosTotale"]["titulo"],
				"Estado"=>isset($estadoNombre[$compra["ComprasProductosTotale"]["compras_estado_id"]]) ? $estadoNombre[$compra["ComprasProductosTotale"]["compras_estado_id"]] : "",
				"Clase"=>isset($estadoClase[$compra["ComprasProductosTotale"]["compras_estado_id"]]) ? $estadoClase[$compra["ComprasProductosTotale"]["compras_estado_id"]] : "",
				"IdEstado"=>isset($estadoId[$compra["ComprasProductosTotale"]["compras_estado_id"]]) ? $estadoId[$compra["ComprasProductosTotale"]["compras_estado_id"]] : "",
				"Fecha"=>date("Y-m-d", strtotime($compra["ComprasProductosTotale"]["created"])),
				"FechaDocumento"=>isset($facturaFechaDocumento[$compra["ComprasProductosTotale"]["id"]]) ? $facturaFechaDocumento[$compra["ComprasProductosTotale"]["id"]] : "",
				"Total"=>$compra["ComprasProductosTotale"]["total"],
				"NumeroSap"=>isset($compra["ComprasProductosTotale"]["numero_sap"]) ? $compra["ComprasProductosTotale"]["numero_sap"] : ""
			);
		}		
    	$this->set("buscaCompras", $buscaCompras);
	}
	*/
	
	public function buscar_compras()
	{
		ini_set('memory_limit', '-1');
		$this->layout = "ajax";
		//$fecha = date('Y/m/d');
		//$nuevafecha = strtotime ('+1 day', strtotime ($fecha)) ;
		//$nuevafecha = date ('Y/m/d', $nuevafecha );
		//$menosDosMeses = strtotime ('-60 day', strtotime ($fecha));
		
		
		//$nuevafechaMenosDosMeses = date ('Y/m/d', $menosDosMeses );
		//pr($nuevafechaMenosDosMeses);
		//exit;
    	$this->response->type('json');
		
    	$compras = json_encode(array('mensaje'=>'No tiene permiso para ver el Json'));
		

    	$this->loadModel("ComprasProductosTotale");
		$this->loadModel("ComprasFactura");
		$this->loadModel("ComprasEstado");
		$this->loadModel("Company");
		$this->loadModel("TiposDocumento");
		$this->loadModel("CompanyType");
		

		$compras = $this->ComprasProductosTotale->find('all', array(
			"fields"=>array(
				"ComprasProductosTotale.id", 
				"ComprasProductosTotale.company_id", 
				"ComprasProductosTotale.titulo", 
				"ComprasProductosTotale.created", 
				"ComprasProductosTotale.total", 
				"ComprasProductosTotale.compras_estado_id",
				"ComprasProductosTotale.numero_sap",
				
			),
			//'conditions'=>array('ComprasProductosTotale.created BETWEEN ? AND ?' => array('2015/01/01', $nuevafecha)),
			'recursive'=>-1
		));
		
		$empresas = $this->Company->find("all", array(
			"fields"=>array("Company.id", "Company.razon_social", "Company.rut", "Company.company_type_id", "Company.company_type_otros"),
			"recursive"=>-1
		));


		$companyTypes = $this->CompanyType->find("list", array(
			"fields"=>array("CompanyType.id", "CompanyType.nombre")
		));

		
		$estadoCompras = $this->ComprasEstado->find("all", array(
			"recursive"=>-1
		));
		
		$tiposDocumentos = $this->TiposDocumento->find("all", array(
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre")
		));
			
		$facturas = $this->ComprasFactura->find("all", array(
			"fields"=>array(
				"ComprasFactura.id", 
				"ComprasFactura.numero_documento", 
				"ComprasFactura.tipos_documento_id", 
				"ComprasFactura.compras_productos_totale_id"
			),
			"recursive" => -1
		));
		
		$tiposDocumentosNombres = "";
		
		foreach($tiposDocumentos as $tiposDocumento)
		{
			$tiposDocumentosNombres[$tiposDocumento["TiposDocumento"]["id"]] = substr($tiposDocumento["TiposDocumento"]["nombre"], 0,3);
		}
		
		$facturaNumeroDocumento = "";
		foreach($facturas as $factura)
		{
			$facturaNumeroDocumento[$factura["ComprasFactura"]["compras_productos_totale_id"]] = isset($tiposDocumentosNombres[$factura["ComprasFactura"]["tipos_documento_id"]]) ? $tiposDocumentosNombres[$factura["ComprasFactura"]["tipos_documento_id"]] . '-'.$factura["ComprasFactura"]["numero_documento"] : "";
		}
		
		$estadoId = "";
		$estadoNombre = "";
		$estadoClase = "";
		
		foreach($estadoCompras as $estadoCompra)
		{
			$estadoId[$estadoCompra["ComprasEstado"]["id"]] = $estadoCompra["ComprasEstado"]["id"];
			$estadoNombre[$estadoCompra["ComprasEstado"]["id"]] = $estadoCompra["ComprasEstado"]["estado"];
			$estadoClase[$estadoCompra["ComprasEstado"]["id"]] = $estadoCompra["ComprasEstado"]["clase"];
		}

		
		$nombreEmpresas = "";
		$rutEmpresas = "";
		$idEmpresa = "";
		$tipoEmpresa = "";

		foreach($empresas as $empresa)
		{


			$nombreEmpresas[$empresa["Company"]["id"]] = $empresa["Company"]["razon_social"];
			$rutEmpresas[$empresa["Company"]["id"]] = $empresa["Company"]["rut"];
			$idEmpresa[$empresa["Company"]["id"]] = $empresa["Company"]["id"];
			$tipoEmpresa[$empresa["Company"]["id"]] = ( isset($empresa["Company"]["company_type_otros"]) && !empty($empresa["Company"]["company_type_otros"]) ? unserialize($empresa["Company"]["company_type_otros"]) : $companyTypes[$empresa["Company"]["company_type_id"]]);
		}


		$nombreTiposCompany = "";

		
		foreach ($tipoEmpresa as $key => $value) {
			if(is_array($value)){
				foreach($value as $x){
					$nombreTiposCompany[$key][] = $companyTypes[$x];
				}
			}else{
				$nombreTiposCompany[$key][] = $value;
			}
		};

		$buscaCompras = "";
		foreach($compras as $compra)
		{
			$buscaCompras[] = array(
				"Id"=>isset($compra["ComprasProductosTotale"]["id"]) ? $compra["ComprasProductosTotale"]["id"] : "",
				"Codigo"=>isset($facturaNumeroDocumento[$compra["ComprasProductosTotale"]["id"]]) ? $facturaNumeroDocumento[$compra["ComprasProductosTotale"]["id"]] : $compra["ComprasProductosTotale"]["id"],
				"Empresa"=>isset($nombreEmpresas[$compra["ComprasProductosTotale"]["company_id"]]) ? $nombreEmpresas[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"EmpresaRut"=>isset($rutEmpresas[$compra["ComprasProductosTotale"]["company_id"]]) ? $rutEmpresas[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"EmpresaId"=>isset($idEmpresa[$compra["ComprasProductosTotale"]["company_id"]]) ? $idEmpresa[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"EmpresaTipoSerializado"=>(isset($nombreTiposCompany[$compra["ComprasProductosTotale"]["company_id"]]) ? implode(' y ', $nombreTiposCompany[$compra["ComprasProductosTotale"]["company_id"]]) : ''),
				"Titulo"=>$compra["ComprasProductosTotale"]["titulo"],
				"Estado"=>isset($estadoNombre[$compra["ComprasProductosTotale"]["compras_estado_id"]]) ? $estadoNombre[$compra["ComprasProductosTotale"]["compras_estado_id"]] : "",
				"Clase"=>isset($estadoClase[$compra["ComprasProductosTotale"]["compras_estado_id"]]) ? $estadoClase[$compra["ComprasProductosTotale"]["compras_estado_id"]] : "",
				"IdEstado"=>isset($estadoId[$compra["ComprasProductosTotale"]["compras_estado_id"]]) ? $estadoId[$compra["ComprasProductosTotale"]["compras_estado_id"]] : "",
				"Fecha"=>date("Y-m-d", strtotime($compra["ComprasProductosTotale"]["created"])),
				"Total"=>$compra["ComprasProductosTotale"]["total"],
				"NumeroSap"=>isset($compra["ComprasProductosTotale"]["numero_sap"]) ? $compra["ComprasProductosTotale"]["numero_sap"] : ""
			);
		}

    	$this->set("buscaCompras", $buscaCompras);
	}

	public function buscar_compras_ingresado_sap()
	{
		$this->layout = "ajax";

		$fecha = date('Y/m/d');
		$nuevafecha = strtotime ('+1 day', strtotime ($fecha)) ;
		$nuevafecha = date ('Y/m/d', $nuevafecha );

    	$this->response->type('json');

    	$compras = json_encode(array('mensaje'=>'No tiene permiso para ver el Json'));

    	$this->loadModel("ComprasProductosTotale");

		$compras = $this->ComprasProductosTotale->find('all', array(
			'conditions'=>array(
				'ComprasProductosTotale.created >' => '2017-01-01 00:00:00',
				'ComprasProductosTotale.compras_estado_id'=>array(4,8),
				'ComprasProductosTotale.tipos_documento_id'=>array(27,26,20,19,17,18)
				),
			'recursive'=>0
		));

		$buscaCompras = "";

		foreach($compras as $compra)
		{
			if(isset($compra["ComprasFactura"][0]["id"]))
			{
				$codigoFactura = substr($compra["TiposDocumento"]["nombre"], 0,3) . '-' . $compra["ComprasFactura"][0]["numero_documento"];
			}
			else
			{
				$codigoFactura = $compra["ComprasProductosTotale"]["id"];
			}

			$buscaCompras[] = array(
				"Id"=>$compra["ComprasProductosTotale"]["id"],
				"Codigo"=>$codigoFactura,
				"Empresa"=>$compra["Company"]["razon_social"],
				"EmpresaRut"=>$compra["Company"]["rut"],
				"EmpresaId"=>$compra["Company"]["id"],
				"Titulo"=>$compra["ComprasProductosTotale"]["titulo"],
				"Estado"=>$compra["ComprasEstado"]["estado"],
				"Clase"=>$compra["ComprasEstado"]["clase"],
				"IdEstado"=>$compra["ComprasEstado"]["id"],
				"Fecha"=>date("d-m-Y", strtotime($compra["ComprasProductosTotale"]["created"])),
				"Total"=>$compra["ComprasProductosTotale"]["total"],
				"NumeroSap"=>$compra["ComprasProductosTotale"]["numero_sap"]
			);
		}

    	$this->set("buscaCompras", $buscaCompras);
	}

	public function todos_sap(){
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
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		//CakeLog::write('actividad', 'entro a  la pagina compras/todos_sap - ' . $this->Session->Read("PerfilUsuario.idUsuario"));


		/*
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
					"idOrdenCompra"=>(isset($ordenCompras["ComprasProductosTotale"]["id"])) ? $ordenCompras["ComprasProductosTotale"]["id"] : "",
					"nombreEmpresa"=>(isset($ordenCompras["ComprasProductosTotale"]["Company"]["nombre"])) ? $ordenCompras["ComprasProductosTotale"]["Company"]["nombre"] : "" ,
					"titulo"=>$ordenCompras["ComprasProductosTotale"]["titulo"],
					"fecha"=>$ordenCompras["ComprasProductosTotale"]["created"],
					"titulo"=>$ordenCompras["ComprasProductosTotale"]["titulo"],
					"estado"=>$ordenCompras["ComprasProductosTotale"]["estado"],
					"total"=>$ordenCompras["ComprasProductosTotale"]["total"],
					"nombreDocumento"=>(isset($ordenCompras["ComprasProductosTotale"]["TiposDocumento"])) ? $ordenCompras["ComprasProductosTotale"]["TiposDocumento"] : "",
					"numeroFactura"=>(isset($ordenCompras["ComprasProductosTotale"]["ComprasFactura"])) ? $ordenCompras["ComprasProductosTotale"]["ComprasFactura"] : ""
				);
			}
			$this->set("filtroOrdenesDeCompra", $filtroOrdenesDeCompra);
		}
		*/
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
			"fields"=>array("Company.id", "Company.razon_social")
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
			"conditions"=>array("TiposDocumento.tipo"=>1, "TiposDocumento.id != "=>26),
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
			"fields"=>array("Company.id", "Company.razon_social")
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


	public function declaracion_ingreso()
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
			"conditions"=>array("TiposDocumento.tipo"=>4),
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
			"fields"=>array("Company.id", "Company.razon_social")
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
			"conditions"=>array("TiposDocumento.tipo"=>1, "TiposDocumento.id !="=>26),
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
			"fields"=>array("Company.id", "Company.razon_social")
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
			"conditions"=>array("TiposDocumento.tipo"=>1, "TiposDocumento.id != "=>26),
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
			"fields"=>array("Company.id", "Company.razon_social")
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


	public function notas_credito($id)
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


		CakeLog::write('actividad', 'entro a  la pagina compras/Notas de Credito - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

		$exisNotaCredito = "";

		$this->loadModel("ComprasProductosTotale");

		if (!$this->ComprasProductosTotale->exists($id))
		{
			throw new NotFoundException(__('el ID no existe'), 'ms_error');
			return $this -> redirect(array("action"=>'index'));
		}

		$this->loadModel("TiposDocumento");
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");

		$tipoDocumentos = $this->TiposDocumento->find("list", array(
			//"conditions"=>array("TiposDocumento.tipo"=>3),
			"conditions"=>array("TiposDocumento.id"=>26),
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre"),
			'order'=>array("TiposDocumento.id ASC")
		));

		$this->set("tipoDocumentos", $tipoDocumentos);


		if(!empty($id))
		{
			$comprasProductosTotale = $this->ComprasProductosTotale->find("first", array(
				'conditions'=>array("ComprasProductosTotale.id"=>$id)
			));

			$nuemroDocumentosEncontrados = "";


			foreach($comprasProductosTotale["ComprasFactura"] as $numeroDocumento)
			{
				$nuemroDocumentosEncontrados[] = $numeroDocumento["numero_documento"];
			}

			if(!empty($nuemroDocumentosEncontrados))
			{
				$this->loadModel("Comprasfactura");
				$documentos = $this->Comprasfactura->find("all", array(
					"conditions"=>array(
						"Comprasfactura.numero_documento"=>$nuemroDocumentosEncontrados,
						"Comprasfactura.tipos_documento_id"=>26,

					),
					"fields"=>array("Comprasfactura.id", "Comprasfactura.requerimiento_id")
				));

				if(!empty($documentos))
				{
					$requerimientoId = "";
					foreach($documentos as $documento)
					{
						if(is_array(unserialize($documento["Comprasfactura"]["requerimiento_id"])))
						{
							foreach(unserialize($documento["Comprasfactura"]["requerimiento_id"]) as $numerosDeserealizados)
							{
								$requerimientoId[] = $numerosDeserealizados["id"]["id"];
							}
						}
						else
						{
							$requerimientoId[] = unserialize($documento["Comprasfactura"]["requerimiento_id"]);
						}
					}
				}

				if(!empty($requerimientoId))
				{
					if(in_array($id, $requerimientoId))
					{
						$exisNotaCredito = 1;
					}
				}
			}

			$this->set("exisNotaCredito", $exisNotaCredito);
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
			"fields"=>array("Company.id", "Company.razon_social")
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

	public function asociar_facturas($idRequerimientosJs = null)
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

		$this->loadModel("TiposDocumento");
		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("ComprasProducto");
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");

		$idRequerimientos = "";

		if(!empty($idRequerimientosJs))
		{
			$idRequerimientos =  explode(",", $idRequerimientosJs);
		}else
		{
			$resultado = str_replace("[", "", $this->request->data["idRequerimiento"]);
			$resultado = str_replace("]", "", $resultado); 
			$idRequerimientos =  explode(",", $resultado);
			//$idRequerimientos =  explode(",", $this->request->data["idRequerimiento"]);
		}



		if(!empty($idRequerimientos))
		{
			
			$idEmpresas = $this->ComprasProductosTotale->find("all", array(
				'conditions'=>array('ComprasProductosTotale.id'=>$idRequerimientos),
				'fields'=>array('ComprasProductosTotale.company_id', 'ComprasProductosTotale.tipos_moneda_id'),
				'recursive'=> 0
			));

			if(!empty($idEmpresas))
			{
				$empresaId = "";
				$tipoMonedaId = "";
				foreach($idEmpresas as $idEmpresa)
				{
					$empresaId[] = $idEmpresa["ComprasProductosTotale"]["company_id"];
					$tipoMonedaId[] = $idEmpresa["ComprasProductosTotale"]["tipos_moneda_id"];
				}

				if(count(array_unique($empresaId)) > 1 || count(array_unique($tipoMonedaId)) > 1)
				{
					$this->Session->setFlash('Para poder asociar mas de un requerimiento estos deben ser del mismo proveedor y el mismo tipo de moneda', 'msg_fallo');
					return $this->redirect(array("action"=>'index'));
				}
				else
				{

					$productosMultiples = $this->ComprasProducto->find("all", array(
						'conditions'=>array('ComprasProducto.compras_productos_totale_id'=>$idRequerimientos),
						'recursive'=>0
					));

					//pr($productosMultiples);
					//exit;

					$id = $idRequerimientos[0];

					$comprasMultiplesProductos = "";

					if(!empty($productosMultiples))
					{
						foreach($productosMultiples as $productosMultiple)
						{

							$comprasMultiplesProductos[] = array(
								"id"=>$productosMultiple["ComprasProducto"]["id"],
					            "dim_uno"=>$productosMultiple["ComprasProducto"]["dim_uno"],
					            "proyecto"=>$productosMultiple["ComprasProducto"]["proyecto"],
					            "cantidad"=>$productosMultiple["ComprasProducto"]["cantidad"],
					            "precio_unitario"=>$productosMultiple["ComprasProducto"]["precio_unitario"],
					            "empaque"=>$productosMultiple["ComprasProducto"]["empaque"],
					            "descuento_producto"=>$productosMultiple["ComprasProducto"]["descuento_producto"],
					            "created"=>$productosMultiple["ComprasProducto"]["created"],
					            "mdified"=>(isset($productosMultiple["ComprasProducto"]["mdified"]) ? $productosMultiple["ComprasProducto"]["mdified"] : ""),
					            "codigos_presupuestarios"=>$productosMultiple["ComprasProducto"]["codigos_presupuestarios"],
					            "descripcion"=>$productosMultiple["ComprasProducto"]["descripcion"],
					            "dim_dos"=>$productosMultiple["ComprasProducto"]["dim_dos"],
					            "dim_tres"=>$productosMultiple["ComprasProducto"]["dim_tres"],
					            "dim_cuatro"=>$productosMultiple["ComprasProducto"]["dim_cuatro"],
					            "dim_cinco"=>$productosMultiple["ComprasProducto"]["dim_cinco"],
					            "compras_productos_totale_id"=>$productosMultiple["ComprasProducto"]["compras_productos_totale_id"],
					            "estado"=>$productosMultiple["ComprasProducto"]["estado"],
					            "subtotal"=>$productosMultiple["ComprasProducto"]["subtotal"],
					            "afecto"=>$productosMultiple["ComprasProducto"]["afecto"],
							);
						}
					}
					$this->set("comprasMultiplesProductos", $comprasMultiplesProductos);
					$this->set("idRequerimientos", $idRequerimientos);
				}
			}
		}else{
			$this->Session->setFlash('No hay documentos tributarios cargados', 'msg_fallo');
			return $this->redirect(array("action"=>'index'));
		}

		CakeLog::write('actividad', 'entro a  la pagina compras/asociar facturas - ' . $this->Session->Read("PerfilUsuario.idUsuario"));

		$tipoDocumentos = $this->TiposDocumento->find("list", array(
			"conditions"=>array("TiposDocumento.tipo"=>1, "TiposDocumento.id !="=>26),
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
			"fields"=>array("Company.id", "Company.razon_social")
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
			"conditions"=>array("TiposDocumento.tipo"=>1, "TiposDocumento.id !="=>26),
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre"),
			'order'=>array("TiposDocumento.id ASC")
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
			"fields"=>array("Company.id", "Company.razon_social")
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
			"conditions"=>array("TiposDocumento.tipo"=>1, "TiposDocumento.id !="=>26),
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre"),
			'order'=>array("TiposDocumento.id ASC")
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
			"fields"=>array("Company.id", "Company.razon_social")
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

	public function satelites_compras()
	{
		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");

		$proveedores = $this->Company->find("list", array(
			"fields"=>array("Company.id", "Company.razon_social")
		));

		$tipoMonedas = $this->TiposMoneda->find("list", array(
			"fields"=>array("TiposMoneda.id", "TiposMoneda.nombre")
		));

		$plazosPagos = $this->PlazosPago->find("list", array(
			"fields"=>array("PlazosPago.id", "PlazosPago.nombre")
		));

		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));

		$proveedoresJson = "";
		foreach($proveedores as $key => $proveedor)
		{
			$proveedoresJson["proveedores"][] = array("id"=>$key, "nombre"=>$proveedor);
		}

		$tipoMonedasJson = "";
		foreach($tipoMonedas as $key => $tipoMoneda)
		{
			$tipoMonedasJson[] = array("id"=>$key, "nombre"=>$tipoMonedas);
		}


		$satelites = $proveedoresJson;
		//$satelites["tipoMonedas"] = $tipoMonedasJson;
		//$satelites["plazoPagos"] = $plazosPagos;
		//$satelites["empaque"] = $empaques;

		$this->set("satelites", $satelites);
	}

	public function editar_codigo_sap()
	{
		$this->layout = "angular";
	}

	public function edit_codigo_sap()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$estado = "";
		$this->loadModel("ComprasProductosTotale");
		if(!empty($this->params->query["numeroSap"]) && !empty($this->params->query["comprasId"]))
		{
			$this->Compra->id = $this->params->query["comprasId"];

			$this->request->data["ComprasProductosTotale"]["id"] = $this->params->query["comprasId"];
			$this->request->data["ComprasProductosTotale"]["numero_sap"] = $this->params->query["numeroSap"];

			if($this->ComprasProductosTotale->save($this->request->data))
			{
				$estado = array("Error"=>1, "Mensaje"=>"EL CODIGO SAP FUE REGISTRADO");
			}
		}
		else
		{
			$estado = array("Error"=>0, "Mensaje"=>"NO SE PUEDE REGISTRAR. INTENTELO NUEVAMENTE");
		}
		$this->set("estado", $estado);
	}

	public function filtro_personalizado()
	{
		$this->layout = "ajax";
		$fecha = date('Y/m/d');
		$nuevafecha = strtotime ('+1 day', strtotime ($fecha)) ;
		$nuevafecha = date ('Y/m/d', $nuevafecha );
		$menosDosMeses = strtotime ('-60 day', strtotime ($fecha));


		$nuevafechaMenosDosMeses = date ('Y/m/d', $menosDosMeses );
		//pr($nuevafechaMenosDosMeses);
		//exit;
    	$this->response->type('json');

    	$compras = json_encode(array('mensaje'=>'No tiene permiso para ver el Json'));


    	$this->loadModel("ComprasProductosTotale");
		$this->loadModel("ComprasFactura");
		$this->loadModel("ComprasEstado");
		$this->loadModel("Company");
		$this->loadModel("TiposDocumento");


		$compras = $this->ComprasProductosTotale->find('all', array(
			"fields"=>array(
				"ComprasProductosTotale.id",
				"ComprasProductosTotale.company_id",
				"ComprasProductosTotale.titulo",
				"ComprasProductosTotale.created",
				"ComprasProductosTotale.total",
				"ComprasProductosTotale.compras_estado_id",
				"ComprasProductosTotale.numero_sap",

			),
			//'conditions'=>array('ComprasProductosTotale.created BETWEEN ? AND ?' => array('2015/01/01', $nuevafecha)),
			'recursive'=>-1
		));

		$empresas = $this->Company->find("all", array(
			"fields"=>array("Company.id", "Company.razon_social", "Company.rut"),
			"recursive"=>-1
		));

		$estadoCompras = $this->ComprasEstado->find("all", array(
			"recursive"=>-1
		));

		$tiposDocumentos = $this->TiposDocumento->find("all", array(
			"fields"=>array("TiposDocumento.id", "TiposDocumento.nombre")
		));

		$facturas = $this->ComprasFactura->find("all", array(
			"fields"=>array(
				"ComprasFactura.id",
				"ComprasFactura.numero_documento",
				"ComprasFactura.tipos_documento_id",
				"ComprasFactura.compras_productos_totale_id"
			),
			"recursive" => -1
		));

		$tiposDocumentosNombres = "";

		foreach($tiposDocumentos as $tiposDocumento)
		{
			$tiposDocumentosNombres[$tiposDocumento["TiposDocumento"]["id"]] = substr($tiposDocumento["TiposDocumento"]["nombre"], 0,3);
		}


		$facturaNumeroDocumento = "";
		foreach($facturas as $factura)
		{
			$facturaNumeroDocumento[$factura["ComprasFactura"]["compras_productos_totale_id"]] =  isset($tiposDocumentosNombres[$factura["ComprasFactura"]["tipos_documento_id"]]) ? $tiposDocumentosNombres[$factura["ComprasFactura"]["tipos_documento_id"]] . '-'.$factura["ComprasFactura"]["numero_documento"] : "";
		}

		$estadoId = "";
		$estadoNombre = "";
		$estadoClase = "";

		foreach($estadoCompras as $estadoCompra)
		{
			$estadoId[$estadoCompra["ComprasEstado"]["id"]] = $estadoCompra["ComprasEstado"]["id"];
			$estadoNombre[$estadoCompra["ComprasEstado"]["id"]] = $estadoCompra["ComprasEstado"]["estado"];
			$estadoClase[$estadoCompra["ComprasEstado"]["id"]] = $estadoCompra["ComprasEstado"]["clase"];
		}

		$nombreEmpresas = "";
		$rutEmpresas = "";
		$idEmpresa = "";
		foreach($empresas as $empresa)
		{
			$nombreEmpresas[$empresa["Company"]["id"]] = $empresa["Company"]["razon_social"];
			$rutEmpresas[$empresa["Company"]["id"]] = $empresa["Company"]["rut"];
			$idEmpresa[$empresa["Company"]["id"]] = $empresa["Company"]["id"];
		}

		$buscaCompras = "";
		foreach($compras as $compra)
		{
			$buscaCompras[] = array(
				"Id"=>isset($compra["ComprasProductosTotale"]["id"]) ? $compra["ComprasProductosTotale"]["id"] : "",
				"Codigo"=>isset($facturaNumeroDocumento[$compra["ComprasProductosTotale"]["id"]]) ? $facturaNumeroDocumento[$compra["ComprasProductosTotale"]["id"]] : "",
				"Empresa"=>isset($nombreEmpresas[$compra["ComprasProductosTotale"]["company_id"]]) ? $nombreEmpresas[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"EmpresaRut"=>isset($rutEmpresas[$compra["ComprasProductosTotale"]["company_id"]]) ? $rutEmpresas[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"EmpresaId"=>isset($idEmpresa[$compra["ComprasProductosTotale"]["company_id"]]) ? $idEmpresa[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"Titulo"=>$compra["ComprasProductosTotale"]["titulo"],
				"Estado"=>isset($estadoNombre[$compra["ComprasProductosTotale"]["compras_estado_id"]]) ? $estadoNombre[$compra["ComprasProductosTotale"]["compras_estado_id"]] : "",
				"Clase"=>isset($estadoClase[$compra["ComprasProductosTotale"]["compras_estado_id"]]) ? $estadoClase[$compra["ComprasProductosTotale"]["compras_estado_id"]] : "",
				"IdEstado"=>isset($estadoId[$compra["ComprasProductosTotale"]["compras_estado_id"]]) ? $estadoId[$compra["ComprasProductosTotale"]["compras_estado_id"]] : "",
				"Fecha"=>date("d-m-Y", strtotime($compra["ComprasProductosTotale"]["created"])),
				"Total"=>$compra["ComprasProductosTotale"]["total"],
				"NumeroSap"=>isset($compra["ComprasProductosTotale"]["numero_sap"]) ? $compra["ComprasProductosTotale"]["numero_sap"] : ""
			);
		}
	}

	public function lista_email_json()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Email");
		$listaEmail = $this->Email->find("all", array("conditions"=>array("Email.informe not in"=>array("abonados", 'scaballero','prod-cdf','prod-tx', 'radio-cdf', 'gau') )));

		$listaEmailJson = "";

		foreach ($listaEmail as $key => $value) {
			$listaEmailJson[] = array(
				"Id"=>$value["Email"]["id"],
				"Email"=>$value["Email"]["email"],
				"Informe"=>$value["Email"]["informe"],
			);
		}

		$this->set("listaEmail", $listaEmailJson);
	}

	public function codigos_cortos()
	{
		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("Dimensione");

		$codigosCortos = $this->Dimensione->find("list", array(
			"conditions"=>array("Dimensione.codigo_corto !="=>""),
			"fields"=>array("Dimensione.codigo_corto", "Dimensione.codigo_corto")
		));

		$this->set("codigosCortos", $codigosCortos);
	}

	public function lista_aprobadores()
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
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function lista_aprobadores_editar()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$estado = "";
		if(!empty($this->params->query))
		{
			$this->loadModel("Email");
			$this->request->data["Email"]["id"] = $this->params->query["getId"];
			$this->request->data["Email"]["email"] = $this->params->query["getEmail"];
			$this->request->data["Email"]["informe"] = $this->params->query["getOperador"];
		}

		if($this->Email->save($this->request->data))
		{
			CakeLog::write('actividad', 'Se edito el aprobador id '.$this->params->query["getId"] . '----' . $this->Session->Read("PerfilUsuario.idUsuario"));
			$estado = array("Error"=>1, "Mensaje"=>"El registro se edito correctamente");
		}else{
			CakeLog::write('actividad', 'intento editar pero ocurrio un error, aprobador id  - '.$this->params->query["getId"] . '----' . $this->Session->Read("PerfilUsuario.idUsuario"));
			$estado = array("Error"=>0, "Mensaje"=>"El registro no se puedo editar");
		}
		$this->set("estado", $estado);
	}

	public function aprobadores_add()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$estado = "";

		if(!empty($this->params->query))
		{
			$this->loadModel("Email");

			$this->request->data["Email"]["email"] = $this->params->query["getEmail"];
			$this->request->data["Email"]["informe"] = $this->params->query["getOperador"];

			if($this->Email->save($this->request->data))
			{
				CakeLog::write('actividad', 'Se edito el aprobador id '.$this->params->query["getId"] . '----' . $this->Session->Read("PerfilUsuario.idUsuario"));
				$estado = array("Error"=>1, "Mensaje"=>"El registro se inserto correctamente");
			}else{
				CakeLog::write('actividad', 'intento editar pero ocurrio un error, aprobador id  - '.$this->params->query["getId"] . '----' . $this->Session->Read("PerfilUsuario.idUsuario"));
				$estado = array("Error"=>0, "Mensaje"=>"El registro no se puedo insertar");
			}

		}
		$this->set("estado", $estado);
	}

	public function aprobadores_delete()
	{
		$this->layout = "ajax";

		$this->loadModel("Email");

		$this->request->data["Email"]["id"] = $this->params->query["getId"];


		if(!empty($this->request->data["Email"]["id"]))
		{
			$this->Email->delete($this->request->data["Email"]["id"]);
			CakeLog::write('actividad', 'Se edito el aprobador id '.$this->params->query["getId"] . '----' . $this->Session->Read("PerfilUsuario.idUsuario"));
			$estado = array("Error"=>1, "Mensaje"=>"El registro se inserto correctamente");
		}
		else
		{
			CakeLog::write('actividad', 'intento editar pero ocurrio un error, aprobador id  - '.$this->params->query["getId"] . '----' . $this->Session->Read("PerfilUsuario.idUsuario"));
			$estado = array("Error"=>0, "Mensaje"=>"El registro no se puedo insertar");
		}
		$this->set("estado", $estado);
	}

	public function editar_codigo_presupuestario($id)
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

		if(!empty($id))
		{
			CakeLog::write('actividad', 'entro a la pagina editar_codigo_presupuestario compras id '.$id . '----' . $this->Session->Read("PerfilUsuario.idUsuario"));
		}
		else
		{
			$this->Session->setFlash('Seleccione un compra antes de editar su código presupuestario', 'msg_fallo');
			return $this->redirect(array("action" => 'todos_sap'));
		}

		$this->layout = "angular";
	}

	public function listar_compras_productos()
	{
		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("ComprasProductosTotale");

		$id = $this->params->query["getId"];


		if(!empty($id))
		{
			$compras = $this->ComprasProductosTotale->findById($id);

			$productosJson = "";

			if(!empty($compras))
			{
				foreach($compras["ComprasProducto"] as $productos)
				{
					$productosJson["Productos"][] = array(
						"Id"=>$productos['id'],
						"Descripcion"=>$productos['descripcion'],
						"DimUno"=>$productos['dim_uno'],
						"CodigoPresupuesto"=>$productos['codigos_presupuestarios'],
						"ComprasProductosTotaleId"=>$productos['compras_productos_totale_id'],
						"ValorProducto"=>$productos['subtotal'],

					);
				}
			}
		}

		$this->set("productosJson", $productosJson);
	}


	public function edit_codigo_presupuestario()
	{
		$this->autoRender = false;
		$this->response->type("json");

		$estado = "";

		if(!empty($this->params->query["getId"]) && !empty($this->params->query["getAgno"]) && !empty($this->params->query["getCodigo"]))
		{
			$this->loadModel("ComprasProducto");

			$this->request->data["ComprasProducto"]["id"] = $this->params->query["getId"];
			$this->request->data["ComprasProducto"]["agno"] = $this->params->query["getAgno"];
			$this->request->data["ComprasProducto"]["codigos_presupuestarios"] = $this->params->query["getCodigo"];

			if($this->ComprasProducto->save($this->request->data["ComprasProducto"]))
			{
				CakeLog::write('actividad', 'Se edito el producto id '.$this->params->query["getId"] . '----' . $this->Session->Read("PerfilUsuario.idUsuario"));
				$estado = array("Error"=>1, "Mensaje"=>"El registro se edito correctamente");
			}
			else
			{
				CakeLog::write('actividad', 'No se edito el producto id '.$this->params->query["getId"] . '----' . $this->Session->Read("PerfilUsuario.idUsuario"));
				$estado = array("Error"=>0, "Mensaje"=>"El registro no se edito correctamente");
			}

		}
		else
		{
			CakeLog::write('actividad', 'No se edito el producto id '.$this->params->query["getId"] . '----' . $this->Session->Read("PerfilUsuario.idUsuario"));
			$estado = array("Error"=>0, "Mensaje"=>"El registro no se edito correctamente");
		}

		//exit;
		return json_encode($estado);
	}


	public function compras_gerencias()
	{
		pr($this->buscar_compras);
		exit;
	}
	
	public function conectarSap($baseUrl, $options = null) {
		
		$dataSource = array(
			"UserName" => USAP,
			"Password" => PSAP,
			"CompanyDB" => DBSAP
		);

		$servicio = new ServiciosController();
		$response = $servicio->sap_post(SAP.$baseUrl, $dataSource);
		$conectar = json_decode($response, true);

		if(array_key_exists("SessionId", $conectar)) {
			return $conectar["SessionId"];
		} else {
			return false;
		}
	}

	public function setDraftsSap($data) {

		$servicio = new ServiciosController();
		$session = $this->conectarSap('Login');

		if($session) {
			$data["SessionId"] = $session;

			$options = urlencode("Drafts");
			$response = $servicio->sap_post(SAP.$options, $data, $session);
			$respuesta = json_decode($response, true);

			if(array_key_exists("error", $respuesta)) {
				return $respuesta["error"];
			} else {
				return $respuesta;
			}
		}		
	}

	public function setFileSap($data) {

		$servicio = new ServiciosController();
		$session = $this->conectarSap('Login');

		if($session) {			

			$options = urlencode("Attachments2");
			$response = $servicio->sap_post(SAP.$options, $data, $session);
			$respuesta = json_decode($response, true);

			if(array_key_exists("error", $respuesta)) {
				return $respuesta["error"];
			} else {
				return $respuesta;
			}
		}		
	}

	public function obtSocioDeNegocio($id) {		
		$servicio = new ServiciosController();
		$session = $this->conectarSap('Login');

		if ($session) {
			$options = urlencode("BusinessPartners?%24select=CardCode,CardName&%24filter=contains(CardCode,'$id')");
			$response = $servicio->sap_get(SAP.urldecode($options), $session, 1);
			$resArray = json_decode($response, true);
			if (array_key_exists("value", $resArray)){
				$respuesta = $resArray["value"];	
			}else {
				$respuesta = array();
			}
		} else {
			$respuesta = array("message" => "no pudo conectar con sap");
		}
		return $respuesta;
	}

	public function obtFinanzasIndicadores() {
		$servicio = new ServiciosController();
		$session = $this->conectarSap('Login');

		if ($session) {
			$options = urlencode("FactoringIndicators?%24orderby=IndicatorName%20asc");
			$response = $servicio->sap_get(SAP.urldecode($options), $session, 1);
			$resArray = json_decode($response, true);
			
			if (array_key_exists("value", $resArray)){
				$respuesta = $resArray["value"];
			}else {
				$respuesta = array();
			}
		} else {
			$respuesta = array("message" => "no pudo conectar con sap");
		}
		return $respuesta;
	}

	public function obtArticulos() {		
		$servicio = new ServiciosController();
		$session = $this->conectarSap('Login');

		if ($session) {
			$options = urlencode("Items?%24select=ItemCode,ItemName&%24orderby=ItemName%20asc");			
			$response = $servicio->sap_get(SAP.urldecode($options), $session, 1);
			$resArray = json_decode($response, true);			

			if (array_key_exists("value", $resArray)){
				$respuesta = $resArray["value"];	
			}else {
				$respuesta = array();
			}
		} else {
			$respuesta = array("message" => "no pudo conectar con sap");
		}
		return $respuesta;
	}

	public function obtCuentasContables() {		
		$servicio = new ServiciosController();
		$session = $this->conectarSap('Login');

		if ($session) {
			$options = urlencode("ChartOfAccounts?%24select=Code,Name&%24orderby=Name%20asc");			
			$response = $servicio->sap_get(SAP.urldecode($options), $session, 1);
			$resArray = json_decode($response, true);			

			if (array_key_exists("value", $resArray)){
				$respuesta = $resArray["value"];	
			}else {
				$respuesta = array();
			}
		} else {
			$respuesta = array("message" => "no pudo conectar con sap");
		}
		return $respuesta;
	}

	public function enviar_compra_sap(){

		$this->loadModel("ComprasSapEnvio");					

		if(!empty($this->request->data["Sap"])){

			// envia juan carlos mariangel
			if ($this->Session->read('PerfilUsuario.idUsuario') == 34) 
				$this->request->data["Sap"]["SalesPersonCode"] = 7;
			//

			$tipoLineasDocumentoI = $this->request->data["Sap"]["DocumentLines"];

			$datosSap = array();
			$productosSapArr = array();
			$codigoPPTO = array();
			
			if (!empty($this->request->data["productos"])) {
				foreach ($this->request->data["productos"] as $idProducto) {
					if (isset($this->request->data["Sap"]["DocType"])){
						if(isset($tipoLineasDocumentoI[$this->request->data["Sap"]["DocType"]][$idProducto])) {
							if($this->request->data["Sap"]["DocType"] == 'dDocument_Items') {
								if($tipoLineasDocumentoI['dDocument_Items'][$idProducto]["ItemCode"] != ''){		//item sap seleccionado
									$productosSapArr[] = $tipoLineasDocumentoI['dDocument_Items'][$idProducto];
									if(isset($tipoLineasDocumentoI['dDocument_Items'][$idProducto]["U_codppto"])){
										$codigoPPTO[] = $tipoLineasDocumentoI['dDocument_Items'][$idProducto]["U_codppto"];
									}
								}
							} else {
								$productosSapArr[] = $tipoLineasDocumentoI[$this->request->data["Sap"]["DocType"]][$idProducto];	
							}
						}
					}
				}
			}			

			// saltos y lineas orden compra
			$lineasSapArr = array();

			if(isset($this->request->data["Sap"]["DocumentSpecialLines"]) && isset($this->request->data["Sap"]["DocType"])){
				if($this->request->data["Sap"]["DocType"] == 'dDocument_Items') {
					$tipoLineasDocumento = $this->request->data["Sap"]["DocumentSpecialLines"];					

					if (!empty($this->request->data["productos"])) {
						foreach ($this->request->data["productos"] as $idProducto) {						
							if (isset($this->request->data["Sap"]["DocType"])){	
								$tipoLineasDocumento[$idProducto]["AfterLineNumber"] = count($lineasSapArr);							
								if($tipoLineasDocumentoI['dDocument_Items'][$idProducto]["ItemCode"] != '') {		//item sap seleccionado
									$lineasSapArr[] = $tipoLineasDocumento[$idProducto];
								}							
							}
						}
					}

					$posPiePagina = count($lineasSapArr) - 1;				
					$tipoLineasDocumento["Text3"]["AfterLineNumber"] = $tipoLineasDocumento["Text4"]["AfterLineNumber"] = $tipoLineasDocumento["Text5"]["AfterLineNumber"] = $tipoLineasDocumento["Text6"]["AfterLineNumber"] = $posPiePagina;				
					array_unshift($lineasSapArr, $tipoLineasDocumento["Text1"], $tipoLineasDocumento["Text2"]);
					$tipoLineasDocumento["Text5"]["LineText"] = $tipoLineasDocumento["Text5"]["LineText"] . implode(";",array_unique($codigoPPTO));
					array_push($lineasSapArr, $tipoLineasDocumento["Text3"], $tipoLineasDocumento["Text4"], $tipoLineasDocumento["Text5"], $tipoLineasDocumento["Text6"]);
				}
			}

			$datosSap = $this->request->data["Sap"];
			$datosSap["DocumentLines"] = $productosSapArr;			
			$datosSap["DocumentSpecialLines"] = $lineasSapArr;				
							
			// registro en sap
			if($datosSap) {

				//archivos adjuntos
				$respuestaArchivo = "";
				if(isset($this->request->data["Sap"]["Attachments2_Lines"])) {
					
					$archivos = $this->request->data["Sap"]["Attachments2_Lines"];
					foreach ($archivos as $key => $archivo) {
						$srcFile = $this->request->data["Sap"]["Attachments2_Lines"][$key]["SourcePath"];
						//copia archivo
						if(file_exists($srcFile)) {
							copy($srcFile, SGI_ATTACH_DIR.DS.basename($srcFile));						
						}
						//valida copy mnt archivo
						if (!file_exists(SGI_ATTACH_DIR.DS.basename($srcFile))){
							$respuestaArchivo = $respuestaArchivo." OBS: No se pudo copiar archivo en ".SGI_ATTACH_DIR. ' ';
						}
						//asociar
						$this->request->data["Sap"]["Attachments2_Lines"][$key]["SourcePath"] = SAP_ATTACH_DIR;	
					}
					$archivosArr = array("Attachments2_Lines"=>$this->request->data["Sap"]["Attachments2_Lines"]);

					$archivoSap = $this->setFileSap($archivosArr);
					
					if (isset($archivoSap["AbsoluteEntry"]) ) {
						$datosSap["AttachmentEntry"] = $archivoSap["AbsoluteEntry"];
						unset($datosSap["Attachments2_Lines"]);
					} else {
						$respuestaArchivo = $respuestaArchivo." OBS: ".$archivoSap["message"]["value"];	
					}
				}
				//info
				$respuestaSap = $this->setDraftsSap($datosSap);
				if (isset($respuestaSap["DocEntry"])) {
					$respuesta = array( "exito" => true,
						"mensaje" => "SAP: Datos enviados correctamente.".$respuestaArchivo,
						"sap_doc_entry_id" => $respuestaSap["DocEntry"]);
				} else {
					$respuesta = array( "exito" => false,
						"mensaje" => "ERROR: ".$respuestaSap["message"]["value"].$respuestaArchivo);
				}				

				$envioSap = array(
					"compras_productos_totale_id" => $this->request->data["idRequerimiento"],
					"sap_envio" => json_encode($datosSap, JSON_HEX_APOS|JSON_HEX_QUOT),
					"sap_respuesta" => json_encode($respuestaSap, JSON_HEX_APOS|JSON_HEX_QUOT),
					"sap_doc_entry_id" => isset($respuestaSap["DocEntry"])?$respuestaSap["DocEntry"]:null,
					"sap_doc_num_id" => isset($respuestaSap["DocNum"])?$respuestaSap["DocNum"]:null,
					"user_id" => $this->Session->read('PerfilUsuario.idUsuario'),
				);

				$this->ComprasSapEnvio->save($envioSap);

			}
		}
		
		$this->set("respuesta", $respuesta);

	}
	


}
?>
