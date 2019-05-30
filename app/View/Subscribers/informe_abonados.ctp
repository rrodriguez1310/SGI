<div class="form-group ">
	<label for="exampleInputEmail1">Seleccione un mes:</label>
	<select id="meses" class="form-control meses" required>
		<?php foreach($meses as $mese) :?>
			<option value="<?php echo $mese["Month"]["id"]; ?>"><?php echo $mese["Month"]["nombre"]; ?></option>
		<?php endForeach;?>
	</select>
</div>

<div class="form-group">
	<label for="exampleInputPassword1">Seleccione un año:</label>
	<select id="agnos" class="form-control agnos" required>
		<?php foreach($agnos as $agno) :?>
			<?php if($agno["Year"]["id"] > 11 && $agno["Year"]["id"] < 17):?>
			<option value="<?php echo $agno["Year"]["id"]; ?>"><?php echo $agno["Year"]["nombre"]; ?></option>
			<?php endif; ?>
		<?php endforeach;?>
	</select>
</div>
<br/><br/>
<div class="row">
	<div class="col-md-12"><a class="btn btn-success btn-block generaInformeAbonado" href="#">Generar Informe</a></div>
	<!--div class="col-md-6"><a class="btn btn-success btn-block generaGraficos" href="#">Generar Graficos</a></div-->
</div>


<script>
	var mesPropuesto = parseInt(<?php echo $mesPedido; ?>) - parseInt(1); 
	
	$("#meses").val(mesPropuesto);
	var idAbonadosMeses = $("#meses").val();
	var idAbonadosAgnos = $("#agnos").val();

	
	if(idAbonadosMeses && idAbonadosMeses)
	{
		$(".generaInformeAbonado").attr("href","<?php echo $this->Html->url(array('controller'=>'subscribers', 'action'=>($promociones == 1) ? 'genera_informe_abonado_pdf_promociones' : 'genera_informe_abonado_pdf'))?>/"+idAbonadosMeses+'/'+idAbonadosAgnos);
	}


	/*
	if(idAbonadosMeses && idAbonadosMeses)
	{
		console.log(idAbonadosMeses);
		console.log(idAbonadosAgnos);

		$(".generaGraficos").attr("href","<?php echo $this->Html->url(array('controller'=>'subscribers', 'action'=>'graficos'))?>?"+idAbonadosMeses+'/'+idAbonadosAgnos);
	}
	*/
	
	$("#meses").on('change', function(){
		idAbonadosMeses = $("#meses").val();
		console.log(idAbonadosMeses);
		if(idAbonadosMeses != "" && idAbonadosAgnos != "")
		{
			$(".generaInformeAbonado").attr("href","<?php echo $this->Html->url(array('controller'=>'subscribers', 'action'=>($promociones == 1) ? 'genera_informe_abonado_pdf_promociones' : 'genera_informe_abonado_pdf'))?>/"+idAbonadosMeses+'/'+idAbonadosAgnos);
		}
	})
	
	$("#agnos").on('change', function(){
		idAbonadosAgnos = $("#agnos").val();
		console.log(idAbonadosAgnos);
		if(idAbonadosMeses != "" && idAbonadosAgnos != "")
		{
			$(".generaInformeAbonado").attr("href","<?php echo $this->Html->url(array('controller'=>'subscribers', 'action'=>($promociones == 1) ? 'genera_informe_abonado_pdf_promociones' : 'genera_informe_abonado_pdf'))?>/"+idAbonadosMeses+"/"+idAbonadosAgnos);
		}
	})
	
	
	
</script>
