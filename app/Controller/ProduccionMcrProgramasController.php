<?php
App::uses('AppController', 'Controller');
/**
 * ProduccionMcrProgramas Controller
 *
 * @property ProduccionMcrPrograma $ProduccionMcrPrograma
 * @property PaginatorComponent $Paginator
 */
class ProduccionMcrProgramasController extends AppController {

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

	public function programas_list(){
    
        $this->autoRender = false;
        $programas = $this->ProduccionMcrPrograma->find("all", array(
            "order"=>"ProduccionMcrPrograma.nombre ASC",
            "recursive"=>1
        ));
        if(!empty($programas))
        {
            foreach ($programas as $programa)
            {
                $respuesta[] = array(
                "id"=>$programa["ProduccionMcrPrograma"]["id"],
                "nombre"=>$programa["ProduccionMcrPrograma"]["nombre"],
                "tipo"=>$programa["ProduccionMcrPrograma"]["tipo"]
				);
                
            }
        }else
        {
            $respuesta = array();
        }
		CakeLog::write('actividad', 'Programas - List - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
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
		if (!$this->ProduccionMcrPrograma->exists($id)) {
			throw new NotFoundException(__('Invalid programa'));
		}
		$options = array('conditions' => array('ProduccionMcrPrograma.' . $this->ProduccionMcrPrograma->primaryKey => $id));
		CakeLog::write('actividad', 'Programas - view - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
		$this->set('programa', $this->ProduccionMcrPrograma->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ProduccionMcrPrograma->create();
			if ($this->ProduccionMcrPrograma->save($this->request->data)) {
				$this->Session->setFlash('El programa ha sido Guardado.', 'msg_exito');
				
				return $this->redirect(array('action' => 'index'));
			} else {
				
				$this->Session->setFlash('Ocurrio un error intentelo nuevamente.', 'msg_fallo');
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
		if (!$this->ProduccionMcrPrograma->exists($id)) {
			throw new NotFoundException(__('Invalid programa'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProduccionMcrPrograma->save($this->request->data)) {
				$this->Session->setFlash('El programa ha sido Guardado.', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error intentelo nuevamente.', 'msg_fallo');
			}
		} else {
			$options = array('conditions' => array('ProduccionMcrPrograma.' . $this->ProduccionMcrPrograma->primaryKey => $id));
			$this->request->data = $this->ProduccionMcrPrograma->find('first', $options);
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
		$this->ProduccionMcrPrograma->id = $id;
		if (!$this->ProduccionMcrPrograma->exists()) {
			throw new NotFoundException(__('Invalid ProduccionMcrPrograma'));
		}
		//$this->request->allowMethod('post', 'delete');
		if ($this->ProduccionMcrPrograma->delete()) {
			CakeLog::write('actividad', 'ProduccionMcrProgramas - Delete - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
			 $this->Session->setFlash('El registro se elimino correctamente', 'msg_exito');
		} else {
			$this->Session->setFlash('Ocurrio un error intentelo nuevamente', 'msg_fallo');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
