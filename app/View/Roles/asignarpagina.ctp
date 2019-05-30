<?php //pr($paginas); exit; ?>
<!--hr>
	<ul class="nav nav-pills">
		<li class="pull-right">
			<a href="<?php echo $this->Html->url(array("controller"=>"roles", "action"=>"index"))?>"><i class="fa fa-mail-reply-all"></i> Volver</a>
		</li>
	</ul>
<hr-->
<id class="mensaje"></id>
<h3 class="text-center"><?php echo __("Asignación de páginas a roles"); ?></h3>
<br/>
 <h4> <i class="fa fa-info-circle fa-1x"></i> El rol al cual se le va asociar páginas es: <?php echo strtoupper($nombre)?></h4>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
	<thead>
		<tr>
			<th><button class="btn-small btn-default" id="checkAll"><i class="fa fa-check-square-o"></i></button></th>
			<th>Clasificación</th>
			<th>Menú 1</th>
			<th>Menú 2</th>
			<th>Menú 3</th>
			<th>Descripción</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($paginas as $pagina): ?>

				<?php if($pagina['Pagina']['controlador_fantasia'] != "Menú" and $pagina['Pagina']['controlador_fantasia'] != "Páginas") :?>
					<tr>
						<td><?php echo $this -> Form -> checkbox('paginas'.$pagina['Pagina']['id'], array('value' => $pagina['Pagina']['id'], 'class'=>'check pagina-'.$pagina["Pagina"]["id"].' limpiar')); ?></td>
						<td class="mayuscula"><?php if($pagina['Pagina']['menu_id']== 8) echo "Función"; else echo "Página"; ?></td>
						<td class="mayuscula"><?php echo $pagina['Menu']['nombre'];?></td>
						<td class="mayuscula"><?php echo $pagina['Pagina']['controlador_fantasia'];?></td>
						<td class="mayuscula"><?php echo $pagina['Pagina']['accion_fantasia'];?></td>
						<td class="mayuscula"><?php echo $pagina['Pagina']['alias'];?></td>
					</tr>
				<?php endif; ?>
		
		<?php endForeach; ?>
	</tbody>
</table>
<button type="submit" class="btn btn-primary registraPaginasRole btn-lg"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 

<script type="text/javascript">
	
	var cheked = false;
	
	$('#checkAll').click(function () {
		
		if(cheked == false)
		{ 		   
	    	$('.check').prop('checked', true);	    
	    	cheked = true; 
		}
		else
		{ 		   
	    	$('.check').prop('checked', false);	    
	    	cheked = false; 
		}       
	});
	
	////clae para los checkbox
	
	$(".registraPaginasRole").click(function(){
		var id="";
		id = "<?php echo $id; ?>";
		var checked = "";
		var unchecked = "";
		$('.check').each(function(){
		   var checkbox = $(this);
		   if(checkbox.is(':checked') == true)
		   {
		   		checked = checked+checkbox.val()+",";		   		
		   }else
		   {
		   		unchecked = unchecked+checkbox.val()+",";
			}
		});
		
		checked = checked.substring(0, checked.length-1);
		unchecked = unchecked.substring(0, unchecked.length-1);
		$.ajax({
		    type: "GET",
		    url:"<?php echo $this->Html->url(array("controller"=>"roles", "action"=>"actualizarPaginaRoles"))?>",
		    data: {"id" : id,"checked" : checked, "unchecked" : unchecked},
		    async: true,
		    dataType: "json",
		    success: function( data ) {
		    	
				if(data != "")
				{
					$(function() {
		                setTimeout(function() {
		                    $.bootstrapGrowl("<strong>Página asignada</strong>", { type: 'success', align: 'center' });
		                }, 1);
		            });
					//$(".mensaje").html('<div class="alert alert-success alert-dismissible" in"="" fade="" role="alert"><button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button><h4>Paginas actualizadas</h4></div>');
				}		    	
		    	
		    }
		});						
	});
	
	$('#datatable').dataTable( {
        "sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
			"sLengthMenu": "Display _MENU_ records per page",
			"sZeroRecords": "Nothing found - sorry",
			"sInfo": "",
			"sInfoEmpty": "Showing 0 to 0 of 0 records",
			"sInfoFiltered": "(encontrados _MAX_ registros)",
			"sSearch": "Buscar:",
			"oPaginate": {
				"sFirst":    "Primero",
				"sPrevious": "« ",
				"sNext":     " »",
				"sLast":     "Último",
			}
		},
		"iDisplayLength": 25,
		"aoColumnDefs": [{"bSortable": false, "aTargets":[0]}] ,
		"fnPreDrawCallback": function(oSettings)
		{
			var id = "";
			id = "<?php echo $id; ?>";
			$.ajax({
			    type: "GET",
			    url:"<?php echo $this->Html->url(array("controller"=>"roles", "action"=>"consultaRoles"))?>",
			    data: {"idRol" : id},
			    async: true,
			    dataType: "json",
			    success: function( data ) {
					if(data != "")
					{
					    $.each(data, function(i, item){					    	
					    	$(".pagina-"+item.IdRol).prop('checked',true);
					    });
					}
			    }
			});	
		}
    });
		
		


    
</script>