<?php

//Clase extendida de la clase controller
class empresaController extends Controller {

	private $_empresa;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_empresa = $this->loadModel('empresa');
    }

	//listado
	public function index() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Menu Empresa';
			$this->_view->navegacion = '';
			$this->_view->renderizar('index', "empresa");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function datos() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Datos Empresariales';
			$this->_view->navegacion = '';

			$this->_view->datos = $this->_empresa->getDatosEmpresa(1);

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan
				if (!$this->getInt('nit')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nit';
					//Vista de la pagina actual
					$this->_view->renderizar('datos','empresa');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('razon_social')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la razon social';
					//Vista de la pagina actual
					$this->_view->renderizar('datos','empresa');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('rep_comercial')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre del representante comercial';
					//Vista de la pagina actual
					$this->_view->renderizar('datos','empresa');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('num_contacto')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de contacto';
					//Vista de la pagina actual
					$this->_view->renderizar('datos','empresa');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('direccion')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la dirreccion';
					//Vista de la pagina actual
					$this->_view->renderizar('datos','empresa');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('email_contacto')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el Email de contacto';
					//Vista de la pagina actual
					$this->_view->renderizar('datos','empresa');
					//Saca de la funcion principal
					exit;
				}
				
				$this->_empresa->ActualizarDatosEmpresa(1,
					$this->getInt('nit'),
					$this->getTexto('razon_social'),
					$this->getTexto('rep_comercial'),
					$this->getInt('num_contacto'),
					$this->getInt('celular'),
					$this->getSql('direccion'),
					$this->getSql('email_contacto'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
			}
			
			$this->_view->datos = $this->_empresa->getDatosEmpresa(1);

			$this->_view->renderizar('datos', "empresa");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function info_emp() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Informacion Empresarial';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->info = $paginador->paginar($this->_empresa->getinfoemp(),1,1);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('info_emp'));

			$this->_view->renderizar('info_emp', "empresa");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicainfoempresa() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->info = $paginador->paginar($this->_empresa->getinfoemp(), $pagina,1);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('info_emp'));
        	$this->_view->renderizar('refrescar_listado_info_emp', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nueva_info() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Información Empresarial Nueva';
			$this->_view->navegacion = '';

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('nombre')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el titulo';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_info_emp','empresa');
					//Saca de la funcion principal
					exit;
				}

				if (!$_POST['descripcion']) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el contenido';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_info_emp','empresa');
					//Saca de la funcion principal
					exit;
				}
				
				$this->_empresa->nueva_info_emp(
					$this->getTexto('nombre'),
					$_POST['descripcion']);
				
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nueva_info_emp', "empresa");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_info_emp($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('info_emp','empresa');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_empresa->getinfo_emp($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('info_emp','empresa');
	        }
			
			 $this->_view->info = $this->_empresa->getinfo_emp($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
					if (!$this->getTexto('nombre')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el titulo';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_info_emp',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$_POST['descripcion']) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el contenido';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_info_emp',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_empresa->editar_info_emp($this->filtrarInt($id),
					$this->getTexto('nombre'),
					$_POST['descripcion']);
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->info = $this->_empresa->getinfo_emp($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_info_emp',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarinfoempresa($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('info_emp','empresa');
	        }

			//Si no existe un registro con ese id
			if (!$this->_empresa->getinfo_emp($this->filtrarInt($id))) {
				$this->redireccionar('info_emp','empresa');
			}

        	$this->_empresa->eliminar_info_emp($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }


	public function redes_sociales() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Redes Sociales Empresariales';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->red = $paginador->paginar($this->_empresa->getredes_sociales(),1,1);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('redes_sociales'));

			$this->_view->renderizar('redes_sociales', "empresa");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicaredes_sociales() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->red = $paginador->paginar($this->_empresa->getredes_sociales(), $pagina,1);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('redes_sociales'));
        	$this->_view->renderizar('refrescar_listado_redes_sociales', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nueva_red_social() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nueva red social';
			$this->_view->navegacion = '';

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('nombre')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre de la red social';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_red_social','empresa');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('url')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la url de la red social';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_red_social','empresa');
					//Saca de la funcion principal
					exit;
				}
				
				$this->_empresa->nueva_red_social(
					$this->getTexto('nombre'),
					$this->getSql('url'));
				
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nueva_red_social', "empresa");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_red_social($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('redes_sociales','empresa');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_empresa->getred_social($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('redes_sociales','empresa');
	        }
			
			 $this->_view->red = $this->_empresa->getred_social($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
					if (!$this->getTexto('nombre')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre de la red social';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_red_social',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('url')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la url de la red social';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_red_social',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_empresa->editar_red_social($this->filtrarInt($id),
					$this->getTexto('nombre'),
					$this->getSql('url'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->red = $this->_empresa->getred_social($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_red_social',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarred_social($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('redes_sociales','empresa');
	        }

			//Si no existe un registro con ese id
			if (!$this->_empresa->getred_social($this->filtrarInt($id))) {
				$this->redireccionar('redes_sociales','empresa');
			}

        	$this->_empresa->eliminar_red_social($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }		
}

?>
