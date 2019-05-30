<?php
App::uses('AuthComponent', 'Controller/Component');
class PaginasRole extends AppModel {
	public $belongsTo = array(
		'Role' => array(
			'className' => 'Role', 
			'foreignKey' => 'role_id', 
			'dependent'=> false,
			'conditions' => '', 
			'fields' => '', 
			'order' => ''
		), 
		'Pagina' => array(
			'className' => 'Pagina', 
			'foreignKey' => 'pagina_id', 
			'dependent'=> false,
			'conditions' => '', 
			'fields' => '', 
			'order' => ''
		));
}
?>

