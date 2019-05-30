<?php
App::uses('AuthComponent', 'Controller/Component');
class Retiro extends AppModel {
	public $belongsTo = array('MotivoRetiro' => array('className' => 'MotivoRetiro', 'foreignKey' => 'motivo_retiro_id'), 'Trabajadore' => array('className' => 'Trabajadore', 'foreignKey' => 'trabajadore_id'));
}
?>

