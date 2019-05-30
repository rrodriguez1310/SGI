<?php
App::uses('AppModel', 'Model');
/**
 * ComprasEstado Model
 *
 * @property ComprasProductosTotale $ComprasProductosTotale
 */
class ComprasEstado extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ComprasProductosTotale' => array(
			'className' => 'ComprasProductosTotale',
			'foreignKey' => 'compras_estado_id',
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
