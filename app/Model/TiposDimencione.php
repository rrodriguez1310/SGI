<?php
App::uses('AppModel', 'Model');
/**
 * BudgetedSubscriber Model
 *
 * @property Month $Month
 * @property Year $Year
 * @property Company $Company
 * @property Channel $Channel
 */
class TiposDimensione extends AppModel {
	
	public $belongsTo = array(
		'Dimensione' => array(
			'className' => 'Dimensione',
			'foreignKey' => 'tipos_dimensione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
}