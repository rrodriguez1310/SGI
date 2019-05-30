<?php
App::uses('AppController', 'Controller');
/**
 * ProduccionMcrReceptores Controller
 *
 * @property ProduccionMcrReceptore $ProduccionMcrReceptore
 * @property PaginatorComponent $Paginator
 */
class ProduccionMcrReceptoresController extends AppController {

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

	public function receptores_list(){
    
        $this->autoRender = false;
        $receptores = $this->ProduccionMcrReceptore->find("all", array(
            "order"=>"ProduccionMcrReceptore.nombre ASC",
            "recursive"=>1
        ));
		
        if(!empty($receptores))
        {
            foreach ($receptores as $receptore)
            {
                $respuesta[] = array(
                "id"=>$receptore["ProduccionMcrReceptore"]["id"],
                "nombre"=>$receptore["ProduccionMcrReceptore"]["nombre"],
                "medio"=>$receptore["TransmisionMedioTransmisione"]["nombre"]
				);
                
            }
        }else
        {
            $respuesta = array();
        }
		CakeLog::write('actividad', 'Receptores - List - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
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
		if (!$this->ProduccionMcrReceptore->exists($id)) {
			throw new NotFoundException(__('Invalid receptore'));
		}
		$options = array('conditions' => array('ProduccionMcrReceptore.' . $this->ProduccionMcrReceptore->primaryKey => $id));
		CakeLog::write('actividad', 'Receptores - View - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
		$this->set('produccionMcrReceptore', $this->ProduccionMcrReceptore->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ProduccionMcrReceptore->create();
			if ($this->ProduccionMcrReceptore->save($this->request->data)) {
				CakeLog::write('actividad', 'ProduccionMcrReceptores - Add - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
				$this->Session->setFlash('El receptor ha sido Guardado.', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error intentelo nuevamente.', 'msg_fallo');
			}
		}
		$transmisionMediosArr = $this->ProduccionMcrReceptore->TransmisionMedioTransmisione->find('all',array(
                    'fields' => array('TransmisionMedioTransmisione.id','TransmisionMedioTransmisione.nombre'),
                    "order"=>"TransmisionMedioTransmisione.id ASC",
                    "recursive"=>0
        )); 
        foreach ($transmisionMediosArr as $value) {
            $transmisionMedioTransmisiones[$value["TransmisionMedioTransmisione"]["id"]] = $value["TransmisionMedioTransmisione"]["nombre"];
        }
        $this->set(compact('transmisionMedioTransmisiones'));

		//$transmisionMedioTransmisiones = $this->ProduccionMcrReceptore->TransmisionMedioTransmisione->find('list');
		//$this->set(compact('transmisionMedioTransmisiones'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ProduccionMcrReceptore->exists($id)) {
			throw new NotFoundException(__('Invalid ProduccionMcrReceptore'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProduccionMcrReceptore->save($this->request->data)) {
				CakeLog::write('actividad', 'Receptores - Edit - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
				$this->Session->setFlash('El receptor ha sido Guardado.', 'msg_exito');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Ocurrio un error intentelo nuevamente.', 'msg_fallo');
			}
		} else {
			$options = array('conditions' => array('ProduccionMcrReceptore.' . $this->ProduccionMcrReceptore->primaryKey => $id));
			$this->request->data = $this->ProduccionMcrReceptore->find('first', $options);
		}
		$transmisionMediosArr = $this->ProduccionMcrReceptore->TransmisionMedioTransmisione->find('all',array(
                    'fields' => array('TransmisionMedioTransmisione.id','TransmisionMedioTransmisione.nombre'),
                    "order"=>"TransmisionMedioTransmisione.id ASC",
                    "recursive"=>0
        )); 
        foreach ($transmisionMediosArr as $value) {
            $transmisionMedioTransmisiones[$value["TransmisionMedioTransmisione"]["id"]] = $value["TransmisionMedioTransmisione"]["nombre"];
        }
        $this->set(compact('transmisionMedioTransmisiones'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ProduccionMcrReceptore->id = $id;
		if (!$this->ProduccionMcrReceptore->exists()) {
			throw new NotFoundException(__('Invalid receptore'));
		}
		//$this->request->allowMethod('post', 'delete');
		if ($this->ProduccionMcrReceptore->delete()) {
			CakeLog::write('actividad', 'Receptores - Delete - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
			 $this->Session->setFlash('El registro se elimino correctamente', 'msg_exito');
		} else {
			$this->Session->setFlash('Ocurrio un error intentelo nuevamente', 'msg_fallo');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
