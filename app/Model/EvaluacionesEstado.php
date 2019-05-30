<?php
App::uses('AppModel', 'Model');
/**
 * EvaluacionesEstado Model
 *
 * @property EvaluacionesTrabajadore $EvaluacionesTrabajadore
 */
class EvaluacionesEstado extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'EvaluacionesTrabajadore' => array(
			'className' => 'EvaluacionesTrabajadore',
			'foreignKey' => 'evaluaciones_estado_id',
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
