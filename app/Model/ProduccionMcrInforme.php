<?php
App::uses('AppModel', 'Model');
/**
 * ProduccionMcrInforme Model
 *
 * @property User $User
 * @property ProduccionPartidosEvento $ProduccionPartidosEvento
 */
class ProduccionMcrInforme extends AppModel {

    /**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'ProduccionPartidosEvento' => array(
			'className' => 'ProduccionPartidosEvento',
			'foreignKey' => 'produccion_partidos_evento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
   
	);

}
