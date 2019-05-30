<?php
App::uses('AuthComponent', 'Controller/Component');
class ComprasProductosTotale extends AppModel {
	
	
	public $belongsTo = array(
		'ComprasProducto' => array(
			'className' => 'ComprasProducto', 
			'foreignKey' => 'compras_producto_id', 
			'conditions' => '', 
			'fields' => '', 
			'order' => ''
		),
		
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
}
