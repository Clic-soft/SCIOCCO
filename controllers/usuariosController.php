<?php

//Clase extendida de la clase controller
class usuariosController extends Controller {

	private $_usuarios;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_usuarios = $this->loadModel('usuarios');
    }

	public function index() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'USUARIOS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->usuario = $paginador->paginar($this->_usuarios->getUsuarios(),1,1);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('usuarios'));

			$this->_view->renderizar('index', "usuarios");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicausuarios() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->usuario = $paginador->paginar($this->_usuarios->getUsuarios(), $pagina,1);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('usuarios'));
        	$this->_view->renderizar('refrescar_listado_usuarios', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nuevo_usuario() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Usuario';
			$this->_view->navegacion = '';

			$this->_view->roles = $this->_usuarios->getroles();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('usuario')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el rol';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_usuario','usuarios');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('pass')) {
	                //Si no cumple la validacion sale mensaje de error
	                $this->_view->_error = 'Debe introducir su contrase&ntilde;a';
	                //Vista de la pagina actual
	                $this->_view->renderizar('nuevo_usuario','usuarios');
	                //Saca de la funcion principal
	                exit;
            	}

            	if (!$this->getSql('repitepass')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar la contrase&ntilde;a nuevamente.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('nuevo_usuario','usuarios');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('id_rol') || $this->getInt('id_rol')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el rol';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_usuario','usuarios');
					//Saca de la funcion principal
					exit;
				}

				//Se valida que las dos contraseñas digitadas coincidan
				if (!$this->_usuarios->validarPassword($this->getSql('pass'), $this->getSql('repitepass'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Las contrase&ntilde;as no coiniciden';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_usuario','usuarios');
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_usuarios->validarusuario($this->getTexto('usuario'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El nombre de usuario ya existe';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_usuario','usuarios');
					//Saca de la funcion principal
					exit;
				}	

				
				$this->_usuarios->crear_usuario($this->getTexto('usuario'),$this->getSql('pass'),$this->getInt('id_rol'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_usuario', "usuarios");
		} else {
      		$this->redireccionar('admin');
      	}
	}
	
}

?>
