<?php
App::uses('AppModel', 'Model');
/**
 * ListaCorreosTipo Model
 *
 * @property ListaCorreo $ListaCorreo
 */
class ListaCorreosTipo extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ListaCorreo' => array(
			'className' => 'ListaCorreo',
			'foreignKey' => 'lista_correos_tipo_id',
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
