<?php
App::uses('AppModel', 'Model');
/**
 * RecognitionProduct Model
 *
 * @property Category $Category
 * @property Statu $Statu
 */
class RecognitionProduct extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $actsAs = array(
		'Upload.Upload' => array(
			'image' => array(
				'fields' => array(
					'dir' => 'imagedir'
				),
				'thumbnailMethod' => 'php',
				'thumbnailSizes' => array(
					'vga' => '250x200',
					'thumb' => '100x40'
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
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'El producto ya existe',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'image' => array(
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
		   /* 'checkUniqueName' => array(
                'rule' => array('checkUniqueName'),
                'message' => 'La imagen ya se encuentra registrada',
                'on' => 'update'
			),*/		
		),
		/*'imagedir' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
		'points' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'quantity' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'category_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'statu_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Category' => array(
			'className' => 'RecognitionCategory',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Statu' => array(
			'className' => 'RecognitionStatus',
			'foreignKey' => 'statu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/*Verifica el estado del registro*/
	public function statu($id){
		
		$ssql = "Select statu_id from recognition_products WHERE statu_id = 1 and id= '".$id."'";
		$rs_query = $this->query($ssql);
		
		if(count($rs_query) > 0){
			return $rs_query;
		}	
	}

	/*Elimina de forma logica el registro, cambiando su estado*/
	public function deletes($id){
		
		$ssql = "UPDATE recognition_products SET statu_id = 2 WHERE id= '".$id."'";
		$rs_query = $this->query($ssql); 
		
	}

	/*Descuenta productos del stock por cada canje de puntos*/
	public function stock($param){
		$quantity = $param[1] - 1;
		$ssql = "UPDATE recognition_products SET quantity = ".$quantity." WHERE id= '".$param[0]."'";
		$rs_query = $this->query($ssql); 
		
	}
}
