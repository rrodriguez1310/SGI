<?php
App::uses('AppController', 'Controller');
/**
* Respuestas Controller
*
* @property Respuesta $Respuesta
* @property PaginatorComponent $Paginator
*/
class RespuestasController extends AppController {
    
    /**
    * Components
    *
    * @var array
    */
    public $components = array('Paginator');
    
    /**
    * index method
    *
    * @return void
    */
    public function index() {
        $this->layout = "angular";
    }
    
    /**
    * view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function view($id = null) {
        if (!$this->Respuesta->exists($id)) {
            throw new NotFoundException(__('Invalid respuesta'));
        }
        $options = array('conditions' => array('Respuesta.' . $this->Respuesta->primaryKey => $id));
        $this->set('respuesta', $this->Respuesta->find('first', $options));
    }
    
    /**
    * add method
    *
    * @return void
    */
    public function add() {
         $this->acceso();
        if ($this->request->is('post')) {
            $this->Respuesta->create();
            if ($this->Respuesta->save($this->request->data)) {
                $this->Session->setFlash('La Respuesta ha sido Guardada.', 'msg_exito');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Ocurrio un error intentelo nuevamente.', 'msg_fallo');
            }
        }
        $preguntasArr = $this->Respuesta->Pregunta->find('all',array(
                    'fields' => array('Pregunta.id','Pregunta.pregunta'),
                    "order"=>"Prueba.id ASC",
                    "recursive"=>0
        )); 
        foreach ($preguntasArr as $value) {
            $preguntas[$value["Pregunta"]["id"]] = $value["Pregunta"]["pregunta"];
        }
        $this->set(compact('preguntas'));
    }
    
    /**
    * edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function edit($id = null) {
         $this->acceso();
        if (!$this->Respuesta->exists($id)) {
            throw new NotFoundException(__('Invalid respuesta'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Respuesta->save($this->request->data)) {
               $this->Session->setFlash('La Respuesta ha sido Guardada.', 'msg_exito');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Ocurrio un error intentelo nuevamente.', 'msg_fallo');
            }
        } else {
            $options = array('conditions' => array('Respuesta.' . $this->Respuesta->primaryKey => $id));
            $this->request->data = $this->Respuesta->find('first', $options);
        }
        $preguntasArr = $this->Respuesta->Pregunta->find('all',array(
						'fields' => array('Pregunta.id','Pregunta.pregunta'),
						"order"=>"Prueba.id ASC",
						"recursive"=>0
        ));     
        foreach ($preguntasArr as $value) {
            $preguntas[$value["Pregunta"]["id"]] = $value["Pregunta"]["pregunta"];
        }  
        $this->set(compact('preguntas'));
        
    }
    
    /**
    * delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function delete($id = null) {
        $this->acceso();
        $this->Respuesta->id = $id;
        if (!$this->Respuesta->exists()) {
            throw new NotFoundException(__('Invalid respuesta'));
        }
        //$this->request->allowMethod('post', 'delete');
        if ($this->Respuesta->delete()) {
            $this->Session->setFlash('El registro se elimino correctamente', 'msg_exito');
        } else {
            $this->Session->setFlash('Ocurrio un error intentelo nuevamente.', 'msg_fallo');
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    public function respuestas_list(){
     
        $this->autoRender = false;
        //$this->response->type("json");
        $respuestas = $this->Respuesta->find("all", array( 
                "order"=>"Respuesta.id ASC",
                "recursive"=>1
        ));
        if(!empty($respuestas))
        {
            foreach ($respuestas as $respuesta)
            {
                $respuestaJson[] = array(
                "id"=>$respuesta["Respuesta"]["id"],
                "opcion_letra"=>$respuesta["Respuesta"]["opcion_letra"],
                "opcion_text"=>$respuesta["Respuesta"]["opcion_text"],
                "pregunta_id"=>$respuesta["Respuesta"]["pregunta_id"]      
                );
            }
        }else
        {
            $respuestaJson = array();
        }
        return json_encode($respuestaJson);
    }
     public function acceso(){
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
        CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
    }
}