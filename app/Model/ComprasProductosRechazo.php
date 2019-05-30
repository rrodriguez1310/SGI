<?php
App::uses('AppModel', 'Model');
/**
 * ComprasProductosRechazo Model
 *
 * @property User $User
 * @property ComprasProducto $ComprasProducto
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
		'ComprasProducto' => array(
			'className' => 'ComprasProducto',
			'foreignKey' => 'compras_producto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
