<?php
App::uses('AppModel', 'Model');
/**
 * ComprasProductosTotale Model
 *
 * @property Company $Company
 * @property TiposMoneda $TiposMoneda
 * @property User $User
 * @property PlazosPago $PlazosPago
 * @property TiposDocumento $TiposDocumento
 * @property ComprasFactura $ComprasFactura
 * @property ComprasProducto $ComprasProducto
 * @property ComprasProductosRechazo $ComprasProductosRechazo
 */
class ComprasProductosTotale extends AppModel {
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TiposMoneda' => array(
			'className' => 'TiposMoneda',
			'foreignKey' => 'tipos_moneda_id',
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
		),
		'PlazosPago' => array(
			'className' => 'PlazosPago',
			'foreignKey' => 'plazos_pago_id',
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

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ComprasFactura' => array(
			'className' => 'ComprasFactura',
			'foreignKey' => 'compras_productos_totale_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ComprasProducto' => array(
			'className' => 'ComprasProducto',
			'foreignKey' => 'compras_productos_totale_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ComprasProductosRechazo' => array(
			'className' => 'ComprasProductosRechazo',
			'foreignKey' => 'compras_productos_totale_id',
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
