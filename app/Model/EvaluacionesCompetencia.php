<?php
App::uses('AppModel', 'Model');
/**
 * EvaluacionesCompetencia Model
 *
 * @property EvaluacionesTrabajadore $EvaluacionesTrabajadore
 * @property Competencia $Competencia
 * @property NivelesLogro $NivelesLogro
 */
class EvaluacionesCompetencia extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'EvaluacionesTrabajadore' => array(
			'className' => 'EvaluacionesTrabajadore',
			'foreignKey' => 'evaluaciones_trabajadore_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Competencia' => array(
			'className' => 'Competencia',
			'foreignKey' => 'competencia_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'NivelesLogro' => array(
			'className' => 'NivelesLogro',
			'foreignKey' => 'niveles_logro_id',
            'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


}
