<?php
App::uses('AppModel', 'Model');
/**
 * CatalogacionPartidosMedio Model
 *
 * @property CatalogacionPartido $CatalogacionPartido
 * @property Formato $Formato
 * @property Bloque $Bloque
 * @property Soporte $Soporte
 * @property Almacenamiento $Almacenamiento
 * @property Copia $Copia
 * @property User $User
 */
class CatalogacionPartidosMedio extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CatalogacionPartido' => array(
			'className' => 'CatalogacionPartido',
			'foreignKey' => 'catalogacion_partido_id',
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
		'Bloque' => array(
			'className' => 'Bloque',
			'foreignKey' => 'bloque_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Soporte' => array(
			'className' => 'Soporte',
			'foreignKey' => 'soporte_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Almacenamiento' => array(
			'className' => 'Almacenamiento',
			'foreignKey' => 'almacenamiento_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
