<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-cogs"></i> Buscador</h3>
	</div>
	<div class="panel-body">
		<input type="text" class="form-control input-sm sube" ng-model="searchMensajes" ng-change="refreshData(searchMensajes)" value="{{searchMensajes}}" placeholder="Buscar" />
	</div>
</div>