<br/><br/><br/><br/>
<div class="col-xs-12 col-sm-6 col-lg-4"></div>
<div class="row center-block">
    <div class="col-xs-12 col-sm-6 col-lg-4">
		<div class="box">							
			<div class="icon">
				<div class="image"><i class="fa fa-key"></i></div>
				<div class="info">
					<h3 class="title">No tiene acceso a la pagina que esta solicitando</h3>
					<div class="more">
						<br>
						<a id="backLink" href="#" title="Title Link">Volver <i class="fa fa-angle-double-right"></i></a>
					</div>
				</div>
			</div>
			<div class="space"></div>
		</div> 
	</div>
</div>
<br/><br/><br/><br/>
<script>
	$("#backLink").click(function(event) {
	    event.preventDefault();
	    history.back(1);
	});
</script>