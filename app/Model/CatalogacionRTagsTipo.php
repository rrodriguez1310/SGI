<?php
App::uses('AppModel', 'Model');
/**
 * CatalogacionRTagsTipo Model
 *
 * @property CatalogacionRTag $CatalogacionRTag
 */
class CatalogacionRTagsTipo extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CatalogacionRTag' => array(
			'className' => 'CatalogacionRTag',
			'foreignKey' => 'catalogacion_r_tags_tipo_id',
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
