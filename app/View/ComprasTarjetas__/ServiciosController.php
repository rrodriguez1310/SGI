<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('File', 'Utility');
App::uses('HttpSocket', 'Network/Http');

class ServiciosController extends AppController {

    public $components = array('RequestHandler');
	
	public function buscaAreas()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		$this->layout = null;
		$this->loadModel("Area");
		
		$buscaAreas = $this->Area->find('all', array(
			'conditions'=>array('gerencia_id'=>$this->params->query["gerencia"], 'Area.estado'=>1),
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

    public function buscaCargos()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		$this->layout = null;
		$this->loadModel("Cargo");
		
		$buscaCargos = $this->Cargo->find('all', array(
			'conditions'=>array('area_id'=>$this->params->query["area"], 'Cargo.estado'=>1),
			'fields'=>array("Cargo.id", "Cargo.nombre"),
			'order'=>'Cargo.nombre ASC'
		));
		
		$cargos = "";
		foreach($buscaCargos as $buscaCargo)
		{
			$cargos[] = array("Id"=>$buscaCargo["Cargo"]["id"], "Nombre"=>$buscaCargo["Cargo"]["nombre"]); 
		}

		if(!empty($cargos))
		{
			echo json_encode($cargos);
		}
		else
		{
			echo "1";
		}		
		exit;
	}
	
	public function compraUnitario()
	{
		if(!empty($this->data))
		{
			echo json_encode($this->data);
		}
		exit;
	}
	
	public function codigoPresupuestario()
	{

		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}


		if($this->params->isAjax == 1)
		{
			$codigoPresupuesto = "";
			
			if(!empty($this->params->query["valor"]))
			{			
				$codigo = explode(" - ", $this->params->query["valor"]);


				$this->loadModel("Dimensione");
				

				$codigoCorto = $this->Dimensione->findByCodigo($codigo[0]);

				if(!empty($codigoCorto["Dimensione"]["codigo_corto"]))
				{
					$this->loadModel("CodigosPresupuesto");
					$this->loadModel("Year");

					$idAgno = $this->Year->find("first", array(
						'conditions'=>array("Year.nombre"=>date('Y'))
					));

					$codigosPresupuestarios = $this->CodigosPresupuesto->find("all", array(
						//'fields'=>array('CodigosPresupuesto.codigo', 'CodigosPresupuesto.nombre'),
						'conditions'=>array(
							'CodigosPresupuesto.codigo LIKE'=>$codigoCorto["Dimensione"]["codigo_corto"].'%',
							'CodigosPresupuesto.year_id'=> $idAgno["Year"]["id"],
							'CodigosPresupuesto.estado' => 1
						),
						//"group" => array("CodigosPresupuesto.codigo", "CodigosPresupuesto.nombre")
					));
				}




				if(!empty($codigosPresupuestarios))
				{
					foreach($codigosPresupuestarios as $codigosPresupuestario)
					{
						$codigoPresupuesto[] =  array( "Id"=>$codigosPresupuestario["CodigosPresupuesto"]["id"], "Nombre"=>$codigosPresupuestario["CodigosPresupuesto"]["codigo"] . ' - ' . $codigosPresupuestario["CodigosPresupuesto"]["nombre"]); 
					}
				}
			}

			echo json_encode($codigoPresupuesto);
		}
		else
		{
			$this -> Session -> setFlash('Estas intentando entrar sin permiso', 'msg_fallo');
			return $this -> redirect(array("controller" => 'compras', "action" => 'index'));
		}
		exit;
	}





	public function addOrdenCompra()
	{
		$this->layout = "ajax";
		$estado = "";
		
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		if(!empty($this->request->data))
		{

			if(!empty($this->request->data["adjunto"]))
			{
				$nombresFotos = "";
			
				foreach($this->request->data["adjunto"] as $adjunto)
				{
					if($adjunto['error'] == 0 && $adjunto['size'] > 0)
					{
		             	$destino = WWW_ROOT.'files'.DS.'orden_compra'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
		             	
		             	if (!file_exists($destino))
						{
							mkdir($destino, 0777, true);
							chmod($destino, 0777);
						}
						
						if(is_uploaded_file($adjunto['tmp_name']))
						{
							if($adjunto['size'] <= 7000000)
							{
								move_uploaded_file($adjunto['tmp_name'], $destino . DS .$adjunto['name']);
								$nombresFotos[] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$adjunto['name'];
							}
							else
							{
	
								$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
								return $this->redirect(array("controller" => 'compras', "action" => 'index'));
								$estado = 2;
								exit;
							}
						}
						else
						{
							$this->Session->setFlash('NO GUARDO!! Ocurrio un problema', 'msg_fallo');
							return $this->redirect(array("controller" => 'compras', "action" => 'index'));
							$estado = 2;
							exit;	
						}
					}
				}
			}
			
			$this->loadModel("ComprasProductosTotale");
			$idProductos = "";
			$idTotal = "";
			$mensaje = "El requerimiento de compra se genero correctamente";
			if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 2)
			{
				$idTotal = $this->request->data["id_clonado"];
				$idProductos = $this->request->data["idProducto"];
				$mensaje = "El requerimiento de compra se edito correctamente";
				CakeLog::write('actividad', 'edito - ' .$this->request->data["id_clonado"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));

			}
			
			//else
			//{
			//	$this->request->data["ComprasProductosTotale"]["adjunto"] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->data['adjunto']['name'];
			//}

			if(!empty($this->request->data["tipo_cambio"]))
			{
				$this->request->data["ComprasProductosTotale"]["tipo_cambio"] = $this->request->data["tipo_cambio"];
			}
			$this->request->data["ComprasProductosTotale"]["id"] = $idTotal;
			$this->request->data["ComprasProductosTotale"]["company_id"] = $this->data["company_id"];
			$this->request->data["ComprasProductosTotale"]["descuento_total"] = str_replace('.', '', $this->data["monto"]);
			$this->request->data["ComprasProductosTotale"]["impuesto"] = $this->data["tipoImpuesto"];
			$this->request->data["ComprasProductosTotale"]["total"] = str_replace('.', '', $this->data["total"]); 
			//$this->request->data["ComprasProductosTotale"]["fecha"] = date("Y-m-d", strtotime($this->data["fecha_entrega"]));
			$this->request->data["ComprasProductosTotale"]["plazos_pago_id"] = $this->data["plazos_pago_id"];
			$this->request->data["ComprasProductosTotale"]["tipos_moneda_id"] = $this->data["tipo_moneda_id"];
			$this->request->data["ComprasProductosTotale"]["observacion"] = $this->data["observacion"];
			$this->request->data["ComprasProductosTotale"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data["ComprasProductosTotale"]["sub_total"] = 0;
			//if(isset($this->data['adjunto']['name']))
			if(!empty($nombresFotos))
			{
				$this->request->data["ComprasProductosTotale"]["adjunto"] = serialize($nombresFotos);  //date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->data['adjunto']['name'];
			}
			$this->request->data["ComprasProductosTotale"]["neto_descuento"] = $this->data["neto_descuento"];
			$this->request->data["ComprasProductosTotale"]["titulo"] = $this->data["titulo"];
			$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 1;

			if($this->ComprasProductosTotale->save($this->request->data))
			{
				CakeLog::write('actividad', 'Ingreso la orden de compra N°- ' .$this->ComprasProductosTotale->id . ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->loadModel("ComprasProducto");
				
				$idComprasTotales = $this->ComprasProductosTotale->id;
				
				if(!empty($idComprasTotales))
				{
					$productoArray = "";

					foreach($this->data["dimCodigoUno"] as $key => $productosTodos)
					{
						//pr($idProductos[$key]);exit;

						$productoArray[] = array(
							"id" => $idProductos[$key],
							'dim_uno'=>$productosTodos,
							'proyecto'=>$this->request->data["proyecto"][$key],
							'cantidad'=>$this->request->data["cantidad"][$key],
							'precio_unitario'=>$this->request->data["precio"][$key],
							'empaque'=>$this->request->data["empaque"][$key],
							'descuento_producto'=>$this->request->data["descuento_unitario"][$key],
							'codigos_presupuestarios'=>$this->request->data["codigoPresupuestario"][$key],
							'descripcion'=>$this->request->data["descripcion"][$key],
							'dim_dos'=>$this->request->data["dimCodigoDos"][$key],
							'dim_tres'=>$this->request->data["dimCodigoTres"][$key],
							'dim_cuatro'=>$this->request->data["dimCodigoCuatro"][$key],
							'dim_cinco'=>$this->request->data["dimCodigoCinco"][$key],
							'compras_productos_totale_id'=>$idComprasTotales,
							'estado'=>1,
							'subtotal'=>$this->request->data["subToal"][$key],
							"afecto" => $this->request->data["afecto"][$key],
						);
					}


					$idProductos = "";					
					if($this->ComprasProducto->saveAll($productoArray))
					{
						CakeLog::write('actividad', 'Ingresaron los productos asociados a la orden de compra N°- ' .$this->ComprasProductosTotale->id . ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));

						$comprasProductosId = $this->ComprasProducto->id;
						$idProductos[] = $this->ComprasProducto->id;
						
						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 1)
						{
							$this->request->data["ComprasProductosTotale"]["id"] =  $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["compras_estado_id"] =  0;
							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);

							CakeLog::write('actividad', 'Se clono la orden de compra - ' .$this->ComprasProductosTotale->id . ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						}
												
						if(!empty($this->data["codigoPresupuestario"]))
						{


							//pr($this->data["codigoPresupuestario"]);
							$aprobadores = "";

							foreach($this->data["codigoPresupuestario"] as $codigoCorto)
							{
								$aprobadores[] = 'Aprobador-'.substr($codigoCorto, 0, 2);
							}

							//pr($aprobadores);
							//exit;

							//$codigoCorto = explode("-", $this->data["codigoPresupuestario"][0]);
							
							$this->loadModel("Email");
							
							$email = $this->Email->find("all", array(
								'conditions'=>array("Email.informe"=>array_unique($aprobadores)),
								'fields'=>"Email.email"
							));


							$this->loadModel("Company");
							$empresa = $this->Company->find("first", array(
								"conditions"=>array("Company.id"=>$this->data["company_id"]),
								"fields"=>"Company.nombre"
							));

							$envioEmail = "";

							foreach ($email as $sendEmail) {
								$envioEmail[] = $sendEmail["Email"]["email"];
							}
							
							if(!empty($envioEmail))
							{
								$Email = new CakeEmail("gmail");
								$Email->from(array('sgi@cdf.cl' => 'SGI'));
								$Email->to($envioEmail);//($email[0]["Email"]["email"]);
								$Email->subject("Requerimiento por aprobar");
								$Email->emailFormat('html');
								$Email->template('orden_compra');
								$Email->viewVars(array(
									"usuario"=>$this->Session->read("Users.nombre"),
									"fechaCreacion"=>date("d/m/Y H:i"),
									"numeroRequerimiento"=>$this->ComprasProductosTotale->id,
									"titulo"=>$this->data["titulo"],
									"total"=>$this->data["total"],
									"empresa"=>$empresa["Company"]["nombre"]
								));
								$Email->send();
							}
						}
						else
						{
							$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
							$estado = 2;
							exit;
						}
					}
					$estado = 1;
				}
				else
				{
					$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
					$estado = 2;
					exit;
				}
			}
			else
			{
				$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
				$estado = 2;
				exit;
			}
		}
		if($estado == 1)
		{

			$this->Session->setFlash($mensaje, 'msg_exito');	
		}
		else
		{
			$this->Session->setFlash('El requerimiento de compra no se pudo generar', 'msg_fallo');
		}

		//echo $estado ;exit;


		$this->set("estado", $estado);
	}
	/*
	public function addOrdenCompra()
	{
		$this->layout = "ajax";

		$estado = "";
	
	
		
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		if(!empty($this->request->data))
		{

			if(!empty($this->request->data["adjunto"]))
			{
				$nombresFotos = "";
			
				foreach($this->request->data["adjunto"] as $adjunto)
				{
					if($adjunto['error'] == 0 && $adjunto['size'] > 0)
					{
		             	$destino = WWW_ROOT.'files'.DS.'orden_compra'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
		             	
		             	if (!file_exists($destino))
						{
							mkdir($destino, 0777, true);
							chmod($destino, 0777);
						}
						
						if(is_uploaded_file($adjunto['tmp_name']))
						{
							if($adjunto['size'] <= 7000000)
							{
								move_uploaded_file($adjunto['tmp_name'], $destino . DS .$adjunto['name']);
								$nombresFotos[] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$adjunto['name'];
							}
							else
							{
	
								$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
								return $this->redirect(array("controller" => 'compras', "action" => 'index'));
								$estado = 2;
								exit;
							}
						}
						else
						{
							$this->Session->setFlash('NO GUARDO!! Ocurrio un problema', 'msg_fallo');
							return $this->redirect(array("controller" => 'compras', "action" => 'index'));
							$estado = 2;
							exit;	
						}
					}
				}
			}
			
			$this->loadModel("ComprasProductosTotale");
			$idProductos = "";
			$idTotal = "";
			$mensaje = "El requerimiento de compra se genero correctamente";
			if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 2)
			{
				$idTotal = $this->request->data["id_clonado"];
				$idProductos = $this->request->data["idProducto"];
				$mensaje = "El requerimiento de compra se edito correctamente";
				CakeLog::write('actividad', 'edito - ' .$this->request->data["id_clonado"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));

			}
			else
			{
				$this->request->data["ComprasProductosTotale"]["adjunto"] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->data['adjunto']['name'];
			}

			if(!empty($this->request->data["tipo_cambio"]))
			{
				$this->request->data["ComprasProductosTotale"]["tipo_cambio"] = $this->request->data["tipo_cambio"];
			}
			$this->request->data["ComprasProductosTotale"]["id"] = $idTotal;
			$this->request->data["ComprasProductosTotale"]["company_id"] = $this->data["company_id"];
			$this->request->data["ComprasProductosTotale"]["descuento_total"] = str_replace('.', '', $this->data["monto"]);
			$this->request->data["ComprasProductosTotale"]["impuesto"] = $this->data["tipoImpuesto"];
			$this->request->data["ComprasProductosTotale"]["total"] = str_replace('.', '', $this->data["total"]); 
			//$this->request->data["ComprasProductosTotale"]["fecha"] = date("Y-m-d", strtotime($this->data["fecha_entrega"]));
			$this->request->data["ComprasProductosTotale"]["plazos_pago_id"] = $this->data["plazos_pago_id"];
			$this->request->data["ComprasProductosTotale"]["tipos_moneda_id"] = $this->data["tipo_moneda_id"];
			$this->request->data["ComprasProductosTotale"]["observacion"] = $this->data["observacion"];
			$this->request->data["ComprasProductosTotale"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data["ComprasProductosTotale"]["sub_total"] = 0;
			//if(isset($this->data['adjunto']['name']))
			if(!empty($nombresFotos))
			{
				$this->request->data["ComprasProductosTotale"]["adjunto"] = serialize($nombresFotos);  //date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->data['adjunto']['name'];
			}
			$this->request->data["ComprasProductosTotale"]["neto_descuento"] = $this->data["neto_descuento"];
			$this->request->data["ComprasProductosTotale"]["titulo"] = $this->data["titulo"];
			$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 1;

			if($this->ComprasProductosTotale->save($this->request->data))
			{
				CakeLog::write('actividad', 'Ingreso la orden de compra N°- ' .$this->ComprasProductosTotale->id . ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->loadModel("ComprasProducto");
				
				$idComprasTotales = $this->ComprasProductosTotale->id;
				
				if(!empty($idComprasTotales))
				{
					$productoArray = "";

					foreach($this->data["dimCodigoUno"] as $key => $productosTodos)
					{
						//pr($idProductos[$key]);exit;

						$productoArray[] = array(
							"id" => $idProductos[$key],
							'dim_uno'=>$productosTodos,
							'proyecto'=>$this->request->data["proyecto"][$key],
							'cantidad'=>$this->request->data["cantidad"][$key],
							'precio_unitario'=>$this->request->data["precio"][$key],
							'empaque'=>$this->request->data["empaque"][$key],
							'descuento_producto'=>$this->request->data["descuento_unitario"][$key],
							'codigos_presupuestarios'=>$this->request->data["codigoPresupuestario"][$key],
							'descripcion'=>$this->request->data["descripcion"][$key],
							'dim_dos'=>$this->request->data["dimCodigoDos"][$key],
							'dim_tres'=>$this->request->data["dimCodigoTres"][$key],
							'dim_cuatro'=>$this->request->data["dimCodigoCuatro"][$key],
							'dim_cinco'=>$this->request->data["dimCodigoCinco"][$key],
							'compras_productos_totale_id'=>$idComprasTotales,
							'estado'=>1,
							'subtotal'=>$this->request->data["subToal"][$key],
							"afecto" => $this->request->data["afecto"][$key],
						);
					}


					$idProductos = "";					
					if($this->ComprasProducto->saveAll($productoArray))
					{
						CakeLog::write('actividad', 'Ingresaron los productos asociados a la orden de compra N°- ' .$this->ComprasProductosTotale->id . ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));

						$comprasProductosId = $this->ComprasProducto->id;
						$idProductos[] = $this->ComprasProducto->id;
						
						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 1)
						{
							$this->request->data["ComprasProductosTotale"]["id"] =  $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["compras_estado_id"] =  0;
							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);

							CakeLog::write('actividad', 'Se clono la orden de compra - ' .$this->ComprasProductosTotale->id . ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						}
												
						if(!empty($this->data["codigoPresupuestario"]))
						{


							//pr($this->data["codigoPresupuestario"]);
							$aprobadores = "";

							foreach($this->data["codigoPresupuestario"] as $codigoCorto)
							{
								$aprobadores[] = 'Aprobador-'.substr($codigoCorto, 0, 2);
							}

							//pr($aprobadores);
							//exit;

							//$codigoCorto = explode("-", $this->data["codigoPresupuestario"][0]);
							
							$this->loadModel("Email");
							
							$email = $this->Email->find("all", array(
								'conditions'=>array("Email.informe"=>array_unique($aprobadores)),
								'fields'=>"Email.email"
							));


							$this->loadModel("Company");
							$empresa = $this->Company->find("first", array(
								"conditions"=>array("Company.id"=>$this->data["company_id"]),
								"fields"=>"Company.nombre"
							));

							$envioEmail = "";

							foreach ($email as $sendEmail) {
								$envioEmail[] = $sendEmail["Email"]["email"];
							}
							
							if(!empty($envioEmail))
							{
								$Email = new CakeEmail("gmail");
								$Email->from(array('sgi@cdf.cl' => 'SGI'));
								$Email->to($envioEmail);//($email[0]["Email"]["email"]);
								$Email->subject("Requerimiento por aprobar");
								$Email->emailFormat('html');
								$Email->template('orden_compra');
								$Email->viewVars(array(
									"usuario"=>$this->Session->read("Users.nombre"),
									"fechaCreacion"=>date("d/m/Y H:i"),
									"numeroRequerimiento"=>$this->ComprasProductosTotale->id,
									"titulo"=>$this->data["titulo"],
									"total"=>$this->data["total"],
									"empresa"=>$empresa["Company"]["nombre"]
								));
								$Email->send();
							}
						}
						else
						{
							$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
							$estado = 2;
							exit;
						}
						
					}
					$estado = 1;
				}
				else
				{
					$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
					$estado = 2;
					exit;
				}
			}
			else
			{
				$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
				$estado = 2;
				exit;
			}
		}
		if($estado == 1)
		{

			$this->Session->setFlash($mensaje, 'msg_exito');	
		}
		else
		{
			$this->Session->setFlash('El requerimiento de compra no se pudo generar', 'msg_fallo');
		}

		//echo $estado ;exit;


		$this->set("estado", $estado);
	}
	*/

	function sanearString($string)
	{
	
	    $string = trim($string);
	
	    $string = str_replace(
	        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
	        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	        $string
	    );
	
	    $string = str_replace(
	        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
	        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	        $string
	    );
	
	    $string = str_replace(
	        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
	        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	        $string
	    ); 
	
	    $string = str_replace(
	        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
	        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	        $string
	    );
	
	    $string = str_replace(
	        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
	        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	        $string
	    );
	
	    $string = str_replace(
	        array('ñ', 'Ñ', 'ç', 'Ç'),
	        array('n', 'N', 'c', 'C',),
	        $string
	    );
	
	    //Esta parte se encarga de eliminar cualquier caracter extraño
	    /*$string = str_replace(
	        array("\\", "¨", "º", "-", "~",
	             "#", "@", "|", "!", "\"",
	             "·", "$", "%", "&", "/",
	             "(", ")", "?", "'", "¡",
	             "¿", "[", "^", "`", "]",
	             "+", "}", "{", "¨", "´",
	             ">", "< ", ";", ",", ":",
	             ".", " "),
	        '',
	        $string
	    );*/
	
	
	    return $string;
	}

	public function saldo_codigo_presupuestario()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie SesiÃ³n', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		$idComprasProductosTotales = 0;


		if($this->params->isAjax == 1)
		{
			$this->loadModel("CodigosPresupuesto");

			$presupuestoItem = $this->CodigosPresupuesto->find("first", array(
				'conditions'=>array(
					"CodigosPresupuesto.codigo"=>$this->params->query["codigoPresupuestario"]
				),
				'fields'=>'CodigosPresupuesto.presupuesto_total'
			));

			$codigoCorto = explode("-", $this->params->query["codigoPresupuestario"]);

			$presupuestoArea = $this->CodigosPresupuesto->find("all", array(
				'conditions'=>array(
					"CodigosPresupuesto.codigo LIKE"=>'%'.$codigoCorto[0].'%',
				),
				'fields'=>'CodigosPresupuesto.presupuesto_total'
			));

			$sumaPresupuestoArea = "";
			foreach($presupuestoArea as $presupuestoArea)
			{
				$sumaPresupuestoArea[] = $presupuestoArea["CodigosPresupuesto"]["presupuesto_total"];
			}

			$this->loadModel("ComprasProducto");
			
			$gastadoItems = $this->ComprasProducto->find("all", array(
				"conditions"=>array(
					"ComprasProducto.codigos_presupuestarios LIKE"=>'%'.$codigoCorto[0].'%',
					"ComprasProducto.estado"=>4
				),
				"fields"=>array('ComprasProducto.subtotal', 'ComprasProducto.compras_productos_totale_id'),
				'recursive'=>2
			));
			
			$idComprasProductosTotales = "";
			$notascredito = "";		
			
			foreach($gastadoItems as $gastadoItem)
			{
				if($gastadoItem["ComprasProductosTotale"]["tipos_documento_id"] == 17 || $gastadoItem["ComprasProductosTotale"]["tipos_documento_id"] == 18 || $gastadoItem["ComprasProductosTotale"]["tipos_documento_id"] == 19 || $gastadoItem["ComprasProductosTotale"]["tipos_documento_id"] == 20 || $gastadoItem["ComprasProductosTotale"]["tipos_documento_id"] == 21 || $gastadoItem["ComprasProductosTotale"]["tipos_documento_id"] == 22)
				{
					$idComprasProductosTotales[] = $gastadoItem["ComprasProducto"]["subtotal"];
				}
				
				if($gastadoItem["ComprasProductosTotale"]["tipos_documento_id"] == 26)
				{
					$notascredito[] = $gastadoItem["ComprasProducto"]["subtotal"];
				}
			}

			/*
			foreach($gastadoItems as $gastadoItem)
			{
				if($gastadoItem["ComprasProductosTotale"]["compras_estado_id"] == 2 || $gastadoItem["ComprasProductosTotale"]["compras_estado_id"] == 6 || $gastadoItem["ComprasProductosTotale"]["compras_estado_id"] == 4 || $gastadoItem["ComprasProductosTotale"]["compras_estado_id"] == 8)
				{
					if($gastadoItem["ComprasProductosTotale"]["compras_estado_id"] != 6 && $gastadoItem["ComprasProductosTotale"]["tipos_documento_id"] == 17)
					{
						if($gastadoItem["ComprasProductosTotale"]["tipos_documento_id"] != 26)
						{
							$idComprasProductosTotales[] = $gastadoItem["ComprasProductosTotale"]["neto_descuento"];	
						}
						else
						{
							$notascredito[] = $gastadoItem["ComprasProductosTotale"]["neto_descuento"];
						}	
					}
				}
			}
			 */
			
			if(empty($idComprasProductosTotales))
			{
				$idComprasProductosTotales = array(0);
			}
			

			$detalleGastos = array(
				"sumaPresupuestoArea"=> array_sum($sumaPresupuestoArea),
				"gastosArea"=>array_sum($idComprasProductosTotales) - (!empty($notascredito) ? array_sum($notascredito) : 0),
				"saldoGastos"=>(array_sum($sumaPresupuestoArea) - array_sum($idComprasProductosTotales)) + (!empty($notascredito) ? array_sum($notascredito) : 0),
				//"notasCredito"=>array_sum($notascredito)
			);

			$this->set("detalleGastos", $detalleGastos);
		}
	}

	public function valida_rut()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		if($this->params->isAjax == 1)
		{
			$this->layout = null;

			$this->loadModel("Company");

			$estadoEmpresa = $this->Company->find('all', array(
				'conditions'=>array('Company.rut'=>$this->params->query["rutEmpresa"]),
				'fields'=>array("Company.rut")
			));
			$estado = 0;
			if(!empty($estadoEmpresa[0]["Company"]["rut"]) == $this->params->query["rutEmpresa"])
			{
				$estado = 1;
			}
			
			$this->set("estado", $estado);
		}
	}


	public function comunas()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		$this->loadModel("Comuna");
		$comunas = $this -> Comuna -> find('all', array(
			'fields' => array(
				'Comuna.id', 
				'Comuna.comuna_nombre'
			), 
			'order'=>'Comuna.comuna_nombre ASC'));
		
		$muestraComunas = "";



		foreach($comunas as $comuna)
		{
			$muestraComunas[] = array("Id"=>$comuna["Comuna"]["id"], "Nombre"=>$comuna["Comuna"]["comuna_nombre"]) ;
		}

		$this->set('comunas', $muestraComunas);
	}

	function asocGerencia()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		$this->layout = "ajax";
		$this->loadModel("Trabajadore");
		$this->loadModel("Area");
		$this->loadModel("Cargo");
		$idAreas = "";
		$idCargos = "";
		$areasArray = "";
		$cargoArray = "";
		$trabajadoresArray = "";

		$areasArray = $this->Area->find('all', array('conditions'=>array('Area.gerencia_id'=>$this->request->query["id"], 'Area.estado'=>1), 'order'=>'Area.nombre', 'fields'=>array('Area.nombre', 'Area.id')));
		if(!empty($areasArray))
		{
			foreach ($areasArray as $k => $areaLimpio) {
				$idAreas[] = $areaLimpio["Area"]["id"];
			}
			$cargoArray = $this->Cargo->find('all', array('conditions'=>array('Cargo.area_id'=>$idAreas, 'Cargo.estado'=>1), 'order'=>'Cargo.nombre', 'fields'=>array('Cargo.nombre','Cargo.id')));
			if(!empty($cargoArray)){
				foreach ($cargoArray as $k => $cargoLimpio) {
					$idCargos[] = $cargoLimpio["Cargo"]["id"];
				}
				$trabajadoresArray = $this->Trabajadore->find("all", array('conditions'=>array('Trabajadore.cargo_id'=>$idCargos, 'Trabajadore.estado !='=>'Retirado'), 'fields'=>array('Trabajadore.nombre', 'Trabajadore.apellido_paterno','Trabajadore.apellido_materno'), 'order'=>'Trabajadore.nombre ASC'));
			}
		}
		if(!empty($trabajadoresArray) || !empty($areasArray) || !empty($cargoArray))
		{
			if(!empty($trabajadoresArray))
			{	
				foreach ($trabajadoresArray as $trabajador) 
				{
					$trabajadores["trabajadores"][]= $trabajador["Trabajadore"]["nombre"]." ".$trabajador["Trabajadore"]["apellido_paterno"]." ".$trabajador["Trabajadore"]["apellido_materno"];
				}
			}else
			{
				$trabajadores["trabajadores"][] = "";
			}
			if(!empty($areasArray))
			{
				foreach ($areasArray as $area) 
				{
					$trabajadores["areas"][] = mb_strtoupper($area["Area"]["nombre"]);
				}
			}else
			{
				$trabajadores["areas"][] = "";
			}
			if(!empty($cargoArray))
			{
				foreach ($cargoArray as $cargo) 
				{
					$trabajadores["cargos"][] = mb_strtoupper($cargo["Cargo"]["nombre"]);
				}
			}else
			{
				$trabajadores["cargos"][] = "";
			}
			$this->set("trabajadores", json_encode($trabajadores));
		}else
		{
			$this->set("trabajadores", 0);
		}
	}

	function asocArea()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		$this->layout = "ajax";
		$this->loadModel("Trabajadore");
		$this->loadModel("Cargo");
		$idCargos = "";
		$trabajadoresArray = "";
		$cargoArray = $this->Cargo->find('all', array('conditions'=>array('Cargo.area_id'=>$this->request->query["id"], 'Cargo.estado'=>1), 'order'=>'Cargo.nombre', 'fields'=>array('Cargo'=>'id', 'Cargo.nombre') ));
		foreach ($cargoArray as $k => $cargoLimpio) {
			$idCargos[] = $cargoLimpio["Cargo"]["id"];
		}
		if(!empty($idCargos))
		{
			$trabajadoresArray = $this->Trabajadore->find("all", array('conditions'=>array('Trabajadore.cargo_id'=>$idCargos, 'Trabajadore.estado !='=>'Retirado'), 'fields'=>array('Trabajadore.nombre', 'Trabajadore.apellido_paterno','Trabajadore.apellido_materno'), 'order'=>'Trabajadore.nombre ASC'));
		}
		if(!empty($trabajadoresArray) || !empty($cargoArray))
		{
			if(!empty($trabajadoresArray))
			{	
				foreach ($trabajadoresArray as $trabajador) 
				{
					$trabajadores["trabajadores"][]= $trabajador["Trabajadore"]["nombre"]." ".$trabajador["Trabajadore"]["apellido_paterno"]." ".$trabajador["Trabajadore"]["apellido_materno"];
				}
			}else
			{
				$trabajadores["trabajadores"][] = "";
			}
			if(!empty($cargoArray))
			{
				foreach ($cargoArray as $cargo) 
				{
					$trabajadores["cargos"][] = mb_strtoupper($cargo["Cargo"]["nombre"]);
				}
			}else
			{
				$trabajadores["cargos"][] = "";
			}
			$this->set("trabajadores", json_encode($trabajadores));
		}else
		{
			$this->set("trabajadores", 0);
		}
	}

	function asocCargo()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		$this->layout = "ajax";
		$this->loadModel("Trabajadore");
		$trabajadoresArray = $this->Trabajadore->find("all", array('conditions'=>array('Trabajadore.cargo_id'=>$this->request->query["id"], 'Trabajadore.estado !='=>'Retirado'), 'fields'=>array('Trabajadore.nombre', 'Trabajadore.apellido_paterno','Trabajadore.apellido_materno'), 'order'=>'Trabajadore.nombre ASC'));
		if(!empty($trabajadoresArray))
		{
			if(!empty($trabajadoresArray))
			{	
				foreach ($trabajadoresArray as $trabajador) 
				{
					$trabajadores["trabajadores"][]= $trabajador["Trabajadore"]["nombre"]." ".$trabajador["Trabajadore"]["apellido_paterno"]." ".$trabajador["Trabajadore"]["apellido_materno"];
				}
			}else
			{
				$trabajadores["trabajadores"][] = "";
			}
			$this->set("trabajadores", json_encode($trabajadores));
		}else
		{
			$this->set("trabajadores", 0);
		}
	}

	public function eliminar_producto()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		$this->layout = "ajax";
		$this->loadModel("ComprasProducto");
		if(!empty($this->params->query["idProducto"]))
		{
			$this->request->data["ComprasProducto"]["id"] = $this->params->query["idProducto"];
			$this->request->data["ComprasProducto"]["estado"] = 0;
			if ($this->ComprasProducto->save($this->request->data)) 
			{	
				CakeLog::write('actividad', 'SE elimino el producto - ' .$this->params->query["idProducto"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));				
				$this->Session->setFlash('El requerimiento de compra fue eliminada', 'msg_exito');
			}
		}

		exit;
	}


	public function addDocumentoTributario()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}


		$this->layout = "ajax";
		$this->loadModel("ComprasFactura");
		$estado = "";		
		if(!empty($this->request->data))
		{


			if(!empty($this->request->data["adjunto"]))
			{
				$nombresFotos = "";
			
				foreach($this->request->data["adjunto"] as $adjunto)
				{
					if($adjunto['error'] == 0 && $adjunto['size'] > 0)
					{
		             	$destino = WWW_ROOT.'files'.DS.'orden_compra'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
		             	
		             	if (!file_exists($destino))
						{
							mkdir($destino, 0777, true);
							chmod($destino, 0777);
						}
						
						if(is_uploaded_file($adjunto['tmp_name']))
						{
							if($adjunto['size'] <= 7000000)
							{
								move_uploaded_file($adjunto['tmp_name'], $destino . DS .$adjunto['name']);
								$nombresFotos[] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$adjunto['name'];
							}
							else
							{
	
								$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
								return $this->redirect(array("controller" => 'compras', "action" => 'index'));
								$estado = 2;
								exit;
							}
						}
						else
						{
							$this->Session->setFlash('NO GUARDO!! Ocurrio un problema', 'msg_fallo');
							return $this->redirect(array("controller" => 'compras', "action" => 'index'));
							$estado = 2;
							exit;	
						}
					}
				}
				/*
				if($this->request->data["adjunto"]['error'] == 0 && $this->request->data["adjunto"]['size'] > 0)
				{
	             	$destino = WWW_ROOT.'files'.DS.'orden_compra'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
	             	
	             	if (!file_exists($destino))
					{
						mkdir($destino, 0777, true);
						chmod($destino, 0777);
					}
					
					if(is_uploaded_file($this->request->data["adjunto"]['tmp_name']))
					{
						if($this->request->data["adjunto"]['size'] <= 7000000)
						{
							move_uploaded_file($this->data['adjunto']['tmp_name'], $destino . DS .$this->data['adjunto']['name']);
						}
						else
						{
							$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
							return $this->redirect(array("controller" => 'compras', "action" => 'index'));
							$estado = 2;
							exit;
						}
					}
					else
					{

						$this->Session->setFlash('NO GUARDO!! , intentelo nuevamente', 'msg_fallo');
						return $this->redirect(array("controller" => 'compras', "action" => 'index'));
						$estado = 2;
						exit;	
					}
				}
				*/
			}
			

			
			$this->loadModel("ComprasProductosTotale");
			$idProductos = "";
			$idTotal = "";
			if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 2)
			{
				$idTotal = $this->request->data["id_clonado"];
				$idProductos = $this->request->data["idProducto"];

				if(!empty($this->request->data["tipo_documento"]))
				{	
					$datosFacturacion = $this->ComprasFactura->find('first', array(
						'conditions'=>array("ComprasFactura.compras_productos_totale_id"=>$this->request->data["id_clonado"]),
						'fields'=>array("ComprasFactura.id")
					));

					$this->request->data["ComprasFactura"]["id"] =$datosFacturacion["ComprasFactura"]["id"];

				}

				CakeLog::write('actividad', 'edito el documento tributario - ' .$this->request->data["id_clonado"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			}

			$this->request->data["ComprasProductosTotale"]["adjunto"] = serialize($nombresFotos); //date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->data['adjunto']['name'];

			if(!empty($this->request->data["tipo_cambio"]))
			{
				$this->request->data["ComprasProductosTotale"]["tipo_cambio"] = $this->request->data["tipo_cambio"];
			}


			$this->request->data["ComprasProductosTotale"]["id"] = $idTotal;
			$this->request->data["ComprasProductosTotale"]["company_id"] = $this->data["company_id"];
			$this->request->data["ComprasProductosTotale"]["descuento_total"] = str_replace('.', '', $this->data["monto"]);
			$this->request->data["ComprasProductosTotale"]["impuesto"] = $this->request->data["tipo_documento"];
			$this->request->data["ComprasProductosTotale"]["total"] = str_replace('.', '', $this->data["total"]); 
			//$this->request->data["ComprasProductosTotale"]["fecha"] = date("Y-m-d", strtotime($this->data["fecha_entrega"]));
			$this->request->data["ComprasProductosTotale"]["plazos_pago_id"] = $this->data["plazos_pago_id"];
			$this->request->data["ComprasProductosTotale"]["tipos_moneda_id"] = $this->data["tipo_moneda_id"];
			$this->request->data["ComprasProductosTotale"]["observacion"] = $this->data["observacion"];
			$this->request->data["ComprasProductosTotale"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data["ComprasProductosTotale"]["neto_descuento"] = $this->data["neto_descuento"];
			$this->request->data["ComprasProductosTotale"]["titulo"] = $this->data["titulo"];
			$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 1;
			$this->request->data["ComprasProductosTotale"]["tipos_documento_id"] = $this->request->data["tipo_documento"];

			//pr($this->request->data["ComprasProductosTotale"]);exit;

			if($this->ComprasProductosTotale->save($this->request->data))
			{
				CakeLog::write('actividad', 'ingreso el documento tributario - ' .$this->ComprasProductosTotale->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->loadModel("ComprasProducto");
				
				$idComprasTotales = $this->ComprasProductosTotale->id;
				
				if(!empty($idComprasTotales))
				{
					$productoArray = "";

					foreach($this->data["dimCodigoUno"] as $key => $productosTodos)
					{
						$productoArray[] = array(
							'id' => $idProductos[$key],
							'dim_uno'=>$productosTodos,
							'proyecto'=>$this->request->data["proyecto"][$key],
							'cantidad'=>$this->request->data["cantidad"][$key],
							'precio_unitario'=>$this->request->data["precio"][$key],
							'empaque'=>$this->request->data["empaque"][$key],
							'descuento_producto'=>$this->request->data["descuento_unitario"][$key],
							'codigos_presupuestarios'=>$this->request->data["codigoPresupuestario"][$key],
							'descripcion'=>$this->request->data["descripcion"][$key],
							'dim_dos'=>$this->request->data["dimCodigoDos"][$key],
							'dim_tres'=>$this->request->data["dimCodigoTres"][$key],
							'dim_cuatro'=>$this->request->data["dimCodigoCuatro"][$key],
							'dim_cinco'=>$this->request->data["dimCodigoCinco"][$key],
							'compras_productos_totale_id'=>$idComprasTotales,
							'estado'=>1,
							'subtotal'=>$this->request->data["subToal"][$key],
							'afecto'=>$this->request->data["afecto"][$key]
						);
					}

					$idProductos = "";					
					if($this->ComprasProducto->saveAll($productoArray))
					{
						
						$this->request->data["ComprasFactura"]["fecha_documento"] = $this->request->data["fecha_documento"];
						$this->request->data["ComprasFactura"]["tipos_documento_id"] = $this->request->data["tipo_documento"];
						$this->request->data["ComprasFactura"]["compras_productos_totale_id"] = $this->ComprasProductosTotale->id;
						$this->request->data["ComprasFactura"]["numero_documento"] = $this->request->data["numero_documento"];

						if($this->ComprasFactura->save($this->request->data["ComprasFactura"])){
						}

						$comprasProductosId = $this->ComprasProducto->id;
						$idProductos[] = $this->ComprasProducto->id;

						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 1)
						{
							$this->request->data["ComprasProductosTotale"]["id"] =  $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["compras_estado_id"] =  0;
							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);     
						}
												
						if(!empty($this->data["codigoPresupuestario"]))
						{
							//$codigoCorto = explode("-", $this->data["codigoPresupuestario"][0]);
							$aprobadores = "";
							foreach($this->data["codigoPresupuestario"] as $codigoCorto)
							{
								$aprobadores[] = 'Aprobador-'.substr($codigoCorto, 0, 2);
							}

							$this->loadModel("Email");
							
							/*
							$email = $this->Email->find("all", array(
								"conditions"=>array("Email.informe"=>'Aprobador-'.array_unique($aprobadores)),
								"fields"=>
							));
							*/

							$email = $this->Email->find("all", array(
								'conditions'=>array("Email.informe"=>array_unique($aprobadores)),
								'fields'=>"Email.email"
							));
							

							$envioEmail = "";


							foreach ($email as $sendEmail) 
							{
								$envioEmail[] = $sendEmail["Email"]["email"];
							}

							pr($envioEmail);
							exit;



							$this->loadMOdel("Company");

							$empresa = $this->Company->find("first", array(
								"conditions"=>array("Company.id"=>$this->data["company_id"]),
								"fields"=>"Company.nombre"
							));

							pr($envioEmail);
							exit;

							
							if(!empty($envioEmail))
							{
								if($this->request->data["tipo_documento"])
								{
									$this->loadModel("TiposDocumento");
									$nombreDocumento = $this->TiposDocumento->find("first", array(
										'conditions'=>array("TiposDocumento.id"=>$this->request->data["tipo_documento"])
									));	
								}

								if(!empty($nombreDocumento["TiposDocumento"]["nombre"]))
								{
									$numeroRequerimiento = $nombreDocumento["TiposDocumento"]["nombre"] . ' - ' .$this->request->data["numero_documento"];
									$plantilla = "documento_tributario";
									$nombreEmail = "SE GENERO UN NUEVO DOCUMENTO TRIBUTARIO";
								}
								else
								{
									$numeroRequerimiento = $this->ComprasProductosTotale->id;
									$plantilla = "documento_tributario";
									$nombreEmail = "SE GENERO UN NUEVO REQUERIMIENTO DE COMPRA";
								}

	


								$Email = new CakeEmail("gmail");
								$Email->from(array('sgi@cdf.cl' => 'SGI'));
								$Email->to($envioEmail);
								$Email->subject($nombreEmail);
								$Email->emailFormat('html');
								$Email->template($plantilla);
								$Email->viewVars(array(
									"nombreEmail"=>$nombreEmail,
									"usuario"=>$this->Session->read("Users.nombre"),
									"fechaCreacion"=>date("d/m/Y H:i"),
									"numeroRequerimiento"=>$numeroRequerimiento,
									"titulo"=>$this->data["titulo"],
									"total"=>$this->data["total"],
									"empresa"=>$empresa["Company"]["nombre"]
								));
								$Email->send();
							}
						}
						else
						{
							$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
							$estado = 2;
							exit;
						}


						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 1)
						{
							$this->request->data["ComprasProductosTotale"]["id"] = $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 0;

							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);
							CakeLog::write('actividad', 'se clono el documento tributario - ' .$this->ComprasProductosTotale->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						}
					}
					$estado = 1;
				}
				else
				{
					$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
					$estado = 2;
					exit;
				}
			}
			else
			{
				$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
				$estado = 2;
				exit;
			}
		}
		if($estado == 1)
		{
			if($this->request->data["clonar"] == 1)
			{
				$this->Session->setFlash('El requerimiento de compra se clono correctamente', 'msg_exito');
			}
			else if($this->request->data["clonar"] == 2)
			{
				$this->Session->setFlash('El requerimiento de compra se edito correctamente', 'msg_exito');
			}
			else
			{
				$this->Session->setFlash('Registrado correctamente', 'msg_exito');	
			}		
		}
		else
		{
			$this->Session->setFlash('El requerimiento de compra no se pudo generar', 'msg_fallo');
		}
		$this->set("estado", $estado);
	}


	public function addDeclaracionIngreso()
	{	
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}


		$this->layout = "ajax";
		$this->loadModel("ComprasFactura");
		$estado = "";		
		if(!empty($this->request->data))
		{


			if(!empty($this->request->data["adjunto"]))
			{
				$nombresFotos = "";
			
				foreach($this->request->data["adjunto"] as $adjunto)
				{
					if($adjunto['error'] == 0 && $adjunto['size'] > 0)
					{
		             	$destino = WWW_ROOT.'files'.DS.'orden_compra'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
		             	
		             	if (!file_exists($destino))
						{
							mkdir($destino, 0777, true);
							chmod($destino, 0777);
						}
						
						if(is_uploaded_file($adjunto['tmp_name']))
						{
							if($adjunto['size'] <= 7000000)
							{
								move_uploaded_file($adjunto['tmp_name'], $destino . DS .$adjunto['name']);
								$nombresFotos[] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$adjunto['name'];
							}
							else
							{
	
								$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
								return $this->redirect(array("controller" => 'compras', "action" => 'index'));
								$estado = 2;
								exit;
							}
						}
						else
						{
							$this->Session->setFlash('NO GUARDO!! Ocurrio un problema', 'msg_fallo');
							return $this->redirect(array("controller" => 'compras', "action" => 'index'));
							$estado = 2;
							exit;	
						}
					}
				}
			}
			

			
			$this->loadModel("ComprasProductosTotale");
			$idProductos = "";
			$idTotal = "";
			if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 2)
			{
				$idTotal = $this->request->data["id_clonado"];
				$idProductos = $this->request->data["idProducto"];

				if(!empty($this->request->data["tipo_documento"]))
				{	
					$datosFacturacion = $this->ComprasFactura->find('first', array(
						'conditions'=>array("ComprasFactura.compras_productos_totale_id"=>$this->request->data["id_clonado"]),
						'fields'=>array("ComprasFactura.id")
					));

					$this->request->data["ComprasFactura"]["id"] =$datosFacturacion["ComprasFactura"]["id"];

				}

				CakeLog::write('actividad', 'edito el documento tributario - ' .$this->request->data["id_clonado"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			}
			
			else
			{
				$this->request->data["ComprasProductosTotale"]["adjunto"] = serialize($nombresFotos); //date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->data['adjunto']['name'];
			}

			if(!empty($this->request->data["tipo_cambio"]))
			{
				$this->request->data["ComprasProductosTotale"]["tipo_cambio"] = $this->request->data["tipo_cambio"];
			}


			$this->request->data["ComprasProductosTotale"]["id"] = $idTotal;
			$this->request->data["ComprasProductosTotale"]["company_id"] = $this->data["company_id"];
			$this->request->data["ComprasProductosTotale"]["descuento_total"] = str_replace('.', '', $this->data["monto"]);
			$this->request->data["ComprasProductosTotale"]["impuesto"] = $this->request->data["tipo_documento"];
			$this->request->data["ComprasProductosTotale"]["total"] = $this->request->data["declaracionIngreso"]["total"];0;//str_replace('.', '', $this->data["total"]); 
			//$this->request->data["ComprasProductosTotale"]["fecha"] = date("Y-m-d", strtotime($this->data["fecha_entrega"]));
			$this->request->data["ComprasProductosTotale"]["plazos_pago_id"] = $this->data["plazos_pago_id"];
			$this->request->data["ComprasProductosTotale"]["tipos_moneda_id"] = $this->data["tipo_moneda_id"];
			$this->request->data["ComprasProductosTotale"]["observacion"] = $this->data["observacion"];
			$this->request->data["ComprasProductosTotale"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data["ComprasProductosTotale"]["neto_descuento"] = $this->request->data["declaracionIngreso"]["descuentos"];//$this->data["neto_descuento"];
			$this->request->data["ComprasProductosTotale"]["titulo"] = $this->data["titulo"];
			$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 1;
			$this->request->data["ComprasProductosTotale"]["tipos_documento_id"] = $this->request->data["tipo_documento"];
			$this->request->data["ComprasProductosTotale"]["declaracion_ingreso"] = serialize($this->request->data["declaracionIngreso"]);
			//declaracionIngreso
			//pr($this->request->data["ComprasProductosTotale"]);exit;

			if($this->ComprasProductosTotale->save($this->request->data))
			{
				CakeLog::write('actividad', 'ingreso el documento tributario - ' .$this->ComprasProductosTotale->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->loadModel("ComprasProducto");
				
				$idComprasTotales = $this->ComprasProductosTotale->id;
				
				if(!empty($idComprasTotales))
				{
					$productoArray = "";

					foreach($this->data["dimCodigoUno"] as $key => $productosTodos)
					{
						$productoArray[] = array(
							'id' => (isset($idProductos[$key]) ? $idProductos[$key] : ""),
							'dim_uno'=>$productosTodos,
							'proyecto'=>$this->request->data["proyecto"][$key],
							'cantidad'=>$this->request->data["cantidad"][$key],
							'precio_unitario'=>$this->request->data["precio"][$key],
							'empaque'=>$this->request->data["empaque"][$key],
							'descuento_producto'=>$this->request->data["descuento_unitario"][$key],
							'codigos_presupuestarios'=>$this->request->data["codigoPresupuestario"][$key],
							'descripcion'=>$this->request->data["descripcion"][$key],
							'dim_dos'=>$this->request->data["dimCodigoDos"][$key],
							'dim_tres'=>$this->request->data["dimCodigoTres"][$key],
							'dim_cuatro'=>$this->request->data["dimCodigoCuatro"][$key],
							'dim_cinco'=>$this->request->data["dimCodigoCinco"][$key],
							'compras_productos_totale_id'=>$idComprasTotales,
							'estado'=>1,
							'subtotal'=>$this->request->data["subToal"][$key],
							'afecto'=>$this->request->data["afecto"][$key]
						);
					}

					$idProductos = "";					
					if($this->ComprasProducto->saveAll($productoArray))
					{
						
						$this->request->data["ComprasFactura"]["fecha_documento"] = $this->request->data["fecha_documento"];
						$this->request->data["ComprasFactura"]["tipos_documento_id"] = $this->request->data["tipo_documento"];
						$this->request->data["ComprasFactura"]["compras_productos_totale_id"] = $this->ComprasProductosTotale->id;
						$this->request->data["ComprasFactura"]["numero_documento"] = $this->request->data["numero_documento"];

						if($this->ComprasFactura->save($this->request->data["ComprasFactura"])){
						}

						$comprasProductosId = $this->ComprasProducto->id;
						$idProductos[] = $this->ComprasProducto->id;

						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 1)
						{
							$this->request->data["ComprasProductosTotale"]["id"] =  $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["compras_estado_id"] =  0;
							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);     
						}
												
						if(!empty($this->data["codigoPresupuestario"]))
						{
							//$codigoCorto = explode("-", $this->data["codigoPresupuestario"][0]);
							$aprobadores = "";
							foreach($this->data["codigoPresupuestario"] as $codigoCorto)
							{
								$aprobadores[] = 'Aprobador-'.substr($codigoCorto, 0, 2);
							}

							$this->loadModel("Email");
							
							/*
							$email = $this->Email->find("all", array(
								"conditions"=>array("Email.informe"=>'Aprobador-'.array_unique($aprobadores)),
								"fields"=>
							));
							*/

							$email = $this->Email->find("all", array(
								'conditions'=>array("Email.informe"=>array_unique($aprobadores)),
								'fields'=>"Email.email"
							));
							

							$envioEmail = "";


							foreach ($email as $sendEmail) 
							{
								$envioEmail[] = $sendEmail["Email"]["email"];
							}

							pr($envioEmail);
							exit;



							$this->loadMOdel("Company");

							$empresa = $this->Company->find("first", array(
								"conditions"=>array("Company.id"=>$this->data["company_id"]),
								"fields"=>"Company.nombre"
							));

							pr($envioEmail);
							exit;

							
							if(!empty($envioEmail))
							{
								if($this->request->data["tipo_documento"])
								{
									$this->loadModel("TiposDocumento");
									$nombreDocumento = $this->TiposDocumento->find("first", array(
										'conditions'=>array("TiposDocumento.id"=>$this->request->data["tipo_documento"])
									));	
								}

								if(!empty($nombreDocumento["TiposDocumento"]["nombre"]))
								{
									$numeroRequerimiento = $nombreDocumento["TiposDocumento"]["nombre"] . ' - ' .$this->request->data["numero_documento"];
									$plantilla = "documento_tributario";
									$nombreEmail = "SE GENERO UN NUEVO DOCUMENTO TRIBUTARIO";
								}
								else
								{
									$numeroRequerimiento = $this->ComprasProductosTotale->id;
									$plantilla = "documento_tributario";
									$nombreEmail = "SE GENERO UN NUEVO REQUERIMIENTO DE COMPRA";
								}

								
								pr($envioEmail);
								exit;




								$Email = new CakeEmail("gmail");
								$Email->from(array('sgi@cdf.cl' => 'SGI'));
								$Email->to($envioEmail);
								$Email->subject($nombreEmail);
								$Email->emailFormat('html');
								$Email->template($plantilla);
								$Email->viewVars(array(
									"nombreEmail"=>$nombreEmail,
									"usuario"=>$this->Session->read("Users.nombre"),
									"fechaCreacion"=>date("d/m/Y H:i"),
									"numeroRequerimiento"=>$numeroRequerimiento,
									"titulo"=>$this->data["titulo"],
									"total"=>$this->data["total"],
									"empresa"=>$empresa["Company"]["nombre"]
								));
								$Email->send();
							}
						}
						else
						{
							$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
							$estado = 2;
							exit;
						}


						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 1)
						{
							$this->request->data["ComprasProductosTotale"]["id"] = $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 0;

							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);
							CakeLog::write('actividad', 'se clono el documento tributario - ' .$this->ComprasProductosTotale->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						}
					}
					$estado = 1;
				}
				else
				{
					$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
					$estado = 2;
					exit;
				}
			}
			else
			{
				$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
				$estado = 2;
				exit;
			}
		}
		if($estado == 1)
		{
			if($this->request->data["clonar"] == 1)
			{
				$this->Session->setFlash('El requerimiento de compra se clono correctamente', 'msg_exito');
			}
			else if($this->request->data["clonar"] == 2)
			{
				$this->Session->setFlash('El requerimiento de compra se edito correctamente', 'msg_exito');
			}
			else
			{
				$this->Session->setFlash('Registrado correctamente', 'msg_exito');	
			}		
		}
		else
		{
			$this->Session->setFlash('El requerimiento de compra no se pudo generar', 'msg_fallo');
		}
		$this->set("estado", $estado);
	}


	public function notas_credito()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		$this->layout = "ajax";
		$this->loadModel("ComprasFactura");
		$estado = "";		
		if(!empty($this->request->data))
		{
			if(!empty($this->request->data["adjunto"]))
			{
				$nombresFotos = "";
			
				foreach($this->request->data["adjunto"] as $adjunto)
				{
					if($adjunto['error'] == 0 && $adjunto['size'] > 0)
					{
		             	$destino = WWW_ROOT.'files'.DS.'orden_compra'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
		             	
		             	if (!file_exists($destino))
						{
							mkdir($destino, 0777, true);
							chmod($destino, 0777);
						}
						
						if(is_uploaded_file($adjunto['tmp_name']))
						{
							if($adjunto['size'] <= 7000000)
							{
								move_uploaded_file($adjunto['tmp_name'], $destino . DS .$adjunto['name']);
								$nombresFotos[] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$adjunto['name'];
							}
							else
							{
	
								$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
								return $this->redirect(array("controller" => 'compras', "action" => 'index'));
								$estado = 2;
								exit;
							}
						}
						else
						{
							$this->Session->setFlash('NO GUARDO!! Ocurrio un problema', 'msg_fallo');
							return $this->redirect(array("controller" => 'compras', "action" => 'index'));
							$estado = 2;
							exit;	
						}
					}
				}
				/*
				if($this->request->data["adjunto"]['error'] == 0 && $this->request->data["adjunto"]['size'] > 0)
				{
	             	$destino = WWW_ROOT.'files'.DS.'orden_compra'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
	             	
	             	if (!file_exists($destino))
					{
						mkdir($destino, 0777, true);
						chmod($destino, 0777);
					}
					
					if(is_uploaded_file($this->request->data["adjunto"]['tmp_name']))
					{
						if($this->request->data["adjunto"]['size'] <= 7000000)
						{
							move_uploaded_file($this->data['adjunto']['tmp_name'], $destino . DS .$this->data['adjunto']['name']);
						}
						else
						{
							$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
							return $this->redirect(array("controller" => 'compras', "action" => 'index'));
							$estado = 2;
							exit;
						}
					}
					else
					{
						$this->Session->setFlash('NO GUARDO!! intentelo nuevamente', 'msg_fallo');
						return $this->redirect(array("controller" => 'compras', "action" => 'index'));
						$estado = 2;
						exit;	
					}
				}
				*/
			}

			$this->loadModel("ComprasProductosTotale");
			$idProductos = "";
			$idTotal = "";
						
			if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 2)
			{
				$idTotal = $this->request->data["id_clonado"];
				$idProductos = $this->request->data["idProducto"];

				if(!empty($this->request->data["tipo_documento"]))
				{	
					$datosFacturacion = $this->ComprasFactura->find('first', array(
						'conditions'=>array("ComprasFactura.compras_productos_totale_id"=>$this->request->data["id_clonado"]),
						'fields'=>array("ComprasFactura.id")
					));

					$this->request->data["ComprasFactura"]["id"] =$datosFacturacion["ComprasFactura"]["id"];
				}
				CakeLog::write('actividad', 'edito el documento tributario - ' .$this->request->data["id_clonado"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
			}
			else
			{
				$this->request->data["ComprasProductosTotale"]["adjunto"] = serialize($nombresFotos);  //date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->data['adjunto']['name'];
			}

			if(!empty($this->request->data["tipo_cambio"]))
			{
				$this->request->data["ComprasProductosTotale"]["tipo_cambio"] = $this->request->data["tipo_cambio"];
			}
			
			$this->request->data["ComprasProductosTotale"]["company_id"] = $this->data["company_id"];
			$this->request->data["ComprasProductosTotale"]["descuento_total"] = str_replace('.', '', $this->data["monto"]);
			$this->request->data["ComprasProductosTotale"]["impuesto"] = $this->request->data["impuesto"];
			$this->request->data["ComprasProductosTotale"]["total"] = str_replace('.', '', $this->data["total"]); 
			$this->request->data["ComprasProductosTotale"]["plazos_pago_id"] = $this->data["plazos_pago_id"];
			$this->request->data["ComprasProductosTotale"]["tipos_moneda_id"] = $this->data["tipo_moneda_id"];
			$this->request->data["ComprasProductosTotale"]["observacion"] = $this->data["observacion"];
			$this->request->data["ComprasProductosTotale"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data["ComprasProductosTotale"]["neto_descuento"] = $this->data["neto_descuento"];
			$this->request->data["ComprasProductosTotale"]["titulo"] = $this->data["titulo"];
			$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 1;
			$this->request->data["ComprasProductosTotale"]["tipos_documento_id"] = $this->request->data["tipo_documento"];

			if($this->ComprasProductosTotale->save($this->request->data))
			{
				//pr($this->request->data);
				//exit;
				CakeLog::write('actividad', 'nota de credito - ' .$this->ComprasProductosTotale->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->loadModel("ComprasProducto");
				
				$idComprasTotales = $this->ComprasProductosTotale->id;
				
				if(!empty($idComprasTotales))
				{
					$productoArray = "";

					foreach($this->data["dimCodigoUno"] as $key => $productosTodos)
					{
						$productoArray[] = array(
							//'id' => $idProductos[$key],
							'dim_uno'=>$productosTodos,
							'proyecto'=>$this->request->data["proyecto"][$key],
							'cantidad'=>$this->request->data["cantidad"][$key],
							'precio_unitario'=>$this->request->data["precio"][$key],
							'empaque'=>$this->request->data["empaque"][$key],
							'descuento_producto'=>$this->request->data["descuento_unitario"][$key],
							'codigos_presupuestarios'=>$this->request->data["codigoPresupuestario"][$key],
							'descripcion'=>$this->request->data["descripcion"][$key],
							'dim_dos'=>$this->request->data["dimCodigoDos"][$key],
							'dim_tres'=>$this->request->data["dimCodigoTres"][$key],
							'dim_cuatro'=>$this->request->data["dimCodigoCuatro"][$key],
							'dim_cinco'=>$this->request->data["dimCodigoCinco"][$key],
							'compras_productos_totale_id'=>$idComprasTotales,
							'estado'=>1,
							'subtotal'=>$this->request->data["subToal"][$key],
							'afecto'=>$this->request->data["afecto"][$key]
						);
					}

					$idProductos = "";					
					if($this->ComprasProducto->saveAll($productoArray))
					{
						$this->request->data["ComprasFactura"]["fecha_documento"] = $this->request->data["fecha_documento"];
						$this->request->data["ComprasFactura"]["tipos_documento_id"] = $this->request->data["tipo_documento"];
						$this->request->data["ComprasFactura"]["compras_productos_totale_id"] = $this->ComprasProductosTotale->id;
						$this->request->data["ComprasFactura"]["numero_documento"] = $this->request->data["numero_documento"];
						//$this->request->data["ComprasFactura"]["documento_relacionado_id"] = $this->request->data["id_clonado"];
						$this->request->data["ComprasFactura"]["requerimiento_id"] = serialize($this->request->data["id_clonado"]);

						if($this->ComprasFactura->save($this->request->data["ComprasFactura"])){
						}

						$comprasProductosId = $this->ComprasProducto->id;
						$idProductos[] = $this->ComprasProducto->id;



						/*
						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 1)
						{
							$this->request->data["ComprasProductosTotale"]["id"] =  $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["compras_estado_id"] =  0;
							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);     
						}
						*/
												
						if(!empty($this->data["codigoPresupuestario"]))
						{
							//$codigoCorto = explode("-", $this->data["codigoPresupuestario"][0]);
							$aprobadores = "";
							foreach($this->data["codigoPresupuestario"] as $codigoCorto)
							{
								$aprobadores[] = 'Aprobador-'.substr($codigoCorto, 0, 2);
							}

							$this->loadModel("Email");
							
							/*
							$email = $this->Email->find("all", array(
								"conditions"=>array("Email.informe"=>'Aprobador-'.array_unique($aprobadores)),
								"fields"=>
							));
							*/
							$email = $this->Email->find("all", array(
								'conditions'=>array("Email.informe"=>'Aprobador-'.array_unique($aprobadores)),
								'fields'=>"Email.email"
							));
							
							$envioEmail = "";


							foreach ($email as $sendEmail) 
							{
								$envioEmail[] = $sendEmail["Email"]["email"];
							}

							$this->loadMOdel("Company");

							$empresa = $this->Company->find("first", array(
								"conditions"=>array("Company.id"=>$this->data["company_id"]),
								"fields"=>"Company.nombre"
							));
							
							if(!empty($envioEmail))
							{
								if($this->request->data["tipo_documento"])
								{
									$this->loadModel("TiposDocumento");
									$nombreDocumento = $this->TiposDocumento->find("first", array(
										'conditions'=>array("TiposDocumento.id"=>$this->request->data["tipo_documento"])
									));	
								}

								if(!empty($nombreDocumento["TiposDocumento"]["nombre"]))
								{
									$numeroRequerimiento = $nombreDocumento["TiposDocumento"]["nombre"] . ' - ' .$this->request->data["numero_documento"];
									$plantilla = "documento_tributario";
									$nombreEmail = "SE GENERO UN NUEVO DOCUMENTO TRIBUTARIO";
								}
								else
								{
									$numeroRequerimiento = $this->ComprasProductosTotale->id;
									$plantilla = "documento_tributario";
									$nombreEmail = "SE GENERO UN NUEVO REQUERIMIENTO DE COMPRA";
								}

								

								$Email = new CakeEmail("gmail");
								$Email->from(array('sgi@cdf.cl' => 'SGI'));
								$Email->to($envioEmail);
								$Email->subject($nombreEmail);
								$Email->emailFormat('html');
								$Email->template($plantilla);
								$Email->viewVars(array(
									"nombreEmail"=>$nombreEmail,
									"usuario"=>$this->Session->read("Users.nombre"),
									"fechaCreacion"=>date("d/m/Y H:i"),
									"numeroRequerimiento"=>$numeroRequerimiento,
									"titulo"=>$this->data["titulo"],
									"total"=>$this->data["total"],
									"empresa"=>$empresa["Company"]["nombre"]
								));
								$Email->send();
							}
						}
						else
						{
							$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
							$estado = 2;
							exit;
						}

						/*
						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 1)
						{
							$this->request->data["ComprasProductosTotale"]["id"] = $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 0;

							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);
							CakeLog::write('actividad', 'se clono el documento tributario - ' .$this->ComprasProductosTotale->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						}
						*/
					}
					$estado = 1;
				}
				else
				{
					$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
					$estado = 2;
					exit;
				}
			}
			else
			{
				$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
				$estado = 2;
				exit;
			}
		}
		if($estado == 1)
		{
			if($this->request->data["clonar"] == 1)
			{
				$this->Session->setFlash('El requerimiento de compra se clono correctamente', 'msg_exito');
			}
			else if($this->request->data["clonar"] == 2)
			{
				$this->Session->setFlash('El requerimiento de compra se edito correctamente', 'msg_exito');
			}
			else
			{
				$this->Session->setFlash('Registrado correctamente', 'msg_exito');	
			}		
		}
		else
		{
			$this->Session->setFlash('El requerimiento de compra no se pudo generar', 'msg_fallo');
		}
		$this->set("estado", $estado);
	}


	public function carga_tipo_cambios()
	{
		$this->layout = "ajax";

		if($this->params->isAjax == 1)
		{
			$this->loadModel("TiposMoneda");

			$valor = $this->TiposMoneda->find("first", array(
				'conditions'=>array("TiposMoneda.id"=>$this->params->query["valor"]),
				//'fields'=>"TiposMoneda.valor"
			));
			$jsonValor = "";
			foreach($valor as $valor);
			{
				$jsonValor = array($valor["valor"]);
			}

			$this->set("valor", $jsonValor);
		}
		else
		{
			//return $this->redirect(array("action" => 'index'));
		}

	}

	public function facturados()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		//pr($this->data);
		//exit;
		
		$this->layout = "ajax";

		$estado = "";		
		if(!empty($this->request->data))
		{
			if(!empty($this->request->data["adjunto"]))
			{
				$nombresFotos = "";
			
				foreach($this->request->data["adjunto"] as $adjunto)
				{
					if($adjunto['error'] == 0 && $adjunto['size'] > 0)
					{
		             	$destino = WWW_ROOT.'files'.DS.'orden_compra'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');    //$this->request->data["File"]["fecha"].DS.$this->request->data["File"]["users_id"];
		             	
		             	if (!file_exists($destino))
						{
							mkdir($destino, 0777, true);
							chmod($destino, 0777);
						}
						
						if(is_uploaded_file($adjunto['tmp_name']))
						{
							if($adjunto['size'] <= 7000000)
							{
								move_uploaded_file($adjunto['tmp_name'], $destino . DS .$adjunto['name']);
								$nombresFotos[] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$adjunto['name'];
							}
							else
							{
	
								$this->Session->setFlash('NO GUARDO!! El archivo adjunto es muy pesado, intentelo nuevamente', 'msg_fallo');
								return $this->redirect(array("controller" => 'compras', "action" => 'index'));
								$estado = 2;
								exit;
							}
						}
						else
						{
							$this->Session->setFlash('NO GUARDO!! Ocurrio un problema', 'msg_fallo');
							return $this->redirect(array("controller" => 'compras', "action" => 'index'));
							$estado = 2;
							exit;	
						}
					}
				}
			}
			
			$this->loadModel("ComprasProductosTotale");
			$idProductos = "";
			$idTotal = "";

			if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 2)
			{
				$idTotal = $this->request->data["id_clonado"];
				$idProductos = $this->request->data["idProducto"];
			}
			
			else
			{
				$this->request->data["ComprasProductosTotale"]["adjunto"] = serialize($nombresFotos); //date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->data['adjunto']['name'];
			}

			if(!empty($this->request->data["tipo_cambio"]))
			{
				$this->request->data["ComprasProductosTotale"]["tipo_cambio"] = $this->request->data["tipo_cambio"];
			}

			//$this->request->data["ComprasProductosTotale"]["id"] = $idTotal;
			$this->request->data["ComprasProductosTotale"]["company_id"] = $this->data["company_id"];
			$this->request->data["ComprasProductosTotale"]["descuento_total"] = str_replace('.', '', $this->data["monto"]);
			$this->request->data["ComprasProductosTotale"]["impuesto"] = $this->data["tipo_documento"];
			$this->request->data["ComprasProductosTotale"]["total"] = str_replace('.', '', $this->data["total"]); 
			//$this->request->data["ComprasProductosTotale"]["fecha"] = date("Y-m-d", strtotime($this->data["fecha_entrega"]));
			$this->request->data["ComprasProductosTotale"]["plazos_pago_id"] = $this->data["plazos_pago_id"];
			$this->request->data["ComprasProductosTotale"]["tipos_moneda_id"] = $this->data["tipo_moneda_id"];
			$this->request->data["ComprasProductosTotale"]["observacion"] = $this->data["observacion"];
			$this->request->data["ComprasProductosTotale"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data["ComprasProductosTotale"]["neto_descuento"] = $this->data["neto_descuento"];
			$this->request->data["ComprasProductosTotale"]["titulo"] = $this->data["titulo"];
			$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 1;
			$this->request->data["ComprasProductosTotale"]["tipos_documento_id"] = $this->data["tipo_documento"];

			if($this->ComprasProductosTotale->save($this->request->data))
			{
				CakeLog::write('actividad', 'Se facturo la orden de compra - ' .$this->ComprasProductosTotale->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$this->loadModel("ComprasProducto");
				
				$idComprasTotales = $this->ComprasProductosTotale->id;
				
				if(!empty($idComprasTotales))
				{
					$productoArray = "";

					foreach($this->data["dimCodigoUno"] as $key => $productosTodos)
					{

						$productoArray[] = array(
							'dim_uno'=>$productosTodos,
							'proyecto'=>$this->request->data["proyecto"][$key],
							'cantidad'=>$this->request->data["cantidad"][$key],
							'precio_unitario'=>$this->request->data["precio"][$key],
							'empaque'=>$this->request->data["empaque"][$key],
							'descuento_producto'=>$this->request->data["descuento_unitario"][$key],
							'codigos_presupuestarios'=>$this->request->data["codigoPresupuestario"][$key],
							'descripcion'=>$this->request->data["descripcion"][$key],
							'dim_dos'=>$this->request->data["dimCodigoDos"][$key],
							'dim_tres'=>$this->request->data["dimCodigoTres"][$key],
							'dim_cuatro'=>$this->request->data["dimCodigoCuatro"][$key],
							'dim_cinco'=>$this->request->data["dimCodigoCinco"][$key],
							'compras_productos_totale_id'=>$idComprasTotales,
							'estado'=>1,
							'subtotal'=>$this->request->data["subToal"][$key],
							'afecto'=>$this->request->data["afecto"][$key]
						);
					}

					

					$idProductos = "";					
					if($this->ComprasProducto->saveAll($productoArray))
					{



						/*
						$this->loadModel("ComprasFactura");
						$this->request->data["ComprasFactura"]["tipos_documento_id"] = $this->request->data["tipo_documento"];
						$this->request->data["ComprasFactura"]["compras_productos_totale_id"] = $this->ComprasProductosTotale->id;
						$this->request->data["ComprasFactura"]["numero_documento"] = $this->request->data["numero_documento"];
						$this->ComprasFactura->save($this->request->data["ComprasFactura"]);
						*/
						$comprasProductosId = $this->ComprasProducto->id;
						$idProductos[] = $this->ComprasProducto->id;

						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 6)
						{
							
							$this->loadModel("ComprasProducto");

							$idComprasTotales = explode(",", $this->request->data["id_clonado"]);

							$idComprasSeleccionadas = $this->ComprasProducto->find("all", array(
								"conditions"=>array(
									"ComprasProducto.compras_productos_totale_id"=>$idComprasTotales
								),
								"fields"=>array("ComprasProducto.id", "ComprasProducto.compras_productos_totale_id", "ComprasProducto.estado")
							));

							$agrupaComprasSeleccionadas = "";

							foreach($idComprasSeleccionadas as $idComprasSeleccionada)
							{
								$agrupaComprasSeleccionadas[$idComprasSeleccionada["ComprasProducto"]["compras_productos_totale_id"]][] = array(
									"IdProductos"=>$idComprasSeleccionada["ComprasProducto"]["id"],
									"EstadoProducto"=>$idComprasSeleccionada["ComprasProducto"]["estado"],
								);			
							}

							$contadorProductosEnDb = "";
							$productosSeleccionados = "";

							foreach($agrupaComprasSeleccionadas as $key => $agrupaCompra)
							{
								foreach($agrupaCompra as $agrupaEstado)
								{
									if($agrupaEstado["EstadoProducto"] == 4 || $agrupaEstado["EstadoProducto"] == 8)
									{
										$contadorProductosEnDb[$key]["Ingresadosap"][] =  $agrupaEstado["IdProductos"];
									}

									if($agrupaEstado["EstadoProducto"] == 6)
									{
										$contadorProductosEnDb[$key]["Facturado"][] =  $agrupaEstado["IdProductos"];
									}	

									if (in_array($agrupaEstado["IdProductos"], $this->request->data["id"]))
									{
										$productosSeleccionados[$key]["ProducctosSeleccionado"][] = $agrupaEstado["IdProductos"]; 
									}
								}
							}

		
							$contadorSeleccionados = "";
							$ingresadosap = "";
							$facturados = "";

							foreach($contadorProductosEnDb as $key => $totalProductos)
							{
								$contadorSeleccionados[$key] = (isset($productosSeleccionados[$key])) ? count($productosSeleccionados[$key]["ProducctosSeleccionado"]) : 0;
								$ingresadosap[$key] = (isset($totalProductos["Ingresadosap"])) ? count($totalProductos["Ingresadosap"]) : 0;
								$facturados[$key]=  (isset($totalProductos["Facturado"])) ? count($totalProductos["Facturado"]) : 0;
							}

							
							$estadoComprasTotales = "";

							if(!empty($ingresadosap))
							{
								foreach($ingresadosap as $key => $ingresadosap)
								{
									if($contadorSeleccionados[$key] == $ingresadosap)
									{
										$estadoComprasTotales[] = array(
											"id"=>$key,
											"compras_estado_id"=>6
										);
									}
									/*
									else
									{
										$totalDos = $ingresadosap + $facturados[$key];

										$totalProductos = $facturados[$key] + $contadorSeleccionados[$key];

										if($ingresadosap == $totalDos)
										{
											$estadoComprasTotales[] = array(
												"id"=>$key,
												"compras_estado_id"=>6
											);
										}
									}
									*/	
								}
							}


							$idComprasTotales = "";
							if($estadoComprasTotales)
							{
								foreach($estadoComprasTotales as $estadoComprasTotale)
								{
									$idComprasTotales[] = array("id"=>$estadoComprasTotale);
								}
							}
							else
							{
								foreach($contadorSeleccionados as $key => $contadorSeleccionado)
								{
									$idComprasTotales[] = array("id"=>$contadorSeleccionados);
								}
							}

							$this->loadModel("ComprasFactura");
							$this->request->data["ComprasFactura"]["fecha_documento"] = $this->request->data["fecha_documento"];
							$this->request->data["ComprasFactura"]["tipos_documento_id"] = $this->request->data["tipo_documento"];
							$this->request->data["ComprasFactura"]["compras_productos_totale_id"] = $this->ComprasProductosTotale->id;
							$this->request->data["ComprasFactura"]["numero_documento"] = $this->request->data["numero_documento"];
							$this->request->data["ComprasFactura"]["requerimiento_id"] = serialize($idComprasTotales);
							//$this->request->data["ComprasFactura"]["documento_relacionda_id"] = serialize($idComprasTotales);


							$this->ComprasFactura->save($this->request->data["ComprasFactura"]);

							$this->ComprasProductosTotale->saveAll($estadoComprasTotales);
							
							CakeLog::write('actividad', 'cambio a facturado la orden de compra - ' .$this->ComprasProductosTotale->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
							
							if(!empty($this->request->data["id"]))
							{
								$actulizacionEstadosProductos = "";

								foreach($this->request->data["id"] as $id)
								{
									$actulizacionEstadosProductos[] = array(
										"id"=>$id,
										"estado"=>6
									);	
								}

								$this->ComprasProducto->saveAll($actulizacionEstadosProductos);
							}
							
							/*
							$comprasActualizadas = "";
							
							if(!empty($estadoComprasTotales))
							{
								foreach($estadoComprasTotales as $estadoComprasTotale)
								{
									$comprasActualizadas[] = array(
										"id"=>$estadoComprasTotale["id"],

									);
								}
							}
							*/
							/*
							$this->request->data["ComprasProductosTotale"]["id"] =  $this->request->data["id_clonado"][0];
							$this->request->data["ComprasProductosTotale"]["estado"] =  6;
							$this->request->data["ComprasProductosTotale"]["tipos_documento_id"] = "";
							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);
							CakeLog::write('actividad', 'cambio a facturado la orden de compra - ' .$this->ComprasProductosTotale->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));     
						
							if(!empty($this->request->data["id"]))
							{
								$actulizacionEstadosProductos = "";

								foreach($this->request->data["id"] as $id)
								{
									$actulizacionEstadosProductos[] = array(
										"id"=>$id,
										"estado"=>6
									);	
								}
								$this->ComprasProducto->save($actulizacionEstadosProductos);
							}

							*/
						}
												
						if(!empty($this->data["codigoPresupuestario"]))
						{
							$codigoCorto = explode("-", $this->data["codigoPresupuestario"][0]);
							
							$this->loadModel("Email");
							
							$email = $this->Email->find("all", array(
								'conditions'=>array("Email.informe"=>'Aprobador-'.$codigoCorto[0]),
								'fields'=>"Email.email"
							));


							if($this->request->data["tipo_documento"])
							{
								$this->loadModel("TiposDocumento");
								$nombreDocumento = $this->TiposDocumento->find("first", array(
								'conditions'=>array("TiposDocumento.id"=>$this->request->data["tipo_documento"])
								));	
							}


								if(!empty($nombreDocumento["TiposDocumento"]["nombre"]))
								{
									$numeroRequerimiento = $nombreDocumento["TiposDocumento"]["nombre"] . ' - ' .$this->request->data["numero_documento"];
									$plantilla = "documento_tributario";
									$nombreEmail = "SE GENERO UN NUEVO DOCUMENTO TRIBUTARIO";
								}
								else
								{
									$numeroRequerimiento = $this->ComprasProductosTotale->id;
									$plantilla = "documento_tributario";
									$nombreEmail = "SE GENERO UN NUEVO REQUERIMIENTO DE COMPRA";
								}

								$this->loadMOdel("Company");

								$empresa = $this->Company->find("first", array(
									"conditions"=>array("Company.id"=>$this->data["company_id"]),
									"fields"=>"Company.nombre"
								));
							
							if(!empty($email[0]["Email"]["email"]))
							{
								$Email = new CakeEmail("gmail");
								$Email->from(array('sgi@cdf.cl' => 'SGI'));
								$Email->to($email[0]["Email"]["email"]);
								$Email->subject("Orden de compra facturada");
								$Email->emailFormat('html');
								$Email->template($plantilla);
								$Email->viewVars(array(
									"nombreEmail" =>$nombreEmail,
									"usuario"=>$this->Session->read("Users.nombre"),
									"fechaCreacion"=>date("d/m/Y H:i"),
									"numeroRequerimiento"=>$numeroRequerimiento,
									"titulo"=>$this->data["titulo"],
									"total"=>$this->data["total"],
									"empresa"=>$empresa["Company"]["nombre"]
								));
								$Email->send();
							}
						}
						else
						{
							$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
							$estado = 2;
							exit;
						}


						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 1)
						{
							$this->request->data["ComprasProductosTotale"]["id"] = $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["compras_estado_id"] = 0;
							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);
						}
					}
					$estado = 1;
				}
				else
				{
					$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
					$estado = 2;
					exit;
				}
			}
			else
			{
				$this->Session->setFlash('NOSE GUARDO!!, intentelo nuevamente', 'msg_fallo');
				$estado = 2;
				exit;
			}
		}
		if($estado == 1)
		{
			if($this->request->data["clonar"] == 1)
			{
				$this->Session->setFlash('El requerimiento de compra se clono correctamente', 'msg_exito');
			}
			else if($this->request->data["clonar"] == 2)
			{
				$this->Session->setFlash('El requerimiento de compra se edito correctamente', 'msg_exito');
			}
			else
			{
				$this->Session->setFlash('Registrado correctamente', 'msg_exito');	
			}		
		}
		else
		{
			$this->Session->setFlash('El requerimiento de compra no se pudo generar', 'msg_fallo');
		}

		$this->set("estado", $estado);
	}

	/*
	public function carga_tipo_cambios()
	{
		$this->layout = "ajax";

		if($this->params->isAjax == 1)
		{
			$this->loadModel("TiposMoneda");

			$valor = $this->TiposMoneda->find("first", array(
				'conditions'=>array("TiposMoneda.id"=>$this->params->query["valor"]),
				'fields'=>"TiposMoneda.valor"
			));
			

			$jsonValor = "";
			foreach($valor as $valor);
			{
				$jsonValor = array($valor["valor"]);
			}

			$this->set("valor", $jsonValor);
		}
		else
		{
			return $this->redirect(array("action" => 'index'));
		}

	}
	*/

/*	public function actualiza_tipo_cambios()
	{
		$this->layout = "ajax";
		$this->loadModel("TiposMoneda");
		$url = 'http://mindicador.cl/api';
		$iniciaDatos = curl_init($url);
		curl_setopt($iniciaDatos,CURLOPT_RETURNTRANSFER, TRUE);
		$datos = curl_exec($iniciaDatos);
		$jsonDatos = json_decode($datos,true);

		$indicador[] = array("id"=>2, "valor"=>$jsonDatos["dolar"]["valor"]);
		$indicador[] = array("id"=>3, "valor"=>$jsonDatos["euro"]["valor"]);
		$indicador[] = array("id"=>5, "valor"=>$jsonDatos["utm"]["valor"]);
		$indicador[] = array("id"=>6, "valor"=>$jsonDatos["uf"]["valor"]);
		$this->TiposMoneda->saveAll($indicador);
		CakeLog::write('actividad', 'Se actualizo el tipo de cambio');
		exit;
	}*/
	public function actualiza_tipo_cambios()
	{
		$this->layout = "ajax";
		$this->loadModel("TiposMoneda");
		$urlJSON = 'http://indicadoresdeldia.cl/webservice/indicadores.json';
		$urlXML = 'http://indicadoresdeldia.cl/webservice/indicadores.xml';
		$json = json_decode(file_get_contents($urlJSON));
		$xml = simplexml_load_file($urlXML);

		if (isset($json->moneda)) {
			$obj = $json;
		}else if(isset($xml->moneda)){
			$obj = $xml;
		} else {
			$Email = new CakeEmail("gmail");
			$Email->from(array('sgi@cdf.cl' => 'SGI'));
			$Email->to('ddiaz@cdf.cl');
			$Email->subject("Carga indicadores en SGI");
			$Email->emailFormat('html');
			$Email->template('carga_tipo_cambios');
			$Email->send();
			exit;
		}

		$indicador[] = array("id"=>2, "valor"=> preg_replace( '/,/','.', preg_replace('/[$.]/' ,'', $obj->moneda->dolar)) );
		$indicador[] = array("id"=>3, "valor"=> preg_replace( '/,/','.', preg_replace('/[$.]/' ,'', $obj->moneda->euro)) );
		$indicador[] = array("id"=>5, "valor"=> preg_replace( '/,/','.', preg_replace('/[$.]/' ,'', $obj->indicador->utm)) );
		$indicador[] = array("id"=>6, "valor"=> preg_replace( '/,/','.', preg_replace('/[$.]/' ,'', $obj->indicador->uf)) );

		$this->TiposMoneda->saveAll($indicador);
		CakeLog::write('actividad', 'Se actualizo el tipo de cambio');
	}

	public function get_canal($srt)
	{
		$srt=trim($srt);
		switch ($srt) 
		{
			case 'CDF Básico':
			case 'Canal del Fútbol':
				return "CDFB";
				break;
			case 'Fox Sports':
				return "FS";
				break;
			case 'ESPN':
				return "ESPN";
				break;
			case 'ESPN+':
				return "ESPNM";
				break;
			case 'ESPN3':
			case 'ESPN3 SD+HD':
				return "ESPN3";
				break;
			case 'CDF Premium':
			case 'Canal Del Futbol Pre':
				return "CDFP";
				break;
			case 'Fox Sports 2':
			case 'Fox Sports 2 SD+HD':
				return "FS2";
				break;
			case 'Fox Sports 3':
			case 'Fox Sports 3 SD+HD':
				return "FS3";
				break;
			case 'ESPN HD':
				return "ESPNHD";
				break;
			case 'CDF HD':
				return "CDFHD";
				break;
			case 'Fox SPTHD=PREM':
			case 'Fox Sport Premium':
				return "FSP";
				break;
			default:
				return "XX".$srt;
				break;
		}
	}

	public function busca_empresa()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		if($this->params->isAjax == 1)
		{
			$this->loadModel("ComprasProductosTotale");

			$registrosAsociados = $this->ComprasProductosTotale->find("all", array(
				'conditions'=>array(
					"ComprasProductosTotale.company_id " => $this->params->query["idEmpresa"],
					"ComprasProductosTotale.compras_estado_id != " => 6,
					"ComprasProductosTotale.tipos_documento_id  " => ""
				),

				'fields'=>'ComprasProductosTotale.id',
				'recursive'=>0
			));

			$idComprasProductosTotales = ""; 
			foreach($registrosAsociados as $registrosAsociado)
			{
				$idComprasProductosTotales[] = $registrosAsociado["ComprasProductosTotale"]["id"];
			}



			if(!empty($registrosAsociados))
			{
				$this->set("idEmpresa", implode('-', $idComprasProductosTotales));
			}
		}
	}

	public function asociar_facturas()
	{
		$this->layout = "ajax";

		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesi?', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		if($this->params->isAjax == 1)
		{
			$existe = "";
		
			$this->loadModel("ComprasFacturas");

			$numeroFacturas = $this->ComprasFacturas->find("all", array(
				'conditions'=>array(
					"ComprasFacturas.numero_documento" => $this->params->query["numeroFactura"],
					"ComprasFacturas.tipos_documento_id" => $this->params->query["tipoDocumento"],
				),
				'recursive'=>2
			));

			$idComprasProductosTotale = "";
			if(!empty($numeroFacturas))
			{
				foreach ($numeroFacturas as $numeroFactura)
				{
					$idComprasProductosTotale[] = $numeroFactura["ComprasFacturas"]["compras_productos_totale_id"];
				}
			}
				

			$this->loadModel("ComprasProductosTotale");
			if(!empty($idComprasProductosTotale))
			{
				$ordenRelacionada = $this->ComprasProductosTotale->find("all", array(
					'conditions'=>array(
						"ComprasProductosTotale.company_id" => $this->params->query["idEmpresa"],
						"ComprasProductosTotale.id"=>$idComprasProductosTotale,
						"ComprasProductosTotale.compras_estado_id != "=> array(0, 5)
					),
					"recursive"=>0
				));
			}
			

			if(!empty($ordenRelacionada))
			{
				$existe = 1;
			}

			$this->set("existe", $existe);
		}
	}

	public function numeros_a_palabras(){
		
		$this->layout = "ajax";
		if(!isset($this->request->query["numero"])){
			$this->request->query["numero"] = 0;	
		}
		App::import("Vendor", "words", array("file" => "Numbers" . DS . "Words.php"));

		$this->words = new Numbers_Words();

		$numeroPalabras = $this->words->toWords($this->request->query["numero"],"es");
		$this->set("numeroPalabras", $numeroPalabras);
	}

	public function pdf_basico(){

		$this->layout = "ajax";
		$pathFile = WWW_ROOT . "files" . DS . "pdf" . DS .$this->request->data["nombre"];
		App::import("Vendor", "tcpdf", array("file" => "tcpdf" . DS . "tcpdf.php"));
		$this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->tcpdf->SetAuthor('Servicios de Televisión Canal del Fútbol Limitada');
		$this->tcpdf->setPrintHeader(false);
		$this->tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$this->tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		isset($this->request->data["margenLi"]) ? $this->tcpdf->setListIndentWidth($this->request->data["margenLi"]) : "" ;
		//$this->tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT,PDF_MARGIN_BOTTOM);
		$this->tcpdf->SetMargins(18, 20, 18, true);
		$this->tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$this->tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$this->tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$this->tcpdf->SetFontSize(12);
		$this->tcpdf->AddPage();
		$this->tcpdf->writeHTML($this->request->data["html"], true, false, true, false, '');
		$this->tcpdf->Output($pathFile, "F");
		$ruta = Router::fullbaseUrl().$this -> webroot."files". DS . "pdf" . DS . $this->request->data["nombre"];
		$this->set("ruta", $ruta);
	}

	public function pdf_basico2(){
		$this->layout = "ajax";
		App::import("Vendor", "tcpdf", array("file" => "tcpdf" . DS . "tcpdf.php"));
		$destino = WWW_ROOT . "files" . DS . $this->request->data["controlador"] . DS . $this->request->data["carpeta"];
		if(!file_exists($destino)){
			mkdir($destino, 0777, true);
			chmod($destino, 0777);
		}
		$pathFile = $destino. DS . $this->request->data["nombre"];
		$file = new File($pathFile, true, 0777);
		if($file->exists())
			$file->delete();
		$this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
		$this->tcpdf->SetAuthor('Servicios de Televisión Canal del Fútbol Limitada');
		$this->tcpdf->setPrintHeader(false);
		$this->tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$this->tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		isset($this->request->data["margenLi"]) ? $this->tcpdf->setListIndentWidth($this->request->data["margenLi"]) : "" ;		
		$this->tcpdf->SetMargins(18, 18, 18, true);
		$this->tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER); //PDF_MARGIN_FOOTER
		$this->tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$this->tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$this->tcpdf->SetFontSize(11);
		$this->tcpdf->AddPage();
		$img_file = WWW_ROOT.'img'.DS.'cdf_pdf.jpg';
		$this->tcpdf->Image($img_file, 173, 10, 29, 12, '', '', '', false, 300, '', false, false, 0);		
		$this->tcpdf->writeHTML($this->request->data["html"], true, false, true, false, '');
		ob_clean();		
		$this->tcpdf->Output($pathFile, 'F');		
		$ruta = Router::fullbaseUrl().$this -> webroot."files". DS . $this->request->data["controlador"] . DS . $this->request->data["carpeta"] . DS . $this->request->data["nombre"];
		$this->set("ruta", $ruta);
	}

	public function paises()
	{
		if($this->Session->Read("Users.flag") != 1)
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		$this->loadModel("Paise");
		$paises = $this -> Paise -> find('all', array(
			'fields' => array(
				'Paise.id', 
				'Paise.nombre'
			), 
			'order'=>'Paise.nombre ASC'));
		
		$muestraPaises = "";

		foreach($paises as $pais)
		{
			$muestraPaises[] = array("Id"=>$pais["Paise"]["id"], "Nombre"=>$pais["Paise"]["nombre"]) ;
		}

		$this->set('paises', $muestraPaises);
	}
	
	/**
    * @name Mutlidimensional Array Sorter.
    * This function can be used for sorting a multidimensional array by sql like order by clause
    */
    public function sort_array_multidim(array $array, $order_by)
    {
        //TODO -c flexibility -o tufanbarisyildirim : this error can be deleted if you want to sort as sql like "NULL LAST/FIRST" behavior.
        if(!is_array($array[0]))
            throw new Exception('$array must be a multidimensional array!',E_USER_ERROR);
        $columns = explode(',',$order_by);
        foreach ($columns as $col_dir)
        {
            if(preg_match('/(.*)([\s]+)(ASC|DESC)/is',$col_dir,$matches))
            {
                if(!array_key_exists(trim($matches[1]),$array[0]))
                    trigger_error('Unknown Column <b>' . trim($matches[1]) . '</b>',E_USER_NOTICE);
                else
                {
                    if(isset($sorts[trim($matches[1])]))
                        trigger_error('Redundand specified column name : <b>' . trim($matches[1] . '</b>'));
                    $sorts[trim($matches[1])] = 'SORT_'.strtoupper(trim($matches[3]));
                }
            }
            else
            {
                throw new Exception("Incorrect syntax near : '{$col_dir}'",E_USER_ERROR);
            }
        }
        //TODO -c optimization -o tufanbarisyildirim : use array_* functions.
        $colarr = array();
        foreach ($sorts as $col => $order)
        {
            $colarr[$col] = array();
            foreach ($array as $k => $row)
            {
                $colarr[$col]['_'.$k] = strtolower($row[$col]);
            }
        }
       
        $multi_params = array();
        foreach ($sorts as $col => $order)
        {
            $multi_params[] = '$colarr[\'' . $col .'\']';
            $multi_params[] = $order;
        }
        $rum_params = implode(',',$multi_params);
        eval("array_multisort({$rum_params});");
        $sorted_array = array();
        foreach ($colarr as $col => $arr)
        {
            foreach ($arr as $k => $v)
            {
                $k = substr($k,1);
                if (!isset($sorted_array[$k]))
                    $sorted_array[$k] = $array[$k];
                $sorted_array[$k][$col] = $array[$k][$col];
            }
        }
        return array_values($sorted_array);
    }

    public function eliminarAcentos($cadena)
	{
		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðòóôõöøùúûýýþÿŔŕ';
	    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidoooooouuuyybyRr';
	    $cadena = utf8_decode($cadena);
	    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
	    $cadena = strtolower($cadena);
	    return utf8_encode($cadena);
	}
	/**
	* Primera mayuscula siempre que texto tenga largo mayor que 2	
	*/	
	public function capitalize($frase){
		$nombre = '';
		$array = explode(" ", trim($frase));
		if(!empty($array))
		foreach($array as $value) {										
			(strtoupper($value)=='CDF' || strtoupper($value)=='RRHH' || strtoupper($value)=='HD')?	$nombre.= strtoupper($value).' ': $nombre.= (strlen($value)>2) ? ucwords( mb_strtolower($value, 'UTF-8') ).' ' : $value.' ';
		}
		return trim($nombre);
	}
	
	public function getUTC($dia){
		$this->loadModel("HorarioGmt");

		$diferenciaUTC = $this->HorarioGmt->find("first", array(
			"fields" =>  "HorarioGmt.utc",
			"conditions"=>array( "HorarioGmt.fecha_inicio <=" => $dia,
				"HorarioGmt.fecha_termino >=" => $dia)
		));

		return !empty($diferenciaUTC) ? $diferenciaUTC["HorarioGmt"]["utc"] : 0;
	}

	public function utc(){
		$this->autoRender = false;		
		$this->response->type("json");

		$utc = isset($this->request->query["dia"]) ? $this->getUTC($this->request->query["dia"]) : 0 ;
		//$this->set("utc",$utc);
		return json_encode($utc);			
	}

	public function validaEmpresaTrabajador(){
		$this->autoRender = false;
		$this->response->type("json");

		$this->loadModel("Company");
		$this->loadModel("Trabajadore");
		$existe = "";
		if(!empty($this->params->query["idEmpresa"])){
			
			$rutEmpresa = $this->Company->findById($this->params->query["idEmpresa"], array(
				'fields'=>"rut",
			));
			if(!empty($rutEmpresa['Company']['rut'])){
				$trabajador = $this->Trabajadore->find('all', array(
					'conditions'=>array(
						'Trabajadore.rut'=>$rutEmpresa['Company']['rut'],
						'Trabajadore.estado' => 'Activo'
					),
					'fields'=>'Trabajadore.id',
					'recursive'=> -1
				)) ;
				if(!empty($trabajador[0]['Trabajadore']['id'])){
					$existe = 1;
				}
			}
		}
		return  json_encode($existe);
	}

	public function validaEmpresaTrabajadorEnviaCorreo(){
		$this->autoRender = false;
		$this->response->type("json");
		$estado = false;
		if(!empty($this->params->query["nDocumento"])){
			$Email = new CakeEmail("gmail");
			$Email->from(array('sgi@cdf.cl' => 'SGI'));
			$Email->to('rrhh@cdf.cl');//($email[0]["Email"]["email"]);
			$Email->subject("Se genero un documento asociado a un trabajador activo");
			$Email->emailFormat('html');
			$Email->template('valida_empresa_trabajador');
			$Email->viewVars(array(
				"usuarioCreador"=>$this->Session->read("Users.nombre"),
				"fechaCreacion"=>date("d/m/Y H:i"),
				"numeroDocumento"=>$this->params->query["nDocumento"],
				"empresa"=>$this->params->query["nombreEmpresa"]
			));
			
			if( $Email->send() ){
				$estado = true;
			}	
		}
		return  $estado;
	}

	public function kapi_getxml($url, $data = null)
	{		
		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $url);
		$contents = curl_exec($c);
		curl_close($c);

		return $contents;
	}

	public function kapi_post($url, $data)
	{
		$data_string = json_encode($data);		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);          
		$response = curl_exec($ch);
		return $response;
	}

	public function sap_get($url, $sessionId = null, $noLimit = null)
	{				
		$c = curl_init();
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, $url);
		$headers = array();

		if ($sessionId) {
			$headers[] = 'Content-Type: application/json';
			$headers[] = 'Connection: Keep-Alive';
			$headers[] = 'Cookie: B1SESSION='.$sessionId;
		}
		if ($noLimit){
			$headers[] = "Prefer: odata.maxpagesize=0";	
		}

		curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($c);
		curl_close($c);
		return $response;

	}

	public function sap_post($url, $data, $sessionId = null)
	{					
		$data_string = json_encode($data, JSON_NUMERIC_CHECK);							
		$HttpSocket = new HttpSocket();
		$request = array();		

		if ($sessionId) { 
			$request = array(
				'header' => array(
					'User-Agent' => 'CakePHP',
			        'Connection' => 'Keep-Alive',			        
			        'Content-Type' => 'application/json',
			        'Cookie' => "B1SESSION=".$sessionId			        
			    )
			  );
		}
		$response = $HttpSocket->post($url, $data_string, $request);
		return $response;
	}	

}
?>
