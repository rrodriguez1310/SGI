<?php
App::uses('AppModel', 'Model');
/**
 * Dimensione Model
 *
 * @property TiposDimensione $TiposDimensione
 */
class Dimensione extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	
	public $validate = array(
		'tipos_dimensione_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Dato obligatorio',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'codigo' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Dato obligatorio',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Dato obligatorio',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'descripcion' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Dato obligatorio',
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
		'TiposDimensione' => array(
			'className' => 'TiposDimensione',
			'foreignKey' => 'tipos_dimensione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
