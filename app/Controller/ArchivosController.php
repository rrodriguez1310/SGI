<?php
App::uses('AppController', 'Controller');
/**
* Archivos Controller
*
* @property Archivo $Archivo
* @property PaginatorComponent $Paginator
*/
class ArchivosController extends AppController {
    
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
        if (!$this->Archivo->exists($id)) {
            throw new NotFoundException(__('Invalid archivo'));
        }
        $options = array('conditions' => array('Archivo.' . $this->Archivo->primaryKey => $id));
        $this->set('archivo', $this->Archivo->find('first', $options));
    }
    
    /**
    * add method
    *
    * @return void
    */
    public function add() {
        $this->acceso();
        $uploadData = '';
        $this->loadModel("CategoriasArchivo");
        if ($this->request->is('post')) {  
            $categorias = $this->CategoriasArchivo->find('first',array(
               'conditions' => array('CategoriasArchivo.id' => $this->request->data["Archivo"]["categorias_archivo_id"], 
            )));
            
            if(!empty($this->request->data['Archivo']['file']['name'])){
                $fileName = $this->request->data['Archivo']['nombre'];
                $uploadPath = WWW_ROOT.$categorias['CategoriasArchivo']['ruta'];
                $uploadFile = $uploadPath.$fileName;
                if(move_uploaded_file($this->request->data['Archivo']['file']['tmp_name'],$uploadFile)){  
                    $this->request->data["Archivo"]["ruta"] = $categorias['CategoriasArchivo']['ruta'];
                    $this->request->data["Archivo"]["leccion"] = $categorias['CategoriasArchivo']['nombre'];
                 
                    if ($this->Archivo->save($this->request->data["Archivo"])) {
                        $this->Session->setFlash('El Archivo ha sido Cargado.', 'msg_exito');
						return $this->redirect(array('action' => 'index'));
                    }else{
                        $this->Session->setFlash('No se puede cargar el archivo. Vuelva a intentarlo.','msg_fallo');
                    }
                }else{
                   $this->Session->setFlash('No se puede subir el archivo. Vuelva a intentarlo.','msg_fallo');
                }
            }else{
                $this->Session->setFlash('Selecciona un archivo para cargarlo.','msg_fallo');
            }
            
        }
        $categoriasArr = $this->Archivo->CategoriasArchivo->find('all',array(
			'fields' => array('CategoriasArchivo.id','CategoriasArchivo.nombre','CategoriasArchivo.ruta'),
			"order"=>"CategoriasArchivo.id ASC",
			"recursive"=>0
        ));
        foreach ($categoriasArr as $value) {
                 $categoriasArchivos[$value["CategoriasArchivo"]["id"]] = $value["CategoriasArchivo"]["nombre"];   
        }    
        $this->set(compact('categoriasArchivos'));

    }
    
    /**
    * edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function edit($id = null) {
        if (!$this->Archivo->exists($id)) {
            throw new NotFoundException(__('Invalid archivo'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Archivo->save($this->request->data)) {
                $this->Session->setFlash(__('The archivo has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The archivo could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Archivo.' . $this->Archivo->primaryKey => $id));
            $this->request->data = $this->Archivo->find('first', $options);
        }
        $categoriasArchivos = $this->Archivo->CategoriasArchivo->find('list');
        $this->set(compact('categoriasArchivos'));
    }
    
    /**
    * delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function delete($id = null) {
        $this->Archivo->id = $id;
        if (!$this->Archivo->exists()) {
            throw new NotFoundException(__('Invalid archivo'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Archivo->delete()) {
            $this->Session->setFlash(__('The archivo has been deleted.'));
        } else {
            $this->Session->setFlash(__('The archivo could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    public function archivos_list(){
        
        $this->autoRender = false;
        $archivos = $this->Archivo->find("all", array(
           "order"=>"Archivo.id ASC"
        ));
        if(!empty($archivos))
        {
            foreach ($archivos as $archivo)
            {
                $respuesta[] = array(
                "id"=>$archivo["Archivo"]["id"],
                "leccion"=>$archivo["Archivo"]["leccion"],
                "ruta"=>$archivo["Archivo"]["ruta"],
                "categorias_archivo_id"=>$archivo["Archivo"]["categorias_archivo_id"],
                "nombre"=>$archivo["Archivo"]["nombre"]
                );
            }
        }else
        {
            $respuesta = array();
        }
        return json_encode($respuesta);
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