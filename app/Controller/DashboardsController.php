<?php
App::uses('AppController', 'Controller');
class DashboardsController extends AppController {
	public function index($idMes = null, $idAgno = null) {
		//Configure::write('debug', 2);
		if($this->Session->Read("Users.flag") != 0)
		{
			
			/*if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}*/
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
	
		/*
		$this -> loadModel("Subscriber");
		
		if($idMes == null && $idAgno == null)
		{

			setlocale(LC_ALL,"es_ES");
			
			
			$mesPropuesto = $this->Subscriber->Month->find("all", array(
				'conditions'=>array('Month.nombre'=>ucwords(strftime("%B"))),
				'fileds'=>array('Month.id')
			));
			
			$agnoPropuesto = $this->Subscriber->Year->find("all", array(
				'conditions'=>array('Year.nombre'=>date("Y")),
				'fileds'=>array('Year.id')
			));
			
			//$this->set("agno", date("Y"));
			
			$idAgno = $agnoPropuesto[0]["Year"]["id"];

			$idMes = $mesPropuesto[0]["Month"]["id"] - 1;


			if($idMes == 0)
			{
				$idMes =  12;

				$idAgno = $agnoPropuesto[0]["Year"]["id"] - 1;
			}

		}


		if (!empty($idMes) && !empty($idAgno)) {

			$this->set("mes", $idMes);
			$this->set("agno", $idAgno);

			$this->loadModel("Email");

			$correosInformeAbonados = $this->Email->find("all", array(
				'conditions' => array('Email.informe' => "abonados"), 
				"fields" => array("Email.email")));
			$emailArray = "";

			foreach ($correosInformeAbonados as $correosInformeAbonado) {
				$emailArray[] = "'" . $correosInformeAbonado["Email"]["email"] . "'";
			}

			if (isset($correosInformeAbonados)) {
				$this->set("correosInformeAbonados", implode(",", $emailArray));
			}

			$abonadosPromedioRealArray = "";

			$meses = $this->Subscriber->Month->find("all", array());
			$agnos = $this->Subscriber->Year->find("all", array());
			$this->set("meses", $meses);
			$this->set("agnos", $agnos);
			//$this -> set("idEmpresa", $idEmpresa);

			$agnosArray = "";
			foreach ($agnos as $agno) {
				$agnosArray[$agno["Year"]["id"]] = $agno["Year"]["nombre"];
			}

			$mesesArray = "";

			foreach ($meses as $mese) {
				$mesesArray[$mese["Month"]["id"]] = $mese["Month"]["nombre"];
			}
			$this -> set("mesesArray", $mesesArray);
			$this -> set("agnosArray", $agnosArray);

			$mesLogo = $this->Subscriber->Month->find("all", array(
				'conditions' => array('Month.id' => $idMes), 
				'fileds' => array('Month.nombre')
			));

			$agnoLogo = $this->Subscriber->Year->find("all", array(
				'conditions' => array('Year.id' => $idAgno), 
				'fileds' => array('Year.nombre')
			));


			$this -> set("mesLogo", $mesLogo[0]["Month"]["nombre"]);
			$this -> set("agnoLogo", $agnoLogo[0]["Year"]["nombre"]);

			$this -> set("idMes", $idMes);
			$this -> set("idAgno", $idAgno);
			
			if ($idMes == 1) {
				$mesAnterior = 12;

				if ($idAgno == 1 && $idMes == 1) {
					$agnoAnterior = $idAgno;
					$mesAnterior = 1;
				} else {
					$agnoAnterior = $idAgno - 1;
				}

				#datos de Entrada para la generacion del informe;
				$mesesPedidos = array($mesAnterior, $idMes);
				$agnosPedidos = array($agnoAnterior, $idAgno);
				$this -> set("agnosPedidos", $agnosPedidos);
				$this -> set("mesesPedidos", $mesesPedidos);
			} else {
				$mesAnterior = $idMes - 1;
				$agnoAnterior = $idAgno;

				#datos de Entrada para la generacion del informe;
				$mesesPedidos = array($mesAnterior, $idMes);
				$agnosPedidos = array($idAgno);
				$this -> set("agnosPedidos", $agnosPedidos);
				$this -> set("mesesPedidos", $mesesPedidos);
			}

			$this -> set("agnosPedidos", $agnosPedidos);
			$this -> set("mesesPedidos", $mesesPedidos);

			$inicio = 1;
			for ($i = 1; $i <= $idMes; $i++) {
				$mesePromedio[] = $i;
			}


			foreach ($meses as $key => $mes) {
				if(isset($mesePromedio))
				{
					if (reset($mesePromedio) == $mes["Month"]["id"]) {
						$primerMes = $mes["Month"]["nombre"];
					}	

					if (end($mesePromedio) == $mes["Month"]["id"]) {
						$ultimoMesMes = $mes["Month"]["nombre"];
					}
				}
				
			}
			#Años promedio

			foreach ($agnos as $agno) {
				if ($agno["Year"]["id"] == end($agnosPedidos)) {
					$agnoPromedio = $agno["Year"]["nombre"];
					$agnoPromedioId = $agno["Year"]["id"];
				}
			}

			$abonados = $this->Subscriber->find('all', array(
				'conditions' => array("Subscriber.year_id" => $idAgno), 
				'recursive' => 2)
			);

			$operadores = $this->Subscriber->Company->find("all");
			
			$this-> loadModel("BudgetedSubscriber");
			$abonadosPresupuestados = $this->BudgetedSubscriber->find('all', array(
				'conditions' => array(
					'BudgetedSubscriber.year_id' =>$idAgno, 
					//'BudgetedSubscriber.month_id' => $mesesPedidos
				) //'BudgetedSubscriber.company_id' => $idOperadoresAgrupadosArray//
			));
			
			$opeadoresNoAgrupadosArray = "";
			foreach($operadores as $key => $nombreOperador)
			{
				$opeadoresNoAgrupadosArray[$nombreOperador["Company"]["id"]] = $nombreOperador["Company"]["id"];
			}
			
			$abonadosMesArray = "";
			foreach($abonados as $abonado)
			{
				if($abonado["Company"]["activo"] == 0 || $abonado["Company"]["activo"] == 1)
				{
					$abonadosMesArray[$abonado["Channel"]["id"]][$abonado["Year"]["id"]][$abonado["Month"]["id"]][$abonado["Company"]["id"]][] = $abonado["Subscriber"]["cantidad_abonados"];
				}
			}
			
			$canales = $this->Subscriber->Channel->find("all");
			
			$canalesArray = "";
			foreach($canales as $canale)
			{
				$canalesArray[$canale["Channel"]["id"]] = $canale["Channel"]["id"]; 
			}
			$valoresMesesAbonados = "";
			$mesesAnterioresBasicos = "";
			$mesesClonadosBasicos = "";
			
			foreach($abonadosMesArray as $key => $abonadosMeses)
			{
				//if($key == "1")
				//{
					foreach($agnos as $agno)
					{
						foreach($meses as $mese)
						{
							if(isset($abonadosMeses[$agno["Year"]["id"]][$mese["Month"]["id"]]))
							{
								foreach($opeadoresNoAgrupadosArray as $opeadoresNoAgrupados)
								{
									if(isset($abonadosMeses[$agno["Year"]["id"]][$mese["Month"]["id"]][$opeadoresNoAgrupados]))
									{
										foreach($abonadosMeses[$agno["Year"]["id"]][$mese["Month"]["id"]][$opeadoresNoAgrupados] as $posicionKey => $valorAbonado)
										{
											if(empty($valorAbonado))
											{
												if($posicionKey > 0)
												{
													$mesAnterior = $mese["Month"]["id"] - 1;
													
													if(!empty($abonadosMeses[$agno["Year"]["id"]][$mesAnterior][$opeadoresNoAgrupados][$posicionKey]))
													{
														$mesesAnterioresBasicos[$mese["Month"]["id"]] = $abonadosMeses[$agno["Year"]["id"]][$mesAnterior][$opeadoresNoAgrupados][$posicionKey];
													}
													else
													{
														$mesesAnterioresBasicos[] = $abonadosMeses[$agno["Year"]["id"]][$mese["Month"]["id"]][$opeadoresNoAgrupados][$posicionKey] = $mesesAnterioresBasicos[$mese["Month"]["id"] - 1];
													}
												}
											}
											$mesesClonadosBasicos[$key][$agno["Year"]["id"]] = $mesesAnterioresBasicos;
											$abonadosMesesBasicos[$key][$agno["Year"]["id"]][$mese["Month"]["id"]][]  =  $valorAbonado;
										}
									}
								}
							}
						}
					}
				//}
			}
			$presupuestadosBasicos = "";
			foreach($abonadosPresupuestados as $abonadosPresupuestados)
			{
				if($abonadosPresupuestados["BudgetedSubscriber"]["channel_id"] == 1)
				{
					$presupuestadosBasicos[$abonadosPresupuestados["BudgetedSubscriber"]["year_id"]][$abonadosPresupuestados["BudgetedSubscriber"]["month_id"]][] = $abonadosPresupuestados["BudgetedSubscriber"]["presupuesto"];
				}
				
				if($abonadosPresupuestados["BudgetedSubscriber"]["channel_id"] == 2)
				{
					$presupuestadosPremium[$abonadosPresupuestados["BudgetedSubscriber"]["year_id"]][$abonadosPresupuestados["BudgetedSubscriber"]["month_id"]][] = $abonadosPresupuestados["BudgetedSubscriber"]["presupuesto"];
				}
				
				if($abonadosPresupuestados["BudgetedSubscriber"]["channel_id"] == 3)
				{
					$presupuestadosHd[$abonadosPresupuestados["BudgetedSubscriber"]["year_id"]][$abonadosPresupuestados["BudgetedSubscriber"]["month_id"]][] = $abonadosPresupuestados["BudgetedSubscriber"]["presupuesto"];
				}
				
			}


			$this->set("agnos", $agnos);
			$this->set("meses", $meses);
			$this->set("abonadosMesesBasicos", $abonadosMesesBasicos);
			$this->set("mesesClonadosBasicos", $mesesClonadosBasicos);
			$this->set("presupuestadosBasicos", $presupuestadosBasicos);
			$this->set("presupuestadosPremium", $presupuestadosPremium);
			$this->set("presupuestadosHd", $presupuestadosHd);

		}
		*/
	}
	 public function bienvenida(){
		 if($this->Session->Read("Users.flag") != 0)
		{
			
			/*if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}*/
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
	 }

}
?>