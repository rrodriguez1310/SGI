<?php
App::uses('AppModel', 'Model');
/**
 * Formato Model
 *
 * @property CatalogacionPartidosMedio $CatalogacionPartidosMedio
 */
class Formato extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CatalogacionPartidosMedio' => array(
			'className' => 'CatalogacionPartidosMedio',
			'foreignKey' => 'formato_id',
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
