<?php
App::uses('AppModel', 'Model');
/**
 * CatalogacionRTipo Model
 *
 * @property CatalogacionRequerimiento $CatalogacionRequerimiento
 */
class CatalogacionRTipo extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CatalogacionRequerimiento' => array(
			'className' => 'CatalogacionRequerimiento',
			'foreignKey' => 'catalogacion_r_tipo_id',
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
