<?php

//Clase extendida de la clase controller
class recursosController extends Controller {

	private $_recursos;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_recursos = $this->loadModel('recursos');
    }

	//listado
	public function index() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'MENU RECURSOS';
			$this->_view->navegacion = '';
			$this->_view->renderizar('index', "recursos");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function banners() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'BANNERS / SLIDES';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->banners = $paginador->paginar($this->_recursos->getBanners(),1,1);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('banners'));

			$this->_view->renderizar('banners', "recursos");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicabanners() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->banners = $paginador->paginar($this->_recursos->getBanners(), $pagina,1);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('banners'));
        	$this->_view->renderizar('refrescar_listado_banners', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nuevo_banner() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Banner';
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

				
				$this->_recursos->nuevo_banner($this->getTexto('rol'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_banner', "recursos");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_banner($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('banners','recursos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_recursos->getbanner($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('banners','recursos');
	        }
			
			 $this->_view->datos = $this->_recursos->getbanner($this->filtrarInt($id));
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
					
					$this->_recursos->editar_banner($this->filtrarInt($id),
					$this->getTexto('rol'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_recursos->getbanner($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_banner',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarbanner($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('banners','recursos');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_recursos->getbanner($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('banners','recursos');
	        }

        	$this->_recursos->eliminar_banner($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }
	
}

?>
