<?php
App::uses('AppModel', 'Model');
/**
 * CuentasCorriente Model
 *
 * @property Banco $Banco
 * @property TiposCuentaBanco $TiposCuentaBanco
 * @property Trabajadore $Trabajadore
 */
class CuentasCorriente extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Banco' => array(
			'className' => 'Banco',
			'foreignKey' => 'banco_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TiposCuentaBanco' => array(
			'className' => 'TiposCuentaBanco',
			'foreignKey' => 'tipos_cuenta_banco_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Trabajadore' => array(
			'className' => 'Trabajadore',
			'joinTable' => 'trabajadores_cuentas_corrientes',
			'foreignKey' => 'cuentas_corriente_id',
			'associationForeignKey' => 'trabajadore_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
