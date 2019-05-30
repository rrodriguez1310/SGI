<?php
App::uses('AppModel', 'Model');
/**
 * GruposCompetencia Model
 *
 * @property TitulosCompetencia $TitulosCompetencia
 * @property CargosFamilia $CargosFamilia
 * @property Competencia $Competencia
 */
class GruposCompetencia extends AppModel {

	public $name = 'GruposCompetencia';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'TitulosCompetencia' => array(
			'className' => 'TitulosCompetencia',
			'foreignKey' => 'titulos_competencia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CargosFamilia' => array(
			'className' => 'CargosFamilia',
			'foreignKey' => 'cargos_familia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Competencia' => array(
			'className' => 'Competencia',
			'foreignKey' => 'grupos_competencia_id',
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
