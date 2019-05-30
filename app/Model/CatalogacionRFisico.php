<?php
App::uses('AppModel', 'Model');
/**
 * CatalogacionRFisico Model
 *
 * @property Soporte $Soporte
 * @property Formato $Formato
 * @property Copia $Copia
 * @property CatalogacionRequerimiento $CatalogacionRequerimiento
 */
class CatalogacionRFisico extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Soporte' => array(
			'className' => 'Soporte',
			'foreignKey' => 'soporte_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Formato' => array(
			'className' => 'Formato',
			'foreignKey' => 'formato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Copia' => array(
			'className' => 'Copia',
			'foreignKey' => 'copia_id',
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
