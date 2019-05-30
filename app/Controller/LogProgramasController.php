<?php
App::uses('AppController', 'Controller');
/**
 * LogProgramas Controller
 *
 * @property LogPrograma $LogPrograma
 * @property PaginatorComponent $Paginator
 */
class LogProgramasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	function incrementadorDias($fecha,$ndias)  
	{
		if(preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		{
			list($dia, $mes, $año) = split("-", $fecha);
		}

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
		{
			 list($dia,$mes,$año) = split("-",$fecha);
		}

		$nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
	    $nuevafecha = date("d-m-Y",$nueva);

	    return ($nuevafecha);    
	}


	public function procesa_log($carpetaLog = null)
	{	
        echo "hola";
		//Configure::write('debug', 1); 
		//echo "procesa";
		//exit;
        // pr($this->params);exit;
	
		//Configure::write('debug', 1); 
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300);

		///home/rating/logProdrive/01_basico/
		$directoriologBasico = "/home/rating/logProdrive/".(isset($this->request->data['carpeta']) ? $this->request->data['carpeta'] : $carpetaLog)."/*";
		
		
		$dias = 31;
		$meses = 12;
		$mes = "";
		$dia = "";

       
		$mesActual = (isset($this->request->data['mes']) ? $this->request->data['mes'] : date("m")); //print_r(date("m"));
		//echo $mesActual;
		//echo date("m");
		//exit;
		$agnoActual = date("Y");//2015; //date("Y");

		for ($imeses = 1; $imeses <= $meses; $imeses++) {
		    for ($idias = 1; $idias <= $dias; $idias++) {
		    	$mes[$imeses][] = $idias;
			}
		}



		$concatenaNombre = "";
		foreach($mes as $key => $mes)
		{
			foreach($mes as $valor)
			{
				$mes =  strlen($key) == 1 ? "0".$key : $key;//$mesActual;
				$dia = strlen($valor) == 1 ? "0".$valor : $valor;
				$logAgrupado[$agnoActual.$mesActual.$dia] = glob($directoriologBasico.$agnoActual.$mesActual.$dia."*");
			}
		}

        
        
		$datos = "";
		if(!empty($logAgrupado))
		{
			foreach(array_filter($logAgrupado) as $key => $datosLogAgrupado)
			{
				foreach($datosLogAgrupado as $datosLog)
				{
					$archivo = fopen($datosLog, "r");
					while(!feof($archivo)) 
					{
				 		$splitLog[$key][] = explode( '	', fgets($archivo));
				 	}
				}
			}

			$datosLog = "";
			$prefijoNombre = "";
			$fechaTv = "";
			$contador = 0;
			$dias = "";
			$fechaInicio = "";
			$logCompleto = "";

			foreach($splitLog as $fecha => $valor)
			{	
				if(isset($fecha))
				{
					$fechaInicio = date("d-m-Y", strtotime($fecha));
				}
				foreach($valor as $log)
				{
					if(!empty($log[1]) && !empty($log[2]) && !empty($log[3]) && !empty($log[5]) && !empty($log[6])  && !empty($log[6]) && !empty($log[7]))
					{
						$hora = explode(":", $log[6]);
						//if($log[6] != "--:--:--:--")
						//{
							$logCompleto[$fechaInicio][] = array(
								"numero_evento"=>$log[0],
								"hora_inicio"=>(isset($log[6])) ? $log[6] : "",
								"cambioDia" => $hora[0],
								"fechaArchivo" =>$fechaInicio,
								"fechaOriginalArchivo"=>$fecha
							);
						//}	
					}	
				}
			}

			//echo "<pre>";
	
			//exit;


			if(empty($logCompleto))
			{
				CakeLog::write('actividad', 'Carga log basico esta vacio  se detiene el proceso' . date("d-m-Y H:i:s"));
				exit;
			}

			$modificaDias = "";
			$r = 0;
			foreach($logCompleto as $fechaArchivo => $logCompleto)
			{

				//if($logCompleto[0]["hora_inicio"] != "--:--:--:--")
				//{
					$x = 0;
					$incrementdor = 0;
					$horaInicioArchivo = explode(":", $logCompleto[0]["hora_inicio"]);
					$fechaInicio = date("d-m-Y", strtotime($fechaArchivo));


					if($logCompleto[0]["cambioDia"] == 00)
					{
						$modificaDias[$fechaArchivo] = $this->incrementadorDias($fechaInicio, -1);//$logCompleto[0]["fechaArchivo"];
					}

					if($logCompleto[0]["cambioDia"] >= 00 && $logCompleto[0]["cambioDia"] <= 06)
					{
						$modificaDias[$fechaArchivo] = $this->incrementadorDias($fechaInicio, -1);//$logCompleto[0]["fechaArchivo"];
					}

					/*
					if($logCompleto[0]["cambioDia"] <= 00 && $logCompleto[0]["cambioDia"] >= 06)
					{
						$modificaDias[$fechaArchivo] = $logCompleto[0]["fechaArchivo"];
					}
					*/



					foreach($logCompleto as $key => $salida)
					{

						if($salida["cambioDia"] == "06" && !isset($logCompleto[$key -1]["cambioDia"]))
						{
							$cambiaDias[$fechaArchivo][] = array(
								"codigo"=>$salida["numero_evento"],
								"cambioDia"=>$salida["cambioDia"] ,
							);

							$fechaG =  $this->incrementadorDias($fechaArchivo, -1);
						}

						if($salida["cambioDia"] == "06" && isset($logCompleto[$key -1]["cambioDia"]))
						{
							if($salida["cambioDia"] == "06" && $logCompleto[$key -1]["cambioDia"] == "05")
							{
								$cambiaDias[$fechaArchivo][] = array(
									"codigo"=>$salida["numero_evento"],
									"cambioDia"=>$salida["cambioDia"] ,
									"fechaG"=>(isset($fechaG) ? $fechaG : ""),
								);
							}
						}
					}
				//}
			}
			//echo "<pr>";
			//print_r($cambiaDias);
			//exit;

			$fechaCorte = "";
			foreach($cambiaDias as $key => $cambiaDiasx)
			{
				foreach($cambiaDiasx as $cambiaDia)
				{
					if(!empty($cambiaDia["fechaG"]))
					{
						$cambiaDias[$this->incrementadorDias($key, -1)] = $cambiaDias[$this->incrementadorDias($key, 0)];
						$eliminarArreglo[$key] = $key;
					}
				}
			}

			if(isset($eliminarArreglo))
			{
				$codigosRestaurar = "";
				foreach($eliminarArreglo as $valorAEliminar)
				{
					foreach($cambiaDias[$valorAEliminar] as $codigos)
					{
						$codigosRestaurar[$codigos["codigo"]] = $codigos["codigo"];
					}
					unset($cambiaDias[$valorAEliminar]);
				}
			}

			$pasoCambioFecha = "";

			foreach($cambiaDias as $fechaOriginal => $cambiaDias)
			{
				foreach($cambiaDias as $keyValor => $cambiaDia) 
				{
					if(!empty($cambiaDia["fechaG"]))
					{
						$trozador[] = $fechaOriginal;
					}

					if(count($cambiaDias) == 1 && isset($modificaDias[$fechaOriginal]))
					{
						$pasoCambioFechas[$cambiaDia["codigo"].$fechaOriginal][] = $this->incrementadorDias($modificaDias[$fechaOriginal], 1);
					}
					else if(isset($modificaDias[$fechaOriginal]) && count($cambiaDias) != 1)
					{
						$pasoCambioFechas[$cambiaDia["codigo"].$fechaOriginal][] = $this->incrementadorDias($fechaOriginal, $keyValor);
					}
					else
					{
						$pasoCambioFechas[$cambiaDia["codigo"].$fechaOriginal][] = $this->incrementadorDias($fechaOriginal, $keyValor + 1);
					}
				}
			}

			if(isset($codigosRestaurar))
			{
				$codigosAcambiar = "";
				foreach($codigosRestaurar as $keyCodigo => $valorCodigo)
				{
					foreach($trozador as $fechaIncremental)
					{
						$codigosAcambiar[$valorCodigo.$fechaIncremental] = array($fechaIncremental, $valorCodigo);
					}
				}

				if(isset($codigosAcambiar))
				{
					foreach($codigosAcambiar as $codigoFecha => $codigoCambiaFecha)
					{	
						if(isset($codigoCambiaFecha) && isset($pasoCambioFechas[$codigoFecha])){
							//pr($pasoCambioFechas[$codigoFecha]);
							$pasoCambioFechas[$codigoCambiaFecha[1].$this->incrementadorDias($codigoCambiaFecha[0], 1)] = $pasoCambioFechas[$codigoFecha];
						}
						
						unset($pasoCambioFechas[$codigoFecha]);
					}

					//pr($pasoCambioFechas);
					//exit;
				}
			}

			$logNormalizado = "";
			$fechaReal = "";
			$conditionsNumeroEvento = "";
			$conditionsFecha = "";
			$conditionsNombreCanal = "";
			$conditionsHoraInicio = "";
			$conditionsDuracion = "";

			foreach($splitLog as $fechaArchivo => $logReal)
			{
				if(isset($fechaArchivo))
				{
					$fechaInicio = date("d-m-Y", strtotime($fechaArchivo));
				}

				foreach($logReal as $salidaLog)
				{
					if(isset($pasoCambioFechas[$salidaLog[0].$fechaInicio]))
					{
						$fechaReal = $pasoCambioFechas[$salidaLog[0].$fechaInicio][0];
					}

					if(empty($fechaReal))
					{
						$fechaReal = $fechaInicio;
					}

					if(!empty($salidaLog[0]))
					{
						$logNormalizado[] = array(
							"numero_evento"=>$salidaLog[0],
							"fecha"=>(isset($salidaLog[1])) ? date("Y-m-d ", strtotime($salidaLog[1])) : "",
							"inicio_presupuestado"=>(isset($salidaLog[2])) ? $salidaLog[2] : "",
							"nombre_canal"=>(isset($salidaLog[3])) ? $salidaLog[3] : "",
							"tipo_play"=>(isset($salidaLog[5])) ? $salidaLog[5] : "",
							"hora_inicio"=>(isset($salidaLog[6])) ? $salidaLog[6] : "",
							"hora_inicio_dos"=>(isset($salidaLog[7])) ? $salidaLog[7] : "",
							"duracion"=>(isset($salidaLog[8])) ? $salidaLog[8] : "",
							"hora_tres"=>(isset($salidaLog[9])) ? $salidaLog[9] : "",
							"clip"=>(isset($salidaLog[10])) ? $salidaLog[10] : "",
							"estado"=>(isset($salidaLog[11])) ? $salidaLog[11] : "",
							"dia_tv"=>$fechaReal
						);

						$conditionsNumeroEvento[] = $salidaLog[0];
						$conditionsFecha[] = date("Y-m-d ", strtotime($salidaLog[1]));
						$conditionsNombreCanal[] = $salidaLog[3];
						$conditionsHoraInicio[] = $salidaLog[6];
						$conditionsDuracion[] = $salidaLog[8];
					}
				}
			}


			if(!empty($logNormalizado))
				{

					
					//exit;
					
					$idEncontrados = $this->LogPrograma->find("all", array(
						'conditions'=>array(
							"LogPrograma.numero_evento"=>$conditionsNumeroEvento,
							"LogPrograma.fecha"=>$conditionsFecha,
							"LogPrograma.nombre_canal"=>$conditionsNombreCanal,
							"LogPrograma.hora_inicio"=>$conditionsHoraInicio,
							"LogPrograma.duracion"=>$conditionsDuracion,
						),
						'fields'=>"LogPrograma.id"
					));

					
					$idLogProgramas = "";
	
					if(!empty($idEncontrados))
					{
						foreach($idEncontrados as $idEncontrado)
						{
							$idLogProgramas[] = $idEncontrado["LogPrograma"]["id"];
						}

						$this->LogPrograma->deleteAll(array("id"=>$idLogProgramas), false);
					}


					if($this->LogPrograma->saveAll($logNormalizado))
					{
						echo ("guardo los daots en la db");
						CakeLog::write('actividad', 'Carga log basico programas - exitoso ' . date("d-m-Y H:i:s"));
					}
					else
					{
						echo ("no guardo");
						CakeLog::write('actividad', 'No Carga log basico programas - con problemas ' . date("d-m-Y H:i:s"));
					}
				}
			//pr($logNormalizado);
		}
		exit;
	}


	public function procesa_log_basico()
	{			
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300);

		$this->layout = "ajax";

		$directoriologBasico = "/home/log_prodrive/01_basico/";

		if (is_dir($directoriologBasico)) {
			$nombreOrdenFecha = "";
			if ($leeDirectorio = opendir($directoriologBasico)) {
				while (($file = readdir($leeDirectorio)) !== false) {
					$orquestador = explode('_', $file);

					if(isset($orquestador[0]) && isset($orquestador[1]) && isset($orquestador[2]))
					{
						$nombreOrdenFecha[$file] = array(
							"FechaNumero" => date("Ymd", strtotime($orquestador[1])).substr($orquestador[2], 0, -4),
						);
					}
				}

				$contador = 1;
				$ultimosLog = "";
				arsort($nombreOrdenFecha);

				foreach ($nombreOrdenFecha as $key => $nombreOrdenFechas)
				{
					$nombreFormateado = explode("_", $key);
					$ultimosLog[substr($nombreFormateado[2], 0 , -4)] = array("Nombre"=>$key, "FechaNumero"=>$nombreOrdenFechas["FechaNumero"]);
					/*
					if(++$contador > 1)
					{
						break;
					}
					*/
				}
				
				

				ksort($ultimosLog);

				$splitLog = "";

				if(!empty($ultimosLog))
				{
					foreach($ultimosLog as $key => $ultimosLogs)
					{
						$archivo = fopen($directoriologBasico.DS.$ultimosLogs["Nombre"], "r");
						while(!feof($archivo)) {
					 		$splitLog[$ultimosLogs["Nombre"]][] = explode( '	', fgets($archivo));
					 	}
					}
					closedir($leeDirectorio);
				}



				
				$datosLog = "";
				$prefijoNombre = "";
				$fechaTv = "";
				$contador = 0;
				$dias = "";
				$fechaInicio = "";
				$logCompleto = "";
				

				//pr($splitLog);exit;


				foreach($splitLog as $nombreArchivo => $valor)
				{
					if(isset($valor[0]["1"]))
					{
						$fechaInicio = date("d-m-Y", strtotime($valor[0]["1"]));	
					}
					
					foreach($valor as $log)
					{
						if(!empty($log[1]) && !empty($log[2]) && !empty($log[3]) && !empty($log[5]) && !empty($log[6]) && !empty($log[6]) && !empty($log[7]))
						{
							$logCompleto[] = array(
								"numero_evento"=>$log[0],
	 							"fecha"=>(isset($log[1])) ? date("Y-m-d ", strtotime($log[1])) : "",
								"inicio_presupuestado"=>(isset($log[2])) ? $log[2] : "",
								"nombre_canal"=>(isset($log[3])) ? $log[3] : "",
								"tipo_play"=>(isset($log[5])) ? $log[5] : "",
								"hora_inicio"=>(isset($log[6])) ? $log[6] : "",
								"hora_inicio_dos"=>(isset($log[7])) ? $log[7] : "",
								"duracion"=>(isset($log[8])) ? $log[8] : "",
								"hora_tres"=>(isset($log[9])) ? $log[9] : "",
								"clip"=>(isset($log[10])) ? $log[10] : "",
								"estado"=>(isset($log[11])) ? $log[11] : "",
								"nombre_archivo" => (isset($nombreArchivo)) ? $nombreArchivo : "",
								"prefijo"=>(isset($prefijoNombre[0])) ? $prefijoNombre[0] : "",
							);	
						}	
					}	
				}

				if(empty($logCompleto))
				{
					CakeLog::write('actividad', 'Carga log basico esta vacio  se detiene el proceso' . date("d-m-Y H:i:s"));
					exit;
				}

				foreach($logCompleto as $logPorDia)
				{
					$horaInicioExplode = explode(";", $logPorDia["hora_inicio"]);
					$soloHora = explode(":", $horaInicioExplode[0]);
					$minutoAminuto[] = $soloHora[0];
				}


				$dias = implode($minutoAminuto);


				$horaInicioArchivo = substr($dias, 0, 2);
				
		
				if($horaInicioArchivo == 00)
				{
					$fechaInicio = $this->incrementadorDias($fechaInicio, -1);
				}


				$diasSeparados = str_replace("0506", "05,06", $dias);


				$contadorDias = explode(",", $diasSeparados);



				foreach($contadorDias as $diasProgramas)
				{
					$programasDias[] = str_split($diasProgramas, 2);	
				}

				$diasReales = "";
				foreach($programasDias as $key => $fechaReal)
				{
					foreach($fechaReal as $llave => $dia)
					{
						$diasReales[] = $this->incrementadorDias($fechaInicio, $key);
					}
				}

				//pr($diasReales);
				


				foreach($diasReales as $key => $fecha)
				{
					$logNormalizado[] = array(
						"numero_evento"=>$logCompleto[$key]["numero_evento"],
						"fecha"=>$logCompleto[$key]["fecha"],
						"inicio_presupuestado"=>$logCompleto[$key]["inicio_presupuestado"],
						"nombre_canal"=>$logCompleto[$key]["nombre_canal"],
						"tipo_play"=>$logCompleto[$key]["tipo_play"],
						"hora_inicio"=>$logCompleto[$key]["hora_inicio"],
						"hora_inicio_dos"=>$logCompleto[$key]["hora_inicio_dos"],
						"duracion"=>$logCompleto[$key]["duracion"],
						"hora_tres"=>$logCompleto[$key]["hora_tres"],
						"clip"=>$logCompleto[$key]["clip"],
						"estado"=>$logCompleto[$key]["estado"],
						"nombre_archivo"=>$logCompleto[$key]["nombre_archivo"],
						"prefijo"=>$logCompleto[$key]["prefijo"],
						"dia_tv"=>$fecha
					);

					$conditionsNumeroEvento[] = $logCompleto[$key]["numero_evento"];
					$conditionsFecha[] = $logCompleto[$key]["fecha"];
					$conditionsNombreCanal[] = $logCompleto[$key]["nombre_canal"];
					$conditionsHoraInicio[] = $logCompleto[$key]["hora_inicio"];
					$conditionsDuracion[] = $logCompleto[$key]["duracion"];
				}

				if(!empty($logNormalizado))
				{

					$idEncontrados = $this->LogPrograma->find("all", array(
						'conditions'=>array(
							"LogPrograma.numero_evento"=>$conditionsNumeroEvento,
							"LogPrograma.fecha"=>$conditionsFecha,
							"LogPrograma.nombre_canal"=>$conditionsNombreCanal,
							"LogPrograma.hora_inicio"=>$conditionsHoraInicio,
							"LogPrograma.duracion"=>$conditionsDuracion,
						),
						'fields'=>"LogPrograma.id"
					));

					$idLogProgramas = "";
					if(!empty($idEncontrados))
					{
						foreach($idEncontrados as $idEncontrado)
						{
							$idLogProgramas[] = $idEncontrado["LogPrograma"]["id"];
						}

						$this->LogPrograma->deleteAll(array("id"=>$idLogProgramas), false);
					}

					if($this->LogPrograma->saveAll($logNormalizado))
					{
						pr("guardo");
						CakeLog::write('actividad', 'Carga log basico programas - exitoso ' . date("d-m-Y H:i:s"));
					}
					else
					{
						pr("no guardo");
						CakeLog::write('actividad', 'No Carga log basico programas - con problemas ' . date("d-m-Y H:i:s"));
					}
				}
			}
		}
	}


	public function procesa_log_premium()
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300);

		$this->layout = "ajax";

		$directoriologBasico = "/home/rating/logProdrive/02_premium";

		if (is_dir($directoriologBasico)) {
			$nombreOrdenFecha = "";
			if ($leeDirectorio = opendir($directoriologBasico)) {
				while (($file = readdir($leeDirectorio)) !== false) {
					$orquestador = explode('_', $file);

					if(isset($orquestador[0]) && isset($orquestador[1]) && isset($orquestador[2]))
					{
						$nombreOrdenFecha[$file] = array(
							"FechaNumero" => date("Ymd", strtotime($orquestador[1])).substr($orquestador[2], 0, -4),
						);

					}
				}

				$contador = 1;
				$ultimosLog = "";
				arsort($nombreOrdenFecha);

				foreach ($nombreOrdenFecha as $key => $nombreOrdenFechas)
				{
					$nombreFormateado = explode("_", $key);
					$ultimosLog[substr($nombreFormateado[2], 0 , -4)] = array("Nombre"=>$key, "FechaNumero"=>$nombreOrdenFechas["FechaNumero"]);
					
					if(++$contador > 1)
					{
						break;
					}
					
				}
				
				ksort($ultimosLog);

				$splitLog = "";

				if(!empty($ultimosLog))
				{
					foreach($ultimosLog as $key => $ultimosLogs)
					{
						$archivo = fopen($directoriologBasico.DS.$ultimosLogs["Nombre"], "r");
						while(!feof($archivo)) {
					 		$splitLog[$ultimosLogs["Nombre"]][] = explode( '	', fgets($archivo));
					 	}
					}
					closedir($leeDirectorio);
				}
				
				$datosLog = "";
				$prefijoNombre = "";
				$fechaTv = "";
				$contador = 0;
				$dias = "";
				$fechaInicio = "";
				$logCompleto = "";
				
				foreach($splitLog as $nombreArchivo => $valor)
				{
					if(isset($valor[0]["1"]))
					{
						$fechaInicio = date("d-m-Y", strtotime($valor[0]["1"]));	
					}
					foreach($valor as $log)
					{
						if(!empty($log[1]) && !empty($log[2]) && !empty($log[3]) && !empty($log[5]) && !empty($log[6]) && !empty($log[6]) && !empty($log[7]))
						{
							$logCompleto[] = array(
								"numero_evento"=>$log[0],
	 							"fecha"=>(isset($log[1])) ? date("Y-m-d ", strtotime($log[1])) : "",
								"inicio_presupuestado"=>(isset($log[2])) ? $log[2] : "",
								"nombre_canal"=>(isset($log[3])) ? $log[3] : "",
								"tipo_play"=>(isset($log[5])) ? $log[5] : "",
								"hora_inicio"=>(isset($log[6])) ? $log[6] : "",
								"hora_inicio_dos"=>(isset($log[7])) ? $log[7] : "",
								"duracion"=>(isset($log[8])) ? $log[8] : "",
								"hora_tres"=>(isset($log[9])) ? $log[9] : "",
								"clip"=>(isset($log[10])) ? $log[10] : "",
								"estado"=>(isset($log[11])) ? $log[11] : "",
								"nombre_archivo" => (isset($nombreArchivo)) ? $nombreArchivo : "",
								"prefijo"=>(isset($prefijoNombre[0])) ? $prefijoNombre[0] : "",
							);	
						}	
					}	
				}

				if(empty($logCompleto))
				{
					CakeLog::write('actividad', 'Carga log premium esta vacio  se detiene el proceso' . date("d-m-Y H:i:s"));
					exit;
				}


				foreach($logCompleto as $logPorDia)
				{
					$horaInicioExplode = explode(";", $logPorDia["hora_inicio"]);
					$soloHora = explode(":", $horaInicioExplode[0]);
					$minutoAminuto[] = $soloHora[0];
				}

				$dias = implode($minutoAminuto);

				$horaInicioArchivo = substr($dias, 0, 2);
				

				if($horaInicioArchivo >= 00  && $horaInicioArchivo <= 06)
				{
					$fechaInicio = $this->incrementadorDias($fechaInicio, -1);
				}




				$diasSeparados = str_replace("0506", "05,06", $dias);


				$contadorDias = explode(",", $diasSeparados);

				foreach($contadorDias as $diasProgramas)
				{
					$programasDias[] = str_split($diasProgramas, 2);	
				}

				$diasReales = "";
				foreach($programasDias as $key => $fechaReal)
				{
					foreach($fechaReal as $llave => $dia)
					{
						$diasReales[] = $this->incrementadorDias($fechaInicio, $key);
					}
				}

				$logNormalizado = "";

				foreach($diasReales as $key => $fecha)
				{
					$logNormalizado[] = array(
						"numero_evento"=>$logCompleto[$key]["numero_evento"],
						"fecha"=>$logCompleto[$key]["fecha"],
						"inicio_presupuestado"=>$logCompleto[$key]["inicio_presupuestado"],
						"nombre_canal"=>$logCompleto[$key]["nombre_canal"],
						"tipo_play"=>$logCompleto[$key]["tipo_play"],
						"hora_inicio"=>$logCompleto[$key]["hora_inicio"],
						"hora_inicio_dos"=>$logCompleto[$key]["hora_inicio_dos"],
						"duracion"=>$logCompleto[$key]["duracion"],
						"hora_tres"=>$logCompleto[$key]["hora_tres"],
						"clip"=>$logCompleto[$key]["clip"],
						"estado"=>$logCompleto[$key]["estado"],
						"nombre_archivo"=>$logCompleto[$key]["nombre_archivo"],
						"prefijo"=>$logCompleto[$key]["prefijo"],
						"dia_tv"=>$fecha
					);

					$conditionsNumeroEvento[] = $logCompleto[$key]["numero_evento"];
					$conditionsFecha[] = $logCompleto[$key]["fecha"];
					$conditionsNombreCanal[] = $logCompleto[$key]["nombre_canal"];
					$conditionsHoraInicio[] = $logCompleto[$key]["hora_inicio"];
					$conditionsDuracion[] = $logCompleto[$key]["duracion"];
				}

				

				if(!empty($logNormalizado))
				{
					$idEncontrados = $this->LogPrograma->find("all", array(
						'conditions'=>array(
							"LogPrograma.numero_evento"=>$conditionsNumeroEvento,
							"LogPrograma.fecha"=>$conditionsFecha,
							"LogPrograma.nombre_canal"=>$conditionsNombreCanal,
							"LogPrograma.hora_inicio"=>$conditionsHoraInicio,
							"LogPrograma.duracion"=>$conditionsDuracion,
						),
						'fields'=>"LogPrograma.id"
					));

					$idLogProgramas = "";
					if(!empty($idEncontrados))
					{
						foreach($idEncontrados as $idEncontrado)
						{
							$idLogProgramas[] = $idEncontrado["LogPrograma"]["id"];
						}

						$this->LogPrograma->deleteAll(array("id"=>$idLogProgramas), false);
					}

					if($this->LogPrograma->saveAll($logNormalizado))
					{
						pr("guardo");
						CakeLog::write('actividad', 'Carga log '. $carpetaLog .' programas - exitoso ' . date("d-m-Y H:i:s"));
					}
					else
					{
						pr("no guardo");
						CakeLog::write('actividad', 'Carga log '. $carpetaLog .' programas - exitoso ' . date("d-m-Y H:i:s"));
					}
				}
			}
		}
	}

	public function procesa_log_hd()
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300);

		$this->layout = "ajax";

		$directoriologBasico = "/home/rating/logProdrive/03_hd/";

		if (is_dir($directoriologBasico)) {
			$nombreOrdenFecha = "";
			if ($leeDirectorio = opendir($directoriologBasico)) {
				while (($file = readdir($leeDirectorio)) !== false) {
					$orquestador = explode('_', $file);

					if(isset($orquestador[0]) && isset($orquestador[1]) && isset($orquestador[2]))
					{
						$nombreOrdenFecha[$file] = array(
							"FechaNumero" => date("Ymd", strtotime($orquestador[1])).substr($orquestador[2], 0, -4),
						);

					}
				}

				$contador = 1;
				$ultimosLog = "";
				arsort($nombreOrdenFecha);

				foreach ($nombreOrdenFecha as $key => $nombreOrdenFechas)
				{
					$nombreFormateado = explode("_", $key);
					$ultimosLog[substr($nombreFormateado[2], 0 , -4)] = array("Nombre"=>$key, "FechaNumero"=>$nombreOrdenFechas["FechaNumero"]);
					
					if(++$contador > 1)
					{
						break;
					}
					
				}
				
				ksort($ultimosLog);

				$splitLog = "";

				if(!empty($ultimosLog))
				{
					foreach($ultimosLog as $key => $ultimosLogs)
					{
						$archivo = fopen($directoriologBasico.DS.$ultimosLogs["Nombre"], "r");
						while(!feof($archivo)) {
					 		$splitLog[$ultimosLogs["Nombre"]][] = explode( '	', fgets($archivo));
					 	}
					}
					closedir($leeDirectorio);
				}
				
				$datosLog = "";
				$prefijoNombre = "";
				$fechaTv = "";
				$contador = 0;
				$dias = "";
				$fechaInicio = "";
				$logCompleto = "";
				
				foreach($splitLog as $nombreArchivo => $valor)
				{
					if(isset($valor[0]["1"]))
					{
						$fechaInicio = date("d-m-Y", strtotime($valor[0]["1"]));	
					}
					foreach($valor as $log)
					{
						if(!empty($log[1]) && !empty($log[2]) && !empty($log[3]) && !empty($log[5]) && !empty($log[6]) && !empty($log[6]) && !empty($log[7]))
						{
							$logCompleto[] = array(
								"numero_evento"=>$log[0],
	 							"fecha"=>(isset($log[1])) ? date("Y-m-d ", strtotime($log[1])) : "",
								"inicio_presupuestado"=>(isset($log[2])) ? $log[2] : "",
								"nombre_canal"=>(isset($log[3])) ? $log[3] : "",
								"tipo_play"=>(isset($log[5])) ? $log[5] : "",
								"hora_inicio"=>(isset($log[6])) ? $log[6] : "",
								"hora_inicio_dos"=>(isset($log[7])) ? $log[7] : "",
								"duracion"=>(isset($log[8])) ? $log[8] : "",
								"hora_tres"=>(isset($log[9])) ? $log[9] : "",
								"clip"=>(isset($log[10])) ? $log[10] : "",
								"estado"=>(isset($log[11])) ? $log[11] : "",
								"nombre_archivo" => (isset($nombreArchivo)) ? $nombreArchivo : "",
								"prefijo"=>(isset($prefijoNombre[0])) ? $prefijoNombre[0] : "",
							);	
						}	
					}	
				}

				if(empty($logCompleto))
				{
					CakeLog::write('actividad', 'Carga log basico esta hd  se detiene el proceso' . date("d-m-Y H:i:s"));
					exit;
				}


				foreach($logCompleto as $logPorDia)
				{
					$horaInicioExplode = explode(";", $logPorDia["hora_inicio"]);
					$soloHora = explode(":", $horaInicioExplode[0]);
					$minutoAminuto[] = $soloHora[0];
				}

				$dias = implode($minutoAminuto);

				$horaInicioArchivo = substr($dias, 0, 2);
				

				if($horaInicioArchivo >= 00  && $horaInicioArchivo <= 06)
				{
					$fechaInicio = $this->incrementadorDias($fechaInicio, -1);
				}

				pr($fechaInicio);


				

				$diasSeparados = str_replace("0506", "05,06", $dias);


				$contadorDias = explode(",", $diasSeparados);

				foreach($contadorDias as $diasProgramas)
				{
					$programasDias[] = str_split($diasProgramas, 2);	
				}

				$diasReales = "";
				foreach($programasDias as $key => $fechaReal)
				{
					foreach($fechaReal as $llave => $dia)
					{
						$diasReales[] = $this->incrementadorDias($fechaInicio, $key);
					}
				}

				$logNormalizado = "";

				foreach($diasReales as $key => $fecha)
				{
					$logNormalizado[] = array(
						"numero_evento"=>$logCompleto[$key]["numero_evento"],
						"fecha"=>$logCompleto[$key]["fecha"],
						"inicio_presupuestado"=>$logCompleto[$key]["inicio_presupuestado"],
						"nombre_canal"=>$logCompleto[$key]["nombre_canal"],
						"tipo_play"=>$logCompleto[$key]["tipo_play"],
						"hora_inicio"=>$logCompleto[$key]["hora_inicio"],
						"hora_inicio_dos"=>$logCompleto[$key]["hora_inicio_dos"],
						"duracion"=>$logCompleto[$key]["duracion"],
						"hora_tres"=>$logCompleto[$key]["hora_tres"],
						"clip"=>$logCompleto[$key]["clip"],
						"estado"=>$logCompleto[$key]["estado"],
						"nombre_archivo"=>$logCompleto[$key]["nombre_archivo"],
						"prefijo"=>$logCompleto[$key]["prefijo"],
						"dia_tv"=>$fecha
					);

					$conditionsNumeroEvento[] = $logCompleto[$key]["numero_evento"];
					$conditionsFecha[] = $logCompleto[$key]["fecha"];
					$conditionsNombreCanal[] = $logCompleto[$key]["nombre_canal"];
					$conditionsHoraInicio[] = $logCompleto[$key]["hora_inicio"];
					$conditionsDuracion[] = $logCompleto[$key]["duracion"];
				}

				

				if(!empty($logNormalizado))
				{

					$idEncontrados = $this->LogPrograma->find("all", array(
						'conditions'=>array(
							"LogPrograma.numero_evento"=>$conditionsNumeroEvento,
							"LogPrograma.fecha"=>$conditionsFecha,
							"LogPrograma.nombre_canal"=>$conditionsNombreCanal,
							"LogPrograma.hora_inicio"=>$conditionsHoraInicio,
							"LogPrograma.duracion"=>$conditionsDuracion,
						),
						'fields'=>"LogPrograma.id"
					));

					$idLogProgramas = "";
					if(!empty($idEncontrados))
					{
						foreach($idEncontrados as $idEncontrado)
						{
							$idLogProgramas[] = $idEncontrado["LogPrograma"]["id"];
						}

						$this->LogPrograma->deleteAll(array("id"=>$idLogProgramas), false);
					}

					if($this->LogPrograma->saveAll($logNormalizado))
					{
						pr("guardo");
						CakeLog::write('actividad', 'Carga log hd programas - exitoso ' . date("d-m-Y H:i:s"));
					}
					else
					{
						pr("no guardo");
						CakeLog::write('actividad', 'No Carga log hd programas - con problemas ' . date("d-m-Y H:i:s"));
					}
				}
			}
		}
	}

/**
 * index method
 *
 * @return void
 *
*/

	public function index() {
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
		
		$this->layout = "angular";
		CakeLog::write('actividad', 'miro la pagina log_programas/index - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
	}
    /*
	public function lista_log($fechaEnviada)
	{
		//pr($fechaEnviada);exit;
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300);
		if(!empty($fechaEnviada))
		{
			$this->layout = "ajax";
			
			$fechaCorta = explode("-", $fechaEnviada);
			
			$listaLogs = $this->LogPrograma->find("all", array(
				'conditions'=>array(
					'LogPrograma.dia_tv LIKE'=>"%".$fechaCorta[1].'-'.$fechaCorta[0]."%"
				),
				"recursive"=>-1
			));
			
		    if(!empty($listaLogs))
			{
				foreach ($listaLogs as $key => $valor)
				{
					if(isset($valor["LogPrograma"]["hora_inicio"]))
					{
						$horaInicio = explode(";", $valor["LogPrograma"]["hora_inicio"]);
					}

					if(isset($valor["LogPrograma"]["duracion"]))
					{
						$duracion = explode(";",  $valor["LogPrograma"]["duracion"]);
					}

					if(isset($valor["LogPrograma"]["clip"]))
					{
						preg_match('@^(/)?([^/]+)@i',$valor["LogPrograma"]["clip"], $coincidencias);

						if(!empty($coincidencias[1]))
						{
							$separador = "/";
						}
						else
						{
							$separador = "\\";
						}

						if(isset($valor["LogPrograma"]["clip"]))
						{
							$programa = explode($separador, $valor["LogPrograma"]["clip"]);
						}
					}

					$inicioPrograma = $horaInicio[0];

        

					$datosLog[] = array(
						"id"=>(isset($valor["LogPrograma"]["id"])) ? $valor["LogPrograma"]["id"] : "",
						"segnal"=>(isset($valor["LogPrograma"]["nombre_canal"])) ? $valor["LogPrograma"]["nombre_canal"] : "",
						"fecha"=>date("d-m-Y", strtotime($valor["LogPrograma"]["dia_tv"])), //(isset($valor["LogPrograma"]["fecha"])) ? date("Y-m-d ", strtotime($valor["LogPrograma"]["fecha"])) : "",
						"fechaOriginal"=>date("d-m-Y", strtotime($valor["LogPrograma"]["fecha"])),
						"hora_inicio"=>$horaInicio[0],
						"programa"=>(isset($programa[3])) ? $programa[3] : "",
						"estado_programa"=>(isset($valor["LogPrograma"]["estado"])) ? $valor["LogPrograma"]["estado"] : "",
						"duracion"=>$duracion[0],
						"nombre_archivo"=>$valor["LogPrograma"]["nombre_archivo"]
					);
				}
				$this->set("datosLog", $datosLog);
				}else{
					$datosLog = array(
						"estado"=>0,
						"mensaje"=>"No se encontraron datos"
					);
					$this->set("datosLog", $datosLog);	
			      }
		
        }
	}
	*/
	public function lista_log($fechaEnviada)
	{
		//pr($fechaEnviada);exit;
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300);
		if(!empty($fechaEnviada))
		{
			$this->layout = "ajax";
			
			$fechaCorta = explode("-", $fechaEnviada);
			//pr($fechaCorta[1].'-'.$fechaCorta[0]);exit;
			$listaLogs = $this->LogPrograma->find("all", array(
				'conditions'=>array(
					'LogPrograma.dia_tv LIKE'=>"%".$fechaCorta[1].'-'.$fechaCorta[0]."%"
				),
				"recursive"=>-1
			));
			//pr($listaLogs);exit;

			/*
			$this->LogPrograma->recursive = 0;

			$this->Paginator->settings = array(
		        "conditions"=>array("LogPrograma.dia_tv"=>date("d-m-Y", strtotime($fechaEnviada))),
		       	'limit' => 99999999
		    );

		    $listaLogs = $this->Paginator->paginate('LogPrograma');
			*/

		    if(!empty($listaLogs))
			{
				foreach ($listaLogs as $key => $valor)
				{
					if(isset($valor["LogPrograma"]["hora_inicio"]))
					{
						$horaInicio = explode(";", $valor["LogPrograma"]["hora_inicio"]);
					}

					if(isset($valor["LogPrograma"]["duracion"]))
					{
						$duracion = explode(";",  $valor["LogPrograma"]["duracion"]);
					}

					if(isset($valor["LogPrograma"]["clip"]))
					{
						preg_match('@^(/)?([^/]+)@i',$valor["LogPrograma"]["clip"], $coincidencias);

						if(!empty($coincidencias[1]))
						{
							$separador = "/";
						}
						else
						{
							$separador = "\\";
						}

						if(isset($valor["LogPrograma"]["clip"]))
						{
							$programa = explode($separador, $valor["LogPrograma"]["clip"]);
						}
					}   

					$inicioPrograma = $horaInicio[0];

					/*
					if( strtotime($inicioPrograma) >= strtotime('00:00:00') && strtotime($inicioPrograma) <= strtotime('06:00:00'))
					{
						
						if(isset($valor["LogPrograma"]["fecha"]))
						{
							$valor["LogPrograma"]["fecha"] = date("Y-m-d", strtotime($valor["LogPrograma"]["fecha"] ."-1 day"));
							$explodeFecha = explode("-", date("Y-m-d ", strtotime($valor["LogPrograma"]["fecha"])));
							$ultimoDiaDelMes = date("d",mktime(0,0,0,$explodeFecha[1]+1,0,$explodeFecha[0]));
						}

					}
					*/

					$datosLog[] = array(
						"id"=>(isset($valor["LogPrograma"]["id"])) ? $valor["LogPrograma"]["id"] : "",
						"segnal"=>(isset($valor["LogPrograma"]["nombre_canal"])) ? $valor["LogPrograma"]["nombre_canal"] : "",
						"fecha"=>date("d-m-Y", strtotime($valor["LogPrograma"]["dia_tv"])), //(isset($valor["LogPrograma"]["fecha"])) ? date("Y-m-d ", strtotime($valor["LogPrograma"]["fecha"])) : "",
						"fechaOriginal"=>date("d-m-Y", strtotime($valor["LogPrograma"]["fecha"])),
						"hora_inicio"=>$horaInicio[0],
						"programa"=>(isset($programa[3])) ? $programa[3] : "",
						"estado_programa"=>(isset($valor["LogPrograma"]["estado"])) ? $valor["LogPrograma"]["estado"] : "",
						"duracion"=>$duracion[0],
						"nombre_archivo"=>$valor["LogPrograma"]["nombre_archivo"]
					);
				}
				$this->set("datosLog", $datosLog);
				}else{
					$datosLog = array(
						"estado"=>0,
						"mensaje"=>"No se encontraron datos"
					);
					$this->set("datosLog", $datosLog);	
			      }

		}
	}

	public function lista_promos_json($fechaEnviada, $fechaEnviadaDos, $fuente = null){

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300);

		$this->autoRender = false;
		$this->response->type("json");


		$inicio = new DateTime($fechaEnviada);
		$fin = new DateTime($fechaEnviadaDos);

		$diferencia = $inicio->diff($fin);

		if(!empty($fechaEnviada)){	
			//$fechaCorta = explode("-", $fechaEnviada);
			
			$fechasArray = array($fechaEnviada);

			for ($i = 1; $i <= $diferencia->days; $i++) {
				$fechasArray[] = $this->incrementadorDias($fechaEnviada, $i);
			}

			$listaLogs = $this->LogPrograma->find("all", array(
				'conditions'=>array(
					'LogPrograma.dia_tv IN'=>$fechasArray
					//'LogPrograma.dia_tv LIKE'=>"%".$fechaCorta[1].'-'.$fechaCorta[0]."%",
				),
				'fields'=>array(
					'LogPrograma.id',
					'LogPrograma.fecha',
					'LogPrograma.nombre_canal',
					'LogPrograma.clip',
					'LogPrograma.dia_tv',
					'LogPrograma.hora_inicio',
					'LogPrograma.duracion',
					'LogPrograma.created',
				),
				"recursive"=>-1,
				//'order'=>'id ASC'
			));

			$promocionesArray = "";
			$nombreMediaArray = "";

			if(!empty($listaLogs)){
				
				foreach($listaLogs as $key => $valor){
					$nombrePieza = explode("/", $valor['LogPrograma']['clip']);
					if(substr(end($nombrePieza), 0, 5) === 'HDPRO'){
						$promocionesArray[$valor['LogPrograma']['dia_tv']][ substr(end($nombrePieza), 0, -4)][$valor['LogPrograma']['nombre_canal']][] = array(
							'id'=>$valor['LogPrograma']['id'],
							'diaTv'=>$valor['LogPrograma']['dia_tv'],
							'nombrePieza'=> substr(end($nombrePieza), 0, -4),
							'horaInicio'=>$valor['LogPrograma']['hora_inicio'],
							'duracion'=>$valor['LogPrograma']['duracion']
						);

						$nombreMediaArray[] = substr(end($nombrePieza), 0, -4);
					}
				}
			}


			$this->loadModel('ProgramacionesCodigo');

			$codigos = $this->ProgramacionesCodigo->find("list", array(
				'conditions'=>array(
					'ProgramacionesCodigo.titulo'=>$nombreMediaArray
				),
				'fields'=>array(
					'ProgramacionesCodigo.titulo',
					'ProgramacionesCodigo.descripcion'
				),
				"recursive"=>-1
			));

			$promocionesAgrupadas = "";
			$agrupado = "";
			
			foreach ($promocionesArray as $keyFecha => $fecha) {
				foreach ($fecha as $keyMedia => $media) {
					foreach ($media as $keySignal => $signal) {
						foreach ($signal as $keyValor => $valor) {

							$promocionesAgrupadas[$keyFecha][$keyMedia][$keySignal] = array(
								'id'=>$valor['id'],
								'fecha'=>$keyFecha,
								'media'=>$keyMedia,
								'signal'=>$keySignal,
								'nombre'=>(isset($codigos[$keyMedia]) ? $codigos[$keyMedia] : 'no existe el codigo'),
								'cantidad'=>count($signal)
							);

							
							$agrupado[$keyFecha][$keyMedia][$keySignal][] = array(
								'id'=>$valor['id'],
								'fecha'=>$keyFecha,
								'media'=>$keyMedia,
								'signal'=>$keySignal,
								'nombre'=>(isset($codigos[$keyMedia]) ? $codigos[$keyMedia] : 'no existe el codigo'),
								'horaInicio'=>$valor['horaInicio'],
								'duracion'=>$valor['duracion'],
							);
						}
					}
				}
			}

			if($fuente === 'listaGraficosPromo'){
				return $promocionesAgrupadas;
				exit;
			}

			foreach ($promocionesAgrupadas as $keyFecha => $fecha){
				foreach ($fecha as $keyMedia => $media) {
					foreach ($media as $keySignal => $signal) {;
						$promocionesAgrupadasx[] = array(
							'id'=>$signal['id'],
							'fecha'=>$signal['fecha'],
							'media'=>$signal['media'],
							'signal'=>$signal['signal'],
							'nombre'=>$signal['nombre'],//(isset($codigos[$keyMedia]) ? $codigos[$keyMedia] : 'no existe el codigo'),
							'cantidad'=>$signal['cantidad'],
							'agrupado'=>$agrupado[$keyFecha][$keyMedia][$keySignal]
						);
					}
				}
			}

			return json_encode($promocionesAgrupadasx);
		}
	}

	public function promos(){
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
		CakeLog::write('actividad', 'miro la pagina promos  id de usuario '. $this->Session->Read("PerfilUsuario.idUsuario"));
	}
	
	public function promos_graficos(){
		$this->layout = "angular";
		
	}

	public function promos_graficos_json($fechaEnviada, $fechaEnviadaDos){


		$this->autoRender = false;
		$this->response->type("json");

		$data = $this->lista_promos_json($fechaEnviada, $fechaEnviadaDos, 'listaGraficosPromo');

		$promocionesGaficosList = "";
		$salida = '';
		$inicializador = '';

		if(!empty($data)){
			$inicializador = 0;	
			foreach ($data as $keyFecha => $fecha) {
				foreach ($fecha as $keyMedia => $media) {
					foreach ($media as $keySignal => $signal) {

						$promocionesGaficosList[$keyMedia][$keySignal][] = array(
							'nombre'=>$signal['nombre'],
							'cantidad'=>$signal['cantidad'], 	
						);
					}
				}
			}
			

			$x = '';


			foreach ($promocionesGaficosList as $keyMedia => $media) {

				
				if(count($media) == 1){
					if(!isset($media['SD_CDF_BAS'])){
						$salida[$keyMedia]['SD_CDF_BAS'] = array(
							'nombre'=> 'sin informacion',
							'total'=>0
						);
					}

					if(!isset($media['SD_CDF_PREM'])){
						$salida[$keyMedia]['SD_CDF_PREM'] = array(
							'nombre'=> 'sin informacion',
							'total'=>0
						);
					}

					if(!isset($media['HD_CDF_HD'])){
						$salida[$keyMedia]['HD_CDF_HD'] = array(
							'nombre'=> 'sin informacion',
							'total'=>0
						);
					}
				}
				
				$inicializador= 0;
				foreach ($media as $keySignal => $signal) {
					foreach ($signal as $keydata => $data) {
						$salida[$keyMedia][$keySignal] = array(
							'nombre'=> $data['nombre'],
							'total'=>$inicializador += $data['cantidad']
						);
					}
				}
			}
		}else{
			return false;
		}
		

		return json_encode($salida);
	}
}
