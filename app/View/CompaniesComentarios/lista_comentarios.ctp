<?php 
	echo $this->Html->css(array('timeline'));	

	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/comentarios_empresas'
	));	
?>
<div ng-controller="ComentariosEmpresas"> 	
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="comentarios">
	    <ul class="timeline">
	        <li ng-repeat="comentario in ComentariosEmpresas">
	          <div class="timeline-badge">
	          	<img id="fotoUsuario" class="img-circle" style="height:50px;width:50px;" src="{{comentario.FotoUsuario}}" alt="usr">
	          </div>
	          <div class="timeline-panel">	   
				<div class="timeline-heading">
	          		<small class="text-info">{{comentario.NombreUsuario}}&nbsp;{{comentario.Apellido}}&nbsp;&nbsp;
	          		<button class="btn btn-xs clasificacion" ng-class="{{comentario.Clasificacion=='Comentario'}}? 'btn-primary':({{comentario.Clasificacion=='Reclamo'}}?'btn-danger':'btn-success')" type="button">{{comentario.Clasificacion}}</button> 
	          		</small>
				</div>
				<div class="timeline-body">
	              <p style="margin-top: 5px;margin-bottom:5px;">{{comentario.Comentario}}</p>
	            </div>  
	            <small class="text-muted"><i class="glyphicon glyphicon-time"></i> {{comentario.Fecha}}</small> 
	          </div>
	        </li>
	    </ul>
	</div>    
</div>

