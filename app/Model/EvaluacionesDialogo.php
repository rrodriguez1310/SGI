<?php
App::uses('AppModel', 'Model');
/**
 * EvaluacionesDialogo Model
 *
 * @property EvaluacionesTrabajadore $EvaluacionesTrabajadore
 * @property DialogosComentario $DialogosComentario
 */
class EvaluacionesDialogo extends AppModel {


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
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DialogosComentario' => array(
			'className' => 'DialogosComentario',
			'foreignKey' => 'dialogos_comentario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
