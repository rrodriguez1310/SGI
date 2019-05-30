<?php
App::uses('AppModel', 'Model');
/**
 * EvaluacionesObjetivo Model
 *
 * @property EvaluacionesTrabajadore $EvaluacionesTrabajadore
 * @property ObjetivosComentario $ObjetivosComentario
 * @property NivelesLogro $NivelesLogro
 * @property EvaluacionesEtapa $EvaluacionesEtapa
 * @property EvaluacionesUnidadObjetivo $EvaluacionesUnidadObjetivo
 * @property EvaluacionesAnio $EvaluacionesAnio
 */
class EvaluacionesObjetivo extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'EvaluacionesTrabajadore' => array(
			'className' => 'EvaluacionesTrabajadore',
			'foreignKey' => 'evaluaciones_trabajadore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ObjetivosComentario' => array(
			'className' => 'ObjetivosComentario',
			'foreignKey' => 'objetivos_comentario_id',
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
		'EvaluacionesEtapa' => array(
			'className' => 'EvaluacionesEtapa',
			'foreignKey' => 'evaluaciones_etapa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EvaluacionesUnidadObjetivo' => array(
			'className' => 'EvaluacionesUnidadObjetivo',
			'foreignKey' => 'evaluaciones_unidad_objetivo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EvaluacionesObjetivoEstado' => array(
			'className' => 'EvaluacionesObjetivoEstado',
			'foreignKey' => 'evaluaciones_objetivo_estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
