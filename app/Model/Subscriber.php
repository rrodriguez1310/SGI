<?php
App::uses('AppModel', 'Model');
/**
 * Subscriber Model
 *
 * @property Company $Company
 * @property Year $Year
 * @property Month $Month
 */
class Subscriber extends AppModel {


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
	);
}
