<!--login modal-->
<div class="row">
<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
      	<?php echo $this->Html->image('cdf_pdf.jpg', array('alt' => 'Canal CDF', 'width'=>'80')); ?>
          <h3 class="text-center">  Login de usuario</h3>
      </div>
      <div class="modal-body">
      	<?php echo $this->Session->flash(); ?>
          <?php echo $this->Form->create('users'); ?>
            <div class="form-group">
            	<?php echo $this->Form->input('usuario', array("class"=>"form-control", "placeholder"=>"Usuario", "label"=>false, 'required'));?>
            </div>
            <div class="form-group">
            	<?php echo $this->Form->input('clave', array("type"=>"password", "class"=>"form-control", "placeholder"=>"Clave", "label"=>false, 'required'));?>
            </div>
            <div class="form-group">
              <button class="btn btn-primary  btn-block" >Ingresar</button><br/>
            </div>
          </form>
      </div>
</div>
</div>
<br/>
<br/>
<br/>
<!--div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"> <h3><i class="fa fa-key"></i> Login de usuario</h3>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('users'); ?>
					<fieldset>
						<div class="form-group">
							<?php echo $this->Form->input('usuario', array("class"=>"form-control", "placeholder"=>"Usuario", "label"=>false, 'required'));?>
						</div>
						<div class="form-group">
							<?php echo $this->Form->input('clave', array("class"=>"form-control", "placeholder"=>"Clave", "label"=>false, 'required'));?>
						</div>
						<div class="checkbox">
							<label>
								<input name="remember" type="checkbox" value="Remember Me">recordar</label>
						</div>
						<button class="btn btn-primary btn-block">Ingresar</button>
					</fieldset>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div-->