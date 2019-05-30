<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class CumpleanosController extends AppController {
	public function envioCorreoCumpleanos()
	{
		$this->layout = "ajax";
		$this->loadModel("Trabajadore");
		$this->loadModel("Cargo");
		$trabajadores = $this->Trabajadore->find('all', array(
			'conditions'=> array(
				//"TO_CHAR(Trabajadore.fecha_nacimiento,'MMDD')"=>date("0910"),
				"TO_CHAR(Trabajadore.fecha_nacimiento,'MMDD')"=>date('md'),
				'Trabajadore.estado'=>'Activo',
				'Trabajadore.fecha_ingreso <='=>date('Y-m-d'),
				'Trabajadore.tipo_contrato_id !='=>3),
			'fields'=>array(
				'Trabajadore.id', 
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
				$tarjetaId = $trabajador["Trabajadore"]["id"];
				$Email = new CakeEmail("gmail");
				$Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
				$Email->to(array('grupocdf@cdf.cl'));
				//$Email->to(array('ddiaz@cdf.cl'));
				$Email->subject($nombreCorreo);
				$Email->emailFormat('html');
				$Email->attachments(array(
				    'cumple.png' => array(
				        'file' =>  WWW_ROOT.'img'.DS.'cumple.png',
				        'mimetype' => 'image/png',
				        'contentId' => $tarjetaId
				    )
				));
				$Email->template('envio_correo_cumpleanos');
				$Email->viewVars(array(
					"tarjetaId"=>$tarjetaId
				));
				$Email->send();

			}
		}
	}
}
