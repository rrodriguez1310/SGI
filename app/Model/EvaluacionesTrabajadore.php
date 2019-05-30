<?php
App::uses('AppModel', 'Model');

/**
 * EvaluacionesTrabajadore Model
 *
 * @property Trabajadore $Trabajadore
 * @property EvaluacionesEstado $EvaluacionesEstado
 * @property NivelesLogro $NivelesLogro
 * @property EvaluacionesCompetencia $EvaluacionesCompetencia
 * @property EvaluacionesCompetenciasGenerale $EvaluacionesCompetenciasGenerale
 * @property EvaluacionesDialogo $EvaluacionesDialogo
 * @property EvaluacionesObjetivo $EvaluacionesObjetivo
 */
class EvaluacionesTrabajadore extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Trabajadore' => array(
			'className' => 'Trabajadore',
			'foreignKey' => 'trabajadore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EvaluacionesEstado' => array(
			'className' => 'EvaluacionesEstado',
			'foreignKey' => 'evaluaciones_estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'NivelesLogro' => array(
			'className' => 'NivelesLogro',
			'foreignKey' => 'niveles_logro_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EvaluacionesAnio' => array(
			'className' => 'EvaluacionesAnio',
			'foreignKey' => 'evaluaciones_anio_id',
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
		'Gerencia' => array(
			'className' => 'Gerencia',
			'foreignKey' => 'gerencia_id',
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
		'EvaluacionesCompetencia' => array(
			'className' => 'EvaluacionesCompetencia',
			'foreignKey' => 'evaluaciones_trabajadore_id',
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
		'EvaluacionesCompetenciasGenerale' => array(
			'className' => 'EvaluacionesCompetenciasGenerale',
			'foreignKey' => 'evaluaciones_trabajadore_id',
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
		'EvaluacionesDialogo' => array(
			'className' => 'EvaluacionesDialogo',
			'foreignKey' => 'evaluaciones_trabajadore_id',
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
		'EvaluacionesObjetivo' => array(
			'className' => 'EvaluacionesObjetivo',
			'foreignKey' => 'evaluaciones_trabajadore_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

 /*   public $hasAndBelongsToMany = array(
        'EvaluacionesCompetencia' =>
            array(
                'className' => 'EvaluacionesCompetencia',
                'joinTable' => 'competencias',
                'foreignKey' => 'id',
                'associationForeignKey' => 'id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'evaluaciones_trabajadores'
            )
    );*/

}
