<?php
App::uses('AppModel', 'Model');
/**
 * ProduccionPartidosOpta Model
 *
 * @property ProduccionPartidosEvento $ProduccionPartidosEvento
 */
class ProduccionPartidosOpta extends AppModel {


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
