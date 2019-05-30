<?php
App::uses('AppModel', 'Model');
/**
 * NivelEducacion Model
 *
 * @property Trabajadore $Trabajadore
 */
class NivelEducacion extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Trabajadore' => array(
			'className' => 'Trabajadore',
			'foreignKey' => 'nivel_educacion_id',
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
