<?php
App::uses('AppController', 'Controller');
/**
* Pruebas Controller
*
* @property Prueba $Prueba
* @property PaginatorComponent $Paginator
*/
class PruebasController extends AppController {
    
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
    public function pruebas_list(){
    
        $this->autoRender = false;
        $pruebas = $this->Prueba->find("all", array(
            "order"=>"Prueba.titulo ASC",
            "recursive"=>1
        ));
        if(!empty($pruebas))
        {
            foreach ($pruebas as $prueba)
            {
                $respuesta[] = array(
                "id"=>$prueba["Prueba"]["id"],
                "titulo"=>$prueba["Prueba"]["titulo"],
                "descripcion"=>$prueba["Prueba"]["descripcion"],
                "numero_preguntas"=>$prueba["Prueba"]["numero_preguntas"],
                "punt_max"=>$prueba["Prueba"]["punt_max"],
                "punt_min"=>$prueba["Prueba"]["punt_min"] 
                );
            }
        }else
        {
            $respuesta = array();
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
        //$this->acceso();
        
    }
    
    public function listado_pruebas_json(){
       
        $this->autoRender = false;
        $pruebas = $this->Prueba->find("all", array(
            "order"=>"Prueba.titulo ASC",
            "recursive"=>-1
        ));
        if(!empty($pruebas))
        {
            foreach ($pruebas as $prueba)
            {
                $respuesta[] = array(
                "id" => $prueba["Prueba"]["id"],
                "titulo" => $prueba["Prueba"]["titulo"],
                "descripcion" => $prueba["Prueba"]["descripcion"],
                "numero_preguntas" => $prueba["Prueba"]["numero_preguntas"],
                "punt_max" => $prueba["Prueba"]["punt_max"],
                "punt_min" => $prueba["Prueba"]["punt_min"]
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
        if (!$this->Prueba->exists($id)) {
            throw new NotFoundException(__('Invalid prueba'));
        }
        $options = array('conditions' => array('Prueba.' . $this->Prueba->primaryKey => $id));
        $this->set('prueba', $this->Prueba->find('first', $options));
    }
    
    /**
    * add method
    *
    * @return void
    */
    public function add() {
        $this->acceso();
        if ($this->request->is('post')) {
            $this->Prueba->create();
            if ($this->Prueba->save($this->request->data)) {
                $this->Session->setFlash('La Prueba ha sido Guardada.', 'msg_exito');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Ocurrio un error intentelo nuevamente.', 'msg_fallo'));
            }
        }
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
        if (!$this->Prueba->exists($id)) {
            throw new NotFoundException(__('Invalid prueba'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Prueba->save($this->request->data)) {
                $this->Session->setFlash('La Prueba ha sido Guardada.', 'msg_exito');
              
                return $this->redirect(array('action' => 'index'));
            } else {
      
                $this->Session->setFlash('Ocurrio un error intentelo nuevamente.', 'msg_fallo');
            }
        } else {
            $options = array('conditions' => array('Prueba.' . $this->Prueba->primaryKey => $id));
            $this->request->data = $this->Prueba->find('first', $options);
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
         $this->acceso();
           $this->Prueba->id = $id;
        if (!$this->Prueba->exists()) {
            throw new NotFoundException(__('Invalid pregunta'));
        }
        //$this->request->allowMethod('post', 'delete');
        if ($this->Prueba->delete()) {
            $this->Session->setFlash('El registro se elimino correctamente', 'msg_exito');
        } else {
            $this->Session->setFlash('Ocurrio un error intentelo nuevamente', 'msg_fallo');
        }
        return $this->redirect(array('action' => 'index'));
     
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