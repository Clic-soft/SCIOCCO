<?php

//Clase extendida de la clase controller
class marcasController extends Controller {

	private $_marcas;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_marcas = $this->loadModel('marcas');
    }

	public function index() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'MARCAS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->marca = $paginador->paginar($this->_marcas->getMarcas(),1,10);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('marcas'));

			$this->_view->renderizar('index', "marcas");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicamarcas() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->marca = $paginador->paginar($this->_marcas->getMarcas(), $pagina,10);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('marcas'));
        	$this->_view->renderizar('refrescar_listado_marcas', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function crear_marca() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nueva Marca';
			$this->_view->navegacion = '';

			$this->_view->proveedor = $this->_marcas->getProveedor();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('id_proveedor') || $this->getInt('id_proveedor')== 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el proveedor';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_marca','marcas');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('marca')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre de la marca';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_marca','marcas');
					//Saca de la funcion principal
					exit;
				}
				
				$this->_marcas->crear_marca($this->getInt('id_proveedor'),
					$this->getTexto('marca'));

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nueva_marca', "marcas");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_marca($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','marcas');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_marcas->getMarca($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','marcas');
	        }
				
			$this->_view->proveedor = $this->_marcas->getProveedor();
			$this->_view->datos = $this->_marcas->getMarca($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
					if (!$this->getInt('id_proveedor') || $this->getInt('id_proveedor')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar de la marca';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_marca',false,true);
						//Saca de la funcion principal
						exit;
					}

					if (!$this->getTexto('marca')) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar el nombre de la marca';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_marca',false,true);
						//Saca de la funcion principal
						exit;
					}

					if (!$this->getInt('estado') || $this->getInt('estado')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar el estado del proveedor';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_marca',false,true);
						//Saca de la funcion principal
						exit;
					}
					
					$this->_marcas->editar_marca($this->filtrarInt($id),
						$this->getInt('id_proveedor'),
						$this->getTexto('marca'),
						$this->getInt('estado'));
					
					$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_marcas->getMarca($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_marca',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarmarca($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','marcas');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_marcas->getMarca($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','marcas');
	        }

        	$this->_marcas->eliminar_marca($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }


	public function subir_foto($id) {
	
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','marcas');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_marcas->getMarca($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','marcas');
	        }
				

			/* VALIDACION */
			if ($this->getInt('guardar') == 1) {
				if ($_FILES['archivo']['name'] != "") {
					//Ruta donde se va a guardar el archivo
					$ruta = 'views/marcas/fotos' . DS . 'grande' . DS;
					$ruta1 = 'views/marcas/fotos' . DS;
	
					// echo $ruta; exit;
					//Se instancia la libreria
					$upload = new upload($_FILES['archivo'], 'es_Es');
	
					/* Extensiones permitidas */
					$upload->allowed = array('image/jpeg','image/png');

					$nombre = Hash::getHash('sha1', $_FILES['archivo']['name'], HASH_KEY);
					/* Renombrando */
					$upload->file_new_name_body = $nombre;	
					/* extencion */
					$upload->file_new_name_ext = 'jpg';
					//Se evita que se auto-renombre
					$upload->file_auto_rename = false;
					//Se sobrescribe el archivo
					$upload->file_overwrite = true;
					//habilita redimesion de imagenes
					$upload->image_resize = true;
					//Crop de la imagen
					$upload->image_ratio = true;
					$upload->image_x = 400;
					$upload->image_y = 225;
					/* Se llama metodo para indicar ruta donde se guarda el archivo */
					$upload->process($ruta);
	
					/* Se verifica si ha sido exitoso */
					if ($upload->processed) {
						/* Extensiones permitidas */
						$upload->allowed = array('image/jpeg','image/png');
						/* Renombrando */
						$nombre = Hash::getHash('sha1', $_FILES['archivo']['name'], HASH_KEY);
						/* Renombrando */
						$upload->file_new_name_body = $nombre;	
						/* extencion */
						$upload->file_new_name_ext = 'jpg';
						//Se evita que se auto-renombre
						$upload->file_auto_rename = false;
						//Se sobrescribe el archivo
						$upload->file_overwrite = true;
						//habilita redimesion de imagenes
						$upload->image_resize = true;
						//Crop de la imagen
						$upload->image_ratio = false;
						$upload->image_x = 200;
						$upload->image_y = 187;
						$upload->process($ruta1);

						$this->_marcas->foto_marca($this->filtrarInt($id),	$nombre, "jpg");				
						
					} else {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = $upload->error;
						//Vista de la pagina actual
						$this->_view->renderizar('foto', false, true);
						//Saca de la funcion principal
						exit;
					}
					
					$this->_view->_mensaje = 'Foto subida Correctamente';
				}

			}
			
			//Se renderiza a la pagina actual
			$this->_view->renderizar('foto',false,true);
		} else {
      		$this->redireccionar('admin');
      	}	
	}

	//ELIMINAR FOTO
    public function eliminarFoto($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','marcas');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_marcas->getMarca($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','marcas');
	        }
		
	        $foto = $this->_marcas->getMarca($this->filtrarInt($id));

		//IMAGEN PEQUEÑA
        if (file_exists("views/marcas/fotos/" . $foto->archivo. ".jpg")):
            unlink('views/marcas/fotos/' . $foto->archivo . ".jpg");
        endif;
		
		//IMAGEN GRANDE
        if (file_exists("views/marcas/fotos/grande/" . $foto->archivo . ".jpg")):
            unlink('views/marcas/fotos/grande/' . $foto->archivo . ".jpg");
        	$this->_marcas->foto_marca($this->filtrarInt($id),	" " , " ");
        endif;

        } else {
      		$this->redireccionar('admin');
      	}
    }

    // paginacion listado
	public function ver_marca($id) {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'NOVEDAD';

			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','marcas');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_marcas->getMarca($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','marcas');
	        }

			
			$this->_view->marca = $this->_marcas->getMarca($this->filtrarInt($id));

        	$this->_view->renderizar('ver_marca', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }
	
}

?>
