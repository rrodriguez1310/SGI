<?php
App::uses('AppModel', 'Model');
/**
 * Company Model
 *
 * @property CompanyType $CompanyType
 * @property Paise $Paise
 */
class Company extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CompanyType' => array(
			'className' => 'CompanyType',
			'foreignKey' => 'company_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Paise' => array(
			'className' => 'Paise',
			'foreignKey' => 'paise_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	//public $validate = array('rut' => array('rule' => 'isUnique', 'message' => 'El rut ingresado ya existe. Por favor, intente con otro.'));
}
