<form class="form-horizontal">
	<div class="container">
		<div class="col-md-10 col-md-offset-1 toppad" >
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h3 class="panel-title"><?php echo __('Detalle Empresa'); ?></h3>
						</div>
					</div>
				</div>

				<div class="panel-body">	
					<div class="col-md-12">
						<div class="panel-body">
							<div  class="">
								<label for="inputEmail3" class="col-md-3 control-label">País:</label>
								<div class="col-md-9 baja mayuscula"><?php echo (!empty($company['Paise']['nombre']))? $company['Paise']['nombre'] : '-'; ?></div>
							</div>
							<div class="">
								<label class="col-md-3 control-label" for="TrabajadoreRut">RUT :</label>
								<div class="col-md-9 baja"><?php echo (!empty($company['Company']['rut'])) ? $company['Company']['rut'] : '-'; ?></div>
							</div>   									
							<div class="">
								<label for="inputRazon" class="col-md-3 control-label">Razón social :</label>
								<div class="col-md-9 baja mayuscula"><?php echo (!empty($company['Company']['razon_social']))? $company['Company']['razon_social'] : '-'; ?></div>
							</div>
							<div  class="">
								<label for="inputEmail3" class="col-md-3 control-label">Nombre de fantasía :</label>
								<div class="col-md-9 baja mayuscula"><?php echo (!empty($company['Company']['alias']))? $company['Company']['alias'] : '-'; ?></div>
							</div>
							<div class="">
								<label for="inputPassword3" class="col-md-3 control-label">Dirección : </label>
								<div class="col-md-9 baja mayuscula"><?php echo (!empty($company['Company']['direccion']))? $company['Company']['direccion'] : '-'; ?></div>
							</div>
							<div class="">
								<label for="inputPassword3" class="col-md-3 control-label">Comuna : </label>
								<div class="col-md-9 baja mayuscula"><?php echo (!empty($comuna['Comuna']['comuna_nombre']))? $comuna['Comuna']['comuna_nombre'] :'-'; ?></div>
							</div>
							<div class="">
								<label for="inputPassword3" class="col-md-3 control-label">Teléfono / fax : </label>
								<div class="col-md-9 baja"><?php echo (!empty($company['Company']['telefono']))? $company['Company']['telefono']:'-'; ?></div>
							</div>
							<div class="">
								<label for="inputPassword3" class="col-md-3 control-label">Email : </label>
								<div class="col-md-9 baja minuscula"><?php echo (!empty($company['Company']['email']))? $company['Company']['email']:'-'; ?></div>
							</div>
							<div class="">
								<label for="inputPassword3" class="col-md-3 control-label">Banco : </label>
								<div class="col-md-9 baja mayuscula"><?php echo (!empty($company['Company']['banco']))? $company['Company']['banco']:'-'; ?></div>
							</div>
							<div class="">
								<label for="inputPassword3" class="col-md-3 control-label">Cuenta corriente : </label>
								<div class="col-md-9 baja"><?php echo (!empty($company['Company']['cuenta_corriente']))? $company['Company']['cuenta_corriente'] : '-'; ?></div>
							</div>
							<div  class="">
								<label for="inputEmail3" class="col-md-3 control-label">Tipo empresa : </label>
								<div class="col-md-9 baja mayuscula"><?php echo (!empty($tipoCompania))? $tipoCompania : '-'; ?></div>
							</div>
							
							<?php if(!empty($company['Company']['documento'])){ ?>
								<div  class="">
									<label for="inputEmail3" class="col-md-3 control-label">Dcumento : </label>
									<div class="col-md-9 baja mayuscula">
										<a  target="_blank" href=" <?php echo $this->webroot ?>files/empresas/<?php echo $company['Company']['documento']; ?>">ver documento</a>
										<?php //echo (!empty($company['Company']['documento']))? $company['Company']['documento'] : 'Sin documento asociado'; ?>
									</div>
								</div>
							<?php } ?>

						</div>
					</div>  								
				</div>
				
				<div class="panel-footer">
					<a href="javascript:window.history.back()" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
				</div> 
			</div>
		</div>
	</div>
</form>
<!--div class="col-sm-offset-4 col-sm-10">
	<h4><?php echo __('Detalle Empresa'); ?></h4>
	<br>
</div>




<table cellpadding="0" cellspacing="0" border="0" class="table tabla-detalle">
	<tr>
		<th>Rut :</th>
		<td><?php echo h($company['Company']['rut']); ?></td>
	</tr>
	<tr>
		<th>Razón social :</th>
		<td><?php echo h($company['Company']['razon_social']); ?></td>
	</tr>
	<tr>
		<th>Nombre de fantasía :</th>
		<td><?php echo h($company['Company']['alias']); ?></td>
	</tr>
	<tr>
		<th>Dirección :</th>
		<td><?php echo h($company['Company']['direccion']); ?></td>
	</tr>
	<tr>
		<th>Comuna :</th>
		<td><?php echo h($company['Company']['comuna']); ?></td>
	</tr>
	<tr>
		<th>Teléfono / fax :</th>
		<td><?php echo h($company['Company']['telefono']); ?></td>
	</tr>
	<tr>
		<th>Email:</th>
		<td class="minuscula"><?php echo h($company['Company']['email']); ?></td>
	</tr>
	<tr>
		<th>Banco : </th>
		<td><?php echo h($company['Company']['banco']); ?></td>
	</tr>
	<tr>
		<th>Cuenta corriente :</th>
		<td><?php echo h($company['Company']['cuenta_corriente']); ?></td>
	</tr>
	<tr>
		<th>Tipo empresa :</th>
		<td><?php echo h($company['Company']['company_type_id']); ?></td>
	</tr>
</table>
<div class="col-sm-offset-4 col-sm-10">
	<a href="<?php echo $this->Html->url(array("controller"=>"companies", "action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
</div>

<!--form class="form-horizontal">
	<div class="col-md-10 col-md-offset-1">
		<div class="form-group">
			<label class="col-sm-3 control-label" >Rut empresa:</label>
			<div class="col-sm-7 baja"><?php echo h($company['Company']['rut']); ?></div>	
		</div>
		<div class="form-group">
			<label for="inputRazon" class="col-sm-3 control-label">Razón social:</label>
			<div class="col-sm-7 baja"><?php echo h($company['Company']['razon_social']); ?></div>
		</div>
		<div  class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label">Nombre de fantasía:</label>
			<div class="col-sm-7 baja"><?php echo h($company['Company']['alias']); ?></div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Dirección: </label>
			<div class="col-sm-7 baja"><?php echo h($company['Company']['direccion']); ?></div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Comuna: </label>
			<div class="col-sm-7 baja"><?php echo h($company['Company']['comuna']); ?></div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Teléfono / fax: </label>
			<div class="col-sm-7 baja"><?php echo h($company['Company']['telefono']); ?></div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Email: </label>
			<div class="col-sm-7 baja"><?php echo h($company['Company']['email']); ?></div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Banco: </label>
			<div class="col-sm-7 baja"><?php echo h($company['Company']['banco']); ?></div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">Cuenta corriente: </label>
			<div class="col-sm-7 baja"><?php echo h($company['Company']['cuenta_corriente']); ?></div>
		</div>
		<div  class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label"><span class="aterisco">*</span>Tipo empresa: </label>
			<div class="col-sm-7 baja"><?php echo h($company['Company']['company_type_id']); ?></div>
		</div>	
	</div>

	<div class="col-sm-offset-3 col-sm-10">
		<a href="<?php echo $this->Html->url(array("controller"=>"companies", "action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
	</div>

</form-->
<!--div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Company'), array('action' => 'edit', $company['Company']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Company'), array('action' => 'delete', $company['Company']['id']), array(), __('Are you sure you want to delete # %s?', $company['Company']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Company Types'), array('controller' => 'company_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company Type'), array('controller' => 'company_types', 'action' => 'add')); ?> </li>
	</ul>
</div-->
