<?php
App::uses('AuthComponent', 'Controller/Component');
class Area extends AppModel {
	
	//public $validate = array('nombre' => array('rule' => 'isUnique', 'message' => 'El nombre ya existe. Por favor, intente con otro.'));
		
    public $belongsTo = array(
        'Gerencia' => array(
            'className' => 'Gerencia',
            'foreignKey' => 'gerencia_id'
        )
    );
}
?>

