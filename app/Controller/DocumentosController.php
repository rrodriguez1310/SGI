<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');

class DocumentosController extends AppController {

	public function delete() {
		$this->layout = "ajax";
		if ($this->Session->read('Users.flag') == 1) {
			$this->Documento->id = $this->data["id"];
			if ($this->Documento->exists()) {
				$documento = $this->Documento->find('first', array(
					'conditions'=>array(
						'Documento.id'=>$this->data["id"]
					), 
					'recursive' => -1
				));
				if($documento['Documento']['tipos_documento_id'] == 10) {
					$this->loadModel('Retiro');
					$retiro = $this->Retiro->find('first', array(
						'recursive' => -1, 
						'conditions' => array(
							'Retiro.documento_id' => $documento['Documento']['id']
						)
					));
					if(!empty($retiro)) {
						$this->Retiro->id = $retiro['Retiro']['id'];
						if(!$this->Retiro->delete()) {
							$this->set("respuesta", json_encode(array(
								"estado"=>0,
								"mensaje"=>"No se puedo eliminar retiro asociado, por favor comunicate con el administrador"
							)));
							return; 
						}	
					};
				}
				if ($this->Documento->delete()) {
					if(!empty($documento["Documento"]["ruta"])){
						unlink(WWW_ROOT.'files'. DS .'trabajadores'. DS .$documento["Documento"]["ruta"] );	
					}
					CakeLog::write('actividad', 'elimino - Documentos - delete - '.$this->Documento->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"El documento se elimino con exito"
						);	
				} else {
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"No se pudo borrar el documento"
						);
				}
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"El archivo no existe"
					);
			}
			
		} else {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Perdio la sesión, por favor vuelta a ingresar al sistema e intentelo nuevamente"
				);
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function documentos_trabajador(){
		$this->layout = "ajax";
		$respuesta = $this->Documento->find("all", array(
			"conditions"=>array(
				"trabajadore_id"=>$this->request->query["trabajadore_id"]
				),
			"fields"=>array("Documento.id", "Documento.trabajadore_id", "Documento.tipos_documento_id", "Documento.fecha_inicial", "Documento.descripcion", "Documento.ruta", "Documento.fecha_final","TiposDocumento.nombre"),
			));
		$this->set("documentos", $respuesta);
	}

	public function upload_documento_trabajador(){
		$this->layout = "ajax";
		$respuesta = "";
		if(!empty($this->request->data)){
			$mensaje = "";
			if(isset($this->params->form)){		
				if($this->params->form["file"]['error'] == 0 && $this->params->form["file"]['size'] > 0){
					$destino = WWW_ROOT.'files'. DS .'trabajadores'. DS .$this->request->data["trabajadore_id"];					
					if (!file_exists($destino)){
						mkdir($destino, 0777, true);
						chmod($destino, 0777);
					}
					if(is_uploaded_file($this->params->form["file"]['tmp_name'])){
						if($this->params->form["file"]['size'] <= 20000000){
							$nombreArchivo = $this->params->form["file"]['name'];
							$destinoArchivo = $destino. DS .$nombreArchivo;
							while(file_exists($destinoArchivo)){
								$archivo = pathinfo($destinoArchivo);
								$archivoNombre = $archivo["filename"];
								$archivoExtension = $archivo["extension"];
								$nombreArchivo = $archivoNombre."(1).".$archivoExtension;
								$destinoArchivo = $destino. DS .$nombreArchivo;
							}
					        move_uploaded_file($this->params->form["file"]["tmp_name"],$destino. DS .$nombreArchivo);
					        $this->request->data["ruta"] = $this->request->data["trabajadore_id"] .DS.$nombreArchivo;
					        $mensaje = " y el archivo con nombre ".$nombreArchivo;
						}else{
							$respuesta = array(
								"estado"=>0,
								"mensaje"=>"Tamaño del archivo excedido"
								);
						}
					}else{
						$respuesta = array(
							"estado"=>0,
							"mensaje"=>"Hubo un error en la carga del archivo, por favor intentelo de nuevo"
							);
					}
				}		 
			}
			$this->loadModel("Documento");
			$this->request->data["Documento"] = $this->request->data;
			$this->request->data["Documento"]["fecha_inicial"] = DateTime::createFromFormat('d/m/Y', $this->request->data["Documento"]["fecha_inicial"])->format('Y-m-d');
			if(isset($this->request->data["Documento"]["fecha_final"])){
				$this->request->data["Documento"]["fecha_final"] = DateTime::createFromFormat('d/m/Y', $this->request->data["Documento"]["fecha_final"])->format('Y-m-d');
			}
			if ($this->Documento->save($this->request->data)) {
				CakeLog::write('actividad', 'subio - Documentos - upload_documento - '.$this->Documento->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario".$mensaje));
				$this->request->data["Documento"]["fecha_inicial"] = date('d/m/Y', strtotime($this->request->data["Documento"]["fecha_inicial"]));
				/*$id = $this->Documento->id;
				$respuesta = $this->Documento->find("all", array('order'=>'Documento.fecha_inicial DESC', 'conditions'=>array('Documento.trabajadore_id'=>$this->request->data["trabajadore_id"])));*/
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>$this->Documento->id
					);
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Se produjo un error al intentar guardar en la base de datos, por favor intentelo de nuevo"
					);
			}
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Se produjo un error, por favor intentelo de nuevo"
				);
		}

		$this->set("respuesta", json_encode($respuesta));
	}

	public function upload_archivo_trabajador(){
		$this->layout = "ajax";
		if(!empty($this->request->data)){
			if(isset($this->params->form)){				
				if($this->params->form["file"]['error'] == 0 && $this->params->form["file"]['size'] > 0){
					$documento = $this->Documento->find('first', array('conditions'=>array('Documento.id'=>$this->request->data["id"])));
					$destino = WWW_ROOT.'files'. DS .'trabajadores'. DS .$documento["Documento"]["trabajadore_id"];					
					if (!file_exists($destino)){
						mkdir($destino, 0777, true);
						chmod($destino, 0777);
					}
					if(is_uploaded_file($this->params->form["file"]['tmp_name'])){
						if($this->params->form["file"]['size'] <= 20000000){
							$nombreArchivo = $this->params->form["file"]['name'];
							$destinoArchivo = $destino. DS .$nombreArchivo;
							while(file_exists($destinoArchivo)){
								$archivo = pathinfo($destinoArchivo);
								$archivoNombre = $archivo["filename"];
								$archivoExtension = $archivo["extension"];
								$nombreArchivo = $archivoNombre."(1).".$archivoExtension;
								$destinoArchivo = $destino. DS .$nombreArchivo;
							}
					        move_uploaded_file($this->params->form["file"]["tmp_name"],$destino. DS .$nombreArchivo);
					        $ruta = $documento["Documento"]["trabajadore_id"] .DS.$nombreArchivo;
					        $this->request->data["Documento"] = array(
								"id"=>$this->request->data["id"],
								"ruta"=>$ruta
								);
							if ($this->Documento->save($this->request->data)) {
								CakeLog::write('actividad', 'edito - Documentos - upload_archivo - '.$this->Documento->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
								$respuesta = array(
									"estado"=>1,
									"mensaje"=>"Se subio correctamente el documento"
									);
							} else {
								$respuesta = array(
									"estado"=>0,
									"mensaje"=>"No se pudo guardar el registro en la base de datos"
									);
							}
						}else{
							$respuesta = array(
								"estado"=>0,
								"mensaje"=>"El tamaño fue excedido"
								);
						}
					}else{
						$respuesta = array(
							"estado"=>0,
							"mensaje"=>"Se produjo un error en la subida del documento, por favor intentelo mas tarde"
							);
					}
				}else{
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"Se produjo un error en la subida del documento, por favor intentelo mas tarde"
						);
				}
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Se produjo un error en la subida del documento, por favor intentelo mas tarde"
					);
			}			
		}
		$this->set("respuesta", json_encode($respuesta));
	}

	public function comprobar_doc_trabajador_upload(){
		$this->layout = "ajax";
		$this->loadModel("Documento");
		if ($this->request-> is(array('get'))){
			$fecha = DateTime::createFromFormat('d/m/Y', $this->request->query["fecha_inicial"])->format('Y-m-d');
			$documento = $this->Documento->find("first", array('conditions'=>array('Documento.trabajadore_id'=>$this->request->query["id"], "Documento.tipos_documento_id"=>$this->request->query["tipos_documento_id"], "Documento.fecha_inicial"=>$fecha)));
			if(!empty($documento)){
				$respuesta = array(
					"estado"=>1
					);
			}else{	
				$respuesta = array(
					"estado"=>0
					);				
			}
		}
		$this->set('respuesta', json_encode($respuesta));
	}

	public function contratos_trabajadores(){
		$this->autoRender = false;
		$this->response->type("json");
		$contratos = $this->Documento->find("all", array(
			"conditions"=>array(
				"Documento.tipos_documento_id"=>array(1,3,4,7,23,24,25)
			),
			"fields"=>array(
				"Trabajadore.id",
				"Trabajadore.rut",
				"Trabajadore.nombre",
				"Trabajadore.apellido_paterno",
				"TiposDocumento.nombre",
				"Documento.fecha_inicial",
				"Documento.fecha_final",
				"Trabajadore.estado"
			),
			"recursive"=>0
		));
		foreach ($contratos as $contrato) {
			$respuesta[] = array(
				"id"=>$contrato["Trabajadore"]["id"],
				"rut"=>$contrato["Trabajadore"]["rut"],
				"nombre"=>$contrato["Trabajadore"]["nombre"],
				"apellido_paterno"=>$contrato["Trabajadore"]["apellido_paterno"],
				"tipo_documento"=>$contrato["TiposDocumento"]["nombre"],
				"fecha_inicial"=>empty($contrato["Documento"]["fecha_inicial"]) ? null : DateTime::createFromFormat('Y-m-d', $contrato["Documento"]["fecha_inicial"])->format("c"),
				"fecha_final"=>empty($contrato["Documento"]["fecha_final"]) ? null : DateTime::createFromFormat('Y-m-d', $contrato["Documento"]["fecha_final"])->format("c"),
				"estado_contrato"=>empty($contrato["Documento"]["fecha_final"]) ? "Vigente" : (($contrato["Documento"]["fecha_final"] < date('Y-m-d')) ? "Vencido" : (($contrato["Documento"]["fecha_final"] >= date('Y-m-d') && DateTime::createFromFormat('Y-m-d', $contrato["Documento"]["fecha_final"])<= DateTime::createFromFormat('Y-m-d', date("Y-m-d"))->modify("+30 day")) ? "Por vencer" : "Vigente")),
				"estado_trabajador"=>$contrato["Trabajadore"]["estado"]
			);
		}
		return json_encode($respuesta);
	}
}
