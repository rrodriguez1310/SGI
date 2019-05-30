<?php
App::uses('AuthComponent', 'Controller/Component');
class RatingProgramacione extends AppModel {
	
	public $hasMany = array(
        'RatingProgramacionesDetalle' => array(
            'className' => 'RatingProgramacionesDetalle'
        )
    );

}
?>