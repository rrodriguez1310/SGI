<?php
App::uses('AppController', 'Controller');
/**
* Calificaciones Controller
*
* @property Calificacione $Calificacione
* @property PaginatorComponent $Paginator
*/
class CalificacionesController extends AppController {
    
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
    public function calificaciones_list(){
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
        
        CakeLog::write('actividad', 'entro a  la pagina Calificaciones_list - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
        $this->autoRender = false;
        $calificaciones = $this->Calificacione->find('all', array(
            "order"=>"Calificacione.created ASC",
            'recursive'=>1
        ));
        $salida = "";
        
        foreach($calificaciones as $calificacion){
            $salida[$calificacion['User']['nombre']] = array(
            "id"=>$calificacion["Calificacione"]["id"],
            "calificacion"=>$calificacion["Calificacione"]["calificacion"],
            "porcentaje"=>$calificacion["Calificacione"]["porcentaje"],
            "estado"=> ($calificacion["Calificacione"]["estado"]==1)? 'Noiniciado' :(($calificacion["Calificacione"]["estado"]==2)?'Encurso':(($calificacion["Calificacione"]["estado"]==3) ? "Finalizada" : "Eliminada")) ,
            "user_id"=>$calificacion["User"]["nombre"],
            "prueba_id"=>$calificacion["Calificacione"]["prueba_id"],
            "video"=>$calificacion["Calificacione"]["video"],
            "created"=>$calificacion["Calificacione"]["created"],
            "modified"=>$calificacion["Calificacione"]["modified"]
            );
        }
        
        $urlLimpia = "";
        $a='';

        foreach($salida as $calificacion){
            if($calificacion['video']){
                $varUrl = $calificacion['video'];
                $a=explode("/",$varUrl);
                $urlLimpia = $a[5];
            }
            pr($a);
            $respuesta[] = array(
            "id"=>$calificacion["id"],
            "calificacion"=>$calificacion["calificacion"],
            "porcentaje"=>$calificacion["porcentaje"],
            "estado"=> $calificacion["estado"] ,
            "user_id"=>$calificacion["user_id"],
            "prueba_id"=>$calificacion["prueba_id"],
            "video"=>$urlLimpia,
            "created"=>$calificacion["created"],
            "modified"=>$calificacion["modified"]
            );
        }
        return json_encode($respuesta);
    }
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
        
        CakeLog::write('actividad', 'entro a  la pagina Calificacione - ' . $this->Session->Read("PerfilUsuario.idUsuario"));
    }
    
    public function listado_calificaciones_json(){
        $this->autoRender = false;
        $calificaciones = $this->Calificacione->find("all", array(
            "order"=>"Calificacione.calificacion ASC",
            "recursive"=>-1
            ));
        if(!empty($calificaciones))
        {
            foreach ($calificaciones as $calificacion)
            {
                $respuesta[] = array(
                "id"=>$calificacion["Calificacione"]["id"],
                "calificacion"=>$calificacion["Calificacione"]["calificacion"],
                "porcentaje"=>$calificacion["Calificacione"]["porcentaje"],
                "estado"=> ($calificacion["Calificacione"]["estado"]==0)? 'Activo' : 'Inactivo' ,
                "user_id"=>$calificacion["Calificacione"]["user_id"],
                "prueba_id"=>$calificacion["Calificacione"]["prueba_id"]
                
                );
            }   
        }else{
            $respuesta = array();
        }
        return json_encode($respuesta);
    }
    
    /**
    * view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function view($id = null) {
        if (!$this->Calificacione->exists($id)) {
            throw new NotFoundException(__('Invalid calificacione'));
        }
        $options = array('conditions' => array('Calificacione.' . $this->Calificacione->primaryKey => $id));
        $this->set('calificacione', $this->Calificacione->find('first', $options));
    }
    
    /**
    * add method
    *
    * @return void
    */
    public function add() {
        if ($this->request->is('post')) {
            
            $this->request->data["Calificacione"]["calificacion"] = 66;
            if ($this->Calificacione->save($this->request->data)) {
                $this->Session->setFlash(__('The calificacione has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The calificacione could not be saved. Please, try again.'));
            }
        }
        $users = $this->Calificacione->User->find('list');
        $pruebas = $this->Calificacione->Prueba->find('list');
        $this->set(compact('users', 'pruebas'));
    }
    
    /**
    * edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function edit($id = null) {
        if (!$this->Calificacione->exists($id)) {
            throw new NotFoundException(__('Invalid calificacione'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Calificacione->save($this->request->data)) {
                $this->Session->setFlash(__('The calificacione has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The calificacione could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Calificacione.' . $this->Calificacione->primaryKey => $id));
            $this->request->data = $this->Calificacione->find('first', $options);
        }
        $users = $this->Calificacione->User->find('list');
        $pruebas = $this->Calificacione->Prueba->find('list');
        $this->set(compact('users', 'pruebas'));
    }
    
    /**
    * delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function delete($id = null) {
        $this->Calificacione->id = $id;
        if (!$this->Calificacione->exists()) {
            throw new NotFoundException(__('Invalid calificacione'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Calificacione->delete()) {
            $this->Session->setFlash(__('The calificacione has been deleted.'));
        } else {
            $this->Session->setFlash(__('The calificacione could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
}