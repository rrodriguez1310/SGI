<div class="companiesContactos view">
<h2><?php echo __('Companies Contacto'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Company'); ?></dt>
		<dd>
			<?php echo $this->Html->link($companiesContacto['Company']['id'], array('controller' => 'companies', 'action' => 'view', $companiesContacto['Company']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Apellido Paterno'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['apellido_paterno']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Apellido Materno'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['apellido_materno']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cargo'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['cargo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telefono Fijo'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['telefono_fijo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telefono Celular'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['telefono_celular']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Observacion'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['observacion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($companiesContacto['CompaniesContacto']['estado']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Companies Contacto'), array('action' => 'edit', $companiesContacto['CompaniesContacto']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Companies Contacto'), array('action' => 'delete', $companiesContacto['CompaniesContacto']['id']), array(), __('Are you sure you want to delete # %s?', $companiesContacto['CompaniesContacto']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies Contactos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Companies Contacto'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
	</ul>
</div>
