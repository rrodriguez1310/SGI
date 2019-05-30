<div ng-controller="induccionPantallasController" ng-init="idTrabajador=<?php echo $idTrabajador; ?>" ng-cloak>

    <div class="text-center">
        <h2>Programa de Inducción Corporativa CDF.</h2>
        <br><br>
    </div>

    <div ng-repeat="items in records">
        <div class="main-timeline" ng-if="($index + 1) % 2 == 1">
            <div class="timeline">
                <div class="timeline-icon"><i class="fa fa-futbol-o fa-2x"></i></div>
                <div class="timeline-content panel panel-primary" >
                    <div ng-class="{'isDisabled': items.activo === false }" class="panel-heading">
                        <a id="{{items.id}}" href="<?php echo $this->Html->url(array('action'=>'contenidos'))?>/{{items.id}}" ng-click="getLecciones(items.id)" class="link "><?php echo "Lección ";?>{{$index + 1}}</a>
                    </div>
                    <div class="panel-body">
                        <h4 class="title">{{items.titulo}}</h4>
                        <p class="description text-center">{{items.descripcion}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-timeline" ng-if="($index + 1) % 2 == 0">
            <div class="timeline">
                <div class="timeline-icon"><i class="fa fa-futbol-o fa-2x"></i></div>
                <div class="timeline-content right panel panel-primary" >
                    <div ng-class="{'isDisabled': items.activo === false }" class="panel-heading">
                        <a id="{{items.id}}" href="<?php echo $this->Html->url(array('action'=>'contenidos'))?>/{{items.id}}" ng-click="getLecciones(items.id)" class="link "><?php echo "Lección ";?>{{$index + 1}}</a>
                    </div>
                    <div class="panel-body">
                        <h4 class="title">{{items.titulo}}</h4>
                        <p class="description text-center">{{items.descripcion}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/induccion/induccionPantallasService',
		'angularjs/controladores/induccion/induccionPantallasController',
		'angularjs/directivas/confirmacion'
	));
?>

<script>
    /*
    $(document).ready(function() {              
        $.ajax({
            type: "GET",
            url: 'http://localhost/sgi-v3/Servicios/serviceObtSession',            
            dataType : 'json',
            success: function(data)
            {   
                if(data!='') {
                    localStorage.setItem("nombre", data["User"].nombre);
                    localStorage.setItem("usuario", data["User"].usuario);
                    localStorage.setItem("email", data["User"].email);
                }
                else {
                    // enviar al cakephp
                    alert("vacio")
                    setSession();
                }                
            }
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
                        alert("set "+ data)
                    }
                }); 
            } else {
                alert("set session no valida")
            }
        }

    });

    
*/
</script>

 <style>
.link{
  color: white;
}
.main-timeline{
    position: relative;
    transition: all 0.4s ease 0s;
}
.main-timeline:before{
    content: "";
    width: 3px;
    height: 100%;
    background: #bfbfbf;
    position: absolute;
    top: 0;
    left: 50%;
}
.main-timeline .timeline{
    position: relative;
    height: 100%;
}
.main-timeline .timeline:before,
.main-timeline .timeline:after{
    content: "";
    display: block;
    width: 100%;
    clear: both;
}
.main-timeline .timeline-icon{
    /*width: 35px;
    height: 35px;*/
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid #0a90d7;
    position: absolute;
    top: 0;
    left: 0;
    right: 3px;
    margin: 0 auto;
    overflow: hidden;
}
.main-timeline .timeline-content{
    width: 45%;
    /*padding: 20px;*/
    border-radius: 5px;
    text-align: center;
    -webkit-box-shadow: 0 3px 0 rgba(0, 0, 0, 0.1);
    -moz-box-shadow: 0 3px 0 rgba(0, 0, 0, 0.1);
    -ms-box-shadow: 0 3px 0 rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease 0s;
}
.main-timeline .date{
    display: inline-block;
    font-size: 16px;
    font-weight: 300;
    color: #fff;
    padding: 12px 33px;
    background: #0a90d7;
    border-radius: 30px;
}
.main-timeline .title{
    font-size: 24px;
    font-weight: 500;
    color: #5c5151;
   /* margin-top: 30px;*/
}
.main-timeline .description{
    font-size: 14px;
    color: #606060;
    line-height: 2;
}
.main-timeline .timeline-content.right{
    float: right;
    text-align: center;
}
@media only screen and (max-width: 767px){
    .main-timeline:before{
        left: 0;
    }
    .main-timeline .timeline-icon{
        left: -8px;
        margin: 0;
    }
    .main-timeline .timeline-content{
        width: 90%;
        float: right;
    }
}

.isDisabled {
    cursor: not-allowed;
    opacity: 0.5;
}
.isDisabled > a {
    color: currentColor;
    display: inline-block; 
    pointer-events: none;
    text-decoration: none;
}
</style>