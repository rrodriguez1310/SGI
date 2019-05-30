<?php
App::uses('AppModel', 'Model');
/**
 * TransmisionSenale Model
 *
 * @property TransmisionMedioTransmisione $TransmisionMedioTransmisione
 */
class TransmisionSenale extends AppModel {


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
