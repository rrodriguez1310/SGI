<?php
App::uses('AppModel', 'Model');
/**
 * CompetenciasGenerale Model
 *
 * @property TitulosCompetencia $TitulosCompetencia
 */
class CompetenciasGenerale extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'TitulosCompetencia' => array(
			'className' => 'TitulosCompetencia',
			'foreignKey' => 'titulos_competencia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'EvaluacionesCompetenciasGenerale' => array(
			'className' => 'EvaluacionesCompetenciasGenerale',
			'foreignKey' => 'competencias_Generale_id',
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
