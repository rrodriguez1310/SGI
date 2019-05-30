<?php pr($gerencias);?>
<div class="col-md-12">
	<div class="row">
		<h2 class="text-center"><?php echo __('Dotación por Gerencia'); ?></h2>		
	</div>
	<div class="table-responsive">
		<table class="table table-condensed table-bordered table-striped">
			<thead style="background-color: #4F80BC; color: #FFF;">
				<th>Año</th>
				<?php foreach($gerencias as $gerencia): ?>
					<th><small><?php echo mb_strtoupper($gerencia["Gerencia"]["nombre"])?></small></th>
				<?php endforeach; ?>	
			</thead>
			<tbody>
				<tr>
					<td>2013</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>