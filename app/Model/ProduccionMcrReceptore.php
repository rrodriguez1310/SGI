<?php
App::uses('AppModel', 'Model');
/**
 * ProduccionMcrReceptore Model
 *
 * @property TransmisionMedioTransmisione $TransmisionMedioTransmisione
 */
class ProduccionMcrReceptore extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'TransmisionMedioTransmisione' => array(
			'className' => 'TransmisionMedioTransmisione',
			'foreignKey' => 'transmision_medio_transmisione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
