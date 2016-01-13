<?php

//Clase extendida de la clase controller
class panelController extends Controller {
	//listado
	public function index() {
		if (Session::Get('autenticado_adminsciocco') == true ){ 
        	Session::set('modulo', "admin");
			$this->_view->titulo = 'Panel Administrativo';
			$this->_view->navegacion = '';
			$this->_view->renderizar('index', "panel");
      	} else {
      		$this->redireccionar('admin');
      	}
		
	}		
}

?>
