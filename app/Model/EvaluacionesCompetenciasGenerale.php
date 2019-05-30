<?php
App::uses('AppModel', 'Model');
/**
 * EvaluacionesCompetenciasGenerale Model
 *
 * @property EvaluacionesTrabajadore $EvaluacionesTrabajadore
 * @property CompetenciasGenerale $CompetenciasGenerale
 * @property NivelesLogro $NivelesLogro
 */
class EvaluacionesCompetenciasGenerale extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'EvaluacionesTrabajadore' => array(
			'className' => 'EvaluacionesTrabajadore',
			'foreignKey' => 'evaluaciones_trabajadore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CompetenciasGenerale' => array(
			'className' => 'CompetenciasGenerale',
			'foreignKey' => 'competencias_generale_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'NivelesLogro' => array(
			'className' => 'NivelesLogro',
			'foreignKey' => 'niveles_logro_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
