<?php
App::uses('AppModel', 'Model');
/**
 * RecognitionSubconduct Model
 *
 * @property Conduct $Conduct
 * @property Statu $Statu
 */
class RecognitionSubconduct extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'La sub-conducta ya existe',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'conduct_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'points' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'statu_id' => array(
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
		'Conduct' => array(
			'className' => 'RecognitionConduct',
			'foreignKey' => 'conduct_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Statu' => array(
			'className' => 'RecognitionStatus',
			'foreignKey' => 'statu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	/*Verifica el estado del registro*/
	public function statu($id){
		
		$ssql = "Select statu_id from recognition_subconducts WHERE statu_id = 1 and id= '".$id."'";
		$rs_query = $this->query($ssql);
		
		if(count($rs_query) > 0){
			return $rs_query;
		}
		
	}

	/*Elimina de forma logica el registro, cambiando su estado*/
	public function deletes($id){
		
		$ssql = "UPDATE recognition_subconducts SET statu_id = 2 WHERE id= '".$id."'";
		$rs_query = $this->query($ssql); 
		
	}
}
