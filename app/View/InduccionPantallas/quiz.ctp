<div class="form-horizontal">
    <div class="container">
        <div class="col-md-12 " >
            <div class="panel panel-primary margin" >
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="panel-title text-center"><?php echo 'Quiz'; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">	
                    <div class="col-md-12">
                        <div class="panel-body">

                            <?php $numeracion =0; $arreglo = array();?>
                            <?php echo $this->Form->create('InduccionQuiz',array('class' => 'form-horizontal')); ?>
                            <fieldset>

                                <?php foreach ($preguntas as $key => $pregunta) : ?>
                                    <?php $numeracion++; ?>
                                    <div>
                                        <h4>  
                                            <?php echo $numeracion.".- ".ucfirst($pregunta['InduccionPregunta']['pregunta']); ?>
                                        </h4>
                                    </div>
                                    <br>

                                    <?php
                                                     
                                        echo $this->Form->input('etapa_id'.$key, array(
                                        'type' => 'hidden',  
                                        'value'=> $etapa_id)); 

                                        echo $this->Form->input('pregunta_id'.$key, array(
                                            'type' => 'hidden',
                                            'value'=> $pregunta['InduccionPregunta']['id']));
                                        
                                    ?>
                                    
                                    <?php foreach ($pregunta['InduccionRespuesta'] as $key2 => $respuesta) : ?>
                                        <div class='col-md-12 col-md-offset-1'>
                                            <div class="form-group">

                                                <div class="form-check">
                                                    <?php
                                                        /*respuestas activas*/
                                                        if($respuesta['induccion_estado_id'] == 1){

                                                            $options = array(
                                                                $respuesta['id'] => $respuesta['respuesta']
                                                            );
                                                            $attributes = array( 
                                                                'name'=> "data[InduccionQuiz][".$pregunta['InduccionPregunta']['pregunta']."][]",
                                                                //'name'=>$pregunta['InduccionPregunta']['pregunta'], 
                                                                'id'=>$pregunta['InduccionPregunta']['id'],
                                                                'required'
                                                            );
                                                            echo $this->Form->radio('quiz', $options, $attributes);
                                                        }
                                                    ?>
                                                </div>                                 
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                                
                                <div class="col-sm-offset-1 col-sm-8 box-footer">
                                    <a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default pull-left"><i class="fa fa-mail-reply-all"></i> Volver</a>
                                    <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-pencil"></i> Guardar</button>
                                    <?php echo $this->Form->end(); ?>
                                </div>
                            </fieldset>
              
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .error {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }
</style>