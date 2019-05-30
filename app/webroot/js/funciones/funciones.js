
/* Psandole el ID de la gerencia, buscaara las areas asociadas*/
function buscaAreas(gerencia)
{
	$.getJSON("",{'gerencia':gerencia},function(data,status){
				if(data == 1)
				{
					$("#CargoAreaId option").remove();
					$("#CargoAreaId").css("border", "1px solid #FF8570");
				}else
				{
					$("#CargoAreaId").css("border", "");
					$("#CargoAreaId option").remove();
					$("#CargoAreaId").append('<option value=""></option>');
					$.each(data, function(i,item)
					{
						$("#CargoAreaId").append('<option value="'+item.Id+'">'+item.Nombre+'</option>');
					});
				}
	  		});	
}

/* Psandole el ID del area, buscara los cargos asociados */

function buscaCargos(area)
{
	$.getJSON("<?php echo $this->Html->url(array('controller'=>'Servicios', 'action'=>'buscaCargos')); ?>",{'area':area},function(data,status){
				if(data == 1)
				{
					$("#CargoAreaId option").remove();
					$("#CargoAreaId").css("border", "1px solid #FF8570");
				}else
				{
					$("#CargoAreaId").css("border", "");
					$("#CargoAreaId option").remove();
					$("#CargoAreaId").append('<option value=""></option>');
					$.each(data, function(i,item)
					{
						$("#CargoAreaId").append('<option value="'+item.Id+'">'+item.Nombre+'</option>');
					});
				}
	  		});	
}