<?php
App::uses('AppModel', 'Model');
/**
 * Archivo Model
 *
 * @property CategoriasArchivo $CategoriasArchivo
 */
class Archivo extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CategoriasArchivo' => array(
			'className' => 'CategoriasArchivo',
			'foreignKey' => 'categorias_archivo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
