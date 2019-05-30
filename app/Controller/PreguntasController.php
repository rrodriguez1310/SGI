<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
* Preguntas Controller
*
* @property Pregunta $Pregunta
* @property PaginatorComponent $Paginator
*/
class PreguntasController extends AppController {
    
    /**
    * Components
    *
    * @var array
    */
    public $components = array('Paginator');
    
    public function index() {
        
        $this->layout = "angular";
        $this->acceso();
    }
    public function preguntas_list_all() {
        
        $this->layout = "angular";
        //$this->acceso();
    }
    
    public function preguntas_list(){
        
        $this->acceso();
        $this->autoRender = false;
        $pathVideos = array(
        Router::fullbaseUrl().$this -> webroot.'files/videos/bienvenida/story.html',
        Router::fullbaseUrl().$this -> webroot.'files/videos/historia/story.html',
        Router::fullbaseUrl().$this -> webroot.'files/videos/negocio_clientes/story.html',
        Router::fullbaseUrl().$this -> webroot.'files/videos/realizacion_servicio/story.html',
        Router::fullbaseUrl().$this -> webroot. 'files/videos/mapa_estrategico/story.html',
        Router::fullbaseUrl().$this -> webroot.'files/videos/gestion_personas/story.html',
        Router::fullbaseUrl().$this -> webroot.'files/videos/relaciones_laborales/story.html'
        );
        
        $this->loadModel("Respuesta");
        $this->loadModel("Calificacione");
        $usuarioID = $this -> Session -> read("PerfilUsuario.idUsuario");
        
        $video = $this->Calificacione->find('first',array(
                'fields' => array('Calificacione.video','Calificacione.prueba_id'),
                'conditions' => array('Calificacione.user_id' => $usuarioID),
                'order'=>array('Calificacione.id' => 'DESC'
        )));
        
        if($video)
        {
            if($video["Calificacione"]["video"]==$pathVideos[0] || $video["Calificacione"]["video"]==$pathVideos[1] ||
               $video["Calificacione"]["video"]==$pathVideos[2] || $video["Calificacione"]["video"]==$pathVideos[3] ||
               $video["Calificacione"]["video"]==$pathVideos[4] )
            {
               $preguntas = $this->Pregunta->find('all',array(
                    'conditions' => array('Pregunta.prueba_id' => 1),
                    'order'=>array("Pregunta.id ASC"),
                    'recursive'=> 1
                    ));
                    //pr($preguntas);exit;
                $this->set('preguntas', $preguntas);  

            }else if ($video["Calificacione"]["video"]==$pathVideos[6] ){
                 $preguntas = $this->Pregunta->find('all',array(
                    'conditions' => array('Pregunta.prueba_id' => 2),
                    'order'=>array("Pregunta.id ASC"),
                    'recursive'=> 1
                    ));
                $this->set('preguntas', $preguntas);       
                
            }else if ($video["Calificacione"]["video"]==Router::fullbaseUrl().$this -> webroot.'files/videos/Examen' || $video["Calificacione"]["video"]==$pathVideos[6])
            {
                $preguntas = $this->Pregunta->find('all',array(
                    'conditions' => array('Pregunta.prueba_id' => 3),
                    'order'=>array("Pregunta.id ASC"),
                    'recursive'=> 1
                    ));
                $this->set('preguntas', $preguntas);
            }
        }
        else{
            $respuesta = array(
                "estado"=>0,
                "mensaje"=>"No tiene Quiz o examenes por responder"
            );
        }
        if(!empty($preguntas))
        {
            foreach ($preguntas as $pregunta)
            {
                $respuesta[] = array(
                "id"=>$pregunta["Pregunta"]["id"],
                "pregunta"=>$pregunta["Pregunta"]["pregunta"],
                "respuesta"=>$pregunta["Pregunta"]["respuesta"],
                "numero_pregunta"=>$pregunta["Pregunta"]["numero_pregunta"],
                "respuesta_id"=>$pregunta["Respuesta"],
                "prueba_id"=>$pregunta["Prueba"],  
                );
            }
        }else{
            $respuesta = array(
                "estado"=>0,
                "mensaje"=>"No tiene Quiz o examenes por responder"
            );    
        }
        return json_encode($respuesta);
    }
    /**
    * index method
    *
    * @return void
    */
    
    
    public function preguntas_list_grid(){

        $this->layout = "angular";
        $this->autoRender = false;

        $preguntas = $this->Pregunta->find("all", array(
            "order"=>"Pregunta.id ASC",
            "recursive"=>-1
        ));
        if(!empty($preguntas))
        {
            foreach ($preguntas as $pregunta)
            {
                $respuesta[] = array(
                "id"=>$pregunta["Pregunta"]["id"],
                "pregunta"=>$pregunta["Pregunta"]["pregunta"],
                "respuesta"=>$pregunta["Pregunta"]["respuesta"],
                "numero_pregunta"=>$pregunta["Pregunta"]["numero_pregunta"],
                "prueba_id"=>$pregunta["Pregunta"]["prueba_id"],
                );
            }  
        }else
        {
            $respuesta = array();
        }
        return json_encode($respuesta);
    }
    
    public function add_calificaciones(){
        $this->acceso();
        
        $this->autoRender = false;
        $this->response->type("json");
        
        $this->loadModel("Calificacione");
        if ($this->request->is(array('post'))){
            $this->request->data["Calificacione"]["calificacion"] = $this->request->data["Pregunta"]["calificacion"];
            $this->request->data["Calificacione"]["porcentaje"] = $this->request->data["Pregunta"]["porcentaje"];
            $this->request->data["Calificacione"]["estado"] = $this->request->data["Pregunta"]["status"];
            $this->request->data["Calificacione"]["user_id"] = $this->Session->read("PerfilUsuario.idUsuario");
            $this->request->data["Calificacione"]["prueba_id"] =$this->request->data["Pregunta"]["pruebaId"];
            $this->request->data["Calificacione"]["video"] = $this->request->data["Pregunta"]["urlVideo"];
            $messageTest = $this->request->data["Pregunta"]["messageTest"];
            $nombreCorreo = " Inducción Corporativa CDF";
            
            if($this->Calificacione->save($this->request->data["Calificacione"])){
                
                CakeLog::write('actividad', 'Paso el video - ' . $this->request->data["Pregunta"]["urlVideo"] . '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
                if($this->request->data["Calificacione"]["porcentaje"]>76){
                    $mensaje = array(
                        "estado"=>1,
                        "mensaje"=>"Aprobado",
                    );
                    $this->Session->setFlash($messageTest, 'msg_exito');
                }else{
                    $mensaje = array(
                        "estado"=>0,
                        "mensaje"=>"Reprobado"
                    );
                    $this->Session->setFlash($messageTest, 'msg_fallo');
                }
            }else{
                $mensaje = array(
                    "estado"=>0,
                    "mensaje"=>"No se pudo registrar la información"
                );
                $this->Session->setFlash($messageTest, 'fallo');
            }        
        }else{
            $mensaje = array(
                "estado"=>0,
                "mensaje"=>"No se pudo registrar la información"
            );
        }
        return json_encode($mensaje);
    }
    

    
    /**
    * view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function view($id = null) {
        if (!$this->Pregunta->exists($id)) {
            throw new NotFoundException(__('Invalid pregunta'));
        }
        $options = array('conditions' => array('Pregunta.' . $this->Pregunta->primaryKey => $id));
        $this->set('pregunta', $this->Pregunta->find('first', $options));
    }
    
    /**
    * add method
    *
    * @return void
    */
    public function add() {
         $this->acceso();
        if ($this->request->is('post')) {
            $this->Pregunta->create();
            if ($this->Pregunta->save($this->request->data)) {
                $this->Session->setFlash('La Pregunta ha sido Guardada.', 'msg_exito');
                return $this->redirect(array('action' => 'preguntas_list_all'));
            } else {
                $this->Session->setFlash(__('Ocurrio un error intentelo nuevamente.', 'msg_fallo'));
            }
        }
        $pruebasArr = $this->Pregunta->Prueba->find('all',array(
                    'fields' => array('Prueba.id','Prueba.titulo'),
                    "order"=>"Prueba.id ASC",
                    "recursive"=>-1
        ));
        
        foreach ($pruebasArr as $value) {
            $pruebas[$value["Prueba"]["id"]] = $value["Prueba"]["titulo"];
        }
        $this->set(compact('pruebas'));
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
        if (!$this->Pregunta->exists($id)) {
            throw new NotFoundException(__('Invalid pregunta'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Pregunta->save($this->request->data)) {
                $this->Session->setFlash('La Pregunta ha sido Guardada.', 'msg_exito');
                return $this->redirect(array('action' => 'preguntas_list_all'));
            } else {
                $this->Session->setFlash(__('Ocurrio un error intentelo nuevamente.', 'msg_fallo'));
            }
        } else {
            $options = array('conditions' => array('Pregunta.' . $this->Pregunta->primaryKey => $id));
            $this->request->data = $this->Pregunta->find('first', $options);
        } 
        $pruebasArr = $this->Pregunta->Prueba->find('all',array(
                        'fields' => array('Prueba.id','Prueba.titulo'),
                        "order"=>"Prueba.id ASC",
                        "recursive"=>-1
        ));
        
        foreach ($pruebasArr as $value) {
            $pruebas[$value["Prueba"]["id"]] = $value["Prueba"]["titulo"];
        } 
        $this->set(compact('pruebas'));
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
        $this->Pregunta->id = $id;
        if (!$this->Pregunta->exists()) {
            throw new NotFoundException(__('Invalid pregunta'));
        }
        //$this->request->allowMethod('post', 'delete');
        if ($this->Pregunta->delete()) {
            $this->Session->setFlash('El registro se elimino correctamente', 'msg_exito');
        } else {
            $this->Session->setFlash('Ocurrio un error intentelo nuevamente', 'msg_fallo');
        }
        return $this->redirect(array('action' => 'preguntas_list_all'));
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