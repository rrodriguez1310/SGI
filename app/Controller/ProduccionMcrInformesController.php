<?php
App::uses('AppController', 'Controller');
/**
 * ProduccionMcrInformes Controller
 *
 * @property ProduccionMcrInforme $ProduccionMcrInforme
 * @property PaginatorComponent $Paginator
 */
class ProduccionMcrInformesController extends AppController {

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
    * index method
    *
    * @return void
    */
    public function informes_list(){
	  
        $this->autoRender = false;
        $informes = $this->ProduccionMcrInforme->find("all", array(
            "order"=>"ProduccionMcrInforme.id DESC",
            "recursive"=>0
        ));
		
        if(!empty($informes))
        {
            $satelite = "";
            foreach ($informes as $informe)
            {
                $respuesta[] = array(
                "id"=>$informe["ProduccionMcrInforme"]["id"],
                "programas"=> unserialize($informe["ProduccionMcrInforme"]["programas"]),
                "evento"=> unserialize($informe["ProduccionMcrInforme"]["evento"]),
                "user"=>$informe["User"]["nombre"]
                );
                
                if(!empty(unserialize($informe["ProduccionMcrInforme"]["satelite2"]))){
                	$satelite[$informe["ProduccionMcrInforme"]["id"]] = unserialize($informe["ProduccionMcrInforme"]["satelite2"]);
                }
            }
            
            
            $x = "";

            foreach($satelite as $key => $value){
                if(!empty($value['respaldo_meta']['prestador'][0]['nombre'])){
                    $x[$key] = $value['respaldo_meta']['prestador'][0]['nombre'];
                    //pr($value['respaldo_meta']['prestador'][0]['nombre']);
                }
            }
            
            $salida = "";

            foreach ($respuesta as $key => $value) {
                $salida[] = array(
                    "id" => $value['id'],
                    "programas"=> $value["programas"],
                    "evento"=> $value["evento"],
                    "user"=>$value["user"],
                    "satelite" => (isset($x[$value['id']]) ? $x[$value['id']] : "sin informacion")
                );	
            }
        }else
        {
            $salida = array();
        }
		CakeLog::write('actividad', 'Informe Transmisiones - List - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
        return json_encode($salida);
    }
	public function trabajadoresCargos($idCargos)
	{
		$this->loadModel("Trabajadore");
		$this->loadModel("ProduccionNombreRostro");	

		$cargosTrabajadores  = $this->Trabajadore->find("all", array(
			"conditions"=>array("Trabajadore.cargo_id"=>$idCargos, 
				"Trabajadore.estado"=>"Activo",
				"Trabajadore.id !=" => array()),
			"fields"=>array(
				"Trabajadore.id",
				"Trabajadore.nombre",
				"Trabajadore.apellido_paterno",
				"Trabajadore.apellido_materno",
				"Trabajadore.cargo_id"
			),
			"recursive"=>-1
		));

		$nombreRostros = $this->ProduccionNombreRostro->find("list",array( 
			"conditions"=>array("tipo_relacion"=>'T'), 
			"fields"=>array("relacion_id","nombre")
		));
		$cargosTrabajadoresArray = "";

		foreach($cargosTrabajadores as $cargosTrabajadore)
		{
			 $cargosTrabajadoresArray[] = array(
				'id' => (string)$cargosTrabajadore['Trabajadore']['id'],
			 'nombre' => $cargosTrabajadore['Trabajadore']['nombre'].' '.$cargosTrabajadore['Trabajadore']['apellido_paterno']
			 );	
		}	
		return $cargosTrabajadoresArray;
	}

	public function obtTrabajadoresEmpresas($idCombinados){

		$trabajadores = array();
		$empresas = array();
		$nombres = array();
	
		if(!empty($idCombinados)){
			foreach ($idCombinados as $id) {
				$formato = explode(":",$id);
				($formato[0]=='T') ? $trabajadores[] = $formato[1] : $empresas[] = $formato[1];
			}
			$empresas = !empty($empresas) ? $this->trabajadoresEmpresaID($empresas) : $empresas;	
			$trabajadores = !empty($trabajadores) ? $this->obtTrabajadores($trabajadores) : $trabajadores;
			$nombres = array_merge($trabajadores, $empresas);	
		}
		return $nombres;
	}
	public function obtTrabajadores($idTrabajadores){
		$this->loadModel("Trabajadore");
		$this->loadModel("ProduccionNombreRostro");
				
		$cargosTrabajadores  = $this->Trabajadore->find("all", array(
			"conditions"=>array("Trabajadore.id"=>$idTrabajadores),
			"fields"=>array(
				"Trabajadore.id",
				"Trabajadore.nombre",
				"Trabajadore.apellido_paterno",			
			),
			"recursive"=>-1
		));
		$nombreRostros = $this->ProduccionNombreRostro->find("list",array(
			"conditions"=>array("tipo_relacion"=>'T'),
			"fields"=>array("relacion_id","nombre")
		));
		
		$cargosTrabajadoresArray = "";
		foreach($cargosTrabajadores as $cargosTrabajadore)
		{
			$nombre = (isset($nombreRostros[$cargosTrabajadore["Trabajadore"]["id"]]))? $nombreRostros[$cargosTrabajadore["Trabajadore"]["id"]]: strtok($cargosTrabajadore["Trabajadore"]["nombre"], " ").' '.$cargosTrabajadore["Trabajadore"]["apellido_paterno"];
			$cargosTrabajadoresArray[$cargosTrabajadore["Trabajadore"]["id"]] = mb_strtoupper($nombre); 
		}
		return $cargosTrabajadoresArray;
	}
	/**
	* view method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function informes_view($id = null) {
		$this->layout = "ajax";
        $this->response->type('json');
		$this->loadModel('ProduccionPartidosEvento');
		$this->loadModel('ProduccionMcrReceptore');
		$this->loadModel('ProduccionMcrPrograma');
		$this->loadModel('TransmisionSenale');
		$this->loadModel('Channel');
		if (!$this->ProduccionMcrInforme->exists($id)) {
			throw new NotFoundException(__('Invalid informes transmisione'));
		}
		$options = array('conditions' => array('ProduccionMcrInforme.' . $this->ProduccionMcrInforme->primaryKey => $id));
		$respuesta= $this->ProduccionMcrInforme->find('first', $options);

		$respuesta["ProduccionMcrInforme"]["otros"] = unserialize($respuesta["ProduccionMcrInforme"]["otros"]);
		$respuesta["ProduccionMcrInforme"]["evento"] = unserialize($respuesta["ProduccionMcrInforme"]["evento"]);
		$respuesta["ProduccionMcrInforme"]["satelite2"] = unserialize($respuesta["ProduccionMcrInforme"]["satelite2"]);
		$respuesta["ProduccionMcrInforme"]["fibra_optica"] = unserialize($respuesta["ProduccionMcrInforme"]["fibra_optica"]);
		$respuesta["ProduccionMcrInforme"]["micro_ondas"] = unserialize($respuesta["ProduccionMcrInforme"]["micro_ondas"]);
		$respuesta["ProduccionMcrInforme"]["programas"] = unserialize($respuesta["ProduccionMcrInforme"]["programas"]);
		$respuesta["ProduccionMcrInforme"]["tipo"] = unserialize($respuesta["ProduccionMcrInforme"]["tipo"]);
		$idEvento = $respuesta["ProduccionMcrInforme"]["produccion_partidos_evento_id"];
       
        $informePartidos = $this->ProduccionPartidosEvento->find('all', array(
        'fields'=>array(
        'initcap(Campeonato.nombre) as Campeonato__nombre',
        //'initcap(Campeonato.nombre_fantasia) as Campeonato__nombre_fantasia',
        'initcap(Equipo.nombre_marcador) as Equipo__nombre',
        'initcap(EquipoVisita.nombre_marcador) as EquipoVisita__nombre',
        'Estadio.id',
        'initcap(Estadio.nombre) as Estadio__nombre',
        'Estadio.regione_id',
        'initcap(Estadio.ciudad) as Estadio__ciudad',
        'initcap(Categoria.nombre) as Categoria__nombre',
        'ProduccionPartidosEvento.id',
        'ProduccionPartidosEvento.campeonato_id',
        'ProduccionPartidosEvento.fixture_partido_id',
        'ProduccionPartidosEvento.fecha_partido',
        'ProduccionPartidosEvento.hora_partido',
        'ProduccionPartidosEvento.hora_partido_gmt',
        'ProduccionPartidosTransmisione.hora_transmision',
        'ProduccionPartidosTransmisione.hora_transmision_gmt',
        'ProduccionPartidosTransmisione.hora_termino_transmision',
        'ProduccionPartidosTransmisione.hora_termino_transmision_gmt',
        'ProduccionPartidosTransmisione.proveedor_company_id',
        'ProduccionPartidosTransmisione.transmisiones_movile_id',
        'ProduccionPartidosTransmisione.numero_partido_id',
        'ProduccionPartidosTransmisione.tipo_transmisione_id',
		'ProduccionPartidosTransmisione.senales',
		'ProduccionPartido.productor',
        'Subcategoria.nombre'),
        'order'=>array('ProduccionPartidosEvento.fecha_partido'=>'asc'),
        'conditions'=>array(
        'ProduccionPartidosEvento.estado_produccion'=>1,
		'ProduccionPartidosEvento.id'=>$idEvento),
        'recursive' => 1
        ));
		
		if(!empty($informePartidos)){
        foreach ($informePartidos as $value) {
			 $informeArray = array(
             'id' => $value['ProduccionPartidosEvento']['id'],
             'equipos' => $value['equipo']['nombre']." vs ".$value['equipovisita']['nombre'],
			 'campeonato' => $value['campeonato']['nombre'],
			 'estadio' => $value['estadio']['nombre'],
			 'nombre_fecha_partido'=> $value['categoria']['nombre'],
			 'fecha_partido' => date("d-m-Y", strtotime($value['ProduccionPartidosEvento']['fecha_partido'])),
			 'hora_transmision'=> $value['ProduccionPartidosTransmisione']['hora_transmision'],
			 'hora_termino_transmision'=> $value['ProduccionPartidosTransmisione']['hora_termino_transmision'],
			 'hora_termino_transmision'=> $value['ProduccionPartidosTransmisione']['hora_termino_transmision'],
			 'tipo_transmisione_id'=> $value['ProduccionPartidosTransmisione']['tipo_transmisione_id'],
			 'senales'=>  $this->listadoSenales(unserialize($value['ProduccionPartidosTransmisione']['senales'])),
			 'productor'=>  unserialize($value['ProduccionPartido']['productor'])? implode(",", $this->obtTrabajadoresEmpresas(unserialize($value["ProduccionPartido"]["productor"]))) : ''
			 );
          }
		}

		$señales = $this->Channel->find('all', array(
			'conditions'=>array(
			'Channel.id <= '=>5, "Channel.id not" => 4),
			"fields"=>array( "Channel.id", "Channel.nombre"), 
			"order" => "Channel.id" )
			
		);
		foreach ($señales as $value) {
			 $senalesArray[] = array(
             'id' => (string)$value['Channel']['id'],
			 'nombre' => $value['Channel']['nombre']
			 );	
        }    
		$receptores = $this->ProduccionMcrReceptore->find('all', array(
			"fields"=>array( "ProduccionMcrReceptore.id", "ProduccionMcrReceptore.nombre","ProduccionMcrReceptore.transmision_medio_transmisione_id"), 
			"order" => "ProduccionMcrReceptore.id" )
		);
		foreach ($receptores as $value) {
			 $receptoresArray[] = array(
             'id' => (string)$value['ProduccionMcrReceptore']['id'],
			 'nombre' => $value['ProduccionMcrReceptore']['nombre'],
			 'medio' => (string)$value["ProduccionMcrReceptore"]["transmision_medio_transmisione_id"]
			 );
        }
		$programas = $this->ProduccionMcrPrograma->find('all', array(
			"fields"=>array( "ProduccionMcrPrograma.id", "ProduccionMcrPrograma.nombre"), 
			"order" => "ProduccionMcrPrograma.id" )
		);
		foreach ($programas as $value) {
			 $programaArray[] = array(
             'id' => $value['ProduccionMcrPrograma']['id'],
			 'nombre' => $value['ProduccionMcrPrograma']['nombre']
			 );	
        }
		$trasmisionSenales = $this->TransmisionSenale->find('all', array(
			"fields"=>array( "TransmisionSenale.id", "TransmisionSenale.nombre","TransmisionSenale.transmision_medio_transmisione_id"), 
			"order" => "TransmisionSenale.id" )
		);
		foreach ($trasmisionSenales as $value) {
			 $trasmisionSenalesArray[] = array(
             'id' => $value['TransmisionSenale']['id'],
			 'nombre' => $value['TransmisionSenale']['nombre'],
			 'medio' => $value["TransmisionSenale"]["transmision_medio_transmisione_id"]
			 );
        }
		$productores = $this->trabajadoresCargos(array(102,143,139,72,147,201));
		$respuesta['productores'] = $productores;
		$respuesta['receptoresArray']=$receptoresArray;
		$respuesta['programaArray']=$programaArray;
		$respuesta['trasmisionSenalesArray']=$trasmisionSenalesArray;
		$respuesta['senalesArray']=$senalesArray;
		if(!empty($informePartidos)){
		$respuesta['informeArray']=$informeArray;
		}else{
			$respuesta['informeArray']=null;
		}
	   $this->set('respuesta', json_encode($respuesta));
	}

	public function view($id = null) {	
		$this->layout = "angular";
        $existe = $this->ProduccionMcrInforme->find('first', array(
			"conditions" => array(
			'ProduccionMcrInforme.id' => $id,),
			"fields"=> array("ProduccionMcrInforme.id")
        ));
        if(!$existe){
            $this->Session->setFlash('La transmisión no se puede ver ya que el registro aún no existe, intente añadir transmisión.','msg_exito');
            return $this->redirect(array('action' => 'index'));
        }
		CakeLog::write('actividad', 'Informe Transmisiones - View - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
        $this->set("id", $id);
	}
	
	public function add() {
        $this->layout = "angular";      
    }

	public function listadoSenales($idSenal=null){
		$this->loadModel("Channel");
		$senalesNombres = $senalesTransmision = array();
		if($idSenal){
			$senalesTransmision = $this->Channel->find("all", array(
				"fields"=>array( "Channel.id", "Channel.nombre"), 
				"conditions"=> array( "Channel.id" => $idSenal ),
				"order" => "Channel.id" )
			);
			foreach ($senalesTransmision as $key => $value){
				$senalesNombres[$key] = $key == 5 ? "Estadio CDF" : $value;			
			}
		}	
		return $senalesNombres;
    }
	

	public function listadoProgramas($idSenal=null){
		$this->loadModel("ProduccionMcrPrograma");
		$senalesNombres = $senalesTransmision = array();
		if($idSenal){
			$senalesTransmision = $this->Channel->find("all", array(
				"fields"=>array( "Channel.id", "Channel.nombre"), 
				"conditions"=> array( "Channel.id" => $idSenal ),
				"order" => "Channel.id" )
			);
			foreach ($senalesTransmision as $key => $value){
				$senalesNombres[$key] = $key == 5 ? "Estadio CDF" : $value;			
			}
		}		
		return $senalesNombres;
    }

	/**
	* add method
	*
	* @return void
	*/
	public function add_informe_senales() {
		$this->layout = "ajax";
        $this->autoRender = false;
        $this->response->type("json");
		$this->loadModel('ProduccionPartidosEvento');	
		$this->loadModel('ProduccionMcrPrograma');	
		$this->loadModel("TransmisionSenale");
		$this->loadModel("ProduccionMcrReceptore");
		$this->loadModel("ProduccionPartido");
		$this->loadModel("Channel");

		if ($this->request->is('post')) {
            $idEvento = $this->request->data["programas"]["informes"]["evento"]["id"];
			CakeLog::write('actividad', 'Informe Transmisiones - Add - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
			$this->request->data["tipo"] = serialize($this->request->data["tipo"]);
			$this->request->data["otros"] = serialize($this->request->data["otros"]);
			$this->request->data["evento"] = serialize($this->request->data["evento"]);
			$this->request->data["satelite2"] = serialize($this->request->data["satelite2"]);
			$this->request->data["fibra_optica"] = serialize($this->request->data["fibra_optica"]);
			$this->request->data["micro_ondas"] = serialize($this->request->data["micro_ondas"]);
			$this->request->data["programas"] = serialize($this->request->data["programas"]);
			$this->request->data["user_id"] = $this->Session->read("PerfilUsuario.idUsuario");
			$this->request->data["produccion_partidos_evento_id"] = $idEvento;
			$this->ProduccionMcrInforme->create();
			if ($this->ProduccionMcrInforme->save($this->request->data)) {
				 $mensaje = array( "estado"=>1,"mensaje"=>"Datos registrados correctamente");
			} else {
				$mensaje = array("estado"=>0,"mensaje"=>"No se pudo registrar la información");
			}
        } 
        
		$señales = $this->Channel->find('all', array(
			'conditions'=>array(
			'Channel.id <= '=>5, "Channel.id not" => 4),
			"fields"=>array( "Channel.id", "Channel.nombre"), 
			"order" => "Channel.id" )
			
		);
		foreach ($señales as $value) {
			 $senalesArray2[] = array(
             'id' => $value['Channel']['id'],
			 'nombre' => $value['Channel']['nombre']
			 );	
        }
		$senalesArray3=serialize($senalesArray2);
		$senalesArray =unserialize($senalesArray3);
		
		$programas = $this->ProduccionMcrPrograma->find('all', array(
			"fields"=>array( "ProduccionMcrPrograma.id", "ProduccionMcrPrograma.nombre"), 
			"order" => "ProduccionMcrPrograma.id" )
		);
		foreach ($programas as $value) {
			 $programaArray[] = array(
             'id' => $value['ProduccionMcrPrograma']['id'],
			 'nombre' => $value['ProduccionMcrPrograma']['nombre']
			 );	
        }
		$trasmisionSenales = $this->TransmisionSenale->find('all', array(
			"fields"=>array( "TransmisionSenale.id", "TransmisionSenale.nombre","TransmisionSenale.transmision_medio_transmisione_id"), 
			"order" => "TransmisionSenale.id" )
		);
		foreach ($trasmisionSenales as $value) {
			 $trasmisionSenalesArray[] = array(
             'id' => $value['TransmisionSenale']['id'],
			 'nombre' => $value['TransmisionSenale']['nombre'],
			 'medio' => $value["TransmisionSenale"]["transmision_medio_transmisione_id"]
			 );	
        }
		$receptores = $this->ProduccionMcrReceptore->find('all', array(
			"fields"=>array( "ProduccionMcrReceptore.id", "ProduccionMcrReceptore.nombre","ProduccionMcrReceptore.transmision_medio_transmisione_id"), 
			"order" => "ProduccionMcrReceptore.id" )
		);
		foreach ($receptores as $value) {
			 $receptoresArray[] = array(
             'id' => $value['ProduccionMcrReceptore']['id'],
			 'nombre' => $value['ProduccionMcrReceptore']['nombre'],
			 'medio' => $value["ProduccionMcrReceptore"]["transmision_medio_transmisione_id"]
			 );
        }
		$fecha = date('Y-m-j');
		$productores = $this->trabajadoresCargos(array(102,143,139,72,147,201));
		$nuevafecha = strtotime ( '-2 day' , strtotime ( $fecha ) ) ;
        $dateShowData = date ( 'Y-m-j' , $nuevafecha );

		 $transmisionPartidos = $this->ProduccionPartidosEvento->find('all', array(
		'fields'=>array(
		'initcap(Campeonato.nombre) as Campeonato__nombre',
		//'initcap(Campeonato.nombre_fantasia) as Campeonato__nombre_fantasia',
		'initcap(Equipo.nombre_marcador) as Equipo__nombre',
		'initcap(EquipoVisita.nombre_marcador) as EquipoVisita__nombre',
		'Estadio.id',
		'initcap(Estadio.nombre) as Estadio__nombre',
		'Estadio.regione_id',
		'initcap(Estadio.ciudad) as Estadio__ciudad',
		'initcap(Categoria.nombre) as Categoria__nombre',
		'ProduccionPartidosEvento.id',
		'ProduccionPartidosEvento.campeonato_id',
		'ProduccionPartidosEvento.fixture_partido_id',
		'ProduccionPartidosEvento.fecha_partido',
		'ProduccionPartidosEvento.hora_partido',
		'ProduccionPartidosEvento.hora_partido_gmt',
		'ProduccionPartidosTransmisione.hora_transmision',
		'ProduccionPartidosTransmisione.hora_transmision_gmt',
		'ProduccionPartidosTransmisione.hora_termino_transmision',
		'ProduccionPartidosTransmisione.hora_termino_transmision_gmt',
		'ProduccionPartidosTransmisione.proveedor_company_id',
		'ProduccionPartidosTransmisione.transmisiones_movile_id',
		'ProduccionPartidosTransmisione.numero_partido_id',
		'ProduccionPartidosTransmisione.tipo_transmisione_id',
		'ProduccionPartidosTransmisione.senales',
		'ProduccionPartido.productor',
		'Subcategoria.nombre'),
		'order'=>array('ProduccionPartidosEvento.fecha_partido'=>'asc'),
		'conditions'=>array(
		'ProduccionPartidosEvento.estado_produccion'=>1,
		'ProduccionPartidosEvento.fecha_partido >=' => $dateShowData),
		'recursive' => 1
        ));
		
		 if(!empty($transmisionPartidos)){
           foreach ($transmisionPartidos as $value) {
				$mensajeArray[] = array(
				'id' => $value['ProduccionPartidosEvento']['id'],
				'equipos' => $value['equipo']['nombre']." vs ".$value['equipovisita']['nombre'],
				'campeonato' => $value['campeonato']['nombre'],
				'estadio' => $value['estadio']['nombre'],
				'nombre_fecha_partido'=> $value['categoria']['nombre'],
				'fecha_partido' => date("d-m-Y", strtotime($value['ProduccionPartidosEvento']['fecha_partido'])),
				'hora_transmision'=> $value['ProduccionPartidosTransmisione']['hora_transmision'],
				'hora_termino_transmision'=> $value['ProduccionPartidosTransmisione']['hora_termino_transmision'],
				'hora_termino_transmision'=> $value['ProduccionPartidosTransmisione']['hora_termino_transmision'],
				'tipo_transmisione_id'=> $value['ProduccionPartidosTransmisione']['tipo_transmisione_id'],
				'senales'=>  $this->listadoSenales(unserialize($value['ProduccionPartidosTransmisione']['senales'])),
				'productor'=>  unserialize($value['ProduccionPartido']['productor'])? implode(",", $this->obtTrabajadoresEmpresas(unserialize($value["ProduccionPartido"]["productor"]))) : ''
				);
           }
		}else{
            $mensajeArray = array();
        }
		$mensaje['productores'] = $productores;
        $mensaje['programaArray'] = $programaArray;
		$mensaje['mensajeArray'] = $mensajeArray;
		$mensaje['trasmisionSenalesArray'] = $trasmisionSenalesArray;
		$mensaje['receptoresArray']=$receptoresArray;
		$mensaje['senalesArray']=$senalesArray;
		return json_encode($mensaje);
	}

	/**
	* edit method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function edit($id = null) {
		$this->layout = "angular";
        $existe = $this->ProduccionMcrInforme->find('first', array(
			"conditions" => array(
			'ProduccionMcrInforme.id' => $id,),
			"fields"=> array("ProduccionMcrInforme.id")
        ));
        if(!$existe){
            $this->Session->setFlash('La transmisión no se puede ver ya que el registro aún no existe, intente añadir transmisión.','msg_exito');
            return $this->redirect(array('action' => 'index'));
        }
        
        $this->set("id", $id);
	}
	 public function informes_edit(){
        $this->layout = "ajax";
        if(!empty($this->request->data['id'])){
            if($this->request->is('post')){
				$idEvento = $this->request->data["programas"]["informes"]["evento"]["id"];
				CakeLog::write('actividad', 'Informe Transmisiones - Edit - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
				$this->request->data["otros"] = serialize($this->request->data["otros"]);
				$this->request->data["tipo"] = serialize($this->request->data["tipo"]);
				$this->request->data["evento"] = serialize($this->request->data["evento"]);
				$this->request->data["satelite2"] = serialize($this->request->data["satelite2"]);
				$this->request->data["fibra_optica"] = serialize($this->request->data["fibra_optica"]);
				$this->request->data["micro_ondas"] = serialize($this->request->data["micro_ondas"]);
				$this->request->data["programas"] = serialize($this->request->data["programas"]);
				$this->request->data["user_id"] = $this->Session->read("PerfilUsuario.idUsuario");
				$this->request->data["produccion_partidos_evento_id"] = $idEvento;
                if ($this->ProduccionMcrInforme->save($this->request->data)) {
                    $respuesta = array(
                    'estado'=>1,
                    'mensaje'=>'La transmision partido fue editada correctamente');
                }else{
                    $respuesta = array(
                    'estado'=>0,
                    'mensaje'=>'Ocurrió un error al intentar editar la transmision partido');
                }
            }
        }else{
            $respuesta = array(
            'estado'=>0,
            'mensaje'=>'Ocurrió un error al intentar editar la transmision partido');
        }
        $this->set("respuesta", json_encode($respuesta));
    }

	/**
	* delete method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public function delete($id = null) {
		$this->ProduccionMcrInforme->id = $id;
		if (!$this->ProduccionMcrInforme->exists()) {
			throw new NotFoundException(__('Informe Inalido'));
		}
		if ($this->ProduccionMcrInforme->delete()) {
			CakeLog::write('actividad', 'Informe Transmisiones - Delete - ' .  '(' .$this->Session->Read("PerfilUsuario.idUsuario") .')');
			$this->Session->setFlash('El informe ha sido eliminado.','msg_exito');	
		} else {
			$this->Session->setFlash('El informe no puede ser eliminado, Por favor intente nuevamente.','msg_fallo');
		}
		return $this->redirect(array('action' => 'index'));
	}
	

}
