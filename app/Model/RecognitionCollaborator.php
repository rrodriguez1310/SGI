<?php
App::uses('AppModel', 'Model');
/**
 * RecognitionCollaborator Model
 *
 * @property Subconducts $Subconducts
 * @property Boss $Boss
 * @property Employed $Employed
 * @property Product $Product
 */
class RecognitionCollaborator extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'recognition_collaborator';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'subconducts_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'boss_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'employed_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'points_add' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'points_delete' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'product_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'descrption' => array(
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
		'Subconducts' => array(
			'className' => 'RecognitionSubconduct',
			'foreignKey' => 'subconducts_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Boss' => array(
			'className' => 'Trabajadore',
			'foreignKey' => 'boss_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Employed' => array(
			'className' => 'Trabajadore',
			'foreignKey' => 'employed_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Product' => array(
			'className' => 'RecognitionProduct',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/*Registra el egreso de los puntos de la jefatura*/
	public function egreso($parametros){
		$ssql = "insert into recognition_collaborator (id, subconducts_id, boss_id, employed_id, points_add, points_delete, change, product_id, descrption, created, modified )
 				values (".$parametros[0].",0,0,".$parametros[2].",0,".$parametros[3].",1,".$parametros[1].",'Puntos canjeados',now(),now());";
		$rs_query = $this->query($ssql); 	
	}
}
