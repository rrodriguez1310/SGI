<?php
App::uses('AppModel', 'Model');
/**
 * ComprasTarjeta Model
 *
 * @property TipoMoneda $TipoMoneda
 * @property CodigoPresupuesto $CodigoPresupuesto
 * @property Dimensione $Dimensione
 * @property CompraTarjetaEstado $CompraTarjetaEstado
 * @property User $User
 */
class ComprasTarjeta extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'url_producto' => array(
			//'alphaNumeric' => array(
				//'rule' => array('alphaNumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//),
		),
		'monto' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cuota' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'TiposMoneda' => array(
			'className' => 'TiposMoneda',
			'foreignKey' => 'tipos_moneda_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CodigosPresupuesto' => array(
			'className' => 'CodigosPresupuesto',
			'foreignKey' => 'codigos_presupuesto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Dimensione' => array(
			'className' => 'Dimensione',
			'foreignKey' => 'dimensione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ComprasTarjetasEstado' => array(
			'className' => 'ComprasTarjetasEstado',
			'foreignKey' => 'compras_tarjetas_estado_id',
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
