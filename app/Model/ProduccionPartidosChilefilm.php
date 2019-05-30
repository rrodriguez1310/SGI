<?php
App::uses('AppModel', 'Model');
/**
 * ProduccionPartidosChilefilm Model
 *
 * @property ProduccionPartido $ProduccionPartido
 */
class ProduccionPartidosChilefilm extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ProduccionPartidosEvento' => array(
			'className' => 'ProduccionPartidosEvento',
			'foreignKey' => 'produccion_partidos_evento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
