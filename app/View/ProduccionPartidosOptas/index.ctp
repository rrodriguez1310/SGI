<style>
.container{ width:100%; }
input {margin-top: 0px;}
</style>
<div ng-controller="conciliacionOptaProd">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="col-md-12" style="margin-bottom:20px;"></div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">

					<div class="col-md-10">
						<h4>Producción Partidos</h4>
					</div>	

					<!--div class="col-md-5">						
						<ui-select class="abajo" ng-model="selectCampeonato.id" name="AnioPresupuesto" id="exampleInputEmail1" required>
						<ui-select-match placeholder=" Campeonato ">
							<span>{{$select.selected.nombre}}</span>
						</ui-select-match>
						<ui-select-choices repeat="campeonato.id as campeonato in campeonatosList | filter: $select.search">
							<div ng-bind-html="campeonato.nombre | highlight: $select.search"></div>
						</ui-select-choices>
						</ui-select>
					</div-->
					
					<button class="btn btn-success sube" ng-click="setDatosOptaAll()">
						<i ng-class=" !btnSync ? 'fa fa-cloud-upload' : 'fa fa-refresh fa-spin fa-fw' "></i> 
						Sincronizar
					</button>

				</div>
				<div id="grid1" ui-grid="gridOptions" ui-grid-edit ui-grid-cellnav ui-grid-resize-columns class="grid"></div>
			</div>
		</div>		
		
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="col-md-4">
						<h4>Opta Feeds</h4>
					</div>
					<div>
						<div class="col-md-3">
							<input type="number" name="Nombre" class="form-control sube" placeholder="ID Campeonato" ng-model="idCompetition" required>
						</div>
						<div class="col-md-3">
							<input type="number" name="Nombre" class="form-control sube" placeholder="Año" ng-model="idSeason" required>
						</div>
						<button class="btn btn-primary sube" ng-disabled="!idCompetition||!idSeason" ng-click="obtDatosOpta()">
							<i ng-class=" !btnLoader ? 'fa fa-cloud-download' : 'fa fa-spinner fa-pulse fa-fw' "></i> 
							Cargar
						</button>
					</div>

				</div>
				<div id="grid2" ui-grid="gridOptionsOpta" ui-grid-resize-columns class="grid"></div>
			</div>
		</div>
	</div>  
</div>

<?php 		
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/produccionPartidos/produccionPartidosOptas',		
		'angularjs/controladores/produccionPartidos/produccionPartidosOptas'		
	));
?>