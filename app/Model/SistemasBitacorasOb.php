<?php
App::uses('AppModel', 'Model');
/**
 * SistemasBitacorasOb Model
 *
 * @property User $User
 * @property SistemasBitacora $SistemasBitacora
 */
class SistemasBitacorasOb extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
		'SistemasBitacora' => array(
			'className' => 'SistemasBitacora',
			'foreignKey' => 'sistemas_bitacora_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
