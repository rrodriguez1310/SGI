<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('CakeNumber', 'Utility');
/**
 * SolicitudRequerimientoViaticos Controller
 *
 * @property SolicitudRequerimientoViatico $SolicitudRequerimientoViatico
 * @property PaginatorComponent $Paginator
 */
class SolicitudRequerimientoViaticosController extends AppController {

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
	public function index() {
		$this->layout='angular';
	}

	public function lista_area(){
		$this->layout='angular';
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

	public function lista_finanza(){
		$this->layout='angular';
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

	public function lista_todos(){
		$this->layout='angular';
	}



	public function lista_viaticos(){
	//	$this->layout=null;


	//Configure::write('debug',2); 
		
		$this->loadModel("TiposMoneda");
		$this->loadModel("SolicitudRequerimientoViatico");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("ComprasTarjetasObservacion");
		$this->loadModel("SolicitudesRequerimiento");
		$this->loadModel("MontosFondoFijo");
		$path= $this->request->query;
	
		
			switch ($path['modulo']) {
				case "lista_viaticos":
					//echo "carga Mis Viaticos";
					$listaRendicionViaticos = $this->SolicitudRequerimientoViatico->find('all', array(
						'conditions'=>array('SolicitudRequerimientoViatico.id_usuario' => $this->Session->read('PerfilUsuario.idUsuario'), 'SolicitudRequerimientoViatico.estado_viatico' => 1)
					));
					//pr($listaRendicionViaticos);
					break;
				case "area":
					//echo "carga viaticos area";
					$listaRendicionViaticos = $this->SolicitudRequerimientoViatico->find('all', array(
						'conditions'=>array('SolicitudRequerimientoViatico.compras_tarjeta_estado_id' => 3, 'SolicitudRequerimientoViatico.estado_viatico' => 1)
					));
					//pr($listaRendicionViaticos);
					break;
				case "finanza":
					//echo "carga viaticos finanza";
					$listaRendicionViaticos = $this->SolicitudRequerimientoViatico->find('all', array(
						'conditions'=>array('SolicitudRequerimientoViatico.compras_tarjeta_estado_id' => 1, 'SolicitudRequerimientoViatico.estado_viatico' => 1)
					));
					///pr($listaRendicionViaticos);
					break;
				case "todos":
					//echo "carga todos los viaticos";
					$listaRendicionViaticos = $this->SolicitudRequerimientoViatico->find('all', array(
						'conditions'=>array('SolicitudRequerimientoViatico.estado_viatico' => 1)
					));
					//pr($listaRendicionViaticos);
					break;	

					
			}
		if(!empty($listaRendicionViaticos)){
			
			$currency = array(
				'places' => 0,
				//'before' => '$',
				'escape' => false,
				//'decimals' => '.',
				'thousands' => '.'
			);

			$salida = "";
			foreach($listaRendicionViaticos as $listaRendicionViatico){	

				/*$nombrelUser = $this->User->find('first', array(
					'conditions'=>array('User.id' => $listaRendicionViatico['SolicitudRequerimientoViatico']['id_usuario'])
				));*/

			//	print_r($listaRendicionViatico['SolicitudRequerimientoViatico']);
			//	exit;
				
				$nombreMoneda = $this->TiposMoneda->find('first', array(
					'conditions'=>array('TiposMoneda.id'=> $listaRendicionViatico['SolicitudRequerimientoViatico']['tipo_moneda'] )
				));
				$estadoSolicitud = $this->ComprasTarjetasEstado->find('first', array(
					'conditions'=>array('ComprasTarjetasEstado.id'=> $listaRendicionViatico['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id'] )
				));

				//pr($estadoSolicitud );
				//exit;

				$salida[] = array(
					'id'=> $listaRendicionViatico['SolicitudRequerimientoViatico']['id'],
					'responsable' => $listaRendicionViatico['SolicitudRequerimientoViatico']['responsable'],
					'fecha_inicio'=>$listaRendicionViatico['SolicitudRequerimientoViatico']['fecha_inicio'],
					'hora_inicio'=> $listaRendicionViatico['SolicitudRequerimientoViatico']['hora_inicio'],
					'fecha_termino'=> $listaRendicionViatico['SolicitudRequerimientoViatico']['fecha_termino'],
					'hora_termino'=>$listaRendicionViatico['SolicitudRequerimientoViatico']['hora_termino'],
					'moneda'=> $nombreMoneda['TiposMoneda']['nombre'],
					'total'=> number_format($listaRendicionViatico['SolicitudRequerimientoViatico']['total'],0,",","."),
					'titulo'=> $listaRendicionViatico['SolicitudRequerimientoViatico']['titulo'],
					'estado'=>$estadoSolicitud['ComprasTarjetasEstado']['descripcion']
				);
			}
			echo json_encode($salida);
			exit;
		}else{
			echo  json_encode(array());
		}
		exit;
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->layout='angular';
		$this->loadModel("SolicitudDetalleViatico");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("TiposMoneda");
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

		$listaViaticos = $this->SolicitudRequerimientoViatico->find('first',array(
			'conditions'=>array('SolicitudRequerimientoViatico.id' => $id)
		));

	
		$nombrelUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $listaViaticos['SolicitudRequerimientoViatico']['id_usuario'])
		));
	
		$estado = $this->ComprasTarjetasEstado->find('first', array(
			'conditions'=>array('ComprasTarjetasEstado.id'=> $listaViaticos['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id'])
		));
		
		$listaDetalleViatico= $this->SolicitudDetalleViatico->find('all', array(
			'conditions'=>array('SolicitudDetalleViatico.id_solicitudes_rendicion_viatico'=> $listaViaticos['SolicitudRequerimientoViatico']['id'] )
		));

		//echo $listaViaticos['SolicitudRequerimientoViatico']['estado'];
		//exit;
			
		switch ($listaViaticos['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id']){
			case 3:
				$select = array(1,5);
				break;

			case 1:
				$select = array(4,7);
				break;	
		}
		
		$listaEstado = $this->ComprasTarjetasEstado->find('list', array(
			'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
			'conditions'=>array('ComprasTarjetasEstado.id'=>$select )
		));
		$nombreMoneda = $this->TiposMoneda->find('first', array(
			'conditions'=>array('TiposMoneda.id'=> $listaViaticos['SolicitudRequerimientoViatico']['tipo_moneda'] )
		));

		//pr($listaDetalleViatico);
		//exit;
		$total = 0;
		foreach($listaDetalleViatico as $viatico){
			$total = $total + $viatico['SolicitudDetalleViatico']['monto'];
		}
		//exit;
            
		$currency = array(
            'places' => 0,
            //'before' => '$',
            'escape' => false,
            //'decimals' => '.',
            'thousands' => '.'
        );
        
        
        
        $url = "http://192.168.1.37/fixture_partidos/lista_fixtures_json";
        $contents = file_get_contents($url);
        $data = json_decode($contents, true);
        
		$data = array("datosViatico"=>array(
			"titulo"=>$listaViaticos['SolicitudRequerimientoViatico']['titulo'],
			"url_documento"=>$listaViaticos['SolicitudRequerimientoViatico']['url_documento'],
			"total"=>CakeNumber::format($total, $currency),
			"estado"=> $estado['ComprasTarjetasEstado']['descripcion'],
			"usuario"=>$nombrelUser['User']['nombre'],
			"moneda"=>$nombreMoneda['TiposMoneda']['nombre'],
			"id"=>$listaViaticos['SolicitudRequerimientoViatico']['id'],
			"fecha_inicio"=>$listaViaticos['SolicitudRequerimientoViatico']['fecha_inicio'],
			"fecha_termino"=>$listaViaticos['SolicitudRequerimientoViatico']['fecha_termino'],
			"observacion"=>$listaViaticos['SolicitudRequerimientoViatico']['observacion'],
			'programacion_partido'=>  $listaViaticos['SolicitudRequerimientoViatico']['produccion_partido_id'] === 0 ? '-' : $data[ $listaViaticos['SolicitudRequerimientoViatico']['produccion_partido_id'] ]

		),

		"listaDetalle"=>$listaDetalleViatico,
		"estados"=>$listaEstado,
		"area"=>$listaViaticos['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id']);

		//pr($data);
		//exit;

		$this->set('data', $data);
	}


	public function mis_view($id = null) {
		$this->layout='angular';
		$this->loadModel("SolicitudDetalleViatico");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("TiposMoneda");

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

		$listaViaticos = $this->SolicitudRequerimientoViatico->find('first',array(
			'conditions'=>array('SolicitudRequerimientoViatico.id' => $id)
		));

	
		$nombrelUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $listaViaticos['SolicitudRequerimientoViatico']['id_usuario'])
		));
	
		$estado = $this->ComprasTarjetasEstado->find('first', array(
			'conditions'=>array('ComprasTarjetasEstado.id'=> $listaViaticos['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id'])
		));
		
		$listaDetalleViatico= $this->SolicitudDetalleViatico->find('all', array(
			'conditions'=>array('SolicitudDetalleViatico.id_solicitudes_rendicion_viatico'=> $listaViaticos['SolicitudRequerimientoViatico']['id'] )
		));

		//echo $listaViaticos['SolicitudRequerimientoViatico']['estado'];
		//exit;
			
		switch ($listaViaticos['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id']){
			case 3:
				$select = array(1,5);
				break;

			case 1:
				$select = array(4,7);
				break;	
		}
		
		$listaEstado = $this->ComprasTarjetasEstado->find('list', array(
			'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
			'conditions'=>array('ComprasTarjetasEstado.id'=>$select )
		));
		$nombreMoneda = $this->TiposMoneda->find('first', array(
			'conditions'=>array('TiposMoneda.id'=> $listaViaticos['SolicitudRequerimientoViatico']['tipo_moneda'] )
		));

        $url = "http://192.168.1.37/fixture_partidos/lista_fixtures_json";
        $contents = file_get_contents($url);
        $data = json_decode($contents, true);
        
		$data = array("datosViatico"=>array(
			"titulo"=>$listaViaticos['SolicitudRequerimientoViatico']['titulo'],
			"url_documento"=>$listaViaticos['SolicitudRequerimientoViatico']['url_documento'],
			"total"=>$listaViaticos['SolicitudRequerimientoViatico']['total'],
			"estado"=> $estado['ComprasTarjetasEstado']['descripcion'],
			"usuario"=>$nombrelUser['User']['nombre'],
			"moneda"=>$nombreMoneda['TiposMoneda']['nombre'],
			"id"=>$listaViaticos['SolicitudRequerimientoViatico']['id'],
			"observacion"=>$listaViaticos['SolicitudRequerimientoViatico']['observacion'],
			"fecha_inicio"=>$listaViaticos['SolicitudRequerimientoViatico']['fecha_inicio'],
			"fecha_termino"=>$listaViaticos['SolicitudRequerimientoViatico']['fecha_termino'],
			"n_documento"=>$listaViaticos['SolicitudRequerimientoViatico']['n_documento'],
			'programacion_partido'=>  $listaViaticos['SolicitudRequerimientoViatico']['produccion_partido_id'] === 0 ? '-' : $data[ $listaViaticos['SolicitudRequerimientoViatico']['produccion_partido_id'] ]
			

		),
		"listaDetalle"=>$listaDetalleViatico,
		"estados"=>$listaEstado,
		"area"=>$listaViaticos['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id']);

		$this->set('data', $data);
	}


	public function list_view($id = null) {
		$this->layout='angular';
		$this->loadModel("SolicitudDetalleViatico");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("TiposMoneda");

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

		$listaViaticos = $this->SolicitudRequerimientoViatico->find('first',array(
			'conditions'=>array('SolicitudRequerimientoViatico.id' => $id)
		));

	
		$nombrelUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $listaViaticos['SolicitudRequerimientoViatico']['id_usuario'])
		));
	
		$estado = $this->ComprasTarjetasEstado->find('first', array(
			'conditions'=>array('ComprasTarjetasEstado.id'=> $listaViaticos['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id'])
		));
		
		$listaDetalleViatico= $this->SolicitudDetalleViatico->find('all', array(
			'conditions'=>array('SolicitudDetalleViatico.id_solicitudes_rendicion_viatico'=> $listaViaticos['SolicitudRequerimientoViatico']['id'] )
		));

		//echo $listaViaticos['SolicitudRequerimientoViatico']['estado'];
		//exit;
			
		switch ($listaViaticos['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id']){
			case 3:
				$select = array(1,5);
				break;

			case 1:
				$select = array(4,7);
				break;	
		}
		
		$listaEstado = $this->ComprasTarjetasEstado->find('list', array(
			'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion'),
			'conditions'=>array('ComprasTarjetasEstado.id'=>$select )
		));
		$nombreMoneda = $this->TiposMoneda->find('first', array(
			'conditions'=>array('TiposMoneda.id'=> $listaViaticos['SolicitudRequerimientoViatico']['tipo_moneda'] )
		));
        
        $url = "http://192.168.1.37/fixture_partidos/lista_fixtures_json";
        $contents = file_get_contents($url);
        $data = json_decode($contents, true);

		$data = array("datosViatico"=>array(
			"titulo"=>$listaViaticos['SolicitudRequerimientoViatico']['titulo'],
			"url_documento"=>$listaViaticos['SolicitudRequerimientoViatico']['url_documento'],
			"total"=>$listaViaticos['SolicitudRequerimientoViatico']['total'],
			"estado"=> $estado['ComprasTarjetasEstado']['descripcion'],
			"usuario"=>$nombrelUser['User']['nombre'],
			"moneda"=>$nombreMoneda['TiposMoneda']['nombre'],
			"id"=>$listaViaticos['SolicitudRequerimientoViatico']['id'],
			"observacion"=>$listaViaticos['SolicitudRequerimientoViatico']['observacion'],
			"fecha_inicio"=>$listaViaticos['SolicitudRequerimientoViatico']['fecha_inicio'],
			"fecha_termino"=>$listaViaticos['SolicitudRequerimientoViatico']['fecha_termino'],
			"n_documento"=>$listaViaticos['SolicitudRequerimientoViatico']['n_documento'],
			'programacion_partido'=>  $listaViaticos['SolicitudRequerimientoViatico']['produccion_partido_id'] === 0 ? '-' : $data[ $listaViaticos['SolicitudRequerimientoViatico']['produccion_partido_id'] ]

		),
		"listaDetalle"=>$listaDetalleViatico,
		"estados"=>$listaEstado,
		"area"=>$listaViaticos['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id']);

		$this->set('data', $data);
	}




	public function add_viaticos() {
        Configure::write('debug', 2);
		$this->autoRender = false;
		$this->loadModel("TiposMoneda");
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("SolicitudDetalleViatico");
		
    
        
        

		$vacio = array(""=>"");
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));

		$this->set('tipoMonedas', $tipoMonedas);

		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));

		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}

		$dimensionesProyectos = $this->DimensionesProyecto->find("all");

		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);

		$dimensiones = $this->Dimensione->find("all", array());

		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{

				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}
	
		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{

			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}
		$dimensionUno[0] = $vacio;
		ksort($dimensionUno);
		$this->set("dimensionUno", $dimensionUno);

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
		//array_unshift($dimensionDos, $vacio);
		$dimensionDos[0] = $vacio;
		ksort($dimensionDos);
		$this->set("dimensionDos", $dimensionDos);

		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		//array_unshift($dimensionTres, $vacio);
		$dimensionTres[0] = $vacio;
		ksort($dimensionTres);
		$this->set("dimensionTres", $dimensionTres);

		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		//array_unshift($dimensionCuatro, $vacio);
		$dimensionCuatro[0] = $vacio;
		ksort($dimensionCuatro);
		$this->set("dimensionCuatro", $dimensionCuatro);

		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		//array_unshift($dimensionCinco, $vacio);
		$dimensionCinco[0] = $vacio;
		ksort($dimensionCinco);
		$this->set("dimensionCinco", $dimensionCinco);

		$proveedores = $this->Company->find("list", array(
			"fields"=>array("Company.id", "Company.razon_social")
		));

		if(!empty($proveedores))
		{
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);   
		}
		$rutasDoc = array();
		if ($this->request->is('post')) {
			if(count($this->request['form']['file']['name'])>0){
				$destino = WWW_ROOT.'files'.DS.'solicitudFondos'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');		 
				if (!file_exists($destino))
				{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}

				for($i=0;$i<count($this->request['form']['file']['name']);$i++){
					$url = $destino . DS .$this->request['form']['file']['name'][$i];
					move_uploaded_file($this->request['form']['file']['tmp_name'][$i], $url);
					array_push($rutasDoc, $url);
				}
			}
			$datosFondosFolmulario = json_decode($this->request->data['rendicion']);
			
			$this->request->data['SolicitudRequerimientoViatico']['fecha_inicio'] = $datosFondosFolmulario->fecha_inicio;
			$this->request->data['SolicitudRequerimientoViatico']['fecha_termino'] = $datosFondosFolmulario->fecha_termino;
			$this->request->data['SolicitudRequerimientoViatico']['hora_inicio'] = isset($datosFondosFolmulario->hora_inicio)?$datosFondosFolmulario->hora_inicio:'S/N';
			$this->request->data['SolicitudRequerimientoViatico']['hora_termino'] = isset($datosFondosFolmulario->hora_termino)?$datosFondosFolmulario->hora_termino:'S/N';
			$this->request->data['SolicitudRequerimientoViatico']['titulo'] = $datosFondosFolmulario->titulo;
			$this->request->data['SolicitudRequerimientoViatico']['responsable'] = $datosFondosFolmulario->responsable;
			$this->request->data['SolicitudRequerimientoViatico']['tipo_moneda'] = isset($datosFondosFolmulario->tipo_moneda_id)?$datosFondosFolmulario->tipo_moneda_id:1;
			$this->request->data['SolicitudRequerimientoViatico']['url_documento'] = implode(",", $rutasDoc);
			$this->request->data['SolicitudRequerimientoViatico']['observacion'] = isset($datosFondosFolmulario->observacion)?$datosFondosFolmulario->observacion:'S/N';
			$this->request->data['SolicitudRequerimientoViatico']['total'] = str_replace(".","",$this->request->data['total']);
			$this->request->data['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id']= 3;
			$this->request->data['SolicitudRequerimientoViatico']['estado_viatico']= 1;
			$this->request->data['SolicitudRequerimientoViatico']['produccion_partido_id'] = isset($datosFondosFolmulario->produccion_partido_id)?$datosFondosFolmulario->produccion_partido_id : 0;
            
            
			$this->request->data['SolicitudRequerimientoViatico']['id_usuario']= $this->Session->read('PerfilUsuario.idUsuario');
            
            echo $this->request->data['SolicitudRequerimientoViatico']['produccion_partido_id'];
            
			if ($this->SolicitudRequerimientoViatico->save($this->request->data['SolicitudRequerimientoViatico'])) {
				$this->Session->setFlash('Rendicion agregada.', 'msg_exito');
			} else {
				$this->Session->setFlash('Problemas al Ingresar','msg_fallo');
			}

			$listaSolicituides = json_decode($this->request->data['lista']);
			for($i=0;$i<count($listaSolicituides);$i++){
				$this->SolicitudDetalleViatico->create();
						$this->request->data['SolicitudDetalleViatico']['colaborador'] = $listaSolicituides[$i]->colaborador;
						$this->request->data['SolicitudDetalleViatico']['monto'] = str_replace(".","",$listaSolicituides[$i]->monto);
						$this->request->data['SolicitudDetalleViatico']['gerencia'] = $listaSolicituides[$i]->gerencia;
						$this->request->data['SolicitudDetalleViatico']['estadio'] = $listaSolicituides[$i]->estadio;
						$this->request->data['SolicitudDetalleViatico']['contenido'] = $listaSolicituides[$i]->contenido;
						$this->request->data['SolicitudDetalleViatico']['canales_distribucion'] = $listaSolicituides[$i]->canales_distribucion;
						$this->request->data['SolicitudDetalleViatico']['otros'] = $listaSolicituides[$i]->otros;
						$this->request->data['SolicitudDetalleViatico']['proyectos'] = $listaSolicituides[$i]->proyectos;
						$this->request->data['SolicitudDetalleViatico']['codigo_presupuestario'] = $listaSolicituides[$i]->codigo_presupuestario;
						$this->request->data['SolicitudDetalleViatico']['descripcion'] = $listaSolicituides[$i]->descripcion;
						$this->request->data['SolicitudDetalleViatico']['id_solicitudes_rendicion_viatico'] = $this->SolicitudRequerimientoViatico->getInsertID();
						
				if ($this->SolicitudDetalleViatico->save($this->request->data['SolicitudDetalleViatico'])) {
					$this->Session->setFlash('Detalle Rendicion agregada.','msg_exito');
					
					CakeLog::write('actividad', 'Agrega solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				} else {
					
					$this->Session->setFlash('Problemas al ingresar','msg_fallo');
				}
			}
		}
		//exit;
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        Configure::write('debug', 2);
       // exit;
		$this->layout = 'angular';
		$this->loadModel("TiposMoneda");
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("SolicitudDetalleViatico");
		$this->loadModel("ProduccionPartido");
		
		$url = "http://192.168.1.37/fixture_partidos/lista_fixtures_json";
        $contents = file_get_contents($url);
        $data = json_decode($contents, true);
        $ListMatchJson = '';
        
        foreach($data as $value){
            $ListMatchJson[$value['id']] = $value['fecha_partido'] . ' - ' . $value['equipo_local'] . ' - ' .$value['equipo_visita'];
        }
        array_unshift($ListMatchJson, " ");

        $this->set('ListMatchJson', $ListMatchJson);
     
        
       
		/*if($this->Session->Read("Users.flag") != 0)
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
		}*/
		
		
		$vacio = array(""=>"");
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		

		$this->set('tipoMonedas', $tipoMonedas);

		$empaques = $this->Empaque->find("list", array(
			"fields"=>array("Empaque.nombre", "Empaque.nombre")
		));

		if(!empty($empaques))
		{
			array_unshift($empaques, $vacio);
			$this->set("empaques", $empaques);
		}

		$dimensionesProyectos = $this->DimensionesProyecto->find("all");

		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);

		$dimensiones = $this->Dimensione->find("all", array());

		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{

				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}
	
		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{

			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}
		$dimensionUno[0] = $vacio;
		ksort($dimensionUno);
		$this->set("dimensionUno", $dimensionUno);

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
		//array_unshift($dimensionDos, $vacio);
		$dimensionDos[0] = $vacio;
		ksort($dimensionDos);
		$this->set("dimensionDos", $dimensionDos);

		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		//array_unshift($dimensionTres, $vacio);
		$dimensionTres[0] = $vacio;
		ksort($dimensionTres);
		$this->set("dimensionTres", $dimensionTres);

		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		//array_unshift($dimensionCuatro, $vacio);
		$dimensionCuatro[0] = $vacio;
		ksort($dimensionCuatro);
		$this->set("dimensionCuatro", $dimensionCuatro);

		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		//array_unshift($dimensionCinco, $vacio);
		$dimensionCinco[0] = $vacio;
		ksort($dimensionCinco);
		$this->set("dimensionCinco", $dimensionCinco);

		$proveedores = $this->Company->find("list", array(
			"fields"=>array("Company.id", "Company.razon_social")
		));

		if(!empty($proveedores))
		{
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);   
		}
		$rutasDoc = array();
		if ($this->request->is('post')) {
			if(count($this->request['form']['file']['name'])>0){
				$destino = WWW_ROOT.'files'.DS.'solicitudFondos'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');		 
				if (!file_exists($destino))
				{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}

				for($i=0;$i<count($this->request['form']['file']['name']);$i++){
					$url = $destino . DS .$this->request['form']['file']['name'][$i];
					move_uploaded_file($this->request['form']['file']['tmp_name'][$i], $url);
					array_push($rutasDoc, $url);
				}
			}
			$datosFondosFolmulario = json_decode($this->request->data['rendicion']);
			
			
			print_r($this->request->data['rendicion']);
			
			exit;

			$this->request->data['SolicitudRequerimientoViatico']['fecha_inicio'] = $datosFondosFolmulario->fecha_inicio;
			$this->request->data['SolicitudRequerimientoViatico']['fecha_termino'] = $datosFondosFolmulario->fecha_termino;
			$this->request->data['SolicitudRequerimientoViatico']['hora_inicio'] = isset($datosFondosFolmulario->hora_inicio)?$datosFondosFolmulario->hora_inicio:'S/N';
			$this->request->data['SolicitudRequerimientoViatico']['hora_termino'] = isset($datosFondosFolmulario->hora_termino)?$datosFondosFolmulario->hora_termino:'S/N';
			$this->request->data['SolicitudRequerimientoViatico']['titulo'] = $datosFondosFolmulario->titulo;
			$this->request->data['SolicitudRequerimientoViatico']['responsable'] = $datosFondosFolmulario->responsable;
			$this->request->data['SolicitudRequerimientoViatico']['tipo_moneda'] = isset($datosFondosFolmulario->tipo_moneda_id)?$datosFondosFolmulario->tipo_moneda_id:1;
			$this->request->data['SolicitudRequerimientoViatico']['url_documento'] = implode(",", $rutasDoc);
			$this->request->data['SolicitudRequerimientoViatico']['observacion'] = isset($datosFondosFolmulario->observacion)?$datosFondosFolmulario->observacion:'S/N';
			$this->request->data['SolicitudRequerimientoViatico']['total'] = str_replace(".","",$this->request->data['total']);
			$this->request->data['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id']= 3;
			$this->request->data['SolicitudRequerimientoViatico']['estado_viatico']= 1;
			$this->request->data['SolicitudRequerimientoViatico']['id_usuario']=$this->Session->read('PerfilUsuario.idUsuario');
            //$this->request->data['SolicitudRequerimientoViatico']['produccion_partido_id'] = $datosFondosFolmulario->produccion_partido_id;
            
            
			if ($this->SolicitudRequerimientoViatico->save($this->request->data['SolicitudRequerimientoViatico'])) {
				$this->Session->setFlash(__('Rendicion agregada.'));
			} else {
				$this->Session->setFlash(__('The solicitud rendicion totale could not be saved. Please, try again.'));
			}

			$listaSolicituides = json_decode($this->request->data['lista']);
			for($i=0;$i<count($listaSolicituides);$i++){
				$this->SolicitudDetalleViatico->create();
						$this->request->data['SolicitudDetalleViatico']['colaborador'] = $listaSolicituides[$i]->colaborador;
						$this->request->data['SolicitudDetalleViatico']['monto'] = str_replace(".","",$listaSolicituides[$i]->monto);
						$this->request->data['SolicitudDetalleViatico']['gerencia'] = $listaSolicituides[$i]->gerencia;
						$this->request->data['SolicitudDetalleViatico']['estadio'] = $listaSolicituides[$i]->estadio;
						$this->request->data['SolicitudDetalleViatico']['contenido'] = $listaSolicituides[$i]->contenido;
						$this->request->data['SolicitudDetalleViatico']['canales_distribucion'] = $listaSolicituides[$i]->canales_distribucion;
						$this->request->data['SolicitudDetalleViatico']['otros'] = $listaSolicituides[$i]->otros;
						$this->request->data['SolicitudDetalleViatico']['proyectos'] = $listaSolicituides[$i]->proyectos;
						$this->request->data['SolicitudDetalleViatico']['codigo_presupuestario'] = $listaSolicituides[$i]->codigo_presupuestario;
						$this->request->data['SolicitudDetalleViatico']['descripcion'] = $listaSolicituides[$i]->descripcion;
						$this->request->data['SolicitudDetalleViatico']['id_solicitudes_rendicion_viatico'] = $this->SolicitudRequerimientoViatico->getInsertID();
				if ($this->SolicitudDetalleViatico->save($this->request->data['SolicitudDetalleViatico'])) {
					CakeLog::write('actividad', 'Agrega solicitud rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				} else {
					$this->Session->setFlash(__('The solicitud rendicion totale could not be saved. Please, try again.'));
				}
			}
		}
		//exit;
	}



	public function edit_viatico($id = null) {
		$this->autoRender = false;
		$this->loadModel("User");
		$this->loadModel("TiposMoneda");
		$this->loadModel("SolicitudDetalleViatico");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("Dimensione");
		$this->loadModel("Company");
		$this->loadModel("SolicitudRequerimientoViatico");
		$this->loadModel("Trabajadore");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("Area");
		$this->loadModel("DimensionesCodigosCorto");
		$this->loadModel("Cargo");
		$this->loadModel("Jefe");

		/*if($this->Session->Read("Users.flag") != 0)
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
		}*/

		$id= isset($this->request->data['id'])?$this->request->data['id']:$id;
		
		$this->set('id',$id);
		$vacio = array(""=>"");
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);


		$datosViaticos = $this->SolicitudRequerimientoViatico->find("first",array(
			'conditions'=>array('SolicitudRequerimientoViatico.id' =>$id)
		));

		$this->set('datos', $datosViaticos['SolicitudRequerimientoViatico']['url_documento']);	

		$valorMoneda = $this->TiposMoneda->find("first", array(
			"conditions"=>array("TiposMoneda.id"=>$datosViaticos['SolicitudRequerimientoViatico']['tipo_moneda']),
		));
	
		$this->set("idMoneda", $valorMoneda['TiposMoneda']['id']);
		$this->set("valorMoneda", $valorMoneda['TiposMoneda']['valor']);


		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);

		$dimensiones = $this->Dimensione->find("all", array());

		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{

				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}
	
		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{

			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}
		$dimensionUno[0] = $vacio;
		ksort($dimensionUno);
		$this->set("dimensionUno", $dimensionUno);

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
		//array_unshift($dimensionDos, $vacio);
		$dimensionDos[0] = $vacio;
		ksort($dimensionDos);
		$this->set("dimensionDos", $dimensionDos);

		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		//array_unshift($dimensionTres, $vacio);
		$dimensionTres[0] = $vacio;
		ksort($dimensionTres);
		$this->set("dimensionTres", $dimensionTres);

		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		//array_unshift($dimensionCuatro, $vacio);
		$dimensionCuatro[0] = $vacio;
		ksort($dimensionCuatro);
		$this->set("dimensionCuatro", $dimensionCuatro);

		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		//array_unshift($dimensionCinco, $vacio);
		$dimensionCinco[0] = $vacio;
		ksort($dimensionCinco);
		$this->set("dimensionCinco", $dimensionCinco);

		$proveedores = $this->Company->find("list", array(
			"fields"=>array("Company.id", "Company.razon_social")
		));

		if(!empty($proveedores))
		{
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);   
		}
		$rutasDoc = array();
		if ($this->request->is(array('post', 'put'))) {

			if(count($this->request['form']['file']['name'])>0){
				$destino = WWW_ROOT.'files'.DS.'solicitudViaticos'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');		 
				if (!file_exists($destino))
				{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}

				for($i=0;$i<count($this->request['form']['file']['name']);$i++){
					$url = $destino . DS .$this->request['form']['file']['name'][$i];
					move_uploaded_file($this->request['form']['file']['tmp_name'][$i], $url);
					array_push($rutasDoc, $url);
				}
			}

			
			$datosFondosFolmulario = json_decode($this->request->data['rendicion']);

			$this->SolicitudRequerimientoViatico->data['fecha_inicio'] = $datosFondosFolmulario->fecha_inicio;
			$this->SolicitudRequerimientoViatico->data['hora_inicio'] = $datosFondosFolmulario->hora_inicio;
			$this->SolicitudRequerimientoViatico->data['fecha_termino'] = $datosFondosFolmulario->fecha_termino;
			$this->SolicitudRequerimientoViatico->data['hora_termino'] = $datosFondosFolmulario->hora_termino;
			$this->SolicitudRequerimientoViatico->data['titulo'] = $datosFondosFolmulario->titulo;


			if(count($rutasDoc)>0){
				$this->SolicitudRequerimientoViatico->data['url_documento'] = implode(",", $rutasDoc);
			}
			
			$this->SolicitudRequerimientoViatico->data['responsable'] = $datosFondosFolmulario->responsable;
			$this->SolicitudRequerimientoViatico->data['observacion'] = $datosFondosFolmulario->observacion;
			$this->SolicitudRequerimientoViatico->data['compras_tarjeta_estado_id']= 3;
			$this->SolicitudRequerimientoViatico->data['total'] = str_replace(".","",$this->request->data['total']);
			$this->SolicitudRequerimientoViatico->data['id_usuario']=$this->Session->read('PerfilUsuario.idUsuario');
			$this->SolicitudRequerimientoViatico->data['id']= $id;

			if ($this->SolicitudRequerimientoViatico->save($this->SolicitudRequerimientoViatico->data)) {

			}

			if ($this->SolicitudDetalleViatico->deleteAll(array('SolicitudDetalleViatico.id_solicitudes_rendicion_viatico' => $id))) {
				//echo "--->elimino";
				//$this->Session->setFlash(__('The solicitud rendicion totale has been deleted.'));
			} 
			$listaSolicituides = json_decode($this->request->data['lista']);

			$totalMontos =0;
			
			for($i=0;$i<count($listaSolicituides);$i++){
				$this->SolicitudDetalleViatico->create();
				
				
				$this->SolicitudDetalleViatico->data['colaborador'] = $listaSolicituides[$i]->colaborador;
				$this->SolicitudDetalleViatico->data['monto'] = str_replace(".","",$listaSolicituides[$i]->monto);
				$this->SolicitudDetalleViatico->data['gerencia'] = $listaSolicituides[$i]->gerencia;
				$this->SolicitudDetalleViatico->data['estadio'] = $listaSolicituides[$i]->estadio;
				$this->SolicitudDetalleViatico->data['contenido'] = $listaSolicituides[$i]->contenido;
				$this->SolicitudDetalleViatico->data['canales_distribucion'] = $listaSolicituides[$i]->canales_distribucion;
				$this->SolicitudDetalleViatico->data['otros'] = $listaSolicituides[$i]->otros;
				$this->SolicitudDetalleViatico->data['proyectos'] = $listaSolicituides[$i]->proyectos;
				$this->SolicitudDetalleViatico->data['codigo_presupuestario'] = $listaSolicituides[$i]->codigo_presupuestario;
				$this->SolicitudDetalleViatico->data['descripcion'] = $listaSolicituides[$i]->descripcion;
				$this->SolicitudDetalleViatico->data['id_solicitudes_rendicion_viatico'] =$id;
			
				$this->SolicitudDetalleViatico->save($this->SolicitudDetalleViatico->data);
			}

					$nombreUsuario = $this->User->find('first', array(
						'conditions'=>array('User.id' => $this->Session->read('PerfilUsuario.idUsuario'))
					));

					$idJefe= $this->Trabajadore->find('first', array(
						'conditions'=>array('Trabajadore.id'=>	$nombreUsuario['User']['trabajadore_id'])
					));

					$idCargo= $this->Cargo->find('first', array(
						'conditions'=>array('Cargo.id'=>	$idJefe['Trabajadore']['cargo_id'])
					));

					$idArea= $this->Area->find('first', array(
						'conditions'=>array('Area.id'=>	$idCargo['Cargo']['area_id'])
					));

					$idCodigoCorto= $this->DimensionesCodigosCorto->find('first', array(
						'conditions'=>array('DimensionesCodigosCorto.id'=>	$idArea['Area']['gerencia_id'])
					));

					$aprobador = $this->EmailsAprobador->find('list', array(
						'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$idCodigoCorto['DimensionesCodigosCorto']['nombre'], 'EmailsAprobador.modulo' =>'fondos')
					));

					$datos = array('subject'=>"Actualizacion Viatico", 
					"template"=>'solicitud_requerimeinto_viatico');
			
					$viewvars = array(
					'cabecera'=>"Actualiza solicitud viatico",	
					'usuario'=>$nombreUsuario ['User']['nombre'], 
					"titulo"=>$datosFondosFolmulario->titulo, 
					"moneda"=>'Pesos Chileno',
					"monto"=>$totalMontos,
					"link"=>'solicitud_requerimiento_viaticos');
			
					$this->envioEmail($aprobador, $datos, $viewvars);
		
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
		$this->layout = 'angular';
		$this->loadModel("User");
		$this->loadModel("TiposMoneda");
		$this->loadModel("SolicitudDetalleViatico");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("Dimensione");
		$this->loadModel("Company");
		$this->loadModel("SolicitudRequerimientoViatico");
		$this->loadModel("Trabajadore");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("Area");
		$this->loadModel("DimensionesCodigosCorto");
		$this->loadModel("Cargo");
		$this->loadModel("Jefe");

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

		$id= isset($this->request->data['id'])?$this->request->data['id']:$id;
		
		$this->set('id',$id);
		$vacio = array(""=>"");
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$this->set('tipoMonedas', $tipoMonedas);


		$datosViaticos = $this->SolicitudRequerimientoViatico->find("first",array(
			'conditions'=>array('SolicitudRequerimientoViatico.id' =>$id)
		));

		$this->set('datos', $datosViaticos['SolicitudRequerimientoViatico']['url_documento']);	

		$valorMoneda = $this->TiposMoneda->find("first", array(
			"conditions"=>array("TiposMoneda.id"=>$datosViaticos['SolicitudRequerimientoViatico']['tipo_moneda']),
		));
	
		$this->set("idMoneda", $valorMoneda['TiposMoneda']['id']);
		$this->set("valorMoneda", $valorMoneda['TiposMoneda']['valor']);


		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
		$proyectos = "";

		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["codigo"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}
		//array_unshift($proyectos, $vacio);
		$proyectos[0] = $vacio;
		ksort($proyectos);

		$this->set("proyectos", $proyectos);

		$dimensiones = $this->Dimensione->find("all", array());

		$tipoDimensiones = "";
		if(!empty($dimensiones))
		{
			foreach($dimensiones as $dimensione)
			{

				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}
	
		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione)
		{

			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}
		$dimensionUno[0] = $vacio;
		ksort($dimensionUno);
		$this->set("dimensionUno", $dimensionUno);

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
		//array_unshift($dimensionDos, $vacio);
		$dimensionDos[0] = $vacio;
		ksort($dimensionDos);
		$this->set("dimensionDos", $dimensionDos);

		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		//array_unshift($dimensionTres, $vacio);
		$dimensionTres[0] = $vacio;
		ksort($dimensionTres);
		$this->set("dimensionTres", $dimensionTres);

		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		//array_unshift($dimensionCuatro, $vacio);
		$dimensionCuatro[0] = $vacio;
		ksort($dimensionCuatro);
		$this->set("dimensionCuatro", $dimensionCuatro);

		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		//array_unshift($dimensionCinco, $vacio);
		$dimensionCinco[0] = $vacio;
		ksort($dimensionCinco);
		$this->set("dimensionCinco", $dimensionCinco);

		$proveedores = $this->Company->find("list", array(
			"fields"=>array("Company.id", "Company.razon_social")
		));

		if(!empty($proveedores))
		{
			$proveedores[0] = $vacio;
			ksort($proveedores);
			$this->set("proveedores", $proveedores);   
		}
		$rutasDoc = array();
		if ($this->request->is(array('post', 'put'))) {

			if(count($this->request['form']['file']['name'])>0){
				$destino = WWW_ROOT.'files'.DS.'solicitudViaticos'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');		 
				if (!file_exists($destino))
				{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}

				for($i=0;$i<count($this->request['form']['file']['name']);$i++){
					$url = $destino . DS .$this->request['form']['file']['name'][$i];
					move_uploaded_file($this->request['form']['file']['tmp_name'][$i], $url);
					array_push($rutasDoc, $url);
				}
			}

			
			$datosFondosFolmulario = json_decode($this->request->data['rendicion']);

			$this->SolicitudRequerimientoViatico->data['fecha_inicio'] = $datosFondosFolmulario->fecha_inicio;
			$this->SolicitudRequerimientoViatico->data['hora_inicio'] = $datosFondosFolmulario->hora_inicio;
			$this->SolicitudRequerimientoViatico->data['fecha_termino'] = $datosFondosFolmulario->fecha_termino;
			$this->SolicitudRequerimientoViatico->data['hora_termino'] = $datosFondosFolmulario->hora_termino;
			$this->SolicitudRequerimientoViatico->data['titulo'] = $datosFondosFolmulario->titulo;


			if(count($rutasDoc)>0){
				$this->SolicitudRequerimientoViatico->data['url_documento'] = implode(",", $rutasDoc);
			}
			
			$this->SolicitudRequerimientoViatico->data['responsable'] = $datosFondosFolmulario->responsable;
			$this->SolicitudRequerimientoViatico->data['observacion'] = $datosFondosFolmulario->observacion;
			$this->SolicitudRequerimientoViatico->data['compras_tarjeta_estado_id']= 3;
			$this->SolicitudRequerimientoViatico->data['total'] = str_replace(".","",$this->request->data['total']);
			$this->SolicitudRequerimientoViatico->data['id_usuario']=$this->Session->read('PerfilUsuario.idUsuario');
			$this->SolicitudRequerimientoViatico->data['id']= $id;

			if ($this->SolicitudRequerimientoViatico->save($this->SolicitudRequerimientoViatico->data)) {

			}

			if ($this->SolicitudDetalleViatico->deleteAll(array('SolicitudDetalleViatico.id_solicitudes_rendicion_viatico' => $id))) {
				//echo "--->elimino";
				//$this->Session->setFlash(__('The solicitud rendicion totale has been deleted.'));
			} 
			$listaSolicituides = json_decode($this->request->data['lista']);

			$totalMontos =0;
			
			for($i=0;$i<count($listaSolicituides);$i++){
				$this->SolicitudDetalleViatico->create();
				
				
				$this->SolicitudDetalleViatico->data['colaborador'] = $listaSolicituides[$i]->colaborador;
				$this->SolicitudDetalleViatico->data['monto'] = str_replace(".","",$listaSolicituides[$i]->monto);
				$this->SolicitudDetalleViatico->data['gerencia'] = $listaSolicituides[$i]->gerencia;
				$this->SolicitudDetalleViatico->data['estadio'] = $listaSolicituides[$i]->estadio;
				$this->SolicitudDetalleViatico->data['contenido'] = $listaSolicituides[$i]->contenido;
				$this->SolicitudDetalleViatico->data['canales_distribucion'] = $listaSolicituides[$i]->canales_distribucion;
				$this->SolicitudDetalleViatico->data['otros'] = $listaSolicituides[$i]->otros;
				$this->SolicitudDetalleViatico->data['proyectos'] = $listaSolicituides[$i]->proyectos;
				$this->SolicitudDetalleViatico->data['codigo_presupuestario'] = $listaSolicituides[$i]->codigo_presupuestario;
				$this->SolicitudDetalleViatico->data['descripcion'] = $listaSolicituides[$i]->descripcion;
				$this->SolicitudDetalleViatico->data['id_solicitudes_rendicion_viatico'] =$id;
			
				$this->SolicitudDetalleViatico->save($this->SolicitudDetalleViatico->data);
			}

					$nombreUsuario = $this->User->find('first', array(
						'conditions'=>array('User.id' => $this->Session->read('PerfilUsuario.idUsuario'))
					));

					$idJefe= $this->Trabajadore->find('first', array(
						'conditions'=>array('Trabajadore.id'=>	$nombreUsuario['User']['trabajadore_id'])
					));

					$idCargo= $this->Cargo->find('first', array(
						'conditions'=>array('Cargo.id'=>	$idJefe['Trabajadore']['cargo_id'])
					));

					$idArea= $this->Area->find('first', array(
						'conditions'=>array('Area.id'=>	$idCargo['Cargo']['area_id'])
					));

					$idCodigoCorto= $this->DimensionesCodigosCorto->find('first', array(
						'conditions'=>array('DimensionesCodigosCorto.id'=>	$idArea['Area']['gerencia_id'])
					));

					$aprobador = $this->EmailsAprobador->find('list', array(
						'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$idCodigoCorto['DimensionesCodigosCorto']['nombre'], 'EmailsAprobador.modulo' =>'fondos')
					));

					$datos = array('subject'=>"Actualizacion Viatico", 
					"template"=>'solicitud_requerimeinto_viatico');
			
					$viewvars = array(
					'cabecera'=>"Actualiza solicitud viatico",	
					'usuario'=>$nombreUsuario ['User']['nombre'], 
					"titulo"=>$datosFondosFolmulario->titulo, 
					"moneda"=>'Pesos Chileno',
					"monto"=>$totalMontos,
					"link"=>'solicitud_requerimiento_viaticos');
			
					$this->envioEmail($aprobador, $datos, $viewvars);
		
		}

	}

	public function edit_rendicion_fondos(){
		$this->layout = null;
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("SolicitudDetalleViatico");
		
		//pr($this->request->query['largo']);
		//exit;

		/*if($this->Session->Read("Users.flag") != 0)
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
		}*/

		if(isset($this->request->query['proyecto'])){
			$proyectos = $this->DimensionesProyecto->find("first",array(
				'conditions'=>array('DimensionesProyecto.codigo' =>$this->request->query['proyecto'])
			));
		}
		
		if(isset($this->request->query['dimUno'])){
			$gerencia = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimUno'])
			));
		}	
		if(isset($this->request->query['dimDos'])){
			$estadios = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimDos'])
			));
		}
		if(isset($this->request->query['dimTres'])){
			$contenido = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimTres'])
			));
		}
		if(isset($this->request->query['dimCuatro'])){
			$canal= $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimCuatro'])
			));
		}
		if(isset($this->request->query['dimCinco'])){
			$otros = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimCinco'])
			));
		}
		if(isset($this->request->query['codigoPresupuestario'])){
			$presupuesto = $this->CodigosPresupuesto->find("first",array(
				'conditions'=>array('CodigosPresupuesto.id' =>$this->request->query['codigoPresupuestario'])
			));
		}
		$detalleViatico = $this->SolicitudDetalleViatico->find("all",array(
			'conditions'=>array('SolicitudDetalleViatico.id_solicitudes_rendicion_viatico' =>$this->request->query['id'])
		));

			if(count($detalleViatico)>0){
				foreach($detalleViatico as $h => $j){
					$salida1[] = array(
						'id'=>$j['SolicitudDetalleViatico']['id'],
						'descripcion'=>$j['SolicitudDetalleViatico']['descripcion'],
						'colaborador'=>$j['SolicitudDetalleViatico']['colaborador'],
						'monto'=>number_format($j['SolicitudDetalleViatico']['monto'],0,",","."),
						'gerencia'=>$j['SolicitudDetalleViatico']['gerencia'],
						'estadio'=>$j['SolicitudDetalleViatico']['estadio'],
						'contenido'=>$j['SolicitudDetalleViatico']['contenido'],
						'canales_distribucion'=>$j['SolicitudDetalleViatico']['canales_distribucion'],
						'otros'=>$j['SolicitudDetalleViatico']['otros'],
						'proyectos'=>$j['SolicitudDetalleViatico']['proyectos'],
						'codigo_presupuestario'=>$j['SolicitudDetalleViatico']['codigo_presupuestario'],
					);
				}
			}
		
			$salida2[] = array(
				'id'=>0,
				'descripcion'=>isset($this->request->query['descripcion'])?$this->request->query['descripcion']:'S/N',
				'colaborador'=>isset($this->request->query['colaborador'])?$this->request->query['colaborador']:'S/N',
				'monto'=>$this->request->query['monto'],
				'gerencia'=>isset($gerencia['Dimensione']['nombre'])?$gerencia['Dimensione']['nombre']:'S/N',
				'estadio'=>isset($estadios['Dimensione']['nombre'])?$estadios['Dimensione']['nombre']:'S/N',
				'contenido'=>isset($contenido['Dimensione']['nombre'])?$contenido['Dimensione']['nombre']:'S/N',
				'canales_distribucion'=>isset($canal['Dimensione']['nombre'])?$canal['Dimensione']['nombre']:'S/N',
				'otros'=>isset($otros['Dimensione']['nombre'])?$otros['Dimensione']['nombre']:'S/N',
				'proyectos'=>isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
				'codigo_presupuestario'=>isset($presupuesto['CodigosPresupuesto']['nombre'])?$presupuesto['CodigosPresupuesto']['nombre']:'S/N',
			);
			if($this->request->query['largo'] == count($detalleViatico) && count($detalleViatico)>0){
				$resultado = array_merge($salida1, $salida2);
			}else{
				$resultado = $salida2;
			}
		CakeLog::write('actividad', 'Edita lista gastos rendicion' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		echo json_encode($resultado);
		exit;
	}

	public function add_rendicion_fondos_rechazo($id=null){
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("SolicitudesRendicionFondo");
		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("SolicitudDetalleViatico");
		$this->layout = null;
		
		//if(!empty($this->request->query)){
			$ProductosCompra = $this->SolicitudDetalleViatico->find("all",array(
				'conditions'=>array('SolicitudDetalleViatico.id_solicitudes_rendicion_viatico' =>$id)
			));
			foreach($ProductosCompra as $h => $j){
				$salida[] = array(
					    'id'=>$j['SolicitudDetalleViatico']['id'],
					    'descripcion'=>$j['SolicitudDetalleViatico']['descripcion'],
						'colaborador'=>$j['SolicitudDetalleViatico']['colaborador'],
						'monto'=>number_format($j['SolicitudDetalleViatico']['monto'],0,",","."),
						'gerencia'=>$j['SolicitudDetalleViatico']['gerencia'],
						'estadio'=>$j['SolicitudDetalleViatico']['estadio'],
						'contenido'=>$j['SolicitudDetalleViatico']['contenido'],
						'canales_distribucion'=>$j['SolicitudDetalleViatico']['canales_distribucion'],
						'otros'=>$j['SolicitudDetalleViatico']['otros'],
						'proyectos'=>$j['SolicitudDetalleViatico']['proyectos'],
						'codigo_presupuestario'=>$j['SolicitudDetalleViatico']['codigo_presupuestario'],
				);
			}
			CakeLog::write('actividad', 'lista solicitud rendicion fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	        echo json_encode($salida);
	//	}
		exit;
	}


/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("SolicitudDetalleViatico");
		$this->loadModel("Area");
		$this->loadModel("DimensionesCodigosCorto");
		$this->loadModel("Cargo");
		$this->loadModel("Trabajadore");
		$this->loadModel("Jefe");
		if($this->Session->Read("Users.flag") != 0)
		/*{
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
		if (!$this->SolicitudRequerimientoViatico->exists(intval($id))) {		
			throw new NotFoundException(__('Invalid compras tarjeta'));
		}*/
		if ($this->request->is(array('get', 'put'))) {
			$this->request->data['SolicitudRequerimientoViatico']['id']=$id;
			$this->request->data['SolicitudRequerimientoViatico']['estado_viatico']=0;
			if ($this->SolicitudRequerimientoViatico->save($this->request->data)) {
				$nombrelUser = $this->User->find('first', array(
					'conditions'=>array('User.id' => $this->Session->read('PerfilUsuario.idUsuario'))
				));

				$idJefe= $this->Trabajadore->find('first', array(
					'conditions'=>array('Trabajadore.id'=>	$nombrelUser['User']['trabajadore_id'])
				));

				$idCargo= $this->Cargo->find('first', array(
					'conditions'=>array('Cargo.id'=>	$idJefe['Trabajadore']['cargo_id'])
				));

				$idArea= $this->Area->find('first', array(
					'conditions'=>array('Area.id'=>	$idCargo['Cargo']['area_id'])
				));
				$idCodigoCorto= $this->DimensionesCodigosCorto->find('first', array(
					'conditions'=>array('DimensionesCodigosCorto.id'=>	$idArea['Area']['gerencia_id'])
				));
				$aprobador = $this->EmailsAprobador->find('list', array(
					'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$idCodigoCorto['DimensionesCodigosCorto']['nombre'], 'EmailsAprobador.modulo' =>'fondos')
				));

				$monto = $this->SolicitudDetalleViatico->find('all', array(
					'conditions'=>array('SolicitudDetalleViatico.id' =>$id)
				));

				$DatosViaticos = $this->SolicitudRequerimientoViatico->find('first', array(
					'conditions'=>array('SolicitudRequerimientoViatico.id' =>$id)
				));

					$datos = array('subject'=>"Elimina Viatico", 
					"template"=>'solicitud_requerimeinto_viatico');

					$viewvars = array(
					'cabecera'=>"Elimina solicitud viatico",
					'usuario'=>$nombrelUser['User']['nombre'], 
					"titulo"=>$DatosViaticos['SolicitudRequerimientoViatico']['titulo'], 
					"moneda"=>'Pesos Chileno',
					"monto"=>number_format($DatosViaticos['SolicitudRequerimientoViatico']['total'],0,",","."),
					"link"=>'solicitud_requerimiento_viaticos');

					$this->envioEmail($aprobador, $datos,$viewvars);
					$this->Session->setFlash('Viatico eliminado.', 'msg_exito');
			} else {
				$this->Session->setFlash(__('The solicitud requerimiento viatico could not be deleted. Please, try again.'));
			}
			return $this->redirect(array('action' => 'index'));
		}
	}

	public function add_rendicion_viaticos(){
	
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");
		$this->layout = null;

		/*if($this->Session->Read("Users.flag") != 0)
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
		}*/


		//pr($this->request->query['codigoPresupuestario']);
		//exit;
		if(isset($this->request->query['proyecto'])){
			$proyectos = $this->DimensionesProyecto->find("first",array(
				'conditions'=>array('DimensionesProyecto.codigo' =>$this->request->query['proyecto'])
			));
		}
		
		if(isset($this->request->query['dimUno'])){
			$gerencia = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimUno'])
			));
		}	
		if(isset($this->request->query['dimDos'])){
			$estadios = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimDos'])
			));
		}
		if(isset($this->request->query['dimTres'])){
			$contenido = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimTres'])
			));
		}
		if(isset($this->request->query['dimCuatro'])){
			$canal= $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimCuatro'])
			));
		}
		if(isset($this->request->query['dimCinco'])){
			$otros = $this->Dimensione->find("first",array(
				'conditions'=>array('Dimensione.codigo' =>$this->request->query['dimCinco'])
			));
		}
		if(isset($this->request->query['codigoPresupuestario'])){
			$presupuesto = $this->CodigosPresupuesto->find("first",array(
				'conditions'=>array('CodigosPresupuesto.id' =>$this->request->query['codigoPresupuestario'])
			));
		}
		if(count($this->request->query)>0){
			
			$salida = array(
				'descripcion'=>isset($this->request->query['descripcion'])?$this->request->query['descripcion']:'S/N',
				'colaborador'=>isset($this->request->query['colaborador'])?$this->request->query['colaborador']:'S/N',
				'monto'=>$this->request->query['monto'],
				'gerencia'=>isset($gerencia['Dimensione']['nombre'])?$gerencia['Dimensione']['nombre']:'S/N',
				'estadio'=>isset($estadios['Dimensione']['nombre'])?$estadios['Dimensione']['nombre']:'S/N',
				'contenido'=>isset($contenido['Dimensione']['nombre'])?$contenido['Dimensione']['nombre']:'S/N',
				'canales_distribucion'=>isset($canal['Dimensione']['nombre'])?$canal['Dimensione']['nombre']:'S/N',
				'otros'=>isset($otros['Dimensione']['nombre'])?$otros['Dimensione']['nombre']:'S/N',
				'proyectos'=>isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N',
				'codigo_presupuestario'=>isset($presupuesto['CodigosPresupuesto']['nombre'])?$presupuesto['CodigosPresupuesto']['nombre']:'S/N',
			);
			CakeLog::write('actividad', 'Lista solicitud viaticos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	        echo json_encode($salida);
		}
		exit;
		
		
	}


	public function add_estados(){
		$this->layout=null;

		$this->loadModel("TiposMoneda");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("SolicitudRequerimientoViatico");
		$this->loadModel("SolicitudDetalleViatico");
		$this->loadModel("Area");
		$this->loadModel("DimensionesCodigosCorto");
		$this->loadModel("Cargo");
		$this->loadModel("Trabajadore");
		$this->loadModel("Jefe");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$salida = "";
			if ($this->request->is(array('post', 'put'))) {

					$this->request->data['SolicitudRequerimientoViatico']['id']=$this->request->query['id'];
					$this->request->data['SolicitudRequerimientoViatico']['compras_tarjeta_estado_id']=$this->request->query['estado'];
					//$this->request->data['SolicitudRequerimientoViatico']['total']= str_replace(".","",$this->request->query['totalGastos']);
					
					$this->request->data['SolicitudRequerimientoViatico']['n_documento']=isset($this->request->query['n_documento'])?$this->request->query['n_documento']:'';
					$this->request->data['SolicitudRequerimientoViatico']['motivo']=isset($this->request->query['motivo'])?$this->request->query['motivo']:'';
			if ($this->SolicitudRequerimientoViatico->save($this->request->data['SolicitudRequerimientoViatico'])) {
				
				$nombrelUser = $this->User->find('first', array(
					'conditions'=>array('User.id' => $this->Session->read('PerfilUsuario.idUsuario'))
				));

				$idJefe= $this->Trabajadore->find('first', array(
					'conditions'=>array('Trabajadore.id'=>	$nombrelUser['User']['trabajadore_id'])
				));

				$idCargo= $this->Cargo->find('first', array(
					'conditions'=>array('Cargo.id'=>	$idJefe['Trabajadore']['cargo_id'])
				));

				$idArea= $this->Area->find('first', array(
					'conditions'=>array('Area.id'=>	$idCargo['Cargo']['area_id'])
				));
				$idCodigoCorto= $this->DimensionesCodigosCorto->find('first', array(
					'conditions'=>array('DimensionesCodigosCorto.id'=>	$idArea['Area']['gerencia_id'])
				));
				$aprobador = $this->EmailsAprobador->find('list', array(
					'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$idCodigoCorto['DimensionesCodigosCorto']['nombre'], 'EmailsAprobador.modulo' =>'fondos')
				));

				$DatosViaticos= $this->SolicitudRequerimientoViatico->find('first', array(
					'conditions'=>array('SolicitudRequerimientoViatico.id'=>$this->request->query['id'])
				));

				if($this->request->query['estado']==1 || $this->request->query['estado']==4 ){
					$area = 'Area';
				}else{
					$area = 'Finanzas';
				}

				if($this->request->query['estado']==5 || $this->request->query['estado']==7 ){
					$area = 'Area';
				}else{
					$area = 'Finanzas';
				}
				switch ($this->request->query['estado']) {
					case 1:
					case 4:
						$datos = array('subject'=>"Aprobación Viatico ".$area, 
						"template"=>'solicitud_requerimeinto_viatico');

						$viewvars = array(
						'cabecera'=>'Aprobación solicitud viatico',
						'usuario'=>$nombrelUser['User']['nombre'], 
						"titulo"=>$DatosViaticos['SolicitudRequerimientoViatico']['titulo'], 
						"moneda"=>'Pesos Chileno',
						"monto"=>$DatosViaticos['SolicitudRequerimientoViatico']['total'],
						"motivo"=>'',
						"link"=>'solicitud_requerimiento_viaticos/lista_area');

						//$this->envioEmail($aprobador, $datos,$viewvars);
						CakeLog::write('actividad', 'Solictud Rendicon compra' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
						return $this->Session->setFlash('Solicitud aprobada.', 'msg_exito');
					break;
					case 5:
					case 7:
						$datos = array('subject'=>"Rechazo Viatico ".$area, 
						"template"=>'rechaso_solicitud_requerimeinto_fondo_fijo');

						$viewvars = array(
						'cabecera'=>'Rechazo solicitud viatico',
						'usuario'=>$nombrelUser['User']['nombre'], 
						"titulo"=>$DatosViaticos['SolicitudRequerimientoViatico']['titulo'], 
						"moneda"=>'Pesos Chileno',
						"monto"=>$DatosViaticos['SolicitudRequerimientoViatico']['total'],
						"motivo"=>$this->request->query['motivo'],
						"link"=>'solicitud_requerimiento_viaticos/lista_finanza');

						$this->envioEmail($aprobador, $datos,$viewvars);
						CakeLog::write('actividad', 'Rechazo Solcitud rendion fondo' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
						return $this->Session->setFlash('Solicitud rechazada.', 'msg_fallo');
					break;	
				}
			} 
		} 
	}

	public function datos_rendicion($id=null){

		//$this->layout = null;

		$this->loadModel("TiposDocumento");
		$this->loadModel("ComprasProductosTotale");
		$this->loadModel("Company");
		$this->loadModel("TiposMoneda");
		$this->loadModel("PlazosPago");
		$this->loadModel("Empaque");
		$this->loadModel("Dimensione");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("SolicitudDetalleViatico");

		/*if($this->Session->Read("Users.flag") != 0)
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
		}*/
		if(!empty($id)){
		
			$datosViaticos = $this->SolicitudRequerimientoViatico->find("first",array(
				'conditions'=>array('SolicitudRequerimientoViatico.id' =>$id)
			));
			//$this->set('datos', json_encode($datosViaticos));

			CakeLog::write('actividad', 'Lista rendicion de fondos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
			echo json_encode($datosViaticos);
			exit;
		}
	}

	public function delete_gasto($id = null) {


		//echo $this->request->query['id'];
		//exit;
		$this->layout=null;
		$this->loadModel("SolicitudDetalleViatico");
			/*if($this->Session->Read("Users.flag") != 0)
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
			}*/
		if (!$this->SolicitudDetalleViatico->exists($this->request->query['id'])) {		
			throw new NotFoundException(__('Invalid compras tarjeta'));
		}
		//if ($this->request->allowMethod('get', 'delete')) {
		
			if ($this->SolicitudDetalleViatico->delete($this->request->data['SolicitudDetalleViatico']['id']=$this->request->query['id'])) {
				//$this->Session->setFlash(__('Solicitud de requerimiento fondo eliminada.', 'msg_exito'));
				//return $this->redirect(array('action' => 'index'));
			} else {
				//$this->Session->setFlash(__('The solicitud rendicion totale could not be deleted. Please, try again.'));
			}
		//return $this->redirect(array('action' => 'index'));
		CakeLog::write('actividad', 'Elimina datos de Gastos' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		//}	
	}

	public function envioEmail($envioEmail, $datos, $viewvars){
		$Email = new CakeEmail("gmail");
		$Email->from(array('sgi@cdf.cl' => 'SGI'));
		$Email->to($envioEmail);//($email[0]["Email"]["email"]);
		$Email->subject($datos['subject']);
		$Email->emailFormat('html');
		$Email->template($datos['template']);
		$Email->viewVars($viewvars);
		//$Email->send();	
	}
	
	public function ver_viatico_todos(){}
}

