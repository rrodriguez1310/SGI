<?php 
	if(!empty($listaMediaJson))
	{
		echo json_encode($listaMediaJson);
	}
	else
	{
		echo "[]";
	}
?>