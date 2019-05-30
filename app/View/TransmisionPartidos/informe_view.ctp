<style>input {margin-top: 0px;}
	.btn-xs{margin-top: -18px;}
	.def{font-weight:100;display:inline-block;}
</style>

<div>
<!--ng-controller="TransmisionControllerView" ng-init="idTransmision = <?php echo $id; ?>"-->
	<!--<p ng-bind-html="cargador" ng-show="loader"></p>-->
	<div class="row" ng-hide="loader">
		<div class="col-sm-12">
			<h3>Informe de recepción y transmisión de señales.</h3>
			<div class="panel panel-default">
				<div class="panel-heading"><h4>Satelite</h4></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<tr> 
										<th>Programa:</th>
										<td>DEPORTES ANTOFAGASTA vs. SANTIAGO WANDERERS  FO + TEMIX</td>
										<th>Hora Inicio:</th>
										<td>15:20</td>
										<th>Hora Termino:</th>
										<td>15:20</td>
										<th>Lugar:</th>
										<td>ANTOFAGASTA</td>
									</tr>
									
								</table>
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
								<tr> 
										<th>Satelite:</th>
										<td>HISPASAT 1E</td>
									</tr>
									<tr>
										<th>Receptor:</th>
										<td>SATHD</td>
									</tr>
									<tr>
										<th>Hora Inicio:</th>
										<td>15:00</td>
									</tr>	
									<tr>
										<th>Hora Termino:</th>
										<td>18:20</td>
									</tr>	
								

								</table>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
							<tr> 
										<th>Signal Level:</th>
										<td>-33 dBm</td>
									</tr>
									<tr>
										<th>BER:</th>
										<td>1.0 E-8</td>
									</tr>
									<tr>
										<th>C/N :</th>
										<td>10.0 dB</td>
									</tr>	
									<tr>
										<th>C/N MARGIN:</th>
										<td>1.6 dB</td>
									</tr>	
								

								</table>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
							<tr> 
										<th>RX DE SEÑAL :</th>
										<td>OK</td>
										<td>DEFICIENTE</td>
										<td>SIN OBSERVACIONES	</td>
									</tr>
									
								

								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading"><h4>Fibra Optica</h4></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
								<tr> 
										<th>Fibra Optica:</th>
										<td>HISPASAT 1E</td>
									</tr>
									<tr>
										<th>Hora Inicio:</th>
										<td>15:00</td>
									</tr>	
									<tr>
										<th>Hora Termino:</th>
										<td>18:20</td>
									</tr>	
										<tr>
										<th>Receptor:</th>
										<td>RXHD 1 CLARO</td>
										<td>RXHD 2 CLARO</td>
										<td>RXC13 HD1</td>
										<td>RXC13 HD2</td>
										<td>RX CTC 1</td>
										<td>RX CTC 2</td>
										<td>RX1</td>
										<td>RX1</td>
										<td>RX1</td>
										<td>RX1</td>
										<td>RXCHF HD</td>
										<td>IN CHF SDI</td>
										<td>CHILEF VC</td>
									</tr>
								

								</table>
							</div>
						</div>
						
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
							<tr> 
										<th>RX DE SEÑAL :</th>
										<td>OK</td>
										<td>DEFICIENTE</td>
										<td>SIN OBSERVACIONES	</td>
									</tr>
									
								

								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
	<div class="panel panel-default">
				<div class="panel-heading"><h4>Micro Ondas</h4></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
								<tr> 
										<th>Micro Ondas:</th>
										<td>HISPASAT 1E</td>
									</tr>
									<tr>
										<th>Hora Inicio:</th>
										<td>15:00</td>
									</tr>	
									<tr>
										<th>Hora Termino:</th>
										<td>18:20</td>
									</tr>	
								    <tr>
										<th>Receptor:</th>
										<td>RX CDF1</td>
										<td>RX CDF2</td>

									</tr>

								</table>
							</div>
						</div>
						
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
							<tr> 
										<th>RX DE SEÑAL :</th>
										<td>OK</td>
										<td>DEFICIENTE</td>
										<td>SIN OBSERVACIONES	</td>
									</tr>
									
								

								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading"><h4>Otros</h4></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							
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
		'angularjs/servicios/transmisionPartidos/transmisionPartidos',
		'angularjs/controladores/transmisionPartidos/transmisionPartidos'
	));
?>
