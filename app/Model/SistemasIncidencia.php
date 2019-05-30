<?php
App::uses('AppModel', 'Model');
/**
 * SistemasIncidencia Model
 *
 * @property SistemasResponsablesIncidencia  $SistemasResponsablesIncidencia 
 * @property Area $Area
 * @property User $User
 * @property Trabajadore $Trabajadore
 * @property SistemasIncidenciasOb $SistemasIncidenciasOb
 */
class SistemasIncidencia extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SistemasResponsablesIncidencia' => array(
			'className' => 'SistemasResponsablesIncidencia',
			'foreignKey' => 'sistemas_responsables_incidencia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Area' => array(
			'className' => 'Area',
			'foreignKey' => 'area_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Trabajadore' => array(
			'className' => 'Trabajadore',
			'foreignKey' => 'trabajadore_id',
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
		'SistemasIncidenciasOb' => array(
			'className' => 'SistemasIncidenciasOb',
			'foreignKey' => 'sistemas_incidencia_id',
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
