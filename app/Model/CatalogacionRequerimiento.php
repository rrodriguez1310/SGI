<?php
App::uses('AppModel', 'Model');
/**
 * CatalogacionRequerimiento Model
 *
 * @property CatalogacionRequerimientosFisico $CatalogacionRequerimientosFisico
 * @property CatalogacionRequerimientosDigitale $CatalogacionRequerimientosDigitale
 * @property User $User
 * @property CatalogacionRequerimientosTipo $CatalogacionRequerimientosTipo
 * @property CatalogacionRequerimientosDetalle $CatalogacionRequerimientosDetalle
 */
class CatalogacionRequerimiento extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'CatalogacionRFisico' => array(
			'className' => 'CatalogacionRFisico',
			'foreignKey' => 'catalogacion_requerimiento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CatalogacionRDigitale' => array(
			'className' => 'CatalogacionRDigitale',
			'foreignKey' => 'catalogacion_requerimiento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

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
		'CatalogacionRTipo' => array(
			'className' => 'CatalogacionRTipo',
			'foreignKey' => 'catalogacion_r_tipo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CatalogacionRResponsable' => array(
			'className' => 'CatalogacionRResponsable',
			'foreignKey' => 'catalogacion_r_responsable_id',
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
		'CatalogacionRTag' => array(
			'className' => 'CatalogacionRTag',
			'foreignKey' => 'catalogacion_requerimiento_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CatalogacionRIngesta' => array(
			'className' => 'CatalogacionRIngesta',
			'foreignKey' => 'catalogacion_requerimiento_id',
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
