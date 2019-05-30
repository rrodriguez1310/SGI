<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('TrabajadoresController', 'Controller');

class EnviosCorreosController extends AppController {

	public function fecha_termino_contrato_trabajadores()
	{
		$this->autoRender = false;
		$this->loadModel("ListaCorreo");
		$this->loadModel("Documento");
		$trabajadorController = new TrabajadoresController;
		date_default_timezone_set("America/Santiago");
		setlocale(LC_ALL,"es_ES");
		$fechaActual = new DateTime();
		$fechaAnterior = new DateTime();
		$fechaAnterior->modify("+30 days");
		$documentosVencer = $this->Documento->find("all", array(
			"conditions"=>array(
				"Documento.fecha_final !="=>null,
				"Trabajadore.estado"=>"Activo",
				"Documento.fecha_final"=>array(
					$fechaActual->format("Y-m-d"),
					$fechaAnterior->format("Y-m-d")
					)
				)
			)
		);
		if(!empty($documentosVencer))
		{
			$listaCorreo = $this->ListaCorreo->find("first", array(
				"conditions"=>array(
					"ListaCorreosTipo.id"=>2,
					"ListaCorreosTipo.estado"=>1
					),
				"recursive"=>1
				)
			);
			foreach($listaCorreo["Trabajadore"] as $trabajador)
			{
				$correos[] = $trabajador["email"];
			}
			foreach ($listaCorreo["ListaCorreosExterno"] as $correosExternos) {
				$correos[] = $correosExternos["correo"];
			}
			foreach ($documentosVencer as $key => $documento) 
			{	
				$trabajador = $trabajadorController->trabajador($documento["Trabajadore"]["id"]);
				$trabajador = json_decode($trabajador);
				$fecha_documento = new DateTime($documento["Documento"]["fecha_inicial"]);
				$fecha_vencimiento = new DateTime($documento["Documento"]["fecha_final"]);
				$reemplazar = array('{{nombre}}', '{{fecha_documento}}', '{{fecha_vencimiento}}', '{{gerencia}}', '{{tipo_documento}}', '{{correo}}', '{{area}}', '{{cargo}}');
				$reemplazo = array(
					mb_strtoupper($documento["Trabajadore"]["nombre"])." ".mb_strtoupper($documento["Trabajadore"]["apellido_paterno"]." ".mb_strtoupper($documento["Trabajadore"]["apellido_materno"])),
					$fecha_documento->format("d/m/Y"),
					$fecha_vencimiento->format("d/m/Y"),
					mb_strtoupper($trabajador->Cargo->Area->Gerencia->nombre),
					mb_strtoupper($documento["TiposDocumento"]["nombre"]),
					mb_strtoupper($trabajador->Trabajadore->email),
					empty($trabajador->cargo_id) ? mb_strtoupper($trabajador->Cargo->Area->nombre) : "",
					empty($trabajador->cargo_id) ? mb_strtoupper($trabajador->Cargo->nombre) : "",
					);
				$mensaje = str_replace($reemplazar, $reemplazo, $listaCorreo["ListaCorreo"]["mensaje"]);
				if(!empty($correos))
				{
					$Email = new CakeEmail("gmail");
					$Email->from(array('sgi@cdf.cl' => 'SGI'));
					$Email->to($correos);
					$Email->subject($listaCorreo["ListaCorreo"]["titulo"]);
					$Email->emailFormat('html');
					$Email->template('envio_correo_vencimiento_documentos_trabajador');
					$Email->viewVars(array(
						"mensaje"=>$mensaje,
					));
					$Email->send();	
				}
			}
		}
	}
}
