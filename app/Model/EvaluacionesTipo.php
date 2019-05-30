<?php
App::uses('AppModel', 'Model');
/**
 * EvaluacionesTipo Model
 *
 * @property NivelesLogro $NivelesLogro
 */
class EvaluacionesTipo extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'NivelesLogro' => array(
			'className' => 'NivelesLogro',
			'foreignKey' => 'evaluaciones_tipo_id',
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
