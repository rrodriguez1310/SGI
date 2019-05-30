<?php
	if(isset($rolesAsociados))
	{
		echo json_encode($rolesAsociados);
	}
	else
	{
		echo "[]";
	}
	

?>