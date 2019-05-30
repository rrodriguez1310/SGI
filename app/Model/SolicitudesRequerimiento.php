<?php
App::uses('AppModel', 'Model');
/**
 * SolicitudesRequerimiento Model
 *
 * @property User $User
 * @property Dimensione $Dimensione
 * @property CodigosPresupuesto $CodigosPresupuesto
 * @property TiposMoneda $TiposMoneda
 */
class SolicitudesRequerimiento extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $name = 'solicitudes_requerimientos';
	public $validate = array(
		'fecha' 					=> array(
											'validate' => array(
												'rule' => 'notEmpty',
												'message' => 'Campo Obligatorio'
											)
										),
		'titulo' 					=> array(
											'validate' => array(
												'rule' => 'notEmpty',
												'message' => 'Campo Obligatorio'
											)
										),
		'tipos_moneda_id'  			=> array(
											'validate' => array(
												'rule' => 'notEmpty',
												'message' => 'Campo Obligatorio'
											)
										),
		'monto'  					=> array(
											'validate' => array(
												'rule' => 'notEmpty',
												'message' => 'Campo Obligatorio',
												
											),
											/*'min' => array(
												'min' => 1,
												'message' => 'Monto debe ser mayor a 1'
											),*/
											'money'=>array(

												'rule' => array('money', 'left'),
											)
										),
		'dimensione_id'  			=> array(
											'validate' => array(
												'rule' => 'notEmpty',
												'message' => 'Campo Obligatorio'
											)
										),
		'codigos_presupuesto_id'  	=> array(
											'validate' => array(
												'rule' => 'notEmpty',
												'message' => 'Campo Obligatorio'
											)
										),
		'observacion'  				=> array(
											'validate' => array(
												'rule' => 'notEmpty',
												'message' => 'Campo Obligatorio'
											)
										)

	);



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
		'Dimensione' => array(
			'className' => 'Dimensione',
			'foreignKey' => 'dimensione_id',
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
		'TiposMoneda' => array(
			'className' => 'TiposMoneda',
			'foreignKey' => 'tipos_moneda_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
