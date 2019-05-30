<?php
App::uses('AppModel', 'Model');
/**
 * EvaluacionesEtapa Model
 *
 * @property EvaluacionesObjetivo $EvaluacionesObjetivo
 */
class EvaluacionesEtapa extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'EvaluacionesObjetivo' => array(
			'className' => 'EvaluacionesObjetivo',
			'foreignKey' => 'evaluaciones_etapa_id',
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
