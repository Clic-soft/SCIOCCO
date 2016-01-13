<?php

//Clase extendida de la clase controller
class politicasController extends Controller {

    private $_politica;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_politica = $this->loadModel('politicas');
    }

	//listado
	public function index() {
			
			$this->_view->titulo = 'Avisos y politicas legales';	
			$this->_view->fogacoop = $this->_politica->getAviso(1);
			$this->_view->politicas = $this->_politica->getAviso(2);
			$this->_view->proteccion = $this->_politica->getAviso(3);
			$this->_view->lavado = $this->_politica->getAviso(4);
			$this->_view->supersolidaria = $this->_politica->getAviso(5); 
			$this->_view->servicio = $this->_politica->getAviso(6);  
			
			$this->_view->renderizar('index', "politicas");
				    
	}
	

}

?>
