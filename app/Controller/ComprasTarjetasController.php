<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
/**
 * ComprasTarjetas Controller
 *
 * @property ComprasTarjeta $ComprasTarjeta
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Sessionemail
 */
class ComprasTarjetasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->layout = 'angular';
		$this->loadModel("ComprasTarjetasEstado");
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
		$estado = $this->ComprasTarjetasEstado->find('first', array(
			'conditions'=>array('ComprasTarjetasEstado.id'=> 2 )
		));
		$this->set("codigo", $estado);
		CakeLog::write('actividad', 'lista compras tarjeta ' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->layout = 'angular';
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("DimensionesProyecto");

		$this->loadModel("CodigosPresupuesto");

		$this->loadModel("EmailsAprobador");

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


		if (!$this->ComprasTarjeta->exists($id)) {
			throw new NotFoundException(__('Invalid compras tarjeestadota'));
		}
	
		$idDimencion = $this->ComprasTarjeta->find('first', array(
			'conditions'=>array('ComprasTarjeta.id' => $id, 'ComprasTarjeta.estado'=>1)
		));

		$codigoDimensionId = $this->Dimensione->find('first', array(
			'conditions'=>array('Dimensione.codigo'=> $idDimencion['ComprasTarjeta']['dimensione_id'] )
		));

		$this->set('comprasTarjeta', $this->ComprasTarjeta->find('first', array(
			'conditions'=>array('ComprasTarjeta.id' => $id, 'ComprasTarjeta.estado'=>1)
		)));

		$datos = $this->ComprasTarjeta->find('first', array(
			'conditions'=>array('ComprasTarjeta.id' => $id, 'ComprasTarjeta.estado'=>1)
		));

	//	pr($datos['ComprasTarjeta']['estadios']);
		$estadios = $this->Dimensione->find("first",array(
			'conditions'=>array('Dimensione.codigo' =>$datos['ComprasTarjeta']['estadios'])
		));
		$this->set("estadios", isset($estadios['Dimensione']['descripcion'])?$estadios['Dimensione']['descripcion']:'S/N');

		$proyectos = $this->DimensionesProyecto->find("first",array(
			'conditions'=>array('DimensionesProyecto.codigo' =>$datos['ComprasTarjeta']['proyectos'])
		));

		$codigoPresupuestoId = $this->CodigosPresupuesto->find('first', array(
			'conditions'=>array('CodigosPresupuesto.id'=>$datos['ComprasTarjeta']['codigos_presupuesto_id'] )
		));


		$this->set("codigoPresupuestoId", $codigoPresupuestoId['CodigosPresupuesto']['nombre']);

		//pr($proyectos);
		//exit;

		$this->set("proyectos", isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N');

		$canal = $this->Dimensione->find("first",array(
			'conditions'=>array('Dimensione.codigo' =>$datos['ComprasTarjeta']['canal'])
		));
		$this->set("canal",  isset($canal['Dimensione']['descripcion'])?$canal['Dimensione']['descripcion']:'S/N');


		$contenido = $this->Dimensione->find("first",array(
			'conditions'=>array('Dimensione.codigo' =>$datos['ComprasTarjeta']['contenido'])
		));
		$this->set("contenido", isset($contenido['Dimensione']['descripcion'])?$contenido['Dimensione']['descripcion']:'S/N');
	//	exit;

		$otros = $this->Dimensione->find('first', array(
			'conditions'=>array('Dimensione.codigo'=> $datos['ComprasTarjeta']['otros'] )
		));

		$this->set("otros",   isset($otros['Dimensione']['descripcion'])?$otros['Dimensione']['descripcion']:'S/N');


		$listaCompras = $this->ComprasTarjeta->find("first",array(
			'conditions'=>array('ComprasTarjeta.id' => $id, 'ComprasTarjeta.estado'=>1)
		));

		$codigo = $listaCompras['ComprasTarjeta']['compras_tarjetas_estado_id'];

		$this->set("codigo", $codigo);

		$emailUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
		));

		$aprobador = $this->EmailsAprobador->find('first', array(
			'conditions'=>array('EmailsAprobador.emails' =>$emailUser['Trabajadore']['email'], 'EmailsAprobador.modulo' =>'tarjeta')
		));
	
		if($codigo==1){
			$cod='GG';
			$estado = $this->ComprasTarjetasEstado->find('list', array(
				'conditions'=>array('ComprasTarjetasEstado.codigo'=> $cod),
				'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
			));
		}elseif($codigo==2|| $codigo==9 ){
			$cod='FZ';
			$estado = $this->ComprasTarjetasEstado->find('list', array(
				'conditions'=>array('ComprasTarjetasEstado.codigo'=> $cod, 'ComprasTarjetasEstado.id'=> array(4,7)),
				'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
			));
			$estadoCompra = $this->ComprasTarjetasEstado->find('list', array(
				'conditions'=>array('ComprasTarjetasEstado.codigo'=> $cod, 'ComprasTarjetasEstado.id'=> array(8,9)),
				'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
			));	
			$this->set("estadoCompra", $estadoCompra);
			

		}elseif($codigo==3) {
			$cod='AA';
			$estado = $this->ComprasTarjetasEstado->find('list', array(
				'conditions'=>array('ComprasTarjetasEstado.codigo'=> $cod),
				'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
			));

			$estadoCompra = $this->ComprasTarjetasEstado->find('list', array(
				'conditions'=>array('ComprasTarjetasEstado.codigo'=> $cod, 'ComprasTarjetasEstado.id'=> array(8,9)),
				'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
			));	
			$this->set("estadoCompra", $estadoCompra);
		}

		$this->set("estado", $estado);


		if(count($aprobador)>0){
			$evaluador = true;
		}else{
			$evaluador = false;
		}
		$this->set("evaluador", $evaluador);
		$this->set("dimensione", $codigoDimensionId);
		CakeLog::write('actividad', 'Visualiza informacion de solicitud compra con tarjeta' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));

	}


	public function general($id = null){
		//$this->layout = 'angular';
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("compras_tarjetas");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("CodigosPresupuesto");

		

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


		if (!$this->ComprasTarjeta->exists($id)) {
			throw new NotFoundException(__('Invalid compras tarjeestadota'));
		}
	
		$idDimencion = $this->ComprasTarjeta->find('first', array(
			'conditions'=>array('ComprasTarjeta.id' => $id, 'ComprasTarjeta.estado'=>1)
		));

		$codigoDimensionId = $this->Dimensione->find('first', array(
			'conditions'=>array('Dimensione.codigo'=> $idDimencion['ComprasTarjeta']['dimensione_id'] )
		));

		$this->set('comprasTarjeta', $this->ComprasTarjeta->find('first', array(
			'conditions'=>array('ComprasTarjeta.id' => $id, 'ComprasTarjeta.estado'=>1)
		)));


		$listaCompras = $this->ComprasTarjeta->find("first",array(
			'conditions'=>array('ComprasTarjeta.id' => $id, 'ComprasTarjeta.estado'=>1)
		));

		$codigo = $listaCompras['ComprasTarjeta']['compras_tarjetas_estado_id'];

		$this->set("codigo", $codigo);

		$emailUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
		));

		$aprobador = $this->EmailsAprobador->find('first', array(
			'conditions'=>array('EmailsAprobador.emails' =>$emailUser['Trabajadore']['email'], 'EmailsAprobador.modulo' =>'tarjeta')
		));

		$datos = $this->ComprasTarjeta->find('first', array(
			'conditions'=>array('ComprasTarjeta.id' => $id, 'ComprasTarjeta.estado'=>1)
		));

	//	pr($datos['ComprasTarjeta']['estadios']);
		$estadios = $this->Dimensione->find("first",array(
			'conditions'=>array('Dimensione.codigo' =>$datos['ComprasTarjeta']['estadios'])
		));
		$this->set("estadios", $estadios);

		$proyectos = $this->DimensionesProyecto->find("first",array(
			'conditions'=>array('DimensionesProyecto.codigo' =>$datos['ComprasTarjeta']['proyectos'])
		));

		//pr($proyectos);
		//exit;

		$this->set("proyectos", isset($proyectos['DimensionesProyecto']['nombre'])?$proyectos['DimensionesProyecto']['nombre']:'S/N');

		$canal = $this->Dimensione->find("first",array(
			'conditions'=>array('Dimensione.codigo' =>$datos['ComprasTarjeta']['canal'])
		));
		$this->set("canal", $canal);


		$contenido = $this->Dimensione->find("first",array(
			'conditions'=>array('Dimensione.codigo' =>$datos['ComprasTarjeta']['contenido'])
		));
		$this->set("contenido", $contenido);
	//	exit;

		$otros = $this->Dimensione->find('first', array(
			'conditions'=>array('Dimensione.codigo'=> $datos['ComprasTarjeta']['otros'] )
		));

		$this->set("otros", $otros);

		$codigoPresupuestoId = $this->CodigosPresupuesto->find('first', array(
			'conditions'=>array('CodigosPresupuesto.id'=>$datos['ComprasTarjeta']['codigos_presupuesto_id'] )
		));


		$this->set("codigoPresupuestoId", $codigoPresupuestoId['CodigosPresupuesto']['nombre']);

	
		if($codigo==1){
			$cod='GG';
			$estado = $this->ComprasTarjetasEstado->find('list', array(
				'conditions'=>array('ComprasTarjetasEstado.codigo'=> $cod),
				'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
			));
		}elseif($codigo==2|| $codigo==9 ){
			$cod='FZ';
			$estado = $this->ComprasTarjetasEstado->find('list', array(
				'conditions'=>array('ComprasTarjetasEstado.codigo'=> $cod, 'ComprasTarjetasEstado.id'=> array(4,7)),
				'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
			));
			$estadoCompra = $this->ComprasTarjetasEstado->find('list', array(
				'conditions'=>array('ComprasTarjetasEstado.codigo'=> $cod, 'ComprasTarjetasEstado.id'=> array(8,9)),
				'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
			));
	
			$this->set("estadoCompra", $estadoCompra);
		}elseif($codigo==3) {
			$cod='AA';
			$estado = $this->ComprasTarjetasEstado->find('list', array(
				'conditions'=>array('ComprasTarjetasEstado.codigo'=> $cod),
				'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
			));
		}

		$this->set("estado", $estado);

		if(count($aprobador)>0){
			$evaluador = true;
		}else{
			$evaluador = false;
		}
		$this->set("evaluador", $evaluador);
		$this->set("dimensione", $codigoDimensionId);
		CakeLog::write('actividad', 'Visualiza informacion de solicitud compra con tarjeta' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
	}


/**
 * add method
 *
 * @return void
 */
	public function add() { 

		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("User");
		$this->loadModel("DimensionesProyecto");

		$vacio = array(""=>"");
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

		$estado = $this->ComprasTarjetasEstado->find('list', array(
			'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
		));

		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		$dimensiones = $this->Dimensione->find("all", array());

		$tipoDimensiones = "";
		if(!empty($dimensiones)){
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione){

			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}

		if(isset($this->request->data['ComprasTarjeta']['dimensione_id'])){
			$codigoDimensionId = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $this->request->data['ComprasTarjeta']['dimensione_id'] )
			));
		}

		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
		//array_unshift($dimensionDos, $vacio);
		$this->set("dimensionDos", $dimensionDos);

		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
		//array_unshift($dimensionTres, $vacio);
		$this->set("dimensionTres", $dimensionTres);

		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
		//array_unshift($dimensionCuatro, $vacio);
		$this->set("dimensionCuatro", $dimensionCuatro);

		$dimensionCinco = "";
		foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
		{
			$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
		}
		//array_unshift($dimensionCinco, $vacio);

		$this->set("dimensionCinco", $dimensionCinco);
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
	
		if ($this->request->is('post')) {

			$nombreMoneda = $this->TiposMoneda->find('first', array(
				'conditions'=>array('TiposMoneda.id'=>$this->request->data['ComprasTarjeta']['tipos_moneda_id'])
			));

			$this->ComprasTarjeta->create(); 

			$this->request->data['ComprasTarjeta']['codigos_presupuesto_id'] = $this->request->data['ComprasTarjeta']['codigo_presupuesto_id'];
			$this->request->data['ComprasTarjeta']['dimensione_id'] = $codigoDimensionId['Dimensione']['codigo'];
			$this->request->data['ComprasTarjeta']['user_id']=$this->Session->Read("PerfilUsuario.idUsuario");
			$this->request->data['ComprasTarjeta']['compras_tarjetas_estado_id']=3;
			$this->request->data['ComprasTarjeta']['fecha_requerimiento']=date('Y-m-d');
			$this->request->data['ComprasTarjeta']['fecha_compra']=date('Y-m-d');
			$this->request->data['ComprasTarjeta']['motivo_rechazo']='En Proceso';
			$this->request->data['ComprasTarjeta']['estado']=1;
			$this->request->data['ComprasTarjeta']['moneda_observada']=$this->request->data['ComprasTarjeta']['moneda_observada'];
			$this->request->data['ComprasTarjeta']['url']=$this->request->data['ComprasTarjeta']['url'];
			$this->request->data['ComprasTarjeta']['recurrencia']=$this->request->data['ComprasTarjeta']['recurrencia'];
			$this->request->data['ComprasTarjeta']['estadios']=$this->request->data['ComprasTarjeta']['dimDos'];
			$this->request->data['ComprasTarjeta']['contenido']=$this->request->data['ComprasTarjeta']['dimTres'];
			$this->request->data['ComprasTarjeta']['canal']=$this->request->data['ComprasTarjeta']['dimCuatro'];
			$this->request->data['ComprasTarjeta']['otros']=$this->request->data['ComprasTarjeta']['dimCinco'];
			$this->request->data['ComprasTarjeta']['proyectos']=$this->request->data['ComprasTarjeta']['proyectos'];

			$destino = WWW_ROOT.'files'.DS.'comprasTarjeta'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
		             	
			if (!file_exists($destino))
			{
				mkdir($destino, 0777, true);
				chmod($destino, 0777);
			}


			//pr($this->data['ComprasTarjeta']['documento']);
			//exit;
			//$rutasDoc= array();
			if(count($this->data['ComprasTarjeta']['documento'])>0){


				if(!empty($this->data['ComprasTarjeta']['documento']['name'])){

					$destino = WWW_ROOT.'files'.DS.'solicitudFondos'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');		 
					if (!file_exists($destino))
					{
						mkdir($destino, 0777, true);
						chmod($destino, 0777);
					}

						$url = $destino . DS .$this->data['ComprasTarjeta']['documento']['name'];
						move_uploaded_file($this->data['ComprasTarjeta']['documento']['tmp_name'], $url);
						//$doc = $compra['ComprasTarjeta']['url_documentos'].",".$url;


						$this->request->data['ComprasTarjeta']['url_documentos'] = $url;
					}
					
				}

			if ($this->ComprasTarjeta->save($this->request->data)) {

				$aprobador = $this->EmailsAprobador->find('list', array(
					'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$codigoDimensionId['Dimensione']['codigo_corto'], 'EmailsAprobador.modulo' =>'tarjeta')
				));

				$nameUser = $this->User->find('first', array(
					'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
				));

				$envioEmail=$aprobador;
				if(!empty($envioEmail))
				{
					$Email = new CakeEmail("gmail");
					$Email->from(array('sgi@cdf.cl' => 'SGI'));
					$Email->to($envioEmail);//($email[0]["Email"]["email"]);
					$Email->subject("Solicitud compra Tarjeta");
					$Email->emailFormat('html');
					$Email->template('solicitud_compra_tarjeta');
					$Email->viewVars(array(
						"usuario"=>$nameUser['User']['nombre'],
						"producto"=>$this->request->data['ComprasTarjeta']['url_producto'],
						"fecha_compra"=>date('Y-m-d'),
						"moneda"=>$nombreMoneda['TiposMoneda']['nombre'],
						"monto"=>$this->request->data['ComprasTarjeta']['monto'],
						"cuota"=>$this->request->data['ComprasTarjeta']['cuota'],
						/*"titulo"=>$this->data["titulo"],
						"total"=>$this->data["total"],
						"empresa"=>$empresa["Company"]["nombre"]*/
					));
					$Email->send();

	
				}
				
			
				$this->Session->setFlash('Registrado correctamente', 'msg_exito');
				//return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
				CakeLog::write('actividad', 'Agrega solicitud de compra con tarjeta y envia mail' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				return $this->redirect(array('action' => 'view_solicitante'));

			} else {
				$this->Session->setFlash('No se puedo ingresar la inforación', 'msg_fallo');
			}
		}
		
		$this->set('tipoMonedas', $tipoMonedas);
		$this->set("dimensione", $dimensionUno);

		//$v=1;
			//	$this->set('v',$v);
		//$this->set('estado', $estado);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {

		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("CodigosPresupuesto");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("DimensionesProyecto");
		$this->loadModel("ComprasTarjeta");
		
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
		
		$vacio = array(""=>"");
		
		$estado = $this->ComprasTarjetasEstado->find('list', array(
			'fields'=>array('ComprasTarjetasEstado.id', 'ComprasTarjetasEstado.descripcion')
		));
		$tipoMonedas = $this->TiposMoneda->find('list', array(
			'fields'=>array('TiposMoneda.id', 'TiposMoneda.nombre')
		));
		
		$dimensiones = $this->Dimensione->find("all", array());

		if(isset($this->request->data['ComprasTarjeta']['dimensione_id'])){
			$codigoDimensionId = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $this->request->data['ComprasTarjeta']['dimensione_id'] )
			));
		}

		$tipoDimensiones = "";
		if(!empty($dimensiones)){
			foreach($dimensiones as $dimensione)
			{
				$tipoDimensiones[$dimensione["TiposDimensione"]["id"]][] = array("Id"=>$dimensione["Dimensione"]["codigo"], "Nombre"=>$dimensione["Dimensione"]["codigo"] .' - ' . $dimensione["Dimensione"]["nombre"]);
			}
		}
	
		$dimensionesProyectos = $this->DimensionesProyecto->find("all");
			$proyectos = "";
		if(!empty($dimensionesProyectos))
		{
			foreach($dimensionesProyectos as $dimensionesProyecto)
			{
				$proyectos[$dimensionesProyecto["DimensionesProyecto"]["id"]] = $dimensionesProyecto["DimensionesProyecto"]["codigo"] . ' - ' .$dimensionesProyecto["DimensionesProyecto"]["nombre"];
			}
		}

	
		$proyectos[0] = $vacio;
		ksort($proyectos);
			$this->set("proyectos", $proyectos);

		$dimensionUno = "";
		foreach($tipoDimensiones[1] as $tipoDimensione){
			$dimensionUno[$tipoDimensione["Id"]] = $tipoDimensione["Nombre"];
		}


		$dimensionDos = "";
		foreach($tipoDimensiones[2] as $tipoDimensioneDos)
		{
			/////pr($tipoDimensioneDos);
			$dimensionDos[$tipoDimensioneDos["Id"]] = $tipoDimensioneDos["Nombre"];
		}
			//array_unshift($dimensionDos, $vacio);
			$this->set("dimensionDos", $dimensionDos);
		$dimensionTres = "";
		foreach($tipoDimensiones[3] as $tipoDimensioneTres)
		{
			$dimensionTres[$tipoDimensioneTres["Id"]] = $tipoDimensioneTres["Nombre"];
		}
			//array_unshift($dimensionTres, $vacio);
			$this->set("dimensionTres", $dimensionTres);
		$dimensionCuatro = "";
		foreach($tipoDimensiones[4] as $tipoDimensioneCuatro)
		{
			$dimensionCuatro[$tipoDimensioneCuatro["Id"]] = $tipoDimensioneCuatro["Nombre"];
		}
			//array_unshift($dimensionCuatro, $vacio);
			$this->set("dimensionCuatro", $dimensionCuatro);

			$dimensionCinco = "";
			foreach($tipoDimensiones[5] as $tipoDimensioneCinco)
			{
				$dimensionCinco[$tipoDimensioneCinco["Id"]] = $tipoDimensioneCinco["Nombre"];
			}
			//array_unshift($dimensionCinco, $vacio);
			$this->set("dimensionCinco", $dimensionCinco);

		if (!$this->ComprasTarjeta->exists($id)) {
			
			throw new NotFoundException(__('Invalid compras tarjeta'));
		}

		$compra = $this->ComprasTarjeta->find('first', array(
			'conditions'=>array('ComprasTarjeta.id'=>$id)
		));


	//	pr($compra['ComprasTarjeta']['codigos_presupuesto_id']);
	//	exit;

		$codigoPresupuestoId = $this->CodigosPresupuesto->find('first', array(
			'conditions'=>array('CodigosPresupuesto.codigo'=>$compra['ComprasTarjeta']['codigos_presupuesto_id'] )
		));
//exit;
		if ($this->request->is(array('post', 'put'))) {

			$nombreMoneda = $this->TiposMoneda->find('first', array(
				'conditions'=>array('TiposMoneda.id'=>$this->request->data['ComprasTarjeta']['tipos_moneda_id'])
			));

		
			
			$this->request->data['ComprasTarjeta']['dimensione_id'] = $this->request->data['ComprasTarjeta']['dimensione_id'];
			$this->request->data['ComprasTarjeta']['codigos_presupuesto_id'] = $this->request->data['ComprasTarjeta']['codigo_presupuesto_id'];

			if(count($this->data['ComprasTarjeta']['documento'])>0){

				if(!empty($this->data['ComprasTarjeta']['documento']['name'])){
					$destino = WWW_ROOT.'files'.DS.'comprasTarjeta'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
				if (!file_exists($destino))
				{
					mkdir($destino, 0777, true);
					chmod($destino, 0777);
				}
					$url = $destino . DS .$this->data['ComprasTarjeta']['documento']['name'];
					move_uploaded_file($this->data['ComprasTarjeta']['documento']['tmp_name'], $url);
					$doc = $compra['ComprasTarjeta']['url_documentos'].",".$url;
				$this->request->data['ComprasTarjeta']['url_documentos'] = $doc;

				}

				
			}

			$this->request->data['ComprasTarjeta']['id'] = $id;
			$this->request->data['ComprasTarjeta']['compras_tarjetas_estado_id'] = 3;
			
			if ($this->ComprasTarjeta->save($this->request->data)) {
				$aprobador = $this->EmailsAprobador->find('list', array(
					'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>$codigoDimensionId['Dimensione']['codigo_corto'], 'EmailsAprobador.modulo' =>'tarjeta')
				));

				$nameUser = $this->User->find('first', array(
					'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
				));

				$envioEmail=$aprobador;
				if(!empty($envioEmail))
				{
					$Email = new CakeEmail("gmail");
					$Email->from(array('sgi@cdf.cl' => 'SGI'));
					$Email->to($envioEmail);//($email[0]["Email"]["email"]);
					$Email->subject("Solicitud compra Tarjeta");
					$Email->emailFormat('html');
					$Email->template('solicitud_compra_tarjeta');
					$Email->viewVars(array(
						"usuario"=>$nameUser['User']['nombre'],
						"producto"=>$this->request->data['ComprasTarjeta']['url_producto'],
						"fecha_compra"=>date('Y-m-d'),
						"moneda"=>$nombreMoneda['TiposMoneda']['nombre'],
						"monto"=>$this->request->data['ComprasTarjeta']['monto'],
						"cuota"=>$this->request->data['ComprasTarjeta']['cuota'],
						/*"titulo"=>$this->data["titulo"],
						"total"=>$this->data["total"],
						"empresa"=>$empresa["Company"]["nombre"]*/
					));
					$Email->send();
				}
				$this->Session->setFlash('Registrado Actualizado correctamente', 'msg_exito');
				CakeLog::write('actividad', 'Edita solicitud de compra con tarjeta' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				return $this->redirect(array('action' => 'view_solicitante'));
			} else {
				$this->Session->setFlash('No se puedo ingresar la inforación', 'msg_fallo');
			}
		} else {
			$options = array('conditions' => array('ComprasTarjeta.' . $this->ComprasTarjeta->primaryKey => $id));
			$this->request->data = $this->ComprasTarjeta->find('first', $options);
			$codigoDimensionId = $this->Dimensione->find('first', array(
				'conditions'=>array('Dimensione.codigo'=> $this->request->data['ComprasTarjeta']['dimensione_id'] )
			));

			/*
			variable año resplazar date('y')
			*/
			$codigoPresupuestoId = $this->CodigosPresupuesto->find('list', array(
				'conditions'=>array('CodigosPresupuesto.codigo LIKE'=> $codigoDimensionId['Dimensione']['codigo_corto'].'%' ,'CodigosPresupuesto.year_id'=> date('y'),'CodigosPresupuesto.estado'=> 1),
				'fields'=>array('CodigosPresupuesto.id', 'CodigosPresupuesto.nombre')
			));
			
            
            $this->set('codigoPresupuestoIdOsirus', $compra['ComprasTarjeta']['codigos_presupuesto_id']);
            
			$this->set('urlDocumento', $this->request->data['ComprasTarjeta']['url_documentos']);
			$this->set('codigoPresupuestoId', $codigoPresupuestoId);
			$this->set('tipoMonedas', $tipoMonedas);
			$this->set("dimensione", $dimensionUno);
			$this->set('estado', $estado);
		}
		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null, $solicitante=null) {

		$this->layout=null;
		if (!$this->ComprasTarjeta->exists($id)) {
					
			throw new NotFoundException(__('Invalid compras tarjeta'));
		}
		if ($this->request->is(array('get', 'put'))) {
			$this->request->data['ComprasTarjeta']['id']=$id;
			$this->request->data['ComprasTarjeta']['estado']=0;
		

			if ($this->ComprasTarjeta->save($this->request->data)) {
				echo json_encode(array(
					'success'=>true,
					'datax' => $this->list_compras_tarjeta()
				));
				$this->Session->setFlash('Registrado eliminado', 'msg_exito');
				CakeLog::write('actividad', 'Elimina solicitud compra con tarjeta' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));

				if($solicitante==1){
					return $this->redirect(array('action' => 'view_solicitante'));
				}else{
					return $this->redirect(array('action' => 'view_general'));
				}

				if($solicitante==3){
					return $this->redirect(array('action' => 'view_area'));
				}
					
			} else {
				return false;
			//	$this->Session->setFlash(__('The compras tarjeta could not be deleted. Please, try again.'));
			}

		}
	}

	public function estado() {

		Configure::write('debug', 2);
			 
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("ComprasTarjeta");
		$this->loadModel("Dimensione");

		$id=$this->request->query['id'];

		$estadosCompras= isset($this->request->query['idEstado'])?$this->request->query['idEstado']:$this->request->query['idEstadoCompra'];



		if($estadosCompras==4 || $estadosCompras==8 || $estadosCompras==9){

			$idEstado = $this->request->query['idEstadoCompra'];
		}else{
			$idEstado = $this->request->query['idEstado'];
		}

		if (!$this->ComprasTarjeta->exists($id)) {
					
			throw new NotFoundException(__('Invalid compras tarjeta'));
		}
		if ($this->request->is(array('get', 'put'))) {

			
			
			$this->request->data['ComprasTarjeta']['compras_tarjetas_estado_id'] = $idEstado;
			$this->request->data['ComprasTarjeta']['id'] = $this->request->query['id'];

			//exit;

			if ($this->ComprasTarjeta->save($this->request->data)) {

				$estado = $this->ComprasTarjetasEstado->find('first', array(
					'conditions'=>array('ComprasTarjetasEstado.id' =>$idEstado)
				));

				$producto = $this->ComprasTarjeta->find('first', array(
					'conditions'=>array('ComprasTarjeta.id' =>$id)
				));

				$codigoDimensionId = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo'=> $producto['ComprasTarjeta']['dimensione_id'] )
				));

				$emailUser = $this->User->find('first', array(
					'conditions'=>array('User.id' => $producto['ComprasTarjeta']['user_id'] )
				));
				

				if($estado['ComprasTarjetasEstado']['codigo']=='AA'){
					$aprobador = $this->EmailsAprobador->find('list', array(
						'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>array('FZ',$codigoDimensionId['Dimensione']['codigo_corto']), 'EmailsAprobador.modulo' =>'tarjeta')
					));
				}

				if($estado['ComprasTarjetasEstado']['codigo']=='FZ'){
					$aprobador = $this->EmailsAprobador->find('list', array(
						'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>array('GG',$codigoDimensionId['Dimensione']['codigo_corto']), 'EmailsAprobador.modulo' =>'tarjeta')
					));
				}

				if($estado['ComprasTarjetasEstado']['codigo']=='GG'){
					$aprobador = $this->EmailsAprobador->find('list', array(
						'conditions'=>array('EmailsAprobador.codigo_presupuesto' =>array('FZ',$codigoDimensionId['Dimensione']['codigo_corto']), 'EmailsAprobador.modulo' =>'tarjeta')
					));
				}

			
				if(!empty($this->request->query['observacion'])){
					$this->observacionComprasTarjeta($this->request->query['id'],$this->request->query['observacion']);
					$observacion =  $this->request->query['observacion'];


					$aprobador[]=$emailUser['Trabajadore']['email'];

				}else{
					if($idEstado!=9){
						$observacion = 'Se acepta solicitud';
					}else{
						$observacion = 'Por comprar';
					}
					
				}
				
					switch ($idEstado) {
						case 1:
							$subject = "Jefe área aprueba solicitud compra Tarjeta";
							
							
						break;
						case 2:
							$subject = "Gerencia general aprueba solicitud compra Tarjeta";
							
						break;
						case 3:
							$subject = "En curso";
						break;
						case 4:
							$subject = "Gerencia finanza aprueba solicitud compra Tarjeta";
							
						break;
						case 5:
							$subject = "Jefe área no aprueba solicitud compra Tarjeta";
							
						break;
						case 6:
							$subject = "Gerente general no aprueba solicitud compra Tarjeta";
							
						break;
						case 7:
							$subject = "Gerencia finanzas no aprueba solicitud compra Tarjeta";
							
						break;	
						case 9:
							$subject = "Gerencia finanzas por comprar solicitud compra Tarjeta";
							
						break;	
											
					}

					$envioEmail=$aprobador;
					if(!empty($envioEmail))
					{
						$Email = new CakeEmail("gmail");
						$Email->from(array('sgi@cdf.cl' => 'SGI'));
						$Email->to($envioEmail);//($email[0]["Email"]["email"]);
						$Email->subject($subject);
						$Email->emailFormat('html');
						$Email->template('rechazo_compra_tarjeta');
						$Email->viewVars(array(
							"usuario"=>$this->Session->read("Users.nombre"),
							"producto"=>$producto['ComprasTarjeta']['url_producto'],
							"fecha_compra"=>date('Y-m-d'),
							"motivo"=>$observacion
						));
						$Email->send();
					}
				//}

				$this->Session->setFlash('Registrado Actualizado correctamente', 'mensaje');
				CakeLog::write('actividad', 'Modifica estado compra con tarjeta' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
				

				switch ($idEstado) {
					case 1:
						return $this->redirect(array('action' => 'view_area'));
						$this->Session->setFlash('Registrado actualizado', 'msg_exito');
						
					break;
					case 2:
					return $this->redirect(array('action' => 'view_gerente'));
					$this->Session->setFlash('Registrado actualizado', 'msg_exito');
						
					break;
					case 4:
					//return $this->redirect(array('action' => 'index'));
					$this->Session->setFlash('Registrado actualizado', 'msg_exito');
						
					break;
					case 5:
						return $this->redirect(array('action' => 'view_area'));
						$this->Session->setFlash('Registrado actualizado', 'msg_exito');
						
					break;
					case 6:
			
					return $this->redirect(array('action' => 'view_gerente'));
					$this->Session->setFlash('Registrado actualizado', 'msg_exito');
						
					break;
					case 7:
					//return $this->redirect(array('action' => 'index'));
					$this->Session->setFlash('Registrado actualizado', 'msg_exito');
						
					break;	
					case 9:
					//return $this->redirect(array('action' => 'index'));
					$this->Session->setFlash('Registrado actualizado', 'msg_exito');
						
					break;	
					default:
					//return $this->redirect(array('action' => 'index'));
					$this->Session->setFlash('Registrado actualizado', 'msg_exito');				
				}

			} else {

				return false;
			//	$this->Session->setFlash(__('The compras tarjeta could not be deleted. Please, try again.'));
			}
				exit;
		}
	}


	public function respuesta(){
		$this->layout=null;
		$id=$this->request->query['id'];

		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");

		$listaCompras = $this->ComprasTarjeta->find("first",array(
			'conditions'=>array('ComprasTarjeta.id' =>$id )
		));

		$codigo = $listaCompras['ComprasTarjeta']['compras_tarjetas_estado_id'];

		$emailUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
		));

		$aprobador = $this->EmailsAprobador->find('first', array(
			'conditions'=>array('EmailsAprobador.emails' =>$emailUser['Trabajadore']['email'], 'EmailsAprobador.modulo' =>'tarjeta')
		));

		if(count($aprobador)>0){
			$evaluador = true;
		}else{
			$evaluador = false;
		}

		$salida = array("codigo"=>$codigo,"evaluador"=>$evaluador);
		echo json_encode(array(
			'success'=>true,
			'datax' =>$salida
		));

		exit;
	}

	public function list_compras_tarjeta(){
		
		$this->layout=null;
		$this->response->type('json');
		$this->autoRender = false;

		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("ComprasTarjetasObservacion");

		$emailUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
		));

		$aprobador = $this->EmailsAprobador->find('first', array(
			'conditions'=>array('EmailsAprobador.emails' => $emailUser['Trabajadore']['email'], 'EmailsAprobador.modulo' =>'tarjeta')
		));

		$codigo = isset($aprobador['EmailsAprobador']['codigo_presupuesto']) ? $aprobador['EmailsAprobador']['codigo_presupuesto'] : NULL;

		//$ids = 2;//isset( $this->request->query['estado'] ) ? $this->request->query['estado'] : $id;

	/*	$estado = $this->ComprasTarjetasEstado->find('first', array(
			'conditions'=>array('ComprasTarjetasEstado.id'=> $this->request->query['estado'] )
		));*/

//$estado['ComprasTarjetasEstado']['id']


		if(!empty($this->request->query['estado'])){

					$listaCompras = $this->ComprasTarjeta->find("all",array(
						'conditions'=>array(
							'ComprasTarjeta.estado'=> 1,
							'ComprasTarjeta.compras_tarjetas_estado_id'=>array($this->request->query['estado'],9),
						)
					));
		
			if(!empty($listaCompras)){
				$salida = "";
				foreach($listaCompras as $listaCompra){	
					$codigoDimensionId = $this->Dimensione->find('first', array(
						'conditions'=>array('Dimensione.codigo'=> $listaCompra['ComprasTarjeta']['dimensione_id'] )
					));	
					
					$nombreMoneda = $this->TiposMoneda->find('first', array(
						'conditions'=>array('TiposMoneda.id'=> $listaCompra['ComprasTarjeta']['tipos_moneda_id'] )
					));

					$salida[] = array(
						'id'=> $listaCompra['ComprasTarjeta']['id'],
						'fechaRequerimiento' => $listaCompra['ComprasTarjeta']['created'],
						'moneda'=>$nombreMoneda['TiposMoneda']['nombre'],
						'fecha_compra'=> $listaCompra['ComprasTarjeta']['modified'],
						'url_producto'=> $listaCompra['ComprasTarjeta']['url_producto'],
						'monto'=> $listaCompra['ComprasTarjeta']['monto'],
						'cuota'=> $listaCompra['ComprasTarjeta']['cuota'],
						'motivo_rechazo'=> $listaCompra['ComprasTarjeta']['motivo_rechazo'],
						'codigos_presupuesto_id'=> $listaCompra['CodigosPresupuesto']['nombre'],
						'dimencione_id'=> $codigoDimensionId['Dimensione']['nombre'],
						'compras_tarjetas_estado_id'=> $listaCompra['ComprasTarjetasEstado']['descripcion'],
						'user_id'=> $listaCompra['User']['nombre']
					);
				}
				return json_encode($salida);
			}else{
				return json_encode(array());
			}
		}else{
			return json_encode(array('message'=>"no a ingresado nada"));
		}
		exit;
	}
	
	public function view_solicitante(){
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

	public function view_solicitante_json(){
		
		$this->layout=null;
		$this->response->type('json');
		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("ComprasTarjetasObservacion");

		

		$listaCompras = $this->ComprasTarjeta->find("all",array(
			'conditions'=>array(
				'ComprasTarjeta.estado'=>1, 
				'ComprasTarjeta.user_id'=>$this->Session->Read("PerfilUsuario.idUsuario"))
		));

		if(!empty($listaCompras)){
			$salida = "";
			foreach($listaCompras as $listaCompra){	
				$codigoDimensionId = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo'=> $listaCompra['ComprasTarjeta']['dimensione_id'] )
				));	
				
				$nombreMoneda = $this->TiposMoneda->find('first', array(
					'conditions'=>array('TiposMoneda.id'=> $listaCompra['ComprasTarjeta']['tipos_moneda_id'] )
				));

				$obsAprobador = $this->ComprasTarjetasObservacion->find('first', array(
					'conditions'=>array('ComprasTarjetasObservacion.compras_tarjetas_id' => $listaCompra['ComprasTarjeta']['id'] ),
					'order' => array('ComprasTarjetasObservacion.id' => 'DESC')
				));
				
				if(empty($obsAprobador['ComprasTarjetasObservacion']['observacion'])){
					$observacion='1';
				}else{
					$observacion=$obsAprobador['ComprasTarjetasObservacion']['observacion'];
				}

				$salida[] = array(
					'id'=> $listaCompra['ComprasTarjeta']['id'],
					'fechaRequerimiento' => $listaCompra['ComprasTarjeta']['created'],
					'moneda'=>$nombreMoneda['TiposMoneda']['nombre'],
					'fecha_compra'=> $listaCompra['ComprasTarjeta']['modified'],
					'url_producto'=> $listaCompra['ComprasTarjeta']['url_producto'],
					'monto'=> $listaCompra['ComprasTarjeta']['monto'],
					'cuota'=> $listaCompra['ComprasTarjeta']['cuota'],
					'motivo_rechazo'=> $listaCompra['ComprasTarjeta']['motivo_rechazo'],
					'codigos_presupuesto_id'=> $listaCompra['CodigosPresupuesto']['nombre'],
					'dimencione_id'=> $codigoDimensionId['Dimensione']['nombre'],
					'compras_tarjetas_estado_id'=> $listaCompra['ComprasTarjetasEstado']['descripcion'],
					'user_id'=> $listaCompra['User']['nombre'],
					'observacion'=>$observacion
				);
			}

			echo  json_encode($salida);
		
		}else{

			echo json_encode(array());
			
		}
		exit;
	}
	public function edit_solicitante(){}
	
	public function recurrecia(){}


	public function observacionComprasTarjeta($id="",$obs=""){

		$this->loadModel("ComprasTarjetasObservacion");
		
		$this->request->data['ComprasTarjetasObservacion']['compras_tarjetas_id'] = $id;

		$this->request->data['ComprasTarjetasObservacion']['fecha_observacion'] = date('Y-m-d');

		$this->request->data['ComprasTarjetasObservacion']['observacion'] = $obs;

		if ($this->ComprasTarjetasObservacion->save($this->request->data)) {

			$this->Session->setFlash('Registrado correctamente', 'msg_exito');

			CakeLog::write('actividad', 'Agrega solicitud de compra con tarjeta y envia mail' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		}
	}

	public function view_general(){
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

	public function view_compras_tarjeta_general(){
		
		$this->layout=null;
		$this->response->type('json');
		$this->autoRender = false;

		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("ComprasTarjetasObservacion");
		$this->loadModel("CodigosPresupuesto");

		
		$listaCompras = $this->ComprasTarjeta->find("all",array(
			'conditions'=>array('ComprasTarjeta.estado'=>1)
		));
		
		if(!empty($listaCompras)){
			$salida = "";
			foreach($listaCompras as $listaCompra){	

				
				$codigoDimensionId = $this->Dimensione->find('first', array(
					'conditions'=>array('Dimensione.codigo'=> $listaCompra['ComprasTarjeta']['dimensione_id'] )
				));	
				
				$nombreMoneda = $this->TiposMoneda->find('first', array(
					'conditions'=>array('TiposMoneda.id'=> $listaCompra['ComprasTarjeta']['tipos_moneda_id'] )
				));

				$presupuesto = $this->CodigosPresupuesto->find('first', array(
					'conditions'=>array('CodigosPresupuesto.id'=> $listaCompra['ComprasTarjeta']['codigos_presupuesto_id'] )
				));

				$obsAprobador = $this->ComprasTarjetasObservacion->find('first', array(
					'conditions'=>array('ComprasTarjetasObservacion.compras_tarjetas_id' => $listaCompra['ComprasTarjeta']['id'] ),
					'order' => array('ComprasTarjetasObservacion.id' => 'DESC')
				));
				
				if(empty($obsAprobador['ComprasTarjetasObservacion']['observacion'])){
					$observacion='';
				}else{
					$observacion=$obsAprobador['ComprasTarjetasObservacion']['observacion'];
				}

				if(empty($listaCompra['ComprasTarjeta']['recurrencia'])){
					$concurrencia = 'NO';
				}else{
					$concurrencia = 'SI';
				}

				$salida[] = array(
					'id'=> $listaCompra['ComprasTarjeta']['id'],
					'fechaRequerimiento' => $listaCompra['ComprasTarjeta']['created'],
					'moneda'=>$nombreMoneda['TiposMoneda']['nombre'],
					'fecha_compra'=> $listaCompra['ComprasTarjeta']['modified'],
					'url_producto'=> $listaCompra['ComprasTarjeta']['url_producto'],
					'monto'=> $listaCompra['ComprasTarjeta']['monto'],
					'cuota'=> $listaCompra['ComprasTarjeta']['cuota'],
					'motivo_rechazo'=> $listaCompra['ComprasTarjeta']['motivo_rechazo'],
					'codigos_presupuesto_id'=> $listaCompra['CodigosPresupuesto']['nombre'],
					'dimencione_id'=> $codigoDimensionId['Dimensione']['nombre'],
					'compras_tarjetas_estado_id'=> $listaCompra['ComprasTarjetasEstado']['descripcion'],
					'user_id'=> $listaCompra['User']['nombre'],
					'recurrencia'=>$concurrencia,
					'observacion'=>$observacion
				);
			}
			return json_encode($salida);
		}else{
			return json_encode(array());
		}
		exit;
	}


	public function view_area(){
		$this->layout = "angular";

		$this->loadModel("ComprasTarjetasEstado");
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

		$estado = $this->ComprasTarjetasEstado->find('first', array(
			'conditions'=>array('ComprasTarjetasEstado.id'=> 3 )
		));
		$this->set("codigo", $estado);

	}


	public function list_compras_area(){
		
		$this->layout=null;
		$this->response->type('json');
		$this->autoRender = false;

		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("ComprasTarjetasObservacion");

		$emailUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
		));

		$aprobador = $this->EmailsAprobador->find('all', array(
			'conditions'=>array('EmailsAprobador.emails' =>$emailUser['Trabajadore']['email'], 'EmailsAprobador.modulo' =>'tarjeta'),
			'fields'=>array('EmailsAprobador.codigo_presupuesto')
		));

		$codigoPresupuesto = [];
		foreach($aprobador as $k=>$j){
			$codigoPresupuesto[$k] = $j['EmailsAprobador']['codigo_presupuesto'];
		}

		$codigo = isset($aprobador['EmailsAprobador']['codigo_presupuesto']) ? $aprobador['EmailsAprobador']['codigo_presupuesto'] : NULL;

		$estado = $this->ComprasTarjetasEstado->find('first', array(
			'conditions'=>array('ComprasTarjetasEstado.id'=> $this->request->query['estado'])
		));

		if(!empty($this->request->query['estado'])){

				$index = [];
				$codigoDimensionId = $this->Dimensione->find('all', array(
					'conditions'=>array('Dimensione.codigo_corto'=> $codigoPresupuesto)
				));

				foreach($codigoDimensionId as $k=>$j){
					$index[$k] = $j['Dimensione']['codigo'];
				}

					$listaCompras = $this->ComprasTarjeta->find("all",array(
						'conditions'=>array(
							'ComprasTarjeta.estado'=> 1,
							'ComprasTarjeta.compras_tarjetas_estado_id'=>$this->request->query['estado'],
							//'ComprasTarjeta.dimensione_id' => $index 
						)
					));
			
			if(!empty($listaCompras)){
				$salida = "";
				foreach($listaCompras as $listaCompra){	
					$codigoDimensionId = $this->Dimensione->find('first', array(
						'conditions'=>array('Dimensione.codigo'=> $listaCompra['ComprasTarjeta']['dimensione_id'] )
					));	
					
					$nombreMoneda = $this->TiposMoneda->find('first', array(
						'conditions'=>array('TiposMoneda.id'=> $listaCompra['ComprasTarjeta']['tipos_moneda_id'] )
					));

					$salida[] = array(
						'id'=> $listaCompra['ComprasTarjeta']['id'],
						'fechaRequerimiento' => $listaCompra['ComprasTarjeta']['created'],
						'moneda'=>$nombreMoneda['TiposMoneda']['nombre'],
						'fecha_compra'=> $listaCompra['ComprasTarjeta']['modified'],
						'url_producto'=> $listaCompra['ComprasTarjeta']['url_producto'],
						'monto'=> $listaCompra['ComprasTarjeta']['monto'],
						'cuota'=> $listaCompra['ComprasTarjeta']['cuota'],
						'motivo_rechazo'=> $listaCompra['ComprasTarjeta']['motivo_rechazo'],
						'codigos_presupuesto_id'=> $listaCompra['CodigosPresupuesto']['nombre'],
						'dimencione_id'=> $codigoDimensionId['Dimensione']['nombre'],
						'compras_tarjetas_estado_id'=> $listaCompra['ComprasTarjetasEstado']['descripcion'],
						'user_id'=> $listaCompra['User']['nombre']
					);
				}
				return json_encode($salida);
			}else{
				return json_encode(array());
			}
		}else{
			return json_encode(array('message'=>"no a ingresado nada"));
		}
		exit;
	}

	public function view_gerente(){
		$this->layout = "angular";
		$this->loadModel("ComprasTarjetasEstado");

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
		$estado = $this->ComprasTarjetasEstado->find('first', array(
			'conditions'=>array('ComprasTarjetasEstado.id'=> 1 )
		));
		$this->set("codigo", $estado);

	}

	public function list_aprobador_gerencia($id=""){
	
		$this->layout=null;
		$this->response->type('json');
		$this->autoRender = false;

		$this->loadModel("TiposMoneda");
		$this->loadModel("Dimensione");
		$this->loadModel("User");
		$this->loadModel("EmailsAprobador");
		$this->loadModel("ComprasTarjetasEstado");
		$this->loadModel("ComprasTarjetasObservacion");

		$emailUser = $this->User->find('first', array(
			'conditions'=>array('User.id' => $this->Session->Read("PerfilUsuario.idUsuario"))
		));

		$aprobador = $this->EmailsAprobador->find('first', array(
			'conditions'=>array('EmailsAprobador.emails' => $emailUser['Trabajadore']['email'], 'EmailsAprobador.modulo' =>'tarjeta')
		));

		$codigo = isset($aprobador['EmailsAprobador']['codigo_presupuesto']) ? $aprobador['EmailsAprobador']['codigo_presupuesto'] : NULL;

	//	$ids = 2;//isset( $this->request->query['estado'] ) ? $this->request->query['estado'] : $id;

		$estado = $this->ComprasTarjetasEstado->find('first', array(
			'conditions'=>array('ComprasTarjetasEstado.id'=> $this->request->query['estado'])
		));

		if(!empty($this->request->query['estado'])){

					$listaCompras = $this->ComprasTarjeta->find("all",array(
						'conditions'=>array(
							'ComprasTarjeta.estado'=> 1,
							'ComprasTarjeta.compras_tarjetas_estado_id'=>$this->request->query['estado']
						)
					));
		
			if(!empty($listaCompras)){
				//$salida = "";
				foreach($listaCompras as $listaCompra){	
					$codigoDimensionId = $this->Dimensione->find('first', array(
						'conditions'=>array('Dimensione.codigo'=> $listaCompra['ComprasTarjeta']['dimensione_id'] )
					));	
					
					$nombreMoneda = $this->TiposMoneda->find('first', array(
						'conditions'=>array('TiposMoneda.id'=> $listaCompra['ComprasTarjeta']['tipos_moneda_id'] )
					));

					$salida[] = array(
						'id'=> $listaCompra['ComprasTarjeta']['id'],
						'fechaRequerimiento' => $listaCompra['ComprasTarjeta']['created'],
						'moneda'=>$nombreMoneda['TiposMoneda']['nombre'],
						'fecha_compra'=> $listaCompra['ComprasTarjeta']['modified'],
						'url_producto'=> $listaCompra['ComprasTarjeta']['url_producto'],
						'monto'=> $listaCompra['ComprasTarjeta']['monto'],
						'cuota'=> $listaCompra['ComprasTarjeta']['cuota'],
						'motivo_rechazo'=> $listaCompra['ComprasTarjeta']['motivo_rechazo'],
						'codigos_presupuesto_id'=> $listaCompra['CodigosPresupuesto']['nombre'],
						'dimencione_id'=> $codigoDimensionId['Dimensione']['nombre'],
						'compras_tarjetas_estado_id'=> $listaCompra['ComprasTarjetasEstado']['descripcion'],
						'user_id'=> $listaCompra['User']['nombre']
					);
				}
				return json_encode($salida);
			}else{
				return json_encode(array());
			}
		}else{
			return json_encode(array('message'=>"no a ingresado nada"));
		}
		exit;
	}




	public function insertRecurrencia(){
		$this->layout=null;
		$this->loadModel("ComprasTarjetasRecurrencium");
		//$this->request->data['CompraTarjetaRecurrencium']['id'] = $this->request->query['estado'];
		$this->request->data['ComprasTarjetasRecurrencium']['fecha'] = date('Y-m-d');
		$this->request->data['ComprasTarjetasRecurrencium']['folio'] = $this->request->query['folio'];
		$this->request->data['ComprasTarjetasRecurrencium']['monto'] = $this->request->query['monto'];
		$this->request->data['ComprasTarjetasRecurrencium']['id_usuario'] = $this->Session->Read("PerfilUsuario.idUsuario");
		$this->request->data['ComprasTarjetasRecurrencium']['id_solicitud'] = $this->request->query['idCompra'];

		if ($this->ComprasTarjetasRecurrencium->save($this->request->data)) {
			$this->Session->setFlash('Recurrecia Ingresada', 'msg_exito');
			CakeLog::write('actividad', 'Agrega recurrencia mensual a solicitud' . $this->Session->Read("PerfilUsuario.idUsuario") . 'usuario'. $this->Session->Read("PerfilUsuario.idUsuario"));
		}
	}

public function btn_view_todos(){
	
}
}
