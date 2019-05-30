<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
class RatingProgramacionesController extends AppController {

	public function edit($id = null)
	{
		//$this->layout = "default_extendido";
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if(isset($id))
		{
			if($this->request->is(array('post','put')))
			{
				if ($this->RatingProgramacione->save($this->request->data)) {
					$this->loadModel("ActividadUsuario");
					$usuario = $this->Session->read("PerfilUsuario.idUsuario");
					$mensaje = 'Se modifica el registro "'.$this->request->data["RatingProgramacione"]["id"];
					$log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);					
					$this->ActividadUsuario->save($log);
					$this->Session->setFlash('El programa fue editado correctamente', 'msg_exito');
					return $this -> redirect(array('action' => 'edit'));
				} else {
					$this->Session->setFlash('El programa no fue editado', 'msg_fallo');
				}
			}
			$this->request->data = $this->RatingProgramacione->find('first', array('conditions'=>array('RatingProgramacione.id'=>$id)));
		}

		if(!empty($this->request->data["fecha"])) 
		{
			$fechaInicio = DateTime::createFromFormat('d/m/Y', $this->request->data["fecha"])->format('Y-m-d');
			$fechaFinal = new DateTime($fechaInicio);
			$fechaFinal->modify("+1 day");
			$fechaFinal->format("Y-m-d");
			$conditions = array('RatingProgramacione.inicio BETWEEN ? and ?'=> array($fechaInicio.' 06:00:00', $fechaFinal->format("Y-m-d").' 05:59:59'));
			$this->RatingProgramacione->Behaviors->load('Containable');
			$programacionesQuery = $this->RatingProgramacione->find("all", array('conditions'=> $conditions,
				'contain' => array('RatingProgramacionesDetalle'=> array('order'=>'RatingProgramacionesDetalle.canal ASC')),
				'order' => 'RatingProgramacione.inicio ASC'
				));
			if(empty($programacionesQuery))
			{
				$this->Session->setFlash('No se ha ingresado la programacion del día solicitado, debe solicitar el ingreso', 'msg_fallo');
				return $this->redirect(array("controller" => 'rating_programaciones', "action" => 'diario'));
			}
			foreach($programacionesQuery as $programacionesArray) 
			{
				$programaciones[$programacionesArray["RatingProgramacione"]["canal_base"]][] = $programacionesArray;
			}
			$this->set("programaciones", $programaciones);
			$this->set("fecha", $this->request->data["fecha"]);
		}
	}

	public function programa()
	{
		$this->layout = "default_extendido";
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if($this->request->is(array('post', 'put')))
		{
			ini_set('max_execution_time', 300);
			ini_set('memory_limit', '-1');
			$conditions ="";
			if(!empty($this->request->data["programa"])) 
			{
				$conditions[] = array('RatingProgramacione.programa LIKE'=> '%'.$this->request->data["programa"].'%');
			}
			if(!empty($this->request->data["fechaInicio"]) && empty($this->request->data["fechaFinal"]))
			{
				$fechaInicio = DateTime::createFromFormat('d/m/Y', $this->request->data["fechaInicio"])->format('Y-m-d');
				$conditions[] = array('RatingProgramacione.inicio >='=> $fechaInicio.' 06:00:00');
			}
			if(!empty($this->request->data["fechaFinal"]) && empty($this->request->data["fechaInicio"]))
			{
				$fechaFinal = DateTime::createFromFormat('d/m/Y', $this->request->data["fechaFinal"])->format('Y-m-d');
				$fecha = new DateTime($fechaFinal);
				$fecha->modify("+1 day");
				$conditions[] = array('RatingProgramacione.inicio <='=> $fecha->format("Y-m-d").' 05:59:59');
			}

			if(!empty($this->request->data["fechaInicio"]) && !empty($this->request->data["fechaFinal"]))
			{
				$fechaInicio = DateTime::createFromFormat('d/m/Y', $this->request->data["fechaInicio"])->format('Y-m-d');
				$fechaFinal = DateTime::createFromFormat('d/m/Y', $this->request->data["fechaFinal"])->format('Y-m-d');
				$fecha = new DateTime($fechaFinal);
				$fecha->modify("+1 day");
				$conditions[] = array('RatingProgramacione.inicio BETWEEN ? and ?'=> array($fechaInicio.' 06:00:00', $fecha->format("Y-m-d").' 05:59:59'));
			}
			if(!empty($this->request->data["señal"])) 
			{
				$señales["canal_base"] = array();
				foreach ($this->request->data["señal"] as $señal) 
				{
					array_push($señales["canal_base"], $señal);
				}
				$conditions[] = $señales;
			}
			$this->RatingProgramacione->Behaviors->load('Containable');
			$programaciones = $this->RatingProgramacione->find("all", array('conditions'=> array($conditions),
				'contain' => array('RatingProgramacionesDetalle'=> array('order'=>'RatingProgramacionesDetalle.canal ASC')),
				'order' => array('RatingProgramacione.inicio ASC')
				));
			if(empty($programaciones))
			{
				$this->Session->setFlash('No se encontro informacion con los parametros indicados', 'msg_fallo');
				return $this->redirect(array("controller" => 'rating_programaciones', "action" => "programa"));
			}
			$this->set("programaciones", $programaciones);
			$this->set("mostrarPrograma", $this->request->data["programa"]);
			$this->set("inicio", $this->request->data["fechaInicio"]);
			$this->set("final", $this->request->data["fechaFinal"]);
		}
		$programasQuery = $this->RatingProgramacione->find('all', array('fields'=>array('DISTINCT RatingProgramacione.programa'), 'recursive'=>0, 'order'=>'RatingProgramacione.programa ASC'));
		if(empty($programasQuery))
		{
			$this->Session->setFlash('No hay programacion ingresada por favor solicite el ingreso', 'msg_fallo');
			return $this->redirect(array("controller" => 'dashboards', "action" => "index"));
		}
		foreach ($programasQuery as $programasArray) 
		{
			$programas[$programasArray["RatingProgramacione"]["programa"]] = $programasArray["RatingProgramacione"]["programa"];
		}
		$programas = array(""=>"")+$programas;
		$this->set("programas",$programas);
	}
	public function upload()
	{
		
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		if ($this->Session->read('Users.flag') == 1) 
		{
			if ($this->request->is(array('post', 'put'))) 
			{
				
				if($this->params->form['uploadProgramaciones']['error']==0)
				{
					$Servicios = new ServiciosController;
					ini_set('memory_limit', '-1');
					ini_set('max_execution_time', 300);
					$this->loadModel("RatingProgramacionesDetalle");
					$i=0;
					$fila = 0;
					if(($gestor = fopen($this->params->form['uploadProgramaciones']['tmp_name'], "r")) !== FALSE) {
					$canalBase = "";
					while(!feof($gestor))
					{
					  	$datos[] = fgetcsv($gestor, 0, ";",'"');
					}
					fclose($gestor);
					foreach($datos as $key => $programacion) 
					{
						if($key>=9)
					  	{	
					  		if($programacion[0]!="")
					  		{
					  			if(!strstr($programacion[1], '*') && $programacion[5]!="")
					  			{
					  				$fecha = explode("/", $programacion[12]);

					  				$fechaInicio = new DateTime($fecha[2]."-".$fecha[1]."-".$fecha[0]);
					  				$fechaFinal = new DateTime($fecha[2]."-".$fecha[1]."-".$fecha[0]);
					  				$inicio = date('H:i:s',  strtotime($programacion[9]));
									$final = date('H:i:s',  strtotime($programacion[10]));

					  				if($inicio>=date('H:i:s', mktime(0,0,0)) && $inicio<date('H:i:s', mktime(6,0,0)))
					  				{
					  					$fechaInicio->modify('+1 day');
					  				}
					  				if($inicio != $final)
					  				{
					  					if($final>=date('H:i:s', mktime(0,0,0)) && $final<=date('H:i:s', mktime(6,0,0)))
						  				{
						  					$fechaFinal->modify('+1 day');
						  				}	
					  				}
					  				
					  				$programa = $this->RatingProgramacione->find('all', array('conditions'=>array('RatingProgramacione.programa'=>utf8_encode($programacion[5]),'RatingProgramacione.inicio'=>$fechaInicio->format("Y-m-d").' '.$inicio, 'RatingProgramacione.final'=>$fechaFinal->format("Y-m-d").' '.$final)));
					  				if(empty($programa))
					  				{

					  					$canal = $Servicios->get_canal(utf8_encode($programacion[3]));
					  					$insert[]["RatingProgramacione"] = array('grupo'=>utf8_encode($programacion[1]),'canal_base'=>$canal,'programa'=>utf8_encode($programacion[5]),'tema'=>utf8_encode($programacion[6]), 'genero'=>utf8_encode($programacion[7]), 'subgenero'=>utf8_encode($programacion[8]), 'inicio'=>$fechaInicio->format("Y-m-d").' '.$inicio,'final'=>$fechaFinal->format("Y-m-d").' '.$final); 
						 				$share = str_replace(',','.',$programacion[14]);
						 				if(!is_numeric($share))
						 				{
							 				$share = 0;
						 				}
						 				$rating = str_replace(',','.',$programacion[13]);
						 				if(!is_numeric($share))
						 				{
							 				$rating = 0;
						 				}
						 				$insert[$i]["RatingProgramacionesDetalle"][] = array('canal'=>utf8_encode($canal),'rating'=>$rating,'share'=>$share);
						 				foreach($datos as $k => $programacionDetalle) 
										{
										  	if($k>=9)
										  	{
										  		if($programacionDetalle[0]!="")
										  		{
										  			if(strstr($programacionDetalle[1], '*') && $programacionDetalle[5]!="")
										  			{
										  				if($programacion[5] == substr($programacionDetalle[5], 0, -1) && $programacion[12] == $programacionDetalle[12] && $programacion[9] == $programacionDetalle[9] && $programacion[10] == $programacionDetalle[10])
										  				{	
										  					$share = str_replace(',','.',$programacionDetalle[14]);
											 				if(!is_numeric($share))
											 				{
												 				$share = 0;
											 				}
											 				$rating = str_replace(',','.',$programacionDetalle[13]);
											 				if(!is_numeric($share))
											 				{
												 				$rating = 0;
											 				}
										  					$canal = $Servicios->get_canal(utf8_encode($programacionDetalle[3]));
										  					$insert[$i]["RatingProgramacionesDetalle"][] = array('canal'=>utf8_encode($canal),'rating'=>str_replace(',','.',$programacionDetalle[13]),'share'=>$share);
										  				}
										  			}	
										  		}			  		
										  	}

										}
									$i++;	
					  				}				
					  			}	
					  		}
					  	}
					}
					if(!empty($insert))
					{
						$this->RatingProgramacione->saveAll($insert, array('deep' => true)); 
					}
					$this->Session->setFlash('Documento ingresado correctamente', 'msg_exito');
					return $this->redirect(array("controller" => 'rating_programaciones', "action" => 'upload'));
				}
			}
			} 

		} else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
	}
	public function diario()
	{
		$this->layout = "default_extendido";
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		if($this->request->is(array('post', 'put')))
		{
			ini_set('memory_limit', '-1');
			$this->loadModel("RatingMinuto");
			if(!empty($this->request->data["fecha"])) 
			{
				$fechaInicio = DateTime::createFromFormat('d/m/Y', $this->request->data["fecha"])->format('Y-m-d');
				$fechaFinal = new DateTime($fechaInicio);
				$fechaFinal->modify("+1 day");
				$fechaFinal->format("Y-m-d");
				$this->RatingProgramacione->Behaviors->load('Containable');
				$programacionesQuery = $this->RatingProgramacione->find("all", array('conditions'=> array('RatingProgramacione.inicio BETWEEN ? and ?'=> array($fechaInicio.' 06:00:00', $fechaFinal->format("Y-m-d").' 05:59:59')),
					'contain' => array('RatingProgramacionesDetalle'=> array('order'=>'RatingProgramacionesDetalle.canal ASC')),
					'order' => 'RatingProgramacione.inicio ASC'
					));
				if(empty($programacionesQuery))
				{
					$this->Session->setFlash('No se ha ingresado la programacion del día solicitado, debe solicitar el ingreso', 'msg_fallo');
					return $this->redirect(array("controller" => 'rating_programaciones', "action" => 'diario'));
				}
				foreach($programacionesQuery as $programacionesArray) 
				{
					$programaciones[$programacionesArray["RatingProgramacione"]["canal_base"]][] = $programacionesArray;
				}
				$totalesQuery = $this->RatingMinuto->find("all", array('conditions'=>array('RatingMinuto.minuto BETWEEN ? and ?'=>array($fechaInicio.' 10:00:00', $fechaFinal->format('Y-m-d').' 01:59:59')), 'order'=>'RatingMinuto.minuto ASC'));
				if(empty($totalesQuery))
				{
					$this->Session->setFlash('No se ha ingresado el minuto a minuto del dia solicitado, debe solicitar el ingreso', 'msg_fallo');
					return $this->redirect(array("controller" => 'rating_programaciones', "action" => 'diario'));
				}
				foreach ($totalesQuery as $key => $totalesProgramaciones) 
				{
					$cdfb = unserialize($totalesProgramaciones["RatingMinuto"]["cdfb"]);
					$cdfp = unserialize($totalesProgramaciones["RatingMinuto"]["cdfp"]);
					$cdfhd = unserialize($totalesProgramaciones["RatingMinuto"]["cdfhd"]);
					$espn = unserialize($totalesProgramaciones["RatingMinuto"]["espn"]);
					$espnm = unserialize($totalesProgramaciones["RatingMinuto"]["espnm"]);
					$espn2 = unserialize($totalesProgramaciones["RatingMinuto"]["espn2"]);
					$espn3 = unserialize($totalesProgramaciones["RatingMinuto"]["espn3"]);
					$espnhd = unserialize($totalesProgramaciones["RatingMinuto"]["espnhd"]);
					$fs = unserialize($totalesProgramaciones["RatingMinuto"]["fs"]);
					$fsp = unserialize($totalesProgramaciones["RatingMinuto"]["fsp"]);
					$fs2 = unserialize($totalesProgramaciones["RatingMinuto"]["fs2"]);
					$fs3 = unserialize($totalesProgramaciones["RatingMinuto"]["fs3"]);
					$totalesRating["cdfb"]["rating"][] = $cdfb["rat"];
					$totalesRating["cdfb"]["share"][] = $cdfb["shr"];
					$totalesRating["cdfp"]["rating"][] = $cdfp["rat"];
					$totalesRating["cdfp"]["share"][] = $cdfp["shr"];
					$totalesRating["cdfhd"]["rating"][] = $cdfhd["rat"];
					$totalesRating["cdfhd"]["share"][] = $cdfhd["shr"];
					$totalesRating["espn"]["rating"][] = $espn["rat"];
					$totalesRating["espn"]["share"][] = $espn["shr"];
					$totalesRating["espnm"]["rating"][] = $espnm["rat"];
					$totalesRating["espnm"]["share"][] = $espnm["shr"];
					$totalesRating["espn2"]["rating"][] = $espn2["rat"];
					$totalesRating["espn2"]["share"][] = $espn2["shr"];
					$totalesRating["espn3"]["rating"][] = $espn3["rat"];
					$totalesRating["espn3"]["share"][] = $espn3["shr"];
					$totalesRating["espnhd"]["rating"][] = $espnhd["rat"];
					$totalesRating["espnhd"]["share"][] = $espnhd["shr"];
					$totalesRating["fs"]["rating"][] = $fs["rat"];
					$totalesRating["fs"]["share"][] = $fs["shr"];
					$totalesRating["fsp"]["rating"][] = $fsp["rat"];
					$totalesRating["fsp"]["share"][] = $fsp["shr"];
					$totalesRating["fs2"]["rating"][] = $fs2["rat"];
					$totalesRating["fs2"]["share"][] = $fs2["shr"];
					$totalesRating["fs3"]["rating"][] = $fs3["rat"];
					$totalesRating["fs3"]["share"][] = $fs3["shr"];
				}
				$totales["cdfb"]["rating"] = number_format(array_sum($totalesRating["cdfb"]["rating"])/960, 3, ",", ".");
				$totales["cdfb"]["share"] = number_format(array_sum($totalesRating["cdfb"]["share"])/960, 3, ",", ".");
				$totales["cdfp"]["rating"] = number_format(array_sum($totalesRating["cdfp"]["rating"])/960, 3, ",", ".");
				$totales["cdfp"]["share"] = number_format(array_sum($totalesRating["cdfp"]["share"])/960, 3, ",", ".");
				$totales["cdfhd"]["rating"] = number_format(array_sum($totalesRating["cdfhd"]["rating"])/960, 3, ",", ".");
				$totales["cdfhd"]["share"] = number_format(array_sum($totalesRating["cdfhd"]["share"])/960, 3, ",", ".");
				$totales["espnm"]["rating"] = number_format(array_sum($totalesRating["espnm"]["rating"])/960, 3, ",", ".");
				$totales["espnm"]["share"] = number_format(array_sum($totalesRating["espnm"]["share"])/960, 3, ",", ".");
				$totales["espn2"]["rating"] = number_format(array_sum($totalesRating["espn2"]["rating"])/960, 3, ",", ".");
				$totales["espn2"]["share"] = number_format(array_sum($totalesRating["espn2"]["share"])/960, 3, ",", ".");
				$totales["espn3"]["rating"] = number_format(array_sum($totalesRating["espn3"]["rating"])/960, 3, ",", ".");
				$totales["espn3"]["share"] = number_format(array_sum($totalesRating["espn3"]["share"])/960, 3, ",", ".");
				$totales["espnhd"]["rating"] = number_format(array_sum($totalesRating["espnhd"]["rating"])/960, 3, ",", ".");
				$totales["espnhd"]["share"] = number_format(array_sum($totalesRating["espnhd"]["share"])/960, 3, ",", ".");
				$totales["fs"]["rating"] = number_format(array_sum($totalesRating["fs"]["rating"])/960, 3, ",", ".");
				$totales["fs"]["share"] = number_format(array_sum($totalesRating["fs"]["share"])/960, 3, ",", ".");
				$totales["fsp"]["rating"] = number_format(array_sum($totalesRating["fsp"]["rating"])/960, 3, ",", ".");
				$totales["fsp"]["share"] = number_format(array_sum($totalesRating["fsp"]["share"])/960, 3, ",", ".");
				$totales["fs2"]["rating"] = number_format(array_sum($totalesRating["fs2"]["rating"])/960, 3, ",", ".");
				$totales["fs2"]["share"] = number_format(array_sum($totalesRating["fs2"]["share"])/960, 3, ",", ".");
				$totales["fs3"]["rating"] = number_format(array_sum($totalesRating["fs3"]["rating"])/960, 3, ",", ".");
				$totales["fs3"]["share"] = number_format(array_sum($totalesRating["fs3"]["share"])/960, 3, ",", ".");
				$totales["espn"]["rating"] = number_format(array_sum($totalesRating["espn"]["rating"])/960, 3, ",", ".");
				$totales["espn"]["share"] = number_format(array_sum($totalesRating["espn"]["share"])/960, 3, ",", ".");
				$this->set("programaciones", $programaciones);
				$this->set("totales", $totales);
				$this->set("fecha", $this->request->data["fecha"]);
			}
		}
	}

	public function programa_minutos($accion, $id)
	{
		$this->layout = "default_extendido";
		ini_set('memory_limit', '-1');
		$this->loadModel("RatingMinuto");
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

		if(empty($id) && empty($accion))
		{
			$this->Session->setFlash('Parametros invalidos', 'msg_fallo');
			return $this -> redirect(array("controller" => 'dashboards', "action" => 'index'));
		}
		if(empty($id))
		{
			$this->Session->setFlash('Falta el identificador del programa', 'msg_fallo');
			return $this -> redirect(array("controller" => 'rating_programaciones', "action" => $accion));	
		}
		$this->RatingProgramacione->Behaviors->load('Containable');
		$programacion = $this->RatingProgramacione->find("first", array('conditions'=>array('RatingProgramacione.id'=>$id),
					'contain' => array('RatingProgramacionesDetalle'=> array('order'=>'RatingProgramacionesDetalle.canal ASC')),
					'order' => 'RatingProgramacione.inicio ASC'
					));
		if(empty($programacion))
		{
			$this->Session->setFlash('No se ha ingresado la programacion del día solicitado, debe solicitar el ingreso', 'msg_fallo');
			return $this->redirect(array("controller" => 'rating_programaciones', "action" => $accion));
		}
		$minutosQuery = $this->RatingMinuto->find('all', array('conditions'=>array('RatingMinuto.minuto BETWEEN ? and ?'=>array($programacion["RatingProgramacione"]["inicio"], $programacion["RatingProgramacione"]["final"])), 'order'=>'RatingMinuto.minuto ASC'));
		if(empty($minutosQuery))
		{
			$this->Session->setFlash('No se ha ingresado el minuto a minuto del dia solicitado, debe solicitar el ingreso', 'msg_fallo');
			return $this->redirect(array("controller" => 'rating_programaciones', "action" => $accion));
		}
		foreach ($minutosQuery as $key => $minutosArray) 
		{
			$cdfb = unserialize($minutosArray["RatingMinuto"]["cdfb"]);
			$cdfp = unserialize($minutosArray["RatingMinuto"]["cdfp"]);
			$cdfhd = unserialize($minutosArray["RatingMinuto"]["cdfhd"]);
			$espn = unserialize($minutosArray["RatingMinuto"]["espn"]);
			$espnm = unserialize($minutosArray["RatingMinuto"]["espnm"]);
			$espn2 = unserialize($minutosArray["RatingMinuto"]["espn2"]);
			$espn3 = unserialize($minutosArray["RatingMinuto"]["espn3"]);
			$espnhd = unserialize($minutosArray["RatingMinuto"]["espnhd"]);
			$fs = unserialize($minutosArray["RatingMinuto"]["fs"]);
			$fsp = unserialize($minutosArray["RatingMinuto"]["fsp"]);
			$fs2 = unserialize($minutosArray["RatingMinuto"]["fs2"]);
			$fs3 = unserialize($minutosArray["RatingMinuto"]["fs3"]);

			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["cdfb"] =array($cdfb["rat"],$cdfb["shr"]);
			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["cdfp"] = array($cdfp["rat"],$cdfp["shr"]);
			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["cdfhd"] = array($cdfhd["rat"],$cdfhd["shr"]);
			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["espn"] = array($espn["rat"],$espn["shr"]);
			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["espnm"] = array($espnm["rat"],$espnm["shr"]);
			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["espn2"] = array($espn2["rat"],$espn2["shr"]);
			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["espn3"] = array($espn3["rat"],$espn3["shr"]);
			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["espnhd"] = array($espnhd["rat"],$espnhd["shr"]);
			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["fs"] = array($fs["rat"],$fs["shr"]);
			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["fsp"] = array($fsp["rat"],$fsp["shr"]);
			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["fs2"] = array($fs2["rat"],$fs2["shr"]);
			$minutos[$minutosArray["RatingMinuto"]["minuto"]]["fs3"] = array($fs3["rat"],$fs3["shr"]);
		}
		$this->set("programacion", $programacion);
		$this->set("minutos", $minutos);
	}
}
