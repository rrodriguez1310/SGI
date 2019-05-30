<?php
App::uses('AppModel', 'Model');
/**
 * TipoContratosPlantilla Model
 *
 * @property TipoContrato $TipoContrato
 * @property TiposDocumento $TiposDocumento
 */
class TipoContratosPlantilla extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'TipoContrato' => array(
			'className' => 'TipoContrato',
			'foreignKey' => 'tipo_contrato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TiposDocumento' => array(
			'className' => 'TiposDocumento',
			'foreignKey' => 'tipos_documento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
