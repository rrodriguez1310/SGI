<?php
App::uses('AuthComponent', 'Controller/Component');
class Cargo extends AppModel {
	
	//public $validate = array('nombre' => array('rule' => 'isUnique', 'message' => 'El nombre ya existe. Por favor, intente con otro.'));
	
	public $belongsTo = array(
        'Area' => array(
        	'className' => 'Area',
        	'foreignKey' => 'area_id'
		)
    );
}


