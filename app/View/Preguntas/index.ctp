<div ng-controller="Preguntas" ng-init>
  <div ng-show="preguntasList.length>0"class="panel panel-primary">

    <!-- Default panel contents -->
    <div  class="panel-heading">{{titleQuiz}}</div>
    <div class="panel-body">
      <p>{{descriptionQuiz}}
      </p>
    </div>
    <form name="form" novalidate>
      <!-- List group -->
      <ul class="list-group" ng-repeat="preguntas in preguntasRespuestas">
        <li class="list-group-item"><strong>{{$index +1}} ) . {{preguntas.pregunta}}</strong></li>
        <ul ng-repeat="respuesta in preguntas.respuesta_id">
          <li>
            <input type="radio" ng-model="formulario.respuestas[$parent.$index]" value="{{respuesta.opcion_text}}" required> {{respuesta.opcion_text}}</li>
        </ul>
      </ul>
      <div class="col-md-12">
        <button class="btn btn-primary btn-block btn-lg" ng-disabled="form.$invalid" type="button" ng-click="enviaRespuestas(formulario.respuestas)"><i class="fa fa-send"></i> Enviar</button>
      </div>
    </form>
  </div>
</div>
<?php
echo $this->Html->script(array(
'angularjs/controladores/app',
'angularjs/controladores/preguntas/preguntas',
'angularjs/servicios/preguntas/preguntas',
'angularjs/directivas/confirmacion'
));
?>
  <script>
    $('.tool').tooltip();
  </script>