<?php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {
	public $belongsTo = array('Role' => array('className' => 'Role', 'foreignKey' => 'role_id', 'conditions' => '', 'fields' => '', 'order' => ''), 'Trabajadore' => array('className' => 'Trabajadore', 'foreignKey' => 'trabajadore_id'));

	public $validate = array('nombre' => array('rule' => 'isUnique', 'message' => 'El nombre ya existe. Por favor, intente con otro.'), 'trabajadore_id'=> array('rule' => 'isUnique', 'message' => 'El trabajador ya ha sido asociado a otro usuario.'));
}
?>

