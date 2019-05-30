<?php
App::uses('AppModel', 'Model');
/**
 * FixturePartido Model
 *
 * @property Campeonato $Campeonato
 * @property CampeonatosFase $CampeonatosFase
 * @property CampeonatosFecha $CampeonatosFecha
 * @property Estadio $Estadio
 */
class FixturePartido extends AppModel {


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
		'Estadio' => array(
			'className' => 'Estadio',
			'foreignKey' => 'estadio_id',
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
		)
	);
}
