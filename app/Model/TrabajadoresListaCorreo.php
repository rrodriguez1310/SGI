<?php
App::uses('AppModel', 'Model');
/**
 * TrabajadoresListaCorreo Model
 *
 * @property Trabajadore $Trabajadore
 * @property ListaCorreo $ListaCorreo
 */
class TrabajadoresListaCorreo extends AppModel {


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
		'ListaCorreo' => array(
			'className' => 'ListaCorreo',
			'foreignKey' => 'lista_correo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
