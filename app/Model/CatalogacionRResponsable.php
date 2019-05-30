<?php
App::uses('AppModel', 'Model');
/**
 * CatalogacionRResponsable Model
 *
 * @property User $User
 * @property CatalogacionRequerimiento $CatalogacionRequerimiento
 */
class CatalogacionRResponsable extends AppModel {


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
	public $hasOne = array(
		'CatalogacionRequerimiento' => array(
			'className' => 'CatalogacionRequerimiento',
			'foreignKey' => 'catalogacion_r_responsable_id',
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
