<?php

App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController {
public function login($usuario = null, $clave = null) {
    $this->layout = "login";
    
    if ($this->request->is('post')) {
        if ($this->Session->read('Users.flag') == "0") {
            $this->Session->setFlash('El usuario o clave son incorrectos', 'msg_fallo');
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        
        if($this->Session->read('Users.flag') == "1") {
            
            $this->loadModel("PaginasRole");
            $this->loadModel("Pagina");
            $this->loadModel("Menu");
            
            $nombreUsuario = $this->User->find('first', array(
            'conditions'=>array('User.nombre'=>$this->Session->read("Users.nombre")),
            'recursive'=>-1
            ));
            
            $idRolesUsuarios = "";
            
            if(!empty($nombreUsuario))
            {
                $usuarioSession = $this->Session->read("Users");
                
                $usuarioSession["trabajadore_id"] = $nombreUsuario["User"]["trabajadore_id"];
                
                $this->Session->write("Users", $usuarioSession);
                
                $idRolesUsuarios = explode(",", $nombreUsuario["User"]["roles_id"]);
                $this->Session->write("RolesUsuarios", $idRolesUsuarios);
                
                $this->Session->write("PerfilUsuario",
                array(
                "idUsuario"=>$nombreUsuario["User"]["id"],
                "roleId"=>$nombreUsuario["User"]["role_id"],
                "trabajadoreId"=>$nombreUsuario["User"]["trabajadore_id"],
                )
                );
            }
            else
            {
                $this->Session->setFlash("Ocurrio un error al intentar ingresar, comuniquese con el administrador del sitio", "msg_fallo");
                return $this->redirect(array('controller'=>'users', 'action' => 'login'));
            }
            
            if(!empty($idRolesUsuarios))
            {
                CakeLog::write('actividad', 'ingreso el usuario - ' . $nombreUsuario["User"]["id"]);
                $idPaginas = $this->PaginasRole->find("all", array(
                "conditions"=>array("PaginasRole.role_id"=>$idRolesUsuarios),
                'fields'=>"PaginasRole.pagina_id",
                "recursive"=>-1
                ));
                
                $paginasId = "";
                foreach($idPaginas as $dataPaginas)
                {
                    $paginasId[] =  $dataPaginas["PaginasRole"]["pagina_id"];
                }
                
                $paginas = $this->Pagina->find("all", array(
                "conditions"=>array("Pagina.id"=>$paginasId),
                "recursive"=>-1
                ));
                
                $nombreMenus = "";
                
                $menus = $this->Menu->find("list",array(
                "fields"=>array("Menu.id", "Menu.nombre")
                ));
                
                $menusPaginas = "";
                $menusSecundarios = "";
                $acceso = "";
                
                foreach($paginas as $paginasMenus)
                {
                    
                    $linkMenu = explode(",", $paginasMenus["Pagina"]["nombre_link"]);
                    $link = $linkMenu[0];
                    
                    if($menus[$paginasMenus["Pagina"]["menu_id"]] != "Secundario")
                    {
                        /*$linkMenu = explode(",", $paginasMenus["Pagina"]["nombre_link"]);
                        $link = $linkMenu[0];*/
                        if(count($linkMenu) > 1)
                        {
                            unset($linkMenu[0]);
                        }
                        $menusPaginas[$menus[$paginasMenus["Pagina"]["menu_id"]]][$link][] = array(
                        "idMenu"=>$paginasMenus["Pagina"]["menu_id"],
                        "nombreLink"=>$linkMenu,
                        "contadorMenu"=>count($linkMenu),
                        "controlador"=>$paginasMenus["Pagina"]["controlador"],
                        "accion"=>$paginasMenus["Pagina"]["accion"],
                        );
                    }
                    else
                    {
                        $menusSecundarios[$menus[$paginasMenus["Pagina"]["menu_id"]]][$link][] = array(
                        "idPagina"=>$paginasMenus["Pagina"]["id"],
                        "idMenu"=>$paginasMenus["Pagina"]["menu_id"],
                        "controlador"=>$paginasMenus["Pagina"]["controlador"],
                        "accion"=>$paginasMenus["Pagina"]["accion"],
                        "accionFantasia"=>$paginasMenus["Pagina"]["accion_fantasia"],
                        );
                    }
                    $acceso[] = array("controlador"=>$paginasMenus["Pagina"]["controlador"], "accion"=>$paginasMenus["Pagina"]["accion"]);
                }
            }
            
            array_multisort($menusPaginas);
            
            $this->Session->write("Acceso", $acceso);
            $this->Session->write("Menus", $menusPaginas);
            $this->Session->write("BotonesSecundarios", $menusSecundarios);
            
            
            if(empty($nombreUsuario["User"]["usuario"]) && !empty($nombreUsuario["User"]["nombre"]))
            {
                
                CakeLog::write('actividad', 'ingreso el usuario - ' . $nombreUsuario["User"]["usuario"]);
                
                $this->request->data["id"] = $nombreUsuario["User"]["id"];
                $this->request->data["nombre"] = $this->Session->read('Users.nombre');
                $this->request->data["usuario"] = $this->Session->read('Users.usuario');
                $this->request->data["email"] = $this->Session->read('Users.email');
                //por aqui pasa
                
                
                if ($this->User->save($this->request->data))
                {
                    
                    CakeLog::write('actividad', 'ingreso el usuario - ' . $nombreUsuario["User"]["usuario"]);
                    $this->redirect(array('controller'=>'dashboards',  'action' => 'bienvenida'));
                }
            }
            else if(!empty($nombreUsuario["User"]["usuario"]) && !empty($nombreUsuario["User"]["nombre"]))
            {
                CakeLog::write('actividad', 'ingreso el usuario - ' . $nombreUsuario["User"]["usuario"] );
                $this->redirect(array('controller'=>'dashboards',  'action' => 'index'));
            }
            else
            {
                $this->Session->setFlash("Usted no tiene permiso para entrar al sistema comuniquese con el administrador", "msg_fallo");
                return $this->redirect(array('controller'=>'users', 'action' => 'login'));
            }
        }
    }
}
    
    public function logout() {
        
        CakeLog::write('actividad', 'fin sesion el usuario - ' . $this->Session->read('Users.nombre'));
        $this->Session->destroy();
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }
    
    public function add() {
        
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
        
        if ($this->Session->read('Users.flag') == 1) {
            
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data["User"]["estado"] = 1;

                //pr($this->request->data["User"]);exit;
			
				$this->loadModel("Trabajadore");
				$trabajadoresArray = $this->Trabajadore->find('first', array(
                    'conditions' => array('Trabajadore.id' =>$this->request->data["User"]["trabajadore_id"]),
                    'fields' => array('Trabajadore.email', 'Trabajadore.nombre','Trabajadore.apellido_paterno', 'Trabajadore.apellido_materno'), 
                    'order'=>array("Trabajadore.nombre ASC"
                )));
				$email = $trabajadoresArray["Trabajadore"]["email"];
                $url = Router::fullbaseUrl().$this -> webroot;
					
                if ($this->User->save($this->request->data)) {
					
                    CakeLog::write(   'actividad', 'se creo el usuario - ' . $this->request->data["User"]["nombre"] . ' - ' .$this->Session->read('Users.nombre'));
                    
                    $this->loadModel("ActividadUsuario");
                    $usuario = $this->Session->read("PerfilUsuario.idUsuario");
                    $mensaje = "Se crea usuario para ".$this->request->data["User"]["nombre"]." con ID ".$this ->User ->id;
                    $log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
                    $this->ActividadUsuario->save($log);

                    $Email = new CakeEmail("gmail");
                    $Email->from(array('rrhh@cdf.cl' => 'Recursos Humanos'));
                    $Email->to($email);
                    $Email->subject('Inducción Corporativa CDF');
                    $Email->emailFormat('html');
                    $Email->template('recordatorio_primer_ingreso');  
                    $Email->viewVars(array(
			        "url"=>$url,));              
                    $Email->send();
                    
                    $this->Session->setFlash('El usuario fue ingresado correctamente', 'msg_exito');
                    return $this->redirect(array('action' => 'index'));
                } else {
					$this->Session->setFlash('El usuario no fue agregado', 'msg_fallo');
                }
            }
            $this->set('usuarios', array());
            $adServer = "ldap://cdf.local";
            $ldap = ldap_connect($adServer);
            $username = "desarrollo01";
            $password = "Canalcdf123";
            
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
                
                $usuarios[""]="";                
                
                foreach($info as $infos)
                {
                    if($infos["objectclass"][0] == "top" && $infos["objectclass"][1]=="person" && $infos["objectclass"][2] == "organizationalPerson" && $infos["objectclass"][3] == "user" && !isset($infos["objectclass"][4]))
                    {
                        $usuarios[$infos['cn'][0]]=$infos['cn'][0];
                    }
                }
                               
                $this->set('usuarios', $usuarios);
            }

            $this->loadModel("Trabajadore");
            $trabajadoresArray = $this->Trabajadore->find('all', array('fields' => array('Trabajadore.id', 'Trabajadore.nombre','Trabajadore.apellido_paterno', 'Trabajadore.apellido_materno'), 'order'=>array("Trabajadore.nombre ASC")));
            foreach($trabajadoresArray as $trabajador)
            {
                $trabajadores[$trabajador["Trabajadore"]["id"]] = $trabajador["Trabajadore"]["nombre"]." ".$trabajador["Trabajadore"]["apellido_paterno"]." ".$trabajador["Trabajadore"]["apellido_materno"];
            }
            $trabajadores = array(""=>"")+$trabajadores;
            $this->set('trabajadores', $trabajadores);
        } else {
            $this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
            return $this->redirect(array("controller" => 'users', "action" => 'login'));
        }
    }
    
    public function edit($id = null) {
        
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
        
        if ($this->Session->read('Users.flag') == 1) {
            if (!$this->User->exists($id)) {
                throw new NotFoundException(__('Usuario no existe'));
            }
            
            if ($this->request->is(array('post', 'put'))) {
                
                if ($this->User->save($this->request->data)) {
                    $this->loadModel("ActividadUsuario");
                    $usuario = $this->Session->read("PerfilUsuario.idUsuario");
                    $mensaje = 'Se modifica usuario "'.$this->request->data["User"]["nombre"].'" con ID '.$this->request->data["User"]["id"];
                    $log["ActividadUsuario"] = array("descripcion"=>$mensaje, "user_id"=>$usuario);
                    $this->ActividadUsuario->save($log);
                    $this->Session->setFlash('El usuario fue editado correctamente', 'msg_exito');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('El usuario no fue editado', 'msg_fallo');
                }
            } else {
                $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
                $this->request->data = $this->User->find('first', $options);
                
            }
            
            $adServer = "ldap://cdf.local";
            $ldap = ldap_connect($adServer);
            $username = "desarrollo01";
            $password = "Canalcdf123";
            
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
                //pr($info);exit;
                $usuarios[""]="";
                
                foreach($info as $infos)
                {
                    if($infos["objectclass"][0] == "top" && $infos["objectclass"][1]=="person" && $infos["objectclass"][2] == "organizationalPerson" && $infos["objectclass"][3] == "user" && !isset($infos["objectclass"][4]))
                    {
                        $usuarios[$infos['cn'][0]]=$infos['cn'][0];
                        
                    }
                }
                $this->set('usuarios', $usuarios);
            }
            
            $this->loadModel("Trabajadore");
            $trabajadoresArray = $this->Trabajadore->find('all', array('conditions'=>array('Trabajadore.estado !='=>'Retirado'), 'fields' => array('Trabajadore.id', 'Trabajadore.nombre','Trabajadore.apellido_paterno', 'Trabajadore.apellido_materno'), 'order'=>array("Trabajadore.nombre ASC")));
            foreach($trabajadoresArray as $trabajador)
            {
                $trabajadores[$trabajador["Trabajadore"]["id"]] = $trabajador["Trabajadore"]["nombre"]." ".$trabajador["Trabajadore"]["apellido_paterno"]." ".$trabajador["Trabajadore"]["apellido_materno"];
            }
            $trabajadores = array(""=>"")+$trabajadores;
            $this->set('trabajadores', $trabajadores);
            $roles = $this->User->Role->find('list', array('fields' => array('Role.id', 'Role.nombre'), 'conditions'=>array('Role.id !=' => 2)));
            $this->set('roles', $roles);
        } else {
            $this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
            return $this->redirect(array("controller" => 'users', "action" => 'login'));
        }
    }
    
    public function roles_usuario()
    {
        $this->layout = "ajax";
        //$this->response->type('json');
        
        $usuarios = $this->User->find('first', array(
        "conditions"=>array("User.id"=>$this->params->query["usuarioId"]),
        "fields"=>array("User.roles_id"),
        "recursive"=>-1
        ));
        
        $this->set("idRolesUsuarios", $usuarios["User"]["roles_id"]);
    }
    
    
    public function lista_usuarios_json() {
        /*
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
        **/
        
        $this->layout = "ajax";
        $this->response->type('json');
        $usuarios = $this->User->find('all', array(
        "fields"=>array("User.id", "User.nombre", "User.roles_id", "Role.id", "Role.nombre", "User.trabajadore_id"),
        "conditions"=>array("User.estado"=>1)
        ));
        
        if(!empty($usuarios))
        {
            $usuariosJson = "";
            foreach($usuarios as $usuario)
            {
                $usuariosJson[] = array(
                "UsuarioId"=>$usuario["User"]["id"],
                "UsuarioNombre"=>$usuario["User"]["nombre"],
                "UsuarioRolesId"=>$usuario["User"]["roles_id"],
                "RoleId"=>$usuario["Role"]["id"],
                "RoleNombre"=>$usuario["Role"]["nombre"],
                "trabajadore_id"=>$usuario["User"]["trabajadore_id"]
                );
            }
        }
        $this->set('usuariosJson', $usuariosJson);
    }
    
    public function index() {
        
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
        
        $this->layout = "angular";
        /*
        $usuarios = $this->User->find('all');
        
        $this->set('usuarios', $usuarios);
        *
        */
    }
    
    public function delete() {
        
        $this->autoRender = false;
        $this->response->type("json");
        if($this->Session->Read("Users.flag") == 1)
        {
            if($this->Session->Read("Accesos.accesoPagina") == 1)
            {
                if($this->request->isPost()){
                    if($this->User->save($this->request->data)){
                        CakeLog::write('actividad', 'Elimino - Usuarios - Delete - '.$this->User->id.' el usuario ' .$this->Session->Read("PerfilUsuario.idUsuario"));
                        $respuesta = array(
                        "estado"=>1,
                        "mensaje"=>"Se elimino el usuario correctamente"
                        );
                    }else{
                        $respuesta = array(
                        "estado"=>0,
                        "mensaje"=>"No se pudo eliminar el usuario, por favor intentelo nuevamente"
                        );
                    }
                }
            }else{
                $respuesta = array(
                "estado"=>0,
                "mensaje"=>"No tiene acceso a la pagina solicitada"
                );
            }
        }
        else
        {
            $respuesta = array(
            "estado"=>0,
            "mensaje"=>'Primero inicie Sesión'
            );
        }
        return json_encode($respuesta);
    }
    
    public function validacion()
    {
        $this->layout = "ajax";
        $usuarios = $this->User->find('all');
        $this->set('usuarios', $usuarios);
        echo json_encode($usuarios);
        
    }
    
    public function fallo()
    {
        $this->layout = "sin_acceso";
    }
    
    
    public function add_roles_usuarios()
    {
        $this->layout = "ajax";
        $this->response->type('json');
        $estado = "";
        
        if(!empty($this->params->query["usuarioId"]))
        {
            $existe = $this->User->find("first", array(
            "conditions"=>array("User.id"=>$this->params->query["usuarioId"], "User.roles_id"=>$this->params->query["rolesId"]),
            "fields"=>array("User.id"),
            "recursive"=>0
            ));
            
            if(empty($existe))
            {
                $this->request->data["User"]["id"] = $this->params->query["usuarioId"];
                $this->request->data["User"]["roles_id"] = $this->params->query["rolesId"];
                $this->User->save($this->request->data);
                $estado = array("Error"=>1, "Mensaje"=>"ROL ASOCIADO CORRECTAMENTE");
            }
            else
            {
                $estado = array("Error"=>1, "Mensaje"=>"NO SE PUDO GUARDAR, LA ASOCIACIÓN DE ROLES ES IGUAL A LA QUE YA ESTA REGISTRADA");
            }
        }
        else
        {
            $estado = array("Error"=>0, "Mensaje"=>"NO SE PUEDE REGISTRAR. SELECCIONE AL MENOS USUARIO Y UN ROL");
        }
        
        $this->set("estado", $estado);
    }
}
?>
