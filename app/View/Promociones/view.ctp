<div class="row">
	<div class="col-md-12">
		<h2>Promoción</h2>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-8 col-md-offset-4 col-sm-8 col-sm-offset-3">
		<dl class="dl-horizontal">
			<dt>ID</dt>
			<dd><?= $promocione["Promocione"]["id"] ?></dd>
			<dt>Nombre</dt>
			<dd><?= $promocione["Promocione"]["nombre"] ?></dd>
			<dt>Descripción</dt>
			<dd><?= $promocione["Promocione"]["descripcion"] ?></dd>
			<dt>Empresa</dt>
			<dd><?= $promocione["Promocione"]["company_nombre"] ?></dd>
			<dt>Canal</dt>
			<dd><?= $promocione["Promocione"]["channel_nombre"] ?></dd>
			<dt>Estado</dt>
			<dd><?= strtoupper($promocione["Promocione"]["estado"]) ?></dd>
			<dt>Creado</dt>
			<dd><?= empty($promocione["Promocione"]["created"]) ? null : DateTime::createFromFormat('Y-m-d H:i:s', $promocione["Promocione"]["created"])->format("d/m/Y") ?></dd>
			<dt>Modificado</dt>
			<dd><?= empty($promocione["Promocione"]["modified"]) ? null : DateTime::createFromFormat('Y-m-d H:i:s', $promocione["Promocione"]["modified"])->format("d/m/Y") ?></dd>
		</dl>
	</div>
</div>
