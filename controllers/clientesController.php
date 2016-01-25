<?php

//Clase extendida de la clase controller
class clientesController extends Controller {

	private $_clientes;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_clientes = $this->loadModel('clientes');
    }

	public function index() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'CLIENTES';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->cliente = $paginador->paginar($this->_clientes->getClientes(),1,1);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('clientes'));

			$this->_view->renderizar('index', "clientes");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicaclientes() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->cliente = $paginador->paginar($this->_clientes->getClientes(), $pagina,1);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('clientes'));
        	$this->_view->renderizar('refrescar_listado_clientes', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    // paginacion listado
	public function ver_cliente($id) {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'CLIENTE';

			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','clientes');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_clientes->getCliente($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','clientes');
	        }

			
			$this->_view->cliente = $this->_clientes->getCliente($this->filtrarInt($id));

        	$this->_view->renderizar('ver_cliente', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nuevo_cliente() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Cliente';
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

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_usuarios->validarusuario($this->getTexto('usuario'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El nombre de usuario ya existe';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_usuario','usuarios');
					//Saca de la funcion principal
					exit;
				}	

				
				$this->_clientes->crear_cliente($this->getTexto('usuario'),$this->getSql('pass'),$this->getInt('id_rol'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_usuario', "usuarios");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_cliente($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','clientes');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_clientes->getCliente($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','clientes');
	        }

				
			$this->_view->roles = $this->_clientes->getUsuario();
			$this->_view->datos = $this->_clientes->getCliente($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getTexto('usuario')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el rol';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_usuario',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('id_rol') || $this->getInt('id_rol')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el rol';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_usuario',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('estado')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el estado del tipo de novedad';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_usuario',false,true);
					//Saca de la funcion principal
					exit;
				}

				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_usuarios->validarusuarioedita($this->getTexto('usuario'),$this->filtrarInt($id))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El nombre de usuario ya existe';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_usuario',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_clientes->editar_cliente($this->filtrarInt($id),
						$this->getTexto('usuario'),
						$this->getInt('id_rol'),
						$this->getInt('estado'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_clientes->getCliente($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_usuario',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarcliente($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','clientes');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_clientes->getCliente($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','clientes');
	        }

        	$this->_clientes->eliminar_cliente($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }
	
}

?>
