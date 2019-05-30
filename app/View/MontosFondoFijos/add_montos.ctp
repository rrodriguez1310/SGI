<?php echo $this->Form->create('MontosFondoFijos', array('action' => 'add_montos', 'class'=>'form-horizontal')); ?>
    <div>
        <fieldset>
            <legend>Ingreso fondo fijo</legend>
            <div class="form-group">
                <label class="col-md-4 control-label baja"><span class="aterisco">*</span>Titulo</label>
                <div class="col-md-6">
                    <?php 
                    echo $this->Form->input('titulo', 	
                    array("class"=>"col-xs-4 form-control requerido", 
                    "type"=>"text",
                    "label"=>false,
                    'placeholder'=>'Titulo',
                    "ng-model"=>"montofijo.titulo",
                    'required'=>true
                        )
                    );
                    ?>
                    <label for="titulo"></label>
                </div>
                
            </div>
            <br/>


            <div class="form-group">
                <label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Area</label>
                <div class="col-md-6">
                    <?php 
                    echo $this->Form->input('area', 
                    array("class"=>"col-xs-4 form-control requerido", 
                    "label"=>false, 
                    'type'=>'select',
                    "options"=>$dimensionUno,
                    'empty'=>'Area',
                    "ng-model"=>"montofijo.area",
                    'required'=>true
                        )
                    );
                    ?>
                </div>
                
            </div>

             <div class="form-group">
                <label class="col-md-4 control-label baja"><span class="aterisco">*</span>Moneda: </label>
                <div class="col-md-6">
                    <?php 
                        echo $this->Form->input('moneda', 
                            array("class"=>"col-xs-4 form-control requerido", 
                                "label"=>false, 
                                'type'=>'select',
                                'empty'=>'Moneda',
                                "options"=>$tipoMonedas,
                                "ng-model"=>"montofijo.moneda",
                                'required'=>true
                            )
                        );
                    ?>
                    <label for="moneda"></label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label baja"><span class="aterisco">*</span>Monto: </label>
                <div class="col-md-6">
                    <?php 
                        echo $this->Form->input('monto', 
                            array("class"=>"col-xs-4 form-control ", 
                            "label"=>false,  
                            "type"=>"text",
                            "ng-model"=>"montofijo.monto",
                            'placeholder'=>'Monto',
                            "onkeyup"=>"formatThusanNumber(this)",
                            "onchange"=>"formatThusanNumber(this)",
                            'required'=>true
                        )
                    );
                    ?>
                    <label for="monto"></label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Estado </label>
                <div class="col-md-6">
                
                        <?php 
                            
                            $options = array('1' => 'Activo', '2' => 'No activo');
                            
                            echo $this->Form->input('estado',
                                array(
                                    'label'=>false,
                                    'options' => $options, 
                                    'default' => '',
                                    'empty'=>'Estado',
                                    "class"=>"col-xs-4 form-control requerido", 
                                )
                            );
                        ?>
                    <label for="estado"></label>
                </div>
                
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label baja" ><span class="aterisco">*</span>Encargado</label>
                <div class="col-md-6">
                    <?php 
                    echo $this->Form->input('encargado', 
                    array("class"=>"col-xs-4 form-control requerido", 
                    "label"=>false, 
                    'type'=>'select',
                    'empty'=>'Encargado',
                    "options"=>$usuario,
                    "ng-model"=>"montofijo.encargado",
                    'required'=>true
                        )
                    );
                    ?>

                </div>
                
            </div>
        </fieldset>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn-block btn btn-primary btn-lg generarOrden">
                <i class="fa fa-file-text-o"></i> Generar Fondo fijo</button>
            </div>
        </div>
    </div>
</form>


<?php 
	echo $this->Html->script(array(
		'bootstrap-datepicker',
        'select2.min'
	));
?>


<script>
$("#flashMessage").addClass( "alert alert-success" );
    $("#MontosFondoFijosArea").select2({
        placeholder: "Seleccione Area",
        allowClear: true,
        width:'100%',
    });
    $("#MontosFondoFijosEncargado").select2({
        placeholder: "Seleccione Area",
        allowClear: true,
        width:'100%',
    });

      function formatThusanNumber(input){

        var num = input.value.replace(/\./g,'');
        if(!isNaN(num)){
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
            //$("#precio").val(num);
        }
        else
        { 
            alert('Solo se permiten numeros');
            input.value.replace(/[^\d\.]*/g,'');
        }
    }
</script>

