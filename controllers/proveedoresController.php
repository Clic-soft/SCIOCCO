<?php

//Clase extendida de la clase controller
class proveedoresController extends Controller {

	private $_proveedores;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_proveedores = $this->loadModel('proveedores');
    }

	public function index() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'PROVEEDORES';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->proveedor = $paginador->paginar($this->_proveedores->getProveedores(),1,10);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('proveedores'));

			$this->_view->renderizar('index', "proveedores");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicaproveedores() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->proveedor = $paginador->paginar($this->_proveedores->getProveedores(), $pagina,10);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('proveedores'));
        	$this->_view->renderizar('refrescar_listado_proveedor', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function crear_proveedor() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nuevo Proveedor';
			$this->_view->navegacion = '';

			$this->_view->tdoc = $this->_proveedores->gettipo_doc();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('id_tipo_doc') || $this->getInt('id_tipo_doc')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedor','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('num_doc')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedor','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('razon_social')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la razon social';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedor','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('rep_comercial')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el representate comercial';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedor','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('contacto')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el dato de contacto del proveedor';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedor','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('num_contacto')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de contacto';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedor','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('direccion')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la dirrecion donde se ubica el proveedor';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedor','proveedores');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('email')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el email de contacto';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedor','proveedores');
					//Saca de la funcion principal
					exit;
				}


				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_proveedores->validarproveedor($this->getTexto('num_doc'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El numero de identificacion ya existe';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_proveedor','proveedores');
					//Saca de la funcion principal
					exit;
				}	

				
				$this->_proveedores->crear_proveedor($this->getInt('id_tipo_doc'),
					$this->getTexto('num_doc'),
					$this->getSql('razon_social'),
					$this->getTexto('rep_comercial'),
					$this->getTexto('contacto'),
					$this->getTexto('num_contacto'),
					$this->getSql('direccion'),
					$this->getTexto('email'));

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_proveedor', "proveedores");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_proveedor($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','proveedores');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_proveedores->getProveedor($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','proveedores');
	        }
				
			$this->_view->tdoc = $this->_proveedores->gettipo_doc();
			$this->_view->datos = $this->_proveedores->getProveedor($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getInt('id_tipo_doc') || $this->getInt('id_tipo_doc')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedor',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('num_doc')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de documento';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedor',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('razon_social')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la razon social';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedor',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('rep_comercial')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el representate comercial';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedor',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('contacto')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el dato de contacto del proveedor';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedor',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('num_contacto')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el numero de contacto';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedor',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getSql('direccion')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la dirrecion donde se ubica el proveedor';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedor',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('email')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el email de contacto';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedor',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('estado') || $this->getInt('estado')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el estado del proveedor';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedor',false,true);
					//Saca de la funcion principal
					exit;
				}


				//Se valida que no exista otro usuario con el mismo nombre
				if ($this->_proveedores->validarproveedoredita($this->getTexto('num_doc'),$this->filtrarInt($id))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'El numero de identificacion ya existe';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_proveedor',false,true);
					//Saca de la funcion principal
					exit;
				}	
					
				$this->_proveedores->editar_proveedor($this->filtrarInt($id),
					$this->getInt('id_tipo_doc'),
					$this->getTexto('num_doc'),
					$this->getSql('razon_social'),
					$this->getTexto('rep_comercial'),
					$this->getTexto('contacto'),
					$this->getTexto('num_contacto'),
					$this->getSql('direccion'),
					$this->getTexto('email'),
					$this->getInt('estado'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_proveedores->getProveedor($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_proveedor',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarproveedor($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','proveedores');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_proveedores->getProveedor($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','proveedores');
	        }

        	$this->_proveedores->eliminar_proveedor($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }
	
}

?>
