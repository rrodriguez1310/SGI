<?php
App::uses('AppModel', 'Model');
/**
 * SistemasResponsable Model
 *
 * @property User $User
 * @property SistemasBitacora $SistemasBitacora
 */
class SistemasResponsable extends AppModel {


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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'SistemasBitacora' => array(
			'className' => 'SistemasBitacora',
			'foreignKey' => 'sistemas_responsable_id',
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
