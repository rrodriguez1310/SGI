<?php
App::uses('AppModel', 'Model');
/**
 * CodigosPresupuesto Model
 *
 * @property Year $Year
 */
class CodigosPresupuesto extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Year' => array(
			'className' => 'Year',
			'foreignKey' => 'year_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
