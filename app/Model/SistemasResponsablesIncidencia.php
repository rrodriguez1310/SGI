<?php
App::uses('AppModel', 'Model');
/**
 * SistemasResponsablesIncidencia Model
 *
 * @property User $User
 * @property Gerencia $Gerencia
 * @property SistemasIncidencia $SistemasIncidencia
 */
class SistemasResponsablesIncidencia extends AppModel {


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
		'Gerencia' => array(
			'className' => 'Gerencia',
			'foreignKey' => 'gerencia_id',
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
		'SistemasIncidencia' => array(
			'className' => 'SistemasIncidencia',
			'foreignKey' => 'sistemas_responsables_incidencia_id',
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
