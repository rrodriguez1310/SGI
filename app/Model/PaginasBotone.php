<?php
App::uses('AppModel', 'Model');
/**
 * PaginasBotone Model
 *
 * @property Pagina $Pagina
 */
class PaginasBotone extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Pagina' => array(
			'className' => 'Pagina',
			'foreignKey' => 'pagina_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
