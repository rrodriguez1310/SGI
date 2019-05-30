<?php
App::uses('AppModel', 'Model');
/**
 * Calificacione Model
 *
 * @property User $User
 * @property Prueba $Prueba
 */
class Calificacione extends AppModel {


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
		'Prueba' => array(
			'className' => 'Prueba',
			'foreignKey' => 'prueba_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
