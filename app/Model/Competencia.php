<?php
App::uses('AppModel', 'Model');
/**
 * Competencia Model
 *
 * @property GruposCompetencia $GruposCompetencia
 */
class Competencia extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'GruposCompetencia' => array(
			'className' => 'GruposCompetencia',
			'foreignKey' => 'grupos_competencia_id',
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
		'EvaluacionesCompetencia' => array(
			'className' => 'EvaluacionesCompetencia',
			'foreignKey' => 'competencia_id',
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
