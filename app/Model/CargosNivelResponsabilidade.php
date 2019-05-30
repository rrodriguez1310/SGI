<?php
App::uses('AppModel', 'Model');
/**
 * CargosNivelResponsabilidade Model
 *
 * @property Cargo $Cargo
 */
class CargosNivelResponsabilidade extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Cargo' => array(
			'className' => 'Cargo',
			'foreignKey' => 'cargos_nivel_responsabilidade_id',
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
