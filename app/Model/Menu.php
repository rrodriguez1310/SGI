<?php
App::uses('AuthComponent', 'Controller/Component');
class Menu extends AppModel {
	
	public $validate = array('nombre' => array('rule' => 'isUnique', 'message' => 'El nombre ya existe. Por favor, intente con otro.'));
}
?>

