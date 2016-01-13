<?php

//Clase extendida de la clase controller
class configuracionController extends Controller {

	private $_configuracion;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_configuracion = $this->loadModel('configuracion');
    }

	//listado
	public function index() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Menu Configuracion';
			$this->_view->navegacion = '';
			$this->_view->renderizar('index', "configuracion");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function roles() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'ROLES';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->rol = $paginador->paginar($this->_configuracion->getRoles(),1,1);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('roles'));

			$this->_view->renderizar('roles', "configuracion");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicaroles() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->rol = $paginador->paginar($this->_configuracion->getRoles(), $pagina,1);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('roles'));
        	$this->_view->renderizar('refrescar_listado_roles', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nuevo_rol() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Rol';
			$this->_view->navegacion = '';

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('rol')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el rol';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_rol','configuracion');
					//Saca de la funcion principal
					exit;
				}

				
				$this->_configuracion->nuevo_rol($this->getTexto('rol'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_rol', "configuracion");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_rol($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('roles','configuracion');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_configuracion->getRol($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('roles','configuracion');
	        }
			
			 $this->_view->datos = $this->_configuracion->getRol($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
					if (!$this->getTexto('rol')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el rol';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_rol',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_configuracion->editar_rol($this->filtrarInt($id),
					$this->getTexto('rol'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_configuracion->getRol($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_rol',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarrol($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('roles','configuracion');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_configuracion->getRol($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('roles','configuracion');
	        }

        	$this->_configuracion->eliminar_rol($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }





    public function t_documentos() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'TIPOS DE DOCUMENTOS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->tdocumento = $paginador->paginar($this->_configuracion->getT_Documentos(),1,1);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('t_documentos'));

			$this->_view->renderizar('t_documentos', "configuracion");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicat_documentos() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->tdocumento = $paginador->paginar($this->_configuracion->getT_Documentos(), $pagina,1);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('t_documentos'));
        	$this->_view->renderizar('refrescar_listado_t_documentos', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nuevo_t_documento() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Tipo de Documento';
			$this->_view->navegacion = '';

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('tipo_doc')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_tipo_doc','configuracion');
					//Saca de la funcion principal
					exit;
				}

				
				$this->_configuracion->nuevo_t_doc($this->getTexto('tipo_doc'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_tipo_doc', "configuracion");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_t_documento($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('t_documentos','configuracion');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_configuracion->gett_documento($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('t_documentos','configuracion');
	        }
			
			 $this->_view->datos = $this->_configuracion->gett_documento($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
					if (!$this->getTexto('tipo_doc')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de doocumento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_t_doc',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_configuracion->editar_t_doc($this->filtrarInt($id),	$this->getTexto('tipo_doc'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_configuracion->gett_documento($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_t_doc',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminart_documento($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('t_documentos','configuracion');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_configuracion->gett_documento($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('t_documentos','configuracion');
	        }

        	$this->_configuracion->eliminar_t_documento($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }







    public function t_novedades() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'TIPOS DE NOVEDADES';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->t_nov = $paginador->paginar($this->_configuracion->getT_Novedades(),1,1);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('t_novedad'));

			$this->_view->renderizar('t_novedades', "configuracion");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicat_novedades() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->t_nov = $paginador->paginar($this->_configuracion->getT_Novedades(), $pagina,1);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('t_novedad'));
        	$this->_view->renderizar('refrescar_listado_t_novedades', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nuevo_t_novedad() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Tipo de Novedad';
			$this->_view->navegacion = '';

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('nombre')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de novedad';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_t_novedad','configuracion');
					//Saca de la funcion principal
					exit;
				}

				
				$this->_configuracion->nuevo_t_nov($this->getTexto('nombre'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_t_novedad', "configuracion");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_t_novedad($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('t_novedades','configuracion');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_configuracion->gett_novedad($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('t_novedades','configuracion');
	        }
			
			 $this->_view->datos = $this->_configuracion->gett_novedad($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
					if (!$this->getTexto('nombre')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de novedad';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_t_novedad',false,true);
					//Saca de la funcion principal
					exit;
				}

					if (!$this->getInt('estado')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el estado del tipo de novedad';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_t_novedad',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_configuracion->editar_t_nov($this->filtrarInt($id),
					$this->getTexto('nombre'),
					$this->getInt('estado'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_configuracion->gett_novedad($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_t_novedad',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminart_novedad($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('t_novedades','configuracion');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_configuracion->gett_novedad($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('t_novedades','configuracion');
	        }

        	$this->_configuracion->eliminar_t_nov($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }


	
}

?>
