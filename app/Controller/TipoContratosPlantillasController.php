<?php
App::uses('AppController', 'Controller');
/**
 * TipoContratosPlantillas Controller
 *
 * @property TipoContratosPlantilla $TipoContratosPlantilla
 * @property PaginatorComponent $Paginator
 */
class TipoContratosPlantillasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'RequestHandler');

	public function tipo_documentos_contrato($id){

		$this->layout = "ajax";
		
		$tipoDocumentos = "Tipo de contrato sin plantillas asociadas";

		$tipoDocumentosQuery = $this->TipoContratosPlantilla->find("all", array(
			"conditions"=>array(
				"TipoContratosPlantilla.tipo_contrato_id"=>$id
				)
			)
		);

		//pr($tipoDocumentosQuery);exit;

		if(!empty($tipoDocumentosQuery)){
			$tipoDocumentos = "";
			foreach($tipoDocumentosQuery as $k => $tipoDocumento){
				$tipoDocumentos[$k]["id"] = $tipoDocumento["TiposDocumento"]["id"];
				$tipoDocumentos[$k]["nombre"] = $tipoDocumento["TiposDocumento"]["nombre"];
			}
		}

		$this->set("tipoDocumentos", $tipoDocumentos);
	}

	public function plantilla_contrato(){
		$this->layout = "ajax";
		//pr($this->request->query);
		$plantillaContrato = $this->TipoContratosPlantilla->find("first", array(
			"conditions"=>array(
				"TipoContratosPlantilla.tipo_contrato_id"=>$this->request->query["tipo_contrato_id"],
				"TipoContratosPlantilla.tipos_documento_id"=>$this->request->query["tipos_documento_id"]
				)
			)
		);
		echo json_encode($plantillaContrato);
		exit;
	}

	public function imprimir_plantilla(){

		$this->layout = "ajax";
		$pathFile = WWW_ROOT . "files" . DS . "pdf" . DS . "contrato_trabajador.pdf";
		App::import("Vendor", "tcpdf", array("file" => "tcpdf" . DS . "tcpdf.php"));

		$this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->tcpdf->SetAuthor('Servicios de Televisión Canal del Fútbol Limitada');
		$this->tcpdf->setPrintHeader(false);
		$this->tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$this->tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$this->tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT,PDF_MARGIN_BOTTOM);
		$this->tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$this->tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$this->tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$this->tcpdf->SetFontSize(12);
		$this->tcpdf->AddPage();
		$this->tcpdf->writeHTML($this->request->data["html"], true, false, true, false, '');
		$this->tcpdf->Output($pathFile, "F");
		$ruta = Router::fullbaseUrl().$this -> webroot."files". DS . "pdf" . DS . "contrato_trabajador.pdf";
		$this->set("ruta", $ruta);
	}

	public function tipo_contratos_plantillas(){
		$this->autoRender = false;
		$this->response->type("json");
		$plantillas = $this->TipoContratosPlantilla->find("all", array("conditions"=>array("TipoContratosPlantilla.estado"=>1)));
		if(!empty($plantillas)){
			$respuesta = array("estado"=>1, "data"=> $plantillas);
		}else{
			$respuesta = array("estado"=>0, "mensaje"=>"Sin data");
		}
		return json_encode($respuesta);
	}
}
