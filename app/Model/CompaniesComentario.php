<?php
App::uses('AppModel', 'Model');
/**
 * CompaniesComentario Model
 *
 * @property Company $Company
 * @property User $User
 * @property ClasificacionComentario $ClasificacionComentario
 */
class CompaniesComentario extends AppModel {


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
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ClasificacionComentario' => array(
			'className' => 'ClasificacionComentario',
			'foreignKey' => 'clasificacion_comentario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
