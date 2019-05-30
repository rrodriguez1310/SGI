<?php
App::uses('AppModel', 'Model');
/**
 * ComprasFactura Model
 *
 * @property ComprasProductosTotale $ComprasProductosTotale
 * @property TiposDocumento $TiposDocumento
 */
class ComprasFactura extends AppModel {


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
		'TiposDocumento' => array(
			'className' => 'TiposDocumento',
			'foreignKey' => 'tipos_documento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
