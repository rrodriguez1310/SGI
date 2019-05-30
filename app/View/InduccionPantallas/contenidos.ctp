<div ng-controller="induccionPantallasContenidos" ng-init="idTrabajador=<?php echo $idTrabajador; ?>" ng-cloak>
	
	<div class=" col-sm-12">
		<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class=" btn btn-primary pull-left inicio"><i class="fa fa-mail-reply-all"></i> Volver al inicio</a><br><br>
	</div>

	<!--div class="container">
		<div class="row">
			leccion: {{ leccion_id }} 
			contenido: {{ contenido_id }} 
			quiz: {{ quiz }} 
		</div>
	</div-->

	<div class="container">
		<div class="row text-center">
			<h2>{{myObj.titulo}}</h2>
		</div>
	</div>

	<div class="container" id="martin">
		<div class="row">
			<div  class="visor" ng-bind-html="myObj.descripcion | html" ng-style="myObj">{{myObj.descripcion}}</div>
		</div>
	</div>

	<div class="col-sm-offset-1 col-sm-10 box-footer margen">
		<button ng-hide="siguiente == 0" ng-click="myFunc(count+1)" class="left volver btn btn-primary pull-right">Siguiente <i class="glyphicon glyphicon-chevron-right"></i></button>
		<a ng-show="quiz == 1" href="<?php echo $this->Html->url(array("controller"=>"induccionQuizzes", "action"=>"quiz"))?>/{{leccion_id}}" class="left volver btn btn-primary pull-right"> Actividad de Aprendizaje</a>
		<button ng-hide="anterior == 0" ng-click="myFunc2(count-1)" class="right volver btn btn-primary pull-left"> <i class="glyphicon glyphicon-chevron-left">Anterior </i></button>
		<br><br>
	</div>

	<!--div>
		contador: {{count}}</div>
	</div-->
</div>


<script>/*
	$(document).ready(function(){              
        $.ajax({
            type: "GET",
            url: 'http://localhost/sgi-v3/Servicios/serviceDetectSession',            
            dataType : 'json',
            success: function(data)
            {   alert("sesion "+data)
				console.log(JSON.stringify(data))
				if(data == 0){
					setSession();
				}
			}
        });
	});
	
	function setSession(){
		if (Object.keys(localStorage).length !== 0) {
			$.ajax({
				type: "POST",
				url: 'http://localhost/sgi-v3/Servicios/serviceSetSession',            
				dataType : 'json',
				data: $.param(localStorage),
				success: function(data)
				{   
					alert("setContenido "+ data)
				}
			}); 
		}
	}*/
</script>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/induccion/induccionPantallasService',
		'angularjs/controladores/induccion/induccionPantallasContenidos',
		'angularjs/filtros/filtros',
		'angularjs/directivas/confirmacion'
	));
?>


<style>
	
.visor { widht: 150px !important; overflow: auto }

.margen{
	margin-bottom: 10px;
}

.lamina{
	margin-top: 10px;
	height: 600px;
	width: 1120px;
	color": white;
	text-align: center;
	background-color: coral;
	padding: 25px;
}

.inicio{
    padding: 10px;
    height: 37px;
    margin-top: 10px;
}
</style>

