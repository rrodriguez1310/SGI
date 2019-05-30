<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
Configure::write('Session.autoRegenerate', true);
/**
 * InduccionPantallas Controller
 *
 * @property PaginatorComponent $Paginator
 */
class InduccionPantallasController extends AppController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');    

    public function index_json() {
        
        $this->layout = "ajax";	        
        $this->autoRender = false;
		$this->response->type('json');
        $this->loadModel("InduccionEtapa");
        $this->loadModel("InduccionQuize");
        $this->loadModel("InduccionProgreso");
        $this->loadModel("InduccionContenido");
        $this->loadModel("InduccionPregunta");
        $this->loadModel("User");
        $trabajadore_id = 0;

        $trabajadore_id = $this->params->query(["idTrabajador"]);  
             
        //obtengo los id de las lecciones asociada a un contenido, solo muestra el resultado si el contenido existe 
        $leccionesLists = $this->InduccionEtapa->InduccionContenido->find('list',array(
            "fields"=>array("InduccionContenido.induccion_etapa_id"),
            "conditions"=> array("InduccionContenido.induccion_estado_id = 1" )
        ));
        //saco del array los etapa_id repetidos
        $leccionesLists = array_unique($leccionesLists);


        //Muestra lecciones activas en el index
        $lecciones = $this->InduccionEtapa->find('all',array(
			'conditions'=>array(
                'InduccionEtapa.induccion_estado_id'=>1,
                'InduccionEtapa.id'=>$leccionesLists,
			),'order' => 'InduccionEtapa.id ASC',
			'recursive'=>-1
        ));

        //obtiene una lista con las lecciones activas
        $leccionesList = $this->InduccionEtapa->find('list',array(
            "fields"=>array("InduccionEtapa.id"),
			'conditions'=>array(
                'InduccionEtapa.id'=>$leccionesLists,
                'InduccionEtapa.induccion_estado_id'=>1
			),'recursive'=>0
        ));

        //obtiene una lista con los contenidos activos asociados a una leccion
        $contenidos = $this->InduccionContenido->find('list', array(
            "fields"=>array("InduccionContenido.induccion_etapa_id"),
            'conditions'=>array(
                'InduccionContenido.induccion_estado_id' => 1,
                'InduccionContenido.induccion_etapa_id' => $leccionesList),
        ));

        //ordeno los id de las etapas
        asort($contenidos);

        $array_contenidos = array_count_values($contenidos);
       
        //Agrego al array los elementos contenido y activo
        foreach ($lecciones as $key => $value) {
            
            $lecciones[0]['InduccionEtapa']['activo'] = true; //La primera leccion vendra desbloqueada
            if(isset($lecciones[$key]['InduccionEtapa']['id'])){
                $lecciones[$key]['InduccionEtapa']['contenido'] = $array_contenidos[$value['InduccionEtapa']['id']]; 
                $lecciones[$key]['InduccionEtapa']['activo'] = false; 
                $lecciones[$key]['InduccionEtapa']['tienequiz'] = 0;
            }
        }

        $progresos1=[];
        foreach ($array_contenidos as $key => $value) {
            //Consulto por la llave que es estapa_id
            $progresos = $this->InduccionProgreso->find('first',array(
                "fields"=>array("count(InduccionProgreso.terminado)"),
                'conditions'=>array(
                    'InduccionProgreso.terminado'=>1,
                    'InduccionProgreso.induccion_contenido_id !='=> '',
                    "InduccionProgreso.induccion_etapa_id"=> $key,
                    "InduccionProgreso.trabajadore_id"=> $trabajadore_id
                ),
                'recursive'=>0
            ));
           $progresos1[$key]=$progresos[0]['count']; 
        }

        $preguntas = $this->InduccionPregunta->find('all',array(
            'conditions'=>array(
                'InduccionPregunta.induccion_estado_id' => 1,
                'Etapa.induccion_estado_id' => 1,
                'InduccionPregunta.induccion_etapa_id' => $leccionesList),
        ));

        foreach ($lecciones as $key => $value) {
            if(isset($lecciones[$key]['InduccionEtapa']['id'])){
                $lecciones[$key]['InduccionEtapa']['estado'] = $progresos1[$value['InduccionEtapa']['id']] ; 
                if($lecciones[$key]['InduccionEtapa']['contenido'] == $progresos1[$value['InduccionEtapa']['id']] ) {
                    $lecciones[$key+1]['InduccionEtapa']['activo'] = true;
                }
                
                foreach ($preguntas as $llave => $valor) {

                    $induccionQuize = $this->InduccionQuize->find('all', array(
                        "fields"=>array("InduccionQuize.*" ),
                        'conditions'=>array(
                            'InduccionQuize.induccion_etapa_id' =>  $lecciones[$key]['InduccionEtapa']['id'],
                            'InduccionQuize.induccion_trabajador_id' => $trabajadore_id,
                        ),
                    ));

                    if(isset($induccionQuize)){
                    
                        if($lecciones[$key]['InduccionEtapa']['id'] == $valor['InduccionPregunta']['induccion_etapa_id'] ){
                            $lecciones[$key]['InduccionEtapa']['tienequiz'] = 1;
                        }

                        if($lecciones[$key]['InduccionEtapa']['tienequiz']== 1 && count($induccionQuize) < 1){
                            $lecciones[$key+1]['InduccionEtapa']['activo'] = false;  
                        }
                    }
                }
            }
        }
        $salidaJson ="";

		foreach($lecciones as  $value){
            if( isset($value['InduccionEtapa']['id']) ){
			    $salidaJson[] = array(
                    'id'                => $value['InduccionEtapa']['id'],
                    'titulo'            => $value['InduccionEtapa']['titulo'],
                    'descripcion'       => $value['InduccionEtapa']['descripcion'],
                    'peso'              => $value['InduccionEtapa']['peso'],
                    'image'             => $value['InduccionEtapa']['image'],
                    'imagedir'          => $value['InduccionEtapa']['imagedir'],
                    'porcentaje_minimo' => $value['InduccionEtapa']['porcentaje_minimo'],
                    'estado_id'         => $value['InduccionEtapa']['induccion_estado_id'],
                    'created'           => $value['InduccionEtapa']['created'],
                    'modified'          => $value['InduccionEtapa']['modified'] ,
                    'contenido'         => $value['InduccionEtapa']['contenido'],
                    'activo'            => $value['InduccionEtapa']['activo'],
                    'estado'            => $value['InduccionEtapa']['estado']
                );
            }
		}
        return json_encode($salidaJson);
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
        
        $this->layout = "angular";
        $this->loadModel("User");
        $this->loadModel("Trabajadore");       
        $this->acceso();
        $user = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
            "conditions"=>array(
                "User.id" => $this->Session->read('PerfilUsuario.idUsuario')
            ),
            "recursive"=>-1
        ));        
        $this->set('idTrabajador', $user["User"]["trabajadore_id"]);     
        
    }

    public function getContenidos_json(){
        
        $this->layout = "ajax";	
        $this->autoRender = false;
		$this->response->type('json');
        $this->loadModel("InduccionContenido");
        $this->loadModel("InduccionPregunta");

        $leccion_id = $this->params->query['leccion_id'];

        $preguntas = $this->InduccionPregunta->find('all',array(
            'conditions'=>array(
                'InduccionPregunta.induccion_estado_id' => 1,
                'Etapa.induccion_estado_id' => 1,
                'InduccionPregunta.induccion_etapa_id' => $leccion_id),
        ));

        $resultado = (count($preguntas)>0) ? 1 : 0;

        $contenidos = $this->InduccionContenido->find('all', array(
			'conditions'=>array(
                'InduccionContenido.induccion_estado_id' => 1,
                'InduccionContenido.induccion_etapa_id' => $leccion_id ),
            'order' => 'InduccionContenido.peso ASC',
			'recursive'=>0
        ));

        $salidaJson ="";

		foreach($contenidos as $key => $value){
            
			$salidaJson[] = array(
				'id'=>$value['InduccionContenido']['id'],
				'titulo'=>$value['InduccionContenido']['titulo'],
				'image'=>$value['InduccionContenido']['image'],
				'imagedir'=>$value['InduccionContenido']['imagedir'],
				'descripcion'=> unserialize($value['InduccionContenido']['descripcion']),
                'peso'=>$value['InduccionContenido']['peso'],
                'etapa_id'=>$value['InduccionContenido']['induccion_etapa_id'],
                'estado_id'=>$value['InduccionContenido']['induccion_estado_id'],
				'created'=>$value['InduccionContenido']['created'],
                'modified'=>$value['InduccionContenido']['modified'],
                'quiz'=>$resultado
			);
        }

        return json_encode($salidaJson);
    }

    public function contenidos($id) {
        $this->layout = "angular";
        $this->loadModel("InduccionEtapas");    
        $this->loadModel("User");      
        $this->acceso();
        $user = $this->User->find("first", array(
			"fields"=>array("User.trabajadore_id"),
            "conditions"=>array(
                "User.id" => $this->Session->read('PerfilUsuario.idUsuario')
            ),
            "recursive"=>-1
        ));        
        $this->set('idTrabajador', $user["User"]["trabajadore_id"]); 
	}


    public function avance(){

        $this->layout = "ajax";	
        $this->acceso();
        $this->autoRender = false;
        $this->loadModel("User");
        $this->loadModel("Trabajadore");
        $this->loadModel("InduccionProgreso");
    

        $etapa_id = $this->params->query['leccion']; 
        $contenido_id = $this->params->query['contenido']; 
        $trabajador_id = $this->params->query['trabajador_id'];
        
        $data = array(
            "trabajadore_id" => $trabajador_id, 
            "induccion_etapa_id"=>$etapa_id, 
            "prueba_id"=>0 , 
            "terminado"=>1,
            "induccion_contenido_id"=>$contenido_id
        );
        
        if($this->request->is('post')) {
            $this->InduccionProgreso->save($data);
        }
        
    }

    public function getContenidos(){

        $this->autoRender = false;
        $this->acceso();
        $this->loadModel("User");
        $this->loadModel("Trabajadore");
        $this->loadModel("InduccionProgreso");
        $trabajadore_id = 0 ;

        $etapa_id = $this->params->query['leccion_id']; 
        $contenido_id = $this->params->query['induccion_contenido_id']; 
        $trabajadore_id = $this->params->query['trabajador_id'];            
        $progreso = $this->InduccionProgreso->find('all', array(
            'fields'=>'InduccionProgreso.*',
            'conditions'=>array(
                'InduccionProgreso.trabajadore_id' => $trabajadore_id,
                'InduccionProgreso.induccion_etapa_id' => $etapa_id,
                'InduccionProgreso.terminado' => 1,
                'InduccionProgreso.induccion_contenido_id' => $contenido_id
                ),"recursive"=>0
        ));

        $progreso =  count($progreso);
        return $progreso;       

    }

    public function reports_json(){
        $this->autoRender = false ;
        $this->loadModel("User");
        $this->loadModel("InduccionQuize");
        $this->loadModel("InduccionEtapa");
        $this->loadModel("Trabajadore");
        $this->loadModel("InduccionProgreso");
        $this->loadModel("InduccionContenido");
        $this->loadModel("InduccionPregunta");

        //obtiene una lista con las lecciones 
        $leccionesList = $this->InduccionEtapa->find('list',array(
            "fields"=>array("InduccionEtapa.id")
        ));

        //obtiene una lista con los contenidos activos asociados a una leccion
        $contenidos = $this->InduccionContenido->find('list', array(
            "fields"=>array("InduccionContenido.induccion_etapa_id"),
            'conditions'=>array(
                'InduccionContenido.induccion_estado_id' => 1,
                'InduccionContenido.induccion_etapa_id' => $leccionesList),
        ));

        //ordeno los id de las etapas
        asort($contenidos);

        $array_contenidos = array_count_values($contenidos);
        
        $salida = $this->InduccionProgreso->find('all',array(
        "fields"=>array("Trabajadore.id","Trabajadore.nombre", "Trabajadore.apellido_paterno", "Trabajadore.apellido_materno", "Cargos.nombre", "Gerencias.nombre", "Etapa.id", "Etapa.titulo", "Quiz.porcentaje_calificacion"),
            "joins"=> array(
                array("table" => "cargos", "alias" => "Cargos", "type" => "LEFT", "conditions" => array("Cargos.id = Trabajadore.cargo_id")),
                array("table" => "dimensiones", "alias" => "Gerencias", "type" => "LEFT", "conditions" => array("Gerencias.id = Trabajadore.dimensione_id ")),
                array("table" => "induccion_quizzes", "alias" => "Quiz", "type" => "LEFT", "conditions" => array("Quiz.induccion_trabajador_id = Trabajadore.id and Quiz.porcentaje_calificacion > 0 and Quiz.induccion_etapa_id = Etapa.id " )),
            ),
            'conditions'=>array(
                'InduccionProgreso.induccion_contenido_id'=>''
            ),
            'order' => 'InduccionProgreso.id ASC'
        ));

        //Agrego los elementos contenido, activo, tienequiz y avance
        foreach ($salida as $key => $value) {
            if(isset($salida[$key]['Etapa']['id'])){
                $salida[$key]['Etapa']['contenido'] = $array_contenidos[$value['Etapa']['id']]; 
                $salida[$key]['Etapa']['leccionTerminada'] = 0 ;
                $salida[$key]['Etapa']['tienequiz'] = 0;
                $salida[$key]['Etapa']['quizTerminada'] = 0;
                $salida[$key]['Etapa']['avance'] = 0;
                $salida[$key]['Etapa']['puntos'] = 0;
                $salida[$key]['Etapa']['Trabajadore'] = 'hhh';
            }
        }

       $traba = [];
        $traba = $this->InduccionProgreso->find('list',array(
            "fields"=>array("InduccionProgreso.trabajadore_id"),
            'conditions'=>array(
                'InduccionProgreso.terminado'=>1,
                'InduccionProgreso.induccion_contenido_id ='=> ''
            ),
            'recursive'=>0
        ));

        //saco del array los etapa_id repetidos
        $traba = array_unique($traba);
        $progresos = array();
        foreach ($traba as $llave2 => $idTrab) {            
            foreach ($array_contenidos as $key => $value) {
                //Consulto por la llave que es etapa_id
                $progresos = $this->InduccionProgreso->find('first',array(
                    "fields"=>array("count(InduccionProgreso.terminado)"),
                    'conditions'=>array(
                        'InduccionProgreso.terminado'=>1,
                        'InduccionProgreso.induccion_contenido_id !='=> '',
                        "InduccionProgreso.induccion_etapa_id"=> $key,
                        "InduccionProgreso.trabajadore_id" => $idTrab
                    ),
                    'recursive'=>0
                ));
            $progresos1[$idTrab][$key]=$progresos[0]['count']; 
            }            
        } 
        
        $preguntas = $this->InduccionPregunta->find('all',array(
            'conditions'=>array(
                'InduccionPregunta.induccion_estado_id' => 1,
                'Etapa.induccion_estado_id' => 1,
                'InduccionPregunta.induccion_etapa_id' => $leccionesList),

        ));

        asort($salida);
        foreach ($salida as $key => $value) {
            $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key] = $salida[$key];

            if(isset($salida[$key]['Etapa']['id'])){             

                $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['avance'] = $progresos1[$salida[$key]['Trabajadore']['id']][$value['Etapa']['id']] ;            

                if($salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['contenido'] == $progresos1[$salida[$key]['Trabajadore']['id']][$value['Etapa']['id']] ) {
                    $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['leccionTerminada'] = 1;
                }
            }
              
            foreach ($preguntas as $llave => $valor) {

                $induccionQuize = $this->InduccionQuize->find('all', array(
                    "fields"=>array("InduccionQuize.*" ),
                    'conditions'=>array(
                        'InduccionQuize.induccion_etapa_id' =>  $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['id'],
                        'InduccionQuize.induccion_trabajador_id' =>  $salida[$key]['Trabajadore']['id'],
                        'InduccionQuize.porcentaje_calificacion >' => 0

                    ),
                ));
                
                if(isset($induccionQuize)){
                
                    if($salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['id'] == $valor['InduccionPregunta']['induccion_etapa_id'] ){
                        $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['tienequiz'] = 1;
                        $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['puntos'] = 0;
                        
                    }

                    if($salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['tienequiz']== 1 && count($induccionQuize) < 1){
                        $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['leccionTerminada'] = 0; 
                        $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['puntos'] = 2;
                        $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['quizTerminada'] = 0;
                    }

                    if($salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['tienequiz']== 1 && count($induccionQuize) >= 1){
                        $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['quizTerminada'] = 1;
                        $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['puntos'] = $induccionQuize[0]['InduccionQuize']['porcentaje_calificacion'];  
                    }

                    if($salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['tienequiz'] == 0 ){
                        $salidaTrabajador[$salida[$key]['Trabajadore']['id']][$key]['Etapa']['quizTerminada'] = 2;
                    }
                }
                
            }
           
        }   

        $salidaJson ="";

		foreach($salidaTrabajador as $key => $value){           
            foreach($salidaTrabajador[$key] as $value){
                $salidaJson[] = array(
                    'nombre'        => ucwords($value['Trabajadore']['nombre'])." ".ucwords($value['Trabajadore']['apellido_paterno'])." ".ucwords($value['Trabajadore']['apellido_materno']),
                    'cargo'         => ucwords($value['Cargos']['nombre']),
                    'gerencia'      => ucwords($value['Gerencias']['nombre']),
                    'etapa'         => ucwords($value['Etapa']['titulo']),
                    'leccionTermin' => $value['Etapa']['leccionTerminada'],
                    'quizTermin'    => $value['Etapa']['quizTerminada'],
                    'puntos'        => $value['Quiz']['porcentaje_calificacion']
                );
            }
			
		}
		
        echo json_encode($salidaJson);

    }
    
    public function reports(){

        $this->layout = "angular";
        $this->acceso();
    }

}