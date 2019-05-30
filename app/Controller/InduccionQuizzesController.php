<?php
App::uses('AppController', 'Controller');
Configure::write('Session.autoRegenerate', true);
/**
 * InduccionQuizzes Controller
 *
 * @property InduccionQuiz $InduccionQuiz
 * @property PaginatorComponent $Paginator
 */
class InduccionQuizzesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/*
 *@author Mpalencia <email@email.com>
 * quiz method
 *
 * @return void
 */

	public function quiz($etapa_id = null){
		/*Valida Usuario */
		$this->acceso();
		/* FinValida Usuario */

		$this->loadModel("InduccionPregunta");
		$this->loadModel("InduccionProgreso");
		$this->loadModel("User");
		$this->loadModel("InduccionQuize");

        $user = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
            "conditions"=>array(
                "User.id" => $this->Session->read('PerfilUsuario.idUsuario')
            ),"recursive"=>0
        ));
        
        $trabajadore_id = $user['User']['trabajadore_id'];

        $preguntas = $this->InduccionPregunta->find('all',array(
			'conditions'=>array(
                'InduccionPregunta.induccion_estado_id'=>1,
                'InduccionPregunta.induccion_etapa_id'=>$etapa_id
			),'order' => 'InduccionPregunta.id ASC',
		));
		
        $parametros = array();
        $dato = "";
        
        if ($this->request->is('post')) {

			$form = $this->request->data['InduccionQuiz'];
			
			$parametros = array_chunk($form, 3);
			
			//preguntas y respuestas que llegan del formulario 
            foreach ($parametros as $key => $value) { 
                $dato['InduccionQuiz'][$key]['induccion_pregunta_id'] = trim($value[1]);
                if(!empty($value[2][1])){
                    $dato['InduccionQuiz'][$key]['induccion_respuesta_id'] = trim($value[2][1]);
                }else{
                    $dato['InduccionQuiz'][$key]['induccion_respuesta_id'] = trim($value[2][2]);
                }
                $dato['InduccionQuiz'][$key]['induccion_etapa_id'] = trim($value[0]);
                $dato['InduccionQuiz'][$key]['induccion_trabajador_id'] = trim($trabajadore_id);
				$dato['InduccionQuiz'][$key]['porcentaje_calificacion'] = 0;
   
			}
			
			$countRespuestas = count($dato['InduccionQuiz']);
			$respondCorrectas = 0;
			$respuesta = "";
			
			//arreglo con preguntas y respuestas correctas
			foreach ($preguntas as $key => $value) {
				$respuesta[$key]['induccion_pregunta_id'] = $value['InduccionPregunta']['id'];

				foreach ($value['InduccionRespuesta'] as $key2 => $value2) {
					if($value2['verdad'] == 1){
						$respuesta[$key]['induccion_respuesta_id'] = $value2['id'];
					}
				}	
			}

			//cantidad de preguntas respondidas de forma correcta
			foreach ($dato['InduccionQuiz'] as $key3 => $getForm) {
				foreach ($respuesta as $key => $getRespuestas) {
					if($getRespuestas['induccion_pregunta_id'] == $getForm ['induccion_pregunta_id'] && $getRespuestas['induccion_respuesta_id'] == $getForm ['induccion_respuesta_id']){
						$respondCorrectas++;
					}
				}
			}

			$porcentAprobo = ($respondCorrectas * 100) / $countRespuestas;

			$dato['InduccionQuiz'][0]['porcentaje_calificacion'] = $porcentAprobo;
			

			$quiz = $this->InduccionQuize->find('all', array(
				'fields'=>'InduccionQuize.*',
				'conditions'=>array(
					'InduccionQuize.induccion_trabajador_id' => $trabajadore_id,
					'InduccionQuize.induccion_etapa_id' => $etapa_id
					),"recursive"=>0
			));

			$contadorQuiz = count($quiz);
			//pr($contadorQuiz );


			if($contadorQuiz == 0){
				if($porcentAprobo > '80'){

					$datoInsert = $dato['InduccionQuiz']; // Guardo un array de objetos
					
					if($this->InduccionQuize->saveAll($datoInsert)){
						
					
						$getQuiz = $this->InduccionProgreso->find('all', array(
							'fields'=>'InduccionProgreso.*',
							'conditions'=>array(
								'InduccionProgreso.trabajadore_id' => $trabajadore_id,
								'InduccionProgreso.induccion_etapa_id' => $etapa_id,
								'InduccionProgreso.induccion_contenido_id !=' => ''
							),"recursive"=>0
						));
	
						foreach ($getQuiz as $key3 => $value3) {
								$update[$key3]['id'] = $value3['InduccionProgreso']['id'];
								$update[$key3]['quiz'] = 1;
						}
	
						$this->InduccionProgreso->saveMany($update);

						$this->Session->setFlash('Vas muy bien! Puedes avanzar a la siguiente lección!','msg_exito');
						return $this->redirect(array('controller'=>'induccionPantallas', 'action' => 'index'));	
					}
				}
				$this->Session->setFlash('Hay algunas respuestas incorrectas, revisa con atención y contesta nuevamente!','msg_fallo');
			}else{
				return $this->redirect(array('controller'=>'induccionPantallas', 'action' => 'index'));
			} 
		}
        $this->set(compact('preguntas', 'respuestas', 'etapa_id'));
    }

}
