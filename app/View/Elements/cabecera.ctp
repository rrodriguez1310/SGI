<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Desplegar navegación</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	<a class="navbar-brand" href="#" style="cursor:initial;"><?php echo $this->Html->image('cdf.png', array('alt' => 'Cdf', 'width' => '41')); ?></a>
</div>
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<?php foreach($this->Session->read("Menus") as $key => $menuPrincipal) : ?>
			<ul class="nav navbar-nav">
				<li class="menu-item dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __($key); ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php foreach($menuPrincipal as $key => $datosMenu) :?>
							<?php if(count($datosMenu) == 1) : ?>
								<?php foreach($datosMenu as $link) : ?>
									<?php if($link["controlador"] == "subscribers" && ($link["accion"] == "informe_abonados" || $link["accion"] == "genera_informe_abonado_pdf_promociones")) : ?>
										<li class="menu-item "><a class="<?php echo ($link["accion"] == "informe_abonados") ? 'filtroInformeAbonados' : 'filtroInformeAbonadosPromociones'?>" href="#" data-toggle="modal" data-target="#informeAbonados"><?php echo $key; ?></a></li>
									<?php else : ?>
										<li class="menu-item dropdown"><a href="<?php echo $this->Html->url(array("controller"=>$link["controlador"], "action"=>$link["accion"])); ?>" ><?php echo $key ;?></a>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php if(count($datosMenu) > 1) : ?>
								<li class="menu-item dropdown dropdown-submenu"><a href="#" ><?php echo $key ;?></a>
								<ul class="dropdown-menu">
								<?php foreach($datosMenu as $link) : ?>
									<?php foreach($link["nombreLink"] as $nombreMenu) : ?>
										<li class="menu-item "><a href="<?php echo $this->Html->url(array("controller"=>$link["controlador"], "action"=>$link["accion"])); ?>"><?php echo $nombreMenu; ?></a></li>
									<?php endforeach; ?>
								<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						<?php endforeach; ?>
						</li>
					</ul>
				</li>
			</ul>
		<?php endforeach; ?>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="<?php echo $this->Html->url(array('controller' => 'trabajadores', 'action' => 'perfil', $this->Session->Read("PerfilUsuario.trabajadoreId")));?>"><i class="fa fa-user"></i> <?php echo $this->Session->Read("Users.nombre");?></a></li>
			<li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout')); ?>"><i class="fa fa-unlock-alt"></i>  Cerrar sesión</a></li>
		</ul>
	</div>
</nav>
