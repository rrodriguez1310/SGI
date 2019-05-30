<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class RatingMinutosController extends AppController {
	public $components = array('RequestHandler');

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
				//pr($this->params);exit;
				//pr(count($this->params->form['uploadMinutos']['error']));exit;
			
				if($this->params->form['uploadMinutos']['error']==0)
				{
					$Servicios = new ServiciosController;
					ini_set('memory_limit', '-1');
					ini_set('max_execution_time', 300);
					$this->loadModel("RatingMinutosDetalle");
					$tipo = "";
					$minutosInsert = "";
					if(($gestor = fopen($this->params->form['uploadMinutos']['tmp_name'], "r")) !== FALSE) 
					{
						$canalBase = "";
						while(!feof($gestor))
						{
						  	$datos[] = fgetcsv($gestor, 0, ";",'"');
						}
						fclose($gestor);
						//pr($datos);exit;
						foreach($datos as $key => $minutos) 
						{								
							if($key>=11)
						  	{
						  		if($minutos[0]=="")
						  		{
						  			break;
						  		}
						  		if(!empty($minutos[1]) && $minutos[2]=="")
								{	
									$fechas = date('Y-m-d',strtotime(str_replace("/", "-", $minutos[1])));
								}else
								{
									$fechaMod = new DateTime($fechas);
									$minuto = date('H:i:s',  strtotime(substr($minutos[1], 1,5)));
									if($minuto>=date('H:i:s', mktime(0,0,0)) && $minuto<date('H:i:s', mktime(6,0,0)))
					  				{
					  					$fechaMod->modify('+1 day');
					  				}
									$prueba[] = $fechaMod->format('Y-m-d')." ".$minuto;
								}
						  	}	
						}
						//pr($prueba);exit; 
						$comprobarQuery = $this->RatingMinuto->find('all', array('conditions'=>array('RatingMinuto.minuto'=>$prueba), 'fields'=>array('RatingMinuto.minuto')));
						foreach ($comprobarQuery as $comprobar) 
						{
							//pr($value);exit;
							$comprobarArray[$comprobar["RatingMinuto"]["minuto"]] = "comprobar";
						}
						//pr($comprobarArray);
						//exit;
						foreach($datos as $key => $minutos) 
						{								
							if($key>=11)
						  	{
						  		if($minutos[0]=="")
						  		{
						  			break;
						  		}
						  		if(!empty($minutos[1]) && $minutos[2]=="")
								{	
									$fecha = date('Y-m-d',strtotime(str_replace("/", "-", $minutos[1])));
								}
									
								if($minutos[2]!="")
								{
									$fechaMod = new DateTime($fecha);
					  				$minuto = date('H:i:s',  strtotime(substr($minutos[1], 1,5)));
					  				if($minuto>=date('H:i:s', mktime(0,0,0)) && $minuto<date('H:i:s', mktime(6,0,0)))
					  				{
					  					$fechaMod->modify('+1 day');
					  				}
					  				//$comprobar = $this->RatingMinuto->find('first', array('conditions'=>array('RatingMinuto.minuto'=>$fecha->format('Y-m-d')." ".$minuto), 'fields'=>array('RatingMinuto.id')));
					  				//pr($comprobar);exit;
					  				if(empty($comprobarArray))
					  				{
						  				foreach($minutos as $k => $minutoDetalle) 
						  				{
						  					if($datos[9][$k]!="")
						  					{							  						
						  						$tipo = substr($datos[9][$k], 0, -1);	
						  					}
						  					if($k>=2)
						  					{
						  						$canal = $Servicios->get_canal(utf8_encode($datos[10][$k]));
							  					$minutosInsertDetalle[$canal][$tipo] = str_replace(',','.',$minutoDetalle);			  					
						  					}
						  				}
						  				$canalDelFutbol = serialize($minutosInsertDetalle["CDFB"]);
						  				$canalDelFutbolPre = serialize($minutosInsertDetalle["CDFP"]);
						  				$cdfHd = serialize($minutosInsertDetalle["CDFHD"]);
						  				$espn = serialize($minutosInsertDetalle["ESPN"]);
										$espnMas = serialize($minutosInsertDetalle["ESPNM"]);
										$espn2 = serialize($minutosInsertDetalle["ESPN2"]);
						  				$espn3 = serialize($minutosInsertDetalle["ESPN3"]);
						  				$espnHd = serialize($minutosInsertDetalle["ESPNHD"]);
						  				$foxSports = serialize($minutosInsertDetalle["FS"]);
						  				$foxSportPremium = serialize($minutosInsertDetalle["FSP"]);
						  				$foxSports2 = serialize($minutosInsertDetalle["FS2"]);
						  				$foxSports3 = serialize($minutosInsertDetalle["FS3"]);
						  				//$fechaF = $fecha->format('Y-m-d')." ".$minuto;
						  				$minutosInsert[]["RatingMinuto"] = array('minuto'=>$fechaMod->format('Y-m-d')." ".$minuto, 'cdfb'=>$canalDelFutbol, 'cdfp'=>$canalDelFutbolPre, 'cdfhd'=>$cdfHd, 'espn'=>$espn, 'espnm'=>$espnMas, 'espn2'=>$espn2, 'espn3'=>$espn3, 'espnhd'=>$espnHd, 'fs'=>$foxSports, 'fsp'=>$foxSportPremium, 'fs2'=>$foxSports2, 'fs3'=>$foxSports3);
							  		}else
							  			foreach($minutos as $k => $minutoDetalle) 
						  				{
						  					if($datos[9][$k]!="")
						  					{							  						
						  						$tipo = substr($datos[9][$k], 0, -1);	
						  					}
						  					if($k>=2)
						  					{
						  						$canal = $Servicios->get_canal(utf8_encode($datos[10][$k]));
							  					$minutosInsertDetalle[$canal][$tipo] = str_replace(',','.',$minutoDetalle);			  					
						  					}
						  				}
						  				$canalDelFutbol = serialize($minutosInsertDetalle["CDFB"]);
						  				$canalDelFutbolPre = serialize($minutosInsertDetalle["CDFP"]);
						  				$cdfHd = serialize($minutosInsertDetalle["CDFHD"]);
						  				$espn = serialize($minutosInsertDetalle["ESPN"]);
										$espnMas = serialize($minutosInsertDetalle["ESPNM"]);
										$espn2 = serialize($minutosInsertDetalle["ESPN2"]);
						  				$espn3 = serialize($minutosInsertDetalle["ESPN3"]);
						  				$espnHd = serialize($minutosInsertDetalle["ESPNHD"]);
						  				$foxSports = serialize($minutosInsertDetalle["FS"]);
						  				$foxSportPremium = serialize($minutosInsertDetalle["FSP"]);
						  				$foxSports2 = serialize($minutosInsertDetalle["FS2"]);
						  				$foxSports3 = serialize($minutosInsertDetalle["FS3"]);
						  				//$fechaF = $fecha->format('Y-m-d')." ".$minuto;
						  				$minutosInsertArray[$fechaMod->format('Y-m-d')." ".$minuto]["RatingMinuto"] = array('minuto'=>$fechaMod->format('Y-m-d')." ".$minuto, 'cdfb'=>$canalDelFutbol, 'cdfp'=>$canalDelFutbolPre, 'cdfhd'=>$cdfHd, 'espn'=>$espn, 'espnm'=>$espnMas, 'espn2'=>$espn2, 'espn3'=>$espn3, 'espnhd'=>$espnHd, 'fs'=>$foxSports, 'fsp'=>$foxSportPremium, 'fs2'=>$foxSports2, 'fs3'=>$foxSports3);
						  				//break;
							  	}
						  	}	
						}
						//pr($minutosInsertArray);exit;
						if(!empty($comprobarArray))
						{
							$minutosDiferenciasArray = array_diff_key($minutosInsertArray, $comprobarArray);
							if(!empty($minutosDiferenciasArray))
							{
								foreach ($minutosDiferenciasArray as $minutosDiferencias) 
								{
									$minutosInsert[] = $minutosDiferencias;
								}	
							}else
							{
								$this->Session->setFlash('Los registros ya estaban guardados', 'msg_fallo');
								return $this->redirect(array("controller" => 'rating_minutos', "action" => 'upload'));
							}
						}						
						if(!empty($minutosInsert)) 
						{
							$this->RatingMinuto->saveAll($minutosInsert);
							$this->Session->setFlash('Documento ingresado correctamente', 'msg_exito');
						}
					}
				}
			} 

		} else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
	}

	public function rating_semana($fecha){

		$this->autoRender = false;
		if($this->Session->read('Users.flag') != 1){
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		$fechaInicial = new DateTime($fecha);
		$fechaInicial->modify("+6 hour");
		$fechaFinal = new DateTime($fecha);
		$fechaFinal->modify("+7 day +5 hour +59 minute +59 second");
		$semana = $this->RatingMinuto->find("all", array(
			"conditions"=>array(
				"RatingMinuto.minuto BETWEEN ? and ?"=>array(
					$fechaInicial->format("Y-m-d H:i:s"),
					$fechaFinal->format("Y-m-d H:i:s")
					)
				)
			)
		);
		return $semana;
	}

	public function rating_semana_promedios_bandas(){
		$this->autoRender = false;
		if($this->Session->read('Users.flag') != 1){
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		ini_set('memory_limit', '-1');
		
		$semanaData = $this->rating_semana($this->request->query["fecha"]);
		if(!empty($semanaData)){

			foreach ($semanaData as $key => $totalesProgramaciones)
			{
				$banda = substr($totalesProgramaciones["RatingMinuto"]["minuto"], 11, 2);
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
				$totalesRating[$banda]["cdfb"]["rating"][] = $cdfb["rat"];
				$totalesRating[$banda]["cdfb"]["tvr"][] = $cdfb["tvr"];
				$totalesRating[$banda]["cdfp"]["rating"][] = $cdfp["rat"];
				$totalesRating[$banda]["cdfp"]["tvr"][] = $cdfp["tvr"];
				$totalesRating[$banda]["cdfhd"]["rating"][] = $cdfhd["rat"];
				$totalesRating[$banda]["cdfhd"]["tvr"][] = $cdfhd["tvr"];
				$totalesRating[$banda]["espn"]["rating"][] = $espn["rat"];
				$totalesRating[$banda]["espn"]["tvr"][] = $espn["tvr"];
				$totalesRating[$banda]["espnm"]["rating"][] = $espnm["rat"];
				$totalesRating[$banda]["espnm"]["tvr"][] = $espnm["tvr"];
				$totalesRating[$banda]["espn2"]["rating"][] = $espn2["rat"];
				$totalesRating[$banda]["espn2"]["tvr"][] = $espn2["tvr"];
				$totalesRating[$banda]["espn3"]["rating"][] = $espn3["rat"];
				$totalesRating[$banda]["espn3"]["tvr"][] = $espn3["tvr"];
				$totalesRating[$banda]["espnhd"]["rating"][] = $espnhd["rat"];
				$totalesRating[$banda]["espnhd"]["tvr"][] = $espnhd["tvr"];
				$totalesRating[$banda]["fs"]["rating"][] = $fs["rat"];
				$totalesRating[$banda]["fs"]["tvr"][] = $fs["tvr"];
				$totalesRating[$banda]["fsp"]["rating"][] = $fsp["rat"];
				$totalesRating[$banda]["fsp"]["tvr"][] = $fsp["tvr"];
				$totalesRating[$banda]["fs2"]["rating"][] = $fs2["rat"];
				$totalesRating[$banda]["fs2"]["tvr"][] = $fs2["tvr"];
				$totalesRating[$banda]["fs3"]["rating"][] = $fs3["rat"];
				$totalesRating[$banda]["fs3"]["tvr"][] = $fs3["tvr"];
			}
			foreach ($totalesRating as $key => $value) {
				
				$totales[$key]["cdfb"]["rating"] = number_format(array_sum($totalesRating[$key]["cdfb"]["rating"])/420, 3, ",", ".");
				$totales[$key]["cdfb"]["tvr"] = number_format(array_sum($totalesRating[$key]["cdfb"]["tvr"])/420, 3, ",", ".");
				$totales[$key]["cdfp"]["rating"] = number_format(array_sum($totalesRating[$key]["cdfp"]["rating"])/420, 3, ",", ".");
				$totales[$key]["cdfp"]["tvr"] = number_format(array_sum($totalesRating[$key]["cdfp"]["tvr"])/420, 3, ",", ".");
				$totales[$key]["cdfhd"]["rating"] = number_format(array_sum($totalesRating[$key]["cdfhd"]["rating"])/420, 3, ",", ".");
				$totales[$key]["cdfhd"]["tvr"] = number_format(array_sum($totalesRating[$key]["cdfhd"]["tvr"])/420, 3, ",", ".");
				$totales[$key]["espnm"]["rating"] = number_format(array_sum($totalesRating[$key]["espnm"]["rating"])/420, 3, ",", ".");
				$totales[$key]["espnm"]["tvr"] = number_format(array_sum($totalesRating[$key]["espnm"]["tvr"])/420, 3, ",", ".");
				$totales[$key]["espn2"]["rating"] = number_format(array_sum($totalesRating[$key]["espn2"]["rating"])/420, 3, ",", ".");
				$totales[$key]["espn2"]["tvr"] = number_format(array_sum($totalesRating[$key]["espn2"]["tvr"])/420, 3, ",", ".");
				$totales[$key]["espn3"]["rating"] = number_format(array_sum($totalesRating[$key]["espn3"]["rating"])/420, 3, ",", ".");
				$totales[$key]["espn3"]["tvr"] = number_format(array_sum($totalesRating[$key]["espn3"]["tvr"])/420, 3, ",", ".");
				$totales[$key]["espnhd"]["rating"] = number_format(array_sum($totalesRating[$key]["espnhd"]["rating"])/420, 3, ",", ".");
				$totales[$key]["espnhd"]["tvr"] = number_format(array_sum($totalesRating[$key]["espnhd"]["tvr"])/420, 3, ",", ".");
				$totales[$key]["fs"]["rating"] = number_format(array_sum($totalesRating[$key]["fs"]["rating"])/420, 3, ",", ".");
				$totales[$key]["fs"]["tvr"] = number_format(array_sum($totalesRating[$key]["fs"]["tvr"])/420, 3, ",", ".");
				$totales[$key]["fsp"]["rating"] = number_format(array_sum($totalesRating[$key]["fsp"]["rating"])/420, 3, ",", ".");
				$totales[$key]["fsp"]["tvr"] = number_format(array_sum($totalesRating[$key]["fsp"]["tvr"])/420, 3, ",", ".");
				$totales[$key]["fs2"]["rating"] = number_format(array_sum($totalesRating[$key]["fs2"]["rating"])/420, 3, ",", ".");
				$totales[$key]["fs2"]["tvr"] = number_format(array_sum($totalesRating[$key]["fs2"]["tvr"])/420, 3, ",", ".");
				$totales[$key]["fs3"]["rating"] = number_format(array_sum($totalesRating[$key]["fs3"]["rating"])/420, 3, ",", ".");
				$totales[$key]["fs3"]["tvr"] = number_format(array_sum($totalesRating[$key]["fs3"]["tvr"])/420, 3, ",", ".");
				$totales[$key]["espn"]["rating"] = number_format(array_sum($totalesRating[$key]["espn"]["rating"])/420, 3, ",", ".");
				$totales[$key]["espn"]["tvr"] = number_format(array_sum($totalesRating[$key]["espn"]["tvr"])/420, 3, ",", ".");
			}
		}
		return json_encode($totales);
	}

	public function minuto_a_minuto() {

		$this->set("layoutContent", "container-fluid");
		$this->layout= "angular";
		if($this->Session->Read("Users.flag") != 0){			
			if($this->Session->Read("Accesos.accesoPagina") == 0){
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
	}

	public function bandas(){
		//$this->set("layoutContent", "container-fluid");
		$this->layout = "angular";
		if($this->Session->Read("Users.flag") != 0){			
			if($this->Session->Read("Accesos.accesoPagina") == 0){
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}

	}

	public function carga_data_webservice_bandas($fechaSolicitada){

		ini_set('max_execution_time', 300);
		$this->loadModel("Channel");
		$this->loadModel("Target");
		$insert = "";
		$channels = $this->Channel->find("all", array("recursive"=>-1));
		foreach ($channels as $channel) {
			if(!empty($channel["Channel"]["codigo"])){
				$canales[$channel["Channel"]["codigo"]] = $channel["Channel"]["id"];	
			}
		}
		$targets = $this->Target->find("all", array("recursive"=>-1));
		foreach ($targets as $target) {
			if(!empty($target["Target"]["codigo"])){
				$objetivos[$target["Target"]["codigo"]] = $target["Target"]["id"];	
			}
		}
		$fechaValidacionFinal = new DateTime($fechaSolicitada);
		$fechaValidacionFinal->modify("+1 day");
		$validacion = array();
		$validaDiaQuery = $this->RatingMinuto->find("all", array("conditions"=>array("RatingMinuto.fecha BETWEEN ? and ?"=>array($fechaSolicitada." 06:00:00", $fechaValidacionFinal->format("Y-m-d")." 05:59:59"))));
		if(!empty($validaDiaQuery)){
			foreach ($validaDiaQuery as $validaDia) {
				$validacion[$validaDia["RatingMinuto"]["target_id"]][$validaDia["RatingMinuto"]["channels_id"]] = $validaDia;
			}	
		}		
		$client = new SoapClient("http://192.168.1.227/WsTvData/WSLoadTvCdf.asmx?WSDL");
		
		$respuestaObj = $client->GetRankingXML(array(
			'dtEvaluation'=>$fechaSolicitada,
            'iTypeAnalysis'=>1,
            //'strChannels'=>"145,364,158,31,345,111,367,37,157,156,65536,65537,652,337",
            'strChannels'=>"145,364,158,31,111,367,37,157,156,65536,65537,652,337",  //agregar canales al inicio del listado
            'iChannelBase'=>65536,
            'strTargets'=>'65536',
            'iNumberOfDecimal'=>3,
            'iChannelProgramming'=>0,
            'authorization'=>'3VohgUMx7aLU80KsAhUPVz8mpiba6rJyYS1XNQYP72RosQQ8w+BO6aRy/Z+R4PiL'
			)
		);
		
		$respuestaXml = simplexml_load_string($respuestaObj->GetRankingXMLResult->any);
		if(isset($respuestaXml->Target)){
			$fechaStr = (string)$respuestaXml->Fecha;
			foreach ($respuestaXml->Target as $targets) {			
				$codigoTarget = (int)$targets->codigo;
				foreach ($targets->BandsEvaluator->Banda as $bandas) {
					$banda = (string)$bandas->nombre;
					foreach ($bandas->Canal as $datos) {
						if(!isset($validacion[$objetivos[(int)$codigoTarget]][$canales[(int)$datos->codigo]])){
							$fecha = new DateTime(date('Y-m-d',strtotime($fechaStr)));
			  				$minuto = date('H:i:s',  strtotime($banda));
			  				if($minuto>=date('H:i:s', mktime(0,0,0)) && $minuto<date('H:i:s', mktime(6,0,0)))
			  				{
			  					$fecha->modify('+1 day');
			  				}
			  				$share = str_replace(",", ".", (string)$datos->shr);
			  				if($share < 0){
			  					$share = "0.000";
			  				}
							$insert["bandas"][]["RatingMinuto"] = array(
								"fecha"=>$fecha->format("Y-m-d")." ".$banda.":00",
								"rating"=>str_replace(",", ".", (string)$datos->rat),
								"share"=>$share,
								"tvr"=>str_replace(",", ".", (string)$datos->tvr),
								"channels_id"=> $canales[(int)$datos->codigo],
								"target_id"=> $objetivos[(int)$codigoTarget],
								"estado"=>1
							);
							if((strtotime($minuto) >= strtotime("07:00:00") && strtotime($minuto) <= strtotime("23:59:00")) || (strtotime($minuto) >= strtotime("00:00:00") && strtotime($minuto) <= strtotime("01:59:00"))){
								$rankingAcumulado[$objetivos[(int)$codigoTarget]][$canales[(int)$datos->codigo]][1]["rating"][] = str_replace(",", ".", (string)$datos->rat);
								$rankingAcumulado[$objetivos[(int)$codigoTarget]][$canales[(int)$datos->codigo]][1]["share"][] = $share;
								$rankingAcumulado[$objetivos[(int)$codigoTarget]][$canales[(int)$datos->codigo]][1]["tvr"][] = str_replace(",", ".", (string)$datos->tvr);	
							}else{
								$rankingAcumulado[$objetivos[(int)$codigoTarget]][$canales[(int)$datos->codigo]][2]["rating"][] = str_replace(",", ".", (string)$datos->rat);
								$rankingAcumulado[$objetivos[(int)$codigoTarget]][$canales[(int)$datos->codigo]][2]["share"][] = $share;
								$rankingAcumulado[$objetivos[(int)$codigoTarget]][$canales[(int)$datos->codigo]][2]["tvr"][] = str_replace(",", ".", (string)$datos->tvr);
							}	
						}else{
							$insert["registrados"][$objetivos[(int)$codigoTarget]][$canales[(int)$datos->codigo]][] = $banda;
						}
					}				
				}
			}
			if(isset($rankingAcumulado)){
				foreach ($rankingAcumulado as $target => $canales) {
					foreach ($canales as $canal => $tipos) {
						foreach ($tipos as $tipo => $rating) {
							$insert["acumulado"][]["RatingMinutosAcumulado"] = array(
								"fecha"=>$fechaSolicitada." 00:00:00",
								"rating"=>array_sum($rating["rating"])/count($rating["rating"]),
								"share"=>array_sum($rating["share"])/count($rating["share"]),
								"tvr"=>array_sum($rating["tvr"])/count($rating["tvr"]),
								"tipo"=>$tipo,
								"estado"=>1,
								"channels_id"=> $canal,
								"target_id"=> $target,
								"count"=>count($rating["rating"])
							);
						}
						
					}
				}
			}
		}else{			
			$insert["error"] = current($respuestaXml);
		}
		return $insert;
	}

	public function minutos_x_rango($fechaInicio, $fechaFinal, $target){
		ini_set('memory_limit', '-1');
		$this->loadModel("Target");
		$target = $this->Target->find("first", array("conditions"=>array("Target.codigo"=>65536), "recursive"=>0));
		
		$minutosQuery = $this->RatingMinuto->find("all", array(
			"conditions"=>array(
				"RatingMinuto.fecha BETWEEN ? and ?"=>array(
					$fechaInicio,
					$fechaFinal
					),
				"RatingMinuto.target_id"=>$target["Target"]["id"]
				),
			"order"=>"RatingMinuto.fecha ASC",
			"fields"=>array(
				"RatingMinuto.fecha",
				"RatingMinuto.rating",
				"RatingMinuto.tvr",
				"RatingMinuto.channels_id",
				"RatingMinuto.target_id"
				),
			"recursive"=>-1
			)
		);
		return $minutosQuery;
	}

	public function minutos_x_rango_bandas_horas(){
		
		$this->autoRender = false;
		$minutosQuery = $this->minutos_x_rango($this->request->query["inicio"], $this->request->query["final"], 65536);
		
		if(!empty($minutosQuery)){
			foreach ($minutosQuery as $minuto) {
				$fecha = substr($minuto["RatingMinuto"]["fecha"], 0,13);
				$minutos[$fecha][$minuto["RatingMinuto"]["channels_id"]]["rating"][] = $minuto["RatingMinuto"]["rating"];
				$minutos[$fecha][$minuto["RatingMinuto"]["channels_id"]]["tvr"][] = $minuto["RatingMinuto"]["tvr"];
			}
			foreach ($minutos as $banda => $targets) {
				foreach ($targets as $target => $minuto) {
					$minutos[$banda][$target]["rating"] = array_sum($minuto["rating"]);
					$minutos[$banda][$target]["tvr"] = array_sum($minuto["tvr"]);
				}
			}
		}else{
			$minutos = 0;
		}

		return json_encode($minutos);
	}

	public function minutos_x_rango_minutos(){

		$this->layout = "ajax";
		$minutosQuery = $this->minutos_x_rango($this->request->query["inicio"], $this->request->query["final"], 65536);
		if(!empty($minutosQuery)){
			foreach ($minutosQuery as $minuto) {
				$fecha = $minuto["RatingMinuto"]["fecha"];
				if(isset($minutos[$fecha][$minuto["RatingMinuto"]["channels_id"]])){
					$minutos[$fecha][$minuto["RatingMinuto"]["channels_id"]] = array(
						"rating"=> $minutos[$fecha][$minuto["RatingMinuto"]["channels_id"]]["rating"]+$minuto["RatingMinuto"]["rating"],
						"tvr"=> $minutos[$fecha][$minuto["RatingMinuto"]["channels_id"]]["tvr"]+$minuto["RatingMinuto"]["tvr"],
					);
				}else{
					$minutos[$fecha][$minuto["RatingMinuto"]["channels_id"]] = array(
						"rating"=> $minuto["RatingMinuto"]["rating"],
						"tvr"=> $minuto["RatingMinuto"]["tvr"],
					);	
				}
			}
		}else{
			$minutos = 0;
		}
		$this->set("minutos", json_encode($minutos));
	}

	public function carga_webservice(){
		ini_set('default_socket_timeout', 600);
		$this->autoRender = false;
		$this->loadModel("RatingMinutosAcumulado");
		$fecha = new DateTime("now");
		$mensajeCorreo = array();
		//$fecha = new DateTime("2018-02-21");
		if($fecha->format("N")!=1){
			$fecha->modify("-1 day");
		}else{
			$fecha->modify("-3 day");
		}
		
		$fechaActual = new DateTime("now");

		#//$fechaActual = new DateTime("2018-02-21");
		#//$fecha = new DateTime("2017-12-08");

		while ($fecha->format("Y-m-d") < $fechaActual->format("Y-m-d")) {
			$insert = $this->carga_data_webservice_bandas($fecha->format("Y-m-d"));
			if(!isset($insert["error"])){
				if(!empty($insert)){					
					$this->RatingMinuto->saveAll($insert["bandas"]);
					$this->RatingMinutosAcumulado->saveAll($insert["acumulado"]);
					$mensajeCorreo[] = "Se insertaron correctamente en Rating Minutos ".count($insert["bandas"])." y en acumulados ".count($insert["acumulado"])." registros, del día ".$fecha->format("d/m/Y");
					if(isset($insert["registrados"])){
						foreach ($insert["registrados"] as $target => $canales) {
							foreach ($canales as $canal => $bandas) {
								$mensajeCorreo[] = "Se omitio del Target id ".$target." y canal id ".$canal." la cantidad de ".count($bandas)." que ya se encuentran registrado del día ".$fecha->format("d/m/Y"); 
							}
						}
					}
				}else{
					$mensajeCorreo[] = "No se inserto ningun registro con fecha ".$fecha->format("d/m/Y"). "porque ya se encontraban ingresados";
				}
			}else{
				$mensajeCorreo[] = $insert["error"];
			}
			$fecha->modify("+1 day");
		}
		$Email = new CakeEmail("gmail");
		$Email->from(array('sgi@cdf.cl' => 'SGI'));
		$Email->to('desarrollo@cdf.cl');
		$Email->subject("Carga rating");
		$Email->emailFormat('html');
		$Email->template('carga_rating');
		$Email->viewVars(array(
			"mensajes"=>$mensajeCorreo,
		));
		$Email->send();

	}

	public function acumulados(){
		$this->autoRender = false;
		$this->response->type("json");
		//ini_set('memory_limit', '-1');
		$this->loadModel("RatingMinutosAcumulado");
		$this->loadModel("Channel");
		$channels = $this->Channel->find("all", array("recursive"=>-1));
		foreach ($channels as $channel) {
			$acumulados["canales"][$channel["Channel"]["id"]] = $channel["Channel"];
		}
		$fechaInicial = new DateTime($this->request->query["anio"]);
		$semanaInicial = new DateTime($this->request->query["anio"]);
		$diaSemana = $semanaInicial->format("N")-1;
		$semanaInicial->modify("-$diaSemana day");
		$semanaAnterior = new DateTime($semanaInicial->format("Y-m-d"));
		$semanaAnterior->modify("-1 week");
		$canalesAcumulados = $this->RatingMinutosAcumulado->find("all", array(
			"conditions"=>array(
				"RatingMinutosAcumulado.fecha >="=>$fechaInicial->format("Y")."-01-01",
				"RatingMinutosAcumulado.fecha <="=>$this->request->query["anio"],
				"RatingMinutosAcumulado.tipo"=>1
				),
			"recursive"=>-1
			)
		);
		foreach ($canalesAcumulados as $canal) {
			$fecha = new DateTime($canal["RatingMinutosAcumulado"]["fecha"]);
			$fechas[] = $canal["RatingMinutosAcumulado"]["fecha"];
			if($fecha->format("n") == $fechaInicial->format("n")){
				$acumuladosMtd[$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["rating"][] = $canal["RatingMinutosAcumulado"]["rating"];
				$acumuladosMtd[$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["share"][] = $canal["RatingMinutosAcumulado"]["share"];
				$acumuladosMtd[$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["tvr"][] = $canal["RatingMinutosAcumulado"]["tvr"];
			}
			if($fecha->format("Y-m-d") >= $semanaAnterior->format("Y-m-d")){
				$acumuladosWtd[$fecha->format("W")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["rating"][] = $canal["RatingMinutosAcumulado"]["rating"];
				$acumuladosWtd[$fecha->format("W")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["share"][] = $canal["RatingMinutosAcumulado"]["share"];
				$acumuladosWtd[$fecha->format("W")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["tvr"][] = $canal["RatingMinutosAcumulado"]["tvr"];
				$acumuladosWtd[$fecha->format("W")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["fecha"][] = $fecha->format("Y-m-d");
			}
			$acumuladosYtd[$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["rating"][] = $canal["RatingMinutosAcumulado"]["rating"];
			$acumuladosYtd[$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["share"][] = $canal["RatingMinutosAcumulado"]["share"];
			$acumuladosYtd[$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["tvr"][] = $canal["RatingMinutosAcumulado"]["tvr"];
		}
		$fechaFinal = new DateTime(max($fechas));
		$acumulados["fechaFinal"] = $fechaFinal->format("Y-m-d");
		foreach ($acumuladosYtd as $target => $canales) {
			foreach ($canales as $canal => $valores) {
				$acumulados["ytd"][$target][$canal]["rating"] = array_sum($valores["rating"])/count($valores["rating"]);
				$acumulados["ytd"][$target][$canal]["share"] = array_sum($valores["share"])/count($valores["share"]);
				$acumulados["ytd"][$target][$canal]["tvr"] = array_sum($valores["tvr"])/count($valores["tvr"]);
				$acumulados["ytd"][$target][$canal]["canal_id"] = $acumulados["canales"][$canal]["id"];
				$acumulados["ytd"][$target][$canal]["nombre"] = $acumulados["canales"][$canal]["nombre"];
				$acumulados["ytd"][$target][$canal]["nombre_corto"] = $acumulados["canales"][$canal]["nombre_corto"];
			}
			
		}
		foreach ($acumuladosMtd as $target => $canales) {
			foreach ($canales as $canal => $valores) {
				$acumulados["mtd"][$target][$canal]["rating"] = array_sum($valores["rating"])/count($valores["rating"]);
				$acumulados["mtd"][$target][$canal]["share"] = array_sum($valores["share"])/count($valores["share"]);
				$acumulados["mtd"][$target][$canal]["tvr"] = array_sum($valores["tvr"])/count($valores["tvr"]);
				$acumulados["mtd"][$target][$canal]["canal_id"] = $acumulados["canales"][$canal]["id"];
				$acumulados["mtd"][$target][$canal]["nombre"] = $acumulados["canales"][$canal]["nombre"];
				$acumulados["mtd"][$target][$canal]["nombre_corto"] = $acumulados["canales"][$canal]["nombre_corto"];
			}
			
		}
		$i = 0;
		
		foreach ($acumuladosWtd as $semana => $semanas) {
			foreach ($semanas as $target => $canales) {
				foreach ($canales as $canal => $valores) {
					$acumulados["wtd"][$i][$target][$canal]["rating"] = array_sum($valores["rating"])/count($valores["rating"]);
					$acumulados["wtd"][$i][$target][$canal]["share"] = array_sum($valores["share"])/count($valores["share"]);
					$acumulados["wtd"][$i][$target][$canal]["tvr"] = array_sum($valores["tvr"])/count($valores["tvr"]);
					$acumulados["wtd"][$i][$target][$canal]["canal_id"] = $acumulados["canales"][$canal]["id"];
					$acumulados["wtd"][$i][$target][$canal]["nombre"] = $acumulados["canales"][$canal]["nombre"];
					$acumulados["wtd"][$i][$target][$canal]["nombre_corto"] = $acumulados["canales"][$canal]["nombre_corto"];
					$acumulados["wtd"][$i][$target][$canal]["fecha_inicio"] = min($valores["fecha"]); 
					$acumulados["wtd"][$i][$target][$canal]["fecha_final"] = max($valores["fecha"]);
					(count($valores["fecha"]) == 7) ? $acumulados["wtd"][$i][$target][$canal]["estado"] = 1 : $acumulados["wtd"][$i][$target][$canal]["estado"] = 0;
				}
				
			}
			$i++;
		}
		return json_encode($acumulados);
	}

	public function grafico_bandas(){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("RatingMinutosAcumulado");
		$this->loadModel("Channel");
		$respuesta = array();
		$channels = $this->Channel->find("all", array("recursive"=>-1));
		foreach ($channels as $channel) {
			$canalesArray[$channel["Channel"]["id"]] = $channel["Channel"];
		}
		$fechaInicial = new DateTime($this->request->query["fecha"]);
		$fechaComparar = new DateTime($this->request->query["fecha"]);
		$fechaAnterior = new DateTime($this->request->query["fecha"]);
		$fechaAnterior->modify("-1 year -1 month");
		$canalesAcumulados = $this->RatingMinutosAcumulado->find("all", array(
			"conditions"=>array(
				"RatingMinutosAcumulado.fecha <="=>$fechaInicial->format("Y-m-d"),
				"TO_CHAR(RatingMinutosAcumulado.fecha,'YYYYMM') >="=>$fechaAnterior->format("Ym"),
				"RatingMinutosAcumulado.tipo"=>1
				),
			"recursive"=>-1,
			"order"=>"RatingMinutosAcumulado.fecha ASC"
			)
		);
		$fechaEncontrada = false;	
		while(!$fechaEncontrada){
			if($fechaComparar->format('n') != $fechaInicial->format('n')){
				if(!isset($fechaSemanaAnalizar)){
					$fechaComparar->modify("+1 day");
					$fechaSemanaAnalizar =  new DateTime($fechaComparar->format("Y-m-d"));
				}
				if($fechaComparar->format("W") != $fechaSemanaAnalizar->format("W")){
					$fechaComparar->modify("+1 day");
					break;
				}
			}
			$fechaComparar->modify("-1 day");
		}
		$i = 0;
		if(!empty($canalesAcumulados)){
			foreach ($canalesAcumulados as $canal){
				$fecha = new DateTime($canal["RatingMinutosAcumulado"]["fecha"]);
				if($fechaInicial->format("Ym") != $fecha->format("Ym")){
					$acumulado["meses"][$fecha->format("n-Y")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["rating"][] = $canal["RatingMinutosAcumulado"]["rating"];
					$acumulado["meses"][$fecha->format("n-Y")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["share"][] = $canal["RatingMinutosAcumulado"]["share"];
					$acumulado["meses"][$fecha->format("n-Y")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["tvr"][] = $canal["RatingMinutosAcumulado"]["tvr"];
				}
				if($fecha->format("Y-m-d") >= $fechaComparar->format("Y-m-d")){
					$acumulado["semanas"][$fecha->format("Y-W")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["rating"][] = $canal["RatingMinutosAcumulado"]["rating"];
					$acumulado["semanas"][$fecha->format("Y-W")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["share"][] = $canal["RatingMinutosAcumulado"]["share"];
					$acumulado["semanas"][$fecha->format("Y-W")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["tvr"][] = $canal["RatingMinutosAcumulado"]["tvr"];
				}
			}
			foreach ($acumulado as $tipo => $periodos) {
				foreach($periodos as $periodo => $targets){
					foreach ($targets as $target => $canales) {
						foreach($canales as $canalId => $valores){
							if($tipo == "meses"){
								$respuesta[$tipo][$periodo][$target][$canalId]["rating"] = array_sum($valores["rating"])/count($valores["rating"]);
								$respuesta[$tipo][$periodo][$target][$canalId]["share"] = array_sum($valores["share"])/count($valores["share"]);
								$respuesta[$tipo][$periodo][$target][$canalId]["tvr"] = array_sum($valores["tvr"])/count($valores["tvr"]);
								$respuesta[$tipo][$periodo][$target][$canalId]["canal_id"] = $canalId;
								$respuesta[$tipo][$periodo][$target][$canalId]["nombre"] = $canalesArray[$canalId]["nombre"];
								$respuesta[$tipo][$periodo][$target][$canalId]["nombre_corto"] = $canalesArray[$canalId]["nombre_corto"];
							}else{
								if(count($valores["rating"]) == 7){
									$respuesta[$tipo][$periodo][$target][$canalId]["rating"] = array_sum($valores["rating"])/count($valores["rating"]);
									$respuesta[$tipo][$periodo][$target][$canalId]["share"] = array_sum($valores["share"])/count($valores["share"]);
									$respuesta[$tipo][$periodo][$target][$canalId]["tvr"] = array_sum($valores["tvr"])/count($valores["tvr"]);
									$respuesta[$tipo][$periodo][$target][$canalId]["canal_id"] = $canalId;
									$respuesta[$tipo][$periodo][$target][$canalId]["nombre"] = $canalesArray[$canalId]["nombre"];
									$respuesta[$tipo][$periodo][$target][$canalId]["nombre_corto"] = $canalesArray[$canalId]["nombre_corto"];
								}
							}
							
						}
					}	
				}
			}
		}
		return json_encode($respuesta);
	}

	public function acumulados_wtd(){
		$this->autoRender = false;
		$this->response->type("json");
		//ini_set('memory_limit', '-1');
		$this->loadModel("RatingMinutosAcumulado");
		$this->loadModel("Channel");
		$channels = $this->Channel->find("all", array("recursive"=>-1));
		foreach ($channels as $channel) {
			$canalesConsulta[$channel["Channel"]["id"]] = $channel["Channel"];
		}
		$fechaInicial = new DateTime($this->request->query["anio"]);
		$semanaInicial = new DateTime($this->request->query["anio"]);		
		$diaSemana = $semanaInicial->format("N")-1;
		$semanaInicial->modify("-$diaSemana day");
		$semanaAnterior = new DateTime($semanaInicial->format("Y-m-d"));
		$semanaAnterior->modify("-1 week");
		$acumulados[] = $this->RatingMinutosAcumulado->find("all", array(
			"conditions"=>array(
				"RatingMinutosAcumulado.fecha >="=>$semanaAnterior->format("Y-m-d"),
				"RatingMinutosAcumulado.fecha <="=>$fechaInicial->format("Y-m-d"),
				"RatingMinutosAcumulado.tipo"=>1
				),
			"recursive"=>-1
			)
		);
		$fechaInicialAnioAnterior = new DateTime($this->request->query["anio"]);
		$fechaInicialAnioAnterior->modify("-1 year");
		
		if($fechaInicialAnioAnterior->format("W") == $fechaInicial->format("W")){
			$dia = $fechaInicialAnioAnterior->format("N")-1;
			$fechaInicialAnioAnterior->modify("-$dia day");
			$fechaInicialAnioAnterior->modify("-1 week");
			$fechaFinalAnioAnterior = new DateTime($fechaInicialAnioAnterior->format("Y-m-d"));
			$fechaFinalAnioAnterior->modify("+2 week -1 day");
		}
		if($fechaInicialAnioAnterior->format("W") > $fechaInicial->format("W")){
			$fechaInicialAnioAnterior->modify("-1 week");
			$dia = $fechaInicialAnioAnterior->format("N")-1;
			$fechaInicialAnioAnterior->modify("-$dia day");
			$fechaInicialAnioAnterior->modify("-1 week");
			$fechaFinalAnioAnterior = new DateTime($fechaInicialAnioAnterior->format("Y-m-d"));
			$fechaFinalAnioAnterior->modify("+2 week -1 day");
		}else{
			$fechaInicialAnioAnterior->modify("+1 week");
			$dia = $fechaInicialAnioAnterior->format("N")-1;
			$fechaInicialAnioAnterior->modify("-$dia day");
			$fechaInicialAnioAnterior->modify("-1 week");
			$fechaFinalAnioAnterior = new DateTime($fechaInicialAnioAnterior->format("Y-m-d"));
			$fechaFinalAnioAnterior->modify("+2 week -1 day");
		}
		//pr($fechaInicialAnioAnterior);
		//pr($fechaFinalAnioAnterior);
		$acumulados[] = $this->RatingMinutosAcumulado->find("all", array(
			"conditions"=>array(
				"RatingMinutosAcumulado.fecha >="=>$fechaInicialAnioAnterior->format("Y-m-d"),
				"RatingMinutosAcumulado.fecha <="=>$fechaFinalAnioAnterior->format("Y-m-d"),
				"RatingMinutosAcumulado.tipo"=>1
				),
			"recursive"=>-1
			)
		);
		//pr($acumulados[1]);
		//exit;
		foreach ($acumulados as $anios) {
			$acumuladosWtd = array();
			foreach ($anios as $canal) {
				$fecha = new DateTime($canal["RatingMinutosAcumulado"]["fecha"]);
				$acumuladosWtd[$fecha->format("W")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["rating"][] = $canal["RatingMinutosAcumulado"]["rating"];
				$acumuladosWtd[$fecha->format("W")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["share"][] = $canal["RatingMinutosAcumulado"]["share"];
				$acumuladosWtd[$fecha->format("W")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["tvr"][] = $canal["RatingMinutosAcumulado"]["tvr"];
				$acumuladosWtd[$fecha->format("W")][$canal["RatingMinutosAcumulado"]["target_id"]][$canal["RatingMinutosAcumulado"]["channels_id"]]["fecha"][] = $fecha->format("Y-m-d");
			}
			$acumuladosSemanas[] = $acumuladosWtd; 
		}
		foreach ($acumuladosSemanas as $anios) {
			$i = 0;
			$promedios = array();
			foreach ($anios as $semana => $semanas) {
				foreach ($semanas as $target => $canales) {
					foreach ($canales as $canal => $valores) {
						$promedios[$i][$target][$canal]["rating"] = array_sum($valores["rating"])/count($valores["rating"]);
						$promedios[$i][$target][$canal]["share"] = array_sum($valores["share"])/count($valores["share"]);
						$promedios[$i][$target][$canal]["tvr"] = array_sum($valores["tvr"])/count($valores["tvr"]);
						$promedios[$i][$target][$canal]["canal_id"] = $canalesConsulta[$canal]["id"];
						$promedios[$i][$target][$canal]["nombre"] = $canalesConsulta[$canal]["nombre"];
						$promedios[$i][$target][$canal]["nombre_corto"] = $canalesConsulta[$canal]["nombre_corto"];
						$promedios[$i][$target][$canal]["fecha_inicio"] = min($valores["fecha"]); 
						$promedios[$i][$target][$canal]["fecha_final"] = max($valores["fecha"]);
						(count($valores["fecha"]) == 7) ? $promedios[$i][$target][$canal]["estado"] = 1 : $promedios[$i][$target][$canal]["estado"] = 0;
					}
					
				}
			$i++;
			}
			$respuesta[] = $promedios;
		}
		//pr($respuesta);exit;
		return json_encode($respuesta);
	}

}
