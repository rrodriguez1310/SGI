<?php
App::uses('AppModel', 'Model');
/**
 * Programacione Model
 *
 * @property LogPrograma $LogPrograma
 */
class Programacione extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'LogPrograma' => array(
			'className' => 'LogPrograma',
			'foreignKey' => 'log_programa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
