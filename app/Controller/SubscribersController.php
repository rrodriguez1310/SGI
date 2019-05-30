<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
//App::import("Vendor", "dompdf", array("file" => "dompdf" . DS . "dompdf_config.inc.php"));
/**
 * Subscribers Controller
 *
 * @property Subscriber $Subscriber
 * @property PaginatorComponent $Paginator
 */
class SubscribersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'RequestHandler');
	//public $components = array('Mpdf.Mpdf'); 

/**
 * index method
 *
 * @return void
 */
 
	public function index($id = null, $agnoNombre = null) {

		$this->layout = "angular";
		//Configure::write("debug",2);
		
		(substr($this->referer(), -9) == "companies") ?	$this->Session->Write("Accesos", array("accesoPagina"=>1)) : "";
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
	
		if($this->Session->read('Users.flag') == 1)
		{
			if($id)
			{
				
				$this->set("idEmpresa", $id);
			}
			else 
			{
				$this->Session->setFlash("Seleccione un operador", "msg_fallo");
				return $this->redirect(array('controller'=>'companies', 'action' => 'index'));
			}
			
			$agnos = $this->Subscriber->Year->find("all", array());
			
			$this->set("agnos", $agnos);
			
			$idAgno = "";
			$valorAgno = "";
			foreach($agnos as $agno)
			{
				if(isset($agnoNombre))
				{
					$valorAgno = $agnoNombre;		
				}
				else
				{
					$valorAgno = date('Y');
				}
				
				if($valorAgno == $agno["Year"]["nombre"])
				{
					$idAgno = $agno["Year"]["id"];
				}
			}
			
			
			if(isset($agnoNombre))
			{
				$this->set("nombreAgno", $agnoNombre);
			}
			else
			{
				$this->set("nombreAgno", date('Y'));
			}
			
			$this->set("agno", $idAgno);
			
			
			$meses = $this->Subscriber->Month->find('all');
			
			$arrayMeses = array();
			
			foreach($meses as $mese)
			{
				foreach($mese as $valor)
				{
					$arrayMeses[] = $valor;
				}
			}
			
			$this->set("arrayMeses", $arrayMeses);
			
			$abonados = $this->Subscriber->find('all', array(
				'conditions'=>array('Subscriber.company_id'=>$id, "Subscriber.year_id"=>$idAgno),
				'order'=>array("Subscriber.created DESC"),
			));
			//pr($abonados);exit;
			
			$valorAbonado = array();
			foreach($abonados as $key => $valor)
			{
				$valorAbonado[$valor["Subscriber"]["month_id"]][$valor["Subscriber"]["channel_id"]][$valor["Subscriber"]["link_id"]][$valor["Subscriber"]["signal_id"]][$valor["Subscriber"]["payment_id"]] = array("Id"=>$valor["Subscriber"]["id"], "Abonados"=>$valor["Subscriber"]["cantidad_abonados"]);
			}
			//pr($valorAbonado);exit;
			$this->set("valorAbonado", $valorAbonado);
			
			$this->loadModel("CompaniesAttribute");
			$serviciosContratados = $this->CompaniesAttribute->find("all", array(
				'conditions'=>array('CompaniesAttribute.company_id'=>$id),
			));
			
			if(isset($serviciosContratados ) && !empty($serviciosContratados))
			{				
				if($serviciosContratados[0]["Company"]["nombre"])
				{
					$this->set('nombreEmpresa', $serviciosContratados[0]["Company"]["nombre"]);
				}
				
				$itemsData = array();
				//$canales = array();
				
				foreach($serviciosContratados as  $serviciosContratado)
				{
					$canales[] =  unserialize($serviciosContratado["CompaniesAttribute"]["channel_id"]);
					$enlaces[] =  unserialize($serviciosContratado["CompaniesAttribute"]["link_id"]);
					$segnal[] =  unserialize($serviciosContratado["CompaniesAttribute"]["signal_id"]);
					$pagos[] = unserialize($serviciosContratado["CompaniesAttribute"]["payment_id"]);	
				}
				
				$datosFinales = array($canales);
				
				$this->loadModel("Channel");
				$this->loadModel("Link");
				$this->loadModel("Signal");
				$this->loadModel("Payment");
				
				$muestraCanales = $this->Channel->find("all");
				$muestraEnlaces = $this->Link->find("all");
				$muestraSignal = $this->Signal->find("all");
				$muestraPagos = $this->Payment->find("all");
				
				$canalesArray = array();
				$enlacesArray = array();
				$signalArray = array();	
				$pagosArray = array();
				
				$atributosEmpresas = array();		
				
				
				foreach($muestraCanales as $muestraCanale)
				{
					$canalesArray[$muestraCanale["Channel"]["id"]] = $muestraCanale["Channel"]["nombre"];
				}
	
	
				$this->set('canalesArray', $canalesArray);
				
				foreach($muestraEnlaces as $muestraEnlace)
				{
					$enlacesArray[$muestraEnlace["Link"]["id"]] = $muestraEnlace["Link"]["nombre"];
				}
	
				$this->set("enlacesArray", $enlacesArray);
				
				foreach($muestraSignal as $muestraSigna)
				{
					$signalArray[$muestraSigna["Signal"]["id"]] = $muestraSigna["Signal"]["nombre"];
				}
				$this->set("signalArray", $signalArray);
				
				foreach($muestraPagos as $muestraPago)
				{
					$pagosArray[$muestraPago["Payment"]["id"]] = $muestraPago["Payment"]["nombre"];
				}
				
				$this->set("pagosArray", $pagosArray);
				
	
				
				foreach($canales as $key => $valor)
				{
					foreach($valor as $valo)
					{
						$atributosEmpresas[$canalesArray[$valo]][] = array("Canales"=>$valor, "Enlaces"=>$enlaces[$key], "Segnal"=>$segnal[$key], "Pagos"=>$pagos[$key]);
					}
				}
				
	
				$this->set("atributosEmpresas", $atributosEmpresas);
			}
			else
			{
				$this->Session->setFlash("Operadro", "msg_fallo");
				return $this->redirect(array('controller'=>'companies', 'action' => 'index'));	
			}
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller"=>'users', "action"=>'login'));
		}
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
 
	public function view($id = null) {
		
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		if($this->Session->read('Users.flag') == 1)
		{	
			if (!$this->Subscriber->exists($id)) {
				throw new NotFoundException(__('Invalid subscriber'));
			}
			$options = array('conditions' => array('Subscriber.' . $this->Subscriber->primaryKey => $id));
			$this->set('subscriber', $this->Subscriber->find('first', $options));
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller"=>'users', "action"=>'login'));
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->params->isAjax != 1)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		$this->request->data["Subscriber"]["id"] = $this->params->data["id"];
		$this->request->data["Subscriber"]["company_id"] = $this->params->data["idEmpresa"];
		$this->request->data["Subscriber"]["channel_id"] = $this->params->data["pk"];
		$this->request->data["Subscriber"]["year_id"] = $this->params->data["agnoId"];
		$this->request->data["Subscriber"]["month_id"] = $this->params->data["mesId"];
		$this->request->data["Subscriber"]["cantidad_abonados"] = $this->params->data["value"];
		$this->request->data["Subscriber"]["link_id"] = $this->params->data["enlaceId"];
		$this->request->data["Subscriber"]["signal_id"] = $this->params->data["segnalId"];
		$this->request->data["Subscriber"]["payment_id"] = $this->params->data["pagosId"];
		
		$estado = "";
		if ($this->params->data) {
			$this->Subscriber->create();
			if ($this->Subscriber->save($this->request->data)) {
				$estado = 1;
				
				if(isset($this->params->data["mesId"]) && isset($this->params->data["agnoId"]))
				{
					setlocale(LC_ALL,"es_ES");
					$mesPropuesto = $this->Subscriber->Month->find("all", array(
						'conditions'=>array('Month.nombre'=>ucwords(strftime("%B"))),
						'fileds'=>array('Month.id')
					));
					$mesActivo = $mesPropuesto[0]["Month"]["id"] - 1;
					
					if($mesActivo == $this->params->data["mesId"])
					{
						$estado = 2;
					}
					
				}
			} else {
				$estado = 0;	
			}
		}
		 echo $estado;
		 exit;
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
 
	public function edit($id = null) {
			
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
			
		if($this->Session->read('Users.flag') == 1)
		{	
			if (!$this->Subscriber->exists($id)) {
				throw new NotFoundException(__('Invalid subscriber'));
			}
			if ($this->request->is(array('post', 'put'))) {
				if ($this->Subscriber->save($this->request->data)) {
					$this->Session->setFlash(__('The subscriber has been saved.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The subscriber could not be saved. Please, try again.'));
				}
			} else {
				$options = array('conditions' => array('Subscriber.' . $this->Subscriber->primaryKey => $id));
				$this->request->data = $this->Subscriber->find('first', $options);
			}
			$companies = $this->Subscriber->Company->find('list');
			$years = $this->Subscriber->Year->find('list');
			$months = $this->Subscriber->Month->find('list');
			$this->set(compact('companies', 'years', 'months'));
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller"=>'users', "action"=>'login'));
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		if($this->Session->read('Users.flag') == 1)
		{
			$this->Subscriber->id = $id;
			if (!$this->Subscriber->exists()) {
				throw new NotFoundException(__('Invalid subscriber'));
			}
			$this->request->allowMethod('post', 'delete');
			if ($this->Subscriber->delete()) {
				$this->Session->setFlash(__('The subscriber has been deleted.'));
			} else {
				$this->Session->setFlash(__('The subscriber could not be deleted. Please, try again.'));
			}
			return $this->redirect(array('action' => 'index'));
		}
		else
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller"=>'users', "action"=>'login'));
		}
	}

	//pdf
	public function view_pdf($id = null, $agnoNombre = null) {
	
		
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		if($id)
		{
			
			$this->set("idEmpresa", $id);
		}
		else 
		{
			$this->Session->setFlash("Seleccione un operador", "msg_fallo");
			return $this->redirect(array('controller'=>'companies', 'action' => 'index'));
		}
		
		$agnos = $this->Subscriber->Year->find("all", array());
		
		$this->set("agnos", $agnos);
		
		$idAgno = "";
		$valorAgno = "";
		foreach($agnos as $agno)
		{
			if(isset($agnoNombre))
			{
				$valorAgno = $agnoNombre;		
			}
			else
			{
				$valorAgno = date('Y');
			}
			
			if($valorAgno == $agno["Year"]["nombre"])
			{
				$idAgno = $agno["Year"]["id"];
			}
		}
		
		
		if(isset($agnoNombre))
		{
			$this->set("nombreAgno", $agnoNombre);
		}
		else
		{
			$this->set("nombreAgno", date('Y'));
		}
		
		$this->set("agno", $idAgno);
		
		
		$meses = $this->Subscriber->Month->find('all');
		
		$arrayMeses = array();
		
		foreach($meses as $mese)
		{
			foreach($mese as $valor)
			{
				$arrayMeses[] = $valor;
			}
		}
		
		$this->set("arrayMeses", $arrayMeses);
		
		$abonados = $this->Subscriber->find('all', array(
			'conditions'=>array('Subscriber.company_id'=>$id, "Subscriber.year_id"=>$idAgno),
			'order'=>array("Subscriber.created DESC"),
		));
		
		$valorAbonado = array();
		foreach($abonados as $key => $valor)
		{
			$valorAbonado[$valor["Subscriber"]["month_id"]][$valor["Subscriber"]["channel_id"]] = array("Id"=>$valor["Subscriber"]["id"], "Abonados"=>$valor["Subscriber"]["cantidad_abonados"]);
		}
		
		
		$this->set("valorAbonado", $valorAbonado);
		
		$this->loadModel("CompaniesAttribute");
		$serviciosContratados = $this->CompaniesAttribute->find("all", array(
			'conditions'=>array('CompaniesAttribute.company_id'=>$id),
		));
		
		if(!empty($serviciosContratados))
		{
			if($serviciosContratados[0]["Company"]["nombre"])
			{
				$this->set('nombreEmpresa', $serviciosContratados[0]["Company"]["nombre"]);
			}
		
			$itemsData = array();
			//$canales = array();
			
			foreach($serviciosContratados as  $serviciosContratado)
			{
				$canales[] =  unserialize($serviciosContratado["CompaniesAttribute"]["channel_id"]);
				$enlaces[] =  unserialize($serviciosContratado["CompaniesAttribute"]["link_id"]);
				$segnal[] =  unserialize($serviciosContratado["CompaniesAttribute"]["signal_id"]);
				$pagos[] = unserialize($serviciosContratado["CompaniesAttribute"]["payment_id"]);	
			}
			
			$datosFinales = array($canales);
			
			$this->loadModel("Channel");
			$this->loadModel("Link");
			$this->loadModel("Signal");
			$this->loadModel("Payment");
			
			$muestraCanales = $this->Channel->find("all");
			$muestraEnlaces = $this->Link->find("all");
			$muestraSignal = $this->Signal->find("all");
			$muestraPagos = $this->Payment->find("all");
			
			$canalesArray = array();
			$enlacesArray = array();
			$signalArray = array();	
			$pagosArray = array();
			
			$atributosEmpresas = array();		
			
			
			foreach($muestraCanales as $muestraCanale)
			{
				$canalesArray[$muestraCanale["Channel"]["id"]] = $muestraCanale["Channel"]["nombre"];
			}


			$this->set('canalesArray', $canalesArray);
			
			foreach($muestraEnlaces as $muestraEnlace)
			{
				$enlacesArray[$muestraEnlace["Link"]["id"]] = $muestraEnlace["Link"]["nombre"];
			}

			$this->set("enlacesArray", $enlacesArray);
			
			foreach($muestraSignal as $muestraSigna)
			{
				$signalArray[$muestraSigna["Signal"]["id"]] = $muestraSigna["Signal"]["nombre"];
			}
			$this->set("signalArray", $signalArray);
			
			foreach($muestraPagos as $muestraPago)
			{
				$pagosArray[$muestraPago["Payment"]["id"]] = $muestraPago["Payment"]["nombre"];
			}
			
			$this->set("pagosArray", $pagosArray);
			

			
			foreach($canales as $key => $valor)
			{
				$atributosEmpresas[] = array("Canales"=>$valor, "Enlaces"=>$enlaces[$key], "Segnal"=>$segnal[$key], "Pagos"=>$pagos[$key]);
			}

			$this->set("atributosEmpresas", $atributosEmpresas);
		}
		else
		{
			$this->Session->setFlash("Operadro", "msg_fallo");
			return $this->redirect(array('controller'=>'companies', 'action' => 'index'));	
		}
	}

	public function informe_abonados($promociones = null)
	{
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->params->isAjax != 1)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		$this->layout = "ajax";
		$meses = $this->Subscriber->Month->find("all", array());
		
		setlocale(LC_ALL,"es_ES");

		$mesPropuesto = $this->Subscriber->Month->find("first", array(
			'conditions'=>array('Month.nombre'=>ucwords(strftime("%B"))),
			'fields'=>array('Month.id')
		));
		
		$agnos = $this->Subscriber->Year->find("all", array('order'=> 'Year.id DESC'));
		$this->set("promociones", $promociones);
		$this->set('agnos', $agnos);
		$this->set('meses', $meses);
		$this->set('mesPedido', $mesPropuesto["Month"]["id"]);
	}
	
	public function enviar_informe_abonados($mesId = null, $agnoId = null, $idEmpresa = null)
	{	
		//pr($this->data["subscribers"]);exit;
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->request->is('post') != 1)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		$pathFile = WWW_ROOT . "files" . DS . "pdf" . DS . "informe_abonados.pdf";
		
		//App::import("Vendor", "dompdf", array("file" => "dompdf" . DS . "dompdf_config.inc.php"));
		
		if(!empty($this->data["subscribers"]["codigoHtml"]) && !empty($this->data["subscribers"]["mes"]) && !empty($this->data["subscribers"]["agno"]) && empty($this->data["subscribers"]["empresa"]))
		{
			//pr($this->data);exit;
			$email = explode(",", $this->data["subscribers"]["email"]);
			
			/*$html = utf8_decode($this->data["subscribers"]["codigoHtml"]);
			$this->dompdf = new DOMPDF();
			$papersize = "legal";
			$orientation = "landscape";
			$this->dompdf->load_html($html);
			$this->dompdf->set_paper($papersize, $orientation);
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents($pathFile, $output);*/

			$html = $this->data["subscribers"]["codigoHtml"];
			App::import("Vendor", "tcpdf", array("file" => "tcpdf" . DS . "tcpdf.php"));
			$this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "LETTER", true, 'UTF-8', false);
			$this->tcpdf->SetAuthor('Servicios de Televisión Canal del Fútbol Limitada');
			$this->tcpdf->setPrintHeader(false);
			$this->tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$this->tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$this->tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$this->tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$this->tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$this->tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$this->tcpdf->SetFontSize(10);
			$this->tcpdf->SetMargins(10,10,10, true);
			$this->tcpdf->setPageOrientation("L");
			$this->tcpdf->AddPage();
			$this->tcpdf->writeHTML($html, true, false, true, false, '');
			$this->tcpdf->Output($pathFile, "F");

			//Envia email con el informe de abonados;
			$nombreSubjet = explode('(', $this->data["subscribers"]["titulo"]);

			$Email = new CakeEmail("gmail");
			$Email->from(array('sgi@cdf.cl' => 'SGI'));
			$Email->to($email);
			$Email->subject($nombreSubjet[0]);
			$Email->emailFormat('html');
			$Email->template('themeEmail');
			$Email->attachments(array($pathFile));
			
			$Email->viewVars(array(
				"titulo"=>$nombreSubjet[0]
			));
			$Email->send();
			$this->Session->setFlash('El informe de abonado se envio correctamente', 'msg_exito');
			return $this->redirect(array("controller"=>"subscribers" , "action"=>isset($this->request->data["subscribers"]["promociones"]) ? 'genera_informe_abonado_pdf_promociones' : 'genera_informe_abonado_pdf', $this->data["subscribers"]["mes"], $this->data["subscribers"]["agno"]));	
		}
		
		if(!empty($this->data["subscribers"]["codigoHtml"]) && !empty($this->data["subscribers"]["mes"]) && !empty($this->data["subscribers"]["agno"]) && !empty($this->data["subscribers"]["empresa"]))
		{
			$pathFile = WWW_ROOT . "files" . DS . "pdf" . DS . "informe_abonados.pdf";
			App::import("Vendor", "dompdf", array("file" => "dompdf" . DS . "dompdf_config.inc.php"));
			
			$this->loadModel("Email");
			
			$correosInformeAbonados = $this->Email->find("all", array(
				'conditions'=>array('Email.informe'=>"abonados"),
				"fields"=>array("Email.email")
			));
			$email = "";
			
			foreach($correosInformeAbonados as $correosInformeAbonado)
			{
				$email[] = $correosInformeAbonado["Email"]["email"];
			}
			//pr($email);
			//pr($this->data);exit;
			
			/*$html = utf8_decode($this->data["subscribers"]["codigoHtml"]);
			$this->dompdf = new DOMPDF();
			$papersize = "legal";
			$orientation = "landscape";
			$this->dompdf->load_html($html);
			$this->dompdf->set_paper($papersize, $orientation);
			$this->dompdf->render();
			$output = $this->dompdf->output();
			file_put_contents($pathFile, $output);*/

			$html = $this->data["subscribers"]["codigoHtml"];
			App::import("Vendor", "tcpdf", array("file" => "tcpdf" . DS . "tcpdf.php"));
			$this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "LETTER", true, 'UTF-8', false);
			$this->tcpdf->SetAuthor('Servicios de Televisión Canal del Fútbol Limitada');
			$this->tcpdf->setPrintHeader(false);
			$this->tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$this->tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$this->tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$this->tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$this->tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$this->tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$this->tcpdf->SetFontSize(10);
			$this->tcpdf->SetMargins(10,10,10, true);
			$this->tcpdf->setPageOrientation("L");
			$this->tcpdf->AddPage();
			$this->tcpdf->writeHTML($html, true, false, true, false, '');
			$this->tcpdf->Output($pathFile, "F");
			
			//Envia email con el informe de abonados;
			
			$Email = new CakeEmail("gmail");
			$Email->from(array('sgi@cdf.cl' => 'SGI'));
			$Email->to($email);
			$Email->subject($this->data["subscribers"]["titulo"]);
			$Email->emailFormat('html');
			$Email->template('themeEmail');
			$Email->attachments(array($pathFile));
			
			$Email->viewVars(array(
				"titulo"=>$this->data["subscribers"]["titulo"],
			));
			$Email->send();
			$this->Session->setFlash('El informe de abonado se envio correctamente', 'msg_exito');
			return $this->redirect(array("controller"=>"subscribers" , "action"=>'index', $this->data["subscribers"]["empresa"]));
		}
		

	}

	public function informe_abonado_pdf()
	{
		
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->request->is('post') != 1)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		
		$this->layout = "ajax";
		$pathFile = WWW_ROOT . "files" . DS . "pdf" . DS . "informe_abonado_pdf.pdf";
		App::import("Vendor", "dompdf", array("file" => "dompdf" . DS . "dompdf_config.inc.php"));
		$html = utf8_decode($this->data["subscribers"]["codigoHtmlPdf"]);
		$this->dompdf = new DOMPDF();
		$papersize = "legal";
		$orientation = "landscape";
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper($papersize, $orientation);
		$this->dompdf->render();
		$output = $this->dompdf->output();
		file_put_contents($pathFile, $output);
		return $this->redirect("/files" . DS . "pdf" . DS . "informe_abonado_pdf.pdf");
	}

	public function lista_graficos()
	{
		$this->layout = "ajax";


		$this->loadModel("Year");
		$fechasArray = "";
		$fechaFin = $this->params->query["getFecha"];
		

		for($i=13;$i>=1;$i--){
			$fechasArray[] = explode("-", date('Y-m-j', strtotime('-'.$i.' month', strtotime($fechaFin))));
		}
		$fechasArray[] = explode("-", $this->params->query["getFecha"]);
		
		//pr($fechasArray);

		$agnoMesesArray = "";
		$agnosNombres = "";

		foreach($fechasArray as $key => $fechaArray)
		{
			if(substr($fechaArray[1], 0, 1) == 0)
			{
				$mes = substr($fechaArray[1],1);
			}
			else
			{
				$mes = $fechaArray[1];
			}
			$agnosNombres[$fechaArray[0]] = $fechaArray[0]; 
			$agnoMesesArray[$fechaArray[0]][] = $mes;
		}


		$idAgno = $this->Year->find("all", array(
			"conditions"=>array("Year.nombre"=>$agnosNombres),
			"recursive"=>-1
		));

		$conditions = "";

		foreach($idAgno as $idAgnos)
		{
			$conditions[] = array("Subscriber.year_id"=>$idAgnos["Year"]["id"], "Subscriber.month_id"=>$agnoMesesArray[$idAgnos["Year"]["nombre"]]);
			$conditionsPresupuestados[] = array("BudgetedSubscriber.year_id"=>$idAgnos["Year"]["id"], "BudgetedSubscriber.month_id"=>$agnoMesesArray[$idAgnos["Year"]["nombre"]]);
		}


		$abonados = $this->Subscriber->find("all", array(
			"conditions"=>array('OR'=>$conditions),
		));

		$this->loadModel("BudgetedSubscriber");

		$abonadosPresupueastados = $this->BudgetedSubscriber->find("all", array(
			"conditions"=>array('OR'=>$conditionsPresupuestados),
		));

		$directvPresupuestado= "";
		$otrosPresupuestado = "";
	


		foreach($abonadosPresupueastados as $key => $abonadosPresupueastado)
		{
			
			if($abonadosPresupueastado["Company"]["nombre"] == "DirecTV" || $abonadosPresupueastado["Company"]["nombre"] == "Telefónica Empresas Chile S.A." || $abonadosPresupueastado["Company"]["nombre"] == "Claro Comunicaciones" || $abonadosPresupueastado["Company"]["nombre"] == "VTR" || $abonadosPresupueastado["Company"]["nombre"] == "Entel" || $abonadosPresupueastado["Company"]["nombre"] == "GTD" || $abonadosPresupueastado["Company"]["nombre"] == "Telsur")
			{
				$directvPresupuestado[$abonadosPresupueastado["Year"]["nombre"]][$abonadosPresupueastado["Month"]["nombre"]][$abonadosPresupueastado["Company"]["nombre"]][ $abonadosPresupueastado["Channel"]["nombre"]][$abonadosPresupueastado["BudgetedSubscriber"]["id"]] = $abonadosPresupueastado["BudgetedSubscriber"]["presupuesto"];
			}
			else
			{
				$otrosPresupuestado[$abonadosPresupueastado["Year"]["nombre"]][$abonadosPresupueastado["Month"]["nombre"]][ $abonadosPresupueastado["Channel"]["nombre"]][] = $abonadosPresupueastado["BudgetedSubscriber"]["presupuesto"];	
			}
			
			
		}


		$otrosJson = "";
		$directvJson = "";
		$xxx = "";

		foreach($directvPresupuestado as $agno => $directvPresupuestadoAgno)
		{
			foreach($directvPresupuestadoAgno as $mes => $directvPresupuestadoMes)
			{
				foreach($directvPresupuestadoMes as $operador => $directvPresupuestadoOperador)
				{
					foreach($directvPresupuestadoOperador as $segnal => $directvPresupuestadoSegnal)
					{
						$directvJson[$agno][$mes][$operador][$segnal]["presupuestados"] = array("totalAbonadoPresupuestados" => array_sum($directvPresupuestadoSegnal));
					}

				}
			}
		}

		foreach($otrosPresupuestado as $agno => $otrosAbonadosPresupuestadosAgno)
		{
			foreach($otrosAbonadosPresupuestadosAgno as $mes => $otrosAbonadosPresupuestadosMes)
			{
				foreach($otrosAbonadosPresupuestadosMes as $segnal => $otrosAbonadosPresupuestadosSegnal)
				{
					$directvJson[$agno][$mes]["otrosPresupuestados"][$segnal][] = array("totalAbonado" => array_sum($otrosAbonadosPresupuestadosSegnal));
				}
			}
		}

		$directv= "";
		$otros = "";

		foreach($abonados as $key => $abonado)
		{
			if($abonado["Company"]["nombre"] == "DirecTV" || $abonado["Company"]["nombre"] == "Telefónica Empresas Chile S.A." || $abonado["Company"]["nombre"] == "Claro Comunicaciones" || $abonado["Company"]["nombre"] == "VTR" || $abonado["Company"]["nombre"] == "Entel" || $abonado["Company"]["nombre"] == "GTD" || $abonado["Company"]["nombre"] == "Telsur")
			{
				$directv[$abonado["Year"]["nombre"]][$abonado["Month"]["nombre"]][$abonado["Company"]["nombre"]][ $abonado["Channel"]["nombre"]][$abonado["Subscriber"]["id"]] = 
					$abonado["Subscriber"]["cantidad_abonados"];
			}
			else
			{
				$otrosAbonados[$abonado["Year"]["nombre"]][$abonado["Month"]["nombre"]][ $abonado["Channel"]["nombre"]][] = $abonado["Subscriber"]["cantidad_abonados"];	
			}
			
		}

		if(!empty($otrosAbonados))
		{
			foreach($otrosAbonados as $keyOtrosPenetraAgos => $otrosAbonadosPenetracion)
			{
				foreach($otrosAbonadosPenetracion as $keyOtrosPenetraMes => $otrosAbonadosPenetracionMes)
				{
					foreach($otrosAbonadosPenetracionMes as $keyOtrosPenetraSegnal => $otrosAbonadosPenetracionSegnal)
					{
						if($keyOtrosPenetraSegnal == "CDF Premium" || $keyOtrosPenetraSegnal == "CDF Basico" || $keyOtrosPenetraSegnal == "CDF HD")
						{
							if(!empty($otrosAbonadosPenetracionMes["CDF Premium"]) && !empty($otrosAbonadosPenetracionMes["CDF Basico"])  && $otrosAbonadosPenetracionMes["CDF HD"]  )
							{
								$directvJson[$keyOtrosPenetraAgos][$keyOtrosPenetraMes]["Otrospenetracion"] = array("penetracion"=>number_format(array_sum($otrosAbonadosPenetracionMes["CDF Premium"]) / array_sum($otrosAbonadosPenetracionMes["CDF Basico"]) * 100, 2, '.', '.'));
							}
						}
					}	
				}
			}

		}

		foreach($directv as $agno => $directvAgno)
		{
			foreach($directvAgno as $mes => $directvMes)
			{
				foreach($directvMes as $operador => $directvOerador)
				{
					foreach($directvOerador as $segnal => $directvSegnal)
					{
						
						if($segnal == "CDF Basico" || $segnal == "CDF Premium" || $segnal == "CDF HD")
						{

							$penetracion[$agno][$mes][$operador][$segnal][] = array("penetracion"=>array_sum($directvSegnal));
						}

						$directvJson[$agno][$mes][$operador][$segnal][] = array("totalAbonado" => array_sum($directvSegnal));
					}
				}
			}
		}

		foreach($otrosAbonados as $agno => $otrosAbonadosAgno)
		{
			foreach($otrosAbonadosAgno as $mes => $otrosAbonadosMes)
			{
				foreach($otrosAbonadosMes as $segnal => $otrosAbonadosSegnal)
				{
					$directvJson[$agno][$mes]["otros"][$segnal][] = array("totalAbonado" => array_sum($otrosAbonadosSegnal));
				}
			}
		}

		foreach($penetracion as $agno => $penetracionAbonados)
		{
			foreach($penetracionAbonados as $mes => $penetracionMes)
			{
				foreach($penetracionMes as $operador => $penetracionOperador)
				{ 
					//if($abonado["Company"]["nombre"] == "DirecTV" || $abonado["Company"]["nombre"] == "Movistar" || $abonado["Company"]["nombre"] == "Claro Comunicaciones" || $abonado["Company"]["nombre"] == "VTR" || $abonado["Company"]["nombre"] == "Entel" || $abonado["Company"]["nombre"] == "GTD" || $abonado["Company"]["nombre"] == "Telsur")
					//{ 
						if(isset($penetracionOperador["CDF Premium"][0]["penetracion"]) && isset($penetracionOperador["CDF HD"][0]["penetracion"]) && isset($penetracionOperador["CDF Basico"][0]["penetracion"]))
						{
							$directvJson[$agno][$mes][$operador]["penetracion"][] = array("penetracion"=>number_format(($penetracionOperador["CDF Premium"][0]["penetracion"] + $penetracionOperador["CDF HD"][0]["penetracion"]) / $penetracionOperador["CDF Basico"][0]["penetracion"] * 100, 2, '.', '.'));	
						}
					//}
				}	
			}	
		}

		/*
		foreach($penetracion as $keyAgno => $penetracionAgno)
		{
			foreach($penetracionAgno as $keyMes => $penetracionMes)
			{
				foreach($penetracionMes as $keyOperador => $penetracionOperador)
				{
					$directvJson[$keyAgno][$keyMes][$keyOperador][] = array("penetracion"=>number_format($penetracionOperador["CDF Premium"]["penetracion"] / $penetracionOperador["CDF Basico"]["penetracion"] * 100, 2, ',', '.'));
				}
			}
		}
		*/
		$this->set("directvJson", $directvJson);
	}


	public function lista_graficosx()
	{
		//Configure::write('debug', 1);
		$this->layout = "ajax";


		$this->loadModel("Year");
		$fechasArray = "";
		$fechaFin = $this->params->query["getFecha"];
		

		for($i=13;$i>=1;$i--){
			$fechasArray[] = explode("-", date('Y-m-j', strtotime('-'.$i.' month', strtotime($fechaFin))));
		}
		$fechasArray[] = explode("-", $this->params->query["getFecha"]);
		
		//pr($fechasArray);

		$agnoMesesArray = "";
		$agnosNombres = "";

		foreach($fechasArray as $key => $fechaArray)
		{
			if(substr($fechaArray[1], 0, 1) == 0)
			{
				$mes = substr($fechaArray[1],1);
			}
			else
			{
				$mes = $fechaArray[1];
			}
			$agnosNombres[$fechaArray[0]] = $fechaArray[0]; 
			$agnoMesesArray[$fechaArray[0]][] = $mes;
		}


		$idAgno = $this->Year->find("all", array(
			"conditions"=>array("Year.nombre"=>$agnosNombres),
			"recursive"=>-1
		));

		$conditions = "";

		foreach($idAgno as $idAgnos)
		{	
			$mesesAgnos[$idAgnos["Year"]["nombre"]] = $agnoMesesArray[$idAgnos["Year"]["nombre"]];
			
			$conditions[] = array("Subscriber.year_id"=>$idAgnos["Year"]["id"], "Subscriber.month_id"=>$agnoMesesArray[$idAgnos["Year"]["nombre"]]);

			$conditionsPresupuestados[] = array("BudgetedSubscriber.year_id"=>$idAgnos["Year"]["id"], "BudgetedSubscriber.month_id"=>$agnoMesesArray[$idAgnos["Year"]["nombre"]]);
		}

		$abonados = $this->Subscriber->find("all", array(
			"conditions"=>array('OR'=>$conditions),
		));

		$listaAbonados = "";

		foreach($abonados as $key => $abonado)
		{
			if($abonado["Company"]["alias"] == "DirecTV" || $abonado["Company"]["alias"] == "Movistar" || $abonado["Company"]["alias"] == "Claro Comunicaciones" || $abonado["Company"]["alias"] == "VTR" || $abonado["Company"]["nombre"] == "Entel" || $abonado["Company"]["alias"] == "GTD" || $abonado["Company"]["alias"] == "Telsur")
			{
				$listaAbonados[$abonado["Year"]["nombre"]][$abonado["Month"]["id"]][$abonado["Company"]["alias"]][ $abonado["Channel"]["nombre"]][] = 
					(isset($abonado["Subscriber"]["cantidad_abonados"]) ? $abonado["Subscriber"]["cantidad_abonados"] : 0);
			}
			else
			{
				$otrosAbonados[$abonado["Year"]["nombre"]][$abonado["Month"]["nombre"]][ $abonado["Channel"]["nombre"]][] = (isset($abonado["Subscriber"]["cantidad_abonados"]) ? $abonado["Subscriber"]["cantidad_abonados"] : 0);	
			}
		}

		foreach($mesesAgnos as $agno => $mesesAgnosMes)
		{
			foreach($mesesAgnosMes as $mes => $meses)
			{
				foreach($abonados as $abonado)
				{
					if($agno == $abonado["Year"]["nombre"])
					{
						if($meses == $abonado["Month"]["id"])
						{

							$datosReales[$agno][$meses][$abonado["Company"]["alias"]][$abonado["Channel"]["nombre"]][] = (isset($abonado["Subscriber"]["cantidad_abonados"]) ? $abonado["Subscriber"]["cantidad_abonados"] : 0);
						}
						else
						{
							$datosReales[$agno][$meses][$abonado["Company"]["alias"]][$abonado["Channel"]["nombre"]][] = 0;
						}
					}
				}
			}
		}
		
		$datosAbonados = "";
		$datosAbonadosPresupuestados = "";
		$datosAbonadosOtrosPenetracion = ""; 

		foreach($datosReales as $agno => $datosRealesAgnos)
		{
			foreach($datosRealesAgnos as $mes => $datosRealesMes)
			{
				foreach($datosRealesMes as $proveedor => $datosRealesProveedor)
				{
					foreach($datosRealesProveedor as $signal => $datosRealesAbonados)
					{
						if($proveedor == "DirecTV" || $proveedor == "Movistar" || $proveedor == "Claro Comunicaciones" || $proveedor == "VTR" || $proveedor == "Entel" || $proveedor == "GTD" || $proveedor == "Telsur")
						{
							$datosAbonados[$agno][$mes][$proveedor][$signal][] = array("abonados"=>array_sum($datosRealesAbonados));
							$datosAbonadosPenetracion[$agno][$mes][$proveedor][$signal][] = array("abonados"=>array_sum($datosRealesAbonados));
						}
						else
						{
							$datosAbonadosOtros[$agno][$mes]['otros'][$signal][] = array_sum($datosRealesAbonados);
							$datosAbonadosOtrosPenetracion[$agno][$mes]['otrosPenetracion'][$signal][] = array_sum($datosRealesAbonados);
						}
					}
				}
			}
		}
		
		//pr($datosAbonadosPenetracion);exit;


		foreach($datosAbonadosPenetracion as $agno => $datosAbonado)
		{
			foreach($datosAbonado as $mes => $datosAbonadoMes)
			{
				foreach ($datosAbonadoMes as $proveedor => $datosAbonadoSignal)
				{
					foreach ($datosAbonadoSignal as $signal => $datosAbonadoProveedorProveedor)
					{
						if($proveedor == "DirecTV" || $proveedor == "Movistar" || $proveedor == "Claro Comunicaciones" || $proveedor == "VTR" || $proveedor == "Entel" || $proveedor == "GTD" || $proveedor == "Telsur")
						{
							if(!empty($datosAbonadoSignal["CDF Premium"][0]["abonados"]) && !empty($datosAbonadoSignal["CDF Basico"][0]["abonados"]) && !empty($datosAbonadoSignal["CDF HD"][0]["abonados"]))
							{
								$datosAbonados[$agno][$mes]['penetracion'][$proveedor] = array("abonados"=>number_format(($datosAbonadoSignal["CDF Premium"][0]["abonados"] + $datosAbonadoSignal["CDF HD"][0]["abonados"]) / $datosAbonadoSignal["CDF Basico"][0]["abonados"] * 100, 2, '.', '.'));
							}
							else
							{
								$datosAbonados[$agno][$mes]['penetracion'][$proveedor] = array("abonados"=>0);
							}
						}
					}
				}
			}
		}
		
		foreach($datosAbonadosOtrosPenetracion as $agno => $datosAbonadosOtrosAgno)
		{
			foreach($datosAbonadosOtrosAgno as $mes => $datosAbonadosOtrosmes)
			{
				foreach($datosAbonadosOtrosmes as $operador => $datosAbonadosOtrosOperador)
				{
					foreach($datosAbonadosOtrosOperador as $signal => $datosAbonadosOtrosSignal)
					{
						if(isset($datosAbonadosOtrosOperador["CDF Premium"]) && isset($datosAbonadosOtrosOperador["CDF HD"]))
						{
							$datosAbonados[$agno][$mes]['otrosPenetracion'][$operador] = array("abonados"=>number_format((array_sum($datosAbonadosOtrosOperador["CDF Premium"]) + array_sum($datosAbonadosOtrosOperador["CDF HD"])) / array_sum($datosAbonadosOtrosOperador["CDF Basico"]) * 100, 2, '.', '.'));
						}
						else
						{
							$datosAbonados[$agno][$mes]['otrosPenetracion'][$operador] = array("abonados"=>0);
						}
						break;
					}
				}
			}
		}

		foreach($datosAbonadosOtros as $agno => $datosAbonadosOtrosAgno)
		{
			foreach($datosAbonadosOtrosAgno as $mes => $datosAbonadosOtrosmes)
			{
				foreach($datosAbonadosOtrosmes as $operador => $datosAbonadosOtrosOperador)
				{
					foreach($datosAbonadosOtrosOperador as $signal => $datosAbonadosOtrosSignal)
					{
						$datosAbonados[$agno][$mes]['otros'][$signal][] = array("abonados"=>array_sum($datosAbonadosOtrosSignal));
					}
				}
			}
		}

		$this->set("datosAbonados", $datosAbonados);
	}

	public function genera_informe_abonado_pdf($monthId = null, $yearId = null, $idEmpresa = null){
		
		$this->layout = "angular";
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		$this->genera_informe_abonado_pdf_data($monthId, $yearId, $idEmpresa);
		$this->presupuestados_ecdf($monthId, $yearId);
	}
	
	public function presupuestados_ecdf($monthId = null, $yearId = null){
       
         Configure::write('debug', 1); 
        
        $this->loadModel("BudgetedSubscriber");
        
        $presupuestado = $this->BudgetedSubscriber->find('all', array(
            'conditions'=>array(
                'BudgetedSubscriber.year_id'=>$yearId,
                'BudgetedSubscriber.month_id'=>array($monthId, $monthId - 1),
                'BudgetedSubscriber.company_id'=>1650
            ),
            'fields'=>array(
                'BudgetedSubscriber.id', 
                'BudgetedSubscriber.month_id', 
                'BudgetedSubscriber.year_id', 
                'BudgetedSubscriber.presupuesto',
                'BudgetedSubscriber.channel_id'
            ),
            'recursive'=>-1
        ));
        
        $salida = "";
        foreach($presupuestado as $key => $value){
            $salida[$value['BudgetedSubscriber']['channel_id']][] = array(
                'id'=> $value['BudgetedSubscriber']['id'],
                'month_id'=> $value['BudgetedSubscriber']['month_id'],
                'year_id'=> $value['BudgetedSubscriber']['year_id'],
                'presupuesto'=> $value['BudgetedSubscriber']['presupuesto'],
                'channel_id'=> $value['BudgetedSubscriber']['channel_id']
            );
        }
        $this->set("presupuestadosEcdf", $salida);
	}
	

	public function genera_informe_abonado_pdf_promociones($monthId = null, $yearId = null, $idEmpresa = null){
		
		$this->layout = "angular";
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this -> Session -> setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this -> Session -> setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		$this->genera_informe_abonado_pdf_data($monthId, $yearId, $idEmpresa,"promociones");
	}

	public function genera_informe_abonado_pdf_data($monthId, $yearId, $idEmpresa, $promociones = null){
        
		$this->loadModel("Channel");
		$this->loadModel("BudgetedSubscriber");
		$this->loadModel("SubscribersPromocione");
		$this->loadModel("Month");
		$this->loadModel("Year");
		$this->loadModel("Email");
		$this->Subscriber->Behaviors->load('Containable');
		$this->Subscriber->contain('Year');
		$this->BudgetedSubscriber->Behaviors->load('Containable');
		$this->BudgetedSubscriber->contain('Year');
		$this->SubscribersPromocione->Behaviors->load('Containable');
		$this->SubscribersPromocione->contain('Year');
		$this->Month->exists($monthId) ? null : $error[] = "mes";
		$this->Year->exists($yearId) ? null : $error[] = "año";
		$this->set("promociones", $promociones);
		if(!isset($error)){
			$this->set("idEmpresa", $idEmpresa);
			$correosInformeAbonados = $this->Email->find("list", array(
				'conditions'=>array('Email.informe'=>"abonados"),
				"fields"=>array("Email.id", "Email.email")
			));
			
			$this->set("correosInformeAbonados",array_values($correosInformeAbonados));
			$modelosConditions = ["Subscriber", "BudgetedSubscriber", "SubscribersPromocione"];
			$nombresCamposAbonados = ["Subscriber" => "cantidad_abonados", "BudgetedSubscriber" => "presupuesto", "SubscribersPromocione" => "cantidad_abonados"];
			if($monthId == 1){
				$monthIdAnterior = 12;
				if($yearId != 1){
					$yearIdAnterior = $yearId - 1;
					$mesesQuery = [$monthId, $monthIdAnterior];
					$aniosQuery = [$yearId, $yearIdAnterior];
					$anioMesesComprobar = [$yearIdAnterior=>[$monthIdAnterior], $yearId=>[$monthId]];
				}else{
					unset($monthIdAnterior);
					$mesesQuery = [$monthId];
					$aniosQuery = [$yearId];
					foreach ($modelosConditions as $modelo) {
						$conditions[$modelo] = [
							$modelo.".month_id" => $mesesQuery,
							$modelo.".year_id" => $aniosQuery,
						];
					}
					$anioMesesComprobar = [$yearId=>[$monthId]];
				}

			}else{
				$mesesQuery = [$monthId - 1, $monthId];
				$aniosQuery = [$yearId];
				$anioMesesComprobar = [$yearId=>$mesesQuery];
			}

			for ($mes=1; $mes <= $monthId ; $mes++) { 
				$anioMesesComprobarPromedio[$yearId][] = $mes;
			}

			$meses = $this->Month->find("list",[
				"fields" => [
					"Month.id", 
					"Month.nombre"
				],
				"recursive" => -1
			]);

			$anios = $this->Year->find("list",[
				"fields" => [
					"Year.id", 
					"Year.nombre"
				],
				"recursive" => -1
			]);
			$this->empresasAbonados();
			$anioMesMaximo = $anios[$yearId].((strlen((String)$monthId) == 1) ? "0".$monthId : $monthId);
			$querySubscriber = $this->Subscriber->find("all", [
				"conditions"=>array(
					"Subscriber.company_id" => $this->empresas["ids"],
					'(Year.nombre::text || (CASE character_length("Subscriber"."month_id"::text) WHEN 1 THEN (0::text||"Subscriber"."month_id"::text) ELSE "Subscriber"."month_id"::text END))::int <=' => $anios[$yearId].((strlen((String)$monthId) == 1) ? "0".$monthId : $monthId),
				),
				"fields" => [
					"Subscriber.month_id",
					"Subscriber.year_id",
					"Subscriber.cantidad_abonados",
					"Subscriber.company_id",
					"Subscriber.channel_id"
				],
			]);
			if(!empty($querySubscriber)){
				$data["channels"] = $this->Channel->find("list", [
					"conditions" => [
						"Channel.tipo" => 1,
						"Channel.estado" => 1
					],
					"fields" => [
						"Channel.id",
						"Channel.nombre"
					],
					"recursive" => -1,
					"order" => "Channel.id"
				]);
				$queryBudgetedSubscriber = $this->BudgetedSubscriber->find("all", [
					"conditions"=>array(
						"BudgetedSubscriber.company_id" => $this->empresas["ids"],
						'(Year.nombre::text || (CASE character_length("BudgetedSubscriber"."month_id"::text) WHEN 1 THEN (0::text||"BudgetedSubscriber"."month_id"::text) ELSE "BudgetedSubscriber"."month_id"::text END))::int <=' => $anios[$yearId].((strlen((String)$monthId) == 1) ? "0".$monthId : $monthId),
					),
					"fields" => [
						"BudgetedSubscriber.month_id",
						"BudgetedSubscriber.year_id",
						"BudgetedSubscriber.presupuesto",
						"BudgetedSubscriber.company_id",
						"BudgetedSubscriber.channel_id"
					],
					"recursive" => -1
				]);
				
                
				
				
				if($promociones == "promociones"){
					$querySubscribersPromocione = $this->SubscribersPromocione->find("all", [
						"conditions"=>array(
							"SubscribersPromocione.company_id" => $this->empresas["ids"],
							'(Year.nombre::text || (CASE character_length("SubscribersPromocione"."month_id"::text) WHEN 1 THEN (0::text||"SubscribersPromocione"."month_id"::text) ELSE "SubscribersPromocione"."month_id"::text END))::int <=' => $anios[$yearId].((strlen((String)$monthId) == 1) ? "0".$monthId : $monthId),
						),
						"fields" => [
							"SubscribersPromocione.month_id",
							"SubscribersPromocione.year_id",
							"SubscribersPromocione.cantidad_abonados",
							"SubscribersPromocione.company_id",
							"SubscribersPromocione.channel_id"
						],
						"recursive" => -1
					]);
				}

				$data["mesSolicitado"][$monthId] = $meses[$monthId];
				$data["mesAnterior"][min($anioMesesComprobar[min(array_keys($anioMesesComprobar))])] = $meses[min($anioMesesComprobar[min(array_keys($anioMesesComprobar))])];
				$data["anioSolicitado"][$yearId] = $anios[$yearId];
				$data["anioAnterior"][min(array_keys($anioMesesComprobar))] = $anios[min(array_keys($anioMesesComprobar))];
				if(!empty($this->empresas)){
					foreach ($modelosConditions as $modelo) {
						if(!empty(${'query'.$modelo})){
							$dataAgrupacionQuery[$modelo] = $this->agrupacionQuerysAbonados(${'query'.$modelo}, $modelo, $nombresCamposAbonados[$modelo]);
							$data[$modelo]["promedios"] = $this->procesaPromedioAnio($dataAgrupacionQuery[$modelo], $modelo, $nombresCamposAbonados[$modelo], $anioMesesComprobarPromedio, $anios,($promociones == "promociones") ? $querySubscribersPromocione : []);
							if(isset($data[$modelo]["promedios"]["faltaAbonados"][$modelo]["promedios"])){
								$faltaPromedios = $data[$modelo]["promedios"]["faltaAbonados"][$modelo]["promedios"];
								unset($data[$modelo]["promedios"]["faltaAbonados"]);
							}
						}
					}
					if(isset($dataAgrupacionQuery["Subscriber"])){
						$subscribersCompleta = $this->agrupacion_datos_subscriber($dataAgrupacionQuery["Subscriber"], $anioMesesComprobar, $anios);
						$dataAgrupacionQuery["Subscriber"] = $subscribersCompleta["Subscriber"];
						$data["faltaAbonados"] = $subscribersCompleta["faltaAbonados"];
						if(isset($faltaPromedios)){
							$data["faltaAbonados"] = $subscribersCompleta["faltaAbonados"];
							$data["faltaAbonados"]["Subscriber"]["promedios"] = $faltaPromedios;
						}
					}
					foreach ($modelosConditions as $modelo) {
						if(isset($dataAgrupacionQuery[$modelo])){
							foreach ($this->agrupacionDataVista($dataAgrupacionQuery[$modelo], $modelo) as $tipo => $respuesta) {
								$data[$modelo][$tipo] = $respuesta;
							}
						}
					}
					// Descontar promociones a subscribers
					if(strtolower($promociones) == "promociones"){
						if(isset($data["Subscriber"]) && !empty($data["Subscriber"])){
							foreach ($data["Subscriber"] as $tipo => $channels) {
								switch ($tipo) {
									case 'noagrupados':
										foreach ($channels as $channelId => $companies) {
											foreach ($companies as $companyId => $years) {
												foreach ($years as $yearId => $months) {
													foreach ($months as $monthId => $abonados) {
														if(isset($data["SubscribersPromocione"]["noagrupados"][$channelId][$companyId][$yearId][$monthId])){
															$data["Subscriber"]["noagrupados"][$channelId][$companyId][$yearId][$monthId] = $abonados - $data["SubscribersPromocione"]["noagrupados"][$channelId][$companyId][$yearId][$monthId];
															$data["Subscriber"]["totales"][$channelId][$yearId][$monthId] -= $data["SubscribersPromocione"]["noagrupados"][$channelId][$companyId][$yearId][$monthId];
														}
													}
												}
											}
										}
									break;						
									case 'agrupados':
										foreach ($channels as $channelId => $years) {
											foreach ($years as $yearId => $months) {
												foreach ($months as $monthId => $abonados) {
													if(isset($data["SubscribersPromocione"][$tipo][$channelId][$yearId][$monthId])){
														$data["Subscriber"][$tipo][$channelId][$yearId][$monthId] = $abonados - $data["SubscribersPromocione"][$tipo][$channelId][$yearId][$monthId];
														$data["Subscriber"]["totales"][$channelId][$yearId][$monthId] -= $data["SubscribersPromocione"][$tipo][$channelId][$yearId][$monthId];
													}
												}
											}
										}
									break;
								}
							}
						}
					}
					$data["empresas"] = $this->empresas["noagrupados"];
				}else{

				}
				$this->set("data", $data);
			}else{
				$this->Session->setFlash("No existen abonados para mostrar", 'msg_fallo');
				$this->set("error", "error");
			}
		}else{
			$this->Session->setFlash('Ocurrio un error el '.implode(", ", $error).' no '.(count($error) == 1 ? "existe" : "existen"), 'msg_fallo');
			$this->set("error", "error");
		}
	}

	/*public function procesaPromedioAnio($agrupadosData, $modelo, $nombreCampoAbonados, $anioMesesComprobar, $yearsList,$queryPromociones){
		$resultado = [];
		if($modelo == "Subscriber"){
			$agrupadosDataSubscribers = $this->agrupacion_datos_subscriber($agrupadosData, $anioMesesComprobar, $yearsList);
			foreach ($agrupadosDataSubscribers["Subscriber"] as $tipo => $channels) {
				foreach ($channels as $channelId => $companies) {
					foreach ($companies as $companyId => $years) {
						foreach ($years as $yearId => $months) {
							foreach ($months as $monthId => $abonados) {
								$agrupacion[$tipo][$channelId][$companyId][] = array_sum($abonados);
								if(isset($agrupadosDataSubscribers["faltaAbonados"]["Subscriber"][$tipo][$channelId][$yearId][$monthId][$companyId])){
									if($tipo == "noagrupados"){
										$resultado["faltaAbonados"]["Subscriber"]["promedios"][$tipo][$channelId][$companyId] = $agrupadosDataSubscribers["faltaAbonados"]["Subscriber"][$tipo][$channelId][$yearId][$monthId];
									}else{
										$resultado["faltaAbonados"]["Subscriber"]["promedios"][$tipo][$channelId] = $agrupadosDataSubscribers["faltaAbonados"]["Subscriber"][$tipo][$channelId];
									}
								}
							}
						}
					}
				}
			}
		}else{
			foreach ($agrupadosData as $tipo => $channels) {
				foreach ($channels as $channelId => $companies) {
					foreach ($companies as $companyId => $years) {
						foreach ($anioMesesComprobar as $yearId => $months) {
							foreach ($months as $monthId) {
								if(isset($agrupadosData[$tipo][$channelId][$companyId][$yearId][$monthId])){
									$agrupacion[$tipo][$channelId][$companyId][] = array_sum($agrupadosData[$tipo][$channelId][$companyId][$yearId][$monthId]);
								}
							}
						}
					}
				}
			}	
		}
		if(isset($agrupacion)){
			if($modelo == "Subscriber"){
				if(!empty($queryPromociones)){
					foreach ($queryPromociones as $abonado) {
						if(isset($this->empresas["noagrupados"][$abonado["SubscribersPromocione"]["company_id"]])){
							$promociones["noagrupados"][$abonado["SubscribersPromocione"]["channel_id"]][$abonado["SubscribersPromocione"]["company_id"]][] = $abonado["SubscribersPromocione"][$nombreCampoAbonados];
						}elseif(isset($this->empresas["agrupados"][$abonado["SubscribersPromocione"]["company_id"]])){
							$promociones["agrupados"][$abonado["SubscribersPromocione"]["channel_id"]][] = $abonado["SubscribersPromocione"][$nombreCampoAbonados];
						}
					}
				}
			}
			if(isset($agrupacion)){
				foreach ($agrupacion as $tipo => $channels) {
					foreach ($channels as $channelId => $companies) {
						foreach ($companies as $companyId => $abonados) {
							if($tipo == "noagrupados"){
								if(!isset($promociones[$tipo][$channelId][$companyId])){
									$resultado[$tipo][$channelId][$companyId] = round(array_sum($abonados)/count($abonados));
								}else{
									$resultado[$tipo][$channelId][$companyId] = round((array_sum($abonados)-array_sum($promociones[$tipo][$channelId][$companyId]))/count($abonados));
								}
								isset($resultado["totales"][$channelId]) ?  $resultado["totales"][$channelId] += $resultado[$tipo][$channelId][$companyId] : $resultado["totales"][$channelId] = $resultado[$tipo][$channelId][$companyId];
							}else{
								$agrupadoParaSumar[$channelId][$companyId] = array_sum($abonados)/count($abonados);
							}
						}
					}
				}
				if(isset($agrupadoParaSumar)){
					foreach ($agrupadoParaSumar as $channelId => $companies) {
						$resultado["agrupados"][$channelId] = round(array_sum(array_values($companies)));
						isset($resultado["totales"][$channelId]) ? $resultado["totales"][$channelId] += $resultado["agrupados"][$channelId] : $resultado["totales"][$channelId] = $resultado["agrupados"][$channelId];
					}
				};
			}
		}
		return $resultado;
	}*/
	public function procesaPromedioAnio($agrupadosData, $modelo, $nombreCampoAbonados, $anioMesesComprobar, $yearsList,$queryPromociones){
		$resultado = [];
		$this->loadModel("Year");
		
		if($modelo == "Subscriber"){
			$agrupadosDataSubscribers = $this->agrupacion_datos_subscriber($agrupadosData, $anioMesesComprobar, $yearsList);

			foreach ($agrupadosDataSubscribers["Subscriber"] as $tipo => $channels) {
				foreach ($channels as $channelId => $companies) {
					foreach ($companies as $companyId => $years) {
						foreach ($years as $yearId => $months) {
							foreach ($months as $monthId => $abonados) {
								$agrupacion[$tipo][$channelId][$companyId][] = array_sum($abonados);
								if(isset($agrupadosDataSubscribers["faltaAbonados"]["Subscriber"][$tipo][$channelId][$yearId][$monthId][$companyId])){
									if($tipo == "noagrupados"){
										$resultado["faltaAbonados"]["Subscriber"]["promedios"][$tipo][$channelId][$companyId] = $agrupadosDataSubscribers["faltaAbonados"]["Subscriber"][$tipo][$channelId][$yearId][$monthId];
									}else{
										$resultado["faltaAbonados"]["Subscriber"]["promedios"][$tipo][$channelId] = $agrupadosDataSubscribers["faltaAbonados"]["Subscriber"][$tipo][$channelId];
									}
								}
							}
						}
					}
				}
			}
		}else{
			
			foreach ($agrupadosData as $tipo => $channels) {
				foreach ($channels as $channelId => $companies) {
					foreach ($companies as $companyId => $years) {
						foreach ($anioMesesComprobar as $yearId => $months) {
							foreach ($months as $monthId) {
								if(isset($agrupadosData[$tipo][$channelId][$companyId][$yearId][$monthId])){
									$agrupacion[$tipo][$channelId][$companyId][] = array_sum($agrupadosData[$tipo][$channelId][$companyId][$yearId][$monthId]);									
								}
							}
						}
					}
				}
			}	
		}
		if(isset($agrupacion)){

				$anioActual = date("Y");
				$yearsList = $this->Year->find("first",array("fields"=>array("Year.id", "Year.nombre"),
			                	'conditions' => array('Year.nombre' => $anioActual),"recursive" => -1));
			    $añoSeleccionado='';
				$mesSeleccionado='';
				foreach ($anioMesesComprobar as $yearId => $months) {		
					foreach ($months as $monthId) {
						$añoSeleccionado=$yearId;
						$mesSeleccionado=$monthId;
					}
				}					
				
			if($modelo == "Subscriber"){			
				if(!empty($queryPromociones)){
					foreach ($queryPromociones as $abonado) {
						if($abonado["SubscribersPromocione"]["year_id"]==$añoSeleccionado ){
						if(isset($this->empresas["noagrupados"][$abonado["SubscribersPromocione"]["company_id"]])){
							$promociones["noagrupados"][$abonado["SubscribersPromocione"]["channel_id"]][$abonado["SubscribersPromocione"]["company_id"]][] = $abonado["SubscribersPromocione"][$nombreCampoAbonados];				
						}elseif(isset($this->empresas["agrupados"][$abonado["SubscribersPromocione"]["company_id"]])){
							$promociones["agrupados"][$abonado["SubscribersPromocione"]["channel_id"]][] = $abonado["SubscribersPromocione"][$nombreCampoAbonados];
						}
						}
					}
					
				}
			}
			if(isset($agrupacion)){
			
				foreach ($agrupacion as $tipo => $channels) {
					foreach ($channels as $channelId => $companies) {
						foreach ($companies as $companyId => $abonados) {	
							if($tipo == "noagrupados"){
								if(!isset($promociones[$tipo][$channelId][$companyId])){
									$resultado[$tipo][$channelId][$companyId] = round(array_sum($abonados)/count($abonados));
								}else if($promociones[$tipo][$channelId][$companyId]){
									$resultado[$tipo][$channelId][$companyId] = round((array_sum($abonados)-array_sum($promociones[$tipo][$channelId][$companyId]))/count($abonados));	    
								}
								isset($resultado["totales"][$channelId]) ?  $resultado["totales"][$channelId] += $resultado[$tipo][$channelId][$companyId] : $resultado["totales"][$channelId] = $resultado[$tipo][$channelId][$companyId];
							}else{
								$agrupadoParaSumar[$channelId][$companyId] = array_sum($abonados)/count($abonados);
							}
						}
					}
				}
				if(isset($agrupadoParaSumar)){
					
					foreach ($agrupadoParaSumar as $channelId => $companies) {
						$resultado["agrupados"][$channelId] = round(array_sum(array_values($companies)));
						isset($resultado["totales"][$channelId]) ? $resultado["totales"][$channelId] += $resultado["agrupados"][$channelId] : $resultado["totales"][$channelId] = $resultado["agrupados"][$channelId];
					}
				};
			}
		}
		return $resultado;
	}

	public function agrupacionQuerysAbonados ($query, $modelo, $nombreCampoAbonados){
		foreach ($query as $abonado) {
			if(isset($this->empresas["noagrupados"][$abonado[$modelo]["company_id"]])){
				$data["noagrupados"][$abonado[$modelo]["channel_id"]][$abonado[$modelo]["company_id"]][$abonado[$modelo]["year_id"]][$abonado[$modelo]["month_id"]][] = $abonado[$modelo][$nombreCampoAbonados];
			}elseif(isset($this->empresas["agrupados"][$abonado[$modelo]["company_id"]])){
				$data["agrupados"][$abonado[$modelo]["channel_id"]][$abonado[$modelo]["company_id"]][$abonado[$modelo]["year_id"]][$abonado[$modelo]["month_id"]][] = $abonado[$modelo][$nombreCampoAbonados];
			}
		}
		return $data;	
	}

	public function agrupacionDataVista ($dataAgrupada, $modelo) {
		foreach ($dataAgrupada as $tipo => $channels) {
			foreach ($channels as $canal => $companies) {
				foreach ($companies as $company => $years) {
					foreach ($years as $year => $meses) {
						foreach ($meses as $mes => $abonados) {
							if($tipo == "noagrupados"){
								$data[$tipo][$canal][$company][$year][$mes]	= array_sum($abonados);
								isset($data["totales"][$canal][$year][$mes]) ? $data["totales"][$canal][$year][$mes] += $data[$tipo][$canal][$company][$year][$mes] : $data["totales"][$canal][$year][$mes] = $data[$tipo][$canal][$company][$year][$mes];	
							}else{
								$agrupada[$canal][$year][$mes][] = array_sum($abonados);
							}
						}
					}
				}
			}	
		}
		if(isset($agrupada)){
			foreach ($agrupada as $canal => $anios) {
				foreach ($anios as $anio => $meses) {
					foreach ($meses as $mes => $abonados) {
						$data["agrupados"][$canal][$anio][$mes]	= array_sum($abonados);
						isset($data["totales"][$canal][$anio][$mes]) ? $data["totales"][$canal][$anio][$mes] += $data["agrupados"][$canal][$anio][$mes] : $data["totales"][$canal][$anio][$mes] = $data["agrupados"][$canal][$anio][$mes];
					}
				}
			}
		}
		return $data;
	}

	public function empresasAbonados(){
		$this->loadModel("Company");
		$this->loadModel("CompaniesAttribute");
		$empresasAbonados = $this->Company->find("all", [
			"conditions" => [
				"Company.company_type_id" => 1,
			],
			"fields" => [
				"Company.id",
				"Company.nombre",
				"Company.fecha_eliminacion",
				"Company.activo",
			],
			"recursive" => -1,
			"order" => "nombre"
		]);
		if(!empty($empresasAbonados)){
			foreach ($empresasAbonados as $empresa) {
				if($empresa["Company"]["activo"] == 0){
					$empresas["noagrupados"][$empresa["Company"]["id"]][$empresa["Company"]["nombre"]] = empty($empresa["Company"]["fecha_eliminacion"]) ? 0 : DateTime::createFromFormat("Y-m-d H:i:s", $empresa["Company"]["fecha_eliminacion"])->format("Yn");
				}else{
					$empresas["agrupados"][$empresa["Company"]["id"]][$empresa["Company"]["nombre"]] = empty($empresa["Company"]["fecha_eliminacion"]) ? 0 : DateTime::createFromFormat("Y-m-d H:i:s", $empresa["Company"]["fecha_eliminacion"])->format("Yn");
				}
				$ids[] = $empresa["Company"]["id"];
			}
			$companiesAtributes = $this->CompaniesAttribute->find("list",[
				"conditions" => [
					"CompaniesAttribute.company_id" => array_merge(array_unique(array_keys($empresas["noagrupados"])), array_unique(array_keys($empresas["agrupados"])))
				],
				"fields" => ["CompaniesAttribute.company_id","CompaniesAttribute.id"]
			]);

			// eliminar empresas sin atributos
			if(isset($empresas)){
				foreach ($empresas as $tipo => $companies) {
					foreach ($companies as $companyId => $companyName) {
						if(!array_key_exists($companyId, $companiesAtributes)){
							//unset($empresas["ids"][array_search($companyId, $empresas["ids"])]);
							unset($empresas[$tipo][$companyId]);
						}
					}	
				}		
			}
			$empresas["ids"] = $ids;
			$this->empresas = $empresas;
		}else{
			$this->empresas = [];
		}
	}

	public function graficos (){
		$this->set("layoutContent","container-fluid");
		$this->layout = "angular";
		$this->loadModel("Year");
		$this->loadModel("Month");
		$yearsSubscribers = $this->Subscriber->find("all", array(
			"fields" => "DISTINCT Subscriber.year_id",
		));
		$selects["years"] = $this->Year->find("list", array(
			"fields" => array("Year.id", "Year.nombre"),
			"recursive" => -1,
			"order" => "Year.nombre DESC",
			"conditions" => array("Year.id" =>Set::extract("/Subscriber/year_id",$yearsSubscribers))
		));
		$selects["months"] = $this->Month->find("list", array(
			"fields" => array("Month.id", "Month.nombre"),
			"recursive" => -1,
		));
		$this->set($selects);
	}

	public function companies_subscribers (){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("Company");
		return json_encode($this->Company->find("list", [
			"conditions" => [
				"Company.company_type_id" => 1,
			],
			"fields" => [
				"Company.id",
				"Company.nombre",
			],
			"recursive" => -1,
			"order" => "nombre"
		]));
	}

	public function subscribers_trece_meses($yearId, $monthId){
		$this->autoRender = false;
		$this->response->type("json");
		$this->loadModel("Year");
		$this->Subscriber->Behaviors->load('Containable');
		$this->Subscriber->contain('Year');
		$agrupados = [];		
		$yearsList = $this->Year->find("list",array("fields"=>array("Year.id", "Year.nombre"),"recursive" => -1));
		if(isset($yearsList[$yearId]) && ($monthId >= 1 && $monthId <=12)){
			$fechaInicio = split(",",DateTime::createFromFormat("Y-n-d H:i:s", $yearsList[$yearId]."-".$monthId."-01 00:00:00")->modify("-13 month")->format("n,Y"));
			$anioAnterior = $this->Year->find("first", array("recursive" => -1, "fields"=>"Year.id", "conditions" =>array("Year.nombre" => $fechaInicio[1])));
			$this->empresasAbonados();
			if(!empty($this->empresas)){
				$subscribersQuery = $this->Subscriber->find("all",array(
					"conditions"=>array(
						"Subscriber.company_id" => $this->empresas["ids"],
						'(Year.nombre::text || (CASE character_length("Subscriber"."month_id"::text) WHEN 1 THEN (0::text||"Subscriber"."month_id"::text) ELSE "Subscriber"."month_id"::text END))::int <=' => $yearsList[$yearId].((strlen((String)$monthId) == 1) ? "0".$monthId : $monthId),
					),
					"fields" => array(
						"Subscriber.month_id",
						"Subscriber.year_id",
						"Subscriber.cantidad_abonados",
						"Subscriber.company_id",
						"Subscriber.channel_id"
					),
					"recursive" => -1
				));
				if(!empty($subscribersQuery)){
					// meses anios y meses que deberian existir
					for ($i=$monthId; $i > 0; $i--) { 
						$anioMesesComprobar[$yearId][] = (int)$i;  	
					}
					if($monthId == 1){
						for ($i=1; $i <= 12; $i++) { 
							$anioMesesComprobar[$yearId-1][] = (int)$i;  	
						}
					}
					sort($anioMesesComprobar[$yearId]);
					if(isset($anioAnterior["Year"]["id"])){
						for ($i=$fechaInicio[0]; $i <= 12; $i++) { 
							$anioMesesComprobar[$anioAnterior["Year"]["id"]][] = (int)$i;  	
						}
						sort($anioMesesComprobar[$anioAnterior["Year"]["id"]]);		
					}
					ksort($anioMesesComprobar);
					$data["headers"] = $anioMesesComprobar;
					// encontrar compañias que no tengan los años y meses correspondientes
					$agrupadosData = $this->agrupacionQuerysAbonados($subscribersQuery, "Subscriber","cantidad_abonados");
					$agrupados = $this->agrupacion_datos_subscriber($agrupadosData, $anioMesesComprobar, $yearsList)["Subscriber"];
					$data["rows"] = $this->agrupacionDataVista($agrupados, "Subscriber");
					function ordernarData ($a, $b){
						switch ($a) {
							case 'noagrupados':
								$orden = -1;
							break;
							case 'totales' :
								$orden = 1;
							break;						
							default:
								$orden = 0;
							break;
						}
						return $orden;
					}
					function ordernarCompanies ($a, $b){
						return strcasecmp($this->empresas["noagrupadas"][$a], $this->empresas["noagrupadas"][$b]);
					}
					uksort($data["rows"], "ordernarData");
					$respuesta = $respuesta = array(
						"status" => "OK",
						"data" => $data
					);
				}else{
					$respuesta = array(
						"status" => "ERROR",
						"message" => "Sin resultados"
					);
				}
			}			
		}else{
			$respuesta = array(
				"status" => "ERROR",
				"message" => "Parametros"
			);
		}
		return json_encode($respuesta);		
	}

	public function agrupacion_datos_subscriber($agrupadosData, $anioMesesComprobar, $channelsCDF = [],$yearsList = []){
		$tipos = array("agrupados", "noagrupados");
		$agrupados = [];
		$faltantes = [];
		if(empty($yearsList)){
			if(!isset($this->Year)){
				$this->loadModel("Year");
			}
			$yearsList = $this->Year->find("list",array("fields"=>array("Year.id", "Year.nombre"),"recursive" => -1));
		}
		if(empty($channelsCDF)){
			if(!isset($this->Channel)){
				$this->loadModel("Channel");
			}
			$channelsCDF = $this->Channel->find("list", array("conditions"=>array("Channel.tipo" => 1), "fields"=>array("Channel.id", "Channel.nombre"), "recursive" => -1));
		}
		arsort($yearsList);
		foreach($tipos as $tipo){
			if(isset($agrupadosData[$tipo])){
				foreach ($channelsCDF as $channelId => $channelNombre) {
					foreach ($this->empresas[$tipo] as $companyId => $valoresEmpress) {
						if(isset($agrupadosData[$tipo][$channelId][$companyId])){
							foreach ($anioMesesComprobar as $yearIdComprobacion => $months) {
								$registroMinimo = $yearsList[min(array_keys($agrupadosData[$tipo][$channelId][$companyId]))].((strlen((String)min(array_keys($agrupadosData[$tipo][$channelId][$companyId][min(array_keys($agrupadosData[$tipo][$channelId][$companyId]))])))) == 1 ? "0".min(array_keys($agrupadosData[$tipo][$channelId][$companyId][min(array_keys($agrupadosData[$tipo][$channelId][$companyId]))])) : min(array_keys($agrupadosData[$tipo][$channelId][$companyId][min(array_keys($agrupadosData[$tipo][$channelId][$companyId]))])));
								foreach ($months as $monthIdComprobacion) {												
									if(isset($agrupadosData[$tipo][$channelId][$companyId][$yearIdComprobacion][$monthIdComprobacion])){
										$agrupados[$tipo][$channelId][$companyId][$yearIdComprobacion][$monthIdComprobacion] = $agrupadosData[$tipo][$channelId][$companyId][$yearIdComprobacion][$monthIdComprobacion];
									}else{
										if((int)$registroMinimo <= (int)$yearsList[$yearIdComprobacion].((strlen((String)$monthIdComprobacion) == 1) ? "0".$monthIdComprobacion : $monthIdComprobacion)){
											if(reset($this->empresas[$tipo][$companyId]) == 0){
												if(isset($agrupados[$tipo][$channelId][$companyId])){
													$agrupados[$tipo][$channelId][$companyId][$yearIdComprobacion][$monthIdComprobacion] = $agrupados[$tipo][$channelId][$companyId][max(array_keys($agrupados[$tipo][$channelId][$companyId]))][max(array_keys($agrupados[$tipo][$channelId][$companyId][max(array_keys($agrupados[$tipo][$channelId][$companyId]))]))];
													$faltantes["Subscriber"][$tipo][$channelId][$yearIdComprobacion][$monthIdComprobacion][$companyId] = key($this->empresas[$tipo][$companyId]);
												}else{
													foreach ($yearsList as $yearId => $year) {
														if($yearId <= $yearIdComprobacion){
															if(isset($agrupadosData[$tipo][$channelId][$companyId][$yearId])){
																for ($i=12; $i > 0; $i--) {
																	if($yearId == $yearIdComprobacion){
																		if($i <= $monthIdComprobacion){
																			if(isset($agrupadosData[$tipo][$channelId][$companyId][$yearId][$i])){
																				$agrupados[$tipo][$channelId][$companyId][$yearIdComprobacion][$monthIdComprobacion] = $agrupadosData[$tipo][$channelId][$companyId][$yearId][$i];
																				$faltantes["Subscriber"][$tipo][$channelId][$yearIdComprobacion][$monthIdComprobacion][$companyId] = key($this->empresas[$tipo][$companyId]);
																				break;
																			}	
																		}
																	}else{
																		if(isset($agrupadosData[$tipo][$channelId][$companyId][$yearId][$i])){
																			$agrupados[$tipo][$channelId][$companyId][$yearIdComprobacion][$monthIdComprobacion] = $agrupadosData[$tipo][$channelId][$companyId][$yearId][$i];
																			$faltantes["Subscriber"][$tipo][$channelId][$yearIdComprobacion][$monthIdComprobacion][$companyId] = key($this->empresas[$tipo][$companyId]);
																			break;
																		}	
																	}
																	
																}
																if(isset($agrupados[$tipo][$channelId][$companyId][$yearIdComprobacion][$monthIdComprobacion])){
																	break;
																}
															}
														}
													}
												}
											}elseif((int)reset($this->empresas[$tipo][$companyId]) >= (int)($yearsList[$yearIdComprobacion].((strlen((String)$monthIdComprobacion) == 1) ? "0".$monthIdComprobacion : $monthIdComprobacion))){
												if(isset($agrupados[$tipo][$channelId][$companyId])){
													$agrupados[$tipo][$channelId][$companyId][$yearIdComprobacion][$monthIdComprobacion] = $agrupados[$tipo][$channelId][$companyId][max(array_keys($agrupados[$tipo][$channelId][$companyId]))][max(array_keys($agrupados[$tipo][$channelId][$companyId][max(array_keys($agrupados[$tipo][$channelId][$companyId]))]))];
													$faltantes["Subscriber"][$tipo][$channelId][$yearIdComprobacion][$monthIdComprobacion][$companyId] = key($this->empresas[$tipo][$companyId]);
												}else{
													foreach ($yearsList as $yearId => $year) {
														if($yearId <= $yearIdComprobacion){
															if(isset($agrupadosData[$tipo][$channelId][$companyId][$yearId])){
																for ($i=12; $i > 0; $i--) {
																	if($yearId == $yearIdComprobacion){
																		if($i <= $monthIdComprobacion){
																			if(isset($agrupadosData[$tipo][$channelId][$companyId][$yearId][$i])){
																				$agrupados[$tipo][$channelId][$companyId][$yearIdComprobacion][$monthIdComprobacion] = $agrupadosData[$tipo][$channelId][$companyId][$yearId][$i];
																				$faltantes["Subscriber"][$tipo][$channelId][$yearIdComprobacion][$monthIdComprobacion][$companyId] = key($this->empresas[$tipo][$companyId]);
																				break;
																			}	
																		}
																	}else{
																		if(isset($agrupadosData[$tipo][$channelId][$companyId][$yearId][$i])){
																			$agrupados[$tipo][$channelId][$companyId][$yearIdComprobacion][$monthIdComprobacion] = $agrupadosData[$tipo][$channelId][$companyId][$yearId][$i];
																			$faltantes["Subscriber"][$tipo][$channelId][$yearIdComprobacion][$monthIdComprobacion][$companyId] = key($this->empresas[$tipo][$companyId]);
																			break;
																		}	
																	}
																}
																if(isset($agrupados[$tipo][$channelId][$companyId][$yearIdComprobacion][$monthIdComprobacion])){
																	break;
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		$data = [
			"Subscriber" => $agrupados,
			"faltaAbonados" => $faltantes
		];
		return $data;
	}
}
