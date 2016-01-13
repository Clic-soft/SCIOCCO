<?php

//Clase extendida de la clase controller
class loginController extends Controller {

    private $_login;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_login = $this->loadModel('login');
    }

	//listado
	public function index() {
			
			$this->_view->titulo = 'Inicio de sesi&oacute;n';
			$this->_view->navegacion = '';
	}

	public function login() {
		
		if (Session::get('autenticado_paginwebacemcop')) {
            //Se redirecciona a otra página
            $this->redireccionar('micuenta');
        }
		
		 
		
		if(isset($_GET["modulo"])){
				$modulo=$_GET["modulo"];	
			}
		
		$this->_view->titulo = 'Inicio de sesi&oacute;n';
		$this->_view->navegacion = '';
		
        if ($this->getInt('enviar') == 1) {
            //Se obtiene los datos  por  post
            $this->_view->datos = $_POST;
            //Se valida que en el campo haya un dato y un alfanúmerico
            if (!$this->getAlphaNum('usuario')) {
                //Si no cumple la validacion sale mensaje de error
                $this->_view->_error = 'Debe introducir su usuario';
                //Vista de la pagina actual
                $this->_view->renderizar('login','login');
                //Saca de la funcion principal
                exit;
            }
            //Se valida el dato
            if (!$this->getSql('pass')) {
                //Si no cumple la validacion sale mensaje de error
                $this->_view->_error = 'Debe introducir su contrase&ntilde;a';
                //Vista de la pagina actual
                $this->_view->renderizar('login','login');
                //Saca de la funcion principal
                exit;
            }

            //Si pasa todas las validaciones se trae el usuario
            $row = $this->_login->getUsuario(
                    $this->getAlphaNum('usuario'), 
                    $this->getSql('pass')
            );
            //Si no cumple con la validación
            if (!$row) {	
                //Sale mensaje de error
                $this->_view->_error = 'Usuario y/o contrase&ntilde;a incorrectos';
                //Se renderiza a el login
                $this->_view->renderizar('login','login');
                //Saca de la funcion principal				
                exit;
            }
            
            if ($row->estado_usuario==0){
                //Sale mensaje de error
                $this->_view->_error = 'Este usuario se encuentra inactivo';
                //Se renderiza a el login
                $this->_view->renderizar('login','login');
                //Saca de la funcion principal
                exit;
            }

            if ($row->estado_afiliado==0){
                //Sale mensaje de error
                $this->_view->_error = 'El Asociado se encuentra inactivo';
                //Se renderiza a el login
                $this->_view->renderizar('login','login');
                //Saca de la funcion principal
                exit;
            }

            $bitacora_inicio = $this->_login->bitacora_login(
                    $row->id_usuario
            );						
            //Se crean variables de sesión
            Session::set('autenticado_paginwebacemcop', true);
            //tipo de usuario
            Session::set('tipo_usuario', $row->tipo_usuario);
			//nombre completo del afiliado
			Session::set('nombre_usuario', $row->nombres." ".$row->apellidos);
			//usuario del afiliado
			Session::set('usuario', $row->usuario);
			// id del usuario
			Session::set('id_usuario', $row->id_usuario);
			// id del afiliado
			Session::set('id_afiliado', $row->id_afiliado);
			
			if(isset($modulo) && $modulo != ""){
				$this->redireccionar($modulo);	
			}else{
				$this->redireccionar('micuenta');	
			}
		}
		
		$this->_view->renderizar('login','login');   				    
	}
	

    //Función para cerrar la sesión
    public function cerrar() {
		
	   $bitacora_inicio_cerrar = $this->_login->bitacora_login_cerrar(
			Session::Get('id_usuario')
		);	
        //Se destruyen todas las variables de sesión
        Session::destroy();
        //Se redirecciona a otra página
        $this->redireccionar('principal/principal');
    }
		
}

?>
