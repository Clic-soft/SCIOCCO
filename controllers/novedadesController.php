<?php

//Clase extendida de la clase controller
class novedadesController extends Controller {

	private $_novedades;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_novedades = $this->loadModel('novedades');
    }

	public function index() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'NOVEDADES';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->novedad = $paginador->paginar($this->_novedades->getNovedades(),1,1);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('novedades'));

			$this->_view->renderizar('index', "novedades");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	// paginacion listado
	public function paginacionDinamicanovedades() {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->novedad = $paginador->paginar($this->_novedades->getNovedades(), $pagina,1);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('novedades'));
        	$this->_view->renderizar('refrescar_listado_novedades', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }

    public function nueva_novedad() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'NUEVA NOVEDAD';
			$this->_view->navegacion = '';

			$this->_view->tnovs = $this->_novedades->gettnovs();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('nombre')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre de la novedad';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_novedad','novedades');
					//Saca de la funcion principal
					exit;
				}

				if (!$_POST['descripcion']) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el contenido';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_novedad','novedades');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('tnov') || $this->getInt('tnov')== 0 || $this->getInt('tnov')== "") {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de novedad';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_novedad','novedades');
					//Saca de la funcion principal
					exit;
				}
				
				$this->_novedades->crear_novedad($this->getTexto('nombre'),$_POST['descripcion'],
					$this->getInt('tnov'));
				
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nueva_novedad', "novedades");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_novedad($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','novedades');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_novedades->getNovedad($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','novedades');
	        }
				
			$this->_view->tnovs = $this->_novedades->gettnovs();
			$this->_view->datos = $this->_novedades->getNovedad($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
				
				if (!$this->getTexto('nombre')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el nombre de la novedad';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_novedad',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$_POST['descripcion']) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el contenido';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_novedad',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('tnov') || $this->getInt('tnov')== 0 || $this->getInt('tnov')== "") {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el tipo de novedad';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_novedad',false,true);
					//Saca de la funcion principal
					exit;
				}

					
					$this->_novedades->editar_novedad($this->filtrarInt($id),
						$this->getTexto('nombre'),
						$_POST['descripcion'],
						$this->getInt('tnov'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_novedades->getNovedad($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_novedad',false,true);

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
	            $this->redireccionar('index','novedades');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_novedades->getNovedad($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','novedades');
	        }
				

			/* VALIDACION */
			if ($this->getInt('guardar') == 1) {
				if ($_FILES['archivo']['name'] != "") {
					//Ruta donde se va a guardar el archivo
					$ruta = 'views/novedades/fotos' . DS . 'grande' . DS;
					$ruta1 = 'views/novedades/fotos' . DS;
	
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
						$upload->image_x = 193;
						$upload->image_y = 167;
						$upload->process($ruta1);

						$this->_novedades->foto_novedad($this->filtrarInt($id),	$nombre, "jpg");				
						
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
	            $this->redireccionar('index','novedades');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_novedades->getNovedad($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','novedades');
	        }
		
	        $foto = $this->_novedades->getNovedad($this->filtrarInt($id));

		//IMAGEN PEQUEÑA
        if (file_exists("views/novedades/fotos/" . $foto->archivo. ".jpg")):
            unlink('views/novedades/fotos/' . $foto->archivo . ".jpg");
        endif;
		
		//IMAGEN GRANDE
        if (file_exists("views/novedades/fotos/grande/" . $foto->archivo . ".jpg")):
            unlink('views/novedades/fotos/grande/' . $foto->archivo . ".jpg");
        	$this->_novedades->foto_novedad($this->filtrarInt($id),	" " , " ");
        endif;

        } else {
      		$this->redireccionar('admin');
      	}
    }


    // paginacion listado
	public function ver_novedad($id) {
        
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'NOVEDAD';

			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','novedades');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_novedades->getNovedad($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','novedades');
	        }

			
			$this->_view->novedad = $this->_novedades->getNovedad($this->filtrarInt($id));

        	$this->_view->renderizar('ver_novedad', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
		
    }



    public function eliminarusuario($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','usuarios');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_usuarios->getUsuario($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','usuarios');
	        }

        	$this->_usuarios->eliminar_usuario($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }
	
}

?>
