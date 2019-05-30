<?php
App::uses('AppModel', 'Model');
/**
 * InduccionPregunta Model
 *
 * @property InduccionEstado $InduccionEstado
 * @property InduccionEtapa $InduccionEtapa
 * @property InduccionRespuesta $InduccionRespuesta
 */
class InduccionPregunta extends AppModel {


	public $displayField = 'pregunta';
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
		public $validate = array(
			'pregunta' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'valor' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'induccion_estado_id' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'induccion_etapa_id' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
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
		'Estado' => array(
			'className' => 'InduccionEstado',
			'foreignKey' => 'induccion_estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Etapa' => array(
			'className' => 'InduccionEtapa',
			'foreignKey' => 'induccion_etapa_id',
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
		'InduccionRespuesta' => array(
			'className' => 'InduccionRespuesta',
			'foreignKey' => 'induccion_pregunta_id',
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
