<?php
App::uses('AppModel', 'Model');
/**
 * InduccionRespuesta Model
 *
 * @property Pregunta $Pregunta
 * @property Estado $Estado
 * @property InduccionPregunta $InduccionPregunta
 */
class InduccionRespuesta extends AppModel {

	public $displayField = 'respuesta';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'respuesta' => array(
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
		'induccion_pregunta_id' => array(
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

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Pregunta' => array(
			'className' => 'InduccionPregunta',
			'foreignKey' => 'induccion_pregunta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Estado' => array(
			'className' => 'InduccionEstado',
			'foreignKey' => 'induccion_estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		/*'InduccionPregunta' => array(
			'className' => 'InduccionPregunta',
			'foreignKey' => 'induccion_pregunta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)*/
	);
}
