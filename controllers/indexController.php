<?php

class indexController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        //Si el usuario esta autenticado
        if (Session::get('autenticado_cemcop')) {

            $this->_view->titulo = 'Empresa';
			
            $this->_view->renderizar('index', 'inicio');
			
        } else {
            $this->redireccionar('principal');
        }
    }

}

?>