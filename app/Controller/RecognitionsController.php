<?php
App::uses('AppController', 'Controller');
/**
 * Recognitions Controller
 *
 * @property Recognitions $Recognitios
 * @property PaginatorComponent $Paginator
 */
class RecognitionsController extends AppController {

    /**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


	public function report1_json(){
		$this->loadModel("User");
		$this->loadModel("RecognitionCollaborator");
		$this->layout = null;
		$this->response->type('json');

		$datosUser = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
		"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
			));
			
		/*$salida = $this->RecognitionCollaborator->find("all", array(
					'order' => 'RecognitionCollaborator.id DESC',
				"recursive"=>0
			));*/

			

			$salida = $this->RecognitionCollaborator->find("all", array(
				"fields"=>array("Boss.nombre","Boss.apellido_paterno","Boss.apellido_materno","Employed.nombre","Employed.apellido_paterno","Employed.apellido_materno","RecognitionCollaborator.created","Conducta.name","Subconducts.name","RecognitionCollaborator.points_add"),
					"joins"=> array(
						array("table" => "recognition_conducts", "alias" => "Conducta", "type" => "INNER", "conditions" => array("Conducta.id = Subconducts.conduct_id")),	
					),'conditions'=>array('RecognitionCollaborator.points_add > ' => 0),
					'order' => 'RecognitionCollaborator.id DESC',
					"recursive"=>0
				));
			
				
			
		$this->set(compact('salida',$salida));

		$salidaJson ="";
		foreach($salida as $value){
			$salidaJson[] = array(
				'jefe'=>$value['Boss']['nombre']." ".$value['Boss']['apellido_paterno']." ".$value['Boss']['apellido_materno'],
				'colaborador'=>ucwords($value['Employed']['nombre']." ".$value['Employed']['apellido_paterno']." ".$value['Employed']['apellido_materno']),
				'fecha'=>date('d/m/y h:i:s', strtotime($value['RecognitionCollaborator']['created'])),
				'conducta'=>ucwords($value['Conducta']['name']),
				'subconducta'=>ucwords($value['Subconducts']['name']),
				'puntosadd'=>ucwords($value['RecognitionCollaborator']['points_add'])

			);
		}
		echo json_encode($salidaJson);
		exit;
	}

	public function report1() {
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */

		$this->layout = "angular";
	}

    public function index(){
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
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Index Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));

		$accesos = $this->Session->Read("Acceso");
		foreach ($accesos as $acceso) {
			if($acceso["controlador"] == 'recognitionBossDepartaments' || $acceso["controlador"] == 'recognitionCollaborators')
				$accesoPaginas[] = $acceso;
        }
        
		$this->set("accesoPaginas", $accesoPaginas);
    }

	public function reportII_json(){
		$this->loadModel("User");
		$this->loadModel("RecognitionCollaborator");
		$this->layout = null;
		$this->response->type('json');

		$datosUser = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
		"conditions"=>array("User.id" => $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
			));
			
		/*$salida = $this->RecognitionCollaborator->find("all", array(
			'conditions'=>array('RecognitionCollaborator.points_delete > ' => 0),
			'order' => 'RecognitionCollaborator.id DESC',
			"recursive"=>0
		));*/

		$salida = $this->RecognitionCollaborator->find("all", array(
			"fields"=>array("RecognitionCollaborator.created","Employed.nombre","Employed.apellido_paterno","Employed.apellido_materno",
					"Product.name","Product.category_id", "Categoria.name"),
			"joins"=> array(
					array("table" => "recognition_categorys", "alias" => "Categoria", "type" => "INNER", "conditions" => array("Categoria.id = Product.category_id")),	
			),'conditions'=>array('RecognitionCollaborator.points_delete > ' => 0 ),
			'order' => 'RecognitionCollaborator.id DESC',
			"recursive"=>0
		));
			
		$this->set(compact('salida',$salida));

		$salidaJson ="";
		foreach($salida as $value){
			$salidaJson[] = array(
				'fecha'=>date('d/m/y h:i:s', strtotime($value['RecognitionCollaborator']['created'])),
				'colaborador'=>ucwords($value['Employed']['nombre']." ".$value['Employed']['apellido_paterno']." ".$value['Employed']['apellido_materno']),
				'categoria'=>ucwords($value['Categoria']['name']),
				'producto'=>ucwords($value['Product']['name'])

			);
		}
		echo json_encode($salidaJson);
		exit;
	}

	public function reports(){
		/*Valida Usuario */
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this -> redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}else {
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this -> redirect(array("controller" => 'users', "action" => 'login'));
		}
		/* FinValida Usuario */

		$this->layout = "angular";
	}


    public function mantenedores() {
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
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', 'Visito - Listado Evaluaciones - index - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
	}

}