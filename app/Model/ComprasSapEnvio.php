<?php
App::uses('AppModel', 'Model');
/**
 * ComprasSapEnvio Model
 *
 * @property ComprasProductosTotale $ComprasProductosTotale
 * @property User $User
 */
class ComprasSapEnvio extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ComprasProductosTotale' => array(
			'className' => 'ComprasProductosTotale',
			'foreignKey' => 'compras_productos_totale_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
