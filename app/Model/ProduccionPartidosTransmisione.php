<?php
App::uses('AppModel', 'Model');
/**
 * ProduccionPartidosTransmisione Model
 *
 * @property ProduccionPartidoEvento $ProduccionPartidoEvento
 */
class ProduccionPartidosTransmisione extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'TipoTransmisione' => array(
			'className' => 'TipoTransmisione',
			'foreignKey' => 'tipo_transmisione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TransmisionesMovile' => array(
			'className' => 'TransmisionesMovile',
			'foreignKey' => 'transmisiones_movile_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'NumeroPartido' => array(
			'className' => 'NumeroPartido',
			'foreignKey' => 'numero_partido_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
