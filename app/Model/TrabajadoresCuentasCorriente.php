<?php
App::uses('AppModel', 'Model');
/**
 * TrabajadoresCuentasCorriente Model
 *
 * @property Trabajadore $Trabajadore
 * @property CuentasCorriente $CuentasCorriente
 */
class TrabajadoresCuentasCorriente extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Trabajadore' => array(
			'className' => 'Trabajadore',
			'foreignKey' => 'trabajadore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CuentasCorriente' => array(
			'className' => 'CuentasCorriente',
			'foreignKey' => 'cuentas_corriente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
