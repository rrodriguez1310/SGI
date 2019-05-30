<?php
App::uses('AppModel', 'Model');
/**
 * ClasificacionComentario Model
 *
 * @property CompaniesComentario $CompaniesComentario
 */
class ClasificacionComentario extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CompaniesComentario' => array(
			'className' => 'CompaniesComentario',
			'foreignKey' => 'clasificacion_comentario_id',
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
