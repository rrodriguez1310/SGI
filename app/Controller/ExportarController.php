<?php
App::uses('AppController', 'Controller');
class ExportarController extends AppController 
{
	public function graficos_dos()
	{ 
		$this->layout = "angular";
	}

	public function graficos()
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
		CakeLog::write('actividad', 'miro la pagina graficos abonados - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
	}
	
	public function excel()
	{
		$this->loadModel("Company");
		$operadoresIniciales = $this->Company->Find("list", array(
			"conditions"=>array("Company.company_type_id"=>1),
			"fields"=>array("Company.id", "Company.nombre"),
		));
		
		$this->set("operadores", $operadoresIniciales);
	}

	public function descarga_excel()
	{
		ini_set('memory_limit', '512M');	
		$this->layout="excel";
	
		$this->loadModel("Subscriber");
		$this->loadModel("Month");
		$this->loadModel("Company");
		$this->loadModel("Channel");
		$this-> loadModel("BudgetedSubscriber");

		$fechaDesde = explode("/", $this->request->data["fechaDesde"]);
		$fechaHasta = explode("/", $this->request->data["fechaHasta"]);

		if(!empty($fechaDesde) && !empty($fechaHasta))
		{
			$agnoInicio = $fechaDesde[2];
			$agnoTermino = $fechaHasta[2];

			$agnosPedidos = array($agnoInicio, $agnoTermino);

			$this->loadModel("Year");

			$idAgnos = $this->Year->find("all", array(
				"conditions"=>array("Year.nombre"=>$agnosPedidos)
			));

			$agnosId = "";
			foreach($idAgnos as $idAgno)
			{
				$agnosId[] = $idAgno["Year"]["id"];
			}

			$agnos = "";


			if(count($idAgnos) > 1)
			{
				$agnoInicio =  $agnosId[0];
				$agnoFin = $agnosId[1];	
			}
			else
			{
				$agnoInicio =  $agnosId[0];
				$agnoFin = $agnosId[0];	
			}


			for ($i = $agnoInicio; $i <= $agnoFin; $i++) {
				$agnos[] = $i;
			}
		}


		$abonadosPorAgnos = $this->Subscriber->find("all", array(
			"conditions"=>array(
				"Subscriber.company_id"=>$this->request->data["Operadores"],
				"Subscriber.year_id"=>$agnos,
			),
			"fields"=>array(
				"Subscriber.company_id", 
				"Subscriber.year_id",
				"Subscriber.month_id",
				"Subscriber.cantidad_abonados",
				"Subscriber.channel_id",
				"Subscriber.link_id",
				"Subscriber.signal_id",
				"Subscriber.payment_id",
			),
			"recursive"=>-1
		));

		$abonadosMesAgnos = "";
		foreach($abonadosPorAgnos as $abonadosPorAgno)
		{
			$abonadosMesAgnos
				[$abonadosPorAgno["Subscriber"]["company_id"]]
				[$abonadosPorAgno["Subscriber"]["year_id"]]
				[$abonadosPorAgno["Subscriber"]["month_id"]]
				[$abonadosPorAgno["Subscriber"]["channel_id"]]
				[$abonadosPorAgno["Subscriber"]["link_id"]]
				[$abonadosPorAgno["Subscriber"]["signal_id"]]
				[$abonadosPorAgno["Subscriber"]["payment_id"]] = $abonadosPorAgno["Subscriber"]["cantidad_abonados"];
		}

		$abonadoClonado = "";

		foreach($abonadosMesAgnos as $keyEmpresa => $abonadosMesAgno)
		{	
			foreach($abonadosMesAgno as $keyAgnos => $abonadosMes)
			{
				foreach($abonadosMes as $keyMeses => $abonados)
				{
					foreach($abonados as $keyCanal => $abonado)
					{
						foreach($abonado as $keyLink => $abonadosLink)
						{
							foreach($abonadosLink as $keySignal => $abonadosSignal)
							{
								foreach($abonadosSignal as $keyTipoSegnal => $abonadoTipoSegnal)
								{
									if(!empty($keyMeses) && empty($abonadoTipoSegnal))
									{
										if($keyMeses != 1)
										{
											$abonadoClonado = $abonadosMes[$keyMeses -1][$keyCanal][$keyLink][$keySignal][$keyTipoSegnal];
											if(!empty($abonadoClonado))
											{
												$final = $abonadoClonado;
											}
											$abonadosMesAgnos[$keyEmpresa][$keyAgnos][$keyMeses][$keyCanal][$keyLink][$keySignal][$keyTipoSegnal] = $final;
											
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$meses = $this->Month->find("list", array("fields"=>array("Month.id", "Month.nombre"), "recirsive"=>-1));
		$agnosTodos = $this->Year->find("list", array("fields"=>array("Year.id", "Year.nombre"), "recirsive"=>-1));
		$empresas = $this->Company->find("list", array("conditions"=>array("Company.company_type_id"=>1), "fields"=>array("Company.id", "Company.razon_social"), "recirsive"=>-1));
		$canal = $this->Channel->find("list", array("fields"=>array("Channel.id", "Channel.nombre"), "recirsive"=>-1));

		$totalAbonadosPorMes = "";
		foreach($abonadosMesAgnos as $keyEmpresas => $salidaAbonadosMesAgno)
		{
			foreach($salidaAbonadosMesAgno as $keyAgnos => $salidaAbonadosMes)
			{
				foreach($salidaAbonadosMes as $keyMeses => $salidaAbonados)
				{
					foreach($salidaAbonados as $keyCanal => $salidaAbonado)
					{
						foreach($salidaAbonado as $keyLink => $salidaAbonadosLink)
						{
							foreach($salidaAbonadosLink as $keySignal => $salidaAbonadosSignal)
							{
								$totalAbonadosPorMes[$agnosTodos[$keyAgnos]][$empresas[$keyEmpresas]][$meses[$keyMeses]][$canal[$keyCanal]][] = array_sum($salidaAbonadosSignal);
							}
						}
					}
				}
			}
		}

		$abonadosPresupuestados = $this->BudgetedSubscriber->find("all", array(
			"conditions"=>array(
				"BudgetedSubscriber.company_id"=>$this->request->data["Operadores"], 
				"BudgetedSubscriber.year_id"=>$agnos,
			),
			"fields"=>array(
				"BudgetedSubscriber.month_id",
				"BudgetedSubscriber.year_id",
				"BudgetedSubscriber.company_id",
				"BudgetedSubscriber.channel_id",
				"BudgetedSubscriber.presupuesto",
			),
			"recursive"=> -1
		));

		$salidaAbonadosPresupuestado = "";
		foreach($abonadosPresupuestados as $abonadosPresupuestadosAgnos)
		{	
			$salidaAbonadosPresupuestado
				[$agnosTodos[$abonadosPresupuestadosAgnos["BudgetedSubscriber"]["year_id"]]]
				[$empresas[$abonadosPresupuestadosAgnos["BudgetedSubscriber"]["company_id"]]]
				[$meses[$abonadosPresupuestadosAgnos["BudgetedSubscriber"]["month_id"]]]
				[$canal[$abonadosPresupuestadosAgnos["BudgetedSubscriber"]["channel_id"]]][] = $abonadosPresupuestadosAgnos["BudgetedSubscriber"]["presupuesto"];
		}
		
		$this->set("salidaAbonadosPresupuestado", $salidaAbonadosPresupuestado);
		$this->set("totalAbonadosPorMes", $totalAbonadosPorMes);
	}
}