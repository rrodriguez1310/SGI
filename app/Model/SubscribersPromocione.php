<?php
App::uses('AppModel', 'Model');
/**
 * SubscribersPromocione Model
 *
 * @property Company $Company
 * @property Year $Year
 * @property Month $Month
 * @property Channel $Channel
 * @property Link $Link
 * @property Signal $Signal
 * @property Payment $Payment
 * @property Promocione $Promocione
 */
class SubscribersPromocione extends AppModel {


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
		'Year' => array(
			'className' => 'Year',
			'foreignKey' => 'year_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Month' => array(
			'className' => 'Month',
			'foreignKey' => 'month_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Channel' => array(
			'className' => 'Channel',
			'foreignKey' => 'channel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Link' => array(
			'className' => 'Link',
			'foreignKey' => 'link_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Signal' => array(
			'className' => 'Signal',
			'foreignKey' => 'signal_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Payment' => array(
			'className' => 'Payment',
			'foreignKey' => 'payment_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Promocione' => array(
			'className' => 'Promocione',
			'foreignKey' => 'promocione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
