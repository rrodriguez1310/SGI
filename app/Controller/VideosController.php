<?php
App::uses('AppController', 'Controller');
/**
* Videos Controller
*
* @property Video $Video
* @property PaginatorComponent $Paginator
*/
class VideosController extends AppController {
    
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
            return $this -> redirect(array("controller" => 'users', "action" => 'login'));
        }
        CakeLog::write('actividad', 'entro a  la pagina Video_add - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
        $this->autoRender = false;
        //$this->acceso();
        
    }
    
    
    /**
    * view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function view($id = null) {
        if (!$this->Video->exists($id)) {
            throw new NotFoundException(__('Invalid video'));
        }
        $options = array('conditions' => array('Video.' . $this->Video->primaryKey => $id));
        $this->set('video', $this->Video->find('first', $options));
    }
    
    /**
    * add method
    *
    * @return void
    */
    public function add() {
       
    }
    
    /**
    * edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function edit($id = null) {
        if (!$this->Video->exists($id)) {
            throw new NotFoundException(__('Invalid video'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Video->save($this->request->data)) {
                $this->Session->setFlash(__('The video has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The video could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Video.' . $this->Video->primaryKey => $id));
            $this->request->data = $this->Video->find('first', $options);
        }
    }
    
    /**
    * delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function delete($id = null) {
        $this->Video->id = $id;
        if (!$this->Video->exists()) {
            throw new NotFoundException(__('Invalid video'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Video->delete()) {
            $this->Session->setFlash(__('The video has been deleted.'));
        } else {
            $this->Session->setFlash(__('The video could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    public function video_add(){
        
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
            return $this -> redirect(array("controller" => 'users', "action" => 'login'));
        }
        
        CakeLog::write('actividad', 'entro a  la pagina Video_add - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
        $this->autoRender = false;
        $this->loadModel("Calificacione");
        $var = $this->request->data["Prueba"];
        
        if ($this->request->is(array('post'))){
            $this->request->data["Calificacione"]["calificacion"] = 0;
            $this->request->data["Calificacione"]["porcentaje"] = 0;
            $this->request->data["Calificacione"]["estado"] = 2;
            $this->request->data["Calificacione"]["user_id"] = $this->Session->read("PerfilUsuario.idUsuario");
            //$this->request->data["Calificacione"]["prueba_id"] =$this->request->data["Prueba"];
            $this->request->data["Calificacione"]["prueba_id"] =1;
            $this->request->data["Calificacione"]["video"] =$this->request->data["Video"];
            if($this->Calificacione->save($this->request->data["Calificacione"])){
                
                CakeLog::write('actividad', 'Paso el video - ' . $this->request->data["Video"] . '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
                $mensaje = array(
                    "estado"=>1,
                    "mensaje"=>"Path agregado",
                    );
            }else{
                
                $mensaje = array(
                    "estado"=>0,
                    "mensaje"=>"No se pudo registrar la información"
                    );
            }
        }else{
            $mensaje = array(
                "estado"=>0,
                "mensaje"=>"No se pudo registrar la información"
                );
        }
        return json_encode($mensaje);
        
    }
    public function videoRest() {
        
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
            return $this -> redirect(array("controller" => 'users', "action" => 'login'));
        }
        
        CakeLog::write('actividad', 'entro a  la Videos - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
        $this->autoRender = false;

        $this->loadModel("Calificacione");
        $userID  = $this->Session->read("PerfilUsuario.idUsuario");
        $calificaciones = $this->Calificacione->find('first',array(
                'fields' => array('Calificacione.video','Calificacione.porcentaje','Calificacione.estado'),
                'conditions' => array('Calificacione.user_id' => $userID),
                'order'=>array('Calificacione.id' => 'DESC'
        )));
              
         if(!empty($calificaciones)){ 
            $calificaciones = array(
                'Calificacione' => Array(
                'video' => $calificaciones['Calificacione']['video'],
                'porcentaje' => $calificaciones['Calificacione']['porcentaje'],
                'estado'=>$calificaciones['Calificacione']['estado']
            ));
          
         }else{
             $calificaciones = array(
                'Calificacione' => Array(
                'video' =>  Router::fullbaseUrl().$this -> webroot.'files/videos/bienvenida/story.html',
                'porcentaje' => 0,
                'estado'=>0
             ));   
        }
        return json_encode($calificaciones );
    }
    public function video() {
        
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
            return $this -> redirect(array("controller" => 'users', "action" => 'login'));
        }
        CakeLog::write('actividad', 'entro a  la Videos - ' . $this->Session->Read("PerfilUsuario.idUsuario")); 
    }
    
    public function induccion() {
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
            return $this -> redirect(array("controller" => 'users', "action" => 'login'));
        }
        
        CakeLog::write('actividad', 'entro a  la pagina de bienvenida Induccion - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
    }
     public function evaluacion_final() {
     }

     public function upload_file() { 
     }
}