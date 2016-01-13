<?php

//Clase extendida de la clase controller
class adminController extends Controller {

    private $_admin;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_admin = $this->loadModel('admin');
    }

	//listado
	public function index() {
		Session::set('modulo', "admin");
			$this->_view->titulo = 'Inicio de sesi&oacute;n';
			$this->_view->navegacion = '';

		
		/*if (Session::get('autenticado_adminsciocco')) {
            //Se redirecciona a otra página
            $this->redireccionar('panel');
        }*/
		
        if ($this->getInt('enviar') == 1) {
            //Se obtiene los datos  por  post
            $this->_view->datos = $_POST;

            //Se valida que en el campo haya un dato y un alfanúmerico
            if (!$this->getAlphaNum('usuario')) {
                //Si no cumple la validacion sale mensaje de error
                $this->_view->_error = 'Debe introducir su usuario';
                //Vista de la pagina actual
                $this->_view->renderizar('login','admin');
                //Saca de la funcion principal
                exit;
            }
            //Se valida el dato
            if (!$this->getSql('pass')) {
                //Si no cumple la validacion sale mensaje de error
                $this->_view->_error = 'Debe introducir su contrase&ntilde;a';
                //Vista de la pagina actual
                $this->_view->renderizar('login','admin');
                //Saca de la funcion principal
                exit;
            }

            //Si pasa todas las validaciones se trae el usuario
            $row = $this->_admin->getUsuario(
                    $this->getAlphaNum('usuario'), 
                    $this->getSql('pass'),
                    1
            );

            //Si no cumple con la validación
            if (!$row) {	
                //Sale mensaje de error
                $this->_view->_error = 'Usuario y/o contrase&ntilde;a incorrectos';
                //Se renderiza a el login
                $this->_view->renderizar('login','admin');
                //Saca de la funcion principal				
                exit;
            }
            
            if ($row->estado==0){
                //Sale mensaje de error
                $this->_view->_error = 'Este usuario se encuentra inactivo';
                //Se renderiza a el login
                $this->_view->renderizar('login','admin');
                //Saca de la funcion principal
                exit;
            }


            /*$bitacora_inicio = $this->_login->bitacora_login(
                    $row->id_usuario
            );*/						
            //Se crean variables de sesión
            Session::set('autenticado_adminsciocco', true);
            //tipo de usuario
            Session::set('tipo_usuario', $row->id_rol);
			//usuario del afiliado
			Session::set('usuario', $row->usuario);
			// id del usuario
			Session::set('id_usuario', $row->id);
			
			$this->redireccionar('panel');	
		}
		
		$this->_view->renderizar('login','admin');   				    
	}
	

    //Función para cerrar la sesión
    public function cerrar() {
		
	   $bitacora_inicio_cerrar = $this->_admin->bitacora_login_cerrar(
			Session::Get('id_usuario')
		);	
        //Se destruyen todas las variables de sesión
        Session::destroy();
        //Se redirecciona a otra página
        $this->redireccionar('principal/principal');
    }
		
}

?>
