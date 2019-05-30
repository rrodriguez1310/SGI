<?php
App::uses('AppModel', 'Model');
/**
 * ProduccionPartido Model
 *
 */
class ProduccionPartido extends AppModel {
	public $belongsTo = array(
		'ProduccionPartidosEvento' => array(
			'className' => 'ProduccionPartidosEvento',
			'foreignKey' => 'produccion_partidos_evento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProduccionTerno' => array(
			'className' => 'ProduccionPartidosVestuario',
			'foreignKey' => 'terno_vestuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProduccionCamisa' => array(
			'className' => 'ProduccionPartidosVestuario',
			'foreignKey' => 'camisa_vestuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProduccionPanuelo' => array(
			'className' => 'ProduccionPartidosVestuario',
			'foreignKey' => 'panuelo_vestuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProduccionCorbata' => array(
			'className' => 'ProduccionPartidosVestuario',
			'foreignKey' => 'corbata_vestuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
}
