<?php
App::uses('AppModel', 'Model');
/**
 * Documento Model
 *
 * @property Trabajadore $Trabajadore
 * @property TipoDocumento $TipoDocumento
 */
class Documento extends AppModel {


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
		'TiposDocumento' => array(
			'className' => 'TiposDocumento',
			'foreignKey' => 'tipos_documento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
