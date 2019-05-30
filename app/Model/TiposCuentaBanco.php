<?php
App::uses('AppModel', 'Model');
/**
 * TiposCuentaBanco Model
 *
 * @property CuentasCorriente $CuentasCorriente
 */
class TiposCuentaBanco extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CuentasCorriente' => array(
			'className' => 'CuentasCorriente',
			'foreignKey' => 'tipos_cuenta_banco_id',
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
