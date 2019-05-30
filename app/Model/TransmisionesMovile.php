<?php
App::uses('AppModel', 'Model');
/**
 * TransmisionesMovile Model
 *
 * @property Company $Company
 * @property ProduccionPartidosTransmisione $ProduccionPartidosTransmisione
 */
class TransmisionesMovile extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ProduccionPartidosTransmisione' => array(
			'className' => 'ProduccionPartidosTransmisione',
			'foreignKey' => 'transmisiones_movile_id',
			'dependent' => false,
		)
	);

}
