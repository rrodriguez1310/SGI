<?php
App::uses('AppModel', 'Model');
/**
 * Estadio Model
 *
 * @property LocaliaEquipo $LocaliaEquipo
 * @property Regione $Regione
 */
class Estadio extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		/*'LocaliaEquipo' => array(
			'className' => 'LocaliaEquipo',
			'foreignKey' => 'localia_equipo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)*/
	);
}
