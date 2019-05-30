<?php
App::uses('AppModel', 'Model');
/**
 * InduccionContenido Model
 *
 * @property InduccionEtapa $InduccionEtapa
 * @property InduccionEstado $InduccionEstado
 */
class InduccionContenido extends AppModel {


/**
 * Display field
 *
 * @var string
 */
public $displayField = 'titulo';

public $actsAs = array(
	'Upload.Upload' => array(
		'image' => array(
			'fields' => array(
				'dir' => 'imagedir'
			),
			'thumbnailMethod' => 'php',
			'thumbnailSizes' => array(
				'vga' => '250x250',
				'thumb' => '50x25'
			),
			'deleteOnUpdate' => true,
			'deleteFolderOnDelete' => true
		)
	)
);

/**
* Validation rules
*
* @var array
*/
public $validate = array(
	'titulo' => array(
		'notEmpty' => array(
			'rule' => array('notEmpty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	),
	'descripcion' => array(
		'notEmpty' => array(
			'rule' => array('notEmpty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	),
	'peso' => array(
		'numeric' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'rule' => array('numeric'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	),
	'etapa_id' => array(
		'numeric' => array(
			'rule' => array('numeric'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
		'notEmpty' => array(
			'rule' => array('notEmpty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	),
	'estado_id' => array(
		'numeric' => array(
			'rule' => array('numeric'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
		'notEmpty' => array(
			'rule' => array('notEmpty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	),
	/*'image' => array(
		'uploadError' => array( 
			'rule' => 'uploadError',
			'message' => 'Algo anda mal, intente nuevamente',
			'on' => 'create'
		),
		'isUnderPhpSizeLimit' => array(
			'rule' => 'isUnderPhpSizeLimit',
			'message' => 'Archivo excede el límite de tamaño de archivo de subida'
		),
		'isValidMimeType' => array(
			'rule' => array('isValidMimeType', array('image/jpeg', 'image/png'), false),
			'message' => 'La imagen no es jpg ni png',
		),
		'isBelowMaxSize' => array(
			'rule' => array('isBelowMaxSize', 1048576),
			'message' => 'El tamaño de imagen es demasiado grande'
		),
		'isValidExtension' => array(
			'rule' => array('isValidExtension', array('jpeg', 'jpg', 'png'), false),
			'message' => 'La imagen no tiene la extension jpg o png'
		),
	)*/
);

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'InduccionEtapa' => array(
			'className' => 'InduccionEtapa',
			'foreignKey' => 'induccion_etapa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InduccionEstado' => array(
			'className' => 'InduccionEstado',
			'foreignKey' => 'induccion_estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
