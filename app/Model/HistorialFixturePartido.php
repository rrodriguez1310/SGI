<?php
App::uses('AppModel', 'Model');
/**
 * HistorialFixturePartido Model
 *
 * @property ProduccionPartidosEvento $ProduccionPartidosEvento
 * @property User $User
 */
class HistorialFixturePartido extends AppModel {


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
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
