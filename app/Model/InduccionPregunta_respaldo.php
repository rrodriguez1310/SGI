<?php
App::uses('AppModel', 'Model');
/**
 * InduccionPregunta Model
 *
 * @property Estado $Estado
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
		'estado_id' => array(
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
		'Etapa' => array(
			'className' => 'InduccionEtapa',
			'foreignKey' => 'etapa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Estado' => array(
			'className' => 'InduccionEstado',
			'foreignKey' => 'estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/*Verifica el estado del registro*/
	public function estado($id){
		$ssql = "Select estado_id from induccion_preguntas WHERE estado_id = 1 and id= '".$id."'";
		$rs_query = $this->query($ssql);
		
		if(count($rs_query) > 0){
			return $rs_query;
		}	
	}

	/*Elimina de forma logica el registro, cambiando su estado*/
	public function eliminar($id){
		$ssql = "UPDATE induccion_preguntas SET estado_id = 2 WHERE id= '".$id."'";
		$rs_query = $this->query($ssql); 
		
	}
}
