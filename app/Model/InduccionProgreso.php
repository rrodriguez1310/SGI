<?php
App::uses('AppModel', 'Model');
/**
 * InduccionProgreso Model
 *
 * @property Trabajadore $Trabajadore
 * @property Etapa $Etapa
 */
class InduccionProgreso extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'induccion_progresos';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Trabajadore' => array(
			'className' => 'Trabajadore',
			'foreignKey' => 'trabajadore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Etapa' => array(
			'className' => 'InduccionEtapa',
			'foreignKey' => 'induccion_etapa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contenido' => array(
			'className' => 'InduccionContenido',
			'foreignKey' => 'induccion_contenido_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}