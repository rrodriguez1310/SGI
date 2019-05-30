<?php
App::uses('AppModel', 'Model');
/**
 * CatalogacionRDigitale Model
 *
 * @property IngestaServidore $IngestaServidore
 * @property CatalogacionRequerimiento $CatalogacionRequerimiento
 */
class CatalogacionRDigitale extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'IngestaServidore' => array(
			'className' => 'IngestaServidore',
			'foreignKey' => 'ingesta_servidore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CatalogacionRequerimiento' => array(
			'className' => 'CatalogacionRequerimiento',
			'foreignKey' => 'catalogacion_requerimiento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
