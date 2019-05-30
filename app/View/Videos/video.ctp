<div ng-controller="VideosPath">
  <p ng-bind-html="cargador" ng-show="loader"></p>
  <div>
    <center ng-show="path">
      <h2 class="text-center">{{title}}</h2>
      <iframe  frameBorder="0" src="{{path}}" width="980" height="614" scrolling="no"></iframe>
      <div>
        <button ng-disabled="path==path2[0]" class="btn btn-primary" id="butonPrevious" ng-click="previousVideo()"><i class="glyphicon glyphicon-chevron-left"></i> Anterior</button>
        <button ng-show="pathValidate==false" ng-disabled=" path == path2[4] || path == path2[6] " class="btn btn-primary" id="butonNext" ng-click="nextVideo()"><i class="glyphicon glyphicon-chevron-right"></i> Siguiente</button>
        <button ng-show="pathValidate" ng-disabled=" path == path2[6] || path == path2[7]" class="btn btn-primary" id="butonNext2" ng-click="nextVideo2()"><i class="glyphicon glyphicon-chevron-right"></i> Siguiente</button>
        <button ng-show="textButton" class="btn btn-primary" id="butonTest" ng-click="abrirTest(path)">{{textButton}}</button>
      </div>
    </center>
    <center ng-show="validate">
        <button ng-show="pathEstado!=3 && path==null" class="btn btn-primary" id="butonPrevious" ng-click="repetir()">Ver Lecciones</button>
        <button ng-show="pathEstado!=3 && path==null" class="btn btn-primary" id="buton" ng-click="abrirTest(path)">Evaluación Final</button>
        <h2 ng-show="pathEstado==3">¡Felicitaciones!</h2>
        <button ng-show="pathEstado==3 " class="btn btn-primary" id="butonVolver" ng-click="repetir()">Comenzar nuevamente</button>
    </center>

  </div>
</div>

<?php
echo $this->Html->script(array(
'angularjs/controladores/app',
'angularjs/servicios/videos/videos',
'angularjs/controladores/videos/videos'
));
?>