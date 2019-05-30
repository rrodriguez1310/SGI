<style>input {margin-top: 0px;}</style>
<div ng-controller="PresupuestoReportes">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="showFecha">		
		<div class="row">
			<div class="col-sm-12 text-center">
				<h4 class="margin-b-10">Resumen Presupuesto vs Gastos {{nombreGerencia}}</h4>
			</div>
		</div><br>
		<div class="row">
			<form class="form-horizontal" name="fecha" novalidate>
				<div class="col-sm-12 text-center">
					<label class="control-label text-right col-md-5 col-sm-12" >Año presupuesto</label>
					<div class="col-md-7 col-sm-12">
						<ui-select class="abajo" ng-model="list.anioPresupuesto" name="AnioPresupuesto" style="width:220px">
							<ui-select-match placeholder=" -- Seleccione -- ">
								 <span>{{(!!$select.selected)?$select.selected:''}}</span>
							</ui-select-match>
							<ui-select-choices repeat="presupuesto in presupuestoAnios | filter: $select.search">
								<div ng-bind-html="presupuesto | highlight: $select.search"></div>
							</ui-select-choices>
						</ui-select>
					</div>
				</div>
			</form>
		</div>
	</div>
	<br>
	<div ng-show="tablaDetalle">
		<?php echo $this->element("botonera"); ?>
		<div ui-i18n="{{lang}}">
			<div ui-grid="gridOptions" ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ui-grid-pinning ng-model="grid" class="grid"></div>
		</div>
	</div>
	<br>
	<div ng-show="showCodigoGrafico">
		<div class="row">
			<form class="form-horizontal" name="codigos" novalidate>
				<div class="col-sm-12 text-center">
					<div class="form-group">
						<label class="control-label text-right col-md-5 col-sm-12">Familia Presupuesto</label>
						<div class="col-md-7 col-sm-12">
							<ui-select class="abajo" ng-model="list.famPresupuesto" name="FamiliaPresupuesto" style="width:400px" on-select="actualizaGraficos()">
								<ui-select-match placeholder=" -- Seleccione -- ">
									 <span>{{(!!$select.selected.nombre)?$select.selected.nombre:''}}</span>
								</ui-select-match>
								<ui-select-choices repeat="familia.codigo as familia in presupuestoFamilias | filter: $select.search">
									<div ng-bind-html="familia.nombre | highlight: $select.search | limitTo: 55"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label text-right col-md-5 col-sm-12">Código Presupuestario</label>
						<div class="col-md-7 col-sm-12">
							<ui-select class="abajo" ng-model="list.codPresupuesto" name="CodigoPresupuesto" style="width:400px" on-select="actualizaGraficos()">
								<ui-select-match placeholder=" -- Seleccione -- ">
									 <span>{{(!!$select.selected.nombre)?$select.selected.nombre:''}}</span>
								</ui-select-match>
								<ui-select-choices repeat="codigo.codigo as codigo in presupuestoCodigos | filter: $select.search">
									<div ng-bind-html="codigo.nombre | highlight: $select.search | limitTo: 55"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>	
	<br>
	<div ng-if="graficos">
		<div class="row">
			<div class="col-md-12">
	            <highchart id="chart1" config="chart1"></highchart>
	        </div>
		</div>
	</div>
</div>
<script>
	$(function () {
	    Highcharts.setOptions({
	        global: {
	            useUTC: false	            
	        },
	        lang: {
	          decimalPoint: ',',
	          thousandsSep: '.'
	        }
	    });
    });
</script>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/compras/compras',
		'angularjs/controladores/compras/presupuesto_reportes',
	));
?>
