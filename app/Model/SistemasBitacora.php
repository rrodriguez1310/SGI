<?php
App::uses('AppModel', 'Model');
/**
 * SistemasBitacora Model
 *
 * @property User $User
 * @property SistemasResponsable $SistemasResponsable
 * @property Area $Area
 * @property Trabajadore $Trabajadore
 * @property SistemasBitacorasOb $SistemasBitacorasOb
 */
class SistemasBitacora extends AppModel {


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
		'SistemasResponsable' => array(
			'className' => 'SistemasResponsable',
			'foreignKey' => 'sistemas_responsable_id',
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
		'SistemasBitacorasOb' => array(
			'className' => 'SistemasBitacorasOb',
			'foreignKey' => 'sistemas_bitacora_id',
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
