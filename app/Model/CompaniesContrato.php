<?php
App::uses('AppModel', 'Model');
/**
 * CompaniesContrato Model
 *
 * @property Gerencia $Gerencia
 * @property CompaniesRenovacionAutomatica $CompaniesRenovacionAutomatica
 * @property CompaniesAvisoTermino $CompaniesAvisoTermino
 * @property Company $Company
 */
class CompaniesContrato extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Gerencia' => array(
			'className' => 'Gerencia',
			'foreignKey' => 'gerencia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CompaniesRenovacionAutomatica' => array(
			'className' => 'CompaniesRenovacionAutomatica',
			'foreignKey' => 'companies_renovacion_automatica_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CompaniesAvisoTermino' => array(
			'className' => 'CompaniesAvisoTermino',
			'foreignKey' => 'companies_aviso_termino_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CompanyType' => array(
			'className' => 'CompanyType',
			'foreignKey' => 'company_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
