<?php
App::uses('AppModel', 'Model');
/**
 * TitulosCompetencia Model
 *
 * @property CompetenciasGenerale $CompetenciasGenerale
 * @property GruposCompetencia $GruposCompetencia
 */
class TitulosCompetencia extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CompetenciasGenerale' => array(
			'className' => 'CompetenciasGenerale',
			'foreignKey' => 'titulos_competencia_id',
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
		'GruposCompetencia' => array(
			'className' => 'GruposCompetencia',
			'foreignKey' => 'titulos_competencia_id',
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

}
