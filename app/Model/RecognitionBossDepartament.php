<?php
App::uses('AppModel', 'Model');
/**
 * RecognitionBossDepartament Model
 *
 * @property Employed $Employed
 * @property Statu $Statu
 */
class RecognitionBossDepartament extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */ 
	public $validate = array(
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
		'points_delete' => array(
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
		'statu_id' => array(
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		/*'Employed' => array(
			'className' => 'Trabajadore',
			'foreignKey' => 'employed_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),*/
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
		$ssql = "Select statu_id from recognition_boss_departaments WHERE statu_id = 1 and id= '".$id."'";
		$rs_query = $this->query($ssql);
		
		if(count($rs_query) > 0){
			return $rs_query;
		}	
	}

	/*Elimina de forma logica el registro, cambiando su estado*/
	public function deletes($id){
		$ssql = "UPDATE recognition_boss_departaments SET statu_id = 2 WHERE id= '".$id."'";
		$rs_query = $this->query($ssql); 
		
	}

	/*Registra el egreso de los puntos de la jefatura*/
	public function egreso($parametros){
		$ssql = "insert into recognition_boss_departaments (id, employed_id, points_add, points_delete, statu_id, descrption, created, modified )
 				values (".$parametros[0].",".$parametros[2].",0,".$parametros[1].",1,'Egreso',now(),now());";
		$rs_query = $this->query($ssql); 	
	}

	/*Incremente la secuencia de la tabla*/
	public function secuencia($newId){
		$ssql = "ALTER SEQUENCE recognition_boss_departaments_id_seq RESTART WITH ".$newId.";";
		$rs_query = $this->query($ssql); 
	
	}
}
