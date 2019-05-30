<?php
App::uses('AppModel', 'Model');
/**
 * ComprasProductosRechazo Model
 *
 * @property User $User
 * @property ComprasProductosTotale $ComprasProductosTotale
 */
class ComprasProductosRechazo extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ComprasProductosTotale' => array(
			'className' => 'ComprasProductosTotale',
			'foreignKey' => 'compras_productos_totale_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
