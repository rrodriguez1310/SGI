<?php
App::uses('AppModel', 'Model');
/**
 * ProduccionPartidosEvento Model
 *
 * @property Campeonato $Campeonato
 * @property CampeonatosFase $CampeonatosFase
 * @property CampeonatosFecha $CampeonatosFecha
 * @property LocalEquipo $LocalEquipo
 * @property VisitaEquipo $VisitaEquipo
 * @property Estadio $Estadio
 * @property HistorialFixturePartido $HistorialFixturePartido
 * @property ProduccionPartido $ProduccionPartido
 * @property ProduccionPartidosChilefilm $ProduccionPartidosChilefilm
 * @property ProduccionPartidosTransmisione $ProduccionPartidosTransmisione
 */
class ProduccionPartidosEvento extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Campeonato' => array(
			'className' => 'Campeonato',
			'foreignKey' => 'campeonato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Categoria' => array(
			'className' => 'CampeonatosCategoria',
			'foreignKey' => 'campeonatos_categoria_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Subcategoria' => array(
			'className' => 'CampeonatosCategoria',
			'foreignKey' => 'campeonatos_subcategoria_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Equipo' => array(
			'className' => 'Equipo',
			'foreignKey' => 'local_equipo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EquipoVisita' => array(
			'className' => 'Equipo',
			'foreignKey' => 'visita_equipo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Estadio' => array(
			'className' => 'Estadio',
			'foreignKey' => 'estadio_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'ProduccionPartido' => array(
			'className' => 'ProduccionPartido',
			'foreignKey' => 'produccion_partidos_evento_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ProduccionPartidosChilefilm' => array(
			'className' => 'ProduccionPartidosChilefilm',
			'foreignKey' => 'produccion_partidos_evento_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ProduccionPartidosTransmisione' => array(
			'className' => 'ProduccionPartidosTransmisione',
			'foreignKey' => 'produccion_partidos_evento_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)		
	);
	
	public $hasMany = array( 
		'HistorialFixturePartido' => array(
			'className' => 'HistorialFixturePartido',
			'foreignKey' => 'produccion_partidos_evento_id',			
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'HistorialFixturePartido.created DESC',
			'limit' => '1',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);    
}
