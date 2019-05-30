<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('TransmisionSenalesController', 'Controller');
App::uses('TransmisionCanalesController', 'Controller');

App::import(
'Vendor',
'phpexcel',
array('file' => 'phpexcel' . DS . 'Classes' . DS .'PHPExcel.php')
);
App::import(
'Vendor',
'phpexcel',
array('file' => 'phpexcel' . DS . 'Classes' . DS . 'PHPExcel' . DS . 'Writer' . DS . 'Excel2007.php')
);
App::import(
'Vendor',
'phpexcel',
array('file' => 'phpexcel' . DS . 'Classes' . DS . 'PHPExcel' . DS . 'IOFactory.php')
);
/**
* TransmisionPartidos Controller
*
* @property TransmisionPartido $TransmisionPartido
* @property PaginatorComponent $Paginator
*/
class TransmisionPartidosController extends AppController {
    
    /**
    * Components
    *
    * @var array
    */
    public $components = array('Paginator', 'RequestHandler');
    private $proveedorCompanies = array(1226 => "Chilefilms", 1842=>"Señal Cero", 551 => "Feres");
    
    public function index() {
        $this->acceso();
        $this->layout = "angular";
    }
    
    public function enviar_transmisiones() {
        $this->acceso();
        $this->set("appAngular", "angularAppText");
        $this->layout = "angular";
    }
    
    public function delete_transmision($id = null) {
        $this->autoRender = false;
        $this->TransmisionPartido->data['TransmisionPartido']['id'] = $id;
        $this->TransmisionPartido->data['TransmisionPartido']['user_id'] = $this->Session->read('PerfilUsuario.idUsuario');
        $this->TransmisionPartido->data['TransmisionPartido']['estado'] = 0;
        
        if ($this->TransmisionPartido->save($this->TransmisionPartido->data)) {
            CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->TransmisionPartido->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") );
            $this->Session->setFlash(__('La transmision partido ha sido eliminada.'));
        }else{
            $this->Session->setFlash(__('La transmision partido no ha podido ser eliminada. Por favor intenta de nuevo.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    public function transmision_lista_json(){
        $this->autoRender = false;
        $this->response->type('json');
        
        $this->loadModel('ProduccionPartidosEvento');
        $this->loadModel('ProduccionPartidosTransmisione');
        $this->loadModel('TipoTransmisione');
        $this->loadModel('Regione');
        
        $transmisionPartidos = $this->ProduccionPartidosEvento->find('all', array(
        'conditions'=>array(
        //'ProduccionPartidosEvento.estado_produccion'=>1,
        'ProduccionPartidosTransmisione.tipo_transmisione_id'=>1,
        'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d"))
        ));
        
        $regiones = $this->Regione->find('list', array(
        'fields' => array(
        'Regione.id',
        'Regione.region_ordinal')
        ));
        
        $transporteSenal = $this->TransmisionPartido->find('all', array(
        'conditions'=>array(
        'TransmisionPartido.produccion_partidos_evento_id !='=> "",
        'TransmisionPartido.estado !=' => 0),
        'fields' => array(
        'TransmisionPartido.produccion_partidos_evento_id',
        'TransmisionPartido.id',
        'TransmisionPartido.estado'
        ),
        'recursive' => -1
        ));
        
        
        foreach ($transporteSenal as $key => $value) {
            $value = (array)$value["TransmisionPartido"];
            $transmisionList[$value["produccion_partidos_evento_id"]]["id"] = $value["id"];
            $transmisionList[$value["produccion_partidos_evento_id"]]["estado"] = $value["estado"];
        }
        //pr($transmisionList);exit;
        foreach ($transmisionPartidos as $key => $value) {
            $id_partido = $value['ProduccionPartidosEvento']['id'];
            $error = false;
            
            if( isset($transmisionList[$id_partido]) ){
                if( $value['ProduccionPartidosEvento']['estado_produccion'] == 0 && $transmisionList[$id_partido]["estado"] != 2){
                    $error = true;
                }else{
                    $estado = $transmisionList[$id_partido]["estado"];
                }
            }else if ( !isset($transmisionList[$id_partido]) ){
                if($value['ProduccionPartidosEvento']['estado_produccion'] == 1){
                    $estado = 0;
                }else{
                    $error = true;
                }
            }
            
            if(!$error){
                $transmisionJson[] = array(
                'id' => $value['ProduccionPartidosEvento']['id'],
                'campeonato' => $value['Campeonato']['nombre'],
                'categoria' => $value['Categoria']['nombre'],
                'subcategoria' => $value['Subcategoria']['nombre'],
                'dia' => $value['ProduccionPartidosEvento']['fecha_partido'],
                'estadio' => $value['Estadio']['nombre'],
                'estadio_region' => $regiones[$value['Estadio']['regione_id']],
                'hora' => $value['ProduccionPartidosEvento']['hora_partido'],
                'local' => $value['Equipo']['nombre'],
                'visita' => $value['EquipoVisita']['nombre'],
                'transmisionPartido' => (isset($transmisionList[$value['ProduccionPartidosEvento']['id']])) ? $transmisionList[$value['ProduccionPartidosEvento']['id']]["id"] : "",
                'estado' =>	$estado
                );
            }
            
        }
        if(count($transmisionPartidos) > 0){
            return json_encode($transmisionJson);
        }else{
            $transmisionJson = array();
            return json_encode($transmisionJson);
        }
    }
    
    public function enviar_correo_transmisiones(){
        
        $this->layout = "ajax";
        $this->response->type("json");
        if(!empty($this->request->data['email'])){
            $correo = $this->request->data['email'];
            $asunto = $this->request->data['asunto'];
            $mensaje = $this->request->data['mensaje'];
            //$adjunto = $this->request->data['adjunto'];
            $Email = new CakeEmail("gmail");
            $Email->from(array('no-reply@cdf.cl' => 'SGI'));
            $Email->to($correo);
            
            //$Email->cc("cseverino@externo.cdf.cl");
            //$Email->bcc("cseverino@externo.cdf.cl");
            
            $Email->subject($asunto);
            $Email->emailFormat('html');
            $nombre_archivo_pdf = "transmision_pdf_".date("Y-m-d").".pdf";
            
            $archivos = array($nombre_archivo_pdf => array(
            'file' =>  WWW_ROOT.'files'.DS.'pdf'.DS.$nombre_archivo_pdf,
            'mimetype' => 'application/pdf',
            'contentId' => 'my-unique-id'
            )
            );
            
            $Email->attachments($archivos);
            
            if($Email->send($mensaje)){
                CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->TransmisionPartido->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") );
                $respuesta = array(
                "estado"=>1,
                "mensaje"=>"El correo ha sido enviado"
                );
                if(!unlink($archivos[$nombre_archivo_pdf]['file'])) $msgunlink = "no se pudo borrar el archivo";
            }else{
                $respuesta = array(
                "estado"=>0,
                "mensaje"=>"El correo NO ha sido enviado, por favor intente nuevamente."
                );
            }
        }else{
            $respuesta = array(
            "estado"=>0,
            "mensaje"=>"El correo NO ha sido enviado, por favor intente nuevamente."
            );
        }
        $this->set('respuesta',json_encode($respuesta));
    }
    
    public function transmision_lista_envio_json(){
        $this->autoRender = false;
        $this->response->type('json');
        
        $this->loadModel('ProduccionPartidosEvento');
        $this->loadModel('ProduccionPartidosTransmisione');
        $this->loadModel('TransmisionesMovile');
        $this->loadModel('NumeroPartido');
        $this->loadModel('TransmisionSenale');
        $this->loadModel('Regione');
        
        setlocale(LC_TIME, 'es_ES.UTF-8');
        
        $senales_controller = new TransmisionSenalesController;
        $senales = json_decode($senales_controller->senales_list());
        $senalesList = array();
        foreach ($senales as $key => $value) {
            $value = (array)$value;
            $senalesList[$value["id"]]["nombre"] = $value["nombre"];
            $senalesList[$value["id"]]["medio_tx"] = $value["medio_tx"];
            $senalesList[$value["id"]]["medio_id"] = $value["medio_id"];
        }
        
        $numeroPartidos = $this->NumeroPartido->find('list', array(
        'fields'=>array(
        'NumeroPartido.id',
        'NumeroPartido.nombre'
        )
        ));
        
        $transmisionMovile = $this->ProduccionPartidosTransmisione->find('all', array(
        'fields'=>array(
        'TransmisionesMovile.id',
        'TransmisionesMovile.nombre',
        'TransmisionesMovile.senal')
        ));
        
        $regiones = $this->Regione->find('list', array(
        'fields'=>array(
        'Regione.id',
        'Regione.region_ordinal')
        ));
        
        $transmisionPartidos = $this->ProduccionPartidosEvento->find('all', array(
        'fields'=>array(
        'Campeonato.nombre',
        'initcap(Campeonato.nombre_prefijo) as Campeonato__nombre_prefijo',
        'Equipo.nombre',
        'EquipoVisita.nombre',
        'Estadio.id',
        'Estadio.nombre',
        'Estadio.regione_id',
        'Estadio.ciudad',
        'Categoria.nombre',
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
        'TransmisionPartido.id',
        'TransmisionPartido.estado',
        'TransmisionPartido.produccion_partidos_evento_id',
        'TransmisionPartido.transmision_senales_principal_senale_id',
        'TransmisionPartido.transmision_senales_respaldo_senale_id',
        'TransmisionPartido.radio',
        'Subcategoria.nombre'),
        'order'=>array('Campeonato.nombre'=>'desc'),
        "joins"=>array( array("table" => "transmision_partidos", "alias" => "TransmisionPartido", "type" => "LEFT", "conditions" => array("TransmisionPartido.produccion_partidos_evento_id = ProduccionPartidosEvento.id" ))),
        'conditions'=>array(
        'TransmisionPartido.id !='=> null,
        'TransmisionPartido.estado'=> 1,
        'ProduccionPartidosTransmisione.tipo_transmisione_id'=>1,
        'ProduccionPartidosEvento.estado_produccion'=>1,
        'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d")),
        'recursive' => 0
        ));
        $campeonatoActual = array();
        foreach ($transmisionPartidos as $key => $partido) {
            $id=$partido["ProduccionPartidosEvento"]['id'];
            $existePrevia = $this->ProduccionPartidosEvento->find('all', array(
            "conditions" => array(
            'ProduccionPartidosEvento.id !='=>$id,
            'ProduccionPartidosEvento.estado_produccion'=>1,
            'ProduccionPartidosEvento.fixture_partido_id'=>$partido["ProduccionPartidosEvento"]['fixture_partido_id'],
            'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d"),
            'ProduccionPartidosTransmisione.tipo_transmisione_id'=>3
            ),
            "fields"=> array(
            'ProduccionPartidosTransmisione.tipo_transmisione_id',
            'ProduccionPartidosTransmisione.hora_transmision',
            'ProduccionPartidosTransmisione.hora_transmision_gmt'),
            'recursive'=>1
            ));
            
            if(!isset($campeonatoActual[$partido["ProduccionPartidosEvento"]["campeonato_id"]])){
                $partidosGroup[$id]['Campeonato'] = $partido['Campeonato'];
                $campeonatoActual[$partido["ProduccionPartidosEvento"]["campeonato_id"]] = true;
            }
            $fechastr = ucfirst( mb_strtolower( strftime("%A %d de %B de %Y", strtotime($partido["ProduccionPartidosEvento"]["fecha_partido"])) , 'UTF-8') );
            
            $partidosGroup[$id]['Transmision'] = $partido['TransmisionPartido'];
            
            if(isset($partido['TransmisionPartido']['transmision_senales_principal_senale_id'])){
                $partidosGroup[$id]['Transmision']['senal_principal_nombre'] = $senalesList[$partido['TransmisionPartido']['transmision_senales_principal_senale_id']]["medio_tx"]. " " .$senalesList[$partido['TransmisionPartido']['transmision_senales_principal_senale_id']]["nombre"];
            }else{
                $partidosGroup[$id]['Transmision']['senal_principal_nombre'] = "";
            }
            if(isset($partido['TransmisionPartido']['transmision_senales_respaldo_senale_id'])){
                $partidosGroup[$id]['Transmision']['senal_respaldo_nombre'] = $senalesList[$partido['TransmisionPartido']['transmision_senales_respaldo_senale_id']]["medio_tx"]. " " .$senalesList[$partido['TransmisionPartido']['transmision_senales_respaldo_senale_id']]["nombre"];
            }else{
                $partidosGroup[$id]['Transmision']['senal_respaldo_nombre'] = "";
            }
            
            if(isset($partido['TransmisionPartido']['radio'])){
                $partidosGroup[$id]['Transmision']['senal_radio_nombre'] = $senalesList[$partido['TransmisionPartido']['radio']]["medio_tx"]. " " .$senalesList[$partido['TransmisionPartido']['radio']]["nombre"];
            }else{
                $partidosGroup[$id]['Transmision']['senal_radio_nombre'] = "";
            }
            
            $partidosGroup[$id]['ProduccionPartidosEvento'] = $partido['ProduccionPartidosEvento'];
            $partidosGroup[$id]['ProduccionPartidosEvento']['fecha_string'] = $fechastr;
            $partidosGroup[$id]['Equipo'] = $partido['Equipo'];
            $partidosGroup[$id]['EquipoVisita'] = $partido['EquipoVisita'];
            $partidosGroup[$id]['Categoria'] = $partido['Categoria'];
            $partidosGroup[$id]['Estadio'] = $partido['Estadio'];
            $partidosGroup[$id]['Estadio']['region_ordinal'] = $regiones[$partido['Estadio']['regione_id']];
            $partidosGroup[$id]['ProduccionPartidosTransmisione'] = $partido['ProduccionPartidosTransmisione'];
            
            if(isset($existePrevia[0]['ProduccionPartidosTransmisione']['tipo_transmisione_id']) && $existePrevia[0]['ProduccionPartidosTransmisione']['tipo_transmisione_id'] == 3){
                $partidosGroup[$id]['ProduccionPartidosTransmisione']['hora_transmision'] = $existePrevia[0]['ProduccionPartidosTransmisione']['hora_transmision'];
                $partidosGroup[$id]['ProduccionPartidosTransmisione']['hora_transmision_gmt'] = $existePrevia[0]['ProduccionPartidosTransmisione']['hora_transmision_gmt'];
            }
            
            $partidosGroup[$id]['ProduccionPartidosTransmisione']['nombre_partido'] = $numeroPartidos[$partido['ProduccionPartidosTransmisione']['numero_partido_id']];
            $partidosGroup[$id]['NombreProveedor'] = $this->proveedorCompanies[$partido["ProduccionPartidosTransmisione"]["proveedor_company_id"]];
            $partidosGroup[$id]['TransmisionMovile'] = $transmisionMovile[$partido['ProduccionPartidosTransmisione']['transmisiones_movile_id']]['TransmisionesMovile'];
        }
        
        $respuesta = array(
        "estado"=>0,
        "mensaje"=>"No existe ningún registro por el momento, asigne desde Transmision Partidos"
        );
        
        if(count($transmisionPartidos) > 0){
            return json_encode($partidosGroup);
        }else{
            return json_encode($respuesta);
        }
    }
    
    public function edit($id = null) {
        $this->acceso();
        $this->layout = "angular";
        
        $existe = $this->TransmisionPartido->find('first', array(
        "conditions" => array(
        'TransmisionPartido.produccion_partidos_evento_id' => $id,
        'TransmisionPartido.estado !=' =>0),
        "fields"=> array("TransmisionPartido.id")
        ));
        if(!$existe){
            $this->Session->setFlash('La transmisión no se puede editar ya que el registro aún no existe, intente añadir transmisión.','msg_exito');
            return $this->redirect(array('action' => 'index'));
        }
        
        $this->set("id", $id);
    }
    
    public function view($id = null) {
        $this->acceso();
        $this->layout = "angular";
        
        $existe = $this->TransmisionPartido->find('first', array(
        "conditions" => array(
        'TransmisionPartido.produccion_partidos_evento_id' => $id,
        'TransmisionPartido.estado !=' =>0),
        "fields"=> array("TransmisionPartido.id")
        ));
        if(!$existe){
            $this->Session->setFlash('La transmisión no se puede ver ya que el registro aún no existe, intente añadir transmisión.','msg_exito');
            return $this->redirect(array('action' => 'index'));
        }
        
        $this->set("id", $id);
    }
    
    public function editar_transmision_guardar(){
        $this->layout = "ajax";
        $this->loadModel("TransmisionPartido");
        
        if(!empty($this->request->data['id'])){
            if($this->request->is('post')){
                if ($this->TransmisionPartido->save($this->request->data)) {
                    CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->TransmisionPartido->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") );
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
    
    public function edit_transmision($id = null) {
        $this->layout = "ajax";
        $this->response->type('json');
        $this->loadModel("ProduccionPartidosEvento");
        $this->loadModel("ProduccionPartidosTransmisione");
        $this->loadModel("TransmisionTipoEvento");
        $this->loadModel("TransmisionSenale");
        $this->loadModel("TransmisionPartido");
        $this->loadModel("TransmisionesMovile");
        $this->loadModel("TipoTransmisione");
        $this->loadModel("Regione");
        
        setlocale(LC_TIME, 'es_ES.UTF-8');
        
        $senales_controller = new TransmisionSenalesController;
        $canales_controller = new TransmisionCanalesController;
        
        $senales = json_decode($senales_controller->senales_list());
        $medios = $senales_controller->medios_transmision_list();
        $canales = json_decode($canales_controller->canales_list());
        
        $regiones = $this->Regione->find('list', array(
        'fields' => array(
        'Regione.id',
        'Regione.region_ordinal')
        ));
        $produccion = $this->ProduccionPartidosEvento->find('first', array("conditions" => array('ProduccionPartidosEvento.id' => $id),
        'recursive' => 2,
        'fields' => array(
        'initcap(Campeonato.nombre_prefijo) as Campeonato__nombre_prefijo',
        'Equipo.nombre',
        'EquipoVisita.nombre',
        'Estadio.id',
        'Estadio.regione_id',
        'Estadio.nombre',
        'Estadio.ciudad',
        'Categoria.nombre',
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
        'Subcategoria.nombre')
        ));
        
        $produccion["ProduccionPartidosTransmisione"]["nombre_proveedor"] = $this->proveedorCompanies[$produccion["ProduccionPartidosTransmisione"]["proveedor_company_id"]];
        
        $transmision = $this->TransmisionPartido->find('first', array("conditions" => array('TransmisionPartido.produccion_partidos_evento_id' => $id,
        'TransmisionPartido.estado !='=>0),
        'recursive' => 1,
        'fields' => array(
        'TransmisionPartido.id',
        'TransmisionPartido.transmision_senales_principal_senale_id',
        'TransmisionPartido.transmision_senales_respaldo_senale_id',
        'TransmisionPartido.transmision_senales_respaldo_otro_senale_id',
        'TransmisionPartido.radio',
        'TransmisionPartido.principal_meta',
        'TransmisionPartido.respaldo_meta',
        'TransmisionPartido.radio_meta',
        'TransmisionPartido.respaldo_otro_meta'
        )
        ));
        
        $existePrevia = $this->ProduccionPartidosEvento->find('all', array(
        "conditions" => array(
        'ProduccionPartidosEvento.id !='=>$id,
        'ProduccionPartidosEvento.estado_produccion'=>1,
        'ProduccionPartidosEvento.fixture_partido_id'=>$produccion['ProduccionPartidosEvento']['fixture_partido_id'],
        'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d")
        ),
        "fields"=> array(
        'ProduccionPartidosTransmisione.tipo_transmisione_id',
        'ProduccionPartidosTransmisione.hora_transmision',
        'ProduccionPartidosTransmisione.hora_transmision_gmt'),
        'recursive'=>0
        ));
        
        foreach ($existePrevia as $key => $value) {
            if($value['ProduccionPartidosTransmisione']['tipo_transmisione_id'] == 3){
                $produccion['ProduccionPartidosTransmisione']['hora_transmision'] = $value['ProduccionPartidosTransmisione']['hora_transmision'];
                $produccion['ProduccionPartidosTransmisione']['hora_transmision_gmt'] = $value['ProduccionPartidosTransmisione']['hora_transmision_gmt'];
            }
        }
        $fechastr = ucfirst( mb_strtolower( strftime("%A %d de %B de %Y", strtotime($produccion["ProduccionPartidosEvento"]["fecha_partido"])) , 'UTF-8') );
        $produccionArray = array(
        'id' => $produccion['ProduccionPartidosEvento']['id'],
        'equipos' => $produccion['Equipo']['nombre']." vs ".$produccion['EquipoVisita']['nombre'],
        'estadio' => isset($produccion['Estadio']['nombre']) ? $produccion['Estadio']['nombre'] : "",
        'estadio_ciudad' => isset($produccion['Estadio']['ciudad']) ? $produccion['Estadio']['ciudad'] : "",
        'estadio_region' => isset($regiones[$produccion['Estadio']['regione_id']]) ? $regiones[$produccion['Estadio']['regione_id']] : "",
        'campeonato' => isset($produccion['Campeonato']['nombre']) ? $produccion['Campeonato']['nombre'] : "",
        'categoria' => isset($produccion['Categoria']['nombre']) ? $produccion['Categoria']['nombre'] : "",
        'subcategoria' => isset($produccion['Subcategoria']['nombre']) ? $produccion['Subcategoria']['nombre'] : "",
        'fecha_partido' => isset($produccion['ProduccionPartidosEvento']['fecha_partido']) ? $produccion['ProduccionPartidosEvento']['fecha_partido'] : "",
        'fecha_partido_str' => isset($fechastr) ? $fechastr : "",
        'nPartido' => isset($produccion['ProduccionPartidosTransmisione']['NumeroPartido']['nombre']) ? $produccion['ProduccionPartidosTransmisione']['NumeroPartido']['nombre'] : "",
        'inicio_transmision' => isset($produccion['ProduccionPartidosTransmisione']['hora_transmision']) ? $produccion['ProduccionPartidosTransmisione']['hora_transmision'] : "",
        'inicio_transmision_gmt' => isset($produccion['ProduccionPartidosTransmisione']['hora_transmision_gmt']) ? $produccion['ProduccionPartidosTransmisione']['hora_transmision_gmt'] : "",
        'inicio_partido' => isset($produccion['ProduccionPartidosEvento']['hora_partido']) ? $produccion['ProduccionPartidosEvento']['hora_partido'] : "",
        'inicio_partido_gmt' => isset($produccion['ProduccionPartidosEvento']['hora_partido_gmt']) ? $produccion['ProduccionPartidosEvento']['hora_partido_gmt'] : "",
        'fin_aprox_transmision' => isset($produccion['ProduccionPartidosTransmisione']['hora_termino_transmision']) ? $produccion['ProduccionPartidosTransmisione']['hora_termino_transmision'] : "",
        'fin_aprox_transmision_gmt' => isset($produccion['ProduccionPartidosTransmisione']['hora_termino_transmision_gmt']) ? $produccion['ProduccionPartidosTransmisione']['hora_termino_transmision_gmt'] : "",
        'produccion_tecnica' => isset($produccion['ProduccionPartidosTransmisione']['nombre_proveedor']) ? $produccion['ProduccionPartidosTransmisione']['nombre_proveedor'] : "",
        'movile' => isset($produccion["ProduccionPartidosTransmisione"]["TransmisionesMovile"]['nombre']) ? $produccion["ProduccionPartidosTransmisione"]["TransmisionesMovile"]['nombre'] : "",
        'senal' => isset($produccion["ProduccionPartidosTransmisione"]["TransmisionesMovile"]['senal']) ? $produccion["ProduccionPartidosTransmisione"]["TransmisionesMovile"]['senal'] : "",
        'radio'=> isset($transmision['radio']) ? $transmision['radio'] : ""
        );
        
        $respuesta['senales'] = $senales;
        $respuesta['canales'] = $canales;
        $respuesta['medios'] = $medios;
        $respuesta['produccion'] = $produccionArray;
        $respuesta['transmision'] = $transmision;
        $this->set('respuesta', json_encode($respuesta));
    }
    
    public function add($id = null) {
        $this->acceso();
        $this->layout = "angular";
        $this->loadModel("TransmisionPartido");
        
        $existe = $this->TransmisionPartido->find('first', array(
        "conditions" => array(
        'TransmisionPartido.produccion_partidos_evento_id' => $id,
        'TransmisionPartido.estado !=' =>0),
        "fields"=> array("TransmisionPartido.id")
        ));
        if($existe){
            $this->Session->setFlash('La transmisión no se puede agregar ya que el registro ya existe, intente editar transmisión.','msg_exito');
            return $this->redirect(array('action' => 'index'));
        }
        $this->set("id", $id);
    }
    
    public function add_transmision_guardar(){
        $this->layout = "ajax";
        $this->loadModel("TransmisionPartido");
        if($this->request->is('post')){
            $this->request->data['user_id'] = $this->Session->Read("PerfilUsuario.idUsuario");
            if ($this->TransmisionPartido->save($this->request->data)) {
                CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->TransmisionPartido->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") );
                $respuesta = array(
                'estado'=>1,
                'mensaje'=>'La transmision partido fue agregada correctamente');
            }else{
                $respuesta = array(
                'estado'=>0,
                'mensaje'=>'Ocurrió un error al intentar agregar la transmision partido');
            }
        }else{
            $respuesta = array(
            'estado'=>0,
            'mensaje'=>'Ocurrió un error al intentar agregar la transmision partido.');
        }
        
        $this->set("respuesta", json_encode($respuesta));
    }
    
    public function add_transmision($id = null) {
        $this->layout = "ajax";
        $this->response->type('json');
        $this->loadModel("ProduccionPartidosEvento");
        $this->loadModel("TransmisionTipoEvento");
        $this->loadModel("TransmisionSenale");
        $this->loadModel("TransmisionPartido");
        $this->loadModel("Regione");
        $this->loadModel("ProduccionPartidosTransmisione");
        
        $senales_controller = new TransmisionSenalesController;
        $canales_controller = new TransmisionCanalesController;
        
        $senales = json_decode($senales_controller->senales_list());
        $medios = $senales_controller->medios_transmision_list();
        $canales = json_decode($canales_controller->canales_list());
        
        setlocale(LC_TIME, 'es_ES.UTF-8');
        
        $existe = $this->TransmisionPartido->find('first', array(
        "conditions" => array(
        'TransmisionPartido.produccion_partidos_evento_id' => $id,
        'TransmisionPartido.estado !=' =>0),
        "fields"=> array("TransmisionPartido.id")
        ));
        
        if($existe){
            $this->Session->setFlash('La transmisión no se puede agregar ya que el registro existe, intente editar transmisión.','msg_exito');
            return $this->redirect(array('action' => 'index'));
        }
        
        if($this->request->is('post')){
            $this->request->data["TransmisionPartido"]["user_id"] = $this->Session->read('PerfilUsuario.idUsuario');
            $existe = $this->TransmisionPartido->find('first', array(
            "conditions" => array(
            'TransmisionPartido.produccion_partidos_evento_id' => $id,
            'TransmisionPartido.estado !=' => 0),
            'fields' => array('TransmisionPartido.produccion_partidos_evento_id')
            ));
            
            if($existe){
                $this->Session->setFlash('La transmision partido no se pudo guardar, ya que el registro existe, intente editar.', "msg_fallo");
            }else{
                if ($this->TransmisionPartido->save($this->request->data)) {
                    CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - id ' . $this->TransmisionPartido->id . ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") );
                    $this->Session->setFlash('La transmision partido fue agregada.','msg_exito');
                    return $this->redirect(array('action' => 'index'));
                }else{
                    $this->Session->setFlash('La transmision partido no se pudo agregar, por favor vuelve a intentar.', "msg_fallo");
                    return $this->redirect(array('action' => 'index'));
                }
            }
        }
        
        $regiones = $this->Regione->find('list', array(
        'fields' => array(
        'Regione.id',
        'Regione.region_ordinal')
        ));
        
        $produccion = $this->ProduccionPartidosEvento->find('first', array("conditions" => array('ProduccionPartidosEvento.id' => $id),
        'recursive' => 2,
        'fields' => array('Campeonato.nombre',
        'Equipo.nombre',
        'EquipoVisita.nombre',
        'Estadio.nombre',
        'Estadio.ciudad',
        'Estadio.id',
        'Estadio.regione_id',
        'Categoria.nombre',
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
        'ProduccionPartidosTransmisione.tipo_transmisione_id',
        'ProduccionPartidosTransmisione.numero_partido_id',
        'Subcategoria.nombre')
        ));
        
        $produccion["ProduccionPartidosTransmisione"]["nombre_proveedor"] = $this->proveedorCompanies[$produccion["ProduccionPartidosTransmisione"]["proveedor_company_id"]];
        
        $existePrevia = $this->ProduccionPartidosEvento->find('all', array(
        "conditions" => array(
        'ProduccionPartidosEvento.id !='=>$id,
        'ProduccionPartidosEvento.estado_produccion'=>1,
        'ProduccionPartidosEvento.fixture_partido_id'=>$produccion['ProduccionPartidosEvento']['fixture_partido_id'],
        'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d")
        ),
        "fields"=> array(
        'ProduccionPartidosTransmisione.tipo_transmisione_id',
        'ProduccionPartidosTransmisione.hora_transmision',
        'ProduccionPartidosTransmisione.hora_transmision_gmt'),
        'recursive'=>0
        ));
        
        foreach ($existePrevia as $key => $value) {
            if($value['ProduccionPartidosTransmisione']['tipo_transmisione_id'] == 3){
                $produccion['ProduccionPartidosTransmisione']['hora_transmision'] = $value['ProduccionPartidosTransmisione']['hora_transmision'];
                $produccion['ProduccionPartidosTransmisione']['hora_transmision_gmt'] = $value['ProduccionPartidosTransmisione']['hora_transmision_gmt'];
            }
        }
        $fechastr = ucfirst( mb_strtolower( strftime("%A %d de %B de %Y", strtotime($produccion["ProduccionPartidosEvento"]["fecha_partido"])) , 'UTF-8') );
        $produccionArray = array(
        'id' => $produccion['ProduccionPartidosEvento']['id'],
        'equipos' => $produccion['Equipo']['nombre']." vs ".$produccion['EquipoVisita']['nombre'],
        'estadio' => $produccion['Estadio']['nombre'],
        'estadio_ciudad' => $produccion['Estadio']['ciudad'],
        'estadio_region' => isset($regiones[$produccion['Estadio']['regione_id']]) ? $regiones[$produccion['Estadio']['regione_id']] : "",
        'campeonato' => isset($produccion['Campeonato']['nombre']) ? $produccion['Campeonato']['nombre'] : "",
        'categoria' => isset($produccion['Categoria']['nombre']) ? $produccion['Categoria']['nombre'] : "",
        'subcategoria' => isset($produccion['Subcategoria']['nombre']) ? $produccion['Subcategoria']['nombre'] : "",
        'fecha_partido' => isset($produccion['ProduccionPartidosEvento']['fecha_partido']) ? $produccion['ProduccionPartidosEvento']['fecha_partido'] : "",
        'fecha_partido_str' => isset($fechastr) ? $fechastr : "",
        'nPartido' => isset($produccion['ProduccionPartidosTransmisione']['NumeroPartido']['nombre']) ? $produccion['ProduccionPartidosTransmisione']['NumeroPartido']['nombre'] : "",
        'inicio_transmision' => isset($produccion['ProduccionPartidosTransmisione']['hora_transmision']) ? $produccion['ProduccionPartidosTransmisione']['hora_transmision'] : "",
        'inicio_transmision_gmt' => isset($produccion['ProduccionPartidosTransmisione']['hora_transmision_gmt']) ? $produccion['ProduccionPartidosTransmisione']['hora_transmision_gmt'] : "",
        'inicio_partido' => isset($produccion['ProduccionPartidosEvento']['hora_partido']) ? $produccion['ProduccionPartidosEvento']['hora_partido'] : "",
        'inicio_partido_gmt' => isset($produccion['ProduccionPartidosEvento']['hora_partido_gmt']) ? $produccion['ProduccionPartidosEvento']['hora_partido_gmt'] : "",
        'fin_aprox_transmision' => isset($produccion['ProduccionPartidosTransmisione']['hora_termino_transmision']) ? $produccion['ProduccionPartidosTransmisione']['hora_termino_transmision'] : "",
        'fin_aprox_transmision_gmt' => isset($produccion['ProduccionPartidosTransmisione']['hora_termino_transmision_gmt']) ? $produccion['ProduccionPartidosTransmisione']['hora_termino_transmision_gmt'] : "",
        'produccion_tecnica' => isset($produccion['ProduccionPartidosTransmisione']['nombre_proveedor']) ? $produccion['ProduccionPartidosTransmisione']['nombre_proveedor'] : "",
        'movile' => isset($produccion["ProduccionPartidosTransmisione"]["TransmisionesMovile"]['nombre']) ? $produccion["ProduccionPartidosTransmisione"]["TransmisionesMovile"]['nombre'] : "",
        'senal' => isset($produccion["ProduccionPartidosTransmisione"]["TransmisionesMovile"]['senal']) ? $produccion["ProduccionPartidosTransmisione"]["TransmisionesMovile"]['senal'] : ""
        );
        $respuesta['senales'] = $senales;
        $respuesta['canales'] = $canales;
        $respuesta['medios'] = $medios;
        $respuesta['produccion'] = $produccionArray;
        $this->set('respuesta', json_encode($respuesta));
    }
    
    public function transmision_pdf($tipo = null){
        $this->layout = "ajax";
        if($tipo == "reporte"){
            $nombre_archivo_pdf = "transmision_reporte_pdf_".date("Y-m-d").".pdf";
        }else{
            $nombre_archivo_pdf = "transmision_pdf_".date("Y-m-d").".pdf";
        }
        
        $pathFile = WWW_ROOT . "files" . DS . "pdf" . DS . $nombre_archivo_pdf;
        App::import("Vendor", "tcpdf", array("file" => "tcpdf" . DS . "tcpdf.php"));
        
        $this->tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $this->tcpdf->SetAuthor('Servicios de Televisión Canal del Fútbol Limitada');
        $this->tcpdf->setPrintHeader(false);
        $this->tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $this->tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $this->tcpdf->SetMargins(20,10,10);
        $this->tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $this->tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $this->tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $this->tcpdf->SetFontSize(12);
        $this->tcpdf->AddPage('L', 'A4');
        $this->tcpdf->writeHTML($this->request->data["html"], true, false, false, false, '');
        $output = $this->tcpdf->Output($pathFile, "F");
        $this->set('respuesta',"files" . DS . "pdf" . DS . $nombre_archivo_pdf);
    }
    
    public function excel(){
        $this->autoRender = false;
        //$this->response->type('json');
        $this->loadModel('ProduccionPartidosEvento');
        $this->loadModel('ProduccionPartidosTransmisione');
        $this->loadModel('TransmisionesMovile');
        $this->loadModel('NumeroPartido');
        $this->loadModel('TransmisionSenale');
        $this->loadModel('Regione');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        
        $objPHPExcel = new PHPExcel();
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        
        $objPHPExcel->setActiveSheetIndex(0);
        $objActSheet = $objPHPExcel->getActiveSheet();
        $objPHPExcel->getProperties()->setCreator("SGI - CDF")
        ->setTitle("Documento Transmision Partidos CDF".date("Y-m-d"))
        ->setSubject("Documento Transmision Partidos CDF")
        ->setDescription("Documento Transmision Partidos CDF")
        ->setKeywords("Documento Transmision Partidos CDF")
        ->setCategory("Documento Transmision Partidos CDF");
        
        $numeroPartidos = $this->NumeroPartido->find('list', array(
        'fields'=>array(
        'NumeroPartido.id',
        'NumeroPartido.nombre'
        )
        ));
        
        $transmisionSenales = $this->TransmisionSenale->find('list', array(
        'fields'=>array(
        'TransmisionSenale.id',
        'TransmisionSenale.nombre'),
        'conditions'=>array(
        'TransmisionSenale.estado'=>1)
        ));
        
        $transmisionMovile = $this->ProduccionPartidosTransmisione->find('all', array(
        'fields'=>array(
        'TransmisionesMovile.id',
        'TransmisionesMovile.nombre',
        'TransmisionesMovile.senal')
        ));
        
        $regiones = $this->Regione->find('list', array(
        'fields'=>array(
        'Regione.id',
        'Regione.region_ordinal')
        ));
        
        $transmisionPartidos = $this->ProduccionPartidosEvento->find('all', array(
        'fields'=>array(
        'initcap(Campeonato.nombre) as Campeonato__nombre',
        'initcap(Campeonato.nombre_prefijo) as Campeonato__nombre_prefijo',
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
        'Subcategoria.nombre'),
        'order'=>array('ProduccionPartidosEvento.fecha_partido'=>'asc'),
        //"joins"=>array( array("table" => "transmision_partidos", "alias" => "TransmisionPartido", "type" => "LEFT", "conditions" => array("TransmisionPartido.produccion_partidos_evento_id = ProduccionPartidosEvento.id" ))),
        'conditions'=>array(
        'ProduccionPartidosTransmisione.tipo_transmisione_id'=>1,
        'ProduccionPartidosEvento.estado_produccion'=>1,
        'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d")),
        'recursive' => 0
        ));
        
        $campeonatos = array();
        foreach ($transmisionPartidos as $key => $partido) {
            $id=$partido["ProduccionPartidosEvento"]['id'];
            $existePrevia = $this->ProduccionPartidosEvento->find('all', array(
            "conditions" => array(
            'ProduccionPartidosEvento.id !='=>$id,
            'ProduccionPartidosEvento.estado_produccion'=>1,
            'ProduccionPartidosEvento.fixture_partido_id'=>$partido["ProduccionPartidosEvento"]['fixture_partido_id'],
            'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d"),
            'ProduccionPartidosTransmisione.tipo_transmisione_id'=>3
            ),
            "fields"=> array(
            'ProduccionPartidosTransmisione.tipo_transmisione_id',
            'ProduccionPartidosTransmisione.hora_transmision',
            'ProduccionPartidosTransmisione.hora_transmision_gmt'),
            'recursive'=>1
            ));
            
            $partidosGroup[$id]['campeonato'] = $partido['campeonato'];
            
            if(!isset($campeonatos[$partido["ProduccionPartidosEvento"]["campeonato_id"]])){
                $campeonatos[$partido["ProduccionPartidosEvento"]["campeonato_id"]] = $partido['campeonato']['nombre'];
            }
            
            $fechastr = ucfirst( mb_strtolower( strftime("%A %d de %B de %Y", strtotime($partido["ProduccionPartidosEvento"]["fecha_partido"])) , 'UTF-8') );
            
            //$partidosGroup[$id]['Transmision'] = $partido['TransmisionPartido'];
            //$partidosGroup[$id]['Transmision']['senal_principal_nombre'] = $transmisionSenales[$partido['TransmisionPartido']['transmision_senales_principal_senale_id']];
            //$partidosGroup[$id]['Transmision']['senal_respaldo_nombre'] = $transmisionSenales[$partido['TransmisionPartido']['transmision_senales_respaldo_senale_id']];
            
            /*if(isset($partido['TransmisionPartido']['radio'])){
            $partidosGroup[$id]['Transmision']['senal_radio_nombre'] = $transmisionSenales[$partido['TransmisionPartido']['radio']];
            }else{
            $partidosGroup[$id]['Transmision']['senal_radio_nombre'] = "";
            }*/
            
            $partidosGroup[$id]['ProduccionPartidosEvento'] = $partido['ProduccionPartidosEvento'];
            $partidosGroup[$id]['ProduccionPartidosEvento']['fecha_string'] = $fechastr;
            $partidosGroup[$id]['Equipo'] = $partido['equipo'];
            $partidosGroup[$id]['EquipoVisita'] = $partido['equipovisita'];
            $partidosGroup[$id]['Categoria'] = $partido['categoria'];
            $partidosGroup[$id]['Estadio'] = $partido['Estadio'];
            $partidosGroup[$id]['estadio'] = $partido['estadio'];
            $partidosGroup[$id]['Estadio']['region_ordinal'] = $regiones[$partido['Estadio']['regione_id']];
            $partidosGroup[$id]['ProduccionPartidosTransmisione'] = $partido['ProduccionPartidosTransmisione'];
            
            if(isset($existePrevia[0]['ProduccionPartidosTransmisione']['tipo_transmisione_id']) && $existePrevia[0]['ProduccionPartidosTransmisione']['tipo_transmisione_id'] == 3){
                $partidosGroup[$id]['ProduccionPartidosTransmisione']['hora_transmision'] = $existePrevia[0]['ProduccionPartidosTransmisione']['hora_transmision'];
                $partidosGroup[$id]['ProduccionPartidosTransmisione']['hora_transmision_gmt'] = $existePrevia[0]['ProduccionPartidosTransmisione']['hora_transmision_gmt'];
            }
            
            $partidosGroup[$id]['ProduccionPartidosTransmisione']['nombre_partido'] = $numeroPartidos[$partido['ProduccionPartidosTransmisione']['numero_partido_id']];
            $partidosGroup[$id]['NombreProveedor'] = $this->proveedorCompanies[$partido["ProduccionPartidosTransmisione"]["proveedor_company_id"]];
            $partidosGroup[$id]['TransmisionMovile'] = $transmisionMovile[$partido['ProduccionPartidosTransmisione']['transmisiones_movile_id']]['TransmisionesMovile'];
        }
        
        $campeonatos = implode($campeonatos, " y ");
        
        $objActSheet->setCellValue('A1', '');
        $objActSheet->setCellValue('B1', 'CAMPEONATO '.$campeonatos);
        $objActSheet->setCellValue('C1', '');
        $objActSheet->setCellValue('D1', '');
        $objActSheet->setCellValue('E1', '');
        $objActSheet->setCellValue('F1', '');
        $objActSheet->setCellValue('G1', '');
        $objActSheet->setCellValue('H1', 'PROGRAMACION DE TRANSMISIONES CLARO');
        $objActSheet->setCellValue('I1', '');
        $objActSheet->setCellValue('J1', '');
        $objActSheet->setCellValue('K1', '');
        $objActSheet->setCellValue('L1', '');
        $objActSheet->mergeCells('B1:F1');
        $objActSheet->mergeCells('H1:J1');
        $titulos = [
        "id",
        "LOCAL",
        '',
        "VISITA",
        "ESTADIO",
        "Campeonato",
        "SEÑAL",
        "Horario de puesta en marcha",
        "OPERACION",
        "Medio Tx Id",
        "Medio Tx Nombre",
        "Contacto Estadio",
        "Recepcion de señal en CDF",
        "Anexo"
        ];
        
        $objActSheet->setCellValue('A2', $titulos[0]);
        $objActSheet->setCellValue('B2', $titulos[1]);
        $objActSheet->setCellValue('C2', $titulos[2]);
        $objActSheet->setCellValue('D2', $titulos[3]);
        $objActSheet->setCellValue('E2', $titulos[4]);
        $objActSheet->setCellValue('F2', $titulos[5]);
        $objActSheet->setCellValue('G2', $titulos[6]);
        $objActSheet->setCellValue('H2', $titulos[7]);
        $objActSheet->setCellValue('I2', $titulos[8]);
        $objActSheet->setCellValue('J2', $titulos[9]);
        $objActSheet->setCellValue('K2', $titulos[10]);
        $objActSheet->setCellValue('L2', $titulos[11]);
        $objActSheet->setCellValue('M2', $titulos[12]);
        $objActSheet->setCellValue('N2', $titulos[13]);
        $contador = 4; //a partir de la fila 4 comenzamos a dibujar los datos
        $color[0] = "F5F5DC";
        $color[1] = "DCDCDC";
        $actual = 0;
        
        $estiloBorde = array(
        'borders' => array(
        'outline' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
        )
        )
        );
        
        foreach($partidosGroup as $id => $partido){
            //cambio de transmision_id por produccion_partidos_evento_id
            //$objActSheet->setCellValue('A'.$contador,$partido['Transmision']['id']);
            /*
            $objPHPExcel->getActiveSheet()
            ->setCellValue(
            'E10',
            '=SUM(A10:E9)'
            );
            '=IF(C4>500,"profit","loss")'
            */
            
            $contadorInicio = $contador;
            $objActSheet->setCellValue('A'.$contador,$partido['ProduccionPartidosEvento']['id']);
            $objActSheet->setCellValue('B'.$contador,$partido['Equipo']['nombre']);
            $objActSheet->setCellValue('C'.$contador,'v/s');
            $objActSheet->setCellValue('D'.$contador,$partido['EquipoVisita']['nombre']);
            $objActSheet->setCellValue('E'.$contador,$partido['estadio']['nombre']);
            $objActSheet->setCellValue('F'.$contador,$partido['campeonato']['nombre_prefijo']);
            $objActSheet->setCellValue('G'.$contador,"Principal");
            $objActSheet->setCellValue('H'.$contador,'');
            $objActSheet->setCellValue('I'.$contador,'');
            $objActSheet->setCellValue('J'.$contador,'');
            $objActSheet->setCellValue('K'.$contador,'=IF(J'.$contador.'=1, "Fibra Óptica", IF(J'.$contador.'=2, "Micro Ondas", ""))');
            $objActSheet->setCellValue('L'.$contador,'');
            $objActSheet->setCellValue('M'.$contador,'');
            $objActSheet->setCellValue('N'.$contador,'');
            
            $objPHPExcel->getActiveSheet()
            ->getStyle('A'.$contador.':N'.$contador)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF'.$color[$actual]);
            $contador++;
            
            $objActSheet->setCellValue('A'.$contador,'');
            $objActSheet->setCellValue('B'.$contador,$partido['ProduccionPartidosEvento']['fecha_string']);
            $objActSheet->setCellValue('C'.$contador,'');
            $objActSheet->setCellValue('D'.$contador,'');
            $objActSheet->setCellValue('E'.$contador,'');
            $objActSheet->setCellValue('F'.$contador,'');
            $objActSheet->setCellValue('G'.$contador,"Respaldo");
            $objActSheet->setCellValue('H'.$contador,'');
            $objActSheet->setCellValue('I'.$contador,'');
            $objActSheet->setCellValue('J'.$contador,'');
            //$objActSheet->setCellValue('K'.$contador,'');
            $objActSheet->setCellValue('K'.$contador,'=IF(J'.$contador.'=1, "Fibra Óptica", IF(J'.$contador.'=2, "Micro Ondas", ""))');
            $objActSheet->setCellValue('L'.$contador,'');
            $objActSheet->setCellValue('M'.$contador,'');
            $objActSheet->setCellValue('N'.$contador,'');
            
            $objPHPExcel->getActiveSheet()
            ->getStyle('A'.$contador.':N'.$contador)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF'.$color[$actual]);
            $contador++;
            
            $objActSheet->setCellValue('A'.$contador,'');
            $objActSheet->setCellValue('B'.$contador,"Inicio Tx");
            $objActSheet->setCellValue('C'.$contador,substr($partido['ProduccionPartidosTransmisione']['hora_transmision'],0,5));
            $objActSheet->setCellValue('D'.$contador,'');
            $objActSheet->setCellValue('E'.$contador,'');
            $objActSheet->setCellValue('F'.$contador,'');
            
            //$tieneradio = $partido['Transmision']['senal_radio_nombre'] !== "" ? "RADIO" : '';
            //$senalradio = $partido['Transmision']['senal_radio_nombre'] !== "" ? $partido['Transmision']['senal_radio_nombre'] : '';
            
            $objActSheet->setCellValue('G'.$contador,"RADIO");
            $objActSheet->setCellValue('H'.$contador,'');
            $objActSheet->setCellValue('I'.$contador,'');
            $objActSheet->setCellValue('J'.$contador,'');
            //$objActSheet->setCellValue('K'.$contador,'');
            $objActSheet->setCellValue('K'.$contador,'=IF(J'.$contador.'=1, "Fibra Óptica", IF(J'.$contador.'=2, "Micro Ondas", ""))');
            $objActSheet->setCellValue('L'.$contador,'');
            $objActSheet->setCellValue('M'.$contador,'');
            $objActSheet->setCellValue('N'.$contador,'');
            
            $objPHPExcel->getActiveSheet()
            ->getStyle('A'.$contador.':N'.$contador)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF'.$color[$actual]);
            
            $contadorFinal = $contador;
            $objPHPExcel->getActiveSheet()->getStyle('A'.$contadorInicio.':N'.$contadorFinal)->applyFromArray($estiloBorde);
            $contador++;
            if($actual == 0){
                $actual = 1;
            }else{
                $actual = 0;
            }
        }
        $contador--;
        
        for ($i=4; $i<=$contador; $i++) {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('J'.$i)
            ->getDataValidation();
            $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_WHOLE );
            $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP );
            $objValidation->setAllowBlank(true);
            $objValidation->setShowInputMessage(false);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setErrorTitle('Error de escritura');
            $objValidation->setError('Valor no permitido');
            $objValidation->setPromptTitle('Valores permitidos');
            $objValidation->setPrompt('Solo se permiten valores 1 y 2');
            $objValidation->setFormula1(1);
            $objValidation->setFormula2(2);
        }
        
        $estiloBordeTodos = array(
        'borders' => array(
        'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
        )
        )
        );
        
        $objPHPExcel->getActiveSheet()->getStyle('H4:N'.$contador)->applyFromArray($estiloBordeTodos);
        $objPHPExcel->getActiveSheet()->getStyle('A4:A'.$contador)->applyFromArray($estiloBorde);
        
        $objPHPExcel->getActiveSheet()
        ->getComment('J2')
        ->getText()->createTextRun('Debe Ingresar valor 1 o 2 en caso de:   ');
        $objPHPExcel->getActiveSheet()
        ->getComment('J2')
        ->getText()->createTextRun("\r\n");
        $objPHPExcel->getActiveSheet()
        ->getComment('J2')
        ->getText()->createTextRun('1 = Fibra Óptica');
        $objPHPExcel->getActiveSheet()
        ->getComment('J2')
        ->getText()->createTextRun("\r\n");
        $objPHPExcel->getActiveSheet()
        ->getComment('J2')
        ->getText()->createTextRun('2 = Microondas');
        $objPHPExcel->getActiveSheet()
        ->getComment('J2')
        ->getText()->createTextRun("\r\n");
        
        $objPHPExcel->getActiveSheet()->getComment("J2")->setWidth("250px");
        $objPHPExcel->getActiveSheet()->getComment("J2")->setHeight("70px");
        
        //leyenda para llenar Medio Tx
        $objActSheet->setCellValue('J'.($contador+3),'1 = Fibra Óptica');
        $objActSheet->setCellValue('J'.($contador+4),'2 = Microondas');
        
        $objPHPExcel->getActiveSheet()
        ->getStyle('J'.($contador+3).':J'.($contador+4))
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('FF87CEFA');
        
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(26);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        
        $objPHPExcel->getActiveSheet()
        ->getStyle('A1:N1')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('FFDCDCDC');
        
        $objPHPExcel->getActiveSheet()
        ->getStyle('A2:N2')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('FFC0C0C0');
        
        $objStyleA5 = $objActSheet ->getStyle('A5');
        $objStyleA5 ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        //Configuración de tipos de letra
        $objFontA5 = $objStyleA5->getFont();
        $objFontA5->setName('Courier New');
        $objFontA5->setSize(8);
        $objFontA5->setBold(false);
        $objFontA5->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
        $objFontA5->getColor()->setARGB('FFFF0000');
        $objFontA5->getColor()->setARGB( PHPExcel_Style_Color::COLOR_WHITE);
        
        //Protección de celda
        $objPHPExcel->getActiveSheet()->getProtection()->setPassword('cdf');
        $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
        //$objPHPExcel->getActiveSheet()->protectCells('A1:G10', 'PHPExcel');
        $objPHPExcel->getActiveSheet()
        ->getStyle('H4:J'.$contador)
        ->getProtection()->setLocked(
        PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
        );
        $objPHPExcel->getActiveSheet()
        ->getStyle('L4:N'.$contador)
        ->getProtection()->setLocked(
        PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
        );
        
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
        $objPHPExcel->getActiveSheet()->setPrintGridlines(true);
        
        header('Content-Disposition: attachment;filename="transmision_partidos_'.date("Y_m_d").'.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Cache-Control: max-age=0');
        ob_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save('php://output');
        $archivo = WWW_ROOT.'files'.DS.'csv'.DS.'transmision_partidos_'.date("Y_m_d").'.xlsx';
        $url = 'files'.DS.'csv'.DS.'transmision_partidos_'.date("Y_m_d").'.xlsx';
        $destino = WWW_ROOT.'files'.DS.'csv';
        
        $respuesta["archivo"] = $archivo;
        $respuesta["url"] = $url;
        
        $objWriter->save($archivo);
        return(json_encode($respuesta));
        //$this->set('data', $respuesta);
        exit;
    }
    
    public function excel_carga() {
        $this->acceso();
        $this->layout = "angular";
    }
    
    public function transmision_leer_excel_json(){
        $this->autoRender = false;
        $objReader = new PHPExcel_Reader_Excel5();
        $objReader->setReadDataOnly(true);
        $archivo = WWW_ROOT . "files" . DS . "xls" . DS . 'lista.xlsx';
        $objPHPExcel = PHPExcel_IOFactory::load($archivo);
        $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
        
        $array_data = array();
        $fila_partido = 1;
        foreach($rowIterator as $row){
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            if($row->getRowIndex() < 4) continue;
            foreach ($cellIterator as $cell) {
                if('A' == $cell->getColumn()){
                    if( is_numeric($cell->getCalculatedValue()) ){
                        $idactual = $cell->getCalculatedValue();
                        $fila_partido = 1;
                    }else{
                        $fila_partido++;
                    }
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('B' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('C' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('D' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('E' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('F' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('G' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('H' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('I' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('J' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('K' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('L' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                } else if('M' == $cell->getColumn()){
                    $array_data[$idactual][$cell->getColumn().$fila_partido] = $cell->getCalculatedValue();
                }
            }
        }
        
        $array_limpio = [];
        $array_base = [];
        $array_principal = [];
        $array_respaldo = [];
        $array_radio = [];
        
        foreach ($array_data as $key => $partido) {
            $array_base["id"] = $partido["A1"];
            $array_base["local"] = $partido["B1"];
            $array_base["visita"] = $partido["D1"];
            $array_base["fecha_str"] = $partido["B2"];
            $array_base["inicio_transmision"] = $partido["C3"];
            $array_base["estadio"] = $partido["E1"];
            $array_base["campeonato"] = $partido["F1"];
            
            $array_principal["tipo_senal"] = "Principal";
            $array_respaldo["tipo_senal"] = "Respaldo";
            $array_radio["tipo_senal"] = "Radio";
            
            $array_principal["senal"] = $partido["J1"];
            $array_respaldo["senal"] = $partido["J2"];
            $array_radio["senal"] = $partido["J3"];
            
            $array_principal["puesta_marcha"] = $partido["H1"];
            $array_respaldo["puesta_marcha"] = $partido["H2"];
            $array_radio["puesta_marcha"] = $partido["H3"];
            
            $array_base["contacto_estadio"] = $partido["K1"]. " ".$partido["K2"]. " ". $partido["K3"];
            $array_principal["recepcion_senal"] = $partido["L1"];
            $array_respaldo["recepcion_senal"] = $partido["L2"];
            $array_radio["recepcion_senal"] = $partido["L3"];
            
            $array_base["anexo"] = $partido["M1"]." ".$partido["M2"]." ".$partido["M3"];
            
            array_push($array_limpio, array_merge($array_base, $array_principal));
            array_push($array_limpio, array_merge($array_base, $array_respaldo));
            if($partido["J3"] !== Null){
                array_push($array_limpio, array_merge($array_base, $array_radio));
            }
        }
        //pr($array_limpio);exit;
        return(json_encode($array_limpio));
        //exit;
    }
    
    public function subir_csv() {
        $this->autoRender = false;
        $this->layout = "ajax";
        $estado = array();
        if ($this->request->is('post')){
            if(!empty($this->request->params["form"]["file"])){
                if($this->request->params["form"]["file"]['error']==0 && $this->request->params["form"]["file"]['size'] > 0){
                    $destino = WWW_ROOT.'files'.DS.'csv';
                    
                    if (!file_exists($destino)){
                        mkdir($destino, 0777, true);
                        chmod($destino, 0777);
                    }
                    
                    if(is_uploaded_file($this->request->params["form"]["file"]['tmp_name'])){
                        if($this->request->params["form"]["file"]['size'] <= 2000000){
                            move_uploaded_file($this->params["form"]["file"]['tmp_name'], $destino . DS .$this->params["form"]["file"]['name']);
                            $estado["estado"] = 1;
                            $estado["data"] = $this->params["form"]["file"]['name'];
                            $estado["mensaje"] = "El archivo se ha subido correctamente";
                        }else{
                            $estado["estado"] = 3;
                            $estado["file"] = "";
                            $estado["mensaje"] = "";
                        }
                    }else{
                        $estado["estado"] = 2;
                        $estado["file"] = "";
                        $estado["mensaje"] = "";
                    }
                }else{
                    $estado["estado"] = 2;
                    $estado["file"] = "";
                    $estado["mensaje"] = 'error de archivo cod '.$this->request->params["form"]["file"]['error'];
                }
            }else{
                $estado["estado"] = 2;
                $estado["file"] = "";
                $estado["mensaje"] = 'error al intentar cargar el archivo';
            }
        }else{
            $estado["estado"] = 2;
            $estado["file"] = "";
            $estado["mensaje"] = 'error al intentar cargar el archivo, no se pudo leer';
        }
        return(json_encode($estado));
        //$this->set('data', $estado);
    }
    
    public function transmision_leer_csv_json($archivo){
        $this->autoRender = false;
        $this->loadModel("ProduccionPartidosEvento");
        $this->loadModel("ProduccionPartidosTransmisione");
        $error = false;
        
        $senales_controller = new TransmisionSenalesController;
        $senales = json_decode($senales_controller->senales_list());
        
        foreach ($senales as $key => $value) {
            $value = (array)$value;
            $senalesList[$value["id"]]["nombre"] = $value["nombre"];
            $senalesList[$value["id"]]["medio_tx"] = $value["medio_tx"];
            $senalesList[$value["id"]]["medio_id"] = $value["medio_id"];
        }
        
        $senales_claro[1]=4;
        $senales_claro[2]=1;
       // pr($senales_claro);exit;
        /*
        Señales de Claro
        id  	Señal 				Medio Tx
        1 		Claro Microondas 	Micro Ondas
        3 		Claro 				Fibra Optica
        */
        
        $transmisionPartidos = $this->ProduccionPartidosEvento->find('all', array(
        'fields'=>array(
        'ProduccionPartidosEvento.id'),
        'conditions'=>array(
        'ProduccionPartidosTransmisione.tipo_transmisione_id'=>1,
        'ProduccionPartidosEvento.estado_produccion'=>1,
        'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d")),
        'recursive' => 0
        ));
        foreach ($transmisionPartidos as $key => $value) {
            $array_partidos_vigentes[] = $value["ProduccionPartidosEvento"]["id"];
        }
        
        $archivo = WWW_ROOT . "files" . DS . "csv" . DS . $archivo;
        $arreglo = array();
        $arreglo_limpio = array();
        $file = fopen($archivo,"r");
        
        while(! feof($file)){
            $arreglo[] = fgetcsv($file);
        }
        fclose($file);
        
        foreach ($arreglo as $key => $value) {
            $arreglo_limpio[] = utf8_encode($value[0]);
        }
        
        $array_data = array();
        $fila_partido = 1;
        $contador = 0;
        foreach($arreglo_limpio as $row){
            $array_data[$contador] = explode(";", $row);
            $contador++;
        }
        
        $array_limpio = [];
        $array_base = [];
        $array_principal = [];
        $array_respaldo = [];
        $array_radio = [];
        $array_final = [];
        
        $fila_partido = 1;
        $idactual = 0;
        foreach ($array_data as $key => $partido) {
            if($key < 3) continue;
            if(is_numeric($partido[0])){
                $fila_partido=1;
                $idactual = $partido[0];
                $array_final[$idactual][$fila_partido] = $partido;
            }else{
                $fila_partido++;
                $array_final[$idactual][$fila_partido] = $partido;
            }
        }
        foreach ($array_final as $key => $partido) {
            if (in_array($partido[1][0], $array_partidos_vigentes)) {
                $array_base["id"] = $partido[1][0];
                $array_base["local"] = $partido[1][1];
                $array_base["visita"] = $partido[1][3];
                $array_base["fecha_str"] = $partido[2][1];
                $array_base["inicio_transmision"] = isset($partido[3][2]) ? $partido[3][2] : "";
                $array_base["estadio"] = isset($partido[1][4]) ? $partido[1][4] : "";
                $array_base["campeonato"] = isset($partido[1][5]) ? $partido[1][5] : "";
                
                $array_principal["tipo_senal"] = "Principal";
                $array_respaldo["tipo_senal"] = "Respaldo";
                $array_radio["tipo_senal"] = "Radio";
                $valor = strpos($partido[1][9], '-');
                
                if(filter_var($partido[1][9], FILTER_VALIDATE_INT)) {
                    $array_principal["senal_id"] = $senales_claro[$partido[1][9]];
                    $array_principal["senal"] = $senalesList[$array_principal["senal_id"]]["medio_tx"];
                    //pr($array_principal["senal"] );exit;
                }else{
                    $array_principal["senal_id"] = "";
                    $array_principal["senal"] = "";
                }
                
                if(filter_var($partido[2][9], FILTER_VALIDATE_INT)) {
                    $array_respaldo["senal_id"] = $senales_claro[$partido[1][9]];
                    $array_respaldo["senal"] = $senalesList[$array_respaldo["senal_id"]]["medio_tx"];
                }else{
                    $array_respaldo["senal_id"] = "";
                    $array_respaldo["senal"] = "";
                }
                
                if(filter_var($partido[3][9], FILTER_VALIDATE_INT)) {
                    $array_radio["senal_id"] = $senales_claro[$partido[3][9]];
                    $array_radio["senal"] = $senalesList[$array_radio["senal_id"]]["medio_tx"];
                }else{
                    $array_radio["senal_id"] = "";
                    $array_radio["senal"] = "";
                }
                
                $array_principal["puesta_marcha"] = $partido[1][7];
                $array_respaldo["puesta_marcha"] = $partido[2][7];
                $array_radio["puesta_marcha"] = $partido[3][7];
                
                $array_base["contacto_estadio"] = $partido[1][11];
                
                if($partido[2][11] != ""){
                    if($partido[1][11] !== $partido[2][11]){
                        $array_base["contacto_estadio"] .= ", ".$partido[2][11];
                    }
                }
                if($partido[3][11] != ""){
                    if($partido[2][11] !== $partido[3][11] && $partido[3][11] !== $partido[1][11]){
                        $array_base["contacto_estadio"] .= ", ".$partido[3][11];
                    }
                }
                if(!isset($array_base["contacto_estadio"])){
                    $array_base["contacto_estadio"] = "";
                }
                
                $array_principal["recepcion_senal"] = isset($partido[1][12]) ? $partido[1][12] : "";
                $array_respaldo["recepcion_senal"] = isset($partido[2][12]) ? $partido[2][12] : "";
                $array_radio["recepcion_senal"] = isset($partido[3][12]) ? $partido[3][12] : "";
                
                $array_base["anexo"] = "";
                if($partido[1][13] !== ""){
                    $array_base["anexo"] = $partido[1][13];
                }
                if($partido[2][13] !== ""){
                    if($partido[1][13] !== $partido[2][13]){
                        $array_base["anexo"] .= "-".$partido[2][13];
                    }
                }
                if($partido[3][13] !== ""){
                    $array_base["anexo"] = $partido[3][13];
                }
                
                if(filter_var($array_principal["senal_id"], FILTER_VALIDATE_INT)) {
                    array_push($array_limpio, array_merge($array_base, $array_principal));
                }
                if(filter_var($array_respaldo["senal_id"], FILTER_VALIDATE_INT)) {
                    array_push($array_limpio, array_merge($array_base, $array_respaldo));
                }
                if(filter_var($array_radio["senal_id"], FILTER_VALIDATE_INT)) {
                    array_push($array_limpio, array_merge($array_base, $array_radio));
                }
            }
        }
        //pr($array_limpio);exit;
        if(!$error){
            return(json_encode($array_limpio));
        }else{
            $array_vacio = array();
            return(json_encode($array_vacio));
        }
        
    }
    
    public function consolidar_csv(){
        $this->autoRender = false;
        $this->loadModel("ProduccionPartidosEvento");
        $this->loadModel("ProduccionPartidosTransmisione");
        
        $partidos = $this->request->data;
        $idactual = 0;
        $partidos_ids = array();
        $partidos_error = array();
        
        $partidos_vigentes = $this->ProduccionPartidosEvento->find('all', array(
        'fields'=>array(
        'ProduccionPartidosEvento.id'),
        'conditions'=>array(
        'ProduccionPartidosTransmisione.tipo_transmisione_id'=>1,
        'ProduccionPartidosEvento.estado_produccion'=>1,
        'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d")),
        'recursive' => 0
        ));
        foreach ($partidos_vigentes as $key => $value) {
            $array_partidos_vigentes[] = $value["ProduccionPartidosEvento"]["id"];
        }
        
        $transmisionPartidos = $this->ProduccionPartidosEvento->find('all', array(
        'fields'=>array(
        'ProduccionPartidosEvento.id',
        'TransmisionPartido.id',
        'TransmisionPartido.produccion_partidos_evento_id'),
        "joins"=>array( array("table" => "transmision_partidos", "alias" => "TransmisionPartido", "type" => "LEFT", "conditions" => array("TransmisionPartido.produccion_partidos_evento_id = ProduccionPartidosEvento.id" ))),
        'conditions'=>array(
        'TransmisionPartido.estado'=>1,
        'ProduccionPartidosTransmisione.tipo_transmisione_id'=>1,
        'ProduccionPartidosEvento.estado_produccion'=>1,
        'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d")),
        'recursive' => 0
        ));
        
        foreach ($partidos as $key => $partido) {
            if($idactual !== $partido['id']){
                if(in_array($partido['id'], $array_partidos_vigentes)){
                    $idactual = $partido['id'];
                    array_unshift($partidos_ids, $partido['id']);
                    $respuesta[$idactual]["TransmisionPartido"]["produccion_partidos_evento_id"]= $idactual;
                    $respuesta[$idactual]["TransmisionPartido"]['user_id'] = $this->Session->read('PerfilUsuario.idUsuario');
                    
                    foreach ($transmisionPartidos as $key => $value){
                        if($partido["id"] == $value["ProduccionPartidosEvento"]["id"]){
                            $respuesta[$idactual]["TransmisionPartido"]['id'] = $value["TransmisionPartido"]["id"];
                        }
                    }
                }else{
                    array_unshift($partidos_error, $partido['id']);
                }
            }
            if(strtolower($partido["tipo_senal"]) == "principal"){
                $array_data[$idactual]["Principal"]["puesta_marcha"] = $partido["puesta_marcha"];
                $array_data[$idactual]["Principal"]["contacto"] = $partido["contacto_estadio"];
                $array_data[$idactual]["Principal"]["recepcion"] = $partido["recepcion_senal"];
                $array_data[$idactual]["Principal"]["anexo"] = $partido["anexo"];
                $respuesta[$idactual]["TransmisionPartido"]["principal_meta"] = json_encode($array_data[$idactual]["Principal"], JSON_UNESCAPED_UNICODE);
                if($partido["senal_id"] != ""){
                    $respuesta[$idactual]["TransmisionPartido"]["transmision_senales_principal_senale_id"]= $partido["senal_id"];
                }
                
            }else if(strtolower($partido["tipo_senal"]) == "respaldo"){
                $array_data[$idactual]["Respaldo2"]["puesta_marcha"] = $partido["puesta_marcha"];
                $array_data[$idactual]["Respaldo2"]["contacto"] = $partido["contacto_estadio"];
                $array_data[$idactual]["Respaldo2"]["recepcion"] = $partido["recepcion_senal"];
                $array_data[$idactual]["Respaldo2"]["anexo"] = $partido["anexo"];
                $respuesta[$idactual]["TransmisionPartido"]["respaldo2_meta"] = json_encode($array_data[$idactual]["Respaldo2"], JSON_UNESCAPED_UNICODE);
                if($partido["senal_id"] != ""){
                    $respuesta[$idactual]["TransmisionPartido"]["transmision_senales_respaldo2_senale_id"]= $partido["senal_id"];
                }
                
            }else if(strtolower($partido["tipo_senal"]) == "radio"){
                $array_data[$idactual]["Radio"]["puesta_marcha"] = $partido["puesta_marcha"];
                $array_data[$idactual]["Radio"]["contacto"] = $partido["contacto_estadio"];
                $array_data[$idactual]["Radio"]["recepcion"] = $partido["recepcion_senal"];
                $array_data[$idactual]["Radio"]["anexo"] = $partido["anexo"];
                $respuesta[$idactual]["TransmisionPartido"]["radio_meta"] = json_encode($array_data[$idactual]["Radio"], JSON_UNESCAPED_UNICODE);
                if($partido["senal_id"] != ""){
                    $respuesta[$idactual]["TransmisionPartido"]["radio"]= $partido["senal_id"];
                }
            }
            unset($array_data);
        }
        
        $str_ids =  implode("-",$partidos_ids);
        if(count($partidos_error) > 0){
            $str_ids_error =  implode("-",$partidos_error);
            $respuesta_mensaje = array(
            'estado'=>1,
            'mensaje'=>'La información de los partidos '.$str_ids.' parece correcta, Sin embargo, los siguientes partidos no se encuentran vigentes para registrar la transmisión: '.$str_ids_error);
        }else{
            if ($this->TransmisionPartido->saveAll($respuesta)){
                CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - ids ' . $str_ids . ' - el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario") );
                $respuesta_mensaje = array(
                'estado'=>1,
                'mensaje'=>'Se guardó la información de los partidos '.$str_ids);
            }else{
                $respuesta_mensaje = array(
                'estado'=>2,
                'mensaje'=>'Las transmisiones no han podido ser registradas en la base de datos');
            }
        }
        return json_encode($respuesta_mensaje, JSON_UNESCAPED_UNICODE);
    }
    
    public function reporte_datos(){
        $this->autoRender = false;
        $this->loadModel('ProduccionPartidosEvento');
        $this->loadModel('ProduccionPartidosTransmisione');
        $this->loadModel('TransmisionesMovile');
        $this->loadModel('NumeroPartido');
        $this->loadModel('TransmisionSenale');
        $this->loadModel('Regione');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        
        $senales_controller = new TransmisionSenalesController;
        $senales = json_decode($senales_controller->senales_list());
        $medios = $senales_controller->medios_transmision_list();
        
        $numeroPartidos = $this->NumeroPartido->find('list', array(
        'fields'=>array(
        'NumeroPartido.id',
        'NumeroPartido.nombre'
        )
        ));
        $senalesList = array();
        
        foreach ($senales as $key => $value) {
            $value = (array)$value;
            $senalesList[$value["id"]]["nombre"] = $value["nombre"];
            $senalesList[$value["id"]]["medio_tx"] = $value["medio_tx"];
            $senalesList[$value["id"]]["medio_id"] = $value["medio_id"];
        }
        
        $transmisionMovile = $this->ProduccionPartidosTransmisione->find('all', array(
        'fields'=>array(
        'TransmisionesMovile.id',
        'TransmisionesMovile.nombre',
        'TransmisionesMovile.senal')
        ));
        
        $regiones = $this->Regione->find('list', array(
        'fields'=>array(
        'Regione.id',
        'Regione.region_ordinal')
        ));
        
        $transmisionPartidos = $this->ProduccionPartidosEvento->find('all', array(
        'fields'=>array(
        'initcap(Campeonato.nombre) as Campeonato__nombre',
        'initcap(Campeonato.nombre_prefijo) as Campeonato__nombre_prefijo',
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
        'TransmisionPartido.id',
        'TransmisionPartido.estado',
        'TransmisionPartido.produccion_partidos_evento_id',
        'TransmisionPartido.transmision_senales_principal_senale_id',
        'TransmisionPartido.transmision_senales_respaldo_senale_id',
        'TransmisionPartido.radio',
        'TransmisionPartido.transmision_senales_respaldo2_senale_id',
        'TransmisionPartido.principal_meta',
        'TransmisionPartido.respaldo_meta',
        'TransmisionPartido.radio_meta',
        'TransmisionPartido.respaldo2_meta',
        'Subcategoria.nombre'),
        'order'=>array('Campeonato.nombre'=>'desc'),
        "joins"=>array( array("table" => "transmision_partidos", "alias" => "TransmisionPartido", "type" => "LEFT", "conditions" => array("TransmisionPartido.produccion_partidos_evento_id = ProduccionPartidosEvento.id" ))),
        'conditions'=>array(
        'TransmisionPartido.id !='=> null,
        'TransmisionPartido.estado'=> 1,
        'ProduccionPartidosTransmisione.tipo_transmisione_id'=>1,
        'ProduccionPartidosEvento.estado_produccion'=>1,
        'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d")),
        'recursive' => 0
        ));
        
        $campeonatos = array();
        $campeonatos["nombres"] = "";
        
        foreach ($transmisionPartidos as $key => $partido) {
            $id=$partido["ProduccionPartidosEvento"]['id'];
            $existePrevia = $this->ProduccionPartidosEvento->find('all', array(
            "conditions" => array(
            'ProduccionPartidosEvento.id !='=>$id,
            'ProduccionPartidosEvento.estado_produccion'=>1,
            'ProduccionPartidosEvento.fixture_partido_id'=>$partido["ProduccionPartidosEvento"]['fixture_partido_id'],
            'ProduccionPartidosEvento.fecha_partido >=' => date("Y-m-d"),
            'ProduccionPartidosTransmisione.tipo_transmisione_id'=>3
            ),
            "fields"=> array(
            'ProduccionPartidosTransmisione.tipo_transmisione_id',
            'ProduccionPartidosTransmisione.hora_transmision',
            'ProduccionPartidosTransmisione.hora_transmision_gmt'),
            'recursive'=>1
            ));
            
            $partidosGroup[$id]['campeonato'] = $partido['campeonato'];
            
            if(!isset($campeonatos[$partido["ProduccionPartidosEvento"]["campeonato_id"]])){
                $campeonatos[$partido["ProduccionPartidosEvento"]["campeonato_id"]] = $partido['campeonato']['nombre'];
                if($campeonatos["nombres"] == ""){
                    $campeonatos["nombres"] .= $partido['campeonato']['nombre'];
                }else{
                    $campeonatos["nombres"] .= " y ".$partido['campeonato']['nombre'];
                }
            }
            
            $fechastr = ucfirst( mb_strtolower( strftime("%A %d de %B", strtotime($partido["ProduccionPartidosEvento"]["fecha_partido"])) , 'UTF-8') );
            
            $partidosGroup[$id]['Transmision'] = $partido['TransmisionPartido'];
            
            if(isset($partido['TransmisionPartido']['transmision_senales_principal_senale_id'])){
                $partidosGroup[$id]['Transmision']['senal_principal_nombre'] = $senalesList[$partido['TransmisionPartido']['transmision_senales_principal_senale_id']]["nombre"];
                $partidosGroup[$id]['Transmision']['medio_principal_nombre'] = $senalesList[$partido['TransmisionPartido']['transmision_senales_principal_senale_id']]["medio_tx"];
            }
            
            if(isset($partido['TransmisionPartido']['transmision_senales_respaldo_senale_id'])){
                $partidosGroup[$id]['Transmision']['senal_respaldo_nombre'] = $senalesList[$partido['TransmisionPartido']['transmision_senales_respaldo_senale_id']]["nombre"];
                $partidosGroup[$id]['Transmision']['medio_respaldo_nombre'] = $senalesList[$partido['TransmisionPartido']['transmision_senales_respaldo_senale_id']]["medio_tx"];
            }
            
            if(isset($partido['TransmisionPartido']['transmision_senales_respaldo2_senale_id'])){
                $partidosGroup[$id]['Transmision']['senal_respaldo2_nombre'] = $senalesList[$partido['TransmisionPartido']['transmision_senales_respaldo2_senale_id']]["nombre"];
                $partidosGroup[$id]['Transmision']['medio_respaldo2_nombre'] = $senalesList[$partido['TransmisionPartido']['transmision_senales_respaldo2_senale_id']]["medio_tx"];
            }
            
            $partidosGroup[$id]['Transmision']['principal_meta'] = json_decode($partidosGroup[$id]['Transmision']['principal_meta']);
            $partidosGroup[$id]['Transmision']['respaldo_meta'] = json_decode($partidosGroup[$id]['Transmision']['respaldo_meta']);
            $partidosGroup[$id]['Transmision']['radio_meta'] = json_decode($partidosGroup[$id]['Transmision']['radio_meta']);
            $partidosGroup[$id]['Transmision']['respaldo2_meta'] = json_decode($partidosGroup[$id]['Transmision']['respaldo2_meta']);
            
            if(isset($partido['TransmisionPartido']['radio'])){
                $partidosGroup[$id]['Transmision']['senal_radio_nombre'] = $senalesList[$partido['TransmisionPartido']['radio']]["nombre"];
                $partidosGroup[$id]['Transmision']['medio_radio_nombre'] = $senalesList[$partido['TransmisionPartido']['radio']]["medio_tx"];
            }else{
                $partidosGroup[$id]['Transmision']['senal_radio_nombre'] = "";
            }
            
            $partidosGroup[$id]['ProduccionPartidosEvento'] = $partido['ProduccionPartidosEvento'];
            $partidosGroup[$id]['ProduccionPartidosEvento']['fecha_string'] = $fechastr;
            $partidosGroup[$id]['Equipo'] = $partido['equipo'];
            $partidosGroup[$id]['EquipoVisita'] = $partido['equipovisita'];
            $partidosGroup[$id]['Categoria'] = $partido['categoria'];
            $partidosGroup[$id]['Estadio'] = $partido['Estadio'];
            $partidosGroup[$id]['estadio'] = $partido['estadio'];
            $partidosGroup[$id]['Estadio']['region_ordinal'] = $regiones[$partido['Estadio']['regione_id']];
            $partidosGroup[$id]['ProduccionPartidosTransmisione'] = $partido['ProduccionPartidosTransmisione'];
            
            if(isset($existePrevia[0]['ProduccionPartidosTransmisione']['tipo_transmisione_id']) && $existePrevia[0]['ProduccionPartidosTransmisione']['tipo_transmisione_id'] == 3){
                $partidosGroup[$id]['ProduccionPartidosTransmisione']['hora_transmision'] = $existePrevia[0]['ProduccionPartidosTransmisione']['hora_transmision'];
                $partidosGroup[$id]['ProduccionPartidosTransmisione']['hora_transmision_gmt'] = $existePrevia[0]['ProduccionPartidosTransmisione']['hora_transmision_gmt'];
            }
            
            $partidosGroup[$id]['ProduccionPartidosTransmisione']['nombre_partido'] = $numeroPartidos[$partido['ProduccionPartidosTransmisione']['numero_partido_id']];
            $partidosGroup[$id]['NombreProveedor'] = $this->proveedorCompanies[$partido["ProduccionPartidosTransmisione"]["proveedor_company_id"]];
            $partidosGroup[$id]['TransmisionMovile'] = $transmisionMovile[$partido['ProduccionPartidosTransmisione']['transmisiones_movile_id']]['TransmisionesMovile'];
        }
        foreach ($partidosGroup as $key => $value) {
            $partidosGroup[$key]["campeonatos"] = $campeonatos["nombres"];
        }
        return json_encode($partidosGroup);
    }
    
    public function reporte() {
        $this->acceso();
        $this->set("appAngular", "angularAppText");
        $this->layout = "angular";
    }
    
    public function add_informe_senales() {
        $this->layout = "ajax";
        $this->autoRender = false;
        $this->response->type("json");
        //$this->loadModel("model");
        if ($this->request->is(array('post'))){
            pr($this->request->data);exit;
            //$this->request->data["model"]["programa"] = $this->request->data["programa"];
            //$this->request->data["model"]["hora_ini_evento"] = $this->request->data["hora_ini_evento"];
            //$this->request->data["model"]["hora_out_evento"] = $this->request->data["hora_out_evento"];
            //$this->request->data["model"]["selectedItemReceptorSatelite"] = $this->request->data["selectedItemReceptorSatelite"];
            //$this->request->data["model"]["hora_ini_satelite"] = $this->request->data["hora_ini_satelite"];
            //$this->request->data["model"]["hora_out_satelite"] = $this->request->data["hora_out_satelite"];
            //$this->request->data["model"]["signal_level"] = $this->request->data["signal_level"];
            //$this->request->data["model"]["ber"] = $this->request->data["ber"];
            //$this->request->data["model"]["cn"] = $this->request->data["cn"];
            //$this->request->data["model"]["cn_margin"] = $this->request->data["cn_margin"];
            //$this->request->data["model"]["rx_senal_satelite"] = $this->request->data["rx_senal_satelite"];
            //$this->request->data["model"]["selectedItemReceptorFibra"] = $this->request->data["selectedItemReceptorFibra"];
            //$this->request->data["model"]["hora_ini_fibra"] = $this->request->data["hora_ini_fibra"];
            //$this->request->data["model"]["hora_out_fibra"] = $this->request->data["hora_out_fibra"];
            //$this->request->data["model"]["rx_senal_fibra"] = $this->request->data["rx_senal_fibra"];
            //$this->request->data["model"]["selectedItemReceptorFibra"] = $this->request->data["selectedItemReceptorFibra"];
            //$this->request->data["model"]["hora_ini_micro"] = $this->request->data["hora_ini_micro"];
            //$this->request->data["model"]["hora_out_micro"] = $this->request->data["hora_out_micro"];
            //$this->request->data["model"]["rx_senal_micro"] = $this->request->data["rx_senal_micro"];
            if($this->model->save($this->request->data["model"])){
                $mensaje = array( "estado"=>1,"mensaje"=>"Datos registrados correctamente");
			}else{
					$mensaje = array("estado"=>0,"mensaje"=>"No se pudo registrar la información");
					$this->Session->setFlash('No se pudo registrar la información', 'fallo');
			}
        }else{
               $mensaje = array("estado"=>0,"mensaje"=>"Error.",);
        }
        return json_encode($mensaje);
    }
    public function informe_senales() {
        $this->layout = "angular";      
    }
	 public function informe_view() {
        $this->layout = "angular";      
    }
}