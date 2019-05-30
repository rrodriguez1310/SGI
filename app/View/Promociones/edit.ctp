<div ng-cloak>
	<div class="row">
		<div class="col-md-12">
			<h2>Editar promoción</h2>
		</div>
	</div>
	<hr>
	<br/>
	<div class="row">
		<div class="col-md-12">
			<?php echo $this->Form->create('Promocione', [
				"name" => "promocionesAdd",
				"novalidate",
				"inputDefaults" => [
					"div" => "form-group",
					"label" => [
						"class" => "control-label"
					],
					"class" => "form-control",
					"required"
				]
			]); ?>
			<?= $this->Form->input('id') ?>
			<?= $this->Form->input('nombre', ["ng-model"=>"nombre", "label" => ["text"=>"Nombre", "class" => "control-label"], "ng-init" => "nombre='".$this->request->data['Promocione']['nombre']."'","div" => ["ng-class"=>"{'has-error' : promocionesAdd['data[Promocione][nombre]'].\$invalid}"]]) ?>
			<?= $this->Form->input('descripcion', ["ng-model"=>"descripcion", "label"=> ["text"=>"Descripción", "class" => "control-label"], "ng-init" => "descripcion='".$this->request->data['Promocione']['descripcion']."'","div" => ["ng-class"=>"{'has-error' : promocionesAdd['data[Promocione][descripcion]'].\$invalid}"]]) ?>
			<?= $this->Form->input('channel_id', ["ng-model"=>"channel_id", "label"=> ["text"=>"Canal", "class" => "control-label"], "ng-init" => "channel_id='".$this->request->data['Promocione']['channel_id']."'","div" => ["ng-class"=>"{'has-error' : promocionesAdd['data[Promocione][channel_id]'].\$invalid}"]]) ?>
			<?= $this->Form->input('company_id', ["ng-model"=>"company_id", "label"=> ["text"=>"Empresa", "class" => "control-label"], "ng-init" => "company_id='".$this->request->data['Promocione']['company_id']."'","div" => ["ng-class"=>"{'has-error' : promocionesAdd['data[Promocione][company_id]'].\$invalid}"]]) ?>
			<div class="form-group text-center">
				<?= $this->Form->button('<i class="fa fa-pencil-square-o"></i> Actualizar', ['type' => 'submit', "escape" => false, "class" => "btn btn-primary btn-lg", "ng-disabled" => "promocionesAdd.\$invalid"])?>	
			</div>
			
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<?= $this->Html->script("angularjs/controladores/app")?>
