<?php
App::uses('AppModel', 'Model');
/**
 * ObjetivosComentario Model
 *
 * @property EvaluacionesObjetivo $EvaluacionesObjetivo
 */
class ObjetivosComentario extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'EvaluacionesObjetivo' => array(
			'className' => 'EvaluacionesObjetivo',
			'foreignKey' => 'objetivos_comentario_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
