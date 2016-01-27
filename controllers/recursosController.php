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

				if (!$this->getTexto('nombre')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_banner','recursos');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('tipo') || $this->getInt('tipo')== 0 || $this->getInt('tipo')== "") {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de imagen';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_banner','recursos');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('tipo_apertura') || $this->getTexto('tipo_apertura')== "") {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de apertura';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_banner','recursos');
					//Saca de la funcion principal
					exit;
				}


				if (!$this->getTexto('url')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la url';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_banner','recursos');
					//Saca de la funcion principal
					exit;
				}

				
				$this->_recursos->nuevo_banner($this->getTexto('nombre'),
				$this->getInt('tipo'),
				$this->getTexto('tipo_apertura'),
				$this->getTexto('url'));
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
					if (!$this->getTexto('nombre')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_banner',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('tipo') || $this->getInt('tipo')== 0 || $this->getInt('tipo')== "") {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de imagen';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_banner',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('tipo_apertura') || $this->getTexto('tipo_apertura')== "") {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de apertura';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_banner',false,true);
					//Saca de la funcion principal
					exit;
				}


				if (!$this->getTexto('url')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la url';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_banner',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('estado')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el estado del tipo de novedad';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_banner',false,true);
					//Saca de la funcion principal
					exit;
				}
					
					$this->_recursos->editar_banner($this->filtrarInt($id),
					$this->getTexto('nombre'),
					$this->getInt('tipo'),
					$this->getTexto('tipo_apertura'),
					$this->getTexto('url'),
					$this->getInt('estado'));
				
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

    //CAMBIAR FOTO DEL ASOCIADO
	public function subir_foto($id) {
	
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
				

			/* VALIDACION */
			if ($this->getInt('guardar') == 1) {
				if ($_FILES['archivo']['name'] != "") {
					//Ruta donde se va a guardar el archivo
					$ruta = 'views/recursos/fotos' . DS . 'grande' . DS;
					$ruta1 = 'views/recursos/fotos' . DS;
	
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
					$upload->image_x = 800;
					$upload->image_y = 600;
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
						$upload->image_x = 400;
						$upload->image_y = 320;
						$upload->process($ruta1);

						$this->_recursos->foto_banner($this->filtrarInt($id),	$nombre, "jpg");				
						
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
	            $this->redireccionar('banners','recurso');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_recursos->getbanner($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('banners','recursos');
	        }
		
	        $foto = $this->_recursos->getbanner($this->filtrarInt($id));

		//IMAGEN PEQUEÑA
        if (file_exists("views/recursos/fotos/" . $foto->archivo. ".jpg")):
            unlink('views/recursos/fotos/' . $foto->archivo . ".jpg");
        endif;
		
		//IMAGEN GRANDE
        if (file_exists("views/recursos/fotos/grande/" . $foto->archivo . ".jpg")):
            unlink('views/recursos/fotos/grande/' . $foto->archivo . ".jpg");
        	$this->_recursos->foto_banner($this->filtrarInt($id),	" " , " ");
        endif;

        } else {
      		$this->redireccionar('admin');
      	}
    }


    // paginacion listado
	public function ver_banner($id) {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'NOVEDAD';

			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','novedades');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_recursos->getbanner($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('banners','recursos');
	        }

			
			$this->_view->banner = $this->_recursos->getbanner($this->filtrarInt($id));

        	$this->_view->renderizar('ver_banner', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }
	
}

?>
