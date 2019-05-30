<?php

	App::uses('AppController', 'Controller');
	class EnviaEmailController extends AppController {
		
		public function envia_informe_abonados($estado)
		{
			
				/*
				$this->LoadModel("Email");
				
				$emails = $this->Email->find("all", array(
					'conditions'=>array("Email.informe" => "abonados"),
					'fields'=>'Email.email'
				));
				
				$emailArray = "";
				foreach($emails as  $email)
				{
					$emailArray[] = $email["Email"]["email"];
				}
				
				pr($emailArray);exit;
				
				$Email = new CakeEmail();
				$Email->from(array('sgi@cfd.com' => 'SGI'));
				$Email->to(array('desarrollo01@cdf.cl', 'groupbycaq@gmail.com'));
				$Email->subject('Se genero un nuevo informe de abonados');
				$Email->emailFormat('html');
				$Email->template('themeEmail');
				$Email->viewVars(array(
					"numeroCotizacion"=>"1",
					"valorTotal"=>"2", 
					"cantidad"=>"3", 
					"productos"=>"4"
				));
				$Email->send();
				*/
		}
		
	}
	
?>