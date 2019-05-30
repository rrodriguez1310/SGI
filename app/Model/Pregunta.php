<?php
App::uses('AppModel', 'Model');
/**
 * Pregunta Model
 *
 * @property Prueba $Prueba
 * @property Respuesta $Respuesta
 */
class Pregunta extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Prueba' => array(
			'className' => 'Prueba',
			'foreignKey' => 'prueba_id',
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
		'Respuesta' => array(
			'className' => 'Respuesta',
			'foreignKey' => 'pregunta_id',
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
