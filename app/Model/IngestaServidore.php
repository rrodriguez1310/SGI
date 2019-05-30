<?php
App::uses('AppModel', 'Model');
/**
 * IngestaServidore Model
 *
 * @property CatalogacionRDigitale $CatalogacionRDigitale
 */
class IngestaServidore extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CatalogacionRDigitale' => array(
			'className' => 'CatalogacionRDigitale',
			'foreignKey' => 'ingesta_servidore_id',
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
