<?php 
	if(!empty($paginasId))
	{
		echo json_encode($paginasId); 
	}
	else
	{
		echo "[]";
	}
	
?>