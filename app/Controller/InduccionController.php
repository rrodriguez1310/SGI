<?php
App::uses('AppController', 'Controller');
/**
 * Induccion Controller
 *
 * @property Induccion $Recognitios
 * @property PaginatorComponent $Paginator
 */
class InduccionController extends AppController {

    /**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

    public function index(){	
		
		$this->acceso();
		//CakeLog::write('actividad', 'Visito - Index Induccion - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));

        $accesos = $this->Session->Read("Acceso");
        
		foreach ($accesos as $acceso) {
			if($acceso["controlador"] == 'induccionPantallas')
				$accesoPaginas[] = $acceso;
        }
        
		$this->set("accesoPaginas", $accesoPaginas);
    }

    

}