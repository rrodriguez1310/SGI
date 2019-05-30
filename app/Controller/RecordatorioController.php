<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class RecordatorioController extends AppController {
    
    
    public function recordatorioInduccion($fechaActual){
        $this->loadModel('User');
        $fechaInicio = "20017-01-24";
        
        if(!empty($fechaActual)){
            $usuarios = $this->User->find('all', array(
            'conditions'=>array('User.created >='=> $fechaInicio),
            'recursive'=> -1
            ));
            
            $informarUsuarios = "";
            $dateActual = new DateTime($fechaActual);
            
            if(!empty($usuarios)){
                foreach($usuarios as $usuario){      
                    $fechaCreated =  new DateTime($usuario['User']['created']);
                    $interval = $dateActual->diff($fechaCreated);                   
                    if($interval->days==5 || $interval->days==10){
                        $informarUsuarios[] = $usuario['User']['email'];   
                    }  
                }
            }

            if(!empty($informarUsuarios)){ 
                $Email = new CakeEmail("gmail");
                $Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
                $Email->to($informarUsuarios);
                $Email->subject('Recordatorio Inducción Corporativa CDF');
                $Email->emailFormat('html');
                $Email->template('recordatorio_induccion');
                $Email->send();
                
            }
        }
    }
}