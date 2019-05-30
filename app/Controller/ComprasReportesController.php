<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');

class ComprasReportesController extends AppController
{
	public function lista_compras()
	{

		$this->layout = "ajax";
    	$this->response->type('json');
		
    	//$compras = json_encode(array('mensaje'=>'No tiene permiso para ver el Json'));
		
    	$this->loadModel("ComprasProductosTotale");
		$this->loadModel("ComprasFactura");
		$this->loadModel("ComprasEstado");
		$this->loadModel("Company");
		$this->loadModel("TiposDocumento");
		$this->loadModel("DimensionesCodigosCorto");
		

		$compras = $this->ComprasProductosTotale->find('all', array(
			"fields"=>array(
				"ComprasProductosTotale.id", 
				"ComprasProductosTotale.company_id", 
				"ComprasProductosTotale.titulo", 
				"ComprasProductosTotale.created", 
				"ComprasProductosTotale.total", 
				"ComprasProductosTotale.compras_estado_id",
				"ComprasProductosTotale.numero_sap",
				"ComprasProductosTotale.created",
			),
			'conditions'=>array(
				'ComprasProductosTotale.tipos_documento_id'=>array(17, 18),
				//'ComprasProductosTotale.tipos_documento_id'=>array(17, 18, 19, 20, 21, 22), 
				//'ComprasProductosTotale.compras_estado_id'=>array(6, 9)
			),
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
		$tiposDocumentosNombresLargo = "";
		
		foreach($tiposDocumentos as $tiposDocumento)
		{
			$tiposDocumentosNombres[$tiposDocumento["TiposDocumento"]["id"]] = $tiposDocumento["TiposDocumento"]["nombre"];
			#$tiposDocumentosNombres[$tiposDocumento["TiposDocumento"]["id"]] = substr($tiposDocumento["TiposDocumento"]["nombre"], 0,3);
			#$tiposDocumentosNombresLargo[$tiposDocumento["TiposDocumento"]["id"]] = $tiposDocumento["TiposDocumento"]["nombre"];
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
		
		foreach($empresas as $empresa)
		{
			$nombreEmpresas[$empresa["Company"]["id"]] = $empresa["Company"]["razon_social"];
			$rutEmpresas[$empresa["Company"]["id"]] = $empresa["Company"]["rut"];
			$idEmpresa[$empresa["Company"]["id"]] = $empresa["Company"]["id"];
		}


		$codigosCortos = $this->DimensionesCodigosCorto->find("all");

		$nombreCodigosCortos = "";
		foreach($codigosCortos as $codigosCorto)
		{
			$nombreCodigosCortos[$codigosCorto["DimensionesCodigosCorto"]["nombre"]] = $codigosCorto["DimensionesCodigosCorto"]["descripcion"];
		}

		


		$comprasJson = "";
		$codigosPresupuestarios = "";
		$detalleCodigoCorto = "";
		foreach($compras as $codigos)
		{
			foreach($codigos["ComprasProducto"] as $codigosProductos)
			{
				$codigo = explode("-", $codigosProductos["codigos_presupuestarios"]);
				$codigosPresupuestarios[$codigosProductos["compras_productos_totale_id"]][] = $codigosProductos["codigos_presupuestarios"];
				$detalleCodigoCorto[$codigosProductos["compras_productos_totale_id"]] = $nombreCodigosCortos[$codigo[0]];
				}
		}


		$buscaCompras = "";




		foreach($compras as $compra)
		{
			$buscaCompras[] = array(
				"Id"=>isset($compra["ComprasProductosTotale"]["id"]) ? $compra["ComprasProductosTotale"]["id"] : "",
				"Fecha" => date("d-m-Y", strtotime($compra["ComprasProductosTotale"]["created"])),
				"TipoDocumento"=>isset($facturaNumeroDocumento[$compra["ComprasProductosTotale"]["id"]]) ? $facturaNumeroDocumento[$compra["ComprasProductosTotale"]["id"]] : $compra["ComprasProductosTotale"]["id"],
				"Proveedor"=>isset($nombreEmpresas[$compra["ComprasProductosTotale"]["company_id"]]) ? $nombreEmpresas[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"EmpresaRut"=>isset($rutEmpresas[$compra["ComprasProductosTotale"]["company_id"]]) ? $rutEmpresas[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"EmpresaId"=>isset($idEmpresa[$compra["ComprasProductosTotale"]["company_id"]]) ? $idEmpresa[$compra["ComprasProductosTotale"]["company_id"]] : "",
				"DescripcionGasto"=>$compra["ComprasProductosTotale"]["titulo"],
				"IdEstado"=>isset($estadoId[$compra["ComprasProductosTotale"]["compras_estado_id"]]) ? $estadoId[$compra["ComprasProductosTotale"]["compras_estado_id"]] : "",
				"Fecha"=>date("d-m-Y", strtotime($compra["ComprasProductosTotale"]["created"])),
				"Total"=>number_format($compra["ComprasProductosTotale"]["total"], 0, '', '.'),
				"NumeroSap"=>isset($compra["ComprasProductosTotale"]["numero_sap"]) ? $compra["ComprasProductosTotale"]["numero_sap"] : "",
				"Neto"=>number_format($compra["ComprasProductosTotale"]["total"] / 1.19 , 0, '', '.'),
				#"NombreDocumento"=>(isset($tiposDocumentosNombresLargo[$compra["ComprasProductosTotale"]["id"]]) ? $tiposDocumentosNombresLargo[$compra["ComprasProductosTotale"]["id"]] : ""),
				//"CodigoPresupuestario" => implode(', ', array_unique($codigosPresupuestarios[$compra["ComprasProductosTotale"]["id"]])),
			);
		}

    	$this->set("comprasJson", $buscaCompras);
	}

	public function index()
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

		if($this->Session->read('Users.flag') == 1)
		{
			CakeLog::write('actividad', 'miro la pagina compras_reortes - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
		}
	}

	public function json_facturas_aprobadas()
	{
		$this->layout = "ajax";
    	$this->response->type('json');

		$this->loadModel("ComprasFactura");

		$facturas = $this->ComprasFactura->find("all", array(
			"conditions"=>array(
				"ComprasFactura.tipos_documento_id"=>array(17, 18, 19, 20, 21, 22),
				"ComprasProductosTotale.compras_estado_id"=>4,			
			),
			"fields"=>array(
				"ComprasFactura.id",
				"ComprasFactura.numero_documento",
				"ComprasFactura.compras_productos_totale_id",
				"TiposDocumento.nombre",
				"ComprasProductosTotale.company_id",
				"ComprasProductosTotale.total",
				"ComprasProductosTotale.modified",
				"ComprasProductosTotale.titulo",
				"ComprasProductosTotale.neto_descuento",
				"ComprasProductosTotale.id",
			)
		));


		$idEmpresas = "";
		$idComprasProductostotales = "";

		foreach($facturas as $datosEmpresasProductos)
		{
			$idEmpresas[$datosEmpresasProductos["ComprasProductosTotale"]["company_id"]] = $datosEmpresasProductos["ComprasProductosTotale"]["company_id"];
			$idComprasProductostotales[] = $datosEmpresasProductos["ComprasFactura"]["compras_productos_totale_id"];
		}

		if(!empty($facturas))
		{
			$this->loadModel("Company");

			$empresas = $this->Company->find("all", array(
				"conditions"=>array("Company.id"=>$idEmpresas),
				"fields"=>array("Company.id", "Company.nombre")
			));

			$nombreEmpresas = "";

			foreach($empresas as $empresa)
			{
				$nombreEmpresas[$empresa["Company"]["id"]] =  $empresa["Company"]["nombre"];
			}

			$this->loadModel("ComprasProducto");

			$productos = $this->ComprasProducto->find("all", array(
				"conditions"=>array("ComprasProducto.compras_productos_totale_id"=>$idComprasProductostotales),
				"fields"=>array(
					"ComprasProducto.id", 
					"ComprasProducto.descripcion", 
					"ComprasProducto.dim_uno", 
					"ComprasProducto.codigos_presupuestarios",
					"ComprasProducto.subtotal",
					"ComprasProducto.compras_productos_totale_id"
				),
				"recursive"=>-1
			));

			$productosArray = "";

			foreach($productos as $producto)
			{
				if(!empty($producto["ComprasProducto"]["compras_productos_totale_id"]) && !empty($producto["ComprasProducto"]["codigos_presupuestarios"]))
				{
					$productosArray[$producto["ComprasProducto"]["compras_productos_totale_id"]][] = $producto["ComprasProducto"]["codigos_presupuestarios"];
				}
			}

			$facturasAprobadasJson = "";

			foreach($facturas as $key => $factura)
			{
				$facturasAprobadasJson[] = array(
					"idCompraFactura" => (isset($factura["ComprasFactura"]["id"]) ? $factura["ComprasFactura"]["id"] : ""),
					"numeroFactura" => (isset($factura["ComprasFactura"]["numero_documento"]) ? $factura["ComprasFactura"]["numero_documento"] : ""),
					"idCompraProductoTotales" => (isset($factura["ComprasFactura"]["compras_productos_totale_id"]) ? $factura["ComprasFactura"]["compras_productos_totale_id"] : ""),
					"nombreDocumento" => (isset($factura["TiposDocumento"]["nombre"]) ? $factura["TiposDocumento"]["nombre"] : ""),
					"nombreEmpresa"=> (isset($nombreEmpresas[$factura["ComprasProductosTotale"]["company_id"]]) ? $nombreEmpresas[$factura["ComprasProductosTotale"]["company_id"]] : ""),
					"totalFactura"=>(isset($factura["ComprasProductosTotale"]["total"]) ? $factura["ComprasProductosTotale"]["total"] : $factura["ComprasProductosTotale"]["total"]),
					"fechaIngresoSap"=>(isset($factura["ComprasProductosTotale"]["modified"]) ? $factura["ComprasProductosTotale"]["modified"] : "") ,
					"titulo"=>(isset($factura["ComprasProductosTotale"]["titulo"]) ? $factura["ComprasProductosTotale"]["titulo"] : ""),
					"neto"=>(isset($factura["ComprasProductosTotale"]["neto_descuento"]) ? $factura["ComprasProductosTotale"]["neto_descuento"] : "") ,
					"total"=>(isset($factura["ComprasProductosTotale"]["total"]) ? $factura["ComprasProductosTotale"]["total"] : "") ,
					"productosAsociados"=>(isset($productosArray[$factura["ComprasFactura"]["compras_productos_totale_id"]]) ? implode(",", $productosArray[$factura["ComprasFactura"]["compras_productos_totale_id"]]) : "")
				);
			}
		}

		$this->set("facturasAprobadasJson", $facturasAprobadasJson);
	}

	public function presupuesto(){
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

		if($this->Session->read('Users.flag') == 1)
		{
			CakeLog::write('actividad', 'miro la pagina compras_reortes - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
		}
	}

	public function presupuesto_general(){
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

		if($this->Session->read('Users.flag') == 1)
		{
			CakeLog::write('actividad', 'miro la pagina compras_reortes - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
		}
	}

	public function datos_trabajador(){

		$this->loadModel("User");
		$this->loadModel("Trabajadore");

		$IDTrabajador = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
			"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>-1
			));		
		$datosTrabajador = $this->Trabajadore->find("all", array(
			"fields" => array(
				"Trabajadore.id", 
				"Trabajadore.nombre", 
				"Trabajadore.apellido_paterno", 
				"Gerencia.id",
				"Gerencia.nombre"
			),
			"conditions" => array( 
				"Trabajadore.id" => $IDTrabajador["User"]["trabajadore_id"]
			),
			"joins"=> array( 
				array(
					"table" => "areas", 
					"alias" => "Area", 
					"type" => "LEFT", 
					"conditions" => array(
						"Cargo.area_id = Area.id"
					)
				),
				array(
					"table" => "gerencias", 
					"alias" => "Gerencia", 
					"type" => "LEFT", 
					"conditions" => array(
						"Area.gerencia_id = Gerencia.id"
					)
				)
			),
			"recursive"=>0
			)
		);
		return $datosTrabajador;
	} 

	public function codigos_presupuestarios($anio, $conditions){
		$this->loadModel("CodigosPresupuesto");

		$codigosPresupuestos = $this->CodigosPresupuesto->find("all" , array(
			"fields" => array( 
				"CodigosPresupuesto.presupuesto_total", 
				"CodigosPresupuesto.codigo",
				"CodigosPresupuesto.nombre",
				'"CodigosPresupuesto"."presupuesto_enero" AS "CodigosPresupuesto__01"',
				'"CodigosPresupuesto"."presupuesto_febrero" AS "CodigosPresupuesto__02"',
				'"CodigosPresupuesto"."presupuesto_marzo" AS "CodigosPresupuesto__03"',
				'"CodigosPresupuesto"."presupuesto_abril" AS "CodigosPresupuesto__04"',
				'"CodigosPresupuesto"."presupuesto_mayo" AS "CodigosPresupuesto__05"',
				'"CodigosPresupuesto"."presupuesto_junio" AS "CodigosPresupuesto__06"',
				'"CodigosPresupuesto"."presupuesto_julio" AS "CodigosPresupuesto__07"',
				'"CodigosPresupuesto"."presupuesto_agosto" AS "CodigosPresupuesto__08"',
				'"CodigosPresupuesto"."presupuesto_septiembre" AS "CodigosPresupuesto__09"',
				'"CodigosPresupuesto"."presupuesto_octubre" AS "CodigosPresupuesto__10"',
				'"CodigosPresupuesto"."presupuesto_noviembre" AS "CodigosPresupuesto__11"',
				'"CodigosPresupuesto"."presupuesto_diciembre" AS "CodigosPresupuesto__12"'
				),
			"conditions"=>array( 
				$conditions,
				"CodigosPresupuesto.year_id"=> $anio,
				"CodigosPresupuesto.estado"=> 1				
				),
			"recursive"=>0,
			)
		);
		return $codigosPresupuestos;
	}

	public function codigos_presupuesto_grafico($anio, $conditions, $condEspecifica){
		$this->loadModel("CodigosPresupuesto");
		$codigosPresupuestos = $this->CodigosPresupuesto->find("all", array(
			"fields" => array( 				
				"CodigosPresupuesto.codigo",
				'"CodigosPresupuesto"."presupuesto_enero" AS "CodigosPresupuesto__01"',
				'"CodigosPresupuesto"."presupuesto_febrero" AS "CodigosPresupuesto__02"',
				'"CodigosPresupuesto"."presupuesto_marzo" AS "CodigosPresupuesto__03"',
				'"CodigosPresupuesto"."presupuesto_abril" AS "CodigosPresupuesto__04"',
				'"CodigosPresupuesto"."presupuesto_mayo" AS "CodigosPresupuesto__05"',
				'"CodigosPresupuesto"."presupuesto_junio" AS "CodigosPresupuesto__06"',
				'"CodigosPresupuesto"."presupuesto_julio" AS "CodigosPresupuesto__07"',
				'"CodigosPresupuesto"."presupuesto_agosto" AS "CodigosPresupuesto__08"',
				'"CodigosPresupuesto"."presupuesto_septiembre" AS "CodigosPresupuesto__09"',
				'"CodigosPresupuesto"."presupuesto_octubre" AS "CodigosPresupuesto__10"',
				'"CodigosPresupuesto"."presupuesto_noviembre" AS "CodigosPresupuesto__11"',
				'"CodigosPresupuesto"."presupuesto_diciembre" AS "CodigosPresupuesto__12"'
				),
			"conditions"=>array( 
				$conditions,
				"CodigosPresupuesto.year_id"=> $anio,
				"CodigosPresupuesto.estado"=> 1,
				$condEspecifica
			),
			"recursive"=>0
		));
		return $codigosPresupuestos;
	}

	public function compras_facturas($anio) {
		$this->loadModel("ComprasFactura");

		$facturas = $this->ComprasFactura->find("all", array(
			"fields"=>array(
				"ComprasFactura.id",
				"ComprasFactura.numero_documento",
				"ComprasFactura.compras_productos_totale_id",
				"ComprasFactura.created", 
				"ComprasFactura.fecha_documento",
				"ComprasFactura.requerimiento_id",
				"TiposDocumento.nombre",				
				"ComprasProductosTotale.company_id",
				"ComprasProductosTotale.titulo",
				"ComprasProductosTotale.tipo_cambio",
				"ComprasProductosTotale.id"
			),
			"conditions"=>array(
				"ComprasFactura.tipos_documento_id"=>array(17, 18, 19, 20, 21, 22),
				"ComprasProductosTotale.compras_estado_id"=>array(4,8),
				"TO_CHAR(ComprasFactura.created,'YYYY')"=> $anio,
				"ComprasFactura.numero_documento not in ('6829')"
			),			
			"order" => array(
				"ComprasFactura.fecha_documento", 
				"ComprasFactura.created"),
		));

		return $facturas;
	}

	public function compras_productos($anio, $totalesId, $conditions, $condGrafico){
		$this->loadModel("ComprasProducto");

		$detalleProductos = $this->ComprasProducto->find( "all", array( 
			"fields" => array(
				"ComprasProducto.descripcion", 
				"ComprasProducto.cantidad", 
				"ComprasProducto.codigos_presupuestarios", 
				"ComprasProducto.estado",
				"ComprasProducto.subtotal",
				"ComprasProducto.descuento_producto",
				"ComprasProducto.compras_productos_totale_id"
				),
			"conditions" => array( 		
				$conditions,
				"ComprasProducto.estado" => array(4,8), 
				"ComprasProductosTotale.compras_estado_id" => array(4,8),
				"ComprasProducto.compras_productos_totale_id" => $totalesId,
				array(
				"OR" => array(
					array("ComprasProducto.agno" => null),
					array("ComprasProducto.agno" => $anio)
					),					
				),
				$condGrafico
				),
			"order" => "ComprasProducto.codigos_presupuestarios ASC"
			)
		);
		return $detalleProductos;
	}

	public function presupuesto_json($anio = null, $general = null){

		$this->layout = "ajax";
    	$this->response->type('json');
		$this->loadModel("Year");
		$this->loadModel("DimensionesCodigosCorto");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("Company");
		$this->loadModel("PresupuestosFamilia");		
		$serv = new ServiciosController();

		$aniosListID = $this->CodigosPresupuesto->find("all", array(
			"fields" => array("DISTINCT CodigosPresupuesto.year_id"),
			"conditions"=>array("CodigosPresupuesto.estado"=> 1),
			"recursive"=>-1
			));
		
		$aniosListID 		 = Set::classicExtract($aniosListID,'{n}.CodigosPresupuesto.year_id');
		
		$anioPresupuestoList = $this->Year->find("all", array( "conditions"=>array("Year.id"=> $aniosListID ), "order"=> array("Year.nombre DESC")));
		
		$anioPresupuestoList = Set::classicExtract($anioPresupuestoList,'{n}.Year.nombre');
		/* metodo */
		
		$datosTrabajador 	 = $this->datos_trabajador();
		$gerenciaId 		 = Set::classicExtract($datosTrabajador, '{n}.Gerencia.id');
		$gerenciaNombre 	 = Set::classicExtract($datosTrabajador, '{n}.Gerencia.nombre');


		if($general){
			$conditionsGeneral = array();
		}else{
			$conditionsGeneral = array("DimensionesCodigosCorto.gerencia_id" => $gerenciaId);
		}
		$dimensionesProyectos = $this->DimensionesCodigosCorto->find("all", array(
			"fields" => array("DISTINCT DimensionesCodigosCorto.nombre"),
			"conditions" => $conditionsGeneral
			));	
		$conditionCodigo = array();
		foreach ($dimensionesProyectos as $codigoGerencia) 
		{ 
			$conditionCodigo[] = $codigoGerencia["DimensionesCodigosCorto"]["nombre"];	
		}
		if(count($conditionCodigo)>1)
		{
			$conditions = array("substr(CodigosPresupuesto.codigo, 0, 3) IN " => $conditionCodigo ); 			
		}
		else
		{
			$conditions = array("substr(CodigosPresupuesto.codigo, 0, 3) =" => $conditionCodigo[0] );
		}
		$anioPresupuesto 	 = $this->Year->find("all", array( "conditions"=>array("Year.nombre"=> ($anio)? $anio : $anio = date("Y")),	"recursive"=>-1	));
		/* metodo */
		$codigosPresupuestos = $this->codigos_presupuestarios($anioPresupuesto[0]["Year"]["id"], $conditions);

		$codigosPresupuestarios = array();
		$nombreCodigos = array();
		$familiaCodigoList 	= array();
		$codigoListUnico 	= array();
		foreach ($codigosPresupuestos as $codigo) {			
			$codigoCompleto 	= $codigo["CodigosPresupuesto"]["codigo"];
			unset($codigo["CodigosPresupuesto"]["codigo"]);
			$nombreCodigos[$codigoCompleto][] = $codigo["CodigosPresupuesto"]["nombre"];
			unset($codigo["CodigosPresupuesto"]["nombre"]);
			$codigosPresupuestarios[$codigoCompleto][] = $codigo["CodigosPresupuesto"];	

			$familiaArr 	= explode("-",$codigoCompleto);
			$familiaCodigo 	= implode("-",array_slice($familiaArr,0,count($familiaArr)-1));
			$familiaCodigoList[] 	= $familiaCodigo;
			$codigoList[$familiaCodigo][] 	 = $codigoCompleto;
			$codigoListUnico[$familiaCodigo] = array_unique($codigoList[$familiaCodigo]);
			array_splice($codigoListUnico[$familiaCodigo], 0, 0); 
		}

		foreach ($codigosPresupuestarios as $key => $cod) {	
			$final 	= array();		
			array_walk_recursive($cod, function($item, $key) use (&$final){ $final[$key] 	= isset($final[$key]) ? $item + $final[$key] : $item; });		// suma mensual por codigo presupuestario
			$presCodigo[$key] = $final;
		}
		//pr($presCodigo);exit;
		/* metodo */
		$facturas 	= $this->compras_facturas($anio);		
		$totalesId 	= Set::classicExtract($facturas,'{n}.ComprasFactura.compras_productos_totale_id');

		if(count($conditionCodigo)>1){
			$conditions = array("substr(ComprasProducto.codigos_presupuestarios, 0, 3) IN " => $conditionCodigo ); 			
		}else{
			$conditions = array("substr(ComprasProducto.codigos_presupuestarios, 0, 3) =" => $conditionCodigo[0] );
		}
		/* metodo */
		$detalleProductos 	= $this->compras_productos($anio, $totalesId, $conditions, array());


		foreach ($detalleProductos as $detalle) {
			$productosReqID[$detalle["ComprasProducto"]["compras_productos_totale_id"]][] = $detalle;
		}

		$nombreFamilia = $this->PresupuestosFamilia->find("list", array("fields"=> array("PresupuestosFamilia.codigo","PresupuestosFamilia.nombre"))); 
		$familiaCodigoListUnico = array_unique($familiaCodigoList);		
		array_splice($familiaCodigoListUnico, 0, 0);

		$nombreFamilias = array();
		foreach ($familiaCodigoListUnico as $fam) {
			$nombreFamilias[] = array( 
				"id" 	 => substr($fam, 3, 3),
				"codigo" => $fam,
				"nombre" => (array_key_exists(substr($fam, 3, 3), $nombreFamilia))? $fam.' - '.$nombreFamilia[substr($fam, 3, 3)] : $fam
				);
		}		
		if(!empty($nombreFamilias)){
			$nombreFamilias = $serv->sort_array_multidim( $nombreFamilias, "nombre ASC");
		}
		
		$empresas = $this->Company->find("list", array("fields"=>array("Company.razon_social")));
		$productos = array();

		foreach($facturas as $factura) {	

			$facturaId  = $factura["ComprasFactura"]["id"];
			$numeroDocumento = $factura["ComprasFactura"]["numero_documento"];
			$fechaFactura 	 = (isset($factura["ComprasFactura"]["fecha_documento"])) ? $factura["ComprasFactura"]["fecha_documento"] : $factura["ComprasFactura"]["created"];
			$reqId 		= $factura["ComprasProductosTotale"]["id"];
			$reqTitulo 	= $factura["ComprasProductosTotale"]["titulo"];
			$nomEmpresa = (isset($empresas[$factura["ComprasProductosTotale"]["company_id"]])) ? $empresas[$factura["ComprasProductosTotale"]["company_id"]] : '';
			$tipoDocumento = $factura["TiposDocumento"]["nombre"];
			$tipoCambio = (isset($factura["ComprasProductosTotale"]["tipo_cambio"])) ? $factura["ComprasProductosTotale"]["tipo_cambio"] : 1;

			if(array_key_exists($reqId, $productosReqID)){	

				foreach ($productosReqID[$reqId] as $producto) {	

						$familiaArr = explode("-",$producto["ComprasProducto"]["codigos_presupuestarios"]);
						$familiaCodigo = implode("-",array_slice($familiaArr,0,count($familiaArr)-1));
						$nomFamilia = (array_key_exists(substr($familiaCodigo, 3, 3), $nombreFamilia))? $nombreFamilia[substr($familiaCodigo, 3, 3)] : '';
						$fechaDocumento = substr($fechaFactura, 0, 10);

						$productos[] = array(
							"factura_id" 		=> $facturaId,
							"requerimiento" 	=> $reqTitulo,
							"empresa" 			=> $nomEmpresa,
							"tipo_documento" 	=> $tipoDocumento,
							"nro_documento" 	=> $numeroDocumento,
							"nombre_producto" 	=> $producto["ComprasProducto"]["descripcion"],
							"cantidad_producto" => $producto["ComprasProducto"]["cantidad"],
							"familia_nombre" 	=> $nomFamilia,
							"familia_codigo" 	=> $familiaCodigo,
							"codigo_presupuesto"=> $producto["ComprasProducto"]["codigos_presupuestarios"],
							"fecha_documento" 	=> $fechaDocumento,
							"fecha_factura" 	=>	 $fechaFactura,
							"subtotal" 			=> round( ($producto["ComprasProducto"]["subtotal"] - $producto["ComprasProducto"]["descuento_producto"]) * $tipoCambio),
						);
				}
			}
		}
		
		if(!empty($productos)){
			$productos 	= $serv->sort_array_multidim( $productos, "familia_codigo ASC, codigo_presupuesto ASC, fecha_factura ASC");
			// presupuesto - gastos
			foreach ($productos as $detalle) {
				$mes 	= date("m",strtotime($detalle["fecha_documento"]));
				if(array_key_exists($detalle["codigo_presupuesto"], $presCodigo)){

					$productosFinal[] = array_merge( 
						$detalle,
						array( "presupuesto" => $presCodigo[$detalle["codigo_presupuesto"]][$mes],
							"saldo" 		=> $presCodigo[$detalle["codigo_presupuesto"]][$mes] - $detalle["subtotal"],
							"presupuesto_anual" => $presCodigo[$detalle["codigo_presupuesto"]]["presupuesto_total"],
							"saldo_anual" 	=> $presCodigo[$detalle["codigo_presupuesto"]]["presupuesto_total"] - $detalle["subtotal"],
						)
					);
					$presCodigo[$detalle["codigo_presupuesto"]][$mes] = $presCodigo[$detalle["codigo_presupuesto"]][$mes] - $detalle["subtotal"];
					$presCodigo[$detalle["codigo_presupuesto"]]["presupuesto_total"] = $presCodigo[$detalle["codigo_presupuesto"]]["presupuesto_total"] - $detalle["subtotal"];
				}else{
					$noExisten[] = $detalle;
				}
			}
		}else{
			$productosFinal = array();
		}		

		$data = array(
			"productosFinal" 	=> $productosFinal,
			"anioPresupuestoList" => $anioPresupuestoList,
			"familiaList" 	=> $nombreFamilias,
			"codigoList" 	=> $codigoListUnico,
			"gerenciaNombre" => $serv->capitalize($gerenciaNombre[0]),
			"nombreCodigo" 	=> $nombreCodigos 
			);

		$this->set("detallePresupuesto", $data);
	}

	public function grafico_presupuesto_json(){			
		$this->layout = "ajax";
    	$this->response->type('json');
		$this->loadModel("Year");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("ComprasFactura");
		$this->loadModel("ComprasProducto");
		$this->loadModel("Company");
		$this->loadModel("DimensionesCodigosCorto");
		$serv = new ServiciosController();

		$anio 			= $this->request->query["anioPresupuesto"];
		$famPresupuesto = $this->request->query["famPresupuesto"];
		$codPresupuesto = $this->request->query["codPresupuesto"];
		$general 		= $this->request->query["general"];
		$datosTrabajador 	= $this->datos_trabajador();
		$gerenciaId 		= Set::classicExtract($datosTrabajador, '{n}.Gerencia.id');
		$gerenciaNombre 	= Set::classicExtract($datosTrabajador, '{n}.Gerencia.nombre');
		$anioPresupuesto 	= $this->Year->find("all", array( "conditions"=>array("Year.nombre"=> ($anio)? $anio : $anio = date("Y")), "recursive"=>-1 ));

		if($general){
			$conditionsGeneral = array();
		}else{
			$conditionsGeneral = array("DimensionesCodigosCorto.gerencia_id" => $gerenciaId);
		}
		$dimensionesProyectos = $this->DimensionesCodigosCorto->find("all", array(
			"fields" => array("DISTINCT DimensionesCodigosCorto.nombre"),
			"conditions" => $conditionsGeneral
			));

		$conditionCodigo = array();
		foreach ($dimensionesProyectos as $codigoGerencia) { 
			$conditionCodigo[] = $codigoGerencia["DimensionesCodigosCorto"]["nombre"];	
		}
		if(count($conditionCodigo)>1){
			$conditions = array("substr(CodigosPresupuesto.codigo, 0, 3) IN " => $conditionCodigo ); 			
		}else{
			$conditions = array("substr(CodigosPresupuesto.codigo, 0, 3) =" => $conditionCodigo[0] );
		}				
		if($codPresupuesto)
		{ 
			$famPresupuesto = 0; 
		}
		$conditionEspecifica = array(
			array(
				"OR" => array(
					array("substr(CodigosPresupuesto.codigo, 0, 7) = '$famPresupuesto'" ),
					array("'$famPresupuesto'='0'")						
				),
			),
			array(	
				"OR" => array(
					array("CodigosPresupuesto.codigo = '$codPresupuesto'" ),
					array("'$codPresupuesto'='0'")						
				)
			));
		/* metodo */ 
		$codigosPresupuestos = $this->codigos_presupuesto_grafico($anioPresupuesto[0]["Year"]["id"], $conditions, $conditionEspecifica);		

		$codigosPresupuestarios = array();
		foreach ($codigosPresupuestos as $codigo) {			
			$codigoCompleto = $codigo["CodigosPresupuesto"]["codigo"];
			unset($codigo["CodigosPresupuesto"]["codigo"]);			
			$codigosPresupuestarios[$codigoCompleto][] = $codigo["CodigosPresupuesto"];
		}

		// suma mensual por codigo presupuestario (codigos repetidos)
		$presCodigo = array();
		foreach ($codigosPresupuestarios as $key => $cod) {	
			$final 	= array();		
			array_walk_recursive($cod, function($item, $key) use (&$final){ $final[$key] = isset($final[$key]) ? $item + $final[$key] : $item; });
			$presCodigo[$key] = $final;
		}

		// suma presupuesto mes familia codigo
		$presupuestoMensual = array();
		if($codPresupuesto){
			ksort($presCodigo[$codPresupuesto]);
			$presupuestoMensual = array_map('floatval',explode(",", implode(",",$presCodigo[$codPresupuesto]))); 
			
		}else{			
			for ($i=1; $i <= 12 ; $i++) {
				$indexMes = substr(('0'.$i),-2);
				$presupuestoMensual[$indexMes] = 0;
				foreach ($presCodigo as  $preMensual) {
					$presupuestoMensual[$indexMes] += $preMensual[$indexMes];
				}
			}
			ksort($presupuestoMensual);
			$presupuestoMensual = array_map('floatval',explode(",", implode(",",$presupuestoMensual)));			
		}
		
		$empresas 	= $this->Company->find("list", array("fields"=>array("Company.nombre")));
		/* metodo */ 
		$facturas 	= $this->compras_facturas($anio);
		$totalesId 	= Set::classicExtract($facturas,'{n}.ComprasFactura.compras_productos_totale_id');			

		if(count($conditionCodigo)>1){
			$conditions = array("substr(ComprasProducto.codigos_presupuestarios, 0, 3) IN " => $conditionCodigo ); 			
		}else{
			$conditions = array("substr(ComprasProducto.codigos_presupuestarios, 0, 3) =" => $conditionCodigo[0] );
		}
		$condGrafico = array(
			array(
				"OR" => array(
						array("substr(ComprasProducto.codigos_presupuestarios, 0, 7) = '$famPresupuesto'" ),
						array("'$famPresupuesto'='0'")						
					),
				),
			array(	
				"OR" => array(
						array("ComprasProducto.codigos_presupuestarios = '$codPresupuesto'" ),
						array("'$codPresupuesto'='0'")
					)				
				)
			);
		/* metodo */
		$productosReqID = array();
		$detalleProductos = $this->compras_productos($anio, $totalesId, $conditions, $condGrafico);
		foreach ($detalleProductos as $detalle) {			
			$productosReqID[$detalle["ComprasProducto"]["compras_productos_totale_id"]][] = $detalle;
		}

		$productos 	= array();
		foreach($facturas as $factura) {	

			$fechaFactura = (isset($factura["ComprasFactura"]["fecha_documento"])) ? $factura["ComprasFactura"]["fecha_documento"] : $factura["ComprasFactura"]["created"];
			$reqId 		  = $factura["ComprasProductosTotale"]["id"];			
			$tipoCambio   = (isset($factura["ComprasProductosTotale"]["tipo_cambio"])) ? $factura["ComprasProductosTotale"]["tipo_cambio"] : 1;			
			
			if(array_key_exists($reqId, $productosReqID)){
				foreach ($productosReqID[$reqId] as $producto) {

					$familiaArr 	= explode("-",$producto["ComprasProducto"]["codigos_presupuestarios"]);
					$familiaCodigo 	= implode("-",array_slice($familiaArr,0,count($familiaArr)-1));
					$fechaDocumento = substr($fechaFactura, 0, 10);					
					$mesGasto 	= date("m",strtotime(date($fechaDocumento)));	
					$productos[$mesGasto][] = round( ($producto["ComprasProducto"]["subtotal"] - $producto["ComprasProducto"]["descuento_producto"]) * $tipoCambio);
				}
			}
		}
		for ($i=1; $i <= 12 ; $i++) { 
			$indexMes = substr(('0'.$i),-2);
			if(array_key_exists($indexMes, $productos))
				$gastosPorMes[$indexMes] = array_sum($productos[$indexMes]);
			else
				$gastosPorMes[$indexMes] = 0;
		}

		ksort($gastosPorMes);
		$gastosPorMes 	= array_map('floatval',explode(",", implode(",",$gastosPorMes)));
		$xAxisMeses 	= array("Ene","Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
		
		$series = array(array("name"=> "Presupuesto","data"=>$presupuestoMensual),
			array("name"=> "Gastos", "data"=>$gastosPorMes)
			);

		$graficoPresupuesto = array(
			"gerencia" 	=> $serv->capitalize($gerenciaNombre[0]),
			"xAxis" 	=> $xAxisMeses,
			"series" 	=> $series
			);	

		$this->set("detalleGraficos", $graficoPresupuesto);
	}
}
