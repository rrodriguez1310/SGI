<?php 
	echo $this->Html->css(array(
		'multi-select',
		'datepicker3'
	));
?>
<!--hr-->
	<ul class="nav nav-pills">
		<li class="pull-right">
			<a id="history" href="#" class="volver btn btn-default "><i class="fa fa-mail-reply-all"></i> Volver</a>
		</li>
	</ul>
<!--hr-->
<br/>

<h3 class="text-center">Exportar a Excel</h3><br/>
<?php //echo $this->Form->create('exportar'); ?>
<form id="exportarExcelForm" accept-charset="utf-8" method="post" action="<?php echo $this->Html->url(array("controller"=>"exportar","action"=>"descarga_excel"))?>">
	<div class="form-group col-md-5">
		<label class="sr-only" for="exampleInputEmail2">Email address</label>
		<?php echo $this->Form->input('Operadores', array("type"=>"select", "option"=>$operadores, 'label'=>"Seleccione uno o más operadores", 'class'=>'multiselect operadores', "multiple"=>"multiple", 'required'=>true)); ?>
	</div>
	
	<div class="form-group col-md-5">
		<label>Fecha Desde</label>
		<?php echo $this->Form->input('fechaDesde', array("option"=>"", 'label'=>false, 'class'=>'form-control', 'required'=>true)); ?>
	</div>
	
	<div class="form-group col-md-5">
		<label>Feecha Hasta</label>
		<?php echo $this->Form->input('fechaHasta', array("option"=>"", 'label'=>false, 'class'=>'form-control', 'required'=>true)); ?>
	</div>
	
	<button type="submit" class="btn btn-primary col-md-5">
		Generar Informe
	</button>
</form>
<br>
<?php if(isset($abonadosMesesBasicos)) : ?>
	<?php foreach($abonadosMesesBasicos as $key => $abonadosMesesBasico) : ?>
		<table style="width: 100%; border:1px solid #002840;" cellpadding="5">
			<tbody>
				<tr>
					<td style="background-color: #002840; color:#ffffff;" align="center"><strong> Reales</strong></td>
					<td style="width: 200px; background-color: #002840; color:#ffffff;" colspan="3" rowspan="1" align="center" ><strong>Operador / <?php echo $operadores[$key];?></strong></td>
				</tr>
				<tr>
					<td align="center" style="width:20%; background-color: #002840; color:#ffffff;"><strong>Mes / Año</strong></td>
					<td align="center" style="width:20%; background-color: #002840; color:#ffffff;"><strong>Basicos</strong></td>
					<td align="center" style="width:20%; background-color: #002840; color:#ffffff;"><strong>Premium</strong></td>
					<td align="center" style="width:20%; background-color: #002840; color:#ffffff;"><strong>HD</strong></td>
				</tr>
				
				<?php if(isset($agnos)) :?>
					<?php foreach($agnos as $agno) : ?>
						<?php foreach($meses as $keyMes => $mes) :?>
							<?php if(isset($abonadosMesesBasicos[$key][$agno["Year"]["id"]])) :?>
								<tr>
									<td style="border:1px solid #002840;"> <?php echo substr($mes["Month"]["nombre"], 0, 3) . ' / ' .  $agno["Year"]["nombre"]; ?> </td>
									<td style="border:1px solid #002840;" align="right"> 
										<?php 
											if(isset($abonadosMesesBasicos[$key][$agno["Year"]["id"]][$mes["Month"]["id"]][1])){
												if(isset($mesesClonadosBasicos[$key][$agno["Year"]["id"]][1][$mes["Month"]["id"]]))
												{
													echo number_format(array_sum($abonadosMesesBasicos[$key][$agno["Year"]["id"]][$mes["Month"]["id"]][1]) + $mesesClonadosBasicos[$key][$agno["Year"]["id"]][1][$mes["Month"]["id"]], 0, '', '.');
												}else{
													echo number_format( array_sum($abonadosMesesBasicos[$key][$agno["Year"]["id"]][$mes["Month"]["id"]][1]), 0, '', '.');
												}
											}else{
												echo "";
											}
										?>
									</td>
									<td style="border:1px solid #002840;" align="right">
										<?php 
											if(isset($abonadosMesesBasicos[$key][$agno["Year"]["id"]][$mes["Month"]["id"]][2])){
												if(isset($mesesClonadosBasicos[$key][$agno["Year"]["id"]][2][$mes["Month"]["id"]]))
												{
													echo number_format(array_sum($abonadosMesesBasicos[$key][$agno["Year"]["id"]][$mes["Month"]["id"]][2]) + $mesesClonadosBasicos[$key][$agno["Year"]["id"]][2][$mes["Month"]["id"]], 0, '', '.');
												}else{
													echo number_format( array_sum($abonadosMesesBasicos[$key][$agno["Year"]["id"]][$mes["Month"]["id"]][2]), 0, '', '.');
												}
											}else{
												echo "";
											}
										?>
									</td>
									<td style="border:1px solid #002840;" align="right">
										<?php 
											if(isset($abonadosMesesBasicos[$key][$agno["Year"]["id"]][$mes["Month"]["id"]][3])){
												if(isset($mesesClonadosBasicos[$key][$agno["Year"]["id"]][3][$mes["Month"]["id"]]))
												{
													echo number_format(array_sum($abonadosMesesBasicos[$key][$agno["Year"]["id"]][$mes["Month"]["id"]][3]) + $mesesClonadosBasicos[$key][$agno["Year"]["id"]][3][$mes["Month"]["id"]], 0, '', '.');
												}else{
													echo number_format( array_sum($abonadosMesesBasicos[$key][$agno["Year"]["id"]][$mes["Month"]["id"]][3]), 0, '', '.');
												}
												
											}else{
												echo "";
											}
										?>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
		<br/>
		<br/>
	
		<table style="width: 100%; border:1px solid #3276B1" cellpadding="5">
			<tbody>
				<tr>
					<td style="width: 200px; background-color: #3276B1; color:#ffffff;" align="center"><strong> Presupuestado</strong></td>
					<td colspan="3" rowspan="1" align="center" style="background-color: #3276B1; color:#ffffff;"><strong>Operador / <?php echo $operadores[$key];?></strong></td>
				</tr>
				<tr>
					<td align="center" style="width:20%; background-color: #3276B1; color:#ffffff;"><strong>Mes / Año</strong></td>
					<td align="center" style="width:20%; background-color: #3276B1; color:#ffffff;"><strong>Basicos</strong></td>
					<td align="center" style="width:20%; background-color: #3276B1; color:#ffffff;"><strong>Premium</strong></td>
					<td align="center" style="width:20%; background-color: #3276B1; color:#ffffff;"><strong>HD</strong></td>
				</tr>
				
				<?php if(isset($agnos)) :?>
					<?php foreach($agnos as $agno) : ?>
						<?php foreach($meses as $keyMes => $mes) :?>
							<?php if(isset($abonadosMesesBasicos[$key][$agno["Year"]["id"]])) :?>
								<tr>
									<td style="border:1px solid #3276B1"> <?php echo substr($mes["Month"]["nombre"], 0, 3) . ' / ' .  $agno["Year"]["nombre"]; ?> </td>
									<td style="border:1px solid #3276B1" align="right"> 
										<?php 
											if(isset($presupuestadosBasicos[$key][$agno["Year"]["id"]][$mes["Month"]["id"]])){
												echo number_format( array_sum($presupuestadosBasicos[$key][$agno["Year"]["id"]][$mes["Month"]["id"]]), 0, '', '.');
											}else{
												echo "";
											}
										?>
									</td>
									<td style="border:1px solid #3276B1" align="right">
										<?php 
											
											if(isset($presupuestadosPremium[$key][$agno["Year"]["id"]][$mes["Month"]["id"]])){
												echo number_format( array_sum($presupuestadosPremium[$key][$agno["Year"]["id"]][$mes["Month"]["id"]]), 0, '', '.');
											}else{
												echo "";
											}
											 
										?>
									</td>
									<td style="border:1px solid #3276B1" align="right">
										<?php 
											if(isset($presupuestadosHd[$key][$agno["Year"]["id"]][$mes["Month"]["id"]])){
												echo number_format( array_sum($presupuestadosHd[$key][$agno["Year"]["id"]][$mes["Month"]["id"]]), 0, '', '.');
											}else{
												echo "";
											}
										?>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
		<br/><br/>
	<?php endforeach; ?>
<?php endif; ?>

<?php 
	echo $this->Html->script(array(
		'jquery.multi-select',
		'bootstrap-datepicker'
	));
?>
<script>
	var operadoresPrincipales = ["14","31", "32","33", "15", "13"];
	
	if(operadoresPrincipales != "")
	{
		$.each(operadoresPrincipales, function( index, value ) {
			$("#Operadores option[value=" +value+"]").attr('selected', 'selected');
		});
	}
	
	$('#Operadores').multiSelect(
		{
			selectableOptgroup: true
		}
	);
	    $('#fechaDesde, #fechaHasta').datepicker({
		    format: "dd/mm/yyyy",
		    startView: 1,
		    language: "es",
		    multidate: false,
		    daysOfWeekDisabled: "0, 6",
		    autoclose: true,
		    viewMode: "months", 
   			minViewMode: "months"
	    });
	    
	    $("#history").click(function(event) {
		    event.preventDefault();
		    history.back(1);
		});
</script>