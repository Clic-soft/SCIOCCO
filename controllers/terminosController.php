<?php

//Clase extendida de la clase controller
class terminosController extends Controller {

	private $_terminos;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_terminos = $this->loadModel('terminos');
    }

	//listado
	public function index() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Terminos';
			$this->_view->navegacion = '';

	//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->terminos = $paginador->paginar($this->_terminos->get_terminos(),1,1);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('terminos'));

			$this->_view->renderizar('index', "terminos");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicaterminos() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->terminos = $paginador->paginar($this->_terminos->get_terminos(),$pagina,1);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('terminos'));
        	$this->_view->renderizar('refrescar_listado_terminos', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nuevo_termino() {
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
					$this->_view->renderizar('nuevo_termino','terminos');
					//Saca de la funcion principal
					exit;
				}

				if (!$_POST['descripcion']) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el contenido';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_termino','terminos');
					//Saca de la funcion principal
					exit;
				}
				
				$this->_terminos->nuevo_termino(
					$this->getTexto('nombre'),
					$_POST['descripcion']);
				
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_termino', "terminos");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_termino($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','terminos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_terminos->get_termino($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','terminos');
	        }
			
			 $this->_view->termino = $this->_terminos->get_termino($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
					if (!$this->getTexto('nombre')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el titulo';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_termino',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$_POST['descripcion']) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el contenido';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_termino',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_terminos->editar_termino($this->filtrarInt($id),
					$this->getTexto('nombre'),
					$_POST['descripcion']);
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->info = $this->_terminos->get_termino($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_termino',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminar_termino($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','terminos');
	        }

			//Si no existe un registro con ese id
			if (!$this->_terminos->get_termino($this->filtrarInt($id))) {
				$this->redireccionar('index','terminos');
			}

        	$this->_terminos->eliminar_termino($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }

}

?>
