<?php
App::uses('AppModel', 'Model');
/**
 * TransmisionPartido Model
 *
 * @property ProduccionPartidosEvento $ProduccionPartidosEvento
 * @property TransmisionTipoEvento $TransmisionTipoEvento
 * @property User $User
 */
class TransmisionPartido extends AppModel {


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
		'TransmisionPrincipalSenale' => array (
			'className' => 'TransmisionSenale',
			'foreignKey' => 'transmision_senales_principal_senale_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TransmisionRespaldoSenale' => array (
			'className' => 'TransmisionSenale',
			'foreignKey' => 'transmision_senales_respaldo_senale_id',
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
