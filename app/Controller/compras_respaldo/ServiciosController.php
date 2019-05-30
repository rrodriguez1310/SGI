<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class ServiciosController extends AppController {

    public $components = array('RequestHandler');
	
	public function buscaAreas()
	{
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

					$codigosPresupuestarios = $this->CodigosPresupuesto->find("all", array(
						'conditions'=>array('CodigosPresupuesto.codigo LIKE'=>$codigoCorto["Dimensione"]["codigo_corto"].'%')
					));
				}




				if(!empty($codigosPresupuestarios))
				{
					foreach($codigosPresupuestarios as $codigosPresupuestario)
					{
						$codigoPresupuesto[] =  array( "Id"=>$codigosPresupuestario["CodigosPresupuesto"]["codigo"], "Nombre"=>$codigosPresupuestario["CodigosPresupuesto"]["codigo"] . ' - ' . $codigosPresupuestario["CodigosPresupuesto"]["nombre"]); 
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
		if(!empty($this->request->data))
		{
			if(!empty($this->request->data["adjunto"]))
			{
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
						if($this->request->data["adjunto"]['size'] <= 2000000)
						{
							move_uploaded_file($this->data['adjunto']['tmp_name'], $destino . DS .$this->data['adjunto']['name']);
							
						}
						else
						{
							$estado = 2;
						}
					}
					else
					{
						$estado = 2;	
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
			if(isset($this->data['adjunto']['name']))
			{
				$this->request->data["ComprasProductosTotale"]["adjunto"] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->data['adjunto']['name'];
			}
			$this->request->data["ComprasProductosTotale"]["neto_descuento"] = $this->data["neto_descuento"];
			$this->request->data["ComprasProductosTotale"]["titulo"] = $this->data["titulo"];
			$this->request->data["ComprasProductosTotale"]["estado"] = 1;

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
							'subtotal'=>$this->request->data["subToal"][$key]
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
							$this->request->data["ComprasProductosTotale"]["estado"] =  0;
							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);

							CakeLog::write('actividad', 'Se clono la orden de compra - ' .$this->ComprasProductosTotale->id . ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						}
						


												
						if(!empty($this->data["codigoPresupuestario"]))
						{
							$codigoCorto = explode("-", $this->data["codigoPresupuestario"][0]);
							
							$this->loadModel("Email");
							
							$email = $this->Email->find("all", array(
								'conditions'=>array("Email.informe"=>'Aprobador-'.$codigoCorto[0]),
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
							$estado = 2;
						}
						
					}
					$estado = 1;
				}
				else
				{
					$estado = 2;
				}
			}
			else
			{
				$estado = 2;
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
		$this->set("estado", $estado);
	}

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

				),
				"fields"=>array('ComprasProducto.subtotal', 'ComprasProducto.compras_productos_totale_id'),
				'recursive'=>2
			));

			$idComprasProductosTotales = "";

			foreach($gastadoItems as $gastadoItem)
			{
				if($gastadoItem["ComprasProductosTotale"]["estado"] == 2 || $gastadoItem["ComprasProductosTotale"]["estado"] == 6 || $gastadoItem["ComprasProductosTotale"]["estado"] == 4)
				{

					

					if($gastadoItem["ComprasProductosTotale"]["estado"] != 6 && $gastadoItem["ComprasProductosTotale"]["tipos_documento_id"] != "")
					{

						$idComprasProductosTotales[] = $gastadoItem["ComprasProductosTotale"]["neto_descuento"];
					}
					
				}
			}



			if(empty($idComprasProductosTotales))
			{
				$idComprasProductosTotales = array(0);
			}
			

			$detalleGastos = array(
				"sumaPresupuestoArea"=>array_sum($sumaPresupuestoArea),
				"gastosArea"=>array_sum($idComprasProductosTotales),
				"saldoGastos"=>array_sum($sumaPresupuestoArea) - array_sum($idComprasProductosTotales)

			);

			$this->set("detalleGastos", $detalleGastos);




	

			/*
			$saldoItem = "";
			$saldoArea = "";
			$sumaGastadoItem = "";
			$sumaGastadoArea = "";

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

			$gastadoItem = $this->ComprasProducto->find("all", array(
				"conditions"=>array(
					"ComprasProducto.codigos_presupuestarios"=>$this->params->query["codigoPresupuestario"],
					//"ComprasProducto.estado"=>2,
				),
				"fields"=>array('ComprasProducto.subtotal', 'ComprasProducto.compras_productos_totale_id')
			));

			$this->loadModel("ComprasProductosTotale");

			$gastadoArea = $this->ComprasProductosTotale->find("all", array(
				"conditions"=>array(
					"ComprasProducto.codigos_presupuestarios LIKE"=>'%'.$codigoCorto[0].'%',
					"ComprasProducto.estado"=>array(2, 4),

				),
				"fields"=>'ComprasProducto.subtotal'
			));

			foreach($gastadoItem as $sumaItem)
			{
				$sumaGastadoItem[] = $sumaItem["ComprasProducto"]["subtotal"];
			}

			$sumaGastadoArea = "";

			foreach($gastadoArea as $sumaArea)
			{
				$sumaGastadoArea[] = $sumaArea["ComprasProducto"]["subtotal"];
			}

			if(!empty($sumaGastadoItem) && !empty($presupuestoItem["CodigosPresupuesto"]["presupuesto_total"]))
			{
				$saldoItem =  $presupuestoItem["CodigosPresupuesto"]["presupuesto_total"] - array_sum($sumaGastadoItem);
			}

			if(!empty($sumaPresupuestoArea) && !empty($sumaGastadoArea))
			{
				$saldoArea =  array_sum($sumaPresupuestoArea) - array_sum($sumaGastadoArea);
			}

			if(empty($sumaGastadoItem))
			{
				$sumaGastadoItem = array(0);
			}

			if(empty($sumaPresupuestoArea))
			{
				$sumaPresupuestoArea = array(0);
			}

			if(empty($sumaGastadoArea))
			{
				$sumaGastadoArea = array(0);
			}
			
			if(empty($sumaGastadoItem))
			{
				$sumaGastadoItem = array(0);
			}

			if(empty($saldoItem))
			{
				$saldoItem = $presupuestoItem["CodigosPresupuesto"]["presupuesto_total"];
			}

			if(empty($saldoArea))
			{
				$saldoArea = array_sum($sumaPresupuestoArea);
			}

			$saldos = array(
				"presupuestoItem"=>$presupuestoItem["CodigosPresupuesto"]["presupuesto_total"],
				"sumaPresupuestoArea"=>array_sum($sumaPresupuestoArea),
				'sumaGastadoArea'=>array_sum($sumaGastadoArea),
				"sumaGastadoItem"=>array_sum($sumaGastadoItem),
				'saldoItem'=>$saldoItem,
				'saldaArea'=>$saldoArea 	
			);
			$this->set("saldos", $saldos);
			*/
		}
	}

	public function envioCorreoCumpleanos()
	{
		$this->layout = null;
		$this->loadModel("Trabajadore");
		$this->loadModel("Cargo");
		$trabajadores = $this->Trabajadore->find('all', array(
			'conditions'=> array(
				"TO_CHAR(Trabajadore.fecha_nacimiento,'MMDD')"=>date('md'),
				'Trabajadore.estado'=>'Activo', 
				'Trabajadore.tipo_contrato_id !='=>3),
			'fields'=>array(
				'Trabajadore.nombre', 
				'Trabajadore.apellido_paterno', 
				'Trabajadore.sexo', 
				'Trabajadore.cargo_id',
				'Trabajadore.fecha_nacimiento'),
			'recursive'=>3
			)
		);
		//$gerencias = $this->Cargo->find("all", array('conditions'=>array($trabajadores["Trabajadore"]["cargo_id"])));
		//pr($trabajadores);exit;
		setlocale(LC_ALL,"es_ES");
		if(!empty($trabajadores))
		{
			foreach($trabajadores as $trabajador)
			{	
				$trabajador["Trabajadore"]["plantilla"] = "plantilla_hombre.jpg";
				$trabajador["Trabajadore"]["colornombre"] = array(249, 227, 141);
				$trabajador["Trabajadore"]["colorfecha"] = array(255, 255, 255);
				if($trabajador["Trabajadore"]["sexo"]===1) 
				{
					$trabajador["Trabajadore"]["plantilla"] = "plantilla_mujer.jpg";
					$trabajador["Trabajadore"]["colornombre"] = array(176, 33, 121);
					$trabajador["Trabajadore"]["colorfecha"] = array(255, 49, 71);
				}				
				$fecha_nacimiento = new DateTime($trabajador["Trabajadore"]["fecha_nacimiento"]);
				$trabajador['Trabajadore']['fecha_nacimiento'] = mb_strtoupper(strftime("%d de %B de ", strtotime($fecha_nacimiento->format('m/d/Y'))).date('Y'));
				$nombreCorreo = "Feliz Cumpleaños! ".$trabajador["Trabajadore"]["nombre"]." ".$trabajador["Trabajadore"]["apellido_paterno"];
				$nombre = explode(' ', $trabajador["Trabajadore"]["nombre"]);
				$trabajador["Trabajadore"]["nombre"] =  mb_strtoupper($nombre[0]);
				if(!empty($trabajador["Trabajadore"]["cargo_id"]))
				{
					$trabajador["Gerencia"]["nombre"] = mb_strtoupper($trabajador["Cargo"]["Area"]["Gerencia"]["nombre"]);	
				}
				$trabajador["Trabajadore"]["apellido_paterno"] = mb_strtoupper($trabajador["Trabajadore"]["apellido_paterno"]);

				$image = imagecreatefromjpeg(WWW_ROOT.'img'.DS.$trabajador["Trabajadore"]["plantilla"]);
				$color1 = imagecolorallocate($image, $trabajador["Trabajadore"]["colornombre"][0], $trabajador["Trabajadore"]["colornombre"][1], $trabajador["Trabajadore"]["colornombre"][2]);
				$blanco = imagecolorallocate($image, $trabajador["Trabajadore"]["colorfecha"][0], $trabajador["Trabajadore"]["colorfecha"][1], $trabajador["Trabajadore"]["colorfecha"][2]);
				
				$ttf = WWW_ROOT.'fonts'.DS."AkzidenzGrotesk-CondItalic.ttf";
				imagefttext($image, 12, 0, 80, 355, $blanco, $ttf, $trabajador['Trabajadore']['fecha_nacimiento']);

				$ttf = WWW_ROOT.'fonts'.DS."AkzidenzGrotesk-ExtraBoldCondItalic.ttf";
				imagefttext($image, 30, 0, 80, 132, $color1, $ttf, $trabajador["Trabajadore"]["nombre"]);
				$bbox = imageftbbox(30, 0, $ttf, $trabajador["Trabajadore"]["nombre"]);
				
				if(!empty($trabajador["Trabajadore"]["cargo_id"]))
				{
					imagefttext($image, 16, 0, 80, 154, $color1, $ttf, $trabajador["Gerencia"]["nombre"]);
				}

				$ttf = WWW_ROOT.'fonts'.DS."AkzidenzGrotesk-LightCondItalic.ttf";

				imagettftext($image, 30, 0, ($bbox[2]+90), 132, $color1, $ttf, $trabajador["Trabajadore"]["apellido_paterno"]);

				//$trabajador["Trabajadore"]["nombre"]." ".

				$ruta = WWW_ROOT.'img'.DS.'cumple.png';
				//pr($ruta);exit;
				imagepng($image, $ruta);
				imagedestroy($image);

				$Email = new CakeEmail("gmail");
				$Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
				$Email->to(array('bperez@cdf.cl'));
				$Email->subject($nombreCorreo);
				$Email->emailFormat('html');
				$Email->attachments(array(
				    'cumple.png' => array(
				        'file' =>  WWW_ROOT.'img'.DS.'cumple.png',
				        'mimetype' => 'image/png',
				        'contentId' => 'my-unique-id'
				    )
				));
				$Email->template('envio_correo_cumpleanos');
				$Email->viewVars(array(
					"trabajador"=>$trabajador,
				));
				$Email->send();

			}
		}
	}

	public function valida_rut()
	{
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
	}


	public function addDocumentoTributario()
	{
		$this->layout = "ajax";

		$estado = "";		
		if(!empty($this->request->data))
		{
			if(!empty($this->request->data["adjunto"]))
			{
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
						if($this->request->data["adjunto"]['size'] <= 2000000)
						{
							move_uploaded_file($this->data['adjunto']['tmp_name'], $destino . DS .$this->data['adjunto']['name']);
							
						}
						else
						{
							$estado = 2;
						}
					}
					else
					{
						$estado = 2;	
					}
				}
			}
			//pr($this->data);exit;
			
			$this->loadModel("ComprasProductosTotale");
			$idProductos = "";
			$idTotal = "";
			if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 2)
			{
				$idTotal = $this->request->data["id_clonado"];
				$idProductos = $this->request->data["idProducto"];
				CakeLog::write('actividad', 'edito el documento tributario - ' .$this->request->data["id_clonado"]. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
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
			$this->request->data["ComprasProductosTotale"]["neto_descuento"] = $this->data["neto_descuento"];
			$this->request->data["ComprasProductosTotale"]["titulo"] = $this->data["titulo"];
			$this->request->data["ComprasProductosTotale"]["estado"] = 1;
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
							'subtotal'=>$this->request->data["subToal"][$key]
						);
					}

					$idProductos = "";					
					if($this->ComprasProducto->saveAll($productoArray))
					{
						$this->loadModel("ComprasFactura");

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
							$this->request->data["ComprasProductosTotale"]["estado"] =  0;
							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);     
						}
												
						if(!empty($this->data["codigoPresupuestario"]))
						{
							$codigoCorto = explode("-", $this->data["codigoPresupuestario"][0]);
							
							$this->loadModel("Email");
							
							$email = $this->Email->find("all", array(
								'conditions'=>array("Email.informe"=>'Aprobador-'.$codigoCorto[0]),
								'fields'=>"Email.email"
							));
							
							$envioEmail = "";




							foreach ($email as $sendEmail) {
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
							$estado = 2;
						}


						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 1)
						{
							$this->request->data["ComprasProductosTotale"]["id"] = $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["estado"] = 0;

							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);
							CakeLog::write('actividad', 'se clono el documento tributario - ' .$this->ComprasProductosTotale->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						}
					}
					$estado = 1;
				}
				else
				{
					$estado = 2;
				}
			}
			else
			{
				$estado = 2;
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


	public function facturados()
	{
		$this->layout = "ajax";

		pr($this->request->data);
		$estado = "";		
		if(!empty($this->request->data))
		{
			if(!empty($this->request->data["adjunto"]))
			{
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
						if($this->request->data["adjunto"]['size'] <= 2000000)
						{
							move_uploaded_file($this->data['adjunto']['tmp_name'], $destino . DS .$this->data['adjunto']['name']);
							
						}
						else
						{
							$estado = 2;
						}
					}
					else
					{
						$estado = 2;	
					}
				}
			}
			//pr($this->data);exit;

			
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
				$this->request->data["ComprasProductosTotale"]["adjunto"] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario').DS.$this->data['adjunto']['name'];
			}

			if(!empty($this->request->data["tipo_cambio"]))
			{
				$this->request->data["ComprasProductosTotale"]["tipo_cambio"] = $this->request->data["tipo_cambio"];
			}

			//$this->request->data["ComprasProductosTotale"]["id"] = $idTotal;
			$this->request->data["ComprasProductosTotale"]["company_id"] = $this->data["company_id"];
			$this->request->data["ComprasProductosTotale"]["descuento_total"] = str_replace('.', '', $this->data["monto"]);
			$this->request->data["ComprasProductosTotale"]["impuesto"] = $this->data["tipoImpuesto"];
			$this->request->data["ComprasProductosTotale"]["total"] = str_replace('.', '', $this->data["total"]); 
			//$this->request->data["ComprasProductosTotale"]["fecha"] = date("Y-m-d", strtotime($this->data["fecha_entrega"]));
			$this->request->data["ComprasProductosTotale"]["plazos_pago_id"] = $this->data["plazos_pago_id"];
			$this->request->data["ComprasProductosTotale"]["tipos_moneda_id"] = $this->data["tipo_moneda_id"];
			$this->request->data["ComprasProductosTotale"]["observacion"] = $this->data["observacion"];
			$this->request->data["ComprasProductosTotale"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
			$this->request->data["ComprasProductosTotale"]["neto_descuento"] = $this->data["neto_descuento"];
			$this->request->data["ComprasProductosTotale"]["titulo"] = $this->data["titulo"];
			$this->request->data["ComprasProductosTotale"]["estado"] = 1;
			$this->request->data["ComprasProductosTotale"]["tipos_documento_id"] = $this->data["tipo_documento"];

			//pr($this->request->data["ComprasProductosTotale"]);exit;

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
							'subtotal'=>$this->request->data["subToal"][$key]
						);
					}

					$idProductos = "";					
					if($this->ComprasProducto->saveAll($productoArray))
					{
						$this->loadModel("ComprasFactura");

						$this->request->data["ComprasFactura"]["tipos_documento_id"] = $this->request->data["tipo_documento"];
						$this->request->data["ComprasFactura"]["compras_productos_totale_id"] = $this->ComprasProductosTotale->id;
						$this->request->data["ComprasFactura"]["numero_documento"] = $this->request->data["numero_documento"];

						if($this->ComprasFactura->save($this->request->data["ComprasFactura"])){
						}

						$comprasProductosId = $this->ComprasProducto->id;
						$idProductos[] = $this->ComprasProducto->id;

						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 6)
						{
							$this->request->data["ComprasProductosTotale"]["id"] =  $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["estado"] =  6;
							$this->request->data["ComprasProductosTotale"]["tipos_documento_id"] = "";
							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);
							CakeLog::write('actividad', 'cambio a facturado la orden de compra - ' .$this->ComprasProductosTotale->id. ' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));     
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

								
								/*

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
								*/


							
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
							$estado = 2;
						}


						if(!empty($this->request->data["id_clonado"]) && $this->request->data["clonar"] == 1)
						{
							$this->request->data["ComprasProductosTotale"]["id"] = $this->request->data["id_clonado"];
							$this->request->data["ComprasProductosTotale"]["estado"] = 0;

							$this->ComprasProductosTotale->save($this->request->data["ComprasProductosTotale"]);
						}
					}
					$estado = 1;
				}
				else
				{
					$estado = 2;
				}
			}
			else
			{
				$estado = 2;
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
	public function actualiza_tipo_cambios()
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
		//CakeLog::write('actividad', 'Se actualizo el tipo de cambio');
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
				return "ESPN3";
				break;
			case 'CDF Premium':
			case 'Canal Del Futbol Pre':
				return "CDFP";
				break;
			case 'Fox Sports 2':
				return "FS2";
				break;
			case 'Fox Sports 3':
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

		if($this->params->isAjax == 1)
		{
			$this->loadModel("ComprasProductosTotale");

			$registrosAsociados = $this->ComprasProductosTotale->find("all", array(
				'conditions'=>array(
					"ComprasProductosTotale.company_id " => $this->params->query["idEmpresa"],
					"ComprasProductosTotale.estado != " => 6,
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
		if($this->params->isAjax == 1)
		{
		
			$this->loadModel("ComprasFacturas");

			$numeroFacturas = $this->ComprasFacturas->find("all", array(
				'conditions'=>array(
					"ComprasFacturas.numero_documento" => $this->params->query["numeroFactura"],
					"ComprasFacturas.tipos_documento_id" => $this->params->query["tipoDocumento"],
					//"ComprasFacturas.tipos_documento_id" => $this->params->query["tipoDocumento"],

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
				
			//pr($this->params->query["idEmpresa"]);

			$this->loadModel("ComprasProductosTotale");
			if(!empty($idComprasProductosTotale))
			{
				$ordenRelacionada = $this->ComprasProductosTotale->find("all", array(
					'conditions'=>array(
						"ComprasProductosTotale.company_id" => $this->params->query["idEmpresa"],
						"ComprasProductosTotale.id"=>$idComprasProductosTotale,
						"ComprasProductosTotale.estado != "=> 4
					)
				));
			}


			//pr($ordenRelacionada);exit;

			$this->set("numeroFactura", $ordenRelacionada);
		}
	}

	public function numeros_a_palabras(){
		
		$this->layout = "ajax";
		if(!isset($this->request->query["numero"])){
			$this->request->query["numero"] = 0;	
		}
		if ($this->Session->read('Users.flag') == 1) {

			App::import("Vendor", "words", array("file" => "Numbers" . DS . "Words.php"));

			$this->words = new Numbers_Words();

			$numeroPalabras = $this->words->toWords($this->request->query["numero"],"es");
			$this->set("numeroPalabras", $numeroPalabras);
		} else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function pdf_basico(){
		$this->layout = "ajax";
		if ($this->Session->read('Users.flag') != 1) {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		$pathFile = WWW_ROOT . "files" . DS . "pdf" . DS .$this->request->data["nombre"];
		App::import("Vendor", "tcpdf", array("file" => "tcpdf" . DS . "tcpdf.php"));
		$this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->tcpdf->SetAuthor('Servicios de Televisión Canal del Fútbol Limitada');
		$this->tcpdf->setPrintHeader(false);
		$this->tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$this->tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$this->tcpdf->SetMargins(23, 20, 10, true);
		//$this->tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT,PDF_MARGIN_BOTTOM);
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
}
?>
