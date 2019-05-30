<div class="logProgramas view">
<h2><?php echo __('Log Programa'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numero Evento'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['numero_evento']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['fecha']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Inicio Presupuestado'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['inicio_presupuestado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre Canal'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['nombre_canal']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tipo Play'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['tipo_play']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hora Inicio'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['hora_inicio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hora Inicio Dos'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['hora_inicio_dos']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Duracion'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['duracion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hora Tres'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['hora_tres']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Clip'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['clip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['estado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Path'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre Archivo'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['nombre_archivo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Prefijo'); ?></dt>
		<dd>
			<?php echo h($logPrograma['LogPrograma']['prefijo']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Log Programa'), array('action' => 'edit', $logPrograma['LogPrograma']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Log Programa'), array('action' => 'delete', $logPrograma['LogPrograma']['id']), array(), __('Are you sure you want to delete # %s?', $logPrograma['LogPrograma']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Log Programas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Log Programa'), array('action' => 'add')); ?> </li>
	</ul>
</div>
