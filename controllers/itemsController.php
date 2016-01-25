<?php

//Clase extendida de la clase controller
class itemsController extends Controller {

	private $_items;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_items = $this->loadModel('items');
    }

	//listado
	public function index() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'MENU ITEMS';
			$this->_view->navegacion = '';
			$this->_view->renderizar('index', "items");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function categorias() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'CATEGORIAS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->categoria = $paginador->paginar($this->_items->getCategorias(),1,10);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('categorias'));

			$this->_view->renderizar('categorias', "items");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function paginaciondinamicacategorias() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->categoria = $paginador->paginar($this->_items->getCategorias(), $pagina,10);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('categorias'));
        	$this->_view->renderizar('refrescar_listado_categorias', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
	}

	 public function crear_categoria() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nueva Categoria';
			$this->_view->navegacion = '';

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('categoria')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la categoria';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_categoria','items');
					//Saca de la funcion principal
					exit;
				}

				
				$this->_items->nueva_categoria($this->getTexto('categoria'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nueva_categoria', "items");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_categoria($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('categorias','items');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_items->getCategoria($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('categorias','items');
	        }
			
			 $this->_view->datos = $this->_items->getCategoria($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
					if (!$this->getTexto('categoria')) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la categoria';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_categoria',false,true);
						//Saca de la funcion principal
						exit;
					}

					if (!$this->getInt('estado') || $this->getInt('estado')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar el estado de la categoria';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_categoria',false,true);
						//Saca de la funcion principal
						exit;
					}
					
					$this->_items->editar_categoria($this->filtrarInt($id),
					$this->getTexto('categoria'),
					$this->getInt('estado'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_items->getCategoria($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_categoria',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarcategoria($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('categorias','items');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_items->getCategoria($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('categorias','items');
	        }

        	$this->_items->eliminar_categoria($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }

    public function subcategorias() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'SUBCATEGORIAS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->subcategoria = $paginador->paginar($this->_items->getsubCategorias(),1,10);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('subcategorias'));

			$this->_view->renderizar('subcategorias', "items");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function paginaciondinamicasubcategorias() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->subcategoria = $paginador->paginar($this->_items->getsubCategorias(), $pagina,10);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('subcategorias'));
        	$this->_view->renderizar('refrescar_listado_subcategorias', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
	}

	 public function crear_subcategoria() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nueva Categoria';
			$this->_view->navegacion = '';


			$this->_view->categoria = $this->_items->getCategoriasestado();

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('nombre_subcategoria')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la sub categoria';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_subcategoria','items');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('id_categoria') || $this->getInt('id_categoria')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la categoria';
						//Vista de la pagina actual
						$this->_view->renderizar('nueva_subcategoria','items');
						//Saca de la funcion principal
						exit;
					}

				
				$this->_items->nueva_subcategoria($this->getTexto('nombre_subcategoria'),$this->getInt('id_categoria'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nueva_subcategoria', "items");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_subcategoria($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('subcategorias','items');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_items->getsubCategoria($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('subcategorias','items');
	        }
			
			 $this->_view->categoria = $this->_items->getCategoriasestado();
			 $this->_view->datos = $this->_items->getsubCategoria($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
					if (!$this->getTexto('nombre_subcategoria')) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la sub categoria';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_subcategoria',false,true);
						//Saca de la funcion principal
						exit;
					}

					if (!$this->getInt('id_categoria') || $this->getInt('id_categoria')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la categoria';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_subcategoria',false,true);
						//Saca de la funcion principal
						exit;
					}

					if (!$this->getInt('estado') || $this->getInt('estado')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar el estado de la categoria';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_subcategoria',false,true);
						//Saca de la funcion principal
						exit;
					}
					
					$this->_items->editar_subcategoria($this->filtrarInt($id),
					$this->getTexto('nombre_subcategoria'),
					$this->getInt('id_categoria'),
					$this->getInt('estado'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_items->getsubCategoria($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_subcategoria',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarsubcategoria($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('subcategorias','items');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_items->getsubCategoria($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('subcategorias','items');
	        }

        	$this->_items->eliminar_subcategoria($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }

    public function tallas() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'SUBCATEGORIAS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->tallas = $paginador->paginar($this->_items->gettallas(),1,10);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('tallas'));

			$this->_view->renderizar('tallas', "items");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function paginaciondinamicatallas() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->tallas = $paginador->paginar($this->_items->gettallas(), $pagina,10);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('tallas'));
        	$this->_view->renderizar('refrescar_listado_tallas', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
	}

	 public function crear_talla() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'Nueva Talla';
			$this->_view->navegacion = '';

			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getTexto('talla')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la talla';
					//Vista de la pagina actual
					$this->_view->renderizar('nueva_talla','items');
					//Saca de la funcion principal
					exit;
				}
				
				$this->_items->nueva_talla($this->getTexto('talla'));
				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nueva_talla', "items");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_talla($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('tallas','items');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_items->gettalla($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('tallas','items');
	        }
			
			 $this->_view->datos = $this->_items->gettalla($this->filtrarInt($id));
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
					if (!$this->getTexto('talla')) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la talla';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_talla',false,true);
						//Saca de la funcion principal
						exit;
					}
					
					$this->_items->editar_talla($this->filtrarInt($id),
					$this->getTexto('talla'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_items->gettalla($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_talla',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminartalla($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('tallas','items');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_items->gettalla($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('tallas','items');
	        }

        	$this->_items->eliminar_talla($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }

    public function productos() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'PRODUCTOS';
			$this->_view->navegacion = '';

				//Se instancia la libreria
			$paginador = new Paginador();
		
			$this->_view->producto = $paginador->paginar($this->_items->getProductos(),1,10);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
			$this->_view->setJs(array('productos','combosubcategoria','foto_producto'));

			$this->_view->renderizar('productos', "items");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function paginaciondinamicaproductos() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	$pagina = $this->getInt('pagina');
				
        	$paginador = new Paginador();
        	$this->_view->producto = $paginador->paginar($this->_items->getProductos(), $pagina,10);
        	$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
        	$this->_view->setJs(array('productos','combosubcategoria','foto_producto'));
        	$this->_view->renderizar('refrescar_listado_productos', false, true);
        } else {
      		$this->redireccionar('admin');
      	}
	}
	
	public function crear_producto() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->setJs(array('combosubcategoria'));
			$this->_view->titulo = 'Nueva Producto';
			$this->_view->navegacion = '';


			$this->_view->categoria = $this->_items->getCategoriasestado();
			$this->_view->subcategoria = $this->_items->getsubCategoriasestado();
			$this->_view->marca = $this->_items->getmarcas();
			$this->_view->talla = $this->_items->gettallas();
			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan

				if (!$this->getInt('id_marca') || $this->getInt('id_marca')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la marca';
						//Vista de la pagina actual
						$this->_view->renderizar('nuevo_producto','items');
						//Saca de la funcion principal
						exit;
					}

				if (!$this->getInt('id_categoria') || $this->getInt('id_categoria')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la categoria';
						//Vista de la pagina actual
						$this->_view->renderizar('nuevo_producto','items');
						//Saca de la funcion principal
						exit;
					}
					
				if (!$this->getInt('id_subcategoria') || $this->getInt('id_subcategoria')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la sub categoria';
						//Vista de la pagina actual
						$this->_view->renderizar('nuevo_producto','items');
						//Saca de la funcion principal
						exit;
					}
					
					if (!$this->getInt('id_talla') || $this->getInt('id_talla')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la talla';
						//Vista de la pagina actual
						$this->_view->renderizar('nuevo_producto','items');
						//Saca de la funcion principal
						exit;
					}		

				if (!$this->getSql('referencia')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la referencia';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_producto','items');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('color')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el color';
					//Vista de la pagina actual
					$this->_view->renderizar('nuevo_producto','items');
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('precio') || $this->getInt('precio')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar el precio';
						//Vista de la pagina actual
						$this->_view->renderizar('nuevo_producto','items');
						//Saca de la funcion principal
						exit;
					}	
				
				$this->_items->nuevo_producto($this->getInt('id_marca'),
					$this->getInt('id_categoria'),
					$this->getInt('id_subcategoria'),
					$this->getInt('talla'),
					$this->getSql('referencia'),
					$this->getTexto('color'),
					$this->getInt('precio'));

				$this->_view->_mensaje = 'Datos Creados Correctamente';
			}

			$this->_view->renderizar('nuevo_producto', "items");
		} else {
      		$this->redireccionar('admin');
      	}
	}

	public function editar_producto($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('tallas','items');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_items->gettalla($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('tallas','items');
	        }
			
			 $this->_view->datos = $this->_items->getproducto($this->filtrarInt($id));
			 $this->_view->categoria = $this->_items->getCategoriasestado();
			$this->_view->subcategoria = $this->_items->getsubCategoriasestado();
			$this->_view->marca = $this->_items->getmarcas();
			$this->_view->talla = $this->_items->gettallas();
			 /* VALIDACION */
				if ($this->getInt('guardar') == 1) {
					
					$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
				//Se valida que las dos contraseñas digitadas coincidan
					if (!$this->getInt('id_marca') || $this->getInt('id_marca')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la marca';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_producto',false,true);
						//Saca de la funcion principal
						exit;
					}

				if (!$this->getInt('id_categoria') || $this->getInt('id_categoria')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la categoria';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_producto',false,true);
						//Saca de la funcion principal
						exit;
					}
					
				if (!$this->getInt('id_subcategoria') || $this->getInt('id_subcategoria')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la sub categoria';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_producto',false,true);
						//Saca de la funcion principal
						exit;
					}
					
					if (!$this->getInt('id_talla') || $this->getInt('id_talla')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la talla';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_producto',false,true);
						//Saca de la funcion principal
						exit;
					}		

				if (!$this->getSql('referencia')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar la referencia';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_producto',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getTexto('color')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar el color';
					//Vista de la pagina actual
					$this->_view->renderizar('editar_producto',false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('precio') || $this->getInt('precio')== 0) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar el precio';
						//Vista de la pagina actual
						$this->_view->renderizar('editar_producto',false,true);
						//Saca de la funcion principal
						exit;
					}
					
					$this->_items->editar_producto($this->filtrarInt($id),
					$this->getInt('id_marca'),
					$this->getInt('id_categoria'),
					$this->getInt('id_subcategoria'),
					$this->getInt('talla'),
					$this->getSql('referencia'),
					$this->getTexto('color'),
					$this->getInt('precio'));
				
				$this->_view->_mensaje = 'Datos Actualizados Correctamente';
				}		
			 	
				$this->_view->datos = $this->_items->getproducto($this->filtrarInt($id));
				
			 $this->_view->renderizar('editar_producto',false,true);

		} else {
      		$this->redireccionar('admin');
      	}
    }

    public function eliminarproducto($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
	        //Si el id no es un nro entero
	        if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('tallas','items');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_items->getproducto($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('tallas','items');
	        }

        	$this->_items->eliminar_producto($this->filtrarInt($id));
        } else {
      		$this->redireccionar('admin');
      	}
    }




    public function getsubCategoriascombo() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
        	
        	$id_categoria = $_POST['id_categoria'];
			$subcategoria = $this->_items->getsubCategoriascombo($this->filtrarInt($id_categoria));
			echo $subcategoria;	
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
	            $this->redireccionar('index','items');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_items->getproducto($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','items');
	        }
				

			/* VALIDACION */
			if ($this->getInt('guardar') == 1) {
				if ($_FILES['archivo']['name'] != "") {
					//Ruta donde se va a guardar el archivo
					$ruta = 'views/items/fotos' . DS . 'grande' . DS;
					$ruta1 = 'views/items/fotos' . DS;
	
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
					$upload->image_x = 300;
					$upload->image_y = 250;
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
						$upload->image_x = 150;
						$upload->image_y = 125;
						$upload->process($ruta1);

						$this->_items->foto_item_nueva($this->filtrarInt($id),	$nombre, "jpg");				
						
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
    public function eliminarFotoproducto($id) {
    	echo $id;
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
		
			if (!$this->filtrarInt($id)) {
	            //Se redirecciona al index
	            $this->redireccionar('index','items');
	        }
	        //Si no existe un registro con ese id
	        if (!$this->_items->getfotoproducto($this->filtrarInt($id))) {
	            //Se redirecciona al index
	            $this->redireccionar('index','items');
	        }
		
	        $foto = $this->_items->getfotoproducto($this->filtrarInt($id));

		//IMAGEN PEQUEÑA
        if (file_exists("views/items/fotos/" . $foto->archivo. ".jpg")):
            unlink('views/items/fotos/' . $foto->archivo . ".jpg");
        endif;
		
		//IMAGEN GRANDE
        if (file_exists("views/items/fotos/grande/" . $foto->archivo . ".jpg")):
            unlink('views/items/fotos/grande/' . $foto->archivo . ".jpg");
        	$this->_items->foto_item_eliminar($this->filtrarInt($id));
        endif;

        } else {
      		$this->redireccionar('admin');
      	}
    }
    
    public function listado_img_producto($id) {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
			Session::set('modulo', "admin");
			$this->_view->titulo = 'LISTADO IMAGENES PRODUCTOS';
			$this->_view->navegacion = '';

			
		
			$this->_view->imagenes = $this->_items->getimg_productos($this->filtrarInt($id));
			$this->_view->id= $this->filtrarInt($id);
			$this->_view->setJs(array('foto_producto'));
			$this->_view->renderizar('listado_img_producto',false,true);
		} else {
      		$this->redireccionar('admin');
      	}
	}

}

?>
