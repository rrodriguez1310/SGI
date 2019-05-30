<?php
App::uses('AuthComponent', 'Controller/Component');
class Pagina extends AppModel {

	public $belongsTo = array(
		'Menu' => array(
			'className' => 'Menu', 
				'foreignKey' => 'menu_id', 
			'conditions' => '', 
			'fields' => '', 
			'order' => ''
		)
	);

	public $hasMany = array(
		'PaginasRole' => array(
			'className' => 'PaginasRole',
			'foreignKey' => 'role_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		), 

	);
	//public $validate = array('nombre' => array('rule' => 'isUnique', 'message' => 'El nombre ya existe. Por favor, intente con otro.'));
	public function beforeSave($options = array())
	{
		$pagina="";
		if(!isset($this->data["Pagina"]["id"]))
		{
			$pagina = $this->find('all', array('conditions'=>array('Pagina.menu_id'=> $this->data["Pagina"]["menu_id"], 'Pagina.controlador'=> $this->data["Pagina"]["controlador"], 'Pagina.accion'=> $this->data["Pagina"]["accion"])));
			if(empty($pagina))
			{
				return true;
			}else
				{
					return false;
				}
		}else
		{
			return true;		
		}
	}
}
