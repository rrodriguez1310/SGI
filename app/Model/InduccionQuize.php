<?php
App::uses('AppModel', 'Model');
/**
 * InduccionQuize Model
 *
 * @property InduccionPregunta $InduccionPregunta
 * @property InduccionRespuesta $InduccionRespuesta
 * @property InduccionEtapa $InduccionEtapa
 * @property InduccionTrabajador $InduccionTrabajador
 */
class InduccionQuize extends AppModel {

	/**
 * Use table
 *
 * @var mixed False or table name
 */
public $useTable = 'induccion_quizzes';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'InduccionPregunta' => array(
			'className' => 'InduccionPregunta',
			'foreignKey' => 'induccion_pregunta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InduccionRespuesta' => array(
			'className' => 'InduccionRespuesta',
			'foreignKey' => 'induccion_respuesta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InduccionEtapa' => array(
			'className' => 'InduccionEtapa',
			'foreignKey' => 'induccion_etapa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
