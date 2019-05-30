<?php
App::uses('AppModel', 'Model');
/**
 * NivelesLogro Model
 *
 * @property EvaluacionesTipo $EvaluacionesTipo
 * @property EvaluacionesCompetencia $EvaluacionesCompetencia
 * @property EvaluacionesCompetenciasGenerale $EvaluacionesCompetenciasGenerale
 * @property EvaluacionesObjetivo $EvaluacionesObjetivo
 * @property EvaluacionesTrabajadore $EvaluacionesTrabajadore
 */
class NivelesLogro extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'EvaluacionesTipo' => array(
			'className' => 'EvaluacionesTipo',
			'foreignKey' => 'evaluaciones_tipo_id',
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
			'foreignKey' => 'niveles_logro_id',
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
		'EvaluacionesCompetenciasGenerale' => array(
			'className' => 'EvaluacionesCompetenciasGenerale',
			'foreignKey' => 'niveles_logro_id',
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
		'EvaluacionesObjetivo' => array(
			'className' => 'EvaluacionesObjetivo',
			'foreignKey' => 'niveles_logro_id',
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
		'EvaluacionesTrabajadore' => array(
			'className' => 'EvaluacionesTrabajadore',
			'foreignKey' => 'niveles_logro_id',
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
