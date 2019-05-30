<?php
App::uses('AppModel', 'Model');
/**
 * ComprasProducto Model
 *
 * @property ComprasProductosTotale $ComprasProductosTotale
 */
class ComprasProducto extends AppModel {


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
	);
}
