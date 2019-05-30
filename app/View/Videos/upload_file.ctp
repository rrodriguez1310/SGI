<div  ng-controller="VideosPath">
  <h4>Upload on file select</h4>

  <button ngf-select="uploadFiles($files, $invalidFiles)" ng-model="foto.archivo"  multiple
          accept="image/*"  >
      Select Files</button>
  <br><br>
  Files:
  <ul>
    <li ng-repeat="f in files" style="font:smaller">{{f.name}} {{f.$errorParam}}
      <span class="progress" ng-show="f.progress >= 0">
        <div style="width:{{f.progress}}%"  
            ng-bind="f.progress + '%'"></div>
      </span>
    </li>
    <li ng-repeat="f in errFiles" style="font:smaller">{{f.name}} {{f.$error}} {{f.$errorParam}}
    </li> 
  </ul>
<h4 class="text-center">Documentos</h4>
													<div class="row">
														<div class="col-md-12">
															<div trabajadores-lista-documentos-directive>
																
															</div trabajadores-lista-documentos-directive>
															<div>
																<br>	
																<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ng-model="grid" class="grid"></div>
															</div>
														</div>
													</div>
												</div>
</div>

<?php
echo $this->Html->script(array(
'angularjs/controladores/app',
'angularjs/servicios/videos/videos',
'angularjs/controladores/videos/videos'
));
?>