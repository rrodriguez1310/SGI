<?php
App::uses('AppModel', 'Model');
/**
 * RatingMinutosAcumulado Model
 *
 * @property Channels $Channels
 * @property Target $Target
 */
class RatingMinutosAcumulado extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Channels' => array(
			'className' => 'Channels',
			'foreignKey' => 'channels_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Target' => array(
			'className' => 'Target',
			'foreignKey' => 'target_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
