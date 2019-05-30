<?php
App::uses('AppModel', 'Model');
/**
 * CatalogacionPartido Model
 *
 * @property Campeonato $Campeonato
 * @property User $User
 */
class CatalogacionPartido extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Campeonato' => array(
			'className' => 'Campeonato',
			'foreignKey' => 'campeonato_id',
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
	public $hasMany = array("CatalogacionPartidosMedio");
}
