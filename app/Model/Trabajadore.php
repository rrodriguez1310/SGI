<?php
App::uses('AppModel', 'Model');
/**
 * Trabajadore Model
 *
 * @property Comuna $Comuna
 * @property Cargo $Cargo
 * @property Nacionalidade $Nacionalidade
 * @property Localizacione $Localizacione
 * @property SistemaPrevisione $SistemaPrevisione
 * @property SistemaPensione $SistemaPensione
 * @property Horario $Horario
 * @property TipoContrato $TipoContrato
 * @property Jefe $Jefe
 * @property NivelEducacion $NivelEducacion
 * @property Dimensione $Dimensione
 * @property Documento $Documento
 * @property Jefe $Jefe
 * @property Retiro $Retiro
 * @property User $User
 * @property CuentasCorriente $CuentasCorriente
 * @property ListaCorreo $ListaCorreo
 */
class Trabajadore extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Comuna' => array(
			'className' => 'Comuna',
			'foreignKey' => 'comuna_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cargo' => array(
			'className' => 'Cargo',
			'foreignKey' => 'cargo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Nacionalidade' => array(
			'className' => 'Nacionalidade',
			'foreignKey' => 'nacionalidade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Localizacione' => array(
			'className' => 'Localizacione',
			'foreignKey' => 'localizacione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SistemaPrevisione' => array(
			'className' => 'SistemaPrevisione',
			'foreignKey' => 'sistema_previsione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SistemaPensione' => array(
			'className' => 'SistemaPensione',
			'foreignKey' => 'sistema_pensione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Horario' => array(
			'className' => 'Horario',
			'foreignKey' => 'horario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TipoContrato' => array(
			'className' => 'TipoContrato',
			'foreignKey' => 'tipo_contrato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Jefe' => array(
			'className' => 'Jefe',
			'foreignKey' => 'jefe_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
		'NivelEducacion' => array(
			'className' => 'NivelEducacion',
			'foreignKey' => 'nivel_educacion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Dimensione' => array(
			'className' => 'Dimensione',
			'foreignKey' => 'dimensione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EstadosCivile' => array(
			'className' => 'EstadosCivile',
			'foreignKey' => 'estados_civile_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Documento' => array(
			'className' => 'Documento',
			'foreignKey' => 'trabajadore_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		/*'Jefe' => array(
			'className' => 'Jefe',
			'foreignKey' => 'trabajadore_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),*/
		'Retiro' => array(
			'className' => 'Retiro',
			'foreignKey' => 'trabajadore_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		/*'User' => array(
			'className' => 'User',
			'foreignKey' => 'trabajadore_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)*/
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'CuentasCorriente' => array(
			'className' => 'CuentasCorriente',
			'joinTable' => 'trabajadores_cuentas_corrientes',
			'foreignKey' => 'trabajadore_id',
			'associationForeignKey' => 'cuentas_corriente_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		/*'ListaCorreo' => array(
			'className' => 'ListaCorreo',
			'joinTable' => 'trabajadores_lista_correos',
			'foreignKey' => 'trabajadore_id',
			'associationForeignKey' => 'lista_correo_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)*/
	);

}
