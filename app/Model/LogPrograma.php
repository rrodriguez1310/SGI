<?php
App::uses('AppModel', 'Model');
/**
 * LogPrograma Model
 *
 * @property Programacione $Programacione
 * @property Programacione $Programacione
 */
class LogPrograma extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'Programacione' => array(
			'className' => 'Programacione',
			'foreignKey' => 'log_programa_id',
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
 /*
	public $belongsTo = array(
		'Programacione' => array(
			'className' => 'Programacione',
			'foreignKey' => 'programacione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	*/
}
