
<style>
.container {
    margin-top: 20px;
}

/* Carousel Styles */
.carousel-indicators .active {
    background-color: #2980b9;
}

.carousel-inner img {
    width: 97%;
    max-height: 750px !important;
    /*max-height: auto;*/
   /* content: block; */ 
}

.carousel-control {
    width: 0;
}

.carousel-control.left,
.carousel-control.right {
	opacity: 1;
	filter: alpha(opacity=100);
	background-image: none;
	background-repeat: no-repeat;
	text-shadow: none;
}

.carousel-control.left span {
	padding: 15px;
}

.carousel-control.right span {
	padding: 15px;
}

.carousel-control .glyphicon-chevron-left, 
.carousel-control .glyphicon-chevron-right, 
.carousel-control .icon-prev, 
.carousel-control .icon-next {
	position: absolute;
	top: 45%;
	z-index: 5;
	display: inline-block;
}

.carousel-control .glyphicon-chevron-left,
.carousel-control .icon-prev {
	left: 0;
}

.carousel-control .glyphicon-chevron-right,
.carousel-control .icon-next {
	right: 0;
}

.carousel-control.left span,
.carousel-control.right span {
	background-color: #000;
}

.carousel-control.left span:hover,
.carousel-control.right span:hover {
	opacity: .7;
	filter: alpha(opacity=70);
}

/* Carousel Header Styles */
.header-text {
    position: absolute;
    top: 10px;
    left: 8%;
    right: auto;
    width: 80%;
    color: #fff;
}

.header-text h2 {
    font-size: 40px;
}

.header-text h2 span {
    background:white;
	padding: 5px;
}

.header-text h3 span {
    color: #000;
    padding: 0px;
    text-align: right !important;
}

.btn-min-block {
    min-width: 170px;
    line-height: 26px;
}

.btn-theme {
    color: #fff;
    background-color: transparent;
    border: 2px solid #fff;
    margin-right: 15px;
}

.btn-theme:hover {
    color: #000;
    background-color: #fff;
    border-color: #fff;
}
</style>

<div class=" col-sm-12">
    <a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="pull-right"> Volver al panel</a><br><br>
</div>

<div class="container">
	<div class="row">
    	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
            <?php foreach ($contenidos as $key => $contenido):?>
                <?php $id = $contenido['InduccionContenidos']['id'];?>
                <?php echo ($key == 0 ? '<div id="'.$id.'" class="item  active">' : '<div id="'. $id.'" class="item">'); ?> 
                <?php echo $this->Html->image('../files/induccion_contenido/image/'.$contenido['InduccionContenidos']['imagedir'].'/'.$contenido['InduccionContenidos']['image'], array('title' => $contenido['InduccionContenidos']['titulo']) ); ?>
                    <div class="header-text hidden-xs">
                        <div class="col-md-12 text-center">
                            <h2>
                            	<span><?php echo $contenido['InduccionContenidos']['titulo'] ?></span>
                            </h2>>
                            <h3>
                            	<span><?php echo $contenido['InduccionContenidos']['descripcion'] ?></span>
                            </h3>
                        </div>
                    </div>
			    </div>
            <?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

<div class="col-sm-offset-1 col-sm-10 box-footer">
    <a id="link" href="#carousel-example-generic" data-slide="prev" class=" left volver btn btn-primary pull-left"><i class="glyphicon glyphicon-chevron-left"></i> Anterior</a>
    <a href="#carousel-example-generic" data-slide="next" class=" right ri volver btn btn-primary pull-right">Siguiente <i class="glyphicon glyphicon-chevron-right"></i></a>
    <a href="<?php echo $this->Html->url(array("action"=>"quiz"))?>" class="quiz volver btn btn-primary pull-right">Realizar Quiz <i class="glyphicon glyphicon-list-alt"></i></a>
    <a href="http://localhost/sgi-v3/induccionPantallas/index" class="avance ri volver btn btn-primary pull-right">Siguiente lección <i class="glyphicon glyphicon-list-alt"></i></a>
    <br><br>
</div>


<script>

    $(document).ready(function() {
        $('.carousel').carousel({
            interval: 60000,
            wrap: false
        })

        $( ".ri" ).on("click",function() {
            $(".active").each(function(v, e){
                if(e.id != ""){
                    console.log('1 -> ',e.id);

                    var leccion = '<?php echo $leccion_id ?>';
                    var host = 'http://localhost/sgi-v3/';
                    var contenido = e.id; 
                    $.post(host + "InduccionPantallas/getContenidos/",{leccion:leccion, contenido:contenido}, function(data){
                        console.log('2 -> ',data)
                        if(data == 0){
                            $.post(host + "InduccionPantallas/avance/",{leccion:leccion, contenido:contenido}, function(data){
                            })
                        }else{
                            console.log("El contenido fue terminado por el usuario");
                        }
                        console.log('3 -> ', data)
                    }); 
                    return false;
                 }
            });
        });

    });

    var checkitem = function() {
        var $this;
        $this = $(".carousel");
        if ($(".carousel .carousel-inner .item:first").hasClass("active")) {
            $(".quiz, .left, .avance").hide();
            $(".right").show();
        } else if ($(".carousel .carousel-inner .item:last").hasClass("active")) {
            $(".right").hide();
            $(".quiz, .avance, .left").show();
        } else {
            $this.children(".carousel-control").show();
            $(".left, .quiz").show();
            $(".quiz").hide();
        }
    };

    checkitem();

    $(".carousel").on("slid.bs.carousel", "", checkitem);
    
</script>