<?php
App::uses('AppModel', 'Model');
/**
 * ListaCorreo Model
 *
 * @property ListaCorreosTipo $ListaCorreosTipo
 * @property Trabajadore $Trabajadore
 */
class ListaCorreo extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ListaCorreosTipo' => array(
			'className' => 'ListaCorreosTipo',
			'foreignKey' => 'lista_correos_tipo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Trabajadore' => array(
			'className' => 'Trabajadore',
			'joinTable' => 'trabajadores_lista_correos',
			'foreignKey' => 'lista_correo_id',
			'associationForeignKey' => 'trabajadore_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
