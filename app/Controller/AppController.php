<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public function beforeFilter() {

       // $this->Session->write('Users.flag', "");

        if ($this->request->is('post'))
        {
			if(!empty($this->data["users"]))
			{
				$adServer = "ldap://cdf.local";
			    $ldap = ldap_connect($adServer);
			    $username = $this->data["users"]['usuario'];
			    $password = $this->data["users"]['clave'];

			    $ldaprdn = 'cdf' . "\\" . $username;

			    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
			    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

			    $bind = @ldap_bind($ldap, $ldaprdn, $password);

				if ($bind == 1)
				{
					$filter="(sAMAccountName=*)";
					$attributes = array("memberof","givenname");
					$result = ldap_search($ldap,"dc=cdf,dc=local",$filter);
					ldap_sort($ldap,$result,"sn");
					$info = ldap_get_entries($ldap, $result);

			        $filter="(sAMAccountName=$username)";

			        $result = ldap_search($ldap,"dc=cdf,dc=local",$filter);

			        ldap_sort($ldap,$result,"sn");

			        $info = ldap_get_entries($ldap, $result);
					//pr($info);
					$this->Session->write('Users', array(
						"nombre" =>$info[0]['cn'][0],
						'usuario'=>$info[0]['samaccountname'][0],
						'email'=>$info[0]['userprincipalname'][0],
						'flag' => 1
					));

			        @ldap_close($ldap);

			    }
			    else
			    {
			    	$this->Session->write('Users', array(
						"Nombre" =>"",
						'usuario'=>"",
						'email'=>"",
						'flag' => 0
					));
			    }
			}
		}

		if($this->Session->read('Users.flag') == 1 )
		{
			if($this->Session->read("Acceso") != NULL)
			{
				foreach($this->Session->read("Acceso") as $accesos)
				{
					if($accesos["controlador"] == $this->params->params["controller"] && $accesos["accion"] == $this->params->params["action"])
					{
						$permisoPagina = 1;
						$this->Session->write('Accesos', array("accesoPagina" => 1));
					}
				}	
			}

			$this->loadModel("User");
			$rolesUsuarios = $this->User->find("first", array(
				"conditions"=>array( "LOWER(User.usuario)" => mb_strtolower( $this->Session->read("Users.usuario"), 'UTF-8')),
//				"conditions"=>array("User.usuario"=>$this->Session->read("Users.usuario")),
				"fields"=>"User.roles_id",
				"recursive"=>-1
			));
				
			if(!empty($rolesUsuarios))
			{

				$idRoles = explode(",", $rolesUsuarios["User"]["roles_id"]);
				$this->loadModel("PaginasBotone");
				$this->loadModel("PaginasRole");

				if(!empty($idRoles))
				{
					$botonesPaginas = $this->PaginasRole->find("all", array(
						"conditions"=>array("PaginasRole.role_id"=>$idRoles, "Pagina.menu_id"=>8),
						"recursive"=> 0
					));
					$botones = "";
					$acciones = "";
					foreach($botonesPaginas as $botonesPaginas)
					{
						$botones[$botonesPaginas["Pagina"]["controlador"]][$botonesPaginas["Pagina"]["ejecucion_metodo"]][$botonesPaginas["Pagina"]["id"]] = array(
							"descripcion"=>$botonesPaginas["Pagina"]["alias"],
							"boton_controller"=>$botonesPaginas["Pagina"]["ejecucion_boton_controlador"],
							"boton_metodo"=>$botonesPaginas["Pagina"]["ejecucion_boton_metodo"],
							"boton_ruta"=>$botonesPaginas["Pagina"]["ejecucion_boton_ruta"],
							);
						$acciones[] = $botonesPaginas["Pagina"]["accion"];
					}
					$accionesbotones = "";
					if(!empty($acciones))
					{
						foreach($acciones as $accion)
						{
							$accionesbotones[] = $accion;
						}

						$this->loadModel("PaginasBotonesEstilo");
						
						$estilos = $this->PaginasBotonesEstilo->find("all", array(
							"conditions"=>array("PaginasBotonesEstilo.accion"=>$accionesbotones)
						));

						$estilosBotones = "";

						foreach($estilos as $estilo)
						{
							$estilosBotones[$estilo["PaginasBotonesEstilo"]["accion"]] = array(
								"clase"=>$estilo["PaginasBotonesEstilo"]["clase"],
								"icono"=>$estilo["PaginasBotonesEstilo"]["icono"]
							);							
						}
					}
					if(isset($botones[$this->params->controller])){
						$this->set("botones", $botones[$this->params->controller]);
						$this->set("estilosBotones", $estilosBotones);
					}
				}
			}
			
			if(empty($permisoPagina))
			{
				$this->Session->write('Accesos', array("accesoPagina" => 0));

			}
		}
    }

   public function acceso(){
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		CakeLog::write('actividad', $this->params['controller']. ' - '. $this->request->params['action']. ' - usuario ' .$this->Session->Read("PerfilUsuario.idUsuario")); 
	}
	
}
