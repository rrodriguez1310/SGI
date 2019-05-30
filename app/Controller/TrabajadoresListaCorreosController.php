<?php
App::uses('AppController', 'Controller');
/**
 * TrabajadoresListaCorreos Controller
 *
 * @property TrabajadoresListaCorreo $TrabajadoresListaCorreo
 * @property PaginatorComponent $Paginator
 */
class TrabajadoresListaCorreosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function registrar_trabajadores_lista_correos(){
		$this->layout = "ajax";

		if ($this->request->is(array('post', 'put'))) 
		{
			if($this->TrabajadoresListaCorreo->save($this->request->data)){
				CakeLog::write('actividad', 'agrego - TrabajadoresListaCorreos - registrar_trabajadores_lista_correos - '.$this->ListaCorreo->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>'La asociacion fue ingresado correctamente'
					);
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>'La asociacion no pudo ser agregada, por favor intente de nuevo o avise al administrador'
					);
			}	
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function eliminar_correo_asociado(){
		$this->layout = "ajax";
		$asociacion = $this->TrabajadoresListaCorreo->find("first", array(
			"conditions"=>array(
				"TrabajadoresListaCorreo.trabajadore_id"=>$this->request->data["trabajador"], 
				"TrabajadoresListaCorreo.lista_correo_id"=>$this->request->data["listaCorreo"]
				)
			)
		);
		$this->TrabajadoresListaCorreo->id = $asociacion["TrabajadoresListaCorreo"]["id"];
		if($this->TrabajadoresListaCorreo->exists()){
			if($this->request->is(array('post', 'put'))){
				if ($this->TrabajadoresListaCorreo->delete($this->TrabajadoresListaCorreo->id)) {
					CakeLog::write('actividad', 'elimino - TrabaajadoreListaCorreo - eliminarCorreoAsociado - '.$this->TrabajadoresListaCorreo->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$respuesta = array(
						"mensaje"=>"Se elimino correctamente del listado",
						"estado"=>1
						);
				} else {
					$respuesta = array(
						"mensaje"=>"No se pudo eliminar la lista",
						"estado"=>0
						);
				}
			}else{
				$respuesta = array(
					"mensaje"=>"No se puede eliminar",
					"estado"=>0
					);
			}	
		}else{
			$respuesta = array(
				"mensaje"=>"El mensaje no existe",
				"estado"=>0
				);
		}
		$this->set("resultado", json_encode($respuesta));
	}

}
