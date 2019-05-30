<?php
App::uses('AppModel', 'Model');
/**
 * SistemasIncidenciasOb Model
 *
 * @property User $User
 * @property SistemasIncidencia $SistemasIncidencia
 */
class SistemasIncidenciasOb extends AppModel {


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
		'SistemasIncidencia' => array(
			'className' => 'SistemasIncidencia',
			'foreignKey' => 'sistemas_incidencia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
