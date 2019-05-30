<?php
App::uses('AppController', 'Controller');
/**
 * CompaniesComentarios Controller
 *
 * @property CompaniesComentario $CompaniesComentario
 * @property PaginatorComponent $Paginator
 */
class CompaniesComentariosController extends AppController {

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
		$this->CompaniesComentario->recursive = 0;
		$this->set('companiesComentarios', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CompaniesComentario->exists($id)) {
			throw new NotFoundException(__('Invalid companies comentario'));
		}
		$options = array('conditions' => array('CompaniesComentario.' . $this->CompaniesComentario->primaryKey => $id));
		$this->set('companiesComentario', $this->CompaniesComentario->find('first', $options));
	}

/**
 * list method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function lista_comentarios_json($company_id = null) {

		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("Companies");
		$companiesComentarios = $this->CompaniesComentario->find("all", array(
			"fields"=>array("Company.nombre","Company.id","Trabajadore.nombre","Trabajadore.apellido_paterno","Trabajadore.foto","ClasificacionComentario.clasificacion","CompaniesComentario.comentario","CompaniesComentario.ruta_archivos",
							"CompaniesComentario.estado","CompaniesComentario.created","CompaniesContacto.nombre","CompaniesContacto.apellido_paterno"),
			"joins"=>array(array("table" => "trabajadores",
					        	"alias" => "Trabajadore",
							    "type" => "LEFT",
							    "conditions" => array("User.trabajadore_id = Trabajadore.id")),
							array("table" => "companies_contactos",
					        	"alias" => "CompaniesContacto",
							    "type" => "LEFT",
							    "conditions" => array("CompaniesComentario.companies_contacto_id = CompaniesContacto.id"))),
			"conditions"=>array("CompaniesComentario.company_id"=>$company_id, "CompaniesComentario.estado"=>1),
			"order" => array('CompaniesComentario.created DESC')
		));

		//pr($companiesComentarios);

		if($companiesComentarios){
			foreach ($companiesComentarios as $companiesComentario) {
				$listaComentarios[]=array(
					"NombreCompania"=>$companiesComentario["Company"]["nombre"],
					"IdCompania"=>$companiesComentario["Company"]["id"],
					"NombreUsuario"=>trim($companiesComentario["Trabajadore"]["nombre"] .' '. $companiesComentario["Trabajadore"]["apellido_paterno"]),
					//"FotoUsuario"=>$this->webroot.'files'. DS .'trabajadores'. DS.$companiesComentario["Trabajadore"]["foto"],
					"Clasificacion"=>$companiesComentario["ClasificacionComentario"]["clasificacion"],
					"Comentario"=>$companiesComentario["CompaniesComentario"]["comentario"],
					"NombreContacto"=>trim($companiesComentario["CompaniesContacto"]["nombre"].' ' .$companiesComentario["CompaniesContacto"]["apellido_paterno"]),
					"Adjunto"=> ($companiesComentario["CompaniesComentario"]["ruta_archivos"])? $this->webroot.'files'. DS .'companies_comentarios'. DS .$companiesComentario["CompaniesComentario"]["ruta_archivos"]: '',
					"Estado"=>$companiesComentario["CompaniesComentario"]["estado"],
					"Fecha"=>date('d/m/y H:i',strtotime($companiesComentario["CompaniesComentario"]["created"].'- 3 hours')),
				);
			}
		}else{
			$listaComentarios = array();
		}

		$datosListaComentarios=array();
		$datosListaComentarios["ListaComentarios"] = $listaComentarios;
		$datosListaComentarios["IdEmpresa"] = $company_id;

		$this->set("datosListaComentarios",$datosListaComentarios);
	}
/**
 * list method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */

	public function add_json($company_id = null) { 	//  $id  ajax => $this->request->params  

		$this->layout = "ajax";

		$this->response->type('json');

		$this->loadModel("Company");
		$empresa = $this->Company->find("first", array(
			"fields"=>array("Company.id", "Company.rut", "Company.razon_social"),
			"conditions"=>array("Company.id"=>$company_id),
			"recursive"=>0
		));

		$this->loadModel("CompaniesContacto");
		$listaContactos = $this->CompaniesContacto->find("all", array(
			"fields"=>array("CompaniesContacto.id", "CompaniesContacto.nombre", "CompaniesContacto.apellido_paterno"),
			"conditions"=>array("CompaniesContacto.company_id"=>$company_id),
			"recursive"=>0
		));

		if($listaContactos){
			foreach ($listaContactos as $contacto) {
				$listaContacto[] = array(
						"idContacto"=>$contacto["CompaniesContacto"]["id"],
						"nombre_completo"=>$contacto["CompaniesContacto"]["nombre"] .' '. $contacto["CompaniesContacto"]["apellido_paterno"],
						//"apellido"=>$contacto["CompaniesContacto"]["apellido_paterno"],
					);
			}	
		}else {
			$listaContacto = array();
		}

		$this->loadModel("ClasificacionComentario");
		$listaClasificaciones = $this->ClasificacionComentario->find("all", array(
			"order" => array('ClasificacionComentario.id ASC'),
			"fields"=>array("ClasificacionComentario.id", "ClasificacionComentario.clasificacion"),
			"recursive"=>0
		));

		foreach ($listaClasificaciones as $clasificacion) {
			$listaClasificacion[] = array(
					"idClasificacion"=>$clasificacion["ClasificacionComentario"]["id"],
					"clasificacion"=>$clasificacion["ClasificacionComentario"]["clasificacion"],
				);
		}
		
		$datosAddComentario=array();
		$datosAddComentario["ListaClasificacion"] = $listaClasificacion;
		$datosAddComentario["Empresa"] = $empresa["Company"];
		$datosAddComentario["ListaContacto"] = $listaContacto;
		
		$this->set("datosAddComentario",$datosAddComentario);
		
	}
	

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->layout = "ajax";

		$estado = '';

		if ($this->request->is('post')) {
		
			if(!empty($this->request->params["form"]["file"]))
			{

				if($this->request->params["form"]["file"]['error']==0 && $this->request->params["form"]["file"]['size'] > 0)
				{
	             	$destino = WWW_ROOT.'files'.DS.'companies_comentarios'.DS.date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario');   
	             	if (!file_exists($destino))
					{
						mkdir($destino, 0777, true);
						chmod($destino, 0777);
					}

					if(is_uploaded_file($this->request->params["form"]["file"]['tmp_name']))
					{	

						if($this->request->params["form"]["file"]['size'] <= 2000000)
						{
							move_uploaded_file($this->params["form"]["file"]['tmp_name'], $destino . DS .$this->params["form"]["file"]['name']);
						}
						else
						{
							$estado = 3;							
						}								
					}
					else
					{
						$estado = 2;							
					}
				} else {

					if($this->request->params["form"]["file"]['error'])
						$estado = 'error de archivo cod '.$this->request->params["form"]["file"]['error'];	
					else
						$estado = 3;
				}

				if($estado == '') {

					$this->request->data["ruta_archivos"] = date("Y_m_d_H_i").DS.$this->Session->read('PerfilUsuario.idUsuario') . DS .$this->params["form"]["file"]['name'];	
				}
			}

			if($estado == ''){

				if ($this->CompaniesComentario->save($this->request->data)) {
					$estado = 1;
				} else {
					$estado = 0;
				}	
			}										
		}

		echo $estado;
		exit;
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CompaniesComentario->exists($id)) {
			throw new NotFoundException(__('Invalid companies comentario'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CompaniesComentario->save($this->request->data)) {
				$this->Session->setFlash(__('The companies comentario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The companies comentario could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CompaniesComentario.' . $this->CompaniesComentario->primaryKey => $id));
			$this->request->data = $this->CompaniesComentario->find('first', $options);
		}
		$companies = $this->CompaniesComentario->Company->find('list');
		$users = $this->CompaniesComentario->User->find('list');
		$clasificacionComentarios = $this->CompaniesComentario->ClasificacionComentario->find('list');
		$this->set(compact('companies', 'users', 'clasificacionComentarios'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CompaniesComentario->id = $id;
		if (!$this->CompaniesComentario->exists()) {
			throw new NotFoundException(__('Invalid companies comentario'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CompaniesComentario->delete()) {
			$this->Session->setFlash(__('The companies comentario has been deleted.'));
		} else {
			$this->Session->setFlash(__('The companies comentario could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
