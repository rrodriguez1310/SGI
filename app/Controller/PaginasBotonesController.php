<?php
App::uses('AppController', 'Controller');

class PaginasBotonesController extends AppController {

	public function botones_roles()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		if(!empty($this->params->query["paginaId"]) && !empty($this->params->query["rolId"]))
		{
			$idPaginas = $this->PaginasBotone->find("all", array(
				"conditions"=>array("PaginasBotone.pagina_id"=>$this->params->query["paginaId"], "PaginasBotone.role_id"=>$this->params->query["rolId"]),
				"fields"=>"PaginasBotone.boton_id",
				"recursive"=>-1
			));

			$paginasId = "";

			foreach($idPaginas as $idPaginas)
			{
				$paginasId[] = $idPaginas["PaginasBotone"]["boton_id"];
			}

			$this->set("paginasId", $paginasId);
		}
		else
		{
			$estado = array("Error"=>0, "Mensaje"=>"LA ASOCIACIÓN NO SE PUEDE REGISTRAR");
		}

		
	}

	public function add()
	{
		$this->layout = "ajax";
		$this->response->type('json');

		$estado = "";
		if(!empty($this->params->query["botonesId"]) && !empty($this->params->query["paginaId"]) && !empty($this->params->query["rolId"]))
		{
			$idBotones = explode(",", $this->params->query["botonesId"]);
			
			$existe = $this->PaginasBotone->find("all", array(
				'conditions'=>array(
					"PaginasBotone.pagina_id"=>$this->params->query["paginaId"],
					"PaginasBotone.role_id"=>$this->params->query["rolId"],
					"PaginasBotone.boton_id"=>$idBotones
				),
				"recursive"=>-1
			));

			if(empty($existe))
			{
				$paginasBotones = "";
				foreach($idBotones as $idBotones)
				{
					$paginasBotones[] = array(
						"pagina_id"=>$this->params->query["paginaId"],
						"boton_id"=>$idBotones,
						"role_id"=>$this->params->query["rolId"]
					);
				}

				if($this->PaginasBotone->saveAll($paginasBotones))
				{
					$estado = array("Error"=>1, "Mensaje"=>"LA ASOCIACIÓN FUE REGISTRADA");
				}
				else
				{
					$estado = array("Error"=>0, "Mensaje"=>"LA ASOCIACIÓN NO SE PUEDE REGISTRAR");
				}
			}
			else
			{
				$estado = array("Error"=>0, "Mensaje"=>"LA ASOCIACIÓN YA EXISTE");
			}
		}

		$this->set("estado", $estado);
	}

	public function delete()
	{
		$this->layout = "ajax";
		$this->response->type('json');

		if(!empty($this->params->query["botonesId"]) && !empty($this->params->query["paginaId"]) && !empty($this->params->query["rolId"]))
		{
			
			$idBotones = explode(",", $this->params->query["botonesId"]);
			$idPaginasBotones = $this->PaginasBotone->find("all", array(
				'conditions'=>array(
					"PaginasBotone.pagina_id"=>$this->params->query["paginaId"],
					"PaginasBotone.role_id"=>$this->params->query["rolId"],
					"PaginasBotone.boton_id"=>$idBotones
				),
				"fields"=>"PaginasBotone.id",
				"recursive"=>-1
			));
			
			$id = "";
			foreach($idPaginasBotones as $idPaginasBotone)
			{
				$id["PaginasBotone.id"][] = $idPaginasBotone["PaginasBotone"]["id"];
			}


			if($this->PaginasBotone->deleteAll($id))
			{
				$estado = array("Error"=>1, "Mensaje"=>"LA ASOCIACIÓN FUE REGISTRADA");
			}

		}
		else
		{
			$estado = array("Error"=>0, "Mensaje"=>"LA ASOCIACIÓN NO SE PUEDE REGISTRAR");
		}

		/*
		$estado = "";
		if(!empty($this->params->query["botonesId"]) && !empty($this->params->query["paginaId"]) && !empty($this->params->query["rolId"]))
		{
			
			
			$existe = $this->PaginasBotone->find("all", array(
				'conditions'=>array(
					"PaginasBotone.pagina_id"=>$this->params->query["paginaId"],
					"PaginasBotone.role_id"=>$this->params->query["rolId"],
					"PaginasBotone.boton_id"=>$idBotones
				),
				"recursive"=>-1
			));

			if(empty($existe))
			{
				$paginasBotones = "";
				foreach($idBotones as $idBotones)
				{
					$paginasBotones[] = array(
						"pagina_id"=>$this->params->query["paginaId"],
						"boton_id"=>$idBotones,
						"role_id"=>$this->params->query["rolId"]
					);
				}

				if($this->PaginasBotone->saveAll($paginasBotones))
				{
					$estado = array("Error"=>1, "Mensaje"=>"LA ASOCIACIÓN FUE REGISTRADA");
				}
				else
				{
					$estado = array("Error"=>0, "Mensaje"=>"LA ASOCIACIÓN NO SE PUEDE REGISTRAR");
				}
			}
			else
			{
				$estado = array("Error"=>0, "Mensaje"=>"LA ASOCIACIÓN YA EXISTE");
			}
		}

		$this->set("estado", $estado);
		*/
	}


}