<?php
App::uses('AppModel', 'Model');
/**
 * RecognitionStatus Model
 *
 */
class RecognitionStatus extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'recognition_status';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	/*public $hasMany = array(
		'RecognitionCategory' => array(
			'className' => 'RecognitionCategory',
			'foreignKey' => 'statu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);*/

}
