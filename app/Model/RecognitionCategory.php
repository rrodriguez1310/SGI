<?php
App::uses('AppModel', 'Model');
/**
 * RecognitionCategory Model
 *
 * @property Statu $Statu
 */
class RecognitionCategory extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'recognition_categorys';

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
				'message' => 'La categoría ya existe',
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
		
		$ssql = "Select statu_id from recognition_categorys WHERE statu_id = 1 and id= '".$id."'";
		$rs_query = $this->query($ssql);
		
		if(count($rs_query) > 0){
			return $rs_query;
		}	
	}

	/*Elimina de forma logica el registro, cambiando su estado*/
	public function deletes($id){
		
		$ssql = "UPDATE recognition_categorys SET statu_id = 2 WHERE id= '".$id."'";
		$rs_query = $this->query($ssql); 	
	}
	
}
