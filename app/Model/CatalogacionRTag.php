<?php
App::uses('AppModel', 'Model');
/**
 * CatalogacionRTag Model
 *
 * @property CatalogacionRequerimiento $CatalogacionRequerimiento
 */
class CatalogacionRTag extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CatalogacionRequerimiento' => array(
			'className' => 'CatalogacionRequerimiento',
			'foreignKey' => 'catalogacion_requerimiento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
